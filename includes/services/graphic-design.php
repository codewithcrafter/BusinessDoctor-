<?php
/**
 * BusinessDoctor Service Detail View — Graphic Design & Brand Identity
 * Discipline 05 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Graphic Design';
$serviceSlug = 'graphic-design';
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
          <span>Creative Design and Branding Agency</span>
        </div>
        <h1 class="srv-hero-title">
          Graphic Design Company in Delhi <br><span class="text-brand">That Turns Visuals Into Customers</span>
        </h1>
        <p class="srv-hero-desc">
          BusinessDoctor is a graphic design company in Delhi for businesses that want more than a nice-looking logo. We build brand identities, packaging, print material and social media creatives that earn trust at first glance and push buyers towards one action: contacting you.
        </p>

        <div class="srv-hero-actions">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Get a Free Design Quote</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.design :: brand-identity-system</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// VECTOR ACCURACY &amp; BRAND GUIDELINES</text>
              <circle cx="160" cy="140" r="45" stroke="#34D399" stroke-width="2"/>
              <polygon points="260,105 300,175 220,175" stroke="#06B5F9" stroke-width="2" fill="none"/>
              <rect x="330" y="110" width="60" height="60" stroke="#FBBF24" stroke-width="2" fill="none"/>
              <text x="420" y="145" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">100% Custom Vector Art</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DELIVERY TIMELINE</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">5-7 Days</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Logo Concepts &amp; Reasoning</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">Print &amp; Web Ready Formats</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// ASSET EXPORTS</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">AI &bull; PSD</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">PDF &bull; PNG &bull; SVG &bull; EPS</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">Complete Source Files Handover</text>
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
        <span class="srv-takeaways-pill">Quick Summary</span>
      </div>
      <div class="srv-takeaways-grid">
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Full Scope</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Full Service</span>
          <p class="srv-takeaway-desc">Logo, branding, print, packaging, social media and UI/UX from one experienced graphic design company in Delhi.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Goal-Led</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Goal-Led Design</span>
          <p class="srv-takeaway-desc">Every project begins with your audience, competitors and business goal.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Clear</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Transparent Terms</span>
          <p class="srv-takeaway-desc">Itemised quote, fixed timeline and revision rounds agreed upfront.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">Ready</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Ready to Use</span>
          <p class="srv-takeaway-desc">Files for print, web and social media, with source files handed over to you.</p>
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
          Turning Your Brand Image Into a <span class="text-brand">Steady Stream of Enquiries</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Most businesses spend on ads, SEO and printing, yet lose customers at the first look. A mismatched logo, a crowded brochure or an untidy Instagram feed makes buyers hesitate, and hesitation costs sales.
        </p>
        <p class="srv-card-desc mb-4">
          Choosing the right graphic design company in Delhi fixes this at the root. When your visuals are consistent and professional, every rupee you spend on marketing performs better, and your sales team spends less time convincing people that you are the right choice.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Brand Clarity:</strong> 
              <span class="text-secondary">One logo, colour system and font set across every touchpoint.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Faster Decisions:</strong> 
              <span class="text-secondary">Clean layouts that help buyers find prices, features and contact details quickly.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Lower Rework Costs:</strong> 
              <span class="text-secondary">Print-ready files built correctly the first time, so you avoid wasted reprints.</span>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary">
            <span>Book a Free Consultation</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <div class="srv-col-12 srv-col-lg-6 mt-4 mt-lg-0">
        <div class="srv-hud-card">
          <div class="srv-hud-header">
            <span class="srv-hud-title">DESIGN DELIVERY SNAPSHOT</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              WHAT EVERY PROJECT INCLUDES
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time design deliverables and production standards guaranteed with every client engagement.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">5-7 Days</div>
                <div class="srv-hud-metric-label">Logo Turnaround</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Concepts</div>
                <div class="srv-hud-metric-label">Presented With Reasoning</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">Revisions</div>
                <div class="srv-hud-metric-label">Included as Per Quote</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">AI &bull; PSD</div>
                <div class="srv-hud-metric-label">Source &amp; Export Files</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Logo Design</span>
              <span class="srv-tool-badge">Brand Identity</span>
              <span class="srv-tool-badge">Print &amp; Brochure</span>
              <span class="srv-tool-badge">Packaging</span>
              <span class="srv-tool-badge">Social Creatives</span>
              <span class="srv-tool-badge">UI/UX Web</span>
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
        <span>SERVICES</span>
      </div>
      <h2 class="srv-section-title">
        Graphic Design Services in Delhi <span class="text-brand">Built for Growing Businesses</span>
      </h2>
      <p class="srv-section-subtitle">
        Whether you are launching a new brand or refreshing an old one, our graphic design services in Delhi cover everything under one roof. Every service is handled by one team, so your brand looks the same on a signboard, a catalogue and a social media post, and you never have to chase separate freelancers.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Service Card 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
        </div>
        <h3 class="srv-card-title">Logo Design</h3>
        <p class="srv-card-desc">As a logo design company in Delhi, we create simple, memorable marks that stay sharp from a visiting card to a shop signboard.</p>
        <ul class="srv-card-list">
          <li>Multiple concepts with clear reasoning</li>
          <li>Scalable vector files</li>
          <li>Colour, black and white versions</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>A recognisable logo helps customers remember you and recommend you.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/><line x1="16" y1="8" x2="2" y2="22"/><line x1="17.5" y1="15" x2="9" y2="15"/></svg>
        </div>
        <h3 class="srv-card-title">Brand Identity Design</h3>
        <p class="srv-card-desc">Colours, typography, icons and usage rules in one guide. As a branding agency in Delhi, we keep your business consistent everywhere customers see it.</p>
        <ul class="srv-card-list">
          <li>Colour palette and typography</li>
          <li>Brand guidelines document</li>
          <li>Business cards and stationery</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Consistent branding builds trust and supports fair pricing.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <h3 class="srv-card-title">Brochure and Print Design</h3>
        <p class="srv-card-desc">Brochures, catalogues and company profiles organised for easy reading and strong first impressions.</p>
        <ul class="srv-card-list">
          <li>Brochures and catalogues</li>
          <li>Flyers, posters and standees</li>
          <li>Company profiles</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Clear layouts help buyers decide faster in meetings and exhibitions.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <h3 class="srv-card-title">Packaging Design</h3>
        <p class="srv-card-desc">Our packaging design services help your product stand out on the shelf and arrive at your printer in a clean, production-ready file.</p>
        <ul class="srv-card-list">
          <li>Box and label design</li>
          <li>Print-ready layouts</li>
          <li>Shelf and marketplace visibility</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Strong packaging helps your product get noticed and picked.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </div>
        <h3 class="srv-card-title">Social Media Creatives</h3>
        <p class="srv-card-desc">Posts, carousels and ad banners that match your brand and keep your page looking active and professional.</p>
        <ul class="srv-card-list">
          <li>Posts and carousels</li>
          <li>Ad banners</li>
          <li>Reel covers and templates</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>A polished feed builds credibility and supports paid campaigns.</span>
        </div>
        <div class="mt-3">
          <a href="<?= e($consultationUrl) ?>" class="text-brand" style="font-weight: 600; font-size: 0.9rem;">Inquire About This Service &rarr;</a>
        </div>
      </div>

      <!-- Service Card 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title">UI/UX and Web Graphics</h3>
        <p class="srv-card-desc">Website banners, landing page visuals and app screens designed to guide visitors towards one clear action.</p>
        <ul class="srv-card-list">
          <li>Website banners</li>
          <li>Landing page visuals</li>
          <li>App and dashboard screens</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Clear visuals reduce confusion and increase calls, messages and sales.</span>
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
        <span>FRAMEWORK</span>
      </div>
      <h2 class="srv-section-title">
        The 6-Phase Design and <span class="text-brand">Delivery Framework</span>
      </h2>
      <p class="srv-section-subtitle">
        Clear milestones, honest timelines and approvals at every stage. This is how our creative design agency in Delhi keeps every project on track.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Phase 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 01 – Discovery and Brief</h3>
          <p class="srv-step-desc">We learn your business, customers, competitors and goals through a short briefing.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Written design brief &bull; Competitor snapshot</span>
          </div>
        </div>
      </div>

      <!-- Phase 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 02 – Research and Direction</h3>
          <p class="srv-step-desc">We study your market and share style directions for approval before any design begins.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Moodboard &bull; Colour and style direction</span>
          </div>
        </div>
      </div>

      <!-- Phase 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 03 – Concept Design</h3>
          <p class="srv-step-desc">Our designers create the first concepts from the approved direction and explain each choice.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Initial concepts &bull; Design rationale</span>
          </div>
        </div>
      </div>

      <!-- Phase 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 04 – Feedback and Revisions</h3>
          <p class="srv-step-desc">You share your thoughts and we refine the work, round by round, until it feels right.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Revision rounds as per quote &bull; Refined designs</span>
          </div>
        </div>
      </div>

      <!-- Phase 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 05 – Finalisation</h3>
          <p class="srv-step-desc">We prepare final files in the correct size, resolution and colour mode.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Print-ready files &bull; Web-ready exports</span>
          </div>
        </div>
      </div>

      <!-- Phase 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">Phase 06 – Delivery and Support</h3>
          <p class="srv-step-desc">You receive every source and export file, along with simple guidance on using them.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Source files &bull; Brand usage guidance</span>
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
        Why Growing Brands Choose BusinessDoctor as Their <span class="text-brand">Graphic Design Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Plenty of designers can make something pretty, but pretty alone does not fill your enquiry inbox. We combine creative skill with business thinking and clear communication, which is why clients return for their next project.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Goal-Led Design</div>
        <h3 class="srv-benefit-title">Business-First Thinking</h3>
        <p class="srv-benefit-desc">Every design is built around a goal, whether that is enquiries, sales or a stronger first impression.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Zero Templates</div>
        <h3 class="srv-benefit-title">100% Original Work</h3>
        <p class="srv-benefit-desc">Every design is created from scratch. No stock templates, no copied artwork.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Multi-Industry Experience</div>
        <h3 class="srv-benefit-title">Experienced Designers</h3>
        <p class="srv-benefit-desc">Our team has handled projects across many industries and knows what works in your market.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Fixed Timelines</div>
        <h3 class="srv-benefit-title">On-Time Delivery</h3>
        <p class="srv-benefit-desc">You get a clear timeline at the start, and we respect it.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">No Hidden Charges</div>
        <h3 class="srv-benefit-title">Honest, Clear Pricing</h3>
        <p class="srv-benefit-desc">A simple quote that lists exactly what is included.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Consistent Everywhere</div>
        <h3 class="srv-benefit-title">Complete Marketing Support</h3>
        <p class="srv-benefit-desc">Designs that fit your website, SEO and social media marketing.</p>
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
        Tools We Use <span class="text-brand">to Design</span>
      </h2>
      <p class="srv-section-subtitle">
        Every designer at our graphic design company in Delhi works with industry-standard software, so you get sharp, flexible files that any printer or platform can use.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Branding and Logo</h3>
        <ul class="srv-tech-list">
          <li>Adobe Illustrator</li>
          <li>CorelDRAW</li>
          <li>Adobe Photoshop</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Print and Packaging</h3>
        <ul class="srv-tech-list">
          <li>Adobe InDesign</li>
          <li>Adobe Acrobat Pro</li>
          <li>Pantone Colour System</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">UI/UX and Web</h3>
        <ul class="srv-tech-list">
          <li>Figma</li>
          <li>FigJam</li>
          <li>Google Fonts</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Motion and Social</h3>
        <ul class="srv-tech-list">
          <li>Adobe After Effects</li>
          <li>Adobe Premiere Pro</li>
          <li>Adobe Photoshop</li>
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
        <span>SECTORS</span>
      </div>
      <h2 class="srv-section-title">
        Tailored Graphic Design for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        Different industries need different visual language. A clinic should look calm and trustworthy, while a restaurant should look warm and tempting. As a graphic design company in Delhi that works across sectors, we study how your buyers think before we open any software.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <h3 class="srv-card-title">Real Estate</h3>
        <p class="srv-card-desc">Project branding, brochures, hoardings and sales kits that make developments look premium and credible.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Typical Deliverables</span>
          <span>Brochures &bull; Hoardings &bull; Project Logos</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Healthcare</h3>
        <p class="srv-card-desc">Clean, calm and trust-building material for clinics, hospitals and wellness brands.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Typical Deliverables</span>
          <span>Clinic Branding &bull; Patient Leaflets &bull; Social Posts</span>
        </div>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">E-commerce and D2C</h3>
        <p class="srv-card-desc">Product banners, marketplace graphics and packaging that help online shoppers choose you.</p>
        <div class="srv-sector-outcome">
          <span class="srv-outcome-badge">Typical Deliverables</span>
          <span>Packaging &bull; Banners &bull; Ad Creatives</span>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <p style="color: var(--color-text-muted); font-size: 0.95rem;">
        We also design for education, restaurants, startups and B2B manufacturers.
      </p>
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
        Common Questions About <span class="text-brand">Graphic Design in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our graphic design services, pricing, timelines, and deliverables.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">1. What does a graphic design company in Delhi do?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>A graphic design company in Delhi creates visual material for businesses, including logos, brand identities, brochures, packaging, social media creatives and website graphics.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">2. How much do graphic design services in Delhi cost?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>The price depends on your requirement. A single logo costs less than a full brand identity or a multi-page catalogue. Share your needs and we will send a clear, itemised quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">3. How long does a logo design project take?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Most logo projects take five to seven working days, depending on how quickly you share feedback.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">4. Will I get the source files?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. After final payment, you receive the editable source files and export formats for print and digital use.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">5. How many revisions are included?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Every package includes revision rounds until the design matches the approved brief. The exact number is mentioned in your quote.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">6. Can you design for both print and digital?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Our graphic design services in Delhi cover both. We prepare every file in the right size, resolution and colour mode for print, websites and social media.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">7. Do you work with startups and small businesses?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We offer practical branding packages for startups, and we also support established companies that need a refresh. A new business gets a complete identity on a sensible budget, and an older one gets a cleaner, more modern look without losing the recognition it has already built.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-8">
          <span class="srv-faq-question">8. How do I get started?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-8" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Fill in the enquiry form or call us. We will understand your requirement, suggest the right services and share a timeline and quote within one working day.</p>
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
              Ready to Hire a Graphic Design Company in Delhi <span class="text-brand">You Can Trust?</span>
            </h2>
            <p class="srv-cta-lead">
              Tell us about your business and we will suggest the right design approach, timeline and budget, with no obligation. Whether you need a logo, a full brand identity or a year of social media creatives, let BusinessDoctor make your brand look as good as your work deserves. Your competitors are already improving how they look, so the best time to start is today.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Book Your Free Consultation</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Free Audit</span>
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
                <span class="text-secondary">Response Time: Within 24 working hours</span>
              </div>
            </div>
          </div>
          <div>
            <div class="srv-quick-form-card">
              <div class="srv-form-header">
                <h3 class="srv-form-title">Request Design Consultation</h3>
                <p class="srv-form-subtitle">Direct consultation with senior creative leads.</p>
              </div>
              <form action="<?= appUrl('contact') ?>" method="GET" class="srv-quick-form">
                <input type="hidden" name="service" value="<?= e($serviceName) ?>">
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_name_graphic-design">Your Full Name</label>
                  <input type="text" id="quick_name_graphic-design" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_graphic-design">Work Email</label>
                  <input type="email" id="quick_email_graphic-design" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_graphic-design">Company / Domain</label>
                  <input type="text" id="quick_company_graphic-design" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_graphic-design">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_graphic-design" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your design needs, brand goals, or timelines..."></textarea>
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