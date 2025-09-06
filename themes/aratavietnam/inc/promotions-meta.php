<?php
/**
 * Promotions Page Meta Boxes
 * Configurable hero settings for promotions page
 */

if (!defined('ABSPATH')) { exit; }

/**
 * Add promotions page meta boxes
 */
function add_promotions_meta_boxes() {
    global $post;
    
    // Only add meta box if this page uses promotions template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/promotions.php') {
        add_meta_box(
            'promotions_settings',
            'Cài đặt trang Khuyến mãi',
            'promotions_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'add_promotions_meta_boxes');

/**
 * Promotions settings meta box callback
 */
function promotions_settings_callback($post) {
    // Only show for pages using the promotions template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/promotions.php') {
        echo '<p class="description">Meta box này chỉ hiển thị cho trang sử dụng template "Promotions Page".</p>';
        return;
    }

    // Add nonce for security
    wp_nonce_field('promotions_settings_save', 'promotions_settings_nonce');
    
    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $promotions_subtitle = get_post_meta($post->ID, 'arata_promotions_subtitle', true);
    $promotions_intro = get_post_meta($post->ID, 'arata_promotions_intro', true);
    
    // Default values
    if ($promotions_subtitle === '') {
        $promotions_subtitle = 'Ưu đãi đặc biệt từ Arata Vietnam';
    }
    if ($promotions_intro === '') {
        $promotions_intro = 'Khám phá các chương trình khuyến mãi hấp dẫn và ưu đãi độc quyền từ Arata Vietnam.';
    }
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="arata_promotions_show_hero">Hiển thị Hero Section</label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="arata_promotions_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Bật hero section cho trang này
                </label>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="arata_promotions_compact_hero">Hero Gọn</label>
            </th>
            <td>
                <label>
                    <input type="checkbox" id="arata_promotions_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero gọn (thấp hơn)
                </label>
                <p class="description">Hero gọn sẽ có chiều cao thấp hơn và phong cách tối giản</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="arata_promotions_subtitle">Phụ đề Hero</label>
            </th>
            <td>
                <input type="text" id="arata_promotions_subtitle" name="arata_promotions_subtitle" value="<?php echo esc_attr($promotions_subtitle); ?>" class="large-text" />
                <p class="description">Tiêu đề phụ hiển thị trong hero section</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="arata_promotions_intro">Giới thiệu Hero</label>
            </th>
            <td>
                <textarea id="arata_promotions_intro" name="arata_promotions_intro" rows="3" class="large-text"><?php echo esc_textarea($promotions_intro); ?></textarea>
                <p class="description">Mô tả ngắn hiển thị trong hero section</p>
            </td>
        </tr>
    </table>
    
    <?php
}

/**
 * Save promotions settings
 */
function save_promotions_settings($post_id) {
    // Check if nonce is set
    if (!isset($_POST['promotions_settings_nonce'])) {
        return;
    }
    
    // Verify nonce
    if (!wp_verify_nonce($_POST['promotions_settings_nonce'], 'promotions_settings_save')) {
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

    // Only save for pages using promotions template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/promotions.php') {
        return;
    }
    
    // Save hero settings
    $show_hero = isset($_POST['arata_show_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_show_hero', $show_hero);
    
    $compact_hero = isset($_POST['arata_compact_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_compact_hero', $compact_hero);
    
    // Save promotions-specific content
    if (isset($_POST['arata_promotions_subtitle'])) {
        update_post_meta($post_id, 'arata_promotions_subtitle', sanitize_text_field($_POST['arata_promotions_subtitle']));
    }
    
    if (isset($_POST['arata_promotions_intro'])) {
        update_post_meta($post_id, 'arata_promotions_intro', sanitize_textarea_field($_POST['arata_promotions_intro']));
    }
}
add_action('save_post', 'save_promotions_settings');
