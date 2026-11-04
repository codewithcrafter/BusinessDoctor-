const { spawn } = require('child_process');

async function testRegression() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9535;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    '--window-size=1440,900',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1800));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();
    const errors = [];

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (data.method === 'Runtime.exceptionThrown') {
        errors.push(data.params);
      }
      if (callbacks.has(data.id)) {
        callbacks.get(data.id)(data);
        callbacks.delete(data.id);
      }
    };

    await new Promise(r => ws.onopen = r);

    function send(method, params = {}) {
      return new Promise(resolve => {
        const id = idCounter++;
        callbacks.set(id, resolve);
        ws.send(JSON.stringify({ id, method, params }));
      });
    }

    await send('Page.enable');
    await send('Runtime.enable');
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
    await new Promise(r => setTimeout(r, 2000));

    // Check navbar text
    const navText = await send('Runtime.evaluate', {
      expression: `(() => {
        const item = document.querySelector('.nav-item-dropdown > a, .nav-item-dropdown > button, .nav-link-services');
        const itItem = Array.from(document.querySelectorAll('.nav-menu a, .nav-menu button')).find(el => el.textContent.includes('IT Services'));
        return itItem ? itItem.textContent.trim() : 'NOT_FOUND';
      })()`
    });

    // Check tab arrows
    const arrows = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `(() => {
        const prev = document.getElementById('capNavPrev');
        const next = document.getElementById('capNavNext');
        return { prev: !!prev, next: !!next };
      })()`
    });

    // Check 5 section eyebrow labels (must have NO numbers)
    const eyebrows = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `(() => {
        return Array.from(document.querySelectorAll('.eyebrow-badge span:last-child')).map(s => s.textContent.trim());
      })()`
    });

    console.log('Nav item:', navText.result.result.value);
    console.log('Tab arrows present:', arrows.result.result.value);
    console.log('Eyebrows:', eyebrows.result.result.value);
    console.log('Console errors count:', errors.length);

    // Now check about.php for Mission & Vision
    await send('Page.navigate', { url: 'http://127.0.0.1:8000/about.php' });
    await new Promise(r => setTimeout(r, 1500));
    const aboutCheck = await send('Runtime.evaluate', {
      returnByValue: true,
      expression: `(() => {
        const mv = document.getElementById('missionVision');
        const cards = mv ? mv.querySelectorAll('.mv-card').length : 0;
        return { hasMissionVision: !!mv, cardsCount: cards };
      })()`
    });
    console.log('About page Mission & Vision:', aboutCheck.result.result.value);

    ws.close();
  } catch (err) {
    console.error(err);
  } finally {
    chrome.kill();
  }
}

testRegression();
