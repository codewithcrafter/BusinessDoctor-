<?php
/**
 * BusinessDoctor Perspectives & Insights Directory - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Technical Blog. Strategic Frameworks. — BusinessDoctor Enterprise IT';
$pageDescription = 'Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.';
$canonicalUrl = appUrl('insights.php');

$selectedCategory = trim($_GET['category'] ?? '');
$searchQuery = trim($_GET['search'] ?? '');

$insights = [];
$featured = null;
try {
    $pdo = Database::getConnection();
    
    $sql = "SELECT * FROM insights WHERE status = 'published' AND is_deleted = 0";
    $params = [];

    if ($selectedCategory !== '') {
        $sql .= " AND category = ?";
        $params[] = $selectedCategory;
    }

    if ($searchQuery !== '') {
        $sql .= " AND (title LIKE ? OR summary LIKE ? OR content LIKE ?)";
        $searchParam = '%' . $searchQuery . '%';
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }

    $sql .= " ORDER BY published_at DESC, id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $insights = $stmt->fetchAll();

    if (!empty($insights) && empty($selectedCategory) && empty($searchQuery)) {
        $featured = array_shift($insights);
    }
} catch (Exception $e) {}

$categories = [
    'All' => '',
    'Web & Digital Strategy' => 'Web & Digital Strategy',
    'Web Development' => 'Web Development',
    'UI/UX & Branding' => 'UI/UX & Branding'
];

/**
 * Helper to resolve URL for blog assets with safe percent-encoding
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

/**
 * Helper to resolve relevant local professional fallback dummy image if missing
 */
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

require_once __DIR__ . '/includes/header.php';
?>

<style>
  /* Scoped Full-Width Blog Card & Image Styles */
  .blog-spotlight-card,
  .blog-card {
    padding: 0 !important;
    overflow: hidden;
    box-sizing: border-box;
    width: 100%;
  }

  .blog-spotlight-media,
  .blog-card-media {
    position: relative;
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden;
    display: block;
  }

  .blog-card-media {
    aspect-ratio: 16 / 9;
  }

  .blog-card-media a,
  .blog-spotlight-media a {
    display: block;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
  }

  .blog-card-media img,
  .blog-spotlight-media img {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    aspect-ratio: 16 / 9;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
  }

  .blog-card-body {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    box-sizing: border-box;
  }

  @media (max-width: 768px) {
    .blog-card-body {
      padding: 1.5rem 1.25rem;
    }
    .blog-spotlight-card > div {
      grid-template-columns: 1fr !important;
    }
    .blog-spotlight-media {
      min-height: 220px !important;
      aspect-ratio: 16 / 9;
    }
  }
