<?php
if (!defined('ABSPATH')) { exit; }

// Set products per page for WooCommerce
add_filter('loop_shop_per_page', function() {
    return 6; // Show 6 products per page (for better pagination)
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

                <!-- Mobile Filter Trigger -->
                <div class="lg:hidden mb-4">
                    <button id="mobile-filter-trigger" class="w-full flex items-center justify-center bg-white border border-gray-300 rounded-lg py-2 px-4 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                        <span data-icon="filter" data-size="16" class="mr-2"></span>
                        Bộ lọc
                    </button>
                </div>

                <!-- Sidebar - Product Categories & Filters (1/4) - Hidden on Mobile -->
                <aside class="hidden lg:block lg:col-span-1">
                    <div class="sticky top-24 space-y-4">

                        <!-- Product Categories -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <h3 class="text-base font-semibold text-gray-900 flex items-center">
                                    <span data-icon="folder" data-size="16" class="text-primary mr-2"></span>
                                    Danh mục sản phẩm
                                </h3>
                            </div>

                            <div class="p-3">
                                <div class="space-y-1">
                                    <?php
                                    // Check if we're on the main shop page (all products)
                                    $is_shop_page = is_shop() && !is_product_category() && !is_product_tag();
                                    ?>

                                    <!-- All Products Tab -->
                                    <div class="border-b border-gray-100">
                                        <div class="flex items-center justify-between group">
                                            <a href="<?php echo wc_get_page_permalink('shop'); ?>"
                                               class="flex-1 py-2 px-2 text-gray-700 hover:text-primary hover:bg-primary/5 rounded transition-all duration-200 group-hover:bg-primary/5 flex items-center <?php echo $is_shop_page ? 'text-primary bg-primary/10 font-semibold' : ''; ?>">
                                                <span data-icon="folder" data-size="14" class="mr-2 inline-block"></span>
                                                Tất cả sản phẩm
                                                <?php
                                                // Get total product count
                                                $all_products_count = wp_count_posts('product');
                                                $total_count = $all_products_count->publish;
                                                ?>
                                                <span class="text-xs text-gray-400 ml-2 bg-gray-100 px-1.5 py-0.5 rounded-full"><?php echo $total_count; ?></span>
                                            </a>
                                        </div>
                                    </div>

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
                                                       class="flex-1 py-2 px-2 text-gray-700 hover:text-primary hover:bg-primary/5 rounded transition-all duration-200 group-hover:bg-primary/5 flex items-center <?php echo $is_current ? 'text-primary bg-primary/10 font-semibold' : ''; ?>">
                                                        <span data-icon="folder" data-size="14" class="mr-2 inline-block"></span>
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
                                    <span data-icon="dollar-sign" data-size="16" class="text-primary mr-2"></span>
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
                                    <span data-icon="award" data-size="16" class="text-primary mr-2"></span>
                                    Thương hiệu
                                </h3>
                            </div>
                            <div class="p-3">
                                <div class="space-y-2">
                                    <?php
                                    // Get all product brands with product count
                                    $product_brands = get_terms([
                                        'taxonomy' => 'product_brand',
                                        'hide_empty' => false, // Changed to false to show all brands
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                    ]);

                                    if (!empty($product_brands) && !is_wp_error($product_brands)) :
                                        foreach ($product_brands as $brand) :
                                            $is_current_brand = false;

                                            // Check if this brand is currently selected
                                            if (isset($_GET['brand_filter'])) {
                                                $selected_brands = explode(',', $_GET['brand_filter']);
                                                $is_current_brand = in_array($brand->slug, $selected_brands);
                                            }

                                            // Calculate actual product count for this brand
                                            $brand_product_count = get_posts([
                                                'post_type' => 'product',
                                                'post_status' => 'publish',
                                                'posts_per_page' => -1,
                                                'tax_query' => [
                                                    [
                                                        'taxonomy' => 'product_brand',
                                                        'field' => 'slug',
                                                        'terms' => $brand->slug,
                                                    ]
                                                ],
                                                'fields' => 'ids', // Only get IDs for better performance
                                            ]);
                                            $actual_count = count($brand_product_count);
                                            ?>
                                            <label class="flex items-center cursor-pointer group">
                                                <input type="checkbox"
                                                       name="brand_filter[]"
                                                       value="<?php echo esc_attr($brand->slug); ?>"
                                                       class="mr-2 text-primary"
                                                       <?php echo $is_current_brand ? 'checked' : ''; ?>>
                                                <span class="text-gray-700 group-hover:text-primary transition-colors text-sm">
                                                    <?php echo esc_html($brand->name); ?>
                                                    <span class="text-xs text-gray-400 ml-1 bg-gray-100 px-1.5 py-0.5 rounded-full"><?php echo $actual_count; ?></span>
                                                </span>
                                            </label>
                                            <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <p class="text-gray-500 text-sm">Chưa có thương hiệu nào.</p>
                                        <?php
                                    endif;
                                    ?>
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

                        <!-- Sort Dropdown -->
                        <div class="bg-white rounded-lg border border-gray-200 p-3 mb-6">
                            <div class="flex items-center justify-between flex-wrap gap-x-4 gap-y-2">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-700 font-medium text-sm">Sắp xếp theo:</span>
                                    <div class="relative">
                                        <select id="product-sort" name="product_sort" class="text-sm appearance-none bg-white border border-gray-300 rounded-lg px-3 py-1.5 pr-8 text-gray-700 hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                            <?php
                                            $current_sort = isset($_GET['orderby']) ? $_GET['orderby'] : 'menu_order';
                                            $sort_options = array(
                                                'menu_order' => 'Mặc định',
                                                'title' => 'Tên A đến Z',
                                                'title-desc' => 'Tên Z đến A',
                                                'price' => 'Giá thấp đến cao',
                                                'price-desc' => 'Giá cao đến thấp',
                                                'date' => 'Mới nhất',
                                                'popularity' => 'Phổ biến nhất'
                                            );

                                            foreach ($sort_options as $value => $label) :
                                                $selected = ($current_sort === $value) ? 'selected' : '';
                                                echo "<option value='{$value}' {$selected}>{$label}</option>";
                                            endforeach;
                                            ?>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <span data-icon="chevron-down" data-size="14" class="text-gray-400"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-500">
                                    <?php
                                    global $wp_query;
                                    $total_products = $wp_query->found_posts;
                                    $current_page = max(1, get_query_var('paged'));
                                    $per_page = get_option('posts_per_page');
                                    $start = (($current_page - 1) * $per_page) + 1;
                                    $end = min($current_page * $per_page, $total_products);

                                    echo "Hiển thị {$start}–{$end} của {$total_products} sản phẩm";
                                    ?>
                                </div>
                            </div>
                        </div>



                        <!-- Products Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                            <?php while (have_posts()) : the_post(); ?>
                                <?php get_template_part('template-parts/product-card'); ?>
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

<!-- Mobile Filter Panel (Off-canvas) -->
<div id="mobile-filter-panel" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden" aria-hidden="true">
    <div id="mobile-filter-content" class="absolute top-0 right-0 h-full bg-white w-80 max-w-full shadow-lg z-[9999] transform translate-x-full transition-transform duration-300 overflow-y-auto">
        <!-- Panel Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Bộ lọc sản phẩm</h3>
            <button id="mobile-filter-close" class="p-2 text-gray-500 hover:text-primary rounded-full hover:bg-gray-100">
                <span data-icon="x" data-size="20"></span>
            </button>
        </div>

        <!-- Panel Body (Cloned Filters) -->
        <div class="p-4 space-y-6">
            <!-- Filters will be cloned here by JS -->
        </div>
    </div>
</div>





<?php get_footer(); ?>
