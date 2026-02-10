<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h3 mb-0">
                                    <i class="fas fa-file-signature me-2 text-primary"></i>
                                    <span data-key="t-nato-salute-reports">NATO SALUTE Reports</span>
                                </h1>
                                <p class="text-muted mb-0" data-key="t-standardized-intelligence-reporting">
                                    Standardized Intelligence Reporting (Size, Activity, Location, Unit, Time, Equipment)
                                </p>
                            </div>
                            <div>
                                <button wire:click="create" class="btn btn-danger">
                                    <i class="fas fa-plus me-1"></i> <span data-key="t-new-salute-report">New Report</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase text-white" data-key="t-total-reports">Total Reports</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['total'] }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-white bg-opacity-25 rounded fs-3">
                                            <i class="fas fa-archive"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase text-white" data-key="t-high-threat">High Threat</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['high_threat'] }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-white bg-opacity-25 rounded fs-3">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase text-white" data-key="t-reports-today">Reports Today</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['today'] }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-white bg-opacity-25 rounded fs-3">
                                            <i class="fas fa-calendar-day"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase text-white" data-key="t-pending-tx">Pending TX</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['pending'] }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-white bg-opacity-25 rounded fs-3">
                                            <i class="fas fa-satellite-dish"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="search-box">
                                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search ID, Location, Activity..." data-key-placeholder="t-search-placeholder">
                                            <i class="fas fa-search search-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select wire:model.live="filterThreat" class="form-select">
                                            <option value="all" data-key="t-all-threat-levels">All Threat Levels</option>
                                            <option value="LOW" data-key="t-low">Low</option>
                                            <option value="MEDIUM" data-key="t-medium">Medium</option>
                                            <option value="HIGH" data-key="t-high">High</option>
                                            <option value="CRITICAL" data-key="t-critical">Critical</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select wire:model.live="filterStatus" class="form-select">
                                            <option value="all" data-key="t-all-statuses">All Statuses</option>
                                            <option value="transmitted" data-key="t-transmitted">Transmitted</option>
                                            <option value="pending" data-key="t-pending-transmission">Pending Transmission</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th scope="col" data-key="t-report-id">Report ID</th>
                                            <th scope="col" data-key="t-threat">Threat</th>
                                            <th scope="col" data-key="t-time">Time (Observed)</th>
                                            <th scope="col" data-key="t-location">Location</th>
                                            <th scope="col" data-key="t-activity-unit">Activity / Unit</th>
                                            <th scope="col" data-key="t-status">Status</th>
                                            <th scope="col" data-key="t-actions">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($reports as $report)
                                            <tr>
                                                <td>
                                                    <a href="#" wire:click.prevent="viewDetails('{{ $report->report_id }}')" class="fw-bold text-primary font-monospace">
                                                        {{ $report->report_id }}
                                                    </a>
                                                    <br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($report->timestamp)->format('d M Y H:i') }}</small>
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeClass = match($report->threat_level) {
                                                            'CRITICAL' => 'bg-danger',
                                                            'HIGH' => 'bg-orange',
                                                            'MEDIUM' => 'bg-warning text-dark',
                                                            default => 'bg-success',
                                                        };
                                                        if($report->threat_level == 'HIGH') $badgeClass = 'bg-danger bg-opacity-75';
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">{{ $report->threat_level }}</span>
                                                </td>
                                                <td>
                                                    <span class="font-monospace text-dark">{{ $report->salute_time }}</span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ Str::limit($report->salute_location, 20) }}
                                                </td>
                                                <td>
                                                    <div class="fw-medium">{{ Str::limit($report->salute_activity, 30) }}</div>
                                                    <small class="text-muted">{{ $report->salute_unit ?? 'Unknown Unit' }}</small>
                                                </td>
                                                <td>
                                                    @if($report->is_transmitted)
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                            <i class="fas fa-check-double me-1"></i> <span data-key="t-transmitted">Transmitted</span>
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                            <i class="fas fa-clock me-1"></i> <span data-key="t-pending">Pending</span>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button wire:click="viewDetails('{{ $report->report_id }}')" class="btn btn-soft-primary" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button wire:click="edit('{{ $report->report_id }}')" class="btn btn-soft-info" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button wire:click="toggleTransmit('{{ $report->report_id }}')" class="btn btn-soft-{{ $report->is_transmitted ? 'warning' : 'success' }}" title="Toggle Transmit">
                                                            <i class="fas fa-{{ $report->is_transmitted ? 'undo' : 'satellite-dish' }}"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                                        <h5 data-key="t-no-reports-found">No reports found</h5>
                                                        <p class="mb-0" data-key="t-try-adjusting-your">Try adjusting your search or filters.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 border-top">
                                    {{ $reports->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($showModal)
                    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5); z-index: 1055;" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title mb-3 text-white" id="reportModalLabel">
                                        <i class="fas fa-file-signature me-2"></i>
                                        {!! $isEditMode ? '<span data-key="t-edit-salute-report">Edit SALUTE Report</span>' : '<span data-key="t-new-salute-report">New SALUTE Report</span>' !!}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white text-white mb-1" wire:click="closeModal"></button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent="store">
                                        <div class="alert alert-light border border-danger border-opacity-25 d-flex align-items-center" role="alert">
                                            <i class="fas fa-info-circle text-danger fs-4 me-3"></i>
                                            <div class="text-black">
                                                <strong data-key="t-salute-protocol">S.A.L.U.T.E. Protocol:</strong> <span data-key="t-fill-all-fields-accurately">Fill all fields accurately. This report will be transmitted to command instantly.</span>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-12 mb-2">
                                                <label class="form-label fw-bold" data-key="t-threat-classification">Threat Classification</label>
                                                <div class="d-flex gap-2">
                                                    @foreach(['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'] as $level)
                                                        @php
                                                            $color = match ($level) {
                                                                'CRITICAL' => 'danger',
                                                                'HIGH'     => 'orange',
                                                                'MEDIUM'   => 'warning',
                                                                default    => 'success',
                                                            };
                                                        @endphp
                                                        <input type="radio" class="btn-check" name="threat_level" id="threat_{{ $level }}" value="{{ $level }}" wire:model="threat_level">
                                                        <label class="btn btn-outline-{{ $color }} flex-fill text-uppercase" data-key="t-{{ strtolower($level) }}" for="threat_{{ $level }}">
                                                            {{ $level }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @error('threat_level') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-danger fw-bold" data-key="t-s-size">S - Size</label>
                                                <input type="text" class="form-control" wire:model="salute_size" placeholder="e.g., 5 Tanks, Platoon size">
                                                @error('salute_size') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-danger fw-bold" data-key="t-a-activity">A - Activity</label>
                                                <input type="text" class="form-control" wire:model="salute_activity" placeholder="e.g., Moving North, Entrenching">
                                                @error('salute_activity') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-danger fw-bold" data-key="t-l-location">L - Location</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" class="form-control" wire:model="salute_location" placeholder="MGRS Grid or Lat/Lon">
                                                </div>
                                                @error('salute_location') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-danger fw-bold" data-key="t-u-unit-uniform">U - Unit / Uniform</label>
                                                <input type="text" class="form-control" wire:model="salute_unit" placeholder="e.g., VDV insignia, Unknown markings">
                                                @error('salute_unit') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-danger fw-bold" data-key="t-time-observed">T - Time (Observed)</label>
                                                <input type="text" class="form-control" wire:model="salute_time" placeholder="DTG format e.g., 071430Z OCT 23">
                                                @error('salute_time') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label text-danger fw-bold" data-key="t-e-equipment">E - Equipment</label>
                                                <input type="text" class="form-control" wire:model="salute_equipment" placeholder="e.g., T-90 tanks, AK-74, RPGs">
                                                @error('salute_equipment') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="mt-4 text-end">
                                            <button type="button" class="btn btn-light" wire:click="closeModal" data-key="t-close">Close</button>
                                            <button type="submit" class="btn btn-danger px-4">
                                                <i class="fas fa-paper-plane me-1"></i> <span data-key="t-submit-report">Submit Report</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($showDetailsModal && $selectedReport)
                    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5); z-index: 1060;" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header bg-dark text-white">
                                    <h5 class="modal-title font-monospace text-white mb-3"><span class="text-uppercase" data-key="t-report-id">REPORT ID</span>: {{ $selectedReport->report_id }}</h5>
                                    <button type="button" class="btn-close btn-close-white mb-3 text-white" wire:click="closeModal"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $selectedReport->threat_level == 'CRITICAL' ? 'danger' : 'warning' }} fs-6">
                                        {{ $selectedReport->threat_level }} <span class="text-uppercase" data-key="t-threat">THREAT</span>
                                    </span>
                                        <span class="text-muted small">
                                        <i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($selectedReport->timestamp)->toDayDateTimeString() }}
                                    </span>
                                    </div>
                                    <div class="p-4">
                                        <div class="row mb-3 pb-3 border-bottom border-dashed">
                                            <div class="col-3 text-muted fw-bold text-uppercase" data-key="t-size">SIZE</div>
                                            <div class="col-9">{{ $selectedReport->salute_size }}</div>
                                        </div>
                                        <div class="row mb-3 pb-3 border-bottom border-dashed">
                                            <div class="col-3 text-muted fw-bold text-uppercase" data-key="t-activity">ACTIVITY</div>
                                            <div class="col-9">{{ $selectedReport->salute_activity }}</div>
                                        </div>
                                        <div class="row mb-3 pb-3 border-bottom border-dashed">
                                            <div class="col-3 text-muted fw-bold text-uppercase" data-key="t-location">LOCATION</div>
                                            <div class="col-9 text-danger fw-medium">{{ $selectedReport->salute_location }}</div>
                                        </div>
                                        <div class="row mb-3 pb-3 border-bottom border-dashed">
                                            <div class="col-3 text-muted fw-bold text-uppercase" data-key="t-unit">UNIT</div>
                                            <div class="col-9">{{ $selectedReport->salute_unit ?? 'N/A' }}</div>
                                        </div>
                                        <div class="row mb-3 pb-3 border-bottom border-dashed">
                                            <div class="col-3 text-muted fw-bold text-uppercase" data-key="t-time">TIME</div>
                                            <div class="col-9 font-monospace">{{ $selectedReport->salute_time }}</div>
                                        </div>
                                        <div class="row mb-0">
                                            <div class="col-3 text-muted fw-bold text-uppercase" data-key="t-equipment">EQUIPMENT</div>
                                            <div class="col-9">{{ $selectedReport->salute_equipment ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div class="bg-dark bg-opacity-10 p-3">
                                        <small class="text-muted d-block mb-1 text-uppercase" data-key="t-full-text-string">FULL TEXT STRING:</small>
                                        <code class="text-dark">{{ $selectedReport->full_report_text }}</code>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary mt-3" wire:click="closeModal" data-key="t-close">Close</button>
                                    <button type="button" class="btn btn-success mt-3" wire:click="toggleTransmit('{{ $selectedReport->report_id }}')">
                                        @if($selectedReport->is_transmitted)
                                            <i class="fas fa-undo me-1"></i> <span data-key="t-retract">Retract</span>
                                        @else
                                            <i class="fas fa-satellite-dish me-1"></i> <span data-key="t-transmit-hq">Transmit to HQ</span>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('styles')
    <style>
        .bg-orange {
            background-color: #ff5802 !important;
        }

        .btn-outline-orange {
            border-color: #ff5802 !important;
            color: #ff5802 !important;
            background-color: transparent;
        }

        .btn-check:checked + .btn-outline-orange {
            background-color: #ff5802 !important;
            color: #fff !important;
            border-color: #ff5802 !important;
        }
        .btn-outline-orange.selected {
            background-color: #ff5802 !important;
            color: #fff !important;
        }
    </style>
@endpush
