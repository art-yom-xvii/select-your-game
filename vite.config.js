import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0",
        port: 5173,
        origin: "https://vite.laravel.dev",
        cors: {
            origin: ["https://laravel.dev", "https://vite.laravel.dev"],
            credentials: true,
        },
        hmr: {
            host: "vite.laravel.dev",
            protocol: "wss",
            clientPort: 443,
        },
    },
});
