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

                // Handle direct discovery files: llms.txt, sitemap.xml
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
        } elseif (str_starts_with($path, '/md/') && str_ends_with($path, '.md')) {
            $isMarkdownRequest = true;
        }

        if (!$isMarkdownRequest) {
            // Not a markdown request; return to allow normal pipeline to continue if included
            return;
        }

        // Normalize clean route
        $cleanRoute = ($cleanRoute !== '/') ? rtrim($cleanRoute, '/') : '/';

        // Block any request trying to access an index on /md or retired /llms.md
        if ($cleanRoute === '/md' || $cleanRoute === '/md/index' || $cleanRoute === '/llms' || $path === '/llms.md') {
            self::sendNotFound("The requested Markdown document does not exist.");
        }

        // ----------------------------------------------------
        // 1. Central /md/... Sub-repository Mirror Requests (*.md)
        // ----------------------------------------------------
        if (str_starts_with($path, '/md/')) {
            $subPath = substr($path, 4); // Strip '/md/'
            if ($subPath === 'index.md' || $subPath === 'index') {
                self::sendNotFound("The requested Markdown document does not exist.");
            }
            $physicalFile = ROOT_PATH . '/md/' . ltrim($subPath, '/');
            if (file_exists($physicalFile) && is_file($physicalFile)) {
                self::sendResponse(file_get_contents($physicalFile));
            }

            if (str_ends_with($subPath, '.md')) {
                $subClean = substr($subPath, 0, -3);
            } else {
                $subClean = $subPath;
            }

            if ($subClean === 'home' || $subClean === 'index') {
                $physicalHome = ROOT_PATH . '/md/home.md';
                if (file_exists($physicalHome) && is_file($physicalHome)) {
                    self::sendResponse(file_get_contents($physicalHome));
                }
                self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('home'));
            }
            if (in_array($subClean, ['about', 'contact', 'audit', 'services', 'insights', 'case-studies'], true)) {
                $physicalPage = ROOT_PATH . '/md/' . $subClean . '.md';
                if (file_exists($physicalPage) && is_file($physicalPage)) {
                    self::sendResponse(file_get_contents($physicalPage));
                }
                self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown($subClean));
            }
            if (preg_match('#^(?:services|service|company)/([a-zA-Z0-9_-]+)$#', $subClean, $m)) {
                self::renderServiceMarkdown($m[1]);
            }
            if (preg_match('#^(?:insights|blog)/([a-zA-Z0-9_-]+)$#', $subClean, $m)) {
                self::renderBlogMarkdown($m[1]);
            }
            if (preg_match('#^case-studies/([a-zA-Z0-9_-]+)$#', $subClean, $m)) {
                self::renderCaseStudyMarkdown($m[1]);
            }
        }

        // ----------------------------------------------------
        // 3. Homepage Markdown: /home.md, /.md, /home, /index.php.md
        // ----------------------------------------------------
        if ($cleanRoute === '/' || $cleanRoute === '/index.php' || $cleanRoute === '/home' || $cleanRoute === '/index') {
            $physicalHome = ROOT_PATH . '/md/home.md';
            if (file_exists($physicalHome) && is_file($physicalHome)) {
                self::sendResponse(file_get_contents($physicalHome));
            }
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('home'));
        }

        // ----------------------------------------------------
        // 4. About Page Markdown: /about.php.md, /about.md
        // ----------------------------------------------------
        if ($cleanRoute === '/about.php' || $cleanRoute === '/about') {
            $physicalAbout = ROOT_PATH . '/md/about.md';
            if (file_exists($physicalAbout) && is_file($physicalAbout)) {
                self::sendResponse(file_get_contents($physicalAbout));
            }
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('about'));
        }

        // ----------------------------------------------------
        // 5. Contact Page Markdown: /contact.php.md, /contact.md
        // ----------------------------------------------------
        if ($cleanRoute === '/contact.php' || $cleanRoute === '/contact') {
            $physicalContact = ROOT_PATH . '/md/contact.md';
            if (file_exists($physicalContact) && is_file($physicalContact)) {
                self::sendResponse(file_get_contents($physicalContact));
            }
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('contact'));
        }

        // ----------------------------------------------------
        // 6. Services Overview: /services.md, /services, /company.md
        // ----------------------------------------------------
        if (in_array($cleanRoute, ['/services', '/services.php', '/company', '/company-in-delhi', '/digital-marketing-company-in-delhi'], true)) {
            $physicalServices = ROOT_PATH . '/md/services.md';
            if (file_exists($physicalServices) && is_file($physicalServices)) {
                self::sendResponse(file_get_contents($physicalServices));
            }
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('services'));
        }

        // ----------------------------------------------------
        // 7. Individual Service Detail Pages:
        //    A: /service/{slug}.md
        //    B: /company/{slug}.md
        //    C: /services/{slug}.md
        //    D: /{slug}-company-in-delhi.md
        //    E: /service-detail.php.md?slug={slug}
        // ----------------------------------------------------
        if (preg_match('#^/(?:service|services|company)/([a-zA-Z0-9_-]+)$#', $cleanRoute, $m) || preg_match('#^/([a-zA-Z0-9_-]+)-company-in-delhi$#', $cleanRoute, $m)) {
            if ($m[1] === 'digital-marketing') {
                $physicalServices = ROOT_PATH . '/md/services.md';
                if (file_exists($physicalServices) && is_file($physicalServices)) {
                    self::sendResponse(file_get_contents($physicalServices));
                }
                self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('services'));
            }
            self::renderServiceMarkdown($m[1]);
        }
        if ($cleanRoute === '/service-detail.php' || $cleanRoute === '/service-detail') {
            $slug = $params['slug'] ?? '';
            if (empty($slug)) {
                self::sendNotFound("No practice discipline slug was specified.");
            }
            self::renderServiceMarkdown((string)$slug);
        }

        // ----------------------------------------------------
        // 8. Blog Listing: /blog.md, /blog.php.md, /insights.php.md, /insights.md
        // ----------------------------------------------------
        if ($cleanRoute === '/blog' || $cleanRoute === '/blog.php' || $cleanRoute === '/insights.php' || $cleanRoute === '/insights') {
            $physicalInsights = ROOT_PATH . '/md/insights.md';
            if (file_exists($physicalInsights) && is_file($physicalInsights)) {
                self::sendResponse(file_get_contents($physicalInsights));
            }
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
            $physicalCases = ROOT_PATH . '/md/case-studies.md';
            if (file_exists($physicalCases) && is_file($physicalCases)) {
                self::sendResponse(file_get_contents($physicalCases));
            }
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
            $physicalAudit = ROOT_PATH . '/md/audit.md';
            if (file_exists($physicalAudit) && is_file($physicalAudit)) {
                self::sendResponse(file_get_contents($physicalAudit));
            }
            self::sendResponse(SeoSyncEngine::generateStaticPageMarkdown('audit'));
        }

        // ----------------------------------------------------
        // 13. Direct / Custom Physical Markdown Files in /md/
        //     e.g. /custom-page.md -> ROOT_PATH/md/custom-page.md
        // ----------------------------------------------------
        $trimmedRoute = trim($cleanRoute, '/');
        if ($trimmedRoute !== '') {
            $customCandidate1 = ROOT_PATH . '/md/' . $trimmedRoute . '.md';
            $customCandidate2 = ROOT_PATH . '/md/' . $trimmedRoute;
            if (file_exists($customCandidate1) && is_file($customCandidate1)) {
                self::sendResponse(file_get_contents($customCandidate1));
            }
            if (file_exists($customCandidate2) && is_file($customCandidate2)) {
                self::sendResponse(file_get_contents($customCandidate2));
            }
        }

        // ----------------------------------------------------
        // 14. Direct Physical Root Markdown Files (e.g. llms.md)
        // ----------------------------------------------------
        $rootTarget = ROOT_PATH . '/' . ltrim($path, '/');
        if (file_exists($rootTarget) && is_file($rootTarget)) {
            self::sendResponse(file_get_contents($rootTarget));
        }

        // ----------------------------------------------------
        // 15. Fallback: 404 for Unknown or Unmapped Route
        // ----------------------------------------------------
        self::sendNotFound("The requested Markdown document '{$path}' does not correspond to any published public page.");
    }

    /**
     * Resolve and render an individual Service practice area
     */
    private static function renderServiceMarkdown(string $slug): void
    {
        $physicalFile = ROOT_PATH . '/md/services/' . $slug . '.md';
        if (file_exists($physicalFile) && is_file($physicalFile)) {
            self::sendResponse(file_get_contents($physicalFile));
        }

        $practice = getPracticeBySlug($slug);
        if (!$practice) {
            self::sendNotFound("Practice discipline '{$slug}' does not exist or is not active.");
        }

        self::sendResponse(SeoSyncEngine::generateServiceMarkdown($practice['slug'], $practice));
    }

    /**
     * Resolve and render an individual published Blog Article
     */
    private static function renderBlogMarkdown(string $slug): void
    {
        $physicalFile = ROOT_PATH . '/md/insights/' . $slug . '.md';
        if (file_exists($physicalFile) && is_file($physicalFile)) {
            self::sendResponse(file_get_contents($physicalFile));
        }

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
        $physicalFile = ROOT_PATH . '/md/case-studies/' . $slug . '.md';
        if (file_exists($physicalFile) && is_file($physicalFile)) {
            self::sendResponse(file_get_contents($physicalFile));
        }

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
        exit;
    }
}
