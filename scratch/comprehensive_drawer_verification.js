const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\mobile_drawer_final_proof';
if (!fs.existsSync(outDir)) {
  fs.mkdirSync(outDir, { recursive: true });
}

const testViewports = [
  { name: '01_small_iphone_320x568', w: 320, h: 568, dpr: 2 },
  { name: '02_iphone_se_375x667', w: 375, h: 667, dpr: 2 },
  { name: '03_iphone_14_390x844', w: 390, h: 844, dpr: 3 },
  { name: '04_pixel_412x915', w: 412, h: 915, dpr: 2.625 },
  { name: '05_pixel_10_412x924', w: 412, h: 924, dpr: 2.625 },
  { name: '06_large_iphone_430x932', w: 430, h: 932, dpr: 3 },
  { name: '07_short_viewport_390x667', w: 390, h: 667, dpr: 2 },
  { name: '08_tablet_768x1024', w: 768, h: 1024, dpr: 2 },
  { name: '09_landscape_844x390', w: 844, h: 390, dpr: 3 }
];

async function runComprehensiveVerification() {
  const port = 9911;
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

    const results = [];

    for (const vp of testViewports) {
      console.log(`\n========================================================`);
      console.log(`TESTING VIEWPORT: ${vp.name} (${vp.w} × ${vp.h})`);
      console.log(`========================================================`);

      await send('Emulation.setDeviceMetricsOverride', {
        width: vp.w,
        height: vp.h,
        deviceScaleFactor: vp.dpr,
        mobile: true
      });

      // Navigate to fresh page
      await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
      for (let i = 0; i < 40; i++) {
        await new Promise(r => setTimeout(r, 100));
        const s = await send('Runtime.evaluate', { expression: 'document.readyState' });
        if (s && s.result && s.result.value === 'complete') break;
      }
      await new Promise(r => setTimeout(r, 500));

      // Scroll down page 350px before opening drawer to guarantee scroll-independence test!
      await send('Runtime.evaluate', { expression: 'window.scrollTo(0, 350);' });
      await new Promise(r => setTimeout(r, 300));

      // 1. Capture closed state (while page is scrolled)
      let shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `${vp.name}_01_closed.png`), Buffer.from(shot.data, 'base64'));

      // 2. Open drawer
      const openEval = await send('Runtime.evaluate', {
        expression: `(() => {
          const toggle = document.getElementById('menuToggleBtn');
          toggle.click();
          const d = document.getElementById('mobileDrawer');
          const b = document.getElementById('mobileDrawerBackdrop');
          const sb = document.getElementById('mobileDrawerScrollBody');
          const navList = document.querySelector('.mobile-nav-list');
          const cta = document.querySelector('.mobile-drawer-cta');

          const dr = d.getBoundingClientRect();
          const br = b.getBoundingClientRect();
          const firstLink = navList && navList.children.length > 0 ? navList.children[0] : null;
          const flr = firstLink ? firstLink.getBoundingClientRect() : null;

          return {
            windowInnerWidth: window.innerWidth,
            windowInnerHeight: window.innerHeight,
            windowScrollY: window.scrollY,
            bodyLocked: document.body.classList.contains('mobile-nav-lock'),
            drawer: {
              top: Math.round(dr.top),
              bottom: Math.round(dr.bottom),
              height: Math.round(dr.height),
              width: Math.round(dr.width),
              isOpen: d.classList.contains('open'),
              ariaHidden: d.getAttribute('aria-hidden')
            },
            backdrop: {
              top: Math.round(br.top),
              bottom: Math.round(br.bottom),
              height: Math.round(br.height),
              width: Math.round(br.width),
              isOpen: b.classList.contains('open')
            },
            scrollBody: {
              scrollTop: sb.scrollTop,
              scrollHeight: sb.scrollHeight,
              clientHeight: sb.clientHeight
            },
            firstItem: firstLink ? {
              text: firstLink.innerText.trim(),
              top: Math.round(flr.top),
              isVisible: flr.top >= 0 && flr.bottom <= window.innerHeight
            } : null
          };
        })()`,
        returnByValue: true
      });

      const metrics = openEval.result.value;
      console.log('Open Metrics:', JSON.stringify(metrics, null, 2));

      // Capture open state
      await new Promise(r => setTimeout(r, 400));
      shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `${vp.name}_02_opened_top.png`), Buffer.from(shot.data, 'base64'));

      // 3. Test IT Services accordion expansion
      await send('Runtime.evaluate', {
        expression: `(() => {
          const accToggle = document.getElementById('mobileServicesToggle');
          if (accToggle) accToggle.click();
        })()`
      });
      await new Promise(r => setTimeout(r, 400));
      shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `${vp.name}_03_accordion_expanded.png`), Buffer.from(shot.data, 'base64'));

      // 4. Scroll drawer to bottom and verify CTA buttons
      const scrollBottomEval = await send('Runtime.evaluate', {
        expression: `(() => {
          const sb = document.getElementById('mobileDrawerScrollBody');
          sb.scrollTop = sb.scrollHeight;
          const cta = document.querySelector('.mobile-drawer-cta');
          const cr = cta.getBoundingClientRect();
          return {
            newScrollTop: sb.scrollTop,
            ctaTop: Math.round(cr.top),
            ctaBottom: Math.round(cr.bottom),
            ctaVisible: cr.top < window.innerHeight && cr.bottom > 0
          };
        })()`,
        returnByValue: true
      });
      console.log('Scroll to Bottom Metrics:', scrollBottomEval.result.value);

      await new Promise(r => setTimeout(r, 400));
      shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `${vp.name}_04_scrolled_bottom.png`), Buffer.from(shot.data, 'base64'));

      // 5. Close drawer via dedicated close button
      await send('Runtime.evaluate', {
        expression: `(() => {
          document.getElementById('mobileDrawerCloseBtn').click();
        })()`
      });
      await new Promise(r => setTimeout(r, 400));

      const closedEval = await send('Runtime.evaluate', {
        expression: `(() => {
          const d = document.getElementById('mobileDrawer');
          const b = document.getElementById('mobileDrawerBackdrop');
          return {
            drawerOpen: d.classList.contains('open'),
            backdropOpen: b.classList.contains('open'),
            bodyLocked: document.body.classList.contains('mobile-nav-lock')
          };
        })()`,
        returnByValue: true
      });
      console.log('Closed State:', closedEval.result.value);

      // 6. Reopen drawer and verify it automatically resets scrollTop to 0
      const reopenEval = await send('Runtime.evaluate', {
        expression: `(() => {
          document.getElementById('menuToggleBtn').click();
          const sb = document.getElementById('mobileDrawerScrollBody');
          const navList = document.querySelector('.mobile-nav-list');
          const firstLink = navList && navList.children.length > 0 ? navList.children[0] : null;
          const flr = firstLink ? firstLink.getBoundingClientRect() : null;
          return {
            scrollTopAfterReopen: sb.scrollTop,
            firstItemText: firstLink ? firstLink.innerText.trim() : null,
            firstItemTop: flr ? Math.round(flr.top) : null,
            isHomeVisibleAtTop: flr && flr.top >= 50 && flr.bottom <= window.innerHeight
          };
        })()`,
        returnByValue: true
      });
      console.log('Reopen Reset Verification:', reopenEval.result.value);

      await new Promise(r => setTimeout(r, 400));
      shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(outDir, `${vp.name}_05_reopened_reset_to_top.png`), Buffer.from(shot.data, 'base64'));

      // Clean close for next viewport
      await send('Runtime.evaluate', { expression: `document.getElementById('mobileDrawerCloseBtn').click();` });
      await new Promise(r => setTimeout(r, 400));

      results.push({
        viewport: vp.name,
        dimensions: `${vp.w}x${vp.h}`,
        fullHeightVerified: metrics.drawer.height === vp.h && metrics.drawer.top === 0 && metrics.drawer.bottom === vp.h,
        zeroUnderlyingExposure: metrics.backdrop.height === vp.h && metrics.drawer.bottom === vp.h,
        firstItemIsHome: metrics.firstItem && metrics.firstItem.text.startsWith('Home'),
        reopenResetSuccess: reopenEval.result.value.scrollTopAfterReopen === 0 && reopenEval.result.value.isHomeVisibleAtTop,
        ctaAccessible: scrollBottomEval.result.value.ctaVisible,
        bodyLockFunctional: metrics.bodyLocked && !closedEval.result.value.bodyLocked
      });
    }

    console.log('\n========================================================');
    console.log('FINAL COMPREHENSIVE VERIFICATION RESULTS:');
    console.log('========================================================');
    console.table(results);
    fs.writeFileSync('scratch/final_verification_results.json', JSON.stringify(results, null, 2));

    ws.close();
  } catch (err) {
    console.error('VERIFICATION ERROR:', err);
  } finally {
    chrome.kill();
  }
}

runComprehensiveVerification();

