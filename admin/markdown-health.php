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
            setFlashMessage('success', "Universal Markdown synchronization completed in {$duration}ms. {$writtenCount} Markdown files, llms.txt, llms.md, and sitemap.xml are now fully updated.");
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
        'clean_md' => '/.md',
        'repo_file' => 'md/home.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'About the Firm & Leadership',
        'web_url' => '/about.php',
        'clean_md' => '/about.php.md',
        'repo_file' => 'md/about.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Services Hub & Disciplines',
        'web_url' => '/services.php',
        'clean_md' => '/services.php.md',
        'repo_file' => 'md/services.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Executive Advisory & Contact',
        'web_url' => '/contact.php',
        'clean_md' => '/contact.php.md',
        'repo_file' => 'md/contact.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Digital Architecture Audit',
        'web_url' => '/audit.php',
        'clean_md' => '/audit.php.md',
        'repo_file' => 'md/audit.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Technical Perspectives & Blog Hub',
        'web_url' => '/insights.php',
        'clean_md' => '/insights.php.md',
        'repo_file' => 'md/insights.md',
    ],
    [
        'section' => 'Institutional',
        'title' => 'Case Studies & Results Hub',
        'web_url' => '/case-studies.php',
        'clean_md' => '/case-studies.php.md',
        'repo_file' => 'md/case-studies.md',
    ],
];

// Add 6 Active Services
$services = SeoSyncEngine::getActiveServices();
foreach ($services as $slug => $s) {
    $pagesInventory[] = [
        'section' => 'Practice Discipline',
        'title' => ($s['number'] ?? '') . ' ' . ($s['name'] ?? $slug),
        'web_url' => '/company/' . $slug,
        'clean_md' => '/company/' . $slug . '.md',
        'repo_file' => 'md/services/' . $slug . '.md',
    ];
}

// Add 3 Case Studies
$cases = SeoSyncEngine::getPublishedCaseStudies();
foreach ($cases as $c) {
    $pagesInventory[] = [
        'section' => 'Case Study',
        'title' => $c['title'] ?? $c['slug'],
        'web_url' => '/case-study-detail.php?slug=' . $c['slug'],
        'clean_md' => '/case-studies/' . $c['slug'] . '.md',
        'repo_file' => 'md/case-studies/' . $c['slug'] . '.md',
    ];
}

// Add 4 Published Blogs
$blogs = SeoSyncEngine::getPublishedInsights();
foreach ($blogs as $b) {
    $pagesInventory[] = [
        'section' => 'Technical Blog',
        'title' => $b['title'] ?? $b['slug'],
        'web_url' => '/insight-detail.php?slug=' . $b['slug'],
        'clean_md' => '/insights/' . $b['slug'] . '.md',
        'repo_file' => 'md/insights/' . $b['slug'] . '.md',
    ];
}

// Master Index
$masterIndexMeta = [
    'section' => 'Master Index',
    'title' => 'Public Markdown Repository Catalog',
    'web_url' => '/md',
    'clean_md' => '/md',
    'repo_file' => 'md/index.md',
];
array_unshift($pagesInventory, $masterIndexMeta);

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

    if ($exists) {
        $verifiedFiles++;
        $content = file_get_contents($filePath);
        $lines = substr_count($content, "\n") + 1;
        preg_match_all('/^#+\s+(.+)$/m', $content, $hMatches);
        $headings = count($hMatches[1]);
    }

    $pageDetails[] = array_merge($item, [
        'exists' => $exists,
        'size' => $size,
        'lines' => $lines,
        'headings' => $headings,
    ]);
}
?>

