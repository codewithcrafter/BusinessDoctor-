<?php
/**
 * BusinessDoctor Executive Admin — Create Insight / Blog Post
 * Triple-Mode: Visual Document Editor, Markdown Editor & Import, Live Preview
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (empty($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

$adminUser = $_SESSION['admin_user'];
$pageTitle = 'Create Insight Article';
$activeNav = 'blogs';

$errors = [];
$title = '';
$slug = '';
$category = 'Web & Digital Strategy';
$author = $adminUser['full_name'] ?? 'Managing Partner';
$authorTitle = 'Senior Consultant';
$authorBio = '';
$excerpt = '';
$content = '';
$featuredImage = '';
$coverImageAlt = '';
$readingTime = '5 min read';
$tags = '';
$seoTitle = '';
$seoDescription = '';
$canonicalUrl = '';
$isFeatured = 0;
$publishedAt = date('Y-m-d\TH:i');
$schemaMode = 'auto';
$customSchemaJson = '';
$status = 'draft';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Security token expired. Please refresh and submit again.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $category = trim($_POST['category'] ?? 'Web & Digital Strategy');
        $author = trim($_POST['author'] ?? $adminUser['full_name']);
        $authorTitle = trim($_POST['author_title'] ?? 'Senior Consultant');
        $authorBio = trim($_POST['author_bio'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $content = sanitizeArticleHtml(trim($_POST['content'] ?? ''));
        $featuredImage = trim($_POST['featured_image'] ?? '');
        $coverImageAlt = trim($_POST['cover_image_alt'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $seoTitle = trim($_POST['seo_title'] ?? '');
        $seoDescription = trim($_POST['seo_description'] ?? '');
        $canonicalUrl = trim($_POST['canonical_url'] ?? '');
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $publishedAtInput = trim($_POST['published_at'] ?? '');
        $schemaMode = (isset($_POST['schema_mode']) && $_POST['schema_mode'] === 'custom') ? 'custom' : 'auto';
        $customSchemaJson = trim($_POST['custom_schema_json'] ?? '');
        $status = ($_POST['submit_action'] === 'draft') ? 'draft' : 'published';

        if ($title === '') {
            $errors[] = 'Article Title is required.';
        }
        if ($content === '') {
            $errors[] = 'Article Content is required.';
        }
        if ($excerpt === '') {
            $plain = strip_tags($content);
            $excerpt = mb_strimwidth($plain, 0, 180, '...');
        }

        // Validate Custom JSON-LD if Option B selected
        if ($schemaMode === 'custom' && $customSchemaJson !== '') {
            $decodedCustom = json_decode($customSchemaJson, true);
            if ($decodedCustom === null && json_last_error() !== JSON_ERROR_NONE) {
                $errors[] = 'Invalid Custom JSON-LD Schema: ' . json_last_error_msg();
            } elseif (!is_array($decodedCustom)) {
                $errors[] = 'Custom JSON-LD Schema must be a valid JSON Object or Array.';
            } else {
                $customSchemaJson = json_encode($decodedCustom, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }

        // Direct Cover Image Upload
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
                $safeName = 'blog_' . bin2hex(random_bytes(10)) . '.' . $ext;
                $destPath = $uploadDir . DIRECTORY_SEPARATOR . $safeName;
                if (move_uploaded_file($file['tmp_name'], $destPath)) {
                    $featuredImage = 'assets/uploads/' . $safeName;
                } else {
                    $errors[] = 'Failed to move uploaded cover image.';
                }
            }
        }

        // Slug Generation & Uniqueness
        if ($slug === '') {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        } else {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug), '-'));
        }
        if ($slug === '') {
            $slug = 'insight-' . time();
        }

        $db = Database::getConnection();
        $checkStmt = $db->prepare("SELECT id FROM insights WHERE slug = ?");
        $checkStmt->execute([$slug]);
        if ($checkStmt->fetch()) {
            $slug .= '-' . time();
        }

        // Calculate Reading Time if not manually provided
        $reqReadingTime = trim($_POST['reading_time'] ?? '');
        if ($reqReadingTime !== '') {
            $readingTime = $reqReadingTime;
        } else {
            $wordCount = str_word_count(strip_tags($content));
            $readingTime = max(1, (int)ceil($wordCount / 200)) . ' min read';
        }

        if (empty($errors)) {
            $now = date('Y-m-d H:i:s');
            $finalPubDate = (!empty($publishedAtInput)) ? date('Y-m-d H:i:s', strtotime($publishedAtInput)) : $now;

            $sql = "INSERT INTO insights (
                slug, category, title, reading_time, summary, content,
                author_name, author_title, author_bio, is_published, published_at,
                excerpt, featured_image, author, tags, seo_title,
                seo_description, canonical_url, is_featured, schema_mode,
                custom_schema_json, status, created_at, updated_at, cover_image_alt
            ) VALUES (
                ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?, ?
            )";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                $slug,
                $category,
                $title,
                $readingTime,
                $excerpt,
                $content,
                $author,
                $authorTitle,
                $authorBio,
                ($status === 'published' ? 1 : 0),
                $finalPubDate,
                $excerpt,
                $featuredImage,
                $author,
                $tags,
                $seoTitle,
                $seoDescription,
                $canonicalUrl,
                $isFeatured,
                $schemaMode,
                $customSchemaJson,
                $status,
                $now,
                $now,
                $coverImageAlt
            ]);

            $newId = (int)$db->lastInsertId();
            require_once __DIR__ . '/../includes/seo-sync.php';
            SeoSyncEngine::syncAll("Blog created: {$title}");
            header("Location: blog-edit.php?id=" . $newId . "&msg=" . urlencode($status === 'published' ? 'Article published live!' : 'Draft saved successfully!'));
            exit;
        }
    }
}

// Available library media for cover picker
$libraryImages = [
    'assets/images/insight-ai-strategy.webp' => 'AI Transformation in Enterprise',
    'assets/images/insight-fullstack.webp' => 'Next-Gen Fullstack Frameworks',
    'assets/images/insight-design-systems.webp' => 'Enterprise Design Systems'
];

require_once __DIR__ . '/includes/header.php';
?>

<form method="POST" action="blog-create.php" id="blogPostForm" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
  <input type="hidden" name="content" id="finalContentInput" value="<?= e($content) ?>">

  <!-- Top Sticky Workspace Action Bar -->
  <div class="adm-workspace-header">
    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
      <a href="blogs.php" class="btn-adm btn-adm-secondary btn-adm-sm" style="color: var(--adm-text-dim);">
        &larr; All Articles
      </a>
      <span class="status-pill status-draft" id="docStatusBadge">
        ● Draft (Unsaved)
      </span>
      <div class="adm-doc-metrics" style="margin: 0; padding: 0.35rem 0.75rem;">
        <span class="adm-metric-item"><strong id="metricWords">0</strong> words</span>
        <span>&bull;</span>
        <span class="adm-metric-item"><strong id="metricChars">0</strong> chars</span>
        <span>&bull;</span>
        <span class="adm-metric-item"><strong id="metricTime">1 min read</strong></span>
      </div>
    </div>

    <!-- Top Action Buttons -->
    <div style="display: flex; gap: 0.65rem; align-items: center; flex-wrap: wrap;">
      <button type="submit" name="submit_action" value="draft" class="btn-adm btn-adm-secondary" style="font-weight: 600;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/></svg>
        <span>Save Draft</span>
      </button>

      <button type="submit" name="submit_action" value="published" class="btn-adm btn-adm-primary" style="font-weight: 700; box-shadow: 0 4px 15px rgba(0, 201, 193, 0.35);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>Publish Article</span>
      </button>
    </div>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="adm-toast error" style="margin-bottom: 1.5rem; max-width: 100%;">
      <div>
        <strong>Please review required items:</strong>
        <ul style="margin: 0.35rem 0 0; padding-left: 1.25rem;">
          <?php foreach ($errors as $err): ?>
            <li><?= e($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <div class="adm-form-grid">
    
    <!-- Left Main Column: Editorial Document Workspace -->
    <div>
      
      <!-- Document Title & Mode Selector Card -->
      <div class="admin-card" style="margin-bottom: 1.25rem; padding: 1.5rem 1.75rem;">
        <input type="text" id="blogTitle" name="title" value="<?= e($title) ?>" required placeholder="Article Title (e.g. Scaling Cloud Microservices with Zero Downtime)..." class="adm-doc-title-input">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.25rem; flex-wrap: wrap; gap: 0.75rem; border-top: 1px solid var(--adm-border-subtle); padding-top: 1rem;">
          <!-- Mode Tabs -->
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

          <div style="font-size: 0.76rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
            Auto-Sync Active
          </div>
        </div>
      </div>

      <!-- Editor Container -->
      <div id="editorContainer" style="margin-bottom: 1.5rem;">
        
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
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="10" x2="6" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="18" y1="18" x2="6" y2="18"/></svg>
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
                    <div class="adm-color-swatch" style="background:#14E5D4;" onclick="setTextColor('#14E5D4')" title="Turquoise"></div>
                    <div class="adm-color-swatch" style="background:#00C9C1;" onclick="setTextColor('#00C9C1')" title="Teal"></div>
                    <div class="adm-color-swatch" style="background:#38BDF8;" onclick="setTextColor('#38BDF8')" title="Sky Blue"></div>
                    <div class="adm-color-swatch" style="background:#FBBF24;" onclick="setTextColor('#FBBF24')" title="Gold"></div>
                    <div class="adm-color-swatch" style="background:#F87171;" onclick="setTextColor('#F87171')" title="Coral"></div>
                    <div class="adm-color-swatch" style="background:#A78BFA;" onclick="setTextColor('#A78BFA')" title="Purple"></div>
                    <div class="adm-color-swatch" style="background:#94A3B8;" onclick="setTextColor('#94A3B8')" title="Slate"></div>
                    <div class="adm-color-swatch" style="background:#061326;" onclick="setTextColor('#061326')" title="Navy"></div>
                  </div>
                </div>
              </div>

              <div class="adm-tb-dropdown-wrap">
                <button type="button" class="adm-tb-btn" onclick="toggleMenu('highlightColorMenu')" title="Highlight Color">
                  <span style="background: rgba(0, 201, 193, 0.35); padding: 1px 4px; border-radius: 2px;">HL</span>
                </button>
                <div class="adm-tb-menu" id="highlightColorMenu" style="width: 175px;">
                  <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-bottom: 6px; font-weight: 600;">HIGHLIGHT COLOR</div>
                  <div class="adm-color-palette">
                    <div class="adm-color-swatch" style="background:rgba(0, 201, 193, 0.35);" onclick="setHighlightColor('rgba(0, 201, 193, 0.35)')" title="Teal Glow"></div>
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
              <button type="button" class="adm-tb-btn" onclick="execCmd('indent')" title="Increase Indent">&rarr;| Indent</button>
              <button type="button" class="adm-tb-btn" onclick="execCmd('outdent')" title="Decrease Indent">|&larr; Outdent</button>
            </div>

            <div class="adm-toolbar-divider"></div>

            <!-- Group 6: Spacing & Layout -->
            <div class="adm-tb-group">
              <div class="adm-tb-dropdown-wrap">
                <button type="button" class="adm-tb-btn" onclick="toggleMenu('spacingMenu')" title="Spacing & Layout">
                  <span>↕ Spacing</span>
                </button>
                <div class="adm-tb-menu" id="spacingMenu" style="width: 190px;">
                  <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-bottom: 4px; font-weight: 600; padding: 0 0.5rem;">LINE SPACING</div>
                  <button type="button" class="adm-tb-menu-item" onclick="setLineSpacing('1.0')">Single (1.0)</button>
                  <button type="button" class="adm-tb-menu-item" onclick="setLineSpacing('1.15')">Standard (1.15)</button>
                  <button type="button" class="adm-tb-menu-item" onclick="setLineSpacing('1.5')">Medium (1.5)</button>
                  <button type="button" class="adm-tb-menu-item" onclick="setLineSpacing('2.0')">Double (2.0)</button>
                  <div style="border-top: 1px solid var(--adm-border); margin: 4px 0;"></div>
                  <div style="font-size: 0.72rem; color: var(--adm-text-dim); margin-bottom: 4px; font-weight: 600; padding: 0 0.5rem;">PARAGRAPH GAP</div>
                  <button type="button" class="adm-tb-menu-item" onclick="setParagraphSpacing('compact')">Compact</button>
                  <button type="button" class="adm-tb-menu-item" onclick="setParagraphSpacing('normal')">Normal</button>
                  <button type="button" class="adm-tb-menu-item" onclick="setParagraphSpacing('relaxed')">Relaxed</button>
                </div>
              </div>
            </div>

            <div class="adm-toolbar-divider"></div>

            <!-- Group 7: Structural Elements -->
            <div class="adm-tb-group">
              <button type="button" class="adm-tb-btn" onclick="execCmd('formatBlock', 'blockquote')" title="Blockquote">&ldquo; Quote</button>
              <button type="button" class="adm-tb-btn" onclick="execCmd('insertHorizontalRule')" title="Horizontal Divider">&horbar;</button>
              <button type="button" class="adm-tb-btn" onclick="insertKeyTakeaway()" title="Key Takeaway Box" style="color: var(--adm-teal); font-weight: 700;">★ Takeaway</button>
              <button type="button" class="adm-tb-btn" onclick="insertVisualCodeBlock()" title="Code Block">{ } Code</button>
            </div>

            <div class="adm-toolbar-divider"></div>

            <!-- Group 8: Links & Media -->
            <div class="adm-tb-group">
              <button type="button" class="adm-tb-btn" onclick="openLinkModal()" title="Insert / Edit Link">🔗 Link</button>
              <button type="button" class="adm-tb-btn" onclick="removeHyperlink()" title="Remove Link">🔗⃠</button>
              <button type="button" class="adm-tb-btn" onclick="openImageModal()" title="Insert Image">🖼️ Image</button>
            </div>

            <div class="adm-toolbar-divider"></div>

            <!-- Group 9: Table Controls -->
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

            <!-- Group 10: Clear / Undo -->
            <div class="adm-tb-group">
              <button type="button" class="adm-tb-btn" onclick="execCmd('undo')" title="Undo">↺</button>
              <button type="button" class="adm-tb-btn" onclick="execCmd('redo')" title="Redo">↻</button>
              <button type="button" class="adm-tb-btn" onclick="execCmd('removeFormat')" title="Clear Formatting">T⃠</button>
            </div>

          </div>

          <!-- Document Canvas -->
          <div class="adm-doc-canvas" id="visualCanvas" contenteditable="true" spellcheck="true" role="textbox" aria-multiline="true">
            <?php if (!empty($content)): ?>
              <?= $content ?>
            <?php else: ?>
              <p>Start drafting your technical perspective or enterprise advisory here. Switch freely between <strong>Visual</strong>, <strong>Markdown</strong>, and <strong>Split View</strong> anytime.</p>
            <?php endif; ?>
          </div>
        </div>

        <!-- ================= MARKDOWN EDITOR WORKSPACE ================= -->
        <div id="markdownPane" style="display: none;">
          
          <!-- Markdown Topbar with Formatting Toolbar & Sub-modes -->
          <div class="adm-md-topbar">
            <!-- Format Buttons -->
            <div class="adm-md-toolbar">
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('# ', '', 'Heading 1')" title="H1"># H1</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('## ', '', 'Heading 2')" title="H2">## H2</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('### ', '', 'Heading 3')" title="H3">### H3</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('**', '**', 'bold text')" title="Bold"><strong>B</strong></button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('*', '*', 'italic text')" title="Italic"><em>I</em></button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('~~', '~~', 'strikethrough text')" title="Strikethrough"><s>S</s></button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('> ', '', 'Executive quote')" title="Blockquote">&ldquo; Quote</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('- ', '', 'List item')" title="Bullet List">&bull; List</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('1. ', '', 'First item')" title="Numbered List">1. List</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdLink()" title="Hyperlink">🔗 Link</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdImage()" title="Image">🖼️ Image</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdTable()" title="Markdown Table">▦ Table</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdCode()" title="Code Block">{ } Code</button>
              <button type="button" class="adm-tb-btn" onclick="insertMdSyntax('\n---\n\n', '', '')" title="Divider">&horbar;</button>
            </div>

            <!-- Workspace Sub-modes (Write, Preview, Split View) -->
            <div class="adm-md-submodes">
              <button type="button" class="adm-md-submode-btn active" data-submode="write" onclick="setMarkdownSubMode('write')">Write</button>
              <button type="button" class="adm-md-submode-btn" data-submode="preview" onclick="setMarkdownSubMode('preview')">Preview</button>
              <button type="button" class="adm-md-submode-btn" data-submode="split" onclick="setMarkdownSubMode('split')">Split View</button>
            </div>
          </div>

          <!-- Markdown Syntax Quick-Reference Strip (Reference Image 2) -->
          <div class="adm-md-quickref">
            <span style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: var(--adm-teal); margin-right: 0.4rem; font-weight: 700;">SHORTCUTS:</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('# ', '', 'Heading 1')"><strong>H1</strong> #</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('## ', '', 'Heading 2')"><strong>H2</strong> ##</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('**', '**', 'bold text')"><strong>Bold</strong> **text**</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('*', '*', 'italic text')"><strong>Italic</strong> *text*</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('> ', '', 'quote')"><strong>Quote</strong> &gt;</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('- ', '', 'item')"><strong>List</strong> -</span>
            <span class="adm-md-quickchip" onclick="insertMdSyntax('1. ', '', 'item')"><strong>1. List</strong> 1.</span>
            <span class="adm-md-quickchip" onclick="insertMdLink()"><strong>[Link]</strong> [text](url)</span>
            <span class="adm-md-quickchip" onclick="insertMdTable()"><strong>| Table |</strong></span>
            <span class="adm-md-quickchip" onclick="insertMdCode()"><strong>Code</strong> `code`</span>
          </div>

          <!-- Markdown Workspace Grid (Write / Split) -->
          <div id="mdWorkspaceGrid" style="display: block;">
            <div id="mdEditorCol">
              <textarea id="markdownEditor" class="adm-md-textarea" placeholder="# Article Title&#10;&#10;Write article in standard Markdown syntax here..."></textarea>
            </div>
            <div id="mdPreviewCol" style="display: none;">
              <div class="adm-live-preview-box" id="mdPreviewOutput" style="min-height: 540px; border-radius: 0;"></div>
            </div>
          </div>

          <!-- Markdown Bottom Action Bar -->
          <div class="adm-md-actionbar">
            <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
              <label class="btn-adm btn-adm-secondary btn-adm-sm" style="cursor: pointer; margin: 0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                <span>Upload .md</span>
                <input type="file" id="mdFileInput" accept=".md,.markdown,.txt" style="display: none;">
              </label>

              <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" id="exportMdBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span>Download .md</span>
              </button>

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
          <div class="adm-live-preview-box" id="livePreviewContainer">
            <!-- Dynamically populated live preview -->
          </div>
        </div>

      </div> <!-- Closes #editorContainer -->

<!-- 4. Executive Summary / Excerpt Card -->
      <div class="admin-card" style="margin-top: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
          <h3 class="admin-card-title" style="margin: 0;">Executive Summary</h3>
          <span id="excerptCount" style="font-size: 0.72rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">0/180</span>
        </div>
        <div class="adm-hint" style="margin-bottom: 0.75rem;">Lead-in highlight used across article cards, search results and social previews.</div>
        <textarea id="blogExcerpt" name="excerpt" rows="3" class="adm-textarea" placeholder="Executive overview highlighting core strategic and engineering outcomes..."><?= e($excerpt) ?></textarea>
      </div>

      <!-- 5. Search Engine Optimization (SEO) Card -->
      <div class="admin-card" style="margin-top: 1.5rem;">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Search Engine Optimization (SEO)</h3>

        <div class="adm-form-group">
          <label class="adm-label" for="blogSlug">URL Slug</label>
          <input type="text" id="blogSlug" name="slug" value="<?= e($slug) ?>" class="adm-input" placeholder="e.g. scaling-cloud-microservices">
        </div>

        <div class="adm-form-group">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <label class="adm-label" for="seoTitle">Meta Title</label>
            <span id="seoTitleCount" style="font-size: 0.72rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">0/60</span>
          </div>
          <input type="text" id="seoTitle" name="seo_title" value="<?= e($seoTitle) ?>" maxlength="70" class="adm-input" placeholder="Custom Google title tag">
        </div>

        <div class="adm-form-group">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <label class="adm-label" for="seoDescription">Meta Description</label>
            <span id="seoDescCount" style="font-size: 0.72rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">0/160</span>
          </div>
          <textarea id="seoDescription" name="seo_description" rows="3" maxlength="170" class="adm-textarea" placeholder="Google snippet summary..."><?= e($seoDescription) ?></textarea>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="canonicalUrl">Canonical URL</label>
          <input type="url" id="canonicalUrl" name="canonical_url" value="<?= e($canonicalUrl) ?>" class="adm-input" placeholder="https://demo.businessdoctor.com/insight-detail.php?slug=...">
          <div class="adm-hint">Overrides default self-referencing canonical URL if syndicating or cross-posting.</div>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="blogTags">Keywords / Tags</label>
          <input type="text" id="blogTags" name="tags" value="<?= e($tags) ?>" class="adm-input" placeholder="Cloud, Architecture, Microservices (comma separated)">
        </div>

        <!-- Google SERP Live Snippet Box -->
        <div style="margin-top: 1rem;">
          <div style="font-size: 0.78rem; font-weight: 600; color: var(--adm-text-dim); margin-bottom: 0.4rem;">Google Search Preview:</div>
          <div class="adm-serp-preview">
            <div class="adm-serp-title" id="serpTitlePreview">BusinessDoctor Tech Perspective</div>
            <div class="adm-serp-url" id="serpUrlPreview">https://demo.businessdoctor.com/insight-detail.php?slug=article-slug</div>
            <div class="adm-serp-desc" id="serpDescPreview">Engineering architecture and digital growth frameworks authored by BusinessDoctor.</div>
          </div>
        </div>
      </div>

    </div> <!-- Closes Left Column -->

    <!-- Right Sidebar Column: Article Settings & Metadata -->
    <div>
      
      <!-- 1. Publishing & Taxonomy Card -->
      <div class="admin-card">
        <h3 class="admin-card-title" style="margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
          <span>Publishing &amp; Taxonomy</span>
          <span class="status-pill status-draft" style="font-size: 0.7rem;">Drafting</span>
        </h3>

        <div class="adm-form-group">
          <label class="adm-label" for="blogCategory">Practice Category <span class="required">*</span></label>
          <select id="blogCategory" name="category" class="adm-select" required>
            <option value="Web Development" <?= $category === 'Web Development' ? 'selected' : '' ?>>Web Development</option>
            <option value="Web & Digital Strategy" <?= $category === 'Web & Digital Strategy' ? 'selected' : '' ?>>Web &amp; Digital Strategy</option>
            <option value="UI/UX & Branding" <?= $category === 'UI/UX & Branding' ? 'selected' : '' ?>>UI/UX &amp; Branding</option>
            <option value="Digital Marketing & SEO" <?= $category === 'Digital Marketing & SEO' ? 'selected' : '' ?>>Digital Marketing &amp; SEO</option>
            <option value="E-Commerce & Marketplaces" <?= $category === 'E-Commerce & Marketplaces' ? 'selected' : '' ?>>E-Commerce &amp; Marketplaces</option>
            <option value="Cloud Solutions & IT" <?= $category === 'Cloud Solutions & IT' ? 'selected' : '' ?>>Cloud Solutions &amp; IT</option>
          </select>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="publishedAt">Publication Date &amp; Time</label>
          <input type="datetime-local" id="publishedAt" name="published_at" value="<?= e($publishedAt) ?>" class="adm-input">
          <div class="adm-hint">Controls the schema `datePublished` and frontend article byline timestamp.</div>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="readingTimeInput">Reading Time</label>
          <div style="display: flex; gap: 0.5rem;">
            <input type="text" id="readingTimeInput" name="reading_time" value="<?= e($readingTime) ?>" class="adm-input" placeholder="e.g. 5 min read">
            <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="calcReadingTime()" title="Recalculate reading time based on word count" style="white-space: nowrap;">Auto-Calc</button>
          </div>
          <div class="adm-hint">Auto-calculated (200 wpm) or overridden manually.</div>
        </div>

        <div class="adm-form-group" style="margin-bottom: 0;">
          <label style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.85rem; color: var(--adm-text); cursor: pointer;">
            <input type="checkbox" id="isFeatured" name="is_featured" value="1" <?= $isFeatured ? 'checked' : '' ?> style="accent-color: var(--adm-teal); width: 16px; height: 16px;">
            <span style="font-weight: 500;">Featured Article (Spotlight on Homepage &amp; Insights)</span>
          </label>
        </div>
      </div>

      <!-- 2. Hero Cover Media Card -->
      <div class="admin-card" style="margin-top: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
          <h3 class="admin-card-title" style="margin: 0;">Hero Cover Media</h3>
          <span class="adm-res-badge">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            1600 &times; 900 (16:9)
          </span>
        </div>

        <!-- Internal Managed Relative Path (Hidden) -->
        <input type="hidden" id="featuredImagePath" name="featured_image" value="<?= e($featuredImage) ?>">

        <div class="adm-form-group">
          <label class="adm-label">Upload New Cover Image</label>
          <input type="file" name="image_file" id="coverImageFile" accept="image/jpeg,image/png,image/webp" class="adm-input" onchange="previewSelectedImage(this)">
          <div class="adm-hint">JPG, PNG, WebP &bull; Max 5 MB. Stored securely in uploads.</div>
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="coverImageAlt">Cover Image Alt Text (SEO)</label>
          <input type="text" id="coverImageAlt" name="cover_image_alt" value="<?= e($coverImageAlt) ?>" class="adm-input" placeholder="Descriptive visual explanation for Google Images and accessibility">
        </div>

        <!-- Cover Preview Box -->
        <div id="coverPreviewBox" style="<?= empty($featuredImage) ? 'display: none;' : '' ?> margin-top: 1rem;">
          <div style="font-size: 0.78rem; font-weight: 600; color: var(--adm-text-dim); margin-bottom: 0.4rem;">Staged Cover Preview:</div>
          <div style="position: relative; border-radius: 6px; overflow: hidden; border: 1px solid var(--adm-border);">
            <img id="coverPreviewImg" src="<?= !empty($featuredImage) ? '../' . e($featuredImage) : '' ?>" alt="Cover preview" style="width: 100%; height: 160px; object-fit: cover; display: block;">
            <button type="button" onclick="removeCoverImage()" style="position: absolute; top: 8px; right: 8px; background: rgba(239, 68, 68, 0.9); color: #fff; border: none; border-radius: 4px; padding: 4px 8px; font-size: 0.75rem; cursor: pointer;">Remove</button>
          </div>
        </div>

        <!-- Quick Select from Pre-seeded Assets -->
        <div style="margin-top: 1.25rem;">
          <div style="font-size: 0.78rem; font-weight: 600; color: var(--adm-text-dim); margin-bottom: 0.5rem;">Or Choose Studio Asset:</div>
          <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem;">
            <?php foreach ($libraryImages as $path => $label): ?>
              <div onclick="selectLibraryCover('<?= $path ?>')" style="border: 1px solid var(--adm-border); border-radius: 4px; overflow: hidden; cursor: pointer; transition: border-color 0.15s ease;" title="<?= e($label) ?>">
                <img src="../<?= $path ?>" alt="<?= e($label) ?>" style="width: 100%; height: 50px; object-fit: cover; display: block;">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- 3. Author Bylines Card -->
      <div class="admin-card" style="margin-top: 1.5rem;">
        <h3 class="admin-card-title" style="margin-bottom: 1rem;">Author Bylines</h3>

        <div class="adm-form-group">
          <label class="adm-label" for="blogAuthor">Author Name</label>
          <input type="text" id="blogAuthor" name="author" value="<?= e($author) ?>" class="adm-input" placeholder="e.g. Managing Partner">
        </div>

        <div class="adm-form-group">
          <label class="adm-label" for="authorTitle">Author Role / Designation</label>
          <input type="text" id="authorTitle" name="author_title" value="<?= e($authorTitle) ?>" class="adm-input" placeholder="e.g. Senior Cloud Architect &amp; Partner">
        </div>

        <div class="adm-form-group" style="margin-bottom: 0;">
          <label class="adm-label" for="authorBio">Author Bio Snippet</label>
          <textarea id="authorBio" name="author_bio" rows="2" class="adm-textarea" placeholder="Brief expert byline summary included in Schema.org Person entity and article footer..."><?= e($authorBio) ?></textarea>
        </div>
      </div>

    </div>

  </div> <!-- Closes .adm-form-grid -->

  <!-- ================= SCHEMA MARKUP PANEL (100% FULL MAIN CONTENT WIDTH) ================= -->
  <div class="admin-card adm-schema-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem; flex-wrap: wrap; gap: 0.75rem;">
      <div style="display: flex; align-items: center; gap: 0.75rem;">
        <h3 class="admin-card-title" style="margin: 0; font-size: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--adm-teal);"><path d="M16 18l6-6-6-6"/><path d="M8 6l-6 6 6 6"/></svg>
          <span>Schema Markup</span>
        </h3>
        <span id="schemaStatusBadge" class="status-pill status-published" style="font-size: 0.72rem; font-weight: 600;">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
          Active &bull; Validated
        </span>
      </div>
      <div style="font-size: 0.76rem; color: var(--adm-text-dim); font-family: var(--adm-font-mono);">
        Schema.org / JSON-LD
      </div>
    </div>

    <div style="font-size: 0.82rem; color: var(--adm-text-muted); margin-bottom: 1.15rem; line-height: 1.5;">
      Configure Google-compliant structured data for rich snippets, author authority, breadcrumb trails, and search engine knowledge graph integration.
    </div>

    <!-- Schema Type Indicator Badges -->
    <div style="margin-bottom: 1.25rem;">
      <div style="font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--adm-text-dim); margin-bottom: 0.4rem;">
        Generated Schema Entities:
      </div>
      <div class="adm-schema-types" style="margin: 0;">
        <span class="adm-schema-type-pill active" id="pillBlogPosting">&bull; BlogPosting</span>
        <span class="adm-schema-type-pill active" id="pillBreadcrumb">&bull; BreadcrumbList</span>
        <span class="adm-schema-type-pill active" id="pillOrg">&bull; Organization</span>
        <span class="adm-schema-type-pill active" id="pillPerson">&bull; Person (Author)</span>
        <span class="adm-schema-type-pill optional" id="faqSchemaPill" title="Dynamically embeds FAQPage when Q&A content is detected">&bull; FAQPage (Dynamic)</span>
      </div>
    </div>

    <!-- Schema Mode Selectors (Option A vs Option B) -->
    <div class="adm-schema-mode-grid">
      <label class="adm-radio-card <?= $schemaMode === 'auto' ? 'selected' : '' ?>" id="radioCardAuto" style="margin-bottom: 0;">
        <input type="radio" name="schema_mode" value="auto" <?= $schemaMode === 'auto' ? 'checked' : '' ?> onchange="switchSchemaMode('auto')">
        <div class="adm-radio-card-body">
          <div class="adm-radio-card-title">Option A: Recommended (Default)</div>
          <div class="adm-radio-card-desc">Automatically compiles valid Schema.org JSON-LD from article data, author bylines, and dynamic content.</div>
        </div>
      </label>

      <label class="adm-radio-card <?= $schemaMode === 'custom' ? 'selected' : '' ?>" id="radioCardCustom" style="margin-bottom: 0;">
        <input type="radio" name="schema_mode" value="custom" <?= $schemaMode === 'custom' ? 'checked' : '' ?> onchange="switchSchemaMode('custom')">
        <div class="adm-radio-card-body">
          <div class="adm-radio-card-title">Option B: Custom JSON-LD</div>
          <div class="adm-radio-card-desc">Paste custom Schema.org code or upload a .json file. Validated before saving.</div>
        </div>
      </label>
    </div>

    <!-- OPTION A: Live Generated Schema Preview -->
    <div id="schemaOptionAContainer" style="<?= $schemaMode === 'custom' ? 'display: none;' : '' ?>">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
          <span style="font-size: 0.78rem; font-weight: 600; color: var(--adm-text-dim);">Live Schema Preview (Read-Only)</span>
          <span style="font-size: 0.7rem; color: var(--adm-teal); font-family: var(--adm-font-mono);">[Updates Automatically]</span>
        </div>
        <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="copyRecommendedSchema()" style="padding: 4px 12px; font-size: 0.76rem; display: inline-flex; align-items: center; gap: 0.35rem;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
          <span>Copy JSON-LD</span>
        </button>
      </div>
      
      <pre class="adm-schema-code-preview"><code id="recommendedSchemaCode"></code></pre>
    </div>

    <!-- OPTION B: Custom JSON-LD Editor -->
    <div id="schemaOptionBContainer" style="<?= $schemaMode === 'auto' ? 'display: none;' : '' ?>">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
          <label class="adm-label" for="customSchemaEditor" style="margin-bottom: 0;">Custom JSON-LD Editor</label>
          <span id="customValidationIndicator" class="status-pill status-published" style="font-size: 0.68rem; padding: 1px 6px;">Valid JSON</span>
        </div>
        <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
          <label class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 4px 10px; font-size: 0.74rem; cursor: pointer; margin: 0; display: inline-flex; align-items: center; gap: 0.3rem;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            <span>Upload JSON</span>
            <input type="file" id="schemaFileInput" accept=".json,application/json" style="display: none;" onchange="handleSchemaFileUpload(this)">
          </label>
          <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="beautifyCustomSchema()" style="padding: 4px 10px; font-size: 0.74rem;">Format</button>
          <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="validateCustomSchemaClient(true)" style="padding: 4px 10px; font-size: 0.74rem;">Validate</button>
          <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="resetCustomSchemaToRecommended()" style="padding: 4px 10px; font-size: 0.74rem; color: #FBBF24;" title="Populate custom editor with the currently generated recommended schema">Reset to Recommended</button>
        </div>
      </div>

      <div id="schemaSyntaxErrorBox" style="display: none; padding: 0.65rem 0.85rem; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 4px; color: #FCA5A5; font-size: 0.76rem; font-family: var(--adm-font-mono); margin-bottom: 0.6rem;"></div>

      <textarea name="custom_schema_json" id="customSchemaEditor" rows="14" class="adm-textarea" placeholder="{\n  &quot;@context&quot;: &quot;https://schema.org&quot;,\n  &quot;@type&quot;: &quot;BlogPosting&quot;,\n  ...\n}" style="width: 100%; box-sizing: border-box; font-family: var(--adm-font-mono); font-size: 0.78rem; tab-size: 2; line-height: 1.5; color: #14E5D4; background: #061326; min-height: 340px;" oninput="validateCustomSchemaClient(false)"><?= e($customSchemaJson) ?></textarea>
      <div class="adm-hint" style="margin-top: 0.4rem;">JSON syntax is strictly validated before saving or publishing. Arbitrary script tags are blocked.</div>
    </div>

  </div>

  <!-- Bottom Workspace Actions Bar (Save Draft & Publish Article) -->
  <div class="adm-form-actions-bottom">
    <button type="button" class="btn-adm btn-adm-secondary" onclick="submitDoc('draft')" style="padding: 0.65rem 1.4rem;">
      Save Draft
    </button>
    <button type="button" class="btn-adm btn-adm-primary" onclick="submitDoc('published')" style="padding: 0.65rem 1.6rem; font-weight: 600;">
      Publish Article &rarr;
    </button>
  </div>
</form>

<!-- ================= MODALS ================= -->

<!-- Hyperlink Modal -->
<div class="adm-modal-overlay" id="linkModal">
  <div class="adm-modal-card">
    <div class="adm-modal-header">
      <h4 class="adm-modal-title">Insert / Edit Hyperlink</h4>
      <button type="button" class="adm-modal-close" onclick="closeModal('linkModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div class="adm-form-group">
        <label class="adm-label">Destination URL <span class="required">*</span></label>
        <input type="text" id="linkModalUrl" class="adm-input" placeholder="https://example.com or /case-studies.php">
      </div>
      <div class="adm-form-group">
        <label class="adm-label">Link Text</label>
        <input type="text" id="linkModalText" class="adm-input" placeholder="Anchor text">
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--adm-text); cursor: pointer;">
          <input type="checkbox" id="linkModalTarget" checked>
          <span>Open link in new browser tab (`target="_blank"`)</span>
        </label>
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('linkModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyLinkModal()">Apply Link</button>
    </div>
  </div>
</div>

<!-- Insert Image Modal -->
<div class="adm-modal-overlay" id="imageModal">
  <div class="adm-modal-card">
    <div class="adm-modal-header">
      <h4 class="adm-modal-title">Insert Document Image</h4>
      <button type="button" class="adm-modal-close" onclick="closeModal('imageModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div class="adm-form-group">
        <label class="adm-label">Image URL / Path <span class="required">*</span></label>
        <input type="text" id="imageModalUrl" class="adm-input" placeholder="assets/images/insight-ai-strategy.webp or https://...">
      </div>
      <div class="adm-form-group">
        <label class="adm-label">Image Alt Text (SEO &amp; Accessibility)</label>
        <input type="text" id="imageModalAlt" class="adm-input" placeholder="Descriptive image explanation">
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label class="adm-label">Image Title / Caption (Optional)</label>
        <input type="text" id="imageModalTitle" class="adm-input" placeholder="Hover tooltip or caption">
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('imageModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyImageModal()">Insert Image</button>
    </div>
  </div>
</div>

<!-- Edit Image Details Modal -->
<div class="adm-modal-overlay" id="editImageAltModal">
  <div class="adm-modal-card">
    <div class="adm-modal-header">
      <h4 class="adm-modal-title">Edit Image Details</h4>
      <button type="button" class="adm-modal-close" onclick="closeModal('editImageAltModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div class="adm-form-group">
        <label class="adm-label">Image Alt Text (SEO)</label>
        <input type="text" id="editImageAltInput" class="adm-input" placeholder="Describe this image for search engines and screen readers">
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label class="adm-label">Image Title / Hover Text</label>
        <input type="text" id="editImageTitleInput" class="adm-input" placeholder="Optional title attribute">
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('editImageAltModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyEditImageAltModal()">Update Image</button>
    </div>
  </div>
</div>

<!-- Insert Table Modal -->
<div class="adm-modal-overlay" id="tableModal">
  <div class="adm-modal-card">
    <div class="adm-modal-header">
      <h4 class="adm-modal-title">Insert Structured Table</h4>
      <button type="button" class="adm-modal-close" onclick="closeModal('tableModal')">&times;</button>
    </div>
    <div class="adm-modal-body">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div class="adm-form-group">
          <label class="adm-label">Number of Rows</label>
          <input type="number" id="tableModalRows" class="adm-input" value="3" min="1" max="25">
        </div>
        <div class="adm-form-group">
          <label class="adm-label">Number of Columns</label>
          <input type="number" id="tableModalCols" class="adm-input" value="3" min="1" max="10">
        </div>
      </div>
      <div class="adm-form-group" style="margin-bottom: 0;">
        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--adm-text); cursor: pointer;">
          <input type="checkbox" id="tableModalHeader" checked>
          <span>Include Table Header Row (`<thead>`)</span>
        </label>
      </div>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('tableModal')">Cancel</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="applyTableModal()">Create Table</button>
    </div>
  </div>
</div>

<!-- Compiled Schema Preview Modal -->
<div class="adm-modal-overlay" id="compiledSchemaModal">
  <div class="adm-modal-card" style="max-width: 720px; width: 92%;">
    <div class="adm-modal-header">
      <div style="display: flex; align-items: center; gap: 0.6rem;">
        <h4 class="adm-modal-title">Live Compiled Schema.org Graph</h4>
        <span class="status-pill status-published" style="font-size: 0.7rem;">Valid JSON-LD</span>
      </div>
      <button type="button" class="adm-modal-close" onclick="closeModal('compiledSchemaModal')">&times;</button>
    </div>
    <div class="adm-modal-body" style="padding: 1.25rem;">
      <div style="font-size: 0.78rem; color: var(--adm-text-dim); margin-bottom: 0.75rem;">
        This Schema.org JSON-LD multi-type graph will be embedded into the <code>&lt;head&gt;</code> of the article upon publication:
      </div>
      <pre style="background: #061326; color: #14E5D4; padding: 1rem; border-radius: 6px; border: 1px solid var(--adm-border); font-family: var(--adm-font-mono); font-size: 0.76rem; max-height: 380px; overflow-y: auto; line-height: 1.45;"><code id="compiledSchemaCode"></code></pre>
    </div>
    <div class="adm-modal-footer">
      <button type="button" class="btn-adm btn-adm-secondary btn-adm-sm" onclick="closeModal('compiledSchemaModal')">Close</button>
      <button type="button" class="btn-adm btn-adm-primary btn-adm-sm" onclick="copyCompiledSchema()">Copy JSON-LD</button>
    </div>
  </div>
</div>

<!-- Core Editorial Engine -->
<script src="../assets/js/admin-editor.js"></script>

<script>
// Cover image handlers
function selectLibraryCover(path) {
  document.getElementById('featuredImagePath').value = path;
  document.getElementById('coverPreviewImg').src = '../' + path;
  document.getElementById('coverPreviewBox').style.display = 'block';
  showToast('Selected cover image from library', 'info');
  updateLivePreview();
}

function removeCoverImage() {
  document.getElementById('featuredImagePath').value = '';
  document.getElementById('coverPreviewBox').style.display = 'none';
  showToast('Cover image removed', 'info');
  updateLivePreview();
}

function previewSelectedImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('coverPreviewImg').src = e.target.result;
      document.getElementById('coverPreviewBox').style.display = 'block';
      showToast('Image staged for upload', 'info');
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// Markdown Import Handler
document.getElementById('mdFileInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function(evt) {
    let text = evt.target.result;

    // Parse Frontmatter if present
    if (text.startsWith('---')) {
      const parts = text.split('---');
      if (parts.length >= 3) {
        const frontmatter = parts[1];
        text = parts.slice(2).join('---').trim();

        frontmatter.split('\n').forEach(line => {
          const colonIdx = line.indexOf(':');
          if (colonIdx > 0) {
            const key = line.substring(0, colonIdx).trim().toLowerCase();
            const val = line.substring(colonIdx + 1).trim().replace(/^["']|["']$/g, '');
            if (key === 'title') document.getElementById('blogTitle').value = val;
            if (key === 'category') document.getElementById('blogCategory').value = val;
            if (key === 'author') document.getElementById('blogAuthor').value = val;
            if (key === 'author_title') document.getElementById('authorTitle').value = val;
            if (key === 'excerpt' || key === 'summary') document.getElementById('blogExcerpt').value = val;
            if (key === 'tags') document.getElementById('blogTags').value = val;
            if (key === 'slug') document.getElementById('blogSlug').value = val;
            if (key === 'cover_image_alt') document.getElementById('coverImageAlt').value = val;
          }
        });
      }
    }

    document.getElementById('markdownEditor').value = text;
    syncFromMarkdown();
    showToast(`Imported ${file.name} successfully!`, 'info');
  };
  reader.readAsText(file);
});

// Markdown Export Handler
document.getElementById('exportMdBtn').addEventListener('click', function() {
  const title = document.getElementById('blogTitle').value || 'untitled-article';
  const category = document.getElementById('blogCategory').value;
  const author = document.getElementById('blogAuthor').value;
  const excerpt = document.getElementById('blogExcerpt').value;
  const tags = document.getElementById('blogTags').value;
  const coverAlt = document.getElementById('coverImageAlt').value;
  const mdBody = document.getElementById('markdownEditor').value;

  const frontmatter = [
    '---',
    `title: "${title.replace(/"/g, '\\"')}"`,
    `category: "${category}"`,
    `author: "${author}"`,
    `excerpt: "${excerpt.replace(/"/g, '\\"')}"`,
    `tags: "${tags}"`,
    `cover_image_alt: "${coverAlt.replace(/"/g, '\\"')}"`,
    `date: "${new Date().toISOString()}"`,
    '---',
    '',
    mdBody
  ].join('\n');

  const blob = new Blob([frontmatter], { type: 'text/markdown;charset=utf-8' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = (title.toLowerCase().replace(/[^a-z0-9]+/g, '-') || 'article') + '.md';
  a.click();
  showToast('Exported article as Markdown', 'info');
});

// Excerpt Character Counter
const excerptEl = document.getElementById('blogExcerpt');
const excerptCount = document.getElementById('excerptCount');
if (excerptEl && excerptCount) {
  const updateExcerptCount = () => {
    excerptCount.textContent = `${excerptEl.value.length}/180`;
  };
  excerptEl.addEventListener('input', updateExcerptCount);
  updateExcerptCount();
}

// Auto-Calculate Reading Time
function calcReadingTime() {
  const editor = document.getElementById('visualEditor');
  const mdEditor = document.getElementById('markdownEditor');
  let text = '';
  if (editor && editor.innerText) {
    text = editor.innerText;
  } else if (mdEditor && mdEditor.value) {
    text = mdEditor.value;
  }
  const words = text.trim() ? text.trim().split(/\s+/).length : 0;
  const minutes = Math.max(1, Math.ceil(words / 200));
  const readingTimeStr = minutes + ' min read';
  const input = document.getElementById('readingTimeInput');
  if (input) {
    input.value = readingTimeStr;
    showToast('Calculated reading time: ' + readingTimeStr, 'info');
  }
}

// Schema Mode Switcher
function switchSchemaMode(mode) {
  const cardAuto = document.getElementById('radioCardAuto');
  const cardCustom = document.getElementById('radioCardCustom');
  const containerAuto = document.getElementById('schemaOptionAContainer');
  const containerCustom = document.getElementById('schemaOptionBContainer');
  const badge = document.getElementById('schemaStatusBadge');

  if (mode === 'custom') {
    if (cardAuto) cardAuto.classList.remove('selected');
    if (cardCustom) cardCustom.classList.add('selected');
    if (containerAuto) containerAuto.style.display = 'none';
    if (containerCustom) containerCustom.style.display = 'block';
    validateCustomSchemaClient(false);
  } else {
    if (cardAuto) cardAuto.classList.add('selected');
    if (cardCustom) cardCustom.classList.remove('selected');
    if (containerAuto) containerAuto.style.display = 'block';
    if (containerCustom) containerCustom.style.display = 'none';
    if (badge) {
      badge.className = 'status-pill status-published';
      badge.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 3px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Active &bull; Validated';
    }
    updateLiveRecommendedSchema();
  }
}

// Handle .json File Upload
function handleSchemaFileUpload(input) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      try {
        const parsed = JSON.parse(e.target.result);
        const editor = document.getElementById('customSchemaEditor');
        editor.value = JSON.stringify(parsed, null, 2);
        showToast('Loaded ' + file.name + ' successfully!', 'success');
        validateCustomSchemaClient(true);
      } catch (err) {
        showToast('Invalid JSON file: ' + err.message, 'error');
        const errBox = document.getElementById('schemaSyntaxErrorBox');
        if (errBox) {
          errBox.textContent = 'JSON Syntax Error in ' + file.name + ': ' + err.message;
          errBox.style.display = 'block';
        }
      }
    };
    reader.readAsText(file);
  }
}

// Format / Beautify Custom JSON
function beautifyCustomSchema() {
  const editor = document.getElementById('customSchemaEditor');
  const val = editor ? editor.value.trim() : '';
  if (!val) {
    showToast('Custom schema editor is empty', 'warning');
    return;
  }
  try {
    const parsed = JSON.parse(val);
    editor.value = JSON.stringify(parsed, null, 2);
    const errBox = document.getElementById('schemaSyntaxErrorBox');
    if (errBox) errBox.style.display = 'none';
    validateCustomSchemaClient(false);
    showToast('Formatted JSON successfully', 'success');
  } catch (err) {
    showToast('Cannot format invalid JSON: ' + err.message, 'error');
    const errBox = document.getElementById('schemaSyntaxErrorBox');
    if (errBox) {
      errBox.textContent = 'Format Error: ' + err.message;
      errBox.style.display = 'block';
    }
  }
}

// Validate Custom JSON Syntax Client-side
function validateCustomSchemaClient(showToastAlert = true) {
  const editor = document.getElementById('customSchemaEditor');
  const errBox = document.getElementById('schemaSyntaxErrorBox');
  const badge = document.getElementById('customValidationIndicator');
  const statusBadge = document.getElementById('schemaStatusBadge');
  const val = editor ? editor.value.trim() : '';

  if (!val) {
    if (errBox) errBox.style.display = 'none';
    if (badge) {
      badge.className = 'status-pill status-draft';
      badge.textContent = 'Empty';
    }
    return true;
  }

  try {
    const parsed = JSON.parse(val);
    if (typeof parsed !== 'object' || parsed === null) {
      throw new Error('Custom schema must be a valid JSON Object or Array.');
    }
    if (errBox) errBox.style.display = 'none';
    if (badge) {
      badge.className = 'status-pill status-published';
      badge.innerHTML = '<svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 3px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Valid JSON';
    }
    if (statusBadge) {
      statusBadge.className = 'status-pill status-published';
      statusBadge.innerHTML = '<svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 3px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Valid Custom Schema';
    }
    if (showToastAlert) showToast('Custom Schema JSON is valid!', 'success');
    return true;
  } catch (err) {
    if (errBox) {
      errBox.textContent = 'JSON Syntax Error: ' + err.message;
      errBox.style.display = 'block';
    }
    if (badge) {
      badge.className = 'status-pill status-archived';
      badge.textContent = 'Invalid Syntax';
    }
    if (statusBadge) {
      statusBadge.className = 'status-pill status-archived';
      statusBadge.textContent = 'Invalid JSON';
    }
    if (showToastAlert) showToast('JSON Syntax Error: ' + err.message, 'error');
    return false;
  }
}

// Reset Custom Schema to Recommended baseline
function resetCustomSchemaToRecommended() {
  const codeEl = document.getElementById('recommendedSchemaCode');
  const editor = document.getElementById('customSchemaEditor');
  if (codeEl && editor) {
    editor.value = codeEl.textContent;
    validateCustomSchemaClient(true);
    showToast('Reset custom editor with Recommended Schema baseline', 'info');
  }
}

// Copy Recommended Schema to Clipboard
function copyRecommendedSchema() {
  const codeEl = document.getElementById('recommendedSchemaCode');
  const code = codeEl ? codeEl.textContent : '';
  if (!code) return;
  navigator.clipboard.writeText(code).then(() => {
    showToast('Schema.org JSON-LD copied to clipboard!', 'success');
  }).catch(() => {
    showToast('Failed to copy to clipboard', 'error');
  });
}

// Build and render the Recommended Schema.org JSON-LD dynamically
function updateLiveRecommendedSchema() {
  const baseUrl = 'https://demo.businessdoctor.com';
  const title = (document.getElementById('blogTitle') ? document.getElementById('blogTitle').value.trim() : '') || 'Insight Article Title';
  const slug = (document.getElementById('blogSlug') ? document.getElementById('blogSlug').value.trim() : '') || 'article-slug';
  const canonicalField = document.getElementById('canonicalUrl') ? document.getElementById('canonicalUrl').value.trim() : '';
  const pageUrl = canonicalField || (baseUrl + '/insight-detail.php?slug=' + encodeURIComponent(slug));
  
  const coverImage = (document.getElementById('featuredImagePath') ? document.getElementById('featuredImagePath').value.trim() : '') || 'assets/images/insight-ai-strategy.webp';
  const coverAlt = (document.getElementById('coverImageAlt') ? document.getElementById('coverImageAlt').value.trim() : '') || title;
  const imageUrl = coverImage.startsWith('http') ? coverImage : (baseUrl + '/' + coverImage.replace(/^\/+/, ''));
  
  const authorName = (document.getElementById('blogAuthor') ? document.getElementById('blogAuthor').value.trim() : '') || 'BusinessDoctor Research Team';
  const authorRole = (document.getElementById('authorTitle') ? document.getElementById('authorTitle').value.trim() : '') || 'Senior Consultant';
  const authorBio = (document.getElementById('authorBio') ? document.getElementById('authorBio').value.trim() : '');
  const excerpt = (document.getElementById('blogExcerpt') ? document.getElementById('blogExcerpt').value.trim() : '') || 'Executive insights and enterprise strategies authored by BusinessDoctor.';
  const category = (document.getElementById('blogCategory') ? document.getElementById('blogCategory').value : 'Enterprise Strategy');
  const tags = (document.getElementById('blogTags') ? document.getElementById('blogTags').value.trim() : 'IT Strategy, Software Engineering');
  const publishedAtInput = document.getElementById('publishedAt') ? document.getElementById('publishedAt').value : '';
  const datePublished = publishedAtInput ? new Date(publishedAtInput).toISOString() : new Date().toISOString();
  const dateModified = new Date().toISOString();

  // Check content for FAQs and calculate word count
  const visualEd = document.getElementById('visualEditor');
  const mdEd = document.getElementById('markdownEditor');
  let rawContent = '';
  if (visualEd && visualEd.innerHTML) {
    rawContent = visualEd.innerHTML;
  } else if (mdEd && mdEd.value) {
    rawContent = mdEd.value;
  }
  const plainText = visualEd ? visualEd.innerText : (mdEd ? mdEd.value : '');
  const words = plainText.trim() ? plainText.trim().split(/\s+/).length : 0;

  // Detect FAQs in content
  const hasFaqs = /<dt\b|<details\b|faq|frequently asked questions|\bQ:\s*|\bA:\s*/i.test(rawContent);
  const faqPill = document.getElementById('faqSchemaPill');
  if (faqPill) {
    if (hasFaqs) {
      faqPill.className = 'adm-schema-type-pill active';
      faqPill.innerHTML = '&bull; FAQPage (Detected)';
    } else {
      faqPill.className = 'adm-schema-type-pill optional';
      faqPill.innerHTML = '&bull; FAQPage (Dynamic)';
    }
  }

  const authorId = baseUrl + '/#author-' + authorName.toLowerCase().replace(/[^a-z0-9]+/g, '-');
  const orgId = baseUrl + '/#organization';

  const graph = [
    {
      "@type": "BlogPosting",
      "@id": pageUrl + "#article",
      "isPartOf": {
        "@type": "WebSite",
        "@id": baseUrl + "/#website",
        "name": "BusinessDoctor",
        "url": baseUrl + "/"
      },
      "headline": title,
      "description": excerpt,
      "inLanguage": "en-US",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": pageUrl
      },
      "url": pageUrl,
      "datePublished": datePublished,
      "dateModified": dateModified,
      "articleSection": category,
      "keywords": tags,
      "wordCount": words,
      "image": {
        "@type": "ImageObject",
        "url": imageUrl,
        "caption": coverAlt
      },
      "author": {
        "@type": "Person",
        "@id": authorId,
        "name": authorName,
        "jobTitle": authorRole,
        ...(authorBio ? { "description": authorBio } : {})
      },
      "publisher": {
        "@type": "Organization",
        "@id": orgId,
        "name": "BusinessDoctor",
        "url": baseUrl + "/",
        "logo": {
          "@type": "ImageObject",
          "url": baseUrl + "/assets/img/og-preview.svg"
        }
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": pageUrl + "#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": baseUrl + "/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Insights & Perspectives",
          "item": baseUrl + "/insights.php"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": title,
          "item": pageUrl
        }
      ]
    },
    {
      "@type": "Organization",
      "@id": orgId,
      "name": "BusinessDoctor",
      "url": baseUrl + "/",
      "logo": {
        "@type": "ImageObject",
        "url": baseUrl + "/assets/img/og-preview.svg"
      },
      "sameAs": [
        "https://www.linkedin.com/company/businessdoctor",
        "https://twitter.com/businessdoctor"
      ]
    },
    {
      "@type": "Person",
      "@id": authorId,
      "name": authorName,
      "jobTitle": authorRole,
      "worksFor": {
        "@type": "Organization",
        "@id": orgId,
        "name": "BusinessDoctor",
        "url": baseUrl + "/"
      },
      ...(authorBio ? { "description": authorBio } : {})
    }
  ];

  if (hasFaqs) {
    graph.push({
      "@type": "FAQPage",
      "@id": pageUrl + "#faq",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "What strategic outcomes does this framework deliver?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "It provides measurable performance architecture, operational cost reduction, and resilient digital execution."
          }
        }
      ]
    });
  }

  const fullSchema = {
    "@context": "https://schema.org",
    "@graph": graph
  };

  const codeEl = document.getElementById('recommendedSchemaCode');
  if (codeEl) {
    codeEl.textContent = JSON.stringify(fullSchema, null, 2);
  }
}

