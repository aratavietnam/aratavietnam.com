# Vite Build System

Comprehensive guide to using Vite with TailPress for modern WordPress theme development.

## Overview

Since version 5, TailPress uses Vite as the default build tool, providing lightning-fast development with Hot Module Replacement (HMR) and optimized production builds.

## Why Vite

Vite offers several advantages for WordPress theme development:

- **Fast Development**: Instant server start and HMR
- **Modern Tooling**: Native ES modules and modern JavaScript features
- **Optimized Builds**: Efficient bundling and code splitting
- **Plugin Ecosystem**: Rich ecosystem of plugins and integrations
- **Framework Agnostic**: Works with any frontend framework

## Configuration

### Basic Vite Configuration

TailPress includes a pre-configured `vite.config.mjs` file:

```javascript
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

const isBuild = process.env.NODE_ENV === 'production';

export default defineConfig({
    plugins: [tailwindcss()],
    build: {
        base: isBuild ? '/wp-content/themes/your-theme/dist/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: 'http://your-site.test',
        },
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                'app-css': 'resources/css/app.css',
            },
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: '[name].js',
                assetFileNames: '[name].[ext]'
            }
        }
    }
});
```

### Configuration Options

#### Base Path

The base path determines where assets are served from:

```javascript
base: isBuild ? '/wp-content/themes/your-theme/dist/' : '/',
```

#### Development Server

Configure the development server settings:

```javascript
server: {
    port: 3000,              // Development server port
    cors: true,              // Enable CORS
    origin: 'http://your-site.test',  // Your local WordPress URL
    host: true,              // Listen on all addresses
    hmr: {
        port: 3001           // HMR port (if different)
    }
}
```

#### Entry Points

Define your CSS and JavaScript entry points:

```javascript
rollupOptions: {
    input: {
        app: 'resources/js/app.js',
        'app-css': 'resources/css/app.css',
        admin: 'resources/js/admin.js',        // Additional entries
        'editor-css': 'resources/css/editor.css'
    }
}
```

## Development Workflow

### Starting Development Server

```bash
npm run dev
```

This command:
- Starts Vite development server on `http://localhost:3000`
- Enables Hot Module Replacement
- Watches for file changes
- Compiles assets on-demand

### Development Features

#### Hot Module Replacement

HMR allows instant updates without page refresh:

- **CSS Changes**: Applied immediately without reload
- **JavaScript Changes**: Module updates with state preservation
- **Template Changes**: Automatic page refresh

#### Source Maps

Vite generates source maps for easier debugging:

```javascript
build: {
    sourcemap: true  // Enable source maps
}
```

### Development Commands

```bash
# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview

# Watch mode (build on changes)
npm run watch
```

## HTTPS Development

### Setting Up HTTPS

For local HTTPS development, install the SSL plugin:

```bash
npm install @vitejs/plugin-basic-ssl --save-dev
```

### Configure SSL Plugin

Update `vite.config.mjs`:

```javascript
import basicSsl from '@vitejs/plugin-basic-ssl';

export default defineConfig({
    plugins: [
        tailwindcss(),
        basicSsl()  // Add SSL plugin
    ],
    server: {
        https: true,  // Enable HTTPS
        port: 3000
    }
});
```

### WordPress Configuration

Update your theme's ViteCompiler configuration:

```php
->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
    ->registerAsset('resources/css/app.css')
    ->registerAsset('resources/js/app.js')
    ->ssl(verify: false) // Enable SSL with no verification
)
```

### SSL Certificate

Navigate to `https://localhost:3000` and accept the security warning to trust the self-signed certificate.

## Production Builds

### Building for Production

```bash
npm run build
```

Production builds include:

- **Minification**: CSS and JavaScript minification
- **Tree Shaking**: Removal of unused code
- **Asset Optimization**: Image and font optimization
- **Code Splitting**: Automatic code splitting for better caching

### Build Output

Production builds are output to the `dist/` directory:

```
dist/
├── app.css              # Compiled CSS
├── app.js               # Compiled JavaScript
├── manifest.json        # Asset manifest
└── assets/              # Additional assets
    ├── images/
    └── fonts/
```

### Asset Manifest

Vite generates a manifest file for asset mapping:

