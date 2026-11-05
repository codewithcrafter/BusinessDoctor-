<?php
/**
 * BusinessDoctor Admin Master Controller (/admin)
 * Routes unauthenticated users to Login and authenticated users to Dashboard
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// If authenticated, display dashboard internally
if (!empty($_SESSION['admin_user'])) {
    require __DIR__ . '/dashboard.php';
    exit;
}

// Unauthenticated: Handle login submission or render login form
require __DIR__ . '/login.php';
