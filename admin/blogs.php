<?php
/**
 * BusinessDoctor Executive Admin — Blog & Technical Perspectives Management (CMS)
 * Author, edit, schedule, and optimize engineering perspectives and digital marketing insights.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

// Handle Actions (Publish / Unpublish / Toggle Featured / Soft-Delete / Restore)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'Security session expired. Please retry.');
        header('Location: blogs.php');
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    $action = $_POST['action'];

    if ($id > 0) {
        if ($action === 'toggle_publish') {
            $stmt = $pdo->prepare("SELECT status FROM insights WHERE id = ?");
            $stmt->execute([$id]);
            $currentStatus = $stmt->fetchColumn();
            $newStatus = ($currentStatus === 'published') ? 'draft' : 'published';
            $isPub = ($newStatus === 'published') ? 1 : 0;
            $pubAt = ($newStatus === 'published') ? date('Y-m-d H:i:s') : null;

            $update = $pdo->prepare("UPDATE insights SET status = ?, is_published = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $update->execute([$newStatus, $isPub, $id]);

            setFlashMessage('success', "Blog post status changed to {$newStatus}.");
        } elseif ($action === 'toggle_featured') {
            $stmt = $pdo->prepare("SELECT is_featured FROM insights WHERE id = ?");
            $stmt->execute([$id]);
            $isFeatured = (int)$stmt->fetchColumn();
            $newVal = $isFeatured ? 0 : 1;

            $update = $pdo->prepare("UPDATE insights SET is_featured = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $update->execute([$newVal, $id]);

            setFlashMessage('success', $newVal ? "Article marked as featured." : "Article unfeatured.");
        } elseif ($action === 'soft_delete') {
            $update = $pdo->prepare("UPDATE insights SET is_deleted = 1, deleted_at = CURRENT_TIMESTAMP, status = 'draft', is_published = 0 WHERE id = ?");
            $update->execute([$id]);
            setFlashMessage('success', "Blog post moved to trash (soft-deleted).");
        } elseif ($action === 'restore') {
            $update = $pdo->prepare("UPDATE insights SET is_deleted = 0, deleted_at = NULL WHERE id = ?");
            $update->execute([$id]);
            setFlashMessage('success', "Blog post restored from trash.");
        }
        require_once __DIR__ . '/../includes/seo-sync.php';
        SeoSyncEngine::syncAll("Blog status change ({$action}) ID:{$id}");
    }

    $redirectUrl = 'blogs.php' . (!empty($_GET['trash']) ? '?trash=1' : (!empty($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
    header('Location: ' . $redirectUrl);
    exit;
}

// Filters & Search
$search = trim($_GET['search'] ?? '');
$categoryFilter = trim($_GET['category'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');
$viewTrash = (isset($_GET['trash']) && $_GET['trash'] === '1');

$where = $viewTrash ? ["is_deleted = 1"] : ["is_deleted = 0"];
$params = [];

if ($search !== '') {
    $where[] = "(title LIKE ? OR summary LIKE ? OR author_name LIKE ? OR author LIKE ? OR category LIKE ? OR slug LIKE ?)";
    $like = "%{$search}%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if ($categoryFilter !== '') {
    $where[] = "category = ?";
    $params[] = $categoryFilter;
}

if ($statusFilter !== '' && !$viewTrash) {
    if ($statusFilter === 'featured') {
        $where[] = "is_featured = 1";
    } else {
        $where[] = "status = ?";
        $params[] = $statusFilter;
    }
}

$whereSql = implode(' AND ', $where);

// Get distinct categories for filter dropdown
$categories = $pdo->query("SELECT DISTINCT category FROM insights WHERE is_deleted = 0 AND category IS NOT NULL AND category != '' ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);

// Fetch Blogs
$sql = "SELECT * FROM insights WHERE {$whereSql} ORDER BY is_featured DESC, id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Real-time counts for pill tabs
$totalActive = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0")->fetchColumn();
$totalPublished = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0 AND status = 'published'")->fetchColumn();
$totalDrafts = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0 AND status = 'draft'")->fetchColumn();
$totalFeatured = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0 AND is_featured = 1")->fetchColumn();
$totalTrash = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 1")->fetchColumn();

$pageTitle = $viewTrash ? 'Trash / Deleted Articles' : 'Editorial Workspace &amp; Blog Management';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Content Header Toolbar -->
<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1.25rem;">
  <div>
    <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--adm-font-mono); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--adm-teal); background: rgba(0, 242, 254, 0.08); border: 1px solid rgba(0, 242, 254, 0.2); padding: 0.2rem 0.6rem; border-radius: 4px; margin-bottom: 0.6rem;">
      <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--adm-teal); display: inline-block;"></span>
      <span>EDITORIAL DESK // THOUGHT LEADERSHIP &amp; PERSPECTIVES</span>
    </div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #FFFFFF; margin: 0 0 0.35rem; font-family: var(--adm-font-display); letter-spacing: -0.01em;">
      <?= $viewTrash ? 'Trash / Deleted Articles' : 'Technical Perspectives &amp; Blog Hub' ?>
    </h2>
    <p style="color: var(--adm-text-muted, #94A3B8); font-size: 0.9rem; margin: 0; line-height: 1.5;">
      Author, optimize, schedule, and publish engineering perspectives and digital growth insights for BusinessDoctor.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
    <?php if ($viewTrash): ?>
      <a href="blogs.php" class="btn-adm btn-adm-secondary">
        &larr; Back to Active Articles (<?= $totalActive ?>)
      </a>
    <?php else: ?>
      <a href="../blog" target="_blank" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.65rem 1rem;">
        <span>View Live Blog</span>
        <span style="font-size: 0.9rem;">↗</span>
      </a>
      <a href="blog-create.php" class="btn-adm btn-adm-primary" style="font-weight: 600; padding: 0.65rem 1.15rem; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(6, 181, 249, 0.25);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>+ Create Blog Post</span>
      </a>
    <?php endif; ?>
  </div>
</div>

<!-- Performance HUD / Metric Cards -->
<?php if (!$viewTrash): ?>
  <div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 1.75rem;">
    <!-- Stat 1 -->
    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(6, 181, 249, 0.12); color: var(--adm-teal);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <div>
        <div class="admin-stat-val"><?= $totalActive ?></div>
        <div class="admin-stat-lbl">Total Articles</div>
      </div>
    </div>

    <!-- Stat 2 -->
    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #34D399;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #34D399;"><?= $totalPublished ?></div>
        <div class="admin-stat-lbl">Live On Website</div>
      </div>
    </div>

    <!-- Stat 3 -->
    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(245, 158, 11, 0.15); color: #FBBF24;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #FBBF24;"><?= $totalDrafts ?></div>
        <div class="admin-stat-lbl">Drafts In Progress</div>
      </div>
    </div>

    <!-- Stat 4 -->
    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(99, 102, 241, 0.15); color: #A5B4FC;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #A5B4FC;"><?= count($categories) ?></div>
        <div class="admin-stat-lbl">Active Categories</div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Segmented Filter Tabs Bar -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap; align-items: center;">
  <a href="blogs.php" class="btn-adm <?= (!$viewTrash && $statusFilter === '') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    All (<?= $totalActive ?>)
  </a>
  <a href="blogs.php?status=published" class="btn-adm <?= (!$viewTrash && $statusFilter === 'published') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    Published (<?= $totalPublished ?>)
  </a>
  <a href="blogs.php?status=featured" class="btn-adm <?= (!$viewTrash && $statusFilter === 'featured') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    Featured (<?= $totalFeatured ?>)
  </a>
  <a href="blogs.php?status=draft" class="btn-adm <?= (!$viewTrash && $statusFilter === 'draft') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    Drafts (<?= $totalDrafts ?>)
  </a>
  <?php if ($totalTrash > 0 || $viewTrash): ?>
    <a href="blogs.php?trash=1" class="btn-adm <?= $viewTrash ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="margin-left: auto; <?= $viewTrash ? '' : 'color: #FCA5A5; border-color: rgba(239, 68, 68, 0.35);' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2" style="margin-right: 0.25rem;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
      <span>Trash (<?= $totalTrash ?>)</span>
    </a>
  <?php endif; ?>
</div>

<!-- Filters Toolbar Card -->
<div class="admin-card" style="padding: 1.15rem 1.35rem; margin-bottom: 1.5rem; background: var(--adm-surface); border: 1px solid var(--adm-border);">
  <form method="GET" action="blogs.php" class="admin-toolbar" style="margin: 0; gap: 1rem;">
    <?php if ($viewTrash): ?>
      <input type="hidden" name="trash" value="1">
    <?php endif; ?>
    <?php if ($statusFilter !== ''): ?>
      <input type="hidden" name="status" value="<?= e($statusFilter) ?>">
    <?php endif; ?>

    <div class="admin-toolbar-group" style="flex: 1; min-width: 260px; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
      <div class="adm-search-box" style="flex: 1; min-width: 240px; position: relative;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--adm-text-dim);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search articles by title, author, slug..." class="adm-input" style="padding-left: 36px; width: 100%;">
      </div>

      <select name="category" class="adm-select" style="width: auto; min-width: 190px;">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= e($cat) ?>" <?= $categoryFilter === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.55rem 1rem;">Filter</button>
      
      <?php if ($search !== '' || $categoryFilter !== '' || $statusFilter !== ''): ?>
        <a href="blogs.php<?= $viewTrash ? '?trash=1' : '' ?>" class="btn-adm btn-adm-secondary" style="color: var(--adm-text-dim); padding: 0.55rem 0.85rem;">Reset</a>
      <?php endif; ?>
    </div>

    <div style="font-size: 0.78rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono); background: rgba(255,255,255,0.03); border: 1px solid var(--adm-border-subtle); padding: 0.4rem 0.75rem; border-radius: 4px; white-space: nowrap;">
      Showing <?= count($blogs) ?> <?= count($blogs) === 1 ? 'article' : 'articles' ?>
    </div>
  </form>
</div>

<!-- Blogs Table -->
<div class="admin-card" style="padding: 0; overflow: hidden; border: 1px solid var(--adm-border); background: var(--adm-surface);">
  <?php if (empty($blogs)): ?>
    <div style="text-align: center; padding: 4rem 1.5rem;">
      <div style="width: 56px; height: 56px; margin: 0 auto 1.25rem; border-radius: 50%; background: rgba(6, 181, 249, 0.1); border: 1px solid rgba(6, 181, 249, 0.25); display: flex; align-items: center; justify-content: center; color: var(--adm-teal);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="28" height="28" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
      </div>
      <h3 style="color: #ffffff; margin-bottom: 0.5rem; font-family: var(--adm-font-display); font-size: 1.2rem;">No blog articles found</h3>
      <p style="color: var(--adm-text-muted); margin-bottom: 1.5rem; max-width: 440px; margin-left: auto; margin-right: auto; font-size: 0.88rem; line-height: 1.55;">
        <?= $viewTrash ? 'Trash is currently empty.' : 'Try adjusting your search criteria, clearing the category filter, or launch the editor to author a new post.' ?>
      </p>
      <?php if (!$viewTrash): ?>
        <a href="blog-create.php" class="btn-adm btn-adm-primary" style="padding: 0.65rem 1.25rem; font-weight: 600;">
          + Create First Blog Post
        </a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="admin-table-wrapper" style="border: none; margin: 0; background: transparent;">
      <table class="admin-table" style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr style="border-bottom: 1px solid var(--adm-border);">
            <th style="width: 40%; padding: 1rem 1.25rem;">ARTICLE &amp; SLUG</th>
            <th style="width: 18%; padding: 1rem 1rem;">CATEGORY</th>
            <th style="width: 16%; padding: 1rem 1rem;">AUTHOR &amp; METADATA</th>
            <th style="width: 9%; padding: 1rem 0.75rem; text-align: center;">STATUS</th>
            <th style="width: 9%; padding: 1rem 0.75rem; text-align: center;">PUBLISHED</th>
            <th style="width: 8%; padding: 1rem 1.25rem; text-align: right;">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($blogs as $b): ?>
            <?php 
              $hasImage = !empty($b['featured_image']) && file_exists(ROOT_PATH . '/' . ltrim($b['featured_image'], '/'));
              $cleanUrl = getBlogUrl($b['slug']);
              $authorName = $b['author'] ?: ($b['author_name'] ?: 'Editorial Team');
              $authorInitials = strtoupper(substr($authorName, 0, 2));
            ?>
            <tr style="transition: background-color 0.15s ease;">
              <!-- Title & Article Column -->
              <td style="padding: 1rem 1.25rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                  <!-- Thumbnail Image with Fallback -->
                  <div style="width: 68px; height: 48px; border-radius: 6px; overflow: hidden; background: #07172C; border: 1px solid var(--adm-border); flex-shrink: 0; display: flex; align-items: center; justify-content: center; position: relative;">
                    <?php if ($hasImage): ?>
                      <img src="../<?= e($b['featured_image']) ?>" alt="<?= e($b['cover_image_alt'] ?: $b['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                      <div style="display: none; width: 100%; height: 100%; align-items: center; justify-content: center; background: rgba(6, 181, 249, 0.08); color: var(--adm-teal); font-family: var(--adm-font-mono); font-size: 0.72rem; font-weight: 700;">
                        DOC
                      </div>
                    <?php else: ?>
                      <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(6, 181, 249, 0.08); color: var(--adm-teal); font-family: var(--adm-font-mono); font-size: 0.72rem; font-weight: 700;">
                        DOC
                      </div>
                    <?php endif; ?>
                  </div>

                  <!-- Title, Badges, and Clean URL -->
                  <div style="min-width: 0; flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap; margin-bottom: 0.35rem;">
                      <a href="blog-edit.php?id=<?= $b['id'] ?>" style="color: #FFFFFF; font-weight: 700; text-decoration: none; font-size: 0.94rem; line-height: 1.4;" onmouseover="this.style.color='var(--adm-teal)'" onmouseout="this.style.color='#FFFFFF'">
                        <?= e($b['title']) ?>
                      </a>
                      <?php if (!empty($b['is_featured'])): ?>
                        <span style="font-size: 0.65rem; padding: 0.15rem 0.45rem; background: rgba(245, 158, 11, 0.15); color: #FBBF24; border: 1px solid rgba(245, 158, 11, 0.35); border-radius: 4px; font-weight: 700; font-family: var(--adm-font-mono);">
                          ★ FEATURED
                        </span>
                      <?php endif; ?>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; font-size: 0.76rem;">
                      <a href="<?= $cleanUrl ?>" target="_blank" style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: #94A3B8; text-decoration: none; background: rgba(255,255,255,0.04); padding: 0.15rem 0.45rem; border-radius: 4px; border: 1px solid rgba(255,255,255,0.06);">
                        /blog/<?= e($b['slug']) ?> ↗
                      </a>
                      <span style="color: var(--adm-text-dim);">&bull;</span>
                      <a href="../blog/<?= e($b['slug']) ?>.md" target="_blank" style="font-family: var(--adm-font-mono); font-size: 0.7rem; color: var(--adm-teal); text-decoration: none; background: rgba(6, 181, 249, 0.08); padding: 0.15rem 0.45rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.2);">
                        .md ↗
                      </a>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Category Column -->
              <td style="padding: 1rem 1rem;">
                <div style="display: inline-block; background: rgba(6, 181, 249, 0.08); color: var(--adm-teal); border: 1px solid rgba(6, 181, 249, 0.25); border-radius: 4px; padding: 0.2rem 0.55rem; font-size: 0.72rem; font-weight: 600; font-family: var(--adm-font-mono); text-transform: uppercase; letter-spacing: 0.04em;">
                  <?= e($b['category'] ?: 'Engineering Strategy') ?>
                </div>
              </td>

              <!-- Author & Read Time Column -->
              <td style="padding: 1rem 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                  <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(6, 181, 249, 0.15); border: 1px solid rgba(6, 181, 249, 0.3); color: var(--adm-teal); font-size: 0.65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; font-family: var(--adm-font-mono); flex-shrink: 0;">
                    <?= e($authorInitials) ?>
                  </div>
                  <div style="min-width: 0;">
                    <div style="font-size: 0.84rem; font-weight: 600; color: #FFFFFF; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      <?= e($authorName) ?>
                    </div>
                    <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-top: 0.1rem; font-family: var(--adm-font-mono);">
                      <?= e($b['reading_time'] ?? '6 min read') ?>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Status Column -->
              <td style="padding: 1rem 0.75rem; text-align: center;">
                <?php if ($b['status'] === 'published'): ?>
                  <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(16, 185, 129, 0.12); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 700; font-family: var(--adm-font-mono);">
                    <span style="width: 5px; height: 5px; border-radius: 50%; background: #34D399;"></span>
                    <span>PUBLISHED</span>
                  </span>
                <?php else: ?>
                  <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(245, 158, 11, 0.12); color: #FBBF24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 700; font-family: var(--adm-font-mono);">
                    <span style="width: 5px; height: 5px; border-radius: 50%; background: #FBBF24;"></span>
                    <span>DRAFT</span>
                  </span>
                <?php endif; ?>
              </td>

              <!-- Publication Date Column -->
              <td style="padding: 1rem 0.75rem; text-align: center; white-space: nowrap; font-family: var(--adm-font-mono); font-size: 0.76rem; color: var(--adm-text-muted);">
                <?= e(date('M d, Y', strtotime($b['published_at'] ?? $b['created_at'] ?? 'now'))) ?>
              </td>

              <!-- Actions Column -->
              <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                <div style="display: inline-flex; gap: 0.45rem; align-items: center; justify-content: flex-end;">
                  <?php if (!$viewTrash): ?>
                    <!-- Live Article Link -->
                    <a href="<?= $cleanUrl ?>" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 0.35rem 0.6rem; font-size: 0.78rem;" title="Preview published article on live website">
                      View ↗
                    </a>

                    <!-- Editorial Workspace Edit Button -->
                    <a href="blog-edit.php?id=<?= $b['id'] ?>" class="btn-adm btn-adm-primary btn-adm-sm" style="padding: 0.35rem 0.75rem; font-weight: 600; font-size: 0.78rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="12" height="12" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                      <span>Edit</span>
                    </a>

                    <!-- Toggle Publish Status -->
                    <form method="POST" action="blogs.php" style="display: inline;">
                      <input type="hidden" name="action" value="toggle_publish">
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <?= csrfField() ?>
                      <button type="submit" class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 0.35rem 0.65rem; font-size: 0.78rem;" title="<?= $b['status'] === 'published' ? 'Switch to draft' : 'Publish live' ?>">
                        <?= $b['status'] === 'published' ? 'Unpublish' : 'Publish' ?>
                      </button>
                    </form>

                    <!-- Soft Delete Form -->
                    <form method="POST" action="blogs.php" style="display: inline;">
                      <input type="hidden" name="action" value="soft_delete">
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <?= csrfField() ?>
                      <button type="submit" class="btn-adm btn-adm-danger btn-adm-sm" style="padding: 0.35rem 0.55rem; font-size: 0.78rem;" onclick="return confirm('Move article \'<?= addslashes($b['title']) ?>\' to trash? It will be unpublished from the website immediately.');" title="Move to trash">
                        Delete
                      </button>
                    </form>
                  <?php else: ?>
                    <!-- Restore Form -->
                    <form method="POST" action="blogs.php?trash=1" style="display: inline;">
                      <input type="hidden" name="action" value="restore">
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <?= csrfField() ?>
                      <button type="submit" class="btn-adm btn-adm-primary btn-adm-sm" style="font-weight: 600;">
                        Restore
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
