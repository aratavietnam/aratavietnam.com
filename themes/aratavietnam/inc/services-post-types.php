<?php
/**
 * Custom Post Types for Services Section
 * - Services (Dịch vụ)
 * - Service Categories (Danh mục dịch vụ)
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

    // Add rewrite rule for the "Dịch vụ" page (highest priority)
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
});

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
 * Add meta boxes for Services page template
 */
add_action('add_meta_boxes_page', function($post) {
    $template = get_post_meta($post->ID, '_wp_page_template', true);

    if ($template === 'page-templates/services.php') {
        add_meta_box(
            'arata_services_meta',
            __('Cài đặt trang Dịch vụ', 'aratavietnam'),
            function($post) {
                $fields = [
                    'arata_services_subtitle' => [
                        'label' => __('Phụ đề Hero', 'aratavietnam'),
                        'type' => 'text',
                        'placeholder' => 'VD: Giải pháp toàn diện cho doanh nghiệp'
                    ],
                    'arata_services_intro' => [
                        'label' => __('Mô tả ngắn', 'aratavietnam'),
                        'type' => 'textarea',
                        'placeholder' => 'Mô tả tổng quan về dịch vụ của công ty'
                    ],
                    'arata_services_featured_text' => [
                        'label' => __('Văn bản nổi bật', 'aratavietnam'),
                        'type' => 'text',
                        'placeholder' => 'VD: Cam kết chất lượng - Uy tín hàng đầu'
                    ],
                    'arata_services_cta_text' => [
                        'label' => __('Text nút CTA', 'aratavietnam'),
                        'type' => 'text',
                        'placeholder' => 'VD: Liên hệ tư vấn'
                    ],
                    'arata_services_cta_link' => [
                        'label' => __('Link nút CTA', 'aratavietnam'),
                        'type' => 'text',
                        'placeholder' => 'VD: /lien-he hoặc #contact'
                    ]
                ];

                wp_nonce_field('arata_services_meta_save', 'arata_services_meta_nonce');
                echo '<table class="form-table">';
                foreach ($fields as $key => $field) {
                    $value = get_post_meta($post->ID, $key, true);
                    echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th><td>';

                    if ($field['type'] === 'textarea') {
                        echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text" placeholder="' . esc_attr($field['placeholder']) . '">' . esc_textarea($value) . '</textarea>';
                    } else {
                        echo '<input type="' . esc_attr($field['type']) . '" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" placeholder="' . esc_attr($field['placeholder']) . '" />';
                    }

                    echo '</td></tr>';
                }
                echo '</table>';
            },
            'page',
            'normal',
            'default'
        );
    }
});

/**
 * Save meta for Services page
 */
