<?php
/**
 * Favicon and PWA support for Arata Vietnam theme
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
