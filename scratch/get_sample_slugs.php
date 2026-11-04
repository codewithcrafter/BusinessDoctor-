<?php
require_once __DIR__ . '/../includes/db.php';
$pdo = Database::getConnection();
foreach (['case_studies', 'insights', 'posts'] as $t) {
    try {
        $stmt = $pdo->query("SELECT slug FROM $t LIMIT 3");
        $slugs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "$t: " . implode(', ', $slugs) . PHP_EOL;
    } catch (Exception $e) {
        echo "$t error: " . $e->getMessage() . PHP_EOL;
    }
}

