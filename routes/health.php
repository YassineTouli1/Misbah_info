<?php

use Illuminate\Support\Facades\Route;

// Health check route for Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'service' => 'snack-app'
    ]);
});

// Alternative health check route
Route::get('/ping', function () {
    return 'pong';
});
