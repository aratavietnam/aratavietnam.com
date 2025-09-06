<?php
/**
 * Promotions Page Meta Boxes
 * Configurable hero settings for promotions page
 */

if (!defined('ABSPATH')) { exit; }

// Add meta box for promotions page settings
function add_promotions_meta_boxes() {
    global $post;

    // Only add meta box if this page uses promotions template OR is the promotions archive page
    $is_promotions_template = $post && get_page_template_slug($post->ID) === 'page-templates/promotions.php';
    $is_promotions_archive = $post && $post->post_name === 'khuyen-mai';

    if ($is_promotions_template || $is_promotions_archive) {
        add_meta_box(
            'promotions_settings',
            __('Cài đặt trang Khuyến mãi', 'aratavietnam'),
            'promotions_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
}

/**
 * Promotions settings meta box callback
 */
function promotions_settings_callback($post) {
    // Only show for pages using the promotions template or promotions archive page
    $page_template = get_page_template_slug($post->ID);
    $is_promotions_template = $page_template === 'page-templates/promotions.php';
    $is_promotions_archive = $post->post_name === 'khuyen-mai';

    if (!$is_promotions_template && !$is_promotions_archive) {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "Promotions Page" hoặc trang khuyến mãi.</p>';
        return;
    }

    wp_nonce_field('promotions_settings_nonce', 'promotions_settings_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'arata_promotions_subtitle', true);
    $hero_intro = get_post_meta($post->ID, 'arata_promotions_intro', true);

    ?>
    <style>
        .promotions-meta-table { width: 100%; }
        .promotions-meta-table th { width: 200px; text-align: left; padding: 15px 10px 15px 0; vertical-align: top; }
        .promotions-meta-table td { padding: 15px 0; }
        .promotions-meta-table input[type="text"], .promotions-meta-table textarea { width: 100%; max-width: 500px; }
        .promotions-meta-table textarea { height: 80px; }
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
    <table class="promotions-meta-table">
        <tr>
            <th><label for="arata_promotions_show_hero">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_promotions_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero trên trang khuyến mãi
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_promotions_compact_hero">Chế độ Hero</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_promotions_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)
                </label>
                <p class="description">Hero nhỏ gọn sẽ có chiều cao thấp hơn và thiết kế đơn giản</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Nội dung Hero Section</div>
    <table class="promotions-meta-table">
        <tr>
            <th><label for="arata_promotions_subtitle">Tiêu đề Hero</label></th>
            <td>
                <input type="text" id="arata_promotions_subtitle" name="arata_promotions_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Khuyến mãi" />
                <p class="description">Tiêu đề hiển thị trong hero section</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_promotions_intro">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_promotions_intro" name="arata_promotions_intro" placeholder="Khám phá các chương trình khuyến mãi hấp dẫn..."><?php echo esc_textarea($hero_intro); ?></textarea>
                <p class="description">Mô tả hiển thị dưới tiêu đề trong hero section</p>
            </td>
        </tr>
    </table>
    <?php
}

function save_promotions_settings($post_id) {
    // Verify nonce
    if (!isset($_POST['promotions_settings_nonce']) || !wp_verify_nonce($_POST['promotions_settings_nonce'], 'promotions_settings_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using promotions template or archive page
    $page_template = get_page_template_slug($post_id);
    $post = get_post($post_id);
    $is_promotions_template = $page_template === 'page-templates/promotions.php';
    $is_promotions_archive = $post && $post->post_name === 'khuyen-mai';

    if (!$is_promotions_template && !$is_promotions_archive) {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = ['arata_show_hero', 'arata_compact_hero'];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save text fields
    $text_fields = ['arata_promotions_subtitle', 'arata_promotions_intro'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

// Hook the functions
add_action('add_meta_boxes', 'add_promotions_meta_boxes');
add_action('save_post', 'save_promotions_settings');
