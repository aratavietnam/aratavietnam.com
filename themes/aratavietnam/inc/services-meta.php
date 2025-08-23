<?php
/**
 * Services Page Meta Box Management
 * 
 * Manages meta boxes for Services Page template only
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes only for Services Page template
 */
add_action('add_meta_boxes', 'arata_add_services_meta_boxes');

function arata_add_services_meta_boxes() {
    global $post;
    
    // Only add meta box if current page uses Services template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/services.php') {
        add_meta_box(
            'arata_services_page_settings',
            __('Cài đặt trang dịch vụ', 'aratavietnam'),
            'arata_services_page_meta_callback',
            'page',
            'normal',
            'high'
        );
    }
}

/**
 * Meta box callback function
 */
function arata_services_page_meta_callback($post) {
    // Add nonce for security
    wp_nonce_field('arata_services_page_meta_save', 'arata_services_page_meta_nonce');
    
    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $show_services = get_post_meta($post->ID, 'arata_show_services', true);
    $show_stats = get_post_meta($post->ID, 'arata_show_stats', true);
    $show_why_choose = get_post_meta($post->ID, 'arata_show_why_choose', true);
    $show_testimonials = get_post_meta($post->ID, 'arata_show_testimonials', true);
    
    $hero_subtitle = get_post_meta($post->ID, 'arata_services_subtitle', true);
    $hero_intro = get_post_meta($post->ID, 'arata_services_intro', true);
    $featured_text = get_post_meta($post->ID, 'arata_services_featured_text', true);
    $cta_text = get_post_meta($post->ID, 'arata_services_cta_text', true);
    $cta_link = get_post_meta($post->ID, 'arata_services_cta_link', true);
    
    ?>
    <div class="arata-services-meta">
        <style>
        .arata-services-meta .form-table th {
            width: 200px;
            padding: 15px 10px 15px 0;
        }
        .arata-services-meta .form-table td {
            padding: 15px 10px;
        }
        .arata-services-meta .section-header {
            background: #f1f1f1;
            padding: 10px 15px;
            margin: 20px 0 10px 0;
            border-left: 4px solid #0073aa;
            font-weight: bold;
        }
        .arata-services-meta input[type="text"],
        .arata-services-meta textarea {
            width: 100%;
        }
        .arata-services-meta textarea {
            height: 80px;
        }
        </style>
        
        <div class="section-header">Hiển thị các Section</div>
        <table class="form-table">
            <tr>
                <th><label for="arata_show_hero">Hiển thị Hero Section</label></th>
                <td>
                    <input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    <p class="description">Hiển thị phần hero ở đầu trang</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_show_services">Hiển thị Services Section</label></th>
                <td>
                    <input type="checkbox" id="arata_show_services" name="arata_show_services" value="1" <?php checked($show_services, '1'); ?> />
                    <p class="description">Hiển thị danh sách dịch vụ</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_show_stats">Hiển thị Statistics Section</label></th>
                <td>
                    <input type="checkbox" id="arata_show_stats" name="arata_show_stats" value="1" <?php checked($show_stats, '1'); ?> />
                    <p class="description">Hiển thị phần thống kê</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_show_why_choose">Hiển thị Why Choose Us Section</label></th>
                <td>
                    <input type="checkbox" id="arata_show_why_choose" name="arata_show_why_choose" value="1" <?php checked($show_why_choose, '1'); ?> />
                    <p class="description">Hiển thị phần tại sao chọn chúng tôi</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_show_testimonials">Hiển thị Testimonials Section</label></th>
                <td>
                    <input type="checkbox" id="arata_show_testimonials" name="arata_show_testimonials" value="1" <?php checked($show_testimonials, '1'); ?> />
                    <p class="description">Hiển thị phần đánh giá khách hàng</p>
                </td>
            </tr>
        </table>
        
        <div class="section-header">Nội dung Hero Section</div>
        <table class="form-table">
            <tr>
                <th><label for="arata_services_subtitle">Phụ đề Hero</label></th>
                <td>
                    <input type="text" id="arata_services_subtitle" name="arata_services_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Giải pháp toàn diện cho doanh nghiệp" />
                </td>
            </tr>
            <tr>
                <th><label for="arata_services_intro">Mô tả Hero</label></th>
                <td>
                    <textarea id="arata_services_intro" name="arata_services_intro" placeholder="Chúng tôi cung cấp các dịch vụ chất lượng cao..."><?php echo esc_textarea($hero_intro); ?></textarea>
                </td>
            </tr>
        </table>
        
        <div class="section-header">Nội dung Services Section</div>
        <table class="form-table">
            <tr>
                <th><label for="arata_services_featured_text">Tiêu đề Services</label></th>
                <td>
                    <input type="text" id="arata_services_featured_text" name="arata_services_featured_text" value="<?php echo esc_attr($featured_text); ?>" placeholder="Cam kết chất lượng - Uy tín hàng đầu" />
                </td>
            </tr>
            <tr>
                <th><label for="arata_services_cta_text">Text nút CTA</label></th>
                <td>
                    <input type="text" id="arata_services_cta_text" name="arata_services_cta_text" value="<?php echo esc_attr($cta_text); ?>" placeholder="Liên hệ tư vấn" />
                </td>
            </tr>
            <tr>
                <th><label for="arata_services_cta_link">Link nút CTA</label></th>
                <td>
                    <input type="text" id="arata_services_cta_link" name="arata_services_cta_link" value="<?php echo esc_attr($cta_link); ?>" placeholder="/lien-he" />
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Save meta box data
 */
add_action('save_post', 'arata_save_services_page_meta');

function arata_save_services_page_meta($post_id) {
    // Verify nonce
    if (!isset($_POST['arata_services_page_meta_nonce']) || !wp_verify_nonce($_POST['arata_services_page_meta_nonce'], 'arata_services_page_meta_save')) {
        return;
    }
    
    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Only save for Services template
    if (get_page_template_slug($post_id) !== 'page-templates/services.php') {
        return;
    }
    
    // Save checkbox fields
    $checkbox_fields = [
        'arata_show_hero',
        'arata_show_services', 
        'arata_show_stats',
        'arata_show_why_choose',
        'arata_show_testimonials'
    ];
    
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }
    
    // Save text fields
    $text_fields = [
        'arata_services_subtitle',
        'arata_services_intro',
        'arata_services_featured_text',
        'arata_services_cta_text',
        'arata_services_cta_link'
    ];
    
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

/**
 * Hide meta boxes for non-Services pages
 */
add_action('admin_head', 'arata_hide_meta_boxes_for_non_services');

function arata_hide_meta_boxes_for_non_services() {
    global $post;
    
    // Only run on page edit screen
    if (!$post || get_post_type($post) !== 'page') {
        return;
    }
    
    // If not Services template, hide Rank Math SEO and other meta boxes
    if (get_page_template_slug($post->ID) !== 'page-templates/services.php') {
        ?>
        <style>
        /* Hide Rank Math SEO meta box for non-Services pages */
        #rank_math_metabox {
            display: none !important;
        }
        
        /* Hide any duplicate Services meta boxes */
        #arata_services_meta,
        #arata_services_page_meta {
            display: none !important;
        }
        </style>
        <?php
    }
}

/**
 * Show Rank Math SEO only for Services template
 */
add_action('add_meta_boxes', 'arata_conditional_rank_math_display', 99);

function arata_conditional_rank_math_display() {
    global $post;
    
    if (!$post || get_post_type($post) !== 'page') {
        return;
    }
    
    // If not Services template, remove Rank Math meta box
    if (get_page_template_slug($post->ID) !== 'page-templates/services.php') {
        remove_meta_box('rank_math_metabox', 'page', 'normal');
    }
}
