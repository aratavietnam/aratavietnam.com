<?php
/**
 * Promotion Archive Template - New UI Design
 * Layout: Blog-style with system icons, no emojis
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
        <!-- Compact Hero Section -->
        <section class="py-16 text-center" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo esc_html($hero_subtitle); ?></h1>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo esc_html($hero_intro); ?>
                    </p>
                </div>
            </div>
        </section>
        <?php
    } else {
        // Use full hero template part
        get_template_part('template-parts/hero');
    }
}

// Start main content
?>
<main id="site-content" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <!-- Promotions Content Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">

            <!-- Main Layout: Left (2/3) + Right (1/3) like blog -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

    <!-- Left Side: Promotions Grid (2/3) -->
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    $discount = get_post_meta(get_the_ID(), 'arata_promotion_discount', true);
                    $code = get_post_meta(get_the_ID(), 'arata_promotion_code', true);
                    $end_date = get_post_meta(get_the_ID(), 'arata_promotion_end_date', true);
                    $start_date = get_post_meta(get_the_ID(), 'arata_promotion_start_date', true);
                    ?>
                    <article class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()): ?>
                            <div class="aspect-video overflow-hidden relative">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                </a>

                                <!-- Discount Badge -->
                                <?php if ($discount): ?>
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"></path>
                                        </svg>
                                        <?php echo esc_html($discount); ?>%
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="aspect-video bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center relative">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm font-medium">Khuyến mãi đặc biệt</p>
                                </div>

                                <!-- Discount Badge -->
                                <?php if ($discount): ?>
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"></path>
                                        </svg>
                                        <?php echo esc_html($discount); ?>%
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300 line-clamp-2">
                                <a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
                            </h3>

                            <!-- Excerpt -->
                            <div class="text-gray-600 mb-4 leading-relaxed text-sm line-clamp-3">
                                <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                            </div>

                            <!-- Promotion Code -->
                            <?php if ($code): ?>
                                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Mã khuyến mãi:
                                        </div>
                                        <code class="text-white px-3 py-1 rounded font-mono text-sm font-bold" style="background-color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($code); ?></code>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <!-- Date -->
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <?php echo get_the_date('d/m/Y'); ?>
                                    </div>

                                    <!-- Expiry -->
                                    <?php if ($end_date): ?>
                                        <div class="flex items-center text-red-600">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Hết hạn: <?php echo date('d/m/Y', strtotime($end_date)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Read More -->
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
                                    Xem chi tiết
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
            else:
                ?>
                <div class="col-span-full text-center py-16">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
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
                    'prev_text' => '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Trang trước',
                    'next_text' => 'Trang sau <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
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
        <div class="bg-white rounded-xl p-6 sticky top-8 shadow-sm border border-gray-100">
            <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900">Khuyến mãi sắp hết hạn</h3>
            </div>

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
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                            <?php the_title(); ?>
                                        </h4>
                                        <?php if ($discount): ?>
                                            <div class="flex items-center text-xs text-red-600 font-bold mt-1">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732L14.146 12.8l-1.179 4.456a1 1 0 01-1.934 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732L9.854 7.2l1.179-4.456A1 1 0 0112 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                Giảm <?php echo esc_html($discount); ?>%
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex items-center text-xs text-gray-500 mt-2">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
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
                    <div class="text-center py-8">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-sm">Không có khuyến mãi sắp hết hạn</p>
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

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php get_footer(); ?>
