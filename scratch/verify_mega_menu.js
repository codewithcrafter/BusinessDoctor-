const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = path.join(__dirname);

async function runSession(width, height, fn) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9500 + Math.floor(Math.random() * 40);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${width},${height}`,
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
    const consoleLogs = [];

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (data.method === 'Runtime.consoleAPICalled') {
        const text = data.params.args.map(a => a.value || a.description || '').join(' ');
        consoleLogs.push({ type: data.params.type, text });
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
    await send('Emulation.setDeviceMetricsOverride', {
      width,
      height,
      deviceScaleFactor: 1,
      mobile: width < 768
    });

    await new Promise(r => setTimeout(r, 800));

    async function evaluate(exp) {
      const res = await send('Runtime.evaluate', {
        expression: exp,
        returnByValue: true
      });
      return res.result && res.result.result ? res.result.result.value : null;
    }

    async function capture(filename) {
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      fs.writeFileSync(path.join(ARTIFACT_DIR, filename), buf);
      fs.writeFileSync(path.join(SCRATCH_DIR, filename), buf);
      console.log(`[Captured] ${filename}`);
    }

    async function mouseMove(x, y) {
      await send('Input.dispatchMouseEvent', { type: 'mouseMoved', x, y });
    }

    async function mouseClick(x, y) {
      await send('Input.dispatchMouseEvent', { type: 'mousePressed', x, y, button: 'left', clickCount: 1 });
      await send('Input.dispatchMouseEvent', { type: 'mouseReleased', x, y, button: 'left', clickCount: 1 });
    }

    await fn({ send, evaluate, capture, mouseMove, mouseClick, consoleLogs });

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function verifyMegaMenu() {
  console.log('=== Step 1: Desktop Hover & Interaction Scenarios (1440x900) ===');
  await runSession(1440, 900, async ({ send, evaluate, capture, mouseMove, mouseClick, consoleLogs }) => {
    // 1. Get coordinates of trigger and menu
    const coords = await evaluate(`
      (() => {
        const trigger = document.querySelector('.has-mega-menu .nav-link-dropdown');
        const menu = document.querySelector('.mega-menu');
        const triggerRect = trigger.getBoundingClientRect();
        const menuRect = menu.getBoundingClientRect();
        return {
          trigger: { x: triggerRect.left + triggerRect.width / 2, y: triggerRect.top + triggerRect.height / 2 },
          triggerBottom: triggerRect.bottom,
          menuTop: menuRect.top,
          menuCenter: { x: menuRect.left + menuRect.width / 2, y: menuRect.top + menuRect.height / 2 }
        };
      })()
    `);
    console.log('Coordinates:', coords);

    // Initial state: menu closed
    let isOpen = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('Initial is-open:', isOpen);

    // Scenario 1: Hover over IT Services trigger
    console.log('--- Testing Scenario 1: Hover over IT Services ---');
    await mouseMove(coords.trigger.x, coords.trigger.y);
    await new Promise(r => setTimeout(r, 200));

    let menuState1 = await evaluate(`
      (() => {
        const item = document.querySelector('.has-mega-menu');
        const menu = document.querySelector('.mega-menu');
        const style = window.getComputedStyle(menu);
        return {
          isOpen: item.classList.contains('is-open'),
          opacity: style.opacity,
          visibility: style.visibility,
          pointerEvents: style.pointerEvents,
          ariaExpanded: item.querySelector('.nav-link-dropdown')?.getAttribute('aria-expanded')
        };
      })()
    `);
    console.log('Scenario 1 State (hover trigger):', menuState1);
    await capture('megamenu_01_trigger_hover.png');

    // Scenario 2: Move cursor slowly from trigger down across the gap into menu
    console.log('--- Testing Scenario 2: Move cursor slowly across gap into menu ---');
    const startY = coords.trigger.y;
    const endY = coords.menuTop + 40;
    const steps = 10;
    for (let i = 1; i <= steps; i++) {
      const curY = startY + (endY - startY) * (i / steps);
      await mouseMove(coords.trigger.x, curY);
      await new Promise(r => setTimeout(r, 40)); // 40ms * 10 = 400ms slow traversal
    }
    await new Promise(r => setTimeout(r, 100));

    let menuState2 = await evaluate(`
      (() => {
        const item = document.querySelector('.has-mega-menu');
        const menu = document.querySelector('.mega-menu');
        const style = window.getComputedStyle(menu);
        return {
          isOpen: item.classList.contains('is-open'),
          opacity: style.opacity,
          visibility: style.visibility,
          pointerEvents: style.pointerEvents
        };
      })()
    `);
    console.log('Scenario 2 State (slowly moving into menu):', menuState2);
    await capture('megamenu_02_inside_menu.png');

    // Scenario 3: Move cursor across all six service links
    console.log('--- Testing Scenario 3: Hover across all 6 service items ---');
    const serviceItems = await evaluate(`
      (() => {
        const items = document.querySelectorAll('.mega-service-item');
        return Array.from(items).map(item => {
          const r = item.getBoundingClientRect();
          return {
            title: item.querySelector('.mega-item-title')?.textContent?.trim(),
            x: r.left + r.width / 2,
            y: r.top + r.height / 2
          };
        });
      })()
    `);

    let allHoveredSuccessfully = true;
    for (const item of serviceItems) {
      await mouseMove(item.x, item.y);
      await new Promise(r => setTimeout(r, 120));
      const stillOpen = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
      if (!stillOpen) {
        allHoveredSuccessfully = false;
        console.log(`FAILED on service item: ${item.title}`);
      }
    }
    console.log(`Scenario 3: Hovered all ${serviceItems.length} service links successfully:`, allHoveredSuccessfully);
    await capture('megamenu_03_services_hover.png');

    // Scenario 4: Move cursor to Digital Assessment highlight card
    console.log('--- Testing Scenario 4: Move to Digital Assessment panel ---');
    const auditCardCoord = await evaluate(`
      (() => {
        const card = document.querySelector('.mega-highlight-card');
        const r = card.getBoundingClientRect();
        return { x: r.left + r.width / 2, y: r.top + r.height / 2 };
      })()
    `);
    await mouseMove(auditCardCoord.x, auditCardCoord.y);
    await new Promise(r => setTimeout(r, 200));

    const cardState = await evaluate(`
      (() => {
        const item = document.querySelector('.has-mega-menu');
        const menu = document.querySelector('.mega-menu');
        return {
          isOpen: item.classList.contains('is-open'),
          visibility: window.getComputedStyle(menu).visibility
        };
      })()
    `);
    console.log('Scenario 4 State (highlight card):', cardState);
    await capture('megamenu_04_highlight_card.png');

    // Scenario 5: Move cursor outside entire menu
    console.log('--- Testing Scenario 5: Move cursor outside entire menu ---');
    await mouseMove(50, 800); // Way off down in page body, outside the 1200px menu
    // Before delay expires (at 100ms): should still be open due to 300ms delay
    await new Promise(r => setTimeout(r, 100));
    const stillOpenAt100ms = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('At 100ms (within 300ms grace period) is-open:', stillOpenAt100ms);

    // After delay expires (at 450ms): should now be closed
    await new Promise(r => setTimeout(r, 350));
    const closedAfterDelay = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('At 450ms (after delay) is-open:', closedAfterDelay);
    await capture('megamenu_05_closed_outside.png');

    // Scenario 6: Rapid flickers between trigger and menu
    console.log('--- Testing Scenario 6: Rapid flickers between trigger and panel ---');
    for (let f = 0; f < 5; f++) {
      await mouseMove(coords.trigger.x, coords.trigger.y);
      await new Promise(r => setTimeout(r, 30));
      await mouseMove(coords.trigger.x, coords.menuTop + 30);
      await new Promise(r => setTimeout(r, 30));
    }
    await new Promise(r => setTimeout(r, 100));
    const flickerState = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('Scenario 6 State after rapid flickers (should remain open):', flickerState);

    // Scenario 7: Keyboard navigation & Escape
    console.log('--- Testing Scenario 7: Keyboard navigation & Escape ---');
    // Dispatch Enter on trigger
    await evaluate(`
      (() => {
        const trigger = document.querySelector('.has-mega-menu .nav-link-dropdown');
        trigger.focus();
        trigger.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter', bubbles: true }));
      })()
    `);
    await new Promise(r => setTimeout(r, 150));

    const kbOpen = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('Keyboard opened via Enter:', kbOpen);

    // Dispatch Escape to close
    await evaluate(`
      (() => {
        document.dispatchEvent(new KeyboardEvent('keydown', { key: 'Escape', bubbles: true }));
      })()
    `);
    await new Promise(r => setTimeout(r, 150));

    const kbClosed = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('Keyboard closed via Escape:', !kbClosed);

    // Scenario 8: Click/Tap toggle
    console.log('--- Testing Scenario 8: Click/Tap toggle ---');
    await mouseClick(coords.trigger.x, coords.trigger.y);
    await new Promise(r => setTimeout(r, 200));
    const clickOpened = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('Click opened:', clickOpened);

    // Click again to toggle close
    await mouseClick(coords.trigger.x, coords.trigger.y);
    await new Promise(r => setTimeout(r, 200));
    const clickClosed = await evaluate(`document.querySelector('.has-mega-menu').classList.contains('is-open')`);
    console.log('Click closed:', !clickClosed);

    console.log('Desktop console errors:', consoleLogs.filter(l => l.type === 'error'));
  });

  console.log('=== Step 2: Multi-Viewport Overflow & Console Checks ===');
  const viewports = [
    { w: 1920, h: 1080 },
    { w: 1440, h: 900 },
    { w: 1366, h: 768 },
    { w: 1024, h: 768 },
    { w: 768, h: 1024 },
    { w: 390, h: 844 },
    { w: 360, h: 800 }
  ];

  for (const vp of viewports) {
    await runSession(vp.w, vp.h, async ({ evaluate, consoleLogs }) => {
      const check = await evaluate(`
        (() => {
          return {
            scrollWidth: document.documentElement.scrollWidth,
            innerWidth: window.innerWidth,
            hasOverflow: document.documentElement.scrollWidth > window.innerWidth
          };
        })()
      `);
      const errors = consoleLogs.filter(l => l.type === 'error');
      console.log(`Viewport ${vp.w}x${vp.h}:`, check, `Errors: ${errors.length}`);
    });
  }

  console.log('All mega menu verifications finished!');
}

verifyMegaMenu().catch(err => {
  console.error('Error during verification:', err);
  process.exit(1);
});
