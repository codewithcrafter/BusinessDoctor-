const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const outDir = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\section_mod_proofs\\after';

async function captureTransition() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9565;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--disable-extensions',
    `--remote-debugging-port=${port}`,
    'http://localhost/businessdoctor/services/web-software-development'
  ]);

  try {
    await new Promise(r => setTimeout(r, 1500));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages[0];
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
    await send('Emulation.setDeviceMetricsOverride', {
      width: 1440,
      height: 900,
      deviceScaleFactor: 1,
      mobile: false
    });

    const clipRes = await send('Runtime.evaluate', {
      expression: `(() => {
        const ind = document.getElementById('industry-use-cases');
        const faq = document.getElementById('faq');
        if (!ind || !faq) return null;
        const rInd = ind.getBoundingClientRect();
        const rFaq = faq.getBoundingClientRect();
        
        const top = rInd.bottom + window.scrollY - 150;
        const height = (rFaq.top + window.scrollY + 250) - top;
        return {
          x: 0,
          y: Math.max(0, top),
          width: 1440,
          height: Math.min(1200, height)
        };
      })()`,
      returnByValue: true
    });

    if (clipRes.result && clipRes.result.result && clipRes.result.result.value) {
      const clip = clipRes.result.result.value;
      const shot = await send('Page.captureScreenshot', {
        format: 'png',
        clip: { x: clip.x, y: clip.y, width: clip.width, height: clip.height, scale: 1 }
      });
      const dest = path.join(outDir, 'web-software-development_gap_transition_after.png');
      fs.writeFileSync(dest, Buffer.from(shot.result.data, 'base64'));
      console.log('[Saved] web-software-development_gap_transition_after.png');
    }

    ws.close();
  } finally {
    chrome.kill();
  }
}

captureTransition().catch(console.error);
