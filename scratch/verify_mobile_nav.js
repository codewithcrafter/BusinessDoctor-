const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function verifyMobileNav() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9610;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=390,844',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();
    const errors = [];

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (data.method === 'Runtime.exceptionThrown') {
        errors.push(data.params.exceptionDetails);
      }
      if (data.method === 'Runtime.consoleAPICalled' && data.params.type === 'error') {
        errors.push(data.params.args.map(a => a.value).join(' '));
      }
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

    // Capture mobile closed navbar
    const shotClosed = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'navbar_mobile_390_closed.png'), Buffer.from(shotClosed.result.data, 'base64'));

    // Open mobile drawer
    const toggleResult = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const btn = document.getElementById('menuToggleBtn');
          if (btn) btn.click();
          const drawer = document.getElementById('mobileDrawer');
          return {
            btnExists: !!btn,
            drawerOpen: drawer ? drawer.classList.contains('open') || drawer.classList.contains('active') || getComputedStyle(drawer).display !== 'none' : false,
            mobileNavLinks: drawer ? Array.from(drawer.querySelectorAll('a')).map(a => a.textContent.trim()) : []
          };
        })()
      `
    });

    console.log('Mobile Drawer Toggle Result:', JSON.stringify(toggleResult.result.result.value, null, 2));

    await new Promise(r => setTimeout(r, 300));
    const shotOpen = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'navbar_mobile_390_open.png'), Buffer.from(shotOpen.result.data, 'base64'));

    console.log('Mobile Console Errors:', errors.length);
    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

verifyMobileNav();

