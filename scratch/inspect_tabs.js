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

async function inspect(vp) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    'http://127.0.0.1:8000/#capabilities'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1500));
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

    const evalRes = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const capNav = document.getElementById('capabilitiesNavBar');
          const prevBtn = document.getElementById('capNavPrev');
          const nextBtn = document.getElementById('capNavNext');
          const tabs = Array.from(document.querySelectorAll('.cap-tab-btn')).map(t => {
            const r = t.getBoundingClientRect();
            return {
              text: t.innerText.replace(/\\n/g, ' '),
              left: Math.round(r.left),
              right: Math.round(r.right),
              width: Math.round(r.width),
              clippedRight: Math.round(r.right) > (capNav ? Math.round(capNav.getBoundingClientRect().right) : 0)
            };
          });

          const navRect = capNav ? capNav.getBoundingClientRect() : null;

          return {
            navRect: navRect ? { left: Math.round(navRect.left), right: Math.round(navRect.right), width: Math.round(navRect.width) } : null,
            scrollLeft: capNav ? capNav.scrollLeft : 0,
            scrollWidth: capNav ? capNav.scrollWidth : 0,
            clientWidth: capNav ? capNav.clientWidth : 0,
            prevHidden: prevBtn ? prevBtn.classList.contains('is-hidden') : true,
            nextHidden: nextBtn ? nextBtn.classList.contains('is-hidden') : true,
            tabs: tabs
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`\n=== VIEWPORT ${vp.name} (${vp.w}x${vp.h}) ===`);
    console.log(JSON.stringify(evalRes.result.value, null, 2));

    ws.close();
  } catch (err) {
    console.error(`Error at ${vp.name}:`, err.message);
  } finally {
    chrome.kill('SIGKILL');
  }
}

async function run() {
  for (const vp of viewports) {
    await inspect(vp);
  }
}

run();
