<?php
/**
 * BusinessDoctor Helper Functions & IT Practice Taxonomy
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/**
 * Escape HTML output for XSS protection
 */
function e(?string $string): string
{
    return htmlspecialchars((string)$string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Sanitize rich article HTML to prevent XSS while allowing safe formatting, tables, images, and embeds
 */
function sanitizeArticleHtml(?string $html): string
{
    if (empty($html)) {
        return '';
    }
    
    // Strip malicious executable tags
    $disallowedTags = 'script|style|iframe|object|embed|applet|form|input|button|select|textarea|frameset|frame|meta|link';
    $clean = preg_replace('#<(' . $disallowedTags . ')[^>]*>.*?</\1>#is', '', $html);
    $clean = preg_replace('#<(' . $disallowedTags . ')[^>]*>#is', '', $clean);
    
    // Strip inline event attributes like onclick, onerror, onload, etc.
    $clean = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $clean);
    
    // Neutralize dangerous javascript: and vbscript: URIs
    $clean = preg_replace('/href\s*=\s*["\']\s*(?:javascript|vbscript):[^"\']*["\']/i', 'href="#"', $clean);
    $clean = preg_replace('/src\s*=\s*["\']\s*(?:javascript|vbscript):[^"\']*["\']/i', 'src=""', $clean);

    return trim($clean);
}

/**
 * Sanitize external URL to prevent javascript: and data: XSS injections
 */
function safeUrl(?string $url): string
{
    if (empty($url)) {
        return '#';
    }
    $url = trim($url);
    if (preg_match('/^https?:\/\//i', $url)) {
        return $url;
    }
    if (!preg_match('/^[a-z0-9+.-]+:/i', $url)) {
        return 'https://' . $url;
    }
    return '#';
}

/**
 * Generate CSRF Token
 */
function getCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF Token
 */
function verifyCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if the current request script matches the given page name for navigation styling
 */
function isActivePage(string ...$pages): string
{
    $current = basename($_SERVER['SCRIPT_NAME'] ?? '');
    foreach ($pages as $p) {
        if ($current === $p) {
            return 'active';
        }
    }

    // Also check REQUEST_URI for clean routes such as /services or /services/{slug}
    $reqUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($reqUri !== null && (str_starts_with($reqUri, '/services') || $reqUri === '/services')) {
        if (in_array('services.php', $pages, true) || in_array('service-detail.php', $pages, true)) {
            return 'active';
        }
    }

    return '';
}

/**
 * Return clean SEO-friendly URL for a service
 */
function getServiceUrl(string $slug): string
{
    return '/services/' . rawurlencode($slug);
}

/**
 * Format timestamp to executive presentation format
 */
function formatExecutiveDate(string $timestamp): string
{
    try {
        $dt = new DateTime($timestamp);
        return $dt->format('M d, Y');
    } catch (Exception $e) {
        return $timestamp;
    }
}

/**
 * Validate that an IP address is a safe, publicly routable Internet IP.
 * Strictly blocks private (RFC 1918), loopback (127.0.0.0/8), link-local cloud metadata
 * (169.254.0.0/16), multicast, carrier-grade NAT, and reserved networks.
 */
function isPublicInternetIp(string $ip): bool
{
    // Filter out standard private and reserved ranges
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return false;
    }

    // Additional strict IPv4 boundaries
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $octets = array_map('intval', explode('.', $ip));
        if (count($octets) !== 4) return false;

        if ($octets[0] === 127) return false; // 127.0.0.0/8
        if ($octets[0] === 0) return false;   // 0.0.0.0/8
        if ($octets[0] === 10) return false;  // 10.0.0.0/8
        if ($octets[0] === 172 && $octets[1] >= 16 && $octets[1] <= 31) return false; // 172.16.0.0/12
        if ($octets[0] === 192 && $octets[1] === 168) return false; // 192.168.0.0/16
        if ($octets[0] === 169 && $octets[1] === 254) return false; // 169.254.0.0/16 (AWS/GCP/Azure metadata)
        if ($octets[0] === 100 && $octets[1] >= 64 && $octets[1] <= 127) return false; // 100.64.0.0/10
        if ($octets[0] === 192 && $octets[1] === 0 && $octets[2] === 0) return false; // 192.0.0.0/24
        if ($octets[0] === 198 && ($octets[1] === 18 || $octets[1] === 19)) return false; // 198.18.0.0/15
        if ($octets[0] >= 224) return false; // Multicast & Reserved
        if ($ip === '255.255.255.255') return false;
    }

    // Additional strict IPv6 boundaries
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $lower = strtolower($ip);
        if ($lower === '::1' || str_starts_with($lower, 'fe80:') || str_starts_with($lower, 'fc00:') || str_starts_with($lower, 'fd00:')) {
            return false;
        }
    }

    return true;
}

