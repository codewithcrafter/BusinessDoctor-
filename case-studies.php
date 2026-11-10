<?php
/**
 * BusinessDoctor Client Case Studies Directory - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Enterprise Case Studies & Verified Client Outcomes — BusinessDoctor';
$pageDescription = 'Examine verified case studies of businesses scaled through custom web development, high-ROI digital marketing, UI/UX design, and marketplace acceleration.';
$canonicalUrl = appUrl('case-studies.php');

$cases = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT * FROM case_studies WHERE status = 'published' AND is_deleted = 0 ORDER BY sort_order ASC, id DESC");
    $cases = $stmt->fetchAll();
} catch (Exception $e) {}

/**
 * Safe URL generator for case study assets
 */
if (!function_exists('getCaseAssetUrl')) {
    function getCaseAssetUrl(string $path): string
    {
        $cleanPath = ltrim($path, '/');
        $segments = explode('/', $cleanPath);
        $encoded = array_map('rawurlencode', $segments);
        return appUrl(implode('/', $encoded));
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<style>
  /* ==========================================================================
     Case Studies Directory Scoped Contrast & Visibility System
     Strictly applies only to the Case Studies listing page
     ========================================================================== */

  /* Header Hero Contrast Overrides */
  .case-studies-hero {
    background-color: var(--color-background) !important;
  }
  .case-studies-hero .eyebrow-badge {
    background: rgba(6, 181, 249, 0.12) !important;
    border: 1px solid rgba(6, 181, 249, 0.35) !important;
    color: #06B5F9 !important;
  }
  .case-studies-hero .eyebrow-badge .pill-dot {
    background: #06B5F9 !important;
    box-shadow: 0 0 8px #06B5F9 !important;
  }
  .case-studies-hero .hero-headline-oversized {
    color: #F5F7FA !important;
  }
  .case-studies-hero .hero-headline-oversized .hero-accent-text {
    color: #06B5F9 !important;
  }
  .case-studies-hero .hero-lead-text {
    color: #B8C7D9 !important;
  }

  /* Grid Section */
  .case-studies-grid-section {
    background-color: var(--color-surface) !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
  }

  /* Case Card Structure & Edge-to-Edge Framing */
  .case-card {
    padding: 0 !important;
    overflow: hidden !important;
    border-radius: var(--radius-lg) !important;
    border: 1px solid rgba(6, 181, 249, 0.20) !important;
    background: #0D223A !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35) !important;
    display: flex !important;
    flex-direction: column !important;
    box-sizing: border-box !important;
    width: 100% !important;
    transition: transform var(--transition-normal), box-shadow var(--transition-normal), border-color var(--transition-normal) !important;
  }

  .case-card:hover {
    transform: translateY(-4px) !important;
    border-color: rgba(6, 181, 249, 0.45) !important;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.55), 0 0 20px rgba(6, 181, 249, 0.12) !important;
  }

  /* Visual Cover Media */
  .case-card-media {
    position: relative !important;
    width: 100% !important;
    aspect-ratio: 16 / 9 !important;
    background: #071224 !important;
    overflow: hidden !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
  }

  .case-card-media img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
    aspect-ratio: 16 / 9 !important;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
  }

  /* Category Badges & Image Overlays */
  .case-card-badge {
    background: rgba(6, 19, 38, 0.92) !important;
    backdrop-filter: blur(8px) !important;
    border: 1px solid rgba(6, 181, 249, 0.45) !important;
    color: #06B5F9 !important;
    font-size: 0.72rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.08em !important;
    padding: 0.35rem 0.75rem !important;
    border-radius: var(--radius-pill) !important;
    font-family: var(--font-mono) !important;
    text-transform: uppercase !important;
    display: inline-flex !important;
    align-items: center !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.45) !important;
  }

  .case-card-overlay-pill {
    background: rgba(15, 23, 42, 0.90) !important;
    color: #8FA3B8 !important;
    font-family: var(--font-mono) !important;
    font-size: 0.65rem !important;
    font-weight: 600 !important;
    padding: 0.25rem 0.55rem !important;
    border-radius: 4px !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    letter-spacing: 0.05em !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.35) !important;
  }

  /* Card Body & Textual Elements */
  .case-card-body {
    padding: 2rem !important;
    display: flex !important;
    flex-direction: column !important;
    flex-grow: 1 !important;
    box-sizing: border-box !important;
  }

  /* High-Contrast Transformation Metric Pill */
  .case-metric-pill {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    background: rgba(6, 181, 249, 0.08) !important;
    border: 1px solid rgba(6, 181, 249, 0.28) !important;
    padding: 0.75rem 1.1rem !important;
    border-radius: var(--radius-md) !important;
    margin-bottom: 1.25rem !important;
    gap: 0.75rem !important;
    flex-wrap: wrap !important;
  }

  .case-metric-before {
    text-decoration: line-through !important;
    color: #F87171 !important;
    font-family: var(--font-mono) !important;
    font-weight: 600 !important;
    font-size: 0.82rem !important;
  }

  .case-metric-arrow {
    color: #8FA3B8 !important;
    margin: 0 0.35rem !important;
    font-weight: 700 !important;
  }

  .case-metric-label {
    color: #B8C7D9 !important;
    font-size: 0.82rem !important;
    font-weight: 600 !important;
  }

  .case-metric-outcome {
    font-family: var(--font-display) !important;
    font-weight: 800 !important;
    font-size: 1.18rem !important;
    color: #34D399 !important;
    letter-spacing: -0.01em !important;
    text-shadow: 0 0 16px rgba(52, 211, 153, 0.25) !important;
  }

  /* Card Title & Link */
  .case-card-title {
    font-size: 1.35rem !important;
    font-weight: 800 !important;
    line-height: 1.35 !important;
    margin-bottom: 0.85rem !important;
    color: #F5F7FA !important;
  }

  .case-card-title a {
    color: #F5F7FA !important;
    text-decoration: none !important;
    transition: color var(--transition-fast) !important;
  }

  .case-card-title a:hover {
    color: #06B5F9 !important;
  }

  /* Description Paragraph */
  .case-card-desc {
    font-size: 0.95rem !important;
    color: #B8C7D9 !important;
    line-height: 1.65 !important;
    margin-bottom: 1.5rem !important;
    flex-grow: 1 !important;
  }

  /* Card Footer Strip */
  .case-card-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
    padding-top: 1.25rem !important;
    margin-top: auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    flex-wrap: wrap !important;
    gap: 0.75rem !important;
  }

  .case-card-practice {
    font-family: var(--font-mono) !important;
    font-size: 0.78rem !important;
    color: #06B5F9 !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.06em !important;
  }

  .case-card-action {
    color: #F5F7FA !important;
    background: #071A2C !important;
    border: 1px solid rgba(6, 181, 249, 0.35) !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4) !important;
    font-size: 0.82rem !important;
    font-weight: 700 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.4rem !important;
    padding: 0.45rem 0.95rem !important;
    border-radius: var(--radius-sm) !important;
    text-decoration: none !important;
    transition: all var(--transition-fast) !important;
  }

  .case-card-action:hover {
    background: #0D223A !important;
    border-color: #06B5F9 !important;
    color: #FFFFFF !important;
  }

  .case-card-action svg {
    stroke: #06B5F9 !important;
  }

  /* Empty state */
  .case-empty-state {
    color: #8FA3B8 !important;
    font-size: 1.1rem !important;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .case-card-body {
      padding: 1.5rem 1.25rem !important;
    }
    .case-metric-pill {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 0.4rem !important;
    }
    .case-metric-outcome {
      font-size: 1.1rem !important;
    }
    .case-card-footer {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 1rem !important;
    }
    .case-card-action {
      width: 100% !important;
      justify-content: center !important;
    }
  }
