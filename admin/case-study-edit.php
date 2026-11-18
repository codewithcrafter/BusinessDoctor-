<?php
/**
 * BusinessDoctor Edit Case Study
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: case-studies.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM case_studies WHERE id = ?");
$stmt->execute([$id]);
$case = $stmt->fetch();

if (!$case) {
    setFlashMessage('error', 'Case study not found.');
    header('Location: case-studies.php');
    exit;
}

$errors = [];
$title = $case['title'];
$slug = $case['slug'];
$clientName = $case['client_name'] ?? '';
$projectUrl = $case['project_url'] ?? '';
$industry = $case['industry'] ?: $case['client_industry'];
$serviceCategory = $case['service_category'] ?: $case['practice_area'];
$baselineMetric = $case['baseline_metric'] ?? '';
$outcomeMetric = $case['outcome_metric'] ?? '';
$metricLabel = $case['metric_label'] ?? '';
$challenge = $case['challenge'] ?? '';
$solution = $case['solution'] ?: $case['prescription'];
$implementation = $case['implementation'] ?? '';
$results = $case['results'] ?: $case['result_description'];
$quoteText = $case['quote_text'] ?? '';
$quoteAuthor = $case['quote_author'] ?? '';
$quoteTitle = $case['quote_title'] ?? '';
$featuredImage = $case['featured_image'] ?? '';
$coverImageAlt = $case['cover_image_alt'] ?? '';
$gallery = $case['gallery'] ?? '';
$isFeatured = (int)($case['is_featured'] ?? 0);
$sortOrder = (int)($case['sort_order'] ?? 0);
$seoTitle = $case['seo_title'] ?? '';
$seoDescription = $case['seo_description'] ?? '';
$status = $case['status'] ?? 'published';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Security token expired or invalid. Please refresh and retry.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $requestedSlug = trim($_POST['slug'] ?? '');
        $clientName = trim($_POST['client_name'] ?? '');
        $projectUrl = trim($_POST['project_url'] ?? '');
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

        if ($projectUrl !== '') {
            if (!filter_var($projectUrl, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $projectUrl)) {
                $errors[] = 'Project / Case Study Link must be a valid HTTP or HTTPS URL (e.g. https://example.com).';
            }
        }

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

        // Validate or generate unique slug
        if (empty($errors)) {
            $slugBase = !empty($requestedSlug) ? $requestedSlug : $title;
            $finalSlug = generateUniqueSlug($slugBase, 'case_studies', $id);

            if ($seoTitle === '') $seoTitle = $title;
            if ($seoDescription === '') $seoDescription = mb_strimwidth($challenge, 0, 160, '...');

            $now = date('Y-m-d H:i:s');

            $update = $pdo->prepare("
                UPDATE case_studies SET
                    slug = ?,
                    title = ?,
                    client_name = ?,
                    project_url = ?,
                    client_industry = ?,
                    industry = ?,
                    practice_area = ?,
                    service_category = ?,
                    project_summary = ?,
                    baseline_metric = ?,
                    outcome_metric = ?,
                    metric_label = ?,
                    challenge = ?,
                    prescription = ?,
                    solution = ?,
                    implementation = ?,
                    result_description = ?,
                    results = ?,
                    featured_image = ?,
                    cover_image_alt = ?,
                    gallery = ?,
                    quote_text = ?,
                    quote_author = ?,
                    quote_title = ?,
                    seo_title = ?,
                    seo_description = ?,
                    status = ?,
                    is_featured = ?,
                    sort_order = ?,
                    updated_at = ?
                WHERE id = ?
            ");

            $update->execute([
                $finalSlug,
                $title,
                $clientName,
                ($projectUrl !== '' ? $projectUrl : null),
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
                $id
            ]);

            require_once __DIR__ . '/../includes/seo-sync.php';
            SeoSyncEngine::syncAll("Case Study updated: {$title}");
            setFlashMessage('success', "Case study '{$title}' updated successfully as " . strtoupper($status) . ".");
            header('Location: case-studies.php');
            exit;
        }
    }
}

// Media library images for quick picker
$mediaList = $pdo->query("SELECT file_path, original_name FROM media ORDER BY id DESC LIMIT 24")->fetchAll();

$pageTitle = 'Edit Case Study';
require_once __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
  <div>
    <h2 style="font-size: 1.4rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem; font-family: var(--adm-font-display);">
      Edit Case Study #<?= $id ?>
    </h2>
    <p style="margin: 0; color: var(--adm-text-muted); font-size: 0.85rem;">
      Last updated: <?= e(date('M d, Y H:i', strtotime($case['updated_at'] ?? $case['created_at'] ?? 'now'))) ?>
    </p>
  </div>
  <div style="display: flex; gap: 0.75rem;">
    <a href="../case-studies/<?= urlencode($case['slug']) ?>" target="_blank" rel="noopener" class="btn-adm btn-adm-secondary">
      Preview on Website ↗
    </a>
    <a href="case-studies.php" class="btn-adm btn-adm-secondary">
      &larr; Back to List
    </a>
  </div>
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

<form method="POST" action="case-study-edit.php?id=<?= $id ?>" enctype="multipart/form-data" id="caseStudyForm">
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
          <input type="text" id="caseTitle" name="title" value="<?= e($title) ?>" required class="adm-input" style="font-size: 1.05rem; font-weight: 600;">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="caseSlug">
            URL Slug <span class="required">*</span>
          </label>
          <input type="text" id="caseSlug" name="slug" value="<?= e($slug) ?>" class="adm-input" style="font-family: var(--adm-font-mono); font-size: 0.85rem;">
          <div class="adm-hint">Public URL: <code>/case-studies/<?= e($slug) ?></code></div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group">
            <label class="adm-label" for="clientName">Client / Company Name</label>
            <input type="text" id="clientName" name="client_name" value="<?= e($clientName) ?>" class="adm-input">
          </div>

          <div class="adm-form-group">
            <label class="adm-label" for="caseIndustry">Industry</label>
            <input type="text" id="caseIndustry" name="industry" value="<?= e($industry) ?>" class="adm-input">
          </div>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="projectUrl">Project / Case Study Link (Optional)</label>
          <input type="url" id="projectUrl" name="project_url" value="<?= e($projectUrl) ?>" placeholder="https://example.com" class="adm-input">
          <div class="adm-hint">Add the client's website, live project, or relevant reference URL.</div>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="caseChallenge">
            01 // The Challenge &amp; Roadblocks <span class="required">*</span>
          </label>
          <textarea id="caseChallenge" name="challenge" rows="5" required class="adm-textarea"><?= e($challenge) ?></textarea>
        </div>

        <div class="adm-form-group">
          <!-- Section 02 Header & Mode Tabs -->
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.75rem;">
            <label class="adm-label" style="margin-bottom: 0;">
              02 // The Solution &amp; Engineering Architecture <span class="required">*</span>
            </label>
            <div class="adm-mode-tabs" role="tablist">
              <button type="button" class="adm-mode-tab active" id="tabVisual" onclick="switchEditorMode('visual')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span>Visual Editor</span>
              </button>
              <button type="button" class="adm-mode-tab" id="tabMarkdown" onclick="switchEditorMode('markdown')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
                <span>Markdown</span>
              </button>
              <button type="button" class="adm-mode-tab" id="tabPreview" onclick="switchEditorMode('preview')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <span>Live Preview</span>
              </button>
              <button type="button" class="adm-mode-tab" id="tabSplit" onclick="switchEditorMode('split')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="12" y1="3" x2="12" y2="21"/></svg>
                <span>Split View</span>
              </button>
            </div>
          </div>

          <!-- Editor Container -->
          <div id="editorContainer" style="margin-bottom: 0.5rem;">
            
            <!-- ================= VISUAL EDITOR MODE ================= -->
            <div id="visualPane">
              
              <!-- Complete Rich Formatting Toolbar -->
              <div class="adm-editor-toolbar">
                
                <!-- Group 1: Typography Block Selector -->
                <div class="adm-tb-group">
                  <select class="adm-tb-select" onchange="setBlockFormat(this.value); this.value='';" title="Block Format">
                    <option value="" disabled selected>Format</option>
                    <option value="p">Paragraph / Normal</option>
                    <option value="h1">Heading H1</option>
                    <option value="h2">Heading H2</option>
                    <option value="h3">Heading H3</option>
                  </select>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 2: Inline Styles -->
                <div class="adm-tb-group">
                  <button type="button" class="adm-tb-btn" id="tbBtnBold" onclick="execCmd('bold')" title="Bold (Ctrl+B)"><strong>B</strong></button>
                  <button type="button" class="adm-tb-btn" id="tbBtnItalic" onclick="execCmd('italic')" title="Italic (Ctrl+I)"><em>I</em></button>
                  <button type="button" class="adm-tb-btn" id="tbBtnUnderline" onclick="execCmd('underline')" title="Underline (Ctrl+U)"><u>U</u></button>
                  <button type="button" class="adm-tb-btn" id="tbBtnStrike" onclick="execCmd('strikeThrough')" title="Strikethrough"><s>S</s></button>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 3: Text Alignment -->
                <div class="adm-tb-group">
                  <button type="button" class="adm-tb-btn" id="tbBtnAlignLeft" onclick="execCmd('justifyLeft')" title="Align Left">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                  </button>
                  <button type="button" class="adm-tb-btn" id="tbBtnAlignCenter" onclick="execCmd('justifyCenter')" title="Align Center">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="10" x2="6" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="18" y1="18" x2="6" y2="18"/></svg>
                  </button>
                  <button type="button" class="adm-tb-btn" id="tbBtnAlignRight" onclick="execCmd('justifyRight')" title="Align Right">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="21" y1="10" x2="7" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="7" y2="18"/></svg>
                  </button>
                  <button type="button" class="adm-tb-btn" id="tbBtnAlignJustify" onclick="execCmd('justifyFull')" title="Justify">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/></svg>
                  </button>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 4: Text & Highlight Color -->
                <div class="adm-tb-group">
                  <div class="adm-tb-dropdown-wrap">
                    <button type="button" class="adm-tb-btn" onclick="toggleMenu('textColorMenu')" title="Text Color" style="font-weight: 700;">
                      <span style="border-bottom: 3px solid var(--adm-teal); line-height: 1;">A</span>
                    </button>
                    <div class="adm-tb-menu" id="textColorMenu" style="width: 175px;">
                      <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-bottom: 6px; font-weight: 600;">TEXT COLOR</div>
                      <div class="adm-color-palette">
                        <div class="adm-color-swatch" style="background:#FFFFFF;" onclick="setTextColor('#FFFFFF')" title="White"></div>
                        <div class="adm-color-swatch" style="background:#0099DB;" onclick="setTextColor('#0099DB')" title="Turquoise"></div>
                        <div class="adm-color-swatch" style="background:#06B5F9;" onclick="setTextColor('#06B5F9')" title="Teal"></div>
                        <div class="adm-color-swatch" style="background:#38BDF8;" onclick="setTextColor('#38BDF8')" title="Sky Blue"></div>
                        <div class="adm-color-swatch" style="background:#FBBF24;" onclick="setTextColor('#FBBF24')" title="Gold"></div>
                        <div class="adm-color-swatch" style="background:#F87171;" onclick="setTextColor('#F87171')" title="Coral"></div>
                      </div>
                    </div>
                  </div>

                  <div class="adm-tb-dropdown-wrap">
                    <button type="button" class="adm-tb-btn" onclick="toggleMenu('highlightColorMenu')" title="Highlight Color">
                      <span style="background: rgba(6, 181, 249, 0.35); padding: 1px 4px; border-radius: 2px;">HL</span>
                    </button>
                    <div class="adm-tb-menu" id="highlightColorMenu" style="width: 175px;">
                      <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-bottom: 6px; font-weight: 600;">HIGHLIGHT COLOR</div>
                      <div class="adm-color-palette">
                        <div class="adm-color-swatch" style="background:rgba(6, 181, 249, 0.35);" onclick="setHighlightColor('rgba(6, 181, 249, 0.35)')" title="Teal Glow"></div>
                        <div class="adm-color-swatch" style="background:rgba(56, 189, 248, 0.35);" onclick="setHighlightColor('rgba(56, 189, 248, 0.35)')" title="Blue Glow"></div>
                        <div class="adm-color-swatch" style="background:rgba(251, 191, 36, 0.35);" onclick="setHighlightColor('rgba(251, 191, 36, 0.35)')" title="Gold Glow"></div>
                        <div class="adm-color-swatch" style="background:rgba(248, 113, 113, 0.35);" onclick="setHighlightColor('rgba(248, 113, 113, 0.35)')" title="Coral Glow"></div>
                        <div class="adm-color-swatch" style="background:transparent; border: 1px dashed #64748B;" onclick="setHighlightColor('transparent')" title="Remove Highlight"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 5: Lists & Indents -->
                <div class="adm-tb-group">
                  <button type="button" class="adm-tb-btn" id="tbBtnBulletList" onclick="execCmd('insertUnorderedList')" title="Bullet List">&bull; List</button>
                  <button type="button" class="adm-tb-btn" id="tbBtnNumberedList" onclick="execCmd('insertOrderedList')" title="Numbered List">1. List</button>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 6: Structural Elements -->
                <div class="adm-tb-group">
                  <button type="button" class="adm-tb-btn" onclick="execCmd('formatBlock', 'blockquote')" title="Blockquote">&ldquo; Quote</button>
                  <button type="button" class="adm-tb-btn" onclick="execCmd('insertHorizontalRule')" title="Horizontal Divider">&horbar;</button>
                  <button type="button" class="adm-tb-btn" onclick="insertVisualCodeBlock()" title="Code Block">{ } Code</button>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 7: Links & Media -->
                <div class="adm-tb-group">
                  <button type="button" class="adm-tb-btn" onclick="openLinkModal()" title="Insert / Edit Link">🔗 Link</button>
                  <button type="button" class="adm-tb-btn" onclick="removeHyperlink()" title="Remove Link">🔗⃠</button>
                  <button type="button" class="adm-tb-btn" onclick="openImageModal()" title="Insert Image">🖼️ Image</button>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 8: Table Controls -->
                <div class="adm-tb-group">
                  <div class="adm-tb-dropdown-wrap">
                    <button type="button" class="adm-tb-btn" onclick="toggleMenu('tableMenu')" title="Table Tools">
                      <span>▦ Table ▾</span>
                    </button>
                    <div class="adm-tb-menu" id="tableMenu" style="width: 210px;">
                      <button type="button" class="adm-tb-menu-item" onclick="openTableModal(); toggleMenu('tableMenu');">
                        <strong>+ Insert Table...</strong>
                      </button>
                      <div style="border-top: 1px solid var(--adm-border); margin: 4px 0;"></div>
                      <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-bottom: 4px; font-weight: 600; padding: 0 0.5rem;">TABLE MODIFICATIONS</div>
                      <button type="button" class="adm-tb-menu-item" onclick="tableAddRow(true); toggleMenu('tableMenu');">Add Row Above</button>
                      <button type="button" class="adm-tb-menu-item" onclick="tableAddRow(false); toggleMenu('tableMenu');">Add Row Below</button>
                      <button type="button" class="adm-tb-menu-item danger" onclick="tableDeleteRow(); toggleMenu('tableMenu');">Delete Row</button>
                      <div style="border-top: 1px solid var(--adm-border); margin: 4px 0;"></div>
                      <button type="button" class="adm-tb-menu-item" onclick="tableAddCol(true); toggleMenu('tableMenu');">Add Column Left</button>
                      <button type="button" class="adm-tb-menu-item" onclick="tableAddCol(false); toggleMenu('tableMenu');">Add Column Right</button>
                      <button type="button" class="adm-tb-menu-item danger" onclick="tableDeleteCol(); toggleMenu('tableMenu');">Delete Column</button>
                      <div style="border-top: 1px solid var(--adm-border); margin: 4px 0;"></div>
                      <button type="button" class="adm-tb-menu-item danger" onclick="tableDeleteTable(); toggleMenu('tableMenu');">Delete Entire Table</button>
                    </div>
                  </div>
                </div>

                <div class="adm-toolbar-divider"></div>

                <!-- Group 9: Clear / Undo -->
                <div class="adm-tb-group">
                  <button type="button" class="adm-tb-btn" onclick="execCmd('undo')" title="Undo">↺</button>
                  <button type="button" class="adm-tb-btn" onclick="execCmd('redo')" title="Redo">↻</button>
                  <button type="button" class="adm-tb-btn" onclick="execCmd('removeFormat')" title="Clear Formatting">T⃠</button>
                </div>

              </div>

              <!-- Document Canvas -->
              <div class="adm-doc-canvas" id="visualCanvas" contenteditable="true" spellcheck="true" role="textbox" aria-multiline="true" style="min-height: 280px;">
                <?php if (!empty($solution)): ?>
                  <?= $solution ?>
                <?php else: ?>
                  <p>Detail the custom technical architecture, stack upgrades, optimizations, and strategy deployed by BusinessDoctor. Switch between <strong>Visual</strong> and <strong>Markdown</strong> modes anytime.</p>
                <?php endif; ?>
              </div>
            </div>

            <!-- ================= MARKDOWN EDITOR WORKSPACE ================= -->
            <div id="markdownPane" style="display: none;">
              
              <!-- Markdown Topbar with Formatting Toolbar & Sub-modes -->
              <div class="adm-md-topbar">
                <div class="adm-md-toolbar">
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('# ', '', 'Heading 1')" title="H1"># H1</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('## ', '', 'Heading 2')" title="H2">## H2</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('### ', '', 'Heading 3')" title="H3">### H3</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('**', '**', 'bold text')" title="Bold"><strong>B</strong></button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('*', '*', 'italic text')" title="Italic"><em>I</em></button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('> ', '', 'Executive quote')" title="Blockquote">&ldquo; Quote</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('- ', '', 'List item')" title="Bullet List">&bull; List</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('1. ', '', 'First item')" title="Numbered List">1. List</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdLink()" title="Hyperlink">🔗 Link</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdImage()" title="Image">🖼️ Image</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdTable()" title="Markdown Table">▦ Table</button>
                  <button type="button" class="adm-tb-btn" onclick="insertMdCode()" title="Code Block">{ } Code</button>
                </div>

                <div class="adm-md-submodes">
                  <button type="button" class="adm-md-submode-btn active" data-submode="write" onclick="setMarkdownSubMode('write')">Write</button>
                  <button type="button" class="adm-md-submode-btn" data-submode="preview" onclick="setMarkdownSubMode('preview')">Preview</button>
                  <button type="button" class="adm-md-submode-btn" data-submode="split" onclick="setMarkdownSubMode('split')">Split View</button>
                </div>
              </div>

              <!-- Markdown Syntax Quick-Reference Strip -->
              <div class="adm-md-quickref">
                <span style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: var(--adm-teal); margin-right: 0.4rem; font-weight: 700;">SHORTCUTS:</span>
                <span class="adm-md-quickchip" onclick="insertMdSyntax('# ', '', 'Heading 1')"><strong>H1</strong> #</span>
                <span class="adm-md-quickchip" onclick="insertMdSyntax('## ', '', 'Heading 2')"><strong>H2</strong> ##</span>
                <span class="adm-md-quickchip" onclick="insertMdSyntax('**', '**', 'bold text')"><strong>Bold</strong> **text**</span>
                <span class="adm-md-quickchip" onclick="insertMdSyntax('*', '*', 'italic text')"><strong>Italic</strong> *text*</span>
                <span class="adm-md-quickchip" onclick="insertMdSyntax('> ', '', 'quote')"><strong>Quote</strong> &gt;</span>
                <span class="adm-md-quickchip" onclick="insertMdSyntax('- ', '', 'item')"><strong>List</strong> -</span>
                <span class="adm-md-quickchip" onclick="insertMdLink()"><strong>[Link]</strong> [text](url)</span>
                <span class="adm-md-quickchip" onclick="insertMdTable()"><strong>| Table |</strong></span>
                <span class="adm-md-quickchip" onclick="insertMdCode()"><strong>Code</strong> `code`</span>
              </div>

              <!-- Markdown Workspace Grid (Write / Split) -->
              <div id="mdWorkspaceGrid" style="display: block;">
                <div id="mdEditorCol">
                  <textarea id="markdownEditor" class="adm-md-textarea" placeholder="## Architecture Overview&#10;&#10;Write solution in standard Markdown syntax here..."></textarea>
                </div>
                <div id="mdPreviewCol" style="display: none;">
                  <div class="adm-live-preview-box" id="mdPreviewOutput" style="min-height: 280px; border-radius: 0;"></div>
                </div>
              </div>

              <!-- Markdown Bottom Action Bar -->
              <div class="adm-md-actionbar">
                <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                  <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="appendMarkdownToBody()" title="Append Markdown content to current document">
                    Append to Body
                  </button>
                  <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyMarkdownReplaceBody()" title="Replace document body with this Markdown">
                    Apply (Replace Body)
                  </button>
                </div>

                <div class="adm-doc-metrics" style="margin: 0; padding: 0.25rem 0.65rem; background: transparent; border: none;">
                  <span class="adm-metric-item"><strong id="mdMetricWords">0</strong> words</span>
                  <span>&bull;</span>
                  <span class="adm-metric-item"><strong id="mdMetricChars">0</strong> chars</span>
                </div>
              </div>

            </div>

            <!-- ================= LIVE PREVIEW PANE ================= -->
            <div id="previewPane" style="display: none;">
              <div class="adm-live-preview-box" id="livePreviewContainer" style="min-height: 280px; padding: 1.5rem; background: var(--adm-card-bg); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-md);">
                <!-- Dynamically populated live preview -->
              </div>
            </div>

            <!-- Hidden Input for Form Submission -->
            <input type="hidden" name="solution" id="finalContentInput" value="<?= e($solution) ?>">

          </div> <!-- Closes #editorContainer -->
        </div>

        <div class="adm-form-group" style="margin-bottom: 0;">
          <label class="adm-label" for="caseResults">
            03 // Implementation &amp; Measured Impact
          </label>
          <textarea id="caseResults" name="results" rows="5" class="adm-textarea"><?= e($results) ?></textarea>
        </div>
      </div>

      <!-- Verified Transformation Metrics Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Verified Outcome Metrics</h3>
        <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin: 0 0 1.25rem;">These figures power the high-impact visual banners on case study pages and homepage cards.</p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="baseMetric">Baseline Status</label>
            <input type="text" id="baseMetric" name="baseline_metric" value="<?= e($baselineMetric) ?>" class="adm-input" style="font-family: var(--adm-font-mono);">
            <div class="adm-hint">Shown in red / strikethrough</div>
          </div>

          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="outMetric">Verified Outcome</label>
            <input type="text" id="outMetric" name="outcome_metric" value="<?= e($outcomeMetric) ?>" class="adm-input" style="font-family: var(--adm-font-mono); color: #34D399; font-weight: 700;">
            <div class="adm-hint">Highlighted outcome stat</div>
          </div>

          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="metLabel">Measured Impact Label</label>
            <input type="text" id="metLabel" name="metric_label" value="<?= e($metricLabel) ?>" class="adm-input">
            <div class="adm-hint">Short label beneath stat</div>
          </div>
        </div>
      </div>

      <!-- Client Quote Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Client Executive Testimonial</h3>
        
        <div class="adm-form-group">
          <label class="adm-label" for="quoteText">Testimonial Quote</label>
          <textarea id="quoteText" name="quote_text" rows="3" class="adm-textarea"><?= e($quoteText) ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="quoteAuthor">Author Name</label>
            <input type="text" id="quoteAuthor" name="quote_author" value="<?= e($quoteAuthor) ?>" class="adm-input">
          </div>

          <div class="adm-form-group" style="margin-bottom: 0;">
            <label class="adm-label" for="quoteTitle">Author Title / Role</label>
            <input type="text" id="quoteTitle" name="quote_title" value="<?= e($quoteTitle) ?>" class="adm-input">
          </div>
        </div>
      </div>

    </div>

    <!-- Sidebar Column -->
    <div>
      
      <!-- Publish Action Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Publishing Actions</h3>
        
        <div style="margin-bottom: 1rem; font-size: 0.82rem; color: var(--adm-text-muted);">
          Current Status: 
          <span class="status-pill status-<?= $status === 'published' ? 'published' : 'draft' ?>">
            <?= e($status) ?>
          </span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
          <button type="submit" name="submit_action" value="published" class="btn-adm btn-adm-primary" style="width: 100%; padding: 0.75rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Update &amp; Publish</span>
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
        
        <?php if (!empty($featuredImage)): ?>
          <div style="margin-bottom: 1rem; border-radius: var(--adm-radius); overflow: hidden; border: 1px solid var(--adm-border);">
            <img src="../<?= e($featuredImage) ?>" alt="<?= e($coverImageAlt ?: $title) ?>" style="width: 100%; height: 140px; object-fit: cover; display: block;">
          </div>
        <?php endif; ?>

        <div class="adm-form-group">
          <label class="adm-label">Replace Cover Image (JPG, PNG, WebP &le; 5MB)</label>
          <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp" class="adm-input">
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
          <textarea id="caseGallery" name="gallery" rows="3" class="adm-textarea" style="font-family: var(--adm-font-mono); font-size: 0.8rem;"><?= e($gallery) ?></textarea>
        </div>
      </div>

    </div>

  </div>
</form>

<!-- Modal Dialogs for Rich Editor -->
<div class="adm-modal-overlay" id="linkModal">
  <div class="adm-modal-box">
    <div class="adm-modal-header">
      <h3 class="adm-modal-title">Insert / Edit Hyperlink</h3>
      <button type="button" class="adm-modal-close" onclick="closeModal('linkModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div class="adm-form-group">
        <label class="adm-label">Target URL</label>
        <input type="text" id="linkModalUrl" class="adm-input" placeholder="https://example.com or /case-studies.php">
      </div>
      <div class="adm-form-group">
        <label class="adm-label">Display Anchor Text</label>
        <input type="text" id="linkModalText" class="adm-input" placeholder="Anchor text">
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; cursor: pointer; color: var(--adm-text);">
          <input type="checkbox" id="linkModalTarget" checked>
          <span>Open in new tab (target="_blank" rel="noopener")</span>
        </label>
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('linkModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyLinkModal()">Apply Link</button>
    </div>
  </div>
</div>

<div class="adm-modal-overlay" id="imageModal">
  <div class="adm-modal-box">
    <div class="adm-modal-header">
      <h3 class="adm-modal-title">Insert Content Image</h3>
      <button type="button" class="adm-modal-close" onclick="closeModal('imageModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div class="adm-form-group">
        <label class="adm-label">Image Source URL / Path</label>
        <input type="text" id="imageModalUrl" class="adm-input" placeholder="assets/images/architecture.webp or https://...">
      </div>
      <div class="adm-form-group">
        <label class="adm-label">Alternative Text (Alt Text)</label>
        <input type="text" id="imageModalAlt" class="adm-input" placeholder="Descriptive image explanation">
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label class="adm-label">Caption / Hover Tooltip</label>
        <input type="text" id="imageModalTitle" class="adm-input" placeholder="Hover tooltip or caption">
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('imageModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyImageModal()">Insert Image</button>
    </div>
  </div>
</div>

<div class="adm-modal-overlay" id="tableModal">
  <div class="adm-modal-box">
    <div class="adm-modal-header">
      <h3 class="adm-modal-title">Insert Data Table</h3>
      <button type="button" class="adm-modal-close" onclick="closeModal('tableModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div class="adm-form-group">
          <label class="adm-label">Rows</label>
          <input type="number" id="tableModalRows" class="adm-input" value="3" min="1" max="25">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">Columns</label>
          <input type="number" id="tableModalCols" class="adm-input" value="3" min="1" max="10">
        </div>
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; cursor: pointer; color: var(--adm-text);">
          <input type="checkbox" id="tableModalHeader" checked>
          <span>Include Header Row</span>
        </label>
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('tableModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyTableModal()">Create Table</button>
    </div>
  </div>
</div>

<script src="../assets/js/admin-editor.js"></script>
<script>
// Auto-sync visual editor content to hidden solution input before form submission
const caseForm = document.getElementById('caseStudyForm');
if (caseForm) {
  caseForm.addEventListener('submit', function(e) {
    if (typeof syncFromVisual === 'function') {
      syncFromVisual();
    }
    const canvas = document.getElementById('visualCanvas');
    const input = document.getElementById('finalContentInput');
    if (canvas && input) {
      input.value = canvas.innerHTML;
    }
  });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

