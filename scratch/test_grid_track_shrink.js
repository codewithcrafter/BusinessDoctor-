const { spawn } = require('child_process');

async function testGridTrackShrink() {
  const port = 9959;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/index.php'
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
  await send('Emulation.setDeviceMetricsOverride', {
    width: 360,
    height: 800,
    deviceScaleFactor: 2,
    mobile: true
  });
  await send('Page.reload', { ignoreCache: true });
  await new Promise(r => setTimeout(r, 1000));

  const before = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const h = document.querySelector('.cap-card-title');
        const body = document.querySelector('.cap-card-body');
        const card = document.querySelector('.capability-editorial-card');
        return {
          hWidth: h ? Math.round(h.getBoundingClientRect().width) : null,
          bodyWidth: body ? Math.round(body.getBoundingClientRect().width) : null,
          cardWidth: card ? Math.round(card.getBoundingClientRect().width) : null
        };
      })()
    `,
    returnByValue: true
  });

  // Inject fix
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const style = document.createElement('style');
        style.textContent = \`
          @media (max-width: 1024px) {
            .capability-editorial-card {
              grid-template-columns: minmax(0, 1fr) !important;
            }
          }
          .cap-card-body,
          .cap-card-sidebar {
            min-width: 0 !important;
            max-width: 100% !important;
          }
          .cap-card-body > div {
            min-width: 0 !important;
            max-width: 100% !important;
          }
          .cap-card-title {
            max-width: 100% !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
          }
        \`;
        document.head.appendChild(style);
      })()
    `
  });

  const after = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const h = document.querySelector('.cap-card-title');
        const body = document.querySelector('.cap-card-body');
        const card = document.querySelector('.capability-editorial-card');
        return {
          hWidth: h ? Math.round(h.getBoundingClientRect().width) : null,
          bodyWidth: body ? Math.round(body.getBoundingClientRect().width) : null,
          cardWidth: card ? Math.round(card.getBoundingClientRect().width) : null
        };
      })()
    `,
    returnByValue: true
  });

  console.log('Before fix:', before.result.result.value);
  console.log('After fix:', after.result.result.value);
  chrome.kill();
}

testGridTrackShrink();

