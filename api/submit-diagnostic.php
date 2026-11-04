<?php
/**
 * BusinessDoctor API: Submit Digital Audit Request with Real Technical Domain Analysis
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Security: Verify CSRF token
$csrfToken = $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Security token invalid or expired. Please refresh the page and submit again.'
    ]);
    exit;
}

$workEmail = filter_var(trim($_POST['work_email'] ?? ''), FILTER_VALIDATE_EMAIL);
$websiteUrl = filter_var(trim($_POST['website_url'] ?? ''), FILTER_SANITIZE_URL);
$companyName = trim($_POST['company_name'] ?? '');
$contactName = trim($_POST['contact_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$revenueBracket = trim($_POST['revenue_bracket'] ?? '250k_to_1m');
$bottleneck = trim($_POST['primary_bottleneck'] ?? 'technology');
$operatingModel = trim($_POST['operating_model'] ?? 'b2b');

if (empty($companyName)) {
    if (!empty($websiteUrl)) {
        $parsed = parse_url($websiteUrl, PHP_URL_HOST);
        $companyName = $parsed ? ucfirst(str_replace('www.', '', $parsed)) : 'Enterprise Client';
    } else {
        $companyName = 'Prospective Enterprise Client';
    }
}

if (empty($contactName)) {
    $parts = explode('@', (string)$workEmail);
    $contactName = !empty($parts[0]) ? ucfirst($parts[0]) : 'Project Inquirer';
}

if (!$workEmail) {
    http_response_code(422);
    echo json_encode([
        'success' => false, 
        'message' => 'A valid corporate work email address is required for sending your digital audit report.'
    ]);
    exit;
}

// 1. Perform Real Technical Domain Analysis (Never simulate actual measurements)
$realTelemetry = !empty($websiteUrl) 
    ? analyzeRealDomain($websiteUrl) 
    : [
        'is_valid' => false,
        'host' => 'None provided',
        'dns_resolved' => false,
        'ip' => null,
        'http_code' => 0,
        'response_time_ms' => null,
        'ssl_active' => false,
        'compression' => 'Unknown',
        'security_headers' => [],
        'status_message' => 'No website URL was supplied for live technical probing.'
    ];

// 2. Questionnaire-Based Business Readiness Score
$eval = computeDigitalAuditScore($bottleneck, $revenueBracket, $operatingModel);
$healthScore = $eval['score'];

// 3. Record summary with clear distinction between real measured telemetry & client survey
$summary = sprintf(
    "LIVE TELEMETRY: Host: %s | DNS: %s | Latency: %s | HTTP: %d | SSL: %s || SURVEY: Urgency: %s | Growth Potential: %s | Recommended Practice: %s",
    $realTelemetry['host'],
    $realTelemetry['dns_resolved'] ? 'Resolved (' . $realTelemetry['ip'] . ')' : 'Failed',
    $realTelemetry['response_time_ms'] !== null ? $realTelemetry['response_time_ms'] . 'ms' : 'Unreachable',
    $realTelemetry['http_code'],
    $realTelemetry['ssl_active'] ? 'Active (HTTPS)' : 'Inactive / HTTP',
    $eval['urgency'],
    $eval['opportunity'],
    $eval['recommended_practice']
);

$refNo = 'BD-' . strtoupper(bin2hex(random_bytes(4)));

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("
        INSERT INTO diagnostic_requests 
        (reference_no, company_name, contact_name, work_email, phone, website_url, revenue_bracket, primary_bottleneck, operating_model, health_score, diagnostic_summary, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $refNo,
        $companyName,
        $contactName,
        $workEmail,
        $phone,
        $websiteUrl,
        $revenueBracket,
        $bottleneck,
        $operatingModel,
        $healthScore,
        $summary
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Digital audit request registered successfully. Our technical team is reviewing your website and project requirements.',
        'reference_no' => $refNo,
        'health_score' => $healthScore,
        'urgency' => $eval['urgency'],
        'recommended_practice' => $eval['recommended_practice'],
        'real_telemetry' => $realTelemetry
    ]);
} catch (Exception $e) {
    error_log('Audit Submission DB Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal audit registration error. Please contact our solutions desk directly.'
    ]);
}
