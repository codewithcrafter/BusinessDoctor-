const { spawn } = require('child_process');

const viewports = [
  { name: '1920', w: 1920, h: 1080 },
  { name: '1440', w: 1440, h: 900 },
  { name: '1366', w: 1366, h: 768 },
  { name: '1024', w: 1024, h: 768 },
  { name: '768', w: 768, h: 1024 },
  { name: '390', w: 390, h: 844 },
  { name: '360', w: 360, h: 800 }
];

const pagesToTest = [
  '/',
  '/about.php',
  '/services.php',
  '/service-detail.php?slug=web-software-development',
  '/audit.php',
  '/case-studies.php',
  '/insights.php',
  '/contact.php'
];

async function testPageViewport(urlPath, vp) {
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    `http://127.0.0.1:8000${urlPath}`
  ]);

  try {
    await new Promise(r => setTimeout(r, 1400));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
    const ws = new WebSocket(page.webSocketDebuggerUrl);

    function send(method, params = {}) {
      return new Promise(resolve => {
        const id = Math.floor(Math.random() * 1000000);
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
    await new Promise(r => setTimeout(r, 300));

    const check = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const docEl = document.documentElement;
          const body = document.body;
          const scrollW = docEl.scrollWidth;
          const clientW = docEl.clientWidth;
          const innerW = window.innerWidth;
          const hasHorizontalOverflow = scrollW > innerW + 1;

          // Find specific elements causing horizontal overflow if any
          const overflowingElements = [];
          if (hasHorizontalOverflow) {
            const all = document.querySelectorAll('*');
            for (const el of all) {
              const r = el.getBoundingClientRect();
              if (r.right > innerW + 2) {
                // Ignore fixed or background pseudo containers if not visible
                const style = window.getComputedStyle(el);
                if (style.display !== 'none' && style.visibility !== 'hidden' && style.opacity !== '0') {
                  overflowingElements.push({
                    tag: el.tagName.toLowerCase(),
                    className: (el.className || '').toString().slice(0, 50),
                    id: el.id,
                    right: Math.round(r.right),
                    overflowBy: Math.round(r.right - innerW)
                  });
                }
              }
            }
          }

          return {
            scrollW,
            clientW,
            innerW,
            hasHorizontalOverflow,
            overflowAmount: Math.max(0, scrollW - innerW),
            overflowingElements: overflowingElements.slice(0, 5)
          };
        })()
      `,
      returnByValue: true
    });

    return check.result.result.value;
  } catch (err) {
    return { error: err.message };
  } finally {
    chrome.kill();
  }
}

async function run() {
  console.log('STARTING COMPREHENSIVE RESPONSIVE AUDIT ACROSS ALL PAGES AND VIEWPORTS...\n');
  const issues = [];

  for (const pagePath of pagesToTest) {
    console.log(`Checking ${pagePath}...`);
    for (const vp of viewports) {
      const res = await testPageViewport(pagePath, vp);
      if (res.error) {
        console.log(`  [ERROR] ${vp.name} (${vp.w}px): ${res.error}`);
        issues.push({ page: pagePath, vp: vp.name, error: res.error });
      } else if (res.hasHorizontalOverflow) {
        console.log(`  [OVERFLOW] ${vp.name} (${vp.w}px): scrollWidth=${res.scrollW} > innerW=${res.innerW} (Overflow: +${res.overflowAmount}px)`);
        console.log(`    Elements:`, JSON.stringify(res.overflowingElements));
        issues.push({ page: pagePath, vp: vp.name, width: vp.w, overflow: res.overflowAmount, elements: res.overflowingElements });
      } else {
        // clean
      }
    }
  }

  console.log('\n=======================================');
  console.log(`AUDIT COMPLETE. Total issues found: ${issues.length}`);
  console.log('=======================================');
  console.log(JSON.stringify(issues, null, 2));
}

run();

