<?php
/**
 * BusinessDoctor Service Detail View — Creative Production & Video Marketing
 * Discipline 09 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Video Editing';
$serviceSlug = 'video-editing';
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
          <span>COMMERCIAL CINEMATOGRAPHY &amp; VIDEO MARKETING</span>
        </div>
        <h1 class="srv-hero-title">
          Producing High-Impact <br><span class="text-brand">Commercial Video &amp; Creative Media</span>
        </h1>
        <p class="srv-hero-desc">
          We produce cinema-grade commercial video, high-converting social ads (Reels/TikTok/YouTube), 3D product renders, and corporate brand films engineered to capture attention, stop the scroll, and accelerate conversions.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Consultation</span>
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
            <span class="srv-hero-stat-val">4K / 6K</span>
            <span class="srv-hero-stat-lbl">Cinema Cinema Production</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">72%+</span>
            <span class="srv-hero-stat-lbl">Average 3-Second Hook Rate</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">+85%</span>
            <span class="srv-hero-stat-lbl">Conversion Rate Lift</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Broadcast Licensing Rights</span>
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
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.studio :: 4k-commercial-video-pipeline.v2</text>

  <!-- Video Viewport Monitor -->
  <rect x="40" y="65" width="340" height="230" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  
  <!-- Camera Grid & Target -->
  <circle cx="210" cy="180" r="45" stroke="#06B5F9" stroke-opacity="0.5" stroke-dasharray="4 4"/>
  <circle cx="210" cy="180" r="4" fill="#06B5F9"/>
  <line x1="150" y1="180" x2="270" y2="180" stroke="#06B5F9" stroke-opacity="0.3"/>
  <line x1="210" y1="120" x2="210" y2="240" stroke="#06B5F9" stroke-opacity="0.3"/>
  <rect x="55" y="80" width="70" height="22" rx="4" fill="#EF4444"/>
  <text x="65" y="95" fill="#ffffff" font-family="monospace" font-size="11" font-weight="bold">&bull; REC 4K</text>
  <text x="240" y="95" fill="#34D399" font-family="monospace" font-size="11">60 FPS &bull; ProRes RAW</text>
  
  <!-- Audio Waveform -->
  <path d="M55 270 Q 75 250, 95 270 T 135 270 T 175 250 T 215 270 T 255 240 T 295 270 T 335 270 T 365 270" stroke="#06B5F9" stroke-width="2" fill="none"/>

  <!-- Timeline Panel Below -->
  <rect x="40" y="310" width="520" height="95" rx="8" fill="#0A2038" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="60" y="335" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// MULTI-TRACK TIMELINE (DAVINCI RESOLVE / PREMIERE)</text>
  <rect x="60" y="348" width="160" height="18" rx="4" fill="#06B5F9" fill-opacity="0.4"/>
  <text x="70" y="361" fill="#ffffff" font-family="monospace" font-size="9">V1: Commercial 4K A-Roll</text>

  <rect x="230" y="348" width="120" height="18" rx="4" fill="#34D399" fill-opacity="0.4"/>
  <text x="240" y="361" fill="#ffffff" font-family="monospace" font-size="9">V2: 3D Product B-Roll</text>

  <rect x="360" y="348" width="180" height="18" rx="4" fill="#06B5F9" fill-opacity="0.4"/>
  <text x="370" y="361" fill="#ffffff" font-family="monospace" font-size="9">A1: Master Dolby Audio</text>

  <!-- Side Metrics -->
  <rect x="400" y="65" width="160" height="110" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="415" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// AD RETENTION</text>
  <text x="415" y="120" fill="#34D399" font-family="sans-serif" font-size="22" font-weight="900">72.4%</text>
  <text x="415" y="145" fill="#B8C7D9" font-family="monospace" font-size="10">3s Hook Rate (+44%)</text>

  <rect x="400" y="185" width="160" height="110" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="415" y="210" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// CONVERSION LIFT</text>
  <text x="415" y="240" fill="#06B5F9" font-family="sans-serif" font-size="22" font-weight="900">+85%</text>
  <text x="415" y="265" fill="#B8C7D9" font-family="monospace" font-size="10">Paid Video Ad ROAS</text>
</svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     KEY TAKEAWAYS & EXECUTIVE SUMMARY (Reference Feature B)
     ============================================================ -->
<section class="srv-section srv-section-takeaways" style="padding-top: 0; padding-bottom: 2.5rem;">
  <div class="srv-container">
    <div class="srv-key-takeaways">
      <div class="srv-takeaways-header">
        <div class="srv-takeaways-kicker">
          <svg class="srv-takeaways-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          <span>KEY TAKEAWAYS &bull; AT A GLANCE</span>
        </div>
        <span class="srv-takeaways-pill">Core Execution Highlights</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">4K / 6K</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Cinema Cinema Production</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">72%+</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Average 3-Second Hook Rate</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">+85%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Conversion Rate Lift</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Broadcast Licensing Rights</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
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
          <span>VISUAL STORYTELLING FRAMEWORK</span>
        </div>
        <h2 class="srv-section-title">
          Cinematic Storytelling Engineered for <span class="text-brand">Direct Commercial Impact</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          In an era of relentless algorithmic scrolling, dull stock imagery and amateur smartphone footage will actively undermine your brand value and balloon your customer acquisition costs.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we bridge the gap between Hollywood-grade cinematography and direct-response performance marketing. From 4K commercial camera packages and studio lighting to 3D motion graphics and narrative brand films, our video assets are engineered to build trust and compel action.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Cinema-Grade Studio &amp; On-Location Production:</strong> 
              <span class="text-secondary">Sony FX / RED 4K/6K cinema packages, precision lighting, and professional audio capture.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">High-Converting Performance Video Ads:</strong> 
              <span class="text-secondary">Scripted for Meta, TikTok, and YouTube with verified 3-second hook structures.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">3D Product Visualization &amp; Motion Design:</strong> 
              <span class="text-secondary">Photorealistic Blender and Cinema4D exploded views and micro-feature showcases.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Corporate Documentaries &amp; Case Study Films:</strong> 
              <span class="text-secondary">Compelling narrative proof that convinces enterprise buying committees to say yes.</span>
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
            <span class="srv-hud-title">CREATIVE STUDIO TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              PRODUCTION PIPELINE ACTIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time telemetry tracking viewer drop-off curves, hook rates, and video ad conversion lift.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">72.4%</div>
                <div class="srv-hud-metric-label">3-Sec Hook Rate</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">+85%</div>
                <div class="srv-hud-metric-label">Video Ad Conv Lift</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4K 60P</div>
                <div class="srv-hud-metric-label">Native Master Format</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">14 Days</div>
                <div class="srv-hud-metric-label">Average Turnaround</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">DaVinci Resolve</span>
              <span class="srv-tool-badge">Premiere Pro</span>
              <span class="srv-tool-badge">Blender 3D</span>
              <span class="srv-tool-badge">After Effects</span>
              <span class="srv-tool-badge">Dolby Master</span>
              <span class="srv-tool-badge">RED Cinema</span>
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
        <span>COMPREHENSIVE CAPABILITIES</span>
      </div>
      <h2 class="srv-section-title">
        Specialized Services Built for <span class="text-brand">Enterprise Scale</span>
      </h2>
      <p class="srv-section-subtitle">
        Every capability is executed by veteran specialists dedicated to predictable return on investment and zero fluff.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg></div>
        </div>
        <h3 class="srv-card-title">Direct-Response Performance Video Ads</h3>
        <p class="srv-card-desc">High-converting short-form video ads scripted, filmed, and edited specifically to stop the scroll and drive immediate purchases on Meta, TikTok, and YouTube.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>3-Second Hook Pattern Interrupts</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Kinetic On-Screen Captions &amp; Sound Effects</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Split-Test Variant Drops (3 Hooks x 2 CTAs)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Vertical 9:16 &amp; Horizontal 16:9 Renders</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Lowers cost per acquisition by keeping ad creative fresh and engaging.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Direct-Response Performance Video Ads')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg></div>
        </div>
        <h3 class="srv-card-title">Commercial Product Cinematography &amp; Photography</h3>
        <p class="srv-card-desc">Studio and on-location commercial photography capturing your physical products with macro lenses, controlled studio lighting, and texture styling.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>High-Speed Macro Fluid Motion Rigs</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Multi-Angle Studio Product Photography</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Lifestyle &amp; In-Context Model Shoots</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Color-Accurate Master Retouching</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Elevates product desirability and dramatically reduces return rates.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Commercial Product Cinematography & Photography')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        </div>
        <h3 class="srv-card-title">3D Product Modeling &amp; Motion Design</h3>
        <p class="srv-card-desc">Photorealistic 3D product animation built in Blender and Cinema 4D, showcasing internal components, engineering features, and sleek materials.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>CAD-to-Polygon 3D Optimization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Photorealistic Texture &amp; Material Physics</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Exploded Mechanism Animations</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Abstract Architectural Motion Graphics</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Visualizes technical superiority before physical manufacturing is complete.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('3D Product Modeling & Motion Design')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        </div>
        <h3 class="srv-card-title">Corporate Brand Films &amp; Executive Documentaries</h3>
        <p class="srv-card-desc">Cinematic narrative films showcasing your founders, engineering facilities, company culture, and customer transformation stories.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Multi-Camera 4K Executive Interviews</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Cinematic B-Roll of Operations &amp; Labs</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Original Musical Scoring &amp; Sound Design</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Dolby 5.1 &amp; Stereo Audio Mastering</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Builds unshakeable corporate prestige for enterprise sales and investor relations.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Corporate Brand Films & Executive Documentaries')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">Video Case Studies &amp; Client Testimonials</h3>
        <p class="srv-card-desc">Documentary-style client video testimonials that capture authentic emotional transformation, hard financial metrics, and undeniable peer proof.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Remote 4K Director Kits &amp; On-Site Crews</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Structured Metric-Driven Interview Scripting</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>B-Roll Integration of Client Using Product</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Social Cutdowns for Sales Rep Outbound</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Serves as the highest-converting closing asset for your sales team.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Video Case Studies & Client Testimonials')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div>
        </div>
        <h3 class="srv-card-title">Social-First Video Packages (Reels, TikTok &amp; Shorts)</h3>
        <p class="srv-card-desc">High-velocity monthly video production delivering batch packages of educational, entertaining, and promotional short-form content.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Trend-Aware Scripting &amp; Storyboards</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Batch Studio Filming Days</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Native App Platform Transitions</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Content Calendar Scheduling Integration</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Maintains an omnipresent, authoritative presence across all social algorithms.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Social-First Video Packages (Reels, TikTok & Shorts)')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5 — OUR PROCESS
     ============================================================ -->
<section class="srv-section" id="process">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>STRUCTURED EXECUTION TIMELINE</span>
      </div>
      <h2 class="srv-section-title">
        The 6-Phase Engineering &amp; Delivery <span class="text-brand">Framework</span>
      </h2>
      <p class="srv-section-subtitle">
        Predictable milestones, rigorous testing checkpoints, and full visibility at every stage of the project lifecycle.
      </p>
    </div>

        <div class="srv-process-nav" role="tablist" aria-label="Process Milestones">
      <button type="button" class="srv-process-pill is-active" data-step="01"><span class="srv-pill-num">1</span> Phase 01</button>
      <button type="button" class="srv-process-pill" data-step="02"><span class="srv-pill-num">2</span> Phase 02</button>
      <button type="button" class="srv-process-pill" data-step="03"><span class="srv-pill-num">3</span> Phase 03</button>
      <button type="button" class="srv-process-pill" data-step="04"><span class="srv-pill-num">4</span> Phase 04</button>
      <button type="button" class="srv-process-pill" data-step="05"><span class="srv-pill-num">5</span> Phase 05</button>
      <button type="button" class="srv-process-pill" data-step="06"><span class="srv-pill-num">6</span> Phase 06</button>
    </div>

    <div class="srv-process-timeline">
      <div class="srv-process-card" data-step="01">
        <div class="srv-phase-badge">PHASE 01 &bull; WEEKS 1–2</div>
        <h3 class="srv-process-title">Creative Brief, Concepting &amp; Scripting</h3>
        <p class="srv-card-desc mb-3">We define the core commercial objective, analyze competitor visual tropes, craft compelling scripts, and build visual storyboards.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Creative Strategy Brief</li>
            <li>Word-for-Word Scripts with Visual Cues</li>
            <li>Scene-by-Scene Visual Storyboards</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; WEEKS 2–3</div>
        <h3 class="srv-process-title">Pre-Production &amp; Logistics Planning</h3>
        <p class="srv-card-desc mb-3">We scout locations, cast professional talent, design studio sets, prepare equipment packages, and assemble call sheets.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Cast &amp; Location Confirmations</li>
            <li>Production Call Sheet &amp; Schedule</li>
            <li>Set Design &amp; Wardrobe Palette Approval</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; WEEKS 3–4</div>
        <h3 class="srv-process-title">Principal Photography &amp; Cinema Production</h3>
        <p class="srv-card-desc mb-3">Our crew executes principal photography using 4K/6K cinema packages, precision lighting, and multi-channel master audio.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Complete Raw Cinema Footage Capture</li>
            <li>Dual On-Site Data Backups (RAID)</li>
            <li>Client Remote Video Feed Monitoring</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; WEEKS 4–5</div>
        <h3 class="srv-process-title">Editorial Assembly &amp; Rough Cut Review</h3>
        <p class="srv-card-desc mb-3">We assemble the narrative timeline, pacing, and dialogue flow, delivering an interactive rough cut for your executive team.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Frame.io Interactive Video Review Link</li>
            <li>Rough Cut Editorial Assembly</li>
            <li>Feedback &amp; Revision Tracking</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; WEEKS 5–6</div>
        <h3 class="srv-process-title">Color Grading, 3D VFX &amp; Sound Design</h3>
        <p class="srv-card-desc mb-3">We grade in DaVinci Resolve, animate kinetic motion graphics, and mix immersive sound design with licensed music tracks.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>DaVinci Color Master Grade</li>
            <li>3D Motion Graphics &amp; Captions</li>
            <li>Dolby Master Sound Design</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; WEEKS 6–7</div>
        <h3 class="srv-process-title">Multi-Format Export &amp; Ad Deployment</h3>
        <p class="srv-card-desc mb-3">We render master files in 16:9, 9:16, and 1:1 aspect ratios, providing ProRes archives and web-optimized deliverables for ad managers.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Master ProRes &amp; H.265 Files</li>
            <li>Vertical (9:16) &amp; Horizontal (16:9) Cuts</li>
            <li>Full Commercial License Documentation</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 6 — WHY CHOOSE BUSINESSDOCTOR
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="why-choose-us">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>COMPETITIVE ADVANTAGE</span>
      </div>
      <h2 class="srv-section-title">
        Why Leading Companies Partner with <span class="text-brand">BusinessDoctor</span>
      </h2>
      <p class="srv-section-subtitle">
        We bridge the gap between business strategy and deep technical execution, providing senior expertise without agency bloat.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg></div>
        <h3 class="srv-card-title">Cinema-Grade Camera Gear</h3>
        <p class="srv-card-desc">We film on high-end cinema systems (RED, Sony FX line) paired with prime lenses to deliver rich depth-of-field and Hollywood aesthetics.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">4K / 6K</span>
          <span class="text-muted text-sm ms-2">Native Resolution</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <h3 class="srv-card-title">Direct-Response ROI Focus</h3>
        <p class="srv-card-desc">We are performance marketers first. Every scene, hook, and line of copy is designed to convert viewers into revenue, not win vanity awards.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">+85%</span>
          <span class="text-muted text-sm ms-2">Average ROAS Lift</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div>
        <h3 class="srv-card-title">Rapid Modular Ad Variant Testing</h3>
        <p class="srv-card-desc">We don’t deliver just one video; we deliver multiple hook variations and calls-to-action so your media buyers can test and win.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">3x2 Matrix</span>
          <span class="text-muted text-sm ms-2">Hooks x CTAs per Shoot</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3 class="srv-card-title">100% Broadcast Licensing Rights</h3>
        <p class="srv-card-desc">All music tracks, voiceover talent, and fonts come with lifetime, worldwide commercial and broadcast usage rights included.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Worldwide</span>
          <span class="text-muted text-sm ms-2">Lifetime Usage Included</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        <h3 class="srv-card-title">In-House 3D &amp; VFX Artists</h3>
        <p class="srv-card-desc">Our 3D animators render photorealistic CAD models and exploded mechanisms that physical cameras simply cannot capture.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Photorealistic</span>
          <span class="text-muted text-sm ms-2">Blender &amp; C4D Pipeline</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <h3 class="srv-card-title">Fast 14-Day Delivery Sprints</h3>
        <p class="srv-card-desc">Our streamlined pre-production and editing pipelines allow us to go from concept approval to final master delivery in just two weeks.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">14 Days</span>
          <span class="text-muted text-sm ms-2">Concept to Delivery</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7 — TECHNOLOGY & TOOLS WE USE
     ============================================================ -->
<section class="srv-section" id="technologies">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>TOOLS TO BE USED</span>
      </div>
      <h2 class="srv-section-title">
        Tools to Be <span class="text-brand">Used</span>
      </h2>
      <p class="srv-section-subtitle">
        We select battle-tested, high-performance tooling suited for scale, reliability, and seamless ongoing maintenance.
      </p>
    </div>

    <div class="srv-tech-grid">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Cinema Cameras &amp; Lighting</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Sony FX6 / FX3 Cinema</span>
            <span class="srv-tool-role">Primary 4K 120fps Capture</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">RED Digital Cinema</span>
            <span class="srv-tool-role">6K Raw Commercial Master</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Aputure &amp; Nanlite</span>
            <span class="srv-tool-role">High-CRI Studio Lighting</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Sennheiser &amp; Deity</span>
            <span class="srv-tool-role">Broadcast Lavalier &amp; Shotgun Audio</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Post-Production &amp; Color Grading</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">DaVinci Resolve Studio</span>
            <span class="srv-tool-role">Color Grading &amp; Film Emulation</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Adobe Premiere Pro</span>
            <span class="srv-tool-role">Multi-Track Editorial Assembly</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Adobe After Effects</span>
            <span class="srv-tool-role">Kinetic Typography &amp; Motion Graphics</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">iZotope RX Audio</span>
            <span class="srv-tool-role">Spectral Audio Repair &amp; Mastering</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">3D Animation &amp; Visual Effects</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Blender 3D</span>
            <span class="srv-tool-role">Product Modeling &amp; Cycles Renders</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Cinema 4D + Redshift</span>
            <span class="srv-tool-role">Complex Dynamic Simulations</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Substance 3D Painter</span>
            <span class="srv-tool-role">Physically Based Materials</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Unreal Engine 5</span>
            <span class="srv-tool-role">Real-Time Virtual Environments</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Review &amp; Delivery Platforms</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Frame.io</span>
            <span class="srv-tool-role">Timecode-Accurate Client Review</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Artlist / Musicbed</span>
            <span class="srv-tool-role">Global Broadcast Music Licensing</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Dropbox Replay</span>
            <span class="srv-tool-role">Multi-Platform Video Handoff</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Apple ProRes 422 HQ</span>
            <span class="srv-tool-role">Lossless Master Archive Standard</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8 — INDUSTRY USE CASES
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="industry-use-cases">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>INDUSTRY SPECIALIZATION</span>
      </div>
      <h2 class="srv-section-title">
        Tailored Solutions for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        We solve domain-specific compliance, performance, and workflow challenges across multiple complex industries.
      </p>
    </div>

        <div class="srv-carousel-wrapper" data-carousel="use-cases">
      <div class="srv-carousel-nav-header">
        <div class="srv-carousel-kicker">
          <span class="text-brand font-mono font-bold">SECTOR ARCHITECTURES</span>
          <span class="text-muted text-sm ml-2">&bull; Interactive scroll &amp; swipe</span>
        </div>
        <div class="srv-carousel-controls">
          <button type="button" class="srv-carousel-btn srv-carousel-prev" aria-label="Previous Sector Solution"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg></button>
          <button type="button" class="srv-carousel-btn srv-carousel-next" aria-label="Next Sector Solution"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
      </div>
      <div class="srv-carousel-track">

      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
          <span class="srv-industry-tag">D2C &amp; CONSUMER LIFESTYLE</span>
        </div>
        <h3 class="srv-card-title">High-Conversion Product Ad Suites</h3>
        <p class="srv-card-desc">Kinetic macro close-ups and unboxing videos showcasing textures, packaging, and real-world application.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">3.8x Return on Ad Spend on TikTok &amp; Meta</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
          <span class="srv-industry-tag">B2B SAAS &amp; ENTERPRISE SOFTWARE</span>
        </div>
        <h3 class="srv-card-title">Cinematic Product Walkthroughs &amp;amp; Teasers</h3>
        <p class="srv-card-desc">Dynamic UI screen recordings paired with 3D isometric graphics and professional voiceover explaining complex value props.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">+48% Increase in Homepage Demo Booking</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <span class="srv-industry-tag">HEALTHCARE &amp; BIOTECH</span>
        </div>
        <h3 class="srv-card-title">Empathetic Patient Story Documentaries</h3>
        <p class="srv-card-desc">High-production clinical documentaries showcasing patient recoveries, physician expertise, and sterile lab technologies.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">94% Viewer Retention on Educational Case Videos</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
          <span class="srv-industry-tag">LUXURY REAL ESTATE &amp; RESORTS</span>
        </div>
        <h3 class="srv-card-title">4K Drone &amp;amp; Architectural Cinematography</h3>
        <p class="srv-card-desc">Golden-hour aerial flyovers, stabilized interior walkthroughs, and lifestyle vignettes for multi-million-dollar listings.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">M+ in Inbound International Inquiries</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
          <span class="srv-industry-tag">FINTECH &amp; INVESTMENT FIRMS</span>
        </div>
        <h3 class="srv-card-title">High-Trust Corporate Brand Films</h3>
        <p class="srv-card-desc">Executive interviews and trading floor b-roll that project financial stability, regulatory compliance, and technological prowess.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Instituted as Core Pitch Deck Asset for Series B</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
          <span class="srv-industry-tag">MANUFACTURING &amp; INDUSTRIAL</span>
        </div>
        <h3 class="srv-card-title">Factory Tour &amp;amp; Engineering Showcase</h3>
        <p class="srv-card-desc">Robotics in motion, laser cutting close-ups, and ISO-certified assembly line footage establishing manufacturing authority.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Replaced In-Person Audits for Overseas Buyers</strong>
        </div>
      </div>
          </div>
      <div class="srv-carousel-dots" aria-hidden="true"></div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 10 — INTERACTIVE FAQ ACCORDION
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="faq">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>FREQUENTLY ASKED QUESTIONS</span>
      </div>
      <h2 class="srv-section-title">
        Common Questions About <span class="text-brand">Creative Production &amp; Video Marketing</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">What is included in a typical commercial video production package?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>Our full-service packages include end-to-end execution: creative concepting, scriptwriting, professional voiceover, location scouting, casting, 4K/6K cinema camera filming, professional lighting grids, audio capture, editorial cutting, DaVinci Resolve color grading, motion graphics, licensed commercial music, and export in all social and broadcast aspect ratios.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Can you shoot on location at our company offices or factory?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Our production crews regularly travel nationwide and internationally with compact, airline-approved cinema gear to film on-site at corporate headquarters, manufacturing facilities, medical clinics, and remote client locations.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How many revisions do we get during the video editing phase?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We conduct structured feedback milestones using Frame.io, allowing you to click anywhere on the video frame and leave exact time-stamped comments. We include up to two rounds of comprehensive revisions after the initial rough cut to guarantee perfection.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Do you provide vertical (9:16) video cuts for Instagram Reels and TikTok?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We plan for multi-format delivery during the storyboard stage. Our cameras compose shots that allow native vertical 9:16 crops with customized kinetic captions optimized specifically for Instagram Reels, TikTok, and YouTube Shorts.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Who owns the final video files and raw footage?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You receive 100% full ownership and worldwide commercial broadcast rights to all final rendered video assets upon project completion. Raw footage archives can also be delivered on portable hard drives upon request.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How long does the entire production process take from start to finish?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>A typical commercial or performance video ad project takes 2 to 4 weeks from initial concept and script approval to final delivery. Rapid short-form social video batches can often be delivered in under 10 business days.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Can you create animated 3D product videos if we do not have physical prototypes yet?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. If you provide CAD files (STEP, IGES, OBJ, or FBX), our 3D team can texture, light, and animate photorealistic 3D renders that look identical to a physical product before your manufacturing tooling is even finished.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">How does your team ensure video ads actually convert into revenue?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We structure scripts using proven direct-response marketing principles: immediate 3-second pattern interrupts, rapid identification of customer pain points, clear demonstration of your unique solution, social proof, and a single, compelling call to action.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 11 — FINAL CONVERSION CTA
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
          Ready to Elevate Your Brand with <span class="text-brand">Cinema-Grade Video?</span>
        </h2>
            <p class="srv-cta-lead">
          Schedule a creative consultation. Our executive producers will review your campaign objectives, analyze your brand visual assets, and present tailored commercial concepts.
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
                  <label class="srv-form-label" for="quick_name_video-editing.php">Your Full Name</label>
                  <input type="text" id="quick_name_video-editing.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_video-editing.php">Work Email</label>
                  <input type="email" id="quick_email_video-editing.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_video-editing.php">Company / Domain</label>
                  <input type="text" id="quick_company_video-editing.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_video-editing.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_video-editing.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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
  </div>
</section>
