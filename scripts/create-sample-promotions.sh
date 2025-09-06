#!/bin/bash

echo "Tạo các khuyến mãi mẫu cho Arata Vietnam..."

# Tạo khuyến mãi 1: Giảm giá 20%
echo "Tạo khuyến mãi: Giảm 20% toàn bộ sản phẩm..."
docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Giảm 20% toàn bộ sản phẩm chăm sóc da" \
    --post_content="<p>Chương trình khuyến mãi đặc biệt dành cho tất cả sản phẩm chăm sóc da từ Nhật Bản. Áp dụng cho tất cả các sản phẩm kem dưỡng, serum, toner và sữa rửa mặt.</p>

<h3>Điều kiện áp dụng:</h3>
<ul>
<li>Áp dụng cho đơn hàng từ 500.000đ trở lên</li>
<li>Không áp dụng cùng với các chương trình khuyến mãi khác</li>
<li>Có hiệu lực từ ngày 01/01/2025 đến 31/01/2025</li>
</ul>

<h3>Cách sử dụng:</h3>
<p>Nhập mã <strong>SKINCARE20</strong> khi thanh toán để được giảm ngay 20% giá trị đơn hàng.</p>" \
    --post_status=publish \
    --post_name="giam-20-phan-tram-san-pham-cham-soc-da" \
    --meta_input='{"arata_promotion_discount":"20","arata_promotion_code":"SKINCARE20","arata_promotion_start_date":"2025-01-01","arata_promotion_end_date":"2025-01-31","arata_promotion_type":"percentage","arata_promotion_terms":"Áp dụng cho đơn hàng từ 500.000đ trở lên"}' \
    --allow-root

# Tạo khuyến mãi 2: Mua 2 tặng 1
echo "Tạo khuyến mãi: Mua 2 tặng 1..."
docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Mua 2 tặng 1 - Combo chăm sóc da hoàn hảo" \
    --post_content="<p>Chương trình ưu đãi hấp dẫn: Mua 2 sản phẩm bất kỳ trong bộ sưu tập chăm sóc da, nhận ngay 1 sản phẩm miễn phí có giá trị thấp nhất.</p>

<h3>Sản phẩm áp dụng:</h3>
<ul>
<li>Kem dưỡng da Arata</li>
<li>Serum vitamin C</li>
<li>Toner cân bằng da</li>
<li>Sữa rửa mặt dịu nhẹ</li>
</ul>

<h3>Lưu ý:</h3>
<p>Sản phẩm tặng sẽ là sản phẩm có giá trị thấp nhất trong 3 sản phẩm được chọn. Chương trình có thể kết thúc sớm khi hết hàng tặng.</p>" \
    --post_status=publish \
    --post_name="mua-2-tang-1-combo-cham-soc-da" \
    --meta_input='{"arata_promotion_discount":"33","arata_promotion_code":"BUY2GET1","arata_promotion_start_date":"2025-01-15","arata_promotion_end_date":"2025-02-15","arata_promotion_type":"buy_x_get_y","arata_promotion_terms":"Sản phẩm tặng có giá trị thấp nhất"}' \
    --allow-root

# Tạo khuyến mãi 3: Freeship
echo "Tạo khuyến mãi: Miễn phí vận chuyển..."
docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Miễn phí vận chuyển toàn quốc" \
    --post_content="<p>Chúng tôi hỗ trợ miễn phí vận chuyển cho tất cả đơn hàng trên toàn quốc, giúp bạn tiết kiệm chi phí và nhận hàng nhanh chóng tại nhà.</p>

<h3>Điều kiện:</h3>
<ul>
<li>Áp dụng cho đơn hàng từ 300.000đ trở lên</li>
<li>Giao hàng trong vòng 2-3 ngày làm việc</li>
<li>Áp dụng cho tất cả tỉnh thành</li>
</ul>

