# Best Practices

Comprehensive guide to best practices for developing WordPress themes with TailPress.

## Code Organization

### File Structure

Maintain a clean and logical file structure:

```
your-theme/
├── functions.php              # Theme configuration only
├── inc/                       # Additional PHP includes
│   ├── customizer.php        # Theme customizer
│   ├── template-functions.php # Template helper functions
│   └── admin.php             # Admin-specific code
├── template-parts/           # Reusable template components
│   ├── header/
│   ├── footer/
│   └── content/
├── resources/                # Source assets
│   ├── css/
│   │   ├── components/       # Component-specific styles
│   │   ├── layouts/          # Layout styles
│   │   └── utilities/        # Utility classes
│   └── js/
│       ├── components/       # JavaScript components
│       └── utils/            # Utility functions
└── src/                      # PHP classes
    ├── Admin/
    ├── Frontend/
    └── Utils/
```

### Naming Conventions

#### PHP

```php
// Classes: PascalCase
class ThemeCustomizer {}

// Functions: snake_case with theme prefix
function your_theme_setup() {}

// Constants: UPPER_SNAKE_CASE
define('YOUR_THEME_VERSION', '1.0.0');

// Variables: snake_case
$theme_options = get_option('theme_options');
```

#### CSS

```css
/* Classes: kebab-case */
.header-navigation {}
.content-wrapper {}

/* BEM methodology for components */
.card {}
.card__header {}
.card__body {}
.card--featured {}
```

#### JavaScript

```javascript
// Variables and functions: camelCase
const themeOptions = {};
function initializeTheme() {}

// Constants: UPPER_SNAKE_CASE
const API_ENDPOINT = '/wp-json/wp/v2/';

// Classes: PascalCase
class ThemeManager {}
```

## WordPress Integration

### Theme Setup

Keep functions.php focused on theme configuration:

```php
<?php
// Theme setup
function your_theme_setup() {
    // Theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    
    // Register menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'your-theme'),
        'footer' => __('Footer Menu', 'your-theme'),
    ]);
}
add_action('after_setup_theme', 'your_theme_setup');

// Include additional files
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/template-functions.php';

// Initialize TailPress
function your_theme(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(/* asset configuration */)
        ->features(/* theme features */)
        ->menus(/* menu configuration */)
        ->themeSupport(/* WordPress features */);
}

your_theme();
```

### Security Best Practices

#### Input Sanitization

```php
// Sanitize user input
$user_input = sanitize_text_field($_POST['user_input']);
$email = sanitize_email($_POST['email']);
$url = esc_url_raw($_POST['url']);
```

#### Output Escaping

```php
// Escape output
echo esc_html($user_content);
echo esc_attr($attribute_value);
echo esc_url($link_url);

// In templates
<h1><?php echo esc_html(get_the_title()); ?></h1>
<a href="<?php echo esc_url(get_permalink()); ?>">
    <?php echo esc_html(get_the_title()); ?>
</a>
```

#### Nonce Verification

```php
// Create nonce
wp_nonce_field('your_theme_action', 'your_theme_nonce');

// Verify nonce
if (!wp_verify_nonce($_POST['your_theme_nonce'], 'your_theme_action')) {
    wp_die('Security check failed');
}
```

### Database Queries

#### Use WordPress Functions

```php
// Good: Use WordPress functions
$posts = get_posts([
    'post_type' => 'product',
    'posts_per_page' => 10,
    'meta_query' => [
        [
            'key' => 'featured',
            'value' => 'yes',
            'compare' => '='
        ]
    ]
]);

// Avoid: Direct database queries
// $posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts}...");
```

#### Optimize Queries

```php
// Cache expensive queries
$cache_key = 'your_theme_featured_posts';
$featured_posts = wp_cache_get($cache_key);

if (false === $featured_posts) {
    $featured_posts = get_posts([
        'post_type' => 'product',
        'meta_key' => 'featured',
        'meta_value' => 'yes',
        'posts_per_page' => 10
    ]);
    wp_cache_set($cache_key, $featured_posts, '', HOUR_IN_SECONDS);
}
```

## Performance Optimization

### Asset Management

#### Conditional Loading

```php
// Load assets only where needed
function your_theme_enqueue_scripts() {
    if (is_front_page()) {
        wp_enqueue_script('homepage-slider', 
            get_template_directory_uri() . '/dist/homepage.js',
            ['jquery'], 
            YOUR_THEME_VERSION, 
            true
        );
    }
    
    if (is_single() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'your_theme_enqueue_scripts');
```

#### Asset Optimization

```javascript
// vite.config.mjs
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['jquery', 'lodash'],
                    utils: ['./src/utils/helpers.js']
                }
            }
        }
    }
});
```

### Image Optimization

#### Responsive Images

```php
// Use WordPress responsive images
the_post_thumbnail('large', [
    'class' => 'responsive-image',
    'loading' => 'lazy'
]);

// Custom responsive image function
function your_theme_responsive_image($attachment_id, $sizes = 'large') {
    return wp_get_attachment_image($attachment_id, $sizes, false, [
        'class' => 'responsive-image',
        'loading' => 'lazy',
        'decoding' => 'async'
    ]);
}
```

#### Image Formats

```php
// Support modern image formats
function your_theme_add_webp_support($mimes) {
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    return $mimes;
}
add_filter('upload_mimes', 'your_theme_add_webp_support');
```

### Caching Strategies

#### Object Caching

```php
function your_theme_get_cached_data($key, $callback, $expiration = HOUR_IN_SECONDS) {
    $cached_data = wp_cache_get($key, 'your_theme');
    
    if (false === $cached_data) {
        $cached_data = call_user_func($callback);
        wp_cache_set($key, $cached_data, 'your_theme', $expiration);
    }
    
    return $cached_data;
}
```

