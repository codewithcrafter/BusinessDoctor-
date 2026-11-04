const http = require('http');

http.get('http://127.0.0.1:9222/json', (res) => {
  let data = '';
  res.on('data', chunk => data += chunk);
  res.on('end', () => {
    const list = JSON.parse(data);
    const target = list.find(t => t.url.includes('8000'));
    if (!target) {
      console.log('No 8000 target found in list:', list.map(t => t.url));
      process.exit(1);
    }
    const ws = new WebSocket(target.webSocketDebuggerUrl);
    ws.onopen = () => {
      ws.send(JSON.stringify({
        id: 1,
        method: 'Runtime.evaluate',
        params: {
          expression: `(() => {
            window.scrollTo(0, 0);
            const h1 = document.querySelector(".hero-headline-oversized");
            const ed = document.querySelector("#heroEditorialLayer");
            const nav = document.querySelector(".site-header");
            const stage = document.querySelector(".hero-sticky-stage");
            const viewport = document.querySelector("#heroAnimViewport");
            return {
              windowScrollY: window.scrollY,
              navHeight: nav ? nav.offsetHeight : null,
              h1Rect: h1 ? h1.getBoundingClientRect() : null,
              edRect: ed ? ed.getBoundingClientRect() : null,
              stageRect: stage ? stage.getBoundingClientRect() : null,
              viewportRect: viewport ? viewport.getBoundingClientRect() : null,
              edTransform: ed ? ed.style.transform : null
            };
          })()`,
          returnByValue: true
        }
      }));
    };
    ws.onmessage = (event) => {
      const resp = JSON.parse(event.data);
      console.log('Result:', JSON.stringify(resp.result?.result?.value, null, 2));
      process.exit(0);
    };
    ws.onerror = (err) => {
      console.error('WS Error:', err);
      process.exit(1);
    };
  });
}).on('error', (err) => {
  console.log('HTTP Error:', err.message);
  process.exit(1);
});
