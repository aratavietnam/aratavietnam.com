<?php
/**
 * Logo and branding functionality for Arata Vietnam theme
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
