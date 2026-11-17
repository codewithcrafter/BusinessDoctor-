<?php
/**
 * BusinessDoctor Service Detail View — Custom Web Development & Enterprise Software
 * Discipline 01 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Web Development';
$serviceSlug = 'web-development';
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
          <span>WEBSITE DEVELOPMENT COMPANY IN DELHI</span>
        </div>
        <h1 class="srv-hero-title">
          Website Development Company in Delhi <br><span class="text-brand">for High-Performance Websites and Enterprise Software</span>
        </h1>
        <p class="srv-hero-desc">
          Looking for a Website Development Company in Delhi specialising in high-Performance Websites and Enterprise Software? Businessdoctor is a company that designs user friendly, fast corporate websites, client portals and secure web applications for companies in Delhi. We build every website from scratch, not just a template. We use modern technologies like PHP 8+ and JavaScript to make your website fast and smooth. A user-friendly website leads to better Google rankings and more leads.
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
            <span>Explore Capabilities</span>
            <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </a>
        </div>

        <div class="srv-hero-stats">
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">No Bloat</span>
            <span class="srv-hero-stat-lbl">No Extra Code: Simple &amp; lightweight</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">&lt; 1.0s</span>
            <span class="srv-hero-stat-lbl">Fast Loading: Smooth user experience</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">OWASP</span>
            <span class="srv-hero-stat-lbl">Strong Security: Secure coding methods</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">PHP 8+</span>
            <span class="srv-hero-stat-lbl">Long-Lasting Code: Clean &amp; organised</span>
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
              <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.dev :: enterprise-architecture-runtime</text>
              <rect x="40" y="65" width="520" height="150" rx="10" fill="#030E1A" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
              <text x="65" y="100" fill="#06B5F9" font-family="monospace" font-size="12" font-weight="bold">// PHP 8+ STRICT ENGINE EXECUTION</text>
              <path d="M 65 175 L 140 145 L 220 155 L 310 115 L 400 130 L 520 85" stroke="#34D399" stroke-width="3" fill="none"/>
              <circle cx="520" cy="85" r="5" fill="#34D399"/>
              <text x="430" y="75" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="bold">&lt; 0.5s TTFB</text>
              <rect x="40" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="60" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// LIGHTHOUSE AUDIT</text>
              <text x="60" y="305" fill="#34D399" font-family="sans-serif" font-size="28" font-weight="900">95 - 100</text>
              <text x="60" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Core Web Vitals Pass</text>
              <text x="60" y="365" fill="#ffffff" font-family="sans-serif" font-size="13" font-weight="600">Zero Unnecessary Frameworks</text>
              <rect x="310" y="235" width="250" height="170" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
              <text x="330" y="265" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// ARCHITECTURE</text>
              <text x="330" y="305" fill="#06B5F9" font-family="sans-serif" font-size="28" font-weight="900">100% Custom</text>
              <text x="330" y="330" fill="#B8C7D9" font-family="sans-serif" font-size="12">Full Source Code Ownership</text>
              <text x="330" y="365" fill="#34D399" font-family="sans-serif" font-size="13" font-weight="600">OWASP Top 10 Hardened</text>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2 — ARCHITECTURAL PHILOSOPHY
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="introduction">
  <div class="srv-container">
    <div class="srv-row srv-align-center">
      <div class="srv-col-12 srv-col-lg-6">
        <div class="srv-badge mb-3">
          <span class="srv-badge-dot"></span>
          <span>Architectural Philosophy</span>
        </div>
        <h2 class="srv-section-title">
          Why Fast and Maintainable Code Matters in <span class="text-brand">Professional Website Development</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Why do speed and maintainability matter? Most business websites suffer from Code Quality Issues. They are often full with heavy themes, Plugin Problems and low-performing databases. This can lead to poor performance, low rankings and high maintenance.
        </p>
        <p class="srv-card-desc mb-4">
          Our professional website development services make sure that we build your website from the scratch by using PHP8+, MariaDB / PostgreSQL and Fast-Loading Design.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">No Extra Code –</strong> 
              <span class="text-secondary">We keep your website simple and lightweight by avoiding unnecessary code and plugins.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Fast Loading –</strong> 
              <span class="text-secondary">We build fast-loading websites that provide a smooth user experience.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Strong Security –</strong> 
              <span class="text-secondary">We use secure coding methods to provide security to your website</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Long-Lasting Code –</strong> 
              <span class="text-secondary">We write clean and organised code that makes your website easy to manage and update</span>
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
            <span class="srv-hud-title">SYSTEM ARCHITECTURE TELEMETRY</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              PRODUCTION ENGINE ACTIVE
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time telemetry showing server execution benchmarks, memory footprints, query latency, and Core Web Vitals across deployments.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">&lt; 0.5s</div>
                <div class="srv-hud-metric-label">TTFB Server Time</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">95+</div>
                <div class="srv-hud-metric-label">Lighthouse Score</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100%</div>
                <div class="srv-hud-metric-label">Custom Codebase</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0%</div>
                <div class="srv-hud-metric-label">Bloated Plugins</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">PHP 8+</span>
              <span class="srv-tool-badge">MariaDB</span>
              <span class="srv-tool-badge">PostgreSQL</span>
              <span class="srv-tool-badge">Vanilla JS</span>
              <span class="srv-tool-badge">REST API</span>
              <span class="srv-tool-badge">Cloudflare</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4 — CAPABILITIES / WHAT WE OFFER
     ============================================================ -->
<section class="srv-section srv-bg-surface" id="services-list">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>Capabilities</span>
      </div>
      <h2 class="srv-section-title">
        Website Development Company in Delhi <span class="text-brand">offering High-Quality Solutions</span>
      </h2>
      <p class="srv-section-subtitle">
        Custom engineering tailored to your operational workflows, performance benchmarks, and commercial growth.
      </p>
    </div>

    <div class="srv-grid-3">
      <!-- Capability 1 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
        </div>
        <h3 class="srv-card-title">Custom Web Applications</h3>
        <p class="srv-card-desc">Business doctor provides best website development services in Delhi and builds every web application from scratch according to your needs to provide a smooth user experience so that your brand becomes unforgettable.</p>
        <ul class="srv-card-list">
          <li>Strongly Typed</li>
          <li>Fast Server Execution</li>
          <li>Multi-Tenant</li>
          <li>Designed according to your business needs, without any unnecessary code</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Designed according to your business needs, without any unnecessary code.</span>
        </div>
      </div>

      <!-- Capability 2 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h3 class="srv-card-title">Custom Website Development for Corporate and Service Companies</h3>
        <p class="srv-card-desc">We build professional websites for your business that provide perfect mobile layouts, best user experience and a custom headless CMS.</p>
        <ul class="srv-card-list">
          <li>Fast Website Performance</li>
          <li>Easy Content Management</li>
          <li>Automatic Structured Data</li>
          <li>Mobile Friendly Design</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Build your credibility and turn more visitors into quality leads.</span>
        </div>
      </div>

      <!-- Capability 3 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
        </div>
        <h3 class="srv-card-title">Client Portals / B2B Dashboards</h3>
        <p class="srv-card-desc">Create secure websites where your client can share documents, manage invoices, view reports and handle daily tasks.</p>
        <ul class="srv-card-list">
          <li>Role Based Access Control</li>
          <li>Two Factor Authentication</li>
          <li>Live Data Visualisation</li>
          <li>Email/SMS Alerts</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Automate your communications with clients.</span>
        </div>
      </div>

      <!-- Capability 4 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </div>
        <h3 class="srv-card-title">REST API</h3>
        <p class="srv-card-desc">APIs with documentation to connect your website to your mobile apps, CRMs and payment gateways.</p>
        <ul class="srv-card-list">
          <li>Easy Data Sharing</li>
          <li>Secure Access Control</li>
          <li>Request Management</li>
          <li>Clear API Documentation</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Enable your software to integrate with the modern digital world.</span>
        </div>
      </div>

      <!-- Capability 5 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
        </div>
        <h3 class="srv-card-title">Database Architecture and Optimisation</h3>
        <p class="srv-card-desc">We optimise MySQL, MariaDB and PostgreSQL so that the website can handle transactions and data easily.</p>
        <ul class="srv-card-list">
          <li>Faster Database Searches</li>
          <li>Faster Website Performance</li>
          <li>Updates Without Downtime</li>
          <li>Secure Daily Backups</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Fast querying for large data sets.</span>
        </div>
      </div>

      <!-- Capability 6 -->
      <div class="srv-card">
        <div class="srv-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        </div>
        <h3 class="srv-card-title">Legacy Upgrades and Refactoring</h3>
        <p class="srv-card-desc">Upgrade slow outdated PHP systems to modern runtimes.</p>
        <ul class="srv-card-list">
          <li>PHP Version Upgrade</li>
          <li>Database Upgrade</li>
          <li>Safe Website Updates</li>
          <li>Testing After Updates</li>
        </ul>
        <div class="srv-sector-outcome mt-3">
          <span class="srv-outcome-badge">Business Value</span>
          <span>Remove technical debt without a full rebuild.</span>
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
        <span>DELIVERY BLUEPRINT</span>
      </div>
      <h2 class="srv-section-title">
        Our 6-Phase Website Development Process, <span class="text-brand">From Blueprint to Launch</span>
      </h2>
      <p class="srv-section-subtitle">
        As a trusted website development company in Delhi, we follow a six-step process. We start with identifying and planning to understand your goals, then design a clean, mobile-friendly website. Our professional website developers in Delhi can build your website. Before release, we test everything on every device so that we can provide you with a smooth website, and after release, we stay with you to fix issues and help you grow. This is how our custom website development services turn into more leads for your business.
      </p>
    </div>

    <div class="srv-process-timeline">
      <!-- Step 1 -->
      <div class="srv-process-step">
        <div class="srv-step-number">01</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">1. Architecture and Schema Design</h3>
          <p class="srv-step-desc">Plan how your website stores data, shares information and controls who can access the website.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Database Structure, API Guides, Website Structure and Planning</span>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="srv-process-step">
        <div class="srv-step-number">02</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">2. Database and Core Logic</h3>
          <p class="srv-step-desc">Secure database layers and core business logic are created by our Delhi website developers.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Database Updates, Secure Login and User Access, Automatic Data Setup</span>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="srv-process-step">
        <div class="srv-step-number">03</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">3. Frontend and UI</h3>
          <p class="srv-step-desc">We build fast and user-friendly website pages using HTML5 and CSS, and connect them to your website's backend</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Designs for All Devices, Easy Online Forms, Interactive and Easy to Use Dashboards</span>
          </div>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="srv-process-step">
        <div class="srv-step-number">04</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">4. Security and Stress Testing</h3>
          <p class="srv-step-desc">We run security tests and stress tests to make sure your site remains secure.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Website Security Report, Website Performance Test Results, Website Speed and User Experience</span>
          </div>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="srv-process-step">
        <div class="srv-step-number">05</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">5. Deployment</h3>
          <p class="srv-step-desc">We deploy your site without any downtime and set up SSL.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>Website Launch, Daily Data Backups, Website Monitoring and Notifications</span>
          </div>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="srv-process-step">
        <div class="srv-step-number">06</div>
        <div class="srv-step-content">
          <h3 class="srv-step-title">6. SLA Support and Optimisations</h3>
          <p class="srv-step-desc">As a website development company in Delhi we’ll continue to provide support to ensure your site runs quickly and securely.</p>
          <div class="srv-step-deliverables">
            <span class="srv-deliverable-label">Key Deliverables:</span>
            <span>24/7 Monitoring, Quarterly Security Audits, SLA Priority Support</span>
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
        <span>WHY LEADING COMPANIES CHOOSE US</span>
      </div>
      <h2 class="srv-section-title">
        Why Leading Companies Choose BusinessDoctor as Their <span class="text-brand">Website Development Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Leading companies choose BusinessDoctor as Their Website Development Company in Delhi. We are experts in bridging the gap between business strategy and technology. You get support from experienced experts without extra costs.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Zero Framework Bloat</div>
        <h3 class="srv-benefit-title">Clean Custom Code, Zero Bloat</h3>
        <p class="srv-benefit-desc">We write every line of code ourselves. We do not use ready-made themes or weak plugins that slow your site down. This means your website stays light, fast and easy to look after. You only get the features you really need, nothing more. That is how we do custom website development the right way.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Lighthouse 95+ Score</div>
        <h3 class="srv-benefit-title">Sub-Second Speed Guarantee</h3>
        <p class="srv-benefit-desc">We develop websites that load in less than a second. We aim for a Lighthouse score of 95 or higher to improve speed and quality, help you rank higher on Google and turn more of them into enquiries.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">OWASP Hardened</div>
        <h3 class="srv-benefit-title">Enterprise Security and OWASP Hardened</h3>
        <p class="srv-benefit-desc">Your website holds important information, so we keep it safe. We use secure coding methods to protect your website database from harmful code and online attacks. We also follow trusted security guidelines to keep your website safe. This keeps your data, your customers and your business protected all the time.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Clean Database Schemas</div>
        <h3 class="srv-benefit-title">Optimized Relational Data Architecture</h3>
        <p class="srv-benefit-desc">We manage your website data properly and avoid storing the same information again. We also make searching faster, so if your website has alot of data, it continues to work smoothly and load quickly.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">100% Code Ownership</div>
        <h3 class="srv-benefit-title">Complete IP and Source Code Ownership</h3>
        <p class="srv-benefit-desc">When the project is done, everything belongs to you. We hand over all the source code and database schemas. There are no licensing fees and no hidden charges. You are free to grow, change or move your website anytime, and you never depend on us to keep it running.</p>
      </div>

      <div class="srv-benefit-card">
        <div class="srv-benefit-badge">Direct Senior Engineer Access</div>
        <h3 class="srv-benefit-title">Direct Access to Senior Website Developers in Delhi</h3>
        <p class="srv-benefit-desc">You talk straight to the people who build your website. There are no middlemen and no junior developers learning on your project. Our senior website developers in Delhi answer your questions, explain things in simple words and give you quick updates. So you always know what is happening with your website.</p>
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
        Tools and Technologies Used by Our <span class="text-brand">Custom Web Development Company in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Tools used by Our Custom Web Development company in Delhi.
      </p>
    </div>

    <div class="srv-grid-4">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Backend / Server</h3>
        <ul class="srv-tech-list">
          <li><strong>PHP 8.2/8.3:</strong> Fast and secure versions of PHP.</li>
          <li><strong>Apache:</strong> A reliable web server.</li>
          <li><strong>Nginx:</strong> Very fast server that can handle lots of traffic.</li>
          <li><strong>Node.js:</strong> Used to add real time features.</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Database/Cache</h3>
        <ul class="srv-tech-list">
          <li><strong>MariaDB:</strong> Fast open source database.</li>
          <li><strong>MySQL 8:</strong> A very popular database that can handle huge amounts of data.</li>
          <li><strong>PostgreSQL 16:</strong> A great database that can handle large and complex data.</li>
          <li><strong>Redis:</strong> Caching system that stores frequently used data which makes page loads much faster.</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Frontend</h3>
        <ul class="srv-tech-list">
          <li><strong>HTML5:</strong> Pages will be well structured and easy for search engines and browsers to parse.</li>
          <li><strong>CSS Custom Properties:</strong> Can easily and quickly update the design and keep everything consistent with your branding.</li>
          <li><strong>Vanilla ES6+ JS:</strong> Zero Libraries, Zero Dependencies.</li>
          <li><strong>Bootstrap 5.3:</strong> Helps style and size content in a slimmed down layout.</li>
        </ul>
      </div>

      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">DevOps/Security</h3>
        <ul class="srv-tech-list">
          <li><strong>Docker:</strong> Makes sure your website is the same from testing to production.</li>
          <li><strong>Git/GitHub Actions:</strong> Tracks changes and automatically tests and updates.</li>
          <li><strong>Cloudflare:</strong> Protects your site and makes it fast around the world.</li>
          <li><strong>Composer:</strong> Secure package manager for PHP.</li>
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
        Web Development Company in Delhi for <span class="text-brand">High-Growth Sectors</span>
      </h2>
      <p class="srv-section-subtitle">
        Web Development Company in Delhi specialising in high growth industries.
      </p>
    </div>

    <div class="srv-grid-3">
      <div class="srv-card">
        <h3 class="srv-card-title">Fintech and Banking</h3>
        <p class="srv-card-desc"><strong>Secure Financial Dashboards and Portals:</strong> We built a secure financial platform with a safe login system, protected data, storage and activity records. This keeps your financial information safe and makes your website work smoothly.</p>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Healthcare</h3>
        <p class="srv-card-desc"><strong>Secure Patient Booking and Telehealth:</strong> We create secure healthcare websites where patients can book their appointments and share documents safely. We keep patient information private and make sure that the website stays available</p>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">B2B SaaS and Enterprise</h3>
        <p class="srv-card-desc"><strong>Multi-Tenant SaaS Backends:</strong> We build platforms where different businesses can manage their accounts, choose suitable plans and use services securely. Our systems are designed to handle more users as your business grows.</p>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Commerce and Marketplaces</h3>
        <p class="srv-card-desc"><strong>Multi Warehouse Inventory:</strong> We connect information across different warehouses, stores and online marketplaces. This helps you to keep track of products, avoid running out of stock.</p>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Logistics</h3>
        <p class="srv-card-desc"><strong>Real Time Fleet and Freight Tracking:</strong> Live data, mapping and automated dispatch. Improving dispatch.</p>
      </div>

      <div class="srv-card">
        <h3 class="srv-card-title">Professional Consulting</h3>
        <p class="srv-card-desc"><strong>High Converting Corporate Platforms:</strong> We build professional business websites that have clear information, customer success stories and easy enquiry forms. This helps businesses attract potential clients and get more quality enquiries</p>
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
        <span>FAQs</span>
      </div>
      <h2 class="srv-section-title">
        Common Questions About <span class="text-brand">Website Development Services in Delhi</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our web development process, speed, security, and project timelines.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">What do you do to make sure sites load quickly?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We use modern technology to make website smooth. This helps with fast website loading and helps search engines understand your website easily. We use Cloudflare to improve the speed and security of your website</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Can you build client portals?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes, we can. We can create custom portals for your business and can connect them with ariaDB, PostgreSQL, HubSpot and Salesforce</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Will we have access to the source code?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes! You will receive all source code, schemas, documentation and assets.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">How do you ensure security?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>All of our development is done using OWASP Top 10 guidelines. We use PDO prepared statements, validation, strict CSP and HTTP headers.</p>
          </div>
        </div>
      </div>

      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How long does a project take?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Corporate sites usually take between 4-6 weeks. Custom web apps & portals take between 8-12 weeks.</p>
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
              Ready to Build with the Leading <span class="text-brand">Website Development Company in Delhi?</span>
            </h2>
            <p class="srv-cta-lead">
              Schedule a discovery consultation with our senior software architects. We will analyze your system requirements, review existing codebases, and propose an optimal engineering blueprint.
            </p>
            <div class="srv-cta-actions" style="justify-content: flex-start; margin-bottom: 2rem;">
              <a href="<?= e($consultationUrl) ?>" class="btn-srv-primary btn-srv-lg">
                <span>Get a Free Consultation</span>
                <svg class="btn-srv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
              <a href="<?= appUrl('audit.php') ?>" class="btn-srv-secondary btn-srv-lg">
                <span>Request Technical Audit</span>
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
                  <label class="srv-form-label" for="quick_name_web-development">Your Full Name</label>
                  <input type="text" id="quick_name_web-development" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_web-development">Work Email</label>
                  <input type="email" id="quick_email_web-development" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_web-development">Company / Domain</label>
                  <input type="text" id="quick_company_web-development" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_web-development">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_web-development" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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