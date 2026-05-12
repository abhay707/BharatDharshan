#!/bin/sh
set -e

echo "==> Running Laravel boot sequence..."

# Cache config/routes/views for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run DB migrations (idempotent, safe in production)
php artisan migrate --force

# Create storage symlink (safe if already exists)
php artisan storage:link || true

# Ensure correct permissions for runtime directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Boot complete. Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
