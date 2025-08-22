#!/bin/bash

# Script to create About page for Arata Vietnam
# This script is idempotent: it deletes any existing 'About' page before creating a new one.

# Function to run WP-CLI commands using docker-compose run
run_wp_cli() {
    docker-compose run --rm wp-cli "$@"
}

echo "Preparing to create About page..."

# 1. Delete any existing 'Về Arata Vietnam' pages to prevent duplicates
echo "Checking for and deleting existing 'About' pages..."
PAGE_IDS=$(run_wp_cli wp post list --post_type=page --title='Về Arata Vietnam' --field=ID --format=ids --allow-root)

if [ -n "$PAGE_IDS" ]; then
    echo "Found existing pages with IDs: $PAGE_IDS. Deleting..."
    run_wp_cli wp post delete $PAGE_IDS --force --allow-root
    echo "Old pages deleted."
else
    echo "No existing 'About' pages found."
fi

# 2. Create the new About page
echo "Creating new 'About' page..."
NEW_PAGE_ID=$(run_wp_cli wp post create \
  --post_type=page \
  --post_title='Về Arata Vietnam' \
  --post_content='<p>Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản, chuyên nhập khẩu và phân phối các sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản.</p><p>Với cam kết mang đến những sản phẩm tốt nhất từ đất nước mặt trời mọc, chúng tôi tự hào là cầu nối tin cậy giữa các thương hiệu hóa mỹ phẩm Nhật Bản và người tiêu dùng Việt Nam.</p>' \
  --post_status=publish \
  --page_template='page-templates/about.php' \
  --porcelain \
  --allow-root)

if [ -z "$NEW_PAGE_ID" ] || ! [[ "$NEW_PAGE_ID" =~ ^[0-9]+$ ]]; then
    echo "Error: Failed to create the page. Aborting."
    exit 1
fi

echo "New 'About' page created successfully with ID: $NEW_PAGE_ID"

# 3. Add all meta fields to the new page
echo "Adding content and settings to the new page..."

run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_subtitle 'Đối tác tin cậy trong lĩnh vực hóa mỹ phẩm Nhật Bản tại Việt Nam' --allow-root

run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_company_intro '<p><strong>Arata Việt Nam</strong> là công ty con của Tập đoàn Arata Nhật Bản, được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản cho thị trường Việt Nam.</p><p>Chúng tôi chuyên nhập khẩu trực tiếp các sản phẩm từ các thương hiệu uy tín tại Nhật Bản, đảm bảo tính chính hãng và chất lượng tốt nhất cho khách hàng.</p><p>Với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm, Arata Việt Nam cam kết cung cấp dịch vụ tốt nhất cho cả nhà bán lẻ và người tiêu dùng cuối.</p>' --allow-root

run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_history '<p><strong>2020:</strong> Thành lập công ty Arata Việt Nam tại TP. Hồ Chí Minh</p><p><strong>2021:</strong> Ký kết hợp tác với các thương hiệu hóa mỹ phẩm hàng đầu Nhật Bản</p><p><strong>2022:</strong> Mở rộng mạng lưới phân phối trên toàn quốc</p><p><strong>2023:</strong> Đạt mốc 1000+ điểm bán hàng trên cả nước</p><p><strong>2024:</strong> Ra mắt hệ thống thương mại điện tử và dịch vụ giao hàng tận nơi</p><p><strong>2025:</strong> Tiếp tục mở rộng và phát triển với nhiều sản phẩm mới từ Nhật Bản</p>' --allow-root

run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_mission '<h3>Sứ mệnh</h3><p>Mang đến cho người tiêu dùng Việt Nam những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản với giá cả hợp lý và dịch vụ tận tâm.</p><h3>Tầm nhìn</h3><p>Trở thành nhà phân phối hóa mỹ phẩm Nhật Bản hàng đầu tại Việt Nam, được khách hàng và đối tác tin tưởng lựa chọn.</p>' --allow-root

run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_values '<h3>Giá trị cốt lõi</h3><ul><li><strong>Chất lượng:</strong> Cam kết sản phẩm chính hãng, chất lượng cao</li><li><strong>Uy tín:</strong> Xây dựng niềm tin bền vững với khách hàng</li><li><strong>Dịch vụ:</strong> Hỗ trợ tận tâm, chuyên nghiệp</li><li><strong>Đổi mới:</strong> Không ngừng cải tiến và phát triển</li></ul>' --allow-root

run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_commitment '<h3>Cam kết chất lượng</h3><p>✓ 100% sản phẩm chính hãng từ Nhật Bản<br>✓ Nhập khẩu trực tiếp từ nhà sản xuất<br>✓ Kiểm tra chất lượng nghiêm ngặt<br>✓ Bảo hành và đổi trả theo chính sách</p>' --allow-root

# Add social media links
run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_facebook 'https://facebook.com/aratavietnam' --allow-root
run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_instagram 'https://instagram.com/aratavietnam' --allow-root
run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_tiktok 'https://tiktok.com/@aratavietnam' --allow-root
run_wp_cli wp post meta add $NEW_PAGE_ID arata_about_shopee 'https://shopee.vn/aratavietnam' --allow-root

echo ""
echo "-----------------------------------------------------"
echo "✅ 'About Us' page setup is complete!"
echo "Page ID: $NEW_PAGE_ID"
echo ""
echo "Next Steps:"
echo "1. Go to Pages > Edit 'Về Arata Vietnam' in your WP admin."
echo "2. In 'About Page Settings', go to the 'Product Images' tab."
echo "3. Click 'Select Images' to add floating product images."
echo "-----------------------------------------------------"
