<?php
/**
 * Promotion Archive Template - Based on blog page structure
 * Layout: 2/3 main content + 1/3 sidebar like blog page
 */

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Get promotions archive page settings (create page if not exists)
$promotions_page = get_page_by_path('khuyen-mai');
if (!$promotions_page) {
    // Create promotions page if it doesn't exist
    $promotions_page_id = wp_insert_post([
        'post_title' => 'Khuyến mãi',
        'post_name' => 'khuyen-mai',
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_content' => 'Trang khuyến mãi của Arata Vietnam'
    ]);
    $promotions_page = get_post($promotions_page_id);
}

// Get hero settings from the promotions page
$show_hero = get_post_meta($promotions_page->ID, 'arata_show_hero', true) !== '0'; // Default to true if not set
$use_compact_hero = get_post_meta($promotions_page->ID, 'arata_compact_hero', true) === '1'; // New compact option
$hero_subtitle = get_post_meta($promotions_page->ID, 'arata_promotions_subtitle', true) ?: 'Khuyến mãi';
$hero_intro = get_post_meta($promotions_page->ID, 'arata_promotions_intro', true) ?: 'Khám phá các chương trình khuyến mãi hấp dẫn và ưu đãi độc quyền từ Arata Vietnam.';

// Set hero variables
set_query_var('title', 'Khuyến mãi');
set_query_var('subtitle', $hero_subtitle);
set_query_var('description', $hero_intro);
set_query_var('compact_mode', $use_compact_hero);

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
            <!-- Main Layout: Left (2/3) + Right (1/3) like blog -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Side: Promotions Grid (2/3) -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                $discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
                                $code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
                                $end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
                                ?>
                                <article class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="aspect-video overflow-hidden">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="aspect-video bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                                            <div class="text-center">
                                                <span class="text-4xl mb-2 block">🎉</span>
                                                <p class="text-gray-500 text-sm">Khuyến mãi đặc biệt</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Discount Badge -->
                                    <?php if ($discount): ?>
                                        <div class="absolute top-4 right-4 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                            -<?php echo esc_html($discount); ?>%
                                        </div>
                                    <?php endif; ?>

                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>

                                        <div class="text-gray-600 mb-4 leading-relaxed text-sm">
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </div>

                                        <?php if ($code): ?>
                                            <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-gray-600">Mã khuyến mãi:</span>
                                                    <code class="text-white px-3 py-1 rounded font-mono text-sm font-bold" style="background-color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($code); ?></code>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                                            <?php if ($end_date): ?>
                                                <span class="flex items-center">
                                                    <span data-icon="clock" data-size="14" class="mr-1"></span>
                                                    Hết hạn: <?php echo date('d/m/Y', strtotime($end_date)); ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="flex items-center">
                                                    <span data-icon="infinity" data-size="14" class="mr-1"></span>
                                                    Không giới hạn thời gian
                                                </span>
                                            <?php endif; ?>

                                            <a href="<?php the_permalink(); ?>" class="text-primary hover:text-primary-dark font-medium">
                                                Xem chi tiết →
                                            </a>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                        else:
                            ?>
                            <div class="col-span-full text-center py-16">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-4xl">🎉</span>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có khuyến mãi nào</h3>
                                <p class="text-gray-600">Hãy quay lại sau để không bỏ lỡ các ưu đãi hấp dẫn!</p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <?php if (have_posts()): ?>
                        <div class="mt-12">
                            <?php
                            the_posts_pagination([
                                'prev_text' => '<span class="mr-2">&laquo;</span> Trang trước',
                                'next_text' => 'Trang sau <span class="ml-2">&raquo;</span>',
                                'screen_reader_text' => ' ',
                                'before_page_number' => '<span class="inline-flex items-center justify-center w-10 h-10">',
                                'after_page_number'  => '</span>',
                            ]);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Side: Sidebar (1/3) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 sticky top-8 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                            Khuyến mãi sắp hết hạn
                        </h3>

                        <div class="space-y-4">
                            <?php
                            $sidebar_promotions = new WP_Query([
                                'post_type' => 'promotion',
                                'posts_per_page' => 5,
                                'post_status' => 'publish',
                                'meta_query' => [
                                    [
                                        'key' => 'arata_promotion_end_date',
                                        'value' => [date('Y-m-d'), date('Y-m-d', strtotime('+30 days'))],
                                        'compare' => 'BETWEEN',
                                        'type' => 'DATE'
                                    ]
                                ],
                                'meta_key' => 'arata_promotion_end_date',
                                'orderby' => 'meta_value',
                                'order' => 'ASC'
                            ]);

                            if ($sidebar_promotions->have_posts()) :
                                while ($sidebar_promotions->have_posts()) : $sidebar_promotions->the_post();
                                    $end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
                                    $discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
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
                                                        <span class="text-lg">🎉</span>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                                        <?php the_title(); ?>
                                                    </h4>
                                                    <?php if ($discount): ?>
                                                        <div class="text-xs text-red-600 font-bold mt-1">
                                                            Giảm <?php echo esc_html($discount); ?>%
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="flex items-center text-xs text-gray-500 mt-2">
                                                        <span data-icon="clock" data-size="12" class="mr-1"></span>
                                                        <?php echo date('d/m/Y', strtotime($end_date)); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else:
                                ?>
                                <p class="text-gray-600 text-sm">Không có khuyến mãi sắp hết hạn.</p>
                                <?php
                            endif;
                            ?>
                        </div>

                        <!-- View all promotions link -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="<?php echo home_url('/khuyen-mai'); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                Xem tất cả khuyến mãi
                                <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php get_footer(); ?>
