<?php
/**
 * Custom Post Types for Services Section
 * - Services
 * - Service Categories
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Services Post Type
 */
add_action('init', function () {
    $labels = [
        'name' => __('Dịch vụ', 'aratavietnam'),
        'singular_name' => __('Dịch vụ', 'aratavietnam'),
        'menu_name' => __('Dịch vụ', 'aratavietnam'),
        'add_new' => __('Thêm mới', 'aratavietnam'),
        'add_new_item' => __('Thêm dịch vụ mới', 'aratavietnam'),
        'edit_item' => __('Sửa dịch vụ', 'aratavietnam'),
        'new_item' => __('Dịch vụ mới', 'aratavietnam'),
        'view_item' => __('Xem dịch vụ', 'aratavietnam'),
        'search_items' => __('Tìm kiếm dịch vụ', 'aratavietnam'),
        'not_found' => __('Không tìm thấy dịch vụ nào', 'aratavietnam'),
        'not_found_in_trash' => __('Không có dịch vụ nào trong thùng rác', 'aratavietnam'),
    ];

    register_post_type('service', [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'menu_position' => 27,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'dich-vu'],
        'show_in_rest' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'show_in_nav_menus' => true,
    ]);
});

/**
 * Register Service Categories Taxonomy
 */
add_action('init', function () {
    $labels = [
        'name' => __('Danh mục dịch vụ', 'aratavietnam'),
        'singular_name' => __('Danh mục dịch vụ', 'aratavietnam'),
        'search_items' => __('Tìm kiếm danh mục', 'aratavietnam'),
        'all_items' => __('Tất cả danh mục', 'aratavietnam'),
        'parent_item' => __('Danh mục cha', 'aratavietnam'),
        'parent_item_colon' => __('Danh mục cha:', 'aratavietnam'),
        'edit_item' => __('Sửa danh mục', 'aratavietnam'),
        'update_item' => __('Cập nhật danh mục', 'aratavietnam'),
        'add_new_item' => __('Thêm danh mục mới', 'aratavietnam'),
        'new_item_name' => __('Tên danh mục mới', 'aratavietnam'),
        'menu_name' => __('Danh mục dịch vụ', 'aratavietnam'),
    ];

    register_taxonomy('service_category', ['service'], [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'danh-muc-dich-vu'],
        'show_in_rest' => true,
    ]);
});

/**
 * Add custom columns to Services admin list
 */
add_filter('manage_service_posts_columns', function ($columns) {
    $new_columns = [];
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['service_category'] = __('Danh mục', 'aratavietnam');
    $new_columns['service_type'] = __('Loại dịch vụ', 'aratavietnam');
    $new_columns['service_price'] = __('Giá', 'aratavietnam');
    $new_columns['service_status'] = __('Trạng thái', 'aratavietnam');
    $new_columns['menu_order'] = __('Thứ tự', 'aratavietnam');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
});

/**
 * Populate custom columns
 */
add_action('manage_service_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'service_category':
            $terms = get_the_terms($post_id, 'service_category');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(function($term) {
                    return '<a href="' . admin_url('edit.php?post_type=service&service_category=' . $term->slug) . '">' . $term->name . '</a>';
                }, $terms);
                echo implode(', ', $term_names);
            } else {
                echo '—';
            }
            break;
        case 'service_type':
            $type = get_post_meta($post_id, 'arata_service_type', true);
            $type_labels = [
                'consultation' => 'Tư vấn',
                'implementation' => 'Triển khai',
                'maintenance' => 'Bảo trì',
                'support' => 'Hỗ trợ',
                'training' => 'Đào tạo',
                'custom' => 'Tùy chỉnh'
            ];
            echo $type_labels[$type] ?? '—';
            break;
        case 'service_price':
            $price = get_post_meta($post_id, 'arata_service_price', true);
            $price_type = get_post_meta($post_id, 'arata_service_price_type', true);
            if ($price) {
                if ($price_type === 'free') {
                    echo '<span class="text-green-600 font-medium">Miễn phí</span>';
                } elseif ($price_type === 'contact') {
                    echo '<span class="text-blue-600 font-medium">Liên hệ</span>';
                } else {
                    echo '<span class="font-medium">' . esc_html($price) . '</span>';
                }
            } else {
                echo '—';
            }
            break;
        case 'service_status':
            $status = get_post_meta($post_id, 'arata_service_status', true);
            $status_labels = [
                'active' => '<span class="text-green-600 font-medium">Hoạt động</span>',
                'inactive' => '<span class="text-gray-500 font-medium">Tạm ngưng</span>',
                'coming_soon' => '<span class="text-orange-600 font-medium">Sắp ra mắt</span>',
                'deprecated' => '<span class="text-red-600 font-medium">Ngừng cung cấp</span>'
            ];
            echo $status_labels[$status] ?? '—';
            break;
        case 'menu_order':
            $order = get_post_field('menu_order', $post_id);
            echo esc_html($order ?: '0');
            break;
    }
}, 10, 2);

