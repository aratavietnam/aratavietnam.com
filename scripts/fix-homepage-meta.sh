#!/bin/bash

# Fix homepage meta fields to match template expectations
echo "=== FIXING HOMEPAGE META FIELDS ==="

CONTAINER="wordpress_app"
HOMEPAGE_ID=4

# Hero section uses slide images
echo "Updating hero slide images..."
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" _slide1_image 634 --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" _slide2_image 635 --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" _slide3_image 636 --allow-root

# About section uses _about_image_ format
echo "Updating about section images..."
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" _about_image_1 634 --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" _about_image_2 635 --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" _about_image_3 636 --allow-root

# Partners section uses partner post type, not meta fields
echo "Creating partner posts..."

# Create partner posts if they don't exist
PARTNER_NAMES=("Shopee" "Amazon" "Lazada" "Google" "Tiki" "Apple")
PARTNER_IMAGE_IDS=(631 632 633 635 636 601)

for i in "${!PARTNER_NAMES[@]}"; do
    name="${PARTNER_NAMES[$i]}"
    image_id="${PARTNER_IMAGE_IDS[$i]}"
    
    # Check if partner post already exists
    post_id=$(docker exec "$CONTAINER" wp post list --post_type=partner --title="$name" --format=ids --allow-root)
    
    if [ -z "$post_id" ]; then
        echo "Creating partner post: $name"
        # Create partner post
        post_id=$(docker exec "$CONTAINER" wp post create --post_type=partner --post_title="$name" --post_status=publish --format=ids --allow-root)
        
        # Set featured image
        docker exec "$CONTAINER" wp post meta update "$post_id" _thumbnail_id "$image_id" --allow-root
        
        # Set menu order
        docker exec "$CONTAINER" wp post update "$post_id" --menu_order=$((i+1)) --allow-root
    else
        echo "Partner post '$name' already exists with ID: $post_id"
        # Update featured image
        docker exec "$CONTAINER" wp post meta update "$post_id" _thumbnail_id "$image_id" --allow-root
    fi
done

# Also ensure hero section is enabled
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_hero 1 --allow-root

echo "=== HOMEPAGE META FIELDS FIXED ==="