import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/css/dashboard.css','resources/css/index.css','resources/css/login.css','resources/css/dataTables.bootstrap5.min.css',
                    'resources/css/dynamic-page.css','resources/css/sweetalert2.min.css','resources/css/quotes.css','resources/css/bootstrap.min.css',
                    'resources/js/app.js','resources/js/dashboard.js','resources/js/index.js','resources/js/login.js','resources/js/functions.js','resources/js/dataTables.bootstrap5.min.js','resources/js/jquery-3.7.1.min.js',
                    'resources/js/chart.js','resources/js/quotes.js','resources/js/sweetalert2.all.min.js','resources/js/bootstrap.bundle.min.js','resources/js/progress.js','resources/js/jquery.dataTables.min.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
