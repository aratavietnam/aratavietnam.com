<?php
/**
 * Account Management AJAX Handler
 *
 * Handles AJAX requests for account management functionality
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register AJAX actions
 */
add_action('wp_ajax_arata_update_profile', 'arata_ajax_update_profile');
add_action('wp_ajax_arata_update_security', 'arata_ajax_update_security');
add_action('wp_ajax_arata_update_notifications', 'arata_ajax_update_notifications');
add_action('wp_ajax_arata_upload_avatar', 'arata_ajax_upload_avatar');
add_action('wp_ajax_arata_deactivate_account', 'arata_ajax_deactivate_account');
add_action('wp_ajax_arata_delete_account', 'arata_ajax_delete_account');
add_action('wp_ajax_arata_get_user_data', 'arata_ajax_get_user_data');

/**
 * Register shortcode
 */
add_action('init', 'arata_register_account_shortcode');

function arata_register_account_shortcode() {
    add_shortcode('arata_account_page', 'arata_account_page_shortcode');
}

/**
 * Update user profile
 */
function arata_ajax_update_profile() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to update your profile.', 'aratavietnam')));
    }

    $user_id = get_current_user_id();
    $user_data = array();
    $meta_data = array();

    // Sanitize and validate basic user data
    if (isset($_POST['first_name'])) {
        $user_data['first_name'] = sanitize_text_field($_POST['first_name']);
    }
    if (isset($_POST['last_name'])) {
        $user_data['last_name'] = sanitize_text_field($_POST['last_name']);
    }
    if (isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        if (!is_email($email)) {
            wp_send_json_error(array('message' => __('Invalid email address.', 'aratavietnam')));
        }
        if (email_exists($email) && $email !== get_user_by('id', $user_id)->user_email) {
            wp_send_json_error(array('message' => __('Email already exists.', 'aratavietnam')));
        }
        $user_data['user_email'] = $email;
    }

    // Update display name if first or last name changed
    if (isset($user_data['first_name']) || isset($user_data['last_name'])) {
        $first_name = $user_data['first_name'] ?? get_user_meta($user_id, 'first_name', true);
        $last_name = $user_data['last_name'] ?? get_user_meta($user_id, 'last_name', true);
        $user_data['display_name'] = trim($first_name . ' ' . $last_name);
    }

    // Sanitize meta fields
    $meta_fields = array(
        'phone' => 'sanitize_text_field',
        'address' => 'sanitize_textarea_field',
        'city' => 'sanitize_text_field',
        'company' => 'sanitize_text_field',
        'position' => 'sanitize_text_field',
        'birth_date' => 'sanitize_text_field',
        'gender' => 'sanitize_text_field',
        'interests' => 'sanitize_text_field',
        'website' => 'sanitize_url',
        'facebook' => 'sanitize_url',
        'linkedin' => 'sanitize_url',
        'bio' => 'wp_kses_post',
    );

    foreach ($meta_fields as $field => $sanitize_callback) {
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            $meta_data[$field] = call_user_func($sanitize_callback, $_POST[$field]);
        }
    }

    // Update user data
    if (!empty($user_data)) {
        $result = wp_update_user(array_merge(array('ID' => $user_id), $user_data));
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }
    }

    // Update meta data
    foreach ($meta_data as $key => $value) {
        update_user_meta($user_id, 'arata_' . $key, $value);
    }

    // Send success response
    wp_send_json_success(array(
        'message' => __('Profile updated successfully!', 'aratavietnam'),
        'data' => array(
            'display_name' => get_user_by('id', $user_id)->display_name,
            'email' => get_user_by('id', $user_id)->user_email,
        )
    ));
}

/**
 * Update security settings
 */
function arata_ajax_update_security() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to update security settings.', 'aratavietnam')));
    }

    $user_id = get_current_user_id();
    $user = get_user_by('id', $user_id);

    // Verify current password
    if (!wp_check_password($_POST['current_password'], $user->user_pass, $user_id)) {
        wp_send_json_error(array('message' => __('Current password is incorrect.', 'aratavietnam')));
    }

    // Validate new password
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($new_password) < 8) {
        wp_send_json_error(array('message' => __('Password must be at least 8 characters long.', 'aratavietnam')));
    }

    if ($new_password !== $confirm_password) {
        wp_send_json_error(array('message' => __('Passwords do not match.', 'aratavietnam')));
    }

    // Update password
    wp_set_password($new_password, $user_id);

    // Log user out after password change
    wp_clear_auth_cookie();
    wp_send_json_success(array(
        'message' => __('Password updated successfully! Please log in again.', 'aratavietnam'),
        'redirect' => wp_login_url()
    ));
}

