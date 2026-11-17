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
        // Enforce canonical production domain
        if (defined('CANONICAL_DOMAIN') && !empty(CANONICAL_DOMAIN)) {
            $base = rtrim(CANONICAL_DOMAIN, '/');
        } elseif (defined('CANONICAL_BASE_URL') && !empty(CANONICAL_BASE_URL)) {
            $base = rtrim(CANONICAL_BASE_URL, '/');
        } elseif (defined('APP_URL') && !empty(APP_URL)) {
            $base = rtrim(APP_URL, '/');
        } elseif (defined('BASE_URL') && !empty(BASE_URL)) {
            $base = rtrim(BASE_URL, '/');
        } else {
            $base = 'https://demo.businesdoctor.com';
        }
        // Strict safety normalization: Never allow demo.businessdoctor.com with extra 's'
        return str_replace('demo.businessdoctor.com', 'demo.businesdoctor.com', $base);
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
                'description' => 'BusinesDoctor delivers enterprise IT solutions, web & custom software development, digital marketing, UI/UX architecture, e-commerce, and cloud consulting.'
            ],
            [
                'loc' => '/services',
                'file' => 'services.php',
                'priority' => '0.9',
                'changefreq' => 'weekly',
                'title' => 'Digital Marketing & IT Services Delhi NCR — BusinesDoctor',
                'description' => 'Targeted growth solutions for businesses in Delhi NCR: SMO, Google Business Profile Management, PPC / Paid Ads, Ecommerce Management, Graphic Design, SEO, Social Media Marketing, Product Photography, Video Editing, and Web Development.'
            ],
            [
                'loc' => '/audit',
                'file' => 'audit.php',
                'priority' => '0.9',
                'changefreq' => 'weekly',
                'title' => 'Free Digital Architecture Audit & Project Scope',
                'description' => 'Diagnostic assessment tool to benchmark technical infrastructure, security posture, conversion leaks, and growth bottlenecks.'
            ],
            [
                'loc' => '/case-studies',
                'file' => 'case-studies.php',
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'title' => 'Client Case Studies & Proven Results',
                'description' => 'Real-world enterprise case studies showcasing measurable outcomes, revenue growth, and architectural turnarounds.'
            ],
            [
                'loc' => '/blog',
                'file' => 'insights.php',
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'title' => 'Blog & Technical Perspectives — BusinesDoctor Enterprise IT',
                'description' => 'Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.'
            ],
            [
                'loc' => '/about',
                'file' => 'about.php',
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'title' => 'About BusinessDoctor — Firm Profile & Practice',
                'description' => 'Our history, engineering ethos, global delivery standards, and digital marketing practice methodology.'
            ],
            [
                'loc' => '/contact',
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
    public static function getActiveServices(bool $refresh = false): array
    {
        return getPracticeAreas($refresh);
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

        // 2. Services (Canonical URLs: /company/{slug})
        foreach (self::getActiveServices() as $slug => $service) {
            $loc = getServiceUrl($slug);
            // Guarantee canonical domain
            if (!str_starts_with($loc, $baseUrl)) {
                $loc = $baseUrl . parse_url($loc, PHP_URL_PATH);
            }
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($loc) . '</loc>';
            $xml[] = '    <lastmod>' . $today . '</lastmod>';
            $xml[] = '    <changefreq>weekly</changefreq>';
            $xml[] = '    <priority>0.8</priority>';
            $xml[] = '  </url>';
        }

        // 3. Case Studies (Canonical URLs: /case-studies/{slug})
        foreach (self::getPublishedCaseStudies() as $case) {
            $caseSlug = $case['slug'];
            $loc = getCaseStudyUrl($caseSlug);
            if (!str_starts_with($loc, $baseUrl)) {
                $loc = $baseUrl . parse_url($loc, PHP_URL_PATH);
            }
            $lastmod = !empty($case['updated_at']) ? date('Y-m-d', strtotime((string)$case['updated_at'])) : (!empty($case['created_at']) ? date('Y-m-d', strtotime((string)$case['created_at'])) : $today);
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($loc) . '</loc>';
            $xml[] = '    <lastmod>' . $lastmod . '</lastmod>';
            $xml[] = '    <changefreq>monthly</changefreq>';
            $xml[] = '    <priority>0.7</priority>';
            $xml[] = '  </url>';
        }

        // 4. Insights / Blogs (Canonical URLs: /blog/{slug})
        foreach (self::getPublishedInsights() as $insight) {
            $insightSlug = $insight['slug'];
            $loc = getBlogUrl($insightSlug);
            if (!str_starts_with($loc, $baseUrl)) {
                $loc = $baseUrl . parse_url($loc, PHP_URL_PATH);
            }
            $lastmod = !empty($insight['updated_at']) ? date('Y-m-d', strtotime((string)$insight['updated_at'])) : (!empty($insight['published_at']) ? date('Y-m-d', strtotime((string)$insight['published_at'])) : $today);
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . htmlspecialchars($loc) . '</loc>';
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
        $appName = 'BusinesDoctor';
        $tagline = defined('APP_TAGLINE') ? APP_TAGLINE : 'Engineering Technology. Accelerating Digital Growth.';

        $insights = self::getPublishedInsights();
        $cases = self::getPublishedCaseStudies();

        $lines = [];
        $lines[] = "# {$appName}";
        $lines[] = "> {$tagline}";
        $lines[] = "";
        $lines[] = "BusinesDoctor is an enterprise digital services practice delivering full-stack software development, performance digital marketing, UI/UX architecture, e-commerce marketplace scaling, creative video production, and cloud IT infrastructure.";
        $lines[] = "";
        $lines[] = "Website: {$baseUrl}/";
        $lines[] = "";
        $lines[] = "This index links to Markdown resources intended for AI/LLM consumption. All listed URLs must be verified canonical pages reflecting published website content.";
        $lines[] = "";
        $lines[] = "## Core Practice Disciplines";
        foreach (self::getActiveServices() as $slug => $service) {
            $name = $service['name'] ?? $service['short_title'] ?? $slug;
            $summary = !empty($service['summary']) ? $service['summary'] : (!empty($service['tagline']) ? $service['tagline'] : 'Enterprise digital service.');
            $summary = trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
            $url = getServiceUrl($slug);
            if (!str_starts_with($url, $baseUrl)) {
                $url = $baseUrl . parse_url($url, PHP_URL_PATH);
            }
            $lines[] = "- [{$name}]({$url}): {$summary}";
        }
        $lines[] = "";
        $lines[] = "## Company";
        $lines[] = "- [BusinesDoctor Homepage]({$baseUrl}/): Primary enterprise portal outlining technology capabilities, client transformations, and strategic consulting frameworks.";
        $lines[] = "- [About BusinesDoctor]({$baseUrl}/about): Digital marketing practice methodology, engineering principles, and core consulting values.";
        $lines[] = "- [Contact Us]({$baseUrl}/contact): Direct communication channels, enterprise project scoping, consultation requests, and verified headquarters address.";
        $lines[] = "- [Digital Architecture Audit]({$baseUrl}/audit): Complimentary diagnostic benchmarking technical bottlenecks, Core Web Vitals, conversion leaks, and infrastructure readiness.";
        $lines[] = "";
        $lines[] = "## Published Editorial & Insights";
        if (empty($insights)) {
            $lines[] = "- No published articles available at this time.";
        } else {
            foreach ($insights as $art) {
                $title = trim($art['title']);
                $slug = $art['slug'];
                $summary = !empty($art['summary']) ? $art['summary'] : (!empty($art['excerpt']) ? $art['excerpt'] : 'Technical insight and editorial analysis.');
                $summary = trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
                if (mb_strlen($summary) > 160) {
                    $summary = mb_substr($summary, 0, 157) . '...';
                }
                $lines[] = "- [{$title}]({$baseUrl}/blog/{$slug}): {$summary}";
            }
        }
        $lines[] = "";
        $lines[] = "## Client Case Studies & Proven Results";
        if (empty($cases)) {
            $lines[] = "- No published case studies available at this time.";
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
                $lines[] = "- [{$title}]({$baseUrl}/case-studies/{$slug}): [{$industry}]{$metricText} {$desc}";
            }
        }
        $lines[] = "";
        $lines[] = "## Public Tools & Resources";
        $lines[] = "- [XML Sitemap]({$baseUrl}/sitemap.xml): Complete search engine index containing verified canonical URLs for all public pages, services, articles, and case studies.";
        $lines[] = "- [Public Markdown Index]({$baseUrl}/md): Directory of clean Markdown mirrors structured for AI agents, developers, and LLM context extraction.";

        return implode("\n", $lines) . "\n";
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
            $url = getServiceUrl($slug);

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
                $url = "{$baseUrl}/case-studies/{$slug}";
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
                $url = "{$baseUrl}/blog/{$slug}";
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
        $lines[] = "BusinessDoctor operates an interactive diagnostic assessment portal at [{$baseUrl}/audit]({$baseUrl}/audit). The tool evaluates enterprise digital operations across four foundational vectors:";
        $lines[] = "1. **Architecture & Engineering**: Monolithic framework latency, Core Web Vitals (LCP, INP, CLS), database querying bottlenecks, and mobile responsiveness.";
        $lines[] = "2. **Customer Acquisition & Traffic**: PPC ad spend waste, conversion funnel friction, organic search visibility, and CAC inflation.";
        $lines[] = "3. **Systems & Security Posture**: Infrastructure uptime resilience, automated backup hygiene, SSL/TLS configurations, and API security.";
        $lines[] = "4. **Brand Positioning & Trust**: Brand architecture, UI design consistency, and marketplace Buy Box protection.";
        $lines[] = "";

        // Contact & Engagement
        $lines[] = "## 6. Enterprise Inquiries & Contact Channels";
        $lines[] = "";
        $lines[] = "- **Web Engagement Portal**: [{$baseUrl}/contact]({$baseUrl}/contact)";
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

        // Safeguard: protect `<` immediately followed by a digit from being consumed by strip_tags()
        $md = preg_replace('/<(?=[0-9])/', '&lt;', $md);

        // Normalize legacy URL paths to clean canonical routes
        $md = str_replace(
            ['contact.php', 'about.php', 'audit.php', 'case-studies.php', 'case-study-detail.php?slug='],
            ['contact', 'about', 'audit', 'case-studies', 'case-studies/'],
            $md
        );
        $md = preg_replace('#/(?:company|services)/([a-zA-Z0-9_-]+)(?!\.md)#', '/service/$1', $md);
        $md = preg_replace('#/([a-zA-Z0-9_-]+)-company-in-delhi#', '/service/$1', $md);

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

        // Clean Headings (h1 to h6)
        for ($i = 6; $i >= 1; $i--) {
            $prefix = str_repeat('#', $i);
            $md = preg_replace_callback('#<h' . $i . '[^>]*>(.*?)</h' . $i . '>#is', function($m) use ($prefix) {
                $hText = preg_replace('#<br\s*/?>#i', ' ', $m[1]);
                $hText = trim(preg_replace('/\s+/', ' ', strip_tags($hText)));
                if ($hText === '') return '';
                return "\n\n{$prefix} {$hText}\n\n";
            }, $md);
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
        $md = preg_replace_callback('#<li[^>]*>(.*?)</li>#is', function($m) {
            $item = trim(preg_replace('/\s+/', ' ', strip_tags($m[1])));
            return "- {$item}\n";
        }, $md);
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
     * Case study specific diagrams and tech stack metadata
     */
    public static function getCaseSpecifics(string $slug): array
    {
        static $caseSpecifics = [
            'fintech-saas-funnel-resuscitation' => [
                'supp_src' => 'uploads/cases/fintech-payment-pipeline-diagram.svg',
                'supp_alt' => 'Automated FinTech Onboarding & Payment Architecture (Illustrative Schematic)',
                'supp_caption' => 'Exhibit B — Zero-friction client provisioning flow replacing legacy manual verification gates.',
                'supp_badge' => 'INTEGRATION TOPOLOGY',
                'tech_stack' => ['Next.js 14 App Router', 'Stripe Issuing & Vault API', 'Redis Enterprise Idempotency', 'Cloudflare Edge SSR', 'PostgreSQL Timescale', 'Tailwind CSS Design System', 'Plaid KYC Webhooks'],
                'workflow' => [
                    ['step' => '01', 'title' => 'Diagnostic Funnel Telemetry', 'desc' => 'Instrumented full session recordings and micro-latency timers to identify exact user drop-off during payment collection.'],
                    ['step' => '02', 'title' => 'Decoupled Micro-Auth Engine', 'desc' => 'Architected asynchronous KYC bureau checks and tokenized Stripe vaulting to reduce user friction from 7 screens to 1.'],
                    ['step' => '03', 'title' => 'Edge Canary Deployment', 'desc' => 'Deployed new conversion funnel on Cloudflare Workers edge nodes with automated rollback thresholds and continuous health checks.'],
                    ['step' => '04', 'title' => 'Outcome Verification', 'desc' => 'Validated +312% pipeline lift and $908 customer acquisition cost reduction across 90 days of live production traffic.']
                ]
            ],
            'd2c-apparel-vital-infrastructure-overhaul' => [
                'supp_src' => 'uploads/cases/d2c-inventory-routing-topology.svg',
                'supp_alt' => 'D2C Edge Distribution & Multi-Warehouse Routing Topology (Illustrative Schematic)',
                'supp_caption' => 'Exhibit B — Decoupled edge caching and asynchronous inventory routing across regional fulfillment hubs.',
                'supp_badge' => 'EDGE TOPOLOGY',
                'tech_stack' => ['Headless Hydrogen React PWA', 'Shopify Storefront API', 'Cloudflare Workers & KV', 'Redis Order Queue', 'Fastly Image Transcoding', 'Kaviyo Event Webhooks', 'ERP Real-Time Inventory Sync'],
                'workflow' => [
                    ['step' => '01', 'title' => 'Stress-Testing & Concurrency Audit', 'desc' => 'Simulated 50,000 concurrent checkout sessions to isolate database locks and slow liquid template compilation.'],
                    ['step' => '02', 'title' => 'Headless Composable Re-Platforming', 'desc' => 'Built ultra-fast React PWA with optimistic cart state and sub-second catalog hydration on global CDN edge.'],
                    ['step' => '03', 'title' => 'Real-Time Inventory Lock Engine', 'desc' => 'Engineered distributed Redis queuing to synchronize warehouse inventory levels with zero race conditions.'],
                    ['step' => '04', 'title' => 'Peak Flash Sale Delivery', 'desc' => 'Achieved 99.98% uptime and processed 18,500 transactions per minute during peak BFCM event without a single dropped cart.']
                ]
            ],
            'multichannel-retail-marketplace-dominance' => [
                'supp_src' => 'uploads/cases/omnichannel-catalog-sync-architecture.svg',
                'supp_alt' => 'Omnichannel Feed Pipeline & Rate-Limiting Architecture (Illustrative Schematic)',
                'supp_caption' => 'Exhibit B — Asynchronous data processing pipeline ensuring continuous catalog integrity across merchant APIs.',
                'supp_badge' => 'PIPELINE SCHEMATIC',
                'tech_stack' => ['Amazon SP-API v2', 'Walmart Marketplace REST', 'eBay Trading API', 'Node.js Event Bus', 'RabbitMQ Distributed Queue', 'Elasticsearch Master Catalog', 'Automated Margin Repricer'],
                'workflow' => [
                    ['step' => '01', 'title' => 'Catalog Synchronization Audit', 'desc' => 'Audited multi-platform SKU drift, out-of-sync inventory feeds, and algorithmic pricing margin discrepancies.'],
                    ['step' => '02', 'title' => 'Central Master PIM Bus', 'desc' => 'Unified 48,000 SKUs into a canonical master database with automated channel-specific taxonomy formatting.'],
                    ['step' => '03', 'title' => 'Dynamic Margin Repricing Engine', 'desc' => 'Built algorithmic repricing bot with margin safety floors to continuously win Buy Box placement against third-party sellers.'],
                    ['step' => '04', 'title' => 'Continuous Automation', 'desc' => 'Reduced catalog sync latency from 4 hours to 8 seconds, capturing 84% Buy Box share across top revenue categories.']
                ]
            ]
        ];

        return $caseSpecifics[$slug] ?? [];
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
        $canonicalUrl = $baseUrl . '/blog/' . urlencode($slug);
        $cleanMdUrl = $baseUrl . '/blog/' . urlencode($slug) . '.md';
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
        if (!empty($blog['featured_image'])) {
            $imgSrc = $blog['featured_image'];
            $imgUrl = str_starts_with($imgSrc, 'http') ? $imgSrc : ($baseUrl . '/' . ltrim($imgSrc, '/'));
            $alt = !empty($blog['cover_image_alt']) ? $blog['cover_image_alt'] : $title;
            $lines[] = "![{$alt}]({$imgUrl})";
            $lines[] = "";
        }
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
        $canonicalUrl = $baseUrl . '/case-studies/' . urlencode($slug);
        $cleanMdUrl = $baseUrl . '/case-studies/' . urlencode($slug) . '.md';
        $mdUrl = $baseUrl . '/md/case-studies/' . urlencode($slug) . '.md';
        $summary = trim($case['project_summary'] ?? '');
        $baseline = trim($case['baseline_metric'] ?? '');
        $outcome = trim($case['outcome_metric'] ?? '');
        $metricLabel = trim($case['metric_label'] ?? '');

        $spec = self::getCaseSpecifics($slug);

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

        if (!empty($case['featured_image'])) {
            $imgSrc = $case['featured_image'];
            $imgUrl = str_starts_with($imgSrc, 'http') ? $imgSrc : ($baseUrl . '/' . ltrim($imgSrc, '/'));
            $alt = !empty($case['cover_image_alt']) ? $case['cover_image_alt'] : $title;
            $lines[] = "![{$alt}]({$imgUrl})";
            $lines[] = "";
        }
        $lines[] = "---";
        $lines[] = "";

        if (!empty($case['challenge'])) {
            $lines[] = "## 01 // Challenge & Operational Bottlenecks";
            $lines[] = "### Critical Operational & Revenue Roadblocks";
            $lines[] = self::htmlToMarkdown($case['challenge']);
            $lines[] = "";
        }

        if (!empty($case['solution']) || !empty($case['prescription'])) {
            $lines[] = "## 02 // Strategic Solution & Engineering Execution";
            $lines[] = "### Prescribed Engineering Architecture";
            $lines[] = self::htmlToMarkdown($case['solution'] ?: $case['prescription']);
            $lines[] = "";
        }

        if (!empty($spec['supp_src'])) {
            $lines[] = "## 03 // Supporting Architectural Blueprint";
            $lines[] = "### Deployed System Topology";
            $diagUrl = str_starts_with($spec['supp_src'], 'http') ? $spec['supp_src'] : ($baseUrl . '/' . ltrim($spec['supp_src'], '/'));
            $lines[] = "![{$spec['supp_alt']}]({$diagUrl})";
            $lines[] = "";
            $lines[] = "*{$spec['supp_caption']}* `[Badge: {$spec['supp_badge']}]`";
            $lines[] = "";
        }

        if (!empty($spec['tech_stack'])) {
            $lines[] = "## 04 // Technical Stack Deployed";
            $lines[] = "### Tools & Technologies Deployed";
            foreach ($spec['tech_stack'] as $t) {
                $lines[] = "- `{$t}`";
            }
            $lines[] = "";
        }

        if (!empty($spec['workflow'])) {
            $lines[] = "## 05 // Project Delivery Workflow";
            $lines[] = "### Execution & Delivery Methodology";
            foreach ($spec['workflow'] as $wf) {
                $lines[] = "#### Stage {$wf['step']}: {$wf['title']}";
                $lines[] = $wf['desc'];
                $lines[] = "";
            }
        }

        if (!empty($case['implementation'])) {
            $lines[] = "## 06 // Implementation & Hardening Notes";
            $lines[] = self::htmlToMarkdown($case['implementation']);
            $lines[] = "";
        }

        if (!empty($case['results']) || !empty($case['result_description'])) {
            $lines[] = "## 07 // Quantifiable Business Outcomes";
            $lines[] = "### Long-Term Business & Technical Impact";
            $lines[] = self::htmlToMarkdown($case['results'] ?: $case['result_description']);
            $lines[] = "";
        }

        if (!empty($case['quote_text'])) {
            $quoteAuthor = $case['quote_author'] ?? 'Executive Sponsor';
            $quoteTitle = !empty($case['quote_title']) ? ', ' . $case['quote_title'] : '';
            $lines[] = "## Executive Client Verification";
            $lines[] = "> \"{$case['quote_text']}\"";
            $lines[] = "> ";
            $lines[] = "> — **{$quoteAuthor}**{$quoteTitle}";
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
        $file = ROOT_PATH . '/includes/services/' . $slug . '.php';
        
        $serviceName = $service['name'] ?? 'Practice Area';
        $serviceSlug = $slug;
        $consultationUrl = $baseUrl . '/contact?service=' . urlencode($serviceName);
        $canonicalUrl = $baseUrl . '/service/' . $slug;
        $cleanMdUrl = $baseUrl . '/service/' . $slug . '.md';
        $mdUrl = $baseUrl . '/md/services/' . urlencode($slug) . '.md';

        $bodyMd = '';
        if (file_exists($file)) {
            ob_start();
            include $file;
            $rawHtml = ob_get_clean();

            // Strip raw SVGs and purely decorative elements
            $cleanHtml = preg_replace('#<svg\b[^>]*>.*?</svg>#is', '', $rawHtml);
            $cleanHtml = preg_replace('#<span class="srv-eyebrow-dot"[^>]*></span>#is', '', $cleanHtml);
            $cleanHtml = preg_replace('#<div class="srv-process-num"[^>]*>.*?</div>#is', '', $cleanHtml);

            $bodyMd = self::htmlToMarkdown($cleanHtml);
            // Re-enforce canonical clean consultation URL so included templates don't pollute local scope
            $consultationUrl = $baseUrl . '/contact?service=' . urlencode($serviceName);
        } else {
            $desc = !empty($service['description']) ? self::htmlToMarkdown($service['description']) : ($service['summary'] ?? '');
            $bodyMd = "## Practice Overview\n\n" . $desc;
            if (!empty($service['deliverables']) && is_array($service['deliverables'])) {
                $bodyMd .= "\n\n## Key Deliverables\n";
                foreach ($service['deliverables'] as $del) {
                    $bodyMd .= "- " . trim($del) . "\n";
                }
            }
            if (!empty($service['kpis']) && is_array($service['kpis'])) {
                $bodyMd .= "\n\n## Target Performance KPIs\n";
                foreach ($service['kpis'] as $kpi) {
                    $bodyMd .= "- " . trim($kpi) . "\n";
                }
            }
        }

        $lines = [];
        $lines[] = "# {$serviceName}";
        $lines[] = "";
        if (!empty($service['tagline'])) {
            $lines[] = "> " . trim($service['tagline']);
            $lines[] = "";
        }
        $lines[] = "## Discipline Information";
        $lines[] = "- **Practice Area**: " . ($service['number'] ?? '') . " {$serviceName}";
        $lines[] = "- **Canonical Web URL**: [{$canonicalUrl}]({$canonicalUrl})";
        $lines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
        $lines[] = "- **Central Markdown URL**: [{$mdUrl}]({$mdUrl})";
        $lines[] = "- **Direct Consultation**: [Schedule Practice Scope]({$consultationUrl})";
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";
        $lines[] = $bodyMd;
        $lines[] = "";
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
        $hq = defined('APP_HEADQUARTERS') ? APP_HEADQUARTERS : 'Executive Tech Park, Innovation District, Sector 62, Noida, Uttar Pradesh 201309, India';

        switch ($pageKey) {
            case 'about':
                return <<<MD
# Business Doctor - Digital Marketing company in Delhi

> Business Doctor is a digital marketing company in Delhi that provides seo services in delhi , ppc services, social media marketing in Delhi, website development services and graphic design services in Delhi, which helps your business to grow and reach its full potential. We personalize every strategy according to your business needs. We aim to increase your brand visibility and get you quality leads.

## Firm Information & Digital Resources
- **Canonical Web URL**: [{$baseUrl}/about]({$baseUrl}/about)
- **Clean Markdown URL**: [{$baseUrl}/about.md]({$baseUrl}/about.md)
- **Central Markdown URL**: [{$baseUrl}/md/about.md]({$baseUrl}/md/about.md)
- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)
- **Corporate Legal Entity**: {$legalName}
- **Headquarters**: {$hq}
- **Advisory Contact**: [{$email}](mailto:{$email}) | Phone: {$phone}

---

## The BusinessDoctor Philosophy: Why Businesses Call BusinessDoctor the Best Digital Marketing Company in Delhi
We believe that every business has the potential to grow and we provide a full-service digital marketing company that helps your business grow.Our professional team helps you at every step from web development to lead generation. We don't make big promises and leave you in the middle, we provide you with weekly reports and updates on your business so that you can track your growth as well.

### 01 // Diagnostic Identification: Challenges a Digital Marketing Company in Delhi Can Help Solve
Does your business have low lead generation, poor website performance, poor user experience and a low conversion rate? If these challenges are limiting your growth, you need the right strategy to grow your business from Business Doctor- a trusted digital marketing company in Delhi that helps your brand to get quality customers.

### 02 // The Clinical Diagnosis: End-to-End Digital Marketing Services in Delhi
Business Doctor's experienced digital marketing team identifies the root cause of your low performance and makes a personalized solution plan that suits your business problem. We believe that every business needs a different approach to grow. Our professional team manages everything on-page, off-page, Website development and more.

### 03 // Measurable Execution: Growth-Focused Digital Marketing Solutions in Delhi
Once we identify the problem and create the plan, we implement it and follow up till we reach the desired result. As a full-service digital marketing company, we provide everything from developing user friendly websites to improving marketing campaigns, our aim is to deliver measurable results.

---

## Four Commitments We Stand By as a Digital Marketing Company
As a Digital Marketing company in Delhi, we believe that successful partnership is built on trust, accountability, engineering excellence and transparency. We follow our four non-negotiable commitments to make sure that every business achieves its full potential.

### Commitment 01: Clean, Framework-Free Code
Business Doctor, a trusted digital marketing company in Delhi focuses on clean coding, which avoids unnecessary heavy frameworks and makes websites fast, effective and user-friendly providing users with a smooth and seamless experience and helping to make your business recognisable.

### Commitment 02: Measurable Commercial ROI
Business Doctor is a professional digital marketing company. Our team doesn't just focus on improving website marketing,we identify the gaps of your business that are holding it back and work on them so that you get quality leads. We also track how many leads, sales, and conversions you are getting.

### Commitment 03: Integrated End-to-End Delivery
BusinessDoctor, a digital marketing company in Delhi provides full services in digital marketing from website development to digital marketing so that you get all services on one platform.

### Commitment 04: Long-Term Partnership & Support
We don't just believe in making a website we believe in building long term business relationships. We monitor your business’s regular performance, improve the strategy according to needs and support you at every step so that your business can grow continuously.

---

## Our Purpose & Direction: Business Growth Through Digital Marketing Solutions
At BusinessDoctor, we help businesses grow through a strategic digital marketing plan and innovative technology. As a digital marketing expert in Delhi, we focus on improving online visibility, generating quality leads, improving user experiences and increasing conversions.

### Our Mission: Digital Marketing Solutions for Business Growth
Business Doctor's mission is to overcome the challenges that your business is facing by providing the right strategy so that you get potential customers. Through transparency and technical excellence, we want to create impact and make your brand unforgettable.

### Our Vision: Trusted Digital Marketing company for Business Growth
Business Doctors is a trusted digital marketing company in Delhi. Our vision is to be a digital marketing partner for businesses to empower businesses with innovative digital strategies, advanced technologies, lead generation and sustainable growth. We want to provide solutions for your digital challenges, so that you can build a strong online presence.

---

## Elevate Your Digital Capabilities
Schedule an introductory discovery call with our tech leads to discuss your web development, digital marketing, or branding requirements.
- **Direct Consultation**: [Schedule a Project Consultation]({$baseUrl}/contact)
- **Complimentary Diagnostic**: [Request Free Digital Audit]({$baseUrl}/audit)
- **Practice Hub**: [Explore IT Services & Practice Areas]({$baseUrl}/services)

---
*Maintained by {$appName} Corporate Communications.*
MD;

            case 'contact':
                return <<<MD
# Let’s Build Something Exceptional Together

> Whether you need a custom high-performance web application, a full-funnel digital marketing campaign, an Amazon storefront overhaul, or ongoing cloud infrastructure support, our senior technical teams are ready to collaborate.

## Engagement Information & Digital Resources
- **Canonical Web URL**: [{$baseUrl}/contact]({$baseUrl}/contact)
- **Clean Markdown URL**: [{$baseUrl}/contact.md]({$baseUrl}/contact.md)
- **Central Markdown URL**: [{$baseUrl}/md/contact.md]({$baseUrl}/md/contact.md)
- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)
- **Direct Advisory Phone**: {$phone}
- **Advisory & Scoping Email**: [{$email}](mailto:{$email})
- **Corporate Headquarters**: {$hq}
- **Guaranteed Response SLA**: Initial technical review and response within 2 business hours.

---

## 01 // Request a Project Proposal
Tell us about your project requirements. Our solutions team reviews incoming requests and responds with preliminary architectural insights within 2 business hours.

### Intake Parameters & Requirements Checklist
When submitting a project scope or proposal request, please prepare the following details:
1. **Primary Contact**: Full name, official corporate email, and direct telephone/WhatsApp number.
2. **Company / Organization**: Corporate legal name and primary website domain.
3. **Practice Area / Discipline**:
   - Web & Custom Software Development
   - Digital Marketing, Paid Ads & SEO
   - UI/UX Design & Brand Identity
   - E-Commerce & Marketplace Management
   - Creative Production & Video Marketing
   - Cloud Solutions & IT Consulting
   - Comprehensive Website & Digital Audit
4. **Estimated Budget Allocation**:
   - \$5,000 – \$10,000 (Targeted diagnostic or single-discipline project)
   - \$10,000 – \$25,000 (Complete web platform build or multi-channel growth sprint)
   - \$25,000 – \$50,000 (Enterprise software overhaul or comprehensive re-platforming)
   - \$50,000+ (Full digital transformation, bespoke SaaS engineering, or annual retainer)
5. **Project Overview & Objectives**: Key commercial targets, current operational bottlenecks, desired deliverables, and target launch timeline.

---

## 02 // Direct Access to Technical Leads
When you engage BusinessDoctor, you speak directly with experienced software engineers, conversion rate optimization specialists, and digital strategists — never junior account managers or sales intermediaries.
- **Collaborative Problem-Solving**: We analyze your current architecture, ad account configurations, and conversion funnels during the initial consultation.
- **No Vanity Metrics**: We align our engagement scope with bottom-line business objectives, from lower customer acquisition cost (CAC) to higher Average Order Value (AOV).
- **Rapid Prototyping & Scoping**: Within 48 hours of initial intake, we deliver a concrete technical blueprint detailing milestones, deliverables, tech stacks, and investment.

---

## 03 // Physical Headquarters & Global Operational Coordinates
- **Headquarters**: {$hq}
- **Advisory Direct Line**: {$phone}
- **General & Scoping Inquiries**: [{$email}](mailto:{$email})
- **Technical Support Desk**: [{$email}](mailto:{$email})
- **Operating Hours**: Monday through Friday, 09:00 – 19:00 IST / 24/7/365 Emergency Monitoring for Enterprise Clients with Active SLAs.

---

## 04 // Engagement Roadmap
1. **Initial Diagnostic Briefing (Day 1)**: 30-minute introductory call to benchmark current digital friction, revenue goals, and technical requirements.
2. **Technical Scope & Commercial Proposal (Days 2–3)**: Comprehensive specification document outlining architecture, sprint schedule, KPIs, and fixed pricing.
3. **Sprint Kickoff & Dedicated Lead Assignment (Week 1)**: Immediate deployment of dedicated technical lead, shared communication channels, and Git milestone tracking.

---
*Maintained by {$appName} Executive Advisory Practice.*
MD;

            case 'audit':
                return <<<MD
# Technical Architecture & Digital Growth Audit

> Discover technical bottlenecks, page speed issues, and SEO gaps holding back your online business. Submit your domain to receive real live telemetry analysis and a customized project proposal within 24 hours.

## Diagnostic Resource Information
- **Canonical Web URL**: [{$baseUrl}/audit]({$baseUrl}/audit)
- **Clean Markdown URL**: [{$baseUrl}/audit.md]({$baseUrl}/audit.md)
- **Central Markdown URL**: [{$baseUrl}/md/audit.md]({$baseUrl}/md/audit.md)
- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)
- **Audit Turnaround SLA**: Guaranteed delivery of full report to corporate email within 24 hours.
- **Confidentiality Standard**: Enterprise non-disclosure protection across all collected telemetry and audit findings.

---

## 01 // Multi-Vector Diagnostic Scope
Our senior engineering and performance marketing leads conduct a clinical diagnostic evaluation across four critical digital vectors:

### Vector 1: Engineering Architecture & Server Latency
- **Time to First Byte (TTFB)**: Server-side processing overhead, database query performance, and web server configuration.
- **Google Core Web Vitals**: Real-world LCP (Largest Contentful Paint), INP (Interaction to Next Paint), and CLS (Cumulative Layout Shift) measurements.
- **Asset Weight & Compression**: Evaluation of CSS/JS minification, edge caching headers, and modern image formats (WebP/AVIF).
- **Mobile Usability & Responsiveness**: Viewport configuration, DOM depth, layout stability, and tap target spacing.

### Vector 2: Digital Marketing, SEO & Funnel Acquisition
- **Technical SEO Crawlability**: Indexing hygiene, robots.txt, XML sitemaps, canonical tags, and schema.org structured data.
- **Ad Spend Efficiency & CAC Leakage**: Evaluation of landing page relevance, headline alignment, tracking tags (GA4 / Meta CAPI), and conversion drop-offs.
- **Keyword & Competitive Gap Analysis**: Ranking positions for commercial-intent keywords vs primary sector competitors.

### Vector 3: Security, Resilience & Compliance Posture
- **SSL/TLS Encryption Hygiene**: Certificate validity, cipher suite security, and HTTPS enforcement.
- **Security Headers Evaluation**: HSTS, Content-Security-Policy (CSP), X-Frame-Options, and X-Content-Type-Options posture.
- **Data Protection & Compliance**: Form input sanitization, CSRF token validation, and cookie consent mechanisms.

### Vector 4: Conversion Rate Optimization (CRO) & User Journey
- **Friction Points & Cognitive Load**: Cluttered page layouts, excessive form fields, confusing navigation, and unclear calls-to-action.
- **Trust Architecture**: Placement of social proof, client logos, case studies, security badges, and clear pricing disclosures.

---

## 02 // Diagnostic Intake Parameters
To initiate an automated live telemetry scan and detailed manual engineering review, submit the following property parameters:
1. **Website Domain / URL**: (e.g., `https://yourcompany.com`)
2. **Primary Area of Concern**:
   - Slow Website Loading & Poor Core Web Vitals
   - High Ad Spend & Low Conversion Rates / Escalating CAC
   - Low Organic Search Rankings & Technical SEO Deficits
   - Outdated Brand Identity & Sub-Optimal UI/UX Design
   - Marketplace / E-Commerce Operations & Amazon Buy Box Losses
   - Unstable Server Infrastructure & Frequent Downtime
3. **Monthly Traffic & Transaction Volume**: Benchmarking platform scale.
4. **Corporate Email**: Required for secure delivery of the complete audit report.

---

## 03 // What You Receive in the Comprehensive Digital Audit Report
- **Executive Scorecard**: A-to-F ratings across Architecture, SEO, Conversion, and Security.
- **Telemetry Waterfall Chart**: Exact resource loading sequence identifying slow third-party scripts and database queries.
- **Prioritized Action Plan**: Ranked checklist of high-impact fixes categorized by engineering effort vs revenue impact.
- **Fixed-Price Scoping Proposal**: Transparent implementation scope detailing timeline, sprint milestones, and investment required for BusinessDoctor to execute the fixes.

---

## 04 // Next Steps
- **Submit Audit Request**: [Request Free Digital Audit Online]({$baseUrl}/audit)
- **Schedule Live Discovery Call**: [Contact Tech Leads]({$baseUrl}/contact)
- **Explore All IT Disciplines**: [Services Overview]({$baseUrl}/services)

---
*Maintained by {$appName} Diagnostic Practice.*
MD;

            case 'services':
                $services = self::getActiveServices();
                $sLines = [];
                $sLines[] = "# Top Digital Marketing company in Delhi NCR";
                $sLines[] = "";
                $sLines[] = "> We offer a full-suite of digital marketing and IT services in Delhi NCR. Ten specialized disciplines built to solve complex business bottlenecks, capture qualified pipeline, and deliver measurable revenue outcomes.";
                $sLines[] = "";
                $sLines[] = "## Hub Information & Digital Resources";
                $sLines[] = "- **Canonical Web URL**: [{$baseUrl}/services]({$baseUrl}/services)";
                $sLines[] = "- **Clean Markdown URL**: [{$baseUrl}/services.md]({$baseUrl}/services.md)";
                $sLines[] = "- **Central Markdown URL**: [{$baseUrl}/md/services.md]({$baseUrl}/md/services.md)";
                $sLines[] = "- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
                $sLines[] = "- **Total Integrated Disciplines**: " . count($services) . " specialized practices";
                $sLines[] = "";
                $sLines[] = "---";
                $sLines[] = "";
                $sLines[] = "## Core Practice Disciplines";
                $sLines[] = "";

                foreach ($services as $slug => $s) {
                    $num = $s['number'] ?? '';
                    $name = $s['name'] ?? 'Practice Area';
                    $tagline = $s['tagline'] ?? '';
                    $summary = $s['summary'] ?? '';
                    $description = $s['description'] ?? '';
                    $webUrl = "{$baseUrl}/service/{$slug}";
                    $cleanMdUrl = "{$baseUrl}/service/{$slug}.md";
                    $centralMdUrl = "{$baseUrl}/md/services/{$slug}.md";
                    $consultUrl = "{$baseUrl}/contact?service=" . urlencode($name);

                    $sLines[] = "### Discipline // {$num}: {$name}";
                    $sLines[] = "> *{$tagline}*";
                    $sLines[] = "";
                    $sLines[] = "- **Canonical Web URL**: [{$webUrl}]({$webUrl})";
                    $sLines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
                    $sLines[] = "- **Central Markdown URL**: [{$centralMdUrl}]({$centralMdUrl})";
                    $sLines[] = "- **Scope Consultation**: [Request Scope for {$name}]({$consultUrl})";
                    $sLines[] = "";
                    $sLines[] = "**Practice Summary:**";
                    $sLines[] = $summary;
                    $sLines[] = "";
                    if (!empty($description) && $description !== $summary) {
                        $sLines[] = "**Discipline Scope & Execution:**";
                        $sLines[] = $description;
                        $sLines[] = "";
                    }

                    if (!empty($s['deliverables']) && is_array($s['deliverables'])) {
                        $sLines[] = "**Key Technical Deliverables:**";
                        foreach ($s['deliverables'] as $del) {
                            $sLines[] = "- " . trim($del);
                        }
                        $sLines[] = "";
                    }

                    if (!empty($s['kpis']) && is_array($s['kpis'])) {
                        $sLines[] = "**Key Performance Commitment (KPIs):**";
                        foreach ($s['kpis'] as $kpi) {
                            $sLines[] = "- `{$kpi}`";
                        }
                        $sLines[] = "";
                    }
                    $sLines[] = "---";
                    $sLines[] = "";
                }

                $sLines[] = "## Need a Custom IT or Marketing Solution?";
                $sLines[] = "Every enterprise challenge is unique. We configure bespoke multi-disciplinary teams tailored to your specific technical architecture, growth bottlenecks, and commercial objectives.";
                $sLines[] = "- [Schedule Project Consultation]({$baseUrl}/contact)";
                $sLines[] = "- [Request Free Digital Audit]({$baseUrl}/audit)";
                $sLines[] = "";
                $sLines[] = "---";
                $sLines[] = "*Delivered by [BusinessDoctor]({$baseUrl}) Technology Practice.*";

                return implode("\n", $sLines);

            case 'insights':
                $insights = self::getPublishedInsights();
                $iLines = [];
                $iLines[] = "# Technical Blog & Strategic Frameworks";
                $iLines[] = "";
                $iLines[] = "> Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.";
                $iLines[] = "";
                $iLines[] = "## Editorial Information & Digital Resources";
                $iLines[] = "- **Canonical Web URL**: [{$baseUrl}/blog]({$baseUrl}/blog)";
                $iLines[] = "- **Clean Markdown URL**: [{$baseUrl}/blog.md]({$baseUrl}/blog.md)";
                $iLines[] = "- **Central Markdown URL**: [{$baseUrl}/md/insights.md]({$baseUrl}/md/insights.md)";
                $iLines[] = "- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
                $iLines[] = "- **Published Articles**: " . count($insights) . " technical perspectives";
                $iLines[] = "";
                $iLines[] = "---";
                $iLines[] = "";
                $iLines[] = "## Published Blog Articles";
                $iLines[] = "";

                if (empty($insights)) {
                    $iLines[] = "No technical articles are currently published in the knowledge base.";
                } else {
                    foreach ($insights as $art) {
                        $title = trim($art['title']);
                        $slug = $art['slug'];
                        $author = $art['author_name'] ?: ($art['author'] ?: 'BusinessDoctor Engineering');
                        $authorTitle = $art['author_title'] ?? 'Senior Engineering Consultant';
                        $readTime = $art['reading_time'] ?? '5 min read';
                        $category = $art['category'] ?? 'Enterprise Strategy';
                        $pubDate = !empty($art['published_at']) ? date('F j, Y', strtotime($art['published_at'])) : 'Published';
                        $summary = trim(preg_replace('/\s+/', ' ', strip_tags($art['summary'] ?: ($art['excerpt'] ?: ''))));
                        $webUrl = "{$baseUrl}/blog/{$slug}";
                        $cleanMdUrl = "{$baseUrl}/blog/{$slug}.md";
                        $centralMdUrl = "{$baseUrl}/md/insights/{$slug}.md";

                        $iLines[] = "### {$title}";
                        $iLines[] = "- **Category**: {$category} | **Read Time**: {$readTime}";
                        $iLines[] = "- **Author**: {$author} ({$authorTitle}) | **Published**: {$pubDate}";
                        $iLines[] = "- **Canonical Web URL**: [{$webUrl}]({$webUrl})";
                        $iLines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
                        $iLines[] = "- **Central Markdown URL**: [{$centralMdUrl}]({$centralMdUrl})";
                        if (!empty($summary)) {
                            $iLines[] = "";
                            $iLines[] = "**Executive Summary:**";
                            $iLines[] = $summary;
                        }
                        $iLines[] = "";
                    }
                }

                $iLines[] = "---";
                $iLines[] = "*Published by [BusinessDoctor]({$baseUrl}) Editorial & Engineering Staff.*";
                return implode("\n", $iLines);

            case 'case-studies':
                $cases = self::getPublishedCaseStudies();
                $cLines = [];
                $cLines[] = "# Client Case Studies & Proven Results";
                $cLines[] = "";
                $cLines[] = "> Measurable outcomes, revenue acceleration, and architectural turnarounds for enterprise clients across FinTech, D2C Apparel, and Multichannel Retail.";
                $cLines[] = "";
                $cLines[] = "## Case Studies Index & Digital Resources";
                $cLines[] = "- **Canonical Web URL**: [{$baseUrl}/case-studies]({$baseUrl}/case-studies)";
                $cLines[] = "- **Clean Markdown URL**: [{$baseUrl}/case-studies.md]({$baseUrl}/case-studies.md)";
                $cLines[] = "- **Central Markdown URL**: [{$baseUrl}/md/case-studies.md]({$baseUrl}/md/case-studies.md)";
                $cLines[] = "- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)";
                $cLines[] = "- **Published Case Studies**: " . count($cases) . " documented client turnarounds";
                $cLines[] = "";
                $cLines[] = "---";
                $cLines[] = "";
                $cLines[] = "## Documented Enterprise Transformations";
                $cLines[] = "";

                if (empty($cases)) {
                    $cLines[] = "No client case studies are currently published.";
                } else {
                    foreach ($cases as $c) {
                        $title = trim($c['title']);
                        $slug = $c['slug'];
                        $client = $c['client_name'] ?? 'Confidential Enterprise Client';
                        $industry = $c['industry'] ?: ($c['client_industry'] ?: 'Enterprise');
                        $practice = $c['service_category'] ?: ($c['practice_area'] ?: 'Digital Practice');
                        $baseline = $c['baseline_metric'] ?? '';
                        $outcome = $c['outcome_metric'] ?? '';
                        $metricLabel = $c['metric_label'] ?? '';
                        $webUrl = "{$baseUrl}/case-studies/{$slug}";
                        $cleanMdUrl = "{$baseUrl}/case-studies/{$slug}.md";
                        $centralMdUrl = "{$baseUrl}/md/case-studies/{$slug}.md";

                        $cLines[] = "### {$title}";
                        $cLines[] = "- **Client**: {$client}";
                        $cLines[] = "- **Industry**: {$industry} | **Discipline**: {$practice}";
                        if ($baseline || $outcome) {
                            $cLines[] = "- **Quantifiable Metric Shift**: `{$baseline}` → `{$outcome}`" . ($metricLabel ? " ({$metricLabel})" : "");
                        }
                        $cLines[] = "- **Canonical Web URL**: [{$webUrl}]({$webUrl})";
                        $cLines[] = "- **Clean Markdown URL**: [{$cleanMdUrl}]({$cleanMdUrl})";
                        $cLines[] = "- **Central Markdown URL**: [{$centralMdUrl}]({$centralMdUrl})";
                        if (!empty($c['project_summary'])) {
                            $cLines[] = "";
                            $cLines[] = "**Project Executive Summary:**";
                            $cLines[] = trim(preg_replace('/\s+/', ' ', strip_tags($c['project_summary'])));
                        }
                        $cLines[] = "";
                    }
                }

                $cLines[] = "---";
                $cLines[] = "*Documented by [BusinessDoctor]({$baseUrl}) Client Turnaround Practice.*";
                return implode("\n", $cLines);

            case 'home':
            default:
                return <<<MD
# Technology That Moves Business Forward. Engineered for Scalable Growth.

> From intelligent software to digital growth, we engineer solutions that help businesses move beyond limitations. We unify custom engineering, performance marketing, and marketplace operations under one disciplined standard.

## Platform Information & Digital Resources
- **Canonical Web URL**: [{$baseUrl}/]({$baseUrl}/)
- **Clean Markdown URL**: [{$baseUrl}/.md]({$baseUrl}/.md)
- **Central Markdown URL**: [{$baseUrl}/md/home.md]({$baseUrl}/md/home.md)
- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)
- **AI Agent Discovery**: [{$baseUrl}/llms.txt]({$baseUrl}/llms.txt)
- **XML Sitemap**: [{$baseUrl}/sitemap.xml]({$baseUrl}/sitemap.xml)
- **Primary Contact**: [{$email}](mailto:{$email}) | Phone: {$phone}
- **Headquarters**: {$hq}

---

## 01 // Portfolio Benchmark Targets & Operating Standards
- **Global Latency / Speed Target**: `< 0.8s` (100% Core Web Vitals Benchmark)
- **Client Portfolio ROAS**: `3.8x – 4.6x` (Audited Zero Ad Budget Waste)
- **High-Availability SLA**: `99.98%` (Cloud Redundant Infrastructure)
- **Marketplace Buy Box**: `94%+` (Amazon & Flipkart Brand Defense)
- **Portfolio Outcomes**: 450+ Projects Delivered | \$48M+ Revenue Generated | 98.4% Client Retention | 3.8x Average ROAS

---

## 02 // Featured Capabilities (Digital Marketing Services in Delhi)
Business Doctor is a full-service digital marketing company in Delhi NCR that provides you with the best digital marketing services, from web development, digital marketing and e-commerce management to cloud solutions. Our team provides you with suitable personalization strategies that help you to grow.

### 01. Web and software development services
Business Doctor is an Affordable Digital Marketing company in Delhi that provides digital marketing services. We build every website from scratch and custom software solutions according to your needs, creating secure, fast and easy to use digital solutions. Our services reflect your brand identity and make your brand remarkable.
- **Core Deliverables**: Custom Website and Software Development; User-Friendly UI/UX Design; Mobile Friendly Development; Advanced Features and API Integration; Secure and Scalable Digital Solutions.
- **Discipline Link**: [Web Development Practice]({$baseUrl}/service/web-development)

### 02. Digital marketing, PPC and SEO services
Better search engine optimization, digital marketing and performance ads can help your website rank and get you more leads, as we are an affordable digital marketing company in Delhi. Our team provides you with everything that makes your business recognisable, from improving Google search rankings to running targeted ad campaigns. Business Doctor’s team provides you with the best and affordable seo and digital marketing services in delhi NCR.
- **Core Deliverables**: Effective Keyword Research and SEO; On-Page, Off-Page and Technical SEO Optimisation; Google Ads and PPC Campaign Management; Social Media and Paid Advertising; Lead Generation and Performance Tracking.
- **Discipline Link**: [SEO & Digital Marketing Practice]({$baseUrl}/service/seo)

### 03. UI/UX Design and Brand Identity
Business doctors create attractive and user friendly websites and software that help your business grow and provide you with leads, so that you can reach quality customers. We customise every project to make your brand memorable and to provide users with the most seamless experience.
- **Core Deliverables**: User Friendly UI/UX Design; Creative Websites; Logo and Brand Identity Design; Engaging Visual and Graphic Design; Consistent Brand Colours and Typography.
- **Discipline Link**: [UI/UX & Graphic Design Practice]({$baseUrl}/service/graphic-design)

### 04. E-Commerce and Marketplace Management Service
Businessdoctor is the best digital marketing company in Delhi that helps businesses manage and grow their online stores across different platforms, from product listing and inventory management to order handling and sales tracking. Our team ensures a smooth shopping experience for customers and better business growth.
- **Core Deliverables**: Online Store Management; Product Listing and Optimisation; Marketplace Account Management; Order and Inventory Management; Sales and Performance Tracking.
- **Discipline Link**: [E-Commerce Management Practice]({$baseUrl}/service/ecommerce-management)

### 05. Creative Production and Video Marketing
Businessdoctor is the best online digital marketing company in Delhi. Our team creates interesting and engaging content that grabs the audience's attention. Your engaging Instagram reels, product photography, videography and more everything is our responsibility.
- **Core Deliverables**: Promotional Video Creation; Social Media Reels and Shorts; Product Photography and Videography; UGC Video Production; Video Editing and Motion Graphics.
- **Discipline Link**: [Creative Video Editing Practice]({$baseUrl}/service/video-editing)

### 06. Cloud Solutions and IT Consulting
We are the Affordable Digital Marketing company in Delhi that provides IT solutions and cloud services to your business that make your data safe and daily operations smooth. We are the Best digital marketing company in Delhi, helping with cloud setup, data management, security and technical support so that you can manage your business technology easily.
- **Core Deliverables**: Cloud Storage and Data Management; Cloud Setup and Migration; Data Security and Backup Solutions; IT Infrastructure Management; Technical Support and System Monitoring.
- **Discipline Link**: [All Services Overview]({$baseUrl}/services)

---

## 03 // 10 Integrated Practice Disciplines Built for Enterprise Scale
1. **[SMO (Social Media Optimization)]({$baseUrl}/service/smo)**: Strategic profile optimization, bio conversion funnels, branded content templates, and social visibility.
2. **[Google Business Profile Management]({$baseUrl}/service/google-business-profile)**: Complete GBP setup, Google Maps optimization, local search visibility, and review strategy.
3. **[PPC / Paid Ads]({$baseUrl}/service/ppc-paid-ads)**: High-converting Google Search, Performance Max, Meta Ads, and LinkedIn B2B advertising campaigns.
4. **[Ecommerce Management]({$baseUrl}/service/ecommerce-management)**: Amazon and Flipkart marketplace management, product listings, inventory optimization, A+ content, and marketplace growth.
5. **[Graphic Design]({$baseUrl}/service/graphic-design)**: Corporate brand identity, creative graphics, marketing materials, social media creatives, and visual communication.
6. **[SEO — Search Engine Optimization]({$baseUrl}/service/seo)**: Technical SEO, on-page optimization, keyword strategy, search visibility, organic traffic, and performance monitoring.
7. **[Social Media Marketing]({$baseUrl}/service/social-media-marketing)**: Social media strategy, content planning, campaign management, audience engagement, and brand growth.
8. **[Product Photography]({$baseUrl}/service/product-photography)**: Professional product photography, ecommerce product visuals, creative compositions, and conversion-focused imagery.
9. **[Video Editing]({$baseUrl}/service/video-editing)**: Professional promotional videos, short-form content, Instagram Reels, YouTube Shorts, and brand videos.
10. **[Web Development]({$baseUrl}/service/web-development)**: Fast, responsive business websites, custom web applications, performance optimization, and conversion-focused development.

---

## 04 // The Transformation: Why Managing Multiple Freelancers & Vendors Slows Down Your Growth

### The Problem: Disconnected Work, Technical Debt & Wasted Ad Budgets
- **Finger-Pointing Between Vendors**: Developers blame designers; ad agencies blame developers for slow landing pages; marketplace managers operate in total isolation.
- **Compounding Technical Debt**: Patchwork codebases with unmaintained plugins, security vulnerabilities, and slow database queries.
- **Ad Spend Bleeding**: Traffic is sent to slow, unoptimized landing pages that fail to convert, driving up CAC.
- **Administrative Fatigue**: Founders and executives spend hours coordinating disconnected contractors instead of scaling operations.

### The Solution: Integrated Engineering & High-Velocity Digital Execution
- **One Accountable Partner**: Software engineering, brand design, paid acquisition, and operations united under one technical leadership.
- **Clean, Maintainable Architectures**: Clean procedural and object-oriented code built for long-term scalability without framework bloat.
- **Conversion-Aligned Systems**: Every line of code and marketing funnel is engineered specifically to maximize commercial transaction completion.
- **Direct Lead Access**: Weekly sprint reviews with senior technical directors.

---

## 05 // Why Businesses Choose BusinessDoctor
Six decisive advantages engineered into every client partnership:
1. **Direct Access to Technical Leads**: Direct communication with senior software architects and digital strategists — never junior account managers.
2. **Sub-Second Performance Standards**: We mandate TTFB under 200ms and total page load under 1.2s to maximize search rankings and ad conversion rates.
3. **Conversion-Centered Architecture**: Every interface, navigation path, and button is engineered to guide users toward measurable transactions.
4. **Full IP Ownership & Transparency**: You own 100% of your source code, design assets, and ad accounts. Zero vendor lock-in.
5. **Data-Driven Growth Marketing**: Precision attribution modeling combining GA4, Meta CAPI, and server-side tracking.
6. **Dedicated Post-Launch Support & SLA**: 24/7 infrastructure monitoring, rapid-response bug fixes, and continuous performance tuning.

---

## 06 // A Disciplined Engineering & Growth Methodology
Our 5-phase delivery lifecycle ensures predictable, high-impact results:
- **Phase 01 // Clinical Diagnostic & Audit**: In-depth telemetry scan analyzing TTFB, Core Web Vitals, ad account ROAS, and user journey drop-offs.
- **Phase 02 // Architecture & Strategic Blueprint**: Technical specifications, system architecture diagrams, database schemas, and sprint milestones.
- **Phase 03 // Agile Engineering & Iteration**: Two-week development sprints with continuous integration, daily staging builds, and code review.
- **Phase 04 // Rigorous Quality Assurance & Load Testing**: Cross-browser validation, mobile responsiveness testing, security audits, and concurrency load tests.
- **Phase 05 // Scaled Deployment & Continuous Optimization**: Zero-downtime production launch, edge CDN configuration, and real-time conversion monitoring.

---

## 07 // Proven Outcomes: Real Business Growth with the Right Digital Marketing Strategy
At Business Doctor, a trusted digital marketing company in Delhi, we provide everything from generating quality leads to increasing online visibility which helps your business grow.

- **01. Faster Website Performance**: Business Doctor is a digital marketing company in Delhi. We design user friendly websites with faster performance. This makes the user experience better.
- **02. Stronger Online Visibility**: We provide the best seo service in delhi that improve your business's online visibility. Good online visibility will help you to get more leads and quality customers.
- **03. Better Lead Generation**: Our team helps you to get quality leads that help your business to grow and turn enquiries into real potential customers. Our goal is to help you build a strong customer base and achieve long term success.
- **04. Zero Ad Waste Guarantee**: Our goal is maximum utilisation of your advertising budget and to reduce unnecessary ad spending. We make sure that your ad reaches the right audience through smart, data driven strategies and continuous campaigns.

---

## 08 // Real Results: Documented Enterprise Case Studies
- **[FinTech SaaS Funnel Resuscitation]({$baseUrl}/case-studies/fintech-saas-funnel-resuscitation)**: Replaced a broken 7-step onboarding process with asynchronous micro-auth and Stripe vaulting.
  - *Metric Shift*: `1.2% Conversion` → `4.8% Conversion (+312% pipeline lift)`
- **[D2C Apparel Vital Infrastructure Overhaul]({$baseUrl}/case-studies/d2c-apparel-vital-infrastructure-overhaul)**: Re-platformed a slow Shopify store into a headless React PWA with Redis inventory locking.
  - *Metric Shift*: `4.6s Page Load` → `0.78s Page Load (18,500 peak transactions/min)`
- **[Multichannel Retail Marketplace Dominance]({$baseUrl}/case-studies/multichannel-retail-marketplace-dominance)**: Unified 48,000 SKUs across Amazon, Walmart, and eBay with an algorithmic dynamic repricing bot.
  - *Metric Shift*: `22% Buy Box Share` → `84% Buy Box Share (+$2.1M monthly GMV)`

---

## 09 // Tools & Technologies That Power Our Work
We deploy battle-tested enterprise technologies:
- **Languages & Frameworks**: PHP 8+, JavaScript (ES6+), React, Next.js, Node.js, Python, Tailwind CSS.
- **Databases & Caching**: PostgreSQL, MySQL, Redis Enterprise, SQLite.
- **Infrastructure & Cloud**: Cloudflare Workers & CDN, AWS, Linux Ubuntu, Docker, Nginx, Apache.
- **Growth & Marketing Tooling**: Google Ads, Meta Ads Manager, Google Analytics 4, Google Tag Manager, Semrush, Hotjar, Klaviyo.
- **Design & Prototyping**: Figma, Adobe Creative Cloud, Blender.

---

## 10 // Engineering Architecture & Digital Growth Analysis
Unsure why your website is slow, or why your ad spend isn't producing adequate ROAS? Submit your domain for a complimentary 24-hour diagnostic audit covering server latency, Core Web Vitals, and conversion funnel friction.
- [Request Free Digital Audit]({$baseUrl}/audit)

---

## 11 // Frequently Asked Questions About BusinessDoctor Services

### How do I choose the Best Digital Marketing company for My Business?
Choosing a digital marketing company will depend on your goals, budget and target audience. You want to find an company that will understand your needs and provide the correct services with a clear strategy to help your business grow.

### What digital marketing services does BusinessDoctor offer?
BusinessDoctor offers digital marketing services including SEO, social media marketing, paid advertising, content marketing and website development.

### How can digital marketing help My Business grow?
Digital marketing can help your business gain more visibility online. It can improve your website traffic, create brand awareness, lead generation and increase sales.

### How long will it take my digital marketing to deliver results?
The amount of time that it takes to deliver results will depend on your goals. Paid advertising can provide fast results with increased traffic and lead generation. SEO usually takes several months to see any real improvements.

---

## 12 // Ready to Move Your Business Beyond Limitations?
- **Schedule Discovery Consultation**: [Contact Practice Leads]({$baseUrl}/contact)
- **Complimentary Diagnostic**: [Request Free Digital Audit]({$baseUrl}/audit)
- **Review Service Disciplines**: [Explore All Practices]({$baseUrl}/services)

---
*Maintained by {$appName} Enterprise Engineering.*
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
        $lines[] = "- **XML Sitemap**: [{$baseUrl}/sitemap.xml]({$baseUrl}/sitemap.xml)";
        $lines[] = "- **Last Synchronized**: " . date('Y-m-d H:i:s T');
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";

        // 1. Institutional
        $lines[] = "## 1. Institutional & Diagnostic Documents";
        $lines[] = "";
        $lines[] = "- [Homepage Overview]({$baseUrl}/md/home.md) ([Clean URL]({$baseUrl}/.md) | [Web Page]({$baseUrl}/)): Enterprise digital practice overview.";
        $lines[] = "- [Firm Profile & Practice]({$baseUrl}/md/about.md) ([Clean URL]({$baseUrl}/about.md) | [Web Page]({$baseUrl}/about)): Digital marketing practice and engineering ethos.";
        $lines[] = "- [Services Overview Hub]({$baseUrl}/md/services.md) ([Clean URL]({$baseUrl}/services.md) | [Web Page]({$baseUrl}/services)): Multi-disciplinary capability catalog.";
        $lines[] = "- [Executive Advisory & Inquiries]({$baseUrl}/md/contact.md) ([Clean URL]({$baseUrl}/contact.md) | [Web Page]({$baseUrl}/contact)): Direct engagement and consulting channels.";
        $lines[] = "- [Digital Diagnostic Audit Framework]({$baseUrl}/md/audit.md) ([Clean URL]({$baseUrl}/audit.md) | [Web Page]({$baseUrl}/audit)): Benchmarking performance, security, and CAC.";
        $lines[] = "- [Technical Blog & Perspectives Catalog]({$baseUrl}/md/insights.md) ([Clean URL]({$baseUrl}/blog.md) | [Web Page]({$baseUrl}/blog)): Index of published technical essays.";
        $lines[] = "- [Enterprise Case Studies Catalog]({$baseUrl}/md/case-studies.md) ([Clean URL]({$baseUrl}/case-studies.md) | [Web Page]({$baseUrl}/case-studies)): Index of verified client turnarounds.";
        $lines[] = "";

        // 2. Services
        $lines[] = "## 2. Core Practice Disciplines & Services";
        $lines[] = "";
        foreach ($services as $slug => $s) {
            $name = $s['name'];
            $tag = rtrim(strip_tags($s['tagline'] ?? $s['summary']), '.');
            $webUrl = getServiceUrl($slug);
            $cleanUrl = getMarkdownUrl($webUrl);
            $repoUrl = "{$baseUrl}/md/services/{$slug}.md";
            $lines[] = "- [{$name}]({$repoUrl}) ([Clean URL]({$cleanUrl}) | [Web Page]({$webUrl})): {$tag}.";
        }
        $lines[] = "";

        // 3. Case Studies
        $lines[] = "## 3. Client Case Studies & Proven Results";
        $lines[] = "";
        if (empty($cases)) {
            $lines[] = "- No client case studies are currently published.";
        } else {
            foreach ($cases as $c) {
                $title = trim($c['title']);
                $slug = $c['slug'];
                $cleanUrl = "{$baseUrl}/case-studies/{$slug}.md";
                $repoUrl = "{$baseUrl}/md/case-studies/{$slug}.md";
                $webUrl = "{$baseUrl}/case-studies/{$slug}";
                $industry = $c['industry'] ?: ($c['client_industry'] ?: 'Enterprise');
                $baseline = $c['baseline_metric'] ?? '';
                $outcome = $c['outcome_metric'] ?? '';
                $metricText = ($baseline && $outcome) ? " ({$baseline} → {$outcome})" : ($outcome ? " ({$outcome})" : "");
                $lines[] = "- [{$title}]({$repoUrl}) ([Clean URL]({$cleanUrl}) | [Web Page]({$webUrl})): [{$industry}]{$metricText}";
            }
        }
        $lines[] = "";

        // 4. Blog Articles
        $lines[] = "## 4. Technical Blog & Articles";
        $lines[] = "";
        if (empty($insights)) {
            $lines[] = "- No editorial articles are currently published.";
        } else {
            foreach ($insights as $art) {
                $title = trim($art['title']);
                $slug = $art['slug'];
                $cleanUrl = "{$baseUrl}/blog/{$slug}.md";
                $repoUrl = "{$baseUrl}/md/insights/{$slug}.md";
                $webUrl = "{$baseUrl}/blog/{$slug}";
                $readTime = $art['reading_time'] ?? '5 min read';
                $summary = !empty($art['summary']) ? $art['summary'] : (!empty($art['excerpt']) ? $art['excerpt'] : '');
                $summary = trim(preg_replace('/\s+/', ' ', strip_tags($summary)));
                if (mb_strlen($summary) > 130) {
                    $summary = mb_substr($summary, 0, 127) . '...';
                }
                $lines[] = "- [{$title}]({$repoUrl}) ([Clean URL]({$cleanUrl}) | [Web Page]({$webUrl})): {$summary} ({$readTime})";
            }
        }
        $lines[] = "";

        $lines[] = "---";
        $lines[] = "*BusinessDoctor Centralized Markdown Distribution Network.*";
        $lines[] = "";

        return implode("\n", $lines);
    }

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
     * Return comprehensive dependency map showing:
     * Source Data -> Generator -> Output Files -> Public URLs -> Schemas
     */
    public static function getDependencyMap(): array
    {
        $baseUrl = self::getBaseUrl();
        $services = self::getActiveServices();
        $insights = self::getPublishedInsights();
        $cases = self::getPublishedCaseStudies();

        $map = [
            'services' => [],
            'blogs' => [],
            'case_studies' => [],
            'static_pages' => []
        ];

        foreach ($services as $slug => $s) {
            $webUrl = getServiceUrl($slug);
            $cleanMd = getMarkdownUrl($webUrl);
            $map['services'][$slug] = [
                'source_type' => 'database',
                'source_table' => 'services',
                'source_id' => $s['id'] ?? null,
                'name' => $s['name'],
                'public_web_url' => $webUrl,
                'clean_md_url' => $cleanMd,
                'repo_md_path' => "md/services/{$slug}.md",
                'generator' => 'SeoSyncEngine::generateServiceMarkdown',
                'manifests' => ['sitemap.xml', 'llms.txt', 'llms.md', 'md/index.md', 'md/services.md'],
                'schemas' => ['Service', 'BreadcrumbList', 'Organization'],
            ];
        }

        foreach ($insights as $b) {
            $slug = $b['slug'];
            $webUrl = getBlogUrl($slug);
            $cleanMd = getMarkdownUrl($webUrl);
            $map['blogs'][$slug] = [
                'source_type' => 'database',
                'source_table' => 'insights',
                'source_id' => $b['id'] ?? null,
                'name' => $b['title'],
                'public_web_url' => $webUrl,
                'clean_md_url' => $cleanMd,
                'repo_md_path' => "md/insights/{$slug}.md",
                'generator' => 'SeoSyncEngine::generateBlogMarkdown',
                'manifests' => ['sitemap.xml', 'llms.txt', 'llms.md', 'md/index.md', 'md/insights.md'],
                'schemas' => ['Article', 'BreadcrumbList'],
            ];
        }

        foreach ($cases as $c) {
            $slug = $c['slug'];
            $webUrl = getCaseStudyUrl($slug);
            $cleanMd = getMarkdownUrl($webUrl);
            $map['case_studies'][$slug] = [
                'source_type' => 'database',
                'source_table' => 'case_studies',
                'source_id' => $c['id'] ?? null,
                'name' => $c['title'],
                'public_web_url' => $webUrl,
                'clean_md_url' => $cleanMd,
                'repo_md_path' => "md/case-studies/{$slug}.md",
                'generator' => 'SeoSyncEngine::generateCaseStudyMarkdown',
                'manifests' => ['sitemap.xml', 'llms.txt', 'llms.md', 'md/index.md', 'md/case-studies.md'],
                'schemas' => ['CaseStudy', 'BreadcrumbList'],
            ];
        }

        foreach (self::getStaticPages() as $sp) {
            $key = $sp['file'] === 'index.php' ? 'home' : basename($sp['file'], '.php');
            $webUrl = $baseUrl . $sp['loc'];
            $cleanMd = getMarkdownUrl($webUrl);
            $map['static_pages'][$key] = [
                'source_type' => 'filesystem',
                'source_file' => $sp['file'],
                'name' => $sp['title'],
                'public_web_url' => $webUrl,
                'clean_md_url' => $cleanMd,
                'repo_md_path' => "md/{$key}.md",
                'generator' => 'SeoSyncEngine::generateStaticPageMarkdown',
                'manifests' => ['sitemap.xml', 'llms.txt', 'llms.md', 'md/index.md'],
                'schemas' => ['WebPage', 'BreadcrumbList'],
            ];
        }

        return $map;
    }

    /**
     * Re-synchronize dependencies when a specific entity is updated
     */
    public static function syncDependenciesFor(string $entityType, string $identifier): array
    {
        return self::syncAll("Targeted sync for {$entityType}: {$identifier}");
    }

    /**
     * Pre-write validation to guarantee integrity, minimum content length,
     * valid syntax, and strictly prevent stale URL leakage.
     */
    public static function validateContent(string $filePath, string $content): array
    {
        $errors = [];
        $len = strlen(trim($content));
        if ($len < 20) {
            $errors[] = "Content is empty or too short ({$len} bytes).";
        }

        // XML validation
        if (str_ends_with($filePath, '.xml')) {
            if (!str_contains($content, '<?xml') || !str_contains($content, '</urlset>')) {
                $errors[] = "Invalid XML format: missing xml declaration or </urlset>.";
            }
        }

        // Stale URL pattern check: block legacy /services/{slug} (not /md/services/) or /company/{slug}
        if (str_ends_with($filePath, '.xml') || str_ends_with($filePath, '.txt') || str_ends_with($filePath, '.md')) {
            if (preg_match('#(?<!/md)/services/[a-zA-Z0-9_-]+(?!\.md)#', $content, $m)) {
                $errors[] = "Stale URL pattern detected: {$m[0]}";
            }
            // For manifests other than llms.txt, enforce zero /company/ URLs (llms.txt uses verified canonical /company/ routes)
            if (!str_ends_with($filePath, 'llms.txt') && preg_match('#(?<!/md)/company/[a-zA-Z0-9_-]+(?!\.md)#', $content, $m)) {
                $errors[] = "Stale URL pattern detected: {$m[0]}";
            }
        }

        return $errors;
    }

    /**
     * Atomically and safely write content to a destination file with validation
     */
    public static function writeFileAtomic(string $filePath, string $content, bool $validate = true): bool
    {
        if ($validate) {
            $valErrors = self::validateContent($filePath, $content);
            if (!empty($valErrors)) {
                error_log("Pre-write validation failed for {$filePath}: " . implode('; ', $valErrors));
                return false;
            }
        }
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

        // On Windows, direct copy overwrites safely without requiring risky unlink
        if (DIRECTORY_SEPARATOR === '\\') {
            $ok = @copy($tempFile, $filePath);
            @unlink($tempFile);
            if (!$ok) {
                // Exclusive lock direct write fallback
                return file_put_contents($filePath, $content, LOCK_EX) !== false;
            }
            return true;
        }

        // Linux/POSIX atomic rename
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
        self::getActiveServices(true);
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

        // 3. llms.md has been permanently removed per specification
        if (file_exists($llmsMdPath)) {
            @unlink($llmsMdPath);
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

