#!/bin/bash

# Simple script to update remaining products one by one
# Usage: ./simple_update.sh

echo "=== SIMPLE PRODUCT IMAGE UPDATE ==="

# Function to update single product
update_product() {
    local id=$1
    local name="$2"
    local color="$3"
    
    echo "Updating Product ID $id: $name"
    
    # Ensure WP CLI is running
    docker-compose up wp-cli -d >/dev/null 2>&1
    sleep 3
    
    # Create simple main image
    magick -size 600x400 xc:"$color" -pointsize 20 -fill black -gravity center \
           -annotate +0+0 "$name" "/tmp/p${id}.jpg"
    
    # Copy to mounted volume
    cp "/tmp/p${id}.jpg" /tmp/aratavietnam_images/
    
    # Import and set as featured image
    attachment_id=$(docker-compose exec wp-cli wp media import "/tmp/aratavietnam_images/p${id}.jpg" --porcelain --allow-root 2>/dev/null | grep -o '[0-9]*' | head -n1)
    
    if [ -n "$attachment_id" ] && [ "$attachment_id" -gt 0 ]; then
        docker-compose exec wp-cli wp post meta update $id _thumbnail_id $attachment_id --allow-root >/dev/null 2>&1
        echo "  ✓ Featured image set: $attachment_id"
    else
        echo "  ✗ Failed to import image"
    fi
    
    # Cleanup
    rm -f "/tmp/p${id}.jpg"
    sleep 1
}

# Update remaining products (starting from failed ones)
update_product 448 "ELMIE Underwear Wash" "#E6E6FA"
update_product 444 "HERBAL POWDER Bleach" "#32CD32"  
update_product 442 "Washing Machine Cleaner" "#87CEEB"
update_product 440 "Mitsuei Toilet Cleaner" "#FF6347"
update_product 438 "SHABONDAMA Kids Toothpaste" "#FFB6C1"
update_product 434 "HERBAL FRESH Dish Soap" "#90EE90"
update_product 420 "Mitsuei Kitchen Foam" "#FFFF00"
update_product 261 "TO-PLAN Baby Cream" "#E0E0E0"
update_product 259 "Purevivi Cleansing Wax" "#FFEFD5"
update_product 257 "PAENNA Jobs Tears Milk" "#F5DEB3"
update_product 255 "PAENNA Jobs Tears Mask" "#F0E68C"
update_product 242 "Purevivi Cleansing Water" "#87CEFA"
update_product 240 "JELLAN Mens Lotion" "#4169E1"
update_product 238 "BIJINNUKA Rice Bran Powder" "#FFEFD5"

echo ""
echo "=== VERIFICATION ==="
echo "Checking which products now have images:"

docker-compose up wp-cli -d >/dev/null 2>&1
sleep 3

for pid in 448 444 442 440 438 434 420 261 259 257 255 242 240 238; do
    thumbnail=$(docker-compose exec wp-cli wp post meta get $pid _thumbnail_id --allow-root 2>/dev/null | tr -d '\r\n' | grep -o '[0-9]*')
    
    if [ -n "$thumbnail" ] && [ "$thumbnail" -gt 0 ]; then
        echo "✓ Product $pid has featured image: $thumbnail"
    else
        echo "✗ Product $pid missing featured image"
    fi
done

echo ""
echo "=== COMPLETE ==="
echo "Simple update finished. Check your WooCommerce admin for results."