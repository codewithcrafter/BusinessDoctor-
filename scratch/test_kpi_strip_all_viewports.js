const { spawn } = require('child_process');
const fs = require('fs');

async function testViewport(v, port) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    `--remote-debugging-port=${port}`,
    `--window-size=${v.w},${v.h}`,
    'http://127.0.0.1:8000/'
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
      width: v.w,
      height: v.h,
      deviceScaleFactor: 1,
      mobile: v.w < 768
    });

    await new Promise(r => setTimeout(r, 400));

    // Scroll to 90% of hero scroll track
    await send('Runtime.evaluate', {
      expression: `
        (function() {
          const track = document.getElementById('heroScrollTrack');
          const maxScroll = track ? track.offsetHeight - window.innerHeight : 1000;
          window.scrollTo(0, maxScroll * 0.90);
        })()
      `
    });

    // Wait for animations
    await new Promise(r => setTimeout(r, 1600));

    // Evaluate layout and styles
    const rawRes = await send('Runtime.evaluate', {
      expression: `
        (function() {
          const strip = document.getElementById('vitalTicker');
          const grid = document.querySelector('.vital-ticker-grid');
          const items = Array.from(document.querySelectorAll('.vital-item'));
          const numbers = Array.from(document.querySelectorAll('.vital-number'));
          const labels = Array.from(document.querySelectorAll('.vital-label'));

          const stripStyle = window.getComputedStyle(strip);
          const gridStyle = window.getComputedStyle(grid);
          const num0Style = window.getComputedStyle(numbers[0]);
          const lbl0Style = window.getComputedStyle(labels[0]);

          const sRect = strip.getBoundingClientRect();
          const docScrollWidth = document.documentElement.scrollWidth;
          const docClientWidth = document.documentElement.clientWidth;

          return {
            docScrollWidth,
            docClientWidth,
            hasHorizontalScroll: docScrollWidth > docClientWidth,
            gridTemplateColumns: gridStyle.gridTemplateColumns,
            stripRect: { top: Math.round(sRect.top), left: Math.round(sRect.left), width: Math.round(sRect.width), height: Math.round(sRect.height) },
            stripBg: stripStyle.backgroundImage || stripStyle.backgroundColor,
            numberColor: num0Style.color,
            numberFont: num0Style.fontSize + ' ' + num0Style.fontFamily,
            labelColor: lbl0Style.color,
            labelFont: lbl0Style.fontSize,
            items: items.map((it, i) => {
              const r = it.getBoundingClientRect();
              return {
                num: numbers[i].innerText.trim(),
                label: labels[i].innerText.trim(),
                left: Math.round(r.left),
                top: Math.round(r.top),
                width: Math.round(r.width),
                height: Math.round(r.height)
              };
            })
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`\n========================================`);
    console.log(`VIEWPORT: ${v.w}x${v.h} (${v.label})`);
    console.log(`========================================`);
    const val = rawRes.result && rawRes.result.result && rawRes.result.result.value;
    if (val) {
      console.log('Columns:', val.gridTemplateColumns);
      console.log('Horizontal Overflow?', val.hasHorizontalScroll ? 'YES (FAIL)' : 'NO (PASS)');
      console.log('Number Color:', val.numberColor);
      console.log('Label Color:', val.labelColor);
      console.log('Strip Size:', `${val.stripRect.width}x${val.stripRect.height}`);
      val.items.forEach((it, i) => {
        console.log(` Item ${i+1}: "${it.num}" — "${it.label}" [${it.width}x${it.height} at x:${it.left}, y:${it.top}]`);
      });
    }

    // Capture screenshot
    const shot = await send('Page.captureScreenshot', { format: 'png' });
    const buf = Buffer.from(shot.result.data, 'base64');
    fs.writeFileSync('scratch/' + v.filename, buf);
    console.log(`Saved screenshot: scratch/${v.filename}`);

    ws.close();
  } catch (err) {
    console.error(`Error in ${v.w}x${v.h}:`, err.message);
  } finally {
    chrome.kill();
    await new Promise(r => setTimeout(r, 500));
  }
}

(async () => {
  const testCases = [
    { w: 1920, h: 1080, label: 'Desktop 1920px', filename: 'kpi_strip_1920px.png' },
    { w: 1440, h: 900,  label: 'Desktop 1440px', filename: 'kpi_strip_1440px.png' },
    { w: 768,  h: 1024, label: 'Tablet 768px',   filename: 'kpi_strip_768px.png' },
    { w: 390,  h: 844,  label: 'Mobile 390px',   filename: 'kpi_strip_390px.png' },
    { w: 360,  h: 800,  label: 'Mobile 360px',   filename: 'kpi_strip_360px.png' }
  ];

  let port = 9230;
  for (const tc of testCases) {
    port++;
    await testViewport(tc, port);
  }
  console.log('\nAll 5 viewports tested and captured successfully!');
})();
