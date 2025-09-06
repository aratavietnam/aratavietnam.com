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

    // Add meta box for careers template page
    if ($post && get_page_template_slug($post->ID) === 'page-templates/careers.php') {
        add_meta_box(
            'careers_settings',
            'Cài đặt trang Tuyển dụng',
            'careers_settings_callback',
            'page',
            'normal',
            'high'
        );
    }

    // Also add meta box for the "tuyen-dung" page (for archive settings)
    if ($post && $post->post_name === 'tuyen-dung') {
        add_meta_box(
            'careers_archive_settings',
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
    // Add nonce for security
    wp_nonce_field('careers_meta_nonce', 'careers_meta_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $careers_subtitle = get_post_meta($post->ID, 'arata_careers_subtitle', true);
    $careers_intro = get_post_meta($post->ID, 'arata_careers_intro', true);

    // Set defaults
    if ($show_hero === '') $show_hero = '1';
    if ($careers_subtitle === '') $careers_subtitle = 'Tuyển dụng';
    if ($careers_intro === '') $careers_intro = 'Khám phá cơ hội nghề nghiệp tại Arata Vietnam - nơi bạn có thể phát triển tài năng và xây dựng tương lai trong lĩnh vực hóa mỹ phẩm.';
    ?>

    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="arata_show_hero">Hiển thị Hero Section</label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero (banner) ở đầu trang
                </label>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="arata_compact_hero">Chế độ Hero</label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="arata_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)
                </label>
                <p class="description">Hero nhỏ gọn sẽ có chiều cao thấp hơn và phù hợp cho trang nội dung.</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="arata_careers_subtitle">Tiêu đề phụ Hero</label>
            </th>
            <td>
                <input type="text" id="arata_careers_subtitle" name="arata_careers_subtitle" value="<?php echo esc_attr($careers_subtitle); ?>" class="regular-text" />
                <p class="description">Tiêu đề phụ hiển thị trong hero section</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="arata_careers_intro">Mô tả Hero</label>
            </th>
            <td>
                <textarea id="arata_careers_intro" name="arata_careers_intro" rows="4" class="large-text"><?php echo esc_textarea($careers_intro); ?></textarea>
                <p class="description">Mô tả chi tiết hiển thị trong hero section</p>
            </td>
        </tr>
    </table>

    <style>
        .form-table th {
            width: 200px;
        }
        .form-table td {
            padding: 15px 10px;
        }
        .form-table .description {
            margin-top: 5px;
            color: #666;
            font-style: italic;
        }
    </style>
    <?php
}

/**
 * Save careers meta box data
 */
function save_careers_meta_box_data($post_id) {
    // Check if our nonce is set
    if (!isset($_POST['careers_meta_nonce'])) {
        return;
    }

    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['careers_meta_nonce'], 'careers_meta_nonce')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    }

    // Sanitize and save the data
    $show_hero = isset($_POST['arata_show_hero']) ? '1' : '0';
    $compact_hero = isset($_POST['arata_compact_hero']) ? '1' : '0';
    $careers_subtitle = sanitize_text_field($_POST['arata_careers_subtitle']);
    $careers_intro = sanitize_textarea_field($_POST['arata_careers_intro']);

    update_post_meta($post_id, 'arata_show_hero', $show_hero);
    update_post_meta($post_id, 'arata_compact_hero', $compact_hero);
    update_post_meta($post_id, 'arata_careers_subtitle', $careers_subtitle);
    update_post_meta($post_id, 'arata_careers_intro', $careers_intro);
}
add_action('save_post', 'save_careers_meta_box_data');
