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

// Register custom page templates
function aratavietnam_register_page_templates($templates) {
    $templates['page-templates/news.php'] = 'News Page';
    $templates['page-templates/promotions.php'] = 'Promotions Page';
    $templates['page-templates/careers.php'] = 'Careers Page';
    $templates['page-templates/blog.php'] = 'Blog Page';
    $templates['page-templates/contact.php'] = 'Contact Page';
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

    // Debug log
    error_log("ArataVietnam Search API called with query: " . $search_query);

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

    error_log("ArataVietnam Search found " . $query->found_posts . " posts");

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
                error_log("Post {$post_id} has featured image: " . $featured_image_thumbnail);
            } else {
                // Fallback to default image
                $featured_image = get_template_directory_uri() . '/assets/images/placeholder.svg';
                $featured_image_thumbnail = get_template_directory_uri() . '/assets/images/placeholder.svg';
                error_log("Post {$post_id} using placeholder image: " . $featured_image_thumbnail);
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
            error_log("Added result: " . json_encode($result_item));
        }
        wp_reset_postdata();
    }

    error_log("ArataVietnam Search API returning " . count($results) . " results");
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
        'version' => '1.0.1', // For cache busting
        'debug' => WP_DEBUG,
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

/**
 * Debug: Add version info to footer for debugging
 */
function aratavietnam_debug_info() {
    if (WP_DEBUG) {
        echo '<script>console.log("ArataVietnam Theme Debug Info:", ' . json_encode(array(
            'version' => '1.0.1',
            'search_api_url' => home_url('/wp-json/aratavietnam/v1/search'),
            'theme_uri' => get_template_directory_uri(),
            'timestamp' => current_time('timestamp')
        )) . ');</script>';
    }
}
add_action('wp_footer', 'aratavietnam_debug_info');
