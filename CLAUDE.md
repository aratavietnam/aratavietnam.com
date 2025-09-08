# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Architecture

Containerized WordPress e-commerce site for Arata Vietnam (Japanese cosmetics distributor) using TailPress framework with modern build tools and comprehensive Vietnamese localization.

### Core Stack
- **WordPress**: Latest with WooCommerce + comprehensive Vietnamese translations
- **TailPress Framework v5.0.4**: WordPress theme framework with Tailwind CSS v4
- **Vite 6.3+**: Module bundler with HMR, ES6 modules, hashed asset names
- **Docker**: MySQL 8.0, WordPress, WP CLI with automated setup
- **PHP 8.0.2+**: Modern PHP with PSR-4 autoloading

## Development Commands

```bash
# Environment (from project root)
docker-compose up -d                    # Start all services
docker-compose logs -f wp-cli          # Monitor WordPress setup
docker-compose down                    # Stop services
docker-compose down -v && docker-compose up -d  # Full reset with data cleanup

# Theme development (from themes/aratavietnam/)
npm run dev                           # Vite dev server (port 3000) with HMR
npm run build                         # Production build with versioning & hashed filenames
composer install                     # PHP dependencies (TailPress framework)

# WordPress CLI operations
docker-compose exec wp-cli wp --allow-root [command]
docker-compose exec wp-cli wp post list --allow-root
docker-compose exec wp-cli wp db export backup.sql --allow-root

# Content management scripts (from project root)
./scripts/create-website-structure.sh    # Create basic pages
./scripts/create-news-content.sh         # Generate sample news content
./scripts/fix-docker-permissions.sh      # Fix file permissions

# Development utility scripts (55+ total - explore with ls scripts/)
./scripts/setup-woocommerce.sh          # WooCommerce configuration
./scripts/create-demo-products.sh       # Sample product data
./scripts/update-product-images.sh      # Batch product image updates
./scripts/update-all-pages-images.sh    # Update featured images for all pages
./scripts/update-homepage-images.sh     # Update homepage section images
./scripts/update-promotions-services-images.sh  # Update promotions and services images

# SEO and content optimization scripts
./scripts/bulk-update-*.php            # Bulk update focus keywords for SEO
./scripts/fix-product-images.sh        # Fix product image URLs and attributes
./scripts/check_missing_thumbnails.sh  # Check for missing featured images

# Site structure and menu scripts
./scripts/create-*.sh                  # Create various page types and content
./scripts/fix-menu-*.sh                # Fix navigation menu structure
./scripts/setup-*.sh                   # Setup various site components

# Build verification and asset management
./scripts/verify-build.sh              # Verify all built assets and functions

# Docker-specific scripts
./scripts/update-page-featured-images-docker.sh     # Update images using Docker
./scripts/update-page-images-docker-improved.sh     # Improved Docker image updates
```

### Access Points
- **Frontend**: http://localhost:8080
- **Admin**: http://localhost:8080/wp-admin (admin/admin123)
- **Vite Dev Server**: http://localhost:3000 (HMR for development)
- **Database**: MySQL on port 3306 (wordpress/wordpress_password)

**Note**: The README.md incorrectly shows port 8000, but docker-compose.yml actually uses port 8080. All documentation should reference port 8080.

## Theme Architecture

### TailPress Framework Integration
The theme follows TailPress conventions with modular architecture:

- **Entry Point**: `functions.php` → `aratavietnam()` function initializes framework
- **Asset Pipeline**: `resources/` → Vite compilation → `dist/` output
- **Modular System**: All functionality organized in `inc/` directory modules
- **Template System**: Component-based with `template-parts/` organization

### Core Modules (inc/ directory)

**Core Framework:**
- `woocommerce.php` - E-commerce functionality + Vietnamese translations
- `fonts-vietnamese.php` - Vietnamese typography optimization
- `favicon-pwa.php` - Site identity and PWA configuration
- `logo-branding.php` - Site branding and identity
- `customizer-colors.php` + `customizer-footer.php` - WordPress Customizer extensions

**Content Management:**
- `news-post-types.php` + `news-meta-fields.php` + `news-forms.php` - News/blog system
- `services-post-types.php` + `services-meta.php` - Services custom post type with meta
- `partner-post-type.php` - Partners management
- `contact-form.php` + `contact-meta.php` + `contact-config.php` - Contact system

**E-commerce:**
- `product-brand-taxonomy.php` - Product brand taxonomy
- `product-filters.php` - Advanced product filtering
- `product-assets.php` - Product-specific asset loading
- `product-policies-meta.php` - Product policy management

**Page Templates & Meta:**
- `*-meta.php` files - Admin meta boxes for different page types
- `shop-meta.php`, `blog-meta.php`, `careers-meta.php`, `promotions-meta.php`, `homepage-meta.php`, `services-meta.php`

