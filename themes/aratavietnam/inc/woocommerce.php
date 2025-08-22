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

        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        $product_image_id = $_product->get_image_id();
        $product_image_url = $product_image_id
            ? wp_get_attachment_image_url($product_image_id, 'thumbnail')
            : wc_placeholder_img_src();

        $cart_items[] = array(
            'key' => $cart_item_key,
            'name' => $_product->get_name(),
            'quantity' => $cart_item['quantity'],
            'price' => apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key),
            'image' => $product_image_url,
            'url' => get_permalink($product_id)
        );
    }

    wp_send_json_success(array(
        'count' => $cart->get_cart_contents_count(),
        'total' => $cart->get_cart_total(),
        'subtotal' => $cart->get_cart_subtotal(),
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

/**
 * Enqueue WooCommerce AJAX scripts and localize data
 */
function aratavietnam_enqueue_wc_cart_scripts() {
    if (class_exists('WooCommerce')) {
        wp_localize_script('aratavietnam-app', 'wc_add_to_cart_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_nonce' => wp_create_nonce('wc_add_to_cart_nonce'),
            'cart_url' => wc_get_cart_url(),
            'is_cart' => is_cart(),
            'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add')
        ));
    }
}
add_action('wp_enqueue_scripts', 'aratavietnam_enqueue_wc_cart_scripts');
