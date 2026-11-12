<?php
/**
 * BusinessDoctor Service Detail View — Digital Marketing & SEO
 * Discipline 02 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Digital Marketing & SEO';
$serviceSlug = 'digital-marketing-seo';
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
          <span>PERFORMANCE MARKETING &amp; TECHNICAL SEO</span>
        </div>
        <h1 class="srv-hero-title">
          Engineering High-ROI <br><span class="text-brand">Digital Marketing &amp; Technical SEO</span>
        </h1>
        <p class="srv-hero-desc">
          We replace vanity agency metrics with revenue-focused digital growth: programmatic technical SEO, high-intent Google Search and Meta Ads, server-side attribution, and continuous conversion rate optimization.
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
            <span class="srv-hero-stat-val">4.2x</span>
            <span class="srv-hero-stat-lbl">Average Client ROAS</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">-38%</span>
            <span class="srv-hero-stat-lbl">Customer Acquisition Cost</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">+215%</span>
            <span class="srv-hero-stat-lbl">Organic Search Traffic</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">100%</span>
            <span class="srv-hero-stat-lbl">First-Party Tracking SLA</span>
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
  <circle cx="28" cy="20" r="5" fill="#F87171"/>
  <circle cx="46" cy="20" r="5" fill="#FBBF24"/>
  <circle cx="64" cy="20" r="5" fill="#34D399"/>
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.growth :: paid-ads-organic-telemetry.v2</text>
  
  <!-- Metrics Cards -->
  <rect x="40" y="65" width="245" height="85" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="55" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// PAID MEDIA ROAS</text>
  <text x="55" y="120" fill="#34D399" font-family="sans-serif" font-size="24" font-weight="900">4.82x</text>
  <text x="135" y="120" fill="#B8C7D9" font-family="monospace" font-size="11">Target: &gt; 3.50x &bull; +42% YoY</text>

  <rect x="315" y="65" width="245" height="85" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="330" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// BLENDED CAC REDUCTION</text>
  <text x="330" y="120" fill="#06B5F9" font-family="sans-serif" font-size="24" font-weight="900">-38.4%</text>
  <text x="430" y="120" fill="#B8C7D9" font-family="monospace" font-size="11">CPL &bull; Qualified Intent</text>

  <!-- Interactive Chart Area -->
  <rect x="40" y="170" width="520" height="235" rx="10" fill="#0A2038" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.25"/>
  <text x="60" y="200" fill="#F5F7FA" font-family="sans-serif" font-size="13" font-weight="bold">Conversion Funnel &amp; Revenue Velocity</text>
  <text x="420" y="200" fill="#06B5F9" font-family="monospace" font-size="11">LIVE TELEMETRY</text>
  
  <!-- Curve Trend -->
  <path d="M60 340 C 140 320, 200 280, 280 250 C 360 220, 440 180, 520 150" stroke="#06B5F9" stroke-width="3.5" fill="none"/>
  <path d="M60 340 C 140 320, 200 280, 280 250 C 360 220, 440 180, 520 150 L 520 370 L 60 370 Z" fill="url(#grad1)" opacity="0.25"/>
  
  <!-- Secondary dashed baseline -->
  <path d="M60 350 C 140 350, 280 340, 520 330" stroke="#8FA3B8" stroke-width="2" stroke-dasharray="4 4" fill="none"/>
  <text x="360" y="325" fill="#8FA3B8" font-family="monospace" font-size="10">Legacy Baseline</text>

  <!-- Data Points -->
  <circle cx="280" cy="250" r="5" fill="#06B5F9" stroke="#ffffff" stroke-width="2"/>
  <circle cx="520" cy="150" r="6" fill="#34D399" stroke="#ffffff" stroke-width="2"/>
  <text x="440" y="140" fill="#34D399" font-family="monospace" font-size="12" font-weight="bold">+148% REV</text>
  
  <defs>
    <linearGradient id="grad1" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0%" stop-color="#06B5F9"/>
      <stop offset="100%" stop-color="#071A2C" stop-opacity="0"/>
    </linearGradient>
  </defs>
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
            <span class="srv-takeaway-val">4.2x</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Average Client ROAS</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">-38%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Customer Acquisition Cost</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">+215%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Organic Search Traffic</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">100%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">First-Party Tracking SLA</span>
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
          <span>DATA-DRIVEN GROWTH PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Transforming Ad Spend into <span class="text-brand">Predictable Revenue Pipelines</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          Most marketing agencies burn budgets on impressions, clicks, and generic blog posts that never generate qualified business pipeline. At BusinessDoctor, we treat digital marketing as an engineering discipline rooted in conversion telemetry and algorithmic precision.
        </p>
        <p class="srv-card-desc mb-4">
          Whether fixing severe Core Web Vitals crawl budget leaks or architecting multi-touch paid ad funnels across Google and Meta, our campaigns are engineered to maximize client lifetime value and lower customer acquisition cost (CAC).
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Server-Side Attribution (CAPI &amp; GA4):</strong> 
              <span class="text-secondary">Bypassing iOS 14+ cookie blocking with resilient server-to-server event tracking.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Technical Crawl &amp; Semantic SEO:</strong> 
              <span class="text-secondary">Fixing indexation barriers, internal page link equity, and entity schemas for Googlebot.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">High-Intent Paid Acquisition:</strong> 
              <span class="text-secondary">Laser-targeted Google Search, Performance Max, and Meta retargeting funnels.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Landing Page CRO Sprints:</strong> 
              <span class="text-secondary">Multivariate testing designed to turn paid click traffic into committed paying customers.</span>
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
            <span class="srv-hud-title">GROWTH DIAGNOSTIC ENGINE</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              LIVE CAMPAIGN MONITOR
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time telemetry measuring crawl depth, paid ad auction efficiency, and conversion rate velocity.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">94.8%</div>
                <div class="srv-hud-metric-label">Crawl Efficiency</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">4.6%</div>
                <div class="srv-hud-metric-label">Demo Request Conv</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">$290</div>
                <div class="srv-hud-metric-label">Target CAC Achieved</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.8s</div>
                <div class="srv-hud-metric-label">LCP Page Speed</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">Google Ads</span>
              <span class="srv-tool-badge">Meta CAPI</span>
              <span class="srv-tool-badge">Ahrefs</span>
              <span class="srv-tool-badge">Screaming Frog</span>
              <span class="srv-tool-badge">GA4 Server-Side</span>
              <span class="srv-tool-badge">Looker Studio</span>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Skyrocketing Paid Ad Acquisition Costs</h3>
        <p class="srv-problem-desc">Bidding on generic keywords without strict audience negative exclusions causes ad spend to burn while CPA increases every month.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Shrinking operating margins and unprofitable customer acquisition funnels.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Full restructuring around commercial search intent, smart negative lists, and tight target CPA/ROAS bid guardrails.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Stagnant Organic Ranks &amp; Crawl Budget Leaks</h3>
        <p class="srv-problem-desc">Bloated JavaScript frameworks, duplicate canonical paths, and broken internal links prevent search engine crawlers from indexing high-value pages.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Zero organic search visibility for high-intent transactional buyer keywords.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Comprehensive technical SEO remediation: edge caching, server-rendered HTML, clean schema markup, and crawl depth reduction.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Broken Tracking &amp; Blind Attribution (iOS 14+)</h3>
        <p class="srv-problem-desc">Browser-based third-party cookies lose up to 40% of conversion events, misleading ad algorithms and resulting in misallocated ad spend.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Inability to know which campaigns, ads, or creatives actually generate revenue.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Server-Side Google Tag Manager and Meta Conversions API (CAPI) implementation with 100% first-party data capture.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></div>
        </div>
        <h3 class="srv-problem-title">High Bounce Rates on Poor Landing Pages</h3>
        <p class="srv-problem-desc">Driving expensive traffic to generic homepages with slow load times, confusing messaging, and complex forms kills conversion rates.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Over 85% of paid visitors bounce within 4 seconds without taking any action.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Dedicated high-converting landing pages with sub-second load times, social proof, and streamlined multi-step lead capture.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Unqualified Lead Volume Overwhelming Sales</h3>
        <p class="srv-problem-desc">Marketing teams celebrating vanity form fills while sales teams waste hours filtering out spam, job seekers, and low-budget prospects.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Sales burnout and friction between marketing and revenue teams.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">Lead qualification gating, firmographic enrichment, and algorithmic bid optimization tied directly to CRM closed-won revenue.</p>
        </div>
      </div>
      <div class="srv-problem-card">
        <div class="srv-problem-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        </div>
        <h3 class="srv-problem-title">Agency Hostage &amp; Black Box Reporting</h3>
        <p class="srv-problem-desc">Prior agencies holding ad accounts hostage, hiding ad spend markups, and sending generic PDF reports full of vanity impressions.</p>
        <div class="srv-impact-badge">
          <span class="srv-impact-tag">BUSINESS IMPACT</span>
          <p class="srv-impact-text">Loss of historical campaign learning data and total lack of financial transparency.</p>
        </div>
        <div class="srv-solution-box">
          <span class="srv-solution-tag">BUSINESSDOCTOR FIX</span>
          <p class="srv-solution-text">100% client account ownership, zero spend markups, and transparent live Looker Studio dashboards linked to your CRM.</p>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
        </div>
        <h3 class="srv-card-title">Technical SEO &amp; Crawl Optimization</h3>
        <p class="srv-card-desc">Deep architectural remediation ensuring every high-priority page is crawled, indexed, and recognized as authoritative by search engines.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Core Web Vitals Optimization</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Server-Side Rendering &amp; Edge Caching</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Entity &amp; Knowledge Graph Schema</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Internal Link Equity Distribution</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Rank for competitive high-intent terms without ongoing ad spend.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Technical SEO & Crawl Optimization')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        </div>
        <h3 class="srv-card-title">High-Intent Google Ads &amp; Search Marketing</h3>
        <p class="srv-card-desc">Precision Google Search, Performance Max, and YouTube campaigns engineered to capture active buyers at the exact moment of commercial intent.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Exact-Match Buyer Keyword Clustering</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Smart Bidding Strategy Calibration</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Negative Keyword Scripts</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Dynamic Ad Copy Customization</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Predictable pipeline of inbound demo requests and qualified sales calls.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('High-Intent Google Ads & Search Marketing')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
        </div>
        <h3 class="srv-card-title">Paid Social &amp; Meta Performance Scaling</h3>
        <p class="srv-card-desc">High-converting video and image ad campaigns across Instagram, Facebook, and LinkedIn designed to generate demand and scale customer volume.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Creative Fatigue Rotation Strategy</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Lookalike &amp; First-Party Custom Audiences</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Meta Advantage+ Bid Structuring</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Cross-Platform Retargeting Sequences</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Lower customer acquisition cost through scalable creative testing.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Paid Social & Meta Performance Scaling')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></div>
        </div>
        <h3 class="srv-card-title">Conversion Rate Optimization (CRO)</h3>
        <p class="srv-card-desc">Systematic qualitative and quantitative experimentation on your key landing pages to maximize the percentage of visitors who become customers.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Heatmap &amp; Session Recording Audits</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>A/B Multivariate Headline &amp; Layout Testing</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Frictionless Mobile-First Form Design</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Psychological Social Proof Placements</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Double your lead volume without increasing your ad spend by a single dollar.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Conversion Rate Optimization (CRO)')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        </div>
        <h3 class="srv-card-title">Server-Side Tracking &amp; Full Attribution</h3>
        <p class="srv-card-desc">First-party data infrastructure that circumvents ad blockers, Safari ITP, and browser restrictions to feed clean conversion signals to ad networks.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Server-Side Google Tag Manager (sGTM)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Meta CAPI &amp; Google Offline Conversions</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Multi-Touch Attribution Modeling</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>CRM Closed-Loop Revenue Sync</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Algorithms optimize for actual revenue instead of low-value vanity clicks.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Server-Side Tracking & Full Attribution')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">Topical Authority &amp; Content Strategy</h3>
        <p class="srv-card-desc">Comprehensive content ecosystems designed around thematic clusters that position your brand as the undeniable authority in your industry.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Semantic Search Intent Mapping</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>In-Depth Research Reports &amp; Whitepapers</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Programmatic Content Architecture</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>High-Authority Backlink Acquisition</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Sustained organic traffic moat that competitors cannot easily duplicate.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Topical Authority & Content Strategy')) ?>" class="srv-link-action">
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
        <h3 class="srv-process-title">Technical Audit &amp; Tracking Calibration</h3>
        <p class="srv-card-desc mb-3">We perform exhaustive crawl audits, review historical ad accounts, and deploy server-side tracking tags to establish an unshakeable data foundation.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Full Technical SEO Health Audit</li>
            <li>Tracking &amp; Pixel Verification Report</li>
            <li>Competitor Keyword &amp; Ad Spy Intelligence</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; WEEKS 2–3</div>
        <h3 class="srv-process-title">Audience Mapping &amp; Campaign Architecture</h3>
        <p class="srv-card-desc mb-3">We build the campaign structures, segment buyer personas, identify high-intent keyword clusters, and draft high-converting ad copy.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Google &amp; Meta Campaign Structure Plan</li>
            <li>Ad Copy &amp; Creative Testing Matrix</li>
            <li>Negative Keyword Blacklists</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; WEEKS 3–4</div>
        <h3 class="srv-process-title">Landing Page CRO &amp; Asset Deployment</h3>
        <p class="srv-card-desc mb-3">We design and engineer bespoke, lightning-fast landing pages with optimized copy, clear value propositions, and frictionless lead capture forms.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>High-Converting Landing Pages</li>
            <li>Mobile-Responsive Form Integrations</li>
            <li>Core Web Vitals Verification</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; WEEKS 4–6</div>
        <h3 class="srv-process-title">Campaign Launch &amp; Initial Bidding Calibration</h3>
        <p class="srv-card-desc mb-3">We launch campaigns under strict manual and algorithmic guardrails, monitoring search query reports and real-time impression share daily.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Controlled Budget Rollout</li>
            <li>Search Query Cleansing &amp; Negative Filtering</li>
            <li>Initial Bid &amp; ROAS Baseline Tuning</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; WEEKS 6–10</div>
        <h3 class="srv-process-title">Multivariate Testing &amp; Creative Iteration</h3>
        <p class="srv-card-desc mb-3">We systematically test new ad creatives, landing page variations, and bid strategies to lower CPA and discover winning combinations.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>A/B Test Statistical Significance Reports</li>
            <li>Creative Fatigue Replacements</li>
            <li>Audience Expansion Scenarios</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; ONGOING</div>
        <h3 class="srv-process-title">Budget Scaling &amp; Executive BI Dashboards</h3>
        <p class="srv-card-desc mb-3">We scale profitable ad sets, optimize for downstream customer LTV, and provide real-time Looker Studio dashboards for executive stakeholders.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Live Looker Studio Executive Dashboard</li>
            <li>Bi-Weekly Strategy Calibration Calls</li>
            <li>Quarterly Growth Roadmap</li>
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
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <h3 class="srv-card-title">Zero Vanity Metrics</h3>
        <p class="srv-card-desc">We don’t celebrate clicks, impressions, or generic traffic. We report on pipeline value, closed revenue, ROAS, and customer acquisition cost.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">ROAS &amp; CAC</span>
          <span class="text-muted text-sm ms-2">Core Success Metrics</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3 class="srv-card-title">100% Account Ownership</h3>
        <p class="srv-card-desc">You own all ad accounts, pixels, tracking tags, and creative assets. If we ever part ways, your historical data and account learnings stay yours.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">100%</span>
          <span class="text-muted text-sm ms-2">Client Owned Assets</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        <h3 class="srv-card-title">In-House Technical Engineering</h3>
        <p class="srv-card-desc">Our marketers work side-by-side with senior developers, enabling us to fix complex site code, Core Web Vitals, and tracking APIs in hours.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">&lt; 24h</span>
          <span class="text-muted text-sm ms-2">Technical Turnaround</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
        <h3 class="srv-card-title">First-Party Server-Side Data</h3>
        <p class="srv-card-desc">We bypass browser tracking restrictions with bulletproof server-side architectures, giving ad algorithms 30% more signal accuracy.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">+30%</span>
          <span class="text-muted text-sm ms-2">More Signal Accuracy</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
        <h3 class="srv-card-title">Senior Media Buyers Only</h3>
        <p class="srv-card-desc">Your campaigns are managed directly by seasoned growth practitioners with multi-million dollar ad spend experience, never handed to junior interns.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">10+ Yrs</span>
          <span class="text-muted text-sm ms-2">Average Strategist Experience</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <h3 class="srv-card-title">Rapid Creative Rotation</h3>
        <p class="srv-card-desc">We combat ad fatigue by continuously producing and testing fresh hooks, high-contrast imagery, and persuasive video angles.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Weekly</span>
          <span class="text-muted text-sm ms-2">Fresh Creative Drops</span>
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
        <span>TECHNOLOGY STACK &amp; TOOLS</span>
      </div>
      <h2 class="srv-section-title">
        Enterprise-Grade Stacks Built for <span class="text-brand">Speed &amp; Security</span>
      </h2>
      <p class="srv-section-subtitle">
        We select battle-tested, high-performance tooling suited for scale, reliability, and seamless ongoing maintenance.
      </p>
    </div>

    <div class="srv-tech-grid">
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Paid Advertising Networks</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Ads</span>
            <span class="srv-tool-role">Search &amp; PMax Bidding</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Meta Ads Manager</span>
            <span class="srv-tool-role">IG &amp; FB Performance</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">LinkedIn Campaign Mgr</span>
            <span class="srv-tool-role">B2B ABM Targeting</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">YouTube Ads</span>
            <span class="srv-tool-role">High-Impact Video Reach</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">SEO &amp; Crawl Intelligence</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Ahrefs</span>
            <span class="srv-tool-role">Backlink &amp; Keyword Intel</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">SEMrush</span>
            <span class="srv-tool-role">Competitive Gap Analysis</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Screaming Frog</span>
            <span class="srv-tool-role">Technical Spider Audits</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Search Console</span>
            <span class="srv-tool-role">Crawl &amp; Indexation Health</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Tracking &amp; Conversion Analytics</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Analytics 4</span>
            <span class="srv-tool-role">Multi-Touch Reporting</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Server-Side GTM</span>
            <span class="srv-tool-role">First-Party Event Pipelines</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Meta CAPI</span>
            <span class="srv-tool-role">Direct Server Conversion API</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Looker Studio</span>
            <span class="srv-tool-role">Real-Time BI Dashboards</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">CRO &amp; Behavioral Insights</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Hotjar</span>
            <span class="srv-tool-role">Heatmaps &amp; Session Replays</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">VWO / Optimizely</span>
            <span class="srv-tool-role">Multivariate Split Testing</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">HubSpot CRM</span>
            <span class="srv-tool-role">Closed-Loop Pipeline Sync</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Unbounce</span>
            <span class="srv-tool-role">Rapid Landing Page Prototyping</span>
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
        <h3 class="srv-card-title">High-Trust Financial Acquisition Funnels</h3>
        <p class="srv-card-desc">Navigating strict regulatory advertising policies while driving verified customer accounts and institutional loan inquiries.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">42% Reduction in Cost Per Funded Account</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <span class="srv-industry-tag">HEALTHCARE &amp; CLINICAL</span>
        </div>
        <h3 class="srv-card-title">HIPAA-Compliant Patient Booking Growth</h3>
        <p class="srv-card-desc">High-intent localized search campaigns paired with privacy-first analytics to book qualified patient consultations.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">3.8x Growth in High-Value Procedure Inquiries</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
          <span class="srv-industry-tag">E-COMMERCE &amp; RETAIL</span>
        </div>
        <h3 class="srv-card-title">Omnichannel Scaling &amp;amp; ROAS Optimization</h3>
        <p class="srv-card-desc">Unified Google Shopping, Meta dynamic product ads, and technical catalog SEO driving high-margin repeat purchases.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">4.6x Blended ROAS Across 12,000+ SKUs</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
          <span class="srv-industry-tag">B2B SAAS &amp; ENTERPRISE</span>
        </div>
        <h3 class="srv-card-title">Account-Based Search &amp;amp; Qualified Demo Funnels</h3>
        <p class="srv-card-desc">Targeting enterprise decision-makers searching for competitor alternatives and specific software capabilities.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">0 CAC with 4.6% Demo-to-Opportunity Conv</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
          <span class="srv-industry-tag">REAL ESTATE &amp; INFRASTRUCTURE</span>
        </div>
        <h3 class="srv-card-title">High-Ticket Investor Lead Generation</h3>
        <p class="srv-card-desc">Geo-targeted search and luxury visual campaigns connecting commercial developers with accredited investors.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">M+ in Verified Inbound Pipeline</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
          <span class="srv-industry-tag">PROFESSIONAL SERVICES</span>
        </div>
        <h3 class="srv-card-title">Topical Authority &amp;amp; Consultative Inbound</h3>
        <p class="srv-card-desc">Dominating high-relevance search queries to generate inbound retainers for corporate law, tax, and consulting firms.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">+180% Organic Inbound Retainer Inquiries</strong>
        </div>
      </div>
          </div>
      <div class="srv-carousel-dots" aria-hidden="true"></div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 9 — CASE STUDIES / RELATED WORK
     ============================================================ -->
<section class="srv-section" id="case-studies">
  <div class="srv-container">
    <div class="srv-section-header text-center">
      <div class="srv-badge">
        <span class="srv-badge-dot"></span>
        <span>PROVEN RESULTS &amp; EVIDENCE</span>
      </div>
      <h2 class="srv-section-title">
        Measurable Client Transformations <span class="text-brand">&amp; Benchmarks</span>
      </h2>
      <p class="srv-section-subtitle">
        Real case studies demonstrating how our architectural engineering and strategic execution drive transformative growth.
      </p>
    </div>

        <div class="srv-carousel-wrapper" data-carousel="case-studies">
      <div class="srv-carousel-nav-header">
        <div class="srv-carousel-kicker">
          <span class="text-brand font-mono font-bold">VERIFIED BENCHMARKS</span>
          <span class="text-muted text-sm ml-2">&bull; Real client outcomes</span>
        </div>
        <div class="srv-carousel-controls">
          <button type="button" class="srv-carousel-btn srv-carousel-prev" aria-label="Previous Case Study"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg></button>
          <button type="button" class="srv-carousel-btn srv-carousel-next" aria-label="Next Case Study"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
      </div>
      <div class="srv-carousel-track">

      <div class="srv-case-card">
        <div class="srv-case-img-wrap">
          <img src="<?= getAssetUrl('uploads/cases/fintech-saas-funnel-architecture-cover.svg') ?>" alt="PayGuard Technologies case study" class="srv-case-img" loading="lazy">
          <span class="srv-case-badge">FinTech &bull; SaaS Funnel Resuscitation</span>
        </div>
        <div class="srv-case-body">
          <div class="srv-case-meta">
            <span class="text-brand font-mono font-bold">PayGuard Technologies</span>
            <span class="text-muted">&bull; 90-Day Sprint</span>
          </div>
          <h3 class="srv-case-title">
            <a href="<?= appUrl('case-study-detail.php?slug=' . urlencode('fintech-saas-funnel-resuscitation')) ?>" class="srv-case-link">
              Lowering B2B Customer Acquisition Cost by 38% via Precision Search &amp; Server-Side CAPI
            </a>
          </h3>
          <p class="srv-card-desc mb-3">
            PayGuard faced escalating ad costs and poor demo conversion rates. We audited their tracking, redesigned the landing page architecture, and restructured their Google Search campaigns.
          </p>

          <div class="srv-case-metrics">
            <div class="srv-case-metric-item">
              <span class="srv-case-metric-val">0</span>
              <span class="srv-case-metric-lbl">Target CAC (from 8)</span>
            </div>
            <div class="srv-case-metric-item">
              <span class="srv-case-metric-val">4.6%</span>
              <span class="srv-case-metric-lbl">Demo Request Conv Rate</span>
            </div>
            <div class="srv-case-metric-item">
              <span class="srv-case-metric-val">+185%</span>
              <span class="srv-case-metric-lbl">Pipeline ARR Generated</span>
            </div>
          </div>

          <div class="srv-case-action pt-3">
            <a href="<?= appUrl('case-study-detail.php?slug=' . urlencode('fintech-saas-funnel-resuscitation')) ?>" class="btn-srv-secondary">
              <span>Read Full Case Study</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
        </div>
      </div>
      <div class="srv-case-card">
        <div class="srv-case-img-wrap">
          <img src="<?= getAssetUrl('uploads/cases/multichannel-marketplace-hub-cover.svg') ?>" alt="Apex Industrial case study" class="srv-case-img" loading="lazy">
          <span class="srv-case-badge">Multi-Channel Retail &bull; Marketplace Dominance</span>
        </div>
        <div class="srv-case-body">
          <div class="srv-case-meta">
            <span class="text-brand font-mono font-bold">Apex Industrial</span>
            <span class="text-muted">&bull; 6-Month Transformation</span>
          </div>
          <h3 class="srv-case-title">
            <a href="<?= appUrl('case-study-detail.php?slug=' . urlencode('multichannel-retail-marketplace-dominance')) ?>" class="srv-case-link">
              Scaling Commercial Catalog Performance with 4.6x Blended ROAS Across Search &amp; Marketplaces
            </a>
          </h3>
          <p class="srv-card-desc mb-3">
            Replaced fragmented marketing agencies with unified search advertising, product feed optimization, and algorithmic bid automation across Google and digital retail marketplaces.
          </p>

          <div class="srv-case-metrics">
            <div class="srv-case-metric-item">
              <span class="srv-case-metric-val">4.6x</span>
              <span class="srv-case-metric-lbl">Average Blended ROAS</span>
            </div>
            <div class="srv-case-metric-item">
              <span class="srv-case-metric-val">94%</span>
              <span class="srv-case-metric-lbl">Buy Box &amp; Ad Impression Share</span>
            </div>
            <div class="srv-case-metric-item">
              <span class="srv-case-metric-val">+230%</span>
              <span class="srv-case-metric-lbl">Top-Line Revenue Growth</span>
            </div>
          </div>

          <div class="srv-case-action pt-3">
            <a href="<?= appUrl('case-study-detail.php?slug=' . urlencode('multichannel-retail-marketplace-dominance')) ?>" class="btn-srv-secondary">
              <span>Read Full Case Study</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
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
        Common Questions About <span class="text-brand">Digital Marketing &amp; SEO</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">How quickly can we expect to see results from technical SEO versus paid advertising?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>Paid advertising campaigns (Google Search, Meta Ads) begin driving qualified traffic and conversion data within 48 to 72 hours of launch. Technical SEO and organic authority building typically demonstrate noticeable indexation and ranking velocity within 60 to 90 days, with exponential traffic and lead growth compounding over 6 to 12 months.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">Do you require long-term lock-in agency contracts?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>No. We operate on transparent monthly retainers with clear deliverables, milestone checkpoints, and 30-day notice terms. We believe in earning our partnership every single month through measurable revenue performance, not legal entrapment.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">Who owns our ad accounts, tracking pixels, and creative assets?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You do—100%. We always work inside your own Google Ads, Meta Business Manager, and Google Cloud accounts. If you ever decide to bring marketing in-house, all campaigns, audiences, historical learning data, and creative files remain your property.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">How do you handle the tracking issues caused by Apple iOS 14+ and Safari ITP?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We engineer a custom first-party server-side tracking architecture using Server-Side Google Tag Manager (sGTM) and Direct Meta Conversions API (CAPI). Events are routed through your own custom domain, bypassing client-side ad blockers and providing ad algorithms with accurate conversion data.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">What monthly advertising budget is required to work with BusinessDoctor?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We typically work with growth-stage and enterprise companies investing at least $3,000 to $50,000+ per month in paid media. This level of spend ensures adequate statistical significance for rapid multivariate testing and algorithmic bidding calibration.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">Do you build the landing pages or do we need our own development team?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We handle everything. Our in-house engineering team designs, writes, and develops high-converting, sub-second landing pages optimized specifically for your target buyer persona and Core Web Vitals.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">How frequently will we receive performance updates and reports?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>You receive continuous, 24/7 access to a custom Looker Studio executive dashboard syncing directly with your ad accounts and CRM. In addition, we conduct bi-weekly strategy calls and deliver comprehensive monthly performance and optimization roadmaps.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">How does your team ensure leads are qualified and not just spam?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We implement automated honeypot spam filters, work email verification, and conditional qualification logic on all lead forms. Furthermore, we feed closed-won offline conversion data from your CRM back to Google and Meta so the bidding algorithms optimize for paying customers, not empty form fills.</p>
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
          Ready to Eliminate Ad Waste &amp; Scale <span class="text-brand">Profitable Acquisition?</span>
        </h2>
            <p class="srv-cta-lead">
          Schedule a comprehensive growth diagnostic call. Our senior marketing architects will audit your current ad accounts, technical SEO health, and conversion funnel.
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
                  <label class="srv-form-label" for="quick_name_digital-marketing-seo.php">Your Full Name</label>
                  <input type="text" id="quick_name_digital-marketing-seo.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_digital-marketing-seo.php">Work Email</label>
                  <input type="email" id="quick_email_digital-marketing-seo.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_digital-marketing-seo.php">Company / Domain</label>
                  <input type="text" id="quick_company_digital-marketing-seo.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_digital-marketing-seo.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_digital-marketing-seo.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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
