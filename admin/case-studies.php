<?php
/**
 * BusinessDoctor Case Studies Management (CMS)
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

            $update = $pdo->prepare("UPDATE case_studies SET status = ?, updated_at = datetime('now') WHERE id = ?");
            $update->execute([$newStatus, $id]);

            setFlashMessage('success', "Case study status changed to {$newStatus}.");
        } elseif ($action === 'toggle_featured') {
            $stmt = $pdo->prepare("SELECT is_featured FROM case_studies WHERE id = ?");
            $stmt->execute([$id]);
            $isFeatured = (int)$stmt->fetchColumn();
            $newVal = $isFeatured ? 0 : 1;

            $update = $pdo->prepare("UPDATE case_studies SET is_featured = ?, updated_at = datetime('now') WHERE id = ?");
            $update->execute([$newVal, $id]);

            setFlashMessage('success', $newVal ? "Case study marked as featured on homepage." : "Case study unfeatured from homepage.");
        } elseif ($action === 'soft_delete') {
            $update = $pdo->prepare("UPDATE case_studies SET is_deleted = 1, deleted_at = datetime('now'), status = 'draft' WHERE id = ?");
            $update->execute([$id]);
            setFlashMessage('success', "Case study moved to trash (soft-deleted).");
        } elseif ($action === 'restore') {
            $update = $pdo->prepare("UPDATE case_studies SET is_deleted = 0, deleted_at = NULL WHERE id = ?");
            $update->execute([$id]);
            setFlashMessage('success', "Case study restored from trash.");
        }

        // Automatic SEO, Schema, Sitemap, Markdown & LLM Optimization Hook
        try {
            require_once __DIR__ . '/../includes/seo-service.php';
            seo_on_case_study_changed($id);
        } catch (Throwable $seoErr) {
            error_log('[SEO HOOK ERROR] case-studies.php: ' . $seoErr->getMessage());
        }
    }

    header('Location: case-studies.php' . (!empty($_GET['trash']) ? '?trash=1' : ''));
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

if ($statusFilter !== '') {
    $where[] = "status = ?";
    $params[] = $statusFilter;
}

$whereSql = implode(' AND ', $where);

// Get distinct industries
$industries = $pdo->query("SELECT DISTINCT COALESCE(NULLIF(industry, ''), client_industry) FROM case_studies WHERE is_deleted = 0 ORDER BY 1 ASC")->fetchAll(PDO::FETCH_COLUMN);

// Fetch Case Studies
$sql = "SELECT * FROM case_studies WHERE {$whereSql} ORDER BY sort_order ASC, id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$cases = $stmt->fetchAll();

// Counts
$totalActive = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0")->fetchColumn();
$totalTrash = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 1")->fetchColumn();

$pageTitle = $viewTrash ? 'Trash / Deleted Case Studies' : 'Case Studies Management';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Toolbar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.4rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem; font-family: var(--adm-font-display);">
      <?= $viewTrash ? 'Deleted Case Studies' : 'Client Case Studies' ?>
    </h2>
    <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.85rem;">
      Manage verified client transformations, outcome metrics, and architecture case studies.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center;">
    <?php if ($viewTrash): ?>
      <a href="case-studies.php" class="btn-adm btn-adm-secondary">
        &larr; Back to Active Case Studies (<?= $totalActive ?>)
      </a>
    <?php else: ?>
      <?php if ($totalTrash > 0): ?>
        <a href="case-studies.php?trash=1" class="btn-adm btn-adm-secondary btn-adm-sm" style="color: #FCA5A5;">
          Trash (<?= $totalTrash ?>)
        </a>
      <?php endif; ?>
      <a href="case-study-create.php" class="btn-adm btn-adm-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Create Case Study</span>
      </a>
    <?php endif; ?>
  </div>
</div>

<!-- Filters Toolbar -->
<div class="admin-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
  <form method="GET" action="case-studies.php" class="admin-toolbar" style="margin: 0;">
    <?php if ($viewTrash): ?>
      <input type="hidden" name="trash" value="1">
    <?php endif; ?>

    <div class="admin-toolbar-group" style="flex: 1;">
      <div class="adm-search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search by title, client, or industry..." class="adm-input">
      </div>

      <select name="industry" class="adm-select" style="width: auto; min-width: 180px;">
        <option value="">All Industries</option>
        <?php foreach ($industries as $ind): ?>
          <?php if (!empty($ind)): ?>
            <option value="<?= e($ind) ?>" <?= $industryFilter === $ind ? 'selected' : '' ?>><?= e($ind) ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>

      <?php if (!$viewTrash): ?>
        <select name="status" class="adm-select" style="width: auto; min-width: 140px;">
          <option value="">All Statuses</option>
          <option value="published" <?= $statusFilter === 'published' ? 'selected' : '' ?>>Published</option>
          <option value="draft" <?= $statusFilter === 'draft' ? 'selected' : '' ?>>Draft</option>
        </select>
      <?php endif; ?>

      <button type="submit" class="btn-adm btn-adm-secondary">Filter</button>
      
      <?php if ($search !== '' || $industryFilter !== '' || $statusFilter !== ''): ?>
        <a href="case-studies.php<?= $viewTrash ? '?trash=1' : '' ?>" class="btn-adm btn-adm-secondary" style="color: var(--adm-text-dim);">Reset</a>
      <?php endif; ?>
    </div>

    <div style="font-size: 0.8rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
      Found: <?= count($cases) ?> <?= count($cases) === 1 ? 'case study' : 'case studies' ?>
    </div>
  </form>
</div>

<!-- Case Studies Table -->
<div class="admin-card" style="padding: 0; overflow: hidden;">
  <?php if (empty($cases)): ?>
    <div style="text-align: center; padding: 3.5rem 1.5rem;">
      <div style="width: 48px; height: 48px; margin: 0 auto 1rem; border-radius: 50%; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #60A5FA;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="24" height="24" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      </div>
      <h3 style="color: #ffffff; margin-bottom: 0.5rem;">No case studies found</h3>
      <p style="color: var(--adm-text-muted); margin-bottom: 1.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">
        <?= $viewTrash ? 'Trash is currently empty.' : 'Try adjusting your search filters or create a new case study.' ?>
      </p>
      <?php if (!$viewTrash): ?>
        <a href="case-study-create.php" class="btn-adm btn-adm-primary">Create Your First Case Study</a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="admin-table-wrapper" style="border: none;">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width: 40%;">Project Title &amp; Client</th>
            <th>Industry / Category</th>
            <th>Verified Impact Metric</th>
            <th>Status</th>
            <th>Featured</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cases as $c): ?>
            <tr>
              <td>
                <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
                  <?php if (!empty($c['featured_image'])): ?>
                    <img src="../<?= e($c['featured_image']) ?>" alt="" style="width: 52px; height: 42px; border-radius: 4px; object-fit: cover; flex-shrink: 0; border: 1px solid var(--adm-border);">
                  <?php endif; ?>
                  <div>
                    <a href="case-study-edit.php?id=<?= $c['id'] ?>" style="color: #ffffff; font-weight: 700; text-decoration: none; font-size: 0.92rem;">
                      <?= e($c['title']) ?>
                    </a>
                    <div style="font-size: 0.76rem; color: var(--adm-teal); margin-top: 0.2rem;">
                      <?= e($c['client_name'] ?: 'Enterprise Client') ?> &bull; 
                      <span style="font-family: var(--adm-font-mono); color: var(--adm-text-dim);">/case-studies/<?= e($c['slug']) ?></span>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <span class="status-pill status-published" style="background: rgba(59, 130, 246, 0.1); color: #60A5FA; border-color: rgba(59, 130, 246, 0.25);">
                  <?= e($c['industry'] ?: $c['client_industry']) ?>
                </span>
                <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-top: 0.25rem;">
                  <?= e($c['service_category'] ?: $c['practice_area']) ?>
                </div>
              </td>
              <td>
                <div style="font-family: var(--adm-font-mono); font-size: 0.85rem; font-weight: 700; color: #34D399;">
                  <?= e($c['outcome_metric']) ?>
                </div>
                <div style="font-size: 0.72rem; color: var(--adm-text-dim);"><?= e($c['metric_label']) ?></div>
              </td>
              <td>
                <span class="status-pill status-<?= $c['status'] === 'published' ? 'published' : 'draft' ?>">
                  <?= e($c['status']) ?>
                </span>
              </td>
              <td>
                <?php if (!$viewTrash): ?>
                  <form method="POST" action="case-studies.php" style="display: inline;">
                    <input type="hidden" name="action" value="toggle_featured">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                    <button type="submit" class="status-pill <?= $c['is_featured'] ? 'status-published' : 'status-draft' ?>" style="cursor: pointer; background: transparent; border: 1px solid <?= $c['is_featured'] ? '#10B981' : 'var(--adm-text-dim)' ?>;">
                      <?= $c['is_featured'] ? '★ Homepage' : '☆ Standard' ?>
                    </button>
                  </form>
                <?php else: ?>
                  <span style="font-size: 0.75rem; color: var(--adm-text-dim);"><?= $c['is_featured'] ? 'Yes' : 'No' ?></span>
                <?php endif; ?>
              </td>
              <td style="text-align: right; white-space: nowrap;">
                <div style="display: inline-flex; gap: 0.4rem; align-items: center;">
                  
                  <?php if (!$viewTrash): ?>
                    <!-- Live / Preview Link -->
                    <a href="../case-studies/<?= urlencode($c['slug']) ?>" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary btn-adm-sm" title="Preview on website">
                      View ↗
                    </a>

                    <!-- Edit Button -->
                    <a href="case-study-edit.php?id=<?= $c['id'] ?>" class="btn-adm btn-adm-primary btn-adm-sm">
                      Edit
                    </a>

                    <!-- Toggle Publish Form -->
                    <form method="POST" action="case-studies.php" style="display: inline;">
                      <input type="hidden" name="action" value="toggle_publish">
                      <input type="hidden" name="id" value="<?= $c['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                      <button type="submit" class="btn-adm btn-adm-secondary btn-adm-sm" title="<?= $c['status'] === 'published' ? 'Unpublish' : 'Publish' ?>">
                        <?= $c['status'] === 'published' ? 'Unpublish' : 'Publish' ?>
                      </button>
                    </form>

                    <!-- Soft Delete Form -->
                    <form method="POST" action="case-studies.php" style="display: inline;">
                      <input type="hidden" name="action" value="soft_delete">
                      <input type="hidden" name="id" value="<?= $c['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                      <button type="submit" class="btn-adm btn-adm-danger btn-adm-sm" data-confirm="Move this case study to trash? It will be unpublished immediately.">
                        Delete
                      </button>
                    </form>
                  <?php else: ?>
                    <!-- Restore Form -->
                    <form method="POST" action="case-studies.php?trash=1" style="display: inline;">
                      <input type="hidden" name="action" value="restore">
                      <input type="hidden" name="id" value="<?= $c['id'] ?>">
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

