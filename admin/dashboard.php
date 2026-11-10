<?php
/**
 * BusinessDoctor Executive Admin Dashboard
 * Client Project Console & CMS Overview
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$message = '';
$msgType = 'info';

// Handle Audit Status Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_diagnostic_status') {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $message = "Security session expired. Status update rejected.";
            $msgType = "error";
        } else {
            $id = (int)($_POST['id'] ?? 0);
            $newStatus = trim($_POST['status'] ?? 'pending');
            $allowed = ['pending', 'in_review', 'prescribed', 'completed', 'archived'];
            if ($id > 0 && in_array($newStatus, $allowed, true)) {
                $stmt = $pdo->prepare("UPDATE diagnostic_requests SET status = ? WHERE id = ?");
                $stmt->execute([$newStatus, $id]);
                $message = "Audit request #{$id} status updated to '{$newStatus}'.";
                $msgType = "success";
            }
        }
    }
}

// Fetch Metrics
$diagCount = (int)$pdo->query("SELECT COUNT(*) FROM diagnostic_requests")->fetchColumn();
$pendingDiagCount = (int)$pdo->query("SELECT COUNT(*) FROM diagnostic_requests WHERE status = 'pending'")->fetchColumn();
$contactCount = (int)$pdo->query("SELECT COUNT(*) FROM contact_inquiries")->fetchColumn();
$subCount = (int)$pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE is_active = 1")->fetchColumn();
$blogCount = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0")->fetchColumn();
$publishedBlogCount = (int)$pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0 AND status = 'published'")->fetchColumn();
$caseCount = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0")->fetchColumn();
$publishedCaseCount = (int)$pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0 AND status = 'published'")->fetchColumn();

// Fetch Recent Records
$recentBlogs = $pdo->query("SELECT id, title, category, author_name, status, published_at FROM insights WHERE is_deleted = 0 ORDER BY id DESC LIMIT 5")->fetchAll();
$recentCases = $pdo->query("SELECT id, title, client_name, industry, status, is_featured FROM case_studies WHERE is_deleted = 0 ORDER BY id DESC LIMIT 5")->fetchAll();
$diagnostics = $pdo->query("SELECT * FROM diagnostic_requests ORDER BY created_at DESC LIMIT 15")->fetchAll();
$contacts = $pdo->query("SELECT * FROM contact_inquiries ORDER BY created_at DESC LIMIT 10")->fetchAll();

$pageTitle = 'Executive Dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($message): ?>
  <div class="adm-toast <?= $msgType === 'error' ? 'error' : '' ?>" style="margin-bottom: 1.5rem; max-width: 100%;">
    <span><?= e($message) ?></span>
  </div>
<?php endif; ?>

<!-- Quick Actions Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin: 0 0 0.35rem; font-family: var(--adm-font-display);">Executive Control Center</h2>
    <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.9rem;">Content Management System &amp; Enterprise Project Inquiries</p>
  </div>
  <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
    <a href="blog-create.php" class="btn-adm btn-adm-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      <span>New Blog Post</span>
    </a>
    <a href="case-study-create.php" class="btn-adm btn-adm-secondary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      <span>New Case Study</span>
    </a>
    <a href="media.php" class="btn-adm btn-adm-secondary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
      <span>Upload Media</span>
    </a>
  </div>
</div>

<!-- Stats Grid -->
<div class="admin-stats-grid">
  <div class="admin-stat-box">
    <div class="admin-stat-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    </div>
    <div>
      <div class="admin-stat-val"><?= $blogCount ?></div>
      <div class="admin-stat-lbl">Blogs (<?= $publishedBlogCount ?> live)</div>
    </div>
  </div>

  <div class="admin-stat-box">
    <div class="admin-stat-icon" style="background-color: rgba(59, 130, 246, 0.15); color: #60A5FA;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
    </div>
    <div>
      <div class="admin-stat-val"><?= $caseCount ?></div>
      <div class="admin-stat-lbl">Case Studies (<?= $publishedCaseCount ?> live)</div>
    </div>
  </div>

  <div class="admin-stat-box">
    <div class="admin-stat-icon" style="background-color: rgba(239, 68, 68, 0.15); color: #F87171;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
    </div>
    <div>
      <div class="admin-stat-val"><?= $diagCount ?></div>
      <div class="admin-stat-lbl">Audits (<?= $pendingDiagCount ?> pending)</div>
    </div>
  </div>

  <div class="admin-stat-box">
    <div class="admin-stat-icon" style="background-color: rgba(16, 185, 129, 0.15); color: #34D399;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>
    <div>
      <div class="admin-stat-val"><?= $contactCount ?></div>
      <div class="admin-stat-lbl">Project Inquiries</div>
    </div>
  </div>
</div>

<!-- Two-Column Overview: Recent Content -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(460px, 1fr)); gap: 1.75rem; margin-bottom: 2rem;">
  
  <!-- Recent Blogs -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Recent Blog Articles</h3>
      <a href="blogs.php" class="btn-adm btn-adm-secondary btn-adm-sm">View All &rarr;</a>
    </div>
    <?php if (empty($recentBlogs)): ?>
      <p style="color: var(--adm-text-dim); text-align: center; padding: 2rem 0;">No blog articles found. Create your first post!</p>
    <?php else: ?>
      <div class="admin-table-wrapper">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentBlogs as $rb): ?>
              <tr>
                <td>
                  <a href="blog-edit.php?id=<?= $rb['id'] ?>" style="color: #ffffff; text-decoration: none; font-weight: 600;">
                    <?= e(mb_strimwidth($rb['title'], 0, 40, '...')) ?>
                  </a>
                </td>
                <td><span style="font-size: 0.8rem; color: var(--adm-text-muted);"><?= e($rb['category']) ?></span></td>
                <td>
                  <span class="status-pill status-<?= $rb['status'] === 'published' ? 'published' : 'draft' ?>">
                    <?= e($rb['status']) ?>
                  </span>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <a href="blog-edit.php?id=<?= $rb['id'] ?>" class="btn-adm btn-adm-secondary btn-adm-sm">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <!-- Recent Case Studies -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title">Recent Case Studies</h3>
      <a href="case-studies.php" class="btn-adm btn-adm-secondary btn-adm-sm">View All &rarr;</a>
    </div>
    <?php if (empty($recentCases)): ?>
      <p style="color: var(--adm-text-dim); text-align: center; padding: 2rem 0;">No case studies found.</p>
    <?php else: ?>
      <div class="admin-table-wrapper">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Title / Client</th>
              <th>Industry</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentCases as $rc): ?>
              <tr>
                <td>
                  <a href="case-study-edit.php?id=<?= $rc['id'] ?>" style="color: #ffffff; text-decoration: none; font-weight: 600;">
                    <?= e(mb_strimwidth($rc['title'], 0, 36, '...')) ?>
                  </a>
                  <?php if (!empty($rc['client_name'])): ?>
                    <div style="font-size: 0.74rem; color: var(--adm-teal);"><?= e($rc['client_name']) ?></div>
                  <?php endif; ?>
                </td>
                <td><span style="font-size: 0.8rem; color: var(--adm-text-muted);"><?= e($rc['industry'] ?? 'Enterprise') ?></span></td>
                <td>
                  <span class="status-pill status-<?= $rc['status'] === 'published' ? 'published' : 'draft' ?>">
                    <?= e($rc['status']) ?>
                  </span>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <a href="case-study-edit.php?id=<?= $rc['id'] ?>" class="btn-adm btn-adm-secondary btn-adm-sm">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

</div>

<!-- Digital Audit Intake Pipeline -->
<div class="admin-card">
  <div class="admin-card-header">
    <div>
      <h3 class="admin-card-title">Digital Audit Intake Queue</h3>
      <p style="margin: 0.25rem 0 0; color: var(--adm-text-muted); font-size: 0.82rem;">Incoming client requests, technical domain telemetry, and review status</p>
    </div>
    <span class="status-pill status-published">Active Pipeline</span>
  </div>

  <?php if (empty($diagnostics)): ?>
    <p style="color: var(--adm-text-dim); text-align: center; padding: 2rem 0;">No digital audit requests logged yet.</p>
  <?php else: ?>
    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Ref #</th>
            <th>Company &amp; Lead</th>
            <th>Website URL</th>
            <th>Score</th>
            <th>Status</th>
            <th>Update Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($diagnostics as $d): ?>
            <tr>
              <td>
                <span style="font-family: var(--adm-font-mono); font-weight: 700; color: var(--adm-teal); font-size: 0.8rem;">
                  <?= e($d['reference_no']) ?>
                </span>
                <div style="font-size: 0.72rem; color: var(--adm-text-dim);"><?= e(date('M d, H:i', strtotime($d['created_at']))) ?></div>
              </td>
              <td>
                <div style="font-weight: 600; color: #ffffff;"><?= e($d['company_name']) ?></div>
                <div style="font-size: 0.78rem; color: var(--adm-text-muted);"><?= e($d['contact_name']) ?> &bull; <?= e($d['work_email']) ?></div>
              </td>
              <td>
                <?php if (!empty($d['website_url'])): ?>
                  <a href="<?= safeUrl($d['website_url']) ?>" target="_blank" rel="noopener" style="color: var(--adm-teal); text-decoration: underline; font-size: 0.82rem;">
                    <?= e(mb_strimwidth($d['website_url'], 0, 30, '...')) ?>
                  </a>
                <?php else: ?>
                  <span style="color: var(--adm-text-dim); font-size: 0.8rem;">Not provided</span>
                <?php endif; ?>
              </td>
              <td>
                <span style="font-family: var(--adm-font-display); font-weight: 800; font-size: 1rem; color: <?= (int)$d['health_score'] >= 75 ? '#34D399' : ((int)$d['health_score'] >= 50 ? '#FBBF24' : '#F87171') ?>;">
                  <?= (int)$d['health_score'] ?>/100
                </span>
              </td>
              <td>
                <span class="status-pill status-<?= $d['status'] === 'completed' ? 'published' : ($d['status'] === 'archived' ? 'archived' : 'draft') ?>">
                  <?= e($d['status']) ?>
                </span>
              </td>
              <td>
                <form method="POST" style="display: flex; gap: 0.4rem; align-items: center;">
                  <input type="hidden" name="action" value="update_diagnostic_status">
                  <input type="hidden" name="id" value="<?= $d['id'] ?>">
                  <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                  <select name="status" class="adm-select" style="padding: 0.25rem 0.5rem; font-size: 0.76rem; width: auto;">
                    <option value="pending" <?= $d['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_review" <?= $d['status'] === 'in_review' ? 'selected' : '' ?>>In Review</option>
                    <option value="prescribed" <?= $d['status'] === 'prescribed' ? 'selected' : '' ?>>Prescribed</option>
                    <option value="completed" <?= $d['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="archived" <?= $d['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                  </select>
                  <button type="submit" class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 0.25rem 0.5rem; font-size: 0.74rem;">
                    Save
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Project Contact Inquiries -->
<div class="admin-card">
  <div class="admin-card-header">
    <div>
      <h3 class="admin-card-title">Recent Direct Contact Inquiries</h3>
      <p style="margin: 0.25rem 0 0; color: var(--adm-text-muted); font-size: 0.82rem;">Inbound consultation requests via contact form</p>
    </div>
    <span class="status-pill status-published"><?= $contactCount ?> Total</span>
  </div>

  <?php if (empty($contacts)): ?>
    <p style="color: var(--adm-text-dim); text-align: center; padding: 2rem 0;">No inquiries received yet.</p>
  <?php else: ?>
    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name &amp; Organization</th>
            <th>Email &amp; Phone</th>
            <th>Service Interest</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contacts as $co): ?>
            <tr>
              <td style="white-space: nowrap; font-family: var(--adm-font-mono); font-size: 0.76rem; color: var(--adm-text-dim);">
                <?= e(date('M d, Y', strtotime($co['created_at']))) ?>
              </td>
              <td>
                <div style="font-weight: 600; color: #ffffff;"><?= e($co['full_name']) ?></div>
                <div style="font-size: 0.75rem; color: var(--adm-teal);"><?= e($co['organization'] ?: 'Direct Client') ?></div>
              </td>
              <td>
                <div><a href="mailto:<?= e($co['email']) ?>" style="color: var(--adm-text); text-decoration: none;"><?= e($co['email']) ?></a></div>
                <div style="font-size: 0.75rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);"><?= e($co['phone'] ?: 'No phone') ?></div>
              </td>
              <td>
                <span class="status-pill status-published" style="background: rgba(6, 181, 249, 0.1); color: var(--adm-teal); border: 1px solid rgba(6, 181, 249,0.25);">
                  <?= e($co['service_interest']) ?>
                </span>
              </td>
              <td style="max-width: 280px; font-size: 0.82rem; color: var(--adm-text-muted);">
                <?= e(mb_strimwidth($co['message'], 0, 80, '...')) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
