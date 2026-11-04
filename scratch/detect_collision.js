const { spawn } = require('child_process');

async function testCollisions(width, height) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9235',
    `--window-size=${width},${height}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9235/json/list');
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

    await send('Runtime.enable');

    console.log(`\n=== Testing Viewport ${width}x${height} ===`);

    const evalRes = await send('Runtime.evaluate', {
      expression: `
        (async () => {
          const track = document.getElementById('heroScrollTrack');
          const totalScroll = track.getBoundingClientRect().height - window.innerHeight;
          const hud = document.getElementById('heroHudCard');
          const revealed = document.getElementById('heroRevealedLayer');
          const editorial = document.getElementById('heroEditorialLayer');
          const ticker = document.getElementById('heroVitalDock');
          const results = [];

          for (let pct = 0; pct <= 100; pct += 10) {
            const p = pct / 100;
            const y = Math.round(p * totalScroll);
            window.scrollTo({ top: y, behavior: 'instant' });
            document.documentElement.scrollTop = y;
            window.dispatchEvent(new Event('scroll'));
            await new Promise(r => setTimeout(r, 80));

            const hudR = hud.getBoundingClientRect();
            const revR = revealed.getBoundingClientRect();
            const editR = editorial.getBoundingClientRect();
            const tickR = ticker.getBoundingClientRect();

            const revOpacity = parseFloat(getComputedStyle(revealed).opacity);
            const editOpacity = parseFloat(getComputedStyle(editorial).opacity);
            const hudOpacity = parseFloat(getComputedStyle(hud).opacity);
            const tickOpacity = parseFloat(getComputedStyle(ticker).opacity);

            // Intersection helper between two boxes A and B
            function intersects(a, b) {
              return !(a.right < b.left || a.left > b.right || a.bottom < b.top || a.top > b.bottom);
            }

            // Check if HUD overlaps Revealed text while both are visible
            const hudRevealedOverlap = (hudOpacity > 0.05 && revOpacity > 0.05 && intersects(hudR, revR));
            // Check if HUD overlaps Editorial text while both are visible
            const hudEditOverlap = (hudOpacity > 0.05 && editOpacity > 0.05 && intersects(hudR, editR));
            // Check if HUD overlaps Ticker while both are visible
            const hudTickerOverlap = (hudOpacity > 0.05 && tickOpacity > 0.05 && intersects(hudR, tickR));

            // Overlap width / clearance
            const revHudGap = hudR.left - revR.right;
            const tickerHudGap = tickR.top - hudR.bottom;

            results.push({
              pct: pct + '%',
              p: p.toFixed(2),
              y,
              revOpacity: revOpacity.toFixed(2),
              hudOpacity: hudOpacity.toFixed(2),
              tickOpacity: tickOpacity.toFixed(2),
              hudR: { left: Math.round(hudR.left), right: Math.round(hudR.right), top: Math.round(hudR.top), bottom: Math.round(hudR.bottom) },
              revR: { left: Math.round(revR.left), right: Math.round(revR.right), top: Math.round(revR.top), bottom: Math.round(revR.bottom) },
              hudRevealedOverlap,
              revHudGap: Math.round(revHudGap),
              tickerHudGap: Math.round(tickerHudGap)
            });
          }
          return JSON.stringify(results);
        })()
      `,
      awaitPromise: true,
      returnByValue: true
    });

    const data = JSON.parse(evalRes.result.result.value);
    for (const r of data) {
      const status = r.hudRevealedOverlap ? '🚨 OVERLAP!' : '✅ OK';
      console.log(`[${r.pct.padStart(4)}] p=${r.p} | RevOp=${r.revOpacity} HudOp=${r.hudOpacity} | RevRight=${r.revR.right} HudLeft=${r.hudR.left} | Gap=${r.revHudGap}px | ${status}`);
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function run() {
  await testCollisions(1920, 1080);
  await testCollisions(1440, 900);
  await testCollisions(1366, 768);
  await testCollisions(768, 1024);
  await testCollisions(390, 844);
  await testCollisions(360, 800);
}

run().catch(console.error);
