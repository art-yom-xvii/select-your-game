import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js", "resources/js/home.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "localhost",
        port: 5174,
        strictPort: true,
        hmr: {
            host: "localhost",
            port: 5174,
        },
    },
});
