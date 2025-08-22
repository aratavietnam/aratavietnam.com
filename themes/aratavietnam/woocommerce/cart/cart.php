<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<?php
// Hero section
$hero_title = 'Giỏ hàng';
$hero_subtitle = 'Kiểm tra và hoàn tất đơn hàng của bạn';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <div class="container mx-auto px-4 py-10">
        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <?php if (!WC()->cart->is_empty()) : ?>
                <!-- Cart Items Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                            <!-- Cart Header -->
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-900">Sản phẩm trong giỏ hàng</h2>
                                <p class="text-sm text-gray-600 mt-1"><?php echo sprintf(esc_html__('Bạn có %d sản phẩm trong giỏ hàng', 'aratavietnam'), WC()->cart->get_cart_contents_count()); ?></p>
                            </div>

                            <!-- Cart Items List -->
                            <div class="cart-items-list divide-y divide-gray-100">
                                <?php
                                do_action('woocommerce_before_cart_contents');

                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                                        ?>
                                        <div class="p-5">
                                            <div class="flex items-start gap-4">
                                                <!-- Product Image -->
                                                <div class="flex-shrink-0">
                                                    <?php
                                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', ['class' => 'w-20 h-20 object-cover rounded-lg border border-gray-100']), $cart_item, $cart_item_key);
                                                    if (!$product_permalink) {
                                                        echo $thumbnail;
                                                    } else {
                                                        printf('<a href="%s" class="block">%s</a>', esc_url($product_permalink), $thumbnail);
                                                    }
                                                    ?>
                                                </div>

                                                <!-- Product Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <h3 class="text-base font-medium text-gray-900 mb-1">
                                                                <?php
                                                                if (!$product_permalink) {
                                                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                                } else {
                                                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" class="hover:text-primary">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                                }
                                                                ?>
                                                            </h3>
                                                            <?php if ($_product->get_sku()) : ?>
                                                                <p class="text-xs text-gray-500 mb-2">SKU: <?php echo esc_html($_product->get_sku()); ?></p>
                                                            <?php endif; ?>

                                                            <!-- Product Meta -->
                                                            <div class="text-sm text-gray-600">
                                                                <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                                                            </div>
                                                        </div>

                                                        <!-- Remove Button -->
                                                        <div class="ml-4">
                                                            <?php
                                                            echo apply_filters(
                                                                'woocommerce_cart_item_remove_link',
                                                                sprintf(
                                                                    '<a href="%s" class="text-gray-400 hover:text-red-500" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                                    esc_html__('Remove this item', 'aratavietnam'),
                                                                    esc_attr($product_id),
                                                                    esc_attr($_product->get_sku()),
                                                                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
                                                                ),
                                                                $cart_item_key
                                                            );
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <!-- Price and Quantity -->
                                                    <div class="flex items-center justify-between mt-3">
                                                        <div class="flex items-center gap-3">
                                                            <!-- Quantity -->
                                                            <div class="flex items-center gap-2">
                                                                <label class="text-sm text-gray-700">Số lượng</label>
                                                                <?php
                                                                if ($_product->is_sold_individually()) {
                                                                    $min_quantity = 1;
                                                                    $max_quantity = 1;
                                                                } else {
                                                                    $min_quantity = 0;
                                                                    $max_quantity = $_product->get_max_purchase_quantity();
                                                                }

                                                                $product_quantity = woocommerce_quantity_input(
                                                                    array(
                                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                        'input_value'  => $cart_item['quantity'],
                                                                        'max_value'    => $max_quantity,
                                                                        'min_value'    => $min_quantity,
                                                                        'product_name' => $_product->get_name(),
                                                                    ),
                                                                    $_product,
                                                                    false
                                                                );

                                                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <!-- Price -->
                                                        <div class="text-right">
                                                            <div class="text-base font-semibold text-primary">
                                                                <?php
                                                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                                                ?>
                                                            </div>
                                                            <?php if ($_product->get_regular_price() != $_product->get_price()) : ?>
                                                                <div class="text-xs text-gray-400 line-through">
                                                                    <?php echo wc_price($_product->get_regular_price()); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <!-- Cart Actions -->
                            <div class="px-6 py-4 border-t border-gray-100">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <button type="submit" class="woocommerce-button button woocommerce-form-cart__submit bg-primary hover:bg-primary-dark text-white px-5 py-2 rounded-md" name="update_cart" value="<?php esc_attr_e('Update cart', 'aratavietnam'); ?>">
                                        Cập nhật giỏ hàng
                                    </button>

                                    <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="inline-flex items-center text-primary hover:text-primary-dark">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Tiếp tục mua sắm
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php do_action('woocommerce_cart_contents'); ?>
                        <?php do_action('woocommerce_after_cart_contents'); ?>
                    </div>

                    <!-- Cart Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg border border-gray-100">
                            <!-- Summary Header -->
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-900">Tổng đơn hàng</h3>
                            </div>

                            <!-- Summary Content -->
                            <div class="p-6">
                                <!-- Cart Totals -->
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Tạm tính</span>
                                        <span class="font-medium"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                    </div>

                                    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Phí vận chuyển</span>
                                            <span class="font-medium"><?php echo WC()->cart->get_cart_shipping_total(); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                                        <div class="flex justify-between items-center text-sm text-green-600">
                                            <span>Mã giảm giá (<?php echo esc_html($code); ?>)</span>
                                            <span class="font-medium">-<?php echo wc_price(WC()->cart->get_coupon_discount_amount($code)); ?></span>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600"><?php echo esc_html($fee->name); ?></span>
                                            <span class="font-medium"><?php echo wc_price($fee->amount); ?></span>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php if (WC()->cart->get_cart_tax()) : ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">Thuế</span>
                                            <span class="font-medium"><?php echo WC()->cart->get_cart_tax(); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="border-t border-gray-100 pt-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-base font-semibold text-gray-900">Tổng cộng</span>
                                            <span class="text-lg font-bold text-primary"><?php echo WC()->cart->get_total(); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coupon Code -->
                                <?php if (wc_coupons_enabled()) : ?>
                                    <div class="mb-6">
                                        <details class="group">
                                            <summary class="flex items-center justify-between cursor-pointer text-sm text-gray-700">
                                                <span>Mã giảm giá</span>
                                                <svg class="w-4 h-4 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </summary>
                                            <div class="mt-3">
                                                <div class="flex gap-2">
                                                    <input type="text" name="coupon_code" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" id="coupon_code" value="" placeholder="Nhập mã giảm giá" />
                                                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'aratavietnam'); ?>">
                                                        Áp dụng
                                                    </button>
                                                </div>
                                            </div>
                                        </details>
                                    </div>
                                <?php endif; ?>

                                <!-- Checkout Button -->
                                <div class="space-y-2">
                                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="arata-btn block w-full">
                                        Tiến hành thanh toán
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <!-- Empty Cart -->
                <div class="text-center py-14">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">Giỏ hàng trống</h2>
                        <p class="text-gray-600 mb-6">Bạn chưa có sản phẩm nào trong giỏ. Hãy khám phá các sản phẩm của chúng tôi!</p>
                        <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="inline-flex items-center bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-md font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Khám phá sản phẩm
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</main>

<?php do_action('woocommerce_after_cart'); ?>
