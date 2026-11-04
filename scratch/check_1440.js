const { spawn } = require('child_process');

async function check1440() {
  const port = 9994;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pages = await res.json();
  const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  ws.onopen = async () => {
    ws.send(JSON.stringify({ id: 98, method: 'Network.enable' }));
    ws.send(JSON.stringify({ id: 99, method: 'Network.setCacheDisabled', params: { cacheDisabled: true } }));
    ws.send(JSON.stringify({ id: 100, method: 'Runtime.enable' }));
    ws.send(JSON.stringify({ id: 101, method: 'Page.reload', params: { ignoreCache: true } }));
    await new Promise(r => setTimeout(r, 1200));
    ws.send(JSON.stringify({
      id: 2,
      method: 'Runtime.evaluate',
      params: {
        returnByValue: true,
        expression: `
          (() => {
            const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
            return btns.map(b => ({ text: b.innerText.trim(), w: b.getBoundingClientRect().width, offsetW: b.offsetWidth }));
          })()
        `
      }
    }));
    await new Promise(r => setTimeout(r, 200));
    ws.send(JSON.stringify({
      id: 1,
      method: 'Runtime.evaluate',
      params: {
        returnByValue: true,
        expression: `
          (() => {
            const bar = document.getElementById("capabilitiesNavBar");
            const barR = bar.getBoundingClientRect();
            const btns = Array.from(document.querySelectorAll(".cap-tab-btn"));
            return {
              styleMaxWidth: bar.style.maxWidth,
              styleWidth: bar.style.width,
              barR: { left: Math.round(barR.left), right: Math.round(barR.right), width: Math.round(barR.width) },
              tabs: btns.map((b, i) => {
                const r = b.getBoundingClientRect();
                return {
                  i: i + 1,
                  text: b.innerText.replace(/\\s+/g, ' ').trim(),
                  left: Math.round(r.left),
                  right: Math.round(r.right),
                  width: Math.round(r.width),
                  isClippedRight: r.right > barR.right + 2 && r.left < barR.right - 2,
                  fullyVisible: r.right <= barR.right + 2 && r.left >= barR.left - 2
                };
              })
            };
          })()
        `
      }
    }));
  };

  ws.onmessage = (evt) => {
    const data = JSON.parse(evt.data);
    if (data.method === 'Runtime.consoleAPICalled') {
      console.log('BROWSER CONSOLE:', data.params.args.map(a => a.value).join(' '));
    }
    if (data.id === 2) {
      console.log('ID 2 BTN WIDTHS:', JSON.stringify(data.result.result.value, null, 2));
    }
    if (data.id === 1) {
      console.log(JSON.stringify(data.result.result.value, null, 2));
      chrome.kill();
      process.exit();
    }
  };
}

check1440();
