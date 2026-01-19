<?php

namespace App\Livewire\User;

use App\Exports\AnalysesExport;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AnalysisHistoryPage extends Component
{
    public $analyses = [];
    public $selectedAnalysis = null;
    public $showDetailsModal = false;
    public $loading = false;
    public $stats = [];
    public $timeRange = '7days';
    public $filterStatus = 'all';
    public $filterRisk = 'all';
    public $search = '';
    public $exporting = false;
    public $currentLocale;
    public $chartData = [];
    public $riskDistribution = [];
    public $aircraftTrends = [];

    public function mount(): void
    {
        $this->currentLocale = Session::get('user_locale', App::getLocale());
        Session::put('user_locale', $this->currentLocale);

        $this->loadAnalyses();
        $this->loadStats();
        $this->loadChartData();
    }

    public function loadAnalyses(): void
    {
        $this->loading = true;

        $query = DB::table('skyguardian_analyses')
            ->orderBy('analysis_time', 'desc');

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

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterRisk !== 'all') {
            $query->where('overall_risk', $this->filterRisk);
        }

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

    public function loadStats(): void
    {
        $days = match($this->timeRange) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            default => 9999
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

    public function loadChartData(): void
    {
        $days = match($this->timeRange) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            default => 30
        };

        $startDate = Carbon::now()->subDays($days);

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

        $this->riskDistribution = DB::table('skyguardian_analyses')
            ->select('overall_risk', DB::raw('COUNT(*) as count'))
            ->where('analysis_time', '>=', $startDate)
            ->groupBy('overall_risk')
            ->get()
            ->pluck('count', 'overall_risk')
            ->toArray();

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

    public function viewDetails($analysisId): void
    {
        $this->selectedAnalysis = DB::table('skyguardian_analyses')->find($analysisId);
        $this->showDetailsModal = true;
    }

    public function closeModal(): void
    {
        $this->showDetailsModal = false;
        $this->selectedAnalysis = null;
    }

    public function applyFilters(): void
    {
        $this->loadAnalyses();
        $this->loadStats();
        $this->loadChartData();
        $this->dispatch('charts-updated');
    }

    public function resetFilters(): void
    {
        $this->timeRange = '7days';
        $this->filterStatus = 'all';
        $this->filterRisk = 'all';
        $this->search = '';
        $this->applyFilters();
    }

    public function exportAnalysis($analysisId = null)
    {
        $this->exporting = true;

        try {
            if ($analysisId) {
                $analysis = DB::table('skyguardian_analyses')->find($analysisId);
                if (!$analysis) {
                    session()->flash('export_error', 'Analysis not found.');
                    $this->exporting = false;
                    return;
                }

                $query = DB::table('skyguardian_analyses')->where('id', $analysisId);

                $filename = 'analysis-report-' . ($analysis->analysis_id ?? $analysisId) . '-' . date('Y-m-d-H-i-s') . '.xlsx';

                session()->flash('export_message', "Exporting analysis {$analysis->analysis_id}...");

                $export = new AnalysesExport($query, null, [], 'single');

                $this->exporting = false;
                return Excel::download($export, $filename);

            } else {
                $query = $this->buildExportQuery();
                $filters = [
                    'time_range' => $this->timeRange,
                    'status' => $this->filterStatus,
                    'risk' => $this->filterRisk,
                    'search' => $this->search,
                ];

                $rangeText = match($this->timeRange) {
                    '7days' => '7days',
                    '30days' => '30days',
                    '90days' => '90days',
                    default => 'all-time'
                };

                $filename = 'analysis-history-' . $rangeText . '-' . date('Y-m-d-H-i-s') . '.xlsx';

                $recordCount = $query->count();
                session()->flash('export_message', "Exporting {$recordCount} analysis records...");

                $export = new AnalysesExport($query, $this->timeRange, $filters, 'filtered');

                $this->exporting = false;
                return Excel::download($export, $filename);
            }
        } catch (\Exception $e) {
            $this->exporting = false;
            logger()->error('Export failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            session()->flash('export_error', 'Export failed: ' . $e->getMessage());
            return null;
        }
    }

    private function buildExportQuery(): \Illuminate\Database\Query\Builder
    {
        $query = DB::table('skyguardian_analyses');

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

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterRisk !== 'all') {
            $query->where('overall_risk', $this->filterRisk);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('analysis_id', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('weather_notes', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function exportAll()
    {
        return $this->exportAnalysis();
    }

    public function refreshData(): void
    {
        $this->loadAnalyses();
        $this->loadStats();
        $this->loadChartData();
        $this->dispatch('charts-updated');
    }

    public function getStatusOptions(): array
    {
        return DB::table('skyguardian_analyses')
            ->select('status')
            ->distinct()
            ->pluck('status')
            ->toArray();
    }

    public function getRiskOptions(): array
    {
        return DB::table('skyguardian_analyses')
            ->select('overall_risk')
            ->distinct()
            ->pluck('overall_risk')
            ->toArray();
    }

    public function updated($property): void
    {
        if ($property === 'currentLocale' && $this->currentLocale) {
            Session::put('user_locale', $this->currentLocale);
        }
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.user.analysis-history-page', [
            'statusOptions' => $this->getStatusOptions(),
            'riskOptions' => $this->getRiskOptions(),
        ])->layout('components.layouts.userApp');
    }
}
