<?php
/**
 * BusinessDoctor — Centralized SEO Schema Renderer
 * Queries, validates, dynamically binds, and outputs Schema.org JSON-LD scripts in public pages.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

/**
 * Return list of all natively supported pages for Schema Management
 */
function getSupportedSchemaPages(): array
{
    return [
        'home' => [
            'name' => 'Homepage',
            'url' => '/',
            'recommended_types' => ['Organization', 'WebSite'],
            'is_dynamic' => false
        ],
        'about' => [
            'name' => 'About Us',
            'url' => '/about.php',
            'recommended_types' => ['AboutPage', 'BreadcrumbList'],
            'is_dynamic' => false
        ],
        'services' => [
            'name' => 'IT Services Portfolio',
            'url' => '/services.php',
            'recommended_types' => ['ProfessionalService', 'BreadcrumbList'],
            'is_dynamic' => false
        ],
        'service-detail' => [
            'name' => 'Individual Service Pages',
            'url' => '/services/{slug}',
            'recommended_types' => ['Service', 'BreadcrumbList'],
            'is_dynamic' => true
        ],
        'diagnostic' => [
            'name' => 'Digital Architecture Audit',
            'url' => '/diagnostic.php',
            'recommended_types' => ['WebPage'],
            'is_dynamic' => false
        ],
        'case-studies' => [
            'name' => 'Case Studies Listing',
            'url' => '/case-studies.php',
            'recommended_types' => ['WebPage', 'BreadcrumbList'],
            'is_dynamic' => false
        ],
        'case-study-detail' => [
            'name' => 'Individual Case Study Pages',
            'url' => '/case-studies/{slug}',
            'recommended_types' => ['Article', 'BreadcrumbList'],
            'is_dynamic' => true
        ],
        'insights' => [
            'name' => 'Perspectives & Blog Listing',
            'url' => '/insights.php',
            'recommended_types' => ['WebPage', 'BreadcrumbList'],
            'is_dynamic' => false
        ],
        'insight-detail' => [
            'name' => 'Individual Blog Articles',
            'url' => '/insights/{slug}',
            'recommended_types' => ['BlogPosting', 'BreadcrumbList'],
            'is_dynamic' => true
        ],
        'contact' => [
            'name' => 'Contact Us',
            'url' => '/contact.php',
            'recommended_types' => ['ContactPage'],
            'is_dynamic' => false
        ]
    ];
}

/**
 * Detect page_key from current request if not explicitly provided
 */
function detectCurrentPageKey(): string
{
    // Check clean route paths first
    $reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($reqPath !== null) {
        if (preg_match('#^/services/([a-zA-Z0-9_-]+)#', $reqPath)) {
            return 'service-detail';
        }
        if (preg_match('#^/case-studies/([a-zA-Z0-9_-]+)#', $reqPath)) {
            return 'case-study-detail';
        }
        if (preg_match('#^/(?:insights|blogs)/([a-zA-Z0-9_-]+)#', $reqPath)) {
            return 'insight-detail';
        }
    }

    $script = basename($_SERVER['SCRIPT_NAME'] ?? '');
    
    switch ($script) {
        case 'index.php':
            return 'home';
        case 'about.php':
            return 'about';
        case 'services.php':
            return 'services';
        case 'service-detail.php':
            return 'service-detail';
        case 'diagnostic.php':
        case 'audit.php':
            return 'diagnostic';
        case 'case-studies.php':
            return 'case-studies';
        case 'case-study-detail.php':
            return 'case-study-detail';
        case 'insights.php':
        case 'blog.php':
            return 'insights';
        case 'insight-detail.php':
        case 'blog-detail.php':
            return 'insight-detail';
        case 'contact.php':
            return 'contact';
        default:
            return preg_replace('/\.php$/', '', $script) ?: 'home';
    }
}

/**
 * Extract FAQ pairs from HTML content if present
 * Detects questions ending with '?' or under FAQ headings followed by answers
 */
