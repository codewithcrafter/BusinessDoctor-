<?php
/**
 * BusinessDoctor — Public Markdown Document Index Gateway
 * Serves machine-readable Markdown files for LLMs, AI agents, and web crawlers.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/seo-sync.php';

header('Content-Type: text/markdown; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('X-Robots-Tag: index, follow');
header('Cache-Control: public, max-age=3600');

$requestedFile = $_GET['file'] ?? '';

if (!empty($requestedFile)) {
    // Sanitize and resolve file path
    $cleanRelPath = ltrim(str_replace(['\\', '..'], ['/', ''], (string)$requestedFile), '/');
    if (!str_ends_with($cleanRelPath, '.md')) {
        $cleanRelPath .= '.md';
    }
    
    $fullPath = __DIR__ . '/' . $cleanRelPath;
    $realBase = realpath(__DIR__);
    $realTarget = realpath($fullPath);

    if ($realTarget !== false && str_starts_with($realTarget, $realBase) && is_file($realTarget)) {
        readfile($realTarget);
        exit;
    }

    http_response_code(404);
    echo "# 404 Not Found\n\n";
    echo "The requested Markdown document `{$cleanRelPath}` does not exist or has been unpublished.\n\n";
    echo "Visit the master index at [" . SeoSyncEngine::getBaseUrl() . "/md](" . SeoSyncEngine::getBaseUrl() . "/md) to explore available public documents.\n";
    exit;
}

// Serve master markdown index
$masterIndexPath = __DIR__ . '/index.md';
if (!file_exists($masterIndexPath)) {
    SeoSyncEngine::syncMarkdownFiles();
}

if (file_exists($masterIndexPath)) {
    readfile($masterIndexPath);
} else {
    echo SeoSyncEngine::generateMdMasterIndex();
}
exit;
