# Theme Functionality Files

Thư mục này chứa các file chức năng được tách ra từ `functions.php` để dễ quản lý và bảo trì.

## Cấu trúc Files

### `woocommerce.php`
**Chức năng**: Tất cả các tính năng liên quan đến WooCommerce
- AJAX cart handlers (get_cart_contents, remove_cart_item)
- WooCommerce theme support setup
- Custom WooCommerce wrapper
- Product display settings (columns, products per page)

### `fonts-vietnamese.php`
**Chức năng**: Tối ưu hóa font và hỗ trợ tiếng Việt
- Preload Google Fonts cho tiếng Việt
- Critical CSS cho font optimization
- Vietnamese language support
- Charset và meta tags cho tiếng Việt

### `favicon-pwa.php`
**Chức năng**: Favicon và PWA support
- Comprehensive favicon support (tất cả sizes)
- Apple Touch Icons
- Microsoft Tiles
- PWA meta tags và manifest

### `logo-branding.php`
**Chức năng**: Logo và branding
- Custom logo functions
- Default logo fallback
- Logo display helpers

### `customizer-footer.php`
**Chức năng**: Footer customizer settings
- Footer company information
- Social media links
- Customizer enhancements
- Live preview JavaScript

## Cách sử dụng

Tất cả các file này được tự động include trong `functions.php`:

```php
// Include theme functionality files
require_once get_template_directory() . '/inc/woocommerce.php';
require_once get_template_directory() . '/inc/fonts-vietnamese.php';
require_once get_template_directory() . '/inc/favicon-pwa.php';
require_once get_template_directory() . '/inc/logo-branding.php';
require_once get_template_directory() . '/inc/customizer-footer.php';
```

## Lợi ích của việc tách file

1. **Dễ bảo trì**: Mỗi file có chức năng riêng biệt
2. **Dễ debug**: Tìm lỗi nhanh hơn khi biết chức năng ở file nào
3. **Tái sử dụng**: Có thể dễ dàng copy chức năng sang theme khác
4. **Collaboration**: Nhiều developer có thể làm việc trên các file khác nhau
5. **Performance**: Có thể conditional load nếu cần

## Quy tắc khi thêm chức năng mới

1. **Tạo file mới** nếu chức năng không liên quan đến các file hiện có
2. **Thêm vào file phù hợp** nếu chức năng liên quan
3. **Luôn thêm security check** `if (!defined('ABSPATH')) { exit; }`
4. **Comment rõ ràng** về chức năng của từng function
5. **Include file mới** trong `functions.php`

## Ví dụ tạo file mới

```php
<?php
/**
 * SEO functionality for Arata Vietnam theme
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add SEO meta tags
 */
function aratavietnam_seo_meta_tags() {
    // SEO functionality here
}
add_action('wp_head', 'aratavietnam_seo_meta_tags');
```

Sau đó thêm vào `functions.php`:
```php
require_once get_template_directory() . '/inc/seo.php';
```