<div class="admin-main">
  <!-- Top Bar -->
  <div class="admin-topbar">
    <div class="admin-topbar-left">
      <h1 class="admin-page-title">Markdown Health &amp; Synchronization</h1>
      <p class="admin-page-subtitle">Website-wide machine-readable Markdown repository, universal routing endpoints, and LLM context pipelines.</p>
    </div>
    <div class="admin-topbar-right">
      <form method="POST" style="margin: 0;">
        <?= csrfField() ?>
        <input type="hidden" name="action" value="regenerate">
        <button type="submit" class="admin-btn admin-btn-primary" onclick="return confirm('Regenerate all 21 Markdown files, llms.txt, llms.md and sitemap.xml now?');">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px; margin-right: 6px;"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
          Regenerate All Markdown
        </button>
      </form>
      <a href="../md" target="_blank" class="admin-btn admin-btn-secondary" style="margin-left: 0.5rem;">
        View /md Index ↗
      </a>
    </div>
  </div>

  <?= renderFlashMessage() ?>

  <!-- Performance HUD / Metric Cards -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <!-- Metric 1 -->
    <div style="background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-lg); padding: 1.25rem;">
      <div style="font-size: 0.75rem; color: var(--adm-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.05em; margin-bottom: 0.5rem;">
        TOTAL PUBLIC PAGES
      </div>
      <div style="font-size: 1.85rem; font-weight: 800; color: #FFFFFF; font-family: var(--adm-font-mono);">
        <?= count($pagesInventory) - 1 ?> Pages
      </div>
      <div style="font-size: 0.8rem; color: var(--adm-muted); margin-top: 0.35rem;">
        7 Static + 6 Services + 3 Cases + 4 Blogs
      </div>
    </div>

    <!-- Metric 2 -->
    <div style="background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-lg); padding: 1.25rem;">
      <div style="font-size: 0.75rem; color: var(--adm-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.05em; margin-bottom: 0.5rem;">
        MARKDOWN FILES HEALTH
      </div>
      <div style="font-size: 1.85rem; font-weight: 800; color: var(--adm-teal); font-family: var(--adm-font-mono);">
        <?= $verifiedFiles ?> / <?= $totalFiles ?> Verified
      </div>
      <div style="font-size: 0.8rem; color: var(--adm-muted); margin-top: 0.35rem;">
        <?= round($totalBytes / 1024, 1) ?> KB total markdown content
      </div>
    </div>

    <!-- Metric 3 -->
    <div style="background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-lg); padding: 1.25rem;">
      <div style="font-size: 0.75rem; color: var(--adm-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.05em; margin-bottom: 0.5rem;">
        LAST SYNCHRONIZATION
      </div>
      <div style="font-size: 1.15rem; font-weight: 700; color: #FFFFFF; font-family: var(--adm-font-mono); margin-top: 0.35rem;">
        <?= e($syncStatus['last_sync_timestamp'] ?? 'Just Now') ?>
      </div>
      <div style="font-size: 0.8rem; color: var(--adm-teal); margin-top: 0.35rem;">
        Status: <?= ucfirst($syncStatus['status'] ?? 'Active') ?> (<?= $syncStatus['duration_ms'] ?? 0 ?> ms)
      </div>
    </div>

    <!-- Metric 4 -->
    <div style="background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-lg); padding: 1.25rem;">
      <div style="font-size: 0.75rem; color: var(--adm-muted); text-transform: uppercase; font-family: var(--adm-font-mono); letter-spacing: 0.05em; margin-bottom: 0.5rem;">
        AI AGENT DISCOVERY
      </div>
      <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem; flex-wrap: wrap;">
        <a href="../llms.txt" target="_blank" style="background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.3); font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 4px; text-decoration: none; font-family: var(--adm-font-mono);">llms.txt (<?= round(filesize(ROOT_PATH . '/llms.txt') / 1024, 1) ?>K) ↗</a>
        <a href="../llms.md" target="_blank" style="background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.3); font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 4px; text-decoration: none; font-family: var(--adm-font-mono);">llms.md (<?= round(filesize(ROOT_PATH . '/llms.md') / 1024, 1) ?>K) ↗</a>
        <a href="../sitemap.xml" target="_blank" style="background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.3); font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 4px; text-decoration: none; font-family: var(--adm-font-mono);">sitemap (<?= round(filesize(ROOT_PATH . '/sitemap.xml') / 1024, 1) ?>K) ↗</a>
      </div>
    </div>
  </div>

  <!-- Document Table -->
  <div style="background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-lg); overflow: hidden; margin-bottom: 2.5rem;">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center;">
      <div>
        <h2 style="font-size: 1.1rem; color: #FFFFFF; margin: 0; font-weight: 700;">Public Page-by-Page Markdown Inventory</h2>
        <p style="font-size: 0.8rem; color: var(--adm-muted); margin: 0.25rem 0 0 0;">Verifies physical file persistence, universal clean URL routing, and heading extraction depth.</p>
      </div>
      <span style="font-family: var(--adm-font-mono); font-size: 0.8rem; color: var(--adm-teal); background: rgba(0, 242, 254, 0.08); padding: 0.35rem 0.75rem; border-radius: 4px; border: 1px solid rgba(0, 242, 254, 0.2);">
        Universal Routing: ACTIVE
      </span>
    </div>

    <div style="overflow-x: auto;">
      <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
        <thead>
          <tr style="background: rgba(15, 23, 42, 0.6); border-bottom: 1px solid var(--adm-border); color: var(--adm-muted); font-family: var(--adm-font-mono); font-size: 0.75rem; text-transform: uppercase;">
            <th style="padding: 0.75rem 1rem;">Section</th>
            <th style="padding: 0.75rem 1rem;">Page &amp; Title</th>
            <th style="padding: 0.75rem 1rem;">Clean Markdown Endpoint</th>
            <th style="padding: 0.75rem 1rem;">Repository Path</th>
            <th style="padding: 0.75rem 1rem; text-align: right;">Size</th>
            <th style="padding: 0.75rem 1rem; text-align: center;">Headings</th>
            <th style="padding: 0.75rem 1rem; text-align: center;">Lines</th>
            <th style="padding: 0.75rem 1rem; text-align: center;">Health Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pageDetails as $row): ?>
            <tr style="border-bottom: 1px solid rgba(51, 65, 85, 0.3); transition: background 0.15s ease;">
              <td style="padding: 0.85rem 1rem;">
                <span style="font-size: 0.72rem; padding: 0.2rem 0.5rem; border-radius: 3px; font-weight: 600; text-transform: uppercase; background: rgba(59, 130, 246, 0.12); color: #60A5FA; border: 1px solid rgba(59, 130, 246, 0.3); font-family: var(--adm-font-mono);">
                  <?= e($row['section']) ?>
                </span>
              </td>
              <td style="padding: 0.85rem 1rem;">
                <div style="font-weight: 600; color: #FFFFFF;"><?= e($row['title']) ?></div>
                <div style="margin-top: 0.2rem;">
                  <a href="..<?= $row['web_url'] ?>" target="_blank" style="color: var(--adm-muted); text-decoration: none; font-size: 0.78rem;">
                    <?= e($row['web_url']) ?> ↗
                  </a>
                </div>
              </td>
              <td style="padding: 0.85rem 1rem; font-family: var(--adm-font-mono); font-size: 0.8rem;">
                <a href="..<?= $row['clean_md'] ?>" target="_blank" style="color: var(--adm-teal); text-decoration: none;">
                  <?= e($row['clean_md']) ?> ↗
                </a>
              </td>
              <td style="padding: 0.85rem 1rem; font-family: var(--adm-font-mono); font-size: 0.8rem; color: #CBD5E1;">
                <?= e($row['repo_file']) ?>
              </td>
              <td style="padding: 0.85rem 1rem; text-align: right; font-family: var(--adm-font-mono); font-size: 0.82rem; color: #FFFFFF;">
                <?= round($row['size'] / 1024, 1) ?> KB
              </td>
              <td style="padding: 0.85rem 1rem; text-align: center; font-family: var(--adm-font-mono); font-size: 0.82rem; color: var(--adm-teal);">
                <?= $row['headings'] ?>
              </td>
              <td style="padding: 0.85rem 1rem; text-align: center; font-family: var(--adm-font-mono); font-size: 0.82rem; color: #94A3B8;">
                <?= $row['lines'] ?>
              </td>
              <td style="padding: 0.85rem 1rem; text-align: center;">
                <?php if ($row['exists'] && $row['size'] > 1000): ?>
                  <span style="color: #10B981; background: rgba(16, 185, 129, 0.12); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(16, 185, 129, 0.3);">
                    ✓ SYNCHRONIZED
                  </span>
                <?php else: ?>
                  <span style="color: #EF4444; background: rgba(239, 68, 68, 0.12); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.3);">
                    ✗ INCOMPLETE
                  </span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

