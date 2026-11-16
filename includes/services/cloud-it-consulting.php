<?php
/**
 * BusinessDoctor Service Detail View — Cloud Solutions & IT Consulting
 * Discipline 06 — Full-Width Modern Enterprise Landing Page
 * Brand Color: #06B5F9
 */

declare(strict_types=1);

$serviceName = 'Cloud Solutions & IT Consulting';
$serviceSlug = 'cloud-it-consulting';
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
          <span>ENTERPRISE CLOUD ARCHITECTURE &amp; DEVOPS</span>
        </div>
        <h1 class="srv-hero-title">
          Engineering Resilient <br><span class="text-brand">Enterprise Cloud Architecture &amp; DevOps</span>
        </h1>
        <p class="srv-hero-desc">
          We architect mission-critical cloud infrastructure on AWS, Google Cloud, and Azure: zero-downtime Kubernetes CI/CD pipelines, automated disaster recovery, SOC 2 compliance security hardening, and FinOps cloud cost reduction.
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
            <span class="srv-hero-stat-val">99.99%</span>
            <span class="srv-hero-stat-lbl">Uptime SLA Guarantee</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">-40%</span>
            <span class="srv-hero-stat-lbl">Average Cloud Spend Reduction</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">0 Downtime</span>
            <span class="srv-hero-stat-lbl">Blue/Green Deployments</span>
          </div>
          <div class="srv-hero-stat-item">
            <span class="srv-hero-stat-val">&amp;lt; 15m</span>
            <span class="srv-hero-stat-lbl">Disaster Recovery RTO</span>
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
  <text x="90" y="24" fill="#8FA3B8" font-family="monospace" font-size="11" font-weight="600">businessdoctor.cloud :: enterprise-devops-telemetry.v2</text>

  <!-- Cloud Top Node -->
  <rect x="50" y="65" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="70" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// HIGH AVAILABILITY SLA</text>
  <text x="70" y="120" fill="#34D399" font-family="sans-serif" font-size="24" font-weight="900">99.99%</text>
  <text x="170" y="120" fill="#B8C7D9" font-family="monospace" font-size="11">Multi-Region Failover</text>

  <rect x="320" y="65" width="230" height="90" rx="8" fill="#0D2644" stroke="#06B5F9" stroke-width="1.5" stroke-opacity="0.4"/>
  <text x="340" y="90" fill="#06B5F9" font-family="monospace" font-size="11" font-weight="bold">// INFRASTRUCTURE COST</text>
  <text x="340" y="120" fill="#06B5F9" font-family="sans-serif" font-size="24" font-weight="900">-42.5%</text>
  <text x="440" y="120" fill="#B8C7D9" font-family="monospace" font-size="11">FinOps Optimization</text>

  <!-- Infrastructure Architecture Diagram -->
  <rect x="50" y="175" width="500" height="230" rx="10" fill="#0A2038" stroke="#06B5F9" stroke-width="1" stroke-opacity="0.3"/>
  <text x="70" y="200" fill="#F5F7FA" font-family="sans-serif" font-size="13" font-weight="bold">Zero-Trust Cloud Mesh &amp; Kubernetes CI/CD</text>
  <text x="420" y="200" fill="#06B5F9" font-family="monospace" font-size="11">SYS STATUS: OK</text>

  <!-- Cloud Architecture Nodes -->
  <rect x="70" y="225" width="120" height="65" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="80" y="245" fill="#06B5F9" font-family="monospace" font-size="10" font-weight="bold">EDGE INGRESS</text>
  <text x="80" y="265" fill="#F5F7FA" font-family="sans-serif" font-size="11" font-weight="bold">Cloudflare WAF</text>
  <text x="80" y="280" fill="#34D399" font-family="monospace" font-size="9">DDoS Shield &bull; 0ms</text>

  <rect x="240" y="225" width="120" height="65" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="250" y="245" fill="#06B5F9" font-family="monospace" font-size="10" font-weight="bold">COMPUTE CLUSTER</text>
  <text x="250" y="265" fill="#F5F7FA" font-family="sans-serif" font-size="11" font-weight="bold">AWS EKS / Docker</text>
  <text x="250" y="280" fill="#34D399" font-family="monospace" font-size="9">Auto-Scale 2&ndash;50</text>

  <rect x="410" y="225" width="120" height="65" rx="6" fill="#0D2644" stroke="#06B5F9" stroke-opacity="0.3"/>
  <text x="420" y="245" fill="#06B5F9" font-family="monospace" font-size="10" font-weight="bold">STORAGE &amp; DB</text>
  <text x="420" y="265" fill="#F5F7FA" font-family="sans-serif" font-size="11" font-weight="bold">Postgres / Redis</text>
  <text x="420" y="280" fill="#34D399" font-family="monospace" font-size="9">Automated Backup</text>

  <!-- Connectors -->
  <line x1="190" y1="257" x2="240" y2="257" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>
  <line x1="360" y1="257" x2="410" y2="257" stroke="#06B5F9" stroke-width="2" stroke-dasharray="3 3"/>

  <!-- Telemetry Row Below -->
  <rect x="70" y="310" width="460" height="75" rx="6" fill="#071A2C" stroke="#06B5F9" stroke-opacity="0.2"/>
  <text x="85" y="332" fill="#8FA3B8" font-family="monospace" font-size="10">&gt; terraform apply &bull; 0 errors &bull; SOC 2 Type II Certified</text>
  <text x="85" y="352" fill="#34D399" font-family="monospace" font-size="11">&bull; CPU Load: 18.2% &bull; Memory: 42.1% &bull; Latency: 12ms</text>
  <text x="85" y="372" fill="#B8C7D9" font-family="monospace" font-size="10">&bull; Last Automated Snapshot: 4 mins ago &bull; RPO: &lt; 5m | RTO: &lt; 15m</text>
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
            <span class="srv-takeaway-val">99.99%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Uptime SLA Guarantee</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">-40%</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Average Cloud Spend Reduction</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">0 Downtime</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Blue/Green Deployments</span>
          <p class="srv-takeaway-desc">Verified benchmark engineered across production client deployments.</p>
        </div>
        <div class="srv-takeaway-card">
          <div class="srv-takeaway-top">
            <span class="srv-takeaway-val">&amp;lt; 15m</span>
            <div class="srv-takeaway-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
          </div>
          <span class="srv-takeaway-label">Disaster Recovery RTO</span>
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
          <span>INFRASTRUCTURE ENGINEERING PHILOSOPHY</span>
        </div>
        <h2 class="srv-section-title">
          Mission-Critical Cloud Systems Built for <span class="text-brand">Extreme Stability</span>
        </h2>
        <p class="srv-section-subtitle mb-4">
          When enterprise cloud infrastructure crashes or slows down during peak commercial demand, revenue evaporates, brand reputation plummets, and security vulnerabilities emerge.
        </p>
        <p class="srv-card-desc mb-4">
          At BusinessDoctor, we engineer cloud systems using Infrastructure as Code (Terraform), containerized microservices (Docker &amp; Kubernetes), and automated disaster recovery. We eliminate fragile manual server setups and build resilient, automated cloud foundations.
        </p>

        <div class="srv-feature-list mb-4">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Infrastructure as Code (Terraform):</strong> 
              <span class="text-secondary">Repeatable, version-controlled cloud environments that eliminate human configuration errors.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">Zero-Downtime CI/CD Automation:</strong> 
              <span class="text-secondary">Automated GitHub Actions pipelines deploying multiple times daily with instant rollback safeguards.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">FinOps Cloud Cost Optimization:</strong> 
              <span class="text-secondary">Eliminating zombie cloud instances, right-sizing compute nodes, and slashing AWS/GCP bills by 30-50%.</span>
            </div>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <div>
              <strong class="text-white">SOC 2 &amp; ISO 27001 Security Hardening:</strong> 
              <span class="text-secondary">Zero-trust network meshes, end-to-end encryption at rest/in transit, and 24/7 SIEM monitoring.</span>
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
            <span class="srv-hud-title">CLOUD OPERATIONS CENTER</span>
            <span class="srv-hud-status">
              <span class="srv-hud-pulse"></span>
              SYSTEMS HEALTHY (100%)
            </span>
          </div>
          <div class="srv-hud-body">
            <p class="srv-card-desc mb-4">
              Real-time telemetry tracking global cluster CPU utilization, network latency, and container health.
            </p>
            <div class="srv-hud-metrics">
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">99.99%</div>
                <div class="srv-hud-metric-label">Cluster Uptime</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">12ms</div>
                <div class="srv-hud-metric-label">Edge Latency</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">0.0%</div>
                <div class="srv-hud-metric-label">Packet Loss</div>
              </div>
              <div class="srv-hud-metric-box">
                <div class="srv-hud-metric-num">$14.2k</div>
                <div class="srv-hud-metric-label">Monthly FinOps Savings</div>
              </div>
            </div>
            <div class="srv-hud-tag-list mt-3">
              <span class="srv-tool-badge">AWS EKS</span>
              <span class="srv-tool-badge">Terraform</span>
              <span class="srv-tool-badge">Docker</span>
              <span class="srv-tool-badge">Google Cloud</span>
              <span class="srv-tool-badge">Kubernetes</span>
              <span class="srv-tool-badge">Cloudflare WAF</span>
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
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></div>
        </div>
        <h3 class="srv-card-title">AWS, GCP &amp; Azure Architecture Design</h3>
        <p class="srv-card-desc">Custom enterprise cloud blueprints engineered for high availability, fault tolerance, and seamless multi-region auto-scaling.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Multi-Availability Zone Redundancy</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Elastic Container Service (ECS) &amp; EKS</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Serverless &amp; Microservice Hybrid Architectures</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Edge Content Delivery (Cloudflare / CloudFront)</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Guarantees 99.99% uptime and sub-second global response times.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('AWS, GCP & Azure Architecture Design')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        </div>
        <h3 class="srv-card-title">DevOps Automation &amp; CI/CD Pipelines</h3>
        <p class="srv-card-desc">Turn your release cycles into an effortless, automated process with modern automated testing, container builds, and zero-downtime deployments.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>GitHub Actions &amp; GitLab CI Workflows</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Blue/Green &amp; Canary Deployment Logic</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Unit &amp; Integration Test Gating</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Instant One-Click Rollback Capabilities</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Ship product features multiple times daily with zero risk of customer disruption.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('DevOps Automation & CI/CD Pipelines')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        </div>
        <h3 class="srv-card-title">FinOps Cloud Cost Optimization</h3>
        <p class="srv-card-desc">Rigorous algorithmic analysis of your cloud resource utilization to identify waste and dramatically slash ongoing monthly infrastructure bills.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Idle &amp; Zombie Resource Remediation</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Savings Plans &amp; Reserved Instance Modeling</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Kubernetes Cluster Auto-Scaling &amp; Spot Fleets</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Detailed Departmental Cost Allocation Tagging</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Reduces monthly cloud bills by an average of 30% to 50% without sacrificing speed.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('FinOps Cloud Cost Optimization')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        </div>
        <h3 class="srv-card-title">Cybersecurity Hardening &amp; SOC 2 Compliance</h3>
        <p class="srv-card-desc">Comprehensive infrastructure security audits and implementation to help your organization achieve SOC 2 Type II, ISO 27001, and HIPAA readiness.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Zero-Trust Identity &amp; Access Management (IAM)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Private VPC Subnets &amp; Bastion Host Ingress</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>End-to-End Encryption (At-Rest &amp; In-Transit)</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated Static Code &amp; Container Security Scans</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Pass enterprise security procurement reviews and win major institutional clients.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Cybersecurity Hardening & SOC 2 Compliance')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        </div>
        <h3 class="srv-card-title">Database Performance Tuning &amp; Scaling</h3>
        <p class="srv-card-desc">Deep architectural remediation for PostgreSQL, MySQL, and Redis: query indexing, connection pooling, read replicas, and sharding.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Slow Query Optimization &amp; Index Engineering</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Read Replica Load Balancing &amp; Sharding</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Redis High-Speed Caching Layers</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Zero-Downtime Database Version Migrations</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Eliminates database bottlenecks and accelerates application response times.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('Database Performance Tuning & Scaling')) ?>" class="srv-link-action">
            <span>Inquire About This Service</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-card-icon-wrap">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        </div>
        <h3 class="srv-card-title">24/7 SRE Monitoring &amp; Disaster Recovery</h3>
        <p class="srv-card-desc">Round-the-clock telemetry, automated synthetic health checks, and disaster recovery architectures with aggressive RTO and RPO targets.</p>
        <div class="srv-feature-list mb-3">
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Prometheus &amp; Grafana Telemetry Dashboards</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Automated PagerDuty Incident Escalation</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Cross-Region Automated Database Snapshots</span>
          </div>
          <div class="srv-feature-item">
            <svg class="srv-check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Sub-15 Minute Disaster Recovery Failover Drills</span>
          </div>
        </div>
        <div class="srv-benefit-badge">
          <span class="text-secondary">BUSINESS VALUE:</span> 
          <strong class="text-white">Ensures your technical team sleeps soundly knowing critical systems are monitored 24/7.</strong>
        </div>
        <div class="pt-3">
          <a href="<?= appUrl('contact.php?service=' . urlencode($serviceName) . '&capability=' . urlencode('24/7 SRE Monitoring & Disaster Recovery')) ?>" class="srv-link-action">
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
        <h3 class="srv-process-title">Infrastructure Discovery &amp; Security Audit</h3>
        <p class="srv-card-desc mb-3">We perform exhaustive reviews of your existing cloud configurations, security IAM roles, billing trends, and deployment bottlenecks.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Complete Cloud Architecture Map</li>
            <li>Security &amp; Compliance Vulnerability Audit</li>
            <li>FinOps Cost Reduction Opportunity Report</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="02">
        <div class="srv-phase-badge">PHASE 02 &bull; WEEKS 2–3</div>
        <h3 class="srv-process-title">Architecture Blueprint &amp; IaC Formulation</h3>
        <p class="srv-card-desc mb-3">We author production-grade Terraform manifests, specify VPC topologies, and model containerized microservice architectures.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Terraform Infrastructure as Code Repo</li>
            <li>Network VPC &amp; Security Group Blueprints</li>
            <li>Container Orchestration Specs (Docker/K8s)</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="03">
        <div class="srv-phase-badge">PHASE 03 &bull; WEEKS 3–5</div>
        <h3 class="srv-process-title">Staging Cluster &amp; CI/CD Pipeline Buildout</h3>
        <p class="srv-card-desc mb-3">We provision isolated staging environments, establish automated GitHub Actions workflows, and configure secrets management.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Automated GitHub Actions CI/CD Pipeline</li>
            <li>Isolated Staging Testing Environment</li>
            <li>AWS Secrets Manager &amp; Vault Integration</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="04">
        <div class="srv-phase-badge">PHASE 04 &bull; WEEKS 5–6</div>
        <h3 class="srv-process-title">Load Testing &amp; Disaster Recovery Verification</h3>
        <p class="srv-card-desc mb-3">We simulate extreme traffic surges and execute simulated regional failover drills to verify resilience under pressure.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>10x Traffic Load Test Benchmark</li>
            <li>Disaster Recovery RTO/RPO Drill Report</li>
            <li>Automated Rollback Verification</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="05">
        <div class="srv-phase-badge">PHASE 05 &bull; WEEKS 6–7</div>
        <h3 class="srv-process-title">Zero-Downtime Production Cutover</h3>
        <p class="srv-card-desc mb-3">We execute a seamless blue/green cutover during low-traffic windows, routing DNS traffic without dropping a single active customer session.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>Zero-Downtime Production Migration</li>
            <li>Live DNS Cutover Verification</li>
            <li>Production Performance Validation</li>
          </ul>
        </div>
      </div>
      <div class="srv-process-card" data-step="06">
        <div class="srv-phase-badge">PHASE 06 &bull; ONGOING</div>
        <h3 class="srv-process-title">24/7 SRE Telemetry &amp; Continuous FinOps</h3>
        <p class="srv-card-desc mb-3">We monitor system vitals 24/7, conduct monthly FinOps spend optimizations, and support your engineering team with senior DevOps leads.</p>
        <div class="srv-process-deliverable">
          <span class="srv-deliverable-lbl">KEY DELIVERABLES:</span>
          <ul class="srv-bullet-list">
            <li>24/7 Grafana &amp; Datadog Monitoring</li>
            <li>Monthly Cloud Cost Optimization Reviews</li>
            <li>Quarterly Security Patching Audits</li>
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
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg></div>
        <h3 class="srv-card-title">Certified Senior Cloud Architects</h3>
        <p class="srv-card-desc">Your infrastructure is designed and maintained exclusively by senior AWS/GCP certified solutions architects with 10+ years of high-scale enterprise experience.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Certified</span>
          <span class="text-muted text-sm ms-2">AWS &amp; GCP Architects</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <h3 class="srv-card-title">Guaranteed FinOps ROI</h3>
        <p class="srv-card-desc">Our cloud optimization audits frequently pay for themselves within the first 60 days through direct, permanent reductions in monthly cloud hosting bills.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">30–50%</span>
          <span class="text-muted text-sm ms-2">Average Cost Reduction</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3 class="srv-card-title">Strict Zero-Trust Security Standard</h3>
        <p class="srv-card-desc">We never take shortcuts with security. Every server, database, and API endpoint is locked behind private subnets, bastion gates, and automated scanners.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Zero-Trust</span>
          <span class="text-muted text-sm ms-2">Enterprise Security</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
        <h3 class="srv-card-title">100% Infrastructure as Code</h3>
        <p class="srv-card-desc">No manual clicking inside web consoles. Everything is authored in version-controlled Terraform code that your team fully inspects and owns.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Terraform</span>
          <span class="text-muted text-sm ms-2">Version-Controlled Code</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
        <h3 class="srv-card-title">Zero Vendor Lock-In Philosophy</h3>
        <p class="srv-card-desc">We build using open standards (Docker, Kubernetes, Linux, Terraform) so your business can migrate between AWS, GCP, or bare-metal at will.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">Open Stacks</span>
          <span class="text-muted text-sm ms-2">No Proprietary Lock-In</span>
        </div>
      </div>
      <div class="srv-card">
        <div class="srv-icon-box mb-3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <h3 class="srv-card-title">Rapid Under-15m Disaster Recovery</h3>
        <p class="srv-card-desc">We don’t just hope backups work; we routinely rehearse point-in-time database restoration to guarantee rapid recovery from any catastrophe.</p>
        <div class="srv-metric-highlight mt-2">
          <span class="text-brand font-mono font-bold">&lt; 15m</span>
          <span class="text-muted text-sm ms-2">Verified Recovery Time</span>
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
        <h3 class="srv-tech-cat-title">Cloud Providers &amp; Compute</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Amazon Web Services (AWS)</span>
            <span class="srv-tool-role">EC2, ECS, EKS, Lambda, S3</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Google Cloud Platform (GCP)</span>
            <span class="srv-tool-role">Compute Engine, GKE, Cloud Run</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Microsoft Azure</span>
            <span class="srv-tool-role">Virtual Machines &amp; AKS Clusters</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Cloudflare Workers</span>
            <span class="srv-tool-role">Global Serverless Edge Execution</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Infrastructure as Code &amp; CI/CD</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">HashiCorp Terraform</span>
            <span class="srv-tool-role">Multi-Cloud Infrastructure as Code</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Docker &amp; Kubernetes</span>
            <span class="srv-tool-role">Containerization &amp; Orchestration</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">GitHub Actions</span>
            <span class="srv-tool-role">Automated CI/CD Build Pipelines</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Helm &amp; ArgoCD</span>
            <span class="srv-tool-role">Declarative GitOps Delivery</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Security &amp; Identity Management</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">HashiCorp Vault</span>
            <span class="srv-tool-role">Centralized Secrets Management</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">AWS IAM &amp; GuardDuty</span>
            <span class="srv-tool-role">Intelligent Threat Detection</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Cloudflare Enterprise WAF</span>
            <span class="srv-tool-role">DDoS Mitigation &amp; Edge Defense</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">SonarQube / Snyk</span>
            <span class="srv-tool-role">Automated Dependency &amp; Code Scans</span>
          </div>
        </div>
      </div>
      <div class="srv-tech-category">
        <h3 class="srv-tech-cat-title">Telemetry &amp; Observability</h3>
        <div class="srv-tech-tags">
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Datadog / Prometheus</span>
            <span class="srv-tool-role">Real-Time Metrics Collection</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Grafana Enterprise</span>
            <span class="srv-tool-role">Unified SRE System Dashboards</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">Elasticsearch / OpenSearch</span>
            <span class="srv-tool-role">Centralized Log Aggregation</span>
          </div>
          <div class="srv-tool-item">
            <span class="srv-tool-dot"></span>
            <span class="srv-tool-name">PagerDuty</span>
            <span class="srv-tool-role">24/7 Automated Incident Routing</span>
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
          <span class="srv-industry-tag">FINTECH &amp; PAYMENTS</span>
        </div>
        <h3 class="srv-card-title">PCI-DSS Compliant Payment Mesh</h3>
        <p class="srv-card-desc">Multi-region architectures with encrypted tokenization vaults and audited logging meeting international payment security standards.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Zero Security Audit Non-Conformances</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <span class="srv-industry-tag">HEALTHCARE &amp; HEALTH-TECH</span>
        </div>
        <h3 class="srv-card-title">HIPAA-Compliant Patient Data Storage</h3>
        <p class="srv-card-desc">Zero-trust infrastructure with encrypted database clusters, strict role-based access controls, and immutable audit trails.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">100% HIPAA &amp; SOC 2 Compliance Readiness</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></div>
          <span class="srv-industry-tag">E-COMMERCE &amp; RETAIL SCALING</span>
        </div>
        <h3 class="srv-card-title">Auto-Scaling Flash Sale Infrastructure</h3>
        <p class="srv-card-desc">Edge-cached product catalogs and Redis-backed shopping carts that automatically scale to absorb 100,000 concurrent shoppers during promotions.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">99.99% Uptime During Holiday Flash Sales</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></div>
          <span class="srv-industry-tag">B2B SAAS ENTERPRISE</span>
        </div>
        <h3 class="srv-card-title">Multi-Tenant Kubernetes Architecture</h3>
        <p class="srv-card-desc">Isolated database schemas and containerized tenant pods providing strict enterprise customer data segregation.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Enabled Enterprise Sales to Fortune 500 Clients</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></div>
          <span class="srv-industry-tag">LOGISTICS &amp; TELEMATICS</span>
        </div>
        <h3 class="srv-card-title">High-Throughput IoT Data Ingestion</h3>
        <p class="srv-card-desc">Serverless message queues handling millions of daily GPS and sensor events with sub-50ms ingestion latency.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Slashing Server Cost by 60% with Serverless Pipelines</strong>
        </div>
      </div>
      <div class="srv-industry-card">
        <div class="srv-industry-header">
          <div class="srv-icon-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
          <span class="srv-industry-tag">PROFESSIONAL SERVICES &amp; LAW</span>
        </div>
        <h3 class="srv-card-title">Secure Multi-Cloud Document Vaults</h3>
        <p class="srv-card-desc">Encrypted cloud document repositories with granular identity permissions and disaster recovery backups.</p>
        <div class="srv-industry-outcome">
          <span class="srv-deliverable-lbl">PRIMARY BUSINESS OUTCOME:</span>
          <strong class="text-brand">Eliminated In-House Server Failures Entirely</strong>
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
        Common Questions About <span class="text-brand">Cloud Solutions &amp; IT Consulting</span>
      </h2>
      <p class="srv-section-subtitle">
        Everything you need to know about our scope, timeline, engineering standards, communication, and ongoing support.
      </p>
    </div>

    <div class="srv-faq-container">
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="true" aria-controls="faq-ans-0">
          <span class="srv-faq-question">Which cloud provider do you recommend: AWS, Google Cloud, or Microsoft Azure?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-0" class="srv-faq-panel" style="max-height: 500px;">
          <div class="srv-faq-content">
            <p>The ideal provider depends on your existing technology stack, compliance requirements, and business goals. AWS offers the most mature ecosystem of managed services; Google Cloud excels in Kubernetes (GKE), containerization, and data analytics; Microsoft Azure is ideal for enterprise organizations with extensive Active Directory and Microsoft enterprise agreements. We architect with Infrastructure as Code to ensure you are never locked into a single vendor.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-1">
          <span class="srv-faq-question">How can you guarantee zero downtime during a major cloud migration?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-1" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We utilize blue/green and canary deployment architectures. We provision your entire new cloud infrastructure in parallel, synchronize databases in real time, run automated validation test suites, and then shift DNS traffic over gradually. If any unexpected anomaly is detected, traffic shifts back instantly without any user disruption.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-2">
          <span class="srv-faq-question">What is FinOps and how do you reduce our monthly cloud bill?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-2" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>FinOps is the practice of continuous cloud financial management. We analyze your historical utilization metrics to eliminate zombie volumes, convert on-demand instances to Reserved or Savings Plans, right-size compute resources, deploy auto-scaling, and configure lifecycle rules on storage buckets. This typically yields a 30% to 50% permanent cost reduction.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-3">
          <span class="srv-faq-question">Will our internal engineering team be able to maintain the cloud infrastructure?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-3" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. Because we author 100% of infrastructure using standard Terraform and Docker code, everything is transparent, version-controlled, and thoroughly documented. We conduct hands-on training sessions with your development leads and provide complete architectural documentation.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-4">
          <span class="srv-faq-question">What is the difference between RTO and RPO in disaster recovery?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-4" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>RTO (Recovery Time Objective) is the maximum acceptable duration of time your systems can be down following a failure. RPO (Recovery Point Objective) is the maximum acceptable age of files or data that must be recovered from backup storage for normal operations to resume. We design architectures with sub-15 minute RTO and sub-5 minute RPO standards.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-5">
          <span class="srv-faq-question">How do you handle secrets, API keys, and credentials in the cloud?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-5" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>We strictly ban hardcoding credentials in application repositories. We implement enterprise secrets management systems such as AWS Secrets Manager or HashiCorp Vault with automated secret rotation, encrypted storage, and least-privilege IAM policy enforcement.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-6">
          <span class="srv-faq-question">Can you help us prepare for SOC 2 Type II or HIPAA audits?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-6" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We configure private VPC topologies, enforce end-to-end encryption (AES-256 at rest and TLS 1.3 in transit), configure centralized immutable log aggregation, implement multi-factor authentication, and provide architectural evidence required by certified compliance auditors.</p>
          </div>
        </div>
      </div>
      <div class="srv-faq-item">
        <button type="button" class="srv-faq-btn" aria-expanded="false" aria-controls="faq-ans-7">
          <span class="srv-faq-question">Do you provide ongoing 24/7 emergency support after the migration is complete?</span>
          <span class="srv-faq-icon" aria-hidden="true">+</span>
        </button>
        <div id="faq-ans-7" class="srv-faq-panel">
          <div class="srv-faq-content">
            <p>Yes. We offer ongoing Site Reliability Engineering (SRE) retainer plans that include 24/7 automated synthetic monitoring, on-call emergency response, proactive security patching, and regular architecture optimization reviews.</p>
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
          Ready to Build Resilient, Cost-Effective <span class="text-brand">Enterprise Cloud Systems?</span>
        </h2>
            <p class="srv-cta-lead">
          Schedule an architecture diagnostic session. Our senior cloud solutions architects will review your current infrastructure, evaluate security posture, and map a FinOps cost reduction plan.
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
                  <label class="srv-form-label" for="quick_name_cloud-it-consulting.php">Your Full Name</label>
                  <input type="text" id="quick_name_cloud-it-consulting.php" name="name" required class="srv-form-input" placeholder="e.g. Sarah Jenkins">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_email_cloud-it-consulting.php">Work Email</label>
                  <input type="email" id="quick_email_cloud-it-consulting.php" name="email" required class="srv-form-input" placeholder="e.g. sarah@enterprise.com">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_company_cloud-it-consulting.php">Company / Domain</label>
                  <input type="text" id="quick_company_cloud-it-consulting.php" name="company" class="srv-form-input" placeholder="e.g. Enterprise Corp (enterprise.com)">
                </div>
                <div class="srv-form-group">
                  <label class="srv-form-label" for="quick_notes_cloud-it-consulting.php">Project Scope &amp; Objectives</label>
                  <textarea id="quick_notes_cloud-it-consulting.php" name="notes" rows="2" class="srv-form-textarea" placeholder="Briefly describe your timeline, goals, or current technical bottlenecks..."></textarea>
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
