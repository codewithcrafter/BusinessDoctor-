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
$canonicalUrl = 'https://businessdoctor.com/about.php';
$schemaPageKey = 'about';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Page Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>ABOUT OUR COMPANY</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.5rem;">
      Engineering Technology. <br><span class="text-gradient-pine">Accelerating Scalable Growth.</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      We founded BusinessDoctor to provide modern businesses with a reliable, all-in-one IT and digital growth partner. We eliminate the friction of managing disconnected developers, ad agencies, and designers by bringing them together under one disciplined engineering practice.
    </p>
  </div>
</section>

<!-- ============================================================
     SECTION A — OUR STORY: INTEGRATED ENTERPRISE IT & GROWTH
     ============================================================ -->
<section class="section about-story-section" id="our-story">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR FOUNDING STORY &amp; PURPOSE</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Bridging the Gap Between Technology and Digital Growth
      </h2>
      <p class="lead">
        Most companies struggle not from a shortage of talent, but from vendor fragmentation. We built BusinessDoctor to provide a single, accountable engineering practice where software, marketing, design, and marketplaces converge.
      </p>
    </div>

    <div class="about-story-grid">
      <!-- Card 1: The Disconnected Reality -->
      <article class="about-story-card">
        <div class="about-card-badge">
          <span>THE CHALLENGE // VENDOR FRAGMENTATION</span>
        </div>
        <h3 class="about-card-title">The Friction of Disconnected Digital Vendors</h3>
        <p class="about-card-desc">
          When enterprises seek to scale their digital presence, they typically engage multiple specialized vendors: web developers building features in isolation, marketing agencies running ad campaigns without technical insight, designers creating interfaces detached from conversion mechanics, and marketplace consultants operating in silos.
        </p>
        <p class="about-card-desc">
          The result is chronic architectural friction: slow page loads that undermine ad spend, ad funnels directing traffic to high-friction checkout pages, and disjointed brand messaging that confuses prospective customers. Leaders end up spending valuable operational bandwidth arbitrating between conflicting agencies.
        </p>
        <div class="about-tags-row">
          <span class="about-tag">Siloed Workflows</span>
          <span class="about-tag">Misaligned Incentives</span>
          <span class="about-tag">Wasted Ad Capital</span>
          <span class="about-tag">Technical Debt</span>
        </div>
      </article>

      <!-- Card 2: The Integrated Solution -->
      <article class="about-story-card featured">
        <div class="about-card-badge featured">
          <span>THE SOLUTION // INTEGRATED PRACTICE</span>
        </div>
        <h3 class="about-card-title">One Unified Engineering &amp; Growth Partner</h3>
        <p class="about-card-desc">
          BusinessDoctor was architected to eliminate this division. We operate as an integrated technical and commercial partner, ensuring that your software infrastructure, marketing engine, brand touchpoints, and marketplace channels work synchronously toward measurable commercial outcomes.
        </p>
        <p class="about-card-desc">
          Our software engineers write lightweight, framework-free code that loads instantly; our digital strategists build high-intent acquisition campaigns; our designers craft intuitive user experiences; and our marketplace specialists defend Buy Box margins. Every discipline collaborates under a unified standard of accountability.
        </p>
        <div class="about-tags-row">
          <span class="about-tag featured">Unified Architecture</span>
          <span class="about-tag featured">Synchronized Workflows</span>
          <span class="about-tag featured">Sub-Second Load Times</span>
          <span class="about-tag featured">Single Accountability</span>
        </div>
      </article>
    </div>

    <!-- Integrated Thesis Quote Strip -->
    <div class="about-thesis-strip">
      <div class="about-thesis-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
      </div>
      <p class="about-thesis-quote">
        "By aligning software engineering, performance marketing, brand identity, and marketplace management under one disciplined standard, BusinessDoctor transforms fragmented digital efforts into resilient, compounding enterprise growth."
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION B — MISSION & VISION: PURPOSE & DIRECTION
     ============================================================ -->
