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
        $canonicalUrl = $baseUrl . '/case-study-detail.php?slug=' . urlencode($slug);
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
        $consultationUrl = appUrl('contact.php?service=' . urlencode($serviceName));
        $canonicalUrl = $baseUrl . '/services/' . urlencode($slug);
        $cleanMdUrl = $baseUrl . '/services/' . urlencode($slug) . '.md';
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
# Engineering Technology. Accelerating Scalable Growth.

> We founded BusinessDoctor to provide modern businesses with a reliable, all-in-one IT and digital growth partner. We eliminate the friction of managing disconnected developers, ad agencies, and designers by bringing them together under one disciplined engineering practice.

## Firm Information & Digital Resources
- **Canonical Web URL**: [{$baseUrl}/about.php]({$baseUrl}/about.php)
- **Clean Markdown URL**: [{$baseUrl}/about.php.md]({$baseUrl}/about.php.md)
- **Central Markdown URL**: [{$baseUrl}/md/about.md]({$baseUrl}/md/about.md)
- **Master Markdown Index**: [{$baseUrl}/md]({$baseUrl}/md)
- **Corporate Legal Entity**: {$legalName}
- **Headquarters**: {$hq}
- **Advisory Contact**: [{$email}](mailto:{$email}) | Phone: {$phone}

---

## 01 // The BusinessDoctor Philosophy: Why We Call Ourselves BusinessDoctor
A clinical engineering approach to diagnosing digital friction, eliminating architecture bottlenecks, and prescribing sustainable enterprise growth.

### 01.1 The Symptoms of Digital Friction (Diagnostic Identification)
Every growing enterprise encounters digital friction: an outdated website that repels prospective clients, slow server response times that kill search engine rankings, paid advertising campaigns that fail to convert, or marketplace listings that lose sales to competitors.
- **Conversion Drop-off**: Fragmented checkout flows, unintuitive information architecture, and unoptimized landing pages that drain marketing budgets.
- **Latency Bottlenecks**: Monolithic bloat, uncompressed media assets, unindexed databases, and poor Time to First Byte (TTFB).
- **Ad Spend Waste**: High Customer Acquisition Cost (CAC) driven by disconnected messaging, untracked conversion APIs, and broken sales funnels.

### 01.2 End-to-End Technical Care (The Clinical Diagnosis)
Just as any complex system needs expert trouble-shooters to diagnose root technical failures and prescribe robust engineering solutions, **BusinessDoctor provides end-to-end technical care for your digital presence**.
- **Root-Cause Diagnosis**: We don't mask symptoms with superficial redesigns. We inspect database queries, server logs, ad account configurations, and UX funnels.
- **Systemic Prescription**: Custom software development, targeted search engine optimization, high-converting UI/UX design, and multi-channel marketplace scaling.

### 01.3 Precision Engineering & Scale (Measurable Execution)
We don't sell superficial fixes or bloated templates. Our software engineers, performance marketers, and UI/UX designers analyze your technical infrastructure, rebuild broken user journeys, build lightning-fast web applications, and scale customer acquisition with data-backed precision.
- **Custom PHP 8+ Architecture**: Zero bloated frameworks or unmaintained third-party plugins. Clean, modular procedural and object-oriented architectures.
- **Sub-Second Load Times**: Edge caching via Cloudflare CDN, WebP/AVIF asset optimization, and lean relational database queries.
- **Data-Led Acquisition**: Full-funnel tracking with Google Analytics 4, Meta Conversions API (CAPI), and granular server-side attribution.

---

## 02 // Operating Standards: Four Commitments We Stand By
Non-negotiable architectural benchmarks and accountability standards engineered into every client partnership.

### Commitment 1: Clean, Framework-Free Code
- Sub-second server response times (TTFB < 200ms) with lightweight PHP and vanilla JavaScript.
- Zero bloated frameworks, fragile CMS plugins, or unnecessary dependencies that introduce security vulnerabilities.
- Maintainable, well-documented codebases built for enterprise longevity and multi-developer handoff.

