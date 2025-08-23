<?php
/**
 * Product Pages Assets Handler
 * Enqueues JavaScript and CSS for product pages
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue product page assets


    if (is_singular('product')) {
        wp_enqueue_script(
            'aratavietnam-product-single',
            get_template_directory_uri() . '/resources/js/product-single.js',
            [],
            filemtime(get_template_directory() . '/resources/js/product-single.js'),
            true
        );
    }
 */
function aratavietnam_enqueue_product_assets() {
    // Get theme version for cache busting
    $theme_version = wp_get_theme()->get('Version');

    // Enqueue product pages CSS
    wp_enqueue_style(
        'aratavietnam-product-pages',
        get_template_directory_uri() . '/resources/css/product-pages.css',
        array(),
        $theme_version
    );

    // Enqueue single product page JS
    if (is_product()) {
        wp_enqueue_script(
            'aratavietnam-product-single',
            get_template_directory_uri() . '/resources/js/product-single.js',
            array(),
            $theme_version,
            true
        );

        // Localize script with product data
        global $post;
        $product = wc_get_product($post->ID);

        if ($product) {
            wp_localize_script('aratavietnam-product-single', 'productData', array(
                'id' => $product->get_id(),
                'type' => $product->get_type(),
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('product_nonce'),
                'currency_symbol' => get_woocommerce_currency_symbol(),
                'strings' => array(
                    'adding_to_cart' => __('Đang thêm...', 'aratavietnam'),
                    'add_to_cart' => __('Thêm vào giỏ hàng', 'aratavietnam'),
                    'added_to_cart' => __('Đã thêm vào giỏ hàng', 'aratavietnam'),
                    'error' => __('Có lỗi xảy ra', 'aratavietnam'),
                )
            ));
        }
    }

    // Enqueue product archive page JS
    if (is_shop() || is_product_category() || is_product_tag() || is_tax('product_brand')) {
        wp_enqueue_script(
            'aratavietnam-product-archive',
            get_template_directory_uri() . '/resources/js/product-archive.js',
            array('jquery'),
            $theme_version,
            true
        );

        // Localize script with archive data
        wp_localize_script('aratavietnam-product-archive', 'archiveData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('archive_nonce'),
            'current_url' => get_pagenum_link(),
            'strings' => array(
                'loading' => __('Đang tải...', 'aratavietnam'),
                'no_products' => __('Không tìm thấy sản phẩm', 'aratavietnam'),
                'clear_filters' => __('Xóa bộ lọc', 'aratavietnam'),
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'aratavietnam_enqueue_product_assets');

/**
 * Add product page body classes
 */
function aratavietnam_product_body_classes($classes) {
    if (is_product()) {
        $classes[] = 'single-product-page';
    }

    if (is_shop() || is_product_category() || is_product_tag()) {
        $classes[] = 'product-archive-page';
    }

    return $classes;
}
add_filter('body_class', 'aratavietnam_product_body_classes');

/**
 * Add inline CSS variables for product pages
 */
function aratavietnam_product_css_variables() {
    if (is_product() || is_shop() || is_product_category() || is_product_tag()) {
        $primary_color = get_theme_mod('primary_color', '#3b82f6');
        $secondary_color = get_theme_mod('secondary_color', '#10b981');

        echo "<style>:root { --primary-color: {$primary_color}; --secondary-color: {$secondary_color}; }</style>\n";
    }
}
add_action('wp_head', 'aratavietnam_product_css_variables');

/**
 * Filter products on the archive page
 */
function aratavietnam_filter_products_query($query) {
    // Only modify the main query on the frontend for product archives
    if (is_admin() || !$query->is_main_query() || !is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
        return;
    }

    $meta_query = $query->get('meta_query') ? $query->get('meta_query') : [];
    $tax_query = $query->get('tax_query') ? $query->get('tax_query') : [];

    // Price filter
    if (isset($_GET['price_filter']) && $_GET['price_filter'] !== 'all') {
        $price_filter = sanitize_text_field($_GET['price_filter']);
        $price_range = explode('-', $price_filter);

        if (count($price_range) === 2) {
            $meta_query[] = [
                'key' => '_price',
                'value' => [$price_range[0], $price_range[1]],
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN'
            ];
        } elseif (strpos($price_filter, '+') !== false) {
            $min_price = str_replace('+', '', $price_filter);
            $meta_query[] = [
                'key' => '_price',
                'value' => $min_price,
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        }
    }

    // Brand filter
    if (isset($_GET['brand_filter']) && !empty($_GET['brand_filter'])) {
        $brands = explode(',', sanitize_text_field($_GET['brand_filter']));
        $tax_query[] = [
            'taxonomy' => 'product_brand',
            'field'    => 'slug',
            'terms'    => $brands,
            'operator' => 'IN',
        ];
    }

    // Set the modified queries back to the main query object
    if (!empty($meta_query)) {
        $query->set('meta_query', $meta_query);
    }
    if (!empty($tax_query)) {
        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'aratavietnam_filter_products_query');
