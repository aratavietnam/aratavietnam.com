<?php

if (is_file(__DIR__.'/vendor/autoload_packages.php')) {
    require_once __DIR__.'/vendor/autoload_packages.php';
}

// Include theme functionality files
require_once get_template_directory() . '/inc/woocommerce.php';
require_once get_template_directory() . '/inc/fonts-vietnamese.php';
require_once get_template_directory() . '/inc/favicon-pwa.php';
require_once get_template_directory() . '/inc/logo-branding.php';
require_once get_template_directory() . '/inc/customizer-footer.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/contact-meta.php';
require_once get_template_directory() . '/inc/contact-config.php';
require_once get_template_directory() . '/inc/news-post-types.php';
require_once get_template_directory() . '/inc/news-meta-fields.php';
require_once get_template_directory() . '/inc/news-forms.php';
require_once get_template_directory() . '/inc/class-dropdown-walker.php';
require_once get_template_directory() . '/inc/about-meta.php';
require_once get_template_directory() . '/inc/admin-columns.php';
require_once get_template_directory() . '/inc/template-filters.php';
require_once get_template_directory() . '/inc/upload-mimes.php';
require_once get_template_directory() . '/inc/auth-handler.php';
require_once get_template_directory() . '/inc/job-application-handler.php';
require_once get_template_directory() . '/inc/services-post-types.php';

// Register custom page templates
function aratavietnam_register_page_templates($templates) {
    $templates['page-templates/news.php'] = 'News Page';
    $templates['page-templates/promotions.php'] = 'Promotions Page';
    $templates['page-templates/careers.php'] = 'Careers Page';
    $templates['page-templates/blog.php'] = 'Blog Page';
    $templates['page-templates/contact.php'] = 'Contact Page';
    $templates['page-templates/services.php'] = 'Services Page';
    return $templates;
}
add_filter('theme_page_templates', 'aratavietnam_register_page_templates');

// Force WordPress to recognize custom templates
function aratavietnam_force_template_recognition($template) {
    global $post;

    if (is_page() && $post) {
        $template_name = get_post_meta($post->ID, '_wp_page_template', true);

        if ($template_name && $template_name !== 'default') {
            $template_path = get_template_directory() . '/' . $template_name;
            if (file_exists($template_path)) {
                return $template_path;
            }
        }
    }

    return $template;
}
add_filter('template_include', 'aratavietnam_force_template_recognition', 99);

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


/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}










	return $urls;
}

// Track post views
function arata_get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function arata_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Function to track post views
function arata_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    arata_set_post_views($post_id);
}
add_action( 'wp_head', 'arata_track_post_views');


// Customize comment form
add_filter('comment_form_defaults', function ($defaults) {
    // Remove the 'Leave a Reply' title
    $defaults['title_reply'] = '';
    $defaults['title_reply_before'] = '';
    $defaults['title_reply_after'] = '';

    // Translate the cookies consent checkbox text
    $commenter = wp_get_current_commenter();
    $consent   = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
    $defaults['fields']['cookies'] = '<p class="comment-form-cookies-consent">' .
                                     '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
                                     '<label for="wp-comment-cookies-consent">' . __('Lưu tên, email và trang web của tôi trong trình duyệt này cho lần bình luận tiếp theo.', 'aratavietnam') . '</label>' .
                                     '</p>';
    return $defaults;
});

// WooCommerce: Vietnamese add-to-cart message (simple & small)
add_filter('wc_add_to_cart_message_html', function($message, $products){
    $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '/gio-hang';
    return sprintf('Đã thêm vào giỏ hàng. <a href="%s" class="underline text-primary">Xem giỏ hàng</a>', esc_url($cart_url));
}, 10, 2);

