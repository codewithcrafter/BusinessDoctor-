const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
  const browser = await puppeteer.launch({ headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 1920, height: 1080 });
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'networkidle0' });

  // Scroll to 85% of hero to see vital ticker
  const heroHeight = await page.evaluate(() => {
    const hero = document.getElementById('heroScrollTrack');
    return hero ? hero.offsetHeight - window.innerHeight : 1000;
  });

  await page.evaluate((y) => window.scrollTo(0, y), heroHeight * 0.85);
  await new Promise(r => setTimeout(r, 600));

  await page.screenshot({ path: 'scratch/current_vital_ticker_1920.png' });
  console.log('Screenshot taken at 85% hero scroll');
  await browser.close();
})();

