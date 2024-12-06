FROM php:8.2-fpm

# Set environment variables for UID and GID
ENV HOST_GID=1000 \
    HOST_UID=1000

# Cek apakah grup dan pengguna www-data sudah ada, jika tidak, buat grup dan pengguna dengan UID dan GID yang ditentukan
RUN if ! getent group www-data; then \
        groupadd -g $HOST_GID www-data; \
    fi && \
    if ! getent passwd www-data; then \
        useradd -u $HOST_UID -g www-data -m www-data; \
    fi

# Install dependencies untuk PHP
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    libonig-dev \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    ca-certificates \
    curl

# Clear cache untuk mengurangi ukuran image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Ambil Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Salin aplikasi dan sesuaikan kepemilikan file
COPY --chown=www-data:www-data . /var/www/

# Ganti user ke www-data
USER www-data

# Pindah ke direktori kerja
WORKDIR /var/www

# Install dependensi PHP menggunakan Composer (sebagai www-data)
RUN composer install -v

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000
