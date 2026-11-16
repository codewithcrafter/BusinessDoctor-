<?php
/**
 * BusinessDoctor Service Detail View — PPC / Paid Ads
 * Discipline 03 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'PPC / Paid Ads';
$serviceSlug = 'ppc-paid-ads';
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
          <span>PERFORMANCE MEDIA & PROFITABLE SCALING</span>
        </div>
        <h1 class="srv-hero-title">
          Precision Paid Advertising Engineered for <br><span class="text-brand">Maximum ROAS &amp; Lowest CAC</span>
        </h1>
        <p class="srv-hero-desc">
          We architect disciplined, data-driven paid advertising campaigns across Google Search, Performance Max, Meta Ads, and LinkedIn B2B. With server-side conversion tracking (CAPI), negative keyword architecture, and conversion rate optimization, every dollar is engineered for profitable return.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Consultation</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="#services-list" class="btn-srv-secondary">
            <span>Explore Scope</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </a>
        </div>

        <div class="srv-hero-stats">
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">3.8x+</span>
            <span class="srv-hero-stat-lbl">Verified Average ROAS</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">-40%</span>
            <span class="srv-hero-stat-lbl">Customer Acquisition Cost</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Server-Side CAPI Tracked</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">0%</span>
            <span class="srv-hero-stat-lbl">Wasted Ad Spend</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.internal :: telemetry-engine.v2</text>
              
              <rect x="50" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DISCIPLINE // 03</text>
              <text x="70" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">PPC / Paid Ads</text>
              <text x="70" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Active Execution &bull; Calibrated</text>

              <rect x="320" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="340" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// AUDIT &amp; QUALITY</text>
              <text x="340" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Enterprise SLA Standards</text>
              <text x="340" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Continuous Accountability</text>

              <line x1="280" y1="115" x2="320" y2="115" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

              <rect x="50" y="180" width="500" height="225" rx="10" fill="#051424" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
              <text x="70" y="210" fill="#34D399" font-family="monospace" font-size="12">$ execute --benchmark ppc-paid-ads</text>
              <text x="70" y="235" fill="#F5F7FA" font-family="monospace" font-size="11">&gt; 200 OK &bull; [Status: Calibrated] [Throughput: High]</text>
              <text x="70" y="260" fill="#8FA3B8" font-family="monospace" font-size="11">&gt; Core Standard: Zero Fluff, Measurable Business ROI</text>
              <text x="70" y="285" fill="#06B5F9" font-family="monospace" font-size="11">&gt; Verification Protocol: 100% Quality Assurance</text>
              <text x="70" y="310" fill="#B8C7D9" font-family="monospace" font-size="11">&gt; Operational Readiness: Verified</text>
              <text x="70" y="340" fill="#34D399" font-family="monospace" font-size="11">&gt; All Systems Active</text>
            </svg>
          </div>
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
          <span>UNIT ECONOMICS PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Why Most Companies Burn Money on Ads &mdash; <span class="text-brand">And How We Fix It</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Most digital advertising agencies focus on vanity metrics: impressions, clicks, and estimated reach. Meanwhile, client budgets are squandered on broad match keyword leakage, bot traffic, and fragmented post-iOS conversion tracking that misinforms bidding algorithms.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we treat paid advertising as a financial instrument. We establish rock-solid server-side attribution, craft high-converting landing pages, engineer negative keyword fortresses, and scale only winning ad variants that deliver positive return on ad spend (ROAS).
        </p>

        <div class="srv-feature-list mb-4">
                    <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Granular Keyword Intent:</strong> 
              <span class="text-secondary">Strict exact and phrase match structures that eliminate irrelevant query waste.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Server-Side CAPI Tracking:</strong> 
              <span class="text-secondary">100% conversion attribution via Meta Conversions API and Google Tag Manager Server-Side.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Direct-Response Ad Creative:</strong> 
              <span class="text-secondary">Psychology-backed ad copywriting, high-impact visuals, and video hooks that capture attention.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Continuous Landing Page CRO:</strong> 
              <span class="text-secondary">Dedicated landing page A/B testing to maximize conversion rates and lower cost per acquisition.</span>
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
            <span class="srv-hud-title">PAID MEDIA PERFORMANCE TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              SYSTEM STATUS: OPTIMAL
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time telemetry tracking performance velocity, conversion attribution, and brand authority.
            </p>
            <div class="srv-hud-metrics">
                            <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4.2x</div>
                <div class="srv-hud-metric-label">Blended Target ROAS</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">$18.40</div>
                <div class="srv-hud-metric-label">Target Cost Per Lead</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Conversion Event Match</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">84%</div>
                <div class="srv-hud-metric-label">Impression Share</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Google Ads</span>
<span class="srv-tool-badge">Meta Ads Manager</span>
<span class="srv-tool-badge">LinkedIn Campaign Mgr</span>
<span class="srv-tool-badge">GTM Server-Side</span>
<span class="srv-tool-badge">Triple Whale</span>
<span class="srv-tool-badge">GA4</span>

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
<section class="srv-section" id="pain-points">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>CHALLENGES SOLVED</span>
      </div>
      <h2 class="srv-section-title">
        Eliminating Costly <span class="text-brand">Paid Media Budget Waste</span>
      </h2>
      <p class="srv-section-subtitle">
        The structural tracking and targeting failures that secretly destroy advertising profitability.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Broad Match Budget Bleed</h3>
        <p class="srv-card-desc">Relying on broad keywords forces your budget to pay for completely irrelevant search terms that never convert.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Post-iOS Tracking Blindness</h3>
        <p class="srv-card-desc">Browser-only pixels lose 30-40% of conversion data, preventing ad platforms from optimizing for real buyers.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">High CAC & Weak Conversion Rates</h3>
        <p class="srv-card-desc">Sending expensive paid traffic to generic homepages rather than tailored, conversion-focused landing pages.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Ad Fatigue & Stagnant Creative</h3>
        <p class="srv-card-desc">Running the same ad creatives for months leads to audience burnout, dropping CTRs, and skyrocketing CPMs.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Unqualified B2B Lead Forms</h3>
        <p class="srv-card-desc">Generating hundreds of cheap form submissions from students and competitors instead of real decision-makers.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">No Negative Keyword Defense</h3>
        <p class="srv-card-desc">Failing to continuously audit search queries lets budget drain into "free", "login", or "jobs" searches.</p>
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
        <span>COMPREHENSIVE SCOPE</span>
      </div>
      <h2 class="srv-section-title">
        Full-Funnel <span class="text-brand">PPC &amp; Paid Media Scope</span>
      </h2>
      <p class="srv-section-subtitle">
        End-to-end campaign architecture, creative production, and daily bid management.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Google Search & Intent Harvesting</h3>
        <p class="srv-card-desc">Capturing high-intent buyers searching for your exact solutions with disciplined single-theme ad groups.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Exact & phrase match architecture</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Exhaustive negative keyword lists</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Target CPA & Target ROAS bidding</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Google Performance Max & Shopping</h3>
        <p class="srv-card-desc">Leveraging Google's AI across YouTube, Display, Search, and Maps with structured product feeds and asset groups.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Merchant Center feed optimization</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>First-party audience signal upload</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Negative placement exclusions</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Meta Direct-Response (FB & IG)</h3>
        <p class="srv-card-desc">Scalable customer acquisition across Facebook and Instagram using high-converting video and carousel creatives.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Broad audience & Advantage+ campaigns</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Retargeting with dynamic product ads</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Weekly ad creative testing sprints</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">LinkedIn ABM for B2B</h3>
        <p class="srv-card-desc">Laser-targeted advertising targeting verified decision-makers by job title, industry, company revenue, and seniority.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Account-Based Marketing lists</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Lead Gen Form frictionless capture</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Thought leadership ad amplification</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Server-Side Attribution (CAPI)</h3>
        <p class="srv-card-desc">Deploying server-side tracking via Google Cloud / AWS so ad algorithms receive 100% accurate conversion signals.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Meta Conversions API (CAPI)</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Google Ads Enhanced Conversions</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Offline conversion tracking sync</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Landing Page CRO & A/B Testing</h3>
        <p class="srv-card-desc">Designing and developing high-speed, sub-second landing pages engineered specifically for high conversion rates.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>A/B headline & offer split tests</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Frictionless multi-step forms</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Mobile conversion optimization</span></li></ul></div>

    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5 — STEP-BY-STEP PROCESS
     ============================================================ -->
<section class="srv-section" id="process">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>EXECUTION FRAMEWORK</span>
      </div>
      <h2 class="srv-section-title">
        How We Work: <span class="text-brand">Structured &amp; Accountable</span>
      </h2>
      <p class="srv-section-subtitle">
        From baseline diagnostic audit to scaled execution, our structured workflow eliminates guesswork and delivers predictable results.
      </p>
    </div>

    <div class="srv-process-grid">
            <div class="srv-process-card">
        <div class="srv-process-num">01</div>
        <h3 class="srv-process-title">Unit Economics & Tracking Audit</h3>
        <p class="srv-process-desc">We calculate your target CAC and LTV, audit existing campaigns, and verify server-side conversion tracking.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Attribution & Tracking Verified
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">02</div>
        <h3 class="srv-process-title">Audience & Keyword Modeling</h3>
        <p class="srv-process-desc">We build segmented keyword trees, draft negative keyword exclusions, and configure custom audience signals.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Campaign Structure Blueprint
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">03</div>
        <h3 class="srv-process-title">Creative & Landing Page Launch</h3>
        <p class="srv-process-desc">We produce high-impact ad creatives, write compelling copy, deploy dedicated landing pages, and launch.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Live Multi-Channel Campaign
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">04</div>
        <h3 class="srv-process-title">Algorithmic Optimization & Scale</h3>
        <p class="srv-process-desc">We prune non-performing keywords, rotate winning creative variants, and scale budget on profitable channels.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Target ROAS Achieved & Scaled
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6 — TOOLS & TECHNOLOGY
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="technology">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>TOOLING &amp; INFRASTRUCTURE</span>
      </div>
      <h2 class="srv-section-title">
        Enterprise-Grade <span class="text-brand">Tools &amp; Technology Stack</span>
      </h2>
      <p class="srv-section-subtitle">
        We utilize industry-standard platforms, diagnostic software, and proprietary telemetry tools to ensure flawless execution.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Ad Platforms</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Google Ads</span><span class="srv-tool-badge">Meta Ads Manager</span><span class="srv-tool-badge">LinkedIn Ads</span><span class="srv-tool-badge">YouTube Advertising</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Tracking & Telemetry</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">GTM Server-Side</span><span class="srv-tool-badge">Meta CAPI</span><span class="srv-tool-badge">Google Analytics 4</span><span class="srv-tool-badge">Triple Whale</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Creative & CRO</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Figma</span><span class="srv-tool-badge">Adobe Premiere Pro</span><span class="srv-tool-badge">Unbounce</span><span class="srv-tool-badge">Hotjar</span></div></div>

    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7 — INDUSTRY USE CASES
     ============================================================ -->
<section class="srv-section" id="use-cases">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>PRACTICAL APPLICATIONS</span>
      </div>
      <h2 class="srv-section-title">
        Tailored Strategies Across <span class="text-brand">Diverse Industries</span>
      </h2>
      <p class="srv-section-subtitle">
        Discover how our PPC / Paid Ads discipline drives measurable outcomes across key vertical markets.
      </p>
    </div>

    <div class="srv-grid srv-grid-2">
            <div class="srv-card">
        <span class="srv-badge mb-2"><span>Enterprise B2B Software</span></span>
        <h3 class="srv-card-title text-white">LinkedIn ABM & Google Search Pipeline</h3>
        <p class="srv-card-desc mb-3">Generated over 40 qualified demo requests per month from Fortune 1000 CTOs at an audited 45% lower CAC.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">4.8x Pipeline Revenue</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Direct-to-Consumer E-Commerce</span></span>
        <h3 class="srv-card-title text-white">Meta Scaling with Server-Side CAPI</h3>
        <p class="srv-card-desc mb-3">Scaled monthly ad spend from $15,000 to $85,000 while maintaining a consistent 4.1x blended return on ad spend.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+420% Net Monthly Sales</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>High-Ticket Local Services</span></span>
        <h3 class="srv-card-title text-white">Google Search Call-Only Campaigns</h3>
        <p class="srv-card-desc mb-3">Captured exclusive inbound commercial contractor calls with zero budget leakage to residential queries.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">120+ Verified Monthly Calls</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Financial Advisory Firm</span></span>
        <h3 class="srv-card-title text-white">Compliant Lead Funnel Optimization</h3>
        <p class="srv-card-desc mb-3">Deployed compliant high-net-worth investor lead generation funnel with multi-step qualification forms.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">$32M in New AUM Inquiries</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8 — INTERACTIVE FAQ ACCORDION
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="faq">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>FREQUENTLY ASKED QUESTIONS</span>
      </div>
      <h2 class="srv-section-title">
        Common Questions About <span class="text-brand">PPC / Paid Ads</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear answers about our methodology, timelines, deliverables, SLAs, and commercial engagement terms.
      </p>
    </div>

    <div class="srv-faq-container">
            <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">What is the minimum recommended ad budget to get started?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>We recommend a minimum media spend of $2,000 to $3,000 per month. This provides sufficient conversion data for machine-learning bidding algorithms to optimize effectively.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How quickly will we see results from PPC advertising?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Unlike SEO, PPC delivers traffic within hours of campaign launch. Predictable conversion optimization and algorithmic stabilization typically take 2 to 4 weeks of continuous testing.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Do you build dedicated landing pages for ad campaigns?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. Sending paid traffic to generic homepages cuts conversion rates in half. We design, code, and A/B test high-speed landing pages tailored specifically to each campaign.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">What is server-side conversion tracking (CAPI) and why is it needed?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Modern browser privacy updates and ad blockers block up to 40% of standard pixel tracking. Server-side CAPI sends conversion events directly from your web server to Google and Meta, restoring complete data accuracy.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Who pays the advertising platform costs (Google, Meta)?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>You pay the ad platforms directly using your own corporate credit card. You maintain 100% account ownership, data history, and transparency at all times.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How do you prevent click fraud and bot traffic?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We implement automated IP exclusion rules, restrict audience targeting strictly to validated geographies, and filter out search partner network placements known for fraudulent traffic.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">How frequently do you test new ad creatives?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We run weekly or bi-weekly creative testing cycles, testing new hooks, headlines, visual assets, and formats to stay ahead of audience fatigue.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">What reports do we receive each month?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>You receive real-time Looker Studio dashboard access and detailed monthly executive reports breaking down spend, revenue, cost per acquisition (CAC), and verified ROAS.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 9 — FINAL CONVERSION CTA
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
              Ready to Scale Profitable <span class="text-brand">Paid Customer Acquisition?</span>
            </h2>
            <p class="srv-cta-lead">
              Schedule a paid media architecture audit. Our senior performance media strategists will inspect your ad accounts, identify wasted spend, and model a high-ROAS roadmap.
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
                <h3 class="srv-form-title">Request Practice Consultation</h3>
                <p class="srv-form-subtitle">Direct consultation with senior PPC / Paid Ads strategists.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_ppc-paid-ads.php">Your Full Name</label>
                  <input type="text" id="quick_name_ppc-paid-ads.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_ppc-paid-ads.php">Work Email</label>
                  <input type="email" id="quick_email_ppc-paid-ads.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_ppc-paid-ads.php">Company / Domain</label>
                  <input type="text" id="quick_company_ppc-paid-ads.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_ppc-paid-ads.php">Project Scope &amp; Goals</label>
                  <textarea id="quick_notes_ppc-paid-ads.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your objectives, challenges, or current growth bottlenecks..."></textarea>
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