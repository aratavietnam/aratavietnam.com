<?php
if (!defined('ABSPATH')) { exit; }

// Set products per page for WooCommerce
add_filter('loop_shop_per_page', function() {
    return 12; // Show 12 products per page (4 columns x 3 rows)
}, 20);

?>
<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary/3 via-white to-secondary/3 border-b border-gray-100">
    <div class="absolute inset-0 bg-white/80 backdrop-blur-sm"></div>
    <div class="relative container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Compact title indicator -->
            <div class="inline-flex items-center mb-3">
                <div class="w-8 h-0.5 bg-primary rounded-full mr-3"></div>
                <span class="text-primary font-medium text-xs uppercase tracking-widest">Sản phẩm</span>
                <div class="w-8 h-0.5 bg-primary rounded-full ml-3"></div>
            </div>

            <!-- Smaller, more elegant title -->
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">
                Khám phá sản phẩm chất lượng cao
            </h1>

            <!-- Compact description -->
            <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl mx-auto">
                Các sản phẩm hóa mỹ phẩm được nhập khẩu trực tiếp từ Nhật Bản, đảm bảo chất lượng và an toàn cho người sử dụng
            </p>
        </div>
    </div>
</section>

<main id="site-content" class="bg-white">
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-8">

                <!-- Sidebar - Product Categories & Filters (1/4) -->
                <aside class="lg:col-span-1 mb-6 lg:mb-0">
                    <div class="sticky top-24 space-y-4">

                        <!-- Product Categories -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                                    <span data-icon="grid" data-size="16" class="text-primary mr-2"></span>
                                    Danh mục sản phẩm
                                </h3>
                            </div>

                            <div class="p-3">
                                <div class="space-y-1">
                                    <?php
                                    $product_categories = get_terms([
                                        'taxonomy' => 'product_cat',
                                        'hide_empty' => true,
                                        'parent' => 0, // Only top-level categories
                                    ]);

                                    if (!empty($product_categories) && !is_wp_error($product_categories)) :
                                        foreach ($product_categories as $category) :
                                            $category_link = get_term_link($category);
                                            $is_current = is_tax('product_cat', $category->term_id);

                                            // Get sub-categories
                                            $sub_categories = get_terms([
                                                'taxonomy' => 'product_cat',
                                                'hide_empty' => true,
                                                'parent' => $category->term_id,
                                            ]);

                                            $has_children = !empty($sub_categories) && !is_wp_error($sub_categories);
                                            ?>
                                            <div class="border-b border-gray-100 last:border-b-0">
                                                <div class="flex items-center justify-between group">
                                                    <a href="<?php echo esc_url($category_link); ?>"
                                                       class="flex-1 py-2 px-2 text-gray-700 hover:text-primary hover:bg-primary/5 rounded transition-all duration-200 group-hover:bg-primary/5 <?php echo $is_current ? 'text-primary bg-primary/10 font-semibold' : ''; ?>">
                                                        <?php echo esc_html($category->name); ?>
                                                        <span class="text-xs text-gray-400 ml-2 bg-gray-100 px-1.5 py-0.5 rounded-full"><?php echo $category->count; ?></span>
                                                    </a>

                                                    <?php if ($has_children) : ?>
                                                        <button class="category-toggle p-1.5 text-gray-400 hover:text-primary hover:bg-primary/5 rounded transition-all duration-200"
                                                                data-category="<?php echo $category->term_id; ?>">
                                                            <span data-icon="chevron-down" data-size="14" class="category-icon transition-transform duration-200"></span>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if ($has_children) : ?>
                                                    <div class="subcategories hidden ml-3" id="subcategories-<?php echo $category->term_id; ?>">
                                                        <?php foreach ($sub_categories as $sub_category) :
                                                            $sub_category_link = get_term_link($sub_category);
                                                            $is_current_sub = is_tax('product_cat', $sub_category->term_id);
                                                            ?>
                                                            <a href="<?php echo esc_url($sub_category_link); ?>"
                                                               class="block py-1.5 px-3 text-sm text-gray-600 hover:text-primary hover:bg-primary/5 rounded transition-all duration-200 <?php echo $is_current_sub ? 'text-primary bg-primary/10 font-medium' : ''; ?>">
                                                                <span class="w-1.5 h-1.5 bg-gray-300 rounded-full inline-block mr-1.5"></span>
                                                                <?php echo esc_html($sub_category->name); ?>
                                                                <span class="text-xs text-gray-400 ml-1.5 bg-gray-50 px-1 py-0.5 rounded"><?php echo $sub_category->count; ?></span>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                                    <span data-icon="tag" data-size="16" class="text-primary mr-2"></span>
                                    Lọc theo giá
                                </h3>
                            </div>
                            <div class="p-3">
                                <div class="space-y-2">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_filter" value="all" class="mr-2 text-primary" checked>
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">Tất cả giá</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_filter" value="0-100000" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">Dưới 100.000₫</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_filter" value="100000-300000" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">100.000₫ - 300.000₫</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_filter" value="300000-500000" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">300.000₫ - 500.000₫</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_filter" value="500000+" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">Trên 500.000₫</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                                    <span data-icon="star" data-size="16" class="text-primary mr-2"></span>
                                    Thương hiệu
                                </h3>
                            </div>
                            <div class="p-3">
                                <div class="space-y-2">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="bijinnuka" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">Bijinnuka</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="es-healthy" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">ES Healthy</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="jellan" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">JELLAN</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="purevivi" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">Purevivi</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="paenna" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">PAENNA</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="to-plan" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">TO-PLAN</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" name="brand_filter[]" value="tokyo-fruits" class="mr-2 text-primary">
                                        <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">TOKYO FRUITS</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Clear Filters Button -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="p-3">
                                <button id="clear-filters" class="w-full bg-primary text-white py-2 px-3 rounded hover:bg-primary-dark transition-all duration-200 font-medium">
                                    <span data-icon="refresh" data-size="14" class="mr-2"></span>
                                    Xóa bộ lọc
                                </button>
                            </div>
                        </div>

                    </div>
                </aside>

                <!-- Main Content - Product Grid (3/4) -->
                <div class="lg:col-span-3">
                    <?php if (have_posts()) : ?>
                        <!-- Products Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                            <?php while (have_posts()) : the_post(); ?>
                                <article class="group h-full">
                                    <div class="bg-white rounded-lg border border-gray-200 hover:border-primary/30 transition-all duration-300 overflow-hidden h-full flex flex-col">
                                        <!-- Product Image -->
                                        <div class="aspect-square overflow-hidden bg-gray-50 flex-shrink-0 relative">
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
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <a href="<?php the_permalink(); ?>" class="bg-white text-primary px-3 py-1.5 rounded font-medium hover:bg-primary hover:text-white transition-colors text-sm">
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
                                                        <span class="text-base font-bold text-primary"><?php echo number_format($sale_price); ?>₫</span>
                                                        <span class="text-sm text-gray-500 line-through"><?php echo number_format($regular_price); ?>₫</span>
                                                    </div>
                                                    <?php
                                                elseif ($price) :
                                                    ?>
                                                    <span class="text-base font-bold text-primary"><?php echo number_format($price); ?>₫</span>
                                                    <?php
                                                else :
                                                    ?>
                                                    <span class="text-base font-bold text-primary">Liên hệ</span>
                                                    <?php
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            <?php
                            // Get pagination info
                            global $wp_query;
                            $total_pages = $wp_query->max_num_pages;
                            $current_page = max(1, get_query_var('paged'));

                            if ($total_pages > 1) :
                                ?>
                                <nav class="flex items-center justify-center space-x-1" aria-label="Phân trang sản phẩm">
                                    <!-- Previous Page -->
                                    <?php if ($current_page > 1) : ?>
                                        <a href="<?php echo get_pagenum_link($current_page - 1); ?>"
                                           class="px-3 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors">
                                            <span data-icon="chevron-left" data-size="16"></span>
                                        </a>
                                    <?php endif; ?>

                                    <!-- Page Numbers -->
                                    <?php
                                    $start_page = max(1, $current_page - 2);
                                    $end_page = min($total_pages, $current_page + 2);

                                    // Show first page if not in range
                                    if ($start_page > 1) :
                                        ?>
                                        <a href="<?php echo get_pagenum_link(1); ?>"
                                           class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            1
                                        </a>
                                        <?php if ($start_page > 2) : ?>
                                            <span class="px-2 py-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                        <?php
                                    endif;

                                    // Show page numbers in range
                                    for ($i = $start_page; $i <= $end_page; $i++) :
                                        if ($i == $current_page) :
                                            ?>
                                            <span class="px-3 py-2 text-white bg-primary border border-primary rounded-lg">
                                                <?php echo $i; ?>
                                            </span>
                                            <?php
                                        else :
                                            ?>
                                            <a href="<?php echo get_pagenum_link($i); ?>"
                                               class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                                <?php echo $i; ?>
                                            </a>
                                            <?php
                                        endif;
                                    endfor;

                                    // Show last page if not in range
                                    if ($end_page < $total_pages) :
                                        if ($end_page < $total_pages - 1) : ?>
                                            <span class="px-2 py-2 text-gray-500">...</span>
                                        <?php endif; ?>
                                        <a href="<?php echo get_pagenum_link($total_pages); ?>"
                                           class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            <?php echo $total_pages; ?>
                                        </a>
                                        <?php
                                    endif;
                                    ?>

                                    <!-- Next Page -->
                                    <?php if ($current_page < $total_pages) : ?>
                                        <a href="<?php echo get_pagenum_link($current_page + 1); ?>"
                                           class="px-3 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors">
                                            <span data-icon="chevron-right" data-size="16"></span>
                                        </a>
                                    <?php endif; ?>
                                </nav>

                                <!-- Page Info -->
                                <div class="text-center mt-4 text-sm text-gray-500">
                                    Trang <?php echo $current_page; ?> của <?php echo $total_pages; ?>
                                    (<?php echo $wp_query->found_posts; ?> sản phẩm)
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>

                    <?php else : ?>
                        <!-- No Products Found -->
                        <div class="text-center py-16">
                            <div class="text-gray-400 mb-4">
                                <span data-icon="package" data-size="64"></span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-600">Vui lòng thử lại với bộ lọc khác hoặc quay lại sau.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Custom styles for product page */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.category-icon {
    transition: transform 0.2s ease-in-out;
}

