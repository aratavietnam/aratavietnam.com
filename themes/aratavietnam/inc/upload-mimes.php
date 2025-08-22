<?php
/**
 * Allow additional file types for upload.
 *
 * @package ArataVietnam
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
function aratavietnam_add_upload_mimes($mimes) {
    // Allow JPG, JPEG, and WebP files, which might be returned by Unsplash.
    $mimes['jpg'] = 'image/jpeg';
    $mimes['jpeg'] = 'image/jpeg';
    $mimes['webp'] = 'image/webp';

    return $mimes;
}
add_filter('upload_mimes', 'aratavietnam_add_upload_mimes', 99);

