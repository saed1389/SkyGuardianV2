<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div class="page-title-left">
                                <h4 class="mb-1 text-dark">
                                    <i class="fas fa-history me-2 text-primary"></i>
                                    <span data-key="t-analysis-history">Analysis History</span>
                                </h4>
                                <p class="text-muted mb-0" data-key="t-historical-analysis-data-and-trends">Historical analysis data and trends</p>
                            </div>
                            <div class="page-title-right">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-primary">
                                        <i class="fas fa-database me-1"></i>
                                        {{ $stats['total_analyses'] ?? 0 }} <span data-key="t-analyses">Analyses</span>
                                    </span>
                                    <button wire:click="exportAll" wire:loading.attr="disabled" class="btn btn-sm btn-success" title="Export All Filtered Data" data-key-title="t-export-all-data">
                                        <i class="fas fa-file-excel" wire:loading.class="fa-spin"></i>
                                        <span data-key="t-export-all">Export All</span>
                                    </button>
                                    <button wire:click="refreshData" wire:loading.attr="disabled" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-redo" wire:loading.class="fa-spin"></i>
                                        <span data-key="t-refresh">Refresh</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (session()->has('export_message'))
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('export_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif
                @if (session()->has('export_error'))
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('export_error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-hover border-start border-3 border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-total-analyses">Total Analyses</h5>
                                        <h3 class="mb-0">{{ $stats['total_analyses'] ?? 0 }}</h3>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-primary-subtle text-primary me-1">
                                                <span data-key="t-avg">Avg</span>: {{ round($stats['avg_aircraft'] ?? 0) }} <span data-key="t-aircraft">aircraft</span>
                                            </span>
                                            <span class="text-success">
                                                {{ round(($stats['avg_confidence'] ?? 0) * 100) }}% <span data-key="t-confidence">confidence</span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-2 text-primary">
                                            <i class="fas fa-chart-line text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-hover border-start border-3 border-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-military-aircraft">Military Aircraft</h5>
                                        <h3 class="mb-0">{{ round($stats['avg_military'] ?? 0) }}</h3>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ min(100, ($stats['avg_military'] ?? 0) / max(1, ($stats['avg_aircraft'] ?? 1)) * 100) }}%"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" data-key="t-of-active-aircraft">
                                            {{ round(($stats['avg_military'] ?? 0) / max(1, ($stats['avg_aircraft'] ?? 1)) * 100) }}% of active aircraft
                                        </small>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded fs-2 text-danger">
                                            <i class="fas fa-fighter-jet"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-hover border-start border-3 border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-high-risk-analyses">High Risk Analyses</h5>
                                        <h3 class="mb-0">{{ $stats['high_risk_count'] ?? 0 }}</h3>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-warning-subtle text-warning me-1">
                                                {{ $stats['critical_count'] ?? 0 }} <span data-key="t-critical">critical</span>
                                            </span>
                                            <span class="text-danger">
                                                {{ round(($stats['high_risk_count'] ?? 0) / max(1, ($stats['total_analyses'] ?? 1)) * 100) }}%
                                            </span>
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-2 text-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-hover border-start border-3 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-avg-anomaly-score">Avg Anomaly Score</h5>
                                        <h3 class="mb-0">{{ round($stats['avg_anomaly_score'] ?? 0) }}</h3>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ min(100, ($stats['avg_anomaly_score'] ?? 0) / 100 * 100) }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" data-key="t-relative-to-baseline">
                                            Relative to baseline
                                        </small>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-2 text-info">
                                            <i class="fas fa-chart-bar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-line me-2"></i><span data-key="t-analysis-trends">Analysis Trends</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="trend-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie me-2"></i><span data-key="t-risk-level-distribution">Risk Level Distribution</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="risk-chart" style="height: 300px;" wire:ignore></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-filter me-2"></i><span data-key="t-filter-analysis">Filter Analysis</span>
                                    </h5>
                                    <div>
                                        <button wire:click="resetFilters" class="btn btn-sm btn-outline-secondary me-2">
                                            <i class="fas fa-times me-1"></i> <span data-key="t-clear-filters">Clear Filters</span>
                                        </button>
                                        <button wire:click="exportAll" wire:loading.attr="disabled" class="btn btn-sm btn-success">
                                            <i class="fas fa-file-excel me-1" wire:loading.class="fa-spin"></i>
                                            <span data-key="t-export-filtered">Export Filtered</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <label class="form-label" data-key="t-time-range">Time Range</label>
                                        <select wire:model.live="timeRange" wire:change="applyFilters" class="form-select form-select-sm">
                                            <option value="7days" data-key="t-last-7-days">Last 7 Days</option>
                                            <option value="30days" data-key="t-last-30-days">Last 30 Days</option>
                                            <option value="90days" data-key="t-last-90-days">Last 90 Days</option>
                                            <option value="all" data-key="t-all-time">All Time</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <label class="form-label" data-key="t-status">Status</label>
                                        <select wire:model.live="filterStatus" wire:change="applyFilters" class="form-select form-select-sm">
                                            <option value="all" data-key="t-all-status">All Status</option>
                                            @foreach($statusOptions as $status)
                                                <option value="{{ $status }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <label class="form-label" data-key="t-risk-level">Risk Level</label>
                                        <select wire:model.live="filterRisk" wire:change="applyFilters" class="form-select form-select-sm">
                                            <option value="all" data-key="t-all-risk">All Risk</option>
                                            @foreach($riskOptions as $risk)
                                                <option value="{{ $risk }}">{{ $risk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <label class="form-label" data-key="t-search-analysis">Search Analysis</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by ID, status, weather..." data-key-placeholder="t-search-by-id-status-weather">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-table me-2"></i><span data-key="t-historical-analysis-records">Historical Analysis Records</span>
                                    </h5>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark">
                                            {{ $analyses->total() }} <span data-key="t-records">records</span>
                                        </span>
                                        @if(count($analyses) > 0)
                                            <button wire:click="exportAll" wire:loading.attr="disabled" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-file-excel me-1" wire:loading.class="fa-spin"></i>
                                                <span data-key="t-export-table">Export</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden"><span data-key="t-loading">Loading...</span></span>
                                        </div>
                                        <p class="mt-2 text-muted" data-key="t-loading-analysis-history">Loading analysis history...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th><span data-key="t-time">Time</span></th>
                                                <th><span data-key="t-analysis-id">Analysis ID</span></th>
                                                <th><span data-key="t-aircraft-summary">Aircraft Summary</span></th>
                                                <th><span data-key="t-threat-metrics">Threat Metrics</span></th>
                                                <th><span data-key="t-risk-level">Risk Level</span></th>
                                                <th><span data-key="t-anomaly-score">Anomaly Score</span></th>
                                                <th><span data-key="t-status">Status</span></th>
                                                <th class="text-center"><span data-key="t-actions">Actions</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($analyses as $analysis)
                                                <tr class="{{ $analysis->overall_risk === 'HIGH' ? 'table-danger' : ($analysis->overall_risk === 'MEDIUM' ? 'table-warning' : '') }}">
                                                    <td>
                                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($analysis->analysis_time)->format('M d, Y') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($analysis->analysis_time)->format('H:i') }}</small>
                                                        <div class="text-muted small">{{ \Carbon\Carbon::parse($analysis->analysis_time)->diffForHumans() }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium text-truncate" style="max-width: 120px;" title="{{ $analysis->analysis_id }}">
                                                            {{ $analysis->analysis_id }}
                                                        </div>
                                                        <div class="mt-1">
                                                            @if($analysis->is_night)
                                                                <span class="badge bg-dark me-1" data-key="t-night">Night</span>
                                                            @endif
                                                            @if($analysis->is_weekend)
                                                                <span class="badge bg-secondary" data-key="t-weekend">Weekend</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                                            <span class="badge bg-primary">{{ $analysis->total_aircraft }} <span data-key="t-total">total</span></span>
                                                            <span class="badge bg-danger">{{ $analysis->military_aircraft }} <span data-key="t-military">military</span></span>
                                                            <span class="badge bg-warning">{{ $analysis->drones }} <span data-key="t-drones">drones</span></span>
                                                            <span class="badge bg-success">{{ $analysis->civil_aircraft }} <span data-key="t-civil">civil</span></span>
                                                        </div>
                                                        <small class="text-muted">
                                                            <span data-key="t-nato">NATO</span>: {{ $analysis->nato_aircraft }} • <span data-key="t-sensitive">Sensitive</span>: {{ $analysis->near_sensitive }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div><span data-key="t-high-threat">High Threat</span>: {{ $analysis->high_threat_aircraft }}</div>
                                                            <div><span data-key="t-potential">Potential</span>: {{ $analysis->potential_threats }}</div>
                                                            <div><span data-key="t-high-speed">High Speed</span>: {{ $analysis->high_speed }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $analysis->overall_risk === 'HIGH' ? 'danger' : ($analysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }} px-2 py-1">
                                                        {{ $analysis->overall_risk }}
                                                    </span>
                                                        <div class="text-muted small mt-1">
                                                            <span data-key="t-severity">Severity</span>: {{ $analysis->severity }}/5
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $analysis->anomaly_score > 50 ? 'danger' : ($analysis->anomaly_score > 30 ? 'warning' : 'success') }}"
                                                                     style="width: {{ min(100, $analysis->anomaly_score) }}%"></div>
                                                            </div>
                                                            <strong>{{ $analysis->anomaly_score }}</strong>
                                                        </div>
                                                        <small class="text-muted">
                                                            <span data-key="t-composite">Composite</span>: {{ $analysis->composite_score }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $analysis->status === 'ACTIVE' ? 'success' : 'secondary' }}">
                                                        {{ $analysis->status }}
                                                    </span>
                                                        <div class="text-muted small mt-1">
                                                            {{ round($analysis->confidence * 100) }}% <span data-key="t-conf">conf</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button wire:click="viewDetails('{{ $analysis->id }}')" class="btn btn-outline-primary" title="View Details" data-key-title="t-view-details">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button wire:click="exportAnalysis('{{ $analysis->id }}')" wire:loading.attr="disabled" class="btn btn-outline-secondary" title="Export Analysis" data-key-title="t-export-analysis">
                                                                <i class="fas fa-download" wire:loading.class="fa-spin"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="fas fa-history fa-3x mb-3 opacity-25"></i>
                                                            <h5 class="mb-2" data-key="t-no-analysis-records-found">No analysis records found</h5>
                                                            <p class="mb-0" data-key="t-try-adjusting-your-filters-or-refresh">Try adjusting your filters or refresh</p>
                                                            <button wire:click="resetFilters" class="btn btn-sm btn-outline-primary mt-3">
                                                                <i class="fas fa-redo me-1"></i> <span data-key="t-reset-filters">Reset Filters</span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            @if(count($analyses) > 0)
                                <div class="card-footer bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-sm-6">
                                            <small class="text-muted">
                                                <span data-key="t-showing">Showing</span>
                                                {{ $analyses->firstItem() ?? 0 }}
                                                <span data-key="t-to">to</span>
                                                {{ $analyses->lastItem() ?? 0 }}
                                                <span data-key="t-of">of</span>
                                                {{ $analyses->total() }}
                                                <span data-key="t-entries">entries</span>
                                            </small>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="float-sm-end">
                                                {{ $analyses->links('livewire::bootstrap') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($showDetailsModal && $selectedAnalysis)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-{{ $selectedAnalysis->overall_risk === 'HIGH' ? 'danger' : ($selectedAnalysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }} text-white">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-chart-bar me-2"></i>
                            <span data-key="t-analysis-details">Analysis Details</span>
                            <span class="badge bg-white text-dark ms-2">
                                <span data-key="t-id">ID</span>: {{ $selectedAnalysis->analysis_id }}
                            </span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-3" data-key="t-analysis-time">ANALYSIS TIME</h6>
                                        <div class="display-6 fw-bold">
                                            {{ \Carbon\Carbon::parse($selectedAnalysis->analysis_time)->format('H:i') }}
                                        </div>
                                        <div class="text-muted">
                                            {{ \Carbon\Carbon::parse($selectedAnalysis->analysis_time)->format('M d, Y') }}
                                        </div>
                                        <div class="mt-2">
                                            @if($selectedAnalysis->is_night)
                                                <span class="badge bg-dark me-1" data-key="t-night-analysis">Night Analysis</span>
                                            @endif
                                            @if($selectedAnalysis->is_weekend)
                                                <span class="badge bg-secondary" data-key="t-weekend">Weekend</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-{{ $selectedAnalysis->overall_risk === 'HIGH' ? 'danger' : ($selectedAnalysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }}-subtle">
                                    <div class="card-body text-center">
                                        <h6 class="text-muted mb-3" data-key="t-risk-assessment">RISK ASSESSMENT</h6>
                                        <div class="display-4 fw-bold text-{{ $selectedAnalysis->overall_risk === 'HIGH' ? 'danger' : ($selectedAnalysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }}">
                                            {{ $selectedAnalysis->overall_risk }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge bg-secondary">
                                                <span data-key="t-severity">Severity</span>: {{ $selectedAnalysis->severity }}/5
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info-subtle">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3" data-key="t-scores">SCORES</h6>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-anomaly">Anomaly</small>
                                                <div class="h3 fw-bold">{{ $selectedAnalysis->anomaly_score }}</div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-composite">Composite</small>
                                                <div class="h3 fw-bold">{{ $selectedAnalysis->composite_score }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block" data-key="t-trend">Trend</small>
                                                <div class="h4 fw-bold">{{ $selectedAnalysis->trend_score }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block" data-key="t-confidence">Confidence</small>
                                                <div class="h4 fw-bold">{{ round($selectedAnalysis->confidence * 100) }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning-subtle">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3" data-key="t-weather-impact">WEATHER IMPACT</h6>
                                        @if($selectedAnalysis->weather_api_available)
                                            <div class="text-center">
                                                <div class="mb-2">
                                                    <small class="text-muted d-block" data-key="t-multiplier">Multiplier</small>
                                                    <div class="h3 fw-bold">{{ $selectedAnalysis->weather_multiplier }}x</div>
                                                </div>
                                                <div class="mb-2">
                                                    <small class="text-muted d-block" data-key="t-adjusted-score">Adjusted Score</small>
                                                    <div class="h4 fw-bold">{{ $selectedAnalysis->adjusted_anomaly_score }}</div>
                                                </div>
                                                @if($selectedAnalysis->weather_significant)
                                                    <span class="badge bg-warning" data-key="t-significant-weather">Significant Weather</span>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-3">
                                                <i class="fas fa-cloud-slash fa-2x text-muted mb-2"></i>
                                                <p class="text-muted mb-0" data-key="t-weather-data-unavailable">Weather data unavailable</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3 border-bottom pb-2" data-key="t-aircraft-statistics">AIRCRAFT STATISTICS</h6>
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <div class="card border-primary">
                                            <div class="card-body text-center py-3">
                                                <div class="display-6 fw-bold text-primary">{{ $selectedAnalysis->total_aircraft }}</div>
                                                <small class="text-muted" data-key="t-total-aircraft">Total Aircraft</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card border-danger">
                                            <div class="card-body text-center py-3">
                                                <div class="display-6 fw-bold text-danger">{{ $selectedAnalysis->military_aircraft }}</div>
                                                <small class="text-muted" data-key="t-military">Military</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card border-warning">
                                            <div class="card-body text-center py-3">
                                                <div class="display-6 fw-bold text-warning">{{ $selectedAnalysis->drones }}</div>
                                                <small class="text-muted" data-key="t-drones">Drones</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card border-success">
                                            <div class="card-body text-center py-3">
                                                <div class="display-6 fw-bold text-success">{{ $selectedAnalysis->civil_aircraft }}</div>
                                                <small class="text-muted" data-key="t-civil">Civil</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card border-info">
                                            <div class="card-body text-center py-3">
                                                <div class="display-6 fw-bold text-info">{{ $selectedAnalysis->nato_aircraft }}</div>
                                                <small class="text-muted" data-key="t-nato">NATO</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card border-secondary">
                                            <div class="card-body text-center py-3">
                                                <div class="display-6 fw-bold text-secondary">{{ $selectedAnalysis->high_threat_aircraft }}</div>
                                                <small class="text-muted" data-key="t-high-threat">High Threat</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0" data-key="t-threat-metrics">Threat Metrics</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-near-sensitive-areas">Near Sensitive Areas</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->near_sensitive }}</strong>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-potential-threats">Potential Threats</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->potential_threats }}</strong>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-high-speed-aircraft">High Speed Aircraft</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->high_speed }}</strong>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-low-altitude">Low Altitude</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->low_altitude }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block" data-key="t-persistent-alert">Persistent Alert</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->persistent_alert ? 'Yes' : 'No' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0" data-key="t-analysis-context">Analysis Context</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-deduplication-rate">Deduplication Rate</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->deduplication_rate }}%</strong>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-baseline">Baseline</small>
                                                <strong class="fs-5">{{ $selectedAnalysis->baseline }}</strong>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block" data-key="t-status">Status</small>
                                                <span class="badge bg-{{ $selectedAnalysis->status === 'ACTIVE' ? 'success' : 'secondary' }}">
                                                    {{ $selectedAnalysis->status }}
                                                </span>
                                            </div>
                                            @if($selectedAnalysis->weather_notes)
                                                <div class="col-12 mt-3">
                                                    <small class="text-muted d-block" data-key="t-weather-notes">Weather Notes</small>
                                                    <div class="alert alert-light mb-0">
                                                        {{ $selectedAnalysis->weather_notes }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($selectedAnalysis->enhanced_stats || $selectedAnalysis->scoring_breakdown || $selectedAnalysis->final_assessment)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="accordion" id="dataAccordion">

                                        @if($selectedAnalysis->enhanced_stats)
                                            @php
                                                $stats = json_decode($selectedAnalysis->enhanced_stats, true);
                                            @endphp
                                            <div class="accordion-item border-0 mb-3">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#enhancedStats">
                                                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                                                        <strong data-key="t-enhanced-statistics">Enhanced Statistics</strong>
                                                    </button>
                                                </h2>
                                                <div id="enhancedStats" class="accordion-collapse collapse show">
                                                    <div class="accordion-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <div class="card h-100 border-light bg-light bg-opacity-25">
                                                                    <div class="card-body">
                                                                        <h6 class="card-title text-muted mb-3 border-bottom pb-2" data-key="t-general-counts">General Counts</h6>
                                                                        <div class="d-flex flex-wrap gap-2">
                                                                            <span class="badge bg-primary p-2 text-uppercase"><span data-key="t-total">Total</span>: {{ $stats['total'] ?? 0 }}</span>
                                                                            <span class="badge bg-danger p-2 text-uppercase"><span data-key="t-military">Military</span>: {{ $stats['military'] ?? 0 }}</span>
                                                                            <span class="badge bg-success p-2 text-uppercase"><span data-key="t-civil">Civil</span>: {{ $stats['civil'] ?? 0 }}</span>
                                                                            <span class="badge bg-warning p-2 text-uppercase text-dark"><span data-key="t-drones">Drones</span>: {{ $stats['drones'] ?? 0 }}</span>
                                                                            <span class="badge bg-info p-2 text-uppercase">NATO: {{ $stats['nato_count'] ?? 0 }}</span>
                                                                        </div>
                                                                        <h6 class="card-title text-muted mt-4 mb-3 border-bottom pb-2" data-key="t-threat-indicators">Threat Indicators</h6>
                                                                        <ul class="list-group list-group-flush bg-transparent">
                                                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-1">
                                                                                <span><i class="fas fa-radiation text-danger me-2"></i><span data-key="t-high-threat">High Threat</span></span>
                                                                                <span class="fw-bold">{{ $stats['high_threat'] ?? 0 }}</span>
                                                                            </li>
                                                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-1">
                                                                                <span><i class="fas fa-exclamation-circle text-warning me-2"></i><span data-key="t-potential-threats">Potential Threats</span></span>
                                                                                <span class="fw-bold">{{ $stats['potential_threats'] ?? 0 }}</span>
                                                                            </li>
                                                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-1">
                                                                                <span><i class="fas fa-map-marked-alt text-danger me-2"></i><span data-key="t-near-sensitive">Near Sensitive</span></span>
                                                                                <span class="fw-bold">{{ $stats['nearSensitive'] ?? 0 }}</span>
                                                                            </li>
                                                                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 py-1">
                                                                                <span><i class="fas fa-tachometer-alt text-info me-2"></i><span data-key="t-high-speed">High Speed</span></span>
                                                                                <span class="fw-bold">{{ $stats['highSpeed'] ?? 0 }}</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row g-3">
                                                                    @if(isset($stats['by_country']) && count($stats['by_country']) > 0)
                                                                        <div class="col-12">
                                                                            <div class="border rounded p-2">
                                                                                <small class="text-muted fw-bold d-block mb-2" data-key="t-by-country">By Country</small>
                                                                                <div class="d-flex flex-wrap gap-1">
                                                                                    @foreach($stats['by_country'] as $country => $count)
                                                                                        <span class="badge bg-secondary bg-opacity-75 text-white border">
                                                                                            {{ $country }}: {{ $count }}
                                                                                        </span>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($stats['bySource']))
                                                                        <div class="col-6">
                                                                            <div class="border rounded p-2 h-100">
                                                                                <small class="text-muted fw-bold d-block mb-2" data-key="t-data-source">Data Source</small>
                                                                                <ul class="list-unstyled mb-0 small">
                                                                                    @foreach($stats['bySource'] as $source => $count)
                                                                                        <li class="d-flex justify-content-between">
                                                                                            <span>{{ $source }}</span>
                                                                                            <span class="fw-bold">{{ $count }}</span>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($stats['byAltitude']))
                                                                        <div class="col-6">
                                                                            <div class="border rounded p-2 h-100">
                                                                                <small class="text-muted fw-bold d-block mb-2" data-key="t-altitude">Altitude</small>
                                                                                <ul class="list-unstyled mb-0 small">
                                                                                    @foreach($stats['byAltitude'] as $alt => $count)
                                                                                        @php
                                                                                            $t_source = strtolower($alt);
                                                                                        @endphp
                                                                                        <li class="d-flex justify-content-between text-capitalize">
                                                                                            <span data-key="t-{{ $t_source }}">{{ $alt }}</span>
                                                                                            <span class="fw-bold">{{ $count }}</span>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($selectedAnalysis->scoring_breakdown)
                                            @php
                                                $scores = json_decode($selectedAnalysis->scoring_breakdown, true);
                                            @endphp
                                            <div class="accordion-item border-0 mb-3">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scoringBreakdown">
                                                        <i class="fas fa-calculator me-2 text-info"></i>
                                                        <strong data-key="t-scoring-breakdown">Scoring Breakdown</strong>
                                                    </button>
                                                </h2>
                                                <div id="scoringBreakdown" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered mb-0">
                                                                <thead class="table-light">
                                                                <tr>
                                                                    <th data-key="t-factor">Factor</th>
                                                                    <th class="text-end" data-key="t-value">Value</th>
                                                                    <th data-key="t-description">Description</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td class="fw-bold text-primary" data-key="t-final-score">Final Score</td>
                                                                    <td class="text-end fw-bold text-primary fs-5">{{ $scores['final'] ?? 0 }}</td>
                                                                    <td><small data-key="t-calculated-anomaly-score">Calculated anomaly score</small></td>
                                                                </tr>
                                                                <tr>
                                                                    <td data-key="t-base-score">Base Score</td>
                                                                    <td class="text-end">{{ $scores['base'] ?? 0 }}</td>
                                                                    <td><small data-key="t-initial-baseline-score">Initial baseline score</small></td>
                                                                </tr>
                                                                @foreach($scores as $key => $value)
                                                                    @if(!in_array($key, ['final', 'base', 'raw']))
                                                                        @php
                                                                            $t_key = strtolower(str_replace('_', '-', $key));
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="text-capitalize" data-key="t-{{ $t_key }}">{{ str_replace('_', ' ', $key) }}</td>
                                                                            <td class="text-end">
                                                                                @if(is_numeric($value) && $value > 0)
                                                                                    <span class="text-danger">+{{ $value }}</span>
                                                                                @elseif(is_numeric($value) && $value < 0)
                                                                                    <span class="text-success">{{ $value }}</span>
                                                                                @else
                                                                                    {{ $value }}
                                                                                @endif
                                                                            </td>
                                                                            <td><small class="text-muted" data-key="t-factor-contribution">Factor contribution</small></td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($selectedAnalysis->final_assessment)
                                            @php
                                                $assessment = json_decode($selectedAnalysis->final_assessment, true);
                                            @endphp
                                            <div class="accordion-item border-0">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalAssessment">
                                                        <i class="fas fa-file-signature me-2 text-success"></i>
                                                        <strong data-key="t-final-assessment">Final Assessment</strong>
                                                    </button>
                                                </h2>
                                                <div id="finalAssessment" class="accordion-collapse collapse">
                                                    <div class="accordion-body">
                                                        @if(empty($assessment))
                                                            <div class="alert alert-secondary mb-0">
                                                                <i class="fas fa-info-circle me-2"></i> <span data-key="t-no-specific-text">No specific text assessment generated. Refer to calculated scores and threat levels.</span>
                                                            </div>
                                                        @else
                                                            <div class="bg-light p-3 rounded">
                                                                @if(is_array($assessment))
                                                                    <ul class="list-group list-group-flush">
                                                                        @foreach($assessment as $key => $val)
                                                                            <li class="list-group-item bg-transparent">
                                                                                <strong class="text-capitalize">{{ str_replace('_', ' ', $key) }}:</strong> {{ is_array($val) ? json_encode($val) : $val }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                    <p class="mb-0">{{ $assessment }}</p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($selectedAnalysis->map_url)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <a href="{{ $selectedAnalysis->map_url }}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                <span data-key="t-view-analysis-map">View Analysis Map</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            <i class="fas fa-times me-1"></i> <span data-key="t-close">Close</span>
                        </button>
                        <button type="button" class="btn btn-success" wire:click="exportAnalysis('{{ $selectedAnalysis->id }}')" wire:loading.attr="disabled">
                            <i class="fas fa-file-excel me-1" wire:loading.class="fa-spin"></i>
                            <span data-key="t-export-report">Export Report</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($exporting)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-primary">
                            <i class="fas fa-file-excel me-2"></i>
                            <span data-key="t-preparing-export">Preparing Export</span>
                        </h5>
                    </div>
                    <div class="modal-body text-center py-4">
                        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden"><span data-key="t-loading">Loading...</span></span>
                        </div>
                        <h5 class="mb-2" data-key="t-generating-excel-file">Generating Excel File</h5>
                        <p class="text-muted mb-0" data-key="t-please-wait-export">Please wait while we prepare your export...</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>

            let trendChart = null;
            let riskChart = null;

            function getNestedProperty(obj, path) {
                return path.split('.').reduce((current, key) => {
                    return current && current[key] !== undefined ? current[key] : null;
                }, obj);
            }

            function applyPageTranslations(translations) {

                document.querySelectorAll('[data-key]').forEach(element => {
                    const key = element.getAttribute('data-key');
                    const translation = getNestedProperty(translations, key);
                    if (translation) {
                        if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                            element.placeholder = translation;
                        } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                            element.value = translation;
                        } else if (element.hasAttribute('title')) {
                            element.setAttribute('title', translation);
                        } else {
                            element.textContent = translation;
                        }
                    }
                });

                document.querySelectorAll('[data-i18n]').forEach(element => {
                    const key = element.getAttribute('data-i18n');
                    const translation = getNestedProperty(translations, key);
                    if (translation) {
                        if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                            element.placeholder = translation;
                        } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                            element.value = translation;
                        } else {
                            element.textContent = translation;
                        }
                    }
                });

                document.querySelectorAll('[data-key-placeholder]').forEach(element => {
                    const key = element.getAttribute('data-key-placeholder');
                    const translation = getNestedProperty(translations, key);
                    if (translation) {
                        element.setAttribute('placeholder', translation);
                    }
                });

                document.querySelectorAll('[data-key-title]').forEach(element => {
                    const key = element.getAttribute('data-key-title');
                    const translation = getNestedProperty(translations, key);
                    if (translation) {
                        element.setAttribute('title', translation);
                    }
                });
            }

            function loadPageTranslations(lang = null) {
                const locale = lang || localStorage.getItem('user_locale') || 'en';
                const translationPath = `/user/assets/lang/${locale}.json`;

                return fetch(translationPath)
                    .then(response => {
                        if (!response.ok) {
                            const altPath = `/assets/lang/${locale}.json`;
                            return fetch(altPath);
                        }
                        return response;
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Failed to load translations: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(translations => {
                        applyPageTranslations(translations);
                        return translations;
                    })
                    .catch(error => {
                        console.error('Translation load error:', error);

                        if (locale !== 'en') {
                            return loadPageTranslations('en');
                        }
                    });
            }

            function preserveLocale() {
                const currentLocale = localStorage.getItem('user_locale') || 'en';

                document.body.setAttribute('data-locale', currentLocale);

                if (window.Livewire) {
                    window.Livewire.dispatch('locale-changed', { locale: currentLocale });
                }

                return currentLocale;
            }

            function reapplyTranslationsAfterUpdate() {
                const currentLocale = preserveLocale();
                setTimeout(() => {
                    loadPageTranslations(currentLocale);
                }, 100);
            }

            document.addEventListener('livewire:initialized', function() {

                preserveLocale();

                loadPageTranslations();

                initCharts();

                Livewire.on('charts-updated', function() {
                    destroyCharts();
                    setTimeout(() => {
                        initCharts();
                        reapplyTranslationsAfterUpdate();
                    }, 500);
                });

                Livewire.hook('message.processed', (message, component) => {
                    if (component.name.includes('analysis-history')) {
                        setTimeout(() => {

                            const trendContainer = document.querySelector("#trend-chart");
                            const riskContainer = document.querySelector("#risk-chart");

                            if (trendContainer && !trendContainer.querySelector('.apexcharts-canvas')) {
                                destroyCharts();
                                initCharts();
                            }

                            reapplyTranslationsAfterUpdate();
                        }, 300);
                    }
                });

                window.addEventListener('language-changed', function(event) {
                    const locale = event.detail?.locale || localStorage.getItem('user_locale') || 'en';
                    loadPageTranslations(locale);

                    setTimeout(() => {
                        destroyCharts();
                        initCharts();
                    }, 100);
                });

                document.addEventListener('locale-updated', function(e) {
                    const locale = e.detail?.locale || localStorage.getItem('user_locale') || 'en';
                    loadPageTranslations(locale);
                });

                function initCharts() {
                    const trendData = @json($chartData ?? []);
                    if (trendData.dates && trendData.dates.length > 0) {
                        const trendContainer = document.querySelector("#trend-chart");
                        if (trendContainer) {
                            if (!trendContainer.querySelector('.apexcharts-canvas')) {
                                trendChart = new ApexCharts(trendContainer, {
                                    series: [
                                        {
                                            name: 'Analysis Count',
                                            type: 'column',
                                            data: trendData.analysis_counts
                                        },
                                        {
                                            name: 'Avg Aircraft',
                                            type: 'line',
                                            data: trendData.avg_aircraft
                                        },
                                        {
                                            name: 'Avg Anomaly Score',
                                            type: 'line',
                                            data: trendData.avg_anomaly
                                        }
                                    ],
                                    chart: {
                                        height: 300,
                                        type: 'line',
                                        toolbar: {
                                            show: true
                                        },
                                        events: {
                                            mounted: function() {
                                                reapplyTranslationsAfterUpdate();
                                            }
                                        }
                                    },
                                    stroke: {
                                        width: [0, 2, 2]
                                    },
                                    colors: ['#0d6efd', '#fd7e14', '#dc3545'],
                                    dataLabels: {
                                        enabled: false
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    xaxis: {
                                        categories: trendData.dates
                                    },
                                    yaxis: [
                                        {
                                            title: {
                                                text: 'Analysis Count'
                                            }
                                        },
                                        {
                                            opposite: true,
                                            title: {
                                                text: 'Aircraft / Score'
                                            }
                                        }
                                    ],
                                    tooltip: {
                                        shared: true,
                                        intersect: false,
                                        y: {
                                            formatter: function (y) {
                                                if (typeof y !== "undefined") {
                                                    return y.toFixed(1);
                                                }
                                                return y;
                                            }
                                        }
                                    }
                                });
                                trendChart.render();
                            }
                        }
                    }

                    const riskData = @json($riskDistribution ?? []);
                    if (Object.keys(riskData).length > 0) {
                        const riskContainer = document.querySelector("#risk-chart");
                        if (riskContainer) {
                            if (!riskContainer.querySelector('.apexcharts-canvas')) {
                                riskChart = new ApexCharts(riskContainer, {
                                    series: Object.values(riskData),
                                    chart: {
                                        type: 'donut',
                                        height: 300,
                                        events: {
                                            mounted: function() {
                                                reapplyTranslationsAfterUpdate();
                                            }
                                        }
                                    },
                                    labels: Object.keys(riskData),
                                    colors: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
                                    legend: {
                                        position: 'bottom'
                                    },
                                    plotOptions: {
                                        pie: {
                                            donut: {
                                                size: '60%',
                                                labels: {
                                                    show: true,
                                                    total: {
                                                        show: true,
                                                        label: "Total",
                                                        color: '#6c757d',
                                                        formatter: function(w) {
                                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    responsive: [{
                                        breakpoint: 480,
                                        options: {
                                            chart: {
                                                width: 200
                                            },
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    }]
                                });
                                riskChart.render();
                            }
                        }
                    }
                }

                function destroyCharts() {
                    if (trendChart) {
                        try {
                            trendChart.destroy();
                        } catch (e) {
                            console.error('Error destroying trend chart:', e);
                        }
                        trendChart = null;
                    }

                    if (riskChart) {
                        try {
                            riskChart.destroy();
                        } catch (e) {
                            console.error('Error destroying risk chart:', e);
                        }
                        riskChart = null;
                    }
                }

                document.addEventListener('livewire:before-destroy', function() {
                    destroyCharts();
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const savedLocale = localStorage.getItem('user_locale') || 'en';
                loadPageTranslations(savedLocale);

                document.dispatchEvent(new CustomEvent('page-locale-loaded', {
                    detail: { locale: savedLocale }
                }));
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('user/assets/css/pages/analysis-history.css') }}" />
    @endpush
</div>
