<?php
/**
 * BusinessDoctor Executive Admin — Services Directory Manager
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$pdo = Database::getConnection();
$services = $pdo->query("SELECT * FROM services ORDER BY is_active DESC, sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/includes/header.php';
?>

<div class="adm-header">
  <div class="adm-header-title">
    <div class="adm-badge">CMS // PRACTICE AREAS</div>
    <h1>IT &amp; Digital Services Manager</h1>
    <p class="adm-subtitle">Manage all 10 practice areas, capabilities, descriptions, and deliverables across MySQL and SQLite storage.</p>
  </div>
  <div>
    <a href="service-create.php" class="btn-adm btn-adm-primary">
      <span>+ Add New Service</span>
    </a>
  </div>
</div>

<?php $flash = getFlashMessage(); if ($flash): ?>
  <div class="alert alert-<?= e($flash['type']) ?>" style="margin-bottom: 1.5rem; padding: 1rem 1.25rem; border-radius: 8px; background: rgba(6, 181, 249, 0.1); border: 1px solid var(--adm-teal); color: #fff;">
    <?= e($flash['message']) ?>
  </div>
<?php endif; ?>

<div class="adm-card">
  <div style="overflow-x: auto;">
    <table class="adm-table" style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="border-bottom: 1px solid var(--adm-border); text-align: left;">
          <th style="padding: 1rem; width: 60px;">No.</th>
          <th style="padding: 1rem;">Service Discipline</th>
          <th style="padding: 1rem;">Slug &amp; Route</th>
          <th style="padding: 1rem;">Status</th>
          <th style="padding: 1rem;">Last Updated</th>
          <th style="padding: 1rem; text-align: right; width: 140px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($services as $s): ?>
          <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
            <td style="padding: 1rem; font-family: var(--adm-font-mono); color: var(--adm-teal); font-weight: 700;">
              <?= e($s['number']) ?>
            </td>
            <td style="padding: 1rem;">
              <div style="font-weight: 700; color: #fff; font-size: 0.95rem;"><?= e($s['name']) ?></div>
              <div style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 0.25rem;"><?= e($s['tagline']) ?></div>
            </td>
            <td style="padding: 1rem; font-family: var(--adm-font-mono); font-size: 0.8rem; color: var(--adm-teal);">
              /services/<?= e($s['slug']) ?>
            </td>
            <td style="padding: 1rem;">
              <span class="status-pill <?= $s['is_active'] ? 'status-published' : 'status-draft' ?>">
                <?= $s['is_active'] ? 'Active' : 'Disabled' ?>
              </span>
            </td>
            <td style="padding: 1rem; font-family: var(--adm-font-mono); font-size: 0.8rem; color: var(--adm-text-muted);">
              <?= e($s['updated_at'] ?: $s['created_at']) ?>
            </td>
            <td style="padding: 1rem; text-align: right;">
              <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                <a href="<?= appUrl('services/' . $s['slug']) ?>" target="_blank" class="btn-adm btn-adm-secondary btn-adm-sm" title="View Public Page">
                  <span>View ↗</span>
                </a>
                <a href="service-edit.php?id=<?= (int)$s['id'] ?>" class="btn-adm btn-adm-primary btn-adm-sm">
                  <span>Edit</span>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>