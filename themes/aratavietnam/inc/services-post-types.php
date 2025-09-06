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
 * Add meta boxes for Services
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'arata_service_details',
        __('Chi tiết dịch vụ', 'aratavietnam'),
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
 * Add meta boxes for Services Page Template - Hero Settings Only
 */
add_action('add_meta_boxes_page', function($post) {
    $template = get_post_meta($post->ID, '_wp_page_template', true);

    if ($template === 'page-templates/services.php') {
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
            
            echo '<table class="form-table">';
            
            // Show Hero checkbox
            echo '<tr>';
            echo '<th><label for="arata_show_hero">Hiển thị Hero Section</label></th>';
            echo '<td>';
            echo '<input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" ' . checked($show_hero !== '0', true, false) . ' />';
            echo '<p class="description">Bỏ chọn để ẩn hero section</p>';
            echo '</td>';
            echo '</tr>';
            
            // Compact Hero checkbox
            echo '<tr>';
            echo '<th><label for="arata_compact_hero">Sử dụng Hero nhỏ gọn</label></th>';
            echo '<td>';
            echo '<input type="checkbox" id="arata_compact_hero" name="arata_compact_hero" value="1" ' . checked($compact_hero, '1', false) . ' />';
            echo '<p class="description">Hero section nhỏ gọn hơn</p>';
            echo '</td>';
            echo '</tr>';
            
            // Subtitle
            echo '<tr>';
            echo '<th><label for="arata_services_subtitle">Phụ đề Hero</label></th>';
            echo '<td>';
            echo '<input type="text" id="arata_services_subtitle" name="arata_services_subtitle" value="' . esc_attr($subtitle) . '" class="regular-text" />';
            echo '<p class="description">Phụ đề hiển thị trong hero section</p>';
            echo '</td>';
            echo '</tr>';
            
            // Intro text
            echo '<tr>';
            echo '<th><label for="arata_services_intro">Mô tả Hero</label></th>';
            echo '<td>';
            echo '<textarea id="arata_services_intro" name="arata_services_intro" rows="3" class="large-text">' . esc_textarea($intro) . '</textarea>';
            echo '<p class="description">Mô tả hiển thị trong hero section</p>';
            echo '</td>';
            echo '</tr>';
            
            echo '</table>';
            },
            'page',
            'normal',
            'high'
        );
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
