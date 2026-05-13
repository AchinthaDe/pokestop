#!/usr/bin/env sh
set -e

PORT_VALUE="${PORT:-80}"
echo "Starting Apache on port ${PORT_VALUE}"

# Debug: Show current MPM state
echo "=== MPMs before cleanup ==="
ls -la /etc/apache2/mods-enabled/mpm_* 2>/dev/null || echo "No MPM symlinks found"

# Forcefully remove all MPM symlinks and recreate only prefork
rm -f /etc/apache2/mods-enabled/mpm_*.load
rm -f /etc/apache2/mods-enabled/mpm_*.conf
ln -sf /etc/apache2/mods-available/mpm_event.load /etc/apache2/mods-enabled/mpm_event.load
ln -sf /etc/apache2/mods-available/mpm_event.conf /etc/apache2/mods-enabled/mpm_event.conf

# Debug: Show MPM state after cleanup
echo "=== MPMs after cleanup ==="
ls -la /etc/apache2/mods-enabled/mpm_*

# Configure port
cat > /etc/apache2/ports.conf <<EOF
Listen ${PORT_VALUE}
EOF

sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT_VALUE}>/g" \
    /etc/apache2/sites-available/000-default.conf

php artisan config:cache || true

exec apache2-foreground
