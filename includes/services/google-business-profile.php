<?php
/**
 * BusinessDoctor Service Detail View — Google Business Profile Management
 * Discipline 02 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Google Business Profile Management';
$serviceSlug = 'google-business-profile';
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
          <span>LOCAL 3-PACK DOMINANCE & MAPS SEARCH</span>
        </div>
        <h1 class="srv-hero-title">
          Dominating Local Search & <br><span class="text-brand">Google Maps 3-Pack Rankings</span>
        </h1>
        <p class="srv-hero-desc">
          Capture high-intent local buyers at the exact moment they search for your services. We deliver systematic Google Business Profile optimization, localized weekly posting, geotagged media distribution, automated review acceleration, and citation consistency.
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
            <span class="srv-hero-stat-val">Top 3</span>
            <span class="srv-hero-stat-lbl">Map Pack Ranking</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">+180%</span>
            <span class="srv-hero-stat-lbl">Calls & Directions</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Profile Verification</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">Weekly</span>
            <span class="srv-hero-stat-lbl">Geotagged Updates</span>
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
              <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DISCIPLINE // 02</text>
              <text x="70" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Google Business Profile Management</text>
              <text x="70" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Active Execution &bull; Calibrated</text>

              <rect x="320" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="340" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// AUDIT &amp; QUALITY</text>
              <text x="340" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Enterprise SLA Standards</text>
              <text x="340" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Continuous Accountability</text>

              <line x1="280" y1="115" x2="320" y2="115" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

              <rect x="50" y="180" width="500" height="225" rx="10" fill="#051424" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
              <text x="70" y="210" fill="#34D399" font-family="monospace" font-size="12">$ execute --benchmark google-business-profile</text>
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
          <span>LOCAL DISCOVERY ENGINE</span>
        </div>
        <h2 class="srv-section-title">
          Why Over 70% of Local Buying Decisions <span class="text-brand">Happen in the Google 3-Pack</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          When potential customers search for services in your area, Google displays the Local 3-Pack before organic search results. If your profile is poorly optimized, lacks weekly activity, or has stagnant reviews, your competitors capture all the phone calls and direction requests.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we actively manage and defend your Google Business Profile. From secondary category selection and high-resolution geotagged photo uploads to weekly product updates and review acceleration workflows, we establish undisputed local authority.
        </p>

        <div class="srv-feature-list mb-4">
                    <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Local 3-Pack Dominance:</strong> 
              <span class="text-secondary">Rank in the top 3 map results for competitive commercial keywords within your service territory.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Automated Review Velocity:</strong> 
              <span class="text-secondary">Ethical, high-conversion review request systems that steadily build 5-star customer feedback.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Geotagged Visual Content:</strong> 
              <span class="text-secondary">Professional image distribution embedded with precise EXIF geotag coordinates to strengthen geographic signals.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Weekly Localized Offers & Posts:</strong> 
              <span class="text-secondary">Regular publishing of Google Posts, event announcements, and product cards that increase search CTR.</span>
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
            <span class="srv-hud-title">LOCAL SEARCH GEO-TELEMETRY</span>
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
                <div class="srv-hud-metric-num">#1-#3</div>
                <div class="srv-hud-metric-label">Core Radius Rank</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4.8★</div>
                <div class="srv-hud-metric-label">Target Review Rating</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">+220%</div>
                <div class="srv-hud-metric-label">Search Views Lift</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">NAP Consistency</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Google Business API</span>
<span class="srv-tool-badge">BrightLocal</span>
<span class="srv-tool-badge">Whitespark</span>
<span class="srv-tool-badge">PlePer Local</span>
<span class="srv-tool-badge">GeoImgr</span>
<span class="srv-tool-badge">Local Viking</span>

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
        Overcoming Critical <span class="text-brand">Local Visibility Roadblocks</span>
      </h2>
      <p class="srv-section-subtitle">
        Common issues that cause Google Maps to suppress your local business listing.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Invisible on Google Maps</h3>
        <p class="srv-card-desc">Falling outside the top 3 results means more than 80% of local customers never discover your location.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Stagnant or Low Review Count</h3>
        <p class="srv-card-desc">Profiles with fewer than 20 reviews or stagnant recent feedback lose credibility to aggressive competitors.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Inconsistent NAP Citations</h3>
        <p class="srv-card-desc">Mismatched Name, Address, and Phone numbers across directories confuse Google's verification algorithms.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Incorrect Primary Category</h3>
        <p class="srv-card-desc">Choosing the wrong primary category immediately disqualifies your profile from ranking for core high-intent queries.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Zero Weekly Updates</h3>
        <p class="srv-card-desc">Google rewards active profiles; abandoned profiles with no recent posts suffer gradual ranking decay.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Unanswered Negative Reviews</h3>
        <p class="srv-card-desc">Leaving negative reviews unaddressed damages brand reputation and reduces prospective customer conversion.</p>
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
        Full-Service <span class="text-brand">GBP Management Scope</span>
      </h2>
      <p class="srv-section-subtitle">
        Systematic management designed to generate consistent local phone calls, visits, and inquiries.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Comprehensive Profile Optimization</h3>
        <p class="srv-card-desc">Audit and setup of primary and secondary categories, service areas, business hours, and keyword-rich descriptions.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Primary & secondary category mapping</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Complete service menu itemization</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Attributes & accessibility tags</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Weekly Google Posts & Offers</h3>
        <p class="srv-card-desc">Creation and publishing of high-converting Google updates featuring custom graphics and localized copy.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Call-to-action buttons (Call, Book)</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Special promotional offers & events</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Product showcase spotlighting</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Geotagged Photo & Video Distribution</h3>
        <p class="srv-card-desc">Uploading optimized commercial photos with calibrated EXIF metadata, geotags, and descriptive alt text.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Exterior, interior, and team photos</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>EXIF latitude/longitude embedding</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>High-resolution webp/jpeg formats</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Review Acceleration & Management</h3>
        <p class="srv-card-desc">Implementing automated review request funnels and responding professionally to all customer reviews within 24 hours.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Custom review link QR codes & SMS</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Professional sentiment responses</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Negative feedback de-escalation</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Local Citation Building & NAP Cleanup</h3>
        <p class="srv-card-desc">Building and maintaining accurate business citations across top local business directories and aggregators.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Top 50 local citation submissions</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Duplicate listing suppression</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Periodic citation health audits</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Geo-Grid Heatmap Reporting</h3>
        <p class="srv-card-desc">Monthly ranking visualization across a 5x5 to 13x13 geographic grid showing exact map positions by neighborhood.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Visual geo-grid ranking maps</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Competitor rank movement tracking</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Calls and directions telemetry</span></li></ul></div>

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
        <h3 class="srv-process-title">Verification & Baseline Audit</h3>
        <p class="srv-process-desc">We audit your profile health, verify ownership, and benchmark your current ranking across local radius coordinates.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Geo-Grid Baseline Benchmark
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">02</div>
        <h3 class="srv-process-title">Category & Listing Optimization</h3>
        <p class="srv-process-desc">We align primary and secondary categories, write keyword-rich service descriptions, and configure direct action links.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: 100% Profile Completeness
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">03</div>
        <h3 class="srv-process-title">Geotagged Media & Content Engine</h3>
        <p class="srv-process-desc">We begin weekly localized posting, upload EXIF-calibrated photography, and launch the review generation funnel.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Active Weekly Operations
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">04</div>
        <h3 class="srv-process-title">Citation Sync & Local Defense</h3>
        <p class="srv-process-desc">We synchronize NAP data across primary directories and monitor rankings continuously against local competitors.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: 3-Pack Rank Dominance
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
      <div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Local Rank Tracking</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Local Viking</span><span class="srv-tool-badge">PlePer</span><span class="srv-tool-badge">BrightLocal</span><span class="srv-tool-badge">Whitespark</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Media & Geotagging</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">GeoImgr</span><span class="srv-tool-badge">Adobe Lightroom</span><span class="srv-tool-badge">Capture One</span><span class="srv-tool-badge">ExifTool</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Citation Networks</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Data Axle</span><span class="srv-tool-badge">Yelp</span><span class="srv-tool-badge">Bing Places</span><span class="srv-tool-badge">Apple Business Connect</span></div></div>

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
        Discover how our Google Business Profile Management discipline drives measurable outcomes across key vertical markets.
      </p>
    </div>

    <div class="srv-grid srv-grid-2">
            <div class="srv-card">
        <span class="srv-badge mb-2"><span>Multi-Location Retail</span></span>
        <h3 class="srv-card-title text-white">Regional Chain 3-Pack Optimization</h3>
        <p class="srv-card-desc mb-3">Synchronized 12 store profiles across 3 cities with automated review capture and localized offers.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+145% Store Visits</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Professional Law Firm</span></span>
        <h3 class="srv-card-title text-white">High-Intent Legal Search Dominance</h3>
        <p class="srv-card-desc mb-3">Ranked #1 on Google Maps for competitive corporate litigation terms in downtown business district.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">3x Inbound Case Calls</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Healthcare Clinics</span></span>
        <h3 class="srv-card-title text-white">Medical Center Patient Acquisition</h3>
        <p class="srv-card-desc mb-3">Standardized clinic hours, doctor profiles, and built over 250 verified 5-star patient reviews.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+92% Appointment Bookings</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Commercial B2B Services</span></span>
        <h3 class="srv-card-title text-white">Industrial Service Provider Expansion</h3>
        <p class="srv-card-desc mb-3">Expanded ranking radius from 3 km to 25 km across metropolitan industrial zones.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+180% Request-a-Quote Actions</span>
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
        Common Questions About <span class="text-brand">Google Business Profile Management</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear answers about our methodology, timelines, deliverables, SLAs, and commercial engagement terms.
      </p>
    </div>

    <div class="srv-faq-container">
            <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">How long does it take to rank in the Google 3-Pack?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>Most businesses see noticeable ranking improvements within 30 to 60 days. Highly competitive metropolitan categories typically take 90 days of consistent activity and citation building to achieve stable top 3 positions.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Can you help if our Google Business Profile is suspended?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We specialize in reinstatement appeals. We audit your documentation, address policy violations, and submit compliant reinstatement requests to Google support.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How do you generate genuine Google reviews?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We provide automated review collection funnels via SMS, email, and on-site QR codes that make leaving a review effortless for satisfied customers. We never use fake reviews or violating incentives.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">What is geo-grid rank tracking?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Geo-grid tracking places a virtual grid over your city (e.g., every 1 km) and checks where your business ranks on Google Maps from each specific geographic node. This reveals exact areas where you dominate or need improvement.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Why are geotagged photos important for GBP?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Geotagged photos contain embedded GPS coordinates that signal to Google that authentic work was completed at that exact physical location, strengthening your local relevance.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How often do you publish Google Posts?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We publish 1 to 2 high-quality Google updates every week, featuring professional graphics, clear value propositions, and direct call-to-action buttons.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Do you handle multiple locations?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We manage multi-location Google Business Profile portfolios with centralized reporting, standardized branding, and unique localized content per branch.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">How do you respond to negative reviews?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We draft professional, empathetic, and de-escalating responses for your approval within 24 hours, taking difficult conversations offline while demonstrating accountability to future prospective buyers.</p>
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
              Ready to Dominate <span class="text-brand">Local Google Search?</span>
            </h2>
            <p class="srv-cta-lead">
              Request a free Local 3-Pack Audit. We will analyze your Google Business Profile, run a geo-grid rank scan, and show you exactly where competitors are outranking you.
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
                <p class="srv-form-subtitle">Direct consultation with senior Google Business Profile Management strategists.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_google-business-profile.php">Your Full Name</label>
                  <input type="text" id="quick_name_google-business-profile.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_google-business-profile.php">Work Email</label>
                  <input type="email" id="quick_email_google-business-profile.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_google-business-profile.php">Company / Domain</label>
                  <input type="text" id="quick_company_google-business-profile.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_google-business-profile.php">Project Scope &amp; Goals</label>
                  <textarea id="quick_notes_google-business-profile.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your objectives, challenges, or current growth bottlenecks..."></textarea>
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