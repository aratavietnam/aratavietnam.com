<?php
/**
 * Template Name: Tuyển dụng
 * Template Post Type: page
 * Description: Trang tuyển dụng theo cấu trúc blog
 */

if (!defined('ABSPATH')) { exit; }

get_header();
?>

<main id="site-content" class="bg-gray-50 py-12 md:py-20">
    <div class="container mx-auto px-4">

        <header class="archive-header mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2"><?php the_title(); ?></h1>
            <div class="text-lg text-gray-600 max-w-2xl mx-auto">
                Khám phá cơ hội nghề nghiệp tại Arata Vietnam - nơi bạn có thể phát triển tài năng và xây dựng tương lai trong lĩnh vực hóa mỹ phẩm.
            </div>
        </header>

        <?php
        $job_posts = new WP_Query([
            'post_type' => 'job_posting',
            'posts_per_page' => 12,
            'post_status' => 'publish',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1
        ]);

        if ($job_posts->have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ($job_posts->have_posts()) : $job_posts->the_post();
                    ?>
                    <article class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col">
                        <div class="relative overflow-hidden">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                <?php else : ?>
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <div class="text-center">
                                            <span data-icon="briefcase" data-size="24" class="text-gray-400 mb-2"></span>
                                            <p class="text-gray-400 text-sm">Tuyển dụng</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <!-- Job Type Badge -->
                            <div class="absolute top-4 left-4">
                                <?php
                                $job_type = get_post_meta(get_the_ID(), 'job_type', true);
                                if ($job_type) {
                                    echo '<span class="inline-flex items-center px-3 py-1 bg-primary text-white text-xs font-medium rounded-full">' . esc_html($job_type) . '</span>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="text-gray-600 mb-4 leading-relaxed text-sm flex-grow">
                                <?php
                                $excerpt = get_the_excerpt();
                                if (empty($excerpt)) {
                                    $excerpt = wp_trim_words(get_the_content(), 20);
                                }
                                echo esc_html($excerpt);
                                ?>
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date('d/m/Y')); ?>
                                </time>
                                <?php
                                $location = get_post_meta(get_the_ID(), 'job_location', true);
                                if ($location): ?>
                                    <span class="flex items-center">
                                        <span data-icon="map-pin" data-size="14" class="mr-1"></span>
                                        <?php echo esc_html($location); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <div class="mt-12">
                <?php
                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $job_posts->max_num_pages,
                    'prev_text' => '<span class="mr-2">&laquo;</span> Trang trước',
                    'next_text' => 'Trang sau <span class="ml-2">&raquo;</span>',
                    'type' => 'list',
                    'end_size' => 3,
                    'mid_size' => 3
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Chưa có tin tuyển dụng nào</h2>
                <p class="text-gray-600">Hãy quay lại sau để xem những cơ hội nghề nghiệp mới nhất tại Arata Vietnam.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mt-6 inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors">Quay về trang chủ</a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>