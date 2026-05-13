FROM php:8.2-fpm

# Install dependencies including Nginx
RUN apt-get update && apt-get install -y \
    nginx git zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev curl nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip gd

# MongoDB PHP driver
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/html
COPY . .

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Storage permissions
RUN mkdir -p storage/app/public \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache
RUN php artisan storage:link || true

# Node build
RUN npm ci && npm run build

# Copy Nginx config
COPY nginx.conf /etc/nginx/sites-available/default

# Copy and set up start script
COPY start-fpm.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080
CMD ["/start.sh"]
