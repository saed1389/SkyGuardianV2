<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-history me-2"></i>Analysis History
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-database me-1"></i>
                                    {{ $stats['total_analyses'] ?? 0 }} Analyses
                                </span>
                                <button wire:click="refreshData" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-redo"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Historical analysis data and trends</p>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Total Analyses</p>
                                        <h3 class="mb-0">{{ $stats['total_analyses'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-primary bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-primary me-1">Avg: {{ round($stats['avg_aircraft'] ?? 0) }} aircraft</span>
                                        <span class="text-success">{{ round($stats['avg_confidence'] * 100 ?? 0) }}% confidence</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Military Aircraft</p>
                                        <h3 class="mb-0">{{ round($stats['avg_military'] ?? 0) }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-danger bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-fighter-jet"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: {{ min(100, ($stats['avg_military'] ?? 0) / max(1, ($stats['avg_aircraft'] ?? 1)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">High Risk Analyses</p>
                                        <h3 class="mb-0">{{ $stats['high_risk_count'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 text-muted">
                                        {{ $stats['critical_count'] ?? 0 }} critical
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-info bg-opacity-10 border-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Avg Anomaly Score</p>
                                        <h3 class="mb-0">{{ round($stats['avg_anomaly_score'] ?? 0) }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-info bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{ min(100, ($stats['avg_anomaly_score'] ?? 0) / 100 * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Analysis Trends</h5>
                            </div>
                            <div class="card-body">
                                <div id="trend-chart" style="height: 300px;" wire:ignore.self></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Risk Level Distribution</h5>
                            </div>
                            <div class="card-body">
                                <div id="risk-chart" style="height: 300px;" wire:ignore.self></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label">Time Range</label>
                                        <select wire:model.live="timeRange" wire:change="applyFilters" class="form-select">
                                            <option value="7days">Last 7 Days</option>
                                            <option value="30days">Last 30 Days</option>
                                            <option value="90days">Last 90 Days</option>
                                            <option value="all">All Time</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Status</label>
                                        <select wire:model.live="filterStatus" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Status</option>
                                            @foreach($statusOptions as $status)
                                                <option value="{{ $status }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Risk Level</label>
                                        <select wire:model.live="filterRisk" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Risk</option>
                                            @foreach($riskOptions as $risk)
                                                <option value="{{ $risk }}">{{ $risk }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Search Analysis</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                   class="form-control" placeholder="Search by ID, status, weather...">
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-times me-1"></i> Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analyses Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Historical Analysis Records</h5>
                                    <span class="badge bg-light text-dark">
                                        {{ count($analyses) }} records
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading analysis history...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Analysis ID</th>
                                                <th>Aircraft Summary</th>
                                                <th>Threat Metrics</th>
                                                <th>Risk Level</th>
                                                <th>Anomaly Score</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($analyses as $analysis)
                                                <tr class="{{ $analysis->overall_risk === 'HIGH' ? 'table-danger' : ($analysis->overall_risk === 'MEDIUM' ? 'table-warning' : '') }}">
                                                    <td>
                                                        <div>{{ \Carbon\Carbon::parse($analysis->analysis_time)->format('M d') }}</div>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($analysis->analysis_time)->format('H:i') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ Str::limit($analysis->analysis_id, 15) }}</div>
                                                        @if($analysis->is_night)
                                                            <span class="badge bg-dark">Night</span>
                                                        @endif
                                                        @if($analysis->is_weekend)
                                                            <span class="badge bg-secondary">Weekend</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                                            <span class="badge bg-primary">{{ $analysis->total_aircraft }} total</span>
                                                            <span class="badge bg-danger">{{ $analysis->military_aircraft }} military</span>
                                                            <span class="badge bg-warning">{{ $analysis->drones }} drones</span>
                                                            <span class="badge bg-success">{{ $analysis->civil_aircraft }} civil</span>
                                                        </div>
                                                        <small class="text-muted">
                                                            NATO: {{ $analysis->nato_aircraft }} • Sensitive: {{ $analysis->near_sensitive }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="small">
                                                            <div>High Threat: {{ $analysis->high_threat_aircraft }}</div>
                                                            <div>Potential: {{ $analysis->potential_threats }}</div>
                                                            <div>High Speed: {{ $analysis->high_speed }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $analysis->overall_risk === 'HIGH' ? 'danger' : ($analysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }}">
                                                        {{ $analysis->overall_risk }}
                                                    </span>
                                                        <div class="small text-muted">Severity: {{ $analysis->severity }}/5</div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $analysis->anomaly_score > 50 ? 'danger' : ($analysis->anomaly_score > 30 ? 'warning' : 'success') }}"
                                                                     style="width: {{ min(100, $analysis->anomaly_score) }}%"></div>
                                                            </div>
                                                            <strong>{{ $analysis->anomaly_score }}</strong>
                                                        </div>
                                                        <small class="text-muted">Composite: {{ $analysis->composite_score }}</small>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $analysis->status === 'ACTIVE' ? 'success' : 'secondary' }}">
                                                        {{ $analysis->status }}
                                                    </span>
                                                        <div class="small text-muted">{{ round($analysis->confidence * 100) }}% conf</div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button wire:click="viewDetails('{{ $analysis->id }}')"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button wire:click="exportAnalysis('{{ $analysis->id }}')"
                                                                    class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-history fa-2x mb-2"></i>
                                                            <p>No analysis records found</p>
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
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Showing {{ count($analyses) }} analyses •
                                            Time range: {{ $timeRange === '7days' ? 'Last 7 days' : ($timeRange === '30days' ? 'Last 30 days' : ($timeRange === '90days' ? 'Last 90 days' : 'All time')) }}
                                        </small>
                                        <div>
                                            <small class="text-muted me-3">
                                                Avg aircraft: {{ round($stats['avg_aircraft'] ?? 0) }}
                                            </small>
                                            <button wire:click="refreshData" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-sync-alt"></i> Refresh
                                            </button>
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

    <!-- Analysis Details Modal -->
    @if($showDetailsModal && $selectedAnalysis)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-{{ $selectedAnalysis->overall_risk === 'HIGH' ? 'danger' : ($selectedAnalysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }} text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            Analysis Details
                            <span class="badge bg-light text-dark ms-2">ID: {{ $selectedAnalysis->analysis_id }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Analysis Overview -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">ANALYSIS TIME</h6>
                                        <div class="text-center">
                                            <div class="display-6 fw-bold">
                                                {{ \Carbon\Carbon::parse($selectedAnalysis->analysis_time)->format('H:i') }}
                                            </div>
                                            <div class="text-muted">
                                                {{ \Carbon\Carbon::parse($selectedAnalysis->analysis_time)->format('M d, Y') }}
                                            </div>
                                            @if($selectedAnalysis->is_night)
                                                <span class="badge bg-dark mt-2">Night Analysis</span>
                                            @endif
                                            @if($selectedAnalysis->is_weekend)
                                                <span class="badge bg-secondary mt-2">Weekend</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card bg-{{ $selectedAnalysis->overall_risk === 'HIGH' ? 'danger' : ($selectedAnalysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }} bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">RISK ASSESSMENT</h6>
                                        <div class="text-center">
                                            <div class="display-4 fw-bold text-{{ $selectedAnalysis->overall_risk === 'HIGH' ? 'danger' : ($selectedAnalysis->overall_risk === 'MEDIUM' ? 'warning' : 'success') }}">
                                                {{ $selectedAnalysis->overall_risk }}
                                            </div>
                                            <div class="mt-2">
                                                <span class="badge bg-secondary">Severity: {{ $selectedAnalysis->severity }}/5</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card bg-info bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">SCORES</h6>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Anomaly</small>
                                                    <div class="h3 fw-bold">{{ $selectedAnalysis->anomaly_score }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Composite</small>
                                                    <div class="h3 fw-bold">{{ $selectedAnalysis->composite_score }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Trend</small>
                                                    <div class="h4 fw-bold">{{ $selectedAnalysis->trend_score }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Confidence</small>
                                                    <div class="h4 fw-bold">{{ round($selectedAnalysis->confidence * 100) }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card bg-warning bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">WEATHER IMPACT</h6>
                                        <div class="text-center">
                                            @if($selectedAnalysis->weather_api_available)
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Multiplier</small>
                                                    <div class="h3 fw-bold">{{ $selectedAnalysis->weather_multiplier }}x</div>
                                                </div>
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">Adjusted Score</small>
                                                    <div class="h4 fw-bold">{{ $selectedAnalysis->adjusted_anomaly_score }}</div>
                                                </div>
                                                @if($selectedAnalysis->weather_significant)
                                                    <span class="badge bg-warning">Significant Weather</span>
                                                @endif
                                            @else
                                                <div class="text-center py-3">
                                                    <i class="fas fa-cloud-slash fa-2x text-muted mb-2"></i>
                                                    <p class="text-muted mb-0">Weather data unavailable</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aircraft Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3 border-bottom pb-2">AIRCRAFT STATISTICS</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="display-6 fw-bold text-primary">{{ $selectedAnalysis->total_aircraft }}</div>
                                                <small class="text-muted">Total Aircraft</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="display-6 fw-bold text-danger">{{ $selectedAnalysis->military_aircraft }}</div>
                                                <small class="text-muted">Military</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="display-6 fw-bold text-warning">{{ $selectedAnalysis->drones }}</div>
                                                <small class="text-muted">Drones</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="display-6 fw-bold text-success">{{ $selectedAnalysis->civil_aircraft }}</div>
                                                <small class="text-muted">Civil</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="display-6 fw-bold text-info">{{ $selectedAnalysis->nato_aircraft }}</div>
                                                <small class="text-muted">NATO</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Threat Metrics -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Threat Metrics</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">High Threat Aircraft</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->high_threat_aircraft }}</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Near Sensitive Areas</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->near_sensitive }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Potential Threats</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->potential_threats }}</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">High Speed Aircraft</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->high_speed }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Low Altitude</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->low_altitude }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Persistent Alert</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->persistent_alert ? 'Yes' : 'No' }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Analysis Context</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Deduplication Rate</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->deduplication_rate }}%</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Baseline</small>
                                                    <strong class="fs-5">{{ $selectedAnalysis->baseline }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Status</small>
                                                    <span class="badge bg-{{ $selectedAnalysis->status === 'ACTIVE' ? 'success' : 'secondary' }}">
                                                    {{ $selectedAnalysis->status }}
                                                </span>
                                                </div>
                                                @if($selectedAnalysis->weather_notes)
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Weather Notes</small>
                                                        <small>{{ $selectedAnalysis->weather_notes }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- JSON Data (Collapsible) -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="accordion" id="dataAccordion">
                                    @if($selectedAnalysis->enhanced_stats)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#enhancedStats">
                                                    Enhanced Statistics
                                                </button>
                                            </h2>
                                            <div id="enhancedStats" class="accordion-collapse collapse" data-bs-parent="#dataAccordion">
                                                <div class="accordion-body">
                                                    <pre class="mb-0" style="font-size: 12px; max-height: 200px; overflow: auto;">{{ json_encode(json_decode($selectedAnalysis->enhanced_stats), JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($selectedAnalysis->scoring_breakdown)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scoringBreakdown">
                                                    Scoring Breakdown
                                                </button>
                                            </h2>
                                            <div id="scoringBreakdown" class="accordion-collapse collapse" data-bs-parent="#dataAccordion">
                                                <div class="accordion-body">
                                                    <pre class="mb-0" style="font-size: 12px; max-height: 200px; overflow: auto;">{{ json_encode(json_decode($selectedAnalysis->scoring_breakdown), JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($selectedAnalysis->final_assessment)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finalAssessment">
                                                    Final Assessment
                                                </button>
                                            </h2>
                                            <div id="finalAssessment" class="accordion-collapse collapse" data-bs-parent="#dataAccordion">
                                                <div class="accordion-body">
                                                    <pre class="mb-0" style="font-size: 12px; max-height: 200px; overflow: auto;">{{ json_encode(json_decode($selectedAnalysis->final_assessment), JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Map Link -->
                        @if($selectedAnalysis->map_url)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <a href="{{ $selectedAnalysis->map_url }}" target="_blank" class="btn btn-primary">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                View Analysis Map
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="exportAnalysis('{{ $selectedAnalysis->id }}')">
                            <i class="fas fa-download me-1"></i> Export Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:initialized', function() {
                Livewire.on('charts-updated', function() {
                    setTimeout(initCharts, 500);
                });

                setTimeout(initCharts, 1000);

                function initCharts() {
                    // Trend Chart
                    const trendData = @json($chartData ?? []);
                    if (trendData.dates && trendData.dates.length > 0) {
                        const trendChart = new ApexCharts(document.querySelector("#trend-chart"), {
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

                    // Risk Distribution Chart
                    const riskData = @json($riskDistribution ?? []);
                    if (Object.keys(riskData).length > 0) {
                        const riskChart = new ApexCharts(document.querySelector("#risk-chart"), {
                            series: Object.values(riskData),
                            chart: {
                                type: 'pie',
                                height: 300
                            },
                            labels: Object.keys(riskData),
                            colors: ['#198754', '#fd7e14', '#dc3545', '#6c757d'],
                            legend: {
                                position: 'bottom'
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
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            .modal-content {
                max-height: 90vh;
            }
            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }
            .bg-opacity-10 {
                background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
            }
            .avatar-sm {
                width: 40px;
                height: 40px;
            }
            .avatar-title {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
            }
            .fs-22 {
                font-size: 22px;
            }
            .accordion-button:not(.collapsed) {
                background-color: rgba(var(--bs-primary-rgb), 0.1);
                color: var(--bs-primary);
            }
            pre {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                padding: 10px;
                margin: 0;
            }
        </style>
    @endpush
</div>
