<?php
/**
 * BusinessDoctor IT & Digital Services Overview Page
 * Enterprise IT Solutions & Digital Services Practice
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// 301 Permanent Redirect legacy URLs (/services.php, /services, /company-in-delhi) to canonical /company
$reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
if ($reqPath === '/services.php' || $reqPath === '/services' || $reqPath === '/services/' || $reqPath === '/company-in-delhi' || $reqPath === '/company-in-delhi/') {
    header("Location: " . getServicesOverviewUrl(), true, 301);
    exit;
}

$pageTitle = 'IT & Digital Services — BusinessDoctor Enterprise Technology';
$pageDescription = 'Explore BusinessDoctor\'s core integrated digital & technology practice areas: Web & Custom Software Development, Digital Marketing & Performance Ads, UI/UX Design & Brand Identity, E-Commerce & Marketplace Management, Creative Video Production, and Cloud Solutions & IT Consulting.';
$canonicalUrl = getServicesOverviewUrl();
$schemaPageKey = 'services';

$practices = getPracticeAreas();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Services Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>DIGITAL &amp; TECHNOLOGY SERVICES</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.5rem;">
      Full-Stack Technology &amp; <br><span class="text-brand">Digital Growth Disciplines</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      We engineer high-performance web software, manage profitable paid acquisition portfolios, and build distinctive brand architectures. Ten specialized disciplines operating under one accountable standard.
    </p>
  </div>
</section>

<!-- Services List -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="display: flex; flex-direction: column; gap: 4.5rem;">
      <?php foreach ($practices as $slug => $p): ?>
        <div id="<?= e($slug) ?>" class="capability-editorial-card">
          <div class="cap-card-body">
            <div>
              <div class="cap-card-eyebrow">
                <span>DISCIPLINE // <?= e($p['number']) ?></span>
                <span>•</span>
                <span><?= e($p['tagline']) ?></span>
              </div>

              <h2 class="cap-card-title" style="color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem; line-height: 1.2;">
                <?= e($p['name']) ?>
              </h2>
              <p style="font-size: 1.05rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 2rem;">
                <?= e($p['description']) ?>
              </p>

              <!-- Deliverables Grid -->
              <div style="margin-bottom: 2.5rem;">
                <div style="font-family: var(--font-mono); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: #06B5F9; margin-bottom: 1rem; font-weight: 700;">
                  KEY DELIVERABLES &amp; SCOPE
                </div>
                <div class="cap-deliverables-list">
                  <?php foreach ($p['deliverables'] as $item): ?>
                    <div class="cap-deliverable-item">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                      </svg>
                      <span><?= e($item) ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
              <a href="<?= getServiceUrl($slug) ?>" class="btn btn-primary">
                <span>View Full <?= e($p['short_title']) ?> Roadmap</span>
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12"/>
                  <polyline points="12 5 19 12 12 19"/>
                </svg>
              </a>
              <a href="<?= appUrl('contact.php?service=' . urlencode($p['name'])) ?>" class="btn btn-secondary">
                <span>Request Project Scope</span>
              </a>
            </div>
          </div>

          <!-- KPI & SLA Standards Side Panel -->
          <div class="cap-card-sidebar">
            <div>
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 1.25rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-accent); font-weight: 700; letter-spacing: 0.1em;">
                  PERFORMANCE BENCHMARKS
                </span>
                <div class="practice-icon" style="width: 40px; height: 40px; background: rgba(6, 181, 249, 0.15); color: var(--color-accent); border-color: rgba(6, 181, 249, 0.3);">
                  <?= $p['icon'] ?>
                </div>
              </div>

              <div class="cap-sidebar-kpi-block">
                <div class="cap-sidebar-kpi-label">KEY PERFORMANCE COMMITMENT</div>
                <div class="cap-sidebar-kpi-value"><?= e($p['kpis'][0]) ?></div>
              </div>

              <div style="margin-top: 2rem;">
                <div class="cap-sidebar-kpi-label">TECHNICAL STANDARDS</div>
                <div class="cap-sidebar-chips">
                  <?php foreach ($p['kpis'] as $kpi): ?>
                    <span class="cap-sidebar-chip"><?= e($kpi) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div style="margin-top: 3rem; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 1.5rem; font-family: var(--font-mono); font-size: 0.78rem; color: rgba(255,255,255,0.7);">
              MANAGED BY DEDICATED SENIOR TECH LEADS
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Quote & Audit CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Need a Custom IT or Marketing Solution?</h2>
        <p class="closing-cta-lead">
          Our senior technical architects are available to discuss your specifications, provide recommendations, and formulate a transparent scope.
        </p>
        <div class="closing-cta-buttons">
          <a href="<?= appUrl('contact.php') ?>" class="btn btn-primary btn-lg">
            <span>Get a Project Consultation</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="<?= appUrl('audit.php') ?>" class="btn btn-secondary btn-lg">
            <span>Request Free Technical Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
