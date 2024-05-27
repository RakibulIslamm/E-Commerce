import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            /* screens: {
                xs: { max: "480px" },
                sm: { max: "599px" },
                md: { min: "600px", max: "1024px" },
                lg: { min: "1025px" },
            }, */
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
                lora: ["Lora", "serif"],
            },
            transitionProperty: {
                height: "height",
            },
        },
    },

    plugins: [forms, require("tailwind-scrollbar")],
};
