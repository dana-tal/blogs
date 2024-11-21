import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        "./node_modules/tw-elements/js/**/*.js"
    ],
    theme: {
        extend: {
            colors:{
                "brownBear":"#835C3B",
            },
            backgroundColor:{
                "camelBrown":"#C19A6B",
                "brownBear":"#835C3B",
                "antiqueWhite":"#FAEBD7",
                "darkBrown":"#654321"
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    darkMode: "class",
    plugins: [],
};