/**
 * Check Login Rate Limiting (Brute-Force Protection)
 * Max 5 failed attempts per 15-minute window per IP
 */
function checkLoginRateLimit(string $ip): array
{
    try {
        $pdo = Database::getConnection();
        // Ensure rate limits table exists
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS login_rate_limits (
                ip_address VARCHAR(45) NOT NULL PRIMARY KEY,
                attempts INT NOT NULL DEFAULT 1,
                last_attempt DATETIME NOT NULL,
                locked_until DATETIME NULL
            )
        ");

        $stmt = $pdo->prepare("SELECT * FROM login_rate_limits WHERE ip_address = ?");
        $stmt->execute([$ip]);
        $row = $stmt->fetch();

        if ($row && !empty($row['locked_until'])) {
            $lockExpiry = strtotime($row['locked_until']);
            if ($lockExpiry > time()) {
                $waitMins = max(1, (int)ceil(($lockExpiry - time()) / 60));
                return [
                    'allowed' => false,
                    'message' => "Too many failed sign-in attempts. Security lock active. Please retry in {$waitMins} minute(s)."
                ];
            }
        }
    } catch (Exception $e) {
        error_log('Rate limit check error: ' . $e->getMessage());
    }

    return ['allowed' => true];
}

/**
 * Record a failed login attempt for the given IP
 */
function recordFailedLogin(string $ip): void
{
    try {
        $pdo = Database::getConnection();
        $now = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("SELECT * FROM login_rate_limits WHERE ip_address = ?");
        $stmt->execute([$ip]);
        $row = $stmt->fetch();

        if ($row) {
            $attempts = (int)$row['attempts'] + 1;
            $lockedUntil = null;
            if ($attempts >= 5) {
                $lockedUntil = date('Y-m-d H:i:s', time() + 900); // 15-minute lockout
            }
            $update = $pdo->prepare("UPDATE login_rate_limits SET attempts = ?, last_attempt = ?, locked_until = ? WHERE ip_address = ?");
            $update->execute([$attempts, $now, $lockedUntil, $ip]);
        } else {
            $insert = $pdo->prepare("INSERT INTO login_rate_limits (ip_address, attempts, last_attempt, locked_until) VALUES (?, 1, ?, NULL)");
            $insert->execute([$ip, $now]);
        }
    } catch (Exception $e) {
        error_log('Rate limit record error: ' . $e->getMessage());
    }
}

/**
 * Clear failed login attempts upon successful authentication
 */
function clearLoginAttempts(string $ip): void
{
    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM login_rate_limits WHERE ip_address = ?");
        $stmt->execute([$ip]);
    } catch (Exception $e) {}
}

/**
 * Internal cURL Probe Helper for analyzeRealDomain
 */
function probeHttpEndpoint(string $targetUrl): array
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $targetUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if (defined('CURLOPT_PROTOCOLS') && defined('CURLPROTO_HTTP') && defined('CURLPROTO_HTTPS')) {
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
        curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
    }
    curl_setopt($ch, CURLOPT_USERAGENT, 'BusinessDoctor-Audit/1.0 (+https://businessdoctor.com)');

    $start = microtime(true);
    $headerOutput = curl_exec($ch);
    $elapsedMs = (int)round((microtime(true) - $start) * 1000);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = (string)curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    $errno = curl_errno($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    return [
        'http_code' => $httpCode,
        'response_time_ms' => $elapsedMs,
        'header_output' => $headerOutput,
        'final_url' => $finalUrl,
        'errno' => $errno,
        'curl_error' => $curlError
    ];
}

