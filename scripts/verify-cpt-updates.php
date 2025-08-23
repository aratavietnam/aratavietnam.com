<?php

$post_ids_to_verify = [263, 305, 214, 208, 235];

echo "Verifying focus keyword updates for sample items...\n";

foreach ($post_ids_to_verify as $post_id) {
    $focus_keyword = get_post_meta($post_id, 'rank_math_focus_keyword', true);
    $title = get_the_title($post_id);
    $post_type = get_post_type($post_id);

    echo "---\n";
    echo "Post Type: " . $post_type . "\n";
    echo "Title: " . $title . "\n";
    echo "Focus Keyword: " . $focus_keyword . "\n";
}

echo "---\nVerification complete.\n";

