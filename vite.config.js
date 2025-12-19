import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin"; // <--- Pastikan baris ini ada
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"], // Sesuaikan path ini
            refresh: true,
        }),
        tailwindcss(),
    ],
});
