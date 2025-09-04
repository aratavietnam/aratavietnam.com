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
    add_meta_box(
        'careers_settings',
        'Cài đặt trang Tuyển dụng',
        'careers_settings_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_careers_meta_boxes');

/**
 * Careers settings meta box callback
 */
function careers_settings_callback($post) {
    // Add nonce for security
    wp_nonce_field('careers_settings_save', 'careers_settings_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $careers_subtitle = get_post_meta($post->ID, 'arata_careers_subtitle', true);
    $careers_intro = get_post_meta($post->ID, 'arata_careers_intro', true);

    // Default values
    if ($careers_subtitle === '') {
        $careers_subtitle = 'Cơ hội nghề nghiệp tại Arata Vietnam';
    }
    if ($careers_intro === '') {
        $careers_intro = 'Gia nhập đội ngũ Arata Vietnam và phát triển sự nghiệp trong lĩnh vực hóa mỹ phẩm hàng đầu.';
    }
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="arata_show_hero">Hiển thị Hero Section</label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Bật hero section cho trang này
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="arata_compact_hero">Hero Gọn</label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="arata_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero gọn (thấp hơn)
                </label>
                <p class="description">Hero gọn sẽ có chiều cao thấp hơn và phong cách tối giản</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="arata_careers_subtitle">Phụ đề Hero</label>
            </th>
            <td>
                <input type="text" id="arata_careers_subtitle" name="arata_careers_subtitle" value="<?php echo esc_attr($careers_subtitle); ?>" class="large-text" />
                <p class="description">Tiêu đề phụ hiển thị trong hero section</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="arata_careers_intro">Giới thiệu Hero</label>
            </th>
            <td>
                <textarea id="arata_careers_intro" name="arata_careers_intro" rows="3" class="large-text"><?php echo esc_textarea($careers_intro); ?></textarea>
                <p class="description">Mô tả ngắn hiển thị trong hero section</p>
            </td>
        </tr>
    </table>

    <?php
}

/**
 * Save careers settings
 */
function save_careers_settings($post_id) {
    // Check if nonce is set
    if (!isset($_POST['careers_settings_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['careers_settings_nonce'], 'careers_settings_save')) {
        return;
    }

    // Check if user has permission to edit
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save hero settings
    $show_hero = isset($_POST['arata_show_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_show_hero', $show_hero);

    $compact_hero = isset($_POST['arata_compact_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_compact_hero', $compact_hero);

    // Save careers-specific content
    if (isset($_POST['arata_careers_subtitle'])) {
        update_post_meta($post_id, 'arata_careers_subtitle', sanitize_text_field($_POST['arata_careers_subtitle']));
    }

    if (isset($_POST['arata_careers_intro'])) {
        update_post_meta($post_id, 'arata_careers_intro', sanitize_textarea_field($_POST['arata_careers_intro']));
    }
}
add_action('save_post', 'save_careers_settings');
