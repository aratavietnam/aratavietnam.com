#!/bin/bash

# Script to update policy pages content
# Using WP CLI in Docker container

echo "🚀 Bắt đầu cập nhật nội dung các trang chính sách..."

# Kiểm tra Docker container đang chạy
if ! docker-compose ps | grep -q "wordpress.*Up"; then
    echo "❌ Docker container WordPress không chạy. Vui lòng chạy: docker-compose up -d"
    exit 1
fi

# Check WP CLI
if ! docker-compose exec wordpress wp --info --allow-root > /dev/null 2>&1; then
    echo "❌ WP CLI không có sẵn. Đang cài đặt..."
    docker-compose exec wordpress bash -c "curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp"
fi

echo "✅ WP CLI đã sẵn sàng"

# Function to update page with safe content
update_page() {
    local page_id=$1
    local title=$2
    local content_file=$3

    echo "📝 Đang cập nhật trang: $title (ID: $page_id)"

    # Read content from file
    if [ -f "$content_file" ]; then
        # Escape quotes và newlines cho shell
        content=$(cat "$content_file" | sed 's/"/\\"/g' | tr '\n' ' ')

        # Cập nhật trang
        docker-compose exec wordpress wp post update "$page_id" \
            --post_content="$content" \
            --allow-root

        if [ $? -eq 0 ]; then
            echo "✅ Đã cập nhật thành công: $title"
        else
            echo "❌ Lỗi khi cập nhật: $title"
        fi
    else
        echo "❌ Không tìm thấy file nội dung: $content_file"
    fi
}

# Create content directory if not exists
mkdir -p scripts/content

echo "📋 Danh sách các trang hiện có:"
docker-compose exec wordpress wp post list --post_type=page --fields=ID,post_title --allow-root

echo ""
echo "🔄 Bắt đầu cập nhật nội dung..."

# Update each page
update_page 89 "Chính sách đổi trả" "scripts/content/return-policy.html"
update_page 90 "Chính sách bảo mật" "scripts/content/privacy-policy.html"
update_page 91 "Điều khoản dịch vụ" "scripts/content/terms-of-service.html"

echo ""
echo "🎉 Hoàn thành cập nhật các trang chính sách!"
echo "🌐 Kiểm tra kết quả tại: http://localhost:8000"
