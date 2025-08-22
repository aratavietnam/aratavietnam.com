<?php
/**
 * Template Name: News Page
 * Template Post Type: page
 * Description: Main news page with 3 sections: Promotions, Careers, Blog
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = get_the_title();
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_news_subtitle', true) ?: 'Cập nhật tin tức mới nhất từ Arata Vietnam';
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
        <div class="max-w-4xl mx-auto">
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
    </div>
    <?php
        }
    }
    ?>

    <!-- News Sections -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <!-- Section Navigation -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                    <span class="text-primary font-medium text-sm uppercase tracking-wider">Tin tức & Thông báo</span>
                    <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Cập nhật từ Arata Vietnam</h2>

                <!-- Tab Navigation -->
                <div class="flex flex-wrap justify-center gap-4 mb-8">
                    <button class="news-tab-btn active px-6 py-3 rounded-lg font-medium transition-all duration-300" data-tab="promotions">
                        <span data-icon="megaphone" data-size="18" class="mr-2"></span>
                        Khuyến mãi
                    </button>
                    <button class="news-tab-btn px-6 py-3 rounded-lg font-medium transition-all duration-300" data-tab="careers">
                        <span data-icon="user" data-size="18" class="mr-2"></span>
                        Tuyển dụng
                    </button>
                    <button class="news-tab-btn px-6 py-3 rounded-lg font-medium transition-all duration-300" data-tab="blog">
                        <span data-icon="file-text" data-size="18" class="mr-2"></span>
                        Blog
                    </button>
                </div>
            </div>

            <!-- Promotions Section -->
            <div id="promotions-section" class="news-section active">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <?php
                    $promotions = new WP_Query([
                        'post_type' => 'promotion',
                        'posts_per_page' => 3,
                        'post_status' => 'publish',
                        'meta_query' => [
                            [
                                'key' => 'arata_promotion_end_date',
                                'value' => date('Y-m-d'),
                                'compare' => '>=',
                                'type' => 'DATE'
                            ]
                        ]
                    ]);

                    if ($promotions->have_posts()) :
                        while ($promotions->have_posts()) : $promotions->the_post();
                            get_template_part('template-parts/content-single-promotion');
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<div class="col-span-3 text-center text-gray-600">' . __('Hiện tại chưa có chương trình khuyến mãi nào.', 'aratavietnam') . '</div>';
                    endif;
                    ?>
                </div>
                        <div class="mt-8 text-center">
                                                    <a href="<?php echo home_url('/khuyen-mai'); ?>" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors duration-300">
                            Xem tất cả khuyến mãi
                            <span data-icon="arrow-right" data-size="18" class="ml-2"></span>
                        </a>
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    <div>
                        <div class="bg-primary/5 rounded-lg p-6 border border-primary/20">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Đăng ký nhận thông báo</h3>
                            <p class="text-gray-600 mb-6">Nhận thông tin về các chương trình khuyến mãi và ưu đãi đặc biệt từ Arata Vietnam.</p>

                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-4">
                                <input type="hidden" name="action" value="arata_newsletter_submit" />
                                <?php wp_nonce_field('arata_newsletter_submit', 'arata_newsletter_nonce'); ?>

                                <div>
                                    <label for="newsletter_name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                                    <input id="newsletter_name" name="name" type="text" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                </div>

                                <div>
                                    <label for="newsletter_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input id="newsletter_email" name="email" type="email" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                </div>

                                <div>
                                    <label for="newsletter_phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                                    <input id="newsletter_phone" name="phone" type="tel" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Sở thích sản phẩm</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="interests[]" value="skincare" class="rounded border-gray-300 text-primary focus:ring-primary" />
                                            <span class="ml-2 text-sm text-gray-700">Chăm sóc da</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="interests[]" value="haircare" class="rounded border-gray-300 text-primary focus:ring-primary" />
                                            <span class="ml-2 text-sm text-gray-700">Chăm sóc tóc</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="interests[]" value="bodycare" class="rounded border-gray-300 text-primary focus:ring-primary" />
                                            <span class="ml-2 text-sm text-gray-700">Chăm sóc cơ thể</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-primary-dark transition-colors duration-300 font-medium">
                                    Đăng ký ngay
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Careers Section -->
            <div id="careers-section" class="news-section hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <?php
                    $jobs = new WP_Query([
                        'post_type' => 'job_posting',
                        'posts_per_page' => 6,
                        'post_status' => 'publish',
                        'meta_query' => [
                            [
                                'key' => 'arata_job_deadline',
                                'value' => date('Y-m-d'),
                                'compare' => '>=',
                                'type' => 'DATE'
                            ]
                        ]
                    ]);

                    if ($jobs->have_posts()) :
                        while ($jobs->have_posts()) : $jobs->the_post();
                            $department = get_post_meta(get_the_ID(), 'arata_job_department', true);
                            $location = get_post_meta(get_the_ID(), 'arata_job_location', true);
                            $deadline = get_post_meta(get_the_ID(), 'arata_job_deadline', true);
                            ?>
                            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:border-secondary transition-colors duration-300">
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>

                                <div class="space-y-2 mb-4 text-sm text-gray-600">
                                    <?php if ($department): ?>
                                        <div class="flex items-center">
                                            <span data-icon="building" data-size="14" class="mr-2"></span>
                                            <?php echo esc_html($department); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($location): ?>
                                        <div class="flex items-center">
                                            <span data-icon="map-pin" data-size="14" class="mr-2"></span>
                                            <?php echo esc_html($location); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($deadline): ?>
                                        <div class="flex items-center text-red-600">
                                            <span data-icon="calendar" data-size="14" class="mr-2"></span>
                                            Hạn: <?php echo date('d/m/Y', strtotime($deadline)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <p class="text-gray-600 text-sm mb-4"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>

                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                    Xem chi tiết & Ứng tuyển
                                    <span data-icon="arrow-right" data-size="14" class="ml-1"></span>
                                </a>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<div class="col-span-3 text-center text-gray-600">Hiện tại chưa có vị trí tuyển dụng nào.</div>';
                    endif;
                    ?>
                </div>

                <div class="mt-8 text-center">
                    <a href="<?php echo home_url('/tuyen-dung'); ?>" class="inline-flex items-center px-6 py-3 bg-secondary text-white rounded-lg hover:bg-secondary-dark transition-colors duration-300">
                        Xem tất cả vị trí tuyển dụng
                        <span data-icon="arrow-right" data-size="18" class="ml-2"></span>
                    </a>
                </div>
            </div>

            <!-- Blog Section -->
            <div id="blog-section" class="news-section hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Main Blog Posts (2/3 width) -->
                    <div class="lg:col-span-2">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Bài viết mới nhất</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php
                            $blog_posts = new WP_Query([
                                'post_type' => 'post',
                                'posts_per_page' => 6,
                                'post_status' => 'publish'
                            ]);

                            if ($blog_posts->have_posts()) :
                                while ($blog_posts->have_posts()) : $blog_posts->the_post();
                                    ?>
                                    <article class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:border-primary transition-colors duration-300">
                                        <?php if (has_post_thumbnail()): ?>
                                            <div class="aspect-video overflow-hidden">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <div class="p-4">
                                            <div class="flex items-center text-xs text-gray-500 mb-2">
                                                <span data-icon="calendar" data-size="12" class="mr-1"></span>
                                                <?php echo get_the_date('d/m/Y'); ?>
                                                <span class="mx-2">•</span>
                                                <span data-icon="user" data-size="12" class="mr-1"></span>
                                                <?php the_author(); ?>
                                            </div>

                                            <h4 class="text-base font-semibold text-gray-900 mb-2 line-clamp-2">
                                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h4>

                                            <p class="text-gray-600 text-sm mb-3 line-clamp-3"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>

                                            <a href="<?php the_permalink(); ?>" class="text-primary hover:text-primary-dark font-medium text-sm">
                                                Đọc tiếp
                                                <span data-icon="arrow-right" data-size="12" class="ml-1"></span>
                                            </a>
                                        </div>
                                    </article>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else:
                                echo '<div class="col-span-2 text-center text-gray-600">Chưa có bài viết nào.</div>';
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Sidebar (1/3 width) -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Bài viết khác</h3>
                        <div class="space-y-4">
                            <?php
                            $sidebar_posts = new WP_Query([
                                'post_type' => 'post',
                                'posts_per_page' => 8,
                                'post_status' => 'publish',
                                'offset' => 6 // Skip the first 6 posts shown in main area
                            ]);

                            if ($sidebar_posts->have_posts()) :
                                while ($sidebar_posts->have_posts()) : $sidebar_posts->the_post();
                                    ?>
                                    <div class="border-b border-gray-200 pb-3">
                                        <h5 class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                        </h5>
                                        <div class="text-xs text-gray-500">
                                            <span data-icon="calendar" data-size="10" class="mr-1"></span>
                                            <?php echo get_the_date('d/m/Y'); ?>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>

                        <div class="mt-6">
                            <a href="<?php echo home_url('/blog'); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm">
                                Xem tất cả bài viết
                                <span data-icon="arrow-right" data-size="14" class="ml-1"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.news-tab-btn {
    background: white;
    color: #6B7280;
    border: 1px solid #E5E7EB;
    display: flex;
    align-items: center;
    justify-content: center;
}

.news-tab-btn.active {
    background: #F55E25;
    color: white;
    border-color: #F55E25;
}

.news-tab-btn:hover:not(.active) {
    background: #F9FAFB;
    color: #374151;
}

.news-section {
    display: none;
}

.news-section.active {
    display: block;
}

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

/* Icon alignment fixes */
[data-icon] {
    display: inline-flex;
    align-items: center;
    vertical-align: middle;
}

.flex.items-center [data-icon] {
    flex-shrink: 0;
}

.inline-flex.items-center [data-icon] {
    flex-shrink: 0;
}

/* Simple hover effects */
.news-card:hover {
    border-color: #F55E25;
}

.career-card:hover {
    border-color: #0066A6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.news-tab-btn');
    const sections = document.querySelectorAll('.news-section');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');

            // Remove active class from all buttons and sections
            tabButtons.forEach(btn => btn.classList.remove('active'));
            sections.forEach(section => section.classList.remove('active'));

            // Add active class to clicked button and corresponding section
            this.classList.add('active');
            document.getElementById(targetTab + '-section').classList.add('active');
        });
    });
});
</script>

<?php get_footer(); ?>
