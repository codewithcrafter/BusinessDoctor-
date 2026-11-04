const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const targetUrls = [
  'index.php',
  'about.php',
  'services.php',
  'service-detail.php?slug=web-software-development',
  'service-detail.php?slug=digital-marketing-seo',
  'audit.php',
  'diagnostic.php',
  'case-studies.php',
  'case-study-detail.php?slug=d2c-apparel-vital-infrastructure-overhaul',
  'insights.php',
  'insight-detail.php?slug=the-symptom-trap-why-ad-spend-fails-broken-funnels',
  'contact.php'
];

const phoneWidths = [
  { w: 320, h: 720, label: '320x720 (Small Phone)' },
  { w: 360, h: 800, label: '360x800 (Standard Android)' },
  { w: 375, h: 667, label: '375x667 (iPhone SE)' },
  { w: 375, h: 812, label: '375x812 (iPhone Mini)' },
  { w: 390, h: 844, label: '390x844 (iPhone 13/14)' },
  { w: 393, h: 852, label: '393x852 (iPhone 15/16)' },
  { w: 414, h: 896, label: '414x896 (iPhone XR/Plus)' },
  { w: 430, h: 932, label: '430x932 (iPhone Pro Max)' },
  { w: 768, h: 1024, label: '768x1024 (Tablet Portrait)' }
];

async function audit() {
  const port = 9988;
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

    const issuesFound = [];

    for (const pw of phoneWidths) {
      console.log(`\n================ Testing ${pw.label} ================`);
      await send('Emulation.setDeviceMetricsOverride', {
        width: pw.w,
        height: pw.h,
        deviceScaleFactor: 2,
        mobile: true
      });

      for (const urlPath of targetUrls) {
        const fullUrl = `http://127.0.0.1:8000/${urlPath}`;
        await send('Page.navigate', { url: fullUrl });

        // Wait for page complete
        for (let i = 0; i < 30; i++) {
          await new Promise(r => setTimeout(r, 100));
          const stateRes = await send('Runtime.evaluate', { expression: 'document.readyState' });
          if (stateRes.result && stateRes.result.value === 'complete') break;
        }
        await new Promise(r => setTimeout(r, 400));

        // Evaluate overflow and visual defects
        const checkRes = await send('Runtime.evaluate', {
          expression: `(() => {
            const docWidth = document.documentElement.offsetWidth;
            const scrollWidth = document.documentElement.scrollWidth;
            const winWidth = window.innerWidth;
            const hasHScroll = scrollWidth > winWidth + 1;

            // Find elements extending outside viewport
            const overflowingElements = [];
            document.querySelectorAll('*').forEach(el => {
              // Ignore script, style, head, meta
              if (['SCRIPT', 'STYLE', 'HEAD', 'META', 'TITLE'].includes(el.tagName)) return;
              const rect = el.getBoundingClientRect();
              if (rect.width > 0 && rect.height > 0) {
                if (rect.right > winWidth + 2) {
                  overflowingElements.push({
                    tag: el.tagName,
                    class: el.className,
                    id: el.id,
                    right: Math.round(rect.right),
                    overflowBy: Math.round(rect.right - winWidth)
                  });
                }
              }
            });

            return {
              winWidth,
              scrollWidth,
              hasHScroll,
              overflowCount: overflowingElements.length,
              topOverflows: overflowingElements.slice(0, 4)
            };
          })()`,
          returnByValue: true
        });

        const data = checkRes.result ? checkRes.result.value : null;
        if (data) {
          if (data.hasHScroll || data.overflowCount > 0) {
            console.log(`[ISSUE] ${urlPath} at ${pw.w}px: scrollWidth=${data.scrollWidth} vs winWidth=${data.winWidth}, overflows=${data.overflowCount}`);
            issuesFound.push({
              page: urlPath,
              viewport: pw.label,
              data
            });
          } else {
            process.stdout.write(`.`);
          }
        }
      }
    }

    console.log(`\n\nTotal issues detected: ${issuesFound.length}`);
    fs.writeFileSync('scratch/audit_results.json', JSON.stringify(issuesFound, null, 2));

    ws.close();
  } catch (err) {
    console.error('Audit error:', err);
  } finally {
    chrome.kill();
  }
}

audit();

