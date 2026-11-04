const { spawn } = require('child_process');
const fs = require('fs');

async function takeScreenshot(url, width, height, scrollRatio, filename) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9223;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    `--remote-debugging-port=${port}`,
    `--window-size=${width},${height}`,
    url
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page') || pages[0];

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
    await send('Emulation.setDeviceMetricsOverride', {
      width,
      height,
      deviceScaleFactor: 1,
      mobile: width < 768
    });

    await new Promise(r => setTimeout(r, 500));

    // Scroll to position
    if (scrollRatio > 0) {
      await send('Runtime.evaluate', {
        expression: `
          (function() {
            const track = document.getElementById('heroScrollTrack');
            const maxScroll = track ? track.offsetHeight - window.innerHeight : 1000;
            window.scrollTo(0, maxScroll * ${scrollRatio});
          })()
        `
      });
      await new Promise(r => setTimeout(r, 700));
    }

    const shot = await send('Page.captureScreenshot', { format: 'png' });
    const buf = Buffer.from(shot.result.data, 'base64');
    fs.writeFileSync('scratch/' + filename, buf);
    console.log(`Saved scratch/${filename} (${width}x${height}, ratio=${scrollRatio})`);

    ws.close();
  } finally {
    chrome.kill();
  }
}

(async () => {
  await takeScreenshot('http://127.0.0.1:8000/', 1920, 1080, 0.88, 'test_1920.png');
})();

