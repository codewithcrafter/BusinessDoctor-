const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

async function testPixel10() {
  const port = 9987;
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

    // Emulate Pixel 10: 412 x 924, dpr 2.625 or 2
    await send('Emulation.setDeviceMetricsOverride', {
      width: 412,
      height: 924,
      deviceScaleFactor: 2.625,
      mobile: true
    });

    await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
    await new Promise(r => setTimeout(r, 1200));

    // Inspect initial state, scroll page a bit (e.g. user scrolled 200px or 500px, then opened drawer!)
    // Wait, did user open drawer when page was scrolled or at top?
    // Let's test both! First at top, click hamburger:
    const evalResult1 = await send('Runtime.evaluate', {
      expression: `(() => {
        const toggle = document.getElementById('menuToggleBtn');
        toggle.click();
        const drawer = document.getElementById('mobileDrawer');
        const header = document.querySelector('.site-header');
        const rect = drawer.getBoundingClientRect();
        const headerRect = header.getBoundingClientRect();
        return {
          windowHeight: window.innerHeight,
          windowScrollY: window.scrollY,
          headerRect,
          drawerRect: {
            top: rect.top,
            bottom: rect.bottom,
            height: rect.height,
            width: rect.width
          },
          drawerScrollTop: drawer.scrollTop,
          drawerScrollHeight: drawer.scrollHeight
        };
      })()`,
      returnByValue: true
    });

    console.log('Opened at scrollY=0:', evalResult1.result.value);
    await new Promise(r => setTimeout(r, 300));
    let shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_open_at_top.png', Buffer.from(shot.result.data, 'base64'));

    // Now test: close, scroll down the homepage 400px, then open drawer!
    const evalResult2 = await send('Runtime.evaluate', {
      expression: `(() => {
        const toggle = document.getElementById('menuToggleBtn');
        toggle.click(); // close
        window.scrollTo(0, 400);
        // Dispatch scroll event
        window.dispatchEvent(new Event('scroll'));
      })()`
    });
    await new Promise(r => setTimeout(r, 300));

    const evalResult3 = await send('Runtime.evaluate', {
      expression: `(() => {
        const toggle = document.getElementById('menuToggleBtn');
        toggle.click(); // open while scrolled!
        const drawer = document.getElementById('mobileDrawer');
        const header = document.querySelector('.site-header');
        const rect = drawer.getBoundingClientRect();
        const headerRect = header.getBoundingClientRect();
        return {
          windowHeight: window.innerHeight,
          windowScrollY: window.scrollY,
          headerRect,
          drawerRect: {
            top: rect.top,
            bottom: rect.bottom,
            height: rect.height,
            width: rect.width
          },
          drawerScrollTop: drawer.scrollTop,
          drawerScrollHeight: drawer.scrollHeight
        };
      })()`,
      returnByValue: true
    });

    console.log('Opened at scrollY=400:', evalResult3.result.value);
    await new Promise(r => setTimeout(r, 300));
    shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_open_at_400.png', Buffer.from(shot.result.data, 'base64'));

    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

testPixel10();

