# Custom Post Types Documentation

## Overview

The Arata Vietnam theme includes several custom post types to manage different types of content beyond standard WordPress posts and pages.

## Available Post Types

### 1. Promotions (Khuyến mãi)
**Post Type**: `promotion`
**Slug**: `/khuyen-mai/`
**Purpose**: Manage marketing campaigns and promotional offers

#### Fields
- **Title**: Promotion name/title
- **Content**: Detailed promotion description
- **Featured Image**: Promotion banner/image
- **Excerpt**: Short description for listings
- **Custom Fields**:
  - `arata_promotion_type`: Type of promotion (string)
  - `arata_promotion_start_date`: Start date (date)
  - `arata_promotion_end_date`: End date (date)
  - `arata_promotion_terms`: Terms and conditions (textarea)
  - `arata_promotion_discount`: Discount amount (number)

#### Admin Columns
- Title
- Promotion Type
- Start Date
- End Date
- Date Created

#### Archive Page
- URL: `/khuyen-mai/`
- Template: `archive-promotion.php`
- Displays: Grid of active promotions

#### Single Page
- URL: `/khuyen-mai/[slug]/`
- Template: `single-promotion.php`
- Displays: Full promotion details

### 2. Job Postings (Tuyển dụng)
**Post Type**: `job_posting`
**Slug**: `/tuyen-dung/`
**Purpose**: Manage job opportunities and recruitment

#### Fields
- **Title**: Job position title
- **Content**: Job description and requirements
- **Featured Image**: Company/position image
- **Excerpt**: Brief job summary
- **Custom Fields**:
  - `arata_job_department`: Department (string)
  - `arata_job_location`: Work location (string)
  - `arata_job_type`: Job type (full-time, part-time, contract)
  - `arata_job_salary`: Salary range (string)
  - `arata_job_deadline`: Application deadline (date)
  - `arata_job_requirements`: Requirements (textarea)
  - `arata_job_benefits`: Benefits offered (textarea)

#### Admin Columns
- Position Title
- Department
- Location
- Application Deadline
- Date Posted

#### Archive Page
- URL: `/tuyen-dung/`
- Template: `archive-job_posting.php`
- Displays: List of available positions

#### Single Page
- URL: `/tuyen-dung/[slug]/`
- Template: `single-job_posting.php`
- Displays: Full job details with application form

### 3. Services (Dịch vụ)
**Post Type**: `service`
**Slug**: `/dich-vu/`
**Purpose**: Manage company services and offerings

#### Fields
- **Title**: Service name
- **Content**: Service description
- **Featured Image**: Service image/icon
- **Excerpt**: Service summary
- **Custom Fields**:
  - `arata_service_price`: Price range (string)
  - `arata_service_duration`: Service duration (string)
  - `arata_service_features`: Key features (array)
  - `arata_service_category`: Service category (taxonomy)
  - `arata_service_order`: Display order (number)

#### Archive Page
- URL: `/dich-vu/`
- Template: `archive-service.php`
- Displays: Service catalog grid

#### Single Page
- URL: `/dich-vu/[slug]/`
- Template: `single-service.php`
- Displays: Service details with contact form

### 4. Newsletter Subscriptions (Đăng ký khuyến mãi)
**Post Type**: `newsletter_sub`
**Purpose**: Store newsletter subscription data (admin-only)

#### Fields
- **Title**: Auto-generated (Email + Date)
- **Custom Fields**:
  - `arata_subscriber_email`: Email address
  - `arata_subscriber_name`: Full name (optional)
  - `arata_subscriber_phone`: Phone number (optional)
  - `arata_subscription_source`: Source page
  - `arata_subscription_date`: Subscription date

#### Access
- Not publicly visible
- Admin-only access
- Used for email marketing management

### 5. Job Applications (Hồ sơ ứng tuyển)
**Post Type**: `job_application`
**Purpose**: Store job application data (admin-only)

#### Fields
- **Title**: Auto-generated (Name + Position + Date)
- **Custom Fields**:
  - `arata_applicant_name`: Full name
  - `arata_applicant_email`: Email address
  - `arata_applicant_phone`: Phone number
  - `arata_applied_position`: Job position
  - `arata_applicant_cv`: CV file upload
  - `arata_cover_letter`: Cover letter text
  - `arata_application_date`: Application date

#### Access
- Not publicly visible
- Admin-only access
- HR management functionality

## Usage Examples

### Creating Content

#### Add New Promotion
```php
// Programmatically create promotion
$promotion_id = wp_insert_post([
    'post_type' => 'promotion',
    'post_title' => 'Summer Sale 2024',
    'post_content' => 'Get 50% off on all products...',
    'post_status' => 'publish'
]);

// Add custom fields
update_post_meta($promotion_id, 'arata_promotion_type', 'Seasonal Sale');
update_post_meta($promotion_id, 'arata_promotion_start_date', '2024-06-01');
update_post_meta($promotion_id, 'arata_promotion_end_date', '2024-08-31');
```

