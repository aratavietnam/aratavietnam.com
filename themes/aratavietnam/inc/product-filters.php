<?php
/**
 * Product Filters Handler
 * Handles filtering products by brand, price, and other criteria
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter products by brand and price
 */
function aratavietnam_filter_products($query) {
    // Only apply to product queries on frontend
    if (!is_admin() && $query->is_main_query() && 
        (is_shop() || is_product_category() || is_product_tag() || is_tax('product_brand'))) {
        
        // Sorting filter
        if (isset($_GET['orderby']) && !empty($_GET['orderby'])) {
            $orderby = sanitize_text_field($_GET['orderby']);
            
            switch ($orderby) {
                case 'title':
                    $query->set('orderby', 'title');
                    $query->set('order', 'ASC');
                    break;
                case 'title-desc':
                    $query->set('orderby', 'title');
                    $query->set('order', 'DESC');
                    break;
                case 'price':
                    $query->set('orderby', 'meta_value_num');
                    $query->set('meta_key', '_price');
                    $query->set('order', 'ASC');
                    break;
                case 'price-desc':
                    $query->set('orderby', 'meta_value_num');
                    $query->set('meta_key', '_price');
                    $query->set('order', 'DESC');
                    break;
                case 'date':
                    $query->set('orderby', 'date');
                    $query->set('order', 'DESC');
                    break;
                case 'popularity':
                    $query->set('orderby', 'meta_value_num');
                    $query->set('meta_key', 'total_sales');
                    $query->set('order', 'DESC');
                    break;
                case 'menu_order':
                default:
                    $query->set('orderby', 'menu_order');
                    $query->set('order', 'ASC');
                    break;
            }
        }
        
        // Brand filter
        if (isset($_GET['brand_filter']) && !empty($_GET['brand_filter'])) {
            $brand_slugs = explode(',', sanitize_text_field($_GET['brand_filter']));
            
            // Add brand taxonomy query
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'product_brand',
                    'field' => 'slug',
                    'terms' => $brand_slugs,
                    'operator' => 'IN'
                )
            ));
        }
        
        // Price filter
        if (isset($_GET['price_filter']) && !empty($_GET['price_filter']) && $_GET['price_filter'] !== 'all') {
            $price_range = sanitize_text_field($_GET['price_filter']);
            
            // Parse price range
            if (strpos($price_range, '-') !== false) {
                $prices = explode('-', $price_range);
                $min_price = intval($prices[0]);
                $max_price = intval($prices[1]);
                
                $query->set('meta_query', array(
                    array(
                        'key' => '_price',
                        'value' => array($min_price, $max_price),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    )
                ));
            } elseif (strpos($price_range, '+') !== false) {
                $min_price = intval(str_replace('+', '', $price_range));
                
                $query->set('meta_query', array(
                    array(
                        'key' => '_price',
                        'value' => $min_price,
                        'type' => 'NUMERIC',
                        'compare' => '>='
                    )
                ));
            }
        }
        
        // Combine meta queries if both filters are applied
        if (isset($_GET['brand_filter']) && isset($_GET['price_filter']) && 
            !empty($_GET['brand_filter']) && !empty($_GET['price_filter']) && $_GET['price_filter'] !== 'all') {
            
            $brand_slugs = explode(',', sanitize_text_field($_GET['brand_filter']));
            $price_range = sanitize_text_field($_GET['price_filter']);
            
            $tax_query = array(
                array(
                    'taxonomy' => 'product_brand',
                    'field' => 'slug',
                    'terms' => $brand_slugs,
                    'operator' => 'IN'
                )
            );
            
            $meta_query = array();
            
            // Parse price range
            if (strpos($price_range, '-') !== false) {
                $prices = explode('-', $price_range);
                $min_price = intval($prices[0]);
                $max_price = intval($prices[1]);
                
                $meta_query[] = array(
                    'key' => '_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN'
                );
            } elseif (strpos($price_range, '+') !== false) {
                $min_price = intval(str_replace('+', '', $price_range));
                
                $meta_query[] = array(
                    'key' => '_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                );
            }
            
            $query->set('tax_query', $tax_query);
            if (!empty($meta_query)) {
                $query->set('meta_query', $meta_query);
            }
        }
    }
}
add_action('pre_get_posts', 'aratavietnam_filter_products');

