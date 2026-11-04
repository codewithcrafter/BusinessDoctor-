const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

const viewports = [
  { name: '1920', w: 1920, h: 1080 },
  { name: '1440', w: 1440, h: 900 },
  { name: '1366', w: 1366, h: 768 },
  { name: '1024', w: 1024, h: 768 },
  { name: '768', w: 768, h: 1024 },
  { name: '390', w: 390, h: 844 },
  { name: '360', w: 360, h: 800 }
];

async function verifyViewport(vp) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1600));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();
    const consoleErrors = [];

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (data.method === 'Runtime.consoleAPICalled' && data.params.type === 'error') {
        consoleErrors.push(data.params.args.map(a => a.value).join(' '));
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

    await send('Network.enable');
    await send('Network.setCacheDisabled', { cacheDisabled: true });
    await send('Page.enable');
    await send('Runtime.enable');
    await send('Page.reload', { ignoreCache: true });
    await new Promise(r => setTimeout(r, 1000));

    // 1. Verify Main Navbar items and order
    const navEval = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const navLinks = Array.from(document.querySelectorAll('.nav-menu .nav-link')).map(a => a.textContent.trim());
          const blogLink = document.querySelector('.nav-menu a[href="insights.php"]');
          const mobileBlogLink = document.querySelector('.mobile-drawer a[href="insights.php"]');
          return {
            desktopNavLinks: navLinks,
            blogLinkText: blogLink ? blogLink.textContent.trim() : null,
            blogLinkHref: blogLink ? blogLink.getAttribute('href') : null,
            mobileBlogText: mobileBlogLink ? mobileBlogLink.textContent.trim() : null,
            mobileBlogHref: mobileBlogLink ? mobileBlogLink.getAttribute('href') : null
          };
        })()
      `,
      returnByValue: true
    });

    const navData = navEval.result.result.value;

    // Scroll to #capabilities
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 500));

    // 2. Check Initial Tabs State
    const initTabsEval = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const bar = document.getElementById('capabilitiesNavBar');
          const barR = bar.getBoundingClientRect();
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const nextBtn = document.getElementById('capNavNext');
          const prevBtn = document.getElementById('capNavPrev');

          const tabStates = btns.map((b, i) => {
            const r = b.getBoundingClientRect();
            // A tab is considered visible if any part of it is within the bar boundaries
            const isVisible = r.right > barR.left + 2 && r.left < barR.right - 2;
            // Clipped means partially visible with its text/border crossing the boundary
            const isClippedRight = r.right > barR.right + 2 && r.left < barR.right - 2;
            const isClippedLeft = r.left < barR.left - 2 && r.right > barR.left + 2;
            const fullyVisible = r.right <= barR.right + 2 && r.left >= barR.left - 2;
            return {
              num: i + 1,
              text: b.innerText.replace(/\\s+/g, ' ').trim(),
              left: Math.round(r.left),
              right: Math.round(r.right),
              width: Math.round(r.width),
              isVisible,
              fullyVisible,
              isClippedRight,
              isClippedLeft
            };
          });

          return {
            bar: {
              left: Math.round(barR.left),
              right: Math.round(barR.right),
              width: Math.round(barR.width),
              scrollLeft: Math.round(bar.scrollLeft),
              scrollWidth: Math.round(bar.scrollWidth),
              clientWidth: Math.round(bar.clientWidth)
            },
            prevVisible: !prevBtn.classList.contains('is-hidden'),
            nextVisible: !nextBtn.classList.contains('is-hidden'),
            tabs: tabStates,
            anyClipped: tabStates.some(t => t.isClippedRight || t.isClippedLeft)
          };
        })()
      `,
      returnByValue: true
    });

    const initialTabsData = initTabsEval.result.result.value;

    // Capture Initial Screenshot
    const shotInit = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, `category_nav_initial_${vp.name}.png`), Buffer.from(shotInit.result.data, 'base64'));

    // 3. Scroll to End using Next Arrow
    let clicks = 0;
    let reachedEnd = false;
    for (let c = 1; c <= 6; c++) {
      const canClickNext = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const n = document.getElementById('capNavNext');
            return n && !n.classList.contains('is-hidden');
          })()
        `,
        returnByValue: true
      });

      if (!canClickNext.result.result.value) {
        reachedEnd = true;
        break;
      }

      await send('Runtime.evaluate', { expression: `document.getElementById('capNavNext').click();` });
      clicks++;
      await new Promise(r => setTimeout(r, 600));
    }

    // Check End Tabs State
    const endTabsEval = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const bar = document.getElementById('capabilitiesNavBar');
          const barR = bar.getBoundingClientRect();
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const nextBtn = document.getElementById('capNavNext');
          const prevBtn = document.getElementById('capNavPrev');

          const tab6 = btns[5];
          const tab6R = tab6.getBoundingClientRect();

          const tabStates = btns.map((b, i) => {
            const r = b.getBoundingClientRect();
            const isVisible = r.right > barR.left + 2 && r.left < barR.right - 2;
            const isClippedRight = r.right > barR.right + 2 && r.left < barR.right - 2;
            const isClippedLeft = r.left < barR.left - 2 && r.right > barR.left + 2;
            const fullyVisible = r.right <= barR.right + 2 && r.left >= barR.left - 2;
            return {
              num: i + 1,
              text: b.innerText.replace(/\\s+/g, ' ').trim(),
              left: Math.round(r.left),
              right: Math.round(r.right),
              width: Math.round(r.width),
              isVisible,
              fullyVisible,
              isClippedRight,
              isClippedLeft
            };
          });

          return {
            bar: {
              left: Math.round(barR.left),
              right: Math.round(barR.right),
              scrollLeft: Math.round(bar.scrollLeft),
              scrollWidth: Math.round(bar.scrollWidth),
              clientWidth: Math.round(bar.clientWidth)
            },
            tab6Text: tab6.innerText.replace(/\\s+/g, ' ').trim(),
            tab6Left: Math.round(tab6R.left),
            tab6Right: Math.round(tab6R.right),
            tab6FullyVisible: Math.round(tab6R.right) <= Math.round(barR.right) + 2 && Math.round(tab6R.left) >= Math.round(barR.left) - 2,
            prevVisible: !prevBtn.classList.contains('is-hidden'),
            nextVisible: !nextBtn.classList.contains('is-hidden'),
            anyClippedAtEnd: tabStates.some(t => (t.isClippedRight || t.isClippedLeft) && t.isVisible)
          };
        })()
      `,
      returnByValue: true
    });

    const endTabsData = endTabsEval.result.result.value;

    // Capture Scrolled Screenshot
    const shotScrolled = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, `category_nav_scrolled_${vp.name}.png`), Buffer.from(shotScrolled.result.data, 'base64'));

    console.log(`\n======================================================`);
    console.log(`VIEWPORT: ${vp.name} (${vp.w}x${vp.h})`);
    console.log(`Navbar Order:`, navData.desktopNavLinks.join(' → '));
    console.log(`Blog Link: Desktop: "${navData.blogLinkText}" (href: ${navData.blogLinkHref}) | Mobile: "${navData.mobileBlogText}"`);
    console.log(`Initial Tabs Visible:`, initialTabsData.tabs.filter(t => t.fullyVisible).map(t => t.text).join(' | '));
    console.log(`Any Tab Clipped at Initial?:`, initialTabsData.anyClipped);
    console.log(`Clicks to reach end: ${clicks}`);
    console.log(`Tab 6 Text: "${endTabsData.tab6Text}" | Fully Visible at End?: ${endTabsData.tab6FullyVisible}`);
    console.log(`Any Tab Clipped at End?:`, endTabsData.anyClippedAtEnd);
    console.log(`Prev Arrow Visible: ${endTabsData.prevVisible} | Next Arrow Visible: ${endTabsData.nextVisible}`);
    console.log(`Console Errors: ${consoleErrors.length}`);
    console.log(`======================================================\n`);

    ws.close();
  } catch (err) {
    console.error(`Error in VP ${vp.name}:`, err);
  } finally {
    chrome.kill('SIGKILL');
  }
}

async function run() {
  for (const vp of viewports) {
    await verifyViewport(vp);
  }
}

run();
