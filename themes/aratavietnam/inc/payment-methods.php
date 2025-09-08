<?php
/**
 * Payment methods configuration for Arata Vietnam
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Setup COD payment method
 */
function arata_setup_cod_payment() {
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Enable COD payment method
    update_option('woocommerce_cod_enabled', 'yes');
    
    // Configure COD settings for Vietnamese market
    update_option('woocommerce_cod_title', 'Thanh toán khi nhận hàng (COD)');
    update_option('woocommerce_cod_description', 'Thanh toán tiền mặt trực tiếp khi nhận hàng');
    update_option('woocommerce_cod_instructions', 'Vui lòng chuẩn bị đủ số tiền khi nhận hàng. Nhân viên giao hàng sẽ liên hệ trước khi giao.');
    
    // Enable COD for all shipping methods and virtual orders
    update_option('woocommerce_cod_enable_for_methods', array());
    update_option('woocommerce_cod_enable_for_virtual', 'yes');
    
    // Set default order status for COD orders
    update_option('woocommerce_cod_process_order_status', 'processing');
    
    // Log the setup
    if (WP_DEBUG && WP_DEBUG_LOG) {
        error_log('Arata Vietnam: COD payment method configured');
    }
}
add_action('woocommerce_init', 'arata_setup_cod_payment');

/**
 * Filter COD payment gateway title on checkout page
 */
function arata_cod_gateway_title($title, $id) {
    if ($id === 'cod') {
        return 'Thanh toán khi nhận hàng';
    }
    return $title;
}
add_filter('woocommerce_gateway_title', 'arata_cod_gateway_title', 10, 2);

/**
 * Add custom description for COD payment method
 */
function arata_cod_gateway_description($description, $id) {
    if ($id === 'cod') {
        return '<p style="font-size: 14px; color: #666;">Thanh toán bằng tiền mặt khi nhận hàng. Phù hợp với khách hàng muốn kiểm tra sản phẩm trước khi thanh toán.</p>';
    }
    return $description;
}
add_filter('woocommerce_gateway_description', 'arata_cod_gateway_description', 10, 2);

/**
 * Display COD availability notice on product page
 */
function arata_display_cod_notice() {
    if (class_exists('WooCommerce') && is_product()) {
        $cod_enabled = get_option('woocommerce_cod_enabled') === 'yes';
        if ($cod_enabled) {
            echo '<div class="cod-notice" style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 10px; font-size: 14px;">';
            echo '<i class="fas fa-money-bill-wave" style="color: #28a745; margin-right: 5px;"></i>';
            echo '<strong>Hỗ trợ thanh toán khi nhận hàng (COD)</strong>';
            echo '</div>';
        }
    }
}
add_action('woocommerce_single_product_summary', 'arata_display_cod_notice', 35);

/**
 * Add COD information to order confirmation email
 */
function arata_add_cod_to_email($order, $sent_to_admin, $plain_text, $email) {
    if ($order->get_payment_method() === 'cod') {
        if ($plain_text) {
            echo "\n\n" . strtoupper('Hình thức thanh toán') . "\n";
            echo "Thanh toán khi nhận hàng (COD)\n";
            echo "Vui lòng chuẩn bị số tiền: " . $order->get_total() . " " . $order->get_currency() . "\n";
        } else {
            echo '<h2 style="color: #F55E25;">Hình thức thanh toán</h2>';
            echo '<p><strong>Thanh toán khi nhận hàng (COD)</strong></p>';
            echo '<p>Vui lòng chuẩn bị số tiền: <strong>' . $order->get_total() . ' ' . $order->get_currency() . '</strong></p>';
        }
    }
}
add_action('woocommerce_email_after_order_table', 'arata_add_cod_to_email', 10, 4);