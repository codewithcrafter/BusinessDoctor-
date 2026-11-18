<?php
/**
 * BusinessDoctor Executive Admin — Custom Markdown Editor & Studio
 * Centrally author, inspect, customize, and preview machine-readable Markdown for any page.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/seo-sync.php';

$baseUrl = SeoSyncEngine::getBaseUrl();
$customRegistry = SeoSyncEngine::getCustomMarkdownRegistry();

// ------------------------------------------------------------
// 1. Inventory of All Known System Documents
// ------------------------------------------------------------
$knownFiles = [
    // Institutional
    'md/about.md' => [
        'category' => 'Institutional',
        'title' => 'Firm Profile & Practice (About)',
        'endpoint' => '/about.md',
        'can_reset' => true,
    ],
    'md/services.md' => [
        'category' => 'Institutional',
        'title' => 'Services Hub & Capabilities',
        'endpoint' => '/services.md',
        'can_reset' => true,
    ],
    'md/contact.md' => [
        'category' => 'Institutional',
        'title' => 'Executive Contact & Inquiries',
        'endpoint' => '/contact.md',
        'can_reset' => true,
    ],
    'md/audit.md' => [
        'category' => 'Institutional',
        'title' => 'Digital Architecture Diagnostic Audit',
        'endpoint' => '/audit.md',
        'can_reset' => true,
    ],
    'md/insights.md' => [
        'category' => 'Institutional',
        'title' => 'Engineering Perspectives & Blog Hub',
        'endpoint' => '/blog.md',
        'can_reset' => true,
    ],
    'md/case-studies.md' => [
        'category' => 'Institutional',
        'title' => 'Client Turnarounds & Case Studies Hub',
        'endpoint' => '/case-studies.md',
        'can_reset' => true,
    ],
];

// Add 10 Active Services
$services = SeoSyncEngine::getActiveServices();
foreach ($services as $slug => $s) {
    $knownFiles['md/services/' . $slug . '.md'] = [
        'category' => 'Practice Disciplines',
        'title' => ($s['number'] ?? '') . ' ' . ($s['name'] ?? $slug),
        'endpoint' => '/service/' . $slug . '.md',
        'service_slug' => $slug,
        'can_reset' => true,
    ];
}

// Add Published Case Studies
$cases = SeoSyncEngine::getPublishedCaseStudies();
foreach ($cases as $c) {
    $knownFiles['md/case-studies/' . $c['slug'] . '.md'] = [
        'category' => 'Case Studies',
        'title' => $c['title'] ?? $c['slug'],
        'endpoint' => '/case-studies/' . $c['slug'] . '.md',
        'case_slug' => $c['slug'],
        'can_reset' => true,
    ];
}

// Add Published Blogs
$blogs = SeoSyncEngine::getPublishedInsights();
foreach ($blogs as $b) {
    $knownFiles['md/insights/' . $b['slug'] . '.md'] = [
        'category' => 'Technical Blogs',
        'title' => $b['title'] ?? $b['slug'],
        'endpoint' => '/blog/' . $b['slug'] . '.md',
        'blog_slug' => $b['slug'],
        'can_reset' => true,
    ];
}

// Also scan physical md/ directory for any extra/custom pages
$allPhysical = glob(ROOT_PATH . '/md/*.md') ?: [];
$subPhysical = glob(ROOT_PATH . '/md/*/*.md') ?: [];
$normalizedRoot = rtrim(str_replace('\\', '/', ROOT_PATH), '/');
foreach (array_merge($allPhysical, $subPhysical) as $pPath) {
    $normalizedP = str_replace('\\', '/', $pPath);
    $rel = ltrim(str_replace($normalizedRoot . '/', '', $normalizedP), '/');
    if (!str_starts_with($rel, 'md/')) {
        $rel = 'md/' . $rel;
    }
    if (!isset($knownFiles[$rel]) && basename($rel) !== '.custom_markdown.json' && basename($rel) !== 'index.md') {
        $baseName = basename($rel, '.md');
        $endpoint = '/' . (str_starts_with($rel, 'md/') ? substr($rel, 3) : $rel);
        $knownFiles[$rel] = [
            'category' => 'Custom Markdown Pages',
            'title' => 'Custom Page: ' . ucwords(str_replace(['-', '_'], ' ', $baseName)),
            'endpoint' => $endpoint,
            'can_reset' => false,
        ];
    }
}

