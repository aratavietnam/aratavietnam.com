<?php
/**
 * Register Product Brand Taxonomy
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the 'product_brand' taxonomy.
 */
function aratavietnam_register_brand_taxonomy() {
    $labels = array(
        'name'              => _x('Brands', 'taxonomy general name', 'aratavietnam'),
        'singular_name'     => _x('Brand', 'taxonomy singular name', 'aratavietnam'),
        'search_items'      => __('Search Brands', 'aratavietnam'),
        'all_items'         => __('All Brands', 'aratavietnam'),
        'parent_item'       => __('Parent Brand', 'aratavietnam'),
        'parent_item_colon' => __('Parent Brand:', 'aratavietnam'),
        'edit_item'         => __('Edit Brand', 'aratavietnam'),
        'update_item'       => __('Update Brand', 'aratavietnam'),
        'add_new_item'      => __('Add New Brand', 'aratavietnam'),
        'new_item_name'     => __('New Brand Name', 'aratavietnam'),
        'menu_name'         => __('Brands', 'aratavietnam'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'brand'),
        'show_in_rest'      => true, // Enable for Gutenberg editor
    );

    register_taxonomy('product_brand', array('product'), $args);
}
add_action('init', 'aratavietnam_register_brand_taxonomy', 0);
