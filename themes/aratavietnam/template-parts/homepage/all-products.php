<?php
/**
 * Homepage All Products Section
 */
?>

<!-- All Products Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="flex items-center justify-center mb-4">
                <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                <span class="text-primary font-medium text-sm uppercase tracking-wider">Danh mục sản phẩm</span>
                <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                <span class="text-primary">TẤT CẢ</span> 
                <span class="text-secondary">SẢN PHẨM</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Khám phá đầy đủ các bộ sản phẩm hóa mỹ phẩm từ các thương hiệu hàng đầu Nhật Bản
            </p>
        </div>

        <!-- Product Categories Carousel -->
        <div class="relative">
            <!-- Carousel Container -->
            <div class="overflow-hidden">
                <div class="product-categories-carousel flex transition-transform duration-500 ease-in-out" id="categoriesCarousel">
                    <?php
                    // Get product categories
                    $product_categories = get_terms([
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => 0,
                        'number' => 10
                    ]);

                    if ($product_categories && !is_wp_error($product_categories)) :
                        foreach ($product_categories as $category) :
                            $category_image = get_term_meta($category->term_id, 'thumbnail_id', true);
                            $category_image_url = $category_image ? wp_get_attachment_image_src($category_image, 'medium')[0] : '';
                            $category_link = get_term_link($category);
                            $product_count = $category->count;
                            ?>
                            <div class="flex-none w-full sm:w-1/2 lg:w-1/3 xl:w-1/5 px-3">
                                <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-primary/30 h-full">
                                    <!-- Category Image -->
                                    <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-primary/5 to-secondary/5">
                                        <?php if ($category_image_url) : ?>
                                            <img src="<?php echo esc_url($category_image_url); ?>" 
                                                 alt="<?php echo esc_attr($category->name); ?>"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                        <?php else : ?>
                                            <div class="w-full h-full flex items-center justify-center">
                                                <div class="text-center">
                                                    <span data-icon="package" data-size="48" class="text-primary/60 mb-2"></span>
                                                    <p class="text-primary font-medium text-sm"><?php echo esc_html($category->name); ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        
                                        <!-- View Products Button -->
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <a href="<?php echo esc_url($category_link); ?>" 
                                               class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                Xem sản phẩm
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Category Info -->
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-primary transition-colors">
                                            <a href="<?php echo esc_url($category_link); ?>">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        </h3>
                                        
                                        <?php if ($category->description) : ?>
                                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                <?php echo esc_html($category->description); ?>
                                            </p>
                                        <?php endif; ?>

                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">
                                                <?php echo $product_count; ?> sản phẩm
                                            </span>
                                            <a href="<?php echo esc_url($category_link); ?>" 
                                               class="text-primary hover:text-primary-dark font-medium text-sm">
                                                Xem tất cả →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                    else :
                        // Fallback content if no categories
                        for ($i = 1; $i <= 5; $i++) :
                            ?>
                            <div class="flex-none w-full sm:w-1/2 lg:w-1/3 xl:w-1/5 px-3">
                                <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 h-full">
                                    <div class="aspect-square bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center">
                                        <div class="text-center">
                                            <span data-icon="package" data-size="48" class="text-gray-400 mb-2"></span>
                                            <p class="text-gray-600 font-medium">Danh mục <?php echo $i; ?></p>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-2">Sản phẩm mẫu <?php echo $i; ?></h3>
                                        <p class="text-sm text-gray-600 mb-3">Mô tả danh mục sản phẩm</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">0 sản phẩm</span>
                                            <span class="text-primary font-medium text-sm">Xem tất cả →</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endfor;
                    endif;
                    ?>
                </div>
            </div>

            <!-- Carousel Navigation -->
            <button class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-primary hover:shadow-xl transition-all duration-300 z-10" id="prevCategory">
                <span data-icon="chevron-left" data-size="20"></span>
            </button>
            <button class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-primary hover:shadow-xl transition-all duration-300 z-10" id="nextCategory">
                <span data-icon="chevron-right" data-size="20"></span>
            </button>
        </div>

        <!-- View All Categories Button -->
        <div class="text-center mt-12">
            <a href="<?php echo wc_get_page_permalink('shop'); ?>" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-secondary to-primary text-white font-semibold rounded-lg hover:from-secondary-dark hover:to-primary-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <span data-icon="grid" data-size="20" class="mr-2"></span>
                Xem tất cả danh mục
                <span data-icon="arrow-right" data-size="20" class="ml-2"></span>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('categoriesCarousel');
    const prevBtn = document.getElementById('prevCategory');
    const nextBtn = document.getElementById('nextCategory');
    const items = carousel.children;
    const totalItems = items.length;
    
    let currentIndex = 0;
    let itemsPerView = 5; // Default for xl screens
    
    // Calculate items per view based on screen size
    function updateItemsPerView() {
        if (window.innerWidth < 640) {
            itemsPerView = 1; // sm
        } else if (window.innerWidth < 1024) {
            itemsPerView = 2; // md
        } else if (window.innerWidth < 1280) {
            itemsPerView = 3; // lg
        } else {
            itemsPerView = 5; // xl
        }
    }
    
    function updateCarousel() {
        const translateX = -(currentIndex * (100 / itemsPerView));
        carousel.style.transform = `translateX(${translateX}%)`;
        
        // Update button states
        prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= totalItems - itemsPerView ? '0.5' : '1';
    }
    
    function nextSlide() {
        if (currentIndex < totalItems - itemsPerView) {
            currentIndex++;
            updateCarousel();
        }
    }
    
    function prevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    }
    
    // Event listeners
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    // Handle window resize
    window.addEventListener('resize', () => {
        updateItemsPerView();
        currentIndex = Math.min(currentIndex, Math.max(0, totalItems - itemsPerView));
        updateCarousel();
    });
    
    // Initialize
    updateItemsPerView();
    updateCarousel();
    
    // Auto-scroll (optional)
    let autoScrollInterval = setInterval(() => {
        if (currentIndex >= totalItems - itemsPerView) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        updateCarousel();
    }, 4000);
    
    // Pause auto-scroll on hover
    carousel.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
    carousel.addEventListener('mouseleave', () => {
        autoScrollInterval = setInterval(() => {
            if (currentIndex >= totalItems - itemsPerView) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
            updateCarousel();
        }, 4000);
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
