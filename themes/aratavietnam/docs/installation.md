# Installation Guide

## Prerequisites

Before installing the Arata Vietnam theme, ensure you have:

- **Docker** and **Docker Compose** installed
- **Git** for version control
- **Node.js** (v16 or higher) for asset building
- **npm** or **yarn** package manager

## Quick Installation

### 1. Clone the Repository

```bash
git clone https://github.com/aratavietnam/aratavietnam.com
cd aratavietnam.com
```

### 2. Start Docker Environment

```bash
# Start all services (WordPress, MySQL, WP-CLI)
docker-compose up -d
```

### 3. Wait for Setup

The automated setup script will:
- Install WordPress
- Configure database
- Install and activate the theme
- Set up development plugins
- Create sample content

```bash
# Monitor setup progress
docker-compose logs -f wp-cli
```

### 4. Access Your Site

- **Website**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/wp-admin
- **Username**: `admin`
- **Password**: `admin123`

## Detailed Installation

### Manual Theme Installation

If you need to install the theme manually:

1. **Upload Theme Files**
   ```bash
   # Copy theme to WordPress themes directory
   cp -r themes/aratavietnam /path/to/wordpress/wp-content/themes/
   ```

2. **Install PHP Dependencies**
   ```bash
   cd themes/aratavietnam
   composer install
   ```

3. **Install Node Dependencies**
   ```bash
   npm install
   ```

4. **Build Assets**
   ```bash
   # Development build
   npm run dev

   # Production build
   npm run build
   ```

5. **Activate Theme**
   - Go to WordPress Admin → Appearance → Themes
   - Activate "Arata Vietnam" theme

### Required Plugins

The theme works best with these plugins (auto-installed in Docker setup):

#### Essential Plugins
- **Advanced Custom Fields** - Custom field management
- **Classic Editor** - WordPress classic editor
- **Query Monitor** - Development debugging (dev only)
- **Debug Bar** - Development toolbar (dev only)

#### Performance Plugins
- **LiteSpeed Cache** - Caching and optimization
- **EWWW Image Optimizer** - Image compression

#### SEO and Content
- **Rank Math SEO** - Search engine optimization
- **TinyMCE Advanced** - Enhanced text editor

#### E-commerce (Optional)
- **WooCommerce** - E-commerce functionality

## Configuration

### 1. Basic WordPress Configuration

```php
// wp-config.php settings (auto-configured in Docker)
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
define('FS_METHOD', 'direct');
```

### 2. Theme Configuration

The theme automatically configures:
- Site timezone (Asia/Ho_Chi_Minh)
- Date and time formats
- Vietnamese language support
- Custom post types
- Navigation menus

### 3. Asset Building Configuration

**Development Mode**
```bash
npm run dev
```
- Enables hot reload
- Source maps for debugging
- Unminified assets

**Production Mode**
```bash
npm run build
```
- Minified and optimized assets
- Cache busting
- Compressed files

## Environment Variables

### Docker Environment

Customize in `docker-compose.yml`:

```yaml
environment:
  WORDPRESS_DB_HOST: db:3306
  WORDPRESS_DB_USER: wordpress
  WORDPRESS_DB_PASSWORD: wordpress_password
  WORDPRESS_DB_NAME: wordpress
  WORDPRESS_DEBUG: 1
```

### Port Configuration

Default port is 8000. To change:

```yaml
ports:
  - "8001:80"  # Use port 8001 instead
```

### Database Configuration

```yaml
# MySQL service configuration
environment:
  MYSQL_ROOT_PASSWORD: rootpassword
  MYSQL_DATABASE: wordpress
  MYSQL_USER: wordpress
  MYSQL_PASSWORD: wordpress_password
```

## Verification

### 1. Check Theme Installation

- Go to **Appearance → Themes**
- Verify "Arata Vietnam" is active
- Check theme version and details

### 2. Verify Assets

- Check if CSS/JS files are loading correctly
- Verify Tailwind CSS classes are working
- Test responsive design

### 3. Test Custom Post Types

- Go to WordPress Admin
- Check for "Khuyến mãi" (Promotions) menu
- Check for "Tuyển dụng" (Job Postings) menu
- Verify custom fields are available

### 4. Test Forms

- Visit contact page
- Test contact form submission
- Check form validation

## Troubleshooting

### Common Issues

#### Port Already in Use
```bash
# Check what's using port 8000
lsof -i :8000

# Use different port in docker-compose.yml
ports:
  - "8001:80"
```

#### Permission Issues
```bash
# Fix file permissions
docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content
docker-compose exec wordpress chmod -R 755 /var/www/html/wp-content
```

#### Database Connection Issues
```bash
# Restart database service
docker-compose restart db

# Check database logs
docker-compose logs db
```

#### Theme Not Loading
```bash
# Re-run setup script
docker-compose exec wp-cli /wp-cli-setup.sh

# Check theme files exist
docker-compose exec wordpress ls -la /var/www/html/wp-content/themes/aratavietnam
```

#### Assets Not Building
```bash
# Clear node modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Check Node.js version
node --version  # Should be v16+
```

### WP-CLI Commands

Useful commands for troubleshooting:

```bash
# List themes
docker-compose exec wp-cli wp theme list --allow-root

# Activate theme
docker-compose exec wp-cli wp theme activate aratavietnam --allow-root

# List plugins
docker-compose exec wp-cli wp plugin list --allow-root

# Check database
docker-compose exec wp-cli wp db check --allow-root

# Update WordPress
docker-compose exec wp-cli wp core update --allow-root
```

### Getting Help

If you encounter issues:

1. **Check Logs**
   ```bash
   # WordPress logs
   docker-compose logs wordpress

   # WP-CLI logs
   docker-compose logs wp-cli

   # All services
   docker-compose logs
   ```

2. **Debug Mode**
   - Enable WordPress debug mode
   - Check browser console for JavaScript errors
   - Use Query Monitor plugin for detailed debugging

3. **Documentation**
   - Check theme documentation in `/docs/`
   - Review WordPress Codex
   - Check plugin documentation

4. **Support**
   - Create issue in repository
   - Contact development team
   - Check community forums

## Next Steps

After successful installation:

1. **[Configuration Guide](configuration.md)** - Configure theme settings
2. **[Development Setup](development.md)** - Set up development environment
3. **[Customization Guide](customization.md)** - Customize the theme
4. **[Content Management](content-management.md)** - Manage content and posts
