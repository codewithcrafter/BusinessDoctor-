<?php
/**
 * BusinessDoctor — Centralized SEO & Markdown Auto-Synchronization Regression Test Suite
 * Updated for the 10 Core Services and *-company-in-delhi canonical URL architecture.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/seo-sync.php';

class CentralizedSyncRegressionTest
{
    private array $results = [];
    private PDO $db;
    private ?int $createdBlogId = null;
    private ?string $createdBlogSlug = null;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function runAll(): void
    {
        echo "====================================================================\n";
        echo "STARTING CENTRALIZED SEO & MARKDOWN AUTO-SYNC REGRESSION TEST SUITE\n";
        echo "====================================================================\n\n";

        $this->verifyBaselineTenServices();
        $this->testScenario1_ServiceUrlStructure();
        $this->testScenario2_ServiceDescriptionEdit();
        $this->testScenario3_PublishNewBlog();
        $this->testScenario4_EditExistingBlog();
        $this->testScenario5_UnpublishBlog();
        $this->testScenario6_CaseStudyChange();
        $this->testScenario7_AboutPageUpdate();
        $this->testIdempotentSecondRegeneration();
        $this->printSummary();
    }

    private function assert(string $testName, bool $condition, string $detail = ''): void
    {
        if ($condition) {
            echo " [PASS] {$testName}\n";
            if ($detail) echo "        -> {$detail}\n";
            $this->results[] = ['name' => $testName, 'status' => 'PASS', 'detail' => $detail];
        } else {
            echo " [FAIL] {$testName}\n";
            if ($detail) echo "        -> ERROR: {$detail}\n";
            $this->results[] = ['name' => $testName, 'status' => 'FAIL', 'detail' => $detail];
        }
    }

    /**
     * Baseline check: All 10 core services are active and properly formed
     */
    private function verifyBaselineTenServices(): void
    {
        echo "--- Baseline Check: Ten Core Services Verification ---\n";
        $services = SeoSyncEngine::getActiveServices();
        $this->assert("Ten Core Services Active", count($services) === 10, "Active services count = " . count($services));

        $expectedSlugs = [
            'smo' => 'smo-company-in-delhi',
            'google-business-profile' => 'google-business-profile-company-in-delhi',
            'ppc-paid-ads' => 'ppc-company-in-delhi',
            'ecommerce-management' => 'ecommerce-management-company-in-delhi',
            'graphic-design' => 'graphic-design-company-in-delhi',
            'seo' => 'seo-company-in-delhi',
            'social-media-marketing' => 'social-media-marketing-company-in-delhi',
            'product-photography' => 'product-photography-company-in-delhi',
            'video-editing' => 'video-editing-company-in-delhi',
            'web-development' => 'web-development-company-in-delhi',
        ];

        foreach ($expectedSlugs as $slug => $expectedPattern) {
            $this->assert("Core Service [{$slug}] exists", isset($services[$slug]), "Found {$slug} in active services");
            $url = getServiceUrl($slug);
            $this->assert("Core Service [{$slug}] URL pattern", str_contains($url, $expectedPattern), "URL: {$url}");
        }
        echo "\n";
    }

    /**
     * Scenario 1: Verify all 10 *-company-in-delhi URLs propagate into manifests
     */
    private function testScenario1_ServiceUrlStructure(): void
    {
        echo "--- Scenario 1: Service URL *-company-in-delhi Propagation ---\n";
        SeoSyncEngine::syncAll("Regression Test Scenario 1: Baseline Propagation");

        $sitemap = file_get_contents(ROOT_PATH . '/sitemap.xml');
        $llmsTxt = file_get_contents(ROOT_PATH . '/llms.txt');
        $mdIndex = file_get_contents(ROOT_PATH . '/md/index.md');

        $this->assert("llms.md permanently removed", !file_exists(ROOT_PATH . '/llms.md'));

        $tenServices = [
            'smo' => 'https://demo.businesdoctor.com/smo-company-in-delhi',
            'google-business-profile' => 'https://demo.businesdoctor.com/google-business-profile-company-in-delhi',
            'ppc-paid-ads' => 'https://demo.businesdoctor.com/ppc-company-in-delhi',
            'ecommerce-management' => 'https://demo.businesdoctor.com/ecommerce-management-company-in-delhi',
            'graphic-design' => 'https://demo.businesdoctor.com/graphic-design-company-in-delhi',
            'seo' => 'https://demo.businesdoctor.com/seo-company-in-delhi',
            'social-media-marketing' => 'https://demo.businesdoctor.com/social-media-marketing-company-in-delhi',
            'product-photography' => 'https://demo.businesdoctor.com/product-photography-company-in-delhi',
            'video-editing' => 'https://demo.businesdoctor.com/video-editing-company-in-delhi',
            'web-development' => 'https://demo.businesdoctor.com/web-development-company-in-delhi',
        ];

        foreach ($tenServices as $slug => $expectedUrl) {
            $this->assert("Sitemap contains [{$expectedUrl}]", str_contains($sitemap, "<loc>{$expectedUrl}</loc>"), "Found in sitemap.xml");
            $this->assert("llms.txt contains [{$expectedUrl}]", str_contains($llmsTxt, "({$expectedUrl})"), "Found in llms.txt");
            $this->assert("md/index.md contains [{$expectedUrl}]", str_contains($mdIndex, "({$expectedUrl})"), "Found in md/index.md");
            $this->assert("Physical markdown exists [md/services/{$slug}.md]", file_exists(ROOT_PATH . "/md/services/{$slug}.md"), "Physical file verified");
        }

        // Strict assertion: Zero occurrences of stale /services/ or /company/ in manifests
        $this->assert("Zero stale /services/ in sitemap", !preg_match('#(?<!/md)/services/[a-zA-Z0-9_-]+(?!\.md)#', $sitemap));
        $this->assert("Zero stale /company/ in sitemap", !preg_match('#(?<!/md)/company/[a-zA-Z0-9_-]+#', $sitemap));
        $this->assert("Zero stale /services/ in llms.txt", !preg_match('#(?<!/md)/services/[a-zA-Z0-9_-]+(?!\.md)#', $llmsTxt));
        $this->assert("Zero stale /company/ in llms.txt", !preg_match('#(?<!/md)/company/[a-zA-Z0-9_-]+#', $llmsTxt));
        $this->assert("Zero stale /company/ in md/index.md", !preg_match('#(?<!/md)/company/[a-zA-Z0-9_-]+#', $mdIndex));
        echo "\n";
    }

    /**
     * Scenario 2: Service description edit propagation
     */
    private function testScenario2_ServiceDescriptionEdit(): void
    {
        echo "--- Scenario 2: Service Description Edit Propagation ---\n";
        $slug = 'web-development';
        $originalService = getPracticeBySlug($slug);
        $originalSummary = $originalService['summary'] ?? '';

        $testTag = " [TEST_MUTATION_" . bin2hex(random_bytes(3)) . "]";
        $newSummary = $originalSummary . $testTag;

        // Update summary in database
        $this->db->prepare("UPDATE services SET summary = ? WHERE slug = ?")->execute([$newSummary, $slug]);
        $sqlitePath = ROOT_PATH . '/database/businessdoctor.sqlite';
        if (file_exists($sqlitePath)) {
            $sq = new PDO('sqlite:' . $sqlitePath);
            $sq->prepare("UPDATE services SET summary = ? WHERE slug = ?")->execute([$newSummary, $slug]);
        }

        // Trigger synchronization
        SeoSyncEngine::syncDependenciesFor('service', $slug);

        $llmsTxt = file_get_contents(ROOT_PATH . '/llms.txt');

        $this->assert("Updated service summary propagated to llms.txt", str_contains($llmsTxt, $testTag), "Found mutation in llms.txt");

        // Restore original summary
        $this->db->prepare("UPDATE services SET summary = ? WHERE slug = ?")->execute([$originalSummary, $slug]);
        if (file_exists($sqlitePath)) {
            $sq->prepare("UPDATE services SET summary = ? WHERE slug = ?")->execute([$originalSummary, $slug]);
        }
        SeoSyncEngine::syncDependenciesFor('service', $slug);

        $llmsTxtRestored = file_get_contents(ROOT_PATH . '/llms.txt');
        $this->assert("Service summary mutation cleanly reverted", !str_contains($llmsTxtRestored, $testTag), "Clean reversion confirmed");
        echo "\n";
    }

    /**
     * Scenario 3: Publish new blog article
     */
    private function testScenario3_PublishNewBlog(): void
    {
        echo "--- Scenario 3: Publish New Blog Article ---\n";
        $testSlug = 'automated-test-blog-' . time();
        $testTitle = 'Automated Test Blog Post for SEO Sync';

        // Insert new blog into MySQL and SQLite
        $stmt = $this->db->prepare("
            INSERT INTO insights (title, slug, author_name, author_title, category, summary, content, status, published_at, is_deleted, created_at, updated_at)
            VALUES (?, ?, 'BusinessDoctor Engineering', 'Principal Technical Lead', 'Technology', 'Test summary for automated sync verification.', '<p>Test blog article content body for verification.</p>', 'published', NOW(), 0, NOW(), NOW())
        ");
        $stmt->execute([$testTitle, $testSlug]);
        $newId = (int)$this->db->lastInsertId();

        $sqlitePath = ROOT_PATH . '/database/businessdoctor.sqlite';
        if (file_exists($sqlitePath)) {
            $sq = new PDO('sqlite:' . $sqlitePath);
            $sq->prepare("
                INSERT INTO insights (id, title, slug, author_name, author_title, category, summary, content, status, published_at, is_deleted, created_at, updated_at)
                VALUES (?, ?, ?, 'BusinessDoctor Engineering', 'Principal Technical Lead', 'Technology', 'Test summary for automated sync verification.', '<p>Test blog article content body for verification.</p>', 'published', datetime('now'), 0, datetime('now'), datetime('now'))
            ")->execute([$newId, $testTitle, $testSlug]);
        }

        SeoSyncEngine::syncDependenciesFor('blog', $testSlug);

        $sitemap = file_get_contents(ROOT_PATH . '/sitemap.xml');
        $llmsTxt = file_get_contents(ROOT_PATH . '/llms.txt');
        $mdFile = ROOT_PATH . "/md/insights/{$testSlug}.md";

        $expectedBlogUrl = "https://demo.businesdoctor.com/blog/{$testSlug}";
        $this->assert("New blog in sitemap.xml", str_contains($sitemap, "<loc>{$expectedBlogUrl}</loc>"));
        $this->assert("New blog in llms.txt", str_contains($llmsTxt, "({$expectedBlogUrl})"));
        $this->assert("New blog physical markdown generated", file_exists($mdFile));

        // Store newId and slug for Scenarios 4 & 5
        $this->createdBlogId = $newId;
        $this->createdBlogSlug = $testSlug;
        echo "\n";
    }

    /**
     * Scenario 4: Edit existing blog article
     */
    private function testScenario4_EditExistingBlog(): void
    {
        echo "--- Scenario 4: Edit Existing Blog Article ---\n";
        if (!$this->createdBlogId) {
            echo " [SKIP] No test blog available\n";
            return;
        }

        $editMarker = " [EDITED_MARKER_" . bin2hex(random_bytes(2)) . "]";
        $updatedTitle = "Automated Test Blog Post" . $editMarker;

        $this->db->prepare("UPDATE insights SET title = ? WHERE id = ?")->execute([$updatedTitle, $this->createdBlogId]);
        $sqlitePath = ROOT_PATH . '/database/businessdoctor.sqlite';
        if (file_exists($sqlitePath)) {
            $sq = new PDO('sqlite:' . $sqlitePath);
            $sq->prepare("UPDATE insights SET title = ? WHERE id = ?")->execute([$updatedTitle, $this->createdBlogId]);
        }

        SeoSyncEngine::syncDependenciesFor('blog', $this->createdBlogSlug);

        $llmsTxt = file_get_contents(ROOT_PATH . '/llms.txt');
        $mdFile = ROOT_PATH . "/md/insights/{$this->createdBlogSlug}.md";
        $mdContent = file_exists($mdFile) ? file_get_contents($mdFile) : '';

        $this->assert("Edited blog title in llms.txt", str_contains($llmsTxt, $editMarker));
        $this->assert("Edited blog title in physical markdown", str_contains($mdContent, $editMarker));
        echo "\n";
    }

    /**
     * Scenario 5: Unpublish blog article (draft/deleted)
     */
    private function testScenario5_UnpublishBlog(): void
    {
        echo "--- Scenario 5: Unpublish Blog Article ---\n";
        if (!$this->createdBlogId) {
            echo " [SKIP] No test blog available\n";
            return;
        }

        // Set status to draft
        $this->db->prepare("UPDATE insights SET status = 'draft' WHERE id = ?")->execute([$this->createdBlogId]);
        $sqlitePath = ROOT_PATH . '/database/businessdoctor.sqlite';
        if (file_exists($sqlitePath)) {
            $sq = new PDO('sqlite:' . $sqlitePath);
            $sq->prepare("UPDATE insights SET status = 'draft' WHERE id = ?")->execute([$this->createdBlogId]);
        }

        SeoSyncEngine::syncDependenciesFor('blog', $this->createdBlogSlug);

        $sitemap = file_get_contents(ROOT_PATH . '/sitemap.xml');
        $llmsTxt = file_get_contents(ROOT_PATH . '/llms.txt');
        $mdFile = ROOT_PATH . "/md/insights/{$this->createdBlogSlug}.md";

        $expectedBlogUrl = "https://demo.businesdoctor.com/blog/{$this->createdBlogSlug}";
        $this->assert("Unpublished blog removed from sitemap.xml", !str_contains($sitemap, $expectedBlogUrl));
        $this->assert("Unpublished blog removed from llms.txt", !str_contains($llmsTxt, $expectedBlogUrl));
        $this->assert("Unpublished blog physical markdown purged", !file_exists($mdFile));

        // Delete test record completely
        $this->db->prepare("DELETE FROM insights WHERE id = ?")->execute([$this->createdBlogId]);
        if (file_exists($sqlitePath)) {
            $sq->prepare("DELETE FROM insights WHERE id = ?")->execute([$this->createdBlogId]);
        }
        SeoSyncEngine::syncAll("Cleanup test blog");
        echo "\n";
    }

    /**
     * Scenario 6: Case study change propagation
     */
    private function testScenario6_CaseStudyChange(): void
    {
        echo "--- Scenario 6: Case Study Change Propagation ---\n";
        $cases = SeoSyncEngine::getPublishedCaseStudies();
        if (empty($cases)) {
            echo " [SKIP] No published case study\n";
            return;
        }
        $c = $cases[0];
        $slug = $c['slug'];
        $expectedUrl = "https://demo.businesdoctor.com/case-studies/{$slug}";

        $sitemap = file_get_contents(ROOT_PATH . '/sitemap.xml');
        $llmsTxt = file_get_contents(ROOT_PATH . '/llms.txt');
        $mdFile = ROOT_PATH . "/md/case-studies/{$slug}.md";

        $this->assert("Case study URL pattern in sitemap", str_contains($sitemap, "<loc>{$expectedUrl}</loc>"));
        $this->assert("Case study URL pattern in llms.txt", str_contains($llmsTxt, "({$expectedUrl})"));
        $this->assert("Case study physical markdown exists", file_exists($mdFile));
        echo "\n";
    }

    /**
     * Scenario 7: About page update verification
     */
    private function testScenario7_AboutPageUpdate(): void
    {
        echo "--- Scenario 7: About Page Update & Mirror Verification ---\n";
        $aboutMd = ROOT_PATH . '/md/about.md';
        $this->assert("Physical md/about.md exists", file_exists($aboutMd));

        $content = file_get_contents($aboutMd);
        $this->assert("About markdown has substantial content (> 3000 bytes)", strlen($content) > 3000, "Size = " . strlen($content) . " bytes");
        $this->assert("About markdown contains canonical link", str_contains($content, 'https://demo.businesdoctor.com/about.php'));
        echo "\n";
    }

    /**
     * Second regeneration: Confirms idempotency and stability
     */
    private function testIdempotentSecondRegeneration(): void
    {
        echo "--- Idempotent Second Regeneration Verification ---\n";
        // Trigger second regeneration
        $res = SeoSyncEngine::syncAll("Second Regeneration Idempotency Verification");
        $this->assert("Second regeneration status success", $res['status'] === 'success');

        // Check that core content did not drift
        $sitemap2 = file_get_contents(ROOT_PATH . '/sitemap.xml');
        $this->assert("Second sitemap contains all 10 services", substr_count($sitemap2, '-company-in-delhi') >= 10);

        $llmsTxt2 = file_get_contents(ROOT_PATH . '/llms.txt');
        $this->assert("Second llms.txt preserves canonical service URLs", substr_count($llmsTxt2, '-company-in-delhi') >= 10);
        $this->assert("Second regeneration does not recreate llms.md", !file_exists(ROOT_PATH . '/llms.md'));
        echo "\n";
    }

    private function printSummary(): void
    {
        $total = count($this->results);
        $passed = count(array_filter($this->results, fn($r) => $r['status'] === 'PASS'));
        $failed = $total - $passed;

        echo "====================================================================\n";
        echo "REGRESSION TEST SUITE SUMMARY\n";
        echo "====================================================================\n";
        echo "TOTAL TESTS: {$total}\n";
        echo "PASSED:      {$passed}\n";
        echo "FAILED:      {$failed}\n";
        echo "RESULT:      " . ($failed === 0 ? "ALL SCENARIOS PASSED WITH 100% SUCCESS!" : "FAILURES DETECTED") . "\n";
        echo "====================================================================\n";
    }
}

$test = new CentralizedSyncRegressionTest();
$test->runAll();
