const { spawn } = require('child_process');

async function debugIndexH3() {
  const port = 9951;
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
    deviceScaleFactor: 1,
    mobile: true
  });

  await send('Page.reload', { ignoreCache: true });
  await new Promise(r => setTimeout(r, 800));

  const evalRes = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const h3s = Array.from(document.querySelectorAll('h3')).map(h => {
          const r = h.getBoundingClientRect();
          const s = window.getComputedStyle(h);
          const parent = h.parentElement;
          const pRect = parent ? parent.getBoundingClientRect() : null;
          return {
            text: h.innerText.slice(0, 30),
            tag: h.tagName,
            cls: h.className,
            fontSize: s.fontSize,
            lineHeight: s.lineHeight,
            rectW: Math.round(r.width),
            rectLeft: Math.round(r.left),
            rectRight: Math.round(r.right),
            parentW: pRect ? Math.round(pRect.width) : null,
            parentCls: parent ? parent.className : '',
            offsetParent: h.offsetParent ? h.offsetParent.className : null
          };
        });
        return {
          windowInnerWidth: window.innerWidth,
          docScrollWidth: document.documentElement.scrollWidth,
          h3s
        };
      })()
    `,
    returnByValue: true
  });

  console.log(JSON.stringify(evalRes.result.result.value, null, 2));
  chrome.kill();
}

debugIndexH3();

