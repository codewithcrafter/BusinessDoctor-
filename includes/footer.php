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
          <a href="<?= appUrl('about.php') ?>" class="footer-link">About BusinessDoctor</a>
          <a href="<?= appUrl('audit.php') ?>" class="footer-link">Free Technical Digital Audit</a>
          <a href="<?= appUrl('case-studies.php') ?>" class="footer-link">Client Case Studies</a>
          <a href="<?= appUrl('insights.php') ?>" class="footer-link">Blogs & Resources</a>
          <a href="<?= appUrl('contact.php') ?>" class="footer-link">Consultation & Contact</a>
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
        <a href="<?= appUrl('contact.php') ?>" class="footer-link">Terms of Engagement</a>
        <a href="<?= appUrl('contact.php') ?>" class="footer-link">Privacy & Governance</a>
        <a href="<?= appUrl('contact.php') ?>" class="footer-link">Security Compliance</a>
      </div>
    </div>
  </div>
</footer>

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
