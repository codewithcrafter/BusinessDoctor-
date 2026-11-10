<?php
/**
 * BusinessDoctor About Page
 * Enterprise IT Solutions & Digital Services Practice
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'About Us — BusinessDoctor Enterprise IT & Digital Services';
$pageDescription = 'Learn how BusinessDoctor combines custom software engineering, high-ROI performance marketing, UI/UX design, and marketplace scaling to help enterprises dominate their markets.';

require_once __DIR__ . '/includes/header.php';
?>

<div class="about-page">

<!-- Page Header Hero -->
<section class="section hero-enterprise about-hero" id="aboutHero">
  <div class="container text-center about-hero-container">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>ABOUT OUR COMPANY</span>
    </div>
    <h1 class="hero-headline-oversized about-hero-headline">
      Engineering Technology. <br><span class="text-gradient-pine">Accelerating Scalable Growth.</span>
    </h1>
    <p class="hero-lead-text about-hero-lead">
      We founded BusinessDoctor to provide modern businesses with a reliable, all-in-one IT and digital growth partner. We eliminate the friction of managing disconnected developers, ad agencies, and designers by bringing them together under one disciplined engineering practice.
    </p>
  </div>
</section>

<!-- ============================================================
     THE BUSINESSDOCTOR PHILOSOPHY: EDITORIAL PRESENTATION
     ============================================================ -->
<section class="section about-philosophy-section" id="philosophySection">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>THE BUSINESSDOCTOR PHILOSOPHY</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Why We Call Ourselves BusinessDoctor
      </h2>
      <p class="lead">
        A clinical engineering approach to diagnosing digital friction, eliminating architecture bottlenecks, and prescribing sustainable enterprise growth.
      </p>
    </div>

    <div class="philosophy-editorial-grid">
      <!-- Block 1: Digital Friction & Symptoms -->
      <article class="philosophy-editorial-block">
        <div class="philosophy-block-header">
          <span class="philosophy-step-tag">01 // DIAGNOSTIC IDENTIFICATION</span>
          <div class="philosophy-block-icon" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
            </svg>
          </div>
        </div>
        <h3 class="philosophy-block-title">The Symptoms of Digital Friction</h3>
        <p class="philosophy-block-text">
          Every growing enterprise encounters digital friction: an <span class="highlight-teal">outdated website that repels prospective clients</span>, <span class="highlight-teal">slow server response times</span> that kill search engine rankings, <span class="highlight-teal">paid advertising campaigns that fail to convert</span>, or <span class="highlight-teal">marketplace listings that lose sales</span> to competitors.
        </p>
        <div class="philosophy-tags-strip">
          <span class="philosophy-pill">Conversion Drop-off</span>
          <span class="philosophy-pill">Latency Bottlenecks</span>
          <span class="philosophy-pill">Ad Spend Waste</span>
        </div>
      </article>

      <!-- Block 2: Architectural Diagnosis & Care (Focal Block) -->
      <article class="philosophy-editorial-block featured">
        <div class="philosophy-block-header">
          <span class="philosophy-step-tag" style="color: #06B5F9;">02 // THE CLINICAL DIAGNOSIS</span>
          <div class="philosophy-block-icon" style="background: rgba(6, 181, 249, 0.15); border-color: #06B5F9;" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
          </div>
        </div>
        <h3 class="philosophy-block-title">End-to-End Technical Care</h3>
        <p class="philosophy-block-text">
          Just as any complex system needs expert trouble-shooters to <span class="highlight-teal">diagnose root technical failures</span> and <span class="highlight-teal">prescribe robust engineering solutions</span>, <strong class="highlight-aqua">BusinessDoctor provides end-to-end technical care for your digital presence</strong>.
        </p>
        <div class="philosophy-tags-strip">
          <span class="philosophy-pill" style="border-color: rgba(6, 181, 249, 0.4); color: #0099DB;">Root-Cause Diagnosis</span>
          <span class="philosophy-pill" style="border-color: rgba(6, 181, 249, 0.4); color: #0099DB;">Systemic Prescription</span>
        </div>
      </article>

      <!-- Block 3: Disciplined Execution -->
      <article class="philosophy-editorial-block">
        <div class="philosophy-block-header">
          <span class="philosophy-step-tag">03 // MEASURABLE EXECUTION</span>
          <div class="philosophy-block-icon" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
          </div>
        </div>
        <h3 class="philosophy-block-title">Precision Engineering &amp; Scale</h3>
        <p class="philosophy-block-text">
          We don't sell superficial fixes or bloated templates. Our <span class="highlight-teal">software engineers</span>, <span class="highlight-teal">performance marketers</span>, and <span class="highlight-teal">UI/UX designers</span> analyze your technical infrastructure, rebuild broken user journeys, build <span class="highlight-teal">lightning-fast web applications</span>, and scale customer acquisition with <span class="highlight-aqua">data-backed precision</span>.
        </p>
        <div class="philosophy-tags-strip">
          <span class="philosophy-pill">Custom PHP 8+</span>
          <span class="philosophy-pill">Sub-Second Load</span>
          <span class="philosophy-pill">Data-Led Acquisition</span>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     FOUR COMMITMENTS WE STAND BY (PREMIUM 4-CARD GRID)
     ============================================================ -->
<section class="section commitments-section" id="commitmentsSection">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR OPERATING STANDARDS</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Four Commitments We Stand By
      </h2>
      <p class="lead">
        Non-negotiable architectural benchmarks and accountability standards engineered into every client partnership.
      </p>
    </div>

    <div class="commitments-grid">
      <!-- Commitment 01 -->
      <article class="commitment-card">
        <div class="commitment-card-top">
          <div class="commitment-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="16 18 22 12 16 6"/>
              <polyline points="8 6 2 12 8 18"/>
            </svg>
          </div>
          <span class="commitment-num">01</span>
        </div>
        <h3 class="commitment-title">Clean, Framework-Free Code</h3>
        <p class="commitment-desc">
          We build custom, lightweight web applications that load in under 1 second with 100% Core Web Vitals compliance.
        </p>
        <div class="commitment-card-accent"></div>
      </article>

      <!-- Commitment 02 -->
      <article class="commitment-card">
        <div class="commitment-card-top">
          <div class="commitment-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="18" y1="20" x2="18" y2="10"/>
              <line x1="12" y1="20" x2="12" y2="4"/>
              <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
          </div>
          <span class="commitment-num">02</span>
        </div>
        <h3 class="commitment-title">Measurable Commercial ROI</h3>
        <p class="commitment-desc">
          Every digital marketing campaign, SEO sprint, and design update is measured by real business KPIs: qualified leads and revenue.
        </p>
        <div class="commitment-card-accent"></div>
      </article>

      <!-- Commitment 03 -->
      <article class="commitment-card">
        <div class="commitment-card-top">
          <div class="commitment-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="2" width="20" height="8" rx="2" ry="2"/>
              <rect x="2" y="14" width="20" height="8" rx="2" ry="2"/>
              <line x1="6" y1="6" x2="6.01" y2="6"/>
              <line x1="6" y1="18" x2="6.01" y2="18"/>
            </svg>
          </div>
          <span class="commitment-num">03</span>
        </div>
        <h3 class="commitment-title">Integrated End-to-End Delivery</h3>
        <p class="commitment-desc">
          Developers, UI/UX designers, copywriters, and media buyers collaborate under one unified project management team.
        </p>
        <div class="commitment-card-accent"></div>
      </article>

      <!-- Commitment 04 -->
      <article class="commitment-card">
        <div class="commitment-card-top">
          <div class="commitment-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <span class="commitment-num">04</span>
        </div>
        <h3 class="commitment-title">Long-Term Partnership &amp; Support</h3>
        <p class="commitment-desc">
          We provide 24/7 uptime monitoring, security patching, and ongoing growth optimization post-launch.
        </p>
        <div class="commitment-card-accent"></div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     OUR PURPOSE & DIRECTION: MISSION & VISION
     Integrated with Horizontal Business Statistics Strip
     ============================================================ -->
<section class="section mission-vision-section" id="missionVision" aria-label="Mission and Vision">
  <div class="container">
    <!-- Section Header -->
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR PURPOSE &amp; DIRECTION</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Driven by Purpose. <span class="text-gradient-pine">Defined by Results.</span>
      </h2>
      <p class="lead">
        We partner with forward-thinking enterprises to architect reliable digital infrastructure and high-velocity growth systems grounded in technical rigor and measurable commercial impact.
      </p>
    </div>

    <!-- Mission & Vision 2-Column Grid -->
    <div class="mission-vision-grid">
      <!-- Panel 1: OUR MISSION (Deep Emerald Background) -->
      <div class="mv-panel mv-panel-mission">
        <!-- Abstract Engineering Background SVG Pattern -->
        <div class="mv-pattern-bg" aria-hidden="true">
          <svg width="340" height="340" viewBox="0 0 340 340" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="170" cy="170" r="130" stroke="rgba(161, 126, 145, 0.14)" stroke-width="1.2" stroke-dasharray="4 4"/>
            <circle cx="170" cy="170" r="85" stroke="rgba(255, 255, 255, 0.08)" stroke-width="1"/>
            <circle cx="170" cy="170" r="40" stroke="rgba(161, 126, 145, 0.2)" stroke-width="1.5"/>
            <line x1="40" y1="170" x2="300" y2="170" stroke="rgba(161, 126, 145, 0.12)" stroke-width="1"/>
            <line x1="170" y1="40" x2="170" y2="300" stroke="rgba(161, 126, 145, 0.12)" stroke-width="1"/>
            <path d="M120 120 L220 220 M220 120 L120 220" stroke="rgba(255, 255, 255, 0.06)" stroke-width="1"/>
          </svg>
        </div>

        <div class="mv-panel-header">
          <div class="mv-icon-badge mv-icon-emerald">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
          </div>
          <span class="mv-eyebrow">OUR MISSION</span>
        </div>

        <h3 class="mv-heading mv-heading-light">
          Engineering Reliable Digital Solutions Built for Enduring Enterprise Scale
        </h3>

        <p class="mv-statement mv-statement-light">
          "To engineer reliable digital solutions that simplify business operations, strengthen performance, and accelerate sustainable growth."
        </p>

        <div class="mv-pillars">
          <span class="mv-pillar-tag">Operational Simplicity</span>
          <span class="mv-pillar-tag">Performance SLAs</span>
          <span class="mv-pillar-tag">Sustainable Scale</span>
        </div>
      </div>

      <!-- Panel 2: OUR VISION (Deep Teal Background) -->
      <div class="mv-panel mv-panel-vision">
        <!-- Future-Focused Geometric Background Pattern -->
        <div class="mv-pattern-bg" aria-hidden="true">
          <svg width="340" height="340" viewBox="0 0 340 340" fill="none" xmlns="http://www.w3.org/2000/svg">
            <polygon points="170,30 290,100 290,240 170,310 50,240 50,100" stroke="rgba(6, 181, 249, 0.35)" stroke-width="1.2" stroke-dasharray="6 4"/>
            <polygon points="170,75 250,125 250,215 170,265 90,215 90,125" stroke="rgba(6, 181, 249, 0.15)" stroke-width="1"/>
            <line x1="170" y1="30" x2="170" y2="310" stroke="rgba(6, 181, 249, 0.10)" stroke-width="1"/>
            <line x1="50" y1="170" x2="290" y2="170" stroke="rgba(0, 153, 219, 0.25)" stroke-width="1"/>
            <circle cx="170" cy="170" r="14" fill="rgba(6, 181, 249, 0.10)" stroke="#0099DB" stroke-width="1.5"/>
          </svg>
        </div>

        <div class="mv-panel-header">
          <div class="mv-icon-badge mv-icon-ivory">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
              <path d="M2 12h20"/>
            </svg>
          </div>
          <span class="mv-eyebrow mv-eyebrow-dark">OUR VISION</span>
        </div>

        <h3 class="mv-heading mv-heading-dark">
          The Trusted Digital Partner Combining Technical Precision with Real Commercial Impact
        </h3>

        <p class="mv-statement mv-statement-dark">
          "To become a trusted technology and digital growth partner for businesses by combining engineering excellence, innovation, and measurable outcomes."
        </p>

        <div class="mv-pillars">
          <span class="mv-pillar-tag mv-pillar-dark">Engineering Excellence</span>
          <span class="mv-pillar-tag mv-pillar-dark">Applied Innovation</span>
          <span class="mv-pillar-tag mv-pillar-dark">Audited ROI</span>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Leadership Team -->
<section class="section" style="background-color: var(--color-bg);">
  <div class="container">
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>EXPERIENCED LEADERSHIP</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2rem, 3.5vw, 3rem);">Leadership &amp; Technology Directors</h2>
      <p class="lead">Experienced software architects, digital marketing directors, and creative strategists leading your enterprise projects.</p>
    </div>

    <div class="cases-editorial-grid">
      <div class="case-editorial-card" style="padding: 2.75rem 2.25rem;">
        <div style="width: 60px; height: 60px; border-radius: var(--radius-md); background: var(--color-primary); color: var(--color-accent); font-family: var(--font-display); font-size: 1.35rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; border: 1px solid rgba(161, 126, 145, 0.3);">
          HC
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.25rem; color: var(--color-text);">Dr. Harrison Croft</h3>
        <div style="font-family: var(--font-mono); font-size: 0.76rem; color: #06B5F9; font-weight: 700; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 0.08em;">
          MANAGING PARTNER &amp; CHIEF SOLUTIONS OFFICER
        </div>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.65;">
          18+ years leading enterprise digital transformation, software delivery, and performance marketing portfolios for global corporations and high-growth ventures.
        </p>
      </div>

      <div class="case-editorial-card" style="padding: 2.75rem 2.25rem;">
        <div style="width: 60px; height: 60px; border-radius: var(--radius-md); background: var(--color-primary); color: var(--color-accent); font-family: var(--font-display); font-size: 1.35rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; border: 1px solid rgba(161, 126, 145, 0.3);">
          KC
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.25rem; color: var(--color-text);">Kirsten Chen</h3>
        <div style="font-family: var(--font-mono); font-size: 0.76rem; color: #06B5F9; font-weight: 700; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 0.08em;">
          VP OF ENGINEERING &amp; CLOUD ARCHITECTURE
        </div>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.65;">
          Senior full-stack systems engineer specializing in high-performance web architecture, custom database management, cloud hosting, and API integrations.
        </p>
      </div>

      <div class="case-editorial-card" style="padding: 2.75rem 2.25rem;">
        <div style="width: 60px; height: 60px; border-radius: var(--radius-md); background: var(--color-primary); color: var(--color-accent); font-family: var(--font-display); font-size: 1.35rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; border: 1px solid rgba(161, 126, 145, 0.3);">
          JM
        </div>
        <h3 style="font-size: 1.3rem; margin-bottom: 0.25rem; color: var(--color-text);">Julian Montgomery</h3>
        <div style="font-family: var(--font-mono); font-size: 0.76rem; color: #06B5F9; font-weight: 700; margin-bottom: 1.25rem; text-transform: uppercase; letter-spacing: 0.08em;">
          HEAD OF UI/UX DESIGN &amp; BRAND ARCHITECTURE
        </div>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.65;">
          Creative director leading user experience architecture, design systems, modern vector branding, and conversion-focused digital interfaces.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="section" style="background: var(--color-surface); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Ready to Elevate Your Digital Capabilities?</h2>
        <p class="closing-cta-lead">
          Schedule an introductory discovery call with our tech leads to discuss your web development, digital marketing, or branding requirements.
        </p>
        <div class="closing-cta-buttons">
          <a href="contact.php" class="btn btn-accent btn-lg">
            <span>Schedule a Project Consultation</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="audit.php" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

</div><!-- /.about-page -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
