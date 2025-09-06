#!/bin/bash

echo "Thiết lập trang Khuyến mãi với meta fields..."

# Kiểm tra xem trang khuyến mãi đã tồn tại chưa
EXISTING_PAGE=$(docker-compose exec wordpress wp post list --post_type=page --name="khuyen-mai" --field=ID --allow-root 2>/dev/null | head -1)

if [ ! -z "$EXISTING_PAGE" ] && [ "$EXISTING_PAGE" != "" ]; then
    echo "Trang khuyến mãi đã tồn tại với ID: $EXISTING_PAGE"
    PAGE_ID=$EXISTING_PAGE
else
    echo "Tạo trang khuyến mãi mới..."
    PAGE_ID=$(docker-compose exec wordpress wp post create \
        --post_type=page \
        --post_title="Khuyến mãi" \
        --post_name="khuyen-mai" \
        --post_content="<p>Trang khuyến mãi của Arata Vietnam - nơi tập hợp tất cả các chương trình ưu đãi hấp dẫn.</p>" \
        --post_status=publish \
        --porcelain \
        --allow-root)
    echo "Đã tạo trang khuyến mãi với ID: $PAGE_ID"
fi

# Thiết lập meta fields cho hero section
echo "Thiết lập meta fields cho hero section..."

# Bật hero section
docker-compose exec wordpress wp post meta update $PAGE_ID arata_show_hero "1" --allow-root

# Sử dụng compact hero
docker-compose exec wordpress wp post meta update $PAGE_ID arata_compact_hero "1" --allow-root

# Thiết lập tiêu đề hero
docker-compose exec wordpress wp post meta update $PAGE_ID arata_promotions_subtitle "Ưu đãi đặc biệt từ Arata Vietnam" --allow-root

# Thiết lập mô tả hero
docker-compose exec wordpress wp post meta update $PAGE_ID arata_promotions_intro "Khám phá các chương trình khuyến mãi hấp dẫn và ưu đãi độc quyền từ Arata Vietnam. Tiết kiệm chi phí với những deal hot nhất!" --allow-root

echo ""
echo "✅ Hoàn thành thiết lập trang khuyến mãi!"
echo ""
echo "Thông tin trang:"
echo "- ID: $PAGE_ID"
echo "- URL: http://localhost:8080/khuyen-mai/"
echo "- Hero: Bật (Compact mode)"
echo "- Tiêu đề: Ưu đãi đặc biệt từ Arata Vietnam"
echo ""
echo "Bạn có thể chỉnh sửa hero section trong WordPress Admin:"
echo "1. Vào Pages → All Pages"
echo "2. Chỉnh sửa trang 'Khuyến mãi'"
echo "3. Cuộn xuống phần 'Cài đặt trang Khuyến mãi'"
echo "4. Tùy chỉnh hero section theo ý muốn"
echo ""
echo "Truy cập: http://localhost:8080/khuyen-mai/ để xem kết quả"
