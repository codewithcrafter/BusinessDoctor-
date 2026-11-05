<?php
/**
 * BusinessDoctor Service Detail View - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// 1. Legacy URL 301 Permanent Redirect
// If client requested /service-detail.php?slug=... directly, 301 redirect to /services/{slug}
$reqUri = $_SERVER['REQUEST_URI'] ?? '';
if (str_contains($reqUri, 'service-detail.php')) {
    $rawSlug = trim($_GET['slug'] ?? '');
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
?>

<!-- Practice Hero Banner -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container">
    <div style="max-width: 880px;">
      <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem;">
        <span style="font-family: var(--font-mono); font-size: 0.82rem; font-weight: 700; color: var(--color-secondary); letter-spacing: 0.1em;">
          DISCIPLINE // <?= e($practice['number']) ?>
        </span>
        <span class="eyebrow-badge" style="margin-bottom: 0;"><?= e($practice['tagline']) ?></span>
      </div>
      <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-bottom: 1.25rem;">
        <?= e($practice['name']) ?>
      </h1>
      <p class="hero-lead-text"><?= e($practice['description']) ?></p>

      <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
        <a href="/contact.php?service=<?= urlencode($practice['name']) ?>" class="btn btn-accent btn-lg">
          <span>Request a Project Proposal</span>
          <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
        <a href="/services.php" class="btn btn-secondary btn-lg">
          <span>All Capabilities</span>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Practice Scope & Deliverables -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="hero-grid" style="align-items: flex-start; gap: 4rem;">
      <!-- Detailed Deliverables Column -->
      <div>
        <div class="eyebrow-badge" style="margin-bottom: 1rem;">
          <span class="pill-dot"></span>
          <span>COMPREHENSIVE CAPABILITIES</span>
        </div>
        <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
          Service Deliverables &amp; Execution Scope
        </h2>
        <p style="font-size: 1.05rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 2.25rem;">
          Our engagements are built around clear deliverables, milestone-based development, and transparent technical documentation.
        </p>

        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
          <?php foreach ($practice['deliverables'] as $idx => $deliv): ?>
            <div class="card" style="padding: 1.75rem 2rem; display: flex; align-items: flex-start; gap: 1.25rem;">
              <div style="width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--color-secondary-soft); color: var(--color-secondary); font-family: var(--font-mono); font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem;">
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

      <!-- Practice Sidebar: Benchmark Standards & Related Evidence -->
      <div>
        <div class="enterprise-hud-card" style="margin-bottom: 2.5rem; padding: 2.5rem 2.25rem;">
          <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-accent); margin-bottom: 1rem; letter-spacing: 0.1em; text-transform: uppercase;">
            ● TECHNICAL STANDARDS
          </div>
          <h3 style="color: #ffffff; font-size: 1.4rem; margin-bottom: 1.5rem; line-height: 1.3;">
            Guaranteed Quality Thresholds
          </h3>
          <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($practice['kpis'] as $kpi): ?>
              <div style="background: rgba(255,255,255,0.05); padding: 1rem 1.25rem; border-radius: var(--radius-md); border-left: 3px solid var(--color-accent);">
                <div style="font-family: var(--font-display); font-size: 1.2rem; font-weight: 700; color: #ffffff;">
                  <?= e($kpi) ?>
                </div>
                <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.65); margin-top: 0.25rem;">
                  Industry-Leading Performance Metric
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if ($relatedCase): ?>
          <div class="card" style="padding: 2.25rem 2rem;">
            <div class="eyebrow-badge" style="margin-bottom: 0.85rem; font-size: 0.68rem;">
              RELATED CLIENT SUCCESS
            </div>
            <h4 style="font-size: 1.2rem; margin-bottom: 0.75rem; color: var(--color-text); line-height: 1.35;">
              <a href="<?= getCaseStudyUrl($relatedCase['slug']) ?>" style="color: var(--color-text); text-decoration: none;">
                <?= e($relatedCase['title']) ?>
              </a>
            </h4>
            <p style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1.25rem; line-height: 1.55;">
              <?= e(substr($relatedCase['challenge'], 0, 140)) ?>...
            </p>
            <a href="<?= getCaseStudyUrl($relatedCase['slug']) ?>" class="case-card-action">
              <span>Read Full Case Study</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Closing CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Ready to Execute on <?= e($practice['short_title']) ?>?</h2>
        <p class="closing-cta-lead">
          Connect with our senior technical architects to discuss your project requirements and receive a formal scope of work.
        </p>
        <div class="closing-cta-buttons">
          <a href="/contact.php?service=<?= urlencode($practice['name']) ?>" class="btn btn-accent btn-lg">
            <span>Request a Project Proposal</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="/audit.php" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
