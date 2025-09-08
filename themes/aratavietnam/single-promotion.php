<?php
/**
 * Single Promotion Template - New UI Design
 * Layout: Blog-style with system icons, consistent with archive-promotion.php
 */

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

if (have_posts()) : while (have_posts()) : the_post();

// Get promotion meta data
$discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
$code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
$start_date = get_post_meta(get_the_ID(), 'arata_promotion_start_date', true);
$end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
$type = get_post_meta(get_the_ID(), 'arata_promotion_type', true);
$terms = get_post_meta(get_the_ID(), 'arata_promotion_terms', true);

?>

<main id="site-content" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <!-- Hero Section -->
    <section class="py-16 text-center" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <div class="flex items-center justify-center text-sm text-gray-500 space-x-2">
                        <a href="<?php echo home_url(); ?>" class="hover:text-primary">Trang chủ</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="<?php echo home_url('/khuyen-mai'); ?>" class="hover:text-primary">Khuyến mãi</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php the_title(); ?></span>
                    </div>
                </nav>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>

                <!-- Meta Info -->
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Ngày đăng: <?php echo get_the_date('d/m/Y'); ?>
                    </div>
                    <?php if ($end_date): ?>
                        <div class="flex items-center text-red-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Hết hạn: <?php echo date('d/m/Y', strtotime($end_date)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Discount Badge -->
                <?php if ($discount): ?>
                    <div class="inline-flex items-center bg-red-500 text-white px-6 py-3 rounded-full text-lg font-bold shadow-lg mb-6">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"></path>
                        </svg>
                        Giảm <?php echo esc_html($discount); ?>%
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Side: Main Content (2/3) -->
                <div class="lg:col-span-2">
                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()): ?>
                        <div class="aspect-video overflow-hidden rounded-xl mb-8 shadow-sm">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Promotion Code Highlight -->
                    <?php if ($code): ?>
                        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl p-6 mb-8 border border-gray-200">
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Mã khuyến mãi</h3>
                                <div class="flex items-center justify-center space-x-4">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Sử dụng mã:
                                    </div>
                                    <code class="text-white px-6 py-3 rounded-lg font-mono text-xl font-bold shadow-lg" style="background-color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($code); ?></code>
                                    <button onclick="copyToClipboard('<?php echo esc_js($code); ?>')" class="text-gray-500 hover:text-primary transition-colors" title="Sao chép mã">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>

                    <!-- Terms and Conditions -->
                    <?php if ($terms): ?>
                        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Điều kiện áp dụng
                            </h3>
                            <p class="text-gray-600 leading-relaxed"><?php echo esc_html($terms); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Share Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Chia sẻ khuyến mãi</h3>
                        <div class="flex items-center space-x-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <button onclick="copyToClipboard('<?php echo esc_js(get_permalink()); ?>')" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Sao chép link
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Sidebar (1/3) -->
                <div class="lg:col-span-1">
                    <!-- Promotion Details Card -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Thông tin khuyến mãi
                        </h3>

                        <div class="space-y-4">
                            <?php if ($discount): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Mức giảm giá:</span>
                                    <span class="font-bold text-red-600"><?php echo esc_html($discount); ?>%</span>
                                </div>
                            <?php endif; ?>

                            <?php if ($start_date): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Ngày bắt đầu:</span>
                                    <span class="font-medium"><?php echo date('d/m/Y', strtotime($start_date)); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($end_date): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Ngày kết thúc:</span>
                                    <span class="font-medium text-red-600"><?php echo date('d/m/Y', strtotime($end_date)); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($type): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Loại khuyến mãi:</span>
                                    <span class="font-medium"><?php echo esc_html($type); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- CTA Button -->
                        <div class="mt-6">
                            <a href="<?php echo home_url('/san-pham'); ?>" class="inline-flex items-center justify-center w-full py-3 px-4 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Mua sắm ngay
                            </a>
                        </div>

                        <!-- Promotion Signup Form -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <button onclick="togglePromotionSignupForm()" class="inline-flex items-center justify-center w-full py-3 px-4 bg-secondary text-white rounded-lg hover:bg-secondary-dark transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Đăng ký nhận khuyến mãi
                            </button>

                            <div id="promotionSignupForm" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <h4 class="text-md font-bold text-gray-900 mb-3">Nhận thông báo khi có khuyến mãi mới</h4>
                                
                                <?php if (isset($_GET['promotion_signup'])): ?>
                                    <?php 
                                    $status = sanitize_text_field($_GET['promotion_signup']);
                                    if ($status === 'success'): ?>
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                                            <strong>Thành công!</strong> Bạn đã đăng ký nhận khuyến mãi.
                                        </div>
                                    <?php elseif ($status === 'exists'): ?>
                                        <div class="mb-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm">
                                            <strong>Thông báo:</strong> Email này đã đăng ký cho khuyến mãi này rồi.
                                        </div>
                                    <?php elseif ($status === 'error'): ?>
                                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                                            <strong>Lỗi:</strong> Vui lòng điền đầy đủ thông tin.
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-3">
                                    <input type="hidden" name="action" value="arata_promotion_signup_submit" />
                                    <input type="hidden" name="promotion_id" value="<?php echo get_the_ID(); ?>" />
                                    <input type="hidden" name="promotion_code" value="<?php echo esc_attr($code); ?>" />
                                    <?php wp_nonce_field('arata_promotion_signup_submit', 'arata_promotion_signup_nonce'); ?>

                                    <div>
                                        <input type="text" name="name" required 
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent"
                                               placeholder="Họ và tên của bạn" />
                                    </div>

                                    <div>
                                        <input type="email" name="email" required 
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent"
                                               placeholder="Nhập email của bạn" />
                                    </div>

                                    <div>
                                        <input type="tel" name="phone" 
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent"
                                               placeholder="Số điện thoại (tùy chọn)" />
                                    </div>

                                    <button type="submit" class="w-full bg-secondary text-white py-2 px-4 rounded-lg hover:bg-secondary-dark transition-colors font-medium text-sm">
                                        Đăng ký ngay
                                    </button>
                                </form>

                              </div>
                        </div>
                    </div>

                    <!-- Related Promotions -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                            <svg class="w-5 h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900">Khuyến mãi khác</h3>
                        </div>

                        <div class="space-y-4">
                            <?php
                            $related_promotions = new WP_Query([
                                'post_type' => 'promotion',
                                'posts_per_page' => 3,
                                'post_status' => 'publish',
                                'post__not_in' => [get_the_ID()],
                                'meta_query' => [
                                    'relation' => 'OR',
                                    [
                                        'key' => 'arata_promotion_end_date',
                                        'value' => date('Y-m-d'),
                                        'compare' => '>=',
                                        'type' => 'DATE'
                                    ],
                                    [
                                        'key' => 'arata_promotion_end_date',
                                        'compare' => 'NOT EXISTS'
                                    ]
                                ]
                            ]);

                            if ($related_promotions->have_posts()) :
                                while ($related_promotions->have_posts()) : $related_promotions->the_post();
                                    $related_discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
                                    ?>
                                    <div class="group">
                                        <a href="<?php the_permalink(); ?>" class="block hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200">
                                            <div class="flex items-start space-x-3">
                                                <?php if (has_post_thumbnail()): ?>
                                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                                        <?php the_title(); ?>
                                                    </h4>
                                                    <?php if ($related_discount): ?>
                                                        <div class="flex items-center text-xs text-red-600 font-bold mt-1">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Giảm <?php echo esc_html($related_discount); ?>%
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else:
                                ?>
                                <div class="text-center py-8">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Không có khuyến mãi khác</p>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>

                        <!-- View all promotions link -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="<?php echo home_url('/khuyen-mai'); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm w-full justify-center py-2 px-4 border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Xem tất cả khuyến mãi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Đã sao chép!';
        document.body.appendChild(toast);

        setTimeout(() => {
            document.body.removeChild(toast);
        }, 2000);
    });
}

function togglePromotionSignupForm() {
    const form = document.getElementById('promotionSignupForm');
    const button = event.target.closest('button');
    
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>Đóng form đăng ký';
    } else {
        form.classList.add('hidden');
        button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>Đăng ký nhận khuyến mãi';
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose h2 {
    font-size: 1.5em;
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 1em;
    color: #111827;
}

.prose h3 {
    font-size: 1.25em;
    font-weight: 600;
    margin-top: 1.6em;
    margin-bottom: 0.6em;
    color: #111827;
}

.prose p {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
}

.prose ul, .prose ol {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}

.prose li {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}
</style>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
