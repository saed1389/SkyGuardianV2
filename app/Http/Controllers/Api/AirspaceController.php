<?php
// app/Http/Controllers/Api/AirspaceController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AirspaceReadings;
use App\Models\AircraftTracks;
use App\Models\AirspaceAlerts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AirspaceController extends Controller
{
    public function storeReading(Request $request)
    {
        try {
            DB::beginTransaction();

            // Store main reading
            $reading = AirspaceReadings::create([
                'reading_timestamp' => $request->timestamp,
                'anomaly_score' => $request->anomaly_score,
                'adjusted_score' => $request->adjusted_score,
                'risk_level' => strtoupper($request->risk_level),
                'total_aircraft' => $request->total_aircraft,
                'military_aircraft' => $request->military_aircraft,
                'drone_aircraft' => $request->drone_aircraft,
                'high_threat_aircraft' => $request->high_threat_aircraft,
                'potential_threats' => $request->potential_threats,
                'nato_aircraft' => $request->nato_aircraft,
                'weather_multiplier' => $request->weather_multiplier,
                'weather_conditions' => $request->weather_conditions,
                'weather_visibility' => $request->weather_visibility,
                'temperature' => $request->temperature,
                'wind_speed' => $request->wind_speed,
                'flight_data_json' => $request->flight_data_json,
                'summary_json' => $request->summary_json,
                'map_url' => $request->map_url,
            ]);

            // Parse and store aircraft tracks
            if ($request->flight_data_json) {
                $flightData = json_decode($request->flight_data_json, true);
                if (isset($flightData['unique_aircraft']) && is_array($flightData['unique_aircraft'])) {
                    foreach ($flightData['unique_aircraft'] as $aircraft) {
                        AircraftTracks::create([
                            'airspace_reading_id' => $reading->id,
                            'hex_code' => $aircraft['hex'] ?? null,
                            'callsign' => $aircraft['flight'] ?? null,
                            'type' => $this->mapAircraftType($aircraft['type'] ?? 'unknown'),
                            'aircraft_name' => $aircraft['aircraft_name'] ?? null,
                            'country_origin' => $aircraft['country_of_origin'] ?? null,
                            'is_nato' => $aircraft['is_nato'] ?? false,
                            'is_friendly' => $aircraft['is_friendly'] ?? false,
                            'is_potential_threat' => $aircraft['is_potential_threat'] ?? false,
                            'threat_level' => $aircraft['threat_level'] ?? 1,
                            'latitude' => $aircraft['lat'] ?? null,
                            'longitude' => $aircraft['lon'] ?? null,
                            'altitude' => $aircraft['alt_baro'] ?? null,
                            'speed' => $aircraft['gs'] ?? null,
                            'heading' => $aircraft['track'] ?? null,
                            'tracking_data' => json_encode($aircraft),
                            'detected_at' => $aircraft['timestamp'] ?? now(),
                        ]);
                    }
                }
            }

            // Check for alerts
            if (in_array(strtoupper($request->risk_level), ['HIGH', 'CRITICAL'])) {
                AirspaceAlerts::create([
                    'airspace_reading_id' => $reading->id,
                    'alert_type' => 'HIGH_RISK',
                    'severity' => strtoupper($request->risk_level),
                    'title' => "Airspace Alert: {$request->risk_level} Risk Detected",
                    'description' => "Anomaly score: {$request->anomaly_score}, Military aircraft: {$request->military_aircraft}",
                    'ai_analyzed' => !empty($request->summary_json),
                    'ai_analysis' => $request->summary_json,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reading stored successfully',
                'reading_id' => $reading->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Airspace reading store failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function mapAircraftType($type): string
    {
        $map = [
            'civil' => 'CIVIL',
            'military' => 'MILITARY',
            'drone' => 'DRONE',
            'uav' => 'DRONE',
        ];

        return $map[strtolower($type)] ?? 'UNKNOWN';
    }
}
