#!/bin/bash

# Script to update featured images for all pages using correct user
echo "Starting featured image update process..."
echo "============================================"

# Function to update featured image
update_featured_image() {
    local page_title="$1"
    local page_id="$2"
    local search_term="$3"
    
    echo "Processing page: $page_title (ID: $page_id)"
    
    # Create image URL with search term as seed
    local image_url="https://picsum.photos/seed/${search_term}/1200/800.jpg"
    
    # Import image directly from URL and set as featured image
    # Run as www-data user
    docker-compose exec -T wordpress su www-data -s /bin/bash -c "wp media import '$image_url' \
        --title='Featured image for $page_title' \
        --post_id='$page_id' \
        --featured_image"
    
    if [ $? -eq 0 ]; then
        echo "✓ Updated featured image for page: $page_title"
    else
        echo "✗ Failed to update featured image for: $page_title"
    fi
    
    echo "---"
}

# Get all pages and process them
echo "Getting all pages from WordPress..."
docker-compose exec -T wordpress su www-data -s /bin/bash -c "wp post list --post_type=page --format=csv --fields=ID,post_title" | while IFS=, read -r page_id page_title; do
    # Remove quotes from title
    page_title=$(echo "$page_title" | sed 's/^"//' | sed 's/"$//')
    
    # Skip header
    if [ "$page_id" = "ID" ]; then
        continue
    fi
    
    # Skip if no title
    if [ -z "$page_title" ]; then
        continue
    fi
    
    # Clean title for search
    clean_title=$(echo "$page_title" | tr '[:upper:]' '[:lower:]' | sed 's/[^a-z0-9]/ /g' | sed 's/  */ /g' | xargs)
    
    # Determine search term based on page title
    case "$clean_title" in
        *trang*chu*|*home*)
            search_term="arata-vietnam-homepage"
            ;;
        *gioi*thieu*|*about*)
            search_term="arata-vietnam-about"
            ;;
        *san*pham*|*product*)
            search_term="arata-vietnam-products"
            ;;
        *dich*vu*|*service*)
            search_term="arata-vietnam-services"
            ;;
        *tin*tuc*|*blog*|*news*)
            search_term="arata-vietnam-news"
            ;;
        *lien*he*|*contact*)
            search_term="arata-vietnam-contact"
            ;;
        *khuyen*mai*|*promotion*)
            search_term="arata-vietnam-promotion"
            ;;
        *tuyen*dung*|*career*)
            search_term="arata-vietnam-careers"
            ;;
        *cua*hang*|*store*|*shop*)
            search_term="arata-vietnam-store"
            ;;
        *)
            # Use page ID as seed for unique images
            search_term="arata-vietnam-page-${page_id}"
            ;;
    esac
    
    update_featured_image "$page_title" "$page_id" "$search_term"
    
    # Small delay to avoid rate limiting
    sleep 0.5
done

echo ""
echo "============================================"
echo "Featured image update process completed!"