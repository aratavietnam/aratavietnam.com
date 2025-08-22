#!/bin/bash

# Script to create About page for Arata Vietnam
# This script creates the About page with sample content

echo "Creating About page for Arata Vietnam..."

# Create About page
docker-compose exec wp-cli wp post create \
  --post_type=page \
  --post_title="Về Arata Vietnam" \
  --post_content="<p>Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản, chuyên nhập khẩu và phân phối các sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản.</p>

<p>Với cam kết mang đến những sản phẩm tốt nhất từ đất nước mặt trời mọc, chúng tôi tự hào là cầu nối tin cậy giữa các thương hiệu hóa mỹ phẩm Nhật Bản và người tiêu dùng Việt Nam.</p>" \
  --post_status=publish \
  --page_template=page-templates/about.php \
  --allow-root

# Get the page ID
PAGE_ID=$(docker-compose exec wp-cli wp post list --post_type=page --title="Về Arata Vietnam" --field=ID --allow-root)

echo "About page created with ID: $PAGE_ID"

# Add meta fields with sample content
docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_subtitle "Đối tác tin cậy trong lĩnh vực hóa mỹ phẩm Nhật Bản tại Việt Nam" --allow-root

docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_company_intro "<p><strong>Arata Việt Nam</strong> là công ty con của Tập đoàn Arata Nhật Bản, được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản cho thị trường Việt Nam.</p>

<p>Chúng tôi chuyên nhập khẩu trực tiếp các sản phẩm từ các thương hiệu uy tín tại Nhật Bản, đảm bảo tính chính hãng và chất lượng tốt nhất cho khách hàng.</p>

<p>Với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm, Arata Việt Nam cam kết cung cấp dịch vụ tốt nhất cho cả nhà bán lẻ và người tiêu dùng cuối.</p>" --allow-root

docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_history "<p><strong>2020:</strong> Thành lập công ty Arata Việt Nam tại TP. Hồ Chí Minh</p>

<p><strong>2021:</strong> Ký kết hợp tác với các thương hiệu hóa mỹ phẩm hàng đầu Nhật Bản</p>

<p><strong>2022:</strong> Mở rộng mạng lưới phân phối trên toàn quốc</p>

<p><strong>2023:</strong> Đạt mốc 1000+ điểm bán hàng trên cả nước</p>

<p><strong>2024:</strong> Ra mắt hệ thống thương mại điện tử và dịch vụ giao hàng tận nơi</p>

<p><strong>2025:</strong> Tiếp tục mở rộng và phát triển với nhiều sản phẩm mới từ Nhật Bản</p>" --allow-root

docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_mission "<h3>Sứ mệnh</h3>
<p>Mang đến cho người tiêu dùng Việt Nam những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản với giá cả hợp lý và dịch vụ tận tâm.</p>

<h3>Tầm nhìn</h3>
<p>Trở thành nhà phân phối hóa mỹ phẩm Nhật Bản hàng đầu tại Việt Nam, được khách hàng và đối tác tin tưởng lựa chọn.</p>

<h3>Giá trị cốt lõi</h3>
<ul>
<li><strong>Chất lượng:</strong> Cam kết sản phẩm chính hãng, chất lượng cao</li>
<li><strong>Uy tín:</strong> Xây dựng niềm tin bền vững với khách hàng</li>
<li><strong>Dịch vụ:</strong> Hỗ trợ tận tâm, chuyên nghiệp</li>
<li><strong>Đổi mới:</strong> Không ngừng cải tiến và phát triển</li>
</ul>" --allow-root

docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_values "<h3>Chất lượng</h3>
<p>Chúng tôi cam kết chỉ nhập khẩu và phân phối những sản phẩm chính hãng từ các thương hiệu uy tín tại Nhật Bản. Mọi sản phẩm đều được kiểm tra chất lượng nghiêm ngặt trước khi đến tay khách hàng.</p>

<h3>Uy tín</h3>
<p>Xây dựng niềm tin với khách hàng thông qua sự minh bạch trong kinh doanh, cam kết về chất lượng sản phẩm và dịch vụ hậu mãi tốt nhất.</p>

<h3>Dịch vụ khách hàng</h3>
<p>Đội ngũ tư vấn chuyên nghiệp, nhiệt tình hỗ trợ khách hàng 24/7. Chúng tôi luôn lắng nghe và đáp ứng nhu cầu của từng khách hàng một cách tốt nhất.</p>

<h3>Đổi mới</h3>
<p>Không ngừng cập nhật xu hướng mới, sản phẩm mới từ thị trường Nhật Bản để mang đến cho khách hàng Việt Nam những lựa chọn tốt nhất.</p>" --allow-root

docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_commitment "<h3>Cam kết chất lượng</h3>
<p>✓ 100% sản phẩm chính hãng từ Nhật Bản<br>
✓ Nhập khẩu trực tiếp từ nhà sản xuất<br>
✓ Kiểm tra chất lượng nghiêm ngặt<br>
✓ Bảo hành và đổi trả theo chính sách</p>

<h3>Cam kết dịch vụ</h3>
<p>✓ Tư vấn chuyên nghiệp từ đội ngũ có kinh nghiệm<br>
✓ Giao hàng nhanh chóng trên toàn quốc<br>
✓ Hỗ trợ khách hàng 24/7<br>
✓ Chính sách đổi trả linh hoạt</p>

<h3>Chứng nhận và giấy phép</h3>
<p>✓ Giấy phép kinh doanh hợp pháp<br>
✓ Chứng nhận nhập khẩu từ Bộ Y tế<br>
✓ Đăng ký thương hiệu tại Việt Nam<br>
✓ Tuân thủ các quy định về hóa mỹ phẩm</p>" --allow-root

# Add social media links
docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_facebook "https://facebook.com/aratavietnam" --allow-root
docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_instagram "https://instagram.com/aratavietnam" --allow-root
docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_tiktok "https://tiktok.com/@aratavietnam" --allow-root
docker-compose exec wp-cli wp post meta add $PAGE_ID arata_about_shopee "https://shopee.vn/aratavietnam" --allow-root

echo "About page created successfully!"
echo "Page ID: $PAGE_ID"
echo "You can now add product images through WordPress admin:"
echo "1. Go to Pages > Edit 'Về Arata Vietnam'"
echo "2. Scroll down to 'About Page Settings'"
echo "3. Click on 'Product Images' tab"
echo "4. Use 'Select Images' buttons to add floating product images"
echo ""
echo "Recommended: Add 3-4 images for left side and 3-4 images for right side"
echo "Images should be product photos with transparent backgrounds in orange, yellow, and blue tones"
