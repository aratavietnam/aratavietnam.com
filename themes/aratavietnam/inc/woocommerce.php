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
 * AJAX handler for enhanced add to cart
 */
add_action('wp_ajax_arata_add_to_cart', 'aratavietnam_ajax_add_to_cart');
add_action('wp_ajax_nopriv_arata_add_to_cart', 'aratavietnam_ajax_add_to_cart');

function aratavietnam_ajax_add_to_cart() {
    // Debug logging
    error_log('ARATA ADD TO CART: ' . print_r($_POST, true));

    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce not active');
        return;
    }

    // Verify nonce - make it optional for now to debug
    $nonce = $_POST['nonce'] ?? '';
    if (!empty($nonce) && !wp_verify_nonce($nonce, 'arata_add_to_cart_nonce')) {
        wp_send_json_error([
            'message' => 'Security check failed',
            'debug' => 'Nonce verification failed'
        ]);
        return;
    }

    $product_id = absint($_POST['product_id'] ?? 0);
    $quantity = absint($_POST['quantity'] ?? 1);
    $variation_id = absint($_POST['variation_id'] ?? 0);

    if (!$product_id) {
        wp_send_json_error([
            'message' => 'Không thể xác định sản phẩm'
        ]);
        return;
    }

    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error([
            'message' => 'Sản phẩm không tồn tại'
        ]);
        return;
    }

    // Check stock status
    if (!$product->is_in_stock()) {
        wp_send_json_error([
            'message' => 'Sản phẩm đã hết hàng',
            'type' => 'out_of_stock'
        ]);
        return;
    }

    // Check if we have enough quantity in stock
    $stock_quantity = $product->get_stock_quantity();
    $current_cart_quantity = 0;

    // Check current quantity in cart
    if (WC()->cart) {
        foreach (WC()->cart->get_cart() as $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                $current_cart_quantity += $cart_item['quantity'];
            }
        }
    }

    $total_requested = $current_cart_quantity + $quantity;

    if ($stock_quantity !== null && $total_requested > $stock_quantity) {
        $remaining = max(0, $stock_quantity - $current_cart_quantity);

        if ($remaining == 0) {
            wp_send_json_error([
                'message' => 'Bạn đã có tất cả sản phẩm có sẵn trong giỏ hàng',
                'type' => 'cart_full',
                'stock_quantity' => $stock_quantity,
                'cart_quantity' => $current_cart_quantity
            ]);
        } else {
            wp_send_json_error([
                'message' => sprintf('Chỉ có thể thêm %d sản phẩm nữa (còn lại %d trong kho)', $remaining, $stock_quantity),
                'type' => 'insufficient_stock',
                'stock_quantity' => $stock_quantity,
                'cart_quantity' => $current_cart_quantity,
                'remaining' => $remaining
            ]);
        }
        return;
    }

    // Add to cart
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

    if (!$passed_validation) {
        wp_send_json_error([
            'message' => 'Không thể thêm sản phẩm vào giỏ hàng'
        ]);
        return;
    }

    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id);

    if ($cart_item_key) {
        wp_send_json_success([
            'message' => sprintf('Đã thêm "%s" vào giỏ hàng', $product->get_name()),
            'product_name' => $product->get_name(),
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_cart_total(),
            'cart_url' => wc_get_cart_url()
        ]);
    } else {
        wp_send_json_error([
            'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng'
        ]);
    }
}

/**
 * Enqueue WooCommerce AJAX scripts and localize data
 */
function aratavietnam_enqueue_wc_cart_scripts() {
    if (class_exists('WooCommerce')) {
        wp_localize_script('aratavietnam-app', 'wc_add_to_cart_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_nonce' => wp_create_nonce('wc_add_to_cart_nonce'),
            'arata_ajax_nonce' => wp_create_nonce('arata_add_to_cart_nonce'),
            'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#',
            'is_cart' => function_exists('is_cart') ? is_cart() : false,
            'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add')
        ));
    }
}
add_action('wp_enqueue_scripts', 'aratavietnam_enqueue_wc_cart_scripts');
