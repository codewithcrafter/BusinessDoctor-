<?php
/**
 * BusinessDoctor Global Lead Generation Popup Component
 * Appears 5s after initial page load, once per session.
 */

declare(strict_types=1);

// Strict Display Rule: Popup must appear ONLY on the public homepage
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '/';

// 1. Exclude admin portal
if (preg_match('#/admin(/|\.php|$)#i', $scriptName) || preg_match('#/admin(/|\.php|$)#i', $requestUri)) {
    return;
}

// 2. Exclude all internal pages (About, Services, Contact, Blog/Insights, Case Studies, Audit, API, etc.)
if (preg_match('#^/(services|about|contact|insights?|case-stud|audit|api)(/|\.php|$)#i', $requestUri)
    || str_contains($requestUri, 'service-detail')
    || str_contains($requestUri, 'case-study-detail')
    || str_contains($requestUri, 'insight-detail')) {
    return;
}

// 3. Must match public homepage root or index.php only
$cleanPath = rtrim($requestUri, '/');
$isHome = ($cleanPath === '' || $cleanPath === '/index.php' || $cleanPath === '/businessdoctor' || $cleanPath === '/businessdoctor/index.php');

if (!$isHome) {
    return;
}
?>
<!-- Lead Generation Modal Popup -->
<div id="bdrLeadPopupModal" class="bdr-popup-overlay" role="dialog" aria-modal="true" aria-labelledby="bdrPopupTitle" aria-hidden="true">
  <div class="bdr-popup-backdrop" id="bdrPopupBackdrop"></div>
  
  <div class="bdr-popup-wrapper">
    <div class="bdr-popup-card">
      <!-- Glow Accent Line -->
      <div class="bdr-popup-glow-top"></div>

      <!-- Close Button -->
      <button type="button" class="bdr-popup-close" id="bdrPopupCloseBtn" aria-label="Close consultation popup">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>

      <!-- Header Section -->
      <div class="bdr-popup-header">
        <div class="bdr-popup-badge">
          <span class="bdr-badge-dot"></span>
          <span>FREE STRATEGY SESSION</span>
        </div>
        <h2 class="bdr-popup-title" id="bdrPopupTitle">Let's Grow Your Business Together</h2>
        <p class="bdr-popup-desc">Tell us a little about your requirements. Our team will connect with you to discuss the right digital solution for your business.</p>
      </div>

      <!-- Form Section -->
      <?php
      $popupActionUrl = appUrl('api/lead-popup-submit.php');
      if (!empty($_SERVER['HTTP_HOST']) && !str_contains($popupActionUrl, $_SERVER['HTTP_HOST'])) {
          $popupActionUrl = '/api/lead-popup-submit.php';
      }
      ?>
      <form id="bdrLeadPopupForm" class="bdr-popup-form" action="<?= e($popupActionUrl) ?>" method="POST" novalidate>
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
        <!-- Dynamic Source URL -->
        <input type="hidden" name="source_url" id="bdrPopupSourceUrl" value="">

        <!-- Anti-Spam Bot Honeypot -->
        <div class="bdr-popup-hp" aria-hidden="true" style="display:none!important;visibility:hidden;position:absolute;left:-9999px;">
          <input type="text" name="bdr_website_hp" tabindex="-1" autocomplete="off">
          <input type="text" name="bdr_company_hp" tabindex="-1" autocomplete="off">
        </div>

        <!-- Alert Notification Box -->
        <div id="bdrPopupAlert" class="bdr-popup-alert" role="alert" style="display: none;"></div>

        <!-- Full Name Field -->
        <div class="bdr-form-group">
          <label for="bdrPopupName" class="bdr-form-label">Full Name <span class="bdr-req">*</span></label>
          <div class="bdr-input-wrapper">
            <svg class="bdr-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <input type="text" id="bdrPopupName" name="full_name" class="bdr-form-input" placeholder="e.g. Rahul Sharma" required autocomplete="name">
          </div>
          <span class="bdr-field-error" id="bdrErrName"></span>
        </div>

        <!-- Email Address Field -->
        <div class="bdr-form-group">
          <label for="bdrPopupEmail" class="bdr-form-label">Email Address <span class="bdr-req">*</span></label>
          <div class="bdr-input-wrapper">
            <svg class="bdr-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="4" width="20" height="16" rx="2"></rect>
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
            </svg>
            <input type="email" id="bdrPopupEmail" name="email" class="bdr-form-input" placeholder="e.g. rahul@company.com" required autocomplete="email">
          </div>
          <span class="bdr-field-error" id="bdrErrEmail"></span>
        </div>

        <!-- Contact Number Field -->
        <div class="bdr-form-group">
          <label for="bdrPopupPhone" class="bdr-form-label">Contact Number <span class="bdr-req">*</span> <span class="bdr-label-hint">(10-digit Indian Mobile)</span></label>
          <div class="bdr-input-wrapper">
            <span class="bdr-phone-prefix">+91</span>
            <input type="tel" id="bdrPopupPhone" name="phone" class="bdr-form-input bdr-input-phone" placeholder="98765 43210" required autocomplete="tel" maxlength="15">
          </div>
          <span class="bdr-field-error" id="bdrErrPhone"></span>
        </div>

        <!-- CTA Submit Button -->
        <div class="bdr-form-action">
          <button type="submit" id="bdrPopupSubmitBtn" class="bdr-popup-submit-btn">
            <span class="bdr-btn-spinner" style="display:none;" aria-hidden="true"></span>
            <span class="bdr-btn-text">Request a Free Consultation</span>
            <svg class="bdr-btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </button>
        </div>

        <!-- Privacy & Trust Statement -->
        <p class="bdr-popup-privacy">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
          </svg>
          <span>Your information is safe with us. We will only use it to contact you regarding your enquiry.</span>
        </p>
      </form>

      <!-- Submission Success State -->
      <div id="bdrPopupSuccess" class="bdr-popup-success" style="display: none;">
        <div class="bdr-success-glow"></div>
        <div class="bdr-success-icon-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="#06B5F9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
        </div>
        <h3 class="bdr-success-title">Consultation Request Received!</h3>
        <p class="bdr-success-desc">Thank you for reaching out. Our business solutions team has received your enquiry and will connect with you within 2 business hours.</p>
        <button type="button" class="bdr-popup-done-btn" id="bdrPopupDoneBtn">Done</button>
      </div>
    </div>
  </div>
</div>

