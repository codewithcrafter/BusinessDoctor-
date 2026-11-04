const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_drawer_final_proof';

const desktopViewports = [
  { name: 'desktop_1024x768', w: 1024, h: 768 },
  { name: 'desktop_1366x768', w: 1366, h: 768 },
  { name: 'desktop_1440x900', w: 1440, h: 900 },
  { name: 'desktop_1920x1080', w: 1920, h: 1080 }
];

async function verifyDesktop() {
  const port = 9899;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/index.php'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const targetPage = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
    const ws = new WebSocket(targetPage.webSocketDebuggerUrl);

    let id = 1;
    function send(method, params = {}) {
      return new Promise(resolve => {
        const curId = id++;
        const onMsg = evt => {
          const d = JSON.parse(evt.data);
          if (d.id === curId) {
            ws.removeEventListener('message', onMsg);
            resolve(d.result);
          }
        };
        ws.addEventListener('message', onMsg);
        ws.send(JSON.stringify({ id: curId, method, params }));
      });
    }

    await new Promise(r => ws.onopen = r);
    await send('Network.enable');
    await send('Page.enable');
    await send('Runtime.enable');

    for (const dv of desktopViewports) {
      console.log(`Verifying desktop: ${dv.name}`);
      await send('Emulation.setDeviceMetricsOverride', {
        width: dv.w,
        height: dv.h,
        deviceScaleFactor: 1,
        mobile: false
      });

      await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
      for (let i = 0; i < 30; i++) {
        await new Promise(r => setTimeout(r, 100));
        const s = await send('Runtime.evaluate', { expression: 'document.readyState' });
        if (s && s.result && s.result.value === 'complete') break;
      }
      await new Promise(r => setTimeout(r, 500));

      const evalRes = await send('Runtime.evaluate', {
        expression: `(() => {
          const drawer = document.getElementById('mobileDrawer');
          const backdrop = document.getElementById('mobileDrawerBackdrop');
          const toggle = document.getElementById('menuToggleBtn');
          const navMenu = document.querySelector('.nav-menu');
          const header = document.querySelector('.site-header');

          const csD = window.getComputedStyle(drawer);
          const csB = window.getComputedStyle(backdrop);
          const csT = window.getComputedStyle(toggle);
          const csN = window.getComputedStyle(navMenu);

          return {
            drawerDisplay: csD.display,
            backdropDisplay: csB.display,
            toggleDisplay: csT.display,
            navMenuDisplay: csN.display
          };
        })()`,
        returnByValue: true
      });

      console.log(`${dv.name} Check:`, evalRes.result.value);

      const shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `${dv.name}.png`), Buffer.from(shot.data, 'base64'));
    }

    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

verifyDesktop();

