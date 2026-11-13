/**
 * BusinessDoctor — Executive Blog & Insights Editorial Workspace Engine
 * Pure Vanilla JavaScript: Rich Text Visual Editor + Advanced Markdown Editor
 */

(function (window, document) {
  'use strict';

  // --- STATE ---
  const state = {
    currentMainMode: 'visual', // 'visual' | 'markdown' | 'preview' | 'split'
    markdownSubMode: 'write',   // 'write' | 'preview' | 'split'
    selectedImage: null,
    activeTable: null,
    activeCell: null
  };

  // Safe Protocol Validator
  function isSafeUrl(url) {
    if (!url) return false;
    url = url.trim();
    return /^(https?:\/\/|mailto:|tel:|\/|\.\/|\.\.\/|assets\/|#)/i.test(url);
  }

  // --- MODAL DIALOG UTILITIES ---
  function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
      modal.classList.add('open');
      const firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea');
      if (firstInput) setTimeout(() => firstInput.focus(), 50);
    }
  }

  function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.remove('open');
  }

  // Close menus when clicking outside
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.adm-tb-dropdown-wrap')) {
      document.querySelectorAll('.adm-tb-menu').forEach(m => m.classList.remove('open'));
    }
  });

  function toggleMenu(id) {
    const menu = document.getElementById(id);
    if (!menu) return;
    const isOpen = menu.classList.contains('open');
    document.querySelectorAll('.adm-tb-menu').forEach(m => m.classList.remove('open'));
    if (!isOpen) menu.classList.add('open');
  }

  // Toast Notification
  function showToast(msg, type = 'info') {
    if (typeof window.showToast === 'function') {
      window.showToast(msg, type);
      return;
    }
    let toast = document.getElementById('adm-editor-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'adm-editor-toast';
      toast.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#061326;border:1px solid #06B5F9;color:#0099DB;padding:10px 18px;border-radius:6px;font-family:monospace;font-size:13px;z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,0.5);transition:opacity 0.2s ease;';
      document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.style.display = 'block';
    toast.style.opacity = '1';
    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => { toast.style.display = 'none'; }, 200);
    }, 2800);
  }

  // --- VISUAL EDITOR COMMANDS ---
  function execCmd(command, value = null) {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    canvas.focus();
    document.execCommand(command, false, value);
    syncFromVisual();
    updateToolbarActiveStates();
  }

  function setBlockFormat(tag) {
    if (!tag) return;
    execCmd('formatBlock', '<' + tag + '>');
  }

  function setTextColor(color) {
    execCmd('foreColor', color);
    document.querySelectorAll('.adm-tb-menu').forEach(m => m.classList.remove('open'));
  }

  function setHighlightColor(color) {
    if (!execCmd('hiliteColor', color)) {
      execCmd('backColor', color);
    }
    document.querySelectorAll('.adm-tb-menu').forEach(m => m.classList.remove('open'));
  }

  function setLineSpacing(val) {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    const selection = window.getSelection();
    if (selection && selection.rangeCount > 0) {
      let node = selection.anchorNode;
      if (node && node.nodeType === 3) node = node.parentNode;
      while (node && node !== canvas && !/^(P|H1|H2|H3|H4|LI|BLOCKQUOTE|DIV)$/i.test(node.tagName)) {
        node = node.parentNode;
      }
      if (node && node !== canvas) {
        node.style.lineHeight = val;
      } else {
        canvas.style.lineHeight = val;
      }
    }
    syncFromVisual();
    document.querySelectorAll('.adm-tb-menu').forEach(m => m.classList.remove('open'));
    showToast(`Line spacing set to ${val}`, 'info');
  }

  function setParagraphSpacing(spacing) {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    const selection = window.getSelection();
    let margin = '1.25rem';
    if (spacing === 'compact') margin = '0.65rem';
    if (spacing === 'relaxed') margin = '1.85rem';

    if (selection && selection.rangeCount > 0) {
      let node = selection.anchorNode;
      if (node && node.nodeType === 3) node = node.parentNode;
      while (node && node !== canvas && !/^(P|H1|H2|H3|H4|LI|BLOCKQUOTE|DIV)$/i.test(node.tagName)) {
        node = node.parentNode;
      }
      if (node && node !== canvas) {
        node.style.marginBottom = margin;
      } else {
        canvas.querySelectorAll('p').forEach(p => p.style.marginBottom = margin);
      }
    }
    syncFromVisual();
    document.querySelectorAll('.adm-tb-menu').forEach(m => m.classList.remove('open'));
    showToast(`Paragraph spacing updated: ${spacing}`, 'info');
  }

  function insertKeyTakeaway() {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    canvas.focus();
    const html = `
      <div class="adm-key-takeaway">
        <div class="takeaway-badge">KEY EXECUTIVE TAKEAWAY</div>
        <p>State your strategic insight, core principle, or key takeaway here.</p>
      </div><p><br></p>
    `;
    document.execCommand('insertHTML', false, html);
    syncFromVisual();
    showToast('Inserted Key Takeaway block', 'info');
  }

  function insertVisualCodeBlock() {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    canvas.focus();
    const html = `<pre class="adm-code-block"><code>// Enter code, configuration, or technical architecture here...\nconst architecture = "Scalable Microservices";</code></pre><p><br></p>`;
    document.execCommand('insertHTML', false, html);
    syncFromVisual();
    showToast('Inserted Code Block', 'info');
  }

  // --- HYPERLINK CONTROLS ---
  function openLinkModal() {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    const selection = window.getSelection();
    let linkNode = null;
    let text = '';
    let href = '';
    let target = '_blank';

    if (selection && selection.rangeCount > 0) {
      let node = selection.anchorNode;
      if (node && node.nodeType === 3) node = node.parentNode;
      while (node && node !== canvas && node.tagName !== 'A') {
        node = node.parentNode;
      }
      if (node && node.tagName === 'A') {
        linkNode = node;
        href = node.getAttribute('href') || '';
        text = node.textContent;
        target = node.getAttribute('target') || '_self';
      } else {
        text = selection.toString();
      }
    }

    document.getElementById('linkModalUrl').value = href;
    document.getElementById('linkModalText').value = text;
    document.getElementById('linkModalTarget').checked = (target === '_blank');
    window._editingLinkNode = linkNode;
    openModal('linkModal');
  }

  function applyLinkModal() {
    const url = document.getElementById('linkModalUrl').value.trim();
    const text = document.getElementById('linkModalText').value.trim();
    const isBlank = document.getElementById('linkModalTarget').checked;
    closeModal('linkModal');

    if (!url) {
      showToast('Please provide a URL', 'error');
      return;
    }
    if (!isSafeUrl(url)) {
      showToast('Unsafe URL protocol. Allowed: http, https, mailto, tel, relative', 'error');
      return;
    }

    const canvas = document.getElementById('visualCanvas');
    canvas.focus();

    if (window._editingLinkNode) {
      window._editingLinkNode.setAttribute('href', url);
      if (text) window._editingLinkNode.textContent = text;
      if (isBlank) {
        window._editingLinkNode.setAttribute('target', '_blank');
        window._editingLinkNode.setAttribute('rel', 'noopener noreferrer');
      } else {
        window._editingLinkNode.removeAttribute('target');
        window._editingLinkNode.removeAttribute('rel');
      }
      window._editingLinkNode = null;
    } else {
      const linkText = text || url;
      const targetAttr = isBlank ? ' target="_blank" rel="noopener noreferrer"' : '';
      const html = `<a href="${encodeURI(url)}"${targetAttr}>${escapeHtml(linkText)}</a>`;
      document.execCommand('insertHTML', false, html);
    }

    syncFromVisual();
    showToast('Hyperlink applied', 'info');
  }

  function removeHyperlink() {
    const canvas = document.getElementById('visualCanvas');
    const sel = window.getSelection();
    let unlinked = false;

    if (sel && sel.rangeCount > 0) {
      let node = sel.anchorNode;
      if (node && node.nodeType === 3) node = node.parentNode;
      while (node && node !== canvas && node.tagName !== 'A') {
        node = node.parentNode;
      }
      if (node && node.tagName === 'A') {
        const parent = node.parentNode;
        while (node.firstChild) {
          parent.insertBefore(node.firstChild, node);
        }
        node.remove();
        unlinked = true;
      }
    }

    if (!unlinked) {
      execCmd('unlink');
    }

    syncFromVisual();
    showToast('Hyperlink removed', 'info');
  }

  // --- IMAGE CONTROLS ---
  function openImageModal() {
    document.getElementById('imageModalUrl').value = '';
    document.getElementById('imageModalAlt').value = '';
    document.getElementById('imageModalTitle').value = '';
    openModal('imageModal');
  }

  function applyImageModal() {
    const url = document.getElementById('imageModalUrl').value.trim();
    const alt = document.getElementById('imageModalAlt').value.trim();
    const title = document.getElementById('imageModalTitle').value.trim();
    closeModal('imageModal');

    if (!url) {
      showToast('Image URL is required', 'error');
      return;
    }
    if (!isSafeUrl(url)) {
      showToast('Invalid image URL protocol', 'error');
      return;
    }

    const canvas = document.getElementById('visualCanvas');
    canvas.focus();
    const titleAttr = title ? ` title="${escapeHtml(title)}"` : '';
    const imgHtml = `<img src="${encodeURI(url)}" alt="${escapeHtml(alt)}"${titleAttr} style="max-width:100%; border-radius:6px; margin:1.25rem 0;" /><p><br></p>`;
    document.execCommand('insertHTML', false, imgHtml);
    syncFromVisual();
    showToast('Image inserted', 'info');
  }

  function openEditImageAltModal(img) {
    state.selectedImage = img;
    document.getElementById('editImageAltInput').value = img.getAttribute('alt') || '';
    document.getElementById('editImageTitleInput').value = img.getAttribute('title') || '';
    openModal('editImageAltModal');
  }

  function applyEditImageAltModal() {
    if (state.selectedImage) {
      const alt = document.getElementById('editImageAltInput').value.trim();
      const title = document.getElementById('editImageTitleInput').value.trim();
      state.selectedImage.setAttribute('alt', alt);
      if (title) state.selectedImage.setAttribute('title', title);
      else state.selectedImage.removeAttribute('title');
      syncFromVisual();
      showToast('Image details updated', 'info');
    }
    closeModal('editImageAltModal');
    state.selectedImage = null;
  }

  // --- TABLE CONTROLS ---
  function openTableModal() {
    document.getElementById('tableModalRows').value = '3';
    document.getElementById('tableModalCols').value = '3';
    document.getElementById('tableModalHeader').checked = true;
    openModal('tableModal');
  }

  function applyTableModal() {
    const rows = Math.min(20, Math.max(1, parseInt(document.getElementById('tableModalRows').value) || 3));
    const cols = Math.min(10, Math.max(1, parseInt(document.getElementById('tableModalCols').value) || 3));
    const hasHeader = document.getElementById('tableModalHeader').checked;
    closeModal('tableModal');

    let tableHtml = '<div class="adm-table-wrap"><table class="adm-editor-table">';
    if (hasHeader) {
      tableHtml += '<thead><tr>';
      for (let c = 1; c <= cols; c++) {
        tableHtml += `<th>Header ${c}</th>`;
      }
      tableHtml += '</tr></thead>';
    }
    tableHtml += '<tbody>';
    for (let r = 1; r <= rows; r++) {
      tableHtml += '<tr>';
      for (let c = 1; c <= cols; c++) {
        tableHtml += `<td>Cell ${r}-${c}</td>`;
      }
      tableHtml += '</tr>';
    }
    tableHtml += '</tbody></table></div><p><br></p>';

    const canvas = document.getElementById('visualCanvas');
    canvas.focus();
    document.execCommand('insertHTML', false, tableHtml);
    syncFromVisual();
    showToast(`Inserted ${rows}x${cols} table`, 'info');
  }

  // Detect current active table / cell
  function getActiveTableCell() {
    const canvas = document.getElementById('visualCanvas');
    const sel = window.getSelection();
    if (sel && sel.rangeCount > 0) {
      let node = sel.anchorNode;
      if (node && node.nodeType === 3) node = node.parentNode;
      while (node && node !== canvas) {
        if (/^(TD|TH)$/i.test(node.tagName)) {
          state.activeCell = node;
          state.activeTable = node.closest('table');
          return node;
        }
        node = node.parentNode;
      }
    }
    return state.activeCell || null;
  }

  function tableAddRow(above = false) {
    const cell = getActiveTableCell();
    if (!cell) {
      showToast('Click inside a table cell first', 'error');
      return;
    }
    const row = cell.closest('tr');
    const table = row.closest('table');
    const cols = row.children.length;
    const newRow = document.createElement('tr');
    for (let i = 0; i < cols; i++) {
      const td = document.createElement('td');
      td.innerHTML = 'New cell';
      newRow.appendChild(td);
    }
    if (above) {
      row.parentNode.insertBefore(newRow, row);
    } else {
      row.parentNode.insertBefore(newRow, row.nextSibling);
    }
    syncFromVisual();
    showToast(above ? 'Added row above' : 'Added row below', 'info');
  }

  function tableDeleteRow() {
    const cell = getActiveTableCell();
    if (!cell) {
      showToast('Click inside a table cell first', 'error');
      return;
    }
    const row = cell.closest('tr');
    row.remove();
    state.activeCell = null;
    syncFromVisual();
    showToast('Deleted row', 'info');
  }

  function tableAddCol(left = false) {
    const cell = getActiveTableCell();
    if (!cell) {
      showToast('Click inside a table cell first', 'error');
      return;
    }
    const table = cell.closest('table');
    const cellIndex = cell.cellIndex;
    const rows = table.querySelectorAll('tr');
    rows.forEach(r => {
      const isHeader = r.parentElement.tagName === 'THEAD' || r.querySelector('th');
      const newCell = document.createElement(isHeader ? 'th' : 'td');
      newCell.innerHTML = isHeader ? 'Header' : 'Cell';
      const refCell = r.children[cellIndex];
      if (refCell) {
        if (left) {
          r.insertBefore(newCell, refCell);
        } else {
          r.insertBefore(newCell, refCell.nextSibling);
        }
      } else {
        r.appendChild(newCell);
      }
    });
    syncFromVisual();
    showToast(left ? 'Added column left' : 'Added column right', 'info');
  }

  function tableDeleteCol() {
    const cell = getActiveTableCell();
    if (!cell) {
      showToast('Click inside a table cell first', 'error');
      return;
    }
    const table = cell.closest('table');
    const cellIndex = cell.cellIndex;
    const rows = table.querySelectorAll('tr');
    rows.forEach(r => {
      if (r.children[cellIndex]) {
        r.children[cellIndex].remove();
      }
    });
    state.activeCell = null;
    syncFromVisual();
    showToast('Deleted column', 'info');
  }

  function tableDeleteTable() {
    const cell = getActiveTableCell();
    if (!cell) {
      showToast('Click inside a table cell first', 'error');
      return;
    }
    const table = cell.closest('table');
    const wrap = table.closest('.adm-table-wrap') || table;
    wrap.remove();
    state.activeCell = null;
    state.activeTable = null;
    syncFromVisual();
    showToast('Deleted entire table', 'info');
  }

  // --- TOOLBAR ACTIVE STATE HIGHLIGHTS ---
  function updateToolbarActiveStates() {
    const commands = [
      { cmd: 'bold', btn: 'tbBtnBold' },
      { cmd: 'italic', btn: 'tbBtnItalic' },
      { cmd: 'underline', btn: 'tbBtnUnderline' },
      { cmd: 'strikeThrough', btn: 'tbBtnStrike' },
      { cmd: 'justifyLeft', btn: 'tbBtnAlignLeft' },
      { cmd: 'justifyCenter', btn: 'tbBtnAlignCenter' },
      { cmd: 'justifyRight', btn: 'tbBtnAlignRight' },
      { cmd: 'justifyFull', btn: 'tbBtnAlignJustify' },
      { cmd: 'insertUnorderedList', btn: 'tbBtnBulletList' },
      { cmd: 'insertOrderedList', btn: 'tbBtnNumberedList' }
    ];

    commands.forEach(item => {
      const el = document.getElementById(item.btn);
      if (el) {
        try {
          if (document.queryCommandState(item.cmd)) {
            el.classList.add('active');
          } else {
            el.classList.remove('active');
          }
        } catch (e) { }
      }
    });
  }

  // --- MARKDOWN TOOLBAR & SHORTCUTS (Reference Image 2) ---
  function insertMdSyntax(prefix, suffix = '', defaultText = 'text') {
    const textarea = document.getElementById('markdownEditor');
    if (!textarea) return;
    const text = textarea.value;
    let start = textarea.selectionStart;
    let end = textarea.selectionEnd;

    if (start === undefined || start === null || (start === 0 && end === 0 && document.activeElement !== textarea)) {
      start = text.length;
      end = text.length;
    }

    const selected = text.substring(start, end);
    const content = selected || defaultText;
    const replacement = prefix + content + suffix;

    textarea.value = text.substring(0, start) + replacement + text.substring(end);
    textarea.focus();
    const newCursor = start + replacement.length;
    textarea.setSelectionRange(newCursor, newCursor);

    syncFromMarkdown();
  }

  function insertMdTable() {
    const template = `\n| Column 1 | Column 2 | Column 3 |\n| :--- | :---: | ---: |\n| Data 1 | Data 2 | Data 3 |\n| Item A | Item B | Item C |\n\n`;
    insertMdSyntax(template, '', '');
  }

  function insertMdLink() {
    insertMdSyntax('[', '](https://example.com)', 'Link text');
  }

  function insertMdImage() {
    insertMdSyntax('![', '](assets/images/insight-sample.webp)', 'Image description');
  }

  function insertMdCode() {
    const textarea = document.getElementById('markdownEditor');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selected = textarea.value.substring(start, end);

    if (selected.includes('\n')) {
      insertMdSyntax('```javascript\n', '\n```', selected || '// write code here');
    } else {
      insertMdSyntax('`', '`', selected || 'code');
    }
  }

  // --- MARKDOWN WORKSPACE SUB-MODES ---
  function setMarkdownSubMode(submode) {
    state.markdownSubMode = submode;
    document.querySelectorAll('.adm-md-submode-btn').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.submode === submode);
    });

    const wrap = document.getElementById('mdWorkspaceGrid');
    const editorCol = document.getElementById('mdEditorCol');
    const previewCol = document.getElementById('mdPreviewCol');

    if (submode === 'write') {
      wrap.style.display = 'block';
      editorCol.style.display = 'block';
      previewCol.style.display = 'none';
    } else if (submode === 'preview') {
      wrap.style.display = 'block';
      editorCol.style.display = 'none';
      previewCol.style.display = 'block';
      updateMdSubPreview();
    } else if (submode === 'split') {
      wrap.style.display = 'grid';
      wrap.style.gridTemplateColumns = '1fr 1fr';
      wrap.style.gap = '1.25rem';
      editorCol.style.display = 'block';
      previewCol.style.display = 'block';
      updateMdSubPreview();
    }
  }

  function updateMdSubPreview() {
    const md = document.getElementById('markdownEditor').value;
    const container = document.getElementById('mdPreviewOutput');
    if (container) {
      container.innerHTML = markdownToHtml(md);
    }
  }

  // Markdown Action Bar actions
  function appendMarkdownToBody() {
    const md = document.getElementById('markdownEditor').value;
    const htmlToAppend = markdownToHtml(md);
    const canvas = document.getElementById('visualCanvas');
    canvas.innerHTML += '<br>' + htmlToAppend;
    syncFromVisual();
    showToast('Appended Markdown to article body', 'info');
  }

  function applyMarkdownReplaceBody() {
    const md = document.getElementById('markdownEditor').value;
    const canvas = document.getElementById('visualCanvas');
    canvas.innerHTML = markdownToHtml(md);
    syncFromVisual();
    showToast('Applied Markdown to replace article body', 'info');
  }

  // --- MARKDOWN <-> HTML PARSER & CONVERTER ---
  function markdownToHtml(md) {
    if (!md) return '';
    let text = md;

    // 1. Code blocks (fenced ```)
    const codeBlocks = [];
    text = text.replace(/```([a-zA-Z0-9_-]*)\n([\s\S]*?)```/g, function (_, lang, code) {
      const placeholder = `__CODE_BLOCK_${codeBlocks.length}__`;
      const escapedCode = escapeHtml(code.trim());
      codeBlocks.push(`<pre class="adm-code-block"><code class="language-${lang}">${escapedCode}</code></pre>`);
      return placeholder;
    });

    // 2. Tables
    text = text.replace(/((?:\|[^\n]+\|\r?\n)+)/g, function (match) {
      const lines = match.trim().split('\n').map(l => l.trim()).filter(Boolean);
      if (lines.length < 2) return match;
      
      const headerLine = lines[0];
      const separatorLine = lines[1];
      if (!separatorLine.includes('-')) return match;

      const parseCells = line => line.replace(/^\||\|$/g, '').split('|').map(c => c.trim());
      const headers = parseCells(headerLine);
      const rows = lines.slice(2);

      let table = '<div class="adm-table-wrap"><table class="adm-editor-table"><thead><tr>';
      headers.forEach(h => { table += `<th>${inlineMarkdown(h)}</th>`; });
      table += '</tr></thead><tbody>';

      rows.forEach(r => {
        const cells = parseCells(r);
        table += '<tr>';
        cells.forEach(c => { table += `<td>${inlineMarkdown(c)}</td>`; });
        table += '</tr>';
      });

      table += '</tbody></table></div>';
      return table;
    });

    // 3. Key Takeaway Blocks (::: takeaway ... :::)
    text = text.replace(/:::\s*takeaway\s*\n([\s\S]*?)\n:::/gi, function (_, content) {
      return `<div class="adm-key-takeaway"><div class="takeaway-badge">KEY EXECUTIVE TAKEAWAY</div><p>${inlineMarkdown(content.trim())}</p></div>`;
    });

    // 4. Blockquotes
    text = text.replace(/^(?:> ?[^\n]*\n?)+/gm, function (match) {
      const clean = match.replace(/^> ?/gm, '').trim();
      return `<blockquote>${inlineMarkdown(clean)}</blockquote>`;
    });

    // 5. Headings
    text = text.replace(/^### (.*$)/gim, '<h3>$1</h3>');
    text = text.replace(/^## (.*$)/gim, '<h2>$1</h2>');
    text = text.replace(/^# (.*$)/gim, '<h1>$1</h1>');

    // 6. Horizontal Rules
    text = text.replace(/^(?:---|\*\*\*|___)\s*$/gm, '<hr>');

    // 7. Lists (Unordered & Ordered with nesting)
    text = parseMarkdownLists(text);

    // 8. Paragraphs
    const blocks = text.split(/\n{2,}/);
    text = blocks.map(block => {
      block = block.trim();
      if (!block) return '';
      if (/^<(h1|h2|h3|h4|div|pre|blockquote|ul|ol|hr|table)/i.test(block) || block.startsWith('__CODE_BLOCK_')) {
        return block;
      }
      return `<p>${inlineMarkdown(block).replace(/\n/g, '<br>')}</p>`;
    }).join('\n\n');

    // Restore Code Blocks
    codeBlocks.forEach((cb, idx) => {
      text = text.replace(`__CODE_BLOCK_${idx}__`, cb);
    });

    return text;
  }

  function inlineMarkdown(str) {
    if (!str) return '';
    return str
      // Images ![alt](src "title")
      .replace(/!\[([^\]]*)\]\(([^)"]+)(?:\s+"([^"]*)")?\)/g, '<img alt="$1" src="$2" title="$3" style="max-width:100%; border-radius:6px; margin:1rem 0;" />')
      // Links [text](href "title")
      .replace(/\[([^\]]+)\]\(([^)"]+)(?:\s+"([^"]*)")?\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>')
      // Inline Code `code`
      .replace(/`([^`]+)`/g, '<code>$1</code>')
      // Bold & Italic
      .replace(/\*\*\*([^*]+)\*\*\*/g, '<strong><em>$1</em></strong>')
      .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
      .replace(/\*([^*]+)\*/g, '<em>$1</em>')
      .replace(/__([^_]+)__/g, '<strong>$1</strong>')
      .replace(/_([^_]+)_/g, '<em>$1</em>')
      // Strikethrough ~~text~~
      .replace(/~~([^~]+)~~/g, '<s>$1</s>');
  }

  function parseMarkdownLists(text) {
    // Process unordered and ordered lines
    const lines = text.split('\n');
    let inUl = false;
    let inOl = false;
    const output = [];

    lines.forEach(line => {
      const ulMatch = line.match(/^(\s*)[-*+]\s+(.*)$/);
      const olMatch = line.match(/^(\s*)\d+\.\s+(.*)$/);

      if (ulMatch) {
        if (!inUl) {
          if (inOl) { output.push('</ol>'); inOl = false; }
          output.push('<ul>');
          inUl = true;
        }
        output.push(`  <li>${inlineMarkdown(ulMatch[2])}</li>`);
      } else if (olMatch) {
        if (!inOl) {
          if (inUl) { output.push('</ul>'); inUl = false; }
          output.push('<ol>');
          inOl = true;
        }
        output.push(`  <li>${inlineMarkdown(olMatch[2])}</li>`);
      } else {
        if (inUl) { output.push('</ul>'); inUl = false; }
        if (inOl) { output.push('</ol>'); inOl = false; }
        output.push(line);
      }
    });

    if (inUl) output.push('</ul>');
    if (inOl) output.push('</ol>');

    return output.join('\n');
  }

  // --- HTML TO MARKDOWN SERIALIZER ---
  function htmlToMarkdown(html) {
    if (!html) return '';
    const div = document.createElement('div');
    div.innerHTML = html;

    function walk(node) {
      if (node.nodeType === 3) return node.nodeValue;
      if (node.nodeType !== 1) return '';

      const tag = node.tagName.toLowerCase();
      const children = Array.from(node.childNodes).map(walk).join('');

      switch (tag) {
        case 'h1': return `\n\n# ${children.trim()}\n\n`;
        case 'h2': return `\n\n## ${children.trim()}\n\n`;
        case 'h3': return `\n\n### ${children.trim()}\n\n`;
        case 'strong': case 'b': return `**${children}**`;
        case 'em': case 'i': return `*${children}*`;
        case 'u': return `<u>${children}</u>`;
        case 's': case 'strike': case 'del': return `~~${children}~~`;
        case 'blockquote': return `\n\n> ${children.trim().replace(/\n/g, '\n> ')}\n\n`;
        case 'code':
          return node.parentNode && node.parentNode.tagName.toLowerCase() === 'pre' ? children : `\`${children}\``;
        case 'pre':
          return `\n\n\`\`\`\n${node.textContent.trim()}\n\`\`\`\n\n`;
        case 'hr': return `\n\n---\n\n`;
        case 'a':
          const href = node.getAttribute('href') || '#';
          return `[${children}](${href})`;
        case 'img':
          const alt = node.getAttribute('alt') || '';
          const src = node.getAttribute('src') || '';
          return `![${alt}](${src})`;
        case 'ul': return `\n${children}\n`;
        case 'ol': return `\n${children}\n`;
        case 'li':
          const isOl = node.parentNode && node.parentNode.tagName.toLowerCase() === 'ol';
          const prefix = isOl ? '1. ' : '- ';
          return `${prefix}${children.trim()}\n`;
        case 'p': return `\n\n${children.trim()}\n\n`;
        case 'br': return `\n`;
        case 'table':
          return serializeTableToMd(node);
        case 'div':
          if (node.classList.contains('adm-key-takeaway')) {
            const p = node.querySelector('p');
            const txt = p ? p.textContent.trim() : node.textContent.trim();
            return `\n\n::: takeaway\n${txt}\n:::\n\n`;
          }
          return `\n${children}\n`;
        default: return children;
      }
    }

    function serializeTableToMd(table) {
      let md = '\n\n';
      const thead = table.querySelector('thead');
      const rows = Array.from(table.querySelectorAll('tr'));
      if (rows.length === 0) return '';

      const firstRowCells = Array.from(rows[0].querySelectorAll('th, td'));
      md += '| ' + firstRowCells.map(c => c.textContent.trim()).join(' | ') + ' |\n';
      md += '| ' + firstRowCells.map(() => '---').join(' | ') + ' |\n';

      const dataRows = thead ? rows.slice(1) : rows.slice(1);
      dataRows.forEach(row => {
        const cells = Array.from(row.querySelectorAll('th, td'));
        md += '| ' + cells.map(c => c.textContent.trim()).join(' | ') + ' |\n';
      });

      return md + '\n';
    }

    return walk(div).trim().replace(/\n{3,}/g, '\n\n');
  }

  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  // --- SYNCHRONIZATION ---
  function syncFromVisual() {
    const canvas = document.getElementById('visualCanvas');
    if (!canvas) return;
    const html = canvas.innerHTML;

    // Update hidden POST input
    const finalInput = document.getElementById('finalContentInput');
    if (finalInput) finalInput.value = html;

    // Sync markdown editor
    const mdEditor = document.getElementById('markdownEditor');
    if (mdEditor && document.activeElement !== mdEditor) {
      mdEditor.value = htmlToMarkdown(html);
    }

    updateMetrics(canvas.innerText || '');
    updateLivePreview();
    if (state.markdownSubMode !== 'write') updateMdSubPreview();
  }

  function syncFromMarkdown() {
    const mdEditor = document.getElementById('markdownEditor');
    if (!mdEditor) return;
    const md = mdEditor.value;
    const html = markdownToHtml(md);

    // Update hidden POST input
    const finalInput = document.getElementById('finalContentInput');
    if (finalInput) finalInput.value = html;

    // Sync visual canvas
    const canvas = document.getElementById('visualCanvas');
    if (canvas && document.activeElement !== canvas) {
      canvas.innerHTML = html;
    }

    updateMetrics(md);
    updateLivePreview();
    if (state.markdownSubMode !== 'write') updateMdSubPreview();
  }

  function updateMetrics(text) {
    const words = text.trim() ? text.trim().split(/\s+/).filter(Boolean).length : 0;
    const chars = text.length;
    const mins = Math.max(1, Math.ceil(words / 200));

    const wEl = document.getElementById('metricWords');
    const cEl = document.getElementById('metricChars');
    const tEl = document.getElementById('metricTime');
    const rInput = document.getElementById('readingTime');

    if (wEl) wEl.textContent = words.toLocaleString();
    if (cEl) cEl.textContent = chars.toLocaleString();
    if (tEl) tEl.textContent = `${mins} min read`;
    if (rInput) rInput.value = `${mins} min read`;

    // Markdown bottom metrics
    const mdWords = document.getElementById('mdMetricWords');
    const mdChars = document.getElementById('mdMetricChars');
    if (mdWords) mdWords.textContent = words.toLocaleString();
    if (mdChars) mdChars.textContent = chars.toLocaleString();
  }

  // --- LIVE PREVIEW RENDERER (Insight-Detail Parity) ---
  function updateLivePreview() {
    const container = document.getElementById('livePreviewContainer');
    if (!container) return;

    const title = (document.getElementById('blogTitle') || {}).value || 'Untitled Engineering Perspective';
    const category = (document.getElementById('blogCategory') || {}).value || 'Web & Digital Strategy';
    const author = (document.getElementById('blogAuthor') || {}).value || 'BusinessDoctor Senior Architect';
    const authorTitle = (document.getElementById('authorTitle') || {}).value || 'Enterprise Solutions Practice';
    const excerpt = (document.getElementById('blogExcerpt') || {}).value || '';
    const readingTime = (document.getElementById('readingTime') || {}).value || '5 min read';
    const coverImg = (document.getElementById('featuredImagePath') || {}).value || '';
    const coverAlt = (document.getElementById('coverImageAlt') || {}).value || title;
    const canvas = document.getElementById('visualCanvas');
    const contentHtml = canvas ? canvas.innerHTML : '';

    let coverMarkup = '';
    if (coverImg) {
      coverMarkup = `<div style="margin-bottom: 2rem; border-radius: 8px; overflow: hidden; border: 1px solid #E2E8F0;"><img src="../${coverImg}" alt="${coverAlt}" style="width: 100%; max-height: 380px; object-fit: cover; display: block;"></div>`;
    }

    container.innerHTML = `
      <div style="max-width: 780px; margin: 0 auto; font-family: Inter, sans-serif;">
        <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 1rem; flex-wrap: wrap;">
          <span style="background: #061326; color: #06B5F9; font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 4px; font-family: monospace;">${category.toUpperCase()}</span>
          <span style="font-family: monospace; font-size: 0.78rem; color: #64748B;">● ${readingTime}</span>
          <span style="font-family: monospace; font-size: 0.78rem; color: #94A3B8;">● ${new Date().toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}</span>
        </div>

        <h1 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2.2rem; font-weight: 800; color: #061326; line-height: 1.25; margin-bottom: 1.5rem;">
          ${escapeHtml(title)}
        </h1>

        <div style="display: flex; align-items: center; gap: 0.85rem; padding: 1rem 0; margin-bottom: 2rem; border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0;">
          <div style="width: 44px; height: 44px; border-radius: 6px; background: #061326; color: #06B5F9; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem;">
            ${author.substring(0, 2).toUpperCase()}
          </div>
          <div>
            <div style="font-weight: 700; color: #0F172A; font-size: 0.95rem;">${escapeHtml(author)}</div>
            <div style="font-size: 0.78rem; color: #64748B; font-family: monospace;">${escapeHtml(authorTitle)}</div>
          </div>
        </div>

        ${coverMarkup}

        ${excerpt ? `
          <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-left: 4px solid #06B5F9; border-radius: 8px; padding: 1.5rem; margin-bottom: 2.5rem;">
            <div style="font-size: 0.72rem; font-family: monospace; text-transform: uppercase; color: #06B5F9; letter-spacing: 0.08em; font-weight: 700; margin-bottom: 0.5rem;">
              KEY EXECUTIVE SUMMARY
            </div>
            <p style="font-size: 1.05rem; line-height: 1.65; color: #1E293B; margin: 0; font-style: italic;">
              ${escapeHtml(excerpt)}
            </p>
          </div>
        ` : ''}

        <div style="font-size: 1.08rem; line-height: 1.85; color: #334155;">
          ${contentHtml}
        </div>
      </div>
    `;

    updateSerpPreview();
  }

  function updateSerpPreview() {
    const titleEl = document.getElementById('seoTitle') || document.getElementById('blogTitle');
    const slugEl = document.getElementById('blogSlug');
    const descEl = document.getElementById('seoDescription') || document.getElementById('blogExcerpt');

    const title = (titleEl ? titleEl.value : '') || 'BusinessDoctor Tech Perspective';
    const slug = (slugEl ? slugEl.value : '') || 'article-slug';
    const desc = (descEl ? descEl.value : '') || 'Engineering architecture and digital growth frameworks authored by BusinessDoctor.';

    const serpTitle = document.getElementById('serpTitlePreview');
    const serpUrl = document.getElementById('serpUrlPreview');
    const serpDesc = document.getElementById('serpDescPreview');

    if (serpTitle) serpTitle.textContent = title + ' — Perspectives | BusinessDoctor';
    if (serpUrl) serpUrl.textContent = 'https://demo.businesdoctor.com/insight-detail.php?slug=' + slug;
    if (serpDesc) serpDesc.textContent = desc.substring(0, 160);

    const titleCount = document.getElementById('seoTitleCount');
    const descCount = document.getElementById('seoDescCount');
    if (titleCount && document.getElementById('seoTitle')) {
      titleCount.textContent = `${document.getElementById('seoTitle').value.length}/60`;
    }
    if (descCount && document.getElementById('seoDescription')) {
      descCount.textContent = `${document.getElementById('seoDescription').value.length}/160`;
    }
  }

  // --- MAIN WORKSPACE MODE SWITCHER ---
  function switchEditorMode(mode) {
    const prevMode = state.currentMainMode;
    state.currentMainMode = mode;
    document.querySelectorAll('.adm-mode-tab').forEach(t => t.classList.remove('active'));

    const visualPane = document.getElementById('visualPane');
    const markdownPane = document.getElementById('markdownPane');
    const previewPane = document.getElementById('previewPane');
    const container = document.getElementById('editorContainer');

    if (container) container.className = '';
    if (visualPane) visualPane.style.display = 'none';
    if (markdownPane) markdownPane.style.display = 'none';
    if (previewPane) previewPane.style.display = 'none';

    // Synchronize content before activating new mode
    if (mode === 'markdown' && prevMode !== 'markdown') {
      const canvas = document.getElementById('visualCanvas');
      const mdEditor = document.getElementById('markdownEditor');
      if (canvas && mdEditor) {
        mdEditor.value = htmlToMarkdown(canvas.innerHTML);
      }
    } else if (mode === 'visual' && prevMode === 'markdown') {
      const canvas = document.getElementById('visualCanvas');
      const mdEditor = document.getElementById('markdownEditor');
      if (canvas && mdEditor) {
        canvas.innerHTML = markdownToHtml(mdEditor.value);
      }
    }

    if (mode === 'visual') {
      const tab = document.getElementById('tabVisual');
      if (tab) tab.classList.add('active');
      if (visualPane) visualPane.style.display = 'block';
    } else if (mode === 'markdown') {
      const tab = document.getElementById('tabMarkdown');
      if (tab) tab.classList.add('active');
      if (markdownPane) markdownPane.style.display = 'block';
      setMarkdownSubMode(state.markdownSubMode);
    } else if (mode === 'preview') {
      const tab = document.getElementById('tabPreview');
      if (tab) tab.classList.add('active');
      updateLivePreview();
      if (previewPane) previewPane.style.display = 'block';
    } else if (mode === 'split') {
      const tab = document.getElementById('tabSplit');
      if (tab) tab.classList.add('active');
      if (container) container.className = 'adm-editor-split';
      if (visualPane) visualPane.style.display = 'block';
      updateLivePreview();
      if (previewPane) previewPane.style.display = 'block';
    }
  }

  // --- INITIALIZATION ---
  document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('visualCanvas');
    const mdEditor = document.getElementById('markdownEditor');

    if (canvas) {
      canvas.addEventListener('input', syncFromVisual);
      canvas.addEventListener('keyup', updateToolbarActiveStates);
      canvas.addEventListener('mouseup', updateToolbarActiveStates);

      // Click on image opens edit alt modal
      canvas.addEventListener('click', function (e) {
        if (e.target.tagName === 'IMG') {
          openEditImageAltModal(e.target);
        }
      });
    }

    if (mdEditor) {
      mdEditor.addEventListener('input', syncFromMarkdown);
    }

    // Sync input events from metadata fields
    ['blogTitle', 'blogCategory', 'blogAuthor', 'authorTitle', 'blogExcerpt', 'coverImageAlt', 'seoTitle', 'seoDescription', 'blogSlug'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('input', updateLivePreview);
    });

    // Initial sync
    if (canvas && canvas.innerHTML.trim()) {
      syncFromVisual();
    } else if (mdEditor && mdEditor.value.trim()) {
      syncFromMarkdown();
    } else {
      updateLivePreview();
    }
  });

  // Export functions to global scope for HTML onclick bindings
  window.execCmd = execCmd;
  window.setBlockFormat = setBlockFormat;
  window.setTextColor = setTextColor;
  window.setHighlightColor = setHighlightColor;
  window.setLineSpacing = setLineSpacing;
  window.setParagraphSpacing = setParagraphSpacing;
  window.insertKeyTakeaway = insertKeyTakeaway;
  window.insertVisualCodeBlock = insertVisualCodeBlock;
  window.openLinkModal = openLinkModal;
  window.applyLinkModal = applyLinkModal;
  window.removeHyperlink = removeHyperlink;
  window.openImageModal = openImageModal;
  window.applyImageModal = applyImageModal;
  window.openEditImageAltModal = openEditImageAltModal;
  window.applyEditImageAltModal = applyEditImageAltModal;
  window.openTableModal = openTableModal;
  window.applyTableModal = applyTableModal;
  window.tableAddRow = tableAddRow;
  window.tableDeleteRow = tableDeleteRow;
  window.tableAddCol = tableAddCol;
  window.tableDeleteCol = tableDeleteCol;
  window.tableDeleteTable = tableDeleteTable;
  window.toggleMenu = toggleMenu;
  window.openModal = openModal;
  window.closeModal = closeModal;
  window.insertMdSyntax = insertMdSyntax;
  window.insertMdTable = insertMdTable;
  window.insertMdLink = insertMdLink;
  window.insertMdImage = insertMdImage;
  window.insertMdCode = insertMdCode;
  window.setMarkdownSubMode = setMarkdownSubMode;
  window.appendMarkdownToBody = appendMarkdownToBody;
  window.applyMarkdownReplaceBody = applyMarkdownReplaceBody;
  window.switchEditorMode = switchEditorMode;
  window.markdownToHtml = markdownToHtml;
  window.htmlToMarkdown = htmlToMarkdown;
  window.syncFromVisual = syncFromVisual;
  window.syncFromMarkdown = syncFromMarkdown;
  window.updateLivePreview = updateLivePreview;

})(window, document);
