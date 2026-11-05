<?php
/**
 * BusinessDoctor Executive Admin Logout
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';

$_SESSION['admin_user'] = null;
unset($_SESSION['admin_user']);
session_destroy();

header("Location: /admin");
exit;

