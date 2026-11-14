<?php
/**
 * BusinessDoctor Service Detail View — Social Media Marketing
 * Discipline 07 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Social Media Marketing';
$serviceSlug = 'social-media-marketing';
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
          <span>COMMUNITY GROWTH & MULTI-PLATFORM REACH</span>
        </div>
        <h1 class="srv-hero-title">
          Building Loyal Communities & Driving <br><span class="text-brand">Omnichannel Brand Advocacy</span>
        </h1>
        <p class="srv-hero-desc">
          We create disciplined monthly social media content engines that build authentic brand authority and drive customer acquisition across LinkedIn, Instagram, Facebook, and YouTube.
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
            <span class="srv-hero-stat-val">+220%</span>
            <span class="srv-hero-stat-lbl">Social Engagement</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Publishing Consistency</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">3x</span>
            <span class="srv-hero-stat-lbl">Inbound Social DMs</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">4+</span>
            <span class="srv-hero-stat-lbl">Platforms Synced</span>
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
              <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DISCIPLINE // 07</text>
              <text x="70" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Social Media Marketing</text>
              <text x="70" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Active Execution &bull; Calibrated</text>

              <rect x="320" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="340" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// AUDIT &amp; QUALITY</text>
              <text x="340" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Enterprise SLA Standards</text>
              <text x="340" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Continuous Accountability</text>

              <line x1="280" y1="115" x2="320" y2="115" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

              <rect x="50" y="180" width="500" height="225" rx="10" fill="#051424" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
              <text x="70" y="210" fill="#34D399" font-family="monospace" font-size="12">$ execute --benchmark social-media-marketing</text>
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
          <span>COMMUNITY CENTRIC ENGINE</span>
        </div>
        <h2 class="srv-section-title">
          Why Passive Social Media Posting Fails &mdash; <span class="text-brand">And How Strategy Wins</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Randomly posting generic stock photos and corporate holiday announcements will never build an engaged audience. In modern social media algorithms, content that fails to generate comments, shares, and saves is suppressed immediately.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we build intentional editorial calendars that tell your brand's authentic story, educate your target market, and initiate real conversations. We combine thoughtful copywriting, scroll-stopping visual design, active community management, and strategic paid amplification.
        </p>

        <div class="srv-feature-list mb-4">
                    <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Strategic Editorial Calendars:</strong> 
              <span class="text-secondary">30-day proactive content planning aligned with your quarterly commercial objectives.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">High-Retention Carousels & Reels:</strong> 
              <span class="text-secondary">Educational carousels and vertical video edits designed for algorithmic reach and saves.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Proactive Community Management:</strong> 
              <span class="text-secondary">Timely response to comments and inbound DMs to turn casual followers into warm business leads.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Paid Social Amplification:</strong> 
              <span class="text-secondary">Targeted micro-budget boosts behind top-performing organic posts to expand reach profitably.</span>
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
            <span class="srv-hud-title">COMMUNITY ENGAGEMENT TELEMETRY</span>
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
                <div class="srv-hud-metric-num">4.8%</div>
                <div class="srv-hud-metric-label">Avg Engagement Rate</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Calendar On-Time SLA</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num"><1 Hr</div>
                <div class="srv-hud-metric-label">Community Response Time</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">+165%</div>
                <div class="srv-hud-metric-label">Monthly Reach Growth</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Sprout Social</span>
<span class="srv-tool-badge">Buffer Enterprise</span>
<span class="srv-tool-badge">Meta Business Suite</span>
<span class="srv-tool-badge">Figma</span>
<span class="srv-tool-badge">Notion HQ</span>
<span class="srv-tool-badge">Canva Pro</span>

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
        Solving Common <span class="text-brand">Social Media Marketing Bottlenecks</span>
      </h2>
      <p class="srv-section-subtitle">
        The challenges that prevent companies from achieving consistent brand reach and lead flow.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Inconsistent Posting Schedules</h3>
        <p class="srv-card-desc">Posting three times one week and disappearing for the next two destroys algorithmic standing and audience recall.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Boring, Corporate Stock Graphics</h3>
        <p class="srv-card-desc">Generic stock photos look like advertisements and cause users to scroll past without engaging.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Ignored Comments & Inbound DMs</h3>
        <p class="srv-card-desc">Failing to respond promptly to user comments and direct messages misses ready-to-buy customer inquiries.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Zero Revenue Attribution</h3>
        <p class="srv-card-desc">Struggling to track whether social media followers ever convert into website visitors, leads, or sales.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Lack of High-Impact Video Content</h3>
        <p class="srv-card-desc">Algorithms heavily favor Reels and Shorts; brands without a video pipeline suffer severe reach penalties.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Disjointed Multi-Platform Messaging</h3>
        <p class="srv-card-desc">Using different voices, styles, and branding across platforms confuses prospects and weakens authority.</p>
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
        Full-Service <span class="text-brand">Social Media Marketing Scope</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything required to conceptualize, design, write, publish, and manage your brand presence.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Monthly Content Strategy & Calendars</h3>
        <p class="srv-card-desc">Comprehensive 30-day editorial roadmaps defining content pillars, formats, and commercial objectives.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Audience persona research</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Content pillar breakdown (Educate, Inspire, Convert)</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Advance client review & approval workflows</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Visual Asset & Carousel Design</h3>
        <p class="srv-card-desc">Custom graphic design, infographic development, and multi-slide carousel assets engineered for high saves.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Custom branded vector templates</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Data visualization & industry charts</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Multi-slide storytelling decks</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Short-Form Video Production & Reels</h3>
        <p class="srv-card-desc">Editing vertical video reels, shorts, and behind-the-scenes clips with kinetic captions and trending audio.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Hooks & retention pacing</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Animated on-screen subtitles</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Optimized for Reels, Shorts, and TikTok</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Persuasive Social Copywriting</h3>
        <p class="srv-card-desc">Platform-specific copywriting that hooks readers in the first sentence and drives meaningful comments.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Platform tone-of-voice alignment</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Clear conversion call-to-actions</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Curated search-optimized hashtags</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Community Management & DM Nurturing</h3>
        <p class="srv-card-desc">Daily moderation of post comments, active brand engagement, and routing sales inquiries to your team.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Prompt comment responses</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Inbound direct message triage</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Outbound community engagement</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Paid Social Boost & Analytics</h3>
        <p class="srv-card-desc">Micro-boosting top-performing organic posts to lookalike audiences and delivering monthly executive reports.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>High-performing post amplification</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Audience growth & engagement metrics</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Executive monthly review call</span></li></ul></div>

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
        <h3 class="srv-process-title">Brand Persona & Tone Discovery</h3>
        <p class="srv-process-desc">We define your brand voice, content pillars, visual guidelines, and target audience personas.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Social Brand Guidelines
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">02</div>
        <h3 class="srv-process-title">30-Day Calendar Production</h3>
        <p class="srv-process-desc">We draft all copy, design visual creatives, and prepare video assets for your advance review.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Approved Content Calendar
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">03</div>
        <h3 class="srv-process-title">Scheduling & Live Publishing</h3>
        <p class="srv-process-desc">We schedule posts across platforms at peak audience activity hours and verify formatting.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Automated Publishing Pipeline
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">04</div>
        <h3 class="srv-process-title">Community Care & Performance Tuning</h3>
        <p class="srv-process-desc">We manage incoming conversations, boost top performers, and iterate on monthly engagement data.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Monthly Performance Review
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
      <div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Publishing & Scheduling</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Buffer</span><span class="srv-tool-badge">Sprout Social</span><span class="srv-tool-badge">Hootsuite</span><span class="srv-tool-badge">Meta Business Suite</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Creative Design & Video</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Figma</span><span class="srv-tool-badge">Adobe Premiere Pro</span><span class="srv-tool-badge">Photoshop</span><span class="srv-tool-badge">Canva Enterprise</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Community & Analytics</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Brand24</span><span class="srv-tool-badge">Google Analytics 4</span><span class="srv-tool-badge">Bitly Pro</span><span class="srv-tool-badge">Notion CMS</span></div></div>

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
        Discover how our Social Media Marketing discipline drives measurable outcomes across key vertical markets.
      </p>
    </div>

    <div class="srv-grid srv-grid-2">
            <div class="srv-card">
        <span class="srv-badge mb-2"><span>Technology & Software</span></span>
        <h3 class="srv-card-title text-white">LinkedIn Thought Leadership Engine</h3>
        <p class="srv-card-desc mb-3">Built an authoritative executive thought leadership engine generating over 80,000 monthly impressions.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+240% Follower Growth</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>D2C Consumer Goods</span></span>
        <h3 class="srv-card-title text-white">Instagram Aesthetic & Reels Campaign</h3>
        <p class="srv-card-desc mb-3">Transformed feed with daily lifestyle reels and carousel product breakdowns that drove viral shares.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">3.5x Organic Web Traffic</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>B2B Professional Services</span></span>
        <h3 class="srv-card-title text-white">Multi-Channel Corporate Authority</h3>
        <p class="srv-card-desc mb-3">Maintained consistent weekly publishing across LinkedIn, Twitter, and YouTube for a regional accounting firm.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">50+ Inbound Sales Inquiries</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Real Estate Development</span></span>
        <h3 class="srv-card-title text-white">Luxury Property Visual Storytelling</h3>
        <p class="srv-card-desc mb-3">Showcased architectural developments through cinematic short video and interactive story polls.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">$14M in Lead Inquiries</span>
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
        Common Questions About <span class="text-brand">Social Media Marketing</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear answers about our methodology, timelines, deliverables, SLAs, and commercial engagement terms.
      </p>
    </div>

    <div class="srv-faq-container">
            <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">How many posts per week will you create and publish?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>Our standard enterprise packages range from 3 to 5 high-quality posts per week per platform, combining carousels, video reels, and single-image announcements.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Do we have to provide all the video footage and photos?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Not necessarily. While authentic behind-the-scenes footage from your team is highly valuable, our design and creative team produces custom motion graphics, carousels, and visual templates independently.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Do we get to approve posts before they are published?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes, 100%. We provide a complete 30-day content calendar with all copy and graphics for your review and approval before any content goes live.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">How do you handle responses to customer comments and DMs?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We monitor your accounts daily, respond warmly to general comments, and immediately escalate technical or sales inquiries to your designated point of contact.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Can you manage both our company page and our executive personal profiles?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We offer combined packages that manage both your corporate brand accounts and key executive personal profiles (e.g., CEO LinkedIn thought leadership).</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How do you measure the ROI of social media marketing?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We track custom UTM links, website referral traffic, conversion events in Google Analytics 4, and direct message lead inquiries to measure real business impact.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Do you run paid advertising alongside organic social media?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We frequently micro-boost your top-performing organic posts with small paid budgets to amplify reach to verified target audiences.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">What happens if there is breaking company news we want to post immediately?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Our agile workflows include rapid-turnaround capabilities for urgent press releases, awards, or company announcements within 2 to 4 hours.</p>
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
              Ready to Build a Thriving <span class="text-brand">Social Community?</span>
            </h2>
            <p class="srv-cta-lead">
              Schedule a social strategy session. Our senior content strategists will audit your existing social footprint and present a 30-day editorial growth blueprint.
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
                <p class="srv-form-subtitle">Direct consultation with senior Social Media Marketing strategists.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_social-media-marketing.php">Your Full Name</label>
                  <input type="text" id="quick_name_social-media-marketing.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_social-media-marketing.php">Work Email</label>
                  <input type="email" id="quick_email_social-media-marketing.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_social-media-marketing.php">Company / Domain</label>
                  <input type="text" id="quick_company_social-media-marketing.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_social-media-marketing.php">Project Scope &amp; Goals</label>
                  <textarea id="quick_notes_social-media-marketing.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your objectives, challenges, or current growth bottlenecks..."></textarea>
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