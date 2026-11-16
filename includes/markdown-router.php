<?php
/**
 * BusinessDoctor — Universal Central Markdown Router
 * Serves machine-readable, raw Markdown representations for any eligible public page
 * whenever .md is appended to the URL or requested via clean / central endpoints.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/seo-sync.php';

class MarkdownRouter
{
    /**
     * Main dispatch entry point
     */
    public static function handleRequest(?string $requestUri = null): void
    {
        $uri = $requestUri ?? ($_SERVER['REQUEST_URI'] ?? '/');
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'] ?? '/';

        // Parse query string parameters into an associative array
        $queryParams = [];
        if (!empty($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }
        // Merge with $_GET to support both internal rewrites and external queries
        $params = array_merge($_GET, $queryParams);

        // Security Check 1: Directory traversal protection
        if (str_contains($path, '..') || str_contains($path, '\\')) {
            self::sendNotFound("Invalid path traversal sequence detected.");
        }

        // Security Check 2: Strictly block private and administrative namespaces
        if (preg_match('#^/(?:admin|database|scratch|includes|api)(?:/|$)#i', $path)) {
            self::sendNotFound("Access denied: Administrative and internal endpoints cannot be rendered as Markdown.");
        }

                // Handle direct discovery files: llms.txt, llms.md, sitemap.xml
        if ($path === '/llms.txt') {
            $content = SeoSyncEngine::generateLlmsTxt();
            header("Content-Type: text/plain; charset=UTF-8");
            header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Access-Control-Allow-Origin: *");
            echo $content;
            exit;
        }

        if ($path === '/llms.md') {
            $content = SeoSyncEngine::generateLlmsMd();
            self::sendResponse($content);
        }

        if ($path === '/sitemap.xml') {
            $content = SeoSyncEngine::generateSitemapXml();
            header("Content-Type: application/xml; charset=UTF-8");
            header("Cache-Control: no-cache, no-store, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $content;
            exit;
        }
        // Determine if this is a Markdown request
        $isMarkdownRequest = false;
        $cleanRoute = $path;

        if ($path === '/.md' || $path === '.md') {
            $isMarkdownRequest = true;
            $cleanRoute = '/';
        } elseif (str_ends_with($path, '.md')) {
            $isMarkdownRequest = true;
            $cleanRoute = substr($path, 0, -3);
        } elseif ($path === '/md' || $path === '/md/') {
            $isMarkdownRequest = true;
            $cleanRoute = '/md';
        } elseif (str_starts_with($path, '/md/')) {
            $isMarkdownRequest = true;
        }

        if (!$isMarkdownRequest) {
            // Not a markdown request; return to allow normal pipeline to continue if included
            return;
        }

        // Normalize clean route
        $cleanRoute = ($cleanRoute !== '/') ? rtrim($cleanRoute, '/') : '/';

        // ----------------------------------------------------
        // 1. Central Markdown Index: /md or /md/ or /md/index
        // ----------------------------------------------------
        if ($cleanRoute === '/md' || $cleanRoute === '/md/index') {
            self::sendResponse(SeoSyncEngine::generateMdMasterIndex());
        }

        // ----------------------------------------------------
        // 2. Central /md/... Sub-repository Mirror Requests
        // ----------------------------------------------------
        if (str_starts_with($path, '/md/')) {
            $subPath = substr($path, 4); // Strip '/md/'
            if (str_ends_with($subPath, '.md')) {
                $subClean = substr($subPath, 0, -3);
            } else {
                $subClean = $subPath;
            }

            if ($subClean === 'home' || $subClean === 'index') {
                self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('home'));
            }
            if (in_array($subClean, ['about', 'contact', 'audit', 'services', 'insights', 'case-studies'], true)) {
                self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown($subClean));
            }
            if (preg_match('#^(?:services|company)/([a-zA-Z0-9_-]+)$#', $subClean, $m)) {
                self::renderServiceMarkdown($m[1]);
            }
            if (preg_match('#^insights/([a-zA-Z0-9_-]+)$#', $subClean, $m)) {
                self::renderBlogMarkdown($m[1]);
            }
            if (preg_match('#^case-studies/([a-zA-Z0-9_-]+)$#', $subClean, $m)) {
                self::renderCaseStudyMarkdown($m[1]);
            }

            // Check if physical file exists in /md/...
            $physicalFile = ROOT_PATH . '/md/' . ltrim($subPath, '/');
            if (file_exists($physicalFile) && is_file($physicalFile)) {
                self::sendResponse(file_get_contents($physicalFile));
            }
        }

        // ----------------------------------------------------
        // 3. Homepage Markdown: /.md, /index.php.md, /home.md
        // ----------------------------------------------------
        if ($cleanRoute === '/' || $cleanRoute === '/index.php' || $cleanRoute === '/home' || $cleanRoute === '/index') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('home'));
        }

        // ----------------------------------------------------
        // 4. About Page Markdown: /about.php.md, /about.md
        // ----------------------------------------------------
        if ($cleanRoute === '/about.php' || $cleanRoute === '/about') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('about'));
        }

        // ----------------------------------------------------
        // 5. Contact Page Markdown: /contact.php.md, /contact.md
        // ----------------------------------------------------
        if ($cleanRoute === '/contact.php' || $cleanRoute === '/contact') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('contact'));
        }

        // ----------------------------------------------------
        // 6. Services Overview: /company-in-delhi.md, /services.php.md, /services.md, /company.md
        // ----------------------------------------------------
        if ($cleanRoute === '/company-in-delhi' || $cleanRoute === '/services.php' || $cleanRoute === '/services' || $cleanRoute === '/company') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('services'));
        }

        // ----------------------------------------------------
        // 7. Individual Service Detail Pages:
        //    A: /company/{slug}.md (Canonical)
        //    B: /{slug}-company-in-delhi.md (301 redirect to /company/{slug}.md)
        //    C: /services/{slug}.md (301 redirect to /company/{slug}.md)
        //    D: /service-detail.php.md?slug={slug} (301 redirect)
        // ----------------------------------------------------
        if (preg_match('#^/company/([a-zA-Z0-9_-]+)$#', $cleanRoute, $m)) {
            self::renderServiceMarkdown($m[1]);
        }
        if (preg_match('#^/([a-zA-Z0-9_-]+)-company-in-delhi$#', $cleanRoute, $m)) {
            header("Location: " . getMarkdownUrl(getServiceUrl($m[1])), true, 301);
            exit;
        }
        if (preg_match('#^/services/([a-zA-Z0-9_-]+)$#', $cleanRoute, $m)) {
            header("Location: " . getMarkdownUrl(getServiceUrl($m[1])), true, 301);
            exit;
        }
        if ($cleanRoute === '/service-detail.php' || $cleanRoute === '/service-detail') {
            $slug = $params['slug'] ?? '';
            if (empty($slug)) {
                self::sendNotFound("No practice discipline slug was specified.");
            }
            header("Location: " . getMarkdownUrl(getServiceUrl((string)$slug)), true, 301);
            exit;
        }

        // ----------------------------------------------------
        // 8. Blog Listing: /blog.md, /blog.php.md, /insights.php.md, /insights.md
        // ----------------------------------------------------
        if ($cleanRoute === '/blog' || $cleanRoute === '/blog.php' || $cleanRoute === '/insights.php' || $cleanRoute === '/insights') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('insights'));
        }

        // ----------------------------------------------------
        // 9. Individual Blog Detail:
        //    A: /blog/{slug}.md (Canonical)
        //    B: /insights/{slug}.md (301 redirect to /blog/{slug}.md)
        //    C: /insight-detail.php.md?slug={slug}
        // ----------------------------------------------------
        if (preg_match('#^/blog/([a-zA-Z0-9_-]+)$#', $cleanRoute, $m)) {
            self::renderBlogMarkdown($m[1]);
        }
        if (preg_match('#^/insights/([a-zA-Z0-9_-]+)$#', $cleanRoute, $m)) {
            $targetSlug = $m[1];
            header("Location: " . SeoSyncEngine::getBaseUrl() . "/blog/" . $targetSlug . ".md", true, 301);
            exit;
        }
        if ($cleanRoute === '/insight-detail.php' || $cleanRoute === '/insight-detail' || $cleanRoute === '/blog-detail.php' || $cleanRoute === '/blog-detail') {
            $slug = $params['slug'] ?? '';
            if (empty($slug)) {
                self::sendNotFound("No blog article slug was specified in query parameters.");
            }
            self::renderBlogMarkdown((string)$slug);
        }

        // ----------------------------------------------------
        // 10. Case Studies Listing: /case-studies.php.md, /case-studies.md
        // ----------------------------------------------------
        if ($cleanRoute === '/case-studies.php' || $cleanRoute === '/case-studies') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('case-studies'));
        }

        // ----------------------------------------------------
        // 11. Individual Case Study Detail:
        //     A: /case-study-detail.php.md?slug={slug}
        //     B: /case-studies/{slug}.md
        // ----------------------------------------------------
        if ($cleanRoute === '/case-study-detail.php' || $cleanRoute === '/case-study-detail') {
            $slug = $params['slug'] ?? '';
            if (empty($slug)) {
                self::sendNotFound("No case study slug was specified in query parameters.");
            }
            self::renderCaseStudyMarkdown((string)$slug);
        }
        if (preg_match('#^/case-studies/([a-zA-Z0-9_-]+)$#', $cleanRoute, $m)) {
            self::renderCaseStudyMarkdown($m[1]);
        }

        // ----------------------------------------------------
        // 12. Digital Audit: /audit.php.md, /audit.md, /diagnostic.php.md, /diagnostic.md
        // ----------------------------------------------------
        if ($cleanRoute === '/audit.php' || $cleanRoute === '/audit' || $cleanRoute === '/diagnostic.php' || $cleanRoute === '/diagnostic') {
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('audit'));
        }

        // ----------------------------------------------------
        // 13. Direct Physical Root Markdown Files (e.g. llms.md)
        // ----------------------------------------------------
        $rootTarget = ROOT_PATH . '/' . ltrim($path, '/');
        if (file_exists($rootTarget) && is_file($rootTarget)) {
            self::sendResponse(file_get_contents($rootTarget));
        }

        // ----------------------------------------------------
        // 14. Fallback: 404 for Unknown or Unmapped Route
        // ----------------------------------------------------
        self::sendNotFound("The requested Markdown document '{$path}' does not correspond to any published public page.");
    }

    /**
     * Resolve and render an individual Service practice area
     */
    private static function renderServiceMarkdown(string $slug): void
    {
        $cleanSlug = strtolower(trim($slug));
        if (str_starts_with($cleanSlug, 'company/')) {
            $cleanSlug = substr($cleanSlug, 8);
        } elseif (str_starts_with($cleanSlug, 'services/')) {
            $cleanSlug = substr($cleanSlug, 9);
        }
        if (str_ends_with($cleanSlug, '-company-in-delhi')) {
            $cleanSlug = substr($cleanSlug, 0, -17);
        }
        $cleanSlug = trim($cleanSlug, '/');

        $canonicalUrl = getServiceUrl($cleanSlug);
        $canonicalPath = parse_url($canonicalUrl, PHP_URL_PATH);
        $canonicalSlug = basename($canonicalPath);

        if ($cleanSlug !== $canonicalSlug) {
            header("Location: " . getMarkdownUrl($canonicalUrl), true, 301);
            exit;
        }

        $services = SeoSyncEngine::getActiveServices();
        if (!isset($services[$cleanSlug])) {
            self::sendNotFound("Practice discipline '{$cleanSlug}' does not exist or is not active.");
        }
        self::sendResponse(SeoSyncEngine::generateServiceMarkdown($cleanSlug, $services[$cleanSlug]));
    }

    /**
     * Resolve and render an individual published Blog Article
     */
    private static function renderBlogMarkdown(string $slug): void
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM insights WHERE slug = ? AND status = 'published' AND is_deleted = 0 LIMIT 1");
            $stmt->execute([$slug]);
            $blog = $stmt->fetch();

            if (!$blog) {
                self::sendNotFound("The requested blog article '{$slug}' does not exist or has been unpublished.");
            }

            self::sendResponse(SeoSyncEngine::generateBlogMarkdown($blog));
        } catch (Exception $e) {
            self::sendNotFound("Database resolution error for article '{$slug}'.");
        }
    }

    /**
     * Resolve and render an individual published Case Study
     */
    private static function renderCaseStudyMarkdown(string $slug): void
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM case_studies WHERE slug = ? AND status = 'published' AND is_deleted = 0 LIMIT 1");
            $stmt->execute([$slug]);
            $case = $stmt->fetch();

            if (!$case) {
                self::sendNotFound("The requested case study '{$slug}' does not exist or has been unpublished.");
            }

            self::sendResponse(SeoSyncEngine::generateCaseStudyMarkdown($case));
        } catch (Exception $e) {
            self::sendNotFound("Database resolution error for case study '{$slug}'.");
        }
    }

    /**
     * Send clean raw Markdown HTTP response with required headers
     */
    private static function sendResponse(string $markdown): void
    {
        header('Content-Type: text/markdown; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');
        header('X-Robots-Tag: index, follow');
        header('Cache-Control: public, max-age=3600');
        echo $markdown;
        exit;
    }

    /**
     * Send clean raw Markdown 404 response
     */
    private static function sendNotFound(string $reason = ''): void
    {
        http_response_code(404);
        header('Content-Type: text/markdown; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');
        header('X-Robots-Tag: noindex, nofollow');

        $baseUrl = SeoSyncEngine::getBaseUrl();
        echo "# 404 Not Found\n\n";
        echo "The requested Markdown document does not exist or has been unpublished.\n\n";
        if (!empty($reason)) {
            echo "> **Diagnostic Notice**: " . htmlspecialchars($reason) . "\n\n";
        }
        echo "Please explore our available public documentation at the master index:\n";
        echo "- Master Markdown Index: [{$baseUrl}/md]({$baseUrl}/md)\n";
        echo "- AI Discovery Document: [{$baseUrl}/llms.txt]({$baseUrl}/llms.txt)\n";
        echo "- Full LLM Knowledge Graph: [{$baseUrl}/llms.md]({$baseUrl}/llms.md)\n";
        exit;
    }
}
