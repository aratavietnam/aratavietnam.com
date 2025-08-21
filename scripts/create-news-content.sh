#!/bin/bash

echo "Creating News Content for Arata Vietnam..."

# Create main News page
echo "Creating main News page..."
docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Tin tức" \
    --post_content="<p>Cập nhật những tin tức mới nhất từ Arata Vietnam - từ các chương trình khuyến mãi hấp dẫn, cơ hội việc làm tại công ty đến những bài viết chia sẻ kiến thức về sản phẩm hóa mỹ phẩm Nhật Bản.</p>

<p>Chúng tôi cam kết mang đến cho khách hàng những thông tin chính xác, kịp thời và hữu ích nhất.</p>" \
    --post_status=publish \
    --meta_input='{"_wp_page_template":"page-templates/news.php","arata_news_subtitle":"Cập nhật tin tức mới nhất từ Arata Vietnam","arata_news_intro":"Khám phá những tin tức, khuyến mãi và cơ hội nghề nghiệp tại Arata Vietnam"}' \
    --allow-root

# Create Promotions page
echo "Creating Promotions page..."
docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Khuyến mãi" \
    --post_content="<p>Khám phá các chương trình khuyến mãi hấp dẫn từ Arata Vietnam. Chúng tôi thường xuyên có những ưu đãi đặc biệt dành cho khách hàng yêu thích sản phẩm hóa mỹ phẩm Nhật Bản chất lượng cao.</p>" \
    --post_status=publish \
    --meta_input='{"_wp_page_template":"page-templates/promotions.php","arata_news_subtitle":"Ưu đãi đặc biệt từ Arata Vietnam"}' \
    --allow-root

# Create Careers page
echo "Creating Careers page..."
docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Tuyển dụng" \
    --post_content="<p>Gia nhập đội ngũ Arata Vietnam - nơi bạn có thể phát triển sự nghiệp trong lĩnh vực hóa mỹ phẩm hàng đầu. Chúng tôi luôn tìm kiếm những tài năng để cùng xây dựng thương hiệu mạnh mẽ tại thị trường Việt Nam.</p>" \
    --post_status=publish \
    --meta_input='{"_wp_page_template":"page-templates/careers.php","arata_news_subtitle":"Cơ hội nghề nghiệp tại Arata Vietnam"}' \
    --allow-root

# Create Blog page
echo "Creating Blog page..."
docker-compose exec wp-cli wp post create \
    --post_type=page \
    --post_title="Blog" \
    --post_content="<p>Khám phá những bài viết chuyên sâu về hóa mỹ phẩm, xu hướng làm đẹp và những câu chuyện thú vị từ Arata Vietnam.</p>" \
    --post_status=publish \
    --meta_input='{"_wp_page_template":"page-templates/blog.php","arata_news_subtitle":"Chia sẻ kiến thức và kinh nghiệm"}' \
    --allow-root

# Create sample promotions
echo "Creating sample promotions..."

docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Giảm 30% toàn bộ sản phẩm chăm sóc da" \
    --post_content="<p>Chương trình khuyến mãi đặc biệt dành cho các sản phẩm chăm sóc da từ Nhật Bản. Áp dụng cho tất cả sản phẩm trong bộ sưu tập skincare cao cấp.</p>

<h3>Sản phẩm áp dụng:</h3>
<ul>
<li>Kem dưỡng ẩm Arata Premium</li>
<li>Serum vitamin C</li>
<li>Sữa rửa mặt làm sạch sâu</li>
<li>Toner cân bằng độ pH</li>
</ul>

<h3>Điều kiện:</h3>
<ul>
<li>Áp dụng cho đơn hàng từ 500.000đ</li>
<li>Không áp dụng cùng với khuyến mãi khác</li>
<li>Số lượng có hạn</li>
</ul>" \
    --post_status=publish \
    --meta_input='{"arata_promotion_type":"percentage","arata_promotion_discount":"30%","arata_promotion_code":"SKINCARE30","arata_promotion_start_date":"2025-01-01","arata_promotion_end_date":"2025-02-28","arata_promotion_conditions":"Đơn hàng từ 500.000đ, không áp dụng cùng khuyến mãi khác","arata_promotion_products":"Tất cả sản phẩm chăm sóc da"}' \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Mua 2 tặng 1 - Bộ sản phẩm chăm sóc tóc" \
    --post_content="<p>Ưu đãi hấp dẫn cho bộ sản phẩm chăm sóc tóc từ Nhật Bản. Mua 2 sản phẩm bất kỳ trong bộ sưu tập và nhận ngay 1 sản phẩm miễn phí.</p>

