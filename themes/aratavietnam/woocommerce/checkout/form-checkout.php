<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

// Hero section
$hero_title = 'Thanh toán';
$hero_subtitle = 'Hoàn tất đơn hàng của bạn';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <div class="container mx-auto px-4 py-12">
        <?php
        do_action('woocommerce_before_checkout_form', $checkout);

        // If checkout registration is disabled and not logged in, the user cannot checkout.
        if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
            echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'aratavietnam')));
            return;
        }
        ?>

        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Form Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">Thông tin đơn hàng</h2>
                        </div>

                        <div class="p-6">
                            <?php if ($checkout->get_checkout_fields()) : ?>

                                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                                <div class="space-y-8">
                                    <!-- Billing Details -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Thông tin thanh toán
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <?php do_action('woocommerce_checkout_billing'); ?>
                                        </div>
                                    </div>

                                    <!-- Shipping Details -->
                                    <?php if (WC()->cart->needs_shipping_address()) : ?>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Thông tin giao hàng
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <?php do_action('woocommerce_checkout_shipping'); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Additional Information -->
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Ghi chú đơn hàng
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                            <?php endif; ?>

                            <!-- Order Review -->
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Xem lại đơn hàng
                                </h3>
                                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                                <?php do_action('woocommerce_checkout_before_order_review'); ?>
                                <div id="order_review" class="woocommerce-checkout-review-order">
                                    <?php do_action('woocommerce_checkout_order_review'); ?>
                                </div>
                                <?php do_action('woocommerce_checkout_after_order_review'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-24">
                        <!-- Summary Header -->
                        <div class="bg-primary text-white px-6 py-4 rounded-t-lg">
                            <h3 class="text-lg font-bold">Tóm tắt đơn hàng</h3>
                        </div>

                        <!-- Summary Content -->
                        <div class="p-6">
                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                <?php
                                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                        ?>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <?php
                                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                                                echo '<div class="w-12 h-12 rounded-lg overflow-hidden border border-gray-200">' . $thumbnail . '</div>';
                                                ?>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                                    <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?>
                                                </h4>
                                                <p class="text-xs text-gray-500">
                                                    Số lượng: <?php echo $cart_item['quantity']; ?>
                                                </p>
                                            </div>
                                            <div class="text-sm font-medium text-primary">
                                                <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <!-- Order Totals -->
                            <div class="border-t border-gray-200 pt-4 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Tạm tính:</span>
                                    <span class="font-medium"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                </div>

                                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Phí vận chuyển:</span>
                                        <span class="font-medium"><?php echo WC()->cart->get_cart_shipping_total(); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                                    <div class="flex justify-between items-center text-green-600">
                                        <span>Mã giảm giá (<?php echo esc_html($code); ?>):</span>
                                        <span class="font-medium">-<?php echo wc_price(WC()->cart->get_coupon_discount_amount($code)); ?></span>
                                    </div>
                                <?php endforeach; ?>

                                <?php foreach (WC()->cart->get_fees() as $fee) : ?>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600"><?php echo esc_html($fee->name); ?>:</span>
                                        <span class="font-medium"><?php echo wc_price($fee->amount); ?></span>
                                    </div>
                                <?php endforeach; ?>

                                <?php if (WC()->cart->get_cart_tax()) : ?>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Thuế:</span>
                                        <span class="font-medium"><?php echo WC()->cart->get_cart_tax(); ?></span>
                                    </div>
                                <?php endif; ?>

                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">Tổng cộng:</span>
                                        <span class="text-xl font-bold text-primary"><?php echo WC()->cart->get_total(); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Phương thức thanh toán</h4>
                                <div id="payment" class="woocommerce-checkout-payment">
                                    <?php do_action('woocommerce_checkout_after_order_review'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
    </div>
</main>
