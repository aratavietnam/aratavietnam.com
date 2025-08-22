# Development Setup Guide

## Prerequisites

Ensure you have the following installed on your development machine:

- **Docker** (v20.10+) and **Docker Compose** (v2.0+)
- **Node.js** (v16+ recommended)
- **npm** or **yarn** package manager
- **Git** for version control
- **Code Editor** (VS Code recommended with PHP and WordPress extensions)

## Development Environment Setup

### 1. Clone and Initialize Project

```bash
# Clone the repository
git clone https://github.com/aratavietnam/aratavietnam.com
cd aratavietnam.com

# Start Docker containers
docker-compose up -d

# Monitor setup completion
docker-compose logs -f wp-cli
```

### 2. Theme Development Setup

```bash
# Navigate to theme directory
cd themes/aratavietnam

# Install Node.js dependencies
npm install

# Install PHP dependencies (if needed)
composer install

# Start development mode with hot reload
npm run dev
```

### 3. Development URLs

- **Website**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/wp-admin
- **Vite Dev Server**: http://localhost:3000 (assets)
- **WordPress Credentials**: admin / admin123

## Development Workflow

### Asset Development

The theme uses **Vite** for modern asset building with **Tailwind CSS**.

#### Development Mode
```bash
npm run dev
```

This provides:
- Hot Module Replacement (HMR)
- Live CSS updates
- Source maps for debugging
- Fast rebuilds

#### Production Build
```bash
npm run build
```

This generates:
- Minified CSS and JavaScript
- Optimized assets with versioning
- Production-ready files in `/dist/`

### File Structure for Development

```
aratavietnam/
├── resources/              # Source files (edit these)
│   ├── css/
│   │   ├── app.css         # Main stylesheet (Tailwind CSS)
│   │   └── editor-style.css # Block editor styles
│   ├── js/
│   │   └── app.js          # Main JavaScript file
│   └── images/             # Image assets
│
├── dist/                   # Compiled files (auto-generated)
│   ├── app.css             # Compiled CSS
│   ├── app.js              # Compiled JavaScript
│   └── manifest.json       # Asset manifest
│
├── inc/                    # PHP modules (edit for functionality)
│   ├── *.php               # Modular functionality files
│
├── page-templates/         # Custom page templates
├── template-parts/         # Reusable components
└── *.php                   # WordPress template files
```

## Development Tools

### Code Editor Setup (VS Code)

Recommended extensions:

```json
{
  "recommendations": [
    "bradlc.vscode-tailwindcss",
    "phptools.phptools",
    "wordpresstoolbox.wordpress-toolbox",
    "ms-vscode.vscode-typescript-next",
    "esbenp.prettier-vscode",
    "bmewburn.vscode-intelephense-client"
  ]
}
```

VS Code settings for the project:

```json
{
  "emmet.includeLanguages": {
    "php": "html"
  },
  "tailwindCSS.includeLanguages": {
    "php": "html"
  },
  "css.validate": false,
  "tailwindCSS.experimental.classRegex": [
    "class[:]\\s*['\"]([^'\"]*)['\"]"
  ]
}
```

### WordPress Development Plugins

The development environment includes these debugging plugins:

- **Query Monitor**: Performance and debugging information
- **Debug Bar**: Development debugging toolbar

Access these via the admin bar when logged in.

## WP-CLI Development Commands

Common WP-CLI commands for development:

### Theme Management
```bash
# List all themes
docker-compose exec wp-cli wp theme list --allow-root

# Activate theme
docker-compose exec wp-cli wp theme activate aratavietnam --allow-root

# Get theme info
docker-compose exec wp-cli wp theme get aratavietnam --allow-root
```

### Content Management
```bash
# Create a test post
docker-compose exec wp-cli wp post create \
  --post_title="Test Post" \
  --post_content="Test content" \
  --post_status=publish \
  --allow-root

# Create test pages
docker-compose exec wp-cli wp post create \
  --post_type=page \
  --post_title="Test Page" \
  --post_status=publish \
  --allow-root

# Import test content
docker-compose exec wp-cli wp import /path/to/test-content.xml --allow-root
```

### Database Operations
```bash
# Export database
docker-compose exec wp-cli wp db export backup.sql --allow-root

# Import database
docker-compose exec wp-cli wp db import backup.sql --allow-root

# Search and replace URLs
docker-compose exec wp-cli wp search-replace \
  'oldsite.com' 'localhost:8000' \
  --allow-root
```

### Plugin Management
```bash
# List plugins
docker-compose exec wp-cli wp plugin list --allow-root

# Install and activate plugin
docker-compose exec wp-cli wp plugin install plugin-name --activate --allow-root

# Deactivate plugin
docker-compose exec wp-cli wp plugin deactivate plugin-name --allow-root
```

## Custom Scripts

The project includes helpful scripts in the `/scripts/` directory:

### Content Generation
```bash
# Run from project root
./scripts/create-website-structure.sh     # Create basic pages
./scripts/create-news-content.sh          # Generate sample news
./scripts/create-sample-services.sh       # Create service content
```

