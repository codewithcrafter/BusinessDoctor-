const { spawn } = require('child_process');

async function run() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9226',
    '--window-size=768,1024',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9226/json/list');
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page');
    const ws = new WebSocket(page.webSocketDebuggerUrl);

    let id = 1;
    const send = (m, p = {}) => new Promise(resolve => {
      const cur = id++;
      const handler = (evt) => {
        const d = JSON.parse(evt.data);
        if (d.id === cur) {
          ws.removeEventListener('message', handler);
          resolve(d);
        }
      };
      ws.addEventListener('message', handler);
      ws.send(JSON.stringify({ id: cur, method: m, params: p }));
    });

    await new Promise(r => ws.onopen = r);
    await send('Runtime.enable');

    for (const y of [0, 500, 650, 800, 1100]) {
      const evalRes = await send('Runtime.evaluate', {
        expression: `
          (async () => {
            window.scrollTo({ top: ${y}, behavior: 'instant' });
            document.documentElement.scrollTop = ${y};
            document.body.scrollTop = ${y};
            window.dispatchEvent(new Event('scroll'));
            await new Promise(r => setTimeout(r, 200));
            const hud = document.getElementById('heroHudCard').getBoundingClientRect();
            const ticker = document.getElementById('heroVitalDock').getBoundingClientRect();
            const header = document.querySelector('.site-header').getBoundingClientRect();
            const track = document.getElementById('heroScrollTrack');
            const rect = track.getBoundingClientRect();
            const totalScroll = rect.height - window.innerHeight;
            const p = (-rect.top) / totalScroll;
            const edit = document.getElementById('heroEditorialLayer');
            const vis = document.getElementById('heroVisualLayer');
            const dock = document.getElementById('heroVitalDock');
            return JSON.stringify({
              y: ${y},
              p: p.toFixed(3),
              editOpacity: getComputedStyle(edit).opacity,
              visOpacity: getComputedStyle(vis).opacity,
              tickerOpacity: getComputedStyle(dock).opacity,
              hudTop: Math.round(hud.top),
              hudBottom: Math.round(hud.bottom),
              tickerTop: Math.round(ticker.top)
            });
          })()
        `,
        awaitPromise: true,
        returnByValue: true
      });
      console.log(evalRes.result.result.value);
    }
    ws.close();
  } finally {
    chrome.kill();
  }
}

run();
