<?php
/**
 * BusinessDoctor Service Detail View — Web & Custom Software Development
 * Discipline 10 — Full-Width Modern Enterprise Landing Page
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
          <span>HIGH-PERFORMANCE WEB &amp; SOFTWARE ENGINEERING</span>
        </div>
        <h1 class="srv-hero-title">
          Engineering High-Performance <br><span class="text-brand">Web Applications &amp; Enterprise Software</span>
        </h1>
        <p class="srv-hero-desc">
          We architect lightning-fast corporate websites, mission-critical web applications, client portals, and secure database backends engineered with clean PHP 8+, modern JavaScript, and sub-second Core Web Vitals.
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
            <span class="srv-hero-stat-val">&lt; 0.8s</span>
            <span class="srv-hero-stat-lbl">Global TTFB &amp; Load</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">Clean Custom Code</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">99.9%</span>
            <span class="srv-hero-stat-lbl">Uptime SLA Reliability</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">95+</span>
            <span class="srv-hero-stat-lbl">Lighthouse Score</span>
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
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.internal :: architecture-core.v2</text>
  
  <!-- Architecture Nodes -->
  <rect x="50" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="70" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// APPLICATION LAYER</text>
  <text x="70" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">PHP 8.3 &bull; REST API Gateway</text>
  <text x="70" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Sub-second Execution &bull; 0.42s LCP</text>

  <rect x="320" y="70" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="340" y="95" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// DATA PERSISTENCE</text>
  <text x="340" y="122" fill="#F5F7FA" font-family="sans-serif" font-size="14" font-weight="bold">MariaDB / PostgreSQL &amp; Redis</text>
  <text x="340" y="142" fill="#B8C7D9" font-family="monospace" font-size="11">Connection Pooling &bull; 1.2ms Queries</text>

  <line x1="280" y1="115" x2="320" y2="115" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

  <!-- Code Window / Terminal -->
  <rect x="50" y="180" width="500" height="225" rx="10" fill="#051424" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
  <text x="70" y="210" fill="#34D399" font-family="monospace" font-size="12">$ http_get --speed-benchmark /api/v2/workspaces</text>
  <text x="70" y="235" fill="#F5F7FA" font-family="monospace" font-size="11">&gt; 200 OK &bull; [TTFB: 28ms] [DOM: 142ms] [Full Render: 380ms]</text>
  <text x="70" y="260" fill="#8FA3B8" font-family="monospace" font-size="11">&gt; Core Web Vitals Status: [FID: 4ms] [CLS: 0.00] [INP: 18ms]</text>
  <text x="70" y="285" fill="#06B5F9" font-family="monospace" font-size="11">&gt; Security Headers: CSP=Strict, HSTS=31536000, XSS-Protection=1</text>
  <text x="70" y="310" fill="#B8C7D9" font-family="monospace" font-size="11">&gt; Active Worker Threads: 64 | Memory Allocated: 14.8MB</text>
  
  <rect x="70" y="335" width="460" height="50" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.4"/>
  <circle cx="95" cy="360" r="12" fill="#34D399" fill-opacity="0.2"/>
  <circle cx="95" cy="360" r="5" fill="#34D399"/>
  <text x="120" y="356" fill="#F5F7FA" font-family="sans-serif" font-size="12" font-weight="bold">Zero-Bloat Engineering Standard Active</text>
  <text x="120" y="373" fill="#B8C7D9" font-family="monospace" font-size="10">No heavy runtime frameworks &bull; Pure native execution</text>
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
            <span class="srv-takeaway-val">&lt; 0.8s</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Global TTFB &amp; Load</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Clean Custom Code</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">99.9%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Uptime SLA Reliability</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">95+</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Lighthouse Score</span>
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
          <span>ARCHITECTURAL PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Why Fast, Maintainable Code is Your <span class="text-brand">Strongest Unfair Advantage</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Most corporate websites and software applications are drowning in technical debt: bloated themes, dozens of conflicting third-party plugins, unindexed database queries, and fragile dependencies that break with every update.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we engineer software from the database schema up. Using clean, modern PHP 8+, strictly typed architectures, robust MariaDB/PostgreSQL data modeling, and performance-first frontend code, we deliver mission-critical platforms that load in milliseconds and scale without breaking.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Zero-Bloat Native Architecture:</strong> 
              <span class="text-secondary">Lightweight, dependency-free codebases with zero unnecessary framework overhead.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Sub-Second Global Performance:</strong> 
              <span class="text-secondary">Lightning-fast TTFB and 95+ Google Lighthouse scores across desktop and mobile.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Enterprise Security &amp; Isolation:</strong> 
              <span class="text-secondary">Parameterized PDO queries, strict CSP headers, and robust OWASP Top 10 defenses.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Long-Term Maintainability SLA:</strong> 
              <span class="text-secondary">Clean, human-readable codebases designed for effortless 5-to-10 year operational lifespans.</span>
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
            <span class="srv-hud-title">TELEMETRY BENCHMARK CONSOLE</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              SYSTEM PERFORMANCE: OPTIMAL
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Live Core Web Vitals telemetry tracking global edge response times, database query execution, and rendering efficiency.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.42s</div>
                <div class="srv-hud-metric-label">Largest Contentful Paint</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">1.2ms</div>
                <div class="srv-hud-metric-label">Avg Database Latency</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">99.99%</div>
                <div class="srv-hud-metric-label">Annual Uptime Rate</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">100</div>
                <div class="srv-hud-metric-label">Lighthouse Performance</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">PHP 8.3</span>
              <span class="srv-tool-badge">MariaDB</span>
              <span class="srv-tool-badge">PostgreSQL</span>
              <span class="srv-tool-badge">Docker</span>
              <span class="srv-tool-badge">Redis</span>
              <span class="srv-tool-badge">REST APIs</span>
              <span class="srv-tool-badge">Cloudflare Edge</span>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        </div>
        <h3 class="srv-card-title">Custom Web Application Engineering</h3>
        <p class="srv-card-desc">Bespoke web applications built from scratch with modern PHP 8+, clean MVC architecture, and high-speed relational databases.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Clean Object-Oriented Architecture</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Strictly Typed PHP 8+ Codebase</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Sub-Second Server Execution</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Scalable Multi-Tenant Foundations</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Built specifically for your business logic with zero framework overhead.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Custom Web Application Engineering')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        </div>
        <h3 class="srv-card-title">Enterprise Corporate &amp; Service Websites</h3>
        <p class="srv-card-desc">Authoritative corporate websites engineered for lightning-fast speeds, flawless responsive behavior, and effortless CMS publishing.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Sub-Second Core Web Vitals</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Custom In-House Headless CMS</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automatic JSON-LD Schema Generation</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Flawless Mobile-First Layouts</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Projects unmatched executive credibility and converts visitors into qualified inbound leads.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Enterprise Corporate & Service Websites')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">Client Portals &amp; B2B Dashboards</h3>
        <p class="srv-card-desc">Secure, authenticated client web portals and administrative dashboards for document sharing, invoicing, analytics, and workflow management.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Role-Based Access Control (RBAC)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Two-Factor Authentication (2FA)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Real-Time Data Visualization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Email &amp; SMS Notifications</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Automates customer communications and eliminates costly manual back-office tasks.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Client Portals & B2B Dashboards')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
        </div>
        <h3 class="srv-card-title">High-Speed REST API Architecture</h3>
        <p class="srv-card-desc">Robust, documented RESTful APIs that connect your web systems to mobile apps, CRM systems, payment gateways, and third-party partners.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>JSON REST &amp; Webhook Gateways</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Bearer Token &amp; OAuth2 Authentication</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Rate Limiting &amp; DDoS Throttling</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>OpenAPI / Swagger Documentation</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Allows your software to integrate seamlessly with the modern digital ecosystem.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('High-Speed REST API Architecture')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        </div>
        <h3 class="srv-card-title">Database Architecture &amp; Query Optimization</h3>
        <p class="srv-card-desc">Deep schema design, query indexing, and performance tuning for MySQL, MariaDB, and PostgreSQL to handle millions of transactions.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Composite Index Optimization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Redis In-Memory Caching Layers</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Zero-Downtime Schema Migrations</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Daily Encrypted Backups</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Ensures queries execute in single-digit milliseconds even as data volume expands exponentially.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Database Architecture & Query Optimization')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg></div>
        </div>
        <h3 class="srv-card-title">Legacy Modernization &amp; Code Refactoring</h3>
        <p class="srv-card-desc">Revitalizing slow, outdated PHP and legacy systems, upgrading to modern runtimes and modernizing architecture without business disruption.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>PHP 5/7 to PHP 8+ Modernization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Database Engine Upgrades &amp; Normalization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Zero-Downtime Blue/Green Rollouts</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Comprehensive Regression Testing</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Eliminates technical debt and unlocks modern performance without rewriting from scratch.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Legacy Modernization & Code Refactoring')) ?>" class="srv-link-action">
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
        <h3 class="srv-process-title">Architecture Blueprint &amp; Schema Modeling</h3>
        <p class="srv-card-desc mb-3">We define exact data models, database relational schemas, REST API endpoints, and user role permission matrices.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Database Entity Relationship Diagram</li>
            <li>API Specification Contract</li>
            <li>Technical Architecture Blueprint</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; WEEKS 2–4</div>
        <h3 class="srv-process-title">Database Setup &amp; Core Engine Formulation</h3>
        <p class="srv-card-desc mb-3">We provision database tables, author secure PDO database connection layers, and implement core business logic.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Version-Controlled SQL Migrations</li>
            <li>Secure Authentication &amp; RBAC Modules</li>
            <li>Automated Data Seed Scripts</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; WEEKS 4–6</div>
        <h3 class="srv-process-title">High-Speed Frontend &amp; Interface Integration</h3>
        <p class="srv-card-desc mb-3">We build the user interface using semantic HTML5, modern CSS variables, and responsive layouts connected to backend controllers.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Responsive UI Templates (Desktop/Mobile)</li>
            <li>Asynchronous Form Handlers &amp; Modals</li>
            <li>Interactive Dashboards &amp; Data Tables</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; WEEKS 6–7</div>
        <h3 class="srv-process-title">Security Hardening &amp; Stress Testing</h3>
        <p class="srv-card-desc mb-3">We conduct rigorous penetration tests, simulate 10x traffic spikes, and verify zero SQL injection or CSRF vulnerabilities.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>OWASP Security Audit Report</li>
            <li>Apache/Nginx Stress Test Benchmarks</li>
            <li>Core Web Vitals Verification (&lt; 0.8s)</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; WEEKS 7–8</div>
        <h3 class="srv-process-title">Production Launch &amp; DNS Cutover</h3>
        <p class="srv-card-desc mb-3">We deploy to production under a zero-downtime blue/green protocol, configure SSL certificates, and verify live endpoints.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Live Production Cutover</li>
            <li>Automated Nightly Backup Configuration</li>
            <li>System Monitoring &amp; Alert Routing</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; ONGOING</div>
        <h3 class="srv-process-title">Continuous SLA Support &amp; Performance Tuning</h3>
        <p class="srv-card-desc mb-3">We provide 24/7 server monitoring, proactive security updates, database index re-tuning, and dedicated engineering support.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>24/7 Uptime Monitoring</li>
            <li>Quarterly Security &amp; Dependency Audits</li>
            <li>Guaranteed Sub-2 Hour SLA Response</li>
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
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        <h3 class="srv-card-title">Clean Custom Code — Zero Bloat</h3>
        <p class="srv-card-desc">We do not build on bloated commercial themes or fragile plugin stacks. Every line of code is clean, documented, and built to perform.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Zero-Bloat</span>
          <span class="text-muted text-sm ms-2">Native PHP 8+ Architecture</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
        <h3 class="srv-card-title">Sub-Second Speed Guarantee</h3>
        <p class="srv-card-desc">We engineer for sub-800ms global load times and 95+ Google Lighthouse scores, directly lifting your SEO rankings and conversion rates.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">< 0.8s</span>
          <span class="text-muted text-sm ms-2">Global TTFB &amp; Load Time</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3 class="srv-card-title">Enterprise Security &amp; OWASP Hardened</h3>
        <p class="srv-card-desc">From parameterized PDO queries to strict Content Security Policies, your digital assets are shielded from modern cyber threats.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">OWASP Top 10</span>
          <span class="text-muted text-sm ms-2">Security Shield Standards</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
        <h3 class="srv-card-title">Optimized Relational Data Architecture</h3>
        <p class="srv-card-desc">Our database engineers design normalized schemas with composite indexes that query millions of records in single-digit milliseconds.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">1.2ms</span>
          <span class="text-muted text-sm ms-2">Average Query Latency</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        <h3 class="srv-card-title">Complete IP &amp; Source Code Ownership</h3>
        <p class="srv-card-desc">You own 100% of your source code, database schemas, and intellectual property upon delivery. Zero licensing fees or vendor lock-in.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">100%</span>
          <span class="text-muted text-sm ms-2">Client Owned IP</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <h3 class="srv-card-title">Direct Senior Engineer Communication</h3>
        <p class="srv-card-desc">You communicate directly with senior full-stack developers who actually write your software, eliminating account manager telephone games.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Senior Leads</span>
          <span class="text-muted text-sm ms-2">Zero Junior Handoff</span>
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
        <h3 class="srv-tech-cat-title">Backend &amp; Server Runtimes</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">PHP 8.2 / 8.3</span>
            <span class="srv-tool-role">Strictly Typed Enterprise Core</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Apache HTTP Server</span>
            <span class="srv-tool-role">Enterprise Production Web Server</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Nginx</span>
            <span class="srv-tool-role">Reverse Proxy &amp; High-Concurrency Edge</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Node.js</span>
            <span class="srv-tool-role">Build Tools &amp; Microservices</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Databases &amp; In-Memory Caching</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">MariaDB 10.4+</span>
            <span class="srv-tool-role">High-Performance Relational DB</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">MySQL 8.0</span>
            <span class="srv-tool-role">Enterprise Relational Storage</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">PostgreSQL 16</span>
            <span class="srv-tool-role">Advanced ACID Transaction Engine</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Redis</span>
            <span class="srv-tool-role">Sub-Millisecond Cache &amp; Session Store</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Frontend &amp; Standards-Based UI</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">HTML5 / Semantic DOM</span>
            <span class="srv-tool-role">Accessible, SEO-Ready Markup</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">CSS Custom Properties</span>
            <span class="srv-tool-role">Modern Design Token Styling</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Vanilla ES6+ JavaScript</span>
            <span class="srv-tool-role">Zero-Framework UI Controller</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Bootstrap 5.3</span>
            <span class="srv-tool-role">12-Column Responsive Layout Grid</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">DevOps, CI/CD &amp; Security</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Docker</span>
            <span class="srv-tool-role">Isolated Containerized Environments</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Git / GitHub Actions</span>
            <span class="srv-tool-role">Automated CI/CD Deployment</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Cloudflare Enterprise</span>
            <span class="srv-tool-role">DDoS Shield &amp; Edge Caching</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Composer</span>
            <span class="srv-tool-role">PHP Dependency Management</span>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <span class="srv-industry-tag">FINTECH &amp; BANKING</span>
        </div>
        <h3 class="srv-card-title">High-Security Financial Dashboards &amp;amp; Portals</h3>
        <p class="srv-card-desc">Multi-tier role authentication, encrypted database storage, and audit logs complying with international financial regulations.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Zero Security Audit Findings &amp; Sub-Second Latency</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
          <span class="srv-industry-tag">HEALTHCARE &amp; CLINICAL</span>
        </div>
        <h3 class="srv-card-title">HIPAA-Compliant Patient Telehealth Systems</h3>
        <p class="srv-card-desc">Secure appointment booking, encrypted document exchange, and seamless integration with clinical electronic health records.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">99.99% Uptime with Guaranteed Patient Privacy</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
          <span class="srv-industry-tag">B2B SAAS &amp; ENTERPRISE</span>
        </div>
        <h3 class="srv-card-title">Multi-Tenant SaaS Application Backends</h3>
        <p class="srv-card-desc">Scalable multi-tenant architectures with custom billing tiers, user workspace isolation, and automated API rate limiting.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Effortlessly Absorbed 10x User Expansion</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg></div>
          <span class="srv-industry-tag">COMMERCE &amp; MARKETPLACE HUBS</span>
        </div>
        <h3 class="srv-card-title">High-Speed Multi-Warehouse Inventory Systems</h3>
        <p class="srv-card-desc">Synchronizing 50,000+ SKUs across physical stores, Amazon, and custom websites in under two seconds.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Eliminated Stockouts &amp; Reduced Query Time by 85%</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
          <span class="srv-industry-tag">LOGISTICS &amp; SUPPLY CHAIN</span>
        </div>
        <h3 class="srv-card-title">Real-Time Fleet &amp;amp; Freight Tracking Portals</h3>
        <p class="srv-card-desc">Live telematics data ingestion, interactive map visualizations, and automated dispatch management for logistics providers.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">60% Reduction in Dispatch Friction</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
          <span class="srv-industry-tag">PROFESSIONAL CONSULTING</span>
        </div>
        <h3 class="srv-card-title">High-Converting Corporate Digital Architectures</h3>
        <p class="srv-card-desc">Sub-second digital platforms with integrated schema markup, dynamic case studies, and consultative proposal funnels.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">+140% Qualified Inbound Proposal Inquiries</strong>
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
        Common Questions About <span class="text-brand">Web &amp; Custom Software Development</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">Why do you engineer custom web applications using modern PHP 8+ instead of heavy frameworks?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>Modern PHP 8+ is strictly typed, extraordinarily fast, and powers over 75% of the web including Wikipedia and Slack. By avoiding heavy framework bloat, we deliver sub-second response times, virtually eliminate dependency security vulnerabilities, and ensure your software remains easy to maintain for a decade with zero technical debt.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How do you guarantee that our website will achieve sub-second load times?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We engineer performance into every layer: server-rendered HTML with zero hydration lag, optimized database queries with composite indexes, asset minification, webp image formats, and global Cloudflare edge caching. We measure against Google Lighthouse and Core Web Vitals continuously.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Do you build custom client portals that integrate with our existing database or CRM?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We specialize in building secure authenticated client portals that connect directly to your existing MariaDB, PostgreSQL, HubSpot, Salesforce, or custom ERP systems via secure REST APIs and webhooks.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Who owns the source code and intellectual property upon project completion?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You do—100%. Upon final project delivery, all source code, database schemas, documentation, and assets are fully transferred to your ownership with no ongoing software licensing fees or proprietary agency lock-in.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">How do you handle security vulnerabilities such as SQL injection and cross-site scripting?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We adhere strictly to OWASP Top 10 security standards. All database communication uses parameterized PDO prepared statements, user input is strictly validated and escaped, and we implement strict Content Security Policies (CSP) and HTTP security headers.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">Can you modernize our existing legacy application without starting over from scratch?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We frequently conduct legacy modernization sprints where we upgrade older PHP codebases to PHP 8+, optimize database schemas, eliminate slow queries, and modernize frontend interfaces incrementally without business downtime.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">How long does an enterprise web development project take from kickoff to launch?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>A high-performance corporate website typically takes 4 to 6 weeks. A complex custom web application, SaaS platform, or client portal typically spans 8 to 12 weeks depending on the breadth of custom business logic and integrations.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">What happens after launch? Do you provide ongoing maintenance and support?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We offer structured Service Level Agreement (SLA) retainer plans that include 24/7 uptime monitoring, security patching, automated nightly database backups, performance audits, and prioritized access to senior engineering leads.</p>
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
          Ready to Build Fast, Resilient <span class="text-brand">Web Software?</span>
        </h2>
            <p class="srv-cta-lead">
          Schedule a technical architectural consultation. Our senior software architects will inspect your current application, review code requirements, and deliver a detailed engineering roadmap.
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
                  <label class="srv-form-label" for="quick_name_web-development.php">Your Full Name</label>
                  <input type="text" id="quick_name_web-development.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_web-development.php">Work Email</label>
                  <input type="email" id="quick_email_web-development.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_web-development.php">Company / Domain</label>
                  <input type="text" id="quick_company_web-development.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_web-development.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_web-development.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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
