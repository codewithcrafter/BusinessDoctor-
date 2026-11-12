/**
 * BusinessDoctor - Global Lead Generation Popup Controller
 * Appears automatically after 5 seconds on eligible public pages.
 * Displays ONLY ONCE across the entire website per visitor.
 * Dismissal (X button, backdrop, Escape) or successful submission permanently prevents future display.
 */

(function () {
  'use strict';

  // 1. Strict Homepage-Only Rule: Never run on internal pages or admin portal
  var currentPath = (window.location.pathname || '').replace(/\/+$/, '') || '/';
  
  // Strip subfolder if running on local subpath /businessdoctor
  var relativePath = currentPath;
  if (relativePath.indexOf('/businessdoctor') === 0) {
    relativePath = relativePath.substring(15) || '/';
  }

  var isHomepage = (relativePath === '/' || relativePath === '/index.php' || relativePath === '');

  // Abort immediately if not on the public homepage or if on admin portal
  if (!isHomepage || /\/admin(\/|$|\.php)/i.test(currentPath)) {
    return;
  }

  // 2. Prevent duplicate script initializations
  if (window.__bdrLeadPopupInitialized) {
    return;
  }
  window.__bdrLeadPopupInitialized = true;

  var STORAGE_KEY = 'bdr_lead_popup_completed';
  var POPUP_DELAY_MS = 5000; // Exactly 5 seconds after page ready

  // Persistence helpers: localStorage with first-party cookie fallback
  // Dismissal is ONLY persisted after user closes, clicks backdrop, presses Escape, or submits
  function isPopupDismissed() {
    try {
      if (typeof window.localStorage !== 'undefined') {
        var val = window.localStorage.getItem(STORAGE_KEY) || window.localStorage.getItem('bdr_lead_popup_dismissed');
        if (val === 'dismissed' || val === 'submitted') {
          return true;
        }
      }
    } catch (e) {}

    // Cookie fallback check
    try {
      var match = document.cookie.match(new RegExp('(?:^|; )' + STORAGE_KEY + '=([^;]*)'));
      if (match && match[1]) {
        var cVal = decodeURIComponent(match[1]);
        if (cVal === 'dismissed' || cVal === 'submitted') {
          return true;
        }
      }
      var matchOld = document.cookie.match(/(?:^|; )bdr_lead_popup_dismissed=([^;]*)/);
      if (matchOld && (matchOld[1] === 'true' || matchOld[1] === 'dismissed' || matchOld[1] === 'submitted')) {
        return true;
      }
    } catch (e) {}

    return false;
  }

  function setPopupDismissed(reason) {
    reason = reason || 'dismissed';
    try {
      if (typeof window.localStorage !== 'undefined') {
        window.localStorage.setItem(STORAGE_KEY, reason);
      }
    } catch (e) {}

    // Cookie fallback: 365 days, path=/, SameSite=Lax
    try {
      var d = new Date();
      d.setTime(d.getTime() + 365 * 24 * 60 * 60 * 1000);
      document.cookie = STORAGE_KEY + '=' + encodeURIComponent(reason) + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
    } catch (e) {}
  }

  function resetPopupStorage() {
    try {
      if (typeof window.localStorage !== 'undefined') {
        window.localStorage.removeItem(STORAGE_KEY);
        window.localStorage.removeItem('bdr_lead_popup_dismissed');
      }
    } catch (e) {}
    try {
      if (typeof window.sessionStorage !== 'undefined') {
        window.sessionStorage.removeItem('bdr_lead_popup_displayed');
      }
    } catch (e) {}
    try {
      document.cookie = STORAGE_KEY + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax';
      document.cookie = 'bdr_lead_popup_dismissed=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax';
    } catch (e) {}
  }

  // Verification helper: Confirm popup is physically rendered and visible in DOM
  function isModalActuallyVisible(element) {
    if (!element) return false;
    if (!element.classList.contains('is-active')) return false;

    try {
      var style = window.getComputedStyle ? window.getComputedStyle(element) : element.currentStyle;
      if (style) {
        if (style.display === 'none' || style.visibility === 'hidden') {
          return false;
        }
      }
      var rect = element.getBoundingClientRect ? element.getBoundingClientRect() : null;
      if (rect && (rect.width > 0 && rect.height > 0)) {
        return true;
      }
      return (element.offsetWidth > 0 || element.offsetHeight > 0);
    } catch (e) {
      return element.classList.contains('is-active');
    }
  }

  // Expose test utilities on window
  window.bdrIsPopupDismissed = isPopupDismissed;
  window.bdrIsPopupCompleted = isPopupDismissed;
  window.bdrSetPopupDismissed = setPopupDismissed;
  window.bdrSetPopupCompleted = setPopupDismissed;
  window.bdrResetPopupStorage = resetPopupStorage;
  window.bdrIsModalActuallyVisible = function () {
    return isModalActuallyVisible(document.getElementById('bdrLeadPopupModal'));
  };

  // Immediate check: If visitor has already dismissed or submitted, abort immediately
  if (isPopupDismissed()) {
    return;
  }

  var isOpen = false;
  var timerId = null;

  function initLeadPopup() {
    // Re-check in case another tab or script updated storage
    if (isPopupDismissed()) {
      return;
    }

    var modal = document.getElementById('bdrLeadPopupModal');
    if (!modal) return;

    var backdrop = document.getElementById('bdrPopupBackdrop');
    var closeBtn = document.getElementById('bdrPopupCloseBtn');
    var doneBtn = document.getElementById('bdrPopupDoneBtn');
    var form = document.getElementById('bdrLeadPopupForm');
    var successView = document.getElementById('bdrPopupSuccess');
    var headerElem = modal.querySelector('.bdr-popup-header');
    var alertBox = document.getElementById('bdrPopupAlert');
    var submitBtn = document.getElementById('bdrPopupSubmitBtn');
    var sourceUrlInput = document.getElementById('bdrPopupSourceUrl');

    var nameInput = document.getElementById('bdrPopupName');
    var emailInput = document.getElementById('bdrPopupEmail');
    var phoneInput = document.getElementById('bdrPopupPhone');

    var errName = document.getElementById('bdrErrName');
    var errEmail = document.getElementById('bdrErrEmail');
    var errPhone = document.getElementById('bdrErrPhone');

    // Populate current page source URL
    if (sourceUrlInput) {
      sourceUrlInput.value = window.location.href;
    }

    // Open Modal Function: Renders modal, confirms actual visibility
    function openPopup() {
      if (isOpen) return;
      if (isPopupDismissed()) return;

      var targetModal = modal || document.getElementById('bdrLeadPopupModal');
      if (!targetModal) {
        // Modal DOM element missing: render failed, DO NOT mark visitor as dismissed
        return;
      }

      // Step 1: Ensure form & header visible, success hidden
      if (headerElem) headerElem.style.display = 'block';
      if (form) form.style.display = 'flex';
      if (successView) successView.style.display = 'none';

      // Step 2: Render popup by toggling active classes and attributes
      targetModal.classList.add('is-active');
      targetModal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('bdr-modal-open');
      isOpen = true;

      // Step 3: Confirm popup is ACTUALLY visible before focusing
      function confirmVisibility() {
        if (isModalActuallyVisible(targetModal)) {
          // Successfully rendered and visible on screen
          if (nameInput) {
            nameInput.focus();
          }
        } else {
          // Failed render: revert state and NEVER suppress the visitor
          isOpen = false;
          targetModal.classList.remove('is-active');
          targetModal.setAttribute('aria-hidden', 'true');
          document.body.classList.remove('bdr-modal-open');
        }
      }

      // Verify visibility after browser paint cycle
      if (typeof window.requestAnimationFrame === 'function') {
        window.requestAnimationFrame(function () {
          setTimeout(confirmVisibility, 50);
        });
      } else {
        setTimeout(confirmVisibility, 50);
      }
    }

    // Close Modal Function (Permanently dismisses popup across the website)
    function closePopup() {
      if (!isOpen && !modal.classList.contains('is-active')) return;
      isOpen = false;

      // Persist dismissal only after close, backdrop, or Escape
      setPopupDismissed('dismissed');

      modal.classList.remove('is-active');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('bdr-modal-open');

      // Clean up in-flight timer if any
      if (timerId) {
        clearTimeout(timerId);
        timerId = null;
      }
    }

    window.bdrShowLeadPopup = openPopup;
    window.bdrCloseLeadPopup = closePopup;

    // Close button click
    if (closeBtn) {
      closeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        closePopup();
      });
    }

    // Backdrop click
    if (backdrop) {
      backdrop.addEventListener('click', function (e) {
        e.preventDefault();
        closePopup();
      });
    }

    // Done button in success state
    if (doneBtn) {
      doneBtn.addEventListener('click', function (e) {
        e.preventDefault();
        closePopup();
      });
    }

    // Escape key press to close
    document.addEventListener('keydown', function (e) {
      if ((e.key === 'Escape' || e.keyCode === 27) && isOpen) {
        closePopup();
      }
    });

    // Clear field errors on input
    function clearError(input, errElem) {
      if (input && input.parentElement) {
        input.parentElement.classList.remove('is-invalid');
      }
      if (errElem) {
        errElem.textContent = '';
        errElem.classList.remove('is-visible');
      }
      if (alertBox) {
        alertBox.style.display = 'none';
        alertBox.className = 'bdr-popup-alert';
        alertBox.textContent = '';
      }
    }

    if (nameInput) {
      nameInput.addEventListener('input', function () {
        clearError(nameInput, errName);
      });
    }
    if (emailInput) {
      emailInput.addEventListener('input', function () {
        clearError(emailInput, errEmail);
      });
    }
    if (phoneInput) {
      phoneInput.addEventListener('input', function () {
        clearError(phoneInput, errPhone);
      });
    }

    // Indian Phone Number Pattern: 10 digits starting with 6-9, optional +91 or 0 prefix
    var indianPhoneRegex = /^(?:\+91[\-\s]?|0)?[6-9]\d{9}$/;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Form submission validation & AJAX
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Client-side validation
        var valid = true;
        var nameVal = (nameInput ? nameInput.value : '').trim();
        var emailVal = (emailInput ? emailInput.value : '').trim();
        var phoneVal = (phoneInput ? phoneInput.value : '').trim();

        // Validate Name
        if (nameVal.length < 2) {
          valid = false;
          if (errName) {
            errName.textContent = 'Please enter your full name (at least 2 characters).';
            errName.classList.add('is-visible');
          }
          if (nameInput && nameInput.parentElement) {
            nameInput.parentElement.classList.add('is-invalid');
          }
        }

        // Validate Email
        if (!emailVal || !emailRegex.test(emailVal)) {
          valid = false;
          if (errEmail) {
            errEmail.textContent = 'Please enter a valid email address.';
            errEmail.classList.add('is-visible');
          }
          if (emailInput && emailInput.parentElement) {
            emailInput.parentElement.classList.add('is-invalid');
          }
        }

        // Validate Indian Phone Number
        var cleanPhone = phoneVal.replace(/[\s\-]/g, '');
        if (!phoneVal || !indianPhoneRegex.test(cleanPhone)) {
          valid = false;
          if (errPhone) {
            errPhone.textContent = 'Please enter a valid 10-digit Indian mobile number (e.g. 98765 43210).';
            errPhone.classList.add('is-visible');
          }
          if (phoneInput && phoneInput.parentElement) {
            phoneInput.parentElement.classList.add('is-invalid');
          }
        }

        if (!valid) {
          return;
        }

        // UI State: Submitting
        if (submitBtn) {
          submitBtn.disabled = true;
          var spinner = submitBtn.querySelector('.bdr-btn-spinner');
          var btnText = submitBtn.querySelector('.bdr-btn-text');
          var arrow = submitBtn.querySelector('.bdr-btn-arrow');
          if (spinner) spinner.style.display = 'inline-block';
          if (btnText) btnText.textContent = 'Connecting...';
          if (arrow) arrow.style.display = 'none';
        }

        // Prepare Form Data
        var formData = new FormData(form);

        // Determine API endpoint safely (ensuring same-origin even if .env host differs)
        var endpoint = 'api/lead-popup-submit.php';
        var actionAttr = form.getAttribute('action');
        if (actionAttr) {
          if (actionAttr.startsWith('http://') || actionAttr.startsWith('https://')) {
            try {
              var parsedUrl = new URL(actionAttr);
              if (parsedUrl.host !== window.location.host) {
                endpoint = parsedUrl.pathname;
              } else {
                endpoint = actionAttr;
              }
            } catch (e) {
              endpoint = actionAttr;
            }
          } else {
            endpoint = actionAttr;
          }
        }
        if (!endpoint.startsWith('/') && !endpoint.startsWith('http')) {
          var basePath = window.location.pathname.indexOf('/businessdoctor') !== -1 ? '/businessdoctor/' : '/';
          endpoint = basePath + endpoint;
        }

        fetch(endpoint, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
          .then(function (response) {
            return response.json().then(function (data) {
              return { status: response.status, ok: response.ok, body: data };
            });
          })
          .then(function (res) {
            if (res.ok && res.body.success) {
              // Permanently persist successful submission
              setPopupCompleted('submitted');

              // Hide header & form, show success view
              if (headerElem) headerElem.style.display = 'none';
              if (form) form.style.display = 'none';
              if (successView) {
                successView.style.display = 'block';
              }

              // Automatically close modal after 3.5 seconds
              setTimeout(function () {
                closePopup();
              }, 3500);
            } else {
              // Reset submit button
              resetSubmitBtn();

              // Display error
              var errMessage = (res.body && res.body.message) || 'Submission failed. Please check your details.';
              if (alertBox) {
                alertBox.className = 'bdr-popup-alert is-error';
                alertBox.textContent = errMessage;
                alertBox.style.display = 'block';
              }

              // Highlight specific fields if returned
              if (res.body && res.body.errors) {
                if (res.body.errors.full_name && errName) {
                  errName.textContent = res.body.errors.full_name;
                  errName.classList.add('is-visible');
                  if (nameInput) nameInput.parentElement.classList.add('is-invalid');
                }
                if (res.body.errors.email && errEmail) {
                  errEmail.textContent = res.body.errors.email;
                  errEmail.classList.add('is-visible');
                  if (emailInput) emailInput.parentElement.classList.add('is-invalid');
                }
                if (res.body.errors.phone && errPhone) {
                  errPhone.textContent = res.body.errors.phone;
                  errPhone.classList.add('is-visible');
                  if (phoneInput) phoneInput.parentElement.classList.add('is-invalid');
                }
              }
            }
          })
          .catch(function (error) {
            console.error('[BusinessDoctor Lead Popup] Submit error:', error);
            resetSubmitBtn();
            if (alertBox) {
              alertBox.className = 'bdr-popup-alert is-error';
              alertBox.textContent = 'Connection error. Please try again or call our direct line.';
              alertBox.style.display = 'block';
            }
          });

        function resetSubmitBtn() {
          if (!submitBtn) return;
          submitBtn.disabled = false;
          var spinner = submitBtn.querySelector('.bdr-btn-spinner');
          var btnText = submitBtn.querySelector('.bdr-btn-text');
          var arrow = submitBtn.querySelector('.bdr-btn-arrow');
          if (spinner) spinner.style.display = 'none';
          if (btnText) btnText.textContent = 'Request a Free Consultation';
          if (arrow) arrow.style.display = 'inline-block';
        }
      });
    }

    // Schedule 5-second timer
    function startTimer() {
      if (timerId || isPopupDismissed()) return;
      timerId = setTimeout(openPopup, POPUP_DELAY_MS);
    }

    // Clear timer if user navigates away before 5 seconds
    window.addEventListener('beforeunload', function () {
      if (timerId) {
        clearTimeout(timerId);
        timerId = null;
      }
    });

    // Start timer upon DOM readiness or load
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
      startTimer();
    } else {
      document.addEventListener('DOMContentLoaded', startTimer);
      window.addEventListener('load', startTimer);
    }
  }

  // Self-initialize immediately
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLeadPopup);
  } else {
    initLeadPopup();
  }
})();
