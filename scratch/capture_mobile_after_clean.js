const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_repair_after';
if (!fs.existsSync(outDir)) {
  fs.mkdirSync(outDir, { recursive: true });
}

async function run() {
  const port = 9978;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1500));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pagesList = await res.json();
    const page = pagesList.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pagesList[0];
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

    async function scrollAndCapture(selector, filename) {
      await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${selector}');
            if (el) {
              el.scrollIntoView({ behavior: 'instant', block: 'center' });
            }
          })()
        `
      });
      await new Promise(r => setTimeout(r, 350));
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      if (shot.result && shot.result.data) {
        fs.writeFileSync(path.join(outDir, filename), Buffer.from(shot.result.data, 'base64'));
        console.log(`Saved ${filename}`);
      }
    }

    // Capture mobile widths: 390, 360, 320
    const viewports = [
      { w: 390, h: 844, name: '390' },
      { w: 360, h: 800, name: '360' },
      { w: 320, h: 720, name: '320' }
    ];

    for (const v of viewports) {
      console.log(`\nCapturing mobile ${v.w}x${v.h}...`);
      await send('Emulation.setDeviceMetricsOverride', {
        width: v.w,
        height: v.h,
        deviceScaleFactor: 2,
        mobile: true
      });

      await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
      await new Promise(r => setTimeout(r, 1200));

      // 1. Initial Hero Top
      await send('Runtime.evaluate', { expression: 'window.scrollTo(0, 0);' });
      await new Promise(r => setTimeout(r, 300));
      const shotHero = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `01_hero_initial_${v.name}.png`), Buffer.from(shotHero.result.data, 'base64'));
      console.log(`Saved 01_hero_initial_${v.name}.png`);

      // 1b. Hero HUD Card
      await scrollAndCapture('#heroHudCard', `01b_hero_hud_${v.name}.png`);

      // 2. Vital Ticker
      await scrollAndCapture('#vitalTicker', `02_vital_ticker_centered_${v.name}.png`);

      // 3. Matrix Card
      await scrollAndCapture('.matrix-card', `03_matrix_card_${v.name}.png`);

      // 4. Process Card
      await scrollAndCapture('.stage-card', `04_process_card_${v.name}.png`);

      // 5. Benefits Graph
      await scrollAndCapture('.benefits-viz-container', `05_benefits_graph_${v.name}.png`);

      // 6. Capabilities Card
      await scrollAndCapture('.cap-content-card', `06_capabilities_card_${v.name}.png`);

      // 7. Tools Section
      await scrollAndCapture('.tools-grid', `07_tools_${v.name}.png`);
    }

    // Verify Desktop Viewports (1440 and 1920) for regressions
    console.log('\nCapturing Desktop viewports...');
    for (const d of [{ w: 1440, h: 900, name: '1440' }, { w: 1920, h: 1080, name: '1920' }]) {
      await send('Emulation.setDeviceMetricsOverride', {
        width: d.w,
        height: d.h,
        deviceScaleFactor: 1,
        mobile: false
      });
      await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
      await new Promise(r => setTimeout(r, 1200));

      await send('Runtime.evaluate', { expression: 'window.scrollTo(0, 0);' });
      await new Promise(r => setTimeout(r, 300));
      const shotDeskTop = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `desktop_hero_${d.name}.png`), Buffer.from(shotDeskTop.result.data, 'base64'));
      console.log(`Saved desktop_hero_${d.name}.png`);

      await scrollAndCapture('#vitalTicker', `desktop_vital_ticker_${d.name}.png`);
      await scrollAndCapture('#methodologySection', `desktop_methodology_${d.name}.png`);
    }

    ws.close();
    console.log('\nDone capturing all evidence screenshots!');
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

run();

