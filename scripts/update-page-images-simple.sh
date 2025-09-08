#!/bin/bash

# Simple script to update featured images for all pages
# Downloads images and copies them directly to WordPress uploads folder

echo "Starting featured image update process..."
echo "============================================"

# Create temporary directory for downloads
mkdir -p temp-images

# Image URLs for different pages
declare -A PAGE_IMAGES=(
    ["4"]="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=1200&h=800&fit=crop"          # Trang chủ
    ["185"]="https://images.unsplash.com/photo-1522383225653-ed111181a951?w=1200&h=800&fit=crop"     # Về Arata Vietnam
    ["189"]="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=1200&h=800&fit=crop"      # Sản phẩm
    ["488"]="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=1200&h=800&fit=crop"     # Dịch vụ
    ["161"]="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200&h=800&fit=crop"     # Blog
    ["113"]="https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200&h=800&fit=crop"     # Tin tức
    ["160"]="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=800&fit=crop"    # Tuyển dụng
    ["159"]="https://images.unsplash.com/photo-1608302014444-756deb2d8b6d?w=1200&h=800&fit=crop"     # Khuyến mãi
    ["71"]="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=800&fit=crop"      # Liên hệ
)

# Process each page
for page_id in "${!PAGE_IMAGES[@]}"; do
    image_url="${PAGE_IMAGES[$page_id]}"
    filename="featured-${page_id}.jpg"
    temp_path="temp-images/${filename}"
    
    echo "Processing page ID: $page_id"
    
    # Download image
    if curl -s -f -o "$temp_path" "$image_url"; then
        echo "✓ Downloaded image for page ID: $page_id"
        
        # Copy to WordPress uploads directory
        year_month=$(date +%Y/%m)
        docker exec wordpress_app mkdir -p /var/www/html/wp-content/uploads/${year_month}
        docker cp "$temp_path" wordpress_app:/var/www/html/wp-content/uploads/${year_month}/${filename}
        
        # Get attachment ID after import
        attachment_id=$(docker exec wordpress_app wp post list --post_type=attachment \
            --title="featured-${page_id}.jpg" --format=ids --allow-root 2>/dev/null | head -1)
        
        if [ -n "$attachment_id" ]; then
            # Set as featured image
            docker exec wordpress_app wp post meta set "$page_id" "_thumbnail_id" "$attachment_id" --allow-root
            echo "✓ Set featured image for page ID: $page_id"
        else
            # Import the media first
            import_result=$(docker exec wordpress_app wp media import "/var/www/html/wp-content/uploads/${year_month}/${filename}" \
                --title="Featured image for page $page_id" --allow-root 2>/dev/null)
            
            if echo "$import_result" | grep -q "Success"; then
                attachment_id=$(echo "$import_result" | grep -o "ID [0-9]*" | cut -d' ' -f2)
                if [ -n "$attachment_id" ]; then
                    docker exec wordpress_app wp post meta set "$page_id" "_thumbnail_id" "$attachment_id" --allow-root
                    echo "✓ Imported and set featured image for page ID: $page_id"
                fi
            else
                echo "✗ Failed to import image for page ID: $page_id"
            fi
        fi
        
        # Clean up
        rm -f "$temp_path"
    else
        echo "✗ Failed to download image for page ID: $page_id"
    fi
    
    echo "---"
    sleep 1
done

# Clean up
rm -rf temp-images

echo ""
echo "============================================"
echo "Featured image update process completed!"