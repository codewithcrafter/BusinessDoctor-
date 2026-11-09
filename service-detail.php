<?php
/**
 * BusinessDoctor Service Detail View - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

// 1. Legacy URL 301 Permanent Redirect
// If client requested /service-detail.php?slug=... directly, 301 redirect to /services/{slug}
$reqUri = $_SERVER['REQUEST_URI'] ?? '';
if (str_contains($reqUri, 'service-detail.php')) {
    $rawSlug = trim($_GET['slug'] ?? '');
    if ($rawSlug !== '') {
        $p = getPracticeBySlug($rawSlug);
        $redirectSlug = $p ? $p['slug'] : rawurlencode($rawSlug);
        $targetUrl = '/services/' . $redirectSlug;
    } else {
        $targetUrl = '/services.php';
    }
    header("Location: " . $targetUrl, true, 301);
    exit;
}

// 2. Validate Service Slug
$slug = trim($_GET['slug'] ?? '');
if ($slug === '') {
    header("Location: /services.php", true, 301);
    exit;
}

$practice = getPracticeBySlug($slug);

if (!$practice) {
    http_response_code(404);
    $pageTitle = 'Service Not Found — BusinessDoctor';
    $pageDescription = 'The requested practice area could not be found. Explore our enterprise IT and digital capabilities.';
    $canonicalUrl = BASE_URL . '/services.php';
    require_once __DIR__ . '/includes/header.php';
    ?>
    <section class="section hero-enterprise" style="padding-top: 6rem; padding-bottom: 6rem; text-align: center;">
      <div class="container" style="max-width: 760px;">
        <span class="eyebrow-badge" style="margin-bottom: 1.25rem;">
          <span class="pill-dot" style="background-color: var(--color-error, #ef4444);"></span>
          <span>HTTP 404 &mdash; PRACTICE AREA NOT FOUND</span>
        </span>
        <h1 class="hero-headline-oversized" style="font-size: clamp(2.2rem, 4vw, 3.2rem); margin-bottom: 1.25rem;">
          Capability Not Recognized
        </h1>
        <p class="hero-lead-text" style="margin-bottom: 2.5rem;">
          The service discipline <code><?= e($slug) ?></code> is not part of our enterprise roadmap, or the URL has changed.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
          <a href="<?= BASE_URL ?>/services.php" class="btn btn-primary btn-lg">
            <span>Explore All Capabilities</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="<?= BASE_URL ?>/contact.php" class="btn btn-secondary btn-lg">
            <span>Inquire About Custom Engineering</span>
          </a>
        </div>
      </div>
    </section>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$canonicalUrl = BASE_URL . '/services/' . $practice['slug'];
$pageTitle = $practice['name'] . ' — BusinessDoctor Enterprise Capabilities';
$pageDescription = $practice['summary'];

// Get related case study if available
$relatedCase = null;
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM case_studies WHERE practice_area LIKE ? LIMIT 1");
    $stmt->execute(['%' . $practice['short_title'] . '%']);
    $relatedCase = $stmt->fetch();
    if (!$relatedCase) {
        $stmt = $pdo->query("SELECT * FROM case_studies LIMIT 1");
        $relatedCase = $stmt->fetch();
    }
} catch (Exception $e) {}

$schemaPageKey = 'service-detail';
$schemaContextData = [
    'title' => $practice['name'],
    'summary' => $practice['summary'],
    'canonical_url' => $canonicalUrl
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Practice Hero Banner -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 4rem;">
  <div class="container">
    <div style="max-width: 880px;">
      <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem;">
        <span style="font-family: var(--font-mono); font-size: 0.82rem; font-weight: 700; color: var(--color-secondary); letter-spacing: 0.1em;">
          DISCIPLINE // <?= e($practice['number']) ?>
        </span>
        <span class="eyebrow-badge" style="margin-bottom: 0;"><?= e($practice['tagline']) ?></span>
      </div>
      <h1 class="hero-headline-oversized" style="font-size: clamp(2.4rem, 4.5vw, 3.8rem); margin-bottom: 1.25rem;">
        <?= e($practice['name']) ?>
      </h1>
      <p class="hero-lead-text"><?= e($practice['description']) ?></p>

      <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
        <a href="/contact.php?service=<?= urlencode($practice['name']) ?>" class="btn btn-accent btn-lg">
          <span>Request a Project Proposal</span>
          <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
        <a href="/audit.php" class="btn btn-secondary btn-lg">
          <span>Run Digital Architecture Audit</span>
        </a>
      </div>
    </div>
  </div>
</section>

<?php if ($practice['slug'] === 'digital-marketing-seo'): ?>

<!-- ============================================================
     1. SERVICE OVERVIEW
     ============================================================ -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>01 // SERVICE OVERVIEW</span>
      </div>
      <h2 style="font-size: clamp(1.8rem, 3.2vw, 2.5rem); font-weight: 800; color: var(--color-text); margin-bottom: 1.25rem; line-height: 1.3;">
        Engineered Organic Search &amp; Scalable Customer Acquisition
      </h2>
      <p style="font-size: 1.08rem; color: var(--color-text-muted); line-height: 1.75; margin-bottom: 1.25rem;">
        At BusinessDoctor, we treat search engine optimization and digital marketing as engineering disciplines rather than creative guesswork. Modern search algorithms reward technical precision, crawl efficiency, topical authority, and authentic search intent alignment. 
      </p>
      <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.75; margin-bottom: 0;">
        Our digital marketing practice unifies deep technical SEO audits, server-level performance optimization, high-intent keyword mapping, and transparent analytics to systematically lower customer acquisition costs and build sustainable market visibility.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     2. BUSINESS CHALLENGES WE SOLVE
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto 3rem;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>02 // PROBLEM RESOLUTION</span>
      </div>
      <h2 class="section-title">Critical Search &amp; Growth Bottlenecks We Eliminate</h2>
      <p class="lead">Companies frequently face systematic visibility barriers that prevent organic search traffic from converting into revenue.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.75rem;">
      <div class="card" style="padding: 2rem;">
        <div style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-error, #EF4444); font-weight: 700; margin-bottom: 0.5rem;">CHALLENGE 01</div>
        <h3 style="font-size: 1.25rem; color: var(--color-text); margin-bottom: 0.75rem;">Stagnant Search Rankings &amp; Crawl Leaks</h3>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Websites with complex architectures, orphan pages, render-blocking JavaScript, and redirect loops waste Googlebot crawl budget, causing core pages to sit unindexed or rank poorly.
        </p>
      </div>

      <div class="card" style="padding: 2rem;">
        <div style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-error, #EF4444); font-weight: 700; margin-bottom: 0.5rem;">CHALLENGE 02</div>
        <h3 style="font-size: 1.25rem; color: var(--color-text); margin-bottom: 0.75rem;">Escalating Paid Ad Acquisition Costs (CAC)</h3>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Relying solely on pay-per-click ad auctions leads to margin compression. Without an authoritative organic search foundation, acquisition costs surge whenever auction bids climb.
        </p>
      </div>

      <div class="card" style="padding: 2rem;">
        <div style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-error, #EF4444); font-weight: 700; margin-bottom: 0.5rem;">CHALLENGE 03</div>
        <h3 style="font-size: 1.25rem; color: var(--color-text); margin-bottom: 0.75rem;">High Bounce Rates on Slow Landing Pages</h3>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Visitors acquired through organic or paid media abandon slow websites within 3 seconds. Core Web Vitals issues degrade both conversion rates and organic ranking potential.
        </p>
      </div>

      <div class="card" style="padding: 2rem;">
        <div style="font-family: var(--font-mono); font-size: 0.82rem; color: var(--color-error, #EF4444); font-weight: 700; margin-bottom: 0.5rem;">CHALLENGE 04</div>
        <h3 style="font-size: 1.25rem; color: var(--color-text); margin-bottom: 0.75rem;">Mismatched Search Intent &amp; Thin Content</h3>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Publishing generic blog content without rigorous keyword mapping brings unqualified traffic that never buys. We realign content strategy around commercial and transactional intent.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. OUR DIGITAL MARKETING STRATEGY
     ============================================================ -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>03 // METHODOLOGY</span>
      </div>
      <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
        Our Unified Four-Pillar Growth Framework
      </h2>
      <p style="font-size: 1.05rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 2rem;">
        We combine foundational technical health, audience intent research, authoritative content creation, and conversion tracking to ensure every marketing dollar drives measurable commercial impact.
      </p>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem;">
        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); padding: 1.5rem; border-radius: var(--radius-md);">
          <div style="font-family: var(--font-mono); color: var(--color-secondary); font-weight: 700; font-size: 0.85rem; margin-bottom: 0.5rem;">PILLAR 1</div>
          <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Technical Foundation</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Server response times, clean crawl trees, semantic HTML5, XML sitemaps, and strict schema validation.</p>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); padding: 1.5rem; border-radius: var(--radius-md);">
          <div style="font-family: var(--font-mono); color: var(--color-secondary); font-weight: 700; font-size: 0.85rem; margin-bottom: 0.5rem;">PILLAR 2</div>
          <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Commercial Intent</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Targeting high-value keywords where searchers have purchase urgency rather than idle informational interest.</p>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); padding: 1.5rem; border-radius: var(--radius-md);">
          <div style="font-family: var(--font-mono); color: var(--color-secondary); font-weight: 700; font-size: 0.85rem; margin-bottom: 0.5rem;">PILLAR 3</div>
          <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Topical Authority</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Comprehensive pillar guides, service deep-dives, and strategic internal links demonstrating industry expertise.</p>
        </div>

        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); padding: 1.5rem; border-radius: var(--radius-md);">
          <div style="font-family: var(--font-mono); color: var(--color-secondary); font-weight: 700; font-size: 0.85rem; margin-bottom: 0.5rem;">PILLAR 4</div>
          <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Attribution &amp; ROI</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Closed-loop conversion measurement tracking form fills, qualified leads, customer acquisition cost, and revenue.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     4. SEO AUDIT AND TECHNICAL SEO
     ============================================================ -->
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 3rem; align-items: center;">
      <div>
        <div class="eyebrow-badge" style="margin-bottom: 1rem;">
          <span class="pill-dot"></span>
          <span>04 // TECHNICAL EXCELLENCE</span>
        </div>
        <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
          Exhaustive Technical SEO &amp; Core Web Vitals Audits
        </h2>
        <p style="font-size: 1rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.25rem;">
          Before attempting to rank, your platform must be crawlable, accessible, and fast. We audit every technical layer of your digital infrastructure:
        </p>
        <ul style="list-style: none; padding: 0; margin: 0 0 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem; color: var(--color-text);">
          <li style="display: flex; gap: 0.65rem; align-items: flex-start;">
            <span style="color: var(--color-secondary); font-weight: 800;">✓</span>
            <span><strong>Crawlability &amp; Indexation:</strong> Correct robots.txt rules, XML sitemaps, canonical tags, and HTTP 301 redirects.</span>
          </li>
          <li style="display: flex; gap: 0.65rem; align-items: flex-start;">
            <span style="color: var(--color-secondary); font-weight: 800;">✓</span>
            <span><strong>Core Web Vitals:</strong> Optimizing Largest Contentful Paint (LCP &lt; 1.2s), Interaction to Next Paint (INP), and Cumulative Layout Shift (CLS).</span>
          </li>
          <li style="display: flex; gap: 0.65rem; align-items: flex-start;">
            <span style="color: var(--color-secondary); font-weight: 800;">✓</span>
            <span><strong>Schema.org Structured Data:</strong> Embedding JSON-LD graphs for Organizations, Products, Services, Articles, and FAQs.</span>
          </li>
          <li style="display: flex; gap: 0.65rem; align-items: flex-start;">
            <span style="color: var(--color-secondary); font-weight: 800;">✓</span>
            <span><strong>Mobile Performance:</strong> Responsive viewport integrity, fluid typography, and zero horizontal overflow.</span>
          </li>
        </ul>
        <a href="/audit.php" class="btn btn-primary btn-sm">Benchmark Your Site with Our Free Audit &rarr;</a>
      </div>

      <div style="background: rgba(14, 37, 63, 0.7); border: 1px solid var(--color-slate-200); border-radius: var(--radius-lg); padding: 2.25rem;">
        <div style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-accent); margin-bottom: 1rem; text-transform: uppercase;">
          ● AUDIT DELIVERABLES
        </div>
        <h3 style="color: #ffffff; font-size: 1.35rem; margin-bottom: 1.25rem;">What You Receive in a Technical Audit</h3>
        <div style="display: flex; flex-direction: column; gap: 0.85rem; font-size: 0.88rem; color: #CBD5E1;">
          <div style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.04); border-radius: 4px; border-left: 2px solid var(--color-secondary);">
            Full architectural crawl log identifying 404 errors, 302 chains, and canonical mismatches.
          </div>
          <div style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.04); border-radius: 4px; border-left: 2px solid var(--color-secondary);">
            Prioritized engineering roadmap with code snippets for developers to resolve speed bottlenecks.
          </div>
          <div style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.04); border-radius: 4px; border-left: 2px solid var(--color-secondary);">
            Server response analysis and TTFB (Time to First Byte) tuning recommendations.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     5. KEYWORD RESEARCH AND SEARCH INTENT
     ============================================================ -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>05 // MARKET RESEARCH</span>
      </div>
      <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
        Commercial Keyword Intelligence &amp; Intent Mapping
      </h2>
      <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.75rem;">
        Ranking for broad keywords that generate no revenue is a wasted effort. We segment search queries into distinct behavioral stages and map each phrase to dedicated, purpose-built landing pages:
      </p>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem;">
        <div class="card" style="padding: 1.75rem;">
          <h4 style="font-size: 1.1rem; color: var(--color-text); margin-bottom: 0.5rem;">Transactional Intent</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
            Users ready to purchase or book services. Mapped to high-converting service landing pages with frictionless inquiry forms.
          </p>
        </div>

        <div class="card" style="padding: 1.75rem;">
          <h4 style="font-size: 1.1rem; color: var(--color-text); margin-bottom: 0.5rem;">Commercial Investigation</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
            Prospective clients comparing platforms, architectures, and pricing models. Mapped to comparison teardowns and case studies.
          </p>
        </div>

        <div class="card" style="padding: 1.75rem;">
          <h4 style="font-size: 1.1rem; color: var(--color-text); margin-bottom: 0.5rem;">Informational Problem-Solving</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
            Decision-makers diagnosing technical bottlenecks. Mapped to in-depth engineering perspectives that build credibility.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     6. ON-PAGE AND OFF-PAGE SEO
     ============================================================ -->
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2.5rem;">
      <div class="card" style="padding: 2.25rem;">
        <div class="eyebrow-badge" style="margin-bottom: 0.85rem;">ON-PAGE OPTIMIZATION</div>
        <h3 style="font-size: 1.4rem; color: var(--color-text); margin-bottom: 1rem;">Content Architecture &amp; Relevancy</h3>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 1.25rem;">
          We optimize on-page elements to ensure search engines immediately understand your content depth:
        </p>
        <ul style="padding-left: 1.25rem; margin: 0; font-size: 0.9rem; color: var(--color-text-muted); line-height: 1.6;">
          <li>Strategic Title and Meta Description tags crafted for click-through rate (CTR).</li>
          <li>Hierarchical H1 &rarr; H2 &rarr; H3 header structure reflecting content taxonomy.</li>
          <li>Optimized image assets with WebP compression and descriptive alt text.</li>
          <li>Intentional internal link graphs distributing page authority across service silos.</li>
        </ul>
      </div>

      <div class="card" style="padding: 2.25rem;">
        <div class="eyebrow-badge" style="margin-bottom: 0.85rem;">OFF-PAGE AUTHORITY</div>
        <h3 style="font-size: 1.4rem; color: var(--color-text); margin-bottom: 1rem;">Domain Authority &amp; Digital PR</h3>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 1.25rem;">
          Authority is earned through legitimate citations, industry references, and editorial backlinks:
        </p>
        <ul style="padding-left: 1.25rem; margin: 0; font-size: 0.9rem; color: var(--color-text-muted); line-height: 1.6;">
          <li>Digital PR outreach targeting trade publications, podcasts, and engineering journals.</li>
          <li>E-E-A-T (Experience, Expertise, Authoritativeness, Trustworthiness) author byline profiles.</li>
          <li>Competitor backlink gap analysis to uncover high-authority linking opportunities.</li>
          <li>Toxic link profile audits and disavow management to safeguard domain health.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     7. CONTENT STRATEGY
     ============================================================ -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>07 // CONTENT ENGINEERING</span>
      </div>
      <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
        Editorial Content That Outranks &amp; Converts
      </h2>
      <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.25rem;">
        Search engines heavily penalize shallow, AI-generated fluff. Our content creation process relies on domain expertise, concrete case data, actionable code examples, and structured breakdowns that provide authentic value to readers.
      </p>
      <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 0;">
        Every piece of content is engineered with clear key takeaways, responsive diagrams, scannable summary boxes, and context-relevant calls to action that move readers down the decision funnel.
      </p>
    </div>
  </div>
</section>

<!-- ============================================================
     8. LOCAL SEO
     ============================================================ -->
<section class="section">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>08 // REGIONAL VISIBILITY</span>
      </div>
      <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
        Local Search Dominance &amp; Multi-Location Optimization
      </h2>
      <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.75rem;">
        For regional businesses and multi-branch enterprises, capturing high-intent local search queries is essential. We implement complete local search optimization:
      </p>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem;">
        <div style="padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); border-radius: var(--radius-md);">
          <h4 style="font-size: 1.1rem; color: var(--color-text); margin-bottom: 0.5rem;">Google Business Profile (GBP)</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Primary category optimization, verified address records, service menus, review acquisition workflows, and geocoded imagery.</p>
        </div>
        <div style="padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); border-radius: var(--radius-md);">
          <h4 style="font-size: 1.1rem; color: var(--color-text); margin-bottom: 0.5rem;">NAP Citation Consistency</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Synchronizing Name, Address, and Phone details across national directories, map engines, and local chambers of commerce.</p>
        </div>
        <div style="padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid var(--color-slate-200); border-radius: var(--radius-md);">
          <h4 style="font-size: 1.1rem; color: var(--color-text); margin-bottom: 0.5rem;">Local Schema Injection</h4>
          <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">Injecting Schema.org `LocalBusiness` and `PostalAddress` JSON-LD so search engines map service radius and operating hours with precision.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     9. ANALYTICS AND PERFORMANCE TRACKING
     ============================================================ -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>09 // MEASUREMENT &amp; GOVERNANCE</span>
      </div>
      <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
        Full-Funnel Analytics, Conversion Tracking &amp; Reporting
      </h2>
      <p style="font-size: 1.02rem; color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.25rem;">
        We believe in total transparency. Every campaign is tracked using Google Analytics 4 (GA4), Google Search Console, server-side tracking, and custom conversion dashboards:
      </p>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
        <div class="card" style="padding: 1.5rem;">
          <h4 style="font-size: 1rem; color: var(--color-text); margin-bottom: 0.4rem;">Conversion Goal Setup</h4>
          <p style="font-size: 0.85rem; color: var(--color-text-muted); margin: 0;">Tracking form submissions, phone clicks, file downloads, and demo requests.</p>
        </div>
        <div class="card" style="padding: 1.5rem;">
          <h4 style="font-size: 1rem; color: var(--color-text); margin-bottom: 0.4rem;">Search Console Integration</h4>
          <p style="font-size: 0.85rem; color: var(--color-text-muted); margin: 0;">Monitoring organic impression share, click-through rates, indexing errors, and average rank.</p>
        </div>
        <div class="card" style="padding: 1.5rem;">
          <h4 style="font-size: 1rem; color: var(--color-text); margin-bottom: 0.4rem;">Executive Monthly Reports</h4>
          <p style="font-size: 0.85rem; color: var(--color-text-muted); margin: 0;">Plain-language strategic reviews detailing revenue contribution, CAC trends, and next sprint priorities.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     10. OUR DELIVERY PROCESS
     ============================================================ -->
<section class="section">
  <div class="container">
    <div class="section-header text-center" style="max-width: 820px; margin: 0 auto 3rem;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>10 // EXECUTION TIMELINE</span>
      </div>
      <h2 class="section-title">A Structured, Sprint-Based Delivery Process</h2>
      <p class="lead">We deploy our digital marketing and SEO engagements through a proven four-phase engineering roadmap.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
      <div class="card" style="padding: 2rem 1.5rem;">
        <div style="font-family: var(--font-mono); font-size: 1.25rem; font-weight: 800; color: var(--color-secondary); margin-bottom: 0.75rem;">PHASE 01</div>
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Audit &amp; Benchmark</h4>
        <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
          Week 1&ndash;2: Complete technical SEO audit, competitor baseline analysis, keyword opportunity mapping, and tracking hygiene verification.
        </p>
      </div>

      <div class="card" style="padding: 2rem 1.5rem;">
        <div style="font-family: var(--font-mono); font-size: 1.25rem; font-weight: 800; color: var(--color-secondary); margin-bottom: 0.75rem;">PHASE 02</div>
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Technical Remediation</h4>
        <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
          Week 3&ndash;4: Code-level Core Web Vitals remediation, crawl error resolution, XML sitemap rebuild, canonical cleanup, and schema injection.
        </p>
      </div>

      <div class="card" style="padding: 2rem 1.5rem;">
        <div style="font-family: var(--font-mono); font-size: 1.25rem; font-weight: 800; color: var(--color-secondary); margin-bottom: 0.75rem;">PHASE 03</div>
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Content &amp; On-Page</h4>
        <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
          Month 2: Authoritative content expansion, landing page copywriting, on-page optimization, and internal linking architecture rollout.
        </p>
      </div>

      <div class="card" style="padding: 2rem 1.5rem;">
        <div style="font-family: var(--font-mono); font-size: 1.25rem; font-weight: 800; color: var(--color-secondary); margin-bottom: 0.75rem;">PHASE 04</div>
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Scaling &amp; Paid Media</h4>
        <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
          Month 3+: High-intent PPC scaling, digital PR authority building, conversion rate optimization (CRO), and continuous algorithmic monitoring.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     11. DELIVERABLES (PRESERVED & ENHANCED)
     ============================================================ -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div style="max-width: 900px; margin: 0 auto;">
      <div class="eyebrow-badge" style="margin-bottom: 1rem;">
        <span class="pill-dot"></span>
        <span>11 // CORE DELIVERABLES</span>
      </div>
      <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
        Everything Included in Our SEO &amp; Marketing Engagements
      </h2>
      <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-top: 2rem;">
        <?php foreach ($practice['deliverables'] as $idx => $deliv): ?>
          <div class="card" style="padding: 1.75rem 2rem; display: flex; align-items: flex-start; gap: 1.25rem;">
            <div style="width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--color-secondary-soft); color: var(--color-secondary); font-family: var(--font-mono); font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem;">
              0<?= $idx + 1 ?>
            </div>
            <div>
              <h3 style="font-size: 1.2rem; margin-bottom: 0.35rem; color: var(--color-text);"><?= e($deliv) ?></h3>
              <p style="font-size: 0.9rem; color: var(--color-text-muted); margin: 0; line-height: 1.55;">
                Delivered by dedicated digital strategists and technical architects with milestone review sessions.
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     12. FREQUENTLY ASKED QUESTIONS
     ============================================================ -->
<section class="section">
  <div class="container" style="max-width: 860px;">
    <div class="section-header text-center" style="margin-bottom: 2.5rem;">
      <div class="eyebrow-badge">
        <span class="pill-dot"></span>
        <span>12 // QUESTIONS &amp; ANSWERS</span>
      </div>
      <h2 class="section-title">Frequently Asked Questions</h2>
      <p class="lead">Answers to common technical, strategic, and engagement questions about our digital marketing practice.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1rem;">
      <div class="card" style="padding: 1.75rem;">
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">How soon can we expect organic search ranking improvements?</h4>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Technical fixes (resolving crawl blocks, fixing 404s, speed improvements) often show initial indexation gains within 2 to 4 weeks. Competitive keyword ranking and sustained organic traffic growth typically mature across 3 to 6 months of consistent content and authority development.
        </p>
      </div>

      <div class="card" style="padding: 1.75rem;">
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">Do you work directly on our website codebase or just provide recommendations?</h4>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Unlike advisory-only agencies, our engineering division can implement all technical SEO fixes, server configurations, Schema.org code, and Core Web Vitals optimizations directly within your repository via pull requests, or collaborate seamlessly with your in-house engineering team.
        </p>
      </div>

      <div class="card" style="padding: 1.75rem;">
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">How do you measure marketing ROI and prevent ad waste?</h4>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          We enforce closed-loop conversion tracking across GA4, Google Ads, and CRM integrations. We monitor Customer Acquisition Cost (CAC), Return on Ad Spend (ROAS), and Cost Per Qualified Lead (CPL) rather than vanity metrics like raw impressions.
        </p>
      </div>

      <div class="card" style="padding: 1.75rem;">
        <h4 style="font-size: 1.15rem; color: var(--color-text); margin-bottom: 0.5rem;">How does technical SEO interact with website speed and web software development?</h4>
        <p style="font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; margin: 0;">
          Google explicitly uses page experience and Core Web Vitals as ranking criteria. Our <a href="/services/web-software-development" style="color: var(--color-secondary); text-decoration: underline;">Web &amp; Software Development</a> practice works hand-in-hand with our SEO team to ensure sub-second global load times and clean semantic markup.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     13. FINAL CALL TO ACTION
     ============================================================ -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <div class="eyebrow-badge dark" style="margin-bottom: 1.25rem;">
          <span class="pill-dot"></span>
          <span>START SCALING REVENUE</span>
        </div>
        <h2 class="closing-cta-title">Ready to Elevate Your Search Authority &amp; Customer Acquisition?</h2>
        <p class="closing-cta-lead">
          Connect directly with our senior digital growth architects to receive a comprehensive audit of your organic search standing and paid media opportunities.
        </p>
        <div class="closing-cta-buttons">
          <a href="/contact.php?service=<?= urlencode($practice['name']) ?>" class="btn btn-accent btn-lg">
            <span>Request a Project Proposal</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="/audit.php" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php else: ?>

<!-- Practice Scope & Deliverables -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container">
    <div class="hero-grid" style="align-items: flex-start; gap: 4rem;">
      <!-- Detailed Deliverables Column -->
      <div>
        <div class="eyebrow-badge" style="margin-bottom: 1rem;">
          <span class="pill-dot"></span>
          <span>COMPREHENSIVE CAPABILITIES</span>
        </div>
        <h2 style="font-size: 2.1rem; color: var(--color-text); font-weight: 800; margin-bottom: 1.25rem;">
          Service Deliverables &amp; Execution Scope
        </h2>
        <p style="font-size: 1.05rem; color: var(--color-text-muted); line-height: 1.65; margin-bottom: 2.25rem;">
          Our engagements are built around clear deliverables, milestone-based development, and transparent technical documentation.
        </p>

        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
          <?php foreach ($practice['deliverables'] as $idx => $deliv): ?>
            <div class="card" style="padding: 1.75rem 2rem; display: flex; align-items: flex-start; gap: 1.25rem;">
              <div style="width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--color-secondary-soft); color: var(--color-secondary); font-family: var(--font-mono); font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem;">
                0<?= $idx + 1 ?>
              </div>
              <div>
                <h3 style="font-size: 1.2rem; margin-bottom: 0.35rem; color: var(--color-text);"><?= e($deliv) ?></h3>
                <p style="font-size: 0.9rem; color: var(--color-text-muted); margin: 0; line-height: 1.55;">
                  Delivered by specialized engineers and digital strategists adhering to modern web and marketing best practices.
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Practice Sidebar: Benchmark Standards & Related Evidence -->
      <div>
        <div class="enterprise-hud-card" style="margin-bottom: 2.5rem; padding: 2.5rem 2.25rem;">
          <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-accent); margin-bottom: 1rem; letter-spacing: 0.1em; text-transform: uppercase;">
            ● TECHNICAL STANDARDS
          </div>
          <h3 style="color: #ffffff; font-size: 1.4rem; margin-bottom: 1.5rem; line-height: 1.3;">
            Guaranteed Quality Thresholds
          </h3>
          <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($practice['kpis'] as $kpi): ?>
              <div style="background: rgba(255,255,255,0.05); padding: 1rem 1.25rem; border-radius: var(--radius-md); border-left: 3px solid var(--color-accent);">
                <div style="font-family: var(--font-display); font-size: 1.2rem; font-weight: 700; color: #ffffff;">
                  <?= e($kpi) ?>
                </div>
                <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.65); margin-top: 0.25rem;">
                  Industry-Leading Performance Metric
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if ($relatedCase): ?>
          <div class="card" style="padding: 2.25rem 2rem;">
            <div class="eyebrow-badge" style="margin-bottom: 0.85rem; font-size: 0.68rem;">
              RELATED CLIENT SUCCESS
            </div>
            <h4 style="font-size: 1.2rem; margin-bottom: 0.75rem; color: var(--color-text); line-height: 1.35;">
              <a href="/case-study-detail.php?slug=<?= urlencode($relatedCase['slug']) ?>" style="color: var(--color-text); text-decoration: none;">
                <?= e($relatedCase['title']) ?>
              </a>
            </h4>
            <p style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1.25rem; line-height: 1.55;">
              <?= e(substr($relatedCase['challenge'], 0, 140)) ?>...
            </p>
            <a href="/case-study-detail.php?slug=<?= urlencode($relatedCase['slug']) ?>" class="case-card-action">
              <span>Read Full Case Study</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- Closing CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 2rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Ready to Execute on <?= e($practice['short_title']) ?>?</h2>
        <p class="closing-cta-lead">
          Connect with our senior technical architects to discuss your project requirements and receive a formal scope of work.
        </p>
        <div class="closing-cta-buttons">
          <a href="/contact.php?service=<?= urlencode($practice['name']) ?>" class="btn btn-accent btn-lg">
            <span>Request a Project Proposal</span>
            <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>
          <a href="/audit.php" class="btn btn-outline-gold btn-lg">
            <span>Request Free Digital Audit</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
