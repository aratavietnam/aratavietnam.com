<?php

// Get all published posts
$posts = get_posts(['post_type' => 'post', 'numberposts' => -1, 'post_status' => 'publish']);

if (empty($posts)) {
    echo "No posts found to update.\n";
    exit;
}

echo "Starting to update focus keywords for all posts...\n";

foreach ($posts as $post) {
    // Get the post title
    $title = get_the_title($post->ID);

    // Update the Rank Math focus keyword
    update_post_meta($post->ID, 'rank_math_focus_keyword', strtolower($title));

    echo "Updated focus keyword for post '" . $title . "' (ID: " . $post->ID . ").\n";
}

echo "Bulk update of focus keywords is complete.\n";

