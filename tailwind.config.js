import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                 'tm-cyan': '#00b4d8', // Tech-Mart Cyan
                 'tm-dark-blue': '#00296b', // Tech-Mart Dark Blue
                 'tm-yellow': '#ffd60a', // Tech-Mart Yellow
    },
        },
    },

    plugins: [forms],
};
