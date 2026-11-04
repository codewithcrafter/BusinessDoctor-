const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

async function testScroll() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9982;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1440,900',
    'http://127.0.0.1:8000/#capabilities'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1500));
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
    await new Promise(r => setTimeout(r, 400));

    // Scroll to #capabilities
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));

    // Click next arrow
    console.log('Clicking next arrow once:');
    await send('Runtime.evaluate', {
      expression: `document.getElementById('capNavNext').click();`
    });
    await new Promise(r => setTimeout(r, 700));

    let check1 = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const navR = navBar.getBoundingClientRect();
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn')).map((b, i) => {
            const r = b.getBoundingClientRect();
            return {
              i: i + 1,
              text: b.innerText.replace(/\\s+/g, ' ').trim(),
              left: Math.round(r.left),
              right: Math.round(r.right),
              width: Math.round(r.width),
              clippedRight: Math.round(r.right) > Math.round(navR.right),
              clippedLeft: Math.round(r.left) < Math.round(navR.left)
            };
          });
          return {
            scrollLeft: navBar.scrollLeft,
            maxScroll: navBar.scrollWidth - navBar.clientWidth,
            navBarR: Math.round(navR.right),
            navBarL: Math.round(navR.left),
            tabs: btns
          };
        })()
      `,
      returnByValue: true
    });
    console.log(JSON.stringify(check1.result.result.value, null, 2));

    const shot1 = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'tabs_scrolled_click1_1440.png'), Buffer.from(shot1.result.data, 'base64'));

    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill('SIGKILL');
  }
}
testScroll();

