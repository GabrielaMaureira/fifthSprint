#!/bin/sh

echo "🚀 Waiting for Mysql to be ready & accepting connections"
until mysqladmin ping -h db --silent; do
  sleep 2
done

echo "✅ Executing migrations and seeders..."
php artisan migrate --seed --force

echo "✅ Executing Passport installation..."
php artisan passport:install --force

chmod -R 775 storage bootstrap/cache

# Starting PHP-FPM
exec "$@"

