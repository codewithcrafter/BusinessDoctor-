const { spawn } = require('child_process');
const fs = require('fs');

async function debugPixel10() {
  const port = 9982;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1500));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const ws = new WebSocket(pages[0].webSocketDebuggerUrl);

    function send(method, params = {}) {
      return new Promise((resolve, reject) => {
        const id = Math.floor(Math.random() * 1000000);
        const timeout = setTimeout(() => {
          ws.removeEventListener('message', handler);
          reject(new Error(`Timeout on ${method}`));
        }, 5000);
        const handler = (evt) => {
          const data = JSON.parse(evt.data);
          if (data.id === id) {
            clearTimeout(timeout);
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

    // Emulate Pixel 10: 412 x 924
    await send('Emulation.setDeviceMetricsOverride', {
      width: 412,
      height: 924,
      deviceScaleFactor: 2.625,
      mobile: true
    });

    await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
    await new Promise(r => setTimeout(r, 1000));

    // First evaluate: open drawer
    const info = await send('Runtime.evaluate', {
      expression: `(() => {
        const toggle = document.getElementById('menuToggleBtn');
        toggle.click();

        const drawer = document.getElementById('mobileDrawer');
        const backdrop = document.getElementById('mobileDrawerBackdrop');
        const header = document.querySelector('.site-header');
        const content = document.querySelector('.mobile-drawer-content');
        const navList = document.querySelector('.mobile-nav-list');
        const cta = document.querySelector('.mobile-drawer-cta');

        const cs = window.getComputedStyle(drawer);
        const csHeader = window.getComputedStyle(header);

        return {
          windowInnerHeight: window.innerHeight,
          windowInnerWidth: window.innerWidth,
          devicePixelRatio: window.devicePixelRatio,
          header: {
            rect: header.getBoundingClientRect(),
            position: csHeader.position,
            backdropFilter: csHeader.backdropFilter,
            webkitBackdropFilter: csHeader.webkitBackdropFilter,
            transform: csHeader.transform,
            zIndex: csHeader.zIndex
          },
          drawer: {
            rect: drawer.getBoundingClientRect(),
            position: cs.position,
            top: cs.top,
            bottom: cs.bottom,
            height: cs.height,
            maxHeight: cs.maxHeight,
            zIndex: cs.zIndex,
            overflowY: cs.overflowY,
            scrollTop: drawer.scrollTop,
            scrollHeight: drawer.scrollHeight,
            clientHeight: drawer.clientHeight
          },
          backdrop: {
            rect: backdrop.getBoundingClientRect()
          },
          content: {
            rect: content.getBoundingClientRect(),
            scrollHeight: content.scrollHeight,
            clientHeight: content.clientHeight
          },
          navList: {
            rect: navList.getBoundingClientRect(),
            childCount: navList.children.length,
            firstChildRect: navList.firstElementChild.getBoundingClientRect(),
            lastChildRect: navList.lastElementChild.getBoundingClientRect()
          },
          cta: {
            rect: cta.getBoundingClientRect()
          }
        };
      })()`,
      returnByValue: true
    });

    console.log('DIAGNOSTIC RESULTS:', JSON.stringify(info.result.value, null, 2));

    await new Promise(r => setTimeout(r, 400));
    const shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_debug.png', Buffer.from(shot.result.data, 'base64'));
    console.log('Screenshot saved to scratch/pixel10_debug.png');

    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

debugPixel10();

