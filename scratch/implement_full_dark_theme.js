const fs = require('fs');

console.log('Starting Full Dark Theme Implementation...');

// ============================================================
// 1. UPDATE variables.css
// ============================================================
const newVariables = `/**
 * BusinessDoctor Enterprise Design Tokens & CSS Variables
 * STRICT FULL DARK THEME (Aubergine & Rose Gold):
 * Primary Background: #211922 (Deepest Dark Aubergine)
 * Deep Aubergine: #332633 (Card & Section Surface)
 * Elevated Dark Surface: #382A38 (Hover & Active Insets)
 * Secondary Dark Surface: #291F29 (Navbar, HUD, Sidebars, Inputs)
 * Rich Plum: #574054 (Secondary Headers & Active States)
 * Muted Rose: #A17E91 (Badges, Accents, Secondary Dividers)
 * Rose Gold: #D9B7B8 (Highlights, Links, Stat Numerals)
 * Primary Text: #F7F1F3 (Soft Blush Crisp Light Text)
 * Secondary Text: #C6B5C2 (Editorial Body Text)
 * Subtle Border: rgba(217, 183, 184, 0.20)
 */

:root {
  /* Strict Brand Dark System Tokens */
  --color-primary: #332633;         /* Deep Aubergine Surface */
  --color-secondary: #574054;       /* Rich Plum */
  --color-accent: #A17E91;          /* Muted Rose */
  --color-highlight: #D9B7B8;       /* Rose Gold */
  --color-background: #211922;      /* Primary Dark Background */
  --color-surface: #332633;         /* Deep Aubergine Surface */
  --color-surface-elevated: #382A38;/* Elevated Dark Surface */
  --color-dark-surface: #291F29;    /* Secondary Dark Surface */
  --color-soft-surface: #382A38;    /* Subtle Dark Surface */
  --color-text: #F7F1F3;            /* Primary Light Text */
  --color-muted: #C6B5C2;           /* Secondary Muted Text */
  --color-border: rgba(217, 183, 184, 0.20); /* Subtle Rose Gold Border */

  /* Semantic Extended Variables */
  --color-primary-dark: #211922;    /* Deepest Dark Background */
  --color-primary-light: #574054;   /* Rich Plum */
  
  --color-secondary-light: #6e526a; /* Mid Plum */
  --color-secondary-soft: rgba(87, 64, 84, 0.35);  /* Dark Plum Soft */
  
  --color-accent-hover: #D9B7B8;    /* Rose Gold Hover */
  --color-accent-soft: rgba(161, 126, 145, 0.20); /* Muted Rose Soft */
  --color-accent-border: rgba(217, 183, 184, 0.25); /* Rose Gold Border */
  
  --color-bg: #211922;              /* Primary Dark Canvas */
  --color-surface-muted: #291F29;   /* Inset Fill */
  --color-surface-dark: #211922;    /* Darkest Surface */
  
  --color-text-muted: #C6B5C2;      /* Editorial Secondary Text */
  --color-text-light: #A17E91;      /* Micro Meta & Captions (Muted Rose) */
  --color-text-inverse: #211922;    /* Dark text on light chips */

  /* Backward Compatibility Aliases for Dark Theme */
  --color-obsidian: #211922;
  --color-navy: #291F29;
  --color-slate-900: #F7F1F3;        /* High-contrast headings */
  --color-slate-800: #F7F1F3;        /* High-contrast subheadings */
  --color-slate-700: #C6B5C2;        /* Readable paragraph text */
  --color-slate-600: #C6B5C2;        /* Secondary copy */
  --color-slate-500: #A17E91;        /* Muted accents */
  --color-slate-400: #886578;        /* Subtle accents */
  --color-slate-200: rgba(217, 183, 184, 0.20); /* Light Border to Rose Gold Border */
  --color-slate-100: #291F29;        /* Dark Inset */
  --color-slate-50: #211922;         /* Dark Page Canvas */
  --color-white: #332633;            /* Remap white surfaces to Deep Aubergine */

  --color-teal-600: #D9B7B8;        /* Links in Rose Gold */
  --color-teal-500: #F7F1F3;        /* Hover in Soft Blush */
  --color-teal-400: #D9B7B8;        /* Highlights */
  --color-teal-100: rgba(87, 64, 84, 0.35);
  --color-teal-50: #291F29;

  /* Status Badges */
  --color-alert-amber: #f59e0b;
  --color-alert-amber-soft: rgba(245, 158, 11, 0.18);
  --color-success-green: #10b981;
  --color-danger-crimson: #ef4444;

  /* Typography Stack */
  --font-display: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-mono: 'JetBrains Mono', 'Space Mono', Consolas, Monaco, monospace;

  /* Elevation Shadows & Layering (Deep Dark Shadows) */
  --shadow-sm: 0 2px 4px 0 rgba(0, 0, 0, 0.35);
  --shadow-md: 0 4px 12px -1px rgba(0, 0, 0, 0.45), 0 2px 4px -2px rgba(0, 0, 0, 0.3);
  --shadow-lg: 0 12px 28px -4px rgba(0, 0, 0, 0.55), 0 4px 6px -4px rgba(0, 0, 0, 0.3);
  --shadow-xl: 0 24px 44px -6px rgba(0, 0, 0, 0.70), 0 12px 16px -6px rgba(0, 0, 0, 0.3);
  --shadow-glow: 0 0 30px rgba(217, 183, 184, 0.25);
  --shadow-teal-glow: 0 0 30px rgba(161, 126, 145, 0.25);
  --shadow-dark: 0 20px 45px -10px rgba(0, 0, 0, 0.75);

  /* Layout Boundaries */
  --container-max: 1320px;
  --container-wide: 1440px;
  --container-narrow: 1040px;
  --header-height: 84px;

  /* Radii */
  --radius-xs: 2px;
  --radius-sm: 6px;
  --radius-md: 10px;
  --radius-lg: 16px;
  --radius-xl: 24px;
  --radius-pill: 9999px;

  /* Transitions */
  --transition-fast: 160ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-normal: 280ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-smooth: 450ms cubic-bezier(0.16, 1, 0.3, 1);
}
`;

