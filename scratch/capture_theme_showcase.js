const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

async function captureView(url, width, height, scrollSelector, filename) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9260 + Math.floor(Math.random() * 30);
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
    await new Promise(r => setTimeout(r, 800));

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
      await new Promise(r => setTimeout(r, 1000));
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
  console.log('Capturing Theme Showcase with clean tabs...');
  // 1. Hero / Header at 1920px & 390px
  await captureView('http://127.0.0.1:8000/', 1920, 1080, null, 'theme_hero_1920.png');
  await captureView('http://127.0.0.1:8000/', 390, 844, null, 'theme_hero_390.png');

  // 2. Mission, Vision & Statistics Strip
  await captureView('http://127.0.0.1:8000/', 1920, 1080, '#mission-vision', 'theme_mission_vision_1920.png');
  await captureView('http://127.0.0.1:8000/', 390, 844, '#mission-vision', 'theme_mission_vision_390.png');

  // 3. 5-Stage Interactive Framework
  await captureView('http://127.0.0.1:8000/', 1920, 1080, '#approach', 'theme_framework_1920.png');

  // 4. Measurable Accountability
  await captureView('http://127.0.0.1:8000/', 1920, 1080, '#accountability', 'theme_accountability_1920.png');

  // 5. Footer
  await captureView('http://127.0.0.1:8000/', 1920, 900, 'footer.site-footer', 'theme_footer_1920.png');

  // 6. Services Page
  await captureView('http://127.0.0.1:8000/services.php', 1920, 1080, null, 'theme_services_1920.png');

  console.log('ALL SHOWCASE SCREENSHOTS CAPTURED CLEANLY!');
}

run().catch(console.error);