.subcategories {
    transition: all 0.3s ease-in-out;
}

/* Filter hover effects */
input[type="radio"]:checked + span,
input[type="checkbox"]:checked + span {
    color: rgb(59, 130, 246);
    font-weight: 500;
}

/* Button animations */
.add-to-cart-btn:hover {
    transform: translateY(-1px);
}

.add-to-cart-btn:active {
    transform: translateY(0);
}

/* Loading animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Responsive improvements */
@media (max-width: 1024px) {
    .sticky {
        position: relative;
        top: auto;
    }
}

/* Custom scrollbar for subcategories */
.subcategories::-webkit-scrollbar {
    width: 4px;
}

.subcategories::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.subcategories::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.subcategories::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category toggle functionality
    const categoryToggles = document.querySelectorAll('.category-toggle');

    categoryToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category');
            const subcategories = document.getElementById(`subcategories-${categoryId}`);
            const icon = this.querySelector('.category-icon');

            if (subcategories.classList.contains('hidden')) {
                subcategories.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                subcategories.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Filter functionality
    const priceFilters = document.querySelectorAll('input[name="price_filter"]');
    const brandFilters = document.querySelectorAll('input[name="brand_filter[]"]');
    const clearFiltersBtn = document.getElementById('clear-filters');

    // Load saved filter state
    function loadFilterState() {
        const savedPrice = localStorage.getItem('product_price_filter');
        const savedBrands = localStorage.getItem('product_brand_filters');

        if (savedPrice) {
            document.querySelector(`input[name="price_filter"][value="${savedPrice}"]`).checked = true;
        }

        if (savedBrands) {
            const brands = JSON.parse(savedBrands);
            brands.forEach(brand => {
                const checkbox = document.querySelector(`input[name="brand_filter[]"][value="${brand}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }
    }

    // Save filter state
    function saveFilterState() {
        const selectedPrice = document.querySelector('input[name="price_filter"]:checked').value;
        const selectedBrands = Array.from(brandFilters)
            .filter(filter => filter.checked)
            .map(filter => filter.value);

        localStorage.setItem('product_price_filter', selectedPrice);
        localStorage.setItem('product_brand_filters', JSON.stringify(selectedBrands));
    }

    // Load filters on page load
    loadFilterState();

    // Price filter change
    priceFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            saveFilterState();
            applyFilters();
        });
    });

    // Brand filter change
    brandFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            saveFilterState();
            applyFilters();
        });
    });

    // Clear filters
    clearFiltersBtn.addEventListener('click', function() {
        priceFilters.forEach(filter => filter.checked = false);
        priceFilters[0].checked = true; // Reset to "all"
        brandFilters.forEach(filter => filter.checked = false);

        // Clear localStorage
        localStorage.removeItem('product_price_filter');
        localStorage.removeItem('product_brand_filters');

        applyFilters();
    });

    function applyFilters() {
        const selectedPrice = document.querySelector('input[name="price_filter"]:checked').value;
        const selectedBrands = Array.from(brandFilters)
            .filter(filter => filter.checked)
            .map(filter => filter.value);

        // Build query string
        const params = new URLSearchParams(window.location.search);

        if (selectedPrice !== 'all') {
            params.set('price_filter', selectedPrice);
        } else {
            params.delete('price_filter');
        }

        if (selectedBrands.length > 0) {
            params.set('brand_filter', selectedBrands.join(','));
        } else {
            params.delete('brand_filter');
        }

        // Redirect with filters
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.location.href = newUrl;
    }
});
</script>

<?php get_footer(); ?>
