<?php
/**
 * BusinessDoctor Service Detail View — SEO — Search Engine Optimization
 * Discipline 06 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'SEO — Search Engine Optimization';
$serviceSlug = 'seo';
$consultationUrl = appUrl('contact.php?service=' . urlencode($serviceName));
?>

<!-- ============================================================
     SECTION 1 — HERO SECTION
     ============================================================ -->
<section class="srv-hero" id="overview">
  <div class="srv-container">
    <div class="srv-row srv-align-center">
      <div class="srv-col-12 srv-col-lg-6">
        <div class="srv-eyebrow">
          <span class="srv-eyebrow-dot"></span>
          <span>SEO COMPANY IN DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          SEO Company in Delhi <br><span class="text-brand">- Smarter Strategies, Stronger Results</span>
        </h1>
        <p class="srv-hero-desc">
          Boost your online presence and improve the search visibility of your business with a reliable SEO company in Delhi. At Business Doctor, we deliver skilled seo services in Delhi that help your business achieve consistent growth and attract suitable traffic. We build our seo strategy according to your business goals and the specific audience you want to target, and generate organic traffic. At Business Doctor, we offer a complete Seo solution for your business, including technical seo, on page seo, off page seo, local seo service, keyword strategy, and quality link building that help your business grow and build a strong online presence.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Consultation</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
          <a href="#services-list" class="btn-srv-secondary">
            <span>Explore Our Services</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </a>
        </div>

        <div class="srv-hero-stats">
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">3.8x</span>
            <span class="srv-hero-stat-lbl">Organic Traffic Growth</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">50+</span>
            <span class="srv-hero-stat-lbl">Keywords on Page 1</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">62%</span>
            <span class="srv-hero-stat-lbl">Lower Cost per Lead</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">90 Days</span>
            <span class="srv-hero-stat-lbl">to First Results</span>
          </div>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hero-visual">
          <div class="srv-visual-glow"></div>
          <div class="srv-visual-frame">
            <svg viewBox="0 0 600 440" fill="none" xmlns="http://www.w3.org/2000/svg"
              style="width:100%; height:auto; display:block;">
              <rect width="600" height="440" rx="14" fill="#071A2C" />
              <path d="M0 44H600M0 88H600M0 132H600M0 176H600M0 220H600M0 264H600M0 308H600M0 352H600M0 396H600"
                stroke="#06B5F9" stroke-opacity="0.08" />
              <path d="M60 0V440M120 0V440M180 0V440M240 0V440M300 0V440M360 0V440M420 0V440M480 0V440M540 0V440"
                stroke="#06B5F9" stroke-opacity="0.08" />
              <rect width="600" height="40" rx="14" fill="#0A223B" />
              <circle cx="28" cy="20" r="5" fill="#F87171" />
              <circle cx="46" cy="20" r="5" fill="#FBBF24" />
              <circle cx="64" cy="20" r="5" fill="#34D399" />
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11"
                font-weight="600">businessdoctor.growth :: paid-ads-organic-telemetry.v2</text>

              <!-- Metrics Cards -->
              <rect x="40" y="65" width="245" height="100" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5"
                stroke-opacity="0.4" />
              <text x="56" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// ORGANIC GROWTH</text>
              <text x="56" y="122" fill="#34D399" font-family="sans-serif" font-size="26" font-weight="900">3.8x</text>
              <text x="56" y="146" fill="#B8C7D9" font-family="monospace" font-size="10">Target: &gt; 3.0x &bull; 90 Days</text>

              <rect x="315" y="65" width="245" height="100" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5"
                stroke-opacity="0.4" />
              <text x="330" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// PAGE 1 RANKINGS</text>
              <text x="330" y="122" fill="#06B5F9" font-family="sans-serif" font-size="26"
                font-weight="900">120+</text>
              <text x="330" y="146" fill="#B8C7D9" font-family="monospace" font-size="10">High Commercial Intent Keywords</text>

              <!-- Interactive Chart Area -->
              <rect x="40" y="178" width="520" height="228" rx="10" fill="#0A2038" stroke="#06B5F9" stroke-width="1"
                stroke-opacity="0.25" />
              <text x="58" y="206" fill="#F5F7FA" font-family="sans-serif" font-size="12" font-weight="bold">Search Visibility &amp; Organic Ranking Velocity</text>

              <!-- Live Telemetry Badge -->
              <rect x="430" y="193" width="112" height="19" rx="4" fill="#061A2E" stroke="#06B5F9" stroke-width="0.8"
                stroke-opacity="0.5" />
              <circle cx="440" cy="202.5" r="3" fill="#34D399" />
              <text x="448" y="206" fill="#06B5F9" font-family="monospace" font-size="9" font-weight="bold"
                letter-spacing="0.5">LIVE TELEMETRY</text>

              <!-- Curve Trend Area Fill -->
              <path d="M60 340 C 140 330, 220 285, 300 265 C 370 248, 440 238, 515 235 L 515 375 L 60 375 Z"
                fill="url(#grad1_seo)" opacity="0.22" />

              <!-- Curve Trend Stroke -->
              <path d="M60 340 C 140 330, 220 285, 300 265 C 370 248, 440 238, 515 235" stroke="#06B5F9"
                stroke-width="3" fill="none" stroke-linecap="round" />

              <!-- Secondary dashed baseline -->
              <path d="M60 355 C 160 355, 320 350, 515 345" stroke="#8FA3B8" stroke-width="1.8" stroke-dasharray="4 4"
                fill="none" stroke-opacity="0.6" />
              <text x="350" y="338" fill="#8FA3B8" font-family="monospace" font-size="9.5" font-weight="600">Legacy Baseline</text>

              <!-- Data Points -->
              <circle cx="300" cy="265" r="4.5" fill="#06B5F9" stroke="#ffffff" stroke-width="2" />
              <circle cx="515" cy="235" r="5.5" fill="#34D399" stroke="#ffffff" stroke-width="2" />

              <!-- +180% LEADS Badge -->
              <rect x="420" y="252" width="105" height="23" rx="4" fill="#0D2644" stroke="#34D399" stroke-width="1"
                stroke-opacity="0.7" />
              <text x="435" y="267.5" fill="#34D399" font-family="monospace" font-size="10.5" font-weight="bold">+180% LEADS</text>

              <text x="58" y="390" fill="#8FA3B8" font-family="monospace" font-size="9.5">Audited Organic Visibility &bull; Google Search Console &amp; GA4 Telemetry</text>

              <defs>
                <linearGradient id="grad1_seo" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="0%" stop-color="#06B5F9" />
                  <stop offset="100%" stop-color="#071A2C" stop-opacity="0" />
                </linearGradient>
              </defs>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     KEY TAKEAWAYS & EXECUTIVE SUMMARY
     ============================================================ -->
<section class="srv-section srv-section-takeaways" style="padding-top: 0; padding-bottom: 2.5rem;">
  <div class="srv-container">
    <div class="srv-key-takeaways">
      <div class="srv-takeaways-header">
        <div class="srv-takeaways-kicker">
          <svg class="srv-takeaways-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
          </svg>
          <span>KEY TAKEAWAYS</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">3.8x</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Average organic traffic growth in 6 months</span>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">120+</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Keywords ranking on page one</span>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Transparent monthly reporting</span>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">90 days</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Typical time to visible ranking movement</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2 — SERVICE INTRODUCTION / PHILOSOPHY
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="introduction">
  <div class="srv-container">
    <div class="srv-row srv-align-center">
      <div class="srv-col-12 srv-col-lg-6">
        <div class="srv-badge mb-3">
          <span class="srv-badge-dot"></span>
          <span>DATA-DRIVEN GROWTH PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Convert your Search Visibility <span class="text-brand">into Real Revenue</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Many companies will invest in an SEO company in Delhi however often the results are reports based around impressions and traffic only, with little real enquiry. With our focus on helping your business grow, we’ll identify your revenue goals and create a strategy that targets the right keywords, landing pages and authority signals.
        </p>
        <p class="srv-card-desc mb-4">
          The Digital landscape is very competitive in Delhi, with many businesses competing for positions across hundreds of search terms. In order to rank well in search engines you need
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <div>
              <strong class="text-white">Technical SEO –</strong>
              <span class="text-secondary"> We fix every issue that stops your website from crawling and indexing properly. We also optimise your website speed and improve your technical SEO.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <div>
              <strong class="text-white">Commercial and Transactional Keywords –</strong>
              <span class="text-secondary"> We focus on driving traffic through keywords searches that help your business to reach people searching for your products or services.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <div>
              <strong class="text-white">Local and National Visibility –</strong>
              <span class="text-secondary"> We also work on improving your visibility in Delhi NCR (Gurugram &amp; Noida) and provide opportunities to reach your business to the right audiences.</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Schedule Diagnostic Call</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">GROWTH DIAGNOSTIC ENGINE</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              LIVE CAMPAIGN MONITOR
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time telemetry measuring crawl depth, search visibility, and conversion rate velocity.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">6.2%</div>
                <div class="srv-hud-metric-label">Organic Click-Through Rate</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4.1</div>
                <div class="srv-hud-metric-label">Average Position</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">+180%</div>
                <div class="srv-hud-metric-label">Qualified Leads</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">38%</div>
                <div class="srv-hud-metric-label">Bounce Rate</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Google Search Console</span>
              <span class="srv-tool-badge">Ahrefs</span>
              <span class="srv-tool-badge">SEMrush</span>
              <span class="srv-tool-badge">Screaming Frog</span>
              <span class="srv-tool-badge">GA4</span>
              <span class="srv-tool-badge">Looker Studio</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4 — OUR SERVICES / WHAT WE OFFER (6 CARDS)
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="services-list">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>COMPREHENSIVE CAPABILITIES</span>
      </div>
      <h2 class="srv-section-title">
        Specialized SEO Services in Delhi <span class="text-brand">Built to Grow Your Business</span>
      </h2>
      <p class="srv-section-subtitle">
        Every SEO solution is designed by a professional SEO company in Delhi helps to improve your website search visibility, attract qualified traffic, and drive measurable business growth.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <!-- Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg></div>
        </div>
        <h3 class="srv-card-title">Technical SEO &amp; Site Audit</h3>
        <p class="srv-card-desc">Through technical SEO, we help your business to build a solid base for your website. To do this, we will carry out a full technical SEO audit to find any issues on your website.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Crawl and index optimization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Core Web Vitals improvement</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Schema markup implementation</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">Business Value:</span>
          <strong class="text-white">A faster, crawlable site that ranks more pages.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Technical SEO & Site Audit')) ?>"
            class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <circle cx="12" cy="12" r="6" />
              <circle cx="12" cy="12" r="2" />
            </svg></div>
        </div>
        <h3 class="srv-card-title">Local SEO Services in Delhi</h3>
        <p class="srv-card-desc">Your next customer could be just down the road, searching on their phone. We optimise your Google Business Profile, use local keywords, and manage your business listings.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Google Business Profile optimization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Local citations and NAP consistency</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Review generation strategy</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">Business Value:</span>
          <strong class="text-white">More calls, walk-ins, and direction requests.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Local SEO Services in Delhi')) ?>"
            class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="20" x2="18" y2="10" />
              <line x1="12" y1="20" x2="12" y2="4" />
              <line x1="6" y1="20" x2="6" y2="14" />
            </svg></div>
        </div>
        <h3 class="srv-card-title">On-Page SEO Services</h3>
        <p class="srv-card-desc">By on page Seo, your website content will be optimized and made for both seo friendly as well as user friendly.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Keywords and meta titles improving</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>meta descriptions, headings, and image alt text</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Quality internal linking through different pages of the website</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">Business Value:</span>
          <strong class="text-white">Improve website visibility in search engine</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('On-Page SEO Services')) ?>"
            class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
            </svg></div>
        </div>
        <h3 class="srv-card-title">E-commerce &amp; Enterprise SEO</h3>
        <p class="srv-card-desc">No matter how great your product is, it won’t matter if your customers can’t find it. We optimise your product and category pages.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Category and product page optimization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Faceted navigation handling</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Programmatic page templates</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">Business Value:</span>
          <strong class="text-white">Revenue growth without adding ad spend.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('E-commerce & Enterprise SEO')) ?>"
            class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="16 18 22 12 16 6" />
              <polyline points="8 6 2 12 8 18" />
            </svg></div>
        </div>
        <h3 class="srv-card-title">Off-Page SEO Services</h3>
        <p class="srv-card-desc">A strong online authority helps to establish credibility and increase position within the search engine results.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Quality link building</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Improving website trustworthiness to Google</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Studying your competitors and creating a strategy</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">Business Value:</span>
          <strong class="text-white">Building high domain authority of website</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Off-Page SEO Services')) ?>"
            class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 2 7 12 12 22 7 12 2" />
              <polyline points="2 17 12 22 22 17" />
              <polyline points="2 12 12 17 22 12" />
            </svg></div>
        </div>
        <h3 class="srv-card-title">SEO Content Optimisation</h3>
        <p class="srv-card-desc">Improve the content on your website, including your service page content. Also add keywords naturally and ensure every page is relevant.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Update old content to relevant content</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>relevant internal links building</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            <span>Seo friendly content</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">Business Value:</span>
          <strong class="text-white">Relevant content for users</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('SEO Content Optimisation')) ?>"
            class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12" />
              <polyline points="12 5 19 12 12 19" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5 — OUR PROCESS (6 PHASES)
     ============================================================ -->
<section class="srv-section" id="process">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>STRUCTURED EXECUTION TIMELINE</span>
      </div>
      <h2 class="srv-section-title">
        How Our SEO Company in Delhi <span class="text-brand">Delivers Results in 6 Phases</span>
      </h2>
      <p class="srv-section-subtitle">
        A clear process so you always know what happens next.
      </p>
    </div>

    <div class="srv-process-nav" role="tablist" aria-label="Process Milestones">
      <button type="button" class="srv-process-pill is-active" data-step="01"><span class="srv-pill-num">1</span> Phase 01</button>
      <button type="button" class="srv-process-pill" data-step="02"><span class="srv-pill-num">2</span> Phase 02</button>
      <button type="button" class="srv-process-pill" data-step="03"><span class="srv-pill-num">3</span> Phase 03</button>
      <button type="button" class="srv-process-pill" data-step="04"><span class="srv-pill-num">4</span> Phase 04</button>
      <button type="button" class="srv-process-pill" data-step="05"><span class="srv-pill-num">5</span> Phase 05</button>
      <button type="button" class="srv-process-pill" data-step="06"><span class="srv-pill-num">6</span> Phase 06</button>
    </div>

    <div class="srv-process-timeline">
      <div class="srv-process-card" data-step="01">
        <div class="srv-phase-badge">PHASE 01 &bull; TIMELINE: WEEK 1–2</div>
        <h3 class="srv-process-title">01. Audit &amp; Discovery</h3>
        <p class="srv-card-desc mb-3">As a seo company in delhi, We build our strategy by auditing your website current SEO performance, technical health, existing rankings, and your business competitor gaps. This helps us to identify improvement areas and opportunities for your business growth.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Technical SEO Audit</li>
            <li>Competitor Analysis Report</li>
          </ul>
        </div>
      </div>

      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; TIMELINE: WEEK 2–3</div>
        <h3 class="srv-process-title">02. Keyword &amp; Strategy</h3>
        <p class="srv-card-desc mb-3">We carry out keyword research to identify high volume and high relevance keywords. Our team also create an overall keyword strategy ensuring keywords are optimised for search intent and to attract your target audiences.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Keyword Mapping</li>
            <li>6-Month SEO Roadmap</li>
          </ul>
        </div>
      </div>

      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; TIMEFRAME: WEEKS 3-6</div>
        <h3 class="srv-process-title">03) Technical SEO Fixes</h3>
        <p class="srv-card-desc mb-3">We fix all issues on your website that could be impacting your overall performance.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Fixing technical issues on your website</li>
            <li>Schema Markup</li>
          </ul>
        </div>
      </div>

      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; TIMEFRAME: MONTHS 2-4</div>
        <h3 class="srv-process-title">04) Content and On Page SEO</h3>
        <p class="srv-card-desc mb-3">Optimise existing landing pages and create new pages for your business website, with relevant content that centred around target keywords.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Optimised Website Pages</li>
            <li>New SEO Content</li>
          </ul>
        </div>
      </div>

      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; TIMEFRAME: MONTHS 2-6</div>
        <h3 class="srv-process-title">05) Link Building</h3>
        <p class="srv-card-desc mb-3">Build your websites authority by gaining backlinks from relevant sources and building trustworthiness with Google.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Quality Backlinks</li>
            <li>Monthly Link Building Report</li>
          </ul>
        </div>
      </div>

      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; TIMELINE: ONGOING</div>
        <h3 class="srv-process-title">06) Reporting</h3>
        <p class="srv-card-desc mb-3">We continually monitor your targeted keywords, organic traffic and conversions to gain an understanding of how your campaign is performing. We then fine tune your strategy and identify new opportunities to grow.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Monthly Performance Dashboard</li>
            <li>Growth Plan</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6 — WHY CHOOSE BUSINESSDOCTOR (6 CARDS)
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="why-choose-us">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>COMPETITIVE ADVANTAGE</span>
      </div>
      <h2 class="srv-section-title">
        Why Businesses Choose BusinessDoctor <span class="text-brand">As Their SEO Company In Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Choosing an SEO company in delhi can sometimes be confusing but at Business Doctor, we provide services that focus on delivering results based around your business.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="1" x2="12" y2="23" />
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
          </svg></div>
        <h3 class="srv-card-title">01. Real result</h3>
        <p class="srv-card-desc">We focus on result driving real results to generate quality leads, conversions and more revenue for your business.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Business Focused</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
          </svg></div>
        <h3 class="srv-card-title">02. Transparent</h3>
        <p class="srv-card-desc">Your website, analytics, SEO reports and assets will always be 100% owned by you with full transparency at every stage.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">100% Owned</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="16 18 22 12 16 6" />
            <polyline points="8 6 2 12 8 18" />
          </svg></div>
        <h3 class="srv-card-title">03. Strategic</h3>
        <p class="srv-card-desc">Every campaign will be managed by expert SEO Strategists to ensure all decisions are made with your best interest at heart and a strategy is in place to drive growth.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Expertly Managed</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <circle cx="12" cy="12" r="6" />
            <circle cx="12" cy="12" r="2" />
          </svg></div>
        <h3 class="srv-card-title">04. White Hat</h3>
        <p class="srv-card-desc">We focus on driving ethical SEO strategies, quality backlinks and fully optimised SEO.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Google Friendly</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="20" x2="18" y2="10" />
            <line x1="12" y1="20" x2="12" y2="4" />
            <line x1="6" y1="20" x2="6" y2="14" />
          </svg></div>
        <h3 class="srv-card-title">05. Local Expertise</h3>
        <p class="srv-card-desc">Being a professional seo company in delhi,With our knowledge of the competitive market in Delhi we can identify opportunities to improve your search presence within the area.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Focus On Delhi NCR</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
          </svg></div>
        <h3 class="srv-card-title">06. Flexible &amp; Affordable</h3>
        <p class="srv-card-desc">As an seo company in delhi,We will create affordable SEO packages to fit around your business needs with no long term commitments.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">No Long Term Commitments</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7 — TECHNOLOGY & TOOLS WE USE (4 GROUPS)
     ============================================================ -->
<section class="srv-section" id="technologies">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>TOOLS TO WIN RANKINGS</span>
      </div>
      <h2 class="srv-section-title">
        Tools We Use to <span class="text-brand">Win Rankings</span>
      </h2>
      <p class="srv-section-subtitle">
        As a leading seo company in Delhi,We use advanced SEO tools to analyse websites, track performance, identify opportunities and build strategies backed by accurate data.
      </p>
    </div>

    <div class="srv-tech-grid">
      <!-- CARD 1 -->
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">SEO &amp; Crawl Intelligence</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Ahrefs</span>
            <span class="srv-tool-role">Backlink &amp; Keyword Research</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">SEMrush</span>
            <span class="srv-tool-role">Competitor &amp; Keyword Analysis</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Screaming Frog</span>
            <span class="srv-tool-role">Technical Website Crawling</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Search Console</span>
            <span class="srv-tool-role">Search Performance &amp; Indexing</span>
          </div>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Tracking &amp; Analytics</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Analytics 4</span>
            <span class="srv-tool-role">Organic Traffic &amp; Conversion Tracking</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Looker Studio</span>
            <span class="srv-tool-role">SEO Performance Dashboards</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Search Console</span>
            <span class="srv-tool-role">Keyword &amp; Click Performance</span>
          </div>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Website Performance</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">PageSpeed Insights</span>
            <span class="srv-tool-role">Core Web Vitals &amp; Speed Analysis</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">GTmetrix</span>
            <span class="srv-tool-role">Website Loading Performance</span>
          </div>
        </div>
      </div>

      <!-- CARD 4 -->
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">CRO &amp; Behavioural Insights</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Hotjar</span>
            <span class="srv-tool-role">Heatmaps &amp; User Session Recordings</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Microsoft Clarity</span>
            <span class="srv-tool-role">User Behaviour &amp; Interaction Analysis</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8 — INDUSTRY USE CASES (6 CARDS)
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="industry-use-cases">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>INDUSTRY SPECIALIZATION</span>
      </div>
      <h2 class="srv-section-title">
        SEO Solutions Tailored to <span class="text-brand">Your Industry</span>
      </h2>
      <p class="srv-section-subtitle">
        We solve domain-specific compliance, performance, and workflow challenges across multiple complex industries.
      </p>
    </div>

    <div class="srv-carousel-wrapper" data-carousel="use-cases">
      <div class="srv-carousel-nav-header">
        <div class="srv-carousel-kicker">
          <span class="text-brand font-mono font-bold">SECTOR ARCHITECTURES</span>
          <span class="text-muted text-sm ml-2">&bull; Interactive scroll &amp; swipe</span>
        </div>
        <div class="srv-carousel-controls">
          <button type="button" class="srv-carousel-btn srv-carousel-prev" aria-label="Previous Sector Solution"><svg
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6" />
            </svg></button>
          <button type="button" class="srv-carousel-btn srv-carousel-next" aria-label="Next Sector Solution"><svg
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="9 18 15 12 9 6" />
            </svg></button>
        </div>
      </div>
      <div class="srv-carousel-track">

        <!-- Card 1 -->
        <div class="srv-industry-card">
          <div class="srv-industry-header">
            <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
              </svg></div>
            <span class="srv-industry-tag">HEALTHCARE &amp; CLINICAL</span>
          </div>
          <h3 class="srv-card-title">Local SEO for Hospitals &amp; Clinics</h3>
          <p class="srv-card-desc">Rank for “doctor near me” and treatment searches across Delhi NCR with optimised Google Business Profiles, service pages and review strategy.</p>
          <div class="srv-industry-outcome">
            <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
            <strong class="text-brand">3.5x Growth in Patient Appointment Enquiries</strong>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="srv-industry-card">
          <div class="srv-industry-header">
            <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
              </svg></div>
            <span class="srv-industry-tag">REAL ESTATE &amp; INFRASTRUCTURE</span>
          </div>
          <h3 class="srv-card-title">High-Intent Property Lead Generation</h3>
          <p class="srv-card-desc">Capture buyers searching by location, from Gurugram to Noida, with area-based landing pages and schema-ready project listings.</p>
          <div class="srv-industry-outcome">
            <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
            <strong class="text-brand">+160% Qualified Site-Visit Enquiries</strong>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="srv-industry-card">
          <div class="srv-industry-header">
            <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="20" x2="18" y2="10" />
                <line x1="12" y1="20" x2="12" y2="4" />
                <line x1="6" y1="20" x2="6" y2="14" />
              </svg></div>
            <span class="srv-industry-tag">E-COMMERCE &amp; RETAIL</span>
          </div>
          <h3 class="srv-card-title">Catalogue SEO &amp; Organic Revenue Scaling</h3>
          <p class="srv-card-desc">Optimise category pages, product schema and site speed so thousands of SKUs rank and convert without extra ad spend.</p>
          <div class="srv-industry-outcome">
            <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
            <strong class="text-brand">+210% Organic Sales Across 5,000+ SKUs</strong>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="srv-industry-card">
          <div class="srv-industry-header">
            <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg></div>
            <span class="srv-industry-tag">EDUCATION &amp; COACHING</span>
          </div>
          <h3 class="srv-card-title">Admission-Focused Search Visibility</h3>
          <p class="srv-card-desc">Dominate course, coaching and college searches in Delhi with intent-mapped content that fills seats during admission season.</p>
          <div class="srv-industry-outcome">
            <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
            <strong class="text-brand">2.8x Increase in Admission Enquiries</strong>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="srv-industry-card">
          <div class="srv-industry-header">
            <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
              </svg></div>
            <span class="srv-industry-tag">B2B SAAS &amp; MANUFACTURING</span>
          </div>
          <h3 class="srv-card-title">Authority-Led Inbound Demand</h3>
          <p class="srv-card-desc">Rank for solution and “alternative to” searches that decision-makers use, backed by topical authority and quality backlinks.</p>
          <div class="srv-industry-outcome">
            <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
            <strong class="text-brand">4.2% Visitor-to-Demo Conversion Rate</strong>
          </div>
        </div>

        <!-- Card 6 -->
        <div class="srv-industry-card">
          <div class="srv-industry-header">
            <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
              </svg></div>
            <span class="srv-industry-tag">PROFESSIONAL SERVICES</span>
          </div>
          <h3 class="srv-card-title">Consultative Inbound for Law, Tax &amp; Finance</h3>
          <p class="srv-card-desc">Build trust and rankings for high-value queries so corporate law, CA and consulting firms receive steady inbound retainers.</p>
          <div class="srv-industry-outcome">
            <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
            <strong class="text-brand">+180% Organic Inbound Retainer Inquiries</strong>
          </div>
        </div>
      </div>
      <div class="srv-carousel-dots" aria-hidden="true"></div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 10 — INTERACTIVE FAQ ACCORDION
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="faq">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>FREQUENTLY ASKED QUESTIONS</span>
      </div>
      <h2 class="srv-section-title">
        Frequently Asked Questions <span class="text-brand">About SEO in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-0">
          <span class="srv-faq-question">1. How long does SEO take to get results?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Most of our clients will see changes in their rankings in 60-90days with us. Good consistent traffic will be seen after 4-6 months depending on the competition, keyword research and target audience.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">2. How much does an SEO company in Delhi cost?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>The price will depend on your goals, competition and how many pages your website has. As a transparent SEO company in Delhi we provide bespoke packages to help grow your business organically.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">3. Can you guarantee top rankings?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>No SEO company in Delhi can guarantee rankings as Google Algorithm updates directly affect your website rankings. We can guarantee to provide you with a clear strategy, transparent reports and measurable progress.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">4. Do you do local SEO?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes! As a full service SEO company in Delhi, we optimise your Google Business Profile, Local SEO and location pages to help boost your visibility in Delhi, Gurugram, Noida and surrounding areas.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">5. What is the difference between SEO and Google Ads?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>SEO provides you with long term organic traffic whereas Google Ads will provide you with instant rankings (but you will be paying for them). Often our SEO company in Delhi will include both to provide you with instant leads and long term growth.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 11 — FINAL CONVERSION CTA
     ============================================================ -->
<section class="srv-section srv-cta-section" id="cta">
  <div class="srv-container">
    <div class="srv-cta-card">
      <div class="srv-cta-glow"></div>
      <div class="srv-cta-content">
        <div class="srv-cta-grid-2col">
          <div>
            <div class="srv-badge mb-3">
              <span class="srv-badge-dot"></span>
              <span>TAKE THE NEXT STEP</span>
            </div>
            <h2 class="srv-cta-title">
              Ready to Eliminate Ad Waste &amp; Scale <span class="text-brand">Profitable Acquisition?</span>
            </h2>
            <p class="srv-cta-lead">
              Schedule a comprehensive growth diagnostic call. Our senior marketing architects will audit your current ad accounts, technical SEO health, and conversion funnel.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Get a Free Consultation</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="5" y1="12" x2="19" y2="12" />
                  <polyline points="12 5 19 12 12 19" />
                </svg>
              </a>
              <a href="<?= appUrl('audit.php') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Digital Audit</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polyline points="9 18 15 12 9 6" />
                </svg>
              </a>
            </div>
            <div class="srv-cta-contact-meta"
              style="justify-content: flex-start; border-top: 1px solid rgba(6, 181, 249, 0.15); padding-top: 1.5rem;">
              <div class="srv-meta-item">
                <svg class="srv-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                <span class="text-white"><?= htmlspecialchars(APP_PHONE) ?></span>
              </div>
              <div class="srv-meta-item">
                <svg class="srv-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                  <polyline points="22,6 12,13 2,6" />
                </svg>
                <span class="text-white"><?= htmlspecialchars(APP_EMAIL) ?></span>
              </div>
              <div class="srv-meta-item">
                <svg class="srv-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10" />
                  <polyline points="12 6 12 12 16 14" />
                </svg>
                <span class="text-secondary">Response Time: Under 2 Hours</span>
              </div>
            </div>
          </div>
          <div>
            <div class="srv-quick-form-card">
              <div class="srv-form-header">
                <h3 class="srv-form-title">Request Technical Consultation</h3>
                <p class="srv-form-subtitle">Direct consultation with senior enterprise architects.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_seo.php">Your Full Name</label>
                  <input type="text" id="quick_name_seo.php" name="name" required class="srv-form-input"
                    placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_seo.php">Work Email</label>
                  <input type="email" id="quick_email_seo.php" name="email" required class="srv-form-input"
                    placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_seo.php">Company / Domain</label>
                  <input type="text" id="quick_company_seo.php" name="company" class="srv-form-input"
                    placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_seo.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_seo.php" name="notes" rows="2" class="srv-form-textarea"
                    placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
                </div>
                <button type="submit" class="srv-form-submit">
                  <span>Send Consultation Request</span>
                  <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                  </svg>
                </button>
                <div class="srv-form-disclaimer">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                  </svg>
                  <span>100% strict NDA guarantee. Zero spam policy.</span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
