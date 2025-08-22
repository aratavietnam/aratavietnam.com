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
