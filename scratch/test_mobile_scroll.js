const { spawn } = require('child_process');

async function testMobileScroll() {
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    '--remote-debugging-port=9997',
    '--window-size=390,844',
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 2000));
  const res = await fetch('http://127.0.0.1:9997/json/list');
  const pages = await res.json();
  const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  function send(method, params = {}) {
    return new Promise(resolve => {
      const id = Math.floor(Math.random() * 100000);
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
  await send('Network.setCacheDisabled', { cacheDisabled: true });
  await send('Page.enable');
  await send('Runtime.enable');

  // Scroll to #capabilities
  await send('Runtime.evaluate', { expression: `document.getElementById('capabilities').scrollIntoView();` });
  await new Promise(r => setTimeout(r, 400));

  console.log('Testing clicks on 390px:');
  for (let c = 1; c <= 6; c++) {
    const res = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const bar = document.getElementById('capabilitiesNavBar');
          const next = document.getElementById('capNavNext');
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const barR = bar.getBoundingClientRect();
          
          let target = null;
          let targetIdx = -1;
          for (let i = 0; i < btns.length; i++) {
            if (btns[i].getBoundingClientRect().left > barR.left + 40) {
              target = btns[i];
              targetIdx = i;
              break;
            }
          }

          if (target) {
            target.scrollIntoView({ behavior: 'smooth', inline: targetIdx === btns.length - 1 ? 'end' : 'start', block: 'nearest' });
          }

          return {
            targetIdx,
            scrollLeft: bar.scrollLeft,
            maxScroll: bar.scrollWidth - bar.clientWidth
          };
        })()
      `,
      returnByValue: true
    });

    console.log(`Step ${c}:`, JSON.stringify(res.result.result.value));
    await new Promise(r => setTimeout(r, 600));

    // Check position after scroll
    const check = await send('Runtime.evaluate', {
      expression: `
        (() => {
          const bar = document.getElementById('capabilitiesNavBar');
          const barR = bar.getBoundingClientRect();
          const btns = Array.from(document.querySelectorAll('.cap-tab-btn'));
          const tab6 = btns[5];
          const tab6R = tab6.getBoundingClientRect();
          return {
            scrollLeft: Math.round(bar.scrollLeft),
            maxScroll: Math.round(bar.scrollWidth - bar.clientWidth),
            tab6Right: Math.round(tab6R.right),
            barRight: Math.round(barR.right),
            tab6FullyVisible: tab6R.right <= barR.right + 2 && tab6R.left >= barR.left - 2
          };
        })()
      `,
      returnByValue: true
    });
    console.log(`After scroll ${c}:`, JSON.stringify(check.result.result.value));
    if (check.result.result.value.tab6FullyVisible) {
      console.log('SUCCESS: Tab 6 fully visible!');
      break;
    }
  }

  chrome.kill();
  process.exit();
}

testMobileScroll();
