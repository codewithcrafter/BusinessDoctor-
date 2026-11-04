const { spawn } = require('child_process');

const urls = [
  'http://127.0.0.1:8000/index.php',
  'http://127.0.0.1:8000/about.php',
  'http://127.0.0.1:8000/services.php',
  'http://127.0.0.1:8000/service-detail.php?slug=web-software-development',
  'http://127.0.0.1:8000/audit.php',
  'http://127.0.0.1:8000/diagnostic.php',
  'http://127.0.0.1:8000/case-studies.php',
  'http://127.0.0.1:8000/case-study-detail.php?slug=d2c-apparel-vital-infrastructure-overhaul',
  'http://127.0.0.1:8000/insights.php',
  'http://127.0.0.1:8000/insight-detail.php?slug=brand-architecture-as-risk-mitigation',
  'http://127.0.0.1:8000/blog.php',
  'http://127.0.0.1:8000/blog-detail.php?slug=brand-architecture-as-risk-mitigation',
  'http://127.0.0.1:8000/contact.php'
];

async function checkConsoleAndNetwork() {
  const port = 9962;
  const chrome = spawn('C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe', [
    '--headless=new',
    '--incognito',
    '--disable-cache',
    `--remote-debugging-port=${port}`,
    'http://127.0.0.1:8000/'
  ]);

  await new Promise(r => setTimeout(r, 1500));
  const res = await fetch(`http://127.0.0.1:${port}/json/list`);
  const pagesList = await res.json();
  const page = pagesList[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

  const errors = [];
  const networkFailures = [];

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

  ws.onmessage = (evt) => {
    const data = JSON.parse(evt.data);
    if (data.method === 'Runtime.consoleAPICalled') {
      if (data.params.type === 'error') {
        errors.push({ type: 'console.error', args: data.params.args });
      }
    } else if (data.method === 'Runtime.exceptionThrown') {
      errors.push({ type: 'exception', details: data.params.exceptionDetails });
    } else if (data.method === 'Network.responseReceived') {
      if (data.params.response.status >= 400) {
        networkFailures.push({ url: data.params.response.url, status: data.params.response.status });
      }
    }
  };

  await new Promise(r => ws.onopen = r);
  await send('Network.enable');
  await send('Page.enable');
  await send('Runtime.enable');

  for (const u of urls) {
    await send('Page.navigate', { url: u });
    await new Promise(r => setTimeout(r, 400));
  }

  console.log('Console Errors:', errors);
  console.log('Network Failures:', networkFailures);
  chrome.kill();
}

checkConsoleAndNetwork();