// ------------------------------------------------------------
// 2. Determine Currently Selected File
// ------------------------------------------------------------
$selectedFile = trim($_GET['file'] ?? $_POST['file'] ?? 'md/about.md');
$selectedFile = ltrim(str_replace('\\', '/', $selectedFile), '/');

// Security check: must reside inside md/ and end with .md
if (!str_starts_with($selectedFile, 'md/') || str_contains($selectedFile, '..') || !str_ends_with($selectedFile, '.md')) {
    $selectedFile = 'md/about.md';
}

$fullFilePath = ROOT_PATH . '/' . $selectedFile;
$fileMeta = $knownFiles[$selectedFile] ?? [
    'category' => 'Custom Markdown Pages',
    'title' => 'Custom: ' . basename($selectedFile, '.md'),
    'endpoint' => '/' . substr($selectedFile, 3),
    'can_reset' => false,
];

// ------------------------------------------------------------
// 3. Handle Form Submissions (Save / Reset)
// ------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'Security token expired. Please retry.');
        header('Location: markdown-edit.php?file=' . urlencode($selectedFile));
        exit;
    }

    $action = $_POST['action'] ?? 'save';

    if ($action === 'save') {
        $markdownContent = (string)($_POST['markdown_content'] ?? '');
        $documentTitle = trim((string)($_POST['document_title'] ?? $fileMeta['title']));

        // Ensure parent directory exists
        $targetDir = dirname($fullFilePath);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        // Save atomically
        if (file_put_contents($fullFilePath, $markdownContent) !== false) {
            // Register as custom markdown override
            SeoSyncEngine::setCustomMarkdown($selectedFile, $documentTitle, $adminUser['full_name'] ?? 'Admin');
            setFlashMessage('success', "Markdown file '{$selectedFile}' saved successfully! Changes are live immediately at {$fileMeta['endpoint']}.");
        } else {
            setFlashMessage('error', "Failed to write to file '{$selectedFile}'. Check filesystem permissions.");
        }

        header('Location: markdown-edit.php?file=' . urlencode($selectedFile));
        exit;
    }

    if ($action === 'reset_default') {
        $defaultContent = '';

        // Generate default based on file type
        if ($selectedFile === 'md/home.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('home');
        } elseif ($selectedFile === 'md/about.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('about');
        } elseif ($selectedFile === 'md/contact.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('contact');
        } elseif ($selectedFile === 'md/services.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('services');
        } elseif ($selectedFile === 'md/audit.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('audit');
        } elseif ($selectedFile === 'md/insights.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('insights');
        } elseif ($selectedFile === 'md/case-studies.md') {
            $defaultContent = SeoSyncEngine::generateStaticPageMarkdown('case-studies');
        } elseif (!empty($fileMeta['service_slug'])) {
            $sData = getPracticeBySlug($fileMeta['service_slug']);
            $defaultContent = SeoSyncEngine::generateServiceMarkdown($fileMeta['service_slug'], $sData);
        } elseif (!empty($fileMeta['case_slug'])) {
            $cStmt = $pdo->prepare("SELECT * FROM case_studies WHERE slug = ? LIMIT 1");
            $cStmt->execute([$fileMeta['case_slug']]);
            $cData = $cStmt->fetch(PDO::FETCH_ASSOC);
            $defaultContent = $cData ? SeoSyncEngine::generateCaseStudyMarkdown($cData) : '';
        } elseif (!empty($fileMeta['blog_slug'])) {
            $bStmt = $pdo->prepare("SELECT * FROM insights WHERE slug = ? LIMIT 1");
            $bStmt->execute([$fileMeta['blog_slug']]);
            $bData = $bStmt->fetch(PDO::FETCH_ASSOC);
            $defaultContent = $bData ? SeoSyncEngine::generateBlogMarkdown($bData) : '';
        }

        if ($defaultContent !== '') {
            file_put_contents($fullFilePath, $defaultContent);
            SeoSyncEngine::removeCustomMarkdown($selectedFile);
            setFlashMessage('success', "Markdown file '{$selectedFile}' has been reset to the automatic generator template.");
        } else {
            setFlashMessage('error', "No automatic template generator is configured for '{$selectedFile}'.");
        }

        header('Location: markdown-edit.php?file=' . urlencode($selectedFile));
        exit;
    }
}

