<?php
/**
 * Authentication Handler for Arata Vietnam Theme
 * Handles login, register, and forgot password functionality
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) {
    exit;
}

class Arata_Auth_Handler {

    public function __construct() {
        add_action('wp_ajax_arata_user_login', array($this, 'handle_login'));
        add_action('wp_ajax_nopriv_arata_user_login', array($this, 'handle_login'));

        add_action('wp_ajax_arata_user_register', array($this, 'handle_register'));
        add_action('wp_ajax_nopriv_arata_user_register', array($this, 'handle_register'));

        add_action('wp_ajax_arata_forgot_password', array($this, 'handle_forgot_password'));
        add_action('wp_ajax_nopriv_arata_forgot_password', array($this, 'handle_forgot_password'));

        // Use a later priority (e.g., 99) to ensure the main theme script is already enqueued
        add_action('wp_footer', array($this, 'print_auth_data_script'));
    }

    /**
     * Print authentication data directly into the footer.
     * This is a more reliable method than wp_localize_script for timing issues.
     */
    public function print_auth_data_script() {
        $auth_data = array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('arata_auth_nonce'),
            'isLoggedIn' => is_user_logged_in(),
            'messages' => array(
                'requiredField' => __('Trường này là bắt buộc.', 'aratavietnam'),
                'invalidEmail' => __('Email không hợp lệ.', 'aratavietnam'),
                'passwordMismatch' => __('Mật khẩu xác nhận không khớp.', 'aratavietnam'),
                'weakPassword' => __('Mật khẩu phải có ít nhất 8 ký tự.', 'aratavietnam')
            )
        );
        ?>
        <script id="arata-auth-data" type="application/json">
            <?php echo wp_json_encode($auth_data); ?>
        </script>
        <?php
    }

    /**
     * Handle user login
     */
    public function handle_login() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'arata_auth_nonce')) {
            wp_send_json_error(array('message' => 'Nonce verification failed.'));
        }

        $username = sanitize_text_field($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? true : false;

        // Validate input
        if (empty($username) || empty($password)) {
            wp_send_json_error(array('message' => 'Vui lòng nhập đầy đủ thông tin.'));
        }

        // Attempt login
        $credentials = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember
        );

        $user = wp_signon($credentials, false);

        if (is_wp_error($user)) {
            wp_send_json_error(array('message' => $user->get_error_message()));
        }

        // Login successful
        wp_send_json_success(array(
            'message' => 'Đăng nhập thành công!',
            'redirect' => home_url(),
            'user' => array(
                'id' => $user->ID,
                'display_name' => $user->display_name,
                'email' => $user->user_email
            )
        ));
    }

    /**
     * Handle user registration
     */
    public function handle_register() {
        // Check if registration is enabled
        if (!get_option('users_can_register')) {
            wp_send_json_error(array('message' => 'Đăng ký tài khoản hiện không được phép.'));
        }

        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'arata_auth_nonce')) {
            wp_send_json_error(array('message' => 'Nonce verification failed.'));
        }

        $username = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);

        // Validate input
        $errors = array();

        if (empty($username)) {
            $errors[] = 'Tên đăng nhập là bắt buộc.';
        } elseif (username_exists($username)) {
            $errors[] = 'Tên đăng nhập đã tồn tại.';
        }

        if (empty($email)) {
            $errors[] = 'Email là bắt buộc.';
        } elseif (!is_email($email)) {
            $errors[] = 'Email không hợp lệ.';
        } elseif (email_exists($email)) {
            $errors[] = 'Email đã được sử dụng.';
        }

        if (empty($password)) {
            $errors[] = 'Mật khẩu là bắt buộc.';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Mật khẩu phải có ít nhất 8 ký tự.';
        }

        if ($password !== $confirm_password) {
            $errors[] = 'Mật khẩu xác nhận không khớp.';
        }

        if (!empty($errors)) {
            wp_send_json_error(array('message' => implode(' ', $errors)));
        }

        // Create user
        $user_data = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass'  => $password,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'display_name' => trim($first_name . ' ' . $last_name)
        );

        $user_id = wp_insert_user($user_data);

        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }

        // Send notification emails
        wp_new_user_notification($user_id, null, 'both');

        // Auto login after registration
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

        wp_send_json_success(array(
            'message' => 'Đăng ký thành công! Chào mừng bạn đến với Arata Vietnam.',
            'redirect' => home_url(),
            'user' => array(
                'id' => $user_id,
                'display_name' => get_user_meta($user_id, 'display_name', true),
                'email' => $email
            )
        ));
    }

    /**
     * Handle forgot password
     */
    public function handle_forgot_password() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'arata_auth_nonce')) {
            wp_send_json_error(array('message' => 'Nonce verification failed.'));
        }

        $user_login = sanitize_text_field($_POST['user_login']);

        if (empty($user_login)) {
            wp_send_json_error(array('message' => 'Vui lòng nhập email hoặc tên đăng nhập.'));
        }

        // Check if user exists
        if (strpos($user_login, '@')) {
            $user = get_user_by('email', $user_login);
        } else {
            $user = get_user_by('login', $user_login);
        }

        if (!$user) {
            wp_send_json_error(array('message' => 'Không tìm thấy tài khoản với thông tin này.'));
        }

        // Generate reset key
        $key = get_password_reset_key($user);

        if (is_wp_error($key)) {
            wp_send_json_error(array('message' => $key->get_error_message()));
        }

        // Send reset email
        $message = $this->get_reset_password_message($user->user_login, $key);

        $sent = wp_mail(
            $user->user_email,
            'Khôi phục mật khẩu - Arata Vietnam',
            $message,
            array('Content-Type: text/html; charset=UTF-8')
        );

        if (!$sent) {
            wp_send_json_error(array('message' => 'Không thể gửi email. Vui lòng thử lại sau.'));
        }

        wp_send_json_success(array(
            'message' => 'Email khôi phục mật khẩu đã được gửi! Vui lòng kiểm tra hộp thư của bạn.'
        ));
    }

    /**
     * Get reset password email message
     */
    private function get_reset_password_message($user_login, $key) {
        $reset_url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');

        $message = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9;">
            <div style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="color: #333; margin-bottom: 20px;">Khôi phục mật khẩu</h2>
                <p style="color: #666; line-height: 1.6;">Xin chào,</p>
                <p style="color: #666; line-height: 1.6;">Bạn đã yêu cầu khôi phục mật khẩu cho tài khoản <strong>' . $user_login . '</strong> tại Arata Vietnam.</p>
                <p style="color: #666; line-height: 1.6;">Nhấn vào nút bên dưới để tạo mật khẩu mới:</p>
                <div style="text-align: center; margin: 30px 0;">
                    <a href="' . $reset_url . '" style="background-color: #007cba; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">Đặt lại mật khẩu</a>
                </div>
                <p style="color: #666; line-height: 1.6; font-size: 14px;">Nếu bạn không yêu cầu khôi phục mật khẩu, vui lòng bỏ qua email này.</p>
                <p style="color: #666; line-height: 1.6; font-size: 14px;">Link này sẽ hết hiệu lực sau 24 giờ.</p>
                <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
                <p style="color: #999; font-size: 12px; text-align: center;">© ' . date('Y') . ' Arata Vietnam. All rights reserved.</p>
            </div>
        </div>';

        return $message;
    }
}

// Initialize the auth handler
new Arata_Auth_Handler();
