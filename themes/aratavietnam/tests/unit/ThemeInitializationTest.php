<?php
/**
 * Test theme initialization and core functionality
 */

class ThemeInitializationTest extends ThemeTestCase {
    
    public function test_theme_exists() {
        $this->assertTrue($this->theme->exists(), 'Theme should exist');
        $this->assertEquals('aratavietnam', $this->theme->get_stylesheet());
    }
    
    public function test_theme_supports() {
        $this->assertThemeSupport('title-tag');
        $this->assertThemeSupport('custom-logo');
        $this->assertThemeSupport('post-thumbnails');
        $this->assertThemeSupport('align-wide');
        $this->assertThemeSupport('wp-block-styles');
        $this->assertThemeSupport('responsive-embeds');
        $this->assertThemeSupport('menus');
        $this->assertThemeSupport('woocommerce');
        $this->assertThemeSupport('wc-product-gallery-zoom');
        $this->assertThemeSupport('wc-product-gallery-lightbox');
        $this->assertThemeSupport('wc-product-gallery-slider');
        $this->assertThemeSupport('html5');
    }
    
    public function test_theme_functions_exist() {
        $this->assertFunctionExists('aratavietnam');
        $this->assertFunctionExists('aratavietnam_load_textdomain');
        $this->assertFunctionExists('aratavietnam_register_page_templates');
        $this->assertFunctionExists('aratavietnam_force_template_recognition');
        $this->assertFunctionExists('aratavietnam_register_menus');
        $this->assertFunctionExists('aratavietnam_after_setup_theme');
        $this->assertFunctionExists('aratavietnam_enqueue_custom_scripts');
        $this->assertFunctionExists('aratavietnam_localize_theme_data');
        $this->assertFunctionExists('aratavietnam_output_theme_colors');
        $this->assertFunctionExists('aratavietnam_cache_busting');
    }
    
    public function test_textdomain_loading() {
        $this->assertTrue(is_textdomain_loaded('aratavietnam'), 'Theme textdomain should be loaded');
    }
    
    public function test_menu_registration() {
        $locations = get_registered_nav_menus();
        $this->assertArrayHasKey('primary', $locations);
        $this->assertArrayHasKey('footer-menu-1', $locations);
        $this->assertArrayHasKey('footer-menu-2', $locations);
    }
    
    public function test_page_template_registration() {
        $templates = get_page_templates();
        $this->assertArrayHasKey('page-templates/news.php', $templates);
        $this->assertArrayHasKey('page-templates/promotions.php', $templates);
        $this->assertArrayHasKey('page-templates/careers.php', $templates);
        $this->assertArrayHasKey('page-templates/blog.php', $templates);
        $this->assertArrayHasKey('page-templates/contact.php', $templates);
        $this->assertArrayHasKey('page-templates/services.php', $templates);
        $this->assertArrayHasKey('page-templates/about.php', $templates);
    }
    
    public function test_theme_mod_colors() {
        $primary_color = get_theme_mod('theme_primary_color');
        $secondary_color = get_theme_mod('theme_secondary_color');
        $tertiary_color = get_theme_mod('theme_tertiary_color');
        
        $this->assertEquals('#F55E25', $primary_color);
        $this->assertEquals('#0066A6', $secondary_color);
        $this->assertEquals('#FFAB14', $tertiary_color);
    }
    
    public function test_editor_color_palette() {
        $editor_colors = get_theme_support('editor-color-palette');
        $this->assertIsArray($editor_colors);
        $this->assertArrayHasKey(0, $editor_colors[0]);
        
        $colors = $editor_colors[0];
        $color_names = array_column($colors, 'name');
        $this->assertContains('Primary', $color_names);
        $this->assertContains('Secondary', $color_names);
        $this->assertContains('Tertiary', $color_names);
        $this->assertContains('White', $color_names);
        $this->assertContains('Black', $color_names);
    }
    
    public function test_theme_version() {
        $version = wp_get_theme()->get('Version');
        $this->assertNotEmpty($version, 'Theme should have a version');
    }
    
