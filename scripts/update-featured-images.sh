#!/bin/bash

# Script to automatically find and set featured images for posts that are missing them.

# --- CONFIGURATION ---
# Post types to process. Space-separated list.
POST_TYPES="post page promotion job_posting"

# Temporary directory for downloading images.
TMP_DIR="/tmp/aratavietnam_images"

# Unsplash API URL for random photos. You can add keywords based on post title.
# Example: https://source.unsplash.com/1200x800/?nature,water
UNSPLASH_BASE_URL="https://source.unsplash.com/1200x800/"

# --- SCRIPT START ---

echo "Starting featured image update process..."

# Create temporary directory if it doesn't exist.
mkdir -p "$TMP_DIR"

# Function to process a single post.
process_post() {
    POST_ID=$1
    POST_TITLE=$(docker-compose exec -T wp-cli wp post get "$POST_ID" --field=post_title --allow-root)

    echo "Processing Post ID #$POST_ID: $POST_TITLE"

    # 1. Find a suitable image using the post title as a keyword.
    # Replace spaces with commas for Unsplash query.
    KEYWORDS=$(echo "$POST_TITLE" | tr ' ' ',' | tr -d '[:punct:]')
    IMAGE_URL="${UNSPLASH_BASE_URL}?${KEYWORDS},business,technology"
    DOWNLOAD_PATH="$TMP_DIR/$POST_ID.jpg"

    echo " -> Downloading image from Unsplash with keywords: $KEYWORDS"
    curl -L -s -o "$DOWNLOAD_PATH" "$IMAGE_URL"

    # Check if the download was successful and the file is not empty.
    if [ ! -s "$DOWNLOAD_PATH" ]; then
        echo " -> ERROR: Failed to download image for Post ID #$POST_ID. Skipping."
        return
    fi

    # 2. Import the image into the WordPress Media Library.
    echo " -> Importing image to Media Library..."
    ATTACHMENT_ID=$(docker-compose exec -T wp-cli wp media import "$DOWNLOAD_PATH" --porcelain --allow-root)

    if [ -z "$ATTACHMENT_ID" ] || ! [[ "$ATTACHMENT_ID" =~ ^[0-9]+$ ]]; then
        echo " -> ERROR: Failed to import media for Post ID #$POST_ID. Attachment ID: $ATTACHMENT_ID. Skipping."
        # Clean up the downloaded file.
        rm "$DOWNLOAD_PATH"
        return
    fi

    # 3. Set the imported image as the featured image.
    echo " -> Setting attachment #$ATTACHMENT_ID as featured image."
    docker-compose exec -T wp-cli wp post thumbnail set "$POST_ID" "$ATTACHMENT_ID" --allow-root

    echo " -> SUCCESS: Featured image updated for Post ID #$POST_ID."

    # 4. Clean up the downloaded file.
    rm "$DOWNLOAD_PATH"
}

# Loop through all specified post types.
for POST_TYPE in $POST_TYPES; do
    echo ""
    echo "=================================================="
    echo "Processing post type: $POST_TYPE"
    echo "=================================================="

    # Get the list of posts that are missing a featured image.
    POST_IDS=$(docker-compose exec -T wp-cli wp post list \
        --post_type="$POST_TYPE" \
        --format=ids \
        --meta_key=_thumbnail_id \
        --meta_compare='NOT EXISTS' \
        --allow-root)

    if [ -z "$POST_IDS" ]; then
        echo "No posts of type '$POST_TYPE' are missing a featured image."
        continue
    fi

    # Loop through each post ID and process it.
    for POST_ID in $POST_IDS; do
        process_post "$POST_ID"
    done
done

# Clean up the temporary directory.
rm -rf "$TMP_DIR"

echo ""
echo "Featured image update process completed!"
