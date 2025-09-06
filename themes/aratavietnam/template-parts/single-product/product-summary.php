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
            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                <button type="button" class="quantity-minus px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
                        data-min="<?php echo apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ); ?>">
                    <span class="text-lg font-medium">−</span>
                </button>
                <input type="number"
                       id="quantity_<?php echo esc_attr( $product->get_id() ); ?>"
                       class="quantity w-16 px-3 py-2 text-center border-0 focus:ring-2 focus:ring-primary focus:ring-inset focus:outline-none"
                       step="1"
                       min="<?php echo apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ); ?>"
                       max="<?php echo apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ); ?>"
                       name="quantity"
                       value="<?php echo isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(); ?>"
                       title="Số lượng"
                       inputmode="numeric">
                <button type="button" class="quantity-plus px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-inset"
                        data-max="<?php echo apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ); ?>">
                    <span class="text-lg font-medium">+</span>
                </button>
            </div>
        </div>

        <!-- Stock Quantity Display -->
        <?php if ($product->managing_stock() && $product->get_stock_quantity() !== null) : ?>
            <div class="mb-4 text-sm text-gray-600">
                <?php
                $stock_quantity = $product->get_stock_quantity();
                if ($stock_quantity > 0) :
                ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span data-icon="check-circle" data-size="12" class="mr-1"></span>
                        Còn lại: <strong class="mx-1"><?php echo esc_html($stock_quantity); ?></strong> sản phẩm
                    </span>
                <?php elseif ($stock_quantity === 0) : ?>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <span data-icon="x-circle" data-size="12" class="mr-1"></span>
                        Hết hàng
                    </span>
                <?php endif; ?>
            </div>
        <?php elseif ($product->is_in_stock() && !$product->managing_stock()) : ?>
            <div class="mb-4 text-sm text-gray-600">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <span data-icon="infinity" data-size="12" class="mr-1"></span>
                    Còn hàng
                </span>
            </div>
        <?php elseif (!$product->is_in_stock()) : ?>
            <div class="mb-4 text-sm text-gray-600">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <span data-icon="x-circle" data-size="12" class="mr-1"></span>
                    Hết hàng
                </span>
            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row gap-3">
            <button
                type="submit"
                name="add-to-cart"
                value="<?php echo esc_attr($product->get_id()); ?>"
                data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                data-product-title="<?php echo esc_attr($product->get_name()); ?>"
                class="flex-1 bg-primary text-white py-3 px-4 rounded-lg font-medium hover:bg-primary-dark transition-colors duration-300 flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed"
                <?php echo !$product->is_in_stock() ? 'disabled' : ''; ?>
            >
                <span data-icon="cart" data-size="16" class="mr-2"></span>
                <?php echo $product->is_in_stock() ? 'Thêm vào giỏ' : 'Hết hàng'; ?>
            </button>

            <!-- Shopee Button -->
            <?php
            $shopee_link = get_post_meta($product->get_id(), '_arata_shopee_link', true);
            if (!empty($shopee_link)) :
            ?>
                <button id="shopee-redirect-btn" data-shopee-url="<?php echo esc_url($shopee_link); ?>"
                   class="flex-1 bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors duration-300 flex items-center justify-center">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/shopee-icon.svg" alt="Shopee" class="w-4 h-4 mr-2" style="filter: brightness(0) invert(1);">
                    Mua trên Shopee
                </button>
            <?php endif; ?>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const shopeeBtn = document.getElementById('shopee-redirect-btn');
                if (shopeeBtn) {
                    shopeeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const shopeeUrl = this.dataset.shopeeUrl;

                        if (window.ArataNotifications) {
                            let countdown = 3;
                            const notificationId = window.ArataNotifications.show({
                                type: 'info',
                                title: 'Đang chuyển hướng đến Shopee...',
                                message: `Bạn sẽ được chuyển đến trang Shopee trong ${countdown} giây.`,
                                duration: 3500,
                                actions: [
                                    {
                                        text: 'Hủy',
                                        action: () => {
                                            clearInterval(countdownInterval);
                                            clearTimeout(redirectTimeout);
                                        }
                                    }
                                ]
                            });

                            const countdownInterval = setInterval(() => {
                                countdown--;
                                if (countdown > 0) {
                                    const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                                    if (notification) {
                                        const messageEl = notification.querySelector('.notification-message');
                                        if (messageEl) {
                                            messageEl.textContent = `Bạn sẽ được chuyển đến trang Shopee trong ${countdown} giây.`;
                                        }
                                    }
                                } else {
                                    clearInterval(countdownInterval);
                                }
                            }, 1000);

                            const redirectTimeout = setTimeout(() => {
                                window.open(shopeeUrl, '_blank', 'noopener,noreferrer');
                                clearInterval(countdownInterval);
                            }, 3000);
                        } else {
                            // Fallback if notification system not available
                            setTimeout(() => {
                                window.open(shopeeUrl, '_blank', 'noopener,noreferrer');
                            }, 0);
                        }
                    });
                }
            });
            </script>
        </div>

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

