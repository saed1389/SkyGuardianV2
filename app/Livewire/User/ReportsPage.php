<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $startDate;
    public $endDate;
    public $reportFilterCountry = 'all';
    public $activeReportType = 'daily';
    public $reportData = null;
    public $showReportModal = false;

    public $stats = [];

    public function mount(): void
    {
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->startDate = Carbon::today()->subDays(7)->format('Y-m-d');
        $this->refreshStats();
    }

    public function updatedReportFilterCountry(): void
    {
        $this->resetPage();
        $this->refreshStats();
    }

    public function applyDateRange(): void
    {
        $this->resetPage();
        $this->refreshStats();
    }

    public function resetFilters(): void
    {
        $this->startDate = Carbon::today()->subDays(7)->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
        $this->reportFilterCountry = 'all';
        $this->resetPage();
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        $start = $this->startDate;
        $end = $this->endDate . ' 23:59:59';

        if ($this->reportFilterCountry === 'all') {
            $query = DB::table('skyguardian_analyses')
                ->whereBetween('analysis_time', [$start, $end]);

            $this->stats = [
                'total_analyses' => $query->count(),
                'total_military' => $query->sum('military_aircraft'),
                'total_drones'   => $query->sum('drones'),
                'avg_anomaly'    => $query->avg('anomaly_score'),
                'high_risk'      => $query->where('overall_risk', 'HIGH')->count(),
                'max_aircraft'   => $query->max('total_aircraft'),
            ];
        }

        else {
            $aircraftQuery = DB::table('skyguardian_aircraft')
                ->where('country', $this->reportFilterCountry)
                ->whereBetween('last_seen', [$start, $end]);

            $totalCount = $aircraftQuery->count();

            $this->stats = [
                'total_analyses' => $aircraftQuery->count(),
                'total_military' => (clone $aircraftQuery)->where('is_military', true)->count(),
                'total_drones'   => (clone $aircraftQuery)->where('is_drone', true)->count(),
                'avg_anomaly'    => (clone $aircraftQuery)->avg('threat_level') * 10,
                'high_risk'      => (clone $aircraftQuery)->where('threat_level', '>=', 4)->count(),
                'max_aircraft'   => $totalCount,
            ];
        }
    }

    public function generateReport($type): void
    {
        $this->activeReportType = $type;
        $this->showReportModal = true;
        $this->reportData = null;

        $this->reportData = $this->compileReportData($type);
    }

    private function compileReportData($type): array
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate . ' 23:59:59');
        $country = $this->reportFilterCountry;

        $base = [
            'type' => ucfirst($type) . ' Report',
            'period' => $start->format('M d') . ' - ' . $end->format('M d, Y'),
            'generated_at' => now()->format('Y-m-d H:i'),
            'filter_country' => $country === 'all' ? 'Global Scope' : $country,
        ];

        $data = match ($type) {
            'military' => $this->getMilitaryData($start, $end, $country),
            'threat' => $this->getThreatData($start, $end, $country),
            'aircraft' => $this->getAircraftData($start, $end, $country),
            'comprehensive' => $this->getComprehensiveData($start, $end, $country),
            default => $this->getDailyData($start, $end, $country),
        };

        return array_merge($base, $data);
    }

    private function getDailyData($start, $end, $country): array
    {
        if ($country !== 'all') {
            $summaries = DB::table('skyguardian_aircraft')
                ->where('country', $country)
                ->whereBetween('last_seen', [$start, $end])
                ->selectRaw('DATE(last_seen) as date, COUNT(*) as count, AVG(threat_level) as avg_risk')
                ->groupByRaw('DATE(last_seen)')
                ->orderByDesc('date')
                ->get()
                ->map(function($item) {
                    return (object)[
                        'date' => $item->date,
                        'count' => $item->count,
                        'avg_ac' => $item->count,
                        'max_risk' => $item->avg_risk > 3 ? 'HIGH' : 'LOW'
                    ];
                });
        } else {
            $summaries = DB::table('skyguardian_analyses')
                ->whereBetween('analysis_time', [$start, $end])
                ->selectRaw('DATE(analysis_time) as date, COUNT(*) as count, AVG(total_aircraft) as avg_ac, MAX(overall_risk) as max_risk')
                ->groupByRaw('DATE(analysis_time)')
                ->orderByDesc('date')
                ->get();
        }

        $aircraftQuery = DB::table('skyguardian_aircraft')
            ->whereBetween('last_seen', [$start, $end]);

        if ($country !== 'all') {
            $aircraftQuery->where('country', $country);
        }

        $topAircraft = $aircraftQuery->orderBy('threat_level', 'desc')
            ->limit(10)
            ->get();

        return ['daily_summaries' => $summaries, 'top_aircraft' => $topAircraft];
    }

    private function getMilitaryData($start, $end, $country): array
    {
        $query = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->whereBetween('last_seen', [$start, $end]);

        if ($country !== 'all') {
            $query->where('country', $country);
        }

        $byCountry = (clone $query)->selectRaw('country, COUNT(*) as count, SUM(is_drone) as drones')
            ->groupBy('country')
            ->orderByDesc('count')
            ->get();

        $highThreat = (clone $query)->where('threat_level', '>=', 3)
            ->orderByDesc('threat_level')
            ->limit(15)
            ->get();

        return ['countries' => $byCountry, 'high_threat' => $highThreat];
    }

    private function getThreatData($start, $end, $country): array
    {
        $alerts = DB::table('skyguardian_ai_alerts')
            ->whereBetween('ai_timestamp', [$start, $end])
            ->orderByDesc('ai_timestamp')
            ->limit(50)
            ->get();

        return ['ai_alerts' => $alerts];
    }

    private function getAircraftData($start, $end, $country): array
    {
        $query = DB::table('skyguardian_aircraft')
            ->whereBetween('last_seen', [$start, $end]);

        if ($country !== 'all') {
            $query->where('country', $country);
        }

        $types = (clone $query)->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return ['top_types' => $types, 'total_count' => $query->count()];
    }

    private function getComprehensiveData($start, $end, $country): array
    {
        return [
            'daily' => $this->getDailyData($start, $end, $country),
            'military' => $this->getMilitaryData($start, $end, $country),
            'aircraft' => $this->getAircraftData($start, $end, $country)
        ];
    }

    public function exportReport($format)
    {
        if (!$this->reportData) return;
        $fileName = 'Report_' . $this->activeReportType . '_' . now()->format('Ymd_His');

        try {
            if ($format === 'excel') {
                return Excel::download(new ReportExport($this->reportData, $this->activeReportType), $fileName . '.xlsx');
            }
            elseif ($format === 'csv') {
                return Excel::download(new ReportExport($this->reportData, $this->activeReportType), $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }
            elseif ($format === 'pdf') {
                $pdf = Pdf::loadView('livewire.user.reports.export_template', [
                    'reportData' => $this->reportData,
                    'activeReportType' => $this->activeReportType
                ]);

                return response()->streamDownload(function() use ($pdf) {
                    echo $pdf->output();
                }, $fileName . '.pdf');
            }
        } catch (\Exception $e) {
            $this->dispatch('alert', type: 'error', message: 'Export failed: ' . $e->getMessage());
        }
    }

    public function closeReport(): void
    {
        $this->showReportModal = false; $this->reportData = null;
    }

    public function getCountryOptions(): \Illuminate\Support\Collection
    {
        return DB::table('skyguardian_aircraft')->whereNotNull('country')->distinct()->orderBy('country')->pluck('country');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        if ($this->reportFilterCountry === 'all') {
            $reportsQuery = DB::table('skyguardian_analyses')
                ->whereBetween('analysis_time', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->orderBy('analysis_time', 'desc');
        } else {
            $reportsQuery = DB::table('skyguardian_aircraft')
                ->where('country', $this->reportFilterCountry)
                ->whereBetween('last_seen', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->orderBy('last_seen', 'desc');
        }

        return view('livewire.user.reports-page', [
            'reports' => $reportsQuery->paginate(10),
            'countryOptions' => $this->getCountryOptions(),
        ])->layout('components.layouts.userApp');
    }
}