/**
 * Make columns sortable
 */
add_filter('manage_edit-service_sortable_columns', function ($columns) {
    $columns['service_category'] = 'service_category';
    $columns['service_type'] = 'service_type';
    $columns['service_price'] = 'service_price';
    $columns['service_status'] = 'service_status';
    $columns['menu_order'] = 'menu_order';
    return $columns;
});

/**
 * Add meta boxes for Services
 */
add_action('add_meta_boxes', function () {
    global $post;

    // Only add Services hero meta box if this page uses services template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/services.php') {
        // Services page hero meta box
        add_meta_box(
            'arata_services_hero_settings',
            'Cài đặt Hero Section',
            function($post) {
                wp_nonce_field('arata_services_meta_nonce', 'arata_services_nonce');

            $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
            $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
            $subtitle = get_post_meta($post->ID, 'arata_services_subtitle', true);
            $intro = get_post_meta($post->ID, 'arata_services_intro', true);

            // Hero Settings Section
            echo '<div style="margin-bottom: 20px;">';
            echo '<table class="form-table">';

            // Show Hero checkbox
            echo '<tr>';
            echo '<th><label for="arata_show_hero">Hiển thị Hero Section</label></th>';
            echo '<td>';
            echo '<input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" ' . checked($show_hero !== '0', true, false) . ' />';
            echo '<p class="description">Hiển thị phần hero trên trang dịch vụ</p>';
            echo '</td>';
            echo '</tr>';

            // Compact Hero checkbox
            echo '<tr>';
            echo '<th><label for="arata_compact_hero">Chế độ Hero</label></th>';
            echo '<td>';
            echo '<input type="checkbox" id="arata_compact_hero" name="arata_compact_hero" value="1" ' . checked($compact_hero, '1', false) . ' />';
            echo '<p class="description">Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)<br>Hero nhỏ gọn sẽ có chiều cao thấp hơn và thiết kế đơn giản</p>';
            echo '</td>';
            echo '</tr>';

            echo '</table>';
            echo '</div>';

            // Hero Content Section
            echo '<h3 style="margin-top: 20px; padding: 10px; background: #f0f0f0; border-left: 4px solid #0073aa; margin-bottom: 15px;">Nội dung Hero Section</h3>';
            echo '<table class="form-table">';

            // Hero Title
            echo '<tr>';
            echo '<th><label for="arata_services_subtitle">Tiêu đề Hero</label></th>';
            echo '<td>';
            echo '<input type="text" id="arata_services_subtitle" name="arata_services_subtitle" value="' . esc_attr($subtitle ?: 'Dịch vụ') . '" class="regular-text" placeholder="Dịch vụ" />';
            echo '<p class="description">Tiêu đề hiển thị trong hero section</p>';
            echo '</td>';
            echo '</tr>';

            // Hero Description
            echo '<tr>';
            echo '<th><label for="arata_services_intro">Mô tả Hero</label></th>';
            echo '<td>';
            echo '<textarea id="arata_services_intro" name="arata_services_intro" rows="4" class="large-text" placeholder="Khám phá các dịch vụ chất lượng cao của Arata Vietnam với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm Nhật Bản.">' . esc_textarea($intro) . '</textarea>';
            echo '<p class="description">Mô tả hiển thị dưới tiêu đề trong hero section</p>';
            echo '</td>';
            echo '</tr>';

            echo '</table>';
            },
            'page',
            'normal',
            'high'
        );

        // Additional Services Page Settings
        add_meta_box(
            'arata_services_sections',
            'Cài đặt Sections',
            function($post) {
                wp_nonce_field('arata_services_sections_nonce', 'arata_services_sections_nonce');

                $show_services = get_post_meta($post->ID, 'arata_show_services', true);
                $show_stats = get_post_meta($post->ID, 'arata_show_stats', true);
                $show_why_choose = get_post_meta($post->ID, 'arata_show_why_choose', true);
                $show_testimonials = get_post_meta($post->ID, 'arata_show_testimonials', true);

                echo '<table class="form-table">';

                // Show Services
                echo '<tr>';
                echo '<th><label for="arata_show_services">Hiển thị Dịch vụ</label></th>';
                echo '<td>';
                echo '<input type="checkbox" id="arata_show_services" name="arata_show_services" value="1" ' . checked($show_services !== '0', true, false) . ' />';
                echo '<p class="description">Hiển thị danh sách dịch vụ</p>';
                echo '</td>';
                echo '</tr>';

                // Show Stats
                echo '<tr>';
                echo '<th><label for="arata_show_stats">Hiển thị Thống kê</label></th>';
                echo '<td>';
                echo '<input type="checkbox" id="arata_show_stats" name="arata_show_stats" value="1" ' . checked($show_stats !== '0', true, false) . ' />';
                echo '<p class="description">Hiển thị section thống kê (đã tắt trong code)</p>';
                echo '</td>';
                echo '</tr>';

                // Show Why Choose Us
                echo '<tr>';
                echo '<th><label for="arata_show_why_choose">Hiển thị Tại sao chọn chúng tôi</label></th>';
                echo '<td>';
                echo '<input type="checkbox" id="arata_show_why_choose" name="arata_show_why_choose" value="1" ' . checked($show_why_choose !== '0', true, false) . ' />';
                echo '<p class="description">Hiển thị section tại sao chọn (đã tắt trong code)</p>';
                echo '</td>';
                echo '</tr>';

                // Show Testimonials
                echo '<tr>';
                echo '<th><label for="arata_show_testimonials">Hiển thị Đánh giá khách hàng</label></th>';
                echo '<td>';
                echo '<input type="checkbox" id="arata_show_testimonials" name="arata_show_testimonials" value="1" ' . checked($show_testimonials !== '0', true, false) . ' />';
                echo '<p class="description">Hiển thị section đánh giá khách hàng (đã tắt trong code)</p>';
                echo '</td>';
                echo '</tr>';

                echo '</table>';
            },
            'page',
            'normal',
            'default'
        );

        // Services Page Content Settings
        add_meta_box(
            'arata_services_content',
            'Nội dung trang',
            function($post) {
                wp_nonce_field('arata_services_content_nonce', 'arata_services_content_nonce');

                $featured_text = get_post_meta($post->ID, 'arata_services_featured_text', true);
                $cta_text = get_post_meta($post->ID, 'arata_services_cta_text', true);
                $cta_link = get_post_meta($post->ID, 'arata_services_cta_link', true);

                echo '<table class="form-table">';

                // Featured Text
                echo '<tr>';
                echo '<th><label for="arata_services_featured_text">Văn bản nổi bật</label></th>';
                echo '<td>';
                echo '<input type="text" id="arata_services_featured_text" name="arata_services_featured_text" value="' . esc_attr($featured_text) . '" class="regular-text" placeholder="VD: Cam kết chất lượng - Uy tín hàng đầu" />';
                echo '<p class="description">Văn bản nổi bật hiển thị trên trang</p>';
                echo '</td>';
                echo '</tr>';

                // CTA Text
                echo '<tr>';
                echo '<th><label for="arata_services_cta_text">Text nút CTA</label></th>';
                echo '<td>';
                echo '<input type="text" id="arata_services_cta_text" name="arata_services_cta_text" value="' . esc_attr($cta_text ?: 'Liên hệ tư vấn') . '" class="regular-text" placeholder="Liên hệ tư vấn" />';
                echo '<p class="description">Text hiển thị trên nút call-to-action</p>';
                echo '</td>';
                echo '</tr>';

                // CTA Link
                echo '<tr>';
                echo '<th><label for="arata_services_cta_link">Link nút CTA</label></th>';
                echo '<td>';
                echo '<input type="text" id="arata_services_cta_link" name="arata_services_cta_link" value="' . esc_attr($cta_link ?: '/lien-he') . '" class="regular-text" placeholder="/lien-he" />';
                echo '<p class="description">Đường dẫn cho nút call-to-action</p>';
                echo '</td>';
                echo '</tr>';

                echo '</table>';
            },
            'page',
            'normal',
            'default'
        );
    }

    add_meta_box(
        'arata_service_meta',
        __('Thông tin dịch vụ', 'aratavietnam'),
        function ($post) {
            wp_nonce_field('arata_service_meta_save', 'arata_service_meta_nonce');

            $service_type = get_post_meta($post->ID, 'arata_service_type', true);
            $service_price = get_post_meta($post->ID, 'arata_service_price', true);
            $service_icon = get_post_meta($post->ID, 'arata_service_icon', true);
            $service_color = get_post_meta($post->ID, 'arata_service_color', true);

            echo '<table class="form-table">';

            // Service Type
            echo '<tr>';
            echo '<th><label for="arata_service_type">Loại dịch vụ</label></th>';
            echo '<td>';
            echo '<select id="arata_service_type" name="arata_service_type">';
            echo '<option value="">Chọn loại dịch vụ</option>';
            $types = [
                'consultation' => 'Tư vấn',
                'implementation' => 'Triển khai',
                'maintenance' => 'Bảo trì',
                'support' => 'Hỗ trợ',
                'training' => 'Đào tạo',
                'custom' => 'Tùy chỉnh'
            ];
            foreach ($types as $value => $label) {
                echo '<option value="' . esc_attr($value) . '" ' . selected($service_type, $value, false) . '>' . esc_html($label) . '</option>';
            }
            echo '</select>';
            echo '</td>';
            echo '</tr>';

            // Service Price
            echo '<tr>';
            echo '<th><label for="arata_service_price">Giá dịch vụ</label></th>';
            echo '<td>';
            echo '<input type="text" id="arata_service_price" name="arata_service_price" value="' . esc_attr($service_price) . '" class="regular-text" placeholder="VD: 5.000.000₫ hoặc Liên hệ" />';
            echo '</td>';
            echo '</tr>';

            // Service Icon
            echo '<tr>';
            echo '<th><label for="arata_service_icon">Icon dịch vụ</label></th>';
            echo '<td>';
            echo '<input type="text" id="arata_service_icon" name="arata_service_icon" value="' . esc_attr($service_icon) . '" class="regular-text" placeholder="VD: settings, users, phone" />';
            echo '<p class="description">Tên icon từ Lucide Icons</p>';
            echo '</td>';
            echo '</tr>';

            // Service Color
            echo '<tr>';
            echo '<th><label for="arata_service_color">Màu chủ đạo</label></th>';
            echo '<td>';
            echo '<input type="color" id="arata_service_color" name="arata_service_color" value="' . esc_attr($service_color ?: '#F55E25') . '" />';
            echo '</td>';
            echo '</tr>';

            echo '</table>';
        },
        'service',
        'normal',
        'high'
    );
});

