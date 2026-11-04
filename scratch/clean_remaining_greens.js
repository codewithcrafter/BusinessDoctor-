const fs = require('fs');

// 1. Update base.css
let base = fs.readFileSync('assets/css/base.css', 'utf8');
base = base.replace(/border: 1px solid rgba\(13, 148, 136, 0\.2\);/g, 'border: 1px solid rgba(141, 122, 155, 0.25);');
base = base.replace(/background: rgba\(13, 148, 136, 0\.15\);/g, 'background: rgba(141, 122, 155, 0.15);');
base = base.replace(/border-color: rgba\(45, 212, 191, 0\.3\);/g, 'border-color: rgba(214, 194, 226, 0.4);');
base = base.replace(/border-color: rgba\(13, 148, 136, 0\.3\);/g, 'border-color: rgba(141, 122, 155, 0.35);');
fs.writeFileSync('assets/css/base.css', base, 'utf8');
console.log('Updated base.css');

// 2. Update components.css
let comp = fs.readFileSync('assets/css/components.css', 'utf8');
comp = comp.replace(/rgba\(13,\s*48,\s*42,\s*0\.35\)/g, 'rgba(38, 29, 48, 0.4)');
comp = comp.replace(/rgba\(13,\s*48,\s*42,\s*0\.95\)/g, 'rgba(38, 29, 48, 0.95)');
comp = comp.replace(/rgba\(9,\s*34,\s*30,\s*0\.9\)/g, 'rgba(48, 36, 58, 0.95)');
comp = comp.replace(/rgba\(13,\s*48,\s*42,\s*0\.85\)/g, 'rgba(38, 29, 48, 0.85)');
comp = comp.replace(/color:\s*#B9CBC5;/g, 'color: var(--color-highlight);');
fs.writeFileSync('assets/css/components.css', comp, 'utf8');
console.log('Updated components.css');

