const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

async function test() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9590;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2200));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page');

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (callbacks.has(data.id)) {
        callbacks.get(data.id)(data);
        callbacks.delete(data.id);
      }
    };

    await new Promise(r => ws.onopen = r);

    function send(method, params = {}) {
      return new Promise(resolve => {
        const id = idCounter++;
        callbacks.set(id, resolve);
        ws.send(JSON.stringify({ id, method, params }));
      });
    }

    await send('Page.enable');
    await send('Runtime.enable');

    // Get track total scroll
    const trackInfo = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const track = document.getElementById('heroScrollTrack');
          const totalScroll = track.offsetHeight - window.innerHeight;
          return { totalScroll, offsetHeight: track.offsetHeight, innerHeight: window.innerHeight };
        })()
      `,
      returnByValue: true
    });
    const { totalScroll } = trackInfo.result.result.value;
    console.log('Hero total scroll distance:', totalScroll);

    const progressPoints = [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0];

    for (const p of progressPoints) {
      const sy = Math.round(p * totalScroll);
      await send('Runtime.evaluate', {
        expression: `
          window.scrollTo(0, ${sy});
          window.dispatchEvent(new Event('scroll'));
        `
      });
      await new Promise(r => setTimeout(r, 300));

      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      const filename = `scroll_step_${Math.round(p * 100)}.png`;
      fs.writeFileSync(path.join('scratch', filename), buf);
      console.log(`Captured step ${Math.round(p * 100)}% (scrollY=${sy}) -> ${filename}`);
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

test().catch(console.error);
