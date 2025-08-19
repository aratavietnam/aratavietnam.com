#!/bin/bash

echo "Tạo các trang cần thiết cho Arata Vietnam..."

# Create "About Arata" page
echo "Tạo trang Về Arata..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Về Arata" --post_name="ve-arata" --post_status=publish --allow-root

# Create "Services" page
echo "Tạo trang Dịch vụ..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Dịch vụ" --post_name="dich-vu" --post_status=publish --allow-root

# Create "News" page
echo "Tạo trang Tin tức..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Tin tức" --post_name="tin-tuc" --post_status=publish --allow-root

# Create "Promotions" page
echo "Tạo trang Chương trình khuyến mãi..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Chương trình khuyến mãi" --post_name="chuong-trinh-khuyen-mai" --post_status=publish --allow-root

# Create "Careers" page
echo "Tạo trang Tuyển dụng..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Tuyển dụng" --post_name="tuyen-dung" --post_status=publish --allow-root

# Create "Blog" page
echo "Tạo trang Blog..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Blog" --post_name="blog" --post_status=publish --allow-root

# Create "Contact" page
echo "Tạo trang Liên hệ..."
docker-compose run --rm wp-cli wp post create --post_type=page --post_title="Liên hệ" --post_name="lien-he" --post_status=publish --allow-root

echo "Hoàn thành tạo các trang cơ bản!"
