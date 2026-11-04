const { spawn } = require('child_process');

async function checkOffsets() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--remote-debugging-port=9995',
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9995/json/list');
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
            const btns = Array.from(document.querySelectorAll(".cap-tab-btn"));
            return btns.map((b, i) => ({
              i: i + 1,
              text: b.innerText.replace(/\\s+/g, ' ').trim(),
              offsetLeft: b.offsetLeft,
              offsetWidth: b.offsetWidth,
              sum: b.offsetLeft + b.offsetWidth
            }));
          })()
        `
      }
    }));
  };

  ws.onmessage = (evt) => {
    const data = JSON.parse(evt.data);
    if (data.id === 1) {
      console.log(JSON.stringify(data.result.result.value, null, 2));
      chrome.kill();
      process.exit();
    }
  };
}

checkOffsets();

