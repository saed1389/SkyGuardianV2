<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\AirspaceController;
use App\Http\Controllers\N8nImageController;

Route::prefix('airspace')->group(function () {
    Route::post('/reading', [AirspaceController::class, 'storeReading']);
    Route::get('/readings', [AirspaceController::class, 'getReadings']);
    Route::get('/alerts', [AirspaceController::class, 'getAlerts']);
    Route::get('/statistics', [AirspaceController::class, 'getStatistics']);
});

Route::post('api/n8n/save-image', [N8nImageController::class, 'store']);

Route::post('api/sensor/heartbeat', function (Request $request) {
    try {
        $token = $request->header('X-Sensor-Token');
        if (!$token) {
            return response()->json(['error' => 'No Token Provided'], 401);
        }

        $sensor = DB::table('skyguardian_sensors')->where('api_token', $token)->first();

        if (!$sensor) {
            return response()->json(['error' => 'Invalid Token'], 403);
        }

        $status = 'ONLINE';
        if ((float)$request->input('temperature') > 70) {
            $status = 'WARNING';
        }
        DB::table('skyguardian_sensors')
            ->where('id', $sensor->id)
            ->update([
                'temperature'    => $request->input('temperature', 0),
                'cpu_load'       => $request->input('cpu_load', 0),
                'uptime_seconds' => $request->input('uptime', 0), // Python'dan gelen 'uptime'
                'ip_address'     => $request->ip(),
                'status'         => $status,
                'last_seen'      => now(),
                'updated_at'     => now(),
            ]);

        return response()->json(['status' => 'success']);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Server Error',
            'message' => $e->getMessage()
        ], 500);
    }
});