/**
 * Add brand taxonomy to product query
 */
function aratavietnam_add_brand_to_product_query($query) {
    if (!is_admin() && $query->is_main_query() && 
        (is_shop() || is_product_category() || is_product_tag())) {
        
        // Add brand taxonomy to the query
        $query->set('tax_query', array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => get_queried_object_id(),
                'operator' => 'IN'
            )
        ));
    }
}

/**
 * Get filtered product count for each brand
 */
function aratavietnam_get_brand_product_count($brand_slug, $current_filters = array()) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_brand',
                'field' => 'slug',
                'terms' => $brand_slug
            )
        )
    );
    
    // Apply price filter if present
    if (isset($current_filters['price_filter']) && !empty($current_filters['price_filter']) && $current_filters['price_filter'] !== 'all') {
        $price_range = $current_filters['price_filter'];
        
        if (strpos($price_range, '-') !== false) {
            $prices = explode('-', $price_range);
            $min_price = intval($prices[0]);
            $max_price = intval($prices[1]);
            
            $args['meta_query'] = array(
                array(
                    'key' => '_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN'
                )
            );
        } elseif (strpos($price_range, '+') !== false) {
            $min_price = intval(str_replace('+', '', $price_range));
            
            $args['meta_query'] = array(
                array(
                    'key' => '_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                )
            );
        }
    }
    
    $query = new WP_Query($args);
    return $query->found_posts;
}

/**
 * Add AJAX handler for dynamic filter updates
 */
function aratavietnam_ajax_update_filters() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'product_filter_nonce')) {
        wp_die('Security check failed');
    }
    
    $filters = array();
    if (isset($_POST['price_filter'])) {
        $filters['price_filter'] = sanitize_text_field($_POST['price_filter']);
    }
    if (isset($_POST['brand_filter'])) {
        $filters['brand_filter'] = sanitize_text_field($_POST['brand_filter']);
    }
    
    // Get updated brand counts
    $brands = get_terms(array(
        'taxonomy' => 'product_brand',
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC',
    ));
    
    $brand_counts = array();
    foreach ($brands as $brand) {
        $brand_counts[$brand->slug] = aratavietnam_get_brand_product_count($brand->slug, $filters);
    }
    
    wp_send_json_success(array(
        'brand_counts' => $brand_counts,
        'total_products' => aratavietnam_get_filtered_product_count($filters)
    ));
}
add_action('wp_ajax_update_product_filters', 'aratavietnam_ajax_update_filters');
add_action('wp_ajax_nopriv_update_product_filters', 'aratavietnam_ajax_update_filters');

/**
 * Get total filtered product count
 */
function aratavietnam_get_filtered_product_count($filters = array()) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    
    // Apply brand filter
    if (isset($filters['brand_filter']) && !empty($filters['brand_filter'])) {
        $brand_slugs = explode(',', $filters['brand_filter']);
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_brand',
                'field' => 'slug',
                'terms' => $brand_slugs,
                'operator' => 'IN'
            )
        );
    }
    
    // Apply price filter
    if (isset($filters['price_filter']) && !empty($filters['price_filter']) && $filters['price_filter'] !== 'all') {
        $price_range = $filters['price_filter'];
        
        if (strpos($price_range, '-') !== false) {
            $prices = explode('-', $price_range);
            $min_price = intval($prices[0]);
            $max_price = intval($prices[1]);
            
            $args['meta_query'] = array(
                array(
                    'key' => '_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN'
                )
            );
        } elseif (strpos($price_range, '+') !== false) {
            $min_price = intval(str_replace('+', '', $price_range));
            
            $args['meta_query'] = array(
                array(
                    'key' => '_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                )
            );
        }
    }
    
    $query = new WP_Query($args);
    return $query->found_posts;
}
