const http = require('http');
const { spawn } = require('child_process');
const fs = require('fs');

async function run() {
  const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
  const chrome = spawn(chromePath, [
    '--headless=new',
    '--disable-gpu',
    '--remote-debugging-port=9222',
    '--window-size=1920,1080',
    'http://127.0.0.1:8000/'
  ]);

  // Wait for Chrome to start
  await new Promise(r => setTimeout(r, 1500));

  // Get WebSocket URL
  const versionData = await new Promise((resolve, reject) => {
    http.get('http://127.0.0.1:9222/json/list', res => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => resolve(JSON.parse(data)));
    }).on('error', reject);
  });

  const page = versionData[0];
  const wsUrl = page.webSocketDebuggerUrl;

  const ws = new (require('ws')) ? null : null; // wait, let's see if ws module exists
}

