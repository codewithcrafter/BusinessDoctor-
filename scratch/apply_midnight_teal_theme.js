const fs = require('fs');
const path = require('path');

const cssPath = path.join('assets', 'css', 'components.css');
let css = fs.readFileSync(cssPath, 'utf8');

console.log('Original components.css length:', css.length);

// 1. Replace all legacy theme comments and hex codes in base rules
css = css.replace(/Deep Aubergine \(\#332633\), Plum \(\#574054\), Muted Rose \(\#A17E91\), Rose Gold \(\#D9B7B8\), Soft Blush \(\#F7F1F3\)/g,
                  'Midnight Navy (#061326), Deep Teal (#073B42), Electric Teal (#00C9C1), Aqua (#39E0D5), Ice White (#F4F8FC)');

css = css.replace(/rgba\(217,\s*183,\s*184,\s*([0-9.]+)\)/g, 'rgba(0, 201, 193, $1)');
css = css.replace(/rgba\(161,\s*126,\s*145,\s*([0-9.]+)\)/g, 'rgba(0, 201, 193, $1)');
css = css.replace(/rgba\(87,\s*64,\s*84,\s*([0-9.]+)\)/g, 'rgba(7, 59, 66, $1)');
css = css.replace(/rgba\(51,\s*38,\s*51,\s*([0-9.]+)\)/g, 'rgba(6, 19, 38, $1)');

css = css.replace(/#211922/gi, '#061326');
css = css.replace(/#1c151d/gi, '#071A2C');
css = css.replace(/#382A38/gi, '#0D223A');
css = css.replace(/#332633/gi, '#0D223A');
css = css.replace(/#291F29/gi, '#071A2C');
css = css.replace(/#574054/gi, '#073B42');
css = css.replace(/#D9B7B8/gi, '#00C9C1');
css = css.replace(/#A17E91/gi, '#8297AA');
css = css.replace(/#E9DFE5/gi, '#39E0D5');
css = css.replace(/#F7F1F3/gi, '#F4F8FC');
css = css.replace(/#C6B5C2/gi, '#AABBCB');

// Cut off previous overrides starting from STRICT FULL DARK THEME OVERRIDES
const splitIdx = css.indexOf('/* ============================================================');
let mainCss = css;
const overrideMarker = 'STRICT FULL DARK THEME OVERRIDES';
const overrideIdx = css.indexOf(overrideMarker);
if (overrideIdx !== -1) {
  // Find preceding comment start
  const lastSection = css.lastIndexOf('/* ============================================================', overrideIdx);
  if (lastSection !== -1) {
    mainCss = css.substring(0, lastSection).trimEnd();
  }
}

// Build comprehensive Midnight Navy & Electric Teal Overrides
const newOverrides = `

/* ============================================================
   MIDNIGHT NAVY & ELECTRIC TEAL ENTERPRISE DESIGN SYSTEM
   - Primary Canvas: #061326 (Midnight Navy)
   - Secondary Canvas: #0A1D35 (Deep Navy)
   - Panel & Accent Surface: #073B42 (Deep Teal)
   - Primary Accent & Indicators: #00C9C1 (Electric Teal)
   - Bright Highlights & Hover: #39E0D5 (Aqua Highlight)
   - Elevated Cards: #0D223A (Elevated Surface)
   - Navbar, HUD, Sidebars, Inputs: #071A2C (Dark Surface)
   - High-Contrast Text: #F4F8FC (Ice White)
   - Paragraphs & Descriptions: #AABBCB (Muted Blue-Grey)
   - Micro Metadata & Captions: #8297AA (Muted Text)
   - Borders: rgba(0, 201, 193, 0.20)
   ============================================================ */

/* 1. Global Structure & Universal Overrides */
body {
  background-color: #061326 !important;
  color: #F4F8FC !important;
}

.section {
  background-color: #061326 !important;
  color: #F4F8FC !important;
}

.section-dark {
  background-color: #061326 !important;
  color: #F4F8FC !important;
}

.section-title {
  color: #F4F8FC !important;
}

.section-eyebrow {
  color: #00C9C1 !important;
}

.section-desc {
  color: #AABBCB !important;
}

.eyebrow-badge {
  background: rgba(0, 201, 193, 0.12) !important;
  color: #00C9C1 !important;
  border: 1px solid rgba(0, 201, 193, 0.30) !important;
}

.pill-tag {
  background: rgba(0, 201, 193, 0.12) !important;
  color: #39E0D5 !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.card {
  background-color: #0D223A !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
  color: #F4F8FC !important;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5) !important;
}

/* 2. Enterprise Navbar */
.site-header {
  background-color: #071A2C !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.20) !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
}

.navbar {
  background-color: transparent !important;
}

.brand-logo {
  color: #F4F8FC !important;
}

.brand-symbol {
  background: linear-gradient(135deg, #073B42 0%, #00C9C1 100%) !important;
  border: 1px solid #39E0D5 !important;
  color: #F4F8FC !important;
}

.brand-text-accent {
  color: #00C9C1 !important;
}

.nav-link {
  color: #F4F8FC !important;
}

.nav-link:hover {
  color: #39E0D5 !important;
}

.nav-link.active {
  color: #00C9C1 !important;
}

.nav-link.active::after {
  background-color: #00C9C1 !important;
  box-shadow: 0 0 10px #00C9C1 !important;
}

.nav-cta-btn {
  background-color: #073B42 !important;
  color: #F4F8FC !important;
  border: 1px solid #00C9C1 !important;
}

.nav-cta-btn:hover {
  background-color: #00C9C1 !important;
  color: #061326 !important;
  border-color: #39E0D5 !important;
  box-shadow: 0 0 16px rgba(0, 201, 193, 0.4) !important;
}

.mega-menu {
  background: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8) !important;
}

.mobile-drawer {
  background: #071A2C !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.mobile-nav-link {
  color: #F4F8FC !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.12) !important;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
  color: #00C9C1 !important;
}

/* 3. Buttons & Interactive Controls */
.btn-primary {
  background: linear-gradient(135deg, #00C9C1 0%, #39E0D5 100%) !important;
  color: #061326 !important;
  font-weight: 700 !important;
  border: 1px solid #39E0D5 !important;
  box-shadow: 0 4px 16px rgba(0, 201, 193, 0.35) !important;
}

.btn-primary:hover {
  background: #39E0D5 !important;
  color: #061326 !important;
  border-color: #39E0D5 !important;
  transform: translateY(-2px);
  box-shadow: 0 8px 26px rgba(0, 201, 193, 0.5) !important;
}

.btn-secondary {
  background-color: #071A2C !important;
  color: #F4F8FC !important;
  border: 1px solid rgba(0, 201, 193, 0.35) !important;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4) !important;
}

.btn-secondary:hover {
  background-color: #0D223A !important;
  color: #39E0D5 !important;
  border-color: #00C9C1 !important;
  transform: translateY(-2px);
}

.btn-accent {
  background: linear-gradient(135deg, #073B42 0%, #00C9C1 100%) !important;
  color: #F4F8FC !important;
  border: 1px solid #00C9C1 !important;
}

.btn-accent:hover {
  background: #00C9C1 !important;
  color: #061326 !important;
  box-shadow: 0 0 20px rgba(0, 201, 193, 0.5) !important;
}

/* 4. Homepage Hero Section */
.hero-scroll-track {
  background: #061326 !important;
}

.hero-sticky-stage {
  background-color: #061326 !important;
  background-image: 
    linear-gradient(rgba(0, 201, 193, 0.035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(0, 201, 193, 0.035) 1px, transparent 1px),
    radial-gradient(circle at 50% 20%, rgba(10, 29, 53, 0.8) 0%, transparent 70%),
    radial-gradient(circle at 80% 80%, rgba(7, 59, 66, 0.5) 0%, transparent 60%) !important;
  background-size: 48px 48px, 48px 48px, 100% 100%, 100% 100% !important;
}

.hero-headline-oversized,
.revealed-headline {
  color: #F4F8FC !important;
}

.text-gradient-pine {
  background: linear-gradient(135deg, #F4F8FC 0%, #39E0D5 50%, #00C9C1 100%) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  background-clip: text !important;
}

.hero-lead-text,
.revealed-desc {
  color: #AABBCB !important;
}

.enterprise-hud-card {
  background: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.65), 0 0 30px rgba(0, 201, 193, 0.15) !important;
}

.hud-metric-card {
  background: #061326 !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.hud-metric-val {
  color: #F4F8FC !important;
}

.hud-metric-label {
  color: #00C9C1 !important;
}

.hud-capabilities-strip {
  background: #061326 !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.hud-pill {
  background: #0A1D35 !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
  color: #F4F8FC !important;
}

.hud-footnote {
  color: #8297AA !important;
}

/* 5. Mission & Vision Section */
.mission-vision-section {
  background-color: #061326 !important;
  border-top: 1px solid rgba(0, 201, 193, 0.20) !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.mv-panel-mission {
  background: #0A1D35 !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5) !important;
}

.mv-panel-vision {
  background: #073B42 !important;
  border: 1px solid rgba(57, 224, 213, 0.30) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5) !important;
}

.mv-heading-light,
.mv-heading-dark {
  color: #F4F8FC !important;
}

.mv-statement-light,
.mv-statement-dark {
  color: #AABBCB !important;
}

.mv-icon-emerald {
  background: rgba(0, 201, 193, 0.15) !important;
  color: #00C9C1 !important;
  border: 1px solid rgba(0, 201, 193, 0.35) !important;
}

.mv-icon-ivory {
  background: rgba(57, 224, 213, 0.15) !important;
  color: #39E0D5 !important;
  border: 1px solid rgba(57, 224, 213, 0.35) !important;
}

.mv-eyebrow {
  color: #00C9C1 !important;
}

.mv-eyebrow-dark {
  color: #39E0D5 !important;
}

.mv-pillar-tag {
  background: rgba(0, 201, 193, 0.12) !important;
  color: #F4F8FC !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.mv-pillar-dark {
  background: rgba(57, 224, 213, 0.12) !important;
  color: #F4F8FC !important;
  border: 1px solid rgba(57, 224, 213, 0.25) !important;
}

.vital-ticker {
  background: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5) !important;
}

.vital-number {
  color: #00C9C1 !important;
}

.vital-label {
  color: #AABBCB !important;
}

.vital-item:not(:last-child)::after {
  background: rgba(0, 201, 193, 0.20) !important;
}

/* 6. 5-Stage Framework Section */
.stage-carousel-section {
  background: #061326 !important;
  border-top: 1px solid rgba(0, 201, 193, 0.20) !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.stage-card,
.approach-card {
  background: #0D223A !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5) !important;
  color: #F4F8FC !important;
}

.stage-card:hover,
.approach-card:hover {
  border-color: #39E0D5 !important;
  box-shadow: 0 20px 42px rgba(0, 0, 0, 0.6) !important;
}

.stage-card.is-active {
  border-color: #00C9C1 !important;
  background: #073B42 !important;
  box-shadow: 0 20px 48px rgba(0, 0, 0, 0.6), 0 0 25px rgba(0, 201, 193, 0.25) !important;
}

.stage-card-title,
.approach-title {
  color: #F4F8FC !important;
}

.stage-card-desc,
.approach-desc {
  color: #AABBCB !important;
}

.stage-phase-tag {
  color: #00C9C1 !important;
}

.approach-num {
  color: #39E0D5 !important;
}

.stage-watermark {
  color: rgba(0, 201, 193, 0.08) !important;
}

.stage-pill {
  background: #071A2C !important;
  color: #AABBCB !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.stage-pill.active {
  background: #073B42 !important;
  color: #F4F8FC !important;
  border-color: #00C9C1 !important;
}

.stage-nav-btn {
  background: #071A2C !important;
  color: #F4F8FC !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.stage-nav-btn:hover:not(:disabled) {
  background: #073B42 !important;
  color: #39E0D5 !important;
  border-color: #00C9C1 !important;
}

.stage-counter-badge {
  background: #071A2C !important;
  color: #AABBCB !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.stage-counter-badge .active-num {
  color: #00C9C1 !important;
}

.stage-drag-hint {
  color: #AABBCB !important;
  background: rgba(0, 201, 193, 0.10) !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.approach-deliverables-header {
  color: #00C9C1 !important;
  border-top-color: rgba(0, 201, 193, 0.18) !important;
}

.approach-deliverable {
  color: #F4F8FC !important;
}

/* 7. Featured Capabilities / Services Section */
.capabilities-nav-bar {
  background: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.cap-tab-btn {
  background: #071A2C !important;
  color: #AABBCB !important;
  border: 1px solid rgba(0, 201, 193, 0.15) !important;
}

.cap-tab-btn:hover {
  background: #0D223A !important;
  color: #39E0D5 !important;
}

.cap-tab-btn.active {
  background: #073B42 !important;
  color: #F4F8FC !important;
  border-color: #00C9C1 !important;
}

.capability-editorial-card {
  background: #0D223A !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5) !important;
}

.cap-card-body {
  background: #0D223A !important;
}

.cap-card-title {
  color: #F4F8FC !important;
}

.cap-card-desc {
  color: #AABBCB !important;
}

.cap-deliverable-item {
  color: #F4F8FC !important;
}

.cap-deliverable-item svg {
  color: #00C9C1 !important;
}

.cap-card-sidebar {
  background: #071A2C !important;
  border-left: 1px solid rgba(0, 201, 193, 0.18) !important;
}

.cap-sidebar-kpi-label {
  color: #00C9C1 !important;
}

.cap-sidebar-kpi-value {
  color: #F4F8FC !important;
}

.cap-sidebar-chip {
  background: rgba(0, 201, 193, 0.12) !important;
  border: 1px solid rgba(0, 201, 193, 0.22) !important;
  color: #F4F8FC !important;
}

/* 8. Transformation Section (Vendor Matrix) */
.transformation-section {
  background: #061326 !important;
  border-top: 1px solid rgba(0, 201, 193, 0.20) !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.matrix-card.symptom {
  background: #071A2C !important;
  border: 1px solid rgba(239, 68, 68, 0.35) !important;
  color: #F4F8FC !important;
}

.matrix-card.symptom h3 {
  color: #FCA5A5 !important;
}

.matrix-card.cure {
  background: #073B42 !important;
  border: 1px solid rgba(0, 201, 193, 0.35) !important;
  color: #F4F8FC !important;
  box-shadow: 0 0 30px rgba(0, 201, 193, 0.15) !important;
}

.matrix-card.cure h3 {
  color: #F4F8FC !important;
}

.matrix-item {
  color: #AABBCB !important;
}

/* 9. Measurable Accountability Section */
.accountability-section {
  background: #061326 !important;
  border-top: 1px solid rgba(0, 201, 193, 0.20) !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.accountability-card {
  background: #073B42 !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5) !important;
}

.accountability-card:hover {
  border-color: #39E0D5 !important;
  box-shadow: 0 24px 48px rgba(0, 0, 0, 0.65), 0 0 25px rgba(0, 201, 193, 0.25) !important;
}

.accountability-card-visual {
  background: #071A2C !important;
  border-bottom: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.accountability-card-body {
  background: #0D223A !important;
}

.accountability-card-title {
  color: #F4F8FC !important;
}

.accountability-card-desc {
  color: #AABBCB !important;
}

.visual-number,
.visual-tag {
  color: #39E0D5 !important;
}

.accountability-micro-badge {
  background: rgba(0, 201, 193, 0.12) !important;
  color: #39E0D5 !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.accountability-arrow-btn {
  background: #071A2C !important;
  color: #00C9C1 !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.accountability-card:hover .accountability-arrow-btn {
  background: #00C9C1 !important;
  color: #061326 !important;
}

/* 10. Case Studies & Editorial Cards */
.case-editorial-card {
  background: #0D223A !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.case-editorial-card:hover {
  border-color: #39E0D5 !important;
  box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6) !important;
}

.case-metric-box {
  background: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.case-metric-number {
  color: #00C9C1 !important;
}

.case-metric-label {
  color: #AABBCB !important;
}

.case-title {
  color: #F4F8FC !important;
}

.case-summary {
  color: #AABBCB !important;
}

/* Insights Cards */
.insight-lead-card {
  background: #0D223A !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.insight-lead-card:hover {
  border-color: #39E0D5 !important;
}

.insight-lead-title {
  color: #F4F8FC !important;
}

.insight-lead-excerpt {
  color: #AABBCB !important;
}

.insight-author-name {
  color: #F4F8FC !important;
}

.insight-compact-card {
  background: #0D223A !important;
  border: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.insight-compact-card:hover {
  background: #073B42 !important;
  border-color: #39E0D5 !important;
}

.insight-compact-title {
  color: #F4F8FC !important;
}

.insight-compact-summary {
  color: #AABBCB !important;
}

/* 11. Form Controls (Contact & Audit Pages) */
.form-label {
  color: #F4F8FC !important;
}

.form-control, .form-select, .form-textarea {
  background-color: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
  color: #F4F8FC !important;
}

.form-control:focus, .form-select:focus, .form-textarea:focus {
  border-color: #00C9C1 !important;
  box-shadow: 0 0 0 3px rgba(0, 201, 193, 0.25) !important;
  background-color: #061326 !important;
}

.closing-cta-card,
.enterprise-closing-cta {
  background: #071A2C !important;
  border: 1px solid rgba(0, 201, 193, 0.25) !important;
}

.closing-cta-title {
  color: #F4F8FC !important;
}

.closing-cta-desc {
  color: #AABBCB !important;
}

/* 12. Site Footer */
.site-footer {
  background-color: #071A2C !important;
  color: #AABBCB !important;
  border-top: 1px solid rgba(0, 201, 193, 0.20) !important;
}

.footer-brand p {
  color: #AABBCB !important;
}

.footer-title {
  color: #F4F8FC !important;
}

.footer-link {
  color: #00C9C1 !important;
}

.footer-link:hover {
  color: #39E0D5 !important;
}

.footer-bottom {
  border-top: 1px solid rgba(0, 201, 193, 0.15) !important;
  color: #8297AA !important;
}
`;

const updatedCss = mainCss + newOverrides;
fs.writeFileSync(cssPath, updatedCss, 'utf8');
console.log('Updated components.css successfully! New length:', updatedCss.length);

