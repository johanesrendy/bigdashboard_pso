# Tahap 1: Build Node.js dependencies dan frontend (Multistage Build)
FROM node:20-bullseye AS node-build

# Set working directory
WORKDIR /var/www

# Copy file yang dibutuhkan untuk instalasi dependencies
COPY package*.json ./

# Install Node.js dependencies
RUN npm install --legacy-peer-deps

# Copy seluruh source code
COPY . .

# Build frontend assets (Tailwind, Vue, dll)
RUN npm run build

# Tahap 2: Base PHP-FPM Image
FROM php:8.2-fpm

# Konfigurasi User ID dan Group ID
ENV HOST_GID=1000 \
    HOST_UID=1000

# Tambahkan user www-data dengan UID dan GID yang sama
RUN groupmod -g $HOST_GID www-data && \
    usermod -u $HOST_UID www-data

# Install Dependencies dan PHP Extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    libonig-dev \
    libzip-dev \
    ca-certificates \
    git && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl && \
    pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set Working Directory
WORKDIR /var/www

# Copy hasil build frontend dari Node.js stage
COPY --from=node-build /var/www/public /var/www/public
COPY --from=node-build /var/www/resources /var/www/resources

# Copy project source code
COPY . .

# Install PHP dependencies dengan Composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions untuk Laravel storage folder
RUN chown -R www-data:www-data /var/www/storage && chmod -R 775 /var/www/storage

# Expose PHP-FPM Port
EXPOSE 9000

CMD ["php-fpm"]