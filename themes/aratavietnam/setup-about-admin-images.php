<?php
/**
 * Script to add About section images via WordPress admin
 */

// Include WordPress
require_once('wp-config.php');

echo "=== Thiết lập hình ảnh cho phần About ===\n\n";

// Front page ID
$front_page_id = get_option('page_on_front');
echo "Front Page ID: $front_page_id\n";

if (!$front_page_id) {
    echo "Lỗi: Chưa có trang chủ được thiết lập.\n";
    exit(1);
}

// URLs of images to import (bạn có thể thay thế bằng URLs của bạn)
$image_urls = array(
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&h=600&fit=crop',
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&h=600&fit=crop',
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&h=600&fit=crop'
);

echo "1. Đang thiết lập hình ảnh chính cho About...\n";

// Tải và import hình ảnh chính
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Download and import main image
$tmp = download_url($image_urls[0]);
$file_array = array(
    'name' => 'arata-about-main.jpg',
    'tmp_name' => $tmp
);

if (is_wp_error($tmp)) {
    echo "Lỗi tải hình ảnh: " . $tmp->get_error_message() . "\n";
} else {
    $attachment_id = media_handle_sideload($file_array, $front_page_id);
    
    if (is_wp_error($attachment_id)) {
        echo "Lỗi import hình ảnh: " . $attachment_id->get_error_message() . "\n";
    } else {
        // Set as main about image
        update_post_meta($front_page_id, 'arata_about_image', $attachment_id);
        echo "✓ Hình ảnh chính đã được thiết lập (ID: $attachment_id)\n";
        
        // Import additional images
        echo "\n2. Đang thiết lập các hình ảnh bổ sung...\n";
        $additional_images = array();
        
        for ($i = 1; $i < count($image_urls); $i++) {
            $tmp2 = download_url($image_urls[$i]);
            $file_array2 = array(
                'name' => 'arata-about-' . ($i + 1) . '.jpg',
                'tmp_name' => $tmp2
            );
            
            if (!is_wp_error($tmp2)) {
                $att_id = media_handle_sideload($file_array2, $front_page_id);
                if (!is_wp_error($att_id)) {
                    $additional_images[] = array('image_id' => $att_id);
                    echo "✓ Hình ảnh bổ hợp " . ($i + 1) . " đã được import (ID: $att_id)\n";
                }
                @unlink($tmp2);
            }
        }
        
        // Save additional images
        if (!empty($additional_images)) {
            update_post_meta($front_page_id, '_about_images', $additional_images);
            echo "\n✓ " . count($additional_images) . " hình ảnh bổ hợp đã được lưu\n";
        }
        
        // Ensure About section is enabled
        update_post_meta($front_page_id, 'arata_about_show', '1');
        echo "\n✓ Phần About đã được bật hiển thị\n";
    }
    
    @unlink($tmp);
}

echo "\n=== Hoàn tất ===\n";
echo "Vui lòng kiểm tra trang chủ để xem kết quả.\n";
echo "Để chỉnh sửa: Vào WordPress Admin → Pages → Front Page → Homepage Settings\n";
?>