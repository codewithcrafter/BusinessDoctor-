/**
 * BusinessDoctor - Global Lead Generation Popup Controller
 * Automatically appears 5 seconds after page load on EVERY public page.
 * Per-page dismissal only: navigating to another page re-enables the 5s popup.
 */

(function () {
  'use strict';

  // 1. Strict Admin Route Guard: Never run on admin / CMS / login pages
  var currentPath = window.location.pathname || '';
  if (/\/admin(\/|$|\.php)/i.test(currentPath)) {
    return;
  }

  // 2. Remove legacy cross-page session flags
  try {
    sessionStorage.removeItem('bdr_lead_popup_dismissed');
    localStorage.removeItem('bdr_lead_popup_dismissed');
  } catch (e) {}

  var POPUP_DELAY_MS = 5000; // Exactly 5 seconds after page ready
  var isPageDismissed = false; // Dismissed ONLY for the current page view
  var isOpen = false;
  var timerId = null;

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

    // Open Modal Function
    function openPopup() {
      if (isPageDismissed || isOpen) return;
      isOpen = true;

      // Ensure form & header visible, success hidden
      if (headerElem) headerElem.style.display = 'block';
      if (form) form.style.display = 'flex';
      if (successView) successView.style.display = 'none';

      modal.classList.add('is-active');
      modal.setAttribute('aria-hidden', 'false');
      document.body.classList.add('bdr-modal-open');

      // Autofocus first input field smoothly
      setTimeout(function () {
        if (nameInput) {
          nameInput.focus();
        }
      }, 350);
    }

    // Close Modal Function (Dismisses ONLY for the current page view)
    function closePopup() {
      if (!isOpen) return;
      isOpen = false;
      isPageDismissed = true;

      modal.classList.remove('is-active');
      modal.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('bdr-modal-open');
    }

    // Expose helpers on window for direct testing
    window.bdrShowLeadPopup = openPopup;
    window.bdrCloseLeadPopup = closePopup;
    window.bdrResetPagePopup = function () {
      isPageDismissed = false;
    };

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

        // Determine API endpoint
        var endpoint = form.getAttribute('action') || 'api/lead-popup-submit.php';
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

    // Schedule 5-second timer
    function startTimer() {
      if (timerId || isPageDismissed) return;
      timerId = setTimeout(openPopup, POPUP_DELAY_MS);
    }

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
