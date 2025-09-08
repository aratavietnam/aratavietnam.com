#!/bin/bash

# Update homepage images using Docker WP CLI - Fixed version
# Script downloads and sets featured images for homepage sections

echo "=== UPDATING HOMEPAGE IMAGES ==="

# Container name
CONTAINER="wordpress_app"

# Image URLs
HERO_IMAGE="https://images.unsplash.com/photo-1620916566398-39f1686d6042?w=1920&h=600&fit=crop"
ABOUT_IMAGE_1="https://images.unsplash.com/photo-1612810286534-34a653b89d9a?w=800&h=600&fit=crop"
ABOUT_IMAGE_2="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&h=600&fit=crop"
PARTNER_IMAGES=(
    "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Shopee_logo.svg/320px-Shopee_logo.svg.png"
    "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Amazon_logo.svg/320px-Amazon_logo.svg.png"
    "https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/Lazada_Logo.svg/320px-Lazada_Logo.svg.png"
    "https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/320px-Google_%22G%22_Logo.svg.png"
    "https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Tiki_logo.svg/320px-Tiki_logo.svg.png"
    "https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/320px-Apple_logo_black.svg.png"
)

# Create temp directory
mkdir -p /tmp/homepage-images
cd /tmp/homepage-images

# Function to download and import image
download_and_import() {
    local url=$1
    local filename=$2
    local title=$3
    
    echo "Downloading $filename..."
    curl -s -o "$filename" "$url"
    
    # Copy to container
    docker cp "$filename" "$CONTAINER:/tmp/$filename"
    
    # Import to WordPress media library
    docker exec "$CONTAINER" wp media import "/tmp/$filename" --title="$title" --allow-root
    
    # Get attachment ID using post list
    local attachment_id=$(docker exec "$CONTAINER" wp post list --post_type=attachment --title="$title" --format=ids --allow-root)
    
    echo "Imported $filename with ID: $attachment_id"
    echo "$attachment_id"
}

# Download hero image
echo "=== DOWNLOADING HERO IMAGE ==="
HERO_ID=$(download_and_import "$HERO_IMAGE" "hero-bg.jpg" "Arata Hero Background")

# Download about images
echo "=== DOWNLOADING ABOUT IMAGES ==="
ABOUT_ID_1=$(download_and_import "$ABOUT_IMAGE_1" "about-1.jpg" "About Arata Image 1")
ABOUT_ID_2=$(download_and_import "$ABOUT_IMAGE_2" "about-2.jpg" "About Arata Image 2")

# Download partner images
echo "=== DOWNLOADING PARTNER IMAGES ==="
PARTNER_IDS=()
for i in "${!PARTNER_IMAGES[@]}"; do
    filename="partner-$((i+1)).png"
    title="Partner Logo $((i+1))"
    id=$(download_and_import "${PARTNER_IMAGES[$i]}" "$filename" "$title")
    PARTNER_IDS+=("$id")
done

# Get homepage ID
HOMEPAGE_ID=$(docker exec "$CONTAINER" wp post list --post_type=page --name=homepage --format=ids --allow-root)

if [ -z "$HOMEPAGE_ID" ]; then
    echo "Homepage not found. Looking for front page..."
    HOMEPAGE_ID=$(docker exec "$CONTAINER" wp option get page_on_front --allow-root)
fi

echo "Homepage ID: $HOMEPAGE_ID"

# Update homepage meta fields with image IDs
echo "=== UPDATING HOMEPAGE META FIELDS ==="

# Hero image
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_hero_image "$HERO_ID" --allow-root

# About images
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_about_image_1 "$ABOUT_ID_1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_about_image_2 "$ABOUT_ID_2" --allow-root

# Partner images (store as serialized array)
PARTNER_ARRAY=$(printf '%s\n' "${PARTNER_IDS[@]}" | jq -R . | jq -s .)
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_partner_logos "$PARTNER_ARRAY" --allow-root

# Also update hero section title and description
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_hero_title "Chào Mừng Đến Với Arata Vietnam" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_hero_description "Nhà phân phối mỹ phẩm Nhật Bản chính hãng tại Việt Nam" --allow-root

# Enable all homepage sections
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_marquee "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_featured_products "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_all_products "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_about "1" --allow-root
docker exec "$CONTAINER" wp post meta update "$HOMEPAGE_ID" arata_show_partners "1" --allow-root

echo "=== CLEANING UP ==="
# Clean up temp files
rm -rf /tmp/homepage-images
docker exec "$CONTAINER" bash -c "rm -f /tmp/*.jpg /tmp/*.png" --allow-root

echo "=== HOMEPAGE IMAGES UPDATED SUCCESSFULLY ==="
echo "Hero Image ID: $HERO_ID"
echo "About Image 1 ID: $ABOUT_ID_1"
echo "About Image 2 ID: $ABOUT_ID_2"
echo "Partner Image IDs: ${PARTNER_IDS[*]}"