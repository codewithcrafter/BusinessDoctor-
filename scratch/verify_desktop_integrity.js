const { spawn } = require('child_process');

async function verifyDesktop() {
  const port = 9963;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 1500));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pagesList = await res.json();
  const page = pagesList.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pagesList[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  function send(method, params = {}) {
    return new Promise(resolve => {
      const id = Math.floor(Math.random() * 1000000);
      const handler = (evt) => {
        const data = JSON.parse(evt.data);
        if (data.id === id) {
          ws.removeEventListener('message', handler);
          resolve(data);
        }
      };
      ws.addEventListener('message', handler);
      ws.send(JSON.stringify({ id, method, params }));
    });
  }

  await new Promise(r => ws.onopen = r);
  await send('Network.enable');
  await send('Page.enable');
  await send('Runtime.enable');

  for (const w of [1920, 1440]) {
    await send('Emulation.setDeviceMetricsOverride', { width: w, height: 900, deviceScaleFactor: 1, mobile: false });
    
    // Check Home
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
    await new Promise(r => setTimeout(r, 600));
    const homeRes = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const card = document.querySelector('.capability-editorial-card');
          const title = document.querySelector('.cap-card-title');
          const cs = card ? window.getComputedStyle(card) : null;
          const ts = title ? window.getComputedStyle(title) : null;
          return {
            page: 'index.php',
            viewportWidth: window.innerWidth,
            gridColumns: cs ? cs.gridTemplateColumns : null,
            titleFontSize: ts ? ts.fontSize : null,
            overflow: document.documentElement.scrollWidth > window.innerWidth
          };
        })()
      `,
      returnByValue: true
    });

    // Check Services
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/services.php' });
    await new Promise(r => setTimeout(r, 600));
    const servRes = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const card = document.querySelector('.capability-editorial-card');
          const title = document.querySelector('.cap-card-title');
          const cs = card ? window.getComputedStyle(card) : null;
          const ts = title ? window.getComputedStyle(title) : null;
          return {
            page: 'services.php',
            viewportWidth: window.innerWidth,
            gridColumns: cs ? cs.gridTemplateColumns : null,
            titleFontSize: ts ? ts.fontSize : null,
            overflow: document.documentElement.scrollWidth > window.innerWidth
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`[${w}px Desktop Verification]`);
    console.log('  Home:', homeRes.result.result.value);
    console.log('  Services:', servRes.result.result.value);
  }

  chrome.kill();
}

verifyDesktop();
