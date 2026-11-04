const { spawn } = require('child_process');

async function testViewportCDP(w, h) {
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
    await send('Emulation.setDeviceMetricsOverride', {
      width: w,
      height: h,
      deviceScaleFactor: 1,
      mobile: w <= 768
    });
    await send('Page.reload', { ignoreCache: true });
    await new Promise(r => setTimeout(r, 1000));

    const check = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const innerW = window.innerWidth;
          const docW = document.documentElement.scrollWidth;
          const bodyW = document.body.scrollWidth;
          
          const overflowingElements = [];
          document.querySelectorAll('*').forEach(el => {
            const r = el.getBoundingClientRect();
            // Check if el overflows right viewport
            // Ignore hidden elements, stage-track (which scrolls horizontally in carousel), and ambient glows with overflow:hidden parents
            const style = window.getComputedStyle(el);
            if (style.display === 'none' || style.visibility === 'hidden') return;
            
            // If parent or ancestor has overflow: hidden or overflow-x: auto/scroll, it's contained
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

            if (!contained && r.right > innerW + 1) {
              overflowingElements.push({
                tag: el.tagName,
                id: el.id,
                className: el.className,
                rectLeft: Math.round(r.left),
                rectRight: Math.round(r.right),
                rectWidth: Math.round(r.width),
                text: (el.innerText || '').slice(0, 30).trim()
              });
            }
          });

          return {
            windowInnerWidth: innerW,
            docScrollWidth: docW,
            bodyScrollWidth: bodyW,
            isOverflowing: docW > innerW,
            overflowingElements: overflowingElements.slice(0, 15)
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`[Viewport ${w}x${h}]`, JSON.stringify(check.result.result.value, null, 2));
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

async function run() {
  console.log('Testing true mobile viewports with Emulation.setDeviceMetricsOverride...');
  await testViewportCDP(360, 800);
  await testViewportCDP(390, 844);
  await testViewportCDP(768, 1024);
  await testViewportCDP(1024, 768);
  await testViewportCDP(1366, 768);
  await testViewportCDP(1440, 900);
  await testViewportCDP(1920, 1080);
}

run();

