<?php
/**
 * The Template for displaying all single products
 *
 * @package ArataVietnam
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-gray-50">
    <?php while (have_posts()) : the_post(); ?>
        <?php global $product; ?>
        
        <!-- Breadcrumb -->
        <section class="bg-white border-b border-gray-200 py-4">
            <div class="container mx-auto px-4">
                <?php woocommerce_breadcrumb(array(
                    'delimiter' => ' <span class="text-gray-400">/</span> ',
                    'wrap_before' => '<nav class="text-sm text-gray-500">',
                    'wrap_after' => '</nav>',
                    'before' => '',
                    'after' => '',
                    'home' => __('Trang chủ', 'aratavietnam'),
                )); ?>
            </div>
        </section>

        <!-- Product Details -->
        <section class="py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Product Images -->
                    <div class="product-images">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <?php
                            // Product gallery
                            $attachment_ids = $product->get_gallery_image_ids();
                            $main_image_id = $product->get_image_id();
                            
                            if ($main_image_id || !empty($attachment_ids)) :
                            ?>
                                <!-- Main Image -->
                                <div class="aspect-square overflow-hidden mb-4" id="main-product-image">
                                    <?php if ($main_image_id) : ?>
                                        <?php echo wp_get_attachment_image($main_image_id, 'large', false, array('class' => 'w-full h-full object-cover')); ?>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400">No Image</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Thumbnail Gallery -->
                                <?php if (!empty($attachment_ids)) : ?>
                                    <div class="grid grid-cols-4 gap-2 p-4">
                                        <?php if ($main_image_id) : ?>
                                            <button class="aspect-square overflow-hidden rounded-lg border-2 border-primary thumbnail-btn active" data-image-id="<?php echo $main_image_id; ?>">
                                                <?php echo wp_get_attachment_image($main_image_id, 'thumbnail', false, array('class' => 'w-full h-full object-cover')); ?>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php foreach ($attachment_ids as $attachment_id) : ?>
                                            <button class="aspect-square overflow-hidden rounded-lg border-2 border-gray-200 hover:border-primary thumbnail-btn" data-image-id="<?php echo $attachment_id; ?>">
                                                <?php echo wp_get_attachment_image($attachment_id, 'thumbnail', false, array('class' => 'w-full h-full object-cover')); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="aspect-square bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No Image Available</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <!-- Product Title -->
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-4">
                                <?php the_title(); ?>
                            </h1>

                            <!-- Product Price -->
                            <div class="text-3xl font-bold text-primary mb-6">
                                <?php echo $product->get_price_html(); ?>
                            </div>

                            <!-- Product Short Description -->
                            <?php if ($product->get_short_description()) : ?>
                                <div class="text-gray-600 mb-6 leading-relaxed">
                                    <?php echo $product->get_short_description(); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Product Meta -->
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <?php if ($product->get_sku()) : ?>
                                        <div>
                                            <span class="font-semibold text-gray-700">Mã sản phẩm:</span>
                                            <span class="text-gray-600"><?php echo $product->get_sku(); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div>
                                        <span class="font-semibold text-gray-700">Tình trạng:</span>
                                        <span class="text-gray-600">
                                            <?php echo $product->is_in_stock() ? 'Còn hàng' : 'Hết hàng'; ?>
                                        </span>
                                    </div>
                                    
                                    <?php
                                    $categories = get_the_terms($product->get_id(), 'product_cat');
                                    if ($categories && !is_wp_error($categories)) :
                                    ?>
                                        <div class="sm:col-span-2">
                                            <span class="font-semibold text-gray-700">Danh mục:</span>
                                            <?php
                                            $category_names = array();
                                            foreach ($categories as $category) {
                                                if ($category->slug !== 'uncategorized') {
                                                    $category_names[] = '<a href="' . esc_url(get_term_link($category)) . '" class="text-primary hover:text-primary-dark">' . esc_html($category->name) . '</a>';
                                                }
                                            }
                                            echo implode(', ', $category_names);
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Add to Cart Form -->
                            <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                                <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                                <?php if (!$product->is_sold_individually()) : ?>
                                    <div class="flex items-center space-x-4 mb-6">
                                        <label for="quantity" class="font-semibold text-gray-700">Số lượng:</label>
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button type="button" class="px-3 py-2 text-gray-600 hover:text-gray-800" onclick="decreaseQuantity()">-</button>
                                            <input type="number" id="quantity" name="quantity" value="<?php echo esc_attr(isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : 1); ?>" min="1" max="<?php echo esc_attr(0 < $product->get_max_purchase_quantity() ? $product->get_max_purchase_quantity() : ''); ?>" class="w-16 text-center border-0 focus:ring-0" />
                                            <button type="button" class="px-3 py-2 text-gray-600 hover:text-gray-800" onclick="increaseQuantity()">+</button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="w-full bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors duration-300 mb-4">
                                    <?php echo esc_html($product->single_add_to_cart_text()); ?>
                                </button>

                                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                            </form>

                            <!-- Social Share -->
                            <div class="border-t border-gray-200 pt-6">
                                <span class="font-semibold text-gray-700 mb-3 block">Chia sẻ:</span>
                                <div class="flex space-x-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="bg-blue-400 text-white p-2 rounded-lg hover:bg-blue-500 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Tabs -->
        <section class="py-8 bg-white">
            <div class="container mx-auto px-4">
                <div class="bg-white rounded-lg shadow-sm">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8 px-6">
                            <button class="py-4 px-2 border-b-2 border-primary text-primary font-semibold tab-btn active" data-tab="description">
                                Mô tả sản phẩm
                            </button>
                            <button class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 tab-btn" data-tab="additional">
                                Thông tin bổ sung
                            </button>
                            <button class="py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 tab-btn" data-tab="reviews">
                                Đánh giá (<?php echo $product->get_review_count(); ?>)
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Description Tab -->
                        <div id="description-tab" class="tab-content">
                            <?php if ($product->get_description()) : ?>
                                <div class="prose max-w-none">
                                    <?php echo $product->get_description(); ?>
                                </div>
                            <?php else : ?>
                                <p class="text-gray-500">Chưa có mô tả chi tiết cho sản phẩm này.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Additional Information Tab -->
                        <div id="additional-tab" class="tab-content hidden">
                            <?php
                            $attributes = $product->get_attributes();
                            if (!empty($attributes)) :
                            ?>
                                <table class="w-full border-collapse">
                                    <?php foreach ($attributes as $attribute) : ?>
                                        <tr class="border-b border-gray-200">
                                            <td class="py-3 pr-6 font-semibold text-gray-700 w-1/3">
                                                <?php echo wc_attribute_label($attribute->get_name()); ?>
                                            </td>
                                            <td class="py-3 text-gray-600">
                                                <?php
                                                if ($attribute->is_taxonomy()) {
                                                    $values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                                                    echo implode(', ', $values);
                                                } else {
                                                    echo $attribute->get_options()[0];
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php else : ?>
                                <p class="text-gray-500">Không có thông tin bổ sung.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Reviews Tab -->
                        <div id="reviews-tab" class="tab-content hidden">
                            <?php comments_template(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    const mainImage = document.getElementById('main-product-image');
    
    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            const imageId = this.dataset.imageId;
            
            // Remove active class from all thumbnails
            thumbnails.forEach(t => {
                t.classList.remove('active', 'border-primary');
                t.classList.add('border-gray-200');
            });
            
            // Add active class to clicked thumbnail
            this.classList.add('active', 'border-primary');
            this.classList.remove('border-gray-200');
            
            // Update main image (you would need to implement this based on your image data)
            // This is a simplified version
        });
    });
    
    // Tab functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Remove active classes
            tabBtns.forEach(b => {
                b.classList.remove('active', 'border-primary', 'text-primary');
                b.classList.add('border-transparent', 'text-gray-500');
            });
            
            tabContents.forEach(c => c.classList.add('hidden'));
            
            // Add active classes
            this.classList.add('active', 'border-primary', 'text-primary');
            this.classList.remove('border-transparent', 'text-gray-500');
            
            document.getElementById(tabId + '-tab').classList.remove('hidden');
        });
    });
    
    // Quantity controls
    window.increaseQuantity = function() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        const maxValue = parseInt(input.getAttribute('max')) || 999;
        if (currentValue < maxValue) {
            input.value = currentValue + 1;
        }
    };
    
    window.decreaseQuantity = function() {
        const input = document.getElementById('quantity');
        const currentValue = parseInt(input.value);
        const minValue = parseInt(input.getAttribute('min')) || 1;
        if (currentValue > minValue) {
            input.value = currentValue - 1;
        }
    };
});
</script>

<?php get_footer(); ?>
