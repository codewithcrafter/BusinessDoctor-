<?php
/**
 * BusinessDoctor Service Detail View - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// 1. Legacy URL 301 Permanent Redirect
// Check for legacy slug alias first and redirect immediately
$reqUri = $_SERVER['REQUEST_URI'] ?? '';
$rawSlug = trim($_GET['slug'] ?? '');

$legacySlugMap = [
    'strategic-consulting' => 'web-development',
    'digital-engineering' => 'web-development',
    'performance-marketing' => 'seo',
    'brand-architecture' => 'graphic-design',
    'ecommerce-acceleration' => 'ecommerce-management',
    'creative-production' => 'video-editing',
    'web-software-development' => 'web-development',
    'digital-marketing-seo' => 'seo',
    'ui-ux-branding' => 'graphic-design',
    'ecommerce-marketplaces' => 'ecommerce-management',
    'creative-video-production' => 'video-editing',
    'cloud-it-consulting' => 'web-development',
];

if ($rawSlug !== '' && isset($legacySlugMap[$rawSlug])) {
    header("Location: /services/" . $legacySlugMap[$rawSlug], true, 301);
    exit;
}

// If client requested /service-detail.php?slug=... directly, 301 redirect to /services/{slug}
if (str_contains($reqUri, 'service-detail.php')) {
    if ($rawSlug !== '') {
        $p = getPracticeBySlug($rawSlug);
        $redirectSlug = $p ? $p['slug'] : rawurlencode($rawSlug);
        $targetUrl = '/services/' . $redirectSlug;
    } else {
        $targetUrl = '/services.php';
    }
    header("Location: " . $targetUrl, true, 301);
    exit;
}

// 2. Validate Service Slug
$slug = trim($_GET['slug'] ?? '');
if ($slug === '') {
    header("Location: /services.php", true, 301);
    exit;
}

$practice = getPracticeBySlug($slug);

if (!$practice) {
    http_response_code(404);
    $pageTitle = 'Service Not Found — BusinessDoctor';
    $pageDescription = 'The requested practice area could not be found. Explore our enterprise IT and digital capabilities.';
    $canonicalUrl = BASE_URL . '/services.php';
    require_once __DIR__ . '/includes/header.php';
    ?>
    <section class="section hero-enterprise" style="padding-top: 6rem; padding-bottom: 6rem; text-align: center;">
      <div class="container" style="max-width: 760px;">
        <span class="eyebrow-badge" style="margin-bottom: 1.25rem;">
          <span class="pill-dot" style="background-color: var(--color-error, #ef4444);"></span>
          <span>HTTP 404 &mdash; PRACTICE AREA NOT FOUND</span>
        </span>
        <h1 class="hero-headline-oversized" style="font-size: clamp(2.2rem, 4vw, 3.2rem); margin-bottom: 1.25rem;">
          Capability Not Recognized
        </h1>
        <p class="hero-lead-text" style="margin-bottom: 2.5rem;">
          The service discipline <code><?= e($slug) ?></code> is not part of our enterprise roadmap, or the URL has changed.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
          <a href="<?= BASE_URL ?>/services.php" class="btn btn-primary btn-lg">
            <span>Explore All Capabilities</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="<?= BASE_URL ?>/contact.php" class="btn btn-secondary btn-lg">
            <span>Inquire About Custom Engineering</span>
          </a>
        </div>
      </div>
    </section>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$canonicalUrl = BASE_URL . '/services/' . $practice['slug'];
$pageTitle = $practice['name'] . ' — BusinessDoctor Enterprise Capabilities';
$pageDescription = $practice['summary'];

// Get related case study if available
$relatedCase = null;
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM case_studies WHERE practice_area LIKE ? LIMIT 1");
    $stmt->execute(['%' . $practice['short_title'] . '%']);
    $relatedCase = $stmt->fetch();
    if (!$relatedCase) {
        $stmt = $pdo->query("SELECT * FROM case_studies LIMIT 1");
        $relatedCase = $stmt->fetch();
    }
} catch (Exception $e) {}

$schemaPageKey = 'service-detail';
$schemaContextData = [
    'title' => $practice['name'],
    'summary' => $practice['summary'],
    'canonical_url' => $canonicalUrl
];

require_once __DIR__ . '/includes/header.php';

$servicePartial = __DIR__ . '/includes/services/' . $practice['slug'] . '.php';
if (file_exists($servicePartial)) {
    echo '<div class="srv-wrapper">';
    require $servicePartial;
    echo '</div>';
} else {
?>
<!-- Practice Hero Banner -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container">
    <div style="max-width: 880px;">
      <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem;">
        <span class="eyebrow-badge" style="margin-bottom: 0;"><?= e($practice['tagline']) ?></span>
      </div>
      <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-bottom: 1.25rem;">
        <?= e($practice['name']) ?>
      </h1>
      <p class="hero-lead-text"><?= e($practice['description']) ?></p>

      <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
        <a href="<?= appUrl('contact.php?service=' . urlencode($practice['name'])) ?>" class="btn btn-accent btn-lg">
          <span>Request a Project Proposal</span>
          <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
        <a href="<?= appUrl('audit.php') ?>" class="btn btn-secondary btn-lg">
          <span>Run Digital Architecture Audit</span>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Practice Scope & Deliverables (Default Fallback) -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="hero-grid" style="align-items: flex-start; gap: 4rem;">
      <div>
        <div class="eyebrow-badge" style="margin-bottom: 1rem;">
          <span class="pill-dot"></span>
          <span>COMPREHENSIVE CAPABILITIES</span>
        </div>
        <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
          Service Deliverables &amp; Execution Scope
        </h2>
        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
          <?php foreach ($practice['deliverables'] as $idx => $deliv): ?>
            <div class="card" style="padding: 1.75rem 2rem; display: flex; align-items: flex-start; gap: 1.25rem;">
              <div style="width: 36px; height: 36px; border-radius: var(--radius-sm); background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.25); font-family: var(--font-mono); font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem;">
                0<?= $idx + 1 ?>
              </div>
              <div>
                <h3 style="font-size: 1.2rem; margin-bottom: 0.35rem; color: var(--color-text);"><?= e($deliv) ?></h3>
                <p style="font-size: 0.9rem; color: var(--color-text-muted); margin: 0; line-height: 1.55;">
                  Delivered by specialized engineers and digital strategists adhering to modern web and marketing best practices.
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>