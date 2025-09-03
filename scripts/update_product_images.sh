#!/bin/bash

# Script to update all remaining products with images
# Usage: ./update_product_images.sh

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}=== ARATA VIETNAM PRODUCT IMAGE UPDATE SCRIPT ===${NC}"
echo -e "${BLUE}Starting batch update for all remaining products...${NC}\n"

# Docker compose command prefix
WP_CLI="docker-compose exec wp-cli wp"

# Check if docker services are running
echo -e "${YELLOW}Starting WordPress CLI service...${NC}"
docker-compose up wp-cli -d
sleep 5

# Array of products to update (ID:Name:Color1:Color2:Color3)
declare -a products=(
    "453:Mitsuei Kitchen Cleaner:#90EE90:#98FB98:#7CFC00"
    "450:Zero Spot Face Mask:#FFB6C1:#FFC0CB:#FF69B4"
    "448:ELMIE Underwear Wash:#E6E6FA:#DDA0DD:#DA70D6"
    "446:Hyaluronic Gold Mask:#FFD700:#FFF8DC:#F0E68C"
    "444:HERBAL POWDER Bleach:#32CD32:#90EE90:#ADFF2F"
    "442:Washing Machine Cleaner:#87CEEB:#B0E0E6:#ADD8E6"
    "440:Mitsuei Toilet Cleaner:#FF6347:#FFA07A:#FA8072"
    "438:SHABONDAMA Kids Toothpaste:#FFB6C1:#FFC0CB:#FF69B4"
    "434:HERBAL FRESH Dish Soap:#90EE90:#98FB98:#00FF00"
    "420:Mitsuei Kitchen Foam:#FFFF00:#FFFFE0:#F0E68C"
    "261:TO-PLAN Baby Cream:#E0E0E0:#F5F5F5:#DCDCDC"
    "259:Purevivi Cleansing Wax:#FFEFD5:#FFE4B5:#DEB887"
    "257:PAENNA Job's Tears Milk:#F5DEB3:#D2B48C:#BC9A6A"
    "255:PAENNA Job's Tears Mask:#F0E68C:#DAA520:#B8860B"
    "242:Purevivi Cleansing Water:#87CEFA:#B0E0E6:#ADD8E6"
    "240:JELLAN Men's Lotion:#4169E1:#6495ED:#87CEEB"
    "238:BIJINNUKA Rice Bran Powder:#FFEFD5:#F5DEB3:#DEB887"
)

# Function to create images for a product
create_product_images() {
    local product_id="$1"
    local product_name="$2"
    local color1="$3"
    local color2="$4"
    local color3="$5"
    
    echo -e "${YELLOW}Creating images for Product ID $product_id: $product_name${NC}"
    
    # Create main image
    magick -size 800x600 xc:"$color1" -pointsize 24 -fill black -gravity center \
           -annotate +0+0 "$product_name" "/tmp/product_${product_id}_main.jpg"
    
    # Create gallery image 1
    magick -size 600x600 xc:"$color2" -pointsize 20 -fill black -gravity center \
           -annotate +0+0 "${product_name}\nGallery 1" "/tmp/product_${product_id}_gallery1.jpg"
    
    # Create gallery image 2
    magick -size 600x600 xc:"$color3" -pointsize 20 -fill black -gravity center \
           -annotate +0+0 "${product_name}\nGallery 2" "/tmp/product_${product_id}_gallery2.jpg"
    
    # Copy to mounted volume
    cp "/tmp/product_${product_id}_main.jpg" "/tmp/product_${product_id}_gallery1.jpg" "/tmp/product_${product_id}_gallery2.jpg" /tmp/aratavietnam_images/
    
    echo -e "${GREEN}✓ Images created for Product ID $product_id${NC}"
}

