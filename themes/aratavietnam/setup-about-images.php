<?php
/**
 * Script to set up default About section images
 */

// Include WordPress
require_once('wp-config.php');

// Front page ID
$front_page_id = get_option('page_on_front');

echo "Setting up default About section images...\n";
echo "Front Page ID: $front_page_id\n";

// Default image URLs to import
$image_urls = array(
    'https://picsum.photos/seed/arata-about-1/800/600.jpg',
    'https://picsum.photos/seed/arata-about-2/800/600.jpg',
    'https://picsum.photos/seed/arata-about-3/800/600.jpg'
);

// Import images and set as main about image
if ($front_page_id) {
    // Import main about image
    $main_image_url = 'https://picsum.photos/seed/arata-about-main/800/600.jpg';
    echo "Importing main About image...\n";
    
    // Download and import image
    $tmp = download_url($main_image_url);
    $file_array = array(
        'name' => basename($main_image_url),
        'tmp_name' => $tmp
    );
    
    // Check for download errors
    if (is_wp_error($tmp)) {
        echo 'Download error: ' . $tmp->get_error_message() . "\n";
    } else {
        $attachment_id = media_handle_sideload($file_array, $front_page_id);
        
        if (is_wp_error($attachment_id)) {
            echo 'Error importing image: ' . $attachment_id->get_error_message() . "\n";
        } else {
            // Set as main about image
            update_post_meta($front_page_id, 'arata_about_image', $attachment_id);
            echo "✓ Main About image set with ID: $attachment_id\n";
            
            // Create additional images array
            $additional_images = array();
            
            // Import additional images
            foreach ($image_urls as $url) {
                $tmp2 = download_url($url);
                $file_array2 = array(
                    'name' => basename($url),
                    'tmp_name' => $tmp2
                );
                
                if (!is_wp_error($tmp2)) {
                    $att_id = media_handle_sideload($file_array2, $front_page_id);
                    if (!is_wp_error($att_id)) {
                        $additional_images[] = array('image_id' => $att_id);
                        echo "✓ Additional image imported with ID: $att_id\n";
                    }
                    @unlink($tmp2);
                }
            }
            
            // Save additional images
            if (!empty($additional_images)) {
                update_post_meta($front_page_id, '_about_images', $additional_images);
                echo "✓ " . count($additional_images) . " additional images saved\n";
            }
        }
        
        // Clean up
        @unlink($tmp);
    }
    
    echo "\nDone! About section images have been set up.\n";
    echo "Visit the WordPress admin to verify: /wp-admin/post.php?post=$front_page_id&action=edit\n";
} else {
    echo "Error: No front page is set.\n";
}
?>