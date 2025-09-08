#!/bin/bash

# Script to update featured images for ALL pages
echo "Starting featured image update for ALL pages..."
echo "============================================"

# Define page-specific search terms
declare -A page_search_terms=(
    [4]="arata-vietnam-homepage-beauty-cosmetics"
    [185]="arata-vietnam-about-us-company"
    [189]="arata-vietnam-products-skincare"
    [488]="arata-vietnam-services-beauty"
    [113]="arata-vietnam-news-beauty-blog"
    [159]="arata-vietnam-promotion-discount"
    [160]="arata-vietnam-careers-recruitment"
    [71]="arata-vietnam-contact-information"
    [161]="arata-vietnam-blog-beauty-tips"
    [15]="arata-vietnam-my-account"
    [14]="arata-vietnam-checkout-payment"
    [13]="arata-vietnam-shopping-cart"
)

# Function to update featured image
update_featured_image() {
    local page_id="$1"
    local search_term="$2"
    
    # Import image directly from URL and set as featured image
    docker-compose exec -T wordpress su www-data -s /bin/bash -c "wp media import 'https://picsum.photos/seed/${search_term}/1200/800.jpg' \
        --title='Featured image for page ${page_id}' \
        --post_id='${page_id}' \
        --featured_image" 2>/dev/null
    
    if [ $? -eq 0 ]; then
        echo "✓ Updated featured image for page ID: $page_id"
    else
        echo "✗ Failed to update featured image for page ID: $page_id"
    fi
}

# Update each page
for page_id in "${!page_search_terms[@]}"; do
    search_term="${page_search_terms[$page_id]}"
    update_featured_image "$page_id" "$search_term"
    sleep 0.5
done

echo ""
echo "============================================"
echo "All pages have been updated with featured images!"

# List pages with their featured image status
echo ""
echo "Checking featured image status..."
docker-compose exec -T wordpress su www-data -s /bin/bash -c "wp post list --post_type=page --format=table --fields=ID,post_title"