// WooCommerce: Vietnamese checkout translations
add_filter('woocommerce_checkout_fields', function($fields) {
    // Billing fields
    if (isset($fields['billing'])) {
        $fields['billing']['billing_email']['label'] = 'Địa chỉ email *';
        $fields['billing']['billing_email']['placeholder'] = 'Nhập địa chỉ email của bạn';

        $fields['billing']['billing_first_name']['label'] = 'Tên *';
        $fields['billing']['billing_first_name']['placeholder'] = 'Nhập tên của bạn';

        $fields['billing']['billing_last_name']['label'] = 'Họ *';
        $fields['billing']['billing_last_name']['placeholder'] = 'Nhập họ của bạn';

        $fields['billing']['billing_country']['label'] = 'Quốc gia / Vùng *';

        $fields['billing']['billing_address_1']['label'] = 'Địa chỉ đường *';
        $fields['billing']['billing_address_1']['placeholder'] = 'Số nhà và tên đường';

        $fields['billing']['billing_address_2']['label'] = 'Căn hộ, suite, đơn vị, v.v. (tùy chọn)';
        $fields['billing']['billing_address_2']['placeholder'] = 'Căn hộ, suite, đơn vị, v.v. (tùy chọn)';

        $fields['billing']['billing_postcode']['label'] = 'Mã bưu điện / ZIP (tùy chọn)';
        $fields['billing']['billing_postcode']['placeholder'] = 'Nhập mã bưu điện';

        $fields['billing']['billing_city']['label'] = 'Thành phố / Thị xã *';
        $fields['billing']['billing_city']['placeholder'] = 'Nhập tên thành phố';

        $fields['billing']['billing_phone']['label'] = 'Số điện thoại (tùy chọn)';
        $fields['billing']['billing_phone']['placeholder'] = 'Nhập số điện thoại';
    }

    // Shipping fields
    if (isset($fields['shipping'])) {
        $fields['shipping']['shipping_first_name']['label'] = 'Tên *';
        $fields['shipping']['shipping_last_name']['label'] = 'Họ *';
        $fields['shipping']['shipping_country']['label'] = 'Quốc gia / Vùng *';
        $fields['shipping']['shipping_address_1']['label'] = 'Địa chỉ đường *';
        $fields['shipping']['shipping_address_2']['label'] = 'Căn hộ, suite, đơn vị, v.v. (tùy chọn)';
        $fields['shipping']['shipping_postcode']['label'] = 'Mã bưu điện / ZIP (tùy chọn)';
        $fields['shipping']['shipping_city']['label'] = 'Thành phố / Thị xã *';
    }

    // Order notes
    if (isset($fields['order'])) {
        $fields['order']['order_comments']['label'] = 'Ghi chú đơn hàng (tùy chọn)';
        $fields['order']['order_comments']['placeholder'] = 'Ghi chú về đơn hàng, giao hàng hoặc thông tin khác...';
    }

    return $fields;
});

// WooCommerce: More comprehensive Vietnamese translations
add_filter('gettext', function($translation, $text, $domain) {
    if ($domain === 'woocommerce') {
        switch ($text) {
            case 'Billing details':
                return 'Thông tin thanh toán';
            case 'Street address':
                return 'Địa chỉ đường';
            case 'House number and street name':
                return 'Số nhà và tên đường';
            case 'Apartment, suite, unit, etc. (optional)':
                return 'Căn hộ, suite, đơn vị, v.v. (tùy chọn)';
            case 'Postcode / ZIP (optional)':
                return 'Mã bưu điện / ZIP (tùy chọn)';
            case 'Town / City':
                return 'Thành phố / Thị xã';
            case 'Product':
                return 'Sản phẩm';
            case 'Subtotal':
                return 'Tạm tính';
            case 'Total':
                return 'Tổng cộng';
            case 'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.':
                return 'Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn trên toàn bộ trang web này và cho các mục đích khác được mô tả trong chính sách bảo mật của chúng tôi.';
            case 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.':
                return 'Xin lỗi, có vẻ như không có phương thức thanh toán nào khả dụng. Vui lòng liên hệ với chúng tôi nếu bạn cần hỗ trợ hoặc muốn sắp xếp phương thức thay thế.';
        }
    }
    return $translation;
}, 10, 3);

// WooCommerce: Order review table headers translation
add_filter('woocommerce_cart_item_name', function($name, $cart_item, $cart_item_key) {
    return $name;
}, 10, 3);

// WooCommerce: Specific checkout text translations
add_filter('woocommerce_checkout_privacy_policy_text', function($text) {
    return 'Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn trên toàn bộ trang web này và cho các mục đích khác được mô tả trong chính sách bảo mật của chúng tôi.';
});

// WooCommerce: Order review section title
add_filter('woocommerce_order_review_heading', function($heading) {
    return 'Xem lại đơn hàng';
});

// WooCommerce: Vietnamese order review translations
add_filter('woocommerce_get_item_data', function($item_data, $cart_item) {
    if (isset($item_data['quantity'])) {
        $item_data['quantity']['display_key'] = 'Số lượng';
    }
    return $item_data;
}, 10, 2);

// WooCommerce: Vietnamese checkout messages
add_filter('woocommerce_checkout_fields', function($fields) {
    return $fields;
});

// WooCommerce: Vietnamese order review labels
add_filter('woocommerce_cart_item_subtotal', function($subtotal, $cart_item, $cart_item_key) {
    return $subtotal;
}, 10, 3);

// WooCommerce: Vietnamese checkout button text
add_filter('woocommerce_order_button_text', function($button_text) {
    return 'Đặt hàng';
});

// WooCommerce: Vietnamese coupon text
add_filter('woocommerce_checkout_coupon_message', function($message) {
    return 'Có mã giảm giá? <a href="#" class="showcoupon underline text-primary">Nhấp vào đây để nhập mã</a>';
});

// WooCommerce: Vietnamese order review section titles
add_filter('woocommerce_checkout_order_review_heading', function($heading) {
    return 'Xem lại đơn hàng';
});