### Maintenance Scripts
```bash
./scripts/fix-docker-permissions.sh       # Fix file permissions
./scripts/update-featured-images.sh       # Update post images
./scripts/check_missing_thumbnails.sh     # Check for missing images
```

## Debugging

### PHP Debugging

WordPress debug mode is enabled by default in development:

```php
// Already configured in docker-compose.yml
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
```

Debug logs are available:
```bash
# View WordPress debug log
docker-compose exec wordpress tail -f /var/www/html/wp-content/debug.log

# View PHP error log
docker-compose exec wordpress tail -f /var/log/apache2/error.log
```

### JavaScript Debugging

With Vite development mode:
- Source maps are available
- Console.log statements work normally
- Browser dev tools show original source files

### CSS Debugging

Tailwind CSS development features:
- Full utility classes available
- Source maps for debugging
- Hot reload for instant feedback

## Testing

### Manual Testing Checklist

1. **Theme Functionality**
   - [ ] All templates load correctly
   - [ ] Custom post types work
   - [ ] Contact forms submit properly
   - [ ] Navigation menus function
   - [ ] Footer customizer works

2. **Responsive Design**
   - [ ] Mobile layout (< 768px)
   - [ ] Tablet layout (768px - 1024px)
   - [ ] Desktop layout (> 1024px)

3. **Performance**
   - [ ] Page load times < 3 seconds
   - [ ] Images are optimized
   - [ ] CSS/JS are minified in production

4. **Browser Compatibility**
   - [ ] Chrome (latest)
   - [ ] Firefox (latest)
   - [ ] Safari (latest)
   - [ ] Edge (latest)

### Automated Testing

Currently, the project doesn't include automated tests, but you can add:

#### PHP Testing with PHPUnit
```bash
# Install PHPUnit
composer require --dev phpunit/phpunit

# Create test structure
mkdir tests
```

#### JavaScript Testing with Jest
```bash
# Install Jest
npm install --save-dev jest

# Add test script to package.json
"scripts": {
  "test": "jest"
}
```

## Performance Optimization

### Development Performance

- **Vite HMR**: Fast hot module replacement
- **Tailwind JIT**: Just-in-time CSS compilation
- **Docker Volumes**: Bind mounts for live file editing

### Production Preparation

```bash
# Build optimized assets
npm run build

# Check asset sizes
ls -la dist/

# Test production build locally
docker-compose -f docker-compose.prod.yml up
```

## Common Development Tasks

### Adding New Custom Post Type

1. Create new file in `/inc/` (e.g., `products-post-types.php`)
2. Register the post type
3. Add to `functions.php` require statements
4. Create archive and single templates
5. Add custom fields if needed

### Adding New Page Template

1. Create file in `/page-templates/` (e.g., `custom-page.php`)
2. Add template header comment
3. Register in `functions.php`
4. Style with Tailwind CSS classes

### Modifying Styles

1. Edit `resources/css/app.css`
2. Use Tailwind utility classes
3. Add custom CSS if needed
4. Vite will auto-reload changes

### Adding JavaScript Functionality

1. Edit `resources/js/app.js`
2. Use modern ES6+ syntax
3. Vite handles compilation
4. Add vendor libraries via npm

## Troubleshooting

### Common Issues

#### Assets Not Loading
```bash
# Rebuild assets
npm run build

# Check Vite process
npm run dev

# Verify file permissions
ls -la dist/
```

#### Docker Issues
```bash
# Restart containers
docker-compose restart

# Rebuild containers
docker-compose up --build

# Check container logs
docker-compose logs [service-name]
```

#### WordPress Issues
```bash
# Clear cache
docker-compose exec wp-cli wp cache flush --allow-root

# Reactivate theme
docker-compose exec wp-cli wp theme activate aratavietnam --allow-root

# Check database connection
docker-compose exec wp-cli wp db check --allow-root
```

#### Permission Problems
```bash
# Fix WordPress permissions
docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content
docker-compose exec wordpress chmod -R 755 /var/www/html/wp-content
```

### Getting Help

1. **Check Documentation**: Review theme documentation in `/docs/`
2. **Debug Logs**: Check WordPress and server error logs
3. **WordPress Codex**: Reference official WordPress documentation
4. **Plugin Documentation**: Check individual plugin docs
5. **Create Issues**: Submit issues to the project repository

## Best Practices

### Code Quality
- Follow WordPress coding standards
- Use proper sanitization and escaping
- Comment complex functionality
- Keep functions modular and reusable

### Performance
- Optimize images before uploading
- Minimize HTTP requests
- Use caching appropriately
- Profile code with Query Monitor

### Security
- Sanitize all inputs
- Escape all outputs
- Use nonces for forms
- Keep plugins and WordPress updated

### Version Control
- Commit frequently with descriptive messages
- Use feature branches for new development
- Don't commit sensitive data
- Keep `.gitignore` updated

This development setup provides a modern, efficient workflow for building and maintaining the Arata Vietnam theme.
