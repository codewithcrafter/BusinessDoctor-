<?php
/**
 * BusinessDoctor Case Study Detail View - Enterprise IT & Digital Services
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$slug = trim($_GET['slug'] ?? '');

$case = null;
$relatedCases = [];
try {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT * FROM case_studies WHERE slug = ? AND status = 'published' AND is_deleted = 0 LIMIT 1");
    $stmt->execute([$slug]);
    $case = $stmt->fetch();

    if ($case) {
        $relStmt = $pdo->prepare("SELECT * FROM case_studies WHERE id != ? AND status = 'published' AND is_deleted = 0 ORDER BY id DESC LIMIT 2");
        $relStmt->execute([(int)$case['id']]);
        $relatedCases = $relStmt->fetchAll();
    }
} catch (Exception $e) {}

if (!$case) {
    header("Location: " . appUrl('case-studies.php'));
    exit;
}

$pageTitle = (!empty($case['seo_title']) ? $case['seo_title'] : $case['title']) . ' — BusinessDoctor Case Study';
$pageDescription = !empty($case['seo_description']) ? $case['seo_description'] : substr($case['challenge'] ?: $case['project_summary'], 0, 150);
$canonicalUrl = getCaseStudyUrl($case['slug']);

$schemaPageKey = 'case-study-detail';
$schemaContextData = $case;

// Case study specific supporting diagram and tech stack configurations
$caseSpecifics = [
    'fintech-saas-funnel-resuscitation' => [
        'supp_src' => 'uploads/cases/fintech-payment-pipeline-diagram.svg',
        'supp_alt' => 'Automated FinTech Onboarding & Payment Architecture (Illustrative Schematic)',
        'supp_caption' => 'Exhibit B — Zero-friction client provisioning flow replacing legacy manual verification gates.',
        'supp_badge' => 'INTEGRATION TOPOLOGY',
        'tech_stack' => ['Next.js 14 App Router', 'Stripe Issuing & Vault API', 'Redis Enterprise Idempotency', 'Cloudflare Edge SSR', 'PostgreSQL Timescale', 'Tailwind CSS Design System', 'Plaid KYC Webhooks'],
        'workflow' => [
            ['step' => '01', 'title' => 'Diagnostic Funnel Telemetry', 'desc' => 'Instrumented full session recordings and micro-latency timers to identify exact user drop-off during payment collection.'],
            ['step' => '02', 'title' => 'Decoupled Micro-Auth Engine', 'desc' => 'Architected asynchronous KYC bureau checks and tokenized Stripe vaulting to reduce user friction from 7 screens to 1.'],
            ['step' => '03', 'title' => 'Edge Canary Deployment', 'desc' => 'Deployed new conversion funnel on Cloudflare Workers edge nodes with automated rollback thresholds and continuous health checks.'],
            ['step' => '04', 'title' => 'Outcome Verification', 'desc' => 'Validated +312% pipeline lift and $908 customer acquisition cost reduction across 90 days of live production traffic.']
        ]
    ],
    'd2c-apparel-vital-infrastructure-overhaul' => [
        'supp_src' => 'uploads/cases/d2c-inventory-routing-topology.svg',
        'supp_alt' => 'D2C Edge Distribution & Multi-Warehouse Routing Topology (Illustrative Schematic)',
        'supp_caption' => 'Exhibit B — Decoupled edge caching and asynchronous inventory routing across regional fulfillment hubs.',
        'supp_badge' => 'EDGE TOPOLOGY',
        'tech_stack' => ['Headless Hydrogen React PWA', 'Shopify Storefront API', 'Cloudflare Workers & KV', 'Redis Order Queue', 'Fastly Image Transcoding', 'Kaviyo Event Webhooks', 'ERP Real-Time Inventory Sync'],
        'workflow' => [
            ['step' => '01', 'title' => 'Stress-Testing & Concurrency Audit', 'desc' => 'Simulated 50,000 concurrent checkout sessions to isolate database locks and slow liquid template compilation.'],
            ['step' => '02', 'title' => 'Headless Composable Re-Platforming', 'desc' => 'Built ultra-fast React PWA with optimistic cart state and sub-second catalog hydration on global CDN edge.'],
            ['step' => '03', 'title' => 'Real-Time Inventory Lock Engine', 'desc' => 'Engineered distributed Redis queuing to synchronize warehouse inventory levels with zero race conditions.'],
            ['step' => '04', 'title' => 'Peak Flash Sale Delivery', 'desc' => 'Achieved 99.98% uptime and processed 18,500 transactions per minute during peak BFCM event without a single dropped cart.']
        ]
    ],
    'multichannel-retail-marketplace-dominance' => [
        'supp_src' => 'uploads/cases/omnichannel-catalog-sync-architecture.svg',
        'supp_alt' => 'Omnichannel Feed Pipeline & Rate-Limiting Architecture (Illustrative Schematic)',
        'supp_caption' => 'Exhibit B — Asynchronous data processing pipeline ensuring continuous catalog integrity across merchant APIs.',
        'supp_badge' => 'PIPELINE SCHEMATIC',
        'tech_stack' => ['Amazon SP-API v2', 'Walmart Marketplace REST', 'eBay Trading API', 'Node.js Event Bus', 'RabbitMQ Distributed Queue', 'Elasticsearch Master Catalog', 'Automated Margin Repricer'],
        'workflow' => [
            ['step' => '01', 'title' => 'Catalog Synchronization Audit', 'desc' => 'Audited multi-platform SKU drift, out-of-sync inventory feeds, and algorithmic pricing margin discrepancies.'],
            ['step' => '02', 'title' => 'Central Master PIM Bus', 'desc' => 'Unified 48,000 SKUs into a canonical master database with automated channel-specific taxonomy formatting.'],
            ['step' => '03', 'title' => 'Dynamic Margin Repricing Engine', 'desc' => 'Built algorithmic repricing bot with margin safety floors to continuously win Buy Box placement against third-party sellers.'],
            ['step' => '04', 'title' => 'Continuous Automation', 'desc' => 'Reduced catalog sync latency from 4 hours to 8 seconds, capturing 84% Buy Box share across top revenue categories.']
        ]
    ]
];

$spec = $caseSpecifics[$case['slug']] ?? [
    'supp_src' => 'uploads/cases/fintech-payment-pipeline-diagram.svg',
    'supp_alt' => 'System Integration Topology (Illustrative Schematic)',
    'supp_caption' => 'Exhibit B — Architectural integration diagram illustrating system data flow and automated logic.',
    'supp_badge' => 'ARCHITECTURE EXHIBIT',
    'tech_stack' => ['Enterprise Web Architecture', 'Custom API Integrations', 'Cloud Edge Infrastructure', 'Automated Telemetry', 'Secure Database Persistence'],
    'workflow' => [
        ['step' => '01', 'title' => 'Comprehensive Architecture Audit', 'desc' => 'Deep technical analysis of existing operational bottlenecks and latency drivers.'],
        ['step' => '02', 'title' => 'Custom Engine Engineering', 'desc' => 'Architecting modular, highly maintainable digital solutions tailored to business requirements.'],
        ['step' => '03', 'title' => 'Production Deployment & Hardening', 'desc' => 'Zero-downtime rollout with strict data validation and monitoring.'],
        ['step' => '04', 'title' => 'Continuous Telemetry Verification', 'desc' => 'Post-deployment verification against agreed performance indicators.']
    ]
];

$caseCover = !empty($case['featured_image']) ? $case['featured_image'] : 'uploads/cases/fintech-saas-funnel-architecture-cover.svg';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Hero -->
<section class="section hero-enterprise" style="padding-top: 5rem; padding-bottom: 3.5rem;">
  <div class="container" style="max-width: 960px;">
    <!-- Breadcrumb & Badges -->
    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
      <a href="<?= appUrl('case-studies.php') ?>" class="text-link" style="color: #06B5F9; font-family: var(--font-mono); font-size: 0.8rem;">
        &larr; ALL CASE STUDIES
      </a>
      <span style="color: rgba(255,255,255,0.3);">/</span>
      <span class="eyebrow-badge" style="margin-bottom: 0; font-size: 0.72rem;">
        <?= e($case['industry'] ?: $case['client_industry']) ?>
      </span>
      <span style="font-family: var(--font-mono); font-size: 0.8rem; color: #06B5F9; font-weight: 700;">
        <?= e($case['service_category'] ?: $case['practice_area']) ?>
      </span>
    </div>

    <h1 class="hero-headline-oversized" style="font-size: clamp(2.2rem, 4vw, 3.4rem); margin-bottom: 1.5rem; line-height: 1.25;">
      <?= e($case['title']) ?>
    </h1>

    <!-- Transformation Metric HUD -->
    <?php if (!empty($case['outcome_metric'])): ?>
      <div class="enterprise-hud-card" style="padding: 2rem 2.25rem; margin-top: 1.75rem;">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--color-accent); text-transform: uppercase; margin-bottom: 1rem; font-weight: 700; letter-spacing: 0.1em;">
          ● VERIFIED OUTCOME METRIC
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: center;">
          <?php if (!empty($case['baseline_metric'])): ?>
            <div>
              <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">PRE-ENGAGEMENT BASELINE</div>
              <div style="font-size: 1.25rem; color: #fca5a5; text-decoration: line-through; font-family: var(--font-display); font-weight: 700; margin-top: 0.25rem;">
                <?= e($case['baseline_metric']) ?>
              </div>
            </div>
          <?php endif; ?>
          <div>
            <div style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--color-accent); text-transform: uppercase; font-weight: 700;">VERIFIED OUTCOME</div>
            <div style="font-size: 2rem; color: var(--color-accent); font-family: var(--font-display); font-weight: 800; margin-top: 0.25rem; line-height: 1.1;">
              <?= e($case['outcome_metric']) ?>
            </div>
          </div>
          <div>
            <div style="font-family: var(--font-mono); font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase;">PRIMARY KPI</div>
            <div style="font-size: 1.1rem; color: #ffffff; font-family: var(--font-display); font-weight: 700; margin-top: 0.25rem;">
              <?= e($case['metric_label'] ?: 'Operational Performance') ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Deep Dive Case Body -->
<section class="section" style="background-color: var(--color-surface); border-top: 1px solid var(--color-slate-200); border-bottom: 1px solid var(--color-slate-200);">
  <div class="container" style="max-width: 920px;">
    
    <!-- Hero Cover Image Exhibit -->
    <figure style="margin: 0 0 3.5rem 0;">
      <div style="border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-slate-200); box-shadow: var(--shadow-md); background: #071224;">
        <img src="<?= getAssetUrl($caseCover) ?>" alt="<?= e($case['cover_image_alt'] ?: $case['title']) ?>" style="width: 100%; max-height: 520px; object-fit: cover; display: block; aspect-ratio: 16 / 9;">
      </div>
      <figcaption style="margin-top: 0.85rem; font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-muted); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
        <span><?= e($case['cover_image_alt'] ?: $case['title']) ?></span>
        <span style="color: #06B5F9; font-weight: 700; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3);">
          EXHIBIT A — ENGAGEMENT OVERVIEW
        </span>
      </figcaption>
    </figure>

    <!-- Client & Industry Overview Card -->
    <div class="card" style="margin-bottom: 3.5rem; padding: 2rem 2.25rem; background: var(--color-card-bg); border: 1px solid var(--color-slate-200); border-radius: var(--radius-lg);">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <div>
          <div style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--color-text-muted); text-transform: uppercase;">INDUSTRY DISCIPLINE</div>
          <div style="font-size: 1.05rem; font-weight: 700; color: var(--color-text); margin-top: 0.25rem;">
            <?= e($case['client_industry'] ?: $case['industry']) ?>
          </div>
        </div>
        <div>
          <div style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--color-text-muted); text-transform: uppercase;">PRACTICE AREA</div>
          <div style="font-size: 1.05rem; font-weight: 700; color: #06B5F9; margin-top: 0.25rem;">
            <?= e($case['practice_area'] ?: $case['service_category']) ?>
          </div>
        </div>
        <div>
          <div style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--color-text-muted); text-transform: uppercase;">ENGAGEMENT MODEL</div>
          <div style="font-size: 1.05rem; font-weight: 700; color: var(--color-text); margin-top: 0.25rem;">
            Diagnostic &amp; Turnkey Engineering
          </div>
        </div>
        <div>
          <div style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--color-text-muted); text-transform: uppercase;">DEPLOYMENT STATUS</div>
          <div style="font-size: 1.05rem; font-weight: 700; color: #22c55e; margin-top: 0.25rem;">
            ● 100% Verified in Production
          </div>
        </div>
      </div>
    </div>

    <!-- 01 // OVERVIEW & CHALLENGE -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        01 // THE CHALLENGE &amp; BOTTLENECKS
      </div>
      <h2 style="font-size: 1.85rem; color: var(--color-text); margin-bottom: 1rem; font-weight: 800;">
        Critical Operational &amp; Revenue Roadblocks
      </h2>
      <div style="font-size: 1.05rem; line-height: 1.75; color: var(--color-text-muted);">
        <?= nl2br(e($case['challenge'] ?: $case['project_summary'])) ?>
      </div>
    </div>

    <!-- 02 // ARCHITECTURE & SOLUTION -->
    <div style="margin-bottom: 3.5rem; background: var(--color-card-bg); padding: 2.75rem; border-radius: var(--radius-xl); border: 1px solid var(--color-slate-200); border-left: 4px solid #06B5F9; box-shadow: var(--shadow-sm);">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        02 // THE STRATEGY &amp; IMPLEMENTATION
      </div>
      <h2 style="font-size: 1.85rem; margin-bottom: 1rem; color: var(--color-text); font-weight: 800;">
        Engineering Solution &amp; Execution
      </h2>
      <div style="font-size: 1.05rem; line-height: 1.75; color: var(--color-text); margin: 0;">
        <?= nl2br(e($case['solution'] ?: $case['prescription'])) ?>
      </div>
    </div>

    <!-- 03 // SUPPORTING ARCHITECTURE DIAGRAM -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        03 // ARCHITECTURAL BLUEPRINT
      </div>
      <h2 style="font-size: 1.85rem; color: var(--color-text); margin-bottom: 1.25rem; font-weight: 800;">
        Deployed System Topology
      </h2>
      <figure style="margin: 0;">
        <div style="border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--color-slate-200); box-shadow: var(--shadow-md); background: #071224;">
          <img src="<?= getAssetUrl($spec['supp_src']) ?>" alt="<?= e($spec['supp_alt']) ?>" style="width: 100%; max-height: 500px; object-fit: cover; display: block; aspect-ratio: 16 / 9;">
        </div>
        <figcaption style="margin-top: 0.85rem; font-family: var(--font-mono); font-size: 0.78rem; color: var(--color-text-muted); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
          <span><?= e($spec['supp_caption']) ?></span>
          <span style="color: #06B5F9; font-weight: 700; background: rgba(6, 181, 249, 0.12); padding: 0.2rem 0.5rem; border-radius: 4px; border: 1px solid rgba(6, 181, 249, 0.3);">
            <?= e($spec['supp_badge']) ?>
          </span>
        </figcaption>
      </figure>
    </div>

    <!-- 04 // TECHNOLOGIES & TOOLS USED -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        04 // TECHNICAL STACK
      </div>
      <h2 style="font-size: 1.85rem; color: var(--color-text); margin-bottom: 1.25rem; font-weight: 800;">
        Tools &amp; Technologies Deployed
      </h2>
      <div style="display: flex; gap: 0.65rem; flex-wrap: wrap;">
        <?php foreach ($spec['tech_stack'] as $t): ?>
          <span style="background: rgba(6, 181, 249, 0.12); color: #06B5F9; border: 1px solid rgba(6, 181, 249, 0.3); font-family: var(--font-mono); font-size: 0.85rem; padding: 0.45rem 0.85rem; border-radius: var(--radius-sm); font-weight: 600;">
            <?= e($t) ?>
          </span>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 05 // PROJECT DELIVERY WORKFLOW -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        05 // PROJECT WORKFLOW
      </div>
      <h2 style="font-size: 1.85rem; color: var(--color-text); margin-bottom: 1.5rem; font-weight: 800;">
        Execution &amp; Delivery Methodology
      </h2>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
        <?php foreach ($spec['workflow'] as $wf): ?>
          <div class="card" style="padding: 1.5rem; background: var(--color-card-bg); border-top: 3px solid #06B5F9;">
            <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 800; margin-bottom: 0.4rem;">
              STAGE <?= e($wf['step']) ?>
            </div>
            <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--color-text); margin-bottom: 0.5rem;">
              <?= e($wf['title']) ?>
            </h4>
            <p style="font-size: 0.85rem; color: var(--color-text-muted); line-height: 1.55; margin: 0;">
              <?= e($wf['desc']) ?>
            </p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 06 // IMPLEMENTATION NOTES (if present) -->
    <?php if (!empty($case['implementation'])): ?>
      <div style="margin-bottom: 3.5rem; padding: 2rem; background: rgba(6, 181, 249, 0.04); border: 1px solid rgba(6, 181, 249, 0.2); border-radius: var(--radius-lg);">
        <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem;">
          06 // DEPLOYMENT &amp; HARDENING NOTES
        </div>
        <div style="font-size: 1rem; line-height: 1.7; color: var(--color-text);">
          <?= nl2br(e($case['implementation'])) ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- 07 // MEASURED RESULTS & OUTCOMES -->
    <div style="margin-bottom: 3.5rem;">
      <div style="font-family: var(--font-mono); font-size: 0.75rem; color: #06B5F9; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
        07 // MEASURED OUTCOMES
      </div>
      <h2 style="font-size: 1.85rem; color: var(--color-text); margin-bottom: 1rem; font-weight: 800;">
        Long-Term Business &amp; Technical Impact
      </h2>
      <div style="font-size: 1.05rem; line-height: 1.75; color: var(--color-text-muted);">
        <?= nl2br(e($case['results'] ?: $case['result_description'])) ?>
      </div>
    </div>

    <!-- Executive Quote -->
    <?php if (!empty($case['quote_text'])): ?>
      <div class="card" style="padding: 2.25rem 2.5rem; margin-bottom: 3.5rem; border-left: 4px solid #06B5F9; background: var(--color-card-bg);">
        <p style="font-size: 1.15rem; font-style: italic; color: var(--color-text); line-height: 1.7; margin-bottom: 1rem;">
          &ldquo;<?= e($case['quote_text']) ?>&rdquo;
        </p>
        <div style="font-family: var(--font-mono); font-size: 0.85rem; color: #06B5F9; font-weight: 700;">
          — <?= e($case['quote_author']) ?><?= !empty($case['quote_title']) ? ', ' . e($case['quote_title']) : '' ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Related Case Studies -->
    <?php if (!empty($relatedCases)): ?>
      <div style="border-top: 1px solid var(--color-slate-200); padding-top: 3.5rem; margin-top: 3.5rem;">
        <h3 style="font-size: 1.45rem; font-weight: 800; color: var(--color-text); margin-bottom: 1.75rem;">
          Related Enterprise Transformations
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
          <?php foreach ($relatedCases as $rc): 
            $rcImg = !empty($rc['featured_image']) ? $rc['featured_image'] : 'uploads/cases/fintech-saas-funnel-architecture-cover.svg';
          ?>
            <div class="card" style="padding: 0; display: flex; flex-direction: column; overflow: hidden; border-radius: var(--radius-md);">
              <div style="width: 100%; aspect-ratio: 16 / 9; overflow: hidden; background: #071224;">
                <a href="<?= getCaseStudyUrl($rc['slug']) ?>">
                  <img src="<?= getAssetUrl($rcImg) ?>" alt="<?= e($rc['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </a>
              </div>
              <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                <span class="eyebrow-badge" style="margin-bottom: 0.75rem; font-size: 0.68rem; align-self: flex-start;">
                  <?= e($rc['client_industry'] ?: $rc['industry']) ?>
                </span>
                <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--color-text); line-height: 1.4; margin-bottom: 0.75rem;">
                  <a href="<?= getCaseStudyUrl($rc['slug']) ?>" style="color: var(--color-text); text-decoration: none;">
                    <?= e($rc['title']) ?>
                  </a>
                </h4>
                <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.55; margin-bottom: 1.25rem; flex-grow: 1;">
                  <?= e(mb_strimwidth($rc['challenge'] ?: $rc['project_summary'], 0, 120, '...')) ?>
                </p>
                <a href="<?= getCaseStudyUrl($rc['slug']) ?>" class="text-link" style="color: #06B5F9; font-size: 0.85rem; font-weight: 700;">
                  Examine Case Study &rarr;
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Closing Consultation CTA -->
<section class="section" style="background: var(--color-bg); padding-top: 3rem; padding-bottom: 4rem;">
  <div class="container text-center">
    <div class="enterprise-closing-cta">
      <div class="closing-cta-content">
        <h2 class="closing-cta-title">Ready to Eliminate Critical Friction in Your Enterprise?</h2>
        <p class="closing-cta-lead">
          Partner directly with our senior digital strategists and technical architects. We will conduct an end-to-end diagnostic audit of your systems.
        </p>
        <div class="closing-cta-buttons">
          <a href="<?= appUrl('audit.php') ?>" class="btn btn-accent btn-lg">
            <span>Request Diagnostic Audit</span>
          </a>
          <a href="<?= appUrl('contact.php') ?>" class="btn btn-outline-gold btn-lg">
            <span>Schedule Discovery Session</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
