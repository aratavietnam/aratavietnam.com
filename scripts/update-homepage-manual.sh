#!/bin/bash

# Simple script to update homepage images manually
echo "=== UPDATING HOMEPAGE IMAGES MANUALLY ==="

CONTAINER="wordpress_app"
HOMEPAGE_ID=4

# Use existing images or manually specified IDs
# Let's use some of the recently imported images
HERO_IMAGE_ID=634  # about-2.jpg
ABOUT_IMAGE_1_ID=635  # partner-2.png  
ABOUT_IMAGE_2_ID=636  # partner-6.png

# Partner logo IDs (using some existing images)
PARTNER_IDS=(631 632 633 635 636 601)

echo "Updating homepage meta fields..."
echo "Homepage ID: $HOMEPAGE_ID"
echo "Hero Image ID: $HERO_IMAGE_ID"
echo "About Image 1 ID: $ABOUT_IMAGE_1_ID"
echo "About Image 2 ID: $ABOUT_IMAGE_2_ID"
echo "Partner IDs: ${PARTNER_IDS[*]}"

# Update hero image
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_hero_image "$HERO_IMAGE_ID" --allow-root

# Update about images
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_about_image_1 "$ABOUT_IMAGE_1_ID" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_about_image_2 "$ABOUT_IMAGE_2_ID" --allow-root

# Update partner images as serialized array
PARTNER_ARRAY=$(printf '%s\n' "${PARTNER_IDS[@]}" | jq -R . | jq -s .)
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_partner_logos "$PARTNER_ARRAY" --allow-root

# Update hero content
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_hero_title "Chào Mừng Đến Với Arata Vietnam" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_hero_description "Nhà phân phối mỹ phẩm Nhật Bản chính hãng tại Việt Nam" --allow-root

# Ensure all sections are enabled
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_marquee "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_featured_products "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_all_products "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_about "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_partners "1" --allow-root

echo "=== HOMEPAGE UPDATED SUCCESSFULLY ==="