const { spawn } = require('child_process');

async function debugCalc() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--remote-debugging-port=9992',
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9992/json/list');
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
            const capNavWrapper = document.querySelector('.capabilities-nav-wrapper');
            const capNavBar = document.getElementById('capabilitiesNavBar');
            const tabBtns = Array.from(document.querySelectorAll('.cap-tab-btn'));
            const widths = tabBtns.map(b => b.offsetWidth);
            const barStyle = getComputedStyle(capNavBar);
            const padX = (parseFloat(barStyle.paddingLeft) || 8) + (parseFloat(barStyle.paddingRight) || 8);
            const gapX = parseFloat(barStyle.gap) || 8;
            const wrapperWidth = capNavWrapper.clientWidth;
            const arrowWidth = 44;
            const arrowGap = parseFloat(getComputedStyle(capNavWrapper).gap) || 10;
            const arrowReserve = (arrowWidth + arrowGap) * 2;
            const maxAvailable = wrapperWidth - arrowReserve;

            return {
              wrapperWidth,
              arrowReserve,
              maxAvailable,
              widths,
              padX,
              gapX,
              tab1_4_sum: widths.slice(0, 4).reduce((a, b) => a + b, 0) + 3 * gapX + padX,
              tab1_5_sum: widths.slice(0, 5).reduce((a, b) => a + b, 0) + 4 * gapX + padX,
              currentStyleMaxWidth: capNavBar.style.maxWidth,
              currentClientWidth: capNavBar.clientWidth
            };
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

debugCalc();

