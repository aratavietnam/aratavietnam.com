<?php
/**
 * Admin Columns - Featured Image Display
 * Thêm cột ảnh đại diện vào bảng danh sách bài viết trong WordPress admin
 */

// Thêm cột ảnh đại diện cho Posts
add_action('admin_init', 'aratavietnam_add_featured_image_column_to_post_types');

function aratavietnam_add_featured_image_column_to_post_types() {
    $post_types = get_post_types(['public' => true], 'names');
    foreach ($post_types as $post_type) {
        add_filter("manage_{$post_type}_posts_columns", 'aratavietnam_add_featured_image_column');
        add_action("manage_{$post_type}_posts_custom_column", 'aratavietnam_display_featured_image_column', 10, 2);
        add_filter("manage_edit-{$post_type}_sortable_columns", 'aratavietnam_make_featured_image_sortable');
    }
}

/**
 * Thêm cột ảnh đại diện vào đầu bảng
 */
function aratavietnam_add_featured_image_column($columns) {
    // Add featured image column for Posts
    $new_columns = array();

    // Add featured image column first
    $new_columns['featured_image'] = 'Ảnh đại diện';

    // Add remaining columns
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
    }

    return $new_columns;
}

/**
 * Hiển thị nội dung cột ảnh đại diện
 */
function aratavietnam_display_featured_image_column($column, $post_id) {
    if ($column === 'featured_image') {
        $thumbnail_id = get_post_thumbnail_id($post_id);

        if ($thumbnail_id) {
            $attachment_url = wp_get_attachment_url($thumbnail_id);
            $attachment_mime = get_post_mime_type($thumbnail_id);

            // Check if it's an SVG file
            if ($attachment_mime === 'image/svg+xml') {
                echo '<div class="aratavietnam-admin-thumbnail">';
                echo '<img src="' . esc_url($attachment_url) . '" alt="' . esc_attr(get_the_title($post_id)) . '" style="width: 60px; height: 60px; object-fit: contain;">';
                echo '</div>';
            } else {
                // For regular images (PNG, JPEG, etc.), use the standard thumbnail
                $thumbnail = get_the_post_thumbnail($post_id, array(60, 60), array('class' => 'aratavietnam-admin-thumbnail-img'));
                echo '<div class="aratavietnam-admin-thumbnail">' . $thumbnail . '</div>';
            }
        } else {
            echo '<div class="aratavietnam-admin-thumbnail aratavietnam-no-image">';
            echo '<span class="dashicons dashicons-format-image"></span>';
            echo '</div>';
        }
    }
}

/**
 * Thêm CSS cho cột ảnh đại diện
 */
add_action('admin_head', 'aratavietnam_admin_columns_css');
function aratavietnam_admin_columns_css() {
    echo '<style>
        .aratavietnam-admin-thumbnail {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            background: #f9f9f9;
        }

        .aratavietnam-admin-thumbnail img,
        .aratavietnam-admin-thumbnail-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 3px;
        }

        /* Special handling for SVG images */
        .aratavietnam-admin-thumbnail img[src$=".svg"] {
            object-fit: contain;
            background: white;
        }

        .aratavietnam-no-image {
            background: #f0f0f0;
            color: #999;
        }

        .aratavietnam-no-image .dashicons {
            font-size: 24px;
        }

        /* Điều chỉnh độ rộng cột */
        .column-featured_image {
            width: 80px;
            text-align: center;
        }

        /* Responsive cho mobile */
        @media screen and (max-width: 782px) {
            .aratavietnam-admin-thumbnail {
                width: 40px;
                height: 40px;
            }

            .column-featured_image {
                width: 60px;
            }

            .aratavietnam-no-image .dashicons {
                font-size: 16px;
            }
        }
    </style>';
}

/**
 * Làm cho cột ảnh đại diện có thể sắp xếp (sortable)
 */


function aratavietnam_make_featured_image_sortable($columns) {
    $columns['featured_image'] = '_thumbnail_id';
    return $columns;
}

/**
 * Xử lý sắp xếp theo ảnh đại diện
 */
add_action('pre_get_posts', 'aratavietnam_featured_image_orderby');
function aratavietnam_featured_image_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ('_thumbnail_id' === $query->get('orderby')) {
        $query->set('meta_key', '_thumbnail_id');
        $query->set('orderby', 'meta_value_num');
    }
}

/**
 * Thêm quick edit cho ảnh đại diện (tùy chọn)
 */
