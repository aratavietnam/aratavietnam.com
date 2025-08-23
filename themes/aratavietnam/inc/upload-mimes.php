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

    // Allow SVG files
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter('upload_mimes', 'aratavietnam_add_upload_mimes', 99);

/**
 * Add SVG support to WordPress media library with security checks.
 */
function aratavietnam_enable_svg_support() {
    // Add SVG to allowed file types
    add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
        global $wp_version;
        if ($wp_version !== '4.7.1') {
            return $data;
        }

        $filetype = wp_check_filetype($filename, $mimes);

        return [
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        ];
    }, 10, 4);

    // Fix SVG display in media library
    add_filter('wp_prepare_attachment_for_js', function($response, $attachment, $meta) {
        if ($response['type'] === 'image' && $response['subtype'] === 'svg+xml') {
            $response['image'] = [
                'src' => $response['url'],
                'width' => 300,
                'height' => 300,
            ];
            $response['thumb'] = [
                'src' => $response['url'],
                'width' => 150,
                'height' => 150,
            ];
            $response['sizes'] = [
                'full' => [
                    'url' => $response['url'],
                    'width' => 300,
                    'height' => 300,
                    'orientation' => 'landscape'
                ]
            ];
        }
        return $response;
    }, 10, 3);
}
add_action('init', 'aratavietnam_enable_svg_support');

/**
 * Sanitize SVG files on upload for security.
 */
function aratavietnam_sanitize_svg($file) {
    if ($file['type'] === 'image/svg+xml') {
        $svg_content = file_get_contents($file['tmp_name']);

        // Basic security: remove script tags and event handlers
        $svg_content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $svg_content);
        $svg_content = preg_replace('/on\w+="[^"]*"/i', '', $svg_content);
        $svg_content = preg_replace('/on\w+=\'[^\']*\'/i', '', $svg_content);
        $svg_content = preg_replace('/javascript:/i', '', $svg_content);

        file_put_contents($file['tmp_name'], $svg_content);
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'aratavietnam_sanitize_svg');

/**
 * Add CSS for SVG display in admin.
 */
function aratavietnam_svg_admin_css() {
    echo '<style>
        .attachment-266x266, .thumbnail img {
            width: 100% !important;
            height: auto !important;
        }
        .media-icon img[src$=".svg"] {
            width: 100%;
            height: auto;
        }
    </style>';
}
add_action('admin_head', 'aratavietnam_svg_admin_css');
