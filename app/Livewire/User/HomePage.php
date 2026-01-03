<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomePage extends Component
{
    public $loading = false;
    public $autoRefreshEnabled = true;

    public $stats = [];
    public $recentAlerts = [];
    public $activeAircraft = [];
    public $aiAnalysis = [];
    public $todayAnalyses = [];
    public $threatTrends = [];
    public $mapMarkers = [];

    public function mount(): void
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData(): void
    {
        $this->loading = true;

        DB::beginTransaction();
        try {
            $this->loadRealTimeStats();
            $this->loadRecentAlerts();
            $this->loadActiveAircraft();
            $this->loadAIAnalysis();
            $this->loadTodayAnalyses();
            $this->loadThreatTrends();
            $this->prepareMapMarkers();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->recentAlerts = collect();
            $this->activeAircraft = collect();
            $this->aiAnalysis = collect();
            $this->todayAnalyses = collect();
            $this->threatTrends = collect();
            $this->mapMarkers = [];
            $this->stats = $this->getDefaultStats();
        }

        $this->loading = false;
        $this->dispatch('dashboard-data-loaded', markers: $this->mapMarkers);
    }

    private function loadRealTimeStats(): void
    {
        $now = Carbon::now();
        $oneHourAgo = $now->copy()->subHour();
        $todayStart = $now->copy()->startOfDay();

        $activeAircraftQuery = DB::table('skyguardian_positions')
            ->where('position_time', '>=', $oneHourAgo);

        $activeAircraft = $activeAircraftQuery->distinct('hex')->count('hex');

        $threatCounts = DB::table('skyguardian_positions as p')
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('p.position_time', '>=', $oneHourAgo)
            ->selectRaw('
                COUNT(DISTINCT CASE WHEN a.is_military = true THEN p.hex END) as active_military,
                COUNT(DISTINCT CASE WHEN a.threat_level >= 4 THEN p.hex END) as high_threat'
            )
            ->first();

        $aiAlertsToday = DB::table('skyguardian_ai_alerts')
            ->whereDate('ai_timestamp', $todayStart)
            ->count();

        $inEstonia = DB::table('skyguardian_positions')
            ->where('position_time', '>=', $oneHourAgo)
            ->where('in_estonia', true)
            ->distinct('hex')
            ->count('hex');

        $totalAircraft = DB::table('skyguardian_aircraft')->count();

        $latestAnalysis = DB::table('skyguardian_analyses')
            ->orderBy('analysis_time', 'desc')
            ->first();

        $currentHour = $now->hour;
        $avgPerHour = $currentHour > 0 ? round($aiAlertsToday / ($currentHour + 1), 1) : 0;

        $this->stats = [
            'active_aircraft' => $activeAircraft,
            'active_military' => $threatCounts->active_military ?? 0,
            'high_threat' => $threatCounts->high_threat ?? 0,
            'ai_alerts_today' => $aiAlertsToday,
            'in_estonia' => $inEstonia,
            'total_aircraft' => $totalAircraft,
            'latest_analysis' => $latestAnalysis,
            'update_time' => $now->format('H:i:s'),
            'avg_alerts_per_hour' => $avgPerHour,
            'current_hour' => $currentHour,
        ];
    }

    private function loadRecentAlerts(): void
    {
        $this->recentAlerts = DB::table('skyguardian_ai_alerts')
            ->select('id', 'analysis_id', 'trigger_level', 'threat_level',
                'situation', 'primary_concern', 'ai_timestamp', 'confidence')
            ->orderBy('ai_timestamp', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($alert) {
                $alert->confidence = floatval($alert->confidence);
                $alert->threat_level = strtoupper($alert->threat_level);
                return $alert;
            });
    }

    private function loadActiveAircraft(): void
    {
        $oneHourAgo = Carbon::now()->subHour();

        $recentAircraft = DB::table('skyguardian_positions')
            ->select('hex', DB::raw('MAX(position_time) as latest_time'))
            ->where('position_time', '>=', $oneHourAgo)
            ->groupBy('hex')
            ->get();

        if ($recentAircraft->isEmpty()) {
            $this->activeAircraft = collect();
            return;
        }

        $latestPositions = [];
        foreach ($recentAircraft as $aircraft) {
            $latestPositions[] = DB::table('skyguardian_positions')
                ->where('hex', $aircraft->hex)
                ->where('position_time', $aircraft->latest_time)
                ->first();
        }

        $this->activeAircraft = collect($latestPositions)
            ->filter(function ($position) {
                return $position !== null;
            })
            ->map(function ($position) {
                $aircraft = DB::table('skyguardian_aircraft')
                    ->where('hex', $position->hex)
                    ->first();

                if (!$aircraft) {
                    return null;
                }

                $positionTime = Carbon::parse($position->position_time);
                $minutesAgo = $positionTime->diffInMinutes(now());

                return (object) [
                    'hex' => $position->hex,
                    'latitude' => $position->latitude,
                    'longitude' => $position->longitude,
                    'altitude' => $position->altitude,
                    'speed' => $position->speed,
                    'heading' => $position->heading,
                    'position_time' => $position->position_time,
                    'in_estonia' => $position->in_estonia,
                    'near_sensitive' => $position->near_sensitive,
                    'position_threat' => $position->threat_level,
                    'callsign' => $aircraft->callsign,
                    'type' => $aircraft->type,
                    'country' => $aircraft->country,
                    'is_military' => boolval($aircraft->is_military),
                    'is_drone' => boolval($aircraft->is_drone),
                    'is_nato' => boolval($aircraft->is_nato),
                    'aircraft_threat' => intval($aircraft->threat_level),
                    'minutes_ago' => $minutesAgo,
                ];
            })
            ->filter(function ($aircraft) {
                return $aircraft !== null && $aircraft->minutes_ago <= 60;
            })
            ->sortByDesc('position_time')
            ->take(20)
            ->values();
    }

    private function loadAIAnalysis(): void
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
            ->get()
            ->map(function ($analysis) {
                $analysis->avg_confidence = floatval($analysis->avg_confidence);
                $analysis->count = intval($analysis->count);
                return $analysis;
            });
    }

    private function loadTodayAnalyses(): void
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
            ->get()
            ->map(function ($analysis) {
                $analysis->avg_aircraft = floatval($analysis->avg_aircraft);
                $analysis->avg_military = floatval($analysis->avg_military);
                $analysis->avg_anomaly = floatval($analysis->avg_anomaly);
                $analysis->analysis_count = intval($analysis->analysis_count);
                return $analysis;
            });
    }

    private function loadThreatTrends(): void
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
            ->get()
            ->map(function ($trend) {
                $trend->avg_anomaly = floatval($trend->avg_anomaly);
                $trend->max_anomaly = floatval($trend->max_anomaly);
                $trend->avg_composite = floatval($trend->avg_composite);
                $trend->high_risk_count = intval($trend->high_risk_count);
                return $trend;
            });
    }

    private function prepareMapMarkers(): void
    {
        $this->mapMarkers = $this->activeAircraft->filter(function ($aircraft) {
            return !is_null($aircraft->latitude) &&
                !is_null($aircraft->longitude) &&
                $aircraft->minutes_ago <= 60;
        })->map(function ($aircraft) {
            return [
                'hex' => $aircraft->hex,
                'callsign' => $aircraft->callsign ?? 'N/A',
                'type' => $aircraft->type ?? 'Unknown',
                'country' => $aircraft->country ?? 'Unknown',
                'threat_level' => $aircraft->aircraft_threat,
                'is_military' => $aircraft->is_military,
                'is_drone' => $aircraft->is_drone,
                'is_nato' => $aircraft->is_nato,
                'latitude' => floatval($aircraft->latitude),
                'longitude' => floatval($aircraft->longitude),
                'altitude' => floatval($aircraft->altitude),
                'speed' => floatval($aircraft->speed),
                'heading' => floatval($aircraft->heading),
                'position_time' => $aircraft->position_time,
                'in_estonia' => $aircraft->in_estonia,
                'near_sensitive' => $aircraft->near_sensitive,
                'is_active' => true,
                'minutes_ago' => $aircraft->minutes_ago,
            ];
        })->values()->toArray();
    }

    private function getDefaultStats(): array
    {
        return [
            'active_aircraft' => 0,
            'active_military' => 0,
            'high_threat' => 0,
            'ai_alerts_today' => 0,
            'in_estonia' => 0,
            'total_aircraft' => 0,
            'latest_analysis' => null,
            'update_time' => Carbon::now()->format('H:i:s'),
            'avg_alerts_per_hour' => 0,
            'current_hour' => 0,
        ];
    }

    public function toggleAutoRefresh(): void
    {
        $this->autoRefreshEnabled = !$this->autoRefreshEnabled;
        $this->dispatch('auto-refresh-toggled', enabled: $this->autoRefreshEnabled);
    }

    public function refreshDashboard(): void
    {
        $this->loadDashboardData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.user.home-page')->layout('components.layouts.userApp');
    }
}
