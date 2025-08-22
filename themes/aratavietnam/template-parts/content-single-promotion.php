<?php
/**
 * Template part for displaying promotion cards in lists
 *
 * @package ArataVietnam
 */

// Get promotion meta fields
$type = get_post_meta(get_the_ID(), 'arata_promotion_type', true);
$discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
$code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
$start_date = get_post_meta(get_the_ID(), 'arata_promotion_start_date', true);
$end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);

// Labels for promotion types
$type_labels = [
    'percentage' => 'Giảm %',
    'fixed' => 'Giảm tiền',
    'buy_get' => 'Mua tặng',
    'free_shipping' => 'Miễn phí ship',
    'bundle' => 'Combo'
];

// Calculate days remaining
$days_remaining = 0;
if ($end_date) {
    $end_timestamp = strtotime($end_date);
    $current_timestamp = current_time('timestamp');
    $days_remaining = max(0, ceil(($end_timestamp - $current_timestamp) / DAY_IN_SECONDS));
}
?>

<article class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-primary">
    <!-- Promotion Image -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="aspect-video overflow-hidden">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
            </a>
        </div>
    <?php else : ?>
        <div class="aspect-video bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
            <div class="text-center">
                <span data-icon="megaphone" data-size="32" class="text-gray-400 mb-2"></span>
                <p class="text-gray-500 text-sm">Khuyến mãi</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Promotion Content -->
    <div class="p-4">
        <!-- Promotion Type Badge -->
        <?php if ($type && isset($type_labels[$type])): ?>
            <div class="mb-3">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary border border-primary/20">
                    <?php echo esc_html($type_labels[$type]); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Discount Info -->
        <?php if ($discount): ?>
            <div class="mb-3">
                <span class="text-2xl font-bold text-primary"><?php echo esc_html($discount); ?></span>
                <?php if ($type === 'percentage'): ?>
                    <span class="text-sm text-gray-600 ml-1">giảm giá</span>
                <?php elseif ($type === 'fixed'): ?>
                    <span class="text-sm text-gray-600 ml-1">VNĐ</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Promotion Code -->
        <?php if ($code): ?>
            <div class="mb-3 p-2 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs text-gray-600 mb-1">Mã khuyến mãi:</p>
                <code class="text-sm font-mono font-bold text-primary"><?php echo esc_html($code); ?></code>
            </div>
        <?php endif; ?>

        <!-- Date Range -->
        <?php if ($start_date && $end_date): ?>
            <div class="flex items-center text-xs text-gray-500 mb-3">
                <span data-icon="calendar" data-size="14" class="mr-1"></span>
                <span><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d/m/Y', strtotime($end_date)); ?></span>
            </div>
        <?php endif; ?>

        <!-- Days Remaining -->
        <?php if ($days_remaining > 0): ?>
            <div class="mb-3">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo $days_remaining <= 3 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                    <span data-icon="clock" data-size="12" class="mr-1"></span>
                    Còn <?php echo $days_remaining; ?> ngày
                </span>
            </div>
        <?php endif; ?>

        <!-- Excerpt -->
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
            <?php
            $excerpt = get_the_excerpt();
            if (empty($excerpt)) {
                $excerpt = wp_trim_words(get_the_content(), 15);
            }
            echo esc_html($excerpt);
            ?>
        </p>

        <!-- Read More Link -->
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
            Xem chi tiết
            <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
        </a>
    </div>
</article>
