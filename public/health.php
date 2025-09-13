<?php

// Simple health check that doesn't depend on Laravel
header('Content-Type: application/json');

try {
    // Check if we can write to storage
    $storagePath = __DIR__ . '/../storage';
    $isWritable = is_writable($storagePath);
    
    if (!$isWritable) {
        throw new Exception('Storage directory is not writable');
    }
    
    // Check database connection if possible
    $dbConnected = false;
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
                touch($dbConfig['database']);
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
            
            $dbConnected = true;
        } catch (PDOException $e) {
            // Database connection failed, but we'll still return 200 with a warning
            $dbConnected = false;
            $dbError = $e->getMessage();
        }
    }
    
    // All checks passed
    http_response_code(200);
    echo json_encode([
        'status' => 'ok',
        'timestamp' => date('c'),
        'service' => 'snack-app',
        'version' => '1.0.0',
        'storage' => [
            'writable' => $isWritable,
            'path' => $storagePath,
        ],
        'database' => $dbConnected ? 'connected' : ($dbError ?? 'not configured'),
    ]);
    
} catch (Exception $e) {
    // Something went wrong
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ]);
}
