<?php
/**
 * Script to add Products menu item to WordPress menu
 * Access via: http://localhost:8000/wp-content/themes/aratavietnam/add-products-menu.php
 */

// Load WordPress
require_once('../../../wp-load.php');

// Check if user is admin (basic security)
if (!current_user_can('manage_options')) {
    die('Access denied. Please login as administrator.');
}

echo "<h2>Adding Products Menu Item</h2>";

// Get the shop page ID (should be 189 based on our earlier check)
$shop_page_id = get_option('woocommerce_shop_page_id');

if (!$shop_page_id) {
    // Create shop page if it doesn't exist
    $shop_page_id = wp_insert_post(array(
        'post_title' => 'Sản phẩm',
        'post_name' => 'san-pham',
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_content' => '<p>Trang sản phẩm của Arata Vietnam.</p>'
    ));
    
    // Set as WooCommerce shop page
    update_option('woocommerce_shop_page_id', $shop_page_id);
    echo "<p>✓ Created shop page with ID: $shop_page_id</p>";
} else {
    echo "<p>✓ Shop page already exists with ID: $shop_page_id</p>";
}

// Get primary menu
$menus = wp_get_nav_menus();
$primary_menu = null;

foreach ($menus as $menu) {
    $locations = get_nav_menu_locations();
    if (isset($locations['primary']) && $locations['primary'] == $menu->term_id) {
        $primary_menu = $menu;
        break;
    }
}

// If no primary menu, get the first menu or create one
if (!$primary_menu && !empty($menus)) {
    $primary_menu = $menus[0];
    echo "<p>✓ Using existing menu: {$primary_menu->name}</p>";
} elseif (!$primary_menu) {
    // Create primary menu
    $menu_id = wp_create_nav_menu('Primary Menu');
    $primary_menu = wp_get_nav_menu_object($menu_id);
    
    // Set as primary menu location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "<p>✓ Created primary menu: {$primary_menu->name}</p>";
} else {
    echo "<p>✓ Using primary menu: {$primary_menu->name}</p>";
}

// Check if products menu item already exists
$menu_items = wp_get_nav_menu_items($primary_menu->term_id);
$products_exists = false;

foreach ($menu_items as $item) {
    if ($item->object_id == $shop_page_id && $item->object == 'page') {
        $products_exists = true;
        echo "<p>✓ Products menu item already exists</p>";
        break;
    }
}

// Add products menu item if it doesn't exist
if (!$products_exists) {
    $menu_item_id = wp_update_nav_menu_item($primary_menu->term_id, 0, array(
        'menu-item-title' => 'Sản phẩm',
        'menu-item-object' => 'page',
        'menu-item-object-id' => $shop_page_id,
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish',
        'menu-item-position' => 2 // Place after home
    ));
    
    if (!is_wp_error($menu_item_id)) {
        echo "<p>✓ Added 'Sản phẩm' to menu</p>";
    } else {
        echo "<p>✗ Error adding menu item: " . $menu_item_id->get_error_message() . "</p>";
    }
}

// Flush rewrite rules
flush_rewrite_rules();
echo "<p>✓ Flushed rewrite rules</p>";

echo "<h3>Current Menu Items:</h3>";
$menu_items = wp_get_nav_menu_items($primary_menu->term_id);
if ($menu_items) {
    echo "<ul>";
    foreach ($menu_items as $item) {
        echo "<li>{$item->title} - {$item->url}</li>";
    }
    echo "</ul>";
}

echo "<p><strong>Setup completed!</strong></p>";
echo "<p>Shop page URL: <a href='" . get_permalink($shop_page_id) . "'>" . get_permalink($shop_page_id) . "</a></p>";
echo "<p><a href='/wp-admin/nav-menus.php'>View Menus in Admin</a></p>";
echo "<p><a href='/'>View Website</a></p>";
?>
