#!/bin/sh
set -e

echo "Preparing Laravel application..."

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
fi
chmod 664 database/database.sqlite

if [ -z "${APP_KEY:-}" ]; then
  php artisan key:generate --force --no-interaction
fi

php artisan config:clear || true
php artisan cache:clear || true
php artisan optimize:clear || true
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php artisan serve --host 0.0.0.0 --port "${PORT:-10000}"
