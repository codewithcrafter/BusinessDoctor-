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
          <span>Performance-Driven Social Media Marketing</span>
        </div>
        <h1 class="srv-hero-title">
          Leading Social Media Marketing Company in Delhi <br><span class="text-brand">for High-ROI Social Media Growth</span>
        </h1>
        <p class="srv-hero-desc">
          BusinessDoctor is a results-focused social media marketing company in Delhi that turns social media into a measurable revenue channel. Our team combines data-led strategy, scroll-stopping creative and precision paid campaigns to bring you qualified leads, not vanity likes.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Social Media Audit</span>
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
            <span class="srv-hero-stat-val">3.6x</span>
            <span class="srv-hero-stat-lbl">Average Campaign ROAS</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">-32%</span>
            <span class="srv-hero-stat-lbl">Cost Per Lead</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">+180%</span>
            <span class="srv-hero-stat-lbl">Organic Reach</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Transparent Reporting</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.studio :: smm-performance-pipeline</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// AUDIENCE FUNNEL CONVERSION</text>
              <path d="M 65 180 L 150 140 L 230 160 L 320 110 L 410 130 L 520 85" stroke="#34D399" stroke-width="3" fill="none"/>
              <circle cx="520" cy="85" r="5" fill="#34D399"/>
              <text x="440" y="75" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="bold">3.6x ROAS</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// CAMPAIGN METRICS</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">-32%</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Cost Per Lead (CPL)</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">Platform Sync: Meta &bull; LinkedIn</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// ORGANIC GROWTH</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">+180%</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Organic Reach &amp; Impressions</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">100% Transparent Reporting</text>
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
          <span>Key Takeaways at a Glance</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <p style="color: var(--color-text-muted); margin-bottom: 1.5rem; font-size: 0.95rem;">
        Here is why growing brands choose the best social media marketing company in Delhi for their social media growth:
      </p>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">3.6x</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">3.6x Average ROAS</span>
          <p class="srv-takeaway-desc">Paid social results for Delhi NCR brands.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">-32%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">-32% Cost Per Lead</span>
          <p class="srv-takeaway-desc">Lower costs through audience and creative testing.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">+180%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">+180% Organic Reach</span>
          <p class="srv-takeaway-desc">Reels and carousels built for platform algorithms.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">100% Transparency</span>
          <p class="srv-takeaway-desc">Live dashboards and full account ownership.</p>
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
          <span>Data-Driven Growth Philosophy</span>
        </div>
        <h2 class="srv-section-title">
          Transforming Social Media Spend into <span class="text-brand">Predictable Revenue</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Most agencies report likes, followers and impressions. These numbers look good but rarely pay the bills. As a social media marketing company in Delhi built around performance, BusinessDoctor treats every post, reel and ad as part of a revenue system with clear targets for leads, sales and customer lifetime value.
        </p>
        <p class="srv-card-desc mb-4">
          Whether you serve customers in Connaught Place, Nehru Place or across India, our social media marketing agency in Delhi aligns content, paid media and community management into one funnel. Your audience moves from first scroll to booked call without friction.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Funnel-Based Content:</strong> 
              <span class="text-secondary">Posts for every buyer stage.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Performance Paid Social:</strong> 
              <span class="text-secondary">Meta, LinkedIn and YouTube campaigns managed on cost per lead and ROAS.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Creative Built to Convert:</strong> 
              <span class="text-secondary">Reels and carousels tested weekly.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Lead Quality Tracking:</strong> 
              <span class="text-secondary">Pixel, Conversions API and CRM show which post produced each lead.</span>
            </div>
          </div>
        </div>

        <p class="srv-card-desc mb-4">
          Choosing the right social media marketing company in Delhi means finding a team that is accountable for revenue. Our strategists, designers and ad specialists work as one unit with a single plan and a single report.
        </p>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Schedule a Discovery Call</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">TARGET BENCHMARKS</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              METRICS LIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Performance telemetry tracking engagement, conversion rates, cost efficiency, and response speeds across active campaigns.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4.8%</div>
                <div class="srv-hud-metric-label">Engagement Rate</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">2.9%</div>
                <div class="srv-hud-metric-label">Click-Through Rate</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">₹210</div>
                <div class="srv-hud-metric-label">Cost Per Lead</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.8s</div>
                <div class="srv-hud-metric-label">Page Load</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Instagram</span>
              <span class="srv-tool-badge">Facebook</span>
              <span class="srv-tool-badge">LinkedIn</span>
              <span class="srv-tool-badge">YouTube</span>
              <span class="srv-tool-badge">X</span>
              <span class="srv-tool-badge">WhatsApp Business</span>
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
        Social Media Marketing Services in Delhi <span class="text-brand">Built to Scale Your Brand</span>
      </h2>
      <p class="srv-section-subtitle">
        Every service from our social media marketing company in Delhi is led by senior specialists and tied to clear targets for leads and revenue.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        <h3 class="srv-card-title">1. Social Media Strategy &amp; Audit</h3>
        <p class="srv-card-desc">We study your brand, competitors and audience to build a 90-day roadmap with clear goals and content pillars.</p>
        <ul class="srv-card-list">
          <li>Competitor Research</li>
          <li>Content Pillars</li>
          <li>Monthly Calendar</li>
          <li>KPI Mapping</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>A clear plan that focuses your budget on what grows the business.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        </div>
        <h3 class="srv-card-title">2. Content Creation &amp; Reels Production</h3>
        <p class="srv-card-desc">As an Instagram marketing agency in Delhi, we produce posts, carousels and Reels in your brand voice.</p>
        <ul class="srv-card-list">
          <li>Reels and Short Video</li>
          <li>Carousel Design</li>
          <li>Captions and Hashtags</li>
          <li>Story Templates</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Consistent, high-quality content that builds trust.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <h3 class="srv-card-title">3. Paid Social Advertising</h3>
        <p class="srv-card-desc">Our Facebook ads agency in Delhi plans and optimizes campaigns on Meta, LinkedIn and YouTube for paid social media marketing in Delhi NCR.</p>
        <ul class="srv-card-list">
          <li>Meta Ads</li>
          <li>LinkedIn Lead Generation</li>
          <li>Retargeting Audiences</li>
          <li>A/B Testing</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Lower acquisition cost and predictable lead flow.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3 class="srv-card-title">4. Influencer &amp; UGC Marketing</h3>
        <p class="srv-card-desc">We connect your brand with relevant creators and produce user-generated content that builds social proof.</p>
        <ul class="srv-card-list">
          <li>Creator Vetting</li>
          <li>Campaign Management</li>
          <li>UGC Videos</li>
          <li>Reach Tracking</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Authentic recommendations that shorten the path to purchase.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        </div>
        <h3 class="srv-card-title">5. Community Management &amp; Reputation</h3>
        <p class="srv-card-desc">As a social media management company in Delhi, we reply to comments and messages and monitor brand mentions.</p>
        <ul class="srv-card-list">
          <li>Comment and DM Replies</li>
          <li>Social Listening</li>
          <li>Review Handling</li>
          <li>Crisis Guidelines</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Faster responses and a protected brand image.</span>
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
        <h3 class="srv-card-title">6. Social Analytics &amp; Lead Tracking</h3>
        <p class="srv-card-desc">We connect social platforms to your website and CRM so you see which post, ad or creator produced each sale.</p>
        <ul class="srv-card-list">
          <li>Pixel and Conversions API</li>
          <li>UTM and GA4 Tracking</li>
          <li>CRM Integration</li>
          <li>Looker Studio Dashboards</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Complete ROI visibility for every decision.</span>
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
        <span>DELIVERY FRAMEWORK</span>
      </div>
      <h2 class="srv-section-title">
        The 6-Phase Framework Our Social Media <span class="text-brand">Marketing Company in Delhi Follows</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear milestones and full visibility at every stage.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 01 (Week 1): Discovery &amp; Audit</h3>
          <p class="srv-step-desc">We review profiles, ads and competitors, then agree on goals.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Audit Report, KPI Document</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 02 (Weeks 1-2): Strategy &amp; Content Plan</h3>
          <p class="srv-step-desc">We build your platform plan and brand voice guide.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>90-Day Strategy, Content Calendar</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 03 (Weeks 2-3): Creative &amp; Setup</h3>
          <p class="srv-step-desc">We produce the first content batch and set up tracking.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Posts and Reels, Pixel Setup</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 04 (Weeks 3-4): Launch</h3>
          <p class="srv-step-desc">We publish content, launch paid campaigns and start community management.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Live Schedule, First Campaigns</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 05 (Months 2-3): Testing &amp; Optimization</h3>
          <p class="srv-step-desc">We test audiences, hooks and offers every week.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>A/B Test Reports, Fresh Creatives</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 06 (Month 3+): Scale &amp; Reporting</h3>
          <p class="srv-step-desc">We increase budgets on proven campaigns and review results monthly.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Live Dashboard, Monthly ROI Report</span>
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
        <span>WHY PARTNER WITH US</span>
      </div>
      <h2 class="srv-section-title">
        Why Leading Brands Choose BusinessDoctor as Their <span class="text-brand">Social Media Marketing Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Every brand has different goals, and a good social media marketing company in Delhi proves its value with numbers. Here is what sets our social media marketing company in Delhi apart from typical agencies.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">ROAS-Focused Reporting</div>
        <h3 class="srv-benefit-title">Zero Vanity Metrics</h3>
        <p class="srv-benefit-desc">We report leads, cost per lead and ROAS.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">No Lock-In</div>
        <h3 class="srv-benefit-title">100% Account Ownership</h3>
        <p class="srv-benefit-desc">Your pages, ad accounts and pixels always belong to you.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Dedicated Account Manager</div>
        <h3 class="srv-benefit-title">Senior Strategists</h3>
        <p class="srv-benefit-desc">Experienced specialists plan and review every campaign.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Data-Informed Creative</div>
        <h3 class="srv-benefit-title">Performance Creative</h3>
        <p class="srv-benefit-desc">Our designers work with ad data.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Accurate Attribution</div>
        <h3 class="srv-benefit-title">First-Party Tracking</h3>
        <p class="srv-benefit-desc">Conversions API keeps data accurate despite iOS limits.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Weekly Creative Refresh</div>
        <h3 class="srv-benefit-title">Rapid Creative Rotation</h3>
        <p class="srv-benefit-desc">Weekly refreshes prevent ad fatigue.</p>
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
        Tools <span class="text-brand">to Be Used</span>
      </h2>
      <p class="srv-section-subtitle">
        Our team uses proven tools to plan, publish, advertise and measure growth.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Publishing &amp; Management</h3>
        <ul class="srv-tech-list">
          <li>Meta Business Suite</li>
          <li>Hootsuite</li>
          <li>Buffer</li>
          <li>Sprout Social</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Paid Social Networks</h3>
        <ul class="srv-tech-list">
          <li>Meta Ads Manager</li>
          <li>LinkedIn Campaign Manager</li>
          <li>YouTube Ads</li>
          <li>X Ads</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Creative &amp; Video</h3>
        <ul class="srv-tech-list">
          <li>Canva Pro</li>
          <li>Adobe Premiere Pro</li>
          <li>CapCut</li>
          <li>Figma</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Analytics &amp; CRM</h3>
        <ul class="srv-tech-list">
          <li>Google Analytics 4</li>
          <li>Meta Pixel</li>
          <li>Looker Studio</li>
          <li>HubSpot</li>
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
        <span>INDUSTRIES</span>
      </div>
      <h2 class="srv-section-title">
        Tailored Social Media Solutions for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        We solve sector-specific challenges as your growth partner.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <h3 class="srv-card-title">Real Estate</h3>
        <p class="srv-card-desc">Project reels and lead forms that bring site visits across Delhi NCR.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">KPI</span>
          <span>Qualified Site Visits</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Healthcare &amp; Clinics</h3>
        <p class="srv-card-desc">Compliant, educational content that drives appointment bookings.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">KPI</span>
          <span>Appointments</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">E-commerce &amp; D2C</h3>
        <p class="srv-card-desc">Catalog ads and retargeting that move shoppers to checkout.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">KPI</span>
          <span>ROAS</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Education</h3>
        <p class="srv-card-desc">Parent and student campaigns that fill batches.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">KPI</span>
          <span>Cost per Enquiry</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Restaurants &amp; Hospitality</h3>
        <p class="srv-card-desc">Food reels and local targeting that grow footfall.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">KPI</span>
          <span>Bookings</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">B2B &amp; SaaS</h3>
        <p class="srv-card-desc">LinkedIn lead generation that fills the pipeline.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">KPI</span>
          <span>Qualified Leads</span>
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
        Common Questions About <span class="text-brand">Social Media Marketing in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our social media management, paid campaigns, and reporting.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How quickly can a social media marketing company in Delhi deliver results?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Paid campaigns show lead data in 2 to 4 weeks. Organic growth builds more steadily and usually takes 60 to 90 days.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Do you require long-term contracts?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>No. We suggest 3 months for proper testing, but agreements are flexible.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Which platforms do you manage?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Instagram, Facebook, LinkedIn, YouTube and X, chosen by where your audience is.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Is the ad budget included in your fees?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>No. You pay the platform directly and see every rupee spent.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">What budget do I need to start with a social media marketing company in Delhi?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>It depends on your industry, competition and goals. We suggest a starting range after the discovery call.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Do you create the content?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We handle design, video, captions and hashtags. You only approve.</p>
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
              Ready to Grow with the <span class="text-brand">Best Social Media Marketing Company in Delhi?</span>
            </h2>
            <p class="srv-cta-lead">
              Share your goals and our team will send a free social media audit within 24 hours. As a trusted social media marketing company in Delhi, we keep every promise simple: clear targets, honest reporting and campaigns that grow your business month after month.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Book a Free Consultation</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit.php') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Digital Audit</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </a>
            </div>
            <p style="color: var(--color-accent); font-size: 0.88rem; margin-bottom: 1.5rem; font-weight: 500;">
              Free audit &bull; No obligation &bull; Reply within 2 hours
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
                <p class="srv-form-subtitle">Direct consultation with senior enterprise architects.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_social-media-marketing">Your Full Name</label>
                  <input type="text" id="quick_name_social-media-marketing" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_social-media-marketing">Work Email</label>
                  <input type="email" id="quick_email_social-media-marketing" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_social-media-marketing">Company / Domain</label>
                  <input type="text" id="quick_company_social-media-marketing" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_social-media-marketing">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_social-media-marketing" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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