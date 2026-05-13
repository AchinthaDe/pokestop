FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev curl gnupg nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip gd

# MongoDB PHP driver
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

# Storage
RUN mkdir -p storage/app/public \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN php artisan storage:link || true

# Node build
RUN npm ci && npm run build

# Laravel public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

COPY .railway/start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
