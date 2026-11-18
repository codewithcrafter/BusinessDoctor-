<?php
/**
 * BusinessDoctor Tech Insight Deep-Dive View - Enterprise IT & Digital Services
 * Executive Editorial Perspective & Architectural Briefing
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$slug = trim($_GET['slug'] ?? '');

// 301 Permanent Redirect legacy URLs (/insights/{slug}, /insight-detail.php?slug=...) to canonical /blog/{slug}
$reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
if (str_starts_with($reqPath, '/insights/') || str_contains($reqPath, 'insight-detail.php')) {
    if ($slug !== '') {
        header("Location: " . getBlogUrl($slug), true, 301);
        exit;
    } else {
        header("Location: " . getBlogListingUrl(), true, 301);
        exit;
    }
}

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
    header("Location: " . getBlogListingUrl(), true, 301);
    exit;
}

$pageTitle = (!empty($insight['seo_title']) ? $insight['seo_title'] : $insight['title']) . ' — BusinessDoctor Blog';
$pageDescription = !empty($insight['seo_description']) ? $insight['seo_description'] : (!empty($insight['excerpt']) ? $insight['excerpt'] : $insight['summary']);
$canonicalUrl = getBlogUrl($insight['slug']);
$cleanMdUrl = appUrl('blog/' . $insight['slug'] . '.md');

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

// Parse tags list
$rawTags = trim((string)($insight['tags'] ?? ''));
$articleTags = [];
if ($rawTags !== '') {
    $articleTags = array_filter(array_map('trim', explode(',', $rawTags)));
}
// Fallback tags if database row is completely untagged
if (empty($articleTags)) {
    $cat = $insight['category'] ?? 'Enterprise Strategy';
    $articleTags = [$cat, 'Engineering Architecture', 'Digital Strategy', 'Business Transformation'];
}

$authorName = $insight['author'] ?: ($insight['author_name'] ?: 'BusinessDoctor Editorial Team');
$authorTitle = $insight['author_title'] ?: 'Principal Technology Architect & Growth Strategist';
$authorBio = !empty($insight['author_bio']) ? $insight['author_bio'] : 'Leads digital modernization, Core Web Vitals optimization, and high-performance revenue architecture at BusinessDoctor.';
$authorInitials = strtoupper(substr($authorName, 0, 2));

require_once __DIR__ . '/includes/header.php';
?>

<!-- Sticky Reading Progress Bar -->
<div id="reading-progress-bar" style="position: fixed; top: 0; left: 0; height: 3px; background: linear-gradient(90deg, #06B5F9 0%, #0099DB 50%, #38BDF8 100%); width: 0%; z-index: 99999; transition: width 0.1s ease-out; box-shadow: 0 0 10px rgba(6, 181, 249, 0.7);" aria-hidden="true"></div>

<!-- Toast Notification for Copy Link -->
<div id="copy-toast" style="position: fixed; bottom: 2rem; right: 2rem; background: #0A1D36; border: 1px solid #06B5F9; color: #FFFFFF; padding: 0.75rem 1.25rem; border-radius: 8px; font-family: var(--font-mono); font-size: 0.82rem; display: flex; align-items: center; gap: 0.6rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); z-index: 99999; opacity: 0; transform: translateY(10px); pointer-events: none; transition: all 0.25s ease;">
  <span style="color: #34D399; font-weight: 700;">✓</span>
  <span>Article link copied to clipboard</span>
</div>

<style>
  /* Executive Blog Detail Scoped Styles */
  .article-hero {
    position: relative;
    padding-top: 5rem;
    padding-bottom: 2.75rem;
    background: radial-gradient(circle at 50% 0%, rgba(6, 181, 249, 0.08) 0%, transparent 65%), #061326;
    border-bottom: 1px solid rgba(6, 181, 249, 0.12);
  }

  .article-hero-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
    font-family: var(--font-mono, monospace);
    font-size: 0.8rem;
  }
  .article-hero-breadcrumb a {
    color: #94A3B8;
    text-decoration: none;
    transition: color 0.15s ease;
  }
  .article-hero-breadcrumb a:hover {
    color: #06B5F9;
  }

  .article-badge-strip {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
  }

  .article-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(6, 181, 249, 0.12);
    border: 1px solid rgba(6, 181, 249, 0.35);
    color: #06B5F9;
    padding: 0.28rem 0.75rem;
    border-radius: 20px;
    font-family: var(--font-mono, monospace);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .article-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #CBD5E1;
    padding: 0.28rem 0.65rem;
    border-radius: 20px;
    font-family: var(--font-mono, monospace);
    font-size: 0.75rem;
  }

  .article-headline {
    font-family: var(--font-display, sans-serif);
    font-size: clamp(2.2rem, 3.8vw, 3.2rem);
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -0.025em;
    color: #FFFFFF;
    margin: 0;
  }

  /* TAGS DIRECTLY BELOW H1 */
  .article-hero-tags {
    display: flex;
    gap: 0.55rem;
    flex-wrap: wrap;
    align-items: center;
    margin-top: 1.35rem;
    margin-bottom: 0.25rem;
  }
  .article-hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: rgba(6, 181, 249, 0.08);
    border: 1px solid rgba(6, 181, 249, 0.28);
    color: #38BDF8;
    padding: 0.32rem 0.8rem;
    border-radius: 20px;
    font-family: var(--font-mono, monospace);
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .article-hero-tag .tag-hash {
    color: #06B5F9;
    font-weight: 700;
  }
  .article-hero-tag:hover {
    background: rgba(6, 181, 249, 0.2);
    border-color: #06B5F9;
    color: #FFFFFF;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(6, 181, 249, 0.25);
  }

  /* 2-Column Grid Layout */
  .blog-detail-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 350px;
    gap: 3rem;
    align-items: start;
    width: 100%;
  }

  .blog-main-content {
    min-width: 0;
  }

  .blog-sidebar-column {
    min-width: 0;
  }

  .blog-sidebar-sticky {
    position: sticky;
    top: 96px;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    z-index: 20;
  }

  /* Sidebar Consultation Form Card */
  .blog-sidebar-form-card {
    background: linear-gradient(145deg, #07192f 0%, #0c233f 100%);
    border: 1px solid rgba(6, 181, 249, 0.3);
    border-radius: 14px;
    padding: 1.6rem 1.4rem;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.45);
    position: relative;
    overflow: hidden;
  }
  .blog-sidebar-form-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #06B5F9, #38BDF8, #0099DB);
  }

  .sidebar-form-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-family: var(--font-mono, monospace);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #06B5F9;
    background: rgba(6, 181, 249, 0.1);
    border: 1px solid rgba(6, 181, 249, 0.25);
    padding: 0.2rem 0.55rem;
    border-radius: 4px;
    margin-bottom: 0.75rem;
  }
  .sidebar-form-badge .badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #06B5F9;
    box-shadow: 0 0 6px #06B5F9;
  }

  .sidebar-form-title {
    font-family: var(--font-display, sans-serif);
    font-size: 1.2rem;
    font-weight: 800;
    color: #FFFFFF;
    margin: 0 0 0.35rem 0;
    line-height: 1.3;
  }

  .sidebar-form-desc {
    font-size: 0.84rem;
    color: #94A3B8;
    line-height: 1.5;
    margin: 0 0 1.15rem 0;
  }

  .sidebar-form-group {
    margin-bottom: 0.85rem;
  }

  .sidebar-form-input {
    width: 100%;
    box-sizing: border-box;
    background: #040e1d;
    border: 1px solid rgba(6, 181, 249, 0.25);
    border-radius: 8px;
    padding: 0.65rem 0.85rem;
    color: #FFFFFF;
    font-size: 0.86rem;
    font-family: inherit;
    transition: all 0.2s ease;
  }
  .sidebar-form-input:focus {
    outline: none;
    border-color: #06B5F9;
    box-shadow: 0 0 0 3px rgba(6, 181, 249, 0.18);
    background: #06152a;
  }
  .sidebar-form-input::placeholder {
    color: #64748B;
    font-size: 0.82rem;
  }
  .sidebar-form-select {
    cursor: pointer;
  }
  .sidebar-form-select option {
    background: #07172C;
    color: #FFFFFF;
  }

  .sidebar-form-btn {
    width: 100%;
    background: linear-gradient(135deg, #06B5F9 0%, #0099DB 100%);
    border: none;
    border-radius: 8px;
    color: #040D1A;
    font-weight: 700;
    font-size: 0.9rem;
    padding: 0.75rem 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 15px rgba(6, 181, 249, 0.3);
    margin-top: 0.35rem;
  }
  .sidebar-form-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(6, 181, 249, 0.5);
    color: #000000;
  }
  .sidebar-form-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
  }

  .sidebar-form-msg {
    margin-top: 0.75rem;
    padding: 0.6rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8rem;
    line-height: 1.4;
  }
  .sidebar-form-msg.success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.4);
    color: #34D399;
  }
  .sidebar-form-msg.error {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #F87171;
  }

  .sidebar-privacy-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    font-size: 0.72rem;
    color: #64748B;
    margin-top: 0.75rem;
  }

  /* Scoped Sidebar TOC Styling */
  .blog-sidebar-column .page-toc-card {
    margin-bottom: 0 !important;
    padding: 1.35rem 1.4rem !important;
    background: linear-gradient(145deg, #07192f 0%, #0a223d 100%) !important;
    border: 1px solid rgba(6, 181, 249, 0.25) !important;
    border-radius: 14px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
    max-height: calc(100vh - 440px);
    overflow-y: auto;
  }
  .blog-sidebar-column .page-toc-card::-webkit-scrollbar {
    width: 4px;
  }
  .blog-sidebar-column .page-toc-card::-webkit-scrollbar-thumb {
    background: rgba(6, 181, 249, 0.35);
    border-radius: 3px;
  }
  .blog-sidebar-column .toc-title {
    font-size: 0.78rem !important;
    color: #FFFFFF !important;
  }
  .blog-sidebar-column .toc-link {
    font-size: 0.86rem !important;
    padding: 0.35rem 0.6rem !important;
    line-height: 1.4 !important;
  }
  .blog-sidebar-column .toc-sublink {
    font-size: 0.8rem !important;
    padding: 0.25rem 0.5rem !important;
  }

  /* Featured Cover Figure */
  .article-cover-figure {
    margin: 0 0 3rem 0;
    width: 100%;
  }
  .article-cover-frame {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(6, 181, 249, 0.25);
    box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.7), 0 0 30px rgba(6, 181, 249, 0.1);
    background: #071224;
    width: 100%;
    aspect-ratio: 16 / 9;
    position: relative;
  }
  .article-cover-frame img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
  }
  .article-cover-caption {
    margin-top: 0.85rem;
    font-family: var(--font-mono, monospace);
    font-size: 0.78rem;
    color: #94A3B8;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  /* Executive Summary Box */
  .executive-summary-card {
    background: linear-gradient(135deg, rgba(6, 181, 249, 0.08) 0%, rgba(10, 29, 54, 0.65) 100%);
    border: 1px solid rgba(6, 181, 249, 0.25);
    border-left: 4px solid #06B5F9;
    border-radius: 12px;
    padding: 1.75rem 2rem;
    margin-bottom: 3rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  }

  /* Editorial Content Stream */
  .article-editorial-body {
    font-size: 1.12rem;
    line-height: 1.85;
    color: #E2E8F0;
  }
  .article-editorial-body h2 {
    font-family: var(--font-display, sans-serif);
    font-size: clamp(1.6rem, 2.6vw, 2.1rem);
    font-weight: 800;
    color: #FFFFFF;
    margin-top: 3.25rem;
    margin-bottom: 1.25rem;
    line-height: 1.3;
    letter-spacing: -0.015em;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(6, 181, 249, 0.2);
    position: relative;
  }
  .article-editorial-body h2::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 60px;
    height: 2px;
    background: #06B5F9;
    box-shadow: 0 0 10px #06B5F9;
  }
  .article-editorial-body h3 {
    font-family: var(--font-display, sans-serif);
    font-size: 1.35rem;
    font-weight: 700;
    color: #F1F5F9;
    margin-top: 2.25rem;
    margin-bottom: 1rem;
    line-height: 1.4;
  }
  .article-editorial-body p {
    margin-bottom: 1.65rem;
  }
  .article-editorial-body strong {
    color: #FFFFFF;
    font-weight: 700;
  }
  .article-editorial-body a {
    color: #06B5F9;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.15s ease;
  }
  .article-editorial-body a:hover {
    color: #38BDF8;
  }
  .article-editorial-body ul, 
  .article-editorial-body ol {
    margin: 1.5rem 0 2rem 1.5rem;
    padding-left: 0.5rem;
  }
  .article-editorial-body li {
    margin-bottom: 0.75rem;
    line-height: 1.75;
  }
  .article-editorial-body blockquote {
    background: rgba(6, 181, 249, 0.05);
    border-left: 3px solid #06B5F9;
    border-radius: 0 8px 8px 0;
    padding: 1.35rem 1.75rem;
    margin: 2.25rem 0;
    font-style: italic;
    color: #CBD5E1;
    font-size: 1.15rem;
    line-height: 1.7;
  }
  .article-editorial-body pre {
    background: #040D1A;
    border: 1px solid rgba(6, 181, 249, 0.2);
    border-radius: 8px;
    padding: 1.25rem 1.5rem;
    overflow-x: auto;
    font-family: var(--font-mono, monospace);
    font-size: 0.88rem;
    color: #38BDF8;
    margin: 2rem 0;
  }
  .article-editorial-body code {
    font-family: var(--font-mono, monospace);
    background: rgba(6, 181, 249, 0.1);
    color: #06B5F9;
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
    font-size: 0.9em;
  }

  /* Author Profile Card */
  .article-author-card {
    margin-top: 3.5rem;
    padding: 2.25rem 2.5rem;
    background: linear-gradient(135deg, rgba(7, 26, 44, 0.9) 0%, rgba(13, 34, 58, 0.9) 100%);
    border: 1px solid rgba(6, 181, 249, 0.25);
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 1.75rem;
    flex-wrap: wrap;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
  }
  .article-author-avatar {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    background: rgba(6, 181, 249, 0.12);
    border: 1px solid rgba(6, 181, 249, 0.35);
    color: #06B5F9;
    font-family: var(--font-display, sans-serif);
    font-weight: 800;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 0 15px rgba(6, 181, 249, 0.2);
  }

  /* Bottom Share Bar */
  .article-bottom-share {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.5rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    margin-top: 2.5rem;
    flex-wrap: wrap;
  }
  .article-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #E2E8F0;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .article-action-btn:hover {
    background: rgba(6, 181, 249, 0.12);
    border-color: rgba(6, 181, 249, 0.4);
    color: #06B5F9;
    transform: translateY(-2px);
  }

  /* Related Cards */
  .related-card {
    padding: 0 !important;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    background: #081728;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    width: 100%;
    box-sizing: border-box;
    transition: transform 0.2s ease, border-color 0.2s ease;
  }
  .related-card:hover {
    transform: translateY(-4px);
    border-color: rgba(6, 181, 249, 0.4);
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
    transition: transform 0.3s ease;
  }
  .related-card:hover .related-card-media img {
    transform: scale(1.03);
  }
  .related-card-body {
    padding: 1.75rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    box-sizing: border-box;
  }

  /* Breakpoint adjustments */
  @media (max-width: 1024px) {
    .blog-detail-grid {
      grid-template-columns: minmax(0, 1fr) 320px;
      gap: 2rem;
    }
  }
  @media (max-width: 860px) {
    .blog-detail-grid {
      grid-template-columns: 1fr;
      gap: 2.5rem;
    }
    .blog-sidebar-sticky {
      position: static;
    }
    .blog-sidebar-column .page-toc-card {
      max-height: none;
    }
    .article-hero {
      padding-top: 3.5rem;
      padding-bottom: 2.5rem;
    }
    .article-author-card {
      padding: 1.5rem;
      flex-direction: column;
      align-items: flex-start;
    }
    .related-card-body {
      padding: 1.25rem;
    }
  }