</style>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 3.5rem;">
  <div class="container text-center" style="max-width: 900px; margin: 0 auto;">
    <div class="eyebrow-badge">
      <span class="pill-dot"></span>
      <span>ENGINEERING PERSPECTIVES &amp; BLOG</span>
    </div>
    <h1 class="hero-headline-oversized" style="font-size: clamp(2.3rem, 4.5vw, 3.8rem); margin-top: 1rem; margin-bottom: 1.25rem;">
      Technical Blog. <br><span style="color: #06B5F9;">Strategic Frameworks.</span>
    </h1>
    <p class="hero-lead-text" style="max-width: 780px; margin: 0 auto 2rem;">
      Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.
    </p>

    <!-- Category Filters & Search -->
    <div style="display: flex; gap: 0.75rem; justify-content: center; align-items: center; flex-wrap: wrap; margin-top: 2rem;">
      <?php foreach ($categories as $catLabel => $catVal): 
        $isActive = ($selectedCategory === $catVal);
        $url = empty($catVal) ? appUrl('insights.php') : appUrl('insights.php?category=' . urlencode($catVal));
      ?>
        <a href="<?= $url ?>" class="btn <?= $isActive ? 'btn-primary' : 'btn-secondary' ?> btn-sm" style="font-size: 0.82rem;">
          <?= htmlspecialchars($catLabel) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Main Editorial Section -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); padding-top: 3.5rem; padding-bottom: 5rem;">
  <div class="container">

    <!-- Featured Spotlight Article -->
    <?php if ($featured): 
      $featUrl = getInsightUrl($featured['slug']);
      [$featImg, $featAlt] = getBlogImageFallback($featured);
    ?>
      <div class="card blog-spotlight-card" style="padding: 0 !important; margin-bottom: 3.5rem; overflow: hidden; border-radius: var(--radius-xl); border: 1px solid var(--color-slate-200); background: var(--color-card-bg); box-shadow: var(--shadow-md); width: 100%;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); align-items: stretch; margin: 0; padding: 0;">
          
          <!-- Full-Width Visual Cover Container (Zero Inner Padding) -->
          <div class="blog-spotlight-media" style="position: relative; width: 100%; height: 100%; min-height: 320px; background: #071224; overflow: hidden; margin: 0; padding: 0; display: flex;">
            <a href="<?= $featUrl ?>" style="display: block; width: 100%; height: 100%; margin: 0; padding: 0; text-decoration: none;" aria-label="<?= e($featured['title']) ?>">
              <img src="<?= getBlogAssetUrl($featImg) ?>" alt="<?= e($featAlt) ?>" style="display: block; width: 100%; height: 100%; object-fit: cover; aspect-ratio: 16 / 9; margin: 0; padding: 0; border: 0;">
            </a>
            <div style="position: absolute; top: 1rem; left: 1rem; pointer-events: none;">
              <span class="eyebrow-badge" style="background: rgba(6, 19, 38, 0.92); backdrop-filter: blur(8px); border-color: rgba(6, 181, 249, 0.45); font-size: 0.7rem; margin: 0;">
                FEATURED BLOG
              </span>
            </div>
            <div style="position: absolute; bottom: 0.75rem; right: 0.75rem; pointer-events: none;">
              <span style="background: rgba(15, 23, 42, 0.88); color: #94A3B8; font-family: var(--font-mono); font-size: 0.68rem; padding: 0.25rem 0.5rem; border-radius: 4px; border: 1px solid rgba(255,255,255,0.12);">
                ILLUSTRATIVE SCHEMATIC
              </span>
            </div>
          </div>

          <!-- Content Details -->
          <div style="padding: 2.75rem; display: flex; flex-direction: column; justify-content: center;">
            <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1rem; flex-wrap: wrap;">
              <span class="eyebrow-badge" style="margin-bottom: 0; font-size: 0.72rem;"><?= e($featured['category']) ?></span>
              <span style="font-family: var(--font-mono); font-size: 0.8rem; color: #06B5F9; font-weight: 700;"><?= e($featured['reading_time']) ?></span>
              <span style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--color-text-muted);">● <?= formatExecutiveDate($featured['published_at'] ?? 'now') ?></span>
            </div>
            <h2 style="font-size: clamp(1.6rem, 2.6vw, 2.2rem); font-weight: 800; color: var(--color-text); line-height: 1.3; margin-bottom: 1rem;">
              <a href="<?= $featUrl ?>" style="color: var(--color-text); text-decoration: none;">
                <?= e($featured['title']) ?>
              </a>
            </h2>
            <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.75rem;">
              <?= e($featured['summary']) ?>
            </p>
            <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--color-slate-200); padding-top: 1.25rem; margin-top: auto; flex-wrap: wrap; gap: 1rem;">
              <div>
                <div style="font-weight: 700; font-size: 0.95rem; color: var(--color-text);"><?= e($featured['author_name']) ?></div>
                <div style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-muted);"><?= e($featured['author_title']) ?></div>
              </div>
              <a href="<?= $featUrl ?>" class="btn btn-accent btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>Read Full Analysis</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Editorial Article Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2.25rem; width: 100%;">
      <?php if (!empty($insights)): ?>
        <?php foreach ($insights as $item): 
          $itemUrl = getInsightUrl($item['slug']);
          [$itemImg, $itemAlt] = getBlogImageFallback($item);
        ?>
          <article class="card blog-card" style="padding: 0 !important; margin: 0; display: flex; flex-direction: column; overflow: hidden; border-radius: var(--radius-lg); border: 1px solid var(--color-slate-200); background: var(--color-card-bg); box-shadow: var(--shadow-sm); width: 100%; box-sizing: border-box;">
            
            <!-- Full-Width Featured Image (100% of Card Width, 16:9 Aspect Ratio, Zero Inner Padding) -->
            <div class="blog-card-media" style="position: relative; width: 100%; aspect-ratio: 16 / 9; background: #071224; margin: 0; padding: 0; overflow: hidden; display: block;">
              <a href="<?= $itemUrl ?>" style="display: block; width: 100%; height: 100%; margin: 0; padding: 0; text-decoration: none;" aria-label="<?= e($item['title']) ?>">
                <img src="<?= getBlogAssetUrl($itemImg) ?>" alt="<?= e($itemAlt) ?>" style="display: block; width: 100%; height: 100%; aspect-ratio: 16 / 9; object-fit: cover; margin: 0; padding: 0; border: 0;" loading="lazy">
              </a>
              <div style="position: absolute; top: 1rem; left: 1rem; pointer-events: none;">
                <span class="eyebrow-badge" style="background: rgba(6, 19, 38, 0.90); backdrop-filter: blur(8px); border-color: rgba(6, 181, 249, 0.35); font-size: 0.7rem; margin: 0;">
                  <?= e($item['category']) ?>
                </span>
              </div>
              <div style="position: absolute; bottom: 0.6rem; right: 0.6rem; pointer-events: none;">
                <span style="background: rgba(15, 23, 42, 0.88); color: #94A3B8; font-family: var(--font-mono); font-size: 0.65rem; padding: 0.2rem 0.45rem; border-radius: 4px; border: 1px solid rgba(255,255,255,0.12);">
                  ILLUSTRATIVE
                </span>
              </div>
            </div>

            <!-- Card Body Content Container -->
            <div class="blog-card-body" style="padding: 2rem; display: flex; flex-direction: column; flex-grow: 1;">
              <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-muted);">
                <span><?= e($item['reading_time']) ?></span>
                <span>●</span>
                <span><?= formatExecutiveDate($item['published_at'] ?? 'now') ?></span>
              </div>

              <h2 style="font-size: 1.3rem; font-weight: 800; color: var(--color-text); line-height: 1.35; margin-bottom: 0.85rem;">
                <a href="<?= $itemUrl ?>" style="color: var(--color-text); text-decoration: none;">
                  <?= e($item['title']) ?>
                </a>
              </h2>

              <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin-bottom: 1.5rem; flex-grow: 1;">
                <?= e(mb_strimwidth($item['summary'], 0, 150, '...')) ?>
              </p>

              <div style="border-top: 1px solid var(--color-slate-200); padding-top: 1.25rem; margin-top: auto; display: flex; align-items: center; justify-content: space-between;">
                <div>
                  <div style="font-size: 0.85rem; font-weight: 700; color: var(--color-text);"><?= e($item['author_name']) ?></div>
                  <div style="font-size: 0.72rem; color: var(--color-text-muted); font-family: var(--font-mono);"><?= e($item['author_title']) ?></div>
                </div>
                <a href="<?= $itemUrl ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                  <span>Read Article</span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php elseif (!$featured): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem;">
          <p style="color: var(--color-text-muted); font-size: 1.1rem;">No published articles found matching your criteria.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Executive Newsletter Briefing -->
