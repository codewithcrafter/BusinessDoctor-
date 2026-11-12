<?php
/**
 * BusinessDoctor Service Detail View — E-Commerce & Marketplace Management
 * Discipline 04 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'E-Commerce & Marketplace Management';
$serviceSlug = 'ecommerce-marketplaces';
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
          <span>OMNICHANNEL COMMERCE &amp; MARKETPLACE SCALING</span>
        </div>
        <h1 class="srv-hero-title">
          Scaling Multi-Channel <br><span class="text-brand">E-Commerce &amp; Marketplace Dominance</span>
        </h1>
        <p class="srv-hero-desc">
          We engineer high-growth digital commerce infrastructure: bespoke D2C storefronts, Amazon &amp; Flipkart marketplace optimization, algorithmic advertising, Buy Box protection, and automated multi-channel inventory feeds.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Consultation</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="#services-list" class="btn-srv-secondary">
            <span>Explore Our Services</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </a>
        </div>

        <div class="srv-hero-stats">
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">94%+</span>
            <span class="srv-hero-stat-lbl">Average Buy Box Retention</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">4.6x</span>
            <span class="srv-hero-stat-lbl">Blended Marketplace ROAS</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">&amp;lt; 15%</span>
            <span class="srv-hero-stat-lbl">Target Amazon ACoS</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">99.9%</span>
            <span class="srv-hero-stat-lbl">Stock Sync Accuracy</span>
          </div>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hero-visual">
          <div class="srv-visual-glow"></div>
          <div class="srv-visual-frame">
            <svg viewBox="0 0 600 440" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%; height:auto; display:block;">
  <rect width="600" height="440" rx="14" fill="#071A2C"/>
  <path d="M0 44H600M0 88H600M0 132H600M0 176H600M0 220H600M0 264H600M0 308H600M0 352H600M0 396H600" stroke="#06B5F9" stroke-opacity="0.08"/>
  <path d="M60 0V440M120 0V440M180 0V440M240 0V440M300 0V440M360 0V440M420 0V440M480 0V440M540 0V440" stroke="#06B5F9" stroke-opacity="0.08"/>
  <rect width="600" height="40" rx="14" fill="#0A223B"/>
  <circle cx="28" cy="20" r="5" fill="#F87171"/><circle cx="46" cy="20" r="5" fill="#FBBF24"/><circle cx="64" cy="20" r="5" fill="#34D399"/>
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.retail :: multichannel-marketplace-hub.v2</text>

  <!-- Marketplace Hub Center -->
  <rect x="50" y="70" width="220" height="100" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// BUY BOX RETENTION</text>
  <text x="70" y="125" fill="#34D399" font-family="sans-serif" font-size="24" font-weight="900">94.2%</text>
  <text x="160" y="125" fill="#B8C7D9" font-family="monospace" font-size="11">Amazon &bull; Walmart</text>

  <rect x="330" y="70" width="220" height="100" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="350" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// CATALOG VELOCITY</text>
  <text x="350" y="125" fill="#06B5F9" font-family="sans-serif" font-size="24" font-weight="900">14,200+</text>
  <text x="450" y="125" fill="#B8C7D9" font-family="monospace" font-size="11">Active SKUs Synced</text>

  <!-- Multichannel Inventory & Ads Dashboard -->
  <rect x="50" y="190" width="500" height="215" rx="10" fill="#0A2038" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
  <text x="70" y="220" fill="#F5F7FA" font-family="sans-serif" font-size="13" font-weight="bold">Unified Inventory, ACoS &amp; Fulfillment Sync</text>
  <text x="420" y="220" fill="#06B5F9" font-family="monospace" font-size="11">LIVE TELEMETRY</text>

  <!-- Channel Nodes -->
  <rect x="70" y="240" width="130" height="50" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="80" y="260" fill="#F5F7FA" font-family="sans-serif" font-size="11" font-weight="bold">Shopify Plus Store</text>
  <text x="80" y="278" fill="#34D399" font-family="monospace" font-size="10">0.68s Headless Speed</text>

  <rect x="235" y="240" width="130" height="50" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="245" y="260" fill="#F5F7FA" font-family="sans-serif" font-size="11" font-weight="bold">Amazon FBA / SP-API</text>
  <text x="245" y="278" fill="#34D399" font-family="monospace" font-size="10">14.2% Target ACoS</text>

  <rect x="400" y="240" width="130" height="50" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="410" y="260" fill="#F5F7FA" font-family="sans-serif" font-size="11" font-weight="bold">Flipkart / Marketplaces</text>
  <text x="410" y="278" fill="#34D399" font-family="monospace" font-size="10">Auto-Inventory Sync</text>

  <!-- Bar Graph Visualization -->
  <rect x="80" y="320" width="30" height="60" rx="3" fill="#06B5F9" fill-opacity="0.3"/>
  <rect x="80" y="340" width="30" height="40" rx="3" fill="#06B5F9"/>
  <text x="82" y="395" fill="#8FA3B8" font-family="monospace" font-size="10">M1</text>

  <rect x="150" y="320" width="30" height="60" rx="3" fill="#06B5F9" fill-opacity="0.3"/>
  <rect x="150" y="325" width="30" height="55" rx="3" fill="#06B5F9"/>
  <text x="152" y="395" fill="#8FA3B8" font-family="monospace" font-size="10">M2</text>

  <rect x="220" y="320" width="30" height="60" rx="3" fill="#06B5F9" fill-opacity="0.3"/>
  <rect x="220" y="310" width="30" height="70" rx="3" fill="#06B5F9"/>
  <text x="222" y="395" fill="#8FA3B8" font-family="monospace" font-size="10">M3</text>

  <rect x="290" y="320" width="30" height="60" rx="3" fill="#06B5F9" fill-opacity="0.3"/>
  <rect x="290" y="295" width="30" height="85" rx="3" fill="#06B5F9"/>
  <text x="292" y="395" fill="#8FA3B8" font-family="monospace" font-size="10">M4</text>

  <rect x="360" y="320" width="30" height="60" rx="3" fill="#06B5F9" fill-opacity="0.3"/>
  <rect x="360" y="275" width="30" height="105" rx="3" fill="#34D399"/>
  <text x="362" y="395" fill="#8FA3B8" font-family="monospace" font-size="10">M5</text>

  <text x="420" y="340" fill="#34D399" font-family="sans-serif" font-size="16" font-weight="bold">+230% Rev</text>
  <text x="420" y="360" fill="#B8C7D9" font-family="monospace" font-size="10">Blended Net Margin</text>
</svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     KEY TAKEAWAYS & EXECUTIVE SUMMARY (Reference Feature B)
     ============================================================ -->
<section class="srv-section srv-section-takeaways" style="padding-top: 0; padding-bottom: 2.5rem;">
  <div class="srv-container">
    <div class="srv-key-takeaways">
      <div class="srv-takeaways-header">
        <div class="srv-takeaways-kicker">
          <svg class="srv-takeaways-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          <span>KEY TAKEAWAYS &bull; AT A GLANCE</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">94%+</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Average Buy Box Retention</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">4.6x</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Blended Marketplace ROAS</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">&amp;lt; 15%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Target Amazon ACoS</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">99.9%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Stock Sync Accuracy</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2 — SERVICE INTRODUCTION
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="introduction">
  <div class="srv-container">
    <div class="srv-row srv-align-center">
      <div class="srv-col-12 srv-col-lg-6">
        <div class="srv-badge mb-3">
          <span class="srv-badge-dot"></span>
          <span>RETAIL ENGINEERING FRAMEWORK</span>
        </div>
        <h2 class="srv-section-title">
          Unifying Direct-to-Consumer &amp; <span class="text-brand">Global Marketplace Scale</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Selling across your own D2C storefront, Amazon, Flipkart, and international marketplaces is fraught with inventory stockouts, margin erosion, price-war hijackers, and ad spend waste.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we treat digital retail as an integrated supply-chain and growth ecosystem. We build lightning-fast headless storefronts, optimize marketplace product rankings, deploy automated repricing algorithms, and safeguard brand equity.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Amazon &amp; Marketplace Growth Architecture:</strong> 
              <span class="text-secondary">High-conversion A+ Content, Brand Stores, listing keyword optimization, and Buy Box defense.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Sub-Second D2C Commerce Stacks:</strong> 
              <span class="text-secondary">Headless Shopify Plus, custom PHP/WooCommerce, and high-speed edge caching.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Algorithmic Sponsored Ads (PPC):</strong> 
              <span class="text-secondary">Precision Sponsored Products, Brands, and Display campaigns engineered for low ACoS.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Automated ERP &amp; Stock Synchronization:</strong> 
              <span class="text-secondary">Real-time multi-warehouse inventory sync preventing overselling and account suspensions.</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Schedule Diagnostic Call</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">COMMERCE ENGINE TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              OMNICHANNEL FEEDS SYNCED
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Live monitoring of marketplace Buy Box share, return rates, inventory velocity, and blended ad margins.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">94.2%</div>
                <div class="srv-hud-metric-label">Buy Box Share</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">13.8%</div>
                <div class="srv-hud-metric-label">Target ACoS</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.68s</div>
                <div class="srv-hud-metric-label">Checkout Latency</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">+230%</div>
                <div class="srv-hud-metric-label">YoY GMV Expansion</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Amazon SP-API</span>
              <span class="srv-tool-badge">Shopify Plus</span>
              <span class="srv-tool-badge">Helium 10</span>
              <span class="srv-tool-badge">Flipkart Ads</span>
              <span class="srv-tool-badge">WooCommerce</span>
              <span class="srv-tool-badge">Klaviyo</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 3 — PROBLEMS WE SOLVE
     ============================================================ -->
<section class="srv-section" id="problems-we-solve">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>BUSINESS CHALLENGES WE ELIMINATE</span>
      </div>
      <h2 class="srv-section-title">
        Costly Bottlenecks Holding Back <span class="text-brand">Your Growth</span>
      </h2>
      <p class="srv-section-subtitle">
        Companies frequently struggle with fragmented execution, hidden technical debt, and misaligned metrics. We dismantle these systemic obstacles.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Buy Box Suppression &amp; Unauthorized Hijackers</h3>
        <p class="srv-problem-desc">Unauthorized third-party resellers undercutting MSRP prices and triggering marketplace Buy Box suppression that cuts off your revenue.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Sudden 50-80% drops in daily sales volume and damaged brand reputation.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Amazon Brand Registry enforcement, MAP policy monitoring, and automated algorithmic repricing defenses.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Runaway Marketplace Ad Spend (High ACoS)</h3>
        <p class="srv-problem-desc">Automated broad campaigns spending budget on non-converting search terms, resulting in an advertising cost of sales (ACoS) exceeding 45%.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Net negative margins on high-volume product sales.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Strict negative search-term scripts, exact-match keyword harvesting, dayparting, and bid guardrails targeting sub-15% ACoS.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Slow D2C Storefronts &amp; High Cart Abandonment</h3>
        <p class="srv-problem-desc">Bloated apps, unoptimized product images, and multi-step mobile checkout forms causing over 75% of shoppers to leave before paying.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Burning expensive paid social ad traffic on a leaky, slow website.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Sub-second frontend architecture, instant single-page express checkout, and automated SMS/email cart recovery workflows.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Disastrous Inventory Desyncs &amp; Out-of-Stock Penalties</h3>
        <p class="srv-problem-desc">Manual stock updates between Amazon, Flipkart, and your website lead to overselling or stockouts that destroy organic search rank.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Marketplace policy violations, account health warnings, and severe organic ranking penalties.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Automated ERP/WMS API integration that synchronizes stock across all sales channels in real time.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Thin Product Listings &amp; Poor Organic Rank</h3>
        <p class="srv-problem-desc">Low-resolution images, missing backend search terms, and generic descriptions that leave your products buried on page 4 of search results.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Total dependence on paid ads to make every single sale.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Comprehensive listing engineering: keyword indexing, 3D infographic renders, lifestyle imagery, and persuasive A+ Content.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Zero Post-Purchase Retention &amp; Low LTV</h3>
        <p class="srv-problem-desc">Treating orders as one-time transactions without automated replenishment reminders or cross-selling sequences.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Inability to scale customer lifetime value against rising ad acquisition costs.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Segmentation-driven Klaviyo email/SMS retention flows, VIP loyalty incentives, and subscription repurchase funnels.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4 — OUR SERVICES / WHAT WE OFFER
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="services-list">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>COMPREHENSIVE CAPABILITIES</span>
      </div>
      <h2 class="srv-section-title">
        Specialized Services Built for <span class="text-brand">Enterprise Scale</span>
      </h2>
      <p class="srv-section-subtitle">
        Every capability is executed by veteran specialists dedicated to predictable return on investment and zero fluff.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
        </div>
        <h3 class="srv-card-title">Amazon &amp; Marketplace Management</h3>
        <p class="srv-card-desc">Full-lifecycle marketplace execution across Amazon, Flipkart, and global portals: catalog management, brand registry, listing defense, and case resolution.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Brand Registry &amp; Trademark Protection</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Listing Hijacker Removal &amp; MAP Monitoring</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>FBA Inbound Logistics Guidance</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Seller Support Dispute Resolution</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Protects your margins and secures consistent 90%+ Buy Box dominance.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Amazon & Marketplace Management')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        </div>
        <h3 class="srv-card-title">Sponsored Ads &amp; PPC Campaign Optimization</h3>
        <p class="srv-card-desc">Algorithmic advertising management designed to maximize product sales while keeping ACoS and TACoS strictly within profitable thresholds.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Sponsored Products, Brands &amp; Video</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Daily Bid Adjustments</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Competitor ASIN Conquesting Campaigns</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Dayparting &amp; Hourly Placement Control</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Scale profitable retail sales without eroding your operating margins.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Sponsored Ads & PPC Campaign Optimization')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
        </div>
        <h3 class="srv-card-title">A+ Content, Brand Stores &amp; Visual Merchandising</h3>
        <p class="srv-card-desc">High-conversion visual storytelling that elevates your brand perception above cheap generic competitors on crowded retail pages.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Premium A+ (EBC) Content Design</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Custom Multi-Page Amazon Brand Stores</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>High-Resolution 3D Infographics</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Lifestyle Feature Comparison Grids</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Boosts listing conversion rates by an average of 15% to 30%.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('A+ Content, Brand Stores & Visual Merchandising')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        </div>
        <h3 class="srv-card-title">High-Performance D2C Storefront Engineering</h3>
        <p class="srv-card-desc">Custom Shopify Plus, PHP/WooCommerce, or headless storefronts engineered for sub-second load times and frictionless mobile checkout.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Sub-Second TTFB &amp; Core Web Vitals</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>One-Click Mobile Payment Wallets (Apple Pay/UPI)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Custom Bundling &amp; Upsell Logic</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Abandoned Cart Flows</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Drives higher average order value and lowers customer acquisition costs.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('High-Performance D2C Storefront Engineering')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        </div>
        <h3 class="srv-card-title">Multi-Channel Inventory &amp; ERP Synchronization</h3>
        <p class="srv-card-desc">Automated middleware connecting your warehouse, ERP, and physical retail stores to all digital channels via modern REST and webhook APIs.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Real-Time Multi-Warehouse Stock Sync</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Low-Stock Alert Webhooks</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Unified Multi-Channel Order Routing</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Marketplace Fee Reconciliation</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Eliminates overselling, manual spreadsheets, and out-of-stock ranking penalties.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Multi-Channel Inventory & ERP Synchronization')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">Customer Retention &amp; Lifecycle Email/SMS</h3>
        <p class="srv-card-desc">Automated post-purchase marketing flows that turn first-time shoppers into profitable repeat buyers and brand advocates.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Klaviyo Behavioral Segmentation</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Predictive Replenishment Triggers</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Win-Back &amp; Lapsed Customer Sequences</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>VIP Loyalty &amp; Review Generation Flows</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Generates 25% to 40% of total revenue from zero-ad-cost owned channels.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Customer Retention & Lifecycle Email/SMS')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5 — OUR PROCESS
     ============================================================ -->
<section class="srv-section" id="process">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>STRUCTURED EXECUTION TIMELINE</span>
      </div>
      <h2 class="srv-section-title">
        The 6-Phase Engineering &amp; Delivery <span class="text-brand">Framework</span>
      </h2>
      <p class="srv-section-subtitle">
        Predictable milestones, rigorous testing checkpoints, and full visibility at every stage of the project lifecycle.
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
        <div class="srv-phase-badge">PHASE 01 &bull; WEEKS 1–2</div>
        <h3 class="srv-process-title">Marketplace &amp; Storefront Diagnostic Audit</h3>
        <p class="srv-card-desc mb-3">We audit listing quality scores, Buy Box historical retention, ad spend efficiency, inventory feed latencies, and competitor pricing.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Comprehensive Retail Health Audit</li>
            <li>Listing Keyword Gap Analysis</li>
            <li>Negative Keyword &amp; Waste Elimination List</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; WEEKS 2–3</div>
        <h3 class="srv-process-title">Listing Engineering &amp; Visual Creative Overhaul</h3>
        <p class="srv-card-desc mb-3">We rewrite product titles, bullets, and backend terms for search indexing, while designing premium A+ Content and infographic modules.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Indexed Keyword Copy Matrix</li>
            <li>A+ Enhanced Brand Content Assets</li>
            <li>Brand Store Navigation Wireframe</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; WEEKS 3–4</div>
        <h3 class="srv-process-title">Ad Campaign Restructuring &amp; Bid Guardrails</h3>
        <p class="srv-card-desc mb-3">We segment campaigns into discovery, exact-match ranking, and competitor conquesting buckets with strict target ACoS rules.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>PPC Campaign Structure Blueprint</li>
            <li>Automated Bid Rules Implementation</li>
            <li>Branded Keyword Defense Funnels</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; WEEKS 4–6</div>
        <h3 class="srv-process-title">Inventory Automation &amp; Channel Syncing</h3>
        <p class="srv-card-desc mb-3">We connect automated inventory feeds between your warehouse/Shopify and Amazon/Flipkart APIs to prevent stockouts.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Multi-Channel Inventory Webhook Setup</li>
            <li>Automated Low-Stock Alert System</li>
            <li>Order Routing Integration Verification</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; WEEKS 6–10</div>
        <h3 class="srv-process-title">Conversion Optimization &amp; Review Engine</h3>
        <p class="srv-card-desc mb-3">We deploy compliant post-purchase review generation workflows, A/B test main listing imagery, and optimize D2C checkout flows.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Automated Review Request Sequences</li>
            <li>Main Image Click-Through Split Tests</li>
            <li>Klaviyo Lifecycle Retention Flows</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; ONGOING</div>
        <h3 class="srv-process-title">Scaling, Brand Protection &amp; BI Reporting</h3>
        <p class="srv-card-desc mb-3">We monitor listing hijackers 24/7, expand into new marketplace categories, and provide real-time executive profit dashboards.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Live Margin &amp; Profit BI Dashboard</li>
            <li>24/7 Buy Box &amp; Hijacker Monitoring</li>
            <li>Monthly Strategy Growth Reviews</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6 — WHY CHOOSE BUSINESSDOCTOR
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="why-choose-us">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>COMPETITIVE ADVANTAGE</span>
      </div>
      <h2 class="srv-section-title">
        Why Leading Companies Partner with <span class="text-brand">BusinessDoctor</span>
      </h2>
      <p class="srv-section-subtitle">
        We bridge the gap between business strategy and deep technical execution, providing senior expertise without agency bloat.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
        <h3 class="srv-card-title">Full-Lifecycle Retail Engineering</h3>
        <p class="srv-card-desc">We handle everything from supply-chain inventory feeds to creative A+ design and algorithmic ad spend, providing an end-to-end partner.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">End-to-End</span>
          <span class="text-muted text-sm ms-2">Complete Channel Scope</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <h3 class="srv-card-title">Obsession with Contribution Margin</h3>
        <p class="srv-card-desc">We don’t just report gross sales; we track marketplace fees, ad spend, and cost of goods to optimize for true net bottom-line profit.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Net Profit</span>
          <span class="text-muted text-sm ms-2">Primary KPI Focus</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3 class="srv-card-title">Proactive Brand &amp; Buy Box Defense</h3>
        <p class="srv-card-desc">Our automated monitoring tools detect unauthorized sellers, counterfeiters, and pricing violations the moment they appear.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">24/7</span>
          <span class="text-muted text-sm ms-2">Automated Monitoring</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        <h3 class="srv-card-title">Deep API &amp; Developer Expertise</h3>
        <p class="srv-card-desc">Unlike creative-only agencies, our developers write directly to the Amazon Selling Partner API (SP-API) and Shopify GraphQL APIs.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Native APIs</span>
          <span class="text-muted text-sm ms-2">Direct Code Integration</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        <h3 class="srv-card-title">Proprietary Keyword Harvesting Scripts</h3>
        <p class="srv-card-desc">We continuously identify high-converting customer search terms from auto campaigns and migrate them into exact-match ranking assets.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Weekly</span>
          <span class="text-muted text-sm ms-2">Automated Search Term Mining</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        <h3 class="srv-card-title">Zero Stockout Penalties</h3>
        <p class="srv-card-desc">We engineer automated inventory safeguards to preserve your organic ranking momentum and avoid costly FBA storage overages.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">99.9%</span>
          <span class="text-muted text-sm ms-2">Stock Sync Reliability</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7 — TECHNOLOGY & TOOLS WE USE
     ============================================================ -->
<section class="srv-section" id="technologies">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>TOOLS TO BE USED</span>
      </div>
      <h2 class="srv-section-title">
        Tools to Be <span class="text-brand">Used</span>
      </h2>
      <p class="srv-section-subtitle">
        We select battle-tested, high-performance tooling suited for scale, reliability, and seamless ongoing maintenance.
      </p>
    </div>

    <div class="srv-tech-grid">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Marketplace APIs &amp; Intelligence</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Amazon SP-API</span>
            <span class="srv-tool-role">Direct Catalog &amp; Order Integration</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Helium 10</span>
            <span class="srv-tool-role">Reverse ASIN &amp; Keyword Tracking</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Jungle Scout</span>
            <span class="srv-tool-role">Market Volume &amp; Niche Spy</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Flipkart Seller Hub</span>
            <span class="srv-tool-role">Marketplace Order Management</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">D2C Commerce Platforms</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Shopify Plus</span>
            <span class="srv-tool-role">Enterprise Storefronts</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">WooCommerce / PHP 8</span>
            <span class="srv-tool-role">Custom Self-Hosted Commerce</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Stripe / Razorpay</span>
            <span class="srv-tool-role">Global Payment Gateway Sync</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Cloudflare CDN</span>
            <span class="srv-tool-role">Sub-Second Global Edge Caching</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Advertising &amp; Algorithmic Bidding</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Amazon Ads Console</span>
            <span class="srv-tool-role">Sponsored Products/Brands</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Pacvue / Perpetua</span>
            <span class="srv-tool-role">Algorithmic Bid Adjustments</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Merchant Center</span>
            <span class="srv-tool-role">Shopping Product Feeds</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Meta Advantage+ Catalog</span>
            <span class="srv-tool-role">Dynamic Retargeting Ads</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Inventory &amp; Lifecycle Marketing</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Klaviyo</span>
            <span class="srv-tool-role">Predictive Post-Purchase Flows</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Katana / Zoho Inventory</span>
            <span class="srv-tool-role">Multi-Warehouse ERP</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Gorgias</span>
            <span class="srv-tool-role">Omnichannel Customer Support</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">ShipStation</span>
            <span class="srv-tool-role">Automated Carrier Logistics</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8 — INDUSTRY USE CASES
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="industry-use-cases">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>INDUSTRY SPECIALIZATION</span>
      </div>
      <h2 class="srv-section-title">
        Tailored Solutions for <span class="text-brand">High-Growth Sectors</span>
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
          <button type="button" class="srv-carousel-btn srv-carousel-prev" aria-label="Previous Sector Solution"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg></button>
          <button type="button" class="srv-carousel-btn srv-carousel-next" aria-label="Next Sector Solution"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
      </div>
      <div class="srv-carousel-track">

      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
          <span class="srv-industry-tag">CONSUMER ELECTRONICS</span>
        </div>
        <h3 class="srv-card-title">High-Tech Multi-Channel Hardware Scaling</h3>
        <p class="srv-card-desc">Navigating high warranty inquiries, aggressive counterfeiters, and competitive PPC ad bidding in consumer gadgets.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">4.8x ROAS with 96% Buy Box Protection</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
          <span class="srv-industry-tag">LUXURY APPAREL &amp; FASHION</span>
        </div>
        <h3 class="srv-card-title">Editorial Brand Storefronts &amp;amp; Multi-Variations</h3>
        <p class="srv-card-desc">Managing complex size/color variation matrices while maintaining an elevated luxury brand aesthetic.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">32% Reduction in Return Rates via Size Guides</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <span class="srv-industry-tag">HEALTH &amp; NUTRITION (SUPPLEMENTS)</span>
        </div>
        <h3 class="srv-card-title">Strict FDA/FSSAI Compliance &amp;amp; Subscriptions</h3>
        <p class="srv-card-desc">Scaling compliant ingestible listings with automated Amazon Subscribe &amp; Save and Klaviyo repeat purchase funnels.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">38% of Revenue from Recurring Subscriptions</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
          <span class="srv-industry-tag">INDUSTRIAL &amp; B2B TOOLS</span>
        </div>
        <h3 class="srv-card-title">Heavy Catalog Synchronization (10,000+ SKUs)</h3>
        <p class="srv-card-desc">Automating bulk product specification uploads, wholesale tier pricing, and freight delivery logistics.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">+230% Top-Line Revenue Growth</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
          <span class="srv-industry-tag">HOME &amp; KITCHENWARES</span>
        </div>
        <h3 class="srv-card-title">A+ Visual Merchandising &amp;amp; Video Ads</h3>
        <p class="srv-card-desc">High-impact lifestyle photography and short-form video ads showing product durability and kitchen aesthetic.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">+34% Boost in Listing Conversion Rate</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
          <span class="srv-industry-tag">BEAUTY &amp; PERSONAL CARE</span>
        </div>
        <h3 class="srv-card-title">Omnichannel Social Commerce &amp;amp; Marketplaces</h3>
        <p class="srv-card-desc">Connecting TikTok Shop, Instagram storefronts, and Amazon FBA for frictionless multi-channel checkout.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">5.2x Blended Campaign ROAS</strong>
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
        Common Questions About <span class="text-brand">E-Commerce &amp; Marketplace Management</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">How do you prevent unauthorized sellers from hijacking our Amazon Buy Box?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>We deploy proactive 24/7 Buy Box monitoring software that alerts us within minutes of an unauthorized seller listing on your ASIN. We then execute Brand Registry copyright/trademark infringement notices, cease-and-desist documentation, and automated repricing defense rules.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Can you manage both our Amazon account and our independent D2C website?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. In fact, managing both channels under unified leadership produces the best results. We align pricing, inventory, creative photography, and customer data so that your D2C store and marketplace presence reinforce each other instead of competing.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">What is an acceptable target ACoS for marketplace advertising?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Target ACoS depends on your product gross margins and whether your goal is aggressive market share expansion or maximum immediate cash flow. For mature listings, we typically maintain a target ACoS between 12% and 18%, while total advertising cost of sales (TACoS) remains below 8%.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">How do you resolve complex Amazon Seller Support policy disputes and listing suppressions?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Our team has extensive experience preparing Plan of Action (POA) documentation, root-cause analyses, and regulatory compliance certificates required to overturn erroneous suppressions and reinstate suspended ASINs quickly.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Do you create the 3D graphics, infographics, and A+ Content in-house?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Our specialized creative production team renders 3D product visuals, designs high-converting lifestyle infographics, and drafts persuasive sales copy customized for Amazon and mobile commerce displays.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How does real-time inventory synchronization work across channels?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We deploy direct API connections between your warehouse management system (WMS) and the Amazon SP-API, Flipkart API, and Shopify GraphQL. When an item sells on any channel, inventory levels update across all channels instantly to eliminate overselling.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">What monthly retail revenue does a brand need to partner with BusinessDoctor?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We generally work with retail brands generating at least $10,000 to $500,000+ in monthly digital gross merchandise value (GMV). This scale justifies algorithmic advertising, dedicated channel management, and custom API integration.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">Who owns our marketplace accounts, customer databases, and creative assets?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You do—100%. We operate directly within your existing seller accounts and Shopify portals. All historical customer lists, advertising campaigns, and creative files remain your exclusive property.</p>
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
          Ready to Eliminate Stockouts &amp; Scale <span class="text-brand">Profitable Retail Sales?</span>
        </h2>
            <p class="srv-cta-lead">
          Schedule a comprehensive e-commerce diagnostic session. Our retail architects will audit your listing health, Buy Box share, ACoS efficiency, and supply chain APIs.
        </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Get a Free Consultation</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit.php') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Digital Audit</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </a>
            </div>
            <div class="srv-cta-contact-meta" style="justify-content: flex-start; border-top: 1px solid rgba(6, 181, 249, 0.15); padding-top: 1.5rem;">
              <div class="srv-meta-item">
                <svg class="srv-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span class="text-white"><?= htmlspecialchars(APP_PHONE) ?></span>
              </div>
              <div class="srv-meta-item">
                <svg class="srv-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <span class="text-white"><?= htmlspecialchars(APP_EMAIL) ?></span>
              </div>
              <div class="srv-meta-item">
                <svg class="srv-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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
                  <label class="srv-form-label" for="quick_name_ecommerce-marketplaces.php">Your Full Name</label>
                  <input type="text" id="quick_name_ecommerce-marketplaces.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_ecommerce-marketplaces.php">Work Email</label>
                  <input type="email" id="quick_email_ecommerce-marketplaces.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_ecommerce-marketplaces.php">Company / Domain</label>
                  <input type="text" id="quick_company_ecommerce-marketplaces.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_ecommerce-marketplaces.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_ecommerce-marketplaces.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
                </div>
                <button type="submit" class="srv-form-submit">
                  <span>Send Consultation Request</span>
                  <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
                <div class="srv-form-disclaimer">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                  <span>100% strict NDA guarantee. Zero spam policy.</span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>
