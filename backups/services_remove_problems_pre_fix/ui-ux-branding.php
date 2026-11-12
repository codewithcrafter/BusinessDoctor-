<?php
/**
 * BusinessDoctor Service Detail View — UI/UX Design & Brand Identity
 * Discipline 03 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'UI/UX Design & Brand Identity';
$serviceSlug = 'ui-ux-branding';
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
          <span>HUMAN-CENTERED DESIGN &amp; BRAND SYSTEMS</span>
        </div>
        <h1 class="srv-hero-title">
          Crafting High-Converting <br><span class="text-brand">UI/UX Experiences &amp; Brand Systems</span>
        </h1>
        <p class="srv-hero-desc">
          We engineer intuitive digital products, enterprise design systems in Figma, and iconic brand identities that command authority, reduce user friction, and dramatically elevate conversion rates.
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
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Figma-to-Code Parity</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">+64%</span>
            <span class="srv-hero-stat-lbl">User Task Completion Rate</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">AAA</span>
            <span class="srv-hero-stat-lbl">WCAG Accessibility Standards</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">0-Bloat</span>
            <span class="srv-hero-stat-lbl">Modular Design Tokens</span>
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
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.design :: design-tokens-system.v2</text>
  
  <!-- Canvas Mockup Window -->
  <rect x="40" y="65" width="310" height="340" rx="10" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <rect x="55" y="80" width="280" height="30" rx="6" fill="#0A1D33"/>
  <text x="70" y="100" fill="#06B5F9" font-family="sans-serif" font-size="12" font-weight="bold">DESIGN SYSTEM &bull; FIGMA ATOMS</text>
  
  <!-- Tokens List in Canvas -->
  <rect x="55" y="125" width="130" height="40" rx="6" fill="#06B5F9" fill-opacity="0.2" stroke="#06B5F9"/>
  <text x="65" y="150" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">Primary: #06B5F9</text>
  
  <rect x="195" y="125" width="140" height="40" rx="6" fill="#061326" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="205" y="150" fill="#F5F7FA" font-family="monospace" font-size="11">Navy: #061326</text>

  <rect x="55" y="180" width="280" height="70" rx="8" fill="#0A2038" stroke="#06B5F9" stroke-opacity="0.25"/>
  <text x="70" y="205" fill="#F5F7FA" font-family="sans-serif" font-size="13" font-weight="bold">Component: &lt;AppButton /&gt;</text>
  <text x="70" y="225" fill="#B8C7D9" font-family="monospace" font-size="10">State: Hover &bull; Focus &bull; Active &bull; Disabled</text>
  <rect x="240" y="195" width="80" height="26" rx="4" fill="#06B5F9"/>
  <text x="255" y="212" fill="#061326" font-family="sans-serif" font-size="11" font-weight="bold">Action</text>

  <rect x="55" y="265" width="280" height="120" rx="8" fill="#0A2038" stroke="#06B5F9" stroke-opacity="0.25"/>
  <text x="70" y="290" fill="#F5F7FA" font-family="sans-serif" font-size="12" font-weight="bold">WCAG 2.2 AA Contrast: PASSED</text>
  <text x="70" y="315" fill="#34D399" font-family="monospace" font-size="11">&bull; 8.6:1 AAA on Dark Canvas</text>
  <text x="70" y="335" fill="#34D399" font-family="monospace" font-size="11">&bull; 4.8:1 AA on Light Modals</text>
  <text x="70" y="355" fill="#34D399" font-family="monospace" font-size="11">&bull; 0ms Layout Shifts (CLS)</text>

  <!-- Sidebar Palette & Specs -->
  <rect x="370" y="65" width="190" height="160" rx="10" fill="#0A2038" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
  <text x="385" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// TYPOGRAPHY</text>
  <text x="385" y="115" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Cabinet Grotesk</text>
  <text x="385" y="135" fill="#B8C7D9" font-family="monospace" font-size="11">Display H1-H4</text>
  <text x="385" y="165" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">Inter &bull; Plus Jakarta</text>
  <text x="385" y="185" fill="#B8C7D9" font-family="monospace" font-size="11">Body &bull; 1.65 Line Height</text>
  <text x="385" y="210" fill="#8FA3B8" font-family="monospace" font-size="10">8-Point Spacing Grid</text>

  <rect x="370" y="240" width="190" height="165" rx="10" fill="#0A2038" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
  <text x="385" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// PROTOTYPE FIDELITY</text>
  <circle cx="410" cy="305" r="22" fill="#06B5F9" fill-opacity="0.15" stroke="#06B5F9"/>
  <text x="403" y="310" fill="#06B5F9" font-family="sans-serif" font-size="14" font-weight="bold">100%</text>
  <text x="445" y="300" fill="#F5F7FA" font-family="sans-serif" font-size="12" font-weight="bold">Interactive</text>
  <text x="445" y="318" fill="#B8C7D9" font-family="monospace" font-size="10">Figma to Code</text>
  <text x="385" y="355" fill="#34D399" font-family="monospace" font-size="11">Design-Token Sync</text>
  <text x="385" y="375" fill="#B8C7D9" font-family="monospace" font-size="10">CSS Vars &bull; Storybook Ready</text>
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
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Figma-to-Code Parity</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">+64%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">User Task Completion Rate</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">AAA</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">WCAG Accessibility Standards</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">0-Bloat</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Modular Design Tokens</span>
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
          <span>DESIGN ENGINEERING PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Design That Looks Premium and <span class="text-brand">Converts Without Friction</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Great UI/UX is not merely artistic expression; it is psychological clarity and usability engineering. When enterprise interfaces are cluttered, users get overwhelmed, support tickets spike, and sales funnels abandon.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, our design team unifies deep human factors research, atomic Figma design tokens, rapid click-through prototyping, and complete WCAG 2.2 AA accessibility so your product looks world-class and scales effortlessly.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Atomic Design System Architecture:</strong> 
              <span class="text-secondary">Tokenized typography, colors, and components in Figma with 1:1 CSS variable parity.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Usability Research &amp; Heatmap Auditing:</strong> 
              <span class="text-secondary">Identifying conversion leaks, navigation confusion, and cognitive overload.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Interactive High-Fidelity Prototyping:</strong> 
              <span class="text-secondary">Testing realistic user journeys with your stakeholders prior to writing a line of code.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Comprehensive Brand Identity Guidelines:</strong> 
              <span class="text-secondary">Vector logos, color palettes, micro-interactions, and visual tone documentation.</span>
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
            <span class="srv-hud-title">DESIGN TELEMETRY MATRIX</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              FIGMA TO CODE SYNCED
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Atomic tokens, accessibility metrics, and user journey task velocity tracked in real time.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.00</div>
                <div class="srv-hud-metric-label">Layout Shift (CLS)</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">99.4%</div>
                <div class="srv-hud-metric-label">Design Token Parity</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">8.6:1</div>
                <div class="srv-hud-metric-label">Max Contrast Ratio</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">3.2x</div>
                <div class="srv-hud-metric-label">Dev Handoff Speed</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Figma Tokens</span>
              <span class="srv-tool-badge">Storybook</span>
              <span class="srv-tool-badge">WCAG 2.2 AA</span>
              <span class="srv-tool-badge">Adobe CC</span>
              <span class="srv-tool-badge">CSS Variables</span>
              <span class="srv-tool-badge">Micro-Interactions</span>
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
<section class="srv-section" id="problems-we-solve">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>BUSINESS CHALLENGES WE ELIMINATE</span>
      </div>
      <h2 class="srv-section-title">
        Costly Bottlenecks Holding Back <span class="text-brand">Your Growth</span>
      </h2>
      <p class="srv-section-subtitle">
        Companies frequently struggle with fragmented execution, hidden technical debt, and misaligned metrics. We dismantle these systemic obstacles.
      </p>
    </div>

    <div class="srv-grid srv-grid-3">
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Cluttered Interfaces &amp; High Churn</h3>
        <p class="srv-problem-desc">Legacy user interfaces packed with confusing menus, inconsistent buttons, and fragmented workflows frustrate paying users.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">High product abandonment and a surge in expensive customer support tickets.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Frictionless information architecture overhaul, progressive disclosure, and streamlined user task flows.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Amateur Visual Brand Perception</h3>
        <p class="srv-problem-desc">Outdated logos, mismatched fonts, and inconsistent marketing assets erode corporate credibility when pitching enterprise deals.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Lost high-ticket enterprise contracts to competitors whose digital presence feels more established.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Full-spectrum corporate identity redesign: vector logo system, cohesive typography, and authoritative digital collateral.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Design-to-Code Disconnect &amp; Dev Friction</h3>
        <p class="srv-problem-desc">Designers handing off static images without specs, causing engineers to guess padding, responsive breakpoints, and interaction states.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Months of wasted sprint cycles debating UI revisions and fixing broken frontend layouts.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Structured Figma design systems with auto-layout, exact design tokens, exportable SVG assets, and CSS specs.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Broken Mobile &amp; Tablet Responsiveness</h3>
        <p class="srv-problem-desc">Designing solely for widescreen desktops results in illegible mobile text, clipped modal dialogs, and impossible-to-tap touch targets.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Over 60% of mobile visitors immediately bounce from your mobile site or portal.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Mobile-first responsive architecture designed with 48px minimum touch targets and adaptive touch layouts.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Accessibility Lawsuit &amp; Compliance Risks</h3>
        <p class="srv-problem-desc">Low contrast text, missing ARIA focus rings, and unreadable typography violate modern digital accessibility mandates.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Legal compliance vulnerability and alienating users with visual or motor impairments.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Guaranteed WCAG 2.2 AA compliance audits with accessible color contrast, keyboard navigation, and screen reader semantic structure.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Unvalidated Feature Creep</h3>
        <p class="srv-problem-desc">Building complex product features based on internal guesswork rather than validated customer testing and usability feedback.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Tens of thousands of dollars spent developing features that users ignore or reject.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Rapid interactive prototyping and structured user testing to validate concepts before writing production code.</p>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"/><path d="M12 2h3.5a3.5 3.5 0 1 1 0 7H12V2z"/><path d="M12 12.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 1 1-7 0z"/><path d="M5 19.5A3.5 3.5 0 0 1 8.5 16H12v3.5a3.5 3.5 0 1 1-7 0z"/><path d="M5 12.5A3.5 3.5 0 0 1 8.5 9H12v7H8.5A3.5 3.5 0 0 1 5 12.5z"/></svg></div>
        </div>
        <h3 class="srv-card-title">Enterprise UI/UX Design Systems</h3>
        <p class="srv-card-desc">Scalable design systems built in Figma with reusable components, responsive auto-layout, variable modes, and design token integration.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Atomic Component Libraries</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Light &amp; Dark Mode Token Sync</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Responsive Auto-Layout Frames</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Interactive Component Variants</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Accelerates frontend development cycles by up to 50% while guaranteeing pixel consistency.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Enterprise UI/UX Design Systems')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        </div>
        <h3 class="srv-card-title">Corporate Brand Identity &amp; Visual Language</h3>
        <p class="srv-card-desc">Distilling your company values into an unmistakable corporate identity: logo suites, iconography, typography, and brand guideline portals.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Primary &amp; Secondary Vector Logo Suites</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Color Science &amp; Palette Definition</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Custom Typography Pairing</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Comprehensive Brand Guidelines Manual</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Positions your enterprise as the dominant, trusted leader in your industry category.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Corporate Brand Identity & Visual Language')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">Web &amp; Mobile App Product Design</h3>
        <p class="srv-card-desc">End-to-end UX/UI architecture for SaaS platforms, client portals, mobile applications (iOS/Android), and complex dashboard interfaces.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>User Journey &amp; Flow Wireframing</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>High-Fidelity Screen Layouts</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Interactive Micro-Interactions</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Multi-Tenant Permission Hierarchy UI</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Transforms complicated enterprise workflows into enjoyable, frictionless user experiences.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Web & Mobile App Product Design')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        </div>
        <h3 class="srv-card-title">Conversion-Focused Landing Page UX</h3>
        <p class="srv-card-desc">High-impact landing pages structured with psychological visual hierarchy, strategic eye-flow, and distraction-free checkout paths.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>F-Pattern Visual Scanning Layouts</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Frictionless Multi-Step Lead Flows</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Social Proof &amp; Trust Badge Modules</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Core Web Vitals Visual Pre-Flight</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Maximizes paid media ROI by turning a higher percentage of visitors into pipeline.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Conversion-Focused Landing Page UX')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        </div>
        <h3 class="srv-card-title">WCAG 2.2 AA Accessibility Audits &amp; Remediation</h3>
        <p class="srv-card-desc">Rigorous accessibility testing ensuring color contrast ratios, focus states, and keyboard interactions meet international compliance.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated &amp; Manual Contrast Scoring</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Keyboard Navigation Flow Mapping</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Screen Reader Semantic Verification</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Accessible Form Error State Patterns</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Protects your brand from ADA compliance exposure while expanding your usable market.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('WCAG 2.2 AA Accessibility Audits & Remediation')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">Interactive Prototyping &amp; User Testing</h3>
        <p class="srv-card-desc">Full-featured clickable prototypes that simulate realistic data inputs, page transitions, and responsive behaviors for executive stakeholder signoff.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Click-Through Interactive Prototypes</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>User Testing Session Observation</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Task Completion Time Benchmarks</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Executive Decision Walkthrough Decks</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Validates key user journeys before development, eliminating costly architectural rework.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Interactive Prototyping & User Testing')) ?>" class="srv-link-action">
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
        <h3 class="srv-process-title">User Research &amp; Heuristic Audit</h3>
        <p class="srv-card-desc mb-3">We interview stakeholders, study user behavioral sessions, review competitor UX benchmarks, and identify conversion friction points.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>UX Heuristic Audit Report</li>
            <li>User Persona &amp; Journey Maps</li>
            <li>Competitor Visual Benchmark Matrix</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; WEEKS 2–3</div>
        <h3 class="srv-process-title">Information Architecture &amp; Wireframes</h3>
        <p class="srv-card-desc mb-3">We design low-fidelity structural wireframes and sitemaps to optimize navigation flow and cognitive hierarchy before visual styling.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Complete Structural Sitemaps</li>
            <li>Low-Fidelity Interactive Wireframes</li>
            <li>Core Flow Validation Walkthrough</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; WEEKS 3–4</div>
        <h3 class="srv-process-title">Design Token System &amp; Visual Exploration</h3>
        <p class="srv-card-desc mb-3">We establish typography, color systems, grid scales, and initial high-fidelity mood boards for executive feedback.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Figma Design Token Foundation</li>
            <li>3 Distinct Visual Mood Directions</li>
            <li>Iconography &amp; Color Hierarchy Specs</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; WEEKS 4–6</div>
        <h3 class="srv-process-title">High-Fidelity Component &amp; Screen Design</h3>
        <p class="srv-card-desc mb-3">We design every responsive view across desktop, tablet, and mobile, building out full atomic component libraries in Figma.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Complete High-Fidelity UI Screens</li>
            <li>Atomic Component Library with Variants</li>
            <li>Edge Case States (Errors, Loading, Empty)</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; WEEKS 6–7</div>
        <h3 class="srv-process-title">Clickable Prototyping &amp; Usability Testing</h3>
        <p class="srv-card-desc mb-3">We wire screens into interactive prototypes and run guided usability tasks to verify that flows are effortless and intuitive.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Interactive Figma Prototype</li>
            <li>Usability Session Findings Deck</li>
            <li>Refined Screen Micro-Interactions</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; WEEKS 7–8</div>
        <h3 class="srv-process-title">Developer Handoff &amp; Design Token Sync</h3>
        <p class="srv-card-desc mb-3">We export clean CSS variables, organize developer handoff documentation, and conduct paired walkthroughs with the engineering team.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Tokenized CSS/SCSS Export Files</li>
            <li>Figma Inspect Ready Specs</li>
            <li>Design QA Checklist for Frontend Devs</li>
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
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 5.5A3.5 3.5 0 0 1 8.5 2H12v7H8.5A3.5 3.5 0 0 1 5 5.5z"/><path d="M12 2h3.5a3.5 3.5 0 1 1 0 7H12V2z"/><path d="M12 12.5a3.5 3.5 0 1 1 7 0 3.5 3.5 0 1 1-7 0z"/><path d="M5 19.5A3.5 3.5 0 0 1 8.5 16H12v3.5a3.5 3.5 0 1 1-7 0z"/><path d="M5 12.5A3.5 3.5 0 0 1 8.5 9H12v7H8.5A3.5 3.5 0 0 1 5 12.5z"/></svg></div>
        <h3 class="srv-card-title">100% Figma Auto-Layout Parity</h3>
        <p class="srv-card-desc">Our design files are meticulously organized with responsive auto-layout, exact constraints, and atomic components that developers love.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Pixel-Perfect</span>
          <span class="text-muted text-sm ms-2">Developer-Ready Specs</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3 class="srv-card-title">WCAG 2.2 AA Compliance First</h3>
        <p class="srv-card-desc">Every single color combination, button state, and typographical choice is tested for contrast and readability from day one.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">AAA / AA</span>
          <span class="text-muted text-sm ms-2">Accessibility Standard</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        <h3 class="srv-card-title">Conversion-Driven Aesthetics</h3>
        <p class="srv-card-desc">We don’t design for design awards; we design for commercial revenue, user retention, and sub-second comprehension.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">+64%</span>
          <span class="text-muted text-sm ms-2">Average Flow Completion</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div>
        <h3 class="srv-card-title">Direct Frontend Developer Sync</h3>
        <p class="srv-card-desc">Our designers understand CSS flexbox, CSS grid, and browser rendering limits, preventing unrealistic design proposals that break in code.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">0 Rework</span>
          <span class="text-muted text-sm ms-2">Realistic Architecture</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        <h3 class="srv-card-title">Scalable Design Token Systems</h3>
        <p class="srv-card-desc">Global changes to your primary brand color, font, or corner radii cascade instantly across hundreds of screens in seconds.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Instant</span>
          <span class="text-muted text-sm ms-2">Global Brand Updates</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
        <h3 class="srv-card-title">Full IP &amp; Vector Asset Ownership</h3>
        <p class="srv-card-desc">You receive full ownership of all raw Figma files, vector SVGs, font licenses, and brand style guides with zero licensing restrictions.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">100%</span>
          <span class="text-muted text-sm ms-2">Client Owned IP</span>
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
        <h3 class="srv-tech-cat-title">Core Design &amp; Prototyping</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Figma</span>
            <span class="srv-tool-role">Auto-Layout &amp; Design Systems</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Figma Tokens</span>
            <span class="srv-tool-role">Design Token Management</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Adobe Illustrator</span>
            <span class="srv-tool-role">Vector Iconography &amp; Logo Specs</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Principle / ProtoPie</span>
            <span class="srv-tool-role">Advanced Micro-Interactions</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Developer Handoff &amp; Token Sync</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Storybook</span>
            <span class="srv-tool-role">Isolated Component Explorer</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Zeroheight</span>
            <span class="srv-tool-role">Living Style Guide Documentation</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">CSS Custom Props</span>
            <span class="srv-tool-role">1:1 Variable Code Sync</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Git Repository Sync</span>
            <span class="srv-tool-role">Versioned Design Assets</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Usability &amp; Analytics Audits</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Hotjar</span>
            <span class="srv-tool-role">Heatmaps &amp; Friction Analysis</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Maze</span>
            <span class="srv-tool-role">Unmoderated Usability Testing</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Contrast Analyser</span>
            <span class="srv-tool-role">WCAG 2.2 Color Verification</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Lighthouse</span>
            <span class="srv-tool-role">CLS &amp; Visual Stability Score</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Creative Assets &amp; 3D Visuals</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Adobe Photoshop</span>
            <span class="srv-tool-role">Asset Retouching &amp; Textures</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Blender</span>
            <span class="srv-tool-role">Isometric 3D Illustrations</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">LottieFiles</span>
            <span class="srv-tool-role">Lightweight JSON Animations</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">FontFont / Monotype</span>
            <span class="srv-tool-role">Enterprise Web Typography</span>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
          <span class="srv-industry-tag">FINTECH &amp; BANKING</span>
        </div>
        <h3 class="srv-card-title">Trust-First Financial Dashboards</h3>
        <p class="srv-card-desc">High-density transactional tables, biometric login flows, and clear data visualization engineered for wealth managers and retail investors.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">82% Reduction in User Transfer Errors</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <span class="srv-industry-tag">HEALTHCARE &amp; CLINICAL</span>
        </div>
        <h3 class="srv-card-title">Patient &amp;amp; Clinical Provider Portals</h3>
        <p class="srv-card-desc">Accessible, distraction-free interfaces for telehealth appointments, medical records, and prescription renewals.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">99.8% Usability Score for Senior Demographics</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
          <span class="srv-industry-tag">LUXURY &amp; D2C E-COMMERCE</span>
        </div>
        <h3 class="srv-card-title">Editorial Brand Storefronts &amp;amp; Fast Checkout</h3>
        <p class="srv-card-desc">Immersive visual storytelling, dynamic size pickers, and single-tap mobile checkout designed to maximize average order value.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">+28% Increase in Mobile Conversion Rate</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
          <span class="srv-industry-tag">B2B SAAS &amp; ENTERPRISE</span>
        </div>
        <h3 class="srv-card-title">Complex Workflow Simplification</h3>
        <p class="srv-card-desc">Transforming cluttered multi-tier permission consoles and analytics tools into clean, intuitive workspaces.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">45% Drop in Customer Onboarding Time</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg></div>
          <span class="srv-industry-tag">REAL ESTATE &amp; ARCHITECTURE</span>
        </div>
        <h3 class="srv-card-title">Interactive Property Portals &amp;amp; VR Tours</h3>
        <p class="srv-card-desc">High-resolution architectural showcases, interactive floor plan navigators, and direct private tour booking flows.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">3.4x Increase in Qualified Private Viewings</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
          <span class="srv-industry-tag">PROFESSIONAL CONSULTING</span>
        </div>
        <h3 class="srv-card-title">Authoritative Brand Identity &amp;amp; Portal</h3>
        <p class="srv-card-desc">Editorial typography, bespoke whitepaper layouts, and partner profiles that communicate undeniable executive stature.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">100% Brand Consistency Across 8 Global Offices</strong>
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
        Common Questions About <span class="text-brand">UI/UX Design &amp; Brand Identity</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">What deliverables do we receive at the end of a UI/UX project?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>You receive a complete, production-ready Figma workspace containing the atomic design system (color tokens, typography, component library with interactive variants), all responsive screen layouts (desktop, tablet, mobile), an interactive click-through prototype, exportable SVGs, and developer documentation with CSS variable specifications.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Do you also code the frontend or only provide designs in Figma?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We offer both. Because BusinessDoctor is a full-stack digital engineering firm, we can take the Figma files directly into production code (HTML5, modern CSS/SCSS, React, Vue, or PHP), guaranteeing 100% pixel-perfect implementation without handoff friction.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">How many design revisions are included during the project?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Our iterative sprint process includes structured review milestones at every stage (wireframes, visual mood directions, component library, and final screen flows). Rather than limiting you to arbitrary revision counts, we collaborate until the design meets your exact business objectives and executive standards.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Can you redesign our product without breaking our existing backend?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We frequently conduct UI modernization projects where the underlying database, APIs, and business logic remain intact while we deliver a completely modernized, high-performance frontend interface.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">How do you ensure the designs are accessible (WCAG compliant)?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We test every color combination against automated contrast checkers to ensure WCAG 2.2 AA (and AAA where applicable) compliance. We also design dedicated focus states, ensure semantic typographic hierarchy, and verify minimum 48x48px touch targets for mobile usability.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How long does a typical UI/UX or brand redesign project take?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>A focused landing page or corporate brand identity typically takes 3 to 4 weeks. A comprehensive web application or complex SaaS redesign typically spans 6 to 10 weeks depending on the number of unique user flows and components.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Who owns the intellectual property and copyright of the designs?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You own 100% of all intellectual property, design files, custom illustrations, and brand assets upon project completion. We do not charge licensing fees or retain ownership.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">Can you work with our internal development team during handoff?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Absolutely. We conduct live walkthrough sessions with your engineering leads, provide interactive Figma inspect links, export design token JSON/CSS files, and remain available for design QA during their sprint build.</p>
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
          Ready to Transform Your Product into a <span class="text-brand">World-Class Experience?</span>
        </h2>
            <p class="srv-cta-lead">
          Schedule a design diagnostic session. Our senior product designers will review your current interface, identify conversion friction points, and map an executive design roadmap.
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
                  <label class="srv-form-label" for="quick_name_ui-ux-branding.php">Your Full Name</label>
                  <input type="text" id="quick_name_ui-ux-branding.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_ui-ux-branding.php">Work Email</label>
                  <input type="email" id="quick_email_ui-ux-branding.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_ui-ux-branding.php">Company / Domain</label>
                  <input type="text" id="quick_company_ui-ux-branding.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_ui-ux-branding.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_ui-ux-branding.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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
