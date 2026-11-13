<?php
/**
 * BusinessDoctor Enterprise Configuration
 * IT & Digital Services Practice
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// Load environment variables from .env file if present
$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
if (file_exists($envFile) && is_readable($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $k = trim($k);
            $v = trim($v, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($k, $_ENV)) {
                putenv("{$k}={$v}");
                $_ENV[$k] = $v;
            }
        }
    }
}

// Detect local development environment vs live production
$currentHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocalHost = in_array($currentHost, ['127.0.0.1:8000', 'localhost:8000', 'localhost', '127.0.0.1'], true)
               || str_starts_with($currentHost, 'localhost')
               || str_starts_with($currentHost, '127.0.0.1')
               || in_array(php_sapi_name(), ['cli-server', 'cli'], true);

// Determine Application Environment: local runs as development, production stays production
$env = getenv('APP_ENV');
if ($isLocalHost) {
    $env = 'development';
} elseif (!$env) {
    $env = 'production';
}
define('APP_ENV', $env);

// Error reporting: Strict logging in production without exposing sensitive traces
if (APP_ENV === 'production') {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
} else {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// Session security initialization
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_samesite', 'Lax');

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    if ($isHttps || APP_ENV === 'production') {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}

// Global Application Constants - IT & Digital Services Company
define('APP_NAME', 'BusinessDoctor');
define('APP_LEGAL_NAME', 'BusinessDoctor IT Solutions & Digital Services Private Limited');
define('APP_TAGLINE', 'Engineering Technology. Accelerating Digital Growth.');
define('APP_EMAIL', 'solutions@businessdoctor.com');
define('APP_PHONE', '+1 (800) 492-3628');
define('APP_CALL_NUMBER', getenv('APP_CALL_NUMBER') ?: '+18004923628');
define('APP_WHATSAPP_NUMBER', getenv('APP_WHATSAPP_NUMBER') ?: '18004923628');
define('APP_WHATSAPP_MESSAGE', getenv('APP_WHATSAPP_MESSAGE') ?: 'Hello BusinessDoctor, I would like to inquire about your enterprise IT and digital services.');
define('APP_HEADQUARTERS', 'Floor 42, Executive Tech Park, Innovation District');

// Base URL calculation (safe fallback for CLI & varied web servers)
$envAppUrl = getenv('APP_URL');
// If running on local XAMPP Apache or localhost without custom host domain, dynamically derive base URL
$currentHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocalHost = in_array($currentHost, ['127.0.0.1:8000', 'localhost:8000', 'localhost', '127.0.0.1'], true)
               || str_starts_with($currentHost, 'localhost')
               || str_starts_with($currentHost, '127.0.0.1')
               || in_array(php_sapi_name(), ['cli-server', 'cli'], true);

if (!empty($envAppUrl) && !($isLocalHost && str_contains($envAppUrl, 'demo.businesdoctor.com'))) {
    define('BASE_URL', rtrim($envAppUrl, '/'));
} else {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'demo.businesdoctor.com';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $scriptDir = rtrim(str_replace('\\', '/', $scriptDir), '/');

    $parts = explode('/', trim($scriptDir, '/'));
    if (end($parts) === 'admin' || end($parts) === 'api') {
        array_pop($parts);
    }
    $basePath = empty($parts) ? '' : '/' . implode('/', $parts);
    define('BASE_URL', $protocol . $host . $basePath);
}
define('APP_URL', BASE_URL);
define('ROOT_PATH', dirname(__DIR__));

// Database Configuration - Explicit Driver Selection
// Local XAMPP/CLI environment uses local MariaDB (mysql)
// Production environment (demo.businesdoctor.com) stays strictly on SQLite
$defaultDriver = $isLocalHost ? 'mysql' : 'sqlite';
$driver = getenv('DB_DRIVER');
if ($isLocalHost && (!$driver || $driver === 'sqlite' || getenv('APP_ENV') === 'production')) {
    $driver = 'mysql';
}
if (!$driver) {
    $driver = $defaultDriver;
}
define('DB_DRIVER', strtolower(trim((string)$driver)));
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'businessdoctor');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', (getenv('DB_PASS') !== false && getenv('DB_PASS') !== null) ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');

$sqliteEnv = getenv('DB_SQLITE_PATH');
define('DB_SQLITE_PATH', !empty($sqliteEnv) ? (str_starts_with($sqliteEnv, '/') || str_contains($sqliteEnv, ':') ? $sqliteEnv : ROOT_PATH . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $sqliteEnv)) : ROOT_PATH . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'businessdoctor.sqlite');
