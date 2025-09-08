<?php
/**
 * Job Posting Archive Template - New UI Design
 * Layout: Blog-style with system icons, 3-column layout
 */

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Get careers archive page settings (create page if not exists)
$careers_page = get_page_by_path('tuyen-dung');
if (!$careers_page) {
    // Create careers page if it doesn't exist
    $careers_page_id = wp_insert_post([
        'post_title' => 'Tuyển dụng',
        'post_name' => 'tuyen-dung',
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_content' => 'Trang tuyển dụng của Arata Vietnam'
    ]);
    $careers_page = get_post($careers_page_id);
}

// Get hero settings from the careers page
$show_hero = get_post_meta($careers_page->ID, 'arata_show_hero', true) !== '0'; // Default to true if not set
$use_compact_hero = get_post_meta($careers_page->ID, 'arata_compact_hero', true) === '1'; // New compact option
$hero_subtitle = get_post_meta($careers_page->ID, 'arata_careers_subtitle', true) ?: 'Tuyển dụng';
$hero_intro = get_post_meta($careers_page->ID, 'arata_careers_intro', true) ?: 'Khám phá các cơ hội việc làm tuyệt vời và gia nhập đội ngũ chuyên nghiệp của Arata Vietnam.';

// Set hero variables
set_query_var('title', 'Tuyển dụng');
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
    <!-- Jobs Content Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">

            <!-- Main Layout: Left (2/3) + Right (1/3) like blog -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Side: Jobs Grid (2/3) -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                $job_type = get_post_meta(get_the_ID(), 'job_type', true);
                                $job_location = get_post_meta(get_the_ID(), 'job_location', true);
                                $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
                                $job_deadline = get_post_meta(get_the_ID(), 'job_deadline', true);
                                $job_experience = get_post_meta(get_the_ID(), 'job_experience', true);
                                ?>
                                <article class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                                    <!-- Featured Image -->
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="aspect-video overflow-hidden relative">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                            </a>

                                                                                    </div>
                                    <?php else: ?>
                                        <div class="aspect-video bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center relative">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                                </svg>
                                                <p class="text-gray-500 text-sm font-medium">Cơ hội việc làm</p>
                                            </div>

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
                                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                        </div>

                                        <!-- Job Details -->
                                        <div class="space-y-2 mb-4">
                                            <?php if ($job_location): ?>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <?php echo esc_html($job_location); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($job_salary): ?>
                                                <div class="flex items-center text-sm text-green-600 font-medium">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                    </svg>
                                                    <?php echo esc_html($job_salary); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($job_experience): ?>
                                                <div class="flex items-center text-sm text-blue-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                    </svg>
                                                    <?php echo esc_html($job_experience); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

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

                                                <!-- Deadline -->
                                                <?php if ($job_deadline): ?>
                                                    <div class="flex items-center text-red-600">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Hạn: <?php echo date('d/m/Y', strtotime($job_deadline)); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Read More -->
                                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium">
                                                Ứng tuyển
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có vị trí tuyển dụng nào</h3>
                                <p class="text-gray-600">Hãy quay lại sau để xem các cơ hội việc làm mới nhất!</p>
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
                    <!-- Recent Jobs -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900">Việc làm mới nhất</h3>
                        </div>

                        <div class="space-y-4">
                            <?php
                            $recent_jobs = new WP_Query([
                                'post_type' => 'job_posting',
                                'posts_per_page' => 5,
                                'post_status' => 'publish',
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ]);

                            if ($recent_jobs->have_posts()) :
                                while ($recent_jobs->have_posts()) : $recent_jobs->the_post();
                                    $job_location = get_post_meta(get_the_ID(), 'job_location', true);
                                    $job_type = get_post_meta(get_the_ID(), 'job_type', true);
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
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                                        <?php the_title(); ?>
                                                    </h4>
                                                    <?php if ($job_type): ?>
                                                        <div class="flex items-center text-xs text-primary font-bold mt-1">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                                            </svg>
                                                            <?php echo esc_html($job_type); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($job_location): ?>
                                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            <?php echo esc_html($job_location); ?>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Không có việc làm mới</p>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>

                        <!-- View all jobs link -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="<?php echo home_url('/tuyen-dung'); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm w-full justify-center py-2 px-4 border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                </svg>
                                Xem tất cả việc làm
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
