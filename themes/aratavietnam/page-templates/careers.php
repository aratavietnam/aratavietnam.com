<?php
/**
 * Template Name: Tuyển dụng
 * Template Post Type: page
 * Description: Trang tuyển dụng với thiết kế hiện đại
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get global colors
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Hero configuration
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) !== '0';
$use_compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true) === '1';
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_careers_subtitle', true) ?: 'Cơ hội nghề nghiệp tuyệt vời tại Arata Vietnam';
$hero_intro = get_post_meta(get_the_ID(), 'arata_careers_intro', true) ?: 'Gia nhập đội ngũ Arata Vietnam và phát triển sự nghiệp trong lĩnh vực hóa mỹ phẩm hàng đầu.';

// Set hero variables
set_query_var('title', get_the_title());
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

            <!-- Jobs Content Section -->
            <div class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
                <div class="container mx-auto px-4">
        <?php
    } else {
        // Use full hero template part
        get_template_part('template-parts/hero');
        ?>
        <main id="site-content" class="bg-gradient-to-br from-gray-50 to-gray-100">
            <!-- Jobs Content Section -->
            <div class="py-16">
                <div class="container mx-auto px-4">
        <?php
    }
} else {
    ?>
    <main id="site-content" class="bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Jobs Content Section -->
        <div class="py-16">
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

                <!-- Stats Section -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="text-3xl font-bold text-primary mb-2">50+</div>
                        <div class="text-gray-600">Nhân sự</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="text-3xl font-bold text-secondary mb-2">5+</div>
                        <div class="text-gray-600">Chi nhánh</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="text-3xl font-bold text-tertiary mb-2">10+</div>
                        <div class="text-gray-600">Năm kinh nghiệm</div>
                    </div>
                    <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                        <div class="text-3xl font-bold text-green-600 mb-2">100%</div>
                        <div class="text-gray-600">Đào tạo</div>
                    </div>
                </div>

                <!-- Jobs Grid -->
                <?php
                $job_posts = new WP_Query([
                    'post_type' => 'job_posting',
                    'posts_per_page' => 9,
                    'post_status' => 'publish',
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1
                ]);

                if ($job_posts->have_posts()) : ?>
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                        <?php
                        while ($job_posts->have_posts()) : $job_posts->the_post();
                            $job_type = get_post_meta(get_the_ID(), 'job_type', true);
                            $job_location = get_post_meta(get_the_ID(), 'job_location', true);
                            $job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
                            $job_deadline = get_post_meta(get_the_ID(), 'job_deadline', true);
                            ?>
                            <article class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden border border-gray-100">
                                <!-- Header with gradient -->
                                <div class="bg-gradient-to-r from-primary to-secondary p-6 text-white">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                                            <span data-icon="briefcase" data-size="24"></span>
                                        </div>
                                        <?php if ($job_type): ?>
                                            <span class="bg-white text-primary px-3 py-1 rounded-full text-xs font-semibold">
                                                <?php echo esc_html($job_type); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <h3 class="text-xl font-bold mb-2">
                                        <a href="<?php the_permalink(); ?>" class="text-white hover:text-white/90 transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                </div>

                                <div class="p-6">
                                    <!-- Job Info -->
                                    <div class="space-y-3 mb-6">
                                        <?php if ($job_location): ?>
                                            <div class="flex items-center text-gray-600">
                                                <span data-icon="map-pin" data-size="16" class="mr-3 text-primary"></span>
                                                <span class="text-sm"><?php echo esc_html($job_location); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($job_salary): ?>
                                            <div class="flex items-center text-gray-600">
                                                <span data-icon="dollar-sign" data-size="16" class="mr-3 text-primary"></span>
                                                <span class="text-sm font-medium text-green-600"><?php echo esc_html($job_salary); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($job_deadline): ?>
                                            <div class="flex items-center text-gray-600">
                                                <span data-icon="calendar" data-size="16" class="mr-3 text-primary"></span>
                                                <span class="text-sm">Hạn nộp: <?php echo date('d/m/Y', strtotime($job_deadline)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Excerpt -->
                                    <div class="text-gray-600 text-sm mb-6 line-clamp-3">
                                        <?php
                                        $excerpt = get_the_excerpt();
                                        if (empty($excerpt)) {
                                            $excerpt = wp_trim_words(get_the_content(), 25);
                                        }
                                        echo esc_html($excerpt);
                                        ?>
                                    </div>

                                    <!-- Apply Button -->
                                    <a href="<?php the_permalink(); ?>" class="block w-full bg-gradient-to-r from-primary to-secondary text-white text-center py-3 rounded-lg font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                                        Xem chi tiết & Ứng tuyển
                                    </a>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        <?php
                        $big = 999999999;
                        echo paginate_links([
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $job_posts->max_num_pages,
                            'prev_text' => '<span class="flex items-center"><span data-icon="chevron-left" data-size="16" class="mr-1"></span> Trang trước</span>',
                            'next_text' => '<span class="flex items-center">Trang sau <span data-icon="chevron-right" data-size="16" class="ml-1"></span></span>',
                            'type' => 'list',
                            'end_size' => 2,
                            'mid_size' => 2,
                            'before_page_number' => '<span class="bg-white px-3 py-2 rounded-lg shadow-sm mx-1">',
                            'after_page_number' => '</span>',
                            'prev_next_class' => 'bg-white px-4 py-2 rounded-lg shadow-sm mx-1 font-medium',
                        ]);
                        ?>
                    </div>

                <?php else : ?>
                    <div class="text-center py-20 bg-white rounded-2xl">
                        <div class="text-6xl mb-6">🎯</div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Hiện tại chưa có vị trí tuyển dụng</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Chúng tôi đang cập nhật các cơ hội mới. Hãy quay lại sau hoặc gửi CV về để chúng tôi liên hệ khi có vị trí phù hợp.
                        </p>
                        <div class="space-x-4">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                                Về trang chủ
                            </a>
                            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="inline-block bg-white text-primary border border-primary px-6 py-3 rounded-lg font-semibold hover:bg-primary/5 transition-colors">
                                Liên hệ chúng tôi
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </main>

<?php get_footer(); ?>