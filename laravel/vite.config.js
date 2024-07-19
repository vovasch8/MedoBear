import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/delivery.css',
                'resources/css/main.css',
                'resources/css/map.css',
                'resources/css/price-filter.css',
                'resources/css/slider.css',
                'resources/css/styles.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/chart-area.js',
                'resources/js/chart-bar.js',
                'resources/js/chart-pie.js',
                'resources/js/charts.js',
                'resources/js/datatables.js',
                'resources/js/datatables-simple.js',
                'resources/js/main.js',
                'resources/js/map.js',
                'resources/js/price-filter.js',
                'resources/js/scripts.js',
                'resources/js/slider.js',
                'resources/js/tables.js',
            ],
            refresh: true,
        }),
    ],
});
