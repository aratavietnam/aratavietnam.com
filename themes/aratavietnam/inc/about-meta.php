<?php
/**
 * About Page Meta Fields
 *
 * Add meta fields for about page with section images
 */

if (!defined('ABSPATH')) { exit; }

// Prevent fatal errors
if (!function_exists('add_action')) {
    return;
}

// Add meta box for about page section images
function add_about_meta_boxes() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    global $post;
    
    // Only add meta box if this page uses about template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/about.php') {
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
    // Only show for pages using the about template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/about.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "About Page".</p>';
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
    
    // Content fields
    $about_company_intro = get_post_meta($post->ID, 'arata_about_company_intro', true);
    $about_history = get_post_meta($post->ID, 'arata_about_history', true);
    $about_mission = get_post_meta($post->ID, 'arata_about_mission', true);
    $about_values = get_post_meta($post->ID, 'arata_about_values', true);
    $about_commitment = get_post_meta($post->ID, 'arata_about_commitment', true);
    
    // Section visibility
    $show_company_intro = get_post_meta($post->ID, 'arata_show_company_intro', true);
    $show_history = get_post_meta($post->ID, 'arata_show_history', true);
    $show_mission = get_post_meta($post->ID, 'arata_show_mission', true);
    $show_values = get_post_meta($post->ID, 'arata_show_values', true);
    $show_commitment = get_post_meta($post->ID, 'arata_show_commitment', true);
    $show_social_links = get_post_meta($post->ID, 'arata_show_social_links', true);
    ?>
    <table class="about-meta-table">
        <tbody>
            <tr>
                <th><label for="arata_show_hero">Hiển thị Hero Section</label></th>
                <td>
                    <select name="arata_show_hero" id="arata_show_hero">
                        <option value="1" <?php selected($show_hero, '1'); ?>>Có</option>
                        <option value="0" <?php selected($show_hero, '0'); ?>>Không</option>
                    </select>
                    <p class="description">Hiển thị section hero ở đầu trang</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_compact_hero">Hero Section Compact</label></th>
                <td>
                    <select name="arata_compact_hero" id="arata_compact_hero">
                        <option value="1" <?php selected($compact_hero, '1'); ?>>Có</option>
                        <option value="0" <?php selected($compact_hero, '0'); ?>>Không</option>
                    </select>
                    <p class="description">Sử dụng layout compact cho hero section</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_subtitle">Subtitle Hero</label></th>
                <td>
                    <input type="text" id="arata_about_subtitle" name="arata_about_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" class="regular-text">
                    <p class="description">Subtitle hiển thị dưới tiêu đề chính</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_description">Mô tả Hero</label></th>
                <td>
                    <textarea id="arata_about_description" name="arata_about_description" rows="3" class="large-text"><?php echo esc_textarea($hero_description); ?></textarea>
                    <p class="description">Mô tả ngắn cho hero section</p>
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Nội dung các section</h3>
    <table class="about-meta-table">
        <tbody>
            <tr>
                <th><label for="arata_show_company_intro">Hiển thị Section Giới thiệu công ty</label></th>
                <td>
                    <select name="arata_show_company_intro" id="arata_show_company_intro">
                        <option value="1" <?php selected($show_company_intro, '1'); ?>>Có</option>
                        <option value="0" <?php selected($show_company_intro, '0'); ?>>Không</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_company_intro">Nội dung Giới thiệu công ty</label></th>
                <td>
                    <?php
                    wp_editor($about_company_intro, 'arata_about_company_intro', array(
                        'textarea_name' => 'arata_about_company_intro',
                        'textarea_rows' => 10,
                        'media_buttons' => true,
                        'teeny' => false
                    ));
                    ?>
                    <p class="description">Nội dung giới thiệu công ty</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="about-meta-table">
        <tbody>
            <tr>
                <th><label for="arata_show_history">Hiển thị Section Lịch sử</label></th>
                <td>
                    <select name="arata_show_history" id="arata_show_history">
                        <option value="1" <?php selected($show_history, '1'); ?>>Có</option>
                        <option value="0" <?php selected($show_history, '0'); ?>>Không</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_history">Nội dung Lịch sử</label></th>
                <td>
                    <?php
                    wp_editor($about_history, 'arata_about_history', array(
                        'textarea_name' => 'arata_about_history',
                        'textarea_rows' => 10,
                        'media_buttons' => true,
                        'teeny' => false
                    ));
                    ?>
                    <p class="description">Nội dung lịch sử hình thành</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="about-meta-table">
        <tbody>
            <tr>
                <th><label for="arata_show_mission">Hiển thị Section Sứ mệnh</label></th>
                <td>
                    <select name="arata_show_mission" id="arata_show_mission">
                        <option value="1" <?php selected($show_mission, '1'); ?>>Có</option>
                        <option value="0" <?php selected($show_mission, '0'); ?>>Không</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_mission">Nội dung Sứ mệnh</label></th>
                <td>
                    <?php
                    wp_editor($about_mission, 'arata_about_mission', array(
                        'textarea_name' => 'arata_about_mission',
                        'textarea_rows' => 10,
                        'media_buttons' => true,
                        'teeny' => false
                    ));
                    ?>
                    <p class="description">Nội dung sứ mệnh và tầm nhìn</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="about-meta-table">
        <tbody>
            <tr>
                <th><label for="arata_show_values">Hiển thị Section Giá trị</label></th>
                <td>
                    <select name="arata_show_values" id="arata_show_values">
                        <option value="1" <?php selected($show_values, '1'); ?>>Có</option>
                        <option value="0" <?php selected($show_values, '0'); ?>>Không</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_values">Nội dung Giá trị cốt lõi</label></th>
                <td>
                    <?php
                    wp_editor($about_values, 'arata_about_values', array(
                        'textarea_name' => 'arata_about_values',
                        'textarea_rows' => 10,
                        'media_buttons' => true,
                        'teeny' => false
                    ));
                    ?>
                    <p class="description">Nội dung giá trị cốt lõi</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="about-meta-table">
        <tbody>
            <tr>
                <th><label for="arata_show_commitment">Hiển thị Section Cam kết</label></th>
                <td>
                    <select name="arata_show_commitment" id="arata_show_commitment">
                        <option value="1" <?php selected($show_commitment, '1'); ?>>Có</option>
                        <option value="0" <?php selected($show_commitment, '0'); ?>>Không</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="arata_about_commitment">Nội dung Cam kết chất lượng</label></th>
                <td>
                    <?php
                    wp_editor($about_commitment, 'arata_about_commitment', array(
                        'textarea_name' => 'arata_about_commitment',
                        'textarea_rows' => 10,
                        'media_buttons' => true,
                        'teeny' => false
                    ));
                    ?>
                    <p class="description">Nội dung cam kết chất lượng</p>
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Hình ảnh Sections</h3>
    <table class="about-meta-table">
        <tbody><tr>
            <th><label for="arata_section1_image">Hình Section 1<br>(Giới thiệu công ty)</label></th>
            <td>
                <?php if ($section1_image) : ?>
                    <?php echo wp_get_attachment_image($section1_image, 'medium', false, array('class' => 'image-preview')); ?>
                    <br>
                <?php endif; ?>
                <input type="hidden" id="arata_section1_image" name="arata_section1_image" value="<?php echo esc_attr($section1_image); ?>">
                <button type="button" class="button arata-upload-image" data-target="arata_section1_image">Chọn hình ảnh</button>&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section1_image" <?php echo !$section1_image ? 'style="display:none;"' : ''; ?>>Xóa</button>
                <p class="description">Hình ảnh cho section Giới thiệu công ty (bên phải)</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_section2_image">Hình Section 2<br>(Lịch sử & Thành tựu)</label></th>
            <td>
                <?php if ($section2_image) : ?>
                    <?php echo wp_get_attachment_image($section2_image, 'medium', false, array('class' => 'image-preview')); ?>
                    <br>
                <?php endif; ?>
                <input type="hidden" id="arata_section2_image" name="arata_section2_image" value="<?php echo esc_attr($section2_image); ?>">
                <button type="button" class="button arata-upload-image" data-target="arata_section2_image">Chọn hình ảnh</button>&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section2_image" <?php echo !$section2_image ? 'style="display:none;"' : ''; ?>>Xóa</button>
                <p class="description">Hình ảnh cho section Lịch sử & Thành tựu (bên trái)</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_section3_image">Hình Section 3<br>(Sứ mệnh & Tầm nhìn)</label></th>
            <td>
                <?php if ($section3_image) : ?>
                    <?php echo wp_get_attachment_image($section3_image, 'medium', false, array('class' => 'image-preview')); ?>
                    <br>
                <?php endif; ?>
                <input type="hidden" id="arata_section3_image" name="arata_section3_image" value="<?php echo esc_attr($section3_image); ?>">
                <button type="button" class="button arata-upload-image" data-target="arata_section3_image">Chọn hình ảnh</button>&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section3_image" <?php echo !$section3_image ? 'style="display:none;"' : ''; ?>>Xóa</button>
                <p class="description">Hình ảnh cho section Sứ mệnh & Tầm nhìn (bên phải)</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_section4_image">Hình Section 4<br>(Giá trị & Cam kết)</label></th>
            <td>
                <?php if ($section4_image) : ?>
                    <?php echo wp_get_attachment_image($section4_image, 'medium', false, array('class' => 'image-preview')); ?>
                    <br>
                <?php endif; ?>
                <input type="hidden" id="arata_section4_image" name="arata_section4_image" value="<?php echo esc_attr($section4_image); ?>">
                <button type="button" class="button arata-upload-image" data-target="arata_section4_image">Chọn hình ảnh</button>&nbsp;<button type="button" class="button arata-remove-image" data-target="arata_section4_image" <?php echo !$section4_image ? 'style="display:none;"' : ''; ?>>Xóa</button>
                <p class="description">Hình ảnh cho section Giá trị cốt lõi & Cam kết chất lượng (bên trái)</p>
            </td>
        </tr>
    </tbody></table>

    <table class="about-meta-table">
        <tbody><tr>
            <th><label for="arata_show_social_links">Hiển thị Section Liên kết mạng xã hội</label></th>
            <td>
                <select name="arata_show_social_links" id="arata_show_social_links">
                    <option value="1" <?php selected($show_social_links, '1'); ?>>Có</option>
                    <option value="0" <?php selected($show_social_links, '0'); ?>>Không</option>
                </select>
                <p class="description">Hiển thị section liên kết mạng xã hội</p>
            </td>
        </tr>
    </tbody></table>

    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        // Upload image
        $('.arata-upload-image').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var button = $(this);
            
            // If the media frame already exists, reopen it.
            if (frame) {
                frame.open();
                return;
            }
            
            // Create the media frame.
            frame = wp.media({
                title: 'Chọn hình ảnh',
                multiple: false,
                library: { type: 'image' },
                button: { text: 'Sử dụng hình ảnh này' }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.id);
                var preview = button.closest('td').find('.image-preview');
                preview.attr('src', attachment.url);
                preview.attr('srcset', attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url);
                preview.show();
                button.next('.arata-remove-image').show();
            });
            
            frame.on('close', function() {
                // Clean up the frame reference
                frame = null;
            });
            
            frame.open();
        });
        
        // Remove image
        $('.arata-remove-image').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('#' + target).val('');
            $(this).closest('td').find('.image-preview').attr('src', '').hide();
            $(this).hide();
        });
    });
    </script>
    <?php
}

// Save meta fields
function save_about_settings($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['about_section_images_nonce'])) {
        return $post_id;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['about_section_images_nonce'], 'about_section_images_nonce')) {
        return $post_id;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check the user's permissions.
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Sanitize and save the data
    $fields = array(
        'arata_section1_image',
        'arata_section2_image',
        'arata_section3_image',
        'arata_section4_image',
        'arata_show_hero',
        'arata_compact_hero',
        'arata_about_subtitle',
        'arata_about_description',
        'arata_about_company_intro',
        'arata_about_history',
        'arata_about_mission',
        'arata_about_values',
        'arata_about_commitment',
        'arata_show_company_intro',
        'arata_show_history',
        'arata_show_mission',
        'arata_show_values',
        'arata_show_commitment',
        'arata_show_social_links'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if (in_array($field, array('arata_about_company_intro', 'arata_about_history', 'arata_about_mission', 'arata_about_values', 'arata_about_commitment'))) {
                // Allow HTML in content fields
                update_post_meta($post_id, $field, wp_kses_post($_POST[$field]));
            } else {
                // Sanitize other fields
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}

// Add meta box
add_action('add_meta_boxes_page', 'add_about_meta_boxes');

// Save meta fields
add_action('save_post_page', 'save_about_settings');