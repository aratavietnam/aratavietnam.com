<?php
/**
 * Meta Fields for News Post Types
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) { exit; }

/**
 * Add meta boxes for Promotions
 */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'arata_promotion_meta',
        __('Thông tin khuyến mãi', 'aratavietnam'),
        function($post) {
            $fields = [
                'arata_promotion_type' => __('Loại khuyến mãi', 'aratavietnam'),
                'arata_promotion_discount' => __('Mức giảm giá', 'aratavietnam'),
                'arata_promotion_code' => __('Mã khuyến mãi', 'aratavietnam'),
                'arata_promotion_start_date' => __('Ngày bắt đầu', 'aratavietnam'),
                'arata_promotion_end_date' => __('Ngày kết thúc', 'aratavietnam'),
                'arata_promotion_conditions' => __('Điều kiện áp dụng', 'aratavietnam'),
                'arata_promotion_products' => __('Sản phẩm áp dụng', 'aratavietnam'),
            ];

            wp_nonce_field('arata_promotion_meta_save', 'arata_promotion_meta_nonce');
            echo '<table class="form-table">';
            foreach ($fields as $key => $label) {
                $value = get_post_meta($post->ID, $key, true);
                echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
                
                if ($key === 'arata_promotion_type') {
                    $options = [
                        'percentage' => 'Giảm theo phần trăm',
                        'fixed' => 'Giảm số tiền cố định',
                        'buy_get' => 'Mua X tặng Y',
                        'free_shipping' => 'Miễn phí vận chuyển',
                        'bundle' => 'Combo sản phẩm'
                    ];
                    echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text">';
                    echo '<option value="">Chọn loại khuyến mãi</option>';
                    foreach ($options as $opt_value => $opt_label) {
                        echo '<option value="' . esc_attr($opt_value) . '"' . selected($value, $opt_value, false) . '>' . esc_html($opt_label) . '</option>';
                    }
                    echo '</select>';
                } elseif (in_array($key, ['arata_promotion_start_date', 'arata_promotion_end_date'])) {
                    echo '<input type="date" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
                } elseif (in_array($key, ['arata_promotion_conditions', 'arata_promotion_products'])) {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
                }
                echo '</td></tr>';
            }
            echo '</table>';
        },
        'promotion',
        'normal',
        'default'
    );
});

/**
 * Add meta boxes for Job Postings
 */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'arata_job_meta',
        __('Thông tin tuyển dụng', 'aratavietnam'),
        function($post) {
            $fields = [
                'arata_job_department' => __('Phòng ban', 'aratavietnam'),
                'arata_job_location' => __('Địa điểm làm việc', 'aratavietnam'),
                'arata_job_type' => __('Loại hình công việc', 'aratavietnam'),
                'arata_job_level' => __('Cấp bậc', 'aratavietnam'),
                'arata_job_salary' => __('Mức lương', 'aratavietnam'),
                'arata_job_deadline' => __('Hạn nộp hồ sơ', 'aratavietnam'),
                'arata_job_requirements' => __('Yêu cầu ứng viên', 'aratavietnam'),
                'arata_job_benefits' => __('Quyền lợi', 'aratavietnam'),
                'arata_job_contact' => __('Thông tin liên hệ', 'aratavietnam'),
            ];

            wp_nonce_field('arata_job_meta_save', 'arata_job_meta_nonce');
            echo '<table class="form-table">';
            foreach ($fields as $key => $label) {
                $value = get_post_meta($post->ID, $key, true);
                echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
                
                if ($key === 'arata_job_type') {
                    $options = [
                        'full_time' => 'Toàn thời gian',
                        'part_time' => 'Bán thời gian',
                        'contract' => 'Hợp đồng',
                        'internship' => 'Thực tập',
                        'freelance' => 'Freelance'
                    ];
                    echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text">';
                    echo '<option value="">Chọn loại hình</option>';
                    foreach ($options as $opt_value => $opt_label) {
                        echo '<option value="' . esc_attr($opt_value) . '"' . selected($value, $opt_value, false) . '>' . esc_html($opt_label) . '</option>';
                    }
                    echo '</select>';
                } elseif ($key === 'arata_job_level') {
                    $options = [
                        'intern' => 'Thực tập sinh',
                        'fresher' => 'Nhân viên mới',
                        'junior' => 'Nhân viên',
                        'senior' => 'Nhân viên cao cấp',
                        'lead' => 'Trưởng nhóm',
                        'manager' => 'Quản lý',
                        'director' => 'Giám đốc'
                    ];
                    echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text">';
                    echo '<option value="">Chọn cấp bậc</option>';
                    foreach ($options as $opt_value => $opt_label) {
                        echo '<option value="' . esc_attr($opt_value) . '"' . selected($value, $opt_value, false) . '>' . esc_html($opt_label) . '</option>';
                    }
                    echo '</select>';
                } elseif ($key === 'arata_job_deadline') {
                    echo '<input type="date" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
                } elseif (in_array($key, ['arata_job_requirements', 'arata_job_benefits', 'arata_job_contact'])) {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="4" class="large-text">' . esc_textarea($value) . '</textarea>';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
                }
                echo '</td></tr>';
            }
            echo '</table>';
        },
        'job_posting',
        'normal',
        'default'
    );
});