/**
 * Update notification preferences
 */
function arata_ajax_update_notifications() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to update notification settings.', 'aratavietnam')));
    }

    $user_id = get_current_user_id();

    // Update notification preferences
    $notification_fields = array(
        'email_notifications' => 'boolval',
        'news_notifications' => 'boolval',
        'promo_notifications' => 'boolval',
    );

    foreach ($notification_fields as $field => $type_callback) {
        $value = isset($_POST[$field]) ? call_user_func($type_callback, $_POST[$field]) : false;
        update_user_meta($user_id, 'arata_' . $field, $value);
    }

    wp_send_json_success(array('message' => __('Notification settings updated successfully!', 'aratavietnam')));
}

/**
 * Upload user avatar
 */
function arata_ajax_upload_avatar() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to upload an avatar.', 'aratavietnam')));
    }

    // Check if file was uploaded
    if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error(array('message' => __('File upload failed.', 'aratavietnam')));
    }

    // Validate file type
    $allowed_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
    $file_type = $_FILES['avatar']['type'];
    
    if (!in_array($file_type, $allowed_types)) {
        wp_send_json_error(array('message' => __('Invalid file type. Only JPG, PNG, and GIF are allowed.', 'aratavietnam')));
    }

    // Validate file size (max 2MB)
    if ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
        wp_send_json_error(array('message' => __('File size must be less than 2MB.', 'aratavietnam')));
    }

    // Upload file
    $upload = wp_handle_upload($_FILES['avatar'], array('test_form' => false));
    
    if (isset($upload['error'])) {
        wp_send_json_error(array('message' => $upload['error']));
    }

    // Create attachment
    $attachment = array(
        'post_mime_type' => $upload['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($upload['file'])),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attachment_id = wp_insert_attachment($attachment, $upload['file']);
    if (!is_wp_error($attachment_id)) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attachment_data);
    }

    // Delete old avatar if exists
    $old_avatar_id = get_user_meta(get_current_user_id(), 'arata_avatar_id', true);
    if ($old_avatar_id) {
        wp_delete_attachment($old_avatar_id, true);
    }

    // Update user meta
    update_user_meta(get_current_user_id(), 'arata_avatar_id', $attachment_id);
    update_user_meta(get_current_user_id(), 'arata_avatar_url', $upload['url']);

    wp_send_json_success(array(
        'message' => __('Avatar updated successfully!', 'aratavietnam'),
        'avatar_url' => $upload['url']
    ));
}

/**
 * Deactivate user account
 */
function arata_ajax_deactivate_account() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to deactivate your account.', 'aratavietnam')));
    }

    $user_id = get_current_user_id();

    // Deactivate account by changing user role
    $result = wp_update_user(array(
        'ID' => $user_id,
        'role' => 'deactivated'
    ));

    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => $result->get_error_message()));
    }

    // Log user out
    wp_clear_auth_cookie();

    wp_send_json_success(array(
        'message' => __('Your account has been deactivated successfully.', 'aratavietnam'),
        'redirect' => home_url()
    ));
}

/**
 * Delete user account
 */
function arata_ajax_delete_account() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to delete your account.', 'aratavietnam')));
    }

    // Verify password
    $user = get_user_by('id', get_current_user_id());
    if (!wp_check_password($_POST['password'], $user->user_pass, $user->ID)) {
        wp_send_json_error(array('message' => __('Incorrect password.', 'aratavietnam')));
    }

    $user_id = get_current_user_id();

    // Delete user avatar if exists
    $avatar_id = get_user_meta($user_id, 'arata_avatar_id', true);
    if ($avatar_id) {
        wp_delete_attachment($avatar_id, true);
    }

    // Delete user and reassign content to admin
    require_once(ABSPATH . 'wp-admin/includes/user.php');
    wp_delete_user($user_id, 1); // Reassign to admin user with ID 1

    wp_send_json_success(array(
        'message' => __('Your account has been deleted successfully.', 'aratavietnam'),
        'redirect' => home_url()
    ));
}

