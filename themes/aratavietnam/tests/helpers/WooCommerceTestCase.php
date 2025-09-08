<?php
/**
 * Base test case for WooCommerce integration tests
 */

class WooCommerceTestCase extends ThemeTestCase {
    
    protected $woocommerce;
    
    public function setUp(): void {
        parent::setUp();
        
        // Check if WooCommerce is active
        if (!class_exists('WooCommerce')) {
            $this->markTestSkipped('WooCommerce is not active');
        }
        
        $this->woocommerce = WC();
        
        // Set up WooCommerce test environment
        $this->setup_woocommerce_environment();
    }
    
    protected function setup_woocommerce_environment() {
        // Set WooCommerce currency to VND
        update_option('woocommerce_currency', 'VND');
        
        // Set tax settings
        update_option('woocommerce_calc_taxes', 'no');
        update_option('woocommerce_prices_include_tax', 'no');
        
        // Set shipping settings
        update_option('woocommerce_ship_to_countries', 'all');
        
        // Set checkout settings
        update_option('woocommerce_enable_guest_checkout', 'yes');
        update_option('woocommerce_enable_signup_and_login_from_checkout', 'no');
        
        // Clear cart
        if (method_exists(WC()->cart, 'empty_cart')) {
            WC()->cart->empty_cart();
        }
        
        // Clear session
        if (method_exists(WC()->session, 'cleanup_sessions')) {
            WC()->session->cleanup_sessions();
        }
    }
    
    protected function create_simple_product($price = 10000, $stock = 10) {
        $product = new WC_Product_Simple();
        $product->set_name('Test Product ' . rand(1, 1000));
        $product->set_description('Test product description');
        $product->set_short_description('Test short description');
        $product->set_price($price);
        $product->set_regular_price($price);
        $product->set_sku('TEST-' . rand(1000, 9999));
        $product->set_manage_stock(true);
        $product->set_stock_quantity($stock);
        $product->set_stock_status('instock');
        $product->set_catalog_visibility('visible');
        $product->save();
        
        return $product;
    }
    
    protected function create_variable_product() {
        $product = new WC_Product_Variable();
        $product->set_name('Test Variable Product ' . rand(1, 1000));
        $product->set_description('Test variable product description');
        $product->set_sku('VAR-' . rand(1000, 9999));
        
        // Create attributes
        $attribute = new WC_Product_Attribute();
        $attribute->set_id(0);
        $attribute->set_name('Color');
        $attribute->set_options(['Red', 'Blue', 'Green']);
        $attribute->set_position(0);
        $attribute->set_visible(true);
        $attribute->set_variation(true);
        
        $product->set_attributes([$attribute]);
        $product->save();
        
        // Create variations
        $colors = ['Red', 'Blue', 'Green'];
        foreach ($colors as $color) {
            $variation = new WC_Product_Variation();
            $variation->set_parent_id($product->get_id());
            $variation->set_attributes(['Color' => $color]);
            $variation->set_price(rand(5000, 20000));
            $variation->set_regular_price(rand(5000, 20000));
            $variation->set_sku('VAR-' . $color . '-' . rand(1000, 9999));
            $variation->set_manage_stock(true);
            $variation->set_stock_quantity(5);
            $variation->set_stock_status('instock');
            $variation->save();
        }
        
        return $product;
    }
    
    protected function create_test_order($status = 'completed') {
        $order = wc_create_order();
        
        // Add product to order
        $product = $this->create_simple_product();
        $order->add_product($product, 1);
        
        // Set billing address
        $order->set_billing_first_name('Test');
        $order->set_billing_last_name('Customer');
        $order->set_billing_email('test@example.com');
        $order->set_billing_phone('0123456789');
        $order->set_billing_address_1('123 Test Street');
        $order->set_billing_city('Ho Chi Minh City');
        $order->set_billing_postcode('700000');
        $order->set_billing_country('VN');
        
        // Set shipping address
        $order->set_shipping_first_name('Test');
        $order->set_shipping_last_name('Customer');
        $order->set_shipping_address_1('123 Test Street');
        $order->set_shipping_city('Ho Chi Minh City');
        $order->set_shipping_postcode('700000');
        $order->set_shipping_country('VN');
        
        // Calculate totals
        $order->calculate_totals();
        
        // Set order status
        $order->set_status($status);
        $order->save();
        
        return $order;
    }
    
