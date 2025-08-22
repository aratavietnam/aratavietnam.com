<?php
/**
 * Checkout Form
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<main id="site-content" class="bg-white">
    <div class="container mx-auto px-4 py-10">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Thanh toán</h1>
            <p class="text-lg text-gray-600">Hoàn tất đơn hàng của bạn</p>
        </div>

        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

            <?php if ($checkout->get_checkout_fields()) : ?>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h2 class="text-lg font-semibold text-gray-900">Thông tin thanh toán</h2>
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Billing Details -->
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 mb-4">Thông tin thanh toán</h3>
                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>

                                <!-- Shipping Details -->
                                <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900 mb-4">Thông tin giao hàng</h3>
                                        <?php do_action('woocommerce_checkout_shipping'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Additional Information -->
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 mb-4">Ghi chú đơn hàng</h3>
                                    <textarea name="order_comments" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Ghi chú về đơn hàng, giao hàng hoặc thông tin khác..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg border border-gray-100">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h3 class="text-base font-semibold text-gray-900">Tóm tắt đơn hàng</h3>
                            </div>

                            <div class="p-6">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </form>
    </div>
</main>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
