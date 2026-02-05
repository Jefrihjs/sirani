FROM php:8.2-cli

RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

WORKDIR /var/www/html

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