**Authentication & Applications:**
- `auth-handler.php` - User authentication system
- `job-application-handler.php` - Career applications processing

**Admin & Development:**
- `admin-columns.php` - Custom admin column configurations
- `upload-mimes.php` - File upload type restrictions (includes SVG support with security)
- `template-filters.php` - Template modification hooks
- `class-dropdown-walker.php` - Custom navigation walker
- `asset-management.php` - Automated asset hash detection utilities

### Custom Post Types & Features
- **Post Types**: News, Services, Job Postings, Partners (with rich meta fields)
- **WooCommerce Integration**: Full Vietnamese localization, custom checkout flow
- **Page Templates**: Specialized templates for News, Promotions, Careers, Contact, Services, About
- **REST API**: Custom search endpoint `/wp-json/aratavietnam/v1/search` with featured images
- **JavaScript Modules**: Modern ES6 modules with dynamic imports

### Vite Build System
**Configuration** (`vite.config.mjs`):
- **Entry Points**: Multiple JS modules + CSS files
  - `app.js` (main application)
  - `notifications.js` (notification system)
  - `add-to-cart.js` (WooCommerce integration)
  - `product-single.js` (product page features)
  - `app.css` (main stylesheet)
  - `editor-style.css` (WordPress editor styles)
- **Development**: Port 3000, CORS enabled, `aratavietnam.test` origin
- **Production**: Manifest generation, hashed filenames, module script tags
- **Tailwind CSS v4**: Integrated via `@tailwindcss/vite` plugin

### JavaScript Architecture
**Modern ES6 Module System:**
- **Main App (`app.js`)**: Entry point importing icons, popups, fonts; Vietnamese font loading detection
- **Product Features**: Gallery (PhotoSwipe + Swiper), variants, add-to-cart with conditional loading
- **Contact System (`contact-popup.js`)**: Modal popups with form validation
- **Auth System (`auth-popup.js`)**: Authentication popups and handlers
- **Notification System (`notifications.js`)**: Toast notifications for user feedback
- **Icon System (`icons.js`)**: Lucide icons with dynamic imports and caching

**Dependencies (package.json):**
- **UI Components**: Lucide icons (0.540.0), Swiper gallery (11.0.5), PhotoSwipe lightbox (5.4.3)
- **Build System**: Vite (6.3.2), Tailwind CSS (4.0.0) with @tailwindcss/vite plugin
- **Browser Automation**: Puppeteer (24.19.0) for testing and web scraping

## Asset Management & Build System

### TailPress Integration Pattern
- **Framework Entry**: `functions.php:84` → `aratavietnam()` function initializes TailPress
- **Vite Compiler**: Custom `ViteCompiler` with `aratavietnam` handle for cache management
- **Conditional Assets**: Product-specific JS only loads on `is_product()` pages
- **Module Script Tags**: `type="module"` automatically applied to theme scripts

### Hashed Asset Management
**⚠️ CRITICAL BUILD STEP**: The build system generates hashed filenames that must be manually updated in `functions.php:189-203` after every `npm run build`. The build will work but assets won't load without this manual update.

**Automated Asset Management**
The `asset-management.php` module provides helper functions to eliminate manual hash updates:

```php
// Automatically detect and enqueue assets
aratavietnam_enqueue_asset('aratavietnam-app', 'app', ['jquery'], null, true);
aratavietnam_enqueue_asset('aratavietnam-notifications', 'notifications');
aratavietnam_enqueue_style_asset('aratavietnam-app-css', 'app');

// Debug all available assets
$assets = aratavietnam_get_all_assets();
error_log(print_r($assets, true));
```

```php
// REQUIRED: After npm run build, update these hashed filenames in functions.php
wp_enqueue_script('aratavietnam-app', get_template_directory_uri() . '/dist/app-CdtiypLP.js',
wp_enqueue_script('aratavietnam-notifications', get_template_directory_uri() . '/dist/notifications-DX7Hjlbv.js',
wp_enqueue_script('aratavietnam-add-to-cart', get_template_directory_uri() . '/dist/add-to-cart-DOaesbe3.js',
wp_enqueue_script('aratavietnam-product-single', get_template_directory_uri() . '/dist/product-single-DWIbL6ns.js',
```

**Build Workflow**: 
1. `npm run build` → Generate hashed assets
2. `./scripts/verify-build.sh` → Verify all assets built correctly
3. Either update hashes manually in functions.php:189-203 OR use automated functions
4. Test asset loading in browser

### Brand & Localization
- **Colors**: Primary #F55E25, Secondary #0066A6, Tertiary #FFAB14
- **Typography**: Inter font with Vietnamese fallbacks and loading detection
- **Timezone**: Asia/Ho_Chi_Minh
- **Language**: Comprehensive Vietnamese translations for WooCommerce checkout flow

## Key Architectural Patterns

