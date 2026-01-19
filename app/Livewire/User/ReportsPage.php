<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportsPage extends Component
{
    public $reports = [];
    public $loading = false;
    public $generatingReport = false;
    public $activeReportType = 'daily';
    public $reportData = null;
    public $showReportModal = false;
    public $startDate;
    public $endDate;
    public $reportFilterCountry = 'all';
    public $reportFilterType = 'all';
    public $reportFilterThreatLevel = 'all';
    public $stats = [];

    public function mount(): void
    {
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->startDate = Carbon::today()->subDays(7)->format('Y-m-d');

        $this->loadReports();
        $this->loadStats();
    }

    public function loadReports(): void
    {
        $this->loading = true;

        $this->reports = DB::table('skyguardian_analyses')
            ->select([
                'id',
                'analysis_id',
                'analysis_time',
                'total_aircraft',
                'military_aircraft',
                'drones',
                'high_threat_aircraft',
                'overall_risk',
                'severity',
                'anomaly_score',
                'composite_score',
                'status',
                'created_at'
            ])
            ->where('analysis_time', '>=', $this->startDate)
            ->where('analysis_time', '<=', $this->endDate . ' 23:59:59')
            ->orderBy('analysis_time', 'desc')
            ->get();

        $this->loading = false;
    }

    public function loadStats(): void
    {
        $query = DB::table('skyguardian_analyses')
            ->where('analysis_time', '>=', $this->startDate)
            ->where('analysis_time', '<=', $this->endDate . ' 23:59:59');

        $this->stats = [
            'total_analyses' => $query->count(),
            'avg_aircraft' => $query->avg('total_aircraft') ?? 0,
            'total_military' => $query->sum('military_aircraft') ?? 0,
            'total_drones' => $query->sum('drones') ?? 0,
            'high_risk_count' => $query->where('overall_risk', 'HIGH')->count(),
            'avg_anomaly_score' => $query->avg('anomaly_score') ?? 0,
            'max_aircraft' => $query->max('total_aircraft') ?? 0,
            'peak_analysis' => $query->orderBy('total_aircraft', 'desc')->first(),
        ];
    }

    public function generateReport($type = null): void
    {
        $this->generatingReport = true;

        if ($type) {
            $this->activeReportType = $type;
        }

        $this->reportData = $this->generateReportData($this->activeReportType);
        $this->showReportModal = true;

        $this->generatingReport = false;
    }

    private function generateReportData($type): array
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate . ' 23:59:59');

        switch ($type) {
            case 'daily':
                return $this->generateDailyReport($start, $end);

            case 'military':
                return $this->generateMilitaryReport($start, $end);

            case 'threat':
                return $this->generateThreatReport($start, $end);

            case 'aircraft':
                return $this->generateAircraftReport($start, $end);

            case 'comprehensive':
                return $this->generateComprehensiveReport($start, $end);

            default:
                return $this->generateDailyReport($start, $end);
        }
    }

    private function generateDailyReport($start, $end): array
    {
        $dailyData = DB::table('skyguardian_analyses')
            ->select(
                DB::raw('DATE(analysis_time) as date'),
                DB::raw('COUNT(*) as analysis_count'),
                DB::raw('AVG(total_aircraft) as avg_aircraft'),
                DB::raw('AVG(military_aircraft) as avg_military'),
                DB::raw('AVG(anomaly_score) as avg_anomaly'),
                DB::raw('MAX(total_aircraft) as max_aircraft'),
                DB::raw('SUM(CASE WHEN overall_risk = "HIGH" THEN 1 ELSE 0 END) as high_risk_days')
            )
            ->whereBetween('analysis_time', [$start, $end])
            ->groupBy(DB::raw('DATE(analysis_time)'))
            ->orderBy('date', 'desc')
            ->get();

        $aircraftActivity = DB::table('skyguardian_positions as p')
            ->select(
                DB::raw('DATE(p.position_time) as date'),
                DB::raw('COUNT(DISTINCT p.hex) as unique_aircraft'),
                DB::raw('COUNT(*) as total_positions'),
                DB::raw('AVG(CASE WHEN a.is_military = 1 THEN 1 ELSE 0 END) * 100 as military_percentage')
            )
            ->leftJoin('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->whereBetween('p.position_time', [$start, $end])
            ->groupBy(DB::raw('DATE(p.position_time)'))
            ->orderBy('date', 'desc')
            ->get();

        $topAircraft = DB::table('skyguardian_positions as p')
            ->select(
                'a.hex',
                'a.callsign',
                'a.type',
                'a.country',
                'a.is_military',
                'a.threat_level',
                DB::raw('COUNT(*) as position_count'),
                DB::raw('MAX(p.position_time) as last_seen')
            )
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->whereBetween('p.position_time', [$start, $end])
            ->groupBy('a.hex', 'a.callsign', 'a.type', 'a.country', 'a.is_military', 'a.threat_level')
            ->orderBy('position_count', 'desc')
            ->limit(10)
            ->get();

        return [
            'type' => 'Daily Summary Report',
            'period' => $start->format('M d, Y') . ' to ' . $end->format('M d, Y'),
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'daily_summaries' => $dailyData,
            'aircraft_activity' => $aircraftActivity,
            'top_aircraft' => $topAircraft,
            'stats' => [
                'total_days' => $dailyData->count(),
                'total_analyses' => $dailyData->sum('analysis_count'),
                'avg_daily_aircraft' => round($dailyData->avg('avg_aircraft'), 1),
                'high_risk_days' => $dailyData->sum('high_risk_days'),
            ]
        ];
    }

    private function generateMilitaryReport($start, $end): array
    {
        $militaryData = DB::table('skyguardian_aircraft as a')
            ->select(
                'a.country',
                DB::raw('COUNT(DISTINCT a.hex) as total_aircraft'),
                DB::raw('SUM(CASE WHEN a.is_drone = 1 THEN 1 ELSE 0 END) as drones'),
                DB::raw('SUM(CASE WHEN a.is_nato = 1 THEN 1 ELSE 0 END) as nato'),
                DB::raw('AVG(a.threat_level) as avg_threat_level'),
                DB::raw('MAX(a.threat_level) as max_threat_level')
            )
            ->where('a.is_military', true)
            ->whereNotNull('a.country')
            ->groupBy('a.country')
            ->orderBy('total_aircraft', 'desc')
            ->get();

        $positions = DB::table('skyguardian_positions as p')
            ->select(
                DB::raw('DATE(p.position_time) as date'),
                DB::raw('COUNT(DISTINCT p.hex) as daily_military'),
                DB::raw('AVG(CASE WHEN p.in_estonia = 1 THEN 1 ELSE 0 END) * 100 as in_estonia_percentage'),
                DB::raw('SUM(CASE WHEN p.near_sensitive = 1 THEN 1 ELSE 0 END) as near_sensitive_count')
            )
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('a.is_military', true)
            ->whereBetween('p.position_time', [$start, $end])
            ->groupBy(DB::raw('DATE(p.position_time)'))
            ->orderBy('date', 'desc')
            ->get();

        $highThreat = DB::table('skyguardian_aircraft as a')
            ->select(
                'a.hex',
                'a.callsign',
                'a.type',
                'a.country',
                'a.threat_level',
                DB::raw('MAX(p.position_time) as last_seen'),
                DB::raw('COUNT(p.id) as position_count')
            )
            ->leftJoin('skyguardian_positions as p', 'a.hex', '=', 'p.hex')
            ->where('a.is_military', true)
            ->where('a.threat_level', '>=', 4)
            ->whereBetween('p.position_time', [$start, $end])
            ->groupBy('a.hex', 'a.callsign', 'a.type', 'a.country', 'a.threat_level')
            ->orderBy('a.threat_level', 'desc')
            ->limit(20)
            ->get();

        return [
            'type' => 'Military Activity Report',
            'period' => $start->format('M d, Y') . ' to ' . $end->format('M d, Y'),
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'countries' => $militaryData,
            'daily_activity' => $positions,
            'high_threat_aircraft' => $highThreat,
            'stats' => [
                'total_military_aircraft' => $militaryData->sum('total_aircraft'),
                'total_countries' => $militaryData->count(),
                'total_drones' => $militaryData->sum('drones'),
                'total_nato' => $militaryData->sum('nato'),
                'avg_threat_level' => round($militaryData->avg('avg_threat_level'), 2),
            ]
        ];
    }

    private function generateThreatReport($start, $end): array
    {
        $threatData = DB::table('skyguardian_analyses')
            ->select(
                DB::raw('DATE(analysis_time) as date'),
                DB::raw('AVG(anomaly_score) as avg_anomaly'),
                DB::raw('AVG(composite_score) as avg_composite'),
                DB::raw('SUM(high_threat_aircraft) as total_high_threat'),
                DB::raw('SUM(potential_threats) as total_potential'),
                DB::raw('MAX(severity) as max_severity'),
                DB::raw('SUM(CASE WHEN overall_risk = "HIGH" THEN 1 ELSE 0 END) as high_risk_count')
            )
            ->whereBetween('analysis_time', [$start, $end])
            ->groupBy(DB::raw('DATE(analysis_time)'))
            ->orderBy('date', 'desc')
            ->get();

        $aiAlerts = DB::table('skyguardian_ai_alerts')
            ->select(
                'trigger_level',
                'threat_level',
                'confidence',
                'ai_confidence_score',
                'situation',
                'primary_concern',
                'ai_timestamp'
            )
            ->whereBetween('ai_timestamp', [$start, $end])
            ->orderBy('ai_timestamp', 'desc')
            ->get();

        $threatDistribution = DB::table('skyguardian_aircraft')
            ->select(
                'threat_level',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN is_military = 1 THEN 1 ELSE 0 END) as military'),
                DB::raw('SUM(CASE WHEN is_drone = 1 THEN 1 ELSE 0 END) as drones')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('threat_level')
            ->orderBy('threat_level', 'desc')
            ->get();

        return [
            'type' => 'Threat Analysis Report',
            'period' => $start->format('M d, Y') . ' to ' . $end->format('M d, Y'),
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'daily_threats' => $threatData,
            'ai_alerts' => $aiAlerts,
            'threat_distribution' => $threatDistribution,
            'stats' => [
                'total_ai_alerts' => $aiAlerts->count(),
                'avg_anomaly_score' => round($threatData->avg('avg_anomaly'), 1),
                'total_high_threat' => $threatData->sum('total_high_threat'),
                'high_risk_days' => $threatData->sum('high_risk_count'),
                'max_severity' => $threatData->max('max_severity'),
            ]
        ];
    }

    private function generateAircraftReport($start, $end): array
    {
        $aircraftStats = DB::table('skyguardian_aircraft')
            ->select(
                DB::raw('COUNT(*) as total_aircraft'),
                DB::raw('SUM(CASE WHEN is_military = 1 THEN 1 ELSE 0 END) as military'),
                DB::raw('SUM(CASE WHEN is_drone = 1 THEN 1 ELSE 0 END) as drones'),
                DB::raw('SUM(CASE WHEN is_nato = 1 THEN 1 ELSE 0 END) as nato'),
                DB::raw('AVG(threat_level) as avg_threat_level')
            )
            ->whereBetween('created_at', [$start, $end])
            ->first();

        $countries = DB::table('skyguardian_aircraft')
            ->select(
                'country',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN is_military = 1 THEN 1 ELSE 0 END) as military'),
                DB::raw('SUM(CASE WHEN is_drone = 1 THEN 1 ELSE 0 END) as drones')
            )
            ->whereNotNull('country')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $types = DB::table('skyguardian_aircraft')
            ->select(
                'type',
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(threat_level) as avg_threat')
            )
            ->whereNotNull('type')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->limit(15)
            ->get();

        $activity = DB::table('skyguardian_positions as p')
            ->select(
                DB::raw('DATE(p.position_time) as date'),
                DB::raw('COUNT(DISTINCT p.hex) as unique_aircraft'),
                DB::raw('COUNT(*) as total_positions'),
                DB::raw('AVG(p.speed) as avg_speed'),
                DB::raw('AVG(p.altitude) as avg_altitude')
            )
            ->whereBetween('p.position_time', [$start, $end])
            ->groupBy(DB::raw('DATE(p.position_time)'))
            ->orderBy('date', 'desc')
            ->get();

        return [
            'type' => 'Aircraft Statistics Report',
            'period' => $start->format('M d, Y') . ' to ' . $end->format('M d, Y'),
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'aircraft_stats' => $aircraftStats,
            'top_countries' => $countries,
            'aircraft_types' => $types,
            'activity_timeline' => $activity,
            'stats' => [
                'total_aircraft' => $aircraftStats->total_aircraft ?? 0,
                'military_percentage' => $aircraftStats->total_aircraft > 0 ?
                    round(($aircraftStats->military / $aircraftStats->total_aircraft) * 100, 1) : 0,
                'unique_aircraft_tracked' => $activity->sum('unique_aircraft'),
                'total_positions' => $activity->sum('total_positions'),
                'countries_represented' => $countries->count(),
            ]
        ];
    }

    private function generateComprehensiveReport($start, $end): array
    {
        $daily = $this->generateDailyReport($start, $end);
        $military = $this->generateMilitaryReport($start, $end);
        $threat = $this->generateThreatReport($start, $end);
        $aircraft = $this->generateAircraftReport($start, $end);

        return [
            'type' => 'Comprehensive Security Report',
            'period' => $start->format('M d, Y') . ' to ' . $end->format('M d, Y'),
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'executive_summary' => $this->generateExecutiveSummary($daily, $military, $threat, $aircraft),
            'sections' => [
                'daily_activity' => $daily,
                'military_activity' => $military,
                'threat_analysis' => $threat,
                'aircraft_statistics' => $aircraft,
            ]
        ];
    }

    private function generateExecutiveSummary($daily, $military, $threat, $aircraft): string
    {
        $totalDays = $daily['stats']['total_days'] ?? 0;
        $avgAircraft = $daily['stats']['avg_daily_aircraft'] ?? 0;
        $highRiskDays = $daily['stats']['high_risk_days'] ?? 0;
        $totalMilitary = $military['stats']['total_military_aircraft'] ?? 0;
        $highThreatCount = $threat['stats']['total_high_threat'] ?? 0;
        $aiAlertsCount = $threat['stats']['total_ai_alerts'] ?? 0;

        $summary = "During the reporting period of {$totalDays} days, ";
        $summary .= "an average of {$avgAircraft} aircraft were tracked daily. ";

        if ($highRiskDays > 0) {
            $summary .= "{$highRiskDays} days were classified as HIGH risk. ";
        }

        if ($totalMilitary > 0) {
            $summary .= "A total of {$totalMilitary} military aircraft were identified, ";
        }

        if ($highThreatCount > 0) {
            $summary .= "with {$highThreatCount} high threat aircraft detected. ";
        }

        if ($aiAlertsCount > 0) {
            $summary .= "The AI system generated {$aiAlertsCount} threat alerts. ";
        }

        $summary .= "Overall airspace activity remained " . ($avgAircraft > 50 ? 'high' : ($avgAircraft > 25 ? 'moderate' : 'normal')) . ".";

        return $summary;
    }

    public function closeReport(): void
    {
        $this->showReportModal = false;
        $this->reportData = null;
    }

    public function applyDateRange(): void
    {
        $this->loadReports();
        $this->loadStats();
    }

    public function resetFilters(): void
    {
        $this->startDate = Carbon::today()->subDays(7)->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->reportFilterCountry = 'all';
        $this->reportFilterType = 'all';
        $this->reportFilterThreatLevel = 'all';
        $this->applyDateRange();
    }

    public function exportReport($format = 'pdf'): void
    {
        // TODO: Implement export functionality

        session()->flash('message', "Report export to {$format} format is coming soon!");

        $this->dispatch('report-exported');
    }

    public function getCountryOptions(): array
    {
        return DB::table('skyguardian_aircraft')
            ->whereNotNull('country')
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country')
            ->toArray();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.user.reports-page', [
            'countryOptions' => $this->getCountryOptions(),
        ])->layout('components.layouts.userApp');
    }
}
