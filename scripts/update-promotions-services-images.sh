#!/bin/bash

# Script to update featured images for promotions and services
echo "Starting featured image update for promotions and services..."
echo "========================================================"

# Create temporary directory
mkdir -p temp-posts-images

# Update featured image for a post
update_post_featured_image() {
    local post_id="$1"
    local post_title="$2"
    local image_url="$3"
    local post_type="$4"
    
    echo "Processing $post_type: $post_title (ID: $post_id)"
    
    # Download image
    filename="${post_type}-${post_id}.jpg"
    temp_path="temp-posts-images/${filename}"
    
    if curl -s -f -o "$temp_path" "$image_url"; then
        echo "✓ Downloaded image for: $post_title"
        
        # Copy to WordPress container
        year_month=$(date +%Y/%m)
        docker exec wordpress_app mkdir -p /var/www/html/wp-content/uploads/${year_month}
        docker cp "$temp_path" wordpress_app:/var/www/html/wp-content/uploads/${year_month}/${filename}
        
        # Import and set as featured image
        result=$(docker exec wordpress_app wp media import "/var/www/html/wp-content/uploads/${year_month}/${filename}" \
            --title="Featured image for $post_title" \
            --allow-root 2>/dev/null)
        
        if echo "$result" | grep -q "Success"; then
            attachment_id=$(echo "$result" | grep -o "ID [0-9]*" | cut -d' ' -f2)
            if [ -n "$attachment_id" ]; then
                docker exec wordpress_app wp post meta set "$post_id" "_thumbnail_id" "$attachment_id" --allow-root
                echo "✓ Set featured image for: $post_title"
            fi
        else
            echo "✗ Failed to import image for: $post_title"
        fi
        
        # Clean up
        rm -f "$temp_path"
    else
        echo "✗ Failed to download image for: $post_title"
    fi
    
    echo "---"
    sleep 1
}

# Process promotions
echo "Processing promotions..."
echo "===================="

# Promotion images (beauty/cosmetics promotional content)
promotions=(
    "117,https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=800&h=600&fit=crop"
    "118,https://images.unsplash.com/photo-1522383225653-ed111181a951?w=800&h=600&fit=crop"
    "119,https://images.unsplash.com/photo-1608302014444-756deb2d8b6d?w=800&h=600&fit=crop"
    "210,https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&h=600&fit=crop"
    "212,https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&h=600&fit=crop"
    "214,https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800&h=600&fit=crop"
    "589,https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=800&h=600&fit=crop"
)

for promo in "${promotions[@]}"; do
    IFS=',' read -r post_id image_url <<< "$promo"
    post_title=$(docker exec wordpress_app wp post get "$post_id" --field=post_title --allow-root)
    update_post_featured_image "$post_id" "$post_title" "$image_url" "promotion"
done

# Process services
echo "Processing services..."
echo "===================="

# Service images (professional business services)
services=(
    "235,https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop"
    "233,https://images.unsplash.com/photo-1526378530730-429e1606dcff?w=800&h=600&fit=crop"
    "232,https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop"
)

for service in "${services[@]}"; do
    IFS=',' read -r post_id image_url <<< "$service"
    post_title=$(docker exec wordpress_app wp post get "$post_id" --field=post_title --allow-root)
    update_post_featured_image "$post_id" "$post_title" "$image_url" "service"
done

# Clean up
rm -rf temp-posts-images

echo ""
echo "========================================================"
echo "Featured image update completed for promotions and services!"