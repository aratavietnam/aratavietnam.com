<?php
/**
 * Contact Configuration in Theme Customizer
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Contact Configuration section to Theme Customizer
 */
function arata_contact_customizer_config($wp_customize) {

    // Add Contact Configuration section
    $wp_customize->add_section('arata_contact_config', array(
        'title' => __('Contact Configuration', 'aratavietnam'),
        'description' => __('Configure contact page behavior and display options', 'aratavietnam'),
        'priority' => 35,
        'capability' => 'edit_theme_options',
    ));

    // Contact popup mode setting
    $wp_customize->add_setting('arata_contact_popup_mode', array(
        'default' => false,
        'sanitize_callback' => 'arata_sanitize_checkbox',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_mode', array(
        'label' => __('Enable Contact Popup Mode', 'aratavietnam'),
        'description' => __('When enabled, clicking "Liên hệ" in header menu will show a popup form instead of navigating to contact page', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'checkbox',
        'priority' => 10,
    ));

    // Popup form title
    $wp_customize->add_setting('arata_contact_popup_title', array(
        'default' => __('Liên hệ với chúng tôi', 'aratavietnam'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_title', array(
        'label' => __('Popup Form Title', 'aratavietnam'),
        'description' => __('Title displayed in the contact popup form', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'text',
        'priority' => 20,
    ));

    // Popup form description
    $wp_customize->add_setting('arata_contact_popup_description', array(
        'default' => __('Vui lòng điền thông tin. Các trường có * là bắt buộc.', 'aratavietnam'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_description', array(
        'label' => __('Popup Form Description', 'aratavietnam'),
        'description' => __('Description displayed below the popup form title', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'textarea',
        'priority' => 30,
    ));

    // Show company info in popup
    $wp_customize->add_setting('arata_contact_popup_show_info', array(
        'default' => true,
        'sanitize_callback' => 'arata_sanitize_checkbox',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_show_info', array(
        'label' => __('Show Company Information in Popup', 'aratavietnam'),
        'description' => __('Display company contact information in the popup form', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'checkbox',
        'priority' => 40,
    ));

    // Popup width setting
    $wp_customize->add_setting('arata_contact_popup_width', array(
        'default' => 'md',
        'sanitize_callback' => 'arata_sanitize_select',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_width', array(
        'label' => __('Popup Width', 'aratavietnam'),
        'description' => __('Choose the width of the contact popup', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'select',
        'choices' => array(
            'sm' => __('Small (400px)', 'aratavietnam'),
            'md' => __('Medium (600px)', 'aratavietnam'),
            'lg' => __('Large (800px)', 'aratavietnam'),
            'xl' => __('Extra Large (1000px)', 'aratavietnam'),
        ),
        'priority' => 50,
    ));

    // Success message
    $wp_customize->add_setting('arata_contact_popup_success_message', array(
        'default' => __('Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất.', 'aratavietnam'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_success_message', array(
        'label' => __('Success Message', 'aratavietnam'),
        'description' => __('Message displayed when form is submitted successfully', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'textarea',
        'priority' => 60,
    ));

    // Error message
    $wp_customize->add_setting('arata_contact_popup_error_message', array(
        'default' => __('Có lỗi xảy ra. Vui lòng kiểm tra và thử lại.', 'aratavietnam'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('arata_contact_popup_error_message', array(
        'label' => __('Error Message', 'aratavietnam'),
        'description' => __('Message displayed when form submission fails', 'aratavietnam'),
        'section' => 'arata_contact_config',
        'type' => 'textarea',
        'priority' => 70,
    ));
}
add_action('customize_register', 'arata_contact_customizer_config');

/**
 * Sanitize checkbox
 */
function arata_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select
 */
function arata_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Get contact popup mode status
 */
function arata_get_contact_popup_mode() {
    $mode = get_theme_mod('arata_contact_popup_mode', false);
    return $mode;
}

/**
 * Get contact popup settings
 */
function arata_get_contact_popup_settings() {
    return array(
        'enabled' => arata_get_contact_popup_mode(),
        'title' => get_theme_mod('arata_contact_popup_title', __('Liên hệ với chúng tôi', 'aratavietnam')),
        'description' => get_theme_mod('arata_contact_popup_description', __('Vui lòng điền thông tin. Các trường có * là bắt buộc.', 'aratavietnam')),
        'show_info' => get_theme_mod('arata_contact_popup_show_info', true),
        'width' => get_theme_mod('arata_contact_popup_width', 'md'),
        'success_message' => get_theme_mod('arata_contact_popup_success_message', __('Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất.', 'aratavietnam')),
        'error_message' => get_theme_mod('arata_contact_popup_error_message', __('Có lỗi xảy ra. Vui lòng kiểm tra và thử lại.', 'aratavietnam')),
    );
}

/**
 * Enqueue popup scripts and styles
 */
function arata_enqueue_contact_popup_assets() {
    // Always localize script data, but with different settings based on mode
    $settings = arata_get_contact_popup_settings();

    // Use the correct script handle from TailPress
    wp_localize_script('aratavietnam', 'arataContactPopup', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('arata_contact_popup_nonce'),
        'settings' => $settings,
    ));
}
add_action('wp_enqueue_scripts', 'arata_enqueue_contact_popup_assets');

/**
 * Modify contact menu links to trigger popup when enabled
 */
function arata_modify_contact_menu_links($items, $args) {
    if (arata_get_contact_popup_mode() && $args->theme_location === 'primary') {
        // Add data attribute to contact links
        $items = preg_replace(
            '/<a([^>]*href=[^>]*(?:contact|lien-he)[^>]*[^>]*)>/i',
            '<a$1 data-contact-popup="true">',
            $items
        );

        // Also handle Vietnamese variations
        $items = preg_replace(
            '/<a([^>]*href=[^>]*(?:lien-he|liên-hệ|contact)[^>]*[^>]*)>/i',
            '<a$1 data-contact-popup="true">',
            $items
        );
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'arata_modify_contact_menu_links', 10, 2);

/**
 * Add JavaScript to handle contact menu clicks globally (Cache-safe version)
 */
function arata_add_contact_popup_script() {
    if (!arata_get_contact_popup_mode()) {
        return;
    }
    ?>
    <script>
    // Cache-safe contact popup handler
    (function() {
        'use strict';
        
        let popupInitialized = false;
        let retryCount = 0;
        const maxRetries = 50; // 5 seconds max wait
        
        function initPopupHandler() {
            // Global click handler with retry mechanism
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a');
                if (!target) return;

                const href = target.getAttribute('href') || '';
                const isContactLink = href.includes('contact') ||
                                     href.includes('lien-he') ||
                                     href.includes('liên-hệ') ||
                                     target.getAttribute('data-contact-popup') === 'true';

                if (!isContactLink) return;
                
                e.preventDefault();
                e.stopPropagation();

                // Try to open the popup with fallback mechanisms
                tryOpenPopup();
            });
        }
        
        function tryOpenPopup() {
            // Method 1: Check if arataContactPopup object exists and popup is enabled
            if (typeof window.arataContactPopup !== 'undefined' && 
                window.arataContactPopup.settings && 
                window.arataContactPopup.settings.enabled) {
                
                // Method 1a: Try to find existing popup element
                let popup = document.getElementById('arata-contact-popup');
                if (popup) {
                    showExistingPopup(popup);
                    return;
                }
                
                // Method 1b: Try to initialize popup if function exists
                if (typeof window.initContactPopup === 'function') {
                    try {
                        window.initContactPopup();
                        return;
                    } catch (e) {
                        console.warn('initContactPopup failed:', e);
                    }
                }
                
                // Method 1c: Create popup manually
                createPopupManually();
                return;
            }
            
            // Method 2: Wait for dependencies and retry
            if (retryCount < maxRetries) {
                retryCount++;
                setTimeout(tryOpenPopup, 100);
                return;
            }
            
            // Method 3: Fallback to contact page
            const contactUrl = '<?php echo home_url('/lien-he/'); ?>';
            if (contactUrl) {
                window.location.href = contactUrl;
            }
        }
        
        function showExistingPopup(popup) {
            popup.style.display = 'flex';
            setTimeout(() => {
                popup.classList.remove('opacity-0');
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
        
        function createPopupManually() {
            if (document.getElementById('arata-contact-popup')) return;
            
            const settings = window.arataContactPopup.settings;
            const widthClasses = {
                sm: 'max-w-sm',
                md: 'max-w-2xl', 
                lg: 'max-w-4xl',
                xl: 'max-w-6xl'
            };
            
            const popupHTML = `
                <div id="arata-contact-popup" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
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
                                <input type="hidden" name="nonce" value="${window.arataContactPopup.nonce}" />
                                <input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" />
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="popup-name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                                        <input id="popup-name" name="name" type="text" required placeholder="Nhập họ và tên của bạn" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label for="popup-email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                        <input id="popup-email" name="email" type="email" required placeholder="example@email.com" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label for="popup-phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                                        <input id="popup-phone" name="phone" type="tel" placeholder="0123 456 789" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label for="popup-subject" class="block text-sm font-medium text-gray-700 mb-1">Chủ đề</label>
                                        <input id="popup-subject" name="subject" type="text" placeholder="Chủ đề liên hệ" class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                </div>
                                <div>
                                    <label for="popup-message" class="block text-sm font-medium text-gray-700 mb-1">Nội dung *</label>
                                    <textarea id="popup-message" name="message" rows="4" required placeholder="Nhập nội dung tin nhắn của bạn..." class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
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
            
            document.body.insertAdjacentHTML('beforeend', popupHTML);
            
            const popup = document.getElementById('arata-contact-popup');
            bindPopupEvents(popup);
            showExistingPopup(popup);
        }
        
        function bindPopupEvents(popup) {
            const closeBtn = popup.querySelector('.arata-popup-close');
            const form = popup.querySelector('#arata-popup-form');
            
            // Close popup
            closeBtn.addEventListener('click', function() {
                popup.style.display = 'none';
                document.body.classList.remove('overflow-hidden');
            });
            
            popup.addEventListener('click', function(e) {
                if (e.target === this) {
                    popup.style.display = 'none';
                    document.body.classList.remove('overflow-hidden');
                }
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitContactForm(form);
            });
        }
        
        function submitContactForm(form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const submitText = form.querySelector('.submit-text');
            const loadingSpinner = form.querySelector('.loading-spinner');
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.textContent = 'Đang gửi...';
            loadingSpinner.classList.remove('opacity-0');
            
            const formData = new FormData(form);
            
            fetch(window.arataContactPopup.ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Gửi liên hệ';
                loadingSpinner.classList.add('opacity-0');
                
                if (data.success) {
                    const popup = document.getElementById('arata-contact-popup');
                    const body = popup.querySelector('.p-4.lg\\:p-6') || popup.querySelector('form').parentElement;
                    body.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-lg font-semibold text-gray-900 mb-2">Thành công!</p>
                            <p class="text-gray-600">${data.data.message}</p>
                        </div>
                    `;
                    setTimeout(() => {
                        popup.style.display = 'none';
                        document.body.classList.remove('overflow-hidden');
                    }, 2000);
                } else {
                    alert('Có lỗi xảy ra: ' + (data.data.message || 'Vui lòng thử lại.'));
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitText.textContent = 'Gửi liên hệ';
                loadingSpinner.classList.add('opacity-0');
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPopupHandler);
        } else {
            initPopupHandler();
        }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'arata_add_contact_popup_script');

/**
 * Create fallback arataContactPopup object directly in PHP
 * This ensures the popup works even if Vite build fails
 */
function arata_create_fallback_contact_popup_object() {
    if (!arata_get_contact_popup_mode()) {
        return;
    }

    $settings = arata_get_contact_popup_settings();
    ?>
    <script>
    // Create fallback arataContactPopup object
    window.arataContactPopup = {
        ajaxUrl: '<?php echo admin_url('admin-ajax.php'); ?>',
        nonce: '<?php echo wp_create_nonce('arata_contact_popup_nonce'); ?>',
        settings: <?php echo json_encode($settings); ?>
    };
    </script>
    <?php
}
add_action('wp_head', 'arata_create_fallback_contact_popup_object');

/**
 * AJAX handler for popup form submission
 */
function arata_handle_popup_contact_submission() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_contact_popup_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Honeypot check
    if (!empty($_POST['website'])) {
        wp_send_json_error(array('message' => __('Invalid submission.', 'aratavietnam')));
    }

    // Validate required fields
    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? wp_kses_post(wp_unslash($_POST['message'])) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => __('Vui lòng điền đầy đủ thông tin bắt buộc.', 'aratavietnam')));
    }

    // Create submission post
    $post_id = wp_insert_post(array(
        'post_type' => 'contact_submission',
        'post_status' => 'publish',
        'post_title' => sprintf(__('Contact from %s (%s)', 'aratavietnam'), $name, $email),
    ));

    if (is_wp_error($post_id) || !$post_id) {
        wp_send_json_error(array('message' => __('Không thể lưu thông tin liên hệ.', 'aratavietnam')));
    }

    // Save meta fields
    update_post_meta($post_id, 'arata_name', $name);
    update_post_meta($post_id, 'arata_email', $email);
    update_post_meta($post_id, 'arata_phone', $phone);
    update_post_meta($post_id, 'arata_subject', $subject);
    update_post_meta($post_id, 'arata_message', $message);

    // Send notification email
    $admin_email = get_option('admin_email');
    $subject_line = sprintf(__('New contact submission: %s', 'aratavietnam'), $subject ?: $name);
    $body = sprintf("Name: %s\nEmail: %s\nPhone: %s\nSubject: %s\n\nMessage:\n%s", $name, $email, $phone, $subject, wp_strip_all_tags($message));
    wp_mail($admin_email, $subject_line, $body);

    $settings = arata_get_contact_popup_settings();
    wp_send_json_success(array('message' => $settings['success_message']));
}
add_action('wp_ajax_arata_popup_contact_submit', 'arata_handle_popup_contact_submission');
add_action('wp_ajax_nopriv_arata_popup_contact_submit', 'arata_handle_popup_contact_submission');
