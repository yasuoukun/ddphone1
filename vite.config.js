import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // theme.css is served directly from public/css/theme.css with proper cache headers
            // Loading it through Vite too would cause duplicate stylesheet processing
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
