const { spawn } = require('child_process');

(async () => {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new', '--remote-debugging-port=9599', 'http://127.0.0.1:8000/'
  ]);
  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9599/json/list');
  const pages = await res.json();
  const ws = new WebSocket(pages[0].webSocketDebuggerUrl);
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

  const log = await send('Runtime.evaluate', {
    returnByValue: true,
    expression: `
      (() => {
        const item = document.querySelector('.has-mega-menu');
        const trigger = item.querySelector('.nav-link-dropdown');
        const panel = item.querySelector('.mega-menu');
        
        // Dispatch mouseenter on item
        item.dispatchEvent(new MouseEvent('mouseenter'));
        const s1 = item.classList.contains('is-open');

        // Dispatch mouseleave on item
        item.dispatchEvent(new MouseEvent('mouseleave'));
        return { s1 };
      })()
    `
  });
  console.log('Immediate:', JSON.stringify(log));

  await new Promise(r => setTimeout(r, 400));
  const s2 = await send('Runtime.evaluate', {
    returnByValue: true,
    expression: `document.querySelector('.has-mega-menu').classList.contains('is-open')`
  });
  console.log('After 400ms is-open:', JSON.stringify(s2));

  ws.close();
  chrome.kill();
})();
