#!/usr/bin/env sh
set -e
 
echo "Starting PHP-FPM + Nginx on port 8080"
 
# Laravel config cache
php artisan config:cache || true
 
# Start PHP-FPM in daemon mode
php-fpm -D
 
# Start Nginx in foreground
nginx -g 'daemon off;'
