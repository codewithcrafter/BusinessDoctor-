<?php
/**
 * BusinessDoctor Comprehensive Functional & Security Integration Test Suite
 */

$baseUrl = 'http://127.0.0.1:8000';

@unlink(__DIR__ . '/test_cookies.txt');
@unlink(__DIR__ . '/admin_cookie.txt');
@unlink(__DIR__ . '/api_cookie.txt');

function testUrl($url, $expectedStatus = 200, $findSubstring = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Check raw redirects
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/test_cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/test_cookies.txt');
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    $passed = ($httpCode === $expectedStatus);
    if ($findSubstring && $passed) {
        $passed = (strpos($response, $findSubstring) !== false);
    }
    return [
        'url' => $url,
        'code' => $httpCode,
        'passed' => $passed,
        'error' => $error,
        'has_substring' => $findSubstring ? (strpos($response, $findSubstring) !== false) : true,
        'body' => $response
    ];
}

echo "=== 1. TESTING ALL PUBLIC PAGES ===\n";
$pages = [
    '/' => 'BusinessDoctor',
    '/about.php' => 'About BusinessDoctor',
    '/services.php' => 'Digital Marketing',
    '/service-detail.php?slug=digital-marketing-seo' => 'Digital Marketing',
    '/service-detail.php?slug=web-software-development' => 'Web &amp; Custom Software',
    '/audit.php' => 'Digital Growth Audit',
    '/contact.php' => 'Let’s Build Something Exceptional Together',
    '/case-studies.php' => 'Client Success Stories',
    '/case-study-detail.php?slug=fintech-saas-funnel-resuscitation' => 'PayGuard',
    '/case-study-detail.php?slug=d2c-apparel-vital-infrastructure-overhaul' => 'AURA Atelier',
    '/insights.php' => 'Growth Insights',
    '/insight-detail.php?slug=the-symptom-trap-why-ad-spend-fails-broken-funnels' => 'Why Increasing Ad Spend',
    '/admin/login.php' => 'Sign In to Project Console'
];

$allPassed = true;
foreach ($pages as $path => $needle) {
    $res = testUrl($baseUrl . $path, 200, $needle);
    $status = $res['passed'] ? "PASS" : "FAIL (HTTP {$res['code']})";
    echo "  [{$status}] {$path}\n";
    if (!$res['passed']) $allPassed = false;
}

echo "\n=== 2. TESTING ADMIN AUTH & REDIRECTION ===\n";
// Requesting dashboard without session should redirect (302) to login.php
$dashUnauth = testUrl($baseUrl . '/admin/dashboard.php', 302);
echo "  [" . ($dashUnauth['code'] === 302 ? "PASS" : "FAIL") . "] Unauthorized /admin/dashboard.php redirected (HTTP {$dashUnauth['code']})\n";

// Perform admin login flow with CSRF token
// First fetch login page to get session cookie and CSRF token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/admin/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/admin_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/admin_cookie.txt');
$loginPageHtml = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token"\s+value="([^"]+)"/', $loginPageHtml, $matches);
$csrfToken = $matches[1] ?? '';
echo "  [" . (!empty($csrfToken) ? "PASS" : "FAIL") . "] Extracted CSRF token from login page: " . substr($csrfToken, 0, 10) . "...\n";

// Login with credentials
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/admin/login.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'username' => 'admin',
    'password' => 'Admin@BusinessDoctor2026',
    'csrf_token' => $csrfToken
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/admin_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/admin_cookie.txt');
$loginRes = curl_exec($ch);
$loginCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "  [" . ($loginCode === 302 ? "PASS" : "FAIL") . "] Admin authenticated and redirected (HTTP {$loginCode})\n";

// Access dashboard with logged in cookie
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/admin/dashboard.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/admin_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/admin_cookie.txt');
$dashHtml = curl_exec($ch);
$dashCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$dashPassed = ($dashCode === 200 && strpos($dashHtml, 'Client Projects Console') !== false);
echo "  [" . ($dashPassed ? "PASS" : "FAIL") . "] Authenticated /admin/dashboard.php loaded successfully (HTTP {$dashCode})\n";

echo "\n=== 3. TESTING API ENDPOINTS WITH CSRF ===\n";

// Fetch fresh CSRF token from contact page
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/contact.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/api_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/api_cookie.txt');
$contactHtml = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token"\s+value="([^"]+)"/', $contactHtml, $matches);
$apiCsrf = $matches[1] ?? '';

// Test Contact Form Submission
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/submit-contact.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'full_name' => 'Audit Tester',
    'email' => 'auditor@businessdoctor.test',
    'phone' => '+15551234567',
    'company' => 'Audit Corp',
    'service_category' => 'Technology',
    'budget_range' => '$10k-$25k',
    'message' => 'Functional audit validation message.',
    'csrf_token' => $apiCsrf
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Requested-With: XMLHttpRequest']);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/api_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/api_cookie.txt');
$contactJson = curl_exec($ch);
curl_close($ch);
$contactRes = json_decode($contactJson, true);
echo "  [" . ($contactRes['success'] ? "PASS" : "FAIL") . "] Contact API: " . ($contactRes['message'] ?? 'Failed') . "\n";

// Test Digital Audit Submission with Real Domain Telemetry
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/submit-diagnostic.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'company_name' => 'Google Test Client',
    'website_url' => 'https://www.google.com',
    'contact_name' => 'Tech Lead Tester',
    'work_email' => 'lead@googletest.com',
    'phone' => '+15559876543',
    'operating_model' => 'b2b',
    'revenue_bracket' => '1m_to_5m',
    'primary_bottleneck' => 'technology',
    'csrf_token' => $apiCsrf
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Requested-With: XMLHttpRequest']);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/api_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/api_cookie.txt');
$diagJson = curl_exec($ch);
curl_close($ch);
$diagRes = json_decode($diagJson, true);
$realTel = $diagRes['real_telemetry'] ?? [];
$telemetryValid = !empty($realTel) && isset($realTel['dns_resolved']) && isset($realTel['response_time_ms']);
echo "  [" . ($diagRes['success'] && $telemetryValid ? "PASS" : "FAIL") . "] Diagnostic API (Real Telemetry): Ref " . ($diagRes['reference_no'] ?? 'N/A') . " (Latency: " . ($realTel['response_time_ms'] ?? 'N/A') . "ms, HTTP: " . ($realTel['http_code'] ?? 'N/A') . ")\n";

// Test Newsletter Subscription
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/newsletter-subscribe.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'email' => 'newsletter_tester@businessdoctor.test',
    'csrf_token' => $apiCsrf
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Requested-With: XMLHttpRequest']);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/api_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/api_cookie.txt');
$newsJson = curl_exec($ch);
curl_close($ch);
$newsRes = json_decode($newsJson, true);
echo "  [" . ($newsRes['success'] ? "PASS" : "FAIL") . "] Newsletter API: " . ($newsRes['message'] ?? 'Failed') . "\n";

echo "\n=== 4. TESTING CSRF REJECTION (SECURITY) ===\n";
// Submit without CSRF token to verify 403 rejection
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/submit-contact.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'email' => 'malicious@hack.test'
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-Requested-With: XMLHttpRequest']);
$badJson = curl_exec($ch);
$badCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "  [" . ($badCode === 403 ? "PASS" : "FAIL") . "] API correctly rejected request missing CSRF token (HTTP {$badCode})\n";

echo "\n=== ALL TESTS COMPLETE ===\n";
