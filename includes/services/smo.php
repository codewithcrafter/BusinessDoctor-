<?php
/**
 * BusinessDoctor Service Detail View — SMO — Social Media Optimization
 * Discipline 01 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'SMO — Social Media Optimization';
$serviceSlug = 'smo';
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
          <span>PROFILE ARCHITECTURE & ORGANIC CONVERSION FUNNELS</span>
        </div>
        <h1 class="srv-hero-title">
          Transforming Social Profiles into <br><span class="text-brand">High-Converting Discovery Engines</span>
        </h1>
        <p class="srv-hero-desc">
          We engineer high-converting social media profile architectures across Instagram, LinkedIn, Facebook, and YouTube: bio funnels, branded highlight structures, algorithmic keyword placement, and cross-platform link systems.
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
            <span class="srv-hero-stat-val">+140%</span>
            <span class="srv-hero-stat-lbl">Bio CTR Lift</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Brand Consistency</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">4.5x</span>
            <span class="srv-hero-stat-lbl">Organic Discovery</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">0</span>
            <span class="srv-hero-stat-lbl">Wasted Traffic Leaks</span>
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
              <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DISCIPLINE // 01</text>
              <text x="70" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">SMO — Social Media Optimization</text>
              <text x="70" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Active Execution &bull; Calibrated</text>

              <rect x="320" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="340" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// AUDIT &amp; QUALITY</text>
              <text x="340" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Enterprise SLA Standards</text>
              <text x="340" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Continuous Accountability</text>

              <line x1="280" y1="115" x2="320" y2="115" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

              <rect x="50" y="180" width="500" height="225" rx="10" fill="#051424" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
              <text x="70" y="210" fill="#34D399" font-family="monospace" font-size="12">$ execute --benchmark smo</text>
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
          <span>PROFILE CONVERSION PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Why Your Social Media Bio is Your <span class="text-brand">Most Wasted Landing Page</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Every month, hundreds or thousands of prospective clients visit your Instagram, LinkedIn, and Facebook profiles. If your bio is vague, your link-in-bio is broken or cluttered, and your story highlights are disorganized, that high-intent traffic bounces instantly.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we treat every social profile as an engineered conversion funnel. We optimize headline hooks, build clean link hierarchies, design on-brand story highlight covers, and embed high-intent search keywords so platforms recommend your brand automatically.
        </p>

        <div class="srv-feature-list mb-4">
                    <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Direct Conversion Funnels:</strong> 
              <span class="text-secondary">Turn profile visits into email subscribers, call bookings, and qualified leads.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Social SEO Indexation:</strong> 
              <span class="text-secondary">Optimize profile names, handles, and bios for in-app search engines and Google indexation.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Unified Brand Aesthetics:</strong> 
              <span class="text-secondary">Deliver consistent typography, palette tokens, and highlight icons across every touchpoint.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Cross-Platform Link Architecture:</strong> 
              <span class="text-secondary">Fast-loading, tracked link hubs that direct visitors to high-margin service offerings.</span>
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
            <span class="srv-hud-title">PROFILE OPTIMIZATION TELEMETRY</span>
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
                <div class="srv-hud-metric-num">6.4%</div>
                <div class="srv-hud-metric-label">Avg Bio Click-Through</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Search Discoverability</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num"><0.5s</div>
                <div class="srv-hud-metric-label">Link Hub Load Time</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">+85%</div>
                <div class="srv-hud-metric-label">Profile Retention Rate</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Instagram Graph</span>
<span class="srv-tool-badge">LinkedIn Pulse</span>
<span class="srv-tool-badge">Figma Tokens</span>
<span class="srv-tool-badge">Google Analytics 4</span>
<span class="srv-tool-badge">Bitly Enterprise</span>
<span class="srv-tool-badge">Linktree Pro</span>

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
        Eliminating Hidden <span class="text-brand">Social Profile Conversion Leaks</span>
      </h2>
      <p class="srv-section-subtitle">
        Common social profile oversights that drain revenue and weaken enterprise credibility.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Unclear Value Proposition</h3>
        <p class="srv-card-desc">Visitors cannot determine what your company does or why they should care within the critical first three seconds.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Cluttered Link Directories</h3>
        <p class="srv-card-desc">Sending traffic to a link tree with 15 confusing buttons causes analysis paralysis and high bounce rates.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Inconsistent Visual Identity</h3>
        <p class="srv-card-desc">Mismatched logos, amateur highlight covers, and random color schemes damage enterprise trust.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Zero Social Search Visibility</h3>
        <p class="srv-card-desc">Failing to include high-intent category keywords prevents the algorithm from recommending your profile.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Outdated Contact Channels</h3>
        <p class="srv-card-desc">Broken action buttons, disconnected WhatsApp links, and inactive email endpoints lead to lost customer inquiries.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Lack of Social Proof Highlights</h3>
        <p class="srv-card-desc">Failing to pin client testimonials, case studies, and certifications in persistent highlights kills conversions.</p>
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
        Comprehensive <span class="text-brand">SMO Deliverables & Scope</span>
      </h2>
      <p class="srv-section-subtitle">
        End-to-end technical and visual optimization across all corporate social profiles.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Social Profile & Bio Audit</h3>
        <p class="srv-card-desc">Complete structural review of all brand profiles across Instagram, LinkedIn, Facebook, and YouTube.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Competitor benchmark comparison</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Audience drop-off identification</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Action button verification</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Bio Funnel & Link Architecture</h3>
        <p class="srv-card-desc">Engineered bio copywriting and custom, high-speed tracked link hubs tailored for conversion.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Targeted CTA hook writing</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Custom tracked URL parameters</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Mobile-first loading experience</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Branded Story Highlight System</h3>
        <p class="srv-card-desc">Custom-designed highlight cover icons and curated evergreen story slides that showcase credibility.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Testimonials & case studies highlight</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Services & pricing overview</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Team & corporate culture</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Social SEO & Keyword Silos</h3>
        <p class="srv-card-desc">Placement of primary and secondary category keywords inside names, bios, and alt text.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>In-app search algorithmic rank</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Google SERP social snippet indexing</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Hashtag architecture blueprints</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Visual Grid & Template Standards</h3>
        <p class="srv-card-desc">Standardized visual assets including profile headers, avatars, and pinned banner templates.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>LinkedIn company banner graphics</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>YouTube channel art & watermark</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Standardized color & font tokens</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Engagement & Conversion Protocols</h3>
        <p class="srv-card-desc">Guidelines for pinned posts, direct message greeting automation, and outbound profile engagement.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Pinned post conversion sequencing</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Automated DM response scripts</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Monthly profile performance review</span></li></ul></div>

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
        <h3 class="srv-process-title">Profile Discovery & Audit</h3>
        <p class="srv-process-desc">We benchmark existing profiles, track bounce patterns, and identify missing SEO keywords and conversion leaks.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Comprehensive Profile Audit Report
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">02</div>
        <h3 class="srv-process-title">Bio Copywriting & Architecture</h3>
        <p class="srv-process-desc">We craft sharp, benefit-driven bios, restructure action buttons, and build custom mobile-responsive link trees.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Approved Bio & Link Matrix
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">03</div>
        <h3 class="srv-process-title">Visual Asset Production</h3>
        <p class="srv-process-desc">Our design division produces cohesive highlight icons, corporate banners, and pinned post graphics.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Complete Asset Delivery Pack
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">04</div>
        <h3 class="srv-process-title">Implementation & Indexing</h3>
        <p class="srv-process-desc">We roll out all updates across platforms, test tracking parameters, and verify search discoverability.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Full Live Deployment & Review
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
      <div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Profile Analytics & Audit</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Sprout Social</span><span class="srv-tool-badge">Iconosquare</span><span class="srv-tool-badge">Meta Business Suite</span><span class="srv-tool-badge">LinkedIn Analytics</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Visual Asset Design</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Figma</span><span class="srv-tool-badge">Adobe Illustrator</span><span class="srv-tool-badge">Photoshop</span><span class="srv-tool-badge">Canva Enterprise</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Link Hubs & Attribution</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Google Tag Manager</span><span class="srv-tool-badge">GA4 UTMs</span><span class="srv-tool-badge">Bitly Pro</span><span class="srv-tool-badge">Custom Web Funnel</span></div></div>

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
        Discover how our SMO — Social Media Optimization discipline drives measurable outcomes across key vertical markets.
      </p>
    </div>

    <div class="srv-grid srv-grid-2">
            <div class="srv-card">
        <span class="srv-badge mb-2"><span>B2B Professional Services</span></span>
        <h3 class="srv-card-title text-white">LinkedIn Executive Profile Overhaul</h3>
        <p class="srv-card-desc mb-3">Optimized corporate and leadership profiles to attract high-ticket enterprise contracts and speaking inquiries.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+210% Inbound Inquiries</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>E-Commerce Brands</span></span>
        <h3 class="srv-card-title text-white">Instagram Bio & Highlight Funnel</h3>
        <p class="srv-card-desc mb-3">Streamlined link-in-bio architecture with direct product category routing and customer review highlights.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+38% Storefront Conversion</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>SaaS Technology</span></span>
        <h3 class="srv-card-title text-white">Multi-Platform Authority Architecture</h3>
        <p class="srv-card-desc mb-3">Standardized technical social profiles across Twitter, YouTube, and LinkedIn for a fast-growing software firm.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">4x Demo Bookings from Social</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Healthcare & Wellness</span></span>
        <h3 class="srv-card-title text-white">Trust-Focused Clinic Optimization</h3>
        <p class="srv-card-desc mb-3">Organized patient testimonials, doctor credentials, and direct appointment booking buttons in highlights.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+85% Appointment Actions</span>
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
        Common Questions About <span class="text-brand">SMO — Social Media Optimization</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear answers about our methodology, timelines, deliverables, SLAs, and commercial engagement terms.
      </p>
    </div>

    <div class="srv-faq-container">
            <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">What is the difference between SMO and SMM?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>SMO (Social Media Optimization) focuses on the structural architecture, searchability, bio copywriting, and conversion funnels of your profiles. SMM (Social Media Marketing) focuses on ongoing content creation, publishing schedules, community engagement, and paid ad boosts.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Which social platforms do you optimize?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We optimize profiles across Instagram, LinkedIn (Company &amp; Personal), Facebook, YouTube, X (Twitter), and TikTok.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How long does a complete SMO overhaul take?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>A typical multi-platform SMO implementation takes 2 to 3 weeks from kickoff to final live deployment, including asset design and testing.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Do you design custom highlight covers and banner graphics?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. Every SMO package includes custom vector highlight icons, LinkedIn corporate banners, YouTube channel headers, and branded pinned graphics.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Will SMO help our profiles rank in Google search results?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. By aligning your profile names, usernames, and bios with high-intent keywords, Google frequently indexes and displays your social channels for brand and category searches.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">Can you build a custom link-in-bio landing page on our domain?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We recommend and frequently build custom lightweight mobile landing pages directly on your domain (e.g., yourdomain.com/links) for maximum SEO benefit and tracking accuracy.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Do you provide guidelines for pinned posts?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We design and script the exact 3 pinned posts every profile needs: 1) What We Do, 2) Social Proof / Case Study, and 3) How to Work With Us.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">What happens after the profiles are optimized?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We provide ongoing monthly performance tracking and quarterly profile refresh audits to align with platform algorithm changes and new service launches.</p>
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
              Ready to Turn Social Visits into <span class="text-brand">Paying Customers?</span>
            </h2>
            <p class="srv-cta-lead">
              Schedule a discovery session with our SMO architects. We will conduct a live audit of your current social profiles and deliver an actionable conversion blueprint.
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
                <p class="srv-form-subtitle">Direct consultation with senior SMO — Social Media Optimization strategists.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_smo.php">Your Full Name</label>
                  <input type="text" id="quick_name_smo.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_smo.php">Work Email</label>
                  <input type="email" id="quick_email_smo.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_smo.php">Company / Domain</label>
                  <input type="text" id="quick_company_smo.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_smo.php">Project Scope &amp; Goals</label>
                  <textarea id="quick_notes_smo.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your objectives, challenges, or current growth bottlenecks..."></textarea>
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