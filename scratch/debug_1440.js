const { spawn } = require('child_process');

async function debug1440() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--remote-debugging-port=9991',
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9991/json/list');
  const pages = await res.json();
  const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  ws.onopen = () => {
    ws.send(JSON.stringify({
      id: 1,
      method: 'Runtime.evaluate',
      params: {
        returnByValue: true,
        expression: `
          (() => {
            const bar = document.getElementById("capabilitiesNavBar");
            const barR = bar.getBoundingClientRect();
            return {
              barR: { left: Math.round(barR.left), right: Math.round(barR.right), width: Math.round(barR.width) },
              styleMaxWidth: bar.style.maxWidth,
              tabs: Array.from(document.querySelectorAll(".cap-tab-btn")).map(b => {
                const r = b.getBoundingClientRect();
                return {
                  text: b.innerText.replace(/\\s+/g, ' ').trim(),
                  left: Math.round(r.left),
                  right: Math.round(r.right),
                  width: Math.round(r.width)
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
    if (data.id === 1) {
      console.log(JSON.stringify(data, null, 2));
      chrome.kill();
      process.exit();
    }
  };
}

debug1440();
