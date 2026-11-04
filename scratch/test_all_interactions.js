const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const artifactBase = 'C:\\Users\\user\\.gemini\\antigravity\\brain\\18684505-2438-4107-b6f3-8223edf48149\\responsive_audit_screenshots';

async function testInteractions() {
  const port = 9960;
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
  const page = pagesList.find(p => p.type === 'page' && !p.url.startsWith('chrome-extension')) || pagesList[0];
  const ws = new WebSocket(page.webSocketDebuggerUrl);

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

  await new Promise(r => ws.onopen = r);
  await send('Network.enable');
  await send('Page.enable');
  await send('Runtime.enable');

  const interactionLog = [];

  console.log('=== STARTING INTERACTION TESTING ===\n');

  // TEST 1: Mobile Navigation Drawer (390x844)
  console.log('Test 1: Mobile Drawer Open / Close (390x844)');
  await send('Emulation.setDeviceMetricsOverride', { width: 390, height: 844, deviceScaleFactor: 2, mobile: true });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
  await new Promise(r => setTimeout(r, 800));

  const drawerTest = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const btn = document.getElementById('menuToggleBtn');
        const drawer = document.getElementById('mobileDrawer');
        if (!btn || !drawer) return { success: false, reason: 'Elements not found' };

        // Initial state
        const initialClosed = !drawer.classList.contains('open');

        // Click to open
        btn.click();
        const afterOpen = drawer.classList.contains('open');

        // Check links inside drawer
        const links = Array.from(drawer.querySelectorAll('a')).map(a => ({ text: a.innerText.trim(), href: a.getAttribute('href') }));

        // Click to close
        btn.click();
        const afterClose = !drawer.classList.contains('open');

        return {
          success: initialClosed && afterOpen && afterClose,
          initialClosed,
          afterOpen,
          afterClose,
          linksCount: links.length,
          hasBlogLink: links.some(l => l.text.toLowerCase().includes('blog'))
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Mobile Navigation Drawer', result: drawerTest.result.result.value });
  console.log('  Result:', drawerTest.result.result.value);

  // TEST 2: Desktop Mega Menu (1440x900)
  console.log('\nTest 2: Desktop Mega Menu Hover / State (1440x900)');
  await send('Emulation.setDeviceMetricsOverride', { width: 1440, height: 900, deviceScaleFactor: 1, mobile: false });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
  await new Promise(r => setTimeout(r, 800));

  const megaTest = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const megaItem = document.querySelector('.nav-item.has-mega-menu');
        const megaMenu = document.querySelector('.mega-menu');
        if (!megaItem || !megaMenu) return { success: false, reason: 'Mega menu elements not found' };

        // Mouseenter
        megaItem.dispatchEvent(new MouseEvent('mouseenter', { bubbles: true }));
        const serviceLinks = Array.from(megaMenu.querySelectorAll('.mega-service-item')).map(a => a.innerText.trim());

        return {
          success: true,
          serviceLinksCount: serviceLinks.length,
          serviceLinks
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Desktop Mega Menu', result: megaTest.result.result.value });
  console.log('  Result:', megaTest.result.result.value);

  // TEST 3: Capabilities Service Tabs & Arrows (1440x900 and 390x844)
  console.log('\nTest 3: Service Category Tabs & Navigation Arrows (1440x900 & 390x844)');
  await send('Emulation.setDeviceMetricsOverride', { width: 1440, height: 900, deviceScaleFactor: 1, mobile: false });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/' });
  await new Promise(r => setTimeout(r, 800));

  const tabTest1440 = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const track = document.getElementById('capabilitiesNavBar') || document.querySelector('.capabilities-nav-bar');
        const next = document.getElementById('capNavNext');
        const prev = document.getElementById('capNavPrev');
        const tabs = Array.from(document.querySelectorAll('.cap-tab-btn'));
        const panes = Array.from(document.querySelectorAll('.cap-tab-pane'));
        if (!track || !next || !prev || tabs.length === 0) return { success: false, reason: 'Elements missing' };

        // Test tab switching
        const initialActivePane = document.querySelector('.cap-tab-pane.active').id;
        tabs[1].click(); // Click tab 2
        const afterClickPane = document.querySelector('.cap-tab-pane.active').id;

        // Test next arrow scroll
        const initialScroll = track.scrollLeft;
        next.click();
        const afterScroll = track.scrollLeft;

        return {
          success: true,
          tabsCount: tabs.length,
          panesCount: panes.length,
          initialActivePane,
          afterClickPane,
          tabSwitchWorked: initialActivePane !== afterClickPane,
          tabLabels: tabs.map(t => t.innerText.trim().replace(/\\s+/g, ' '))
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Service Tabs 1440px', result: tabTest1440.result.result.value });
  console.log('  Result (1440px):', tabTest1440.result.result.value);

  // TEST 4: Benefits Accordion and Dynamic Graphs (1440x900 and 390x844)
  console.log('\nTest 4: Benefits Accordion Expand / Collapse & Dynamic Graphs');
  const accordionTest = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const triggers = Array.from(document.querySelectorAll('.benefits-accordion-trigger'));
        const items = Array.from(document.querySelectorAll('.benefits-accordion-item'));
        const graphStage = document.getElementById('benefitGraphContainer') || document.querySelector('.benefits-graph-container, .benefit-graph-card, .benefits-graph-column');
        if (triggers.length === 0) return { success: false, reason: 'Accordion triggers not found' };

        // Initial active
        const initialActiveIndex = items.findIndex(it => it.classList.contains('active'));

        // Click trigger 2
        triggers[1].click();
        const afterClickActiveIndex = items.findIndex(it => it.classList.contains('active'));

        return {
          success: true,
          totalAccordionItems: triggers.length,
          initialActiveIndex,
          afterClickActiveIndex,
          toggleWorked: afterClickActiveIndex === 1,
          graphStageFound: !!graphStage
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Benefits Accordion', result: accordionTest.result.result.value });
  console.log('  Result:', accordionTest.result.result.value);

  // TEST 5: Tools Filter Tabs (1440x900)
  console.log('\nTest 5: Tools Section Category Filter Buttons');
  const toolsFilterTest = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const filterBtns = Array.from(document.querySelectorAll('.tool-filter-btn'));
        const allCards = Array.from(document.querySelectorAll('.tool-card'));
        if (filterBtns.length === 0 || allCards.length === 0) return { success: false, reason: 'Tools elements missing' };

        // Click analytics filter
        const analyticsBtn = filterBtns.find(b => b.getAttribute('data-filter') === 'analytics');
        if (analyticsBtn) analyticsBtn.click();

        const visibleAfterFilter = allCards.filter(c => window.getComputedStyle(c).display !== 'none');

        // Click all
        const allBtn = filterBtns.find(b => b.getAttribute('data-filter') === 'all');
        if (allBtn) allBtn.click();
        const visibleAfterAll = allCards.filter(c => window.getComputedStyle(c).display !== 'none');

        return {
          filterButtonsCount: filterBtns.length,
          totalCards: allCards.length,
          filteredCount: visibleAfterFilter.length,
          restoredCount: visibleAfterAll.length,
          works: visibleAfterFilter.length < allCards.length && visibleAfterAll.length === allCards.length
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Tools Filter Buttons', result: toolsFilterTest.result.result.value });
  console.log('  Result:', toolsFilterTest.result.result.value);

  // TEST 6: Audit / Diagnostic Form (audit.php at 390x844)
  console.log('\nTest 6: Digital Audit Interactive Diagnostic Form (audit.php at 390x844)');
  await send('Emulation.setDeviceMetricsOverride', { width: 390, height: 844, deviceScaleFactor: 2, mobile: true });
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/audit.php' });
  await new Promise(r => setTimeout(r, 800));

  const formTest = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const form = document.getElementById('auditForm') || document.querySelector('form');
        const inputs = Array.from(document.querySelectorAll('input, select, textarea'));
        const submitBtn = document.querySelector('button[type="submit"], input[type="submit"], .btn-primary');
        return {
          formFound: !!form,
          inputsCount: inputs.length,
          submitBtnFound: !!submitBtn,
          inputNames: inputs.map(i => i.name || i.id).filter(Boolean)
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Audit Form Structure', result: formTest.result.result.value });
  console.log('  Result:', formTest.result.result.value);

  // TEST 7: Contact Form (contact.php at 390x844)
  console.log('\nTest 7: Contact Form Fields & Layout (contact.php at 390x844)');
  await send('Page.navigate', { url: 'http://127.0.0.1:8000/contact.php' });
  await new Promise(r => setTimeout(r, 800));

  const contactTest = await send('Runtime.evaluate', {
    expression: `
      (() => {
        const form = document.querySelector('form');
        const inputs = Array.from(document.querySelectorAll('input, select, textarea'));
        const submitBtn = document.querySelector('button[type="submit"], .btn-primary');
        return {
          formFound: !!form,
          inputsCount: inputs.length,
          submitBtnFound: !!submitBtn,
          inputNames: inputs.map(i => i.name || i.id).filter(Boolean)
        };
      })()
    `,
    returnByValue: true
  });
  interactionLog.push({ test: 'Contact Form Structure', result: contactTest.result.result.value });
  console.log('  Result:', contactTest.result.result.value);

  fs.writeFileSync(
    path.join(artifactBase, 'interaction_results.json'),
    JSON.stringify(interactionLog, null, 2)
  );

  console.log('\n=== ALL INTERACTION TESTS COMPLETED ===');
  chrome.kill();
}

testInteractions().catch(err => {
  console.error('Interaction test failed:', err);
  process.exit(1);
});
