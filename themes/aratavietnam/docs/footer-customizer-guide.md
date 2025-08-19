# Hướng dẫn sử dụng Footer Customizer - Arata Vietnam

## Tổng quan

Footer Customizer cho phép bạn tùy chỉnh toàn bộ thông tin footer của website từ WordPress Admin mà không cần chỉnh sửa code.

## Cách truy cập

1. Đăng nhập WordPress Admin
2. Vào **Appearance > Customize**
3. Tìm và click vào **Footer Settings**

## Các tùy chọn có sẵn

### 1. Company Information (Thông tin công ty)

#### Company Name (Tên công ty)
- **Mặc định**: "Công ty TNHH Arata Việt Nam"
- **Mô tả**: Tên công ty hiển thị ở phần đầu footer bên trái

#### Company Address (Địa chỉ công ty)
- **Mặc định**: Địa chỉ The Landmark
- **Mô tả**: Địa chỉ đầy đủ của công ty
- **Lưu ý**: Có thể xuống dòng bằng cách nhấn Enter

#### Company Phone (Số điện thoại hiển thị)
- **Mặc định**: "028 3357 100"
- **Mô tả**: Số điện thoại hiển thị cho khách hàng

#### Phone Link (Liên kết điện thoại)
- **Mặc định**: "0283357100"
- **Mô tả**: Số điện thoại cho liên kết tel: (không có dấu cách)
- **Lưu ý**: Khi khách hàng click sẽ mở ứng dụng gọi điện

#### Company Email (Email công ty)
- **Mặc định**: "arata-vietnam@arata-gr.jp"
- **Mô tả**: Email liên hệ chính của công ty

#### Company Description (Mô tả công ty)
- **Mặc định**: Mô tả về Arata Vietnam
- **Mô tả**: Đoạn text mô tả ngắn về công ty
- **Lưu ý**: Có thể xuống dòng bằng cách nhấn Enter

### 2. Social Media Links (Liên kết mạng xã hội)

#### Facebook URL
- **Mặc định**: "https://www.facebook.com/aratavietnam"
- **Mô tả**: Liên kết đến trang Facebook
- **Lưu ý**: Để trống nếu không muốn hiển thị

#### Instagram URL
- **Mặc định**: "https://www.instagram.com/aratavietnam/"
- **Mô tả**: Liên kết đến trang Instagram
- **Lưu ý**: Để trống nếu không muốn hiển thị

#### Website URL
- **Mặc định**: "https://aratavietnam.com"
- **Mô tả**: Liên kết đến website chính
- **Lưu ý**: Để trống nếu không muốn hiển thị

#### TikTok URL
- **Mặc định**: Trống
- **Mô tả**: Liên kết đến trang TikTok
- **Lưu ý**: Chỉ hiển thị khi có URL

#### Shopee URL
- **Mặc định**: Trống
- **Mô tả**: Liên kết đến shop Shopee
- **Lưu ý**: Chỉ hiển thị khi có URL

### 3. Footer Display Settings (Cài đặt hiển thị)

#### Customer Service Title (Tiêu đề dịch vụ khách hàng)
- **Mặc định**: "Dịch vụ khách hàng"
- **Mô tả**: Tiêu đề cho phần menu footer bên phải

#### Copyright Text (Text bản quyền)
- **Mặc định**: "Tất cả quyền được bảo lưu"
- **Mô tả**: Text hiển thị sau tên công ty trong phần copyright

#### Show Floating Social Widget (Hiển thị widget mạng xã hội nổi)
- **Mặc định**: Bật
- **Mô tả**: Hiển thị widget mạng xã hội nổi ở góc trái dưới màn hình
- **Lưu ý**: Widget sẽ sử dụng các URL social media đã cấu hình ở trên

## Tính năng đặc biệt

### Live Preview
- Tất cả thay đổi được hiển thị ngay lập tức trong preview panel
- Không cần reload trang để xem kết quả

### Responsive Design
- Footer tự động điều chỉnh cho mobile và desktop
- Thứ tự hiển thị thay đổi phù hợp với từng thiết bị

### Conditional Display
- Social media icons chỉ hiển thị khi có URL
- Tự động ẩn các icon không có liên kết

## Hướng dẫn sử dụng từng bước

### Bước 1: Cập nhật thông tin công ty
1. Vào **Company Information**
2. Cập nhật tên công ty, địa chỉ, điện thoại, email
3. Chỉnh sửa mô tả công ty theo ý muốn

### Bước 2: Cấu hình social media
1. Vào **Social Media Links**
2. Nhập URL đầy đủ cho từng platform
3. Để trống những platform không sử dụng

### Bước 3: Tùy chỉnh hiển thị
1. Vào **Footer Display Settings**
2. Thay đổi tiêu đề dịch vụ khách hàng nếu cần
3. Cập nhật text copyright

### Bước 4: Kiểm tra và lưu
1. Kiểm tra preview ở panel bên phải
2. Test trên cả desktop và mobile
3. Click **Publish** để lưu thay đổi

## Lưu ý quan trọng

### Format URL
- Luôn bao gồm `https://` hoặc `http://`
- Ví dụ đúng: `https://www.facebook.com/aratavietnam`
- Ví dụ sai: `www.facebook.com/aratavietnam`

### Xuống dòng
- Trong Address và Description, nhấn Enter để xuống dòng
- Text sẽ tự động format với `<br>` tags

### Số điện thoại
- **Phone Display**: Format đẹp cho hiển thị (028 3357 100)
- **Phone Link**: Chỉ số, không dấu cách (0283357100)

### Backup
- Trước khi thay đổi lớn, nên backup website
- Có thể export/import customizer settings

## Troubleshooting

### Thay đổi không hiển thị
1. Kiểm tra đã click **Publish** chưa
2. Clear cache nếu có plugin cache
3. Hard refresh browser (Ctrl+F5)

### Social icons không hiển thị
1. Kiểm tra URL có đúng format không
2. Đảm bảo có `https://` ở đầu
3. Kiểm tra URL có hoạt động không

### Layout bị lỗi trên mobile
1. Kiểm tra content có quá dài không
2. Test trên nhiều thiết bị khác nhau
3. Có thể cần điều chỉnh CSS custom

## Hỗ trợ

Nếu gặp vấn đề, vui lòng liên hệ team phát triển với thông tin:
- Screenshot lỗi
- Thiết bị đang sử dụng
- Browser và version
- Các bước đã thực hiện
