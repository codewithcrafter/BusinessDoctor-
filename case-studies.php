<?php
/**
 * BusinessDoctor Client Case Studies Directory - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Case Studies & Verified Outcomes — BusinessDoctor Enterprise IT';
$pageDescription = 'Examine verified case studies of businesses scaled through custom web development, high-ROI digital marketing, and marketplace acceleration.';

$cases = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query("SELECT * FROM case_studies ORDER BY sort_order ASC");
    $cases = $stmt->fetchAll();
} catch (Exception $e) {}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>VERIFIED CLIENT OUTCOMES</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.5rem;">
      Real Transformation. <br><span class="text-gradient-pine">Verified Business Impact.</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      We let our results speak for themselves. Discover how our custom web engineering, digital marketing, UI/UX design, and marketplace operations helped businesses solve critical roadblocks and scale revenue.
    </p>
  </div>
</section>

<!-- Case Studies Grid -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="cases-editorial-grid">
      <?php if (!empty($cases)): ?>
        <?php foreach ($cases as $c): ?>
          <article class="case-editorial-card">
            <div class="case-card-header">
              <span class="case-industry-tag"><?= e($c['client_industry']) ?></span>
              <div style="font-size: 0.82rem; color: rgba(255,255,255,0.7); margin-bottom: 0.5rem; font-family: var(--font-mono);"><?= e($c['practice_area']) ?></div>
              
              <div class="case-metric-banner">
                <div>
                  <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">BASELINE</div>
                  <div style="font-size: 0.95rem; color: #fca5a5; text-decoration: line-through; font-family: var(--font-mono);"><?= e($c['baseline_metric']) ?></div>
                </div>
                <div style="text-align: right;">
                  <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">VERIFIED OUTCOME</div>
                  <div class="case-outcome-stat"><?= e($c['outcome_metric']) ?></div>
                </div>
              </div>
            </div>

            <div class="case-card-content">
              <h3 class="case-card-title">
                <a href="case-study-detail.php?slug=<?= urlencode($c['slug']) ?>" style="color: var(--color-text); text-decoration: none;">
                  <?= e($c['title']) ?>
                </a>
              </h3>
              
              <div style="margin-bottom: 1.25rem;">
                <div style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--color-secondary); text-transform: uppercase; font-weight: 700; margin-bottom: 0.35rem;">
                  THE CHALLENGE:
                </div>
                <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;"><?= e($c['challenge']) ?></p>
              </div>

              <div style="margin-bottom: 1.5rem; background: var(--color-bg); padding: 1.25rem; border-radius: var(--radius-md); border-left: 3px solid var(--color-secondary);">
                <div style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--color-text); text-transform: uppercase; font-weight: 700; margin-bottom: 0.35rem;">
                  THE SOLUTION:
                </div>
                <p style="font-size: 0.88rem; color: var(--color-text); margin: 0; line-height: 1.55;">
                  <?= e(substr($c['prescription'], 0, 160)) ?>...
                </p>
              </div>

              <?php if (!empty($c['quote_text'])): ?>
                <div class="case-quote-box" style="margin-bottom: 1.5rem;">
                  &ldquo;<?= e($c['quote_text']) ?>&rdquo;
                  <div class="case-quote-author">
                    — <?= e($c['quote_author']) ?>, <?= e($c['quote_title']) ?>
                  </div>
                </div>
              <?php endif; ?>

              <div style="margin-top: auto;">
                <a href="case-study-detail.php?slug=<?= urlencode($c['slug']) ?>" class="case-card-action">
                  <span>Read Full Technical Architecture</span>
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

<!-- Project CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Ready to Achieve Similar Results?</h2>
        <p class="closing-cta-lead">
          Let's discuss how our integrated engineering and digital marketing teams can accelerate your business objectives.
        </p>
        <div class="closing-cta-buttons">
          <a href="contact.php" class="btn btn-accent btn-lg">
            <span>Schedule a Consultation</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="audit.php" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
