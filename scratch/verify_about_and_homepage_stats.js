const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = path.join(__dirname);

async function runSession(url, width, height, fn) {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9450 + Math.floor(Math.random() * 40);
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    `--window-size=${width},${height}`,
    url
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
  console.log('=== Step 1: About Page Verification (about.php) ===');
  await runSession('http://127.0.0.1:8000/about.php', 1440, 900, async ({ evaluate, capture, consoleLogs }) => {
    const audit = await evaluate(`
      (() => {
        const phil = document.getElementById('philosophySection');
        const comm = document.getElementById('commitmentsSection');
        const ticker = document.getElementById('vitalTicker');
        
        const commCards = Array.from(document.querySelectorAll('.commitment-card')).map(c => ({
          num: c.querySelector('.commitment-num')?.textContent?.trim(),
          title: c.querySelector('.commitment-title')?.textContent?.trim(),
          desc: c.querySelector('.commitment-desc')?.textContent?.trim()
        }));

        const blocks = Array.from(document.querySelectorAll('.philosophy-editorial-block')).map(b => ({
          title: b.querySelector('.philosophy-block-title')?.textContent?.trim(),
          textSnippet: b.querySelector('.philosophy-block-text')?.textContent?.trim()?.slice(0, 60)
        }));

        return {
          philosophyFound: !!phil,
          commitmentsFound: !!comm,
          tickerFoundOnAbout: !!ticker,
          commitmentsCount: commCards.length,
          commCards,
          blocksCount: blocks.length,
          blocks
        };
      })()
    `);
    console.log('About Page Audit:', audit);

    // Scroll to Philosophy section
    await evaluate(`document.getElementById('philosophySection')?.scrollIntoView({ behavior: 'instant', block: 'start' });`);
    await new Promise(r => setTimeout(r, 400));
    await capture('about_philosophy_1440.png');

    // Scroll to Commitments section
    await evaluate(`document.getElementById('commitmentsSection')?.scrollIntoView({ behavior: 'instant', block: 'start' });`);
    await new Promise(r => setTimeout(r, 400));
    await capture('about_commitments_1440.png');

    console.log('About console warnings/errors:', consoleLogs.filter(l => l.type === 'error'));
  });

  console.log('=== Step 2: About Page Mobile Verification (390x844) ===');
  await runSession('http://127.0.0.1:8000/about.php', 390, 844, async ({ evaluate, capture }) => {
    await evaluate(`document.getElementById('philosophySection')?.scrollIntoView({ behavior: 'instant', block: 'start' });`);
    await new Promise(r => setTimeout(r, 400));
    await capture('about_philosophy_390.png');

    await evaluate(`document.getElementById('commitmentsSection')?.scrollIntoView({ behavior: 'instant', block: 'start' });`);
    await new Promise(r => setTimeout(r, 400));
    await capture('about_commitments_390.png');
  });

  console.log('=== Step 3: Homepage KPI Statistics Verification (index.php) ===');
  await runSession('http://127.0.0.1:8000/', 1440, 900, async ({ evaluate, capture, consoleLogs }) => {
    const kpiAudit = await evaluate(`
      (() => {
        const hero = document.getElementById('heroScrollTrack');
        const kpi = document.getElementById('kpiStripSection');
        const cap = document.getElementById('capabilities');
        const ticker = document.getElementById('vitalTicker');

        const heroRect = hero ? hero.getBoundingClientRect() : null;
        const kpiRect = kpi ? kpi.getBoundingClientRect() : null;
        const capRect = cap ? cap.getBoundingClientRect() : null;

        const kpiTop = kpi ? kpi.offsetTop : -1;
        const heroBottom = hero ? hero.offsetTop + hero.offsetHeight : -1;
        const capTop = cap ? cap.offsetTop : -1;

        const items = Array.from(document.querySelectorAll('#vitalTicker .vital-item')).map(item => ({
          num: item.querySelector('.vital-number')?.textContent?.trim(),
          label: item.querySelector('.vital-label')?.textContent?.trim()
        }));

        return {
          kpiSectionFound: !!kpi,
          vitalTickerFound: !!ticker,
          isAfterHero: kpiTop >= heroBottom,
          isBeforeCapabilities: kpiTop < capTop,
          items
        };
      })()
    `);
    console.log('Homepage KPI Audit:', kpiAudit);

    // Scroll to KPI strip section and trigger animation
    await evaluate(`
      (() => {
        const kpi = document.getElementById('kpiStripSection');
        if (kpi) kpi.scrollIntoView({ behavior: 'instant', block: 'center' });
        if (typeof window.triggerKpiDataStrip === 'function') window.triggerKpiDataStrip();
      })()
    `);
    await new Promise(r => setTimeout(r, 1500)); // wait for count-up animation
    await capture('homepage_kpis_1440.png');

    const animatedValues = await evaluate(`
      (() => {
        return Array.from(document.querySelectorAll('#vitalTicker .vital-item')).map(item => ({
          num: item.querySelector('.vital-number')?.textContent?.trim(),
          label: item.querySelector('.vital-label')?.textContent?.trim()
        }));
      })()
    `);
    console.log('Animated KPI Values after scroll:', animatedValues);

    console.log('Homepage console warnings/errors:', consoleLogs.filter(l => l.type === 'error'));
  });

  console.log('=== Step 4: Homepage KPI Mobile Verification (390x844) ===');
  await runSession('http://127.0.0.1:8000/', 390, 844, async ({ evaluate, capture }) => {
    await evaluate(`
      (() => {
        const kpi = document.getElementById('kpiStripSection');
        if (kpi) kpi.scrollIntoView({ behavior: 'instant', block: 'center' });
        if (typeof window.triggerKpiDataStrip === 'function') window.triggerKpiDataStrip();
      })()
    `);
    await new Promise(r => setTimeout(r, 1500));
    await capture('homepage_kpis_390.png');
  });

  console.log('=== Step 5: Responsive Viewport Overflow Checks across both pages ===');
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
    // Check index.php
    await runSession('http://127.0.0.1:8000/', vp.w, vp.h, async ({ evaluate, consoleLogs }) => {
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
      console.log(`Homepage ${vp.w}x${vp.h}:`, check, `Errors: ${errors.length}`);
    });

    // Check about.php
    await runSession('http://127.0.0.1:8000/about.php', vp.w, vp.h, async ({ evaluate, consoleLogs }) => {
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
      console.log(`About Page ${vp.w}x${vp.h}:`, check, `Errors: ${errors.length}`);
    });
  }

  console.log('All verifications finished!');
}

verifyAll().catch(err => {
  console.error('Error during verification:', err);
  process.exit(1);
});