</style>

<!-- Header Hero -->
<section class="section hero-enterprise case-studies-hero" style="padding-top: 5rem; padding-bottom: 3.5rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>VERIFIED CLIENT IMPACT</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.3rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.25rem;">
      Enterprise Execution. <br><span class="hero-accent-text" style="color: #06B5F9;">Documented Outcomes.</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 1.5rem;">
      Real-world engineering, performance marketing, and digital operations case studies demonstrating how we eliminate operational bottlenecks and build scalable revenue engines.
    </p>
  </div>
</section>

<!-- Case Studies Grid -->
<section class="section case-studies-grid-section" style="padding-top: 3.5rem; padding-bottom: 5rem;">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 2.25rem;">
      <?php if (!empty($cases)): ?>
        <?php foreach ($cases as $c): 
          $detailUrl = getCaseStudyUrl($c['slug']);
          $caseImg = !empty($c['featured_image']) ? $c['featured_image'] : 'uploads/cases/fintech-saas-funnel-architecture-cover.svg';
        ?>
          <article class="card case-card">
            
            <!-- Card Visual / Cover Image Container (16:9 Full Width, Flush Framing) -->
            <div class="case-card-media">
              <a href="<?= $detailUrl ?>" style="display: block; width: 100%; height: 100%; text-decoration: none;" aria-label="<?= e($c['title']) ?>">
                <img src="<?= getCaseAssetUrl($caseImg) ?>" alt="<?= e($c['cover_image_alt'] ?: $c['title']) ?>" loading="lazy">
              </a>
              <div style="position: absolute; top: 1rem; left: 1rem; pointer-events: none; z-index: 2;">
                <span class="case-card-badge">
                  <?= e($c['client_industry'] ?: $c['industry']) ?>
                </span>
              </div>
              <div style="position: absolute; bottom: 0.6rem; right: 0.6rem; pointer-events: none; z-index: 2;">
                <span class="case-card-overlay-pill">
                  ILLUSTRATIVE
                </span>
              </div>
            </div>

            <!-- Card Body -->
            <div class="case-card-body">
              
              <!-- Transformation Metric Pill -->
              <?php if (!empty($c['outcome_metric'])): ?>
                <div class="case-metric-pill">
                  <div>
                    <?php if (!empty($c['baseline_metric'])): ?>
                      <span class="case-metric-before"><?= e($c['baseline_metric']) ?></span>
                      <span class="case-metric-arrow">&rarr;</span>
                    <?php endif; ?>
                    <span class="case-metric-label"><?= e($c['metric_label'] ?: 'Result') ?></span>
                  </div>
                  <div class="case-metric-outcome">
                    <?= e($c['outcome_metric']) ?>
                  </div>
                </div>
              <?php endif; ?>

              <h2 class="case-card-title">
                <a href="<?= $detailUrl ?>">
                  <?= e($c['title']) ?>
                </a>
              </h2>

              <p class="case-card-desc">
                <?= e(mb_strimwidth($c['challenge'] ?: $c['project_summary'], 0, 160, '...')) ?>
              </p>

              <div class="case-card-footer">
                <div class="case-card-practice">
                  <?= e($c['practice_area'] ?: 'Enterprise Architecture') ?>
                </div>
                <a href="<?= $detailUrl ?>" class="case-card-action">
                  <span>Examine Case Study</span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem;">
          <p class="case-empty-state">No published case studies available at this time.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Closing Consultation CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 3rem; padding-bottom: 4rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title" style="color: #F5F7FA;">Ready to Engineer Measurable Outcomes for Your Enterprise?</h2>
        <p class="closing-cta-lead" style="color: #B8C7D9;">
          Schedule a diagnostic consultation with our enterprise technical leadership. We will audit your existing operations and design a high-ROI transformation roadmap.
        </p>
        <div class="closing-cta-buttons">
          <a href="<?= appUrl('audit.php') ?>" class="btn btn-accent btn-lg">
            <span>Request Diagnostic Consultation</span>
          </a>
          <a href="<?= appUrl('contact.php') ?>" class="btn btn-outline-gold btn-lg">
            <span>Speak With a Practice Lead</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
