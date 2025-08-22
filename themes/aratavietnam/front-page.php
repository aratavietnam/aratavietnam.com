<?php
/**
 * Front Page Template - Arata Vietnam Homepage
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-white">
    <!-- Hero Banner Section -->
    <section class="hero-banner bg-gradient-to-r from-primary/10 to-secondary/10 py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4">
                ARATA VIETNAM
            </h1>
            <p class="text-xl md:text-2xl text-primary font-semibold mb-8">
                NHÀ PHÂN PHỐI HÓA MỸ PHẨM HÀNG ĐẦU NHẬT BẢN
            </p>
            <?php if (class_exists('WooCommerce')) : ?>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="inline-block bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors duration-300">
                Khám phá sản phẩm
            </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Featured Products Section -->
    <?php if (class_exists('WooCommerce')) : ?>
    <section class="featured-products py-16 bg-secondary/5">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">SẢN PHẨM NỔI BẬT</h2>
                <div class="w-24 h-1 bg-primary mx-auto"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php
                // Get featured products
                $featured_products = wc_get_featured_product_ids();
                if (empty($featured_products)) {
                    // If no featured products, get latest products
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 8,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => '_visibility',
                                'value' => array('catalog', 'visible'),
                                'compare' => 'IN'
                            )
                        )
                    );
                    $products = get_posts($args);
                } else {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 8,
                        'post__in' => array_slice($featured_products, 0, 8),
                        'post_status' => 'publish'
                    );
                    $products = get_posts($args);
                }

                foreach ($products as $product_post) :
                    $product = wc_get_product($product_post->ID);
                    if (!$product) continue;
                ?>
                    <div class="product-card bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="block">
                            <div class="aspect-square overflow-hidden">
                                <?php if ($product->get_image_id()) : ?>
                                    <?php echo wp_get_attachment_image($product->get_image_id(), 'medium', false, array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300')); ?>
                                <?php else : ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2"><?php echo esc_html($product->get_name()); ?></h3>
                                <div class="text-primary font-bold text-lg">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-8">
                <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors duration-300">
                    Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    </section>

    <!-- All Products Section -->
    <section class="all-products py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">TẤT CẢ SẢN PHẨM</h2>
                <div class="w-24 h-1 bg-primary mx-auto"></div>
            </div>

            <!-- Product Categories Carousel -->
            <div class="relative">
                <div class="overflow-hidden">
                    <div class="flex space-x-6 pb-4" id="categories-carousel">
                        <?php
                        // Get product categories
                        $product_categories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => false,
                            'number' => 8,
                            'exclude' => array(get_option('default_product_cat'))
                        ));

                        if (!empty($product_categories)) :
                            foreach ($product_categories as $category) :
                                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                $category_link = get_term_link($category);
                        ?>
                            <div class="flex-shrink-0 w-64">
                                <a href="<?php echo esc_url($category_link); ?>" class="block bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                                    <div class="aspect-square overflow-hidden">
                                        <?php if ($thumbnail_id) : ?>
                                            <?php echo wp_get_attachment_image($thumbnail_id, 'medium', false, array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300')); ?>
                                        <?php else : ?>
                                            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                                <span class="text-primary font-semibold text-lg"><?php echo esc_html($category->name); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-4 text-center">
                                        <h3 class="font-semibold text-gray-800 mb-1"><?php echo esc_html($category->name); ?></h3>
                                        <p class="text-sm text-gray-500"><?php echo esc_html($category->count); ?> sản phẩm</p>
                                    </div>
                                </a>
                            </div>
                        <?php
                            endforeach;
                        else :
                            // Show placeholder categories if none exist
                            $placeholder_categories = array(
                                'Chăm sóc da mặt', 'Trang điểm', 'Chăm sóc cơ thể',
                                'Chăm sóc tóc', 'Nước hoa', 'Sản phẩm nam',
                                'Sản phẩm trẻ em', 'Phụ kiện làm đẹp'
                            );
                            foreach ($placeholder_categories as $cat_name) :
                        ?>
                            <div class="flex-shrink-0 w-64">
                                <div class="block bg-white rounded-lg shadow-sm overflow-hidden">
                                    <div class="aspect-square overflow-hidden">
                                        <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                            <span class="text-primary font-semibold text-lg"><?php echo esc_html($cat_name); ?></span>
                                        </div>
                                    </div>
                                    <div class="p-4 text-center">
                                        <h3 class="font-semibold text-gray-800 mb-1"><?php echo esc_html($cat_name); ?></h3>
                                        <p class="text-sm text-gray-500">Sắp có sản phẩm</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>

                <!-- Carousel Navigation -->
                <button class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-2 shadow-md hover:shadow-lg transition-shadow duration-300" id="prev-btn">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-2 shadow-md hover:shadow-lg transition-shadow duration-300" id="next-btn">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- About Section -->
    <section class="about-section py-16 bg-secondary/5">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Về Arata Vietnam</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản, được thành lập với sứ mệnh mang đến cho người tiêu dùng Việt Nam những sản phẩm hóa mỹ phẩm chất lượng cao nhất từ Nhật Bản.
                    </p>
                    <a href="<?php echo esc_url(home_url('/ve-arata')); ?>" class="inline-block bg-secondary text-white px-6 py-3 rounded-lg font-semibold hover:bg-secondary-dark transition-colors duration-300">
                        Tìm hiểu thêm
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="aspect-square bg-gradient-to-br from-primary/20 to-secondary/20 rounded-lg"></div>
                    <div class="aspect-square bg-gradient-to-br from-secondary/20 to-tertiary/20 rounded-lg"></div>
                    <div class="aspect-square bg-gradient-to-br from-tertiary/20 to-primary/20 rounded-lg"></div>
                    <div class="aspect-square bg-gradient-to-br from-primary/30 to-secondary/30 rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('categories-carousel');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    if (carousel && prevBtn && nextBtn) {
        let scrollAmount = 0;
        const cardWidth = 256 + 24; // w-64 + gap-6

        nextBtn.addEventListener('click', function() {
            scrollAmount += cardWidth;
            if (scrollAmount > carousel.scrollWidth - carousel.clientWidth) {
                scrollAmount = 0;
            }
            carousel.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        prevBtn.addEventListener('click', function() {
            scrollAmount -= cardWidth;
            if (scrollAmount < 0) {
                scrollAmount = carousel.scrollWidth - carousel.clientWidth;
            }
            carousel.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }
});
</script>

<?php get_footer(); ?>
