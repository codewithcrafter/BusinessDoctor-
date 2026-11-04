const { spawn } = require('child_process');

async function testPage(url, vp = { w: 1440, h: 900 }) {
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    url
  ]);

  try {
    await new Promise(r => setTimeout(r, 1600));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
    const ws = new WebSocket(page.webSocketDebuggerUrl);

    function send(method, params = {}) {
      return new Promise(resolve => {
        const id = Math.floor(Math.random() * 100000);
        const handler = (evt) => {
          const data = JSON.parse(evt.data);
          if (data.id === id) {
            ws.removeEventListener('message', handler);
            resolve(data);
          }
        };
        ws.addEventListener('message', handler);
        ws.send(JSON.stringify({ id, method, params }));
      });
    }

    await new Promise(r => ws.onopen = r);
    await send('Network.enable');
    await send('Network.setCacheDisabled', { cacheDisabled: true });
    await send('Page.enable');
    await send('Runtime.enable');
    await new Promise(r => setTimeout(r, 400));

    const evalRes = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const desktopBlog = document.querySelector('.nav-menu a[href="insights.php"]');
          const mobileBlog = document.querySelector('.mobile-drawer a[href="insights.php"]');
          const allDesktopLinks = Array.from(document.querySelectorAll('.nav-menu .nav-link')).map(a => ({
            text: a.innerText.trim(),
            href: a.getAttribute('href'),
            isActive: a.classList.contains('active')
          }));

          return {
            title: document.title,
            desktopBlog: desktopBlog ? {
              text: desktopBlog.innerText.trim(),
              href: desktopBlog.getAttribute('href'),
              isActive: desktopBlog.classList.contains('active')
            } : null,
            mobileBlog: mobileBlog ? {
              text: mobileBlog.innerText.trim(),
              href: mobileBlog.getAttribute('href'),
              isActive: mobileBlog.classList.contains('active')
            } : null,
            allDesktopLinks
          };
        })()
      `,
      returnByValue: true
    });

    return evalRes.result.result.value;
  } finally {
    chrome.kill();
  }
}

async function run() {
  console.log('--- 1. Testing Homepage (index.php) ---');
  const home = await testPage('http://127.0.0.1:8000/index.php');
  console.log('Homepage Links:', home.allDesktopLinks);
  console.log('Desktop Blog on Home active?:', home.desktopBlog.isActive);

  console.log('\n--- 2. Testing Blog Listing (insights.php) ---');
  const insights = await testPage('http://127.0.0.1:8000/insights.php');
  console.log('Desktop Blog on insights.php active?:', insights.desktopBlog.isActive);
  console.log('Mobile Blog on insights.php active?:', insights.mobileBlog.isActive);

  console.log('\n--- 3. Testing Blog Detail (insight-detail.php?slug=performance-driven-enterprise-replatforming) ---');
  const detail = await testPage('http://127.0.0.1:8000/insight-detail.php?slug=performance-driven-enterprise-replatforming');
  console.log('Desktop Blog on insight-detail active?:', detail.desktopBlog.isActive);
  console.log('Mobile Blog on insight-detail active?:', detail.mobileBlog.isActive);

  console.log('\n--- 4. Testing Alias blog.php ---');
  const blogAlias = await testPage('http://127.0.0.1:8000/blog.php');
  console.log('Desktop Blog on blog.php active?:', blogAlias.desktopBlog.isActive);

  console.log('\n--- 5. Testing Mobile Viewport (390px) ---');
  const mobileHome = await testPage('http://127.0.0.1:8000/insights.php', { w: 390, h: 844 });
  console.log('Mobile Blog Text:', mobileHome.mobileBlog.text);
  console.log('Mobile Blog active?:', mobileHome.mobileBlog.isActive);
}

run();

