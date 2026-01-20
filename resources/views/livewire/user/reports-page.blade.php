<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h3 mb-1 text-gray-800">
                                    <i class="fas fa-file-alt me-2 text-primary"></i> <span data-key="t-reports-analytics">Reports & Analytics</span>
                                </h1>
                                <p class="text-muted mb-0 small" data-key="t-generate-intelligence-reports-and-analyze-historical-data">Generate intelligence reports and analyze historical data.</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-white text-primary border px-3 py-2">
                                    <i class="far fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d') }}
                                </span>
                                <button wire:click="applyDateRange" wire:loading.attr="disabled" class="btn btn-primary btn-sm px-3">
                                    <i class="fas fa-sync-alt me-1" wire:loading.remove wire:target="applyDateRange"></i>
                                    <i class="fas fa-spinner fa-spin me-1" wire:loading wire:target="applyDateRange"></i>
                                    <span data-key="t-refresh">Refresh</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4 g-3">
                    <div class="col-md-2 col-6">
                        <div class="card h-100 border-start border-4 border-primary shadow-sm">
                            <div class="card-body p-3">
                                <div class="text-uppercase text-muted small fw-bold mb-1" data-key="t-analyses">Analyses</div>
                                <div class="h3 mb-0 text-dark">{{ $stats['total_analyses'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card h-100 border-start border-4 border-danger shadow-sm">
                            <div class="card-body p-3">
                                <div class="text-uppercase text-muted small fw-bold mb-1" data-key="t-military">Military</div>
                                <div class="h3 mb-0 text-dark">{{ $stats['total_military'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card h-100 border-start border-4 border-warning shadow-sm">
                            <div class="card-body p-3">
                                <div class="text-uppercase text-muted small fw-bold mb-1" data-key="t-drones">Drones</div>
                                <div class="h3 mb-0 text-dark">{{ $stats['total_drones'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card h-100 border-start border-4 border-info shadow-sm">
                            <div class="card-body p-3">
                                <div class="text-uppercase text-muted small fw-bold mb-1" data-key="t-avg-anomaly">Avg Anomaly</div>
                                <div class="h3 mb-0 text-dark">{{ round($stats['avg_anomaly'] ?? 0, 1) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card h-100 border-start border-4 border-success shadow-sm">
                            <div class="card-body p-3">
                                <div class="text-uppercase text-muted small fw-bold mb-1" data-key="t-high-risk">High Risk</div>
                                <div class="h3 mb-0 text-dark">{{ $stats['high_risk'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card h-100 border-start border-4 border-secondary shadow-sm">
                            <div class="card-body p-3">
                                <div class="text-uppercase text-muted small fw-bold mb-1" data-key="t-max-traffic">Max Traffic</div>
                                <div class="h3 mb-0 text-dark">{{ $stats['max_aircraft'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body bg-light rounded">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase text-muted" data-key="t-start-date">Start Date</label>
                                <input type="date" wire:model.live="startDate" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase text-muted" data-key="t-end-date">End Date</label>
                                <input type="date" wire:model.live="endDate" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase text-muted" data-key="t-country-scope">Country Scope</label>
                                <select wire:model.live="reportFilterCountry" class="form-select">
                                    <option value="all">Global (All Countries)</option>
                                    @foreach($countryOptions as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 text-end">
                                <button wire:click="resetFilters" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i> <span data-key="t-reset-filters">Reset Filters</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3 fw-bold text-dark" data-key="t-generate-intelligence-report">Generate Intelligence Report</h5>
                <div class="row g-3 mb-5">
                    @php
                        $types = [
                            'daily' => ['icon' => 'calendar-day', 'color' => 'primary', 'title' => '<span data-ket="t-daily-summary">Daily Summary</span>', 'desc' => '<span data-key="t-activity-overview--traffic-totals">Activity overview & traffic totals</span>'],
                            'military' => ['icon' => 'fighter-jet', 'color' => 'danger', 'title' => '<span data-ket="t-military-intel">Military Intel</span>', 'desc' => '<span data-key="t-movement-threat-analysis">Movement & threat analysis</span>'],
                            'threat' => ['icon' => 'exclamation-triangle', 'color' => 'warning', 'title' => '<span data-ket="t-threat-audit">Threat Audit</span>', 'desc' => '<span data-key="t-ai-alerts-risk-levels">AI Alerts & Risk Levels</span>'],
                            'aircraft' => ['icon' => 'plane', 'color' => 'info', 'title' => '<span data-ket="t-air-traffic">Air Traffic</span>', 'desc' => '<span data-key="t-volume-categorization">Volume & Categorization</span>'],
                            'comprehensive' => ['icon' => 'book', 'color' => 'success', 'title' => '<span data-ket="t-comprehensive">Comprehensive</span>', 'desc' => '<span data-key="t-full-security-breakdown">Full security breakdown</span>']
                        ];
                    @endphp

                    @foreach($types as $key => $meta)
                        <div class="col-md-2 col-sm-6">
                            <div class="card h-100 report-card border-0 shadow-sm" wire:click="generateReport('{{ $key }}')">
                                <div class="card-body text-center p-3">
                                    <div class="avatar-md mx-auto mb-3">
                                        <div class="avatar-title rounded-circle bg-{{ $meta['color'] }} bg-opacity-10 text-{{ $meta['color'] }}">
                                            <i class="fas fa-{{ $meta['icon'] }} fs-3"></i>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">{!! $meta['title'] !!}</h6>
                                    <small class="text-muted d-block lh-sm">{!! $meta['desc'] !!}</small>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <small class="text-primary fw-bold" wire:loading wire:target="generateReport('{{ $key }}')">
                                        <i class="fas fa-spinner fa-spin"></i> <span data-key="t-generating">Generating...</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            {{ $reportFilterCountry === 'all' ? 'Analysis History' : 'Aircraft Log: ' . $reportFilterCountry }}
                        </h5>
                        <div class="small text-muted" data-key="t-showing-results-for-selected-period">
                            Showing results for selected period
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                @if($reportFilterCountry === 'all')
                                    <th data-key="t-timestamp">Timestamp</th>
                                    <th data-key="t-analysis-id">Analysis ID</th>
                                    <th data-key="t-summary">Summary</th>
                                    <th data-key="t-risk-level">Risk Level</th>
                                    <th data-key="t-score">Score</th>
                                @else
                                    <th data-key="t-last-seen">Last Seen</th>
                                    <th data-key="t-hex-code">Hex Code</th>
                                    <th data-key="t-callsign">Callsign</th>
                                    <th data-key="t-type">Type</th>
                                    <th data-key="t-threat">Threat</th>
                                @endif
                                <th data-key="t-actions">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    @if($reportFilterCountry === 'all')
                                        <td>
                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($report->analysis_time)->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($report->analysis_time)->format('H:i') }}</small>
                                        </td>
                                        <td><code class="text-primary">{{ Str::limit($report->analysis_id, 8) }}</code></td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $report->total_aircraft }} Aircraft</span>
                                            @if($report->military_aircraft > 0)
                                                <span class="badge bg-danger bg-opacity-10 text-danger">{{ $report->military_aircraft }} Mil</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $report->overall_risk == 'HIGH' ? 'danger' : ($report->overall_risk == 'MEDIUM' ? 'warning' : 'success') }}">
                                                {{ $report->overall_risk }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center" style="width: 80px;">
                                                <div class="progress flex-grow-1 me-2" style="height: 4px;">
                                                    <div class="progress-bar bg-{{ $report->anomaly_score > 50 ? 'danger' : 'primary' }}" style="width: {{ $report->anomaly_score }}%"></div>
                                                </div>
                                                <small>{{ round($report->anomaly_score) }}</small>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($report->last_seen)->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($report->last_seen)->format('H:i') }}</small>
                                        </td>
                                        <td><code class="text-primary">{{ $report->hex }}</code></td>
                                        <td>
                                            {{ $report->callsign ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $report->type ?? 'Unknown' }}
                                            @if($report->is_drone) <span class="badge bg-warning text-dark ms-1">Drone</span> @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $report->threat_level >= 4 ? 'danger' : ($report->threat_level >= 2 ? 'warning' : 'secondary') }}">
                                                <span data-key="t-level">Level</span> {{ $report->threat_level }}
                                            </span>
                                        </td>
                                    @endif

                                    <td>
                                        <button class="btn btn-sm btn-light" wire:click="generateReport('daily')">
                                            <i class="fas fa-eye text-muted"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                        <p class="text-muted" data-key="t-no-records-found-for-this-date-range">No records found for this date range.</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white">
                        {{ $reports->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if($showReportModal)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.6);" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-dark text-white">
                        <div>
                            <h5 class="modal-title text-white">
                                <i class="fas fa-file-contract me-2 text-warning"></i>
                                {!! $reportData['type'] ?? '<span data-key="t-report-preview">Report Preview</span>' !!}
                            </h5>
                            @if($reportData)
                                <small class="text-white-50"><span data-key="t-filter-scope">Filter Scope</span>: {{ $reportData['filter_country'] }}</small>
                            @endif
                        </div>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeReport"></button>
                    </div>
                    <div class="modal-body bg-light p-0">
                        @if(!$reportData)
                            <div class="d-flex flex-column align-items-center justify-content-center" style="height: 400px;">
                                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
                                <p class="mt-3 text-muted fw-medium" data-key="t-compiling-intelligence-data">Compiling Intelligence Data...</p>
                            </div>
                        @else
                            <div class="p-5 bg-white mx-auto shadow-sm" style="max-width: 900px; min-height: 800px;">
                                <div class="d-flex justify-content-between border-bottom pb-4 mb-4">
                                    <div>
                                        <h2 class="fw-bold text-dark mb-0" data-key="t-intelligence-report">INTELLIGENCE REPORT</h2>
                                        <p class="text-muted small">SkyGuardian System</p>
                                    </div>
                                    <div class="text-end">
                                        <div class="badge bg-danger mb-1" data-key="t-confidential">CONFIDENTIAL</div>
                                        <div class="text-muted small">{{ $reportData['period'] }}</div>
                                    </div>
                                </div>

                                @include('livewire.user.reports.export_template', ['reportData' => $reportData, 'activeReportType' => $activeReportType])

                                <div class="mt-5 pt-3 border-top text-center text-muted small">
                                    <span data-key="t-generated-on">Generated on</span> {{ $reportData['generated_at'] }} • ID: {{ Str::random(10) }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer bg-white">
                        <button class="btn btn-outline-secondary" wire:click="closeReport" data-key="t-close">Close</button>
                        <div class="vr mx-2"></div>
                        <button class="btn btn-danger" wire:click="exportReport('pdf')" wire:loading.attr="disabled">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </button>
                        <button class="btn btn-success" wire:click="exportReport('excel')" wire:loading.attr="disabled">
                            <i class="fas fa-file-excel me-1"></i> Excel
                        </button>
                        <button class="btn btn-primary" wire:click="exportReport('csv')" wire:loading.attr="disabled">
                            <i class="fas fa-file-csv me-1"></i> CSV
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
        <style>
            .report-card { transition: all 0.2s; cursor: pointer; }
            .report-card:hover { transform: translateY(-5px); }
        </style>
    @endpush
</div>
