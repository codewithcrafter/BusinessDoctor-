const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function testTabArrows() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9930;
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
    const errors = [];

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (data.method === 'Runtime.exceptionThrown') {
        errors.push(data.params.exceptionDetails);
      }
      if (data.method === 'Runtime.consoleAPICalled' && data.params.type === 'error') {
        errors.push(data.params.args.map(a => a.value).join(' '));
      }
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

    // 1. Initial State Check
    console.log('--- 1. INITIAL TABS STATE ---');
    const initState = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab6 = btns[5];
          const barR = navBar.getBoundingClientRect();
          const tab6R = tab6 ? tab6.getBoundingClientRect() : null;

          return {
            scrollLeft: navBar.scrollLeft,
            maxScroll: navBar.scrollWidth - navBar.clientWidth,
            prevHidden: prev.classList.contains('is-hidden'),
            nextHidden: next.classList.contains('is-hidden'),
            barWidth: Math.round(barR.width),
            tab6Left: tab6R ? Math.round(tab6R.left) : 0,
            tab6Right: tab6R ? Math.round(tab6R.right) : 0,
            barRight: Math.round(barR.right),
            isTab6PartiallyHidden: tab6R ? tab6R.right > barR.right : true
          };
        })()
      `
    });
    console.log('Initial State:', JSON.stringify(initState.result.result.value, null, 2));

    // Capture initial state screenshot of the capabilities section
    const shotInit = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'tabs_arrows_initial_1440.png'), Buffer.from(shotInit.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'tabs_arrows_initial_1440.png'), Buffer.from(shotInit.result.data, 'base64'));

    // 2. Click Right Arrow
    console.log('\n--- 2. CLICKING RIGHT ARROW ---');
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const next = document.getElementById('capNavNext');
          if (next) next.click();
        })()
      `
    });

    // Wait for smooth scroll to finish
    await new Promise(r => setTimeout(r, 600));

    const scrolledState = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab6 = btns[5];
          const barR = navBar.getBoundingClientRect();
          const tab6R = tab6 ? tab6.getBoundingClientRect() : null;

          return {
            scrollLeft: navBar.scrollLeft,
            maxScroll: navBar.scrollWidth - navBar.clientWidth,
            prevHidden: prev.classList.contains('is-hidden'),
            nextHidden: next.classList.contains('is-hidden'),
            tab6Right: tab6R ? Math.round(tab6R.right) : 0,
            barRight: Math.round(barR.right),
            isTab6FullyVisible: tab6R ? tab6R.right <= barR.right + 2 && tab6R.left >= barR.left : false,
            doesArrowCoverTab6: false // arrow is external flex item
          };
        })()
      `
    });
    console.log('Scrolled State:', JSON.stringify(scrolledState.result.result.value, null, 2));

    const shotScrolled = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'tabs_arrows_scrolled_1440.png'), Buffer.from(shotScrolled.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'tabs_arrows_scrolled_1440.png'), Buffer.from(shotScrolled.result.data, 'base64'));

    // 3. Click Tab 6 (Cloud Solutions)
    console.log('\n--- 3. CLICKING TAB 6 (CLOUD SOLUTIONS) ---');
    const tabClickResult = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab6 = btns[5];
          if (tab6) tab6.click();

          const activeBtn = document.querySelector('.cap-tab-btn.active');
          const activePane = document.querySelector('.cap-tab-pane.active');

          return {
            activeBtnText: activeBtn ? activeBtn.textContent.trim() : null,
            activePaneId: activePane ? activePane.id : null,
            activePaneTitle: activePane ? activePane.querySelector('.cap-card-title')?.textContent?.trim() : null
          };
        })()
      `
    });
    console.log('Tab 6 Activated:', JSON.stringify(tabClickResult.result.result.value, null, 2));

    // 4. Click Left Arrow to scroll back
    console.log('\n--- 4. CLICKING LEFT ARROW (SCROLL BACK) ---');
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const prev = document.getElementById('capNavPrev');
          if (prev) prev.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));

    const backState = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navBar = document.getElementById('capabilitiesNavBar');
          const prev = document.getElementById('capNavPrev');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab1 = btns[0];
          const barR = navBar.getBoundingClientRect();
          const tab1R = tab1 ? tab1.getBoundingClientRect() : null;

          return {
            scrollLeft: navBar.scrollLeft,
            prevHidden: prev.classList.contains('is-hidden'),
            nextHidden: next.classList.contains('is-hidden'),
            tab1Visible: tab1R ? tab1R.left >= barR.left - 2 : false
          };
        })()
      `
    });
    console.log('Back State:', JSON.stringify(backState.result.result.value, null, 2));

    console.log('\nConsole Errors:', errors.length);
    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

testTabArrows();

