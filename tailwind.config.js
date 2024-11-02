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
                    '50': '#effefb',
                    '100': '#c8fff5',
                    '200': '#90ffec',
                    '300': '#51f7e1',
                    '400': '#1de4d0',
                    '500': '#05c7b7',
                    '600': '#00a196',
                    '700': '#058079',
                    '800': '#0a6561',
                    '900': '#0e5351',
                    '950': '#003333',
                },
            }
        },
    },

    plugins: [forms, typography],
};
