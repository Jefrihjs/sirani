FROM php:8.2-fpm

# Install dependensi sistem + library JPEG & Freetype
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# KONFIGURASI GD: Memberitahu PHP agar GD mendukung JPEG dan Freetype
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install ekstensi PHP (termasuk GD yang sudah dikonfigurasi)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Ambil Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

USER www-data
