<?php
/**
 * BusinessDoctor Free Digital Audit & Project Scope Portal
 * Enterprise IT Solutions & Digital Services Practice
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Free Technical Digital Audit — BusinessDoctor Enterprise IT';
$pageDescription = 'Submit your business website to receive a free performance, SEO, and digital growth audit with a tailored IT project scope from BusinessDoctor.';

$preBottleneck = $_GET['bottleneck'] ?? 'technology';
$preRevenue = $_GET['revenue'] ?? '250k_to_1m';
$preModel = $_GET['model'] ?? 'b2b';
$refDone = $_GET['ref'] ?? null;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>COMPLIMENTARY DIGITAL AUDIT</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.5rem;">
      Technical Architecture &amp; <br><span class="text-gradient-pine">Digital Growth Audit</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      Discover technical bottlenecks, page speed issues, and SEO gaps holding back your online business. Submit your domain to receive real live telemetry analysis and a customized project proposal within 24 hours.
    </p>
  </div>
</section>

<!-- Audit Intake Form Section -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container" style="max-width: 960px;">

    <!-- Success Notice -->
    <?php if ($refDone): ?>
      <div class="form-alert success" style="margin-bottom: 2.5rem; font-size: 1rem; padding: 1.5rem; border-radius: var(--radius-lg);">
        <div>
          <h4 style="color: #065f46; margin-bottom: 0.35rem; font-size: 1.2rem;">Audit Request Confirmed: <?= e($refDone) ?></h4>
          <p style="margin: 0; color: #047857; line-height: 1.55;">
            Our senior technical team is analyzing your website architecture, SEO visibility, and digital user experience. Your detailed digital audit and project scope will be delivered to your corporate email within 24 hours.
          </p>
        </div>
      </div>
    <?php endif; ?>

    <!-- Interactive Result Display Card -->
    <div id="diagnostic-result-card" class="enterprise-hud-card" style="display: none; margin-bottom: 3rem; padding: 2.75rem; text-align: center;">
      <div class="eyebrow-badge dark" style="margin-bottom: 1rem;">
        <span class="pill-dot" style="background-color: var(--color-accent);"></span>
        <span>DIGITAL AUDIT &amp; REAL TELEMETRY COMPLETED</span>
      </div>
      <h2 style="color: #ffffff; margin-bottom: 0.5rem; font-size: 2rem;">Technical Audit &amp; Readiness Assessment</h2>
      <div style="font-family: var(--font-mono); font-size: 0.85rem; color: rgba(255,255,255,0.7); margin-bottom: 2rem;">
        PROJECT TRACKING REFERENCE: <strong style="color: var(--color-accent);" class="result-ref-val">BD-XXXXX</strong>
      </div>

      <!-- Real Live Domain Telemetry Block (Genuine Network Measurement) -->
      <div style="background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(161, 126, 145, 0.3); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 2.25rem; text-align: left;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.12); padding-bottom: 0.75rem;">
          <div style="display: flex; align-items: center; gap: 0.5rem; font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-accent); font-weight: 700;">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
            <span>LIVE DOMAIN TELEMETRY (REAL MEASUREMENT)</span>
          </div>
          <span class="telemetry-domain" style="font-family: var(--font-mono); font-size: 0.8rem; color: rgba(255,255,255,0.85);"></span>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1.25rem; font-family: var(--font-mono); font-size: 0.82rem;">
          <div>
            <div style="color: rgba(255,255,255,0.6); font-size: 0.72rem; text-transform: uppercase;">HTTP STATUS</div>
            <div class="telemetry-http" style="font-weight: 700; color: #ffffff; font-size: 1.05rem;">--</div>
          </div>
          <div>
            <div style="color: rgba(255,255,255,0.6); font-size: 0.72rem; text-transform: uppercase;">SERVER LATENCY</div>
            <div class="telemetry-latency" style="font-weight: 700; color: var(--color-accent); font-size: 1.05rem;">-- ms</div>
          </div>
          <div>
            <div style="color: rgba(255,255,255,0.6); font-size: 0.72rem; text-transform: uppercase;">DNS RESOLUTION</div>
            <div class="telemetry-dns" style="font-weight: 700; color: #ffffff; font-size: 1.05rem;">--</div>
          </div>
          <div>
            <div style="color: rgba(255,255,255,0.6); font-size: 0.72rem; text-transform: uppercase;">SSL ENCRYPTION</div>
            <div class="telemetry-ssl" style="font-weight: 700; color: #ffffff; font-size: 1.05rem;">--</div>
          </div>
        </div>
        <div class="telemetry-status-msg" style="font-family: var(--font-mono); font-size: 0.78rem; color: rgba(255,255,255,0.7); margin-top: 1rem; border-top: 1px dashed rgba(255,255,255,0.12); padding-top: 0.75rem;"></div>
      </div>

      <!-- Survey Readiness Indicator -->
      <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2rem;">
        <div class="gauge-circle" style="width: 140px; height: 140px; border-color: rgba(255,255,255,0.15); border-top-color: var(--color-accent); border-right-color: var(--color-accent);">
          <span class="gauge-score result-score-val" style="font-size: 2.75rem; color: var(--color-accent);">56</span>
          <span class="gauge-unit" style="color: rgba(255,255,255,0.65);">READINESS INDEX</span>
        </div>
        <div style="font-size: 0.8rem; font-family: var(--font-mono); color: rgba(255,255,255,0.6); margin-top: 0.75rem;">
          * Strategic Readiness Index calculated from your organization's operating profile and digital goals.
        </div>
      </div>

      <p style="max-width: 640px; margin: 0 auto 2.25rem; color: rgba(255, 255, 255, 0.85); font-size: 1.05rem; line-height: 1.6;">
        Your submission has been captured. Our technical directors are reviewing your domain architecture, Core Web Vitals, and marketing funnel. A custom technical scope will be delivered to your email within 24 hours.
      </p>

      <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
        <a href="case-studies.php" class="btn btn-secondary">
          <span>Review Similar Client Work</span>
        </a>
        <a href="contact.php" class="btn btn-accent">
          <span>Speak With a Tech Lead</span>
        </a>
      </div>
    </div>

    <!-- Intake Card Form -->
    <div class="card" style="padding: 3.5rem; border-radius: var(--radius-xl);">
      <div style="margin-bottom: 2.5rem; border-bottom: 1px solid var(--color-slate-200); padding-bottom: 1.5rem;">
        <h3 style="font-size: 1.65rem; color: var(--color-text); margin-bottom: 0.5rem; font-weight: 800;">
          Request Your Custom Digital Audit &amp; Scope
        </h3>
        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin: 0;">
          All business information and project specifications are held in strict confidence.
        </p>
      </div>

      <form id="comprehensive-diagnostic-form" action="api/submit-diagnostic.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

        <!-- Section 1: Business Profile -->
        <h4 style="font-family: var(--font-mono); font-size: 0.82rem; color: #06B5F9; text-transform: uppercase; margin-bottom: 1.25rem; letter-spacing: 0.08em; font-weight: 700;">
          01 // Organization Information
        </h4>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label" for="company_name">Company / Brand Name *</label>
            <input type="text" id="company_name" name="company_name" required placeholder="Acme Global Inc." class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label" for="website_url">Website / Domain URL to Audit *</label>
            <input type="url" id="website_url" name="website_url" required placeholder="https://acmeglobal.com" class="form-control">
          </div>
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label" for="contact_name">Your Name &amp; Title *</label>
            <input type="text" id="contact_name" name="contact_name" required placeholder="Jane Doe, Director" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label" for="work_email">Business Email Address *</label>
            <input type="email" id="work_email" name="work_email" required placeholder="jane@acmeglobal.com" class="form-control">
          </div>
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label" for="phone">Phone / WhatsApp Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+1 (555) 019-2834" class="form-control">
          </div>
          <div class="form-group">
            <label class="form-label" for="operating_model">Primary Business Model *</label>
            <select id="operating_model" name="operating_model" class="form-select" required>
              <option value="b2b" <?= $preModel === 'b2b' ? 'selected' : '' ?>>B2B Enterprise, SaaS &amp; Tech</option>
              <option value="d2c" <?= $preModel === 'd2c' ? 'selected' : '' ?>>D2C Consumer &amp; E-Commerce</option>
              <option value="service" <?= $preModel === 'service' ? 'selected' : '' ?>>Professional &amp; Corporate Services</option>
              <option value="marketplace" <?= $preModel === 'marketplace' ? 'selected' : '' ?>>Marketplace / Multi-Channel Retailer</option>
            </select>
          </div>
        </div>

        <!-- Section 2: Technical Needs -->
        <h4 style="font-family: var(--font-mono); font-size: 0.82rem; color: #06B5F9; text-transform: uppercase; margin-top: 2rem; margin-bottom: 1.25rem; letter-spacing: 0.08em; font-weight: 700;">
          02 // Digital Focus &amp; Objectives
        </h4>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label" for="revenue_bracket">Annual Revenue Bracket *</label>
            <select id="revenue_bracket" name="revenue_bracket" class="form-select" required>
              <option value="under_250k" <?= $preRevenue === 'under_250k' ? 'selected' : '' ?>>Under $250,000 / year</option>
              <option value="250k_to_1m" <?= $preRevenue === '250k_to_1m' ? 'selected' : '' ?>>$250,000 – $1,000,000 / year</option>
              <option value="1m_to_5m" <?= $preRevenue === '1m_to_5m' ? 'selected' : '' ?>>$1,000,000 – $5,000,000 / year</option>
              <option value="5m_plus" <?= $preRevenue === '5m_plus' ? 'selected' : '' ?>>$5,000,000+ / year (Enterprise)</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="primary_bottleneck">Primary Area of Need *</label>
            <select id="primary_bottleneck" name="primary_bottleneck" class="form-select" required>
              <option value="technology" <?= $preBottleneck === 'technology' ? 'selected' : '' ?>>Web &amp; Custom Software Development (Speed, Portals, Redesign)</option>
              <option value="traffic" <?= $preBottleneck === 'traffic' ? 'selected' : '' ?>>Digital Marketing &amp; SEO (Google Ads, Meta Ads, Search Rankings)</option>
              <option value="conversion" <?= $preBottleneck === 'conversion' ? 'selected' : '' ?>>Conversion Rate Optimization &amp; Funnel UX</option>
              <option value="branding" <?= $preBottleneck === 'branding' ? 'selected' : '' ?>>UI/UX Redesign &amp; Brand Identity</option>
              <option value="marketplace" <?= $preBottleneck === 'marketplace' ? 'selected' : '' ?>>Amazon / Flipkart Marketplace Management &amp; Advertising</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="symptom_notes">Project Details / Goals / Current Challenges</label>
          <textarea id="symptom_notes" name="diagnostic_summary" class="form-textarea" placeholder="Tell us about your target audience, current technical challenges, desired launch timeline, and primary objectives..."></textarea>
        </div>

        <div style="margin-top: 2rem;">
          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
            <span>Submit for Free Website &amp; Digital Audit</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </button>
        </div>

        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-light);">
          <svg style="width: 15px; height: 15px; color: #06B5F9;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <span>STRICT CONFIDENTIALITY // NO COMMITMENT REQUIRED // 24-HOUR TURNAROUND</span>
        </div>
      </form>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
