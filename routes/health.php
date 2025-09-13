<?php

use Illuminate\Support\Facades\Route;

// Health check route for Railway
Route::get('/health', function () {
    try {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
            'service' => 'snack-app',
            'version' => '1.0.0'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'error' => $e->getMessage()
        ], 500);
    }
});

// Alternative health check route
Route::get('/ping', function () {
    return 'pong';
});
