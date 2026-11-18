<?php
/**
 * BusinessDoctor Service Detail View — Google Business Profile Management
 * Discipline 02 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Google Business Profile Management';
$serviceSlug = 'google-business-profile';
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
          <span>GOOGLE BUSINESS PROFILE MANAGEMENT COMPANY IN DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          Google Business Profile Management Company in Delhi <br><span class="text-brand">for More Calls, Directions and Local Leads</span>
        </h1>
        <p class="srv-hero-desc">
          We manage your Google Business Profile including setting up your profile, managing your reviews, posts and monthly reports. We work with local retailers, clinics, restaurants and multi-branch brands throughout Delhi NCR. If you're looking for a Google Business Profile management company in Delhi that can track genuine calls and visits, simply send us your profile link and we'll provide a free audit.
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
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">Locations</span>
              <span class="srv-hero-prop-lbl">Profiles Managed: Single and multi-location</span>
            </div>
          </div>
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">Monthly</span>
              <span class="srv-hero-prop-lbl">Reporting: Every month</span>
            </div>
          </div>
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">No Lock In</span>
              <span class="srv-hero-prop-lbl">Contract: No lock in</span>
            </div>
          </div>
          <div class="srv-hero-prop-card">
            <div class="srv-hero-prop-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="srv-hero-prop-content">
              <span class="srv-hero-prop-val">100%</span>
              <span class="srv-hero-prop-lbl">Ownership: Stays with you</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.maps :: local-pack-engine</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// GOOGLE MAPS 3-PACK RANKING TRAJECTORY</text>
              <path d="M 65 175 L 140 145 L 230 160 L 320 115 L 410 130 L 520 75" stroke="#34D399" stroke-width="3" fill="none"/>
              <circle cx="520" cy="75" r="5" fill="#34D399"/>
              <text x="430" y="65" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="bold">Top 3 Maps Rank</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// CALL CONVERSIONS</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">Direct Calls</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Phone Calls &bull; Direction Requests</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">Monthly Performance Tracking</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// REVIEW REPUTATION</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">100%</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Review Replies &bull; QR Setup</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">Full Profile Ownership Stays With You</text>
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
          <span>Why Brands Hire BusinessDoctor as Their Google Business Profile Management Company in Delhi</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Calls</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Call First Reporting</span>
          <p class="srv-takeaway-desc">You see calls, direction requests and website clicks, not just views.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Included</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Review Management Included</span>
          <p class="srv-takeaway-desc">We reply to reviews and help you collect new ones.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">No Lock-In</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">No Lock In Contracts</span>
          <p class="srv-takeaway-desc">You stay because the work is good, not because you signed a long deal.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">1-on-1</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Dedicated Profile Manager</span>
          <p class="srv-takeaway-desc">One person knows your profile and responds to your messages.</p>
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
          <span>DIRECT LOCAL IMPACT</span>
        </div>
        <h2 class="srv-section-title">
          Hire a Google Business Profile Management Company in Delhi <span class="text-brand">Built for Direct Local Impact</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          By hiring us as your Google Business Profile management company in Delhi, you receive a single dedicated manager. Your profile will be fully cleaned up, you'll have regular posts, responses to reviews and a monthly report. We begin by doing a free audit.
        </p>
        <p class="srv-card-desc mb-4">
          We link your profile to your website, review system and call tracking so that those finding you on the map will actually call or visit. This is what a good Google Maps ranking company in Delhi should offer.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Profile Setup and Verification:</strong> 
              <span class="text-secondary">A clean, verified profile from day one.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Optimization and Map Ranking:</strong> 
              <span class="text-secondary">Every section filled with what buyers search for.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Review Management:</strong> 
              <span class="text-secondary">Replies and a simple way to collect more reviews.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Post and Offer Management:</strong> 
              <span class="text-secondary">Fresh updates on a fixed schedule.</span>
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
            <span class="srv-hud-title">LOCAL DISCOVERY TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              MAPS 3-PACK ACTIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time local ranking telemetry tracking Google Maps visibility, phone calls, and customer direction requests.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Top 3</div>
                <div class="srv-hud-metric-label">Target Map Pack</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">High</div>
                <div class="srv-hud-metric-label">Call &amp; Direction Lift</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Verified Profile</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Weekly</div>
                <div class="srv-hud-metric-label">Updates &amp; Posts</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Profile Setup</span>
              <span class="srv-tool-badge">Maps Ranking</span>
              <span class="srv-tool-badge">Review Replies</span>
              <span class="srv-tool-badge">Local Citations</span>
              <span class="srv-tool-badge">Q&amp;A Management</span>
              <span class="srv-tool-badge">Multi-Location</span>
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
        Google Business Profile Management Services <span class="text-brand">From a Professional Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Comprehensive local optimization designed to drive real calls, store visits, and local map-pack dominance.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <h3 class="srv-card-title">Google Business Profile Setup and Verification Company in Delhi</h3>
        <p class="srv-card-desc">We create your profile, or take over your old one, and get it verified without the usual back and forth. Everything is set up cleanly from day one.</p>
        <ul class="srv-card-list">
          <li>Profile creation</li>
          <li>Right category selection</li>
          <li>Verification support</li>
          <li>NAP consistency</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>A verified, correct profile that Google can trust.</span>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <h3 class="srv-card-title">GMB Optimization Company for Local Maps Ranking</h3>
        <p class="srv-card-desc">We fill every part of your profile with the details customers search for, so Google knows exactly what you do and where you are.</p>
        <ul class="srv-card-list">
          <li>Business description</li>
          <li>Services and products list</li>
          <li>Attributes</li>
          <li>Q&amp;A setup</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Your business shows up in more searches near you.</span>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        </div>
        <h3 class="srv-card-title">Review Management and Reply Handling for Local Businesses</h3>
        <p class="srv-card-desc">We give happy customers an easy way to leave a review, and we reply to every review in your own voice.</p>
        <ul class="srv-card-list">
          <li>Review link and QR code</li>
          <li>Reply drafting</li>
          <li>Negative review response</li>
          <li>Review reporting</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>More trust before a customer even picks up the phone.</span>
        </div>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </div>
        <h3 class="srv-card-title">Posts, Photos and Offers Management for Google Profiles</h3>
        <p class="srv-card-desc">A profile that gets updated looks alive. We post and upload on a fixed schedule so you never have to remember.</p>
        <ul class="srv-card-list">
          <li>Weekly posts</li>
          <li>Offer updates</li>
          <li>Photo uploads</li>
          <li>Event listings</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>More reasons for people to click, call or visit.</span>
        </div>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <h3 class="srv-card-title">Multi Location Google Business Profile Management for Chains</h3>
        <p class="srv-card-desc">Running ten branches should not mean ten headaches. We manage every location from one plan and one dashboard.</p>
        <ul class="srv-card-list">
          <li>Location wise profiles</li>
          <li>Bulk updates</li>
          <li>Local landing pages</li>
          <li>Central dashboard</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Every branch stays accurate and easy to find.</span>
        </div>
      </div>

      <!-- Service Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h3 class="srv-card-title">Monthly Google Business Profile Management Packages</h3>
        <p class="srv-card-desc">A fixed monthly plan with clear work and a clear price. You always know what we do each month.</p>
        <ul class="srv-card-list">
          <li>Fixed monthly scope</li>
          <li>Monthly reports</li>
          <li>Regular review call</li>
          <li>No lock in</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>A predictable cost and no surprise bills.</span>
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
        6 Phase Google Business <span class="text-brand">Profile Process</span>
      </h2>
      <p class="srv-section-subtitle">
        How we transform your local map presence from unverified or incomplete to a top-ranking lead engine.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">1. Profile and Listing Audit</h3>
          <p class="srv-step-desc">We audit all elements of your profile, listings and top local competitors. This will leave you with a clear overview of what needs to be done.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Audit Report, NAP Sheet, Competitor Gap List.</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">2. Keyword and Category Planning</h3>
          <p class="srv-step-desc">Here we will show you what keywords people are using to search for your business. We will also show you what types your business should be in.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Category list, Local Keyword Map, Services list.</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">3. Profile Optimization</h3>
          <p class="srv-step-desc">All sections of your profile will be optimised by us. We will also add relevant images.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Optimised description, Attributes and Services, Images and Logo.</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">4. Content and Review Setup</h3>
          <p class="srv-step-desc">We will create a content strategy to make it easy for clients to leave reviews.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Content calendar, Review link and QR Code, Response templates.</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">5. Ranking and Growth</h3>
          <p class="srv-step-desc">Every week we will post content, respond to queries, correct any listing errors and monitor your ranking.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Weekly updates, Q&amp;A and offer posts, Clean citations.</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">6. Reporting and Review</h3>
          <p class="srv-step-desc">Once a month we will show you how your calls, directions and clicks have changed. We will then plan what we are going to do next month.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Live dashboard, Monthly report, Strategy call.</span>
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
        Why Leading Brands Choose BusinessDoctor as Their <span class="text-brand">Google Business Profile Management Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Dedicated profile management focused on phone calls, direction requests, and local customer acquisition.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Calls &amp; Directions | Dedicated Manager</div>
        <h3 class="srv-benefit-title">Call-First Account Managers</h3>
        <p class="srv-benefit-desc">Your manager tracks calls, directions and website clicks. As a Google Business Profile management company in Delhi, we care about your phone ringing, not just views.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Reputation Ready | Faster Responses</div>
        <h3 class="srv-benefit-title">Review Reply System Included</h3>
        <p class="srv-benefit-desc">Every review gets a reply written in your voice. We also give you a simple way to collect more of them.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Suspension Protection | Guideline Compliant</div>
        <h3 class="srv-benefit-title">Policy-Safe Profile Handling</h3>
        <p class="srv-benefit-desc">We follow Google’s rules on business names, categories and content, so your profile stays in good standing.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Real-Time Reporting | Full Access</div>
        <h3 class="srv-benefit-title">Transparent Live Dashboards</h3>
        <p class="srv-benefit-desc">Open your dashboard any time and see what we did and what changed.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">100% Ownership | No Lock-In</div>
        <h3 class="srv-benefit-title">Profile Ownership Stays With You</h3>
        <p class="srv-benefit-desc">Your profile is always in your name. If you ever leave, you take everything with you.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">End-to-End | Complete Local Scope</div>
        <h3 class="srv-benefit-title">Full Digital Team Under One Roof</h3>
        <p class="srv-benefit-desc">Need a website fix or ads along with your profile? Our design, SEO and ads people work as one team.</p>
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
        Professional Tools Our Google Business Profile <span class="text-brand">Management Company in Delhi Uses</span>
      </h2>
      <p class="srv-section-subtitle">
        We use these tools to fix your listings, track your rankings and report your numbers.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Profile &amp; Listing</h3>
        <ul class="srv-tech-list">
          <li><strong>Google Business Profile Manager:</strong> edit and manage profile</li>
          <li><strong>Google Maps:</strong> check map visibility</li>
          <li><strong>Bing Places:</strong> manage Bing listing</li>
          <li><strong>Apple Business Connect:</strong> manage Apple Maps listing</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Rank &amp; Citation Tracking</h3>
        <ul class="srv-tech-list">
          <li><strong>BrightLocal:</strong> track local rankings, citations</li>
          <li><strong>Local Falcon:</strong> map grid rank check</li>
          <li><strong>Whitespark:</strong> build and clean citations</li>
          <li><strong>Semrush:</strong> keyword and competitor research</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Tracking &amp; Analytics</h3>
        <ul class="srv-tech-list">
          <li><strong>GA4:</strong> track website visits, leads</li>
          <li><strong>Google Search Console:</strong> monitor search performance</li>
          <li><strong>Google Tag Manager:</strong> set up tracking tags</li>
          <li><strong>Call Tracking:</strong> count calls from profile</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Reporting &amp; Reviews</h3>
        <ul class="srv-tech-list">
          <li><strong>Looker Studio:</strong> build live dashboards</li>
          <li><strong>Review Request Links:</strong> collect customer reviews easily</li>
          <li><strong>QR Codes:</strong> get reviews in-store</li>
          <li><strong>CRM Integration:</strong> sync leads automatically</li>
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
        <span>LOCAL SECTORS</span>
      </div>
      <h2 class="srv-section-title">
        Google Business Profile Management Company in Delhi for <span class="text-brand">Local-Intent Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        Tailored local visibility systems engineered for multi-location and local-service businesses.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <h3 class="srv-card-title">Restaurants &amp; Cafes</h3>
        <p class="srv-card-desc"><strong>Google Profile Management for Restaurants &amp; Cafes:</strong> Menu, photos, timings and offers kept fresh so hungry people find you first.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Primary Outcome</span>
          <span>More direction requests</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Clinics &amp; Hospitals</h3>
        <p class="srv-card-desc"><strong>Google Profile Management for Clinics &amp; Hospitals:</strong> Services, doctor details and reviews set up so patients trust you before they call.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Primary Outcome</span>
          <span>Quality appointment calls</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Retail &amp; Showrooms</h3>
        <p class="srv-card-desc"><strong>Google Profile Management for Retail &amp; Showrooms:</strong> Store timings, product photos and offers that bring people through your door.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Primary Outcome</span>
          <span>More store visits</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Real Estate Projects</h3>
        <p class="srv-card-desc"><strong>Google Profile Management for Real Estate Projects:</strong> Project details, photos and enquiry links that turn a search into a site visit.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Primary Outcome</span>
          <span>More site visit enquiries</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Salons &amp; Wellness Centres</h3>
        <p class="srv-card-desc"><strong>Google Profile Management for Salons &amp; Wellness Centres:</strong> Service lists, price ranges and booking links ready on your profile.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Primary Outcome</span>
          <span>More bookings</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Education &amp; Coaching</h3>
        <p class="srv-card-desc"><strong>Google Profile Management for Education &amp; Coaching:</strong> Courses, results and student reviews placed in one clear profile.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Primary Outcome</span>
          <span>More admission enquiries</span>
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
        Hiring a Google Business Profile Management Company in Delhi: <span class="text-brand">Your Questions Answered</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our GBP management, multi-location support, verification, and monthly reporting.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How much does a Google Business Profile management company in Delhi charge?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Fees depend on how many locations you have and the work needed each month. We give a fixed monthly quote after a free audit. Share your requirement for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How do I hire BusinessDoctor as my Google Business Profile management company in delhi?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Send us your profile link and your goal. We do a free audit and share a quote, so a Google Business Profile management company in Delhi starts with facts. Share your requirement for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">What does your Google Business Profile management package include?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Our Google Business Profile management company in Delhi covers profile optimization, weekly posts, review replies, listing fixes, a monthly report and a regular call. Share your requirement for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Can you handle profile verification or a suspended profile?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes, we help with verification and with appeals for suspended profiles. We cannot promise Google’s decision, but we do the work properly. Share your requirement for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">Do you manage multiple business locations?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. As a Google Business Profile management company in Delhi, we manage all your branches from one plan and one dashboard. Share your requirement for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">How soon can you start after onboarding?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Once we get access to your profile, we begin with the audit and the first fixes. Share your requirements and we will confirm a start date.</p>
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
            <p>You get a report every month and can open your live dashboard any time. We also keep a regular call to go through it. Share your requirement for a quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-8">
          <span class="srv-faq-question">Do I keep ownership of my Google Business Profile?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-8" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes, always. Even with a Google Business Profile management company in Delhi like us, the profile stays in your name and you remain the owner. Share your requirement for a quote.</p>
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
              Ready for More Local Calls, Directions and <span class="text-brand">Walk-In Customers?</span>
            </h2>
            <p class="srv-cta-lead">
              If you're looking for a Google Business Profile management company in Delhi that can track genuine calls and visits, simply send us your profile link and we'll provide a free audit.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Get a Free Audit &amp; Quote</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Local Audit</span>
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
                <h3 class="srv-form-title">Request Local Map Consultation</h3>
                <p class="srv-form-subtitle">Direct consultation with senior local SEO strategists.</p>
              </div>
              <form action="<?= appUrl('contact') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_google-business-profile">Your Full Name</label>
                  <input type="text" id="quick_name_google-business-profile" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_google-business-profile">Work Email</label>
                  <input type="email" id="quick_email_google-business-profile" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_google-business-profile">Company / Location</label>
                  <input type="text" id="quick_company_google-business-profile" name="company" class="srv-form-input" placeholder="e.g. Clinic / Retail Store (Delhi)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_google-business-profile">Profile Link &amp; Goals</label>
                  <textarea id="quick_notes_google-business-profile" name="notes" rows="2" class="srv-form-textarea" placeholder="Paste your Google Maps link or describe your local locations..."></textarea>
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