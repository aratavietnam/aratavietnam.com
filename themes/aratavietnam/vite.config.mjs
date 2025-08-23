import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

export default defineConfig(({ command }) => {
    const isBuild = command === 'build';

    return {
        base: isBuild ? '/wp-content/themes/aratavietnam/dist/' : '/',
        server: {
            port: 3000,
            cors: true,
            origin: 'http://aratavietnam.test',
        },
        build: {
            manifest: true,
            outDir: 'dist',
            rollupOptions: {
                input: [
                    'resources/js/app.js',
                    'resources/js/product-single.js',
                    'resources/css/app.css',
                    'resources/css/editor-style.css'
                ],
            },
            assetsDir: '', // Assets in the same directory
            copyPublicDir: false,
        },
        publicDir: false,
        assetsInclude: ['**/*.woff', '**/*.woff2', '**/*.ttf', '**/*.otf'],
        plugins: [
            tailwindcss(),
        ],
    }
});
