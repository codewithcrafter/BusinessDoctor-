const { spawn } = require('child_process');
const fs = require('fs');

async function testViewport(width, height, prefix, scrollPoints) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9225',
    `--window-size=${width},${height}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9225/json/list');
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
    await new Promise(r => setTimeout(r, 1000));

    for (const pt of scrollPoints) {
      await send('Runtime.evaluate', {
        expression: `
          window.scrollTo({ top: ${pt.y}, behavior: 'instant' });
          document.documentElement.scrollTop = ${pt.y};
          window.dispatchEvent(new Event('scroll'));
        `
      });
      await new Promise(r => setTimeout(r, 600));

      const filename = `${prefix}_${pt.name}.png`;
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      fs.writeFileSync('C:\\Users\\user\\Desktop\\businessdoctor\\scratch\\' + filename, buf);
      console.log(`Captured: ${filename} (${buf.length} bytes)`);
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function runAll() {
  // 1. Desktop 1920x1080
  console.log('Testing Desktop 1920x1080...');
  await testViewport(1920, 1080, 'hero_1920', [
    { name: 'beginning', y: 0 },
    { name: 'middle', y: 680 },
    { name: 'end', y: 1380 }
  ]);

  // 2. Desktop 1440x900
  console.log('Testing Desktop 1440x900...');
  await testViewport(1440, 900, 'hero_1440', [
    { name: 'beginning', y: 0 },
    { name: 'middle', y: 650 },
    { name: 'end', y: 1250 }
  ]);

  // 3. Desktop 1366x768
  console.log('Testing Desktop 1366x768...');
  await testViewport(1366, 768, 'hero_1366', [
    { name: 'beginning', y: 0 },
    { name: 'middle', y: 550 },
    { name: 'end', y: 1020 }
  ]);

  // 4. Tablet 768x1024
  console.log('Testing Tablet 768x1024...');
  await testViewport(768, 1024, 'hero_768', [
    { name: 'beginning', y: 0 },
    { name: 'middle', y: 480 },
    { name: 'end', y: 800 }
  ]);

  // 5. Mobile 390x844
  console.log('Testing Mobile 390x844...');
  await testViewport(390, 844, 'hero_390', [
    { name: 'beginning', y: 0 },
    { name: 'middle', y: 380 },
    { name: 'end', y: 700 }
  ]);

  // 6. Mobile 360x800
  console.log('Testing Mobile 360x800...');
  await testViewport(360, 800, 'hero_360', [
    { name: 'beginning', y: 0 },
    { name: 'middle', y: 350 },
    { name: 'end', y: 680 }
  ]);

  console.log('ALL VIEWPORTS AND SCROLL STAGES CAPTURED SUCCESSFULLY!');
}

runAll().catch(e => {
  console.error(e);
  process.exit(1);
});
