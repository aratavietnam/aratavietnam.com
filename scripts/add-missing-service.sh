#!/bin/bash

echo "Adding missing marketing service..."

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

echo "Marketing service added successfully!"