#### Transient API

```php
function your_theme_get_external_data() {
    $transient_key = 'your_theme_external_data';
    $data = get_transient($transient_key);
    
    if (false === $data) {
        $response = wp_remote_get('https://api.example.com/data');
        $data = wp_remote_retrieve_body($response);
        set_transient($transient_key, $data, DAY_IN_SECONDS);
    }
    
    return $data;
}
```

## Accessibility

### Semantic HTML

```html
<!-- Use proper heading hierarchy -->
<h1>Page Title</h1>
<h2>Section Title</h2>
<h3>Subsection Title</h3>

<!-- Use semantic elements -->
<nav aria-label="Main navigation">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
    </ul>
</nav>

<main>
    <article>
        <header>
            <h1>Article Title</h1>
        </header>
        <section>
            <p>Article content...</p>
        </section>
    </article>
</main>
```

### ARIA Labels

```html
<!-- Descriptive labels -->
<button aria-label="Close dialog">×</button>
<input type="search" aria-label="Search products">

<!-- Live regions -->
<div aria-live="polite" id="status-message"></div>

<!-- Expanded states -->
<button aria-expanded="false" aria-controls="menu">Menu</button>
<ul id="menu" aria-hidden="true">
    <!-- Menu items -->
</ul>
```

### Keyboard Navigation

```javascript
// Ensure keyboard accessibility
function initKeyboardNavigation() {
    // Trap focus in modals
    const modal = document.querySelector('.modal');
    const focusableElements = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    modal.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            // Handle tab navigation
        }
        if (e.key === 'Escape') {
            closeModal();
        }
    });
}
```

## Internationalization

### Text Domains

```php
// Use consistent text domain
__('Hello World', 'your-theme');
_e('Welcome', 'your-theme');
_n('One item', '%s items', $count, 'your-theme');

// Escape translated strings
echo esc_html__('Safe text', 'your-theme');
echo esc_attr__('Safe attribute', 'your-theme');
```

### Translation Functions

```php
// Context for translators
_x('Post', 'noun', 'your-theme');
_x('Post', 'verb', 'your-theme');

// Placeholders
printf(
    __('Welcome %s to our site!', 'your-theme'),
    esc_html($user_name)
);
```

### RTL Support

```css
/* RTL-aware styles */
.content {
    margin-left: 20px;
    margin-right: 0;
}

[dir="rtl"] .content {
    margin-left: 0;
    margin-right: 20px;
}

/* Or use logical properties */
.content {
    margin-inline-start: 20px;
}
```

## Testing

### Unit Testing

```php
// PHPUnit test example
class ThemeTest extends WP_UnitTestCase {
    public function test_theme_setup() {
        $this->assertTrue(current_theme_supports('post-thumbnails'));
        $this->assertTrue(current_theme_supports('title-tag'));
    }
    
    public function test_menu_registration() {
        $menus = get_registered_nav_menus();
        $this->assertArrayHasKey('primary', $menus);
    }
}
```

### JavaScript Testing

```javascript
// Jest test example
import { initializeTheme } from '../src/theme.js';

describe('Theme initialization', () => {
    test('should initialize without errors', () => {
        expect(() => initializeTheme()).not.toThrow();
    });
    
    test('should set up event listeners', () => {
        const mockElement = document.createElement('div');
        document.body.appendChild(mockElement);
        
        initializeTheme();
        
        // Test event listeners are attached
    });
});
```

### Browser Testing

```javascript
// Playwright test example
const { test, expect } = require('@playwright/test');

test('homepage loads correctly', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('h1')).toBeVisible();
    await expect(page.locator('.main-navigation')).toBeVisible();
});

test('mobile navigation works', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/');
    
    await page.click('.mobile-menu-toggle');
    await expect(page.locator('.mobile-menu')).toBeVisible();
});
```

## Documentation

### Code Comments

```php
/**
 * Initialize theme features and configuration.
 *
 * This function sets up theme support for various WordPress features,
 * registers navigation menus, and configures the theme for optimal
 * performance and accessibility.
 *
 * @since 1.0.0
 * @return void
 */
function your_theme_setup() {
    // Implementation
}
```

### README Documentation

Include comprehensive README files:

```markdown
# Theme Name

Brief description of your theme.

## Installation

1. Download the theme
2. Upload to `/wp-content/themes/`
3. Activate in WordPress admin

## Development

```bash
npm install
npm run dev
```

## Customization

### Colors

Edit `theme.json` to modify the color palette.

### Fonts

Add custom fonts in `resources/css/fonts.css`.
```

## Error Handling

### Graceful Degradation

```php
// Check if function exists
if (function_exists('wp_body_open')) {
    wp_body_open();
} else {
    do_action('wp_body_open');
}

// Check if plugin is active
if (class_exists('WooCommerce')) {
    // WooCommerce-specific code
}
```

### Error Logging

```php
// Log errors for debugging
function your_theme_log_error($message, $data = []) {
    if (WP_DEBUG && WP_DEBUG_LOG) {
        error_log(sprintf(
            '[%s] %s: %s',
            get_template(),
            $message,
            print_r($data, true)
        ));
    }
}
```

## Maintenance

### Version Control

- Use semantic versioning
- Write descriptive commit messages
- Tag releases properly
- Maintain changelog

### Code Reviews

- Review all code changes
- Check for security issues
- Verify performance impact
- Ensure accessibility compliance

### Regular Updates

- Keep dependencies updated
- Monitor for security vulnerabilities
- Test with latest WordPress versions
- Update documentation as needed

These best practices ensure your TailPress themes are maintainable, secure, performant, and accessible.