</style>

<!-- Hero Section -->
<section class="article-hero">
  <div class="container" style="max-width: 1200px;">
    <!-- Breadcrumb -->
    <nav class="article-hero-breadcrumb" aria-label="Breadcrumb">
      <a href="<?= appUrl('') ?>">Home</a>
      <span style="color: #64748B;">/</span>
      <a href="<?= getBlogListingUrl() ?>">Blog</a>
      <span style="color: #64748B;">/</span>
      <span style="color: #06B5F9; font-weight: 600;"><?= e($insight['category']) ?></span>
    </nav>

    <!-- Badges Row -->
    <div class="article-badge-strip">
      <span class="article-category-badge">
        <span style="width: 6px; height: 6px; border-radius: 50%; background: #06B5F9; display: inline-block;"></span>
        <span><?= e($insight['category']) ?></span>
      </span>

      <span class="article-meta-pill">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span><?= e($insight['reading_time']) ?></span>
      </span>

      <span class="article-meta-pill">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <span><?= formatExecutiveDate($insight['published_at'] ?? 'now') ?></span>
      </span>

      <a href="<?= $cleanMdUrl ?>" target="_blank" class="article-meta-pill" style="color: #38BDF8; text-decoration: none; border-color: rgba(6, 181, 249, 0.3);" title="Machine-readable Markdown representation for LLMs">
        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        <span>.md Endpoint ↗</span>
      </a>
    </div>

    <!-- Article Headline -->
    <h1 class="article-headline">
      <?= e($insight['title']) ?>
    </h1>

    <!-- Article Tags Placed Directly Below H1 -->
    <?php if (!empty($articleTags)): ?>
      <div class="article-hero-tags">
        <?php foreach ($articleTags as $tag): ?>
          <a href="<?= getBlogListingUrl() ?>?search=<?= urlencode($tag) ?>" class="article-hero-tag" title="Search articles tagged <?= e($tag) ?>">
            <span class="tag-hash">#</span><span><?= e($tag) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Article Deep Dive Content Section (2-Column Layout) -->
