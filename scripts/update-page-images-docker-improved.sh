#!/bin/bash

# Script to update featured images for all pages using Docker
# Downloads beauty/cosmetics related images and sets them as featured images

echo "Starting featured image update process..."
echo "============================================"

# Create temporary directory for downloads
mkdir -p temp-images

# Function to download and set featured image
update_featured_image() {
    local page_id="$1"
    local page_title="$2"
    local image_url="$3"
    
    echo "Processing: $page_title (ID: $page_id)"
    
    # Download image using Docker curl
    local filename="page-${page_id}.jpg"
    local temp_path="temp-images/${filename}"
    
    if curl -s -f -o "$temp_path" "$image_url"; then
        echo "✓ Downloaded image for: $page_title"
        
        # Copy image to WordPress container
        docker cp "$temp_path" wordpress_app:/var/www/html/wp-content/uploads/"${filename}"
        
        # Set as featured image using wp-cli
        docker-compose exec -T wordpress_app wp media import "/var/www/html/wp-content/uploads/${filename}" \
            --title="Featured image for ${page_title}" \
            --post_id="$page_id" \
            --featured_image \
            --allow-root
        
        if [ $? -eq 0 ]; then
            echo "✓ Updated featured image for: $page_title"
        else
            echo "✗ Failed to set featured image for: $page_title"
        fi
        
        # Clean up
        rm -f "$temp_path"
        docker-compose exec -T wordpress_app rm -f "/var/www/html/wp-content/uploads/${filename}"
    else
        echo "✗ Failed to download image for: $page_title"
    fi
    
    echo "---"
}

# Get all pages and process them
echo "Getting pages from WordPress..."
docker-compose exec -T wordpress_app wp post list --post_type=page --format=csv --fields=ID,post_title --allow-root | tail -n +2 | while IFS=, read -r page_id page_title; do
    # Remove quotes from title
    page_title=$(echo "$page_title" | sed 's/"//g')
    
    # Determine image URL based on page title
    case "$page_title" in
        "Trang chủ")
            image_url="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=1200&h=800&fit=crop"
            ;;
        "Về Arata Vietnam")
            image_url="https://images.unsplash.com/photo-1522383225653-ed111181a951?w=1200&h=800&fit=crop"
            ;;
        "Sản phẩm")
            image_url="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=1200&h=800&fit=crop"
            ;;
        "Dịch vụ")
            image_url="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=1200&h=800&fit=crop"
            ;;
        "Blog"|"Tin tức")
            image_url="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200&h=800&fit=crop"
            ;;
        "Tuyển dụng")
            image_url="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=800&fit=crop"
            ;;
        "Khuyến mãi")
            image_url="https://images.unsplash.com/photo-1608302014444-756deb2d8b6d?w=1200&h=800&fit=crop"
            ;;
        "Liên hệ")
            image_url="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=800&fit=crop"
            ;;
        *)
            # Use a generic beauty image for unknown pages
            image_url="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=1200&h=800&fit=crop"
            ;;
    esac
    
    update_featured_image "$page_id" "$page_title" "$image_url"
    
    # Small delay
    sleep 2
done

# Clean up
rm -rf temp-images

echo ""
echo "============================================"
echo "Featured image update process completed!"