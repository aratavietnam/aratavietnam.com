<?php

// Get the current Rank Math titles options
$options = get_option('rank-math-options-titles');

if (!$options) {
    echo "Error: Could not retrieve Rank Math settings.\n";
    exit(1);
}

// Define the new settings for blog posts
$new_post_settings = [
    'pt_post_title' => '%title% - %sitename%',
    'pt_post_description' => '%excerpt%',
    'pt_post_default_rich_snippet' => 'article',
    'pt_post_default_article_type' => 'BlogPosting',
];

// Merge the new settings into the existing options
$updated_options = array_merge($options, $new_post_settings);

// Update the option in the database
$result = update_option('rank-math-options-titles', $updated_options);

if ($result) {
    echo "Successfully updated Rank Math SEO settings for blog posts.\n";
} else {
    echo "Notice: Settings were not changed. They may already be up to date.\n";
}

