<?php
/**
 * Homepage Custom Meta Fields
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add meta box for homepage settings
function arata_add_homepage_meta_box() {
    $front_page_id = get_option('page_on_front');
    if (get_current_screen()->id === 'page' && isset($_GET['post']) && (int)$_GET['post'] === (int)$front_page_id) {
        add_meta_box(
            'arata_homepage_settings',
            'Homepage Settings',
            'arata_homepage_meta_box_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'arata_add_homepage_meta_box');

// Meta box callback
function arata_homepage_meta_box_callback($post) {
    wp_nonce_field('arata_homepage_save_meta_box_data', 'arata_homepage_meta_box_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'arata_homepage_subtitle', true);
    $hero_intro = get_post_meta($post->ID, 'arata_homepage_intro', true);
    
    // Section toggles
    $show_marquee = get_post_meta($post->ID, 'arata_show_marquee', true);
    $show_featured_products = get_post_meta($post->ID, 'arata_show_featured_products', true);
    $show_all_products = get_post_meta($post->ID, 'arata_show_all_products', true);
    $show_about = get_post_meta($post->ID, 'arata_show_about', true);
    $show_partners = get_post_meta($post->ID, 'arata_show_partners', true);
    
    // Marquee text
    $marquee_text = get_post_meta($post->ID, '_marquee_text', true);

    // Hero slide fields
    $slide1_type = get_post_meta($post->ID, '_slide1_type', true) ?: 'image';
    $slide1_image = get_post_meta($post->ID, '_slide1_image', true);
    $slide1_video = get_post_meta($post->ID, '_slide1_video', true);
    $slide2_type = get_post_meta($post->ID, '_slide2_type', true) ?: 'image';
    $slide2_image = get_post_meta($post->ID, '_slide2_image', true);
    $slide2_video = get_post_meta($post->ID, '_slide2_video', true);
    $slide3_type = get_post_meta($post->ID, '_slide3_type', true) ?: 'image';
    $slide3_image = get_post_meta($post->ID, '_slide3_image', true);
    $slide3_video = get_post_meta($post->ID, '_slide3_video', true);

    ?>
    <style>
        .homepage-meta-table { width: 100%; }
        .homepage-meta-table th { width: 200px; text-align: left; padding: 15px 10px 15px 0; vertical-align: top; }
        .homepage-meta-table td { padding: 15px 0; }
        .homepage-meta-table input[type="text"], .homepage-meta-table textarea { width: 100%; max-width: 500px; }
        .homepage-meta-table textarea { height: 80px; }
        .section-header {
            background: #f0f0f1;
            padding: 10px 15px;
            margin: 20px -12px 15px -12px;
            font-weight: 600;
            border-left: 4px solid #2271b1;
        }
        .section-header:first-child { margin-top: 0; }
        .homepage-meta-tabs { margin-top: 20px; }
        .homepage-meta-tabs ul.tab-links { list-style: none; padding: 0; margin: 0; border-bottom: 1px solid #ddd; }
        .homepage-meta-tabs ul.tab-links li { display: inline-block; margin: 0 0 -1px 0; padding: 0; }
        .homepage-meta-tabs ul.tab-links li a { display: block; padding: 10px 15px; text-decoration: none; border: 1px solid #ddd; border-bottom: none; background: #f9f9f9; }
        .homepage-meta-tabs ul.tab-links li.active a { background: #fff; border-bottom: 1px solid #fff; margin-bottom: -1px; }
        .homepage-meta-tabs .tab-content { padding: 15px 0; }
        .homepage-meta-tabs .tab { display: none; }
        .homepage-meta-tabs .tab.active { display: block; }
    </style>

    <div class="section-header">Cài đặt Hero Section</div>
    <table class="homepage-meta-table">
        <tr>
            <th><label for="arata_show_hero">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero trên trang chủ
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
    <table class="homepage-meta-table">
        <tr>
            <th><label for="arata_homepage_subtitle">Tiêu đề Hero</label></th>
            <td>
                <input type="text" id="arata_homepage_subtitle" name="arata_homepage_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Trang chủ" />
                <p class="description">Tiêu đề hiển thị trong hero section</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_homepage_intro">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_homepage_intro" name="arata_homepage_intro" placeholder="Chào mừng bạn đến với Arata Vietnam..."><?php echo esc_textarea($hero_intro); ?></textarea>
                <p class="description">Mô tả hiển thị dưới tiêu đề trong hero section</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Cài đặt các Section</div>
    <table class="homepage-meta-table">
        <tr>
            <th><label for="arata_show_marquee">Hiển thị Marquee</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_marquee" name="arata_show_marquee" value="1" <?php checked($show_marquee, '1'); ?> />
                    Hiển thị phần marquee text chạy
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_featured_products">Hiển thị Sản phẩm nổi bật</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_featured_products" name="arata_show_featured_products" value="1" <?php checked($show_featured_products, '1'); ?> />
                    Hiển thị section sản phẩm nổi bật
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_all_products">Hiển thị Tất cả sản phẩm</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_all_products" name="arata_show_all_products" value="1" <?php checked($show_all_products, '1'); ?> />
                    Hiển thị section tất cả sản phẩm
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_about">Hiển thị Giới thiệu</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_about" name="arata_show_about" value="1" <?php checked($show_about, '1'); ?> />
                    Hiển thị section giới thiệu về Arata
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_partners">Hiển thị Đối tác</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_partners" name="arata_show_partners" value="1" <?php checked($show_partners, '1'); ?> />
                    Hiển thị section đối tác
                </label>
            </td>
        </tr>
    </table>

    <div class="section-header">Cài đặt Marquee Text</div>
    <table class="homepage-meta-table">
        <tr>
            <th><label for="marquee_text">Nội dung Marquee</label></th>
            <td>
                <input type="text" id="marquee_text" name="marquee_text" value="<?php echo esc_attr($marquee_text); ?>" placeholder="ARATA - NHÀ PHÂN PHỐI HÓA MỸ PHẨM HÀNG ĐẦU NHẬT BẢN" />
                <p class="description">Text sẽ chạy liên tục từ phải sang trái</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Cài đặt Hero Slides</div>
    <div class="homepage-meta-tabs">
        <ul class="tab-links">
            <li class="active"><a href="#slide1">Slide 1</a></li>
            <li><a href="#slide2">Slide 2</a></li>
            <li><a href="#slide3">Slide 3</a></li>
        </ul>

        <div class="tab-content">
            <div id="slide1" class="tab active">
                <table class="homepage-meta-table">
                    <tr>
                        <th><label for="slide1_type">Loại</label></th>
                        <td>
                            <select id="slide1_type" name="slide1_type">
                                <option value="image" <?php selected($slide1_type, 'image'); ?>>Hình ảnh</option>
                                <option value="video" <?php selected($slide1_type, 'video'); ?>>Video</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slide1_image">Hình ảnh</label></th>
                        <td>
                            <input type="text" id="slide1_image" name="slide1_image" value="<?php echo esc_attr($slide1_image); ?>" class="widefat" />
                            <button class="button upload_image_button">Upload Image</button>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slide1_video">Video URL (MP4)</label></th>
                        <td>
                            <input type="text" id="slide1_video" name="slide1_video" value="<?php echo esc_attr($slide1_video); ?>" class="widefat" />
                        </td>
                    </tr>
                </table>
            </div>

            <div id="slide2" class="tab">
                <table class="homepage-meta-table">
                    <tr>
                        <th><label for="slide2_type">Loại</label></th>
                        <td>
                            <select id="slide2_type" name="slide2_type">
                                <option value="image" <?php selected($slide2_type, 'image'); ?>>Hình ảnh</option>
                                <option value="video" <?php selected($slide2_type, 'video'); ?>>Video</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slide2_image">Hình ảnh</label></th>
                        <td>
                            <input type="text" id="slide2_image" name="slide2_image" value="<?php echo esc_attr($slide2_image); ?>" class="widefat" />
                            <button class="button upload_image_button">Upload Image</button>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slide2_video">Video URL (MP4)</label></th>
                        <td>
                            <input type="text" id="slide2_video" name="slide2_video" value="<?php echo esc_attr($slide2_video); ?>" class="widefat" />
                        </td>
                    </tr>
                </table>
            </div>

            <div id="slide3" class="tab">
                <table class="homepage-meta-table">
                    <tr>
                        <th><label for="slide3_type">Loại</label></th>
                        <td>
                            <select id="slide3_type" name="slide3_type">
                                <option value="image" <?php selected($slide3_type, 'image'); ?>>Hình ảnh</option>
                                <option value="video" <?php selected($slide3_type, 'video'); ?>>Video</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slide3_image">Hình ảnh</label></th>
                        <td>
                            <input type="text" id="slide3_image" name="slide3_image" value="<?php echo esc_attr($slide3_image); ?>" class="widefat" />
                            <button class="button upload_image_button">Upload Image</button>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="slide3_video">Video URL (MP4)</label></th>
                        <td>
                            <input type="text" id="slide3_video" name="slide3_video" value="<?php echo esc_attr($slide3_video); ?>" class="widefat" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}

// Save meta box data
function arata_homepage_save_meta_box_data($post_id) {
    if (!isset($_POST['arata_homepage_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['arata_homepage_meta_box_nonce'], 'arata_homepage_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Save hero settings
    $hero_checkbox_fields = ['arata_show_hero', 'arata_compact_hero'];
    foreach ($hero_checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save hero content fields
    $hero_text_fields = ['arata_homepage_subtitle', 'arata_homepage_intro'];
    foreach ($hero_text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }

    // Save section toggles
    $section_fields = ['arata_show_marquee', 'arata_show_featured_products', 'arata_show_all_products', 'arata_show_about', 'arata_show_partners'];
    foreach ($section_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save Marquee text
    if (isset($_POST['marquee_text'])) {
        update_post_meta($post_id, '_marquee_text', sanitize_text_field($_POST['marquee_text']));
    }

    // Save Slide 1 data
    if (isset($_POST['slide1_type'])) {
        update_post_meta($post_id, '_slide1_type', sanitize_text_field($_POST['slide1_type']));
    }
    if (isset($_POST['slide1_image'])) {
        update_post_meta($post_id, '_slide1_image', sanitize_text_field($_POST['slide1_image']));
    }
    if (isset($_POST['slide1_video'])) {
        update_post_meta($post_id, '_slide1_video', sanitize_text_field($_POST['slide1_video']));
    }

    // Save Slide 2 data
    if (isset($_POST['slide2_type'])) {
        update_post_meta($post_id, '_slide2_type', sanitize_text_field($_POST['slide2_type']));
    }
    if (isset($_POST['slide2_image'])) {
        update_post_meta($post_id, '_slide2_image', sanitize_text_field($_POST['slide2_image']));
    }
    if (isset($_POST['slide2_video'])) {
        update_post_meta($post_id, '_slide2_video', sanitize_text_field($_POST['slide2_video']));
    }

    // Save Slide 3 data
    if (isset($_POST['slide3_type'])) {
        update_post_meta($post_id, '_slide3_type', sanitize_text_field($_POST['slide3_type']));
    }
    if (isset($_POST['slide3_image'])) {
        update_post_meta($post_id, '_slide3_image', sanitize_text_field($_POST['slide3_image']));
    }
    if (isset($_POST['slide3_video'])) {
        update_post_meta($post_id, '_slide3_video', sanitize_text_field($_POST['slide3_video']));
    }
}
add_action('save_post', 'arata_homepage_save_meta_box_data');

// Enqueue scripts for media uploader and tabs
function arata_homepage_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('arata-homepage-admin-js', get_template_directory_uri() . '/assets/js/homepage-admin.js', ['jquery'], null, true);
    
    // Add inline script for tab functionality
    wp_add_inline_script('arata-homepage-admin-js', '
        jQuery(document).ready(function($) {
            // Tab functionality
            $(".homepage-meta-tabs ul.tab-links li a").click(function(e) {
                e.preventDefault();
                var tab_id = $(this).attr("href");
                
                $(".homepage-meta-tabs ul.tab-links li").removeClass("active");
                $(".homepage-meta-tabs .tab").removeClass("active");
                
                $(this).parent().addClass("active");
                $(tab_id).addClass("active");
            });
        });
    ');
}
add_action('admin_enqueue_scripts', 'arata_homepage_admin_scripts');


// Add meta box for homepage content sections
function arata_add_homepage_content_meta_box() {
    $front_page_id = get_option('page_on_front');
    if (get_current_screen()->id === 'page' && isset($_GET['post']) && (int)$_GET['post'] === (int)$front_page_id) {
        add_meta_box(
            'arata_homepage_content_settings',
            'Homepage Section Content',
            'arata_homepage_content_meta_box_callback',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'arata_add_homepage_content_meta_box');

// Callback for the homepage content meta box
function arata_homepage_content_meta_box_callback($post) {
    wp_nonce_field('arata_homepage_save_content_meta_box_data', 'arata_homepage_content_meta_box_nonce');

    // Get existing values
    $featured_title_part1 = get_post_meta($post->ID, '_featured_products_title_part1', true);
    $featured_title_part2 = get_post_meta($post->ID, '_featured_products_title_part2', true);
    $featured_desc = get_post_meta($post->ID, '_featured_products_description', true);
    $all_products_title_part1 = get_post_meta($post->ID, '_all_products_title_part1', true);
    $all_products_title_part2 = get_post_meta($post->ID, '_all_products_title_part2', true);
    $all_products_desc = get_post_meta($post->ID, '_all_products_description', true);
    $partners_title_part1 = get_post_meta($post->ID, '_partners_title_part1', true);
    $partners_title_part2 = get_post_meta($post->ID, '_partners_title_part2', true);
    $about_title_part1 = get_post_meta($post->ID, '_about_title_part1', true);
    $about_title_part2 = get_post_meta($post->ID, '_about_title_part2', true);
    $partners_desc = get_post_meta($post->ID, '_partners_description', true);
    $about_images = [];
    for ($i = 1; $i <= 5; $i++) {
        $about_images[$i] = get_post_meta($post->ID, '_about_image_' . $i, true);
    }
    ?>
    <div style="padding: 10px;">
        <h3>Featured Products Section</h3>
        <p>
            <label for="featured_products_title_part1"><strong>Title (Part 1 - Blue):</strong></label>
            <input type="text" id="featured_products_title_part1" name="featured_products_title_part1" value="<?php echo esc_attr($featured_title_part1); ?>" class="widefat" placeholder="Sản phẩm" />
        </p>
        <p>
            <label for="featured_products_title_part2"><strong>Title (Part 2 - Orange):</strong></label>
            <input type="text" id="featured_products_title_part2" name="featured_products_title_part2" value="<?php echo esc_attr($featured_title_part2); ?>" class="widefat" placeholder="Nổi bật" />
        </p>
        <p>
            <label for="featured_products_description"><strong>Description:</strong></label>
            <textarea id="featured_products_description" name="featured_products_description" class="widefat" rows="3" placeholder="Khám phá những sản phẩm hóa mỹ phẩm chất lượng cao..."><?php echo esc_textarea($featured_desc); ?></textarea>
        </p>
        <hr style="margin: 20px 0;">
        <h3>All Products Section</h3>
        <p>
            <label for="all_products_title_part1"><strong>Title (Part 1 - Blue):</strong></label>
            <input type="text" id="all_products_title_part1" name="all_products_title_part1" value="<?php echo esc_attr($all_products_title_part1); ?>" class="widefat" placeholder="Tất cả" />
        </p>
        <p>
            <label for="all_products_title_part2"><strong>Title (Part 2 - Orange):</strong></label>
            <input type="text" id="all_products_title_part2" name="all_products_title_part2" value="<?php echo esc_attr($all_products_title_part2); ?>" class="widefat" placeholder="Sản phẩm" />
        </p>
        <p>
            <label for="all_products_description"><strong>Description:</strong></label>
            <textarea id="all_products_description" name="all_products_description" class="widefat" rows="3" placeholder="Khám phá đầy đủ các sản phẩm..."><?php echo esc_textarea($all_products_desc); ?></textarea>
        <hr style="margin: 20px 0;">
        <h3>About Arata Section</h3>
        <p>
            <label for="about_title_part1"><strong>Title (Part 1 - Blue):</strong></label>
            <input type="text" id="about_title_part1" name="about_title_part1" value="<?php echo esc_attr($about_title_part1); ?>" class="widefat" placeholder="Về" />
        </p>
        <p>
            <label for="about_title_part2"><strong>Title (Part 2 - Orange):</strong></label>
            <input type="text" id="about_title_part2" name="about_title_part2" value="<?php echo esc_attr($about_title_part2); ?>" class="widefat" placeholder="Arata" />
        </p>
        <?php for ($i = 1; $i <= 5; $i++) : ?>
        <p>
            <label for="about_image_<?php echo $i; ?>"><strong>Image <?php echo $i; ?>:</strong></label>
            <input type="text" id="about_image_<?php echo $i; ?>" name="about_image_<?php echo $i; ?>" value="<?php echo esc_attr($about_images[$i]); ?>" class="widefat" />
            <button class="button upload_image_button">Upload Image</button>
        </p>
        <?php endfor; ?>
        <hr style="margin: 20px 0;">
        <h3>Partners Section</h3>
        <p>
            <label for="partners_title_part1"><strong>Title (Part 1 - Blue):</strong></label>
            <input type="text" id="partners_title_part1" name="partners_title_part1" value="<?php echo esc_attr($partners_title_part1); ?>" class="widefat" placeholder="Đối tác" />
        </p>
        <p>
            <label for="partners_title_part2"><strong>Title (Part 2 - Orange):</strong></label>
            <input type="text" id="partners_title_part2" name="partners_title_part2" value="<?php echo esc_attr($partners_title_part2); ?>" class="widefat" placeholder="& Thương hiệu" />
        </p>
        <p>
            <label for="partners_description"><strong>Description:</strong></label>
            <textarea id="partners_description" name="partners_description" class="widefat" rows="3" placeholder="Chúng tôi tự hào hợp tác với các thương hiệu..."><?php echo esc_textarea($partners_desc); ?></textarea>
        </p>
    </div>
    <?php
}

// Hook into the save_post action to save the new fields
function arata_homepage_save_content_meta_box_data($post_id) {
    if (!isset($_POST['arata_homepage_content_meta_box_nonce']) || !wp_verify_nonce($_POST['arata_homepage_content_meta_box_nonce'], 'arata_homepage_save_content_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Save About Arata images
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST['about_image_' . $i])) {
            update_post_meta($post_id, '_about_image_' . $i, sanitize_text_field($_POST['about_image_' . $i]));
        }
    }
    // Save Featured Products fields
    if (isset($_POST['featured_products_title_part1'])) {
        update_post_meta($post_id, '_featured_products_title_part1', sanitize_text_field($_POST['featured_products_title_part1']));
    }
    if (isset($_POST['featured_products_title_part2'])) {
        update_post_meta($post_id, '_featured_products_title_part2', sanitize_text_field($_POST['featured_products_title_part2']));
    }
    if (isset($_POST['featured_products_description'])) {
        update_post_meta($post_id, '_featured_products_description', sanitize_textarea_field($_POST['featured_products_description']));
    }

    // Save All Products fields
    if (isset($_POST['all_products_title_part1'])) {
        update_post_meta($post_id, '_all_products_title_part1', sanitize_text_field($_POST['all_products_title_part1']));
    }
    if (isset($_POST['all_products_title_part2'])) {
        update_post_meta($post_id, '_all_products_title_part2', sanitize_text_field($_POST['all_products_title_part2']));
    }
    if (isset($_POST['all_products_description'])) {
        update_post_meta($post_id, '_all_products_description', sanitize_textarea_field($_POST['all_products_description']));
    }

    // Save About Arata fields
    if (isset($_POST['about_title_part1'])) {
        update_post_meta($post_id, '_about_title_part1', sanitize_text_field($_POST['about_title_part1']));
    }
    if (isset($_POST['about_title_part2'])) {
        update_post_meta($post_id, '_about_title_part2', sanitize_text_field($_POST['about_title_part2']));
    }

    // Save Partners fields
    if (isset($_POST['partners_title_part1'])) {
        update_post_meta($post_id, '_partners_title_part1', sanitize_text_field($_POST['partners_title_part1']));
    }
    if (isset($_POST['partners_title_part2'])) {
        update_post_meta($post_id, '_partners_title_part2', sanitize_text_field($_POST['partners_title_part2']));
    }
    if (isset($_POST['partners_description'])) {
        update_post_meta($post_id, '_partners_description', sanitize_textarea_field($_POST['partners_description']));
    }
}
add_action('save_post', 'arata_homepage_save_content_meta_box_data');
