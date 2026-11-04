const { spawn } = require('child_process');
const fs = require('fs');

async function check() {
  const port = 9951;
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

    let msgId = 1;
    function send(method, params = {}) {
      return new Promise((resolve, reject) => {
        const id = msgId++;
        const to = setTimeout(() => {
          reject(new Error(`Timeout on ${method}`));
        }, 10000);
        const onMsg = (evt) => {
          const data = JSON.parse(evt.data);
          if (data.id === id) {
            clearTimeout(to);
            ws.removeEventListener('message', onMsg);
            resolve(data.result);
          }
        };
        ws.addEventListener('message', onMsg);
        ws.send(JSON.stringify({ id, method, params }));
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

    await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
    
    // Proper readyState wait
    for (let i = 0; i < 40; i++) {
      await new Promise(r => setTimeout(r, 100));
      const r = await send('Runtime.evaluate', { expression: 'document.readyState' });
      if (r && r.result && r.result.value === 'complete') {
        break;
      }
    }
    await new Promise(r => setTimeout(r, 500));

    // Click menu toggle
    const evalData = await send('Runtime.evaluate', {
      expression: `(() => {
        const btn = document.getElementById('menuToggleBtn');
        if (!btn) return { error: 'No menuToggleBtn found!' };
        btn.click();
        const d = document.getElementById('mobileDrawer');
        if (!d) return { error: 'No mobileDrawer found!' };
        const h = document.querySelector('.site-header');
        const b = document.getElementById('mobileDrawerBackdrop');
        const navList = document.querySelector('.mobile-nav-list');
        const cta = document.querySelector('.mobile-drawer-cta');

        const dr = d.getBoundingClientRect();
        const hr = h.getBoundingClientRect();
        const csD = window.getComputedStyle(d);
        const csH = window.getComputedStyle(h);

        return {
          window: { innerWidth: window.innerWidth, innerHeight: window.innerHeight, scrollY: window.scrollY },
          header: { top: hr.top, bottom: hr.bottom, height: hr.height, backdropFilter: csH.backdropFilter },
          drawer: {
            top: dr.top, bottom: dr.bottom, height: dr.height, width: dr.width,
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

    console.log('EVAL DATA:', JSON.stringify(evalData.result.value, null, 2));

    await new Promise(r => setTimeout(r, 500));
    const shotRes = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync('scratch/pixel10_reproduced.png', Buffer.from(shotRes.data, 'base64'));
    console.log('Saved scratch/pixel10_reproduced.png');

    ws.close();
  } catch (err) {
    console.error('SCRIPT ERROR:', err);
  } finally {
    chrome.kill();
  }
}

check();