### Modular PHP Architecture
All functionality is organized in `/inc/` modules with specific naming patterns:
- `*-post-types.php`: Custom post type registration
- `*-meta-fields.php` + `*-meta.php`: Admin meta box systems
- `*-forms.php`: Frontend form handlers
- `contact-*`: Three-file contact system (form, meta, config)

### Template System Integration
- **Page Templates**: `page-templates/*.php` registered via `functions.php:52-62`
- **Template Parts**: Component-based in `template-parts/` directory
- **Force Recognition**: Custom template loader at `functions.php:65-82`
- **Recent Refactoring**: Template parts for single post types (job_posting, promotion) have been consolidated into their respective single template files for simplified maintenance

### Vietnamese E-commerce Localization
Comprehensive Vietnamese translations implemented via WordPress filters in `functions.php:267-416`, covering:
- Checkout field labels and placeholders
- WooCommerce UI text and messages
- Order review sections and button text
- Privacy policy and legal text

### REST API Extensions
Custom search endpoint `/wp-json/aratavietnam/v1/search` with featured image support implemented at `functions.php:438-530`.

## Development Workflow

### Starting Development
1. **Environment**: `docker-compose up -d` → Wait for wp-cli logs to complete
2. **Theme Dev**: `cd themes/aratavietnam && npm run dev` (HMR on port 3000)
3. **Asset Building**: `npm run build` → Update hashed filenames in functions.php:189-202
4. **Database**: Use WP CLI via docker-compose exec wp-cli wp [command] --allow-root

### Common Development Tasks
- **Add New Module**: Create in `/inc/`, add to functions.php includes (lines 8-42)
- **New Page Template**: Create in `page-templates/`, register in functions.php:52-62
- **Custom Post Type**: Follow pattern: `*-post-types.php` + `*-meta-fields.php` + `*-meta.php`
- **Frontend JavaScript**: Add to vite.config.mjs input array, use ES6 modules with dynamic imports
- **Vietnamese Content**: Use existing translation filters in functions.php:267-416

### Recent Codebase Improvements
- **Security Enhancement**: SVG upload support with security validation in `upload-mimes.php`
- **Code Cleanup**: Vietnamese comments removed, console.log statements cleaned up
- **Asset Optimization**: Versioned script enqueuing for better cache management
- **Template Consolidation**: Single post type templates (job_posting, promotion) consolidated into their respective single template files for simplified maintenance
- **Navigation Structure**: Menu scripts organized for better site structure management
- **Hero Section Settings**: Added hero section customization for About page matching Blog page structure
- **Asset Management**: Added `asset-management.php` module with utilities for automatic hash detection to eliminate manual updates after builds

### Testing & Debugging
- **Query Monitor**: Available in admin bar for database queries and performance
- **Debug Bar**: Development debugging toolbar (installed by wp-cli-setup.sh)
- **WP CLI**: Use for content management, database operations, and testing
- **Vite HMR**: Instant CSS/JS updates during development via localhost:3000
- **Asset Issues**: Check Vite manifest.json and functions.php hashed filename alignment
- **Error Logs**: Check `/uploads/wc-logs/` for WooCommerce errors and fatal errors

### Project Management
- **Scripts Directory**: 55+ utility scripts for content management, image updates, database operations, and SEO updates
- **Content Management**: Automated scripts for creating demo products, news content, and page structure
- **Image Processing**: Bulk image update scripts for products, posts, promotions, and homepage sections
- **Database Tools**: Scripts for SEO updates, permission fixes, and WordPress configuration
- **Docker-specific Tools**: Specialized scripts for managing image updates and featured images in Docker environment

### PHP Autoloading
- **PSR-4**: Namespace `AraVietnam\\` maps to `src/` directory (composer.json)
- **TailPress Framework**: v5.0.4 loaded via Composer with Jetpack autoloader
- **Manual Includes**: All functionality explicitly required in functions.php:8-42

## Important Development Notes

### Theme Location Correction
The actual theme is located at `themes/aratavietnam/` (not `themes/tailpress/` as mentioned in README.md). The README contains outdated path references.

### Port Configuration
- **Actual Frontend Port**: 8080 (docker-compose.yml)
- **README Port**: 8000 (incorrect)
- **Vite Dev Server**: 3000
- **Database**: 3306

### Asset Build Process
After running `npm run build`, you MUST update the hashed filenames in `functions.php:189-203`. The build generates new hashes each time, and assets will not load without this manual update step.

### Docker Development
For detailed Docker setup instructions, troubleshooting, and advanced configuration, see `docs/DOCKER-DEVELOPMENT.md`.

# important-instruction-reminders
Do what has been asked; nothing more, nothing less.
NEVER create files unless they're absolutely necessary for achieving your goal.
ALWAYS prefer editing an existing file to creating a new one.
NEVER proactively create documentation files (*.md) or README files. Only create documentation files if explicitly requested by the User.