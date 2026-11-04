const { spawn } = require('child_process');
(async () => {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new', '--remote-debugging-port=9602', '--window-size=1440,900', 'http://127.0.0.1:8000/'
  ]);
  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9602/json/list');
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

  const result = await send('Runtime.evaluate', {
    returnByValue: true,
    expression: `
      (() => {
        const item = document.querySelector('.has-mega-menu');
        const trigger = item.querySelector('.nav-link-dropdown');
        const initialOpen = item.classList.contains('is-open');

        // Press Enter on trigger
        trigger.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
        const afterEnter = item.classList.contains('is-open');

        // Press Escape
        document.dispatchEvent(new KeyboardEvent('keydown', { key: 'Escape', bubbles: true }));
        const afterEscape = item.classList.contains('is-open');

        // Press Space on trigger
        trigger.dispatchEvent(new KeyboardEvent('keydown', { key: ' ', bubbles: true }));
        const afterSpace = item.classList.contains('is-open');

        // Press Escape again
        document.dispatchEvent(new KeyboardEvent('keydown', { key: 'Escape', bubbles: true }));
        const afterEscape2 = item.classList.contains('is-open');

        return { initialOpen, afterEnter, afterEscape, afterSpace, afterEscape2 };
      })()
    `
  });
  console.log('Keyboard test result:', result.result.result.value);
  ws.close();
  chrome.kill();
})();