// ------------------------------------------------------------
// 4. Load Current Content of Selected File
// ------------------------------------------------------------
$currentContent = '';
$fileExists = file_exists($fullFilePath);
if ($fileExists) {
    $currentContent = (string)file_get_contents($fullFilePath);
} else {
    // Boilerplate for new custom file
    $cleanSlug = basename($selectedFile, '.md');
    $cleanTitle = ucwords(str_replace(['-', '_'], ' ', $cleanSlug));
    $currentContent = <<<MD
# {$cleanTitle}

> Custom document overview for BusinessDoctor digital practice.

## Document Information
- **Canonical URL**: [{$baseUrl}/{$cleanSlug}]({$baseUrl}/{$cleanSlug})
- **Clean Markdown URL**: [{$baseUrl}/{$cleanSlug}.md]({$baseUrl}/{$cleanSlug}.md)
- **Central Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)

---

## 01 // Overview & Scope
Add your custom content here according to your business needs...

MD;
}

$isCustomOverride = SeoSyncEngine::isCustomMarkdown($selectedFile);
$customMeta = $customRegistry[$selectedFile] ?? null;

$pageTitle = 'Edit Markdown: ' . $fileMeta['title'];
require_once __DIR__ . '/includes/header.php';
?>

<!-- Content Header Toolbar -->
<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.25rem; width: 100%; box-sizing: border-box;">
  <div style="max-width: 680px;">
    <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--adm-font-mono); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--adm-teal); background: rgba(0, 242, 254, 0.08); border: 1px solid rgba(0, 242, 254, 0.2); padding: 0.2rem 0.6rem; border-radius: 4px; margin-bottom: 0.6rem;">
      <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--adm-teal); display: inline-block;"></span>
      <span>STUDIO // CUSTOM MARKDOWN EDITOR</span>
    </div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #FFFFFF; margin: 0 0 0.4rem; font-family: var(--adm-font-display); letter-spacing: -0.01em;">
      <?= e($fileMeta['title']) ?>
    </h2>
    <p style="color: var(--adm-text-muted, #94A3B8); font-size: 0.92rem; margin: 0; line-height: 1.55;">
      Directly author and customize machine-readable Markdown for this page. Changes take effect on the live website and AI crawler endpoints immediately upon saving.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
    <a href="..<?= $fileMeta['endpoint'] ?>" target="_blank" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.65rem 1rem; display: inline-flex; align-items: center; gap: 0.45rem;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 15px; height: 15px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      <span>View Live .md ↗</span>
    </a>
    <a href="markdown-health.php" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.65rem 1rem; display: inline-flex; align-items: center; gap: 0.4rem;">
      <span>&larr; Back to Health Dashboard</span>
    </a>
  </div>
</div>

