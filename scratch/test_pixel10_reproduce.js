const { spawn } = require('child_process');
const fs = require('fs');

async function testPixel10() {
  const port = 9931;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/index.php'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const targetPage = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
    const ws = new WebSocket(targetPage.webSocketDebuggerUrl);

    let id = 1;
    function send(method, params = {}) {
      return new Promise(resolve => {
        const curId = id++;
        const onMsg = evt => {
          const d = JSON.parse(evt.data);
          if (d.id === curId) {
            ws.removeEventListener('message', onMsg);
            resolve(d.result);
          }
        };
        ws.addEventListener('message', onMsg);
        ws.send(JSON.stringify({ id: curId, method, params }));
      });
    }

    await new Promise(r => ws.onopen = r);
    await send('Network.enable');
    await send('Page.enable');
    await send('Runtime.enable');

    // Emulate Pixel 10: 412 × 924
    await send('Emulation.setDeviceMetricsOverride', {
      width: 412,
      height: 924,
      deviceScaleFactor: 2.625,
      mobile: true
    });

    await new Promise(r => setTimeout(r, 800));

    // Open drawer
    const openRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const btn = document.getElementById('menuToggleBtn');
        btn.click();
        const d = document.getElementById('mobileDrawer');
        const h = document.querySelector('.site-header');
        const dr = d.getBoundingClientRect();
        const hr = h.getBoundingClientRect();
        const csD = window.getComputedStyle(d);
        const csH = window.getComputedStyle(h);
        const navList = document.querySelector('.mobile-nav-list');
        const cta = document.querySelector('.mobile-drawer-cta');

        return {
          window: { innerWidth: window.innerWidth, innerHeight: window.innerHeight, scrollY: window.scrollY },
          header: { rect: hr, backdropFilter: csH.backdropFilter, height: csH.height },
          drawer: {
            rect: dr,
            computedHeight: csD.height,
            computedTop: csD.top,
            computedPosition: csD.position,
            computedBg: csD.backgroundColor,
            scrollTop: d.scrollTop,
            scrollHeight: d.scrollHeight,
            clientHeight: d.clientHeight
          },
          links: Array.from(navList ? navList.querySelectorAll('a') : []).map(a => ({
            text: a.innerText.trim(),
            top: Math.round(a.getBoundingClientRect().top),
            bottom: Math.round(a.getBoundingClientRect().bottom)
          })),
          cta: cta ? { top: Math.round(cta.getBoundingClientRect().top), bottom: Math.round(cta.getBoundingClientRect().bottom) } : null
        };
      })()`,
      returnByValue: true
    });

    console.log('PIXEL 10 OPEN METRICS:', JSON.stringify(openRes.result.value, null, 2));

    await new Promise(r => setTimeout(r, 500));
    const shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_reproduced.png', Buffer.from(shot.data, 'base64'));
    console.log('Saved scratch/pixel10_reproduced.png');

    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

testPixel10();
