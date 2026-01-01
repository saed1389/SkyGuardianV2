<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalysisHistoryPage extends Component
{
    public $analyses = [];
    public $selectedAnalysis = null;
    public $showDetailsModal = false;
    public $loading = false;
    public $stats = [];
    public $timeRange = '7days'; // 7days, 30days, 90days, all
    public $filterStatus = 'all';
    public $filterRisk = 'all';
    public $search = '';

    // Chart data
    public $chartData = [];
    public $riskDistribution = [];
    public $aircraftTrends = [];

    public function mount()
    {
        $this->loadAnalyses();
        $this->loadStats();
        $this->loadChartData();
    }

    public function loadAnalyses()
    {
        $this->loading = true;

        $query = DB::table('skyguardian_analyses')
            ->orderBy('analysis_time', 'desc');

        // Apply time range filter
        if ($this->timeRange !== 'all') {
            $days = match($this->timeRange) {
                '7days' => 7,
                '30days' => 30,
                '90days' => 90,
                default => 7
            };

            $startDate = Carbon::now()->subDays($days);
            $query->where('analysis_time', '>=', $startDate);
        }

        // Apply status filter
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Apply risk filter
        if ($this->filterRisk !== 'all') {
            $query->where('overall_risk', $this->filterRisk);
        }

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('analysis_id', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('weather_notes', 'like', '%' . $this->search . '%');
            });
        }

        $this->analyses = $query->limit(100)->get();
        $this->loading = false;
    }

    public function loadStats()
    {
        // Calculate time range for stats
        $days = match($this->timeRange) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            default => 9999 // all time
        };

        $startDate = Carbon::now()->subDays($days);

        $statsQuery = DB::table('skyguardian_analyses')
            ->where('analysis_time', '>=', $startDate);

        $this->stats = [
            'total_analyses' => $statsQuery->count(),
            'avg_aircraft' => $statsQuery->avg('total_aircraft') ?? 0,
            'avg_military' => $statsQuery->avg('military_aircraft') ?? 0,
            'avg_anomaly_score' => $statsQuery->avg('anomaly_score') ?? 0,
            'high_risk_count' => $statsQuery->where('overall_risk', 'HIGH')->count(),
            'critical_count' => $statsQuery->where('severity', '>=', 4)->count(),
            'avg_confidence' => $statsQuery->avg('confidence') ?? 0,
            'total_drones' => $statsQuery->sum('drones') ?? 0,
            'peak_analysis' => $statsQuery->orderBy('total_aircraft', 'desc')->first(),
            'latest_analysis' => $statsQuery->orderBy('analysis_time', 'desc')->first(),
        ];
    }

    public function loadChartData()
    {
        // Time range for charts
        $days = match($this->timeRange) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            default => 30
        };

        $startDate = Carbon::now()->subDays($days);

        // Daily analysis counts
        $dailyData = DB::table('skyguardian_analyses')
            ->select(
                DB::raw('DATE(analysis_time) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(total_aircraft) as avg_aircraft'),
                DB::raw('AVG(anomaly_score) as avg_anomaly')
            )
            ->where('analysis_time', '>=', $startDate)
            ->groupBy(DB::raw('DATE(analysis_time)'))
            ->orderBy('date')
            ->get();

        $this->chartData = [
            'dates' => $dailyData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'analysis_counts' => $dailyData->pluck('count')->toArray(),
            'avg_aircraft' => $dailyData->pluck('avg_aircraft')->map(fn($val) => round($val, 1))->toArray(),
            'avg_anomaly' => $dailyData->pluck('avg_anomaly')->map(fn($val) => round($val, 1))->toArray(),
        ];

        // Risk level distribution
        $this->riskDistribution = DB::table('skyguardian_analyses')
            ->select('overall_risk', DB::raw('COUNT(*) as count'))
            ->where('analysis_time', '>=', $startDate)
            ->groupBy('overall_risk')
            ->get()
            ->pluck('count', 'overall_risk')
            ->toArray();

        // Aircraft type trends
        $this->aircraftTrends = DB::table('skyguardian_analyses')
            ->select(
                DB::raw('AVG(military_aircraft) as avg_military'),
                DB::raw('AVG(civil_aircraft) as avg_civil'),
                DB::raw('AVG(drones) as avg_drones'),
                DB::raw('AVG(nato_aircraft) as avg_nato')
            )
            ->where('analysis_time', '>=', $startDate)
            ->first();
    }

    public function viewDetails($analysisId)
    {
        $this->selectedAnalysis = DB::table('skyguardian_analyses')->find($analysisId);
        $this->showDetailsModal = true;
    }

    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedAnalysis = null;
    }

    public function applyFilters()
    {
        $this->loadAnalyses();
        $this->loadStats();
        $this->loadChartData();
    }

    public function resetFilters()
    {
        $this->timeRange = '7days';
        $this->filterStatus = 'all';
        $this->filterRisk = 'all';
        $this->search = '';
        $this->applyFilters();
    }

    public function exportAnalysis($analysisId)
    {
        // TODO: Implement export functionality
        session()->flash('message', 'Export feature coming soon!');
    }

    public function refreshData()
    {
        $this->loadAnalyses();
        $this->loadStats();
        $this->loadChartData();
        $this->dispatch('charts-updated');
    }

    public function getStatusOptions()
    {
        return DB::table('skyguardian_analyses')
            ->select('status')
            ->distinct()
            ->pluck('status')
            ->toArray();
    }

    public function getRiskOptions()
    {
        return DB::table('skyguardian_analyses')
            ->select('overall_risk')
            ->distinct()
            ->pluck('overall_risk')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.user.analysis-history-page', [
            'statusOptions' => $this->getStatusOptions(),
            'riskOptions' => $this->getRiskOptions(),
        ])->layout('components.layouts.userApp');
    }
}
