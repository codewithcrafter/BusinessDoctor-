const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const ARTIFACT_DIR = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149';
const SCRATCH_DIR = 'c:\\Users\\user\\Desktop\\businessdoctor\\scratch';

const viewports = [
  { name: 'desktop_1920', w: 1920, h: 1080 },
  { name: 'tablet_1024', w: 1024, h: 768 },
  { name: 'mobile_390', w: 390, h: 844 }
];

async function verifyBadges() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9650;
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

    // Verify all 5 badges
    const badgeAudit = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `
        (() => {
          const targets = [
            { id: '1_capabilities', sel: '#capabilities .eyebrow-badge' },
            { id: '2_transformation', sel: '.transformation-section .eyebrow-badge' },
            { id: '3_approach', sel: '#methodologySection .eyebrow-badge' },
            { id: '4_outcomes', sel: '.cases-editorial-grid' }, // parent section
            { id: '5_insights', sel: '.insights-editorial-grid' } // parent section
          ];

          // 4 and 5 need section .eyebrow-badge
          const s4 = document.querySelector('.cases-editorial-grid')?.closest('section')?.querySelector('.eyebrow-badge');
          const s5 = document.querySelector('.insights-editorial-grid')?.closest('section')?.querySelector('.eyebrow-badge');

          const badges = [
            { key: 'Section 1 (Featured Capabilities)', el: document.querySelector('#capabilities .eyebrow-badge') },
            { key: 'Section 2 (Business Transformation)', el: document.querySelector('.transformation-section .eyebrow-badge') },
            { key: 'Section 3 (Our Approach)', el: document.querySelector('#methodologySection .eyebrow-badge') },
            { key: 'Section 4 (Proven Outcomes)', el: s4 },
            { key: 'Section 5 (Perspectives & Insights)', el: s5 }
          ];

          return badges.map(b => {
            const el = b.el;
            if (!el) return { key: b.key, found: false };
            const textSpan = el.querySelector('span:not(.pill-dot)');
            const dot = el.querySelector('.pill-dot');
            const style = getComputedStyle(el);
            const dotStyle = dot ? getComputedStyle(dot) : null;
            const rect = el.getBoundingClientRect();
            return {
              key: b.key,
              found: true,
              visibleText: textSpan ? textSpan.textContent.trim() : el.textContent.trim(),
              hasCyanDot: !!dot,
              dotColor: dotStyle ? dotStyle.backgroundColor : null,
              textColor: style.color,
              bgColor: style.backgroundColor,
              border: style.border,
              borderRadius: style.borderRadius,
              fontSize: style.fontSize,
              letterSpacing: style.letterSpacing,
              padding: style.padding,
              rect: { top: Math.round(rect.top), left: Math.round(rect.left), width: Math.round(rect.width), height: Math.round(rect.height) }
            };
          });
        })()
      `
    });

    console.log('Eyebrow Badges Audit Result:');
    console.log(JSON.stringify(badgeAudit.result.result.value, null, 2));

    // Scroll and capture screenshot of each section header
    const sectionSelectors = [
      { name: 'eyebrow_1_capabilities', sel: '#capabilities .section-header' },
      { name: 'eyebrow_2_transformation', sel: '.transformation-section .section-header' },
      { name: 'eyebrow_3_approach', sel: '#methodologySection .stage-header-col' },
      { name: 'eyebrow_4_outcomes', sel: '.cases-editorial-grid' },
      { name: 'eyebrow_5_insights', sel: '.insights-editorial-grid' }
    ];

    for (const sec of sectionSelectors) {
      const clipEval = await send('Runtime.evaluate', {
        returnByValue: true,
        expression: `
          (() => {
            let el;
            if ('${sec.name}' === 'eyebrow_4_outcomes') {
              el = document.querySelector('.cases-editorial-grid')?.closest('section')?.querySelector('.section-header');
            } else if ('${sec.name}' === 'eyebrow_5_insights') {
              el = document.querySelector('.insights-editorial-grid')?.closest('section')?.querySelector('.section-header');
            } else {
              el = document.querySelector('${sec.sel}');
            }
            if (!el) return null;
            el.scrollIntoView({ block: 'center' });
            const r = el.getBoundingClientRect();
            return { x: 0, y: Math.max(0, window.scrollY + r.top - 60), width: window.innerWidth, height: Math.min(600, r.height + 140) };
          })()
        `
      });

      await new Promise(r => setTimeout(r, 200));
      const clip = clipEval.result.result.value;
      if (clip) {
        const shot = await send('Page.captureScreenshot', { format: 'png', clip: { x: clip.x, y: clip.y, width: clip.width, height: clip.height, scale: 1 } });
        fs.writeFileSync(path.join(ARTIFACT_DIR, `${sec.name}.png`), Buffer.from(shot.result.data, 'base64'));
        fs.writeFileSync(path.join(SCRATCH_DIR, `${sec.name}.png`), Buffer.from(shot.result.data, 'base64'));
      }
    }

    console.log('Console Errors:', errors.length);
    ws.close();
  } catch (err) {
    console.error('Error:', err);
  } finally {
    chrome.kill();
  }
}

verifyBadges();