<section class="section mission-vision-section" id="mission-vision" aria-label="Mission and Vision">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR PURPOSE &amp; DIRECTION</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Driven by Purpose. <span class="text-gradient-pine">Defined by Results.</span>
      </h2>
      <p class="lead" style="max-width: 780px; margin: 0 auto;">
        Our operational direction is anchored in engineering clarity, technical integrity, and enduring commercial value for the organizations we serve.
      </p>
    </div>

    <div class="mission-vision-grid">
      <!-- Mission Panel -->
      <div class="mv-panel mv-panel-mission is-revealed">
        <div class="mv-pattern-bg" aria-hidden="true">
          <svg width="340" height="340" viewBox="0 0 340 340" fill="none">
            <circle cx="170" cy="170" r="130" stroke="rgba(0, 201, 193, 0.18)" stroke-width="1.2" stroke-dasharray="4 4"/>
            <circle cx="170" cy="170" r="85" stroke="rgba(255, 255, 255, 0.08)" stroke-width="1"/>
            <line x1="40" y1="170" x2="300" y2="170" stroke="rgba(0, 201, 193, 0.15)" stroke-width="1"/>
            <line x1="170" y1="40" x2="170" y2="300" stroke="rgba(0, 201, 193, 0.15)" stroke-width="1"/>
          </svg>
        </div>

        <div>
          <div class="mv-panel-header">
            <div class="mv-icon-badge mv-icon-emerald" aria-hidden="true">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
              </svg>
            </div>
            <span class="mv-eyebrow">OUR MISSION</span>
          </div>

          <h3 class="mv-heading mv-heading-light">
            Operating Smarter Through Disciplined Engineering
          </h3>

          <p class="mv-statement mv-statement-light">
            "Help businesses operate smarter through reliable technology, disciplined engineering and measurable digital growth."
          </p>
          <p style="font-size: 0.95rem; line-height: 1.68; color: #C3D0DE; margin-top: 1rem;">
            We fulfill our mission by diagnosing the systemic causes of digital friction, eliminating wasteful technology sprawl, and engineering robust digital infrastructure designed for sustained operational performance.
          </p>
        </div>

        <div class="mv-pillars">
          <span class="mv-pillar-tag">Reliable Technology</span>
          <span class="mv-pillar-tag">Disciplined Engineering</span>
          <span class="mv-pillar-tag">Measurable Digital Growth</span>
        </div>
      </div>

      <!-- Vision Panel -->
      <div class="mv-panel mv-panel-vision is-revealed">
        <div class="mv-pattern-bg" aria-hidden="true">
          <svg width="340" height="340" viewBox="0 0 340 340" fill="none">
            <polygon points="170,30 290,100 290,240 170,310 50,240 50,100" stroke="rgba(57, 224, 213, 0.25)" stroke-width="1.2" stroke-dasharray="6 4"/>
            <circle cx="170" cy="170" r="14" fill="rgba(0, 201, 193, 0.12)" stroke="#39E0D5" stroke-width="1.5"/>
          </svg>
        </div>

        <div>
          <div class="mv-panel-header">
            <div class="mv-icon-badge mv-icon-emerald" aria-hidden="true">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                <path d="M2 12h20"/>
              </svg>
            </div>
            <span class="mv-eyebrow">OUR VISION</span>
          </div>

          <h3 class="mv-heading mv-heading-light">
            Confident Scale Through Integrated Digital Expertise
          </h3>

          <p class="mv-statement mv-statement-light">
            "Build a future where businesses can access integrated technology and digital expertise to scale confidently."
          </p>
          <p style="font-size: 0.95rem; line-height: 1.68; color: #C3D0DE; margin-top: 1rem;">
            We envision an enterprise landscape where ambitious companies are never held back by technical friction, fragmented vendors, or unvalidated digital investments, but instead scale securely on proven systems.
          </p>
        </div>

        <div class="mv-pillars">
          <span class="mv-pillar-tag">Integrated Capabilities</span>
          <span class="mv-pillar-tag">Confident Scalability</span>
          <span class="mv-pillar-tag">Enduring Partnership</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION C — WHAT WE DO: SIX SERVICE CAPABILITIES
     ============================================================ -->
