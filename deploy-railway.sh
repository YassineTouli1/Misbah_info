#!/bin/bash

# Railway Deployment Script for Snack App
echo "🚀 Starting Railway deployment setup..."

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from the Laravel project root directory"
    exit 1
fi

echo "✅ Laravel project detected"

# Install dependencies
echo "📦 Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm install

# Build assets
echo "🏗️ Building assets..."
npm run build

# Generate application key if not exists
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate
fi

# Clear and cache configuration
echo "🧹 Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (only if database is configured)
if [ ! -z "$DB_CONNECTION" ] && [ "$DB_CONNECTION" != "sqlite" ]; then
    echo "🗄️ Running database migrations..."
    php artisan migrate --force
fi

echo "✅ Deployment setup complete!"
echo "🌐 Your app should be available at the Railway URL"
