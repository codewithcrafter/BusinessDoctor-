const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = path.join(__dirname);

async function runSession(width, height, fn) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9400 + Math.floor(Math.random() * 50);
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

    await fn({ send, evaluate, capture, consoleLogs });

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function verifyAll() {
  console.log('=== Step 1: Desktop Verification (1440x900) ===');
  await runSession(1440, 900, async ({ send, evaluate, capture, consoleLogs }) => {
    // 1. Check DOM ordering of all sections
    const sectionOrder = await evaluate(`
      (() => {
        const expected = [
          'heroScrollTrack',
          'capabilitiesSection',
          'bizTransformationSection',
          'benefitsSection',
          'methodologySection',
          'accountability',
          'realResultsSection',
          'toolsSection',
          'insightsSection'
        ];
        const found = [];
        expected.forEach(id => {
          const el = document.getElementById(id);
          if (el) {
            found.push({ id, top: el.getBoundingClientRect().top + window.scrollY });
          }
        });
        found.sort((a,b) => a.top - b.top);
        return found.map(f => f.id);
      })()
    `);
    console.log('Section Order on page:', sectionOrder);

    // 2. Scroll to Benefits Section
    await evaluate(`
      (() => {
        const el = document.getElementById('benefitsSection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      })()
    `);
    await new Promise(r => setTimeout(r, 500));

    // Capture all 6 graphs sequentially
    for (let i = 0; i < 6; i++) {
      await evaluate(`
        (() => {
          const triggers = document.querySelectorAll('.benefits-accordion-trigger');
          if (triggers[${i}]) {
            triggers[${i}].click();
          }
        })()
      `);
      await new Promise(r => setTimeout(r, 400));
      await capture(`accordion_graph_0${i+1}.png`);
    }

    // 3. Scroll to Real Results Section
    await evaluate(`
      (() => {
        const el = document.getElementById('realResultsSection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      })()
    `);
    await new Promise(r => setTimeout(r, 500));
    await capture('real_results_1440.png');

    // Verify Real Results data structure
    const resultsData = await evaluate(`
      (() => {
        const cards = document.querySelectorAll('.result-card');
        return Array.from(cards).map(c => ({
          badge: c.querySelector('.result-industry-badge')?.textContent?.trim(),
          title: c.querySelector('.result-card-title')?.textContent?.trim(),
          challenge: !!c.querySelector('.result-meta-block:nth-of-type(1) .result-card-text'),
          solution: !!c.querySelector('.result-meta-block:nth-of-type(2) .result-card-text'),
          stat: c.querySelector('.result-outcome-stat')?.textContent?.trim(),
          baseline: c.querySelector('.result-baseline-stat')?.textContent?.trim(),
          summary: !!c.querySelector('.result-outcome-summary'),
          actionHref: c.querySelector('.result-card-action')?.getAttribute('href')
        }));
      })()
    `);
    console.log('Real Results Cards found (' + resultsData.length + '):', resultsData);

    // 4. Scroll to Tools We Use Section
    await evaluate(`
      (() => {
        const el = document.getElementById('toolsSection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      })()
    `);
    await new Promise(r => setTimeout(r, 500));
    await capture('tools_we_use_1440.png');

    // Verify Tools filtering
    const toolsData = await evaluate(`
      (() => {
        const allCards = document.querySelectorAll('.tool-card');
        const filterBtns = document.querySelectorAll('.tool-filter-btn');
        return {
          totalCards: allCards.length,
          categories: Array.from(new Set(Array.from(allCards).map(c => c.dataset.category))),
          filterCount: filterBtns.length
        };
      })()
    `);
    console.log('Tools We Use Data:', toolsData);

    console.log('Console warnings/errors:', consoleLogs.filter(l => l.type === 'error'));
  });

  console.log('=== Step 2: Mobile Verification (390x844) ===');
  await runSession(390, 844, async ({ send, evaluate, capture }) => {
    // Scroll to Benefits Section
    await evaluate(`
      (() => {
        const el = document.getElementById('benefitsSection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      })()
    `);
    await new Promise(r => setTimeout(r, 500));
    await capture('benefits_accordion_390.png');

    // Scroll to Real Results
    await evaluate(`
      (() => {
        const el = document.getElementById('realResultsSection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      })()
    `);
    await new Promise(r => setTimeout(r, 500));
    await capture('real_results_390.png');

    // Scroll to Tools We Use
    await evaluate(`
      (() => {
        const el = document.getElementById('toolsSection');
        if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
      })()
    `);
    await new Promise(r => setTimeout(r, 500));
    await capture('tools_we_use_390.png');
  });

  console.log('=== Step 3: Responsive Viewport Overflow & Error Checks ===');
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

  console.log('All verifications finished!');
}

verifyAll().catch(err => {
  console.error('Error during verification:', err);
  process.exit(1);
});
