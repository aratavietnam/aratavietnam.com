<?php
/**
 * The Template for displaying all single products
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

get_header();
?>

<main id="site-content" class="bg-gray-50" style="margin-top: -5px;">
    <?php while (have_posts()) : the_post(); ?>
        <?php global $product; ?>

        <!-- Breadcrumb -->
        <section class="border-b border-gray-200" style="background-color: <?php echo esc_attr($background_color); ?>">
            <div class="container mx-auto px-4">
                <div class="py-1 overflow-x-auto whitespace-nowrap">
                    <?php woocommerce_breadcrumb(array(
                        'delimiter'   => ' <span class="text-gray-400 mx-2">/</span> ',
                        'wrap_before' => '<nav class="text-sm text-gray-600">',
                        'wrap_after'  => '</nav>',
                        'before'      => '',
                        'after'       => '',
                        'home'        => __('Trang chủ', 'aratavietnam'),
                    )); ?>
                </div>
            </div>
        </section>

        <!-- Product Details Section -->
        <section class="py-12" style="background-color: <?php echo esc_attr($background_color); ?>">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Product Gallery -->
                    <div class="product-gallery">
                        <?php get_template_part('template-parts/single-product/product-gallery'); ?>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <div class="bg-white rounded-lg shadow-sm p-6 lg:p-8">
                            <?php get_template_part('template-parts/single-product/product-summary'); ?>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Product Tabs (Description, Reviews, etc.) -->
        <section class="py-12" style="background-color: <?php echo esc_attr($background_color); ?>">
            <div class="container mx-auto px-4">
                <?php get_template_part('template-parts/single-product/product-tabs'); ?>
            </div>
        </section>

        <!-- Related Products -->
        <section class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <?php
                $related_products = wc_get_related_products($product->get_id(), 4);
                if ($related_products) :
                ?>
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                            <span class="text-gray-700">Sản phẩm</span>
                            <span style="color: <?php echo esc_attr($primary_color); ?>">Liên Quan</span>
                        </h2>
                        <div class="w-24 h-1 mx-auto mt-4" style="background-color: <?php echo esc_attr($primary_color); ?>"></div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php
                        foreach ($related_products as $related_product_id) {
                            $post_object = get_post($related_product_id);
                            setup_postdata($GLOBALS['post'] =& $post_object);
                            get_template_part('template-parts/product-card');
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Recently Viewed Products -->
        <?php
        // Get recently viewed products
        $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
        $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

        if ( !empty($viewed_products) ) :
        ?>
        <section class="py-12 border-t border-gray-200" style="background-color: <?php echo esc_attr($background_color); ?>">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                        <span class="text-gray-700">Sản phẩm</span>
                        <span style="color: <?php echo esc_attr($primary_color); ?>">Đã Xem</span>
                    </h2>
                    <div class="w-24 h-1 mx-auto mt-4" style="background-color: <?php echo esc_attr($primary_color); ?>"></div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php
                    $query_args = array(
                        'posts_per_page' => 4,
                        'no_found_rows'  => 1,
                        'post_status'    => 'publish',
                        'post_type'      => 'product',
                        'post__in'       => $viewed_products,
                        'orderby'        => 'post__in',
                    );
                    $r = new WP_Query($query_args);

                    if ($r->have_posts()) {
                        while ($r->have_posts()) {
                            $r->the_post();
                            get_template_part('template-parts/product-card');
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
