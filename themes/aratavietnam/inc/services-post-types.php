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
        'has_archive' => false, // Disable default archive
        'rewrite' => ['slug' => 'dich-vu'],
        'show_in_rest' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'show_in_nav_menus' => true,
    ]);
});

/**
 * Fix rewrite rules for service post type
 * Ensure archive page works correctly
 */
add_action('init', function() {
    // Remove conflicting rewrite rules first
    remove_rewrite_tag('%service%');

    add_rewrite_rule(
        '^dich-vu/?$',
        'index.php?pagename=dich-vu',
        'top'
    );

    // Add custom rewrite rules for single service posts
    add_rewrite_rule(
        '^dich-vu/([^/]+)/?$',
        'index.php?post_type=service&name=$matches[1]',
        'top'
    );
}, 10);

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
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'danh-muc-dich-vu'],
        'show_in_rest' => true,
    ]);
});

/**
 * Register Service Features Taxonomy
 */
add_action('init', function () {
    $labels = [
        'name' => __('Tính năng dịch vụ', 'aratavietnam'),
        'singular_name' => __('Tính năng dịch vụ', 'aratavietnam'),
        'search_items' => __('Tìm kiếm tính năng', 'aratavietnam'),
        'all_items' => __('Tất cả tính năng', 'aratavietnam'),
        'edit_item' => __('Sửa tính năng', 'aratavietnam'),
        'update_item' => __('Cập nhật tính năng', 'aratavietnam'),
        'add_new_item' => __('Thêm tính năng mới', 'aratavietnam'),
        'new_item_name' => __('Tên tính năng mới', 'aratavietnam'),
        'menu_name' => __('Tính năng dịch vụ', 'aratavietnam'),
    ];

    register_taxonomy('service_feature', ['service'], [
        'labels' => $labels,
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'tinh-nang-dich-vu'],
        'show_in_rest' => true,
    ]);
});

/**
 * Customize admin columns for Services
 */
add_filter('manage_service_posts_columns', function ($columns) {
    $new = [];
    $new['cb'] = $columns['cb'] ?? '';
    $new['title'] = __('Tên dịch vụ', 'aratavietnam');
    $new['service_category'] = __('Danh mục', 'aratavietnam');
    $new['service_type'] = __('Loại dịch vụ', 'aratavietnam');
    $new['service_price'] = __('Giá dịch vụ', 'aratavietnam');
    $new['service_status'] = __('Trạng thái', 'aratavietnam');
    $new['menu_order'] = __('Thứ tự', 'aratavietnam');
    $new['date'] = __('Ngày tạo', 'aratavietnam');
    return $new;
});

