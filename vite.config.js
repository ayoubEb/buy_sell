import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/sass/login.scss',
              'resources/sass/app.scss',
              'resources/sass/style.scss',
              'resources/sass/document.scss',
              'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
