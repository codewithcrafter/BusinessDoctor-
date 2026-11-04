const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

const viewports = [
  { name: '1920', w: 1920, h: 1080 },
  { name: '1440', w: 1440, h: 900 },
  { name: '1366', w: 1366, h: 768 },
  { name: '1024', w: 1024, h: 768 },
  { name: '768', w: 768, h: 1024 },
  { name: '390', w: 390, h: 844 },
  { name: '360', w: 360, h: 800 }
];

async function checkAboutViewport(vp) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9800 + Math.floor(Math.random() * 50);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    'http://127.0.0.1:8000/about.php'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1800));
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
    await new Promise(r => setTimeout(r, 400));

    // Scroll to Mission & Vision
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const mv = document.getElementById('missionVision');
          if (mv) mv.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));

    const check = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const mv = document.getElementById('missionVision');
          const grid = document.querySelector('.mission-vision-grid');
          const pMission = document.querySelector('.mv-panel-mission');
          const pVision = document.querySelector('.mv-panel-vision');
          const ticker = document.getElementById('vitalTicker');
          return {
            windowWidth: window.innerWidth,
            docScrollWidth: document.documentElement.scrollWidth,
            hasHorizontalOverflow: document.documentElement.scrollWidth > window.innerWidth,
            missionRect: pMission ? pMission.getBoundingClientRect() : null,
            visionRect: pVision ? pVision.getBoundingClientRect() : null,
            isStacked: pMission && pVision ? pVision.getBoundingClientRect().top >= pMission.getBoundingClientRect().bottom - 5 : false
          };
        })()
      `
    });

    const val = check.result.result.value;
    console.log(`Viewport ${vp.name} (${vp.w}x${vp.h}): overflow=${val.hasHorizontalOverflow}, isStacked=${val.isStacked}`);

    // If mobile 390, capture screenshot of mobile layout
    if (vp.w === 390) {
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(ARTIFACT_DIR, 'about_mobile_390.png'), Buffer.from(shot.result.data, 'base64'));
      fs.writeFileSync(path.join(SCRATCH_DIR, 'about_mobile_390.png'), Buffer.from(shot.result.data, 'base64'));
    }

    ws.close();
  } catch (err) {
    console.error(`Error on ${vp.name}:`, err);
  } finally {
    chrome.kill();
  }
}

async function runAll() {
  for (const vp of viewports) {
    await checkAboutViewport(vp);
  }
}

runAll();

