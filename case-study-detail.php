<?php
/**
 * BusinessDoctor Case Study Detail View - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$slug = trim($_GET['slug'] ?? '');

$case = null;
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM case_studies WHERE slug = ? AND status = 'published' AND is_deleted = 0 LIMIT 1");
    $stmt->execute([$slug]);
    $case = $stmt->fetch();
} catch (Exception $e) {}

if (!$case) {
    header("Location: case-studies.php");
    exit;
}

$pageTitle = (!empty($case['seo_title']) ? $case['seo_title'] : $case['title']) . ' — Client Case Study | BusinessDoctor';
$pageDescription = !empty($case['seo_description']) ? $case['seo_description'] : substr($case['challenge'], 0, 150);

$canonicalUrl = 'https://businessdoctor.com/case-studies/' . rawurlencode($case['slug']);
$markdownUrl = 'https://businessdoctor.com/content-md/case-studies/' . rawurlencode($case['slug']) . '.md';
$schemaPageKey = 'case-study-detail';
$schemaContextData = $case;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container">
    <div style="max-width: 940px;">
      <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem; flex-wrap: wrap;">
        <span class="eyebrow-badge" style="margin-bottom: 0;"><?= e($case['industry'] ?: $case['client_industry']) ?></span>
        <span style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-secondary); font-weight: 700;"><?= e($case['service_category'] ?: $case['practice_area']) ?></span>
        <?php if (!empty($case['client_name'])): ?>
          <span style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-teal-400); font-weight: 700;">● <?= e($case['client_name']) ?></span>
        <?php endif; ?>
      </div>
      <h1 class="hero-headline-oversized" style="font-size: clamp(2.2rem, 4vw, 3.4rem); margin-bottom: 1.5rem;">
        <?= e($case['title']) ?>
      </h1>

      <!-- Metric Transformation Callout -->
      <div class="enterprise-hud-card" style="padding: 2.25rem 2.5rem; margin-top: 2rem;">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-accent); text-transform: uppercase; margin-bottom: 1.25rem; font-weight: 700; letter-spacing: 0.1em;">
          ● VERIFIED PROJECT IMPACT
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1.2fr 1fr; gap: 2rem; align-items: center;">
          <div>
            <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">BASELINE STATUS</div>
            <div style="font-size: 1.25rem; color: #fca5a5; text-decoration: line-through; font-family: var(--font-display); font-weight: 700; margin-top: 0.25rem;">
              <?= e($case['baseline_metric']) ?>
            </div>
          </div>
          <div>
            <div style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--color-accent); text-transform: uppercase; font-weight: 700;">VERIFIED OUTCOME</div>
            <div style="font-size: 1.85rem; color: var(--color-accent); font-family: var(--font-display); font-weight: 800; margin-top: 0.25rem; line-height: 1.1;">
              <?= e($case['outcome_metric']) ?>
            </div>
          </div>
          <div>
            <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">MEASURED IMPACT</div>
            <div style="font-size: 1.15rem; color: #ffffff; font-family: var(--font-display); font-weight: 700; margin-top: 0.25rem;">
              <?= e($case['metric_label']) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Deep Dive Case Body -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container" style="max-width: 900px;">
    <?php if (!empty($case['featured_image'])): ?>
      <div style="margin-bottom: 3rem; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-slate-200); box-shadow: var(--shadow-md);">
        <img src="<?= e($case['featured_image']) ?>" alt="<?= e($case['title']) ?>" style="width: 100%; max-height: 440px; object-fit: cover; display: block;">
      </div>
    <?php endif; ?>
    <!-- Section 1: The Challenge -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        01 // THE CHALLENGE
      </div>
      <h2 style="font-size: 1.8rem; color: var(--color-text); margin-bottom: 1rem; font-weight: 800;">
        Business Friction &amp; Architectural Bottlenecks
      </h2>
      <p style="font-size: 1.05rem; line-height: 1.75; color: var(--color-text-muted);">
        <?= nl2br(e($case['challenge'])) ?>
      </p>
    </div>

    <!-- Section 2: The Solution & Architecture -->
    <div style="margin-bottom: 3.5rem; background: var(--color-bg); padding: 3rem; border-radius: var(--radius-xl); border-left: 4px solid var(--color-secondary);">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        02 // THE SOLUTION &amp; EXECUTION
      </div>
      <h2 style="font-size: 1.8rem; margin-bottom: 1rem; color: var(--color-text); font-weight: 800;">
        The BusinessDoctor Engineering Architecture
      </h2>
      <p style="font-size: 1.05rem; line-height: 1.75; color: var(--color-text); margin: 0;">
        <?= nl2br(e($case['prescription'])) ?>
      </p>
    </div>

    <!-- Section 3: Business Impact -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        03 // COMMERCIAL RESULTS
      </div>
      <h2 style="font-size: 1.8rem; color: var(--color-text); margin-bottom: 1rem; font-weight: 800;">
        Measurable Commercial &amp; Technical Return
      </h2>
      <p style="font-size: 1.05rem; line-height: 1.75; color: var(--color-text-muted);">
        <?= nl2br(e($case['result_description'])) ?>
      </p>
    </div>

    <!-- Executive Quote -->
    <?php if (!empty($case['quote_text'])): ?>
      <div class="card" style="padding: 2.5rem; background: var(--color-primary); color: var(--color-white); border-color: rgba(161, 126, 145,0.3); border-radius: var(--radius-xl);">
        <div style="font-size: 1.25rem; font-style: italic; line-height: 1.65; margin-bottom: 1.5rem; color: rgba(255,255,255,0.92);">
          &ldquo;<?= e($case['quote_text']) ?>&rdquo;
        </div>
        <div style="border-top: 1px solid rgba(255,255,255,0.15); padding-top: 1.25rem; display: flex; align-items: center; justify-content: space-between;">
          <div>
            <div style="font-family: var(--font-display); font-weight: 700; font-size: 1.05rem; color: var(--color-white);">
              <?= e($case['quote_author']) ?>
            </div>
            <div style="font-size: 0.82rem; color: var(--color-accent); font-family: var(--font-mono);">
              <?= e($case['quote_title']) ?>
            </div>
          </div>
          <div style="font-family: var(--font-mono); font-size: 0.75rem; color: rgba(255,255,255,0.6);">
            VERIFIED CLIENT TESTIMONIAL
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div style="margin-top: 3.5rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-200); padding-top: 2rem;">
      <a href="case-studies.php" class="case-card-action">
        <span>&larr; Back to All Case Studies</span>
      </a>
      <a href="contact.php" class="btn btn-primary">
        <span>Discuss a Similar Project</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
