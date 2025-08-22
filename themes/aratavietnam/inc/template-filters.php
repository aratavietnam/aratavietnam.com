<?php
/**
 * Custom template filters to prevent content duplication.
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Remove the featured image from the post content on single views for specific post types.
 *
 * This prevents the image from showing twice (once from the_post_thumbnail() and once from the_content()).
 *
 * @param string $content The post content.
 * @return string The modified post content.
 */
function aratavietnam_remove_featured_image_from_content($content)
{
    // Check if it's a single post view for the specified post types and has a featured image.
    if (is_singular(['promotion', 'job_posting']) && has_post_thumbnail()) {
        // Get the featured image ID.
        $featured_image_id = get_post_thumbnail_id(get_the_ID());

        // Get the URL of the featured image.
        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

        // Find the image tag in the content.
        preg_match('/<img[^>]+>/', $content, $matches);

        if (!empty($matches)) {
            $first_image_tag = $matches[0];
            // Check if the first image in content is the featured image.
            if (strpos($first_image_tag, 'wp-image-' . $featured_image_id) !== false || strpos($first_image_tag, esc_attr($featured_image_url)) !== false) {
                // Remove the first image block paragraph wrapper to avoid empty space.
                $content = preg_replace('/<p>\s*<a[^>]*>\s*<img[^>]+>\s*<\/a>\s*<\/p>|<p>\s*<img[^>]+>\s*<\/p>/', '', $content, 1);
            }
        }
    }

    return $content;
}
add_filter('the_content', 'aratavietnam_remove_featured_image_from_content', 10);

