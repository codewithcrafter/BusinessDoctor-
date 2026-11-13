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
$relatedInsights = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM insights WHERE slug = ? AND status = 'published' AND is_deleted = 0 LIMIT 1");
    $stmt->execute([$slug]);
    $insight = $stmt->fetch();

    if ($insight) {
        $relStmt = $pdo->prepare("SELECT * FROM insights WHERE id != ? AND status = 'published' AND is_deleted = 0 ORDER BY id DESC LIMIT 2");
        $relStmt->execute([(int)$insight['id']]);
        $relatedInsights = $relStmt->fetchAll();
    }
} catch (Exception $e) {}

if (!$insight) {
    header("Location: " . appUrl('insights.php'));
    exit;
}

$pageTitle = (!empty($insight['seo_title']) ? $insight['seo_title'] : $insight['title']) . ' — BusinessDoctor Blog';
$pageDescription = !empty($insight['seo_description']) ? $insight['seo_description'] : (!empty($insight['excerpt']) ? $insight['excerpt'] : $insight['summary']);
$canonicalUrl = getInsightUrl($insight['slug']);

$schemaPageKey = 'insight-detail';
$schemaContextData = $insight;

/**
 * Helper to resolve relevant local professional fallback dummy image if missing
 */
if (!function_exists('getBlogAssetUrl')) {
    function getBlogAssetUrl(string $path): string
    {
        $cleanPath = ltrim($path, '/');
        $segments = explode('/', $cleanPath);
        $encoded = array_map('rawurlencode', $segments);
        return appUrl(implode('/', $encoded));
    }
}

if (!function_exists('getBlogImageFallback')) {
    function getBlogImageFallback(array $item): array
    {
        $img = !empty($item['featured_image']) ? trim($item['featured_image']) : '';
        $alt = !empty($item['cover_image_alt']) ? trim($item['cover_image_alt']) : '';

        // Check if existing referenced file exists on disk
        if (empty($img) || !file_exists(ROOT_PATH . '/' . ltrim($img, '/'))) {
            $cat = strtolower((string)($item['category'] ?? ''));
            $slug = strtolower((string)($item['slug'] ?? ''));
            $title = strtolower((string)($item['title'] ?? ''));
            $haystack = $cat . ' ' . $slug . ' ' . $title;

            if (str_contains($haystack, 'ai') || str_contains($haystack, 'auto') || str_contains($haystack, 'agent') || str_contains($haystack, 'llm')) {
                $img = 'assets/img/blog/ai-automation-architecture.svg';
                if (empty($alt)) $alt = 'Agentic Workflow Pipeline & LLM Inference Orchestration Diagram';
            } elseif (str_contains($haystack, 'cloud') || str_contains($haystack, 'edge') || str_contains($haystack, 'infra') || str_contains($haystack, 'serverless')) {
                $img = 'assets/img/blog/cloud-edge-infrastructure.svg';
                if (empty($alt)) $alt = 'Global Distributed Edge Network & Low-Latency Routing Topology';
            } elseif (str_contains($haystack, 'architect') || str_contains($haystack, 'microservice') || str_contains($haystack, 'backend') || str_contains($haystack, 'api')) {
                $img = 'assets/img/blog/software-architecture-microservices.svg';
                if (empty($alt)) $alt = 'Event-Driven Microservices & Resilient Database Topology Schematic';
            } elseif (str_contains($haystack, 'ux') || str_contains($haystack, 'ui') || str_contains($haystack, 'brand') || str_contains($haystack, 'design')) {
                $img = 'assets/img/blog/ui-ux-design-system.svg';
                if (empty($alt)) $alt = 'Design Token Architecture & Component Accessibility Hierarchy';
            } elseif (str_contains($haystack, 'seo') || str_contains($haystack, 'search') || str_contains($haystack, 'rank') || str_contains($haystack, 'marketing')) {
                $img = 'assets/img/blog/seo-growth-analytics.svg';
                if (empty($alt)) $alt = 'Algorithmic Organic Search Crawl Topology & Schema Graph';
            } elseif (str_contains($haystack, 'dev') || str_contains($haystack, 'web') || str_contains($haystack, 'vitals') || str_contains($haystack, 'speed') || str_contains($haystack, 'headless')) {
                $img = 'assets/img/blog/web-development-headless.svg';
                if (empty($alt)) $alt = 'Decoupled Headless Engineering vs. Legacy Monolithic Infrastructure';
            } else {
                $img = 'assets/img/blog/business-strategy-funnel.svg';
                if (empty($alt)) $alt = 'Enterprise LTV-to-CAC Ratio & Conversion Yield Architecture Schematic';
            }
        }

        if (empty($alt)) {
            $alt = $item['title'] ?? 'BusinessDoctor Technical Blog';
        }

        return [$img, $alt];
    }
}