// Bind live reactive update listeners
['blogTitle', 'blogSlug', 'blogAuthor', 'authorTitle', 'authorBio', 'blogExcerpt', 'coverImageAlt', 'canonicalUrl', 'blogTags'].forEach(id => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener('input', updateLiveRecommendedSchema);
  }
});

['publishedAt', 'blogCategory', 'featuredImagePath'].forEach(id => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener('change', updateLiveRecommendedSchema);
  }
});

const visualEditorEl = document.getElementById('visualEditor');
if (visualEditorEl) {
  visualEditorEl.addEventListener('input', updateLiveRecommendedSchema);
}
const mdEditorEl = document.getElementById('markdownEditor');
if (mdEditorEl) {
  mdEditorEl.addEventListener('input', updateLiveRecommendedSchema);
}

// Run initial live schema render on load
document.addEventListener('DOMContentLoaded', function() {
  updateLiveRecommendedSchema();
  if (document.getElementById('customSchemaEditor') && document.getElementById('customSchemaEditor').value.trim()) {
    validateCustomSchemaClient(false);
  }
});
updateLiveRecommendedSchema();

// Prevent submitting invalid custom JSON
const blogForm = document.getElementById('blogPostForm');
if (blogForm) {
  blogForm.addEventListener('submit', function(e) {
    const selectedMode = document.querySelector('input[name="schema_mode"]:checked');
    if (selectedMode && selectedMode.value === 'custom') {
      const isValid = validateCustomSchemaClient(false);
      if (!isValid) {
        e.preventDefault();
        showToast('Please fix JSON Syntax Errors in Custom Schema before saving.', 'error');
        const errBox = document.getElementById('schemaSyntaxErrorBox');
        if (errBox) {
          errBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return false;
      }
    }
  });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
