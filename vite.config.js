import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    build: {
        rollupOptions: {
            output: {
                // Split the vendor libraries out of the app bundle. React and
                // Inertia change rarely, so returning visitors reuse a cached
                // copy instead of re-downloading everything after each deploy.
                manualChunks: {
                    react: ['react', 'react-dom'],
                    inertia: ['@inertiajs/react'],
                    motion: ['framer-motion'],
                },
            },
        },
    },
});
