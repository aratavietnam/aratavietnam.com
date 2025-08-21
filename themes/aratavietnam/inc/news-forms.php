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
 * Handle Newsletter Subscription
 */
function arata_handle_newsletter_submission() {
    if (!isset($_POST['arata_newsletter_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_newsletter_nonce']), 'arata_newsletter_submit')) {
        wp_die(__('Security check failed.', 'aratavietnam'));
    }

    $referer = isset($_POST['_wp_http_referer']) ? esc_url_raw(wp_unslash($_POST['_wp_http_referer'])) : home_url('/');

    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $interests = isset($_POST['interests']) ? array_map('sanitize_text_field', wp_unslash($_POST['interests'])) : [];

    if (empty($name) || empty($email)) {
        wp_safe_redirect(add_query_arg('newsletter', 'error', $referer));
        exit;
    }

    // Check if email already exists
    $existing = get_posts([
        'post_type' => 'newsletter_sub',
        'meta_query' => [
            [
                'key' => 'arata_subscriber_email',
                'value' => $email,
                'compare' => '='
            ]
        ],
        'posts_per_page' => 1
    ]);

    if (!empty($existing)) {
        wp_safe_redirect(add_query_arg('newsletter', 'exists', $referer));
        exit;
    }

    $post_id = wp_insert_post([
        'post_type' => 'newsletter_sub',
        'post_status' => 'publish',
        'post_title' => sprintf(__('Newsletter subscription: %s (%s)', 'aratavietnam'), $name, $email),
    ]);

    if (is_wp_error($post_id) || !$post_id) {
        wp_safe_redirect(add_query_arg('newsletter', 'error', $referer));
        exit;
    }

    update_post_meta($post_id, 'arata_subscriber_name', $name);
    update_post_meta($post_id, 'arata_subscriber_email', $email);
    update_post_meta($post_id, 'arata_subscriber_phone', $phone);
    update_post_meta($post_id, 'arata_subscriber_interests', implode(', ', $interests));

    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('New newsletter subscription: %s', 'aratavietnam'), $name);
    $body = sprintf("Tên: %s\nEmail: %s\nĐiện thoại: %s\nSở thích: %s", $name, $email, $phone, implode(', ', $interests));
    wp_mail($admin_email, $subject, $body);

    wp_safe_redirect(add_query_arg('newsletter', 'success', $referer));
    exit;
}

add_action('admin_post_nopriv_arata_newsletter_submit', 'arata_handle_newsletter_submission');
add_action('admin_post_arata_newsletter_submit', 'arata_handle_newsletter_submission');

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
    $position = isset($_POST['position']) ? sanitize_text_field(wp_unslash($_POST['position'])) : '';
    $cover_letter = isset($_POST['cover_letter']) ? wp_kses_post(wp_unslash($_POST['cover_letter'])) : '';

    if (empty($name) || empty($email) || empty($phone) || empty($position)) {
        wp_safe_redirect(add_query_arg('job_application', 'error', $referer));
        exit;
    }

    $post_id = wp_insert_post([
        'post_type' => 'job_application',
        'post_status' => 'publish',
        'post_title' => sprintf(__('Job application: %s - %s', 'aratavietnam'), $name, $position),
    ]);

    if (is_wp_error($post_id) || !$post_id) {
        wp_safe_redirect(add_query_arg('job_application', 'error', $referer));
        exit;
    }

    update_post_meta($post_id, 'arata_applicant_name', $name);
    update_post_meta($post_id, 'arata_applicant_email', $email);
    update_post_meta($post_id, 'arata_applicant_phone', $phone);
    update_post_meta($post_id, 'arata_applicant_position', $position);
    update_post_meta($post_id, 'arata_applicant_cover_letter', $cover_letter);

    // Handle CV upload
    if (!empty($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $upload = wp_handle_upload($_FILES['cv'], ['test_form' => false]);
        if (!isset($upload['error'])) {
            update_post_meta($post_id, 'arata_applicant_cv', $upload['url']);
        }
    }

    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('New job application: %s - %s', 'aratavietnam'), $name, $position);
    $body = sprintf("Tên: %s\nEmail: %s\nĐiện thoại: %s\nVị trí: %s\n\nThư xin việc:\n%s", $name, $email, $phone, $position, wp_strip_all_tags($cover_letter));
    wp_mail($admin_email, $subject, $body);

    wp_safe_redirect(add_query_arg('job_application', 'success', $referer));
    exit;
}

add_action('admin_post_nopriv_arata_job_application_submit', 'arata_handle_job_application');
add_action('admin_post_arata_job_application_submit', 'arata_handle_job_application');

/**
 * Customize admin columns for Newsletter Subscriptions
 */
add_filter('manage_newsletter_sub_posts_columns', function ($columns) {
    $new = [];
    $new['cb'] = $columns['cb'] ?? '';
    $new['title'] = __('Tên', 'aratavietnam');
    $new['email'] = __('Email', 'aratavietnam');
    $new['phone'] = __('Điện thoại', 'aratavietnam');
    $new['interests'] = __('Sở thích', 'aratavietnam');
    $new['date'] = __('Ngày đăng ký', 'aratavietnam');
    return $new;
});

add_action('manage_newsletter_sub_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'email':
            $email = get_post_meta($post_id, 'arata_subscriber_email', true);
            echo esc_html($email);
            break;
        case 'phone':
            $phone = get_post_meta($post_id, 'arata_subscriber_phone', true);
            echo esc_html($phone);
            break;
        case 'interests':
            $interests = get_post_meta($post_id, 'arata_subscriber_interests', true);
            echo esc_html($interests);
            break;
    }
}, 10, 2);

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
