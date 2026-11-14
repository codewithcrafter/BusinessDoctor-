<?php
/**
 * BusinessDoctor Service Detail View — Product Photography
 * Discipline 08 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Product Photography';
$serviceSlug = 'product-photography';
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
          <span>COMMERCIAL STUDIO & VISUAL DETAIL</span>
        </div>
        <h1 class="srv-hero-title">
          Commercial Studio Photography that <br><span class="text-brand">Converts Browsers into Buyers</span>
        </h1>
        <p class="srv-hero-desc">
          High-resolution commercial product imagery tailored for e-commerce storefronts, Amazon listings, and luxury print catalogs: clean pure-white background catalog shots, stylized lifestyle staging, 360-degree interactive captures, and macro texture detailing.
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
            <span class="srv-hero-stat-val">4K / 8K</span>
            <span class="srv-hero-stat-lbl">Commercial Resolution</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">+45%</span>
            <span class="srv-hero-stat-lbl">Product Page Conversion</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Marketplace Compliant</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">RGB 255</span>
            <span class="srv-hero-stat-lbl">Pure White Accuracy</span>
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
              <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DISCIPLINE // 08</text>
              <text x="70" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Product Photography</text>
              <text x="70" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Active Execution &bull; Calibrated</text>

              <rect x="320" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="340" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// AUDIT &amp; QUALITY</text>
              <text x="340" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Enterprise SLA Standards</text>
              <text x="340" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Continuous Accountability</text>

              <line x1="280" y1="115" x2="320" y2="115" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

              <rect x="50" y="180" width="500" height="225" rx="10" fill="#051424" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
              <text x="70" y="210" fill="#34D399" font-family="monospace" font-size="12">$ execute --benchmark product-photography</text>
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
          <span>VISUAL CONVERSION STANDARDS</span>
        </div>
        <h2 class="srv-section-title">
          Why High-Resolution Photography is Your <span class="text-brand">Best Sales Closer</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          In digital commerce, your customer cannot physically touch, hold, or inspect your product. Low-resolution photos, inaccurate colors, or sloppy lighting instantly introduce doubt, driving potential buyers straight to competitors with higher return rates.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, our commercial photography studio utilizes full-frame high-resolution camera systems, color-calibrated Profoto lighting, and rigorous post-production retouching. We deliver crystal-clear imagery that highlights craftsmanship and accelerates purchasing decisions.
        </p>

        <div class="srv-feature-list mb-4">
                    <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Pure White RGB 255 Catalog Shots:</strong> 
              <span class="text-secondary">100% compliant with Amazon, Flipkart, and Google Shopping technical standards.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Contextual Lifestyle Staging:</strong> 
              <span class="text-secondary">Stylized tabletop and environmental sets that demonstrate product scale, usage, and luxury appeal.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Precision Color Calibration:</strong> 
              <span class="text-secondary">Calibrated with X-Rite ColorChecker charts to ensure on-screen colors match physical products perfectly.</span>
            </div>
          </div>          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Macro Texture & Material Detailing:</strong> 
              <span class="text-secondary">Extreme close-up macro captures revealing premium textures, stitching, and precision engineering.</span>
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
            <span class="srv-hud-title">STUDIO CALIBRATION TELEMETRY</span>
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
                <div class="srv-hud-metric-num">61 MP</div>
                <div class="srv-hud-metric-label">Camera Sensor Stills</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">sRGB / Adobe RGB Color</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.00</div>
                <div class="srv-hud-metric-label">Color Delta-E Variance</div>
              </div>              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">24-48h</div>
                <div class="srv-hud-metric-label">Sample Turnaround</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Sony Alpha Full-Frame</span>
<span class="srv-tool-badge">Capture One Pro</span>
<span class="srv-tool-badge">Profoto Studio Strobes</span>
<span class="srv-tool-badge">Adobe Lightroom</span>
<span class="srv-tool-badge">Photoshop CC</span>
<span class="srv-tool-badge">X-Rite ColorChecker</span>

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
        Eliminating Costly <span class="text-brand">E-Commerce Product Visual Flaws</span>
      </h2>
      <p class="srv-section-subtitle">
        Common photography mistakes that suppress e-commerce conversion rates and spike returns.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Smartphone Photo Quality</h3>
        <p class="srv-card-desc">Shooting products on mobile phones produces lens distortion, digital grain, and inconsistent color rendition.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">High Return Rates from Color Mismatch</h3>
        <p class="srv-card-desc">Inaccurate white balance causes customers to receive items that look completely different from the website.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Amazon & Marketplace Rejection</h3>
        <p class="srv-card-desc">Non-compliant background gray values or incorrect pixel dimensions get product listings flagged or suppressed.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">No Sense of Scale or Context</h3>
        <p class="srv-card-desc">Catalog-only shots without lifestyle context leave shoppers guessing about dimensions and practical use.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Harsh Shadows & Blown Highlights</h3>
        <p class="srv-card-desc">Uncontrolled studio reflections on metallic, glass, or glossy packaging obscure branding and labels.</p>
      </div>      <div class="srv-card">
        <div class="srv-card-icon-wrap" style="color: #F87171; background: rgba(248, 113, 113, 0.12); border-color: rgba(248, 113, 113, 0.25);">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Slow Multi-Week Studio Turnaround</h3>
        <p class="srv-card-desc">Waiting weeks for product photos delays inventory launches and wastes precious seasonal sales windows.</p>
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
        Commercial <span class="text-brand">Product Photography Scope</span>
      </h2>
      <p class="srv-section-subtitle">
        From sample intake and studio lighting to advanced retouching and multi-format export.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
            <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Pure White Background Catalog Shots</h3>
        <p class="srv-card-desc">Flawless isolation shots on pure white backgrounds (RGB 255, 255, 255) with natural contact shadows.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Amazon & Flipkart primary image compliance</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Precision hand-drawn clipping paths</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Zero haloing or jagged edges</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Stylized Lifestyle & Contextual Sets</h3>
        <p class="srv-card-desc">Curated tabletop staging with props, natural textures, and creative lighting that bring products to life.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Prop sourcing & set construction</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Editorial social media & web banners</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Brand aesthetic color harmony</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">360-Degree Interactive Spin Photography</h3>
        <p class="srv-card-desc">Capturing 24 to 72 sequential frames on motorized turntables for seamless interactive web product inspection.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Smooth 360-degree interactive rotation</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>HTML5 & JavaScript player integration</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Mobile touch & zoom compatibility</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Macro Detail & Texture Close-Ups</h3>
        <p class="srv-card-desc">Ultra-sharp macro photography spotlighting product craftsmanship, materials, controls, and premium finishes.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Fabric, leather, and metal textures</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Ingrediant & formulation close-ups</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Packaging detail and holographic labels</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Commercial Post-Production & Retouching</h3>
        <p class="srv-card-desc">High-end digital cleanup removing dust, microscopic scratches, fingerprints, and color imperfections.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Blemish & reflection cleanup</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Color calibration & tone grading</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Symmetrical reshaping & alignment</span></li></ul></div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title text-white">Multi-Resolution Asset Delivery</h3>
        <p class="srv-card-desc">Delivery of web-optimized WebP, high-res JPEG, transparent PNG, and print-ready TIFF formats.</p>
        <ul style="list-style: none; padding: 0; margin: 1rem 0 0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: #B8C7D9;"><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Web-ready compressed formats</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>High-res archival master files</span></li><li style="display: flex; gap: 0.5rem; align-items: flex-start;"><span style="color: #06B5F9;">&bull;</span><span>Organized SKU folder hierarchy</span></li></ul></div>

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
        <h3 class="srv-process-title">Product Intake & Creative Brief</h3>
        <p class="srv-process-desc">We receive your product samples, review your brand aesthetic guidelines, and create a shot list.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Approved Shot List & Moodboard
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">02</div>
        <h3 class="srv-process-title">Studio Lighting & Staging</h3>
        <p class="srv-process-desc">We calibrate lighting, clean products to perfection, and shoot tethered directly to Capture One.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Tethered Live Capture Review
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">03</div>
        <h3 class="srv-process-title">Digital Retouching & Clipping</h3>
        <p class="srv-process-desc">Our post-production specialists clean blemishes, calibrate colors, create clipping masks, and add shadows.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Retouched Proof Review
        </div>
      </div>      <div class="srv-process-card">
        <div class="srv-process-num">04</div>
        <h3 class="srv-process-title">Final Export & Secure Delivery</h3>
        <p class="srv-process-desc">We export web and print formats organized by SKU numbers and deliver them via secure cloud storage.</p>
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: #06B5F9; font-weight: 700; margin-top: 1rem;">
          MILESTONE: Complete Asset Handover
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
      <div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Camera & Lenses</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Sony Alpha 61MP Full-Frame</span><span class="srv-tool-badge">Sony G-Master 90mm Macro</span><span class="srv-tool-badge">24-70mm f/2.8</span><span class="srv-tool-badge">50mm f/1.2</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Studio Lighting</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Profoto D2 Strobes</span><span class="srv-tool-badge">Softboxes & Octaboxes</span><span class="srv-tool-badge">C-Stands</span><span class="srv-tool-badge">Motorized 360 Turntable</span></div></div>
<div class="srv-card"><h4 style="font-size: 1.1rem; color: #fff; margin-bottom: 1rem; border-bottom: 1px solid rgba(6,181,249,0.2); padding-bottom: 0.5rem;">Post-Production Software</h4><div style="display: flex; flex-wrap: wrap; gap: 0.5rem;"><span class="srv-tool-badge">Capture One Pro</span><span class="srv-tool-badge">Adobe Photoshop CC</span><span class="srv-tool-badge">Lightroom Classic</span><span class="srv-tool-badge">ColorChecker Passport</span></div></div>

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
        Discover how our Product Photography discipline drives measurable outcomes across key vertical markets.
      </p>
    </div>

    <div class="srv-grid srv-grid-2">
            <div class="srv-card">
        <span class="srv-badge mb-2"><span>Cosmetics & Skincare</span></span>
        <h3 class="srv-card-title text-white">Luxury Packaging & Texture Macro</h3>
        <p class="srv-card-desc mb-3">Captured glass dropper bottles, cream textures, and luxury metallic typography with flawless reflection control.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">+52% Conversion Lift</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Electronics & Hardware</span></span>
        <h3 class="srv-card-title text-white">Consumer Tech 360-Degree Spins</h3>
        <p class="srv-card-desc mb-3">Produced interactive 360-degree rotation view showing every port, button, and ergonomic contour.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">35% Lower Return Rate</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Apparel & Footwear</span></span>
        <h3 class="srv-card-title text-white">Catalog Stills & Material Detailing</h3>
        <p class="srv-card-desc mb-3">Shot clean white-background footwear angles paired with macro stitching close-ups and outdoor lifestyle.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">Over 4,000 SKUs Photographed</span>
        </div>
      </div>      <div class="srv-card">
        <span class="srv-badge mb-2"><span>Packaged Food & Beverages</span></span>
        <h3 class="srv-card-title text-white">Tabletop Staging & Fresh Ingredients</h3>
        <p class="srv-card-desc mb-3">Styled artisanal gourmet food packaging alongside raw natural ingredients with warm morning lighting.</p>
        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem;">
          <span style="color: #8FA3B8;">Outcome:</span>
          <span style="color: #34D399; font-family: var(--font-mono); font-weight: 700;">Featured on National Retailers</span>
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
        Common Questions About <span class="text-brand">Product Photography</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear answers about our methodology, timelines, deliverables, SLAs, and commercial engagement terms.
      </p>
    </div>

    <div class="srv-faq-container">
            <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">How do we ship product samples to your studio?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>We provide secure shipping instructions to our commercial studio. We request at least 2 identical samples per SKU to ensure we have backup options in case of minor packaging flaws.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How long does a typical product photography shoot take?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Standard shoots of 10 to 50 SKUs are typically shot, retouched, and delivered within 5 to 7 business days from sample receipt.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Are your photos 100% compliant with Amazon and Flipkart standards?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. All pure white background photos are delivered at RGB (255, 255, 255) with 2000x2000px minimum resolution to activate marketplace zoom features.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Can you shoot lifestyle photography with models?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. We offer lifestyle shoots with hand models or full on-set talent upon request, including location scouting and prop sourcing.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">Do you provide transparent background PNG files?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>Yes. Upon request, we deliver transparent PNG files with hand-clipped vector paths so you can place products onto any background color or marketing graphic.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">What happens to the product samples after the shoot?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We can securely return all samples to your warehouse via your preferred courier, or store them safely in our studio for future seasonal shoots.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">How do you ensure color accuracy?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>We use calibrated X-Rite ColorChecker profiles under color-balanced studio strobes. Our monitors are hardware-calibrated weekly to ensure 100% color fidelity.</p>
          </div>
        </div>
      </div>      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">Who owns the copyright to the final photos?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel" >
          <div class="srv-faq-content">
            <p>You do. Upon final payment, you receive full commercial usage rights for web, social media, marketplaces, print catalogs, and global advertising with zero royalties.</p>
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
              Ready to Elevate Your <span class="text-brand">Product Visuals?</span>
            </h2>
            <p class="srv-cta-lead">
              Book a studio consultation. Send us your sample details and shot list requirements, and our photography leads will deliver a customized shoot plan and proposal.
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
                <p class="srv-form-subtitle">Direct consultation with senior Product Photography strategists.</p>
              </div>
              <form action="<?= appUrl('contact.php') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_product-photography.php">Your Full Name</label>
                  <input type="text" id="quick_name_product-photography.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_product-photography.php">Work Email</label>
                  <input type="email" id="quick_email_product-photography.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_product-photography.php">Company / Domain</label>
                  <input type="text" id="quick_company_product-photography.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_product-photography.php">Project Scope &amp; Goals</label>
                  <textarea id="quick_notes_product-photography.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your objectives, challenges, or current growth bottlenecks..."></textarea>
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