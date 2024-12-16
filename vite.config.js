// import { defineConfig } from "vite";
// import laravel from "laravel-vite-plugin";

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: [
//                 "resources/css/app.css",
//                 "resources/js/app.js",
//                 "resources/js/bootstrap.js",
//             ],
//             refresh: true,
//         }),
//     ],
//     server: {
//         host: "localhost",
//         port: 5173,
//         https: false,
//         cors: {
//             origin: "*",
//             methods: ["GET", "POST", "PUT", "DELETE"],
//             allowedHeaders: ["Content-Type", "Authorization"],
//         },
//     },
// });

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"], // Sesuaikan dengan file Anda
            refresh: false, // Matikan refresh otomatis
        }),
    ],
    build: {
        outDir: "public/build", // Direktori output
        assetsDir: "assets", // Folder untuk file CSS, JS, dll.
    },
});
