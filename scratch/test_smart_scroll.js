const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function testSmartScroll() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9940;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1440,900',
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
    await new Promise(r => setTimeout(r, 500));

    // Scroll to #capabilities
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 400));

    // Inspect tabs with smart scroll function
    const evalRes = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const barR = navBar.getBoundingClientRect();
          const tab6 = btns[5];
          const tab6R = tab6.getBoundingClientRect();

          // Scroll to cutoff tab
          const delta = tab6R.right - barR.right + 30;
          navBar.scrollBy({ left: delta, behavior: 'instant' });

          const afterR = tab6.getBoundingClientRect();
          const next = document.getElementById('capNavNext');
          const prev = document.getElementById('capNavPrev');

          return {
            deltaNeeded: delta,
            tab6Before: { left: Math.round(tab6R.left), right: Math.round(tab6R.right) },
            barRect: { left: Math.round(barR.left), right: Math.round(barR.right), width: Math.round(barR.width) },
            tab6After: { left: Math.round(afterR.left), right: Math.round(afterR.right) },
            isTab6FullyInside: afterR.right <= barR.right && afterR.left >= barR.left
          };
        })()
      `
    });

    console.log('Smart Scroll Test Result:', JSON.stringify(evalRes.result.result.value, null, 2));

    const shot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'tabs_smart_scroll_1440.png'), Buffer.from(shot.result.data, 'base64'));

    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

testSmartScroll();

