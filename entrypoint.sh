#!/bin/bash

# Bersihkan cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Cek apakah ada file package.json dan jalankan npm install dan build secara berurutan
if [ -f package.json ]; then
    echo "Installing npm dependencies..."
    npm install   # Menjalankan npm install terlebih dahulu

    echo "Running npm build..."
    npm run build # Menjalankan build frontend setelah dependensi terinstal

    echo "Running npm dev server..."
    npm run dev & # Menjalankan npm run dev di latar belakang (untuk development server)
fi

# Jalankan PHP-FPM
php-fpm
