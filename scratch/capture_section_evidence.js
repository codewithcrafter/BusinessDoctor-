const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_repair_before';
if (!fs.existsSync(outDir)) {
  fs.mkdirSync(outDir, { recursive: true });
}

async function captureSectionScreenshots() {
  const port = 9970;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

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

  const targets = [
    { name: 'header_and_hero', selector: '#hero', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'vital_ticker', selector: '#vitalTicker', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'capabilities_card', selector: '#capabilities', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'matrix_section', selector: '.matrix-grid', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'benefits_accordion', selector: '#benefitsSection', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'process_cards', selector: '#approach', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'tools_section', selector: '#toolsSection', page: 'http://127.0.0.1:8000/index.php' },
    { name: 'about_stats', selector: '.vital-ticker', page: 'http://127.0.0.1:8000/about.php' },
    { name: 'services_cards', selector: '.capability-editorial-card', page: 'http://127.0.0.1:8000/services.php' }
  ];

  const viewports = [
    { w: 390, h: 844 },
    { w: 360, h: 800 },
    { w: 320, h: 720 }
  ];

  for (const vp of viewports) {
    console.log(`\nCapturing mobile viewports at ${vp.w}x${vp.h}...`);
    await send('Emulation.setDeviceMetricsOverride', {
      width: vp.w,
      height: vp.h,
      deviceScaleFactor: 2,
      mobile: true
    });

    for (const t of targets) {
      await send('Page.navigate', { url: t.page });
      await new Promise(r => setTimeout(r, 800));

      // Scroll element into view
      const found = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${t.selector}');
            if (el) {
              el.scrollIntoView({ behavior: 'instant', block: 'start' });
              return true;
            }
            return false;
          })()
        `,
        returnByValue: true
      });

      await new Promise(r => setTimeout(r, 400));
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const filename = `${t.name}_${vp.w}.png`;
      fs.writeFileSync(path.join(outDir, filename), Buffer.from(shot.result.data, 'base64'));
      console.log(`  Saved ${filename} (found: ${found.result.result.value})`);
    }
  }

  console.log('\nAll section screenshots captured in mobile_repair_before/');
  chrome.kill();
}

captureSectionScreenshots().catch(err => {
  console.error(err);
  process.exit(1);
});

