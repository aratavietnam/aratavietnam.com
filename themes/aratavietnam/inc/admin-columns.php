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
    // Tạo array mới với cột ảnh đại diện ở đầu
    $new_columns = array();

    // Thêm cột ảnh đại diện đầu tiên
    $new_columns['featured_image'] = '<span class="dashicons dashicons-format-image" title="Ảnh đại diện"></span>';

    // Thêm các cột còn lại
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
        $thumbnail = get_the_post_thumbnail($post_id, array(60, 60));

        if ($thumbnail) {
            echo $thumbnail;
        } else {
            echo '<span class="dashicons dashicons-format-image"></span>';
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

        .aratavietnam-admin-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 3px;
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
