const { spawn } = require('child_process');

const viewports = [
  { name: '1920', w: 1920, h: 1080 },
  { name: '1440', w: 1440, h: 900 },
  { name: '1366', w: 1366, h: 768 },
  { name: '1024', w: 1024, h: 768 },
  { name: '768', w: 768, h: 1024 },
  { name: '390', w: 390, h: 844 },
  { name: '360', w: 360, h: 800 }
];

async function inspectComponents(vp) {
  const port = 9980 + Math.floor(Math.random() * 80);
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    `--window-size=${vp.w},${vp.h}`,
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
    await send('Network.setCacheDisabled', { cacheDisabled: true });
    await send('Page.enable');
    await send('Runtime.enable');
    await new Promise(r => setTimeout(r, 400));

    const check = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const innerW = window.innerWidth;
          const issues = [];

          // 1. Check for text truncation or ellipsis where not intended
          const headings = document.querySelectorAll('h1, h2, h3, h4, .lead, .hero-lead-text, .section-eyebrow');
          headings.forEach(h => {
            const r = h.getBoundingClientRect();
            if (r.width > innerW) {
              issues.push({ type: 'heading-overflow', tag: h.tagName, text: h.innerText.slice(0, 30), width: r.width });
            }
          });

          // 2. Check for button min-width or overflow
          const buttons = document.querySelectorAll('.btn, button:not(.menu-toggle):not(.cap-nav-arrow)');
          buttons.forEach(b => {
            const r = b.getBoundingClientRect();
            if (r.width > innerW) {
              issues.push({ type: 'button-overflow', text: b.innerText.slice(0, 20), width: r.width });
            }
          });

          // 3. Check Benefits Accordion component
          const benefits = document.getElementById('benefitsAccordionSection');
          let benefitsCheck = null;
          if (benefits) {
            const bR = benefits.getBoundingClientRect();
            const items = benefits.querySelectorAll('.benefit-item');
            const activeGraph = benefits.querySelector('.benefit-graph-container');
            benefitsCheck = {
              width: Math.round(bR.width),
              itemCount: items.length,
              graphWidth: activeGraph ? Math.round(activeGraph.getBoundingClientRect().width) : null
            };
          }

          // 4. Check Real Results section
          const results = document.getElementById('resultsSection');
          let resultsCheck = null;
          if (results) {
            const rR = results.getBoundingClientRect();
            const cards = results.querySelectorAll('.case-study-metric-card');
            resultsCheck = {
              width: Math.round(rR.width),
              cardCount: cards.length,
              cardsW: Array.from(cards).map(c => Math.round(c.getBoundingClientRect().width))
            };
          }

          // 5. Check Tools We Use section
          const tools = document.getElementById('toolsSection');
          let toolsCheck = null;
          if (tools) {
            const tR = tools.getBoundingClientRect();
            const toolCards = tools.querySelectorAll('.tool-category-card');
            toolsCheck = {
              width: Math.round(tR.width),
              cardCount: toolCards.length,
              cardsW: Array.from(toolCards).map(c => Math.round(c.getBoundingClientRect().width))
            };
          }

          // 6. Check Methodology Approach section
          const approach = document.getElementById('approach');
          let approachCheck = null;
          if (approach) {
            const aR = approach.getBoundingClientRect();
            const stageCards = approach.querySelectorAll('.stage-card');
            approachCheck = {
              width: Math.round(aR.width),
              cardCount: stageCards.length,
              cardsW: Array.from(stageCards).map(c => Math.round(c.getBoundingClientRect().width))
            };
          }

          // 7. Check Footer
          const footer = document.querySelector('footer');
          let footerCheck = null;
          if (footer) {
            const fR = footer.getBoundingClientRect();
            footerCheck = {
              width: Math.round(fR.width),
              overflow: fR.width > innerW
            };
          }

          return {
            vpWidth: innerW,
            issues,
            benefitsCheck,
            resultsCheck,
            toolsCheck,
            approachCheck,
            footerCheck
          };
        })()
      `,
      returnByValue: true
    });

    return check.result.result.value;
  } catch (err) {
    return { error: err.message };
  } finally {
    chrome.kill();
  }
}

async function run() {
  console.log('--- COMPONENT-LEVEL RESPONSIVE INSPECTION ---');
  for (const vp of viewports) {
    const res = await inspectComponents(vp);
    console.log(`\n[${vp.name}px - ${vp.w}x${vp.h}]`);
    console.log(`  Issues count: ${res.issues ? res.issues.length : 'error'}`);
    if (res.issues && res.issues.length > 0) {
      console.log(`  Issues:`, res.issues);
    }
    console.log(`  Benefits Section:`, res.benefitsCheck);
    console.log(`  Real Results Section:`, res.resultsCheck);
    console.log(`  Tools Section:`, res.toolsCheck);
    console.log(`  Approach Section:`, res.approachCheck);
  }
}

run();

