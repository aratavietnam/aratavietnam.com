<?php
/**
 * Base test case for theme tests
 */

class ThemeTestCase extends WP_UnitTestCase {
    
    protected $theme;
    
    public function setUp(): void {
        parent::setUp();
        
        // Set up theme
        $this->theme = wp_get_theme('aratavietnam');
        $this->assertTrue($this->theme->exists(), 'Theme should exist');
        
        // Set up test data
        $this->setup_test_data();
    }
    
    protected function setup_test_data() {
        // Create test user
        $this->user_id = $this->factory->user->create(array(
            'role' => 'administrator',
            'user_login' => 'test_admin',
            'user_email' => 'test@aratavietnam.com'
        ));
        
        wp_set_current_user($this->user_id);
        
        // Create test posts
        $this->post_id = $this->factory->post->create(array(
            'post_title' => 'Test Post',
            'post_content' => 'Test content',
            'post_status' => 'publish',
            'post_type' => 'post'
        ));
        
        $this->page_id = $this->factory->post->create(array(
            'post_title' => 'Test Page',
            'post_content' => 'Test page content',
            'post_status' => 'publish',
            'post_type' => 'page'
        ));
        
        // Create test product if WooCommerce is active
        if (class_exists('WooCommerce')) {
            $this->product_id = $this->factory->post->create(array(
                'post_title' => 'Test Product',
                'post_content' => 'Test product description',
                'post_status' => 'publish',
                'post_type' => 'product'
            ));
            
            // Set product meta
            update_post_meta($this->product_id, '_price', '10000');
            update_post_meta($this->product_id, '_regular_price', '10000');
            update_post_meta($this->product_id, '_sku', 'TEST-001');
            update_post_meta($this->product_id, '_manage_stock', 'yes');
            update_post_meta($this->product_id, '_stock', '10');
        }
    }
    
    protected function create_test_news_post() {
        return $this->factory->post->create(array(
            'post_title' => 'Test News Post',
            'post_content' => 'Test news content',
            'post_status' => 'publish',
            'post_type' => 'news'
        ));
    }
    
    protected function create_test_service_post() {
        return $this->factory->post->create(array(
            'post_title' => 'Test Service',
            'post_content' => 'Test service description',
            'post_status' => 'publish',
            'post_type' => 'service'
        ));
    }
    
    protected function create_test_job_posting() {
        return $this->factory->post->create(array(
            'post_title' => 'Test Job Position',
            'post_content' => 'Test job description',
            'post_status' => 'publish',
            'post_type' => 'job_posting'
        ));
    }
    
    protected function create_test_partner() {
        return $this->factory->post->create(array(
            'post_title' => 'Test Partner',
            'post_content' => 'Test partner description',
            'post_status' => 'publish',
            'post_type' => 'partner'
        ));
    }
    
    protected function assertThemeSupport($feature) {
        $this->assertTrue(current_theme_supports($feature), "Theme should support {$feature}");
    }
    
    protected function assertPostTypeExists($post_type) {
        $this->assertTrue(post_type_exists($post_type), "Post type {$post_type} should exist");
    }
    
    protected function assertTaxonomyExists($taxonomy) {
        $this->assertTrue(taxonomy_exists($taxonomy), "Taxonomy {$taxonomy} should exist");
    }
    
    protected function assertFunctionExists($function) {
        $this->assertTrue(function_exists($function), "Function {$function} should exist");
    }
    
    protected function assertRestEndpointExists($route) {
        $rest_server = rest_get_server();
        $routes = $rest_server->get_routes();
        $this->assertArrayHasKey($route, $routes, "REST endpoint {$route} should exist");
    }
    
    public function tearDown(): void {
        // Clean up test data
        if (isset($this->user_id)) {
            wp_delete_user($this->user_id, true);
        }
        
        if (isset($this->post_id)) {
            wp_delete_post($this->post_id, true);
        }
        
        if (isset($this->page_id)) {
            wp_delete_post($this->page_id, true);
        }
        
        if (isset($this->product_id)) {
            wp_delete_post($this->product_id, true);
        }
        
        parent::tearDown();
    }
}