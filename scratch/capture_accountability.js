const { spawn } = require('child_process');
const fs = require('fs');

async function captureSection(width, height, filename) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9230',
    `--window-size=${width},${height}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9230/json/list');
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page') || pages[0];

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
    await new Promise(r => setTimeout(r, 500));

    // Scroll directly to #accountability
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const el = document.getElementById('accountability');
          if (el) {
            el.scrollIntoView({ behavior: 'instant', block: 'start' });
          }
        })()
      `
    });

    await new Promise(r => setTimeout(r, 800));

    const shot = await send('Page.captureScreenshot', { format: 'png' });
    const buf = Buffer.from(shot.result.data, 'base64');
    fs.writeFileSync('C:\\Users\\user\\Desktop\\businessdoctor\\scratch\\' + filename, buf);
    console.log(`Captured: ${filename} (${buf.length} bytes) at ${width}x${height}`);

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function run() {
  await captureSection(1920, 1080, 'accountability_1920.png');
  await captureSection(1440, 900, 'accountability_1440.png');
  await captureSection(1366, 768, 'accountability_1366.png');
  await captureSection(768, 1024, 'accountability_768.png');
  await captureSection(390, 844, 'accountability_390.png');
  await captureSection(360, 800, 'accountability_360.png');
  console.log('ALL ACCOUNTABILITY SCREENSHOTS CAPTURED SUCCESSFULLY!');
}

run().catch(console.error);

