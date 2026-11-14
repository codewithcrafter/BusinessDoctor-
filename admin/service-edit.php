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
        $number = trim($_POST['number'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $tagline = trim($_POST['tagline'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $seoTitle = trim($_POST['seo_title'] ?? '');
        $seoDescription = trim($_POST['seo_description'] ?? '');
        $featuredImage = trim($_POST['featured_image'] ?? '');
        $icon = trim($_POST['icon'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $rawDeliverables = trim($_POST['deliverables'] ?? '');
        $deliverablesArray = array_values(array_filter(array_map('trim', explode("\n", $rawDeliverables))));

        $rawKpis = trim($_POST['kpis'] ?? '');
        $kpisArray = array_values(array_filter(array_map('trim', explode("\n", $rawKpis))));

        $rawFaqs = trim($_POST['faqs'] ?? '');
        $faqsArray = [];
        if ($rawFaqs !== '') {
            $lines = explode("\n", $rawFaqs);
            foreach ($lines as $line) {
                $line = trim($line);
                if (str_contains($line, '|')) {
                    [$q, $a] = explode('|', $line, 2);
                    $faqsArray[] = ['q' => trim($q), 'a' => trim($a)];
                } elseif ($line !== '') {
                    $faqsArray[] = ['q' => $line, 'a' => ''];
                }
            }
        }

        if ($name === '') $errors[] = 'Service name cannot be empty.';
        if ($summary === '') $errors[] = 'Service summary cannot be empty.';
        if ($slug === '') $errors[] = 'Service slug cannot be empty.';

        if (empty($errors)) {
            // Update primary PDO connection
            $upd = $pdo->prepare("
                UPDATE services 
                SET number = ?, name = ?, short_title = ?, slug = ?, tagline = ?, summary = ?, description = ?, 
                    deliverables = ?, kpis = ?, icon = ?, seo_title = ?, seo_description = ?, faqs = ?, 
                    featured_image = ?, sort_order = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $upd->execute([
                $number,
                $name,
                $shortTitle,
                $slug,
                $tagline,
                $summary,
                $description,
                json_encode($deliverablesArray),
                json_encode($kpisArray),
                $icon,
                $seoTitle,
                $seoDescription,
                json_encode($faqsArray),
                $featuredImage,
                $sortOrder,
                $isActive,
                $id
            ]);

            // Also synchronize SQLite if primary was MySQL, or vice-versa
            try {
                $sqlitePath = ROOT_PATH . '/database/businessdoctor.sqlite';
                if (file_exists($sqlitePath)) {
                    $sqlitePdo = new PDO('sqlite:' . $sqlitePath);
                    $sqlitePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqliteUpd = $sqlitePdo->prepare("
                        UPDATE services 
                        SET number = ?, name = ?, short_title = ?, slug = ?, tagline = ?, summary = ?, description = ?, 
                            deliverables = ?, kpis = ?, icon = ?, seo_title = ?, seo_description = ?, faqs = ?, 
                            featured_image = ?, sort_order = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
                        WHERE slug = ? OR id = ?
                    ");
                    $sqliteUpd->execute([
                        $number, $name, $shortTitle, $slug, $tagline, $summary, $description,
                        json_encode($deliverablesArray), json_encode($kpisArray), $icon,
                        $seoTitle, $seoDescription, json_encode($faqsArray), $featuredImage,
                        $sortOrder, $isActive, $slug, $id
                    ]);
                }
            } catch (Throwable $t) {}

            setFlashMessage('success', "Service '{$name}' updated successfully.");
            require_once __DIR__ . '/../includes/seo-sync.php';
            SeoSyncEngine::syncAll("Service updated: {$name}");
            header("Location: services.php");
            exit;
        }
    }
}

$currentDeliverables = json_decode($service['deliverables'] ?? '[]', true) ?: [];
$deliverablesText = implode("\n", $currentDeliverables);

$currentKpis = json_decode($service['kpis'] ?? '[]', true) ?: [];
$kpisText = implode("\n", $currentKpis);

$currentFaqs = json_decode($service['faqs'] ?? '[]', true) ?: [];
$faqsText = '';
foreach ($currentFaqs as $faq) {
    $faqsText .= ($faq['q'] ?? '') . ' | ' . ($faq['a'] ?? '') . "\n";
}
$faqsText = trim($faqsText);

require_once __DIR__ . '/includes/header.php';
?>

<div class="adm-header">
  <div class="adm-header-title">
    <div class="adm-badge">DISCIPLINE // <?= e($service['number']) ?></div>
    <h1>Edit Service: <?= e($service['name']) ?></h1>
    <p class="adm-subtitle">Persistent multi-database storage. Changes immediately update public templates, mega menus, and Markdown mirrors.</p>
  </div>
  <div style="display: flex; gap: 0.75rem;">
    <a href="services.php" class="btn-adm btn-adm-secondary">Back to Services</a>
    <a href="<?= appUrl('company/' . $service['slug']) ?>" target="_blank" class="btn-adm btn-adm-secondary">View Live Page ↗</a>
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

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
          <div class="form-group">
            <label class="form-label" for="short_title">Short Title (Nav &amp; Badges)</label>
            <input type="text" id="short_title" name="short_title" class="form-control" value="<?= e($service['short_title']) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="number">Discipline Number (e.g. 01)</label>
            <input type="text" id="number" name="number" class="form-control" value="<?= e($service['number']) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="slug">Clean URL Slug</label>
            <input type="text" id="slug" name="slug" class="form-control" value="<?= e($service['slug']) ?>" required>
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
        <h3 class="adm-card-title">Deliverables &amp; Performance Benchmarks</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
          <div class="form-group">
            <label class="form-label" for="deliverables">Deliverables (One item per line)</label>
            <textarea id="deliverables" name="deliverables" class="form-control" rows="6"><?= e($deliverablesText) ?></textarea>
          </div>
          <div class="form-group">
            <label class="form-label" for="kpis">Target KPIs (One item per line)</label>
            <textarea id="kpis" name="kpis" class="form-control" rows="6"><?= e($kpisText) ?></textarea>
          </div>
        </div>
      </div>

      <div class="adm-card">
        <h3 class="adm-card-title">SEO &amp; Search Optimization</h3>
        <div class="form-group" style="margin-bottom: 1.25rem;">
          <label class="form-label" for="seo_title">Custom SEO Meta Title</label>
          <input type="text" id="seo_title" name="seo_title" class="form-control" value="<?= e($service['seo_title'] ?? '') ?>" placeholder="Defaults to: Service Name — BusinessDoctor">
        </div>
        <div class="form-group">
          <label class="form-label" for="seo_description">Custom SEO Meta Description</label>
          <textarea id="seo_description" name="seo_description" class="form-control" rows="3" placeholder="Defaults to Executive Summary"><?= e($service['seo_description'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="adm-card">
        <h3 class="adm-card-title">Frequently Asked Questions (FAQs)</h3>
        <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-bottom: 1rem;">
          Enter each FAQ on a new line using format: <code>Question | Answer</code>
        </p>
        <textarea id="faqs" name="faqs" class="form-control" rows="6" placeholder="What is the turnaround time? | Typically 2 to 3 weeks from kickoff."><?= e($faqsText) ?></textarea>
      </div>
    </div>

    <!-- Sidebar Settings -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
      <div class="adm-card">
        <h3 class="adm-card-title">Publication Status</h3>
        <label style="display: flex; align-items: center; gap: 0.65rem; cursor: pointer; margin-bottom: 1.25rem;">
          <input type="checkbox" name="is_active" value="1" <?= $service['is_active'] ? 'checked' : '' ?> style="width: 18px; height: 18px;">
          <span style="font-size: 0.95rem; color: #fff;">Service Active &amp; Discoverable</span>
        </label>

        <div class="form-group" style="margin-bottom: 1.25rem;">
          <label class="form-label" for="sort_order">Sort Order Priority</label>
          <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= (int)$service['sort_order'] ?>">
        </div>

        <button type="submit" class="btn-adm btn-adm-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
          <span>Save Changes to Database</span>
        </button>
      </div>

      <div class="adm-card">
        <h3 class="adm-card-title">Visual Branding &amp; Icon</h3>
        <div class="form-group" style="margin-bottom: 1rem;">
          <label class="form-label" for="featured_image">Featured Image URL</label>
          <input type="text" id="featured_image" name="featured_image" class="form-control" value="<?= e($service['featured_image'] ?? '') ?>" placeholder="assets/img/services/...">
        </div>
        <div class="form-group">
          <label class="form-label" for="icon">Lucide SVG Code</label>
          <textarea id="icon" name="icon" class="form-control" rows="4" style="font-family: var(--adm-font-mono); font-size: 0.75rem;"><?= e($service['icon'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="adm-card">
        <h3 class="adm-card-title">Database Metadata</h3>
        <div style="font-size: 0.82rem; color: var(--adm-text-muted); display: flex; flex-direction: column; gap: 0.5rem; font-family: var(--adm-font-mono);">
          <div>ID: <?= (int)$service['id'] ?></div>
          <div>DISCIPLINE: <?= e($service['number']) ?></div>
          <div>URL: <?= getServiceUrl($service['slug']) ?></div>
          <div>CREATED: <?= e($service['created_at']) ?></div>
          <div>UPDATED: <?= e($service['updated_at'] ?: 'N/A') ?></div>
        </div>
      </div>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
