<?php
/**
 * BusinessDoctor — Public Markdown Document Index Gateway
 * Serves machine-readable Markdown files for LLMs, AI agents, and web crawlers.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/seo-sync.php';

// Strict Markdown Content-Type Header
header('Content-Type: text/markdown; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('X-Robots-Tag: index, follow');
header('Cache-Control: public, max-age=3600');

$requestedFile = $_GET['file'] ?? '';

if (!empty($requestedFile)) {
    // Sanitize input and prevent directory traversal
    $cleanRelPath = ltrim(str_replace(['\\', '..'], ['/', ''], (string)$requestedFile), '/');
    if (!str_ends_with($cleanRelPath, '.md')) {
        $cleanRelPath .= '.md';
    }

    $realBase = realpath(__DIR__);
    $baseName = basename($cleanRelPath);

    // Candidate lookup locations inside /md
    $candidatePaths = [
        __DIR__ . '/' . $cleanRelPath,
        __DIR__ . '/services/' . $baseName,
        __DIR__ . '/insights/' . $baseName,
        __DIR__ . '/case-studies/' . $baseName,
    ];

    // Also check root files if requested (e.g. llms.md)
    if (defined('ROOT_PATH')) {
        $candidatePaths[] = ROOT_PATH . '/' . $baseName;
    }

    $resolvedFile = null;
    foreach ($candidatePaths as $candidate) {
        $realTarget = realpath($candidate);
        if ($realTarget !== false && is_file($realTarget)) {
            // Verify inside project directory
            $rootBase = defined('ROOT_PATH') ? realpath(ROOT_PATH) : $realBase;
            if (str_starts_with($realTarget, $rootBase) || str_starts_with($realTarget, $realBase)) {
                $resolvedFile = $realTarget;
                break;
            }
        }
    }

    // If candidate was not found on disk, trigger sync once in case of cold start
    if ($resolvedFile === null) {
        SeoSyncEngine::syncMarkdownFiles();
        foreach ($candidatePaths as $candidate) {
            $realTarget = realpath($candidate);
            if ($realTarget !== false && is_file($realTarget)) {
                $rootBase = defined('ROOT_PATH') ? realpath(ROOT_PATH) : $realBase;
                if (str_starts_with($realTarget, $rootBase) || str_starts_with($realTarget, $realBase)) {
                    $resolvedFile = $realTarget;
                    break;
                }
            }
        }
    }

    if ($resolvedFile !== null) {
        readfile($resolvedFile);
        exit;
    }

    // Genuine 404 for unlisted, draft, or nonexistent markdown content
    http_response_code(404);
    echo "# 404 Not Found\n\n";
    echo "The requested Markdown document `{$cleanRelPath}` does not exist or has been unpublished.\n\n";
    echo "Visit the master index at [" . SeoSyncEngine::getBaseUrl() . "/md](" . SeoSyncEngine::getBaseUrl() . "/md) to explore available public documents.\n";
    exit;
}

// Serve master markdown index (/md or /md/)
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
