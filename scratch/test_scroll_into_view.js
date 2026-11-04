const { spawn } = require('child_process');

async function testScrollIntoView() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9970;
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
    await new Promise(r => setTimeout(r, 300));

    const testRes = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const barR = navBar.getBoundingClientRect();
          const cutoffTab = btns.find(b => b.getBoundingClientRect().right > barR.right + 2);

          // Scroll into view inline end
          if (cutoffTab) {
            cutoffTab.scrollIntoView({ behavior: 'instant', block: 'nearest', inline: 'end' });
          }

          const tab6 = btns[5];
          const tab6R = tab6.getBoundingClientRect();
          const newBarR = navBar.getBoundingClientRect();

          return {
            scrollLeft: navBar.scrollLeft,
            maxScroll: navBar.scrollWidth - navBar.clientWidth,
            tab6R: { left: Math.round(tab6R.left), right: Math.round(tab6R.right) },
            newBarR: { left: Math.round(newBarR.left), right: Math.round(newBarR.right), width: Math.round(newBarR.width) },
            isTab6FullyInside: tab6R.right <= newBarR.right + 2 && tab6R.left >= newBarR.left
          };
        })()
      `
    });

    console.log('ScrollIntoView test:', JSON.stringify(testRes.result.result.value, null, 2));
    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

testScrollIntoView();

