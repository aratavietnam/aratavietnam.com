<?php
/**
 * Template Name: Blog Page
 * Template Post Type: page
 * Description: Blog page with horizontal layout (6 posts, 2 rows) on left and vertical sidebar on right
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = get_the_title();
// Try to get subtitle from the current page first
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_news_subtitle', true);

// If empty, fall back to the main News page setting
if (empty($hero_subtitle)) {
    $news_page = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/news.php']);
    if (!empty($news_page)) {
        $news_page_id = $news_page[0]->ID;
        $hero_subtitle = get_post_meta($news_page_id, 'arata_news_subtitle', true);
    }
}

// Fallback to a default value if still not found
if (empty($hero_subtitle)) {
    $hero_subtitle = 'Chia sẻ kiến thức và kinh nghiệm';
}
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <?php
    // Only show the Page Content section if the page has content in the editor.
    if (have_posts()) {
        the_post(); // Set up the post data
        if (trim(get_the_content())) { // Check if there is actual content, not just whitespace
            rewind_posts(); // Rewind the loop so it can run again below
    ?>
    <!-- Page Content -->
    <div class="container mx-auto px-4 py-12">
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
    <?php
        }
    }
    ?>

    <!-- Blog Layout Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                    <span class="text-primary font-medium text-sm uppercase tracking-wider">Blog Arata Vietnam</span>
                    <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Bài viết mới nhất</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Khám phá những bài viết chuyên sâu về hóa mỹ phẩm, xu hướng làm đẹp và kiến thức chăm sóc sắc đẹp từ Nhật Bản.
                </p>
            </div>

            <!-- Main Blog Layout: Left (6 posts horizontal) + Right (sidebar vertical) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Side: 6 Posts in Horizontal Layout (2 rows x 3 columns) -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php
                        $blog_posts = new WP_Query([
                            'post_type' => 'post',
                            'posts_per_page' => 6,
                            'post_status' => 'publish'
                        ]);

                        if ($blog_posts->have_posts()) :
                            while ($blog_posts->have_posts()) : $blog_posts->the_post();
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
                                                <span data-icon="file-text" data-size="32" class="text-gray-400 mb-2"></span>
                                                <p class="text-gray-500 text-sm">Arata Vietnam</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="p-4">
                                        <!-- Meta info -->
                                        <div class="flex items-center text-xs text-gray-500 mb-3">
                                            <span data-icon="calendar" data-size="14" class="mr-1"></span>
                                            <?php echo get_the_date('d/m/Y'); ?>
                                            <span class="mx-2">•</span>
                                            <span data-icon="user" data-size="14" class="mr-1"></span>
                                            <?php the_author(); ?>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>

                                        <!-- Meta Description (Excerpt) -->
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            if (empty($excerpt)) {
                                                $excerpt = wp_trim_words(get_the_content(), 20);
                                            }
                                            echo esc_html($excerpt);
                                            ?>
                                        </p>

                                        <!-- Read more link -->
                                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                            Đọc tiếp
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
                                    <span data-icon="file-text" data-size="48"></span>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có bài viết nào</h3>
                                <p class="text-gray-600">Hãy quay lại sau để đọc những bài viết mới nhất từ Arata Vietnam.</p>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($blog_posts->max_num_pages > 1): ?>
                        <div class="mt-12 flex justify-center">
                            <div class="flex items-center space-x-2">
                                <?php
                                $current_page = max(1, get_query_var('paged'));
                                $total_pages = $blog_posts->max_num_pages;

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

                <!-- Right Side: Vertical Sidebar (titles only) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 sticky top-8 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                            Bài viết được đọc nhiều nhất
                        </h3>

                        <div class="space-y-4">
                            <?php
                            $sidebar_posts = new WP_Query([
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'post_status' => 'publish',
                                'meta_key' => 'post_views_count',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'date_query' => [
                                    ['after' => '1 month ago']
                                ]
                            ]);

                            if ($sidebar_posts->have_posts()) :
                                while ($sidebar_posts->have_posts()) : $sidebar_posts->the_post();
                                    ?>
                                    <div class="border-b border-gray-100/80 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
                                        <a href="<?php the_permalink(); ?>" class="flex items-start space-x-4 group">
                                            <?php if (has_post_thumbnail()): ?>
                                                <div class="flex-shrink-0 w-20 h-16">
                                                    <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover rounded-md group-hover:opacity-90 transition-opacity']); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="flex-1">
                                                <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 leading-relaxed group-hover:text-primary transition-colors">
                                                    <?php the_title(); ?>
                                                </h4>
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <span data-icon="calendar" data-size="12" class="mr-1"></span>
                                                    <?php echo get_the_date('d/m/Y'); ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else:
                                ?>
                                <p class="text-gray-600 text-sm">Không có bài viết khác.</p>
                                <?php
                            endif;
                            ?>
                        </div>

                        <!-- View all posts link -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="<?php echo home_url('/blog'); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                Xem tất cả bài viết
                                <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                            </a>
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
