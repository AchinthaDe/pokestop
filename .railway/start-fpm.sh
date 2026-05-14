#!/usr/bin/env sh
set -e

echo "=== Starting PHP-FPM + Nginx ==="

# Laravel config cache
echo "Running artisan config:cache..."
php artisan config:cache || echo "Warning: config:cache failed"

# Start PHP-FPM in daemon mode
echo "Starting PHP-FPM..."
php-fpm -D

# Wait a moment for PHP-FPM to fully start
sleep 2

# Verify PHP-FPM is running
if pgrep php-fpm > /dev/null; then
    echo "✓ PHP-FPM is running"
    echo "PHP-FPM processes:"
    ps aux | grep php-fpm | grep -v grep
else
    echo "✗ PHP-FPM failed to start!"
    exit 1
fi

# Check if PHP-FPM is listening on port 9000
echo "Checking PHP-FPM port 9000..."
netstat -tuln | grep 9000 || echo "Warning: Port 9000 not listening"

# Start Nginx in foreground
echo "Starting Nginx..."
nginx -g 'daemon off;'
