<?php
/**
 * BusinessDoctor — Automated SEO, Schema & LLM Discovery Engine
 * Synchronizes sitemap.xml, llms.txt, and llms.md across the enterprise platform.
 * 
 * Provides centralized generation, atomic file writing, and audit tracking
 * for search engine indexers and generative AI discovery crawlers.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

class SeoSyncEngine
{
    private const LOG_FILE = 'database/seo_sync_log.json';

    /**
     * Get the standardized canonical base URL
     */
    public static function getBaseUrl(): string
    {
        $envUrl = getenv('APP_URL');
        if (!empty($envUrl)) {
            return rtrim($envUrl, '/');
        }
        if (defined('APP_URL') && !empty(APP_URL)) {
            return rtrim(APP_URL, '/');
        }
        if (defined('BASE_URL') && !empty(BASE_URL)) {
            return rtrim(BASE_URL, '/');
        }
        return 'https://demo.businessdoctor.com';
    }

    /**
     * Core static pages configuration
     */
    public static function getStaticPages(): array
    {
        return [
            [
                'loc' => '/',
                'file' => 'index.php',
                'priority' => '1.0',
                'changefreq' => 'daily',
                'title' => 'Home — Enterprise Technology & IT Solutions',
                'description' => 'BusinessDoctor delivers enterprise IT solutions, web & custom software development, digital marketing, UI/UX architecture, e-commerce, and cloud consulting.'
            ],
            [
                'loc' => '/services.php',
                'file' => 'services.php',
                'priority' => '0.9',
                'changefreq' => 'weekly',
                'title' => 'IT Services & Practice Areas',
                'description' => 'Explore BusinessDoctor’s six core digital disciplines: Software Engineering, SEO & Performance Ads, UI/UX, E-Commerce, Creative Production, and Cloud IT.'
            ],
            [
                'loc' => '/audit.php',
                'file' => 'audit.php',
                'priority' => '0.9',
                'changefreq' => 'weekly',
                'title' => 'Free Digital Architecture Audit & Project Scope',
                'description' => 'Diagnostic assessment tool to benchmark technical infrastructure, security posture, conversion leaks, and growth bottlenecks.'
            ],
            [
                'loc' => '/case-studies.php',
                'file' => 'case-studies.php',
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'title' => 'Client Case Studies & Proven Results',
                'description' => 'Real-world enterprise case studies showcasing measurable outcomes, revenue growth, and architectural turnarounds.'
            ],
            [
                'loc' => '/insights.php',
                'file' => 'insights.php',
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'title' => 'Perspectives, Engineering Insights & Blog',
                'description' => 'Technical teardowns, digital transformation playbooks, and strategic analysis from BusinessDoctor engineers.'
            ],
            [
                'loc' => '/about.php',
                'file' => 'about.php',
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'title' => 'About BusinessDoctor — Firm Profile & Leadership',
                'description' => 'Our history, engineering ethos, global delivery standards, and multidisciplinary leadership team.'
            ],
            [
                'loc' => '/contact.php',
                'file' => 'contact.php',
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'title' => 'Contact Us & Executive Advisory',
                'description' => 'Schedule a strategic diagnostic call, request an enterprise proposal, or reach our technical practice leads.'
            ]
        ];
    }

    /**
     * Fetch active published services
     */
    public static function getActiveServices(): array
    {
        return getPracticeAreas();
    }

    /**
     * Fetch published case studies from SQLite database
     */
    public static function getPublishedCaseStudies(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("
                SELECT * FROM case_studies 
                WHERE status = 'published' AND is_deleted = 0 
                ORDER BY sort_order ASC, id DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            error_log("SeoSyncEngine::getPublishedCaseStudies error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch published insights / blogs from SQLite database
     */
    public static function getPublishedInsights(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query("
                SELECT * FROM insights 
                WHERE status = 'published' AND is_deleted = 0 
                ORDER BY published_at DESC, id DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            error_log("SeoSyncEngine::getPublishedInsights error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Generate standard XML Sitemap adhering to sitemaps.org
     */
    public static function generateSitemapXml(): string
    {
        $baseUrl = self::getBaseUrl();
        $today = date('Y-m-d');
        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // 1. Static Pages
        foreach (self::getStaticPages() as $page) {
            $lastmod = $today;
            $filePath = ROOT_PATH . '/' . $page['file'];
            if (file_exists($filePath)) {
                $lastmod = date('Y-m-d', filemtime($filePath));
            }
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($baseUrl . $page['loc']) . '</loc>';
            $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
            $xml[] = '    <changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml[] = '    <priority>' . $page['priority'] . '</priority>';
            $xml[] = '  </url>';
        }

        // 2. Services (Clean URLs: /services/{slug})
        foreach (self::getActiveServices() as $slug => $service) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($baseUrl . '/services/' . $slug) . '</loc>';
            $xml[] = '    <lastmod>' . $today . '</lastmod>';
            $xml[] = '    <changefreq>weekly</changefreq>';
            $xml[] = '    <priority>0.8</priority>';
            $xml[] = '  </url>';
        }

        // 3. Case Studies (/case-study-detail.php?slug={slug})
        foreach (self::getPublishedCaseStudies() as $case) {
            $caseSlug = $case['slug'];
            $lastmod = !empty($case['updated_at']) ? date('Y-m-d', strtotime((string)$case['updated_at'])) : (!empty($case['created_at']) ? date('Y-m-d', strtotime((string)$case['created_at'])) : $today);
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($baseUrl . '/case-study-detail.php?slug=' . urlencode($caseSlug)) . '</loc>';
            $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
            $xml[] = '    <changefreq>monthly</changefreq>';
            $xml[] = '    <priority>0.7</priority>';
            $xml[] = '  </url>';
        }

        // 4. Insights / Blogs (/insight-detail.php?slug={slug})
        foreach (self::getPublishedInsights() as $insight) {
            $insightSlug = $insight['slug'];
            $lastmod = !empty($insight['updated_at']) ? date('Y-m-d', strtotime((string)$insight['updated_at'])) : (!empty($insight['published_at']) ? date('Y-m-d', strtotime((string)$insight['published_at'])) : $today);
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($baseUrl . '/insight-detail.php?slug=' . urlencode($insightSlug)) . '</loc>';
            $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
            $xml[] = '    <changefreq>monthly</changefreq>';
            $xml[] = '    <priority>0.7</priority>';
            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';
        $xml[] = '';

        return implode("\n", $xml);
    }

    /**
     * Generate concise /llms.txt AI discovery file (https://llmstxt.org)
     */
    public static function generateLlmsTxt(): string
    {
        $baseUrl = self::getBaseUrl();
        $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
        $tagline = defined('APP_TAGLINE') ? APP_TAGLINE : 'Engineering Technology. Accelerating Digital Growth.';

        $services = self::getActiveServices();
        $insights = self::getPublishedInsights();
        $cases = self::getPublishedCaseStudies();

        $lines = [];
        $lines[] = "# {$appName}";
        $lines[] = "> {$tagline}";
        $lines[] = "";
        $lines[] = "BusinessDoctor is an enterprise digital services practice delivering full-stack software development, performance digital marketing, UI/UX architecture, e-commerce marketplace scaling, creative video production, and cloud IT infrastructure.";
        $lines[] = "";
        $lines[] = "## Core Practice Disciplines";
        foreach ($services as $slug => $s) {
            $name = $s['name'];
            $summary = rtrim(strip_tags($s['summary'] ?? $s['tagline']), '.');
            $lines[] = "- [{$name}]({$baseUrl}/services/{$slug}): {$summary}.";
        }
        $lines[] = "";

        $lines[] = "## Published Editorial & Insights";
        if (empty($insights)) {
            $lines[] = "- No editorial articles currently published.";
        } else {
            foreach ($insights as $art) {
                $title = trim($art['title']);
                $slug = $art['slug'];
                $summary = !empty($art['summary']) ? $art['summary'] : (!empty($art['excerpt']) ? $art['excerpt'] : 'Technical insight and editorial analysis.');
                $summary = trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
                if (mb_strlen($summary) > 160) {
                    $summary = mb_substr($summary, 0, 157) . '...';
                }
                $lines[] = "- [{$title}]({$baseUrl}/insight-detail.php?slug={$slug}): {$summary}";
            }
        }
        $lines[] = "";

        $lines[] = "## Client Case Studies & Proven Results";
        if (empty($cases)) {
            $lines[] = "- No public case studies currently published.";
        } else {
            foreach ($cases as $c) {
                $title = trim($c['title']);
                $slug = $c['slug'];
                $industry = $c['industry'] ?: ($c['client_industry'] ?: 'Enterprise');
                $baseline = $c['baseline_metric'] ?? '';
                $outcome = $c['outcome_metric'] ?? '';
                $metricText = ($baseline && $outcome) ? " ({$baseline} → {$outcome})" : ($outcome ? " ({$outcome})" : "");
                $desc = !empty($c['challenge']) ? trim(preg_replace('/\s+/', ' ', strip_tags($c['challenge']))) : 'Enterprise implementation and performance turnaround.';
                if (mb_strlen($desc) > 140) {
                    $desc = mb_substr($desc, 0, 137) . '...';
                }
                $lines[] = "- [{$title}]({$baseUrl}/case-study-detail.php?slug={$slug}): [{$industry}]{$metricText} {$desc}";
            }
        }
        $lines[] = "";

        $lines[] = "## Public Tools & Resources";
        $lines[] = "- [Free Digital Architecture Audit]({$baseUrl}/audit.php): Proprietary diagnostic benchmarking technical bottlenecks, security vulnerabilities, conversion leaks, and scale readiness.";
        $lines[] = "- [Comprehensive AI Documentation Index]({$baseUrl}/llms.md): Complete machine-readable markdown reference containing full practice details, technical capabilities, and comprehensive catalog.";
        $lines[] = "- [Executive Advisory & Project Inquiries]({$baseUrl}/contact.php): Direct communication portal for engineering scoping, proposals, and consultative advisory.";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Generate in-depth /llms.md documentation index for AI systems & LLM RAG
     */
    public static function generateLlmsMd(): string
    {
        $baseUrl = self::getBaseUrl();
        $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
        $legalName = defined('APP_LEGAL_NAME') ? APP_LEGAL_NAME : 'BusinessDoctor IT Solutions & Digital Services Private Limited';
        $tagline = defined('APP_TAGLINE') ? APP_TAGLINE : 'Engineering Technology. Accelerating Digital Growth.';
        $phone = defined('APP_PHONE') ? APP_PHONE : '+1 (800) 492-3628';
        $email = defined('APP_EMAIL') ? APP_EMAIL : 'solutions@businessdoctor.com';
        $hq = defined('APP_HEADQUARTERS') ? APP_HEADQUARTERS : 'Executive Tech Park, Innovation District';

        $services = self::getActiveServices();
        $insights = self::getPublishedInsights();
        $cases = self::getPublishedCaseStudies();

        $lines = [];
        $lines[] = "# {$appName} — Enterprise Knowledge Base & LLM Index";
        $lines[] = "> {$tagline}";
        $lines[] = "";
        $lines[] = "Canonical Source: {$baseUrl}";
        $lines[] = "Last Updated: " . date('Y-m-d H:i:s T');
        $lines[] = "";

        // Executive Overview
        $lines[] = "## 1. Executive Overview & Firm Profile";
        $lines[] = "";
        $lines[] = "{$appName} ({$legalName}) is a premium technology and digital growth practice. The firm combines deep software engineering capabilities with revenue-focused digital marketing, conversion-centered design, and robust cloud infrastructure operations.";
        $lines[] = "";
        $lines[] = "- **Firm Legal Name**: {$legalName}";
        $lines[] = "- **Primary URL**: {$baseUrl}";
        $lines[] = "- **Inquiries**: {$email} | Telephone: {$phone}";
        $lines[] = "- **Global Operations**: {$hq}";
        $lines[] = "- **Engineering Philosophy**: Sub-second server responses, zero framework bloat, semantic accessible HTML5, resilient SQLite / MariaDB data layers, and privacy-first analytics.";
        $lines[] = "";

        // Core Practice Disciplines
        $lines[] = "## 2. Core Practice Disciplines & Deliverables";
        $lines[] = "";
        foreach ($services as $slug => $s) {
            $num = $s['number'] ?? '';
            $name = $s['name'] ?? '';
            $sTagline = $s['tagline'] ?? '';
            $desc = $s['description'] ?? $s['summary'] ?? '';
            $url = "{$baseUrl}/services/{$slug}";

            $lines[] = "### 2.{$num} {$name}";
            $lines[] = "**Tagline**: {$sTagline}";
            $lines[] = "**Canonical URL**: [{$url}]({$url})";
            $lines[] = "";
            $lines[] = $desc;
            $lines[] = "";
            
            if (!empty($s['deliverables']) && is_array($s['deliverables'])) {
                $lines[] = "**Key Deliverables:**";
                foreach ($s['deliverables'] as $del) {
                    $lines[] = "- " . $del;
                }
                $lines[] = "";
            }

            if (!empty($s['kpis']) && is_array($s['kpis'])) {
                $lines[] = "**Target Performance KPIs:**";
                foreach ($s['kpis'] as $kpi) {
                    $lines[] = "- " . $kpi;
                }
                $lines[] = "";
            }
        }

        // Case Studies
        $lines[] = "## 3. Client Case Studies & Proof of Performance";
        $lines[] = "";
        if (empty($cases)) {
            $lines[] = "No public case studies are currently published in the repository.";
            $lines[] = "";
        } else {
            foreach ($cases as $idx => $c) {
                $num = $idx + 1;
                $title = $c['title'];
                $slug = $c['slug'];
                $url = "{$baseUrl}/case-study-detail.php?slug={$slug}";
                $industry = $c['industry'] ?: ($c['client_industry'] ?: 'Enterprise');
                $practice = $c['service_category'] ?: ($c['practice_area'] ?: 'Digital Practice');
                $client = !empty($c['client_name']) ? $c['client_name'] : 'Confidential Enterprise Client';

                $lines[] = "### 3.{$num} {$title}";
                $lines[] = "- **Canonical URL**: [{$url}]({$url})";
                $lines[] = "- **Industry**: {$industry} | **Discipline**: {$practice}";
                $lines[] = "- **Client**: {$client}";
                if (!empty($c['baseline_metric']) || !empty($c['outcome_metric'])) {
                    $lines[] = "- **Metric Shift**: `{$c['baseline_metric']}` → `{$c['outcome_metric']}`" . (!empty($c['metric_label']) ? " ({$c['metric_label']})" : "");
                }
                $lines[] = "";

                if (!empty($c['challenge'])) {
                    $lines[] = "**The Challenge / Operational Bottleneck:**";
                    $lines[] = trim(preg_replace('/\s+/', ' ', strip_tags($c['challenge'])));
                    $lines[] = "";
                }

                if (!empty($c['solution']) || !empty($c['prescription'])) {
                    $lines[] = "**Prescribed Engineering & Strategic Solution:**";
                    $lines[] = trim(preg_replace('/\s+/', ' ', strip_tags($c['solution'] ?: $c['prescription'])));
                    $lines[] = "";
                }

                if (!empty($c['implementation'])) {
                    $lines[] = "**Implementation Architecture:**";
                    $lines[] = trim(preg_replace('/\s+/', ' ', strip_tags($c['implementation'])));
                    $lines[] = "";
                }

                if (!empty($c['results']) || !empty($c['result_description'])) {
                    $lines[] = "**Quantifiable Business Outcomes:**";
                    $lines[] = trim(preg_replace('/\s+/', ' ', strip_tags($c['results'] ?: $c['result_description'])));
                    $lines[] = "";
                }
            }
        }

        // Editorial Insights
        $lines[] = "## 4. Editorial Perspectives & Technical Insights";
        $lines[] = "";
        if (empty($insights)) {
            $lines[] = "No technical articles are currently published in the knowledge base.";
            $lines[] = "";
        } else {
            foreach ($insights as $idx => $art) {
                $num = $idx + 1;
                $title = $art['title'];
                $slug = $art['slug'];
                $url = "{$baseUrl}/insight-detail.php?slug={$slug}";
                $author = $art['author_name'] ?: ($art['author'] ?: 'BusinessDoctor Engineering');
                $pubDate = !empty($art['published_at']) ? date('F j, Y', strtotime($art['published_at'])) : 'Published';
                $readingTime = $art['reading_time'] ?? '5 min read';
                $category = $art['category'] ?? 'Enterprise Strategy';

                $lines[] = "### 4.{$num} {$title}";
                $lines[] = "- **Canonical URL**: [{$url}]({$url})";
                $lines[] = "- **Category**: {$category} | **Read Time**: {$readingTime}";
                $lines[] = "- **Author**: {$author} | **Published**: {$pubDate}";
                $lines[] = "";

                $summary = !empty($art['summary']) ? $art['summary'] : (!empty($art['excerpt']) ? $art['excerpt'] : '');
                if (!empty($summary)) {
                    $lines[] = "**Executive Summary:**";
                    $lines[] = trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
                    $lines[] = "";
                }

                // If content is present, extract a clean markdown outline/highlights
                if (!empty($art['content'])) {
                    $rawText = strip_tags($art['content']);
                    $cleanSnippet = trim(preg_replace('/\s+/', ' ', $rawText));
                    if (mb_strlen($cleanSnippet) > 500) {
                        $cleanSnippet = mb_substr($cleanSnippet, 0, 497) . '...';
                    }
                    $lines[] = "**Key Content Preview:**";
                    $lines[] = $cleanSnippet;
                    $lines[] = "";
                }
            }
        }

        // Digital Diagnostic Tool
        $lines[] = "## 5. Proprietary Digital Diagnostic Engine";
        $lines[] = "";
        $lines[] = "BusinessDoctor operates an interactive diagnostic assessment portal at [{$baseUrl}/audit.php]({$baseUrl}/audit.php). The tool evaluates enterprise digital operations across four foundational vectors:";
        $lines[] = "1. **Architecture & Engineering**: Monolithic framework latency, Core Web Vitals (LCP, INP, CLS), database querying bottlenecks, and mobile responsiveness.";
        $lines[] = "2. **Customer Acquisition & Traffic**: PPC ad spend waste, conversion funnel friction, organic search visibility, and CAC inflation.";
        $lines[] = "3. **Systems & Security Posture**: Infrastructure uptime resilience, automated backup hygiene, SSL/TLS configurations, and API security.";
        $lines[] = "4. **Brand Positioning & Trust**: Brand architecture, UI design consistency, and marketplace Buy Box protection.";
        $lines[] = "";

        // Contact & Engagement
        $lines[] = "## 6. Enterprise Inquiries & Contact Channels";
        $lines[] = "";
        $lines[] = "- **Web Engagement Portal**: [{$baseUrl}/contact.php]({$baseUrl}/contact.php)";
        $lines[] = "- **Email Advisory**: [{$email}](mailto:{$email})";
        $lines[] = "- **Direct Phone Line**: {$phone}";
        $lines[] = "- **Headquarters**: {$hq}";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "*This document is maintained dynamically by the BusinessDoctor Centralized SEO & LLM Synchronization Engine. All rights reserved.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Atomically and safely write content to a destination file
     */
    public static function writeFileAtomic(string $filePath, string $content): bool
    {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $tempFile = $dir . DIRECTORY_SEPARATOR . '.' . basename($filePath) . '.' . bin2hex(random_bytes(4)) . '.tmp';
        
        $bytes = @file_put_contents($tempFile, $content, LOCK_EX);
        if ($bytes === false) {
            // Direct safe fallback with exclusive lock
            return file_put_contents($filePath, $content, LOCK_EX) !== false;
        }

        // Windows atomic replacement handling
        if (file_exists($filePath)) {
            if (@unlink($filePath) === false) {
                // If unlink was blocked by a transient lock, direct copy/overwrite
                $ok = @file_put_contents($filePath, $content, LOCK_EX) !== false;
                @unlink($tempFile);
                return $ok;
            }
        }

        $renamed = @rename($tempFile, $filePath);
        if (!$renamed) {
            @copy($tempFile, $filePath);
            @unlink($tempFile);
        }

        return true;
    }

    /**
     * Centralized synchronization trigger:
     * Generates and writes sitemap.xml, llms.txt, and llms.md atomically.
     * Records execution metrics in database/seo_sync_log.json.
     */
    public static function syncAll(string $triggerReason = 'System Auto-Sync'): array
    {
        $startTime = microtime(true);
        $sitemapPath = ROOT_PATH . '/sitemap.xml';
        $llmsTxtPath = ROOT_PATH . '/llms.txt';
        $llmsMdPath = ROOT_PATH . '/llms.md';
        $logPath = ROOT_PATH . '/' . self::LOG_FILE;

        $errors = [];
        $filesWritten = [];

        // 1. Generate & Write sitemap.xml
        try {
            $sitemapContent = self::generateSitemapXml();
            if (self::writeFileAtomic($sitemapPath, $sitemapContent)) {
                $filesWritten['sitemap_xml'] = [
                    'path' => 'sitemap.xml',
                    'size_bytes' => strlen($sitemapContent),
                    'status' => 'written'
                ];
            } else {
                $errors[] = 'Failed to write sitemap.xml';
            }
        } catch (Throwable $e) {
            $errors[] = 'sitemap.xml generation error: ' . $e->getMessage();
        }

        // 2. Generate & Write llms.txt
        try {
            $llmsTxtContent = self::generateLlmsTxt();
            if (self::writeFileAtomic($llmsTxtPath, $llmsTxtContent)) {
                $filesWritten['llms_txt'] = [
                    'path' => 'llms.txt',
                    'size_bytes' => strlen($llmsTxtContent),
                    'status' => 'written'
                ];
            } else {
                $errors[] = 'Failed to write llms.txt';
            }
        } catch (Throwable $e) {
            $errors[] = 'llms.txt generation error: ' . $e->getMessage();
        }

        // 3. Generate & Write llms.md
        try {
            $llmsMdContent = self::generateLlmsMd();
            if (self::writeFileAtomic($llmsMdPath, $llmsMdContent)) {
                $filesWritten['llms_md'] = [
                    'path' => 'llms.md',
                    'size_bytes' => strlen($llmsMdContent),
                    'status' => 'written'
                ];
            } else {
                $errors[] = 'Failed to write llms.md';
            }
        } catch (Throwable $e) {
            $errors[] = 'llms.md generation error: ' . $e->getMessage();
        }

        $durationMs = round((microtime(true) - $startTime) * 1000, 2);
        $status = empty($errors) ? 'success' : (count($filesWritten) > 0 ? 'partial' : 'error');

        // Metrics calculation
        $staticCount = count(self::getStaticPages());
        $servicesCount = count(self::getActiveServices());
        $casesCount = count(self::getPublishedCaseStudies());
        $insightsCount = count(self::getPublishedInsights());
        $totalSitemapUrls = $staticCount + $servicesCount + $casesCount + $insightsCount;

        $syncRecord = [
            'last_sync_timestamp' => date('Y-m-d H:i:s'),
            'last_sync_iso' => date('c'),
            'trigger_reason' => $triggerReason,
            'status' => $status,
            'duration_ms' => $durationMs,
            'errors' => $errors,
            'metrics' => [
                'static_pages' => $staticCount,
                'services' => $servicesCount,
                'case_studies' => $casesCount,
                'insights' => $insightsCount,
                'total_urls_in_sitemap' => $totalSitemapUrls
            ],
            'files' => $filesWritten
        ];

        // Persist sync log
        self::writeFileAtomic($logPath, json_encode($syncRecord, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $syncRecord;
    }

    /**
     * Retrieve status metrics for admin dashboard inspection
     */
    public static function getSyncStatus(): array
    {
        $logPath = ROOT_PATH . '/' . self::LOG_FILE;
        $logData = [];
        if (file_exists($logPath)) {
            $raw = file_get_contents($logPath);
            $logData = json_decode((string)$raw, true) ?: [];
        }

        $sitemapPath = ROOT_PATH . '/sitemap.xml';
        $llmsTxtPath = ROOT_PATH . '/llms.txt';
        $llmsMdPath = ROOT_PATH . '/llms.md';

        $staticCount = count(self::getStaticPages());
        $servicesCount = count(self::getActiveServices());
        $casesCount = count(self::getPublishedCaseStudies());
        $insightsCount = count(self::getPublishedInsights());
        $totalSitemapUrls = $staticCount + $servicesCount + $casesCount + $insightsCount;

        return [
            'last_sync_timestamp' => $logData['last_sync_timestamp'] ?? 'Never',
            'last_sync_iso' => $logData['last_sync_iso'] ?? null,
            'trigger_reason' => $logData['trigger_reason'] ?? 'Not initialized',
            'status' => $logData['status'] ?? 'pending',
            'duration_ms' => $logData['duration_ms'] ?? 0,
            'errors' => $logData['errors'] ?? [],
            'metrics' => [
                'static_pages' => $staticCount,
                'services' => $servicesCount,
                'case_studies' => $casesCount,
                'insights' => $insightsCount,
                'total_urls_in_sitemap' => $totalSitemapUrls
            ],
            'files' => [
                'sitemap_xml' => [
                    'exists' => file_exists($sitemapPath),
                    'size' => file_exists($sitemapPath) ? filesize($sitemapPath) : 0,
                    'mtime' => file_exists($sitemapPath) ? date('Y-m-d H:i:s', filemtime($sitemapPath)) : null
                ],
                'llms_txt' => [
                    'exists' => file_exists($llmsTxtPath),
                    'size' => file_exists($llmsTxtPath) ? filesize($llmsTxtPath) : 0,
                    'mtime' => file_exists($llmsTxtPath) ? date('Y-m-d H:i:s', filemtime($llmsTxtPath)) : null
                ],
                'llms_md' => [
                    'exists' => file_exists($llmsMdPath),
                    'size' => file_exists($llmsMdPath) ? filesize($llmsMdPath) : 0,
                    'mtime' => file_exists($llmsMdPath) ? date('Y-m-d H:i:s', filemtime($llmsMdPath)) : null
                ]
            ]
        ];
    }
}

