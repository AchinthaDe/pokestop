#!/bin/sh
echo "Container started - script is running"
set -e

echo "Working directory: $(pwd)"
echo "User: $(whoami)"

# Start PHP-FPM first
echo "Starting PHP-FPM..."
php-fpm -D || { echo "PHP-FPM failed to start"; exit 1; }

sleep 2
echo "PHP-FPM started, checking process..."
ps aux | grep php-fpm | head -5

# Start Nginx
echo "Starting Nginx..."
exec nginx -g 'daemon off;'
