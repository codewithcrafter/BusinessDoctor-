<?php
/**
 * BusinessDoctor Contact & Project Consultation Desk
 * Enterprise IT Solutions & Digital Services Practice
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Contact Us & Project Consultation — BusinessDoctor Enterprise IT';
$pageDescription = 'Connect with BusinessDoctor software architects and digital marketing leads for custom web development, SEO, branding, or marketplace management.';

$preService = $_GET['service'] ?? 'Web & Custom Software Development';
$practices = getPracticeAreas();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>EXECUTIVE CONSULTATION</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.5rem;">
      Let’s Build Something <br><span class="text-gradient-pine">Exceptional Together</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      Whether you need a custom high-performance web application, a full-funnel digital marketing campaign, an Amazon storefront overhaul, or ongoing cloud infrastructure support, our senior technical teams are ready to collaborate.
    </p>
  </div>
</section>

<!-- Contact & Inquiry Grid -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="hero-grid" style="align-items: flex-start; gap: 4rem;">
      <!-- Consultation Request Form -->
      <div class="card" style="padding: 3.5rem; border-radius: var(--radius-xl);">
        <h3 style="font-size: 1.6rem; color: var(--color-text); font-weight: 800; margin-bottom: 0.5rem;">
          Request a Project Proposal
        </h3>
        <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-bottom: 2rem;">
          Tell us about your project requirements. Our solutions team responds within 2 business hours.
        </p>

        <form id="contact-form" action="api/submit-contact.php" method="POST">
          <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label" for="contact_name">Full Name *</label>
              <input type="text" id="contact_name" name="full_name" required placeholder="Marcus Vance" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label" for="contact_email">Corporate Work Email *</label>
              <input type="email" id="contact_email" name="email" required placeholder="marcus@payguard.com" class="form-control">
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label" for="contact_phone">Direct Phone / WhatsApp</label>
              <input type="tel" id="contact_phone" name="phone" placeholder="+1 (555) 019-2834" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label" for="contact_org">Company / Organization *</label>
              <input type="text" id="contact_org" name="organization" required placeholder="PayGuard Technologies" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="service_interest">Service of Primary Interest *</label>
            <select id="service_interest" name="service_interest" class="form-select" required>
              <option value="Full Comprehensive Digital Audit" <?= $preService === 'Full Comprehensive Digital Audit' ? 'selected' : '' ?>>Comprehensive Website &amp; Digital Audit</option>
              <?php foreach ($practices as $slug => $p): ?>
                <option value="<?= e($p['name']) ?>" <?= $preService === $p['name'] ? 'selected' : '' ?>><?= e($p['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="contact_msg">Project Requirements &amp; Timeline *</label>
            <textarea id="contact_msg" name="message" required class="form-textarea" placeholder="Briefly outline your goals, current website URL, desired tech stack, and target completion timeline..."></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
            <span>Send Project Inquiry</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </button>
        </form>
      </div>

      <!-- Institutional Contact Coordinates & SLA -->
      <div>
        <div class="enterprise-hud-card" style="padding: 2.75rem 2.25rem; margin-bottom: 2rem;">
          <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-accent); margin-bottom: 1rem; letter-spacing: 0.1em; text-transform: uppercase;">
            ● OUR SERVICE COMMITMENT
          </div>
          <h3 style="color: #ffffff; font-size: 1.45rem; margin-bottom: 1.25rem; line-height: 1.3;">
            Direct Access to Tech Leads
          </h3>
          <p style="font-size: 0.95rem; color: rgba(255,255,255,0.85); line-height: 1.6; margin-bottom: 2rem;">
            You will never be handed off to junior sales reps who don't understand code or marketing analytics. You speak directly with practicing software architects and digital directors.
          </p>

          <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 1.25rem;">
              <div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: rgba(161, 126, 145, 0.15); color: var(--color-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
              </div>
              <div>
                <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">DIRECT OFFICE PHONE</div>
                <div style="font-size: 1.15rem; font-weight: 700; color: #ffffff;"><?= APP_PHONE ?></div>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 1.25rem;">
              <div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: rgba(161, 126, 145, 0.15); color: var(--color-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                </svg>
              </div>
              <div>
                <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">PROJECT INQUIRIES DESK</div>
                <div style="font-size: 1.15rem; font-weight: 700; color: #ffffff;"><?= APP_EMAIL ?></div>
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid rgba(255,255,255,0.12); padding-top: 1.25rem;">
              <div style="width: 44px; height: 44px; border-radius: var(--radius-md); background: rgba(161, 126, 145, 0.15); color: var(--color-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
              </div>
              <div>
                <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">TECHNOLOGY CENTER HEADQUARTERS</div>
                <div style="font-size: 1rem; font-weight: 600; color: #ffffff;"><?= APP_HEADQUARTERS ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
