# Installation

Complete guide for installing and setting up TailPress for WordPress theme development.

## About TailPress

TailPress is a boilerplate theme for WordPress using Tailwind CSS. In its current iteration, in addition to being a boilerplate, a more robust ecosystem is being built around it.

## System Requirements

To use TailPress effectively, ensure you have:

### Required Software

- **Composer**: PHP dependency manager
- **NPM**: Node.js package manager
- **PHP**: 8.0 or higher
- **WordPress**: 6.2 or higher

### Development Environment

- **Local Server**: XAMPP, MAMP, Laravel Valet, or Docker
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Web Server**: Apache or Nginx

## Installation Methods

### Method 1: Using TailPress Installer (Recommended)

The easiest way to create a theme is by using the TailPress installer.

#### Step 1: Install TailPress CLI

```bash
composer global require tailpress/installer
```

#### Step 2: Verify Installation

```bash
tailpress --version
```

If the command is not found, add Composer's global vendor bin directory to your PATH:

**macOS:**
```bash
export PATH="$HOME/.composer/vendor/bin:$PATH"
```

**Windows:**
```cmd
set PATH=%USERPROFILE%\AppData\Roaming\Composer\vendor\bin;%PATH%
```

**Linux:**
```bash
export PATH="$HOME/.config/composer/vendor/bin:$PATH"
```

You can find the exact path by running:
```bash
composer global about
```

#### Step 3: Create New Theme

```bash
tailpress new your-theme-folder-name
```

The installer will prompt you to select your preferred setup options.

#### Step 4: Navigate to Theme Directory

```bash
cd your-theme-folder-name
```

#### Step 5: WordPress Installation Option

The installer will ask if you want WordPress installed as well. Note that you still need a local development environment for PHP and MySQL.

### Method 2: Manual Installation

If you prefer manual installation or the installer is not available:

#### Step 1: Download TailPress

```bash
git clone https://github.com/tailpress/tailpress.git your-theme-name
cd your-theme-name
```

#### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

#### Step 3: Configure Theme

Edit the theme information in `style.css`:

```css
/*
Theme Name: Your Theme Name
Description: Your theme description
Author: Your Name
Version: 1.0.0
Text Domain: your-textdomain
*/
```

## Post-Installation Setup

### 1. Environment Configuration

Create or update your development environment configuration:

#### For Docker Users

If using Docker, ensure your `docker-compose.yml` includes:

```yaml
services:
  wordpress:
    volumes:
      - ./themes/your-theme:/var/www/html/wp-content/themes/your-theme
```

#### For Local Development

Ensure your theme is in the correct WordPress themes directory:
```
/wp-content/themes/your-theme-name/
```

### 2. WordPress Configuration

#### Activate Theme

1. Log into WordPress admin
2. Navigate to Appearance > Themes
3. Activate your new TailPress theme

#### Set Permalink Structure

For better URL structure, set permalinks to "Post name":
1. Go to Settings > Permalinks
2. Select "Post name"
3. Save changes

### 3. Development Server Setup

#### Start Development Mode

```bash
npm run dev
```

This starts the Vite development server with:
- Hot module replacement
- Automatic browser refresh
- CSS/JS compilation
- Development server on `http://localhost:3000`

#### Build for Production

```bash
npm run build
```

This creates optimized assets in the `dist/` directory.

## Verification

### Check Installation Success

1. **Theme Activation**: Verify theme is active in WordPress admin
2. **Assets Loading**: Check that CSS and JavaScript are loading correctly
3. **Development Server**: Confirm `npm run dev` runs without errors
4. **Hot Reload**: Test that changes to CSS/JS trigger automatic updates

### Common Installation Issues

#### Composer Not Found

```bash
# Install Composer globally
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### NPM Permission Issues

```bash
# Fix NPM permissions (macOS/Linux)
sudo chown -R $(whoami) ~/.npm
```

#### PHP Version Issues

Ensure PHP 8.0+ is installed and active:
```bash
php --version
```

#### WordPress Requirements

Verify WordPress version:
```bash
# Using WP-CLI
wp core version
```

## Directory Structure After Installation

```
your-theme/
├── .github/                  # GitHub workflows
├── .gitignore               # Git ignore rules
├── .distignore              # Distribution ignore rules
├── functions.php            # Theme configuration
├── style.css                # Theme header
├── index.php                # Main template
├── header.php               # Header template
├── footer.php               # Footer template
├── resources/               # Source assets
│   ├── css/
│   │   ├── app.css         # Main CSS
│   │   ├── theme.css       # Theme colors
│   │   └── editor-style.css # Block editor
│   └── js/
│       └── app.js          # Main JavaScript
├── src/                     # PHP classes
├── template-parts/          # Template partials
├── vendor/                  # Composer dependencies
├── node_modules/            # NPM dependencies
├── dist/                    # Compiled assets
├── package.json             # NPM configuration
├── composer.json            # Composer configuration
├── vite.config.mjs         # Vite configuration
├── theme.json              # WordPress theme config
├── screenshot.png          # Theme screenshot
└── README.md               # Theme documentation
```

## Next Steps

After successful installation:

1. [Configure your theme](./setup.md)
2. [Customize colors and styling](./colors.md)
3. [Set up the build process](./vite.md)
4. [Learn about theme structure](./theme-structure.md)

## Troubleshooting

### Installation Fails

- Check PHP and Node.js versions
- Verify Composer is properly installed
- Ensure sufficient disk space
- Check internet connectivity for package downloads

### Permission Errors

```bash
# Fix file permissions (Linux/macOS)
chmod -R 755 your-theme-directory
chown -R www-data:www-data your-theme-directory
```

### Development Server Issues

- Check if port 3000 is available
- Verify Vite configuration
- Clear node_modules and reinstall if needed

For additional help, consult the [TailPress community](https://github.com/tailpress/tailpress/discussions).
