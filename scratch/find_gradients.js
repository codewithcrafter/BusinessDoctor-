const fs = require('fs');
fs.readdirSync('.').filter(f => f.endsWith('.php')).forEach(f => {
  const content = fs.readFileSync(f, 'utf8');
  const m = content.match(/text-gradient[^\s"'>]*/g);
  if (m) console.log(f, [...new Set(m)]);
});

