<?php

// Get all published pages
$pages = get_posts(['post_type' => 'page', 'numberposts' => -1, 'post_status' => 'publish']);

if (empty($pages)) {
    echo "No pages found to update.\n";
    exit;
}

echo "Starting to update focus keywords for all pages...\n";

foreach ($pages as $page) {
    // Get the page title
    $title = get_the_title($page->ID);

    // Update the Rank Math focus keyword
    update_post_meta($page->ID, 'rank_math_focus_keyword', strtolower($title));

    echo "Updated focus keyword for page '" . $title . "' (ID: " . $page->ID . ").\n";
}

echo "Bulk update of focus keywords for pages is complete.\n";

