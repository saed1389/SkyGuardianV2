<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-file-alt me-2"></i>Reports
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                                </span>
                                <button wire:click="applyDateRange" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Generate detailed security and analysis reports</p>
                    </div>
                </div>

                <!-- Report Statistics -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-primary">{{ $stats['total_analyses'] ?? 0 }}</div>
                                <small class="text-muted">Analyses</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-danger">{{ $stats['total_military'] ?? 0 }}</div>
                                <small class="text-muted">Military Aircraft</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-warning">{{ $stats['total_drones'] ?? 0 }}</div>
                                <small class="text-muted">Drones</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-info bg-opacity-10 border-info">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-info">{{ round($stats['avg_anomaly_score'] ?? 0) }}</div>
                                <small class="text-muted">Avg Anomaly Score</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-success bg-opacity-10 border-success">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-success">{{ $stats['high_risk_count'] ?? 0 }}</div>
                                <small class="text-muted">High Risk Days</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-secondary bg-opacity-10 border-secondary">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-secondary">{{ $stats['max_aircraft'] ?? 0 }}</div>
                                <small class="text-muted">Max Aircraft</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date Range & Filters -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" wire:model.live="startDate" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">End Date</label>
                                        <input type="date" wire:model.live="endDate" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Country Filter</label>
                                        <select wire:model.live="reportFilterCountry" class="form-select">
                                            <option value="all">All Countries</option>
                                            @foreach($countryOptions as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button wire:click="applyDateRange" class="btn btn-primary w-100">
                                            <i class="fas fa-filter me-1"></i> Apply
                                        </button>
                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Types -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3">Generate Report</h5>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card report-type-card" wire:click="generateReport('daily')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-primary bg-opacity-20 rounded fs-24">
                                                <i class="fas fa-calendar-day text-primary"></i>
                                            </div>
                                        </div>
                                        <h6 class="mb-1">Daily Summary</h6>
                                        <small class="text-muted">Daily activity overview</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card report-type-card" wire:click="generateReport('military')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-danger bg-opacity-20 rounded fs-24">
                                                <i class="fas fa-fighter-jet text-danger"></i>
                                            </div>
                                        </div>
                                        <h6 class="mb-1">Military Activity</h6>
                                        <small class="text-muted">Military aircraft analysis</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card report-type-card" wire:click="generateReport('threat')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-warning bg-opacity-20 rounded fs-24">
                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                            </div>
                                        </div>
                                        <h6 class="mb-1">Threat Analysis</h6>
                                        <small class="text-muted">Threat assessment report</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card report-type-card" wire:click="generateReport('aircraft')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-info bg-opacity-20 rounded fs-24">
                                                <i class="fas fa-plane text-info"></i>
                                            </div>
                                        </div>
                                        <h6 class="mb-1">Aircraft Statistics</h6>
                                        <small class="text-muted">Aircraft database analysis</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card report-type-card" wire:click="generateReport('comprehensive')" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-success bg-opacity-20 rounded fs-24">
                                                <i class="fas fa-file-contract text-success"></i>
                                            </div>
                                        </div>
                                        <h6 class="mb-1">Comprehensive</h6>
                                        <small class="text-muted">Full security report</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <div class="avatar-sm mx-auto mb-3">
                                            <div class="avatar-title bg-secondary bg-opacity-20 rounded fs-24">
                                                <i class="fas fa-cog text-secondary"></i>
                                            </div>
                                        </div>
                                        <h6 class="mb-1">Custom Report</h6>
                                        <small class="text-muted">Coming Soon</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Analysis Reports</h5>
                                    <span class="badge bg-light text-dark">
                                        {{ count($reports) }} reports
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading reports...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th>Date & Time</th>
                                                <th>Analysis ID</th>
                                                <th>Aircraft Summary</th>
                                                <th>Risk Level</th>
                                                <th>Anomaly Score</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($reports as $report)
                                                <tr class="{{ $report->overall_risk === 'HIGH' ? 'table-danger' : ($report->overall_risk === 'MEDIUM' ? 'table-warning' : '') }}">
                                                    <td>
                                                        <div>{{ \Carbon\Carbon::parse($report->analysis_time)->format('M d, Y') }}</div>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($report->analysis_time)->format('H:i:s') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="font-monospace">{{ Str::limit($report->analysis_id, 15) }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1">
                                                            <span class="badge bg-primary">{{ $report->total_aircraft }} total</span>
                                                            <span class="badge bg-danger">{{ $report->military_aircraft }} military</span>
                                                            <span class="badge bg-warning">{{ $report->drones }} drones</span>
                                                            <span class="badge bg-dark">{{ $report->high_threat_aircraft }} high threat</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $report->overall_risk === 'HIGH' ? 'danger' : ($report->overall_risk === 'MEDIUM' ? 'warning' : 'success') }}">
                                                        {{ $report->overall_risk }}
                                                    </span>
                                                        <div class="small text-muted">Severity: {{ $report->severity }}/5</div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $report->anomaly_score > 50 ? 'danger' : ($report->anomaly_score > 30 ? 'warning' : 'success') }}"
                                                                     style="width: {{ min(100, $report->anomaly_score) }}%"></div>
                                                            </div>
                                                            <strong>{{ $report->anomaly_score }}</strong>
                                                        </div>
                                                        <small class="text-muted">Composite: {{ $report->composite_score }}</small>
                                                    </td>
                                                    <td>
                                                    <span class="badge bg-{{ $report->status === 'ACTIVE' ? 'success' : 'secondary' }}">
                                                        {{ $report->status }}
                                                    </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button wire:click="generateReport('daily')"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button wire:click="exportReport('pdf')"
                                                                    class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                                                            <p>No reports found for the selected date range</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            @if(count($reports) > 0)
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Showing {{ count($reports) }} reports •
                                            Date range: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                                        </small>
                                        <button wire:click="applyDateRange" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Charts -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Daily Aircraft Count</h5>
                            </div>
                            <div class="card-body">
                                <div id="aircraft-chart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Risk Level Distribution</h5>
                            </div>
                            <div class="card-body">
                                <div id="risk-chart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Modal -->
    @if($showReportModal && $reportData)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-file-pdf me-2"></i>
                            {{ $reportData['type'] ?? 'Report' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeReport"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Report Header -->
                        <div class="report-header mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>{{ $reportData['type'] ?? 'Security Report' }}</h4>
                                    <p class="text-muted mb-1">Period: {{ $reportData['period'] ?? 'N/A' }}</p>
                                    <p class="text-muted">Generated: {{ $reportData['generated_at'] ?? now()->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="d-flex flex-column align-items-end">
                                        <span class="badge bg-primary fs-6 mb-2">CONFIDENTIAL</span>
                                        <small class="text-muted">SkyGuardian System Report</small>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>

                        <!-- Executive Summary (for comprehensive reports) -->
                        @if(isset($reportData['executive_summary']))
                            <div class="executive-summary mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-2">EXECUTIVE SUMMARY</h6>
                                        <p class="mb-0">{{ $reportData['executive_summary'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Report Content based on type -->
                        @switch($activeReportType)
                            @case('daily')
                                @include('livewire.user.reports.daily', ['data' => $reportData])
                                @break

                            @case('military')
                                @include('livewire.user.reports.military', ['data' => $reportData])
                                @break

                            @case('threat')
                                @include('livewire.user.reports.threat', ['data' => $reportData])
                                @break

                            @case('aircraft')
                                @include('livewire.user.reports.aircraft', ['data' => $reportData])
                                @break

                            @case('comprehensive')
                                @include('livewire.user.reports.comprehensive', ['data' => $reportData])
                                @break

                            @default
                                @include('livewire.user.reports.daily', ['data' => $reportData])
                        @endswitch

                        <!-- Report Footer -->
                        <div class="report-footer mt-4 pt-4 border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        This report is generated by SkyGuardian Air Traffic Monitoring System
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        Page 1 of 1 • Document ID: {{ Str::random(10) }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeReport">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" wire:click="exportReport('pdf')">
                                <i class="fas fa-file-pdf me-1"></i> Export PDF
                            </button>
                            <button type="button" class="btn btn-success" wire:click="exportReport('excel')">
                                <i class="fas fa-file-excel me-1"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-info" wire:click="exportReport('csv')">
                                <i class="fas fa-file-csv me-1"></i> Export CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Create Report Include Files -->
    @php
        // Create report view includes dynamically if they don't exist
        // For now, we'll create them inline
    @endphp

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:initialized', function() {
                // Initialize charts
                setTimeout(initReportCharts, 1000);

                // Refresh charts when date range changes
                Livewire.on('date-range-changed', function() {
                    setTimeout(initReportCharts, 500);
                });

                function initReportCharts() {
                    // Daily Aircraft Chart
                    const aircraftData = @json($reports ?? []);
                    if (aircraftData.length > 0) {
                        const dates = aircraftData.map(r => new Date(r.analysis_time).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                        const counts = aircraftData.map(r => r.total_aircraft);

                        const aircraftChart = new ApexCharts(document.querySelector("#aircraft-chart"), {
                            series: [{
                                name: 'Aircraft Count',
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
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.1,
                                    stops: [0, 90, 100]
                                }
                            },
                            xaxis: {
                                categories: dates
                            },
                            yaxis: {
                                title: {
                                    text: 'Aircraft Count'
                                }
                            }
                        });
                        aircraftChart.render();
                    }

                    // Risk Distribution Chart
                    const riskData = @json($reports ?? []);
                    if (riskData.length > 0) {
                        const riskCounts = {
                            'HIGH': riskData.filter(r => r.overall_risk === 'HIGH').length,
                            'MEDIUM': riskData.filter(r => r.overall_risk === 'MEDIUM').length,
                            'LOW': riskData.filter(r => r.overall_risk === 'LOW').length
                        };

                        const riskChart = new ApexCharts(document.querySelector("#risk-chart"), {
                            series: Object.values(riskCounts),
                            chart: {
                                type: 'donut',
                                height: 250
                            },
                            labels: Object.keys(riskCounts),
                            colors: ['#dc3545', '#fd7e14', '#198754'],
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
                        riskChart.render();
                    }
                }
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            .report-type-card {
                transition: all 0.2s ease;
                border: 2px solid transparent;
            }
            .report-type-card:hover {
                border-color: var(--bs-primary);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
            .bg-info.bg-opacity-10 {
                background-color: rgba(13, 202, 240, 0.1) !important;
            }
            .bg-success.bg-opacity-10 {
                background-color: rgba(25, 135, 84, 0.1) !important;
            }
            .avatar-sm {
                width: 50px;
                height: 50px;
            }
            .avatar-title {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
            }
            .fs-24 {
                font-size: 24px;
            }
            .modal-content {
                max-height: 85vh;
            }
            .modal-body {
                max-height: 65vh;
                overflow-y: auto;
            }
            .report-header {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .executive-summary {
                border-left: 4px solid #0d6efd;
                padding-left: 15px;
            }
            .table-danger {
                background-color: rgba(220, 53, 69, 0.05) !important;
            }
            .table-warning {
                background-color: rgba(255, 193, 7, 0.05) !important;
            }
        </style>
    @endpush

    <!-- Inline Report Templates -->
    @if($showReportModal && $reportData)
        <div wire:ignore>
            <!-- Daily Report Template -->
            @if($activeReportType === 'daily')
                <div id="daily-report-template" style="display: none;">
                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">DAILY SUMMARY STATISTICS</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Analyses</th>
                                    <th>Avg Aircraft</th>
                                    <th>Avg Military</th>
                                    <th>Avg Anomaly</th>
                                    <th>Max Aircraft</th>
                                    <th>High Risk</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData['daily_summaries'] ?? [] as $summary)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($summary->date)->format('M d, Y') }}</td>
                                        <td>{{ $summary->analysis_count }}</td>
                                        <td>{{ round($summary->avg_aircraft, 1) }}</td>
                                        <td>{{ round($summary->avg_military, 1) }}</td>
                                        <td>{{ round($summary->avg_anomaly, 1) }}</td>
                                        <td>{{ $summary->max_aircraft }}</td>
                                        <td>{{ $summary->high_risk_days ? 'Yes' : 'No' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">TOP AIRCRAFT BY ACTIVITY</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Hex</th>
                                    <th>Callsign</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>Military</th>
                                    <th>Threat Level</th>
                                    <th>Positions</th>
                                    <th>Last Seen</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData['top_aircraft'] ?? [] as $aircraft)
                                    <tr>
                                        <td class="font-monospace">{{ $aircraft->hex }}</td>
                                        <td>{{ $aircraft->callsign ?? 'N/A' }}</td>
                                        <td>{{ $aircraft->type ?? 'Unknown' }}</td>
                                        <td>{{ $aircraft->country ?? 'Unknown' }}</td>
                                        <td>{{ $aircraft->is_military ? 'Yes' : 'No' }}</td>
                                        <td>{{ $aircraft->threat_level }}</td>
                                        <td>{{ $aircraft->position_count }}</td>
                                        <td>{{ \Carbon\Carbon::parse($aircraft->last_seen)->format('M d, H:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">OVERALL STATISTICS</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <div class="h3 fw-bold">{{ $reportData['stats']['total_days'] ?? 0 }}</div>
                                        <small class="text-muted">Total Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <div class="h3 fw-bold">{{ $reportData['stats']['total_analyses'] ?? 0 }}</div>
                                        <small class="text-muted">Total Analyses</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <div class="h3 fw-bold">{{ $reportData['stats']['avg_daily_aircraft'] ?? 0 }}</div>
                                        <small class="text-muted">Avg Daily Aircraft</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <div class="h3 fw-bold">{{ $reportData['stats']['high_risk_days'] ?? 0 }}</div>
                                        <small class="text-muted">High Risk Days</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Military Report Template -->
            @if($activeReportType === 'military')
                <div id="military-report-template" style="display: none;">
                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">MILITARY AIRCRAFT BY COUNTRY</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Total Aircraft</th>
                                    <th>Drones</th>
                                    <th>NATO</th>
                                    <th>Avg Threat Level</th>
                                    <th>Max Threat Level</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData['countries'] ?? [] as $country)
                                    <tr>
                                        <td>{{ $country->country }}</td>
                                        <td>{{ $country->total_aircraft }}</td>
                                        <td>{{ $country->drones }}</td>
                                        <td>{{ $country->nato }}</td>
                                        <td>{{ round($country->avg_threat_level, 1) }}</td>
                                        <td>{{ $country->max_threat_level }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">HIGH THREAT MILITARY AIRCRAFT</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Hex</th>
                                    <th>Callsign</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>Threat Level</th>
                                    <th>Positions</th>
                                    <th>Last Seen</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData['high_threat_aircraft'] ?? [] as $aircraft)
                                    <tr>
                                        <td class="font-monospace">{{ $aircraft->hex }}</td>
                                        <td>{{ $aircraft->callsign ?? 'N/A' }}</td>
                                        <td>{{ $aircraft->type ?? 'Unknown' }}</td>
                                        <td>{{ $aircraft->country ?? 'Unknown' }}</td>
                                        <td><span class="badge bg-danger">{{ $aircraft->threat_level }}</span></td>
                                        <td>{{ $aircraft->position_count }}</td>
                                        <td>{{ $aircraft->last_seen ? \Carbon\Carbon::parse($aircraft->last_seen)->format('M d, H:i') : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Threat Report Template -->
            @if($activeReportType === 'threat')
                <div id="threat-report-template" style="display: none;">
                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">AI THREAT ALERTS</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Trigger Level</th>
                                    <th>Threat Level</th>
                                    <th>Confidence</th>
                                    <th>AI Confidence</th>
                                    <th>Primary Concern</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData['ai_alerts'] ?? [] as $alert)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($alert->ai_timestamp)->format('M d, H:i') }}</td>
                                        <td><span class="badge bg-{{ $alert->trigger_level === 'HIGH' ? 'danger' : 'warning' }}">{{ $alert->trigger_level }}</span></td>
                                        <td><span class="badge bg-{{ $alert->threat_level === 'HIGH' ? 'danger' : 'warning' }}">{{ $alert->threat_level }}</span></td>
                                        <td>{{ $alert->confidence }}</td>
                                        <td>{{ round($alert->ai_confidence_score * 100) }}%</td>
                                        <td>{{ Str::limit($alert->primary_concern, 50) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Aircraft Report Template -->
            @if($activeReportType === 'aircraft')
                <div id="aircraft-report-template" style="display: none;">
                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">TOP COUNTRIES BY AIRCRAFT COUNT</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Total Aircraft</th>
                                    <th>Military</th>
                                    <th>Drones</th>
                                    <th>Percentage</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData['top_countries'] ?? [] as $country)
                                    @php
                                        $total = $reportData['aircraft_stats']->total_aircraft ?? 1;
                                        $percentage = round(($country->count / $total) * 100, 1);
                                    @endphp
                                    <tr>
                                        <td>{{ $country->country }}</td>
                                        <td>{{ $country->count }}</td>
                                        <td>{{ $country->military }}</td>
                                        <td>{{ $country->drones }}</td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <small>{{ $percentage }}%</small>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Comprehensive Report Template -->
            @if($activeReportType === 'comprehensive')
                <div id="comprehensive-report-template" style="display: none;">
                    <div class="report-section mb-4">
                        <h6 class="text-muted mb-3 border-bottom pb-2">REPORT SECTIONS</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Daily Activity</h6>
                                        <ul class="mb-0">
                                            <li>Total Days: {{ $reportData['sections']['daily_activity']['stats']['total_days'] ?? 0 }}</li>
                                            <li>Total Analyses: {{ $reportData['sections']['daily_activity']['stats']['total_analyses'] ?? 0 }}</li>
                                            <li>Avg Daily Aircraft: {{ $reportData['sections']['daily_activity']['stats']['avg_daily_aircraft'] ?? 0 }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Military Activity</h6>
                                        <ul class="mb-0">
                                            <li>Total Military Aircraft: {{ $reportData['sections']['military_activity']['stats']['total_military_aircraft'] ?? 0 }}</li>
                                            <li>Total Countries: {{ $reportData['sections']['military_activity']['stats']['total_countries'] ?? 0 }}</li>
                                            <li>Avg Threat Level: {{ $reportData['sections']['military_activity']['stats']['avg_threat_level'] ?? 0 }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