<!-- Document Selector Bar -->
<div class="admin-card" style="padding: 1.25rem 1.5rem; margin-bottom: 1.75rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <!-- Switch File Dropdown -->
    <div style="display: flex; align-items: center; gap: 0.85rem; flex: 1; min-width: 280px;">
      <label for="fileSelect" style="font-family: var(--adm-font-mono); font-size: 0.78rem; text-transform: uppercase; color: var(--adm-text-muted); font-weight: 700; white-space: nowrap;">
        Select Document:
      </label>
      <select id="fileSelect" onchange="window.location.href='markdown-edit.php?file=' + encodeURIComponent(this.value);" style="background: #040D1A; color: #FFFFFF; border: 1px solid var(--adm-border); border-radius: 6px; padding: 0.55rem 0.85rem; font-size: 0.88rem; width: 100%; max-width: 480px; font-family: var(--adm-font-mono);">
        <?php
        $grouped = [];
        foreach ($knownFiles as $fPath => $fInfo) {
            $cat = $fInfo['category'] ?? 'Other';
            $grouped[$cat][$fPath] = $fInfo;
        }
        foreach ($grouped as $catName => $items): ?>
          <optgroup label="=== <?= e($catName) ?> ===">
            <?php foreach ($items as $fPath => $fInfo): ?>
              <option value="<?= e($fPath) ?>" <?= $selectedFile === $fPath ? 'selected' : '' ?>>
                <?= e($fInfo['title']) ?> (<?= e($fPath) ?>)
              </option>
            <?php endforeach; ?>
          </optgroup>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Status Badges -->
    <div style="display: flex; align-items: center; gap: 0.65rem;">
      <?php if ($isCustomOverride): ?>
        <span style="background: rgba(245, 158, 11, 0.12); color: #F59E0B; border: 1px solid rgba(245, 158, 11, 0.35); padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.76rem; font-family: var(--adm-font-mono); font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
          <span style="width: 6px; height: 6px; border-radius: 50%; background: #F59E0B; display: inline-block;"></span>
          CUSTOM USER OVERRIDE
          <?php if (!empty($customMeta['updated_at'])): ?>
            <span style="opacity: 0.7; font-weight: 400;">(<?= e($customMeta['updated_at']) ?>)</span>
          <?php endif; ?>
        </span>
      <?php else: ?>
        <span style="background: rgba(16, 185, 129, 0.12); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.35); padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.76rem; font-family: var(--adm-font-mono); font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;">
          <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981; display: inline-block;"></span>
          AUTO-GENERATED TEMPLATE
        </span>
      <?php endif; ?>

      <button type="button" onclick="promptCreateNew();" class="btn-adm btn-adm-secondary btn-adm-sm" style="font-size: 0.78rem; padding: 0.4rem 0.75rem;">
        + New Custom File
      </button>
    </div>
  </div>
</div>

