import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primario': '#1A57DB',   // Un azul personalizado
                'secundario': '#FCC731',  // Un amarillo personalizado
                'fondo': '#121212',       // Un fondo oscuro
                'super-blanco': '#F7F7F7', // Un blanco casi blanco
                'acento': '#FF6F61',      // Un color de acento
                'cafe-claro':'#F4F1EC',
                'cafe-medio':'#F5F2EE',
                'cafe-oscuro':'#D0C6B6',
                'negro':'#23262C'


              },
        },
    },
    plugins: [],
};
