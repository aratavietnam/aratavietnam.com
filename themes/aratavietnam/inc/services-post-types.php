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

        // Services Page Sections Manager
        add_meta_box(
            'arata_services_sections',
            'Quản lý Sections',
            'services_sections_callback',
            'page',
            'normal',
            'high'
        );
    }

    // Service meta box for service posts
    if ($post->post_type === 'service') {
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

            // Show Service Header
            echo '<tr>';
            echo '<th><label for="arata_show_service_header">Hiển thị tiêu đề dịch vụ</label></th>';
            echo '<td>';
            echo '<input type="checkbox" id="arata_show_service_header" name="arata_show_service_header" value="1" ' . checked(get_post_meta($post->ID, 'arata_show_service_header', true), '1', false) . ' />';
            echo '<p class="description">Hiển thị phần tiêu đề "Dịch vụ của chúng tôi" và mô tả</p>';
            echo '</td>';
            echo '</tr>';

            // Service Price Type
            echo '<tr>';
            echo '<th><label for="arata_service_price_type">Kiểu giá</label></th>';
            echo '<td>';
            echo '<select id="arata_service_price_type" name="arata_service_price_type">';
            echo '<option value="">Chọn kiểu giá</option>';
            $price_types = [
                'fixed' => 'Giá cố định',
                'hourly' => 'Theo giờ',
                'project' => 'Theo dự án',
                'free' => 'Miễn phí',
                'contact' => 'Liên hệ báo giá'
            ];
            foreach ($price_types as $value => $label) {
                echo '<option value="' . esc_attr($value) . '" ' . selected(get_post_meta($post->ID, 'arata_service_price_type', true), $value, false) . '>' . esc_html($label) . '</option>';
            }
            echo '</select>';
            echo '</td>';
            echo '</tr>';

            // Service Duration
            echo '<tr>';
            echo '<th><label for="arata_service_duration">Thời gian</label></th>';
            echo '<td>';
            echo '<input type="text" id="arata_service_duration" name="arata_service_duration" value="' . esc_attr(get_post_meta($post->ID, 'arata_service_duration', true)) . '" class="regular-text" placeholder="VD: 1-2 tuần, 3 tháng, tùy theo quy mô" />';
            echo '</td>';
            echo '</tr>';

            // Service Features
            echo '<tr>';
            echo '<th><label for="arata_service_features">Tính năng</label></th>';
            echo '<td>';
            echo '<textarea id="arata_service_features" name="arata_service_features" rows="3" class="large-text">' . esc_textarea(get_post_meta($post->ID, 'arata_service_features', true)) . '</textarea>';
            echo '<p class="description">Mỗi tính năng một dòng</p>';
            echo '</td>';
            echo '</tr>';

            // Service Benefits
            echo '<tr>';
            echo '<th><label for="arata_service_benefits">Lợi ích</label></th>';
            echo '<td>';
            echo '<textarea id="arata_service_benefits" name="arata_service_benefits" rows="3" class="large-text">' . esc_textarea(get_post_meta($post->ID, 'arata_service_benefits', true)) . '</textarea>';
            echo '<p class="description">Mỗi lợi ích một dòng</p>';
            echo '</td>';
            echo '</tr>';

            // Service Process
            echo '<tr>';
            echo '<th><label for="arata_service_process">Quy trình</label></th>';
            echo '<td>';
            echo '<textarea id="arata_service_process" name="arata_service_process" rows="3" class="large-text">' . esc_textarea(get_post_meta($post->ID, 'arata_service_process', true)) . '</textarea>';
            echo '<p class="description">Mỗi bước một dòng</p>';
            echo '</td>';
            echo '</tr>';

            // Service Requirements
            echo '<tr>';
            echo '<th><label for="arata_service_requirements">Yêu cầu</label></th>';
            echo '<td>';
            echo '<textarea id="arata_service_requirements" name="arata_service_requirements" rows="3" class="large-text">' . esc_textarea(get_post_meta($post->ID, 'arata_service_requirements', true)) . '</textarea>';
            echo '<p class="description">Mỗi yêu cầu một dòng</p>';
            echo '</td>';
            echo '</tr>';

            // Service Deliverables
            echo '<tr>';
            echo '<th><label for="arata_service_deliverables">Kết quả交付</label></th>';
            echo '<td>';
            echo '<textarea id="arata_service_deliverables" name="arata_service_deliverables" rows="3" class="large-text">' . esc_textarea(get_post_meta($post->ID, 'arata_service_deliverables', true)) . '</textarea>';
            echo '<p class="description">Mỗi kết quả một dòng</p>';
            echo '</td>';
            echo '</tr>';

            // Service Status
            echo '<tr>';
            echo '<th><label for="arata_service_status">Trạng thái</label></th>';
            echo '<td>';
            echo '<select id="arata_service_status" name="arata_service_status">';
            echo '<option value="">Chọn trạng thái</option>';
            $statuses = [
                'active' => 'Hoạt động',
                'inactive' => 'Tạm ngưng',
                'coming_soon' => 'Sắp ra mắt',
                'deprecated' => 'Ngừng cung cấp'
            ];
            foreach ($statuses as $value => $label) {
                echo '<option value="' . esc_attr($value) . '" ' . selected(get_post_meta($post->ID, 'arata_service_status', true), $value, false) . '>' . esc_html($label) . '</option>';
            }
            echo '</select>';
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
    }
});

