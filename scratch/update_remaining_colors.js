const fs = require('fs');

// 1. Update responsive.css
let respCss = fs.readFileSync('assets/css/responsive.css', 'utf8');
respCss = respCss.replace(/214,\s*183,\s*121/g, '141, 122, 155');
fs.writeFileSync('assets/css/responsive.css', respCss, 'utf8');
console.log('Updated responsive.css');

// 2. Update secondary PHP files
const secondaryPhp = ['about.php', 'audit.php', 'case-study-detail.php', 'contact.php', 'insight-detail.php', 'services.php'];
secondaryPhp.forEach(file => {
  let content = fs.readFileSync(file, 'utf8');
  content = content.replace(/214,\s*183,\s*121/g, '141, 122, 155');
  content = content.replace(/214,183,121/g, '141, 122, 155');
  fs.writeFileSync(file, content, 'utf8');
  console.log('Updated ' + file);
});

// 3. Update index.php
let indexContent = fs.readFileSync('index.php', 'utf8');

// Replace hex codes
indexContent = indexContent.replace(/#1C7467/gi, '#51415D');
indexContent = indexContent.replace(/#123D35/gi, '#30243A');
indexContent = indexContent.replace(/#0D302A/gi, '#261D30');
indexContent = indexContent.replace(/#F5E3BD/gi, '#E8E1EC');
indexContent = indexContent.replace(/#D6B779/gi, '#D6C2E2');
indexContent = indexContent.replace(/#B9CBC5/gi, '#D6C2E2');

// Replace rgba
indexContent = indexContent.replace(/rgba\(\s*185\s*,\s*203\s*,\s*197/gi, 'rgba(214, 194, 226');
indexContent = indexContent.replace(/rgba\(\s*28\s*,\s*116\s*,\s*103/gi, 'rgba(81, 65, 93');
indexContent = indexContent.replace(/rgba\(\s*214\s*,\s*183\s*,\s*121/gi, 'rgba(141, 122, 155');
indexContent = indexContent.replace(/rgba\(\s*18\s*,\s*61\s*,\s*53/gi, 'rgba(48, 36, 58');

fs.writeFileSync('index.php', indexContent, 'utf8');
console.log('Updated index.php');

