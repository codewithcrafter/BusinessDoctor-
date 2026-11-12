/**
 * BusinessDoctor - Global Lead Generation Popup Controller
 * Appears 5 seconds after page load on EVERY public page.
 * Appears ONLY ONCE per page view (never repeats every 5s while on same page).
 * If user refreshes the page or navigates to another page, popup appears again after 5 seconds.
 */

(function () {
  'use strict';

  // 1. Strict Admin Route Guard: Never run on admin / CMS / login pages
  var currentPath = window.location.pathname || '';
  if (/\/admin(\/|$|\.php)/i.test(currentPath)) {
    return;
  }

  // 2. Prevent duplicate script initializations on same page
  if (window.__bdrLeadPopupInitialized) {
    return;
  }
  window.__bdrLeadPopupInitialized = true;

  // Clear legacy permanent lockout flags so page refresh or revisit triggers 5s popup cleanly
  try {
    localStorage.removeItem('bdr_lead_popup_completed');
    localStorage.removeItem('bdr_lead_popup_dismissed');
    sessionStorage.removeItem('bdr_lead_popup_completed');
    sessionStorage.removeItem('bdr_lead_popup_dismissed');
    document.cookie = 'bdr_lead_popup_completed=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax';
    document.cookie = 'bdr_lead_popup_dismissed=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;SameSite=Lax';
  } catch (e) {}

  var POPUP_DELAY_MS = 5000; // Exactly 5 seconds after page ready
  var hasAppearedOnThisPage = false; // Appears ONLY ONE TIME per page view, never loops
  var isPageDismissed = false; // Dismissed ONLY for the current page view
  var isOpen = false;
  var timerId = null;

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
  window.bdrIsPageDismissed = function () {
    return isPageDismissed;
  };
  window.bdrHasAppeared = function () {
    return hasAppearedOnThisPage;
  };
  window.bdrIsModalActuallyVisible = function () {
    return isModalActuallyVisible(document.getElementById('bdrLeadPopupModal'));
  };

  function initLeadPopup() {
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

    // Open Modal Function: Renders modal once per page view
    function openPopup() {
      // Remember: only ONE TIME pop up appears, not every 5 seconds
      if (isOpen || hasAppearedOnThisPage || isPageDismissed) return;
      hasAppearedOnThisPage = true;
      isOpen = true;

      // Clear any pending timer so it never repeats on this page
      if (timerId) {
        clearTimeout(timerId);
        timerId = null;
      }

      var targetModal = modal || document.getElementById('bdrLeadPopupModal');
      if (!targetModal) return;

      // Step 1: Ensure form & header visible, success hidden
      if (headerElem) headerElem.style.display = 'block';
      if (form) form.style.display = 'flex';
      if (successView) successView.style.display = 'none';

      // Step 2: Render popup by toggling active classes and attributes
      targetModal.classList.add('is-active');
      targetModal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('bdr-modal-open');

      // Step 3: Confirm popup is visible before focusing
      function confirmVisibility() {
        if (isModalActuallyVisible(targetModal)) {
          if (nameInput) {
            nameInput.focus();
          }
        } else {
          // Failed render: revert state
          isOpen = false;
          hasAppearedOnThisPage = false;
          targetModal.classList.remove('is-active');
          targetModal.setAttribute('aria-hidden', 'true');
          document.body.classList.remove('bdr-modal-open');
        }
      }

      if (typeof window.requestAnimationFrame === 'function') {
        window.requestAnimationFrame(function () {
          setTimeout(confirmVisibility, 50);
        });
      } else {
        setTimeout(confirmVisibility, 50);
      }
    }

    // Close Modal Function: Dismisses for the rest of this page view
    function closePopup() {
      if (!isOpen && !modal.classList.contains('is-active')) return;
      isOpen = false;
      isPageDismissed = true; // Dismissed on this page view (will reappear only if user refreshes)

      modal.classList.remove('is-active');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('bdr-modal-open');

      // Clear any timer so it never pops up again on this page
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
              isPageDismissed = true;

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

    // Schedule 5-second timer (fires ONLY ONCE per page load)
    function startTimer() {
      if (timerId || hasAppearedOnThisPage || isPageDismissed) return;
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

