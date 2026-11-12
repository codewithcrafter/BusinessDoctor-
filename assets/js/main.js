/**
 * BusinessDoctor Enterprise JavaScript Suite
 * Sticky Navigation, Services Mega Menu, Capabilities Tab Explorer, & Micro-Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Sticky Header with Scroll Shadow Treatment
  const header = document.querySelector('.site-header');
  if (header) {
    const handleScroll = () => {
      if (window.scrollY > 20) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  // 2. Mobile Drawer Navigation & Accordion Controller
  const menuToggle = document.getElementById('menuToggleBtn') || document.querySelector('.menu-toggle');
  const mobileDrawer = document.getElementById('mobileDrawer') || document.querySelector('.mobile-drawer');
  const drawerBackdrop = document.getElementById('mobileDrawerBackdrop');
  const drawerCloseBtn = document.getElementById('mobileDrawerCloseBtn');
  const servicesToggle = document.getElementById('mobileServicesToggle');
  const servicesAccordion = document.getElementById('mobileServicesAccordion');
  const drawerScrollBody = document.getElementById('mobileDrawerScrollBody') || (mobileDrawer ? mobileDrawer.querySelector('.mobile-drawer-scroll-body') : null);

  let savedPageScrollY = 0;

  function openMobileDrawer() {
    if (!mobileDrawer) return;

    // 1. Record current scroll offset before lock
    savedPageScrollY = window.scrollY || window.pageYOffset || 0;

    // 2. Reset drawer scroll position to 0 so "Home" is always at the top
    if (drawerScrollBody) {
      drawerScrollBody.scrollTop = 0;
    }
    mobileDrawer.scrollTop = 0;

    // 3. Open drawer and backdrop
    mobileDrawer.classList.add('open');
    if (drawerBackdrop) drawerBackdrop.classList.add('open');

    // 4. Update aria attributes and toggle icon
    if (menuToggle) {
      menuToggle.setAttribute('aria-expanded', 'true');
      menuToggle.setAttribute('aria-label', 'Close mobile navigation menu');
      menuToggle.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    }
    mobileDrawer.setAttribute('aria-hidden', 'false');

    // 5. Lock background scroll
    document.body.classList.add('mobile-nav-lock');
    document.documentElement.classList.add('mobile-nav-lock');
  }

  function closeMobileDrawer() {
    if (!mobileDrawer) return;

    mobileDrawer.classList.remove('open');
    if (drawerBackdrop) drawerBackdrop.classList.remove('open');

    if (menuToggle) {
      menuToggle.setAttribute('aria-expanded', 'false');
      menuToggle.setAttribute('aria-label', 'Toggle mobile navigation menu');
      menuToggle.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>';
    }
    mobileDrawer.setAttribute('aria-hidden', 'true');

    // Unlock background scroll
    document.body.classList.remove('mobile-nav-lock');
    document.documentElement.classList.remove('mobile-nav-lock');

    // Restore background page scroll position smoothly
    if (typeof savedPageScrollY === 'number' && savedPageScrollY > 0) {
      window.scrollTo(0, savedPageScrollY);
    }
  }

  if (menuToggle && mobileDrawer) {
    // Toggle button in header
    menuToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      if (mobileDrawer.classList.contains('open')) {
        closeMobileDrawer();
      } else {
        openMobileDrawer();
      }
    });

    // Close button inside drawer
    if (drawerCloseBtn) {
      drawerCloseBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        closeMobileDrawer();
        if (menuToggle) menuToggle.focus();
      });
    }

    // Backdrop click to close
    if (drawerBackdrop) {
      drawerBackdrop.addEventListener('click', () => {
        closeMobileDrawer();
      });
    }

    // IT Services Expandable Accordion
    if (servicesToggle && servicesAccordion) {
      servicesToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const isExpanded = servicesAccordion.classList.toggle('is-expanded');
        servicesToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
        servicesToggle.setAttribute('aria-label', isExpanded ? 'Collapse IT Services Submenu' : 'Expand IT Services Submenu');
        const toggleText = servicesToggle.querySelector('.accordion-toggle-text');
        if (toggleText) {
          toggleText.textContent = isExpanded ? 'Collapse' : 'Expand';
        }
      });
    }

    // Close on any navigation link click (except accordion toggle itself)
    mobileDrawer.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        closeMobileDrawer();
      });
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (mobileDrawer.classList.contains('open') && 
          !mobileDrawer.contains(e.target) && 
          !menuToggle.contains(e.target)) {
        closeMobileDrawer();
      }
    });

    // Close on Escape key press
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && mobileDrawer.classList.contains('open')) {
        closeMobileDrawer();
        if (menuToggle) menuToggle.focus();
      }
    });

    // Auto-close on resize to desktop viewport
    window.addEventListener('resize', () => {
      if (window.innerWidth > 1024 && mobileDrawer.classList.contains('open')) {
        closeMobileDrawer();
      }
    }, { passive: true });
  }

  // 3. Robust Services Mega Menu Interaction Controller
  const megaMenuItem = document.querySelector('.has-mega-menu');
  if (megaMenuItem) {
    const trigger = megaMenuItem.querySelector('.nav-link-dropdown');
    const panel = megaMenuItem.querySelector('.mega-menu');
    let closeTimer = null;
    const CLOSE_DELAY = 300; // Controlled 300ms close delay (per specification: 250-350ms)

    function openMenu() {
      cancelClose();
      megaMenuItem.classList.add('is-open');
      if (trigger) {
        trigger.setAttribute('aria-expanded', 'true');
      }
    }

    function cancelClose() {
      if (closeTimer) {
        clearTimeout(closeTimer);
        closeTimer = null;
      }
    }

    function scheduleClose() {
      cancelClose();
      closeTimer = setTimeout(() => {
        closeMenu();
      }, CLOSE_DELAY);
    }

    function closeMenu() {
      cancelClose();
      megaMenuItem.classList.remove('is-open');
      if (trigger) {
        trigger.setAttribute('aria-expanded', 'false');
      }
    }

    // --- Hover Interactions with controlled debounce ---
    megaMenuItem.addEventListener('mouseenter', () => {
      openMenu();
    });

    megaMenuItem.addEventListener('mouseleave', () => {
      scheduleClose();
    });

    if (panel) {
      panel.addEventListener('mouseenter', () => {
        cancelClose();
        openMenu();
      });

      panel.addEventListener('mouseleave', () => {
        scheduleClose();
      });
    }

    // --- Click & Touch Interaction ---
    if (trigger) {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        if (megaMenuItem.classList.contains('is-open')) {
          closeMenu();
        } else {
          openMenu();
        }
      });
    }

    // Close on click outside
    document.addEventListener('click', (e) => {
      if (!megaMenuItem.contains(e.target)) {
        closeMenu();
      }
    });

    // --- Keyboard Navigation (Accessibility) ---
    if (trigger) {
      trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
          e.preventDefault();
          if (megaMenuItem.classList.contains('is-open') && e.key !== 'ArrowDown') {
            closeMenu();
          } else {
            openMenu();
            // Focus first link in menu
            const firstLink = panel ? panel.querySelector('a') : null;
            if (firstLink) firstLink.focus();
          }
        }
      });
    }

    // Escape key closes menu and returns focus to trigger
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && megaMenuItem.classList.contains('is-open')) {
        closeMenu();
        if (trigger) trigger.focus();
      }
    });

    // Handle focus leaving the mega menu during tab navigation
    megaMenuItem.addEventListener('focusout', (e) => {
      setTimeout(() => {
        if (!megaMenuItem.contains(document.activeElement)) {
          closeMenu();
        }
      }, 50);
    });
  }

  // 4. Interactive Capabilities Tab Explorer with Horizontal Navigation Arrows
  const tabBtns = document.querySelectorAll('.cap-tab-btn[data-target]');
  const tabPanes = document.querySelectorAll('.cap-tab-pane');
  const capNavWrapper = document.querySelector('.capabilities-nav-wrapper');
  const capNavBar = document.getElementById('capabilitiesNavBar') || document.querySelector('.capabilities-nav-bar');
  const capNavPrev = document.getElementById('capNavPrev');
  const capNavNext = document.getElementById('capNavNext');

  function updateCapArrows() {
    if (!capNavBar || !capNavPrev || !capNavNext) return;
    const scrollLeft = Math.round(capNavBar.scrollLeft);
    const maxScroll = Math.round(capNavBar.scrollWidth - capNavBar.clientWidth);
    const hasOverflow = maxScroll > 4;

    if (!hasOverflow) {
      capNavPrev.classList.add('is-hidden');
      capNavNext.classList.add('is-hidden');
      return;
    }

    // Left Arrow appears only when left scrolling is possible
    if (scrollLeft > 6) {
      capNavPrev.classList.remove('is-hidden');
    } else {
      capNavPrev.classList.add('is-hidden');
    }

    // Right Arrow appears only when right scrolling is possible
    if (scrollLeft < maxScroll - 6) {
      capNavNext.classList.remove('is-hidden');
    } else {
      capNavNext.classList.add('is-hidden');
    }
  }

  function fitCapTabs() {
    if (!capNavWrapper || !capNavBar || tabBtns.length === 0) return;

    const wrapperWidth = capNavWrapper.clientWidth;
    if (wrapperWidth <= 0) return;

    const btns = Array.from(tabBtns);
    const arrowWidth = capNavNext ? capNavNext.offsetWidth : 44;
    const arrowGap = parseFloat(getComputedStyle(capNavWrapper).gap) || 10;
    const arrowReserve = (arrowWidth + arrowGap) * 2;
    const maxAvailable = wrapperWidth - arrowReserve;

    const barStyle = getComputedStyle(capNavBar);
    const padLeft = parseFloat(barStyle.paddingLeft) || 8;
    const padRight = parseFloat(barStyle.paddingRight) || 8;
    const borderLeft = parseFloat(barStyle.borderLeftWidth) || 1;
    const borderRight = parseFloat(barStyle.borderRightWidth) || 1;
    const gapX = parseFloat(barStyle.gap) || 8;
    const gapHalf = Math.floor(gapX / 2);

    // Get individual button widths accurately
    const btnWidths = btns.map(b => Math.ceil(b.getBoundingClientRect().width));

    // Calculate total required width for all tabs
    const totalAll = btnWidths.reduce((sum, w) => sum + w, 0) + (btns.length - 1) * gapX + padLeft + padRight + borderLeft + borderRight;

    if (totalAll <= wrapperWidth) {
      // All tabs fit across the wrapper without scrolling
      capNavBar.style.maxWidth = '100%';
      capNavBar.style.width = 'auto';
    } else {
      // Find how many complete tabs fit in maxAvailable without any text clipping
      let bestFitWidth = 0;
      let lastFittingIndex = -1;

      let currentX = padLeft + borderLeft;
      for (let i = 0; i < btnWidths.length; i++) {
        const tabRightEdge = currentX + btnWidths[i];
        const splitBoundary = tabRightEdge + gapHalf;
        if (splitBoundary <= maxAvailable) {
          bestFitWidth = splitBoundary;
          lastFittingIndex = i;
          currentX = tabRightEdge + gapX;
        } else {
          break;
        }
      }

      if (lastFittingIndex >= 0 && bestFitWidth > 0) {
        capNavBar.style.maxWidth = bestFitWidth + 'px';
        capNavBar.style.width = bestFitWidth + 'px';
      } else {
        const firstW = btnWidths[0] + padLeft + borderLeft + gapHalf;
        capNavBar.style.maxWidth = firstW + 'px';
        capNavBar.style.width = firstW + 'px';
      }
    }

    updateCapArrows();
  }

  if (capNavBar && capNavPrev && capNavNext) {
    capNavNext.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();

      const navR = capNavBar.getBoundingClientRect();
      const btns = Array.from(tabBtns);

      // Find the first tab whose left edge is beyond the container's start area
      let targetTab = null;
      let targetIndex = -1;
      for (let i = 0; i < btns.length; i++) {
        const r = btns[i].getBoundingClientRect();
        if (r.left > navR.left + 40) {
          targetTab = btns[i];
          targetIndex = i;
          break;
        }
      }

      if (!targetTab || targetIndex === btns.length - 1) {
        capNavBar.scrollTo({ left: capNavBar.scrollWidth - capNavBar.clientWidth, behavior: 'smooth' });
        return;
      }

      targetTab.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
    });

    capNavPrev.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();

      const navR = capNavBar.getBoundingClientRect();
      const btns = Array.from(tabBtns);

      // Find the first tab to the left whose right edge is before the container's start
      let targetTab = null;
      let targetIndex = -1;
      for (let i = btns.length - 1; i >= 0; i--) {
        const r = btns[i].getBoundingClientRect();
        if (r.right < navR.left + 20) {
          targetTab = btns[i];
          targetIndex = i;
          break;
        }
      }

      if (!targetTab || targetIndex <= 0) {
        capNavBar.scrollTo({ left: 0, behavior: 'smooth' });
        return;
      }

      targetTab.scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
    });

    capNavBar.addEventListener('scroll', updateCapArrows, { passive: true });
    window.addEventListener('resize', () => {
      fitCapTabs();
    }, { passive: true });

    fitCapTabs();
    setTimeout(fitCapTabs, 100);
  }

  if (tabBtns.length > 0 && tabPanes.length > 0) {
    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');

        // Deactivate all
        tabBtns.forEach(b => b.classList.remove('active'));
        tabPanes.forEach(p => p.classList.remove('active'));

        // Activate current
        btn.classList.add('active');
        const targetPane = document.getElementById(targetId);
        if (targetPane) {
          targetPane.classList.add('active');
        }

        // Keep selected tab in view without moving the page
        if (capNavBar && typeof btn.scrollIntoView === 'function') {
          btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
        }
      });
    });
  }

  // 5. Smooth Anchor Scrolling
  document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      const targetEl = document.querySelector(targetId);
      if (targetEl) {
        e.preventDefault();
        const headerOffset = 90;
        const elementPosition = targetEl.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

  // 6. Premium Upward Animation & Counter for KPI Data Strip
  function initKpiDataStrip() {
    const strip = document.getElementById('vitalTicker');
    if (!strip) return;

    const counters = strip.querySelectorAll('.vital-number[data-count]');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let hasAnimated = false;

    function triggerAnimation() {
      if (hasAnimated) return;
      hasAnimated = true;
      strip.classList.add('is-animated');

      if (prefersReducedMotion) {
        counters.forEach(el => {
          const target = parseFloat(el.getAttribute('data-count'));
          const prefix = el.getAttribute('data-prefix') || '';
          const suffix = el.getAttribute('data-suffix') || '';
          el.textContent = prefix + (Number.isInteger(target) ? target.toString() : target.toFixed(1)) + suffix;
        });
        return;
      }

      // Smooth Ease-Out Upward Counter Animation
      counters.forEach(el => {
        const target = parseFloat(el.getAttribute('data-count'));
        const prefix = el.getAttribute('data-prefix') || '';
        const suffix = el.getAttribute('data-suffix') || '';
        const isDecimal = !Number.isInteger(target);
        const duration = 1250;
        let startTime = null;

        function easeOutCubic(t) {
          return 1 - Math.pow(1 - t, 3);
        }

        function step(timestamp) {
          if (!startTime) startTime = timestamp;
          const elapsed = timestamp - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const eased = easeOutCubic(progress);
          const val = eased * target;

          if (isDecimal) {
            el.textContent = prefix + val.toFixed(1) + suffix;
          } else {
            el.textContent = prefix + Math.floor(val) + suffix;
          }

          if (progress < 1) {
            requestAnimationFrame(step);
          } else {
            el.textContent = prefix + (isDecimal ? target.toFixed(1) : target) + suffix;
          }
        }

        requestAnimationFrame(step);
      });
    }

    window.triggerKpiDataStrip = triggerAnimation;

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            triggerAnimation();
            obs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });

      observer.observe(strip);
    }
  }

  initKpiDataStrip();

  // 6.5. Mission & Vision Panels Scroll Reveal Observer
  function initMissionVisionReveal() {
    const mvPanels = document.querySelectorAll('.mv-panel');
    if (mvPanels.length === 0) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
      mvPanels.forEach(p => p.classList.add('is-revealed'));
      return;
    }

    const panelObserver = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    mvPanels.forEach(p => panelObserver.observe(p));
  }

  initMissionVisionReveal();

  // 7. Interactive Movable 5-Stage Framework Controller
  initStageCarousel();

  // 8. Deloitte-Inspired Scroll-Driven Hero Animation Controller
  initHeroScrollAnimation();

  // 9. Interactive Benefits Accordion with Dynamic Graphs
  initBenefitsAccordion();

  // 10. Tools We Use Filter Controller
  initToolsFilter();
});

/**
 * 5-Stage Interactive Movable Framework
 * Drag, swipe, arrow navigation, keyboard controls, progress indicators
 */
