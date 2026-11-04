const { spawn } = require('child_process');

async function testMinWidthFix() {
  const port = 9958;
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
  const page = pagesList[0];
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
  
  // Wait until body exists
  let ready = false;
  for (let i = 0; i < 20; i++) {
    const chk = await send('Runtime.evaluate', {
      expression: 'document.readyState === "complete" && !!document.querySelector(".cap-card-title")'
    });
    if (chk.result && chk.result.result && chk.result.result.value === true) {
      ready = true;
      break;
    }
    await new Promise(r => setTimeout(r, 100));
  }

  // Apply CSS fix dynamically and check
  const before = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const h = document.querySelector('.cap-card-title');
        return {
          hText: h ? h.innerText : null,
          hWidth: h ? Math.round(h.getBoundingClientRect().width) : null,
          bodyWidth: document.querySelector('.cap-card-body') ? Math.round(document.querySelector('.cap-card-body').getBoundingClientRect().width) : null
        };
      })()
    `,
    returnByValue: true
  });

  // Inject fix
  await send('Runtime.evaluate', {
    expression: `
      (() => {
        const style = document.createElement('style');
        style.textContent = \`
          .capability-editorial-card {
            grid-template-columns: minmax(0, 1fr) !important;
          }
          .cap-card-body,
          .cap-card-body > div,
          .cap-card-sidebar,
          .cap-card-title {
            min-width: 0 !important;
            max-width: 100% !important;
          }
        \`;
        document.head.appendChild(style);
      })()
    `
  });

  const after = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const h = document.querySelector('.cap-card-title');
        return {
          hWidth: h ? Math.round(h.getBoundingClientRect().width) : null,
          bodyWidth: document.querySelector('.cap-card-body') ? Math.round(document.querySelector('.cap-card-body').getBoundingClientRect().width) : null
        };
      })()
    `,
    returnByValue: true
  });

  console.log('Before fix:', before.result.result.value);
  console.log('After fix:', after.result.result.value);
  chrome.kill();
}

testMinWidthFix();
