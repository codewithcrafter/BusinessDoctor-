<?php
/**
 * BusinessDoctor CMS Migration Script
 * Safe, idempotent migration for SQLite & MySQL
 * Preserves all existing records and backfills new fields
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

echo "=== BUSINESSDOCTOR CMS DATABASE MIGRATION ===\n";

try {
    $pdo = Database::getConnection();
    $driver = Database::getDriver();
    echo "Active Driver: $driver\n";

    // 1. Ensure Media Table Exists
    echo "\n1. Checking 'media' table...\n";
    if ($driver === 'sqlite') {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS media (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                filename TEXT NOT NULL,
                original_name TEXT NOT NULL,
                file_path TEXT NOT NULL,
                file_size INTEGER NOT NULL,
                mime_type TEXT NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ");
    } else {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `media` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `filename` VARCHAR(255) NOT NULL,
                `original_name` VARCHAR(255) NOT NULL,
                `file_path` VARCHAR(255) NOT NULL,
                `file_size` INT UNSIGNED NOT NULL,
                `mime_type` VARCHAR(60) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }
    echo "   'media' table ready.\n";

    // Helper to get existing columns
    $getTableColumns = function(PDO $pdo, string $table, string $driver): array {
        $columns = [];
        if ($driver === 'sqlite') {
            $stmt = $pdo->query("PRAGMA table_info({$table})");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $columns[] = strtolower($row['name']);
            }
        } else {
            $stmt = $pdo->query("SHOW COLUMNS FROM `{$table}`");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $columns[] = strtolower($row['Field']);
            }
        }
        return $columns;
    };

    // 2. Migrate 'insights' Table
    echo "\n2. Migrating 'insights' table columns...\n";
    $insightCols = $getTableColumns($pdo, 'insights', $driver);
    
    $insightNewCols = [
        'excerpt' => 'TEXT NULL',
        'featured_image' => 'TEXT NULL',
        'cover_image_alt' => 'TEXT NULL',
        'author' => 'TEXT NULL',
        'tags' => 'TEXT NULL',
        'seo_title' => 'TEXT NULL',
        'seo_description' => 'TEXT NULL',
        'status' => "TEXT NOT NULL DEFAULT 'published'",
        'created_at' => 'TEXT NULL',
        'updated_at' => 'TEXT NULL',
        'deleted_at' => 'TEXT NULL',
        'is_deleted' => 'INTEGER NOT NULL DEFAULT 0',
    ];

    foreach ($insightNewCols as $col => $type) {
        if (!in_array(strtolower($col), $insightCols, true)) {
            echo "   Adding column '$col' to 'insights'...\n";
            $pdo->exec("ALTER TABLE insights ADD COLUMN {$col} {$type}");
        }
    }

    // Backfill insights data
    $pdo->exec("
        UPDATE insights SET
            author = CASE WHEN author IS NULL OR author = '' THEN author_name ELSE author END,
            excerpt = CASE WHEN excerpt IS NULL OR excerpt = '' THEN summary ELSE excerpt END,
            seo_title = CASE WHEN seo_title IS NULL OR seo_title = '' THEN title ELSE seo_title END,
            seo_description = CASE WHEN seo_description IS NULL OR seo_description = '' THEN summary ELSE seo_description END,
            status = CASE WHEN is_published = 1 THEN 'published' ELSE 'draft' END,
            created_at = CASE WHEN created_at IS NULL THEN published_at ELSE created_at END,
            updated_at = CASE WHEN updated_at IS NULL THEN published_at ELSE updated_at END,
            is_deleted = 0
        WHERE is_deleted IS NULL OR status IS NULL OR author IS NULL OR excerpt IS NULL
    ");
    echo "   'insights' columns verified and existing records backfilled.\n";

    // 3. Migrate 'case_studies' Table
    echo "\n3. Migrating 'case_studies' table columns...\n";
    $caseCols = $getTableColumns($pdo, 'case_studies', $driver);

    $caseNewCols = [
        'client_name' => 'TEXT NULL',
        'industry' => 'TEXT NULL',
        'service_category' => 'TEXT NULL',
        'project_summary' => 'TEXT NULL',
        'solution' => 'TEXT NULL',
        'implementation' => 'TEXT NULL',
        'results' => 'TEXT NULL',
        'featured_image' => 'TEXT NULL',
        'cover_image_alt' => 'TEXT NULL',
        'gallery' => 'TEXT NULL',
        'seo_title' => 'TEXT NULL',
        'seo_description' => 'TEXT NULL',
        'status' => "TEXT NOT NULL DEFAULT 'published'",
        'published_at' => 'TEXT NULL',
        'updated_at' => 'TEXT NULL',
        'deleted_at' => 'TEXT NULL',
        'is_deleted' => 'INTEGER NOT NULL DEFAULT 0',
    ];

    foreach ($caseNewCols as $col => $type) {
        if (!in_array(strtolower($col), $caseCols, true)) {
            echo "   Adding column '$col' to 'case_studies'...\n";
            $pdo->exec("ALTER TABLE case_studies ADD COLUMN {$col} {$type}");
        }
    }

    // Backfill case_studies data
    $pdo->exec("
        UPDATE case_studies SET
            industry = CASE WHEN industry IS NULL OR industry = '' THEN client_industry ELSE industry END,
            service_category = CASE WHEN service_category IS NULL OR service_category = '' THEN practice_area ELSE service_category END,
            project_summary = CASE WHEN project_summary IS NULL OR project_summary = '' THEN challenge ELSE project_summary END,
            solution = CASE WHEN solution IS NULL OR solution = '' THEN prescription ELSE solution END,
            results = CASE WHEN results IS NULL OR results = '' THEN result_description ELSE results END,
            seo_title = CASE WHEN seo_title IS NULL OR seo_title = '' THEN title ELSE seo_title END,
            seo_description = CASE WHEN seo_description IS NULL OR seo_description = '' THEN substr(challenge, 1, 160) ELSE seo_description END,
            status = 'published',
            published_at = CASE WHEN published_at IS NULL THEN created_at ELSE published_at END,
            updated_at = CASE WHEN updated_at IS NULL THEN created_at ELSE updated_at END,
            is_deleted = 0
        WHERE is_deleted IS NULL OR status IS NULL OR industry IS NULL OR solution IS NULL
    ");

    // Client names backfill for existing 3 case studies
    $pdo->exec("UPDATE case_studies SET client_name = 'PayGuard Technologies' WHERE slug = 'fintech-saas-funnel-resuscitation' AND (client_name IS NULL OR client_name = '')");
    $pdo->exec("UPDATE case_studies SET client_name = 'AURA Atelier' WHERE slug = 'd2c-apparel-vital-infrastructure-overhaul' AND (client_name IS NULL OR client_name = '')");
    $pdo->exec("UPDATE case_studies SET client_name = 'Apex Industrial' WHERE slug = 'multichannel-retail-marketplace-dominance' AND (client_name IS NULL OR client_name = '')");

    echo "   'case_studies' columns verified and existing records backfilled.\n";

    // 4. Verify Record Counts
    echo "\n4. Verifying record counts after migration:\n";
    $diag = $pdo->query("SELECT COUNT(*) FROM diagnostic_requests")->fetchColumn();
    $contacts = $pdo->query("SELECT COUNT(*) FROM contact_inquiries")->fetchColumn();
    $subs = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers")->fetchColumn();
    $insightsCount = $pdo->query("SELECT COUNT(*) FROM insights WHERE is_deleted = 0")->fetchColumn();
    $casesCount = $pdo->query("SELECT COUNT(*) FROM case_studies WHERE is_deleted = 0")->fetchColumn();
    $adminCount = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();

    echo "   admin_users: $adminCount\n";
    echo "   insights: $insightsCount (published: " . $pdo->query("SELECT COUNT(*) FROM insights WHERE status = 'published'")->fetchColumn() . ")\n";
    echo "   case_studies: $casesCount (published: " . $pdo->query("SELECT COUNT(*) FROM case_studies WHERE status = 'published'")->fetchColumn() . ")\n";
    echo "   diagnostic_requests: $diag\n";
    echo "   contact_inquiries: $contacts\n";
    echo "   newsletter_subscribers: $subs\n";

    echo "\n=== MIGRATION COMPLETED SUCCESSFULLY ===\n";

} catch (Throwable $e) {
    echo "MIGRATION FAILED: " . $e->getMessage() . "\n";
    exit(1);
}

