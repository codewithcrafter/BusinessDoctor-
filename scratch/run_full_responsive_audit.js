const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const artifactBase = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\responsive_audit_screenshots';

const pages = [
  { id: 'index', name: 'Home', url: 'http://127.0.0.1:8000/index.php' },
  { id: 'about', name: 'About Us', url: 'http://127.0.0.1:8000/about.php' },
  { id: 'services', name: 'IT Services', url: 'http://127.0.0.1:8000/services.php' },
  { id: 'service-detail', name: 'Service Detail', url: 'http://127.0.0.1:8000/service-detail.php?slug=web-software-development' },
  { id: 'audit', name: 'Digital Audit', url: 'http://127.0.0.1:8000/audit.php' },
  { id: 'diagnostic', name: 'Diagnostic Portal', url: 'http://127.0.0.1:8000/diagnostic.php' },
  { id: 'case-studies', name: 'Case Studies', url: 'http://127.0.0.1:8000/case-studies.php' },
  { id: 'case-study-detail', name: 'Case Study Detail', url: 'http://127.0.0.1:8000/case-study-detail.php?slug=d2c-apparel-vital-infrastructure-overhaul' },
  { id: 'insights', name: 'Insights', url: 'http://127.0.0.1:8000/insights.php' },
  { id: 'insight-detail', name: 'Insight Detail', url: 'http://127.0.0.1:8000/insight-detail.php?slug=brand-architecture-as-risk-mitigation' },
  { id: 'blog', name: 'Blog', url: 'http://127.0.0.1:8000/blog.php' },
  { id: 'blog-detail', name: 'Blog Detail', url: 'http://127.0.0.1:8000/blog-detail.php?slug=brand-architecture-as-risk-mitigation' },
  { id: 'contact', name: 'Contact', url: 'http://127.0.0.1:8000/contact.php' }
];

const viewports = [
  { id: '1920x1080', name: 'Large Desktop', w: 1920, h: 1080, isMobile: false },
  { id: '1440x900', name: 'Desktop', w: 1440, h: 900, isMobile: false },
  { id: '1366x768', name: 'Laptop', w: 1366, h: 768, isMobile: false },
  { id: '1024x768', name: 'Tablet Landscape', w: 1024, h: 768, isMobile: false },
  { id: '768x1024', name: 'Tablet Portrait', w: 768, h: 1024, isMobile: true },
  { id: '430x932', name: 'Large Mobile', w: 430, h: 932, isMobile: true },
  { id: '390x844', name: 'Standard Mobile', w: 390, h: 844, isMobile: true },
  { id: '375x812', name: 'Small Mobile', w: 375, h: 812, isMobile: true },
  { id: '360x800', name: 'Compact Mobile', w: 360, h: 800, isMobile: true },
  { id: '320x720', name: 'Extra Small Mobile', w: 320, h: 720, isMobile: true }
];

async function startChrome(port) {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/'
  ]);
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
  await send('Network.setCacheDisabled', { cacheDisabled: true });
  await send('Page.enable');
  await send('Runtime.enable');
  await send('Log.enable');

  return { chrome, ws, send };
}

