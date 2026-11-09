<?php
/**
 * BusinessDoctor Create Case Study
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$errors = [];
$title = '';
$slug = '';
$clientName = '';
$industry = 'Enterprise FinTech SaaS';
$serviceCategory = 'Web Development & Performance Marketing';
$baselineMetric = '';
$outcomeMetric = '';
$metricLabel = 'Verified Pipeline Growth';
$challenge = '';
$solution = '';
$implementation = '';
$results = '';
$quoteText = '';
$quoteAuthor = '';
$quoteTitle = '';
$featuredImage = '';
$coverImageAlt = '';
$gallery = '';
$isFeatured = 0;
$sortOrder = 0;
$seoTitle = '';
$seoDescription = '';
$status = 'published';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Security token expired or invalid. Please refresh and retry.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $requestedSlug = trim($_POST['slug'] ?? '');
        $clientName = trim($_POST['client_name'] ?? '');
        $industry = trim($_POST['industry'] ?? 'Enterprise Software');
        $serviceCategory = trim($_POST['service_category'] ?? 'Custom Web Engineering');
        $baselineMetric = trim($_POST['baseline_metric'] ?? '');
        $outcomeMetric = trim($_POST['outcome_metric'] ?? '');
        $metricLabel = trim($_POST['metric_label'] ?? 'Verified Growth');
        $challenge = trim($_POST['challenge'] ?? '');
        $solution = trim($_POST['solution'] ?? '');
        $implementation = trim($_POST['implementation'] ?? '');
        $results = trim($_POST['results'] ?? '');
        $quoteText = trim($_POST['quote_text'] ?? '');
        $quoteAuthor = trim($_POST['quote_author'] ?? '');
        $quoteTitle = trim($_POST['quote_title'] ?? '');
        $featuredImage = trim($_POST['featured_image'] ?? '');
        $coverImageAlt = trim($_POST['cover_image_alt'] ?? '');
        $gallery = trim($_POST['gallery'] ?? '');
        $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $seoTitle = trim($_POST['seo_title'] ?? '');
        $seoDescription = trim($_POST['seo_description'] ?? '');
        $status = ($_POST['submit_action'] === 'draft') ? 'draft' : 'published';

        if ($title === '') $errors[] = 'Case Study Title is required.';
        if ($challenge === '') $errors[] = 'The Challenge description is required.';
        if ($solution === '') $errors[] = 'The Solution / Architecture description is required.';

        // Handle Direct File Upload if submitted
        if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image_file'];
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($mime, $allowedMimes, true) || !in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $errors[] = 'Invalid image format. Allowed formats: JPG, JPEG, PNG, WebP only.';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $errors[] = 'Image size exceeds maximum limit of 5 MB.';
            } else {
                $uploadDir = ROOT_PATH . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $safeName = 'case_' . bin2hex(random_bytes(10)) . '.' . $ext;
                $destPath = $uploadDir . DIRECTORY_SEPARATOR . $safeName;
                if (move_uploaded_file($file['tmp_name'], $destPath)) {
                    $featuredImage = 'assets/uploads/' . $safeName;
                    $medStmt = $pdo->prepare("INSERT INTO media (filename, original_name, file_path, file_size, mime_type) VALUES (?, ?, ?, ?, ?)");
                    $medStmt->execute([$safeName, $file['name'], $featuredImage, $file['size'], $mime]);
                } else {
                    $errors[] = 'Failed to save uploaded image.';
                }
            }
        }

        // Generate Unique Slug
        if (empty($errors)) {
            $slugBase = !empty($requestedSlug) ? $requestedSlug : $title;
            $finalSlug = generateUniqueSlug($slugBase, 'case_studies');

            if ($seoTitle === '') $seoTitle = $title;
            if ($seoDescription === '') $seoDescription = mb_strimwidth($challenge, 0, 160, '...');

            $now = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare("
                INSERT INTO case_studies 
                (slug, title, client_name, client_industry, industry, practice_area, service_category,
                 project_summary, baseline_metric, outcome_metric, metric_label, challenge, 
                 prescription, solution, implementation, result_description, results, 
                 featured_image, cover_image_alt, gallery, quote_text, quote_author, quote_title, 
                 seo_title, seo_description, status, is_featured, sort_order, 
                 published_at, created_at, updated_at, is_deleted)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
            ");

            $stmt->execute([
                $finalSlug,
                $title,
                $clientName,
                $industry, // client_industry
                $industry, // industry
                $serviceCategory, // practice_area
                $serviceCategory, // service_category
                $challenge, // project_summary
                $baselineMetric,
                $outcomeMetric,
                $metricLabel,
                $challenge,
                $solution, // prescription
                $solution, // solution
                $implementation,
                $results ?: $outcomeMetric, // result_description
                $results, // results
                $featuredImage,
                $coverImageAlt,
                $gallery,
                $quoteText,
                $quoteAuthor,
                $quoteTitle,
                $seoTitle,
                $seoDescription,
                $status,
                $isFeatured,
                $sortOrder,
                $now,
                $now,
                $now
            ]);

            require_once __DIR__ . '/../includes/seo-sync.php';
            SeoSyncEngine::syncAll("Case Study created: {$title}");
            setFlashMessage('success', "Case study '{$title}' created successfully as " . strtoupper($status) . ".");
            header('Location: case-studies.php');
            exit;
        }
    }
}

// Media library images for quick picker
$mediaList = $pdo->query("SELECT file_path, original_name FROM media ORDER BY id DESC LIMIT 24")->fetchAll();

$pageTitle = 'Create Client Case Study';
require_once __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.4rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem; font-family: var(--adm-font-display);">
      Create Client Case Study
    </h2>
    <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.85rem;">
      Document a client transformation, baseline bottlenecks, engineering architecture, and verified business outcomes.
    </p>
  </div>
  <a href="case-studies.php" class="btn-adm btn-adm-secondary">
    &larr; Back to Case Studies List
  </a>
</div>

<?php if (!empty($errors)): ?>
  <div class="adm-toast error" style="margin-bottom: 1.5rem; max-width: 100%;">
    <div>
      <strong>Please correct the following:</strong>
      <ul style="margin: 0.35rem 0 0; padding-left: 1.25rem;">
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>

<form method="POST" action="case-study-create.php" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

  <div class="adm-form-grid">
    
    <!-- Main Column -->
    <div>
      
      <!-- Primary Details Card -->
      <div class="admin-card">
        <div class="adm-form-group">
          <label class="adm-label" for="caseTitle">
            Project / Transformation Title <span class="required">*</span>
          </label>
          <input type="text" id="caseTitle" name="title" value="<?= e($title) ?>" required placeholder="e.g. Custom E-Commerce Architecture: Sub-Second Load &amp; 162% Revenue Surge" class="adm-input" style="font-size: 1.05rem; font-weight: 600;">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="caseSlug">
            URL Slug <span class="required">*</span>
          </label>
          <input type="text" id="caseSlug" name="slug" value="<?= e($slug) ?>" data-slug-from="caseTitle" placeholder="custom-ecommerce-architecture-sub-second-load" class="adm-input" style="font-family: var(--adm-font-mono); font-size: 0.85rem;">
          <div class="adm-hint">Auto-generated from title. Duplicate slugs are automatically resolved with a unique suffix.</div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group">
            <label class="adm-label" for="clientName">Client / Company Name</label>
            <input type="text" id="clientName" name="client_name" value="<?= e($clientName) ?>" placeholder="e.g. AURA Atelier" class="adm-input">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="caseIndustry">Industry</label>
            <input type="text" id="caseIndustry" name="industry" value="<?= e($industry) ?>" placeholder="e.g. Luxury D2C &amp; Apparel" class="adm-input">
          </div>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="caseChallenge">
            01 // The Challenge &amp; Roadblocks <span class="required">*</span>
          </label>
          <textarea id="caseChallenge" name="challenge" rows="5" required placeholder="Describe the client's initial situation, pain points, website bottlenecks, and performance challenges..." class="adm-textarea"><?= e($challenge) ?></textarea>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="caseSolution">
            02 // The Solution &amp; Engineering Architecture <span class="required">*</span>
          </label>
          <textarea id="caseSolution" name="solution" rows="7" required placeholder="Detail the custom technical architecture, stack upgrades, optimizations, and strategy deployed by BusinessDoctor..." class="adm-textarea"><?= e($solution) ?></textarea>
        </div>

        <div class="adm-form-group" style="margin-bottom: 0;">
          <label class="adm-label" for="caseResults">
            03 // Implementation &amp; Measured Impact
          </label>
          <textarea id="caseResults" name="results" rows="5" placeholder="Summary of outcomes achieved, revenue generated, latency improvements, and conversion metrics..." class="adm-textarea"><?= e($results) ?></textarea>
        </div>
      </div>

      <!-- Verified Transformation Metrics Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Verified Outcome Metrics</h3>
        <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin: 0 0 1.25rem;">These figures power the high-impact visual banners on case study pages and homepage cards.</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="baseMetric">Baseline Status</label>
            <input type="text" id="baseMetric" name="baseline_metric" value="<?= e($baselineMetric) ?>" placeholder="e.g. 4.8s Load / 0.8% Conv" class="adm-input" style="font-family: var(--adm-font-mono);">
            <div class="adm-hint">Shown in red / strikethrough</div>
          </div>

          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="outMetric">Verified Outcome</label>
            <input type="text" id="outMetric" name="outcome_metric" value="<?= e($outcomeMetric) ?>" placeholder="e.g. 0.6s Load / 3.4% Conv" class="adm-input" style="font-family: var(--adm-font-mono); color: #34D399; font-weight: 700;">
            <div class="adm-hint">Highlighted outcome stat</div>
          </div>

          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="metLabel">Measured Impact Label</label>
            <input type="text" id="metLabel" name="metric_label" value="<?= e($metricLabel) ?>" placeholder="e.g. Revenue &amp; Speed Scaling" class="adm-input">
            <div class="adm-hint">Short label beneath stat</div>
          </div>
        </div>
      </div>

      <!-- Client Quote Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Client Executive Testimonial</h3>
        
        <div class="adm-form-group">
          <label class="adm-label" for="quoteText">Testimonial Quote</label>
          <textarea id="quoteText" name="quote_text" rows="3" placeholder="&ldquo;BusinessDoctor solved what three previous agencies couldn't...&rdquo;" class="adm-textarea"><?= e($quoteText) ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="quoteAuthor">Author Name</label>
            <input type="text" id="quoteAuthor" name="quote_author" value="<?= e($quoteAuthor) ?>" placeholder="e.g. Marcus Vance" class="adm-input">
          </div>

          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="quoteTitle">Author Title / Role</label>
            <input type="text" id="quoteTitle" name="quote_title" value="<?= e($quoteTitle) ?>" placeholder="e.g. Chief Revenue Officer" class="adm-input">
          </div>
        </div>
      </div>

    </div>

    <!-- Sidebar Column -->
    <div>
      
      <!-- Publish Action Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Publishing Actions</h3>
        
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
          <button type="submit" name="submit_action" value="published" class="btn-adm btn-adm-primary" style="width: 100%; padding: 0.75rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Publish Case Study</span>
          </button>
          
          <button type="submit" name="submit_action" value="draft" class="btn-adm btn-adm-secondary" style="width: 100%; padding: 0.75rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
            <span>Save as Draft</span>
          </button>
        </div>
      </div>

      <!-- Settings & Placement Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Placement &amp; Taxonomy</h3>
        
        <div class="adm-form-group">
          <label class="adm-label" for="caseCategory">Practice Area / Service</label>
          <select id="caseCategory" name="service_category" class="adm-select">
            <option value="Web Development &amp; Performance Marketing" <?= $serviceCategory === 'Web Development & Performance Marketing' ? 'selected' : '' ?>>Web Development &amp; Performance Marketing</option>
            <option value="Web Development &amp; UI/UX Design" <?= $serviceCategory === 'Web Development & UI/UX Design' ? 'selected' : '' ?>>Web Development &amp; UI/UX Design</option>
            <option value="E-Commerce &amp; Marketplace Management" <?= $serviceCategory === 'E-Commerce & Marketplace Management' ? 'selected' : '' ?>>E-Commerce &amp; Marketplace Management</option>
            <option value="Custom Web Engineering" <?= $serviceCategory === 'Custom Web Engineering' ? 'selected' : '' ?>>Custom Web Engineering</option>
            <option value="Cloud Solutions &amp; DevOps" <?= $serviceCategory === 'Cloud Solutions & DevOps' ? 'selected' : '' ?>>Cloud Solutions &amp; DevOps</option>
          </select>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
            <input type="checkbox" name="is_featured" value="1" <?= $isFeatured ? 'checked' : '' ?> style="width: 16px; height: 16px; accent-color: var(--adm-teal);">
            <span>Feature on Homepage Showcase</span>
          </label>
          <div class="adm-hint">Featured case studies appear in the verified impact section on the homepage.</div>
        </div>

        <div class="adm-form-group" style="margin-bottom: 0;">
          <label class="adm-label" for="sortOrder">Sort Priority (0 = Default)</label>
          <input type="number" id="sortOrder" name="sort_order" value="<?= $sortOrder ?>" class="adm-input" style="font-family: var(--adm-font-mono);">
        </div>
      </div>

      <!-- Featured Image Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Project Cover Image</h3>
        
        <div class="adm-form-group">
          <label class="adm-label">Upload Cover Image (JPG, PNG, WebP &le; 5MB)</label>
          <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp" class="adm-input" id="caseImageFileInput">
        </div>

        <!-- Internally Managed Image Path (Not manually editable) -->
        <input type="hidden" id="featuredImagePath" name="featured_image" value="<?= e($featuredImage) ?>">

        <div class="adm-form-group">
          <label class="adm-label" for="coverImageAlt">Cover Image Alt Text</label>
          <input type="text" id="coverImageAlt" name="cover_image_alt" value="<?= e($coverImageAlt) ?>" placeholder="e.g. Enterprise dashboard transformation architecture" class="adm-input">
          <div class="adm-hint">Descriptive accessibility and SEO alt text for the project cover image.</div>
        </div>

        <?php if (!empty($mediaList)): ?>
          <div>
            <div style="font-size: 0.78rem; font-weight: 600; color: var(--adm-text-dim); margin-bottom: 0.4rem; font-family: var(--adm-font-mono);">SELECT FROM MEDIA LIBRARY:</div>
            <div style="display: flex; gap: 0.4rem; overflow-x: auto; padding-bottom: 0.5rem;">
              <?php foreach ($mediaList as $m): ?>
                <img src="../<?= e($m['file_path']) ?>" alt="<?= e($m['original_name']) ?>" style="width: 48px; height: 38px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 1px solid var(--adm-border);" onclick="document.getElementById('featuredImagePath').value = '<?= e($m['file_path']) ?>'; window.showToast('Selected image: <?= e($m['original_name']) ?>', 'info');">
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Gallery Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Image Gallery (Optional)</h3>
        <div class="adm-form-group" style="margin-bottom: 0;">
          <label class="adm-label" for="caseGallery">Gallery Image Paths (One per line)</label>
          <textarea id="caseGallery" name="gallery" rows="3" placeholder="assets/uploads/screen1.webp&#10;assets/uploads/screen2.webp" class="adm-textarea" style="font-family: var(--adm-font-mono); font-size: 0.8rem;"><?= e($gallery) ?></textarea>
        </div>
      </div>

    </div>

  </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

