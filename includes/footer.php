<?php
/**
 * BusinessDoctor Global Footer Template - Enterprise IT & Digital Solutions
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$practices = getPracticeAreas();
?>
</main>

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <!-- Col 1: Brand & Overview -->
      <div class="footer-col footer-brand">
        <a href="<?= appUrl() ?>" class="brand-logo" style="color: #ffffff;" aria-label="BusinessDoctor Home">
          <img src="<?= getAssetUrl('assets/img/bdr_logo_transparent.png') ?>" alt="BusinessDoctor Logo" class="brand-logo-img" style="height: 52px; width: auto; max-width: 150px; object-fit: contain; aspect-ratio: 1816 / 1131; display: block;">
        </a>
        <p>
          Established international IT solutions and digital growth firm. We engineer high-performance web software, execute data-driven digital marketing, design distinctive brand systems, and scale multi-channel marketplace operations.
        </p>
        <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-accent);">
          <span class="pill-dot"></span>
          <span>ENTERPRISE ENGINEERING & DIGITAL OPERATIONS ACTIVE 24/7</span>
        </div>
      </div>

      <!-- Col 2: Services -->
      <div class="footer-col">
        <h4 class="footer-title">IT & Digital Disciplines</h4>
        <div class="footer-links">
          <?php foreach ($practices as $slug => $p): ?>
            <a href="<?= getServiceUrl($slug) ?>" class="footer-link">
              <?= e($p['name']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Col 3: Company & Resources -->
      <div class="footer-col">
        <h4 class="footer-title">Enterprise</h4>
        <div class="footer-links">
          <a href="<?= appUrl('about') ?>" class="footer-link">About BusinessDoctor</a>
          <a href="<?= appUrl('audit') ?>" class="footer-link">Free Technical Digital Audit</a>
          <a href="<?= appUrl('case-studies') ?>" class="footer-link">Client Case Studies</a>
          <a href="<?= getBlogListingUrl() ?>" class="footer-link">Blogs &amp; Resources</a>
          <a href="<?= appUrl('contact') ?>" class="footer-link">Consultation &amp; Contact</a>
          <a href="<?= appUrl('admin/login.php') ?>" class="footer-link" style="color: #8FA3B8;">Project Console (Admin)</a>
        </div>
      </div>

      <!-- Col 4: Newsletter & Direct Coordinates -->
      <div class="footer-col">
        <h4 class="footer-title">Perspectives Newsletter</h4>
        <p style="font-size: 0.88rem; color: #B8C7D9; margin-bottom: 1.25rem;">
          Subscribe to our executive brief covering software engineering architectures, SEO algorithms, and digital growth frameworks.
        </p>
        <form class="newsletter-form" action="<?= appUrl('api/newsletter-subscribe.php') ?>" method="POST">
          <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
          <div style="display: flex; gap: 0.5rem; width: 100%;">
            <input type="email" name="email" required placeholder="executive@enterprise.com" class="cta-input" style="font-size: 0.88rem; padding: 0.75rem 1rem;">
            <button type="submit" class="btn btn-accent btn-sm" style="flex-shrink: 0;">
              Subscribe
            </button>
          </div>
        </form>
        <div style="margin-top: 1.75rem; font-size: 0.85rem; color: #B8C7D9;">
          <div><strong>Direct Line:</strong> <?= APP_PHONE ?></div>
          <div style="margin-top: 0.35rem;"><strong>Inquiries:</strong> <?= APP_EMAIL ?></div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom Strip -->
    <div class="footer-bottom">
      <div>
        &copy; <?= date('Y') ?> <?= APP_LEGAL_NAME ?>. All rights reserved.
      </div>
      <div class="footer-legal-links">
        <a href="<?= appUrl('contact') ?>" class="footer-link">Terms of Engagement</a>
        <a href="<?= appUrl('contact') ?>" class="footer-link">Privacy & Governance</a>
        <a href="<?= appUrl('contact') ?>" class="footer-link">Security Compliance</a>
      </div>
    </div>
  </div>
</footer>

<!-- ============================================================
     FIXED FLOATING CONTACT ICONS (GLOBAL PUBLIC WIDGET)
     ============================================================ -->
<aside class="floating-contact-widget" aria-label="Quick Contact Channels"
  style="position: fixed; bottom: max(24px, env(safe-area-inset-bottom, 24px)); right: max(24px, env(safe-area-inset-right, 24px)); z-index: 990; display: flex; flex-direction: column; gap: 12px; pointer-events: none;">

  <!-- Direct Call Floating Action -->
  <a href="tel:<?= htmlspecialchars(APP_CALL_NUMBER) ?>" class="floating-contact-btn floating-call-btn"
    aria-label="Call BusinessDoctor at <?= htmlspecialchars(APP_PHONE) ?>"
    title="Call BusinessDoctor (<?= htmlspecialchars(APP_PHONE) ?>)"
    style="pointer-events: auto; width: 52px; height: 52px; border-radius: 50%; background: #06B5F9; color: #061326; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 18px rgba(6, 181, 249, 0.45); transition: transform 0.2s ease, box-shadow 0.2s ease; text-decoration: none;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
      stroke-linecap="round" stroke-linejoin="round">
      <path
        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
      </path>
    </svg>
  </a>

  <!-- WhatsApp Floating Action -->
  <a href="https://wa.me/<?= htmlspecialchars(APP_WHATSAPP_NUMBER) ?>?text=<?= urlencode(APP_WHATSAPP_MESSAGE) ?>"
    target="_blank" rel="noopener noreferrer" class="floating-contact-btn floating-wa-btn"
    aria-label="Chat with BusinessDoctor on WhatsApp" title="Chat on WhatsApp"
    style="pointer-events: auto; width: 52px; height: 52px; border-radius: 50%; background: #25D366; color: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 18px rgba(37, 211, 102, 0.45); transition: transform 0.2s ease, box-shadow 0.2s ease; text-decoration: none;">
    <svg width="25" height="25" viewBox="0 0 24 24" fill="currentColor">
      <path
        d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M9.53 7.34C9.36 7.34 9.09 7.4 8.87 7.65C8.65 7.89 8.02 8.48 8.02 9.71C8.02 10.94 8.91 12.13 9.03 12.29C9.15 12.46 10.8 15.01 13.32 16.1C13.92 16.36 14.39 16.51 14.75 16.63C15.35 16.82 15.9 16.79 16.34 16.73C16.82 16.66 17.82 16.12 18.03 15.54C18.24 14.95 18.24 14.45 18.18 14.35C18.12 14.24 17.95 14.18 17.7 14.05C17.44 13.93 16.19 13.31 15.96 13.23C15.73 13.14 15.56 13.1 15.4 13.35C15.23 13.6 14.76 14.18 14.61 14.35C14.46 14.52 14.31 14.54 14.06 14.42C13.8 14.29 13 14.03 12.04 13.17C11.3 12.5 10.79 11.68 10.65 11.43C10.5 11.18 10.63 11.04 10.76 10.92C10.88 10.8 11.02 10.61 11.16 10.45C11.3 10.28 11.34 10.16 11.43 9.99C11.51 9.83 11.47 9.68 11.41 9.56C11.34 9.44 10.85 8.24 10.64 7.74C10.44 7.26 10.24 7.32 10.09 7.32C9.94 7.32 9.77 7.34 9.53 7.34Z" />
    </svg>
  </a>
</aside>
<style>
.floating-contact-btn:hover {
  transform: translateY(-3px) scale(1.05);
}
.floating-call-btn:hover {
  box-shadow: 0 6px 22px rgba(6, 181, 249, 0.65) !important;
}
.floating-wa-btn:hover {
  box-shadow: 0 6px 22px rgba(37, 211, 102, 0.65) !important;
}
</style>

<!-- Lead Generation Popup Modal -->
<?php require_once __DIR__ . '/lead-popup.php'; ?>
<script src="<?= getAssetUrl('assets/js/lead-popup.js') ?>?v=<?= filemtime(__DIR__ . '/../assets/js/lead-popup.js') ?>"></script>

<!-- Core Vanilla JavaScript -->
<script src="<?= getAssetUrl('assets/js/main.js') ?>?v=<?= filemtime(__DIR__ . '/../assets/js/main.js') ?>"></script>
<script src="<?= getAssetUrl('assets/js/diagnostic-calculator.js') ?>" ></script>
<script src="<?= getAssetUrl('assets/js/form-handler.js') ?>" ></script>
<script src="<?= getAssetUrl('assets/js/services-interactive.js') ?>?v=<?= filemtime(__DIR__ . '/../assets/js/services-interactive.js') ?>"></script>
</body>
</html>
