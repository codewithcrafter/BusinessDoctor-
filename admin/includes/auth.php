<?php
/**
 * BusinessDoctor Admin Authentication Guard
 */

declare(strict_types=1);

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';

if (empty($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

$adminUser = $_SESSION['admin_user'];
$pdo = Database::getConnection();

