<?php
/**
 * BusinessDoctor — Schema Manager Database Migration
 * Creates page_schemas table and seeds recommended default Schema.org JSON-LD templates.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';

try {
    $pdo = Database::getConnection();

    // 1. Create page_schemas table if not exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS page_schemas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            page_key TEXT NOT NULL,
            page_url TEXT NOT NULL,
            schema_name TEXT NOT NULL,
            schema_type TEXT NOT NULL,
            schema_description TEXT NULL,
            schema_json TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT 'active',
            created_at TEXT DEFAULT CURRENT_TIMESTAMP,
            updated_at TEXT DEFAULT CURRENT_TIMESTAMP
        );
        CREATE INDEX IF NOT EXISTS idx_page_schemas_page_key ON page_schemas (page_key);
        CREATE INDEX IF NOT EXISTS idx_page_schemas_status ON page_schemas (status);
    ");

    echo "[PASS] Table `page_schemas` ensured in SQLite database.\n";

    // 2. Check if default schemas are already seeded
    $count = (int)$pdo->query("SELECT COUNT(*) FROM page_schemas")->fetchColumn();
    if ($count === 0) {
        $now = date('Y-m-d H:i:s');
        $baseUrl = defined('BASE_URL') ? BASE_URL : 'https://demo.businesdoctor.com';
        $appName = defined('APP_NAME') ? APP_NAME : 'BusinessDoctor';
        $legalName = defined('APP_LEGAL_NAME') ? APP_LEGAL_NAME : 'BusinessDoctor Enterprise Solutions Pvt. Ltd.';
        $phone = defined('APP_PHONE') ? APP_PHONE : '+91 98765 43210';
        $email = defined('APP_EMAIL') ? APP_EMAIL : 'leadership@businessdoctor.com';

        $defaultSchemas = [
            // 1. Homepage — Organization Schema
            [
                'page_key' => 'home',
                'page_url' => '/',
                'schema_name' => 'Primary Enterprise Organization Schema',
                'schema_type' => 'Organization',
                'schema_description' => '<p>Primary corporate identity schema establishing BusinessDoctor as an enterprise IT, cloud, and digital transformation consultancy firm.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Organization',
                    '@id' => '{{BASE_URL}}/#organization',
                    'name' => $appName,
                    'legalName' => $legalName,
                    'url' => '{{BASE_URL}}/',
                    'logo' => '{{BASE_URL}}/assets/img/logo.svg',
                    'description' => 'BusinessDoctor is an enterprise digital transformation, cloud architecture, and full-stack software development consulting firm.',
                    'telephone' => $phone,
                    'email' => $email,
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'First Floor, Ram Dutt Enclave, B-16, Block D, Uttam Nagar East',
                        'addressLocality' => 'Uttam Nagar, New Delhi',
                        'addressRegion' => 'Delhi',
                        'postalCode' => '110059',
                        'addressCountry' => 'IN'
                    ],
                    'sameAs' => [
                        'https://www.linkedin.com/company/businessdoctor',
                        'https://twitter.com/businessdoctor',
                        'https://github.com/businessdoctor'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 2. Homepage — WebSite & Sitelinks Search Schema
            [
                'page_key' => 'home',
                'page_url' => '/',
                'schema_name' => 'Website Global Authority Schema',
                'schema_type' => 'WebSite',
                'schema_description' => '<p>Declares the website root entity and enables Google Sitelinks query integration.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebSite',
                    '@id' => '{{BASE_URL}}/#website',
                    'url' => '{{BASE_URL}}/',
                    'name' => $appName,
                    'description' => 'Enterprise IT solutions, high-growth digital strategy, and full-stack engineering consultancy.',
                    'publisher' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => [
                            '@type' => 'EntryPoint',
                            'urlTemplate' => '{{BASE_URL}}/insights.php?q={search_term_string}'
                        ],
                        'query-input' => 'required name=search_term_string'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 3. About Us — AboutPage Schema
            [
                'page_key' => 'about',
                'page_url' => '/about.php',
                'schema_name' => 'About Us Corporate Purpose Schema',
                'schema_type' => 'AboutPage',
                'schema_description' => '<p>Signals to Google knowledge graph about BusinessDoctor leadership, mission, and technical philosophy.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'AboutPage',
                    '@id' => '{{BASE_URL}}/about.php#aboutpage',
                    'url' => '{{BASE_URL}}/about.php',
                    'name' => 'About BusinessDoctor — Enterprise IT & Growth Consultancy',
                    'description' => 'Learn about BusinessDoctor executive leadership, engineering principles, and our multidisciplinary IT practice.',
                    'mainEntity' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 4. IT Services — ProfessionalService & OfferCatalog
            [
                'page_key' => 'services',
                'page_url' => '/services.php',
                'schema_name' => 'IT Services Portfolio & OfferCatalog',
                'schema_type' => 'ProfessionalService',
                'schema_description' => '<p>Defines the four core engineering practices: Web Development, Performance Marketing, UI/UX, and Cloud Solutions.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'ProfessionalService',
                    '@id' => '{{BASE_URL}}/services.php#professionalservice',
                    'name' => $appName . ' IT Services',
                    'url' => '{{BASE_URL}}/services.php',
                    'priceRange' => '$$$',
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name' => 'Enterprise IT & Digital Services Portfolio',
                        'itemListElement' => [
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'Web & Custom Software Engineering',
                                    'description' => 'Architecting resilient full-stack web applications, microservices, and enterprise APIs.'
                                ]
                            ],
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'Digital Marketing & Performance SEO',
                                    'description' => 'Data-driven growth engines, revenue attribution, and organic search dominance.'
                                ]
                            ],
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'UI/UX Design & Brand Identity Systems',
                                    'description' => 'Human-centered user experience design, interactive design tokens, and design systems.'
                                ]
                            ],
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'Cloud Solutions & DevOps Automation',
                                    'description' => 'Cloud-native infrastructure, Kubernetes orchestration, and continuous delivery pipelines.'
                                ]
                            ]
                        ]
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 5. Individual Service Detail — Dynamic Service Schema
            [
                'page_key' => 'service-detail',
                'page_url' => '/services/{slug}',
                'schema_name' => 'Dynamic Practice Area Service Schema',
                'schema_type' => 'Service',
                'schema_description' => '<p>Dynamically populates based on active practice area URL parameter.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => '{{PAGE_TITLE}}',
                    'url' => '{{CANONICAL_URL}}',
                    'description' => '{{PAGE_DESCRIPTION}}',
                    'provider' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ],
                    'areaServed' => 'Global',
                    'serviceType' => 'Enterprise Consulting'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 6. Digital Audit — Interactive Diagnostic Tool
            [
                'page_key' => 'diagnostic',
                'page_url' => '/diagnostic.php',
                'schema_name' => 'Digital Architecture Diagnostic Audit Tool',
                'schema_type' => 'WebPage',
                'schema_description' => '<p>Marks up the interactive digital health and architecture diagnostic assessment.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => 'Enterprise Digital Diagnostic & IT Health Audit',
                    'url' => '{{BASE_URL}}/diagnostic.php',
                    'description' => 'Benchmark your technology stack, operational bottlenecks, and digital maturity in minutes.',
                    'publisher' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 7. Case Studies Listing
            [
                'page_key' => 'case-studies',
                'page_url' => '/case-studies.php',
                'schema_name' => 'Client Case Studies & Proven Results Collection',
                'schema_type' => 'WebPage',
                'schema_description' => '<p>Portfolio listing of verified enterprise transformations and quantified business outcomes.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => 'Client Case Studies & Transformations — BusinessDoctor',
                    'url' => '{{BASE_URL}}/case-studies.php',
                    'description' => 'Explore proven case studies demonstrating measurable growth and software transformation across industries.',
                    'publisher' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 8. Individual Case Study Page — Dynamic Article Schema
            [
                'page_key' => 'case-study-detail',
                'page_url' => '/case-study-detail.php',
                'schema_name' => 'Dynamic Client Case Study Article Schema',
                'schema_type' => 'Article',
                'schema_description' => '<p>Dynamically pulls client industry, challenge, outcome, and canonical slug for rich snippets.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Article',
                    'headline' => '{{ARTICLE_TITLE}}',
                    'url' => '{{CANONICAL_URL}}',
                    'description' => '{{ARTICLE_DESCRIPTION}}',
                    'publisher' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ],
                    'author' => [
                        '@type' => 'Organization',
                        'name' => $appName
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 9. Blog / Insights Listing
            [
                'page_key' => 'insights',
                'page_url' => '/insights.php',
                'schema_name' => 'Perspectives & Engineering Insights Blog',
                'schema_type' => 'WebPage',
                'schema_description' => '<p>Main editorial collection page for technical perspectives, architecture guides, and strategic commentary.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'name' => 'Perspectives & Technical Insights — BusinessDoctor',
                    'url' => '{{BASE_URL}}/insights.php',
                    'description' => 'Technical blueprints, cloud architecture strategies, and leadership insights from BusinessDoctor experts.',
                    'publisher' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 10. Individual Blog Article — Dynamic BlogPosting Schema
            [
                'page_key' => 'insight-detail',
                'page_url' => '/insight-detail.php',
                'schema_name' => 'Dynamic Technical Article & BlogPosting Schema',
                'schema_type' => 'BlogPosting',
                'schema_description' => '<p>Rich Google-compatible BlogPosting schema with dynamic headline, author, datePublished, image, and canonical URL.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'BlogPosting',
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => '{{CANONICAL_URL}}'
                    ],
                    'headline' => '{{ARTICLE_TITLE}}',
                    'description' => '{{ARTICLE_DESCRIPTION}}',
                    'image' => '{{FEATURED_IMAGE}}',
                    'datePublished' => '{{DATE_PUBLISHED}}',
                    'dateModified' => '{{DATE_MODIFIED}}',
                    'author' => [
                        '@type' => 'Person',
                        'name' => '{{AUTHOR_NAME}}'
                    ],
                    'publisher' => [
                        '@id' => '{{BASE_URL}}/#organization'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ],

            // 11. Contact Us — ContactPage Schema
            [
                'page_key' => 'contact',
                'page_url' => '/contact.php',
                'schema_name' => 'Contact Us & Advisory Inquiries Schema',
                'schema_type' => 'ContactPage',
                'schema_description' => '<p>Marks up the primary contact point and advisory consultation inquiry channels.</p>',
                'status' => 'active',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'ContactPage',
                    '@id' => '{{BASE_URL}}/contact.php#contactpage',
                    'url' => '{{BASE_URL}}/contact.php',
                    'name' => 'Contact BusinessDoctor — Enterprise Advisory & Consultation',
                    'description' => 'Initiate a dialogue with BusinessDoctor solution architects and digital practice directors.',
                    'mainEntity' => [
                        '@type' => 'ContactPoint',
                        'telephone' => $phone,
                        'contactType' => 'customer service',
                        'email' => $email,
                        'availableLanguage' => ['English', 'Hindi']
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT INTO page_schemas (page_key, page_url, schema_name, schema_type, schema_description, schema_json, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($defaultSchemas as $s) {
            $stmt->execute([
                $s['page_key'],
                $s['page_url'],
                $s['schema_name'],
                $s['schema_type'],
                $s['schema_description'],
                $s['schema_json'],
                $s['status'],
                $now,
                $now
            ]);
        }

        echo "[PASS] Successfully seeded " . count($defaultSchemas) . " default Schema.org JSON-LD templates.\n";
    } else {
        echo "[INFO] `page_schemas` already contains {$count} records. Preserved existing schemas.\n";
    }

} catch (Exception $e) {
    echo "[FAIL] Migration error: " . $e->getMessage() . "\n";
    exit(1);
}