<p>Sản phẩm tặng sẽ là sản phẩm có giá trị thấp nhất trong 3 sản phẩm được chọn.</p>" \
    --post_status=publish \
    --meta_input='{"arata_promotion_type":"buy_get","arata_promotion_discount":"Mua 2 tặng 1","arata_promotion_code":"HAIR321","arata_promotion_start_date":"2025-01-15","arata_promotion_end_date":"2025-03-15","arata_promotion_conditions":"Áp dụng cho sản phẩm chăm sóc tóc, sản phẩm tặng có giá trị thấp nhất","arata_promotion_products":"Bộ sưu tập chăm sóc tóc"}' \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=promotion \
    --post_title="Miễn phí vận chuyển toàn quốc" \
    --post_content="<p>Miễn phí vận chuyển cho tất cả đơn hàng trên toàn quốc. Áp dụng cho mọi sản phẩm và không giới hạn số lượng.</p>

<p>Thời gian giao hàng: 2-3 ngày làm việc tại TP.HCM và Hà Nội, 3-5 ngày làm việc tại các tỉnh thành khác.</p>" \
    --post_status=publish \
    --meta_input='{"arata_promotion_type":"free_shipping","arata_promotion_discount":"Miễn phí ship","arata_promotion_code":"FREESHIP","arata_promotion_start_date":"2025-01-01","arata_promotion_end_date":"2025-12-31","arata_promotion_conditions":"Áp dụng cho tất cả đơn hàng","arata_promotion_products":"Tất cả sản phẩm"}' \
    --allow-root

# Create sample job postings
echo "Creating sample job postings..."

docker-compose exec wp-cli wp post create \
    --post_type=job_posting \
    --post_title="Nhân viên Kinh doanh" \
    --post_content="<p>Chúng tôi đang tìm kiếm nhân viên kinh doanh năng động để mở rộng thị trường sản phẩm hóa mỹ phẩm Nhật Bản tại Việt Nam.</p>

<h3>Mô tả công việc:</h3>
<ul>
<li>Phát triển và duy trì mối quan hệ với khách hàng</li>
<li>Tư vấn sản phẩm cho khách hàng</li>
<li>Thực hiện kế hoạch bán hàng</li>
<li>Báo cáo kết quả kinh doanh</li>
</ul>

<h3>Yêu cầu:</h3>
<ul>
<li>Tốt nghiệp Đại học các chuyên ngành liên quan</li>
<li>Có kinh nghiệm bán hàng từ 1 năm trở lên</li>
<li>Kỹ năng giao tiếp tốt</li>
<li>Tiếng Anh giao tiếp</li>
</ul>" \
    --post_status=publish \
    --meta_input='{"arata_job_department":"Kinh doanh","arata_job_location":"TP. Hồ Chí Minh","arata_job_type":"full_time","arata_job_level":"junior","arata_job_salary":"12-18 triệu","arata_job_deadline":"2025-03-31","arata_job_requirements":"Tốt nghiệp Đại học, kinh nghiệm bán hàng 1+ năm, tiếng Anh giao tiếp","arata_job_benefits":"Lương cơ bản + hoa hồng, bảo hiểm đầy đủ, đào tạo sản phẩm","arata_job_contact":"hr@aratavietnam.com - 028 3827 7060"}' \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=job_posting \
    --post_title="Chuyên viên Marketing" \
    --post_content="<p>Vị trí chuyên viên marketing để phát triển thương hiệu Arata Vietnam trên các kênh truyền thông số.</p>

<h3>Trách nhiệm chính:</h3>
<ul>
<li>Lập kế hoạch marketing tổng thể</li>
<li>Quản lý các kênh social media</li>
<li>Tạo nội dung sáng tạo</li>
<li>Phân tích hiệu quả chiến dịch</li>
</ul>" \
    --post_status=publish \
    --meta_input='{"arata_job_department":"Marketing","arata_job_location":"TP. Hồ Chí Minh","arata_job_type":"full_time","arata_job_level":"senior","arata_job_salary":"15-25 triệu","arata_job_deadline":"2025-02-28","arata_job_requirements":"Kinh nghiệm marketing 2+ năm, thành thạo các công cụ digital marketing","arata_job_benefits":"Lương cạnh tranh, môi trường sáng tạo, cơ hội thăng tiến","arata_job_contact":"hr@aratavietnam.com"}' \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=job_posting \
    --post_title="Thực tập sinh Kinh doanh" \
    --post_content="<p>Cơ hội thực tập tuyệt vời cho sinh viên muốn tìm hiểu về ngành hóa mỹ phẩm và phát triển kỹ năng kinh doanh.</p>

