<?php

use App\Http\Controllers\Api\AirspaceController;
use App\Http\Controllers\N8nImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('airspace')->group(function () {
    Route::post('/reading', [AirspaceController::class, 'storeReading']);
    Route::get('/readings', [AirspaceController::class, 'getReadings']);
    Route::get('/alerts', [AirspaceController::class, 'getAlerts']);
    Route::get('/statistics', [AirspaceController::class, 'getStatistics']);
});

Route::post('api/n8n/save-image', [N8nImageController::class, 'store']);
