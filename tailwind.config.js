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
        height: (theme) => ({
			auto: "auto",
			...theme("spacing"),
			full: "100%",
			screen: "calc(var(--vh) * 100)",
		}),
		minHeight: (theme) => ({
			0: "0",
			...theme("spacing"),
			full: "100%",
			screen: "calc(var(--vh) * 100)",
		}),
        extend: {
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
