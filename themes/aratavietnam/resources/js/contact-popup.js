/**
 * Contact Popup Handler
 *
 * @package ArataVietnam
 */

(function () {
  'use strict';

  // Check if required data is available
  if (typeof arataContactPopup === 'undefined') {
    return;
  }

  // Popup HTML template
  function getPopupHTML(settings) {
    return `
            <div id="arata-contact-popup" class="arata-popup-overlay" style="display: none;">
                <div class="arata-popup-container arata-popup-${settings.width}">
                    <div class="arata-popup-header">
                        <h2 class="arata-popup-title">${settings.title}</h2>
                        <button type="button" class="arata-popup-close" aria-label="Close popup">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="arata-popup-body">
                        <p class="arata-popup-description">${settings.description}</p>

                        <form id="arata-popup-form" class="arata-popup-form">
                            <input type="hidden" name="action" value="arata_popup_contact_submit" />
                            <input type="hidden" name="nonce" value="${arataContactPopup.nonce}" />
                            <input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" />

                            <div class="arata-form-grid">
                                <div class="arata-form-group">
                                    <label for="popup-name" class="arata-form-label">Họ và tên *</label>
                                    <div class="arata-input-wrapper">
                                        <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <input id="popup-name" name="name" type="text" required placeholder="Nhập họ và tên của bạn" class="arata-form-input" />
                                    </div>
                                    <div class="arata-error-message" id="popup-name-error"></div>
                                </div>

                                <div class="arata-form-group">
                                    <label for="popup-email" class="arata-form-label">Email *</label>
                                    <div class="arata-input-wrapper">
                                        <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <input id="popup-email" name="email" type="email" required placeholder="example@email.com" class="arata-form-input" />
                                    </div>
                                    <div class="arata-error-message" id="popup-email-error"></div>
                                </div>

                                <div class="arata-form-group">
                                    <label for="popup-phone" class="arata-form-label">Số điện thoại</label>
                                    <div class="arata-input-wrapper">
                                        <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <input id="popup-phone" name="phone" type="tel" placeholder="0123 456 789" class="arata-form-input" />
                                    </div>
                                    <div class="arata-error-message" id="popup-phone-error"></div>
                                </div>

                                <div class="arata-form-group">
                                    <label for="popup-subject" class="arata-form-label">Chủ đề</label>
                                    <div class="arata-input-wrapper">
                                        <svg class="arata-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <input id="popup-subject" name="subject" type="text" placeholder="Chủ đề liên hệ" class="arata-form-input" />
                                    </div>
                                </div>
                            </div>

                            <div class="arata-form-group">
                                <label for="popup-message" class="arata-form-label">Nội dung *</label>
                                <textarea id="popup-message" name="message" rows="4" required placeholder="Nhập nội dung tin nhắn của bạn..." class="arata-form-textarea"></textarea>
                                <div class="arata-error-message" id="popup-message-error"></div>
                            </div>

                            <div class="arata-form-actions">
                                <button type="submit" class="arata-submit-btn">
                                    <span class="arata-submit-text">Gửi liên hệ</span>
                                    <svg class="arata-loading-spinner" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
  }

  // Initialize popup
  function initContactPopup() {
    const settings = arataContactPopup.settings;

    // Add popup HTML to body
    document.body.insertAdjacentHTML('beforeend', getPopupHTML(settings));

    // Bind events
    bindPopupEvents();
  }

  // Bind popup events
  function bindPopupEvents() {
    const popup = document.getElementById('arata-contact-popup');
    const closeBtn = popup.querySelector('.arata-popup-close');
    const form = document.getElementById('arata-popup-form');

    // Open popup when clicking contact menu items
    document.addEventListener('click', function (e) {
      const target = e.target.closest('a');
      if (!target) return;

      const href = target.getAttribute('href') || '';
      const isContactLink = href.includes('contact') || href.includes('lien-he') || target.getAttribute('data-contact-popup') === 'true';

      if (isContactLink && arataContactPopup.settings.enabled) {
        e.preventDefault();
        e.stopPropagation();
        openPopup();
      }
    });

    // Close popup
    closeBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', function (e) {
      if (e.target === this) {
        closePopup();
      }
    });

    // Close on escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && popup.style.display !== 'none') {
        closePopup();
      }
    });

    // Form submission
    form.addEventListener('submit', handleFormSubmission);

    // Real-time validation
    form.querySelectorAll('input, textarea').forEach(function (field) {
      field.addEventListener('blur', function () {
        validateField(field);
      });
    });
  }

  // Open popup
  function openPopup() {
    const popup = document.getElementById('arata-contact-popup');
    popup.style.display = 'flex';
    document.body.classList.add('arata-popup-open');
    popup.querySelector('input:first-of-type').focus();
  }

  // Close popup
  function closePopup() {
    const popup = document.getElementById('arata-contact-popup');
    popup.style.display = 'none';
    document.body.classList.remove('arata-popup-open');
    resetForm();
  }

  // Reset form
  function resetForm() {
    const form = document.getElementById('arata-popup-form');
    form.reset();
    form.querySelectorAll('.arata-error-message').forEach(function (error) {
      error.textContent = '';
      error.style.display = 'none';
    });
    form.querySelectorAll('.arata-form-input, .arata-form-textarea').forEach(function (field) {
      field.classList.remove('arata-input-error');
    });
    const submitBtn = form.querySelector('.arata-submit-btn');
    submitBtn.disabled = false;
    submitBtn.querySelector('.arata-submit-text').textContent = 'Gửi liên hệ';
    submitBtn.querySelector('.arata-loading-spinner').style.display = 'none';
  }

  // Validation functions
  function validateName(name) {
    return name.trim().length >= 2;
  }

  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function validatePhone(phone) {
    if (!phone.trim()) return true; // Optional field
    const phoneRegex = /^[0-9\s\-\+\(\)]{10,15}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
  }

  function validateMessage(message) {
    return message.trim().length >= 10;
  }

  // Validate individual field
  function validateField(field) {
    const fieldName = field.getAttribute('name');
    const value = field.value;
    let isValid = true;
    let errorMessage = '';

    // Remove previous error styling
    field.classList.remove('arata-input-error');
    const errorElement = field.parentNode.querySelector('.arata-error-message');
    if (errorElement) {
      errorElement.textContent = '';
      errorElement.style.display = 'none';
    }

    // Validate based on field type
    switch (fieldName) {
      case 'name':
        if (!validateName(value)) {
          isValid = false;
          errorMessage = 'Tên phải có ít nhất 2 ký tự';
        }
        break;
      case 'email':
        if (!validateEmail(value)) {
          isValid = false;
          errorMessage = 'Email không hợp lệ';
        }
        break;
      case 'phone':
        if (!validatePhone(value)) {
          isValid = false;
          errorMessage = 'Số điện thoại không hợp lệ';
        }
        break;
      case 'message':
        if (!validateMessage(value)) {
          isValid = false;
          errorMessage = 'Nội dung phải có ít nhất 10 ký tự';
        }
        break;
    }

    // Show error if validation failed
    if (!isValid && errorElement) {
      field.classList.add('arata-input-error');
      errorElement.textContent = errorMessage;
      errorElement.style.display = 'block';
    }

    return isValid;
  }

  // Handle form submission
  function handleFormSubmission(e) {
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('.arata-submit-btn');
    const submitText = submitBtn.querySelector('.arata-submit-text');
    const loadingSpinner = submitBtn.querySelector('.arata-loading-spinner');

    // Validate all fields first
    let isValid = true;
    const requiredFields = ['name', 'email', 'message'];
    const optionalFields = ['phone'];

    // Validate required fields
    requiredFields.forEach(function(fieldName) {
      const field = form.querySelector(`[name="${fieldName}"]`);
      if (field && !validateField(field)) {
        isValid = false;
      }
    });

    // Validate optional fields if they have values
    optionalFields.forEach(function(fieldName) {
      const field = form.querySelector(`[name="${fieldName}"]`);
      if (field && field.value.trim() && !validateField(field)) {
        isValid = false;
      }
    });

    if (!isValid) {
      // Scroll to first error
      const firstError = form.querySelector('.arata-input-error');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
      }
      return;
    }

    // Show confirmation dialog before submission
    showConfirmationDialog(form, function() {
      // User confirmed, proceed with submission
      submitForm(form, submitBtn, submitText, loadingSpinner);
    });
  }

  // Show confirmation dialog
  function showConfirmationDialog(form, onConfirm) {
    const name = form.querySelector('[name="name"]').value;
    const email = form.querySelector('[name="email"]').value;
    const phone = form.querySelector('[name="phone"]').value;
    const subject = form.querySelector('[name="subject"]').value;
    const message = form.querySelector('[name="message"]').value;

    const confirmationHTML = `
      <div id="arata-confirmation-dialog" class="arata-confirmation-overlay">
        <div class="arata-confirmation-container">
          <div class="arata-confirmation-header">
            <h3 class="arata-confirmation-title">Xác nhận thông tin liên hệ</h3>
          </div>

          <div class="arata-confirmation-body">
            <p class="arata-confirmation-description">Vui lòng kiểm tra lại thông tin trước khi gửi:</p>

            <div class="arata-confirmation-details">
              <div class="arata-detail-item">
                <span class="arata-detail-label">Họ và tên:</span>
                <span class="arata-detail-value">${escapeHtml(name)}</span>
              </div>
              <div class="arata-detail-item">
                <span class="arata-detail-label">Email:</span>
                <span class="arata-detail-value">${escapeHtml(email)}</span>
              </div>
              ${phone ? `
                <div class="arata-detail-item">
                  <span class="arata-detail-label">Số điện thoại:</span>
                  <span class="arata-detail-value">${escapeHtml(phone)}</span>
                </div>
              ` : ''}
              ${subject ? `
                <div class="arata-detail-item">
                  <span class="arata-detail-label">Chủ đề:</span>
                  <span class="arata-detail-value">${escapeHtml(subject)}</span>
                </div>
              ` : ''}
              <div class="arata-detail-item">
                <span class="arata-detail-label">Nội dung:</span>
                <span class="arata-detail-value arata-message-preview">${escapeHtml(message.substring(0, 100))}${message.length > 100 ? '...' : ''}</span>
              </div>
            </div>
          </div>

          <div class="arata-confirmation-actions">
            <button type="button" class="arata-btn-cancel">Hủy</button>
            <button type="button" class="arata-btn-confirm">Xác nhận gửi</button>
          </div>
        </div>
      </div>
    `;

    document.body.insertAdjacentHTML('beforeend', confirmationHTML);

    const dialog = document.getElementById('arata-confirmation-dialog');
    const cancelBtn = dialog.querySelector('.arata-btn-cancel');
    const confirmBtn = dialog.querySelector('.arata-btn-confirm');

    // Show dialog
    dialog.style.display = 'flex';
    confirmBtn.focus();

    // Handle cancel
    cancelBtn.addEventListener('click', function() {
      closeConfirmationDialog();
    });

    // Handle confirm
    confirmBtn.addEventListener('click', function() {
      closeConfirmationDialog();
      onConfirm();
    });

    // Close on overlay click
    dialog.addEventListener('click', function(e) {
      if (e.target === this) {
        closeConfirmationDialog();
      }
    });

    // Close on escape key
    const escapeHandler = function(e) {
      if (e.key === 'Escape') {
        closeConfirmationDialog();
        document.removeEventListener('keydown', escapeHandler);
      }
    };
    document.addEventListener('keydown', escapeHandler);
  }

  // Close confirmation dialog
  function closeConfirmationDialog() {
    const dialog = document.getElementById('arata-confirmation-dialog');
    if (dialog) {
      dialog.remove();
    }
  }

  // Submit form after confirmation
  function submitForm(form, submitBtn, submitText, loadingSpinner) {
    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = 'Đang gửi...';
    loadingSpinner.style.display = 'inline-block';

    // Prepare form data
    const formData = new FormData(form);

    // Submit form via AJAX
    fetch(arataContactPopup.ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showSuccessMessage(data.data.message);
          resetForm();
          setTimeout(closePopup, 3000);
        } else {
          showErrorMessage(data.data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
      })
      .catch(error => {
        showErrorMessage('Có lỗi xảy ra. Vui lòng thử lại.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitText.textContent = 'Gửi liên hệ';
        loadingSpinner.style.display = 'none';
      });
  }

  // Escape HTML to prevent XSS
  function escapeHtml(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
  }

  // Show success message
  function showSuccessMessage(message) {
    const popup = document.getElementById('arata-contact-popup');
    const body = popup.querySelector('.arata-popup-body');

    body.innerHTML = `
            <div class="arata-success-message">
                <svg class="arata-success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p>${message}</p>
            </div>
        `;
  }

  // Show error message
  function showErrorMessage(message) {
    const popup = document.getElementById('arata-contact-popup');
    const body = popup.querySelector('.arata-popup-body');

    const errorAlert = document.createElement('div');
    errorAlert.className = 'arata-error-alert';
    errorAlert.innerHTML = `
        <svg class="arata-error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p>${message}</p>
    `;

    body.insertBefore(errorAlert, body.firstChild);
  }

  // Initialize when document is ready
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof arataContactPopup !== 'undefined' && arataContactPopup.settings.enabled) {
      initContactPopup();
    }
  });

})();
