#!/bin/bash

# Fix partner post featured images
echo "=== FIXING PARTNER POST FEATURED IMAGES ==="

CONTAINER="wordpress_app"

# Partner post IDs and their corresponding image IDs
declare -A partner_images=(
    [637]=631  # Shopee
    [638]=632  # Amazon
    [639]=633  # Lazada
    [640]=635  # Google
    [641]=636  # Tiki
    [642]=601  # Apple
)

for post_id in "${!partner_images[@]}"; do
    image_id="${partner_images[$post_id]}"
    echo "Updating partner post $post_id with image ID $image_id"
    docker exec "$CONTAINER" wp post meta update "$post_id" _thumbnail_id "$image_id" --allow-root
done

echo "=== PARTNER FEATURED IMAGES FIXED ==="