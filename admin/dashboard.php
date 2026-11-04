<?php
/**
 * BusinessDoctor Executive Admin Dashboard - IT & Digital Services
 * Client Project Console & Digital Audit Pipeline
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Auth Protection
if (empty($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

$pdo = Database::getConnection();
$message = '';

// Handle Status Updates with CSRF Verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_diagnostic_status') {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $message = "Security session expired. Status update rejected.";
        } else {
            $id = (int)($_POST['id'] ?? 0);
            $newStatus = trim($_POST['status'] ?? 'pending');
            $allowed = ['pending', 'in_review', 'prescribed', 'completed', 'archived'];
            if ($id > 0 && in_array($newStatus, $allowed, true)) {
                $stmt = $pdo->prepare("UPDATE diagnostic_requests SET status = ? WHERE id = ?");
                $stmt->execute([$newStatus, $id]);
                $message = "Audit request #{$id} status updated to '{$newStatus}'.";
            }
        }
    }
}

// Fetch Metrics
$diagCount = $pdo->query("SELECT COUNT(*) FROM diagnostic_requests")->fetchColumn();
$pendingDiagCount = $pdo->query("SELECT COUNT(*) FROM diagnostic_requests WHERE status = 'pending'")->fetchColumn();
$contactCount = $pdo->query("SELECT COUNT(*) FROM contact_inquiries")->fetchColumn();
$subCount = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE is_active = 1")->fetchColumn();

// Fetch Latest Audit Submissions
$diagnostics = $pdo->query("SELECT * FROM diagnostic_requests ORDER BY created_at DESC LIMIT 50")->fetchAll();

// Fetch Latest Contact Inquiries
$contacts = $pdo->query("SELECT * FROM contact_inquiries ORDER BY created_at DESC LIMIT 20")->fetchAll();

// Fetch Latest Newsletter Subscribers
$subscribers = $pdo->query("SELECT * FROM newsletter_subscribers ORDER BY created_at DESC LIMIT 20")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Projects Console — BusinessDoctor</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/variables.css">
  <link rel="stylesheet" href="../assets/css/base.css">
  <link rel="stylesheet" href="../assets/css/components.css">
  <style>
    body { background-color: #061326 !important; color: #F4F8FC !important; }
    .admin-nav { background: #071A2C; color: #F4F8FC; padding: 1.25rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0, 201, 193, 0.20); }
    .admin-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      margin-top: 2rem;
      margin-bottom: 2.5rem;
    }
    .admin-stat-card { background: #0D223A; border: 1px solid rgba(0, 201, 193, 0.20); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--shadow-sm); color: #F4F8FC; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; background: #0D223A; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid rgba(0, 201, 193, 0.20); }
    .data-table th { background: #071A2C; color: #00C9C1; font-family: var(--font-mono); font-size: 0.75rem; text-transform: uppercase; padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid rgba(0, 201, 193, 0.20); }
    .data-table td { padding: 1rem 1.25rem; border-bottom: 1px solid rgba(0, 201, 193, 0.12); vertical-align: middle; color: #F4F8FC; }
    .data-table tr:hover { background-color: #073B42; }
  </style>
</head>
<body style="background-color: #061326; color: #F4F8FC;">

  <!-- Admin Nav -->
  <header class="admin-nav">
    <div style="display: flex; align-items: center; gap: 1rem;">
      <a href="../index.php" class="brand-logo" style="color: #ffffff;">
        <div class="brand-symbol">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <polyline points="16 18 22 12 16 6"/>
            <polyline points="8 6 2 12 8 18"/>
          </svg>
        </div>
        <span>Business<span class="brand-text-accent">Doctor</span></span>
      </a>
      <span class="pill-tag dark" style="font-size: 0.72rem;">CLIENT PROJECTS CONSOLE</span>
    </div>

    <div style="display: flex; align-items: center; gap: 1.5rem;">
      <div style="font-size: 0.88rem; color: var(--color-slate-300);">
        Signed in as: <strong style="color: #ffffff;"><?= e($_SESSION['admin_user']['full_name']) ?></strong>
      </div>
      <a href="../index.php" target="_blank" class="btn btn-secondary btn-sm" style="background: transparent; color: #ffffff; border-color: rgba(255,255,255,0.2);">
        View Website ↗
      </a>
      <a href="logout.php" class="btn btn-primary btn-sm">
        Sign Out
      </a>
    </div>
  </header>

  <div class="container" style="padding-top: 2.5rem; padding-bottom: 4rem;">

    <?php if ($message): ?>
      <div class="form-alert <?= stripos($message, 'rejected') !== false || stripos($message, 'expired') !== false ? 'error' : 'success' ?>">
        <?= e($message) ?>
      </div>
    <?php endif; ?>

    <!-- Overview Statistics -->
    <div class="admin-stats">
      <div class="admin-stat-card">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-slate-500); text-transform: uppercase;">Total Digital Audits</div>
        <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--color-slate-900); margin-top: 0.25rem;">
          <?= $diagCount ?>
        </div>
      </div>
      <div class="admin-stat-card">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #dc2626; text-transform: uppercase;">Pending Review</div>
        <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: #dc2626; margin-top: 0.25rem;">
          <?= $pendingDiagCount ?>
        </div>
      </div>
      <div class="admin-stat-card">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-slate-500); text-transform: uppercase;">Project Inquiries</div>
        <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--color-slate-900); margin-top: 0.25rem;">
          <?= $contactCount ?>
        </div>
      </div>
      <div class="admin-stat-card">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-teal-600); text-transform: uppercase;">Newsletter Subscribers</div>
        <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--color-teal-600); margin-top: 0.25rem;">
          <?= $subCount ?>
        </div>
      </div>
    </div>

    <!-- 1. Audit Requests Pipeline -->
    <div style="margin-bottom: 3.5rem;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
        <div>
          <h2 style="font-size: 1.4rem;">Website & Digital Audit Intake Queue</h2>
          <p style="font-size: 0.9rem; color: var(--color-slate-500); margin: 0;">Incoming client audit requests, real domain telemetry, readiness scores and review statuses.</p>
        </div>
        <span class="pill-tag" style="font-size: 0.75rem;">Database Storage: Active</span>
      </div>

      <?php if (empty($diagnostics)): ?>
        <div class="card" style="text-align: center; padding: 3rem; color: var(--color-slate-500);">
          No audit requests registered yet. Requests submitted from the homepage or audit page will appear here immediately.
        </div>
      <?php else: ?>
        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Ref No</th>
                <th>Company / Domain</th>
                <th>Client Contact</th>
                <th>Primary Need</th>
                <th>Revenue</th>
                <th>Readiness Score</th>
                <th>Telemetry & Scope Summary</th>
                <th>Status</th>
                <th>Received</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($diagnostics as $row): ?>
                <tr>
                  <td>
                    <strong style="font-family: var(--font-mono); color: var(--color-teal-600);"><?= e($row['reference_no']) ?></strong>
                  </td>
                  <td>
                    <strong><?= e($row['company_name']) ?></strong>
                    <?php if (!empty($row['website_url'])): ?>
                      <div style="font-size: 0.78rem; color: var(--color-slate-500);">
                        <a href="<?= e(safeUrl($row['website_url'])) ?>" target="_blank" rel="noopener noreferrer" style="color: var(--color-slate-500);">
                          <?= e($row['website_url']) ?> ↗
                        </a>
                      </div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div><?= e($row['contact_name']) ?></div>
                    <div style="font-size: 0.78rem; color: var(--color-slate-500);"><?= e($row['work_email']) ?></div>
                    <?php if (!empty($row['phone'])): ?>
                      <div style="font-size: 0.75rem; color: var(--color-slate-400);"><?= e($row['phone']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="pill-tag" style="font-size: 0.7rem;">
                      <?= e(ucfirst(str_replace('_', ' ', $row['primary_bottleneck']))) ?>
                    </span>
                  </td>
                  <td>
                    <span style="font-size: 0.82rem; font-family: var(--font-mono); color: var(--color-slate-700);">
                      <?= e(str_replace('_', ' ', $row['revenue_bracket'])) ?>
                    </span>
                  </td>
                  <td>
                    <span style="font-family: var(--font-display); font-weight: 800; font-size: 1.1rem; color: <?= $row['health_score'] < 60 ? '#ef4444' : '#0d9488' ?>;">
                      <?= (int)$row['health_score'] ?>%
                    </span>
                  </td>
                  <td style="font-size: 0.78rem; max-width: 260px; color: var(--color-slate-600); line-height: 1.4;">
                    <?= e($row['diagnostic_summary'] ?: '—') ?>
                  </td>
                  <td>
                    <form method="POST" action="dashboard.php" style="display: flex; gap: 0.35rem; align-items: center;">
                      <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                      <input type="hidden" name="action" value="update_diagnostic_status">
                      <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                      <select name="status" onchange="this.form.submit()" class="form-select" style="padding: 0.35rem 0.65rem; font-size: 0.8rem; border-radius: var(--radius-sm);">
                        <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending Review</option>
                        <option value="in_review" <?= $row['status'] === 'in_review' ? 'selected' : '' ?>>In Review</option>
                        <option value="prescribed" <?= $row['status'] === 'prescribed' ? 'selected' : '' ?>>Scope Sent</option>
                        <option value="completed" <?= $row['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="archived" <?= $row['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
                      </select>
                    </form>
                  </td>
                  <td style="font-size: 0.8rem; color: var(--color-slate-500); font-family: var(--font-mono);">
                    <?= formatExecutiveDate($row['created_at']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <!-- 2. Direct Contact Inquiries -->
    <div style="margin-bottom: 3.5rem;">
      <h2 style="font-size: 1.4rem; margin-bottom: 1.25rem;">Direct Project Proposals & Inquiries</h2>
      <?php if (empty($contacts)): ?>
        <div class="card" style="text-align: center; padding: 2.5rem; color: var(--color-slate-500);">
          No consultation messages received yet.
        </div>
      <?php else: ?>
        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Client Name</th>
                <th>Email / Phone</th>
                <th>Organization</th>
                <th>Service Interest</th>
                <th>Message Excerpt</th>
                <th>Received</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($contacts as $c): ?>
                <tr>
                  <td><strong><?= e($c['full_name']) ?></strong></td>
                  <td>
                    <div><?= e($c['email']) ?></div>
                    <?php if (!empty($c['phone'])): ?>
                      <div style="font-size: 0.75rem; color: var(--color-slate-500);"><?= e($c['phone']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td><?= e($c['organization'] ?: '—') ?></td>
                  <td><span class="pill-tag" style="font-size: 0.7rem;"><?= e($c['service_interest']) ?></span></td>
                  <td style="max-width: 300px; font-size: 0.85rem; color: var(--color-slate-600);"><?= e($c['message']) ?></td>
                  <td style="font-size: 0.8rem; color: var(--color-slate-500); font-family: var(--font-mono);"><?= formatExecutiveDate($c['created_at']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <!-- 3. Newsletter Subscribers -->
    <div>
      <h2 style="font-size: 1.4rem; margin-bottom: 1.25rem;">Tech Newsletter Subscribers</h2>
      <?php if (empty($subscribers)): ?>
        <div class="card" style="text-align: center; padding: 2rem; color: var(--color-slate-500);">
          No subscribers yet.
        </div>
      <?php else: ?>
        <table class="data-table">
          <thead>
            <tr>
              <th>Subscriber Email</th>
              <th>Channel Source</th>
              <th>IP Address</th>
              <th>Subscribed At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subscribers as $s): ?>
              <tr>
                <td><strong><?= e($s['email']) ?></strong></td>
                <td><span class="pill-tag" style="font-size: 0.7rem;"><?= e($s['source_page']) ?></span></td>
                <td style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-slate-500);"><?= e($s['ip_address'] ?: '—') ?></td>
                <td style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-slate-500);"><?= formatExecutiveDate($s['created_at']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

  </div>

</body>
</html>
