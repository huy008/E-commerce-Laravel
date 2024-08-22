import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/views/dashboard/component/head.blade.php",
                "resources/views/dashboard/component/script.blade.php",
            ],
            refresh: true,
        }),
    ],
});
