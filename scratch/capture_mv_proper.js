const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function captureMVProper() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9850;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/about.php'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
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
    await new Promise(r => setTimeout(r, 500));

    // Get exact document offset of #missionVision
    const mvLoc = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const mv = document.getElementById('missionVision');
          if (!mv) return null;
          const rect = mv.getBoundingClientRect();
          const pageY = window.scrollY + rect.top;
          window.scrollTo(0, pageY - 40);
          return {
            pageY: pageY,
            rect: rect,
            width: rect.width,
            height: rect.height
          };
        })()
      `
    });

    console.log('MV location:', mvLoc.result.result.value);
    await new Promise(r => setTimeout(r, 500));

    // Just capture the current viewport without clip, so we see what's on screen
    const shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'about_mission_vision.png'), Buffer.from(shot.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'about_mission_vision.png'), Buffer.from(shot.result.data, 'base64'));

    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

captureMVProper();

