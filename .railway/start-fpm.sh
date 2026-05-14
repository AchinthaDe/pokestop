#!/bin/sh
echo "Container started - script is running"
set -e

echo "Working directory: $(pwd)"
echo "User: $(whoami)"

# Check Laravel files exist
echo "Checking Laravel files..."
ls -la public/index.php || echo "ERROR: public/index.php not found!"
ls -la artisan || echo "ERROR: artisan not found!"

# Check environment
echo "Checking environment variables..."
echo "APP_KEY set: $(if [ -n "$APP_KEY" ]; then echo 'YES'; else echo 'NO - THIS WILL CAUSE 502!'; fi)"
echo "APP_ENV: ${APP_ENV:-not set}"
echo "APP_DEBUG: ${APP_DEBUG:-not set}"

# Check storage permissions
echo "Checking storage permissions..."
ls -ld storage/framework/sessions storage/framework/views storage/framework/cache || echo "Storage dirs missing"

# Start PHP-FPM first
echo "Starting PHP-FPM..."
php-fpm -D || { echo "PHP-FPM failed to start"; exit 1; }

sleep 2
echo "PHP-FPM started, checking process..."
ps aux | grep php-fpm | head -5

# Verify PHP-FPM is listening on port 9000
echo "Checking if PHP-FPM is listening on port 9000..."
netstat -tuln | grep 9000 || echo "WARNING: PHP-FPM not listening on port 9000!"

# Test PHP execution
echo "Testing PHP execution..."
echo '<?php echo "PHP works\n"; ?>' > /tmp/test.php
php /tmp/test.php || echo "PHP execution failed!"

# Create symlink for logs
ln -sf /dev/stdout /var/log/nginx/access.log
ln -sf /dev/stderr /var/log/nginx/error.log

# Start Nginx with error logging
echo "Starting Nginx..."
echo "Nginx errors will appear below when you access the site:"
exec nginx -g 'daemon off;'
