<?php
/**
 * Plugin Name: Remove Shortcode Comments
 * Description: Removes <!-- wp:shortcode --> comments from output
 */

add_filter('the_content', function($content) {
    return preg_replace('/<!-- wp:shortcode -->.*?<!-- \/wp:shortcode -->/s', '', $content);
}, 20);