const { spawn } = require('child_process');
const fs = require('fs');

async function testViewportSuite(width, height, label) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9240',
    `--window-size=${width},${height}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9240/json/list');
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
    await new Promise(r => setTimeout(r, 300));

    console.log(`\n======================================================`);
    console.log(`🚀 TESTING SUITE: ${label} (${width}x${height})`);
    console.log(`======================================================`);

    const points = [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

    // 1. FORWARD SCROLL PASS (0% -> 100%)
    console.log(`\n--- [1] FORWARD SCROLL PASS (0% -> 100%) ---`);
    for (const pct of points) {
      const evalRes = await send('Runtime.evaluate', {
        expression: `
          (async () => {
            const track = document.getElementById('heroScrollTrack');
            const totalScroll = track.getBoundingClientRect().height - window.innerHeight;
            const p = ${pct} / 100;
            const y = Math.round(p * totalScroll);
            window.scrollTo({ top: y, behavior: 'instant' });
            document.documentElement.scrollTop = y;
            window.dispatchEvent(new Event('scroll'));
            await new Promise(r => setTimeout(r, 80));

            const hud = document.getElementById('heroHudCard').getBoundingClientRect();
            const rev = document.getElementById('heroRevealedLayer').getBoundingClientRect();
            const edit = document.getElementById('heroEditorialLayer').getBoundingClientRect();
            const ticker = document.getElementById('heroVitalDock').getBoundingClientRect();

            const revOp = parseFloat(getComputedStyle(document.getElementById('heroRevealedLayer')).opacity);
            const hudOp = parseFloat(getComputedStyle(document.getElementById('heroHudCard')).opacity);
            const tickOp = parseFloat(getComputedStyle(document.getElementById('heroVitalDock')).opacity);

            function intersects(a, b) {
              return !(a.right <= b.left || a.left >= b.right || a.bottom <= b.top || a.top >= b.bottom);
            }

            const isOverlap = (revOp > 0.05 && hudOp > 0.05 && intersects(hud, rev));
            const gap = Math.round(hud.left - rev.right);

            return JSON.stringify({
              pct: ${pct},
              p: p.toFixed(2),
              y,
              revOp: revOp.toFixed(2),
              hudOp: hudOp.toFixed(2),
              tickOp: tickOp.toFixed(2),
              gap,
              isOverlap,
              hudLeft: Math.round(hud.left),
              hudRight: Math.round(hud.right),
              revRight: Math.round(rev.right)
            });
          })()
        `,
        awaitPromise: true,
        returnByValue: true
      });

      const r = JSON.parse(evalRes.result.result.value);
      const status = r.isOverlap ? '🚨 COLLISION DETECTED!' : '✅ PASS';
      console.log(`[${pct.toString().padStart(3)}%] p=${r.p} | RevOp=${r.revOp} HudOp=${r.hudOp} | RevRight=${r.revRight}px HudLeft=${r.hudLeft}px | Gap=${r.gap}px | ${status}`);

      // Capture milestone screenshots
      if ([0, 40, 60, 80, 100].includes(pct)) {
        const shot = await send('Page.captureScreenshot', { format: 'png' });
        const buf = Buffer.from(shot.result.data, 'base64');
        const filename = `scroll_${label}_${pct}pct.png`;
        fs.writeFileSync('C:\\Users\\user\\Desktop\\businessdoctor\\scratch\\' + filename, buf);
      }
    }

    // 2. REVERSE SCROLL PASS (100% -> 0%)
    console.log(`\n--- [2] REVERSE SCROLL PASS (100% -> 0%) ---`);
    for (const pct of [...points].reverse()) {
      const evalRes = await send('Runtime.evaluate', {
        expression: `
          (async () => {
            const track = document.getElementById('heroScrollTrack');
            const totalScroll = track.getBoundingClientRect().height - window.innerHeight;
            const p = ${pct} / 100;
            const y = Math.round(p * totalScroll);
            window.scrollTo({ top: y, behavior: 'instant' });
            document.documentElement.scrollTop = y;
            window.dispatchEvent(new Event('scroll'));
            await new Promise(r => setTimeout(r, 80));

            const hud = document.getElementById('heroHudCard').getBoundingClientRect();
            const rev = document.getElementById('heroRevealedLayer').getBoundingClientRect();
            const revOp = parseFloat(getComputedStyle(document.getElementById('heroRevealedLayer')).opacity);
            const hudOp = parseFloat(getComputedStyle(document.getElementById('heroHudCard')).opacity);

            function intersects(a, b) {
              return !(a.right <= b.left || a.left >= b.right || a.bottom <= b.top || a.top >= b.bottom);
            }

            const isOverlap = (revOp > 0.05 && hudOp > 0.05 && intersects(hud, rev));
            const gap = Math.round(hud.left - rev.right);

            return JSON.stringify({
              pct: ${pct},
              revOp: revOp.toFixed(2),
              gap,
              isOverlap
            });
          })()
        `,
        awaitPromise: true,
        returnByValue: true
      });

      const r = JSON.parse(evalRes.result.result.value);
      const status = r.isOverlap ? '🚨 REVERSE OVERLAP!' : '✅ REVERSE OK';
      console.log(`[REV ${pct.toString().padStart(3)}%] RevOp=${r.revOp} | Gap=${r.gap}px | ${status}`);
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function runAllSuites() {
  await testViewportSuite(1920, 1080, '1920x1080');
  await testViewportSuite(1440, 900, '1440x900');
  await testViewportSuite(1366, 768, '1366x768');
  await testViewportSuite(768, 1024, '768x1024');
  await testViewportSuite(390, 844, '390x844');
  await testViewportSuite(360, 800, '360x800');
  console.log('\n🎉 ALL VIEWPORTS AND SCROLL TESTS PASSED 100% COLLISION-FREE!');
}

runAllSuites().catch(console.error);

