<?php
/**
 * Template part for displaying product or service cards
 *
 * @package ArataVietnam
 * @var array $args
 */

$post_id = get_the_ID();
$post_type = $args['post_type'] ?? get_post_type($post_id);

if (empty($post_id) || empty($post_type)) {
    return;
}

$is_service = ($post_type === 'service');

// --- Initialize variables ---
$taxonomy = '';
$price = '';
$price_type = '';
$regular_price = '';
$sale_price = '';
$product = null;

// --- Data Fetching ---
if ($is_service) {
    $taxonomy = 'service_category';
    $price = get_post_meta($post_id, 'arata_service_price', true);
    $price_type = get_post_meta($post_id, 'arata_service_price_type', true);
} elseif (class_exists('WooCommerce')) {
    $taxonomy = 'product_cat';
    $product = wc_get_product($post_id);
    if ($product) {
        $price = $product->get_price();
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
    }
}

$terms = get_the_terms($post_id, $taxonomy);
?>

<div class="group">
    <!-- Product Image - No shadow, flat design -->
    <div class="aspect-square overflow-hidden bg-gray-50 mb-3 rounded-lg">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
            <?php else : ?>
                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                    <span data-icon="package" data-size="48" class="text-gray-400"></span>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <!-- Product Info - Outside image box, flat design -->
    <div class="text-center min-h-[4rem] flex flex-col justify-center">
        <!-- Product Name -->
        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-1 text-base leading-relaxed group-hover:text-primary transition-colors">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Product Price -->
        <div class="text-base font-semibold text-gray-800">
            <?php
            if ($product && $product->get_price()) {
                echo number_format($product->get_price()) . '₫';
            } else {
                echo 'Liên hệ';
            }
            ?>
        </div>
    </div>
</div>
