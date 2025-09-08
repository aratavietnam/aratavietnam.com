<?php
/**
 * Base test case for general tests
 */

class TestCase extends WP_UnitTestCase {
    
    protected function setUp(): void {
        parent::setUp();
    }
    
    protected function create_post($args = []) {
        $defaults = [
            'post_title' => 'Test Post ' . rand(1, 1000),
            'post_content' => 'Test content',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'post'
        ];
        
        $args = wp_parse_args($args, $defaults);
        return $this->factory->post->create($args);
    }
    
    protected function create_page($args = []) {
        $defaults = [
            'post_title' => 'Test Page ' . rand(1, 1000),
            'post_content' => 'Test page content',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'page'
        ];
        
        $args = wp_parse_args($args, $defaults);
        return $this->factory->post->create($args);
    }
    
    protected function create_user($role = 'subscriber') {
        return $this->factory->user->create([
            'role' => $role,
            'user_login' => 'test_user_' . rand(1, 1000),
            'user_email' => 'test' . rand(1, 1000) . '@example.com'
        ]);
    }
    
    protected function create_attachment($file, $parent_id = 0) {
        $filename = basename($file);
        $upload = wp_upload_bits($filename, null, file_get_contents($file));
        
        $attachment = [
            'post_title' => $filename,
            'post_content' => '',
            'post_status' => 'inherit',
            'post_mime_type' => mime_content_type($file),
            'guid' => $upload['url']
        ];
        
        $attachment_id = wp_insert_attachment($attachment, $upload['file'], $parent_id);
        
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attachment_data);
        
        return $attachment_id;
    }
    
    protected function create_term($name, $taxonomy, $args = []) {
        $defaults = [
            'description' => 'Test term description',
            'slug' => sanitize_title($name)
        ];
        
        $args = wp_parse_args($args, $defaults);
        return wp_insert_term($name, $taxonomy, $args);
    }
    
    protected function add_post_meta($post_id, $meta_key, $meta_value) {
        return update_post_meta($post_id, $meta_key, $meta_value);
    }
    
    protected function get_post_meta($post_id, $meta_key, $single = true) {
        return get_post_meta($post_id, $meta_key, $single);
    }
    
    protected function assertHasAction($hook, $callback) {
        $this->assertTrue(has_action($hook, $callback) !== false, "Action {$hook} should have callback {$callback}");
    }
    
    protected function assertHasFilter($hook, $callback) {
        $this->assertTrue(has_filter($hook, $callback) !== false, "Filter {$hook} should have callback {$callback}");
    }
    
    protected function assertOptionExists($option_name) {
        $this->assertTrue(get_option($option_name) !== false, "Option {$option_name} should exist");
    }
    
    protected function assertOptionValue($option_name, $expected_value) {
        $this->assertEquals($expected_value, get_option($option_name), "Option {$option_name} should have value {$expected_value}");
    }
    
    protected function assertPostMeta($post_id, $meta_key, $expected_value) {
        $this->assertEquals($expected_value, get_post_meta($post_id, $meta_key, true), "Post {$post_id} should have meta {$meta_key} with value {$expected_value}");
    }
    
    protected function assertUserMeta($user_id, $meta_key, $expected_value) {
        $this->assertEquals($expected_value, get_user_meta($user_id, $meta_key, true), "User {$user_id} should have meta {$meta_key} with value {$expected_value}");
    }
    
    protected function assertTermExists($term, $taxonomy) {
        $term_obj = get_term_by('name', $term, $taxonomy);
        $this->assertNotFalse($term_obj, "Term {$term} should exist in taxonomy {$taxonomy}");
    }
    
    protected function assertPostHasTerm($post_id, $term, $taxonomy) {
        $this->assertTrue(has_term($term, $taxonomy, $post_id), "Post {$post_id} should have term {$term} in taxonomy {$taxonomy}");
    }
    
    protected function assertFileExists($file) {
        $this->assertTrue(file_exists($file), "File {$file} should exist");
    }
    
    protected function assertIsWritable($file) {
        $this->assertTrue(is_writable($file), "File {$file} should be writable");
    }
    
    protected function assertJson($string) {
        $this->assertJsonStringEqualsJsonString($string, json_decode($string, true), "String should be valid JSON");
    }
    
    protected function create_test_image() {
        $upload_dir = wp_upload_dir();
        $filename = 'test-image.jpg';
        $filepath = $upload_dir['path'] . '/' . $filename;
        
        // Create a simple test image
        $image = imagecreatetruecolor(100, 100);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        imagejpeg($image, $filepath);
        imagedestroy($image);
        
        return $filepath;
    }
    
    protected function cleanup_test_files() {
        $upload_dir = wp_upload_dir();
        $files = glob($upload_dir['path'] . '/test-image*');
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
    
    protected function get_rest_response($route, $method = 'GET', $params = []) {
        $request = new WP_REST_Request($method, $route);
        
        foreach ($params as $key => $value) {
            $request->set_param($key, $value);
        }
        
        return rest_do_request($request);
    }
    
    protected function assertRestResponse($response, $expected_status = 200) {
        $this->assertInstanceOf('WP_REST_Response', $response);
        $this->assertEquals($expected_status, $response->get_status());
    }
    
    protected function assertRestResponseData($response, $expected_data) {
        $this->assertRestResponse($response);
        $this->assertEquals($expected_data, $response->get_data());
    }
    
    public function tearDown(): void {
        $this->cleanup_test_files();
        parent::tearDown();
    }
}