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
    // Define width classes for Tailwind
    const widthClasses = {
      sm: 'max-w-sm',
      md: 'max-w-2xl',
      lg: 'max-w-4xl',
      xl: 'max-w-6xl'
    };

    return `
      <div id="arata-contact-popup" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" style="display: none;">
        <div class="bg-white rounded-lg shadow-xl w-full ${widthClasses[settings.width] || 'max-w-2xl'} max-h-[90vh] flex flex-col transform transition-transform duration-300 scale-95">

          <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-lg lg:text-xl font-semibold text-gray-900">${settings.title}</h2>
            <button type="button" class="arata-popup-close text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close popup">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
          </div>

          <div class="p-4 lg:p-6 overflow-y-auto">
            <p class="text-sm text-gray-600 mb-4">${settings.description}</p>
            <form id="arata-popup-form" class="space-y-4">
              <input type="hidden" name="action" value="arata_popup_contact_submit" />
              <input type="hidden" name="nonce" value="${arataContactPopup.nonce}" />
              <input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" />

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label for="popup-name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                    <input id="popup-name" name="name" type="text" required placeholder="Nhập họ và tên của bạn" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  </div>
                  <div class="mt-1 text-xs text-red-600 hidden" id="popup-name-error"></div>
                </div>
                <div>
                  <label for="popup-email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></span>
                    <input id="popup-email" name="email" type="email" required placeholder="example@email.com" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  </div>
                  <div class="mt-1 text-xs text-red-600 hidden" id="popup-email-error"></div>
                </div>
                <div>
                  <label for="popup-phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></span>
                    <input id="popup-phone" name="phone" type="tel" placeholder="0123 456 789" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  </div>
                  <div class="mt-1 text-xs text-red-600 hidden" id="popup-phone-error"></div>
                </div>
                <div>
                  <label for="popup-subject" class="block text-sm font-medium text-gray-700 mb-1">Chủ đề</label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg></span>
                    <input id="popup-subject" name="subject" type="text" placeholder="Chủ đề liên hệ" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  </div>
                </div>
              </div>

              <div>
                <label for="popup-message" class="block text-sm font-medium text-gray-700 mb-1">Nội dung *</label>
                <textarea id="popup-message" name="message" rows="4" required placeholder="Nhập nội dung tin nhắn của bạn..." class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                <div class="mt-1 text-xs text-red-600 hidden" id="popup-message-error"></div>
              </div>

              <div class="pt-2">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2.5 text-white font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                  <span class="submit-text">Gửi liên hệ</span>
                  <svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white opacity-0 loading-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
    if (!popup) return;
    popup.style.display = 'flex';
    setTimeout(() => {
      popup.classList.remove('opacity-0');
      // Find the popup content div (second child of popup)
      const popupContent = popup.querySelector('div > div');
      if (popupContent) {
        popupContent.classList.remove('scale-95');
      }
    }, 10);
    document.body.classList.add('overflow-hidden');
    const firstInput = popup.querySelector('input[name="name"]');
    if (firstInput) {
      firstInput.focus();
    }
  }

  // Close popup function
  function closePopup() {
    const popup = document.getElementById('arata-contact-popup');
    if (popup) {
      popup.style.display = 'none';
      // Remove any existing confirmation dialogs
      const confirmDialog = document.getElementById('arata-confirmation-dialog');
      if (confirmDialog) {
        confirmDialog.remove();
      }
      // Reset form
      const form = popup.querySelector('#arata-popup-form');
      if (form) {
        form.reset();
      }
      // Restore body scroll
      document.body.classList.remove('overflow-hidden');
    }
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
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.disabled = false;
      const submitText = submitBtn.querySelector('.submit-text');
      const loadingSpinner = submitBtn.querySelector('.loading-spinner');
      if (submitText) submitText.textContent = 'Gửi liên hệ';
      if (loadingSpinner) loadingSpinner.classList.add('opacity-0');
    }
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

  // Show/Hide Error Functions
  function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + '-error');
    if (!field || !errorDiv) return;

    field.classList.add('border-red-500', 'focus:ring-red-500');
    field.classList.remove('border-gray-300', 'focus:ring-primary');
    errorDiv.textContent = message;
    errorDiv.classList.remove('hidden');
  }

  function hideError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + '-error');
    if (!field || !errorDiv) return;

    field.classList.remove('border-red-500', 'focus:ring-red-500');
    field.classList.add('border-gray-300', 'focus:ring-primary');
    errorDiv.classList.add('hidden');
  }

  // Validate individual field
  function validateField(field) {
    const fieldId = field.id;
    const value = field.value;
    let isValid = true;

    switch (field.name) {
      case 'name':
        if (!validateName(value)) {
          isValid = false;
          showError(fieldId, 'Họ tên phải có ít nhất 2 ký tự');
        } else {
          hideError(fieldId);
        }
        break;
      case 'email':
        if (!validateEmail(value)) {
          isValid = false;
          showError(fieldId, 'Vui lòng nhập email hợp lệ');
        } else {
          hideError(fieldId);
        }
        break;
      case 'phone':
        if (!validatePhone(value)) {
          isValid = false;
          showError(fieldId, 'Số điện thoại không hợp lệ');
        } else {
          hideError(fieldId);
        }
        break;
      case 'message':
        if (!validateMessage(value)) {
          isValid = false;
          showError(fieldId, 'Nội dung phải có ít nhất 10 ký tự');
        } else {
          hideError(fieldId);
        }
        break;
    }
    return isValid;
  }

  // Handle form submission
  function handleFormSubmission(e) {
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    if (!submitBtn || submitBtn.disabled) {
      return;
    }

    let isValid = true;
    const errors = [];

    form.querySelectorAll('[required]').forEach(field => {
      if (!validateField(field)) {
        isValid = false;
        errors.push(`${field.name}: ${field.value}`);
      }
    });

    if (!isValid) {
      const firstError = form.querySelector('.border-red-500');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
      }
      return;
    }

    showConfirmationDialog(form, () => {
      const submitText = form.querySelector('.submit-text');
      const loadingSpinner = form.querySelector('.loading-spinner');
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
      <div id="arata-confirmation-dialog" class="fixed inset-0 bg-black/60 z-[10000] flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
          <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Xác nhận thông tin liên hệ</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" onclick="this.closest('#arata-confirmation-dialog').remove()">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
          </div>

          <div class="p-4 overflow-y-auto">
            <p class="text-sm text-gray-600 mb-4">Vui lòng kiểm tra lại thông tin trước khi gửi:</p>

            <div class="space-y-3">
              <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="font-medium text-gray-700">Họ và tên:</span>
                <span class="text-gray-900">${escapeHtml(name)}</span>
              </div>
              <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="font-medium text-gray-700">Email:</span>
                <span class="text-gray-900">${escapeHtml(email)}</span>
              </div>
              ${phone ? `
                <div class="flex justify-between py-2 border-b border-gray-100">
                  <span class="font-medium text-gray-700">Số điện thoại:</span>
                  <span class="text-gray-900">${escapeHtml(phone)}</span>
                </div>
              ` : ''}
              ${subject ? `
                <div class="flex justify-between py-2 border-b border-gray-100">
                  <span class="font-medium text-gray-700">Chủ đề:</span>
                  <span class="text-gray-900">${escapeHtml(subject)}</span>
                </div>
              ` : ''}
              <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="font-medium text-gray-700">Nội dung:</span>
                <span class="text-gray-900 text-sm">${escapeHtml(message.substring(0, 100))}${message.length > 100 ? '...' : ''}</span>
              </div>
            </div>
          </div>

          <div class="flex justify-end space-x-3 p-4 border-t border-gray-200">
            <button type="button" class="arata-btn-cancel px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Hủy</button>
            <button type="button" class="arata-btn-confirm px-4 py-2 bg-primary text-white hover:bg-primary-dark rounded-lg transition-colors">Xác nhận gửi</button>
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
    cancelBtn.addEventListener('click', function () {
      closeConfirmationDialog();
    });

    // Handle confirm
    confirmBtn.addEventListener('click', function () {
      closeConfirmationDialog();
      onConfirm();
    });

    // Close on overlay click
    dialog.addEventListener('click', function (e) {
      if (e.target === this) {
        closeConfirmationDialog();
      }
    });

    // Close on escape key
    const escapeHandler = function (e) {
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
    // Restore body scroll if popup is also closed
    const popup = document.getElementById('arata-contact-popup');
    if (popup && popup.style.display === 'none') {
      document.body.classList.remove('overflow-hidden');
    }
  }

  // Clear existing alerts
  function clearAlerts() {
    const popup = document.getElementById('arata-contact-popup');
    if (!popup) return;
    const existingAlert = popup.querySelector('.arata-error-alert');
    if (existingAlert) {
      existingAlert.remove();
    }
  }

  // Submit form after confirmation
  function submitForm(form, submitBtn, submitText, loadingSpinner) {
    // Clear any previous alerts before proceeding
    clearAlerts();

    // Get submit button and elements if not provided
    if (!submitBtn) {
      submitBtn = form.querySelector('button[type="submit"]');
    }
    if (!submitText) {
      submitText = form.querySelector('.submit-text');
    }
    if (!loadingSpinner) {
      loadingSpinner = form.querySelector('.loading-spinner');
    }

    // Show loading state
    if (submitBtn) {
      submitBtn.disabled = true;
    }
    if (submitText) {
      submitText.textContent = 'Đang gửi...';
    }
    if (loadingSpinner) {
      loadingSpinner.classList.remove('opacity-0');
    }

    // Prepare form data
    const formData = new FormData(form);

    // Submit form via AJAX
    fetch(arataContactPopup.ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        // Reset button state first
        if (submitBtn) {
          submitBtn.disabled = false;
        }
        if (submitText) {
          submitText.textContent = 'Gửi liên hệ';
        }
        if (loadingSpinner) {
          loadingSpinner.classList.add('opacity-0');
        }

        if (data.success) {
          showSuccessMessage(data.data.message);
        } else {
          showErrorMessage(data.data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
      })
      .catch(error => {
        // Reset button state on error
        if (submitBtn) {
          submitBtn.disabled = false;
        }
        if (submitText) {
          submitText.textContent = 'Gửi liên hệ';
        }
        if (loadingSpinner) {
          loadingSpinner.classList.add('opacity-0');
        }
        showErrorMessage('Có lỗi xảy ra. Vui lòng thử lại.');
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
    return text.replace(/[&<>"']/g, function (m) { return map[m]; });
  }

  // Show success message
  function showSuccessMessage(message) {
    const popup = document.getElementById('arata-contact-popup');
    if (!popup) {
      return;
    }

    // Try multiple selectors to find the popup body
    let body = popup.querySelector('.arata-popup-body');
    if (!body) {
      body = popup.querySelector('.p-4.lg\\:p-6');
    }
    if (!body) {
      body = popup.querySelector('form').parentElement;
    }

    if (!body) {
      return;
    }

    body.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-semibold text-gray-900 mb-2">Thành công!</p>
                <p class="text-gray-600">${message}</p>
            </div>
        `;

    // Auto close popup after 2 seconds
    setTimeout(() => {
      closePopup();
    }, 2000);
  }

  // Show error message
  function showErrorMessage(message) {
    const popup = document.getElementById('arata-contact-popup');
    if (!popup) return;

    // Find the popup body - try multiple selectors
    let body = popup.querySelector('.arata-popup-body');
    if (!body) {
      body = popup.querySelector('.p-4.lg\\:p-6');
    }
    if (!body) {
      body = popup.querySelector('form').parentElement;
    }
    if (!body) return;

    const errorAlert = document.createElement('div');
    errorAlert.className = 'arata-error-alert bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-start space-x-2';
    errorAlert.innerHTML = `
        <svg class="arata-error-icon w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-sm">${message}</p>
    `;

    // Safe insert - check if firstChild exists
    if (body.firstChild) {
      body.insertBefore(errorAlert, body.firstChild);
    } else {
      body.appendChild(errorAlert);
    }
  }

  // Initialize when document is ready
  document.addEventListener('DOMContentLoaded', function () {
    if (typeof arataContactPopup !== 'undefined' && arataContactPopup.settings.enabled) {
      initContactPopup();
    }
  });
})();
