<?php
/**
 * BusinessDoctor Admin Gateway
 * Automatically routes authenticated users to dashboard and unauthenticated users to login.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$target = !empty($_SESSION['admin_user']) ? appUrl('admin/dashboard.php') : appUrl('admin/login.php');
header("Location: " . $target);
exit;
