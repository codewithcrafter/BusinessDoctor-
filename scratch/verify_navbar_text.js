const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function verifyNavbar() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9600;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
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

    // Verify desktop navbar element
    const checkDesktop = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const navItem = document.querySelector('.nav-item.has-mega-menu');
          const navLink = navItem ? navItem.querySelector('.nav-link-dropdown') : null;
          const span = navLink ? navLink.querySelector('span') : null;
          const chevron = navLink ? navLink.querySelector('.dropdown-chevron') : null;
          const megaMenu = navItem ? navItem.querySelector('.mega-menu') : null;
          const serviceLinks = megaMenu ? Array.from(megaMenu.querySelectorAll('.mega-service-item')).map(a => ({
            text: a.querySelector('.mega-item-title')?.textContent?.trim(),
            href: a.getAttribute('href')
          })) : [];

          return {
            labelText: span ? span.textContent.trim() : null,
            href: navLink ? navLink.getAttribute('href') : null,
            hasChevron: !!chevron,
            hasMegaMenu: !!megaMenu,
            serviceItemsCount: serviceLinks.length,
            serviceLinksSample: serviceLinks.slice(0, 3)
          };
        })()
      `
    });

    console.log('Desktop Navbar Verification:', JSON.stringify(checkDesktop.result.result.value, null, 2));

    // Capture desktop screenshot with navbar
    const shot = await send('Page.captureScreenshot', {
      format: 'png',
      clip: { x: 0, y: 0, width: 1920, height: 180, scale: 1 }
    });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'navbar_it_services_desktop.png'), Buffer.from(shot.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'navbar_it_services_desktop.png'), Buffer.from(shot.result.data, 'base64'));

    // Check mega menu hover appearance
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const mega = document.querySelector('.mega-menu');
          if (mega) {
            mega.style.opacity = '1';
            mega.style.visibility = 'visible';
            mega.style.transform = 'translateY(0)';
          }
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));

    const shotMega = await send('Page.captureScreenshot', {
      format: 'png',
      clip: { x: 0, y: 0, width: 1920, height: 500, scale: 1 }
    });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'navbar_mega_menu_active.png'), Buffer.from(shotMega.result.data, 'base64'));

    console.log('Console Errors:', errors.length);
    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

verifyNavbar();

