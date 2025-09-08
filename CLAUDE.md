# CLAUDE.md

File này cung cấp hướng dẫn cho Claude Code (claude.ai/code) khi làm việc với repository này.

## Kiến trúc Dự án

Website thương mại điện tử WordPress được container hóa cho Arata Vietnam (Nhà phân phối mỹ phẩm Nhật Bản) sử dụng framework TailPress với các công cụ xây dựng hiện đại và bản địa hóa tiếng Việt toàn diện.

### Stack Công nghệ Chính
- **WordPress**: Phiên bản mới nhất với WooCommerce + bản dịch tiếng Việt toàn diện
- **TailPress Framework v5.0.4**: WordPress theme framework với Tailwind CSS v4
- **Vite 6.3+**: Module bundler với HMR, ES6 modules, hashed asset names
- **Docker**: MySQL 8.0, WordPress, WP CLI với thiết lập tự động
- **PHP 8.0.2+**: PHP hiện đại với PSR-4 autoloading

## Lệnh Phát Triển

```bash
# Môi trường (từ thư mục gốc dự án)
docker-compose up -d                    # Khởi động tất cả dịch vụ
docker-compose logs -f wp-cli          # Giám sát thiết lập WordPress
docker-compose down                    # Dừng tất cả dịch vụ
docker-compose down -v && docker-compose up -d  # Đặt lại hoàn toàn với dữ liệu mới

# Phát triển theme (từ themes/aratavietnam/)
npm run dev                           # Vite dev server (cổng 3000) với HMR
npm run build                         # Build production với phiên bản & hashed filenames
composer install                     # PHP dependencies (TailPress framework)

# Thao tác WordPress CLI
docker-compose exec wp-cli wp --allow-root [command]
docker-compose exec wp-cli wp post list --allow-root
docker-compose exec wp-cli wp db export backup.sql --allow-root

# Scripts quản lý nội dung (từ thư mục gốc)
./scripts/create-website-structure.sh    # Tạo các trang cơ bản
./scripts/create-news-content.sh         # Tạo nội dung tin tức mẫu
./scripts/fix-docker-permissions.sh      # Sửa quyền file

# Scripts tiện ích phát triển (55+ tổng - khám phá với ls scripts/)
./scripts/setup-woocommerce.sh          # Cấu hình WooCommerce
./scripts/create-demo-products.sh       # Dữ liệu sản phẩm mẫu
./scripts/update-product-images.sh      # Cập nhật hàng loạt hình ảnh sản phẩm
./scripts/update-all-pages-images.sh    # Cập nhật featured images cho tất cả trang
./scripts/update-homepage-images.sh     # Cập nhật hình ảnh các phần homepage
./scripts/update-promotions-services-images.sh  # Cập nhật hình ảnh khuyến mãi và dịch vụ

# Scripts SEO và tối ưu hóa nội dung
./scripts/bulk-update-*.php            # Cập nhật hàng loạt focus keywords cho SEO
./scripts/fix-product-images.sh        # Sửa URLs và thuộc tính hình ảnh sản phẩm
./scripts/check_missing_thumbnails.sh  # Kiểm tra featured images bị thiếu

# Scripts cấu trúc site và menu
./scripts/create-*.sh                  # Tạo các loại trang và nội dung khác nhau
./scripts/fix-menu-*.sh                # Sửa cấu trúc menu điều hướng
./scripts/setup-*.sh                   # Thiết lập các thành phần site khác nhau

# Xác minh build và quản lý assets
./scripts/verify-build.sh              # Xác minh tất cả assets và functions đã build

# Scripts riêng cho Docker
./scripts/update-page-featured-images-docker.sh     # Cập nhật hình ảnh sử dụng Docker
./scripts/update-page-images-docker-improved.sh     # Cập nhật hình ảnh Docker cải tiến
```

### Điểm Truy Cập
- **Frontend**: http://localhost:8080
- **Admin**: http://localhost:8080/wp-admin (admin/admin123)
- **Vite Dev Server**: http://localhost:3000 (HMR cho phát triển)
- **Database**: MySQL trên cổng 3306 (wordpress/wordpress_password)

**Lưu ý**: README.md hiển thị sai cổng 8000, nhưng docker-compose.yml thực tế sử dụng cổng 8080. Tất cả tài liệu nên tham chiếu đến cổng 8080.

## Kiến trúc Theme

### Tích hợp TailPress Framework
Theme tuân theo các quy ước của TailPress với kiến trúc modular:

