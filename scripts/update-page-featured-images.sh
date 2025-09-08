#!/bin/bash

# Script to update featured images for all pages using Docker
# This script searches for images on the internet and updates page thumbnails

echo "Starting featured image update process..."
echo "============================================"

# Create logs directory
mkdir -p /var/www/html/wp-content/uploads/featured-image-updates
LOG_FILE="/var/www/html/wp-content/uploads/featured-image-updates/update-$(date +%Y%m%d-%H%M%S).log"

# Function to log messages
log_message() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

# Function to search and download image
search_and_download_image() {
    local page_title="$1"
    local page_id="$2"
    local search_term="$3"
    
    log_message "Processing page: $page_title (ID: $page_id)"
    
    # Create search query (Vietnamese beauty/cosmetics related)
    local query="${search_term} arata vietnam mỹ phẩm chăm sóc da"
    
    # Download placeholder image from picsum with search term as seed
    local image_url="https://picsum.photos/seed/${search_term}/1200/800.jpg"
    local temp_file="/tmp/page-${page_id}.jpg"
    
    # Download image using curl
    if curl -s -f -o "$temp_file" "$image_url"; then
        log_message "Downloaded image for: $page_title"
        
        # Import image to WordPress media library
        local import_result=$(docker-compose exec -T wp-cli wp media import "$temp_file" \
            --title="Featured image for $page_title" \
            --post_id="$page_id" \
            --featured_image \
            --allow-root 2>/dev/null)
        
        if echo "$import_result" | grep -q "Success"; then
            log_message "✓ Updated featured image for page: $page_title"
            echo "$import_result" >> "$LOG_FILE"
        else
            log_message "✗ Failed to update featured image for: $page_title"
            echo "Error: $import_result" >> "$LOG_FILE"
        fi
        
        # Clean up temp file
        rm -f "$temp_file"
    else
        log_message "✗ Failed to download image for: $page_title"
    fi
    
    echo "---" >> "$LOG_FILE"
}

# Get all pages
log_message "Getting all pages from WordPress..."
docker-compose exec -T wp-cli wp post list --post_type=page --format=csv --fields=ID,post_title --allow-root > /tmp/pages-list.csv

# Process each page
while IFS=, read -r page_id page_title; do
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
    
    # Small delay to avoid overwhelming the server
    sleep 2
    
done < /tmp/pages-list.csv

# Clean up
rm -f /tmp/pages-list.csv

log_message "Featured image update process completed!"
log_message "Log file saved to: $LOG_FILE"

echo ""
echo "============================================"
echo "Update completed! Check the log file for details:"
echo "$LOG_FILE"