<section class="section about-services-section" id="what-we-do">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>WHAT WE DO</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Six Core Service Capabilities
      </h2>
      <p class="lead">
        Each capability functions as a specialized center of excellence, operating under an integrated architectural standard to ensure seamless technical and commercial execution.
      </p>
    </div>

    <div class="about-capabilities-grid">
      <!-- 1. Web & Custom Software Development -->
      <article class="capability-card">
        <div class="cap-card-header">
          <div class="cap-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
              <line x1="8" y1="21" x2="16" y2="21"/>
              <line x1="12" y1="17" x2="12" y2="21"/>
            </svg>
          </div>
          <span class="cap-card-num">01</span>
        </div>
        <h3 class="cap-card-title">Web &amp; Custom Software Development</h3>
        <p class="cap-card-desc">
          We engineer high-performance web platforms, enterprise applications, client portals, and secure database systems. Built with clean, framework-free architecture that achieves sub-second load times and flawless Core Web Vitals.
        </p>
        <div class="cap-card-meta">
          <span class="cap-pill">Custom PHP 8+</span>
          <span class="cap-pill">Enterprise Portals</span>
          <span class="cap-pill">API Systems</span>
          <span class="cap-pill">Core Web Vitals</span>
        </div>
        <a href="<?= e(getServiceUrl('web-software-development')) ?>" class="cap-card-link">
          <span>Explore Web &amp; Software Development</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </article>

      <!-- 2. Digital Marketing & SEO -->
      <article class="capability-card">
        <div class="cap-card-header">
          <div class="cap-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="m4.93 4.93 4.24 4.24"/>
              <path d="m14.83 9.17 4.24-4.24"/>
              <path d="m14.83 14.83 4.24 4.24"/>
              <path d="m9.17 14.83-4.24 4.24"/>
              <circle cx="12" cy="12" r="2"/>
            </svg>
          </div>
          <span class="cap-card-num">02</span>
        </div>
        <h3 class="cap-card-title">Digital Marketing &amp; SEO</h3>
        <p class="cap-card-desc">
          Data-led customer acquisition campaigns across search and paid channels. We combine technical SEO architecture with disciplined Google Search, Meta Ads, and B2B paid media to lower acquisition costs and drive sustainable revenue.
        </p>
        <div class="cap-card-meta">
          <span class="cap-pill">Technical SEO</span>
          <span class="cap-pill">Google Ads PPC</span>
          <span class="cap-pill">Paid Media Scaling</span>
          <span class="cap-pill">Conversion Funnels</span>
        </div>
        <a href="<?= e(getServiceUrl('digital-marketing-seo')) ?>" class="cap-card-link">
          <span>Explore Digital Marketing &amp; SEO</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </article>

      <!-- 3. UI/UX Design & Brand Identity -->
      <article class="capability-card">
        <div class="cap-card-header">
          <div class="cap-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 2 7 12 12 22 7 12 2"/>
              <polyline points="2 17 12 22 22 17"/>
              <polyline points="2 12 12 17 22 12"/>
            </svg>
          </div>
          <span class="cap-card-num">03</span>
        </div>
        <h3 class="cap-card-title">UI/UX Design &amp; Brand Identity</h3>
        <p class="cap-card-desc">
          User-centered interfaces and distinctive corporate identity systems. We craft intuitive wireframes, component design systems, and conversion-focused digital designs that build market authority and elevate user engagement.
        </p>
        <div class="cap-card-meta">
          <span class="cap-pill">Interface Design</span>
          <span class="cap-pill">User Journeys</span>
          <span class="cap-pill">Design Systems</span>
          <span class="cap-pill">Brand Architecture</span>
        </div>
        <a href="<?= e(getServiceUrl('ui-ux-branding')) ?>" class="cap-card-link">
          <span>Explore UI/UX &amp; Brand Identity</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </article>

      <!-- 4. E-Commerce & Marketplace Management -->
      <article class="capability-card">
        <div class="cap-card-header">
          <div class="cap-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="9" cy="21" r="1"/>
              <circle cx="20" cy="21" r="1"/>
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
          </div>
          <span class="cap-card-num">04</span>
        </div>
        <h3 class="cap-card-title">E-Commerce &amp; Marketplace Management</h3>
        <p class="cap-card-desc">
          Full-cycle operations across Amazon, Flipkart, and custom online storefronts. We oversee listing optimization, A+ content modules, sponsored product ads, and Buy Box strategies to scale multi-channel commercial sales.
        </p>
        <div class="cap-card-meta">
          <span class="cap-pill">Amazon &amp; Flipkart</span>
          <span class="cap-pill">Listing Optimization</span>
          <span class="cap-pill">A+ Content</span>
          <span class="cap-pill">Buy Box Protection</span>
        </div>
        <a href="<?= e(getServiceUrl('ecommerce-marketplaces')) ?>" class="cap-card-link">
          <span>Explore Marketplace Management</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </article>

      <!-- 5. Creative Production & Video Marketing -->
      <article class="capability-card">
        <div class="cap-card-header">
          <div class="cap-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="23 7 16 12 23 17 23 7"/>
              <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
            </svg>
          </div>
          <span class="cap-card-num">05</span>
        </div>
        <h3 class="cap-card-title">Creative Production &amp; Video Marketing</h3>
        <p class="cap-card-desc">
          High-impact visual content tailored for digital conversions. We produce commercial product photography, brand promo videos, motion graphics, and short-form social video formats that captivate audiences and increase engagement.
        </p>
        <div class="cap-card-meta">
          <span class="cap-pill">Studio Photography</span>
          <span class="cap-pill">Brand Video</span>
          <span class="cap-pill">Motion Graphics</span>
          <span class="cap-pill">Social Creatives</span>
        </div>
        <a href="<?= e(getServiceUrl('creative-video-production')) ?>" class="cap-card-link">
          <span>Explore Creative &amp; Video Production</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </article>

      <!-- 6. Cloud Solutions & IT Consulting -->
      <article class="capability-card">
        <div class="cap-card-header">
          <div class="cap-card-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/>
            </svg>
          </div>
          <span class="cap-card-num">06</span>
        </div>
        <h3 class="cap-card-title">Cloud Solutions &amp; IT Consulting</h3>
        <p class="cap-card-desc">
          Robust cloud infrastructure, DevOps deployment workflows, and ongoing systems maintenance. We deliver security hardening, vulnerability audits, server monitoring, and strategic technology consulting to keep digital assets secure and resilient.
        </p>
        <div class="cap-card-meta">
          <span class="cap-pill">Cloud Architecture</span>
          <span class="cap-pill">DevOps Pipelines</span>
          <span class="cap-pill">Cybersecurity Audits</span>
          <span class="cap-pill">Uptime Monitoring</span>
        </div>
        <a href="<?= e(getServiceUrl('cloud-it-consulting')) ?>" class="cap-card-link">
          <span>Explore Cloud &amp; IT Consulting</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION D — OUR APPROACH: 5-STEP PROCESS
     ============================================================ -->
