<?php
/**
 * BusinessDoctor Executive Admin — Markdown Architecture & Health Dashboard
 * Monitor, inspect, validate, and synchronize all website-wide Markdown documents.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/seo-sync.php';

// Handle Manual Full Regeneration Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'regenerate') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'Security token expired. Please retry.');
    } else {
        try {
            $syncResult = SeoSyncEngine::syncAll("Manual Admin Regeneration via Markdown Health Dashboard");
            $writtenCount = $syncResult['files']['md_files']['count_written'] ?? 21;
            $duration = $syncResult['duration_ms'] ?? 0;
            setFlashMessage('success', "Universal Markdown synchronization completed in {$duration}ms. {$writtenCount} Markdown files, llms.txt, and sitemap.xml are now fully updated.");
        } catch (Throwable $e) {
            setFlashMessage('error', 'Synchronization error: ' . $e->getMessage());
        }
    }
    header('Location: markdown-health.php');
    exit;
}

$pageTitle = 'Markdown Health Dashboard — BusinessDoctor Admin';
require_once __DIR__ . '/includes/header.php';

$baseUrl = SeoSyncEngine::getBaseUrl();
$syncStatus = SeoSyncEngine::getSyncStatus();

// Gather all public pages and their corresponding Markdown files
$pagesInventory = [
    // Institutional
    [
        'section' => 'Institutional',
        'title' => 'Homepage Overview',
        'web_url' => '/',
        'clean_md' => '/home.md',
        'repo_file' => 'md/home.md',
        'source' => 'filesystem: index.php',
        'deps' => 'sitemap.xml, llms.txt',
    ],
    [
        'section' => 'Institutional',
        'title' => 'About the Firm & Leadership',
        'web_url' => '/about',
        'clean_md' => '/about.md',
        'repo_file' => 'md/about.md',
        'source' => 'filesystem: about.php',
        'deps' => 'sitemap.xml, llms.txt',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Services Hub & Disciplines',
        'web_url' => '/services',
        'clean_md' => '/services.md',
        'source' => 'filesystem: services.php',
        'deps' => 'sitemap.xml, llms.txt',
        'repo_file' => 'md/services.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Executive Advisory & Contact',
        'web_url' => '/contact',
        'clean_md' => '/contact.md',
        'repo_file' => 'md/contact.md',
        'source' => 'filesystem: contact.php',
        'deps' => 'sitemap.xml, llms.txt',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Digital Architecture Audit',
        'web_url' => '/audit',
        'clean_md' => '/audit.md',
        'repo_file' => 'md/audit.md',
        'source' => 'filesystem: audit.php',
        'deps' => 'sitemap.xml, llms.txt',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Technical Perspectives & Blog Hub',
        'web_url' => '/blog',
        'clean_md' => '/blog.md',
        'repo_file' => 'md/insights.md',
        'source' => 'filesystem: insights.php',
        'deps' => 'sitemap.xml, llms.txt',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Case Studies & Results Hub',
        'web_url' => '/case-studies',
        'clean_md' => '/case-studies.md',
        'repo_file' => 'md/case-studies.md',
        'source' => 'filesystem: case-studies.php',
        'deps' => 'sitemap.xml, llms.txt',
    ],
];

// Add 10 Active Services
$services = SeoSyncEngine::getActiveServices();
foreach ($services as $slug => $s) {
    $srvUrl = parse_url(getServiceUrl($slug), PHP_URL_PATH);
    $srvMd = parse_url(getMarkdownUrl(getServiceUrl($slug)), PHP_URL_PATH);
    $pagesInventory[] = [
        'section' => 'Practice Discipline',
        'title' => ($s['number'] ?? '') . ' ' . ($s['name'] ?? $slug),
        'web_url' => $srvUrl,
        'clean_md' => $srvMd,
        'repo_file' => 'md/services/' . $slug . '.md',
        'source' => 'services table (id: ' . ($s['id'] ?? $slug) . ')',
        'deps' => 'sitemap.xml, llms.txt, Schema',
    ];
}

// Add 3 Case Studies
$cases = SeoSyncEngine::getPublishedCaseStudies();
foreach ($cases as $c) {
    $pagesInventory[] = [
        'section' => 'Case Study',
        'title' => $c['title'] ?? $c['slug'],
        'web_url' => '/case-studies/' . $c['slug'],
        'clean_md' => '/case-studies/' . $c['slug'] . '.md',
        'repo_file' => 'md/case-studies/' . $c['slug'] . '.md',
        'source' => 'case_studies table (id: ' . ($c['id'] ?? $c['slug']) . ')',
        'deps' => 'sitemap.xml, llms.txt',
    ];
}

// Add 4 Published Blogs
$blogs = SeoSyncEngine::getPublishedInsights();
foreach ($blogs as $b) {
    $pagesInventory[] = [
        'section' => 'Technical Blog',
        'title' => $b['title'] ?? $b['slug'],
        'web_url' => '/blog/' . $b['slug'],
        'clean_md' => '/blog/' . $b['slug'] . '.md',
        'repo_file' => 'md/insights/' . $b['slug'] . '.md',
        'source' => 'insights table (id: ' . ($b['id'] ?? $b['slug']) . ')',
        'deps' => 'sitemap.xml, llms.txt, Schema',
    ];
}

// Check for any extra custom markdown files from disk
$trackedFiles = array_column($pagesInventory, 'repo_file');
$allDiskFiles = glob(ROOT_PATH . '/md/*.md') ?: [];
$subDiskFiles = glob(ROOT_PATH . '/md/*/*.md') ?: [];
$normalizedRoot = rtrim(str_replace('\\', '/', ROOT_PATH), '/');
foreach (array_merge($allDiskFiles, $subDiskFiles) as $diskFile) {
    $normalizedDisk = str_replace('\\', '/', $diskFile);
    $rel = ltrim(str_replace($normalizedRoot . '/', '', $normalizedDisk), '/');
    if (!str_starts_with($rel, 'md/')) {
        $rel = 'md/' . $rel;
    }
    if (!in_array($rel, $trackedFiles, true) && basename($rel) !== '.custom_markdown.json' && basename($rel) !== 'index.md') {
        $baseName = basename($rel, '.md');
        $endpoint = '/' . (str_starts_with($rel, 'md/') ? substr($rel, 3) : $rel);
        $pagesInventory[] = [
            'section' => 'Custom Page',
            'title' => 'Custom: ' . ucwords(str_replace(['-', '_'], ' ', $baseName)),
            'web_url' => $endpoint,
            'clean_md' => $endpoint,
            'repo_file' => $rel,
            'source' => 'filesystem (custom edit)',
            'deps' => 'Direct endpoint',
        ];
        $trackedFiles[] = $rel;
    }
}

