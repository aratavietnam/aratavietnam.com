# TailPress Framework Documentation

Comprehensive documentation for developing WordPress themes with TailPress framework.

## Table of Contents

- [Introduction](#introduction)
- [Installation](./installation.md)
- [Setup and Configuration](./setup.md)
- [Theme Structure](./theme-structure.md)
- [Colors and Styling](./colors.md)
- [Font Management](./fonts.md)
- [Pagination](./pagination.md)
- [Comments System](./comments.md)
- [Vite Build System](./vite.md)
- [Release and Deployment](./release.md)
- [Best Practices](./best-practices.md)

## Introduction

TailPress is a WordPress theme boilerplate that combines the power of Tailwind CSS with modern development tools. It provides a solid foundation for building custom WordPress themes with:

### Core Features

- **Tailwind CSS 4.0**: Utility-first CSS framework
- **Vite Build System**: Lightning-fast development server with HMR
- **Modern WordPress**: Full support for latest WordPress features
- **Component Architecture**: Modular and reusable code structure
- **Performance Optimized**: Built for speed and efficiency

### Framework Components

- **Asset Management**: Automatic asset compilation and optimization
- **Theme Features**: Pre-configured WordPress theme support
- **Menu System**: Built-in navigation menu management
- **Translation Ready**: Full internationalization support
- **Block Editor**: Complete Gutenberg block editor integration

### Development Benefits

- **Hot Module Replacement**: Instant updates during development
- **Modern PHP**: Uses PHP 8.0+ features and best practices
- **Composer Integration**: Dependency management with autoloading
- **NPM Ecosystem**: Access to modern JavaScript tools
- **GitHub Workflows**: Automated release and deployment

## Requirements

### System Requirements

- **PHP**: 8.0 or higher
- **WordPress**: 6.2 or higher
- **Node.js**: 18.0+ (LTS recommended)
- **Composer**: 2.0+
- **NPM**: 8.0+ or Yarn 1.22+

### Development Tools

- **Git**: Version control
- **Docker**: For containerized development
- **VS Code**: Recommended editor with extensions
- **Browser DevTools**: For debugging and testing

## Quick Start

```bash
# Install TailPress CLI globally
composer global require tailpress/installer

# Create new theme
tailpress new your-theme-name

# Navigate to theme directory
cd your-theme-name

# Install dependencies
npm install
composer install

# Start development server
npm run dev
```

## Framework Architecture

### Core Classes

- **Theme**: Main theme instance and configuration
- **AssetManager**: Handles CSS/JS compilation and enqueuing
- **ViteCompiler**: Vite integration for modern build process
- **Pagination**: Custom pagination functionality
- **CommentWalker**: Enhanced comment display system

### File Structure

```
your-theme/
├── functions.php              # Theme configuration
├── style.css                  # Theme header
├── resources/                 # Source assets
│   ├── css/
│   │   ├── app.css           # Main CSS entry
│   │   ├── theme.css         # WordPress theme colors
│   │   └── editor-style.css  # Block editor styles
│   └── js/
│       └── app.js            # Main JavaScript entry
├── src/                      # PHP classes
├── template-parts/           # Reusable templates
├── dist/                     # Compiled assets
├── vendor/                   # Composer dependencies
├── node_modules/             # NPM dependencies
├── package.json              # NPM configuration
├── composer.json             # Composer configuration
├── vite.config.mjs          # Vite configuration
└── theme.json               # WordPress theme settings
```

## Key Concepts

### Asset Pipeline

TailPress uses Vite for asset compilation with automatic:
- CSS preprocessing and optimization
- JavaScript bundling and minification
- Hot module replacement during development
- Production build optimization

### Theme Configuration

All theme setup is handled through the main theme function:

```php
function your_theme(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(/* asset configuration */)
        ->features(/* theme features */)
        ->menus(/* navigation menus */)
        ->themeSupport(/* WordPress features */);
}
```

### WordPress Integration

TailPress automatically handles:
- Asset enqueuing with proper dependencies
- WordPress theme feature registration
- Navigation menu setup
- Block editor integration
- Translation file loading

## Development Workflow

1. **Setup**: Install dependencies and configure environment
2. **Development**: Use `npm run dev` for hot reload development
3. **Building**: Use `npm run build` for production assets
4. **Testing**: Test across different devices and browsers
5. **Release**: Use built-in release tools for deployment

## Next Steps

- [Installation Guide](./installation.md) - Detailed setup instructions
- [Theme Configuration](./setup.md) - Configure your theme
- [Styling Guide](./colors.md) - Customize colors and appearance
- [Build Process](./vite.md) - Understanding the build system

## Resources

- [TailPress Official Site](https://tailpress.io)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [WordPress Theme Development](https://developer.wordpress.org/themes/)
- [Vite Documentation](https://vitejs.dev/)

## Support

- [GitHub Repository](https://github.com/tailpress/tailpress)
- [Community Discussions](https://github.com/tailpress/tailpress/discussions)
- [Issue Tracker](https://github.com/tailpress/tailpress/issues)