# Function to import and set images for a product
import_and_set_images() {
    local product_id="$1"
    local product_name="$2"
    
    echo -e "${YELLOW}Importing images for Product ID $product_id: $product_name${NC}"
    
    # Import images to WordPress
    main_attachment_id=$($WP_CLI media import "/tmp/aratavietnam_images/product_${product_id}_main.jpg" --title="$product_name Main" --porcelain --allow-root 2>/dev/null)
    gallery1_attachment_id=$($WP_CLI media import "/tmp/aratavietnam_images/product_${product_id}_gallery1.jpg" --title="$product_name Gallery 1" --porcelain --allow-root 2>/dev/null)
    gallery2_attachment_id=$($WP_CLI media import "/tmp/aratavietnam_images/product_${product_id}_gallery2.jpg" --title="$product_name Gallery 2" --porcelain --allow-root 2>/dev/null)
    
    if [[ -n "$main_attachment_id" && -n "$gallery1_attachment_id" && -n "$gallery2_attachment_id" ]]; then
        # Set featured image
        $WP_CLI post meta update $product_id _thumbnail_id $main_attachment_id --allow-root >/dev/null 2>&1
        
        # Set gallery images
        $WP_CLI post meta update $product_id _product_image_gallery "${gallery1_attachment_id},${gallery2_attachment_id}" --allow-root >/dev/null 2>&1
        
        echo -e "${GREEN}✓ Images imported and set for Product ID $product_id${NC}"
        echo -e "  - Featured Image: $main_attachment_id"
        echo -e "  - Gallery Images: $gallery1_attachment_id, $gallery2_attachment_id"
    else
        echo -e "${RED}✗ Failed to import images for Product ID $product_id${NC}"
        return 1
    fi
}

# Function to process a single product
process_product() {
    local product_data="$1"
    IFS=':' read -r product_id product_name color1 color2 color3 <<< "$product_data"
    
    echo -e "\n${BLUE}--- Processing Product ID $product_id ---${NC}"
    
    # Create images
    create_product_images "$product_id" "$product_name" "$color1" "$color2" "$color3"
    
    # Import and set images
    import_and_set_images "$product_id" "$product_name"
    
    # Clean up temporary files
    rm -f "/tmp/product_${product_id}_main.jpg" "/tmp/product_${product_id}_gallery1.jpg" "/tmp/product_${product_id}_gallery2.jpg"
}

# Main execution
echo -e "${BLUE}Starting batch processing of ${#products[@]} products...${NC}\n"

success_count=0
fail_count=0

for product in "${products[@]}"; do
    if process_product "$product"; then
        ((success_count++))
    else
        ((fail_count++))
    fi
    
    # Small delay to prevent overwhelming the system
    sleep 2
done

# Final summary
echo -e "\n${BLUE}=== BATCH UPDATE COMPLETE ===${NC}"
echo -e "${GREEN}✓ Successfully processed: $success_count products${NC}"
if [ $fail_count -gt 0 ]; then
    echo -e "${RED}✗ Failed to process: $fail_count products${NC}"
fi

echo -e "\n${BLUE}=== VERIFICATION ===${NC}"
echo -e "${YELLOW}Checking updated products...${NC}"

# Verify products have featured images
for product in "${products[@]}"; do
    IFS=':' read -r product_id product_name _ _ _ <<< "$product"
    
    thumbnail_id=$($WP_CLI post meta get $product_id _thumbnail_id --allow-root 2>/dev/null)
    gallery_ids=$($WP_CLI post meta get $product_id _product_image_gallery --allow-root 2>/dev/null)
    
    if [[ -n "$thumbnail_id" && -n "$gallery_ids" ]]; then
        echo -e "${GREEN}✓ Product ID $product_id: Featured($thumbnail_id) Gallery($gallery_ids)${NC}"
    else
        echo -e "${RED}✗ Product ID $product_id: Missing images${NC}"
    fi
done

echo -e "\n${BLUE}Script completed! All products have been updated with images.${NC}"
echo -e "${YELLOW}You can now check your WooCommerce products in the admin panel.${NC}"