<h3>Bạn sẽ được:</h3>
<ul>
<li>Hỗ trợ team kinh doanh trong các hoạt động hàng ngày</li>
<li>Tham gia các buổi training về sản phẩm</li>
<li>Học hỏi quy trình bán hàng chuyên nghiệp</li>
<li>Có cơ hội trở thành nhân viên chính thức</li>
</ul>" \
    --post_status=publish \
    --meta_input='{"arata_job_department":"Kinh doanh","arata_job_location":"TP. Hồ Chí Minh","arata_job_type":"internship","arata_job_level":"intern","arata_job_salary":"5-7 triệu","arata_job_deadline":"2025-04-30","arata_job_requirements":"Sinh viên năm 3, 4 hoặc mới tốt nghiệp, nhiệt tình học hỏi","arata_job_benefits":"Trợ cấp thực tập, đào tạo miễn phí, cơ hội việc làm full-time","arata_job_contact":"hr@aratavietnam.com"}' \
    --allow-root

# Create sample blog posts
echo "Creating sample blog posts..."

docker-compose exec wp-cli wp post create \
    --post_type=post \
    --post_title="5 Bước chăm sóc da cơ bản với sản phẩm Nhật Bản" \
    --post_content="<p>Chăm sóc da theo phương pháp Nhật Bản nổi tiếng với sự tỉ mỉ và hiệu quả. Hãy cùng Arata Vietnam tìm hiểu 5 bước chăm sóc da cơ bản để có làn da khỏe mạnh và rạng rỡ.</p>

<h2>Bước 1: Làm sạch da</h2>
<p>Làm sạch da là bước đầu tiên và quan trọng nhất trong quy trình chăm sóc da. Sử dụng sữa rửa mặt phù hợp với loại da để loại bỏ bụi bẩn, dầu thừa và tế bào chết.</p>

<h2>Bước 2: Toner cân bằng</h2>
<p>Toner giúp cân bằng độ pH của da và chuẩn bị cho các bước tiếp theo. Chọn toner không chứa cồn để tránh làm khô da.</p>

<h2>Bước 3: Serum dưỡng chất</h2>
<p>Serum chứa nồng độ dưỡng chất cao, giúp giải quyết các vấn đề cụ thể của da như lão hóa, thâm nám, hay thiếu ẩm.</p>

<h2>Bước 4: Kem dưỡng ẩm</h2>
<p>Kem dưỡng ẩm giúp khóa ẩm và bảo vệ da khỏi các tác nhân gây hại từ môi trường.</p>

<h2>Bước 5: Kem chống nắng</h2>
<p>Kem chống nắng là bước cuối cùng vào ban ngày, bảo vệ da khỏi tác hại của tia UV.</p>" \
    --post_status=publish \
    --post_excerpt="Khám phá 5 bước chăm sóc da cơ bản theo phương pháp Nhật Bản để có làn da khỏe mạnh và rạng rỡ." \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=post \
    --post_title="Xu hướng làm đẹp Nhật Bản 2025" \
    --post_content="<p>Năm 2025, ngành làm đẹp Nhật Bản tiếp tục dẫn đầu với những xu hướng mới mang tính đột phá. Cùng Arata Vietnam khám phá những xu hướng hot nhất.</p>

<h2>Glass Skin - Làn da trong suốt như thủy tinh</h2>
<p>Xu hướng glass skin tiếp tục thống trị, tập trung vào việc tạo ra làn da mịn màng, trong suốt và rạng rỡ tự nhiên.</p>

<h2>Skinimalism - Tối giản hóa quy trình</h2>
<p>Thay vì sử dụng nhiều sản phẩm, xu hướng skinimalism khuyến khích sử dụng ít sản phẩm nhưng chất lượng cao và hiệu quả.</p>

<h2>Sustainable Beauty - Làm đẹp bền vững</h2>
<p>Các thương hiệu Nhật Bản ngày càng chú trọng đến tính bền vững trong sản xuất và đóng gói sản phẩm.</p>" \
    --post_status=publish \
    --post_excerpt="Khám phá những xu hướng làm đẹp hot nhất từ Nhật Bản trong năm 2025." \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=post \
    --post_title="Cách chọn sản phẩm chăm sóc tóc phù hợp" \
    --post_content="<p>Mỗi loại tóc có những đặc điểm riêng và cần được chăm sóc bằng sản phẩm phù hợp. Hãy cùng tìm hiểu cách chọn sản phẩm chăm sóc tóc đúng cách.</p>

