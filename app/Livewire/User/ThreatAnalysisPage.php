<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SkyguardianAiAlerts;
use App\Exports\AlertsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ThreatAnalysisPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $latestAlert;
    public $stats = [];
    public $loading = false;
    public $selectedAlertId = null;
    public $showDetailsModal = false;
    public $showExportModal = false;
    public $exportType = 'excel';
    public $exportRange = 'current';
    public $selectedAlerts = [];
    public $selectAll = false;
    public $bulkAction = '';

    // Language properties
    public $currentLocale = 'en';

    // Filters
    public $filterLevel = 'all';
    public $filterDate = '';
    public $search = '';
    public $perPage = 15;
    public $sortField = 'ai_timestamp';
    public $sortDirection = 'desc';

    // Stats refresh timer
    public $autoRefresh = false;
    public $refreshInterval = 60;

    // Cache keys
    protected $statsCacheKey = 'threat_analysis_stats_v2';

    protected $queryString = [
        'filterLevel' => ['except' => 'all'],
        'filterDate' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 15],
        'sortField' => ['except' => 'ai_timestamp'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Set current locale from session
        $this->currentLocale = Session::get('locale', 'en');
        App::setLocale($this->currentLocale);

        $this->loadStats();
        $this->loadLatestAlert();
    }

    public function loadLatestAlert()
    {
        $this->latestAlert = cache()->remember($this->statsCacheKey . '_latest', 60, function() {
            $alert = SkyguardianAiAlerts::latest('ai_timestamp')->first();
            return $this->applyTranslation($alert);
        });
    }

    public function loadStats()
    {
        $this->stats = cache()->remember($this->statsCacheKey, 300, function() {
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            $lastWeek = Carbon::today()->subWeek();

            $statsData = SkyguardianAiAlerts::select([
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN DATE(ai_timestamp) = CURDATE() THEN 1 ELSE 0 END) as today_count'),
                DB::raw('AVG(ai_confidence_score) * 100 as avg_confidence'),
                DB::raw('COUNT(CASE WHEN threat_level = "HIGH" OR trigger_level = "HIGH" THEN 1 END) as high_threat'),
            ])->first();

            $levelDistribution = SkyguardianAiAlerts::select('threat_level', DB::raw('count(*) as count'))
                ->whereNotNull('threat_level')
                ->groupBy('threat_level')
                ->get()
                ->pluck('count', 'threat_level')
                ->toArray();

            $trends = SkyguardianAiAlerts::select([
                DB::raw('DATE(ai_timestamp) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(ai_confidence_score) * 100 as avg_confidence')
            ])
                ->where('ai_timestamp', '>=', $lastWeek)
                ->groupBy(DB::raw('DATE(ai_timestamp)'))
                ->orderBy('date')
                ->get();

            return [
                'total' => $statsData->total ?? 0,
                'today' => $statsData->today_count ?? 0,
                'high_threat' => $statsData->high_threat ?? 0,
                'avg_confidence' => round($statsData->avg_confidence ?? 0, 1),
                'level_distribution' => $levelDistribution,
                'trends' => $trends,
                'yesterday_count' => SkyguardianAiAlerts::whereDate('ai_timestamp', $yesterday)->count(),
                'week_count' => SkyguardianAiAlerts::where('ai_timestamp', '>=', $lastWeek)->count(),
            ];
        });
    }

    // Apply translation to a single alert
    private function applyTranslation($alert)
    {
        if (!$alert || $this->currentLocale === 'en') {
            return $alert;
        }

        // Check if we have a translation in the database
        $translationColumn = 'analysis_' . $this->currentLocale;

        if (isset($alert->$translationColumn) && !empty($alert->$translationColumn)) {
            $translation = json_decode($alert->$translationColumn, true);

            if ($translation) {
                // Clone the alert to avoid modifying the original
                $translatedAlert = clone $alert;

                // Apply translations if available
                foreach ($translation as $key => $value) {
                    if (property_exists($translatedAlert, $key) && !empty($value)) {
                        $translatedAlert->$key = $value;
                    }
                }

                return $translatedAlert;
            }
        }

        return $alert;
    }

    // Get alerts with translations applied
    public function getAlertsProperty()
    {
        $query = SkyguardianAiAlerts::query();

        if ($this->filterLevel !== 'all') {
            $query->where('trigger_level', $this->filterLevel);
        }

        if ($this->filterDate) {
            $query->whereDate('ai_timestamp', Carbon::parse($this->filterDate));
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('situation', 'like', '%' . $this->search . '%')
                    ->orWhere('primary_concern', 'like', '%' . $this->search . '%')
                    ->orWhere('likely_scenario', 'like', '%' . $this->search . '%')
                    ->orWhere('analysis_id', 'like', '%' . $this->search . '%');
            });
        }

        if (in_array($this->sortField, ['ai_timestamp', 'threat_level', 'ai_confidence_score'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('ai_timestamp', 'desc');
        }

        $alerts = $query->paginate($this->perPage);

        // Apply translations to each alert
        $alerts->getCollection()->transform(function ($alert) {
            return $this->applyTranslation($alert);
        });

        return $alerts;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }

        $this->resetPage();
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

        $alert = SkyguardianAiAlerts::find($this->selectedAlertId);
        return $this->applyTranslation($alert);
    }

    public function changeLanguage($locale)
    {
        if (in_array($locale, ['en', 'tr', 'et'])) {
            $this->currentLocale = $locale;
            Session::put('locale', $locale);
            App::setLocale($locale);

            // Refresh the view
            $this->refreshData();

            // Dispatch event for JavaScript to handle language change
            $this->dispatch('language-changed', locale: $locale);
        }
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filterLevel = 'all';
        $this->filterDate = '';
        $this->search = '';
        $this->perPage = 15;
        $this->sortField = 'ai_timestamp';
        $this->sortDirection = 'desc';
        $this->resetPage();
        $this->selectedAlerts = [];
        $this->selectAll = false;
    }

    public function refreshData()
    {
        cache()->forget($this->statsCacheKey);
        cache()->forget($this->statsCacheKey . '_latest');

        $this->loadStats();
        $this->loadLatestAlert();

        $this->dispatch('alert-refreshed');
    }

    public function toggleAutoRefresh()
    {
        $this->autoRefresh = !$this->autoRefresh;

        if ($this->autoRefresh) {
            $this->dispatch('start-auto-refresh', interval: $this->refreshInterval);
        } else {
            $this->dispatch('stop-auto-refresh');
        }
    }

    public function updatedPage()
    {
        $this->selectedAlerts = [];
        $this->selectAll = false;
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedAlerts = $this->alerts->pluck('id')->toArray();
        } else {
            $this->selectedAlerts = [];
        }
    }

    public function updatedSelectedAlerts()
    {
        $this->selectAll = count($this->selectedAlerts) === $this->alerts->count();
    }

    public function applyBulkAction()
    {
        if (empty($this->selectedAlerts) || !$this->bulkAction) {
            return;
        }

        switch ($this->bulkAction) {
            case 'export':
                return $this->exportSelected();
            case 'mark_high':
                SkyguardianAiAlerts::whereIn('id', $this->selectedAlerts)->update(['threat_level' => 'HIGH']);
                break;
            case 'mark_medium':
                SkyguardianAiAlerts::whereIn('id', $this->selectedAlerts)->update(['threat_level' => 'MEDIUM']);
                break;
            case 'mark_reviewed':
                SkyguardianAiAlerts::whereIn('id', $this->selectedAlerts)->update(['reviewed_at' => now()]);
                break;
        }

        $this->refreshData();
        $this->selectedAlerts = [];
        $this->bulkAction = '';
        $this->selectAll = false;
    }

    public function showExportModal()
    {
        $this->showExportModal = true;
    }

    public function exportData()
    {
        $this->validate([
            'exportType' => 'required|in:excel,csv,pdf,json',
            'exportRange' => 'required|in:current,all,today,last7days,last30days,selected',
        ]);

        $query = $this->getExportQuery();
        $filename = 'threat-analysis-' . now()->format('Y-m-d_H-i-s');

        switch ($this->exportType) {
            case 'excel':
                return Excel::download(new AlertsExport($query), $filename . '.xlsx');

            case 'csv':
                return Excel::download(new AlertsExport($query), $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);

            case 'pdf':
                $alerts = $query->get();
                $stats = $this->stats;
                $pdf = Pdf::loadView('exports.alerts-pdf', compact('alerts', 'stats'))
                    ->setPaper('a4', 'landscape')
                    ->setOption('defaultFont', 'Arial');
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, $filename . '.pdf');

            case 'json':
                $alerts = $query->get();
                return response()->streamDownload(function () use ($alerts) {
                    echo json_encode($alerts, JSON_PRETTY_PRINT);
                }, $filename . '.json');
        }

        $this->showExportModal = false;
    }

    public function exportSelected()
    {
        if (empty($this->selectedAlerts)) {
            return;
        }

        $query = SkyguardianAiAlerts::whereIn('id', $this->selectedAlerts);
        $filename = 'selected-alerts-' . now()->format('Y-m-d_H-i-s');

        return Excel::download(new AlertsExport($query), $filename . '.xlsx');
    }

    public function exportSingleAlert($alertId)
    {
        $alert = SkyguardianAiAlerts::findOrFail($alertId);
        $filename = 'alert-' . ($alert->analysis_id ?? $alert->id) . '-' . now()->format('Y-m-d');

        $pdf = Pdf::loadView('exports.alert-details-pdf', compact('alert'))
            ->setPaper('a4')
            ->setOption('defaultFont', 'Arial');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename . '.pdf');
    }

    protected function getExportQuery()
    {
        $query = SkyguardianAiAlerts::query()->orderBy('ai_timestamp', 'desc');

        if ($this->exportRange === 'selected') {
            return $query->whereIn('id', $this->selectedAlerts);
        }

        if ($this->exportRange !== 'all') {
            switch ($this->exportRange) {
                case 'current':
                    if ($this->filterLevel !== 'all') {
                        $query->where('trigger_level', $this->filterLevel);
                    }
                    if ($this->filterDate) {
                        $query->whereDate('ai_timestamp', Carbon::parse($this->filterDate));
                    }
                    if ($this->search) {
                        $query->where(function($q) {
                            $q->where('situation', 'like', '%' . $this->search . '%')
                                ->orWhere('primary_concern', 'like', '%' . $this->search . '%')
                                ->orWhere('likely_scenario', 'like', '%' . $this->search . '%')
                                ->orWhere('analysis_id', 'like', '%' . $this->search . '%');
                        });
                    }
                    break;

                case 'today':
                    $query->whereDate('ai_timestamp', Carbon::today());
                    break;

                case 'last7days':
                    $query->where('ai_timestamp', '>=', Carbon::now()->subDays(7));
                    break;

                case 'last30days':
                    $query->where('ai_timestamp', '>=', Carbon::now()->subDays(30));
                    break;
            }
        }

        return $query;
    }

    public function render()
    {
        $this->loading = true;
        $alerts = $this->getAlertsProperty();
        $this->loading = false;

        return view('livewire.user.threat-analysis-page', [
            'alerts' => $alerts,
            'alertLevels' => SkyguardianAiAlerts::select('trigger_level')
                ->distinct()
                ->whereNotNull('trigger_level')
                ->orderBy('trigger_level')
                ->pluck('trigger_level')
                ->toArray(),
            'alertDetails' => $this->getAlertDetailsProperty(),
        ])->layout('components.layouts.userApp');
    }
}
