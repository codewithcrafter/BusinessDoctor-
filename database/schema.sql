-- ============================================================
-- BUSINESSDOCTOR ENTERPRISE DATABASE SCHEMA (MySQL 8.0+)
-- IT Solutions & Digital Services Practice
-- Character Set: utf8mb4 / Collation: utf8mb4_unicode_ci
-- ============================================================

CREATE DATABASE IF NOT EXISTS `businessdoctor` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `businessdoctor`;

-- ------------------------------------------------------------
-- 1. Administrative Users Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(60) NOT NULL UNIQUE,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(120) NOT NULL,
    `role` VARCHAR(40) NOT NULL DEFAULT 'senior_consultant',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_username` (`username`),
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 2. Digital Audit & Project Assessment Requests Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `diagnostic_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `reference_no` VARCHAR(32) NOT NULL UNIQUE,
    `company_name` VARCHAR(150) NOT NULL,
    `contact_name` VARCHAR(120) NOT NULL,
    `work_email` VARCHAR(191) NOT NULL,
    `phone` VARCHAR(40) NULL,
    `website_url` VARCHAR(255) NULL,
    `revenue_bracket` VARCHAR(60) NOT NULL,
    `primary_bottleneck` VARCHAR(100) NOT NULL,
    `operating_model` VARCHAR(60) NOT NULL,
    `health_score` INT UNSIGNED NOT NULL DEFAULT 0,
    `diagnostic_summary` TEXT NULL,
    `status` ENUM('pending', 'in_review', 'prescribed', 'completed', 'archived') NOT NULL DEFAULT 'pending',
    `internal_notes` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`),
    INDEX `idx_created_at` (`created_at`),
    INDEX `idx_work_email` (`work_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 3. Contact Inquiries Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_inquiries` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(191) NOT NULL,
    `phone` VARCHAR(40) NULL,
    `organization` VARCHAR(150) NULL,
    `service_interest` VARCHAR(100) NOT NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('new', 'contacted', 'resolved', 'spam') NOT NULL DEFAULT 'new',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_status` (`status`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 4. Newsletter Subscribers Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `source_page` VARCHAR(100) DEFAULT 'homepage_footer',
    `ip_address` VARCHAR(45) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 5. Case Studies Table (Verified Client Success Stories)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `case_studies` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(120) NOT NULL UNIQUE,
    `title` VARCHAR(200) NOT NULL,
    `client_industry` VARCHAR(100) NOT NULL,
    `practice_area` VARCHAR(100) NOT NULL,
    `baseline_metric` VARCHAR(100) NOT NULL,
    `outcome_metric` VARCHAR(100) NOT NULL,
    `metric_label` VARCHAR(120) NOT NULL,
    `challenge` TEXT NOT NULL,
    `prescription` TEXT NOT NULL,
    `result_description` TEXT NOT NULL,
    `quote_text` TEXT NULL,
    `quote_author` VARCHAR(120) NULL,
    `quote_title` VARCHAR(120) NULL,
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_slug` (`slug`),
    INDEX `idx_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 6. Tech Insights & Articles Table
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `insights` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `category` VARCHAR(80) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `reading_time` VARCHAR(30) NOT NULL DEFAULT '6 min read',
    `summary` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `author_name` VARCHAR(120) NOT NULL,
    `author_title` VARCHAR(120) NOT NULL,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `published_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_slug` (`slug`),
    INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 7. Login Rate Limiting Table (Brute-Force Protection)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `login_rate_limits` (
    `ip_address` VARCHAR(45) NOT NULL PRIMARY KEY,
    `attempts` INT UNSIGNED NOT NULL DEFAULT 1,
    `last_attempt` DATETIME NOT NULL,
    `locked_until` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- INITIAL SEED DATA
-- Default Admin User (Password: "Admin@BusinessDoctor2026")
-- ------------------------------------------------------------
INSERT INTO `admin_users` (`username`, `email`, `password_hash`, `full_name`, `role`)
VALUES (
    'admin', 
    'leadership@businessdoctor.com', 
    '$2y$10$wT3WlXmPzD1W3yS7KkV1w.wG6VfGqE7ZJ3kM9qC7qA8rD2.l1t6kS', 
    'Managing Partner & Solutions Lead', 
    'managing_partner'
)
ON DUPLICATE KEY UPDATE `full_name` = VALUES(`full_name`);
