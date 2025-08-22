#!/bin/bash
# Script to update featured images for the 'post' post type.

POST_TYPE="post"
TMP_DIR="/tmp/aratavietnam_images"
UNSPLASH_BASE_URL="https://source.unsplash.com/1200x800/"

echo "=================================================="
echo "Processing post type: $POST_TYPE"
echo "=================================================="

mkdir -p "$TMP_DIR"

process_post() {
    POST_ID=$1
    POST_TITLE=$(docker-compose exec -T wp-cli wp post get "$POST_ID" --field=post_title --allow-root)
    echo "Processing Post ID #$POST_ID: $POST_TITLE"

    # Using a reliable placeholder image service to ensure download success.
    IMAGE_URL="https://picsum.photos/1200/800"
    DOWNLOAD_PATH="$TMP_DIR/$POST_ID.jpg"

    echo " -> Downloading random image from Picsum Photos..."
    # Use a realistic User-Agent and fail on server errors to prevent downloading HTML pages
    curl -A "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36" \
         -L -s -f -o "$DOWNLOAD_PATH" "$IMAGE_URL"

    # Check if curl command succeeded and the file is not empty
    if [ $? -ne 0 ] || [ ! -s "$DOWNLOAD_PATH" ]; then
        echo " -> ERROR: Failed to download a valid image. The service may be unavailable or no image was found for the keywords. Skipping."
        return
    fi

    # Verify that the downloaded file is an image
    MIME_TYPE=$(file --brief --mime-type "$DOWNLOAD_PATH")
    if [[ "$MIME_TYPE" != "image/"* ]]; then
        echo " -> ERROR: Downloaded file is not an image (MIME: $MIME_TYPE). Skipping."
        rm "$DOWNLOAD_PATH"
        return
    fi

    echo " -> Image downloaded successfully ($MIME_TYPE)."

    echo " -> Importing image to Media Library..."
    ATTACHMENT_ID=$(docker-compose exec -T wp-cli wp media import "$DOWNLOAD_PATH" --porcelain --allow-root)

    if [ -z "$ATTACHMENT_ID" ] || ! [[ "$ATTACHMENT_ID" =~ ^[0-9]+$ ]]; then
        echo " -> ERROR: Failed to import media. Skipping."
        rm "$DOWNLOAD_PATH"
        return
    fi

    echo " -> Setting attachment #$ATTACHMENT_ID as featured image."
    docker-compose exec -T wp-cli wp post thumbnail set "$POST_ID" "$ATTACHMENT_ID" --allow-root

    echo " -> SUCCESS: Featured image updated for Post ID #$POST_ID."
    rm "$DOWNLOAD_PATH"
}

POST_IDS=$(docker-compose exec -T wp-cli wp post list \
    --post_type="$POST_TYPE" \
    --format=ids \
    --meta_key=_thumbnail_id \
    --meta_compare='NOT EXISTS' \
    --allow-root)

if [ -z "$POST_IDS" ]; then
    echo "No posts of type '$POST_TYPE' are missing a featured image."
else
    for POST_ID in $POST_IDS; do
        process_post "$POST_ID"
    done
fi

rm -rf "$TMP_DIR"
echo "Finished processing $POST_TYPE."