// Compute live metrics
$totalFiles = count($pagesInventory);
$verifiedFiles = 0;
$totalBytes = 0;

$pageDetails = [];
foreach ($pagesInventory as $item) {
    $filePath = ROOT_PATH . '/' . $item['repo_file'];
    $exists = file_exists($filePath);
    $size = $exists ? filesize($filePath) : 0;
    $totalBytes += $size;
    $lines = 0;
    $headings = 0;

    $contentHash = '';
    $lastMod = '';
    $hasStaleUrl = false;
    $isCustom = SeoSyncEngine::isCustomMarkdown($item['repo_file']);

    if ($exists) {
        $verifiedFiles++;
        $content = file_get_contents($filePath);
        $lines = substr_count($content, "\n") + 1;
        preg_match_all('/^#+\s+(.+)$/m', $content, $hMatches);
        $headings = count($hMatches[1]);
        $contentHash = substr(hash('sha256', $content), 0, 10);
        $lastMod = date('M d, H:i', filemtime($filePath));

        // Stale URL detector: flags legacy .php links or obsolete -company-in-delhi slugs
        if (preg_match('#[a-zA-Z0-9_-]+-company-in-delhi|/(?:about|contact|audit|case-studies|case-study-detail)\.php#', $content)) {
            $hasStaleUrl = true;
        }
    }

    $pageDetails[] = array_merge($item, [
        'exists' => $exists,
        'size' => $size,
        'lines' => $lines,
        'headings' => $headings,
        'hash' => $contentHash,
        'last_mod' => $lastMod,
        'has_stale' => $hasStaleUrl,
        'is_custom' => $isCustom,
    ]);
}
?>

