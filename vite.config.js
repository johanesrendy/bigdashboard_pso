import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        // Agar bisa diakses dari semua IP, bukan hanya localhost
        host: "0.0.0.0", // Membuat Vite dapat diakses dari semua IP
        port: 5173, // Gunakan port yang sesuai, default adalah 5173
        cors: {
            // Mengizinkan semua origin untuk mengakses resource
            origin: "*", // Kamu bisa mengganti '*' dengan domain tertentu jika perlu
            methods: ["GET", "POST", "PUT", "DELETE"],
            allowedHeaders: ["Content-Type", "Authorization"],
        },
        proxy: {
            // Proksi untuk API Laravel jika diperlukan
            "/api": "http://localhost", // Ubah '/api' sesuai dengan path API Laravel
        },
    },
});
