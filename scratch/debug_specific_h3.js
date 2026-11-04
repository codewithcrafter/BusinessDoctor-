const { spawn } = require('child_process');

async function debugSpecificH3() {
  const port = 9954;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'about:blank'
  ]);

  await new Promise(r => setTimeout(r, 1500));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pagesList = await res.json();
  const page = pagesList.find(p => p.type === 'page') || pagesList[0];
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
  await send('Emulation.setDeviceMetricsOverride', {
    width: 360,
    height: 800,
    deviceScaleFactor: 2,
    mobile: true
  });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/index.php' });
  await new Promise(r => setTimeout(r, 1000));

  const evalRes = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const h = document.querySelector('.cap-card-title');
        if (!h) return { found: false };
        const s = window.getComputedStyle(h);
        const r = h.getBoundingClientRect();
        const p = h.parentElement;
        const pr = p ? p.getBoundingClientRect() : null;
        const ps = p ? window.getComputedStyle(p) : null;
        const card = h.closest('.capability-editorial-card');
        const cr = card ? card.getBoundingClientRect() : null;
        const cs = card ? window.getComputedStyle(card) : null;

        return {
          hText: h.innerText,
          hWidth: r.width,
          hFontSize: s.fontSize,
          hWordBreak: s.wordBreak,
          hOverflowWrap: s.overflowWrap,
          hWhiteSpace: s.whiteSpace,
          parentWidth: pr ? pr.width : null,
          cardWidth: cr ? cr.width : null,
          cardPadding: cs ? cs.padding : null,
          bodyPadding: ps ? ps.padding : null,
          containerWidth: h.closest('.container') ? h.closest('.container').getBoundingClientRect().width : null
        };
      })()
    `,
    returnByValue: true
  });

  console.log(JSON.stringify(evalRes.result.result.value, null, 2));
  chrome.kill();
}

debugSpecificH3();

