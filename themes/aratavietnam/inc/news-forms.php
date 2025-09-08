<?php
/**
 * Form Processing for News Section
 * - Newsletter subscription
 * - Job applications
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Job Application Submission
 */
function arata_handle_job_application() {
    if (!isset($_POST['arata_job_application_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_job_application_nonce']), 'arata_job_application_submit')) {
        wp_die(__('Security check failed.', 'aratavietnam'));
    }

    $referer = isset($_POST['_wp_http_referer']) ? esc_url_raw(wp_unslash($_POST['_wp_http_referer'])) : home_url('/');

    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $job_id = isset($_POST['job_id']) ? absint($_POST['job_id']) : 0;
    $cover_letter = isset($_POST['cover_letter']) ? wp_kses_post(wp_unslash($_POST['cover_letter'])) : '';

    // Check required fields including CV file
    if (empty($name) || empty($email) || empty($phone) || empty($job_id) || empty($_FILES['cv']['name'])) {
        wp_safe_redirect(add_query_arg('application_error', '1', $referer));
        exit;
    }

    // Get position from job posting
    $position = get_the_title($job_id);

    $post_id = wp_insert_post([
        'post_type' => 'job_application',
        'post_status' => 'publish',
        'post_title' => sprintf(__('Job application: %s - %s', 'aratavietnam'), $name, $position),
    ]);

    if (is_wp_error($post_id) || !$post_id) {
        wp_safe_redirect(add_query_arg('application_error', '1', $referer));
        exit;
    }

    update_post_meta($post_id, 'arata_applicant_name', $name);
    update_post_meta($post_id, 'arata_applicant_email', $email);
    update_post_meta($post_id, 'arata_applicant_phone', $phone);
    update_post_meta($post_id, 'arata_applicant_position', $position);
    update_post_meta($post_id, 'arata_applicant_cover_letter', $cover_letter);

    // Handle CV upload
    if (!empty($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $upload = wp_handle_upload($_FILES['cv'], [
            'test_form' => false,
            'mimes' => [
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            'test_size' => 5 * 1024 * 1024 // 5MB limit
        ]);
        
        if (!isset($upload['error'])) {
            update_post_meta($post_id, 'arata_applicant_cv', $upload['url']);
        }
    }

    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('New job application: %s - %s', 'aratavietnam'), $name, $position);
    $body = sprintf(
        "Tên: %s\nEmail: %s\nĐiện thoại: %s\nVị trí: %s\n\nThư xin việc:\n%s\n\nXem chi tiết: %s",
        $name,
        $email,
        $phone,
        $position,
        wp_strip_all_tags($cover_letter),
        get_edit_post_link($post_id)
    );
    
    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    wp_mail($admin_email, $subject, $body, $headers);

    // Send confirmation email to applicant
    $applicant_subject = sprintf(__('Cảm ơn bạn đã ứng tuyển tại Arata Vietnam', 'aratavietnam'));
    $applicant_body = sprintf(
        "Chào %s,\n\nCảm ơn bạn đã ứng tuyển vị trí %s tại Arata Vietnam.\n\nChúng tôi đã nhận được hồ sơ của bạn và sẽ xem xét trong thời gian sớm nhất. Nếu hồ sơ của bạn phù hợp, chúng tôi sẽ liên hệ với bạn để sắp xếp phỏng vấn.\n\nTrân trọng,\nĐội ngũ Tuyển dụng\nArata Vietnam",
        $name,
        $position
    );
    wp_mail($email, $applicant_subject, $applicant_body, $headers);

    wp_safe_redirect(add_query_arg('application_success', '1', $referer));
    exit;
}

add_action('admin_post_nopriv_arata_job_application_submit', 'arata_handle_job_application');
add_action('admin_post_arata_job_application_submit', 'arata_handle_job_application');

/**
 * Handle Promotion Signup Submission
 */
