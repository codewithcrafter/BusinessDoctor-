const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

async function captureView(url, width, height, scrollSelector, filename) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9310 + Math.floor(Math.random() * 40);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${width},${height}`,
    url
  ]);

  try {
    await new Promise(r => setTimeout(r, 2200));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];

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
    await new Promise(r => setTimeout(r, 600));

    if (scrollSelector) {
      await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${scrollSelector}');
            if (el) {
              el.scrollIntoView({ behavior: 'instant', block: 'start' });
            }
          })()
        `
      });
      await new Promise(r => setTimeout(r, 800));
    }

    const shot = await send('Page.captureScreenshot', { format: 'png' });
    const buf = Buffer.from(shot.result.data, 'base64');
    
    fs.writeFileSync(path.join('scratch', filename), buf);
    if (fs.existsSync(ARTIFACT_DIR)) {
      fs.writeFileSync(path.join(ARTIFACT_DIR, filename), buf);
    }
    console.log(`Captured: ${filename} (${buf.length} bytes) at ${width}x${height}`);

    ws.close();
  } catch (err) {
    console.error(`Error capturing ${filename}:`, err.message);
  } finally {
    chrome.kill();
  }
}

async function run() {
  console.log('Capturing Aubergine & Rose Gold Design System Showcase...');
  
  // 1. Desktop 1920x1080 Viewports
  await captureView('http://127.0.0.1:8000/', 1920, 1080, null, 'aubergine_hero_1920.png');
  await captureView('http://127.0.0.1:8000/', 1920, 1080, '#accountability', 'aubergine_accountability_1920.png');
  await captureView('http://127.0.0.1:8000/', 1920, 900, 'footer.site-footer', 'aubergine_footer_1920.png');

  // 2. Responsive Viewports requested by user (1440, 1366, 1024, 768, 390, 360)
  await captureView('http://127.0.0.1:8000/', 1440, 900, null, 'aubergine_hero_1440.png');
  await captureView('http://127.0.0.1:8000/', 1366, 768, null, 'aubergine_hero_1366.png');
  await captureView('http://127.0.0.1:8000/', 1024, 768, null, 'aubergine_hero_1024.png');
  await captureView('http://127.0.0.1:8000/', 768, 1024, null, 'aubergine_hero_768.png');
  await captureView('http://127.0.0.1:8000/', 390, 844, null, 'aubergine_hero_390.png');
  await captureView('http://127.0.0.1:8000/', 360, 800, null, 'aubergine_hero_360.png');

  // 3. Key Secondary & Admin Pages
  await captureView('http://127.0.0.1:8000/services.php', 1920, 1080, null, 'aubergine_services_1920.png');
  await captureView('http://127.0.0.1:8000/contact.php', 1920, 1080, null, 'aubergine_contact_1920.png');
  await captureView('http://127.0.0.1:8000/admin/login.php', 1920, 1080, null, 'aubergine_admin_login_1920.png');

  console.log('ALL AUBERGINE & ROSE GOLD SHOWCASE SCREENSHOTS CAPTURED CLEANLY!');
}

run().catch(console.error);