add_action('save_post_page', function($post_id) {
    if (!isset($_POST['arata_services_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_services_meta_nonce']), 'arata_services_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
    if (!current_user_can('edit_page', $post_id)) { return; }

    $keys = [
        'arata_services_subtitle',
        'arata_services_intro',
        'arata_services_featured_text',
        'arata_services_cta_text',
        'arata_services_cta_link'
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
 * Add meta boxes for Services Page Template
 */
add_action('add_meta_boxes', function () {
    // Add meta box for Services page template
    add_meta_box(
        'arata_services_page_meta',
        __('Cài đặt trang dịch vụ', 'aratavietnam'),
        function ($post) {
            // Only show for Services page template
            if (get_page_template_slug($post->ID) !== 'page-templates/services.php') {
                echo '<p class="description">Meta box này chỉ hiển thị cho trang sử dụng template "Services Page".</p>';
                return;
            }

            wp_nonce_field('arata_services_page_meta_save', 'arata_services_page_meta_nonce');

            $fields = [
                // Section visibility controls
                'arata_show_hero' => [
                    'label' => __('Hiển thị Hero Section', 'aratavietnam'),
                    'type' => 'checkbox',
                    'default' => '1'
                ],
                'arata_show_services' => [
                    'label' => __('Hiển thị Dịch vụ nổi bật', 'aratavietnam'),
                    'type' => 'checkbox',
                    'default' => '1'
                ],
                'arata_show_stats' => [
                    'label' => __('Hiển thị Thống kê', 'aratavietnam'),
                    'type' => 'checkbox',
                    'default' => '1'
                ],
                'arata_show_why_choose' => [
                    'label' => __('Hiển thị Tại sao chọn chúng tôi', 'aratavietnam'),
                    'type' => 'checkbox',
                    'default' => '1'
                ],
                'arata_show_testimonials' => [
                    'label' => __('Hiển thị Đánh giá khách hàng', 'aratavietnam'),
                    'type' => 'checkbox',
                    'default' => '1'
                ],

                // Statistics section
                'arata_stats_title' => [
                    'label' => __('Tiêu đề thống kê', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Thống kê ấn tượng'
                ],
                'arata_stats_subtitle' => [
                    'label' => __('Mô tả thống kê', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Những con số thể hiện sự tin tưởng và hài lòng của khách hàng đối với dịch vụ của chúng tôi.'
                ],
                'arata_stats_customers' => [
                    'label' => __('Số khách hàng hài lòng', 'aratavietnam'),
                    'type' => 'text',
                    'default' => '500'
                ],
                'arata_stats_projects' => [
                    'label' => __('Số dự án thành công', 'aratavietnam'),
                    'type' => 'text',
                    'default' => '50'
                ],
                'arata_stats_years' => [
                    'label' => __('Số năm kinh nghiệm', 'aratavietnam'),
                    'type' => 'text',
                    'default' => '5'
                ],
                'arata_stats_success_rate' => [
                    'label' => __('Tỷ lệ thành công (%)', 'aratavietnam'),
                    'type' => 'text',
                    'default' => '98'
                ],

                // Why Choose Us section
                'arata_why_choose_title' => [
                    'label' => __('Tiêu đề "Tại sao chọn"', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Tại sao chọn Arata Vietnam?'
                ],
                'arata_why_choose_subtitle' => [
                    'label' => __('Mô tả "Tại sao chọn"', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Chúng tôi cam kết mang đến những giá trị tốt nhất cho khách hàng thông qua chất lượng dịch vụ và sự tận tâm.'
                ],
                'arata_why_choose_quality_title' => [
                    'label' => __('Tiêu đề "Chất lượng hàng đầu"', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Chất lượng hàng đầu'
                ],
                'arata_why_choose_quality_desc' => [
                    'label' => __('Mô tả "Chất lượng hàng đầu"', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Cam kết cung cấp dịch vụ chất lượng cao với tiêu chuẩn Nhật Bản.'
                ],
                'arata_why_choose_team_title' => [
                    'label' => __('Tiêu đề "Đội ngũ chuyên nghiệp"', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Đội ngũ chuyên nghiệp'
                ],
                'arata_why_choose_team_desc' => [
                    'label' => __('Mô tả "Đội ngũ chuyên nghiệp"', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Đội ngũ nhân viên giàu kinh nghiệm, được đào tạo bài bản.'
                ],
                'arata_why_choose_service_title' => [
                    'label' => __('Tiêu đề "Dịch vụ 24/7"', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Dịch vụ 24/7'
                ],
                'arata_why_choose_service_desc' => [
                    'label' => __('Mô tả "Dịch vụ 24/7"', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Hỗ trợ khách hàng mọi lúc, mọi nơi với tinh thần phục vụ tận tâm.'
                ],

                // Testimonials section
                'arata_testimonials_title' => [
                    'label' => __('Tiêu đề đánh giá', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Khách hàng nói gì về chúng tôi'
                ],
                'arata_testimonials_subtitle' => [
                    'label' => __('Mô tả đánh giá', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Những đánh giá chân thực từ khách hàng đã sử dụng dịch vụ của Arata Vietnam.'
                ],

                // Testimonial 1
                'arata_testimonial_1_name' => [
                    'label' => __('Tên khách hàng 1', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Nguyễn Văn An'
                ],
                'arata_testimonial_1_position' => [
                    'label' => __('Chức vụ khách hàng 1', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Giám đốc Công ty ABC'
                ],
                'arata_testimonial_1_content' => [
                    'label' => __('Nội dung đánh giá 1', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Arata Vietnam đã giúp chúng tôi tối ưu hóa quy trình kinh doanh và tăng hiệu quả hoạt động đáng kể. Đội ngũ chuyên nghiệp và tận tâm.'
                ],

                // Testimonial 2
                'arata_testimonial_2_name' => [
                    'label' => __('Tên khách hàng 2', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Trần Thị Bình'
                ],
                'arata_testimonial_2_position' => [
                    'label' => __('Chức vụ khách hàng 2', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Chủ doanh nghiệp XYZ'
                ],
                'arata_testimonial_2_content' => [
                    'label' => __('Nội dung đánh giá 2', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Dịch vụ marketing số của Arata Vietnam thực sự hiệu quả. Chúng tôi đã thấy rõ sự tăng trưởng trong doanh số và nhận diện thương hiệu.'
                ],

                // Testimonial 3
                'arata_testimonial_3_name' => [
                    'label' => __('Tên khách hàng 3', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Lê Văn Cường'
                ],
                'arata_testimonial_3_position' => [
                    'label' => __('Chức vụ khách hàng 3', 'aratavietnam'),
                    'type' => 'text',
                    'default' => 'Quản lý Dự án DEF'
                ],
                'arata_testimonial_3_content' => [
                    'label' => __('Nội dung đánh giá 3', 'aratavietnam'),
                    'type' => 'textarea',
                    'default' => 'Hỗ trợ kỹ thuật 24/7 của Arata Vietnam giúp chúng tôi yên tâm vận hành hệ thống. Đội ngũ kỹ thuật viên rất chuyên nghiệp và nhanh nhạy.'
                ]
            ];

            echo '<div class="arata-meta-sections">';

            // Section visibility controls
            echo '<div class="arata-meta-section">';
            echo '<h3 style="margin-top: 20px; padding: 10px; background: #f0f0f0; border-left: 4px solid #0073aa;">Cài đặt hiển thị</h3>';
            foreach (['arata_show_hero', 'arata_show_services', 'arata_show_stats', 'arata_show_why_choose', 'arata_show_testimonials'] as $key) {
                $field = $fields[$key];
                $value = get_post_meta($post->ID, $key, true);
                echo '<table class="form-table"><tr>';
                echo '<th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th>';
                echo '<td>';
                echo '<input type="checkbox" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="1" ' . checked($value, '1', false) . ' />';
                echo '</td></tr></table>';
            }
            echo '</div>';

            // Statistics Section
            echo '<div class="arata-meta-section">';
            echo '<h3 style="margin-top: 20px; padding: 10px; background: #f0f0f0; border-left: 4px solid #0073aa;">Thống kê ấn tượng</h3>';
            foreach (['arata_stats_title', 'arata_stats_subtitle', 'arata_stats_customers', 'arata_stats_projects', 'arata_stats_years', 'arata_stats_success_rate'] as $key) {
                $field = $fields[$key];
                $value = get_post_meta($post->ID, $key, true) ?: $field['default'];
                echo '<table class="form-table"><tr>';
                echo '<th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th>';
                echo '<td>';
                if ($field['type'] === 'textarea') {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                }
                echo '</td></tr></table>';
            }
            echo '</div>';

            // Why Choose Us Section
            echo '<div class="arata-meta-section">';
            echo '<h3 style="margin-top: 20px; padding: 10px; background: #f0f0f0; border-left: 4px solid #0073aa;">Tại sao chọn Arata Vietnam?</h3>';
            foreach (['arata_why_choose_title', 'arata_why_choose_subtitle', 'arata_why_choose_quality_title', 'arata_why_choose_quality_desc', 'arata_why_choose_team_title', 'arata_why_choose_team_desc', 'arata_why_choose_service_title', 'arata_why_choose_service_desc'] as $key) {
                $field = $fields[$key];
                $value = get_post_meta($post->ID, $key, true) ?: $field['default'];
                echo '<table class="form-table"><tr>';
                echo '<th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th>';
                echo '<td>';
                if ($field['type'] === 'textarea') {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                }
                echo '</td></tr></table>';
            }
            echo '</div>';

            // Testimonials Section
            echo '<div class="arata-meta-section">';
            echo '<h3 style="margin-top: 20px; padding: 10px; background: #f0f0f0; border-left: 4px solid #0073aa;">Đánh giá khách hàng</h3>';

            // General testimonials fields
            foreach (['arata_testimonials_title', 'arata_testimonials_subtitle'] as $key) {
                $field = $fields[$key];
                $value = get_post_meta($post->ID, $key, true) ?: $field['default'];
                echo '<table class="form-table"><tr>';
                echo '<th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th>';
                echo '<td>';
                if ($field['type'] === 'textarea') {
                    echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                } else {
                    echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                }
                echo '</td></tr></table>';
            }

            // Individual testimonials
            for ($i = 1; $i <= 3; $i++) {
                echo '<h4 style="margin-top: 15px; padding: 8px; background: #f9f9f9; border-left: 3px solid #0073aa;">Khách hàng ' . $i . '</h4>';

                foreach (['name', 'position', 'content'] as $field_type) {
                    $key = 'arata_testimonial_' . $i . '_' . $field_type;
                    $field = $fields[$key];
                    $value = get_post_meta($post->ID, $key, true) ?: $field['default'];
                    echo '<table class="form-table"><tr>';
                    echo '<th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th>';
                    echo '<td>';
                    if ($field['type'] === 'textarea') {
                        echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
                    } else {
                        echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text" />';
                    }
                    echo '</td></tr></table>';
                }
            }

            echo '</div>';

            echo '</div>';
        },
        'page',
        'normal',
        'high'
    );
});

/**
 * Save meta boxes for Services Page Template
 */
add_action('save_post', function ($post_id) {
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if this is a page
    if (get_post_type($post_id) !== 'page') {
        return;
    }

    // Check if this is the Services page template
    if (get_page_template_slug($post_id) !== 'page-templates/services.php') {
        return;
    }

    // Verify nonce
    if (!isset($_POST['arata_services_page_meta_nonce']) || !wp_verify_nonce($_POST['arata_services_page_meta_nonce'], 'arata_services_page_meta_save')) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta fields
    $meta_fields = [
        'arata_show_hero', 'arata_show_services', 'arata_show_stats', 'arata_show_why_choose', 'arata_show_testimonials',
        'arata_stats_title', 'arata_stats_subtitle', 'arata_stats_customers', 'arata_stats_projects', 'arata_stats_years', 'arata_stats_success_rate',
        'arata_why_choose_title', 'arata_why_choose_subtitle', 'arata_why_choose_quality_title', 'arata_why_choose_quality_desc',
        'arata_why_choose_team_title', 'arata_why_choose_team_desc', 'arata_why_choose_service_title', 'arata_why_choose_service_desc',
        'arata_testimonials_title', 'arata_testimonials_subtitle',
        'arata_testimonial_1_name', 'arata_testimonial_1_position', 'arata_testimonial_1_content',
        'arata_testimonial_2_name', 'arata_testimonial_2_position', 'arata_testimonial_2_content',
        'arata_testimonial_3_name', 'arata_testimonial_3_position', 'arata_testimonial_3_content'
    ];

    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            // For checkboxes, if not set in POST, save as empty string (unchecked)
            if (strpos($field, 'arata_show_') === 0) {
                update_post_meta($post_id, $field, '');
            }
        }
    }
});