<!-- Quantity Controls JavaScript v3.0 -->
<script>
(function() {
    // Prevent multiple initializations
    if (window.arataQuantityControlsInitialized) {
        return;
    }
    window.arataQuantityControlsInitialized = true;

    function initQuantityControls() {
        // Find elements using vanilla JavaScript
        const quantityInput = document.querySelector('input[name="quantity"]') ||
                             document.querySelector('.quantity') ||
                             document.querySelector('input[type="number"]');
        const minusButton = document.querySelector('.quantity-minus');
        const plusButton = document.querySelector('.quantity-plus');

        if (quantityInput && minusButton && plusButton) {
            // Check if already initialized
            if (quantityInput.dataset.quantityInitialized) {
                return;
            }
            quantityInput.dataset.quantityInitialized = 'true';

            const minValue = parseInt(quantityInput.getAttribute('min')) || 1;
            const maxValue = parseInt(quantityInput.getAttribute('max')) || 999;

            // Minus button functionality
            function handleMinusClick(e) {
                e.preventDefault();
                e.stopPropagation();

                let currentValue = parseInt(quantityInput.value) || minValue;
                if (currentValue > minValue) {
                    currentValue--;
                    quantityInput.value = currentValue;

                    // Trigger change events
                    const changeEvent = new Event('change', { bubbles: true });
                    const inputEvent = new Event('input', { bubbles: true });
                    quantityInput.dispatchEvent(changeEvent);
                    quantityInput.dispatchEvent(inputEvent);
                }
                return false;
            }

            // Plus button functionality
            function handlePlusClick(e) {
                e.preventDefault();
                e.stopPropagation();

                let currentValue = parseInt(quantityInput.value) || minValue;
                if (currentValue < maxValue) {
                    currentValue++;
                    quantityInput.value = currentValue;

                    // Trigger change events
                    const changeEvent = new Event('change', { bubbles: true });
                    const inputEvent = new Event('input', { bubbles: true });
                    quantityInput.dispatchEvent(changeEvent);
                    quantityInput.dispatchEvent(inputEvent);
                }
                return false;
            }

            // Add event listeners with once option to prevent duplicates
            minusButton.addEventListener('click', handleMinusClick, { once: false });
            plusButton.addEventListener('click', handlePlusClick, { once: false });

            // Store handlers for potential cleanup
            minusButton._arataHandler = handleMinusClick;
            plusButton._arataHandler = handlePlusClick;

            // Validate input on change
            if (!quantityInput.dataset.inputInitialized) {
                quantityInput.addEventListener('input', function() {
                    let value = parseInt(this.value);
                    if (isNaN(value) || value < minValue) {
                        this.value = minValue;
                    } else if (value > maxValue) {
                        this.value = maxValue;
                    }
                });

                // Prevent manual input of invalid characters
                quantityInput.addEventListener('keypress', function(e) {
                    // Allow: backspace, delete, tab, escape, enter
                    if ([46, 8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                        // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        (e.keyCode === 86 && e.ctrlKey === true) ||
                        (e.keyCode === 88 && e.ctrlKey === true)) {
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                quantityInput.dataset.inputInitialized = 'true';
            }

            // Quantity controls initialized successfully
        } else {
            // Quantity controls not found
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initQuantityControls);
    } else {
        initQuantityControls();
    }

    // Also initialize after a short delay to ensure all elements are loaded
    setTimeout(initQuantityControls, 500);
})();
</script>

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
