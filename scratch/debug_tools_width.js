const { spawn } = require('child_process');

async function testViewport(w, h) {
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    `--window-size=${w},${h}`,
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
    await new Promise(r => setTimeout(r, 400));

    const check = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const innerW = window.innerWidth;
          const docW = document.documentElement.scrollWidth;
          const tools = document.getElementById('toolsSection');
          const tRect = tools ? tools.getBoundingClientRect() : null;
          
          const wideElements = [];
          document.querySelectorAll('*').forEach(el => {
            const r = el.getBoundingClientRect();
            if (r.width > innerW) {
              wideElements.push({
                tag: el.tagName,
                id: el.id,
                className: el.className,
                rectWidth: Math.round(r.width),
                scrollWidth: el.scrollWidth,
                text: el.innerText ? el.innerText.slice(0, 30).trim() : ''
              });
            }
          });

          return {
            windowInnerWidth: innerW,
            docScrollWidth: docW,
            toolsRect: tRect ? { width: tRect.width, left: tRect.left, right: tRect.right } : null,
            wideElements: wideElements.slice(0, 20)
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`Viewport ${w}x${h}:`, JSON.stringify(check.result.result.value, null, 2));
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

async function run() {
  await testViewport(390, 844);
  await testViewport(360, 800);
}

run();

