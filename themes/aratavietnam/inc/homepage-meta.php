<?php

/**
 * Homepage meta box configuration - Following About page patterns
 * 
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register homepage meta fields
 */
function aratavietnam_homepage_meta_fields() {
    $prefix = 'arata_';
    
    $cmb = new_cmb2_box(array(
        'id'            => 'homepage_meta',
        'title'         => __('Homepage Settings', 'aratavietnam'),
        'object_types'  => array('page'),
        'show_on'       => array('key' => 'page-template', 'value' => 'page-templates/homepage.php'),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
    ));
    
    // Hero Section Settings
    $cmb->add_field(array(
        'name' => __('Hiển thị Hero Section', 'aratavietnam'),
        'desc' => __('Bật/tắt hiển thị hero section', 'aratavietnam'),
        'id'   => $prefix . 'hero_show',
        'type' => 'select',
        'options' => array(
            '1' => __('Hiển thị', 'aratavietnam'),
            '0' => __('Ẩn', 'aratavietnam'),
        ),
        'default' => '1',
    ));
    
    // Marquee Section
    $cmb->add_field(array(
        'name' => __('Hiển thị Marquee Section', 'aratavietnam'),
        'desc' => __('Bật/tắt hiển thị marquee section', 'aratavietnam'),
        'id'   => $prefix . 'marquee_show',
        'type' => 'select',
        'options' => array(
            '1' => __('Hiển thị', 'aratavietnam'),
            '0' => __('Ẩn', 'aratavietnam'),
        ),
        'default' => '1',
    ));
    
    $cmb->add_field(array(
        'name' => __('Marquee Text', 'aratavietnam'),
        'desc' => __('Văn bản chạy marquee section', 'aratavietnam'),
        'id'   => '_marquee_text',
        'type' => 'text',
        'default' => 'ARATA - NHÀ PHÂN PHỐI HÓA MỸ PHẨM HÀNG ĐẦU NHẬT BẢN',
    ));
    
    // Hero Slides
    $group_field_id = $cmb->add_field(array(
        'id'          => $prefix . 'hero_slides',
        'type'        => 'group',
        'description' => __('Hero Slides Configuration', 'aratavietnam'),
        'options'     => array(
            'group_title'   => __('Slide {#}', 'aratavietnam'),
            'add_button'    => __('Add Slide', 'aratavietnam'),
            'remove_button' => __('Remove Slide', 'aratavietnam'),
            'sortable'      => true,
        ),
    ));
    
    $cmb->add_group_field($group_field_id, array(
        'name' => __('Loại slide', 'aratavietnam'),
        'desc' => __('Chọn loại hình ảnh hoặc video', 'aratavietnam'),
        'id'   => 'slide_type',
        'type' => 'select',
        'options' => array(
            'image' => __('Hình ảnh', 'aratavietnam'),
            'video' => __('Video', 'aratavietnam'),
        ),
        'default' => 'image',
    ));
    
    $cmb->add_group_field($group_field_id, array(
        'name' => __('Hình ảnh', 'aratavietnam'),
        'desc' => __('Chọn hình ảnh cho slide', 'aratavietnam'),
        'id'   => 'slide_image',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text'    => array(
            'add_upload_file_text' => __('Add Image', 'aratavietnam'),
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'medium',
    ));
    
    $cmb->add_group_field($group_field_id, array(
        'name' => __('Video URL', 'aratavietnam'),
        'desc' => __('URL video MP4', 'aratavietnam'),
        'id'   => 'slide_video',
        'type' => 'text_url',
    ));
    
    $cmb->add_group_field($group_field_id, array(
        'name' => __('Hình ảnh Mobile', 'aratavietnam'),
        'desc' => __('Chọn hình ảnh cho mobile (không bắt buộc)', 'aratavietnam'),
        'id'   => 'slide_mobile_image',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text'    => array(
            'add_upload_file_text' => __('Add Mobile Image', 'aratavietnam'),
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'medium',
    ));
    
    $cmb->add_group_field($group_field_id, array(
        'name' => __('Video URL Mobile', 'aratavietnam'),
        'desc' => __('URL video MP4 cho mobile (không bắt buộc)', 'aratavietnam'),
        'id'   => 'slide_mobile_video',
        'type' => 'text_url',
    ));
    
    // All Products Section
    $cmb->add_field(array(
        'name' => __('Hiển thị All Products', 'aratavietnam'),
        'desc' => __('Bật/tắt hiển thị section all products', 'aratavietnam'),
        'id'   => $prefix . 'all_products_show',
        'type' => 'select',
        'options' => array(
            '1' => __('Hiển thị', 'aratavietnam'),
            '0' => __('Ẩn', 'aratavietnam'),
        ),
        'default' => '1',
    ));
    
    $cmb->add_field(array(
        'name' => __('All Products Title', 'aratavietnam'),
        'desc' => __('Tiêu đề section all products', 'aratavietnam'),
        'id'   => $prefix . 'all_products_title',
        'type' => 'text',
        'default' => 'Tất Cả Sản Phẩm',
    ));
    
    // Featured Products Section
    $cmb->add_field(array(
        'name' => __('Hiển thị Featured Products', 'aratavietnam'),
        'desc' => __('Bật/tắt hiển thị section featured products', 'aratavietnam'),
        'id'   => $prefix . 'featured_show',
        'type' => 'select',
        'options' => array(
            '1' => __('Hiển thị', 'aratavietnam'),
            '0' => __('Ẩn', 'aratavietnam'),
        ),
        'default' => '1',
    ));
    
    $cmb->add_field(array(
        'name' => __('Featured Products Title', 'aratavietnam'),
        'desc' => __('Tiêu đề section featured products', 'aratavietnam'),
        'id'   => $prefix . 'featured_title',
        'type' => 'text',
        'default' => 'Sản Phẩm Nổi Bật',
    ));
    
    // About Section
    $cmb->add_field(array(
        'name' => __('Hiển thị About Section', 'aratavietnam'),
        'desc' => __('Bật/tắt hiển thị section about', 'aratavietnam'),
        'id'   => $prefix . 'about_show',
        'type' => 'select',
        'options' => array(
            '1' => __('Hiển thị', 'aratavietnam'),
            '0' => __('Ẩn', 'aratavietnam'),
        ),
        'default' => '1',
    ));
    
    $cmb->add_field(array(
        'name' => __('About Title', 'aratavietnam'),
        'desc' => __('Tiêu đề section about', 'aratavietnam'),
        'id'   => $prefix . 'about_title',
        'type' => 'text',
        'default' => 'Về Arata Vietnam',
    ));
    
    $cmb->add_field(array(
        'name' => __('About Description', 'aratavietnam'),
        'desc' => __('Mô tả ngắn về section about', 'aratavietnam'),
        'id'   => $prefix . 'about_description',
        'type' => 'textarea',
    ));
    
    $cmb->add_field(array(
        'name' => __('About Image', 'aratavietnam'),
        'desc' => __('Hình ảnh chính section about', 'aratavietnam'),
        'id'   => $prefix . 'about_image',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text'    => array(
            'add_upload_file_text' => __('Add Image', 'aratavietnam'),
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'medium',
    ));
    
    // Additional About Images Gallery
    $about_images_group = $cmb->add_field(array(
        'id'          => '_about_images',
        'type'        => 'group',
        'description' => __('Thêm các hình ảnh khác cho section About (tùy chọn)', 'aratavietnam'),
        'options'     => array(
            'group_title'   => __('Hình ảnh {#}', 'aratavietnam'),
            'add_button'    => __('Add Image', 'aratavietnam'),
            'remove_button' => __('Remove Image', 'aratavietnam'),
            'sortable'      => true,
        ),
    ));
    
    $cmb->add_group_field($about_images_group, array(
        'name' => __('Hình ảnh', 'aratavietnam'),
        'desc' => __('Chọn hình ảnh thêm', 'aratavietnam'),
        'id'   => 'image_id',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text'    => array(
            'add_upload_file_text' => __('Add Image', 'aratavietnam'),
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'medium',
    ));
    
    // Partners Section
    $cmb->add_field(array(
        'name' => __('Hiển thị Partners Section', 'aratavietnam'),
        'desc' => __('Bật/tắt hiển thị section partners', 'aratavietnam'),
        'id'   => $prefix . 'partners_show',
        'type' => 'select',
        'options' => array(
            '1' => __('Hiển thị', 'aratavietnam'),
            '0' => __('Ẩn', 'aratavietnam'),
        ),
        'default' => '1',
    ));
    
    $cmb->add_field(array(
        'name' => __('Partners Title', 'aratavietnam'),
        'desc' => __('Tiêu đề section partners', 'aratavietnam'),
        'id'   => $prefix . 'partners_title',
        'type' => 'text',
        'default' => 'Đối Tác',
    ));
    
    $cmb->add_field(array(
        'name' => __('Partners Description', 'aratavietnam'),
        'desc' => __('Mô tả section partners', 'aratavietnam'),
        'id'   => '_partners_description',
        'type' => 'textarea',
        'default' => 'Chúng tôi tự hào hợp tác với các thương hiệu hóa mỹ phẩm hàng đầu từ Nhật Bản',
    ));
}
add_action('cmb2_admin_init', 'aratavietnam_homepage_meta_fields');