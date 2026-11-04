const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_repair_after';
if (!fs.existsSync(outDir)) {
  fs.mkdirSync(outDir, { recursive: true });
}

async function run() {
  const port = 9977;
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

    async function navigateAndWait(url) {
      await send('Page.navigate', { url });
      // Poll document.readyState
      for (let i = 0; i < 40; i++) {
        await new Promise(r => setTimeout(r, 100));
        const res = await send('Runtime.evaluate', { expression: 'document.readyState' });
        if (res.result && res.result.value === 'complete') {
          break;
        }
      }
      await new Promise(r => setTimeout(r, 800));
    }

    async function captureElement(selector, filename, pad = 12) {
      const evalRes = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${selector}');
            if (!el) return null;
            el.scrollIntoView({ block: 'center', inline: 'center' });
            return true;
          })()
        `,
        returnByValue: true
      });

      if (!evalRes.result || !evalRes.result.value) {
        console.log(`Element ${selector} not found for ${filename}`);
        return;
      }

      await new Promise(r => setTimeout(r, 300));

      const rectRes = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${selector}');
            const rect = el.getBoundingClientRect();
            return { x: rect.left, y: rect.top, width: rect.width, height: rect.height };
          })()
        `,
        returnByValue: true
      });
      const r = rectRes.result.value;

      const clip = {
        x: Math.max(0, r.x - pad),
        y: Math.max(0, r.y - pad),
        width: r.width + pad * 2,
        height: r.height + pad * 2,
        scale: 1
      };

      const shot = await send('Page.captureScreenshot', { format: 'png', clip });
      if (shot.result && shot.result.data) {
        fs.writeFileSync(path.join(outDir, filename), Buffer.from(shot.result.data, 'base64'));
        console.log(`Saved ${filename}`);
      }
    }

    async function captureViewport(filename) {
      await new Promise(r => setTimeout(r, 200));
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      if (shot.result && shot.result.data) {
        fs.writeFileSync(path.join(outDir, filename), Buffer.from(shot.result.data, 'base64'));
        console.log(`Saved ${filename}`);
      }
    }

    const mobileWidths = [
      { w: 390, h: 844, name: '390' },
      { w: 360, h: 800, name: '360' },
      { w: 320, h: 720, name: '320' }
    ];

    for (const v of mobileWidths) {
      console.log(`\n=== Testing Mobile Viewport ${v.w}x${v.h} ===`);
      await send('Emulation.setDeviceMetricsOverride', {
        width: v.w,
        height: v.h,
        deviceScaleFactor: 2,
        mobile: true
      });

      await navigateAndWait('http://127.0.0.1:8000/index.php');

      // Scroll top
      await send('Runtime.evaluate', { expression: 'window.scrollTo(0, 0);' });
      await captureViewport(`header_and_hero_${v.name}.png`);

      // Scroll to HUD card in hero
      await captureElement('#heroHudCard', `hero_hud_card_${v.name}.png`, 10);

      // Vital Ticker
      await captureElement('#vitalTicker', `vital_ticker_${v.name}.png`, 12);

      // Matrix Grid
      await captureElement('.matrix-grid', `matrix_section_${v.name}.png`, 12);

      // Methodology Process Cards
      await captureElement('#methodologySection', `process_cards_${v.name}.png`, 12);

      // Benefits Accordion & Graph
      await captureElement('#benefitsSection', `benefits_section_${v.name}.png`, 12);

      // Capabilities Cards
      await captureElement('#capabilitiesSection', `capabilities_card_${v.name}.png`, 12);

      // Tools Section
      await captureElement('#toolsSection', `tools_section_${v.name}.png`, 12);
    }

    console.log('\n=== Testing Desktop Viewports (Regression Check) ===');
    for (const d of [{ w: 1440, h: 900, name: '1440' }, { w: 1920, h: 1080, name: '1920' }]) {
      await send('Emulation.setDeviceMetricsOverride', {
        width: d.w,
        height: d.h,
        deviceScaleFactor: 1,
        mobile: false
      });
      await navigateAndWait('http://127.0.0.1:8000/index.php');
      await captureViewport(`desktop_hero_${d.name}.png`);
      await captureElement('#vitalTicker', `desktop_vital_ticker_${d.name}.png`, 15);
      await captureElement('#methodologySection', `desktop_methodology_${d.name}.png`, 15);
    }

    ws.close();
    console.log('\nAll captures completed successfully.');
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

run();
