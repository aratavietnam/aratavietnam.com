<?php
/**
 * Template Name: Promotions Page
 * Template Post Type: page
 * Description: Promotions page with newsletter signup form
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = get_the_title();
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_news_subtitle', true) ?: 'Ưu đãi đặc biệt từ Arata Vietnam';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <!-- Page Content -->
    <div class="container mx-auto px-4 py-10">
        <article id="post-<?php the_ID(); ?>" <?php post_class('prose max-w-none mb-12'); ?>>
            <div class="entry-content">
                <?php
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
                ?>
            </div>
        </article>
    </div>

    <!-- Promotions Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                    <span class="text-primary font-medium text-sm uppercase tracking-wider">Khuyến mãi đặc biệt</span>
                    <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
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
                                <div class="bg-white rounded-lg p-6 border border-gray-200 hover:border-primary transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-4">
                                        <h4 class="text-xl font-semibold text-gray-900 flex-1">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                        </h4>
                                        <?php if ($discount): ?>
                                            <span class="bg-primary text-white px-4 py-2 rounded-full text-sm font-bold ml-4">
                                                <?php echo esc_html($discount); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($code): ?>
                                        <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-300">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">Mã khuyến mãi:</span>
                                                <code class="bg-primary text-white px-3 py-1 rounded font-mono text-sm font-bold"><?php echo esc_html($code); ?></code>
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
                                        <a href="<?php the_permalink(); ?>" class="text-primary hover:text-primary-dark font-medium">
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
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span data-icon="bell" data-size="32" class="text-primary"></span>
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

                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-4 rounded-lg hover:from-primary-dark hover:to-secondary-dark transition-all duration-300 font-medium text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <span class="flex items-center justify-center">
                                    <span data-icon="send" data-size="20" class="mr-2"></span>
                                    Đăng ký ngay
                                </span>
                            </button>
                        </form>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            Bằng cách đăng ký, bạn đồng ý với
                            <a href="<?php echo home_url('/chinh-sach-bao-mat'); ?>" class="text-primary hover:underline">Chính sách bảo mật</a>
                            của chúng tôi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
