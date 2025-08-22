<?php
/**
 * Footer Customizer Settings - Complete Version
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
 * Main Footer Customizer Function
 */
function aratavietnam_footer_customizer($wp_customize) {

    // Add Footer Section
    $wp_customize->add_section('aratavietnam_footer_section', array(
        'title' => __('Footer Settings', 'aratavietnam'),
        'description' => __('Configure footer information and social media links', 'aratavietnam'),
        'priority' => 30,
        'capability' => 'edit_theme_options',
    ));

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

    // Company Name
    $wp_customize->add_setting('footer_company_name', array(
        'default' => 'Công ty TNHH Arata Việt Nam',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_company_name', array(
        'label' => __('Company Name', 'aratavietnam'),
        'description' => __('Company name displayed in footer', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'text',
        'priority' => 11,
    ));

    // Company Address
    $wp_customize->add_setting('footer_company_address', array(
        'default' => "Lầu 2, Tòa nhà The Landmark,\n5B Tôn Đức Thắng, Phường Bến Nghé,\nQuận 1, Thành phố Hồ Chí Minh",
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_company_address', array(
        'label' => __('Company Address', 'aratavietnam'),
        'description' => __('Full company address (use Enter for line breaks)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'textarea',
        'priority' => 12,
    ));

    // Company Phone Display
    $wp_customize->add_setting('footer_company_phone', array(
        'default' => '+84 28 3827 7060',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_company_phone', array(
        'label' => __('Phone Number (Display)', 'aratavietnam'),
        'description' => __('Phone number as displayed to customers', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'text',
        'priority' => 13,
    ));

    // Company Phone Link
    $wp_customize->add_setting('footer_company_phone_link', array(
        'default' => '+842838277060',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_company_phone_link', array(
        'label' => __('Phone Number (Link)', 'aratavietnam'),
        'description' => __('Phone number for tel: link (numbers only, no spaces)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'text',
        'priority' => 14,
    ));

    // Company Email
    $wp_customize->add_setting('footer_company_email', array(
        'default' => 'arata-vietnam@arata-gr.jp',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_company_email', array(
        'label' => __('Company Email', 'aratavietnam'),
        'description' => __('Main contact email address', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'email',
        'priority' => 15,
    ));

    // Company Description
    $wp_customize->add_setting('footer_company_description', array(
        'default' => "Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản.<br>Chúng tôi kinh doanh các sản phẩm Hóa Mỹ Phẩm<br>được nhập khẩu trực tiếp từ Nhật Bản.",
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_company_description', array(
        'label' => __('Company Description', 'aratavietnam'),
        'description' => __('Short company description (HTML allowed)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'textarea',
        'priority' => 16,
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

    // Facebook URL
    $wp_customize->add_setting('footer_facebook_url', array(
        'default' => 'https://www.facebook.com/aratavietnam',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_facebook_url', array(
        'label' => __('Facebook URL', 'aratavietnam'),
        'description' => __('Full Facebook page URL (leave empty to hide)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'url',
        'priority' => 51,
    ));

    // Instagram URL
    $wp_customize->add_setting('footer_instagram_url', array(
        'default' => 'https://www.instagram.com/aratavietnam/',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_instagram_url', array(
        'label' => __('Instagram URL', 'aratavietnam'),
        'description' => __('Full Instagram profile URL (leave empty to hide)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'url',
        'priority' => 52,
    ));

    // Website URL
    $wp_customize->add_setting('footer_website_url', array(
        'default' => 'https://aratavietnam.com',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_website_url', array(
        'label' => __('Website URL', 'aratavietnam'),
        'description' => __('Main website URL (leave empty to hide)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'url',
        'priority' => 53,
    ));

    // TikTok URL
    $wp_customize->add_setting('footer_tiktok_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_tiktok_url', array(
        'label' => __('TikTok URL', 'aratavietnam'),
        'description' => __('Full TikTok profile URL (leave empty to hide)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'url',
        'priority' => 54,
    ));

    // Shopee URL
    $wp_customize->add_setting('footer_shopee_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_shopee_url', array(
        'label' => __('Shopee URL', 'aratavietnam'),
        'description' => __('Full Shopee shop URL (leave empty to hide)', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'url',
        'priority' => 55,
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

    // Customer Service Title
    $wp_customize->add_setting('footer_service_title', array(
        'default' => 'Dịch vụ khách hàng',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_service_title', array(
        'label' => __('Customer Service Title', 'aratavietnam'),
        'description' => __('Title for the right column menu section', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'text',
        'priority' => 81,
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright_text', array(
        'default' => 'Tất cả quyền được bảo lưu',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_copyright_text', array(
        'label' => __('Copyright Text', 'aratavietnam'),
        'description' => __('Text displayed after company name in copyright', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'text',
        'priority' => 82,
    ));

    // Show Floating Social Widget
    $wp_customize->add_setting('footer_show_floating_social', array(
        'default' => true,
        'sanitize_callback' => 'aratavietnam_sanitize_checkbox',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('footer_show_floating_social', array(
        'label' => __('Show Floating Social Widget', 'aratavietnam'),
        'description' => __('Display floating social media widget on bottom left', 'aratavietnam'),
        'section' => 'aratavietnam_footer_section',
        'type' => 'checkbox',
        'priority' => 83,
    ));
}
add_action('customize_register', 'aratavietnam_footer_customizer');

/**
 * Add live preview JavaScript for footer customizer
 */
function aratavietnam_footer_customizer_preview_js() {
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
