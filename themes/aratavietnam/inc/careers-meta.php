<?php
/**
 * Careers Page Meta Boxes
 * Configurable hero settings for careers page
 */

if (!defined('ABSPATH')) { exit; }

/**
 * Add careers page meta boxes
 */
function add_careers_meta_boxes() {
    global $post;

    // Add meta box for careers template page OR the "tuyen-dung" page (for archive settings)
    if ($post && (get_page_template_slug($post->ID) === 'page-templates/careers.php' || $post->post_name === 'tuyen-dung')) {
        add_meta_box(
            'careers_settings',
            'Cài đặt trang Tuyển dụng',
            'careers_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'add_careers_meta_boxes');

/**
 * Careers meta box callback
 */
function careers_settings_callback($post) {
    // Only show for pages using the careers template or careers archive page
    $page_template = get_page_template_slug($post->ID);
    $is_careers_template = $page_template === 'page-templates/careers.php';
    $is_careers_archive = $post->post_name === 'tuyen-dung';

    if (!$is_careers_template && !$is_careers_archive) {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "Careers Page" hoặc trang tuyển dụng.</p>';
        return;
    }

    wp_nonce_field('careers_meta_nonce', 'careers_meta_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $careers_subtitle = get_post_meta($post->ID, 'arata_careers_subtitle', true);
    $careers_intro = get_post_meta($post->ID, 'arata_careers_intro', true);

    // Set defaults
    if ($show_hero === '') $show_hero = '1';
    if ($careers_subtitle === '') $careers_subtitle = 'Cơ hội nghề nghiệp tuyệt vời tại Arata Vietnam';
    if ($careers_intro === '') $careers_intro = 'Gia nhập đội ngũ Arata Vietnam và phát triển sự nghiệp trong lĩnh vực hóa mỹ phẩm hàng đầu.';
    ?>

    <style>
        .careers-meta-table { width: 100%; }
        .careers-meta-table th { width: 200px; text-align: left; padding: 15px 10px 15px 0; vertical-align: top; }
        .careers-meta-table td { padding: 15px 0; }
        .careers-meta-table input[type="text"], .careers-meta-table textarea { width: 100%; max-width: 500px; }
        .careers-meta-table textarea { height: 80px; }
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
    <table class="careers-meta-table">
        <tr>
            <th><label for="arata_show_hero">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero (banner) ở đầu trang
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_compact_hero">Chế độ Hero</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)
                </label>
                <p class="description">Hero nhỏ gọn sẽ có chiều cao thấp hơn và phù hợp cho trang nội dung.</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Nội dung Hero Section</div>
    <table class="careers-meta-table">
        <tr>
            <th><label for="arata_careers_subtitle">Tiêu đề phụ Hero</label></th>
            <td>
                <input type="text" id="arata_careers_subtitle" name="arata_careers_subtitle" value="<?php echo esc_attr($careers_subtitle); ?>" placeholder="Cơ hội nghề nghiệp tuyệt vời tại Arata Vietnam" />
                <p class="description">Tiêu đề phụ hiển thị trong hero section</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_careers_intro">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_careers_intro" name="arata_careers_intro" placeholder="Gia nhập đội ngũ Arata Vietnam..."><?php echo esc_textarea($careers_intro); ?></textarea>
                <p class="description">Mô tả chi tiết hiển thị trong hero section</p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save careers meta box data
 */
function save_careers_meta_box_data($post_id) {
    // Verify nonce
    if (!isset($_POST['careers_meta_nonce']) || !wp_verify_nonce($_POST['careers_meta_nonce'], 'careers_meta_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using careers template or archive page
    $page_template = get_page_template_slug($post_id);
    $post = get_post($post_id);
    $is_careers_template = $page_template === 'page-templates/careers.php';
    $is_careers_archive = $post && $post->post_name === 'tuyen-dung';

    if (!$is_careers_template && !$is_careers_archive) {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = ['arata_show_hero', 'arata_compact_hero'];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save text fields
    $text_fields = ['arata_careers_subtitle', 'arata_careers_intro'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_careers_meta_box_data');
