/**
 * BusinessDoctor - Dynamic Table of Contents (TOC) Engine
 * Automatically extracts H2 and nested H3 headings from article and case study content,
 * builds a structured, clickable, accessible navigation widget with dynamic count,
 * smooth scrolling with fixed header compensation, and scrollspy active tracking.
 */
document.addEventListener('DOMContentLoaded', () => {
  const tocContainer = document.getElementById('page-toc-card');
  if (!tocContainer) return;

  // Locate the article content body
  const contentContainer = document.querySelector('.article-editorial-body') ||
                           document.querySelector('.case-study-article-body');
  if (!contentContainer) {
    tocContainer.style.display = 'none';
    return;
  }

  // Detect existing H2 and H3 headings strictly within the article body
  const headingElements = Array.from(contentContainer.querySelectorAll('h2, h3'));
  if (headingElements.length === 0) {
    tocContainer.style.display = 'none';
    return;
  }

  const usedIds = new Set();
  const tocTree = [];
  let currentH2 = null;

  headingElements.forEach((el, index) => {
    const rawTitle = el.textContent.trim();
    if (!rawTitle) return;

    // Generate unique, clean, stable ID if missing
    let id = el.id ? el.id.trim() : '';
    if (!id) {
      id = rawTitle
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
      if (!id) id = `section-${index + 1}`;

      let baseId = id;
      let counter = 1;
      while (usedIds.has(id) || document.getElementById(id)) {
        id = `${baseId}-${++counter}`;
      }
      el.id = id;
    }
    usedIds.add(id);

    const tag = el.tagName.toLowerCase();
    const item = {
      id: id,
      title: rawTitle,
      tag: tag,
      element: el,
      children: []
    };

    if (tag === 'h2') {
      currentH2 = item;
      tocTree.push(item);
    } else if (tag === 'h3') {
      if (currentH2) {
        currentH2.children.push(item);
      } else {
        // Orphaned H3 without preceding H2 -> treat as top level
        tocTree.push(item);
      }
    }
  });

  const totalCount = headingElements.length;
  if (totalCount === 0 || tocTree.length === 0) {
    tocContainer.style.display = 'none';
    return;
  }

  function escapeHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
  }

  // Render TOC Markup
  const countLabel = totalCount === 1 ? '1 SECTION' : `${totalCount} SECTIONS`;

  let html = `
    <div class="toc-header">
      <div class="toc-title-wrap">
        <svg class="toc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <line x1="8" y1="6" x2="21" y2="6"></line>
          <line x1="8" y1="12" x2="21" y2="12"></line>
          <line x1="8" y1="18" x2="21" y2="18"></line>
          <line x1="3" y1="6" x2="3.01" y2="6"></line>
          <line x1="3" y1="12" x2="3.01" y2="12"></line>
          <line x1="3" y1="18" x2="3.01" y2="18"></line>
        </svg>
        <span class="toc-title">TABLE OF CONTENTS</span>
      </div>
      <span class="toc-count-badge" aria-label="${countLabel}">${countLabel}</span>
    </div>
    <ul class="toc-nav-list" role="list">
  `;

  tocTree.forEach((item) => {
    html += `
      <li class="toc-item">
        <a href="#${escapeHtml(item.id)}" class="toc-link" data-target="${escapeHtml(item.id)}">
          <span class="toc-bullet" aria-hidden="true"></span>
          <span class="toc-text">${escapeHtml(item.title)}</span>
        </a>
    `;

    if (item.children && item.children.length > 0) {
      html += `<ul class="toc-sublist" role="list">`;
      item.children.forEach((child) => {
        html += `
          <li class="toc-subitem">
            <a href="#${escapeHtml(child.id)}" class="toc-sublink" data-target="${escapeHtml(child.id)}">
              <span class="toc-subbullet" aria-hidden="true"></span>
              <span class="toc-text">${escapeHtml(child.title)}</span>
            </a>
          </li>
        `;
      });
      html += `</ul>`;
    }

    html += `</li>`;
  });

  html += `</ul>`;

  tocContainer.innerHTML = html;
  tocContainer.style.display = 'block';

  // Helper: get fixed header height
  function getHeaderOffset() {
    const header = document.querySelector('.site-header') || document.querySelector('header');
    if (header) {
      const h = header.getBoundingClientRect().height;
      if (h > 0) return h;
    }
    return 84;
  }

  // Smooth scroll handler on click
  tocContainer.addEventListener('click', (e) => {
    const link = e.target.closest('.toc-link, .toc-sublink');
    if (!link) return;

    const targetId = link.getAttribute('data-target') || link.getAttribute('href').replace(/^#/, '');
    const targetEl = document.getElementById(targetId);
    if (!targetEl) return;

    e.preventDefault();

    const offset = getHeaderOffset() + 24;
    const targetY = targetEl.getBoundingClientRect().top + window.pageYOffset - offset;

    window.scrollTo({
      top: Math.max(0, targetY),
      behavior: 'smooth'
    });

    if (history.pushState) {
      history.pushState(null, '', '#' + targetId);
    } else {
      location.hash = targetId;
    }

    // Set active link immediately on click
    setActiveLink(targetId);
  });

  // Active state highlighting (ScrollSpy)
  const allTocLinks = Array.from(tocContainer.querySelectorAll('.toc-link, .toc-sublink'));

  function setActiveLink(activeId) {
    allTocLinks.forEach((l) => {
      if (l.getAttribute('data-target') === activeId) {
        l.classList.add('is-active');
        l.setAttribute('aria-current', 'true');
      } else {
        l.classList.remove('is-active');
        l.removeAttribute('aria-current');
      }
    });
  }

  let isTicking = false;
  function updateScrollSpy() {
    const offset = getHeaderOffset() + 40;
    const scrollPos = window.scrollY || window.pageYOffset;

    // Check if scrolled near bottom of page
    const docHeight = document.documentElement.scrollHeight;
    const winHeight = window.innerHeight;
    if (scrollPos + winHeight >= docHeight - 50) {
      const last = headingElements[headingElements.length - 1];
      if (last && last.id) {
        setActiveLink(last.id);
        return;
      }
    }

    let currentActive = null;
    for (let i = 0; i < headingElements.length; i++) {
      const heading = headingElements[i];
      const top = heading.getBoundingClientRect().top;
      if (top <= offset) {
        currentActive = heading;
      } else {
        break;
      }
    }

    if (currentActive && currentActive.id) {
      setActiveLink(currentActive.id);
    } else if (headingElements.length > 0) {
      const firstTop = headingElements[0].getBoundingClientRect().top;
      if (firstTop <= winHeight * 0.5) {
        setActiveLink(headingElements[0].id);
      } else {
        setActiveLink(null);
      }
    }
  }

  window.addEventListener('scroll', () => {
    if (!isTicking) {
      window.requestAnimationFrame(() => {
        updateScrollSpy();
        isTicking = false;
      });
      isTicking = true;
    }
  }, { passive: true });

  // Initial check on load
  setTimeout(updateScrollSpy, 150);

  // If initial URL had hash, handle smooth scroll
  if (window.location.hash) {
    const hashId = window.location.hash.replace(/^#/, '');
    const el = document.getElementById(hashId);
    if (el) {
      setTimeout(() => {
        const offset = getHeaderOffset() + 24;
        const targetY = el.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
        setActiveLink(hashId);
      }, 250);
    }
  }
});

