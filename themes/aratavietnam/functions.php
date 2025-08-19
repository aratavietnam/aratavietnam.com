<?php

if (is_file(__DIR__.'/vendor/autoload_packages.php')) {
    require_once __DIR__.'/vendor/autoload_packages.php';
}

function aratavietnam(): TailPress\Framework\Theme
{
    $viteCompiler = new TailPress\Framework\Assets\ViteCompiler;
    $viteCompiler->handle = 'aratavietnam';

    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler($viteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
            )
            ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager
            ->add('primary', __( 'Primary Menu', 'aratavietnam'))
            ->add('footer-menu-1', __( 'Footer Menu 1', 'aratavietnam'))
            ->add('footer-menu-2', __( 'Footer Menu 2', 'aratavietnam'))
        )
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'woocommerce',
            'wc-product-gallery-zoom',
            'wc-product-gallery-lightbox',
            'wc-product-gallery-slider',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

aratavietnam();

// AJAX handlers for cart functionality
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
 * Preload fonts for better performance
 */
function aratavietnam_preload_fonts() {
    // Preload Google Fonts for Vietnamese support
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // Preload Inter font (primary choice for Vietnamese)
    echo '<link rel="preload" href="https://fonts.gstatic.com/s/inter/v12/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuLyfAZ9hiA.woff2" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
}
add_action('wp_head', 'aratavietnam_preload_fonts', 1);

/**
 * Add critical CSS for Vietnamese font optimization
 */
function aratavietnam_critical_font_css() {
    echo '<style>
        /* Critical font CSS - inline for immediate rendering */
        body {
            font-family: "Inter", "Source Sans Pro", "Noto Sans", "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            font-display: swap;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Vietnamese text optimization */
        :lang(vi) {
            font-family: "Inter", "Source Sans Pro", "Noto Sans", "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.7;
            letter-spacing: 0.01em;
        }

        /* Ensure proper rendering of Vietnamese diacritics */
        * {
            font-feature-settings: "kern" 1, "liga" 1;
            text-rendering: optimizeLegibility;
        }
    </style>' . "\n";
}
add_action('wp_head', 'aratavietnam_critical_font_css', 2);

/**
 * Add Vietnamese language support
 */
function aratavietnam_vietnamese_support() {
    // Set proper charset for Vietnamese
    add_filter('wp_charset_collate', function($charset_collate) {
        return 'utf8mb4_unicode_ci';
    });

    // Ensure proper text rendering
    add_action('wp_head', function() {
        echo '<meta name="format-detection" content="telephone=no">' . "\n";
        echo '<meta name="language" content="vi">' . "\n";
    });
}
add_action('init', 'aratavietnam_vietnamese_support');

/**
 * Add comprehensive favicon support to website
 */
function aratavietnam_add_favicon() {
    // Use favicon from media library (ID 55)
    $favicon_id = 55; // Favicon uploaded via WP-CLI
    $favicon_url = wp_get_attachment_image_url($favicon_id, 'full');

    // Fallback to theme assets if media library version not found
    if (!$favicon_url) {
        $favicon_url = get_template_directory_uri() . '/assets/images/favicon.png';
    }

    // Check if favicon URL is valid
    if ($favicon_url) {
        // Standard favicon
        echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="shortcut icon" type="image/png" href="' . esc_url($favicon_url) . '">' . "\n";

        // Apple Touch Icon
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="152x152" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="144x144" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="120x120" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="114x114" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="76x76" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="72x72" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="60x60" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="57x57" href="' . esc_url($favicon_url) . '">' . "\n";

        // Microsoft Tiles
        echo '<meta name="msapplication-TileImage" content="' . esc_url($favicon_url) . '">' . "\n";
        echo '<meta name="msapplication-TileColor" content="#2C7FFF">' . "\n";

        // Android Chrome
        echo '<link rel="icon" type="image/png" sizes="192x192" href="' . esc_url($favicon_url) . '">' . "\n";
        echo '<link rel="icon" type="image/png" sizes="512x512" href="' . esc_url($favicon_url) . '">' . "\n";

        // Theme color for mobile browsers
        echo '<meta name="theme-color" content="#2C7FFF">' . "\n";
        echo '<meta name="msapplication-navbutton-color" content="#2C7FFF">' . "\n";
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="#2C7FFF">' . "\n";

        // Web App Manifest
        $manifest_url = get_template_directory_uri() . '/assets/manifest.json';
        echo '<link rel="manifest" href="' . esc_url($manifest_url) . '">' . "\n";

        // Additional PWA meta tags
        echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-title" content="Arata Vietnam">' . "\n";
        echo '<meta name="application-name" content="Arata Vietnam">' . "\n";
    }
}
add_action('wp_head', 'aratavietnam_add_favicon');



/**
 * Set default logo if no custom logo is set
 */
function aratavietnam_get_custom_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');

    if ($custom_logo_id) {
        // Use custom logo if set
        return wp_get_attachment_image($custom_logo_id, 'full', false, array(
            'class' => 'custom-logo',
            'alt' => get_bloginfo('name'),
        ));
    } else {
        // Use default logo
        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
        return '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="custom-logo default-logo" style="max-height: 60px; width: auto;">';
    }
}

/**
 * Override the_custom_logo to use our default logo
 */
function aratavietnam_custom_logo() {
    $logo = aratavietnam_get_custom_logo();

    if ($logo) {
        echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link" rel="home">' . $logo . '</a>';
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
