#!/usr/bin/env sh
set -e

PORT_VALUE="${PORT:-8080}"
echo "Starting PHP-FPM + Nginx on port ${PORT_VALUE}"

# Update Nginx config with the correct port
sed -i "s/PORT_PLACEHOLDER/${PORT_VALUE}/g" /etc/nginx/sites-available/default

# Laravel config cache
php artisan config:cache || true

# Start PHP-FPM in daemon mode
php-fpm -D

# Start Nginx in foreground
nginx -g 'daemon off;'
