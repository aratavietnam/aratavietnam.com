<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * @package ArataVietnam
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <section class="page-header bg-gradient-to-r from-primary/10 to-secondary/10 py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    <?php
                    if (is_shop()) {
                        echo __('Tất cả sản phẩm', 'aratavietnam');
                    } elseif (is_product_category()) {
                        single_cat_title();
                    } elseif (is_product_tag()) {
                        single_tag_title();
                    } else {
                        echo __('Sản phẩm', 'aratavietnam');
                    }
                    ?>
                </h1>
                
                <?php if (is_product_category() && category_description()) : ?>
                    <div class="text-gray-600 max-w-2xl mx-auto">
                        <?php echo category_description(); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Breadcrumb -->
                <nav class="mt-4">
                    <?php woocommerce_breadcrumb(array(
                        'delimiter' => ' <span class="text-gray-400">/</span> ',
                        'wrap_before' => '<div class="text-sm text-gray-500">',
                        'wrap_after' => '</div>',
                        'before' => '',
                        'after' => '',
                        'home' => __('Trang chủ', 'aratavietnam'),
                    )); ?>
                </nav>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Danh mục sản phẩm</h3>
                    
                    <?php
                    // Get product categories
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'exclude' => array(get_option('default_product_cat'))
                    ));

                    if (!empty($product_categories)) :
                    ?>
                        <ul class="space-y-2">
                            <li>
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" 
                                   class="block py-2 px-3 rounded-lg text-gray-600 hover:bg-primary/10 hover:text-primary transition-colors duration-200 <?php echo is_shop() && !is_product_category() ? 'bg-primary/10 text-primary font-semibold' : ''; ?>">
                                    Tất cả sản phẩm
                                </a>
                            </li>
                            <?php foreach ($product_categories as $category) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" 
                                       class="block py-2 px-3 rounded-lg text-gray-600 hover:bg-primary/10 hover:text-primary transition-colors duration-200 <?php echo is_product_category($category->slug) ? 'bg-primary/10 text-primary font-semibold' : ''; ?>">
                                        <?php echo esc_html($category->name); ?>
                                        <span class="text-xs text-gray-400 ml-1">(<?php echo $category->count; ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="text-gray-500 text-sm">Chưa có danh mục sản phẩm</p>
                    <?php endif; ?>
                </div>

                <!-- Price Filter -->
                <div class="bg-white rounded-lg p-6 shadow-sm mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Lọc theo giá</h3>
                    <?php the_widget('WC_Widget_Price_Filter'); ?>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <?php if (woocommerce_product_loop()) : ?>
                    <!-- Toolbar -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 bg-white rounded-lg p-4 shadow-sm">
                        <div class="mb-4 sm:mb-0">
                            <?php woocommerce_result_count(); ?>
                        </div>
                        <div class="flex items-center space-x-4">
                            <?php woocommerce_catalog_ordering(); ?>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php
                        woocommerce_product_loop_start();

                        if (wc_get_loop_prop('is_shortcode')) {
                            $columns = absint(wc_get_loop_prop('columns'));
                        } else {
                            $columns = wc_get_default_products_per_row();
                        }

                        while (have_posts()) :
                            the_post();
                            global $product;
                        ?>
                            <div class="product-card bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="block">
                                    <div class="aspect-square overflow-hidden relative">
                                        <?php if ($product->get_image_id()) : ?>
                                            <?php echo wp_get_attachment_image($product->get_image_id(), 'medium', false, array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300')); ?>
                                        <?php else : ?>
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400">No Image</span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Sale Badge -->
                                        <?php if ($product->is_on_sale()) : ?>
                                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                                Sale
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-primary transition-colors duration-200">
                                            <?php echo esc_html($product->get_name()); ?>
                                        </h3>
                                        
                                        <div class="text-primary font-bold text-lg mb-3">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>
                                        
                                        <!-- Add to Cart Button -->
                                        <div class="mt-auto">
                                            <?php
                                            echo apply_filters(
                                                'woocommerce_loop_add_to_cart_link',
                                                sprintf(
                                                    '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                    esc_url($product->add_to_cart_url()),
                                                    esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                                                    esc_attr('btn-primary w-full text-center py-2 px-4 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-200'),
                                                    isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                                                    esc_html($product->add_to_cart_text())
                                                ),
                                                $product,
                                                $args ?? array()
                                            );
                                            ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php woocommerce_product_loop_end(); ?>

                    <!-- Pagination -->
                    <div class="mt-8">
                        <?php woocommerce_pagination(); ?>
                    </div>

                <?php else : ?>
                    <!-- No Products Found -->
                    <div class="text-center py-16 bg-white rounded-lg shadow-sm">
                        <div class="max-w-md mx-auto">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-600 mb-6">Hiện tại chưa có sản phẩm nào trong danh mục này.</p>
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors duration-300">
                                Xem tất cả sản phẩm
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
