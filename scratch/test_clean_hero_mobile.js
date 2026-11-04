const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\scratch';

async function testCleanHeroMobile() {
  const port = 9973;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

  await new Promise(r => setTimeout(r, 1500));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pagesList = await res.json();
  const page = pagesList.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pagesList[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  function send(method, params = {}) {
    return new Promise(resolve => {
      const id = Math.floor(Math.random() * 1000000);
      const handler = (evt) => {
        const data = JSON.parse(evt.data);
        if (data.id === id) {
          ws.removeEventListener('message', handler);
          resolve(data);
        }
      };
      ws.addEventListener('message', handler);
      ws.send(JSON.stringify({ id, method, params }));
    });
  }

  await new Promise(r => ws.onopen = r);
  await send('Network.enable');
  await send('Page.enable');
  await send('Runtime.enable');

  await send('Emulation.setDeviceMetricsOverride', {
    width: 390,
    height: 844,
    deviceScaleFactor: 2,
    mobile: true
  });

  await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
  await new Promise(r => setTimeout(r, 1000));

  // Inject CSS
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const style = document.createElement('style');
        style.textContent = \`
          @media (max-width: 768px) {
            .menu-toggle {
              color: #F4F8FC !important;
            }
            .menu-toggle:hover {
              color: #00C9C1 !important;
            }
            .hero-scroll-track {
              height: auto !important;
              padding: 0 !important;
            }
            .hero-sticky-stage {
              position: relative !important;
              height: auto !important;
              min-height: auto !important;
              max-height: none !important;
              overflow: visible !important;
              padding: calc(var(--header-height, 72px) + 1.25rem) 0 3rem !important;
            }
            .hero-stage-inner {
              padding: 0 !important;
            }
            .hero-anim-viewport {
              min-height: auto !important;
              display: flex !important;
              flex-direction: column !important;
              gap: 2rem !important;
            }
            .hero-text-zone {
              position: relative !important;
              height: auto !important;
            }
            .hero-editorial-layer {
              position: relative !important;
              opacity: 1 !important;
              transform: none !important;
              pointer-events: auto !important;
            }
            .hero-visual-layer {
              position: relative !important;
              opacity: 1 !important;
              transform: none !important;
              pointer-events: auto !important;
              margin-top: 1rem !important;
            }
            .enterprise-hud-card {
              transform: none !important;
              max-width: 100% !important;
            }
            .hero-scroll-indicator {
              display: none !important;
            }
            .kpi-strip-section {
              margin-top: 0 !important;
              padding-top: 1rem !important;
            }
          }
        \`;
        document.head.appendChild(style);
      })()
    `
  });

  await new Promise(r => setTimeout(r, 400));
  const shot1 = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, 'clean_hero_mobile_top.png'), Buffer.from(shot1.result.data, 'base64'));

  // Scroll down slightly to see HUD and vital ticker
  await send('Runtime.evaluate', { expression: 'window.scrollTo(0, 450);' });
  await new Promise(r => setTimeout(r, 400));
  const shot2 = await send('Page.captureScreenshot', { format: 'png' });
  fs.writeFileSync(path.join(outDir, 'clean_hero_mobile_hud.png'), Buffer.from(shot2.result.data, 'base64'));

  console.log('Saved clean_hero_mobile_top.png and clean_hero_mobile_hud.png');
  chrome.kill();
}

testCleanHeroMobile().catch(console.error);

