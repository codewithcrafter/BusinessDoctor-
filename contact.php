<?php
/**
 * BusinessDoctor Contact & Executive Consultation Desk
 * Enterprise IT Solutions & Digital Services Practice
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Executive Consultation & Inquiries — BusinessDoctor Enterprise IT';
$pageDescription = 'Connect directly with BusinessDoctor software architects, digital marketing leads, and cloud engineers for custom web systems, performance SEO, or e-commerce scaling.';

$preService = $_GET['service'] ?? 'Web & Custom Software Development';
$practices = getPracticeAreas();

$schemaPageKey = 'contact';
$schemaContextData = [
    'title' => 'Contact Us & Executive Consultation',
    'summary' => $pageDescription,
    'canonical_url' => getBaseUrl() . '/contact'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ============================================================
     HERO SECTION — EXECUTIVE ADVISORY DESK
     ============================================================ -->
<section class="section hero-enterprise contact-hero" style="padding-top: 5.5rem; padding-bottom: 4rem; position: relative; overflow: hidden;">
  <!-- Ambient background glow elements -->
  <div style="position: absolute; top: 10%; left: 50%; transform: translateX(-50%); width: 700px; height: 350px; background: radial-gradient(circle, rgba(6, 181, 249, 0.08) 0%, rgba(0, 153, 219, 0.02) 50%, transparent 70%); filter: blur(50px); pointer-events: none; z-index: 0;"></div>

  <div class="container text-center" style="max-width: 920px; margin: 0 auto; position: relative; z-index: 1;">
    <div class="eyebrow-badge" style="margin-bottom: 1.25rem;">
      <span class="pill-dot"></span>
      <span>DIRECT ARCHITECTURAL CONSULTATION</span>
    </div>
    
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.3rem, 4.5vw, 3.8rem); line-height: 1.15; margin-bottom: 1.25rem; font-weight: 800; letter-spacing: -0.02em;">
      Let’s Engineer Your Next <br>
      <span class="text-brand">Growth Breakthrough</span>
    </h1>
    
    <p class="hero-lead-text" style="max-width: 760px; margin: 0 auto 2.5rem; font-size: 1.1rem; line-height: 1.7; color: var(--color-text-muted);">
      Direct access to principal software architects, performance marketers, and e-commerce growth leads. No junior account managers or sales runaround.
    </p>

    <!-- Executive SLA Guarantee Strip -->
    <div class="contact-sla-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; max-width: 820px; margin: 0 auto;">
      <div style="background: rgba(6, 19, 38, 0.65); border: 1px solid rgba(6, 181, 249, 0.2); border-radius: var(--radius-md); padding: 0.85rem 1.15rem; display: flex; align-items: center; gap: 0.75rem; text-align: left; backdrop-filter: blur(8px);">
        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(6, 181, 249, 0.12); color: #06B5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(6, 181, 249, 0.3);">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
          <div style="font-size: 0.85rem; font-weight: 700; color: #FFFFFF;">Sub-2 Hour SLA</div>
          <div style="font-size: 0.74rem; color: #94A3B8; font-family: var(--font-mono);">Rapid technical review</div>
        </div>
      </div>

      <div style="background: rgba(6, 19, 38, 0.65); border: 1px solid rgba(6, 181, 249, 0.2); border-radius: var(--radius-md); padding: 0.85rem 1.15rem; display: flex; align-items: center; gap: 0.75rem; text-align: left; backdrop-filter: blur(8px);">
        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(6, 181, 249, 0.12); color: #06B5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(6, 181, 249, 0.3);">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div>
          <div style="font-size: 0.85rem; font-weight: 700; color: #FFFFFF;">100% NDA Protected</div>
          <div style="font-size: 0.74rem; color: #94A3B8; font-family: var(--font-mono);">Confidentiality guaranteed</div>
        </div>
      </div>

      <div style="background: rgba(6, 19, 38, 0.65); border: 1px solid rgba(6, 181, 249, 0.2); border-radius: var(--radius-md); padding: 0.85rem 1.15rem; display: flex; align-items: center; gap: 0.75rem; text-align: left; backdrop-filter: blur(8px);">
        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(6, 181, 249, 0.12); color: #06B5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(6, 181, 249, 0.3);">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
        </div>
        <div>
          <div style="font-size: 0.85rem; font-weight: 700; color: #FFFFFF;">Direct Tech Leads</div>
          <div style="font-size: 0.74rem; color: #94A3B8; font-family: var(--font-mono);">Speak code &amp; strategy</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     MAIN 2-COLUMN WORKSPACE: FORM + INSTITUTIONAL COORDINATES
     ============================================================ -->
<section class="section contact-workspace-section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200); padding-top: 4.5rem; padding-bottom: 5.5rem;">
  <div class="container">
    <div class="contact-main-grid" style="display: grid; grid-template-columns: 1.18fr 0.82fr; gap: 2.75rem; align-items: flex-start;">
      
      <!-- ================= LEFT COLUMN: EXECUTIVE PROPOSAL FORM ================= -->
      <div class="card contact-form-card" style="padding: 3rem 3.25rem; border-radius: var(--radius-xl); background: var(--color-card-bg); border: 1px solid var(--color-slate-200); box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12); position: relative; overflow: hidden;">
        
        <!-- Top Accent Bar -->
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #06B5F9, #0099DB, #38BDF8);"></div>

        <div style="margin-bottom: 2rem;">
          <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--font-mono); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: #06B5F9; margin-bottom: 0.6rem;">
            <span style="width: 6px; height: 6px; border-radius: 50%; background: #06B5F9; display: inline-block;"></span>
            <span>PROJECT SPECIFICATION</span>
          </div>
          <h2 style="font-size: 1.85rem; color: var(--color-text); font-weight: 800; margin-bottom: 0.4rem; letter-spacing: -0.01em;">
            Request a Project Proposal
          </h2>
          <p style="font-size: 0.95rem; color: var(--color-text-muted); margin: 0; line-height: 1.6;">
            Detail your technical scope or digital objectives. Our principal solutions engineers will review your requirements and respond within 2 business hours.
          </p>
        </div>

        <form id="contact-form" action="api/submit-contact.php" method="POST">
          <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

          <!-- Row 1: Full Name & Corporate Email -->
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;" class="contact-form-row">
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="contact_name" style="font-weight: 600; font-size: 0.88rem; margin-bottom: 0.45rem; display: block;">
                Full Name <span style="color: #EF4444;">*</span>
              </label>
              <div style="position: relative;">
                <input type="text" id="contact_name" name="full_name" required placeholder="e.g. Marcus Vance" class="form-control" style="padding-left: 2.75rem;">
                <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94A3B8; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="contact_email" style="font-weight: 600; font-size: 0.88rem; margin-bottom: 0.45rem; display: block;">
                Corporate Work Email <span style="color: #EF4444;">*</span>
              </label>
              <div style="position: relative;">
                <input type="email" id="contact_email" name="email" required placeholder="e.g. marcus@enterprise.com" class="form-control" style="padding-left: 2.75rem;">
                <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94A3B8; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              </div>
            </div>
          </div>

          <!-- Row 2: Phone & Company -->
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;" class="contact-form-row">
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="contact_phone" style="font-weight: 600; font-size: 0.88rem; margin-bottom: 0.45rem; display: block;">
                Direct Phone / WhatsApp
              </label>
              <div style="position: relative;">
                <input type="tel" id="contact_phone" name="phone" placeholder="+1 (555) 000-0000" class="form-control" style="padding-left: 2.75rem;">
                <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94A3B8; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="contact_org" style="font-weight: 600; font-size: 0.88rem; margin-bottom: 0.45rem; display: block;">
                Company / Website URL <span style="color: #EF4444;">*</span>
              </label>
              <div style="position: relative;">
                <input type="text" id="contact_org" name="organization" required placeholder="e.g. Acme Corp / acme.com" class="form-control" style="padding-left: 2.75rem;">
                <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94A3B8; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
              </div>
            </div>
          </div>

          <!-- Service of Primary Interest -->
          <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" for="service_interest" style="font-weight: 600; font-size: 0.88rem; margin-bottom: 0.45rem; display: block;">
              Practice / Capability of Primary Interest <span style="color: #EF4444;">*</span>
            </label>
            <div style="position: relative;">
              <select id="service_interest" name="service_interest" class="form-select" required style="padding-left: 2.75rem; appearance: auto; -webkit-appearance: auto;">
                <option value="Full Comprehensive Digital Audit" <?= $preService === 'Full Comprehensive Digital Audit' ? 'selected' : '' ?>>Comprehensive Digital &amp; Architecture Audit</option>
                <?php foreach ($practices as $slug => $p): ?>
                  <option value="<?= e($p['name']) ?>" <?= $preService === $p['name'] ? 'selected' : '' ?>><?= e($p['name']) ?></option>
                <?php endforeach; ?>
                <option value="Custom Software & Cloud Infrastructure">Custom Software &amp; Cloud Infrastructure</option>
                <option value="Other Bespoke Engagement">Other Bespoke Strategic Engagement</option>
              </select>
              <svg style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94A3B8; pointer-events: none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
          </div>

          <!-- Quick Service Selector Pills for UX -->
          <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
            <button type="button" class="contact-pill-btn" onclick="selectServicePill('Web Development')" style="background: rgba(6, 181, 249, 0.08); border: 1px solid rgba(6, 181, 249, 0.25); color: #06B5F9; border-radius: 20px; padding: 0.3rem 0.75rem; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;">
              + Web Development
            </button>
            <button type="button" class="contact-pill-btn" onclick="selectServicePill('SEO')" style="background: rgba(6, 181, 249, 0.08); border: 1px solid rgba(6, 181, 249, 0.25); color: #06B5F9; border-radius: 20px; padding: 0.3rem 0.75rem; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;">
              + SEO &amp; Organic
            </button>
            <button type="button" class="contact-pill-btn" onclick="selectServicePill('PPC & Paid Ads')" style="background: rgba(6, 181, 249, 0.08); border: 1px solid rgba(6, 181, 249, 0.25); color: #06B5F9; border-radius: 20px; padding: 0.3rem 0.75rem; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;">
              + PPC Advertising
            </button>
            <button type="button" class="contact-pill-btn" onclick="selectServicePill('Ecommerce Management')" style="background: rgba(6, 181, 249, 0.08); border: 1px solid rgba(6, 181, 249, 0.25); color: #06B5F9; border-radius: 20px; padding: 0.3rem 0.75rem; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;">
              + E-Commerce
            </button>
            <button type="button" class="contact-pill-btn" onclick="selectServicePill('UI/UX Design & Branding')" style="background: rgba(6, 181, 249, 0.08); border: 1px solid rgba(6, 181, 249, 0.25); color: #06B5F9; border-radius: 20px; padding: 0.3rem 0.75rem; font-size: 0.75rem; cursor: pointer; transition: all 0.2s;">
              + UI/UX Design
            </button>
          </div>

          <!-- Project Requirements & Timeline -->
          <div class="form-group" style="margin-bottom: 1.75rem;">
            <label class="form-label" for="contact_msg" style="font-weight: 600; font-size: 0.88rem; margin-bottom: 0.45rem; display: block;">
              Project Goals, Architecture &amp; Target Timeline <span style="color: #EF4444;">*</span>
            </label>
            <textarea id="contact_msg" name="message" required rows="5" class="form-textarea" placeholder="Outline your objectives, current tech stack, pain points, website URLs, and expected launch date. (e.g. Migrating to custom PHP microservices, improving Core Web Vitals to sub-second TTFB, scaling Google Ads ROAS)..." style="line-height: 1.6;"></textarea>
          </div>

          <!-- Submit Button & Trust Guarantee -->
          <div>
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; padding: 0.95rem 1.75rem; font-weight: 700; font-size: 1.05rem; box-shadow: 0 6px 20px rgba(6, 181, 249, 0.35); display: flex; align-items: center; justify-content: center; gap: 0.65rem;">
              <span>Submit Project Inquiry</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="18" height="18" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
            
            <div style="display: flex; align-items: center; justify-content: center; gap: 1.25rem; margin-top: 1rem; font-size: 0.78rem; color: var(--color-text-muted); flex-wrap: wrap;">
              <span style="display: inline-flex; align-items: center; gap: 0.35rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Zero Spam Guarantee
              </span>
              <span>&bull;</span>
              <span style="display: inline-flex; align-items: center; gap: 0.35rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#06B5F9" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Encrypted Data Storage
              </span>
              <span>&bull;</span>
              <span>Direct Architect Response</span>
            </div>
          </div>
        </form>
      </div>

      <!-- ================= RIGHT COLUMN: INSTITUTIONAL CHANNELS & HQ HUB ================= -->
      <div style="display: flex; flex-direction: column; gap: 1.75rem;">
        
        <!-- Direct Communication Card -->
        <div class="enterprise-hud-card" style="padding: 2.25rem 2rem; border-radius: var(--radius-xl); background: var(--color-dark-surface); border: 1px solid rgba(6, 181, 249, 0.25); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
            <div style="font-family: var(--font-mono); font-size: 0.72rem; color: #06B5F9; letter-spacing: 0.1em; text-transform: uppercase; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem;">
              <span style="width: 7px; height: 7px; border-radius: 50%; background: #22C55E; box-shadow: 0 0 8px #22C55E; display: inline-block;"></span>
              <span>ACTIVE CHANNELS</span>
            </div>
            <span style="font-family: var(--font-mono); font-size: 0.72rem; color: #94A3B8; background: rgba(255,255,255,0.06); padding: 0.2rem 0.5rem; border-radius: 4px;">
              MON–SAT 9AM–8PM IST
            </span>
          </div>

          <h3 style="color: #ffffff; font-size: 1.35rem; margin-bottom: 0.6rem; font-weight: 800;">
            Direct Technical Engagement
          </h3>
          <p style="font-size: 0.9rem; color: #94A3B8; line-height: 1.55; margin-bottom: 1.75rem;">
            You speak directly with practicing software architects and digital growth leads who can review architecture schematics, unit economics, and code repositories on Day 1.
          </p>

          <!-- Channels List -->
          <div style="display: flex; flex-direction: column; gap: 1.15rem;">
            
            <!-- Direct Line -->
            <a href="tel:<?= preg_replace('/[^\d\+]/', '', APP_PHONE) ?>" style="display: flex; align-items: center; gap: 1rem; padding: 0.85rem 1rem; border-radius: var(--radius-md); background: rgba(6, 181, 249, 0.06); border: 1px solid rgba(6, 181, 249, 0.2); text-decoration: none; transition: all 0.2s;" class="contact-channel-item">
              <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(6, 181, 249, 0.15); color: #06B5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(6, 181, 249, 0.35);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
              </div>
              <div style="flex-grow: 1;">
                <div style="font-family: var(--font-mono); font-size: 0.7rem; color: #06B5F9; font-weight: 700; text-transform: uppercase;">ENTERPRISE ADVISORY LINE</div>
                <div style="font-size: 1.05rem; font-weight: 700; color: #FFFFFF; font-family: var(--font-mono);"><?= APP_PHONE ?></div>
              </div>
              <span style="color: #06B5F9; font-size: 1.1rem;">↗</span>
            </a>

            <!-- Direct Mailbox -->
            <a href="mailto:<?= APP_EMAIL ?>" style="display: flex; align-items: center; gap: 1rem; padding: 0.85rem 1rem; border-radius: var(--radius-md); background: rgba(6, 181, 249, 0.06); border: 1px solid rgba(6, 181, 249, 0.2); text-decoration: none; transition: all 0.2s;" class="contact-channel-item">
              <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(6, 181, 249, 0.15); color: #06B5F9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(6, 181, 249, 0.35);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                </svg>
              </div>
              <div style="flex-grow: 1;">
                <div style="font-family: var(--font-mono); font-size: 0.7rem; color: #06B5F9; font-weight: 700; text-transform: uppercase;">PROPOSALS &amp; AUDIT DESK</div>
                <div style="font-size: 1.02rem; font-weight: 700; color: #FFFFFF;"><?= APP_EMAIL ?></div>
              </div>
              <span style="color: #06B5F9; font-size: 1.1rem;">↗</span>
            </a>

            <!-- Global Headquarters -->
            <div style="display: flex; align-items: flex-start; gap: 1rem; padding: 0.85rem 1rem; border-radius: var(--radius-md); background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
              <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(255, 255, 255, 0.06); color: #94A3B8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(255, 255, 255, 0.12);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
              </div>
              <div>
                <div style="font-family: var(--font-mono); font-size: 0.7rem; color: #94A3B8; font-weight: 700; text-transform: uppercase;">DELIVERY CENTRE HEADQUARTERS</div>
                <div style="font-size: 0.88rem; font-weight: 600; color: #E2E8F0; line-height: 1.5; margin-top: 0.2rem;">
                  <?= APP_HEADQUARTERS ?>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- 4-Stage Engagement Workflow Card -->
        <div class="card" style="padding: 2.25rem 2rem; border-radius: var(--radius-xl); background: var(--color-card-bg); border: 1px solid var(--color-slate-200);">
          <div style="font-family: var(--font-mono); font-size: 0.72rem; color: #06B5F9; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem;">
            HOW WE ENGAGE
          </div>
          <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-text); margin-bottom: 1.25rem;">
            4-Stage Partnership Protocol
          </h3>

          <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
              <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 800; color: #06B5F9; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3); flex-shrink: 0;">01</span>
              <div>
                <strong style="font-size: 0.88rem; color: var(--color-text); display: block;">Technical Discovery Call</strong>
                <p style="font-size: 0.8rem; color: var(--color-text-muted); margin: 0.15rem 0 0; line-height: 1.45;">30-minute scoping session with a Senior Solutions Architect to examine requirements and bottlenecks.</p>
              </div>
            </div>

            <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
              <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 800; color: #06B5F9; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3); flex-shrink: 0;">02</span>
              <div>
                <strong style="font-size: 0.88rem; color: var(--color-text); display: block;">Architecture &amp; Growth Audit</strong>
                <p style="font-size: 0.8rem; color: var(--color-text-muted); margin: 0.15rem 0 0; line-height: 1.45;">Deep-dive inspection into Core Web Vitals, conversion funnel telemetry, or PPC waste.</p>
              </div>
            </div>

            <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
              <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 800; color: #06B5F9; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3); flex-shrink: 0;">03</span>
              <div>
                <strong style="font-size: 0.88rem; color: var(--color-text); display: block;">Fixed-Scope Milestone Plan</strong>
                <p style="font-size: 0.8rem; color: var(--color-text-muted); margin: 0.15rem 0 0; line-height: 1.45;">Transparent commercial proposal with exact deliverables, SLAs, and technical specifications.</p>
              </div>
            </div>

            <div style="display: flex; gap: 0.85rem; align-items: flex-start;">
              <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: 800; color: #06B5F9; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3); flex-shrink: 0;">04</span>
              <div>
                <strong style="font-size: 0.88rem; color: var(--color-text); display: block;">Rapid Production Sprint</strong>
                <p style="font-size: 0.8rem; color: var(--color-text-muted); margin: 0.15rem 0 0; line-height: 1.45;">Bi-weekly deployments, staging environment previews, and direct Slack/Teams coordination.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- Inline script for quick pill selection -->
<script>
function selectServicePill(serviceName) {
  const select = document.getElementById('service_interest');
  if (!select) return;
  for (let i = 0; i < select.options.length; i++) {
    if (select.options[i].text.toLowerCase().includes(serviceName.toLowerCase()) || 
        select.options[i].value.toLowerCase().includes(serviceName.toLowerCase())) {
      select.selectedIndex = i;
      select.dispatchEvent(new Event('change'));
      break;
    }
  }
}
</script>

<style>
@media (max-width: 991px) {
  .contact-main-grid {
    grid-template-columns: 1fr !important;
    gap: 2rem !important;
  }
  .contact-form-card {
    padding: 2rem 1.5rem !important;
  }
}
@media (max-width: 600px) {
  .contact-form-row {
    grid-template-columns: 1fr !important;
  }
}
.contact-channel-item:hover {
  background: rgba(6, 181, 249, 0.12) !important;
  border-color: rgba(6, 181, 249, 0.45) !important;
  transform: translateY(-2px);
}
.contact-pill-btn:hover {
  background: rgba(6, 181, 249, 0.2) !important;
  border-color: #06B5F9 !important;
  transform: translateY(-1px);
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
