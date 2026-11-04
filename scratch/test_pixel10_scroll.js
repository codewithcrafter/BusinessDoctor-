const { spawn } = require('child_process');
const fs = require('fs');

async function testPixel10Fixed() {
  const port = 9919;
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

    await send('Emulation.setDeviceMetricsOverride', {
      width: 412,
      height: 924,
      deviceScaleFactor: 2.625,
      mobile: true
    });

    await new Promise(r => setTimeout(r, 800));

    // TEST 1: Open at top (scrollY = 0)
    console.log('=== TEST 1: OPEN DRAWER AT TOP (scrollY = 0) ===');
    const openTopRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const btn = document.getElementById('menuToggleBtn');
        btn.click();
        const d = document.getElementById('mobileDrawer');
        const b = document.getElementById('mobileDrawerBackdrop');
        const sb = document.getElementById('mobileDrawerScrollBody');
        const dr = d.getBoundingClientRect();
        const br = b.getBoundingClientRect();
        const navList = document.querySelector('.mobile-nav-list');
        const cta = document.querySelector('.mobile-drawer-cta');

        return {
          windowHeight: window.innerHeight,
          windowScrollY: window.scrollY,
          backdrop: { top: Math.round(br.top), bottom: Math.round(br.bottom), height: Math.round(br.height) },
          drawer: {
            top: Math.round(dr.top),
            bottom: Math.round(dr.bottom),
            height: Math.round(dr.height),
            width: Math.round(dr.width),
            scrollTop: d.scrollTop,
            scrollBodyScrollTop: sb.scrollTop,
            scrollBodyScrollHeight: sb.scrollHeight,
            scrollBodyClientHeight: sb.clientHeight
          },
          firstLink: navList && navList.firstElementChild ? {
            text: navList.firstElementChild.innerText.trim(),
            top: Math.round(navList.firstElementChild.getBoundingClientRect().top)
          } : null,
          lastLink: navList && navList.lastElementChild ? {
            text: navList.lastElementChild.innerText.trim(),
            top: Math.round(navList.lastElementChild.getBoundingClientRect().top)
          } : null,
          cta: cta ? {
            top: Math.round(cta.getBoundingClientRect().top),
            bottom: Math.round(cta.getBoundingClientRect().bottom)
          } : null
        };
      })()`,
      returnByValue: true
    });
    console.log('TEST 1 METRICS:', JSON.stringify(openTopRes.result.value, null, 2));

    await new Promise(r => setTimeout(r, 400));
    let shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_fixed_open_at_top.png', Buffer.from(shot.data, 'base64'));
    console.log('Saved scratch/pixel10_fixed_open_at_top.png');

    // Close drawer
    await send('Runtime.evaluate', {
      expression: `document.getElementById('mobileDrawerCloseBtn').click();`
    });
    await new Promise(r => setTimeout(r, 400));

    // Scroll page down 500px
    console.log('\n=== TEST 2: SCROLL PAGE 500px & OPEN DRAWER ===');
    await send('Runtime.evaluate', {
      expression: `window.scrollTo(0, 500);`
    });
    await new Promise(r => setTimeout(r, 300));

    // Open drawer while page is scrolled down
    const openScrolledRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const btn = document.getElementById('menuToggleBtn');
        btn.click();
        const d = document.getElementById('mobileDrawer');
        const b = document.getElementById('mobileDrawerBackdrop');
        const sb = document.getElementById('mobileDrawerScrollBody');
        const dr = d.getBoundingClientRect();
        const br = b.getBoundingClientRect();
        const navList = document.querySelector('.mobile-nav-list');
        const cta = document.querySelector('.mobile-drawer-cta');

        return {
          windowHeight: window.innerHeight,
          windowScrollY: window.scrollY,
          backdrop: { top: Math.round(br.top), bottom: Math.round(br.bottom), height: Math.round(br.height) },
          drawer: {
            top: Math.round(dr.top),
            bottom: Math.round(dr.bottom),
            height: Math.round(dr.height),
            width: Math.round(dr.width),
            scrollBodyScrollTop: sb.scrollTop,
            scrollBodyScrollHeight: sb.scrollHeight,
            scrollBodyClientHeight: sb.clientHeight
          },
          firstLink: navList && navList.firstElementChild ? {
            text: navList.firstElementChild.innerText.trim(),
            top: Math.round(navList.firstElementChild.getBoundingClientRect().top)
          } : null,
          lastLink: navList && navList.lastElementChild ? {
            text: navList.lastElementChild.innerText.trim(),
            top: Math.round(navList.lastElementChild.getBoundingClientRect().top)
          } : null,
          cta: cta ? {
            top: Math.round(cta.getBoundingClientRect().top),
            bottom: Math.round(cta.getBoundingClientRect().bottom)
          } : null
        };
      })()`,
      returnByValue: true
    });
    console.log('TEST 2 METRICS:', JSON.stringify(openScrolledRes.result.value, null, 2));

    await new Promise(r => setTimeout(r, 400));
    shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_fixed_open_after_scroll.png', Buffer.from(shot.data, 'base64'));
    console.log('Saved scratch/pixel10_fixed_open_after_scroll.png');

    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

testPixel10Fixed();
