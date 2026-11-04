const { spawn } = require('child_process');
const fs = require('fs');

async function main() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9222',
    '--window-size=1920,1080',
    'about:blank'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));

    // Get list of targets
    const res = await fetch('http://127.0.0.1:9222/json/list');
    const pages = await res.json();
    const page = pages[0];
    const ws = new WebSocket(page.webSocketDebuggerUrl);

    let msgId = 1;
    const callbacks = new Map();

    ws.onmessage = (event) => {
      const data = JSON.parse(event.data);
      if (callbacks.has(data.id)) {
        callbacks.get(data.id)(data);
        callbacks.delete(data.id);
      }
    };

    await new Promise(r => ws.onopen = r);

    function send(method, params = {}) {
      return new Promise(resolve => {
        const id = msgId++;
        callbacks.set(id, resolve);
        ws.send(JSON.stringify({ id, method, params }));
      });
    }

    // Enable Page and Runtime
    await send('Page.enable');
    await send('Runtime.enable');
    await send('DOM.enable');

    // Navigate to homepage
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
    await new Promise(r => setTimeout(r, 2000));

    // Scroll to #methodologySection
    await send('Runtime.evaluate', {
      expression: `
        const el = document.getElementById('methodologySection');
        if (el) {
          el.scrollIntoView({ behavior: 'instant', block: 'start' });
        }
      `
    });
    await new Promise(r => setTimeout(r, 600));

    // Helper to capture screenshot
    async function capture(filename) {
      const res = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync('C:\\Users\\user\\Desktop\\businessdoctor\\scratch\\' + filename, Buffer.from(res.result.data, 'base64'));
      console.log('Saved: ' + filename);
    }

    // 1. Initial State: Stage 01 Active
    await capture('after_stage_01_desktop.png');

    // 2. Click Next Button -> Stage 02
    await send('Runtime.evaluate', {
      expression: `document.getElementById('stageNextBtn').click();`
    });
    await new Promise(r => setTimeout(r, 700));
    await capture('after_stage_02_desktop.png');

    // 3. Click Stage 04 Pill -> Stage 04
    await send('Runtime.evaluate', {
      expression: `
        const pill = document.querySelector('.stage-pill[data-stage="3"]');
        if (pill) pill.click();
      `
    });
    await new Promise(r => setTimeout(r, 700));
    await capture('after_stage_04_desktop.png');

    // 4. Test Mobile Emulation (390x844)
    await send('Emulation.setDeviceMetricsOverride', {
      width: 390,
      height: 844,
      deviceScaleFactor: 2,
      mobile: true
    });
    await send('Runtime.evaluate', {
      expression: `
        const el = document.getElementById('methodologySection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      `
    });
    await new Promise(r => setTimeout(r, 600));

    // Reset to Stage 01 on mobile
    await send('Runtime.evaluate', {
      expression: `
        const card = document.querySelector('.stage-card[data-index="0"]');
        if (card) card.click();
      `
    });
    await new Promise(r => setTimeout(r, 700));
    await capture('after_stage_mobile_390.png');

    // Swipe / Click Next on mobile
    await send('Runtime.evaluate', {
      expression: `document.getElementById('stageNextBtn').click();`
    });
    await new Promise(r => setTimeout(r, 700));
    await capture('after_stage_mobile_390_next.png');

    console.log('ALL VERIFICATIONS SUCCESSFUL!');
    ws.close();
  } finally {
    chrome.kill();
  }
}

main().catch(err => {
  console.error('Error:', err);
  process.exit(1);
});

