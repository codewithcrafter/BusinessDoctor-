<?php
/**
 * BusinessDoctor Blog Management (CMS)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

// Handle Actions (Publish / Unpublish / Soft-Delete / Restore)
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

            $update = $pdo->prepare("UPDATE insights SET status = ?, is_published = ?, updated_at = datetime('now') WHERE id = ?");
            $update->execute([$newStatus, $isPub, $id]);

            setFlashMessage('success', "Blog post status changed to {$newStatus}.");
        } elseif ($action === 'soft_delete') {
            $update = $pdo->prepare("UPDATE insights SET is_deleted = 1, deleted_at = datetime('now'), status = 'draft', is_published = 0 WHERE id = ?");
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

    header('Location: blogs.php' . (!empty($_GET['trash']) ? '?trash=1' : (!empty($_GET['status']) ? '?status=' . urlencode($_GET['status']) : '')));
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
    $where[] = "(title LIKE ? OR summary LIKE ? OR author_name LIKE ? OR author LIKE ? OR category LIKE ?)";
    $like = "%{$search}%";
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
    $where[] = "status = ?";
    $params[] = $statusFilter;
}

$whereSql = implode(' AND ', $where);

// Get distinct categories for filter dropdown
$categories = $pdo->query("SELECT DISTINCT category FROM insights WHERE is_deleted = 0 ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN);

// Fetch Blogs
$sql = "SELECT * FROM insights WHERE {$whereSql} ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$blogs = $stmt->fetchAll();

// Counts for pill tabs
$totalActive = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0")->fetchColumn();
$totalPublished = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0 AND status = 'published'")->fetchColumn();
$totalDrafts = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0 AND status = 'draft'")->fetchColumn();
$totalTrash = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 1")->fetchColumn();

$pageTitle = $viewTrash ? 'Trash / Deleted Blogs' : 'Blog & Perspective Articles';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Toolbar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem; font-family: var(--adm-font-display);">
      <?= $viewTrash ? 'Trash / Deleted Articles' : 'Editorial Workspace &amp; Blog Management' ?>
    </h2>
    <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.88rem;">
      Author, publish, and manage engineering perspectives and digital growth insights for BusinessDoctor.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center;">
    <?php if ($viewTrash): ?>
      <a href="blogs.php" class="btn-adm btn-adm-secondary">
        &larr; Back to Active Articles
      </a>
    <?php else: ?>
      <a href="blog-create.php" class="btn-adm btn-adm-primary" style="font-size: 0.92rem; padding: 0.65rem 1.15rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="18" height="18" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Create Blog Post</span>
      </a>
    <?php endif; ?>
  </div>
</div>

<!-- Stats Counter Badges -->
<?php if (!$viewTrash): ?>
  <div class="admin-stats-grid" style="margin-bottom: 1.5rem;">
    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      </div>
      <div>
        <div class="admin-stat-val"><?= $totalActive ?></div>
        <div class="admin-stat-lbl">Total Articles</div>
      </div>
    </div>

    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(16, 185, 129, 0.15); color: #34D399;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #34D399;"><?= $totalPublished ?></div>
        <div class="admin-stat-lbl">Live on Website</div>
      </div>
    </div>

    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(245, 158, 11, 0.15); color: #FBBF24;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #FBBF24;"><?= $totalDrafts ?></div>
        <div class="admin-stat-lbl">Draft In Progress</div>
      </div>
    </div>

    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(59, 130, 246, 0.15); color: #60A5FA;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      </div>
      <div>
        <div class="admin-stat-val"><?= count($categories) ?></div>
        <div class="admin-stat-lbl">Active Categories</div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Quick Tabs Bar -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap;">
  <a href="blogs.php" class="btn-adm <?= (!$viewTrash && $statusFilter === '') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm">
    All (<?= $totalActive ?>)
  </a>
  <a href="blogs.php?status=published" class="btn-adm <?= (!$viewTrash && $statusFilter === 'published') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm">
    Published (<?= $totalPublished ?>)
  </a>
  <a href="blogs.php?status=draft" class="btn-adm <?= (!$viewTrash && $statusFilter === 'draft') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm">
    Drafts (<?= $totalDrafts ?>)
  </a>
  <?php if ($totalTrash > 0 || $viewTrash): ?>
    <a href="blogs.php?trash=1" class="btn-adm <?= $viewTrash ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="<?= $viewTrash ? '' : 'color: #FCA5A5;' ?>">
      Trash (<?= $totalTrash ?>)
    </a>
  <?php endif; ?>
</div>

<!-- Filters Toolbar -->
<div class="admin-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
  <form method="GET" action="blogs.php" class="admin-toolbar" style="margin: 0;">
    <?php if ($viewTrash): ?>
      <input type="hidden" name="trash" value="1">
    <?php endif; ?>
    <?php if ($statusFilter !== ''): ?>
      <input type="hidden" name="status" value="<?= e($statusFilter) ?>">
    <?php endif; ?>

    <div class="admin-toolbar-group" style="flex: 1;">
      <div class="adm-search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search articles by title, author, or keywords..." class="adm-input">
      </div>

      <select name="category" class="adm-select" style="width: auto; min-width: 180px;">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= e($cat) ?>" <?= $categoryFilter === $cat ? 'selected' : '' ?>><?= e($cat) ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn-adm btn-adm-secondary">Filter</button>
      
      <?php if ($search !== '' || $categoryFilter !== ''): ?>
        <a href="blogs.php<?= $viewTrash ? '?trash=1' : ($statusFilter ? '?status=' . urlencode($statusFilter) : '') ?>" class="btn-adm btn-adm-secondary" style="color: var(--adm-text-dim);">Reset</a>
      <?php endif; ?>
    </div>

    <div style="font-size: 0.8rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
      Showing <?= count($blogs) ?> <?= count($blogs) === 1 ? 'article' : 'articles' ?>
    </div>
  </form>
</div>

<!-- Blogs Table -->
<div class="admin-card" style="padding: 0; overflow: hidden;">
  <?php if (empty($blogs)): ?>
    <div style="text-align: center; padding: 3.5rem 1.5rem;">
      <div style="width: 52px; height: 52px; margin: 0 auto 1.25rem; border-radius: 50%; background: var(--adm-teal-dim); display: flex; align-items: center; justify-content: center; color: var(--adm-teal);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="26" height="26" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
      </div>
      <h3 style="color: #ffffff; margin-bottom: 0.5rem; font-family: var(--adm-font-display);">No blog articles found</h3>
      <p style="color: var(--adm-text-muted); margin-bottom: 1.5rem; max-width: 440px; margin-left: auto; margin-right: auto;">
        <?= $viewTrash ? 'Trash is currently empty.' : 'Try adjusting your search filters or launch the editorial workspace to create a new post.' ?>
      </p>
      <?php if (!$viewTrash): ?>
        <a href="blog-create.php" class="btn-adm btn-adm-primary">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          <span>Create First Blog Post</span>
        </a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="admin-table-wrapper" style="border: none;">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width: 45%;">Article &amp; Metadata</th>
            <th>Category</th>
            <th>Author</th>
            <th>Status</th>
            <th>Publication Date</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($blogs as $b): ?>
            <tr>
              <td>
                <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
                  <?php if (!empty($b['featured_image'])): ?>
                    <img src="../<?= e($b['featured_image']) ?>" alt="<?= e($b['cover_image_alt'] ?: $b['title']) ?>" style="width: 56px; height: 42px; border-radius: 4px; object-fit: cover; flex-shrink: 0; border: 1px solid var(--adm-border);">
                  <?php else: ?>
                    <div style="width: 56px; height: 42px; border-radius: 4px; background: rgba(0, 201, 193, 0.08); border: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: center; color: var(--adm-teal); font-family: var(--adm-font-mono); font-size: 0.72rem; flex-shrink: 0;">DOC</div>
                  <?php endif; ?>
                  <div>
                    <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap;">
                      <a href="blog-edit.php?id=<?= $b['id'] ?>" style="color: #ffffff; font-weight: 700; text-decoration: none; font-size: 0.94rem;">
                        <?= e($b['title']) ?>
                      </a>
                      <?php if (!empty($b['is_featured'])): ?>
                        <span class="status-pill status-published" style="font-size: 0.65rem; padding: 1px 6px; background: rgba(245, 158, 11, 0.15); color: #FBBF24; border-color: rgba(245, 158, 11, 0.35);">★ Featured</span>
                      <?php endif; ?>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--adm-text-dim); margin-top: 0.2rem; font-family: var(--adm-font-mono);">
                      slug: <?= e($b['slug']) ?>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <span class="status-pill status-published" style="background: rgba(0, 201, 193, 0.08); color: var(--adm-teal); border-color: rgba(0,201,193,0.25);">
                  <?= e($b['category']) ?>
                </span>
              </td>
              <td>
                <div style="font-size: 0.85rem; font-weight: 600; color: #ffffff;"><?= e($b['author'] ?: $b['author_name']) ?></div>
                <div style="font-size: 0.72rem; color: var(--adm-text-dim);"><?= e($b['reading_time'] ?? '6 min read') ?></div>
              </td>
              <td>
                <span class="status-pill status-<?= $b['status'] === 'published' ? 'published' : 'draft' ?>">
                  <?= e($b['status']) ?>
                </span>
              </td>
              <td style="white-space: nowrap; font-family: var(--adm-font-mono); font-size: 0.76rem; color: var(--adm-text-muted);">
                <?= e(date('M d, Y', strtotime($b['published_at'] ?? $b['created_at'] ?? 'now'))) ?>
              </td>
              <td style="text-align: right; white-space: nowrap;">
                <div style="display: inline-flex; gap: 0.4rem; align-items: center;">
                  
                  <?php if (!$viewTrash): ?>
                    <!-- Live Preview Link -->
                    <a href="../insight-detail.php?slug=<?= urlencode($b['slug']) ?>" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary btn-adm-sm" title="Preview on live site">
                      View ↗
                    </a>

                    <!-- Editorial Workspace Edit Button -->
                    <a href="blog-edit.php?id=<?= $b['id'] ?>" class="btn-adm btn-adm-primary btn-adm-sm">
                      Edit
                    </a>

                    <!-- Toggle Publish Form -->
                    <form method="POST" action="blogs.php" style="display: inline;">
                      <input type="hidden" name="action" value="toggle_publish">
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                      <button type="submit" class="btn-adm btn-adm-secondary btn-adm-sm" title="<?= $b['status'] === 'published' ? 'Unpublish to draft' : 'Publish live' ?>">
                        <?= $b['status'] === 'published' ? 'Unpublish' : 'Publish' ?>
                      </button>
                    </form>

                    <!-- Soft Delete Form -->
                    <form method="POST" action="blogs.php" style="display: inline;">
                      <input type="hidden" name="action" value="soft_delete">
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                      <button type="submit" class="btn-adm btn-adm-danger btn-adm-sm" data-confirm="Move this blog post to trash? It will be unpublished immediately.">
                        Delete
                      </button>
                    </form>
                  <?php else: ?>
                    <!-- Restore Form -->
                    <form method="POST" action="blogs.php?trash=1" style="display: inline;">
                      <input type="hidden" name="action" value="restore">
                      <input type="hidden" name="id" value="<?= $b['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                      <button type="submit" class="btn-adm btn-adm-primary btn-adm-sm">
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
