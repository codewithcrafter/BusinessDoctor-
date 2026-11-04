const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

const viewports = [
  { name: '1920', w: 1920, h: 1080 },
  { name: '1440', w: 1440, h: 900 },
  { name: '1366', w: 1366, h: 768 },
  { name: '1024', w: 1024, h: 768 },
  { name: '768', w: 768, h: 1024 },
  { name: '390', w: 390, h: 844 },
  { name: '360', w: 360, h: 800 }
];

async function captureTabs(vp) {
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
    await new Promise(r => setTimeout(r, 400));

    // Scroll to #capabilities
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));

    const stateRes = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const navR = navBar.getBoundingClientRect();
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn')).map((b, i) => {
            const r = b.getBoundingClientRect();
            return {
              i: i + 1,
              text: b.innerText.replace(/\\s+/g, ' ').trim(),
              left: Math.round(r.left),
              right: Math.round(r.right),
              width: Math.round(r.width),
              clippedRight: Math.round(r.right) > Math.round(navR.right),
              clippedLeft: Math.round(r.left) < Math.round(navR.left),
              partiallyVisible: Math.round(r.left) < Math.round(navR.right) && Math.round(r.right) > Math.round(navR.right)
            };
          });

          return {
            navBar: {
              left: Math.round(navR.left),
              right: Math.round(navR.right),
              width: Math.round(navR.width),
              scrollWidth: navBar.scrollWidth,
              scrollLeft: navBar.scrollLeft,
              clientWidth: navBar.clientWidth
            },
            prevVisible: !prev.classList.contains('is-hidden'),
            nextVisible: !next.classList.contains('is-hidden'),
            tabs: btns
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`\n=== VP ${vp.name} (${vp.w}x${vp.h}) ===`);
    console.log(JSON.stringify(stateRes.result.result.value, null, 2));

    const shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, `tabs_initial_${vp.name}.png`), Buffer.from(shot.result.data, 'base64'));

    ws.close();
  } catch (err) {
    console.error(`VP ${vp.name} error:`, err);
  } finally {
    chrome.kill('SIGKILL');
  }
}

async function run() {
  for (const vp of viewports) {
    await captureTabs(vp);
  }
}
run();

