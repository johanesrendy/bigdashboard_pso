FROM php:8.2-fpm

ENV HOST_GID=1000 \
    HOST_UID=1000

# Tambahkan user dengan UID dan GID yang sama
RUN groupmod -g $HOST_GID www-data && \
    usermod -u $HOST_UID www-data

# Install dependencies
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
    curl \
    git

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY --chown=www-data:www-data . /var/www/
RUN chown -R www-data:www-data /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
RUN npm install

# Expose PHP-FPM and npm dev server ports
EXPOSE 9000 3000

# Tambahkan entrypoint script untuk menjalankan Laravel dan npm
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