- **Điểm vào**: `functions.php` → hàm `aratavietnam()` khởi tạo framework
- **Asset Pipeline**: `resources/` → Vite compilation → `dist/` output
- **Hệ thống Module**: Tất cả chức năng được tổ chức trong các module thư mục `inc/`
- **Hệ thống Template**: Component-based với tổ chức `template-parts/`

### Các Module Chính (thư mục inc)

**Framework Chính:**
- `woocommerce.php` - Chức năng thương mại điện tử + bản dịch tiếng Việt
- `fonts-vietnamese.php` - Tối ưu hóa typography tiếng Việt
- `favicon-pwa.php` - Định danh site và cấu hình PWA
- `logo-branding.php` - Thương hiệu và định danh site
- `customizer-colors.php` + `customizer-footer.php` - Mở rộng WordPress Customizer

**Quản lý Nội dung:**
- `news-post-types.php` + `news-meta-fields.php` + `news-forms.php` - Hệ thống tin tức/blog
- `services-post-types.php` + `services-meta.php` - Custom post type dịch vụ với meta
- `partner-post-type.php` - Quản lý đối tác
- `contact-form.php` + `contact-meta.php` + `contact-config.php` - Hệ thống liên hệ

**Thương mại điện tử:**
- `product-brand-taxonomy.php` - Taxonomy thương hiệu sản phẩm
- `product-filters.php` - Bộ lọc sản phẩm nâng cao
- `product-assets.php` - Tải asset riêng cho sản phẩm
- `product-policies-meta.php` - Quản lý chính sách sản phẩm

**Templates Trang & Meta:**
- Các file `*-meta.php` - Admin meta boxes cho các loại trang khác nhau
- `shop-meta.php`, `blog-meta.php`, `careers-meta.php`, `promotions-meta.php`, `homepage-meta.php`, `services-meta.php`

**Xác thực & Ứng dụng:**
- `auth-handler.php` - Hệ thống xác thực người dùng
- `job-application-handler.php` - Xử lý ứng tuyển việc làm

**Admin & Phát triển:**
- `admin-columns.php` - Cấu hình cột admin tùy chỉnh
- `upload-mimes.php` - Hạn chế loại file upload (bao gồm hỗ trợ SVG với bảo mật)
- `template-filters.php` - Hooks sửa đổi template
- `class-dropdown-walker.php` - Navigation walker tùy chỉnh
- `asset-management.php` - Tiện ích phát hiện hash asset tự động

### Custom Post Types & Tính năng
- **Post Types**: Tin tức, Dịch vụ, Tuyển dụng, Đối tác (với các meta field phong phú)
- **Tích hợp WooCommerce**: Bản địa hóa tiếng Việt đầy đủ, quy trình checkout tùy chỉnh
- **Page Templates**: Templates chuyên dụng cho Tin tức, Khuyến mãi, Tuyển dụng, Liên hệ, Dịch vụ, Giới thiệu
- **REST API**: Endpoint tìm kiếm tùy chỉnh `/wp-json/aratavietnam/v1/search` với featured images
- **JavaScript Modules**: ES6 modules hiện đại với dynamic imports

### Hệ thống Build Vite
**Cấu hình** (`vite.config.mjs`):
- **Entry Points**: Nhiều JS modules + CSS files
  - `app.js` (ứng dụng chính)
  - `notifications.js` (hệ thống thông báo)
  - `add-to-cart.js` (tích hợp WooCommerce)
  - `product-single.js` (tính năng trang sản phẩm)
  - `app.css` (stylesheet chính)
  - `editor-style.css` (styles WordPress editor)
- **Phát triển**: Cổng 3000, CORS enabled, origin `aratavietnam.test`
- **Production**: Tạo manifest, hashed filenames, module script tags
- **Tailwind CSS v4**: Tích hợp qua plugin `@tailwindcss/vite`

### Kiến trúc JavaScript
**Hệ thống ES6 Module Hiện đại:**
- **Main App (`app.js`)**: Entry point import icons, popups, fonts; phát hiện tải font tiếng Việt
- **Tính năng Sản phẩm**: Gallery (PhotoSwipe + Swiper), variants, add-to-cart với tải có điều kiện
- **Hệ thống Liên hệ (`contact-popup.js`)**: Modal popups với validation form
- **Hệ thống Xác thực (`auth-popup.js`)**: Authentication popups và handlers
- **Hệ thống Thông báo (`notifications.js`)**: Toast notifications cho phản hồi người dùng
- **Hệ thống Icon (`icons.js`)**: Lucide icons với dynamic imports và caching

**Dependencies (package.json):**
- **UI Components**: Lucide icons (0.540.0), Swiper gallery (11.0.5), PhotoSwipe lightbox (5.4.3)
- **Build System**: Vite (6.3.2), Tailwind CSS (4.0.0) với plugin @tailwindcss/vite
- **Browser Automation**: Puppeteer (24.19.0) cho testing và web scraping

