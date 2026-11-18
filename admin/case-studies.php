<?php
/**
 * BusinessDoctor Executive Admin — Client Turnarounds & Case Studies Management (CMS)
 * Manage verified client transformations, outcome metrics, and architecture case studies.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

// Handle Actions (Publish / Unpublish / Toggle Featured / Soft-Delete / Restore)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'Security session expired. Please retry.');
        header('Location: case-studies.php');
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    $action = $_POST['action'];

    if ($id > 0) {
        if ($action === 'toggle_publish') {
            $stmt = $pdo->prepare("SELECT status FROM case_studies WHERE id = ?");
            $stmt->execute([$id]);
            $currentStatus = $stmt->fetchColumn();
            $newStatus = ($currentStatus === 'published') ? 'draft' : 'published';

            $update = $pdo->prepare("UPDATE case_studies SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $update->execute([$newStatus, $id]);

            setFlashMessage('success', "Case study status changed to {$newStatus}.");
        } elseif ($action === 'toggle_featured') {
            $stmt = $pdo->prepare("SELECT is_featured FROM case_studies WHERE id = ?");
            $stmt->execute([$id]);
            $isFeatured = (int)$stmt->fetchColumn();
            $newVal = $isFeatured ? 0 : 1;

            $update = $pdo->prepare("UPDATE case_studies SET is_featured = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $update->execute([$newVal, $id]);

            setFlashMessage('success', $newVal ? "Case study marked as featured on homepage." : "Case study unfeatured from homepage.");
        } elseif ($action === 'soft_delete') {
            $update = $pdo->prepare("UPDATE case_studies SET is_deleted = 1, deleted_at = CURRENT_TIMESTAMP, status = 'draft' WHERE id = ?");
            $update->execute([$id]);
            setFlashMessage('success', "Case study moved to trash (soft-deleted).");
        } elseif ($action === 'restore') {
            $update = $pdo->prepare("UPDATE case_studies SET is_deleted = 0, deleted_at = NULL WHERE id = ?");
            $update->execute([$id]);
            setFlashMessage('success', "Case study restored from trash.");
        }
        require_once __DIR__ . '/../includes/seo-sync.php';
        SeoSyncEngine::syncAll("Case Study status change ({$action}) ID:{$id}");
    }

    $redirectUrl = 'case-studies.php' . (!empty($_GET['trash']) ? '?trash=1' : (!empty($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
    header('Location: ' . $redirectUrl);
    exit;
}

// Filters & Search
$search = trim($_GET['search'] ?? '');
$industryFilter = trim($_GET['industry'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');
$viewTrash = (isset($_GET['trash']) && $_GET['trash'] === '1');

$where = $viewTrash ? ["is_deleted = 1"] : ["is_deleted = 0"];
$params = [];

if ($search !== '') {
    $where[] = "(title LIKE ? OR client_name LIKE ? OR industry LIKE ? OR client_industry LIKE ?)";
    $like = "%{$search}%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if ($industryFilter !== '') {
    $where[] = "(industry = ? OR client_industry = ?)";
    $params[] = $industryFilter;
    $params[] = $industryFilter;
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

// Get distinct industries
$industries = $pdo->query("SELECT DISTINCT COALESCE(NULLIF(industry, ''), client_industry) FROM case_studies WHERE is_deleted = 0 ORDER BY 1 ASC")->fetchAll(PDO::FETCH_COLUMN);

// Fetch Case Studies
$sql = "SELECT * FROM case_studies WHERE {$whereSql} ORDER BY sort_order ASC, id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Real-time counts
$totalActive = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0")->fetchColumn();
$totalPublished = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0 AND status = 'published'")->fetchColumn();
$totalDrafts = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0 AND status = 'draft'")->fetchColumn();
$totalFeatured = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0 AND is_featured = 1")->fetchColumn();
$totalTrash = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 1")->fetchColumn();

$pageTitle = $viewTrash ? 'Trash / Deleted Case Studies' : 'Case Studies Management — BusinessDoctor Admin';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Content Header Toolbar -->
<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1.25rem;">
  <div>
    <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--adm-font-mono); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--adm-teal); background: rgba(0, 242, 254, 0.08); border: 1px solid rgba(0, 242, 254, 0.2); padding: 0.2rem 0.6rem; border-radius: 4px; margin-bottom: 0.6rem;">
      <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--adm-teal); display: inline-block;"></span>
      <span>PORTFOLIO INTELLIGENCE // CLIENT TURNAROUNDS</span>
    </div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #FFFFFF; margin: 0 0 0.35rem; font-family: var(--adm-font-display); letter-spacing: -0.01em;">
      <?= $viewTrash ? 'Trash / Deleted Case Studies' : 'Client Case Studies &amp; Turnarounds' ?>
    </h2>
    <p style="color: var(--adm-text-muted, #94A3B8); font-size: 0.9rem; margin: 0; line-height: 1.5;">
      Manage verified client transformations, validated outcome metrics, architectural schematics, and case studies.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
    <?php if ($viewTrash): ?>
      <a href="case-studies.php" class="btn-adm btn-adm-secondary">
        &larr; Back to Active Studies (<?= $totalActive ?>)
      </a>
    <?php else: ?>
      <a href="../case-studies" target="_blank" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.65rem 1rem;">
        <span>View Public Hub</span>
        <span style="font-size: 0.9rem;">↗</span>
      </a>
      <a href="case-study-create.php" class="btn-adm btn-adm-primary" style="font-weight: 600; padding: 0.65rem 1.15rem; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(6, 181, 249, 0.25);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>+ Create Case Study</span>
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
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      </div>
      <div>
        <div class="admin-stat-val"><?= $totalActive ?></div>
        <div class="admin-stat-lbl">Total Case Studies</div>
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
        <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #FBBF24;"><?= $totalFeatured ?></div>
        <div class="admin-stat-lbl">Featured on Homepage</div>
      </div>
    </div>

    <!-- Stat 4 -->
    <div class="admin-stat-box" style="padding: 1.15rem 1.35rem;">
      <div class="admin-stat-icon" style="background: rgba(99, 102, 241, 0.15); color: #A5B4FC;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
      </div>
      <div>
        <div class="admin-stat-val" style="color: #A5B4FC;"><?= count($industries) ?></div>
        <div class="admin-stat-lbl">Client Industries</div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Segmented Filter Tabs Bar -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.25rem; flex-wrap: wrap; align-items: center;">
  <a href="case-studies.php" class="btn-adm <?= (!$viewTrash && $statusFilter === '') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    All (<?= $totalActive ?>)
  </a>
  <a href="case-studies.php?status=published" class="btn-adm <?= (!$viewTrash && $statusFilter === 'published') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    Published (<?= $totalPublished ?>)
  </a>
  <a href="case-studies.php?status=featured" class="btn-adm <?= (!$viewTrash && $statusFilter === 'featured') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    Featured (<?= $totalFeatured ?>)
  </a>
  <a href="case-studies.php?status=draft" class="btn-adm <?= (!$viewTrash && $statusFilter === 'draft') ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="font-weight: 600; padding: 0.4rem 0.85rem;">
    Drafts (<?= $totalDrafts ?>)
  </a>
  <?php if ($totalTrash > 0 || $viewTrash): ?>
    <a href="case-studies.php?trash=1" class="btn-adm <?= $viewTrash ? 'btn-adm-primary' : 'btn-adm-secondary' ?> btn-adm-sm" style="margin-left: auto; <?= $viewTrash ? '' : 'color: #FCA5A5; border-color: rgba(239, 68, 68, 0.35);' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2" style="margin-right: 0.25rem;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
      <span>Trash (<?= $totalTrash ?>)</span>
    </a>
  <?php endif; ?>
</div>

<!-- Filters Toolbar Card -->
<div class="admin-card" style="padding: 1.15rem 1.35rem; margin-bottom: 1.5rem; background: var(--adm-surface); border: 1px solid var(--adm-border);">
  <form method="GET" action="case-studies.php" class="admin-toolbar" style="margin: 0; gap: 1rem;">
    <?php if ($viewTrash): ?>
      <input type="hidden" name="trash" value="1">
    <?php endif; ?>
    <?php if ($statusFilter !== ''): ?>
      <input type="hidden" name="status" value="<?= e($statusFilter) ?>">
    <?php endif; ?>

    <div class="admin-toolbar-group" style="flex: 1; min-width: 260px; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
      <div class="adm-search-box" style="flex: 1; min-width: 240px; position: relative;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--adm-text-dim);"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search by client, title, industry..." class="adm-input" style="padding-left: 36px; width: 100%;">
      </div>

      <select name="industry" class="adm-select" style="width: auto; min-width: 190px;">
        <option value="">All Industries</option>
        <?php foreach ($industries as $ind): ?>
          <?php if (!empty($ind)): ?>
            <option value="<?= e($ind) ?>" <?= $industryFilter === $ind ? 'selected' : '' ?>><?= e($ind) ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>

      <button type="submit" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.55rem 1rem;">Filter</button>
      
      <?php if ($search !== '' || $industryFilter !== '' || $statusFilter !== ''): ?>
        <a href="case-studies.php<?= $viewTrash ? '?trash=1' : '' ?>" class="btn-adm btn-adm-secondary" style="color: var(--adm-text-dim); padding: 0.55rem 0.85rem;">Reset</a>
      <?php endif; ?>
    </div>

    <div style="font-size: 0.78rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono); background: rgba(255,255,255,0.03); border: 1px solid var(--adm-border-subtle); padding: 0.4rem 0.75rem; border-radius: 4px; white-space: nowrap;">
      Showing <?= count($cases) ?> <?= count($cases) === 1 ? 'case study' : 'case studies' ?>
    </div>
  </form>
</div>

<!-- Case Studies Table -->
<div class="admin-card" style="padding: 0; overflow: hidden; border: 1px solid var(--adm-border); background: var(--adm-surface);">
  <?php if (empty($cases)): ?>
    <div style="text-align: center; padding: 4rem 1.5rem;">
      <div style="width: 56px; height: 56px; margin: 0 auto 1.25rem; border-radius: 50%; background: rgba(6, 181, 249, 0.1); border: 1px solid rgba(6, 181, 249, 0.25); display: flex; align-items: center; justify-content: center; color: var(--adm-teal);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="28" height="28" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      </div>
      <h3 style="color: #ffffff; margin-bottom: 0.5rem; font-family: var(--adm-font-display); font-size: 1.2rem;">No case studies found</h3>
      <p style="color: var(--adm-text-muted); margin-bottom: 1.5rem; max-width: 440px; margin-left: auto; margin-right: auto; font-size: 0.88rem; line-height: 1.55;">
        <?= $viewTrash ? 'Trash is currently empty.' : 'Try adjusting your search criteria, clearing the industry filter, or author a new case study.' ?>
      </p>
      <?php if (!$viewTrash): ?>
        <a href="case-study-create.php" class="btn-adm btn-adm-primary" style="padding: 0.65rem 1.25rem; font-weight: 600;">
          + Create Your First Case Study
        </a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="admin-table-wrapper" style="border: none; margin: 0; background: transparent;">
      <table class="admin-table" style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr style="border-bottom: 1px solid var(--adm-border);">
            <th style="width: 34%; padding: 1rem 1.25rem;">CASE STUDY &amp; CLIENT</th>
            <th style="width: 18%; padding: 1rem 1rem;">INDUSTRY &amp; PRACTICE</th>
            <th style="width: 16%; padding: 1rem 1rem;">VERIFIED IMPACT METRIC</th>
            <th style="width: 8%; padding: 1rem 0.75rem; text-align: center;">STATUS</th>
            <th style="width: 8%; padding: 1rem 0.75rem; text-align: center;">FEATURED</th>
            <th style="width: 16%; padding: 1rem 1.25rem; text-align: right;">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cases as $c): ?>
            <?php 
              $hasImage = !empty($c['featured_image']) && file_exists(ROOT_PATH . '/' . ltrim($c['featured_image'], '/'));
              $cleanUrl = getCaseStudyUrl($c['slug']);
            ?>
            <tr style="transition: background-color 0.15s ease;">
              <!-- Title & Client Column -->
              <td style="padding: 1rem 1.25rem;">
                <div style="display: flex; gap: 1rem; align-items: flex-start;">
                  <!-- Thumbnail Image with Fallback -->
                  <div style="width: 68px; height: 48px; border-radius: 6px; overflow: hidden; background: #07172C; border: 1px solid var(--adm-border); flex-shrink: 0; display: flex; align-items: center; justify-content: center; position: relative;">
                    <?php if ($hasImage): ?>
                      <img src="<?= getAssetUrl($c['featured_image']) ?>" alt="<?= e($c['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                      <div style="display: none; width: 100%; height: 100%; align-items: center; justify-content: center; background: rgba(6, 181, 249, 0.08); color: var(--adm-teal);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                      </div>
                    <?php else: ?>
                      <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(6, 181, 249, 0.08); color: var(--adm-teal);">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                      </div>
                    <?php endif; ?>
                  </div>

                  <!-- Title, Client and Clean URL -->
                  <div style="min-width: 0; flex: 1;">
                    <a href="case-study-edit.php?id=<?= $c['id'] ?>" style="color: #FFFFFF; font-weight: 700; text-decoration: none; font-size: 0.94rem; line-height: 1.4; display: block; margin-bottom: 0.35rem;" onmouseover="this.style.color='var(--adm-teal)'" onmouseout="this.style.color='#FFFFFF'">
                      <?= e($c['title']) ?>
                    </a>
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; font-size: 0.76rem;">
                      <span style="color: var(--adm-teal); font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="12" height="12" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        <span><?= e($c['client_name'] ?: 'Enterprise Client') ?></span>
                      </span>
                      <span style="color: var(--adm-text-dim);">&bull;</span>
                      <a href="<?= $cleanUrl ?>" target="_blank" style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: #94A3B8; text-decoration: none; background: rgba(255,255,255,0.04); padding: 0.15rem 0.45rem; border-radius: 4px; border: 1px solid rgba(255,255,255,0.06);">
                        /case-studies/<?= e($c['slug']) ?> ↗
                      </a>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Industry & Practice Column -->
              <td style="padding: 1rem 1rem;">
                <div style="display: inline-block; background: rgba(6, 181, 249, 0.08); color: #38BDF8; border: 1px solid rgba(6, 181, 249, 0.25); border-radius: 4px; padding: 0.2rem 0.55rem; font-size: 0.72rem; font-weight: 600; font-family: var(--adm-font-mono); text-transform: uppercase; letter-spacing: 0.04em;">
                  <?= e($c['industry'] ?: $c['client_industry'] ?: 'Enterprise') ?>
                </div>
                <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.35rem; line-height: 1.35;">
                  <?= e($c['service_category'] ?: $c['practice_area'] ?: 'Digital Architecture') ?>
                </div>
              </td>

              <!-- Verified Impact Metric Column -->
              <td style="padding: 1rem 1rem;">
                <div style="font-family: var(--adm-font-mono); font-size: 0.88rem; font-weight: 800; color: #34D399; letter-spacing: -0.01em; display: inline-flex; align-items: center; gap: 0.35rem;">
                  <span style="width: 6px; height: 6px; border-radius: 50%; background: #34D399; display: inline-block;"></span>
                  <span><?= e($c['outcome_metric']) ?></span>
                </div>
                <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                  <?= e($c['metric_label'] ?: 'Audited Performance Outcome') ?>
                </div>
              </td>

              <!-- Status Column -->
              <td style="padding: 1rem 0.75rem; text-align: center;">
                <?php if ($c['status'] === 'published'): ?>
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

              <!-- Featured Column -->
              <td style="padding: 1rem 0.75rem; text-align: center;">
                <?php if (!$viewTrash): ?>
                  <form method="POST" action="case-studies.php" style="display: inline;">
                    <input type="hidden" name="action" value="toggle_featured">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <?= csrfField() ?>
                    <button type="submit" style="cursor: pointer; padding: 0.3rem 0.65rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; font-family: var(--adm-font-mono); transition: all 0.15s ease; <?= $c['is_featured'] ? 'background: rgba(245, 158, 11, 0.14); color: #F59E0B; border: 1px solid rgba(245, 158, 11, 0.4);' : 'background: rgba(255,255,255,0.03); color: #64748B; border: 1px solid rgba(255,255,255,0.1);' ?>" title="Click to toggle homepage featured status">
                      <?= $c['is_featured'] ? '★ FEATURED' : '☆ STANDARD' ?>
                    </button>
                  </form>
                <?php else: ?>
                  <span style="font-size: 0.75rem; color: var(--adm-text-dim);"><?= $c['is_featured'] ? 'Yes' : 'No' ?></span>
                <?php endif; ?>
              </td>

              <!-- Actions Column -->
              <td style="padding: 1rem 1.25rem; text-align: right; white-space: nowrap;">
                <div style="display: inline-flex; gap: 0.45rem; align-items: center; justify-content: flex-end;">
                  <?php if (!$viewTrash): ?>
                    <!-- Live Link -->
                    <a href="<?= $cleanUrl ?>" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 0.35rem 0.6rem; font-size: 0.78rem;" title="View public case study on live website">
                      View ↗
                    </a>

                    <!-- Edit Button -->
                    <a href="case-study-edit.php?id=<?= $c['id'] ?>" class="btn-adm btn-adm-primary btn-adm-sm" style="padding: 0.35rem 0.75rem; font-weight: 600; font-size: 0.78rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="12" height="12" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                      <span>Edit</span>
                    </a>

                    <!-- Toggle Publish Status -->
                    <form method="POST" action="case-studies.php" style="display: inline;">
                      <input type="hidden" name="action" value="toggle_publish">
                      <input type="hidden" name="id" value="<?= $c['id'] ?>">
                      <?= csrfField() ?>
                      <button type="submit" class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 0.35rem 0.65rem; font-size: 0.78rem;" title="<?= $c['status'] === 'published' ? 'Switch to draft' : 'Publish live' ?>">
                        <?= $c['status'] === 'published' ? 'Unpublish' : 'Publish' ?>
                      </button>
                    </form>

                    <!-- Soft Delete Form -->
                    <form method="POST" action="case-studies.php" style="display: inline;">
                      <input type="hidden" name="action" value="soft_delete">
                      <input type="hidden" name="id" value="<?= $c['id'] ?>">
                      <?= csrfField() ?>
                      <button type="submit" class="btn-adm btn-adm-danger btn-adm-sm" style="padding: 0.35rem 0.55rem; font-size: 0.78rem;" onclick="return confirm('Move case study \'<?= addslashes($c['title']) ?>\' to trash? It will be unpublished from the website immediately.');" title="Move to trash">
                        Delete
                      </button>
                    </form>
                  <?php else: ?>
                    <!-- Restore Form -->
                    <form method="POST" action="case-studies.php?trash=1" style="display: inline;">
                      <input type="hidden" name="action" value="restore">
                      <input type="hidden" name="id" value="<?= $c['id'] ?>">
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
