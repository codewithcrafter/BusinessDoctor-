async function getUrls() {
  const pages = ['index.php', 'about.php', 'services.php', 'case-studies.php', 'insights.php', 'blog.php', 'contact.php', 'audit.php', 'diagnostic.php'];
  const allUrls = new Set(pages);
  for (const p of ['services.php', 'case-studies.php', 'insights.php', 'blog.php']) {
    try {
      const res = await fetch('http://127.0.0.1:8000/' + p);
      const html = await res.text();
      const regex = /href=["']([^"']+\.php[^"']*)["']/g;
      let match;
      while ((match = regex.exec(html)) !== null) {
        const u = match[1];
        if (!u.startsWith('http') && !u.startsWith('#') && !u.startsWith('mailto')) {
          allUrls.add(u);
        }
      }
    } catch (e) {
      console.error(e);
    }
  }
  console.log(JSON.stringify(Array.from(allUrls).sort(), null, 2));
}
getUrls();

