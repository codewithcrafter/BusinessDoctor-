<?php
/**
 * BusinessDoctor API: Lead Generation Popup Form Submission
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    exit;
}

// 1. Bot Honeypot Protection: hidden field must be empty
if (!empty($_POST['bdr_website_hp']) || !empty($_POST['bdr_company_hp'])) {
    // Silently acknowledge bot to avoid giving clues
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your consultation request has been submitted.'
    ]);
    exit;
}

// 2. CSRF Token Verification
$csrfToken = $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Session security validation expired. Please refresh the page and try again.'
    ]);
    exit;
}

// 3. Extract & Sanitize Input
$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$sourceUrl = trim($_POST['source_url'] ?? '');

if (empty($sourceUrl)) {
    $sourceUrl = $_SERVER['HTTP_REFERER'] ?? '/';
}
// Truncate source URL if too long
$sourceUrl = mb_substr($sourceUrl, 0, 255);

// 4. Server-Side Validation
$errors = [];

// Name validation
if (mb_strlen($fullName) < 2) {
    $errors['full_name'] = 'Please enter your full name (at least 2 characters).';
} elseif (mb_strlen($fullName) > 150) {
    $errors['full_name'] = 'Name cannot exceed 150 characters.';
}

// Email validation
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please provide a valid business or personal email address.';
} elseif (mb_strlen($email) > 191) {
    $errors['email'] = 'Email address is too long.';
}

// Phone validation (Indian mobile number: 10 digits, optional +91 or 0 prefix, starts with 6, 7, 8, or 9)
$cleanPhone = preg_replace('/[\s\-]/', '', $phone);
$indianPhonePattern = '/^(?:\+91|0)?[6-9]\d{9}$/';
if (empty($phone)) {
    $errors['phone'] = 'Contact number is required.';
} elseif (!preg_match($indianPhonePattern, $cleanPhone)) {
    $errors['phone'] = 'Please enter a valid 10-digit Indian mobile number (e.g., 9876543210 or +91 98765 43210).';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => reset($errors), // First error message
        'errors' => $errors
    ]);
    exit;
}

// Format phone for standard readability
if (preg_match('/^(?:\+91|0)?([6-9]\d{9})$/', $cleanPhone, $matches)) {
    $formattedPhone = '+91 ' . substr($matches[1], 0, 5) . ' ' . substr($matches[1], 5);
} else {
    $formattedPhone = $phone;
}

// 5. Database Insertion via PDO Prepared Statement
try {
    $pdo = Database::getConnection();

    // Check if lead_source and source_url columns exist
    $hasExtendedCols = true;
    try {
        $checkCols = $pdo->query("SELECT lead_source, source_url FROM contact_inquiries LIMIT 0");
    } catch (Exception $e) {
        $hasExtendedCols = false;
    }

    $organization = 'Website Lead';
    $serviceInterest = 'Free Consultation';
    $message = "Lead captured via Website Lead Popup\nPage: " . $sourceUrl . "\nSubmitted: " . date('Y-m-d H:i:s');
    $leadSource = 'Website Popup';

    if ($hasExtendedCols) {
        $stmt = $pdo->prepare("
            INSERT INTO contact_inquiries 
            (full_name, email, phone, organization, service_interest, message, status, lead_source, source_url)
            VALUES (?, ?, ?, ?, ?, ?, 'new', ?, ?)
        ");
        $stmt->execute([
            $fullName,
            $email,
            $formattedPhone,
            $organization,
            $serviceInterest,
            $message,
            $leadSource,
            $sourceUrl
        ]);
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO contact_inquiries 
            (full_name, email, phone, organization, service_interest, message, status)
            VALUES (?, ?, ?, ?, ?, ?, 'new')
        ");
        $stmt->execute([
            $fullName,
            $email,
            $formattedPhone,
            $organization,
            $serviceInterest,
            $message
        ]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your request has been received. Our solutions team will connect with you shortly.'
    ]);
} catch (Exception $e) {
    error_log('Lead Popup Submission Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to log your enquiry due to a server error. Please call us directly at ' . APP_PHONE . '.'
    ]);
}

