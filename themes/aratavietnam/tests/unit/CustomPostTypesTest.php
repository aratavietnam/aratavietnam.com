<?php
/**
 * Test custom post types registration and functionality
 */

class CustomPostTypesTest extends ThemeTestCase {
    
    public function test_news_post_type_exists() {
        $this->assertPostTypeExists('news');
        
        $post_type = get_post_type_object('news');
        $this->assertEquals('news', $post_type->name);
        $this->assertTrue($post_type->public);
        $this->assertTrue($post_type->has_archive);
        $this->assertEquals('News', $post_type->labels->name);
        $this->assertEquals('News Item', $post_type->labels->singular_name);
    }
    
    public function test_service_post_type_exists() {
        $this->assertPostTypeExists('service');
        
        $post_type = get_post_type_object('service');
        $this->assertEquals('service', $post_type->name);
        $this->assertTrue($post_type->public);
        $this->assertTrue($post_type->has_archive);
        $this->assertEquals('Services', $post_type->labels->name);
        $this->assertEquals('Service', $post_type->labels->singular_name);
    }
    
    public function test_job_posting_post_type_exists() {
        $this->assertPostTypeExists('job_posting');
        
        $post_type = get_post_type_object('job_posting');
        $this->assertEquals('job_posting', $post_type->name);
        $this->assertTrue($post_type->public);
        $this->assertTrue($post_type->has_archive);
        $this->assertEquals('Job Postings', $post_type->labels->name);
        $this->assertEquals('Job Posting', $post_type->labels->singular_name);
    }
    
    public function test_partner_post_type_exists() {
        $this->assertPostTypeExists('partner');
        
        $post_type = get_post_type_object('partner');
        $this->assertEquals('partner', $post_type->name);
        $this->assertTrue($post_type->public);
        $this->assertTrue($post_type->has_archive);
        $this->assertEquals('Partners', $post_type->labels->name);
        $this->assertEquals('Partner', $post_type->labels->singular_name);
    }
    
    public function test_product_brand_taxonomy_exists() {
        $this->assertTaxonomyExists('product_brand');
        
        $taxonomy = get_taxonomy('product_brand');
        $this->assertEquals('product_brand', $taxonomy->name);
        $this->assertTrue($taxonomy->public);
        $this->assertTrue($taxonomy->show_ui);
        $this->assertEquals('Product Brands', $taxonomy->labels->name);
        $this->assertEquals('Product Brand', $taxonomy->labels->singular_name);
    }
    
