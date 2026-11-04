const { spawn } = require('child_process');

const viewports = [
  { name: 'Tablet 1024', w: 1024, h: 768 },
  { name: 'Tablet 768', w: 768, h: 1024 },
  { name: 'Mobile 390', w: 390, h: 844 },
  { name: 'Mobile 360', w: 360, h: 800 }
];

async function checkViewport(vp) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9700 + Math.floor(Math.random() * 50);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1800));
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
    await new Promise(r => setTimeout(r, 400));

    const check = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const s4 = document.querySelector('.cases-editorial-grid')?.closest('section')?.querySelector('.eyebrow-badge');
          const s5 = document.querySelector('.insights-editorial-grid')?.closest('section')?.querySelector('.eyebrow-badge');
          const badges = [
            document.querySelector('#capabilities .eyebrow-badge'),
            document.querySelector('.transformation-section .eyebrow-badge'),
            document.querySelector('#methodologySection .eyebrow-badge'),
            s4,
            s5
          ];

          return {
            windowWidth: window.innerWidth,
            docScrollWidth: document.documentElement.scrollWidth,
            hasHorizontalOverflow: document.documentElement.scrollWidth > window.innerWidth,
            allPillsWithinBounds: badges.every(b => b ? b.getBoundingClientRect().width <= window.innerWidth - 30 : false)
          };
        })()
      `
    });

    console.log(`${vp.name}:`, check.result.result.value);
    ws.close();
  } catch (err) {
    console.error(`Error on ${vp.name}:`, err);
  } finally {
    chrome.kill();
  }
}

async function runAll() {
  for (const vp of viewports) {
    await checkViewport(vp);
  }
}

runAll();

