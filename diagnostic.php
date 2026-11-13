<?php
/**
 * BusinessDoctor: 301 Permanent Canonical Redirect to Free Digital Audit & Project Scope Portal
 */

declare(strict_types=1);

$query = !empty($_SERVER['QUERY_STRING']) ? ('?' . $_SERVER['QUERY_STRING']) : '';
header("Location: /audit.php" . $query, true, 301);
exit;
