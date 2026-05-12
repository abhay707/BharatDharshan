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
DB_READY=0
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

# Run DB migrations and seed if DB is available
if php artisan db:monitor --max=1 > /dev/null 2>&1; then
    DB_READY=1
    echo "==> Running migrations..."
    php artisan migrate --force

    echo "==> Creating storage symlink..."
    php artisan storage:link || true

    # Seed only when the states table is empty (first boot)
    STATE_COUNT=$(php artisan tinker --execute="echo \App\Models\State::count();" 2>/dev/null | tail -1 | tr -d '[:space:]')
    if [ "$STATE_COUNT" = "0" ] || [ -z "$STATE_COUNT" ]; then
        echo "==> Database is empty — running seeders..."
        php artisan db:seed --force
        echo "==> Seeding complete."
    else
        echo "==> Database already has data (${STATE_COUNT} states) — skipping seed."
    fi

    # Create admin user if it doesn't exist
    ADMIN_EXISTS=$(php artisan tinker --execute="echo \App\Models\User::where('email','admin@bharatdarshan.com')->count();" 2>/dev/null | tail -1 | tr -d '[:space:]')
    if [ "$ADMIN_EXISTS" = "0" ] || [ -z "$ADMIN_EXISTS" ]; then
        echo "==> Creating admin user..."
        php artisan tinker --execute="
            \App\Models\User::create([
                'name'     => 'Admin',
                'email'    => 'admin@bharatdarshan.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            echo 'Admin user created.';
        " 2>/dev/null
        echo "==> Admin user ready: admin@bharatdarshan.com"
    else
        echo "==> Admin user already exists — skipping."
    fi
else
    echo "==> Skipping migrations (no DB connection)."
fi

# Ensure correct permissions for runtime directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==> Boot complete. Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
