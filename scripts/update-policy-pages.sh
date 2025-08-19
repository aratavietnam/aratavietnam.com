#!/bin/bash

# Script to update policy pages content
# Using WP CLI in Docker container

echo "Starting policy pages content update..."

# Kiểm tra Docker container đang chạy
if ! docker-compose ps | grep -q "wordpress.*Up"; then
    echo "ERROR: WordPress Docker container is not running. Please run: docker-compose up -d"
    exit 1
fi

# Check WP CLI
if ! docker-compose exec wordpress wp --info --allow-root > /dev/null 2>&1; then
    echo "WP CLI not available. Installing..."
    docker-compose exec wordpress bash -c "curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp"
fi

echo "WP CLI is ready"

# Function to update page with safe content
update_page() {
    local page_id=$1
    local title=$2
    local content_file=$3

    echo "Updating page: $title (ID: $page_id)"

    # Read content from file
    if [ -f "$content_file" ]; then
        # Escape quotes và newlines cho shell
        content=$(cat "$content_file" | sed 's/"/\\"/g' | tr '\n' ' ')

        # Cập nhật trang
        docker-compose exec wordpress wp post update "$page_id" \
            --post_content="$content" \
            --allow-root

        if [ $? -eq 0 ]; then
            echo "Successfully updated: $title"
        else
            echo "Error updating: $title"
        fi
    else
        echo "Content file not found: $content_file"
    fi
}

# Create content directory if not exists
mkdir -p scripts/content

echo "Current pages list:"
docker-compose exec wordpress wp post list --post_type=page --fields=ID,post_title --allow-root

echo ""
echo "Starting content update..."

# Update each page
update_page 89 "Chính sách đổi trả" "scripts/content/return-policy.html"
update_page 90 "Chính sách bảo mật" "scripts/content/privacy-policy.html"
update_page 91 "Điều khoản dịch vụ" "scripts/content/terms-of-service.html"

echo ""
echo "Policy pages update completed!"
echo "Check results at: http://localhost:8000"
