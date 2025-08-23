<?php
/**
 * Single Product Summary
 *
 * @package ArataVietnam
 */

global $product;
?>

<!-- Product Title -->
<h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">
    <?php the_title(); ?>
</h1>

<!-- Product Price -->
<div class="text-3xl font-bold text-primary mb-4">
    <?php echo $product->get_price_html(); ?>
</div>

<!-- Product Short Description -->
<?php if ($product->get_short_description()) : ?>
    <div class="text-gray-600 mb-6 leading-relaxed prose max-w-none">
        <?php echo $product->get_short_description(); ?>
    </div>
<?php endif; ?>

<!-- Add to Cart Form -->
<?php if ($product->is_in_stock()) : ?>
    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <div class="flex items-center space-x-4 mb-6">
            <label for="quantity_<?php echo esc_attr( $product->get_id() ); ?>" class="font-semibold text-gray-700">Số lượng:</label>
            <?php
            woocommerce_quantity_input(
                array(
                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                    'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                )
            );
            ?>
        </div>

        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="w-full bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors duration-300 flex items-center justify-center">
            <span data-icon="shopping-cart" data-size="18" class="mr-2"></span>
            Thêm vào giỏ hàng
        </button>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>
<?php else : ?>
    <div class="bg-red-100 text-red-700 p-4 rounded-lg">
        Sản phẩm hiện đang hết hàng.
    </div>
<?php endif; ?>

<!-- Product Meta -->
<div class="mt-6 pt-6 border-t border-gray-100">
    <div class="grid grid-cols-[auto,1fr] gap-x-4 gap-y-3 text-sm">
        <?php if ($product->get_sku()) : ?>
            <span class="text-gray-500">Mã sản phẩm</span>
            <span class="font-semibold text-gray-800"><?php echo $product->get_sku(); ?></span>
        <?php endif; ?>

        <?php
        $categories = get_the_terms($product->get_id(), 'product_cat');
        if ($categories && !is_wp_error($categories)) :
            $category_names = array_map(function($category) {
                return sprintf('<a href="%s" class="text-primary hover:underline">%s</a>',
                    esc_url(get_term_link($category)),
                    esc_html($category->name)
                );
            }, $categories);
        ?>
            <span class="text-gray-500">Danh mục</span>
            <span class="font-semibold text-gray-800"><?php echo implode(', ', $category_names); ?></span>
        <?php endif; ?>

        <?php
        $brands = get_the_terms($product->get_id(), 'product_brand');
        if ($brands && !is_wp_error($brands)) :
            $brand_names = array_map(function($brand) {
                return sprintf('<a href="%s" class="text-primary hover:underline">%s</a>',
                    esc_url(get_term_link($brand)),
                    esc_html($brand->name)
                );
            }, $brands);
        ?>
            <span class="text-gray-500">Thương hiệu</span>
            <span class="font-semibold text-gray-800"><?php echo implode(', ', $brand_names); ?></span>
        <?php endif; ?>
    </div>
</div>

<!-- Social Share -->
<div class="pt-6 mt-6">
    <span class="font-semibold text-gray-800 mb-3 block">Chia sẻ sản phẩm:</span>
    <div class="flex items-center gap-3">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300">
            <span data-icon="facebook" data-size="20"></span>

        </a>

        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300">
            <span data-icon="pinterest" data-size="20"></span>
        </a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-blue-700 hover:text-white transition-all duration-300">
            <span data-icon="linkedin" data-size="20"></span>
        </a>
        <button id="copy-product-link" class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-gray-800 hover:text-white transition-all duration-300" data-link="<?php echo esc_url(get_permalink()); ?>">
            <span data-icon="link-2" data-size="20"></span>
        </button>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ensureIconsAreRendered = () => {
        if (window.ArataIcons && typeof window.ArataIcons.init === 'function') {
            window.ArataIcons.init();
        } else {
            setTimeout(ensureIconsAreRendered, 100);
        }
    };
    ensureIconsAreRendered();
});
</script>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const missingIcons = {
        'pinterest': '<path d="M12.5 12c0-2.5-1.5-5-5-5-3.5 0-5 2.5-5 5 0 2.5 1.5 5 5 5 1.5 0 2.5-1 2.5-2.5 0-1.5-1-2.5-2.5-2.5-1.5 0-2.5 1-2.5 2.5 0 1.5 1 2.5 2.5 2.5 3.5 0 5-2.5 5-5z"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"/>',
        'link-2': '<path d="M9 17H7A5 5 0 0 1 7 7h2" /><path d="M15 7h2a5 5 0 1 1 0 10h-2" /><line x1="8" y1="12" x2="16" y2="12" />',
        'check': '<path d="M20 6 9 17l-5-5" />'
    };

    function createManualIcon(name, size = 24, className = '', strokeWidth = 2) {
        const iconPath = missingIcons[name];
        if (!iconPath) return null;

        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('width', size);
        svg.setAttribute('height', size);
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', strokeWidth);
        svg.setAttribute('stroke-linecap', 'round');
        svg.setAttribute('stroke-linejoin', 'round');
        if (className) svg.setAttribute('class', className);
        svg.innerHTML = iconPath;
        return svg;
    }

    document.querySelectorAll('[data-icon="pinterest"], [data-icon="link-2"]').forEach(placeholder => {
        const iconName = placeholder.getAttribute('data-icon');
        const size = placeholder.getAttribute('data-size') || 20;
        const icon = createManualIcon(iconName, size);
        if (icon) {
            placeholder.innerHTML = '';
            placeholder.appendChild(icon);
        }
    });
});
</script>