### Commitment 2: Measurable Commercial ROI
- Every engineering sprint and marketing campaign is directly tied to measurable commercial outcomes.
- We report transparently on conversion rates, revenue pipeline lift, customer acquisition cost (CAC), and Core Web Vitals.
- No vanity metrics. No opaque agency reporting.

### Commitment 3: Integrated End-to-End Delivery
- Complete harmony between software engineering, brand design, paid advertising, and marketplace management.
- Eliminate inter-agency finger-pointing: one senior team owns full responsibility from architecture to conversion.
- Cross-functional agile delivery teams led by dedicated principal technical directors.

### Commitment 4: Long-Term Partnership & Support
- Continuous post-launch monitoring, security patching, and proactive performance tuning.
- 99.9% uptime architecture with automated database backups and edge CDN failover.
- Guaranteed 2-hour response Service Level Agreement (SLA) for enterprise-critical support requests.

---

## 03 // Mission & Strategic Vision: Driven by Purpose. Defined by Results.

### Our Mission
To dismantle digital inefficiency and engineer high-velocity digital architectures that deliver undeniable commercial results.
- **Precision Diagnostics**: Uncompromising technical audits that uncover root-cause bottlenecks before prescribing code or marketing solutions.
- **Disciplined Execution**: Senior-led agile sprints adhering to zero-defect standards, clean code principles, and rigorous load testing.
- **Compounding Value**: Building durable digital assets that lower customer acquisition costs and drive multi-year enterprise value.

### Our Strategic Vision
To be the definitive technology partner for organizations that refuse to accept mediocrity in their digital infrastructure.
- **Global Standards**: Deploying tier-one enterprise engineering, security, and design methodologies to high-growth organizations worldwide.
- **Autonomous Scaling**: Building robust, self-healing platforms capable of handling 100x traffic surges without performance degradation.
- **Sustainable Tech**: Lean software design that minimizes compute overhead, eliminates technical debt, and maximizes operational margins.

---

## 04 // Leadership & Technology Directors
Our practice is directed by senior technology architects and growth strategists with extensive enterprise experience:

### Dr. Alistair Croft — Chief Technology Officer & Principal Architect
Specializing in distributed systems architecture, database optimization, sub-second web performance, and enterprise security posture. Over 15 years leading engineering teams across FinTech, SaaS, and high-concurrency transactional systems.

### Sarah Chen — VP of Growth Marketing & Conversion Science
Pioneering full-funnel customer acquisition models, algorithmic search optimization, and multi-channel attribution frameworks. Oversees multi-million dollar annual ad spend across Google Ads, Meta Ads Manager, and programmatic networks.

### David Montgomery — Director of Brand Architecture & Experience Design
Championing conversion-centered interface design, design systems, and cohesive enterprise visual narratives. Over a decade engineering interactive web experiences and marketplace storefront transformations.

---

## 05 // Elevate Your Digital Capabilities
Schedule an introductory discovery call with our tech leads to discuss your web development, digital marketing, or branding requirements.
- **Direct Consultation**: [Schedule a Project Consultation]({$baseUrl}/contact.php)
- **Complimentary Diagnostic**: [Request Free Digital Audit]({$baseUrl}/audit.php)
- **Practice Hub**: [Explore IT Services & Practice Areas]({$baseUrl}/services.php)

---
*Maintained by {$appName} Corporate Communications.*
MD;

            case 'contact':
                return <<<MD
# Let’s Build Something Exceptional Together

> Whether you need a custom high-performance web application, a full-funnel digital marketing campaign, an Amazon storefront overhaul, or ongoing cloud infrastructure support, our senior technical teams are ready to collaborate.

