<?php
/**
 * BusinessDoctor — Centralized SEO, Schema, Sitemap, Markdown & LLM Optimization Service
 * 
 * Provides automated, event-driven generation of:
 * - /sitemap.xml (XML sitemap following sitemaps.org protocol)
 * - /sitemap.html (Executive responsive HTML sitemap matching website theme)
 * - /content-md/blogs/{slug}.md (Clean, accurate markdown representations of published blogs)
 * - /content-md/case-studies/{slug}.md (Clean markdown representations of published case studies)
 * - /llms.txt (Standardized concise LLM index with business context & links)
 * - /llms-full.txt (Expanded comprehensive documentation and content summaries for LLMs)
 * 
 * Enforces transactional boundaries, safe atomic file replacements, automated cleanup of
 * stale/orphaned files on unpublish/delete/slug change, and status telemetry.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

class SeoService
{
    private PDO $pdo;
    private string $rootDir;
    private string $baseUrl;
    private string $stateFile;

    public function __construct(?PDO $pdo = null, ?string $rootDir = null, ?string $baseUrl = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
        $this->rootDir = $rootDir ?? ROOT_PATH;
        $this->baseUrl = $baseUrl ?? self::resolveProductionBaseUrl();
        $this->stateFile = $this->rootDir . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seo_state.json';
    }

    /**
     * Resolve production canonical base URL.
     * Guaranteed to never output localhost or 127.0.0.1 in generated artifacts.
     */
    public static function resolveProductionBaseUrl(): string
    {
        $canonical = getenv('APP_CANONICAL_URL');
        if (!empty($canonical) && !self::isLocalhostUrl($canonical)) {
            return rtrim($canonical, '/');
        }

        // Canonical production domain configured for BusinessDoctor SEO, sitemaps, and LLMs
        return 'https://businessdoctor.com';
    }

    private static function isLocalhostUrl(string $url): bool
    {
        $parsed = parse_url($url);
        $host = strtolower($parsed['host'] ?? '');
        return in_array($host, ['localhost', '127.0.0.1', '::1', '0.0.0.0'], true) 
               || str_ends_with($host, '.local')
               || str_ends_with($host, '.internal');
    }

    /**
     * Event hook: Triggered on any CMS blog/insight change
     */
    public function onBlogChanged(int $id, ?string $oldSlug = null): array
    {
        if (!empty($oldSlug)) {
            $oldFile = $this->rootDir . DIRECTORY_SEPARATOR . 'content-md' . DIRECTORY_SEPARATOR . 'blogs' . DIRECTORY_SEPARATOR . $oldSlug . '.md';
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }
        return $this->generateAll();
    }

    /**
     * Event hook: Triggered on any CMS case study change
     */
    public function onCaseStudyChanged(int $id, ?string $oldSlug = null): array
    {
        if (!empty($oldSlug)) {
            $oldFile = $this->rootDir . DIRECTORY_SEPARATOR . 'content-md' . DIRECTORY_SEPARATOR . 'case-studies' . DIRECTORY_SEPARATOR . $oldSlug . '.md';
            if (file_exists($oldFile)) {
                @unlink($oldFile);
            }
        }
        return $this->generateAll();
    }

    /**
     * Regenerate all SEO files (XML Sitemap, HTML Sitemap, Markdown, llms.txt, llms-full.txt)
     */
    public function generateAll(): array
    {
        $startTime = microtime(true);
        $errors = [];
        $results = [];

        try {
            // 1. Fetch live published datasets
            $blogs = $this->getPublishedBlogs();
            $caseStudies = $this->getPublishedCaseStudies();
            $staticPages = $this->getStaticPages();

            // 2. Generate XML Sitemap
            try {
                $xmlResult = $this->generateSitemapXml($blogs, $caseStudies, $staticPages);
                $results['sitemap_xml'] = $xmlResult;
            } catch (Throwable $e) {
                $errors[] = 'sitemap.xml generation failed: ' . $e->getMessage();
                error_log('[SEO ERROR] sitemap.xml: ' . $e->getMessage());
            }

            // 3. Generate HTML Sitemap
            try {
                $htmlResult = $this->generateSitemapHtml($blogs, $caseStudies, $staticPages);
                $results['sitemap_html'] = $htmlResult;
            } catch (Throwable $e) {
                $errors[] = 'sitemap.html generation failed: ' . $e->getMessage();
                error_log('[SEO ERROR] sitemap.html: ' . $e->getMessage());
            }

            // 4. Generate Markdown representations & purge stale files
            try {
                $mdResult = $this->generateMarkdownFiles($blogs, $caseStudies);
                $results['markdown'] = $mdResult;
            } catch (Throwable $e) {
                $errors[] = 'Markdown generation failed: ' . $e->getMessage();
                error_log('[SEO ERROR] Markdown files: ' . $e->getMessage());
            }

            // 5. Generate llms.txt
            try {
                $llmsResult = $this->generateLlmsTxt($blogs, $caseStudies, $staticPages);
                $results['llms_txt'] = $llmsResult;
            } catch (Throwable $e) {
                $errors[] = 'llms.txt generation failed: ' . $e->getMessage();
                error_log('[SEO ERROR] llms.txt: ' . $e->getMessage());
            }

            // 6. Generate llms-full.txt
            try {
                $llmsFullResult = $this->generateLlmsFullTxt($blogs, $caseStudies, $staticPages);
                $results['llms_full_txt'] = $llmsFullResult;
            } catch (Throwable $e) {
                $errors[] = 'llms-full.txt generation failed: ' . $e->getMessage();
                error_log('[SEO ERROR] llms-full.txt: ' . $e->getMessage());
            }

            $durationMs = (int)round((microtime(true) - $startTime) * 1000);
            $success = empty($errors);

            // Record state metadata for Admin Dashboard
            $stateData = [
                'success' => $success,
                'last_generation_time' => date('Y-m-d H:i:s'),
                'duration_ms' => $durationMs,
                'published_blogs_count' => count($blogs),
                'published_case_studies_count' => count($caseStudies),
                'total_urls_in_sitemap' => ($results['sitemap_xml']['url_count'] ?? 0),
                'errors' => $errors,
                'files' => [
                    'sitemap_xml' => file_exists($this->rootDir . '/sitemap.xml'),
                    'sitemap_html' => file_exists($this->rootDir . '/sitemap.html'),
                    'llms_txt' => file_exists($this->rootDir . '/llms.txt'),
                    'llms_full_txt' => file_exists($this->rootDir . '/llms-full.txt'),
                    'blog_md_count' => $results['markdown']['blogs_count'] ?? 0,
                    'case_study_md_count' => $results['markdown']['case_studies_count'] ?? 0,
                ]
            ];

            $this->saveState($stateData);

            return [
                'success' => $success,
                'duration_ms' => $durationMs,
                'errors' => $errors,
                'results' => $results,
                'state' => $stateData
            ];

        } catch (Throwable $e) {
            $err = 'Fatal SEO Service failure: ' . $e->getMessage();
            error_log('[SEO FATAL] ' . $err);
            $this->saveState([
                'success' => false,
                'last_generation_time' => date('Y-m-d H:i:s'),
                'errors' => [$err]
            ]);
            throw new RuntimeException($err, 0, $e);
        }
    }

    /**
     * Get list of published, non-deleted blog articles
     */
    public function getPublishedBlogs(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM insights 
            WHERE status = 'published' AND is_deleted = 0 
            ORDER BY published_at DESC, id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get list of published, non-deleted case studies
     */
    public function getPublishedCaseStudies(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM case_studies 
            WHERE status = 'published' AND is_deleted = 0 
            ORDER BY sort_order ASC, id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return all indexable public static pages
     */
    public function getStaticPages(): array
    {
        $base = $this->baseUrl;
        $practiceAreas = getPracticeAreas();

        $pages = [
            [
                'loc' => $base . '/',
                'url_path' => '/',
                'title' => 'BusinessDoctor — Engineering Technology. Accelerating Digital Growth.',
                'section' => 'Core Overview',
                'description' => 'Full-service enterprise IT solutions practice specializing in custom web engineering, digital marketing, UI/UX systems, and cloud infrastructure.',
                'priority' => '1.0',
                'changefreq' => 'daily',
                'lastmod' => $this->getSourceLastMod('index.php')
            ],
            [
                'loc' => $base . '/services.php',
                'url_path' => '/services.php',
                'title' => 'Enterprise IT & Digital Services Portfolio',
                'section' => 'Services',
                'description' => 'Full multidisciplinary portfolio covering software development, digital marketing, UI/UX, e-commerce marketplaces, and cloud consulting.',
                'priority' => '0.9',
                'changefreq' => 'weekly',
                'lastmod' => $this->getSourceLastMod('services.php')
            ]
        ];

        // 6 Specific Practice Areas
        foreach ($practiceAreas as $slug => $area) {
            $pages[] = [
                'loc' => $base . '/services/' . rawurlencode($slug),
                'url_path' => '/services/' . rawurlencode($slug),
                'title' => ($area['name'] ?? 'Practice Area') . ' — BusinessDoctor',
                'section' => 'Practice Areas',
                'description' => $area['summary'] ?? ($area['description'] ?? ''),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => date('Y-m-d')
            ];
        }

        // Additional public indexable pages
        $pages[] = [
            'loc' => $base . '/audit.php',
            'url_path' => '/audit.php',
            'title' => 'Enterprise Digital Diagnostic & Technology Audit',
            'section' => 'Tools & Diagnostics',
            'description' => 'Interactive diagnostic audit benchmarking website speed, Core Web Vitals, security posture, and full-stack performance.',
            'priority' => '0.9',
            'changefreq' => 'weekly',
            'lastmod' => $this->getSourceLastMod('audit.php')
        ];

        $pages[] = [
            'loc' => $base . '/case-studies.php',
            'url_path' => '/case-studies.php',
            'title' => 'Client Case Studies & Verified Results',
            'section' => 'Client Outcomes',
            'description' => 'Portfolio of verified client transformations, baseline bottlenecks, software engineering solutions, and quantified revenue growth.',
            'priority' => '0.8',
            'changefreq' => 'weekly',
            'lastmod' => $this->getSourceLastMod('case-studies.php')
        ];

        $pages[] = [
            'loc' => $base . '/insights.php',
            'url_path' => '/insights.php',
            'title' => 'Perspectives & Technical Insights Blog',
            'section' => 'Perspectives & Editorial',
            'description' => 'Technical blueprints, cloud architecture strategies, and leadership insights authored by BusinessDoctor engineering partners.',
            'priority' => '0.8',
            'changefreq' => 'weekly',
            'lastmod' => $this->getSourceLastMod('insights.php')
        ];

        $pages[] = [
            'loc' => $base . '/about.php',
            'url_path' => '/about.php',
            'title' => 'About BusinessDoctor — Enterprise IT & Growth Consultancy',
            'section' => 'About Us',
            'description' => 'Learn about BusinessDoctor executive leadership, engineering principles, and our multidisciplinary IT practice.',
            'priority' => '0.7',
            'changefreq' => 'monthly',
            'lastmod' => $this->getSourceLastMod('about.php')
        ];

        $pages[] = [
            'loc' => $base . '/contact.php',
            'url_path' => '/contact.php',
            'title' => 'Contact BusinessDoctor — Enterprise Advisory & Consultation',
            'section' => 'Contact Us',
            'description' => 'Connect with our senior technical partners and practice directors to discuss software engineering and digital transformation projects.',
            'priority' => '0.8',
            'changefreq' => 'monthly',
            'lastmod' => $this->getSourceLastMod('contact.php')
        ];

        return $pages;
    }

    private function getSourceLastMod(string $file): string
    {
        $path = $this->rootDir . DIRECTORY_SEPARATOR . $file;
        if (file_exists($path)) {
            return date('Y-m-d', (int)filemtime($path));
        }
        return date('Y-m-d');
    }

    /**
     * PHASE 2 — Automatic XML Sitemap Generation (/sitemap.xml)
     */
    public function generateSitemapXml(?array $blogs = null, ?array $caseStudies = null, ?array $staticPages = null): array
    {
        $blogs = $blogs ?? $this->getPublishedBlogs();
        $caseStudies = $caseStudies ?? $this->getPublishedCaseStudies();
        $staticPages = $staticPages ?? $this->getStaticPages();
        $base = $this->baseUrl;

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n";
        $xml .= '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        $seenUrls = [];
        $urlCount = 0;

        $addUrl = function(string $loc, string $lastmod, string $changefreq, string $priority) use (&$xml, &$seenUrls, &$urlCount) {
            $loc = trim($loc);
            if (isset($seenUrls[$loc])) {
                return;
            }
            $seenUrls[$loc] = true;
            $urlCount++;

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($loc, ENT_QUOTES | ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>" . htmlspecialchars($lastmod, ENT_QUOTES | ENT_XML1, 'UTF-8') . "</lastmod>\n";
            $xml .= "    <changefreq>" . htmlspecialchars($changefreq, ENT_QUOTES | ENT_XML1, 'UTF-8') . "</changefreq>\n";
            $xml .= "    <priority>" . htmlspecialchars($priority, ENT_QUOTES | ENT_XML1, 'UTF-8') . "</priority>\n";
            $xml .= "  </url>\n";
        };

        // 1. Static Pages
        foreach ($staticPages as $page) {
            $addUrl($page['loc'], $page['lastmod'], $page['changefreq'], $page['priority']);
        }

        // 2. Case Studies (Published only)
        foreach ($caseStudies as $case) {
            $loc = $base . '/case-studies/' . rawurlencode($case['slug']);
            $rawDate = $case['updated_at'] ?: ($case['published_at'] ?: ($case['created_at'] ?: 'now'));
            $lastmod = date('Y-m-d', strtotime((string)$rawDate));
            $addUrl($loc, $lastmod, 'monthly', '0.7');
        }

        // 3. Blog Articles (Published only)
        foreach ($blogs as $blog) {
            $loc = !empty($blog['canonical_url']) ? $blog['canonical_url'] : ($base . '/insights/' . rawurlencode($blog['slug']));
            $rawDate = $blog['updated_at'] ?: ($blog['published_at'] ?: ($blog['created_at'] ?: 'now'));
            $lastmod = date('Y-m-d', strtotime((string)$rawDate));
            $addUrl($loc, $lastmod, 'monthly', '0.7');
        }

        $xml .= "</urlset>\n";

        $targetPath = $this->rootDir . DIRECTORY_SEPARATOR . 'sitemap.xml';
        $this->safeAtomicWrite($targetPath, $xml);

        return [
            'file' => $targetPath,
            'url_count' => $urlCount,
            'size_bytes' => strlen($xml)
        ];
    }

    /**
     * PHASE 2 — Automatic HTML Sitemap Generation (/sitemap.html)
     * Matches the high-end design theme of BusinessDoctor.
     */
    public function generateSitemapHtml(?array $blogs = null, ?array $caseStudies = null, ?array $staticPages = null): array
    {
        $blogs = $blogs ?? $this->getPublishedBlogs();
        $caseStudies = $caseStudies ?? $this->getPublishedCaseStudies();
        $staticPages = $staticPages ?? $this->getStaticPages();
        $base = $this->baseUrl;
        $practiceAreas = getPracticeAreas();

        $pageTitle = 'HTML Website Sitemap — Complete Architecture Directory | BusinessDoctor';
        $pageDescription = 'Comprehensive architectural directory and index of all public web pages, practice areas, published case studies, and engineering perspectives on BusinessDoctor.';
        $canonicalUrl = $base . '/sitemap.html';
        $generationDate = date('F j, Y');

        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta name="theme-color" content="#061326">
  <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
  <link rel="alternate" type="application/xml" title="Sitemap XML" href="<?= htmlspecialchars($base . '/sitemap.xml') ?>">

  <!-- Typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Core Stylesheets -->
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/components.css">
  <link rel="stylesheet" href="/assets/css/responsive.css">

  <style>
    .sitemap-hero {
      background: linear-gradient(180deg, #061326 0%, #081B35 100%);
      padding: 5rem 0 3.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      color: #FFFFFF;
    }
    .sitemap-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }
    .sitemap-card {
      background: var(--color-surface, #FFFFFF);
      border: 1px solid var(--color-slate-200, #E2E8F0);
      border-radius: var(--radius-lg, 12px);
      padding: 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .sitemap-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }
    .sitemap-card-header {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.25rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--color-slate-200, #E2E8F0);
    }
    .sitemap-card-icon {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      background: rgba(13, 148, 136, 0.1);
      color: #0D9488;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .sitemap-card-title {
      font-family: var(--font-display, 'Plus Jakarta Sans', sans-serif);
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--color-text, #0F172A);
      margin: 0;
    }
    .sitemap-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sitemap-link-item {
      padding: 0.7rem 0;
      border-bottom: 1px solid rgba(226, 232, 240, 0.5);
    }
    .sitemap-link-item:last-child {
      border-bottom: none;
    }
    .sitemap-link {
      font-size: 0.96rem;
      font-weight: 600;
      color: var(--color-text, #0F172A);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      transition: color 0.15s ease;
    }
    .sitemap-link:hover {
      color: #0D9488;
    }
    .sitemap-link-desc {
      font-size: 0.82rem;
      color: var(--color-text-light, #64748B);
      margin-top: 0.25rem;
      line-height: 1.45;
    }
    .sitemap-meta-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-family: var(--font-mono, 'JetBrains Mono', monospace);
      font-size: 0.72rem;
      padding: 2px 7px;
      border-radius: 4px;
      background: var(--color-bg, #F8FAFC);
      color: var(--color-text-muted, #475569);
      border: 1px solid var(--color-slate-200, #E2E8F0);
      margin-top: 0.35rem;
    }
    .sitemap-dev-box {
      background: #040E1B;
      color: #E2E8F0;
      border-radius: 12px;
      padding: 2.5rem;
      margin-top: 3.5rem;
      border: 1px solid rgba(0, 201, 193, 0.2);
    }
  </style>
</head>
<body>
<a href="#main-content" class="skip-link">Skip to main content</a>

<main id="main-content">
  <!-- Hero Section -->
  <section class="sitemap-hero">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
      <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
        <span class="eyebrow-badge" style="background: rgba(0,201,193,0.15); color: #14E5D4; border-color: rgba(0,201,193,0.3); margin: 0;">
          AUTOMATED ARCHITECTURE DIRECTORY
        </span>
        <span style="font-family: var(--font-mono); font-size: 0.8rem; color: #94A3B8;">
          Updated: <?= htmlspecialchars($generationDate) ?>
        </span>
      </div>

      <h1 style="font-size: clamp(2.2rem, 4vw, 3.2rem); font-family: var(--font-display); font-weight: 800; line-height: 1.15; margin: 0 0 1rem; color: #FFFFFF;">
        BusinessDoctor Website Sitemap
      </h1>

      <p style="font-size: 1.1rem; color: #94A3B8; max-width: 720px; margin: 0; line-height: 1.6;">
        Explore all publicly indexable digital solutions, practice area deep-dives, verified client case studies, and engineering perspectives.
      </p>

      <div style="display: flex; gap: 1rem; margin-top: 1.75rem; flex-wrap: wrap;">
        <a href="/sitemap.xml" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(255,255,255,0.08); color: #FFFFFF; border-color: rgba(255,255,255,0.15);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <span>Raw XML Sitemap</span>
        </a>
        <a href="/llms.txt" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(255,255,255,0.08); color: #14E5D4; border-color: rgba(0,201,193,0.3);">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
          <span>llms.txt (AI Index)</span>
        </a>
        <a href="/llms-full.txt" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(255,255,255,0.08); color: #FFFFFF; border-color: rgba(255,255,255,0.15);">
          <span>llms-full.txt (Comprehensive LLM Docs)</span>
        </a>
      </div>
    </div>
  </section>

  <!-- Sitemap Directory Grid -->
  <section class="section" style="padding: 4rem 0; background: var(--color-bg, #F8FAFC);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
      <div class="sitemap-grid">
        
        <!-- Card 1: Main Platform & Public Pages -->
        <div class="sitemap-card">
          <div class="sitemap-card-header">
            <div class="sitemap-card-icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <h2 class="sitemap-card-title">Core Company Pages</h2>
          </div>
          <ul class="sitemap-links">
            <li class="sitemap-link-item">
              <a href="/" class="sitemap-link">Homepage / Platform Root ↗</a>
              <div class="sitemap-link-desc">Enterprise software engineering, digital strategy, and brand consulting portal.</div>
            </li>
            <li class="sitemap-link-item">
              <a href="/about.php" class="sitemap-link">About Us ↗</a>
              <div class="sitemap-link-desc">Executive team, multidisciplinary practice philosophy, and engineering standards.</div>
            </li>
            <li class="sitemap-link-item">
              <a href="/services.php" class="sitemap-link">IT Services Portfolio ↗</a>
              <div class="sitemap-link-desc">Full suite of enterprise digital engineering, marketing, and cloud services.</div>
            </li>
            <li class="sitemap-link-item">
              <a href="/audit.php" class="sitemap-link">Digital Architecture Audit ↗</a>
              <div class="sitemap-link-desc">Interactive diagnostic tool assessing speed, security headers, and Core Web Vitals.</div>
            </li>
            <li class="sitemap-link-item">
              <a href="/case-studies.php" class="sitemap-link">Client Case Studies ↗</a>
              <div class="sitemap-link-desc">Verified outcomes and architecture blueprints across enterprise clients.</div>
            </li>
            <li class="sitemap-link-item">
              <a href="/insights.php" class="sitemap-link">Perspectives &amp; Technical Blog ↗</a>
              <div class="sitemap-link-desc">Deep-dive software design patterns, cloud frameworks, and growth guides.</div>
            </li>
            <li class="sitemap-link-item">
              <a href="/contact.php" class="sitemap-link">Contact Advisory Team ↗</a>
              <div class="sitemap-link-desc">Direct engagement channel with solutions leads and managing partners.</div>
            </li>
          </ul>
        </div>

        <!-- Card 2: Practice Areas -->
        <div class="sitemap-card">
          <div class="sitemap-card-header">
            <div class="sitemap-card-icon" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
            </div>
            <h2 class="sitemap-card-title">Practice Areas</h2>
          </div>
          <ul class="sitemap-links">
            <?php foreach ($practiceAreas as $slug => $area): ?>
              <li class="sitemap-link-item">
                <a href="/services/<?= rawurlencode($slug) ?>" class="sitemap-link">
                  <?= htmlspecialchars($area['name'] ?? $slug) ?> ↗
                </a>
                <div class="sitemap-link-desc"><?= htmlspecialchars($area['summary'] ?? '') ?></div>
                <div class="sitemap-meta-badge">Route: /services/<?= htmlspecialchars($slug) ?></div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Card 3: Client Case Studies -->
        <div class="sitemap-card">
          <div class="sitemap-card-header">
            <div class="sitemap-card-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            </div>
            <h2 class="sitemap-card-title">Published Case Studies (<?= count($caseStudies) ?>)</h2>
          </div>
          <ul class="sitemap-links">
            <?php if (empty($caseStudies)): ?>
              <li class="sitemap-link-item" style="color: var(--color-text-light);">No published case studies available.</li>
            <?php else: ?>
              <?php foreach ($caseStudies as $case): ?>
                <li class="sitemap-link-item">
                  <a href="/case-studies/<?= rawurlencode($case['slug']) ?>" class="sitemap-link">
                    <?= htmlspecialchars($case['title']) ?> ↗
                  </a>
                  <div class="sitemap-link-desc">
                    <?= htmlspecialchars($case['client_name'] ? $case['client_name'] . ' • ' : '') ?>
                    <?= htmlspecialchars($case['outcome_metric'] ? $case['outcome_metric'] . ' (' . $case['metric_label'] . ')' : '') ?>
                  </div>
                  <div style="display: flex; gap: 0.5rem; margin-top: 0.35rem; align-items: center;">
                    <span class="sitemap-meta-badge"><?= htmlspecialchars($case['industry'] ?: $case['client_industry']) ?></span>
                    <a href="/content-md/case-studies/<?= rawurlencode($case['slug']) ?>.md" target="_blank" rel="noopener" style="font-size: 0.72rem; font-family: var(--font-mono); color: #0D9488; text-decoration: none;">
                      [Markdown .md]
                    </a>
                  </div>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Card 4: Technical Insights & Blog Articles -->
        <div class="sitemap-card">
          <div class="sitemap-card-header">
            <div class="sitemap-card-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <h2 class="sitemap-card-title">Perspectives &amp; Articles (<?= count($blogs) ?>)</h2>
          </div>
          <ul class="sitemap-links">
            <?php if (empty($blogs)): ?>
              <li class="sitemap-link-item" style="color: var(--color-text-light);">No published articles available.</li>
            <?php else: ?>
              <?php foreach ($blogs as $blog): ?>
                <li class="sitemap-link-item">
                  <a href="/insights/<?= rawurlencode($blog['slug']) ?>" class="sitemap-link">
                    <?= htmlspecialchars($blog['title']) ?> ↗
                  </a>
                  <div class="sitemap-link-desc">
                    <?= htmlspecialchars(mb_strimwidth($blog['excerpt'] ?: $blog['summary'], 0, 110, '...')) ?>
                  </div>
                  <div style="display: flex; gap: 0.5rem; margin-top: 0.35rem; align-items: center;">
                    <span class="sitemap-meta-badge"><?= htmlspecialchars($blog['category']) ?></span>
                    <a href="/content-md/blogs/<?= rawurlencode($blog['slug']) ?>.md" target="_blank" rel="noopener" style="font-size: 0.72rem; font-family: var(--font-mono); color: #0D9488; text-decoration: none;">
                      [Markdown .md]
                    </a>
                  </div>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>

      </div>

      <!-- Developer & LLM Endpoints Callout Box -->
      <div class="sitemap-dev-box">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
          <div>
            <h3 style="font-size: 1.35rem; font-family: var(--font-display); font-weight: 700; color: #FFFFFF; margin: 0 0 0.35rem;">
              Machine-Readable &amp; LLM Optimization Endpoints
            </h3>
            <p style="color: #94A3B8; font-size: 0.92rem; margin: 0;">
              BusinessDoctor exposes standardized machine-readable representations for crawlers, AI agents, and LLMs.
            </p>
          </div>
          <span style="font-family: var(--font-mono); font-size: 0.75rem; color: #14E5D4; background: rgba(0,201,193,0.15); border: 1px solid rgba(0,201,193,0.3); padding: 4px 10px; border-radius: 4px;">
            RFC / LLMS.TXT READY
          </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; font-family: var(--font-mono); font-size: 0.85rem;">
          <div style="background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);">
            <div style="color: #64748B; font-size: 0.75rem; margin-bottom: 0.25rem;">XML SITEMAP</div>
            <a href="/sitemap.xml" target="_blank" style="color: #14E5D4; text-decoration: none;">/sitemap.xml ↗</a>
          </div>
          <div style="background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);">
            <div style="color: #64748B; font-size: 0.75rem; margin-bottom: 0.25rem;">LLM CONCISE INDEX</div>
            <a href="/llms.txt" target="_blank" style="color: #14E5D4; text-decoration: none;">/llms.txt ↗</a>
          </div>
          <div style="background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);">
            <div style="color: #64748B; font-size: 0.75rem; margin-bottom: 0.25rem;">LLM FULL DOCUMENTATION</div>
            <a href="/llms-full.txt" target="_blank" style="color: #14E5D4; text-decoration: none;">/llms-full.txt ↗</a>
          </div>
          <div style="background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 6px; border: 1px solid rgba(255,255,255,0.08);">
            <div style="color: #64748B; font-size: 0.75rem; margin-bottom: 0.25rem;">ROBOTS SPECIFICATION</div>
            <a href="/robots.txt" target="_blank" style="color: #14E5D4; text-decoration: none;">/robots.txt ↗</a>
          </div>
        </div>
      </div>

      <!-- Back to Top / Navigation Footer -->
      <div style="margin-top: 3.5rem; padding-top: 1.5rem; border-top: 1px solid var(--color-slate-200, #E2E8F0); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <a href="/" style="font-weight: 700; color: var(--color-text); text-decoration: none; font-size: 0.95rem;">
          &larr; Return to BusinessDoctor Homepage
        </a>
        <div style="font-size: 0.85rem; color: var(--color-text-light);">
          &copy; <?= date('Y') ?> BusinessDoctor IT Solutions &amp; Digital Services. All rights reserved.
        </div>
      </div>

    </div>
  </section>
</main>
</body>
</html>
        <?php
        $html = ob_get_clean();

        $targetPath = $this->rootDir . DIRECTORY_SEPARATOR . 'sitemap.html';
        $this->safeAtomicWrite($targetPath, $html);

        return [
            'file' => $targetPath,
            'size_bytes' => strlen($html)
        ];
    }

    /**
     * PHASE 4 — Automatic Markdown Generation (/content-md/blogs/ and /content-md/case-studies/)
     * Automatically creates, regenerates, and removes stale files on publish, edit, unpublish, delete, or slug change.
     */
    public function generateMarkdownFiles(?array $blogs = null, ?array $caseStudies = null): array
    {
        $blogs = $blogs ?? $this->getPublishedBlogs();
        $caseStudies = $caseStudies ?? $this->getPublishedCaseStudies();
        $base = $this->baseUrl;

        $blogsDir = $this->rootDir . DIRECTORY_SEPARATOR . 'content-md' . DIRECTORY_SEPARATOR . 'blogs';
        $casesDir = $this->rootDir . DIRECTORY_SEPARATOR . 'content-md' . DIRECTORY_SEPARATOR . 'case-studies';

        if (!is_dir($blogsDir)) {
            mkdir($blogsDir, 0755, true);
        }
        if (!is_dir($casesDir)) {
            mkdir($casesDir, 0755, true);
        }

        $activeBlogSlugs = [];
        $activeCaseSlugs = [];

        // 1. Generate Blogs Markdown
        foreach ($blogs as $b) {
            $slug = $b['slug'];
            $activeBlogSlugs[$slug . '.md'] = true;

            $canonicalUrl = !empty($b['canonical_url']) ? $b['canonical_url'] : ($base . '/insights/' . rawurlencode($slug));
            $title = $b['title'];
            $description = !empty($b['seo_description']) ? $b['seo_description'] : (!empty($b['excerpt']) ? $b['excerpt'] : $b['summary']);
            $author = $b['author'] ?: ($b['author_name'] ?: 'BusinessDoctor Expert');
            $authorTitle = $b['author_title'] ?? 'Senior Consultant';
            $category = $b['category'] ?? 'Enterprise Strategy';
            $readingTime = $b['reading_time'] ?? '6 min read';
            $tags = $b['tags'] ?? '';

            $pubDate = !empty($b['published_at']) ? date('Y-m-d', strtotime((string)$b['published_at'])) : date('Y-m-d');
            $modDate = !empty($b['updated_at']) ? date('Y-m-d', strtotime((string)$b['updated_at'])) : $pubDate;

            $featuredImg = $b['featured_image'] ?? '';
            if (!empty($featuredImg) && !preg_match('#^https?://#i', $featuredImg)) {
                $featuredImg = $base . '/' . ltrim($featuredImg, '/');
            }

            $mdContent = $this->htmlToMarkdown($b['content'] ?? '');

            $md = "---\n";
            $md .= "title: " . json_encode($title, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "canonical_url: " . json_encode($canonicalUrl, JSON_UNESCAPED_SLASHES) . "\n";
            $md .= "description: " . json_encode($description, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "published_date: \"{$pubDate}\"\n";
            $md .= "modified_date: \"{$modDate}\"\n";
            $md .= "author: " . json_encode($author, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "author_title: " . json_encode($authorTitle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "category: " . json_encode($category, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "reading_time: \"{$readingTime}\"\n";
            if (!empty($tags)) {
                $md .= "tags: " . json_encode($tags, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            }
            if (!empty($featuredImg)) {
                $md .= "featured_image: " . json_encode($featuredImg, JSON_UNESCAPED_SLASHES) . "\n";
            }
            $md .= "---\n\n";

            $md .= "# {$title}\n\n";
            $md .= "**Author:** {$author} ({$authorTitle})  \n";
            $md .= "**Published:** {$pubDate} | **Reading Time:** {$readingTime} | **Category:** {$category}  \n";
            $md .= "**Canonical Source:** [{$canonicalUrl}]({$canonicalUrl})\n\n";

            if (!empty($description)) {
                $md .= "## Executive Summary\n\n";
                $md .= "> " . str_replace("\n", "\n> ", trim($description)) . "\n\n";
            }

            $md .= "## Article Content\n\n";
            $md .= trim($mdContent) . "\n\n";

            $md .= "---\n\n";
            $md .= "### About BusinessDoctor\n\n";
            $md .= "BusinessDoctor is an enterprise IT solutions and digital services practice specializing in custom software engineering, digital marketing, UI/UX systems, marketplace operations, and cloud architecture.\n\n";
            $md .= "- [Explore All Perspectives]({$base}/insights.php)\n";
            $md .= "- [Request a Complimentary Technical Audit]({$base}/audit.php)\n";
            $md .= "- [Connect with Solutions Leadership]({$base}/contact.php)\n";

            $dest = $blogsDir . DIRECTORY_SEPARATOR . $slug . '.md';
            $this->safeAtomicWrite($dest, $md);
        }

        // 2. Generate Case Studies Markdown
        foreach ($caseStudies as $c) {
            $slug = $c['slug'];
            $activeCaseSlugs[$slug . '.md'] = true;

            $canonicalUrl = $base . '/case-studies/' . rawurlencode($slug);
            $title = $c['title'];
            $clientName = $c['client_name'] ?? 'Enterprise Client';
            $industry = $c['industry'] ?: ($c['client_industry'] ?? 'Enterprise Software');
            $serviceCategory = $c['service_category'] ?: ($c['practice_area'] ?? 'Web Engineering');
            $baseline = $c['baseline_metric'] ?? '';
            $outcome = $c['outcome_metric'] ?? '';
            $metricLabel = $c['metric_label'] ?? 'Verified Outcome';
            $challenge = $c['challenge'] ?? '';
            $solution = $c['solution'] ?: ($c['prescription'] ?? '');
            $results = $c['results'] ?: ($c['result_description'] ?? '');
            $quoteText = $c['quote_text'] ?? '';
            $quoteAuthor = $c['quote_author'] ?? '';
            $quoteTitle = $c['quote_title'] ?? '';

            $pubDate = !empty($c['published_at']) ? date('Y-m-d', strtotime((string)$c['published_at'])) : date('Y-m-d');
            $modDate = !empty($c['updated_at']) ? date('Y-m-d', strtotime((string)$c['updated_at'])) : $pubDate;

            $featuredImg = $c['featured_image'] ?? '';
            if (!empty($featuredImg) && !preg_match('#^https?://#i', $featuredImg)) {
                $featuredImg = $base . '/' . ltrim($featuredImg, '/');
            }

            $md = "---\n";
            $md .= "title: " . json_encode($title, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "canonical_url: " . json_encode($canonicalUrl, JSON_UNESCAPED_SLASHES) . "\n";
            $md .= "client_name: " . json_encode($clientName, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "industry: " . json_encode($industry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "service_category: " . json_encode($serviceCategory, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "published_date: \"{$pubDate}\"\n";
            $md .= "modified_date: \"{$modDate}\"\n";
            $md .= "baseline_metric: " . json_encode($baseline, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "outcome_metric: " . json_encode($outcome, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            $md .= "metric_label: " . json_encode($metricLabel, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
            if (!empty($featuredImg)) {
                $md .= "featured_image: " . json_encode($featuredImg, JSON_UNESCAPED_SLASHES) . "\n";
            }
            $md .= "---\n\n";

            $md .= "# {$title}\n\n";
            $md .= "**Client:** {$clientName} | **Industry:** {$industry}  \n";
            $md .= "**Practice Area:** {$serviceCategory} | **Verified Impact:** {$outcome} ({$metricLabel})  \n";
            $md .= "**Canonical Source:** [{$canonicalUrl}]({$canonicalUrl})\n\n";

            $md .= "## Verified Impact Metrics\n\n";
            $md .= "- **Baseline Status:** {$baseline}\n";
            $md .= "- **Verified Outcome:** {$outcome}\n";
            $md .= "- **Measured Metric:** {$metricLabel}\n\n";

            $md .= "## 01 // The Challenge & Business Friction\n\n";
            $md .= trim($this->htmlToMarkdown($challenge)) . "\n\n";

            $md .= "## 02 // Engineering Architecture & Solution\n\n";
            $md .= trim($this->htmlToMarkdown($solution)) . "\n\n";

            $md .= "## 03 // Commercial Results & Quantified Impact\n\n";
            $md .= trim($this->htmlToMarkdown($results)) . "\n\n";

            if (!empty($quoteText)) {
                $md .= "## Client Testimonial\n\n";
                $md .= "> \"{$quoteText}\"\n";
                $md .= "> \n";
                $md .= "> — **{$quoteAuthor}**, {$quoteTitle}\n\n";
            }

            $md .= "---\n\n";
            $md .= "### Practice References\n\n";
            $md .= "- [Explore All Case Studies]({$base}/case-studies.php)\n";
            $md .= "- [Enterprise IT Services Portfolio]({$base}/services.php)\n";
            $md .= "- [Request a Complimentary Technical Audit]({$base}/audit.php)\n";

            $dest = $casesDir . DIRECTORY_SEPARATOR . $slug . '.md';
            $this->safeAtomicWrite($dest, $md);
        }

        // 3. Stale & Orphaned File Cleanup
        // Scans directories and deletes any .md file whose slug is no longer among active published items
        $purgedBlogs = 0;
        foreach (glob($blogsDir . DIRECTORY_SEPARATOR . '*.md') ?: [] as $file) {
            $baseName = basename($file);
            if (!isset($activeBlogSlugs[$baseName])) {
                @unlink($file);
                $purgedBlogs++;
            }
        }

        $purgedCases = 0;
        foreach (glob($casesDir . DIRECTORY_SEPARATOR . '*.md') ?: [] as $file) {
            $baseName = basename($file);
            if (!isset($activeCaseSlugs[$baseName])) {
                @unlink($file);
                $purgedCases++;
            }
        }

        return [
            'blogs_count' => count($blogs),
            'case_studies_count' => count($caseStudies),
            'purged_blogs_count' => $purgedBlogs,
            'purged_case_studies_count' => $purgedCases
        ];
    }

    /**
     * PHASE 5 — Automatic llms.txt Generation (/llms.txt)
     * Follows the official llmstxt.org specification.
     */
    public function generateLlmsTxt(?array $blogs = null, ?array $caseStudies = null, ?array $staticPages = null): array
    {
        $blogs = $blogs ?? $this->getPublishedBlogs();
        $caseStudies = $caseStudies ?? $this->getPublishedCaseStudies();
        $base = $this->baseUrl;
        $practiceAreas = getPracticeAreas();

        $txt = "# BusinessDoctor\n";
        $txt .= "> Engineering Technology. Accelerating Digital Growth.\n\n";

        $txt .= "BusinessDoctor is an enterprise IT solutions and digital services practice. We engineer high-performance custom web applications, scale revenue via data-driven digital marketing and SEO, craft modern UI/UX design systems, manage Amazon and Flipkart e-commerce operations, produce studio creative media, and architect secure cloud infrastructure.\n\n";

        $txt .= "## Core Capabilities & Services\n";
        foreach ($practiceAreas as $slug => $area) {
            $url = $base . '/services/' . rawurlencode($slug);
            $name = $area['name'] ?? $slug;
            $summary = $area['summary'] ?? ($area['description'] ?? '');
            $txt .= "- [{$name}]({$url}): {$summary}\n";
        }
        $txt .= "\n";

        $txt .= "## Primary Public Pages\n";
        $txt .= "- [Homepage]({$base}/): Official company portal and capabilities overview.\n";
        $txt .= "- [About Us]({$base}/about.php): Company philosophy, executive leadership, and engineering principles.\n";
        $txt .= "- [IT Services Portfolio]({$base}/services.php): Full catalog of IT consulting and software engineering solutions.\n";
        $txt .= "- [Digital Architecture Audit]({$base}/audit.php): Free interactive digital health, performance, and security diagnostic tool.\n";
        $txt .= "- [Case Studies]({$base}/case-studies.php): Verified enterprise transformations and quantified business outcomes.\n";
        $txt .= "- [Insights & Perspectives]({$base}/insights.php): Technical perspectives, cloud blueprints, and growth frameworks.\n";
        $txt .= "- [Contact Us]({$base}/contact.php): Enterprise advisory inquiry and consultation scheduling.\n\n";

        $txt .= "## Published Case Studies\n";
        foreach ($caseStudies as $c) {
            $url = $base . '/case-studies/' . rawurlencode($c['slug']);
            $mdUrl = $base . '/content-md/case-studies/' . rawurlencode($c['slug']) . '.md';
            $title = $c['title'];
            $metric = $c['outcome_metric'] ? " ({$c['outcome_metric']} {$c['metric_label']})" : '';
            $txt .= "- [{$title}]({$url}): {$c['client_industry']}{$metric} ([Markdown]({$mdUrl}))\n";
        }
        $txt .= "\n";

        $txt .= "## Published Perspectives & Technical Articles\n";
        foreach ($blogs as $b) {
            $url = !empty($b['canonical_url']) ? $b['canonical_url'] : ($base . '/insights/' . rawurlencode($b['slug']));
            $mdUrl = $base . '/content-md/blogs/' . rawurlencode($b['slug']) . '.md';
            $title = $b['title'];
            $category = $b['category'];
            $txt .= "- [{$title}]({$url}): {$category} ([Markdown]({$mdUrl}))\n";
        }
        $txt .= "\n";

        $txt .= "## Machine-Readable Resources\n";
        $txt .= "- [XML Sitemap]({$base}/sitemap.xml): Machine-readable XML sitemap protocol index.\n";
        $txt .= "- [HTML Sitemap]({$base}/sitemap.html): Human-navigable architectural sitemap.\n";
        $txt .= "- [Full LLM Documentation]({$base}/llms-full.txt): Comprehensive deep-dive documentation for AI models.\n";

        $targetPath = $this->rootDir . DIRECTORY_SEPARATOR . 'llms.txt';
        $this->safeAtomicWrite($targetPath, $txt);

        return [
            'file' => $targetPath,
            'size_bytes' => strlen($txt)
        ];
    }

    /**
     * PHASE 5 — Automatic llms-full.txt Generation (/llms-full.txt)
     * Comprehensive, expanded documentation with full summaries and deliverables.
     */
    public function generateLlmsFullTxt(?array $blogs = null, ?array $caseStudies = null, ?array $staticPages = null): array
    {
        $blogs = $blogs ?? $this->getPublishedBlogs();
        $caseStudies = $caseStudies ?? $this->getPublishedCaseStudies();
        $base = $this->baseUrl;
        $practiceAreas = getPracticeAreas();

        $txt = "# BusinessDoctor — Enterprise Technical & Capability Documentation\n";
        $txt .= "> Engineering Technology. Accelerating Digital Growth.\n";
        $txt .= "Official Canonical Domain: {$base}\n\n";

        $txt .= "## Organization Overview\n";
        $txt .= "BusinessDoctor IT Solutions & Digital Services Private Limited is an enterprise technology and digital consulting firm. We specialize in custom web application engineering, performance marketing, conversion rate optimization (CRO), UI/UX design systems, Amazon and Flipkart marketplace acceleration, creative media production, and cloud architecture.\n\n";

        $txt .= "## Detailed Practice Areas & Engineering Deliverables\n\n";
        foreach ($practiceAreas as $slug => $area) {
            $url = $base . '/services/' . rawurlencode($slug);
            $name = $area['name'] ?? $slug;
            $tagline = $area['tagline'] ?? '';
            $desc = $area['description'] ?? ($area['summary'] ?? '');

            $txt .= "### {$name}\n";
            $txt .= "**URL:** [{$url}]({$url})  \n";
            if (!empty($tagline)) {
                $txt .= "**Core Focus:** {$tagline}  \n";
            }
            $txt .= "**Description:** {$desc}\n\n";

            if (!empty($area['deliverables']) && is_array($area['deliverables'])) {
                $txt .= "**Key Deliverables:**\n";
                foreach ($area['deliverables'] as $deliv) {
                    $txt .= "- {$deliv}\n";
                }
                $txt .= "\n";
            }

            if (!empty($area['kpis']) && is_array($area['kpis'])) {
                $txt .= "**Performance Benchmarks & KPIs:** " . implode(' | ', $area['kpis']) . "\n\n";
            }
        }

        $txt .= "## Verified Client Case Studies (Complete Deep Dives)\n\n";
        foreach ($caseStudies as $c) {
            $url = $base . '/case-studies/' . rawurlencode($c['slug']);
            $mdUrl = $base . '/content-md/case-studies/' . rawurlencode($c['slug']) . '.md';

            $txt .= "### " . $c['title'] . "\n";
            $txt .= "- **URL:** [{$url}]({$url})\n";
            $txt .= "- **Markdown Source:** [{$mdUrl}]({$mdUrl})\n";
            $txt .= "- **Client / Industry:** " . ($c['client_name'] ? $c['client_name'] . ' (' : '') . ($c['industry'] ?: $c['client_industry']) . ($c['client_name'] ? ')' : '') . "\n";
            $txt .= "- **Practice Area:** " . ($c['service_category'] ?: $c['practice_area']) . "\n";
            $txt .= "- **Verified Outcome:** " . $c['outcome_metric'] . " (" . $c['metric_label'] . ") vs Baseline " . $c['baseline_metric'] . "\n\n";

            $txt .= "#### Challenge\n" . trim(strip_tags($c['challenge'])) . "\n\n";
            $txt .= "#### Engineering Solution\n" . trim(strip_tags($c['solution'] ?: $c['prescription'])) . "\n\n";
            $txt .= "#### Commercial Results\n" . trim(strip_tags($c['results'] ?: $c['result_description'])) . "\n\n";

            if (!empty($c['quote_text'])) {
                $txt .= "> \"{$c['quote_text']}\" — {$c['quote_author']}, {$c['quote_title']}\n\n";
            }
            $txt .= "---\n\n";
        }

        $txt .= "## Published Engineering Perspectives & Technical Articles\n\n";
        foreach ($blogs as $b) {
            $url = !empty($b['canonical_url']) ? $b['canonical_url'] : ($base . '/insights/' . rawurlencode($b['slug']));
            $mdUrl = $base . '/content-md/blogs/' . rawurlencode($b['slug']) . '.md';
            $author = $b['author'] ?: $b['author_name'];
            $authorTitle = $b['author_title'] ?? 'Senior Consultant';

            $txt .= "### " . $b['title'] . "\n";
            $txt .= "- **URL:** [{$url}]({$url})\n";
            $txt .= "- **Markdown Source:** [{$mdUrl}]({$mdUrl})\n";
            $txt .= "- **Author:** {$author} ({$authorTitle})\n";
            $txt .= "- **Category:** {$b['category']} | **Reading Time:** {$b['reading_time']}\n";
            $txt .= "- **Published Date:** " . date('Y-m-d', strtotime($b['published_at'])) . "\n\n";

            $txt .= "#### Summary\n" . trim(strip_tags($b['excerpt'] ?: $b['summary'])) . "\n\n";
            $txt .= "#### Full Content Outline\n";
            $plainContent = trim(strip_tags($b['content']));
            $txt .= mb_strimwidth($plainContent, 0, 600, "...\n\n[Read complete article via {$url} or {$mdUrl}]") . "\n\n";
            $txt .= "---\n\n";
        }

        $targetPath = $this->rootDir . DIRECTORY_SEPARATOR . 'llms-full.txt';
        $this->safeAtomicWrite($targetPath, $txt);

        return [
            'file' => $targetPath,
            'size_bytes' => strlen($txt)
        ];
    }

    /**
     * Convert HTML content into clean, semantic Markdown.
     */
    public function htmlToMarkdown(string $html): string
    {
        if (empty(trim($html))) {
            return '';
        }

        // 1. Remove comments, styles, scripts
        $clean = preg_replace('/<!--.*?-->/s', '', $html);
        $clean = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $clean);
        $clean = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $clean);

        // 2. Headings: H1 to H6
        for ($i = 6; $i >= 1; $i--) {
            $prefix = str_repeat('#', $i);
            $clean = preg_replace_callback('/<h' . $i . '[^>]*>(.*?)<\/h' . $i . '>/is', function($m) use ($prefix) {
                $text = trim(strip_tags($m[1]));
                return "\n\n{$prefix} {$text}\n\n";
            }, $clean);
        }

        // 3. Blockquotes
        $clean = preg_replace_callback('/<blockquote[^>]*>(.*?)<\/blockquote>/is', function($m) {
            $inner = trim(strip_tags($m[1]));
            $lines = explode("\n", $inner);
            $quoted = array_map(fn($l) => '> ' . trim($l), array_filter($lines, fn($l) => trim($l) !== ''));
            return "\n\n" . implode("\n> \n", $quoted) . "\n\n";
        }, $clean);

        // 4. Preformatted & Code Blocks
        $clean = preg_replace_callback('/<pre[^>]*><code(?: class=["\'](?:language-)?([a-z0-9_-]+)["\'])?[^>]*>(.*?)<\/code><\/pre>/is', function($m) {
            $lang = !empty($m[1]) ? strtolower($m[1]) : '';
            $code = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            return "\n\n```{$lang}\n" . trim($code) . "\n```\n\n";
        }, $clean);

        $clean = preg_replace_callback('/<pre[^>]*>(.*?)<\/pre>/is', function($m) {
            $code = html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            return "\n\n```\n" . trim($code) . "\n```\n\n";
        }, $clean);

        // Inline code
        $clean = preg_replace('/<code[^>]*>(.*?)<\/code>/is', '`$1`', $clean);

        // 5. Bold & Strong
        $clean = preg_replace('/<(?:strong|b)\b[^>]*>(.*?)<\/(?:strong|b)>/is', '**$1**', $clean);

        // 6. Italic & Emphasis
        $clean = preg_replace('/<(?:em|i)\b[^>]*>(.*?)<\/(?:em|i)>/is', '*$1*', $clean);

        // 7. Strikethrough
        $clean = preg_replace('/<(?:s|strike|del)\b[^>]*>(.*?)<\/(?:s|strike|del)>/is', '~~$1~~', $clean);

        // 8. Images
        $clean = preg_replace_callback('/<img\b[^>]*src=["\']([^"\']+)["\'][^>]*alt=["\']([^"\']*)["\'][^>]*>/is', function($m) {
            return '![' . trim($m[2]) . '](' . trim($m[1]) . ')';
        }, $clean);
        $clean = preg_replace_callback('/<img\b[^>]*alt=["\']([^"\']*)["\'][^>]*src=["\']([^"\']+)["\'][^>]*>/is', function($m) {
            return '![' . trim($m[1]) . '](' . trim($m[2]) . ')';
        }, $clean);
        $clean = preg_replace('/<img\b[^>]*src=["\']([^"\']+)["\'][^>]*>/is', '![]($1)', $clean);

        // 9. Links
        $clean = preg_replace_callback('/<a\b[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', function($m) {
            $text = trim(strip_tags($m[2]));
            $url = trim($m[1]);
            if (empty($text)) {
                return $url;
            }
            return '[' . $text . '](' . $url . ')';
        }, $clean);

        // 10. Tables
        $clean = preg_replace_callback('/<table\b[^>]*>(.*?)<\/table>/is', function($m) {
            $tableHtml = $m[1];
            $rows = [];
            if (preg_match_all('/<tr\b[^>]*>(.*?)<\/tr>/is', $tableHtml, $trMatches)) {
                foreach ($trMatches[1] as $trHtml) {
                    $cols = [];
                    if (preg_match_all('/<(?:th|td)\b[^>]*>(.*?)<\/(?:th|td)>/is', $trHtml, $tdMatches)) {
                        foreach ($tdMatches[1] as $td) {
                            $cols[] = trim(strip_tags($td));
                        }
                    }
                    if (!empty($cols)) {
                        $rows[] = $cols;
                    }
                }
            }
            if (empty($rows)) {
                return '';
            }

            $maxCols = max(array_map('count', $rows));
            $out = "\n\n";
            $header = array_shift($rows);
            while (count($header) < $maxCols) {
                $header[] = '';
            }
            $out .= '| ' . implode(' | ', $header) . " |\n";
            $out .= '|' . str_repeat(' --- |', $maxCols) . "\n";

            foreach ($rows as $r) {
                while (count($r) < $maxCols) {
                    $r[] = '';
                }
                $out .= '| ' . implode(' | ', $r) . " |\n";
            }
            return $out . "\n";
        }, $clean);

        // 11. Lists (Ordered and Unordered)
        $clean = preg_replace_callback('/<ul\b[^>]*>(.*?)<\/ul>/is', function($m) {
            if (preg_match_all('/<li\b[^>]*>(.*?)<\/li>/is', $m[1], $li)) {
                $items = array_map(fn($item) => '- ' . trim(strip_tags($item)), $li[1]);
                return "\n\n" . implode("\n", $items) . "\n\n";
            }
            return '';
        }, $clean);

        $clean = preg_replace_callback('/<ol\b[^>]*>(.*?)<\/ol>/is', function($m) {
            if (preg_match_all('/<li\b[^>]*>(.*?)<\/li>/is', $m[1], $li)) {
                $idx = 1;
                $items = [];
                foreach ($li[1] as $item) {
                    $items[] = "{$idx}. " . trim(strip_tags($item));
                    $idx++;
                }
                return "\n\n" . implode("\n", $items) . "\n\n";
            }
            return '';
        }, $clean);

        // 12. Paragraphs & Dividers
        $clean = preg_replace('/<hr\b[^>]*>/is', "\n\n---\n\n", $clean);
        $clean = preg_replace('/<br\b[^>]*>/is', "  \n", $clean);
        $clean = preg_replace('/<p\b[^>]*>(.*?)<\/p>/is', "\n\n$1\n\n", $clean);

        // 13. Strip any remaining tags
        $clean = strip_tags($clean);

        // 14. HTML Entities decode
        $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // 15. Normalize excessive whitespace & empty lines
        $clean = preg_replace("/\r\n/", "\n", $clean);
        $clean = preg_replace("/\n{3,}/", "\n\n", $clean);

        return trim($clean);
    }

    /**
     * Read current SEO generation status for admin reporting
     */
    public function getSeoStatus(): array
    {
        $state = [];
        if (file_exists($this->stateFile) && is_readable($this->stateFile)) {
            $raw = file_get_contents($this->stateFile);
            $decoded = json_decode((string)$raw, true);
            if (is_array($decoded)) {
                $state = $decoded;
            }
        }

        $sitemapXmlPath = $this->rootDir . DIRECTORY_SEPARATOR . 'sitemap.xml';
        $sitemapHtmlPath = $this->rootDir . DIRECTORY_SEPARATOR . 'sitemap.html';
        $llmsTxtPath = $this->rootDir . DIRECTORY_SEPARATOR . 'llms.txt';
        $llmsFullTxtPath = $this->rootDir . DIRECTORY_SEPARATOR . 'llms-full.txt';

        $blogsMdDir = $this->rootDir . DIRECTORY_SEPARATOR . 'content-md' . DIRECTORY_SEPARATOR . 'blogs';
        $casesMdDir = $this->rootDir . DIRECTORY_SEPARATOR . 'content-md' . DIRECTORY_SEPARATOR . 'case-studies';

        $blogFiles = is_dir($blogsMdDir) ? (glob($blogsMdDir . DIRECTORY_SEPARATOR . '*.md') ?: []) : [];
        $caseFiles = is_dir($casesMdDir) ? (glob($casesMdDir . DIRECTORY_SEPARATOR . '*.md') ?: []) : [];

        $blogsCount = count($this->getPublishedBlogs());
        $casesCount = count($this->getPublishedCaseStudies());

        return [
            'sitemap_xml' => [
                'exists' => file_exists($sitemapXmlPath),
                'size' => file_exists($sitemapXmlPath) ? filesize($sitemapXmlPath) : 0,
                'modified' => file_exists($sitemapXmlPath) ? date('Y-m-d H:i:s', (int)filemtime($sitemapXmlPath)) : null,
                'url' => '/sitemap.xml'
            ],
            'sitemap_html' => [
                'exists' => file_exists($sitemapHtmlPath),
                'size' => file_exists($sitemapHtmlPath) ? filesize($sitemapHtmlPath) : 0,
                'modified' => file_exists($sitemapHtmlPath) ? date('Y-m-d H:i:s', (int)filemtime($sitemapHtmlPath)) : null,
                'url' => '/sitemap.html'
            ],
            'llms_txt' => [
                'exists' => file_exists($llmsTxtPath),
                'size' => file_exists($llmsTxtPath) ? filesize($llmsTxtPath) : 0,
                'modified' => file_exists($llmsTxtPath) ? date('Y-m-d H:i:s', (int)filemtime($llmsTxtPath)) : null,
                'url' => '/llms.txt'
            ],
            'llms_full_txt' => [
                'exists' => file_exists($llmsFullTxtPath),
                'size' => file_exists($llmsFullTxtPath) ? filesize($llmsFullTxtPath) : 0,
                'modified' => file_exists($llmsFullTxtPath) ? date('Y-m-d H:i:s', (int)filemtime($llmsFullTxtPath)) : null,
                'url' => '/llms-full.txt'
            ],
            'markdown' => [
                'blogs_published' => $blogsCount,
                'blogs_md_count' => count($blogFiles),
                'cases_published' => $casesCount,
                'cases_md_count' => count($caseFiles),
            ],
            'last_generation_time' => $state['last_generation_time'] ?? null,
            'duration_ms' => $state['duration_ms'] ?? null,
            'last_error' => !empty($state['errors']) ? implode('; ', $state['errors']) : null,
            'success' => $state['success'] ?? (file_exists($sitemapXmlPath) && file_exists($llmsTxtPath))
        ];
    }

    /**
     * Persist generation state
     */
    private function saveState(array $data): void
    {
        $dir = dirname($this->stateFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->safeAtomicWrite($this->stateFile, $json);
    }

    /**
     * Safe temporary-file writing followed by atomic replacement.
     */
    public function safeAtomicWrite(string $filePath, string $content): bool
    {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new RuntimeException("Directory could not be created: {$dir}");
            }
        }

        $tempFile = $dir . DIRECTORY_SEPARATOR . '.' . basename($filePath) . '.' . bin2hex(random_bytes(6)) . '.tmp';
        
        $bytes = @file_put_contents($tempFile, $content, LOCK_EX);
        if ($bytes === false) {
            // Check last error
            $lastErr = error_get_last()['message'] ?? 'Unknown filesystem error';
            throw new RuntimeException("Failed to write to temporary file {$tempFile}: {$lastErr}");
        }

        // On Windows platforms, rename() fails if the target file already exists
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && file_exists($filePath)) {
            @unlink($filePath);
        }

        if (!@rename($tempFile, $filePath)) {
            if (!@copy($tempFile, $filePath)) {
                @unlink($tempFile);
                throw new RuntimeException("Failed to atomically replace destination file: {$filePath}");
            }
            @unlink($tempFile);
        }

        @chmod($filePath, 0644);
        return true;
    }
}

/**
 * Procedural helper: on CMS blog changed
 */
function seo_on_blog_changed(int $id, ?string $oldSlug = null): array
{
    $service = new SeoService();
    return $service->onBlogChanged($id, $oldSlug);
}

/**
 * Procedural helper: on CMS case study changed
 */
function seo_on_case_study_changed(int $id, ?string $oldSlug = null): array
{
    $service = new SeoService();
    return $service->onCaseStudyChanged($id, $oldSlug);
}

/**
 * Procedural helper: regenerate all SEO files
 */
function seo_regenerate_all(): array
{
    $service = new SeoService();
    return $service->generateAll();
}

/**
 * Procedural helper: get current SEO status
 */
function seo_get_status(): array
{
    $service = new SeoService();
    return $service->getSeoStatus();
}
