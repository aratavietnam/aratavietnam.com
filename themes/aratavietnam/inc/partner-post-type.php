<?php
/**
 * Register Partner Custom Post Type
 */

if (!defined('ABSPATH')) {
    exit;
}

function arata_register_partner_post_type() {
    $labels = array(
        'name'                  => _x('Đối tác', 'Post Type General Name', 'aratavietnam'),
        'singular_name'         => _x('Đối tác', 'Post Type Singular Name', 'aratavietnam'),
        'menu_name'             => __('Đối tác', 'aratavietnam'),
        'name_admin_bar'        => __('Đối tác', 'aratavietnam'),
        'archives'              => __('Lưu trữ Đối tác', 'aratavietnam'),
        'attributes'            => __('Thuộc tính Đối tác', 'aratavietnam'),
        'parent_item_colon'     => __('Đối tác cha:', 'aratavietnam'),
        'all_items'             => __('Tất cả Đối tác', 'aratavietnam'),
        'add_new_item'          => __('Thêm Đối tác mới', 'aratavietnam'),
        'add_new'               => __('Thêm mới', 'aratavietnam'),
        'new_item'              => __('Đối tác mới', 'aratavietnam'),
        'edit_item'             => __('Chỉnh sửa Đối tác', 'aratavietnam'),
        'update_item'           => __('Cập nhật Đối tác', 'aratavietnam'),
        'view_item'             => __('Xem Đối tác', 'aratavietnam'),
        'view_items'            => __('Xem các Đối tác', 'aratavietnam'),
        'search_items'          => __('Tìm kiếm Đối tác', 'aratavietnam'),
        'not_found'             => __('Không tìm thấy', 'aratavietnam'),
        'not_found_in_trash'    => __('Không tìm thấy trong thùng rác', 'aratavietnam'),
        'featured_image'        => __('Logo Đối tác', 'aratavietnam'),
        'set_featured_image'    => __('Đặt logo', 'aratavietnam'),
        'remove_featured_image' => __('Xóa logo', 'aratavietnam'),
        'use_featured_image'    => __('Sử dụng làm logo', 'aratavietnam'),
        'insert_into_item'      => __('Chèn vào Đối tác', 'aratavietnam'),
        'uploaded_to_this_item' => __('Tải lên cho Đối tác này', 'aratavietnam'),
        'items_list'            => __('Danh sách Đối tác', 'aratavietnam'),
        'items_list_navigation' => __('Điều hướng danh sách Đối tác', 'aratavietnam'),
        'filter_items_list'     => __('Lọc danh sách Đối tác', 'aratavietnam'),
    );
    $args = array(
        'label'                 => __('Đối tác', 'aratavietnam'),
        'description'           => __('Quản lý các đối tác và thương hiệu', 'aratavietnam'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'revisions', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'rewrite'               => false,
    );
    register_post_type('partner', $args);
}
add_action('init', 'arata_register_partner_post_type', 0);