[$coverImg, $coverAlt] = getBlogImageFallback($insight);

require_once __DIR__ . '/includes/header.php';
?>

<style>
  /* Blog Detail Scoped Media & Alignment */
  .article-cover-figure {
    margin: 0 0 3.5rem 0;
    width: 100%;
  }
  .article-cover-figure .media-frame {
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid var(--color-slate-200);
    box-shadow: var(--shadow-md);
    background: #071224;
    width: 100%;
    aspect-ratio: 16 / 9;
  }
  .article-cover-figure img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
    aspect-ratio: 16 / 9;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
  }
  .related-card {
    padding: 0 !important;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: var(--radius-lg);
    border: 1px solid var(--color-slate-200);
    background: var(--color-card-bg);
    box-shadow: var(--shadow-sm);
    width: 100%;
    box-sizing: border-box;
  }
  .related-card-media {
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: #071224;
    margin: 0;
    padding: 0;
    display: block;
  }
  .related-card-media img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
    aspect-ratio: 16 / 9;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
  }
  .related-card-body {
    padding: 1.75rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    box-sizing: border-box;
  }
  @media (max-width: 768px) {
    .related-card-body {
      padding: 1.25rem;
    }
  }
</style>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 3.5rem;">
  <div class="container" style="max-width: 940px;">
    <!-- Breadcrumb & Badges -->
    <nav aria-label="Breadcrumb" style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 1.25rem; font-family: var(--font-mono); font-size: 0.82rem;">
      <a href="<?= appUrl('') ?>" class="text-link" style="color: var(--color-text-muted); text-decoration: none;">Home</a>
      <span style="color: rgba(255,255,255,0.3);">&gt;</span>
      <a href="<?= appUrl('insights.php') ?>" class="text-link" style="color: #06B5F9; text-decoration: none; font-weight: 600;">Blog</a>
      <span style="color: rgba(255,255,255,0.3);">&gt;</span>
      <span style="color: var(--color-text-light); max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= e($insight['title']) ?></span>
      <span style="margin-left: 0.5rem;" class="eyebrow-badge"><?= e($insight['category']) ?></span>
      <span style="font-family: var(--font-mono); font-size: 0.8rem; color: #06B5F9; font-weight: 700;"><?= e($insight['reading_time']) ?></span>
      <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-text-light);">● <?= formatExecutiveDate($insight['published_at'] ?? 'now') ?></span>
    </nav>

    <!-- Title & Subtitle -->
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.2rem, 4vw, 3.4rem); margin-bottom: 1.25rem; line-height: 1.25;">
      <?= e($insight['title']) ?>
    </h1>
    <?php if (!empty($insight['summary'])): ?>
      <p style="font-size: 1.18rem; color: var(--color-text-light); line-height: 1.65; max-width: 860px; margin-bottom: 2rem;">
        <?= e($insight['summary']) ?>
      </p>
    <?php endif; ?>

    <!-- Author Byline Bar -->
    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--color-slate-200); padding-top: 1.5rem; margin-top: 1rem; flex-wrap: wrap; gap: 1rem;">
      <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="width: 48px; height: 48px; border-radius: var(--radius-sm); background: rgba(6, 181, 249, 0.12); color: #06B5F9; font-family: var(--font-display); font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; border: 1px solid rgba(6, 181, 249, 0.35);">
          <?= strtoupper(substr($insight['author'] ?: $insight['author_name'], 0, 2)) ?>
        </div>
        <div>
          <div style="font-family: var(--font-display); font-weight: 700; color: var(--color-text); font-size: 1.05rem;"><?= e($insight['author'] ?: $insight['author_name']) ?></div>
          <div style="font-size: 0.82rem; color: var(--color-text-muted); font-family: var(--font-mono);"><?= e($insight['author_title']) ?></div>
        </div>
      </div>

      <!-- Social Share Buttons -->
      <div style="display: flex; align-items: center; gap: 0.5rem;">
        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($canonicalUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" title="Share on LinkedIn" style="padding: 0.45rem 0.75rem;">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9h2.8v8.37h-2.8v-8.37M7.86 6.81a1.63 1.63 0 0 0-1.63 1.63c0 .9.73 1.63 1.63 1.63.9 0 1.63-.73 1.63-1.63 0-.9-.73-1.63-1.63-1.63z"/></svg>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonicalUrl) ?>&text=<?= urlencode($insight['title']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" title="Share on X / Twitter" style="padding: 0.45rem 0.75rem;">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <button type="button" class="btn btn-secondary btn-sm" onclick="navigator.clipboard.writeText('<?= $canonicalUrl ?>'); alert('Article URL copied to clipboard.');" title="Copy Link" style="padding: 0.45rem 0.75rem;">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Article Deep Dive -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container" style="max-width: 900px;">
    
    <!-- Large Cover Image Exhibit (16:9 Full-Width Featured Cover) -->
    <figure class="article-cover-figure">
      <div class="media-frame">
        <img src="<?= getBlogAssetUrl($coverImg) ?>" alt="<?= e($coverAlt) ?>" loading="eager">
      </div>
      <figcaption style="margin-top: 0.85rem; font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-muted); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
        <span><?= e($coverAlt) ?></span>
        <span style="color: #06B5F9; font-weight: 700; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3);">
          FEATURED ANALYSIS COVER
        </span>
      </figcaption>
    </figure>

    <!-- Executive Summary Box -->
    <div style="background: var(--color-card-bg); border: 1px solid var(--color-slate-200); border-left: 4px solid #06B5F9; border-radius: var(--radius-lg); padding: 2.25rem; margin-bottom: 3.5rem; box-shadow: var(--shadow-sm);">
      <div style="font-size: 0.78rem; font-family: var(--font-mono); text-transform: uppercase; color: #06B5F9; letter-spacing: 0.1em; margin-bottom: 0.75rem; font-weight: 700;">
        KEY EXECUTIVE SUMMARY
      </div>
      <p style="font-size: 1.1rem; line-height: 1.75; color: var(--color-text); margin: 0; font-style: italic;">
        <?= e(!empty($insight['excerpt']) ? $insight['excerpt'] : $insight['summary']) ?>
      </p>
    </div>

    <!-- Article Content Stream -->
    <div class="article-editorial-body" style="font-size: 1.12rem; line-height: 1.85; color: var(--color-text);">
      <?php 
        $text = e($insight['content']);
        // Convert ## Header to h2
        $text = preg_replace('/^##\s+(.+)$/m', '<h2 style="font-size: 1.75rem; font-weight: 800; color: var(--color-text); margin-top: 2.75rem; margin-bottom: 1.25rem; line-height: 1.3;">$1</h2>', $text);
        // Convert ### Header to h3
        $text = preg_replace('/^###\s+(.+)$/m', '<h3 style="font-size: 1.35rem; font-weight: 700; color: var(--color-text); margin-top: 2rem; margin-bottom: 1rem;">$1</h3>', $text);
        // Convert **bold**
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        // Convert - Bullet lists
        $text = preg_replace('/^-\s+(.+)$/m', '<li style="margin-bottom: 0.5rem;">$1</li>', $text);
        // Wrap adjacent li in ul
        $text = preg_replace('/(<li.*?>.*?<\/li>\s*)+/s', '<ul style="padding-left: 1.5rem; margin: 1.25rem 0;">$0</ul>', $text);
        // Support images intentionally inserted by admin inside article content via markdown ![alt](src)
        $text = preg_replace_callback('/!\[([^\]]*)\]\(([^)]+)\)/', function($m) {
            $alt = htmlspecialchars($m[1]);
            $src = getAssetUrl($m[2]);
            return '<figure style="margin: 2.5rem 0; width: 100%;"><div style="border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-slate-200); box-shadow: var(--shadow-md); background: #071224; aspect-ratio: 16 / 9;"><img src="' . $src . '" alt="' . $alt . '" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy"></div>' . (!empty($alt) ? '<figcaption style="margin-top: 0.85rem; font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-muted);">' . $alt . '</figcaption>' : '') . '</figure>';
        }, $text);

        echo nl2br($text);
      ?>
    </div>

    <!-- Author Profile Card -->
    <div class="card" style="margin-top: 4.5rem; padding: 2.25rem 2.5rem; background: var(--color-card-bg); border: 1px solid var(--color-slate-200); border-radius: var(--radius-xl); display: flex; align-items: center; gap: 1.75rem; flex-wrap: wrap;">
      <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(6, 181, 249, 0.12); color: #06B5F9; font-family: var(--font-display); font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 2px solid rgba(6, 181, 249, 0.4); flex-shrink: 0;">
        <?= strtoupper(substr($insight['author'] ?: $insight['author_name'], 0, 2)) ?>
      </div>
      <div style="flex: 1; min-width: 240px;">
        <div style="font-family: var(--font-display); font-weight: 800; font-size: 1.2rem; color: var(--color-text);"><?= e($insight['author'] ?: $insight['author_name']) ?></div>
        <div style="font-family: var(--font-mono); font-size: 0.82rem; color: #06B5F9; font-weight: 700; margin-bottom: 0.5rem;"><?= e($insight['author_title']) ?></div>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Specializes in enterprise software engineering architectures, algorithmic performance marketing, and Core Web Vitals optimization at BusinessDoctor.
        </p>
      </div>
    </div>

    <!-- Related Articles Grid (Related Blogs) -->
    <?php if (!empty($relatedInsights)): ?>
      <div style="border-top: 1px solid var(--color-slate-200); padding-top: 3.5rem; margin-top: 3.5rem;">
        <h3 style="font-size: 1.45rem; font-weight: 800; color: var(--color-text); margin-bottom: 1.75rem;">
          Related Blogs
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem; width: 100%;">
          <?php foreach ($relatedInsights as $ri): 
            [$riImg, $riAlt] = getBlogImageFallback($ri);
          ?>
            <div class="card related-card">
              <div class="related-card-media">
                <a href="<?= getInsightUrl($ri['slug']) ?>" style="display: block; width: 100%; height: 100%; text-decoration: none;" aria-label="<?= e($ri['title']) ?>">
                  <img src="<?= getBlogAssetUrl($riImg) ?>" alt="<?= e($riAlt) ?>" loading="lazy">
                </a>
              </div>
              <div class="related-card-body">
                <span class="eyebrow-badge" style="margin-bottom: 0.75rem; font-size: 0.68rem; align-self: flex-start;">
                  <?= e($ri['category']) ?>
                </span>
                <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--color-text); line-height: 1.4; margin-bottom: 0.75rem;">
                  <a href="<?= getInsightUrl($ri['slug']) ?>" style="color: var(--color-text); text-decoration: none;">
                    <?= e($ri['title']) ?>
                  </a>
                </h4>
                <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin-bottom: 1.25rem; flex-grow: 1;">
                  <?= e(mb_strimwidth($ri['summary'], 0, 120, '...')) ?>
                </p>
                <a href="<?= getInsightUrl($ri['slug']) ?>" class="btn btn-secondary btn-sm" style="align-self: flex-start; display: inline-flex; align-items: center; gap: 0.35rem;">
                  <span>Read Blog</span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Closing Consultation CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 3rem; padding-bottom: 4rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Need Guidance Modernizing Your Digital Architecture?</h2>
        <p class="closing-cta-lead">
          Connect directly with our senior technology architects to evaluate your existing codebase, audit digital speed, and plan scalable optimizations.
        </p>
        <div class="closing-cta-buttons">
          <a href="<?= appUrl('audit.php') ?>" class="btn btn-accent btn-lg">
            <span>Request Free Technical Audit</span>
          </a>
          <a href="<?= appUrl('contact.php') ?>" class="btn btn-outline-gold btn-lg">
            <span>Consult Our Practice Leads</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
