<?php
/**
 * BusinessDoctor Homepage - Enterprise IT Solutions & Digital Services
 * Design Reference: Accenture Digital Experience Standard (Independent Brand Identity)
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// Local development / built-in server fallback routing
$reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
if ($reqPath !== null) {
  if ($reqPath === '/company-in-delhi' || $reqPath === '/company-in-delhi/') {
    require __DIR__ . '/services.php';
    exit;
  }
  if (preg_match('#^/([a-zA-Z0-9_-]+)-company-in-delhi/?$#', $reqPath, $sm)) {
    $_GET['slug'] = $sm[1];
    require __DIR__ . '/service-detail.php';
    exit;
  }
  if ($reqPath === '/blog' || $reqPath === '/blog/') {
    require __DIR__ . '/insights.php';
    exit;
  }
  if (preg_match('#^/blog/([a-zA-Z0-9_-]+)/?$#', $reqPath, $sm)) {
    $_GET['slug'] = $sm[1];
    require __DIR__ . '/insight-detail.php';
    exit;
  }
  if (preg_match('#^/company/([a-zA-Z0-9_-]+)/?$#', $reqPath, $sm)) {
    header("Location: " . getServiceUrl($sm[1]), true, 301);
    exit;
  }
  if (preg_match('#^/services/([a-zA-Z0-9_-]+)/?$#', $reqPath, $sm)) {
    header("Location: " . getServiceUrl($sm[1]), true, 301);
    exit;
  }
  if ($reqPath === '/services' || $reqPath === '/services/' || $reqPath === '/company' || $reqPath === '/company/') {
    header("Location: " . getServicesOverviewUrl(), true, 301);
    exit;
  }
  if ($reqPath === '/insights' || $reqPath === '/insights/' || $reqPath === '/insights.php') {
    header("Location: " . getBlogListingUrl(), true, 301);
    exit;
  }
}

$pageTitle = 'BusinessDoctor — Enterprise IT Solutions & Digital Growth Firm';
$pageDescription = 'BusinessDoctor engineers custom web and software applications, executes high-ROI performance marketing, designs distinctive brand systems, and scales enterprise e-commerce.';

$featuredCases = [];
try {
  $pdo = Database::getConnection();
  $stmt = $pdo->query("SELECT * FROM case_studies WHERE is_featured = 1 AND status = 'published' AND is_deleted = 0 ORDER BY sort_order ASC, id DESC LIMIT 3");
  $featuredCases = $stmt->fetchAll();
} catch (Exception $e) {
}

$insightsList = [];
try {
  $pdo = Database::getConnection();
  $stmt = $pdo->query("SELECT * FROM insights WHERE status = 'published' AND is_deleted = 0 ORDER BY published_at DESC, id DESC LIMIT 3");
  $insightsList = $stmt->fetchAll();
} catch (Exception $e) {
}

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
              Is Your Digital Presence Underperforming?
              <span class="text-gradient-pine">You need the best digital marketing company for Business Growth.</span>
            </h1>

            <p class="hero-lead-text">
              Every business needs the right diagnosis to grow, and here Business Doctor is to diagnose your business !!
              We are the Best digital marketing company in Delhi that works according to what you need and what your
              business needs.
            </p>

            <div class="hero-actions-group">
              <a href="#capabilities" class="btn btn-accent btn-lg">
                <span>Explore Our Capabilities</span>
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="5" y1="12" x2="19" y2="12" />
                  <polyline points="12 5 19 12 12 19" />
                </svg>
              </a>
              <a href="/contact" class="btn btn-secondary btn-lg">
                <span>Start a Project</span>
              </a>
            </div>

            <div class="hero-trust-strip">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="20 6 9 17 4 12" />
              </svg>
              <span>FULL-CYCLE IT SERVICES // 100% TRANSPARENT ROADMAPS // DEDICATED TECH LEADS</span>
            </div>
          </div>

          <!-- Layer B: Mid-Scroll Progressive Reveal Layer -->
          <div class="hero-revealed-layer" id="heroRevealedLayer">
            <div class="revealed-eyebrow">
              <span class="pill-dot" style="background-color: var(--color-accent);"></span>
              <span>full-service digital marketing company </span>
            </div>
            <h2 class="revealed-headline">
              Your business needs the right prescription

            </h2>
            <p class="revealed-desc">
              We are a top digital marketing company in Delhi that provides all the digital services that your business
              needs on a single platform. We plan everything from scratch according to your needs.

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
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>FEATURED CAPABILITIES</span>
      </div>
      <h2 class="section-title">
        Digital Marketing Services in Delhi <span class="text-gradient-pine">Designed to Grow Your Business</span>
      </h2>
      <p class="lead">
        Business Doctor is a full-service digital marketing company in Delhi NCR that provides you with the best digital
        marketing services, from web development, digital marketing and e-commerce management to cloud solutions. Our
        team provides you with suitable personalization strategies that help you to grow.
      </p>
    </div>

    <?php
    $featuredCapabilities = [
      'seo' => [
        'number' => '01',
        'name' => 'SEO Services in Delhi',
        'description' => 'Full-spectrum search engine optimization designed to dominate high-intent keywords, fix technical bottlenecks, and drive sustainable organic revenue for your business.',
        'features' => [
          'Technical SEO Audits & Core Web Vitals Optimization',
          'High-Intent Keyword Strategy & Commercial Mapping',
          'On-Page & Long-Form Content Architecture',
          'Authoritative White-Hat Link Acquisition',
          'Local Delhi NCR & Map Pack 3-Pack Ranking',
        ],
        'url' => getServiceUrl('seo'),
      ],
      'ppc-paid-ads' => [
        'number' => '02',
        'name' => 'PPC Company in Delhi',
        'description' => 'Data-driven performance advertising across Google Ads, Meta Ads, and LinkedIn to maximize pipeline ROAS and eliminate wasted ad spend.',
        'features' => [
          'Google Search & Performance Max Campaigns',
          'Meta (Instagram & Facebook) High-ROAS Funnels',
          'Negative Keyword Sculpting & Budget Protection',
          'First-Party Conversion Tracking & Pixel Setup',
          'Continuous Creative Testing & Data-Driven Scaling',
        ],
        'url' => getServiceUrl('ppc-paid-ads'),
      ],
      'web-development' => [
        'number' => '03',
        'name' => 'Web Development Company in Delhi',
        'description' => 'Custom full-stack web applications, headless commerce storefronts, and enterprise corporate portals engineered for sub-second speeds, security, and high conversions.',
        'features' => [
          'Custom Full-Stack Web Development from Scratch',
          'Ultra-Fast Performance & Sub-Second TTFB',
          'Mobile-First Responsive UI/UX Architecture',
          'REST & GraphQL API Integrations',
          'Enterprise OWASP Security Hardening',
        ],
        'url' => getServiceUrl('web-development'),
      ],
      'social-media-marketing' => [
        'number' => '04',
        'name' => 'Social Media Marketing Company in Delhi',
        'description' => 'High-impact organic and paid social media marketing campaigns across Instagram, LinkedIn, and Facebook designed to build brand authority and generate qualified leads.',
        'features' => [
          'Strategic Social Content Calendar & Brand Voice',
          'High-Engagement Reel & Story Creative Production',
          'Targeted Audience Growth & Community Building',
          'Paid Social Acquisition & Retargeting Funnels',
          'Real-Time Telemetry & Transparent Reporting',
        ],
        'url' => getServiceUrl('social-media-marketing'),
      ],
      'smo' => [
        'number' => '05',
        'name' => 'SMO Company in Delhi',
        'description' => 'Comprehensive social media optimization enhancing brand presence, profile authority, and organic discoverability across all major digital channels.',
        'features' => [
          'Complete Profile & Bio Search Architecture',
          'Hashtag & Keyword Discovery Optimization',
          'Cross-Platform Visual & Voice Consistency',
          'Reputation Management & Social Trust Signals',
          'Viral Community Engagement Strategies',
        ],
        'url' => getServiceUrl('smo'),
      ],
      'ecommerce-management' => [
        'number' => '06',
        'name' => 'E-Commerce Management Company in Delhi',
        'description' => 'End-to-end multi-channel marketplace management, catalog synchronization, and storefront revenue optimization across Amazon, Flipkart, Shopify, and Meesho.',
        'features' => [
          'Amazon & Flipkart Full Account Management',
          'Multi-Channel Inventory & Order Synchronization',
          'A+ Content & High-Converting Storefronts',
          'Buy Box Defense & Margin-Safe Algorithmic Repricing',
          'Marketplace Sponsored Ads Optimization',
        ],
        'url' => getServiceUrl('ecommerce-management'),
      ],
      'google-business-profile' => [
        'number' => '07',
        'name' => 'Google Business Profile Company in Delhi',
        'description' => 'Local SEO and Google Maps 3-pack dominance to capture nearby customers searching with immediate purchase and visit intent.',
        'features' => [
          'Google Maps 3-Pack Ranking & Proximity Strategy',
          'Profile Verification & High-Relevance Categorization',
          'Customer Review Acquisition & Review Management',
          'Local Citation Consistency & NAP Uniformity',
          'Google Posts, Offers & Product Catalog Sync',
        ],
        'url' => getServiceUrl('google-business-profile'),
      ],
      'graphic-design' => [
        'number' => '08',
        'name' => 'Graphic Design Company in Delhi',
        'description' => 'Bespoke corporate identity, marketing collateral, brand guidelines, and high-impact visual design that makes your business memorable.',
        'features' => [
          'Logo & Complete Corporate Brand Guidelines',
          'Marketing Collateral & Pitch Deck Design',
          'Social Media Creatives & Ad Banner Kits',
          'Packaging, Print & Digital-Ready Asset Formats',
          'Custom Vector Illustrations & Visual Elements',
        ],
        'url' => getServiceUrl('graphic-design'),
      ],
      'video-editing' => [
        'number' => '09',
        'name' => 'Video Editing Company in Delhi',
        'description' => 'High-retention social media reels, product demonstration videos, corporate brand films, and motion graphics that turn viewers into paying customers.',
        'features' => [
          'High-Retention Instagram Reels & YouTube Shorts',
          'Commercial Product & Explainer Video Editing',
          'Custom Motion Graphics & Kinetic Typography',
          'Sound Design, Mixing & Vocal Mastering',
          'Multi-Platform Aspect Ratios (9:16, 16:9, 1:1)',
        ],
        'url' => getServiceUrl('video-editing'),
      ],
      'product-photography' => [
        'number' => '10',
        'name' => 'Product Photography Company in Delhi',
        'description' => '61MP commercial studio product photography adhering strictly to Amazon, Flipkart, and premium luxury e-commerce catalog specifications.',
        'features' => [
          '61MP High-Resolution Commercial Studio Captures',
          'Pure White RGB 255 Marketplace-Compliant Standards',
          'Creative Lifestyle & In-Context Model Staging',
          '360° Interactive Product Spin Photography',
          'High-End Retouching & Color Fidelity Matching',
        ],
        'url' => getServiceUrl('product-photography'),
      ],
    ];
    ?>

    <div class="capabilities-explorer">
      <!-- Capability Navigation Tabs with Horizontal Scroll Controls -->
      <div class="capabilities-nav-wrapper">
        <button type="button" class="cap-nav-arrow cap-nav-prev is-hidden" id="capNavPrev"
          aria-label="Scroll left to view previous service tabs" title="Previous service tabs" tabindex="0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>

        <div class="capabilities-nav-bar" id="capabilitiesNavBar" role="tablist" aria-label="Capabilities Navigation">
          <?php $idx = 0;
          foreach ($featuredCapabilities as $slug => $p):
            $idx++; ?>
            <button type="button" class="cap-tab-btn <?= $idx === 1 ? 'active' : '' ?>"
              data-target="cap-pane-<?= e($slug) ?>" role="tab" aria-selected="<?= $idx === 1 ? 'true' : 'false' ?>">
              <span class="cap-tab-num"><?= e($p['number']) ?>.</span>
              <span><?= e($p['name']) ?></span>
            </button>
          <?php endforeach; ?>
        </div>

        <button type="button" class="cap-nav-arrow cap-nav-next" id="capNavNext"
          aria-label="Scroll right to view more service tabs" title="More service tabs" tabindex="0">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </button>
      </div>

      <!-- Capability Tab Panes -->
      <?php $idx = 0;
      foreach ($featuredCapabilities as $slug => $p):
        $idx++; ?>
        <div class="cap-tab-pane <?= $idx === 1 ? 'active' : '' ?>" id="cap-pane-<?= e($slug) ?>" role="tabpanel">
          <div class="capability-editorial-card">
            <!-- Left Editorial Details -->
            <div class="cap-card-body">
              <div>
                <div class="cap-card-eyebrow">
                  <span>DISCIPLINE <?= e($p['number']) ?></span>
                  <span>•</span>
                  <span><?= e($p['name']) ?></span>
                </div>
                <h3 class="cap-card-title"><?= e($p['name']) ?></h3>
                <p class="cap-card-desc"><?= e($p['description']) ?></p>

                <div class="cap-deliverables-list">
                  <div
                    style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.25rem;">
                    CORE DELIVERABLES &amp; EXECUTION:
                  </div>
                  <?php foreach ($p['features'] as $feat): ?>
                    <div class="cap-deliverable-item">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                      </svg>
                      <span><?= e($feat) ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <div>
                <a href="<?= e($p['url']) ?>" class="btn btn-primary">
                  <span>Explore Full <?= e($p['name']) ?> Roadmap</span>
                  <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                  </svg>
                </a>
              </div>
            </div>

            <!-- Right Strategic KPI Sidebar -->
            <div class="cap-card-sidebar">
              <div>
                <div class="cap-sidebar-kpi-block">
                  <div class="cap-sidebar-kpi-label">KEY SERVICE CAPABILITIES</div>
                  <div style="font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; color: #F4F8FC; line-height: 1.25; margin-top: 0.4rem;">
                    <?= e($p['name']) ?>
                  </div>
                </div>

                <div style="margin-top: 1.75rem;">
                  <div class="cap-sidebar-kpi-label">CORE SCOPE HIGHLIGHTS</div>
                  <div class="cap-sidebar-chips" style="margin-top: 0.75rem; display: flex; flex-direction: column; gap: 0.65rem;">
                    <?php foreach ($p['features'] as $feat): ?>
                      <div class="cap-sidebar-chip" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.55rem 0.85rem; font-size: 0.84rem; font-family: var(--font-sans); border-radius: 6px; background: rgba(6, 181, 249, 0.08); border: 1px solid rgba(6, 181, 249, 0.22); color: #F4F8FC;">
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #06B5F9; flex-shrink: 0;"></span>
                        <span><?= e($feat) ?></span>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>

              <div style="margin-top: 2.5rem; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 1.5rem;">
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.78); line-height: 1.5; margin-bottom: 1rem;">
                  Need an architectural evaluation or custom scope for <?= e($p['name']) ?>?
                </p>
                <a href="/contact" class="btn btn-accent btn-sm">
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
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>BUSINESS TRANSFORMATION</span>
      </div>
      <h2 class="section-title">
        A digital marketing company &amp; <span class="text-gradient-pine">that simplifies business growth</span>
      </h2>
      <p class="lead">
        In today's competitive world, every business faces challenges such as low online visibility, low leads and more.
        BusinessDoctor understands your business’s challenges and offers solutions that fit your needs. BusinessDoctor
        provides marketing services such as website development, software development, SEO, social media marketing,
        branding and cloud solutions.
      </p>
    </div>

    <div class="matrix-grid">
      <!-- Card A: Fragmented Vendors -->
      <div class="matrix-card symptom">
        <div class="matrix-header">
          <span class="matrix-badge">Fragmented Vendors &amp; Generic Agencies</span>
        </div>
        <h3>Common challenges that &amp;hold your business back </h3>
        <p style="font-size: 0.95rem; color: #cbd5e1; line-height: 1.6;">
          Nowadays, many businesses invest a lot in their website and digital marketing, but they are still unable to
          reach quality leads and customers. Due to a lack of proper planning and an effective strategy, marketing
          budgets get spent, but they can't meet business expectations.

        </p>

        <div class="matrix-list">
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <line x1="15" y1="9" x2="9" y2="15" />
              <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <span><strong> Low lead generation-</strong> Are you struggling to get potential
              customers? Everyone just visits your website, but you still don't get leads.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <line x1="15" y1="9" x2="9" y2="15" />
              <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <span><strong> Low Online Visibility -</strong> Are potential customers not finding your business online?
              Your website stays behind due to poor seo and a weak online presence on search engines.
            </span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <line x1="15" y1="9" x2="9" y2="15" />
              <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
            <span><strong>Poor Customer Engagement:</strong>Are people not interacting with your brand? Maybe due to low
              engagement, poor appearance and inconsistent content, your audience is losing interest in your
              brand.</span>
          </div>
        </div>
      </div>

      <!-- Card B: BusinessDoctor Solution -->
      <div class="matrix-card cure">
        <div class="matrix-header">
          <span class="matrix-badge">The BusinessDoctor Advantage</span>
        </div>
        <h3>Solution for &amp; better growth</h3>
        <p style="font-size: 0.95rem; color: rgba(255, 255, 255, 0.85); line-height: 1.6;">
          The BusinessDoctor understands your market problem, and we work according to what you need and what your
          business needs. We analyze your website, digital marketing and campaigns and make a strategy according to that
          so that you get quality leads and potential customers

        </p>

        <div class="matrix-list">
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
              <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span><strong>Lead generation - </strong>We use targeted marketing to reach the right audience and attract
              interested customers so that we can convert them into quality leads.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
              <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span><strong>Online visibility -</strong> We customize every strategy to improve your online visibility on
              Google search results and to reach potential customers through SEO and keyword optimisation.</span>
          </div>
          <div class="matrix-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
              <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <span><strong> Poor customer engagement-</strong>Our team posts interesting and engaging content regularly
              on social media to increase audience interaction with your business so that you get quality customers.
            </span>
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
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>BUSINESS IMPACT</span>
      </div>
      <h2 class="section-title">
        Why Businesses Choose BusinessDoctor as <span class="text-gradient-pine">Best Digital Marketing company in Delhi</span>
      </h2>
      <p class="lead">
        BusinessDoctor is a full-service digital marketing company. We believe that every business has the potential to
        grow and we provide them with complete business solutions like a strong online presence, quality lead
        generation, better brand visibility and more leads, which help them to grow their business better. Our goal is
        not just to grow your brand, our goal is to make your brand recognisable.
      </p>
    </div>

    <div class="benefits-layout-grid">
      <!-- Left Column: 6 Expandable Accordion Items -->
      <div class="benefits-accordion" role="region" aria-label="Business Impact Benefits">

        <!-- 01: Increase Brand Visibility -->
        <div class="benefits-accordion-item active" data-index="0">
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger0" aria-expanded="true"
            aria-controls="benefitPanel0">
            <span class="benefit-trigger-left">
              <span class="benefit-num">01</span>
              <span class="benefit-title">Increase Brand Visibility</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel0" role="region" aria-labelledby="benefitTrigger0">
            <p class="benefit-desc">
              We increase your brand visibility through better search engine optimization, keyword research and more.
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
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger1" aria-expanded="false"
            aria-controls="benefitPanel1">
            <span class="benefit-trigger-left">
              <span class="benefit-num">02</span>
              <span class="benefit-title">Drive Meaningful Engagement</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel1" role="region" aria-labelledby="benefitTrigger1">
            <p class="benefit-desc">
              We create content that not only engages but also makes a genuine connection with the audience.
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
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger2" aria-expanded="false"
            aria-controls="benefitPanel2">
            <span class="benefit-trigger-left">
              <span class="benefit-num">03</span>
              <span class="benefit-title">Improve Return on Investment</span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel2" role="region" aria-labelledby="benefitTrigger2">
            <p class="benefit-desc">
              Business Doctor generates a better return on investment by using an effective strategy, reducing
              unnecessary spending.
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
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger3" aria-expanded="false"
            aria-controls="benefitPanel3">
            <span class="benefit-trigger-left">
              <span class="benefit-num">04</span>
              <span class="benefit-title">Reaching the right audience </span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel3" role="region" aria-labelledby="benefitTrigger3">
            <p class="benefit-desc">
              Business Doctor connects your business with a quality audience that is actually interested in your product
              or service.
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
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger4" aria-expanded="false"
            aria-controls="benefitPanel4">
            <span class="benefit-trigger-left">
              <span class="benefit-num">05</span>
              <span class="benefit-title">Make Data-Driven Content </span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel4" role="region" aria-labelledby="benefitTrigger4">
            <p class="benefit-desc">
              Our team creates engaging content based on real data, audience behaviour and platform insights to get
              better results.
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
          <button type="button" class="benefits-accordion-trigger" id="benefitTrigger5" aria-expanded="false"
            aria-controls="benefitPanel5">
            <span class="benefit-trigger-left">
              <span class="benefit-num">06</span>
              <span class="benefit-title">Improve conversion rate </span>
            </span>
            <svg class="benefit-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <div class="benefits-accordion-panel" id="benefitPanel5" role="region" aria-labelledby="benefitTrigger5">
            <p class="benefit-desc">
              Business Doctor increases the number of conversions on your website, not just website visitors.
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
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg"
              aria-label="Horizontal Funnel: Total Reach to Brand Searches">
              <defs>
                <linearGradient id="hGrad1" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#0A223B" />
                  <stop offset="100%" stop-color="#06B5F9" />
                </linearGradient>
                <linearGradient id="hGrad2" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#06B5F9" />
                  <stop offset="100%" stop-color="#0099DB" />
                </linearGradient>
                <linearGradient id="hBridge" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#06B5F9" stop-opacity="0.12" />
                  <stop offset="100%" stop-color="#0A223B" stop-opacity="0.04" />
                </linearGradient>
              </defs>
              <!-- Stage 1 -->
              <rect x="20" y="16" width="500" height="44" rx="8" fill="#071A2C" stroke="rgba(6, 181, 249, 0.3)"
                stroke-width="1.2" />
              <rect x="20" y="16" width="496" height="44" rx="8" fill="url(#hGrad1)" fill-opacity="0.25" />
              <text x="36" y="43" fill="#F4F8FC" font-size="12.5" font-family="var(--font-display)" font-weight="700">01
                // TOTAL REACH</text>
              <text x="360" y="43" fill="#0099DB" font-size="13" font-family="var(--font-mono)"
                font-weight="700">1,250,000</text>
              <text x="475" y="43" fill="#AABBCB" font-size="11.5" font-family="var(--font-mono)">100%</text>

              <!-- Bridge 1-2 -->
              <polygon points="120,60 420,60 380,78 160,78" fill="url(#hBridge)" />

              <!-- Stage 2 -->
              <rect x="55" y="78" width="430" height="44" rx="8" fill="#071A2C" stroke="rgba(6, 181, 249, 0.35)"
                stroke-width="1.2" />
              <rect x="55" y="78" width="310" height="44" rx="8" fill="url(#hGrad1)" fill-opacity="0.4" />
              <text x="71" y="105" fill="#F4F8FC" font-size="12.5" font-family="var(--font-display)"
                font-weight="700">02 // WEBSITE VISITORS</text>
              <text x="360" y="105" fill="#0099DB" font-size="13" font-family="var(--font-mono)"
                font-weight="700">240,000</text>
              <text x="445" y="105" fill="#AABBCB" font-size="11.5" font-family="var(--font-mono)">65%</text>

              <!-- Bridge 2-3 -->
              <polygon points="175,122 365,122 335,140 205,140" fill="url(#hBridge)" />

              <!-- Stage 3 -->
              <rect x="95" y="140" width="350" height="44" rx="8" fill="#071A2C" stroke="rgba(6, 181, 249, 0.45)"
                stroke-width="1.2" />
              <rect x="95" y="140" width="200" height="44" rx="8" fill="url(#hGrad2)" fill-opacity="0.5" />
              <text x="111" y="167" fill="#F4F8FC" font-size="12.5" font-family="var(--font-display)"
                font-weight="700">03 // ENGAGED AUDIENCE</text>
              <text x="340" y="167" fill="#0099DB" font-size="13" font-family="var(--font-mono)"
                font-weight="700">85,000</text>
              <text x="405" y="167" fill="#AABBCB" font-size="11.5" font-family="var(--font-mono)">40%</text>

              <!-- Bridge 3-4 -->
              <polygon points="215,184 325,184 300,202 240,202" fill="url(#hBridge)" />

              <!-- Stage 4 -->
              <rect x="125" y="202" width="290" height="44" rx="8" fill="#071A2C" stroke="#06B5F9" stroke-width="1.5" />
              <rect x="125" y="202" width="140" height="44" rx="8" fill="url(#hGrad2)" fill-opacity="0.8" />
              <text x="140" y="229" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)"
                font-weight="700">04 // BRAND SEARCHES</text>
              <text x="312" y="229" fill="#0099DB" font-size="12.5" font-family="var(--font-mono)"
                font-weight="700">42,000</text>
              <text x="375" y="229" fill="#AABBCB" font-size="11" font-family="var(--font-mono)">24%</text>
            </svg>
          </div>

          <!-- 02: Vertical Bar Chart -->
          <div class="benefits-viz-item" data-viz="1">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg"
              aria-label="Vertical Bar Chart: Channel Engagement">
              <defs>
                <linearGradient id="vBarGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#0099DB" />
                  <stop offset="70%" stop-color="#06B5F9" />
                  <stop offset="100%" stop-color="#0A223B" />
                </linearGradient>
              </defs>
              <!-- Grid lines -->
              <line x1="40" y1="35" x2="510" y2="35" stroke="rgba(6, 181, 249, 0.12)" stroke-dasharray="3 3" />
              <text x="25" y="38" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">100%</text>
              <line x1="40" y1="85" x2="510" y2="85" stroke="rgba(6, 181, 249, 0.12)" stroke-dasharray="3 3" />
              <text x="28" y="88" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">75%</text>
              <line x1="40" y1="135" x2="510" y2="135" stroke="rgba(6, 181, 249, 0.12)" stroke-dasharray="3 3" />
              <text x="28" y="138" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">50%</text>
              <line x1="40" y1="185" x2="510" y2="185" stroke="rgba(6, 181, 249, 0.12)" stroke-dasharray="3 3" />
              <text x="28" y="188" fill="#8297AA" font-size="9.5" font-family="var(--font-mono)">25%</text>
              <line x1="40" y1="215" x2="510" y2="215" stroke="rgba(6, 181, 249, 0.35)" stroke-width="1.5" />

              <!-- Bar 1: Website Interaction (88%) -->
              <rect x="65" y="59" width="56" height="156" rx="6" fill="url(#vBarGrad)" />
              <text x="93" y="49" fill="#0099DB" font-size="12" font-family="var(--font-mono)" font-weight="700"
                text-anchor="middle">88%</text>
              <text x="93" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)"
                text-anchor="middle">Website</text>

              <!-- Bar 2: Social Engagement (74%) -->
              <rect x="160" y="87" width="56" height="128" rx="6" fill="url(#vBarGrad)" />
              <text x="188" y="77" fill="#0099DB" font-size="12" font-family="var(--font-mono)" font-weight="700"
                text-anchor="middle">74%</text>
              <text x="188" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)"
                text-anchor="middle">Social</text>

              <!-- Bar 3: Content Engagement (68%) -->
              <rect x="255" y="99" width="56" height="116" rx="6" fill="url(#vBarGrad)" />
              <text x="283" y="89" fill="#0099DB" font-size="12" font-family="var(--font-mono)" font-weight="700"
                text-anchor="middle">68%</text>
              <text x="283" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)"
                text-anchor="middle">Content</text>

              <!-- Bar 4: Video Engagement (94%) -->
              <rect x="350" y="47" width="56" height="168" rx="6" fill="url(#vBarGrad)" stroke="#0099DB"
                stroke-width="1.2" />
              <text x="378" y="37" fill="#0099DB" font-size="12" font-family="var(--font-mono)" font-weight="700"
                text-anchor="middle">94%</text>
              <text x="378" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)"
                text-anchor="middle">Video</text>

              <!-- Bar 5: Email Engagement (62%) -->
              <rect x="445" y="111" width="56" height="104" rx="6" fill="url(#vBarGrad)" />
              <text x="473" y="101" fill="#0099DB" font-size="12" font-family="var(--font-mono)" font-weight="700"
                text-anchor="middle">62%</text>
              <text x="473" y="235" fill="#C3D0DE" font-size="10.5" font-family="var(--font-mono)"
                text-anchor="middle">Email</text>
            </svg>
          </div>

          <!-- 03: Donut Chart with Center KPI -->
          <div class="benefits-viz-item" data-viz="2">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg"
              aria-label="Donut Chart: Marketing Investment and Revenue Return">
              <circle cx="160" cy="135" r="75" stroke="#071A2C" stroke-width="26" fill="none" />
              <circle cx="160" cy="135" r="75" stroke="#0A223B" stroke-width="24" stroke-dasharray="113 471"
                stroke-dashoffset="-358" fill="none" />
              <circle cx="160" cy="135" r="75" stroke="#06B5F9" stroke-width="24" stroke-dasharray="358 471"
                stroke-dashoffset="0" stroke-linecap="round" fill="none" />

              <circle cx="160" cy="135" r="54" fill="#0A1D35" stroke="rgba(6, 181, 249, 0.35)" stroke-width="1.5" />
              <text x="160" y="125" fill="#0099DB" font-size="22" font-family="var(--font-display)" font-weight="900"
                text-anchor="middle">4.2×</text>
              <text x="160" y="142" fill="#F4F8FC" font-size="9" font-family="var(--font-mono)" font-weight="700"
                text-anchor="middle">AVERAGE ROAS</text>
              <text x="160" y="157" fill="#06B5F9" font-size="8.5" font-family="var(--font-mono)"
                text-anchor="middle">+320% RETURN</text>

              <g transform="translate(300, 48)">
                <rect width="215" height="66" rx="8" fill="#071A2C" stroke="rgba(6, 181, 249, 0.3)"
                  stroke-width="1.2" />
                <circle cx="20" cy="33" r="6" fill="#06B5F9" />
                <text x="36" y="25" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)"
                  font-weight="700">Revenue Return</text>
                <text x="36" y="43" fill="#0099DB" font-size="12" font-family="var(--font-mono)" font-weight="800">76%
                  of Total Value</text>
                <text x="36" y="57" fill="#AABBCB" font-size="9" font-family="var(--font-mono)">Verified Commercial
                  Lift</text>
              </g>

              <g transform="translate(300, 134)">
                <rect width="215" height="66" rx="8" fill="#071A2C" stroke="rgba(6, 181, 249, 0.2)"
                  stroke-width="1.2" />
                <circle cx="20" cy="33" r="6" fill="#0A223B" stroke="#0099DB" stroke-width="1.5" />
                <text x="36" y="25" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)"
                  font-weight="700">Marketing Investment</text>
                <text x="36" y="43" fill="#C3D0DE" font-size="12" font-family="var(--font-mono)" font-weight="800">24%
                  Optimized Capital</text>
                <text x="36" y="57" fill="#AABBCB" font-size="9" font-family="var(--font-mono)">Zero Ad Budget
                  Waste</text>
              </g>
            </svg>
          </div>

          <!-- 04: Segmented Audience Funnel -->
          <div class="benefits-viz-item" data-viz="3">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg"
              aria-label="Segmented Audience Funnel">
              <defs>
                <linearGradient id="seg1" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#0A223B" stop-opacity="0.7" />
                  <stop offset="100%" stop-color="#06B5F9" stop-opacity="0.4" />
                </linearGradient>
                <linearGradient id="seg2" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#06B5F9" stop-opacity="0.8" />
                  <stop offset="100%" stop-color="#0099DB" stop-opacity="0.6" />
                </linearGradient>
              </defs>

              <polygon points="30,20 510,20 460,58 80,58" fill="url(#seg1)" stroke="rgba(6, 181, 249, 0.35)"
                stroke-width="1.2" />
              <text x="270" y="38" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700"
                text-anchor="middle">TOTAL MARKET (100% // 500K)</text>

              <polygon points="85,64 455,64 415,102 125,102" fill="url(#seg1)" stroke="rgba(6, 181, 249, 0.45)"
                stroke-width="1.2" />
              <text x="270" y="82" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700"
                text-anchor="middle">TARGETED SEGMENT (58% // 290K)</text>

              <polygon points="130,108 410,108 370,146 170,146" fill="url(#seg1)" stroke="rgba(6, 181, 249, 0.55)"
                stroke-width="1.2" />
              <text x="270" y="126" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700"
                text-anchor="middle">QUALIFIED LEADS (32% // 160K)</text>

              <polygon points="175,152 365,152 335,190 205,190" fill="url(#seg2)" stroke="#06B5F9" stroke-width="1.4" />
              <text x="270" y="171" fill="#F4F8FC" font-size="9.5" font-family="var(--font-display)" font-weight="700"
                text-anchor="middle" letter-spacing="0.2px">ENGAGED USERS (18% // 90K)</text>

              <polygon points="210,196 330,196 305,236 235,236" fill="url(#seg2)" stroke="#0099DB" stroke-width="1.6" />
              <text x="270" y="214" fill="#061326" font-size="10.5" font-family="var(--font-display)" font-weight="900"
                text-anchor="middle">CONVERTED</text>
              <text x="270" y="228" fill="#061326" font-size="9" font-family="var(--font-mono)" font-weight="800"
                text-anchor="middle">7.4% (37K)</text>
            </svg>
          </div>

          <!-- 05: Multi-Trend Line Chart -->
          <div class="benefits-viz-item" data-viz="4">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg"
              aria-label="Multi-Trend Line Chart: Traffic, Engagement, Conversion">
              <defs>
                <linearGradient id="areaTraffic" x1="0%" y1="0%" x2="0%" y2="100%">
                  <stop offset="0%" stop-color="#06B5F9" stop-opacity="0.35" />
                  <stop offset="100%" stop-color="#0A223B" stop-opacity="0.0" />
                </linearGradient>
              </defs>

              <line x1="45" y1="30" x2="510" y2="30" stroke="rgba(6, 181, 249, 0.1)" stroke-dasharray="3 3" />
              <line x1="45" y1="80" x2="510" y2="80" stroke="rgba(6, 181, 249, 0.1)" stroke-dasharray="3 3" />
              <line x1="45" y1="130" x2="510" y2="130" stroke="rgba(6, 181, 249, 0.1)" stroke-dasharray="3 3" />
              <line x1="45" y1="180" x2="510" y2="180" stroke="rgba(6, 181, 249, 0.1)" stroke-dasharray="3 3" />
              <line x1="45" y1="210" x2="510" y2="210" stroke="rgba(6, 181, 249, 0.35)" stroke-width="1.5" />

              <text x="60" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M1</text>
              <text x="145" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M2</text>
              <text x="230" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M3</text>
              <text x="315" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M4</text>
              <text x="400" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M5</text>
              <text x="485" y="226" fill="#8297AA" font-size="10" font-family="var(--font-mono)">M6</text>

              <path d="M 60,185 C 130,165 200,135 270,105 C 340,80 415,55 485,38 L 485,210 L 60,210 Z"
                fill="url(#areaTraffic)" />
              <path d="M 60,185 C 130,165 200,135 270,105 C 340,80 415,55 485,38" stroke="#06B5F9" stroke-width="3"
                stroke-linecap="round" />
              <path d="M 60,195 C 130,185 200,160 270,130 C 340,110 415,85 485,65" stroke="#0099DB" stroke-width="2.5"
                stroke-dasharray="5 4" stroke-linecap="round" />
              <path d="M 60,205 C 130,200 200,185 270,165 C 340,140 415,115 485,92" stroke="#6EE7B7" stroke-width="2"
                stroke-dasharray="2 3" stroke-linecap="round" />

              <circle cx="60" cy="185" r="4" fill="#071A2C" stroke="#06B5F9" stroke-width="2" />
              <circle cx="270" cy="105" r="4.5" fill="#071A2C" stroke="#06B5F9" stroke-width="2" />
              <circle cx="485" cy="38" r="5" fill="#0099DB" stroke="#071A2C" stroke-width="2" />

              <g transform="translate(60, 245)">
                <line x1="0" y1="6" x2="20" y2="6" stroke="#06B5F9" stroke-width="3" />
                <text x="26" y="10" fill="#F4F8FC" font-size="10" font-family="var(--font-mono)">Traffic (+240%)</text>
                <line x1="140" y1="6" x2="160" y2="6" stroke="#0099DB" stroke-width="2.5" stroke-dasharray="4 3" />
                <text x="166" y="10" fill="#0099DB" font-size="10" font-family="var(--font-mono)">Engagement
                  (88%)</text>
                <line x1="300" y1="6" x2="320" y2="6" stroke="#6EE7B7" stroke-width="2" stroke-dasharray="2 3" />
                <text x="326" y="10" fill="#C3D0DE" font-size="10" font-family="var(--font-mono)">Conversion
                  (4.8%)</text>
              </g>
            </svg>
          </div>

          <!-- 06: Conversion Funnel -->
          <div class="benefits-viz-item" data-viz="5">
            <svg viewBox="0 0 540 270" fill="none" xmlns="http://www.w3.org/2000/svg" class="benefits-chart-svg"
              aria-label="Conversion Funnel: Visitors to Conversions">
              <defs>
                <linearGradient id="cfGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                  <stop offset="0%" stop-color="#0A223B" />
                  <stop offset="100%" stop-color="#06B5F9" />
                </linearGradient>
              </defs>

              <!-- Stage 1: Visitors -->
              <rect x="30" y="12" width="480" height="32" rx="6" fill="#071A2C" stroke="rgba(6, 181, 249, 0.3)"
                stroke-width="1.2" />
              <rect x="30" y="12" width="476" height="32" rx="6" fill="url(#cfGrad)" fill-opacity="0.25" />
              <text x="44" y="32" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700">1.
                VISITORS</text>
              <text x="448" y="32" fill="#0099DB" font-size="11.5" font-family="var(--font-mono)" font-weight="700"
                text-anchor="end">10,000</text>
              <text x="496" y="32" fill="#AABBCB" font-size="11" font-family="var(--font-mono)"
                text-anchor="end">100%</text>

              <!-- Drop-off 1 -->
              <text x="270" y="55" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle"
                dominant-baseline="middle">▼ -36% (High-intent discovery filter)</text>

              <!-- Stage 2: Product/Service Views -->
              <rect x="65" y="64" width="410" height="32" rx="6" fill="#071A2C" stroke="rgba(6, 181, 249, 0.35)"
                stroke-width="1.2" />
              <rect x="65" y="64" width="310" height="32" rx="6" fill="url(#cfGrad)" fill-opacity="0.3" />
              <text x="79" y="84" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700">2.
                PRODUCT/SERVICE VIEWS</text>
              <text x="413" y="84" fill="#0099DB" font-size="11.5" font-family="var(--font-mono)" font-weight="700"
                text-anchor="end">6,400</text>
              <text x="461" y="84" fill="#AABBCB" font-size="11" font-family="var(--font-mono)"
                text-anchor="end">64%</text>

              <!-- Drop-off 2 -->
              <text x="270" y="106" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle"
                dominant-baseline="middle">▼ -30% (Solution alignment evaluation)</text>

              <!-- Stage 3: Enquiries -->
              <rect x="100" y="116" width="340" height="32" rx="6" fill="#071A2C" stroke="rgba(6, 181, 249, 0.45)"
                stroke-width="1.2" />
              <rect x="100" y="116" width="190" height="32" rx="6" fill="url(#cfGrad)" fill-opacity="0.35" />
              <text x="114" y="136" fill="#F4F8FC" font-size="11.5" font-family="var(--font-display)" font-weight="700">3.
                ENQUIRIES</text>
              <text x="378" y="136" fill="#0099DB" font-size="11.5" font-family="var(--font-mono)" font-weight="700"
                text-anchor="end">3,400</text>
              <text x="426" y="136" fill="#AABBCB" font-size="11" font-family="var(--font-mono)"
                text-anchor="end">34%</text>

              <!-- Drop-off 3 -->
              <text x="270" y="158" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle"
                dominant-baseline="middle">▼ -16% (Scope and qualification fit)</text>

              <!-- Stage 4: Qualified Leads -->
              <rect x="135" y="168" width="270" height="32" rx="6" fill="#071A2C" stroke="rgba(6, 181, 249, 0.55)"
                stroke-width="1.2" />
              <rect x="135" y="168" width="125" height="32" rx="6" fill="url(#cfGrad)" fill-opacity="0.4" />
              <text x="149" y="188" fill="#F4F8FC" font-size="11" font-family="var(--font-display)" font-weight="700">4.
                QUALIFIED LEADS</text>
              <text x="343" y="188" fill="#0099DB" font-size="11.5" font-family="var(--font-mono)" font-weight="700"
                text-anchor="end">1,800</text>
              <text x="391" y="188" fill="#AABBCB" font-size="11" font-family="var(--font-mono)"
                text-anchor="end">18%</text>

              <!-- Drop-off 4 -->
              <text x="270" y="210" fill="#8297AA" font-size="9" font-family="var(--font-mono)" text-anchor="middle"
                dominant-baseline="middle">▼ -9.8% (Commercial commitment)</text>

              <!-- Stage 5: Conversions -->
              <rect x="155" y="220" width="230" height="34" rx="8" fill="#071A2C" stroke="#06B5F9" stroke-width="1.6" />
              <rect x="155" y="220" width="230" height="34" rx="8" fill="#06B5F9" fill-opacity="0.18" />
              <text x="169" y="241" fill="#0099DB" font-size="11" font-family="var(--font-display)" font-weight="800">5.
                CONVERSIONS</text>
              <text x="323" y="241" fill="#06B5F9" font-size="11.5" font-family="var(--font-mono)" font-weight="800"
                text-anchor="end">820</text>
              <text x="371" y="241" fill="#06B5F9" font-size="11" font-family="var(--font-mono)" font-weight="800"
                text-anchor="end">8.2%</text>
            </svg>
          </div>
        </div>

        <div class="benefits-viz-footnote">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="16" x2="12" y2="12" />
            <line x1="12" y1="8" x2="12.01" y2="8" />
          </svg>
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
        <h2 class="section-title">
          A strong approach &amp; <span class="text-gradient-pine">for business growth</span>
        </h2>
        <p class="lead">
          We work according to what you need and what your brand needs. We inspect your business, customise a plan and
          monitor it until it reaches its full potential.
        </p>
      </div>

      <div class="stage-controls-col">
        <div class="stage-controls-row">
          <div class="stage-drag-hint">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            <span>Drag or Swipe to Explore</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </div>
          <div class="stage-counter-badge" aria-live="polite">
            STAGE <span class="active-num" id="currentStageNum">01</span> / 05
          </div>
          <button type="button" class="stage-nav-btn" id="stagePrevBtn" aria-label="Previous stage" disabled>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
          </button>
          <button type="button" class="stage-nav-btn" id="stageNextBtn" aria-label="Next stage">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
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
    <div class="stage-carousel-viewport" id="stageCarouselViewport" role="region" aria-roledescription="carousel"
      aria-label="5-Stage Engineering and Growth Methodology" tabindex="0">
      <div class="stage-track" id="stageTrack">

        <!-- Step 1: Discover -->
        <article class="stage-card is-active" data-index="0" role="group" aria-roledescription="slide"
          aria-label="Stage 1 of 5: Discover">
          <div class="stage-watermark">01</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 01 // ARCHITECTURAL AUDIT</span>
            </div>
            <div class="stage-title-row" style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
              <span class="approach-num" style="margin-bottom: 0; line-height: 1; flex-shrink: 0;">01</span>
              <h3 class="approach-title" style="margin-bottom: 0; line-height: 1.2;">Discover</h3>
            </div>
            <p class="approach-desc">
              We start with understanding your goals, business needs, target audience and challenges. It helps us to
              create a strategy for your business.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Full Architecture &amp; Funnel Audit
          </div>
        </article>

        <!-- Step 2: Strategize -->
        <article class="stage-card" data-index="1" role="group" aria-roledescription="slide"
          aria-label="Stage 2 of 5: Strategize">
          <div class="stage-watermark">02</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 02 // SYSTEMS ARCHITECTURE</span>
            </div>
            <div class="stage-title-row" style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
              <span class="approach-num" style="margin-bottom: 0; line-height: 1; flex-shrink: 0;">02</span>
              <h3 class="approach-title" style="margin-bottom: 0; line-height: 1.2;">Strategies</h3>
            </div>
            <p class="approach-desc">
              Strategies are the main foundation of the growth journey. We customize every strategy while keeping your
              needs and goals in mind.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Systems Blueprint &amp; KPI SLAs
          </div>
        </article>

        <!-- Step 3: Engineer -->
        <article class="stage-card" data-index="2" role="group" aria-roledescription="slide"
          aria-label="Stage 3 of 5: Engineer">
          <div class="stage-watermark">03</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 03 // FULL-STACK BUILD</span>
            </div>
            <div class="stage-title-row" style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
              <span class="approach-num" style="margin-bottom: 0; line-height: 1; flex-shrink: 0;">03</span>
              <h3 class="approach-title" style="margin-bottom: 0; line-height: 1.2;">Engineer</h3>
            </div>
            <p class="approach-desc">
              Execute the plan with seo, ads, website development and more so that you can achieve your business goal.
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Production-Ready Applications
          </div>
        </article>

        <!-- Step 4: Optimize -->
        <article class="stage-card" data-index="3" role="group" aria-roledescription="slide"
          aria-label="Stage 4 of 5: Optimize">
          <div class="stage-watermark">04</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 04 // PERFORMANCE &amp; ROAS</span>
            </div>
            <div class="stage-title-row" style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
              <span class="approach-num" style="margin-bottom: 0; line-height: 1; flex-shrink: 0;">04</span>
              <h3 class="approach-title" style="margin-bottom: 0; line-height: 1.2;">Optimization</h3>
            </div>
            <p class="approach-desc">
              At Businessdoctor, after executing the strategy, we optimise performance. We find out what is working well
              and where we need necessary changes
            </p>
          </div>
          <div class="approach-deliverable">
            STAGE DELIVERABLE: Sub-Second Load &amp; Higher ROAS
          </div>
        </article>

        <!-- Step 5: Grow -->
        <article class="stage-card" data-index="4" role="group" aria-roledescription="slide"
          aria-label="Stage 5 of 5: Grow">
          <div class="stage-watermark">05</div>
          <div>
            <div class="stage-card-meta">
              <span class="stage-phase-tag">PHASE 05 // SCALE &amp; RETENTION</span>
            </div>
            <div class="stage-title-row" style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
              <span class="approach-num" style="margin-bottom: 0; line-height: 1; flex-shrink: 0;">05</span>
              <h3 class="approach-title" style="margin-bottom: 0; line-height: 1.2;">Grow</h3>
            </div>
            <p class="approach-desc">
              At Businessdoctor, we focus on taking your business to the next level. Our team focuses on building your
              online presence more strongly.
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
     6. PROVEN OUTCOMES (STANDARDS & ACCOUNTABILITY)
     ============================================================ -->
<section class="section accountability-section" id="accountability">
  <div class="container" style="position: relative; z-index: 2;">
    <!-- Section Header -->
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>PROVEN OUTCOMES</span>
      </div>
      <h2 class="section-title">
        Real Business Growth with &amp; <span class="text-gradient-pine">the Right Digital Marketing Strategy.</span>
      </h2>
      <p class="lead">
        At Business Doctor, a trusted digital marketing company in Delhi, we provide everything from generating quality
        leads to increasing online visibility which helps your business grow.
      </p>
    </div>

    <!-- 4 Feature Cards Grid -->
    <div class="proven-outcomes-grid">

      <!-- Card 01 -->
      <article class="proven-outcome-card">
        <div class="poc-card-top">
          <span class="poc-num">01</span>
          <div class="poc-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
            </svg>
          </div>
        </div>
        <h3 class="poc-title">Faster Website Performance</h3>
        <p class="poc-desc">
          Business Doctor is a digital marketing company in Delhi. We design user friendly websites with faster
          performance. This makes the user experience better.
        </p>
      </article>

      <!-- Card 02 -->
      <article class="proven-outcome-card">
        <div class="poc-card-top">
          <span class="poc-num">02</span>
          <div class="poc-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="2" y1="12" x2="22" y2="12"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
          </div>
        </div>
        <h3 class="poc-title">Stronger Online Visibility</h3>
        <p class="poc-desc">
          We provide the best seo service in delhi that improve your business's online visibility. Good online
          visibility will help you to get more leads and quality customers.
        </p>
      </article>

      <!-- Card 03 -->
      <article class="proven-outcome-card">
        <div class="poc-card-top">
          <span class="poc-num">03</span>
          <div class="poc-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="20" x2="18" y2="10"/>
              <line x1="12" y1="20" x2="12" y2="4"/>
              <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
          </div>
        </div>
        <h3 class="poc-title">Better Lead Generation</h3>
        <p class="poc-desc">
          Our team helps you to get quality leads that help your business to grow and turn enquiries into real
          potential customers. Our goal is to help you build a strong customer base and achieve long term success.
        </p>
      </article>

      <!-- Card 04 -->
      <article class="proven-outcome-card">
        <div class="poc-card-top">
          <span class="poc-num">04</span>
          <div class="poc-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
        </div>
        <h3 class="poc-title">Zero Ad Waste Guarantee</h3>
        <p class="poc-desc">
          Our goal is maximum utilisation of your advertising budget and to reduce unnecessary ad spending. We make
          sure that your ad reaches the right audience through smart, data driven strategies and continuous campaigns.
        </p>
      </article>

    </div>

  </div>
</section>

<!-- ============================================================
     7. NEW REAL RESULTS (CASE STUDIES & PERFORMANCE METRICS)
     ============================================================ -->
<section class="section real-results-section" id="realResultsSection">
  <div class="container">
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>PROOF OF WORK</span>
      </div>
      <h2 class="section-title">
        Real Client Stories and <span class="text-gradient-pine">Digital Business Success Experiences</span>
      </h2>
      <p class="lead">
        Explore how BusinessDoctor Online Marketing company in Delhi combines engineering, marketing and digital
        strategy to solve business challenges and deliver measurable outcomes. Our professional team helps your business
        to reach its full potential.
      </p>
    </div>

    <div class="results-cards-grid">
      <?php if (!empty($featuredCases)): ?>
        <?php foreach ($featuredCases as $case): ?>
          <article class="result-card-v2">
            <!-- Header: Industry & Verified Case -->
            <div class="rc-header">
              <span class="rc-industry-pill">
                <span class="rc-pill-dot"></span>
                <?= e($case['client_industry']) ?>
              </span>
              <span class="rc-badge-verified">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
                Verified Case
              </span>
            </div>

            <!-- Title -->
            <h3 class="rc-title"><?= e($case['title']) ?></h3>

            <!-- Metric Spotlight Banner -->
            <div class="rc-metric-spotlight">
              <div class="rc-metric-top">
                <span class="rc-metric-label"><?= e($case['metric_label']) ?></span>
                <span class="rc-metric-growth-tag">Turnaround</span>
              </div>
              <div class="rc-metric-value"><?= e($case['outcome_metric']) ?></div>
              <div class="rc-baseline-row">
                <span>Baseline:</span>
                <span class="rc-baseline-val"><?= e($case['baseline_metric']) ?></span>
              </div>
            </div>

            <!-- Challenge & Solution Stack -->
            <div class="rc-meta-stack">
              <div class="rc-meta-item">
                <div class="rc-meta-heading">
                  <span class="rc-meta-bullet red"></span>
                  <span>Business Challenge</span>
                </div>
                <p class="rc-meta-text"><?= e($case['challenge']) ?></p>
              </div>

              <div class="rc-meta-item">
                <div class="rc-meta-heading">
                  <span class="rc-meta-bullet cyan"></span>
                  <span>Solution Delivered</span>
                </div>
                <p class="rc-meta-text"><?= e($case['prescription']) ?></p>
              </div>
            </div>

            <!-- Outcome Verified Callout -->
            <div class="rc-outcome-callout">
              <div class="rc-outcome-header">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                  <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>Outcome Verified</span>
              </div>
              <p class="rc-outcome-text"><?= e($case['result_description']) ?></p>
            </div>

            <!-- Footer Link -->
            <div class="rc-footer">
              <a href="<?= getCaseStudyUrl($case['slug']) ?>" class="rc-action-btn">
                <span>View Full Case Study</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                  <line x1="5" y1="12" x2="19" y2="12" />
                  <polyline points="12 5 19 12 12 19" />
                </svg>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 3.5rem;">
      <a href="/case-studies" class="btn btn-secondary btn-lg">
        <span>Explore All Case Studies</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
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
      <h2 class="section-title">Tools That Power Our Digital Marketing and Business Solutions.</h2>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <path d="m4.93 4.93 4.24 4.24" />
              <path d="m14.83 9.17 4.24-4.24" />
              <path d="m14.83 14.83 4.24 4.24" />
              <path d="m9.17 14.83-4.24 4.24" />
            </svg>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
              <rect x="2" y="9" width="4" height="12" />
              <circle cx="4" cy="4" r="2" />
            </svg>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="20" x2="18" y2="10" />
              <line x1="12" y1="20" x2="12" y2="4" />
              <line x1="6" y1="20" x2="6" y2="14" />
            </svg>
          </div>
          <span class="tool-category-badge">Analytics</span>
        </div>
        <h4 class="tool-name">Google Analytics 4</h4>
        <p class="tool-purpose">Event-driven behavioral telemetry, multi-touch attribution and conversion funnels.</p>
      </div>

      <!-- 5. Google Search Console -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
          </div>
          <span class="tool-category-badge">Analytics</span>
        </div>
        <h4 class="tool-name">Google Search Console</h4>
        <p class="tool-purpose">Organic indexing health, crawl optimization and search query performance monitoring.
        </p>
      </div>

      <!-- 6. SEMrush -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
            </svg>
          </div>
          <span class="tool-category-badge">SEO</span>
        </div>
        <h4 class="tool-name">SEMrush</h4>
        <p class="tool-purpose">Competitor intelligence, paid search gap analysis and keyword search intent modeling.
        </p>
      </div>

      <!-- 7. Ahrefs -->
      <div class="tool-card" data-category="analytics">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
              <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
            </svg>
          </div>
          <span class="tool-category-badge">SEO</span>
        </div>
        <h4 class="tool-name">Ahrefs</h4>
        <p class="tool-purpose">Enterprise backlink audits, domain authority benchmarking and technical site crawling.
        </p>
      </div>

      <!-- 8. Figma -->
      <div class="tool-card" data-category="design">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 2 7 12 12 22 7 12 2" />
              <polyline points="2 17 12 22 22 17" />
              <polyline points="2 12 12 17 22 12" />
            </svg>
          </div>
          <span class="tool-category-badge">Design</span>
        </div>
        <h4 class="tool-name">Figma</h4>
        <p class="tool-purpose">Collaborative UI/UX wireframing, component design systems and rapid prototyping.</p>
      </div>

      <!-- 9. Canva -->
      <div class="tool-card" data-category="design">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <path d="M8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0z" />
            </svg>
          </div>
          <span class="tool-category-badge">Design</span>
        </div>
        <h4 class="tool-name">Canva</h4>
        <p class="tool-purpose">Rapid marketing collateral, social creative variations and brand template libraries.
        </p>
      </div>

      <!-- 10. Adobe Creative Cloud -->
      <div class="tool-card" data-category="design">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
              <circle cx="8.5" cy="8.5" r="1.5" />
              <polyline points="21 15 16 10 5 21" />
            </svg>
          </div>
          <span class="tool-category-badge">Design</span>
        </div>
        <h4 class="tool-name">Adobe Creative Cloud</h4>
        <p class="tool-purpose">Professional studio photo retouching, vector brand identities and motion graphics. </p>
      </div>

      <!-- 11. WordPress -->
      <div class="tool-card" data-category="web">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
              <line x1="8" y1="21" x2="16" y2="21" />
              <line x1="12" y1="17" x2="12" y2="21" />
            </svg>
          </div>
          <span class="tool-category-badge">Web &amp; CMS</span>
        </div>
        <h4 class="tool-name">WordPress</h4>
        <p class="tool-purpose">Editorial publication systems, content portals and headless CMS architectures.</p>
      </div>

      <!-- 12. Shopify -->
      <div class="tool-card" data-category="web">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="9" cy="21" r="1" />
              <circle cx="20" cy="21" r="1" />
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
          </div>
          <span class="tool-category-badge">Commerce</span>
        </div>
        <h4 class="tool-name">Shopify</h4>
        <p class="tool-purpose">High-converting D2C storefronts, streamlined checkout funnels and app integrations.
        </p>
      </div>

      <!-- 13. HubSpot -->
      <div class="tool-card" data-category="crm">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
          </div>
          <span class="tool-category-badge">CRM</span>
        </div>
        <h4 class="tool-name">HubSpot</h4>
        <p class="tool-purpose">Inbound marketing automation, enterprise CRM pipelines and lead scoring logic.</p>
      </div>

      <!-- 14. Mailchimp -->
      <div class="tool-card" data-category="crm">
        <div class="tool-card-top">
          <div class="tool-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
              <polyline points="22,6 12,13 2,6" />
            </svg>
          </div>
          <span class="tool-category-badge">Automation</span>
        </div>
        <h4 class="tool-name">Mailchimp</h4>
        <p class="tool-purpose">Email marketing, automated cart recovery and subscriber segmentation.</p>
      </div>
    </div>

    <div class="tools-disclaimer">
      <span>All platform names and trademarks are property of their respective owners. BusinessDoctor deploys these
        industry-standard technologies across client engagements.</span>
    </div>
  </div>
</section>

<!-- ============================================================
     9. INSIGHTS & PERSPECTIVES EDITORIAL
     ============================================================ -->
<section class="section home-insights-section" id="insightsSection">
  <div class="container">
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>ENGINEERING PERSPECTIVES &amp; BLOG</span>
      </div>
      <h2 class="section-title">
        Digital Marketing, Technology &amp; <span class="text-gradient-pine">Business Growth Insights</span>
      </h2>
      <p class="lead">
        At Business Doctor, we focus on modern technology and smart digital solutions that improve your brand's online
        visibility and website performance and help the sustainable growth of your business.
      </p>
    </div>

    <div class="home-insights-showcase">
      <?php if (!empty($insightsList)): ?>
        <?php 
          $leadPost = $insightsList[0];
          $subPosts = array_slice($insightsList, 1);
        ?>

        <!-- Featured Lead Perspective Card -->
        <article class="hi-featured-card">
          <div class="hi-card-badge-row">
            <span class="hi-category-pill"><?= e($leadPost['category']) ?></span>
            <span class="hi-read-time">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
              </svg>
              <?= e($leadPost['reading_time']) ?>
            </span>
            <span class="hi-featured-pill">Featured Perspective</span>
          </div>

          <h3 class="hi-featured-title">
            <a href="<?= getBlogUrl($leadPost['slug']) ?>"><?= e($leadPost['title']) ?></a>
          </h3>

          <p class="hi-featured-summary"><?= e($leadPost['summary']) ?></p>

          <div class="hi-author-footer">
            <div class="hi-author-profile">
              <div class="hi-author-avatar" aria-hidden="true">
                <?= strtoupper(substr($leadPost['author_name'] ?: 'BD', 0, 2)) ?>
              </div>
              <div class="hi-author-meta">
                <span class="hi-author-name"><?= e($leadPost['author_name']) ?></span>
                <span class="hi-author-role"><?= e($leadPost['author_title']) ?></span>
              </div>
            </div>

            <a href="<?= getBlogUrl($leadPost['slug']) ?>" class="btn btn-accent btn-sm">
              <span>Read Blog</span>
              <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12" />
                <polyline points="12 5 19 12 12 19" />
              </svg>
            </a>
          </div>
        </article>

        <!-- Companion Articles Stack -->
        <div class="hi-companion-stack">
          <?php foreach ($subPosts as $post): ?>
            <article class="hi-companion-card">
              <div class="hi-card-badge-row">
                <span class="hi-category-pill"><?= e($post['category']) ?></span>
                <span class="hi-read-time">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                  </svg>
                  <?= e($post['reading_time']) ?>
                </span>
              </div>

              <h4 class="hi-companion-title">
                <a href="<?= getBlogUrl($post['slug']) ?>"><?= e($post['title']) ?></a>
              </h4>

              <p class="hi-companion-summary"><?= e($post['summary']) ?></p>

              <div class="hi-companion-footer">
                <div class="hi-author-inline">
                  <span class="hi-author-dot"></span>
                  <span class="hi-author-name"><?= e($post['author_name']) ?></span>
                  <?php if (!empty($post['author_title'])): ?>
                    <span class="hi-author-sep">•</span>
                    <span class="hi-author-role"><?= e($post['author_title']) ?></span>
                  <?php endif; ?>
                </div>

                <a href="<?= getBlogUrl($post['slug']) ?>" class="hi-read-link">
                  <span>Read Blog</span>
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                  </svg>
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted text-center" style="grid-column: 1 / -1;">No published blog articles currently available.</p>
      <?php endif; ?>
    </div>

    <!-- View All Blogs CTA -->
    <div class="home-insights-cta text-center">
      <a href="<?= getBlogListingUrl() ?>" class="btn btn-secondary btn-lg">
        <span>View All Blogs &amp; Insights</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     7.5. FREQUENTLY ASKED QUESTIONS (HOMEPAGE FAQ ACCORDION)
     ============================================================ -->
<section id="faq" class="section home-faq-section">
  <div class="container">
    <div class="section-header text-center home-section-header">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>FREQUENTLY ASKED QUESTIONS</span>
      </div>
      <h2 class="section-title">
        Frequently Asked Questions About <span class="text-gradient-pine">BusinessDoctor Services</span>
      </h2>
      <p class="lead">
        Clear answers on our digital marketing strategy, web performance engineering, SEO growth, and advertising ROI.
      </p>
    </div>

    <div class="srv-faq-container home-faq-container">
      <!-- FAQ Item 1 -->
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question-wrap">
            <span class="srv-faq-num">01</span>
            <span class="srv-faq-question-text">How do I choose the Best Digital Marketing company for My Business?</span>
          </span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Choosing a digital marketing company will depend on your goals, budget and target audience. You want to find an company that will understand your needs and provide the correct services with a clear strategy to help your business grow.</p>
          </div>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question-wrap">
            <span class="srv-faq-num">02</span>
            <span class="srv-faq-question-text">What digital marketing services does BusinessDoctor offer?</span>
          </span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>BusinessDoctor offers digital marketing services including SEO, social media marketing, paid advertising, content marketing and website development.</p>
          </div>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question-wrap">
            <span class="srv-faq-num">03</span>
            <span class="srv-faq-question-text">How can digital marketing help My Business grow?</span>
          </span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Digital marketing can help your business gain more visibility online. It can improve your website traffic, create brand awareness, lead generation and increase sales.</p>
          </div>
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question-wrap">
            <span class="srv-faq-num">04</span>
            <span class="srv-faq-question-text">How long will it take my digital marketing to deliver results?</span>
          </span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>The amount of time that it takes to deliver results will depend on your goals. Paid advertising can provide fast results with increased traffic and lead generation. SEO usually takes several months to see any real improvements.</p>
          </div>
        </div>
      </div>
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
          Whether you need a bespoke web application, high-ROI performance marketing campaigns, or comprehensive
          marketplace management, our senior technical teams are ready to execute.
        </p>

        <div class="closing-cta-buttons">
          <a href="/contact" class="btn btn-accent btn-lg">
            <span>Start an Enterprise Project</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
          <a href="/audit" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>