function initStageCarousel() {
  const viewport = document.getElementById('stageCarouselViewport');
  const track = document.getElementById('stageTrack');
  if (!viewport || !track) return;

  const cards = track.querySelectorAll('.stage-card');
  const prevBtn = document.getElementById('stagePrevBtn');
  const nextBtn = document.getElementById('stageNextBtn');
  const currentNumEl = document.getElementById('currentStageNum');
  const progressFill = document.getElementById('stageProgressFill');
  const pills = document.querySelectorAll('.stage-pill[data-stage]');

  if (cards.length === 0) return;

  let activeIndex = 0;
  const totalStages = cards.length;
  let isDragging = false;
  let startX = 0;
  let startY = 0;
  let currentTranslate = 0;
  let prevTranslate = 0;
  let dragDistance = 0;
  let isHorizontalDrag = null;

  function getCardStep() {
    if (cards.length < 2) return 400;
    const card0 = cards[0].getBoundingClientRect();
    const card1 = cards[1].getBoundingClientRect();
    return card1.left - card0.left;
  }

  function getTargetTranslate(index) {
    const step = getCardStep();
    const viewportWidth = viewport.clientWidth;
    const cardWidth = cards[0].offsetWidth;
    const totalTrackWidth = (step * (totalStages - 1)) + cardWidth;
    
    // On wide viewports, prevent dragging past the point where the last card sits at the right margin
    const maxTranslate = Math.max(0, totalTrackWidth - viewportWidth);

    let target = index * step;
    if (target > maxTranslate && maxTranslate > 0) {
      target = maxTranslate;
    }
    return -target;
  }

  function updateUI() {
    // Update active class on cards
    cards.forEach((card, idx) => {
      if (idx === activeIndex) {
        card.classList.add('is-active');
        card.setAttribute('aria-current', 'true');
      } else {
        card.classList.remove('is-active');
        card.removeAttribute('aria-current');
      }
    });

    // Update Stage Counter
    if (currentNumEl) {
      currentNumEl.textContent = String(activeIndex + 1).padStart(2, '0');
    }

    // Update Progress Bar
    if (progressFill) {
      const percentage = ((activeIndex + 1) / totalStages) * 100;
      progressFill.style.width = percentage + '%';
    }

    // Update Nav Buttons
    if (prevBtn) {
      prevBtn.disabled = activeIndex === 0;
    }
    if (nextBtn) {
      nextBtn.disabled = activeIndex === totalStages - 1;
    }

    // Update Pills
    pills.forEach((pill, idx) => {
      if (idx === activeIndex) {
        pill.classList.add('active');
        pill.setAttribute('aria-selected', 'true');
      } else {
        pill.classList.remove('active');
        pill.setAttribute('aria-selected', 'false');
      }
    });
  }

  function goToStage(index, smooth = true) {
    if (index < 0) index = 0;
    if (index >= totalStages) index = totalStages - 1;
    activeIndex = index;

    const targetX = getTargetTranslate(activeIndex);
    currentTranslate = targetX;
    prevTranslate = targetX;

    if (smooth) {
      track.style.transition = 'transform 0.5s cubic-bezier(0.22, 1, 0.36, 1)';
    } else {
      track.style.transition = 'none';
    }
    track.style.transform = `translateX(${targetX}px)`;

    updateUI();
  }

  // Pointer Events (Mouse + Touch)
  function pointerDown(e) {
    if (e.button !== undefined && e.button !== 0) return;
    
    isDragging = true;
    startX = e.clientX;
    startY = e.clientY;
    dragDistance = 0;
    isHorizontalDrag = null;

    track.classList.add('is-dragging');
    track.style.transition = 'none';

    try {
      viewport.setPointerCapture(e.pointerId);
    } catch (err) {}
  }

  function pointerMove(e) {
    if (!isDragging) return;

    const currentX = e.clientX;
    const currentY = e.clientY;
    const diffX = currentX - startX;
    const diffY = currentY - startY;

    if (isHorizontalDrag === null) {
      if (Math.abs(diffX) > 7 || Math.abs(diffY) > 7) {
        isHorizontalDrag = Math.abs(diffX) > Math.abs(diffY);
        if (!isHorizontalDrag) {
          isDragging = false;
          track.classList.remove('is-dragging');
          return;
        }
      } else {
        return;
      }
    }

    if (!isHorizontalDrag) return;

    if (e.cancelable) {
      e.preventDefault();
    }
    dragDistance = diffX;

    // Elastic boundary resistance
    let effectiveDiffX = diffX;
    if ((activeIndex === 0 && diffX > 0) || (activeIndex === totalStages - 1 && diffX < 0)) {
      effectiveDiffX = diffX * 0.28;
    }

    currentTranslate = prevTranslate + effectiveDiffX;
    track.style.transform = `translateX(${currentTranslate}px)`;
  }

  function pointerUp(e) {
    if (!isDragging) return;
    isDragging = false;
    track.classList.remove('is-dragging');

    try {
      viewport.releasePointerCapture(e.pointerId);
    } catch (err) {}

    const threshold = 45;
    if (dragDistance < -threshold && activeIndex < totalStages - 1) {
      goToStage(activeIndex + 1);
    } else if (dragDistance > threshold && activeIndex > 0) {
      goToStage(activeIndex - 1);
    } else {
      goToStage(activeIndex);
    }
  }

  // Suppress click if a drag action occurred
  viewport.addEventListener('click', (e) => {
    if (Math.abs(dragDistance) > 10) {
      e.preventDefault();
      e.stopPropagation();
    }
  }, true);

  viewport.addEventListener('pointerdown', pointerDown);
  viewport.addEventListener('pointermove', pointerMove);
  viewport.addEventListener('pointerup', pointerUp);
  viewport.addEventListener('pointercancel', pointerUp);

  // Prev / Next button listeners
  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      if (activeIndex > 0) goToStage(activeIndex - 1);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      if (activeIndex < totalStages - 1) goToStage(activeIndex + 1);
    });
  }

  // Stage pills click listener
  pills.forEach((pill, idx) => {
    pill.addEventListener('click', () => {
      goToStage(idx);
    });
  });

  // Clicking an inactive card directly slides it into view
  cards.forEach((card, idx) => {
    card.addEventListener('click', () => {
      if (Math.abs(dragDistance) <= 10 && idx !== activeIndex) {
        goToStage(idx);
      }
    });
  });

  // Keyboard accessibility
  viewport.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') {
      e.preventDefault();
      if (activeIndex < totalStages - 1) goToStage(activeIndex + 1);
    } else if (e.key === 'ArrowLeft') {
      e.preventDefault();
      if (activeIndex > 0) goToStage(activeIndex - 1);
    } else if (e.key === 'Home') {
      e.preventDefault();
      goToStage(0);
    } else if (e.key === 'End') {
      e.preventDefault();
      goToStage(totalStages - 1);
    }
  });

  // Resize listener with debounce
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      goToStage(activeIndex, false);
    }, 120);
  });

  // Initialize
  goToStage(0, false);
}

