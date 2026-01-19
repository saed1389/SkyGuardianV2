<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-fighter-jet me-2"></i><span data-key="t-military-monitoring">Military Monitoring</span>
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-danger">
                                    <i class="fas fa-satellite-dish me-1"></i>
                                    <span data-key="t-active">Active</span>: {{ $stats['active_last_24h'] ?? 0 }}
                                </span>
                                <button wire:click="refreshData" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-redo"></i> <span data-key="t-refresh">Refresh</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0" data-key="t-real-time-tracking-of-military-aircraft-in-the-region">Real-time tracking of military aircraft in the region</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1" data-key="t-total-military-aircraft">Total Military Aircraft</p>
                                        <h3 class="mb-0">{{ $stats['total_military'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-danger bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-fighter-jet"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-danger me-1"><span data-key="t-active-24h">Active 24h</span>: {{ $stats['active_last_24h'] ?? 0 }}</span>
                                        <span class="text-warning">{{ count($aircraftPositions) }} <span data-key="t-with-positions">with positions</span></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1" data-key="t-military-drones">Military Drones</p>
                                        <h3 class="mb-0">{{ $stats['drones'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning bg-opacity-20 rounded fs-22">
                                            <i class="fa-brands fa-phoenix-squadron"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stats['total_military'] > 0 ? ($stats['drones'] / $stats['total_military'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-info bg-opacity-10 border-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1" data-key="t-nato-aircraft">NATO Aircraft</p>
                                        <h3 class="mb-0">{{ $stats['nato'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-info bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-flag"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $stats['total_military'] > 0 ? ($stats['nato'] / $stats['total_military'] * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-dark bg-opacity-10 border-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1"><span data-key="t-high-threat">High Threat</span> (≥ <span data-key="t-level">Level</span> 4)</p>
                                        <h3 class="mb-0">{{ $stats['threat_levels'][4] + ($stats['threat_levels'][5] ?? 0) ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-dark bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 text-muted">
                                        <span data-key="t-threat-distribution">Threat distribution</span>:
                                        @for($i = 1; $i <= 5; $i++)
                                            @if(isset($stats['threat_levels'][$i]))
                                                <span class="badge bg-{{ $i >= 4 ? 'danger' : ($i >= 3 ? 'warning' : 'success') }} me-1">{{ $i }}:{{ $stats['threat_levels'][$i] }}</span>
                                            @endif
                                        @endfor
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($stats['top_countries']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0" data-key="t-top-countries-by-military-aircraft">Top Countries by Military Aircraft</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($stats['top_countries'] as $country => $count)
                                            <div class="col-md-2 col-4 mb-3">
                                                <div class="text-center">
                                                    <div class="h4 fw-bold">{{ $country }}</div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $count / max($stats['total_military'], 1) * 100 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $count }} <span data-key="t-aircraft">aircraft</span></small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0" data-key="t-military-aircraft-positions">Military Aircraft Positions</h5>
                                    <span class="badge bg-danger">
                                        {{ count($mapMarkersData) }} <span data-key="t-aircraft-on-map">aircraft on map</span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="military-map" style="height: 500px; width: 100%;" wire:ignore></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="me-3">
                                                <span class="badge bg-danger me-1">●</span> <span data-key="t-military">Military</span>
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-warning me-1">●</span> <span data-key="t-drone">Drone</span>
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-info me-1">●</span> <span data-key="nato">NATO</span>
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-success me-1">●</span> <span data-key="t-in-estonia">In Estonia</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted" data-key="t-click-markers-for-details">
                                            Click markers for details • Red markers = active within 30 min
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label" data-key="t-country">Country</label>
                                        <select wire:model.live="filterCountry" wire:change="applyFilters" class="form-select">
                                            <option value="all" data-key="t-all-countries">All Countries</option>
                                            @foreach($countryOptions as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" data-key="t-threat-level">Threat Level</label>
                                        <select wire:model.live="filterThreatLevel" wire:change="applyFilters" class="form-select">
                                            <option value="all" data-key="t-all-levels">All Levels</option>
                                            <option value="4" data-key="t-high-threat-(4-5)">High (4-5)</option>
                                            <option value="3" data-key="t-medium-threat-(3)">Medium (3)</option>
                                            <option value="1" data-key="t-low-threat-(1-2)">Low (1-2)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" data-key="t-type">Type</label>
                                        <select wire:model.live="filterType" wire:change="applyFilters" class="form-select">
                                            <option value="all" data-key="t-all-military">All Military</option>
                                            <option value="drone" data-key="t-drones-only">Drones Only</option>
                                            <option value="nato" data-key="t-nato-only">NATO Only</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label" data-key="t-time-range">Time Range</label>
                                        <select wire:model.live="timeRange" wire:change="applyFilters" class="form-select">
                                            <option value="1hour" data-key="t-last-hour">Last Hour</option>
                                            <option value="6hours" data-key="t-last-6hours">Last 6 Hours</option>
                                            <option value="24hours" data-key="t-last-24hours">Last 24 Hours</option>
                                            <option value="7days" data-key="t-last-7days">Last 7 Days</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" data-key="t-search">Search</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Hex, callsign, type...">
                                        </div>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0" data-key="t-military-aircraft-database">Military Aircraft Database</h5>
                                    <span class="badge bg-light text-dark">
                                        {{ $paginatedAircraft->total() }} <span data-key="t-records">records</span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-danger" role="status">
                                            <span class="visually-hidden" data-key="t-loading">Loading...</span>
                                        </div>
                                        <p class="mt-2" data-key="t-loading-military-aircraft-data">Loading military aircraft data...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th data-key="t-hex">Hex</th>
                                                <th data-key="t-callsign-registration">Callsign / Registration</th>
                                                <th data-key="t-type-name">Type / Name</th>
                                                <th data-key="t-country-nato">Country / NATO</th>
                                                <th data-key="t-threat-level">Threat Level</th>
                                                <th data-key="t-last-position">Last Position</th>
                                                <th data-key="t-status">Status</th>
                                                <th data-key="t-actions">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($paginatedAircraft as $item)
                                                @php
                                                    $aircraft = $item->aircraft;
                                                    $position = $item->position;
                                                    $isActive = $item->is_active;
                                                @endphp
                                                <tr class="{{ $aircraft->threat_level >= 4 ? 'table-danger' : ($aircraft->threat_level >= 3 ? 'table-warning' : '') }}">
                                                    <td>
                                                        <div class="fw-bold font-monospace">{{ $aircraft->hex }}</div>
                                                        @if($aircraft->is_drone)
                                                            <span class="badge bg-warning">Drone</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ $aircraft->callsign ?? 'N/A' }}</div>
                                                        @if($aircraft->registration)
                                                            <small class="text-muted">{{ $aircraft->registration }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div>{!! $aircraft->type ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                                        <small class="text-muted">{!! $aircraft->aircraft_name ?? '<span data-key="t-unknown-aircraft">Unknown aircraft</span>' !!}</small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{!! $aircraft->country ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                                        @if($aircraft->is_nato)
                                                            <span class="badge bg-info">NATO</span>
                                                        @endif
                                                        @if($aircraft->is_friendly)
                                                            <span class="badge bg-success" data-key="t-friendly">Friendly</span>
                                                        @endif
                                                        @if($aircraft->is_potential_threat)
                                                            <span class="badge bg-danger" data-key="t-potential-threat">Potential Threat</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $aircraft->threat_level >= 4 ? 'danger' : ($aircraft->threat_level >= 3 ? 'warning' : 'success') }}" style="width: {{ $aircraft->threat_level * 20 }}%"></div>
                                                            </div>
                                                            <strong>{{ $aircraft->threat_level }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($position)
                                                            <div>
                                                                <small class="text-muted d-block"><span data-key="t-position">Position</span>:</small>
                                                                <code>{{ number_format($position->latitude, 4) }}, {{ number_format($position->longitude, 4) }}</code>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block"><span data-key="t-time">Time</span>:</small>
                                                                <small>{{ \Carbon\Carbon::parse($position->position_time)->diffForHumans() }}</small>
                                                            </div>
                                                        @else
                                                            <span class="text-muted" data-key="t-no-recent-position">No recent position</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($isActive)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-circle me-1"></i> <span data-key="t-active">Active</span>
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-clock me-1"></i> <span data-key="t-inactive">Inactive</span>
                                                            </span>
                                                        @endif
                                                        @if($position && $position->in_estonia)
                                                            <span class="badge bg-success mt-1 d-block" data-key="t-in-estonia">In Estonia</span>
                                                        @endif
                                                        @if($position && $position->near_sensitive)
                                                            <span class="badge bg-danger mt-1 d-block" data-key="t-near-sensitive">Near Sensitive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button wire:click="viewAircraftDetails('{{ $aircraft->hex }}')" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-search"></i> <span data-key="t-details">Details</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-fighter-jet fa-2x mb-2"></i>
                                                            <p data-key="t-no-military-aircraft-found">No military aircraft found</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        Showing {{ $paginatedAircraft->firstItem() ?? 0 }} to {{ $paginatedAircraft->lastItem() ?? 0 }} of {{ $paginatedAircraft->total() }} entries
                                    </div>
                                    <div>
                                        {{ $paginatedAircraft->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($showDetailsModal && $selectedAircraft)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white">
                            <i class="fas fa-fighter-jet me-2"></i>
                            <span data-key="t-military-aircraft-details">Military Aircraft Details</span>
                            <span class="badge bg-light text-dark ms-2"><span data-key="t-hex">HEX</span>: {{ $selectedAircraft->hex }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3" data-key="t-aircraft-info">AIRCRAFT INFO</h6>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-hex-code">Hex Code</small>
                                            <div class="h4 font-monospace fw-bold">{{ $selectedAircraft->hex }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-callsign">Callsign</small>
                                            <div class="h5">{{ $selectedAircraft->callsign ?? 'N/A' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-registration">Registration</small>
                                            <div class="h5">{{ $selectedAircraft->registration ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-danger bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3" data-key="t-classification">CLASSIFICATION</h6>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span data-key="t-military">Military</span>
                                                <span class="badge bg-danger" data-key="t-yes">YES</span>
                                            </div>
                                            @if($selectedAircraft->is_drone)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span data-key="t-drone">Drone</span>
                                                    <span class="badge bg-warning" data-key="t-yes">YES</span>
                                                </div>
                                            @endif
                                            @if($selectedAircraft->is_nato)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span>NATO</span>
                                                    <span class="badge bg-info" data-key="t-yes">YES</span>
                                                </div>
                                            @endif
                                            @if($selectedAircraft->is_friendly)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span data-key="t-friendly">Friendly</span>
                                                    <span class="badge bg-success" data-key="t-yes">YES</span>
                                                </div>
                                            @endif
                                            @if($selectedAircraft->is_potential_threat)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span data-key="t-potential-threat">Potential Threat</span>
                                                    <span class="badge bg-danger" data-key="t-yes">YES</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-warning bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3" data-key="t-threat-assessment">THREAT ASSESSMENT</h6>
                                        <div class="text-center">
                                            <div class="display-4 fw-bold text-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}">
                                                <span data-key="t-level">Level</span> {{ $selectedAircraft->threat_level }}
                                            </div>
                                            <div class="mt-3">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}" style="width: {{ $selectedAircraft->threat_level * 20 }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0" data-key="t-aircraft-details">Aircraft Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-type">Type</small>
                                                    <strong>{!! $selectedAircraft->type ?? '<span data-key="t-unknown">Unknown</span>' !!}</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-aircraft-name">Aircraft Name</small>
                                                    <strong>{!! $selectedAircraft->aircraft_name ?? '<span data-key="t-unknown">Unknown</span>' !!}</strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-category">Category</small>
                                                    <strong>{!! $selectedAircraft->category ?? '<span data-key="t-unknown">Unknown</span>' !!}</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-role">Role</small>
                                                    <strong>{!! $selectedAircraft->role ?? '<span data-key="t-unknown">Unknown</span>' !!}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-country-of-origin">Country of Origin</small>
                                                    <div class="h5 fw-bold">{!! $selectedAircraft->country ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0" data-key="t-last-seen">Last Seen</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($selectedAircraft->last_seen)
                                            <div class="text-center">
                                                <div class="display-6 fw-bold">
                                                    {{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->format('H:i') }}
                                                </div>
                                                <div class="text-muted">
                                                    {{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->format('M d, Y') }}
                                                </div>
                                                <div class="mt-3">
                                            <span class="badge bg-{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->diffInHours() < 24 ? 'success' : 'secondary' }}">
                                                {{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->diffForHumans() }}
                                            </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-clock fa-2x text-muted mb-2"></i>
                                                <p class="text-muted mb-0" data-key="t-no-last-seen-data">No last seen data</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($selectedAircraft->latest_position))
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0" data-key="t-latest-position">Latest Position</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-coordinates">Coordinates</small>
                                                        <div class="h5">
                                                            {{ number_format($selectedAircraft->latest_position->latitude, 4) }},
                                                            {{ number_format($selectedAircraft->latest_position->longitude, 4) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-altitude">Altitude</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->altitude) }} m</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-speed">Speed</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->speed) }} km/h</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-heading">Heading</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->heading) }}°</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @if($selectedAircraft->latest_position->in_estonia)
                                                            <span class="badge bg-success" data-ket="t-in-estonia">In Estonia</span>
                                                        @endif
                                                        @if($selectedAircraft->latest_position->near_sensitive)
                                                            <span class="badge bg-danger" data-key="t-near-sensitive-area">Near Sensitive Area</span>
                                                        @endif
                                                        @if($selectedAircraft->latest_position->near_military_base)
                                                            <span class="badge bg-warning" data-key="t-near-military-base">Near Military Base</span>
                                                        @endif
                                                        @if($selectedAircraft->latest_position->near_border)
                                                            <span class="badge bg-info" data-key="t-near-border">Near Border</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            <span data-key="t-position-time">Position time</span>: {{ \Carbon\Carbon::parse($selectedAircraft->latest_position->position_time)->format('Y-m-d H:i:s') }}
                                                            ({{ \Carbon\Carbon::parse($selectedAircraft->latest_position->position_time)->diffForHumans() }})
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(isset($selectedAircraft->positions) && count($selectedAircraft->positions) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0" data-key="t-recent-position-history">Recent Position History</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th data-key="t-time">Time</th>
                                                        <th data-key="t-position">Position</th>
                                                        <th data-key="t-altitude">Altitude</th>
                                                        <th data-key="t-speed">Speed</th>
                                                        <th data-key="t-heading">Heading</th>
                                                        <th data-key="t-status">Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($selectedAircraft->positions as $position)
                                                        <tr>
                                                            <td>
                                                                <small>{{ \Carbon\Carbon::parse($position->position_time)->format('H:i:s') }}</small><br>
                                                                <small class="text-muted">{{ \Carbon\Carbon::parse($position->position_time)->format('M d') }}</small>
                                                            </td>
                                                            <td>
                                                                <code>{{ number_format($position->latitude, 4) }}, {{ number_format($position->longitude, 4) }}</code>
                                                            </td>
                                                            <td>{{ round($position->altitude) }} m</td>
                                                            <td>{{ round($position->speed) }} km/h</td>
                                                            <td>{{ round($position->heading) }}°</td>
                                                            <td>
                                                                @if($position->in_estonia)
                                                                    <span class="badge bg-success" data-key="t-in-estonia">In Estonia</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
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
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            let militaryMap = null;
            let militaryMarkers = new Map();
            let isMilitaryMapInitialized = false;

            const militaryColorMap = {
                'military': '#dc3545', // Red for military
                'drone': '#fd7e14',    // Orange for drones
                'nato': '#0dcaf0',     // Blue for NATO
                'inactive': '#6c757d', // Gray for inactive
            };

            // Initialize military map
            function initMilitaryMap() {
                if (isMilitaryMapInitialized) return;

                try {

                    militaryMap = L.map('military-map').setView([58.8, 25.5], 7);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(militaryMap);

                    const mainland = [
                        [59.479, 28.042], // Narva-Jõesuu (Start North-East)
                        [59.376, 28.203], // Narva
                        [58.980, 27.730], // Lake Peipsi North
                        [58.850, 27.500], // Lake Peipsi Coast
                        [58.450, 27.750], // Lake Peipsi South
                        [57.880, 27.810], // Setomaa corner
                        [57.570, 27.350], // Misso (South-East corner)
                        [57.720, 26.650], // Antsla area
                        [57.776, 26.031], // Valga/Valka
                        [57.850, 25.600], // Mulgimaa border
                        [58.000, 25.100], // Kilingi-Nõmme area
                        [57.874, 24.348], // Ikla (South-West Coast)
                        [58.200, 24.500], // Häädemeeste
                        [58.380, 24.500], // Pärnu Bay (Pärnu city)
                        [58.300, 24.150], // Liu
                        [58.350, 23.900], // Tõstamaa
                        [58.550, 23.550], // Matsalu Bay South
                        [58.750, 23.500], // Matsalu Bay North
                        [58.950, 23.540], // Haapsalu / Rohuküla
                        [59.100, 23.500], // Noarootsi
                        [59.250, 23.950], // Kurkse
                        [59.340, 24.060], // Paldiski (Pakri Peninsula)
                        [59.400, 24.250], // Lohusalu
                        [59.450, 24.500], // Vääna-Jõesuu
                        [59.480, 24.600], // Kakumäe
                        [59.440, 24.750], // Tallinn (Port)
                        [59.500, 24.830], // Viimsi Peninsula tip
                        [59.500, 25.100], // Prangli area coast
                        [59.550, 25.300], // Kaberneeme
                        [59.650, 25.650], // Juminda Peninsula
                        [59.670, 25.800], // Pärispea Peninsula (Northernmost mainland)
                        [59.580, 26.000], // Käsmu
                        [59.550, 26.500], // Kunda
                        [59.420, 26.950], // Purtse
                        [59.430, 27.500], // Toila
                        [59.400, 27.900], // Sillamäe
                        [59.479, 28.042]  // Close Loop
                    ];

                    const saaremaa = [
                        [58.640, 23.150],
                        [58.550, 23.350],
                        [58.480, 23.000],
                        [58.350, 22.800],
                        [58.200, 22.500],
                        [57.900, 22.050],
                        [58.150, 22.150],
                        [58.250, 21.800],
                        [58.500, 21.850],
                        [58.580, 22.000],
                        [58.650, 22.600],
                        [58.640, 23.150]
                    ];

                    const hiiumaa = [
                        [59.080, 22.900],
                        [59.000, 23.050],
                        [58.800, 22.950],
                        [58.750, 22.600],
                        [58.900, 22.030],
                        [59.000, 22.200],
                        [59.080, 22.900]
                    ];

                    const estonianBorder = L.polygon([mainland, saaremaa, hiiumaa], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.08,
                        weight: 2,
                        dashArray: '4, 4',
                        opacity: 0.8,
                        smoothFactor: 1.0
                    }).addTo(militaryMap);

                    estonianBorder.bindPopup(`
                            <div class="text-center">
                                <strong data-key="t-republic-of-estonia">Republic of Estonia</strong><br>
                                <span class="badge bg-primary" data-key="t-nato-member">NATO Member</span>
                                <hr class="my-1">
                                <small class="text-muted" data-key="t-monitoring-active-airspace">Monitoring Active Airspace</small>
                            </div>
                        `);
                    const estonianCities = [
                        {name: 'Tallinn', lat: 59.4370, lon: 24.7536},
                        {name: 'Tartu', lat: 58.3780, lon: 26.7290},
                        {name: 'Narva', lat: 59.3797, lon: 28.1797},
                        {name: 'Pärnu', lat: 58.3855, lon: 24.4971},
                        {name: 'Kohtla-Järve', lat: 59.3986, lon: 27.2508},
                        {name: 'Viljandi', lat: 58.3639, lon: 25.5900},
                        {name: 'Rakvere', lat: 59.3494, lon: 26.3628},
                        {name: 'Kuressaare', lat: 58.2532, lon: 22.4886}
                    ];

                    estonianCities.forEach(city => {
                        L.circleMarker([city.lat, city.lon], {
                            radius: 5,
                            fillColor: '#0d6efd',
                            color: '#fff',
                            weight: 1,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(militaryMap).bindPopup(`<strong>${city.name}</strong><br>City`);
                    });

                    const militaryBases = [
                        {name: 'Ämari Air Base', lat: 59.2603, lon: 24.2084, radius: 3000, type: 'airbase'},
                        {name: 'Tallinn Airport (Mil)', lat: 59.4133, lon: 24.8328, radius: 2000, type: 'airport'},
                        {name: 'Tapa Army Base', lat: 59.2667, lon: 25.9667, radius: 2500, type: 'army'},
                        {name: 'Paldiski Naval Base', lat: 59.3567, lon: 24.0531, radius: 2000, type: 'naval'},
                        {name: 'Jägala Airfield', lat: 59.4500, lon: 25.2000, radius: 1500, type: 'airfield'},
                    ];

                    militaryBases.forEach(base => {
                        L.circle([base.lat, base.lon], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.15,
                            radius: base.radius,
                            weight: 1
                        }).bindPopup(`<b>${base.name}</b><br><span data-key="t-military-installation">Military Installation</span><br><span data-key="t-type">Type</span>: ${base.type}`).addTo(militaryMap);

                        L.marker([base.lat, base.lon], {
                            icon: L.divIcon({
                                html: `<div style="background-color: #dc3545; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center;">
                                       <i class="fas fa-${base.type === 'airbase' ? 'fighter-jet' : base.type === 'naval' ? 'ship' : 'shield-alt'}" style="color: white; font-size: 8px;"></i>
                                       </div>`,
                                className: 'military-base-marker',
                                iconSize: [16, 16]
                            })
                        }).addTo(militaryMap);
                    });

                    const borderCrossings = [
                        {name: 'Narva-Ivangorod', lat: 59.380, lon: 28.200, type: 'Road/Rail'},
                        {name: 'Koidula', lat: 57.833, lon: 27.267, type: 'Road'},
                        {name: 'Luhamaa', lat: 57.942, lon: 26.983, type: 'Road'},
                        {name: 'Valga-Valka', lat: 57.775, lon: 26.040, type: 'Road/Rail'}
                    ];

                    borderCrossings.forEach(crossing => {
                        L.marker([crossing.lat, crossing.lon], {
                            icon: L.divIcon({
                                html: '<div style="background-color: #ff6b6b; width: 10px; height: 10px; border-radius: 50%; border: 2px solid white;"></div>',
                                className: 'border-crossing-marker',
                                iconSize: [10, 10]
                            })
                        }).addTo(militaryMap).bindPopup(`<strong>${crossing.name}</strong><br>Border Crossing`);
                    });

                    const sensitiveAirspace = [
                        {
                            name: 'Tallinn Control Zone',
                            coords: [[59.2, 24.3], [59.2, 25.4], [59.7, 25.4], [59.7, 24.3]],
                            color: '#ff0000',
                            fillOpacity: 0.05
                        },
                        {
                            name: 'Ämari Air Base Zone',
                            coords: [[59.20, 24.15], [59.20, 24.25], [59.32, 24.25], [59.32, 24.15]],
                            color: '#ff6b6b',
                            fillOpacity: 0.1
                        },
                        {
                            name: 'Tapa Military Zone',
                            coords: [[59.20, 25.80], [59.20, 26.10], [59.33, 26.10], [59.33, 25.80]],
                            color: '#ff6b6b',
                            fillOpacity: 0.1
                        }
                    ];

                    sensitiveAirspace.forEach(zone => {
                        L.polygon(zone.coords, {
                            color: zone.color,
                            fillColor: zone.color,
                            fillOpacity: zone.fillOpacity,
                            weight: 1,
                            dashArray: '5, 5'
                        }).addTo(militaryMap).bindPopup(`<strong>${zone.name}</strong><br>Restricted Airspace`);
                    });

                    const legend = L.control({position: 'bottomright'});
                    legend.onAdd = function() {
                        const div = L.DomUtil.create('div', 'info legend');
                        div.style.backgroundColor = 'white';
                        div.style.padding = '10px';
                        div.style.borderRadius = '5px';
                        div.style.boxShadow = '0 0 15px rgba(0,0,0,0.2)';
                        div.style.maxWidth = '200px';

                        div.innerHTML = `
                            <h6 style="margin-top: 0; margin-bottom: 10px;"><strong data-key="t-map-legend">Map Legend</strong></h6>
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <div style="background-color: #dc3545; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; border: 2px solid white;"></div>
                                <span data-key="t-military-aircraft">Military Aircraft</span>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <div style="background-color: #fd7e14; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; border: 2px solid white;"></div>
                                <span data-key="t-military-drone">Military Drone</span>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <div style="background-color: #0dcaf0; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; border: 2px solid white;"></div>
                                <span data-key="t-nato-aircraft">NATO Aircraft</span>
                            </div>
                            <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                <div style="background-color: #dc3545; width: 12px; height: 12px; border-radius: 50%; margin-right: 8px; border: 2px solid white; opacity: 0.5;"></div>
                                <span data-key="t-military-base">Military Base</span>
                            </div>
                            <div style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 10px;">
                                <small><strong data-key="t-estonian-border-shown-in-blue-dashed-line">Estonian Border shown in blue dashed line</strong></small>
                            </div>
                        `;
                        return div;
                    };
                    legend.addTo(militaryMap);

                    isMilitaryMapInitialized = true;

                    if (typeof window.militaryMarkersData !== 'undefined') {
                        updateMilitaryMarkers(window.militaryMarkersData);
                    }

                } catch (error) {
                    console.error('Military map initialization failed:', error);
                }
            }

            function updateMilitaryMarkers(aircraftData) {
                if (!isMilitaryMapInitialized) return;

                let markersArray = [];
                try {
                    if (typeof aircraftData === 'string') {
                        markersArray = JSON.parse(aircraftData);
                    } else if (aircraftData && typeof aircraftData === 'object' && aircraftData.markers) {
                        markersArray = (typeof aircraftData.markers === 'string') ? JSON.parse(aircraftData.markers) : aircraftData.markers;
                    } else if (Array.isArray(aircraftData)) {
                        markersArray = aircraftData;
                    } else if (aircraftData && aircraftData.length !== undefined) {
                        markersArray = Array.from(aircraftData);
                    }
                } catch (e) {
                    console.error('Error parsing aircraft data:', e);
                    return;
                }

                militaryMarkers.forEach(marker => {
                    if (militaryMap && militaryMap.hasLayer(marker)) {
                        militaryMap.removeLayer(marker);
                    }
                });
                militaryMarkers.clear();

                markersArray.forEach(aircraft => {
                    if (!aircraft || !aircraft.latitude || !aircraft.longitude) return;

                    let color = militaryColorMap.military;
                    let icon = 'fighter-jet';

                    if (aircraft.is_drone) {
                        color = militaryColorMap.drone;
                        icon = 'drone';
                    } else if (aircraft.is_nato) {
                        color = militaryColorMap.nato;
                        icon = 'flag';
                    }

                    if (!aircraft.is_active) {
                        color = militaryColorMap.inactive;
                    }

                    const latitude = parseFloat(aircraft.latitude);
                    const longitude = parseFloat(aircraft.longitude);
                    const heading = parseFloat(aircraft.heading) || 0;

                    const customIcon = L.divIcon({
                        html: `
                            <div style="
                                background-color: ${color};
                                width: ${aircraft.is_drone ? '18px' : '22px'};
                                height: ${aircraft.is_drone ? '18px' : '22px'};
                                border-radius: 50%;
                                border: 2px solid white;
                                box-shadow: 0 0 8px rgba(0,0,0,0.7);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: white;
                                font-size: ${aircraft.is_drone ? '8px' : '10px'};
                                cursor: pointer;
                                transform: rotate(${heading}deg);
                            ">
                                <i class="fas fa-${icon}"></i>
                            </div>
                        `,
                        className: 'military-aircraft-marker',
                        iconSize: [26, 26],
                        iconAnchor: [13, 13],
                        popupAnchor: [0, -13]
                    });

                    try {
                        const marker = L.marker([latitude, longitude], {
                            icon: customIcon,
                            title: `${aircraft.callsign || aircraft.hex} - ${aircraft.type || 'Military Aircraft'}`,
                            riseOnHover: true
                        });

                        marker.bindPopup(createMilitaryPopupContent(aircraft));

                        marker.on('click', function() {
                            window.dispatchEvent(new CustomEvent('view-aircraft-details', {
                                detail: { hex: aircraft.hex }
                            }));
                        });

                        marker.addTo(militaryMap);
                        militaryMarkers.set(aircraft.hex, marker);

                    } catch (error) {
                        console.error(`Failed to create marker for ${aircraft.hex}:`, error);
                    }
                });

                if (militaryMarkers.size > 0) {
                    const bounds = L.latLngBounds(Array.from(militaryMarkers.values()).map(m => m.getLatLng()));
                    if (bounds.isValid()) {
                        militaryMap.fitBounds(bounds.pad(0.1), { padding: [50, 50], maxZoom: 10, animate: true });
                    }
                }
            }

            function createMilitaryPopupContent(aircraft) {
                const altitude = aircraft.altitude ? Math.round(parseFloat(aircraft.altitude)) : 'N/A';
                const speed = aircraft.speed ? Math.round(parseFloat(aircraft.speed)) : 'N/A';

                let badges = '';
                if (aircraft.is_drone) badges += '<span class="badge bg-warning me-1" data-key="t-drone">Drone</span>';
                if (aircraft.is_nato) badges += '<span class="badge bg-info me-1">NATO</span>';
                if (aircraft.in_estonia) badges += '<span class="badge bg-success me-1" data-key="t-in-estonia">In Estonia</span>';

                return `
                <div style="min-width: 240px;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1"><strong>${aircraft.callsign || aircraft.hex}</strong></h6>
                            <small class="text-muted">${aircraft.type || 'Military Aircraft'}</small>
                        </div>
                        <div>${aircraft.is_active ? '<span class="badge bg-success" data-key="t-active">Active</span>' : '<span class="badge bg-secondary" data-key="t-inactive">Inactive</span>'}</div>
                    </div>
                    <hr class="my-2">
                    <div class="mb-2">
                        <strong>${aircraft.country || 'Unknown'}</strong>
                        <div class="mt-1">${badges}</div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6"><small><strong>Alt:</strong></small><br>${altitude} m</div>
                        <div class="col-6"><small><strong data-key="t-speed">Speed:</strong></small><br>${speed} km/h</div>
                        <div class="col-12"><small><strong>Pos:</strong></small><br><code>${parseFloat(aircraft.latitude).toFixed(4)}, ${parseFloat(aircraft.longitude).toFixed(4)}</code></div>
                    </div>
                    <div class="text-center mt-2">
                        <button onclick="window.dispatchEvent(new CustomEvent('view-aircraft-details', { detail: { hex: '${aircraft.hex}' } }))" class="btn btn-sm btn-danger w-100">
                            <i class="fas fa-search me-1"></i> <span data-key="t-details">Details</span>
                        </button>
                    </div>
                </div>
                `;
            }
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.livewire !== 'undefined') {
                    window.militaryMarkersData = @json($mapMarkersData);
                }

                setTimeout(() => {
                    initMilitaryMap();
                    if (militaryMap) {

                        militaryMap.fitBounds([[57.5, 21.5], [60.0, 28.5]], { padding: [20, 20] });
                    }
                }, 500);

                setInterval(() => {
                    if (typeof Livewire !== 'undefined') Livewire.dispatch('refreshData');
                }, 30000);

                window.addEventListener('view-aircraft-details', function(event) {
                    if (typeof Livewire !== 'undefined') Livewire.dispatch('viewAircraftDetails', { hex: event.detail.hex });
                });
            });

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('map-refreshed', (event) => updateMilitaryMarkers(event));
            });

            window.addEventListener('resize', () => {
                if (militaryMap) setTimeout(() => militaryMap.invalidateSize(), 100);
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="{{ asset('user/assets/css/pages/military-monitor.css') }}" />
    @endpush
</div>
