const fs = require('fs');
const c = fs.readFileSync('index.php', 'utf8').split('\n');
c.forEach((l, i) => {
  if (l.includes('<section') || l.includes('class="section') || l.includes('<!-- ==')) {
    console.log((i+1) + ': ' + l.trim().slice(0, 85));
  }
});

