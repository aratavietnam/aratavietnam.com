# API Reference Documentation

## Overview

The Arata Vietnam theme provides various APIs and functions for developers to extend and customize functionality.

## Theme Functions API

### Core Theme Functions

#### Theme Initialization
```php
function aratavietnam(): TailPress\Framework\Theme
```
**Description**: Main theme initialization function using TailPress framework
**Returns**: TailPress Theme instance
**Location**: `functions.php`

### Post View Tracking

#### Get Post Views
```php
function arata_get_post_views($postID)
```
**Parameters**:
- `$postID` (int): Post ID to get view count for
**Returns**: String formatted view count (e.g., "150 Views")
**Example**:
```php
echo arata_get_post_views(123); // "150 Views"
```

#### Set Post Views
```php
function arata_set_post_views($postID)
```
**Parameters**:
- `$postID` (int): Post ID to increment view count
**Returns**: void
**Description**: Increments post view count by 1

#### Track Post Views (Auto)
```php
function arata_track_post_views($post_id = null)
```
**Parameters**:
- `$post_id` (int, optional): Post ID (defaults to current post)
**Returns**: void
**Hook**: `wp_head`
**Description**: Automatically tracks views on single post pages

### Custom Post Types API

#### Register Custom Post Types
The theme automatically registers these post types:

##### Promotions
```php
register_post_type('promotion', [
    'labels' => [...],
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'khuyen-mai'],
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields']
]);
```

##### Job Postings
```php
register_post_type('job_posting', [
    'labels' => [...],
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'tuyen-dung'],
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields']
]);
```

##### Services
```php
register_post_type('service', [
    'labels' => [...],
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'dich-vu'],
    'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields']
]);
```

### Template Functions

#### Register Page Templates
```php
function aratavietnam_register_page_templates($templates)
```
**Parameters**:
- `$templates` (array): Existing templates array
**Returns**: array - Modified templates array
**Hook**: `theme_page_templates`

**Available Templates**:
- `page-templates/news.php` → 'News Page'
- `page-templates/promotions.php` → 'Promotions Page'
- `page-templates/careers.php` → 'Careers Page'
- `page-templates/blog.php` → 'Blog Page'
- `page-templates/contact.php` → 'Contact Page'
- `page-templates/services.php` → 'Services Page'

#### Force Template Recognition
```php
function aratavietnam_force_template_recognition($template)
```
**Parameters**:
- `$template` (string): Current template path
**Returns**: string - Modified template path
**Hook**: `template_include`

## WordPress Hooks and Filters

### Actions

#### Theme Setup
```php
add_action('after_setup_theme', 'aratavietnam_setup');
add_action('wp_enqueue_scripts', 'aratavietnam_scripts');
add_action('init', 'aratavietnam_register_post_types');
```

#### Post View Tracking
```php
add_action('wp_head', 'arata_track_post_views');
```

#### Custom Post Types
```php
add_action('init', function() {
    // Register promotions post type
});

add_action('init', function() {
    // Register job postings post type
});
```

#### Meta Boxes
```php
add_action('add_meta_boxes', function() {
    // Add custom meta boxes
});

add_action('save_post', function($post_id) {
    // Save custom meta fields
});
```

### Filters

#### Comment Form Customization
```php
add_filter('comment_form_defaults', function($defaults) {
    $defaults['title_reply'] = '';
    return $defaults;
});
```

#### Admin Columns
```php
add_filter('manage_promotion_posts_columns', function($columns) {
    // Customize promotion admin columns
});

add_filter('manage_job_posting_posts_columns', function($columns) {
    // Customize job posting admin columns
});
```

#### Template Loading
```php
add_filter('theme_page_templates', 'aratavietnam_register_page_templates');
add_filter('template_include', 'aratavietnam_force_template_recognition', 99);
```

## Custom Meta Fields API

### Promotion Meta Fields

#### Available Fields
```php
// Promotion type
get_post_meta($post_id, 'arata_promotion_type', true);

// Start date
get_post_meta($post_id, 'arata_promotion_start_date', true);

// End date
get_post_meta($post_id, 'arata_promotion_end_date', true);

// Terms and conditions
get_post_meta($post_id, 'arata_promotion_terms', true);

// Discount amount
get_post_meta($post_id, 'arata_promotion_discount', true);
```

### Job Posting Meta Fields

#### Available Fields
```php
// Department
get_post_meta($post_id, 'arata_job_department', true);

// Location
get_post_meta($post_id, 'arata_job_location', true);

// Job type
get_post_meta($post_id, 'arata_job_type', true);

// Salary range
get_post_meta($post_id, 'arata_job_salary', true);

// Application deadline
get_post_meta($post_id, 'arata_job_deadline', true);

// Requirements
get_post_meta($post_id, 'arata_job_requirements', true);

// Benefits
get_post_meta($post_id, 'arata_job_benefits', true);
```

### Service Meta Fields

#### Available Fields
```php
// Service price
get_post_meta($post_id, 'arata_service_price', true);

// Service duration
get_post_meta($post_id, 'arata_service_duration', true);

// Service features
get_post_meta($post_id, 'arata_service_features', true);

// Service category
get_post_meta($post_id, 'arata_service_category', true);

// Display order
get_post_meta($post_id, 'arata_service_order', true);
```

## Form Handling API

