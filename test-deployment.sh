#!/bin/bash

echo "🧪 Testing Snack App Deployment Configuration"
echo "=============================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from the Laravel project root directory"
    exit 1
fi

echo "✅ Laravel project detected"

# Test 1: Check if app can start
echo ""
echo "🔍 Test 1: Starting Laravel development server..."
echo "Starting server on port 8000 (will run for 10 seconds)..."

# Start server in background
php artisan serve --host=0.0.0.0 --port=8000 &
SERVER_PID=$!

# Wait for server to start
sleep 5

# Test 2: Check health endpoints
echo ""
echo "🔍 Test 2: Testing health check endpoints..."

# Test /ping endpoint
echo "Testing /ping endpoint..."
PING_RESPONSE=$(curl -s -w "%{http_code}" http://localhost:8000/ping)
PING_HTTP_CODE="${PING_RESPONSE: -3}"
PING_BODY="${PING_RESPONSE%???}"

if [ "$PING_HTTP_CODE" = "200" ]; then
    echo "✅ /ping endpoint: OK (HTTP $PING_HTTP_CODE)"
    echo "   Response: $PING_BODY"
else
    echo "❌ /ping endpoint: FAILED (HTTP $PING_HTTP_CODE)"
    echo "   Response: $PING_BODY"
fi

# Test /health endpoint
echo ""
echo "Testing /health endpoint..."
HEALTH_RESPONSE=$(curl -s -w "%{http_code}" http://localhost:8000/health)
HEALTH_HTTP_CODE="${HEALTH_RESPONSE: -3}"
HEALTH_BODY="${HEALTH_RESPONSE%???}"

if [ "$HEALTH_HTTP_CODE" = "200" ]; then
    echo "✅ /health endpoint: OK (HTTP $HEALTH_HTTP_CODE)"
    echo "   Response: $HEALTH_BODY"
else
    echo "❌ /health endpoint: FAILED (HTTP $HEALTH_HTTP_CODE)"
    echo "   Response: $HEALTH_BODY"
fi

# Test root endpoint
echo ""
echo "Testing root endpoint..."
ROOT_RESPONSE=$(curl -s -w "%{http_code}" http://localhost:8000/)
ROOT_HTTP_CODE="${ROOT_RESPONSE: -3}"
ROOT_BODY="${ROOT_RESPONSE%???}"

if [ "$ROOT_HTTP_CODE" = "200" ]; then
    echo "✅ Root endpoint: OK (HTTP $ROOT_HTTP_CODE)"
else
    echo "❌ Root endpoint: FAILED (HTTP $ROOT_HTTP_CODE)"
    echo "   Response: $ROOT_BODY"
fi

# Stop the server
echo ""
echo "🛑 Stopping test server..."
kill $SERVER_PID 2>/dev/null

# Test 3: Check environment
echo ""
echo "🔍 Test 3: Checking environment configuration..."

if [ -f ".env" ]; then
    echo "✅ .env file exists"
    
    if grep -q "APP_KEY=" .env && ! grep -q "APP_KEY=$" .env; then
        echo "✅ APP_KEY is set"
    else
        echo "❌ APP_KEY is not set or empty"
        echo "   Run: php artisan key:generate"
    fi
else
    echo "❌ .env file not found"
    echo "   Copy .env.example to .env and configure it"
fi

# Test 4: Check database
echo ""
echo "🔍 Test 4: Checking database configuration..."

DB_CONNECTION=$(grep "DB_CONNECTION=" .env 2>/dev/null | cut -d'=' -f2)
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ -f "database/database.sqlite" ]; then
        echo "✅ SQLite database file exists"
    else
        echo "❌ SQLite database file not found"
        echo "   Run: touch database/database.sqlite"
    fi
else
    echo "ℹ️  Database connection: $DB_CONNECTION"
fi

echo ""
echo "🏁 Testing complete!"
echo ""
echo "Next steps:"
echo "1. If all tests pass, commit and push to GitHub"
echo "2. Check Railway deployment logs"
echo "3. If healthcheck still fails, try disabling it temporarily in Railway settings"
