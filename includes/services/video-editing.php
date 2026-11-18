<?php
/**
 * BusinessDoctor Service Detail View — Video Editing
 * Discipline 09 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Video Editing';
$serviceSlug = 'video-editing';
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
          <span>VIDEO EDITING COMPANY IN DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          Video Editing Company in Delhi <br><span class="text-brand">for High-Impact Brand and Ad Videos</span>
        </h1>
        <p class="srv-hero-desc">
          Get the footage but no time to edit it? BusinessDoctor is a video editing company in Delhi that turns raw clips into clean, sharp videos for your ads, reels, products and brand. Send your files, tell us the goal, and get a video ready to post.
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
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.studio :: video-editing-pipeline.v2</text>

  <!-- Video Viewport Monitor -->
  <rect x="40" y="65" width="345" height="230" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  
  <!-- Camera Grid & Target -->
  <circle cx="212" cy="180" r="45" stroke="#06B5F9" stroke-opacity="0.5" stroke-dasharray="4 4"/>
  <circle cx="212" cy="180" r="4" fill="#06B5F9"/>
  <line x1="152" y1="180" x2="272" y2="180" stroke="#06B5F9" stroke-opacity="0.3"/>
  <line x1="212" y1="120" x2="212" y2="240" stroke="#06B5F9" stroke-opacity="0.3"/>
  <rect x="55" y="80" width="76" height="24" rx="4" fill="#EF4444"/>
  <text x="64" y="96" fill="#ffffff" font-family="monospace" font-size="10.5" font-weight="bold">&bull; REC 4K</text>
  <text x="235" y="96" fill="#34D399" font-family="monospace" font-size="10.5">60 FPS &bull; ProRes Master</text>
  
  <!-- Audio Waveform -->
  <path d="M 60 262 C 63.7 261, 74.5 255.3, 82 256 C 89.5 256.7, 97 267.3, 105 266 C 113 264.7, 121.7 247.2, 130 248 C 138.3 248.8, 146.3 271.7, 155 271 C 163.7 270.3, 172.8 244.5, 182 244 C 191.2 243.5, 200.7 267.8, 210 268 C 219.3 268.2, 228.8 244.3, 238 245 C 247.2 245.7, 256.3 271.2, 265 272 C 273.7 272.8, 281.7 250.8, 290 250 C 298.3 249.2, 306.7 266, 315 267 C 323.3 268, 331.7 256.8, 340 256 C 348.3 255.2, 360.8 261, 365 262" stroke="#06B5F9" stroke-width="2" fill="none"/>

  <!-- Side Metrics -->
  <rect x="400" y="65" width="160" height="110" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="415" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// FAST TURNAROUND</text>
  <text x="415" y="122" fill="#34D399" font-family="sans-serif" font-size="22" font-weight="900">Guaranteed</text>
  <text x="415" y="148" fill="#B8C7D9" font-family="monospace" font-size="10">Fixed Delivery Date</text>

  <rect x="400" y="185" width="160" height="110" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="415" y="210" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// MULTI-PLATFORM</text>
  <text x="415" y="242" fill="#06B5F9" font-family="sans-serif" font-size="22" font-weight="900">9:16 / 16:9</text>
  <text x="415" y="268" fill="#B8C7D9" font-family="monospace" font-size="10">Reels, Shorts, Feeds</text>

  <!-- Timeline Panel Below -->
  <rect x="40" y="310" width="520" height="95" rx="8" fill="#0A2038" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="56" y="333" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// MULTI-TRACK TIMELINE (PREMIERE / DAVINCI)</text>
  <rect x="56" y="348" width="155" height="22" rx="4" fill="#06B5F9" fill-opacity="0.25" stroke="#06B5F9" stroke-opacity="0.4"/>
  <text x="66" y="363" fill="#ffffff" font-family="monospace" font-size="9.5" font-weight="600">V1: Commercial Hooks</text>

  <rect x="221" y="348" width="145" height="22" rx="4" fill="#34D399" fill-opacity="0.25" stroke="#34D399" stroke-opacity="0.4"/>
  <text x="231" y="363" fill="#ffffff" font-family="monospace" font-size="9.5" font-weight="600">V2: Captions &amp; Titles</text>

  <rect x="376" y="348" width="168" height="22" rx="4" fill="#06B5F9" fill-opacity="0.25" stroke="#06B5F9" stroke-opacity="0.4"/>
  <text x="386" y="363" fill="#ffffff" font-family="monospace" font-size="9.5" font-weight="600">A1: Master Dialogue &amp; Music</text>
  <text x="56" y="392" fill="#8FA3B8" font-family="monospace" font-size="9.5">Timeline Resolution: Multi-Format UHD &bull; Color &amp; Audio Mastered</text>
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
          <span>KEY TAKEAWAYS &bull; WHY BRANDS HIRE BUSINESSDOCTOR?</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Fast</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Fast Turnaround</span>
          <p class="srv-takeaway-desc">We fix the delivery date before we start, and we stick to it.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Included</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Revisions Included</span>
          <p class="srv-takeaway-desc">Not happy with the first cut? We fix it until it matches your brief.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">9:16 / 16:9</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Every Platform Size</span>
          <p class="srv-takeaway-desc">9:16, 16:9 and 1:1 files, ready for each app.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Full Ownership</span>
          <p class="srv-takeaway-desc">The final videos are yours to use anywhere.</p>
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
          <span>HIRE A PROFESSIONAL VIDEO EDITING COMPANY</span>
        </div>
        <h2 class="srv-section-title">
          Hire a Professional Video Editing Company in Delhi <span class="text-brand">That Brings Real Results</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          When you hire our video editing company in Delhi, one editor learns your brand and handles your videos from start to finish. You always know who to call and when your video will land.
        </p>
        <p class="srv-card-desc mb-4">
          Our editors work with our marketing team, so every hook and call to action is placed to get you enquiries, not just views.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Ad Video Editing:</strong> 
              <span class="text-secondary">Two or three hook versions of every ad, so you can test and keep the winner.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Reel and Short-Form Editing:</strong> 
              <span class="text-secondary">Quick cuts, clear captions and the right size for every app.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Product and Marketplace Video Editing:</strong> 
              <span class="text-secondary">Listing videos that show features and help buyers decide.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Corporate and Testimonial Editing:</strong> 
              <span class="text-secondary">Brand films and client stories that build trust fast.</span>
            </div>
          </div>
        </div>

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
            <span class="srv-hud-title">CREATIVE STUDIO TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              PRODUCTION PIPELINE ACTIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time video production metrics tracking delivery timelines, hook performance, and platform-specific exports.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Fast</div>
                <div class="srv-hud-metric-label">Turnaround</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">9:16 &bull; 16:9</div>
                <div class="srv-hud-metric-label">Multi-Platform Size</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Full Ownership</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">1-on-1</div>
                <div class="srv-hud-metric-label">Dedicated Editor</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Ad Video Editing</span>
              <span class="srv-tool-badge">Reel Editing</span>
              <span class="srv-tool-badge">Product Videos</span>
              <span class="srv-tool-badge">Corporate Films</span>
              <span class="srv-tool-badge">Testimonials</span>
              <span class="srv-tool-badge">Monthly Packages</span>
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
        Video Editing Solutions From a Professional <span class="text-brand">Video Editing Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Every video is cut by a real editor who cares how it performs. No templates, no copy-paste edits.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>
        </div>
        <h3 class="srv-card-title">Ad Video Editing Company for Meta, YouTube and Google</h3>
        <p class="srv-card-desc">Your ad gets about three seconds to stop the scroll. We cut it that way. You get a few versions with different hooks, so you can run the one that works.</p>
        <ul class="srv-card-list">
          <li>Strong 3-second hooks</li>
          <li>Bold captions and sound effects</li>
          <li>Hook and CTA variations for testing</li>
          <li>9:16 and 16:9 exports</li>
        </ul>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        </div>
        <h3 class="srv-card-title">Reel Editing Company for Instagram and Shorts</h3>
        <p class="srv-card-desc">Send us the raw clips. We handle cuts, music and captions, and you get Reels and Shorts that look made for each app.</p>
        <ul class="srv-card-list">
          <li>Trend-aware cuts and transitions</li>
          <li>Easy-to-read captions</li>
          <li>Music and sound matching</li>
          <li>Batch editing for the full month</li>
        </ul>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <h3 class="srv-card-title">Product Video Editing Company for Marketplaces and Stores</h3>
        <p class="srv-card-desc">We edit listing videos for Amazon, Flipkart and your own store. Features show up clearly on screen, so buyers feel sure about clicking Buy.</p>
        <ul class="srv-card-list">
          <li>Feature call-outs on screen</li>
          <li>Colour correction for a true product look</li>
          <li>Clear audio and voiceover sync</li>
          <li>Marketplace-ready sizes</li>
        </ul>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <h3 class="srv-card-title">Corporate Video Editing Company</h3>
        <p class="srv-card-desc">Brand films, founder videos, company intros and event highlights. We cut them to look sharp and sound right.</p>
        <ul class="srv-card-list">
          <li>Interview and multi-camera editing</li>
          <li>Logo, lower thirds and brand fonts</li>
          <li>Music and sound balancing</li>
          <li>Short cutdowns for social media</li>
        </ul>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3 class="srv-card-title">Testimonial and Case Study Video Editing</h3>
        <p class="srv-card-desc">Happy clients sell better than any ad. We turn their words into short, honest videos you can send to your next buyer.</p>
        <ul class="srv-card-list">
          <li>Interview cuts with key results on screen</li>
          <li>B-roll added where needed</li>
          <li>Short social cutdowns</li>
          <li>Branded intro and outro</li>
        </ul>
      </div>

      <!-- Service Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h3 class="srv-card-title">Monthly Video Editing Packages</h3>
        <p class="srv-card-desc">Posting every week? Our video editing company in Delhi gives you a fixed number of edits per month with one editor who learns your style. We keep pricing simple and affordable, so you know the cost from day one.</p>
        <ul class="srv-card-list">
          <li>Fixed videos every month</li>
          <li>One dedicated editor</li>
          <li>Priority turnaround</li>
          <li>A simple plan that grows with you</li>
        </ul>
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
        Our 6-Phase Video Editing Process, <span class="text-brand">From Footage to Delivery</span>
      </h2>
      <p class="srv-section-subtitle">
        Six steps. You know what is happening at every stage.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">1. Brief and Footage Review</h3>
          <p class="srv-step-desc">You share the goal, the footage and any reference videos. We check everything and plan the edit.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Edit plan, Footage checklist, Delivery date</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">2. Rough Cut Assembly</h3>
          <p class="srv-step-desc">We build the story on the timeline, trim the extras and set the pace.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>First assembly, Story flow, Music direction</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">3. Fine Cut, Graphics and Captions</h3>
          <p class="srv-step-desc">We polish every cut and add captions, titles and your brand look.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Fine cut, Captions and titles, Brand graphics</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">4. Colour Grading and Sound Design</h3>
          <p class="srv-step-desc">We fix the colours, clean up the audio and mix the music, so the video looks and sounds right.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Colour graded video, Clean audio mix, Licensed music</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">5. Review and Revisions</h3>
          <p class="srv-step-desc">You watch the cut, leave your comments and we fix them fast.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Review link, Time-stamped feedback, Updated cut</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">6. Multi format Export and Delivery</h3>
          <p class="srv-step-desc">We send the final files in every size you need, ready to post.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>9:16, 16:9 and 1:1 files, Master file, Full ownership of the final video</span>
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
        Why Leading Brands Choose BusinessDoctor as Their <span class="text-brand">Video Editing Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Experienced editors, simple pricing and one team that handles it all.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Built for Results</div>
        <h3 class="srv-benefit-title">Marketing-First Editors</h3>
        <p class="srv-benefit-desc">We edit to get clicks and sales, not to win awards.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">One Point of Contact</div>
        <h3 class="srv-benefit-title">Dedicated Editor</h3>
        <p class="srv-benefit-desc">One editor learns your brand and stays with you.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Test and Win</div>
        <h3 class="srv-benefit-title">Multiple Hook Versions</h3>
        <p class="srv-benefit-desc">You get a few openings to test, so your ads keep getting better.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">No Hidden Costs</div>
        <h3 class="srv-benefit-title">Simple, Clear Pricing</h3>
        <p class="srv-benefit-desc">You get a quote before we start. No surprise charges later.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Simple Reviews</div>
        <h3 class="srv-benefit-title">Easy Feedback</h3>
        <p class="srv-benefit-desc">Leave comments right on the video timeline. No long emails.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">One Team, One Standard</div>
        <h3 class="srv-benefit-title">Full Digital Team Under One Roof</h3>
        <p class="srv-benefit-desc">Unlike a typical video editing agency, we also run your ads, website and listings, so everything works together.</p>
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
        Professional Tools <span class="text-brand">Our Editors Use</span>
      </h2>
      <p class="srv-section-subtitle">
        The software our editors work in every day.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Editing and Assembly</h3>
        <ul class="srv-tech-list">
          <li>Adobe Premiere Pro (main timeline editing)</li>
          <li>DaVinci Resolve (colour and edit)</li>
          <li>Final Cut Pro (fast Mac editing)</li>
          <li>CapCut Pro (quick social cuts)</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Motion Graphics</h3>
        <ul class="srv-tech-list">
          <li>After Effects (animated titles)</li>
          <li>Cinema 4D (3D logos and text)</li>
          <li>Blender (3D and effects)</li>
          <li>Mocha Pro (tracking)</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Audio and Sound</h3>
        <ul class="srv-tech-list">
          <li>Adobe Audition (voice clean-up)</li>
          <li>iZotope RX (noise removal)</li>
          <li>Artlist (licensed music)</li>
          <li>Musicbed (premium music)</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Review and Delivery</h3>
        <ul class="srv-tech-list">
          <li>Frame.io (time-stamped feedback)</li>
          <li>Dropbox Replay (easy review)</li>
          <li>Google Drive (secure sharing)</li>
          <li>ProRes and H.265 (high quality exports)</li>
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
        Video Editing Company in Delhi for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        As a video editing company in Delhi, we edit for brands across India. These are the fields we work with most.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <h3 class="srv-card-title">D2C and Consumer</h3>
        <p class="srv-card-desc"><strong>Product Ad Edits:</strong> Fast, bright cuts that show the product and push the buy.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Stronger ads, lower cost per sale.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">E-Commerce Sellers</h3>
        <p class="srv-card-desc"><strong>Listing Video Edits:</strong> Clear videos that show features on Amazon and Flipkart.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>Buyers feel confident and order more.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">B2B SaaS</h3>
        <p class="srv-card-desc"><strong>Product Walkthrough Edits:</strong> Screen recordings, text and voiceover edited into clean demos.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>More demo bookings.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Real Estate</h3>
        <p class="srv-card-desc"><strong>Property Video Edits:</strong> Walkthroughs and drone clips cut into smooth property tours.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>More site-visit enquiries.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Education</h3>
        <p class="srv-card-desc"><strong>Course and Promo Edits:</strong> Course promos and lecture clips edited and captioned.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>More student sign-ups.</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Healthcare</h3>
        <p class="srv-card-desc"><strong>Clinic and Doctor Videos:</strong> Warm, clear videos for doctors and clinics.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Outcome</span>
          <span>More patient trust and bookings.</span>
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
        Hiring a Video Editing Company in Delhi: <span class="text-brand">Your Questions Answered</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our video editing process, pricing, timelines, and deliverables.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How much does a video editing company in Delhi charge?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>The price depends on video length, style and how many videos you need. Share your requirements and we will send you a clear quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How do I hire BusinessDoctor as my video editing company in Delhi?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Fill the form or call us. Share your footage and goal, and we confirm the scope, price and delivery date before we start. We work with brands in Delhi and across Delhi NCR, and online with clients across India.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">What does your video editing package include?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Cutting, colour correction, sound clean-up, captions, brand graphics, exports in every size and revisions. Monthly packages also include a dedicated editor.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">How many revisions do I get?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Revision rounds are included in every project. Tell us the exact changes and we update the video until it matches your brief.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">What is the turnaround time after I share my footage?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We fix the delivery date before we start. Short social edits move faster, and longer corporate videos take more time. Ask for a quote with a timeline.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Does your video editing company in Delhi offer monthly plans?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Pick a fixed number of videos per month with one dedicated editor and priority delivery. Tell us your deadline and we will confirm if it works.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">Do you deliver vertical cuts for Reels and Shorts?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Every video can be exported in 9:16, 16:9 and 1:1, so one edit fits every app.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-8">
          <span class="srv-faq-question">Do I own the final video files after delivery?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-8" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Once the project is complete, the final videos are yours to use anywhere you want.</p>
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
              Ready to Hire a <span class="text-brand">Video Editing Company in Delhi That Delivers?</span>
            </h2>
            <p class="srv-cta-lead">
              Looking for a video editing company in Delhi? We work with brands in Noida, Delhi and across Delhi NCR, and online with clients all over India. Send your footage, tell us what you want, and we will send you a quote.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Get a Free Consultation</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit') ?>" class="btn-srv-secondary btn-srv-lg">
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
              <form action="<?= appUrl('contact') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_video-editing">Your Full Name</label>
                  <input type="text" id="quick_name_video-editing" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_video-editing">Work Email</label>
                  <input type="email" id="quick_email_video-editing" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_video-editing">Company / Domain</label>
                  <input type="text" id="quick_company_video-editing" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_video-editing">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_video-editing" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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