/**
 * Real Live Technical Domain Analysis with SSRF Protection
 * Tests DNS resolution, actual HTTP/HTTPS latency, SSL status, and server headers.
 * Never presents simulated metrics as actual measurements.
 */
function analyzeRealDomain(string $url): array
{
    $url = trim($url);
    if (empty($url)) {
        return [
            'is_valid' => false,
            'host' => 'None provided',
            'dns_resolved' => false,
            'ip' => null,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => 'No website domain was provided.'
        ];
    }

    // Default to https if protocol is omitted
    $hasExplicitHttp = (bool)preg_match('/^http:\/\//i', $url);
    if (!preg_match('/^https?:\/\//i', $url)) {
        $url = 'https://' . $url;
    }

    $parsed = parse_url($url);
    $scheme = strtolower($parsed['scheme'] ?? '');
    $host = $parsed['host'] ?? '';

    // Enforce HTTP / HTTPS scheme only
    if ($scheme !== 'http' && $scheme !== 'https') {
        return [
            'is_valid' => false,
            'host' => $host ?: 'Invalid protocol',
            'dns_resolved' => false,
            'ip' => null,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => 'Security Error: Only standard HTTP and HTTPS web domains can be audited.'
        ];
    }

    // Host sanitation
    $host = strtolower(preg_replace('/^www\./i', '', $host));

    // Block obvious local names first for explicit security reporting
    if (in_array($host, ['localhost', '127.0.0.1', '0.0.0.0', '::1'], true) || 
        str_ends_with($host, '.local') || str_ends_with($host, '.internal') || str_ends_with($host, '.lan')) {
        return [
            'is_valid' => false,
            'host' => $host,
            'dns_resolved' => false,
            'ip' => null,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => 'Security restriction: Scanning localhost, internal subnets, or private names is prohibited.'
        ];
    }

    if (empty($host) || preg_match('/[^a-z0-9.-]/', $host) || !str_contains($host, '.') || str_starts_with($host, '.') || str_ends_with($host, '.')) {
        return [
            'is_valid' => false,
            'host' => $host ?: 'Invalid syntax',
            'dns_resolved' => false,
            'ip' => null,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => 'Invalid domain format. Please provide a fully qualified domain (e.g. yourcompany.com).'
        ];
    }

    // 1. DNS Resolution
    $resolvedIp = @gethostbyname($host);
    if ($resolvedIp === $host || !filter_var($resolvedIp, FILTER_VALIDATE_IP)) {
        return [
            'is_valid' => false,
            'host' => $host,
            'dns_resolved' => false,
            'ip' => null,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => "DNS resolution failed. Domain '{$host}' does not exist or has no active DNS A-records."
        ];
    }

    // 2. SSRF Protection: Validate that the resolved IP is public
    if (!isPublicInternetIp($resolvedIp)) {
        return [
            'is_valid' => false,
            'host' => $host,
            'dns_resolved' => true,
            'ip' => $resolvedIp,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => "Security restriction: IP '{$resolvedIp}' resolves to a private, loopback, or reserved network."
        ];
    }

    // 3. Probing Endpoint (Prefer HTTPS, gracefully fallback to HTTP for non-SSL domains)
    $primaryTarget = ($hasExplicitHttp) ? ('http://' . $host) : ('https://' . $host);
    $probe = probeHttpEndpoint($primaryTarget);

    // If HTTPS attempt failed or timed out, attempt plain HTTP fallback if not explicitly HTTP
    $sslActive = true;
    if (!$hasExplicitHttp && ($probe['http_code'] === 0 || $probe['errno'] === 35 || $probe['errno'] === 60)) {
        $httpProbe = probeHttpEndpoint('http://' . $host);
        if ($httpProbe['http_code'] > 0) {
            $probe = $httpProbe;
            $sslActive = false;
        }
    } elseif ($hasExplicitHttp) {
        $sslActive = (stripos($probe['final_url'], 'https://') === 0);
    }

    // SSRF Check on final redirect destination host (prevent open-redirect SSRF bypass)
    $finalHost = parse_url($probe['final_url'] ?? '', PHP_URL_HOST);
    if (!empty($finalHost)) {
        $finalIp = @gethostbyname($finalHost);
        if (filter_var($finalIp, FILTER_VALIDATE_IP) && !isPublicInternetIp($finalIp)) {
            return [
                'is_valid' => false,
                'host' => $host,
                'dns_resolved' => true,
                'ip' => $resolvedIp,
                'http_code' => 0,
                'response_time_ms' => null,
                'ssl_active' => false,
                'compression' => 'Unknown',
                'security_headers' => [],
                'status_message' => 'Security restriction: Redirected to a restricted internal network address.'
            ];
        }
    }

    // Timeout scenario
    if ($probe['errno'] === 28 /* CURLE_OPERATION_TIMEDOUT */) {
        return [
            'is_valid' => true,
            'host' => $host,
            'dns_resolved' => true,
            'ip' => $resolvedIp,
            'http_code' => 0,
            'response_time_ms' => null,
            'ssl_active' => false,
            'compression' => 'Unknown',
            'security_headers' => [],
            'status_message' => 'Domain responded slowly and timed out after 4 seconds.'
        ];
    }

    // Extract headers
    $headerOutput = $probe['header_output'];
    $isSsl = (stripos($probe['final_url'], 'https://') === 0) || $sslActive;
    $hasGzip = (is_string($headerOutput) && stripos($headerOutput, 'gzip') !== false);
    $hasBrotli = (is_string($headerOutput) && stripos($headerOutput, 'br') !== false);

    $secHeaders = [];
    if (is_string($headerOutput)) {
        if (stripos($headerOutput, 'Strict-Transport-Security') !== false) $secHeaders[] = 'HSTS';
        if (stripos($headerOutput, 'X-Frame-Options') !== false) $secHeaders[] = 'X-Frame-Options';
        if (stripos($headerOutput, 'X-Content-Type-Options') !== false) $secHeaders[] = 'X-Content-Type-Options';
        if (stripos($headerOutput, 'Content-Security-Policy') !== false) $secHeaders[] = 'CSP';
    }

    $httpCode = $probe['http_code'];
    $elapsedMs = $probe['response_time_ms'];

    return [
        'is_valid' => ($httpCode > 0),
        'host' => $host,
        'dns_resolved' => true,
        'ip' => $resolvedIp,
        'http_code' => $httpCode,
        'response_time_ms' => $elapsedMs,
        'ssl_active' => $isSsl,
        'compression' => $hasBrotli ? 'Brotli' : ($hasGzip ? 'Gzip' : 'Standard'),
        'security_headers' => $secHeaders,
        'status_message' => ($httpCode >= 200 && $httpCode < 400) 
            ? "Domain active with {$elapsedMs}ms round-trip latency and HTTP {$httpCode}." 
            : ($httpCode > 0 ? "Domain responded with HTTP {$httpCode} ({$elapsedMs}ms)." : "Host unreachable ({$probe['curl_error']}).")
    ];
}