## Engagement Information & Digital Resources
- **Canonical Web URL**: [{$baseUrl}/contact.php]({$baseUrl}/contact.php)
- **Clean Markdown URL**: [{$baseUrl}/contact.php.md]({$baseUrl}/contact.php.md)
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
- **Technical Support Desk**: [support@businessdoctor.com](mailto:support@businessdoctor.com)
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
- **Canonical Web URL**: [{$baseUrl}/audit.php]({$baseUrl}/audit.php)
- **Clean Markdown URL**: [{$baseUrl}/audit.php.md]({$baseUrl}/audit.php.md)
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
- **Submit Audit Request**: [Request Free Digital Audit Online]({$baseUrl}/audit.php)
- **Schedule Live Discovery Call**: [Contact Tech Leads]({$baseUrl}/contact.php)
- **Explore All IT Disciplines**: [Services Overview]({$baseUrl}/services.php)

---
*Maintained by {$appName} Diagnostic Practice.*
MD;

            case 'services':
                $services = self::getActiveServices();
                $sLines = [];
                $sLines[] = "# Full-Stack Technology & Digital Growth Disciplines";
                $sLines[] = "";
                $sLines[] = "> We engineer high-performance web software, manage profitable paid acquisition portfolios, and build distinctive brand architectures. Six specialized disciplines operating under one accountable standard.";
                $sLines[] = "";
                $sLines[] = "## Hub Information & Digital Resources";
                $sLines[] = "- **Canonical Web URL**: [{$baseUrl}/services.php]({$baseUrl}/services.php)";
                $sLines[] = "- **Clean Markdown URL**: [{$baseUrl}/services.php.md]({$baseUrl}/services.php.md)";
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
                    $webUrl = "{$baseUrl}/services/{$slug}";
                    $cleanMdUrl = "{$baseUrl}/services/{$slug}.md";
                    $centralMdUrl = "{$baseUrl}/md/services/{$slug}.md";
                    $consultUrl = "{$baseUrl}/contact.php?service=" . urlencode($name);

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
                $sLines[] = "- [Schedule Project Consultation]({$baseUrl}/contact.php)";
                $sLines[] = "- [Request Free Digital Audit]({$baseUrl}/audit.php)";
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
                $iLines[] = "- **Canonical Web URL**: [{$baseUrl}/insights.php]({$baseUrl}/insights.php)";
                $iLines[] = "- **Clean Markdown URL**: [{$baseUrl}/insights.php.md]({$baseUrl}/insights.php.md)";
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
                        $webUrl = "{$baseUrl}/insight-detail.php?slug={$slug}";
                        $cleanMdUrl = "{$baseUrl}/insights/{$slug}.md";
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
                $cLines[] = "- **Canonical Web URL**: [{$baseUrl}/case-studies.php]({$baseUrl}/case-studies.php)";
                $cLines[] = "- **Clean Markdown URL**: [{$baseUrl}/case-studies.php.md]({$baseUrl}/case-studies.php.md)";
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
                        $webUrl = "{$baseUrl}/case-study-detail.php?slug={$slug}";
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
- **AI Agent Discovery**: [{$baseUrl}/llms.txt]({$baseUrl}/llms.txt) | [{$baseUrl}/llms.md]({$baseUrl}/llms.md)
- **XML Sitemap**: [{$baseUrl}/sitemap.xml]({$baseUrl}/sitemap.xml)
- **Primary Contact**: [{$email}](mailto:{$email}) | Phone: {$phone}
- **Headquarters**: {$hq}

---

## 01 // Core Architectural Pillars
We engineer digital solutions across four primary pillars to ensure scalable, friction-free business execution:
- **01 Custom Web & Software Engineering**: Sub-second load times, modular architecture, enterprise security standards, clean PHP 8+ and vanilla JS.
- **02 Performance Marketing & SEO**: Conversion-focused paid campaigns across Google Ads & Meta, lower Customer Acquisition Cost (CAC), and sustainable organic rankings.
- **03 E-Commerce & Marketplaces**: Amazon, Flipkart, and Shopify scale with Buy Box dominance, multi-channel feed automation, and review velocity.
- **04 Cloud Infrastructure & IT**: High availability, proactive server monitoring, automated daily backups, and secure DevOps automation.

---

