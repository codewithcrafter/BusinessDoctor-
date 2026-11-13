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
        return 'https://demo.businesdoctor.com';
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
                'title' => 'Technical Blog. Strategic Frameworks.',
                'description' => 'Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.'
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

        $lines[] = "## Published Blog Articles";
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
        $lines[] = "- [Public Markdown Index]({$baseUrl}/md): Complete catalog of pure Markdown mirrors for all published articles, case studies, and practice disciplines.";
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

        // Editorial Insights & Blog
        $lines[] = "## 4. Technical Blog & Editorial Perspectives";
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
        $lines[] = "- **Public Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "*This document is maintained dynamically by the BusinessDoctor Centralized SEO & LLM Synchronization Engine. All rights reserved.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Convert rich HTML body to clean, standard GitHub Flavored Markdown
     */
    public static function htmlToMarkdown(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }
        $md = str_replace(["\r\n", "\r"], "\n", $html);

        // Code blocks
        $md = preg_replace_callback('#<pre><code(?:\s+class="language-([a-zA-Z0-9_-]+)")?>(.*?)</code></pre>#is', function($m) {
            $lang = $m[1] ?? '';
            $code = html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            return "\n```{$lang}\n" . trim($code) . "\n```\n";
        }, $md);

        // Blockquotes
        $md = preg_replace_callback('#<blockquote.*?>(.*?)</blockquote>#is', function($m) {
            $text = trim(strip_tags($m[1]));
            $lines = explode("\n", $text);
            return "\n" . implode("\n", array_map(fn($l) => "> " . trim($l), $lines)) . "\n";
        }, $md);

        // Headings
        for ($i = 6; $i >= 1; $i--) {
            $prefix = str_repeat('#', $i);
            $md = preg_replace('#<h' . $i . '[^>]*>(.*?)</h' . $i . '>#is', "\n\n{$prefix} $1\n\n", $md);
        }

        // Links
        $md = preg_replace('#<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)</a>#is', '[$2]($1)', $md);

        // Strong / Bold
        $md = preg_replace('#<(strong|b)[^>]*>(.*?)</\1>#is', '**$2**', $md);

        // Emphasis / Italic
        $md = preg_replace('#<(em|i)[^>]*>(.*?)</\1>#is', '*$2*', $md);

        // Inline code
        $md = preg_replace('#<code[^>]*>(.*?)</code>#is', '`$1`', $md);

        // Lists
        $md = preg_replace('#<li[^>]*>(.*?)</li>#is', "- $1\n", $md);
        $md = preg_replace('#</?(ul|ol)[^>]*>#is', "\n", $md);

        // Paragraphs and breaks
        $md = preg_replace('#<p[^>]*>(.*?)</p>#is', "\n\n$1\n\n", $md);
        $md = preg_replace('#<br\s*/?>#is', "\n", $md);
        $md = preg_replace('#<hr\s*/?>#is', "\n\n---\n\n", $md);

        // Strip remaining tags
        $md = strip_tags($md);
        $md = html_entity_decode($md, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Clean extra whitespace and blank lines
        $md = preg_replace('/[ \t]+$/m', '', $md);
        $md = preg_replace('/\n{3,}/', "\n\n", $md);

        return trim($md);
    }

    /**
     * Generate individual Markdown document for a published blog/insight
     */
    public static function generateBlogMarkdown(array $blog): string
    {
        $baseUrl = self::getBaseUrl();
        $slug = $blog['slug'];
        $title = trim($blog['title'] ?? 'Perspectives & Engineering Insight');
        $category = trim($blog['category'] ?? 'Enterprise Strategy');
        $author = trim($blog['author_name'] ?: ($blog['author'] ?: 'BusinessDoctor Engineering'));
        $authorTitle = trim($blog['author_title'] ?? 'Senior Engineering Consultant');
        $readTime = trim($blog['reading_time'] ?? '5 min read');
        $pubDate = !empty($blog['published_at']) ? date('Y-m-d', strtotime($blog['published_at'])) : date('Y-m-d');
        $updatedDate = !empty($blog['updated_at']) ? date('Y-m-d', strtotime($blog['updated_at'])) : $pubDate;
        $canonicalUrl = $baseUrl . '/insight-detail.php?slug=' . urlencode($slug);
        $cleanMdUrl = $baseUrl . '/insights/' . urlencode($slug) . '.md';
        $mdUrl = $baseUrl . '/md/insights/' . urlencode($slug) . '.md';

        $summary = trim($blog['summary'] ?: ($blog['excerpt'] ?: ''));
        $content = self::htmlToMarkdown($blog['content'] ?? '');

        $lines = [];
        $lines[] = "# {$title}";
        $lines[] = "";
        if (!empty($summary)) {
            $lines[] = "> " . trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
            $lines[] = "";
        }
        $lines[] = "## Article Metadata";
        $lines[] = "- **Category**: {$category}";
        $lines[] = "- **Author**: {$author} ({$authorTitle})";
        $lines[] = "- **Published Date**: {$pubDate}";
        $lines[] = "- **Last Modified**: {$updatedDate}";
        $lines[] = "- **Reading Time**: {$readTime}";
        $lines[] = "- **Canonical Web URL**: [{$canonicalUrl}]({$canonicalUrl})";
        $lines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
        $lines[] = "- **Central Markdown URL**: [{$mdUrl}]({$mdUrl})";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";
        $lines[] = $content;
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "*Published by [BusinessDoctor]({$baseUrl}) — Engineering Technology. Accelerating Digital Growth.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Generate individual Markdown document for a published case study
     */
    public static function generateCaseStudyMarkdown(array $case): string
    {
        $baseUrl = self::getBaseUrl();
        $slug = $case['slug'];
        $title = trim($case['title'] ?? 'Enterprise Client Turnaround');
        $client = trim($case['client_name'] ?? 'Confidential Enterprise Client');
        $industry = trim($case['industry'] ?: ($case['client_industry'] ?: 'Enterprise'));
        $practice = trim($case['service_category'] ?: ($case['practice_area'] ?: 'Digital Practice'));
        $canonicalUrl = $baseUrl . '/case-study-detail.php?slug=' . urlencode($slug);
        $cleanMdUrl = $baseUrl . '/case-studies/' . urlencode($slug) . '.md';
        $mdUrl = $baseUrl . '/md/case-studies/' . urlencode($slug) . '.md';
        $summary = trim($case['project_summary'] ?? '');
        $baseline = trim($case['baseline_metric'] ?? '');
        $outcome = trim($case['outcome_metric'] ?? '');
        $metricLabel = trim($case['metric_label'] ?? '');

        $lines = [];
        $lines[] = "# {$title}";
        $lines[] = "";
        if (!empty($summary)) {
            $lines[] = "> " . trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
            $lines[] = "";
        }
        $lines[] = "## Case Study Overview";
        $lines[] = "- **Client**: {$client}";
        $lines[] = "- **Industry**: {$industry}";
        $lines[] = "- **Practice Area**: {$practice}";
        if ($baseline || $outcome) {
            $lines[] = "- **Quantifiable Metric Shift**: `{$baseline}` → `{$outcome}`" . ($metricLabel ? " ({$metricLabel})" : "");
        }
        $lines[] = "- **Canonical Web URL**: [{$canonicalUrl}]({$canonicalUrl})";
        $lines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
        $lines[] = "- **Central Markdown URL**: [{$mdUrl}]({$mdUrl})";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";

        if (!empty($case['challenge'])) {
            $lines[] = "## 1. Challenge & Operational Bottlenecks";
            $lines[] = self::htmlToMarkdown($case['challenge']);
            $lines[] = "";
        }

        if (!empty($case['solution']) || !empty($case['prescription'])) {
            $lines[] = "## 2. Prescribed Technical Solution";
            $lines[] = self::htmlToMarkdown($case['solution'] ?: $case['prescription']);
            $lines[] = "";
        }

        if (!empty($case['implementation'])) {
            $lines[] = "## 3. Implementation Architecture";
            $lines[] = self::htmlToMarkdown($case['implementation']);
            $lines[] = "";
        }

        if (!empty($case['results']) || !empty($case['result_description'])) {
            $lines[] = "## 4. Quantifiable Business Outcomes";
            $lines[] = self::htmlToMarkdown($case['results'] ?: $case['result_description']);
            $lines[] = "";
        }

        $lines[] = "---";
        $lines[] = "*Documented by [BusinessDoctor]({$baseUrl}) Client Turnaround Practice.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Generate individual Markdown document for a service practice area
     */
    public static function generateServiceMarkdown(string $slug, array $service): string
    {
        $baseUrl = self::getBaseUrl();
        $name = trim($service['name'] ?? 'Practice Area');
        $tagline = trim($service['tagline'] ?? '');
        $summary = trim($service['summary'] ?? '');
        $description = trim($service['description'] ?? '');
        $canonicalUrl = $baseUrl . '/services/' . urlencode($slug);
        $cleanMdUrl = $baseUrl . '/services/' . urlencode($slug) . '.md';
        $mdUrl = $baseUrl . '/md/services/' . urlencode($slug) . '.md';

        $lines = [];
        $lines[] = "# {$name}";
        $lines[] = "";
        if (!empty($tagline)) {
            $lines[] = "> {$tagline}";
            $lines[] = "";
        }
        $lines[] = "## Discipline Information";
        $lines[] = "- **Canonical Web URL**: [{$canonicalUrl}]({$canonicalUrl})";
        $lines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
        $lines[] = "- **Central Markdown URL**: [{$mdUrl}]({$mdUrl})";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";
        $lines[] = "## Practice Overview";
        $lines[] = !empty($description) ? self::htmlToMarkdown($description) : $summary;
        $lines[] = "";

        if (!empty($service['deliverables']) && is_array($service['deliverables'])) {
            $lines[] = "## Key Deliverables";
            foreach ($service['deliverables'] as $del) {
                $lines[] = "- " . trim($del);
            }
            $lines[] = "";
        }

        if (!empty($service['kpis']) && is_array($service['kpis'])) {
            $lines[] = "## Target Performance KPIs";
            foreach ($service['kpis'] as $kpi) {
                $lines[] = "- " . trim($kpi);
            }
            $lines[] = "";
        }

        $lines[] = "---";
        $lines[] = "*Delivered by [BusinessDoctor]({$baseUrl}) Technology Practice.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Generate institutional and resource Markdown documents
     */
    public static function generateStaticPageMarkdown(string $pageKey): string
    {
        $baseUrl = self::getBaseUrl();
        $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
        $legalName = defined('APP_LEGAL_NAME') ? APP_LEGAL_NAME : 'BusinessDoctor IT Solutions & Digital Services Private Limited';
        $phone = defined('APP_PHONE') ? APP_PHONE : '+1 (800) 492-3628';
        $email = defined('APP_EMAIL') ? APP_EMAIL : 'solutions@businessdoctor.com';
        $hq = defined('APP_HEADQUARTERS') ? APP_HEADQUARTERS : 'Executive Tech Park, Innovation District';

        switch ($pageKey) {
            case 'about':
                return <<<MD
# About {$appName} — Firm Profile & Leadership
> {$legalName} combines software engineering, performance marketing, and conversion architecture.

- **Primary URL**: [{$baseUrl}/about.php]({$baseUrl}/about.php)
- **Markdown Resource**: [{$baseUrl}/md/about.md]({$baseUrl}/md/about.md)
- **Headquarters**: {$hq}

---

## 1. Executive Summary & Mission
BusinessDoctor operates as a technical turn-around and digital scaling practice. We eliminate digital bottlenecks, replace slow legacy code with lean modern architectures, optimize multi-channel conversion funnels, and scale high-volume transactional platforms.

## 2. Engineering Principles
- **Sub-Second Performance**: Elimination of monolithic bloat, optimizing database indices, native caching, and clean execution paths.
- **Conversion-Centered Architecture**: Engineering every UX pathway around measurable transaction completion and lead capture.
- **Data Integrity & Security**: Dual-layer database persistence, strict CSRF/XSS sanitization, and automated schema synchronization.

---
*Maintained by {$appName} Corporate Communications.*
MD;

            case 'contact':
                return <<<MD
# Contact {$appName} & Executive Advisory
> Direct communication channels for enterprise scoping, technical audits, and partnership inquiries.

- **Primary URL**: [{$baseUrl}/contact.php]({$baseUrl}/contact.php)
- **Markdown Resource**: [{$baseUrl}/md/contact.md]({$baseUrl}/md/contact.md)
- **Direct Phone**: {$phone}
- **Advisory Email**: [{$email}](mailto:{$email})
- **Headquarters**: {$hq}

---

## Engagement Process
1. **Initial Diagnostic Briefing**: Benchmarking project parameters, timeline, and architectural requirements.
2. **Technical Feasibility & Scope**: Detailed blueprint covering software engineering, marketing ROI, and infrastructure.
3. **Execution & Delivery**: Agile sprints with daily builds, staging verification, and automated regression testing.

---
*Maintained by {$appName} Executive Advisory.*
MD;

            case 'audit':
                return <<<MD
# Free Digital Architecture Audit & Project Scope
> Diagnostic framework benchmarking infrastructure, ad performance, conversion funnels, and brand positioning.

- **Primary URL**: [{$baseUrl}/audit.php]({$baseUrl}/audit.php)
- **Markdown Resource**: [{$baseUrl}/md/audit.md]({$baseUrl}/md/audit.md)

---

## Audit Evaluation Vectors
1. **Engineering & Architecture**: Server response latency, Core Web Vitals, database queries, and mobile accessibility.
2. **Traffic & Acquisition**: Ad spend leakage, paid search ROAS, CAC escalation, and technical SEO crawlability.
3. **Systems & Security Posture**: SSL/TLS hygiene, backup resilience, error logging, and API authentication.
4. **Brand Positioning & Trust**: Brand architecture, UI design consistency, and marketplace Buy Box protection.

---
*Maintained by {$appName} Diagnostic Practice.*
MD;

            case 'services':
                $services = self::getActiveServices();
                $sLines = [];
                $sLines[] = "# {$appName} — IT Services & Practice Areas";
                $sLines[] = "> Overview of our multidisciplinary digital disciplines, technical deliverables, and performance KPIs.";
                $sLines[] = "";
                $sLines[] = "- **Canonical URL**: [{$baseUrl}/services.php]({$baseUrl}/services.php)";
                $sLines[] = "- **Markdown Resource**: [{$baseUrl}/md/services.md]({$baseUrl}/md/services.md)";
                $sLines[] = "- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
                $sLines[] = "";
                $sLines[] = "---";
                $sLines[] = "";
                $sLines[] = "## Core Practice Disciplines";
                $sLines[] = "";
                foreach ($services as $slug => $s) {
                    $name = $s['name'] ?? '';
                    $tagline = $s['tagline'] ?? '';
                    $summary = $s['summary'] ?? '';
                    $mdUrl = "{$baseUrl}/md/services/{$slug}.md";
                    $cleanMdUrl = "{$baseUrl}/services/{$slug}.md";
                    $webUrl = "{$baseUrl}/services/{$slug}";
                    $sLines[] = "### " . ($s['number'] ?? '') . " {$name}";
                    $sLines[] = "- **Tagline**: {$tagline}";
                    $sLines[] = "- **Markdown File**: [{$slug}.md]({$cleanMdUrl}) ([Mirror]({$mdUrl})) | [Web Page]({$webUrl})";
                    $sLines[] = "- **Summary**: {$summary}";
                    $sLines[] = "";
                }
                $sLines[] = "---";
                $sLines[] = "*Maintained by {$appName} Practice Operations.*";
                return implode("\n", $sLines);

            case 'insights':
                $insights = self::getPublishedInsights();
                $iLines = [];
                $iLines[] = "# {$appName} — Technical Blog & Strategic Frameworks";
                $iLines[] = "> Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.";
                $iLines[] = "";
                $iLines[] = "- **Canonical URL**: [{$baseUrl}/insights.php]({$baseUrl}/insights.php)";
                $iLines[] = "- **Markdown Resource**: [{$baseUrl}/md/insights.md]({$baseUrl}/md/insights.md)";
                $iLines[] = "- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
                $iLines[] = "";
                $iLines[] = "---";
                $iLines[] = "";
                $iLines[] = "## Published Blog Articles";
                $iLines[] = "";
                if (empty($insights)) {
                    $iLines[] = "No editorial articles currently published.";
                } else {
                    foreach ($insights as $art) {
                        $title = trim($art['title']);
                        $slug = $art['slug'];
                        $author = $art['author_name'] ?: ($art['author'] ?: 'BusinessDoctor Engineering');
                        $readTime = $art['reading_time'] ?? '5 min read';
                        $pubDate = !empty($art['published_at']) ? date('M j, Y', strtotime($art['published_at'])) : '';
                        $summary = trim(preg_replace('/\s+/', ' ', strip_tags($art['summary'] ?: ($art['excerpt'] ?: ''))));
                        $mdUrl = "{$baseUrl}/md/insights/{$slug}.md";
                        $cleanMdUrl = "{$baseUrl}/insights/{$slug}.md";
                        $webUrl = "{$baseUrl}/insight-detail.php?slug={$slug}";

                        $iLines[] = "### {$title}";
                        $iLines[] = "- **Author**: {$author} | **Date**: {$pubDate} | **Read Time**: {$readTime}";
                        $iLines[] = "- **Markdown File**: [{$slug}.md]({$cleanMdUrl}) ([Mirror]({$mdUrl})) | [Web Page]({$webUrl})";
                        $iLines[] = "- **Summary**: {$summary}";
                        $iLines[] = "";
                    }
                }
                $iLines[] = "---";
                $iLines[] = "*Maintained by {$appName} Editorial Staff.*";
                return implode("\n", $iLines);

            case 'case-studies':
                $cases = self::getPublishedCaseStudies();
                $cLines = [];
                $cLines[] = "# {$appName} — Client Case Studies & Proven Results";
                $cLines[] = "> Measurable outcomes, revenue acceleration, and architectural turnarounds for enterprise clients.";
                $cLines[] = "";
                $cLines[] = "- **Canonical URL**: [{$baseUrl}/case-studies.php]({$baseUrl}/case-studies.php)";
                $cLines[] = "- **Markdown Resource**: [{$baseUrl}/md/case-studies.md]({$baseUrl}/md/case-studies.md)";
                $cLines[] = "- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
                $cLines[] = "";
                $cLines[] = "---";
                $cLines[] = "";
                $cLines[] = "## Enterprise Client Turnarounds";
                $cLines[] = "";
                if (empty($cases)) {
                    $cLines[] = "No client case studies currently published.";
                } else {
                    foreach ($cases as $c) {
                        $title = trim($c['title']);
                        $slug = $c['slug'];
                        $industry = $c['industry'] ?: ($c['client_industry'] ?: 'Enterprise');
                        $baseline = $c['baseline_metric'] ?? '';
                        $outcome = $c['outcome_metric'] ?? '';
                        $metricShift = ($baseline && $outcome) ? "{$baseline} → {$outcome}" : ($outcome ?: '');
                        $mdUrl = "{$baseUrl}/md/case-studies/{$slug}.md";
                        $cleanMdUrl = "{$baseUrl}/case-studies/{$slug}.md";
                        $webUrl = "{$baseUrl}/case-study-detail.php?slug={$slug}";

                        $cLines[] = "### {$title}";
                        $cLines[] = "- **Industry**: {$industry}" . ($metricShift ? " | **Metric Shift**: `{$metricShift}`" : "");
                        $cLines[] = "- **Markdown File**: [{$slug}.md]({$cleanMdUrl}) ([Mirror]({$mdUrl})) | [Web Page]({$webUrl})";
                        if (!empty($c['project_summary'])) {
                            $cLines[] = "- **Summary**: " . trim(preg_replace('/\s+/', ' ', strip_tags($c['project_summary'])));
                        }
                        $cLines[] = "";
                    }
                }
                $cLines[] = "---";
                $cLines[] = "*Maintained by {$appName} Client Turnaround Practice.*";
                return implode("\n", $cLines);

            case 'home':
            default:
                return <<<MD
# {$appName} — Enterprise Technology & IT Solutions
> Engineering Technology. Accelerating Digital Growth.

- **Canonical URL**: [{$baseUrl}/]({$baseUrl}/)
- **Markdown Resource**: [{$baseUrl}/md/home.md]({$baseUrl}/md/home.md)
- **AI Discovery**: [{$baseUrl}/llms.txt]({$baseUrl}/llms.txt) | [{$baseUrl}/llms.md]({$baseUrl}/llms.md)
- **Public Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)

---

## Practice Disciplines
- **Web & Custom Software Development**: Full-stack engineering, custom applications, and sub-second web architecture.
- **Digital Marketing & Performance Ads**: Search marketing, paid acquisition, and conversion rate optimization.
- **UI/UX Design & Brand Identity**: Premium interface design, interactive prototypes, and design systems.
- **E-Commerce & Marketplaces**: Amazon/Flipkart management, Buy Box protection, and D2C scaling.
- **Creative Production & Video Marketing**: Commercial photography, brand narrative video, and motion graphics.
- **Cloud Solutions & IT Consulting**: Infrastructure setup, security monitoring, and automated devops.

---
*Maintained by {$appName}.*
MD;
        }
    }

    /**
     * Generate master Markdown catalog index (/md and md/index.md)
     */
    public static function generateMdMasterIndex(): string
    {
        $baseUrl = self::getBaseUrl();
        $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
        $tagline = defined('APP_TAGLINE') ? APP_TAGLINE : 'Engineering Technology. Accelerating Digital Growth.';

        $services = self::getActiveServices();
        $cases = self::getPublishedCaseStudies();
        $insights = self::getPublishedInsights();

        $lines = [];
        $lines[] = "# {$appName} — Public Markdown Document Index";
        $lines[] = "> {$tagline}";
        $lines[] = "";
        $lines[] = "High-performance machine-readable Markdown repository for generative AI models, LLM crawlers, search engines, and automated knowledge pipelines.";
        $lines[] = "";
        $lines[] = "- **Canonical Website**: [{$baseUrl}]({$baseUrl})";
        $lines[] = "- **AI Discovery Manifest**: [{$baseUrl}/llms.txt]({$baseUrl}/llms.txt)";
        $lines[] = "- **Comprehensive LLM Context**: [{$baseUrl}/llms.md]({$baseUrl}/llms.md)";
        $lines[] = "- **XML Sitemap**: [{$baseUrl}/sitemap.xml]({$baseUrl}/sitemap.xml)";
        $lines[] = "- **Last Synchronized**: " . date('Y-m-d H:i:s T');
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";

        // 1. Services
        $lines[] = "## 1. Core Practice Disciplines & Services";
        $lines[] = "";
        foreach ($services as $slug => $s) {
            $name = $s['name'];
            $tag = rtrim(strip_tags($s['tagline'] ?? $s['summary']), '.');
            $url = "{$baseUrl}/md/services/{$slug}.md";
            $webUrl = "{$baseUrl}/services/{$slug}";
            $lines[] = "- [{$name}]({$url}) ([Web Page]({$webUrl})): {$tag}.";
        }
        $lines[] = "";

        // 2. Case Studies
        $lines[] = "## 2. Client Case Studies & Proven Results";
        $lines[] = "";
        if (empty($cases)) {
            $lines[] = "- No client case studies are currently published.";
        } else {
            foreach ($cases as $c) {
                $title = trim($c['title']);
                $slug = $c['slug'];
                $url = "{$baseUrl}/md/case-studies/{$slug}.md";
                $webUrl = "{$baseUrl}/case-study-detail.php?slug={$slug}";
                $industry = $c['industry'] ?: ($c['client_industry'] ?: 'Enterprise');
                $baseline = $c['baseline_metric'] ?? '';
                $outcome = $c['outcome_metric'] ?? '';
                $metricText = ($baseline && $outcome) ? " ({$baseline} → {$outcome})" : ($outcome ? " ({$outcome})" : "");
                $lines[] = "- [{$title}]({$url}) ([Web Page]({$webUrl})): [{$industry}]{$metricText}";
            }
        }
        $lines[] = "";

        // 3. Blog Articles
        $lines[] = "## 3. Technical Blog & Articles";
        $lines[] = "";
        if (empty($insights)) {
            $lines[] = "- No editorial articles are currently published.";
        } else {
            foreach ($insights as $art) {
                $title = trim($art['title']);
                $slug = $art['slug'];
                $url = "{$baseUrl}/md/insights/{$slug}.md";
                $webUrl = "{$baseUrl}/insight-detail.php?slug={$slug}";
                $readTime = $art['reading_time'] ?? '5 min read';
                $summary = !empty($art['summary']) ? $art['summary'] : (!empty($art['excerpt']) ? $art['excerpt'] : '');
                $summary = trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
                if (mb_strlen($summary) > 130) {
                    $summary = mb_substr($summary, 0, 127) . '...';
                }
                $lines[] = "- [{$title}]({$url}) ([Web Page]({$webUrl})): {$summary} ({$readTime})";
            }
        }
        $lines[] = "";

        // 4. Institutional
        $lines[] = "## 4. Institutional & Diagnostic Documents";
        $lines[] = "";
        $lines[] = "- [Firm Profile & Leadership]({$baseUrl}/md/about.md) ([Web Page]({$baseUrl}/about.php)): Engineering ethos and leadership profile.";
        $lines[] = "- [Executive Advisory & Inquiries]({$baseUrl}/md/contact.md) ([Web Page]({$baseUrl}/contact.php)): Direct engagement and consulting channels.";
        $lines[] = "- [Digital Diagnostic Audit Framework]({$baseUrl}/md/audit.md) ([Web Page]({$baseUrl}/audit.php)): Benchmarking performance, security, and CAC.";
        $lines[] = "- [Homepage Overview]({$baseUrl}/md/home.md) ([Web Page]({$baseUrl}/)): Enterprise digital practice overview.";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "*BusinessDoctor Centralized Markdown Distribution Network.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

    /**
     * Synchronize and atomicaly write all published Markdown files into /md
     * Automatically purges unlisted/unpublished/draft files.
     */
    public static function syncMarkdownFiles(): array
    {
        $mdBaseDir = ROOT_PATH . '/md';
        $insightsDir = $mdBaseDir . '/insights';
        $casesDir = $mdBaseDir . '/case-studies';
        $servicesDir = $mdBaseDir . '/services';

        foreach ([$mdBaseDir, $insightsDir, $casesDir, $servicesDir] as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
        }

        $written = [];
        $purged = [];

        // 1. Master Index
        $masterIndexContent = self::generateMdMasterIndex();
        $masterIndexPath = $mdBaseDir . '/index.md';
        if (self::writeFileAtomic($masterIndexPath, $masterIndexContent)) {
            $written[] = 'md/index.md';
        }

        // 2. Static Pages & Section Catalogs
        $staticDocs = ['about', 'contact', 'audit', 'home', 'services', 'insights', 'case-studies'];
        foreach ($staticDocs as $doc) {
            $path = $mdBaseDir . "/{$doc}.md";
            $content = self::generateStaticPageMarkdown($doc);
            if (self::writeFileAtomic($path, $content)) {
                $written[] = "md/{$doc}.md";
            }
        }

        // 3. Services
        $services = self::getActiveServices();
        $validServiceSlugs = [];
        foreach ($services as $slug => $s) {
            $validServiceSlugs[] = $slug;
            $path = $servicesDir . "/{$slug}.md";
            $content = self::generateServiceMarkdown($slug, $s);
            if (self::writeFileAtomic($path, $content)) {
                $written[] = "md/services/{$slug}.md";
            }
        }
        // Purge inactive/deleted services
        foreach (glob($servicesDir . '/*.md') ?: [] as $file) {
            $fileSlug = basename($file, '.md');
            if (!in_array($fileSlug, $validServiceSlugs, true)) {
                @unlink($file);
                $purged[] = "md/services/{$fileSlug}.md";
            }
        }

        // 4. Published Case Studies
        $cases = self::getPublishedCaseStudies();
        $validCaseSlugs = [];
        foreach ($cases as $c) {
            $slug = $c['slug'];
            $validCaseSlugs[] = $slug;
            $path = $casesDir . "/{$slug}.md";
            $content = self::generateCaseStudyMarkdown($c);
            if (self::writeFileAtomic($path, $content)) {
                $written[] = "md/case-studies/{$slug}.md";
            }
        }
        // Purge unpublished, draft, or deleted case studies
        foreach (glob($casesDir . '/*.md') ?: [] as $file) {
            $fileSlug = basename($file, '.md');
            if (!in_array($fileSlug, $validCaseSlugs, true)) {
                @unlink($file);
                $purged[] = "md/case-studies/{$fileSlug}.md";
            }
        }

        // 5. Published Insights / Blogs
        $insights = self::getPublishedInsights();
        $validInsightSlugs = [];
        foreach ($insights as $art) {
            $slug = $art['slug'];
            $validInsightSlugs[] = $slug;
            $path = $insightsDir . "/{$slug}.md";
            $content = self::generateBlogMarkdown($art);
            if (self::writeFileAtomic($path, $content)) {
                $written[] = "md/insights/{$slug}.md";
            }
        }
        // Purge unpublished, draft, or deleted insights
        foreach (glob($insightsDir . '/*.md') ?: [] as $file) {
            $fileSlug = basename($file, '.md');
            if (!in_array($fileSlug, $validInsightSlugs, true)) {
                @unlink($file);
                $purged[] = "md/insights/{$fileSlug}.md";
            }
        }

        return [
            'written' => $written,
            'purged' => $purged
        ];
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

        // 4. Generate & Synchronize Markdown Files (/md and /md/*.md)
        $mdSyncResult = ['written' => [], 'purged' => []];
        try {
            $mdSyncResult = self::syncMarkdownFiles();
            $masterIndexPath = ROOT_PATH . '/md/index.md';
            $filesWritten['md_index'] = [
                'path' => 'md/index.md',
                'size_bytes' => file_exists($masterIndexPath) ? filesize($masterIndexPath) : 0,
                'status' => 'written'
            ];
            $filesWritten['md_files'] = [
                'count_written' => count($mdSyncResult['written']),
                'count_purged' => count($mdSyncResult['purged']),
                'status' => 'synchronized'
            ];
        } catch (Throwable $e) {
            $errors[] = 'Markdown files generation error: ' . $e->getMessage();
        }

        $durationMs = round((microtime(true) - $startTime) * 1000, 2);
        $status = empty($errors) ? 'success' : (count($filesWritten) > 0 ? 'partial' : 'error');

        // Metrics calculation
        $staticCount = count(self::getStaticPages());
        $servicesCount = count(self::getActiveServices());
        $casesCount = count(self::getPublishedCaseStudies());
        $insightsCount = count(self::getPublishedInsights());
        $totalSitemapUrls = $staticCount + $servicesCount + $casesCount + $insightsCount;
        $totalMdFiles = count($mdSyncResult['written']);

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
                'total_urls_in_sitemap' => $totalSitemapUrls,
                'total_md_files' => $totalMdFiles
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
        $mdIndexPath = ROOT_PATH . '/md/index.md';

        $staticCount = count(self::getStaticPages());
        $servicesCount = count(self::getActiveServices());
        $casesCount = count(self::getPublishedCaseStudies());
        $insightsCount = count(self::getPublishedInsights());
        $totalSitemapUrls = $staticCount + $servicesCount + $casesCount + $insightsCount;
        $totalMdFiles = $logData['metrics']['total_md_files'] ?? ($staticCount + $servicesCount + $casesCount + $insightsCount + 1);

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
                'total_urls_in_sitemap' => $totalSitemapUrls,
                'total_md_files' => $totalMdFiles
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
                ],
                'md_index' => [
                    'exists' => file_exists($mdIndexPath),
                    'size' => file_exists($mdIndexPath) ? filesize($mdIndexPath) : 0,
                    'mtime' => file_exists($mdIndexPath) ? date('Y-m-d H:i:s', filemtime($mdIndexPath)) : null
                ]
            ]
        ];
    }
}

