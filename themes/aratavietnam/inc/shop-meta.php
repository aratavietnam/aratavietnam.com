<?php
/**
 * Shop Page Meta Box Management
 *
 * Manages meta boxes for Shop (WooCommerce) Page only
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes only for Shop Page (WooCommerce shop page)
 */
add_action('add_meta_boxes', 'arata_add_shop_meta_boxes');

function arata_add_shop_meta_boxes() {
    // Only add meta box for the WooCommerce shop page
    $shop_page_id = wc_get_page_id('shop');

    if ($shop_page_id > 0) {
        add_meta_box(
            'arata_shop_page_settings',
            __('Cài đặt trang sản phẩm', 'aratavietnam'),
            'arata_shop_page_meta_callback',
            'page',
            'normal',
            'high'
        );
    }
}

/**
 * Meta box callback function
 */
function arata_shop_page_meta_callback($post) {
    // Only show for shop page
    $shop_page_id = wc_get_page_id('shop');
    if ($post->ID !== $shop_page_id) {
        return;
    }

    // Add nonce for security
    wp_nonce_field('arata_shop_page_meta_save', 'arata_shop_page_meta_nonce');

    // Get current values
    $show_hero = get_post_meta($post->ID, 'arata_shop_show_hero', true);
    $hero_title = get_post_meta($post->ID, 'arata_shop_hero_title', true);
    $hero_description = get_post_meta($post->ID, 'arata_shop_hero_description', true);
    $hero_indicator = get_post_meta($post->ID, 'arata_shop_hero_indicator', true);

    // Set defaults if empty
    if (empty($hero_title)) {
        $hero_title = 'Khám phá sản phẩm chất lượng cao';
    }
    if (empty($hero_description)) {
        $hero_description = 'Các sản phẩm hóa mỹ phẩm được nhập khẩu trực tiếp từ Nhật Bản, đảm bảo chất lượng và an toàn cho người sử dụng';
    }
    if (empty($hero_indicator)) {
        $hero_indicator = 'Sản phẩm';
    }

    ?>
    <div class="arata-shop-meta">
        <style>
        .arata-shop-meta .form-table th {
            width: 200px;
            padding: 15px 10px 15px 0;
        }
        .arata-shop-meta .form-table td {
            padding: 15px 10px;
        }
        .arata-shop-meta .section-header {
            background: #f1f1f1;
            padding: 10px 15px;
            margin: 20px 0 10px 0;
            border-left: 4px solid #0073aa;
            font-weight: bold;
        }
        .arata-shop-meta input[type="text"],
        .arata-shop-meta textarea {
            width: 100%;
        }
        .arata-shop-meta textarea {
            height: 80px;
        }
        </style>

        <div class="section-header">Hero Section</div>
        <table class="form-table">
            <tr>
                <th><label for="arata_shop_show_hero">Hiển thị Hero Section</label></th>
                <td>
                    <input type="checkbox" id="arata_shop_show_hero" name="arata_shop_show_hero" value="1" <?php checked($show_hero, '1'); ?> />
                    <p class="description">Hiển thị phần hero ở đầu trang sản phẩm</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_shop_hero_title">Tiêu đề Hero</label></th>
                <td>
                    <input type="text" id="arata_shop_hero_title" name="arata_shop_hero_title" value="<?php echo esc_attr($hero_title); ?>" placeholder="Khám phá sản phẩm chất lượng cao" />
                    <p class="description">Tiêu đề chính của hero section</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_shop_hero_description">Mô tả Hero</label></th>
                <td>
                    <textarea id="arata_shop_hero_description" name="arata_shop_hero_description" placeholder="Các sản phẩm hóa mỹ phẩm được nhập khẩu trực tiếp từ Nhật Bản..."><?php echo esc_textarea($hero_description); ?></textarea>
                    <p class="description">Mô tả ngắn về sản phẩm</p>
                </td>
            </tr>
            <tr>
                <th><label for="arata_shop_hero_indicator">Text Indicator</label></th>
                <td>
                    <input type="text" id="arata_shop_hero_indicator" name="arata_shop_hero_indicator" value="<?php echo esc_attr($hero_indicator); ?>" placeholder="Sản phẩm" />
                    <p class="description">Text hiển thị trên thanh indicator</p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Save meta box data
 */
add_action('save_post', 'arata_save_shop_page_meta');

function arata_save_shop_page_meta($post_id) {
    // Only process shop page
    $shop_page_id = wc_get_page_id('shop');
    if ($post_id !== $shop_page_id) {
        return;
    }

    // Verify nonce
    if (!isset($_POST['arata_shop_page_meta_nonce']) || !wp_verify_nonce($_POST['arata_shop_page_meta_nonce'], 'arata_shop_page_meta_save')) {
        return;
    }

    // Check if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save hero show checkbox
    $show_hero = isset($_POST['arata_shop_show_hero']) ? '1' : '0';
    update_post_meta($post_id, 'arata_shop_show_hero', $show_hero);

    // Save text fields
    $text_fields = [
        'arata_shop_hero_title',
        'arata_shop_hero_description',
        'arata_shop_hero_indicator'
    ];

    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'arata_shop_hero_description') {
                update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
            } else {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}

/**
 * Hide meta box for non-shop pages
 */
add_action('admin_head', 'arata_hide_shop_meta_for_non_shop');

function arata_hide_shop_meta_for_non_shop() {
    global $post;

    if (!$post || get_post_type($post) !== 'page') {
        return;
    }

    $shop_page_id = wc_get_page_id('shop');

    // Hide shop meta box if not shop page
    if ($post->ID !== $shop_page_id) {
        ?>
        <style>
        #arata_shop_page_settings {
            display: none !important;
        }
        </style>
        <?php
    }
}
