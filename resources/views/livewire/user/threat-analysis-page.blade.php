<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-robot me-2"></i>AI Threat Analysis
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-sync-alt fa-spin me-1" wire:loading wire:target="refreshData"></i>
                                    Last Updated: {{ $latestAlert ? \Carbon\Carbon::parse($latestAlert->ai_timestamp)->diffForHumans() : 'N/A' }}
                                </span>
                                <button wire:click="refreshData" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-redo"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0">AI-powered threat assessment and predictive analysis</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Total AI Alerts</p>
                                        <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-primary bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-primary me-1">Today: {{ $stats['today'] ?? 0 }}</span>
                                        <span class="text-success">AI Confidence: {{ $stats['avg_confidence'] ?? 0 }}%</span>
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
                                        <p class="text-muted mb-1">High Threat Alerts</p>
                                        <h3 class="mb-0">{{ $stats['high_threat'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-danger bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: {{ $stats['total'] > 0 ? ($stats['high_threat'] / $stats['total'] * 100) : 0 }}%">
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
                                        <p class="text-muted mb-1">Latest Threat Level</p>
                                        <h3 class="mb-0">
                                            @if($latestAlert)
                                                <span class="badge bg-{{ strtolower($latestAlert->threat_level) === 'high' ? 'danger' : 'warning' }}">
                                                    {{ $latestAlert->threat_level ?? 'N/A' }}
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 text-muted">
                                        @if($latestAlert)
                                            <small>Trigger: {{ $latestAlert->trigger_level }}</small>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-success bg-opacity-10 border-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">AI Confidence</p>
                                        <h3 class="mb-0">{{ $stats['avg_confidence'] ?? 0 }}%</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-success bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-brain"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{ $stats['avg_confidence'] ?? 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($latestAlert)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-{{ strtolower($latestAlert->threat_level) === 'high' ? 'danger' : 'warning' }}">
                                <div class="card-header bg-{{ strtolower($latestAlert->threat_level) === 'high' ? 'danger' : 'warning' }} bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            Latest AI Alert
                                            <span class="badge bg-{{ strtolower($latestAlert->threat_level) === 'high' ? 'danger' : 'warning' }} ms-2">
                                            {{ $latestAlert->threat_level }}
                                        </span>
                                        </h5>
                                        <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($latestAlert->ai_timestamp)->format('M d, Y H:i:s') }}
                                    </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="text-muted mb-2">SITUATION:</h6>
                                            <p class="mb-3">{{ Str::limit($latestAlert->situation, 300) }}</p>

                                            <h6 class="text-muted mb-2">PRIMARY CONCERN:</h6>
                                            <p class="mb-3">{{ $latestAlert->primary_concern }}</p>

                                            <div class="d-flex gap-2">
                                            <span class="badge bg-info">
                                                Trigger: {{ $latestAlert->trigger_level }}
                                            </span>
                                                <span class="badge bg-{{ $latestAlert->confidence === 'HIGH' ? 'danger' : 'warning' }}">
                                                Confidence: {{ $latestAlert->confidence }}
                                            </span>
                                                <span class="badge bg-secondary">
                                                AI Score: {{ round($latestAlert->ai_confidence_score * 100) }}%
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted mb-3">QUICK ANALYSIS</h6>

                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Likely Scenario</small>
                                                        <strong>{{ $latestAlert->likely_scenario }}</strong>
                                                    </div>

                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Forecast</small>
                                                        <small>{{ Str::limit($latestAlert->forecast, 100) }}</small>
                                                    </div>

                                                    <button wire:click="viewDetails('{{ $latestAlert->id }}')"
                                                            class="btn btn-sm btn-outline-primary w-100">
                                                        <i class="fas fa-search me-1"></i> View Full Analysis
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Threat Level</label>
                                        <select wire:model.live="filterLevel" class="form-select">
                                            <option value="all">All Levels</option>
                                            @foreach($alertLevels as $level)
                                                <option value="{{ $level }}">{{ $level }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" wire:model.live="filterDate" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Search Analysis</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                   class="form-control" placeholder="Search in situations, concerns...">
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Historical AI Alerts</h5>
                                    <span class="badge bg-light text-dark">
                                        {{ count($alerts) }} records
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading AI analysis...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th width="80">ID</th>
                                                <th>Analysis Time</th>
                                                <th>Situation Summary</th>
                                                <th>Threat Level</th>
                                                <th>Primary Concern</th>
                                                <th>AI Confidence</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($alerts as $alert)
                                                <tr class="{{ $alert->threat_level === 'HIGH' ? 'table-danger' : '' }}">
                                                    <td>
                                                        <small class="text-muted">#{{ $alert->id }}</small>
                                                    </td>
                                                    <td>
                                                        <div>{{ \Carbon\Carbon::parse($alert->ai_timestamp)->format('M d, Y') }}</div>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($alert->ai_timestamp)->format('H:i:s') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ Str::limit($alert->situation, 100) }}</div>
                                                        <small class="text-muted">{{ $alert->trigger_level }}</small>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ strtolower($alert->threat_level) === 'high' ? 'danger' : 'warning' }}">
                                                        {{ $alert->threat_level }}
                                                    </span>
                                                    </td>
                                                    <td>
                                                        <div>{{ Str::limit($alert->primary_concern, 80) }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                                <div class="progress-bar bg-{{ $alert->ai_confidence_score > 0.7 ? 'success' : 'warning' }}"
                                                                     style="width: {{ $alert->ai_confidence_score * 100 }}%"></div>
                                                            </div>
                                                            <span>{{ round($alert->ai_confidence_score * 100) }}%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button wire:click="viewDetails('{{ $alert->id }}')"
                                                                class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-robot fa-2x mb-2"></i>
                                                            <p>No AI threat analysis available</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            @if(count($alerts) > 0)
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Showing {{ count($alerts) }} most recent alerts
                                        </small>
                                        <button wire:click="refreshData" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if(!empty($stats['level_distribution']))
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Threat Level Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="height: 250px;">
                                        <div id="threat-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Recent Alert Trends (7 Days)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="height: 250px;">
                                        <div id="trend-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($showDetailsModal && $alertDetails)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-{{ strtolower($alertDetails->threat_level) === 'high' ? 'danger' : 'warning' }} text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-file-alt me-2"></i>
                            AI Threat Analysis Details
                            <span class="badge bg-light text-dark ms-2">ID: {{ $alertDetails->analysis_id }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">ANALYSIS METADATA</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Analysis Time</small>
                                                <strong>{{ \Carbon\Carbon::parse($alertDetails->ai_timestamp)->format('Y-m-d H:i:s') }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Trigger Level</small>
                                                <span class="badge bg-info">{{ $alertDetails->trigger_level }}</span>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <small class="text-muted d-block">AI Confidence</small>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-success"
                                                             style="width: {{ $alertDetails->ai_confidence_score * 100 }}%"></div>
                                                    </div>
                                                    <strong>{{ round($alertDetails->ai_confidence_score * 100) }}%</strong>
                                                </div>
                                            </div>
                                            <div class="col-6 mt-2">
                                                <small class="text-muted d-block">Response Length</small>
                                                <strong>{{ $alertDetails->ai_response_length }} chars</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-{{ strtolower($alertDetails->threat_level) === 'high' ? 'danger' : 'warning' }} bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">THREAT ASSESSMENT</h6>
                                        <div class="text-center">
                                            <div class="display-4 fw-bold text-{{ strtolower($alertDetails->threat_level) === 'high' ? 'danger' : 'warning' }}">
                                                {{ $alertDetails->threat_level }}
                                            </div>
                                            <div class="mt-2">
                                            <span class="badge bg-{{ $alertDetails->confidence === 'HIGH' ? 'danger' : 'warning' }}">
                                                Confidence: {{ $alertDetails->confidence }}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Analysis Sections -->
                        <div class="analysis-section mb-4">
                            <h6 class="text-muted mb-2 border-bottom pb-2">SITUATION ANALYSIS</h6>
                            <div class="card">
                                <div class="card-body">
                                    <p class="mb-0">{{ $alertDetails->situation }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="analysis-section">
                                    <h6 class="text-muted mb-2 border-bottom pb-2">PRIMARY CONCERN</h6>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $alertDetails->primary_concern }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="analysis-section">
                                    <h6 class="text-muted mb-2 border-bottom pb-2">SECONDARY CONCERNS</h6>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $alertDetails->secondary_concerns }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="analysis-section">
                                    <h6 class="text-muted mb-2 border-bottom pb-2">LIKELY SCENARIO</h6>
                                    <div class="card bg-warning bg-opacity-10">
                                        <div class="card-body">
                                            <h5 class="text-warning">{{ $alertDetails->likely_scenario }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="analysis-section">
                                    <h6 class="text-muted mb-2 border-bottom pb-2">FORECAST</h6>
                                    <div class="card bg-info bg-opacity-10">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $alertDetails->forecast }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="analysis-section">
                            <h6 class="text-muted mb-2 border-bottom pb-2">AI RECOMMENDATIONS</h6>
                            <div class="card bg-success bg-opacity-10">
                                <div class="card-body">
                                    <div class="recommendations">
                                        {!! nl2br(e($alertDetails->recommendations)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="analysis-section mt-4">
                            <button class="btn btn-sm btn-outline-secondary w-100"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#rawAnalysis">
                                <i class="fas fa-code me-1"></i> View Raw AI Analysis
                            </button>
                            <div class="collapse mt-2" id="rawAnalysis">
                                <div class="card">
                                    <div class="card-body">
                                        <pre class="mb-0" style="font-size: 12px; max-height: 300px; overflow: auto;">{{ $alertDetails->ai_analysis_raw }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <button type="button" class="btn btn-primary">
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

                Livewire.on('alert-refreshed', function() {
                    setTimeout(initCharts, 500);
                });

                setTimeout(initCharts, 1000);

                function initCharts() {

                    const threatData = @json($stats['level_distribution'] ?? []);
                    if (Object.keys(threatData).length > 0) {
                        const threatChart = new ApexCharts(document.querySelector("#threat-chart"), {
                            series: Object.values(threatData),
                            chart: {
                                type: 'donut',
                                height: 250
                            },
                            labels: Object.keys(threatData),
                            colors: ['#0d6efd', '#fd7e14', '#dc3545', '#6c757d'],
                            legend: {
                                position: 'bottom'
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '65%',
                                        labels: {
                                            show: true,
                                            total: {
                                                show: true,
                                                label: 'Total',
                                                color: '#6c757d'
                                            }
                                        }
                                    }
                                }
                            }
                        });
                        threatChart.render();
                    }

                    const trendData = @json($stats['trends'] ?? []);
                    if (trendData.length > 0) {
                        const dates = trendData.map(item => item.date);
                        const counts = trendData.map(item => item.count);

                        const trendChart = new ApexCharts(document.querySelector("#trend-chart"), {
                            series: [{
                                name: 'Alerts',
                                data: counts
                            }],
                            chart: {
                                type: 'area',
                                height: 250,
                                toolbar: {
                                    show: false
                                }
                            },
                            colors: ['#0d6efd'],
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            xaxis: {
                                categories: dates,
                                labels: {
                                    formatter: function(value) {
                                        return new Date(value).toLocaleDateString('en-US', {
                                            month: 'short',
                                            day: 'numeric'
                                        });
                                    }
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Number of Alerts'
                                }
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.1,
                                    stops: [0, 90, 100]
                                }
                            }
                        });
                        trendChart.render();
                    }
                }
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            .analysis-section {
                margin-bottom: 1.5rem;
            }
            .recommendations {
                white-space: pre-line;
            }
            .modal-content {
                max-height: 85vh;
            }
            .modal-body {
                max-height: 60vh;
                overflow-y: auto;
            }
            .chart-container {
                position: relative;
            }
            .bg-opacity-10 {
                background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
            }
            .bg-danger.bg-opacity-10 {
                background-color: rgba(220, 53, 69, 0.1) !important;
            }
            .bg-warning.bg-opacity-10 {
                background-color: rgba(255, 193, 7, 0.1) !important;
            }
            .bg-success.bg-opacity-10 {
                background-color: rgba(25, 135, 84, 0.1) !important;
            }
            .bg-info.bg-opacity-10 {
                background-color: rgba(13, 202, 240, 0.1) !important;
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
        </style>
    @endpush
</div>
