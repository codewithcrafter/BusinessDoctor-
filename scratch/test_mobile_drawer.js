const { spawn } = require('child_process');
(async () => {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new', '--remote-debugging-port=9603', '--window-size=390,844', 'http://127.0.0.1:8000/'
  ]);
  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9603/json/list');
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
  await send('Emulation.setDeviceMetricsOverride', { width: 390, height: 844, deviceScaleFactor: 1, mobile: true });

  const result = await send('Runtime.evaluate', {
    returnByValue: true,
    expression: `
      (() => {
        const toggleBtn = document.getElementById('menuToggleBtn');
        const drawer = document.getElementById('mobileDrawer');
        const initialOpen = drawer.classList.contains('open');

        // Tap toggle button
        toggleBtn.click();
        const afterOpen = drawer.classList.contains('open');

        const serviceLinks = drawer.querySelectorAll('.mobile-nav-sublink');

        // Tap toggle button again
        toggleBtn.click();
        const afterClose = drawer.classList.contains('open');

        return { initialOpen, afterOpen, serviceLinksCount: serviceLinks.length, afterClose };
      })()
    `
  });
  console.log('Mobile test result:', result.result.result.value);
  ws.close();
  chrome.kill();
})();
