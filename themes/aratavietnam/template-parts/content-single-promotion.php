<?php
/**
 * Template part for displaying single promotions
 *
 * @package ArataVietnam
 */

// Get all meta fields
$type = get_post_meta(get_the_ID(), 'arata_promotion_type', true);
$discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
$code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
$start_date = get_post_meta(get_the_ID(), 'arata_promotion_start_date', true);
$end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
$conditions = get_post_meta(get_the_ID(), 'arata_promotion_conditions', true);
$products = get_post_meta(get_the_ID(), 'arata_promotion_products', true);

// Labels for meta fields
$type_labels = ['percentage' => 'Giảm theo phần trăm', 'fixed' => 'Giảm số tiền cố định', 'buy_get' => 'Mua X tặng Y', 'free_shipping' => 'Miễn phí vận chuyển', 'bundle' => 'Combo sản phẩm'];
?>

<div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-12">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white p-6 md:p-8 rounded-lg shadow-sm'); ?>>
            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-6 rounded-lg overflow-hidden">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                </div>
            <?php endif; ?>

            <header class="entry-header mb-8">
                <?php if ($type && isset($type_labels[$type])): ?>
                    <div class="mb-4">
                        <span class="text-sm font-medium text-primary uppercase"><?php echo esc_html($type_labels[$type]); ?></span>
                    </div>
                <?php endif; ?>
                <?php the_title('<h1 class="text-3xl lg:text-5xl font-bold text-gray-900 tracking-tight leading-tight mb-4">', '</h1>'); ?>
                <?php if ($start_date && $end_date): ?>
                    <div class="flex items-center text-sm text-gray-500">
                        <span data-icon="calendar" data-size="16" class="mr-2"></span>
                        <span>Thời gian áp dụng: <?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d/m/Y', strtotime($end_date)); ?></span>
                    </div>
                <?php endif; ?>
            </header>

            <div class="entry-content prose prose-lg max-w-none text-gray-800 leading-relaxed border-t border-gray-200 pt-8">
                <?php the_content(); ?>

                <?php if ($conditions) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Điều kiện áp dụng</h3>
                    <div class="prose-sm text-gray-700 p-4 bg-yellow-50 border border-yellow-200 rounded-lg"><?php echo wpautop(esc_html($conditions)); ?></div>
                <?php endif; ?>

                <?php if ($products) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Sản phẩm áp dụng</h3>
                    <div class="prose-sm text-gray-700 p-4 bg-blue-50 border border-blue-200 rounded-lg"><?php echo wpautop(esc_html($products)); ?></div>
                <?php endif; ?>
            </div>
        </article>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-1 mt-12 lg:mt-0">
        <div class="sticky top-24">
            <!-- Promotion Summary -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Thông tin khuyến mãi</h3>
                <ul class="space-y-3 text-sm">
                    <?php if ($discount): ?>
                        <li class="flex items-center"><span data-icon="percent" class="mr-3 text-gray-400"></span><strong>Mức ưu đãi:</strong><span class="ml-auto text-right font-bold text-primary text-lg"><?php echo esc_html($discount); ?></span></li>
                    <?php endif; ?>
                    <?php if ($type && isset($type_labels[$type])) : ?>
                        <li class="flex items-center"><span data-icon="tag" class="mr-3 text-gray-400"></span><strong>Loại KM:</strong><span class="ml-auto text-right"><?php echo esc_html($type_labels[$type]); ?></span></li>
                    <?php endif; ?>
                    <?php if ($start_date && $end_date): ?>
                        <li class="flex items-center"><span data-icon="calendar" class="mr-3 text-gray-400"></span><strong>Thời gian:</strong><span class="ml-auto text-right"><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d/m/Y', strtotime($end_date)); ?></span></li>
                    <?php endif; ?>
                </ul>

                <?php if ($code): ?>
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600 mb-2">Sử dụng mã sau để nhận ưu đãi:</p>
                        <div class="p-3 bg-primary/10 rounded-lg border-2 border-dashed border-primary/50">
                            <code class="text-primary text-2xl font-bold tracking-widest"><?php echo esc_html($code); ?></code>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-6">
                    <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="w-full inline-block text-center bg-primary text-white py-3 rounded-lg hover:bg-primary-dark transition-colors font-medium">Mua sắm ngay</a>
                </div>
            </div>
        </div>
    </aside>
</div>
