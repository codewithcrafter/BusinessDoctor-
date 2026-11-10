/**
 * BusinessDoctor Services Interactive UI Handler
 * Reference Features:
 * - Accessible Expandable FAQ Accordion
 * - Interactive Carousel (Touch / Swipe + Prev/Next Buttons + Dot Pagination)
 * - Process Timeline Step Navigation
 * - Quick Consultation Enquiry Form Feedback
 * - Smooth In-Page Anchor Navigation
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // ============================================================
  // 1. Accessible Interactive FAQ Accordion
  // ============================================================
  const faqButtons = document.querySelectorAll('.srv-faq-btn, .srv-faq-question');

  faqButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      const parentItem = this.closest('.srv-faq-item');
      if (!parentItem) return;

      const isExpanded = this.getAttribute('aria-expanded') === 'true';

      // Auto-collapse siblings in the same accordion group
      const containerParent = parentItem.closest('.srv-faq-container, .srv-faq-accordion');
      if (containerParent) {
        const siblingItems = containerParent.querySelectorAll('.srv-faq-item');
        siblingItems.forEach(function (sibling) {
          if (sibling !== parentItem) {
            sibling.classList.remove('is-active');
            const siblingBtn = sibling.querySelector('.srv-faq-btn, .srv-faq-question');
            if (siblingBtn) {
              siblingBtn.setAttribute('aria-expanded', 'false');
            }
            const siblingPanel = sibling.querySelector('.srv-faq-panel, .srv-faq-answer');
            if (siblingPanel) {
              siblingPanel.style.maxHeight = null;
            }
          }
        });
      }

      const panel = parentItem.querySelector('.srv-faq-panel, .srv-faq-answer');

      if (isExpanded) {
        parentItem.classList.remove('is-active');
        this.setAttribute('aria-expanded', 'false');
        if (panel) {
          panel.style.maxHeight = null;
        }
      } else {
        parentItem.classList.add('is-active');
        this.setAttribute('aria-expanded', 'true');
        if (panel) {
          panel.style.maxHeight = (panel.scrollHeight + 32) + 'px';
        }
      }
    });

    // Keyboard Accessibility (Enter & Space)
    button.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        this.click();
      }
    });
  });

  // ============================================================
  // 2. Interactive Carousel Component (Touch, Swipe, Buttons, Dots)
  // ============================================================
  const carousels = document.querySelectorAll('.srv-carousel-wrapper');

  carousels.forEach(function (carousel) {
    const track = carousel.querySelector('.srv-carousel-track');
    const prevBtn = carousel.querySelector('.srv-carousel-prev');
    const nextBtn = carousel.querySelector('.srv-carousel-next');
    const dotsContainer = carousel.querySelector('.srv-carousel-dots');
    if (!track) return;

    const items = track.children;
    const itemCount = items.length;
    if (itemCount === 0) return;

    // Equalize card heights for consistent alignment
    function equalizeCardHeights() {
      let maxHeight = 0;
      for (let i = 0; i < items.length; i++) {
        items[i].style.removeProperty('height');
        const h = items[i].offsetHeight;
        if (h > maxHeight) maxHeight = h;
      }
      if (maxHeight > 0) {
        for (let i = 0; i < items.length; i++) {
          items[i].style.setProperty('height', maxHeight + 'px', 'important');
        }
      }
    }
    equalizeCardHeights();
    window.addEventListener('load', equalizeCardHeights);
    window.addEventListener('resize', equalizeCardHeights);
    setTimeout(equalizeCardHeights, 250);

    // Generate pagination dots
    if (dotsContainer && itemCount > 1) {
      dotsContainer.innerHTML = '';
      for (let i = 0; i < itemCount; i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'srv-carousel-dot' + (i === 0 ? ' is-active' : '');
        dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        dot.addEventListener('click', function () {
          if (items[i]) {
            items[i].scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
          }
        });
        dotsContainer.appendChild(dot);
      }
    }

    // Scroll helper
    function getCardWidth() {
      if (items[0]) {
        return items[0].getBoundingClientRect().width + 24; // width + gap
      }
      return track.clientWidth * 0.8;
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        track.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        track.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
      });
    }

    // Update active dot on scroll
    let scrollTimeout;
    track.addEventListener('scroll', function () {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(function () {
        if (!dotsContainer) return;
        const scrollLeft = track.scrollLeft;
        const cardWidth = getCardWidth();
        const activeIndex = Math.round(scrollLeft / cardWidth);
        const dots = dotsContainer.querySelectorAll('.srv-carousel-dot');
        dots.forEach(function (d, idx) {
          if (idx === Math.min(activeIndex, dots.length - 1)) {
            d.classList.add('is-active');
          } else {
            d.classList.remove('is-active');
          }
        });
      }, 60);
    }, { passive: true });
  });

  // ============================================================
  // 3. Interactive Process Milestone Framework
  // ============================================================
  const processNavPills = document.querySelectorAll('.srv-process-pill');
  const processCards = document.querySelectorAll('.srv-process-card');

  if (processNavPills.length > 0 && processCards.length > 0) {
    processNavPills.forEach(function (pill) {
      pill.addEventListener('click', function () {
        const step = this.getAttribute('data-step');
        processNavPills.forEach(function (p) { p.classList.remove('is-active'); });
        this.classList.add('is-active');

        processCards.forEach(function (card) {
          if (card.getAttribute('data-step') === step) {
            card.classList.add('is-focused');
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
          } else {
            card.classList.remove('is-focused');
          }
        });
      });
    });

    processCards.forEach(function (card) {
      card.addEventListener('mouseenter', function () {
        processCards.forEach(function (c) { c.classList.remove('is-focused'); });
        this.classList.add('is-focused');
        const step = this.getAttribute('data-step');
        if (step) {
          processNavPills.forEach(function (p) {
            if (p.getAttribute('data-step') === step) p.classList.add('is-active');
            else p.classList.remove('is-active');
          });
        }
      });
    });
  }

  // ============================================================
  // 4. Quick Consultation Form Interactive UX
  // ============================================================
  const quickForms = document.querySelectorAll('.srv-quick-form');
  quickForms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
      const emailInput = form.querySelector('input[type="email"]');
      if (emailInput && !emailInput.value.includes('@')) {
        e.preventDefault();
        emailInput.focus();
        emailInput.style.borderColor = '#F87171';
        return;
      }
      const submitBtn = form.querySelector('.srv-form-submit');
      if (submitBtn) {
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<span>Transmitting Request...</span>';
      }
    });
  });

  // ============================================================
  // 5. Smooth Scroll for In-Page Anchors
  // ============================================================
  const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
  anchorLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      try {
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

          targetEl.setAttribute('tabindex', '-1');
          targetEl.focus({ preventScroll: true });
        }
      } catch (err) {}
    });
  });
});
