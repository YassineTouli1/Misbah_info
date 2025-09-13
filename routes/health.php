<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Health check route for Railway
Route::get('/health', function () {
    $checks = [];
    
    try {
        // Basic app check
        $checks['app'] = [
            'status' => 'ok',
            'message' => 'Application is running',
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
        ];

        // Database connection check
        try {
            DB::connection()->getPdo();
            $checks['database'] = [
                'status' => 'ok',
                'message' => 'Database connection successful',
                'driver' => DB::connection()->getDriverName(),
                'database' => DB::connection()->getDatabaseName(),
            ];
        } catch (\Exception $e) {
            $checks['database'] = [
                'status' => 'error',
                'message' => 'Database connection failed',
                'error' => $e->getMessage(),
            ];
            throw $e;
        }

        // Storage check
        try {
            $storagePath = storage_path();
            $isWritable = is_writable($storagePath);
            $checks['storage'] = [
                'status' => $isWritable ? 'ok' : 'error',
                'message' => $isWritable ? 'Storage is writable' : 'Storage is not writable',
                'path' => $storagePath,
                'writable' => $isWritable,
            ];
            
            if (!$isWritable) {
                throw new \Exception('Storage directory is not writable');
            }
        } catch (\Exception $e) {
            $checks['storage'] = [
                'status' => 'error',
                'message' => 'Storage check failed',
                'error' => $e->getMessage(),
            ];
            throw $e;
        }

        // Overall status
        $status = collect($checks)->every(fn($check) => $check['status'] === 'ok') ? 200 : 500;
        
        return response()->json([
            'status' => $status === 200 ? 'ok' : 'error',
            'timestamp' => now()->toISOString(),
            'service' => 'snack-app',
            'version' => '1.0.0',
            'checks' => $checks
        ], $status);

    } catch (\Exception $e) {
        Log::error('Health check failed: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Health check failed',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'checks' => $checks ?? []
        ], 500);
    }
});

// Simple ping endpoint
Route::get('/ping', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'pong',
        'timestamp' => now()->toISOString()
    ]);
});
