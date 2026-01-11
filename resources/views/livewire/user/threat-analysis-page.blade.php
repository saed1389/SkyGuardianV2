<div x-data="{
    autoRefresh: @entangle('autoRefresh'),
    refreshInterval: @entangle('refreshInterval'),
    currentLocale: '{{ $currentLocale }}',
    init() {
        if (this.autoRefresh) {
            this.startAutoRefresh();
        }

        Livewire.on('start-auto-refresh', (data) => {
            this.refreshInterval = data.interval;
            this.startAutoRefresh();
        });

        Livewire.on('stop-auto-refresh', () => {
            this.stopAutoRefresh();
        });

        Livewire.on('language-changed', (data) => {
            this.currentLocale = data.locale;
            // Reload the page to apply translations
            window.location.reload();
        });
    },
    startAutoRefresh() {
        this.autoRefreshInterval = setInterval(() => {
            @this.refreshData();
        }, this.refreshInterval * 1000);
    },
    stopAutoRefresh() {
        if (this.autoRefreshInterval) {
            clearInterval(this.autoRefreshInterval);
        }
    }
}" class="threat-analysis-page">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <div class="page-title-left">
                                <h4 class="mb-1 text-dark">
                                    <i class="fas fa-shield-alt text-primary me-2"></i>
                                    <span data-key="t-ai-threat-analysis">
                                        AI Threat Analysis
                                    </span>
                                </h4>
                                <p class="text-muted mb-0" data-key="t-Real-time-threat-assessment-and-predictive-intelligence">
                                    Real-time threat assessment and predictive intelligence
                                </p>
                            </div>
                            <div class="page-title-right">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item"
                                                        wire:click="changeLanguage('en')"
                                                        @if($currentLocale === 'en') disabled @endif>
                                                    EN
                                                    @if($currentLocale === 'en')
                                                        <i class="fas fa-check ms-2 text-success"></i>
                                                    @endif
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item"
                                                        wire:click="changeLanguage('tr')"
                                                        @if($currentLocale === 'tr') disabled @endif>
                                                    TR
                                                    @if($currentLocale === 'tr')
                                                        <i class="fas fa-check ms-2 text-success"></i>
                                                    @endif
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item"
                                                        wire:click="changeLanguage('et')"
                                                        @if($currentLocale === 'et') disabled @endif>
                                                    ET
                                                    @if($currentLocale === 'et')
                                                        <i class="fas fa-check ms-2 text-success"></i>
                                                    @endif
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="btn-group" role="group">
                                        <button wire:click="toggleAutoRefresh"
                                                :class="{'btn-success': autoRefresh, 'btn-outline-secondary': !autoRefresh}"
                                                class="btn btn-sm"
                                                title="Auto Refresh"
                                                data-key-title="t-auto-refresh">
                                            <i class="fas fa-sync-alt" :class="{'fa-spin': autoRefresh}"></i>
                                            <span data-key="t-auto-refresh">Auto Refresh</span> {{ $refreshInterval }}s
                                        </button>
                                        <button wire:click="refreshData"
                                                wire:loading.attr="disabled"
                                                class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-redo" wire:loading.class="fa-spin"></i>
                                            <span data-key="t-refresh">Refresh</span>
                                        </button>
                                    </div>
                                    @if($latestAlert)
                                        <div class="d-flex align-items-center">
                                            <div class="vr mx-2"></div>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                <span data-key="t-last-update">Last Update</span>: {{ $latestAlert->time_ago }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-hover border-start border-3 border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-total-alerts">Total Alerts</h5>
                                        <h3 class="mb-0">{{ number_format($stats['total'] ?? 0) }}</h3>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-primary-subtle text-primary me-1">
                                                <span data-key="t-today">Today</span>: {{ $stats['today'] ?? 0 }}
                                            </span>
                                            <span class="text-success">
                                                <i class="fas fa-arrow-up me-1"></i>
                                                {{ $stats['yesterday_count'] ?? 0 }} <span data-key="t-yesterday">yesterday</span>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-2 text-primary">
                                            <i class="fas fa-bell"></i>
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
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-high-threat">High Threats</h5>
                                        <h3 class="mb-0">{{ number_format($stats['high_threat'] ?? 0) }}</h3>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                 style="width: {{ $stats['total'] > 0 ? ($stats['high_threat'] / $stats['total'] * 100) : 0 }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1 d-block">
                                            {{ $stats['total'] > 0 ? round($stats['high_threat'] / $stats['total'] * 100, 1) : 0 }}% <span data-key="t-of-total">of total</span>
                                        </small>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded fs-2 text-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
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
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-ai-confidence">AI Confidence</h5>
                                        <h3 class="mb-0">{{ $stats['avg_confidence'] ?? 0 }}%</h3>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                 style="width: {{ $stats['avg_confidence'] ?? 0 }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" data-key="t-average-prediction-accuracy">
                                            Average prediction accuracy
                                        </small>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-2 text-warning">
                                            <i class="fas fa-brain"></i>
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
                                        <h5 class="text-muted fw-normal mb-2" data-key="t-7-day-trend">7-Day Trend</h5>
                                        <h3 class="mb-0">{{ $stats['week_count'] ?? 0 }}</h3>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-info-subtle text-info me-1">
                                                <span data-key="t-daily-avg">Daily avg</span>: {{ $stats['week_count'] ? ceil($stats['week_count'] / 7) : 0 }}
                                            </span>
                                            <span class="text-success">
                                                <i class="fas fa-chart-line me-1"></i>
                                                <span data-key="t-active-monitoring">Active monitoring</span>
                                            </span>
                                        </p>
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

                @if($latestAlert)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-{{ $latestAlert->threat_level_color }} alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 class="alert-heading mb-0">
                                                <span data-key="t-latest-ai-alert">Latest AI Alert</span>: {{ $latestAlert->threat_level }} <span data-key="t-threat-detected">Threat Detected</span>
                                                <span class="badge bg-{{ $latestAlert->threat_level_color }} ms-2">
                                                {{ $latestAlert->confidence }}
                                            </span>
                                            </h5>
                                            <small class="text-muted">{{ $latestAlert->formatted_timestamp }}</small>
                                        </div>
                                        <p class="mb-1">{{ Str::limit($latestAlert->situation, 200) }}</p>
                                        <div class="mt-2">
                                        <span class="badge bg-light text-dark me-2">
                                            <i class="fas fa-bolt me-1"></i> {{ $latestAlert->trigger_level }}
                                        </span>
                                            <span class="badge bg-light text-dark me-2">
                                            <i class="fas fa-percentage me-1"></i> {{ $latestAlert->confidence_percentage }}% <span data-key="t-confidence">confidence</span>
                                        </span>
                                            <span class="badge bg-light text-dark">
                                            <i class="fas fa-list me-1"></i> {{ $latestAlert->likely_scenario }}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <button wire:click="viewDetails('{{ $latestAlert->id }}')"
                                                class="btn btn-{{ $latestAlert->threat_level_color }}">
                                            <i class="fas fa-search me-1"></i> <span data-key="t-view-details">View Details</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-filter me-2"></i><span data-key="t-filter-alerts">Filter Alerts</span>
                                    </h5>
                                    <div class="d-flex gap-2">
                                        <button wire:click="applyFilters" class="btn btn-sm btn-primary">
                                            <i class="fas fa-check me-1"></i> <span data-key="t-apply">Apply</span>
                                        </button>
                                        <button wire:click="resetFilters" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> <span data-key="t-clear-filters">Clear Filters</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <label class="form-label" data-key="t-threat-level">Threat Level</label>
                                        <select wire:model.live="filterLevel" class="form-select form-select-sm">
                                            <option value="all" data-key="t-all-levels">All Levels</option>
                                            @foreach($alertLevels as $level)
                                                <option value="{{ $level }}">{{ $level }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <label class="form-label" data-key="t-date-range">Date Range</label>
                                        <input type="date" wire:model.live="filterDate" class="form-control form-control-sm">
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-8">
                                        <label class="form-label" data-key="t-search-analysis">Search Analysis</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.500ms="search"
                                                   class="form-control"
                                                   placeholder="Search in situations, concerns, scenarios..."
                                                   data-key-placeholder="t-search-in-situations-concerns-scenarios">
                                            @if($search)
                                                <button wire:click="$set('search', '')" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-4 col-md-4">
                                        <label class="form-label" data-key="t-items-per-page">Items per page</label>
                                        <select wire:model.live="perPage" class="form-select form-select-sm">
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
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
                                        <i class="fas fa-history me-2"></i><span data-key="t-historical-ai-alerts">Historical AI Alerts</span>
                                    </h5>
                                    <div class="d-flex align-items-center gap-2">
                                        @if(count($selectedAlerts) > 0)
                                            <div class="me-2">
                                            <span class="badge bg-primary">
                                                {{ count($selectedAlerts) }} <span data-key="t-selected">selected</span>
                                            </span>
                                            </div>
                                            <select wire:model="bulkAction" class="form-select form-select-sm w-auto">
                                                <option value="" data-key="t-bulk-actions">Bulk Actions</option>
                                                <option value="export" data-key="t-export-selected">Export Selected</option>
                                                <option value="mark_high" data-key="t-mark-as-high-threat">Mark as High Threat</option>
                                                <option value="mark_medium" data-key="t-mark-as-medium-threat">Mark as Medium Threat</option>
                                                <option value="mark_reviewed" data-key="t-mark-as-reviewed">Mark as Reviewed</option>
                                            </select>
                                            <button wire:click="applyBulkAction"
                                                    class="btn btn-sm btn-primary"
                                                    wire:loading.attr="disabled">
                                                <span data-key="t-apply">Apply</span>
                                            </button>
                                        @endif
                                        <button wire:click="showExportModal"
                                                class="btn btn-sm btn-success">
                                            <i class="fas fa-file-export me-1"></i> <span data-key="t-export">Export</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 text-muted" data-key="t-loading-threat-analysis-data">Loading threat analysis data...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th width="50" class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" wire:model="selectAll" wire:change="toggleSelectAll">
                                                    </div>
                                                </th>
                                                <th width="80">
                                                    <a href="#" wire:click.prevent="sortBy('id')" class="text-dark">
                                                        <span data-key="t-id">ID</span>
                                                        @if($sortField === 'id')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a href="#" wire:click.prevent="sortBy('ai_timestamp')" class="text-dark">
                                                        <span data-key="t-time">Time</span>
                                                        @if($sortField === 'ai_timestamp')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th>
                                                    <a href="#" wire:click.prevent="sortBy('threat_level')" class="text-dark">
                                                        <span data-key="t-threat-level">Threat Level</span>
                                                        @if($sortField === 'threat_level')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th><span data-key="t-situation-summary">Situation Summary</span></th>
                                                <th><span data-key="t-primary-concern">Primary Concern</span></th>
                                                <th>
                                                    <a href="#" wire:click.prevent="sortBy('ai_confidence_score')" class="text-dark">
                                                        <span data-key="t-ai-confidence">AI Confidence</span>
                                                        @if($sortField === 'ai_confidence_score')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th width="120" class="text-center"><span data-key="t-actions">Actions</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($alerts as $alert)
                                                <tr class="{{ $alert->threat_level === 'HIGH' ? 'table-danger' : '' }}">
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{ $alert->id }}" wire:model="selectedAlerts">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">#{{ $alert->id }}</span>
                                                        @if($alert->analysis_id)
                                                            <small class="d-block text-muted">{{ $alert->analysis_id }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ $alert->ai_timestamp->format('M d, Y') }}</div>
                                                        <small class="text-muted">{{ $alert->ai_timestamp->format('H:i') }}</small>
                                                        <div class="text-muted small">{{ $alert->time_ago }}</div>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $alert->threat_level_color }} px-2 py-1">
                                                        <i class="fas fa-shield-alt me-1"></i>
                                                        {{ $alert->threat_level }}
                                                    </span>
                                                        <div class="text-muted small mt-1">{{ $alert->trigger_level }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium text-truncate" style="max-width: 250px;"
                                                             title="{{ $alert->situation }}">
                                                            {{ $alert->situation }}
                                                        </div>
                                                        @if($alert->likely_scenario)
                                                            <small class="text-muted d-block mt-1">
                                                                <i class="fas fa-project-diagram me-1"></i>
                                                                {{ $alert->likely_scenario }}
                                                            </small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate" style="max-width: 200px;">
                                                            {{ $alert->primary_concern }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $alert->ai_confidence_score > 0.7 ? 'success' : ($alert->ai_confidence_score > 0.4 ? 'warning' : 'danger') }}"
                                                                     style="width: {{ $alert->ai_confidence_score * 100 }}%"
                                                                     role="progressbar">
                                                                </div>
                                                            </div>
                                                            <span class="fw-medium">{{ $alert->confidence_percentage }}%</span>
                                                        </div>
                                                        <small class="text-muted d-block mt-1">{{ $alert->confidence }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <button wire:click="viewDetails('{{ $alert->id }}')"
                                                                    class="btn btn-outline-primary"
                                                                    title="View Details"
                                                                    data-key-title="t-view-details">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button wire:click="exportSingleAlert('{{ $alert->id }}')"
                                                                    class="btn btn-outline-secondary"
                                                                    title="Export as PDF"
                                                                    data-key-title="t-export-as-pdf">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-5">
                                                        <div class="text-muted">
                                                            <i class="fas fa-robot fa-3x mb-3 opacity-25"></i>
                                                            <h5 class="mb-2" data-key="t-no-threat-analysis-found">No Threat Analysis Found</h5>
                                                            <p class="mb-0" data-key="t-try-adjusting-your-filters-or-refresh-the-data">Try adjusting your filters or refresh the data</p>
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

                            @if($alerts->hasPages() || $alerts->total() > 0)
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">
                                                <span data-key="t-showing">Showing</span> {{ $alerts->firstItem() ?? 0 }} <span data-key="t-to">to</span> {{ $alerts->lastItem() ?? 0 }}
                                                <span data-key="t-of">of</span> {{ $alerts->total() }} <span data-key="t-entries">entries</span>
                                            </small>
                                        </div>
                                        <div>
                                            {{ $alerts->links('livewire::bootstrap') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if(!empty($stats['level_distribution']) || !empty($stats['trends']))
                    <div class="row mt-4">
                        @if(!empty($stats['level_distribution']))
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-pie me-2"></i><span data-key="t-threat-level-distribution">Threat Level Distribution</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="threat-chart" style="min-height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(!empty($stats['trends']))
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-line me-2"></i><span data-key="t-7-day-alert-trends">7-Day Alert Trends</span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="trend-chart" style="min-height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($showDetailsModal && $alertDetails)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-{{ $alertDetails->threat_level_color }} text-white">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-file-alt me-2"></i>
                            <span data-key="t-ai-threat-analysis-details">AI Threat Analysis Details</span>
                            <span class="badge bg-white text-dark ms-2"><span data-key="t-id">ID</span>: {{ $alertDetails->analysis_id ?? $alertDetails->id }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted d-block" data-key="t-analysis-time">Analysis Time</small>
                                                <h6 class="mb-2">{{ $alertDetails->formatted_timestamp }}</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted d-block" data-key="t-trigger-level">Trigger Level</small>
                                                <span class="badge bg-info">{{ $alertDetails->trigger_level }}</span>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <small class="text-muted d-block" data-key="t-ai-confidence">AI Confidence</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar bg-success"
                                                             style="width: {{ $alertDetails->confidence_percentage }}%"></div>
                                                    </div>
                                                    <strong>{{ $alertDetails->confidence_percentage }}%</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <small class="text-muted d-block" data-key="t-response-length">Response Length</small>
                                                <strong>{{ number_format($alertDetails->ai_response_length) }} <span data-key="t-chars">chars</span></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-{{ $alertDetails->threat_level_color }}-subtle">
                                    <div class="card-body text-center">
                                        <div class="display-4 fw-bold text-{{ $alertDetails->threat_level_color }}">
                                            {{ $alertDetails->threat_level }}
                                        </div>
                                        <div class="mt-2">
                                        <span class="badge bg-{{ $alertDetails->confidence === 'HIGH' ? 'danger' : 'warning' }}">
                                            {{ $alertDetails->confidence }} <span data-key="t-confidence">Confidence</span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion" id="analysisAccordion">
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#situationCollapse">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong data-key="t-situation-analysis">Situation Analysis</strong>
                                    </button>
                                </h2>
                                <div id="situationCollapse" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="alert alert-light">
                                            {{ $alertDetails->situation }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#concernsCollapse">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong data-key="t-threat-concerns">Threat Concerns</strong>
                                    </button>
                                </h2>
                                <div id="concernsCollapse" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h6 class="text-muted mb-2" data-key="t-primary-concern">Primary Concern</h6>
                                                <div class="card border-warning">
                                                    <div class="card-body">
                                                        {{ $alertDetails->primary_concern }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h6 class="text-muted mb-2" data-key="t-secondary-concerns">Secondary Concerns</h6>
                                                <div class="card border-secondary">
                                                    <div class="card-body">
                                                        {{ $alertDetails->secondary_concerns ?? 'No secondary concerns identified' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#scenarioCollapse">
                                        <i class="fas fa-project-diagram me-2"></i>
                                        <strong data-key="t-scenario-forecast">Scenario & Forecast</strong>
                                    </button>
                                </h2>
                                <div id="scenarioCollapse" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h6 class="text-muted mb-2" data-key="t-likely-scenario">Likely Scenario</h6>
                                                <div class="card bg-warning-subtle">
                                                    <div class="card-body">
                                                        <h5 class="text-warning">{{ $alertDetails->likely_scenario }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h6 class="text-muted mb-2" data-key="t-forecast">Forecast</h6>
                                                <div class="card bg-info-subtle">
                                                    <div class="card-body">
                                                        {{ $alertDetails->forecast }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#recommendationsCollapse">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        <strong data-key="t-ai-recommendations">AI Recommendations</strong>
                                    </button>
                                </h2>
                                <div id="recommendationsCollapse" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="card bg-success-subtle">
                                            <div class="card-body">
                                                <div class="recommendations">
                                                    {!! nl2br(e($alertDetails->recommendations)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($alertDetails->ai_analysis_raw)
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rawCollapse">
                                            <i class="fas fa-code me-2"></i>
                                            <strong data-key="t-raw-ai-analysis">Raw AI Analysis</strong>
                                        </button>
                                    </h2>
                                    <div id="rawCollapse" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <pre class="mb-0 bg-dark text-light p-3 rounded" style="font-size: 12px; max-height: 300px; overflow: auto;">{{ $alertDetails->ai_analysis_raw }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            <i class="fas fa-times me-1"></i> <span data-key="t-close">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="exportSingleAlert('{{ $alertDetails->id }}')">
                            <i class="fas fa-file-pdf me-1"></i> <span data-key="t-export-as-pdf">Export as PDF</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showExportModal)
        <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-file-export me-2"></i>
                            <span data-key="t-export-data">Export Data</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('showExportModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="exportData">
                            <div class="mb-3">
                                <label class="form-label" data-key="t-export-format">Export Format</label>
                                <select wire:model="exportType" class="form-select">
                                    <option value="excel" data-key="t-excel">Excel (.xlsx)</option>
                                    <option value="csv" data-key="t-csv">CSV (.csv)</option>
                                    <option value="pdf" data-key="t-pdf">PDF (.pdf)</option>
                                    <option value="json" data-key="t-json">JSON (.json)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" data-key="t-data-range">Data Range</label>
                                <select wire:model="exportRange" class="form-select">
                                    <option value="current" data-key="t-current-filtered-results">Current Filtered Results ({{ $alerts->total() }} records)</option>
                                    <option value="selected" data-key="t-selected-items">Selected Items ({{ count($selectedAlerts) }} records)</option>
                                    <option value="all" data-key="t-all-records">All Records ({{ $stats['total'] ?? 0 }} records)</option>
                                    <option value="today" data-key="t-todays-alerts">Today's Alerts ({{ $stats['today'] ?? 0 }} records)</option>
                                    <option value="last7days" data-key="t-last-7-days">Last 7 Days ({{ $stats['week_count'] ?? 0 }} records)</option>
                                    <option value="last30days" data-key="t-last-30-days">Last 30 Days</option>
                                </select>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>
                                    <span data-key="t-exporting">Exporting</span>
                                    @if($exportRange === 'current')
                                        {{ $alerts->total() }} <span data-key="t-filtered-records">filtered records</span>
                                    @elseif($exportRange === 'selected')
                                        {{ count($selectedAlerts) }} <span data-key="t-selected-records">selected records</span>
                                    @elseif($exportRange === 'today')
                                        {{ $stats['today'] ?? 0 }} <span data-key="t-todays-alerts">today's alerts</span>
                                    @elseif($exportRange === 'last7days')
                                        {{ $stats['week_count'] ?? 0 }} <span data-key="t-alerts-from-last-7-days">alerts from last 7 days</span>
                                    @else
                                        {{ $stats['total'] ?? 0 }} <span data-key="t-records">records</span>
                                    @endif
                                </small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary" wire:click="$set('showExportModal', false)">
                                    <span data-key="t-cancel">Cancel</span>
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-download me-1"></i> <span data-key="t-download-export">Download Export</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', function() {
            initCharts();

            Livewire.on('alert-refreshed', function() {
                setTimeout(initCharts, 500);
            });

            function initCharts() {
                const threatData = @json($stats['level_distribution'] ?? []);
                if (Object.keys(threatData).length > 0) {
                    const threatChartEl = document.getElementById("threat-chart");
                    if (threatChartEl) {
                        const threatChart = new ApexCharts(threatChartEl, {
                            series: Object.values(threatData),
                            chart: {
                                type: 'donut',
                                height: 350,
                                toolbar: { show: true }
                            },
                            labels: Object.keys(threatData),
                            colors: ['#dc3545', '#ffc107', '#28a745', '#6c757d', '#0d6efd'],
                            legend: {
                                position: 'bottom',
                                horizontalAlign: 'center'
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '65%',
                                        labels: {
                                            show: true,
                                            name: {
                                                fontSize: '14px'
                                            },
                                            value: {
                                                fontSize: '20px',
                                                fontWeight: 'bold',
                                                formatter: function(val) {
                                                    return val;
                                                }
                                            },
                                            total: {
                                                show: true,
                                                label: getTranslation('t-total-alerts'),
                                                color: '#6c757d',
                                                formatter: function(w) {
                                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val, opts) {
                                    return opts.w.globals.labels[opts.seriesIndex] + ': ' + val;
                                },
                                style: {
                                    fontSize: '12px',
                                    fontWeight: 'normal'
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + ' ' + getTranslation('t-alerts');
                                    }
                                }
                            }
                        });
                        threatChart.render();
                    }
                }

                const trendData = @json($stats['trends'] ?? []);
                if (trendData.length > 0) {
                    const trendChartEl = document.getElementById("trend-chart");
                    if (trendChartEl) {
                        const dates = trendData.map(item => item.date);
                        const counts = trendData.map(item => item.count);
                        const confidence = trendData.map(item => item.avg_confidence || 0);

                        const trendChart = new ApexCharts(trendChartEl, {
                            series: [
                                {
                                    name: getTranslation('t-number-of-alerts'),
                                    type: 'column',
                                    data: counts
                                },
                                {
                                    name: getTranslation('t-avg-confidence') + ' %',
                                    type: 'line',
                                    data: confidence
                                }
                            ],
                            chart: {
                                height: 350,
                                type: 'line',
                                toolbar: { show: true }
                            },
                            stroke: {
                                width: [0, 3],
                                curve: 'smooth'
                            },
                            colors: ['#0d6efd', '#20c997'],
                            dataLabels: {
                                enabled: false
                            },
                            xaxis: {
                                categories: dates.map(date => {
                                    const d = new Date(date);
                                    return d.toLocaleDateString('en-US', {
                                        weekday: 'short',
                                        month: 'short',
                                        day: 'numeric'
                                    });
                                })
                            },
                            yaxis: [
                                {
                                    title: {
                                        text: getTranslation('t-number-of-alerts')
                                    }
                                },
                                {
                                    opposite: true,
                                    title: {
                                        text: getTranslation('t-confidence') + ' %'
                                    },
                                    min: 0,
                                    max: 100
                                }
                            ],
                            fill: {
                                opacity: [0.85, 1]
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                y: {
                                    formatter: function(y) {
                                        if (typeof y !== "undefined") {
                                            return y.toFixed(0) + (y > 1 ? ' ' + getTranslation('t-alerts') : ' ' + getTranslation('t-alert'));
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

            // Helper function to get translation
            function getTranslation(key) {
                return window.translations && window.translations[key] ? window.translations[key] : key;
            }

            let refreshInterval;

            Livewire.on('start-auto-refresh', (data) => {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
                refreshInterval = setInterval(() => {
                    @this.refreshData();
                }, data.interval * 1000);
            });

            Livewire.on('stop-auto-refresh', () => {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('user/assets/css/pages/ai-threat-analysis.css') }}" />
@endpush
