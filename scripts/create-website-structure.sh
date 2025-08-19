#!/bin/bash

echo "Tạo cấu trúc website Arata Vietnam theo brief..."

# Tạo trang "Về Arata"
echo "Tạo trang Về Arata..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Về Arata" \
    --post_name="ve-arata" \
    --post_content="<h1>Về Arata Vietnam</h1>
<h2>Giới thiệu công ty</h2>
<p>Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản, được thành lập với sứ mệnh mang đến cho người tiêu dùng Việt Nam những sản phẩm hóa mỹ phẩm chất lượng cao nhất từ Nhật Bản.</p>

<h2>Tầm nhìn</h2>
<p>Trở thành nhà phân phối hóa mỹ phẩm Nhật Bản hàng đầu tại Việt Nam, mang đến vẻ đẹp tự nhiên và sức khỏe cho làn da người Việt.</p>

<h2>Sứ mệnh</h2>
<p>Cung cấp các sản phẩm hóa mỹ phẩm chính hãng, chất lượng cao từ Nhật Bản với giá cả hợp lý, phù hợp với nhu cầu và điều kiện khí hậu Việt Nam.</p>

<h2>Giá trị cốt lõi</h2>
<ul>
<li><strong>Chất lượng:</strong> Cam kết 100% sản phẩm chính hãng từ Nhật Bản</li>
<li><strong>Uy tín:</strong> Xây dựng niềm tin với khách hàng qua dịch vụ tận tâm</li>
<li><strong>Đổi mới:</strong> Liên tục cập nhật xu hướng làm đẹp mới nhất</li>
<li><strong>Trách nhiệm:</strong> Cam kết bảo vệ môi trường và phát triển bền vững</li>
</ul>" \
    --post_status=publish \
    --allow-root

# Tạo trang "Dịch vụ"
echo "Tạo trang Dịch vụ..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Dịch vụ" \
    --post_name="dich-vu" \
    --post_content="<h1>Dịch vụ Arata Vietnam</h1>
<h2>Tư vấn sản phẩm</h2>
<p>Đội ngũ chuyên gia tư vấn giúp bạn lựa chọn sản phẩm phù hợp với loại da và nhu cầu cá nhân.</p>

<h2>Giao hàng tận nơi</h2>
<p>Dịch vụ giao hàng nhanh chóng trên toàn quốc với đội ngũ vận chuyển chuyên nghiệp.</p>

<h2>Chăm sóc khách hàng</h2>
<p>Hỗ trợ khách hàng 24/7 qua hotline, email và các kênh mạng xã hội.</p>

<h2>Chính sách đổi trả</h2>
<p>Chính sách đổi trả linh hoạt trong vòng 30 ngày với sản phẩm chưa sử dụng.</p>" \
    --post_status=publish \
    --allow-root

# Tạo trang "Tin tức" chính
echo "Tạo trang Tin tức..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Tin tức" \
    --post_name="tin-tuc" \
    --post_content="<h1>Tin tức Arata Vietnam</h1>
<p>Cập nhật những tin tức mới nhất về sản phẩm, chương trình khuyến mãi và xu hướng làm đẹp từ Nhật Bản.</p>

<h2>Danh mục tin tức</h2>
<ul>
<li><a href=\"/chuong-trinh-khuyen-mai\">Chương trình khuyến mãi</a></li>
<li><a href=\"/tuyen-dung\">Tuyển dụng</a></li>
<li><a href=\"/blog\">Blog làm đẹp</a></li>
</ul>" \
    --post_status=publish \
    --allow-root

# Tạo trang con "Chương trình khuyến mãi"
echo "Tạo trang Chương trình khuyến mãi..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Chương trình khuyến mãi" \
    --post_name="chuong-trinh-khuyen-mai" \
    --post_content="<h1>Chương trình khuyến mãi</h1>
<p>Đăng ký nhận thông tin về các chương trình khuyến mãi đặc biệt từ Arata Vietnam.</p>

