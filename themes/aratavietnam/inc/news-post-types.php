<?php
/**
 * Custom Post Types for News Section
 * - Promotions (Khuyến mãi)
 * - Job Postings (Tuyển dụng)
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Promotions Post Type
 */
add_action('init', function () {
    $labels = [
        'name' => __('Khuyến mãi', 'aratavietnam'),
        'singular_name' => __('Chương trình khuyến mãi', 'aratavietnam'),
        'menu_name' => __('Khuyến mãi', 'aratavietnam'),
        'add_new' => __('Thêm mới', 'aratavietnam'),
        'add_new_item' => __('Thêm chương trình khuyến mãi', 'aratavietnam'),
        'edit_item' => __('Sửa chương trình khuyến mãi', 'aratavietnam'),
        'new_item' => __('Chương trình khuyến mãi mới', 'aratavietnam'),
        'view_item' => __('Xem chương trình khuyến mãi', 'aratavietnam'),
        'search_items' => __('Tìm kiếm khuyến mãi', 'aratavietnam'),
        'not_found' => __('Không tìm thấy chương trình khuyến mãi nào', 'aratavietnam'),
        'not_found_in_trash' => __('Không có chương trình khuyến mãi nào trong thùng rác', 'aratavietnam'),
    ];

    register_post_type('promotion', [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,   
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-megaphone',
        'menu_position' => 25,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'khuyen-mai'],
        'show_in_rest' => true,
        'capability_type' => 'post',
    ]);
});

/**
 * Register Job Postings Post Type
 */
add_action('init', function () {
    $labels = [
        'name' => __('Tuyển dụng', 'aratavietnam'),
        'singular_name' => __('Vị trí tuyển dụng', 'aratavietnam'),
        'menu_name' => __('Tuyển dụng', 'aratavietnam'),
        'add_new' => __('Thêm mới', 'aratavietnam'),
        'add_new_item' => __('Thêm vị trí tuyển dụng', 'aratavietnam'),
        'edit_item' => __('Sửa vị trí tuyển dụng', 'aratavietnam'),
        'new_item' => __('Vị trí tuyển dụng mới', 'aratavietnam'),
        'view_item' => __('Xem vị trí tuyển dụng', 'aratavietnam'),
        'search_items' => __('Tìm kiếm tuyển dụng', 'aratavietnam'),
        'not_found' => __('Không tìm thấy vị trí tuyển dụng nào', 'aratavietnam'),
        'not_found_in_trash' => __('Không có vị trí tuyển dụng nào trong thùng rác', 'aratavietnam'),
    ];

    register_post_type('job_posting', [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-businessman',
        'menu_position' => 26,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'tuyen-dung'],
        'show_in_rest' => true,
        'capability_type' => 'post',
    ]);
});

/**
 * Register Newsletter Subscriptions Post Type (for promotion form)
 */
add_action('init', function () {
    $labels = [
        'name' => __('Đăng ký khuyến mãi', 'aratavietnam'),
        'singular_name' => __('Đăng ký khuyến mãi', 'aratavietnam'),
        'menu_name' => __('Đăng ký KM', 'aratavietnam'),
        'search_items' => __('Tìm kiếm đăng ký', 'aratavietnam'),
    ];

    register_post_type('newsletter_sub', [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => ['title'],
        'capability_type' => 'post',
        'has_archive' => false,
        'show_in_rest' => false,
    ]);
});

/**
 * Register Job Applications Post Type (for career form)
 */
add_action('init', function () {
    $labels = [
        'name' => __('Hồ sơ ứng tuyển', 'aratavietnam'),
        'singular_name' => __('Hồ sơ ứng tuyển', 'aratavietnam'),
        'menu_name' => __('Hồ sơ ứng tuyển', 'aratavietnam'),
        'search_items' => __('Tìm kiếm hồ sơ', 'aratavietnam'),
    ];

    register_post_type('job_application', [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title'],
        'capability_type' => 'post',
        'has_archive' => false,
        'show_in_rest' => false,
    ]);
});

/**
 * Customize admin columns for Promotions
 */
add_filter('manage_promotion_posts_columns', function ($columns) {
    $new = [];
    $new['cb'] = $columns['cb'] ?? '';
    $new['title'] = __('Tiêu đề', 'aratavietnam');
    $new['promotion_type'] = __('Loại khuyến mãi', 'aratavietnam');
    $new['start_date'] = __('Ngày bắt đầu', 'aratavietnam');
    $new['end_date'] = __('Ngày kết thúc', 'aratavietnam');
    $new['date'] = __('Ngày tạo', 'aratavietnam');
    return $new;
});

