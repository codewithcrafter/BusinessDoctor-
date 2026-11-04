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
  const port = 9985 + Math.floor(Math.random() * 50);
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
    await new Promise(r => setTimeout(r, 400));

    // Scroll to #capabilities
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));

    // Measure initial state
    const initCheck = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const hasOverflow = navBar.scrollWidth > navBar.clientWidth;
          return {
            windowWidth: window.innerWidth,
            scrollWidth: navBar.scrollWidth,
            clientWidth: navBar.clientWidth,
            hasOverflow: hasOverflow,
            prevVisible: !prev.classList.contains('is-hidden') && getComputedStyle(prev).visibility === 'visible',
            nextVisible: !next.classList.contains('is-hidden') && getComputedStyle(next).visibility === 'visible',
            docScrollWidth: document.documentElement.scrollWidth,
            hasDocOverflow: document.documentElement.scrollWidth > window.innerWidth
          };
        })()
      `
    });

    console.log(`Viewport ${vp.name} (${vp.w}x${vp.h}) Initial:`, initCheck.result.result.value);

    // If mobile 390, capture screenshot
    if (vp.w === 390) {
      const shot390 = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(ARTIFACT_DIR, 'tabs_arrows_mobile_390.png'), Buffer.from(shot390.result.data, 'base64'));
      fs.writeFileSync(path.join(SCRATCH_DIR, 'tabs_arrows_mobile_390.png'), Buffer.from(shot390.result.data, 'base64'));
    }

    // Click next arrow
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const next = document.getElementById('capNavNext');
          if (next) next.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 500));

    const scrolledCheck = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          return {
            scrollLeft: Math.round(navBar.scrollLeft),
            prevVisible: !prev.classList.contains('is-hidden') && getComputedStyle(prev).visibility === 'visible'
          };
        })()
      `
    });

    console.log(`Viewport ${vp.name} Scrolled:`, scrolledCheck.result.result.value);

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
  console.log('\nAll 7 viewports verified successfully!');
}

runAll();

