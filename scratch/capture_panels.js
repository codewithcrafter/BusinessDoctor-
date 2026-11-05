const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const SCREENSHOT_DIR = path.join(__dirname, 'schema_fullwidth_proof');

async function capturePanels() {
  const port = 9960;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    '--disable-gpu',
    '--disable-extensions',
    '--unsafely-treat-insecure-origin-as-secure=http://127.0.0.1:8000',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

  await new Promise(r => setTimeout(r, 1500));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pages = await res.json();
  const targetPage = pages.find(p => p.type === 'page') || pages[0];
  const ws = new WebSocket(targetPage.webSocketDebuggerUrl);

  let msgId = 1;
  function send(method, params = {}) {
    return new Promise((resolve, reject) => {
      const id = msgId++;
      const to = setTimeout(() => reject(new Error(`Timeout on ${method}`)), 15000);
      const onMsg = (evt) => {
        const data = JSON.parse(evt.data);
        if (data.id === id) {
          clearTimeout(to);
          ws.removeEventListener('message', onMsg);
          if (data.error) reject(data.error);
          else resolve(data.result);
        }
      };
      ws.addEventListener('message', onMsg);
      ws.send(JSON.stringify({ id, method, params }));
    });
  }

  await new Promise(r => ws.onopen = r);
  await send('Page.enable');
  await send('Runtime.enable');

  // Login
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/admin/login.php' });
  await new Promise(r => setTimeout(r, 500));
  await send('Runtime.evaluate', {
    expression: `(() => {
      document.querySelector('input[name="username"]').value = 'admin';
      document.querySelector('input[name="password"]').value = 'Admin@BusinessDoctor2026';
      document.querySelector('form').submit();
    })()`
  });
  await new Promise(r => setTimeout(r, 1000));

  // 1440px desktop
  await send('Emulation.setDeviceMetricsOverride', {
    width: 1440,
    height: 900,
    deviceScaleFactor: 1,
    mobile: false
  });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/admin/blog-create.php' });
  await new Promise(r => setTimeout(r, 1000));

  // Scroll to schema panel
  await send('Runtime.evaluate', {
    expression: `document.querySelector('.adm-schema-panel').scrollIntoView()`
  });
  await new Promise(r => setTimeout(r, 400));

  const shot1440 = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(SCREENSHOT_DIR, 'schema_panel_1440_in_view.png'), Buffer.from(shot1440.data, 'base64'));

  // Mobile 390px
  await send('Emulation.setDeviceMetricsOverride', {
    width: 390,
    height: 844,
    deviceScaleFactor: 1,
    mobile: true
  });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/admin/blog-create.php' });
  await new Promise(r => setTimeout(r, 1000));

  await send('Runtime.evaluate', {
    expression: `document.querySelector('.adm-schema-panel').scrollIntoView()`
  });
  await new Promise(r => setTimeout(r, 400));

  const shot390 = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(SCREENSHOT_DIR, 'schema_panel_390_in_view.png'), Buffer.from(shot390.data, 'base64'));

  ws.close();
  chrome.kill();
  console.log('Targeted screenshots captured!');
}

capturePanels().catch(console.error);