### Contact Form
```php
// Form submission handler
add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');

function handle_contact_form_submission() {
    // Process contact form data
    // Located in: inc/contact-form.php
}
```

### Newsletter Subscription
```php
// Newsletter subscription handler
add_action('wp_ajax_newsletter_subscription', 'handle_newsletter_subscription');
add_action('wp_ajax_nopriv_newsletter_subscription', 'handle_newsletter_subscription');
```

### Job Application
```php
// Job application handler
add_action('wp_ajax_job_application', 'handle_job_application');
add_action('wp_ajax_nopriv_job_application', 'handle_job_application');
```

## REST API Endpoints

### Custom Post Types

All custom post types are available via WordPress REST API:

#### Promotions
```http
GET /wp-json/wp/v2/promotion
GET /wp-json/wp/v2/promotion/{id}
POST /wp-json/wp/v2/promotion
PUT /wp-json/wp/v2/promotion/{id}
DELETE /wp-json/wp/v2/promotion/{id}
```

#### Job Postings
```http
GET /wp-json/wp/v2/job_posting
GET /wp-json/wp/v2/job_posting/{id}
POST /wp-json/wp/v2/job_posting
PUT /wp-json/wp/v2/job_posting/{id}
DELETE /wp-json/wp/v2/job_posting/{id}
```

#### Services
```http
GET /wp-json/wp/v2/service
GET /wp-json/wp/v2/service/{id}
POST /wp-json/wp/v2/service
PUT /wp-json/wp/v2/service/{id}
DELETE /wp-json/wp/v2/service/{id}
```

### Custom Endpoints

#### Get Active Promotions
```http
GET /wp-json/arata/v1/promotions/active
```

Response:
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "title": "Summer Sale",
      "start_date": "2024-06-01",
      "end_date": "2024-08-31",
      "discount": "50"
    }
  ]
}
```

#### Submit Contact Form
```http
POST /wp-json/arata/v1/contact
```

Request Body:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "message": "Hello, I'm interested in your services."
}
```

## JavaScript API

### Theme JavaScript Functions

#### Form Validation
```javascript
// Contact form validation
function validateContactForm(formData) {
    // Validation logic
    // Located in: resources/js/app.js
}

// Job application validation
function validateJobApplication(formData) {
    // Validation logic
}
```

#### AJAX Helpers
```javascript
// Generic AJAX helper
function submitFormData(endpoint, formData, callback) {
    fetch(endpoint, {
        method: 'POST',
        body: formData,
        headers: {
            'X-WP-Nonce': wpApiSettings.nonce
        }
    })
    .then(response => response.json())
    .then(callback);
}
```

### Frontend Events

#### Custom Events
```javascript
// Promotion loaded event
document.dispatchEvent(new CustomEvent('promotionLoaded', {
    detail: { promotionId: 123 }
}));

// Job application submitted event
document.dispatchEvent(new CustomEvent('jobApplicationSubmitted', {
    detail: { jobId: 456, applicationId: 789 }
}));
```

## Customizer API

### Footer Customizer

#### Available Settings
```php
// Company information
$wp_customize->add_setting('footer_company_name');
$wp_customize->add_setting('footer_company_address');
$wp_customize->add_setting('footer_company_phone');
$wp_customize->add_setting('footer_company_email');

// Social media
$wp_customize->add_setting('footer_facebook_url');
$wp_customize->add_setting('footer_instagram_url');
$wp_customize->add_setting('footer_website_url');
$wp_customize->add_setting('footer_tiktok_url');
$wp_customize->add_setting('footer_shopee_url');
```

#### Usage in Templates
```php
// Get customizer values
$company_name = get_theme_mod('footer_company_name', 'Công ty TNHH Arata Việt Nam');
$facebook_url = get_theme_mod('footer_facebook_url', '');
```

## Security API

### Nonce Verification
```php
// Verify nonce in form submissions
if (!wp_verify_nonce($_POST['nonce'], 'contact_form_nonce')) {
    wp_die('Security check failed');
}
```

### Data Sanitization
```php
// Sanitize input data
$name = sanitize_text_field($_POST['name']);
$email = sanitize_email($_POST['email']);
$message = sanitize_textarea_field($_POST['message']);
```

### Capability Checks
```php
// Check user capabilities
if (!current_user_can('edit_posts')) {
    wp_die('Insufficient permissions');
}
```

## Utility Functions

### Date Formatting
```php
function arata_format_date($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}
```

### URL Helpers
```php
function arata_get_promotion_url($promotion_id) {
    return get_permalink($promotion_id);
}

function arata_get_job_url($job_id) {
    return get_permalink($job_id);
}
```

### Image Helpers
```php
function arata_get_featured_image_url($post_id, $size = 'medium') {
    return get_the_post_thumbnail_url($post_id, $size);
}
```

## Error Handling

### Custom Error Messages
```php
// Add custom error handling
function arata_handle_error($error_code, $error_message) {
    error_log("Arata Theme Error [{$error_code}]: {$error_message}");

    if (WP_DEBUG) {
        wp_die($error_message);
    }

    return false;
}
```

### Form Error Responses
```php
// JSON error response
function arata_json_error($message, $code = 400) {
    wp_send_json_error([
        'message' => $message,
        'code' => $code
    ], $code);
}

// JSON success response
function arata_json_success($data = []) {
    wp_send_json_success($data);
}
```

This API reference provides developers with comprehensive information for extending and customizing the Arata Vietnam theme functionality.