/**
 * Add custom user role for deactivated accounts
 */
add_action('init', 'arata_add_deactivated_user_role');

function arata_add_deactivated_user_role() {
    add_role('deactivated', __('Deactivated', 'aratavietnam'), array(
        'read' => false,
    ));
}

/**
 * Prevent deactivated users from logging in
 */
add_filter('wp_authenticate_user', 'arata_prevent_deactivated_login', 10, 2);

function arata_prevent_deactivated_login($user, $password) {
    if (is_wp_error($user)) {
        return $user;
    }

    if (in_array('deactivated', (array) $user->roles)) {
        return new WP_Error(
            'account_deactivated',
            __('Your account has been deactivated. Please contact support.', 'aratavietnam')
        );
    }

    return $user;
}

/**
 * Get user data for account page
 */
function arata_ajax_get_user_data() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'arata_account_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'aratavietnam')));
    }

    // Check if user is logged in
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in.', 'aratavietnam')));
    }

    $user_id = get_current_user_id();
    $user = get_user_by('id', $user_id);

    // Get profile data
    $profile_data = array(
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->user_email,
        'display_name' => $user->display_name,
        'phone' => get_user_meta($user_id, 'arata_phone', true),
        'address' => get_user_meta($user_id, 'arata_address', true),
        'city' => get_user_meta($user_id, 'arata_city', true),
        'company' => get_user_meta($user_id, 'arata_company', true),
        'position' => get_user_meta($user_id, 'arata_position', true),
        'birth_date' => get_user_meta($user_id, 'arata_birth_date', true),
        'gender' => get_user_meta($user_id, 'arata_gender', true),
        'interests' => get_user_meta($user_id, 'arata_interests', true),
        'website' => get_user_meta($user_id, 'arata_website', true),
        'facebook' => get_user_meta($user_id, 'arata_facebook', true),
        'linkedin' => get_user_meta($user_id, 'arata_linkedin', true),
        'bio' => get_user_meta($user_id, 'arata_bio', true),
    );

    // Get notification preferences
    $notifications_data = array(
        'email_notifications' => get_user_meta($user_id, 'arata_email_notifications', true),
        'news_notifications' => get_user_meta($user_id, 'arata_news_notifications', true),
        'promo_notifications' => get_user_meta($user_id, 'arata_promo_notifications', true),
    );

    // Get avatar
    $avatar_data = array(
        'avatar_url' => get_user_meta($user_id, 'arata_avatar_url', true),
        'avatar_id' => get_user_meta($user_id, 'arata_avatar_id', true),
    );

    wp_send_json_success(array(
        'profile' => $profile_data,
        'notifications' => $notifications_data,
        'avatar' => $avatar_data,
        'avatar_url' => $avatar_data['avatar_url'] ?: get_avatar_url($user_id, 96),
    ));
}

/**
 * Account Page Shortcode
 * Displays the account management interface
 */