add_action('manage_promotion_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'promotion_type':
            $type = get_post_meta($post_id, 'arata_promotion_type', true);
            echo esc_html($type ?: 'Chưa xác định');
            break;
        case 'start_date':
            $date = get_post_meta($post_id, 'arata_promotion_start_date', true);
            echo esc_html($date ? date('d/m/Y', strtotime($date)) : 'Chưa xác định');
            break;
        case 'end_date':
            $date = get_post_meta($post_id, 'arata_promotion_end_date', true);
            echo esc_html($date ? date('d/m/Y', strtotime($date)) : 'Chưa xác định');
            break;
    }
}, 10, 2);

/**
 * Customize admin columns for Job Postings
 */
add_filter('manage_job_posting_posts_columns', function ($columns) {
    $new = [];
    $new['cb'] = $columns['cb'] ?? '';
    $new['title'] = __('Vị trí', 'aratavietnam');
    $new['department'] = __('Phòng ban', 'aratavietnam');
    $new['location'] = __('Địa điểm', 'aratavietnam');
    $new['deadline'] = __('Hạn nộp', 'aratavietnam');
    $new['date'] = __('Ngày đăng', 'aratavietnam');
    return $new;
});

add_action('manage_job_posting_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'department':
            $dept = get_post_meta($post_id, 'arata_job_department', true);
            echo esc_html($dept ?: 'Chưa xác định');
            break;
        case 'location':
            $location = get_post_meta($post_id, 'arata_job_location', true);
            echo esc_html($location ?: 'Chưa xác định');
            break;
        case 'deadline':
            $deadline = get_post_meta($post_id, 'arata_job_deadline', true);
            echo esc_html($deadline ? date('d/m/Y', strtotime($deadline)) : 'Chưa xác định');
            break;
    }
}, 10, 2);

/**
 * Add meta boxes for Newsletter Subscriptions
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'newsletter_details',
        __('Chi tiết đăng ký', 'aratavietnam'),
        function ($post) {
            $name = get_post_meta($post->ID, 'arata_subscriber_name', true);
            $email = get_post_meta($post->ID, 'arata_subscriber_email', true);
            $phone = get_post_meta($post->ID, 'arata_subscriber_phone', true);
            $interests = get_post_meta($post->ID, 'arata_subscriber_interests', true);
            ?>
            <table class="form-table">
                <tr><th><?php _e('Họ tên', 'aratavietnam'); ?></th><td><?php echo esc_html($name); ?></td></tr>
                <tr><th><?php _e('Email', 'aratavietnam'); ?></th><td><?php echo esc_html($email); ?></td></tr>
                <tr><th><?php _e('Điện thoại', 'aratavietnam'); ?></th><td><?php echo esc_html($phone); ?></td></tr>
                <tr><th><?php _e('Sở thích', 'aratavietnam'); ?></th><td><?php echo esc_html($interests); ?></td></tr>
            </table>
            <?php
        },
        'newsletter_sub',
        'normal',
        'high'
    );
});

/**
 * Add meta boxes for Job Applications
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'job_application_details',
        __('Chi tiết ứng tuyển', 'aratavietnam'),
        function ($post) {
            $name = get_post_meta($post->ID, 'arata_applicant_name', true);
            $email = get_post_meta($post->ID, 'arata_applicant_email', true);
            $phone = get_post_meta($post->ID, 'arata_applicant_phone', true);
            $position = get_post_meta($post->ID, 'arata_applicant_position', true);
            $cv_url = get_post_meta($post->ID, 'arata_applicant_cv', true);
            $cover_letter = get_post_meta($post->ID, 'arata_applicant_cover_letter', true);
            ?>
            <table class="form-table">
                <tr><th><?php _e('Họ tên', 'aratavietnam'); ?></th><td><?php echo esc_html($name); ?></td></tr>
                <tr><th><?php _e('Email', 'aratavietnam'); ?></th><td><?php echo esc_html($email); ?></td></tr>
                <tr><th><?php _e('Điện thoại', 'aratavietnam'); ?></th><td><?php echo esc_html($phone); ?></td></tr>
                <tr><th><?php _e('Vị trí ứng tuyển', 'aratavietnam'); ?></th><td><?php echo esc_html($position); ?></td></tr>
                <tr><th><?php _e('CV', 'aratavietnam'); ?></th><td>
                    <?php if ($cv_url): ?>
                        <a href="<?php echo esc_url($cv_url); ?>" target="_blank">Xem CV</a>
                    <?php else: ?>
                        Chưa có CV
                    <?php endif; ?>
                </td></tr>
                <tr><th><?php _e('Thư xin việc', 'aratavietnam'); ?></th><td><pre style="white-space:pre-wrap;word-break:break-word;"><?php echo esc_html($cover_letter); ?></pre></td></tr>
            </table>
            <?php
        },
        'job_application',
        'normal',
        'high'
    );
});
