<?php
/**
 * Contact Form Popup Template with Theme Colors
 *
 * @package ArataVietnam
 */

// Get theme colors for inline styles
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
?>
<div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col transform transition-transform duration-300">

  <div class="flex items-center justify-between p-4 border-b border-gray-200 flex-shrink-0">
    <h2 class="text-lg lg:text-xl font-semibold text-gray-900" lang="vi">Liên hệ với chúng tôi</h2>
    <button type="button" class="arata-popup-close text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close popup">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
  </div>

  <div class="p-4 lg:p-6 overflow-y-auto">
    <p class="text-sm text-gray-600 mb-4" lang="vi">Vui lòng điền thông tin. Các trường có * là bắt buộc.</p>
    <form id="arata-popup-form" class="space-y-4">
      <input type="hidden" name="action" value="arata_popup_contact_submit">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('arata_popup_contact_nonce'); ?>">
      <input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off">

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="popup-name" class="block text-sm font-medium text-gray-700 mb-1" lang="vi">Họ và tên *</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </span>
            <input 
              id="popup-name" 
              name="name" 
              type="text" 
              required="" 
              placeholder="Nhập họ và tên của bạn" 
              class="block w-full rounded-lg border pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent focus:ring-primary border-gray-300"
            >
          </div>
          <div class="mt-1 text-xs text-red-600" id="popup-name-error">Họ tên phải có ít nhất 2 ký tự</div>
        </div>
        
        <div>
          <label for="popup-email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </span>
            <input 
              id="popup-email" 
              name="email" 
              type="email" 
              required="" 
              placeholder="example@email.com" 
              class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            >
          </div>
          <div class="mt-1 text-xs text-red-600 hidden" id="popup-email-error"></div>
        </div>
        
        <div>
          <label for="popup-phone" class="block text-sm font-medium text-gray-700 mb-1" lang="vi">Số điện thoại</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
            </span>
            <input 
              id="popup-phone" 
              name="phone" 
              type="tel" 
              placeholder="0123 456 789" 
              class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            >
          </div>
          <div class="mt-1 text-xs text-red-600 hidden" id="popup-phone-error"></div>
        </div>
        
        <div>
          <label for="popup-subject" class="block text-sm font-medium text-gray-700 mb-1" lang="vi">Chủ đề</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
              </svg>
            </span>
            <input 
              id="popup-subject" 
              name="subject" 
              type="text" 
              placeholder="Chủ đề liên hệ" 
              class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            >
          </div>
        </div>
      </div>

      <div>
        <label for="popup-message" class="block text-sm font-medium text-gray-700 mb-1" lang="vi">Nội dung *</label>
        <textarea 
          id="popup-message" 
          name="message" 
          rows="4" 
          required="" 
          placeholder="Nhập nội dung tin nhắn của bạn..." 
          class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
        ></textarea>
        <div class="mt-1 text-xs text-red-600 hidden" id="popup-message-error"></div>
      </div>

      <div class="pt-2">
        <button 
          type="submit" 
          class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg px-6 py-2.5 text-white font-medium focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed btn-primary"
        >
          <span class="submit-text" lang="vi">Gửi liên hệ</span>
          <svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white opacity-0 loading-spinner" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </button>
      </div>
    </form>
  </div>
</div>

<style>
/* Ensure CSS variables are properly set for the form */
#arata-popup-form input:focus,
#arata-popup-form textarea:focus {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 3px var(--color-primary)20;
}

/* Error state styling */
#arata-popup-form input.border-red-500,
#arata-popup-form textarea.border-red-500 {
  border-color: #ef4444 !important;
}

#arata-popup-form input.border-red-500:focus,
#arata-popup-form textarea.border-red-500:focus {
  box-shadow: 0 0 0 3px #ef444420;
}

/* Fallback for when CSS variables are not available */
:root {
  --color-primary: <?php echo esc_attr($primary_color); ?>;
}
</style>