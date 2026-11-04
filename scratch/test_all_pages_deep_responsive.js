const { spawn } = require('child_process');

const pagesToTest = [
  { name: 'Home', path: '/' },
  { name: 'About', path: '/about.php' },
  { name: 'Services', path: '/services.php' },
  { name: 'Service Detail', path: '/service-detail.php?slug=web-software-development' },
  { name: 'Audit', path: '/audit.php' },
  { name: 'Case Studies', path: '/case-studies.php' },
  { name: 'Insights (Blog)', path: '/insights.php' },
  { name: 'Contact', path: '/contact.php' }
];

const viewports = [
  { name: '360', w: 360, h: 800 },
  { name: '390', w: 390, h: 844 },
  { name: '768', w: 768, h: 1024 },
  { name: '1024', w: 1024, h: 768 },
  { name: '1440', w: 1440, h: 900 }
];

async function runAudit() {
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1600));
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

    console.log('--- STARTING DEEP RESPONSIVE AUDIT ACROSS ALL 8 PAGES & VIEWPORTS ---');

    const allIssues = [];

    for (const p of pagesToTest) {
      console.log(`\nTesting page: ${p.name} (${p.path})`);
      for (const vp of viewports) {
        await send('Emulation.setDeviceMetricsOverride', {
          width: vp.w,
          height: vp.h,
          deviceScaleFactor: 1,
          mobile: vp.w <= 768
        });

        await send('Page.navigate', { url: `http://127.0.0.1:8000${p.path}` });
        await new Promise(r => setTimeout(r, 800));

        const evalRes = await send('Runtime.evaluate', {
          expression: `
            (() => {
              const innerW = window.innerWidth;
              const docW = document.documentElement.scrollWidth;
              const bodyW = document.body.scrollWidth;

              const issues = [];

              if (docW > innerW + 1) {
                issues.push({ type: 'doc-overflow', docW, innerW, diff: docW - innerW });
              }

              // Check individual elements extending beyond viewport
              document.querySelectorAll('*').forEach(el => {
                const style = window.getComputedStyle(el);
                if (style.display === 'none' || style.visibility === 'hidden') return;
                
                // Allow elements inside containers with overflow-x auto/hidden/scroll
                let contained = false;
                let p = el.parentElement;
                while (p && p !== document.body && p !== document.documentElement) {
                  const pStyle = window.getComputedStyle(p);
                  if (pStyle.overflowX === 'hidden' || pStyle.overflowX === 'auto' || pStyle.overflowX === 'scroll' ||
                      pStyle.overflow === 'hidden') {
                    contained = true;
                    break;
                  }
                  p = p.parentElement;
                }

                const r = el.getBoundingClientRect();
                if (!contained && r.right > innerW + 2) {
                  issues.push({
                    type: 'element-overflow',
                    tag: el.tagName,
                    id: el.id,
                    className: (el.className || '').toString().slice(0, 40),
                    right: Math.round(r.right),
                    width: Math.round(r.width),
                    text: (el.innerText || '').slice(0, 30).trim()
                  });
                }

                // Check text elements clipping or button minimum widths
                if (el.tagName === 'INPUT' || el.tagName === 'SELECT' || el.tagName === 'TEXTAREA') {
                  if (r.width > innerW) {
                    issues.push({
                      type: 'input-overflow',
                      tag: el.tagName,
                      name: el.name,
                      width: Math.round(r.width)
                    });
                  }
                }
              });

              return {
                innerW,
                docW,
                issuesCount: issues.length,
                issues: issues.slice(0, 10)
              };
            })()
          `,
          returnByValue: true
        });

        const resVal = evalRes.result.result.value;
        if (resVal.issuesCount > 0) {
          console.log(`  [${vp.name}px] FOUND ${resVal.issuesCount} ISSUES:`, resVal.issues);
          allIssues.push({ page: p.name, vp: vp.name, issues: resVal.issues });
        } else {
          console.log(`  [${vp.name}px] OK (docW: ${resVal.docW}, innerW: ${resVal.innerW})`);
        }
      }
    }

    console.log('\n=======================================');
    console.log(`TOTAL PAGES WITH ISSUES: ${allIssues.length}`);
    console.log(JSON.stringify(allIssues, null, 2));

  } catch (err) {
    console.error('Audit failed with error:', err);
  } finally {
    chrome.kill();
  }
}

runAudit();

