import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader'


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
        svgLoader({
            svgo: true,
            svgoConfig: {
                plugins: [
                    {
                        name: 'removeAttrs',
                            params: {
                            attrs: '(fill|stroke)', // remove qualquer fill ou stroke fixo
                        },
                    },
                ],
            },
        })
    ],
});
