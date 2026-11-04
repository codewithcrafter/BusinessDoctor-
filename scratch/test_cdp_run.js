const { spawn } = require('child_process');

async function testCDP() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9452;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (callbacks.has(data.id)) {
        callbacks.get(data.id)(data);
        callbacks.delete(data.id);
      }
    };

    await new Promise(r => ws.onopen = r);

    function send(method, params = {}) {
      return new Promise(resolve => {
        const id = idCounter++;
        callbacks.set(id, resolve);
        ws.send(JSON.stringify({ id, method, params }));
      });
    }

    await send('Page.enable');
    await send('Runtime.enable');
    await new Promise(r => setTimeout(r, 500));

    const evalResult = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const nav = document.querySelector('.site-header');
          const h1 = document.querySelector('.hero-headline-oversized');
          const eyebrow = document.querySelector('#heroEditorialLayer .hero-eyebrow-lead');
          const ed = document.querySelector('#heroEditorialLayer');
          const textZone = document.querySelector('.hero-text-zone');
          const stage = document.querySelector('.hero-sticky-stage');
          const viewport = document.querySelector('#heroAnimViewport');

          function r(el) {
            if (!el) return null;
            const rect = el.getBoundingClientRect();
            return { top: rect.top, bottom: rect.bottom, height: rect.height, left: rect.left, right: rect.right, width: rect.width };
          }

          return {
            nav: r(nav),
            stage: r(stage),
            viewport: r(viewport),
            textZone: r(textZone),
            ed: r(ed),
            eyebrow: r(eyebrow),
            h1: r(h1),
            edTransform: ed ? ed.style.transform : null,
            edComputedTransform: ed ? getComputedStyle(ed).transform : null
          };
        })()
      `
    });

    console.log('DOM Rects Detail:', JSON.stringify(evalResult.result.result.value, null, 2));
    ws.close();
  } catch (err) {
    console.error('Test error:', err);
  } finally {
    chrome.kill();
  }
}

testCDP();
