<?php
/**
 * BusinessDoctor API: Newsletter Subscription
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

// Security: Verify CSRF token if provided
$csrfToken = $_POST['csrf_token'] ?? '';
if (!empty($csrfToken) && !verifyCsrfToken($csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Security validation failed or session expired. Please refresh the page.'
    ]);
    exit;
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$source = trim($_POST['source'] ?? 'footer');
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

if (!$email) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid corporate email address.'
    ]);
    exit;
}

try {
    $pdo = Database::getConnection();
    
    // Check if already subscribed
    $check = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        echo json_encode([
            'success' => true,
            'message' => 'You are already registered to receive our tech newsletter.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO newsletter_subscribers (email, source_page, ip_address, is_active)
        VALUES (?, ?, ?, 1)
    ");
    $stmt->execute([$email, $source, $ip]);

    echo json_encode([
        'success' => true,
        'message' => 'Subscription confirmed. You will receive our monthly tech & digital insights.'
    ]);
} catch (Exception $e) {
    error_log('Newsletter Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Subscription service temporarily unavailable.'
    ]);
}
