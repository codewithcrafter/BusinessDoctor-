const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_repair_before';

async function captureDetailedEvidence() {
  const port = 9971;
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

  await send('Emulation.setDeviceMetricsOverride', {
    width: 390,
    height: 844,
    deviceScaleFactor: 2,
    mobile: true
  });

  await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
  await new Promise(r => setTimeout(r, 1000));

  // 1. Hero top
  const shotHero = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '01_hero_initial_390.png'), Buffer.from(shotHero.result.data, 'base64'));

  // 2. Vital Ticker centered
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const el = document.getElementById('vitalTicker');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'center' });
      })()
    `
  });
  await new Promise(r => setTimeout(r, 400));
  const shotStats = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '02_vital_ticker_centered_390.png'), Buffer.from(shotStats.result.data, 'base64'));

  // 3. Matrix card showing badge
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const el = document.querySelector('.matrix-card');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'center' });
      })()
    `
  });
  await new Promise(r => setTimeout(r, 400));
  const shotMatrix = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '03_matrix_card_390.png'), Buffer.from(shotMatrix.result.data, 'base64'));

  // 4. Methodology / Process Phase Card
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const el = document.querySelector('.stage-card');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'center' });
      })()
    `
  });
  await new Promise(r => setTimeout(r, 400));
  const shotProcess = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '04_process_card_390.png'), Buffer.from(shotProcess.result.data, 'base64'));

  // 5. Benefits graph card
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const el = document.querySelector('.benefit-graph-card, .benefits-graph-column');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'center' });
      })()
    `
  });
  await new Promise(r => setTimeout(r, 400));
  const shotBenefitsGraph = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '05_benefits_graph_390.png'), Buffer.from(shotBenefitsGraph.result.data, 'base64'));

  console.log('All detailed screenshots captured!');
  chrome.kill();
}

captureDetailedEvidence().catch(console.error);

