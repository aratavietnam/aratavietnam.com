<?php
/**
 * Template Name: Tuyển dụng
 * Template Post Type: page
 * Description: Trang tuyển dụng với layout 2 cột giống blog
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Get page meta fields for hero customization
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_careers_subtitle', true) ?: 'Tuyển dụng';
$hero_intro = get_post_meta(get_the_ID(), 'arata_careers_intro', true) ?: 'Khám phá cơ hội nghề nghiệp tại Arata Vietnam - nơi bạn có thể phát triển tài năng và xây dựng tương lai trong lĩnh vực hóa mỹ phẩm.';

// Section visibility controls
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) !== '0'; // Default to true if not set
$use_compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true) === '1'; // New compact option

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
            
            <!-- Careers Content Section -->
            <div class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>;">
                <div class="container mx-auto px-4">
        <?php
    } else {
        // Use full hero template part
        get_template_part('template-parts/hero');
        ?>
        <main id="site-content" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <!-- Careers Content Section -->
            <div class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>;">
                <div class="container mx-auto px-4">
        <?php
    }
} else {
    ?>
    <main id="site-content" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <!-- Careers Content Section -->
        <div class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <div class="container mx-auto px-4">
    <?php
}
?>

<!-- Main Careers Layout: Left (6 jobs horizontal) + Right (sidebar vertical) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Side: 6 Job Postings in Horizontal Layout (2 rows x 3 columns) -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php
                        $job_posts = new WP_Query([
                            'post_type' => 'job_posting',
                            'posts_per_page' => 6,
                            'post_status' => 'publish'
                        ]);

                        if ($job_posts->have_posts()) :
                            while ($job_posts->have_posts()) : $job_posts->the_post();
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
                                                <span data-icon="briefcase" data-size="32" class="text-gray-400 mb-2"></span>
                                                <p class="text-gray-500 text-sm">Arata Vietnam</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="p-4">
                                        <!-- Meta info -->
                                        <div class="flex items-center text-xs text-gray-500 mb-3">
                                            <span data-icon="calendar" data-size="14" class="mr-1"></span>
                                            <?php echo get_the_date('d/m/Y'); ?>
                                            
                                            <?php
                                            $location = get_post_meta(get_the_ID(), 'job_location', true);
                                            if ($location): ?>
                                                <span class="mx-2">•</span>
                                                <span data-icon="map-pin" data-size="14" class="mr-1"></span>
                                                <?php echo esc_html($location); ?>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Job Title -->
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>

                                        <!-- Job Description (Excerpt) -->
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            if (empty($excerpt)) {
                                                $excerpt = wp_trim_words(get_the_content(), 20);
                                            }
                                            echo esc_html($excerpt);
                                            ?>
                                        </p>

                                        <!-- Job Type & Salary -->
                                        <div class="flex items-center justify-between mb-4">
                                            <?php
                                            $job_type = get_post_meta(get_the_ID(), 'job_type', true);
                                            $salary = get_post_meta(get_the_ID(), 'job_salary', true);
                                            ?>
                                            
                                            <?php if ($job_type): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <?php echo esc_html($job_type); ?>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <?php if ($salary): ?>
                                                <span class="text-primary font-semibold text-sm">
                                                    <?php echo esc_html($salary); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- View details link -->
                                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                            Xem chi tiết
                                            <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                        </a>
                                    </div>
                                </article>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            ?>
                            <div class="col-span-full text-center py-12">
                                <div class="text-gray-400 mb-4">
                                    <span data-icon="briefcase" data-size="48"></span>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có tin tuyển dụng nào</h3>
                                <p class="text-gray-600">Hãy quay lại sau để xem những cơ hội nghề nghiệp mới nhất tại Arata Vietnam.</p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($job_posts->max_num_pages > 1): ?>
                        <div class="mt-12 flex justify-center">
                            <div class="flex items-center space-x-2">
                                <?php
                                $current_page = max(1, get_query_var('paged'));
                                $total_pages = $job_posts->max_num_pages;

                                // Previous button
                                if ($current_page > 1): ?>
                                    <a href="<?php echo get_pagenum_link($current_page - 1); ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                        Trước
                                    </a>
                                <?php endif;

                                // Page numbers
                                for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <a href="<?php echo get_pagenum_link($i); ?>" class="px-4 py-2 text-sm font-medium <?php echo ($i == $current_page) ? 'text-white bg-primary border-primary' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50'; ?> border rounded-lg">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor;

                                // Next button
                                if ($current_page < $total_pages): ?>
                                    <a href="<?php echo get_pagenum_link($current_page + 1); ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                        Sau
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Side: Vertical Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 sticky top-8 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                            Thông tin tuyển dụng
                        </h3>

                        <div class="space-y-6">
                            <!-- Company Benefits -->
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <span data-icon="heart" data-size="16" class="mr-2 text-primary"></span>
                                    Phúc lợi nhân viên
                                </h4>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start">
                                        <span data-icon="check" data-size="14" class="mr-2 text-green-500 mt-0.5 flex-shrink-0"></span>
                                        Lương tháng 13, thưởng hiệu suất
                                    </li>
                                    <li class="flex items-start">
                                        <span data-icon="check" data-size="14" class="mr-2 text-green-500 mt-0.5 flex-shrink-0"></span>
                                        Bảo hiểm sức khỏe toàn diện
                                    </li>
                                    <li class="flex items-start">
                                        <span data-icon="check" data-size="14" class="mr-2 text-green-500 mt-0.5 flex-shrink-0"></span>
                                        Đào tạo & phát triển sự nghiệp
                                    </li>
                                    <li class="flex items-start">
                                        <span data-icon="check" data-size="14" class="mr-2 text-green-500 mt-0.5 flex-shrink-0"></span>
                                        Môi trường làm việc hiện đại
                                    </li>
                                    <li class="flex items-start">
                                        <span data-icon="check" data-size="14" class="mr-2 text-green-500 mt-0.5 flex-shrink-0"></span>
                                        Team building định kỳ
                                    </li>
                                </ul>
                            </div>

                            <!-- Contact Info -->
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <span data-icon="phone" data-size="16" class="mr-2 text-primary"></span>
                                    Liên hệ HR
                                </h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center">
                                        <span data-icon="mail" data-size="14" class="mr-2 text-gray-400"></span>
                                        hr@aratavietnam.com
                                    </p>
                                    <p class="flex items-center">
                                        <span data-icon="phone" data-size="14" class="mr-2 text-gray-400"></span>
                                        (028) 1234 5678
                                    </p>
                                </div>
                            </div>

                            <!-- Quick Apply -->
                            <div class="border-t border-gray-200 pt-4">
                                <a href="mailto:hr@aratavietnam.com" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                    Gửi CV ngay
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

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.sticky {
    position: sticky;
}
</style>

<?php get_footer(); ?>