const { spawn } = require('child_process');
(async () => {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new', '--remote-debugging-port=9601', '--window-size=1440,900', 'http://127.0.0.1:8000/'
  ]);
  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9601/json/list');
  const pages = await res.json();
  const page = pages.find(p => !p.url.startsWith('chrome-extension'));
  const ws = new WebSocket(page.webSocketDebuggerUrl);
  let id = 1;
  const callbacks = new Map();
  ws.onmessage = e => {
    const d = JSON.parse(e.data);
    if (callbacks.has(d.id)) callbacks.get(d.id)(d);
  };
  await new Promise(r => ws.onopen = r);
  const send = (m, p={}) => new Promise(res => { const i = id++; callbacks.set(i, res); ws.send(JSON.stringify({ id: i, method: m, params: p })); });
  await send('Runtime.enable');
  await send('Page.enable');

  const info = await send('Runtime.evaluate', {
    returnByValue: true,
    expression: `
      (() => {
        const item = document.querySelector('.has-mega-menu');
        item.style.position = 'static';
        const navbar = document.querySelector('.navbar');
        navbar.style.position = 'relative';
        item.classList.add('is-open');
        const menu = document.querySelector('.mega-menu');
        const r = menu.getBoundingClientRect();
        return {
          windowWidth: window.innerWidth,
          menuRect: { left: r.left, right: r.right, top: r.top, bottom: r.bottom, width: r.width }
        };
      })()
    `
  });
  console.log('Position static Info:', info.result.result.value);
  ws.close();
  chrome.kill();
})();
