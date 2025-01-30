import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        https: false,
        host: '0.0.0.0',
        origin: 'http://aisolutions.mamura.test:5173',
        hmr: {
            host: 'aisolutions.mamura.test',
        },
        watch: {
            usePolling: true
        },
        port: 5173,
        cors: {
            origin: true
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        vue({
            base: null, 
            includeAbsolute: false
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            'vue': 'vue/dist/vue.esm-bundler.js'
        },
    },
});
