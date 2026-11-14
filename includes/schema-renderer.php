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
            'url' => '/company/{slug}',
            'recommended_types' => ['Service', 'BreadcrumbList'],
            'is_dynamic' => true
        ],
        'diagnostic' => [
            'name' => 'Digital Architecture Audit',
            'url' => '/audit.php',
            'recommended_types' => ['WebPage', 'BreadcrumbList'],
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
            'url' => '/case-study-detail.php',
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
            'url' => '/insight-detail.php',
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
    if ($reqPath !== null && preg_match('#^/(?:services|company)/([a-zA-Z0-9_-]+)#', $reqPath)) {
        return 'service-detail';
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

    // Pattern 5: Markdown headings (## or ### ending in '?' followed by paragraph text)
    if (empty($faqs)) {
        if (preg_match_all('/(?:^|\r?\n)#{2,4}\s*([^\r\n#]+\?)\s*(?:\r?\n)+([^#\r\n][^\r\n]*(?:\r?\n(?!#{1,6}\s|\r?\n)[^\r\n]*)*)/', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $q = trim(strip_tags($m[1]));
                $a = trim(strip_tags($m[2]));
                if (!empty($q) && !empty($a) && mb_strlen($q) > 8 && mb_strlen($a) > 15) {
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
    $baseUrl = rtrim($baseUrl ?: (defined('BASE_URL') ? BASE_URL : 'https://demo.businesdoctor.com'), '/');
    $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
    $legalName = defined('APP_LEGAL_NAME') ? APP_LEGAL_NAME : 'BusinessDoctor IT Solutions & Digital Services Private Limited';

    $slug = $article['slug'] ?? '';
    $articleUrl = !empty($article['canonical_url']) ? $article['canonical_url'] : ($baseUrl . '/insight-detail.php?slug=' . urlencode($slug));

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

    // 1. Organization Schema (Required: Primary Verified Authority Entity)
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $appName,
        'legalName' => $legalName,
        'url' => $baseUrl . '/',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => $baseUrl . '/assets/img/logo.svg'
        ],
        'description' => 'BusinessDoctor is an enterprise digital transformation, cloud architecture, and full-stack software development consulting firm.',
        'telephone' => '+1 (800) 492-3628',
        'email' => 'solutions@businessdoctor.com',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Sector 62, Innovation Corridor',
            'addressLocality' => 'Noida',
            'addressRegion' => 'UP',
            'postalCode' => '201301',
            'addressCountry' => 'IN'
        ],
        'sameAs' => [
            'https://www.linkedin.com/company/businessdoctor',
            'https://twitter.com/businessdoctor',
            'https://github.com/businessdoctor'
        ],
        'mainEntityOfPage' => $articleUrl
    ];

    // 2. BreadcrumbList Schema (Required: Navigation Trail)
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
                'name' => 'Blog',
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

    // 3. Blog Schema (Required: Parent Publication Series)
    $blog = [
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => 'Technical Blog & Strategic Frameworks — ' . $appName,
        'description' => 'Practical engineering blueprints, Core Web Vitals breakdowns, and conversion optimization strategies from our senior architects and digital strategists.',
        'url' => $baseUrl . '/insights.php',
        'publisher' => [
            '@type' => 'Organization',
            'name' => $appName,
            'url' => $baseUrl . '/'
        ]
    ];

    // 4. BlogPosting Schema (Additional Valid Structured Data)
    $blogPosting = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
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
            'name' => $authorName,
            'jobTitle' => $authorTitle
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $appName,
            'url' => $baseUrl . '/',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . '/assets/img/logo.svg'
            ]
        ]
    ];
    if (!empty($authorBio)) {
        $blogPosting['author']['description'] = $authorBio;
    }

    $schemas = [
        'Organization' => $organization,
        'BreadcrumbList' => $breadcrumbs,
        'Blog' => $blog,
        'BlogPosting' => $blogPosting
    ];

    // 5. FAQPage Schema (Required: Generated when visible FAQs exist)
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

function renderPageSchemas(?string $pageKey = null, array $contextData = []): string
{
    $renderedSchemas = [];

    if ($pageKey === null || $pageKey === '') {
        $pageKey = detectCurrentPageKey();
    }

    try {
        $baseUrl = rtrim(defined('BASE_URL') ? BASE_URL : 'https://demo.businesdoctor.com', '/');
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
        $articleExcerpt = $contextData['excerpt'] ?? $contextData['summary'] ?? $contextData['project_summary'] ?? $contextData['challenge'] ?? $pageDescription;
        $authorName = $contextData['author'] ?? $contextData['author_name'] ?? 'BusinessDoctor';

        $rawPubDate = $contextData['published_at'] ?? $contextData['created_at'] ?? 'now';
        $rawModDate = $contextData['updated_at'] ?? $rawPubDate;

        $pubDateIso = date('c', strtotime((string)$rawPubDate));
        $modDateIso = date('c', strtotime((string)$rawModDate));

        $featuredImg = $contextData['featured_image'] ?? $contextData['hero_image'] ?? $contextData['thumbnail_url'] ?? '';
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

        $hasBreadcrumbs = false;
        foreach ($schemas as $row) {
            if (($row['schema_type'] ?? '') === 'BreadcrumbList') {
                $hasBreadcrumbs = true;
            }
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

        // Auto-inject BreadcrumbList for inner pages if not explicitly declared in page_schemas
        if ($pageKey !== 'home' && !$hasBreadcrumbs) {
            $breadcrumbItems = [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $baseUrl . '/'
                ]
            ];

            if ($pageKey === 'service-detail') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Services Portfolio',
                    'item' => $baseUrl . '/services.php'
                ];
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $articleTitle ?: 'Service Detail',
                    'item' => $canonicalUrl
                ];
            } elseif ($pageKey === 'case-study-detail') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Case Studies',
                    'item' => $baseUrl . '/case-studies.php'
                ];
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $articleTitle ?: 'Case Study Detail',
                    'item' => $canonicalUrl
                ];
            } elseif ($pageKey === 'services') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Services Portfolio',
                    'item' => $baseUrl . '/services.php'
                ];
            } elseif ($pageKey === 'case-studies') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Case Studies',
                    'item' => $baseUrl . '/case-studies.php'
                ];
            } elseif ($pageKey === 'insights') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blog',
                    'item' => $baseUrl . '/insights.php'
                ];
            } elseif ($pageKey === 'about') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'About Us',
                    'item' => $baseUrl . '/about.php'
                ];
            } elseif ($pageKey === 'contact') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Contact Us',
                    'item' => $baseUrl . '/contact.php'
                ];
            } elseif ($pageKey === 'diagnostic') {
                $breadcrumbItems[] = [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Digital Architecture Audit',
                    'item' => $baseUrl . '/audit.php'
                ];
            }

            if (count($breadcrumbItems) > 1) {
                $breadcrumbSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbItems
                ];
                $sig = md5(json_encode($breadcrumbSchema));
                if (!isset($renderedSchemas[$sig])) {
                    $renderedSchemas[$sig] = true;
                    $pretty = json_encode($breadcrumbSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    $output .= "\n  <!-- Schema.org JSON-LD: BreadcrumbList (Auto-Generated) -->\n";
                    $output .= "  <script type=\"application/ld+json\">\n" . $pretty . "\n  </script>\n";
                }
            }
        }

        return $output;

    } catch (Exception $e) {
        return '';
    }
}

