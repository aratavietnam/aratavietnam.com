<?php
/**
 * Template Name: Account Page
 *
 * @package ArataVietnam
 */

get_header();

// Check if user is logged in
if (!is_user_logged_in()) {
    // Redirect to login page with return URL
    $login_url = wp_login_url(get_permalink());
    wp_safe_redirect($login_url);
    exit;
}

$user_id = get_current_user_id();
$user = get_userdata($user_id);

// Get user meta fields
$user_meta = array(
    'phone' => get_user_meta($user_id, 'arata_phone', true),
    'address' => get_user_meta($user_id, 'arata_address', true),
    'city' => get_user_meta($user_id, 'arata_city', true),
    'company' => get_user_meta($user_id, 'arata_company', true),
    'position' => get_user_meta($user_id, 'arata_position', true),
    'bio' => get_user_meta($user_id, 'arata_bio', true),
    'birth_date' => get_user_meta($user_id, 'arata_birth_date', true),
    'gender' => get_user_meta($user_id, 'arata_gender', true),
    'interests' => get_user_meta($user_id, 'arata_interests', true),
    'website' => get_user_meta($user_id, 'arata_website', true),
    'facebook' => get_user_meta($user_id, 'arata_facebook', true),
    'linkedin' => get_user_meta($user_id, 'arata_linkedin', true),
    'member_since' => get_user_meta($user_id, 'arata_member_since', true),
    'last_login' => get_user_meta($user_id, 'arata_last_login', true),
);

// Get page hero settings
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_hero_subtitle', true) ?: __('Thông tin tài khoản', 'aratavietnam');
$hero_intro = get_post_meta(get_the_ID(), 'arata_hero_intro', true) ?: __('Quản lý thông tin cá nhân và cài đặt tài khoản', 'aratavietnam');
$compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true);
?>

