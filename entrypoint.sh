#!/bin/bash

# Bersihkan cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Cek apakah ada file package.json dan jalankan npm install dan build secara berurutan
if [ -f package.json ]; then
    echo "Running npm dev server..."
    npm run dev &  # Menjalankan npm run dev di latar belakang (untuk development server)
fi

# Jalankan PHP-FPM
php-fpm

# Menunggu semua background processes agar tidak keluar saat container mati
wait
