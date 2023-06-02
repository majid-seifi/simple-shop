import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    base: './',
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        },
        watch: {
            // https://vitejs.dev/config/server-options.html#server-watch
            usePolling: true
        }
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