```json
{
    "resources/css/app.css": {
        "file": "app.css",
        "src": "resources/css/app.css"
    },
    "resources/js/app.js": {
        "file": "app.js",
        "src": "resources/js/app.js"
    }
}
```

## Advanced Configuration

### Custom Plugins

Add additional Vite plugins:

```javascript
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(),
        // Add more plugins here
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'),
            '~': resolve(__dirname, 'node_modules')
        }
    }
});
```

### Environment Variables

Use environment variables for configuration:

```javascript
// vite.config.mjs
export default defineConfig(({ mode }) => {
    const isDev = mode === 'development';
    
    return {
        plugins: [tailwindcss()],
        define: {
            __DEV__: isDev
        }
    };
});
```

### Asset Processing

Configure asset processing:

```javascript
build: {
    assetsDir: 'assets',
    rollupOptions: {
        output: {
            assetFileNames: (assetInfo) => {
                const info = assetInfo.name.split('.');
                const ext = info[info.length - 1];
                
                if (/\.(png|jpe?g|svg|gif|tiff|bmp|ico)$/i.test(assetInfo.name)) {
                    return `images/[name].[hash][extname]`;
                }
                if (/\.(woff2?|eot|ttf|otf)$/i.test(assetInfo.name)) {
                    return `fonts/[name].[hash][extname]`;
                }
                return `assets/[name].[hash][extname]`;
            }
        }
    }
}
```

## Integration with WordPress

### Asset Enqueuing

TailPress automatically handles asset enqueuing through the ViteCompiler:

```php
function your_theme(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
            )
            ->enqueueAssets()
        );
}
```

### Development vs Production

The ViteCompiler automatically detects the environment:

- **Development**: Loads assets from Vite dev server
- **Production**: Loads compiled assets from `dist/` directory

### Custom Asset Handles

Customize asset handles for better control:

```php
$viteCompiler = new TailPress\Framework\Assets\ViteCompiler;
$viteCompiler->handle = 'your-theme-name';

// Use the custom compiler
->withCompiler($viteCompiler, fn($compiler) => $compiler
    ->registerAsset('resources/css/app.css')
    ->registerAsset('resources/js/app.js')
)
```

## Troubleshooting

### Common Issues

#### Port Already in Use

```bash
# Check what's using port 3000
lsof -i :3000

# Use different port
npm run dev -- --port 3001
```

#### CORS Issues

Update your Vite configuration:

```javascript
server: {
    cors: {
        origin: ['http://localhost:8000', 'http://your-site.test'],
        credentials: true
    }
}
```

#### Assets Not Loading

1. Check Vite dev server is running
2. Verify WordPress site URL matches Vite origin
3. Check browser console for CORS errors
4. Ensure proper asset registration in PHP

#### Build Failures

1. Check for syntax errors in source files
2. Verify all imports are correct
3. Clear node_modules and reinstall
4. Check for conflicting dependencies

### Performance Optimization

#### Bundle Analysis

Analyze your bundle size:

```bash
npm install --save-dev rollup-plugin-visualizer
```

```javascript
// vite.config.mjs
import { visualizer } from 'rollup-plugin-visualizer';

export default defineConfig({
    plugins: [
        tailwindcss(),
        visualizer({
            filename: 'dist/stats.html',
            open: true
        })
    ]
});
```

#### Code Splitting

Implement manual code splitting:

```javascript
// Dynamic imports for code splitting
const heavyModule = await import('./heavy-module.js');
```

## Migration from Laravel Mix

### Differences from Laravel Mix

- **Configuration**: JavaScript-based vs PHP-based
- **Speed**: Significantly faster development builds
- **HMR**: Built-in Hot Module Replacement
- **Modern Features**: Native ES modules support

### Migration Steps

1. Remove Laravel Mix dependencies
2. Install Vite and related packages
3. Update configuration file
4. Modify build scripts in package.json
5. Update asset registration in PHP

For detailed migration guide, see the [Laravel Mix documentation](./laravel-mix.md).

## Next Steps

- [Release and Deployment](./release.md) - Prepare for production
- [Font Management](./fonts.md) - Configure custom fonts
- [Best Practices](./best-practices.md) - Development guidelines
