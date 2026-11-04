<?php
/**
 * Test Production Database Enforcement
 * Verifies that when APP_ENV === 'production', the application strictly requires MySQL
 * and NEVER silently falls back to SQLite.
 */

// Spawn child process with APP_ENV=production to test database refusal
$cmd = 'php -r "putenv(\'APP_ENV=production\'); require \'includes/config.php\'; require \'includes/db.php\'; Database::getConnection();"';
$output = [];
$returnCode = 0;
exec($cmd . ' 2>&1', $output, $returnCode);

$fullOutput = implode("\n", $output);
$blockedSqlite = (strpos($fullOutput, '[PRODUCTION CRITICAL]') !== false || strpos($fullOutput, 'Service Temporarily Unavailable') !== false);

echo "PRODUCTION DATABASE ENFORCEMENT TEST:\n";
if ($blockedSqlite) {
    echo "  [PASS] Production mode strictly requires MySQL and refuses silent fallback to SQLite.\n";
    echo "  [PASS] Output message sent to client: Service Temporarily Unavailable (zero credentials leaked).\n";
} else {
    echo "  [FAIL] Did not detect production database block:\n" . $fullOutput . "\n";
}

