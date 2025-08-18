# Setup and Configuration

Comprehensive guide for configuring TailPress themes after installation.

## Theme Configuration Overview

All theme setup is handled in the `functions.php` file. TailPress provides a fluent API for configuring various aspects of your WordPress theme.

## Automatic Features

TailPress automatically handles:

- **Asset Enqueuing**: Your theme assets are enqueued with full Vite compatibility
- **WordPress Features**: Common WordPress theme features are registered
- **Navigation Menu**: A primary navigation menu is set up by default

## Basic Theme Configuration

### Minimal Setup

The simplest TailPress theme configuration:

```php
<?php

function your_theme(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance();
}

your_theme();
```

### Standard Configuration

A typical theme setup with assets and basic features:

```php
<?php

function your_theme(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
            )
            ->enqueueAssets()
        );
}

your_theme();
```

## Asset Management

### Registering Assets

TailPress uses a ViteCompiler for modern asset handling:

```php
->assets(fn($manager) => $manager
    ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
        ->registerAsset('resources/css/app.css')
        ->registerAsset('resources/js/app.js')
        ->editorStyleFile('resources/css/editor-style.css')
    )
    ->enqueueAssets()
)
```

### Custom Asset Handle

To customize the asset handle (useful for branding):

```php
$viteCompiler = new TailPress\Framework\Assets\ViteCompiler;
$viteCompiler->handle = 'your-theme-name';

return TailPress\Framework\Theme::instance()
    ->assets(fn($manager) => $manager
        ->withCompiler($viteCompiler, fn($compiler) => $compiler
            ->registerAsset('resources/css/app.css')
            ->registerAsset('resources/js/app.js')
        )
        ->enqueueAssets()
    );
```

### HTTPS Development Server

For secure development servers, configure SSL:

```php
->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
    ->registerAsset('resources/css/app.css')
    ->registerAsset('resources/js/app.js')
    ->ssl(verify: false) // Add SSL support
)
```

## Theme Features

### Adding Theme Features

```php
->features(fn($manager) => $manager
    ->add(TailPress\Framework\Features\MenuOptions::class)
)
```

### Available Features

- **MenuOptions**: Enhanced menu management capabilities
- Custom features can be added by extending the framework

## Menu Configuration

### Registering Menus

```php
->menus(fn($manager) => $manager
    ->add('primary', __('Primary Menu', 'your-textdomain'))
    ->add('footer', __('Footer Menu', 'your-textdomain'))
    ->add('social', __('Social Links', 'your-textdomain'))
)
```

### Menu Parameters

- **Location ID**: Unique identifier for the menu location
- **Description**: Human-readable description for admin interface
- **Text Domain**: For internationalization

## WordPress Theme Support

### Standard Theme Support

```php
->themeSupport(fn($manager) => $manager->add([
    'title-tag',
    'custom-logo',
    'post-thumbnails',
    'align-wide',
    'wp-block-styles',
    'responsive-embeds',
    'html5' => [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ],
]))
```

### Theme Support Options

- **title-tag**: Let WordPress manage document title
- **custom-logo**: Enable custom logo upload
- **post-thumbnails**: Enable featured images
- **align-wide**: Support for wide and full-width blocks
- **wp-block-styles**: Default block styles
- **responsive-embeds**: Responsive embedded content
- **html5**: HTML5 markup for various elements

### Custom Post Type Support

```php
->themeSupport(fn($manager) => $manager->add([
    'post-thumbnails' => ['post', 'page', 'custom_post_type'],
]))
```

## Translation Support

### Loading Translation Files

```php
->withTextdomain('your-textdomain')
```

### Custom Translation Path

```php
->withTextdomain('your-textdomain', '/custom/languages/path')
```

By default, TailPress looks in the `/languages` directory.

### Translation File Structure

```
your-theme/
├── languages/
│   ├── your-textdomain.pot      # Template file
│   ├── your-textdomain-en_US.po # English translations
│   ├── your-textdomain-en_US.mo # Compiled English
│   ├── your-textdomain-es_ES.po # Spanish translations
│   └── your-textdomain-es_ES.mo # Compiled Spanish
```

## Complete Configuration Example

```php
<?php

function your_theme(): TailPress\Framework\Theme
{
    $viteCompiler = new TailPress\Framework\Assets\ViteCompiler;
    $viteCompiler->handle = 'your-theme';
    
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler($viteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
            )
            ->enqueueAssets()
        )
        ->features(fn($manager) => $manager
            ->add(TailPress\Framework\Features\MenuOptions::class)
        )
        ->menus(fn($manager) => $manager
            ->add('primary', __('Primary Menu', 'your-textdomain'))
            ->add('footer', __('Footer Menu', 'your-textdomain'))
        )
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ],
        ]))
        ->withTextdomain('your-textdomain');
}

your_theme();
```

## Advanced Configuration

### Custom Asset Compiler

For advanced use cases, you can create custom compilers:

```php
class CustomCompiler extends TailPress\Framework\Assets\Compiler
{
    // Custom compilation logic
}

// Use in theme configuration
->withCompiler(new CustomCompiler, fn($compiler) => $compiler
    // Custom compiler configuration
)
```

### Conditional Loading

Load different assets based on conditions:

```php
->assets(fn($manager) => $manager
    ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
        ->registerAsset('resources/css/app.css')
        ->registerAsset('resources/js/app.js')
        ->when(is_front_page(), fn($c) => $c->registerAsset('resources/css/homepage.css'))
        ->when(is_admin(), fn($c) => $c->registerAsset('resources/js/admin.js'))
    )
    ->enqueueAssets()
)
```

## Configuration Validation

### Checking Configuration

Verify your theme configuration is working:

1. **Assets Loading**: Check browser developer tools for CSS/JS files
2. **Menu Locations**: Verify menus appear in Appearance > Menus
3. **Theme Support**: Check available features in theme customizer
4. **Translations**: Test with different languages if applicable

### Debug Mode

Enable WordPress debug mode to catch configuration errors:

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## Next Steps

After configuring your theme:

1. [Customize colors and styling](./colors.md)
2. [Set up custom fonts](./fonts.md)
3. [Configure the build process](./vite.md)
4. [Learn about pagination](./pagination.md)

## Troubleshooting

### Assets Not Loading

- Check file paths in asset registration
- Verify Vite development server is running
- Ensure proper file permissions

### Menu Not Appearing

- Verify menu registration in theme configuration
- Check if menu is assigned in WordPress admin
- Ensure proper template code for displaying menus

### Translation Issues

- Verify text domain matches throughout theme
- Check translation file paths and permissions
- Ensure proper locale settings in WordPress
