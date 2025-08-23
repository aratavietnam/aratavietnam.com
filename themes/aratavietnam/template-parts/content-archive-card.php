<?php
/**
 * Template part for displaying a post card in archive pages
 *
 * @package ArataVietnam
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col'); ?>>
    <div class="relative overflow-hidden">
        <a href="<?php the_permalink(); ?>" class="block">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300']); ?>
            <?php else : ?>
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400 text-sm">Không có ảnh</span>
                </div>
            <?php endif; ?>
        </a>
        <!-- Category Badge -->
        <div class="absolute top-4 left-4">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="inline-flex items-center px-3 py-1 bg-primary text-white text-xs font-medium rounded-full hover:bg-primary-dark transition-colors">' . esc_html($categories[0]->name) . '</a>';
            }
            ?>
        </div>
    </div>

    <div class="p-6 flex flex-col flex-grow">
        <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <div class="text-gray-600 mb-4 leading-relaxed text-sm flex-grow">
            <?php the_excerpt(); ?>
        </div>

        <div class="flex items-center justify-between text-xs text-gray-500 pt-4 border-t border-gray-100">
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo esc_html(get_the_date('d/m/Y')); ?>
            </time>
            <span class="flex items-center">
                <span data-icon="eye" data-size="14" class="mr-1"></span>
                <?php echo arata_get_post_views(get_the_ID()); ?>
            </span>
        </div>
    </div>
</article>

