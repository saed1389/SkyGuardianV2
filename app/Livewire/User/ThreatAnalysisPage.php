<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThreatAnalysisPage extends Component
{
    public $alerts = [];
    public $latestAlert = null;
    public $stats = [];
    public $loading = false;
    public $selectedAlertId = null;
    public $showDetailsModal = false;

    // Filters
    public $filterLevel = 'all';
    public $filterDate = '';
    public $search = '';

    public function mount()
    {
        $this->loadAlerts();
        $this->loadStats();
    }

    public function loadAlerts()
    {
        $this->loading = true;

        $query = DB::table('skyguardian_ai_alerts')
            ->orderBy('ai_timestamp', 'desc');

        // Apply filters
        if ($this->filterLevel !== 'all') {
            $query->where('trigger_level', $this->filterLevel);
        }

        if ($this->filterDate) {
            $query->whereDate('ai_timestamp', $this->filterDate);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('situation', 'like', '%' . $this->search . '%')
                    ->orWhere('primary_concern', 'like', '%' . $this->search . '%')
                    ->orWhere('likely_scenario', 'like', '%' . $this->search . '%');
            });
        }

        $this->alerts = $query->limit(50)->get();

        // Get latest alert for summary
        $this->latestAlert = DB::table('skyguardian_ai_alerts')
            ->orderBy('ai_timestamp', 'desc')
            ->first();

        $this->loading = false;
    }

    public function loadStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastWeek = Carbon::today()->subWeek();

        // Total alerts
        $total = DB::table('skyguardian_ai_alerts')->count();

        // Today's alerts
        $todayCount = DB::table('skyguardian_ai_alerts')
            ->whereDate('ai_timestamp', $today)
            ->count();

        // High threat alerts
        $highThreat = DB::table('skyguardian_ai_alerts')
            ->where('threat_level', 'HIGH')
            ->orWhere('trigger_level', 'HIGH')
            ->count();

        // Average confidence
        $avgConfidence = DB::table('skyguardian_ai_alerts')
            ->avg('ai_confidence_score');

        // Threat level distribution
        $levelDistribution = DB::table('skyguardian_ai_alerts')
            ->select('threat_level', DB::raw('count(*) as count'))
            ->whereNotNull('threat_level')
            ->groupBy('threat_level')
            ->get()
            ->pluck('count', 'threat_level')
            ->toArray();

        // Recent trends (last 7 days)
        $trends = DB::table('skyguardian_ai_alerts')
            ->select(DB::raw('DATE(ai_timestamp) as date'), DB::raw('count(*) as count'))
            ->where('ai_timestamp', '>=', $lastWeek)
            ->groupBy(DB::raw('DATE(ai_timestamp)'))
            ->orderBy('date', 'desc')
            ->get();

        $this->stats = [
            'total' => $total,
            'today' => $todayCount,
            'high_threat' => $highThreat,
            'avg_confidence' => round($avgConfidence * 100, 1),
            'level_distribution' => $levelDistribution,
            'trends' => $trends,
        ];
    }

    public function viewDetails($alertId)
    {
        $this->selectedAlertId = $alertId;
        $this->showDetailsModal = true;
    }

    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedAlertId = null;
    }

    public function getAlertDetailsProperty()
    {
        if (!$this->selectedAlertId) {
            return null;
        }

        return DB::table('skyguardian_ai_alerts')
            ->find($this->selectedAlertId);
    }

    public function applyFilters()
    {
        $this->loadAlerts();
    }

    public function resetFilters()
    {
        $this->filterLevel = 'all';
        $this->filterDate = '';
        $this->search = '';
        $this->loadAlerts();
    }

    public function refreshData()
    {
        $this->loadAlerts();
        $this->loadStats();
        $this->dispatch('alert-refreshed');
    }

    public function render()
    {
        $alertLevels = DB::table('skyguardian_ai_alerts')
            ->select('trigger_level')
            ->distinct()
            ->pluck('trigger_level')
            ->toArray();

        return view('livewire.user.threat-analysis-page', [
            'alertLevels' => $alertLevels,
            'alertDetails' => $this->getAlertDetailsProperty(),
        ])->layout('components.layouts.userApp');
    }
}
