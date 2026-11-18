<?php
/**
 * BusinessDoctor Service Detail View — PPC / Paid Ads
 * Discipline 03 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'PPC / Paid Ads';
$serviceSlug = 'ppc-paid-ads';
$consultationUrl = appUrl('contact?service=' . urlencode($serviceName));
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
          <span>PPC COMPANY IN DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          PPC Company in Delhi for <br><span class="text-brand">High-ROAS Google, Meta and LinkedIn Ad Campaigns</span>
        </h1>
        <p class="srv-hero-desc">
          We are a PPC company in Delhi that runs Google, Meta and LinkedIn ads for brands that want leads and sales, not just clicks. Our team is based in Delhi NCR. We set up your campaigns, fix your tracking and send you a clear report every week. Share your ad account and we will do a free audit and send you a quote.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Audit &amp; Quote</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="#services-list" class="btn-srv-secondary">
            <span>Explore Services</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </a>
        </div>

        <div class="srv-hero-propositions">
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">Google &bull; Meta</span>
              <span class="srv-hero-prop-lbl">Google, Meta, LinkedIn - ad platforms we manage</span>
            </div>
          </div>
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">Weekly</span>
              <span class="srv-hero-prop-lbl">Weekly - performance report</span>
            </div>
          </div>
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">No Lock In</span>
              <span class="srv-hero-prop-lbl">No lock in - cancel anytime</span>
            </div>
          </div>
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">Server Side</span>
              <span class="srv-hero-prop-lbl">Server side - tracking setup included</span>
            </div>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.ads :: ppc-performance-engine</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// CAMPAIGN CONVERSION FUNNEL</text>
              <path d="M 65 170 L 150 130 L 240 150 L 330 100 L 420 120 L 520 75" stroke="#34D399" stroke-width="3" fill="none"/>
              <circle cx="520" cy="75" r="5" fill="#34D399"/>
              <text x="440" y="65" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="bold">High-ROAS</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// TRACKING ARCHITECTURE</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">Server-Side</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">CAPI &bull; GTM &bull; GA4 Tracked</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">100% Attribution Accuracy</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// CONTRACT TERMS</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">No Lock-In</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Weekly Performance Reports</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">Full Account Ownership</text>
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
          <span>Why Brands Hire BusinessDoctor as Their PPC Company in Delhi</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Revenue</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Revenue First Reporting</span>
          <p class="srv-takeaway-desc">We report on sales and cost per lead, not just clicks.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Server-Side</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Server Side Tracking</span>
          <p class="srv-takeaway-desc">You see which ad brought which enquiry.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">No Lock-In</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">No Lock In Contracts</span>
          <p class="srv-takeaway-desc">Stay because the results are good, not because you signed.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">1-on-1</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Dedicated Ad Manager</span>
          <p class="srv-takeaway-desc">One person owns your account and picks up your calls.</p>
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
          <span>DIRECT COMMERCIAL IMPACT</span>
        </div>
        <h2 class="srv-section-title">
          Hire a PPC Agency in Delhi Built for <span class="text-brand">Direct Commercial Impact</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          When you hire us as your PPC company in Delhi, one ad manager owns your account. We set up the campaigns, write the ads, fix the tracking and send a weekly report. Before you pay anything, you get a free audit of your account.
        </p>
        <p class="srv-card-desc mb-4">
          As a Google Ads company in Delhi, we do not stop at the ad. We connect every campaign to a landing page and proper conversion tracking, so you know which ad brought which enquiry and which sale.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Google Ads Management:</strong> 
              <span class="text-secondary">High-intent search and lead generation campaigns.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Meta Ads Management:</strong> 
              <span class="text-secondary">Facebook and Instagram performance sales funnels.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">LinkedIn B2B Ads:</strong> 
              <span class="text-secondary">Account-based targeting to decision makers.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Conversion Tracking and CRO:</strong> 
              <span class="text-secondary">Server-side CAPI and high-converting landing pages.</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Audit &amp; Quote</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">PPC PERFORMANCE TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              CAMPAIGNS MONITORED LIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time campaign tracking across Google, Meta, and LinkedIn with CAPI server-side sync.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Weekly</div>
                <div class="srv-hud-metric-label">Reports</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">CAPI</div>
                <div class="srv-hud-metric-label">Tracking Setup</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Account Ownership</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">High</div>
                <div class="srv-hud-metric-label">Target ROAS</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Google Ads</span>
              <span class="srv-tool-badge">Meta Ads</span>
              <span class="srv-tool-badge">LinkedIn Ads</span>
              <span class="srv-tool-badge">Performance Max</span>
              <span class="srv-tool-badge">CRO</span>
              <span class="srv-tool-badge">CAPI Tracking</span>
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
        PPC Management Services From a <span class="text-brand">Professional PPC Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Performance-engineered ad management designed to turn ad clicks into confirmed buyers and high-intent commercial enquiries.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3 class="srv-card-title">Google Ads Company in Delhi for Search and Lead Generation</h3>
        <p class="srv-card-desc">We build search campaigns around people who are ready to buy or call. Your money goes to keywords that bring real enquiries.</p>
        <ul class="srv-card-list">
          <li>Keyword research and match type plan</li>
          <li>Ad copy written for clicks and calls</li>
          <li>Negative keyword list updated every week</li>
          <li>Daily bid and budget control</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>You pay for enquiries, not random clicks.</span>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <h3 class="srv-card-title">Performance Max and Shopping Ads Company for Ecommerce Brands</h3>
        <p class="srv-card-desc">We clean up your product feed and set up Shopping and Performance Max so your best sellers get the budget.</p>
        <ul class="srv-card-list">
          <li>Product feed clean-up</li>
          <li>Asset groups by product category</li>
          <li>ROAS targets for each category</li>
          <li>Merchant Center setup and fixes</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>More orders from the same ad spend.</span>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </div>
        <h3 class="srv-card-title">Meta Ads Agency for Facebook and Instagram Sales Campaigns</h3>
        <p class="srv-card-desc">We run Meta ads that turn scrollers into buyers. We test new creatives every week so your ads do not go stale.</p>
        <ul class="srv-card-list">
          <li>Audience and look like setup</li>
          <li>Weekly creative testing</li>
          <li>Pixel and Conversions API setup</li>
          <li>Retargeting for visitors and cart drop offs</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Lower cost per sale and steady daily orders.</span>
        </div>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
        </div>
        <h3 class="srv-card-title">LinkedIn Ads Company for B2B Lead Generation</h3>
        <p class="srv-card-desc">We reach decision makers by job title, company size and industry. No spend on people who cannot buy.</p>
        <ul class="srv-card-list">
          <li>Job title and company targeting</li>
          <li>Lead gen forms people actually fill</li>
          <li>Account-based target lists</li>
          <li>CRM sync for every lead</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Your sales team gets leads worth calling.</span>
        </div>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        </div>
        <h3 class="srv-card-title">Remarketing, Display and YouTube Ads Management</h3>
        <p class="srv-card-desc">We bring back people who visited your site but did not buy, and keep your brand in front of them.</p>
        <ul class="srv-card-list">
          <li>Cart abandoner ads</li>
          <li>YouTube and Display setup</li>
          <li>Frequency caps so ads do not annoy</li>
          <li>Audience layers by buying intent</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Win back visitors you already paid for.</span>
        </div>
      </div>

      <!-- Service Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h3 class="srv-card-title">Monthly PPC Management Packages</h3>
        <p class="srv-card-desc">One fixed monthly plan for all your ad platforms. You know what you pay and what you get.</p>
        <ul class="srv-card-list">
          <li>Fixed monthly scope</li>
          <li>Weekly reports</li>
          <li>Monthly strategy call</li>
          <li>Cancel anytime</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Predictable cost and no surprises.</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5 — 6-PHASE PROCESS
     ============================================================ -->
<section class="srv-section" id="process">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>OUR PROCESS</span>
      </div>
      <h2 class="srv-section-title">
        Our 6-Phase PPC Process, <span class="text-brand">From Audit to Scale</span>
      </h2>
      <p class="srv-section-subtitle">
        Here is how our PPC company in Delhi takes your account from audit to scale.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Account and Tracking Audit</h3>
          <p class="srv-step-desc">We check your ad account, tracking and past spend to find where money is leaking.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>audit report, tracking checklist, budget leak list.</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Keyword and Audience Planning</h3>
          <p class="srv-step-desc">We pick the keywords and audiences closest to a sale and map out the campaigns.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>keyword map, audience list, campaign structure.</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Ad Creative and Landing Page</h3>
          <p class="srv-step-desc">We write the ads and suggest page changes so visitors actually enquire.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>ad copy, creative set, landing page fixes.</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Campaign Launch</h3>
          <p class="srv-step-desc">We go live only after tracking is tested and working.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>live campaigns, working conversion tracking, launch checklist.</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Optimization and Scaling</h3>
          <p class="srv-step-desc">Every week we cut weak spending and push the budget to what works.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>weekly optimizations, A/B test results, scaling plan.</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Reporting and Review</h3>
          <p class="srv-step-desc">You see the numbers in simple language, not jargon.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>live dashboard, monthly report, strategy call.</span>
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
        Why Leading Brands Choose BusinessDoctor as Their <span class="text-brand">PPC Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        A dedicated advertising team committed to lowering customer acquisition costs and driving real business revenue.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">ROAS Focused - Dedicated Manager</div>
        <h3 class="srv-benefit-title">Revenue First Account Managers</h3>
        <p class="srv-benefit-desc">Your manager at our PPC company in Delhi talks about sales and cost per lead, not clicks and impressions.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Accurate Data - CAPI Ready</div>
        <h3 class="srv-benefit-title">Server Side Tracking Setup</h3>
        <p class="srv-benefit-desc">Your data stays accurate even with browser and iOS limits.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Budget Control - Lower CAC</div>
        <h3 class="srv-benefit-title">Negative Keyword Protection</h3>
        <p class="srv-benefit-desc">We block searches that waste money and review them every week.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Real Time Reporting - Full Access</div>
        <h3 class="srv-benefit-title">Transparent Live Dashboards</h3>
        <p class="srv-benefit-desc">Check your numbers any day, without asking us.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">100% Ownership - No Lock In</div>
        <h3 class="srv-benefit-title">Ad Account Ownership With You</h3>
        <p class="srv-benefit-desc">Your ad accounts stay in your name. If you leave, everything goes with you.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">End to End - Complete Channel Scope</div>
        <h3 class="srv-benefit-title">Full Digital Team Under One Roof</h3>
        <p class="srv-benefit-desc">Need a landing page, creatives or SEO along with ads? One team handles it all.</p>
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
        Professional Tools <span class="text-brand">Our PPC Company in Delhi Uses</span>
      </h2>
      <p class="srv-section-subtitle">
        We use these tools to build, track and report on every campaign.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Ad Platforms</h3>
        <ul class="srv-tech-list">
          <li><strong>Google Ads:</strong> Search and Shopping campaigns</li>
          <li><strong>Meta Ads:</strong> Facebook and Instagram sales</li>
          <li><strong>LinkedIn Ads:</strong> B2B lead generation</li>
          <li><strong>Microsoft Ads:</strong> Bing search campaigns</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Tracking and Analytics</h3>
        <ul class="srv-tech-list">
          <li><strong>GA4:</strong> Track visitor behaviour</li>
          <li><strong>Google Tag Manager:</strong> Fire tags without code</li>
          <li><strong>Server-Side Tagging:</strong> Accurate, privacy-safe data</li>
          <li><strong>Meta CAPI:</strong> Better Meta conversion tracking</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Landing Page and CRO</h3>
        <ul class="srv-tech-list">
          <li><strong>Unbounce:</strong> Build high-converting landing pages</li>
          <li><strong>VWO:</strong> A/B test page changes</li>
          <li><strong>Hotjar:</strong> See where users drop</li>
          <li><strong>Figma:</strong> Design ad and page layouts</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Reporting and Automation</h3>
        <ul class="srv-tech-list">
          <li><strong>Looker Studio:</strong> Live performance dashboards</li>
          <li><strong>Supermetrics:</strong> Pull ad data automatically</li>
          <li><strong>CRM Integration:</strong> Sync leads to sales</li>
          <li><strong>Zapier:</strong> Automate lead follow-ups</li>
        </ul>
      </div>
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
        PPC Company in Delhi for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        Specialized performance paid advertising tailored to sector economics and high-intent buyer journeys.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <h3 class="srv-card-title">D2C and Consumer</h3>
        <p class="srv-card-desc"><strong>Ad Campaigns for D2C Brands:</strong> Sales campaigns on Meta and Google that bring repeat buyers.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>higher ROAS.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Ecommerce Sellers</h3>
        <p class="srv-card-desc"><strong>Shopping and Performance Max Ads:</strong> Product ads that push your best sellers.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>more orders from the same budget.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">B2B SaaS</h3>
        <p class="srv-card-desc"><strong>Lead Generation Ads:</strong> Search and LinkedIn campaigns for demo requests.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>lower cost per qualified lead.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Real Estate</h3>
        <p class="srv-card-desc"><strong>Property Enquiry Campaigns:</strong> Ads that reach buyers searching in your area.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>lower cost per site visit.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Education</h3>
        <p class="srv-card-desc"><strong>Admission Enquiry Ads:</strong> Campaigns timed to admission seasons.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>more admission enquiries.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Healthcare</h3>
        <p class="srv-card-desc"><strong>Appointment Booking Ads:</strong> Local ads that fill your calendar.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>quality appointment bookings.</span>
        </div>
      </div>
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
        Hiring a PPC Company in Delhi: <span class="text-brand">Your Questions Answered</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our paid advertising management, fee models, tracking, and campaign launch.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How much does a PPC company in Delhi charge?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Our fee depends on your platforms and monthly ad spend. After a free audit, we send one fixed monthly quote. Share your requirements to get yours.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How do I hire BusinessDoctor as my PPC agency?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Fill out the form, share your ad account for a free audit, and we will send a quote. That is the simplest way to hire a PPC company in Delhi.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">What does your PPC management package include?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Campaign setup, ad copy, tracking, weekly optimization, weekly reports and a monthly call. Share your requirements for a quote with the full scope.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">What is the minimum ad budget to get started?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>After the audit, we tell you honestly what budget your goal needs. Share your requirements for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How soon can you launch my campaigns after onboarding?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Once we have account access and your brief, we plan, set up and test tracking before going live. Share your requirements to start.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Do you also build landing pages for ad campaigns?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We build or fix pages made for ad traffic, so more visitors turn into enquiries. Share your requirements for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">How often do I receive performance reports?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You get a weekly report, live dashboard access and a monthly strategy call. Share your requirements for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-8">
          <span class="srv-faq-question">Do I keep ownership of my ad accounts and data?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-8" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Your ad accounts, data and creatives always stay with you. Share your requirements for a quote.</p>
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
              Ready to Scale with a High-ROAS <span class="text-brand">PPC Company in Delhi?</span>
            </h2>
            <p class="srv-cta-lead">
              Share your ad account and we will do a free audit and send you a quote. Our team is based in Delhi NCR and ready to scale your campaigns.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Get a Free Audit &amp; Quote</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Account Audit</span>
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
                <p class="srv-form-subtitle">Direct consultation with senior performance media architects.</p>
              </div>
              <form action="<?= appUrl('contact') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_ppc-paid-ads">Your Full Name</label>
                  <input type="text" id="quick_name_ppc-paid-ads" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_ppc-paid-ads">Work Email</label>
                  <input type="email" id="quick_email_ppc-paid-ads" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_ppc-paid-ads">Company / Domain</label>
                  <input type="text" id="quick_company_ppc-paid-ads" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_ppc-paid-ads">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_ppc-paid-ads" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your ad spend, target platforms, or performance bottlenecks..."></textarea>
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