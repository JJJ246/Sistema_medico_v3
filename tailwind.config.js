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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary-blue': '#1e40af',
                'medical-green': '#10b981',
                'bg-light': '#f8fafc',
                'blue-gradient-from': '#1e3a8a',
                'blue-gradient-to': '#3b82f6',
            },
        },
    },

    plugins: [forms],
};
