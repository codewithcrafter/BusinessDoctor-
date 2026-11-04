const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const viewports = [
  { name: 'iphone_se_375', w: 375, h: 667 },
  { name: 'iphone_14_390', w: 390, h: 844 },
  { name: 'android_small_320', w: 320, h: 720 },
  { name: 'iphone_promax_430', w: 430, h: 932 }
];

const pages = [
  { name: 'home_hero', url: 'index.php', scrollY: 0 },
  { name: 'home_commitments', url: 'index.php', scrollSelector: '.commitments-section' },
  { name: 'home_kpi_strip', url: 'index.php', scrollSelector: '.kpi-strip-section' },
  { name: 'about_editorial', url: 'about.php', scrollSelector: '.editorial-section' },
  { name: 'about_commitments', url: 'about.php', scrollSelector: '.commitments-section' },
  { name: 'services_overview', url: 'services.php', scrollY: 0 },
  { name: 'service_detail', url: 'service-detail.php?slug=web-software-development', scrollY: 0 },
  { name: 'audit_page', url: 'audit.php', scrollY: 0 },
  { name: 'diagnostic_tool', url: 'diagnostic.php', scrollY: 0 },
  { name: 'case_studies', url: 'case-studies.php', scrollY: 0 },
  { name: 'blog_list', url: 'blog.php', scrollY: 0 },
  { name: 'contact_page', url: 'contact.php', scrollY: 0 }
];

async function capture() {
  const outDir = path.resolve('C:/Users/user/.gemini/antigravity/brain/18684505-2438-4107-b6f3-8223edf48149/mobile_page_verification');
  if (!fs.existsSync(outDir)) {
    fs.mkdirSync(outDir, { recursive: true });
  }

  const port = 9989;
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

    for (const vp of viewports) {
      console.log(`Setting viewport: ${vp.name} (${vp.w}x${vp.h})`);
      await send('Emulation.setDeviceMetricsOverride', {
        width: vp.w,
        height: vp.h,
        deviceScaleFactor: 2,
        mobile: true
      });

      for (const p of pages) {
        const fullUrl = `http://127.0.0.1:8000/${p.url}`;
        await send('Page.navigate', { url: fullUrl });

        for (let i = 0; i < 30; i++) {
          await new Promise(r => setTimeout(r, 100));
          const stateRes = await send('Runtime.evaluate', { expression: 'document.readyState' });
          if (stateRes.result && stateRes.result.value === 'complete') break;
        }
        await new Promise(r => setTimeout(r, 500));

        if (p.scrollSelector) {
          await send('Runtime.evaluate', {
            expression: `(() => {
              const el = document.querySelector('${p.scrollSelector}');
              if (el) {
                el.scrollIntoView({ behavior: 'instant', block: 'start' });
              }
            })()`
          });
          await new Promise(r => setTimeout(r, 300));
        }

        const shotRes = await send('Page.captureScreenshot', { format: 'png' });
        if (shotRes.result && shotRes.result.data) {
          const fileName = `${vp.name}_${p.name}.png`;
          fs.writeFileSync(path.join(outDir, fileName), Buffer.from(shotRes.result.data, 'base64'));
          console.log(`Saved screenshot: ${fileName}`);
        }
      }
    }

    ws.close();
  } catch (err) {
    console.error('Capture error:', err);
  } finally {
    chrome.kill();
  }
}

capture();

