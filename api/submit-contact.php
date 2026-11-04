<?php
/**
 * BusinessDoctor API: Submit Contact Inquiry
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
        'message' => 'Security validation failed or session expired. Please refresh the page and try again.'
    ]);
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$phone = trim($_POST['phone'] ?? '');
$organization = trim($_POST['organization'] ?? '');
$serviceInterest = trim($_POST['service_interest'] ?? 'General Project Consultation');
$message = trim($_POST['message'] ?? '');

if (empty($fullName) || !$email || empty($message)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please provide your full name, a valid email address, and a brief description of your inquiry.'
    ]);
    exit;
}

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("
        INSERT INTO contact_inquiries 
        (full_name, email, phone, organization, service_interest, message, status)
        VALUES (?, ?, ?, ?, ?, ?, 'new')
    ");

    $stmt->execute([
        $fullName,
        $email,
        $phone,
        $organization,
        $serviceInterest,
        $message
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Your consultation request has been received. Our solutions team responds within 2 business hours.'
    ]);
} catch (Exception $e) {
    error_log('Contact Submission Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to log inquiry. Please call our direct line at ' . APP_PHONE . '.'
    ]);
}
