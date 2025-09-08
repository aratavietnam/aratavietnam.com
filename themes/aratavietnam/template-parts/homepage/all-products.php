<?php
/**
 * Homepage All Products Section - Grid Layout (2x4)
 */

// Get homepage settings
$front_page_id = get_option('page_on_front');
$show_all_products = get_post_meta($front_page_id, 'arata_all_products_show', true);
$all_products_title = get_post_meta($front_page_id, 'arata_all_products_title', true) ?: 'Tất Cả Sản Phẩm';

// Only show if section is enabled
if ($show_all_products === '0') {
    return;
}

// Get global colors
$primary_color = get_theme_mod('arata_primary_color', '#0066A6');
$secondary_color = get_theme_mod('arata_secondary_color', '#F55E25');
$background_color = get_theme_mod('theme_background_color', '#ffffff');
?>

<!-- All Products Section -->
<section id="all-products" class="py-20 scroll-animate" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="container mx-auto px-4 text-center">
        <div class="mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                <span style="color: <?php echo esc_attr($secondary_color); ?>;"><?php echo esc_html($all_products_title); ?></span>
            </h2>
        </div>

        <!-- Products Grid -->
        <div class="products-container">
            <?php
            // Get all products (8 products for 2x4 grid)
            $all_products = array();
            if (function_exists('wc_get_products')) {
                $all_products = wc_get_products([
                    'limit' => 8,
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);
            }

            if ($all_products) :
            ?>
                <!-- Desktop Grid (4 columns x 2 rows) -->
                <div class="hidden md:grid md:grid-cols-4 gap-6 max-w-6xl mx-auto">
                    <?php foreach ($all_products as $product) :
                        $product_id = $product->get_id();
                        $product_name = $product->get_name();
                        $product_price = $product->get_price();
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                        $product_link = get_permalink($product_id);
                        ?>
                        <div class="group">
                            <!-- Product Image -->
                            <div class="aspect-square overflow-hidden bg-white mb-3 rounded-lg shadow-sm">
                                <?php if ($product_image) : ?>
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <img src="<?php echo esc_url($product_image[0]); ?>"
                                             alt="<?php echo esc_attr($product_name); ?>"
                                             class="w-full h-full object-cover" />
                                    </a>
                                <?php else : ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <span data-icon="package" data-size="48" class="text-gray-400"></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Product Info -->
                            <div class="text-center">
                                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-1">
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <?php echo esc_html($product_name); ?>
                                    </a>
                                </h3>

                                <!-- Product Price -->
                                <div class="text-base font-semibold text-gray-700">
                                    <?php if ($product_price) : ?>
                                        <?php echo number_format($product_price); ?>₫
                                    <?php else : ?>
                                        Liên hệ
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Mobile Grid (2 columns) -->
                <div class="md:hidden grid grid-cols-2 gap-4">
                    <?php foreach ($all_products as $product) :
                        $product_id = $product->get_id();
                        $product_name = $product->get_name();
                        $product_price = $product->get_price();
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                        $product_link = get_permalink($product_id);
                        ?>
                        <div class="group">
                            <!-- Product Image -->
                            <div class="aspect-square overflow-hidden bg-white mb-3 rounded-lg shadow-sm">
                                <?php if ($product_image) : ?>
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <img src="<?php echo esc_url($product_image[0]); ?>"
                                             alt="<?php echo esc_attr($product_name); ?>"
                                             class="w-full h-full object-cover" />
                                    </a>
                                <?php else : ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <span data-icon="package" data-size="32" class="text-gray-400"></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Product Info -->
                            <div class="text-center">
                                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-1 text-sm">
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <?php echo esc_html($product_name); ?>
                                    </a>
                                </h3>

                                <!-- Product Price -->
                                <div class="text-sm font-semibold text-gray-700">
                                    <?php if ($product_price) : ?>
                                        <?php echo number_format($product_price); ?>₫
                                    <?php else : ?>
                                        Liên hệ
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <!-- No Products Found -->
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span data-icon="package" data-size="32" class="text-gray-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">Chưa có sản phẩm nào</h3>
                    <p class="text-gray-500">Vui lòng thêm sản phẩm trong admin panel.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- View All Products Button -->
        <div class="text-center mt-12">
            <a href="<?php echo wc_get_page_permalink('shop'); ?>"
               class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition-all duration-300">
                Xem tất cả sản phẩm
                <span data-icon="arrow-right" data-size="16" class="ml-2"></span>
            </a>
        </div>
    </div>
</section>

    <style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Flat design - minimal hover effects */
#all-products .group:hover h3 a {
    color: #f97316;
}

/* Smooth transitions for text only */
#all-products h3 a {
    transition: color 0.2s ease;
}

/* Responsive text sizes */
@media (max-width: 640px) {
    #all-products h2 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    #all-products h3 {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }
}

@media (min-width: 641px) {
    #all-products h3 {
        font-size: 1rem;
        line-height: 1.5rem;
    }
}
</style>
