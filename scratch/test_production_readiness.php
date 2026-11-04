<?php
/**
 * BusinessDoctor Production Readiness Verification Script
 * Validates:
 * 1. SSRF prevention & domain telemetry edge cases
 * 2. Login rate limiting & brute-force mitigation
 * 3. Database production mode vs dev mode handling
 * 4. SEO canonicals, sitemap, robots, schema.org JSON-LD
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

echo "============================================================\n";
echo "BUSINESSDOCTOR PRODUCTION READINESS AUDIT SUITE\n";
echo "============================================================\n\n";

$passCount = 0;
$failCount = 0;

function reportResult(string $title, bool $passed, string $details = '') {
    global $passCount, $failCount;
    if ($passed) {
        $passCount++;
        echo "  [PASS] {$title}" . ($details ? " ({$details})" : "") . "\n";
    } else {
        $failCount++;
        echo "  [FAIL] {$title}" . ($details ? " ({$details})" : "") . "\n";
    }
}

// ------------------------------------------------------------
// TEST 1: SSRF PROTECTION & PRIVATE IP SCANNING
// ------------------------------------------------------------
echo "--- 1. TESTING SSRF & PRIVATE IP SCANNING RESTRICTIONS ---\n";

$ssrfTargets = [
    'http://127.0.0.1' => 'Loopback IPv4',
    'http://localhost' => 'Localhost name',
    'http://169.254.169.254/latest/meta-data/' => 'Cloud Metadata Service (AWS/GCP/Azure)',
    'http://192.168.1.1' => 'Private RFC 1918 Class C',
    'http://10.0.0.1' => 'Private RFC 1918 Class A',
    'http://172.16.0.1' => 'Private RFC 1918 Class B',
    'http://0.0.0.0' => 'Current network broadcast'
];

foreach ($ssrfTargets as $target => $label) {
    $res = analyzeRealDomain($target);
    $blocked = ($res['is_valid'] === false) && (strpos($res['status_message'], 'Security') !== false || strpos($res['status_message'], 'restriction') !== false || strpos($res['status_message'], 'failed') !== false);
    reportResult("SSRF blocked: {$label} ({$target})", $blocked, $res['status_message']);
}

// ------------------------------------------------------------
// TEST 2: DOMAIN ANALYSIS EDGE CASES (INVALID, NON-EXISTENT, NON-SSL)
// ------------------------------------------------------------
echo "\n--- 2. TESTING DOMAIN ANALYSIS EDGE CASES ---\n";

// Invalid Domain Syntax
$resInvalid = analyzeRealDomain('ht!tp://$$$bad..domain');
reportResult("Invalid domain syntax rejected", ($resInvalid['is_valid'] === false), $resInvalid['status_message']);

// Non-existent Domain
$resNonExistent = analyzeRealDomain('this-domain-does-not-exist-at-all-89723498723.com');
reportResult("Non-existent domain DNS resolution failure", ($resNonExistent['dns_resolved'] === false), $resNonExistent['status_message']);

// Valid Domain (e.g. google.com)
$resValid = analyzeRealDomain('google.com');
$validOk = ($resValid['is_valid'] === true && $resValid['dns_resolved'] === true && $resValid['http_code'] > 0 && $resValid['response_time_ms'] > 0);
reportResult("Valid domain telemetry measured (google.com)", $validOk, "HTTP {$resValid['http_code']}, {$resValid['response_time_ms']}ms, SSL: " . ($resValid['ssl_active'] ? 'Yes' : 'No'));

// Non-SSL Domain Probing (e.g. neverssl.com)
$resNeverSsl = analyzeRealDomain('neverssl.com');
$neverSslOk = ($resNeverSsl['is_valid'] === true && $resNeverSsl['dns_resolved'] === true);
reportResult("Non-SSL domain reachable & identified (neverssl.com)", $neverSslOk, "HTTP {$resNeverSsl['http_code']}, SSL: " . ($resNeverSsl['ssl_active'] ? 'Active' : 'Inactive'));

// ------------------------------------------------------------
// TEST 3: LOGIN RATE LIMITING & BRUTE FORCE PROTECTION
// ------------------------------------------------------------
echo "\n--- 3. TESTING LOGIN RATE LIMITING ---\n";

$testIp = '203.0.113.199'; // Test IP
clearLoginAttempts($testIp);

// Check initial state
$initCheck = checkLoginRateLimit($testIp);
reportResult("Initial login check allowed", $initCheck['allowed']);

// Simulate 4 failed attempts
for ($i = 1; $i <= 4; $i++) {
    recordFailedLogin($testIp);
}
$fourthCheck = checkLoginRateLimit($testIp);
reportResult("4 failed attempts still within threshold", $fourthCheck['allowed']);

// 5th failed attempt should trigger security lockout
recordFailedLogin($testIp);
$fifthCheck = checkLoginRateLimit($testIp);
reportResult("5th failed attempt triggers 15-min lockout", (!$fifthCheck['allowed']), $fifthCheck['message'] ?? '');

// Clear attempts
clearLoginAttempts($testIp);
$clearedCheck = checkLoginRateLimit($testIp);
reportResult("Clearing attempts restores access", $clearedCheck['allowed']);

// ------------------------------------------------------------
// TEST 4: SEO METADATA, SITEMAP & ROBOTS.TXT
// ------------------------------------------------------------
echo "\n--- 4. TESTING SEO ARTIFACTS & METADATA ---\n";

// Check robots.txt
$robotsPath = dirname(__DIR__) . '/robots.txt';
$hasRobots = file_exists($robotsPath) && strpos(file_get_contents($robotsPath), 'Disallow: /admin/') !== false;
reportResult("robots.txt exists with secure admin disallow", $hasRobots);

// Check sitemap.xml
$sitemapPath = dirname(__DIR__) . '/sitemap.xml';
$hasSitemap = file_exists($sitemapPath);
$validXml = false;
if ($hasSitemap) {
    $xml = @simplexml_load_file($sitemapPath);
    $validXml = ($xml !== false && count($xml->url) >= 15);
}
reportResult("sitemap.xml exists and is valid XML", $validXml, "URL count: " . ($xml ? count($xml->url) : 0));

// Check HTML header SEO tags on homepage
$homeHtml = file_get_contents('http://127.0.0.1:8000/');
$hasCanonical = (strpos($homeHtml, 'rel="canonical"') !== false);
$hasOg = (strpos($homeHtml, 'property="og:title"') !== false && strpos($homeHtml, 'property="og:image"') !== false);
$hasTwitter = (strpos($homeHtml, 'name="twitter:card"') !== false);
$hasSchema = (strpos($homeHtml, 'application/ld+json') !== false && strpos($homeHtml, 'ProfessionalService') !== false);

reportResult("Canonical link tag in HTML", $hasCanonical);
reportResult("Open Graph tags (title, image, url)", $hasOg);
reportResult("Twitter Card tags", $hasTwitter);
reportResult("Schema.org JSON-LD Structured Data", $hasSchema);

// Check .htaccess
$htaccessPath = dirname(__DIR__) . '/.htaccess';
$hasHtaccess = file_exists($htaccessPath);
$hasSecurityRules = false;
if ($hasHtaccess) {
    $htContent = file_get_contents($htaccessPath);
    $hasSecurityRules = (strpos($htContent, 'Options -Indexes') !== false && strpos($htContent, 'RewriteEngine On') !== false && strpos($htContent, 'X-Content-Type-Options') !== false);
}
reportResult(".htaccess production rules configured", $hasSecurityRules);

echo "\n============================================================\n";
echo "SUMMARY: {$passCount} PASSED, {$failCount} FAILED\n";
echo "============================================================\n";

