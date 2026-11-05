<?php
/**
 * BusinessDoctor Tech Insight Deep-Dive View - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$slug = trim($_GET['slug'] ?? '');

$insight = null;
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM insights WHERE slug = ? AND status = 'published' AND is_deleted = 0 LIMIT 1");
    $stmt->execute([$slug]);
    $insight = $stmt->fetch();
} catch (Exception $e) {}

if (!$insight) {
    header("Location: insights.php");
    exit;
}

$pageTitle = (!empty($insight['seo_title']) ? $insight['seo_title'] : $insight['title']) . ' — Perspectives | BusinessDoctor';
$pageDescription = !empty($insight['seo_description']) ? $insight['seo_description'] : (!empty($insight['excerpt']) ? $insight['excerpt'] : $insight['summary']);

$canonicalUrl = !empty($insight['canonical_url']) ? $insight['canonical_url'] : ('https://businessdoctor.com/insights/' . rawurlencode($insight['slug']));
$markdownUrl = 'https://businessdoctor.com/content-md/blogs/' . rawurlencode($insight['slug']) . '.md';
$schemaPageKey = 'insight-detail';
$schemaContextData = $insight;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container" style="max-width: 900px;">
    <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem; flex-wrap: wrap;">
      <span class="eyebrow-badge" style="margin-bottom: 0;"><?= e($insight['category']) ?></span>
      <span style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-secondary); font-weight: 700;"><?= e($insight['reading_time']) ?></span>
      <span style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-text-light);">● <?= formatExecutiveDate($insight['published_at'] ?? 'now') ?></span>
    </div>

    <h1 class="hero-headline-oversized" style="font-size: clamp(2.2rem, 4vw, 3.4rem); margin-bottom: 1.5rem;">
      <?= e($insight['title']) ?>
    </h1>

    <div style="display: flex; align-items: center; gap: 1rem; border-top: 1px solid var(--color-slate-200); padding-top: 1.5rem; margin-top: 2rem; flex-wrap: wrap;">
      <div style="width: 48px; height: 48px; border-radius: var(--radius-sm); background: var(--color-primary); color: var(--color-accent); font-family: var(--font-display); font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; border: 1px solid rgba(161, 126, 145,0.3);">
        <?= strtoupper(substr($insight['author'] ?: $insight['author_name'], 0, 2)) ?>
      </div>
      <div>
        <div style="font-family: var(--font-display); font-weight: 700; color: var(--color-text); font-size: 1.05rem;"><?= e($insight['author'] ?: $insight['author_name']) ?></div>
        <div style="font-size: 0.82rem; color: var(--color-text-light); font-family: var(--font-mono);"><?= e($insight['author_title']) ?></div>
      </div>
    </div>
  </div>
</section>

<!-- Article Body -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container" style="max-width: 900px;">
    <?php if (!empty($insight['featured_image'])): ?>
      <div style="margin-bottom: 2.5rem; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-slate-200); box-shadow: var(--shadow-md);">
        <img src="<?= e($insight['featured_image']) ?>" alt="<?= e($insight['title']) ?>" style="width: 100%; max-height: 440px; object-fit: cover; display: block;">
      </div>
    <?php endif; ?>

    <!-- Abstract Box -->
    <div style="background: var(--color-bg); border: 1px solid var(--color-slate-200); border-left: 4px solid var(--color-secondary); border-radius: var(--radius-lg); padding: 2.25rem; margin-bottom: 3.5rem;">
      <div style="font-size: 0.78rem; font-family: var(--font-mono); text-transform: uppercase; color: var(--color-secondary); letter-spacing: 0.1em; margin-bottom: 0.75rem; font-weight: 700;">
        KEY EXECUTIVE SUMMARY
      </div>
      <p style="font-size: 1.1rem; line-height: 1.7; color: var(--color-text); margin: 0; font-style: italic;">
        <?= e(!empty($insight['excerpt']) ? $insight['excerpt'] : $insight['summary']) ?>
      </p>
    </div>

    <!-- Main Editorial Text -->
    <div style="font-size: 1.15rem; line-height: 1.85; color: var(--color-text);">
      <?= nl2br(e($insight['content'])) ?>
    </div>

    <!-- Post Article CTA -->
    <div class="enterprise-hud-card" style="margin-top: 4.5rem; padding: 3rem; text-align: center;">
      <h3 style="color: #ffffff; font-size: 1.6rem; margin-bottom: 0.75rem;">Need Help Modernizing Your Digital Architecture?</h3>
      <p style="color: rgba(255,255,255,0.85); font-size: 1.05rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        Get a complimentary website and digital audit from our senior technical architects.
      </p>
      <a href="audit.php" class="btn btn-accent btn-lg">
        <span>Request Free Technical Audit</span>
        <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
    </div>

    <div style="margin-top: 3.5rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-200); padding-top: 2rem;">
      <a href="insights.php" class="case-card-action">
        <span>&larr; Back to All Perspectives</span>
      </a>
      <a href="contact.php" class="btn btn-secondary">
        <span>Contact Author / Tech Team</span>
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
