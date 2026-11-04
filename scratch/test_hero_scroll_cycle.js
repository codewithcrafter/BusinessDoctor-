const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function runScrollCycleTest() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9460;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];

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
    await new Promise(r => setTimeout(r, 600));

    // Get track total scroll height
    const trackInfo = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const track = document.getElementById('heroScrollTrack');
          const rect = track.getBoundingClientRect();
          const totalScroll = rect.height - window.innerHeight;
          const nav = document.querySelector('.site-header');
          return {
            trackHeight: rect.height,
            windowHeight: window.innerHeight,
            totalScroll: totalScroll,
            navHeight: nav.offsetHeight
          };
        })()
      `
    });

    const info = trackInfo.result.result.value;
    console.log('Track Info:', info);

    const checkpoints = [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0];
    const forwardResults = [];

    // Helper to evaluate metrics at current scroll
    async function evaluateMetrics(pLabel) {
      return await send('Runtime.evaluate', {
        returnByValue: true,
        expression: `
          (() => {
            const nav = document.querySelector('.site-header');
            const h1 = document.querySelector('.hero-headline-oversized');
            const h2 = document.querySelector('.revealed-headline');
            const ed = document.querySelector('#heroEditorialLayer');
            const rev = document.querySelector('#heroRevealedLayer');
            const hud = document.querySelector('#heroVisualLayer');
            const dock = document.querySelector('.hero-vital-dock');

            function r(el) {
              if (!el) return null;
              const b = el.getBoundingClientRect();
              return { top: b.top, bottom: b.bottom, left: b.left, right: b.right, width: b.width, height: b.height };
            }

            const navR = r(nav);
            const h1R = r(h1);
            const h2R = r(h2);
            const hudR = r(hud);
            const edStyle = ed ? getComputedStyle(ed) : null;
            const revStyle = rev ? getComputedStyle(rev) : null;

            const edOpacity = edStyle ? parseFloat(edStyle.opacity) : 0;
            const revOpacity = revStyle ? parseFloat(revStyle.opacity) : 0;

            // Heading clearance from navbar
            let topClearanceA = h1R && navR ? h1R.top - navR.bottom : 999;
            let topClearanceB = h2R && navR ? h2R.top - navR.bottom : 999;

            // Horizontal clearance from HUD
            let xClearanceA = hudR && h1R ? hudR.left - h1R.right : 999;
            let xClearanceB = hudR && h2R ? hudR.left - h2R.right : 999;

            return {
              scrollY: window.scrollY,
              edOpacity: edOpacity,
              revOpacity: revOpacity,
              topClearanceA: Math.round(topClearanceA),
              topClearanceB: Math.round(topClearanceB),
              xClearanceA: Math.round(xClearanceA),
              xClearanceB: Math.round(xClearanceB),
              h1Color: h1 ? getComputedStyle(h1).color : null,
              h2Color: h2 ? getComputedStyle(h2).color : null
            };
          })()
        `
      });
    }

    // Helper to take screenshot
    async function captureScreen(filename) {
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      fs.writeFileSync(path.join(ARTIFACT_DIR, filename), buf);
      fs.writeFileSync(path.join(SCRATCH_DIR, filename), buf);
    }

    console.log('\n--- FORWARD SCROLL PASS ---');
    for (const cp of checkpoints) {
      const scrollY = Math.round(cp * info.totalScroll);
      await send('Runtime.evaluate', {
        expression: `window.scrollTo({ top: ${scrollY}, behavior: 'instant' });`
      });
      await new Promise(r => setTimeout(r, 150));

      const evalRes = await evaluateMetrics(`Forward ${Math.round(cp * 100)}%`);
      const metrics = evalRes.result.result.value;
      metrics.checkpoint = `${Math.round(cp * 100)}%`;
      forwardResults.push(metrics);
      console.log(`Forward ${metrics.checkpoint}:`, metrics);

      await captureScreen(`hero_scroll_fwd_${Math.round(cp * 100)}.png`);
    }

    console.log('\n--- REVERSE SCROLL PASS ---');
    const reverseCheckpoints = [0.9, 0.7, 0.5, 0.3, 0.1, 0.0];
    const reverseResults = [];
    for (const cp of reverseCheckpoints) {
      const scrollY = Math.round(cp * info.totalScroll);
      await send('Runtime.evaluate', {
        expression: `window.scrollTo({ top: ${scrollY}, behavior: 'instant' });`
      });
      await new Promise(r => setTimeout(r, 150));

      const evalRes = await evaluateMetrics(`Reverse ${Math.round(cp * 100)}%`);
      const metrics = evalRes.result.result.value;
      metrics.checkpoint = `Rev_${Math.round(cp * 100)}%`;
      reverseResults.push(metrics);
      console.log(`Reverse ${metrics.checkpoint}:`, metrics);

      await captureScreen(`hero_scroll_rev_${Math.round(cp * 100)}.png`);
    }

    // Boundary check: scroll to 1.1 (into #missionVision)
    console.log('\n--- BOUNDARY CHECK (#missionVision) ---');
    const mvScrollY = Math.round(info.totalScroll + 200);
    await send('Runtime.evaluate', {
      expression: `window.scrollTo({ top: ${mvScrollY}, behavior: 'instant' });`
    });
    await new Promise(r => setTimeout(r, 200));
    await captureScreen('hero_scroll_boundary_mv.png');

    console.log('\n--- MULTI-VIEWPORT VERIFICATION ---');
    ws.close();
  } catch (err) {
    console.error('Test error:', err);
  } finally {
    chrome.kill();
  }
}

runScrollCycleTest();