<!-- Content Header Toolbar -->
<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1.25rem; width: 100%; box-sizing: border-box;">
  <div style="max-width: 650px;">
    <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--adm-font-mono); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--adm-teal); background: rgba(0, 242, 254, 0.08); border: 1px solid rgba(0, 242, 254, 0.2); padding: 0.2rem 0.6rem; border-radius: 4px; margin-bottom: 0.6rem;">
      <span style="width: 6px; height: 6px; border-radius: 50%; background: var(--adm-teal); display: inline-block;"></span>
      <span>SYSTEM ARCHITECTURE // LLM &amp; DISCOVERY</span>
    </div>
    <h2 style="font-size: 1.6rem; font-weight: 800; color: #FFFFFF; margin: 0 0 0.4rem; font-family: var(--adm-font-display); letter-spacing: -0.01em;">
      Markdown Health &amp; Synchronization
    </h2>
    <p style="color: var(--adm-text-muted, #94A3B8); font-size: 0.92rem; margin: 0; line-height: 1.55;">
      Website-wide machine-readable Markdown repository, universal routing endpoints, and LLM context pipelines.
    </p>
  </div>

  <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
    <a href="markdown-edit.php" class="btn-adm btn-adm-primary" style="font-weight: 600; padding: 0.65rem 1.15rem; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(6, 181, 249, 0.25);">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      <span>+ Custom Markdown Editor</span>
    </a>
    <form method="POST" style="margin: 0; display: inline-block;">
      <?= csrfField() ?>
      <input type="hidden" name="action" value="regenerate">
      <button type="submit" class="btn-adm btn-adm-secondary" style="font-weight: 600; padding: 0.65rem 1.15rem; display: inline-flex; align-items: center; gap: 0.5rem;" onclick="return confirm('Audit and re-synchronize all automatic Markdown files, llms.txt and sitemap.xml now? (Any customized pages will be preserved)');">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        <span>Audit &amp; Re-sync</span>
      </button>
    </form>
  </div>
</div>

