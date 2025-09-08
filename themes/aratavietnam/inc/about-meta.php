<?php
/**
 * About Page Meta Fields
 *
 * Add meta fields for about page customization similar to blog page
 */

if (!defined('ABSPATH')) { exit; }

// Prevent fatal errors
if (!function_exists('add_action')) {
    return;
}

// Add meta box for about page settings
function add_about_meta_boxes() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    global $post;
    
    
    // Only add meta box if this page uses about template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/about.php') {
        add_meta_box(
            'about_hero_settings',
            __('Cài đặt Hero Section - Về chúng tôi', 'aratavietnam'),
            'about_hero_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
}

function about_hero_settings_callback($post) {
    // Only show for pages using the about template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/about.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "About Page".</p>';
        return;
    }

    wp_nonce_field('about_hero_settings_nonce', 'about_hero_settings_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_show_hero', true);
    $compact_hero = get_post_meta($post->ID, 'arata_compact_hero', true);
    $hero_subtitle = get_post_meta($post->ID, 'arata_about_subtitle', true);
    $hero_description = get_post_meta($post->ID, 'arata_about_description', true);

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
    </style>

    <div class="section-header">Cài đặt Hero Section</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_about_show_hero">Hiển thị Hero Section</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_about_show_hero" name="arata_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    Hiển thị phần hero trên trang về chúng tôi
                </label>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_compact_hero">Chế độ Hero</label></th>
            <td>
                <label>
                    <input type="checkbox" id="arata_about_compact_hero" name="arata_compact_hero" value="1" <?php checked($compact_hero, '1'); ?> />
                    Sử dụng hero nhỏ gọn (thay vì hero đầy đủ)
                </label>
                <p class="description">Hero nhỏ gọn sẽ có chiều cao thấp hơn và thiết kế đơn giản</p>
            </td>
        </tr>
    </table>

    <div class="section-header">Nội dung Hero Section</div>
    <table class="about-meta-table">
        <tr>
            <th><label for="arata_about_subtitle">Tiêu đề Hero</label></th>
            <td>
                <input type="text" id="arata_about_subtitle" name="arata_about_subtitle" value="<?php echo esc_attr($hero_subtitle); ?>" placeholder="Chuyên gia hóa mỹ phẩm Nhật Bản tại Việt Nam" />
                <p class="description">Tiêu đề hiển thị trong hero section</p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_about_description">Mô tả Hero</label></th>
            <td>
                <textarea id="arata_about_description" name="arata_about_description" placeholder="Arata Vietnam tự hào là đối tác tin cậy trong lĩnh vực hóa mỹ phẩm..."><?php echo esc_textarea($hero_description); ?></textarea>
                <p class="description">Mô tả hiển thị dưới tiêu đề trong hero section</p>
            </td>
        </tr>
    </table>
    <?php
}