    public function test_news_post_creation() {
        $post_id = $this->create_test_news_post();
        
        $this->assertGreaterThan(0, $post_id);
        $this->assertEquals('news', get_post_type($post_id));
        $this->assertEquals('publish', get_post_status($post_id));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_service_post_creation() {
        $post_id = $this->create_test_service_post();
        
        $this->assertGreaterThan(0, $post_id);
        $this->assertEquals('service', get_post_type($post_id));
        $this->assertEquals('publish', get_post_status($post_id));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_job_posting_creation() {
        $post_id = $this->create_test_job_posting();
        
        $this->assertGreaterThan(0, $post_id);
        $this->assertEquals('job_posting', get_post_type($post_id));
        $this->assertEquals('publish', get_post_status($post_id));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_partner_creation() {
        $post_id = $this->create_test_partner();
        
        $this->assertGreaterThan(0, $post_id);
        $this->assertEquals('partner', get_post_type($post_id));
        $this->assertEquals('publish', get_post_status($post_id));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_news_post_meta_fields() {
        $post_id = $this->create_test_news_post();
        
        // Test meta fields
        update_post_meta($post_id, '_news_featured', '1');
        update_post_meta($post_id, '_news_video_url', 'https://youtube.com/watch?v=test');
        update_post_meta($post_id, '_news_source', 'Test Source');
        update_post_meta($post_id, '_news_author', 'Test Author');
        
        $this->assertEquals('1', get_post_meta($post_id, '_news_featured', true));
        $this->assertEquals('https://youtube.com/watch?v=test', get_post_meta($post_id, '_news_video_url', true));
        $this->assertEquals('Test Source', get_post_meta($post_id, '_news_source', true));
        $this->assertEquals('Test Author', get_post_meta($post_id, '_news_author', true));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_service_post_meta_fields() {
        $post_id = $this->create_test_service_post();
        
        // Test meta fields
        update_post_meta($post_id, '_service_icon', 'icon-service');
        update_post_meta($post_id, '_service_price', '1000000');
        update_post_meta($post_id, '_service_duration', '60');
        update_post_meta($post_id, '_service_featured', '1');
        
        $this->assertEquals('icon-service', get_post_meta($post_id, '_service_icon', true));
        $this->assertEquals('1000000', get_post_meta($post_id, '_service_price', true));
        $this->assertEquals('60', get_post_meta($post_id, '_service_duration', true));
        $this->assertEquals('1', get_post_meta($post_id, '_service_featured', true));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_job_posting_meta_fields() {
        $post_id = $this->create_test_job_posting();
        
        // Test meta fields
        update_post_meta($post_id, '_job_location', 'Ho Chi Minh City');
        update_post_meta($post_id, '_job_salary', '10000000');
        update_post_meta($post_id, '_job_type', 'full-time');
        update_post_meta($post_id, '_job_experience', '2 years');
        update_post_meta($post_id, '_job_deadline', '2024-12-31');
        
        $this->assertEquals('Ho Chi Minh City', get_post_meta($post_id, '_job_location', true));
        $this->assertEquals('10000000', get_post_meta($post_id, '_job_salary', true));
        $this->assertEquals('full-time', get_post_meta($post_id, '_job_type', true));
        $this->assertEquals('2 years', get_post_meta($post_id, '_job_experience', true));
        $this->assertEquals('2024-12-31', get_post_meta($post_id, '_job_deadline', true));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_partner_meta_fields() {
        $post_id = $this->create_test_partner();
        
        // Test meta fields
        update_post_meta($post_id, '_partner_website', 'https://example.com');
        update_post_meta($post_id, '_partner_logo', '123');
        update_post_meta($post_id, '_partner_featured', '1');
        
        $this->assertEquals('https://example.com', get_post_meta($post_id, '_partner_website', true));
        $this->assertEquals('123', get_post_meta($post_id, '_partner_logo', true));
        $this->assertEquals('1', get_post_meta($post_id, '_partner_featured', true));
        
        // Clean up
        wp_delete_post($post_id, true);
    }
    
    public function test_product_brand_taxonomy_terms() {
        // Create test terms
        $brand1 = wp_insert_term('Brand 1', 'product_brand');
        $brand2 = wp_insert_term('Brand 2', 'product_brand');
        
        $this->assertNotWPError($brand1);
        $this->assertNotWPError($brand2);
        
        // Test term retrieval
        $terms = get_terms('product_brand', ['hide_empty' => false]);
        $this->assertIsArray($terms);
        $this->assertGreaterThan(0, count($terms));
        
        $term_names = array_column($terms, 'name');
        $this->assertContains('Brand 1', $term_names);
        $this->assertContains('Brand 2', $term_names);
        
        // Clean up
        wp_delete_term($brand1['term_id'], 'product_brand');
        wp_delete_term($brand2['term_id'], 'product_brand');
    }
    
    public function test_post_type_archive_urls() {
        $this->assertStringContainsString('/news/', get_post_type_archive_link('news'));
        $this->assertStringContainsString('/service/', get_post_type_archive_link('service'));
        $this->assertStringContainsString('/job_posting/', get_post_type_archive_link('job_posting'));
        $this->assertStringContainsString('/partner/', get_post_type_archive_link('partner'));
    }
    
    public function test_post_type_single_urls() {
        $news_id = $this->create_test_news_post();
        $service_id = $this->create_test_service_post();
        
        $news_url = get_permalink($news_id);
        $service_url = get_permalink($service_id);
        
        $this->assertStringContainsString('/news/', $news_url);
        $this->assertStringContainsString('/service/', $service_url);
        
        // Clean up
        wp_delete_post($news_id, true);
        wp_delete_post($service_id, true);
    }
    
    public function test_post_type_query_var() {
        $this->assertTrue(get_post_type_object('news')->publicly_queryable);
        $this->assertTrue(get_post_type_object('service')->publicly_queryable);
        $this->assertTrue(get_post_type_object('job_posting')->publicly_queryable);
        $this->assertTrue(get_post_type_object('partner')->publicly_queryable);
    }
    
    public function test_post_type_supports() {
        $this->assertTrue(post_type_supports('news', 'title'));
        $this->assertTrue(post_type_supports('news', 'editor'));
        $this->assertTrue(post_type_supports('news', 'thumbnail'));
        $this->assertTrue(post_type_supports('news', 'excerpt'));
        $this->assertTrue(post_type_supports('news', 'custom-fields'));
        
        $this->assertTrue(post_type_supports('service', 'title'));
        $this->assertTrue(post_type_supports('service', 'editor'));
        $this->assertTrue(post_type_supports('service', 'thumbnail'));
        $this->assertTrue(post_type_supports('service', 'excerpt'));
        $this->assertTrue(post_type_supports('service', 'custom-fields'));
    }
    
    public function test_post_type_rewrite_rules() {
        $news_object = get_post_type_object('news');
        $service_object = get_post_type_object('service');
        
        $this->assertNotEmpty($news_object->rewrite);
        $this->assertNotEmpty($service_object->rewrite);
        
        $this->assertTrue($news_object->rewrite['with_front']);
        $this->assertTrue($service_object->rewrite['with_front']);
    }
    
    public function test_post_type_capabilities() {
        $news_object = get_post_type_object('news');
        $service_object = get_post_type_object('service');
        
        $this->assertIsArray($news_object->cap);
        $this->assertIsArray($service_object->cap);
        
        $this->assertArrayHasKey('edit_post', $news_object->cap);
        $this->assertArrayHasKey('read_post', $news_object->cap);
        $this->assertArrayHasKey('delete_post', $news_object->cap);
        
        $this->assertArrayHasKey('edit_post', $service_object->cap);
        $this->assertArrayHasKey('read_post', $service_object->cap);
        $this->assertArrayHasKey('delete_post', $service_object->cap);
    }
}