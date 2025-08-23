<?php
/**
 * The Template for displaying all single products
 *
 * @package ArataVietnam
 */

get_header();
?>

<main id="site-content" class="bg-gray-50">
    <?php while (have_posts()) : the_post(); ?>
        <?php global $product; ?>

        <!-- Breadcrumb -->
        <section class="bg-white border-b border-gray-200">
            <div class="container mx-auto px-4">
                <div class="py-3 overflow-x-auto whitespace-nowrap">
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
        <section class="py-12">
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

                        <!-- Sale Policies -->
                        <div class="mt-6 bg-white rounded-lg shadow-sm p-6 lg:p-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Chính sách bán hàng</h3>
                            <?php
                            $policy1 = get_post_meta($product->get_id(), '_arata_policy_commitment', true);
                            $policy2 = get_post_meta($product->get_id(), '_arata_policy_shipping', true);
                            $policy3 = get_post_meta($product->get_id(), '_arata_policy_returns', true);

                            // Use default if custom is empty
                            $policy1 = !empty($policy1) ? $policy1 : 'Cam kết 100% sản phẩm chính hãng từ Nhật Bản.';
                            $policy2 = !empty($policy2) ? $policy2 : 'Giao hàng toàn quốc, thanh toán linh hoạt.';
                            $policy3 = !empty($policy3) ? $policy3 : 'Hỗ trợ đổi trả trong 7 ngày nếu có lỗi từ nhà sản xuất.';
                            ?>
                            <ul class="space-y-3 text-gray-600 text-sm">
                                <li class="flex items-start">
                                    <span data-icon="shield-check" data-size="16" class="text-primary mr-3 mt-1"></span>
                                    <span><?php echo esc_html($policy1); ?></span>
                                </li>
                                <li class="flex items-start">
                                    <span data-icon="truck" data-size="16" class="text-primary mr-3 mt-1"></span>
                                    <span><?php echo esc_html($policy2); ?></span>
                                </li>
                                <li class="flex items-start">
                                    <span data-icon="refresh-cw" data-size="16" class="text-primary mr-3 mt-1"></span>
                                    <span><?php echo esc_html($policy3); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Tabs (Description, Reviews, etc.) -->
        <section class="py-12 bg-white">
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
                            <span class="text-primary">Liên Quan</span>
                        </h2>
                        <div class="w-24 h-1 bg-primary mx-auto mt-4"></div>
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
        <section class="py-12 bg-white border-t border-gray-200">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                        <span class="text-gray-700">Sản phẩm</span>
                        <span class="text-primary">Đã Xem</span>
                    </h2>
                    <div class="w-24 h-1 bg-primary mx-auto mt-4"></div>
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