/**
 * 8. Deloitte-Inspired Scroll-Driven Hero Animation
 * Controlled sticky range, multi-layer parallax, 3D unbundling, progressive reveal
 */
function initHeroScrollAnimation() {
  const track = document.getElementById('heroScrollTrack');
  const sticky = document.getElementById('heroStickyStage');
  if (!track || !sticky) return;

  // Check prefers-reduced-motion
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const editorialLayer = document.getElementById('heroEditorialLayer');
    const visualLayer = document.getElementById('heroVisualLayer');
    const hudCard = document.getElementById('heroHudCard');
    const scrollIndicator = document.getElementById('heroScrollIndicator');
    if (editorialLayer) {
      editorialLayer.style.opacity = '1';
      editorialLayer.style.transform = 'none';
      editorialLayer.style.pointerEvents = 'auto';
    }
    if (visualLayer) {
      visualLayer.style.opacity = '1';
      visualLayer.style.transform = 'none';
      visualLayer.style.pointerEvents = 'auto';
    }
    if (hudCard) {
      hudCard.style.transform = 'none';
    }
    if (scrollIndicator) {
      scrollIndicator.style.display = 'none';
    }
    if (typeof window.triggerKpiDataStrip === 'function') {
      window.triggerKpiDataStrip();
    }
    return;
  }

  const editorialLayer = document.getElementById('heroEditorialLayer');
  const revealedLayer = document.getElementById('heroRevealedLayer');
  const visualLayer = document.getElementById('heroVisualLayer');
  const hudCard = document.getElementById('heroHudCard');
  const bgCanvas = document.getElementById('heroBgCanvas');
  const kpiBoxes = document.querySelectorAll('.hud-kpi-box');
  const vitalDock = document.getElementById('heroVitalDock');
  const scrollIndicator = document.getElementById('heroScrollIndicator');
  const progressFill = document.getElementById('heroProgressFill');

  let ticking = false;

  function clamp(val, min, max) {
    return Math.max(min, Math.min(max, val));
  }

  function updateHeroAnimation() {
    const rect = track.getBoundingClientRect();
    const windowHeight = window.innerHeight;
    const totalScroll = rect.height - windowHeight;

    if (totalScroll <= 0) {
      ticking = false;
      return;
    }

    // Scroll progress p in [0.0, 1.0]
    const scrollOffset = -rect.top;
    const p = clamp(scrollOffset / totalScroll, 0, 1);
    const isDesktop = window.innerWidth > 1024;
    const isMobile = window.innerWidth <= 768;

    // 1. Progress Fill Line
    if (progressFill) {
      progressFill.style.width = (p * 100) + '%';
    }

    // 2. Scroll Indicator Pill (Fades out early)
    if (scrollIndicator) {
      if (p < 0.12) {
        scrollIndicator.style.opacity = String(1 - (p / 0.12));
        scrollIndicator.style.transform = `translateX(-50%) translateY(${p * 25}px)`;
      } else {
        scrollIndicator.style.opacity = '0';
      }
    }

    // 3. Background Canvas Parallax & Scale
    if (bgCanvas) {
      const bgScale = 1 + p * 0.12;
      const bgY = p * 35;
      bgCanvas.style.transform = `scale(${bgScale}) translateY(${bgY}px)`;
    }

    if (isDesktop) {
      // DESKTOP MULTI-COLUMN CHOREOGRAPHY (Collision-free independent layout zones)
      // 4. Initial Editorial Column (Moves up and fades)
      if (editorialLayer) {
        const t1 = clamp((p - 0.14) / 0.12, 0, 1);
        const editY = -clamp(p / 0.26, 0, 1) * 40;
        const editScale = 1 - clamp(p / 0.26, 0, 1) * 0.04;
        const editOpacity = 1 - t1;

        editorialLayer.style.transform = `translateY(${editY}px) scale(${editScale})`;
        editorialLayer.style.opacity = String(editOpacity);
        editorialLayer.style.filter = 'none';
        editorialLayer.style.pointerEvents = editOpacity < 0.1 ? 'none' : 'auto';
      }

      // 5. Revealed Transformation Narrative (Mid-Scroll Phase: 0.22 -> 0.65)
      if (revealedLayer) {
        const enter = clamp((p - 0.22) / 0.10, 0, 1);
        const exit = clamp((p - 0.58) / 0.12, 0, 1);
        const revOpacity = enter * (1 - exit);
        const revY = (1 - enter) * 20 - exit * 30;
        const revScale = 0.98 + enter * 0.02;

        revealedLayer.style.transform = `translateY(${revY}px) scale(${revScale})`;
        revealedLayer.style.opacity = String(revOpacity);
        revealedLayer.style.pointerEvents = revOpacity > 0.5 ? 'auto' : 'none';
      }

      // 6. Technology Visual & HUD Board (Parallax 3D & Non-colliding Centering)
      if (hudCard && visualLayer) {
        visualLayer.style.opacity = '1';
        // HUD remains strictly in its right-hand zone while revealed text is visible
        const tShift = clamp((p - 0.68) / 0.16, 0, 1);
        const shiftX = -tShift * 25; // pulls toward center only after revealed layer has cleared (p > 0.68)
        const shiftY = window.innerHeight < 820 ? -tShift * 16 : -tShift * 30;
        const scale = window.innerHeight < 820 ? 1 : 1 + tShift * 0.03;
        const tRotate = clamp(p / 0.38, 0, 1);
        const rotateY = -8 * (1 - tRotate);
        hudCard.style.transform = `translateX(${shiftX}%) translateY(${shiftY}px) scale(${scale}) rotateY(${rotateY}deg)`;

        // Parallax 3D KPI Unbundling on 4 boxes happens smoothly during Phase 2
        if (kpiBoxes.length >= 4) {
          const tBox = clamp((p - 0.18) / 0.35, 0, 1);
          const maxOffset = 14;
          kpiBoxes[0].style.transform = `translate3d(${-tBox * maxOffset}px, ${-tBox * (maxOffset * 0.7)}px, ${tBox * 20}px)`;
          kpiBoxes[1].style.transform = `translate3d(${tBox * maxOffset}px, ${-tBox * (maxOffset * 0.7)}px, ${tBox * 20}px)`;
          kpiBoxes[2].style.transform = `translate3d(${-tBox * (maxOffset * 0.7)}px, ${tBox * (maxOffset * 0.6)}px, ${tBox * 10}px)`;
          kpiBoxes[3].style.transform = `translate3d(${tBox * (maxOffset * 0.7)}px, ${tBox * (maxOffset * 0.6)}px, ${tBox * 10}px)`;
        }
      }

      // 7. Vital Metrics Dock (Final Phase: 0.72 -> 0.95)
      if (vitalDock) {
        const tDock = clamp((p - 0.72) / 0.18, 0, 1);
        const dockY = (1 - tDock) * 25;
        vitalDock.style.transform = `translateY(${dockY}px)`;
        vitalDock.style.opacity = String(tDock);
        vitalDock.style.pointerEvents = tDock > 0.5 ? 'auto' : 'none';
        if (tDock > 0.05 && typeof window.triggerKpiDataStrip === 'function') {
          window.triggerKpiDataStrip();
        }
      }
    } else {
      // MOBILE & TABLET SEQUENTIAL CINEMATIC FLOW
      // Stage 1 (p: 0 -> 0.28): Initial Editorial Content (moves up and fades out)
      if (editorialLayer) {
        const t1 = clamp(p / 0.24, 0, 1);
        const editY = -t1 * 30;
        const editOpacity = Math.max(0, 1 - t1 * 1.25);
        editorialLayer.style.transform = `translateY(${editY}px) scale(${1 - t1 * 0.04})`;
        editorialLayer.style.opacity = String(editOpacity);
        editorialLayer.style.pointerEvents = editOpacity < 0.1 ? 'none' : 'auto';
      }

      // Stage 2 (p: 0.25 -> 0.65): Revealed Transformation Narrative (Next Content)
      if (revealedLayer) {
        const enter = clamp((p - 0.24) / 0.12, 0, 1);
        const exit = clamp((p - 0.54) / 0.11, 0, 1);
        const revOpacity = enter * (1 - exit);
        const revY = (1 - enter) * 25 - exit * 25;
        revealedLayer.style.transform = `translateY(${revY}px)`;
        revealedLayer.style.opacity = String(revOpacity);
        revealedLayer.style.pointerEvents = revOpacity > 0.4 ? 'auto' : 'none';
      }

      // Stage 3 (p: 0.58 -> 0.96): Enterprise Operating Standards HUD Card
      if (visualLayer && hudCard) {
        const tVisEnter = clamp((p - 0.58) / 0.14, 0, 1);
        const tVisExit = clamp((p - 0.92) / 0.08, 0, 1);
        const visOpacity = tVisEnter * (1 - tVisExit);
        const visY = (1 - tVisEnter) * 25 - tVisExit * 20;
        visualLayer.style.opacity = String(visOpacity);
        visualLayer.style.transform = `translateY(${visY}px)`;
        visualLayer.style.pointerEvents = visOpacity > 0.4 ? 'auto' : 'none';
        hudCard.style.transform = `scale(${0.96 + tVisEnter * 0.04})`;

        if (kpiBoxes.length >= 4) {
          const tBox = tVisEnter;
          kpiBoxes[0].style.transform = `translate3d(${-tBox * 4}px, ${-tBox * 3}px, 0)`;
          kpiBoxes[1].style.transform = `translate3d(${tBox * 4}px, ${-tBox * 3}px, 0)`;
          kpiBoxes[2].style.transform = `translate3d(${-tBox * 3}px, ${tBox * 3}px, 0)`;
          kpiBoxes[3].style.transform = `translate3d(${tBox * 3}px, ${tBox * 3}px, 0)`;
        }
      }

      // Final Transition Trigger for KPI Strip (p >= 0.70)
      if (typeof window.triggerKpiDataStrip === 'function' && p > 0.7) {
        window.triggerKpiDataStrip();
      }
    }

    ticking = false;
  }

  function onScroll() {
    if (!ticking) {
      requestAnimationFrame(updateHeroAnimation);
      ticking = true;
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });
  updateHeroAnimation();
}

