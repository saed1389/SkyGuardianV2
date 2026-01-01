<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-database me-2"></i>Aircraft Database
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-plane me-1"></i>
                                    {{ $stats['total'] ?? 0 }} Aircraft
                                </span>
                                <button wire:click="refreshData" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-redo"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Comprehensive database of all tracked aircraft with detailed information</p>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-primary">{{ $stats['total'] ?? 0 }}</div>
                                <small class="text-muted">Total Aircraft</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-danger">{{ $stats['military'] ?? 0 }}</div>
                                <small class="text-muted">Military</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-warning">{{ $stats['drones'] ?? 0 }}</div>
                                <small class="text-muted">Drones</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-info bg-opacity-10 border-info">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-info">{{ $stats['nato'] ?? 0 }}</div>
                                <small class="text-muted">NATO</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-success bg-opacity-10 border-success">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-success">{{ $stats['active_24h'] ?? 0 }}</div>
                                <small class="text-muted">Active (24h)</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-secondary bg-opacity-10 border-secondary">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-secondary">{{ $stats['countries'] ?? 0 }}</div>
                                <small class="text-muted">Countries</small>
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
                                        <label class="form-label">Aircraft Type</label>
                                        <select wire:model.live="filterType" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Types</option>
                                            <option value="military">Military</option>
                                            <option value="civil">Civil</option>
                                            <option value="drone">Drones</option>
                                            <option value="nato">NATO</option>
                                        </select>
                                    </div>

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
                                        <label class="form-label">Status</label>
                                        <select wire:model.live="filterStatus" wire:change="applyFilters" class="form-select">
                                            <option value="all">All Status</option>
                                            <option value="active">Active (24h)</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Search Aircraft</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search"
                                                   class="form-control" placeholder="Hex, callsign, type, country...">
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

                <!-- Aircraft Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Aircraft Registry</h5>
                                    <span class="badge bg-light text-dark">
                                        Page {{ $currentPage }} of {{ $totalPages }} ({{ $totalAircraft }} total)
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading aircraft data...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 80px;">
                                                    <a href="javascript:void(0)" wire:click="sort('hex')" class="text-dark text-decoration-none">
                                                        Hex
                                                        @if($sortBy === 'hex')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 120px;">
                                                    <a href="javascript:void(0)" wire:click="sort('callsign')" class="text-dark text-decoration-none">
                                                        Callsign
                                                        @if($sortBy === 'callsign')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 150px;">
                                                    <a href="javascript:void(0)" wire:click="sort('type')" class="text-dark text-decoration-none">
                                                        Type / Name
                                                        @if($sortBy === 'type')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 120px;">
                                                    <a href="javascript:void(0)" wire:click="sort('country')" class="text-dark text-decoration-none">
                                                        Country
                                                        @if($sortBy === 'country')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 100px;">Classification</th>
                                                <th style="width: 100px;">
                                                    <a href="javascript:void(0)" wire:click="sort('threat_level')" class="text-dark text-decoration-none">
                                                        Threat
                                                        @if($sortBy === 'threat_level')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 150px;">
                                                    <a href="javascript:void(0)" wire:click="sort('last_seen')" class="text-dark text-decoration-none">
                                                        Last Seen
                                                        @if($sortBy === 'last_seen')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 150px;">Last Position</th>
                                                <th style="width: 80px;">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($aircraft as $ac)
                                                <tr class="{{ $ac->threat_level >= 4 ? 'table-danger' : ($ac->threat_level >= 3 ? 'table-warning' : '') }}">
                                                    <td>
                                                        <div class="fw-bold font-monospace">{{ $ac->hex }}</div>
                                                        @if($ac->registration)
                                                            <small class="text-muted">{{ $ac->registration }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ $ac->callsign ?? 'N/A' }}</div>
                                                    </td>
                                                    <td>
                                                        <div>{{ $ac->type ?? 'Unknown' }}</div>
                                                        <small class="text-muted">{{ Str::limit($ac->aircraft_name, 30) }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">{{ $ac->country ?? 'Unknown' }}</div>
                                                        @if($ac->is_nato)
                                                            <span class="badge bg-info mt-1">NATO</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @if($ac->is_military)
                                                                <span class="badge bg-danger">Military</span>
                                                            @else
                                                                <span class="badge bg-primary">Civil</span>
                                                            @endif
                                                            @if($ac->is_drone)
                                                                <span class="badge bg-warning">Drone</span>
                                                            @endif
                                                            @if($ac->is_friendly)
                                                                <span class="badge bg-success">Friendly</span>
                                                            @endif
                                                            @if($ac->is_potential_threat)
                                                                <span class="badge bg-danger">Threat</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $ac->threat_level >= 4 ? 'danger' : ($ac->threat_level >= 3 ? 'warning' : 'success') }}"
                                                                     style="width: {{ $ac->threat_level * 20 }}%"></div>
                                                            </div>
                                                            <strong>{{ $ac->threat_level }}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($ac->last_seen)
                                                            <div>{{ \Carbon\Carbon::parse($ac->last_seen)->format('M d, Y') }}</div>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($ac->last_seen)->format('H:i') }}
                                                                <br>
                                                                {{ \Carbon\Carbon::parse($ac->last_seen)->diffForHumans() }}
                                                            </small>
                                                        @else
                                                            <span class="text-muted">Never</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($ac->latitude && $ac->longitude)
                                                            <div>
                                                                <small class="text-muted d-block">Position:</small>
                                                                <code>{{ number_format($ac->latitude, 4) }}, {{ number_format($ac->longitude, 4) }}</code>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block">Time:</small>
                                                                <small>{{ $ac->position_time ? \Carbon\Carbon::parse($ac->position_time)->diffForHumans() : 'N/A' }}</small>
                                                            </div>
                                                            @if($ac->in_estonia)
                                                                <span class="badge bg-success mt-1">In Estonia</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">No position data</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button wire:click="viewAircraftDetails('{{ $ac->hex }}')"
                                                                class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-plane-slash fa-2x mb-2"></i>
                                                            <p>No aircraft found matching your criteria</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            @if(count($aircraft) > 0)
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Showing {{ (($currentPage - 1) * $perPage) + 1 }} to {{ min($currentPage * $perPage, $totalAircraft) }} of {{ $totalAircraft }} aircraft
                                        </small>

                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                                    <button class="page-link" wire:click="previousPage">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                </li>

                                                @php
                                                    $start = max(1, $currentPage - 2);
                                                    $end = min($totalPages, $currentPage + 2);
                                                @endphp

                                                @if($start > 1)
                                                    <li class="page-item">
                                                        <button class="page-link" wire:click="goToPage(1)">1</button>
                                                    </li>
                                                    @if($start > 2)
                                                        <li class="page-item disabled">
                                                            <span class="page-link">...</span>
                                                        </li>
                                                    @endif
                                                @endif

                                                @for($i = $start; $i <= $end; $i++)
                                                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                                        <button class="page-link" wire:click="goToPage({{ $i }})">{{ $i }}</button>
                                                    </li>
                                                @endfor

                                                @if($end < $totalPages)
                                                    @if($end < $totalPages - 1)
                                                        <li class="page-item disabled">
                                                            <span class="page-link">...</span>
                                                        </li>
                                                    @endif
                                                    <li class="page-item">
                                                        <button class="page-link" wire:click="goToPage({{ $totalPages }})">{{ $totalPages }}</button>
                                                    </li>
                                                @endif

                                                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                                                    <button class="page-link" wire:click="nextPage">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </nav>

                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted">Per page:</small>
                                            <select wire:model.live="perPage" wire:change="applyFilters" class="form-select form-select-sm" style="width: auto;">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <button wire:click="refreshData" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-sync-alt"></i>
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

    <!-- Aircraft Details Modal -->
    @if($showDetailsModal && $selectedAircraft)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" wire:ignore.self>
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-plane me-2"></i>
                            Aircraft Details
                            <span class="badge bg-light text-dark ms-2">HEX: {{ $selectedAircraft->hex }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">BASIC INFORMATION</h6>
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
                                <div class="card bg-info bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">AIRCRAFT SPECIFICATIONS</h6>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Type Code</small>
                                            <div class="h5">{{ $selectedAircraft->type ?? 'Unknown' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Aircraft Name</small>
                                            <div class="h5">{{ $selectedAircraft->aircraft_name ?? 'Unknown' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Category</small>
                                            <div class="h5">{{ $selectedAircraft->category ?? 'Unknown' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Role</small>
                                            <div class="h5">{{ $selectedAircraft->role ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-{{ $selectedAircraft->is_military ? 'danger' : 'primary' }} bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">CLASSIFICATION</h6>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Military</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_military ? 'danger' : 'secondary' }}">
                                                {{ $selectedAircraft->is_military ? 'YES' : 'NO' }}
                                            </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Drone</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_drone ? 'warning' : 'secondary' }}">
                                                {{ $selectedAircraft->is_drone ? 'YES' : 'NO' }}
                                            </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>NATO</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_nato ? 'info' : 'secondary' }}">
                                                {{ $selectedAircraft->is_nato ? 'YES' : 'NO' }}
                                            </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Friendly</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_friendly ? 'success' : 'secondary' }}">
                                                {{ $selectedAircraft->is_friendly ? 'YES' : 'NO' }}
                                            </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Potential Threat</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_potential_threat ? 'danger' : 'secondary' }}">
                                                {{ $selectedAircraft->is_potential_threat ? 'YES' : 'NO' }}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Country and Threat -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Country Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="display-4 fw-bold">{{ $selectedAircraft->country ?? 'Unknown' }}</div>
                                            <div class="mt-3">
                                                <span class="badge bg-secondary">Country of Origin</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }} bg-opacity-10">
                                    <div class="card-header">
                                        <h6 class="mb-0">Threat Assessment</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="display-4 fw-bold text-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}">
                                                Level {{ $selectedAircraft->threat_level }}
                                            </div>
                                            <div class="mt-3">
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}"
                                                         style="width: {{ $selectedAircraft->threat_level * 20 }}%"></div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <small class="text-muted">Threat scale: 1 (Low) to 5 (Critical)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Activity Timeline</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">First Seen</small>
                                                    @if(isset($selectedAircraft->first_seen) && $selectedAircraft->first_seen->position_time)
                                                        <div class="h5">{{ \Carbon\Carbon::parse($selectedAircraft->first_seen->position_time)->format('Y-m-d') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($selectedAircraft->first_seen->position_time)->format('H:i:s') }}</small>
                                                    @else
                                                        <div class="text-muted">Unknown</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Last Seen</small>
                                                    @if($selectedAircraft->last_seen)
                                                        <div class="h5">{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->format('Y-m-d') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->format('H:i:s') }}</small>
                                                        <br>
                                                        <span class="badge bg-{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->diffInHours() < 24 ? 'success' : 'secondary' }}">
                                                    {{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->diffForHumans() }}
                                                </span>
                                                    @else
                                                        <div class="text-muted">Unknown</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block">Database Entry</small>
                                                    <div>{{ \Carbon\Carbon::parse($selectedAircraft->created_at)->format('Y-m-d H:i:s') }}</div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($selectedAircraft->created_at)->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Latest Position</h6>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($selectedAircraft->latest_position))
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Coordinates</small>
                                                        <code class="h6">{{ number_format($selectedAircraft->latest_position->latitude, 4) }}, {{ number_format($selectedAircraft->latest_position->longitude, 4) }}</code>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Altitude</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->altitude) }} m</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block">Speed</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->speed) }} km/h</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
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
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-3">
                                                <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                                                <p class="text-muted mb-0">No position data available</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Position History -->
                        @if(isset($selectedAircraft->positions) && count($selectedAircraft->positions) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">Recent Position History (Last 50 positions)</h6>
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
                                                        <th>Threat</th>
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
                                                        <span class="badge bg-{{ $position->threat_level >= 4 ? 'danger' : ($position->threat_level >= 3 ? 'warning' : 'success') }}">
                                                            {{ $position->threat_level }}
                                                        </span>
                                                            </td>
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

                        <!-- Metadata (Collapsible) -->
                        @if($selectedAircraft->metadata)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <button class="btn btn-sm btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#metadataCollapse">
                                                <i class="fas fa-code me-1"></i> View Raw Metadata
                                            </button>
                                        </div>
                                        <div class="collapse" id="metadataCollapse">
                                            <div class="card-body">
                                                <pre class="mb-0" style="font-size: 11px; max-height: 200px; overflow: auto;">{{ json_encode(json_decode($selectedAircraft->metadata), JSON_PRETTY_PRINT) }}</pre>
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
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-flag me-1"></i> Flag for Monitoring
                        </button>
                        <button type="button" class="btn btn-success">
                            <i class="fas fa-download me-1"></i> Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
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
            .font-monospace {
                font-family: 'Courier New', monospace;
            }
            .table-danger {
                background-color: rgba(220, 53, 69, 0.05) !important;
            }
            .table-warning {
                background-color: rgba(255, 193, 7, 0.05) !important;
            }
            .modal-content {
                max-height: 90vh;
            }
            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }
            pre {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                padding: 10px;
                margin: 0;
            }
            .page-link {
                cursor: pointer;
            }
            .sortable {
                cursor: pointer;
            }
            .sortable:hover {
                background-color: rgba(0, 0, 0, 0.03);
            }
        </style>
    @endpush
</div>