async function runAudit() {
  const port = 9950;
  const { chrome, send } = await startChrome(port);

  const consoleErrors = [];
  const networkFailures = [];

  // Listen to console and network
  // In CDP, events are pushed
  // We will collect in eval scripts

  const auditResults = {
    timestamp: new Date().toISOString(),
    totalPages: pages.length,
    totalViewports: viewports.length,
    totalRuns: pages.length * viewports.length,
    runs: [],
    issues: []
  };

  console.log(`=== STARTING COMPLETE RESPONSIVE AUDIT (${auditResults.totalRuns} combinations) ===\n`);

  for (const page of pages) {
    const pageDir = path.join(artifactBase, page.id);
    if (!fs.existsSync(pageDir)) {
      fs.mkdirSync(pageDir, { recursive: true });
    }

    console.log(`--> Page: ${page.name} (${page.url})`);

    for (const vp of viewports) {
      process.stdout.write(`    [${vp.id} - ${vp.name}] ... `);

      // 1. Set viewport
      await send('Emulation.setDeviceMetricsOverride', {
        width: vp.w,
        height: vp.h,
        deviceScaleFactor: 1,
        mobile: vp.isMobile
      });

      // 2. Navigate
      await send('Page.navigate', { url: page.url });
      await new Promise(r => setTimeout(r, 600));

      // 3. Inspect page layout and overflow
      const checkRes = await send('Runtime.evaluate', {
        expression: `
          (() => {
            const innerW = window.innerWidth;
            const docW = document.documentElement.scrollWidth;
            const bodyW = document.body.scrollWidth;
            const docH = document.documentElement.scrollHeight;

            const horizontalOverflow = docW > innerW;
            const overflowDiff = Math.max(0, docW - innerW);

            const problematicElements = [];

            // Scan all visible elements
            document.querySelectorAll('*').forEach(el => {
              const style = window.getComputedStyle(el);
              if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') return;

              // Check if inside container with horizontal scroll or hidden overflow
              let isContained = false;
              let cur = el.parentElement;
              while (cur && cur !== document.body && cur !== document.documentElement) {
                const s = window.getComputedStyle(cur);
                if (s.overflowX === 'hidden' || s.overflowX === 'auto' || s.overflowX === 'scroll' || s.overflow === 'hidden') {
                  isContained = true;
                  break;
                }
                cur = cur.parentElement;
              }

              const rect = el.getBoundingClientRect();
              
              // 1. Bounding rect extends beyond viewport
              if (!isContained && rect.right > innerW + 1.5) {
                problematicElements.push({
                  type: 'viewport-overflow',
                  tag: el.tagName,
                  id: el.id,
                  cls: (el.className || '').toString().slice(0, 50),
                  rect: { left: Math.round(rect.left), right: Math.round(rect.right), width: Math.round(rect.width) },
                  text: (el.innerText || '').slice(0, 40).trim()
                });
              }

              // 2. Severe negative left margin causing left clip
              if (!isContained && rect.left < -5 && rect.width < innerW) {
                problematicElements.push({
                  type: 'left-clip',
                  tag: el.tagName,
                  id: el.id,
                  cls: (el.className || '').toString().slice(0, 50),
                  rect: { left: Math.round(rect.left), width: Math.round(rect.width) },
                  text: (el.innerText || '').slice(0, 40).trim()
                });
              }

              // 3. Form elements overflowing
              if (['INPUT', 'SELECT', 'TEXTAREA'].includes(el.tagName) && rect.width > innerW) {
                problematicElements.push({
                  type: 'form-element-overflow',
                  tag: el.tagName,
                  name: el.name,
                  id: el.id,
                  width: Math.round(rect.width)
                });
              }
            });

            // Check headings
            const clippedHeadings = [];
            document.querySelectorAll('h1, h2, h3, h4').forEach(h => {
              const r = h.getBoundingClientRect();
              if (r.width > innerW) {
                clippedHeadings.push({
                  tag: h.tagName,
                  text: h.innerText.slice(0, 40),
                  width: Math.round(r.width)
                });
              }
            });

            return {
              innerW,
              innerH: window.innerHeight,
              docW,
              bodyW,
              docH,
              horizontalOverflow,
              overflowDiff,
              problematicElements: problematicElements.slice(0, 10),
              clippedHeadings
            };
          })()
        `,
        returnByValue: true
      });

      const check = checkRes.result.result.value;

      // 4. Capture Screenshot
      const screenshotRes = await send('Page.captureScreenshot', { format: 'png' });
      const shotPath = path.join(pageDir, `${vp.id}.png`);
      fs.writeFileSync(shotPath, Buffer.from(screenshotRes.result.data, 'base64'));

      const runRecord = {
        pageId: page.id,
        pageName: page.name,
        viewport: vp.id,
        viewportName: vp.name,
        width: vp.w,
        height: vp.h,
        horizontalOverflow: check.horizontalOverflow,
        overflowDiff: check.overflowDiff,
        docWidth: check.docW,
        viewportWidth: check.innerW,
        issuesCount: check.problematicElements.length + check.clippedHeadings.length,
        screenshotPath: shotPath
      };

      auditResults.runs.push(runRecord);

      if (runRecord.issuesCount > 0 || runRecord.horizontalOverflow) {
        console.log(`FAILED (${runRecord.issuesCount} issues, overflow: ${runRecord.overflowDiff}px)`);
        auditResults.issues.push({
          page: page.name,
          pageId: page.id,
          viewport: vp.id,
          overflow: runRecord.horizontalOverflow,
          overflowDiff: runRecord.overflowDiff,
          elements: check.problematicElements,
          headings: check.clippedHeadings,
          screenshot: shotPath
        });
      } else {
        console.log(`PASSED (docW: ${check.docW}px, innerW: ${check.innerW}px)`);
      }
    }
  }

  // Save audit data
  fs.writeFileSync(
    path.join(artifactBase, 'audit_results.json'),
    JSON.stringify(auditResults, null, 2)
  );

  console.log('\n=== AUDIT INITIAL SCAN FINISHED ===');
  console.log(`Total test runs: ${auditResults.runs.length}`);
  console.log(`Total issues identified: ${auditResults.issues.length}`);

  chrome.kill();
}

runAudit().catch(err => {
  console.error('Audit failed:', err);
  process.exit(1);
});

