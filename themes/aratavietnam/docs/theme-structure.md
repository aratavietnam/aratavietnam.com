# Theme Structure Documentation

## Overview

The Arata Vietnam theme follows a modular architecture built on the TailPress framework with modern development practices.

## Directory Structure

```
aratavietnam/
├── style.css                 # Theme metadata and registration
├── functions.php             # Main theme functions and initialization
├── index.php                 # Fallback template
├── front-page.php           # Homepage template
├── page.php                 # Default page template
├── single.php               # Single post template
├── archive.php              # Archive template
├── 404.php                  # Error page template
├── header.php               # Site header
├── footer.php               # Site footer
├── comments.php             # Comments template
├── searchform.php           # Search form template
│
├── inc/                     # Modular functionality
│   ├── woocommerce.php      # WooCommerce integration
│   ├── fonts-vietnamese.php # Vietnamese font support
│   ├── news-post-types.php  # Custom post types
│   ├── contact-form.php     # Contact form handlers
│   ├── customizer-footer.php # Footer customizer
│   ├── services-post-types.php # Service catalog
│   ├── auth-handler.php     # Authentication
│   └── ...                  # Other modules
│
├── page-templates/          # Custom page templates
│   ├── about.php            # About page template
│   ├── contact.php          # Contact page template
│   ├── news.php             # News listing template
│   ├── services.php         # Services template
│   ├── careers.php          # Careers template
│   ├── promotions.php       # Promotions template
│   └── blog.php             # Blog template
│
├── template-parts/          # Reusable template components
│   ├── content-excerpt.php  # Post excerpt
│   ├── content-single.php   # Single post content
│   ├── navigation.php       # Navigation component
│   └── ...                  # Other components
│
├── resources/               # Source assets
│   ├── css/
│   │   ├── app.css          # Main stylesheet
│   │   └── editor-style.css # Block editor styles
│   ├── js/
│   │   └── app.js           # Main JavaScript
│   └── images/              # Image assets
│
├── dist/                    # Compiled assets (auto-generated)
│   ├── app.css              # Compiled CSS
│   ├── app.js               # Compiled JavaScript
│   └── manifest.json        # Asset manifest
│
├── woocommerce/             # WooCommerce template overrides
│   ├── archive-product.php  # Product archive
│   └── single-product/      # Single product templates
│
├── docs/                    # Documentation
├── vendor/                  # PHP dependencies
├── node_modules/            # Node.js dependencies
├── package.json             # Node.js package configuration
├── vite.config.mjs          # Vite build configuration
├── composer.json            # PHP package configuration
└── theme.json               # WordPress theme configuration
```

## Core Files

### style.css
Contains theme metadata required by WordPress:
- Theme Name, Description, Author
- Version and License information
- Text Domain for translations

### functions.php
Main theme initialization file that:
- Loads all modular functionality from `/inc/`
- Initializes TailPress framework
- Registers theme supports and features
- Sets up navigation menus
- Configures asset compilation

### theme.json
WordPress theme configuration file that defines:
- Color palette and typography
- Spacing and layout settings
- Block editor configurations
- Global styles and presets

## Modular Architecture (/inc/)

The theme uses a modular approach where each feature is separated into its own file:

### Core Modules
- **woocommerce.php**: E-commerce functionality
- **fonts-vietnamese.php**: Vietnamese typography support
- **favicon-pwa.php**: Favicon and PWA settings
- **logo-branding.php**: Site branding customization

### Content Management
- **news-post-types.php**: Custom post types (Promotions, Jobs)
- **news-meta-fields.php**: Meta fields for news content
- **services-post-types.php**: Service catalog functionality
- **about-meta.php**: About page meta fields

### Forms and Interaction
- **contact-form.php**: Contact form processing
- **contact-meta.php**: Contact page meta fields
- **news-forms.php**: Newsletter and subscription forms
- **auth-handler.php**: User authentication
- **job-application-handler.php**: Job application processing

### Customization
- **customizer-footer.php**: WordPress Customizer for footer
- **admin-columns.php**: Admin interface customizations
- **template-filters.php**: Template modification hooks
- **upload-mimes.php**: File upload security

### Utilities
- **class-dropdown-walker.php**: Custom navigation walker
- **contact-config.php**: Contact configuration

## Template Hierarchy

### Page Templates
The theme provides specialized templates for different content types:

1. **front-page.php**: Homepage (currently development placeholder)
2. **page-templates/**: Custom page templates for specific pages
3. **archive-*.php**: Archive pages for custom post types
4. **single-*.php**: Single post templates for custom post types

### Template Selection
WordPress follows this hierarchy:
1. Custom page template (if selected)
2. Specific template (e.g., `single-promotion.php`)
3. General template (e.g., `single.php`)
4. Fallback template (`index.php`)

## Asset Management

### Source Files (/resources/)
- **CSS**: Tailwind CSS source files
- **JavaScript**: ES6+ source files
- **Images**: Optimized image assets

### Build Process
- **Vite**: Modern build tool for asset compilation
- **Tailwind CSS**: Utility-first CSS framework
- **PostCSS**: CSS processing and optimization

### Compiled Assets (/dist/)
- Auto-generated during build process
- Includes versioned filenames for cache busting
- Manifest file for asset tracking

## Custom Post Types

The theme registers several custom post types:

1. **Promotions** (`promotion`): Marketing campaigns
2. **Job Postings** (`job_posting`): Career opportunities
3. **Services** (`service`): Service catalog
4. **Newsletter Subscriptions** (`newsletter_sub`): Email subscriptions
5. **Job Applications** (`job_application`): Resume submissions

## Integration Points

### WordPress Integration
- Custom post types and meta fields
- WordPress Customizer integration
- Block editor support
- REST API endpoints

### WooCommerce Integration
- Product catalog functionality
- Custom product templates
- Shopping cart integration
- Payment processing support

### Third-party Plugins
- Advanced Custom Fields
- SEO optimization plugins
- Caching plugins
- Image optimization plugins

## Development Workflow

1. **Asset Development**: Edit files in `/resources/`
2. **PHP Development**: Modify templates and `/inc/` modules
3. **Build Process**: Run `npm run dev` for development or `npm run build` for production
4. **Testing**: Use development tools and WordPress debugging

## Performance Considerations

- **Modular Loading**: Only necessary code is loaded
- **Asset Optimization**: Vite handles minification and optimization
- **Image Optimization**: Integrated with EWWW Image Optimizer
- **Caching**: Compatible with LiteSpeed Cache
- **Code Splitting**: JavaScript is split for optimal loading

## Security Features

- **File Upload Restrictions**: Custom MIME type filtering
- **Directory Protection**: Index files prevent direct access
- **Input Sanitization**: All user inputs are sanitized
- **Nonce Verification**: Forms use WordPress nonces
- **Capability Checks**: Proper permission checking

This modular structure makes the theme maintainable, extensible, and easy to understand for developers.
