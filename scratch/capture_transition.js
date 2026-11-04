const { spawn } = require('child_process');
const fs = require('fs');

(async () => {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new', '--disable-gpu', '--remote-debugging-port=9610', '--window-size=1920,1080', 'http://127.0.0.1:8000/'
  ]);
  await new Promise(r => setTimeout(r, 2200));
  const res = await fetch('http://127.0.0.1:9610/json/list');
  const pages = await res.json();
  const ws = new WebSocket(pages[0].webSocketDebuggerUrl);
  let id = 1; const callbacks = new Map();
  ws.onmessage = e => { const d = JSON.parse(e.data); if (callbacks.has(d.id)) { callbacks.get(d.id)(d); callbacks.delete(d.id); } };
  await new Promise(r => ws.onopen = r);
  function send(m, p={}) { return new Promise(res => { const i = id++; callbacks.set(i, res); ws.send(JSON.stringify({id:i, method:m, params:p})); }); }
  await send('Page.enable'); await send('Runtime.enable');
  for (const sy of [1500, 1650, 1800, 2000]) {
    await send('Runtime.evaluate', { expression: `window.scrollTo(0, ${sy}); window.dispatchEvent(new Event('scroll'));` });
    await new Promise(r => setTimeout(r, 400));
    const shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(`scratch/scroll_trans_${sy}.png`, Buffer.from(shot.result.data, 'base64'));
    console.log(`Captured scroll_trans_${sy}.png`);
  }
  ws.close(); chrome.kill();
})().catch(console.error);