#### Add New Job Posting
```php
$job_id = wp_insert_post([
    'post_type' => 'job_posting',
    'post_title' => 'Frontend Developer',
    'post_content' => 'We are looking for a skilled frontend developer...',
    'post_status' => 'publish'
]);

update_post_meta($job_id, 'arata_job_department', 'Engineering');
update_post_meta($job_id, 'arata_job_location', 'Ho Chi Minh City');
update_post_meta($job_id, 'arata_job_deadline', '2024-12-31');
```

### Querying Content

#### Get Active Promotions
```php
$active_promotions = new WP_Query([
    'post_type' => 'promotion',
    'posts_per_page' => 10,
    'meta_query' => [
        'relation' => 'AND',
        [
            'key' => 'arata_promotion_start_date',
            'value' => date('Y-m-d'),
            'compare' => '<='
        ],
        [
            'key' => 'arata_promotion_end_date',
            'value' => date('Y-m-d'),
            'compare' => '>='
        ]
    ]
]);
```

#### Get Jobs by Department
```php
$engineering_jobs = new WP_Query([
    'post_type' => 'job_posting',
    'meta_query' => [
        [
            'key' => 'arata_job_department',
            'value' => 'Engineering',
            'compare' => '='
        ]
    ]
]);
```

#### Get Services by Category
```php
$consultation_services = new WP_Query([
    'post_type' => 'service',
    'meta_query' => [
        [
            'key' => 'arata_service_category',
            'value' => 'consultation',
            'compare' => '='
        ]
    ],
    'orderby' => 'meta_value_num',
    'meta_key' => 'arata_service_order',
    'order' => 'ASC'
]);
```

## Template Files

### Archive Templates
- `archive-promotion.php` - Promotions listing
- `archive-job_posting.php` - Jobs listing
- `archive-service.php` - Services listing

### Single Templates
- `single-promotion.php` - Single promotion
- `single-job_posting.php` - Single job posting
- `single-service.php` - Single service

### Template Parts
- `template-parts/content-promotion.php` - Promotion content
- `template-parts/content-job.php` - Job content
- `template-parts/content-service.php` - Service content

## Customization

### Adding Custom Fields

```php
// Add to inc/news-meta-fields.php or inc/services-post-types.php
add_action('add_meta_boxes', function() {
    add_meta_box(
        'custom_field_box',
        'Custom Fields',
        'custom_field_callback',
        'promotion',
        'normal',
        'high'
    );
});

function custom_field_callback($post) {
    $value = get_post_meta($post->ID, 'custom_field_key', true);
    echo '<input type="text" name="custom_field_key" value="' . esc_attr($value) . '">';
}
```

### Modifying Admin Columns

```php
// Add to inc/admin-columns.php
add_filter('manage_promotion_posts_columns', function($columns) {
    $columns['custom_column'] = 'Custom Field';
    return $columns;
});

add_action('manage_promotion_posts_custom_column', function($column, $post_id) {
    if ($column === 'custom_column') {
        echo get_post_meta($post_id, 'custom_field_key', true);
    }
}, 10, 2);
```

### Custom Taxonomies

```php
// Add custom taxonomy for job categories
register_taxonomy('job_category', 'job_posting', [
    'hierarchical' => true,
    'labels' => [
        'name' => 'Job Categories',
        'singular_name' => 'Job Category'
    ],
    'show_ui' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'job-category']
]);
```

## REST API

All custom post types are available via WordPress REST API:

### Endpoints
- `/wp-json/wp/v2/promotion` - Promotions
- `/wp-json/wp/v2/job_posting` - Job postings
- `/wp-json/wp/v2/service` - Services

### Example Usage
```javascript
// Fetch active promotions
fetch('/wp-json/wp/v2/promotion?status=publish')
    .then(response => response.json())
    .then(promotions => {
        console.log(promotions);
    });
```

## Best Practices

### Content Management
1. Use descriptive titles and slugs
2. Always add featured images
3. Fill in all custom fields
4. Use excerpts for listings
5. Set proper publication dates

### SEO Optimization
1. Use SEO-friendly slugs
2. Add meta descriptions
3. Optimize images with alt text
4. Use proper heading structure
5. Internal linking between related content

### Performance
1. Limit queries with `posts_per_page`
2. Use `WP_Query` appropriately
3. Cache expensive queries
4. Optimize images
5. Use pagination for large datasets

### Security
1. Sanitize all input data
2. Validate custom field values
3. Use nonces for forms
4. Proper capability checks
5. Escape output data

This comprehensive system allows for flexible content management while maintaining a clean, organized structure for the Arata Vietnam website.
