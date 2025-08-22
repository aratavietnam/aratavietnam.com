#!/bin/bash

POST_TYPE=$1

echo "Checking for missing thumbnails in post type: $POST_TYPE"

# Get all post IDs for the given post type
POST_IDS=$(wp post list --post_type=$POST_TYPE --format=ids --allow-root)

if [ -z "$POST_IDS" ]; then
    echo "No posts found for type $POST_TYPE."
    exit 0
fi

# Loop through each post ID and check for a thumbnail
for id in $POST_IDS; do
    THUMBNAIL_ID=$(wp post meta get $id _thumbnail_id --allow-root)
    if [ -z "$THUMBNAIL_ID" ]; then
        POST_TITLE=$(wp post get $id --field=post_title --allow-root)
        echo "Post ID: $id - Title: '$POST_TITLE' is MISSING a thumbnail."
    fi
done

echo "Check complete."
