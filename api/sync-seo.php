<?php
/**
 * Direct Live SEO & LLM Synchronization Trigger
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo-sync.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

$result = SeoSyncEngine::syncAll("Production LLM Domain Correction Sync");
echo json_encode([
    'status' => 'success',
    'base_url' => SeoSyncEngine::getBaseUrl(),
    'files' => $result['files'] ?? [],
    'duration_ms' => $result['duration_ms'] ?? 0
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);