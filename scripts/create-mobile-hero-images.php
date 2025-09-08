<?php
/**
 * Create mobile-specific hero images for testing
 */

// Include WordPress
require_once('wp-config.php');

// Mobile slide image IDs (these should be different from desktop ones)
$mobile_slide_ids = [280, 281, 282];

echo "Mobile hero slide image IDs: " . implode(', ', $mobile_slide_ids) . "\n";
echo "These images should be different from the desktop slide images (277, 278, 279)\n";
echo "\nTo use these features:\n";
echo "1. Upload mobile-specific images to the Media Library\n";
echo "2. Note their attachment IDs\n";
echo "3. In the Homepage Settings, add mobile images to each slide\n";
echo "4. The slider will now show different images on mobile vs desktop\n";
?>