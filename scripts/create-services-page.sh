#!/bin/bash

echo "Creating services page..."

# Create services page
wp post create \
    --post_type=page \
    --post_title="Dịch vụ" \
    --post_content="Chào mừng bạn đến với trang dịch vụ của Arata Vietnam. Chúng tôi cung cấp các dịch vụ chất lượng cao với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm." \
    --post_status=publish \
    --allow-root

# Get the page ID
PAGE_ID=$(wp post list --post_type=page --post_title="Dịch vụ" --format=ids --allow-root)

# Set the page template
wp post meta add $PAGE_ID _wp_page_template "page-templates/services.php" --allow-root

# Set page meta fields
wp post meta add $PAGE_ID arata_services_subtitle "Giải pháp toàn diện cho doanh nghiệp" --allow-root
wp post meta add $PAGE_ID arata_services_intro "Chúng tôi cung cấp các dịch vụ chất lượng cao với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm Nhật Bản." --allow-root
wp post meta add $PAGE_ID arata_services_featured_text "Cam kết chất lượng - Uy tín hàng đầu" --allow-root
wp post meta add $PAGE_ID arata_services_cta_text "Liên hệ tư vấn" --allow-root
wp post meta add $PAGE_ID arata_services_cta_link "/lien-he" --allow-root

echo "Services page created successfully with ID: $PAGE_ID"
echo "Page URL: http://localhost:8000/dich-vu/"