    protected function create_test_customer() {
        $customer_id = wc_create_new_customer(
            'testcustomer@example.com',
            'testcustomer',
            'password123'
        );
        
        if (is_wp_error($customer_id)) {
            throw new Exception('Could not create test customer: ' . $customer_id->get_error_message());
        }
        
        // Add customer meta
        update_user_meta($customer_id, 'first_name', 'Test');
        update_user_meta($customer_id, 'last_name', 'Customer');
        update_user_meta($customer_id, 'billing_first_name', 'Test');
        update_user_meta($customer_id, 'billing_last_name', 'Customer');
        update_user_meta($customer_id, 'billing_email', 'testcustomer@example.com');
        update_user_meta($customer_id, 'billing_phone', '0123456789');
        update_user_meta($customer_id, 'billing_address_1', '123 Test Street');
        update_user_meta($customer_id, 'billing_city', 'Ho Chi Minh City');
        update_user_meta($customer_id, 'billing_postcode', '700000');
        update_user_meta($customer_id, 'billing_country', 'VN');
        
        return $customer_id;
    }
    
    protected function add_product_to_cart($product_id, $quantity = 1) {
        WC()->cart->add_to_cart($product_id, $quantity);
        return WC()->cart->get_cart_contents_count();
    }
    
    protected function assertProductInCart($product_id) {
        $cart_items = WC()->cart->get_cart();
        $found = false;
        
        foreach ($cart_items as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                $found = true;
                break;
            }
        }
        
        $this->assertTrue($found, "Product {$product_id} should be in cart");
    }
    
    protected function assertProductStock($product_id, $expected_stock) {
        $product = wc_get_product($product_id);
        $this->assertEquals($expected_stock, $product->get_stock_quantity(), "Product {$product_id} should have {$expected_stock} items in stock");
    }
    
    protected function assertOrderStatus($order_id, $expected_status) {
        $order = wc_get_order($order_id);
        $this->assertEquals($expected_status, $order->get_status(), "Order {$order_id} should have status {$expected_status}");
    }
    
    protected function assertOrderTotal($order_id, $expected_total) {
        $order = wc_get_order($order_id);
        $this->assertEquals($expected_total, $order->get_total(), "Order {$order_id} should have total {$expected_total}");
    }
    
    protected function get_vietnamese_translation($english_text) {
        $translations = [
            'Billing details' => 'Thông tin thanh toán',
            'Street address' => 'Địa chỉ đường',
            'House number and street name' => 'Số nhà và tên đường',
            'Apartment, suite, unit, etc. (optional)' => 'Căn hộ, suite, đơn vị, v.v. (tùy chọn)',
            'Postcode / ZIP (optional)' => 'Mã bưu điện / ZIP (tùy chọn)',
            'Town / City' => 'Thành phố / Thị xã',
            'Product' => 'Sản phẩm',
            'Subtotal' => 'Tạm tính',
            'Total' => 'Tổng cộng',
            'Place order' => 'Đặt hàng',
            'View cart' => 'Xem giỏ hàng',
        ];
        
        return $translations[$english_text] ?? $english_text;
    }
    
    public function tearDown(): void {
        // Clean up WooCommerce data
        if (method_exists(WC()->cart, 'empty_cart')) {
            WC()->cart->empty_cart();
        }
        
        // Clean up orders
        $orders = wc_get_orders(['limit' => -1]);
        foreach ($orders as $order) {
            $order->delete(true);
        }
        
        // Clean up products
        $products = wc_get_products(['limit' => -1]);
        foreach ($products as $product) {
            $product->delete(true);
        }
        
        parent::tearDown();
    }
}