<section class="section about-approach-section" id="our-approach">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR METHODOLOGY</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Our Approach: A Disciplined 5-Step Process
      </h2>
      <p class="lead">
        We execute every client engagement through a structured, transparent process designed to de-risk investments and ensure predictable technical and commercial outcomes.
      </p>
    </div>

    <div class="approach-steps-timeline">
      <!-- Step 01: Discover -->
      <article class="approach-step-item">
        <div class="step-num-bubble" aria-hidden="true">01</div>
        <div class="step-content-box">
          <div class="step-eyebrow">PHASE 01 // DIAGNOSTIC DISCOVERY</div>
          <h3 class="step-title">Discover — Understand Business Objectives &amp; Challenges</h3>
          <p class="step-tagline">Clinical examination of organizational goals, user journeys, and technical bottlenecks.</p>
          <p class="step-desc">
            We begin with an exhaustive technical and commercial audit. Rather than accepting superficial symptoms, our engineers and strategists inspect codebase health, server configurations, conversion funnels, search visibility, and competitor benchmarks to pinpoint the exact root causes of friction.
          </p>
        </div>
      </article>

      <!-- Step 02: Strategize -->
      <article class="approach-step-item">
        <div class="step-num-bubble" aria-hidden="true">02</div>
        <div class="step-content-box">
          <div class="step-eyebrow">PHASE 02 // ARCHITECTURAL BLUEPRINT</div>
          <h3 class="step-title">Strategize — Develop a Practical Roadmap</h3>
          <p class="step-tagline">Translating business requirements into an actionable, phased delivery plan.</p>
          <p class="step-desc">
            We design an unbloated technical blueprint that defines architecture specifications, technology selection, database schemas, and milestone timelines. We establish clear KPIs upfront, ensuring alignment between engineering resources, marketing spend, and corporate commercial milestones.
          </p>
        </div>
      </article>

      <!-- Step 03: Engineer -->
      <article class="approach-step-item">
        <div class="step-num-bubble" aria-hidden="true">03</div>
        <div class="step-content-box">
          <div class="step-eyebrow">PHASE 03 // RIGOROUS BUILD</div>
          <h3 class="step-title">Engineer — Build Reliable and Scalable Solutions</h3>
          <p class="step-tagline">Disciplined software development, clean interfaces, and robust systems architecture.</p>
          <p class="step-desc">
            Our engineering team writes clean, modular code free of framework dependencies, ensuring fast execution, low server overhead, and high security. Concurrently, our creative team develops design assets and high-converting marketing materials tailored precisely to the technical framework.
          </p>
        </div>
      </article>

      <!-- Step 04: Execute -->
      <article class="approach-step-item">
        <div class="step-num-bubble" aria-hidden="true">04</div>
        <div class="step-content-box">
          <div class="step-eyebrow">PHASE 04 // CONTROLLED ROLLOUT</div>
          <h3 class="step-title">Execute — Deploy and Implement with Discipline</h3>
          <p class="step-tagline">Zero-downtime production deployment, rigorous QA validation, and channel launch.</p>
          <p class="step-desc">
            Deployments are conducted through strict quality assurance protocols covering cross-browser rendering, mobile responsiveness, Core Web Vitals compliance, conversion tracking integration, and structured data validation. We ensure that new platforms launch smoothly without disrupting existing business operations.
          </p>
        </div>
      </article>

      <!-- Step 05: Optimize -->
      <article class="approach-step-item">
        <div class="step-num-bubble" aria-hidden="true">05</div>
        <div class="step-content-box">
          <div class="step-eyebrow">PHASE 05 // CONTINUOUS REFINEMENT</div>
          <h3 class="step-title">Optimize — Continuously Improve Performance</h3>
          <p class="step-tagline">Real-time performance analytics, conversion rate optimization, and ongoing enhancements.</p>
          <p class="step-desc">
            Launch is merely the beginning of value creation. We continuously analyze user telemetry, conduct multivariate conversion testing, refine paid media acquisition funnels, and perform preventive server maintenance to ensure your digital ecosystem compounds in efficiency and value over time.
          </p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION E — WHY BUSINESSDOCTOR: DIFFERENTIATORS
     ============================================================ -->