fs.writeFileSync('assets/css/variables.css', newVariables, 'utf8');
console.log('Wrote assets/css/variables.css');

// ============================================================
// 2. UPDATE base.css
// ============================================================
let baseCss = fs.readFileSync('assets/css/base.css', 'utf8');

// Ensure body background is #211922 and text is #F7F1F3
baseCss = baseCss.replace(/background-color:\s*var\(--color-slate-50\);/g, 'background-color: var(--color-background);');
baseCss = baseCss.replace(/color:\s*var\(--color-slate-600\);/g, 'color: var(--color-text);');
baseCss = baseCss.replace(/color:\s*var\(--color-slate-900\);/g, 'color: var(--color-text);');
baseCss = baseCss.replace(/border:\s*1px solid var\(--color-slate-200\);/g, 'border: 1px solid var(--color-border);');

// Card
baseCss = baseCss.replace(/\.card\s*\{[\s\S]*?padding:/m, (m) => {
  return `.card {\n  background: var(--color-surface);\n  border: 1px solid var(--color-border);\n  color: var(--color-text);\n  border-radius: var(--radius-lg);\n  padding:`;
});

// Pill tag
baseCss = baseCss.replace(/\.pill-tag\s*\{[\s\S]*?border-radius:[^;]+;/m, (m) => {
  return `.pill-tag {\n  display: inline-flex;\n  align-items: center;\n  gap: 0.5rem;\n  font-family: var(--font-mono);\n  font-size: 0.78rem;\n  font-weight: 700;\n  letter-spacing: 0.08em;\n  text-transform: uppercase;\n  padding: 0.35rem 0.85rem;\n  border-radius: var(--radius-pill);\n  background: rgba(217, 183, 184, 0.12);\n  color: var(--color-highlight);\n  border: 1px solid rgba(217, 183, 184, 0.25);`;
});

fs.writeFileSync('assets/css/base.css', baseCss, 'utf8');
console.log('Updated assets/css/base.css');

// ============================================================
// 3. APPEND EXPLICIT DARK THEME OVERRIDES TO components.css
// ============================================================
const darkThemeOverrides = `

/* ============================================================
   STRICT FULL DARK THEME OVERRIDES (CRITICAL CORRECTION)
   ============================================================ */

/* 1. Global Section Backgrounds */
.section {
  background-color: var(--color-background);
  color: var(--color-text);
}

.section-title {
  color: var(--color-text) !important;
}

.eyebrow-badge {
  background: rgba(217, 183, 184, 0.12) !important;
  color: var(--color-highlight) !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
}

/* 2. Navbar & Header */
.site-header {
  background: rgba(41, 31, 41, 0.96) !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.site-header.scrolled {
  background: rgba(33, 25, 34, 0.98) !important;
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.6) !important;
}

.brand-logo {
  color: #F7F1F3 !important;
}

.brand-logo span {
  color: #D9B7B8 !important;
}

.nav-link {
  color: #F7F1F3 !important;
}

.nav-link:hover {
  color: #D9B7B8 !important;
  background-color: rgba(217, 183, 184, 0.12) !important;
}

.nav-link.active {
  color: #D9B7B8 !important;
  background-color: rgba(217, 183, 184, 0.18) !important;
}

.mega-menu {
  background: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
}

.mobile-drawer {
  background: #291F29 !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.25) !important;
}

.mobile-nav-link {
  color: #F7F1F3 !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.12) !important;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
  color: #D9B7B8 !important;
}

/* 3. Buttons */
.btn-primary {
  background-color: #574054 !important;
  color: #F7F1F3 !important;
  border: 1px solid #D9B7B8 !important;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4) !important;
}

.btn-primary:hover {
  background-color: #D9B7B8 !important;
  color: #211922 !important;
  border-color: #D9B7B8 !important;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(217, 183, 184, 0.3) !important;
}

.btn-secondary {
  background-color: #291F29 !important;
  color: #F7F1F3 !important;
  border: 1px solid rgba(217, 183, 184, 0.35) !important;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3) !important;
}

.btn-secondary:hover {
  background-color: #382A38 !important;
  color: #D9B7B8 !important;
  border-color: #D9B7B8 !important;
  transform: translateY(-2px);
}

.btn-accent {
  background-color: #D9B7B8 !important;
  color: #211922 !important;
  border: 1px solid #D9B7B8 !important;
}

.btn-accent:hover {
  background-color: #F7F1F3 !important;
  color: #211922 !important;
  box-shadow: 0 0 20px rgba(217, 183, 184, 0.4) !important;
}

/* 4. Hero Section */
.hero-scroll-track {
  background: #211922 !important;
}

.hero-sticky-stage {
  background: radial-gradient(circle at 50% 20%, rgba(87, 64, 84, 0.4) 0%, transparent 70%),
              radial-gradient(circle at 80% 80%, rgba(161, 126, 145, 0.2) 0%, transparent 60%),
              #211922 !important;
}

.hero-headline-oversized,
.revealed-headline {
  color: #F7F1F3 !important;
}

.text-gradient-pine {
  background: linear-gradient(135deg, #F7F1F3 0%, #D9B7B8 50%, #A17E91 100%) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  background-clip: text !important;
}

.hero-lead-text,
.revealed-desc {
  color: #C6B5C2 !important;
}

.enterprise-hud-card {
  background: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
}

.hud-metric-card {
  background: #211922 !important;
  border: 1px solid rgba(217, 183, 184, 0.18) !important;
}

.hud-metric-val {
  color: #F7F1F3 !important;
}

.hud-metric-label {
  color: #D9B7B8 !important;
}

.hud-capabilities-strip {
  background: #211922 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  color: #F7F1F3 !important;
}

.hud-footnote {
  color: #A17E91 !important;
}

/* 5. Mission & Vision (Both Panels Dark) */
.mission-vision-section {
  background-color: #211922 !important;
  border-top: 1px solid rgba(217, 183, 184, 0.20) !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.mv-panel-mission {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45) !important;
}

.mv-panel-vision {
  background: #382A38 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45) !important;
}

.mv-heading-light,
.mv-heading-dark {
  color: #F7F1F3 !important;
}

.mv-statement-light,
.mv-statement-dark {
  color: #C6B5C2 !important;
}

.mv-icon-emerald {
  background: rgba(161, 126, 145, 0.22) !important;
  color: #D9B7B8 !important;
  border: 1px solid rgba(217, 183, 184, 0.35) !important;
}

.mv-icon-ivory {
  background: rgba(217, 183, 184, 0.22) !important;
  color: #D9B7B8 !important;
  border: 1px solid rgba(217, 183, 184, 0.35) !important;
}

.mv-eyebrow,
.mv-eyebrow-dark {
  color: #D9B7B8 !important;
}

.mv-pillar-tag,
.mv-pillar-dark {
  background: rgba(217, 183, 184, 0.12) !important;
  color: #F7F1F3 !important;
  border: 1px solid rgba(217, 183, 184, 0.22) !important;
}

.vital-ticker {
  background: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45) !important;
}

.vital-number {
  color: #D9B7B8 !important;
}

.vital-label {
  color: #C6B5C2 !important;
}

.vital-item:not(:last-child)::after {
  background: rgba(217, 183, 184, 0.20) !important;
}

/* 6. 5-Stage Framework */
.stage-carousel-section {
  background: #211922 !important;
  border-top: 1px solid rgba(217, 183, 184, 0.20) !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.stage-card,
.approach-card {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4) !important;
  color: #F7F1F3 !important;
}

.stage-card:hover,
.approach-card:hover {
  border-color: #D9B7B8 !important;
  box-shadow: 0 20px 42px rgba(0, 0, 0, 0.5) !important;
}

.stage-card.is-active {
  border-color: #D9B7B8 !important;
  background: #382A38 !important;
}

.stage-card-title {
  color: #F7F1F3 !important;
}

.stage-card-desc {
  color: #C6B5C2 !important;
}

.stage-watermark {
  color: rgba(217, 183, 184, 0.08) !important;
}

.stage-pill {
  background: #291F29 !important;
  color: #C6B5C2 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.stage-pill.active {
  background: #574054 !important;
  color: #F7F1F3 !important;
  border-color: #D9B7B8 !important;
}

.stage-nav-btn {
  background: #291F29 !important;
  color: #F7F1F3 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
}

.stage-nav-btn:hover:not(:disabled) {
  background: #574054 !important;
  color: #D9B7B8 !important;
  border-color: #D9B7B8 !important;
}

.stage-counter-badge {
  background: #291F29 !important;
  color: #C6B5C2 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.stage-counter-badge .active-num {
  color: #D9B7B8 !important;
}

.stage-drag-hint {
  color: #C6B5C2 !important;
  background: rgba(217, 183, 184, 0.10) !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.approach-deliverables-header {
  color: #D9B7B8 !important;
  border-top-color: rgba(217, 183, 184, 0.18) !important;
}

.approach-deliverable {
  color: #F7F1F3 !important;
}

/* 7. Featured Capabilities / Services Section */
.capabilities-nav-bar {
  background: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.cap-tab-btn {
  background: #291F29 !important;
  color: #C6B5C2 !important;
  border: 1px solid rgba(217, 183, 184, 0.15) !important;
}

.cap-tab-btn:hover {
  background: #332633 !important;
  color: #D9B7B8 !important;
}

.cap-tab-btn.active {
  background: #574054 !important;
  color: #F7F1F3 !important;
  border-color: #D9B7B8 !important;
}

.capability-editorial-card {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45) !important;
}

.cap-card-body {
  background: #332633 !important;
}

.cap-card-title {
  color: #F7F1F3 !important;
}

.cap-card-desc {
  color: #C6B5C2 !important;
}

.cap-deliverable-item {
  color: #F7F1F3 !important;
}

.cap-deliverable-item svg {
  color: #D9B7B8 !important;
}

.cap-card-sidebar {
  background: #291F29 !important;
  border-left: 1px solid rgba(217, 183, 184, 0.18) !important;
}

/* 8. Transformation Section (Vendor Matrix) */
.transformation-section {
  background: #211922 !important;
  border-top: 1px solid rgba(217, 183, 184, 0.20) !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.matrix-card.symptom {
  background: #291F29 !important;
  border: 1px solid rgba(239, 68, 68, 0.35) !important;
  color: #F7F1F3 !important;
}

.matrix-card.cure {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.35) !important;
  color: #F7F1F3 !important;
}

/* 9. Measurable Accountability */
.accountability-section {
  background: #211922 !important;
  border-top: 1px solid rgba(217, 183, 184, 0.20) !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.accountability-card {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45) !important;
}

.accountability-card:hover {
  border-color: #D9B7B8 !important;
  box-shadow: 0 24px 48px rgba(0, 0, 0, 0.55), 0 0 20px rgba(217, 183, 184, 0.20) !important;
}

.accountability-card-visual {
  background: #291F29 !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.accountability-card-body {
  background: #332633 !important;
}

.accountability-card-title {
  color: #F7F1F3 !important;
}

.accountability-card-desc {
  color: #C6B5C2 !important;
}

.accountability-card-footer {
  border-top: 1px solid rgba(217, 183, 184, 0.15) !important;
}

.accountability-micro-badge {
  color: #D9B7B8 !important;
}

.connector-marker {
  background: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
  color: #F7F1F3 !important;
}

/* 10. Case Studies & Perspectives */
.case-editorial-card {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4) !important;
}

.case-card-header {
  background: #291F29 !important;
  border-bottom: 1px solid rgba(217, 183, 184, 0.15) !important;
}

.case-card-title {
  color: #F7F1F3 !important;
}

.case-card-summary {
  color: #C6B5C2 !important;
}

.case-quote-box {
  background: #291F29 !important;
  border-left: 3px solid #D9B7B8 !important;
  color: #F7F1F3 !important;
}

.case-quote-author {
  color: #D9B7B8 !important;
}

.insight-lead-card {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4) !important;
}

.insight-lead-title {
  color: #F7F1F3 !important;
}

.insight-lead-summary {
  color: #C6B5C2 !important;
}

.insight-author-name {
  color: #F7F1F3 !important;
}

.insight-compact-card {
  background: #332633 !important;
  border: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.insight-compact-card:hover {
  background: #382A38 !important;
  border-color: #D9B7B8 !important;
}

.insight-compact-title {
  color: #F7F1F3 !important;
}

.insight-compact-summary {
  color: #C6B5C2 !important;
}

/* 11. Form Controls (Contact & Audit) */
.form-label {
  color: #F7F1F3 !important;
}

.form-control, .form-select, .form-textarea {
  background-color: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
  color: #F7F1F3 !important;
}

.form-control:focus, .form-select:focus, .form-textarea:focus {
  border-color: #D9B7B8 !important;
  box-shadow: 0 0 0 3px rgba(217, 183, 184, 0.25) !important;
  background-color: #211922 !important;
}

.closing-cta-card,
.enterprise-closing-cta {
  background: #291F29 !important;
  border: 1px solid rgba(217, 183, 184, 0.25) !important;
}

.closing-cta-title {
  color: #F7F1F3 !important;
}

.closing-cta-desc {
  color: #C6B5C2 !important;
}

/* 12. Site Footer */
.site-footer {
  background-color: #1c151d !important;
  color: #C6B5C2 !important;
  border-top: 1px solid rgba(217, 183, 184, 0.20) !important;
}

.footer-brand p {
  color: #C6B5C2 !important;
}

.footer-title {
  color: #F7F1F3 !important;
}

.footer-link {
  color: #D9B7B8 !important;
}

.footer-link:hover {
  color: #FFFFFF !important;
}

.footer-bottom {
  border-top: 1px solid rgba(217, 183, 184, 0.15) !important;
  color: #A17E91 !important;
}
`;

let compCss = fs.readFileSync('assets/css/components.css', 'utf8');

// Replace any residual white backgrounds in components.css
compCss = compCss.replace(/background:\s*#FAF9F5;/g, 'background: #211922;');
compCss = compCss.replace(/background:\s*#FFFFFF;/g, 'background: #332633;');
compCss = compCss.replace(/background:\s*#fffafa;/g, 'background: #291F29;');
compCss = compCss.replace(/background:\s*rgba\(255,\s*255,\s*255,\s*0\.98\);/g, 'background: rgba(33, 25, 34, 0.98);');
compCss = compCss.replace(/background:\s*linear-gradient\(145deg,\s*#FFFFFF\s*0%,\s*#F7F1F3\s*100%\);/g, 'background: #382A38;');
compCss = compCss.replace(/background:\s*linear-gradient\(135deg,\s*#FFFFFF\s*0%,\s*#F7F1F3\s*100%\);/g, 'background: #291F29;');

// Remove any prior duplicate overrides block if present
const marker = '/* ============================================================';
const overrideMarker = '/* STRICT FULL DARK THEME OVERRIDES (CRITICAL CORRECTION)';
const idx = compCss.indexOf(overrideMarker);
if (idx !== -1) {
  compCss = compCss.slice(0, idx - 64);
}

compCss = compCss + darkThemeOverrides;
fs.writeFileSync('assets/css/components.css', compCss, 'utf8');
console.log('Appended darkThemeOverrides to assets/css/components.css');

// ============================================================
// 4. UPDATE admin/dashboard.php INLINE STYLES
// ============================================================
let adminDash = fs.readFileSync('admin/dashboard.php', 'utf8');
adminDash = adminDash.replace(/body\s*\{[\s\S]*?\}/m, `body { font-family: var(--font-body); background-color: #211922; color: #F7F1F3; }`);
adminDash = adminDash.replace(/\.admin-nav\s*\{[\s\S]*?\}/m, `.admin-nav { background: #1c151d; color: #F7F1F3; padding: 1.25rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(217, 183, 184, 0.20); }`);
adminDash = adminDash.replace(/\.admin-stat-card\s*\{[\s\S]*?\}/m, `.admin-stat-card { background: #332633; border: 1px solid rgba(217, 183, 184, 0.20); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--shadow-sm); color: #F7F1F3; }`);
adminDash = adminDash.replace(/\.data-table\s*\{[\s\S]*?\}/m, `.data-table { width: 100%; border-collapse: collapse; font-size: 0.88rem; background: #332633; border-radius: var(--radius-lg); overflow: hidden; border: 1px solid rgba(217, 183, 184, 0.20); }`);
adminDash = adminDash.replace(/\.data-table th\s*\{[\s\S]*?\}/m, `.data-table th { background: #291F29; color: #D9B7B8; font-family: var(--font-mono); font-size: 0.75rem; text-transform: uppercase; padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid rgba(217, 183, 184, 0.20); }`);
adminDash = adminDash.replace(/\.data-table td\s*\{[\s\S]*?\}/m, `.data-table td { padding: 1rem 1.25rem; border-bottom: 1px solid rgba(217, 183, 184, 0.12); vertical-align: middle; color: #F7F1F3; }`);
adminDash = adminDash.replace(/\.data-table tr:hover\s*\{[\s\S]*?\}/m, `.data-table tr:hover { background-color: #382A38; }`);
fs.writeFileSync('admin/dashboard.php', adminDash, 'utf8');
console.log('Updated admin/dashboard.php');

// ============================================================
// 5. UPDATE INLINE TEXT/HEADER OVERRIDES IN PHP FILES
// ============================================================
const phpFiles = fs.readdirSync('.').filter(f => f.endsWith('.php'));
phpFiles.forEach(file => {
  let content = fs.readFileSync(file, 'utf8');
  let changed = false;

  // Replace inline heading/title colors that were pointing to dark color-primary
  if (content.includes('color: var(--color-primary);')) {
    content = content.replace(/color:\s*var\(--color-primary\);/g, 'color: var(--color-text);');
    changed = true;
  }
  if (content.includes('color: #332633;')) {
    content = content.replace(/color:\s*#332633;/g, 'color: var(--color-text);');
    changed = true;
  }
  if (content.includes('color: var(--color-obsidian);')) {
    content = content.replace(/color:\s*var\(--color-obsidian\);/g, 'color: var(--color-text);');
    changed = true;
  }

  if (changed) {
    fs.writeFileSync(file, content, 'utf8');
    console.log('Updated inline colors in ' + file);
  }
});

console.log('Full Dark Theme implementation script finished successfully!');

