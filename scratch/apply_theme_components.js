const fs = require('fs');

let css = fs.readFileSync('assets/css/components.css', 'utf8');

// Header comment
css = css.replace(
  /\* Brand System: Forest Obsidian \(#123D35\), Pine Teal \(#1C7467\), Champagne Gold \(#D6B779\), Cream Canvas \(#F7F6F0\)/g,
  '* Brand System: Deep Plum (#30243A), Plum (#51415D), Muted Silver Plum (#8D7A9B), Lavender Silver (#D6C2E2), Soft Off-White (#F5F1F7)'
);

// Hero specific transforms
css = css.replace(
  /\.hero-scroll-track\s*\{[\s\S]*?background:\s*var\(--color-bg\);/g,
  '.hero-scroll-track {\n  position: relative;\n  height: 250vh;\n  background: #30243A;'
);

css = css.replace(
  /\.hero-sticky-stage\s*\{[\s\S]*?border-bottom:\s*1px solid var\(--color-slate-200\);/g,
  `.hero-sticky-stage {
  position: sticky;
  top: 0;
  width: 100%;
  height: 100vh;
  min-height: 600px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  background: radial-gradient(circle at 85% 15%, rgba(81, 65, 93, 0.5) 0%, transparent 60%),
              radial-gradient(circle at 10% 85%, rgba(141, 122, 155, 0.22) 0%, transparent 60%),
              #30243A;
  border-bottom: 1px solid rgba(141, 122, 155, 0.25);`
);

css = css.replace(
  /background:\s*radial-gradient\(circle,\s*rgba\(28,\s*116,\s*103,\s*0\.16\)\s*0%,\s*transparent\s*70%\);/g,
  'background: radial-gradient(circle, rgba(81, 65, 93, 0.5) 0%, transparent 70%);'
);

css = css.replace(
  /background:\s*radial-gradient\(circle,\s*rgba\(214,\s*183,\s*121,\s*0\.15\)\s*0%,\s*transparent\s*70%\);/g,
  'background: radial-gradient(circle, rgba(214, 194, 226, 0.22) 0%, transparent 70%);'
);

css = css.replace(
  /rgba\(18,\s*61,\s*53,\s*0\.035\)/g,
  'rgba(214, 194, 226, 0.04)'
);

// Hero headlines and text
css = css.replace(
  /\.hero-headline-oversized\s*\{[\s\S]*?margin-bottom:\s*1\.25rem;\s*\}/g,
  `.hero-headline-oversized {
  font-family: var(--font-display);
  font-size: clamp(2.3rem, 4vw, 3.6rem);
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: -0.035em;
  color: #FFFFFF;
  margin-bottom: 1.25rem;
}`
);

css = css.replace(
  /\.text-gradient-pine\s*\{[\s\S]*?display:\s*inline-block;\s*\}/g,
  `.text-gradient-pine {
  background: linear-gradient(135deg, #FFFFFF 0%, #D6C2E2 55%, #8D7A9B 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}`
);

css = css.replace(
  /\.hero-lead-text\s*\{[\s\S]*?max-width:\s*620px;\s*\}/g,
  `.hero-lead-text {
  font-size: clamp(1.05rem, 1.25vw, 1.2rem);
  line-height: 1.65;
  color: #D6C2E2;
  margin-bottom: 2rem;
  max-width: 620px;
}`
);

// Global replacements of old brand colors
// Deep Forest Obsidian -> Deep Plum
css = css.replace(/#123D35/gi, '#30243A');
// Pine Teal -> Plum
css = css.replace(/#1C7467/gi, '#51415D');
// Ultra Dark Greens -> Dark Surface Plum
css = css.replace(/#0D302A/gi, '#261D30');
css = css.replace(/#0D2D27/gi, '#261D30');
css = css.replace(/#0a241f/gi, '#261D30');
// Muted Green text -> Secondary text
css = css.replace(/#5F706C/gi, '#716B78');
// Warm Ivory -> Soft Off-White
css = css.replace(/#FAF8F2/gi, '#F5F1F7');
css = css.replace(/#F7F6F0/gi, '#F5F1F7');
css = css.replace(/#F5F1E6/gi, '#EFE9F2');

// RGBA emerald -> RGBA Deep Plum (18, 61, 53 -> 48, 36, 58)
css = css.replace(/18,\s*61,\s*53/g, '48, 36, 58');

// RGBA pine teal -> RGBA Plum (28, 116, 103 -> 81, 65, 93)
css = css.replace(/28,\s*116,\s*103/g, '81, 65, 93');

// RGBA champagne gold -> RGBA Muted Silver Plum / Lavender (214, 183, 121 -> 141, 122, 155)
css = css.replace(/214,\s*183,\s*121/g, '141, 122, 155');

// Hex Champagne Gold -> Lavender Silver #D6C2E2 or Muted Silver Plum #8D7A9B
css = css.replace(/#D6B779/gi, '#D6C2E2');

fs.writeFileSync('assets/css/components.css', css);
console.log('Successfully updated assets/css/components.css');