    public function test_theme_directory() {
        $template_dir = get_template_directory();
        $stylesheet_dir = get_stylesheet_directory();
        
        $this->assertStringEndsWith('themes/aratavietnam', $template_dir);
        $this->assertEquals($template_dir, $stylesheet_dir);
    }
    
    public function test_theme_uri() {
        $template_uri = get_template_directory_uri();
        $stylesheet_uri = get_stylesheet_directory_uri();
        
        $this->assertStringEndsWith('themes/aratavietnam', $template_uri);
        $this->assertEquals($template_uri, $stylesheet_uri);
    }
    
    public function test_theme_assets_directory() {
        $this->assertFileExists(get_template_directory() . '/resources');
        $this->assertFileExists(get_template_directory() . '/resources/js');
        $this->assertFileExists(get_template_directory() . '/resources/css');
        $this->assertFileExists(get_template_directory() . '/dist');
    }
    
    public function test_theme_includes_directory() {
        $this->assertFileExists(get_template_directory() . '/inc');
        $this->assertFileExists(get_template_directory() . '/inc/woocommerce.php');
        $this->assertFileExists(get_template_directory() . '/inc/news-post-types.php');
        $this->assertFileExists(get_template_directory() . '/inc/services-post-types.php');
    }
    
    public function test_theme_template_directory() {
        $this->assertFileExists(get_template_directory() . '/page-templates');
        $this->assertFileExists(get_template_directory() . '/page-templates/news.php');
        $this->assertFileExists(get_template_directory() . '/page-templates/promotions.php');
        $this->assertFileExists(get_template_directory() . '/page-templates/careers.php');
    }
    
    public function test_theme_scripts_enqueued() {
        do_action('wp_enqueue_scripts');
        
        $this->assertTrue(wp_script_is('aratavietnam-app', 'enqueued'));
        $this->assertTrue(wp_script_is('aratavietnam-notifications', 'enqueued'));
    }
    
    public function test_theme_localized_data() {
        do_action('wp_enqueue_scripts');
        
        $localized = wp_scripts()->get_data('aratavietnam-app', 'data');
        $this->assertStringContainsString('arataThemeData', $localized);
        $this->assertStringContainsString('themeUri', $localized);
        $this->assertStringContainsString('ajaxUrl', $localized);
        $this->assertStringContainsString('nonce', $localized);
    }
    
    public function test_theme_colors_output() {
        ob_start();
        do_action('wp_head');
        $output = ob_get_clean();
        
        $this->assertStringContainsString('--theme-primary-color', $output);
        $this->assertStringContainsString('--theme-secondary-color', $output);
        $this->assertStringContainsString('--theme-tertiary-color', $output);
    }
    
    public function test_cache_busting_filter() {
        $src = get_template_directory_uri() . '/dist/app.js';
        $filtered_src = apply_filters('script_loader_src', $src, 'aratavietnam-app');
        
        $this->assertNotEquals($src, $filtered_src);
        $this->assertStringContainsString('v=', $filtered_src);
    }
    
    public function test_custom_logo_support() {
        $this->assertThemeSupport('custom-logo');
        
        $custom_logo = get_theme_support('custom-logo');
        $this->assertIsArray($custom_logo);
        $this->assertEquals(100, $custom_logo[0]['height']);
        $this->assertEquals(400, $custom_logo[0]['width']);
        $this->assertTrue($custom_logo[0]['flex-height']);
        $this->assertTrue($custom_logo[0]['flex-width']);
    }
    
    public function test_html5_support() {
        $html5_support = get_theme_support('html5');
        $this->assertIsArray($html5_support);
        $this->assertContains('search-form', $html5_support[0]);
        $this->assertContains('comment-form', $html5_support[0]);
        $this->assertContains('comment-list', $html5_support[0]);
        $this->assertContains('gallery', $html5_support[0]);
        $this->assertContains('caption', $html5_support[0]);
    }
    
    public function test_post_thumbnails_support() {
        $this->assertThemeSupport('post-thumbnails');
        $this->assertTrue(post_type_supports('post', 'thumbnail'));
        $this->assertTrue(post_type_supports('page', 'thumbnail'));
    }
    
    public function test_theme_activation() {
        // Test that theme can be activated
        $this->assertTrue(is_active_theme('aratavietnam'));
    }
}