/**
 * 9. Interactive Benefits Accordion with Dynamic Graphs
 * Synchronizes 6 expandable items with 6 distinct SVG performance graphs.
 */
function initBenefitsAccordion() {
  const container = document.getElementById('benefitsSection');
  if (!container) return;

  const items = container.querySelectorAll('.benefits-accordion-item');
  const vizItems = container.querySelectorAll('.benefits-viz-item');
  const vizKicker = document.getElementById('vizKicker');
  const vizHeading = document.getElementById('vizHeading');

  const vizMeta = [
    { kicker: 'PERFORMANCE MODEL 01', heading: 'Brand Visibility & Reach Funnel' },
    { kicker: 'PERFORMANCE MODEL 02', heading: 'Multi-Channel Engagement Matrix' },
    { kicker: 'PERFORMANCE MODEL 03', heading: 'Capital Efficiency & ROAS Donut' },
    { kicker: 'PERFORMANCE MODEL 04', heading: 'Audience Segmentation Funnel' },
    { kicker: 'PERFORMANCE MODEL 05', heading: 'Multi-Trend Performance Intelligence' },
    { kicker: 'PERFORMANCE MODEL 06', heading: 'Conversion Pipeline Optimization' }
  ];

  function activateIndex(index) {
    if (index < 0 || index >= items.length) return;

    items.forEach((item, i) => {
      const trigger = item.querySelector('.benefits-accordion-trigger');
      const panel = item.querySelector('.benefits-accordion-panel');
      const isActive = i === index;

      item.classList.toggle('active', isActive);
      if (trigger) {
        trigger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
      }
      if (panel) {
        panel.style.display = isActive ? 'block' : 'none';
      }
    });

    vizItems.forEach((viz, i) => {
      viz.classList.toggle('active', i === index);
    });

    if (vizMeta[index]) {
      if (vizKicker) vizKicker.textContent = vizMeta[index].kicker;
      if (vizHeading) vizHeading.textContent = vizMeta[index].heading;
    }
  }

  items.forEach((item, index) => {
    const trigger = item.querySelector('.benefits-accordion-trigger');
    if (!trigger) return;

    trigger.addEventListener('click', () => {
      activateIndex(index);
    });

    trigger.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        const next = (index + 1) % items.length;
        items[next].querySelector('.benefits-accordion-trigger')?.focus();
        activateIndex(next);
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        const prev = (index - 1 + items.length) % items.length;
        items[prev].querySelector('.benefits-accordion-trigger')?.focus();
        activateIndex(prev);
      } else if (e.key === 'Home') {
        e.preventDefault();
        items[0].querySelector('.benefits-accordion-trigger')?.focus();
        activateIndex(0);
      } else if (e.key === 'End') {
        e.preventDefault();
        items[items.length - 1].querySelector('.benefits-accordion-trigger')?.focus();
        activateIndex(items.length - 1);
      }
    });
  });

  // Default active: Item 0
  activateIndex(0);
}

/**
 * 10. Tools We Use Category Filter Controller
 */
function initToolsFilter() {
  const filterBtns = document.querySelectorAll('.tool-filter-btn');
  const toolCards = document.querySelectorAll('.tool-card');
  if (filterBtns.length === 0 || toolCards.length === 0) return;

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const filter = btn.getAttribute('data-filter') || 'all';

      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      toolCards.forEach(card => {
        const cat = card.getAttribute('data-category');
        if (filter === 'all' || cat === filter) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
}