function extractFaqsFromContent(string $html): array
{
    $faqs = [];
    if (empty(trim($html))) {
        return $faqs;
    }

    // Pattern 1: Structured FAQ items (e.g. class="faq-question" and "faq-answer")
    if (preg_match_all('/class=["\'][^"\']*faq-question[^"\']*["\'][^>]*>(.*?)<\/[^>]+>[\s\S]*?class=["\'][^"\']*faq-answer[^"\']*["\'][^>]*>(.*?)<\/[^>]+>/i', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $q = trim(strip_tags($m[1]));
            $a = trim(strip_tags($m[2]));
            if (!empty($q) && !empty($a)) {
                $faqs[] = ['question' => $q, 'answer' => $a];
            }
        }
    }

    // Pattern 2: Headings (H2, H3, H4) ending in '?' or containing 'FAQ' followed by a paragraph
    if (empty($faqs)) {
        if (preg_match_all('/<(h[2-4])[^>]*>(.*?\?.*?)<\/\1>\s*<p[^>]*>(.*?)<\/p>/is', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $q = trim(strip_tags($m[2]));
                $a = trim(strip_tags($m[3]));
                if (!empty($q) && !empty($a) && mb_strlen($q) > 8 && mb_strlen($a) > 15) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }
    }

    // Pattern 3: Definition list FAQ items (<dt>Question?</dt><dd>Answer</dd>)
    if (empty($faqs)) {
        if (preg_match_all('/<dt[^>]*>(.*?)<\/dt>\s*<dd[^>]*>(.*?)<\/dd>/is', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $q = trim(strip_tags($m[1]));
                $a = trim(strip_tags($m[2]));
                if (!empty($q) && !empty($a)) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }
    }

    // Pattern 4: HTML details/summary FAQs
    if (empty($faqs)) {
        if (preg_match_all('/<summary[^>]*>(.*?)<\/summary>\s*(?:<div[^>]*>)?\s*(?:<p[^>]*>)?(.*?)(?:<\/p>)?\s*(?:<\/div>)?\s*<\/details>/is', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $q = trim(strip_tags($m[1]));
                $a = trim(strip_tags($m[2]));
                if (!empty($q) && !empty($a)) {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }
    }

    return $faqs;
}

/**
 * Generate complete Schema.org JSON-LD Graph for Insight Articles
 * Generates BlogPosting, BreadcrumbList, Organization, and FAQPage (if FAQs exist)
 */
function generateArticleSchemaGraph(array $article, string $baseUrl = ''): array
{
    $baseUrl = rtrim($baseUrl ?: (defined('BASE_URL') ? BASE_URL : 'https://businessdoctor.com'), '/');
    $parsedHost = parse_url($baseUrl, PHP_URL_HOST);
    if (empty($parsedHost) || in_array($parsedHost, ['localhost', '127.0.0.1', '::1', '0.0.0.0'], true) || str_ends_with($parsedHost, '.local')) {
        $baseUrl = 'https://businessdoctor.com';
    }
    $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';

    $slug = $article['slug'] ?? '';
    $articleUrl = !empty($article['canonical_url']) ? $article['canonical_url'] : ($baseUrl . '/insights/' . rawurlencode($slug));

    $title = !empty($article['seo_title']) ? $article['seo_title'] : ($article['title'] ?? 'Insight Article');
    $description = !empty($article['seo_description']) ? $article['seo_description'] : (!empty($article['excerpt']) ? $article['excerpt'] : ($article['summary'] ?? ''));
    $authorName = !empty($article['author_name']) ? $article['author_name'] : (!empty($article['author']) ? $article['author'] : 'BusinessDoctor Expert');
    $authorTitle = !empty($article['author_title']) ? $article['author_title'] : 'Senior Consultant';
    $authorBio = !empty($article['author_bio']) ? $article['author_bio'] : '';

    $rawPub = !empty($article['published_at']) ? $article['published_at'] : (!empty($article['created_at']) ? $article['created_at'] : 'now');
    $rawMod = !empty($article['updated_at']) ? $article['updated_at'] : $rawPub;
    $datePublished = date('c', strtotime((string)$rawPub));
    $dateModified = date('c', strtotime((string)$rawMod));

    $featuredImg = !empty($article['featured_image']) ? $article['featured_image'] : '';
    if (!empty($featuredImg)) {
        if (!preg_match('/^https?:\/\//i', $featuredImg)) {
            $featuredImg = $baseUrl . '/' . ltrim($featuredImg, '/');
        }
    } else {
        $featuredImg = $baseUrl . '/assets/img/og-preview.svg';
    }

    $rawTags = !empty($article['tags']) ? $article['tags'] : '';
    $tagsArr = array_filter(array_map('trim', explode(',', (string)$rawTags)));
    $keywords = !empty($tagsArr) ? implode(', ', $tagsArr) : 'IT Strategy, Software Engineering, Enterprise Consulting';

    // 1. BlogPosting Schema
    $blogPosting = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        '@id' => $articleUrl . '#article',
        'isPartOf' => [
            '@type' => 'WebSite',
            '@id' => $baseUrl . '/#website',
            'name' => $appName,
            'url' => $baseUrl . '/'
        ],
        'headline' => $title,
        'description' => $description,
        'inLanguage' => 'en-US',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $articleUrl
        ],
        'url' => $articleUrl,
        'datePublished' => $datePublished,
        'dateModified' => $dateModified,
        'articleSection' => $article['category'] ?? 'Enterprise Insights',
        'keywords' => $keywords,
        'wordCount' => str_word_count(strip_tags($article['content'] ?? '')),
        'image' => [
            '@type' => 'ImageObject',
            'url' => $featuredImg,
            'caption' => !empty($article['cover_image_alt']) ? $article['cover_image_alt'] : $title
        ],
        'author' => [
            '@type' => 'Person',
            '@id' => $baseUrl . '/#author-' . preg_replace('/[^a-z0-9]+/i', '-', strtolower($authorName)),
            'name' => $authorName,
            'jobTitle' => $authorTitle
        ],
        'publisher' => [
            '@type' => 'Organization',
            '@id' => $baseUrl . '/#organization',
            'name' => $appName,
            'url' => $baseUrl . '/',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/bdr-logo.png'
            ]
        ]
    ];
    if (!empty($authorBio)) {
        $blogPosting['author']['description'] = $authorBio;
    }

    // 2. BreadcrumbList Schema
    $breadcrumbs = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $baseUrl . '/'
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Insights & Perspectives',
                'item' => $baseUrl . '/insights.php'
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $title,
                'item' => $articleUrl
            ]
        ]
    ];

    // 3. Organization Authority Schema
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => $baseUrl . '/#organization',
        'name' => $appName,
        'url' => $baseUrl . '/',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $baseUrl . '/assets/img/bdr-logo.png'
        ]
    ];

    // 4. Person (Author) Schema
    $person = [
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        '@id' => $baseUrl . '/#author-' . preg_replace('/[^a-z0-9]+/i', '-', strtolower($authorName)),
        'name' => $authorName,
        'jobTitle' => $authorTitle,
        'worksFor' => [
            '@type' => 'Organization',
            '@id' => $baseUrl . '/#organization',
            'name' => $appName,
            'url' => $baseUrl . '/'
        ]
    ];
    if (!empty($authorBio)) {
        $person['description'] = $authorBio;
    }

    $schemas = [
        'BlogPosting' => $blogPosting,
        'BreadcrumbList' => $breadcrumbs,
        'Organization' => $organization,
        'Person' => $person
    ];

    // 4. FAQPage Schema — ONLY IF FAQs EXIST IN CONTENT!
    $faqs = extractFaqsFromContent($article['content'] ?? '');
    if (!empty($faqs)) {
        $faqItems = [];
        foreach ($faqs as $faq) {
            $faqItems[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        $schemas['FAQPage'] = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems
        ];
    }

    return $schemas;
}

