<?php
/**
 * BusinessDoctor Service Detail View — E-Commerce & Marketplace Management
 * Discipline 04 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Ecommerce Management';
$serviceSlug = 'ecommerce-management';
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
          <span>ECOMMERCE MANAGEMENT COMPANY IN DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          Ecommerce Management Company in Delhi <br><span class="text-brand">That Treats Your Store Like Its Own</span>
        </h1>
        <p class="srv-hero-desc">
          Running an online store takes more hours than most owners expect. BusinessDoctor is an ecommerce management company in Delhi that takes over the daily work like your website, listings, ads, orders and marketplace accounts. You focus on your product. We focus on making every sale count. No big promises, just steady work, clear reports and real profit at the end of the month.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Consultation</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
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
            <span class="srv-hero-stat-val">1 Team</span>
            <span class="srv-hero-stat-lbl">One team for everything. No running behind 5 freelancers</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">6 Channels</span>
            <span class="srv-hero-stat-lbl">Shopify, WooCommerce, Amazon, Flipkart, Myntra, Meesho</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">Profit</span>
            <span class="srv-hero-stat-lbl">Plans built around your profit, not just sales numbers</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">Delhi NCR</span>
            <span class="srv-hero-stat-lbl">Same-day support, phone calls and in-person meetings</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.studio :: ecommerce-operations-hub</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// MULTI-CHANNEL REVENUE &amp; MARGIN FLOW</text>
              <path d="M 65 180 L 150 150 L 240 160 L 330 120 L 420 135 L 520 80" stroke="#34D399" stroke-width="3" fill="none"/>
              <circle cx="520" cy="80" r="5" fill="#34D399"/>
              <text x="430" y="70" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="bold">Net Profit Focus</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// CHANNELS MANAGED</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">6 Platforms</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Amazon &bull; Flipkart &bull; Shopify &bull; D2C</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">Live Inventory &amp; Order Sync</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// LOCAL PRESENCE</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">Delhi NCR</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Dedicated Account Manager</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">Same-Day In-Person Support</text>
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
          <svg class="srv-takeaways-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          <span>What You Get With Us</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">1 Team</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">One Team for Everything</span>
          <p class="srv-takeaway-desc">No more running behind five different freelancers.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">6 Channels</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Full Ecommerce Management</span>
          <p class="srv-takeaway-desc">Shopify, WooCommerce, Amazon, Flipkart, Myntra and Meesho.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Profit First</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Built Around Your Profit</span>
          <p class="srv-takeaway-desc">Plans built around your profit, not just your sales numbers.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Monthly</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Simple Monthly Report</span>
          <p class="srv-takeaway-desc">A simple monthly report with your sales, returns, ad spend and growth.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2 — SERVICE INTRODUCTION & PHILOSOPHY
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="introduction">
  <div class="srv-container">
    <div class="srv-row srv-align-center">
      <div class="srv-col-12 srv-col-lg-6">
        <div class="srv-badge mb-3">
          <span class="srv-badge-dot"></span>
          <span>WHY WE WORK THIS WAY</span>
        </div>
        <h2 class="srv-section-title">
          Why We Work <span class="text-brand">This Way</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Online stores fail not for having a bad product but because of neglecting the little things. Weak product titles mean they can't be found by customers. Wasteful ads target the wrong products. When you try to purchase there's no stock even though the product says it's available, meaning you lose out on your order. You're getting lots of returns but no one is asking why. All of these factors are affecting your margins.
        </p>
        <p class="srv-card-desc mb-4">
          As an ecommerce management agency based in Delhi we will identify the issue causing you to lose money. We will look at your sales, ad spend, returns and shipping costs to pinpoint the main issue and sort it out. As an ecommerce management company in Delhi we measure our success by asking one question: have you made more profit this month?
        </p>
        <p class="srv-card-desc mb-4">
          We won't use any complex terms or confusing charts. You will always understand exactly what we have done, why and what has changed.
        </p>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Consultation</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">ECOMMERCE OPERATIONS TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              DAILY OPERATIONS ACTIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time monitoring across catalogue health, inventory sync, advertising efficiency, and net margin protection.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Live</div>
                <div class="srv-hud-metric-label">Stock Sync</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">6+</div>
                <div class="srv-hud-metric-label">Marketplaces</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0</div>
                <div class="srv-hud-metric-label">Hidden Terms</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Profit Focus</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Shopify</span>
              <span class="srv-tool-badge">WooCommerce</span>
              <span class="srv-tool-badge">Amazon</span>
              <span class="srv-tool-badge">Flipkart</span>
              <span class="srv-tool-badge">Myntra</span>
              <span class="srv-tool-badge">Meesho</span>
            </div>
          </div>
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
        <span>WHAT WE OFFER</span>
      </div>
      <h2 class="srv-section-title">
        Ecommerce Management Services <span class="text-brand">in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        As an ecommerce management company in Delhi, we cover everything from your first product upload to your thousand orders. Here is what we handle for you.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <h3 class="srv-card-title">Ecommerce Store Management</h3>
        <p class="srv-card-desc">Our Shopify store management service from Delhi includes adding new products, updating prices, creating promotions, changing banners and improving site speed, leaving you with an up-to-date, fast performing store to ensure your customers won’t bounce off your site.</p>
        <ul class="srv-card-list">
          <li>Product uploads, price changes and offers</li>
          <li>Banner and homepage updates</li>
          <li>Site speed and checkout fixes</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Fewer visitors leave halfway, so more of your traffic turns into orders.</span>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        </div>
        <h3 class="srv-card-title">Marketplace Management</h3>
        <p class="srv-card-desc">We are a marketplace management company based in Delhi. We offer Amazon, Flipkart, Myntra and Meesho account management. List, submit and review your products with us so they are visible and your account is secure.</p>
        <ul class="srv-card-list">
          <li>Listing and keeping checks</li>
          <li>Review and rating handling</li>
          <li>Deals and promotion planning</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Better rankings and a healthy account mean steady marketplace sales.</span>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        </div>
        <h3 class="srv-card-title">Ecommerce Catalogue Management</h3>
        <p class="srv-card-desc">Our ecommerce catalogue management services will ensure that your listings are easy to sell by providing clear search terms with relevant keywords, easy to read bullet points, accurate descriptions, proper categorisation and quality images to make it easy for shoppers to find and add your products to their basket.</p>
        <ul class="srv-card-list">
          <li>Titles and bullet points with the right keywords</li>
          <li>Clear descriptions and correct categories</li>
          <li>Sharp, clean product images</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Shoppers find you faster and click “Add to Cart” more often.</span>
        </div>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <h3 class="srv-card-title">Order and Inventory Management</h3>
        <p class="srv-card-desc">Our order and inventory management services ensure that you have accurate stock levels across all channels. Fewer cancellations, quicker dispatch and happy customers. Efficient stock management will help boost your seller rating and therefore get your listings seen by more people.</p>
        <ul class="srv-card-list">
          <li>Live stock sync across platforms</li>
          <li>Order tracking and dispatch follow-up</li>
          <li>Return and cancellation checks</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Fewer cancellations, happier buyers and better seller ratings.</span>
        </div>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8l-8 8"/><path d="M8 8h8v8"/></svg>
        </div>
        <h3 class="srv-card-title">Ecommerce Advertising</h3>
        <p class="srv-card-desc">Delhi-based ecommerce advertising agency. We manage all your Google Shopping, Meta and marketplace ads. We invest in the right products and pause the wrong ones. This helps you make the most of your ad spend and protects your margins.</p>
        <ul class="srv-card-list">
          <li>Campaigns built on your best-margin products</li>
          <li>Weekly budget and bid checks</li>
          <li>Pausing ads that don’t pay back</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Every ad rupee works harder and your margin stays safe.</span>
        </div>
      </div>

      <!-- Service Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3 class="srv-card-title">Ecommerce SEO</h3>
        <p class="srv-card-desc">Our ecommerce SEO services in Delhi will help you improve your category pages, product pages and blogs so that you gain more customers via Google without paying per click.</p>
        <ul class="srv-card-list">
          <li>Category and product page fixes</li>
          <li>Keyword-based blog content</li>
          <li>Basic technical clean-up</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>More buyers come through Google, so you depend less on paid clicks.</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5 — PROCESS FRAMEWORK
     ============================================================ -->
<section class="srv-section" id="process">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>OUR PROCESS</span>
      </div>
      <h2 class="srv-section-title">
        How We <span class="text-brand">Work</span>
      </h2>
      <p class="srv-section-subtitle">
        Here is how our ecommerce management company in Delhi takes your store from confused to consistent.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">1. Audit</h3>
          <p class="srv-step-desc">We look at your website, listings, ads and old sales. We find what is working and what is not.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Store audit report, list of money leaks, priority fix list.</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">2. Growth Plan</h3>
          <p class="srv-step-desc">We set clear goals, select the right channels for your products and make a realistic 3-Months plan.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Channel plan, monthly targets, 90-day roadmap.</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">3. Setup</h3>
          <p class="srv-step-desc">Prior to spending on advertising, we ensure your catalogue is clean, tracking is correct and your accounts are set up. This ensures any cost issues are avoided from the start.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Cleaned catalogue, working tracking, organised accounts.</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">4. Launch</h3>
          <p class="srv-step-desc">Improved listings and new ad campaigns will be created. Every change made will be recorded.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Optimised listings, live ad campaigns, change log.</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">5. Daily Management</h3>
          <p class="srv-step-desc">Every day uploads, orders, reviews, pricing and marketplace tasks will be completed.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Daily task updates, order and stock checks, review replies.</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">6. Reporting and Growth</h3>
          <p class="srv-step-desc">Each month you’ll receive a clear report. With increased budgets allocated to the winning products and any losing aspects will be removed.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Monthly performance report, budget shift plan, next-month targets.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6 — WHY CHOOSE US
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="why-choose-us">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>WHY CHOOSE US</span>
      </div>
      <h2 class="srv-section-title">
        Why Brands Pick BusinessDoctor as Their <span class="text-brand">Ecommerce Growth Agency in Delhi NCR</span>
      </h2>
      <p class="srv-section-subtitle">
        A dedicated team focused on your profit, margins, and steady daily store growth.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Local Market Knowledge Same-Day Support</div>
        <h3 class="srv-benefit-title">We Are Based in Delhi</h3>
        <p class="srv-benefit-desc">A proper ecommerce management company in Delhi should know the local market. We know how Indian buyers shop, how the festive rush hits and how local delivery works. You can also visit us and get quick answers.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">End-to-End Complete Channel Scope</div>
        <h3 class="srv-benefit-title">Many Platforms, One Plan</h3>
        <p class="srv-benefit-desc">Shopify, WooCommerce, Amazon, Flipkart and more, all under one plan and one team. No mixed messages between different vendors.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Full Transparency Real ROI Data</div>
        <h3 class="srv-benefit-title">Honest Numbers</h3>
        <p class="srv-benefit-desc">Our ecommerce management company in Delhi shows you real figures for sales, returns, ad spend and ROI. We never hide behind vague updates.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Margin Focused Profit Tracking</div>
        <h3 class="srv-benefit-title">Profit Comes First</h3>
        <p class="srv-benefit-desc">We watch your margins, shipping costs and returns. Sales that lose money are not growth, and we won’t chase them.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Dedicated Support Single Point of Contact</div>
        <h3 class="srv-benefit-title">One Account Manager</h3>
        <p class="srv-benefit-desc">At our ecommerce management company in Delhi, one person learns your business well and picks up your calls. You don’t have to explain the same thing twice.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Scalable Packages Start Small</div>
        <h3 class="srv-benefit-title">Flexible Plans</h3>
        <p class="srv-benefit-desc">New D2C brand or an old seller, our ecommerce management company in Delhi has a plan you can start small with and grow later when you see results.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7 — TECHNOLOGIES & TOOLS
     ============================================================ -->
<section class="srv-section" id="technologies">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>TOOL STACK</span>
      </div>
      <h2 class="srv-section-title">
        Tools <span class="text-brand">We Use</span>
      </h2>
      <p class="srv-section-subtitle">
        Good decisions need clean data. That’s why our ecommerce management company in Delhi works with proven tools for every part of your store.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Store Platforms</h3>
        <ul class="srv-tech-list">
          <li>Shopify - Store setup and management</li>
          <li>WooCommerce - Product and order handling</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Marketplace Tools</h3>
        <ul class="srv-tech-list">
          <li>Amazon Seller Central - Listings, orders and reviews</li>
          <li>Flipkart Seller Hub - Catalogue and promotion management</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Ads and Analytics</h3>
        <ul class="srv-tech-list">
          <li>Google Analytics - Sales and traffic tracking</li>
          <li>Meta Ads Manager - Ad campaigns and budgets</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">SEO and Research</h3>
        <ul class="srv-tech-list">
          <li>SEMrush - Keyword and competitor research</li>
          <li>Ahrefs - Ranking and backlink tracking</li>
        </ul>
      </div>
    </div>

    <div class="text-center mt-4">
      <p style="color: var(--color-text-muted); font-size: 0.95rem; max-width: 820px; margin: 0 auto;">
        We also use inventory and order tools to keep your stock right on every channel. Clean data means we guess less, decide better and protect your margin.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8 — INDUSTRY SECTORS
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="industry-use-cases">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>SECTOR EXPERTISE</span>
      </div>
      <h2 class="srv-section-title">
        Industries <span class="text-brand">We Manage</span>
      </h2>
      <p class="srv-section-subtitle">
        Our ecommerce management company in Delhi has worked with online stores in these areas:
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-card">
        <h3 class="srv-card-title">Fashion and Apparel</h3>
        <p class="srv-card-desc">We fix size charts, photos and product details so buyers pick the right fit the first time.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Fewer size-related returns and stronger festive sales.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Electronics and Accessories</h3>
        <p class="srv-card-desc">We track prices and ads daily, so you stay competitive without losing margin.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Better price control and higher ad return.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Home and Kitchen</h3>
        <p class="srv-card-desc">We write clear listings that answer size, material and use before the buyer asks.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Clearer listings and more repeat orders.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Beauty and Personal Care</h3>
        <p class="srv-card-desc">We help you collect honest reviews and keep your listings clean and compliant.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>More reviews and steady repeat buyers.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Jewellery and Gifting</h3>
        <p class="srv-card-desc">We improve photos, descriptions and festive offers so buyers feel safe ordering.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Higher buyer trust and better gifting-season sales.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Health and Wellness</h3>
        <p class="srv-card-desc">We keep your listings accurate and within marketplace rules, without making them hard to buy from.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Compliant listings and loyal customers.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">FMCG and Grocery</h3>
        <p class="srv-card-desc">We keep your stock correct and dispatch quickly, so high-volume orders don’t get cancelled.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Accurate stock and faster dispatch.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Industrial and B2B Products</h3>
        <p class="srv-card-desc">We build listings with clear specs and bulk pricing that serious business buyers look for.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Quality enquiries and bulk orders.</span>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <p style="color: var(--color-text-muted); font-size: 0.95rem; max-width: 820px; margin: 0 auto;">
        Every category sells in its own way. A jewellery buyer thinks differently from a grocery buyer. So we change the pricing, content and ads to match your products and your customers.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 9 — FREQUENTLY ASKED QUESTIONS
     ============================================================ -->
<section class="srv-section" id="faq">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>QUESTIONS &amp; ANSWERS</span>
      </div>
      <h2 class="srv-section-title">
        Questions People Ask About an <span class="text-brand">Ecommerce Management Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our ecommerce operations, marketplace management, and pricing.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">What does an ecommerce management company do?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>It runs your online selling work for you. At BusinessDoctor, an ecommerce management company in Delhi, we handle your listings, catalogue, ads, orders, stock, marketplaces and reports. You get your time back to focus on your products.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Why should I hire an ecommerce management company in Delhi?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Because local knowledge saves money. An ecommerce management company in Delhi knows how Indian buyers behave, how marketplace rules work and where deliveries usually go wrong. You can also sit across the table with your team whenever you need.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Which platforms can you manage?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>As a marketplace management company in Delhi, we work with Shopify, WooCommerce, Amazon, Flipkart, Myntra and Meesho. We can manage your own website too.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">How much do your services cost?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>The cost of our ecommerce management service will vary based on the number of products you need to sell, how many platforms you have and your advertising budget. We can give you a clear price after a free audit. No hidden fees.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How soon will I see results?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>With our ecommerce management company in Delhi, catalogue and listing fixes often show results within a few weeks. Ads and SEO build stronger and steadier growth over two to three months.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Do you offer a free audit?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Share your store or marketplace link and our ecommerce management company in Delhi will show you where you can sell more and spend less.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 10 — FINAL CONVERSION CTA
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
              Want One Team to Handle <span class="text-brand">All of This?</span>
            </h2>
            <p class="srv-cta-lead">
              Talk to an ecommerce management company in Delhi that does the work, not just the planning. Pick an ecommerce management company in Delhi NCR and you can call us or meet us the same day.
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
                  <label class="srv-form-label" for="quick_name_ecommerce-management">Your Full Name</label>
                  <input type="text" id="quick_name_ecommerce-management" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_ecommerce-management">Work Email</label>
                  <input type="email" id="quick_email_ecommerce-management" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_ecommerce-management">Company / Domain</label>
                  <input type="text" id="quick_company_ecommerce-management" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_ecommerce-management">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_ecommerce-management" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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
</section>