#!/bin/bash

# Script to update featured images for all pages using Docker WordPress container
echo "Starting featured image update process..."
echo "============================================"

# Create logs directory inside container
docker-compose exec -T wordpress mkdir -p /var/www/html/wp-content/uploads/featured-image-updates

# Function to search and download image
search_and_download_image() {
    local page_title="$1"
    local page_id="$2"
    local search_term="$3"
    
    echo "Processing page: $page_title (ID: $page_id)"
    
    # Create search query
    local query="${search_term} arata vietnam mỹ phẩm chăm sóc da"
    
    # Download placeholder image from picsum with search term as seed
    local image_url="https://picsum.photos/seed/${search_term}/1200/800.jpg"
    local temp_file="/tmp/page-${page_id}.jpg"
    
    # Download image inside container
    docker-compose exec -T wordpress bash -c "curl -s -f -o '$temp_file' '$image_url'"
    
    if [ $? -eq 0 ]; then
        echo "✓ Downloaded image for: $page_title"
        
        # Import image to WordPress media library
        docker-compose exec -T wordpress wp media import "$temp_file" \
            --title="Featured image for $page_title" \
            --post_id="$page_id" \
            --featured_image \
            --allow-root
        
        if [ $? -eq 0 ]; then
            echo "✓ Updated featured image for page: $page_title"
        else
            echo "✗ Failed to update featured image for: $page_title"
        fi
        
        # Clean up temp file
        docker-compose exec -T wordpress rm -f "$temp_file"
    else
        echo "✗ Failed to download image for: $page_title"
    fi
    
    echo "---"
}

# Get all pages
echo "Getting all pages from WordPress..."
docker-compose exec -T wordpress wp post list --post_type=page --format=csv --fields=ID,post_title --allow-root | while IFS=, read -r page_id page_title; do
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
            search_term="homepage beauty cosmetics"
            ;;
        *gioi*thieu*|*about*)
            search_term="about us company profile"
            ;;
        *san*pham*|*product*)
            search_term="cosmetics products skincare"
            ;;
        *dich*vu*|*service*)
            search_term="beauty services spa"
            ;;
        *tin*tuc*|*blog*|*news*)
            search_term="beauty news blog"
            ;;
        *lien*he*|*contact*)
            search_term="contact information"
            ;;
        *khuyen*mai*|*promotion*)
            search_term="promotion discount sale"
            ;;
        *tuyen*dung*|*career*)
            search_term="recruitment careers"
            ;;
        *)
            # Use first few words of title
            search_term=$(echo "$clean_title" | cut -d' ' -f1-3)
            ;;
    esac
    
    search_and_download_image "$page_title" "$page_id" "$search_term"
    
    # Small delay
    sleep 1
done

echo ""
echo "============================================"
echo "Featured image update process completed!"