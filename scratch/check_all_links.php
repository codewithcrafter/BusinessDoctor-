<?php
/**
 * Link Crawler & Broken Link Detection Script
 */

$baseUrl = 'http://127.0.0.1:8000';
$visited = [];
$toVisit = ['/'];
$brokenLinks = [];

while (!empty($toVisit)) {
    $current = array_shift($toVisit);
    if (isset($visited[$current])) continue;
    $visited[$current] = true;

    $url = $baseUrl . $current;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code !== 200) {
        $brokenLinks[] = ['url' => $current, 'code' => $code];
        continue;
    }

    // Extract all links
    preg_match_all('/href="([^"#][^"]*)"/i', $html, $matches);
    foreach ($matches[1] as $href) {
        // Skip external links, mailto, tel, javascript, data URIs
        if (preg_match('/^(https?:\/\/|mailto:|tel:|javascript:|data:)/i', $href)) {
            continue;
        }
        // Normalize relative path
        if (strpos($href, '/') !== 0) {
            $href = '/' . $href;
        }
        // Exclude admin pages from public crawler (they require auth)
        if (strpos($href, '/admin/') === 0) {
            continue;
        }
        if (!isset($visited[$href]) && !in_array($href, $toVisit)) {
            $toVisit[] = $href;
        }
    }
}

echo "Visited " . count($visited) . " unique internal pages.\n";
if (empty($brokenLinks)) {
    echo "NO BROKEN LINKS FOUND! All tested internal links returned HTTP 200.\n";
} else {
    echo "Found " . count($brokenLinks) . " broken links:\n";
    foreach ($brokenLinks as $b) {
        echo "  - {$b['url']} (HTTP {$b['code']})\n";
    }
}