add_action('manage_service_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'service_category':
            $terms = get_the_terms($post_id, 'service_category');
            if ($terms && !is_wp_error($terms)) {
                $term_names = array_map(function($term) { return $term->name; }, $terms);
                echo esc_html(implode(', ', $term_names));
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
            echo esc_html($type_labels[$type] ?? $type ?: '—');
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
    }

    add_meta_box(
        'arata_service_meta',
        __('Thông tin dịch vụ', 'aratavietnam'),
        function ($post) {
            wp_nonce_field('arata_service_meta_save', 'arata_service_meta_nonce');

            $fields = [
                'arata_service_type' => [
                    'label' => __('Loại dịch vụ', 'aratavietnam'),
                    'type' => 'select',
                    'options' => [
                        'consultation' => 'Tư vấn',
                        'implementation' => 'Triển khai',
                        'maintenance' => 'Bảo trì',
                        'support' => 'Hỗ trợ',
                        'training' => 'Đào tạo',
                        'custom' => 'Tùy chỉnh'
                    ]
                ],
                'arata_service_price' => [
                    'label' => __('Giá dịch vụ', 'aratavietnam'),
                    'type' => 'text',
                    'placeholder' => 'VD: 500,000 VNĐ'
                ],
                'arata_service_price_type' => [
                    'label' => __('Kiểu giá', 'aratavietnam'),
                    'type' => 'select',
                    'options' => [
                        'fixed' => 'Giá cố định',
                        'hourly' => 'Theo giờ',
                        'project' => 'Theo dự án',
                        'free' => 'Miễn phí',
                        'contact' => 'Liên hệ báo giá'
                    ]
                ],
                'arata_service_status' => [
                    'label' => __('Trạng thái', 'aratavietnam'),
                    'type' => 'select',
                    'options' => [
                        'active' => 'Hoạt động',
                        'inactive' => 'Tạm ngưng',
                        'coming_soon' => 'Sắp ra mắt',
                        'deprecated' => 'Ngừng cung cấp'
                    ]
                ],
                'arata_service_duration' => [
                    'label' => __('Thời gian thực hiện', 'aratavietnam'),
                    'type' => 'text',
                    'placeholder' => 'VD: 2-3 tuần, 1 tháng'
                ],
                'arata_service_features' => [
                    'label' => __('Tính năng chính', 'aratavietnam'),
                    'type' => 'textarea',
                    'placeholder' => 'Liệt kê các tính năng chính của dịch vụ'
                ],
                'arata_service_benefits' => [
                    'label' => __('Lợi ích', 'aratavietnam'),
                    'type' => 'textarea',
                    'placeholder' => 'Lợi ích khách hàng nhận được'
                ],
                'arata_service_process' => [
                    'label' => __('Quy trình thực hiện', 'aratavietnam'),
                    'type' => 'textarea',
                    'placeholder' => 'Các bước thực hiện dịch vụ'
                ],
                'arata_service_requirements' => [
                    'label' => __('Yêu cầu khách hàng', 'aratavietnam'),
                    'type' => 'textarea',
                    'placeholder' => 'Yêu cầu cần thiết từ khách hàng'
                ],
                'arata_service_deliverables' => [
                    'label' => __('Sản phẩm đầu ra', 'aratavietnam'),
                    'type' => 'textarea',
                    'placeholder' => 'Những gì khách hàng nhận được'
                ],
                'arata_service_icon' => [
                    'label' => __('Icon dịch vụ', 'aratavietnam'),
                    'type' => 'text',
                    'placeholder' => 'Tên icon từ Lucide (VD: settings, users, globe)'
                ],
                'arata_service_color' => [
                    'label' => __('Màu sắc chủ đạo', 'aratavietnam'),
                    'type' => 'select',
                    'options' => [
                        'primary' => 'Cam chính (#F55E25)',
                        'secondary' => 'Xanh dương (#0066A6)',
                        'tertiary' => 'Vàng cam (#FFAB14)',
                        'success' => 'Xanh lá (#10B981)',
                        'info' => 'Xanh thông tin (#3B82F6)'
                    ]
                ]
            ];

            echo '<table class="form-table">';
            foreach ($fields as $key => $field) {
                $value = get_post_meta($post->ID, $key, true);
                echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th><td>';

                if ($field['type'] === 'select') {
                    echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text">';
                    echo '<option value="">Chọn ' . strtolower($field['label']) . '</option>';
                    foreach ($field['options'] as $opt_value => $opt_label) {
                        echo '<option value="' . esc_attr($opt_value) . '"' . selected($value, $opt_value, false) . '>' . esc_html($opt_label) . '</option>';
                    }
                    echo '</select>';
                } elseif ($field['type'] === 'textarea') {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                } elseif ($field['type'] === 'checkbox') {
                    echo '<input type="checkbox" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="1" ' . checked($value, '1', false) . ' />';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                }

                echo '</td></tr>';
            }
            echo '</table>';
        },
        'service',
        'normal',
        'default'
    );
}); // Close add_action('add_meta_boxes') callback

/**
 * Save meta for Services
 */
add_action('save_post_service', function($post_id) {
    if (!isset($_POST['arata_service_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_service_meta_nonce']), 'arata_service_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_post', $post_id)) { return; }

    $keys = [
        'arata_service_type',
        'arata_service_price',
        'arata_service_price_type',
        'arata_service_status',
        'arata_service_duration',
        'arata_service_features',
        'arata_service_benefits',
        'arata_service_process',
        'arata_service_requirements',
        'arata_service_deliverables',
        'arata_service_icon',
        'arata_service_color'
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
