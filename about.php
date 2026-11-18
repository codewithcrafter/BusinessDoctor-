<?php
/**
 * BusinessDoctor About Page
 * Enterprise IT Solutions & Digital Services Practice
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'About our company / Business Doctor - Digital Marketing company in Delhi';
$pageDescription = 'Business Doctor is a digital marketing company in Delhi that provides seo services in delhi , ppc services, social media marketing in Delhi, website development services and graphic design services in Delhi, which helps your business to grow and reach its full potential.';
$canonicalUrl = appUrl('about');
$schemaPageKey = 'about';

require_once __DIR__ . '/includes/header.php';
?>

<div class="about-page">

<!-- ============================================================
     PAGE HEADER HERO
     ============================================================ -->
<section class="section hero-enterprise about-hero" id="aboutHero">
  <div class="container text-center about-hero-container">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>ABOUT OUR COMPANY</span>
    </div>
    <h1 class="hero-headline-oversized about-hero-headline">
      Business Doctor - <br><span class="text-gradient-pine">Digital Marketing company in Delhi</span>
    </h1>

    <div class="about-hero-lead-box">
      <p class="hero-lead-text about-hero-lead">
        Business Doctor is a digital marketing company in Delhi that provides seo services in delhi , ppc services, social media marketing in Delhi, website development services and graphic design services in Delhi, which helps your business to grow and reach its full potential. We personalize every strategy according to your business needs. We aim to increase your brand visibility and get you quality leads.
      </p>
    </div>

    <div class="about-hero-actions">
      <a href="/contact" class="btn btn-accent btn-lg">
        <span>Schedule a Project Consultation</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
      <a href="/services" class="btn btn-outline-gold btn-lg">
        <span>Explore Our Services</span>
      </a>
    </div>

    <!-- Hero Trust / Highlights Strip -->
    <div class="about-hero-trust" aria-label="Key highlights">
      <div class="about-trust-item">
        <span class="about-trust-dot"></span>
        <span>Transparent Weekly Reporting</span>
      </div>
      <div class="about-trust-item">
        <span class="about-trust-dot"></span>
        <span>Tailored Business Strategy</span>
      </div>
      <div class="about-trust-item">
        <span class="about-trust-dot"></span>
        <span>Full-Service Digital Delivery</span>
      </div>
      <div class="about-trust-item">
        <span class="about-trust-dot"></span>
        <span>Measurable Growth &amp; Leads</span>
      </div>
    </div>
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
      <h2 class="section-title">
        Why Businesses Call BusinessDoctor the Best Digital Marketing Company in Delhi
      </h2>
      <p class="lead">
        We believe that every business has the potential to grow and we provide a full-service digital marketing company that helps your business grow.Our professional team helps you at every step from web development to lead generation. We don't make big promises and leave you in the middle, we provide you with weekly reports and updates on your business so that you can track your growth as well.
      </p>
    </div>

    <div class="philosophy-editorial-grid">
      <!-- Block 1: Diagnostic Identification -->
      <article class="philosophy-editorial-block">
        <div class="philosophy-block-header">
          <span class="philosophy-step-tag">
            <span class="philosophy-step-dot"></span>
            01 // DIAGNOSTIC IDENTIFICATION
          </span>
          <div class="philosophy-block-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
            </svg>
          </div>
        </div>
        <h3 class="philosophy-block-title">Challenges a Digital Marketing Company in Delhi Can Help Solve</h3>
        <p class="philosophy-block-text">
          Does your business have low lead generation, poor website performance, poor user experience and a low conversion rate? If these challenges are limiting your growth, you need the right strategy to grow your business from Business Doctor- a trusted digital marketing company in Delhi that helps your brand to get quality customers.
        </p>
      </article>

      <!-- Block 2: The Clinical Diagnosis -->
      <article class="philosophy-editorial-block featured">
        <div class="philosophy-block-header">
          <span class="philosophy-step-tag">
            <span class="philosophy-step-dot"></span>
            02 // THE CLINICAL DIAGNOSIS
          </span>
          <div class="philosophy-block-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="8" x2="12" y2="12"/>
              <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
          </div>
        </div>
        <h3 class="philosophy-block-title">End-to-End Digital Marketing Services in Delhi</h3>
        <p class="philosophy-block-text">
          Business Doctor's experienced digital marketing team identifies the root cause of your low performance and makes a personalized solution plan that suits your business problem. We believe that every business needs a different approach to grow. Our professional team manages everything on-page, off-page, Website development and more.
        </p>
      </article>

      <!-- Block 3: Measurable Execution -->
      <article class="philosophy-editorial-block">
        <div class="philosophy-block-header">
          <span class="philosophy-step-tag">
            <span class="philosophy-step-dot"></span>
            03 // MEASURABLE EXECUTION
          </span>
          <div class="philosophy-block-icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
          </div>
        </div>
        <h3 class="philosophy-block-title">Growth-Focused Digital Marketing Solutions in Delhi</h3>
        <p class="philosophy-block-text">
          Once we identify the problem and create the plan, we implement it and follow up till we reach the desired result. As a full-service digital marketing company, we provide everything from developing user friendly websites to improving marketing campaigns, our aim is to deliver measurable results.
        </p>
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
        <span>OUR COMMITMENTS</span>
      </div>
      <h2 class="section-title">
        Four Commitments We Stand By as a Digital Marketing Company
      </h2>
      <p class="lead">
        As a Digital Marketing company in Delhi, we believe that successful partnership is built on trust, accountability, engineering excellence and transparency. We follow our four non-negotiable commitments to make sure that every business achieves its full potential.
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
          Business Doctor, a trusted digital marketing company in Delhi focuses on clean coding, which avoids unnecessary heavy frameworks and makes websites fast, effective and user-friendly providing users with a smooth and seamless experience and helping to make your business recognisable.
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
          Business Doctor is a professional digital marketing company. Our team doesn't just focus on improving website marketing,we identify the gaps of your business that are holding it back and work on them so that you get quality leads. We also track how many leads, sales, and conversions you are getting.
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
          BusinessDoctor, a digital marketing company in Delhi provides full services in digital marketing from website development to digital marketing so that you get all services on one platform.
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
          We don't just believe in making a website we believe in building long term business relationships. We monitor your business’s regular performance, improve the strategy according to needs and support you at every step so that your business can grow continuously.
        </p>
        <div class="commitment-card-accent"></div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     OUR PURPOSE & DIRECTION: MISSION & VISION
     ============================================================ -->
<section class="section mission-vision-section" id="missionVision" aria-label="Mission and Vision">
  <div class="container">
    <!-- Section Header -->
    <div class="section-header text-center">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR PURPOSE &amp; DIRECTION</span>
      </div>
      <h2 class="section-title">
        Business Growth Through <span class="text-gradient-pine">Digital Marketing Solutions</span>
      </h2>
      <p class="lead">
        At BusinessDoctor, we help businesses grow through a strategic digital marketing plan and innovative technology. As a digital marketing expert in Delhi, we focus on improving online visibility, generating quality leads, improving user experiences and increasing conversions.
      </p>
    </div>

    <!-- Mission & Vision 2-Column Grid -->
    <div class="mission-vision-grid">
      <!-- Panel 1: OUR MISSION -->
      <div class="mv-panel mv-panel-mission">
        <div class="mv-panel-header">
          <div class="mv-icon-badge mv-icon-emerald">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
          </div>
          <span class="mv-eyebrow">OUR MISSION</span>
        </div>

        <h3 class="mv-heading mv-heading-light">
          Digital Marketing Solutions for Business Growth
        </h3>

        <p class="mv-statement mv-statement-light">
          Business Doctor's mission is to overcome the challenges that your business is facing by providing the right strategy so that you get potential customers. Through transparency and technical excellence, we want to create impact and make your brand unforgettable.
        </p>
      </div>

      <!-- Panel 2: OUR VISION -->
      <div class="mv-panel mv-panel-vision">
        <div class="mv-panel-header">
          <div class="mv-icon-badge mv-icon-emerald">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
              <path d="M2 12h20"/>
            </svg>
          </div>
          <span class="mv-eyebrow">OUR VISION</span>
        </div>

        <h3 class="mv-heading mv-heading-light">
          Trusted Digital Marketing company for Business Growth
        </h3>

        <p class="mv-statement mv-statement-light">
          Business Doctors is a trusted digital marketing company in Delhi. Our vision is to be a digital marketing partner for businesses to empower businesses with innovative digital strategies, advanced technologies, lead generation and sustainable growth. We want to provide solutions for your digital challenges, so that you can build a strong online presence.
        </p>
      </div>
    </div>

  </div>
</section>

<!-- ============================================================
     CALL TO ACTION (CLOSING SECTION)
     ============================================================ -->
<section class="section about-closing-section">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Ready to Elevate Your Digital Capabilities?</h2>
        <p class="closing-cta-lead">
          Schedule an introductory discovery call with our tech leads to discuss your web development, digital marketing, or branding requirements.
        </p>
        <div class="closing-cta-buttons">
          <a href="/contact" class="btn btn-accent btn-lg">
            <span>Schedule a Project Consultation</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="/audit" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
        <div class="about-closing-meta">
          <span>Direct Advisory: <?= defined('APP_PHONE') ? e(APP_PHONE) : '+91 99994 48988' ?></span>
          <span class="meta-separator">•</span>
          <span>Official Email: <?= defined('APP_EMAIL') ? e(APP_EMAIL) : 'contact@businessdoctor.com' ?></span>
          <span class="meta-separator">•</span>
          <span>Response SLA: Within 2 Business Hours</span>
        </div>
      </div>
    </div>
  </div>
</section>

</div><!-- /.about-page -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
