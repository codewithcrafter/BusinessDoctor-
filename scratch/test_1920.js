const { spawn } = require('child_process');

async function test1920() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    '--remote-debugging-port=9998',
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9998/json/list');
  const pages = await res.json();
  const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  function send(method, params = {}) {
    return new Promise(resolve => {
      const id = Math.floor(Math.random() * 100000);
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
  await send('Network.setCacheDisabled', { cacheDisabled: true });
  await send('Page.enable');
  await send('Runtime.enable');
  await send('Page.reload', { ignoreCache: true });
  await new Promise(r => setTimeout(r, 1200));

  const check = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const bar = document.getElementById('capabilitiesNavBar');
        const barR = bar.getBoundingClientRect();
        const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
        return {
          barR: { left: Math.round(barR.left), right: Math.round(barR.right), width: Math.round(barR.width) },
          styleMaxWidth: bar.style.maxWidth,
          styleWidth: bar.style.width,
          tabs: btns.map((b, i) => {
            const r = b.getBoundingClientRect();
            return {
              i: i + 1,
              text: b.innerText.replace(/\\s+/g, ' ').trim(),
              left: Math.round(r.left),
              right: Math.round(r.right),
              width: Math.round(r.width),
              isClippedRight: r.right > barR.right + 2 && r.left < barR.right - 2,
              fullyVisible: r.right <= barR.right + 2 && r.left >= barR.left - 2
            };
          })
        };
      })()
    `,
    returnByValue: true
  });

  console.log('1920 RESULTS:', JSON.stringify(check.result.result.value, null, 2));
  chrome.kill();
  process.exit();
}

test1920();

