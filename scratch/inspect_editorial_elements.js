const { spawn } = require('child_process');

async function test() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9580;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2200));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page');

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

    const data = await send('Runtime.evaluate', {
      expression: `
        JSON.stringify((() => {
          const edit = document.querySelector('#heroEditorialLayer');
          const children = Array.from(edit.children).map(c => {
            const r = c.getBoundingClientRect();
            const cs = window.getComputedStyle(c);
            return {
              tag: c.tagName,
              class: c.className,
              top: Math.round(r.top),
              bottom: Math.round(r.bottom),
              height: Math.round(r.height),
              marginTop: cs.marginTop,
              marginBottom: cs.marginBottom
            };
          });
          const vp = document.querySelector('#heroAnimViewport').getBoundingClientRect();
          const stageInner = document.querySelector('.hero-stage-inner').getBoundingClientRect();
          const stage = document.querySelector('.hero-sticky-stage').getBoundingClientRect();
          return {
            stage: { top: stage.top, height: stage.height },
            stageInner: { top: stageInner.top, height: stageInner.height },
            viewport: { top: vp.top, height: vp.height },
            editorial: { top: edit.getBoundingClientRect().top, height: edit.getBoundingClientRect().height },
            children
          };
        })())
      `
    });
    console.log('Editorial layer details:', JSON.stringify(JSON.parse(data.result?.result?.value || '{}'), null, 2));

    ws.close();
  } finally {
    chrome.kill();
  }
}

test().catch(console.error);

