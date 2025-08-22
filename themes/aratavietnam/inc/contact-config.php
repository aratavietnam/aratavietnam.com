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
 * Add JavaScript to handle contact menu clicks globally
 */
function arata_add_contact_popup_script() {
    if (!arata_get_contact_popup_mode()) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle contact menu clicks globally
        document.addEventListener('click', function(e) {
            const target = e.target.closest('a');
            if (!target) return;

            const href = target.getAttribute('href') || '';
            const isContactLink = href.includes('contact') ||
                                 href.includes('lien-he') ||
                                 href.includes('liên-hệ') ||
                                 target.getAttribute('data-contact-popup') === 'true';

            if (isContactLink) {
                e.preventDefault();
                e.stopPropagation();

                // Check if popup is available and enabled
                if (typeof arataContactPopup !== 'undefined' && arataContactPopup.settings.enabled) {
                    // Try to call the popup function
                    if (typeof initContactPopup === 'function') {
                        initContactPopup();
                    } else if (typeof openPopup === 'function') {
                        openPopup();
                    } else {
                        // Fallback: check for popup element
                        const popup = document.getElementById('arata-contact-popup');
                        if (popup) {
                            popup.style.display = 'flex';
                            document.body.classList.add('arata-popup-open');
                        }
                    }
                } else {
                    // Fallback to contact page
                    window.location.href = href;
                }
            }
        });
    });
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
