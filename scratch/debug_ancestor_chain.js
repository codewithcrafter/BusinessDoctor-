const { spawn } = require('child_process');

async function debugAncestorChain() {
  const port = 9955;
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
  const page = pagesList.find(p => p.type === 'page') || pagesList[0];
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
        const h = document.querySelector('.cap-card-title');
        const chain = [];
        let cur = h;
        while (cur && cur !== document.body) {
          const s = window.getComputedStyle(cur);
          const r = cur.getBoundingClientRect();
          chain.push({
            tag: cur.tagName,
            cls: cur.className,
            id: cur.id,
            display: s.display,
            width: Math.round(r.width),
            scrollWidth: cur.scrollWidth,
            minWidth: s.minWidth,
            maxWidth: s.maxWidth,
            padding: s.padding,
            overflow: s.overflow
          });
          cur = cur.parentElement;
        }
        return chain;
      })()
    `,
    returnByValue: true
  });

  console.log(JSON.stringify(evalRes.result.result.value, null, 2));
  chrome.kill();
}

debugAncestorChain();

