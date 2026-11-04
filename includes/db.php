<?php
/**
 * BusinessDoctor Database Connection Layer - IT & Digital Services
 * Dual-Driver Support: Native MySQL with seamless Local SQLite Auto-Fallback
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

class Database
{
    private static ?PDO $instance = null;
    private static string $driver = 'unknown';

    public static function getConnection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host = DB_HOST;
        $port = (int)DB_PORT;

        // ============================================================
        // 1. PRODUCTION ENVIRONMENT: MANDATORY MYSQL CONNECTION
        //    Never silently fallback to SQLite in production!
        // ============================================================
        if (APP_ENV === 'production') {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $host,
                    $port,
                    DB_NAME,
                    DB_CHARSET
                );

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_TIMEOUT            => 5,
                ];

                if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                    $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES " . DB_CHARSET . " COLLATE utf8mb4_unicode_ci";
                }

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$driver = 'mysql';
                return self::$instance;
            } catch (PDOException $e) {
                // Log full technical trace internally; never leak credentials or DSN to public output
                error_log('[PRODUCTION CRITICAL] MySQL connection failed: ' . $e->getMessage());
                http_response_code(500);
                die('<!DOCTYPE html><html><head><title>Service Unavailable</title></head><body style="font-family:sans-serif;text-align:center;padding:5rem 2rem;"><h2>Service Temporarily Unavailable</h2><p>Our database engine is undergoing scheduled maintenance or is momentarily unreachable. Please refresh in a few moments.</p></body></html>');
            }
        }

        // ============================================================
        // 2. DEVELOPMENT / LOCAL ENVIRONMENT: MYSQL WITH SQLITE FALLBACK
        // ============================================================
        // Fast pre-check: verify if MySQL port is actively listening before PDO connect
        $mysqlReachable = false;
        $socket = @fsockopen($host, $port, $errno, $errstr, 0.05);
        if (is_resource($socket)) {
            fclose($socket);
            $mysqlReachable = true;
        }

        if ($mysqlReachable) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $host,
                    $port,
                    DB_NAME,
                    DB_CHARSET
                );

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_TIMEOUT            => 2,
                ];

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$driver = 'mysql';
                return self::$instance;
            } catch (PDOException $e) {
                error_log('Local MySQL unavailable, engaging development SQLite storage: ' . $e->getMessage());
            }
        }

        // Local SQLite Resilient Driver (Development Only)
        try {
            $sqlitePath = DB_SQLITE_PATH;
            $dbDir = dirname($sqlitePath);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }

            $firstInit = !file_exists($sqlitePath) || filesize($sqlitePath) === 0;

            self::$instance = new PDO('sqlite:' . $sqlitePath, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            self::$driver = 'sqlite';

            if ($firstInit) {
                self::initializeSQLiteTables(self::$instance);
            }

            return self::$instance;
        } catch (PDOException $e) {
            die('Fatal Database Failure: Unable to establish data persistence layer. ' . htmlspecialchars($e->getMessage()));
        }
    }

    public static function getDriver(): string
    {
        return self::$driver;
    }

    private static function initializeSQLiteTables(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                email TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                full_name TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'senior_consultant',
                is_active INTEGER NOT NULL DEFAULT 1,
                last_login TEXT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS diagnostic_requests (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                reference_no TEXT NOT NULL UNIQUE,
                company_name TEXT NOT NULL,
                contact_name TEXT NOT NULL,
                work_email TEXT NOT NULL,
                phone TEXT NULL,
                website_url TEXT NULL,
                revenue_bracket TEXT NOT NULL,
                primary_bottleneck TEXT NOT NULL,
                operating_model TEXT NOT NULL,
                health_score INTEGER NOT NULL DEFAULT 0,
                diagnostic_summary TEXT NULL,
                status TEXT NOT NULL DEFAULT 'pending',
                internal_notes TEXT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS contact_inquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                full_name TEXT NOT NULL,
                email TEXT NOT NULL,
                phone TEXT NULL,
                organization TEXT NULL,
                service_interest TEXT NOT NULL,
                message TEXT NOT NULL,
                status TEXT NOT NULL DEFAULT 'new',
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS newsletter_subscribers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                source_page TEXT DEFAULT 'homepage_footer',
                ip_address TEXT NULL,
                is_active INTEGER NOT NULL DEFAULT 1,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS case_studies (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                title TEXT NOT NULL,
                client_industry TEXT NOT NULL,
                practice_area TEXT NOT NULL,
                baseline_metric TEXT NOT NULL,
                outcome_metric TEXT NOT NULL,
                metric_label TEXT NOT NULL,
                challenge TEXT NOT NULL,
                prescription TEXT NOT NULL,
                result_description TEXT NOT NULL,
                quote_text TEXT NULL,
                quote_author TEXT NULL,
                quote_title TEXT NULL,
                is_featured INTEGER NOT NULL DEFAULT 0,
                sort_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS insights (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                category TEXT NOT NULL,
                title TEXT NOT NULL,
                reading_time TEXT NOT NULL DEFAULT '6 min read',
                summary TEXT NOT NULL,
                content TEXT NOT NULL,
                author_name TEXT NOT NULL,
                author_title TEXT NOT NULL,
                is_published INTEGER NOT NULL DEFAULT 1,
                published_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS login_rate_limits (
                ip_address TEXT PRIMARY KEY,
                attempts INTEGER NOT NULL DEFAULT 1,
                last_attempt TEXT NOT NULL,
                locked_until TEXT NULL
            );
        ");

        // Seed Default Admin: username "admin", password "Admin@BusinessDoctor2026"
        $defaultPassword = password_hash('Admin@BusinessDoctor2026', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("
            INSERT OR IGNORE INTO admin_users (username, email, password_hash, full_name, role)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            'admin',
            'leadership@businessdoctor.com',
            $defaultPassword,
            'Managing Partner & Solutions Lead',
            'managing_partner'
        ]);

        self::seedCaseStudies($pdo);
        self::seedInsights($pdo);
    }

    private static function seedCaseStudies(PDO $pdo): void
    {
        $cases = [
            [
                'slug' => 'fintech-saas-funnel-resuscitation',
                'title' => 'Scaling B2B Acquisition: 240% Demo Booking Growth for PayGuard',
                'client_industry' => 'Enterprise FinTech SaaS',
                'practice_area' => 'Web Development & Performance Marketing',
                'baseline_metric' => '$840 CAC / 1.1% Demo Conv',
                'outcome_metric' => '$290 CAC / 4.6% Demo Conv',
                'metric_label' => 'Qualified Pipeline Growth',
                'challenge' => 'PayGuard was burning $85,000 monthly across Google Ads and LinkedIn without generating qualified enterprise demos. Their website was slow, messaging was unclear, and 88% of inbound traffic dropped off before completing the demo form.',
                'prescription' => 'BusinessDoctor redesigned and rebuilt the core web application using custom PHP/HTML5, built an interactive product demo widget, and restructured their Google Search and LinkedIn paid media campaigns around high-intent keywords.',
                'result_description' => 'Within 90 days, demo booking conversions climbed by 318% while customer acquisition costs fell by 65%. Annual Recurring Revenue (ARR) grew by $3.4M in two quarters.',
                'quote_text' => 'BusinessDoctor solved what three previous agencies couldn\'t. Having software engineers and performance marketers working on the exact same project was a game changer.',
                'quote_author' => 'Marcus Vance',
                'quote_title' => 'Chief Revenue Officer, PayGuard Technologies',
                'is_featured' => 1,
                'sort_order' => 1
            ],
            [
                'slug' => 'd2c-apparel-vital-infrastructure-overhaul',
                'title' => 'Custom E-Commerce Architecture: Sub-Second Load & 162% Revenue Surge for AURA Atelier',
                'client_industry' => 'Luxury D2C & Apparel',
                'practice_area' => 'Web Development & UI/UX Design',
                'baseline_metric' => '4.8s Page Load / 1.4% Conv',
                'outcome_metric' => '0.68s Page Load / 3.9% Conv',
                'metric_label' => 'Net Conversion Surge',
                'challenge' => 'AURA Atelier suffered heavy cart abandonment on mobile devices due to an outdated, plugin-heavy theme with 4.8-second load times and broken mobile layouts.',
                'prescription' => 'We engineered a bespoke, lightweight PHP/HTML5 storefront with dynamic image compression, instant AJAX cart transitions, and a streamlined 1-page checkout flow.',
                'result_description' => 'Mobile page load dropped to 680 milliseconds. Mobile checkout abandonment declined by 52%, resulting in an immediate $1.85M revenue lift within 60 days of launch.',
                'quote_text' => 'The technical speed and clean UI transformed our business. Our store feels instantaneous, and sales have increased dramatically.',
                'quote_author' => 'Elena Rostova',
                'quote_title' => 'Founder & Creative Director, AURA Atelier',
                'is_featured' => 1,
                'sort_order' => 2
            ],
            [
                'slug' => 'multichannel-retail-marketplace-dominance',
                'title' => 'Marketplace Management & ROAS Scaling: 4.6x Ad Return for Apex Industrial',
                'client_industry' => 'Industrial Equipment & B2B Retail',
                'practice_area' => 'E-Commerce & Marketplace Management',
                'baseline_metric' => '1.8x ROAS / 34% Buy Box Loss',
                'outcome_metric' => '4.6x ROAS / 94% Buy Box Control',
                'metric_label' => 'Marketplace Revenue Scale',
                'challenge' => 'Apex Industrial was losing Buy Box share on Amazon and Flipkart due to unauthorized resellers, poor product titles, and unoptimized ad campaigns.',
                'prescription' => 'BusinessDoctor implemented Brand Registry brand gating, redesigned catalog listings with rich A+ lifestyle modules, and restructured Sponsored Brands and Sponsored Products campaigns.',
                'result_description' => 'Buy Box possession stabilized at 94%. Blended advertising return climbed from 1.8x to 4.6x while net marketplace operating profit margin expanded by 11.2 percentage points.',
                'quote_text' => 'BusinessDoctor gave us total command over Amazon and Flipkart. Our listings look world-class, and our ad spend is driving high-margin volume.',
                'quote_author' => 'David Thorne',
                'quote_title' => 'VP of Omnichannel Sales, Apex Industrial',
                'is_featured' => 1,
                'sort_order' => 3
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT OR REPLACE INTO case_studies 
            (slug, title, client_industry, practice_area, baseline_metric, outcome_metric, metric_label, challenge, prescription, result_description, quote_text, quote_author, quote_title, is_featured, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($cases as $c) {
            $stmt->execute([
                $c['slug'], $c['title'], $c['client_industry'], $c['practice_area'],
                $c['baseline_metric'], $c['outcome_metric'], $c['metric_label'],
                $c['challenge'], $c['prescription'], $c['result_description'],
                $c['quote_text'], $c['quote_author'], $c['quote_title'],
                $c['is_featured'], $c['sort_order']
            ]);
        }
    }

    private static function seedInsights(PDO $pdo): void
    {
        $insights = [
            [
                'slug' => 'the-symptom-trap-why-ad-spend-fails-broken-funnels',
                'category' => 'Web & Digital Strategy',
                'title' => 'Why Increasing Ad Spend on a Slow, Broken Website Drains Your Marketing Budget',
                'reading_time' => '7 min read',
                'summary' => 'When customer acquisition costs rise, marketing agencies often suggest doubling the ad budget. Learn why auditing web performance, mobile speed, and user experience must come first.',
                'content' => 'In digital commerce, pouring paid traffic into a slow, poorly designed website is like trying to fill a bucket with holes in the bottom. 

If your conversion rate is 1.2% because your website takes 4 seconds to load and your mobile checkout is confusing, doubling ad spend does not double revenue—it simply burns your budget twice as fast.

High-growth businesses begin with technical optimization: achieving 100% Core Web Vitals, removing render-blocking JavaScript, streamlining checkout flows, and aligning value propositions. Once the technical foundation is fast and frictionless, ad spend scales profitably.',
                'author_name' => 'Dr. Harrison Croft',
                'author_title' => 'Managing Partner & Chief Solutions Officer'
            ],
            [
                'slug' => 'core-web-vitals-and-enterprise-valuation',
                'category' => 'Web Development',
                'title' => 'The Speed Advantage: How Sub-Second Load Times Drive Search Rankings and Sales',
                'reading_time' => '5 min read',
                'summary' => 'Page speed is a major ranking factor for Google and a critical driver of user conversions. An engineering breakdown of how clean architecture delivers sub-second load times.',
                'content' => 'Speed is not a cosmetic feature; it is the fundamental benchmark of web engineering. Google search algorithms prioritize fast, responsive pages that pass Core Web Vitals metrics.

Yet many enterprise sites are weighed down by bloated themes, unmanaged tracking scripts, and heavy frameworks. When a website requires 4.5 seconds to load on mobile, over 40% of visitors abandon the page before interacting.

Building clean, semantic, server-rendered web applications with optimized database caching is one of the most cost-effective investments a business can make.',
                'author_name' => 'Kirsten Chen',
                'author_title' => 'VP of Engineering'
            ],
            [
                'slug' => 'brand-architecture-as-risk-mitigation',
                'category' => 'UI/UX & Branding',
                'title' => 'Modern UI/UX Design as a Revenue Multiplier: Why Premium Design Eliminates Price Resistance',
                'reading_time' => '8 min read',
                'summary' => 'Commoditized businesses compete on price and face low margins. How professional UI/UX design and consistent visual identity elevate your brand into an industry leader.',
                'content' => 'Without distinctive visual authority and an intuitive digital experience, prospective clients compare you solely on price.

Modern UI/UX design transforms your digital presence from a standard website into a trusted enterprise platform. When your typography, user journey, and digital collateral exude quality and attention to detail, client confidence increases and conversion rates rise.',
                'author_name' => 'Julian Montgomery',
                'author_title' => 'Head of UI/UX & Brand Design'
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT OR REPLACE INTO insights 
            (slug, category, title, reading_time, summary, content, author_name, author_title, published_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, datetime('now'))
        ");

        foreach ($insights as $ins) {
            $stmt->execute([
                $ins['slug'], $ins['category'], $ins['title'], $ins['reading_time'],
                $ins['summary'], $ins['content'], $ins['author_name'], $ins['author_title']
            ]);
        }
    }
}
