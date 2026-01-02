<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomePage extends Component
{
    public $loading = false;

    // Real-time stats
    public $stats = [];
    public $recentAlerts = [];
    public $activeAircraft = [];
    public $aiAnalysis = [];
    public $todayAnalyses = [];
    public $threatTrends = [];

    // Map markers data
    public $mapMarkers = [];

    // Time periods
    public $timeRange = '1hour';

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->loading = true;

        // 1. Real-time statistics
        $this->loadRealTimeStats();

        // 2. Recent AI alerts
        $this->loadRecentAlerts();

        // 3. Active aircraft positions
        $this->loadActiveAircraft();

        // 4. AI threat analysis
        $this->loadAIAnalysis();

        // 5. Today's analyses
        $this->loadTodayAnalyses();

        // 6. Threat trends
        $this->loadThreatTrends();

        // 7. Map markers
        $this->prepareMapMarkers();

        $this->loading = false;

        // Dispatch event for map update
        $this->dispatch('dashboard-data-loaded', markers: $this->mapMarkers);
    }

    private function loadRealTimeStats()
    {
        $now = Carbon::now();
        $oneHourAgo = $now->copy()->subHour();
        $todayStart = $now->copy()->startOfDay();

        // Active aircraft in last hour
        $activeAircraft = DB::table('skyguardian_positions')
            ->where('position_time', '>=', $oneHourAgo)
            ->distinct('hex')
            ->count('hex');

        // Military aircraft active
        $activeMilitary = DB::table('skyguardian_positions as p')
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('p.position_time', '>=', $oneHourAgo)
            ->where('a.is_military', true)
            ->distinct('p.hex')
            ->count('p.hex');

        // High threat aircraft
        $highThreat = DB::table('skyguardian_positions as p')
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('p.position_time', '>=', $oneHourAgo)
            ->where('a.threat_level', '>=', 4)
            ->distinct('p.hex')
            ->count('p.hex');

        // AI alerts today
        $aiAlertsToday = DB::table('skyguardian_ai_alerts')
            ->whereDate('ai_timestamp', $todayStart)
            ->count();

        // Aircraft in Estonia right now
        $inEstonia = DB::table('skyguardian_positions')
            ->where('position_time', '>=', $oneHourAgo)
            ->where('in_estonia', true)
            ->distinct('hex')
            ->count('hex');

        // Total aircraft in database
        $totalAircraft = DB::table('skyguardian_aircraft')->count();

        // Latest analysis
        $latestAnalysis = DB::table('skyguardian_analyses')
            ->orderBy('analysis_time', 'desc')
            ->first();

        // Calculate average alerts per hour for today (fix the error)
        $currentHour = (int) date('H');
        $avgPerHour = $aiAlertsToday > 0 && $currentHour > 0
            ? round($aiAlertsToday / ($currentHour + 1), 1)
            : 0;

        $this->stats = [
            'active_aircraft' => $activeAircraft,
            'active_military' => $activeMilitary,
            'high_threat' => $highThreat,
            'ai_alerts_today' => $aiAlertsToday,
            'in_estonia' => $inEstonia,
            'total_aircraft' => $totalAircraft,
            'latest_analysis' => $latestAnalysis,
            'update_time' => $now->format('H:i:s'),
            'avg_alerts_per_hour' => $avgPerHour,
        ];
    }

    private function loadRecentAlerts()
    {
        $this->recentAlerts = DB::table('skyguardian_ai_alerts')
            ->select('id', 'analysis_id', 'trigger_level', 'threat_level', 'situation', 'primary_concern', 'ai_timestamp', 'confidence')
            ->orderBy('ai_timestamp', 'desc')
            ->limit(5)
            ->get();
    }

    private function loadActiveAircraft()
    {
        $oneHourAgo = Carbon::now()->subHour();

        // Get latest positions for each aircraft in last hour
        $this->activeAircraft = DB::table('skyguardian_positions as p')
            ->select([
                'p.hex',
                'p.latitude',
                'p.longitude',
                'p.altitude',
                'p.speed',
                'p.heading',
                'p.position_time',
                'p.in_estonia',
                'p.near_sensitive',
                'p.threat_level as position_threat',
                'a.callsign',
                'a.type',
                'a.country',
                'a.is_military',
                'a.is_drone',
                'a.is_nato',
                'a.threat_level as aircraft_threat',
            ])
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('p.position_time', '>=', $oneHourAgo)
            ->whereIn('p.id', function($query) use ($oneHourAgo) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('skyguardian_positions')
                    ->where('position_time', '>=', $oneHourAgo)
                    ->groupBy('hex');
            })
            ->orderBy('p.position_time', 'desc')
            ->limit(10)
            ->get();
    }

    private function loadAIAnalysis()
    {
        $todayStart = Carbon::today();

        $this->aiAnalysis = DB::table('skyguardian_ai_alerts')
            ->select(
                'threat_level',
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(ai_confidence_score) as avg_confidence'),
                DB::raw('MAX(ai_timestamp) as latest_alert')
            )
            ->whereDate('ai_timestamp', $todayStart)
            ->groupBy('threat_level')
            ->orderBy('threat_level', 'desc')
            ->get();
    }

    private function loadTodayAnalyses()
    {
        $todayStart = Carbon::today();

        $this->todayAnalyses = DB::table('skyguardian_analyses')
            ->select(
                DB::raw('HOUR(analysis_time) as hour'),
                DB::raw('AVG(total_aircraft) as avg_aircraft'),
                DB::raw('AVG(military_aircraft) as avg_military'),
                DB::raw('AVG(anomaly_score) as avg_anomaly'),
                DB::raw('COUNT(*) as analysis_count')
            )
            ->whereDate('analysis_time', $todayStart)
            ->groupBy(DB::raw('HOUR(analysis_time)'))
            ->orderBy('hour')
            ->get();
    }

    private function loadThreatTrends()
    {
        $lastWeek = Carbon::now()->subDays(7);

        $this->threatTrends = DB::table('skyguardian_analyses')
            ->select(
                DB::raw('DATE(analysis_time) as date'),
                DB::raw('AVG(anomaly_score) as avg_anomaly'),
                DB::raw('MAX(anomaly_score) as max_anomaly'),
                DB::raw('AVG(composite_score) as avg_composite'),
                DB::raw('SUM(CASE WHEN overall_risk = "HIGH" THEN 1 ELSE 0 END) as high_risk_count')
            )
            ->where('analysis_time', '>=', $lastWeek)
            ->groupBy(DB::raw('DATE(analysis_time)'))
            ->orderBy('date')
            ->get();
    }

    private function prepareMapMarkers()
    {
        $this->mapMarkers = [];

        foreach ($this->activeAircraft as $aircraft) {
            if (!is_null($aircraft->latitude) && !is_null($aircraft->longitude)) {
                $this->mapMarkers[] = [
                    'hex' => $aircraft->hex,
                    'callsign' => $aircraft->callsign ?? 'N/A',
                    'type' => $aircraft->type ?? 'Unknown',
                    'country' => $aircraft->country ?? 'Unknown',
                    'threat_level' => intval($aircraft->aircraft_threat),
                    'is_military' => boolval($aircraft->is_military),
                    'is_drone' => boolval($aircraft->is_drone),
                    'is_nato' => boolval($aircraft->is_nato),
                    'latitude' => floatval($aircraft->latitude),
                    'longitude' => floatval($aircraft->longitude),
                    'altitude' => floatval($aircraft->altitude),
                    'speed' => floatval($aircraft->speed),
                    'heading' => floatval($aircraft->heading),
                    'position_time' => $aircraft->position_time,
                    'in_estonia' => boolval($aircraft->in_estonia),
                    'near_sensitive' => boolval($aircraft->near_sensitive),
                    'is_active' => true,
                ];
            }
        }
    }

    public function refreshDashboard()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.user.home-page')->layout('components.layouts.userApp');
    }
}
