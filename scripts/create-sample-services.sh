#!/bin/bash

echo "Creating sample services for Arata Vietnam..."

# Create service categories first
echo "Creating service categories..."

# Tư vấn kinh doanh
wp term create service_category "Tư vấn kinh doanh" --description="Dịch vụ tư vấn chiến lược kinh doanh và phát triển thị trường" --allow-root

# Xuất nhập khẩu
wp term create service_category "Xuất nhập khẩu" --description="Dịch vụ hỗ trợ xuất nhập khẩu hàng hóa Nhật Bản" --allow-root

# Marketing số
wp term create service_category "Marketing số" --description="Dịch vụ marketing trực tuyến và quảng cáo số" --allow-root

# Đào tạo
wp term create service_category "Đào tạo" --description="Chương trình đào tạo chuyên nghiệp cho doanh nghiệp" --allow-root

# Hỗ trợ kỹ thuật
wp term create service_category "Hỗ trợ kỹ thuật" --description="Dịch vụ hỗ trợ kỹ thuật và bảo trì hệ thống" --allow-root

echo "Service categories created successfully!"

# Create sample services
echo "Creating sample services..."

# Service 1: Tư vấn chiến lược kinh doanh
wp post create \
    --post_type=service \
    --post_title="Tư vấn chiến lược kinh doanh" \
    --post_content="Chúng tôi cung cấp dịch vụ tư vấn chiến lược kinh doanh toàn diện, giúp doanh nghiệp xác định hướng đi đúng đắn và phát triển bền vững trong thị trường cạnh tranh." \
    --post_excerpt="Dịch vụ tư vấn chiến lược kinh doanh toàn diện, giúp doanh nghiệp phát triển bền vững và tăng trưởng hiệu quả." \
    --post_status=publish \
    --allow-root

# Set meta for service 1
SERVICE1_ID=$(wp post list --post_type=service --post_title="Tư vấn chiến lược kinh doanh" --format=ids --allow-root)
wp post meta add $SERVICE1_ID arata_service_status "active" --allow-root
wp post meta add $SERVICE1_ID arata_service_type "consultation" --allow-root
wp post meta add $SERVICE1_ID arata_service_price "Liên hệ" --allow-root
wp post meta add $SERVICE1_ID arata_service_price_type "contact" --allow-root
wp post meta add $SERVICE1_ID arata_service_duration "2-4 tuần" --allow-root
wp post meta add $SERVICE1_ID arata_service_icon "trending-up" --allow-root
wp post meta add $SERVICE1_ID arata_service_color "primary" --allow-root

# Assign to category
wp post term set $SERVICE1_ID service_category "Tư vấn kinh doanh" --allow-root

# Service 2: Xuất nhập khẩu hàng hóa Nhật Bản
wp post create \
    --post_type=service \
    --post_title="Xuất nhập khẩu hàng hóa Nhật Bản" \
    --post_content="Chuyên cung cấp dịch vụ xuất nhập khẩu hàng hóa Nhật Bản chất lượng cao, đảm bảo quy trình thủ tục nhanh chóng và an toàn." \
    --post_excerpt="Dịch vụ xuất nhập khẩu hàng hóa Nhật Bản chuyên nghiệp, đảm bảo quy trình thủ tục nhanh chóng và an toàn." \
    --post_status=publish \
    --allow-root

# Set meta for service 2
SERVICE2_ID=$(wp post list --post_type=service --post_title="Xuất nhập khẩu hàng hóa Nhật Bản" --format=ids --allow-root)
wp post meta add $SERVICE2_ID arata_service_status "active" --allow-root
wp post meta add $SERVICE2_ID arata_service_type "implementation" --allow-root
wp post meta add $SERVICE2_ID arata_service_price "Từ 5 triệu VNĐ" --allow-root
wp post meta add $SERVICE2_ID arata_service_price_type "contact" --allow-root
wp post meta add $SERVICE2_ID arata_service_duration "1-2 tuần" --allow-root
wp post meta add $SERVICE2_ID arata_service_icon "shipping" --allow-root
wp post meta add $SERVICE2_ID arata_service_color "secondary" --allow-root

# Assign to category
wp post term set $SERVICE2_ID service_category "Xuất nhập khẩu" --allow-root

# Service 3: Marketing số và quảng cáo trực tuyến
wp post create \
    --post_type=service \
    --post_title="Marketing số và quảng cáo trực tuyến" \
    --post_content="Dịch vụ marketing số toàn diện giúp doanh nghiệp tăng cường hiện diện trực tuyến và thu hút khách hàng tiềm năng." \
    --post_excerpt="Dịch vụ marketing số toàn diện giúp doanh nghiệp tăng cường hiện diện trực tuyến và thu hút khách hàng tiềm năng." \
    --post_status=publish \
    --allow-root

# Set meta for service 3
SERVICE3_ID=$(wp post list --post_type=service --post_title="Marketing số và quảng cáo trực tuyến" --format=ids --allow-root)
wp post meta add $SERVICE3_ID arata_service_status "active" --allow-root
wp post meta add $SERVICE3_ID arata_service_type "implementation" --allow-root
wp post meta add $SERVICE3_ID arata_service_price "Từ 10 triệu VNĐ/tháng" --allow-root
wp post meta add $SERVICE3_ID arata_service_price_type "contact" --allow-root
wp post meta add $SERVICE3_ID arata_service_duration "3-6 tháng" --allow-root
wp post meta add $SERVICE3_ID arata_service_icon "megaphone" --allow-root
wp post meta add $SERVICE3_ID arata_service_color "tertiary" --allow-root

# Assign to category
wp post term set $SERVICE3_ID service_category "Marketing số" --allow-root

echo "Sample services created successfully!"
echo "Total services created: 3"

# List all services
echo ""
echo "List of created services:"
wp post list --post_type=service --format=table --allow-root

echo ""
echo "List of service categories:"
wp term list service_category --format=table --allow-root
