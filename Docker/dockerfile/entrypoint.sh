#!/bin/bash

# Bersihkan cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Jalankan npm install dan npm run dev di latar belakang
if [ -f package.json ]; then
    npm install
    npm run dev &
fi

# Jalankan PHP-FPM
php-fpm
