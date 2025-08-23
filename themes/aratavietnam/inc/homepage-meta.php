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
            'Homepage Banner Settings',
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

    // Marquee text field
    $marquee_text = get_post_meta($post->ID, '_marquee_text', true);

    // Slide 1 fields
    $slide1_type = get_post_meta($post->ID, '_slide1_type', true) ?: 'image';
    $slide1_image = get_post_meta($post->ID, '_slide1_image', true);
    $slide1_video = get_post_meta($post->ID, '_slide1_video', true);

    // Slide 2 fields
    $slide2_type = get_post_meta($post->ID, '_slide2_type', true) ?: 'image';
    $slide2_image = get_post_meta($post->ID, '_slide2_image', true);
    $slide2_video = get_post_meta($post->ID, '_slide2_video', true);

    // Slide 3 fields
    $slide3_type = get_post_meta($post->ID, '_slide3_type', true) ?: 'image';
    $slide3_image = get_post_meta($post->ID, '_slide3_image', true);
    $slide3_video = get_post_meta($post->ID, '_slide3_video', true);

    // HTML for the meta box
    ?>
    <div class="homepage-meta-tabs">
        <ul class="tab-links">
            <li class="active"><a href="#marquee">Marquee Text</a></li>
            <li><a href="#slide1">Slide 1</a></li>
            <li><a href="#slide2">Slide 2</a></li>
            <li><a href="#slide3">Slide 3</a></li>
        </ul>

        <div class="tab-content">
            <!-- Marquee Text Content -->
            <div id="marquee" class="tab active">
                <h4>Marquee Running Text Settings</h4>
                <p>
                    <label><strong>Running Text:</strong></label>
                    <input type="text" name="marquee_text" value="<?php echo esc_attr($marquee_text); ?>" class="widefat" placeholder="ARATA - NHÀ PHÂN PHỐI HÓA MỸ PHẨM HÀNG ĐẦU NHẬT BẢN" />
                    <em>Text sẽ chạy liên tục từ phải sang trái dưới hero banner</em>
                </p>
            </div>

            <!-- Slide 1 Content -->
            <div id="slide1" class="tab">
                <h4>Slide 1 Settings</h4>
                <p>
                    <label>Type:</label>
                    <select name="slide1_type">
                        <option value="image" <?php selected($slide1_type, 'image'); ?>>Image</option>
                        <option value="video" <?php selected($slide1_type, 'video'); ?>>Video</option>
                    </select>
                </p>
                <p>
                    <label>Image:</label>
                    <input type="text" name="slide1_image" value="<?php echo esc_attr($slide1_image); ?>" class="widefat" />
                    <button class="button upload_image_button">Upload Image</button>
                </p>
                <p>
                    <label>Video URL (MP4):</label>
                    <input type="text" name="slide1_video" value="<?php echo esc_attr($slide1_video); ?>" class="widefat" />
                </p>
            </div>

            <!-- Slide 2 Content -->
            <div id="slide2" class="tab">
                <h4>Slide 2 Settings</h4>
                <p>
                    <label>Type:</label>
                    <select name="slide2_type">
                        <option value="image" <?php selected($slide2_type, 'image'); ?>>Image</option>
                        <option value="video" <?php selected($slide2_type, 'video'); ?>>Video</option>
                    </select>
                </p>
                <p>
                    <label>Image:</label>
                    <input type="text" name="slide2_image" value="<?php echo esc_attr($slide2_image); ?>" class="widefat" />
                    <button class="button upload_image_button">Upload Image</button>
                </p>
                <p>
                    <label>Video URL (MP4):</label>
                    <input type="text" name="slide2_video" value="<?php echo esc_attr($slide2_video); ?>" class="widefat" />
                </p>
            </div>

            <!-- Slide 3 Content -->
            <div id="slide3" class="tab">
                <h4>Slide 3 Settings</h4>
                <p>
                    <label>Type:</label>
                    <select name="slide3_type">
                        <option value="image" <?php selected($slide3_type, 'image'); ?>>Image</option>
                        <option value="video" <?php selected($slide3_type, 'video'); ?>>Video</option>
                    </select>
                </p>
                <p>
                    <label>Image:</label>
                    <input type="text" name="slide3_image" value="<?php echo esc_attr($slide3_image); ?>" class="widefat" />
                    <button class="button upload_image_button">Upload Image</button>
                </p>
                <p>
                    <label>Video URL (MP4):</label>
                    <input type="text" name="slide3_video" value="<?php echo esc_attr($slide3_video); ?>" class="widefat" />
                </p>
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

    // Save Marquee text
    if (isset($_POST['marquee_text'])) {
        update_post_meta($post_id, '_marquee_text', sanitize_text_field($_POST['marquee_text']));
    }

    // Save Slide 1 data
    update_post_meta($post_id, '_slide1_type', sanitize_text_field($_POST['slide1_type']));
    update_post_meta($post_id, '_slide1_image', sanitize_text_field($_POST['slide1_image']));
    update_post_meta($post_id, '_slide1_video', sanitize_text_field($_POST['slide1_video']));

    // Save Slide 2 data
    update_post_meta($post_id, '_slide2_type', sanitize_text_field($_POST['slide2_type']));
    update_post_meta($post_id, '_slide2_image', sanitize_text_field($_POST['slide2_image']));
    update_post_meta($post_id, '_slide2_video', sanitize_text_field($_POST['slide2_video']));

    // Save Slide 3 data
    update_post_meta($post_id, '_slide3_type', sanitize_text_field($_POST['slide3_type']));
    update_post_meta($post_id, '_slide3_image', sanitize_text_field($_POST['slide3_image']));
    update_post_meta($post_id, '_slide3_video', sanitize_text_field($_POST['slide3_video']));
}
add_action('save_post', 'arata_homepage_save_meta_box_data');

// Enqueue scripts for media uploader
function arata_homepage_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('arata-homepage-admin-js', get_template_directory_uri() . '/assets/js/homepage-admin.js', ['jquery'], null, true);
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
