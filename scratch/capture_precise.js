const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');
const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_repair_after';

async function fix() {
  const port = 9980;
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
  await send('Emulation.setDeviceMetricsOverride', { width: 390, height: 844, deviceScaleFactor: 2, mobile: true });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
  await new Promise(r => setTimeout(r, 1200));

  // Scroll matrix card top with 80px offset
  await send('Runtime.evaluate', {
    expression: `(() => {
      const el = document.querySelector('.matrix-card');
      const top = el.getBoundingClientRect().top + window.pageYOffset - 90;
      window.scrollTo(0, top);
    })()`
  });
  await new Promise(r => setTimeout(r, 400));
  let shot = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '03_matrix_card_390.png'), Buffer.from(shot.result.data, 'base64'));

  // Scroll capabilities active pane
  await send('Runtime.evaluate', {
    expression: `(() => {
      const el = document.querySelector('.cap-tab-pane.active');
      const top = el.getBoundingClientRect().top + window.pageYOffset - 90;
      window.scrollTo(0, top);
    })()`
  });
  await new Promise(r => setTimeout(r, 400));
  shot = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '06_capabilities_card_390.png'), Buffer.from(shot.result.data, 'base64'));

  // Also capture the mobile drawer open
  await send('Runtime.evaluate', {
    expression: `(() => {
      window.scrollTo(0, 0);
      const btn = document.querySelector('.menu-toggle');
      if (btn) btn.click();
    })()`
  });
  await new Promise(r => setTimeout(r, 400));
  shot = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, '00_mobile_drawer_open_390.png'), Buffer.from(shot.result.data, 'base64'));

  ws.close();
  chrome.kill();
  console.log('Updated 03, 06, and 00!');
}
fix();

