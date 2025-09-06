<?php
/**
 * About Page Meta Fields
 *
 * Add meta fields for about page customization similar to blog page
 */

if (!defined('ABSPATH')) { exit; }

// Add meta box for about page settings
function add_about_meta_boxes() {
    global $post;
    
    // Only add meta box if this page uses about template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/about.php') {
        add_meta_box(
            'about_hero_settings',
            __('Cài đặt Hero Section - Về chúng tôi', 'aratavietnam'),
            'about_hero_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
}

function about_hero_settings_callback($post) {
    // Only show for pages using the about template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/about.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "About Page".</p>';
        return;
    }

    wp_nonce_field('about_hero_settings_nonce', 'about_hero_settings_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'arata_about_subtitle', true);
    $hero_description = get_post_meta($post->ID, 'arata_about_description', true);

    ?>
    <style>
        .about-meta-table { width: 100%; }
        .about-meta-table th { width: 200px; text-align: left; padding: 15px 10px 15px 0; vertical-align: top; }
        .about-meta-table td { padding: 15px 0; }
        .about-meta-table input[type="text"], .about-meta-table textarea { width: 100%; max-width: 500px; }
        .about-meta-table textarea { height: 80px; }
        .section-header {
            background: #f0f0f1;
            padding: 10px 15px;
            margin: 20px -12px 15px -12px;
            font-weight: 600;
            border-left: 4px solid #2271b1;
        }
        .section-header:first-child { margin-top: 0; }
    </style>

    <div class="section-header">Cài đặt Hero Section</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_about_show_hero">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_about_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero trên trang về chúng tôi
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_compact_hero">Chế độ Hero</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_about_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)
                </label>
                <p class="description">Hero nhỏ gọn sẽ có chiều cao thấp hơn và thiết kế đơn giản</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Nội dung Hero Section</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_about_subtitle">Tiêu đề Hero</label></th>
            <td>
                <input type="text" id="arata_about_subtitle" name="arata_about_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Chuyên gia hóa mỹ phẩm Nhật Bản tại Việt Nam" />
                <p class="description">Tiêu đề hiển thị trong hero section</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_description">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_about_description" name="arata_about_description" placeholder="Arata Vietnam tự hào là đối tác tin cậy trong lĩnh vực hóa mỹ phẩm..."><?php echo esc_textarea($hero_description); ?></textarea>
                <p class="description">Mô tả hiển thị dưới tiêu đề trong hero section</p>
            </td>
        </tr>
    </table>
    <?php
}

function save_about_hero_settings($post_id) {
    // Verify nonce
    if (!isset($_POST['about_hero_settings_nonce']) || !wp_verify_nonce($_POST['about_hero_settings_nonce'], 'about_hero_settings_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using about template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/about.php') {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = ['arata_show_hero', 'arata_compact_hero'];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save text fields
    $text_fields = ['arata_about_subtitle', 'arata_about_description'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'arata_about_description') {
                update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
            } else {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}

// Hook the functions
add_action('add_meta_boxes', 'add_about_meta_boxes');
add_action('save_post', 'save_about_hero_settings');
