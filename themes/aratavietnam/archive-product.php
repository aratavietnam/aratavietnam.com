<?php
/**
 * The Template for displaying product archives, including the main shop page
 * Designed according to Arata Vietnam Brief requirements
 *
 * @package ArataVietnam
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-white">
    <!-- Page Header with Brand Colors -->
    <section class="page-header bg-gradient-to-r from-secondary/15 to-primary/10 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-primary mb-4">
                    <?php
                    if (is_shop()) {
                        echo __('TẤT CẢ SẢN PHẨM', 'aratavietnam');
                    } elseif (is_product_category()) {
                        echo strtoupper(single_cat_title('', false));
                    } elseif (is_product_tag()) {
                        echo strtoupper(single_tag_title('', false));
                    } else {
                        echo __('SẢN PHẨM', 'aratavietnam');
                    }
                    ?>
                </h1>

                <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>

                <?php if (is_product_category() && category_description()) : ?>
                    <div class="text-gray-600 max-w-2xl mx-auto text-lg">
                        <?php echo category_description(); ?>
                    </div>
                <?php endif; ?>

                <!-- Breadcrumb -->
                <nav class="mt-6">
                    <?php woocommerce_breadcrumb(array(
                        'delimiter' => ' <span class="text-gray-400 mx-2">/</span> ',
                        'wrap_before' => '<div class="text-sm text-gray-500 bg-white/50 rounded-full px-4 py-2 inline-block">',
                        'wrap_after' => '</div>',
                        'before' => '',
                        'after' => '',
                        'home' => __('Trang chủ', 'aratavietnam'),
                    )); ?>
                </nav>
            </div>
        </div>
    </section>

    <!-- 8 Product Collections Section (According to Brief) -->
    <section class="bg-secondary/5 py-12">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">8 BỘ SẢN PHẨM ARATA</h2>
                <div class="w-24 h-1 bg-primary mx-auto"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <?php
                // Define 8 product collections according to brief
                $product_collections = array(
                    array('name' => 'Chăm sóc da mặt', 'slug' => 'cham-soc-da-mat', 'icon' => '🧴'),
                    array('name' => 'Làm sạch', 'slug' => 'lam-sach', 'icon' => '🧽'),
                    array('name' => 'Dưỡng ẩm', 'slug' => 'duong-am', 'icon' => '💧'),
                    array('name' => 'Chống lão hóa', 'slug' => 'chong-lao-hoa', 'icon' => '✨'),
                    array('name' => 'Làm sáng da', 'slug' => 'lam-sang-da', 'icon' => '☀️'),
                    array('name' => 'Trị mụn', 'slug' => 'tri-mun', 'icon' => '🎯'),
                    array('name' => 'Chăm sóc mắt', 'slug' => 'cham-soc-mat', 'icon' => '👁️'),
                    array('name' => 'Kem chống nắng', 'slug' => 'kem-chong-nang', 'icon' => '🌞')
                );

                foreach ($product_collections as $index => $collection) :
                    $term = get_term_by('slug', $collection['slug'], 'product_cat');
                    $count = $term ? $term->count : 0;
                    $link = $term ? get_term_link($term) : '#';
                ?>
                    <div class="product-collection-card bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer group"
                         data-collection="<?php echo esc_attr($collection['slug']); ?>">
                        <div class="text-center">
                            <div class="text-3xl mb-2"><?php echo $collection['icon']; ?></div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-primary transition-colors duration-200">
                                <?php echo esc_html($collection['name']); ?>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1"><?php echo $count; ?> sản phẩm</p>

                            <!-- Dropdown arrow -->
                            <div class="mt-2">
                                <svg class="w-4 h-4 mx-auto text-gray-400 group-hover:text-primary transition-all duration-200 transform group-hover:rotate-180"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Hidden subcategories (will be shown on click) -->
                        <div class="subcategories hidden mt-4 pt-4 border-t border-gray-100">
                            <div class="space-y-2">
                                <?php if ($term) : ?>
                                    <a href="<?php echo esc_url($link); ?>"
                                       class="block text-sm text-gray-600 hover:text-primary transition-colors duration-200 py-1">
                                        Xem tất cả <?php echo esc_html($collection['name']); ?>
                                    </a>
                                <?php endif; ?>
                                <!-- Add more subcategories here if needed -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-secondary mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Danh mục sản phẩm
                    </h3>

                    <?php
                    // Get product categories
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'exclude' => array(get_option('default_product_cat'))
                    ));

                    if (!empty($product_categories)) :
                    ?>
                        <ul class="space-y-1">
                            <li>
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                                   class="block py-3 px-4 rounded-lg text-gray-600 hover:bg-primary/10 hover:text-primary transition-all duration-200 border-l-3 hover:border-l-primary <?php echo is_shop() && !is_product_category() ? 'bg-primary/10 text-primary font-semibold border-l-primary' : 'border-l-transparent'; ?>">
                                    <span class="flex items-center justify-between">
                                        Tất cả sản phẩm
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                            <?php echo wp_count_posts('product')->publish; ?>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <?php foreach ($product_categories as $category) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>"
                                       class="block py-3 px-4 rounded-lg text-gray-600 hover:bg-primary/10 hover:text-primary transition-all duration-200 border-l-3 hover:border-l-primary <?php echo is_product_category($category->slug) ? 'bg-primary/10 text-primary font-semibold border-l-primary' : 'border-l-transparent'; ?>">
                                        <span class="flex items-center justify-between">
                                            <?php echo esc_html($category->name); ?>
                                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                                <?php echo $category->count; ?>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class="text-gray-500 text-sm">Chưa có danh mục sản phẩm</p>
                    <?php endif; ?>
                </div>

                <!-- Price Filter -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100 mt-6">
                    <h3 class="text-lg font-semibold text-secondary mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Lọc theo giá
                    </h3>
                    <?php the_widget('WC_Widget_Price_Filter'); ?>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <?php if (woocommerce_product_loop()) : ?>
                    <!-- Toolbar with Brand Styling -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 bg-white rounded-lg p-6 shadow-sm border border-gray-100">
                        <div class="mb-4 sm:mb-0">
                            <div class="text-secondary font-semibold">
                                <?php woocommerce_result_count(); ?>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <label class="text-sm font-medium text-gray-700">Sắp xếp:</label>
                            <?php woocommerce_catalog_ordering(); ?>
                        </div>
                    </div>

                    <!-- Products Grid with Enhanced Design -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
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
                            <div class="product-card bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 group">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="block">
                                    <div class="aspect-square overflow-hidden relative bg-gray-50">
                                        <?php if ($product->get_image_id()) : ?>
                                            <?php echo wp_get_attachment_image($product->get_image_id(), 'medium', false, array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500')); ?>
                                        <?php else : ?>
                                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-gray-400 text-sm">Chưa có ảnh</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Sale Badge with Brand Colors -->
                                        <?php if ($product->is_on_sale()) : ?>
                                            <span class="absolute top-3 left-3 bg-gradient-to-r from-primary to-tertiary text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                                SALE
                                            </span>
                                        <?php endif; ?>

                                        <!-- Featured Badge -->
                                        <?php if ($product->is_featured()) : ?>
                                            <span class="absolute top-3 right-3 bg-secondary text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                                NỔI BẬT
                                            </span>
                                        <?php endif; ?>

                                        <!-- Quick View Overlay -->
                                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                            <span class="bg-white text-gray-800 px-4 py-2 rounded-lg font-medium shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                Xem chi tiết
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <h3 class="font-semibold text-gray-800 mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 text-lg leading-tight">
                                            <?php echo esc_html($product->get_name()); ?>
                                        </h3>

                                        <!-- Product Rating -->
                                        <?php if ($product->get_average_rating()) : ?>
                                            <div class="flex items-center mb-3">
                                                <div class="flex text-tertiary text-sm">
                                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                        <svg class="w-4 h-4 <?php echo $i <= $product->get_average_rating() ? 'fill-current' : 'text-gray-300'; ?>" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    <?php endfor; ?>
                                                </div>
                                                <span class="text-sm text-gray-500 ml-2">(<?php echo $product->get_review_count(); ?>)</span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="text-primary font-bold text-xl mb-4">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>

                                        <!-- Add to Cart Button with Brand Styling -->
                                        <div class="mt-auto">
                                            <?php
                                            $button_text = $product->add_to_cart_text();
                                            $button_class = 'w-full text-center py-3 px-6 rounded-lg font-semibold transition-all duration-200 transform hover:scale-105 shadow-sm';

                                            if ($product->is_purchasable() && $product->is_in_stock()) {
                                                $button_class .= ' bg-gradient-to-r from-primary to-primary-dark text-white hover:shadow-lg';
                                            } else {
                                                $button_class .= ' bg-gray-200 text-gray-500 cursor-not-allowed';
                                                $button_text = 'Hết hàng';
                                            }

                                            echo apply_filters(
                                                'woocommerce_loop_add_to_cart_link',
                                                sprintf(
                                                    '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                                    esc_url($product->add_to_cart_url()),
                                                    esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                                                    esc_attr($button_class),
                                                    isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                                                    esc_html($button_text)
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

                    <!-- Enhanced Pagination -->
                    <div class="mt-12 flex justify-center">
                        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                            <?php woocommerce_pagination(); ?>
                        </div>
                    </div>

                <?php else : ?>
                    <!-- No Products Found with Enhanced Design -->
                    <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="max-w-md mx-auto">
                            <div class="mb-6">
                                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">Hiện tại chưa có sản phẩm nào trong danh mục này.<br>Hãy thử tìm kiếm với từ khóa khác hoặc xem tất cả sản phẩm.</p>
                            <div class="space-y-3">
                                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                                   class="inline-block bg-gradient-to-r from-primary to-primary-dark text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    Xem tất cả sản phẩm
                                </a>
                                <div class="text-sm text-gray-500">
                                    hoặc <a href="<?php echo esc_url(home_url('/')); ?>" class="text-primary hover:text-primary-dark font-medium">về trang chủ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript for Product Collections Interaction -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product collection cards interaction
    const collectionCards = document.querySelectorAll('.product-collection-card');

    collectionCards.forEach(card => {
        card.addEventListener('click', function() {
            const subcategories = this.querySelector('.subcategories');
            const arrow = this.querySelector('svg');

            // Toggle subcategories
            if (subcategories.classList.contains('hidden')) {
                // Close all other subcategories
                collectionCards.forEach(otherCard => {
                    if (otherCard !== this) {
                        otherCard.querySelector('.subcategories').classList.add('hidden');
                        otherCard.querySelector('svg').classList.remove('rotate-180');
                    }
                });

                // Open this subcategory
                subcategories.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                // Close this subcategory
                subcategories.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        });
    });

    // Enhanced hover effects for product cards
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll for collection navigation
    const collectionLinks = document.querySelectorAll('.product-collection-card a');

    collectionLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading animation
            const card = this.closest('.product-collection-card');
            card.style.opacity = '0.7';
            card.style.transform = 'scale(0.98)';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
            }, 200);
        });
    });
});
</script>

<style>
/* Additional CSS for enhanced product page styling */
.product-collection-card {
    transition: all 0.3s ease;
}

.product-collection-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.product-card {
    transition: all 0.3s ease;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom styling for WooCommerce elements */
.woocommerce-ordering select {
    @apply border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent;
}

.woocommerce-result-count {
    @apply text-gray-600;
}

/* Pagination styling */
.woocommerce-pagination {
    @apply flex justify-center;
}

.woocommerce-pagination .page-numbers {
    @apply mx-1 px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200;
}

.woocommerce-pagination .page-numbers.current {
    @apply bg-primary text-white border-primary;
}
</style>

<?php get_footer(); ?>
