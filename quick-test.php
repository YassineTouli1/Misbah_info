<?php
// Quick health check test
// Run with: php quick-test.php

echo "🧪 Quick Health Check Test\n";
echo "==========================\n\n";

// Test 1: Basic PHP functionality
echo "1. Testing basic PHP functionality...\n";
try {
    $test = "Hello World";
    echo "   ✅ PHP is working: $test\n";
} catch (Exception $e) {
    echo "   ❌ PHP error: " . $e->getMessage() . "\n";
}

// Test 2: Check if Laravel can bootstrap
echo "\n2. Testing Laravel bootstrap...\n";
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    echo "   ✅ Laravel bootstrap successful\n";
} catch (Exception $e) {
    echo "   ❌ Laravel bootstrap failed: " . $e->getMessage() . "\n";
}

// Test 3: Check environment
echo "\n3. Testing environment...\n";
if (file_exists('.env')) {
    echo "   ✅ .env file exists\n";
    
    $env = file_get_contents('.env');
    if (strpos($env, 'APP_KEY=') !== false && strpos($env, 'APP_KEY=$') === false) {
        echo "   ✅ APP_KEY is set\n";
    } else {
        echo "   ❌ APP_KEY is not set\n";
    }
} else {
    echo "   ❌ .env file not found\n";
}

// Test 4: Check routes
echo "\n4. Testing routes...\n";
try {
    $routes = file_get_contents('routes/web.php');
    if (strpos($routes, "Route::get('/health'") !== false) {
        echo "   ✅ /health route exists\n";
    } else {
        echo "   ❌ /health route not found\n";
    }
    
    if (strpos($routes, "Route::get('/ping'") !== false) {
        echo "   ✅ /ping route exists\n";
    } else {
        echo "   ❌ /ping route not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error reading routes: " . $e->getMessage() . "\n";
}

echo "\n🏁 Quick test complete!\n";
echo "\nTo test the actual endpoints, run:\n";
echo "1. php artisan serve\n";
echo "2. curl http://localhost:8000/ping\n";
echo "3. curl http://localhost:8000/health\n";

