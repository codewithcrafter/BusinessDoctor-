<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
$pdo = Database::getConnection();
$cs = $pdo->query('SELECT slug FROM case_studies LIMIT 5')->fetchAll(PDO::FETCH_COLUMN);
$ins = $pdo->query('SELECT slug FROM insights LIMIT 5')->fetchAll(PDO::FETCH_COLUMN);
echo "Case studies: " . json_encode($cs) . "\n";
echo "Insights: " . json_encode($ins) . "\n";
