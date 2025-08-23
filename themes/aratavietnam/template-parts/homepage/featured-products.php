<?php
/**
 * Homepage Featured Products Section
 */
?>

<!-- Featured Products Section -->
<section id="featured-products" class="py-16 bg-gradient-to-br from-secondary/10 to-primary/5">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="flex items-center justify-center mb-4">
                <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                <span class="text-primary font-medium text-sm uppercase tracking-wider">Sản phẩm nổi bật</span>
                <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                <span class="text-primary">SẢN PHẨM</span> 
                <span class="text-secondary">NỔI BẬT</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Khám phá những sản phẩm hóa mỹ phẩm chất lượng cao được nhập khẩu trực tiếp từ Nhật Bản
            </p>
        </div>

        <!-- Products Grid (4x2) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <?php
            // Get featured products (8 products for 4x2 grid)
            $featured_products = wc_get_products([
                'limit' => 8,
                'status' => 'publish',
                'featured' => true,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);

            if (empty($featured_products)) {
                // Fallback to latest products if no featured products
                $featured_products = wc_get_products([
                    'limit' => 8,
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);
            }

            if ($featured_products) :
                foreach ($featured_products as $product) :
                    $product_id = $product->get_id();
                    $product_name = $product->get_name();
                    $product_price = $product->get_price_html();
                    $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                    $product_link = get_permalink($product_id);
                    $on_sale = $product->is_on_sale();
                    ?>
                    <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-primary/30">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-50">
                            <?php if ($product_image) : ?>
                                <img src="<?php echo esc_url($product_image[0]); ?>" 
                                     alt="<?php echo esc_attr($product_name); ?>"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <?php else : ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                    <span data-icon="package" data-size="48" class="text-gray-400"></span>
                                </div>
                            <?php endif; ?>

                            <!-- Sale Badge -->
                            <?php if ($on_sale) : ?>
                                <div class="absolute top-3 left-3">
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        SALE
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Quick View Button -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <a href="<?php echo esc_url($product_link); ?>" 
                                   class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                <a href="<?php echo esc_url($product_link); ?>">
                                    <?php echo esc_html($product_name); ?>
                                </a>
                            </h3>

                            <!-- Price -->
                            <div class="flex items-center justify-between">
                                <div class="text-lg font-bold text-primary">
                                    <?php echo $product_price; ?>
                                </div>

                                <!-- Add to Cart Button -->
                                <button class="add-to-cart-btn bg-primary text-white p-2 rounded-lg hover:bg-primary-dark transition-colors" 
                                        data-product-id="<?php echo $product_id; ?>"
                                        title="Thêm vào giỏ hàng">
                                    <span data-icon="shopping-cart" data-size="16"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            else :
                ?>
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span data-icon="package" data-size="32" class="text-gray-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có sản phẩm nào</h3>
                    <p class="text-gray-500">Vui lòng thêm sản phẩm trong admin panel.</p>
                </div>
                <?php
            endif;
            ?>
        </div>

        <!-- View All Products Button -->
        <div class="text-center">
            <a href="<?php echo wc_get_page_permalink('shop'); ?>" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-lg hover:from-primary-dark hover:to-secondary-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <span data-icon="grid" data-size="20" class="mr-2"></span>
                Xem tất cả sản phẩm
                <span data-icon="arrow-right" data-size="20" class="ml-2"></span>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const originalIcon = this.innerHTML;
            
            // Show loading state
            this.innerHTML = '<span data-icon="loader" data-size="16" class="animate-spin"></span>';
            this.disabled = true;
            
            // AJAX add to cart
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'action': 'woocommerce_add_to_cart',
                    'product_id': productId,
                    'quantity': 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    this.innerHTML = '<span data-icon="check" data-size="16"></span>';
                    this.classList.remove('bg-primary', 'hover:bg-primary-dark');
                    this.classList.add('bg-green-500', 'hover:bg-green-600');
                    
                    // Update cart count if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cart_count) {
                        cartCount.textContent = data.cart_count;
                    }
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                        this.classList.remove('bg-green-500', 'hover:bg-green-600');
                        this.classList.add('bg-primary', 'hover:bg-primary-dark');
                        this.disabled = false;
                    }, 2000);
                } else {
                    // Show error state
                    this.innerHTML = '<span data-icon="x" data-size="16"></span>';
                    this.classList.remove('bg-primary', 'hover:bg-primary-dark');
                    this.classList.add('bg-red-500', 'hover:bg-red-600');
                    
                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                        this.classList.remove('bg-red-500', 'hover:bg-red-600');
                        this.classList.add('bg-primary', 'hover:bg-primary-dark');
                        this.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = originalIcon;
                this.disabled = false;
            });
        });
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
