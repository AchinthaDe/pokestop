#!/usr/bin/env sh
set -e

PORT_VALUE="${PORT:-8080}"

echo "Starting Apache on port ${PORT_VALUE}"

cat > /etc/apache2/ports.conf <<EOF
Listen ${PORT_VALUE}
EOF

sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT_VALUE}>/g" \
    /etc/apache2/sites-available/000-default.conf

php artisan config:cache || true

exec apache2-foreground
