const { spawn } = require('child_process');
const fs = require('fs');

async function captureDesktop() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9222',
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9222/json/list');
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page') || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
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
    await new Promise(r => setTimeout(r, 1200));

    async function capture(filename) {
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      const out = 'C:\\Users\\user\\Desktop\\businessdoctor\\scratch\\' + filename;
      fs.writeFileSync(out, buf);
      console.log(`Saved: ${filename} (${buf.length} bytes)`);
    }

    async function scrollTo(y) {
      await send('Runtime.evaluate', {
        expression: `
          window.scrollTo({ top: ${y}, behavior: 'instant' });
          window.dispatchEvent(new Event('scroll'));
        `
      });
      await new Promise(r => setTimeout(r, 600));
    }

    console.log('Capturing Desktop Beginning (scrollY = 0)...');
    await scrollTo(0);
    await capture('hero_scroll_01_beginning.png');

    console.log('Capturing Desktop Middle (scrollY = 680)...');
    await scrollTo(680);
    await capture('hero_scroll_02_middle.png');

    console.log('Capturing Desktop End (scrollY = 1380)...');
    await scrollTo(1380);
    await capture('hero_scroll_03_end.png');

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function captureMobile() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9223',
    '--window-size=390,844',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch('http://127.0.0.1:9223/json/list');
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page') || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
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
    await new Promise(r => setTimeout(r, 1200));

    async function capture(filename) {
      const shot = await send('Page.captureScreenshot', { format: 'png' });
      const buf = Buffer.from(shot.result.data, 'base64');
      const out = 'C:\\Users\\user\\Desktop\\businessdoctor\\scratch\\' + filename;
      fs.writeFileSync(out, buf);
      console.log(`Saved: ${filename} (${buf.length} bytes)`);
    }

    async function scrollTo(y) {
      await send('Runtime.evaluate', {
        expression: `
          window.scrollTo({ top: ${y}, behavior: 'instant' });
          window.dispatchEvent(new Event('scroll'));
        `
      });
      await new Promise(r => setTimeout(r, 600));
    }

    console.log('Capturing Mobile Beginning (scrollY = 0)...');
    await scrollTo(0);
    await capture('hero_scroll_mobile_01_beginning.png');

    console.log('Capturing Mobile Middle (scrollY = 420)...');
    await scrollTo(420);
    await capture('hero_scroll_mobile_02_middle.png');

    ws.close();
  } finally {
    chrome.kill();
  }
}

async function run() {
  await captureDesktop();
  await captureMobile();
  console.log('ALL SCREENSHOTS CAPTURED CLEANLY!');
}

run().catch(e => {
  console.error(e);
  process.exit(1);
});
