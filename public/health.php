<?php

// Enable detailed error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Simple health check that doesn't depend on Laravel
header('Content-Type: application/json');

// We never fail the healthcheck with 500. Instead, we always return 200 and include diagnostics.
$diag = [
    'status' => 'ok',
    'timestamp' => date('c'),
    'service' => 'snack-app',
    'version' => '1.0.0',
    'checks' => []
];

// Storage check
$storagePath = __DIR__ . '/../storage';
$isWritable = @is_writable($storagePath);
$diag['checks']['storage'] = [
    'writable' => (bool)$isWritable,
    'path' => $storagePath,
    'status' => $isWritable ? 'ok' : 'warn',
];

// Database check (best-effort)
$dbResult = 'not checked';
if (file_exists(__DIR__ . '/../.env')) {
    $dbConfig = [
        'driver' => getenv('DB_CONNECTION') ?: 'sqlite',
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_DATABASE') ?: __DIR__ . '/../database/database.sqlite',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
    ];
    try {
        if ($dbConfig['driver'] === 'sqlite' && !file_exists($dbConfig['database'])) {
            @touch($dbConfig['database']);
        }
        $dsn = "{$dbConfig['driver']}:";
        if ($dbConfig['driver'] === 'sqlite') {
            $dsn .= $dbConfig['database'];
        } else {
            $dsn .= "host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']}";
        }
        $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        $dbResult = 'connected';
    } catch (Throwable $e) {
        $dbResult = 'error: ' . $e->getMessage();
    }
}
$diag['checks']['database'] = $dbResult;

http_response_code(200);
echo json_encode($diag);
