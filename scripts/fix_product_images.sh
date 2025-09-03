#!/bin/bash

# Fixed script to update all remaining products with images
# Usage: ./fix_product_images.sh

echo "=== FIXING PRODUCT IMAGES ==="

# Ensure WP CLI is running
echo "Starting WordPress CLI..."
docker-compose up wp-cli -d
sleep 10

# Function to process products in smaller batches
process_batch() {
    local products=("$@")
    
    for product_data in "${products[@]}"; do
        IFS=':' read -r product_id product_name color1 color2 color3 <<< "$product_data"
        
        echo "Processing Product ID $product_id: $product_name"
        
        # Create images
        magick -size 800x600 xc:"$color1" -pointsize 20 -fill black -gravity center \
               -annotate +0+0 "$product_name" "/tmp/p${product_id}_main.jpg"
        
        magick -size 600x600 xc:"$color2" -pointsize 16 -fill black -gravity center \
               -annotate +0+0 "${product_name} Gallery 1" "/tmp/p${product_id}_g1.jpg"
        
        magick -size 600x600 xc:"$color3" -pointsize 16 -fill black -gravity center \
               -annotate +0+0 "${product_name} Gallery 2" "/tmp/p${product_id}_g2.jpg"
        
        # Copy to mounted volume
        cp "/tmp/p${product_id}_main.jpg" "/tmp/p${product_id}_g1.jpg" "/tmp/p${product_id}_g2.jpg" /tmp/aratavietnam_images/
        
        # Restart WP CLI and import
        docker-compose up wp-cli -d
        sleep 3
        
        # Import main image
        main_id=$(docker-compose exec wp-cli wp media import "/tmp/aratavietnam_images/p${product_id}_main.jpg" --porcelain --allow-root 2>/dev/null | grep -o '[0-9]*' | head -n1)
        
        if [ -n "$main_id" ] && [ "$main_id" -gt 0 ]; then
            echo "  Main image imported: $main_id"
            
            # Import gallery images  
            g1_id=$(docker-compose exec wp-cli wp media import "/tmp/aratavietnam_images/p${product_id}_g1.jpg" --porcelain --allow-root 2>/dev/null | grep -o '[0-9]*' | head -n1)
            g2_id=$(docker-compose exec wp-cli wp media import "/tmp/aratavietnam_images/p${product_id}_g2.jpg" --porcelain --allow-root 2>/dev/null | grep -o '[0-9]*' | head -n1)
            
            if [ -n "$g1_id" ] && [ -n "$g2_id" ]; then
                echo "  Gallery images imported: $g1_id, $g2_id"
                
                # Set featured image
                docker-compose exec wp-cli wp post meta update $product_id _thumbnail_id $main_id --allow-root >/dev/null 2>&1
                
                # Set gallery images
                docker-compose exec wp-cli wp post meta update $product_id _product_image_gallery "${g1_id},${g2_id}" --allow-root >/dev/null 2>&1
                
                echo "  ✓ SUCCESS: Product $product_id updated"
            else
                echo "  ✗ FAILED: Gallery import failed for product $product_id"
            fi
        else
            echo "  ✗ FAILED: Main image import failed for product $product_id"
        fi
        
        # Cleanup
        rm -f "/tmp/p${product_id}_main.jpg" "/tmp/p${product_id}_g1.jpg" "/tmp/p${product_id}_g2.jpg"
        
        sleep 2
    done
}

# Product data array
products_batch1=(
    "453:Mitsuei Kitchen Cleaner:#90EE90:#98FB98:#7CFC00"
    "450:Zero Spot Face Mask:#FFB6C1:#FFC0CB:#FF69B4"
    "448:ELMIE Underwear Wash:#E6E6FA:#DDA0DD:#DA70D6"
    "446:Hyaluronic Gold Mask:#FFD700:#FFF8DC:#F0E68C"
    "444:HERBAL POWDER Bleach:#32CD32:#90EE90:#ADFF2F"
    "442:Washing Machine Cleaner:#87CEEB:#B0E0E6:#ADD8E6"
)

products_batch2=(
    "440:Mitsuei Toilet Cleaner:#FF6347:#FFA07A:#FA8072"
    "438:SHABONDAMA Kids Toothpaste:#FFB6C1:#FFC0CB:#FF69B4"
    "434:HERBAL FRESH Dish Soap:#90EE90:#98FB98:#00FF00"
    "420:Mitsuei Kitchen Foam:#FFFF00:#FFFFE0:#F0E68C"
    "261:TO-PLAN Baby Cream:#E0E0E0:#F5F5F5:#DCDCDC"
)

products_batch3=(
    "259:Purevivi Cleansing Wax:#FFEFD5:#FFE4B5:#DEB887"
    "257:PAENNA Jobs Tears Milk:#F5DEB3:#D2B48C:#BC9A6A"
    "255:PAENNA Jobs Tears Mask:#F0E68C:#DAA520:#B8860B"
    "242:Purevivi Cleansing Water:#87CEFA:#B0E0E6:#ADD8E6"
    "240:JELLAN Mens Lotion:#4169E1:#6495ED:#87CEEB"
    "238:BIJINNUKA Rice Bran Powder:#FFEFD5:#F5DEB3:#DEB887"
)

echo "Processing Batch 1/3..."
process_batch "${products_batch1[@]}"

echo "Processing Batch 2/3..."
process_batch "${products_batch2[@]}"

echo "Processing Batch 3/3..."
process_batch "${products_batch3[@]}"

echo "=== VERIFICATION ==="
# Quick verification
docker-compose up wp-cli -d
sleep 3

all_products=(453 450 448 446 444 442 440 438 434 420 261 259 257 255 242 240 238)

for pid in "${all_products[@]}"; do
    thumbnail=$(docker-compose exec wp-cli wp post meta get $pid _thumbnail_id --allow-root 2>/dev/null | tr -d '\r\n')
    gallery=$(docker-compose exec wp-cli wp post meta get $pid _product_image_gallery --allow-root 2>/dev/null | tr -d '\r\n')
    
    if [[ -n "$thumbnail" && -n "$gallery" ]]; then
        echo "✓ Product $pid: Featured($thumbnail) Gallery($gallery)"
    else
        echo "✗ Product $pid: Missing images"
    fi
done

echo "=== COMPLETE ==="