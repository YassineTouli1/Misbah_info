#!/bin/bash

# Start script for Railway deployment
echo "🚀 Starting Snack App on Railway..."

# Set the port
export PORT=${PORT:-8000}

# Map Railway DATABASE_URL to Laravel DB_URL if present
if [ -n "$DATABASE_URL" ] && [ -z "$DB_URL" ]; then
    echo "🔗 Mapping DATABASE_URL -> DB_URL"
    export DB_URL="$DATABASE_URL"
fi

# Ensure logs go to container stdout/stderr
export LOG_CHANNEL=${LOG_CHANNEL:-stderr}

# Avoid DB-backed cache & session during boot
export CACHE_STORE=${CACHE_STORE:-file}
export CACHE_DRIVER=${CACHE_DRIVER:-file}
export SESSION_DRIVER=${SESSION_DRIVER:-file}

# Ensure an APP_KEY exists even without .env
if [ -z "$APP_KEY" ]; then
    echo "🔑 No APP_KEY found. Generating one for runtime..."
    export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
    # Best-effort write to .env if it exists
    if [ -f .env ]; then
        sed -i "s/^APP_KEY=.*/APP_KEY=${APP_KEY//\//\/}/" .env 2>/dev/null || true
    fi
fi

# If no DB configured, default to SQLite and ensure file exists
if [ -z "$DB_CONNECTION" ] && [ -z "$DB_URL" ]; then
    export DB_CONNECTION=sqlite
    export DB_DATABASE="$(pwd)/database/database.sqlite"
    echo "🗃️ Using SQLite at $DB_DATABASE"
    mkdir -p "$(pwd)/database" || true
    if [ ! -f "$DB_DATABASE" ]; then
        touch "$DB_DATABASE"
    fi
    chmod 664 "$DB_DATABASE" || true
fi

# Ensure storage directories exist
echo "🗂️ Ensuring storage directories exist..."
mkdir -p storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache \
         storage/logs \
         bootstrap/cache

# Set permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

# Clear and cache configuration
echo "🧹 Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear

# Run migrations (non-blocking)
echo "🗄️ Running database migrations..."
if ! php artisan migrate --force; then
    echo "⚠️ Migrations failed (likely DB not configured yet). Continuing to serve the app."
fi

# Start the application
echo "🌐 Starting web server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
