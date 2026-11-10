<?php
/**
 * BusinessDoctor Executive Admin — Edit Service Discipline
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$pdo = Database::getConnection();
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    setFlashMessage('error', 'Service record not found.');
    header("Location: services.php");
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Security token expired. Please reload and try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $shortTitle = trim($_POST['short_title'] ?? '');
        $tagline = trim($_POST['tagline'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $rawDeliverables = trim($_POST['deliverables'] ?? '');
        $deliverablesArray = array_values(array_filter(array_map('trim', explode("\n", $rawDeliverables))));

        if ($name === '') $errors[] = 'Service name cannot be empty.';
        if ($summary === '') $errors[] = 'Service summary cannot be empty.';

        if (empty($errors)) {
            $upd = $pdo->prepare("
                UPDATE services 
                SET name = ?, short_title = ?, tagline = ?, summary = ?, description = ?, deliverables = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $upd->execute([
                $name,
                $shortTitle,
                $tagline,
                $summary,
                $description,
                json_encode($deliverablesArray),
                $isActive,
                $id
            ]);

            setFlashMessage('success', "Service '{$name}' updated successfully in SQLite database.");
            header("Location: services.php");
            exit;
        }
    }
}

$currentDeliverables = json_decode($service['deliverables'] ?? '[]', true) ?: [];
$deliverablesText = implode("\n", $currentDeliverables);

require_once __DIR__ . '/includes/header.php';
?>

<div class="adm-header">
  <div class="adm-header-title">
    <div class="adm-badge">DISCIPLINE // <?= e($service['number']) ?></div>
    <h1>Edit Service: <?= e($service['name']) ?></h1>
    <p class="adm-subtitle">Persistent SQLite storage. Changes immediately update public templates and API endpoints.</p>
  </div>
  <div style="display: flex; gap: 0.75rem;">
    <a href="services.php" class="btn-adm btn-adm-secondary">Back to Services</a>
    <a href="<?= appUrl('services/' . $service['slug']) ?>" target="_blank" class="btn-adm btn-adm-secondary">View Live Page ↗</a>
  </div>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-error" style="margin-bottom: 1.5rem; padding: 1rem 1.25rem; border-radius: 8px; background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fff;">
    <?php foreach ($errors as $err): ?>
      <div>● <?= e($err) ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<form method="POST" action="service-edit.php?id=<?= $id ?>">
  <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

  <div class="adm-editor-grid">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
      <div class="adm-card">
        <h3 class="adm-card-title">Core Service Information</h3>
        
        <div class="form-group" style="margin-bottom: 1.25rem;">
          <label class="form-label" for="name">Service Full Name</label>
          <input type="text" id="name" name="name" class="form-control" value="<?= e($service['name']) ?>" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
          <div class="form-group">
            <label class="form-label" for="short_title">Short Title (Nav &amp; Badges)</label>
            <input type="text" id="short_title" name="short_title" class="form-control" value="<?= e($service['short_title']) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="slug">Clean URL Slug (Read-only)</label>
            <input type="text" id="slug" class="form-control" value="<?= e($service['slug']) ?>" disabled style="opacity: 0.6;">
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
          <label class="form-label" for="tagline">Service Tagline / Subtitle</label>
          <input type="text" id="tagline" name="tagline" class="form-control" value="<?= e($service['tagline']) ?>">
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
          <label class="form-label" for="summary">Executive Summary (Cards &amp; Mega Menu)</label>
          <textarea id="summary" name="summary" class="form-control" rows="3" required><?= e($service['summary']) ?></textarea>
        </div>

        <div class="form-group">
          <label class="form-label" for="description">Full Service Description (Hero Section)</label>
          <textarea id="description" name="description" class="form-control" rows="5"><?= e($service['description']) ?></textarea>
        </div>
      </div>

      <div class="adm-card">
        <h3 class="adm-card-title">Deliverables (One item per line)</h3>
        <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-bottom: 1rem;">
          Enter each service deliverable on a new line. These are rendered across public service scope cards and contracts.
        </p>
        <textarea name="deliverables" class="form-control" rows="6"><?= e($deliverablesText) ?></textarea>
      </div>
    </div>

    <!-- Sidebar Settings -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
      <div class="adm-card">
        <h3 class="adm-card-title">Publication Status</h3>
        <label style="display: flex; align-items: center; gap: 0.65rem; cursor: pointer; margin-bottom: 1.5rem;">
          <input type="checkbox" name="is_active" value="1" <?= $service['is_active'] ? 'checked' : '' ?> style="width: 18px; height: 18px;">
          <span style="font-size: 0.95rem; color: #fff;">Service Active &amp; Discoverable</span>
        </label>

        <button type="submit" class="btn-adm btn-adm-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
          <span>Save Changes to Database</span>
        </button>
      </div>

      <div class="adm-card">
        <h3 class="adm-card-title">Database Metadata</h3>
        <div style="font-size: 0.82rem; color: var(--adm-text-muted); display: flex; flex-direction: column; gap: 0.5rem; font-family: var(--adm-font-mono);">
          <div>ID: <?= (int)$service['id'] ?></div>
          <div>DISCIPLINE: <?= e($service['number']) ?></div>
          <div>CREATED: <?= e($service['created_at']) ?></div>
          <div>UPDATED: <?= e($service['updated_at'] ?: 'N/A') ?></div>
        </div>
      </div>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>