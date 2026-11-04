const { spawn } = require('child_process');

async function testStepByStep() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--remote-debugging-port=9996',
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9996/json/list');
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
            const tabBtns = document.querySelectorAll('.cap-tab-btn[data-target]');
            const capNavNext = document.getElementById('capNavNext');

            capNavBar.style.maxWidth = '';
            capNavBar.style.width = 'auto';

            const wrapperWidth = capNavWrapper.clientWidth;
            const btns = Array.from(tabBtns);
            const arrowWidth = capNavNext ? capNavNext.offsetWidth : 44;
            const arrowGap = parseFloat(getComputedStyle(capNavWrapper).gap) || 10;
            const arrowReserve = (arrowWidth + arrowGap) * 2;
            const maxAvailable = wrapperWidth - arrowReserve;

            const barStyle = getComputedStyle(capNavBar);
            const padX = (parseFloat(barStyle.paddingLeft) || 8) + (parseFloat(barStyle.paddingRight) || 8);
            const borderX = (parseFloat(barStyle.borderLeftWidth) || 1) + (parseFloat(barStyle.borderRightWidth) || 1);

            const firstOffset = btns[0].offsetLeft;
            const steps = btns.map((b, i) => {
              const relLeft = b.offsetLeft - firstOffset;
              const reqW = Math.ceil(relLeft + b.offsetWidth + padX + borderX);
              return { i, text: b.innerText.trim(), offsetLeft: b.offsetLeft, relLeft, offsetWidth: b.offsetWidth, reqW, fits: reqW <= maxAvailable };
            });

            const reqW = steps[3].reqW; // 981
            capNavBar.style.maxWidth = reqW + 'px';
            capNavBar.style.width = reqW + 'px';

            const barR = capNavBar.getBoundingClientRect();
            const tabStates = btns.map((b, i) => {
              const r = b.getBoundingClientRect();
              return {
                i: i + 1,
                text: b.innerText.replace(/\\s+/g, ' ').trim(),
                left: Math.round(r.left),
                right: Math.round(r.right),
                isClippedRight: r.right > barR.right + 2 && r.left < barR.right - 2,
                fullyVisible: r.right <= barR.right + 2 && r.left >= barR.left - 2
              };
            });

            return {
              barR: { left: Math.round(barR.left), right: Math.round(barR.right), width: Math.round(barR.width) },
              tabStates
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

testStepByStep();
