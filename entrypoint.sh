#!/bin/bash

# Bersihkan cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Cek apakah ada file package.json dan jalankan npm install dan build secara berurutan
if [ -f package.json ]; then
    echo "Running npm install..."
    npm install

    # Jalankan npm run build dan pastikan berhasil
    echo "Running npm build..."
    npm run build

    # Cek apakah npm run build berhasil
    if [ $? -eq 0 ]; then
        echo "npm build berhasil!"
    else
        echo "npm build gagal. Keluar dari skrip."
        exit 1  # Keluar jika build gagal
    fi

    # Jalankan npm dev server setelah build
    echo "Running npm dev server..."
    npm run dev &  # Menjalankan npm dev di background
fi

# Jalankan PHP-FPM
echo "Running PHP-FPM..."
php-fpm

# Menunggu semua background processes agar tidak keluar saat container mati
wait
