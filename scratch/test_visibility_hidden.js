const { spawn } = require('child_process');

async function testVisibilityHidden() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9980;
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

          // Override .is-hidden to visibility: hidden
          const style = document.createElement('style');
          style.innerHTML = '.cap-nav-arrow.is-hidden { visibility: hidden !important; opacity: 0 !important; pointer-events: none !important; }';
          document.head.appendChild(style);
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));

    // Initial check
    const initRes = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab6 = btns[5];
          const barR = navBar.getBoundingClientRect();
          const tab6R = tab6.getBoundingClientRect();

          return {
            barWidth: Math.round(barR.width),
            scrollLeft: navBar.scrollLeft,
            maxScroll: navBar.scrollWidth - navBar.clientWidth,
            tab6Before: { left: Math.round(tab6R.left), right: Math.round(tab6R.right) },
            prevVisibility: getComputedStyle(prev).visibility,
            nextVisibility: getComputedStyle(next).visibility
          };
        })()
      `
    });
    console.log('1. Initial (with visibility:hidden):', JSON.stringify(initRes.result.result.value, null, 2));

    // Click Next
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const next = document.getElementById('capNavNext');
          if (next) next.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));

    // Scrolled check
    const scrollRes = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab6 = btns[5];
          const barR = navBar.getBoundingClientRect();
          const tab6R = tab6.getBoundingClientRect();

          return {
            barWidth: Math.round(barR.width),
            scrollLeft: navBar.scrollLeft,
            maxScroll: navBar.scrollWidth - navBar.clientWidth,
            tab6R: { left: Math.round(tab6R.left), right: Math.round(tab6R.right) },
            barR: { left: Math.round(barR.left), right: Math.round(barR.right) },
            isTab6FullyVisible: tab6R.right <= barR.right + 2 && tab6R.left >= barR.left,
            prevVisibility: getComputedStyle(prev).visibility,
            nextVisibility: getComputedStyle(next).visibility
          };
        })()
      `
    });
    console.log('2. Scrolled (with visibility:hidden):', JSON.stringify(scrollRes.result.result.value, null, 2));

    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

testVisibilityHidden();

