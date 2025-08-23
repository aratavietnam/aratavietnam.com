#!/bin/sh
# Script to set tags for posts that are missing them.

set -e

echo "Waiting for the database to be ready..."
sleep 10

echo "Setting tags for missing posts..."

# Post 196: Mặt Nạ Giấy
wp post term set 196 post_tag 'Chăm sóc da' 'Mặt nạ' 'Dưỡng ẩm' 'Mỹ phẩm Nhật Bản' --allow-root

# Post 195: Combo Chăm Sóc Da
wp post term set 195 post_tag 'Chăm sóc da' 'Mỹ phẩm Nhật Bản' --allow-root

# Post 194: Glycerin
wp post term set 194 post_tag 'Chăm sóc da' 'Dưỡng ẩm' 'Thành phần mỹ phẩm' 'Glycerin' --allow-root

echo "Successfully set tags for missing posts."

