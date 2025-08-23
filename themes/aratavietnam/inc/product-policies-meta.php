<?php
/**
 * Adds a meta box for custom sales policies on the product edit screen.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// 1. Add Meta Box to Product Edit Screen
add_action('add_meta_boxes', 'aratavietnam_add_policies_meta_box');
function aratavietnam_add_policies_meta_box() {
    add_meta_box(
        'aratavietnam_sales_policies',
        __('Chính sách bán hàng tùy chỉnh', 'aratavietnam'),
        'aratavietnam_policies_meta_box_html',
        'product',
        'normal',
        'high'
    );
}

// 2. Render Meta Box HTML
function aratavietnam_policies_meta_box_html($post) {
    wp_nonce_field('aratavietnam_save_policies_meta', 'aratavietnam_policies_nonce');

    $policy1 = get_post_meta($post->ID, '_arata_policy_commitment', true);
    $policy2 = get_post_meta($post->ID, '_arata_policy_shipping', true);
    $policy3 = get_post_meta($post->ID, '_arata_policy_returns', true);
    ?>
    <p class="description">
        <?php _e('Nhập nội dung cho các chính sách bán hàng. Nếu để trống, hệ thống sẽ sử dụng chính sách mặc định.', 'aratavietnam'); ?>
    </p>
    <table class="form-table">
        <tr>
            <th><label for="arata_policy_commitment"><?php _e('Chính sách 1 (Cam kết)', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" id="arata_policy_commitment" name="arata_policy_commitment" class="widefat" value="<?php echo esc_attr($policy1); ?>" placeholder="Ví dụ: Cam kết 100% sản phẩm chính hãng.">
            </td>
        </tr>
        <tr>
            <th><label for="arata_policy_shipping"><?php _e('Chính sách 2 (Giao hàng)', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" id="arata_policy_shipping" name="arata_policy_shipping" class="widefat" value="<?php echo esc_attr($policy2); ?>" placeholder="Ví dụ: Giao hàng toàn quốc, thanh toán linh hoạt.">
            </td>
        </tr>
        <tr>
            <th><label for="arata_policy_returns"><?php _e('Chính sách 3 (Đổi trả)', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" id="arata_policy_returns" name="arata_policy_returns" class="widefat" value="<?php echo esc_attr($policy3); ?>" placeholder="Ví dụ: Hỗ trợ đổi trả trong 7 ngày.">
            </td>
        </tr>
    </table>
    <?php
}

// 3. Save Meta Box Data
add_action('save_post_product', 'aratavietnam_save_policies_meta_data');
function aratavietnam_save_policies_meta_data($post_id) {
    // Check nonce
    if (!isset($_POST['aratavietnam_policies_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['aratavietnam_policies_nonce']), 'aratavietnam_save_policies_meta')) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize and save data
    $fields = [
        'arata_policy_commitment',
        'arata_policy_shipping',
        'arata_policy_returns'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, '_' . $field);
        }
    }
}
