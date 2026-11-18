<?php
/**
 * BusinessDoctor Service Detail View — SMO — Social Media Optimization
 * Discipline 01 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'SMO — Social Media Optimization';
$serviceSlug = 'smo';
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
          <span>SOCIAL MEDIA OPTIMIZATION &bull; DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          SMO Company in Delhi <br><span class="text-brand">That Turns Social Reach into Qualified Leads</span>
        </h1>
        <p class="srv-hero-desc">
          We optimize your profiles, content and community so the right customers find you, trust you and enquire. BusinessDoctor is a Delhi-based SMO company built around measurable engagement, not vanity followers.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free SMO Audit</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.smo :: organic-growth-funnel</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// ORGANIC SOCIAL REACH &amp; PROFILE ENGAGEMENT</text>
              <path d="M 65 175 L 145 135 L 235 155 L 325 105 L 415 125 L 520 70" stroke="#34D399" stroke-width="3" fill="none"/>
              <circle cx="520" cy="70" r="5" fill="#34D399"/>
              <text x="430" y="60" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="bold">3x Reach Lift</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// PROFILE OPTIMIZATION</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">92%</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Profile Completeness</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">Bio Funnel &bull; Link-in-Bio Sync</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// ENGAGEMENT RATE</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">+40%</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Engagement Rate Lift</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">Organic Enquiries &bull; 100% Ownership</text>
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
          <span>KEY TAKEAWAYS AT A GLANCE</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <p style="color: var(--color-text-muted); margin-bottom: 1.5rem; font-size: 0.95rem;">
        A good SMO company in Delhi improves profile quality, content relevance and community response together, so social traffic converts into enquiries.
      </p>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">3x</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Average Reach Growth</span>
          <p class="srv-takeaway-desc">Average reach growth in the first 90 days</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">+40%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Engagement Lift</span>
          <p class="srv-takeaway-desc">Engagement rate lift after profile and content fixes</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">-25%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Lower Cost Per Lead</span>
          <p class="srv-takeaway-desc">Lower cost per lead from organic social</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Full Ownership</span>
          <p class="srv-takeaway-desc">Account ownership stays with you</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2 — PROBLEM TO SOLUTION
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="introduction">
  <div class="srv-container">
    <div class="srv-row srv-align-center">
      <div class="srv-col-12 srv-col-lg-6">
        <div class="srv-badge mb-3">
          <span class="srv-badge-dot"></span>
          <span>PROBLEM TO SOLUTION</span>
        </div>
        <h2 class="srv-section-title">
          From Scattered Posting to a <span class="text-brand">Predictable Social Lead Engine</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Many Delhi businesses post daily and still get no enquiries. The reason is rarely effort. Profiles are half-complete, content ignores what the audience searches for, and comments go unanswered. A specialist SMO company in Delhi fixes these gaps in order, so every post supports a business goal.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Profile and Bio Optimization:</strong> 
              <span class="text-secondary">Complete, keyword-aware profiles with clear offers, links and call-to-action buttons.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Content-to-Conversion Funnel:</strong> 
              <span class="text-secondary">Posts planned around awareness, trust and enquiry, each with one clear next step.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Community and Social Proof:</strong> 
              <span class="text-secondary">Fast replies, reviews and user content that build credibility.</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Schedule a Free SMO Audit</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">SOCIAL GROWTH DIAGNOSTICS</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              DIAGNOSTICS ACTIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time profile performance diagnostics and content health monitoring across target channels.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">92%</div>
                <div class="srv-hud-metric-label">Profile Completeness</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4.6%</div>
                <div class="srv-hud-metric-label">Engagement Rate</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">26/mo</div>
                <div class="srv-hud-metric-label">Posting Consistency</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">2.8%</div>
                <div class="srv-hud-metric-label">Link Click-Through</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Instagram</span>
              <span class="srv-tool-badge">LinkedIn</span>
              <span class="srv-tool-badge">Facebook</span>
              <span class="srv-tool-badge">YouTube</span>
              <span class="srv-tool-badge">X</span>
              <span class="srv-tool-badge">Pinterest</span>
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
        <span>OUR SERVICES</span>
      </div>
      <h2 class="srv-section-title">
        Social Media Optimization Services in Delhi <span class="text-brand">Built for Business Growth</span>
      </h2>
      <p class="srv-section-subtitle">
        Every service is planned around enquiries and sales, not likes alone.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <h3 class="srv-card-title">Social Media Profile Optimization</h3>
        <p class="srv-card-desc">Bio and handle keyword fit; Highlights and pinned posts; Link-in-bio and CTA setup; Brand consistency across platforms.</p>
        <ul class="srv-card-list">
          <li>Bio and handle keyword fit</li>
          <li>Highlights and pinned posts</li>
          <li>Link-in-bio and CTA setup</li>
          <li>Brand consistency across platforms</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>More profile visits turn into clicks and enquiries.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h3 class="srv-card-title">Content Strategy and Calendar</h3>
        <p class="srv-card-desc">Monthly content pillars; Reels, carousels and posts; Festival and trend planning; Brand-voice guidelines.</p>
        <ul class="srv-card-list">
          <li>Monthly content pillars</li>
          <li>Reels, carousels and posts</li>
          <li>Festival and trend planning</li>
          <li>Brand-voice guidelines</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Steady, on-brand content that keeps your audience coming back.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="9" x2="20" y2="9"/><line x1="4" y1="15" x2="20" y2="15"/><line x1="10" y1="3" x2="8" y2="21"/><line x1="16" y1="3" x2="14" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title">Social SEO, Hashtags and Keywords</h3>
        <p class="srv-card-desc">Keyword research for each platform; Hashtag sets by topic; Alt text and caption optimization; Search-friendly video titles.</p>
        <ul class="srv-card-list">
          <li>Keyword research for each platform</li>
          <li>Hashtag sets by topic</li>
          <li>Alt text and caption optimization</li>
          <li>Search-friendly video titles</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Your content appears when customers search inside social apps.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        </div>
        <h3 class="srv-card-title">Community Management and Engagement</h3>
        <p class="srv-card-desc">Comment and DM replies; Audience Q&A posts; Reputation monitoring; Lead hand-off to your sales team.</p>
        <ul class="srv-card-list">
          <li>Comment and DM replies</li>
          <li>Audience Q&A posts</li>
          <li>Reputation monitoring</li>
          <li>Lead hand-off to your sales team</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Faster responses build trust and shorten the buying decision.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3 class="srv-card-title">Influencer and Collaboration Outreach</h3>
        <p class="srv-card-desc">Micro-influencer shortlisting; Outreach and brief writing; Collaboration tracking; Content reuse rights.</p>
        <ul class="srv-card-list">
          <li>Micro-influencer shortlisting</li>
          <li>Outreach and brief writing</li>
          <li>Collaboration tracking</li>
          <li>Content reuse rights</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Borrowed audiences bring qualified traffic at lower cost.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <h3 class="srv-card-title">Analytics and Monthly Reporting</h3>
        <p class="srv-card-desc">Reach, engagement and click tracking; Competitor benchmarking; Best-time and best-format insights; Clear action list each month.</p>
        <ul class="srv-card-list">
          <li>Reach, engagement and click tracking</li>
          <li>Competitor benchmarking</li>
          <li>Best-time and best-format insights</li>
          <li>Clear action list each month</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>You see exactly what worked and where to invest next.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
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
        <span>PREDICTABLE EXECUTION TIMELINE</span>
      </div>
      <h2 class="srv-section-title">
        The 6-Phase Framework Behind Our <span class="text-brand">SMO Services in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Our SMO company in Delhi works to this plan so you always know what happens next.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 01 (Weeks 1 to 2): Audit and Benchmarking</h3>
          <p class="srv-step-desc">Profile audit; Competitor review; Audience research.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Profile audit; Competitor review; Audience research &bull; Milestone: Audit report shared</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 02 (Weeks 2 to 3): Strategy and Content Pillars</h3>
          <p class="srv-step-desc">Goal setting; Content pillars; Platform priority list.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Goal setting; Content pillars; Platform priority list &bull; Milestone: Strategy approved</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 03 (Weeks 3 to 4): Profile and Asset Setup</h3>
          <p class="srv-step-desc">Optimized bios and links; Highlights and cover designs; Hashtag and keyword library.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Optimized bios and links; Highlights and cover designs; Hashtag and keyword library &bull; Milestone: Profiles live</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 04 (Weeks 4 to 8): Publishing and Engagement</h3>
          <p class="srv-step-desc">Daily posting; Community replies; Collaboration outreach.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Daily posting; Community replies; Collaboration outreach &bull; Milestone: First 30-day cycle done</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 05 (Weeks 8 to 10): Testing and Optimization</h3>
          <p class="srv-step-desc">Format and timing tests; Caption and CTA tests; Underperformer clean-up.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Format and timing tests; Caption and CTA tests; Underperformer clean-up &bull; Milestone: Winning formats found</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 06 (Weeks 10 to 12): Reporting and Scale</h3>
          <p class="srv-step-desc">Performance dashboard; Review call; Next-quarter roadmap.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Performance dashboard; Review call; Next-quarter roadmap &bull; Milestone: Scale plan approved</span>
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
        <span>COMPETITIVE ADVANTAGE</span>
      </div>
      <h2 class="srv-section-title">
        Why Brands Choose BusinessDoctor as Their <span class="text-brand">SMO Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        We connect social media activity with business goals and report honestly on both.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Reports built on leads</div>
        <h3 class="srv-benefit-title">Zero Vanity Metrics</h3>
        <p class="srv-benefit-desc">We track enquiries, clicks and conversions, not just followers and likes.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Full admin access for you</div>
        <h3 class="srv-benefit-title">100% Account Ownership</h3>
        <p class="srv-benefit-desc">Every page, password and asset stays with you. We work as your team, not as a gatekeeper.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">No outsourced content</div>
        <h3 class="srv-benefit-title">In-House Specialists</h3>
        <p class="srv-benefit-desc">Strategists, designers, writers and video editors work under one roof.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Local and national campaigns</div>
        <h3 class="srv-benefit-title">Delhi-Market Insight</h3>
        <p class="srv-benefit-desc">We understand local buying habits, festivals and the competition in your city.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Quality checked twice</div>
        <h3 class="srv-benefit-title">Senior Review on Every Plan</h3>
        <p class="srv-benefit-desc">A senior strategist reviews each monthly plan before it goes live.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Weekly creative delivery</div>
        <h3 class="srv-benefit-title">Fast Creative Turnaround</h3>
        <p class="srv-benefit-desc">Posts, reels and carousels move from brief to approval quickly.</p>
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
        <span>TOOLS TO BE EXACT</span>
      </div>
      <h2 class="srv-section-title">
        Tools Behind Our <span class="text-brand">Social Media Optimization Company Workflow</span>
      </h2>
      <p class="srv-section-subtitle">
        We choose tools for accuracy, speed and clear reporting.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Publishing and Scheduling</h3>
        <ul class="srv-tech-list">
          <li>Meta Business Suite (Facebook and Instagram)</li>
          <li>Buffer (cross-platform scheduling)</li>
          <li>Hootsuite (team approvals)</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Analytics and Reporting</h3>
        <ul class="srv-tech-list">
          <li>Google Analytics 4 (social traffic)</li>
          <li>Looker Studio (client dashboards)</li>
          <li>Native platform insights</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Design and Creative</h3>
        <ul class="srv-tech-list">
          <li>Canva (quick posts)</li>
          <li>Adobe Photoshop (custom visuals)</li>
          <li>CapCut (short video edits)</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Social SEO and Research</h3>
        <ul class="srv-tech-list">
          <li>SEMrush (keyword and competitor data)</li>
          <li>Ahrefs (content gaps)</li>
          <li>Google Trends (topic timing)</li>
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
        <span>INDUSTRY SPECIALIZATION</span>
      </div>
      <h2 class="srv-section-title">
        Tailored SMO Services for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        Each industry needs its own tone, content type and platform mix.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <div class="srv-benefit-badge mb-2">E-COMMERCE</div>
        <h3 class="srv-card-title">D2C and Online Retail Brands</h3>
        <p class="srv-card-desc">Product reels, user content and shoppable posts that move followers toward the checkout page.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Result</span>
          <span>Higher social-to-cart clicks</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Explore This Sector &rarr;</a>
        </div>
      </div>

      <div class="srv-card">
        <div class="srv-benefit-badge mb-2">EDUCATION</div>
        <h3 class="srv-card-title">Coaching Institutes and Colleges</h3>
        <p class="srv-card-desc">Faculty videos, result stories and admission-season campaigns that bring parent and student enquiries.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Result</span>
          <span>More admission enquiries</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Explore This Sector &rarr;</a>
        </div>
      </div>

      <div class="srv-card">
        <div class="srv-benefit-badge mb-2">HEALTHCARE</div>
        <h3 class="srv-card-title">Clinics and Wellness Brands</h3>
        <p class="srv-card-desc">Patient education posts, doctor profiles and review highlights that build trust within compliance rules.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Result</span>
          <span>More appointment requests</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Explore This Sector &rarr;</a>
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
        <span>FREQUENTLY ASKED QUESTIONS</span>
      </div>
      <h2 class="srv-section-title">
        Common Questions About Hiring an <span class="text-brand">SMO Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Straight answers on timelines, budgets, platforms and reporting.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How quickly can I see results from social media optimization?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Profile fixes show effect within 2 to 4 weeks as visits and clicks improve. Steady growth in reach, engagement and enquiries usually builds over 90 days of consistent work.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">What is the difference between SMO and social media marketing?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>SMO improves your organic presence: profiles, content, hashtags and engagement. A social media marketing company in Delhi also runs paid campaigns. We offer both, and SMO is the right base before you spend on ads.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Which platforms does your SMO company in Delhi manage?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We manage Instagram, Facebook, LinkedIn, YouTube, X and Pinterest. We recommend the two or three platforms where your customers are most active instead of spreading effort thin.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Do I keep ownership of my accounts and content?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. All accounts, passwords and creative files stay in your name. We work through admin access, which you can change at any time.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">What monthly budget do I need for SMO services in Delhi?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Cost depends on the number of platforms, posting frequency and video needs. After a free audit we share a clear, fixed-scope quote with no hidden charges.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">How often will I receive reports and updates?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You receive a weekly progress note and a detailed monthly report covering reach, engagement, clicks and leads, followed by a review call.</p>
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
              Ready to Work with a Result-Driven <span class="text-brand">SMO Company in Delhi?</span>
            </h2>
            <p class="srv-cta-lead">
              Share your brand details and goals. We will send a free social media audit with clear next steps within 24 hours.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Book Your Free SMO Audit</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Digital Audit</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </a>
            </div>
            <p style="color: var(--color-accent); font-size: 0.88rem; margin-bottom: 1.5rem; font-weight: 500;">
              No contract. No obligation. Your audit is yours to keep.
            </p>
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
                <p class="srv-form-subtitle">Direct consultation with senior SMO growth architects.</p>
              </div>
              <form action="<?= appUrl('contact') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_smo">Your Full Name</label>
                  <input type="text" id="quick_name_smo" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_smo">Work Email</label>
                  <input type="email" id="quick_email_smo" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_smo">Company / Domain</label>
                  <input type="text" id="quick_company_smo" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_smo">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_smo" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your social channels, audience targets, or growth goals..."></textarea>
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