// Enqueue media library for avatar and featured image upload
add_action('admin_enqueue_scripts', function ($hook) {
    // Only load on services page edit screen or service post type
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        global $post;
        if ($post && (
            get_page_template_slug($post->ID) === 'page-templates/services.php' || 
            $post->post_type === 'service'
        )) {
            wp_enqueue_media();
        }
    }
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

    $fields = [
        'arata_service_type', 
        'arata_service_price', 
        'arata_service_price_type',
        'arata_service_duration',
        'arata_service_icon', 
        'arata_service_color',
        'arata_service_status'
    ];

    // Handle checkbox fields
    $checkbox_fields = ['arata_show_service_header'];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Save textarea fields
    $textarea_fields = [
        'arata_service_features',
        'arata_service_benefits',
        'arata_service_process',
        'arata_service_requirements',
        'arata_service_deliverables'
    ];

    foreach ($textarea_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
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
 * Services sections meta box callback
 */
function services_sections_callback($post) {
    // Only show for services template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/services.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "Services Page".</p>';
        return;
    }

    wp_nonce_field('services_sections_nonce', 'services_sections_nonce');

    // Section visibility settings
    $show_services = get_post_meta($post->ID, 'arata_show_services', true) !== '0';
    $show_stats = get_post_meta($post->ID, 'arata_show_stats', true) !== '0';
    $show_why_choose = get_post_meta($post->ID, 'arata_show_why_choose', true) !== '0';
    $show_testimonials = get_post_meta($post->ID, 'arata_show_testimonials', true) !== '0';
    $show_cta = get_post_meta($post->ID, 'arata_show_cta', true) !== '0';

    // Section content settings
    $stats_title = get_post_meta($post->ID, 'arata_stats_title', true) ?: 'Những con số biết nói';
    $why_choose_title = get_post_meta($post->ID, 'arata_why_choose_title', true) ?: 'Tại sao chọn Arata Vietnam?';
    $testimonials_title = get_post_meta($post->ID, 'arata_testimonials_title', true) ?: 'Khách hàng nói gì về chúng tôi';
    $cta_title = get_post_meta($post->ID, 'arata_cta_title', true) ?: 'Sẵn sàng hợp tác?';
    $cta_description = get_post_meta($post->ID, 'arata_cta_description', true) ?: 'Hãy liên hệ với chúng tôi để được tư vấn giải pháp phù hợp nhất.';
    $cta_button_text = get_post_meta($post->ID, 'arata_cta_button_text', true) ?: 'Liên hệ ngay';
    $cta_button_link = get_post_meta($post->ID, 'arata_cta_button_link', true) ?: '/lien-he';

    ?>
    <style>
        .sections-manager { max-width: 100%; }
        .section-item { background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 15px; padding: 15px; }
        .section-header { display: flex; align-items: center; margin-bottom: 10px; }
        .section-toggle { margin-right: 10px; }
        .section-title { font-weight: 600; flex: 1; }
        .section-content { display: none; margin-top: 15px; }
        .section-content.active { display: block; }
        .form-table th { width: 200px; }
        .wp-editor-wrap { margin-top: 10px; }
    </style>

    <div class="sections-manager">
        <p class="description">Chọn các section hiển thị trên trang dịch vụ. Kéo thả để sắp xếp thứ tự.</p>

        <!-- Services Section -->
        <div class="section-item">
            <div class="section-header">
                <input type="checkbox" class="section-toggle" id="toggle_services" name="arata_show_services" value="1" <?php checked($show_services); ?> data-target="services_content">
                <label class="section-title" for="toggle_services">Danh sách dịch vụ</label>
            </div>
            <div id="services_content" class="section-content <?php echo $show_services ? 'active' : ''; ?>">
                <p class="description">Hiển thị danh sách tất cả dịch vụ.</p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="section-item">
            <div class="section-header">
                <input type="checkbox" class="section-toggle" id="toggle_stats" name="arata_show_stats" value="1" <?php checked($show_stats); ?> data-target="stats_content">
                <label class="section-title" for="toggle_stats">Thống kê thành tựu</label>
            </div>
            <div id="stats_content" class="section-content <?php echo $show_stats ? 'active' : ''; ?>">
                <table class="form-table">
                    <tr>
                        <th><label for="arata_stats_title">Tiêu đề section</label></th>
                        <td><input type="text" id="arata_stats_title" name="arata_stats_title" value="<?php echo esc_attr($stats_title); ?>" class="regular-text"></td>
                    </tr>
                </table>
                
                <!-- Stats Items Repeater -->
                <div class="repeater-section">
                    <h4 style="margin: 20px 0 10px; font-size: 14px; color: #23282d;">Các số liệu thống kê</h4>
                    <?php
                    $stats_items = get_post_meta($post->ID, 'arata_stats_items', true);
                    if (empty($stats_items)) {
                        $stats_items = [
                            ['number' => '10+', 'label' => 'Năm kinh nghiệm', 'color' => 'primary'],
                            ['number' => '5000+', 'label' => 'Khách hàng tin tưởng', 'color' => 'secondary'],
                            ['number' => '100+', 'label' => 'Sản phẩm chất lượng', 'color' => 'tertiary'],
                            ['number' => '24/7', 'label' => 'Hỗ trợ khách hàng', 'color' => 'primary']
                        ];
                    }
                    
                    if (!empty($stats_items) && is_array($stats_items)) :
                        foreach ($stats_items as $index => $item) :
                    ?>
                            <div class="repeater-item" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; position: relative;">
                                <button type="button" class="remove-repeater button button-secondary" style="position: absolute; top: 10px; right: 10px;">Xóa</button>
                                <table class="form-table">
                                    <tr>
                                        <th><label>Số liệu</label></th>
                                        <td><input type="text" name="arata_stats_items[<?php echo $index; ?>][number]" value="<?php echo esc_attr($item['number']); ?>" class="regular-text" placeholder="VD: 10+, 5000+"></td>
                                    </tr>
                                    <tr>
                                        <th><label>Nhãn</label></th>
                                        <td><input type="text" name="arata_stats_items[<?php echo $index; ?>][label]" value="<?php echo esc_attr($item['label']); ?>" class="regular-text" placeholder="VD: Năm kinh nghiệm"></td>
                                    </tr>
                                    <tr>
                                        <th><label>Màu sắc</label></th>
                                        <td>
                                            <select name="arata_stats_items[<?php echo $index; ?>][color]" class="regular-text">
                                                <option value="primary" <?php selected($item['color'], 'primary'); ?>>Màu chính</option>
                                                <option value="secondary" <?php selected($item['color'], 'secondary'); ?>>Màu phụ</option>
                                                <option value="tertiary" <?php selected($item['color'], 'tertiary'); ?>>Màu thứ cấp</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <button type="button" id="add-stats" class="button">+ Thêm số liệu</button>
                </div>
            </div>
        </div>

        <!-- Why Choose Section -->
        <div class="section-item">
            <div class="section-header">
                <input type="checkbox" class="section-toggle" id="toggle_why_choose" name="arata_show_why_choose" value="1" <?php checked($show_why_choose); ?> data-target="why_choose_content">
                <label class="section-title" for="toggle_why_choose">Lý do chọn chúng tôi</label>
            </div>
            <div id="why_choose_content" class="section-content <?php echo $show_why_choose ? 'active' : ''; ?>">
                <table class="form-table">
                    <tr>
                        <th><label for="arata_why_choose_title">Tiêu đề section</label></th>
                        <td><input type="text" id="arata_why_choose_title" name="arata_why_choose_title" value="<?php echo esc_attr($why_choose_title); ?>" class="regular-text"></td>
                    </tr>
                </table>
                
                <!-- Why Choose Items Repeater -->
                <div class="repeater-section">
                    <h4 style="margin: 20px 0 10px; font-size: 14px; color: #23282d;">Các lý do chọn chúng tôi</h4>
                    <?php
                    $why_choose_items = get_post_meta($post->ID, 'arata_why_choose_items', true);
                    if (empty($why_choose_items)) {
                        $why_choose_items = [
                            [
                                'icon' => 'check',
                                'title' => 'Chất lượng đảm bảo',
                                'description' => 'Sản phẩm nhập khẩu chính hãng từ Nhật Bản, đảm bảo chất lượng và an toàn.'
                            ],
                            [
                                'icon' => 'users',
                                'title' => 'Đội ngũ chuyên gia',
                                'description' => 'Đội ngũ nhân viên giàu kinh nghiệm, được đào tạo bài bản về sản phẩm.'
                            ],
                            [
                                'icon' => 'truck',
                                'title' => 'Giao hàng nhanh',
                                'description' => 'Hệ thống giao hàng nhanh chóng, tiện lợi trên toàn quốc.'
                            ]
                        ];
                    }
                    
                    if (!empty($why_choose_items) && is_array($why_choose_items)) :
                        foreach ($why_choose_items as $index => $item) :
                    ?>
                            <div class="repeater-item" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; position: relative;">
                                <button type="button" class="remove-repeater button button-secondary" style="position: absolute; top: 10px; right: 10px;">Xóa</button>
                                <table class="form-table">
                                    <tr>
                                        <th><label>Icon</label></th>
                                        <td>
                                            <select name="arata_why_choose_items[<?php echo $index; ?>][icon]" class="regular-text">
                                                <option value="check" <?php selected($item['icon'], 'check'); ?>>✓ Check</option>
                                                <option value="users" <?php selected($item['icon'], 'users'); ?>>👥 Users</option>
                                                <option value="truck" <?php selected($item['icon'], 'truck'); ?>>🚚 Truck</option>
                                                <option value="star" <?php selected($item['icon'], 'star'); ?>>⭐ Star</option>
                                                <option value="heart" <?php selected($item['icon'], 'heart'); ?>>❤️ Heart</option>
                                                <option value="shield" <?php selected($item['icon'], 'shield'); ?>>🛡️ Shield</option>
                                                <option value="award" <?php selected($item['icon'], 'award'); ?>>🏆 Award</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label>Tiêu đề</label></th>
                                        <td><input type="text" name="arata_why_choose_items[<?php echo $index; ?>][title]" value="<?php echo esc_attr($item['title']); ?>" class="regular-text"></td>
                                    </tr>
                                    <tr>
                                        <th><label>Mô tả</label></th>
                                        <td><textarea name="arata_why_choose_items[<?php echo $index; ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($item['description']); ?></textarea></td>
                                    </tr>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <button type="button" id="add-why-choose" class="button">+ Thêm lý do</button>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="section-item">
            <div class="section-header">
                <input type="checkbox" class="section-toggle" id="toggle_testimonials" name="arata_show_testimonials" value="1" <?php checked($show_testimonials); ?> data-target="testimonials_content">
                <label class="section-title" for="toggle_testimonials">Đánh giá khách hàng</label>
            </div>
            <div id="testimonials_content" class="section-content <?php echo $show_testimonials ? 'active' : ''; ?>">
                <table class="form-table">
                    <tr>
                        <th><label for="arata_testimonials_title">Tiêu đề section</label></th>
                        <td><input type="text" id="arata_testimonials_title" name="arata_testimonials_title" value="<?php echo esc_attr($testimonials_title); ?>" class="regular-text"></td>
                    </tr>
                </table>
                
                <!-- Testimonials Repeater -->
                <div class="repeater-section">
                    <h4 style="margin: 20px 0 10px; font-size: 14px; color: #23282d;">Đánh giá của khách hàng</h4>
                    <?php
                    $testimonials = get_post_meta($post->ID, 'arata_testimonials', true);
                    if (empty($testimonials)) {
                        $testimonials = [
                            [
                                'name' => 'Nguyễn Văn A',
                                'content' => 'Sản phẩm chất lượng, dịch vụ tận tình. Tôi rất hài lòng khi mua hàng tại Arata Vietnam.',
                                'rating' => 5
                            ],
                            [
                                'name' => 'Trần Thị B',
                                'content' => 'Đã sử dụng nhiều sản phẩm và đều rất tốt. Mình sẽ tiếp tục ủng hộ Arata Vietnam.',
                                'rating' => 5
                            ],
                            [
                                'name' => 'Lê Văn C',
                                'content' => 'Nhân viên tư vấn rất nhiệt tình, sản phẩm chính hãng từ Nhật. Rất đáng tin cậy!',
                                'rating' => 5
                            ]
                        ];
                    }
                    
                    if (!empty($testimonials) && is_array($testimonials)) :
                        foreach ($testimonials as $index => $item) :
                    ?>
                            <div class="repeater-item" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; position: relative;">
                                <button type="button" class="remove-repeater button button-secondary" style="position: absolute; top: 10px; right: 10px;">Xóa</button>
                                <table class="form-table">
                                    <tr>
                                        <th><label>Tên khách hàng</label></th>
                                        <td><input type="text" name="arata_testimonials[<?php echo $index; ?>][name]" value="<?php echo esc_attr($item['name']); ?>" class="regular-text" placeholder="Nguyễn Văn A"></td>
                                    </tr>
                                    <tr>
                                        <th><label>Nội dung đánh giá</label></th>
                                        <td><textarea name="arata_testimonials[<?php echo $index; ?>][content]" rows="3" class="large-text" placeholder="Nội dung đánh giá..."><?php echo esc_textarea($item['content']); ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <th><label>Đánh giá (sao)</label></th>
                                        <td>
                                            <select name="arata_testimonials[<?php echo $index; ?>][rating]" class="regular-text">
                                                <?php for($i=1; $i<=5; $i++) : ?>
                                                    <option value="<?php echo $i; ?>" <?php selected($item['rating'], $i); ?>><?php echo $i; ?> sao</option>
                                                <?php endfor; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label>Avatar khách hàng</label></th>
                                        <td>
                                            <?php
                                            $avatar_id = isset($item['avatar_id']) ? intval($item['avatar_id']) : 0;
                                            $avatar_url = $avatar_id ? wp_get_attachment_url($avatar_id) : '';
                                            ?>
                                            <div class="avatar-upload">
                                                <div class="avatar-preview" style="margin-bottom: 10px;">
                                                    <?php if ($avatar_url) : ?>
                                                        <img src="<?php echo esc_url($avatar_url); ?>" style="max-width: 100px; max-height: 100px; border-radius: 50%;" />
                                                    <?php else : ?>
                                                        <div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            <span style="color: #999;">No Image</span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="hidden" name="arata_testimonials[<?php echo $index; ?>][avatar_id]" value="<?php echo $avatar_id; ?>" class="avatar-id" />
                                                <button type="button" class="button upload-avatar-button" data-target=".avatar-id">Upload Avatar</button>
                                                <button type="button" class="button remove-avatar-button" style="<?php echo $avatar_url ? '' : 'display:none;'; ?>">Remove</button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <button type="button" id="add-testimonial" class="button">+ Thêm đánh giá</button>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="section-item">
            <div class="section-header">
                <input type="checkbox" class="section-toggle" id="toggle_cta" name="arata_show_cta" value="1" <?php checked($show_cta); ?> data-target="cta_content">
                <label class="section-title" for="toggle_cta">Call to Action</label>
            </div>
            <div id="cta_content" class="section-content <?php echo $show_cta ? 'active' : ''; ?>">
                <table class="form-table">
                    <tr>
                        <th><label for="arata_cta_title">Tiêu đề</label></th>
                        <td><input type="text" id="arata_cta_title" name="arata_cta_title" value="<?php echo esc_attr($cta_title); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="arata_cta_description">Mô tả</label></th>
                        <td><textarea id="arata_cta_description" name="arata_cta_description" rows="3" class="large-text"><?php echo esc_textarea($cta_description); ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="arata_cta_button_text">Text nút</label></th>
                        <td><input type="text" id="arata_cta_button_text" name="arata_cta_button_text" value="<?php echo esc_attr($cta_button_text); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="arata_cta_button_link">Link nút</label></th>
                        <td><input type="text" id="arata_cta_button_link" name="arata_cta_button_link" value="<?php echo esc_attr($cta_button_link); ?>" class="regular-text"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Section toggle functionality
        $('.section-toggle').on('change', function() {
            var target = $(this).data('target');
            $('#' + target).toggleClass('active', $(this).is(':checked'));
        });

        // Why Choose Repeater
        var whyChooseIndex = $('.repeater-item').length;
        $('#add-why-choose').on('click', function() {
            var template = `
                <div class="repeater-item" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; position: relative;">
                    <button type="button" class="remove-repeater button button-secondary" style="position: absolute; top: 10px; right: 10px;">Xóa</button>
                    <table class="form-table">
                        <tr>
                            <th><label>Icon</label></th>
                            <td>
                                <select name="arata_why_choose_items[${whyChooseIndex}][icon]" class="regular-text">
                                    <option value="check">✓ Check</option>
                                    <option value="users">👥 Users</option>
                                    <option value="truck">🚚 Truck</option>
                                    <option value="star">⭐ Star</option>
                                    <option value="heart">❤️ Heart</option>
                                    <option value="shield">🛡️ Shield</option>
                                    <option value="award">🏆 Award</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Tiêu đề</label></th>
                            <td><input type="text" name="arata_why_choose_items[${whyChooseIndex}][title]" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label>Mô tả</label></th>
                            <td><textarea name="arata_why_choose_items[${whyChooseIndex}][description]" rows="3" class="large-text"></textarea></td>
                        </tr>
                    </table>
                </div>`;
            $(this).before(template);
            whyChooseIndex++;
        });

        // Stats Repeater
        var statsIndex = $('.repeater-item').length;
        $('#add-stats').on('click', function() {
            var template = `
                <div class="repeater-item" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; position: relative;">
                    <button type="button" class="remove-repeater button button-secondary" style="position: absolute; top: 10px; right: 10px;">Xóa</button>
                    <table class="form-table">
                        <tr>
                            <th><label>Số liệu</label></th>
                            <td><input type="text" name="arata_stats_items[${statsIndex}][number]" class="regular-text" placeholder="VD: 10+, 5000+"></td>
                        </tr>
                        <tr>
                            <th><label>Nhãn</label></th>
                            <td><input type="text" name="arata_stats_items[${statsIndex}][label]" class="regular-text" placeholder="VD: Năm kinh nghiệm"></td>
                        </tr>
                        <tr>
                            <th><label>Màu sắc</label></th>
                            <td>
                                <select name="arata_stats_items[${statsIndex}][color]" class="regular-text">
                                    <option value="primary">Màu chính</option>
                                    <option value="secondary">Màu phụ</option>
                                    <option value="tertiary">Màu thứ cấp</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>`;
            $(this).before(template);
            statsIndex++;
        });

        // Testimonials Repeater
        var testimonialIndex = $('.repeater-item').length;
        $('#add-testimonial').on('click', function() {
            var template = `
                <div class="repeater-item" style="background: #fff; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; position: relative;">
                    <button type="button" class="remove-repeater button button-secondary" style="position: absolute; top: 10px; right: 10px;">Xóa</button>
                    <table class="form-table">
                        <tr>
                            <th><label>Tên khách hàng</label></th>
                            <td><input type="text" name="arata_testimonials[${testimonialIndex}][name]" class="regular-text" placeholder="Nguyễn Văn A"></td>
                        </tr>
                        <tr>
                            <th><label>Nội dung đánh giá</label></th>
                            <td><textarea name="arata_testimonials[${testimonialIndex}][content]" rows="3" class="large-text" placeholder="Nội dung đánh giá..."></textarea></td>
                        </tr>
                        <tr>
                            <th><label>Đánh giá (sao)</label></th>
                            <td>
                                <select name="arata_testimonials[${testimonialIndex}][rating]" class="regular-text">
                                    <option value="1">1 sao</option>
                                    <option value="2">2 sao</option>
                                    <option value="3">3 sao</option>
                                    <option value="4">4 sao</option>
                                    <option value="5" selected>5 sao</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Avatar khách hàng</label></th>
                            <td>
                                <div class="avatar-upload">
                                    <div class="avatar-preview" style="margin-bottom: 10px;">
                                        <div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: #999;">No Image</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="arata_testimonials[${testimonialIndex}][avatar_id]" value="0" class="avatar-id" />
                                    <button type="button" class="button upload-avatar-button" data-target=".avatar-id">Upload Avatar</button>
                                    <button type="button" class="button remove-avatar-button" style="display:none;">Remove</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>`;
            $(this).before(template);
            testimonialIndex++;
        });

        // Remove repeater item
        $(document).on('click', '.remove-repeater', function() {
            $(this).closest('.repeater-item').remove();
        });

        // Avatar upload functionality
        var mediaUploader;
        
        $(document).on('click', '.upload-avatar-button', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var target = button.data('target');
            var previewContainer = button.closest('.avatar-upload').find('.avatar-preview');
            
            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Avatar',
                button: {
                    text: 'Choose Avatar'
                },
                multiple: false
            });
            
            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                var avatarIdField = button.closest('.avatar-upload').find(target);
                avatarIdField.val(attachment.id);
                
                // Update preview
                previewContainer.html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px; border-radius: 50%;" />');
                
                // Show remove button
                button.siblings('.remove-avatar-button').show();
            });
            
            // Open the uploader dialog
            mediaUploader.open();
        });
        
        // Remove avatar
        $(document).on('click', '.remove-avatar-button', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var target = button.data('target');
            var previewContainer = button.closest('.avatar-upload').find('.avatar-preview');
            var avatarIdField = button.closest('.avatar-upload').find('.avatar-id');
            
            // Clear the value
            avatarIdField.val(0);
            
            // Reset preview
            previewContainer.html('<div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><span style="color: #999;">No Image</span></div>');
            
            // Hide remove button
            button.hide();
        });
    });

      });
    </script>
    <?php
}

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
});

