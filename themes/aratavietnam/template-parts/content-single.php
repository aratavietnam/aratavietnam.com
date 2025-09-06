<?php
/**
 * Template part for displaying single posts
 *
 * @package ArataVietnam
 */

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');
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
                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="text-sm font-medium uppercase hover:opacity-80 transition-colors" style="color: ' . esc_attr($primary_color) . ';">' . esc_html($categories[0]->name) . '</a>';
                        }
                        ?>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 tracking-tight leading-tight mb-4"><?php the_title(); ?></h1>

                    <!-- Post Meta -->
                    <div class="flex items-center text-sm text-gray-500">
                        <span class="flex items-center">
                            <span data-icon="calendar" data-size="16" class="mr-2"></span>
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d/m/Y'); ?></time>
                        </span>
                        <span class="mx-3">•</span>
                        <span class="flex items-center">
                             <span data-icon="eye" data-size="16" class="mr-2"></span>
                            <span><?php echo arata_get_post_views(get_the_ID()); ?> lượt xem</span>
                        </span>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-8 rounded-xl overflow-hidden shadow-sm">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="bg-white rounded-xl p-6 lg:p-8 shadow-sm mb-8">
                    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                        <?php
                        the_content();
                        wp_link_pages([
                            'before' => '<div class="page-links">' . __('Pages:', 'aratavietnam'),
                            'after'  => '</div>',
                        ]);
                        ?>
                    </div>
                </div>

                <!-- Footer with Tags and Social Share -->
                <footer class="bg-white rounded-xl p-6 lg:p-8 shadow-sm">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                        <div class="flex items-center flex-wrap mb-6">
                            <span class="font-semibold mr-4 text-gray-700">Tags:</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm hover:text-white transition-colors" onmouseover="this.style.backgroundColor='<?php echo esc_attr($primary_color); ?>'" onmouseout="this.style.backgroundColor=''">
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
            <div class="bg-white rounded-xl p-6 sticky top-24 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">Bài viết liên quan</h3>
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
                            <div class="border-b border-gray-100/80 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
                                <a href="<?php the_permalink(); ?>" class="flex items-start space-x-4 group">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="flex-shrink-0 w-20 h-16">
                                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover rounded-md group-hover:opacity-90 transition-opacity']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 leading-relaxed transition-colors" style="color: inherit;" onmouseover="this.style.color='<?php echo esc_attr($primary_color); ?>'" onmouseout="this.style.color='inherit'"><?php the_title(); ?></h4>
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
                    else :
                        echo '<p class="text-gray-600">Không có bài viết liên quan.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </aside>

</div>