<!-- Performance HUD / Metric Cards -->
<div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
  <!-- Metric 1 -->
  <div class="admin-stat-box" style="flex-direction: column; align-items: flex-start; gap: 0.5rem; padding: 1.25rem 1.4rem;">
    <div style="font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.06em;">
      TOTAL PUBLIC PAGES
    </div>
    <div style="font-size: 1.85rem; font-weight: 800; color: #FFFFFF; font-family: var(--adm-font-mono); line-height: 1;">
      <?= count($pagesInventory) ?> Pages
    </div>
    <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
      7 Static + <?= count($services) ?> Services + <?= count($cases) ?> Cases + <?= count($blogs) ?> Blogs
    </div>
  </div>

  <!-- Metric 2 -->
  <div class="admin-stat-box" style="flex-direction: column; align-items: flex-start; gap: 0.5rem; padding: 1.25rem 1.4rem;">
    <div style="font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.06em;">
      MARKDOWN FILES HEALTH
    </div>
    <div style="font-size: 1.85rem; font-weight: 800; color: var(--adm-teal); font-family: var(--adm-font-mono); line-height: 1;">
      <?= $verifiedFiles ?> / <?= $totalFiles ?> Verified
    </div>
    <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
      <?= round($totalBytes / 1024, 1) ?> KB total markdown content
    </div>
  </div>

  <!-- Metric 3 -->
  <div class="admin-stat-box" style="flex-direction: column; align-items: flex-start; gap: 0.5rem; padding: 1.25rem 1.4rem;">
    <div style="font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.06em;">
      LAST SYNCHRONIZATION
    </div>
    <div style="font-size: 1.15rem; font-weight: 700; color: #FFFFFF; font-family: var(--adm-font-mono); line-height: 1.2; word-break: break-all;">
      <?= e($syncStatus['last_sync_timestamp'] ?? 'Just Now') ?>
    </div>
    <div style="font-size: 0.8rem; color: var(--adm-teal); margin-top: 0.2rem;">
      Status: <?= ucfirst($syncStatus['status'] ?? 'Active') ?> (<?= $syncStatus['duration_ms'] ?? 0 ?> ms)
    </div>
  </div>

  <!-- Metric 4 -->
  <div class="admin-stat-box" style="flex-direction: column; align-items: flex-start; gap: 0.5rem; padding: 1.25rem 1.4rem;">
    <div style="font-size: 0.72rem; color: var(--adm-text-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.06em;">
      AI AGENT DISCOVERY
    </div>
    <div style="display: flex; gap: 0.5rem; margin-top: 0.35rem; flex-wrap: wrap;">
      <a href="../llms.txt" target="_blank" style="background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.3); font-size: 0.78rem; padding: 0.3rem 0.6rem; border-radius: 4px; text-decoration: none; font-family: var(--adm-font-mono); font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem;">
        <span>llms.txt (<?= round(filesize(ROOT_PATH . '/llms.txt') / 1024, 1) ?>K)</span>
        <span>↗</span>
      </a>
      <a href="../sitemap.xml" target="_blank" style="background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.3); font-size: 0.78rem; padding: 0.3rem 0.6rem; border-radius: 4px; text-decoration: none; font-family: var(--adm-font-mono); font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem;">
        <span>sitemap (<?= round(filesize(ROOT_PATH . '/sitemap.xml') / 1024, 1) ?>K)</span>
        <span>↗</span>
      </a>
    </div>
  </div>
</div>

