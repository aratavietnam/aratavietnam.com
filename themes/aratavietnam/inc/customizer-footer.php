<?php
/**
 * Footer Customizer Settings - Simplified Version
 *
 * @package ArataVietnam
 */

/**
 * Add Footer Customizer CSS for better admin experience
 */
function aratavietnam_footer_customizer_css() {
    ?>
    <style type="text/css">
        .customize-control-footer-info {
            background: #0066A6;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .customize-control-footer-info h4 {
            margin: 0 0 10px 0;
            color: #FFAB14;
            font-size: 14px;
            font-weight: bold;
        }
        .customize-control-footer-info p {
            margin: 5px 0;
            font-size: 12px;
            line-height: 1.4;
        }
        .customize-control-section-divider {
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
add_action('customize_controls_print_styles', 'aratavietnam_footer_customizer_css');

/**
 * Enhanced Footer Customizer with better organization
 */
function aratavietnam_footer_customizer_enhanced($wp_customize) {
    // Add informational control at the top
    $wp_customize->add_setting('footer_info', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_info', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_footer_section',
        'priority' => 1,
        'description' => '<div class="customize-control-footer-info">
            <h4>' . __('Footer Configuration', 'aratavietnam') . '</h4>
            <p>' . __('Configure all footer information from this panel. Changes will be reflected immediately in the preview.', 'aratavietnam') . '</p>
        </div>',
    ));

    // Company Information Divider
    $wp_customize->add_setting('company_info_divider', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('company_info_divider', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_footer_section',
        'priority' => 10,
        'description' => '<div class="customize-control-section-divider">' . __('Company Information', 'aratavietnam') . '</div>',
    ));

    // Social Media Divider
    $wp_customize->add_setting('social_media_divider', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('social_media_divider', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_footer_section',
        'priority' => 50,
        'description' => '<div class="customize-control-section-divider">' . __('Social Media Links', 'aratavietnam') . '</div>',
    ));

    // Footer Display Divider
    $wp_customize->add_setting('footer_display_divider', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_display_divider', array(
        'type' => 'hidden',
        'section' => 'aratavietnam_footer_section',
        'priority' => 80,
        'description' => '<div class="customize-control-section-divider">' . __('Footer Display Settings', 'aratavietnam') . '</div>',
    ));

    // Update priorities for existing controls
    $existing_controls = array(
        'footer_company_name' => 11,
        'footer_company_address' => 12,
        'footer_company_phone' => 13,
        'footer_company_phone_link' => 14,
        'footer_company_email' => 15,
        'footer_company_description' => 16,
        'footer_facebook_url' => 51,
        'footer_instagram_url' => 52,
        'footer_website_url' => 53,
        'footer_tiktok_url' => 54,
        'footer_shopee_url' => 55,
        'footer_service_title' => 81,
        'footer_copyright_text' => 82,
        'footer_show_floating_social' => 83,
    );

    foreach ($existing_controls as $control_id => $priority) {
        $control = $wp_customize->get_control($control_id);
        if ($control) {
            $control->priority = $priority;
        }
    }
}
add_action('customize_register', 'aratavietnam_footer_customizer_enhanced', 20);

/**
 * Add live preview JavaScript for footer customizer
 */
function aratavietnam_footer_customizer_preview_js() {
    // Simple inline JavaScript for live preview
    ?>
    <script type="text/javascript">
    (function($) {
        'use strict';

        // Company Name
        wp.customize('footer_company_name', function(value) {
            value.bind(function(newval) {
                $('#colophon h3').first().text(newval);
            });
        });

        // Company Phone Display
        wp.customize('footer_company_phone', function(value) {
            value.bind(function(newval) {
                $('#colophon a[href^="tel:"]').text(newval);
            });
        });

        // Company Email
        wp.customize('footer_company_email', function(value) {
            value.bind(function(newval) {
                $('#colophon a[href^="mailto:"]').attr('href', 'mailto:' + newval).text(newval);
            });
        });

        // Customer Service Title
        wp.customize('footer_service_title', function(value) {
            value.bind(function(newval) {
                $('#colophon h4').text(newval);
            });
        });

    })(jQuery);
    </script>
    <?php
}
add_action('customize_preview_init', 'aratavietnam_footer_customizer_preview_js');

/**
 * Sanitize checkbox
 */
function aratavietnam_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize select
 */
function aratavietnam_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}