## 02 // Performance Metric HUD
- **99.9% Uptime SLA**: Fault-tolerant server configurations with automated edge failover and continuous health monitoring.
- **< 1.2s Core Web Vitals**: Optimized Largest Contentful Paint (LCP) and zero Cumulative Layout Shift (CLS) on mobile devices.
- **3.8x Average ROAS Uplift**: Full-funnel tracking with GA4, Meta Conversions API (CAPI), and high-converting landing pages.
- **2-Hour Enterprise Response SLA**: Direct access to senior technology leads for rapid diagnostic troubleshooting and support.

---

## 03 // Engineered Capabilities Built for Enterprise Scale
We provide six specialized disciplines operating under one accountable standard:
1. **[Web & Custom Software Development]({$baseUrl}/services/web-software-development)**: High-performance business websites, custom web applications, client portals, and secure database solutions.
2. **[Digital Marketing & Performance Ads]({$baseUrl}/services/digital-marketing-seo)**: Full-funnel digital marketing, Google Ads, Meta Ads Manager, technical SEO, and conversion rate optimization (CRO).
3. **[UI/UX Design & Brand Identity]({$baseUrl}/services/ui-ux-branding)**: Conversion-centered interface design, complete brand style systems, wireframes, and design systems.
4. **[E-Commerce & Marketplaces]({$baseUrl}/services/ecommerce-marketplaces)**: Amazon & Flipkart store management, Buy Box defense, A+ content, and automated inventory feeds.
5. **[Creative Production & Video Marketing]({$baseUrl}/services/creative-video-production)**: Commercial product photography, brand narrative films, 3D motion graphics, and social video ads.
6. **[Cloud Solutions & IT Consulting]({$baseUrl}/services/cloud-it-consulting)**: Cloud migration, AWS/Cloudflare setup, server security hardening, and ongoing maintenance.

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

## 07 // Built on Engineering Integrity & Measurable Accountability
We hold our practice to rigorous operational commitments:
- Guaranteed code quality and security standards (OWASP compliance).
- Complete data privacy with strict confidentiality agreements (NDA).
- Transparent fixed pricing with zero hidden surcharges or surprise billing.

---

## 08 // Real Results: Documented Enterprise Case Studies
- **[FinTech SaaS Funnel Resuscitation]({$baseUrl}/case-study-detail.php?slug=fintech-saas-funnel-resuscitation)**: Replaced a broken 7-step onboarding process with asynchronous micro-auth and Stripe vaulting.
  - *Metric Shift*: `1.2% Conversion` → `4.8% Conversion (+312% pipeline lift)`
- **[D2C Apparel Vital Infrastructure Overhaul]({$baseUrl}/case-study-detail.php?slug=d2c-apparel-vital-infrastructure-overhaul)**: Re-platformed a slow Shopify store into a headless React PWA with Redis inventory locking.
  - *Metric Shift*: `4.6s Page Load` → `0.78s Page Load (18,500 peak transactions/min)`
- **[Multichannel Retail Marketplace Dominance]({$baseUrl}/case-study-detail.php?slug=multichannel-retail-marketplace-dominance)**: Unified 48,000 SKUs across Amazon, Walmart, and eBay with an algorithmic dynamic repricing bot.
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
- [Request Free Digital Audit]({$baseUrl}/audit.php)

---

## 11 // Frequently Asked Questions About BusinessDoctor Advisory & Engineering

### What core services does BusinessDoctor provide?
BusinessDoctor delivers enterprise full-stack software development, performance digital marketing and SEO, UI/UX architecture, e-commerce marketplace scaling, commercial creative video production, and cloud IT infrastructure consulting.

### How does BusinessDoctor conduct digital architecture audits?
Our senior technical architects perform deep diagnostic audits across four critical vectors: software engineering latency, digital ad spend ROI and CAC leakage, enterprise systems resilience, and brand identity conversion trust.

### Can BusinessDoctor resuscitate failing enterprise web projects?
Yes. We specialize in turn-around engineering for distressed codebases, slow legacy web applications, broken checkout funnels, and high-traffic transactional platforms facing scalability bottlenecks.