function arata_handle_promotion_signup_submission() {
    if (!isset($_POST['arata_promotion_signup_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_promotion_signup_nonce']), 'arata_promotion_signup_submit')) {
        wp_die(__('Security check failed.', 'aratavietnam'));
    }

    $referer = isset($_POST['_wp_http_referer']) ? esc_url_raw(wp_unslash($_POST['_wp_http_referer'])) : home_url('/');

    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $promotion_id = isset($_POST['promotion_id']) ? absint($_POST['promotion_id']) : 0;
    $promotion_code = isset($_POST['promotion_code']) ? sanitize_text_field(wp_unslash($_POST['promotion_code'])) : '';

    if (empty($name) || empty($email) || empty($promotion_id)) {
        wp_safe_redirect(add_query_arg('promotion_signup', 'error', $referer));
        exit;
    }

    // Check if email already exists for this promotion
    $existing = get_posts([
        'post_type' => 'promotion_signup',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'arata_signup_email',
                'value' => $email,
                'compare' => '='
            ],
            [
                'key' => 'arata_signup_promotion_id',
                'value' => $promotion_id,
                'compare' => '='
            ]
        ],
        'posts_per_page' => 1
    ]);

    if (!empty($existing)) {
        wp_safe_redirect(add_query_arg('promotion_signup', 'exists', $referer));
        exit;
    }

    $post_id = wp_insert_post([
        'post_type' => 'promotion_signup',
        'post_status' => 'publish',
        'post_title' => sprintf(__('Promotion signup: %s - %s', 'aratavietnam'), $name, $email),
    ]);

    if (is_wp_error($post_id) || !$post_id) {
        wp_safe_redirect(add_query_arg('promotion_signup', 'error', $referer));
        exit;
    }

    update_post_meta($post_id, 'arata_signup_name', $name);
    update_post_meta($post_id, 'arata_signup_email', $email);
    update_post_meta($post_id, 'arata_signup_phone', $phone);
    update_post_meta($post_id, 'arata_signup_promotion_id', $promotion_id);
    update_post_meta($post_id, 'arata_signup_promotion_code', $promotion_code);

    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $promotion_title = get_the_title($promotion_id);
    $subject = sprintf(__('New promotion signup: %s', 'aratavietnam'), $name);
    $body = sprintf(
        "Tên: %s\nEmail: %s\nĐiện thoại: %s\nKhuyến mãi: %s\nMã khuyến mãi: %s\n\nXem chi tiết: %s",
        $name,
        $email,
        $phone,
        $promotion_title,
        $promotion_code,
        get_edit_post_link($post_id)
    );
    
    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    wp_mail($admin_email, $subject, $body, $headers);

    // Send confirmation email to user
    $user_subject = sprintf(__('Đăng ký nhận khuyến mãi thành công!', 'aratavietnam'));
    $user_body = sprintf(
        "Chào %s,\n\nCảm ơn bạn đã đăng ký nhận khuyến mãi \"%s\" từ Arata Vietnam.\n\nChúng tôi đã ghi nhận thông tin của bạn và sẽ gửi các thông tin cập nhật về chương trình khuyến mãi này đến email của bạn.\n\nMã khuyến mãi của bạn: %s\n\nTrân trọng,\nĐội ngũ Arata Vietnam",
        $name,
        $promotion_title,
        $promotion_code
    );
    wp_mail($email, $user_subject, $user_body, $headers);

    wp_safe_redirect(add_query_arg('promotion_signup', 'success', $referer));
    exit;
}

add_action('admin_post_nopriv_arata_promotion_signup_submit', 'arata_handle_promotion_signup_submission');
add_action('admin_post_arata_promotion_signup_submit', 'arata_handle_promotion_signup_submission');

/**
 * Customize admin columns for Job Applications
 */
add_filter('manage_job_application_posts_columns', function ($columns) {
    $new = [];
    $new['cb'] = $columns['cb'] ?? '';
    $new['title'] = __('Tên', 'aratavietnam');
    $new['email'] = __('Email', 'aratavietnam');
    $new['phone'] = __('Điện thoại', 'aratavietnam');
    $new['position'] = __('Vị trí', 'aratavietnam');
    $new['cv'] = __('CV', 'aratavietnam');
    $new['date'] = __('Ngày ứng tuyển', 'aratavietnam');
    return $new;
});

add_action('manage_job_application_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'email':
            $email = get_post_meta($post_id, 'arata_applicant_email', true);
            echo esc_html($email);
            break;
        case 'phone':
            $phone = get_post_meta($post_id, 'arata_applicant_phone', true);
            echo esc_html($phone);
            break;
        case 'position':
            $position = get_post_meta($post_id, 'arata_applicant_position', true);
            echo esc_html($position);
            break;
        case 'cv':
            $cv_url = get_post_meta($post_id, 'arata_applicant_cv', true);
            if ($cv_url) {
                echo '<a href="' . esc_url($cv_url) . '" target="_blank">Xem CV</a>';
            } else {
                echo 'Chưa có';
            }
            break;
    }
}, 10, 2);

/**
 * Customize admin columns for Promotion Signups
 */
add_filter('manage_promotion_signup_posts_columns', function ($columns) {
    $new = [];
    $new['cb'] = $columns['cb'] ?? '';
    $new['title'] = __('Tên', 'aratavietnam');
    $new['email'] = __('Email', 'aratavietnam');
    $new['phone'] = __('Điện thoại', 'aratavietnam');
    $new['promotion'] = __('Chương trình KM', 'aratavietnam');
    $new['code'] = __('Mã KM', 'aratavietnam');
    $new['date'] = __('Ngày đăng ký', 'aratavietnam');
    return $new;
});

add_action('manage_promotion_signup_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'email':
            $email = get_post_meta($post_id, 'arata_signup_email', true);
            echo esc_html($email);
            break;
        case 'phone':
            $phone = get_post_meta($post_id, 'arata_signup_phone', true);
            echo esc_html($phone);
            break;
        case 'promotion':
            $promotion_id = get_post_meta($post_id, 'arata_signup_promotion_id', true);
            if ($promotion_id) {
                $title = get_the_title($promotion_id);
                echo '<a href="' . get_edit_post_link($promotion_id) . '" target="_blank">' . esc_html($title) . '</a>';
            } else {
                echo 'Chưa xác định';
            }
            break;
        case 'code':
            $code = get_post_meta($post_id, 'arata_signup_promotion_code', true);
            echo esc_html($code ?: 'Chưa có');
            break;
    }
}, 10, 2);
