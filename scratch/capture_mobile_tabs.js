const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const artifactDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

async function captureTabsOnMobile(w, h) {
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
    await send('Page.enable');
    await send('Runtime.enable');
    await send('Emulation.setDeviceMetricsOverride', {
      width: w,
      height: h,
      deviceScaleFactor: 2,
      mobile: true
    });

    await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
    await new Promise(r => setTimeout(r, 800));

    // Scroll to #capabilities
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ behavior: 'instant', block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 400));

    const shot1 = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(artifactDir, `capabilities_tabs_${w}_initial.png`), Buffer.from(shot1.result.data, 'base64'));

    // Click next arrow
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const next = document.getElementById('capNavNext');
          if (next) next.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));

    const shot2 = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(artifactDir, `capabilities_tabs_${w}_scrolled.png`), Buffer.from(shot2.result.data, 'base64'));
    console.log(`Captured tabs at ${w}px successfully.`);
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

async function run() {
  await captureTabsOnMobile(390, 844);
  await captureTabsOnMobile(360, 800);
}

run();

