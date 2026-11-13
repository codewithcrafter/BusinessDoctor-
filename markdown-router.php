<?php
/**
 * BusinessDoctor — Markdown Gateway Dispatcher
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/markdown-router.php';
MarkdownRouter::handleRequest();
