<?php

$post_types_to_update = ['product', 'partner', 'promotion', 'job_posting', 'service'];

echo "Starting bulk update of focus keywords for custom post types...\n";

foreach ($post_types_to_update as $post_type) {
    $posts = get_posts(['post_type' => $post_type, 'numberposts' => -1, 'post_status' => 'publish']);

    if (empty($posts)) {
        echo "No items found for post type '" . $post_type . "'. Skipping.\n";
        continue;
    }

    echo "Updating items for post type '" . $post_type . "'...\n";

    foreach ($posts as $post) {
        $title = get_the_title($post->ID);
        update_post_meta($post->ID, 'rank_math_focus_keyword', strtolower($title));
        echo "  - Updated '" . $title . "' (ID: " . $post->ID . ").\n";
    }
}

echo "Bulk update of focus keywords for custom post types is complete.\n";

