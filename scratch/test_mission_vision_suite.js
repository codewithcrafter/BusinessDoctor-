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

    // Scroll to the stats strip so the entire section has been scrolled through
    await send('Runtime.evaluate', {
      expression: `
        (function() {
          const stats = document.getElementById('vitalTicker');
          if (stats) {
            stats.scrollIntoView({ behavior: 'instant', block: 'center' });
          }
        })()
      `
    });

    // Wait 1.6s for animations (reveal + numbers)
    await new Promise(r => setTimeout(r, 1600));

    // Now scroll slightly back to show the complete Mission & Vision section nicely
    await send('Runtime.evaluate', {
      expression: `
        (function() {
          const section = document.getElementById('missionVision');
          if (section) {
            const rect = section.getBoundingClientRect();
            // Scroll so section is in upper portion
            window.scrollBy(0, rect.top - 80);
          }
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));

    // Inspect layout and values
    const rawRes = await send('Runtime.evaluate', {
      expression: `
        (function() {
          const section = document.getElementById('missionVision');
          const grid = document.querySelector('.mission-vision-grid');
          const missionPanel = document.querySelector('.mv-panel-mission');
          const visionPanel = document.querySelector('.mv-panel-vision');
          const statsStrip = document.getElementById('vitalTicker');
          const statsGrid = document.querySelector('.vital-ticker-grid');
          const numbers = Array.from(document.querySelectorAll('.vital-number'));
          const labels = Array.from(document.querySelectorAll('.vital-label'));

          const secRect = section.getBoundingClientRect();
          const mRect = missionPanel.getBoundingClientRect();
          const vRect = visionPanel.getBoundingClientRect();
          const sRect = statsStrip.getBoundingClientRect();

          const gridStyle = window.getComputedStyle(grid);
          const statsGridStyle = window.getComputedStyle(statsGrid);
          const num0Style = window.getComputedStyle(numbers[0]);
          const lbl0Style = window.getComputedStyle(labels[0]);

          const docScrollWidth = document.documentElement.scrollWidth;
          const docClientWidth = document.documentElement.clientWidth;

          return {
            docScrollWidth,
            docClientWidth,
            hasHorizontalScroll: docScrollWidth > docClientWidth,
            mvGridCols: gridStyle.gridTemplateColumns,
            statsGridCols: statsGridStyle.gridTemplateColumns,
            sectionRect: {
              top: Math.round(secRect.top + window.scrollY),
              left: Math.round(secRect.left),
              width: Math.round(secRect.width),
              height: Math.round(secRect.height)
            },
            missionPanel: {
              width: Math.round(mRect.width),
              height: Math.round(mRect.height),
              left: Math.round(mRect.left),
              top: Math.round(mRect.top),
              isRevealed: missionPanel.classList.contains('is-revealed')
            },
            visionPanel: {
              width: Math.round(vRect.width),
              height: Math.round(vRect.height),
              left: Math.round(vRect.left),
              top: Math.round(vRect.top),
              isRevealed: visionPanel.classList.contains('is-revealed')
            },
            statsStrip: {
              width: Math.round(sRect.width),
              height: Math.round(sRect.height),
              left: Math.round(sRect.left),
              top: Math.round(sRect.top),
              isAnimated: statsStrip.classList.contains('is-animated')
            },
            numberColor: num0Style.color,
            labelColor: lbl0Style.color,
            kpis: numbers.map((n, i) => ({
              num: n.innerText.trim(),
              label: labels[i].innerText.trim()
            }))
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`\n========================================`);
    console.log(`TEST VIEWPORT: ${v.w}x${v.h} (${v.label})`);
    console.log(`========================================`);
    const val = rawRes.result && rawRes.result.result && rawRes.result.result.value;
    if (val) {
      console.log('MV Columns:', val.mvGridCols);
      console.log('Stats Columns:', val.statsGridCols);
      console.log('Horizontal Overflow?', val.hasHorizontalScroll ? 'YES (FAIL)' : 'NO (PASS)');
      console.log('Mission Panel:', `${val.missionPanel.width}x${val.missionPanel.height} at (${val.missionPanel.left}, ${val.missionPanel.top}) | Revealed: ${val.missionPanel.isRevealed}`);
      console.log('Vision Panel:', `${val.visionPanel.width}x${val.visionPanel.height} at (${val.visionPanel.left}, ${val.visionPanel.top}) | Revealed: ${val.visionPanel.isRevealed}`);
      console.log('Stats Strip:', `${val.statsStrip.width}x${val.statsStrip.height} at (${val.statsStrip.left}, ${val.statsStrip.top}) | Animated: ${val.statsStrip.isAnimated}`);
      console.log('KPIs:', val.kpis.map(k => `${k.num} — ${k.label}`).join(' | '));

      // Capture full-section clip screenshot
      const shot = await send('Page.captureScreenshot', {
        format: 'png',
        clip: {
          x: 0,
          y: val.sectionRect.top,
          width: v.w,
          height: val.sectionRect.height,
          scale: 1
        },
        captureBeyondViewport: true
      });
      const buf = Buffer.from(shot.result.data, 'base64');
      fs.writeFileSync('scratch/' + v.filename, buf);
      console.log(`Saved screenshot: scratch/${v.filename}`);

      // Also copy directly to brain artifact directory
      const destDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
      fs.writeFileSync(`${destDir}\\${v.filename}`, buf);
      console.log(`Copied to artifact dir: ${v.filename}`);
    }

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
    { w: 1920, h: 1080, label: 'Desktop 1920px', filename: 'mission_vision_1920px.png' },
    { w: 1440, h: 900,  label: 'Desktop 1440px', filename: 'mission_vision_1440px.png' },
    { w: 1366, h: 768,  label: 'Desktop 1366px', filename: 'mission_vision_1366px.png' },
    { w: 768,  h: 1024, label: 'Tablet 768px',   filename: 'mission_vision_768px.png' },
    { w: 390,  h: 844,  label: 'Mobile 390px',   filename: 'mission_vision_390px.png' },
    { w: 360,  h: 800,  label: 'Mobile 360px',   filename: 'mission_vision_360px.png' }
  ];

  let port = 9250;
  for (const tc of testCases) {
    port++;
    await testViewport(tc, port);
  }
  console.log('\nAll 6 viewports tested, captured, and copied successfully!');
})();
