<?php
$baseUrl = 'http://127.0.0.1:8000';
$routes = ['/', '/services.php', '/audit.php', '/case-studies.php', '/insights.php', '/contact.php'];

echo "PAGE RESPONSE TIME BENCHMARK (10 iterations per route):\n";
foreach ($routes as $route) {
    $times = [];
    for ($i = 0; $i < 10; $i++) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . $route);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $start = microtime(true);
        curl_exec($ch);
        $duration = (microtime(true) - $start) * 1000;
        curl_close($ch);
        $times[] = $duration;
    }
    $avg = array_sum($times) / count($times);
    $min = min($times);
    $max = max($times);
    printf("  %-20s Avg: %5.1f ms | Min: %5.1f ms | Max: %5.1f ms\n", $route, $avg, $min, $max);
}

