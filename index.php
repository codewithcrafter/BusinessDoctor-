<?php
/**
 * BusinessDoctor Homepage - Enterprise IT Solutions & Digital Services
 * Design Reference: Accenture Digital Experience Standard (Independent Brand Identity)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// Local development / built-in server fallback routing for clean /services/ URLs
$reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
if ($reqPath !== null && preg_match('#^/services/([a-zA-Z0-9_-]+)/?$#', $reqPath, $sm)) {
    $_GET['slug'] = $sm[1];
    require __DIR__ . '/service-detail.php';
    exit;
} elseif ($reqPath === '/services' || $reqPath === '/services/') {
    require __DIR__ . '/services.php';
    exit;
}

$pageTitle = 'BusinessDoctor — Enterprise IT Solutions & Digital Growth Firm';
$pageDescription = 'BusinessDoctor engineers custom web and software applications, executes high-ROI performance marketing, designs distinctive brand systems, and scales enterprise e-commerce.';

$featuredCases = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT * FROM case_studies WHERE is_featured = 1 AND status = 'published' AND is_deleted = 0 ORDER BY sort_order ASC, id DESC LIMIT 3");
    $featuredCases = $stmt->fetchAll();
} catch (Exception $e) {}

$insightsList = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT * FROM insights WHERE status = 'published' AND is_deleted = 0 ORDER BY published_at DESC, id DESC LIMIT 3");
    $insightsList = $stmt->fetchAll();
} catch (Exception $e) {}

$practices = getPracticeAreas();

require_once __DIR__ . '/includes/header.php';
?>

<!-- ============================================================
     1. CINEMATIC ENTERPRISE HERO (DELOITTE-INSPIRED SCROLL TIMELINE)
     ============================================================ -->
<section class="hero-scroll-track" id="heroScrollTrack">
  <div class="hero-sticky-stage" id="heroStickyStage">
    <!-- Ambient Background Parallax & Glow Layer -->
    <div class="hero-bg-canvas" id="heroBgCanvas">
      <div class="hero-ambient-glow glow-1"></div>
      <div class="hero-ambient-glow glow-2"></div>
      <div class="hero-matrix-grid-pattern"></div>
    </div>

    <div class="container hero-stage-inner">
      <div class="hero-anim-viewport" id="heroAnimViewport">

        <!-- Column 1: Dedicated Independent Text Zone -->
        <div class="hero-text-zone" id="heroTextZone">
          <!-- Layer A: Initial Editorial Column -->
          <div class="hero-editorial-layer" id="heroEditorialLayer">
            <div class="eyebrow-badge">
              <span class="pill-dot"></span>
              <span>ENTERPRISE IT &amp; DIGITAL SOLUTIONS</span>
            </div>
            
            <h1 class="hero-headline-oversized">
              Technology That Moves Business Forward.
              <span class="text-gradient-pine">Engineered for Scalable Growth.</span>
            </h1>
            
            <p class="hero-lead-text">
              From intelligent software to digital growth, we engineer solutions that help businesses move beyond limitations. We unify custom engineering, performance marketing, and marketplace operations under one disciplined standard.
            </p>

            <div class="hero-actions-group">
              <a href="#capabilities" class="btn btn-accent btn-lg">
                <span>Explore Our Capabilities</span>
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12"/>
                  <polyline points="12 5 19 12 12 19"/>
                </svg>
              </a>
              <a href="contact.php" class="btn btn-secondary btn-lg">
                <span>Start a Project</span>
              </a>
            </div>

            <div class="hero-trust-strip">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              <span>FULL-CYCLE IT SERVICES // 100% TRANSPARENT ROADMAPS // DEDICATED TECH LEADS</span>
            </div>
          </div>

          <!-- Layer B: Mid-Scroll Progressive Reveal Layer -->
          <div class="hero-revealed-layer" id="heroRevealedLayer">
            <div class="revealed-eyebrow">
              <span class="pill-dot" style="background-color: var(--color-accent);"></span>
              <span>DISCIPLINED DIGITAL TRANSFORMATION</span>
            </div>
            <h2 class="revealed-headline">
              Engineering Without Compromise.
            </h2>
            <p class="revealed-desc">
              High-velocity software architecture, sub-second global infrastructure, and audited marketing ROI operating under one accountable standard.
            </p>
            <div class="revealed-badges-grid">
              <div class="revealed-badge-item">
                <span class="badge-indicator"></span>
                <span>Sub-Second Performance</span>
              </div>
              <div class="revealed-badge-item">
                <span class="badge-indicator"></span>
                <span>Zero Framework Bloat</span>
              </div>
              <div class="revealed-badge-item">
                <span class="badge-indicator"></span>
                <span>Audited ROI SLAs</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Column 2: Independent Foreground Technology Visual (HUD Board) -->
        <div class="hero-visual-layer" id="heroVisualLayer">
          <div class="enterprise-hud-card" id="heroHudCard">
            <div class="hud-top-bar">
              <div>
                <div class="eyebrow-badge dark" style="margin-bottom: 0.35rem; font-size: 0.68rem;">
                  ● PORTFOLIO BENCHMARK TARGETS
                </div>
                <div class="hud-top-title">Enterprise Operating Standards</div>
              </div>
              <div class="hud-status-badge">
                <span class="pill-dot" style="background-color: var(--color-accent);"></span>
                <span>STANDARDS VERIFIED</span>
              </div>
            </div>

            <div class="hud-kpi-grid">
              <div class="hud-kpi-box" data-kpi="0">
                <div class="hud-kpi-label">Global Latency / Speed Target</div>
                <div class="hud-kpi-value">&lt; 0.8s</div>
                <div class="hud-kpi-sub">100% Core Web Vitals Benchmark</div>
              </div>
              <div class="hud-kpi-box" data-kpi="1">
                <div class="hud-kpi-label">Client Portfolio ROAS</div>
                <div class="hud-kpi-value">3.8x – 4.6x</div>
                <div class="hud-kpi-sub">Audited Zero Ad Budget Waste</div>
              </div>
              <div class="hud-kpi-box" data-kpi="2">
                <div class="hud-kpi-label">High-Availability SLA</div>
                <div class="hud-kpi-value">99.98%</div>
                <div class="hud-kpi-sub">Cloud Redundant Infrastructure</div>
              </div>
              <div class="hud-kpi-box" data-kpi="3">
                <div class="hud-kpi-label">Marketplace Buy Box</div>
                <div class="hud-kpi-value">94%+</div>
                <div class="hud-kpi-sub">Amazon &amp; Flipkart Brand Defense</div>
              </div>
            </div>

            <div class="hud-capabilities-strip">
              <span style="color: var(--color-accent); font-weight: 700;">ENGINEERING ARCHITECTURE:</span>
              <span>PHP 8+ // HTML5 // VANILLA JS // SECURE CLOUD</span>
            </div>
            <div class="hud-footnote">
              * Measured portfolio benchmarks across active enterprise engagements
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Scroll Progress Indicator Pill (Live scrub feedback) -->
    <div class="hero-scroll-indicator" id="heroScrollIndicator">
      <span class="scroll-ind-pill">
        <span class="scroll-ind-dot"></span>
        <span class="scroll-ind-text">Scroll To Explore Architecture</span>
        <svg class="scroll-ind-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
      </span>
      <div class="hero-scroll-progress-line" aria-hidden="true">
        <div class="hero-scroll-progress-fill" id="heroProgressFill"></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. HOMEPAGE PORTFOLIO PERFORMANCE BENCHMARKS (KPI STRIP)
     Placed immediately after the hero scroll experience in normal document flow
     ============================================================ -->
<section class="section kpi-strip-section" id="kpiStripSection" aria-label="Portfolio Performance Benchmarks">
  <div class="container">
    <div class="vital-ticker" id="vitalTicker" role="region" aria-label="Key Performance Indicators">
      <div class="vital-ticker-grid">
        <div class="vital-item">
          <div class="vital-number" data-count="450" data-suffix="+">450+</div>
          <div class="vital-label">Projects Delivered</div>
        </div>
        <div class="vital-item">
          <div class="vital-number" data-count="48" data-prefix="$" data-suffix="M+">$48M+</div>
          <div class="vital-label">Revenue Generated</div>
        </div>
        <div class="vital-item">
          <div class="vital-number" data-count="98.4" data-suffix="%">98.4%</div>
          <div class="vital-label">Client Retention</div>
        </div>
        <div class="vital-item">
          <div class="vital-number" data-count="3.8" data-suffix="x">3.8x</div>
          <div class="vital-label">Average ROAS</div>
        </div>
      </div>

      <!-- Unverified Marketing Benchmark Indicator (Data Integrity Compliance) -->
      <div class="kpi-ticker-footnote">
        <span class="kpi-footnote-dot" aria-hidden="true"></span>
        <span>Marketing benchmark targets. Preliminary figures pending final annual audit reconciliation.</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. FEATURED CAPABILITIES (ACCENTURE-INSPIRED EXPLORER)
     ============================================================ -->
<section id="capabilities" class="section">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>FEATURED CAPABILITIES</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2rem, 3.5vw, 3rem);">Engineered Capabilities Built for Enterprise Scale</h2>
      <p class="lead">
        We deliver end-to-end capabilities across six specialized disciplines—eliminating technology bottlenecks, scaling customer acquisition, and commanding marketplace authority.
      </p>
    </div>

    <div class="capabilities-explorer">
      <!-- Capability Navigation Tabs with Horizontal Scroll Controls -->
      <div class="capabilities-nav-wrapper">
        <button 
          type="button" 
          class="cap-nav-arrow cap-nav-prev is-hidden" 
          id="capNavPrev" 
          aria-label="Scroll left to view previous service tabs"
          title="Previous service tabs"
          tabindex="0"
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>

        <div class="capabilities-nav-bar" id="capabilitiesNavBar" role="tablist" aria-label="Capabilities Navigation">
          <?php $idx = 0; foreach ($practices as $slug => $p): $idx++; ?>
            <button 
              type="button" 
              class="cap-tab-btn <?= $idx === 1 ? 'active' : '' ?>" 
              data-target="cap-pane-<?= e($slug) ?>"
              role="tab"
              aria-selected="<?= $idx === 1 ? 'true' : 'false' ?>"
            >
              <span class="cap-tab-num"><?= e($p['number']) ?>.</span>
              <span><?= e($p['short_title']) ?></span>
            </button>
          <?php endforeach; ?>
        </div>

        <button 
          type="button" 
          class="cap-nav-arrow cap-nav-next" 
          id="capNavNext" 
          aria-label="Scroll right to view more service tabs"
          title="More service tabs"
          tabindex="0"
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </button>
      </div>

      <!-- Capability Tab Panes -->
      <?php $idx = 0; foreach ($practices as $slug => $p): $idx++; ?>
        <div 
          class="cap-tab-pane <?= $idx === 1 ? 'active' : '' ?>" 
          id="cap-pane-<?= e($slug) ?>"
          role="tabpanel"
        >
          <div class="capability-editorial-card">
            <!-- Left Editorial Details -->
            <div class="cap-card-body">
              <div>
                <div class="cap-card-eyebrow">
                  <span>DISCIPLINE // <?= e($p['number']) ?></span>
                  <span>•</span>
                  <span><?= e($p['tagline']) ?></span>
                </div>
                <h3 class="cap-card-title"><?= e($p['name']) ?></h3>
                <p class="cap-card-desc"><?= e($p['description']) ?></p>

                <div class="cap-deliverables-list">
                  <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">
                    CORE DELIVERABLES &amp; EXECUTION:
                  </div>
                  <?php foreach ($p['deliverables'] as $deliv): ?>
                    <div class="cap-deliverable-item">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                      </svg>
                      <span><?= e($deliv) ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <div>
                <a href="<?= getServiceUrl($slug) ?>" class="btn btn-primary">
                  <span>Explore Full <?= e($p['short_title']) ?> Roadmap</span>
                  <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                  </svg>
                </a>
              </div>
            </div>

            <!-- Right Strategic KPI Sidebar -->
            <div class="cap-card-sidebar">
              <div>
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

              <div style="margin-top: 3rem; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 1.5rem;">
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.78); line-height: 1.5; margin-bottom: 1rem;">
                  Need an architectural evaluation or custom scope for <?= e($p['name']) ?>?
                </p>
                <a href="contact.php" class="btn btn-accent btn-sm">
                  <span>Consult With Tech Lead</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     3. BUSINESS TRANSFORMATION STORYTELLING
     ============================================================ -->
<section class="section transformation-section">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>BUSINESS TRANSFORMATION</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2rem, 3.5vw, 3rem);">Why Managing Multiple Freelancers &amp; Vendors Slows Down Your Growth</h2>
      <p class="lead">
        Most companies struggle because their web developer, SEO specialist, ad agency, and designer never communicate. BusinessDoctor unifies end-to-end technology and digital services under one disciplined standard.
      </p>
    </div>

    <div class="matrix-grid">
      <!-- Card A: Fragmented Vendors -->
      <div class="matrix-card symptom">
        <div class="matrix-header">
          <span class="matrix-badge">Fragmented Vendors &amp; Generic Agencies</span>
        </div>
        <h3>Disconnected Work, Technical Debt &amp; Wasted Ad Budgets</h3>
        <p style="font-size: 0.95rem; color: #cbd5e1; line-height: 1.6;">
          Hiring separate freelancers or specialized agencies leads to finger-pointing, slow project delivery, bloated code, and unoptimized ad spend.
        </p>

        <div class="matrix-list">
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <span><strong>Bloated, Slow Websites:</strong> Developers use pre-made templates with 5-second load times that destroy your SEO rankings and paid traffic conversions.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <span><strong>Inefficient Paid Ad Spend:</strong> Marketing agencies burn budgets on generic audiences while failing to fix fundamental landing page bottlenecks.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <span><strong>Zero Single Accountability:</strong> When customer acquisition costs soar, developers blame the marketers, and marketers blame the website.</span>
          </div>
        </div>
      </div>

      <!-- Card B: BusinessDoctor Solution -->
      <div class="matrix-card cure">
        <div class="matrix-header">
          <span class="matrix-badge">The BusinessDoctor Advantage</span>
        </div>
        <h3>Integrated Engineering &amp; High-Velocity Digital Execution</h3>
        <p style="font-size: 0.95rem; color: rgba(255, 255, 255, 0.85); line-height: 1.6;">
          We operate as your dedicated technology and digital growth partner—building clean software, scaling traffic, optimizing conversions, and protecting your bottom line.
        </p>

        <div class="matrix-list">
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span><strong>Custom Enterprise Engineering:</strong> Clean, semantic, lightning-fast PHP, HTML5, and vanilla JS web applications that load in under 1 second globally.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span><strong>High-ROI Performance Marketing:</strong> Targeted Google Search, Meta Ads, and Technical SEO campaigns built to deliver profitable customer acquisition.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span><strong>Dedicated Senior Tech Leads:</strong> One accountable partner managing your digital transformation with transparent milestone reporting.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     NEW SECTION 1: INTERACTIVE BENEFITS ACCORDION WITH DYNAMIC GRAPHS
     ============================================================ -->
<section class="section benefits-section" id="benefitsSection">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>BUSINESS IMPACT</span>
      </div>
      <h2 class="section-title">Why Businesses Choose BusinessDoctor</h2>
      <p class="lead" style="max-width: 760px; margin: 0 auto;">
        From stronger brand visibility to measurable commercial growth, we combine technology, marketing and business strategy to deliver meaningful outcomes.
      </p>
    </div>

    <div class="benefits-layout-grid">
      <!-- Left Column: 6 Expandable Accordion Items -->
      <div class="benefits-accordion" role="region" aria-label="Business Impact Benefits">
        
        <!-- 01: Increase Brand Visibility -->
        <div class="benefits-accordion-item active" data-index="0">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger0" aria-expanded="true" aria-controls="benefitPanel0">
            <span class="benefit-trigger-left">
              <span class="benefit-num">01</span>
              <span class="benefit-title">Increase Brand Visibility</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel0" role="region" aria-labelledby="benefitTrigger0">
            <p class="benefit-desc">
              Build a stronger digital presence through search engines, social platforms, content and integrated digital channels.
            </p>
            <div class="benefit-tag-strip">
              <span class="benefit-pill">Omnichannel Presence</span>
              <span class="benefit-pill">Search Visibility</span>
              <span class="benefit-pill">Brand Awareness</span>
            </div>
          </div>
        </div>

        <!-- 02: Drive Meaningful Engagement -->
        <div class="benefits-accordion-item" data-index="1">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger1" aria-expanded="false" aria-controls="benefitPanel1">
            <span class="benefit-trigger-left">
              <span class="benefit-num">02</span>
              <span class="benefit-title">Drive Meaningful Engagement</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel1" role="region" aria-labelledby="benefitTrigger1">
            <p class="benefit-desc">
              Create relevant customer experiences that encourage interaction, strengthen relationships and improve audience engagement.
            </p>
            <div class="benefit-tag-strip">
              <span class="benefit-pill">Interactive UX</span>
              <span class="benefit-pill">Audience Retention</span>
              <span class="benefit-pill">Multi-Touchpoint Reach</span>
            </div>
          </div>
        </div>

        <!-- 03: Improve Return on Investment -->
        <div class="benefits-accordion-item" data-index="2">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger2" aria-expanded="false" aria-controls="benefitPanel2">
            <span class="benefit-trigger-left">
              <span class="benefit-num">03</span>
              <span class="benefit-title">Improve Return on Investment</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel2" role="region" aria-labelledby="benefitTrigger2">
            <p class="benefit-desc">
              Use performance tracking, campaign optimization and data-led marketing decisions to improve marketing efficiency and returns.
            </p>
            <div class="benefit-tag-strip">
              <span class="benefit-pill">ROAS Optimization</span>
              <span class="benefit-pill">CAC Reduction</span>
              <span class="benefit-pill">Capital Efficiency</span>
            </div>
          </div>
        </div>

        <!-- 04: Reach the Right Audience -->
        <div class="benefits-accordion-item" data-index="3">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger3" aria-expanded="false" aria-controls="benefitPanel3">
            <span class="benefit-trigger-left">
              <span class="benefit-num">04</span>
              <span class="benefit-title">Reach the Right Audience</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel3" role="region" aria-labelledby="benefitTrigger3">
            <p class="benefit-desc">
              Identify relevant audience segments and connect your products and services with customers who are more likely to convert.
            </p>
            <div class="benefit-tag-strip">
              <span class="benefit-pill">Precision Segmentation</span>
              <span class="benefit-pill">High-Intent ICP</span>
              <span class="benefit-pill">Buyer Journey Mapping</span>
            </div>
          </div>
        </div>

        <!-- 05: Make Data-Driven Decisions -->
        <div class="benefits-accordion-item" data-index="4">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger4" aria-expanded="false" aria-controls="benefitPanel4">
            <span class="benefit-trigger-left">
              <span class="benefit-num">05</span>
              <span class="benefit-title">Make Data-Driven Decisions</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel4" role="region" aria-labelledby="benefitTrigger4">
            <p class="benefit-desc">
              Turn campaign analytics, customer behaviour and performance insights into informed business decisions.
            </p>
            <div class="benefit-tag-strip">
              <span class="benefit-pill">Real-Time Dashboards</span>
              <span class="benefit-pill">Predictive Analytics</span>
              <span class="benefit-pill">Attribution Modeling</span>
            </div>
          </div>
        </div>

        <!-- 06: Improve Conversion Rates -->
        <div class="benefits-accordion-item" data-index="5">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger5" aria-expanded="false" aria-controls="benefitPanel5">
            <span class="benefit-trigger-left">
              <span class="benefit-num">06</span>
              <span class="benefit-title">Improve Conversion Rates</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel5" role="region" aria-labelledby="benefitTrigger5">
            <p class="benefit-desc">
              Optimize landing pages, customer journeys and digital experiences to reduce friction and increase qualified conversions.
            </p>
            <div class="benefit-tag-strip">
              <span class="benefit-pill">Conversion Architecture</span>
              <span class="benefit-pill">A/B Testing</span>
              <span class="benefit-pill">Friction Elimination</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Column: Dynamic Visualization Panel -->
      <div class="benefits-viz-container" id="benefitsVizContainer">
        <div class="benefits-viz-header">
          <div>
            <span class="benefits-viz-kicker" id="vizKicker">PERFORMANCE MODEL 01</span>
            <h3 class="benefits-viz-heading" id="vizHeading">Brand Visibility &amp; Reach Funnel</h3>
          </div>
          <span class="viz-badge-demo">Illustrative Example</span>
        </div>

        <div class="benefits-viz-stage">
          <!-- 01: Horizontal Funnel Visualization -->
          <div class="benefits-viz-item active" data-viz="0">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg" aria-label="Horizontal Funnel: Total Reach to Brand Searches">
              <defs>
                <linearGradient id="hGrad1" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#073B42"/>
                  <stop offset="100%" stop-color="#00C9C1"/>
                </linearGradient>
                <linearGradient id="hGrad2" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#00C9C1"/>
                  <stop offset="100%" stop-color="#39E0D5"/>
                </linearGradient>
                <linearGradient id="hBridge" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#00C9C1" stop-opacity="0.12"/>
                  <stop offset="100%" stop-color="#073B42" stop-opacity="0.04"/>
                </linearGradient>
              </defs>
              <!-- Stage 1 -->
              <rect x="20" y="16" width="500" height="44" rx="8" fill="#071A2C" stroke="rgba(0, 201, 193, 0.3)" stroke-width="1.2"/>
              <rect x="20" y="16" width="496" height="44" rx="8" fill="url(#hGrad1)" fill-opacity="0.25"/>
              <text x="36" y="43" fill="#F4F8FC" font-size="12.5" font-family="var(--font-display)" font-weight="700">01 // TOTAL REACH</text>
              <text x="360" y="43" fill="#39E0D5" font-size="13" font-family="var(--font-mono)" font-weight="700">1,250,000</text>
              <text x="475" y="43" fill="#AABBCB" font-size="11.5" font-family="var(--font-mono)">100%</text>

              <!-- Bridge 1-2 -->
              <polygon points="120,60 420,60 380,78 160,78" fill="url(#hBridge)"/>

              <!-- Stage 2 -->
              <rect x="55" y="78" width="430" height="44" rx="8" fill="#071A2C" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.2"/>
              <rect x="55" y="78" width="310" height="44" rx="8" fill="url(#hGrad1)" fill-opacity="0.4"/>
              <text x="71" y="105" fill="#F4F8FC" font-size="12.5" font-family="var(--font-display)" font-weight="700">02 // WEBSITE VISITORS</text>
              <text x="360" y="105" fill="#39E0D5" font-size="13" font-family="var(--font-mono)" font-weight="700">240,000</text>
              <text x="445" y="105" fill="#AABBCB" font-size="11.5" font-family="var(--font-mono)">65%</text>

              <!-- Bridge 2-3 -->
              <polygon points="175,122 365,122 335,140 205,140" fill="url(#hBridge)"/>

              <!-- Stage 3 -->
              <rect x="95" y="140" width="350" height="44" rx="8" fill="#071A2C" stroke="rgba(0, 201, 193, 0.45)" stroke-width="1.2"/>
              <rect x="95" y="140" width="200" height="44" rx="8" fill="url(#hGrad2)" fill-opacity="0.5"/>
              <text x="111" y="167" fill="#F4F8FC" font-size="12.5" font-family="var(--font-display)" font-weight="700">03 // ENGAGED AUDIENCE</text>
              <text x="340" y="167" fill="#39E0D5" font-size="13" font-family="var(--font-mono)" font-weight="700">85,000</text>
              <text x="405" y="167" fill="#AABBCB" font-size="11.5" font-family="var(--font-mono)">40%</text>

              <!-- Bridge 3-4 -->
              <polygon points="215,184 325,184 300,202 240,202" fill="url(#hBridge)"/>

              <!-- Stage 4 -->
              <rect x="125" y="202" width="290" height="44" rx="8" fill="#071A2C" stroke="#00C9C1" stroke-width="1.5"/>
              <rect x="125" y="202" width="140" height="44" rx="8" fill="url(#hGrad2)" fill-opacity="0.8"/>
              <text x="140" y="229" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700">04 // BRAND SEARCHES</text>
              <text x="312" y="229" fill="#39E0D5" font-size="12.5" font-family="var(--font-mono)" font-weight="700">42,000</text>
              <text x="375" y="229" fill="#AABBCB" font-size="11" font-family="var(--font-mono)">24%</text>
            </svg>
          </div>

          <!-- 02: Vertical Bar Chart -->
          <div class="benefits-viz-item" data-viz="1">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg" aria-label="Vertical Bar Chart: Channel Engagement">
              <defs>
                <linearGradient id="vBarGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#39E0D5"/>
                  <stop offset="70%" stop-color="#00C9C1"/>
                  <stop offset="100%" stop-color="#073B42"/>
                </linearGradient>
              </defs>
              <!-- Grid lines -->
              <line x1="40" y1="35" x2="510" y2="35" stroke="rgba(0, 201, 193, 0.12)" stroke-dasharray="3 3"/>
              <text x="25" y="38" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">100%</text>
              <line x1="40" y1="85" x2="510" y2="85" stroke="rgba(0, 201, 193, 0.12)" stroke-dasharray="3 3"/>
              <text x="28" y="88" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">75%</text>
              <line x1="40" y1="135" x2="510" y2="135" stroke="rgba(0, 201, 193, 0.12)" stroke-dasharray="3 3"/>
              <text x="28" y="138" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">50%</text>
              <line x1="40" y1="185" x2="510" y2="185" stroke="rgba(0, 201, 193, 0.12)" stroke-dasharray="3 3"/>
              <text x="28" y="188" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">25%</text>
              <line x1="40" y1="215" x2="510" y2="215" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.5"/>

              <!-- Bar 1: Website Interaction (88%) -->
              <rect x="65" y="59" width="56" height="156" rx="6" fill="url(#vBarGrad)"/>
              <text x="93" y="49" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700" text-anchor="middle">88%</text>
              <text x="93" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)" text-anchor="middle">Website</text>

              <!-- Bar 2: Social Engagement (74%) -->
              <rect x="160" y="87" width="56" height="128" rx="6" fill="url(#vBarGrad)"/>
              <text x="188" y="77" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700" text-anchor="middle">74%</text>
              <text x="188" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)" text-anchor="middle">Social</text>

              <!-- Bar 3: Content Engagement (68%) -->
              <rect x="255" y="99" width="56" height="116" rx="6" fill="url(#vBarGrad)"/>
              <text x="283" y="89" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700" text-anchor="middle">68%</text>
              <text x="283" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)" text-anchor="middle">Content</text>

              <!-- Bar 4: Video Engagement (94%) -->
              <rect x="350" y="47" width="56" height="168" rx="6" fill="url(#vBarGrad)" stroke="#39E0D5" stroke-width="1.2"/>
              <text x="378" y="37" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700" text-anchor="middle">94%</text>
              <text x="378" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)" text-anchor="middle">Video</text>

              <!-- Bar 5: Email Engagement (62%) -->
              <rect x="445" y="111" width="56" height="104" rx="6" fill="url(#vBarGrad)"/>
              <text x="473" y="101" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700" text-anchor="middle">62%</text>
              <text x="473" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)" text-anchor="middle">Email</text>
            </svg>
          </div>

          <!-- 03: Donut Chart with Center KPI -->
          <div class="benefits-viz-item" data-viz="2">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg" aria-label="Donut Chart: Marketing Investment and Revenue Return">
              <circle cx="160" cy="135" r="75" stroke="#071A2C" stroke-width="26" fill="none"/>
              <circle cx="160" cy="135" r="75" stroke="#073B42" stroke-width="24" stroke-dasharray="113 471" stroke-dashoffset="-358" fill="none"/>
              <circle cx="160" cy="135" r="75" stroke="#00C9C1" stroke-width="24" stroke-dasharray="358 471" stroke-dashoffset="0" stroke-linecap="round" fill="none"/>

              <circle cx="160" cy="135" r="54" fill="#0A1D35" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.5"/>
              <text x="160" y="125" fill="#39E0D5" font-size="22" font-family="var(--font-display)" font-weight="900" text-anchor="middle">4.2×</text>
              <text x="160" y="142" fill="#F4F8FC" font-size="9" font-family="var(--font-mono)" font-weight="700" text-anchor="middle">AVERAGE ROAS</text>
              <text x="160" y="157" fill="#00C9C1" font-size="8.5" font-family="var(--font-mono)" text-anchor="middle">+320% RETURN</text>

              <g transform="translate(300, 48)">
                <rect width="215" height="66" rx="8" fill="#071A2C" stroke="rgba(0, 201, 193, 0.3)" stroke-width="1.2"/>
                <circle cx="24" cy="33" r="7" fill="#00C9C1"/>
                <text x="42" y="27" fill="#F4F8FC" font-size="12" font-family="var(--font-display)" font-weight="700">Revenue Return</text>
                <text x="42" y="45" fill="#39E0D5" font-size="14" font-family="var(--font-mono)" font-weight="800">76% of Total Value</text>
                <text x="42" y="58" fill="#AABBCB" font-size="9" font-family="var(--font-mono)">Verified Commercial Lift</text>
              </g>

              <g transform="translate(300, 134)">
                <rect width="215" height="66" rx="8" fill="#071A2C" stroke="rgba(0, 201, 193, 0.2)" stroke-width="1.2"/>
                <circle cx="24" cy="33" r="7" fill="#073B42" stroke="#39E0D5" stroke-width="1.5"/>
                <text x="42" y="27" fill="#F4F8FC" font-size="12" font-family="var(--font-display)" font-weight="700">Marketing Investment</text>
                <text x="42" y="45" fill="#C3D0DE" font-size="14" font-family="var(--font-mono)" font-weight="800">24% Optimized Capital</text>
                <text x="42" y="58" fill="#AABBCB" font-size="9" font-family="var(--font-mono)">Zero Ad Budget Waste</text>
              </g>
            </svg>
          </div>

          <!-- 04: Segmented Audience Funnel -->
          <div class="benefits-viz-item" data-viz="3">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg" aria-label="Segmented Audience Funnel">
              <defs>
                <linearGradient id="seg1" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#073B42" stop-opacity="0.7"/>
                  <stop offset="100%" stop-color="#00C9C1" stop-opacity="0.4"/>
                </linearGradient>
                <linearGradient id="seg2" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#00C9C1" stop-opacity="0.8"/>
                  <stop offset="100%" stop-color="#39E0D5" stop-opacity="0.6"/>
                </linearGradient>
              </defs>

              <polygon points="30,20 510,20 460,58 80,58" fill="url(#seg1)" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.2"/>
              <text x="270" y="38" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700" text-anchor="middle">TOTAL MARKET (100% // 500K)</text>

              <polygon points="85,64 455,64 415,102 125,102" fill="url(#seg1)" stroke="rgba(0, 201, 193, 0.45)" stroke-width="1.2"/>
              <text x="270" y="82" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700" text-anchor="middle">TARGETED SEGMENT (58% // 290K)</text>

              <polygon points="130,108 410,108 370,146 170,146" fill="url(#seg1)" stroke="rgba(0, 201, 193, 0.55)" stroke-width="1.2"/>
              <text x="270" y="126" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700" text-anchor="middle">QUALIFIED LEADS (32% // 160K)</text>

              <polygon points="175,152 365,152 335,190 205,190" fill="url(#seg2)" stroke="#00C9C1" stroke-width="1.4"/>
              <text x="270" y="170" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700" text-anchor="middle">ENGAGED USERS (18% // 90K)</text>

              <polygon points="210,196 330,196 305,236 235,236" fill="url(#seg2)" stroke="#39E0D5" stroke-width="1.6"/>
              <text x="270" y="214" fill="#061326" font-size="10.5" font-family="var(--font-display)" font-weight="900" text-anchor="middle">CONVERTED</text>
              <text x="270" y="228" fill="#061326" font-size="9" font-family="var(--font-mono)" font-weight="800" text-anchor="middle">7.4% (37K)</text>
            </svg>
          </div>

          <!-- 05: Multi-Trend Line Chart -->
          <div class="benefits-viz-item" data-viz="4">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg" aria-label="Multi-Trend Line Chart: Traffic, Engagement, Conversion">
              <defs>
                <linearGradient id="areaTraffic" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#00C9C1" stop-opacity="0.35"/>
                  <stop offset="100%" stop-color="#073B42" stop-opacity="0.0"/>
                </linearGradient>
              </defs>

              <line x1="45" y1="30" x2="510" y2="30" stroke="rgba(0, 201, 193, 0.1)" stroke-dasharray="3 3"/>
              <line x1="45" y1="80" x2="510" y2="80" stroke="rgba(0, 201, 193, 0.1)" stroke-dasharray="3 3"/>
              <line x1="45" y1="130" x2="510" y2="130" stroke="rgba(0, 201, 193, 0.1)" stroke-dasharray="3 3"/>
              <line x1="45" y1="180" x2="510" y2="180" stroke="rgba(0, 201, 193, 0.1)" stroke-dasharray="3 3"/>
              <line x1="45" y1="210" x2="510" y2="210" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.5"/>

              <text x="60" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M1</text>
              <text x="145" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M2</text>
              <text x="230" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M3</text>
              <text x="315" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M4</text>
              <text x="400" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M5</text>
              <text x="485" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M6</text>

              <path d="M 60,185 C 130,165 200,135 270,105 C 340,80 415,55 485,38 L 485,210 L 60,210 Z" fill="url(#areaTraffic)"/>
              <path d="M 60,185 C 130,165 200,135 270,105 C 340,80 415,55 485,38" stroke="#00C9C1" stroke-width="3" stroke-linecap="round"/>
              <path d="M 60,195 C 130,185 200,160 270,130 C 340,110 415,85 485,65" stroke="#39E0D5" stroke-width="2.5" stroke-dasharray="5 4" stroke-linecap="round"/>
              <path d="M 60,205 C 130,200 200,185 270,165 C 340,140 415,115 485,92" stroke="#6EE7B7" stroke-width="2" stroke-dasharray="2 3" stroke-linecap="round"/>

              <circle cx="60" cy="185" r="4" fill="#071A2C" stroke="#00C9C1" stroke-width="2"/>
              <circle cx="270" cy="105" r="4.5" fill="#071A2C" stroke="#00C9C1" stroke-width="2"/>
              <circle cx="485" cy="38" r="5" fill="#39E0D5" stroke="#071A2C" stroke-width="2"/>

              <g transform="translate(60, 245)">
                <line x1="0" y1="6" x2="20" y2="6" stroke="#00C9C1" stroke-width="3"/>
                <text x="26" y="10" fill="#F4F8FC" font-size="10" font-family="var(--font-mono)">Traffic (+240%)</text>
                <line x1="140" y1="6" x2="160" y2="6" stroke="#39E0D5" stroke-width="2.5" stroke-dasharray="4 3"/>
                <text x="166" y="10" fill="#39E0D5" font-size="10" font-family="var(--font-mono)">Engagement (88%)</text>
                <line x1="300" y1="6" x2="320" y2="6" stroke="#6EE7B7" stroke-width="2" stroke-dasharray="2 3"/>
                <text x="326" y="10" fill="#C3D0DE" font-size="10" font-family="var(--font-mono)">Conversion (4.8%)</text>
              </g>
            </svg>
          </div>

          <!-- 06: Conversion Funnel -->
          <div class="benefits-viz-item" data-viz="5">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg" aria-label="Conversion Funnel: Visitors to Conversions">
              <defs>
                <linearGradient id="cfGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#073B42"/>
                  <stop offset="100%" stop-color="#00C9C1"/>
                </linearGradient>
              </defs>

              <rect x="30" y="16" width="480" height="36" rx="6" fill="#071A2C" stroke="rgba(0, 201, 193, 0.3)" stroke-width="1.2"/>
              <rect x="30" y="16" width="476" height="36" rx="6" fill="url(#cfGrad)" fill-opacity="0.25"/>
              <text x="45" y="39" fill="#F4F8FC" font-size="12" font-family="var(--font-display)" font-weight="700">1. VISITORS</text>
              <text x="365" y="39" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700">10,000</text>
              <text x="465" y="39" fill="#AABBCB" font-size="11" font-family="var(--font-mono)">100%</text>

              <text x="270" y="60" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle">▼ -36% (High-intent discovery filter)</text>

              <rect x="65" y="66" width="410" height="36" rx="6" fill="#071A2C" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.2"/>
              <rect x="65" y="66" width="310" height="36" rx="6" fill="url(#cfGrad)" fill-opacity="0.35"/>
              <text x="80" y="89" fill="#F4F8FC" font-size="12" font-family="var(--font-display)" font-weight="700">2. PRODUCT/SERVICE VIEWS</text>
              <text x="365" y="89" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700">6,400</text>
              <text x="435" y="89" fill="#AABBCB" font-size="11" font-family="var(--font-mono)">64%</text>

              <text x="270" y="110" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle">▼ -30% (Solution alignment evaluation)</text>

              <rect x="105" y="116" width="330" height="36" rx="6" fill="#071A2C" stroke="rgba(0, 201, 193, 0.45)" stroke-width="1.2"/>
              <rect x="105" y="116" width="180" height="36" rx="6" fill="url(#cfGrad)" fill-opacity="0.5"/>
              <text x="120" y="139" fill="#F4F8FC" font-size="12" font-family="var(--font-display)" font-weight="700">3. ENQUIRIES</text>
              <text x="330" y="139" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700">3,400</text>
              <text x="395" y="139" fill="#AABBCB" font-size="11" font-family="var(--font-mono)">34%</text>

              <text x="270" y="160" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle">▼ -16% (Scope and qualification fit)</text>

              <rect x="145" y="166" width="250" height="36" rx="6" fill="#071A2C" stroke="rgba(0, 201, 193, 0.55)" stroke-width="1.2"/>
              <rect x="145" y="166" width="115" height="36" rx="6" fill="url(#cfGrad)" fill-opacity="0.65"/>
              <text x="160" y="189" fill="#F4F8FC" font-size="12" font-family="var(--font-display)" font-weight="700">4. QUALIFIED LEADS</text>
              <text x="315" y="189" fill="#39E0D5" font-size="12" font-family="var(--font-mono)" font-weight="700">1,800</text>
              <text x="360" y="189" fill="#AABBCB" font-size="11" font-family="var(--font-mono)">18%</text>

              <text x="270" y="210" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle">▼ -9.8% (Commercial commitment)</text>

              <rect x="180" y="216" width="180" height="38" rx="8" fill="#071A2C" stroke="#00C9C1" stroke-width="1.6"/>
              <rect x="180" y="216" width="180" height="38" rx="8" fill="#00C9C1" fill-opacity="0.2"/>
              <text x="195" y="240" fill="#39E0D5" font-size="12" font-family="var(--font-display)" font-weight="900">5. CONVERSIONS</text>
              <text x="305" y="240" fill="#00C9C1" font-size="13" font-family="var(--font-mono)" font-weight="800">820 (8.2%)</text>
            </svg>
          </div>
        </div>

        <div class="benefits-viz-footnote">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          <span>Illustrative benchmark model. Values shown for visual demonstration of methodology.</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     5. THE 5-STAGE ENTERPRISE APPROACH (INTERACTIVE MOVABLE TRACK)
     ============================================================ -->
<section class="stage-carousel-section" id="methodologySection">
  <div class="container">
    <div class="stage-top-bar">
      <div class="stage-header-col">
        <div class="eyebrow-badge">
          <span class="pill-dot"></span>
          <span>OUR APPROACH</span>
        </div>
        <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-bottom: 1rem;">A Disciplined Engineering &amp; Growth Methodology</h2>
        <p class="lead" style="margin-bottom: 0;">
          From initial architectural diagnosis to continuous performance scaling, our 5-stage framework ensures precision, speed, and measurable business return.
        </p>
      </div>

      <div class="stage-controls-col">
        <div class="stage-controls-row">
          <div class="stage-drag-hint">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
            <span>Drag or Swipe to Explore</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </div>
          <div class="stage-counter-badge" aria-live="polite">
            STAGE <span class="active-num" id="currentStageNum">01</span> / 05
          </div>
          <button type="button" class="stage-nav-btn" id="stagePrevBtn" aria-label="Previous stage" disabled>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
          </button>
          <button type="button" class="stage-nav-btn" id="stageNextBtn" aria-label="Next stage">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Quick Jump Step Pills -->
    <div class="stage-pills-row" role="tablist" aria-label="Stage selector">
      <button type="button" class="stage-pill active" data-stage="0" role="tab" aria-selected="true">
        <span>01</span> Discover
      </button>
      <button type="button" class="stage-pill" data-stage="1" role="tab" aria-selected="false">
        <span>02</span> Strategize
      </button>
      <button type="button" class="stage-pill" data-stage="2" role="tab" aria-selected="false">
        <span>03</span> Engineer
      </button>
      <button type="button" class="stage-pill" data-stage="3" role="tab" aria-selected="false">
        <span>04</span> Optimize
      </button>
      <button type="button" class="stage-pill" data-stage="4" role="tab" aria-selected="false">
        <span>05</span> Grow
      </button>
    </div>

    <!-- Progress Indicator Bar -->
    <div class="stage-progress-track" aria-hidden="true">
      <div class="stage-progress-fill" id="stageProgressFill" style="width: 20%;"></div>
    </div>

    <!-- Movable Track Viewport -->
    <div class="stage-carousel-viewport" id="stageCarouselViewport" role="region" aria-roledescription="carousel" aria-label="5-Stage Engineering and Growth Methodology" tabindex="0">
      <div class="stage-track" id="stageTrack">

        <!-- Step 1: Discover -->
        <article class="stage-card is-active" data-index="0" role="group" aria-roledescription="slide" aria-label="Stage 1 of 5: Discover">
          <div class="stage-watermark">01</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 01 // ARCHITECTURAL AUDIT</span>
            </div>
            <span class="approach-num">01</span>
            <h3 class="approach-title">Discover</h3>
            <p class="approach-desc">
              Deep-dive technical audit into your current codebase, database efficiency, SEO visibility, paid acquisition CAC, and conversion leakages.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Full Architecture &amp; Funnel Audit
          </div>
        </article>

        <!-- Step 2: Strategize -->
        <article class="stage-card" data-index="1" role="group" aria-roledescription="slide" aria-label="Stage 2 of 5: Strategize">
          <div class="stage-watermark">02</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 02 // SYSTEMS ARCHITECTURE</span>
            </div>
            <span class="approach-num">02</span>
            <h3 class="approach-title">Strategize</h3>
            <p class="approach-desc">
              Formulating an enterprise solution blueprint: data schema, technology stack selection, paid channel allocation, and measurable milestone roadmap.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Systems Blueprint &amp; KPI SLAs
          </div>
        </article>

        <!-- Step 3: Engineer -->
        <article class="stage-card" data-index="2" role="group" aria-roledescription="slide" aria-label="Stage 3 of 5: Engineer">
          <div class="stage-watermark">03</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 03 // FULL-STACK BUILD</span>
            </div>
            <span class="approach-num">03</span>
            <h3 class="approach-title">Engineer</h3>
            <p class="approach-desc">
              Executing clean custom development with PHP 8+, modern HTML5/CSS3, and vanilla JS, paired with conversion-driven UI/UX design and catalog setup.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Production-Ready Applications
          </div>
        </article>

        <!-- Step 4: Optimize -->
        <article class="stage-card" data-index="3" role="group" aria-roledescription="slide" aria-label="Stage 4 of 5: Optimize">
          <div class="stage-watermark">04</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 04 // PERFORMANCE &amp; ROAS</span>
            </div>
            <span class="approach-num">04</span>
            <h3 class="approach-title">Optimize</h3>
            <p class="approach-desc">
              Achieving 100% Core Web Vitals, A/B testing landing page conversion rates, eliminating low-performing ad audiences, and defending the Buy Box.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Sub-Second Load &amp; Higher ROAS
          </div>
        </article>

        <!-- Step 5: Grow -->
        <article class="stage-card" data-index="4" role="group" aria-roledescription="slide" aria-label="Stage 5 of 5: Grow">
          <div class="stage-watermark">05</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 05 // SCALE &amp; RETENTION</span>
            </div>
            <span class="approach-num">05</span>
            <h3 class="approach-title">Grow</h3>
            <p class="approach-desc">
              Scaling high-margin channels, expanding organic search dominance, automating repetitive workflows, and providing 24/7 technical monitoring.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Scalable Revenue &amp; Retained Value
          </div>
        </article>

      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     6. PROVEN OUTCOMES (STANDARDS & ACCOUNTABILITY TIMELINE)
     ============================================================ -->
<section class="section accountability-section" id="accountability">
  <!-- Background Ambient & Decorative Layers -->
  <div class="accountability-bg-layer" aria-hidden="true">
    <div class="accountability-ambient-glow glow-left"></div>
    <div class="accountability-ambient-glow glow-right"></div>
    <svg class="accountability-wave-lines" viewBox="0 0 1440 600" fill="none" preserveAspectRatio="none">
      <path d="M-100,200 C300,50 600,350 1100,120 C1300,30 1500,250 1600,200" stroke="rgba(87, 64, 84, 0.08)" stroke-width="1.5" stroke-dasharray="6 6"/>
      <path d="M-100,320 C250,180 750,420 1200,240 C1400,160 1550,300 1600,280" stroke="rgba(161, 126, 145, 0.12)" stroke-width="1.5"/>
      <path d="M-50,450 C350,300 850,550 1350,380 C1500,320 1600,400 1650,390" stroke="rgba(87, 64, 84, 0.06)" stroke-width="1"/>
    </svg>
    <div class="accountability-corner-accent top-left"></div>
    <div class="accountability-corner-accent bottom-right"></div>
  </div>

  <div class="container" style="position: relative; z-index: 2;">
    <!-- Section Header -->
    <div class="accountability-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>PROVEN OUTCOMES</span>
      </div>
      <h2 class="accountability-title">
        Built on Engineering Integrity &amp; <span class="title-accent">Measurable Accountability</span>
      </h2>
      <p class="accountability-desc">
        We partner with established companies that demand transparent roadmaps, enterprise security standards, and zero wasted capital.
      </p>
    </div>

    <!-- 4 Feature Cards Grid -->
    <div class="accountability-grid">

      <!-- Card 01: Framework-Free Speed -->
      <article class="accountability-card">
        <div class="accountability-card-visual">
          <div class="visual-tag">SUB-SECOND SLA</div>
          <div class="visual-number">01</div>
          <svg class="visual-artwork" viewBox="0 0 340 195" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
              <radialGradient id="cardGlow1" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#073B42" stop-opacity="0.45"/>
                <stop offset="100%" stop-color="#0A1D35" stop-opacity="0"/>
              </radialGradient>
              <linearGradient id="goldAcc1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#39E0D5"/>
                <stop offset="100%" stop-color="#00C9C1"/>
              </linearGradient>
            </defs>
            <rect width="340" height="195" fill="url(#cardGlow1)"/>
            <text x="20" y="58" fill="rgba(0, 201, 193, 0.35)" font-size="8.5" font-family="monospace">&lt;?php declare(strict_types=1);</text>
            <text x="20" y="74" fill="rgba(57, 224, 213, 0.25)" font-size="8.5" font-family="monospace">const LATENCY = '0.38s'; // 0MB BLOAT</text>
            <text x="20" y="90" fill="rgba(0, 201, 193, 0.3)" font-size="8.5" font-family="monospace">return new EnterpriseResponse();</text>
            <circle cx="170" cy="115" r="46" stroke="rgba(0, 201, 193, 0.3)" stroke-width="1.5" stroke-dasharray="4 4"/>
            <circle cx="170" cy="115" r="36" fill="#071A2C" stroke="rgba(0, 201, 193, 0.45)" stroke-width="1.5"/>
            <polyline points="154,106 144,115 154,124" stroke="url(#goldAcc1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <polyline points="186,106 196,115 186,124" stroke="url(#goldAcc1)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="174" y1="102" x2="166" y2="128" stroke="url(#goldAcc1)" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M 130 120 A 45 45 0 0 1 210 120" stroke="url(#goldAcc1)" stroke-width="3" stroke-linecap="round" stroke-dasharray="70 120"/>
            <rect x="132" y="166" width="76" height="18" rx="9" fill="rgba(7, 59, 66, 0.55)" stroke="rgba(0, 201, 193, 0.4)"/>
            <text x="170" y="178.5" fill="#39E0D5" font-size="7.5" font-family="monospace" font-weight="700" text-anchor="middle">&lt; 0.4s NATIVE</text>
          </svg>
        </div>
        <div class="accountability-card-body">
          <h4 class="accountability-card-title">Framework-Free Speed</h4>
          <p class="accountability-card-desc">
            Clean PHP 8+ and Vanilla JavaScript eliminating megabytes of third-party bloat, delivering sub-second global response times.
          </p>
          <div class="accountability-card-footer">
            <span class="accountability-micro-badge">Vanilla Stack</span>
            <div class="accountability-arrow-btn" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </div>
          </div>
          <div class="accountability-card-bottom-accent"></div>
        </div>
      </article>

      <!-- Card 02: Ironclad Security -->
      <article class="accountability-card">
        <div class="accountability-card-visual">
          <div class="visual-tag">ZERO-TRUST SEC</div>
          <div class="visual-number">02</div>
          <svg class="visual-artwork" viewBox="0 0 340 195" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
              <radialGradient id="cardGlow2" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#073B42" stop-opacity="0.45"/>
                <stop offset="100%" stop-color="#0A1D35" stop-opacity="0"/>
              </radialGradient>
              <linearGradient id="goldAcc2" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#39E0D5"/>
                <stop offset="100%" stop-color="#00C9C1"/>
              </linearGradient>
            </defs>
            <rect width="340" height="195" fill="url(#cardGlow2)"/>
            <circle cx="170" cy="115" r="60" stroke="rgba(0, 201, 193, 0.2)" stroke-width="1"/>
            <circle cx="170" cy="115" r="44" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.2" stroke-dasharray="3 3"/>
            <line x1="170" y1="45" x2="170" y2="185" stroke="rgba(0, 201, 193, 0.2)" stroke-width="1" stroke-dasharray="2 4"/>
            <line x1="100" y1="115" x2="240" y2="115" stroke="rgba(0, 201, 193, 0.2)" stroke-width="1" stroke-dasharray="2 4"/>
            <circle cx="108" cy="115" r="9" fill="#071A2C" stroke="rgba(0, 201, 193, 0.7)" stroke-width="1.5"/>
            <path d="M105 115 l2 2 l4 -4" stroke="#00C9C1" stroke-width="1.5" fill="none" stroke-linecap="round"/>
            <circle cx="232" cy="115" r="9" fill="#071A2C" stroke="rgba(0, 201, 193, 0.7)" stroke-width="1.5"/>
            <path d="M229 115 l2 2 l4 -4" stroke="#00C9C1" stroke-width="1.5" fill="none" stroke-linecap="round"/>
            <path d="M170 82 L196 93 V120 C196 137 170 148 170 148 C170 148 144 137 144 120 V93 Z" fill="#071A2C" stroke="url(#goldAcc2)" stroke-width="2.2" stroke-linejoin="round"/>
            <rect x="162" y="112" width="16" height="14" rx="3" fill="url(#goldAcc2)"/>
            <path d="M165 112 V106 a5 5 0 0 1 10 0 v6" fill="none" stroke="url(#goldAcc2)" stroke-width="2.2" stroke-linecap="round"/>
            <circle cx="170" cy="118" r="1.8" fill="#071A2C"/>
            <line x1="170" y1="119.5" x2="170" y2="123" stroke="#071A2C" stroke-width="1.5" stroke-linecap="round"/>
            <rect x="122" y="166" width="96" height="18" rx="9" fill="rgba(7, 59, 66, 0.55)" stroke="rgba(0, 201, 193, 0.4)"/>
            <text x="170" y="178.5" fill="#39E0D5" font-size="7.5" font-family="monospace" font-weight="700" text-anchor="middle">CSRF // RATE-LIMITED</text>
          </svg>
        </div>
        <div class="accountability-card-body">
          <h4 class="accountability-card-title">Ironclad Security</h4>
          <p class="accountability-card-desc">
            Strict parameter binding, CSRF/SSRF prevention, brute-force rate limits, and secure headers protecting your enterprise data.
          </p>
          <div class="accountability-card-footer">
            <span class="accountability-micro-badge">Enterprise Defense</span>
            <div class="accountability-arrow-btn" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </div>
          </div>
          <div class="accountability-card-bottom-accent"></div>
        </div>
      </article>

      <!-- Card 03: Zero Ad Waste Guarantee -->
      <article class="accountability-card">
        <div class="accountability-card-visual">
          <div class="visual-tag">VERIFIED MARGINS</div>
          <div class="visual-number">03</div>
          <svg class="visual-artwork" viewBox="0 0 340 195" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
              <radialGradient id="cardGlow3" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#073B42" stop-opacity="0.45"/>
                <stop offset="100%" stop-color="#0A1D35" stop-opacity="0"/>
              </radialGradient>
              <linearGradient id="goldAcc3" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#39E0D5"/>
                <stop offset="100%" stop-color="#00C9C1"/>
              </linearGradient>
              <linearGradient id="chartGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#00C9C1" stop-opacity="0.35"/>
                <stop offset="100%" stop-color="#073B42" stop-opacity="0.05"/>
              </linearGradient>
            </defs>
            <rect width="340" height="195" fill="url(#cardGlow3)"/>
            <line x1="30" y1="85" x2="310" y2="85" stroke="rgba(0, 201, 193, 0.18)" stroke-width="1"/>
            <line x1="30" y1="120" x2="310" y2="120" stroke="rgba(0, 201, 193, 0.18)" stroke-width="1"/>
            <line x1="30" y1="150" x2="310" y2="150" stroke="rgba(0, 201, 193, 0.25)" stroke-width="1"/>
            <rect x="55" y="125" width="14" height="25" rx="3" fill="#073B42" opacity="0.6"/>
            <rect x="85" y="110" width="14" height="40" rx="3" fill="#073B42" opacity="0.75"/>
            <rect x="115" y="92" width="14" height="58" rx="3" fill="#073B42" opacity="0.9"/>
            <rect x="210" y="80" width="14" height="70" rx="3" fill="#073B42" opacity="0.85"/>
            <rect x="240" y="65" width="14" height="85" rx="3" fill="url(#goldAcc3)"/>
            <rect x="270" y="52" width="14" height="98" rx="3" fill="url(#goldAcc3)"/>
            <path d="M 55 125 Q 115 105 160 88 T 280 48 L 280 150 L 55 150 Z" fill="url(#chartGrad)"/>
            <path d="M 55 125 Q 115 105 160 88 T 280 48" stroke="url(#goldAcc3)" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="165" cy="105" r="28" fill="#071A2C" stroke="url(#goldAcc3)" stroke-width="2"/>
            <path d="M165 91 v28 M172 96 h-10 a5 5 0 0 0 0 10 h7 a5 5 0 0 1 0 10 h-11" stroke="url(#goldAcc3)" stroke-width="2.8" stroke-linecap="round" fill="none"/>
            <rect x="125" y="166" width="90" height="18" rx="9" fill="rgba(7, 59, 66, 0.55)" stroke="rgba(0, 201, 193, 0.4)"/>
            <text x="170" y="178.5" fill="#39E0D5" font-size="7.5" font-family="monospace" font-weight="700" text-anchor="middle">ROAS OPTIMIZED</text>
          </svg>
        </div>
        <div class="accountability-card-body">
          <h4 class="accountability-card-title">Zero Ad Waste Guarantee</h4>
          <p class="accountability-card-desc">
            Every dollar spent on Google, Meta, or Amazon is tied directly to verified revenue and protected bottom-line operating margins.
          </p>
          <div class="accountability-card-footer">
            <span class="accountability-micro-badge">Audited Capital</span>
            <div class="accountability-arrow-btn" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </div>
          </div>
          <div class="accountability-card-bottom-accent"></div>
        </div>
      </article>

      <!-- Card 04: Dedicated Tech Leads -->
      <article class="accountability-card">
        <div class="accountability-card-visual">
          <div class="visual-tag">LEAD ARCHITECTS</div>
          <div class="visual-number">04</div>
          <svg class="visual-artwork" viewBox="0 0 340 195" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <defs>
              <radialGradient id="cardGlow4" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#073B42" stop-opacity="0.45"/>
                <stop offset="100%" stop-color="#0A1D35" stop-opacity="0"/>
              </radialGradient>
              <linearGradient id="goldAcc4" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#39E0D5"/>
                <stop offset="100%" stop-color="#00C9C1"/>
              </linearGradient>
            </defs>
            <rect width="340" height="195" fill="url(#cardGlow4)"/>
            <line x1="80" y1="140" x2="170" y2="90" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.5" stroke-dasharray="3 3"/>
            <line x1="260" y1="140" x2="170" y2="90" stroke="rgba(0, 201, 193, 0.35)" stroke-width="1.5" stroke-dasharray="3 3"/>
            <line x1="170" y1="90" x2="170" y2="45" stroke="rgba(57, 224, 213, 0.4)" stroke-width="1.5"/>
            <rect x="65" y="130" width="30" height="20" rx="4" fill="#071A2C" stroke="rgba(0, 201, 193, 0.5)" stroke-width="1.2"/>
            <circle cx="80" cy="140" r="3" fill="#39E0D5"/>
            <rect x="245" y="130" width="30" height="20" rx="4" fill="#071A2C" stroke="rgba(0, 201, 193, 0.5)" stroke-width="1.2"/>
            <circle cx="260" cy="140" r="3" fill="#39E0D5"/>
            <circle cx="170" cy="105" r="34" fill="#071A2C" stroke="url(#goldAcc4)" stroke-width="2"/>
            <path d="M158 91 L164 96 L170 88 L176 96 L182 91 L180 100 H160 Z" fill="url(#goldAcc4)"/>
            <circle cx="170" cy="107" r="7" stroke="url(#goldAcc4)" stroke-width="2" fill="none"/>
            <path d="M157 125 C157 117 163 115 170 115 C177 115 183 117 183 125" stroke="url(#goldAcc4)" stroke-width="2" fill="none" stroke-linecap="round"/>
            <rect x="122" y="166" width="96" height="18" rx="9" fill="rgba(7, 59, 66, 0.55)" stroke="rgba(0, 201, 193, 0.4)"/>
            <text x="170" y="178.5" fill="#39E0D5" font-size="7.5" font-family="monospace" font-weight="700" text-anchor="middle">NO ACCOUNT JUNIORS</text>
          </svg>
        </div>
        <div class="accountability-card-body">
          <h4 class="accountability-card-title">Dedicated Tech Leads</h4>
          <p class="accountability-card-desc">
            Direct communication with senior engineers and strategists—no junior account managers or offshore communication layers.
          </p>
          <div class="accountability-card-footer">
            <span class="accountability-micro-badge">Principal Architects</span>
            <div class="accountability-arrow-btn" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </div>
          </div>
          <div class="accountability-card-bottom-accent"></div>
        </div>
      </article>

    </div>

    <!-- Decorative Connector Line & Markers -->
    <div class="accountability-connector-strip" aria-hidden="true">
      <div class="connector-marker">
        <span class="marker-dot"></span>
        <span class="marker-label"><span class="marker-num">01 //</span> High-Velocity SLA</span>
      </div>
      <div class="connector-marker">
        <span class="marker-dot"></span>
        <span class="marker-label"><span class="marker-num">02 //</span> Enterprise Defense</span>
      </div>
      <div class="connector-marker">
        <span class="marker-dot"></span>
        <span class="marker-label"><span class="marker-num">03 //</span> Audited Capital</span>
      </div>
      <div class="connector-marker">
        <span class="marker-dot"></span>
        <span class="marker-label"><span class="marker-num">04 //</span> Strategic Direction</span>
      </div>
    </div>

  </div>
</section>

<!-- ============================================================
     7. NEW REAL RESULTS (CASE STUDIES & PERFORMANCE METRICS)
     ============================================================ -->
<section class="section real-results-section" id="realResultsSection">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>PROOF OF WORK</span>
      </div>
      <h2 class="section-title">Real Results. Real Business Impact.</h2>
      <p class="lead" style="max-width: 760px; margin: 0 auto;">
        Explore how BusinessDoctor combines engineering, marketing and digital strategy to solve business challenges and deliver measurable outcomes.
      </p>
    </div>

    <div class="results-cards-grid">
      <?php if (!empty($featuredCases)): ?>
        <?php foreach ($featuredCases as $case): ?>
          <article class="result-card">
            <!-- 1. Industry Badge & 2. Client/Project Title -->
            <div class="result-card-header">
              <span class="result-industry-badge"><?= e($case['client_industry']) ?></span>
              <h3 class="result-card-title"><?= e($case['title']) ?></h3>
            </div>

            <div class="result-card-body">
              <!-- 3. Business Challenge -->
              <div class="result-meta-block">
                <div class="result-meta-label">Business Challenge</div>
                <p class="result-card-text"><?= e($case['challenge']) ?></p>
              </div>

              <!-- 4. Solution Delivered -->
              <div class="result-meta-block">
                <div class="result-meta-label">Solution Delivered</div>
                <p class="result-card-text"><?= e($case['prescription']) ?></p>
              </div>

              <!-- 5. Performance Metrics -->
              <div class="result-metric-banner">
                <div class="result-metric-label"><?= e($case['metric_label']) ?></div>
                <div class="result-outcome-stat"><?= e($case['outcome_metric']) ?></div>
                <div class="result-baseline-stat">Baseline: <?= e($case['baseline_metric']) ?></div>
              </div>

              <!-- 6. Short Outcome Summary -->
              <div class="result-meta-block">
                <div class="result-meta-label">Outcome Verified</div>
                <p class="result-outcome-summary"><?= e($case['result_description']) ?></p>
              </div>
            </div>

            <!-- 7. View Case Study Link -->
            <div class="result-card-footer">
              <a href="case-study-detail.php?slug=<?= urlencode($case['slug']) ?>" class="result-card-action">
                <span>View Full Case Study</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12"/>
                  <polyline points="12 5 19 12 12 19"/>
                </svg>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 3.5rem;">
      <a href="case-studies.php" class="btn btn-secondary btn-lg">
        <span>Explore All Case Studies</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     8. NEW TOOLS WE USE (TECHNOLOGY & MARKETING PLATFORMS)
     ============================================================ -->
<section class="section tools-section" id="toolsSection">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR TECHNOLOGY STACK</span>
      </div>
      <h2 class="section-title">Tools That Power Our Work.</h2>
      <p class="lead" style="max-width: 760px; margin: 0 auto;">
        We use trusted platforms and professional tools to build, manage, analyze and optimize digital experiences.
      </p>
    </div>

    <!-- Category Filter Tabs -->
    <div class="tools-filter-strip" role="tablist" aria-label="Tool Categories">
      <button type="button" class="tool-filter-btn active" data-filter="all">All Platforms (14)</button>
      <button type="button" class="tool-filter-btn" data-filter="advertising">Advertising &amp; Performance</button>
      <button type="button" class="tool-filter-btn" data-filter="analytics">Analytics &amp; SEO</button>
      <button type="button" class="tool-filter-btn" data-filter="design">Design &amp; Creative</button>
      <button type="button" class="tool-filter-btn" data-filter="web">Web &amp; Commerce</button>
      <button type="button" class="tool-filter-btn" data-filter="crm">CRM &amp; Automation</button>
    </div>

    <!-- 14 Confirmed Tool Cards -->
    <div class="tools-grid">
      <!-- 1. Google Ads -->
      <div class="tool-card" data-category="advertising">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          </div>
          <span class="tool-category-badge">Advertising</span>
        </div>
        <h4 class="tool-name">Google Ads</h4>
        <p class="tool-purpose">Search, Performance Max &amp; YouTube campaigns optimized for qualified acquisition.</p>
      </div>

      <!-- 2. Meta Ads -->
      <div class="tool-card" data-category="advertising">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>
          </div>
          <span class="tool-category-badge">Advertising</span>
        </div>
        <h4 class="tool-name">Meta Ads</h4>
        <p class="tool-purpose">Facebook &amp; Instagram targeted demographic reach and conversion retargeting.</p>
      </div>

      <!-- 3. LinkedIn Ads -->
      <div class="tool-card" data-category="advertising">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </div>
          <span class="tool-category-badge">Advertising</span>
        </div>
        <h4 class="tool-name">LinkedIn Ads</h4>
        <p class="tool-purpose">B2B enterprise account-based marketing (ABM) and decision-maker lead generation.</p>
      </div>

      <!-- 4. Google Analytics 4 -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          </div>
          <span class="tool-category-badge">Analytics</span>
        </div>
        <h4 class="tool-name">Google Analytics 4</h4>
        <p class="tool-purpose">Event-driven behavioral telemetry, multi-touch attribution, and conversion funnels.</p>
      </div>

      <!-- 5. Google Search Console -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
          <span class="tool-category-badge">Analytics</span>
        </div>
        <h4 class="tool-name">Google Search Console</h4>
        <p class="tool-purpose">Organic indexing health, crawl optimization, and search query performance monitoring.</p>
      </div>

      <!-- 6. SEMrush -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <span class="tool-category-badge">SEO</span>
        </div>
        <h4 class="tool-name">SEMrush</h4>
        <p class="tool-purpose">Competitor intelligence, paid search gap analysis, and keyword search intent modeling.</p>
      </div>

      <!-- 7. Ahrefs -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
          </div>
          <span class="tool-category-badge">SEO</span>
        </div>
        <h4 class="tool-name">Ahrefs</h4>
        <p class="tool-purpose">Enterprise backlink audits, domain authority benchmarking, and technical site crawling.</p>
      </div>

      <!-- 8. Figma -->
      <div class="tool-card" data-category="design">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
          </div>
          <span class="tool-category-badge">Design</span>
        </div>
        <h4 class="tool-name">Figma</h4>
        <p class="tool-purpose">Collaborative UI/UX wireframing, component design systems, and rapid prototyping.</p>
      </div>

      <!-- 9. Canva -->
      <div class="tool-card" data-category="design">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0z"/></svg>
          </div>
          <span class="tool-category-badge">Design</span>
        </div>
        <h4 class="tool-name">Canva</h4>
        <p class="tool-purpose">Rapid marketing collateral, social creative variations, and brand template libraries.</p>
      </div>

      <!-- 10. Adobe Creative Cloud -->
      <div class="tool-card" data-category="design">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
          <span class="tool-category-badge">Design</span>
        </div>
        <h4 class="tool-name">Adobe Creative Cloud</h4>
        <p class="tool-purpose">Professional studio photo retouching, vector brand identities, and motion graphics.</p>
      </div>

      <!-- 11. WordPress -->
      <div class="tool-card" data-category="web">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          </div>
          <span class="tool-category-badge">Web &amp; CMS</span>
        </div>
        <h4 class="tool-name">WordPress</h4>
        <p class="tool-purpose">Editorial publication systems, content portals, and headless CMS architectures.</p>
      </div>

      <!-- 12. Shopify -->
      <div class="tool-card" data-category="web">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          </div>
          <span class="tool-category-badge">Commerce</span>
        </div>
        <h4 class="tool-name">Shopify</h4>
        <p class="tool-purpose">High-converting D2C storefronts, streamlined checkout funnels, and app integrations.</p>
      </div>

      <!-- 13. HubSpot -->
      <div class="tool-card" data-category="crm">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <span class="tool-category-badge">CRM</span>
        </div>
        <h4 class="tool-name">HubSpot</h4>
        <p class="tool-purpose">Inbound marketing automation, enterprise CRM pipelines, and lead scoring logic.</p>
      </div>

      <!-- 14. Mailchimp -->
      <div class="tool-card" data-category="crm">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <span class="tool-category-badge">Automation</span>
        </div>
        <h4 class="tool-name">Mailchimp</h4>
        <p class="tool-purpose">Lifecycle email marketing, automated cart recovery, and subscriber segmentation.</p>
      </div>
    </div>

    <div class="tools-disclaimer">
      <span>All platform names and trademarks are property of their respective owners. BusinessDoctor deploys these industry-standard technologies across client engagements.</span>
    </div>
  </div>
</section>

<!-- ============================================================
     9. INSIGHTS & PERSPECTIVES EDITORIAL
     ============================================================ -->
<section class="section" id="insightsSection" style="background: var(--color-bg); border-top: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>PERSPECTIVES &amp; INSIGHTS</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2rem, 3.5vw, 3rem);">Engineering Architecture &amp; Digital Growth Analysis</h2>
      <p class="lead">
        Executive perspectives on custom web application architecture, Core Web Vitals optimization, paid media strategy, and e-commerce scaling.
      </p>
    </div>

    <div class="insights-editorial-grid">
      <?php if (!empty($insightsList)): ?>
        <?php $leadPost = $insightsList[0]; $subPosts = array_slice($insightsList, 1); ?>
        
        <!-- Lead Featured Article -->
        <article class="insight-lead-card">
          <div>
            <div class="insight-meta-strip">
              <span class="insight-category-badge"><?= e($leadPost['category']) ?></span>
              <span>•</span>
              <span><?= e($leadPost['reading_time']) ?></span>
            </div>
            <h3 class="insight-lead-title"><?= e($leadPost['title']) ?></h3>
            <p class="insight-lead-summary"><?= e($leadPost['summary']) ?></p>
          </div>

          <div>
            <div class="insight-author-bar">
              <div class="insight-author-info">
                <div class="insight-author-name"><?= e($leadPost['author_name']) ?></div>
                <div class="insight-author-title"><?= e($leadPost['author_title']) ?></div>
              </div>
              <a href="insight-detail.php?slug=<?= urlencode($leadPost['slug']) ?>" class="btn btn-primary btn-sm">
                <span>Read Analysis</span>
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12"/>
                  <polyline points="12 5 19 12 12 19"/>
                </svg>
              </a>
            </div>
          </div>
        </article>

        <!-- Companion Articles Column -->
        <div class="insights-list-col">
          <?php foreach ($subPosts as $post): ?>
            <a href="insight-detail.php?slug=<?= urlencode($post['slug']) ?>" class="insight-compact-card">
              <div class="insight-meta-strip">
                <span class="insight-category-badge"><?= e($post['category']) ?></span>
                <span>•</span>
                <span><?= e($post['reading_time']) ?></span>
              </div>
              <h4 class="insight-compact-title"><?= e($post['title']) ?></h4>
              <p class="insight-compact-summary"><?= e($post['summary']) ?></p>
              <div class="insight-read-perspective" style="margin-top: 1.25rem; font-family: var(--font-display); font-size: 0.88rem; font-weight: 700; color: #00C9C1; display: flex; align-items: center; gap: 0.35rem;">
                <span>Read Perspective</span>
                <span>&rarr;</span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted text-center" style="grid-column: 1 / -1;">No published insights currently available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     8. FINAL CLOSING ENTERPRISE CTA
     ============================================================ -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <div class="eyebrow-badge dark" style="margin-bottom: 1.25rem;">
          <span class="pill-dot"></span>
          <span>ACCELERATE YOUR ROADMAP</span>
        </div>
        <h2 class="closing-cta-title">Ready to Move Your Business Beyond Limitations?</h2>
        <p class="closing-cta-lead">
          Whether you need a bespoke web application, high-ROI performance marketing campaigns, or comprehensive marketplace management, our senior technical teams are ready to execute.
        </p>

        <div class="closing-cta-buttons">
          <a href="contact.php" class="btn btn-accent btn-lg">
            <span>Start an Enterprise Project</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="audit.php" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     FIXED FLOATING CONTACT ICONS (HOMEPAGE ONLY)
     ============================================================ -->
<aside class="floating-contact-widget" aria-label="Quick Contact Channels" style="position: fixed; bottom: max(24px, env(safe-area-inset-bottom, 24px)); right: max(24px, env(safe-area-inset-right, 24px)); z-index: 990; display: flex; flex-direction: column; gap: 12px; pointer-events: none;">

  <!-- Direct Call Floating Action -->
  <a href="tel:<?= htmlspecialchars(APP_CALL_NUMBER) ?>" 
     class="floating-contact-btn floating-call-btn" 
     aria-label="Call BusinessDoctor at <?= htmlspecialchars(APP_PHONE) ?>"
     title="Call BusinessDoctor (<?= htmlspecialchars(APP_PHONE) ?>)"
     style="pointer-events: auto; width: 52px; height: 52px; border-radius: 50%; background: #00C9C1; color: #061326; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 18px rgba(0, 201, 193, 0.45); transition: transform 0.2s ease, box-shadow 0.2s ease; text-decoration: none;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
    </svg>
  </a>

  <!-- WhatsApp Floating Action -->
  <a href="https://wa.me/<?= htmlspecialchars(APP_WHATSAPP_NUMBER) ?>?text=<?= urlencode(APP_WHATSAPP_MESSAGE) ?>" 
     target="_blank" 
     rel="noopener noreferrer" 
     class="floating-contact-btn floating-wa-btn" 
     aria-label="Chat with BusinessDoctor on WhatsApp"
     title="Chat on WhatsApp"
     style="pointer-events: auto; width: 52px; height: 52px; border-radius: 50%; background: #25D366; color: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 18px rgba(37, 211, 102, 0.45); transition: transform 0.2s ease, box-shadow 0.2s ease; text-decoration: none;">
    <svg width="25" height="25" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.71C8.02 10.94 8.91 12.13 9.03 12.29C9.15 12.46 10.8 15.01 13.32 16.1C13.92 16.36 14.39 16.51 14.75 16.63C15.35 16.82 15.9 16.79 16.34 16.73C16.82 16.66 17.82 16.12 18.03 15.54C18.24 14.95 18.24 14.45 18.18 14.35C18.12 14.24 17.95 14.18 17.7 14.05C17.44 13.93 16.19 13.31 15.96 13.23C15.73 13.14 15.56 13.1 15.4 13.35C15.23 13.6 14.76 14.18 14.61 14.35C14.46 14.52 14.31 14.54 14.06 14.42C13.8 14.29 13 14.03 12.04 13.17C11.3 12.5 10.79 11.68 10.65 11.43C10.5 11.18 10.63 11.04 10.76 10.92C10.88 10.8 11.02 10.61 11.16 10.45C11.3 10.28 11.34 10.16 11.43 9.99C11.51 9.83 11.47 9.68 11.41 9.56C11.34 9.44 10.85 8.24 10.64 7.74C10.44 7.26 10.24 7.32 10.09 7.32C9.94 7.32 9.77 7.34 9.53 7.34Z"/>
    </svg>
  </a>
</aside>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
