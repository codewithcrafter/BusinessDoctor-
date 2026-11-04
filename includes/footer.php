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
        <a href="index.php" class="brand-logo" style="color: #ffffff;">
          <div class="brand-symbol">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
              <polyline points="16 18 22 12 16 6"/>
              <polyline points="8 6 2 12 8 18"/>
            </svg>
          </div>
          <span>Business<span style="color: var(--color-accent); font-weight: 700;">Doctor</span></span>
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
            <a href="service-detail.php?slug=<?= urlencode($slug) ?>" class="footer-link">
              <?= e($p['name']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Col 3: Company & Resources -->
      <div class="footer-col">
        <h4 class="footer-title">Enterprise</h4>
        <div class="footer-links">
          <a href="about.php" class="footer-link">About BusinessDoctor</a>
          <a href="audit.php" class="footer-link">Free Technical Digital Audit</a>
          <a href="case-studies.php" class="footer-link">Client Case Studies</a>
          <a href="insights.php" class="footer-link">Insights & Perspectives</a>
          <a href="contact.php" class="footer-link">Consultation & Contact</a>
          <a href="admin/login.php" class="footer-link" style="color: rgba(255, 255, 255, 0.45);">Project Console (Admin)</a>
        </div>
      </div>

      <!-- Col 4: Newsletter & Direct Coordinates -->
      <div class="footer-col">
        <h4 class="footer-title">Perspectives Newsletter</h4>
        <p style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.7); margin-bottom: 1.25rem;">
          Subscribe to our executive brief covering software engineering architectures, SEO algorithms, and digital growth frameworks.
        </p>
        <form class="newsletter-form" action="api/newsletter-subscribe.php" method="POST">
          <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
          <div style="display: flex; gap: 0.5rem; width: 100%;">
            <input type="email" name="email" required placeholder="executive@enterprise.com" class="cta-input" style="font-size: 0.88rem; padding: 0.75rem 1rem;">
            <button type="submit" class="btn btn-accent btn-sm" style="flex-shrink: 0;">
              Subscribe
            </button>
          </div>
        </form>
        <div style="margin-top: 1.75rem; font-size: 0.85rem; color: rgba(255, 255, 255, 0.7);">
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
        <a href="contact.php" class="footer-link">Terms of Engagement</a>
        <a href="contact.php" class="footer-link">Privacy & Governance</a>
        <a href="contact.php" class="footer-link">Security Compliance</a>
      </div>
    </div>
  </div>
</footer>

<!-- Core Vanilla JavaScript -->
<script src="assets/js/main.js?v=<?= filemtime(__DIR__ . '/../assets/js/main.js') ?>"></script>
<script src="assets/js/diagnostic-calculator.js"></script>
<script src="assets/js/form-handler.js"></script>
</body>
</html>