/**
 * Save services sections meta box data
 */
add_action('save_post', function($post_id) {
    // Verify nonce
    if (!isset($_POST['services_sections_nonce']) || !wp_verify_nonce($_POST['services_sections_nonce'], 'services_sections_nonce')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Only save for services template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/services.php') {
        return;
    }

    // Save section visibility
    $sections = ['arata_show_services', 'arata_show_stats', 'arata_show_why_choose', 'arata_show_testimonials', 'arata_show_cta'];
    foreach ($sections as $section) {
        $value = isset($_POST[$section]) ? '1' : '0';
        update_post_meta($post_id, $section, $value);
    }

    // Save section content fields
    $text_fields = [
        'arata_stats_title',
        'arata_why_choose_title',
        'arata_testimonials_title',
        'arata_cta_title',
        'arata_cta_description',
        'arata_cta_button_text',
        'arata_cta_button_link'
    ];

    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Save Why Choose repeater items
    if (isset($_POST['arata_why_choose_items']) && is_array($_POST['arata_why_choose_items'])) {
        $why_choose_items = [];
        foreach ($_POST['arata_why_choose_items'] as $item) {
            if (!empty($item['title'])) {
                $why_choose_items[] = [
                    'icon' => sanitize_text_field($item['icon']),
                    'title' => sanitize_text_field($item['title']),
                    'description' => sanitize_textarea_field($item['description'])
                ];
            }
        }
        update_post_meta($post_id, 'arata_why_choose_items', $why_choose_items);
    }

    // Save Stats repeater items
    if (isset($_POST['arata_stats_items']) && is_array($_POST['arata_stats_items'])) {
        $stats_items = [];
        foreach ($_POST['arata_stats_items'] as $item) {
            if (!empty($item['number']) && !empty($item['label'])) {
                $stats_items[] = [
                    'number' => sanitize_text_field($item['number']),
                    'label' => sanitize_text_field($item['label']),
                    'color' => sanitize_text_field($item['color'])
                ];
            }
        }
        update_post_meta($post_id, 'arata_stats_items', $stats_items);
    }

    // Save Testimonials repeater items
    if (isset($_POST['arata_testimonial_items']) && is_array($_POST['arata_testimonial_items'])) {
        $testimonial_items = [];
        foreach ($_POST['arata_testimonial_items'] as $item) {
            if (!empty($item['name']) && !empty($item['content'])) {
                $testimonial_items[] = [
                    'name' => sanitize_text_field($item['name']),
                    'content' => sanitize_textarea_field($item['content']),
                    'rating' => intval($item['rating']),
                    'avatar_id' => isset($item['avatar_id']) ? intval($item['avatar_id']) : 0
                ];
            }
        }
        update_post_meta($post_id, 'arata_testimonial_items', $testimonial_items);
    }

    // Save Testimonials (old format)
    if (isset($_POST['arata_testimonials']) && is_array($_POST['arata_testimonials'])) {
        $testimonials = [];
        foreach ($_POST['arata_testimonials'] as $item) {
            if (!empty($item['name']) && !empty($item['content'])) {
                $testimonials[] = [
                    'name' => sanitize_text_field($item['name']),
                    'content' => sanitize_textarea_field($item['content']),
                    'rating' => intval($item['rating']),
                    'avatar_id' => isset($item['avatar_id']) ? intval($item['avatar_id']) : 0
                ];
            }
        }
        update_post_meta($post_id, 'arata_testimonials', $testimonials);
    }
});