/**
 * Save service meta data
 */
add_action('save_post', function ($post_id) {
    if (!isset($_POST['arata_service_meta_nonce']) || !wp_verify_nonce($_POST['arata_service_meta_nonce'], 'arata_service_meta_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = ['arata_service_type', 'arata_service_price', 'arata_service_icon', 'arata_service_color'];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
});

/**
 * Save meta for Services page - Hero settings
 */
add_action('save_post', function($post_id) {
    if (!isset($_POST['arata_services_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_services_nonce']), 'arata_services_meta_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save hero settings
    $show_hero = isset($_POST['arata_show_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_show_hero', $show_hero);

    $compact_hero = isset($_POST['arata_compact_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_compact_hero', $compact_hero);

    if (isset($_POST['arata_services_subtitle'])) {
        update_post_meta($post_id, 'arata_services_subtitle', sanitize_text_field($_POST['arata_services_subtitle']));
    }

    if (isset($_POST['arata_services_intro'])) {
        update_post_meta($post_id, 'arata_services_intro', sanitize_textarea_field($_POST['arata_services_intro']));
    }
});

/**
 * Save meta for Services page - Sections settings
 */
add_action('save_post', function($post_id) {
    if (!isset($_POST['arata_services_sections_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_services_sections_nonce']), 'arata_services_sections_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save sections settings
    $sections = ['arata_show_services', 'arata_show_stats', 'arata_show_why_choose', 'arata_show_testimonials'];

    foreach ($sections as $section) {
        $value = isset($_POST[$section]) ? '1' : '0';
        update_post_meta($post_id, $section, $value);
    }
});

/**
 * Save meta for Services page - Content settings
 */
add_action('save_post', function($post_id) {
    if (!isset($_POST['arata_services_content_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_services_content_nonce']), 'arata_services_content_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save content settings
    $content_fields = ['arata_services_featured_text', 'arata_services_cta_text', 'arata_services_cta_link'];

    foreach ($content_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
});