/**
 * Calculate Digital Readiness Score based on business challenge, revenue bracket, and operating model
 */
function computeDigitalAuditScore(string $challenge, string $revenue, string $model): array
{
    $score = 75;
    $impacts = [];
    $urgency = 'Optimization Opportunity';

    switch ($challenge) {
        case 'conversion':
        case 'funnel':
            $score -= 18;
            $impacts[] = 'Suboptimal digital user experience causing drop-offs at checkout or demo forms';
            $impacts[] = 'Lack of conversion-rate optimization (CRO) testing';
            $urgency = 'High Priority';
            break;
        case 'traffic':
        case 'marketing':
            $score -= 15;
            $impacts[] = 'Underperforming search engine visibility and inefficient ad spend attribution';
            $impacts[] = 'Paid campaigns lacking precise audience segmentation and retargeting';
            $urgency = 'Elevated';
            break;
        case 'technology':
        case 'outdated_tech':
            $score -= 24;
            $impacts[] = 'Legacy website architecture with slow page speed and mobile responsiveness issues';
            $impacts[] = 'Security vulnerabilities and lack of modern automated workflows';
            $urgency = 'Immediate Action Recommended';
            break;
        case 'branding':
        case 'ui_ux':
            $score -= 14;
            $impacts[] = 'Visual identity and digital design do not reflect modern enterprise credibility';
            $impacts[] = 'Inconsistent digital branding across channels';
            $urgency = 'Strategic Priority';
            break;
        case 'marketplace':
        case 'ecommerce':
            $score -= 20;
            $impacts[] = 'Unoptimized product listings and lost sales velocity on Amazon/Flipkart';
            $impacts[] = 'Sub-optimal advertising return on marketplace campaigns';
            $urgency = 'High Priority';
            break;
        default:
            $score -= 12;
            $impacts[] = 'Comprehensive IT and digital presence requires modernization';
            break;
    }

    if ($revenue === '1m_to_5m' || $revenue === '5m_plus') {
        $opportunitySize = '$50,000 – $250,000+ Annual Digital Uplift Potential';
    } elseif ($revenue === '250k_to_1m') {
        $opportunitySize = '$20,000 – $80,000 Annual Digital Uplift Potential';
    } else {
        $opportunitySize = '$10,000 – $30,000 Annual Digital Uplift Potential';
    }

    return [
        'score' => max(32, min(96, $score)),
        'urgency' => $urgency,
        'impacts' => $impacts,
        'opportunity' => $opportunitySize,
        'recommended_practice' => match($challenge) {
            'technology', 'outdated_tech' => 'Web & Custom Software Development',
            'traffic', 'marketing' => 'Digital Marketing & Performance Ads',
            'branding', 'ui_ux' => 'UI/UX Design & Brand Identity',
            'marketplace', 'ecommerce' => 'E-Commerce & Marketplace Management',
            default => 'Web & Custom Software Development'
        }
    ];
}

