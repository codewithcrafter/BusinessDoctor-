const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

async function verifyRelocation() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9750;
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

    // 1. Check Homepage
    console.log('--- AUDITING HOMEPAGE ---');
    const homeCheck = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const mv = document.getElementById('missionVision');
          const hero = document.getElementById('heroScrollTrack');
          const cap = document.getElementById('capabilities');
          const heroRect = hero ? hero.getBoundingClientRect() : null;
          const capRect = cap ? cap.getBoundingClientRect() : null;
          return {
            hasMissionVisionOnHome: !!mv,
            hasHero: !!hero,
            hasCapabilities: !!cap,
            nextSectionDirectlyFollows: hero && cap ? hero.nextElementSibling === cap : false
          };
        })()
      `
    });
    console.log('Homepage Audit:', JSON.stringify(homeCheck.result.result.value, null, 2));

    // Scroll to capabilities and capture homepage screenshot
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const cap = document.getElementById('capabilities');
          if (cap) cap.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 300));
    const shotHome = await send('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'homepage_after_mv_removal.png'), Buffer.from(shotHome.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'homepage_after_mv_removal.png'), Buffer.from(shotHome.result.data, 'base64'));

    // 2. Navigate to About Page
    console.log('\n--- AUDITING ABOUT PAGE ---');
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/about.php' });
    await new Promise(r => setTimeout(r, 1200));

    const aboutCheck = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const mv = document.getElementById('missionVision');
          const missionPanel = document.querySelector('.mv-panel-mission');
          const visionPanel = document.querySelector('.mv-panel-vision');
          const ticker = document.getElementById('vitalTicker');
          const allIds = Array.from(document.querySelectorAll('[id]')).map(el => el.id);
          const duplicateIds = allIds.filter((id, idx) => allIds.indexOf(id) !== idx);

          const missionStmt = missionPanel?.querySelector('.mv-statement')?.textContent?.trim();
          const visionStmt = visionPanel?.querySelector('.mv-statement')?.textContent?.trim();
          const missionPillars = Array.from(missionPanel?.querySelectorAll('.mv-pillar-tag') || []).map(p => p.textContent.trim());
          const visionPillars = Array.from(visionPanel?.querySelectorAll('.mv-pillar-tag') || []).map(p => p.textContent.trim());
          const tickerItems = Array.from(ticker?.querySelectorAll('.vital-item') || []).map(i => ({
            num: i.querySelector('.vital-number')?.textContent?.trim(),
            lbl: i.querySelector('.vital-label')?.textContent?.trim()
          }));

          // Check surrounding sections
          const prevSection = mv?.previousElementSibling;
          const nextSection = mv?.nextElementSibling;

          return {
            hasMissionVision: !!mv,
            hasMissionPanel: !!missionPanel,
            hasVisionPanel: !!visionPanel,
            hasVitalTicker: !!ticker,
            duplicateIds: duplicateIds,
            missionStatement: missionStmt,
            visionStatement: visionStmt,
            missionPillars: missionPillars,
            visionPillars: visionPillars,
            tickerItems: tickerItems,
            prevSectionName: prevSection ? prevSection.className : null,
            nextSectionName: nextSection ? nextSection.className : null,
            docScrollWidth: document.documentElement.scrollWidth,
            innerWidth: window.innerWidth,
            hasHorizontalOverflow: document.documentElement.scrollWidth > window.innerWidth
          };
        })()
      `
    });
    console.log('About Page Audit:', JSON.stringify(aboutCheck.result.result.value, null, 2));

    // Capture About page intro screenshot
    await send('Runtime.evaluate', { expression: `window.scrollTo(0, 0);` });
    await new Promise(r => setTimeout(r, 300));
    const shotAboutIntro = await send('Page.captureScreenshot', {
      format: 'png',
      clip: { x: 0, y: 0, width: 1920, height: 900, scale: 1 }
    });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'about_intro.png'), Buffer.from(shotAboutIntro.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'about_intro.png'), Buffer.from(shotAboutIntro.result.data, 'base64'));

    // Scroll to Mission & Vision and capture screenshot
    await send('Runtime.evaluate', {
      expression: `
        (() => {
          const mv = document.getElementById('missionVision');
          if (mv) mv.scrollIntoView({ block: 'start' });
        })()
      `
    });
    await new Promise(r => setTimeout(r, 500));
    const shotAboutMV = await send('Page.captureScreenshot', {
      format: 'png',
      clip: { x: 0, y: 0, width: 1920, height: 1080, scale: 1 }
    });
    fs.writeFileSync(path.join(ARTIFACT_DIR, 'about_mission_vision.png'), Buffer.from(shotAboutMV.result.data, 'base64'));
    fs.writeFileSync(path.join(SCRATCH_DIR, 'about_mission_vision.png'), Buffer.from(shotAboutMV.result.data, 'base64'));

    console.log('\nConsole Errors on About Page:', errors.length);
    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

verifyRelocation();

