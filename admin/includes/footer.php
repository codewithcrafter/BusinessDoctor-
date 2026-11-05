    </div><!-- /.admin-content -->
  </main><!-- /.admin-main -->
</div><!-- /.admin-wrapper -->

<!-- Global Confirmation Modal -->
<div class="adm-modal-backdrop" id="confirmModal">
  <div class="adm-modal" role="dialog" aria-modal="true">
    <h3 class="adm-modal-title" id="confirmModalTitle">Please Confirm</h3>
    <div class="adm-modal-body" id="confirmModalText">
      Are you sure you want to perform this action?
    </div>
    <div class="adm-modal-actions">
      <button type="button" class="btn-adm btn-adm-secondary" id="confirmModalCancel">Cancel</button>
      <button type="button" class="btn-adm btn-adm-danger" id="confirmModalProceed">Confirm</button>
    </div>
  </div>
</div>

<!-- Toast Container -->
<div class="adm-toast-container" id="toastContainer"></div>

<!-- Admin JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // 1. Mobile Sidebar Toggle
  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('adminSidebar');
  const overlay = document.getElementById('sidebarOverlay');

  if (toggleBtn && sidebar && overlay) {
    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('open');
    });

    overlay.addEventListener('click', function() {
      sidebar.classList.remove('open');
      overlay.classList.remove('open');
    });
  }

  // 2. Toast Notification Function
  window.showToast = function(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = 'adm-toast' + (type === 'error' ? ' error' : (type === 'warning' ? ' warning' : ''));
    toast.innerHTML = `<span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(15px)';
      toast.style.transition = 'all 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, 3800);
  };

  // 3. Confirmation Dialog Handler
  const confirmModal = document.getElementById('confirmModal');
  const modalText = document.getElementById('confirmModalText');
  const cancelBtn = document.getElementById('confirmModalCancel');
  const proceedBtn = document.getElementById('confirmModalProceed');
  let pendingAction = null;

  function closeModal() {
    confirmModal.style.display = 'none';
    pendingAction = null;
  }

  if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
  if (confirmModal) {
    confirmModal.addEventListener('click', function(e) {
      if (e.target === confirmModal) closeModal();
    });
  }

  if (proceedBtn) {
    proceedBtn.addEventListener('click', function() {
      if (typeof pendingAction === 'function') {
        pendingAction();
      }
      closeModal();
    });
  }

  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', function(e) {
      e.preventDefault();
      const message = this.getAttribute('data-confirm') || 'Are you sure you want to proceed?';
      modalText.textContent = message;
      confirmModal.style.display = 'flex';

      if (this.tagName === 'A') {
        const href = this.getAttribute('href');
        pendingAction = () => { window.location.href = href; };
      } else if (this.type === 'submit' || this.tagName === 'BUTTON') {
        const form = this.closest('form');
        pendingAction = () => { form.submit(); };
      }
    });
  });

  // 4. Auto Slug Generator
  document.querySelectorAll('[data-slug-from]').forEach(slugInput => {
    const sourceId = slugInput.getAttribute('data-slug-from');
    const sourceInput = document.getElementById(sourceId);
    if (!sourceInput) return;

    sourceInput.addEventListener('input', function() {
      // Only auto-generate if user hasn't manually edited slug or if slug was empty
      if (slugInput.dataset.manual !== 'true') {
        const val = this.value.toLowerCase()
          .replace(/[^a-z0-9\s-]/g, '')
          .trim()
          .replace(/\s+/g, '-');
        slugInput.value = val;
      }
    });

    slugInput.addEventListener('input', function() {
      slugInput.dataset.manual = 'true';
    });
  });

  // 5. Copy Text to Clipboard
  document.querySelectorAll('[data-copy]').forEach(btn => {
    btn.addEventListener('click', function() {
      const text = this.getAttribute('data-copy');
      navigator.clipboard.writeText(text).then(() => {
        window.showToast('Copied to clipboard: ' + text, 'info');
      }).catch(() => {
        window.showToast('Failed to copy', 'error');
      });
    });
  });
});
</script>
</body>
</html>