<h2>Xác định loại tóc của bạn</h2>
<p>Trước tiên, bạn cần xác định loại tóc: tóc khô, tóc dầu, tóc hỗn hợp, tóc nhuộm, hay tóc hư tổn.</p>

<h2>Chọn dầu gội phù hợp</h2>
<p>Dầu gội là sản phẩm quan trọng nhất trong quy trình chăm sóc tóc. Chọn dầu gội phù hợp với loại tóc và da đầu.</p>

<h2>Sử dụng dầu xả và kem ủ</h2>
<p>Dầu xả giúp làm mềm tóc và dễ chải, trong khi kem ủ cung cấp dưỡng chất sâu cho tóc.</p>" \
    --post_status=publish \
    --post_excerpt="Hướng dẫn chi tiết cách chọn sản phẩm chăm sóc tóc phù hợp với từng loại tóc." \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=post \
    --post_title="Bí quyết giữ làn da khỏe mạnh mùa hanh khô" \
    --post_content="<p>Mùa hanh khô là thử thách lớn đối với làn da. Độ ẩm trong không khí giảm khiến da dễ bị khô, nứt nẻ và lão hóa sớm.</p>

<h2>Tăng cường dưỡng ẩm</h2>
<p>Sử dụng kem dưỡng ẩm có kết cấu đậm đặc hơn và chứa các thành phần như hyaluronic acid, ceramide.</p>

<h2>Sử dụng máy tạo ẩm</h2>
<p>Máy tạo ẩm giúp duy trì độ ẩm trong không khí, bảo vệ da khỏi bị khô.</p>

<h2>Uống đủ nước</h2>
<p>Cung cấp đủ nước cho cơ thể từ bên trong cũng quan trọng không kém việc dưỡng ẩm từ bên ngoài.</p>" \
    --post_status=publish \
    --post_excerpt="Những bí quyết đơn giản nhưng hiệu quả để giữ làn da khỏe mạnh trong mùa hanh khô." \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=post \
    --post_title="Review chi tiết bộ sản phẩm Arata Premium Skincare" \
    --post_content="<p>Bộ sản phẩm Arata Premium Skincare là dòng sản phẩm cao cấp nhất của thương hiệu, được phát triển với công nghệ tiên tiến từ Nhật Bản.</p>

<h2>Thành phần nổi bật</h2>
<p>Bộ sản phẩm chứa các thành phần quý hiếm như collagen marine, vitamin C ổn định, và peptide phục hồi.</p>

<h2>Hiệu quả sau 4 tuần sử dụng</h2>
<p>Sau 4 tuần sử dụng đều đặn, da trở nên mịn màng hơn, đều màu và giảm thiểu các dấu hiệu lão hóa.</p>

<h2>Đánh giá tổng thể</h2>
<p>Đây là bộ sản phẩm đáng đầu tư cho những ai muốn chăm sóc da một cách chuyên sâu và hiệu quả.</p>" \
    --post_status=publish \
    --post_excerpt="Review chi tiết về hiệu quả và trải nghiệm sử dụng bộ sản phẩm Arata Premium Skincare." \
    --allow-root

docker-compose exec wp-cli wp post create \
    --post_type=post \
    --post_title="Câu chuyện thành công của Arata tại thị trường Việt Nam" \
    --post_content="<p>Từ khi ra mắt tại Việt Nam, Arata đã nhanh chóng chiếm được lòng tin của người tiêu dùng nhờ chất lượng sản phẩm vượt trội và dịch vụ tận tâm.</p>

<h2>Hành trình 5 năm phát triển</h2>
<p>Trong 5 năm qua, Arata đã mở rộng từ 1 cửa hàng đến hệ thống phân phối rộng khắp cả nước.</p>

<h2>Cam kết chất lượng</h2>
<p>Mọi sản phẩm đều được nhập khẩu trực tiếp từ Nhật Bản và trải qua kiểm định nghiêm ngặt.</p>

<h2>Tầm nhìn tương lai</h2>
<p>Arata hướng tới mục tiêu trở thành thương hiệu hóa mỹ phẩm Nhật Bản số 1 tại Việt Nam.</p>" \
    --post_status=publish \
    --post_excerpt="Câu chuyện về hành trình phát triển và thành công của thương hiệu Arata tại thị trường Việt Nam." \
    --allow-root

echo "News content creation completed!"
echo "Created:"
echo "- 4 pages (News, Promotions, Careers, Blog)"
echo "- 3 promotion posts"
echo "- 3 job posting posts"
echo "- 6 blog posts"
echo ""
echo "You can now:"
echo "1. Visit http://localhost:8000/tin-tuc to see the main news page"
echo "2. Go to WordPress admin to manage content"
echo "3. Customize the content as needed"