function save_about_hero_settings($post_id) {
    
    // Verify nonce
    if (!isset($_POST['about_hero_settings_nonce']) || !wp_verify_nonce($_POST['about_hero_settings_nonce'], 'about_hero_settings_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using about template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/about.php') {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = ['arata_show_hero', 'arata_compact_hero'];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }

    // Save text fields
    $text_fields = ['arata_about_subtitle', 'arata_about_description'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'arata_about_description') {
                update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
            } else {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}

// Hook the functions
add_action('add_meta_boxes', 'add_about_meta_boxes');
add_action('save_post', 'save_about_hero_settings');

// Add section settings meta box
function add_about_sections_meta_boxes() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    global $post;
    
    
    // Only add meta box if this page uses about template
    if ($post && get_page_template_slug($post->ID) === 'page-templates/about.php') {
        add_meta_box(
            'arata_about_sections',
            'Cài đặt Sections',
            'about_sections_callback',
            'page',
            'normal',
            'default'
        );
    }
}

function about_sections_callback($post) {
    // Only show for pages using the about template
    $page_template = get_page_template_slug($post->ID);
    if ($page_template !== 'page-templates/about.php') {
        echo '<p>Meta fields này chỉ hiển thị cho trang sử dụng template "About Page".</p>';
        return;
    }

    wp_nonce_field('arata_about_sections_nonce', 'arata_about_sections_nonce');

    $show_company_intro = get_post_meta($post->ID, 'arata_show_company_intro', true);
    $show_history = get_post_meta($post->ID, 'arata_show_history', true);
    $show_mission = get_post_meta($post->ID, 'arata_show_mission', true);
    $show_values = get_post_meta($post->ID, 'arata_show_values', true);
    $show_commitment = get_post_meta($post->ID, 'arata_show_commitment', true);
    $show_social_links = get_post_meta($post->ID, 'arata_show_social_links', true);

    echo '<table class="form-table">';

    // Show Company Intro
    echo '<tr>';
    echo '<th><label for="arata_show_company_intro">Hiển thị Giới thiệu công ty</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="arata_show_company_intro" name="arata_show_company_intro" value="1" ' . checked($show_company_intro !== '0', true, false) . ' />';
    echo '<p class="description">Hiển thị section giới thiệu công ty</p>';
    echo '</td>';
    echo '</tr>';

    // Show History
    echo '<tr>';
    echo '<th><label for="arata_show_history">Hiển thị Lịch sử & Thành tựu</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="arata_show_history" name="arata_show_history" value="1" ' . checked($show_history !== '0', true, false) . ' />';
    echo '<p class="description">Hiển thị section lịch sử và thành tựu</p>';
    echo '</td>';
    echo '</tr>';

    // Show Mission
    echo '<tr>';
    echo '<th><label for="arata_show_mission">Hiển thị Sứ mệnh & Tầm nhìn</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="arata_show_mission" name="arata_show_mission" value="1" ' . checked($show_mission !== '0', true, false) . ' />';
    echo '<p class="description">Hiển thị section sứ mệnh và tầm nhìn</p>';
    echo '</td>';
    echo '</tr>';

    // Show Values
    echo '<tr>';
    echo '<th><label for="arata_show_values">Hiển thị Giá trị cốt lõi</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="arata_show_values" name="arata_show_values" value="1" ' . checked($show_values !== '0', true, false) . ' />';
    echo '<p class="description">Hiển thị section giá trị cốt lõi</p>';
    echo '</td>';
    echo '</tr>';

    // Show Commitment
    echo '<tr>';
    echo '<th><label for="arata_show_commitment">Hiển thị Cam kết chất lượng</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="arata_show_commitment" name="arata_show_commitment" value="1" ' . checked($show_commitment !== '0', true, false) . ' />';
    echo '<p class="description">Hiển thị section cam kết chất lượng</p>';
    echo '</td>';
    echo '</tr>';

    // Show Social Links
    echo '<tr>';
    echo '<th><label for="arata_show_social_links">Hiển thị Mạng xã hội</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="arata_show_social_links" name="arata_show_social_links" value="1" ' . checked($show_social_links !== '0', true, false) . ' />';
    echo '<p class="description">Hiển thị section liên kết mạng xã hội</p>';
    echo '</td>';
    echo '</tr>';

    echo '</table>';
}

function save_about_sections_settings($post_id) {
    // Verify nonce
    if (!isset($_POST['arata_about_sections_nonce']) || !wp_verify_nonce($_POST['arata_about_sections_nonce'], 'arata_about_sections_nonce')) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    // Only save for pages using about template
    $page_template = get_page_template_slug($post_id);
    if ($page_template !== 'page-templates/about.php') {
        return;
    }

    // Save checkbox fields
    $checkbox_fields = [
        'arata_show_company_intro',
        'arata_show_history',
        'arata_show_mission',
        'arata_show_values',
        'arata_show_commitment',
        'arata_show_social_links'
    ];
    foreach ($checkbox_fields as $field) {
        $value = isset($_POST[$field]) ? '1' : '0';
        update_post_meta($post_id, $field, $value);
    }
}

// Hook the section functions
add_action('add_meta_boxes', 'add_about_sections_meta_boxes');
add_action('save_post', 'save_about_sections_settings');