### How do your engagement models and pricing work?
We offer flexible engagement models tailored to client needs: fixed-scope sprint deliverables with defined milestones and pricing, ongoing dedicated engineering/marketing retainers, and specialized technical diagnostic audits.

### Where does BusinessDoctor operate?
BusinessDoctor operates globally with distributed engineering leadership and principal consultants headquartered in our Noida, India innovation corridor.

---

## 12 // Ready to Move Your Business Beyond Limitations?
- **Schedule Discovery Consultation**: [Contact Practice Leads]({$baseUrl}/contact.php)
- **Complimentary Diagnostic**: [Request Free Digital Audit]({$baseUrl}/audit.php)
- **Review Service Disciplines**: [Explore All Practices]({$baseUrl}/services.php)

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
        $lines[] = "- **Comprehensive LLM Context**: [{$baseUrl}/llms.md]({$baseUrl}/llms.md)";
        $lines[] = "- **XML Sitemap**: [{$baseUrl}/sitemap.xml]({$baseUrl}/sitemap.xml)";
        $lines[] = "- **Last Synchronized**: " . date('Y-m-d H:i:s T');
        $lines[] = "";
        $lines[] = "---";
        $lines[] = "";

        // 1. Institutional
        $lines[] = "## 1. Institutional & Diagnostic Documents";
        $lines[] = "";
        $lines[] = "- [Homepage Overview]({$baseUrl}/md/home.md) ([Clean URL]({$baseUrl}/.md) | [Web Page]({$baseUrl}/)): Enterprise digital practice overview.";
        $lines[] = "- [Firm Profile & Leadership]({$baseUrl}/md/about.md) ([Clean URL]({$baseUrl}/about.php.md) | [Web Page]({$baseUrl}/about.php)): Engineering ethos and leadership profile.";
        $lines[] = "- [Services Overview Hub]({$baseUrl}/md/services.md) ([Clean URL]({$baseUrl}/services.php.md) | [Web Page]({$baseUrl}/services.php)): Multi-disciplinary capability catalog.";
        $lines[] = "- [Executive Advisory & Inquiries]({$baseUrl}/md/contact.md) ([Clean URL]({$baseUrl}/contact.php.md) | [Web Page]({$baseUrl}/contact.php)): Direct engagement and consulting channels.";
        $lines[] = "- [Digital Diagnostic Audit Framework]({$baseUrl}/md/audit.md) ([Clean URL]({$baseUrl}/audit.php.md) | [Web Page]({$baseUrl}/audit.php)): Benchmarking performance, security, and CAC.";
        $lines[] = "- [Technical Blog & Perspectives Catalog]({$baseUrl}/md/insights.md) ([Clean URL]({$baseUrl}/insights.php.md) | [Web Page]({$baseUrl}/insights.php)): Index of published technical essays.";
        $lines[] = "- [Enterprise Case Studies Catalog]({$baseUrl}/md/case-studies.md) ([Clean URL]({$baseUrl}/case-studies.php.md) | [Web Page]({$baseUrl}/case-studies.php)): Index of verified client turnarounds.";
        $lines[] = "";

        // 2. Services
        $lines[] = "## 2. Core Practice Disciplines & Services";
        $lines[] = "";
        foreach ($services as $slug => $s) {
            $name = $s['name'];
            $tag = rtrim(strip_tags($s['tagline'] ?? $s['summary']), '.');
            $cleanUrl = "{$baseUrl}/services/{$slug}.md";
            $repoUrl = "{$baseUrl}/md/services/{$slug}.md";
            $webUrl = "{$baseUrl}/services/{$slug}";
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
                $webUrl = "{$baseUrl}/case-study-detail.php?slug={$slug}";
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
                $cleanUrl = "{$baseUrl}/insights/{$slug}.md";
                $repoUrl = "{$baseUrl}/md/insights/{$slug}.md";
                $webUrl = "{$baseUrl}/insight-detail.php?slug={$slug}";
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

