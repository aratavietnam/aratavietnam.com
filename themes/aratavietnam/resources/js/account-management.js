// Account Management JavaScript
class ArataAccountManager {
    constructor() {
        this.init();
    }

    init() {
        // Only initialize on account page
        if (!document.querySelector('.account-page')) {
            return;
        }

        this.accountTabs = document.querySelectorAll('.account-tab-btn');
        this.accountContents = document.querySelectorAll('.account-tab-content');
        this.avatarUpload = document.querySelector('input[type="file"][name="avatar"]');
        this.avatarPreview = document.querySelector('.account-page .rounded-full');
        this.forms = {
            profile: document.getElementById('account-profile-form'),
            security: document.getElementById('account-security-form'),
            notifications: document.getElementById('account-notifications-form')
        };
        
        this.bindEvents();
        this.loadUserData();
    }

    bindEvents() {
        // Tab switching
        this.accountTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchTab(tab.dataset.tab);
            });
        });

        // Avatar upload
        if (this.avatarUpload) {
            this.avatarUpload.addEventListener('change', (e) => {
                this.handleAvatarUpload(e);
            });
        }

        // Form submissions
        Object.entries(this.forms).forEach(([key, form]) => {
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.handleFormSubmit(key, form);
                });
            }
        });

        // Password visibility toggle
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                this.togglePasswordVisibility(toggle);
            });
        });

        // Account action buttons
        const deactivateBtn = document.getElementById('deactivate-account');
        const deleteBtn = document.getElementById('delete-account');
        
        if (deactivateBtn) {
            deactivateBtn.addEventListener('click', () => {
                this.showDeactivateConfirm();
            });
        }
        
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                this.showDeleteConfirm();
            });
        }
    }

    switchTab(tabId) {
        // Update tabs
        this.accountTabs.forEach(tab => {
            if (tab.dataset.tab === tabId) {
                tab.classList.add('active', 'text-primary', 'border-b-2', 'border-primary');
                tab.classList.remove('text-gray-600');
            } else {
                tab.classList.remove('active', 'text-primary', 'border-b-2', 'border-primary');
                tab.classList.add('text-gray-600');
            }
        });

        // Update content panels
        this.accountContents.forEach(content => {
            if (content.id === `${tabId}-tab`) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        });
    }

    async loadUserData() {
        try {
            const response = await fetch(arataAccountData.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'arata_get_user_data',
                    nonce: arataAccountData.nonce
                })
            });

            const data = await response.json();
            
            if (data.success) {
                this.populateUserData(data.data);
            }
        } catch (error) {
            console.error('Error loading user data:', error);
        }
    }

    populateUserData(userData) {
        // Profile form
        const profileForm = this.forms.profile;
        if (profileForm && userData.profile) {
            Object.entries(userData.profile).forEach(([key, value]) => {
                const field = profileForm.querySelector(`[name="${key}"]`);
                if (field) {
                    if (field.type === 'checkbox') {
                        field.checked = Boolean(value);
                    } else {
                        field.value = value || '';
                    }
                }
            });

            // Update avatar
            if (userData.avatar_url && this.avatarPreview) {
                this.avatarPreview.src = userData.avatar_url;
            }
        }

        // Security form - Keep empty for security
        const securityForm = this.forms.security;
        if (securityForm) {
            securityForm.reset();
        }

        // Notifications form
        const notificationsForm = this.forms.notifications;
        if (notificationsForm && userData.notifications) {
            Object.entries(userData.notifications).forEach(([key, value]) => {
                const field = notificationsForm.querySelector(`[name="${key}"]`);
                if (field) {
                    field.checked = Boolean(value);
                }
            });
        }
    }

    async handleFormSubmit(formType, form) {
        // Clear previous errors
        this.clearFormErrors(form);

        // Validate form
        const validation = this.validateForm(formType, form);
        if (!validation.valid) {
            this.showFormErrors(form, validation.errors);
            return;
        }

        // Show loading state
        this.setFormLoading(form, true);

        try {
            const formData = new FormData(form);
            const action = formType === 'profile' ? 'arata_update_profile' :
                          formType === 'security' ? 'arata_update_security' :
                          'arata_update_notifications';

            const response = await fetch(arataAccountData.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showFormSuccess(form, data.message);
                
                // Special handling for security form
                if (formType === 'security') {
                    this.showSecuritySuccess(data.data);
                }
                
                // Update UI if needed
                if (formType === 'profile' && data.data) {
                    this.updateProfileDisplay(data.data);
                }
            } else {
                this.showFormErrors(form, { general: data.message });
            }
        } catch (error) {
            this.showFormErrors(form, { general: 'Có lỗi xảy ra. Vui lòng thử lại.' });
        } finally {
            this.setFormLoading(form, false);
        }
    }

    validateForm(formType, form) {
        const errors = {};
        
        if (formType === 'profile') {
            const email = form.email.value;
            
            if (!form.first_name.value.trim()) {
                errors.first_name = 'Vui lòng nhập họ';
            }
            
            if (!form.last_name.value.trim()) {
                errors.last_name = 'Vui lòng nhập tên';
            }
            
            if (!email) {
                errors.email = 'Vui lòng nhập email';
            } else if (!this.isValidEmail(email)) {
                errors.email = 'Email không hợp lệ';
            }

            // Validate website URLs if provided
            const websiteFields = ['website', 'facebook', 'linkedin'];
            websiteFields.forEach(field => {
                const value = form[field]?.value;
                if (value && !this.isValidUrl(value)) {
                    errors[field] = 'URL không hợp lệ';
                }
            });
        }
        
        if (formType === 'security') {
            const currentPassword = form.current_password.value;
            const newPassword = form.new_password.value;
            const confirmPassword = form.confirm_password.value;
            
            if (!currentPassword) {
                errors.current_password = 'Vui lòng nhập mật khẩu hiện tại';
            }
            
            if (!newPassword) {
                errors.new_password = 'Vui lòng nhập mật khẩu mới';
            } else if (newPassword.length < 8) {
                errors.new_password = 'Mật khẩu phải có ít nhất 8 ký tự';
            }
            
            if (!confirmPassword) {
                errors.confirm_password = 'Vui lòng xác nhận mật khẩu mới';
            } else if (newPassword !== confirmPassword) {
                errors.confirm_password = 'Mật khẩu không khớp';
            }
        }

        return {
            valid: Object.keys(errors).length === 0,
            errors
        };
    }

    async handleAvatarUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validate file
        if (!file.type.startsWith('image/')) {
            this.showNotification('Vui lòng chọn file ảnh', 'error');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            this.showNotification('Kích thước file không được vượt quá 2MB', 'error');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = (e) => {
            if (this.avatarPreview) {
                this.avatarPreview.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);

        // Upload
        const formData = new FormData();
        formData.append('action', 'arata_upload_avatar');
        formData.append('nonce', arataAccountData.nonce);
        formData.append('avatar', file);

        try {
            const response = await fetch(arataAccountData.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Cập nhật ảnh đại diện thành công', 'success');
                // Update all avatar instances on page
                this.updateAllAvatars(data.data.avatar_url);
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            this.showNotification('Có lỗi xảy ra khi tải lên', 'error');
        }
    }

    togglePasswordVisibility(toggle) {
        const input = toggle.previousElementSibling;
        const icon = toggle.querySelector('svg');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        }
    }

    showDeactivateConfirm() {
        const modal = this.createConfirmModal(
            'Vô hiệu hóa tài khoản',
            'Bạn có chắc muốn vô hiệu hóa tài khoản? Bạn sẽ không thể đăng nhập cho đến khi kích hoạt lại.',
            'Vô hiệu hóa',
            () => {
                this.deactivateAccount();
            }
        );
        document.body.appendChild(modal);
    }

    showDeleteConfirm() {
        const modal = this.createConfirmModal(
            'Xóa tài khoản',
            'CẢNH BÁO: Hành động này không thể hoàn tác. Tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn.',
            'Xóa tài khoản',
            () => {
                this.deleteAccount();
            },
            true
        );
        document.body.appendChild(modal);
    }

    createConfirmModal(title, message, confirmText, onConfirm, isDangerous = false) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">${title}</h3>
                <p class="text-gray-600 mb-6">${message}</p>
                <div class="flex justify-end space-x-3">
                    <button class="modal-cancel px-4 py-2 text-gray-600 hover:text-gray-800">
                        Hủy
                    </button>
                    <button class="modal-confirm px-4 py-2 rounded text-white ${isDangerous ? 'bg-red-600 hover:bg-red-700' : 'bg-primary hover:bg-primary-dark'}">
                        ${confirmText}
                    </button>
                </div>
            </div>
        `;

        // Event listeners
        modal.querySelector('.modal-cancel').addEventListener('click', () => {
            modal.remove();
        });

        modal.querySelector('.modal-confirm').addEventListener('click', () => {
            onConfirm();
            modal.remove();
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });

        return modal;
    }

    async deactivateAccount() {
        const formData = new FormData();
        formData.append('action', 'arata_deactivate_account');
        formData.append('nonce', arataAccountData.nonce);

        try {
            const response = await fetch(arataAccountData.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.data.redirect;
                }, 2000);
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            this.showNotification('Có lỗi xảy ra', 'error');
        }
    }

    async deleteAccount() {
        const password = prompt('Vui lòng nhập mật khẩu để xác nhận xóa tài khoản:');
        if (!password) return;

        const formData = new FormData();
        formData.append('action', 'arata_delete_account');
        formData.append('nonce', arataAccountData.nonce);
        formData.append('password', password);

        try {
            const response = await fetch(arataAccountData.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.data.redirect;
                }, 2000);
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            this.showNotification('Có lỗi xảy ra', 'error');
        }
    }

    updateProfileDisplay(data) {
        // Update display name in header if exists
        const userDisplay = document.querySelector('.user-display-name');
        if (userDisplay) {
            userDisplay.textContent = data.display_name;
        }
    }

    updateAllAvatars(avatarUrl) {
        // Update all avatar images on page
        document.querySelectorAll('.avatar-img').forEach(img => {
            img.src = avatarUrl;
        });
    }

    showSecuritySuccess(data) {
        const message = document.createElement('div');
        message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        message.textContent = data.message;
        document.body.appendChild(message);

        setTimeout(() => {
            message.remove();
            window.location.href = data.redirect;
        }, 3000);
    }

    showFormSuccess(form, message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded';
        successDiv.textContent = message;
        
        form.insertBefore(successDiv, form.firstChild);
        
        setTimeout(() => {
            successDiv.remove();
        }, 5000);
    }

    showFormErrors(form, errors) {
        Object.entries(errors).forEach(([field, message]) => {
            if (field === 'general') {
                const generalError = document.createElement('div');
                generalError.className = 'mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded';
                generalError.textContent = message;
                form.insertBefore(generalError, form.firstChild);
            } else {
                const input = form.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('border-red-500');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-red-600 text-sm mt-1';
                    errorDiv.textContent = message;
                    input.parentNode.appendChild(errorDiv);
                }
            }
        });
    }

    clearFormErrors(form) {
        // Remove error classes
        form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
        
        // Remove error messages
        form.querySelectorAll('.text-red-600').forEach(el => {
            el.remove();
        });
        
        // Remove general error messages
        form.querySelectorAll('.bg-red-100').forEach(el => {
            el.remove();
        });
    }

    setFormLoading(form, isLoading) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        if (isLoading) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Đang xử lý...
            `;
        } else {
            submitBtn.disabled = false;
            submitBtn.innerHTML = submitBtn.dataset.originalText || 'Lưu thay đổi';
        }
    }

    showNotification(message, type = 'info') {
        // Use existing notification system if available
        if (window.ArataNotifications) {
            window.ArataNotifications.show(message, type);
            return;
        }

        // Fallback notification
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ArataAccountManager();
});

// Export for module systems
export default ArataAccountManager;