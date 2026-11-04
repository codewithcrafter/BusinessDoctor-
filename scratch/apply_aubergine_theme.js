const fs = require('fs');

// Helper to replace all theme tokens in a string
function replaceThemeTokens(content) {
  let res = content;

  // Replace Hex
  res = res.replace(/#30243A/gi, '#332633');
  res = res.replace(/#51415D/gi, '#574054');
  res = res.replace(/#8D7A9B/gi, '#A17E91');
  res = res.replace(/#D6C2E2/gi, '#D9B7B8');
  res = res.replace(/#F5F1F7/gi, '#F7F1F3');
  res = res.replace(/#29242F/gi, '#302A30');
  res = res.replace(/#716B78/gi, '#746A73');
  res = res.replace(/#E8E1EC/gi, '#E9DFE5');
  res = res.replace(/#261D30/gi, '#291F29');

  // Replace RGBAs
  res = res.replace(/48,\s*36,\s*58/g, '51, 38, 51');
  res = res.replace(/81,\s*65,\s*93/g, '87, 64, 84');
  res = res.replace(/141,\s*122,\s*155/g, '161, 126, 145');
  res = res.replace(/214,\s*194,\s*226/g, '217, 183, 184');
  res = res.replace(/38,\s*29,\s*48/g, '41, 31, 41');

  return res;
}

// 1. Update base.css
let base = fs.readFileSync('assets/css/base.css', 'utf8');
base = replaceThemeTokens(base);
fs.writeFileSync('assets/css/base.css', base, 'utf8');
console.log('Updated base.css');

// 2. Update responsive.css
let resp = fs.readFileSync('assets/css/responsive.css', 'utf8');
resp = replaceThemeTokens(resp);
fs.writeFileSync('assets/css/responsive.css', resp, 'utf8');
console.log('Updated responsive.css');

// 3. Update components.css
let comp = fs.readFileSync('assets/css/components.css', 'utf8');
comp = replaceThemeTokens(comp);

// Update comments & explicit overrides in components.css
comp = comp.replace(/Deep Plum/g, 'Deep Aubergine');
comp = comp.replace(/Lavender Silver/g, 'Rose Gold');
comp = comp.replace(/Muted Silver Plum/g, 'Muted Rose');
comp = comp.replace(/Soft Off-White/g, 'Soft Blush');

// Ensure site-footer uses #332633 Deep Aubergine and soft blush supporting text
comp = comp.replace(/\.site-footer\s*\{[\s\S]*?padding-top/m, (m) => {
  return `.site-footer {\n  background-color: #332633;\n  color: var(--color-background);\n  padding-top`;
});

// Ensure footer links default to Rose Gold with hover
comp = comp.replace(/\.footer-link\s*\{[\s\S]*?transition:/m, (m) => {
  return `.footer-link {\n  color: var(--color-highlight);\n  font-size: 0.9rem;\n  text-decoration: none;\n  transition:`;
});

comp = comp.replace(/\.footer-link:hover\s*\{[\s\S]*?\}/m, (m) => {
  return `.footer-link:hover {\n  color: var(--color-white);\n  transform: translateX(3px);\n}`;
});

fs.writeFileSync('assets/css/components.css', comp, 'utf8');
console.log('Updated components.css');

// 4. Update index.php
let index = fs.readFileSync('index.php', 'utf8');
index = replaceThemeTokens(index);
fs.writeFileSync('index.php', index, 'utf8');
console.log('Updated index.php');

// 5. Update secondary PHP files
const phpFiles = ['about.php', 'audit.php', 'case-study-detail.php', 'contact.php', 'insight-detail.php', 'services.php', 'admin/login.php'];
phpFiles.forEach(file => {
  if (fs.existsSync(file)) {
    let content = fs.readFileSync(file, 'utf8');
    content = replaceThemeTokens(content);
    if (file === 'admin/login.php') {
      content = content.replace(/background:\s*#111d33;/g, 'background: var(--color-dark-surface);');
    }
    fs.writeFileSync(file, content, 'utf8');
    console.log('Updated ' + file);
  }
});

console.log('Aubergine & Rose Gold Theme applied successfully!');