## Quản lý Asset & Hệ thống Build

### Mẫu Tích hợp TailPress
- **Framework Entry**: `functions.php:84` → hàm `aratavietnam()` khởi tạo TailPress
- **Vite Compiler**: `ViteCompiler` tùy chỉnh với handle `aratavietnam` cho quản lý cache
- **Conditional Assets**: JS riêng cho sản phẩm chỉ tải trên các trang `is_product()`
- **Module Script Tags**: `type="module"` tự động áp dụng cho theme scripts

### Quản lý Hashed Asset
**⚠️ BƯỚC BUILD QUAN TRỌNG**: Hệ thống build tạo ra hashed filenames phải được cập nhật thủ công trong `functions.php:189-203` sau mỗi lần `npm run build`. Build sẽ hoạt động nhưng assets sẽ không tải nếu không có bước cập nhật thủ công này.

**Quản lý Asset Tự động**
Module `asset-management.php` cung cấp các hàm helper để loại bỏ cập nhật hash thủ công:

```php
// Tự động phát hiện và enqueue assets
aratavietnam_enqueue_asset('aratavietnam-app', 'app', ['jquery'], null, true);
aratavietnam_enqueue_asset('aratavietnam-notifications', 'notifications');
aratavietnam_enqueue_style_asset('aratavietnam-app-css', 'app');

// Debug tất cả assets có sẵn
$assets = aratavietnam_get_all_assets();
error_log(print_r($assets, true));
```

```php
// BẮT BUỘC: Sau npm run build, cập nhật các hashed filenames này trong functions.php
wp_enqueue_script('aratavietnam-app', get_template_directory_uri() . '/dist/app-CdtiypLP.js',
wp_enqueue_script('aratavietnam-notifications', get_template_directory_uri() . '/dist/notifications-DX7Hjlbv.js',
wp_enqueue_script('aratavietnam-add-to-cart', get_template_directory_uri() . '/dist/add-to-cart-DOaesbe3.js',
wp_enqueue_script('aratavietnam-product-single', get_template_directory_uri() . '/dist/product-single-DWIbL6ns.js',
```

**Build Workflow**: 
1. `npm run build` → Tạo hashed assets
2. `./scripts/verify-build.sh` → Xác minh tất cả assets đã build đúng
3. Cập nhật hashes thủ công trong functions.php:189-203 HOẶC sử dụng hàm tự động
4. Kiểm tra tải asset trong trình duyệt

### Thương hiệu & Bản địa hóa
- **Màu sắc**: Primary #F55E25, Secondary #0066A6, Tertiary #FFAB14
- **Typography**: Font Inter với fallbacks tiếng Việt và phát hiện tải
- **Múi giờ**: Asia/Ho_Chi_Minh
- **Ngôn ngữ**: Bản dịch tiếng Việt toàn diện cho quy trình checkout WooCommerce

## Các Mẫu Kiến trúc Chính

### Kiến trúc PHP Modular
Tất cả chức năng được tổ chức trong các module `/inc/` với các mẫu đặt tên cụ thể:
- `*-post-types.php`: Đăng ký custom post type
- `*-meta-fields.php` + `*-meta.php`: Hệ thống admin meta box
- `*-forms.php`: Xử lý form frontend
- `contact-*`: Hệ thống liên hệ ba file (form, meta, config)

### Tích hợp Hệ thống Template
- **Page Templates**: `page-templates/*.php` đăng ký qua `functions.php:52-62`
- **Template Parts**: Component-based trong thư mục `template-parts/`
- **Force Recognition**: Custom template loader tại `functions.php:65-82`
- **Tái cấu trúc gần đây**: Template parts cho single post types (job_posting, promotion) đã được hợp nhất vào các single template file tương ứng để bảo trì đơn giản hóa

### Bản địa hóa Thương mại điện tử Tiếng Việt
Bản dịch tiếng Việt toàn diện được thực hiện qua WordPress filters trong `functions.php:267-416`, bao gồm:
- Labels và placeholders của trường checkout
- Text và messages UI WooCommerce
- Các phần review đơn hàng và text button
- Chính sách bảo mật và văn bản pháp lý

### Mở rộng REST API
Endpoint tìm kiếm tùy chỉnh `/wp-json/aratavietnam/v1/search` với hỗ trợ featured image được thực hiện tại `functions.php:438-530`.

## Quy trình Phát triển