/**
 * Generate complete Schema.org JSON-LD Graph for Case Studies
 * Generates Article, BreadcrumbList, Organization, and FAQPage (if FAQs exist)
 */
function generateCaseStudySchemaGraph(array $case, string $baseUrl = ''): array
{
    $baseUrl = rtrim($baseUrl ?: (defined('BASE_URL') ? BASE_URL : 'https://businessdoctor.com'), '/');
    $parsedHost = parse_url($baseUrl, PHP_URL_HOST);
    if (empty($parsedHost) || in_array($parsedHost, ['localhost', '127.0.0.1', '::1', '0.0.0.0'], true) || str_ends_with($parsedHost, '.local')) {
        $baseUrl = 'https://businessdoctor.com';
    }
    $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';

    $slug = $case['slug'] ?? '';
    $caseUrl = !empty($case['canonical_url']) ? $case['canonical_url'] : ($baseUrl . '/case-studies/' . rawurlencode($slug));

    $title = !empty($case['seo_title']) ? $case['seo_title'] : ($case['title'] ?? 'Client Case Study');
    $description = !empty($case['seo_description']) ? $case['seo_description'] : (!empty($case['project_summary']) ? $case['project_summary'] : substr(strip_tags((string)($case['challenge'] ?? '')), 0, 160));
    $clientIndustry = $case['industry'] ?: ($case['client_industry'] ?? 'Enterprise Software');
    $practiceArea = $case['service_category'] ?: ($case['practice_area'] ?? 'Web Engineering');

    $rawPub = !empty($case['published_at']) ? $case['published_at'] : (!empty($case['created_at']) ? $case['created_at'] : 'now');
    $rawMod = !empty($case['updated_at']) ? $case['updated_at'] : $rawPub;
    $datePublished = date('c', strtotime((string)$rawPub));
    $dateModified = date('c', strtotime((string)$rawMod));

    $featuredImg = !empty($case['featured_image']) ? $case['featured_image'] : '';
    if (!empty($featuredImg)) {
        if (!preg_match('/^https?:\/\//i', $featuredImg)) {
            $featuredImg = $baseUrl . '/' . ltrim($featuredImg, '/');
        }
    } else {
        $featuredImg = $baseUrl . '/assets/img/og-preview.svg';
    }

    // 1. Article Schema for Case Study
    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        '@id' => $caseUrl . '#casestudy',
        'isPartOf' => [
            '@type' => 'WebSite',
            '@id' => $baseUrl . '/#website',
            'name' => $appName,
            'url' => $baseUrl . '/'
        ],
        'headline' => $title,
        'description' => $description,
        'inLanguage' => 'en-US',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $caseUrl
        ],
        'url' => $caseUrl,
        'datePublished' => $datePublished,
        'dateModified' => $dateModified,
        'articleSection' => $clientIndustry,
        'about' => [
            '@type' => 'Thing',
            'name' => $practiceArea
        ],
        'image' => [
            '@type' => 'ImageObject',
            'url' => $featuredImg,
            'caption' => !empty($case['cover_image_alt']) ? $case['cover_image_alt'] : $title
        ],
        'author' => [
            '@type' => 'Organization',
            '@id' => $baseUrl . '/#organization',
            'name' => $appName,
            'url' => $baseUrl . '/'
        ],
        'publisher' => [
            '@type' => 'Organization',
            '@id' => $baseUrl . '/#organization',
            'name' => $appName,
            'url' => $baseUrl . '/',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/bdr-logo.png'
            ]
        ]
    ];

    // 2. Breadcrumbs
    $breadcrumbs = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => $baseUrl . '/'
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Case Studies',
                'item' => $baseUrl . '/case-studies.php'
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $title,
                'item' => $caseUrl
            ]
        ]
    ];

    // 3. Organization
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => $baseUrl . '/#organization',
        'name' => $appName,
        'url' => $baseUrl . '/',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $baseUrl . '/assets/img/bdr-logo.png'
        ]
    ];

    $schemas = [
        'Article' => $articleSchema,
        'BreadcrumbList' => $breadcrumbs,
        'Organization' => $organization
    ];

    // 4. FAQPage if FAQs exist in text
    $allText = ($case['challenge'] ?? '') . ' ' . ($case['prescription'] ?? '') . ' ' . ($case['solution'] ?? '') . ' ' . ($case['results'] ?? '');
    $faqs = extractFaqsFromContent($allText);
    if (!empty($faqs)) {
        $faqItems = [];
        foreach ($faqs as $faq) {
            $faqItems[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        $schemas['FAQPage'] = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqItems
        ];
    }

    return $schemas;
}