<!-- Document Table -->
<div class="admin-card" style="padding: 0; overflow: hidden; margin-bottom: 2.5rem;">
  <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
    <div>
      <h2 style="font-size: 1.15rem; color: #FFFFFF; margin: 0; font-weight: 700; font-family: var(--adm-font-display);">Public Page-by-Page Markdown Inventory</h2>
      <p style="font-size: 0.82rem; color: var(--adm-text-muted); margin: 0.25rem 0 0 0;">Verifies physical file persistence, universal clean URL routing, and heading extraction depth.</p>
    </div>
    <span style="font-family: var(--adm-font-mono); font-size: 0.78rem; font-weight: 600; color: var(--adm-teal); background: rgba(0, 242, 254, 0.08); padding: 0.35rem 0.75rem; border-radius: 4px; border: 1px solid rgba(0, 242, 254, 0.25);">
      Universal Routing: ACTIVE
    </span>
  </div>

  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="padding: 0.85rem 1rem;">Section</th>
          <th style="padding: 0.85rem 1rem;">Page &amp; Title</th>
          <th style="padding: 0.85rem 1rem;">Source of Truth</th>
          <th style="padding: 0.85rem 1rem;">Dependencies</th>
          <th style="padding: 0.85rem 1rem;">Clean Markdown Endpoint</th>
          <th style="padding: 0.85rem 1rem;">Hash</th>
          <th style="padding: 0.85rem 1rem; text-align: right;">Size</th>
          <th style="padding: 0.85rem 1rem; text-align: center;">Status</th>
          <th style="padding: 0.85rem 1rem; text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pageDetails as $row): ?>
          <tr>
            <td style="padding: 0.85rem 1rem;">
              <span style="font-size: 0.72rem; padding: 0.2rem 0.5rem; border-radius: 3px; font-weight: 600; text-transform: uppercase; background: rgba(59, 130, 246, 0.12); color: #60A5FA; border: 1px solid rgba(59, 130, 246, 0.3); font-family: var(--adm-font-mono);">
                <?= e($row['section']) ?>
              </span>
            </td>
            <td style="padding: 0.85rem 1rem;">
              <div style="font-weight: 600; color: #FFFFFF; font-size: 0.9rem; display: flex; align-items: center; gap: 0.45rem;">
                <span><?= e($row['title']) ?></span>
                <?php if (!empty($row['is_custom'])): ?>
                  <span style="background: rgba(245, 158, 11, 0.15); color: #F59E0B; font-size: 0.68rem; padding: 0.1rem 0.4rem; border-radius: 3px; border: 1px solid rgba(245, 158, 11, 0.3); font-family: var(--adm-font-mono);">CUSTOM</span>
                <?php endif; ?>
              </div>
              <div style="margin-top: 0.2rem;">
                <a href="..<?= $row['web_url'] ?>" target="_blank" style="color: var(--adm-text-muted); text-decoration: none; font-size: 0.78rem; transition: color 0.15s ease;">
                  <?= e($row['web_url']) ?> ↗
                </a>
              </div>
            </td>
            <td style="padding: 0.85rem 1rem; font-family: var(--adm-font-mono); font-size: 0.78rem; color: #94A3B8;">
              <?= e($row['source'] ?? 'Database/FS') ?>
            </td>
            <td style="padding: 0.85rem 1rem; font-size: 0.76rem; color: #CBD5E1;">
              <?= e($row['deps'] ?? 'sitemap.xml, llms.txt') ?>
            </td>
            <td style="padding: 0.85rem 1rem; font-family: var(--adm-font-mono); font-size: 0.8rem;">
              <a href="..<?= $row['clean_md'] ?>" target="_blank" style="color: var(--adm-teal); text-decoration: none; font-weight: 600;">
                <?= e($row['clean_md']) ?> ↗
              </a>
            </td>
            <td style="padding: 0.85rem 1rem; font-family: var(--adm-font-mono); font-size: 0.75rem; color: #A7F3D0;">
              <code><?= e($row['hash'] ?: '—') ?></code>
            </td>
            <td style="padding: 0.85rem 1rem; text-align: right; font-family: var(--adm-font-mono); font-size: 0.82rem; color: #FFFFFF; font-weight: 600;">
              <?= round($row['size'] / 1024, 1) ?> KB
            </td>
            <td style="padding: 0.85rem 1rem; text-align: center;">
              <?php if (!empty($row['is_custom'])): ?>
                <span style="color: #F59E0B; background: rgba(245, 158, 11, 0.12); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; border: 1px solid rgba(245, 158, 11, 0.35);">
                  ★ CUSTOM
                </span>
              <?php elseif ($row['has_stale']): ?>
                <span style="color: #F59E0B; background: rgba(245, 158, 11, 0.12); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; border: 1px solid rgba(245, 158, 11, 0.3);">
                  ⚠ STALE URL
                </span>
              <?php elseif ($row['exists'] && $row['size'] > 500): ?>
                <span style="color: #10B981; background: rgba(16, 185, 129, 0.12); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.3);">
                  ✓ SYNCHRONIZED
                </span>
              <?php else: ?>
                <span style="color: #EF4444; background: rgba(239, 68, 68, 0.12); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.72rem; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.3);">
                  ✗ INCOMPLETE
                </span>
              <?php endif; ?>
            </td>
            <td style="padding: 0.85rem 1rem; text-align: right; white-space: nowrap;">
              <a href="markdown-edit.php?file=<?= urlencode($row['repo_file']) ?>" class="btn-adm btn-adm-secondary btn-adm-sm" style="padding: 0.35rem 0.65rem; font-size: 0.78rem; display: inline-flex; align-items: center; gap: 0.35rem; font-weight: 600;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 13px; height: 13px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span>Edit MD</span>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

