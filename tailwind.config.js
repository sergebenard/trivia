import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './app/Http/Livewire/**/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            minWidth: {
                'sm': '40em',
            }
        },
    },

    plugins: [
        require("daisyui"),
    ],
    daisyui: {
        themes: [
            {
                corporate: {
                    ...require("daisyui/src/theming/themes")["[data-theme=corporate]"],
                    ".bg-board": {
                        "background-color": "#072399",
                        "color": "WHITE",
                    },
                    ".btn-clue, .box-category": {
                        "color": "WHITE",
                        "background-color": "#072399",
                        "border-color": "#072399",
                        "text-shadow": "2px 2px 0px #000000",
                    },

                    ".btn-clue:hover": {
                        "background-color": "#073499"
                    },
                }
            }
        ]
    }
};
