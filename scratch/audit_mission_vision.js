const { spawn } = require('child_process');
const fs = require('fs');

async function runAudit() {
  console.log('--- STARTING COMPREHENSIVE AUDIT ---');

  // 1. Check index.php DOM source for Mission & Vision statements and duplication
  const indexHtml = fs.readFileSync('index.php', 'utf8');

  // Statements verification
  const missionTarget = 'To engineer reliable digital solutions that simplify business operations, strengthen performance, and accelerate sustainable growth.';
  const visionTarget = 'To become a trusted technology and digital growth partner for businesses by combining engineering excellence, innovation, and measurable outcomes.';

  console.log('\n[1. STATEMENT COMPLETENESS]');
  console.log('Mission Statement in index.php:', indexHtml.includes(missionTarget) ? 'EXACT MATCH FOUND' : 'MISMATCH');
  console.log('Vision Statement in index.php:', indexHtml.includes(visionTarget) ? 'EXACT MATCH FOUND' : 'MISMATCH');

  // Duplication check in index.php
  console.log('\n[3. DUPLICATION CHECK ON HOMEPAGE]');
  const countOccurrences = (str, pattern) => (str.match(new RegExp(pattern, 'g')) || []).length;

  console.log('Occurrences of "450+":', countOccurrences(indexHtml, '450\\+'));
  console.log('Occurrences of "48M+":', countOccurrences(indexHtml, '48M\\+'));
  console.log('Occurrences of "98.4%":', countOccurrences(indexHtml, '98\\.4%'));
  console.log('Occurrences of "3.8x":', countOccurrences(indexHtml, '3\\.8x'));
  console.log('Occurrences of "vitalTicker":', countOccurrences(indexHtml, 'vitalTicker'));
  console.log('Occurrences of "heroVitalDock":', countOccurrences(indexHtml, 'heroVitalDock'));

  // 2. Search codebase for source of numerical figures
  console.log('\n[4 & 5. SOURCE INVESTIGATION ACROSS PROJECT]');
  const allPhpFiles = fs.readdirSync('.').filter(f => f.endsWith('.php'));
  const includesFiles = fs.readdirSync('includes').filter(f => f.endsWith('.php')).map(f => 'includes/' + f);
  const searchFiles = [...allPhpFiles, ...includesFiles];

  ['450', '48', '98.4', '3.8'].forEach(num => {
    console.log(`\nSearching origin for claim containing "${num}":`);
    searchFiles.forEach(file => {
      const content = fs.readFileSync(file, 'utf8');
      const lines = content.split('\n');
      lines.forEach((l, idx) => {
        if (l.includes(num) && (l.includes('Project') || l.includes('Revenue') || l.includes('Retention') || l.includes('ROAS') || l.includes('case') || l.includes('data-count') || l.includes('db') || l.includes('sql') || l.includes('analytics'))) {
          console.log(`  ${file}:${idx + 1}: ${l.trim().slice(0, 100)}`);
        }
      });
    });
  });

  // 3. Browser runtime testing (Console errors, Counter completion, Reduced-Motion)
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const port = 9260;
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    `--remote-debugging-port=${port}`,
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  try {
    await new Promise(r => setTimeout(r, 2000));
    const res = await fetch(`http://127.0.0.1:${port}/json/list`);
    const pages = await res.json();
    const page = pages.find(p => p.type === 'page') || pages[0];

    const ws = new WebSocket(page.webSocketDebuggerUrl);
    let idCounter = 1;
    const callbacks = new Map();
    const consoleLogs = [];
    const pageErrors = [];

    ws.onmessage = (evt) => {
      const data = JSON.parse(evt.data);
      if (data.method === 'Runtime.consoleAPICalled') {
        consoleLogs.push(data.params);
      }
      if (data.method === 'Runtime.exceptionThrown') {
        pageErrors.push(data.params);
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
    await send('Log.enable');

    // Scroll to stats strip to trigger animations
    await send('Runtime.evaluate', {
      expression: `
        (function() {
          const stats = document.getElementById('vitalTicker');
          if (stats) stats.scrollIntoView({ behavior: 'instant', block: 'center' });
        })()
      `
    });

    // Wait 2s for number animation to finish
    await new Promise(r => setTimeout(r, 2000));

    // Check final counter values
    const counterValuesRes = await send('Runtime.evaluate', {
      expression: `
        (function() {
          const numbers = Array.from(document.querySelectorAll('.vital-number')).map(n => n.innerText.trim());
          const labels = Array.from(document.querySelectorAll('.vital-label')).map(l => l.innerText.trim());
          const missionText = document.querySelector('.mv-panel-mission .mv-statement').innerText.trim();
          const visionText = document.querySelector('.mv-panel-vision .mv-statement').innerText.trim();
          return { numbers, labels, missionText, visionText };
        })()
      `,
      returnByValue: true
    });

    console.log('\n[6. BROWSER RUNTIME NUMBER COUNTERS]');
    const runtimeVal = counterValuesRes.result && counterValuesRes.result.result && counterValuesRes.result.result.value;
    if (runtimeVal) {
      console.log('Counters reached values:', runtimeVal.numbers);
      console.log('Labels rendered:', runtimeVal.labels);
    }

    // Test reduced-motion
    console.log('\n[7. ACCESSIBILITY & CONSOLE ERRORS]');
    await send('Emulation.setEmulatedMedia', {
      features: [{ name: 'prefers-reduced-motion', value: 'reduce' }]
    });

    const reducedMotionCheck = await send('Runtime.evaluate', {
      expression: `
        (function() {
          const isReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          const panel = document.querySelector('.mv-panel');
          const panelStyle = window.getComputedStyle(panel);
          const item = document.querySelector('.vital-item');
          const itemStyle = window.getComputedStyle(item);
          return {
            mediaQueryMatches: isReduced,
            panelTransition: panelStyle.transition,
            itemTransition: itemStyle.transition,
            itemOpacity: itemStyle.opacity
          };
        })()
      `,
      returnByValue: true
    });

    const rmVal = reducedMotionCheck.result && reducedMotionCheck.result.result && reducedMotionCheck.result.result.value;
    console.log('prefers-reduced-motion active:', rmVal && rmVal.mediaQueryMatches);
    console.log('Panel transition under reduced motion:', rmVal && rmVal.panelTransition);
    console.log('Item transition under reduced motion:', rmVal && rmVal.itemTransition);
    console.log('Browser console errors caught:', pageErrors.length === 0 ? '0 ERRORS (CLEAN)' : pageErrors);

    ws.close();
  } finally {
    chrome.kill();
  }
}

runAudit();

