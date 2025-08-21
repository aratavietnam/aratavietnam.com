<?php
/**
 * WooCommerce functionality for Arata Vietnam theme
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX handlers for cart functionality
 */
add_action('wp_ajax_get_cart_contents', 'aratavietnam_get_cart_contents');
add_action('wp_ajax_nopriv_get_cart_contents', 'aratavietnam_get_cart_contents');

function aratavietnam_get_cart_contents() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'wc_add_to_cart_nonce')) {
        wp_die('Security check failed');
    }


    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }

    $cart = WC()->cart;

    if ($cart->is_empty()) {
        wp_send_json_success(array(
            'count' => 0,
            'total' => wc_price(0),
            'items' => array()
        ));
        return;
    }

    $cart_items = array();

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];

        $cart_items[] = array(
            'key' => $cart_item_key,
            'name' => $product->get_name(),
            'quantity' => $quantity,
            'price' => wc_price($product->get_price() * $quantity),
            'image' => wp_get_attachment_image_url($product->get_image_id(), 'thumbnail'),
            'url' => get_permalink($product_id)
        );
    }

    wp_send_json_success(array(
        'count' => $cart->get_cart_contents_count(),
        'total' => wc_price($cart->get_cart_total()),
        'subtotal' => wc_price($cart->get_subtotal()),
        'items' => $cart_items
    ));
}

add_action('wp_ajax_remove_cart_item', 'aratavietnam_remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'aratavietnam_remove_cart_item');

function aratavietnam_remove_cart_item() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'wc_add_to_cart_nonce')) {
        wp_die('Security check failed');
    }

    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

    if (WC()->cart->remove_cart_item($cart_item_key)) {
        wp_send_json_success(array(
            'count' => WC()->cart->get_cart_contents_count(),
            'total' => wc_price(WC()->cart->get_cart_total()),
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng'
        ));
    } else {
        wp_send_json_error('Không thể xóa sản phẩm');
    }
}

/**
 * WooCommerce Support
 */
function aratavietnam_woocommerce_setup() {
    // Add WooCommerce support
    add_theme_support('woocommerce');

    // Add support for WC features
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'aratavietnam_woocommerce_setup');

/**
 * Remove WooCommerce default styles
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Customize WooCommerce wrapper
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'aratavietnam_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'aratavietnam_woocommerce_wrapper_end', 10);

function aratavietnam_woocommerce_wrapper_start() {
    echo '<div class="container mx-auto py-8">';
}

function aratavietnam_woocommerce_wrapper_end() {
    echo '</div>';
}

/**
 * Change number of products per row
 */
function aratavietnam_woocommerce_loop_columns() {
    return 3; // 3 products per row
}
add_filter('loop_shop_columns', 'aratavietnam_woocommerce_loop_columns');

/**
 * Change number of products per page
 */
function aratavietnam_woocommerce_products_per_page() {
    return 12; // 12 products per page
}
add_filter('loop_shop_per_page', 'aratavietnam_woocommerce_products_per_page', 20);