/**
 * Centralized Schema Renderer:
 * Queries active schemas for the page, replaces dynamic tokens, validates JSON, and outputs <script type="application/ld+json">
 */
function renderPageSchemas(?string $pageKey = null, array $contextData = []): string
{
    static $renderedSchemas = [];

    if ($pageKey === null || $pageKey === '') {
        $pageKey = detectCurrentPageKey();
    }

    try {
        $baseUrl = rtrim(defined('BASE_URL') ? BASE_URL : 'https://businessdoctor.com', '/');
        $parsedHost = parse_url($baseUrl, PHP_URL_HOST);
        if (empty($parsedHost) || in_array($parsedHost, ['localhost', '127.0.0.1', '::1', '0.0.0.0'], true) || str_ends_with($parsedHost, '.local')) {
            $baseUrl = 'https://businessdoctor.com';
        }
        $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
        $output = '';

        // Handle Specialized Blog / Insight Detail Schema Logic
        if ($pageKey === 'insight-detail' && !empty($contextData['title'])) {
            $schemaMode = $contextData['schema_mode'] ?? 'auto';

            if ($schemaMode === 'custom' && !empty($contextData['custom_schema_json'])) {
                $decoded = json_decode((string)$contextData['custom_schema_json'], true);
                if (is_array($decoded) && json_last_error() === JSON_ERROR_NONE) {
                    $sig = md5(json_encode($decoded));
                    if (!isset($renderedSchemas[$sig])) {
                        $renderedSchemas[$sig] = true;
                        $pretty = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        $output .= "\n  <!-- Custom Schema.org JSON-LD (Option B: Editorial Custom) -->\n";
                        $output .= "  <script type=\"application/ld+json\">\n" . $pretty . "\n  </script>\n";
                        return $output;
                    }
                }
            }

            // Option A: Automatically Generated Rich Multi-Type Schema Graph
            $graph = generateArticleSchemaGraph($contextData, $baseUrl);
            foreach ($graph as $schemaType => $schemaObj) {
                $sig = md5(json_encode($schemaObj));
                if (isset($renderedSchemas[$sig])) {
                    continue;
                }
                $renderedSchemas[$sig] = true;
                $pretty = json_encode($schemaObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $output .= "\n  <!-- Schema.org JSON-LD: " . htmlspecialchars($schemaType) . " (Auto-Generated) -->\n";
                $output .= "  <script type=\"application/ld+json\">\n" . $pretty . "\n  </script>\n";
            }

            return $output;
        }

        // Handle Specialized Case Study Detail Schema Logic
        if ($pageKey === 'case-study-detail' && !empty($contextData['title'])) {
            $schemaMode = $contextData['schema_mode'] ?? 'auto';

            if ($schemaMode === 'custom' && !empty($contextData['custom_schema_json'])) {
                $decoded = json_decode((string)$contextData['custom_schema_json'], true);
                if (is_array($decoded) && json_last_error() === JSON_ERROR_NONE) {
                    $sig = md5(json_encode($decoded));
                    if (!isset($renderedSchemas[$sig])) {
                        $renderedSchemas[$sig] = true;
                        $pretty = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        $output .= "\n  <!-- Custom Schema.org JSON-LD (Case Study Editorial Custom) -->\n";
                        $output .= "  <script type=\"application/ld+json\">\n" . $pretty . "\n  </script>\n";
                        return $output;
                    }
                }
            }

            // Automatically Generated Rich Case Study Schema Graph (Article, BreadcrumbList, Organization, ImageObject)
            $graph = generateCaseStudySchemaGraph($contextData, $baseUrl);
            foreach ($graph as $schemaType => $schemaObj) {
                $sig = md5(json_encode($schemaObj));
                if (isset($renderedSchemas[$sig])) {
                    continue;
                }
                $renderedSchemas[$sig] = true;
                $pretty = json_encode($schemaObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $output .= "\n  <!-- Schema.org JSON-LD: " . htmlspecialchars($schemaType) . " (Auto-Generated Case Study) -->\n";
                $output .= "  <script type=\"application/ld+json\">\n" . $pretty . "\n  </script>\n";
            }

            return $output;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT schema_name, schema_type, schema_json
            FROM page_schemas
            WHERE page_key = ? AND status = 'active'
            ORDER BY id ASC
        ");
        $stmt->execute([$pageKey]);
        $schemas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($schemas)) {
            return '';
        }

        // Build token replacement dictionary
        $canonicalUrl = $GLOBALS['canonicalUrl'] ?? ($baseUrl . ($_SERVER['REQUEST_URI'] ?? '/'));

        $pageTitle = $GLOBALS['pageTitle'] ?? $appName;
        $pageDescription = $GLOBALS['pageDescription'] ?? '';

        $articleTitle = $contextData['title'] ?? $pageTitle;
        $articleExcerpt = $contextData['excerpt'] ?? $contextData['summary'] ?? $pageDescription;
        $authorName = $contextData['author'] ?? $contextData['author_name'] ?? 'BusinessDoctor';

        $rawPubDate = $contextData['published_at'] ?? $contextData['created_at'] ?? 'now';
        $rawModDate = $contextData['updated_at'] ?? $rawPubDate;

        $pubDateIso = date('c', strtotime((string)$rawPubDate));
        $modDateIso = date('c', strtotime((string)$rawModDate));

        $featuredImg = $contextData['featured_image'] ?? '';
        if (!empty($featuredImg)) {
            if (!preg_match('/^https?:\/\//i', $featuredImg)) {
                $featuredImg = $baseUrl . '/' . ltrim($featuredImg, '/');
            }
        } else {
            $featuredImg = $baseUrl . '/assets/img/og-preview.svg';
        }

        $category = $contextData['category'] ?? $contextData['industry'] ?? 'Enterprise Solutions';

        $replacements = [
            '{{BASE_URL}}' => $baseUrl,
            '{{ORGANIZATION_NAME}}' => $appName,
            '{{PAGE_TITLE}}' => addslashes($pageTitle),
            '{{PAGE_DESCRIPTION}}' => addslashes($pageDescription),
            '{{CANONICAL_URL}}' => $canonicalUrl,
            '{{ARTICLE_TITLE}}' => addslashes($articleTitle),
            '{{ARTICLE_DESCRIPTION}}' => addslashes($articleExcerpt),
            '{{AUTHOR_NAME}}' => addslashes($authorName),
            '{{DATE_PUBLISHED}}' => $pubDateIso,
            '{{DATE_MODIFIED}}' => $modDateIso,
            '{{FEATURED_IMAGE}}' => $featuredImg,
            '{{CATEGORY}}' => addslashes($category)
        ];

        foreach ($schemas as $row) {
            $rawJson = $row['schema_json'];

            // Replace dynamic tokens
            $boundJson = str_replace(array_keys($replacements), array_values($replacements), $rawJson);

            // Validate that result is 100% valid JSON
            $decoded = json_decode($boundJson, true);
            if (!is_array($decoded) || json_last_error() !== JSON_ERROR_NONE) {
                continue;
            }

            // Deduplicate by signature
            $signature = md5(json_encode($decoded));
            if (isset($renderedSchemas[$signature])) {
                continue;
            }
            $renderedSchemas[$signature] = true;

            $prettyJson = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $output .= "\n  <!-- Schema.org JSON-LD: " . htmlspecialchars($row['schema_name']) . " (" . htmlspecialchars($row['schema_type']) . ") -->\n";
            $output .= "  <script type=\"application/ld+json\">\n" . $prettyJson . "\n  </script>\n";
        }

        return $output;

    } catch (Exception $e) {
        return '';
    }
}

