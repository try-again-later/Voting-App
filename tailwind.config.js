const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                'status-open': colors.gray[300],
                'status-in-progress': colors.yellow[400],
                'status-implemented': colors.emerald[400],
                'status-considering': colors.indigo[400],
                'status-closed': colors.red[400],

                'status-hover-open': colors.gray[200],
                'status-hover-in-progress': colors.yellow[300],
                'status-hover-implemented': colors.emerald[300],
                'status-hover-considering': colors.indigo[300],
                'status-hover-closed': colors.red[300],

                'status-text-open': colors.gray[700],
                'status-text-in-progress': colors.white,
                'status-text-implemented': colors.white,
                'status-text-considering': colors.white,
                'status-text-closed': colors.white,
            },
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
    ],
};
