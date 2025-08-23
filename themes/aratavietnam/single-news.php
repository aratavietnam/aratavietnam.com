<?php
/**
 * Single News Template
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) { exit; }

get_header();
?>

<main id="site-content" class="bg-white">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary/5 to-secondary/5 py-16 lg:py-24">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Breadcrumb -->
                <nav class="flex items-center justify-center mb-6 text-sm text-gray-600">
                    <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
                    <span class="mx-2">/</span>
                    <a href="<?php echo home_url('/tin-tuc'); ?>" class="hover:text-primary transition-colors">Tin tức</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900"><?php the_title(); ?></span>
                </nav>

                <!-- Categories -->
                <?php
                $categories = get_the_category();
                if (!empty($categories)) :
                ?>
                <div class="mb-6">
                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"
                       class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-medium rounded-full hover:bg-primary/90 transition-colors">
                        <span data-icon="tag" data-size="16" class="mr-2"></span>
                        <?php echo esc_html($categories[0]->name); ?>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Title -->
                <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 tracking-tight leading-tight mb-6">
                    <?php the_title(); ?>
                </h1>

                <!-- Meta Info -->
                <div class="flex items-center justify-center text-sm text-gray-600 space-x-6">
                    <span class="flex items-center">
                        <span data-icon="user" data-size="16" class="mr-2"></span>
                        <span><?php the_author(); ?></span>
                    </span>
                    <span class="flex items-center">
                        <span data-icon="calendar" data-size="16" class="mr-2"></span>
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d/m/Y'); ?></time>
                    </span>
                    <span class="flex items-center">
                        <span data-icon="eye" data-size="16" class="mr-2"></span>
                        <span><?php echo arata_get_post_views(get_the_ID()); ?> lượt xem</span>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-12">

                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('break-words'); ?>>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Post Content -->
                        <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                            <?php
                            the_content();
                            wp_link_pages([
                                'before' => '<div class="page-links text-center my-8">' . __('Trang:', 'aratavietnam'),
                                'after'  => '</div>',
                            ]);
                            ?>
                        </div>

                        <!-- Tags -->
                        <?php
                        $tags = get_the_tags();
                        if ($tags) :
                        ?>
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <div class="flex items-center flex-wrap">
                                <span class="font-semibold mr-4 text-gray-700">Tags:</span>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($tags as $tag) : ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                           class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm hover:bg-primary hover:text-white transition-colors">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Author Bio -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <div class="flex items-start space-x-4">
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span data-icon="user" data-size="24" class="text-primary"></span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tác giả: <?php the_author(); ?></h3>
                                    <p class="text-gray-600">Bài viết được viết bởi đội ngũ chuyên gia của Arata Vietnam.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Share -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Chia sẻ bài viết:</h3>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <span data-icon="facebook" data-size="16" class="mr-2"></span>
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   class="flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                                    <span data-icon="twitter" data-size="16" class="mr-2"></span>
                                    Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   class="flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors">
                                    <span data-icon="linkedin" data-size="16" class="mr-2"></span>
                                    LinkedIn
                                </a>
                            </div>
                        </div>

                    </article>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1 mt-12 lg:mt-0">
                    <div class="sticky top-24 space-y-8">

                        <!-- Related Posts -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                                <span data-icon="file-text" data-size="20" class="mr-2 text-primary"></span>
                                Bài viết liên quan
                            </h3>
                            <div class="space-y-4">
                                <?php
                                $related_args = [
                                    'post_type'      => 'post',
                                    'posts_per_page' => 4,
                                    'post__not_in'   => [get_the_ID()],
                                    'category__in'   => wp_get_post_categories(get_the_ID(), ['fields' => 'ids']),
                                ];
                                $related_query = new WP_Query($related_args);

                                if ($related_query->have_posts()) :
                                    while ($related_query->have_posts()) : $related_query->the_post();
                                ?>
                                    <a href="<?php the_permalink(); ?>" class="flex items-start group">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden mr-4">
                                                <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center mr-4">
                                                <span data-icon="file-text" data-size="24" class="text-gray-400"></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                                <?php the_title(); ?>
                                            </h4>
                                            <div class="text-xs text-gray-500 mt-2"><?php echo get_the_date('d/m/Y'); ?></div>
                                        </div>
                                    </a>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                else :
                                    echo '<p class="text-gray-600 text-sm">Không có bài viết liên quan.</p>';
                                endif;
                                ?>
                            </div>
                        </div>

                        <!-- Popular Posts -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                                <span data-icon="trending-up" data-size="20" class="mr-2 text-primary"></span>
                                Bài viết nổi bật
                            </h3>
                            <div class="space-y-4">
                                <?php
                                $popular_posts = new WP_Query([
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

                                if ($popular_posts->have_posts()) :
                                    while ($popular_posts->have_posts()) : $popular_posts->the_post();
                                ?>
                                    <a href="<?php the_permalink(); ?>" class="flex items-start group">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden mr-4">
                                                <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="flex-shrink-0 w-20 h-20 rounded-lg bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center mr-4">
                                                <span data-icon="file-text" data-size="24" class="text-gray-400"></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-800 group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                                <?php the_title(); ?>
                                            </h4>
                                            <div class="text-xs text-gray-500 mt-2"><?php echo get_the_date('d/m/Y'); ?></div>
                                        </div>
                                    </a>
                                <?php
                                    endwhile;
                                    wp_reset_postdata();
                                else :
                                    echo '<p class="text-gray-600 text-sm">Không có bài viết nào.</p>';
                                endif;
                                ?>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                                <span data-icon="folder" data-size="20" class="mr-2 text-primary"></span>
                                Danh mục
                            </h3>
                            <div class="space-y-2">
                                <?php
                                $categories = get_categories([
                                    'hide_empty' => true,
                                    'number' => 10
                                ]);

                                foreach ($categories as $category) :
                                    $category_link = get_category_link($category->term_id);
                                    $post_count = $category->count;
                                ?>
                                    <a href="<?php echo esc_url($category_link); ?>"
                                       class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                            <?php echo $post_count; ?>
                                        </span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </section>

</main>

<?php
get_footer();
?>
