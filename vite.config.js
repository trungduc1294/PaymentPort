import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            // Add your laravel plugins here
            'resources/css/style.css',
        ]),
    ],
});