<section class="section about-why-section" id="why-businessdoctor">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>THE BUSINESSDOCTOR ADVANTAGE</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Why Forward-Thinking Enterprises Partner With Us
      </h2>
      <p class="lead">
        We distinguish our practice through architectural discipline, honest technical guidance, and an unwavering commitment to your business performance.
      </p>
    </div>

    <div class="why-differentiators-grid">
      <!-- 1. Integrated Capabilities -->
      <article class="why-card">
        <div class="why-card-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="2" width="20" height="8" rx="2" ry="2"/>
            <rect x="2" y="14" width="20" height="8" rx="2" ry="2"/>
            <line x1="6" y1="6" x2="6.01" y2="6"/>
            <line x1="6" y1="18" x2="6.01" y2="18"/>
          </svg>
        </div>
        <h3 class="why-card-title">Integrated Technology &amp; Digital Capabilities</h3>
        <p class="why-card-desc">
          We bring software engineering, search marketing, interface design, and marketplace operations under one roof. You work with a cohesive team that shares context across disciplines, eliminating the finger-pointing typical of multi-agency arrangements.
        </p>
      </article>

      <!-- 2. Business-Focused Engineering -->
      <article class="why-card">
        <div class="why-card-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
          </svg>
        </div>
        <h3 class="why-card-title">Business-Focused Engineering</h3>
        <p class="why-card-desc">
          We treat technology as a commercial enabler, not an academic exercise. Every technical decision—from database indexing to front-end architecture—is evaluated by its contribution to conversion efficiency, user experience, and revenue generation.
        </p>
      </article>

      <!-- 3. Performance-Driven Execution -->
      <article class="why-card">
        <div class="why-card-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <h3 class="why-card-title">Performance-Driven Execution</h3>
        <p class="why-card-desc">
          We hold ourselves accountable to tangible commercial KPIs: page load speed, search engine visibility, qualified lead volume, and customer acquisition cost. We deliver measurable business outcomes rather than vanity metrics.
        </p>
      </article>

      <!-- 4. Transparent Communication -->
      <article class="why-card">
        <div class="why-card-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
          </svg>
        </div>
        <h3 class="why-card-title">Transparent Communication</h3>
        <p class="why-card-desc">
          You communicate directly with senior practitioners who build and manage your systems. We provide clear milestone updates, honest technical assessments, and documented deliverables with zero agency jargon or hidden surprises.
        </p>
      </article>

      <!-- 5. Scalable & Maintainable Solutions -->
      <article class="why-card">
        <div class="why-card-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
            <polyline points="2 17 12 22 22 17"/>
            <polyline points="2 12 12 17 22 12"/>
          </svg>
        </div>
        <h3 class="why-card-title">Scalable &amp; Maintainable Solutions</h3>
        <p class="why-card-desc">
          We write clean, well-documented code designed to endure. By avoiding fragile third-party dependencies and framework bloat, we ensure that your software remains maintainable, secure, and easily extensible as your business evolves.
        </p>
      </article>

      <!-- 6. Long-Term Technical Partnership -->
      <article class="why-card">
        <div class="why-card-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <h3 class="why-card-title">Long-Term Technical Partnership</h3>
        <p class="why-card-desc">
          We build enduring relationships that extend well past deployment. Through proactive infrastructure monitoring, ongoing security patching, and strategic roadmap consulting, we serve as your trusted ongoing technology ally.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION F — OUR CORE PRINCIPLES
     ============================================================ -->
