<?php
/**
 * Archive template for promotion custom post type
 */

if (!defined('ABSPATH')) { exit; }

get_header();


// Hero
$hero_title = 'Khuyến mãi';
// Find the Promotions settings page to get the hero subtitle
    $promo_page = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/promotions.php', 'number' => 1]);
    $hero_subtitle = 'Ưu đãi đặc biệt từ Arata Vietnam'; // Default value
    if (!empty($promo_page)) {
        $promo_page_id = $promo_page[0]->ID;
        $saved_subtitle = get_post_meta($promo_page_id, 'arata_news_subtitle', true);
        if (!empty($saved_subtitle)) {
            $hero_subtitle = $saved_subtitle;
        }
    }
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <?php
    $archive_description = get_the_archive_description();
    if ($archive_description) :
    ?>
    <!-- Page Content -->
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-4xl mx-auto">
            <div class="prose max-w-none mb-12">
                <?php echo $archive_description; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

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
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Ưu đãi hiện tại</h2>
            </div>

            <!-- Promotions Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        // Lấy meta fields từ news-meta-fields.php
                        $type = get_post_meta(get_the_ID(), 'arata_promotion_type', true);
                        $discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
                        $code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
                        $start_date = get_post_meta(get_the_ID(), 'arata_promotion_start_date', true);
                        $end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
                        $conditions = get_post_meta(get_the_ID(), 'arata_promotion_conditions', true);
                        $products = get_post_meta(get_the_ID(), 'arata_promotion_products', true);

                        // Định nghĩa label cho loại khuyến mãi
                        $type_labels = [
                            'percentage' => 'Giảm theo phần trăm',
                            'fixed' => 'Giảm số tiền cố định',
                            'buy_get' => 'Mua X tặng Y',
                            'free_shipping' => 'Miễn phí vận chuyển',
                            'bundle' => 'Combo sản phẩm'
                        ];
                        ?>
                        <div class="bg-white rounded-lg p-6 border border-gray-200 hover:border-primary transition-colors duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 flex-1">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <?php if ($discount): ?>
                                    <span class="bg-primary text-white px-4 py-2 rounded-full text-sm font-bold ml-4">
                                        <?php echo esc_html($discount); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if ($type && isset($type_labels[$type])): ?>
                                <div class="mb-3">
                                    <span class="inline-block bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium">
                                        <?php echo esc_html($type_labels[$type]); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php if ($code): ?>
                                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-300">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Mã khuyến mãi:</span>
                                        <code class="bg-primary text-white px-3 py-1 rounded font-mono text-sm font-bold"><?php echo esc_html($code); ?></code>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="space-y-3 mb-6">
                                <?php if ($start_date && $end_date): ?>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span data-icon="calendar" data-size="16" class="text-gray-400 mr-2"></span>
                                        Từ <?php echo date('d/m/Y', strtotime($start_date)); ?> đến <?php echo date('d/m/Y', strtotime($end_date)); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($products): ?>
                                    <div class="flex items-start text-sm text-gray-600">
                                        <span data-icon="package" data-size="16" class="text-gray-400 mr-2 mt-0.5"></span>
                                        <span class="flex-1"><?php echo esc_html($products); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="prose text-sm text-gray-600 mb-6">
                                <?php the_excerpt(); ?>
                            </div>

                            <?php if ($conditions): ?>
                                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <h4 class="font-semibold text-yellow-800 mb-2">Điều kiện áp dụng:</h4>
                                    <p class="text-sm text-yellow-700"><?php echo esc_html($conditions); ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="pt-4 border-t border-gray-200">
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                    Xem chi tiết
                                    <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                </a>
                            </div>
                        </div>
                    <?php endwhile;
                else:
                    ?>
                    <div class="lg:col-span-2 text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span data-icon="gift" data-size="32" class="text-gray-400"></span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Hiện tại chưa có chương trình khuyến mãi nào</h3>
                        <p class="text-gray-600 mb-6">Chúng tôi sẽ cập nhật thông tin khuyến mãi mới nhất tại đây.</p>
                        <a href="<?php echo home_url('/tin-tuc'); ?>" class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                            <span data-icon="arrow-left" data-size="16" class="mr-2"></span>
                            Quay lại trang tin tức
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (get_next_posts_link() || get_previous_posts_link()): ?>
                <div class="flex justify-center">
                    <nav class="flex space-x-2">
                        <?php
                        echo paginate_links([
                            'prev_text' => '<span data-icon="chevron-left" data-size="16"></span> Trước',
                            'next_text' => 'Sau <span data-icon="chevron-right" data-size="16"></span>',
                            'class' => 'px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'
                        ]);
                        ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Newsletter Signup -->
    <div class="bg-primary/5 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span data-icon="bell" data-size="32" class="text-primary"></span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Đăng ký nhận thông báo khuyến mãi</h3>
                <p class="text-gray-600 mb-8">
                    Nhận thông tin về các chương trình khuyến mãi và ưu đãi đặc biệt từ Arata Vietnam.
                </p>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="max-w-md mx-auto space-y-4">
                    <input type="hidden" name="action" value="arata_newsletter_submit" />
                    <?php wp_nonce_field('arata_newsletter_submit', 'arata_newsletter_nonce'); ?>

                    <div>
                        <input name="name" type="text" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                               placeholder="Họ và tên *" />
                    </div>

                    <div>
                        <input name="email" type="email" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                               placeholder="Email *" />
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-primary-dark transition-colors font-medium">
                        Đăng ký ngay
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
