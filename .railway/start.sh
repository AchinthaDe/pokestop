#!/usr/bin/env sh
set -e

# Resolve port
PORT_VALUE="${PORT:-8080}"
if [ -z "$PORT_VALUE" ]; then
  PORT_VALUE=8080
fi

# Ensure required Laravel setup (no key:generate writing .env)
if [ ! -f storage/framework/cache/.config_cached ]; then
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true
  mkdir -p storage/framework/cache && touch storage/framework/cache/.config_cached
fi

# Run pending migrations if DB is reachable (non-fatal if fails)
(php artisan migrate --force || echo "Migration step skipped (DB not ready)")

echo "Starting FrankenPHP on port ${PORT_VALUE}"
exec frankenphp php-server --listen :${PORT_VALUE} --root /app/public
