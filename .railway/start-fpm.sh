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

# Verify PHP-FPM is listening on port 9000
echo "Checking if PHP-FPM is listening on port 9000..."
netstat -tuln | grep 9000 || echo "WARNING: PHP-FPM not listening on port 9000!"

# Test PHP-FPM connection
echo "Testing PHP-FPM connection..."
if command -v cgi-fcgi > /dev/null; then
    SCRIPT_FILENAME=/var/www/html/public/index.php REQUEST_METHOD=GET cgi-fcgi -bind -connect 127.0.0.1:9000 || echo "Connection test failed"
fi

# Create symlink for logs
ln -sf /dev/stdout /var/log/nginx/access.log
ln -sf /dev/stderr /var/log/nginx/error.log

# Start Nginx with error logging
echo "Starting Nginx..."
echo "If you get 502, check error logs above"
exec nginx -g 'daemon off;'
