const { spawn } = require('child_process');

async function test() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9620;
  const chrome = spawn(chromePath, [
    '--headless=new', '--disable-gpu', `--remote-debugging-port=${port}`,
    '--window-size=1920,1080', 'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2200));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && p.url.includes('8000')) || pages[0];
    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let id = 1; const callbacks = new Map();
    ws.onmessage = e => { const d = JSON.parse(e.data); if (callbacks.has(d.id)) { callbacks.get(d.id)(d); callbacks.delete(d.id); } };
    await new Promise(r => ws.onopen = r);
    function send(m, p={}) { return new Promise(res => { const i = id++; callbacks.set(i, res); ws.send(JSON.stringify({id:i, method:m, params:p})); }); }
    await send('Page.enable'); await send('Runtime.enable');
    await new Promise(r => setTimeout(r, 1200));

    // Scroll to p = 0.35 (where revealedLayer is visible)
    const data = await send('Runtime.evaluate', {
      expression: `
        (() => {
          try {
            const track = document.getElementById('heroScrollTrack');
            const totalScroll = track.offsetHeight - window.innerHeight;
            window.scrollTo(0, Math.round(0.35 * totalScroll));
            window.dispatchEvent(new Event('scroll'));

            const revLayer = document.querySelector('#heroRevealedLayer');
            const revH2 = document.querySelector('.revealed-headline');
            const hud = document.querySelector('#heroHudCard');
            const visualLayer = document.querySelector('#heroVisualLayer');

            const rRect = revH2.getBoundingClientRect();
            const hudRect = hud.getBoundingClientRect();
            const layerRect = revLayer.getBoundingClientRect();

            return {
              windowWidth: window.innerWidth,
              revLayerRect: { left: Math.round(layerRect.left), right: Math.round(layerRect.right), width: Math.round(layerRect.width) },
              revH2Rect: { left: Math.round(rRect.left), right: Math.round(rRect.right), top: Math.round(rRect.top), bottom: Math.round(rRect.bottom), width: Math.round(rRect.width), text: revH2.innerText },
              hudRect: { left: Math.round(hudRect.left), right: Math.round(hudRect.right), top: Math.round(hudRect.top), bottom: Math.round(hudRect.bottom), width: Math.round(hudRect.width) },
              isOverlapping: !(rRect.right < hudRect.left || rRect.left > hudRect.right || rRect.bottom < hudRect.top || rRect.top > hudRect.bottom),
              horizontalOverlap: Math.round(rRect.right - hudRect.left),
              revLayerStyles: {
                width: window.getComputedStyle(revLayer).width,
                maxWidth: window.getComputedStyle(revLayer).maxWidth,
                whiteSpace: window.getComputedStyle(revH2).whiteSpace,
                wordBreak: window.getComputedStyle(revH2).wordBreak,
                fontSize: window.getComputedStyle(revH2).fontSize
              }
            };
          } catch (err) {
            return { error: err.message, stack: err.stack };
          }
        })()
      `,
      returnByValue: true
    });
    console.log('BUG 2 INSPECTION at p=0.35:', JSON.stringify(data.result?.result?.value, null, 2));
    ws.close();
  } finally {
    chrome.kill();
  }
}

test().catch(console.error);