<section class="section" style="background-color: #07172C; padding-top: 3.5rem; padding-bottom: 5rem;">
  <div class="container" style="max-width: 1200px;">
    
    <div class="blog-detail-grid">
      <!-- Main Content Column (Left) -->
      <article class="blog-main-content">
        <!-- Large Cover Image Exhibit (16:9 Full-Width Featured Cover) -->
        <figure class="article-cover-figure">
          <div class="article-cover-frame">
            <img src="<?= getBlogAssetUrl($coverImg) ?>" alt="<?= e($coverAlt) ?>" width="1280" height="720" loading="eager">
          </div>
          <figcaption class="article-cover-caption">
            <span><?= e($coverAlt) ?></span>
            <span style="color: #06B5F9; font-weight: 700; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.6rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3);">
              EXECUTIVE BRIEFING // ARCHITECTURAL SCHEMATIC
            </span>
          </figcaption>
        </figure>

        <!-- Executive Summary Box -->
        <div class="executive-summary-card">
          <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.76rem; font-family: var(--font-mono); text-transform: uppercase; color: #06B5F9; letter-spacing: 0.1em; margin-bottom: 0.85rem; font-weight: 700;">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span>KEY EXECUTIVE BRIEFING &amp; IMPLICATIONS</span>
          </div>
          <p style="font-size: 1.12rem; line-height: 1.75; color: #F1F5F9; margin: 0; font-style: italic;">
            <?= e(!empty($insight['excerpt']) ? $insight['excerpt'] : $insight['summary']) ?>
          </p>
        </div>

        <!-- Article Content Stream -->
        <div class="article-editorial-body">
          <?= renderBlogContent($insight['content'] ?? '') ?>
        </div>

        <!-- Bottom Author Profile Card -->
        <div class="article-author-card">
          <div class="article-author-avatar">
            <?= e($authorInitials) ?>
          </div>
          <div style="flex: 1; min-width: 240px;">
            <div style="font-family: var(--font-display); font-weight: 800; font-size: 1.25rem; color: #FFFFFF; line-height: 1.3;">
              <?= e($authorName) ?>
            </div>
            <div style="font-family: var(--font-mono); font-size: 0.82rem; color: #06B5F9; font-weight: 700; margin-top: 0.2rem; margin-bottom: 0.65rem;">
              <?= e($authorTitle) ?>
            </div>
            <p style="font-size: 0.94rem; color: #94A3B8; line-height: 1.65; margin: 0;">
              <?= e($authorBio) ?>
            </p>
          </div>
          <div style="align-self: center;">
            <a href="<?= appUrl('contact') ?>" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; white-space: nowrap;">
              <span>Consult Author</span>
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
          </div>
        </div>

        <!-- Bottom Share Bar -->
        <div class="article-bottom-share">
          <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <span style="font-family: var(--font-mono); font-size: 0.76rem; color: #94A3B8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;">SHARE BRIEFING:</span>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($canonicalUrl) ?>" target="_blank" rel="noopener noreferrer" class="article-action-btn" title="Share on LinkedIn" aria-label="Share on LinkedIn">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9h2.8v8.37h-2.8v-8.37M7.86 6.81a1.63 1.63 0 0 0-1.63 1.63c0 .9.73 1.63 1.63 1.63.9 0 1.63-.73 1.63-1.63 0-.9-.73-1.63-1.63-1.63z"/></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonicalUrl) ?>&text=<?= urlencode($insight['title']) ?>" target="_blank" rel="noopener noreferrer" class="article-action-btn" title="Share on X (Twitter)" aria-label="Share on X">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <button type="button" class="article-action-btn" id="bottomCopyLinkBtn" title="Copy Article URL" aria-label="Copy Article Link">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            </button>
          </div>
          <a href="<?= $cleanMdUrl ?>" target="_blank" class="article-meta-pill" style="color: #38BDF8; text-decoration: none; border-color: rgba(6, 181, 249, 0.3);" title="Machine-readable Markdown for AI agents">
            <span>LLM Markdown ↗</span>
          </a>
        </div>
      </article>

      <!-- Sidebar Column (Right): Form Above TOC -->
      <aside class="blog-sidebar-column">
        <div class="blog-sidebar-sticky">
          
          <!-- Small Consultation Form Card (Above TOC) -->
          <div class="blog-sidebar-form-card">
            <div class="sidebar-form-badge">
              <span class="badge-dot"></span>
              <span>FREE STRATEGY CALL</span>
            </div>
            <h3 class="sidebar-form-title">Talk to an Architect</h3>
            <p class="sidebar-form-desc">Get actionable advice on your digital performance and tech stack within 24 hours.</p>

            <form id="blogSidebarForm" method="POST" action="<?= appUrl('api/lead-popup-submit.php') ?>">
              <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
              <input type="hidden" name="source" value="blog_detail_sidebar">
              <input type="hidden" name="source_url" value="<?= e($canonicalUrl) ?>">
              
              <!-- Anti-Spam Honeypots -->
              <div style="display:none;" aria-hidden="true">
                <input type="text" name="bdr_website_hp" tabindex="-1" autocomplete="off">
                <input type="text" name="bdr_company_hp" tabindex="-1" autocomplete="off">
              </div>

              <div class="sidebar-form-group">
                <input type="text" name="full_name" class="sidebar-form-input" placeholder="Your Full Name *" required>
              </div>

              <div class="sidebar-form-group">
                <input type="tel" name="phone" class="sidebar-form-input" placeholder="Phone Number (e.g. 9876543210) *" required>
              </div>

              <div class="sidebar-form-group">
                <input type="email" name="email" class="sidebar-form-input" placeholder="Work Email *" required>
              </div>

              <div class="sidebar-form-group">
                <select name="service_interest" class="sidebar-form-input sidebar-form-select">
                  <option value="Web Development & Engineering">Web Development</option>
                  <option value="SEO Services in Delhi">SEO Services in Delhi</option>
                  <option value="PPC Company in Delhi">PPC Company in Delhi</option>
                  <option value="UI/UX & Brand Design">UI/UX &amp; Brand Design</option>
                  <option value="Technical Architecture Audit" selected>Free Technical Audit</option>
                </select>
              </div>

              <button type="submit" class="sidebar-form-btn" id="sidebarFormBtn">
                <span>Request Strategy Call</span>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </button>

              <div id="sidebarFormMsg" class="sidebar-form-msg" style="display: none;"></div>

              <div class="sidebar-privacy-note">
                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>100% confidential. No spam ever.</span>
              </div>
            </form>
          </div>

          <!-- Dynamic Table of Contents (Directly below Form Card) -->
          <nav id="page-toc-card" class="page-toc-card" style="display: none;" aria-label="Table of Contents"></nav>

        </div>
      </aside>
    </div>

    <!-- Related Articles Grid (Related Blogs) -->
    <?php if (!empty($relatedInsights)): ?>
      <div style="border-top: 1px solid rgba(6, 181, 249, 0.2); padding-top: 4rem; margin-top: 4.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
          <div>
            <div style="font-family: var(--font-mono); font-size: 0.74rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.4rem;">
              CONTINUED READING
            </div>
            <h3 style="font-size: 1.6rem; font-weight: 800; color: #FFFFFF; margin: 0; font-family: var(--font-display);">
              Related Engineering Briefings
            </h3>
          </div>
          <a href="<?= getBlogListingUrl() ?>" style="font-family: var(--font-mono); font-size: 0.82rem; color: #06B5F9; text-decoration: none; font-weight: 600;">
            View All Blogs &rarr;
          </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; width: 100%;">
          <?php foreach ($relatedInsights as $ri): 
            [$riImg, $riAlt] = getBlogImageFallback($ri);
            $riTags = !empty($ri['tags']) ? array_slice(array_filter(array_map('trim', explode(',', (string)$ri['tags']))), 0, 2) : [];
          ?>
            <div class="card related-card">
              <div class="related-card-media">
                <a href="<?= getInsightUrl($ri['slug']) ?>" style="display: block; width: 100%; height: 100%; text-decoration: none;" aria-label="<?= e($ri['title']) ?>">
                  <img src="<?= getBlogAssetUrl($riImg) ?>" alt="<?= e($riAlt) ?>" width="1280" height="720" loading="lazy">
                </a>
              </div>
              <div class="related-card-body">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.85rem;">
                  <span class="eyebrow-badge" style="margin: 0; font-size: 0.68rem; padding: 0.2rem 0.55rem;">
                    <?= e($ri['category']) ?>
                  </span>
                  <span style="font-family: var(--font-mono); font-size: 0.72rem; color: #94A3B8;">
                    <?= e($ri['reading_time']) ?>
                  </span>
                </div>

                <h4 style="font-size: 1.15rem; font-weight: 700; color: #FFFFFF; line-height: 1.4; margin-bottom: 0.75rem;">
                  <a href="<?= getInsightUrl($ri['slug']) ?>" style="color: #FFFFFF; text-decoration: none;" onmouseover="this.style.color='#06B5F9'" onmouseout="this.style.color='#FFFFFF'">
                    <?= e($ri['title']) ?>
                  </a>
                </h4>

                <p style="font-size: 0.88rem; color: #94A3B8; line-height: 1.6; margin-bottom: 1.25rem; flex-grow: 1;">
                  <?= e(mb_strimwidth($ri['summary'], 0, 120, '...')) ?>
                </p>

                <?php if (!empty($riTags)): ?>
                  <div style="display: flex; gap: 0.35rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
                    <?php foreach ($riTags as $rt): ?>
                      <span style="font-family: var(--font-mono); font-size: 0.7rem; color: #38BDF8; background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.2); border-radius: 3px; padding: 0.1rem 0.4rem;">
                        #<?= e($rt) ?>
                      </span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>

                <a href="<?= getInsightUrl($ri['slug']) ?>" class="btn btn-secondary btn-sm" style="align-self: flex-start; display: inline-flex; align-items: center; gap: 0.35rem; font-weight: 600;">
                  <span>Read Briefing</span>
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
<section class="section" style="background: #061326; padding-top: 4.5rem; padding-bottom: 5rem; border-top: 1px solid rgba(6, 181, 249, 0.15);">
  <div class="container text-center">
    <div class="enterprise-closing-cta" style="background: radial-gradient(circle at 50% 50%, rgba(6, 181, 249, 0.1) 0%, rgba(7, 26, 44, 0.8) 100%); border: 1px solid rgba(6, 181, 249, 0.3); border-radius: 16px; padding: 3.5rem 2.5rem; max-width: 900px; margin: 0 auto; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);">
      <div class="closing-cta-content">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--font-mono); font-size: 0.74rem; color: #06B5F9; background: rgba(6, 181, 249, 0.1); border: 1px solid rgba(6, 181, 249, 0.3); border-radius: 20px; padding: 0.3rem 0.8rem; margin-bottom: 1rem; text-transform: uppercase;">
          ARCHITECTURAL ADVISORY // ZERO OBLIGATION
        </div>
        <h2 class="closing-cta-title" style="font-size: clamp(1.8rem, 3.2vw, 2.5rem); font-weight: 800; color: #FFFFFF; margin-bottom: 1rem;">
          Need Guidance Modernizing Your Digital Architecture?
        </h2>
        <p class="closing-cta-lead" style="font-size: 1.1rem; color: #94A3B8; max-width: 680px; margin: 0 auto 2.25rem auto; line-height: 1.7;">
          Connect directly with our senior technology architects to evaluate your existing codebase, audit digital speed, and plan scalable optimizations.
        </p>
        <div class="closing-cta-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
          <a href="<?= appUrl('audit') ?>" class="btn btn-accent btn-lg" style="box-shadow: 0 4px 20px rgba(6, 181, 249, 0.4);">
            <span>Request Free Technical Audit</span>
          </a>
          <a href="<?= appUrl('contact') ?>" class="btn btn-secondary btn-lg" style="border-color: rgba(255, 255, 255, 0.2);">
            <span>Consult Our Practice Leads</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Reading Progress Bar, AJAX Form Handler & Copy Link Script -->
