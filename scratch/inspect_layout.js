const { spawn } = require('child_process');

async function inspectLayout(width, height) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9226;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    `--remote-debugging-port=${port}`,
    `--window-size=${width},${height}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1800));
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

    await new Promise(r => setTimeout(r, 400));

    // Scroll to dock position (0.90)
    await send('Runtime.evaluate', {
      expression: `
        (function() {
          const track = document.getElementById('heroScrollTrack');
          const maxScroll = track ? track.offsetHeight - window.innerHeight : 1000;
          window.scrollTo(0, maxScroll * 0.90);
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));

    const evalRes = await send('Runtime.evaluate', {
      expression: `
        (function() {
          const grid = document.querySelector('.vital-ticker-grid');
          if (!grid) return { error: 'No .vital-ticker-grid found' };
          const items = Array.from(document.querySelectorAll('.vital-item'));
          const ticker = document.querySelector('.vital-ticker');
          const gridStyle = window.getComputedStyle(grid);
          const tRect = ticker.getBoundingClientRect();
          return {
            gridTemplateColumns: gridStyle.gridTemplateColumns,
            tickerRect: { top: tRect.top, bottom: tRect.bottom, left: tRect.left, right: tRect.right, width: tRect.width, height: tRect.height },
            items: items.map(it => {
              const rect = it.getBoundingClientRect();
              return {
                text: it.innerText.replace(/\\n/g, ' - '),
                top: rect.top,
                bottom: rect.bottom,
                left: rect.left,
                right: rect.right,
                width: rect.width,
                height: rect.height
              };
            })
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`=== Viewport ${width}x${height} ===`);
    if (evalRes.result && evalRes.result.value) {
      const val = evalRes.result.value;
      console.log('Columns:', val.gridTemplateColumns);
      console.log('Ticker Rect:', val.tickerRect);
      val.items && val.items.forEach((it, idx) => {
        console.log(` Item ${idx+1}: [${it.left.toFixed(1)}, ${it.top.toFixed(1)}] ${it.width.toFixed(1)}x${it.height.toFixed(1)} -> ${it.text}`);
      });
    } else {
      console.log('Result:', JSON.stringify(evalRes));
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

(async () => {
  await inspectLayout(1920, 1080);
  await inspectLayout(768, 1024);
  await inspectLayout(390, 844);
})();
