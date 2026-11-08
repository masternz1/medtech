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
        // The storefront uses square-ish tiles, like the approved homepage mock-up.
        // Overriding the scale here means every existing page picks it up.
        borderRadius: {
            none: '0',
            sm: '2px',
            DEFAULT: '2px',
            md: '3px',
            lg: '3px',
            xl: '4px',
            '2xl': '4px',
            '3xl': '4px',
            full: '9999px',
        },
        extend: {
            colors: {
                // Sampled from the homepage mock-up
                brand: {
                    50: '#eef5fd',
                    100: '#e3edf8',
                    200: '#c5d9ee',
                    300: '#93b8dc',
                    400: '#4f85b3',
                    500: '#2e72ae',
                    600: '#2166a1',
                    700: '#1b5385',
                    800: '#174468',
                    900: '#12344f',
                },
                mist: '#eef1f8',   // light blue tile
                sand: '#faf3e1',   // warm tile
                fog: '#f4f5f7',    // neutral tile / footer
                ink: '#1f2430',
                night: '#25262b',  // footer base bar
            },
            fontFamily: {
                sans: ['"IBM Plex Serif"', ...defaultTheme.fontFamily.serif],
                display: ['"IBM Plex Serif"', ...defaultTheme.fontFamily.serif],
            },
            maxWidth: {
                shell: '1320px',
            },
        },
    },

    plugins: [forms],
};
