const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';

const viewports = [
  { name: '1920', w: 1920, h: 1080 },
  { name: '1440', w: 1440, h: 900 },
  { name: '1366', w: 1366, h: 768 },
  { name: '1024', w: 1024, h: 768 },
  { name: '768', w: 768, h: 1024 },
  { name: '390', w: 390, h: 844 },
  { name: '360', w: 360, h: 800 }
];

async function runVerification() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9530;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1440,900',
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
        consoleLogs.push(data.params);
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
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
    await new Promise(r => setTimeout(r, 2000));

    // Capture 1440px after screenshots
    async function captureViewportOf(selector, filename, block = 'center') {
      await send('Runtime.evaluate', {
        expression: `(() => {
          const el = document.querySelector('${selector}');
          if (el) el.scrollIntoView({ behavior: 'instant', block: '${block}' });
        })()`
      });
      await new Promise(r => setTimeout(r, 600));
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(ARTIFACT_DIR, filename), Buffer.from(shot.result.data, 'base64'));
      console.log('Saved:', filename);
    }

    await captureViewportOf('#methodologySection .stage-top-bar', 'after_fix1_approach_1440.png');
    await captureViewportOf('.cases-editorial-grid', 'after_fix2_cases_1440.png');
    await captureViewportOf('.insights-editorial-grid', 'after_fix3_insights_1440.png');
    await captureViewportOf('.accountability-connector-strip', 'after_fix4_timeline_1440.png');

    // Multi-viewport loop
    const results = [];
    for (const vp of viewports) {
      await send('Emulation.setDeviceMetricsOverride', {
        width: vp.w,
        height: vp.h,
        deviceScaleFactor: 1,
        mobile: vp.w < 768
      });
      await new Promise(r => setTimeout(r, 400));

      const vpTest = await send('Runtime.evaluate', {
        returnByValue: true,
        expression: `(() => {
          const docOverflow = document.documentElement.scrollWidth > window.innerWidth;
          
          // Fix 1 checks
          const methodTopBar = document.querySelector('#methodologySection .stage-top-bar');
          const methodHeader = document.querySelector('#methodologySection .stage-header-col');
          const methodTitle = document.querySelector('#methodologySection .section-title');
          const methodLead = document.querySelector('#methodologySection .lead');
          const methodEyebrow = document.querySelector('#methodologySection .eyebrow-badge');
          
          const headerComputed = methodHeader ? window.getComputedStyle(methodHeader) : null;
          const titleComputed = methodTitle ? window.getComputedStyle(methodTitle) : null;
          const leadComputed = methodLead ? window.getComputedStyle(methodLead) : null;
          
          // Fix 2 checks (Case Studies)
          const caseTitle = document.querySelector('.case-card-title');
          const caseSummary = document.querySelector('.case-card-summary');
          const caseQuote = document.querySelector('.case-quote-box');
          const caseAuthor = document.querySelector('.case-quote-author');
          const caseMetric = document.querySelector('.case-outcome-stat');
          const caseAction = document.querySelector('.case-card-action');
          
          // Fix 3 checks (Perspectives)
          const insCategory = document.querySelector('.insight-category-badge');
          const insMeta = document.querySelector('.insight-meta-strip');
          const insLeadTitle = document.querySelector('.insight-lead-title');
          const insLeadSummary = document.querySelector('.insight-lead-summary');
          const insReadLink = document.querySelector('.insight-read-perspective');
          
          // Fix 4 checks (Timeline)
          const connector = document.querySelector('.accountability-connector-strip');
          const marker = document.querySelector('.connector-marker');
          const markerLabel = document.querySelector('.marker-label');
          const markerNum = document.querySelector('.marker-num');
          const markerDot = document.querySelector('.marker-dot');
          
          return {
            vp: '${vp.name}',
            w: window.innerWidth,
            docOverflow: docOverflow,
            fix1: {
              headerTextAlign: headerComputed ? headerComputed.textAlign : null,
              titleTextAlign: titleComputed ? titleComputed.textAlign : null,
              leadTextAlign: leadComputed ? leadComputed.textAlign : null,
              titleColor: titleComputed ? titleComputed.color : null,
              leadColor: leadComputed ? leadComputed.color : null
            },
            fix2: {
              titleColor: caseTitle ? window.getComputedStyle(caseTitle).color : null,
              summaryColor: caseSummary ? window.getComputedStyle(caseSummary).color : null,
              quoteColor: caseQuote ? window.getComputedStyle(caseQuote).color : null,
              quoteAuthorColor: caseAuthor ? window.getComputedStyle(caseAuthor).color : null,
              metricColor: caseMetric ? window.getComputedStyle(caseMetric).color : null,
              actionColor: caseAction ? window.getComputedStyle(caseAction).color : null
            },
            fix3: {
              categoryColor: insCategory ? window.getComputedStyle(insCategory).color : null,
              metaColor: insMeta ? window.getComputedStyle(insMeta).color : null,
              leadTitleColor: insLeadTitle ? window.getComputedStyle(insLeadTitle).color : null,
              leadSummaryColor: insLeadSummary ? window.getComputedStyle(insLeadSummary).color : null,
              readLinkColor: insReadLink ? window.getComputedStyle(insReadLink).color : null
            },
            fix4: {
              visible: connector ? window.getComputedStyle(connector).display !== 'none' : false,
              labelColor: markerLabel ? window.getComputedStyle(markerLabel).color : null,
              numColor: markerNum ? window.getComputedStyle(markerNum).color : null,
              dotBg: markerDot ? window.getComputedStyle(markerDot).backgroundColor : null,
              markerBg: marker ? window.getComputedStyle(marker).backgroundColor : null
            }
          };
        })()`
      });

      results.push(vpTest.result.result.value);

      if (vp.w === 390) {
        // Capture 390px mobile screenshots
        await captureViewportOf('#methodologySection .stage-top-bar', 'after_fix1_approach_390.png');
        await captureViewportOf('.cases-editorial-grid', 'after_fix2_cases_390.png');
        await captureViewportOf('.insights-editorial-grid', 'after_fix3_insights_390.png');
      }
    }

    console.log('RESULTS:');
    console.log(JSON.stringify(results, null, 2));

    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

runVerification();

