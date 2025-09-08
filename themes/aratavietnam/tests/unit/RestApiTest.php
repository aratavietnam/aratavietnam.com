<?php
/**
 * Test REST API endpoints and functionality
 */

class RestApiTest extends ThemeTestCase {
    
    public function test_custom_search_endpoint_exists() {
        $this->assertRestEndpointExists('/aratavietnam/v1/search');
    }
    
    public function test_search_endpoint_structure() {
        $rest_server = rest_get_server();
        $routes = $rest_server->get_routes();
        $route = $routes['/aratavietnam/v1/search'][0];
        
        $this->assertEquals(['GET'], $route['methods']);
        $this->assertEquals('aratavietnam_custom_search_callback', $route['callback'][1]);
        $this->assertEquals('__return_true', $route['permission_callback'][1]);
    }
    
    public function test_search_endpoint_response_structure() {
        // Create test posts
        $post_id = $this->create_post([
            'post_title' => 'Test Search Post',
            'post_content' => 'This is a test post for search functionality',
            'post_type' => 'post'
        ]);
        
        $page_id = $this->create_page([
            'post_title' => 'Test Search Page',
            'post_content' => 'This is a test page for search functionality',
            'post_type' => 'page'
        ]);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'test');
        $request->set_param('per_page', 10);
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        $this->assertIsArray($data);
        
        if (!empty($data)) {
            $result = $data[0];
            $this->assertArrayHasKey('id', $result);
            $this->assertArrayHasKey('title', $result);
            $this->assertArrayHasKey('excerpt', $result);
            $this->assertArrayHasKey('url', $result);
            $this->assertArrayHasKey('type', $result);
            $this->assertArrayHasKey('type_label', $result);
            $this->assertArrayHasKey('featured_image', $result);
            $this->assertArrayHasKey('featured_image_thumbnail', $result);
            $this->assertArrayHasKey('date', $result);
            $this->assertArrayHasKey('author', $result);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
        wp_delete_post($page_id, true);
    }
    
    public function test_search_endpoint_with_no_results() {
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'nonexistent');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        $this->assertIsArray($data);
        $this->assertEmpty($data);
    }
    
    public function test_search_endpoint_validation() {
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        // Missing required search parameter
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        $this->assertIsArray($data);
        $this->assertEmpty($data);
    }
    
    public function test_search_endpoint_sanitization() {
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', '<script>alert("xss")</script>');
        $request->set_param('per_page', 'abc'); // Invalid per_page
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        // Should not execute script and should handle invalid per_page gracefully
        $data = $response->get_data();
        $this->assertIsArray($data);
    }
    
    public function test_search_endpoint_per_page_limit() {
        // Create multiple test posts
        $post_ids = [];
        for ($i = 0; $i < 15; $i++) {
            $post_ids[] = $this->create_post([
                'post_title' => "Test Post {$i}",
                'post_content' => "Content for test post {$i}",
                'post_type' => 'post'
            ]);
        }
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'test');
        $request->set_param('per_page', 10);
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        $this->assertLessThanOrEqual(10, count($data));
        
        // Clean up
        foreach ($post_ids as $post_id) {
            wp_delete_post($post_id, true);
        }
    }
    
    public function test_search_endpoint_with_featured_images() {
        // Create test post with featured image
        $post_id = $this->create_post([
            'post_title' => 'Test Post with Image',
            'post_content' => 'Test content',
            'post_type' => 'post'
        ]);
        
        // Add featured image
        $image_path = $this->create_test_image();
        $attachment_id = $this->create_attachment($image_path, $post_id);
        set_post_thumbnail($post_id, $attachment_id);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'image');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        if (!empty($data)) {
            $result = $data[0];
            $this->assertStringContainsString('test-image', $result['featured_image']);
            $this->assertStringContainsString('test-image', $result['featured_image_thumbnail']);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
        wp_delete_attachment($attachment_id, true);
    }
    
    public function test_search_endpoint_without_featured_images() {
        $post_id = $this->create_post([
            'post_title' => 'Test Post without Image',
            'post_content' => 'Test content',
            'post_type' => 'post'
        ]);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'without');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        if (!empty($data)) {
            $result = $data[0];
            $this->assertStringContainsString('placeholder.svg', $result['featured_image']);
            $this->assertStringContainsString('placeholder.svg', $result['featured_image_thumbnail']);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_search_endpoint_multiple_post_types() {
        $post_id = $this->create_post([
            'post_title' => 'Test Post',
            'post_content' => 'Test content',
            'post_type' => 'post'
        ]);
        
        $page_id = $this->create_page([
            'post_title' => 'Test Page',
            'post_content' => 'Test content',
            'post_type' => 'page'
        ]);
        
        if (class_exists('WooCommerce')) {
            $product_id = $this->create_post([
                'post_title' => 'Test Product',
                'post_content' => 'Test content',
                'post_type' => 'product'
            ]);
            update_post_meta($product_id, '_price', '10000');
            update_post_meta($product_id, '_regular_price', '10000');
        }
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'test');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        $this->assertIsArray($data);
        
        $types = array_column($data, 'type');
        $this->assertContains('post', $types);
        $this->assertContains('page', $types);
        
        if (class_exists('WooCommerce')) {
            $this->assertContains('product', $types);
            wp_delete_post($product_id, true);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
        wp_delete_post($page_id, true);
    }
    
    public function test_search_endpoint_excerpt_generation() {
        $post_id = $this->create_post([
            'post_title' => 'Test Excerpt',
            'post_content' => 'This is a long content that should be truncated when generating excerpt for search results',
            'post_type' => 'post'
        ]);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'excerpt');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        if (!empty($data)) {
            $result = $data[0];
            $this->assertStringEndsWith('...', $result['excerpt']);
            $this->assertLessThanOrEqual(200, strlen($result['excerpt']));
        }
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_search_endpoint_date_format() {
        $post_id = $this->create_post([
            'post_title' => 'Test Date',
            'post_content' => 'Test content',
            'post_type' => 'post',
            'post_date' => '2024-01-15 10:00:00'
        ]);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'date');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        if (!empty($data)) {
            $result = $data[0];
            $this->assertEquals('15/01/2024', $result['date']);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_search_endpoint_author_field() {
        $author_id = $this->create_user('author');
        $post_id = $this->create_post([
            'post_title' => 'Test Author',
            'post_content' => 'Test content',
            'post_type' => 'post',
            'post_author' => $author_id
        ]);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'author');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        if (!empty($data)) {
            $result = $data[0];
            $this->assertNotEmpty($result['author']);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
        wp_delete_user($author_id);
    }
    
    public function test_search_endpoint_type_labels() {
        $post_id = $this->create_post([
            'post_title' => 'Test Type Label',
            'post_content' => 'Test content',
            'post_type' => 'post'
        ]);
        
        $page_id = $this->create_page([
            'post_title' => 'Test Type Label',
            'post_content' => 'Test content',
            'post_type' => 'page'
        ]);
        
        $request = new WP_REST_Request('GET', '/aratavietnam/v1/search');
        $request->set_param('search', 'label');
        
        $response = rest_do_request($request);
        $this->assertRestResponse($response, 200);
        
        $data = $response->get_data();
        if (!empty($data)) {
            $type_labels = array_column($data, 'type_label');
            $this->assertContains('Post', $type_labels);
            $this->assertContains('Page', $type_labels);
        }
        
        // Clean up
        wp_delete_post($post_id, true);
        wp_delete_post($page_id, true);
    }
}