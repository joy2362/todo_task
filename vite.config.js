import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";
import tailwindcss from "@tailwindcss/vite";
import Unimport from "unimport/unplugin";

export default defineConfig({
    server: {
        hmr: {
            host: "localhost",
        },
    },
    plugins: [
        tailwindcss(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Unimport.vite({
            addons: {
                vueTemplate: true,
            },
            imports: [{ name: "push", from: "notivue" }],
        }),
    ],
    resolve: {
        alias: {
            "@image": path.resolve(__dirname, "/resources/images"),
            "@css": path.resolve(__dirname, "/resources/css"),
            "@": path.resolve(__dirname, "./resources/js"),
        },
    },
    build: {
        target: "esnext",
    },
});
