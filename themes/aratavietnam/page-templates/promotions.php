<?php
/**
 * Template Name: Promotions Page
 * Template Post Type: page
 * Description: Promotions page with newsletter signup form
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get global colors
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Hero configuration
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) !== '0'; // Default to true if not set
$use_compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true) === '1';
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_promotions_subtitle', true) ?: 'Ưu đãi đặc biệt từ Arata Vietnam';
$hero_intro = get_post_meta(get_the_ID(), 'arata_promotions_intro', true) ?: 'Khám phá các chương trình khuyến mãi hấp dẫn và ưu đãi độc quyền từ Arata Vietnam.';

// Set hero variables if using full hero
if ($show_hero && !$use_compact_hero) {
    set_query_var('title', get_the_title());
    set_query_var('subtitle', $hero_subtitle);
}

if ($show_hero) {
    if ($use_compact_hero) {
        // Use compact hero inline
        ?>
        <main id="site-content" class="min-h-[30vh] flex items-center" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <div class="container mx-auto px-4 py-16 text-center">
                <div class="max-w-2xl mx-auto">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4"><?php echo esc_html($hero_subtitle); ?></h2>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo esc_html($hero_intro); ?>
                    </p>
                </div>
            </div>

            <!-- Promotions Content Section -->
            <div class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>;">
                <div class="container mx-auto px-4">
        <?php
    } else {
        // Use full hero template part
        get_template_part('template-parts/hero');
        ?>
        <main id="site-content" class="bg-white">
            <!-- Promotions Content Section -->
            <div class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>;">
                <div class="container mx-auto px-4">
        <?php
    }
} else {
    ?>
    <main id="site-content" class="bg-white">
        <!-- Promotions Content Section -->
        <div class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <div class="container mx-auto px-4">
    <?php
}
?>
                <!-- Page Content -->
                <article id="post-<?php the_ID(); ?>" <?php post_class('prose max-w-none mb-12'); ?>>
                    <div class="entry-content">
                        <?php
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                        ?>
                    </div>
                </article>
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-1 rounded-full mr-4" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                        <span class="font-medium text-sm uppercase tracking-wider" style="color: <?php echo esc_attr($primary_color); ?>;">Khuyến mãi đặc biệt</span>
                        <div class="w-12 h-1 rounded-full ml-4" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Chương trình khuyến mãi</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Promotions List -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Ưu đãi hiện tại</h3>
                    <div class="space-y-6">
                        <?php
                        $promotions = new WP_Query([
                            'post_type' => 'promotion',
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
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

                        if ($promotions->have_posts()) :
                            while ($promotions->have_posts()) : $promotions->the_post();
                                $discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
                                $code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
                                $start_date = get_post_meta(get_the_ID(), 'arata_promotion_start_date', true);
                                $end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
                                $type = get_post_meta(get_the_ID(), 'arata_promotion_type', true);
                                ?>
                                <div class="bg-white rounded-lg p-6 border border-gray-200 transition-colors duration-300" style="border-color: #E5E7EB;" onmouseover="this.style.borderColor='<?php echo esc_attr($primary_color); ?>'" onmouseout="this.style.borderColor='#E5E7EB'">
                                    <div class="flex items-start justify-between mb-4">
                                        <h4 class="text-xl font-semibold text-gray-900 flex-1">
                                            <a href="<?php the_permalink(); ?>" class="transition-colors" style="color: inherit;" onmouseover="this.style.color='<?php echo esc_attr($primary_color); ?>'" onmouseout="this.style.color='inherit'">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <?php if ($discount): ?>
                                            <span class="text-white px-4 py-2 rounded-full text-sm font-bold ml-4" style="background-color: <?php echo esc_attr($primary_color); ?>;">
                                                <?php echo esc_html($discount); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($code): ?>
                                        <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-300">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">Mã khuyến mãi:</span>
                                                <code class="text-white px-3 py-1 rounded font-mono text-sm font-bold" style="background-color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($code); ?></code>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="prose prose-sm max-w-none mb-4">
                                        <?php echo wp_trim_words(get_the_content(), 30); ?>
                                    </div>

                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center space-x-4">
                                            <?php if ($start_date): ?>
                                                <span class="text-green-600 font-medium">
                                                    <span data-icon="play-circle" data-size="16" class="mr-1"></span>
                                                    Từ <?php echo date('d/m/Y', strtotime($start_date)); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($end_date): ?>
                                                <span class="text-red-600 font-medium">
                                                    <span data-icon="clock" data-size="16" class="mr-1"></span>
                                                    Đến <?php echo date('d/m/Y', strtotime($end_date)); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="font-medium transition-colors" style="color: <?php echo esc_attr($primary_color); ?>;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                            Xem chi tiết →
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            ?>
                            <div class="text-center py-12">
                                <div class="text-gray-400 mb-4">
                                    <span data-icon="gift" data-size="48"></span>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Hiện tại chưa có chương trình khuyến mãi</h3>
                                <p class="text-gray-600">Hãy đăng ký nhận thông báo để không bỏ lỡ các ưu đãi đặc biệt từ Arata Vietnam.</p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Newsletter Signup Form -->
                <div>
                    <div class="bg-gradient-to-br from-primary/5 via-white to-secondary/5 rounded-lg p-8 border border-gray-200">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: <?php echo esc_attr($primary_color); ?>10;">
                                <span data-icon="bell" data-size="32" style="color: <?php echo esc_attr($primary_color); ?>;"></span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Đăng ký nhận thông báo</h3>
                            <p class="text-gray-600">Nhận thông tin về các chương trình khuyến mãi và ưu đãi đặc biệt từ Arata Vietnam.</p>
                        </div>

                        <?php
                        // Display success/error messages
                        if (isset($_GET['newsletter'])) {
                            $status = sanitize_text_field($_GET['newsletter']);
                            if ($status === 'success') {
                                echo '<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 text-sm">
                                    <strong>Thành công!</strong> Bạn đã đăng ký nhận thông báo thành công.
                                </div>';
                            } elseif ($status === 'exists') {
                                echo '<div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm">
                                    <strong>Thông báo:</strong> Email này đã được đăng ký trước đó.
                                </div>';
                            } elseif ($status === 'error') {
                                echo '<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                                    <strong>Lỗi:</strong> Có lỗi xảy ra. Vui lòng thử lại.
                                </div>';
                            }
                        }
                        ?>

                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-4">
                            <input type="hidden" name="action" value="arata_newsletter_submit" />
                            <?php wp_nonce_field('arata_newsletter_submit', 'arata_newsletter_nonce'); ?>

                            <div>
                                <label for="newsletter_name" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                                <input id="newsletter_name" name="name" type="text" required
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                                       placeholder="Nhập họ và tên của bạn" />
                            </div>

                            <div>
                                <label for="newsletter_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input id="newsletter_email" name="email" type="email" required
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                                       placeholder="Nhập địa chỉ email của bạn" />
                            </div>

                            <div>
                                <label for="newsletter_phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input id="newsletter_phone" name="phone" type="tel"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                                       placeholder="Nhập số điện thoại (tùy chọn)" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Sở thích sản phẩm</label>
                                <div class="space-y-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="interests[]" value="skincare" class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" />
                                        <span class="ml-3 text-sm text-gray-700">Chăm sóc da</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="interests[]" value="haircare" class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" />
                                        <span class="ml-3 text-sm text-gray-700">Chăm sóc tóc</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="interests[]" value="bodycare" class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" />
                                        <span class="ml-3 text-sm text-gray-700">Chăm sóc cơ thể</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="interests[]" value="makeup" class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" />
                                        <span class="ml-3 text-sm text-gray-700">Trang điểm</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full text-white py-4 rounded-lg transition-all duration-300 font-medium text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" style="background: linear-gradient(to right, <?php echo esc_attr($primary_color); ?>, <?php echo esc_attr($secondary_color); ?>);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                <span class="flex items-center justify-center">
                                    <span data-icon="send" data-size="20" class="mr-2"></span>
                                    Đăng ký ngay
                                </span>
                            </button>
                        </form>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            Bằng cách đăng ký, bạn đồng ý với
                            <a href="<?php echo home_url('/chinh-sach-bao-mat'); ?>" class="hover:underline" style="color: <?php echo esc_attr($primary_color); ?>;">Chính sách bảo mật</a>
                            của chúng tôi.
                        </p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
