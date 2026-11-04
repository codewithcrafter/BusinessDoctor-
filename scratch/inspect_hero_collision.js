const { spawn } = require('child_process');

async function test() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9570;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2200));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page');

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

    const scrollSteps = [0, 40, 84, 120, 200, 300, 450, 600, 800, 1000, 1200, 1500];
    console.log('--- SCROLL MEASUREMENTS (1920x1080) ---');

    for (const sy of scrollSteps) {
      const data = await send('Runtime.evaluate', {
        expression: `
          JSON.stringify((() => {
            window.scrollTo(0, ${sy});
            window.dispatchEvent(new Event('scroll'));
            const header = document.querySelector('.site-header');
            const hRect = header ? header.getBoundingClientRect() : {};
            const stage = document.querySelector('.hero-sticky-stage');
            const sRect = stage ? stage.getBoundingClientRect() : {};
            const edit = document.querySelector('#heroEditorialLayer');
            const eRect = edit ? edit.getBoundingClientRect() : {};
            const h1 = document.querySelector('.hero-headline-oversized');
            const h1Rect = h1 ? h1.getBoundingClientRect() : {};
            const rev = document.querySelector('#heroRevealedLayer');
            const rRect = rev ? rev.getBoundingClientRect() : {};
            const hud = document.querySelector('#heroHudCard');
            const hudRect = hud ? hud.getBoundingClientRect() : {};

            return {
              scrollY: window.scrollY,
              headerBottom: Math.round(hRect.bottom || 0),
              stageTop: Math.round(sRect.top || 0),
              h1Top: Math.round(h1Rect.top || 0),
              h1Bottom: Math.round(h1Rect.bottom || 0),
              editTop: Math.round(eRect.top || 0),
              editBottom: Math.round(eRect.bottom || 0),
              editOpacity: edit ? parseFloat(window.getComputedStyle(edit).opacity) : null,
              revTop: Math.round(rRect.top || 0),
              revOpacity: rev ? parseFloat(window.getComputedStyle(rev).opacity) : null,
              hudTop: Math.round(hudRect.top || 0),
              hudLeft: Math.round(hudRect.left || 0),
              isClippedByHeader: (h1Rect.top || 0) < (hRect.bottom || 0)
            };
          })())
        `
      });
      const parsed = JSON.parse(data.result?.result?.value || '{}');
      console.log(`ScrollY ${sy}:`, parsed);
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

test().catch(console.error);
