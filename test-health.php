<?php
// Simple health check test script
// Run this locally to test: php test-health.php

echo "Testing health check endpoints...\n";

// Test /health endpoint
$healthUrl = 'http://localhost:8000/health';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $healthUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Health check response (HTTP $httpCode):\n";
echo $response . "\n";

if ($httpCode === 200) {
    echo "✅ Health check passed!\n";
} else {
    echo "❌ Health check failed!\n";
}