<section class="section" style="background: var(--color-bg); padding-top: 3rem; padding-bottom: 4rem;">
  <div class="container text-center" style="max-width: 760px; margin: 0 auto;">
    <div class="card" style="padding: 2.75rem 2.25rem; background: var(--color-dark-surface); border-color: rgba(6, 181, 249, 0.25);">
      <div class="eyebrow-badge" style="margin-bottom: 0.75rem;">
        <span class="pill-dot"></span>
        <span>EXECUTIVE DIGITAL DISPATCH</span>
      </div>
      <h3 style="font-size: 1.85rem; color: #FFFFFF; font-weight: 800; margin-bottom: 0.75rem;">
        Bi-Weekly Engineering Blog
      </h3>
      <p style="color: var(--color-text-light); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.75rem;">
        Join technical executives receiving our private breakdowns on infrastructure scalability, Core Web Vitals, and conversion architecture.
      </p>
      <form class="newsletter-form" action="<?= appUrl('api/newsletter-subscribe.php') ?>" method="POST" style="max-width: 500px; margin: 0 auto; display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
        <input type="email" name="email" required placeholder="executive@enterprise.com" class="form-input" style="flex: 1; min-width: 240px; background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.2); color: #FFFFFF;">
        <button type="submit" class="btn btn-accent btn-md">Subscribe</button>
      </form>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
