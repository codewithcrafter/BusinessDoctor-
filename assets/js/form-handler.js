/**
 * BusinessDoctor Form Handler - IT & Digital Services
 * Asynchronous AJAX submission with validation, loading states and inline feedback
 */

document.addEventListener('DOMContentLoaded', () => {
  function handleFormSubmit(form, endpoint, successCallback) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn ? submitBtn.innerHTML : 'Submit';
      const feedbackContainer = form.querySelector('.form-feedback') || createFeedbackContainer(form);

      feedbackContainer.innerHTML = '';
      feedbackContainer.className = 'form-feedback';

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
          <svg style="animation: spin 1s linear infinite; width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
            <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor"/>
          </svg>
          Processing...
        `;
      }

      const formData = new FormData(form);

      try {
        const response = await fetch(endpoint, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const result = await response.json();

        if (result.success) {
          feedbackContainer.className = 'form-alert success';
          feedbackContainer.innerHTML = `<strong>Success:</strong> ${result.message || 'Submission received.'}`;
          form.reset();
          if (typeof successCallback === 'function') {
            successCallback(result);
          }
        } else {
          feedbackContainer.className = 'form-alert error';
          feedbackContainer.innerHTML = `<strong>Notice:</strong> ${result.message || 'Please check your information.'}`;
        }
      } catch (err) {
        feedbackContainer.className = 'form-alert error';
        feedbackContainer.innerHTML = '<strong>Connection Error:</strong> Could not transmit request. Please try again or email us directly.';
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnText;
        }
      }
    });
  }

  function createFeedbackContainer(form) {
    const div = document.createElement('div');
    div.className = 'form-feedback';
    form.prepend(div);
    return div;
  }

  // 1. Quick CTA Banner Intake Form
  const quickCtaForm = document.querySelector('#quick-cta-form');
  if (quickCtaForm) {
    handleFormSubmit(quickCtaForm, 'api/submit-diagnostic.php', (res) => {
      if (res.reference_no) {
        setTimeout(() => {
          window.location.href = `audit.php?ref=${encodeURIComponent(res.reference_no)}&done=1`;
        }, 1200);
      }
    });
  }

  // 2. Comprehensive Digital Audit Form
  const comprehensiveDiagForm = document.querySelector('#comprehensive-diagnostic-form');
  if (comprehensiveDiagForm) {
    handleFormSubmit(comprehensiveDiagForm, 'api/submit-diagnostic.php', (res) => {
      const resultCard = document.querySelector('#diagnostic-result-card');
      if (resultCard && res.health_score) {
        resultCard.style.display = 'block';
        resultCard.scrollIntoView({ behavior: 'smooth' });
        const scoreEl = resultCard.querySelector('.result-score-val');
        if (scoreEl) scoreEl.textContent = res.health_score;
        const refEl = resultCard.querySelector('.result-ref-val');
        if (refEl) refEl.textContent = res.reference_no;

        // Populate real telemetry measurements
        if (res.real_telemetry) {
          const domEl = resultCard.querySelector('.telemetry-domain');
          const httpEl = resultCard.querySelector('.telemetry-http');
          const latEl = resultCard.querySelector('.telemetry-latency');
          const dnsEl = resultCard.querySelector('.telemetry-dns');
          const sslEl = resultCard.querySelector('.telemetry-ssl');

          const host = res.real_telemetry.host || res.real_telemetry.domain || '';
          const code = res.real_telemetry.http_code !== undefined ? res.real_telemetry.http_code : res.real_telemetry.http_status;
          const resolved = res.real_telemetry.dns_resolved !== undefined ? res.real_telemetry.dns_resolved : res.real_telemetry.dns_resolves;
          const ssl = res.real_telemetry.ssl_active !== undefined ? res.real_telemetry.ssl_active : res.real_telemetry.ssl_enabled;
          const latency = res.real_telemetry.response_time_ms !== null && res.real_telemetry.response_time_ms !== undefined ? res.real_telemetry.response_time_ms : null;

          if (domEl) domEl.textContent = host;
          if (httpEl) {
            httpEl.textContent = code ? `${code} (Live)` : 'Unreachable';
            httpEl.style.color = (code >= 200 && code < 400) ? '#10b981' : '#f59e0b';
          }
          if (latEl) {
            latEl.textContent = latency !== null ? `${latency} ms` : 'N/A';
          }
          if (dnsEl) {
            dnsEl.textContent = resolved ? (res.real_telemetry.ip || 'Resolved') : 'Unresolved';
            dnsEl.style.color = resolved ? '#10b981' : '#ef4444';
          }
          if (sslEl) {
            sslEl.textContent = ssl ? 'Active (HTTPS)' : 'Inactive / HTTP';
            sslEl.style.color = ssl ? '#10b981' : '#f59e0b';
          }
          const msgEl = resultCard.querySelector('.telemetry-status-msg');
          if (msgEl) {
            msgEl.textContent = res.real_telemetry.status_message || '';
          }
        }
      }
    });
  }

  // 3. Contact Inquiries Form
  const contactForm = document.querySelector('#contact-form');
  if (contactForm) {
    handleFormSubmit(contactForm, 'api/submit-contact.php');
  }

  // 4. Newsletter Subscription Form
  const newsletterForms = document.querySelectorAll('.newsletter-form');
  newsletterForms.forEach(form => {
    handleFormSubmit(form, 'api/newsletter-subscribe.php');
  });
});