<h2>Ưu đãi hiện tại</h2>
<ul>
<li>Giảm 20% cho đơn hàng đầu tiên</li>
<li>Miễn phí vận chuyển cho đơn hàng trên 500.000đ</li>
<li>Tặng quà cho khách hàng thân thiết</li>
</ul>

<h2>Đăng ký nhận tin</h2>
<p>Để nhận thông tin về các chương trình khuyến mãi mới nhất, vui lòng liên hệ với chúng tôi.</p>" \
    --post_status=publish \
    --allow-root

# Tạo trang con "Tuyển dụng"
echo "Tạo trang Tuyển dụng..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Tuyển dụng" \
    --post_name="tuyen-dung" \
    --post_content="<h1>Tuyển dụng</h1>
<h2>Cơ hội nghề nghiệp tại Arata Vietnam</h2>
<p>Gia nhập đội ngũ Arata Vietnam để cùng phát triển thương hiệu hóa mỹ phẩm Nhật Bản tại Việt Nam.</p>

<h2>Vị trí đang tuyển</h2>
<ul>
<li>Nhân viên tư vấn bán hàng</li>
<li>Chuyên viên marketing</li>
<li>Nhân viên kho vận</li>
<li>Chuyên viên chăm sóc khách hàng</li>
</ul>

<h2>Quyền lợi</h2>
<ul>
<li>Lương cạnh tranh + thưởng hiệu suất</li>
<li>Bảo hiểm đầy đủ theo quy định</li>
<li>Môi trường làm việc chuyên nghiệp</li>
<li>Cơ hội đào tạo và phát triển</li>
</ul>" \
    --post_status=publish \
    --allow-root

# Tạo trang con "Blog"
echo "Tạo trang Blog..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Blog" \
    --post_name="blog" \
    --post_content="<h1>Blog làm đẹp</h1>
<p>Khám phá những bí quyết làm đẹp, cách chăm sóc da và xu hướng mỹ phẩm mới nhất từ Nhật Bản.</p>

<h2>Chủ đề nổi bật</h2>
<ul>
<li>Cách chăm sóc da mặt theo từng loại da</li>
<li>Routine làm đẹp của phụ nữ Nhật Bản</li>
<li>Cách sử dụng sản phẩm hiệu quả</li>
<li>Xu hướng làm đẹp 2025</li>
</ul>" \
    --post_status=publish \
    --allow-root

# Tạo trang "Liên hệ"
echo "Tạo trang Liên hệ..."
docker-compose run --rm wp-cli wp post create \
    --post_type=page \
    --post_title="Liên hệ" \
    --post_name="lien-he" \
    --post_content="<h1>Liên hệ với Arata Vietnam</h1>
<h2>Thông tin liên hệ</h2>
<p><strong>Địa chỉ:</strong> Tầng 10, Tòa nhà ABC, 123 Đường XYZ, Quận 1, TP.HCM</p>
<p><strong>Điện thoại:</strong> (028) 1234 5678</p>
<p><strong>Email:</strong> info@aratavietnam.com</p>
<p><strong>Giờ làm việc:</strong> Thứ 2 - Thứ 6: 8:00 - 17:30</p>

<h2>Gửi câu hỏi cho chúng tôi</h2>
<p>Vui lòng điền thông tin dưới đây, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất.</p>

<form>
<p><label>Họ và tên *<br><input type=\"text\" name=\"fullname\" required></label></p>
<p><label>Số điện thoại<br><input type=\"tel\" name=\"phone\"></label></p>
<p><label>Email<br><input type=\"email\" name=\"email\"></label></p>
<p><label>Nội dung câu hỏi *<br><textarea name=\"message\" rows=\"5\" required></textarea></label></p>
<p><input type=\"submit\" value=\"Gửi câu hỏi\"></p>
</form>

<h2>Kết nối với chúng tôi</h2>
<p>Theo dõi Arata Vietnam trên các mạng xã hội:</p>
<ul>
<li>Facebook: facebook.com/aratavietnam</li>
<li>TikTok: @aratavietnam</li>
<li>Shopee: shopee.vn/aratavietnam</li>
</ul>" \
    --post_status=publish \
    --allow-root

echo "Hoàn thành tạo cấu trúc website!"
