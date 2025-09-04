<?php
/**
 * Blog Page Meta Fields
 * 
 * Add meta fields for blog page customization similar to services page
 */

if (!defined('ABSPATH')) { exit; }

// Add meta box for blog page settings
function add_blog_meta_boxes() {
    add_meta_box(
        'blog_settings',
        __('Cài đặt trang Blog', 'aratavietnam'),
        'blog_settings_callback',
        'page',
        'normal',
        'high'
    );
}

function blog_settings_callback($post) {
    // Only show for pages using the blog template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/blog.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "Blog Page".</p>';
        return;
    }

    wp_nonce_field('blog_settings_nonce', 'blog_settings_nonce');
    
    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'arata_blog_subtitle', true);
    $hero_intro = get_post_meta($post->ID, 'arata_blog_intro', true);
    
    ?>
    <style>
        .blog-meta-table { width: 100%; }
        .blog-meta-table th { width: 200px; text-align: left; padding: 15px 10px 15px 0; vertical-align: top; }
        .blog-meta-table td { padding: 15px 0; }
        .blog-meta-table input[type="text"], .blog-meta-table textarea { width: 100%; max-width: 500px; }
        .blog-meta-table textarea { height: 80px; }
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
    <table class="blog-meta-table">
        <tr>
            <th><label for="arata_show_hero">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero trên trang blog
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
                <p class="description">Hero nhỏ gọn sẽ có chiều cao thấp hơn và thiết kế đơn giản</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Nội dung Hero Section</div>
    <table class="blog-meta-table">
        <tr>
            <th><label for="arata_blog_subtitle">Tiêu đề Hero</label></th>
            <td>
                <input type="text" id="arata_blog_subtitle" name="arata_blog_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Blog" />
                <p class="description">Tiêu đề hiển thị trong hero section</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_blog_intro">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_blog_intro" name="arata_blog_intro" placeholder="Khám phá những bài viết chuyên sâu về hóa mỹ phẩm..."><?php echo esc_textarea($hero_intro); ?></textarea>
                <p class="description">Mô tả hiển thị dưới tiêu đề trong hero section</p>
            </td>
        </tr>
    </table>
    <?php
}

function save_blog_settings($post_id) {
    // Verify nonce
    if (!isset($_POST['blog_settings_nonce']) || !wp_verify_nonce($_POST['blog_settings_nonce'], 'blog_settings_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using blog template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/blog.php') {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = ['arata_show_hero', 'arata_compact_hero'];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save text fields
    $text_fields = ['arata_blog_subtitle', 'arata_blog_intro'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

// Hook the functions
add_action('add_meta_boxes', 'add_blog_meta_boxes');
add_action('save_post', 'save_blog_settings');