/**
 * Backward-compatible alias for the scoring logic
 */
function computePreliminaryHealth(string $bottleneck, string $revenue, string $model): array
{
    $res = computeDigitalAuditScore($bottleneck, $revenue, $model);
    return [
        'score' => $res['score'],
        'urgency' => $res['urgency'],
        'risks' => $res['impacts'],
        'exposure' => $res['opportunity'],
        'recommended_practice' => $res['recommended_practice']
    ];
}

/**
 * BusinessDoctor Six Core IT & Digital Practice Areas
 */
function getPracticeAreas(): array
{
    return [
        'web-software-development' => [
            'number' => '01',
            'name' => 'Web & Custom Software Development',
            'short_title' => 'Web & Software Dev',
            'slug' => 'web-software-development',
            'tagline' => 'High-Performance Web Platforms & Enterprise Applications',
            'summary' => 'Custom enterprise websites, fast web applications, client portals, and secure database solutions engineered with modern PHP, HTML5, and clean JavaScript.',
            'description' => 'We engineer robust, lightning-fast web and software applications tailored to your business operations. From high-converting business websites to scalable SaaS platforms, internal portals, and custom database web tools, our engineering delivers sub-second load times, ironclad security, and seamless user experiences.',
            'deliverables' => [
                'Custom Corporate & Business Websites',
                'Web Application & Client Portal Development',
                'E-Commerce & Multi-Vendor Storefronts',
                'Database Architecture & API Integrations',
                'Speed Optimization & Core Web Vitals (95+ score)'
            ],
            'kpis' => ['< 0.8s Global Load Times', '100% Mobile Responsive', 'Zero Framework Bloat'],
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>'
        ],
        'digital-marketing-seo' => [
            'number' => '02',
            'name' => 'Digital Marketing & Performance Ads',
            'short_title' => 'Digital Marketing & SEO',
            'slug' => 'digital-marketing-seo',
            'tagline' => 'Search Engine Dominance, Google Ads & Paid Media Scaling',
            'summary' => 'Comprehensive SEO, high-ROI Google Ads campaigns, social media marketing, and data-backed lead generation strategies that drive qualified customer acquisition.',
            'description' => 'Accelerate your revenue with targeted digital marketing. We develop data-driven campaigns across Google Search, Meta Ads, LinkedIn B2B, and high-intent organic search channels—focusing on customer acquisition cost (CAC) reduction, conversion rates, and measurable return on ad spend (ROAS).',
            'deliverables' => [
                'Search Engine Optimization (Technical, On-Page & Local SEO)',
                'Google Search, Display & Performance Max Ads (PPC)',
                'Social Media Marketing & Paid Social Campaigns (Meta & LinkedIn)',
                'Conversion Funnel Optimization & Lead Generation',
                'Advanced Web Analytics & Conversion Tracking Setup'
            ],
            'kpis' => ['3.8x Average Campaign ROAS', '+160% Organic Search Traffic', 'Audited Zero Ad Waste'],
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/><circle cx="12" cy="12" r="2"/></svg>'
        ],
        'ui-ux-branding' => [
            'number' => '03',
            'name' => 'UI/UX Design & Brand Identity',
            'short_title' => 'UI/UX & Branding',
            'slug' => 'ui-ux-branding',
            'tagline' => 'Human-Centered Digital Interfaces & Distinct Visual Branding',
            'summary' => 'Modern UI/UX design, interactive prototypes, corporate logo design, brand style guides, and digital marketing creatives that make your brand stand out.',
            'description' => 'First impressions define customer trust. Our design division crafts intuitive user interfaces (UI) and frictionless user experiences (UX) paired with distinctive brand identity systems. We help companies elevate their market authority, command premium pricing, and convert visitors into loyal clients.',
            'deliverables' => [
                'Comprehensive UI/UX Design & Wireframing',
                'Corporate Brand Identity & Logo Systems',
                'Design Systems & Interactive Component Libraries',
                'Marketing Collateral, Pitch Decks & Brochures',
                'Conversion-Focused Landing Page Designs'
            ],
            'kpis' => ['Flawless User Journeys', 'Modern Design Tokens', 'High Trust & Engagement'],
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>'
        ],
        'ecommerce-marketplaces' => [
            'number' => '04',
            'name' => 'E-Commerce & Marketplace Management',
            'short_title' => 'E-Commerce & Marketplaces',
            'slug' => 'ecommerce-marketplaces',
            'tagline' => 'Amazon, Flipkart & Multi-Channel Storefront Growth',
            'summary' => 'Full-lifecycle e-commerce growth: Amazon and Flipkart account management, A+ content, catalog SEO, Buy Box protection, and marketplace advertising.',
            'description' => 'Maximize your sales on the world’s biggest online marketplaces. We manage complete operations across Amazon, Flipkart, and custom e-commerce stores: optimizing product titles, crafting high-converting A+ lifestyle imagery, managing sponsored ads, and defending your brand from unauthorized sellers.',
            'deliverables' => [
                'Full Amazon & Flipkart Seller Account Management',
                'Product Listing Optimization & Catalog SEO',
                'A+ Content Modules & Brand Storefront Design',
                'Marketplace Advertising (Sponsored Products & Brands)',
                'Buy Box Strategy & Brand Registry Protection'
            ],
            'kpis' => ['95%+ Buy Box Possession', '4.2x Marketplace ROAS', 'Top Search Visibility'],
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>'
        ],
        'creative-video-production' => [
            'number' => '05',
            'name' => 'Creative Production & Video Marketing',
            'short_title' => 'Creative & Video',
            'slug' => 'creative-video-production',
            'tagline' => 'Studio Product Photography, Video Production & Social Creatives',
            'summary' => 'High-resolution commercial product photography, brand promo videos, engaging Reels and Shorts, and motion graphics that captivate digital audiences.',
            'description' => 'High-quality visuals are essential for digital conversions. Our creative team produces professional studio product photos, corporate video shoots, engaging short-form social video (Reels, Shorts, TikTok), and 3D product animations tailored for digital ad performance and social media growth.',
            'deliverables' => [
                'Commercial & Studio Product Photography',
                'Corporate Brand Video & Company Storytelling',
                'Short-Form Video Production (Reels, TikTok, YouTube Shorts)',
                'Product Demo Videos & Motion Graphic Walkthroughs',
                'Ad Creatives & Performance Video Editing'
            ],
            'kpis' => ['4K Ultra HD Quality', '+220% Social Engagement', 'High-Converting Creatives'],
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>'
        ],
        'cloud-it-consulting' => [
            'number' => '06',
            'name' => 'Cloud Solutions & IT Consulting',
            'short_title' => 'Cloud & IT Consulting',
            'slug' => 'cloud-it-consulting',
            'tagline' => 'Cloud Infrastructure, DevOps, Cybersecurity & Systems Maintenance',
            'summary' => 'Strategic IT consulting, cloud server setup, continuous website maintenance, security audits, and business process automation.',
            'description' => 'Ensure your digital assets remain fast, secure, and always accessible. We provide enterprise-level IT consulting, cloud infrastructure management (AWS, Google Cloud, DigitalOcean), ongoing website maintenance, vulnerability patching, backup automation, and digital transformation consulting.',
            'deliverables' => [
                'Cloud Architecture & Server Deployment',
                'Website Maintenance, Uptime & Performance Monitoring',
                'Cybersecurity Audits, SSL & Vulnerability Patching',
                'Business Workflow & CRM Automation',
                'Strategic Digital Transformation Consulting'
            ],
            'kpis' => ['99.9% Uptime Guarantee', '24/7 Monitoring & Backups', 'Zero Security Breaches'],
            'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>'
        ]
    ];
}

