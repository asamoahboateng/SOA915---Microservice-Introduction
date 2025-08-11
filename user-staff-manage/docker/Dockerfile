FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        sockets

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy existing app source
COPY . /var/www

# Run composer install (with --no-dev and optimized autoloader for production)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Set proper permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

EXPOSE 8000


CMD ["php-fpm"]
# ENTRYPOINT ["php", "artisan"]

# CMD ["serve", "--host=0.0.0.0", "--port=8000"]

# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


