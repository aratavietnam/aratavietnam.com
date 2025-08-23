<?php
/**
 * Template part for displaying product cards
 *
 * @package ArataVietnam
 */

global $product;
if (!$product) {
    return;
}
?>

<article class="group h-full product-card">
    <div class="bg-white rounded-lg border border-gray-200 hover:border-primary/30 transition-all duration-300 overflow-hidden h-full flex flex-col">
        <!-- Product Image -->
        <div class="aspect-square overflow-hidden bg-gray-50 flex-shrink-0 relative product-image">
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="block w-full h-full">
                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                </a>
            <?php else : ?>
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <span data-icon="image" data-size="48"></span>
                </div>
            <?php endif; ?>

            <!-- Quick View Overlay -->
            <div class="quick-view-overlay">
                <a href="<?php the_permalink(); ?>" class="bg-white text-primary px-3 py-1.5 rounded font-medium hover:bg-primary hover:text-white transition-colors text-sm quick-view-btn">
                    Xem chi tiết
                </a>
            </div>
        </div>

        <!-- Product Info -->
        <div class="p-3 flex-1 flex flex-col">
            <!-- Product Categories -->
            <div class="mb-2 flex-shrink-0">
                <?php
                $product_cats = get_the_terms(get_the_ID(), 'product_cat');
                if ($product_cats && !is_wp_error($product_cats)) :
                    $cat_names = array_slice(array_map(function($cat) { return $cat->name; }, $product_cats), 0, 1);
                    foreach ($cat_names as $cat_name) :
                        ?>
                        <span class="text-xs font-medium text-primary uppercase tracking-wide bg-primary/10 px-1.5 py-0.5 rounded-full"><?php echo esc_html($cat_name); ?></span>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>

            <!-- Product Title -->
            <h3 class="text-base font-semibold text-gray-900 mb-2 group-hover:text-primary transition-colors flex-shrink-0 line-clamp-2">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <!-- Product Price -->
            <div class="flex items-center justify-between mb-3 flex-shrink-0">
                <?php
                $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                $price = get_post_meta(get_the_ID(), '_price', true);

                if ($sale_price && $sale_price < $regular_price) :
                    ?>
                    <div class="flex items-center space-x-2">
                        <span class="text-base font-bold text-primary price-display"><?php echo number_format($sale_price); ?>₫</span>
                        <span class="text-sm text-gray-500 line-through price-regular"><?php echo number_format($regular_price); ?>₫</span>
                    </div>
                    <?php
                elseif ($price) :
                    ?>
                    <span class="text-base font-bold text-primary price-display"><?php echo number_format($price); ?>₫</span>
                    <?php
                else :
                    ?>
                    <span class="text-base font-bold text-primary price-display">Liên hệ</span>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</article>
