const http = require('http');

async function run() {
  // Check if Chrome debugging port is open or launch headless chrome with remote debugging
  const { exec, spawn } = require('child_process');
  
  // Launch Chrome with remote debugging
  const chromeProcess = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--remote-debugging-port=9222',
    '--disable-gpu',
    '--no-sandbox',
    'http://localhost/businessdoctor/services/web-software-development'
  ]);

  // wait 1.5s
  await new Promise(r => setTimeout(r, 1500));

  // Get websocket debugger URL
  http.get('http://127.0.0.1:9222/json', (res) => {
    let data = '';
    res.on('data', chunk => data += chunk);
    res.on('end', async () => {
      const targets = JSON.parse(data);
      const pageTarget = targets.find(t => t.type === 'page');
      if (!pageTarget) {
        console.log('No page target found');
        chromeProcess.kill();
        return;
      }
      
      const ws = new WebSocket(pageTarget.webSocketDebuggerUrl);
      let id = 1;
      const send = (method, params = {}) => new Promise((resolve) => {
        const msgId = id++;
        const handler = (evt) => {
          const msg = JSON.parse(evt.data);
          if (msg.id === msgId) {
            ws.removeEventListener('message', handler);
            resolve(msg.result);
          }
        };
        ws.addEventListener('message', handler);
        ws.send(JSON.stringify({ id: msgId, method, params }));
      });

      ws.onopen = async () => {
        // Set viewport to 1920x1080
        await send('Emulation.setDeviceMetricsOverride', {
          width: 1920,
          height: 1080,
          deviceScaleFactor: 1,
          mobile: false
        });

        // Evaluate layout metrics
        const evalResult = await send('Runtime.evaluate', {
          expression: `(() => {
            const results = {};
            const hero = document.querySelector('#overview');
            const intro = document.querySelector('#introduction');
            const cases = document.querySelector('#case-studies');

            function getInfo(el) {
              if (!el) return null;
              const rect = el.getBoundingClientRect();
              const container = el.querySelector('.srv-container');
              const cRect = container ? container.getBoundingClientRect() : null;
              const row = el.querySelector('.srv-row');
              const cols = row ? Array.from(row.children).map(c => {
                const cr = c.getBoundingClientRect();
                return {
                  className: c.className,
                  left: Math.round(cr.left),
                  right: Math.round(cr.right),
                  width: Math.round(cr.width),
                  height: Math.round(cr.height)
                };
              }) : [];
              return {
                left: Math.round(rect.left),
                right: Math.round(rect.right),
                width: Math.round(rect.width),
                container: cRect ? {
                  left: Math.round(cRect.left),
                  right: Math.round(cRect.right),
                  width: Math.round(cRect.width)
                } : null,
                cols
              };
            }

            // check case study buttons
            const caseBtns = Array.from(document.querySelectorAll('.srv-case-card')).map(card => {
              const btn = card.querySelector('.srv-case-action a');
              const span = btn ? btn.querySelector('span') : null;
              const svg = btn ? btn.querySelector('svg') : null;
              const cardRect = card.getBoundingClientRect();
              const btnRect = btn ? btn.getBoundingClientRect() : null;
              return {
                cardHeight: Math.round(cardRect.height),
                btnTopRelativeToCard: btnRect ? Math.round(btnRect.top - cardRect.top) : null,
                btnWidth: btnRect ? Math.round(btnRect.width) : null,
                btnHeight: btnRect ? Math.round(btnRect.height) : null,
                spanText: span ? span.textContent.trim() : null,
                spanWidth: span ? Math.round(span.getBoundingClientRect().width) : null,
                svgLeft: svg ? Math.round(svg.getBoundingClientRect().left) : null,
                btnLeft: btnRect ? Math.round(btnRect.left) : null,
                btnRight: btnRect ? Math.round(btnRect.right) : null,
              };
            });

            return {
              hero: getInfo(hero),
              intro: getInfo(intro),
              caseBtns,
              windowWidth: window.innerWidth,
              documentWidth: document.documentElement.scrollWidth
            };
          })()`,
          returnByValue: true
        });

        console.log(JSON.stringify(evalResult.result.value, null, 2));

        ws.close();
        chromeProcess.kill();
      };
    });
  });
}

run();