<!-- Main Markdown Form -->
<form method="POST" id="markdownForm">
  <?= csrfField() ?>
  <input type="hidden" name="action" id="formAction" value="save">
  <input type="hidden" name="file" value="<?= e($selectedFile) ?>">

  <!-- Document Meta Strip -->
  <div class="admin-card" style="padding: 1rem 1.5rem; margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; background: rgba(10, 25, 47, 0.6);">
    <div style="display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;">
      <div>
        <span style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase;">File Target:</span>
        <code style="color: var(--adm-teal); font-size: 0.82rem; margin-left: 0.35rem;"><?= e($selectedFile) ?></code>
      </div>
      <div>
        <span style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase;">Live Endpoint:</span>
        <a href="..<?= $fileMeta['endpoint'] ?>" target="_blank" style="color: #60A5FA; font-size: 0.82rem; margin-left: 0.35rem; font-family: var(--adm-font-mono); text-decoration: none;">
          <?= e($fileMeta['endpoint']) ?> ↗
        </a>
      </div>
    </div>

    <!-- View Mode Switcher -->
    <div style="display: inline-flex; background: #040D1A; border: 1px solid var(--adm-border); border-radius: 6px; padding: 3px;">
      <button type="button" id="btnModeSplit" onclick="setViewMode('split')" style="background: var(--adm-teal-dim); color: var(--adm-teal); border: none; padding: 0.3rem 0.75rem; border-radius: 4px; font-size: 0.78rem; font-family: var(--adm-font-mono); cursor: pointer; font-weight: 700;">
        Split Screen
      </button>
      <button type="button" id="btnModeEdit" onclick="setViewMode('edit')" style="background: transparent; color: var(--adm-text-muted); border: none; padding: 0.3rem 0.75rem; border-radius: 4px; font-size: 0.78rem; font-family: var(--adm-font-mono); cursor: pointer;">
        Editor Only
      </button>
      <button type="button" id="btnModePreview" onclick="setViewMode('preview')" style="background: transparent; color: var(--adm-text-muted); border: none; padding: 0.3rem 0.75rem; border-radius: 4px; font-size: 0.78rem; font-family: var(--adm-font-mono); cursor: pointer;">
        Preview Only
      </button>
    </div>
  </div>

  <!-- Markdown Formatting Quick Toolbar -->
  <div style="background: #040D1A; border: 1px solid var(--adm-border); border-bottom: none; border-top-left-radius: var(--adm-radius-lg); border-top-right-radius: var(--adm-radius-lg); padding: 0.65rem 1rem; display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
    <span style="font-family: var(--adm-font-mono); font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase; margin-right: 0.5rem;">Toolbar:</span>
    <button type="button" class="btn-md-tool" onclick="insertSyntax('**', '**')" title="Bold"><strong>B</strong></button>
    <button type="button" class="btn-md-tool" onclick="insertSyntax('*', '*')" title="Italic"><em>I</em></button>
    <button type="button" class="btn-md-tool" onclick="insertSyntax('~~', '~~')" title="Strikethrough"><del>S</del></button>
    <span style="color: var(--adm-border); margin: 0 0.2rem;">|</span>
    <button type="button" class="btn-md-tool" onclick="insertLinePrefix('# ')" title="Heading 1">H1</button>
    <button type="button" class="btn-md-tool" onclick="insertLinePrefix('## ')" title="Heading 2">H2</button>
    <button type="button" class="btn-md-tool" onclick="insertLinePrefix('### ')" title="Heading 3">H3</button>
    <span style="color: var(--adm-border); margin: 0 0.2rem;">|</span>
    <button type="button" class="btn-md-tool" onclick="insertLinePrefix('> ')" title="Blockquote">&ldquo; Quote</button>
    <button type="button" class="btn-md-tool" onclick="insertSyntax('`', '`')" title="Inline Code">`Code`</button>
    <button type="button" class="btn-md-tool" onclick="insertCodeBlock()" title="Code Block">``` Block</button>
    <span style="color: var(--adm-border); margin: 0 0.2rem;">|</span>
    <button type="button" class="btn-md-tool" onclick="insertLinePrefix('- ')" title="Bullet List">&bull; List</button>
    <button type="button" class="btn-md-tool" onclick="insertLinePrefix('1. ')" title="Numbered List">1. List</button>
    <button type="button" class="btn-md-tool" onclick="insertLink()" title="Hyperlink">[Link]</button>
    <button type="button" class="btn-md-tool" onclick="insertTable()" title="Insert Table">&#9638; Table</button>
  </div>

  <!-- Workspace Grid: Editor & Live Preview -->
  <div id="editorWorkspace" style="display: grid; grid-template-columns: 1fr 1fr; border: 1px solid var(--adm-border); border-bottom-left-radius: var(--adm-radius-lg); border-bottom-right-radius: var(--adm-radius-lg); overflow: hidden; background: #071526; min-height: 580px;">
    
    <!-- Left: Code Textarea -->
    <div id="editorPane" style="display: flex; flex-direction: column; background: #040D1A; border-right: 1px solid var(--adm-border);">
      <textarea id="markdownTextarea" name="markdown_content" spellcheck="false" style="width: 100%; height: 100%; min-height: 580px; background: transparent; border: none; color: #E2E8F0; font-family: var(--adm-font-mono), 'JetBrains Mono', Consolas, monospace; font-size: 0.92rem; line-height: 1.65; padding: 1.25rem 1.5rem; resize: vertical; outline: none; box-sizing: border-box;" placeholder="Type markdown content here..."><?= htmlspecialchars($currentContent, ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>

    <!-- Right: Live Rendered Preview -->
    <div id="previewPane" style="display: flex; flex-direction: column; background: #071526; overflow-y: auto; max-height: 750px;">
      <div style="background: rgba(15, 23, 42, 0.7); border-bottom: 1px solid var(--adm-border); padding: 0.5rem 1.25rem; font-family: var(--adm-font-mono); font-size: 0.74rem; color: var(--adm-text-muted); text-transform: uppercase; letter-spacing: 0.05em; display: flex; justify-content: space-between; align-items: center;">
        <span>Live Preview Output</span>
        <span style="color: var(--adm-teal); font-size: 0.7rem;">Real-Time Sync</span>
      </div>
      <div id="previewContent" class="markdown-preview-body" style="padding: 1.5rem 2rem; color: #E2E8F0; line-height: 1.7; font-size: 0.95rem;">
        <!-- Rendered HTML will inject here -->
      </div>
    </div>

  </div>

  <!-- Live Metrics Bar -->
  <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1.25rem; background: rgba(10, 25, 47, 0.6); border: 1px solid var(--adm-border); border-top: none; border-radius: 0 0 var(--adm-radius-lg) var(--adm-radius-lg); margin-top: -1px; margin-bottom: 2rem; font-family: var(--adm-font-mono); font-size: 0.78rem; color: var(--adm-text-muted); flex-wrap: wrap; gap: 0.75rem;">
    <div style="display: flex; gap: 1.25rem; align-items: center;">
      <span>Lines: <strong id="statLines" style="color: #FFFFFF;">0</strong></span>
      <span>Words: <strong id="statWords" style="color: #FFFFFF;">0</strong></span>
      <span>Characters: <strong id="statChars" style="color: #FFFFFF;">0</strong></span>
      <span>Size: <strong id="statSize" style="color: var(--adm-teal);">0 KB</strong></span>
    </div>
    <div style="color: #94A3B8;">
      Saved to: <code style="color: #FFFFFF;"><?= e($selectedFile) ?></code>
    </div>
  </div>

  <!-- Action Buttons Row -->
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 3.5rem;">
    <div style="display: flex; gap: 0.85rem; align-items: center;">
      <button type="submit" class="btn-adm btn-adm-primary" style="font-weight: 700; padding: 0.75rem 1.5rem; font-size: 0.95rem; box-shadow: 0 4px 18px rgba(6, 181, 249, 0.35); display: inline-flex; align-items: center; gap: 0.5rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 17px; height: 17px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        <span>Save Custom Markdown</span>
      </button>

      <a href="markdown-health.php" class="btn-adm btn-adm-secondary" style="padding: 0.75rem 1.25rem;">
        Cancel
      </a>
    </div>

    <div>
      <?php if (!empty($fileMeta['can_reset'])): ?>
        <button type="button" onclick="confirmReset();" class="btn-adm btn-adm-danger" style="font-size: 0.85rem; padding: 0.65rem 1rem; display: inline-flex; align-items: center; gap: 0.45rem;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
          <span>Reset to Auto-Generated Template</span>
        </button>
      <?php endif; ?>
    </div>
  </div>

</form>

<style>
/* Markdown Quick Toolbar Buttons */
.btn-md-tool {
  background: rgba(15, 23, 42, 0.8);
  border: 1px solid var(--adm-border);
  color: #CBD5E1;
  padding: 0.28rem 0.55rem;
  border-radius: 4px;
  font-size: 0.78rem;
  font-family: var(--adm-font-mono);
  cursor: pointer;
  transition: all 0.15s ease;
}
.btn-md-tool:hover {
  background: var(--adm-teal-dim);
  color: var(--adm-teal);
  border-color: var(--adm-teal);
}

/* Markdown Preview Typography */
.markdown-preview-body h1, 
.markdown-preview-body h2, 
.markdown-preview-body h3, 
.markdown-preview-body h4 {
  color: #FFFFFF;
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
  font-weight: 700;
  line-height: 1.3;
}
.markdown-preview-body h1 { font-size: 1.65rem; border-bottom: 1px solid var(--adm-border); padding-bottom: 0.5rem; }
.markdown-preview-body h2 { font-size: 1.35rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 0.35rem; }
.markdown-preview-body h3 { font-size: 1.15rem; }
.markdown-preview-body p { margin-bottom: 1rem; color: #CBD5E1; }
.markdown-preview-body blockquote {
  border-left: 3px solid var(--adm-teal);
  background: rgba(0, 242, 254, 0.05);
  margin: 1rem 0;
  padding: 0.65rem 1rem;
  color: #94A3B8;
  font-style: italic;
}
.markdown-preview-body code {
  background: rgba(15, 23, 42, 0.8);
  color: var(--adm-teal);
  padding: 0.15rem 0.4rem;
  border-radius: 4px;
  font-family: var(--adm-font-mono);
  font-size: 0.85em;
  border: 1px solid rgba(255,255,255,0.08);
}
.markdown-preview-body pre {
  background: #040D1A;
  border: 1px solid var(--adm-border);
  border-radius: 6px;
  padding: 1rem;
  overflow-x: auto;
  margin: 1rem 0;
}
.markdown-preview-body pre code {
  background: transparent;
  padding: 0;
  border: none;
  color: #E2E8F0;
}
.markdown-preview-body ul, .markdown-preview-body ol {
  padding-left: 1.5rem;
  margin-bottom: 1rem;
  color: #CBD5E1;
}
.markdown-preview-body li { margin-bottom: 0.35rem; }
.markdown-preview-body a {
  color: var(--adm-teal);
  text-decoration: underline;
}
.markdown-preview-body hr {
  border: none;
  border-top: 1px solid var(--adm-border);
  margin: 1.5rem 0;
}
.markdown-preview-body table {
  width: 100%;
  border-collapse: collapse;
  margin: 1.25rem 0;
  font-size: 0.88rem;
}
.markdown-preview-body th, .markdown-preview-body td {
  border: 1px solid var(--adm-border);
  padding: 0.6rem 0.85rem;
  text-align: left;
}
.markdown-preview-body th {
  background: #040D1A;
  color: var(--adm-teal);
  font-family: var(--adm-font-mono);
}
</style>

<!-- Load marked.js for real-time live preview -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const textarea = document.getElementById('markdownTextarea');
  const preview = document.getElementById('previewContent');

  // Simple vanilla fallback renderer if CDN is unreachable
  function parseMarkdown(md) {
    if (typeof marked !== 'undefined' && typeof marked.parse === 'function') {
      return marked.parse(md);
    }
    // Fallback: basic parser
    let html = md
      .replace(/^# (.*$)/gim, '<h1>$1</h1>')
      .replace(/^## (.*$)/gim, '<h2>$1</h2>')
      .replace(/^### (.*$)/gim, '<h3>$1</h3>')
      .replace(/^\> (.*$)/gim, '<blockquote>$1</blockquote>')
      .replace(/\*\*(.*)\*\*/gim, '<strong>$1</strong>')
      .replace(/\*(.*)\*/gim, '<em>$1</em>')
      .replace(/\[([^\]]+)\]\(([^)]+)\)/gim, '<a href="$2" target="_blank">$1</a>')
      .replace(/\n$/gim, '<br />');
    return html;
  }

  function updateMetricsAndPreview() {
    const text = textarea.value;

    // 1. Update Preview
    preview.innerHTML = parseMarkdown(text);

    // 2. Metrics
    const lines = text ? text.split('\n').length : 0;
    const words = text.trim() ? text.trim().split(/\s+/).length : 0;
    const chars = text.length;
    const sizeKb = (new Blob([text]).size / 1024).toFixed(1);

    document.getElementById('statLines').textContent = lines.toLocaleString();
    document.getElementById('statWords').textContent = words.toLocaleString();
    document.getElementById('statChars').textContent = chars.toLocaleString();
    document.getElementById('statSize').textContent = sizeKb + ' KB';
  }

  textarea.addEventListener('input', updateMetricsAndPreview);
  updateMetricsAndPreview();

  // Tab key indent support inside textarea
  textarea.addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
      e.preventDefault();
      const start = this.selectionStart;
      const end = this.selectionEnd;
      this.value = this.value.substring(0, start) + '  ' + this.value.substring(end);
      this.selectionStart = this.selectionEnd = start + 2;
      updateMetricsAndPreview();
    }
  });
});

// View Mode Handler
function setViewMode(mode) {
  const workspace = document.getElementById('editorWorkspace');
  const editorPane = document.getElementById('editorPane');
  const previewPane = document.getElementById('previewPane');

  const btnSplit = document.getElementById('btnModeSplit');
  const btnEdit = document.getElementById('btnModeEdit');
  const btnPrev = document.getElementById('btnModePreview');

  [btnSplit, btnEdit, btnPrev].forEach(b => {
    b.style.background = 'transparent';
    b.style.color = 'var(--adm-text-muted)';
    b.style.fontWeight = '400';
  });

  if (mode === 'split') {
    workspace.style.display = 'grid';
    workspace.style.gridTemplateColumns = '1fr 1fr';
    editorPane.style.display = 'flex';
    previewPane.style.display = 'flex';
    btnSplit.style.background = 'var(--adm-teal-dim)';
    btnSplit.style.color = 'var(--adm-teal)';
    btnSplit.style.fontWeight = '700';
  } else if (mode === 'edit') {
    workspace.style.display = 'block';
    editorPane.style.display = 'flex';
    previewPane.style.display = 'none';
    btnEdit.style.background = 'var(--adm-teal-dim)';
    btnEdit.style.color = 'var(--adm-teal)';
    btnEdit.style.fontWeight = '700';
  } else if (mode === 'preview') {
    workspace.style.display = 'block';
    editorPane.style.display = 'none';
    previewPane.style.display = 'flex';
    btnPrev.style.background = 'var(--adm-teal-dim)';
    btnPrev.style.color = 'var(--adm-teal)';
    btnPrev.style.fontWeight = '700';
  }
}

// Quick Formatting Tools
function insertSyntax(before, after) {
  const textarea = document.getElementById('markdownTextarea');
  const start = textarea.selectionStart;
  const end = textarea.selectionEnd;
  const selected = textarea.value.substring(start, end) || 'text';
  textarea.value = textarea.value.substring(0, start) + before + selected + after + textarea.value.substring(end);
  textarea.focus();
  textarea.setSelectionRange(start + before.length, start + before.length + selected.length);
  textarea.dispatchEvent(new Event('input'));
}

function insertLinePrefix(prefix) {
  const textarea = document.getElementById('markdownTextarea');
  const start = textarea.selectionStart;
  const end = textarea.selectionEnd;
  const val = textarea.value;
  const lineStart = val.lastIndexOf('\n', start - 1) + 1;
  textarea.value = val.substring(0, lineStart) + prefix + val.substring(lineStart);
  textarea.focus();
  textarea.setSelectionRange(start + prefix.length, end + prefix.length);
  textarea.dispatchEvent(new Event('input'));
}

function insertCodeBlock() {
  const textarea = document.getElementById('markdownTextarea');
  const start = textarea.selectionStart;
  const end = textarea.selectionEnd;
  const selected = textarea.value.substring(start, end) || 'console.log("Hello BusinessDoctor");';
  const block = "\n```bash\n" + selected + "\n```\n";
  textarea.value = textarea.value.substring(0, start) + block + textarea.value.substring(end);
  textarea.focus();
  textarea.dispatchEvent(new Event('input'));
}

function insertLink() {
  const url = prompt('Enter link URL (e.g. https://demo.businesdoctor.com/service/seo):', 'https://');
  if (url) {
    insertSyntax('[', '](' + url + ')');
  }
}

function insertTable() {
  const table = "\n| Metric / Discipline | Baseline Standard | Target Outcome |\n| :--- | :---: | :---: |\n| Page Load Time | > 3.5s | < 0.8s Native |\n| ROAS Yield | 1.8x | 4.2x Audited |\n\n";
  const textarea = document.getElementById('markdownTextarea');
  const start = textarea.selectionStart;
  textarea.value = textarea.value.substring(0, start) + table + textarea.value.substring(start);
  textarea.focus();
  textarea.dispatchEvent(new Event('input'));
}

function confirmReset() {
  if (confirm('Are you sure you want to reset this document to its automatically generated template? Any custom modifications will be discarded.')) {
    document.getElementById('formAction').value = 'reset_default';
    document.getElementById('markdownForm').submit();
  }
}

function promptCreateNew() {
  const name = prompt('Enter new custom markdown file path inside md/ (e.g. "privacy.md" or "pricing.md"):');
  if (name) {
    let clean = name.trim().toLowerCase().replace(/[^a-z0-9_\-\.\/]/g, '');
    if (!clean.endsWith('.md')) {
      clean += '.md';
    }
    if (!clean.startsWith('md/')) {
      clean = 'md/' + clean;
    }
    window.location.href = 'markdown-edit.php?file=' + encodeURIComponent(clean);
  }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