/**
 * Save meta for Promotions
 */
add_action('save_post_promotion', function($post_id) {
    if (!isset($_POST['arata_promotion_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_promotion_meta_nonce']), 'arata_promotion_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_post', $post_id)) { return; }

    $keys = [
        'arata_promotion_type',
        'arata_promotion_discount',
        'arata_promotion_code',
        'arata_promotion_start_date',
        'arata_promotion_end_date',
        'arata_promotion_conditions',
        'arata_promotion_products',
    ];
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $value = is_string($_POST[$key]) ? wp_kses_post(wp_unslash($_POST[$key])) : '';
            update_post_meta($post_id, $key, $value);
        } else {
            delete_post_meta($post_id, $key);
        }
    }
});

/**
 * Save meta for Job Postings
 */
add_action('save_post_job_posting', function($post_id) {
    if (!isset($_POST['arata_job_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_job_meta_nonce']), 'arata_job_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_post', $post_id)) { return; }

    $keys = [
        'arata_job_department',
        'arata_job_location',
        'arata_job_type',
        'arata_job_level',
        'arata_job_salary',
        'arata_job_deadline',
        'arata_job_requirements',
        'arata_job_benefits',
        'arata_job_contact',
    ];
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $value = is_string($_POST[$key]) ? wp_kses_post(wp_unslash($_POST[$key])) : '';
            update_post_meta($post_id, $key, $value);
        } else {
            delete_post_meta($post_id, $key);
        }
    }
});

/**
 * Add meta boxes for News pages
 */
add_action('add_meta_boxes', function() {
    add_meta_box(
        'arata_news_meta',
        __('Cài đặt trang Tin tức', 'aratavietnam'),
        function($post) {
            $template = get_post_meta($post->ID, '_wp_page_template', true);
            $news_templates = [
                'page-templates/news.php',
                'page-templates/promotions.php', 
                'page-templates/careers.php',
                'page-templates/blog.php'
            ];
            
            if (!in_array($template, $news_templates)) {
                echo '<p>' . esc_html__('Gán template Tin tức để sử dụng các cài đặt này.', 'aratavietnam') . '</p>';
                return;
            }

            $fields = [
                'arata_news_subtitle' => __('Phụ đề Hero', 'aratavietnam'),
                'arata_news_intro' => __('Mô tả ngắn', 'aratavietnam'),
                'arata_news_featured_text' => __('Văn bản nổi bật', 'aratavietnam'),
            ];

            wp_nonce_field('arata_news_meta_save', 'arata_news_meta_nonce');
            echo '<table class="form-table">';
            foreach ($fields as $key => $label) {
                $value = get_post_meta($post->ID, $key, true);
                echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
                if ($key === 'arata_news_intro') {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
                }
                echo '</td></tr>';
            }
            echo '</table>';
        },
        'page',
        'normal',
        'default'
    );
});

/**
 * Save meta for News pages
 */
add_action('save_post_page', function($post_id) {
    if (!isset($_POST['arata_news_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_news_meta_nonce']), 'arata_news_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_page', $post_id)) { return; }

    $keys = [
        'arata_news_subtitle',
        'arata_news_intro',
        'arata_news_featured_text',
    ];
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $value = is_string($_POST[$key]) ? wp_kses_post(wp_unslash($_POST[$key])) : '';
            update_post_meta($post_id, $key, $value);
        } else {
            delete_post_meta($post_id, $key);
        }
    }
});
