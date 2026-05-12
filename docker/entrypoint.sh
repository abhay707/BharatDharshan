#!/bin/sh
set -e

echo "==> Running Laravel boot sequence..."

# Cache config/routes/views for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Wait for DB to be reachable before migrating
echo "==> Waiting for database connection..."
MAX_TRIES=30
COUNT=0
until php artisan db:monitor --max=1 > /dev/null 2>&1; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$MAX_TRIES" ]; then
        echo "!!! Database not reachable after ${MAX_TRIES}s — skipping migrations."
        echo "    Set DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD in Render env vars."
        break
    fi
    echo "    Waiting for DB... (${COUNT}/${MAX_TRIES})"
    sleep 1
done

# Run DB migrations if DB is available
if php artisan db:monitor --max=1 > /dev/null 2>&1; then
    echo "==> Running migrations..."
    php artisan migrate --force
    echo "==> Creating storage symlink..."
    php artisan storage:link || true
else
    echo "==> Skipping migrations (no DB connection)."
fi

# Ensure correct permissions for runtime directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Boot complete. Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
