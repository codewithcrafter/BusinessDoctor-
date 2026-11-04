const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const artifactDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

async function captureMobileScreens() {
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1600));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
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

    // 1. Emulate 390x844
    await send('Emulation.setDeviceMetricsOverride', {
      width: 390,
      height: 844,
      deviceScaleFactor: 2,
      mobile: true
    });

    // Test mobile drawer
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
    await new Promise(r => setTimeout(r, 800));

    // Click mobile hamburger
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const btn = document.querySelector('.mobile-toggle, .navbar-toggle, .hamburger, [aria-label*="menu" i], [aria-label*="Toggle" i]');
          if (btn) btn.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 500));

    const drawerShot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(artifactDir, 'responsive_mobile_drawer_390.png'), Buffer.from(drawerShot.result.data, 'base64'));
    console.log('Saved responsive_mobile_drawer_390.png');

    // Close drawer
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const closeBtn = document.querySelector('.drawer-close, .mobile-drawer-close, .mobile-toggle.active');
          if (closeBtn) closeBtn.click();
        })()
      `
    });
    await new Promise(r => setTimeout(r, 400));

    // Scroll down to check Benefits, Results, Tools sections on mobile
    const sections = ['#benefitsSection', '#realResultsSection', '#toolsSection', '#approach'];
    for (const s of sections) {
      await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${s}');
            if (el) el.scrollIntoView({ behavior: 'instant', block: 'center' });
          })()
        `
      });
      await new Promise(r => setTimeout(r, 400));
      const sShot = await send('Page.captureScreenshot', { format: 'png' });
      const cleanName = s.replace('#', '');
      fs.writeFileSync(path.join(artifactDir, `responsive_${cleanName}_390.png`), Buffer.from(sShot.result.data, 'base64'));
      console.log(`Saved responsive_${cleanName}_390.png`);
    }

    // Now test services category tabs at 390px
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/services.php' });
    await new Promise(r => setTimeout(r, 800));
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const nav = document.querySelector('.category-nav-wrapper, .service-nav-wrapper');
          if (nav) nav.scrollIntoView({ behavior: 'instant', block: 'center' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 400));
    const servShot = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(artifactDir, 'responsive_services_tabs_390.png'), Buffer.from(servShot.result.data, 'base64'));
    console.log('Saved responsive_services_tabs_390.png');

  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

captureMobileScreens();

