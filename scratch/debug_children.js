const { spawn } = require('child_process');

async function debugChildren() {
  const port = 9956;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

  await new Promise(r => setTimeout(r, 1500));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pagesList = await res.json();
  const page = pagesList[0];
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
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
  await new Promise(r => setTimeout(r, 1000));

  const evalRes = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const body = document.querySelector('.cap-card-body');
        const children = [];
        body.querySelectorAll('*').forEach(el => {
          const r = el.getBoundingClientRect();
          const s = window.getComputedStyle(el);
          children.push({
            tag: el.tagName,
            cls: el.className,
            text: (el.innerText || '').slice(0, 35).trim(),
            width: Math.round(r.width),
            scrollWidth: el.scrollWidth,
            whiteSpace: s.whiteSpace,
            display: s.display
          });
        });
        return children;
      })()
    `,
    returnByValue: true
  });

  console.log(JSON.stringify(evalRes.result.result.value, null, 2));
  chrome.kill();
}

debugChildren();

