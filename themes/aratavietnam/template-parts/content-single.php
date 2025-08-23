<?php
/**
 * Template part for displaying single posts
 *
 * @package ArataVietnam
 */
?>

<div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-12">

        <!-- Main Content -->
        <div class="lg:col-span-2">
            <article id="post-<?php the_ID(); ?>" <?php post_class('break-words'); ?>>
                <header class="mb-8">
                    <!-- Categories -->
                    <div class="mb-4">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="text-sm font-medium text-primary uppercase hover:text-primary-dark transition-colors">' . esc_html($categories[0]->name) . '</a>';
                        }
                        ?>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 tracking-tight leading-tight mb-4"><?php the_title(); ?></h1>

                    <!-- Post Meta -->
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="flex items-center">
                            <span data-icon="user" data-size="16" class="mr-2"></span>
                            <span><?php the_author(); ?></span>
                        </span>
                        <span class="mx-3">|</span>
                        <span class="flex items-center">
                            <span data-icon="calendar" data-size="16" class="mr-2"></span>
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                        </span>
                        <span class="mx-3">|</span>
                        <span class="flex items-center">
                             <span data-icon="eye" data-size="16" class="mr-2"></span>
                            <span><?php echo arata_get_post_views(get_the_ID()); ?></span>
                        </span>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                    <?php
                    the_content();
                    wp_link_pages([
                        'before' => '<div class="page-links">' . __('Pages:', 'aratavietnam'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>

                <!-- Footer with Tags and Social Share -->
                <footer class="mt-12 pt-8 border-t border-gray-200">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                        <div class="flex items-center flex-wrap mb-6">
                            <span class="font-semibold mr-4 text-gray-700">Tags:</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm hover:bg-primary hover:text-white transition-colors">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php get_template_part('template-parts/shared/social-share'); ?>
                </footer>
            </article>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 mt-12 lg:mt-0">
            <div class="sticky top-24">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Bài viết liên quan</h3>
                <div class="space-y-6">
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
                                    <div class="flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden mr-4">
                                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-1">
                                    <h4 class="text-base font-semibold text-gray-800 group-hover:text-primary transition-colors leading-snug"><?php the_title(); ?></h4>
                                    <div class="text-xs text-gray-500 mt-2"><?php echo get_the_date('F j, Y'); ?></div>
                                </div>
                            </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p class="text-gray-600">Không có bài viết liên quan.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </aside>

    </div>
</div>
