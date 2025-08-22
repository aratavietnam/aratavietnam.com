#!/bin/bash

echo "Setting up WooCommerce for Arata Vietnam..."

# Activate WooCommerce if not already active
echo "Activating WooCommerce..."
docker-compose exec wp-cli wp plugin activate woocommerce --allow-root

# Install WooCommerce pages
echo "Installing WooCommerce pages..."
docker-compose exec wp-cli wp wc tool run install_pages --allow-root

# Create shop page with correct slug
echo "Creating shop page..."
SHOP_PAGE_ID=$(docker-compose exec wp-cli wp post create \
  --post_type=page \
  --post_title="Sản phẩm" \
  --post_name="san-pham" \
  --post_status=publish \
  --porcelain \
  --allow-root)

# Set shop page
echo "Setting shop page ID: $SHOP_PAGE_ID"
docker-compose exec wp-cli wp option update woocommerce_shop_page_id $SHOP_PAGE_ID --allow-root

# Configure WooCommerce settings
echo "Configuring WooCommerce settings..."
docker-compose exec wp-cli wp option update woocommerce_currency VND --allow-root
docker-compose exec wp-cli wp option update woocommerce_default_country VN --allow-root
docker-compose exec wp-cli wp option update woocommerce_manage_stock yes --allow-root
docker-compose exec wp-cli wp option update woocommerce_enable_reviews yes --allow-root

# Create sample products
echo "Creating sample products..."
docker-compose exec wp-cli wp wc product create \
  --name="Kem dưỡng da Arata" \
  --type=simple \
  --regular_price=150000 \
  --description="Kem dưỡng da cao cấp từ Nhật Bản" \
  --short_description="Kem dưỡng da chất lượng cao" \
  --status=publish \
  --catalog_visibility=visible \
  --featured=true \
  --allow-root

docker-compose exec wp-cli wp wc product create \
  --name="Sữa rửa mặt Arata" \
  --type=simple \
  --regular_price=120000 \
  --description="Sữa rửa mặt dịu nhẹ cho mọi loại da" \
  --short_description="Làm sạch sâu, dịu nhẹ" \
  --status=publish \
  --catalog_visibility=visible \
  --featured=true \
  --allow-root

docker-compose exec wp-cli wp wc product create \
  --name="Serum vitamin C Arata" \
  --type=simple \
  --regular_price=200000 \
  --description="Serum vitamin C giúp làm sáng da" \
  --short_description="Làm sáng da, chống lão hóa" \
  --status=publish \
  --catalog_visibility=visible \
  --featured=true \
  --allow-root

docker-compose exec wp-cli wp wc product create \
  --name="Toner cân bằng da Arata" \
  --type=simple \
  --regular_price=100000 \
  --description="Toner giúp cân bằng độ pH cho da" \
  --short_description="Cân bằng độ ẩm cho da" \
  --status=publish \
  --catalog_visibility=visible \
  --allow-root

# Create product categories
echo "Creating product categories..."
docker-compose exec wp-cli wp wc product_cat create \
  --name="Chăm sóc da mặt" \
  --slug="cham-soc-da-mat" \
  --description="Các sản phẩm chăm sóc da mặt" \
  --allow-root

docker-compose exec wp-cli wp wc product_cat create \
  --name="Làm sạch" \
  --slug="lam-sach" \
  --description="Sản phẩm làm sạch da" \
  --allow-root

docker-compose exec wp-cli wp wc product_cat create \
  --name="Dưỡng ẩm" \
  --slug="duong-am" \
  --description="Sản phẩm dưỡng ẩm" \
  --allow-root

# Flush rewrite rules
echo "Flushing rewrite rules..."
docker-compose exec wp-cli wp rewrite flush --allow-root

# Check results
echo "Checking WooCommerce setup..."
echo "Shop page ID: $(docker-compose exec wp-cli wp option get woocommerce_shop_page_id --allow-root)"
echo "Number of products: $(docker-compose exec wp-cli wp wc product list --format=count --allow-root)"
echo "Product categories: $(docker-compose exec wp-cli wp wc product_cat list --format=count --allow-root)"

echo ""
echo "WooCommerce setup completed!"
echo "Visit: http://localhost:8000/san-pham/"
echo ""
