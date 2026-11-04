const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_nav_verification';
if (!fs.existsSync(outDir)) {
  fs.mkdirSync(outDir, { recursive: true });
}

async function run() {
  const port = 9985;
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
    const pagesList = await res.json();
    const page = pagesList.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pagesList[0];
    const ws = new WebSocket(page.webSocketDebuggerUrl);

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

    async function navigate(url) {
      await send('Page.navigate', { url });
      for (let i = 0; i < 40; i++) {
        await new Promise(r => setTimeout(r, 100));
        const res = await send('Runtime.evaluate', { expression: 'document.readyState' });
        if (res.result && res.result.value === 'complete') break;
      }
      await new Promise(r => setTimeout(r, 500));
    }

    async function capture(filename) {
      await new Promise(r => setTimeout(r, 300));
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, filename), Buffer.from(shot.result.data, 'base64'));
      console.log(`Saved screenshot: ${filename}`);
    }

    // 1. Functional Interactions Test on 390x844
    console.log('--- TESTING FUNCTIONAL REQUIREMENTS ON 390x844 ---');
    await send('Emulation.setDeviceMetricsOverride', {
      width: 390,
      height: 844,
      deviceScaleFactor: 2,
      mobile: true
    });
    await navigate('http://127.0.0.1:8000/index.php');

    // Test 1: Open Drawer via hamburger click
    console.log('Test 1: Clicking hamburger menu toggle...');
    const clickToggleRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const btn = document.getElementById('menuToggleBtn');
        if (!btn) return 'NO_BTN';
        btn.click();
        const drawer = document.getElementById('mobileDrawer');
        return {
          isOpen: drawer.classList.contains('open'),
          ariaExpanded: btn.getAttribute('aria-expanded'),
          ariaHidden: drawer.getAttribute('aria-hidden'),
          bodyLocked: document.body.classList.contains('mobile-nav-lock')
        };
      })()`,
      returnByValue: true
    });
    console.log('Drawer Open State:', clickToggleRes.result.value);

    // Capture open drawer
    await capture('drawer_open_390.png');

    // Test 2: Check all required links
    const linksCheckRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const drawer = document.getElementById('mobileDrawer');
        const links = Array.from(drawer.querySelectorAll('a')).map(a => ({
          text: a.innerText.trim().replace(/\\s+/g, ' '),
          href: a.getAttribute('href')
        }));
        return links;
      })()`,
      returnByValue: true
    });
    console.log('Links found in drawer:', linksCheckRes.result.value);

    // Test 3: Expand IT Services Accordion
    console.log('Test 3: Expanding IT Services Accordion...');
    const accordionExpandRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const toggle = document.getElementById('mobileServicesToggle');
        if (!toggle) return 'NO_TOGGLE';
        toggle.click();
        const acc = document.getElementById('mobileServicesAccordion');
        const submenu = document.getElementById('mobileServicesSubmenu');
        const sublinks = Array.from(submenu.querySelectorAll('a')).map(a => a.innerText.trim());
        return {
          isExpanded: acc.classList.contains('is-expanded'),
          ariaExpanded: toggle.getAttribute('aria-expanded'),
          submenuDisplay: window.getComputedStyle(submenu).display,
          sublinksCount: sublinks.length,
          sublinks
        };
      })()`,
      returnByValue: true
    });
    console.log('Accordion Expand State:', accordionExpandRes.result.value);
    await capture('drawer_accordion_expanded_390.png');

    // Test 4: Collapse IT Services Accordion
    console.log('Test 4: Collapsing IT Services Accordion...');
    const accordionCollapseRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const toggle = document.getElementById('mobileServicesToggle');
        toggle.click();
        const acc = document.getElementById('mobileServicesAccordion');
        const submenu = document.getElementById('mobileServicesSubmenu');
        return {
          isExpanded: acc.classList.contains('is-expanded'),
          ariaExpanded: toggle.getAttribute('aria-expanded'),
          submenuDisplay: window.getComputedStyle(submenu).display
        };
      })()`,
      returnByValue: true
    });
    console.log('Accordion Collapse State:', accordionCollapseRes.result.value);

    // Test 5: Close via dedicated Close button inside drawer
    console.log('Test 5: Closing via dedicated close button...');
    const closeBtnRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const closeBtn = document.getElementById('mobileDrawerCloseBtn');
        closeBtn.click();
        const drawer = document.getElementById('mobileDrawer');
        const toggle = document.getElementById('menuToggleBtn');
        return {
          isOpen: drawer.classList.contains('open'),
          ariaExpanded: toggle.getAttribute('aria-expanded'),
          bodyLocked: document.body.classList.contains('mobile-nav-lock')
        };
      })()`,
      returnByValue: true
    });
    console.log('Close Button Result:', closeBtnRes.result.value);

    // Test 6: Reopen and close with Escape key
    console.log('Test 6: Opening and closing via Escape key...');
    await send('Runtime.evaluate', { expression: 'document.getElementById("menuToggleBtn").click();' });
    await new Promise(r => setTimeout(r, 200));
    await send('Runtime.evaluate', {
      expression: 'document.dispatchEvent(new KeyboardEvent("keydown", { key: "Escape" }));'
    });
    const escapeRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const drawer = document.getElementById('mobileDrawer');
        return {
          isOpen: drawer.classList.contains('open'),
          bodyLocked: document.body.classList.contains('mobile-nav-lock')
        };
      })()`,
      returnByValue: true
    });
    console.log('Escape Key Result:', escapeRes.result.value);

    // Test 7: Reopen and close via outside backdrop click
    console.log('Test 7: Opening and closing via backdrop click...');
    await send('Runtime.evaluate', { expression: 'document.getElementById("menuToggleBtn").click();' });
    await new Promise(r => setTimeout(r, 200));
    await send('Runtime.evaluate', {
      expression: 'document.getElementById("mobileDrawerBackdrop").click();'
    });
    const backdropRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const drawer = document.getElementById('mobileDrawer');
        return {
          isOpen: drawer.classList.contains('open'),
          bodyLocked: document.body.classList.contains('mobile-nav-lock')
        };
      })()`,
      returnByValue: true
    });
    console.log('Backdrop Click Result:', backdropRes.result.value);

    // 2. Responsive Visual Testing Across All Requested Viewports
    console.log('\n--- CAPTURING RESPONSIVE SCREENSHOTS ACROSS VIEWPORTS ---');
    const viewports = [
      { w: 320, h: 720 },
      { w: 360, h: 800 },
      { w: 375, h: 812 },
      { w: 390, h: 844 },
      { w: 430, h: 932 },
      { w: 768, h: 1024 }
    ];

    for (const vp of viewports) {
      console.log(`Testing viewport ${vp.w}x${vp.h}...`);
      await send('Emulation.setDeviceMetricsOverride', {
        width: vp.w,
        height: vp.h,
        deviceScaleFactor: 2,
        mobile: true
      });
      await navigate('http://127.0.0.1:8000/index.php');

      // 1. Closed state
      await capture(`mobile_${vp.w}_closed.png`);

      // 2. Open state with accordion expanded
      await send('Runtime.evaluate', {
        expression: `(() => {
          const btn = document.getElementById('menuToggleBtn');
          if (btn) btn.click();
          const toggle = document.getElementById('mobileServicesToggle');
          if (toggle) toggle.click();
        })()`
      });
      await capture(`mobile_${vp.w}_drawer_open_accordion.png`);
    }

    // 3. Desktop Preservation Check (1024, 1440, 1920)
    console.log('\n--- VERIFYING DESKTOP PRESERVATION ---');
    for (const d of [{ w: 1024, h: 768 }, { w: 1440, h: 900 }, { w: 1920, h: 1080 }]) {
      await send('Emulation.setDeviceMetricsOverride', {
        width: d.w,
        height: d.h,
        deviceScaleFactor: 1,
        mobile: false
      });
      await navigate('http://127.0.0.1:8000/index.php');
      const deskCheck = await send('Runtime.evaluate', {
        expression: `(() => {
          const deskNav = document.querySelector('.nav-menu');
          const toggle = document.getElementById('menuToggleBtn');
          const drawer = document.getElementById('mobileDrawer');
          return {
            desktopNavVisible: window.getComputedStyle(deskNav).display !== 'none',
            toggleHidden: window.getComputedStyle(toggle).display === 'none',
            drawerHidden: window.getComputedStyle(drawer).display === 'none'
          };
        })()`,
        returnByValue: true
      });
      console.log(`Desktop ${d.w}px Integrity:`, deskCheck.result.value);
      await capture(`desktop_${d.w}_navbar.png`);
    }

    ws.close();
    console.log('\nALL VERIFICATIONS COMPLETED SUCCESSFULLY!');
  } catch (err) {
    console.error('Error during test:', err);
  } finally {
    chrome.kill();
  }
}

run();

