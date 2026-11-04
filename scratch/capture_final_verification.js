const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

async function capture() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

  // Helper for single screenshot
  async function shotPage(url, w, h, outName, setupFn) {
    const port = 9980 + Math.floor(Math.random() * 80);
    const chrome = spawn(chromePath, [
      '--headless=new',
      '--incognito',
      '--disable-cache',
      `--remote-debugging-port=${port}`,
      `--window-size=${w},${h}`,
      url
    ]);

    try {
      await new Promise(r => setTimeout(r, 1600));
      const res = await fetch(`http://127.0.0.1:${port}/json/list`);
      const pages = await res.json();
      const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
      const ws = new WebSocket(page.webSocketDebuggerUrl);

      function send(method, params = {}) {
        return new Promise(resolve => {
          const id = Math.floor(Math.random() * 100000);
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
      await send('Network.setCacheDisabled', { cacheDisabled: true });
      await send('Page.enable');
      await send('Runtime.enable');
      await new Promise(r => setTimeout(r, 400));

      if (setupFn) {
        await setupFn(send);
      }

      const shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(ARTIFACT_DIR, outName), Buffer.from(shot.result.data, 'base64'));
      console.log(`Saved screenshot: ${outName}`);

      ws.close();
    } finally {
      chrome.kill();
    }
  }

  // 1. Desktop 1440 Navbar with Blog
  await shotPage('http://127.0.0.1:8000/index.php', 1440, 900, 'navbar_desktop_blog_1440.png', async (send) => {
    // Header is in view at top
  });

  // 2. Desktop 1440 Blog Active on insights.php
  await shotPage('http://127.0.0.1:8000/insights.php', 1440, 900, 'navbar_blog_active_insights_1440.png', async (send) => {
    // Header is in view at top
  });

  // 3. Desktop 1440 Blog Active on insight-detail.php
  await shotPage('http://127.0.0.1:8000/insight-detail.php?slug=performance-driven-enterprise-replatforming', 1440, 900, 'navbar_blog_active_detail_1440.png', async (send) => {
    // Header is in view at top
  });

  // 4. Mobile 390 Drawer with Blog item
  await shotPage('http://127.0.0.1:8000/index.php', 390, 844, 'navbar_mobile_drawer_blog_390.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const btn = document.getElementById('menuToggleBtn');
          if (btn) btn.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 500));
  });

  // 5. Category Navigation 1440 Initial
  await shotPage('http://127.0.0.1:8000/index.php', 1440, 900, 'category_nav_1440_initial.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `document.getElementById('capabilities').scrollIntoView();`
    });
    await new Promise(r => setTimeout(r, 400));
  });

  // 6. Category Navigation 1440 Scrolled
  await shotPage('http://127.0.0.1:8000/index.php', 1440, 900, 'category_nav_1440_scrolled.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          document.getElementById('capabilities').scrollIntoView();
          const next = document.getElementById('capNavNext');
          if (next) next.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));
  });

  // 7. Category Navigation 1024
  await shotPage('http://127.0.0.1:8000/index.php', 1024, 768, 'category_nav_1024_initial.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `document.getElementById('capabilities').scrollIntoView();`
    });
    await new Promise(r => setTimeout(r, 400));
  });

  // 8. Category Navigation 768
  await shotPage('http://127.0.0.1:8000/index.php', 768, 1024, 'category_nav_768_initial.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `document.getElementById('capabilities').scrollIntoView();`
    });
    await new Promise(r => setTimeout(r, 400));
  });

  // 9. Category Navigation 390 Initial
  await shotPage('http://127.0.0.1:8000/index.php', 390, 844, 'category_nav_390_initial.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `document.getElementById('capabilities').scrollIntoView();`
    });
    await new Promise(r => setTimeout(r, 400));
  });

  // 10. Category Navigation 390 Scrolled to Tab 6
  await shotPage('http://127.0.0.1:8000/index.php', 390, 844, 'category_nav_390_scrolled_tab6.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          document.getElementById('capabilities').scrollIntoView();
          const bar = document.getElementById('capabilitiesNavBar');
          bar.scrollTo({ left: bar.scrollWidth - bar.clientWidth, behavior: 'instant' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 600));
  });

  // 11. Category Navigation 360 Initial
  await shotPage('http://127.0.0.1:8000/index.php', 360, 800, 'category_nav_360_initial.png', async (send) => {
    await send('Runtime.evaluate', {
      expression: `document.getElementById('capabilities').scrollIntoView();`
    });
    await new Promise(r => setTimeout(r, 400));
  });
}

capture();