// WooCommerce: Vietnamese subtotal and total labels
add_filter('woocommerce_cart_totals_before_order_total', function() {
    echo '<tr class="order-subtotal">';
    echo '<th>Tạm tính</th>';
    echo '<td>' . WC()->cart->get_cart_subtotal() . '</td>';
    echo '</tr>';
});

add_filter('woocommerce_cart_totals_order_total_html', function($value) {
    return str_replace('Total', 'Tổng cộng', $value);
});

// WooCommerce: Vietnamese payment methods text
add_filter('woocommerce_no_available_payment_methods_message', function($message) {
    return 'Xin lỗi, có vẻ như không có phương thức thanh toán nào khả dụng. Vui lòng liên hệ với chúng tôi nếu bạn cần hỗ trợ hoặc muốn sắp xếp phương thức thay thế.';
});

// WooCommerce: Vietnamese privacy policy text
add_filter('woocommerce_checkout_privacy_policy_text', function($text) {
    return 'Dữ liệu cá nhân của bạn sẽ được sử dụng để xử lý đơn hàng, hỗ trợ trải nghiệm của bạn trên toàn bộ trang web này và cho các mục đích khác được mô tả trong chính sách bảo mật của chúng tôi.';
});

// Remove entry footer from WooCommerce pages
add_filter('woocommerce_show_page_title', function($show) {
    if (is_cart() || is_checkout()) {
        remove_action('wp_footer', 'wp_footer');
    }
    return $show;
});

// Remove entry footer from WooCommerce pages
add_action('wp_head', function() {
    if (is_cart() || is_checkout()) {
        echo '<style>
            .entry-footer { display: none !important; }
        </style>';
    }
});

/**
 * Custom search endpoint with featured images
 */
function aratavietnam_custom_search_endpoint() {
    register_rest_route('aratavietnam/v1', '/search', array(
        'methods' => 'GET',
        'callback' => 'aratavietnam_custom_search_callback',
        'permission_callback' => '__return_true',
        'args' => array(
            'search' => array(
                'required' => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
            'per_page' => array(
                'default' => 10,
                'sanitize_callback' => 'absint',
            ),
        ),
    ));
}
add_action('rest_api_init', 'aratavietnam_custom_search_endpoint');

function aratavietnam_custom_search_callback($request) {
    $search_query = $request->get_param('search');
    $per_page = $request->get_param('per_page');

    if (empty($search_query)) {
        return new WP_REST_Response(array(), 200);
    }

    // Search in posts, pages, and products
    $args = array(
        'post_type' => array('post', 'page', 'product'),
        'post_status' => 'publish',
        's' => $search_query,
        'posts_per_page' => $per_page,
        'orderby' => 'relevance',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
            array(
                'key' => '_thumbnail_id',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Get featured image
            $featured_image = '';
            $featured_image_thumbnail = '';
            if (has_post_thumbnail($post_id)) {
                $featured_image = get_the_post_thumbnail_url($post_id, 'full');
                $featured_image_thumbnail = get_the_post_thumbnail_url($post_id, 'thumbnail');
            } else {
                // Fallback to default image
                $featured_image = get_template_directory_uri() . '/assets/images/placeholder.svg';
                $featured_image_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.svg';
            }

            // Get post excerpt
            $excerpt = get_the_excerpt();
            if (empty($excerpt)) {
                $excerpt = wp_trim_words(get_the_content(), 20, '...');
            }

            $result_item = array(
                'id' => $post_id,
                'title' => get_the_title(),
                'excerpt' => $excerpt,
                'url' => get_permalink(),
                'type' => get_post_type(),
                'type_label' => get_post_type_object(get_post_type())->labels->singular_name,
                'featured_image' => $featured_image,
                'featured_image_thumbnail' => $featured_image_thumbnail,
                'date' => get_the_date('d/m/Y'),
                'author' => get_the_author(),
            );

            $results[] = $result_item;
        }
        wp_reset_postdata();
    }

    return new WP_REST_Response($results, 200);
}

/**
 * Localize theme data for JavaScript
 */
function aratavietnam_localize_theme_data() {
    wp_localize_script('aratavietnam-app', 'arataThemeData', array(
        'themeUri' => get_template_directory_uri(),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('aratavietnam_nonce'),
        'homeUrl' => home_url(),
        'searchUrl' => home_url('/?s='),
        'searchApiUrl' => home_url('/wp-json/aratavietnam/v1/search'),
        'version' => '1.0.1',
    ));
}
add_action('wp_enqueue_scripts', 'aratavietnam_localize_theme_data');

/**
 * Add cache busting to theme assets
 */
function aratavietnam_cache_busting($src, $handle) {
    if (strpos($handle, 'aratavietnam') !== false) {
        $src = add_query_arg('v', '1.0.1', $src);
    }
    return $src;
}
add_filter('script_loader_src', 'aratavietnam_cache_busting', 10, 2);
add_filter('style_loader_src', 'aratavietnam_cache_busting', 10, 2);

// Remove footer debug info if exists
remove_action('wp_footer', 'aratavietnam_debug_info');