<h3>Cách thức:</h3>
<p>Tự động áp dụng khi đơn hàng đạt giá trị tối thiểu. Không cần mã giảm giá.</p>" \
    --post_status=publish \
    --post_name="mien-phi-van-chuyen-toan-quoc" \
    --meta_input='{"arata_promotion_discount":"0","arata_promotion_code":"FREESHIP","arata_promotion_start_date":"2025-01-01","arata_promotion_end_date":"2025-12-31","arata_promotion_type":"free_shipping","arata_promotion_terms":"Đơn hàng từ 300.000đ"}' \
    --allow-root

# Tạo khuyến mãi 4: Flash sale
echo "Tạo khuyến mãi: Flash Sale cuối tuần..."
docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Flash Sale cuối tuần - Giảm đến 50%" \
    --post_content="<p>Chương trình Flash Sale đặc biệt chỉ diễn ra trong 3 ngày cuối tuần với mức giảm giá lên đến 50% cho các sản phẩm được chọn.</p>

<h3>Sản phẩm khuyến mãi:</h3>
<ul>
<li>Kem dưỡng da ban đêm - Giảm 50%</li>
<li>Serum chống lão hóa - Giảm 40%</li>
<li>Mặt nạ dưỡng ẩm - Giảm 35%</li>
<li>Tẩy trang dịu nhẹ - Giảm 30%</li>
</ul>

<h3>Thời gian:</h3>
<p>Từ 6h sáng thứ 6 đến 23h59 Chủ nhật hàng tuần. Số lượng có hạn, nhanh tay kẻo lỡ!</p>" \
    --post_status=publish \
    --post_name="flash-sale-cuoi-tuan-giam-den-50-phan-tram" \
    --meta_input='{"arata_promotion_discount":"50","arata_promotion_code":"FLASH50","arata_promotion_start_date":"2025-01-10","arata_promotion_end_date":"2025-01-12","arata_promotion_type":"flash_sale","arata_promotion_terms":"Số lượng có hạn"}' \
    --allow-root

# Tạo khuyến mãi 5: Khách hàng mới
echo "Tạo khuyến mãi: Ưu đãi khách hàng mới..."
docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Ưu đãi đặc biệt cho khách hàng mới" \
    --post_content="<p>Chào mừng bạn đến với Arata Vietnam! Để tri ân khách hàng mới, chúng tôi dành tặng ưu đãi đặc biệt cho đơn hàng đầu tiên của bạn.</p>

<h3>Ưu đãi bao gồm:</h3>
<ul>
<li>Giảm 15% cho đơn hàng đầu tiên</li>
<li>Tặng kèm 3 mẫu thử sản phẩm</li>
<li>Miễn phí vận chuyển</li>
<li>Tư vấn chăm sóc da miễn phí</li>
</ul>

<h3>Cách nhận ưu đãi:</h3>
<p>Đăng ký tài khoản mới và sử dụng mã <strong>WELCOME15</strong> cho đơn hàng đầu tiên.</p>" \
    --post_status=publish \
    --post_name="uu-dai-dac-biet-khach-hang-moi" \
    --meta_input='{"arata_promotion_discount":"15","arata_promotion_code":"WELCOME15","arata_promotion_start_date":"2025-01-01","arata_promotion_end_date":"2025-12-31","arata_promotion_type":"new_customer","arata_promotion_terms":"Chỉ áp dụng cho khách hàng mới"}' \
    --allow-root

echo ""
echo "✅ Đã tạo thành công 5 khuyến mãi mẫu!"
echo ""
echo "Các khuyến mãi đã tạo:"
echo "1. Giảm 20% toàn bộ sản phẩm chăm sóc da (SKINCARE20)"
echo "2. Mua 2 tặng 1 - Combo chăm sóc da (BUY2GET1)"
echo "3. Miễn phí vận chuyển toàn quốc (FREESHIP)"
echo "4. Flash Sale cuối tuần - Giảm đến 50% (FLASH50)"
echo "5. Ưu đãi đặc biệt cho khách hàng mới (WELCOME15)"
echo ""
echo "Truy cập: http://localhost:8080/khuyen-mai/ để xem kết quả"