### Bắt đầu Phát triển
1. **Môi trường**: `docker-compose up -d` → Chờ wp-cli logs hoàn thành
2. **Phát triển Theme**: `cd themes/aratavietnam && npm run dev` (HMR trên cổng 3000)
3. **Xây dựng Asset**: `npm run build` → Cập nhật hashed filenames trong functions.php:189-202
4. **Database**: Sử dụng WP CLI qua docker-compose exec wp-cli wp [command] --allow-root

### Nhiệm vụ Phát triển Phổ biến
- **Thêm Module Mới**: Tạo trong `/inc/`, thêm vào functions.php includes (dòng 8-42)
- **Page Template Mới**: Tạo trong `page-templates/`, đăng ký trong functions.php:52-62
- **Custom Post Type**: Theo mẫu: `*-post-types.php` + `*-meta-fields.php` + `*-meta.php`
- **Frontend JavaScript**: Thêm vào mảng input vite.config.mjs, sử dụng ES6 modules với dynamic imports
- **Nội dung Tiếng Việt**: Sử dụng các translation filters có sẵn trong functions.php:267-416

### Cải tiến Codebase Gần đây
- **Cải tiến Bảo mật**: Hỗ trợ upload SVG với validation bảo mật trong `upload-mimes.php`
- **Dọn dẹp Code**: Xóa bình luận tiếng Việt, dọn dẹp các câu lệnh console.log
- **Tối ưu hóa Asset**: Enqueuing script có phiên bản để quản lý cache tốt hơn
- **Hợp nhất Template**: Single post type templates (job_posting, promotion) được hợp nhất vào các single template file tương ứng để bảo trì đơn giản hóa
- **Cấu trúc Điều hướng**: Scripts menu được tổ chức để quản lý cấu trúc site tốt hơn
- **Cài đặt Hero Section**: Thêm tùy chỉnh hero section cho trang Giới thiệu khớp với cấu trúc trang Blog
- **Quản lý Asset**: Thêm module `asset-management.php` với các tiện ích phát hiện hash tự động để loại bỏ cập nhật thủ công sau các build

### Testing & Debugging
- **Query Monitor**: Có sẵn trong admin bar cho database queries và performance
- **Debug Bar**: Development debugging toolbar (được cài đặt bởi wp-cli-setup.sh)
- **WP CLI**: Sử dụng cho quản lý nội dung, thao tác database, và testing
- **Vite HMR**: Cập nhật CSS/JS tức thì trong quá trình phát triển qua localhost:3000
- **Vấn đề Asset**: Kiểm tra Vite manifest.json và căn chỉnh hashed filename functions.php
- **Error Logs**: Kiểm tra `/uploads/wc-logs/` cho các lỗi WooCommerce và fatal errors

### Quản lý Dự án
- **Thư mục Scripts**: 55+ utility scripts cho quản lý nội dung, cập nhật hình ảnh, thao tác database, và cập nhật SEO
- **Quản lý Nội dung**: Scripts tự động để tạo demo products, nội dung tin tức, và cấu trúc trang
- **Xử lý Hình ảnh**: Scripts cập nhật hình ảnh hàng loạt cho products, posts, promotions, và các phần homepage
- **Công cụ Database**: Scripts cho cập nhật SEO, sửa quyền, và cấu hình WordPress
- **Công cụ riêng cho Docker**: Scripts chuyên dụng để quản lý cập nhật hình ảnh và featured images trong môi trường Docker

### PHP Autoloading
- **PSR-4**: Namespace `AraVietnam\\` ánh xạ đến thư mục `src/` (composer.json)
- **TailPress Framework**: v5.0.4 được tải qua Composer với Jetpack autoloader
- **Manual Includes**: Tất cả chức năng được require rõ ràng trong functions.php:8-42

## Ghi chú Phát triển Quan trọng

### Sửa chữa Vị trí Theme
Theme thực tế nằm tại `themes/aratavietnam/` (không phải `themes/tailpress/` như được đề cập trong README.md). README chứa các tham chiếu đường dẫn đã lỗi thời.

### Cấu hình Cổng
- **Cổng Frontend Thực tế**: 8080 (docker-compose.yml)
- **Cổng README**: 8000 (sai)
- **Vite Dev Server**: 3000
- **Database**: 3306

### Quy trình Build Asset
Sau khi chạy `npm run build`, bạn PHẢI cập nhật các hashed filenames trong `functions.php:189-203`. Build tạo ra các hash mới mỗi lần, và assets sẽ không tải nếu không có bước cập nhật thủ công này.

### Phát triển Docker
Để biết hướng dẫn thiết lập Docker chi tiết, khắc phục sự cố, và cấu hình nâng cao, xem `docs/DOCKER-DEVELOPMENT.md`.