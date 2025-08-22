<?php
/**
 * Plugin Name: Arata Allow Uploads
 * Description: A simple plugin to allow additional MIME types for uploads, ensuring WP-CLI compatibility.
 * Version: 1.0
 * Author: Arata Vietnam
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Add support for additional MIME types to be uploaded.
 *
 * @param array $mimes The existing array of allowed MIME types.
 * @return array The modified array of MIME types.
 */
function arata_allow_uploads_add_mimes($mimes) {
    // Allow common image types that might be returned by image services.
    $mimes['jpg'] = 'image/jpeg';
    $mimes['jpeg'] = 'image/jpeg';
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    // Add a fallback for generic binary stream if needed.
    $mimes['bin'] = 'application/octet-stream';

    return $mimes;
}
add_filter('upload_mimes', 'arata_allow_uploads_add_mimes', 99);