<script>
  (function() {
    // Reading progress bar calculation
    const bar = document.getElementById('reading-progress-bar');
    window.addEventListener('scroll', function() {
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      if (docHeight > 0) {
        const scrolled = (window.scrollY / docHeight) * 100;
        bar.style.width = Math.min(100, Math.max(0, scrolled)) + '%';
      }
    }, { passive: true });

    // Toast & Copy link handlers
    const toast = document.getElementById('copy-toast');
    function triggerCopy(text) {
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(function() {
          if (toast) {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
            setTimeout(function() {
              toast.style.opacity = '0';
              toast.style.transform = 'translateY(10px)';
            }, 3000);
          }
        }).catch(function() {
          prompt('Copy link:', text);
        });
      } else {
        prompt('Copy link:', text);
      }
    }

    const copyBtn = document.getElementById('copyLinkBtn');
    if (copyBtn) {
      copyBtn.addEventListener('click', function() {
        triggerCopy(window.location.href);
      });
    }

    const bottomCopyBtn = document.getElementById('bottomCopyLinkBtn');
    if (bottomCopyBtn) {
      bottomCopyBtn.addEventListener('click', function() {
        triggerCopy(window.location.href);
      });
    }

    // Sidebar AJAX Form Submission
    const sidebarForm = document.getElementById('blogSidebarForm');
    if (sidebarForm) {
      sidebarForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('sidebarFormBtn');
        const msg = document.getElementById('sidebarFormMsg');
        const originalBtnText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span>Sending Request...</span>';
        msg.style.display = 'none';

        const formData = new FormData(sidebarForm);

        fetch(sidebarForm.action, {
          method: 'POST',
          body: formData,
          headers: {
            'Accept': 'application/json'
          }
        })
        .then(function(res) {
          return res.json().then(function(data) {
            return { ok: res.ok, status: res.status, data: data };
          });
        })
        .then(function(result) {
          if (result.ok && result.data.success) {
            msg.className = 'sidebar-form-msg success';
            msg.textContent = result.data.message || 'Thank you! Your consultation request has been submitted. We will connect with you shortly.';
            msg.style.display = 'block';
            sidebarForm.reset();
            btn.innerHTML = '<span>Request Sent ✓</span>';
          } else {
            msg.className = 'sidebar-form-msg error';
            msg.textContent = (result.data && result.data.message) ? result.data.message : 'Submission failed. Please check your inputs and try again.';
            msg.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
          }
        })
        .catch(function(err) {
          msg.className = 'sidebar-form-msg error';
          msg.textContent = 'Connection error. Please try again or reach out via our contact page.';
          msg.style.display = 'block';
          btn.disabled = false;
          btn.innerHTML = originalBtnText;
        });
      });
    }
  })();
</script>

<script src="<?= getAssetUrl('assets/js/toc.js') ?>?v=<?= filemtime(__DIR__ . '/assets/js/toc.js') ?>"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
