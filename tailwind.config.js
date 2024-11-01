import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': {
                    '50': '#f5faf3',
                    '100': '#e7f4e4',
                    '200': '#d0e8ca',
                    '300': '#aad5a0',
                    '400': '#7db96f',
                    '500': '#5a9c4b',
                    '600': '#407434',
                    '700': '#396530',
                    '800': '#31512a',
                    '900': '#294324',
                    '950': '#12240f',
                },

            }
        },
    },

    plugins: [forms, typography],
};
