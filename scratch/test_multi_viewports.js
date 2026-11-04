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

async function testViewport(vp) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9500 + Math.floor(Math.random() * 50);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    'http://127.0.0.1:8000/'
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
    await new Promise(r => setTimeout(r, 500));

    // Capture initial state (p = 0)
    const shot0 = await send('Page.captureScreenshot', { format: 'png' });
    const buf0 = Buffer.from(shot0.result.data, 'base64');
    fs.writeFileSync(path.join(ARTIFACT_DIR, `hero_verified_${vp.name}_p0.png`), buf0);
    fs.writeFileSync(path.join(SCRATCH_DIR, `hero_verified_${vp.name}_p0.png`), buf0);

    // Measure metrics
    const evalRes = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const nav = document.querySelector('.site-header');
          const h1 = document.querySelector('.hero-headline-oversized');
          const hud = document.querySelector('#heroVisualLayer');
          const navR = nav ? nav.getBoundingClientRect() : null;
          const h1R = h1 ? h1.getBoundingClientRect() : null;
          const hudR = hud ? hud.getBoundingClientRect() : null;
          return {
            windowWidth: window.innerWidth,
            docScrollWidth: document.documentElement.scrollWidth,
            hasHorizontalOverflow: document.documentElement.scrollWidth > window.innerWidth,
            navBottom: navR ? navR.bottom : 0,
            h1Top: h1R ? h1R.top : 0,
            h1Bottom: h1R ? h1R.bottom : 0,
            clearanceTop: h1R && navR ? Math.round(h1R.top - navR.bottom) : null,
            clearanceX: hudR && h1R ? Math.round(hudR.left - h1R.right) : null,
            h1Color: h1 ? getComputedStyle(h1).color : null
          };
        })()
      `
    });

    const metrics = evalRes.result.result.value;
    console.log(`Viewport ${vp.name} (${vp.w}x${vp.h}):`, metrics);

    // If desktop (>= 1024), also scroll to p = 0.5 to capture Layer B
    if (vp.w >= 1024) {
      await send('Runtime.evaluate', {
        expression: `
          (() => {
            const track = document.getElementById('heroScrollTrack');
            const totalScroll = track.getBoundingClientRect().height - window.innerHeight;
            window.scrollTo({ top: totalScroll * 0.5, behavior: 'instant' });
          })()
        `
      });
      await new Promise(r => setTimeout(r, 150));
      const shot50 = await send('Page.captureScreenshot', { format: 'png' });
      const buf50 = Buffer.from(shot50.result.data, 'base64');
      fs.writeFileSync(path.join(ARTIFACT_DIR, `hero_verified_${vp.name}_p50.png`), buf50);
      fs.writeFileSync(path.join(SCRATCH_DIR, `hero_verified_${vp.name}_p50.png`), buf50);
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
    await testViewport(vp);
  }
  console.log('\nAll viewports tested successfully!');
}

runAll();

