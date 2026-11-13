<?php
/**
 * BusinessDoctor — Public Markdown Document Index Gateway
 * Serves machine-readable Markdown files for LLMs, AI agents, and web crawlers.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/markdown-router.php';

// If called directly via /md/index.php?file=..., translate file to proper route
if (!empty($_GET['file'])) {
    $file = ltrim((string)$_GET['file'], '/');
    if (!str_ends_with($file, '.md')) {
        $file .= '.md';
    }
    MarkdownRouter::handleRequest('/md/' . $file);
} else {
    MarkdownRouter::handleRequest('/md');
}
