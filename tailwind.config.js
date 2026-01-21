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
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brew-brown': '#6B4423',
                'brew-light-brown': '#8B5A3C',
                'brew-orange': '#D4A574',
                'brew-white': '#F5F5F0',
                'brew-cream': '#F0E8DC',
            },
        },
    },

    plugins: [forms, typography],
};
