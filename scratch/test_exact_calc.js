const { spawn } = require('child_process');

async function testExact() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--remote-debugging-port=9993',
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9993/json/list');
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
            const wrapper = document.querySelector('.capabilities-nav-wrapper');
            const bar = document.getElementById('capabilitiesNavBar');
            const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
            const prev = document.getElementById('capNavPrev');
            const next = document.getElementById('capNavNext');

            // Test setting exact width for tabs 0..3 (4 tabs)
            const k = 3; // tab 4
            const padRight = parseFloat(getComputedStyle(bar).paddingRight) || 8;
            const borderRight = parseFloat(getComputedStyle(bar).borderRightWidth) || 1;
            const exactW = Math.ceil(btns[k].offsetLeft + btns[k].offsetWidth + padRight + borderRight);
            
            bar.style.maxWidth = exactW + 'px';
            bar.style.width = exactW + 'px';

            const barR = bar.getBoundingClientRect();
            const tab4R = btns[3].getBoundingClientRect();
            const tab5R = btns[4].getBoundingClientRect();

            return {
              exactW,
              barRight: Math.round(barR.right),
              tab4Right: Math.round(tab4R.right),
              tab5Left: Math.round(tab5R.left),
              isTab4Inside: tab4R.right <= barR.right,
              tab4MarginToEdge: Math.round(barR.right - tab4R.right),
              isTab5Outside: tab5R.left >= barR.right
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

testExact();

