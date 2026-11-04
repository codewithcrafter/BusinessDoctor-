const fs = require('fs');
['about.php', 'audit.php', 'case-studies.php', 'contact.php', 'insights.php'].forEach(f => {
  const content = fs.readFileSync(f, 'utf8');
  const m = content.match(/<section[^>]*class=["'][^"']*hero[^"']*["'][^>]*>/i);
  console.log(f + ' -> ' + (m ? m[0] : 'no hero tag'));
});

