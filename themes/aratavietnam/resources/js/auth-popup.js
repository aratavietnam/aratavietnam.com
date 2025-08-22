/**
 * Authentication Popup Handler
 * Handles login, register, and forgot password popups
 *
 * @package ArataVietnam
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  const authDataElement = document.getElementById('arata-auth-data');

  if (!authDataElement) {
    return;
  }

  let arataAuth;
  try {
    arataAuth = JSON.parse(authDataElement.textContent);
  } catch (e) {
    return;
  }

  let currentPopup = null;

  // --- Popup HTML Templates ---
  const popupTemplates = {
    login: function () {
      return `
        <div id="arata-auth-popup" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" style="display: none;">
          <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] flex flex-col transform transition-transform duration-300 scale-95">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-shrink-0">
              <h2 class="text-lg lg:text-xl font-semibold text-gray-900">Đăng nhập</h2>
              <button type="button" class="arata-popup-close text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close popup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
              </button>
            </div>
            <div class="p-4 lg:p-6 overflow-y-auto">
              <form id="arata-login-form" class="space-y-4">
                <input type="hidden" name="action" value="arata_user_login" />
                <input type="hidden" name="nonce" value="${arataAuth.nonce}" />
                <div>
                  <label for="login-username" class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập hoặc Email *</label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                    <input id="login-username" name="username" type="text" required placeholder="Nhập tên đăng nhập hoặc email" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  </div>
                  <div class="mt-1 text-xs text-red-600 hidden" id="login-username-error"></div>
                </div>
                <div>
                  <label for="login-password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu *</label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></span>
                    <input id="login-password" name="password" type="password" required placeholder="Nhập mật khẩu" class="block w-full rounded-lg border border-gray-300 pl-10 pr-10 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    <button type="button" class="arata-password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" data-target="login-password">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                  </div>
                  <div class="mt-1 text-xs text-red-600 hidden" id="login-password-error"></div>
                </div>
                <div class="flex items-center justify-between">
                  <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" />
                    <span class="ml-2">Ghi nhớ đăng nhập</span>
                  </label>
                  <a href="#" class="arata-auth-link text-sm font-medium text-primary hover:text-primary-dark" data-form="forgot">Quên mật khẩu?</a>
                </div>
                <div class="pt-2">
                  <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2.5 text-white font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="submit-text">Đăng nhập</span>
                    <svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white hidden loading-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                  </button>
                </div>
                <div class="text-center pt-2">
                  <a href="#" class="arata-auth-link text-sm font-medium text-primary hover:text-primary-dark" data-form="register">Chưa có tài khoản? Đăng ký ngay</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      `;
    },

    register: function () {
      return `
        <div id="arata-auth-popup" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" style="display: none;">
          <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col transform transition-transform duration-300 scale-95">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-shrink-0">
              <h2 class="text-lg lg:text-xl font-semibold text-gray-900">Đăng ký tài khoản</h2>
              <button type="button" class="arata-popup-close text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close popup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
              </button>
            </div>
            <div class="p-4 lg:p-6 overflow-y-auto">
              <form id="arata-register-form" class="space-y-4">
                <input type="hidden" name="action" value="arata_user_register" />
                <input type="hidden" name="nonce" value="${arataAuth.nonce}" />
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label for="register-first-name" class="block text-sm font-medium text-gray-700 mb-1">Họ *</label>
                    <input id="register-first-name" name="first_name" type="text" required placeholder="Nhập họ" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    <div class="mt-1 text-xs text-red-600 hidden" id="register-first-name-error"></div>
                  </div>
                  <div>
                    <label for="register-last-name" class="block text-sm font-medium text-gray-700 mb-1">Tên *</label>
                    <input id="register-last-name" name="last_name" type="text" required placeholder="Nhập tên" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    <div class="mt-1 text-xs text-red-600 hidden" id="register-last-name-error"></div>
                  </div>
                </div>
                <div>
                  <label for="register-username" class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập *</label>
                  <input id="register-username" name="username" type="text" required placeholder="Nhập tên đăng nhập" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  <div class="mt-1 text-xs text-red-600 hidden" id="register-username-error"></div>
                </div>
                <div>
                  <label for="register-email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                  <input id="register-email" name="email" type="email" required placeholder="example@email.com" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  <div class="mt-1 text-xs text-red-600 hidden" id="register-email-error"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label for="register-password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu *</label>
                    <div class="relative">
                      <input id="register-password" name="password" type="password" required placeholder="Nhập mật khẩu" class="block w-full rounded-lg border border-gray-300 pr-10 pl-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                      <button type="button" class="arata-password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" data-target="register-password">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                      </button>
                    </div>
                    <div class="mt-1 text-xs text-red-600 hidden" id="register-password-error"></div>
                  </div>
                  <div>
                    <label for="register-confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu *</label>
                    <div class="relative">
                      <input id="register-confirm-password" name="confirm_password" type="password" required placeholder="Nhập lại mật khẩu" class="block w-full rounded-lg border border-gray-300 pr-10 pl-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                      <button type="button" class="arata-password-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600" data-target="register-confirm-password">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                      </button>
                    </div>
                    <div class="mt-1 text-xs text-red-600 hidden" id="register-confirm-password-error"></div>
                  </div>
                </div>
                <div class="pt-2">
                  <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2.5 text-white font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="submit-text">Đăng ký</span>
                    <svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white hidden loading-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                  </button>
                </div>
                <div class="text-center pt-2">
                  <a href="#" class="arata-auth-link text-sm font-medium text-primary hover:text-primary-dark" data-form="login">Đã có tài khoản? Đăng nhập</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      `;
    },

    forgot: function () {
      return `
        <div id="arata-auth-popup" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" style="display: none;">
          <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] flex flex-col transform transition-transform duration-300 scale-95">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-shrink-0">
              <h2 class="text-lg lg:text-xl font-semibold text-gray-900">Quên mật khẩu</h2>
              <button type="button" class="arata-popup-close text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close popup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
              </button>
            </div>
            <div class="p-4 lg:p-6 overflow-y-auto">
              <p class="text-sm text-gray-600 mb-4">Nhập email hoặc tên đăng nhập để nhận link khôi phục mật khẩu.</p>
              <form id="arata-forgot-form" class="space-y-4">
                <input type="hidden" name="action" value="arata_forgot_password" />
                <input type="hidden" name="nonce" value="${arataAuth.nonce}" />
                <div>
                  <label for="forgot-user-login" class="block text-sm font-medium text-gray-700 mb-1">Email hoặc tên đăng nhập *</label>
                  <input id="forgot-user-login" name="user_login" type="text" required placeholder="Nhập email hoặc tên đăng nhập" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                  <div class="mt-1 text-xs text-red-600 hidden" id="forgot-user-login-error"></div>
                </div>
                <div class="pt-2">
                  <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2.5 text-white font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="submit-text">Gửi email khôi phục</span>
                    <svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white hidden loading-spinner" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                  </button>
                </div>
                <div class="text-center pt-2">
                  <a href="#" class="arata-auth-link text-sm font-medium text-primary hover:text-primary-dark" data-form="login">Quay lại đăng nhập</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      `;
    }
  };

  // Initialize auth popup system
  function initAuthPopup() {
    // Bind account button click
    bindAccountButton();
  }

  // Bind account button to show login popup
  function bindAccountButton() {
    document.addEventListener('click', function (e) {
      const accountButton = e.target.closest('.account-toggle');
      if (accountButton) {
        e.preventDefault();
        e.stopPropagation();
        showPopup('login');
      }
    });
  }

  function showPopup(type) {
    if (document.getElementById('arata-auth-popup')) return;

    const popupHTML = popupTemplates[type]();
    document.body.insertAdjacentHTML('beforeend', popupHTML);
    currentPopup = document.getElementById('arata-auth-popup');
    if (!currentPopup) return;

    const container = currentPopup.querySelector('div > div'); // The direct child div is the container

    currentPopup.style.display = 'flex';
    setTimeout(() => {
      currentPopup.classList.remove('opacity-0');
      if (container) container.classList.remove('scale-95');
    }, 10);

    document.body.classList.add('overflow-hidden');
    bindPopupEvents(type);

    const firstInput = currentPopup.querySelector('input:not([type="hidden"])');
    if (firstInput) setTimeout(() => firstInput.focus(), 100);
  }

  function closePopup(callback) {
    if (!currentPopup) {
      if (callback) callback();
      return;
    }

    const container = currentPopup.querySelector('div > div');
    currentPopup.classList.add('opacity-0');
    if (container) container.classList.add('scale-95');

    setTimeout(() => {
      if (currentPopup) currentPopup.remove();
      currentPopup = null;
      document.body.classList.remove('overflow-hidden');
      document.removeEventListener('keydown', handleEscapeKey);
      if (callback) callback();
    }, 300);
  }

  function handleEscapeKey(e) {
    if (e.key === 'Escape' && currentPopup) closePopup();
  }

  function bindPopupEvents(type) {
    if (!currentPopup) return;

    const closeBtn = currentPopup.querySelector('.arata-popup-close');
    const form = currentPopup.querySelector('form');
    const authLinks = currentPopup.querySelectorAll('.arata-auth-link');
    const passwordToggles = currentPopup.querySelectorAll('.arata-password-toggle');

    closeBtn.addEventListener('click', () => closePopup());
    currentPopup.addEventListener('click', (e) => { if (e.target === currentPopup) closePopup(); });
    document.addEventListener('keydown', handleEscapeKey);

    form.addEventListener('submit', (e) => handleFormSubmission(e, type));

    authLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetForm = link.getAttribute('data-form');
        closePopup(() => showPopup(targetForm));
      });
    });

    passwordToggles.forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        togglePasswordVisibility(toggle);
      });
    });

    form.querySelectorAll('input[required]').forEach(input => {
      input.addEventListener('blur', () => validateField(input));
      input.addEventListener('input', () => validateField(input)); // Also validate on input
    });
  }

  // Toggle password visibility
  function togglePasswordVisibility(button) {
    const targetId = button.getAttribute('data-target');
    const input = document.getElementById(targetId);

    if (input.type === 'password') {
      input.type = 'text';
      button.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        </svg>
      `;
    } else {
      input.type = 'password';
      button.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
      `;
    }
  }

  // Handle form submission
  function handleFormSubmission(e, type) {
    e.preventDefault();

    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const submitText = submitBtn ? submitBtn.querySelector('.submit-text') : null;
    const loadingSpinner = submitBtn ? submitBtn.querySelector('.loading-spinner') : null;

    if (!submitBtn) {
      showErrorMessage(form, 'Không tìm thấy nút gửi. Vui lòng tải lại trang.');
      return;
    }

    if (!validateForm(form, type)) {
      return;
    }

    // Show loading state
    if (submitBtn) submitBtn.disabled = true;
    const originalButtonText = submitText ? submitText.textContent : 'Gửi';
    if (submitText) submitText.textContent = 'Đang xử lý...';
    if (loadingSpinner) loadingSpinner.classList.remove('hidden');

    clearFormErrors(form);

    const formData = new FormData(form);

    fetch(arataAuth.ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showSuccessMessage(data.data.message || 'Thao tác thành công!');
          setTimeout(() => {
            if (data.data.redirect) {
              window.location.href = data.data.redirect;
            } else {
              window.location.reload();
            }
          }, 1500);
        } else {
          showErrorMessage(form, data.data.message || 'Đã có lỗi xảy ra. Vui lòng thử lại.');
          if (submitBtn) submitBtn.disabled = false;
          if (submitText) submitText.textContent = originalButtonText;
          if (loadingSpinner) loadingSpinner.classList.add('hidden');
        }
      })
      .catch(error => {
        showErrorMessage(form, 'Có lỗi xảy ra. Vui lòng thử lại.');
        if (submitBtn) submitBtn.disabled = false;
        if (submitText) submitText.textContent = originalButtonText;
        if (loadingSpinner) loadingSpinner.classList.add('hidden');
      });
  }

  // Reset submit button
  function resetSubmitButton(submitBtn, submitText, loadingSpinner, type) {
    submitBtn.disabled = false;
    loadingSpinner.style.display = 'none';

    const buttonTexts = {
      login: 'Đăng nhập',
      register: 'Đăng ký',
      forgot: 'Gửi email khôi phục'
    };

    submitText.textContent = buttonTexts[type] || 'Gửi';
  }

  // Validate form
  function validateForm(form, type) {
    let isValid = true;
    const inputs = form.querySelectorAll('input:not([type="hidden"])');

    inputs.forEach(input => {
      if (!validateField(input, type)) {
        isValid = false;
      }
    });

    return isValid;
  }

  // --- Validation and Error Handling ---
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

  function validateField(field) {
    const fieldId = field.id;
    const fieldName = field.name;
    const value = field.value.trim();
    let isValid = true;

    // Required validation
    if (field.hasAttribute('required') && !value) {
      showError(fieldId, arataAuth.messages.requiredField);
      return false;
    }

    // Specific validation
    switch (fieldName) {
      case 'email':
        if (value && !/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value)) {
          isValid = false;
          showError(fieldId, arataAuth.messages.invalidEmail);
        } else {
          hideError(fieldId);
        }
        break;
      case 'password':
        if (value && value.length < 8) {
          isValid = false;
          showError(fieldId, arataAuth.messages.weakPassword);
        } else {
          hideError(fieldId);
        }
        break;
      case 'confirm_password':
        const passwordField = currentPopup.querySelector('[name="password"]');
        if (passwordField && value !== passwordField.value) {
          isValid = false;
          showError(fieldId, arataAuth.messages.passwordMismatch);
        } else {
          hideError(fieldId);
        }
        break;
      default:
        hideError(fieldId);
        break;
    }
    return isValid;
  }

  // Email validation
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function clearFormErrors(form) {
    const alert = form.querySelector('.arata-error-alert');
    if (alert) {
      alert.remove();
    }
  }

  function showSuccessMessage(message) {
    if (!currentPopup) return;
    const body = currentPopup.querySelector('.overflow-y-auto');
    body.innerHTML = `
      <div class="text-center p-6">
        <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="mt-4 text-lg font-medium text-gray-800">${message}</p>
      </div>
    `;
  }

  function showErrorMessage(form, message) {
    clearFormErrors(form);
    const errorAlert = document.createElement('div');
    errorAlert.className = 'arata-error-alert bg-red-50 border border-red-200 text-sm text-red-700 p-3 rounded-lg flex items-start space-x-2';
    errorAlert.innerHTML = `
      <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
      <span>${message}</span>
    `;
    form.prepend(errorAlert);
  }

  // Initialize the popup logic
  initAuthPopup();
});