<section class="section about-principles-section" id="core-principles">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>OUR CORE PRINCIPLES</span>
      </div>
      <h2 class="section-title" style="font-size: clamp(2.2rem, 3.8vw, 3.25rem); line-height: 1.15; margin-top: 0.75rem; margin-bottom: 1.25rem;">
        Principles That Govern Our Work
      </h2>
      <p class="lead">
        Four non-negotiable operational standards that guide how we engineer software, manage marketing portfolios, and advise our clients.
      </p>
    </div>

    <div class="core-principles-grid">
      <!-- Principle 01: Engineering Excellence -->
      <article class="principle-card">
        <div class="principle-card-top">
          <div class="principle-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="16 18 22 12 16 6"/>
              <polyline points="8 6 2 12 8 18"/>
            </svg>
          </div>
          <span class="principle-num">01</span>
        </div>
        <h3 class="principle-title">Engineering Excellence</h3>
        <p class="principle-desc">
          We uphold uncompromising standards for code quality, architectural durability, and security. We do not cut corners or rely on bloated templates. Every system is built to perform under heavy production loads with sub-second responsiveness.
        </p>
        <div class="principle-tags">
          <span class="principle-pill">Clean Architecture</span>
          <span class="principle-pill">Sub-Second Load</span>
          <span class="principle-pill">Zero Bloat</span>
        </div>
      </article>

      <!-- Principle 02: Business-First Thinking -->
      <article class="principle-card">
        <div class="principle-card-top">
          <div class="principle-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <span class="principle-num">02</span>
        </div>
        <h3 class="principle-title">Business-First Thinking</h3>
        <p class="principle-desc">
          Technology serves corporate strategy, not vice versa. Before writing a line of code or launching an ad campaign, we evaluate its commercial purpose, ensuring that every engineering hour contributes directly to operational agility or top-line revenue.
        </p>
        <div class="principle-tags">
          <span class="principle-pill">Commercial ROI</span>
          <span class="principle-pill">Strategic Focus</span>
          <span class="principle-pill">Value Creation</span>
        </div>
      </article>

      <!-- Principle 03: Transparency & Accountability -->
      <article class="principle-card">
        <div class="principle-card-top">
          <div class="principle-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </div>
          <span class="principle-num">03</span>
        </div>
        <h3 class="principle-title">Transparency &amp; Accountability</h3>
        <p class="principle-desc">
          We operate with open books and clear accountability. We share unfiltered analytics, straightforward technical assessments, and documented milestones, providing clients with complete clarity regarding what is being built and how it performs.
        </p>
        <div class="principle-tags">
          <span class="principle-pill">Open Reporting</span>
          <span class="principle-pill">Clear Metrics</span>
          <span class="principle-pill">Honest Guidance</span>
        </div>
      </article>

      <!-- Principle 04: Continuous Improvement -->
      <article class="principle-card">
        <div class="principle-card-top">
          <div class="principle-icon-wrap" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="23 4 23 10 17 10"/>
              <polyline points="1 20 1 14 7 14"/>
              <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
          </div>
          <span class="principle-num">04</span>
        </div>
        <h3 class="principle-title">Continuous Improvement</h3>
        <p class="principle-desc">
          Digital landscapes, search algorithms, and consumer behaviors shift relentlessly. We practice continuous optimization—regularly auditing system performance, refining conversion funnels, and updating security protocols to ensure sustained market leadership.
        </p>
        <div class="principle-tags">
          <span class="principle-pill">System Audits</span>
          <span class="principle-pill">Iterative Refinement</span>
          <span class="principle-pill">Future-Proofing</span>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION G — CLOSING CTA: START A PROJECT
     ============================================================ -->
<section class="section about-closing-cta-section" id="start-project" style="background: var(--color-surface); padding-top: 3.5rem; padding-bottom: 5rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <div class="eyebrow-badge" style="margin-bottom: 1.25rem;">
          <span class="pill-dot"></span>
          <span>START YOUR PROJECT</span>
        </div>
        <h2 class="closing-cta-title" style="font-size: clamp(2rem, 3.8vw, 3rem); line-height: 1.2; margin-bottom: 1.25rem;">
          Ready to Solve Your Disconnected Business Challenges?
        </h2>
        <p class="closing-cta-lead" style="font-size: 1.05rem; line-height: 1.7; color: #C3D0DE; max-width: 680px; margin: 0 auto 2.5rem;">
          Schedule an introductory consultation with our technology and growth practice leads. Let’s evaluate your digital infrastructure, discuss your commercial goals, and build an integrated roadmap to scale.
        </p>
        <div class="closing-cta-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
          <a href="contact.php" class="btn btn-accent btn-lg">
            <span>Schedule a Project Consultation</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
