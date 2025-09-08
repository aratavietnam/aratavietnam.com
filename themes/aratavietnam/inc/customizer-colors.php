<?php
/**
 * Color Customizer Settings
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Color Customizer CSS for better admin experience
 */
function aratavietnam_color_customizer_css() {
    ?>
    <style type="text/css">
        .customize-control-color-info {
            background: #0066A6;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .customize-control-color-info h4 {
            margin: 0 0 10px 0;
            color: #FFAB14;
            font-size: 14px;
            font-weight: bold;
        }
        .customize-control-color-info p {
            margin: 5px 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .customize-control-color-divider {
            background: #f7f7f7;
            padding: 10px 15px;
            margin: 20px -15px 15px -15px;
            border-left: 4px solid #0066A6;
            font-weight: bold;
            color: #333;
            font-size: 13px;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'aratavietnam_color_customizer_css');

/**
 * Main Color Customizer Function
 */
function aratavietnam_color_customizer($wp_customize) {

    // Add Color Section
    $wp_customize->add_section('aratavietnam_color_section', array(
        'title' => __('Theme Colors', 'aratavietnam'),
        'description' => __('Configure website colors and appearance', 'aratavietnam'),
        'priority' => 25,
        'capability' => 'edit_theme_options',
    ));

    // Add informational control at the top
    $wp_customize->add_setting('color_info', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('color_info', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_color_section',
        'priority' => 1,
        'description' => '<div class="customize-control-color-info">
            <h4>' . __('Theme Color Configuration', 'aratavietnam') . '</h4>
            <p>' . __('Customize your website colors. Changes will be reflected immediately in the preview.', 'aratavietnam') . '</p>
        </div>',
    ));

    // Primary Colors Divider
    $wp_customize->add_setting('primary_colors_divider', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('primary_colors_divider', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_color_section',
        'priority' => 10,
        'description' => '<div class="customize-control-color-divider">' . __('Primary Colors', 'aratavietnam') . '</div>',
    ));

    // Primary Color (Orange)
    $wp_customize->add_setting('theme_primary_color', array(
        'default' => '#F55E25',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_primary_color', array(
        'label' => __('Primary Color', 'aratavietnam'),
        'description' => __('Orange brand color used for buttons, links, and primary accents', 'aratavietnam'),
        'section' => 'aratavietnam_color_section',
        'priority' => 11,
    )));

    // Secondary Color (Blue)
    $wp_customize->add_setting('theme_secondary_color', array(
        'default' => '#0066A6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_secondary_color', array(
        'label' => __('Secondary Color', 'aratavietnam'),
        'description' => __('Blue color used for headers, text, and secondary elements', 'aratavietnam'),
        'section' => 'aratavietnam_color_section',
        'priority' => 12,
    )));

    // Tertiary Color (Yellow)
    $wp_customize->add_setting('theme_tertiary_color', array(
        'default' => '#FFAB14',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_tertiary_color', array(
        'label' => __('Tertiary Color', 'aratavietnam'),
        'description' => __('Yellow accent color for highlights and warning elements', 'aratavietnam'),
        'section' => 'aratavietnam_color_section',
        'priority' => 13,
    )));

    // Background Colors Divider
    $wp_customize->add_setting('background_colors_divider', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('background_colors_divider', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_color_section',
        'priority' => 20,
        'description' => '<div class="customize-control-color-divider">' . __('Background Colors', 'aratavietnam') . '</div>',
    ));

    // Background Color
    $wp_customize->add_setting('theme_background_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_background_color', array(
        'label' => __('Background Color', 'aratavietnam'),
        'description' => __('Main background color for the website', 'aratavietnam'),
        'section' => 'aratavietnam_color_section',
        'priority' => 21,
    )));

    // Header Background Color
    $wp_customize->add_setting('theme_header_background_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_header_background_color', array(
        'label' => __('Header Background Color', 'aratavietnam'),
        'description' => __('Background color for the header area', 'aratavietnam'),
        'section' => 'aratavietnam_color_section',
        'priority' => 22,
    )));

    // Footer Background Color
    $wp_customize->add_setting('theme_footer_background_color', array(
        'default' => '#0066A6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_footer_background_color', array(
        'label' => __('Footer Background Color', 'aratavietnam'),
        'description' => __('Background color for the footer area', 'aratavietnam'),
        'section' => 'aratavietnam_color_section',
        'priority' => 23,
    )));

    // Service Colors - REMOVED: Now using system colors (Primary, Secondary, Tertiary)
    // Service type colors are now mapped directly to theme primary colors in services.php
}
add_action('customize_register', 'aratavietnam_color_customizer');

/**
 * Add live preview JavaScript for color customizer
 */
function aratavietnam_color_customizer_preview_js() {
    ?>
    <script type="text/javascript">
    (function($) {
        'use strict';

        // Primary Color
        wp.customize('theme_primary_color', function(value) {
            value.bind(function(newval) {
                // Update CSS custom properties
                $(':root').get(0).style.setProperty('--color-primary', newval);
                
                // Update specific elements
                $('.bg-primary').css('background-color', newval);
                $('.text-primary').css('color', newval);
                $('.border-primary').css('border-color', newval);
            });
        });

        // Secondary Color  
        wp.customize('theme_secondary_color', function(value) {
            value.bind(function(newval) {
                $(':root').get(0).style.setProperty('--color-secondary', newval);
                
                $('.bg-secondary').css('background-color', newval);
                $('.text-secondary').css('color', newval);
                $('.border-secondary').css('border-color', newval);
            });
        });

        // Tertiary Color
        wp.customize('theme_tertiary_color', function(value) {
            value.bind(function(newval) {
                $(':root').get(0).style.setProperty('--color-tertiary', newval);
                
                $('.bg-tertiary').css('background-color', newval);
                $('.text-tertiary').css('color', newval);
                $('.border-tertiary').css('border-color', newval);
            });
        });

        // Background Color
        wp.customize('theme_background_color', function(value) {
            value.bind(function(newval) {
                $('body').css('background-color', newval);
                $('.bg-white').css('background-color', newval);
            });
        });

        // Header Background Color
        wp.customize('theme_header_background_color', function(value) {
            value.bind(function(newval) {
                $('#masthead').css('background-color', newval);
            });
        });

        // Footer Background Color
        wp.customize('theme_footer_background_color', function(value) {
            value.bind(function(newval) {
                $('#colophon').css('background', 'linear-gradient(135deg, ' + newval + ' 0%, ' + newval + ' 100%)');
            });
        });

        // Service Colors - REMOVED: Now using system colors
        // Service type colors update automatically with theme primary/secondary/tertiary colors

    })(jQuery);
    </script>
    <?php
}
add_action('customize_preview_init', 'aratavietnam_color_customizer_preview_js');