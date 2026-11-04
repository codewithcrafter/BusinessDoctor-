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

async function testVp(vp) {
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
    await new Promise(r => setTimeout(r, 200));

    // Check how many clicks to reach the end
    const clickResults = [];
    for (let click = 1; click <= 4; click++) {
      const nextBtnState = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const next = document.getElementById('capNavNext');
            return next ? !next.classList.contains('is-hidden') : false;
          })()
        `,
        returnByValue: true
      });

      if (!nextBtnState.result.result.value) {
        break;
      }

      await send('Runtime.evaluate', {
        expression: `document.getElementById('capNavNext').click();`
      });
      await new Promise(r => setTimeout(r, 600));

      const state = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const navBar = document.getElementById('capabilitiesNavBar');
            const navR = navBar.getBoundingClientRect();
            const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
            const tab6 = btns[5];
            const tab6R = tab6.getBoundingClientRect();
            return {
              scrollLeft: navBar.scrollLeft,
              maxScroll: navBar.scrollWidth - navBar.clientWidth,
              tab6Right: Math.round(tab6R.right),
              tab6Left: Math.round(tab6R.left),
              navBarRight: Math.round(navR.right),
              navBarLeft: Math.round(navR.left),
              tab6ClippedRight: Math.round(tab6R.right) > Math.round(navR.right) + 1,
              tab6FullyVisible: Math.round(tab6R.right) <= Math.round(navR.right) + 1 && Math.round(tab6R.left) >= Math.round(navR.left)
            };
          })()
        `,
        returnByValue: true
      });
      clickResults.push({ click, state: state.result.result.value });
    }

    console.log(`\n=== VP ${vp.name} (${vp.w}x${vp.h}) ===`);
    console.log(JSON.stringify(clickResults, null, 2));

    ws.close();
  } catch (err) {
    console.error(`VP ${vp.name} error:`, err);
  } finally {
    chrome.kill('SIGKILL');
  }
}

async function run() {
  for (const vp of viewports) {
    await testVp(vp);
  }
}
run();

