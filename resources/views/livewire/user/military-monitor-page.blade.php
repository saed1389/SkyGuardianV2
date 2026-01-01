<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-fighter-jet me-2"></i>Military Monitoring
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-danger">
                                    <i class="fas fa-satellite-dish me-1"></i>
                                    Active: {{ $stats['active_last_24h'] ?? 0 }}
                                </span>
                                <button wire:click="refreshData" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-redo"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Real-time tracking of military aircraft in the region</p>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Total Military Aircraft</p>
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
                                        <span class="badge bg-danger me-1">Active 24h: {{ $stats['active_last_24h'] ?? 0 }}</span>
                                        <span class="text-warning">{{ count($aircraftPositions) }} with positions</span>
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
                                        <p class="text-muted mb-1">Military Drones</p>
                                        <h3 class="mb-0">{{ $stats['drones'] ?? 0 }}</h3>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning bg-opacity-20 rounded fs-22">
                                            <i class="fas fa-drone"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" role="progressbar"
                                             style="width: {{ $stats['total_military'] > 0 ? ($stats['drones'] / $stats['total_military'] * 100) : 0 }}%">
                                        </div>
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
                                        <p class="text-muted mb-1">NATO Aircraft</p>
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
                                        <div class="progress-bar bg-info" role="progressbar"
                                             style="width: {{ $stats['total_military'] > 0 ? ($stats['nato'] / $stats['total_military'] * 100) : 0 }}%">
                                        </div>
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
                                        <p class="text-muted mb-1">High Threat (≥ Level 4)</p>
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
                                        Threat distribution:
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

                <!-- Top Countries -->
                @if(!empty($stats['top_countries']))
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Top Countries by Military Aircraft</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($stats['top_countries'] as $country => $count)
                                            <div class="col-md-2 col-4 mb-3">
                                                <div class="text-center">
                                                    <div class="h4 fw-bold">{{ $country }}</div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                             style="width: {{ $count / max($stats['total_military'], 1) * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $count }} aircraft</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Map Container -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Military Aircraft Positions</h5>
                                    <span class="badge bg-danger">
                                        {{ count($mapMarkersData) }} aircraft on map
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
                                                <span class="badge bg-danger me-1">●</span> Military
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-warning me-1">●</span> Drone
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-info me-1">●</span> NATO
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-success me-1">●</span> In Estonia
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            Click markers for details • Red markers = active within 30 min
                                        </small>
                                    </div>
                                </div>
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
                                        <label class="form-label">Country</label>
                                        <select wire:model.live="filterCountry" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Countries</option>
                                            @foreach($countryOptions as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Threat Level</label>
                                        <select wire:model.live="filterThreatLevel" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Levels</option>
                                            <option value="4">High (4-5)</option>
                                            <option value="3">Medium (3)</option>
                                            <option value="1">Low (1-2)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Type</label>
                                        <select wire:model.live="filterType" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Military</option>
                                            <option value="drone">Drones Only</option>
                                            <option value="nato">NATO Only</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Time Range</label>
                                        <select wire:model.live="timeRange" wire:change="applyFilters" class="form-select">
                                            <option value="1hour">Last Hour</option>
                                            <option value="6hours">Last 6 Hours</option>
                                            <option value="24hours">Last 24 Hours</option>
                                            <option value="7days">Last 7 Days</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Search</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                   class="form-control" placeholder="Hex, callsign, type...">
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

                <!-- Military Aircraft Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Military Aircraft Database</h5>
                                    <span class="badge bg-light text-dark">
                                        {{ count($militaryAircraft) }} records
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-danger" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading military aircraft data...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th>Hex</th>
                                                <th>Callsign / Registration</th>
                                                <th>Type / Name</th>
                                                <th>Country / NATO</th>
                                                <th>Threat Level</th>
                                                <th>Last Position</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($aircraftPositions as $item)
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
                                                        <div>{{ $aircraft->type ?? 'Unknown' }}</div>
                                                        <small class="text-muted">{{ $aircraft->aircraft_name ?? 'Unknown aircraft' }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ $aircraft->country ?? 'Unknown' }}</div>
                                                        @if($aircraft->is_nato)
                                                            <span class="badge bg-info">NATO</span>
                                                        @endif
                                                        @if($aircraft->is_friendly)
                                                            <span class="badge bg-success">Friendly</span>
                                                        @endif
                                                        @if($aircraft->is_potential_threat)
                                                            <span class="badge bg-danger">Potential Threat</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $aircraft->threat_level >= 4 ? 'danger' : ($aircraft->threat_level >= 3 ? 'warning' : 'success') }}"
                                                                     style="width: {{ $aircraft->threat_level * 20 }}%"></div>
                                                            </div>
                                                            <strong>{{ $aircraft->threat_level }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($position)
                                                            <div>
                                                                <small class="text-muted d-block">Position:</small>
                                                                <code>{{ number_format($position->latitude, 4) }}, {{ number_format($position->longitude, 4) }}</code>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Time:</small>
                                                                <small>{{ \Carbon\Carbon::parse($position->position_time)->diffForHumans() }}</small>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">No recent position</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($isActive)
                                                            <span class="badge bg-success">
                                                        <i class="fas fa-circle me-1"></i> Active
                                                    </span>
                                                        @else
                                                            <span class="badge bg-secondary">
                                                        <i class="fas fa-clock me-1"></i> Inactive
                                                    </span>
                                                        @endif
                                                        @if($position && $position->in_estonia)
                                                            <span class="badge bg-success mt-1 d-block">In Estonia</span>
                                                        @endif
                                                        @if($position && $position->near_sensitive)
                                                            <span class="badge bg-danger mt-1 d-block">Near Sensitive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button wire:click="viewAircraftDetails('{{ $aircraft->hex }}')"
                                                                class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-search"></i> Details
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-fighter-jet fa-2x mb-2"></i>
                                                            <p>No military aircraft found</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            @if(count($militaryAircraft) > 0)
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Showing {{ count($militaryAircraft) }} military aircraft •
                                            {{ count($aircraftPositions) }} with recent positions
                                        </small>
                                        <button wire:click="refreshData" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-sync-alt"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aircraft Details Modal -->
    @if($showDetailsModal && $selectedAircraft)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-fighter-jet me-2"></i>
                            Military Aircraft Details
                            <span class="badge bg-light text-dark ms-2">HEX: {{ $selectedAircraft->hex }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Aircraft Info -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">AIRCRAFT INFO</h6>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Hex Code</small>
                                            <div class="h4 font-monospace fw-bold">{{ $selectedAircraft->hex }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Callsign</small>
                                            <div class="h5">{{ $selectedAircraft->callsign ?? 'N/A' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Registration</small>
                                            <div class="h5">{{ $selectedAircraft->registration ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-danger bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">CLASSIFICATION</h6>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Military</span>
                                                <span class="badge bg-danger">YES</span>
                                            </div>
                                            @if($selectedAircraft->is_drone)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span>Drone</span>
                                                    <span class="badge bg-warning">YES</span>
                                                </div>
                                            @endif
                                            @if($selectedAircraft->is_nato)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span>NATO</span>
                                                    <span class="badge bg-info">YES</span>
                                                </div>
                                            @endif
                                            @if($selectedAircraft->is_friendly)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span>Friendly</span>
                                                    <span class="badge bg-success">YES</span>
                                                </div>
                                            @endif
                                            @if($selectedAircraft->is_potential_threat)
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span>Potential Threat</span>
                                                    <span class="badge bg-danger">YES</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-warning bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">THREAT ASSESSMENT</h6>
                                        <div class="text-center">
                                            <div class="display-4 fw-bold text-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}">
                                                Level {{ $selectedAircraft->threat_level }}
                                            </div>
                                            <div class="mt-3">
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}"
                                                         style="width: {{ $selectedAircraft->threat_level * 20 }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aircraft Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Aircraft Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Type</small>
                                                    <strong>{{ $selectedAircraft->type ?? 'Unknown' }}</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Aircraft Name</small>
                                                    <strong>{{ $selectedAircraft->aircraft_name ?? 'Unknown' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Category</small>
                                                    <strong>{{ $selectedAircraft->category ?? 'Unknown' }}</strong>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Role</small>
                                                    <strong>{{ $selectedAircraft->role ?? 'Unknown' }}</strong>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Country of Origin</small>
                                                    <div class="h5 fw-bold">{{ $selectedAircraft->country ?? 'Unknown' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Last Seen</h6>
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
                                                <p class="text-muted mb-0">No last seen data</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Position -->
                        @if(isset($selectedAircraft->latest_position))
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Latest Position</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Coordinates</small>
                                                        <div class="h5">
                                                            {{ number_format($selectedAircraft->latest_position->latitude, 4) }},
                                                            {{ number_format($selectedAircraft->latest_position->longitude, 4) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Altitude</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->altitude) }} m</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Speed</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->speed) }} km/h</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Heading</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->heading) }}°</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @if($selectedAircraft->latest_position->in_estonia)
                                                            <span class="badge bg-success">In Estonia</span>
                                                        @endif
                                                        @if($selectedAircraft->latest_position->near_sensitive)
                                                            <span class="badge bg-danger">Near Sensitive Area</span>
                                                        @endif
                                                        @if($selectedAircraft->latest_position->near_military_base)
                                                            <span class="badge bg-warning">Near Military Base</span>
                                                        @endif
                                                        @if($selectedAircraft->latest_position->near_border)
                                                            <span class="badge bg-info">Near Border</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            Position time: {{ \Carbon\Carbon::parse($selectedAircraft->latest_position->position_time)->format('Y-m-d H:i:s') }}
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

                        <!-- Position History -->
                        @if(isset($selectedAircraft->positions) && count($selectedAircraft->positions) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Recent Position History</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Position</th>
                                                        <th>Altitude</th>
                                                        <th>Speed</th>
                                                        <th>Heading</th>
                                                        <th>Status</th>
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
                                                                    <span class="badge bg-success">In Estonia</span>
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
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <button type="button" class="btn btn-danger">
                            <i class="fas fa-flag me-1"></i> Flag for Monitoring
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

            // Color mapping for military aircraft
            const militaryColorMap = {
                'military': '#dc3545', // Red for military
                'drone': '#fd7e14',    // Orange for drones
                'nato': '#0dcaf0',     // Blue for NATO
                'inactive': '#6c757d', // Gray for inactive
            };

            // Initialize military map
            function initMilitaryMap() {
                if (isMilitaryMapInitialized) return;

                console.log('Initializing military map...');

                try {
                    militaryMap = L.map('military-map').setView([59.42, 24.83], 8);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(militaryMap);

                    // Estonian border
                    L.polygon([
                        [59.0, 21.5], [59.0, 28.5], [57.5, 28.5], [57.5, 21.5]
                    ], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.05,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(militaryMap).bindPopup('Estonian Airspace');

                    // Military bases
                    const militaryBases = [
                        {name: 'Ämari Air Base', lat: 59.2603, lon: 24.2084, radius: 3000},
                        {name: 'Tallinn Airport (Military)', lat: 59.4133, lon: 24.8328, radius: 2000},
                        {name: 'Tapa Army Base', lat: 59.2667, lon: 25.9667, radius: 2000},
                        {name: 'Paldiski Naval Base', lat: 59.3567, lon: 24.0531, radius: 2000},
                    ];

                    militaryBases.forEach(base => {
                        L.circle([base.lat, base.lon], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.15,
                            radius: base.radius
                        }).bindPopup(`<b>${base.name}</b><br>Military Installation`).addTo(militaryMap);

                        // Add base marker
                        L.marker([base.lat, base.lon], {
                            icon: L.divIcon({
                                html: '<div style="background-color: #dc3545; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white;"></div>',
                                className: 'military-base-marker',
                                iconSize: [20, 20]
                            })
                        }).addTo(militaryMap);
                    });

                    isMilitaryMapInitialized = true;
                    console.log('Military map initialized successfully');

                    // Load initial markers
                    updateMilitaryMarkers(@json($mapMarkersData));

                } catch (error) {
                    console.error('Military map initialization failed:', error);
                }
            }

            // Update markers with military aircraft data - FIXED: Handle different data formats
            function updateMilitaryMarkers(aircraftData) {
                if (!isMilitaryMapInitialized) {
                    console.log('Military map not initialized yet');
                    return;
                }

                console.log('Received data for updateMilitaryMarkers:', aircraftData);
                console.log('Type of aircraftData:', typeof aircraftData);

                // Handle different data formats
                let markersArray = [];

                try {
                    // If aircraftData is a string (JSON), parse it
                    if (typeof aircraftData === 'string') {
                        markersArray = JSON.parse(aircraftData);
                    }
                    // If it's already an array/object with markers property (from Livewire event)
                    else if (aircraftData && typeof aircraftData === 'object' && aircraftData.markers) {
                        // Handle Livewire event format with markers property
                        if (typeof aircraftData.markers === 'string') {
                            markersArray = JSON.parse(aircraftData.markers);
                        } else {
                            markersArray = aircraftData.markers;
                        }
                    }
                    // If it's already an array, use it directly
                    else if (Array.isArray(aircraftData)) {
                        markersArray = aircraftData;
                    }

                    else if (aircraftData && typeof aircraftData === 'object' && !Array.isArray(aircraftData)) {
                    // Check if it has length property (array-like)
                    if (aircraftData.length !== undefined) {
                        markersArray = Array.from(aircraftData);
                    } else {
                        console.error('Invalid aircraft data format (object without markers):', aircraftData);
                        return;
                    }
                }
            else {
                    console.error('Invalid aircraft data format:', aircraftData);
                    return;
                }
            } catch (e) {
                console.error('Error parsing aircraft data:', e, aircraftData);
                return;
            }

            console.log('Updating military markers with', markersArray.length, 'aircraft');

            // Clear existing markers
            militaryMarkers.forEach(marker => {
                if (militaryMap && militaryMap.hasLayer(marker)) {
                    militaryMap.removeLayer(marker);
                }
            });
            militaryMarkers.clear();

            // Add new markers
            markersArray.forEach(aircraft => {
                if (!aircraft || !aircraft.latitude || !aircraft.longitude) {
                    console.warn('Skipping invalid aircraft data:', aircraft);
                    return;
                }

                // Determine color and icon
                let color = militaryColorMap.military;
                let icon = 'fighter-jet';

                if (aircraft.is_drone) {
                    color = militaryColorMap.drone;
                    icon = 'drone';
                } else if (aircraft.is_nato) {
                    color = militaryColorMap.nato;
                    icon = 'flag';
                }

                // Inactive aircraft (over 30 minutes)
                if (!aircraft.is_active) {
                    color = militaryColorMap.inactive;
                }

                // Ensure numeric values
                const latitude = parseFloat(aircraft.latitude);
                const longitude = parseFloat(aircraft.longitude);
                const heading = parseFloat(aircraft.heading) || 0;

                // Create custom icon
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
                        alt: `Military aircraft ${aircraft.hex}`,
                        riseOnHover: true
                    });

                    // Create popup content
                    const popupContent = createMilitaryPopupContent(aircraft);
                    marker.bindPopup(popupContent);

                    // Add to map
                    marker.addTo(militaryMap);

                    // Store in markers map
                    militaryMarkers.set(aircraft.hex, marker);

                } catch (error) {
                    console.error(`Failed to create marker for military aircraft ${aircraft.hex}:`, error);
                }
            });

            // Fit map to markers if we have any
            if (militaryMarkers.size > 0) {
                const bounds = L.latLngBounds(Array.from(militaryMarkers.values()).map(m => m.getLatLng()));
                if (bounds.isValid()) {
                    militaryMap.fitBounds(bounds.pad(0.1), {
                        padding: [50, 50],
                        maxZoom: 10,
                        animate: true
                    });
                }
            }

            console.log(`Added ${militaryMarkers.size} military markers to map`);
            }

            // Create popup content for military aircraft
            function createMilitaryPopupContent(aircraft) {
                const altitude = aircraft.altitude ? Math.round(parseFloat(aircraft.altitude)) : 'N/A';
                const speed = aircraft.speed ? Math.round(parseFloat(aircraft.speed)) : 'N/A';
                const heading = aircraft.heading ? parseFloat(aircraft.heading).toFixed(0) + '°' : 'N/A';

                const positionTime = aircraft.position_time ?
                    new Date(aircraft.position_time).toLocaleTimeString('et-EE', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }) : 'Unknown';

                // Status badge
                let statusBadge = '';
                if (aircraft.is_active) {
                    statusBadge = '<span class="badge bg-success">Active</span>';
                } else {
                    statusBadge = '<span class="badge bg-secondary">Inactive</span>';
                }

                // Additional badges
                let badges = '';
                if (aircraft.is_drone) badges += '<span class="badge bg-warning me-1">Drone</span>';
                if (aircraft.is_nato) badges += '<span class="badge bg-info me-1">NATO</span>';
                if (aircraft.in_estonia) badges += '<span class="badge bg-success me-1">In Estonia</span>';
                if (aircraft.near_sensitive) badges += '<span class="badge bg-danger me-1">Near Sensitive</span>';

                return `
            <div style="min-width: 240px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1"><strong>${aircraft.callsign || aircraft.hex}</strong></h6>
                        <small class="text-muted">${aircraft.type || 'Military Aircraft'}</small>
                    </div>
                    <div>${statusBadge}</div>
                </div>

                <hr class="my-2">

                <div class="mb-2">
                    <strong>${aircraft.country || 'Unknown country'}</strong>
                    <div class="mt-1">${badges}</div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <small><strong>Threat Level:</strong></small><br>
                        <span class="badge bg-${aircraft.threat_level >= 4 ? 'danger' : 'warning'}">
                            Level ${aircraft.threat_level}
                        </span>
                    </div>
                    <div class="col-6">
                        <small><strong>Hex:</strong></small><br>
                        <code>${aircraft.hex}</code>
                    </div>
                    <div class="col-12">
                        <small><strong>Position:</strong></small><br>
                        <code>${aircraft.latitude.toFixed(4)}, ${aircraft.longitude.toFixed(4)}</code>
                    </div>
                    <div class="col-6">
                        <small><strong>Altitude:</strong></small><br>
                        ${altitude} m
                    </div>
                    <div class="col-6">
                        <small><strong>Speed:</strong></small><br>
                        ${speed} km/h
                    </div>
                </div>

                <hr class="my-2">
                <div class="text-center">
                    <small class="text-muted">Last update: ${positionTime}</small>
                </div>

                <div class="text-center mt-2">
                    <button onclick="window.dispatchEvent(new CustomEvent('view-aircraft-details', { detail: { hex: '${aircraft.hex}' } }))"
                            class="btn btn-sm btn-danger w-100">
                        <i class="fas fa-search me-1"></i> View Details
                    </button>
                </div>
            </div>
        `;
            }

            // Initialize when page loads
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Page loaded, initializing military map...');
                setTimeout(initMilitaryMap, 100);

                // Auto-refresh every 30 seconds
                setInterval(() => {
                    console.log('Auto-refresh triggered');
                    @this.refreshData();
                }, 30000);

                // Listen for custom event to view aircraft details
                window.addEventListener('view-aircraft-details', function(event) {
                    console.log('Dispatching viewAircraftDetails with hex:', event.detail.hex);
                    @this.viewAircraftDetails(event.detail.hex);
                });
            });

            // Listen for Livewire events - UPDATED: Handle the event properly
            document.addEventListener('livewire:initialized', () => {
                console.log('Livewire initialized for military monitoring');

                // Update map when data is refreshed
                Livewire.on('map-refreshed', (event) => {
                    console.log('Map refresh event received:', event);
                    // Pass the entire event object to updateMilitaryMarkers
                    // It will handle the data format
                    updateMilitaryMarkers(event);
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (militaryMap) {
                    setTimeout(() => militaryMap.invalidateSize(), 100);
                }
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            #military-map {
                min-height: 500px;
                border-radius: 4px;
                background-color: #f8f9fa;
            }
            .military-aircraft-marker {
                background: transparent !important;
                border: none !important;
            }
            .military-base-marker {
                background: transparent !important;
                border: none !important;
            }
            .bg-opacity-10 {
                background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
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
            .table-danger {
                background-color: rgba(220, 53, 69, 0.05) !important;
            }
            .table-warning {
                background-color: rgba(255, 193, 7, 0.05) !important;
            }
            .font-monospace {
                font-family: 'Courier New', monospace;
            }
        </style>
    @endpush
</div>
