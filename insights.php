<?php
/**
 * BusinessDoctor Tech & Digital Insights Directory - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Perspectives & Insights — BusinessDoctor Enterprise IT';
$pageDescription = 'Articles and engineering guides on custom web architecture, SEO algorithms, performance ad strategies, and e-commerce scaling.';

$insights = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT * FROM insights WHERE is_published = 1 ORDER BY published_at DESC");
    $insights = $stmt->fetchAll();
} catch (Exception $e) {}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>PERSPECTIVES &amp; ANALYSIS</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.5rem;">
      Technology Architecture &amp; <br><span class="text-gradient-pine">Digital Growth Perspectives</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      Practical engineering blueprints, Core Web Vitals breakdowns, and conversion marketing frameworks authored by our senior software architects and digital strategists.
    </p>
  </div>
</section>

<!-- Insights Grid -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="cases-editorial-grid">
      <?php if (!empty($insights)): ?>
        <?php foreach ($insights as $item): ?>
          <article class="case-editorial-card">
            <div class="case-card-header" style="background: var(--color-primary);">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span class="case-industry-tag"><?= e($item['category']) ?></span>
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: rgba(255,255,255,0.7);"><?= e($item['reading_time']) ?></span>
              </div>
            </div>

            <div class="case-card-content">
              <h3 class="case-card-title">
                <a href="insight-detail.php?slug=<?= urlencode($item['slug']) ?>" style="color: var(--color-text); text-decoration: none;">
                  <?= e($item['title']) ?>
                </a>
              </h3>

              <p class="case-card-summary">
                <?= e($item['summary']) ?>
              </p>

              <div style="border-top: 1px solid var(--color-slate-100); padding-top: 1.25rem; margin-top: auto; display: flex; justify-content: space-between; align-items: center;">
                <div>
                  <div style="font-size: 0.88rem; font-weight: 700; color: var(--color-text);"><?= e($item['author_name']) ?></div>
                  <div style="font-size: 0.76rem; color: var(--color-text-light); font-family: var(--font-mono);"><?= e($item['author_title']) ?></div>
                </div>
                <a href="insight-detail.php?slug=<?= urlencode($item['slug']) ?>" class="case-card-action">
                  <span>Read Article</span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                  </svg>
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Newsletter CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Receive Executive Tech &amp; Growth Briefings</h2>
        <p class="closing-cta-lead">
          Join founders and technology executives who receive our monthly brief covering software engineering architectures and digital strategy frameworks.
        </p>

        <form class="newsletter-form" action="api/newsletter-subscribe.php" method="POST" style="display: flex; gap: 0.75rem; max-width: 500px; margin: 0 auto; flex-wrap: wrap;">
          <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
          <input type="email" name="email" required placeholder="corporate@enterprise.com" class="cta-input" style="flex: 1; min-width: 240px; font-size: 0.95rem;">
          <button type="submit" class="btn btn-accent btn-lg" style="flex-shrink: 0;">
            <span>Subscribe</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
