#!/bin/bash
# Script to update featured images for the 'job_posting' post type.

POST_TYPE="job_posting"
TMP_DIR="/tmp/aratavietnam_images"
UNSPLASH_BASE_URL="https://source.unsplash.com/1200x800/"

echo "=================================================="
echo "Processing post type: $POST_TYPE"
echo "=================================================="

mkdir -p "$TMP_DIR"

process_post() {
    POST_ID=$1
    POST_TITLE=$(docker-compose exec -T wp-cli wp post get "$POST_ID" --field=post_title --allow-root)
    echo "Processing Job Posting ID #$POST_ID: $POST_TITLE"

    KEYWORDS=$(echo "$POST_TITLE" | tr ' ' ',' | tr -d '[:punct:]')
    IMAGE_URL="${UNSPLASH_BASE_URL}?${KEYWORDS},job,hiring,office,career"
    DOWNLOAD_PATH="$TMP_DIR/$POST_ID.jpg"

    echo " -> Downloading image..."
    curl -L -s -o "$DOWNLOAD_PATH" "$IMAGE_URL"

    if [ ! -s "$DOWNLOAD_PATH" ]; then
        echo " -> ERROR: Failed to download image. Skipping."
        return
    fi

    echo " -> Importing image to Media Library..."
    ATTACHMENT_ID=$(docker-compose exec -T wp-cli wp media import "$DOWNLOAD_PATH" --porcelain --allow-root)

    if [ -z "$ATTACHMENT_ID" ] || ! [[ "$ATTACHMENT_ID" =~ ^[0-9]+$ ]]; then
        echo " -> ERROR: Failed to import media. Skipping."
        rm "$DOWNLOAD_PATH"
        return
    fi

    echo " -> Setting attachment #$ATTACHMENT_ID as featured image."
    docker-compose exec -T wp-cli wp post thumbnail set "$POST_ID" "$ATTACHMENT_ID" --allow-root

    echo " -> SUCCESS: Featured image updated for Job Posting ID #$POST_ID."
    rm "$DOWNLOAD_PATH"
}

POST_IDS=$(docker-compose exec -T wp-cli wp post list \
    --post_type="$POST_TYPE" \
    --format=ids \
    --meta_key=_thumbnail_id \
    --meta_compare='NOT EXISTS' \
    --allow-root)

if [ -z "$POST_IDS" ]; then
    echo "No job postings of type '$POST_TYPE' are missing a featured image."
else
    for POST_ID in $POST_IDS; do
        process_post "$POST_ID"
    done
fi

rm -rf "$TMP_DIR"
echo "Finished processing $POST_TYPE."