<div class="account-page">
    <?php if (!$compact_hero) : ?>
    <section class="page-hero bg-gradient-to-r from-primary to-secondary text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4"><?php the_title(); ?></h1>
                <?php if ($hero_subtitle) : ?>
                    <p class="text-xl md:text-2xl mb-4 opacity-90"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
                <?php if ($hero_intro) : ?>
                    <p class="text-lg max-w-2xl mx-auto opacity-80"><?php echo esc_html($hero_intro); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php else : ?>
    <section class="page-hero-compact bg-gradient-to-r from-primary to-secondary text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center"><?php the_title(); ?></h1>
        </div>
    </section>
    <?php endif; ?>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Account Navigation Tabs -->
                <div class="bg-white rounded-lg shadow-md mb-6">
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button class="account-tab-btn active px-6 py-4 text-primary border-b-2 border-primary font-medium" data-tab="profile">
                                <i data-lucide="user" class="w-5 h-5 inline mr-2"></i>
                                <?php _e('Hồ sơ cá nhân', 'aratavietnam'); ?>
                            </button>
                            <button class="account-tab-btn px-6 py-4 text-gray-600 hover:text-primary font-medium" data-tab="security">
                                <i data-lucide="shield" class="w-5 h-5 inline mr-2"></i>
                                <?php _e('Bảo mật', 'aratavietnam'); ?>
                            </button>
                            <button class="account-tab-btn px-6 py-4 text-gray-600 hover:text-primary font-medium" data-tab="notifications">
                                <i data-lucide="bell" class="w-5 h-5 inline mr-2"></i>
                                <?php _e('Thông báo', 'aratavietnam'); ?>
                            </button>
                        </nav>
                    </div>

                    <!-- Profile Tab Content -->
                    <div id="profile-tab" class="account-tab-content p-6">
                        <form id="account-profile-form" class="space-y-6">
                            <!-- Avatar Section -->
                            <div class="flex items-center space-x-6 pb-6 border-b border-gray-200">
                                <div class="relative">
                                    <?php echo get_avatar($user_id, 96, '', 'User Avatar', array('class' => 'w-24 h-24 rounded-full')); ?>
                                    <button type="button" class="absolute bottom-0 right-0 bg-primary text-white rounded-full p-2 hover:bg-primary-dark transition-colors">
                                        <i data-lucide="camera" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold"><?php echo esc_html($user->display_name); ?></h3>
                                    <p class="text-gray-600"><?php echo esc_html($user->user_email); ?></p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <?php 
                                        if ($user_meta['member_since']) {
                                            printf(__('Thành viên từ: %s', 'aratavietnam'), date_i18n(get_option('date_format'), strtotime($user_meta['member_since'])));
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Họ', 'aratavietnam'); ?> *</label>
                                    <input type="text" name="first_name" value="<?php echo esc_attr($user->first_name); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Tên', 'aratavietnam'); ?> *</label>
                                    <input type="text" name="last_name" value="<?php echo esc_attr($user->last_name); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Email', 'aratavietnam'); ?> *</label>
                                    <input type="email" name="email" value="<?php echo esc_attr($user->user_email); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Số điện thoại', 'aratavietnam'); ?></label>
                                    <input type="tel" name="phone" value="<?php echo esc_attr($user_meta['phone']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Địa chỉ', 'aratavietnam'); ?></label>
                                    <textarea name="address" rows="3" 
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"><?php echo esc_textarea($user_meta['address']); ?></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Thành phố', 'aratavietnam'); ?></label>
                                    <input type="text" name="city" value="<?php echo esc_attr($user_meta['city']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Ngày sinh', 'aratavietnam'); ?></label>
                                    <input type="date" name="birth_date" value="<?php echo esc_attr($user_meta['birth_date']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Giới tính', 'aratavietnam'); ?></label>
                                    <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value=""><?php _e('-- Chọn --', 'aratavietnam'); ?></option>
                                        <option value="male" <?php selected($user_meta['gender'], 'male'); ?>><?php _e('Nam', 'aratavietnam'); ?></option>
                                        <option value="female" <?php selected($user_meta['gender'], 'female'); ?>><?php _e('Nữ', 'aratavietnam'); ?></option>
                                        <option value="other" <?php selected($user_meta['gender'], 'other'); ?>><?php _e('Khác', 'aratavietnam'); ?></option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Công ty', 'aratavietnam'); ?></label>
                                    <input type="text" name="company" value="<?php echo esc_attr($user_meta['company']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Chức vụ', 'aratavietnam'); ?></label>
                                    <input type="text" name="position" value="<?php echo esc_attr($user_meta['position']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Giới thiệu bản thân', 'aratavietnam'); ?></label>
                                    <textarea name="bio" rows="4" 
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                              placeholder="<?php _e('Viết vài dòng về bản thân bạn...', 'aratavietnam'); ?>"><?php echo esc_textarea($user_meta['bio']); ?></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Website', 'aratavietnam'); ?></label>
                                    <input type="url" name="website" value="<?php echo esc_attr($user_meta['website']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="https://">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Sở thích', 'aratavietnam'); ?></label>
                                    <input type="text" name="interests" value="<?php echo esc_attr($user_meta['interests']); ?>" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="<?php _e('Ví dụ: Đọc sách, Du lịch, Nhiếp ảnh', 'aratavietnam'); ?>">
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-semibold mb-4"><?php _e('Mạng xã hội', 'aratavietnam'); ?></h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i data-lucide="facebook" class="w-4 h-4 inline mr-1"></i>
                                            <?php _e('Facebook', 'aratavietnam'); ?>
                                        </label>
                                        <input type="url" name="facebook" value="<?php echo esc_attr($user_meta['facebook']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="https://facebook.com/">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i data-lucide="linkedin" class="w-4 h-4 inline mr-1"></i>
                                            <?php _e('LinkedIn', 'aratavietnam'); ?>
                                        </label>
                                        <input type="url" name="linkedin" value="<?php echo esc_attr($user_meta['linkedin']); ?>" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               placeholder="https://linkedin.com/in/">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 pt-6">
                                <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    <?php _e('Hủy', 'aratavietnam'); ?>
                                </button>
                                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                    <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                    <?php _e('Lưu thay đổi', 'aratavietnam'); ?>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab Content -->
                    <div id="security-tab" class="account-tab-content p-6 hidden">
                        <form id="account-security-form" class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-4"><?php _e('Đổi mật khẩu', 'aratavietnam'); ?></h3>
                                <div class="space-y-4 max-w-md">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Mật khẩu hiện tại', 'aratavietnam'); ?></label>
                                        <input type="password" name="current_password" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Mật khẩu mới', 'aratavietnam'); ?></label>
                                        <input type="password" name="new_password" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               minlength="8" required>
                                        <p class="text-sm text-gray-500 mt-1"><?php _e('Tối thiểu 8 ký tự', 'aratavietnam'); ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php _e('Xác nhận mật khẩu mới', 'aratavietnam'); ?></label>
                                        <input type="password" name="confirm_password" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                               minlength="8" required>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-semibold mb-4"><?php _e('Two-Factor Authentication', 'aratavietnam'); ?></h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-600 mb-4"><?php _e('Thêm lớp bảo mật bổ sung cho tài khoản của bạn', 'aratavietnam'); ?></p>
                                    <button type="button" class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary-dark transition-colors">
                                        <?php _e('Kích hoạt 2FA', 'aratavietnam'); ?>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 pt-6">
                                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                    <i data-lucide="shield-check" class="w-4 h-4 inline mr-2"></i>
                                    <?php _e('Cập nhật bảo mật', 'aratavietnam'); ?>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Notifications Tab Content -->
                    <div id="notifications-tab" class="account-tab-content p-6 hidden">
                        <form id="account-notifications-form" class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-4"><?php _e('Cài đặt thông báo', 'aratavietnam'); ?></h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <h4 class="font-medium"><?php _e('Thông báo email', 'aratavietnam'); ?></h4>
                                            <p class="text-sm text-gray-600"><?php _e('Nhận thông báo quan trọng qua email', 'aratavietnam'); ?></p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="email_notifications" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <h4 class="font-medium"><?php _e('Thông báo tin tức', 'aratavietnam'); ?></h4>
                                            <p class="text-sm text-gray-600"><?php _e('Nhận thông báo về bài viết mới', 'aratavietnam'); ?></p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="news_notifications" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <h4 class="font-medium"><?php _e('Thông báo khuyến mãi', 'aratavietnam'); ?></h4>
                                            <p class="text-sm text-gray-600"><?php _e('Nhận thông báo về chương trình khuyến mãi', 'aratavietnam'); ?></p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="promo_notifications" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 pt-6">
                                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                    <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                                    <?php _e('Lưu cài đặt', 'aratavietnam'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Activity Summary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4"><?php _e('Hoạt động gần đây', 'aratavietnam'); ?></h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-600"><?php _e('Đăng nhập gần nhất', 'aratavietnam'); ?></span>
                            <span class="text-sm text-gray-500">
                                <?php 
                                if ($user_meta['last_login']) {
                                    echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($user_meta['last_login']));
                                } else {
                                    _e('Chưa có dữ liệu', 'aratavietnam');
                                }
                                ?>
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-600"><?php _e('Số bài viết đã xem', 'aratavietnam'); ?></span>
                            <span class="text-sm text-gray-500"><?php echo get_user_meta($user_id, 'arata_posts_viewed', true) ?: 0; ?></span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-600"><?php _e('Sản phẩm đã yêu thích', 'aratavietnam'); ?></span>
                            <span class="text-sm text-gray-500"><?php echo get_user_meta($user_id, 'arata_favorites_count', true) ?: 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4"><?php _e('Thao tác nhanh', 'aratavietnam'); ?></h3>
                    <div class="space-y-3">
                        <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-lucide="shopping-bag" class="w-5 h-5 mr-3"></i>
                            <?php _e('Đơn hàng của tôi', 'aratavietnam'); ?>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-lucide="heart" class="w-5 h-5 mr-3"></i>
                            <?php _e('Sản phẩm yêu thích', 'aratavietnam'); ?>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-lucide="download" class="w-5 h-5 mr-3"></i>
                            <?php _e('Tải xuống', 'aratavietnam'); ?>
                        </a>
                    </div>
                </div>

                <!-- Account Stats -->
                <div class="bg-gradient-to-br from-primary to-secondary text-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4"><?php _e('Thống kê tài khoản', 'aratavietnam'); ?></h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold"><?php echo get_user_meta($user_id, 'arata_orders_count', true) ?: 0; ?></div>
                            <div class="text-sm opacity-90"><?php _e('Đơn hàng', 'aratavietnam'); ?></div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold"><?php echo get_user_meta($user_id, 'arata_reviews_count', true) ?: 0; ?></div>
                            <div class="text-sm opacity-90"><?php _e('Đánh giá', 'aratavietnam'); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4"><?php _e('Hỗ trợ', 'aratavietnam'); ?></h3>
                    <div class="space-y-3">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('lien-he'))); ?>" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-lucide="help-circle" class="w-5 h-5 mr-3"></i>
                            <?php _e('Trung tâm hỗ trợ', 'aratavietnam'); ?>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            <i data-lucide="message-circle" class="w-5 h-5 mr-3"></i>
                            <?php _e('Liên hệ với chúng tôi', 'aratavietnam'); ?>
                        </a>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-red-200">
                    <h3 class="text-lg font-semibold mb-4 text-red-600"><?php _e('Vùng nguy hiểm', 'aratavietnam'); ?></h3>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-between px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <span class="flex items-center">
                                <i data-lucide="download" class="w-5 h-5 mr-3"></i>
                                <?php _e('Tải dữ liệu của tôi', 'aratavietnam'); ?>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                        <button class="w-full flex items-center justify-between px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <span class="flex items-center">
                                <i data-lucide="user-x" class="w-5 h-5 mr-3"></i>
                                <?php _e('Vô hiệu hóa tài khoản', 'aratavietnam'); ?>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                        <button class="w-full flex items-center justify-between px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <span class="flex items-center">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i>
                                <?php _e('Xóa tài khoản', 'aratavietnam'); ?>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages Container -->
<div id="account-messages" class="fixed top-4 right-4 z-50 space-y-2"></div>

<?php
get_footer();