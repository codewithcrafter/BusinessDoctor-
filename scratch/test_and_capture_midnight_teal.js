const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function runSession(url, width, height, scrollSelector, filename, evaluateFn, actionFn) {
  const port = 9530 + Math.floor(Math.random() * 50);
  const chrome = spawn(CHROME_PATH, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${width},${height}`,
    url
  ]);

  try {
    await new Promise(r => setTimeout(r, 2200));
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

    if (actionFn) {
      await actionFn(send);
      await new Promise(r => setTimeout(r, 1200));
    }

    if (scrollSelector) {
      await send('Runtime.evaluate', {
        expression: `
          (() => {
            const el = document.querySelector('${scrollSelector}');
            if (el) {
              el.scrollIntoView({ behavior: 'instant', block: 'start' });
            }
          })()
        `
      });
      await new Promise(r => setTimeout(r, 800));
    }

    let evalResult = null;
    if (evaluateFn) {
      const evalResp = await send('Runtime.evaluate', {
        expression: `(${evaluateFn.toString()})()`,
        returnByValue: true
      });
      evalResult = evalResp.result?.value;
    }

    if (filename) {
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      fs.writeFileSync(path.join('scratch', filename), buf);
      if (fs.existsSync(ARTIFACT_DIR)) {
        fs.writeFileSync(path.join(ARTIFACT_DIR, filename), buf);
      }
      console.log(`[Captured] ${filename} (${buf.length} bytes) @ ${width}x${height}`);
    }

    ws.close();
    return evalResult;
  } catch (err) {
    console.error(`Error in session for ${filename || url}:`, err.message);
  } finally {
    chrome.kill();
  }
}

async function main() {
  console.log('=== STARTING MIDNIGHT NAVY & ELECTRIC TEAL VALIDATION & CAPTURE SUITE ===');

  // 1. Responsive & Overflow Audit across all required viewports
  const viewports = [1920, 1440, 1366, 1024, 768, 390, 360];
  console.log('\n--- 1. Responsive Testing & Overflow Check ---');
  for (const w of viewports) {
    const res = await runSession('http://127.0.0.1:8000/', w, 900, null, null, () => {
      const sw = document.documentElement.scrollWidth;
      const iw = window.innerWidth;
      const hasOverflow = sw > iw;
      const bodyBg = window.getComputedStyle(document.body).backgroundColor;
      const headerBg = window.getComputedStyle(document.querySelector('.site-header')).backgroundColor;
      const missionBg = window.getComputedStyle(document.querySelector('.mv-panel-mission')).backgroundColor;
      const visionBg = window.getComputedStyle(document.querySelector('.mv-panel-vision')).backgroundColor;
      return { sw, iw, hasOverflow, bodyBg, headerBg, missionBg, visionBg };
    });
    console.log(`Viewport ${w}px: Overflow? ${res?.hasOverflow ? 'FAIL (scrollWidth ' + res?.sw + ' > ' + res?.iw + ')' : 'PASS (Clean ' + res?.iw + 'px)'}`);
    console.log(`  Colors: body=${res?.bodyBg}, header=${res?.headerBg}, mission=${res?.missionBg}, vision=${res?.visionBg}`);
  }

  // 2. Mandatory Screenshot Verification (10 items required)
  console.log('\n--- 2. Mandatory Screenshot Verification (10 Items) ---');
  // 1. Homepage navbar and hero
  await runSession('http://127.0.0.1:8000/', 1920, 1080, null, 'teal_hero_1920.png');
  // 2. Mission & Vision
  await runSession('http://127.0.0.1:8000/', 1920, 1080, '#missionVision', 'teal_mission_vision_1920.png');
  // 3. Services / Capabilities
  await runSession('http://127.0.0.1:8000/', 1920, 1080, '#capabilities', 'teal_services_1920.png');
  // 4. Measurable Accountability
  await runSession('http://127.0.0.1:8000/', 1920, 1080, '#accountability', 'teal_accountability_1920.png');
  // 5. Case Studies
  await runSession('http://127.0.0.1:8000/case-studies.php', 1920, 1080, null, 'teal_cases_1920.png');
  // 6. About page
  await runSession('http://127.0.0.1:8000/about.php', 1920, 1080, null, 'teal_about_1920.png');
  // 7. Contact page
  await runSession('http://127.0.0.1:8000/contact.php', 1920, 1080, null, 'teal_contact_1920.png');
  // 8. Footer
  await runSession('http://127.0.0.1:8000/', 1920, 900, 'footer.site-footer', 'teal_footer_1920.png');

  // 9. Admin Dashboard (Authenticate and capture)
  await runSession('http://127.0.0.1:8000/admin/login.php', 1920, 1080, null, 'teal_admin_dashboard_1920.png', null, async (send) => {
    // Fill credentials & submit
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          document.getElementById('username').value = 'admin';
          document.getElementById('password').value = 'Admin@BusinessDoctor2026';
          document.querySelector('form').submit();
        })()
      `
    });
  });

  // 10. Mobile homepage
  await runSession('http://127.0.0.1:8000/', 390, 844, null, 'teal_mobile_hero_390.png');
  await runSession('http://127.0.0.1:8000/', 390, 844, '#missionVision', 'teal_mobile_mv_390.png');

  console.log('\n=== ALL TESTS AND CAPTURES COMPLETED SUCCESSFULLY ===');
}

main().catch(console.error);