/**
 * Fetch a specific practice area by its slug
 */
function getPracticeBySlug(string $slug): ?array
{
    $practices = getPracticeAreas();
    if (isset($practices[$slug])) {
        return $practices[$slug];
    }

    $legacyMap = [
        'strategic-consulting' => 'cloud-it-consulting',
        'digital-engineering' => 'web-software-development',
        'performance-marketing' => 'digital-marketing-seo',
        'brand-architecture' => 'ui-ux-branding',
        'ecommerce-acceleration' => 'ecommerce-marketplaces',
        'creative-production' => 'creative-video-production'
    ];

    if (isset($legacyMap[$slug]) && isset($practices[$legacyMap[$slug]])) {
        return $practices[$legacyMap[$slug]];
    }

    return null;
}

/**
 * Generate a unique URL slug for CMS content
 */
function generateUniqueSlug(string $title, string $table, ?int $excludeId = null): string
{
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = trim((string)preg_replace('/-+/', '-', $slug), '-');
    if (empty($slug)) {
        $slug = 'post-' . bin2hex(random_bytes(3));
    }

    // Protect allowed table names
    $allowedTables = ['insights', 'case_studies'];
    if (!in_array($table, $allowedTables, true)) {
        throw new InvalidArgumentException('Invalid table name for slug generation.');
    }

    $pdo = Database::getConnection();
    $baseSlug = $slug;
    $counter = 1;

    while (true) {
        $sql = "SELECT id FROM {$table} WHERE slug = ? " . ($excludeId !== null ? "AND id != ?" : "") . " LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $params = $excludeId !== null ? [$slug, $excludeId] : [$slug];
        $stmt->execute($params);
        if (!$stmt->fetch()) {
            return $slug;
        }
        $counter++;
        $slug = $baseSlug . '-' . $counter;
    }
}

/**
 * Set session flash message
 */
function setFlashMessage(string $type, string $message): void
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    $_SESSION['flash_message'] = [
        'type' => in_array($type, ['success', 'error', 'info', 'warning'], true) ? $type : 'info',
        'message' => $message
    ];
}

/**
 * Get and clear session flash message
 */
function getFlashMessage(): ?array
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    if (!empty($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}