function arata_account_page_shortcode() {
    // Check if user is logged in
    if (!is_user_logged_in()) {
        $login_url = wp_login_url(get_permalink());
        $output = '<div class="account-login-notice bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">';
        $output .= '<h3 class="text-xl font-semibold mb-2">' . __('Đăng nhập để quản lý tài khoản', 'aratavietnam') . '</h3>';
        $output .= '<p class="text-gray-600 mb-4">' . __('Bạn cần đăng nhập để xem và quản lý thông tin tài khoản.', 'aratavietnam') . '</p>';
        $output .= '<a href="' . esc_url($login_url) . '" class="inline-block px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">';
        $output .= __('Đăng nhập', 'aratavietnam');
        $output .= '</a>';
        $output .= '</div>';
        return $output;
    }

    // Get current user data
    $user_id = get_current_user_id();
    $user = get_userdata($user_id);
    
    // Get user meta fields
    $user_meta = array(
        'phone' => get_user_meta($user_id, 'arata_phone', true),
        'address' => get_user_meta($user_id, 'arata_address', true),
        'city' => get_user_meta($user_id, 'arata_city', true),
        'company' => get_user_meta($user_id, 'arata_company', true),
        'position' => get_user_meta($user_id, 'arata_position', true),
        'bio' => get_user_meta($user_id, 'arata_bio', true),
        'birth_date' => get_user_meta($user_id, 'arata_birth_date', true),
        'gender' => get_user_meta($user_id, 'arata_gender', true),
        'interests' => get_user_meta($user_id, 'arata_interests', true),
        'website' => get_user_meta($user_id, 'arata_website', true),
        'facebook' => get_user_meta($user_id, 'arata_facebook', true),
        'linkedin' => get_user_meta($user_id, 'arata_linkedin', true),
        'member_since' => get_user_meta($user_id, 'arata_member_since', true),
        'last_login' => get_user_meta($user_id, 'arata_last_login', true),
    );

    // Start output buffering
    ob_start();
    ?>
    <div class="account-page">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Account Navigation Tabs -->
                    <div class="bg-white rounded-lg shadow-md mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="flex -mb-px">
                                <button class="account-tab-btn active px-6 py-4 text-primary border-b-2 border-primary font-medium" data-tab="profile">
                                    <i data-lucide="user" class="w-5 h-5 inline mr-2"></i>
                                    <?php _e('Hồ sơ cá nhân', 'aratavietnam'); ?>
                                </button>
                                <button class="account-tab-btn px-6 py-4 text-gray-600 hover:text-primary font-medium" data-tab="security">
                                    <i data-lucide="shield" class="w-5 h-5 inline mr-2"></i>
                                    <?php _e('Bảo mật', 'aratavietnam'); ?>
                                </button>
                                <button class="account-tab-btn px-6 py-4 text-gray-600 hover:text-primary font-medium" data-tab="notifications">
                                    <i data-lucide="bell" class="w-5 h-5 inline mr-2"></i>
                                    <?php _e('Thông báo', 'aratavietnam'); ?>
                                </button>
                            </nav>
                        </div>

                        <!-- Profile Tab Content -->
                        <div id="profile-tab" class="account-tab-content p-6">
                            <form id="account-profile-form" class="space-y-6">
                                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('arata_account_nonce'); ?>">
                                <!-- Avatar Section -->
                                <div class="flex items-center space-x-6 pb-6 border-b border-gray-200">
                                    <div class="relative">
                                        <?php echo get_avatar($user_id, 96, '', 'User Avatar', array('class' => 'w-24 h-24 rounded-full')); ?>
                                        <button type="button" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 hover:bg-primary-dark transition-colors">
                                            <i data-lucide="camera" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold"><?php echo esc_html($user->display_name); ?></h3>
                                        <p class="text-gray-600"><?php echo esc_html($user->user_email); ?></p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <?php 
                                            if ($user_meta['member_since']) {
                                                printf(__('Thành viên từ: %s', 'aratavietnam'), date_i18n(get_option('date_format'), strtotime($user_meta['member_since'])));
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Họ', 'aratavietnam'); ?> *</label>
                                        <input type="text" name="first_name" value="<?php echo esc_attr($user->first_name); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Tên', 'aratavietnam'); ?> *</label>
                                        <input type="text" name="last_name" value="<?php echo esc_attr($user->last_name); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Email', 'aratavietnam'); ?> *</label>
                                        <input type="email" name="email" value="<?php echo esc_attr($user->user_email); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Số điện thoại', 'aratavietnam'); ?></label>
                                        <input type="tel" name="phone" value="<?php echo esc_attr($user_meta['phone']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Địa chỉ', 'aratavietnam'); ?></label>
                                        <textarea name="address" rows="3" 
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"><?php echo esc_textarea($user_meta['address']); ?></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Thành phố', 'aratavietnam'); ?></label>
                                        <input type="text" name="city" value="<?php echo esc_attr($user_meta['city']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Ngày sinh', 'aratavietnam'); ?></label>
                                        <input type="date" name="birth_date" value="<?php echo esc_attr($user_meta['birth_date']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Giới tính', 'aratavietnam'); ?></label>
                                        <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                            <option value=""><?php _e('-- Chọn --', 'aratavietnam'); ?></option>
                                            <option value="male" <?php selected($user_meta['gender'], 'male'); ?>><?php _e('Nam', 'aratavietnam'); ?></option>
                                            <option value="female" <?php selected($user_meta['gender'], 'female'); ?>><?php _e('Nữ', 'aratavietnam'); ?></option>
                                            <option value="other" <?php selected($user_meta['gender'], 'other'); ?>><?php _e('Khác', 'aratavietnam'); ?></option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Công ty', 'aratavietnam'); ?></label>
                                        <input type="text" name="company" value="<?php echo esc_attr($user_meta['company']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Chức vụ', 'aratavietnam'); ?></label>
                                        <input type="text" name="position" value="<?php echo esc_attr($user_meta['position']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Giới thiệu bản thân', 'aratavietnam'); ?></label>
                                        <textarea name="bio" rows="4" 
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                  placeholder="<?php _e('Viết vài dòng về bản thân bạn...', 'aratavietnam'); ?>"><?php echo esc_textarea($user_meta['bio']); ?></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Website', 'aratavietnam'); ?></label>
                                        <input type="url" name="website" value="<?php echo esc_attr($user_meta['website']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="https://">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Sở thích', 'aratavietnam'); ?></label>
                                        <input type="text" name="interests" value="<?php echo esc_attr($user_meta['interests']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="<?php _e('Ví dụ: Đọc sách, Du lịch, Nhiếp ảnh', 'aratavietnam'); ?>">
                                    </div>
                                </div>

                                <!-- Social Links -->
                                <div class="pt-6 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4"><?php _e('Mạng xã hội', 'aratavietnam'); ?></h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i data-lucide="facebook" class="w-4 h-4 inline mr-1"></i>
                                                <?php _e('Facebook', 'aratavietnam'); ?>
                                            </label>
                                            <input type="url" name="facebook" value="<?php echo esc_attr($user_meta['facebook']); ?>" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   placeholder="https://facebook.com/">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i data-lucide="linkedin" class="w-4 h-4 inline mr-1"></i>
                                                <?php _e('LinkedIn', 'aratavietnam'); ?>
                                            </label>
                                            <input type="url" name="linkedin" value="<?php echo esc_attr($user_meta['linkedin']); ?>" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   placeholder="https://linkedin.com/in/">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-4 pt-6">
                                    <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        <?php _e('Hủy', 'aratavietnam'); ?>
                                    </button>
                                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                        <?php _e('Lưu thay đổi', 'aratavietnam'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab Content -->
                        <div id="security-tab" class="account-tab-content p-6 hidden">
                            <form id="account-security-form" class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4"><?php _e('Đổi mật khẩu', 'aratavietnam'); ?></h3>
                                    <div class="space-y-4 max-w-md">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Mật khẩu hiện tại', 'aratavietnam'); ?></label>
                                            <input type="password" name="current_password" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Mật khẩu mới', 'aratavietnam'); ?></label>
                                            <input type="password" name="new_password" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   minlength="8" required>
                                            <p class="text-sm text-gray-500 mt-1"><?php _e('Tối thiểu 8 ký tự', 'aratavietnam'); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Xác nhận mật khẩu mới', 'aratavietnam'); ?></label>
                                            <input type="password" name="confirm_password" 
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                                   minlength="8" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-4 pt-6">
                                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('arata_account_nonce'); ?>">
                                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                        <i data-lucide="shield-check" class="w-4 h-4 inline mr-2"></i>
                                        <?php _e('Cập nhật bảo mật', 'aratavietnam'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Notifications Tab Content -->
                        <div id="notifications-tab" class="account-tab-content p-6 hidden">
                            <form id="account-notifications-form" class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold mb-4"><?php _e('Cài đặt thông báo', 'aratavietnam'); ?></h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div>
                                                <h4 class="font-medium"><?php _e('Thông báo email', 'aratavietnam'); ?></h4>
                                                <p class="text-sm text-gray-600"><?php _e('Nhận thông báo quan trọng qua email', 'aratavietnam'); ?></p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="email_notifications" class="sr-only peer" checked>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div>
                                                <h4 class="font-medium"><?php _e('Thông báo tin tức', 'aratavietnam'); ?></h4>
                                                <p class="text-sm text-gray-600"><?php _e('Nhận thông báo về bài viết mới', 'aratavietnam'); ?></p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="news_notifications" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div>
                                                <h4 class="font-medium"><?php _e('Thông báo khuyến mãi', 'aratavietnam'); ?></h4>
                                                <p class="text-sm text-gray-600"><?php _e('Nhận thông báo về chương trình khuyến mãi', 'aratavietnam'); ?></p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="promo_notifications" class="sr-only peer" checked>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-4 pt-6">
                                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('arata_account_nonce'); ?>">
                                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                        <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                        <?php _e('Lưu cài đặt', 'aratavietnam'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Activity Summary -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4"><?php _e('Hoạt động gần đây', 'aratavietnam'); ?></h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600"><?php _e('Đăng nhập gần nhất', 'aratavietnam'); ?></span>
                                <span class="text-sm text-gray-500">
                                    <?php 
                                    if ($user_meta['last_login']) {
                                        echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($user_meta['last_login']));
                                    } else {
                                        _e('Chưa có dữ liệu', 'aratavietnam');
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600"><?php _e('Số bài viết đã xem', 'aratavietnam'); ?></span>
                                <span class="text-sm text-gray-500"><?php echo get_user_meta($user_id, 'arata_posts_viewed', true) ?: 0; ?></span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-gray-600"><?php _e('Sản phẩm đã yêu thích', 'aratavietnam'); ?></span>
                                <span class="text-sm text-gray-500"><?php echo get_user_meta($user_id, 'arata_favorites_count', true) ?: 0; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4"><?php _e('Thao tác nhanh', 'aratavietnam'); ?></h3>
                        <div class="space-y-3">
                            <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" 
                               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-lucide="shopping-bag" class="w-5 h-5 mr-3"></i>
                                <?php _e('Đơn hàng của tôi', 'aratavietnam'); ?>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-lucide="heart" class="w-5 h-5 mr-3"></i>
                                <?php _e('Sản phẩm yêu thích', 'aratavietnam'); ?>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-lucide="download" class="w-5 h-5 mr-3"></i>
                                <?php _e('Tải xuống', 'aratavietnam'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Account Stats -->
                    <div class="bg-gradient-to-br from-primary to-secondary text-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4"><?php _e('Thống kê tài khoản', 'aratavietnam'); ?></h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold"><?php echo get_user_meta($user_id, 'arata_orders_count', true) ?: 0; ?></div>
                                <div class="text-sm opacity-90"><?php _e('Đơn hàng', 'aratavietnam'); ?></div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold"><?php echo get_user_meta($user_id, 'arata_reviews_count', true) ?: 0; ?></div>
                                <div class="text-sm opacity-90"><?php _e('Đánh giá', 'aratavietnam'); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4"><?php _e('Hỗ trợ', 'aratavietnam'); ?></h3>
                        <div class="space-y-3">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('lien-he'))); ?>" 
                               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-lucide="help-circle" class="w-5 h-5 mr-3"></i>
                                <?php _e('Trung tâm hỗ trợ', 'aratavietnam'); ?>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                                <i data-lucide="message-circle" class="w-5 h-5 mr-3"></i>
                                <?php _e('Liên hệ với chúng tôi', 'aratavietnam'); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="bg-white rounded-lg shadow-md p-6 border border-red-200">
                        <h3 class="text-lg font-semibold mb-4 text-red-600"><?php _e('Vùng nguy hiểm', 'aratavietnam'); ?></h3>
                        <div class="space-y-3">
                            <button class="w-full flex items-center justify-between px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <span class="flex items-center">
                                    <i data-lucide="download" class="w-5 h-5 mr-3"></i>
                                    <?php _e('Tải dữ liệu của tôi', 'aratavietnam'); ?>
                                </span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                            <button class="w-full flex items-center justify-between px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <span class="flex items-center">
                                    <i data-lucide="user-x" class="w-5 h-5 mr-3"></i>
                                    <?php _e('Vô hiệu hóa tài khoản', 'aratavietnam'); ?>
                                </span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                            <button class="w-full flex items-center justify-between px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <span class="flex items-center">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i>
                                    <?php _e('Xóa tài khoản', 'aratavietnam'); ?>
                                </span>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages Container -->
    <div id="account-messages" class="fixed top-4 right-4 z-50 space-y-2"></div>
    <?php
    return ob_get_clean();
}