<?php
/**
 * About Page New Layout Meta Fields
 *
 * Add meta fields for about page new layout with section images
 */

if (!defined('ABSPATH')) { exit; }

// Prevent fatal errors
if (!function_exists('add_action')) {
    return;
}

// Add meta box for about page section images
function add_about_new_meta_boxes() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    global $post;
    
    // Only add meta box if this page uses about-new template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/about-new.php') {
        add_meta_box(
            'about_section_images',
            __('Hình ảnh Sections - Về chúng tôi', 'aratavietnam'),
            'about_section_images_callback',
            'page',
            'normal',
            'high'
        );
    }
}

function about_section_images_callback($post) {
    // Only show for pages using the about-new template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/about-new.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "About Page - New Layout".</p>';
        return;
    }

    wp_nonce_field('about_section_images_nonce', 'about_section_images_nonce');

    // Get current values
    $section1_image = get_post_meta($post->ID, 'arata_section1_image', true);
    $section2_image = get_post_meta($post->ID, 'arata_section2_image', true);
    $section3_image = get_post_meta($post->ID, 'arata_section3_image', true);
    $section4_image = get_post_meta($post->ID, 'arata_section4_image', true);

    // Hero settings
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'arata_about_subtitle', true);
    $hero_description = get_post_meta($post->ID, 'arata_about_description', true);

    // Section visibility
    $show_company_intro = get_post_meta($post->ID, 'arata_show_company_intro', true);
    $show_history = get_post_meta($post->ID, 'arata_show_history', true);
    $show_mission = get_post_meta($post->ID, 'arata_show_mission', true);
    $show_values = get_post_meta($post->ID, 'arata_show_values', true);
    $show_commitment = get_post_meta($post->ID, 'arata_show_commitment', true);
    $show_social_links = get_post_meta($post->ID, 'arata_show_social_links', true);

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
        .image-preview { max-width: 300px; margin-top: 10px; }
        .image-preview img { max-width: 100%; height: auto; border: 1px solid #ddd; }
    </style>

    <!-- Hero Settings -->
    <div class="section-header">Cài đặt Hero Section</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_show_hero_new">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_hero_new" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero trên trang về chúng tôi
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_compact_hero_new">Chế độ Hero</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_compact_hero_new" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_subtitle_new">Tiêu đề Hero</label></th>
            <td>
                <input type="text" id="arata_about_subtitle_new" name="arata_about_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Chuyên gia hóa mỹ phẩm Nhật Bản tại Việt Nam" />
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_description_new">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_about_description_new" name="arata_about_description" placeholder="Arata Vietnam tự hào là đối tác tin cậy trong lĩnh vực hóa mỹ phẩm..."><?php echo esc_textarea($hero_description); ?></textarea>
            </td>
        </tr>
    </table>

    <!-- Section Images -->
    <div class="section-header">Hình ảnh Sections</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_section1_image">Hình Section 1<br/>(Giới thiệu công ty)</label></th>
            <td>
                <?php 
                echo wp_get_attachment_image($section1_image, 'medium', false, array('class' => 'image-preview'));
                echo '<br/>';
                echo '<input type="hidden" id="arata_section1_image" name="arata_section1_image" value="' . esc_attr($section1_image) . '" />';
                echo '<button type="button" class="button arata-upload-image" data-target="arata_section1_image">Chọn hình ảnh</button>';
                if ($section1_image) {
                    echo '&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section1_image">Xóa</button>';
                }
                ?>
                <p class="description">Hình ảnh cho section Giới thiệu công ty (bên phải)</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_section2_image">Hình Section 2<br/>(Lịch sử & Thành tựu)</label></th>
            <td>
                <?php 
                echo wp_get_attachment_image($section2_image, 'medium', false, array('class' => 'image-preview'));
                echo '<br/>';
                echo '<input type="hidden" id="arata_section2_image" name="arata_section2_image" value="' . esc_attr($section2_image) . '" />';
                echo '<button type="button" class="button arata-upload-image" data-target="arata_section2_image">Chọn hình ảnh</button>';
                if ($section2_image) {
                    echo '&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section2_image">Xóa</button>';
                }
                ?>
                <p class="description">Hình ảnh cho section Lịch sử & Thành tựu (bên trái)</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_section3_image">Hình Section 3<br/>(Sứ mệnh & Tầm nhìn)</label></th>
            <td>
                <?php 
                echo wp_get_attachment_image($section3_image, 'medium', false, array('class' => 'image-preview'));
                echo '<br/>';
                echo '<input type="hidden" id="arata_section3_image" name="arata_section3_image" value="' . esc_attr($section3_image) . '" />';
                echo '<button type="button" class="button arata-upload-image" data-target="arata_section3_image">Chọn hình ảnh</button>';
                if ($section3_image) {
                    echo '&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section3_image">Xóa</button>';
                }
                ?>
                <p class="description">Hình ảnh cho section Sứ mệnh & Tầm nhìn (bên phải)</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_section4_image">Hình Section 4<br/>(Giá trị & Cam kết)</label></th>
            <td>
                <?php 
                echo wp_get_attachment_image($section4_image, 'medium', false, array('class' => 'image-preview'));
                echo '<br/>';
                echo '<input type="hidden" id="arata_section4_image" name="arata_section4_image" value="' . esc_attr($section4_image) . '" />';
                echo '<button type="button" class="button arata-upload-image" data-target="arata_section4_image">Chọn hình ảnh</button>';
                if ($section4_image) {
                    echo '&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section4_image">Xóa</button>';
                }
                ?>
                <p class="description">Hình ảnh cho section Giá trị cốt lõi & Cam kết chất lượng (bên trái)</p>
            </td>
        </tr>
    </table>

    <!-- Section Content -->
    <div class="section-header">Nội dung Sections</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_about_company_intro_content">Giới thiệu công ty</label></th>
            <td>
                <?php 
                $company_intro = get_post_meta($post->ID, 'arata_about_company_intro', true);
                wp_editor($company_intro, 'arata_about_company_intro', array(
                    'textarea_name' => 'arata_about_company_intro',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => true
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_history_content">Lịch sử & Thành tựu</label></th>
            <td>
                <?php 
                $history = get_post_meta($post->ID, 'arata_about_history', true);
                wp_editor($history, 'arata_about_history', array(
                    'textarea_name' => 'arata_about_history',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => true
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_mission_content">Sứ mệnh & Tầm nhìn</label></th>
            <td>
                <?php 
                $mission = get_post_meta($post->ID, 'arata_about_mission', true);
                wp_editor($mission, 'arata_about_mission', array(
                    'textarea_name' => 'arata_about_mission',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => true
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_values_content">Giá trị cốt lõi</label></th>
            <td>
                <?php 
                $values = get_post_meta($post->ID, 'arata_about_values', true);
                wp_editor($values, 'arata_about_values', array(
                    'textarea_name' => 'arata_about_values',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => true
                ));
                ?>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_commitment_content">Cam kết chất lượng</label></th>
            <td>
                <?php 
                $commitment = get_post_meta($post->ID, 'arata_about_commitment', true);
                wp_editor($commitment, 'arata_about_commitment', array(
                    'textarea_name' => 'arata_about_commitment',
                    'textarea_rows' => 10,
                    'media_buttons' => true,
                    'teeny' => true
                ));
                ?>
            </td>
        </tr>
    </table>

    <!-- Section Visibility -->
    <div class="section-header">Hiển thị Sections</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_show_company_intro_new">Giới thiệu công ty</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_company_intro_new" name="arata_show_company_intro" value="1" <?php checked($show_company_intro, '1'); ?> />
                    Hiển thị section giới thiệu công ty
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_history_new">Lịch sử & Thành tựu</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_history_new" name="arata_show_history" value="1" <?php checked($show_history, '1'); ?> />
                    Hiển thị section lịch sử và thành tựu
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_mission_new">Sứ mệnh & Tầm nhìn</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_mission_new" name="arata_show_mission" value="1" <?php checked($show_mission, '1'); ?> />
                    Hiển thị section sứ mệnh và tầm nhìn
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_values_new">Giá trị cốt lõi</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_values_new" name="arata_show_values" value="1" <?php checked($show_values, '1'); ?> />
                    Hiển thị section giá trị cốt lõi
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_commitment_new">Cam kết chất lượng</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_commitment_new" name="arata_show_commitment" value="1" <?php checked($show_commitment, '1'); ?> />
                    Hiển thị section cam kết chất lượng
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_show_social_links_new">Mạng xã hội</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_show_social_links_new" name="arata_show_social_links" value="1" <?php checked($show_social_links, '1'); ?> />
                    Hiển thị section liên kết mạng xã hội
                </label>
            </td>
        </tr>
    </table>

    <script>
    jQuery(document).ready(function($) {
        // Upload image
        $('.arata-upload-image').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var button = $(this);
            
            var frame = wp.media({
                title: 'Chọn hình ảnh',
                multiple: false,
                library: { type: 'image' },
                button: { text: 'Sử dụng hình ảnh này' }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.id);
                button.prev('.image-preview').attr('src', attachment.url).show();
                button.next('.arata-remove-image').show();
            });
            
            frame.open();
        });
        
        // Remove image
        $('.arata-remove-image').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('#' + target).val('');
            $(this).prev().prev('.image-preview').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
}

function save_about_new_settings($post_id) {
    // Verify nonce
    if (!isset($_POST['about_section_images_nonce']) || !wp_verify_nonce($_POST['about_section_images_nonce'], 'about_section_images_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using about-new template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/about-new.php') {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = [
        'arata_show_hero',
        'arata_compact_hero',
        'arata_show_company_intro',
        'arata_show_history',
        'arata_show_mission',
        'arata_show_values',
        'arata_show_commitment',
        'arata_show_social_links'
    ];
    foreach ($checkbox_fields as $field) {
        // For unchecked checkboxes, WordPress doesn't send them in POST
        // So we need to check if they exist in POST data
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, '1');
        } else {
            update_post_meta($post_id, $field, '0');
        }
    }

    // Save text fields
    $text_fields = [
        'arata_about_subtitle',
        'arata_about_description'
    ];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'arata_about_description') {
                update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
            } else {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    // Save HTML content fields
    $content_fields = [
        'arata_about_company_intro',
        'arata_about_history',
        'arata_about_mission',
        'arata_about_values',
        'arata_about_commitment'
    ];
    foreach ($content_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, wp_kses_post($_POST[$field]));
        }
    }

    // Save image fields
    $image_fields = [
        'arata_section1_image',
        'arata_section2_image',
        'arata_section3_image',
        'arata_section4_image'
    ];
    foreach ($image_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, absint($_POST[$field]));
        }
    }
}

// Hook the functions
add_action('add_meta_boxes', 'add_about_new_meta_boxes');
add_action('save_post', 'save_about_new_settings');