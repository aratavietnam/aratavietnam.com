# Hướng dẫn triển khai trang "Về chúng tôi" - Arata Vietnam

## Tổng quan
Trang "Về chúng tôi" được thiết kế theo yêu cầu từ brief với:
- Layout 3 cột: Hình ảnh floating - Nội dung chính - Hình ảnh floating
- Nền xanh dương (secondary color)
- Hiệu ứng floating nhẹ nhàng cho hình ảnh sản phẩm
- Social links ở cuối trang
- Responsive design cho mobile

## Các file đã tạo

### 1. Page Template
- **File**: `themes/aratavietnam/page-templates/about.php`
- **Mô tả**: Template chính cho trang About với layout theo yêu cầu brief

### 2. Meta Fields
- **File**: `themes/aratavietnam/inc/about-meta.php`
- **Mô tả**: Tạo meta fields để admin có thể chỉnh sửa nội dung

### 3. CSS Styling
- **File**: `themes/aratavietnam/resources/css/custom.css`
- **Mô tả**: CSS cho floating animations và styling

### 4. Setup Script
- **File**: `scripts/create-about-page.sh`
- **Mô tả**: Script tự động tạo trang với nội dung mẫu

## Cách triển khai

### Bước 1: Tạo trang About thủ công

1. **Đăng nhập WordPress Admin** (http://localhost:8000/wp-admin)
   - Username: admin
   - Password: admin123

2. **Tạo trang mới**:
   - Vào **Pages > Add New**
   - Title: "Về Arata Vietnam"
   - Content: Thêm nội dung giới thiệu cơ bản
   - Page Template: Chọn "About Page"
   - Publish trang

### Bước 2: Cấu hình meta fields

1. **Sau khi tạo trang**, scroll xuống phần "About Page Settings"

2. **Tab Content**: Điền thông tin:
   - **Hero subtitle**: "Đối tác tin cậy trong lĩnh vực hóa mỹ phẩm Nhật Bản tại Việt Nam"
   - **Company Introduction**: Giới thiệu về công ty
   - **History & Achievements**: Lịch sử phát triển
   - **Mission & Vision**: Sứ mệnh và tầm nhìn
   - **Core Values**: Giá trị cốt lõi
   - **Quality Commitment**: Cam kết chất lượng

3. **Tab Social Links**: Thêm links:
   - Facebook: https://facebook.com/aratavietnam
   - Instagram: https://instagram.com/aratavietnam
   - TikTok: https://tiktok.com/@aratavietnam
   - Shopee: https://shopee.vn/aratavietnam

4. **Tab Product Images**: Thêm hình ảnh sản phẩm
   - Upload 3-4 hình ảnh cho bên trái
   - Upload 3-4 hình ảnh cho bên phải
   - Chọn hình ảnh có tone màu cam, vàng, xanh

### Bước 3: Upload hình ảnh sản phẩm

1. **Vào Media Library** (Media > Library)

2. **Upload hình ảnh sản phẩm**:
   - Tìm hình ảnh sản phẩm hóa mỹ phẩm Nhật Bản
   - Ưu tiên hình ảnh có background trong suốt (PNG)
   - Tone màu: cam (#F55E25), vàng (#FFAB14), xanh (#0066A6)

3. **Lưu Image IDs**:
   - Sau khi upload, note lại ID của từng hình ảnh
   - Hoặc sử dụng nút "Select Images" trong About Page Settings

## Nội dung mẫu

### Company Introduction
```
Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản, được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản cho thị trường Việt Nam.

Chúng tôi chuyên nhập khẩu trực tiếp các sản phẩm từ các thương hiệu uy tín tại Nhật Bản, đảm bảo tính chính hãng và chất lượng tốt nhất cho khách hàng.

Với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm, Arata Việt Nam cam kết cung cấp dịch vụ tốt nhất cho cả nhà bán lẻ và người tiêu dùng cuối.
```

### History & Achievements
```
2020: Thành lập công ty Arata Việt Nam tại TP. Hồ Chí Minh
2021: Ký kết hợp tác với các thương hiệu hóa mỹ phẩm hàng đầu Nhật Bản
2022: Mở rộng mạng lưới phân phối trên toàn quốc
2023: Đạt mốc 1000+ điểm bán hàng trên cả nước
2024: Ra mắt hệ thống thương mại điện tử và dịch vụ giao hàng tận nơi
2025: Tiếp tục mở rộng và phát triển với nhiều sản phẩm mới từ Nhật Bản
```

### Mission & Vision
```
Sứ mệnh:
Mang đến cho người tiêu dùng Việt Nam những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản với giá cả hợp lý và dịch vụ tận tâm.

Tầm nhìn:
Trở thành nhà phân phối hóa mỹ phẩm Nhật Bản hàng đầu tại Việt Nam, được khách hàng và đối tác tin tưởng lựa chọn.

Giá trị cốt lõi:
• Chất lượng: Cam kết sản phẩm chính hãng, chất lượng cao
• Uy tín: Xây dựng niềm tin bền vững với khách hàng
• Dịch vụ: Hỗ trợ tận tâm, chuyên nghiệp
• Đổi mới: Không ngừng cải tiến và phát triển
```

## Tính năng đặc biệt

### 1. Floating Images
- Hình ảnh sản phẩm có hiệu ứng floating nhẹ nhàng
- 3 loại animation khác nhau cho sự đa dạng
- Hover effect để tạo tương tác

### 2. Glassmorphism Design
- Background với hiệu ứng glass blur
- Tạo cảm giác hiện đại và chuyên nghiệp

### 3. Responsive Design
- Desktop: Layout 3 cột với floating images
- Mobile: Layout 1 cột với carousel cho hình ảnh

### 4. Social Integration
- Icons với hover effects
- Links đến các trang social media chính thức

## Kiểm tra kết quả

1. **Truy cập trang About**: http://localhost:8000/ve-arata-vietnam
2. **Kiểm tra responsive**: Test trên mobile và desktop
3. **Kiểm tra animations**: Floating images và hover effects
4. **Kiểm tra social links**: Đảm bảo links hoạt động

## Tùy chỉnh thêm

### Thay đổi màu sắc
- Edit file `themes/aratavietnam/theme.json`
- Hoặc sử dụng CSS variables trong `custom.css`

### Thêm animations
- Edit file `themes/aratavietnam/resources/css/custom.css`
- Thêm keyframes mới cho hiệu ứng khác

### Thay đổi layout
- Edit file `themes/aratavietnam/page-templates/about.php`
- Điều chỉnh grid layout và spacing

## Troubleshooting

### Hình ảnh không hiển thị
- Kiểm tra Image IDs trong meta fields
- Đảm bảo hình ảnh đã được upload thành công

### Animations không hoạt động
- Kiểm tra CSS đã được load
- Clear cache browser

### Layout bị lỗi trên mobile
- Kiểm tra responsive CSS
- Test trên nhiều kích thước màn hình khác nhau

## Kết luận

Trang "Về chúng tôi" đã được thiết kế theo đúng yêu cầu từ brief:
- ✅ Layout tương tự Cocoon Vietnam
- ✅ Nội dung ở giữa, hình ảnh floating ở hai bên
- ✅ Tone màu cam, vàng, xanh cho hình ảnh
- ✅ Social links ở cuối trang
- ✅ Nền xanh dương
- ✅ Hiệu ứng nhẹ nhàng, không giật nhanh
- ✅ Responsive design

Trang sẵn sàng để sử dụng và có thể tùy chỉnh thêm theo nhu cầu cụ thể.
