<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-database me-2"></i><span data-key="t-aircraft-database">Aircraft Database</span>
                            </h1>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-plane me-1"></i>
                                    {{ $stats['total'] ?? 0 }} <span data-key="t-aircraft">Aircraft</span>
                                </span>

                                <button wire:click="exportData" wire:loading.attr="disabled" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-excel me-1"></i>
                                    <span wire:loading.remove wire:target="exportData" data-key="t-export-list">Export List</span>
                                    <span wire:loading wire:target="exportData">...</span>
                                </button>

                                <button wire:click="refreshData" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-redo"></i> <span data-key="t-refresh">Refresh</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0" data-key="t-comprehensive-database-of-all-tracked-aircraft-with-detailed-information">Comprehensive database of all tracked aircraft with detailed information</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-primary">{{ $stats['total'] ?? 0 }}</div>
                                <small class="text-muted" data-key="t-total-aircraft">Total Aircraft</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-danger bg-opacity-10 border-danger">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-danger">{{ $stats['military'] ?? 0 }}</div>
                                <small class="text-muted" data-key="t-military">Military</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-warning">{{ $stats['drones'] ?? 0 }}</div>
                                <small class="text-muted" data-key="t-drones">Drones</small>
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
                                <small class="text-muted" data-key="t-active-24h">Active (24h)</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card bg-secondary bg-opacity-10 border-secondary">
                            <div class="card-body text-center">
                                <div class="display-6 fw-bold text-secondary">{{ $stats['countries'] ?? 0 }}</div>
                                <small class="text-muted" data-key="t-countries">Countries</small>
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
                                        <label class="form-label" data-key="t-aircraft-type">Aircraft Type</label>
                                        <select wire:model.live="filterType" wire:change="applyFilters" class="form-select">
                                            <option value="all" data-key="t-all-types">All Types</option>
                                            <option value="military" data-key="t-military">Military</option>
                                            <option value="civil" data-key="t-civil">Civil</option>
                                            <option value="drone" data-key="t-drones">Drones</option>
                                            <option value="nato">NATO</option>
                                        </select>
                                    </div>
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
                                        <label class="form-label" data-key="t-status">Status</label>
                                        <select wire:model.live="filterStatus" wire:change="applyFilters" class="form-select">
                                            <option value="all" data-key="t-all-status">All Status</option>
                                            <option value="active" data-key="t-active-24h">Active (24h)</option>
                                            <option value="inactive" data-key="t-inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" data-key="t-search-aircraft">Search Aircraft</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Hex, callsign, type, country...">
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
                                    <h5 class="card-title mb-0" data-key="t-aircraft-registry">Aircraft Registry</h5>
                                    <span class="badge bg-light text-dark">
                                        <span data-key="t-page">Page</span> {{ $currentPage }} of {{ $totalPages }} ({{ $totalAircraft }} <span data-key="t-total">total</span>)
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($loading)
                                    <div class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden" data-key="t-loading">Loading...</span>
                                        </div>
                                        <p class="mt-2" data-key="t-loading-aircraft-data">Loading aircraft data...</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                            <tr>
                                                <th style="width: 80px;">
                                                    <a href="javascript:void(0)" wire:click="sort('hex')" class="text-dark text-decoration-none">
                                                        <span data-key="t-hex">Hex</span>
                                                        @if($sortBy === 'hex')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 120px;">
                                                    <a href="javascript:void(0)" wire:click="sort('callsign')" class="text-dark text-decoration-none">
                                                        <span data-key="t-callsign">Callsign</span>
                                                        @if($sortBy === 'callsign')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 150px;">
                                                    <a href="javascript:void(0)" wire:click="sort('type')" class="text-dark text-decoration-none">
                                                        <span data-key="t-type-name">Type / Name</span>
                                                        @if($sortBy === 'type')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 120px;">
                                                    <a href="javascript:void(0)" wire:click="sort('country')" class="text-dark text-decoration-none">
                                                        <span data-key="t-country">Country</span>
                                                        @if($sortBy === 'country')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 100px;"><span data-key="t-classification">Classification</span></th>
                                                <th style="width: 100px;">
                                                    <a href="javascript:void(0)" wire:click="sort('threat_level')" class="text-dark text-decoration-none">
                                                        <span data-key="t-threat">Threat</span>
                                                        @if($sortBy === 'threat_level')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 150px;">
                                                    <a href="javascript:void(0)" wire:click="sort('last_seen')" class="text-dark text-decoration-none">
                                                        <span data-key="t-last-seen">Last Seen</span>
                                                        @if($sortBy === 'last_seen')
                                                            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                                        @else
                                                            <i class="fas fa-sort ms-1 text-muted"></i>
                                                        @endif
                                                    </a>
                                                </th>
                                                <th style="width: 150px;"><span data-key="t-last-position">Last Position</span></th>
                                                <th style="width: 80px;"><span data-key="t-actions">Actions</span></th>
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
                                                                <span class="badge bg-danger" data-key="t-military">Military</span>
                                                            @else
                                                                <span class="badge bg-primary" data-key="t-civil">Civil</span>
                                                            @endif
                                                            @if($ac->is_drone)
                                                                <span class="badge bg-warning" data-key="t-drone">Drone</span>
                                                            @endif
                                                            @if($ac->is_friendly)
                                                                <span class="badge bg-success" data-key="t-friendly">Friendly</span>
                                                            @endif
                                                            @if($ac->is_potential_threat)
                                                                <span class="badge bg-danger" data-key="t-threat">Threat</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $ac->threat_level >= 4 ? 'danger' : ($ac->threat_level >= 3 ? 'warning' : 'success') }}" style="width: {{ $ac->threat_level * 20 }}%"></div>
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
                                                            <span class="text-muted" data-key="t-never">Never</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($ac->latitude && $ac->longitude)
                                                            <div>
                                                                <small class="text-muted d-block"><span data-key="t-position">Position</span>:</small>
                                                                <code>{{ number_format($ac->latitude, 4) }}, {{ number_format($ac->longitude, 4) }}</code>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted d-block"><span data-key="t-time">Time</span>:</small>
                                                                <small>{{ $ac->position_time ? \Carbon\Carbon::parse($ac->position_time)->diffForHumans() : 'N/A' }}</small>
                                                            </div>
                                                            @if($ac->in_estonia)
                                                                <span class="badge bg-success mt-1" data-key="t-in-estonia">In Estonia</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted" data-key="t-no-position-data">No position data</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button wire:click="viewAircraftDetails('{{ $ac->hex }}')" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i> <span data-key="t-view">View</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-plane-slash fa-2x mb-2"></i>
                                                            <p data-key="t-no-aircraft-found-matching-your-criteria">No aircraft found matching your criteria</p>
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
                                            <span data-key="t-showing">Showing</span> {{ (($currentPage - 1) * $perPage) + 1 }} to {{ min($currentPage * $perPage, $totalAircraft) }} of {{ $totalAircraft }} <span data-key="t-aircraft">aircraft</span>
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
                                            <small class="text-muted"><span data-key="t-per-page">Per page</span>:</small>
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

    @if($showDetailsModal && $selectedAircraft)
        <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-plane me-2 text-white"></i>
                            <span class="text-white" data-key="t-aircraft-details">Aircraft Details</span>
                            <span class="badge bg-light text-dark ms-2"><span data-key="t-hex">HEX</span>: {{ $selectedAircraft->hex }}</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3 text-uppercase" data-key="t-basic-information">BASIC INFORMATION</h6>
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
                                <div class="card bg-info bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3" data-key="t-aircraft-specification">AIRCRAFT SPECIFICATIONS</h6>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-type-code">Type Code</small>
                                            <div class="h5">{!! $selectedAircraft->type ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-aircraft-name">Aircraft Name</small>
                                            <div class="h5">{!! $selectedAircraft->aircraft_name ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-category">Category</small>
                                            <div class="h5">{!! $selectedAircraft->category ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block" data-key="t-role">Role</small>
                                            <div class="h5">{!! $selectedAircraft->role ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-{{ $selectedAircraft->is_military ? 'danger' : 'primary' }} bg-opacity-10">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3 text-uppercase" data-key="t-classification">CLASSIFICATION</h6>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span data-key="t-military">Military</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_military ? 'danger' : 'secondary' }}">
                                                    {!! $selectedAircraft->is_military ? '<span class="text-uppercase" data-key="t-yes">YES</span>' : '<span class="text-uppercase" data-key="t-no">NO</span>' !!}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span data-key="t-drone">Drone</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_drone ? 'warning' : 'secondary' }}">
                                                    {!!   $selectedAircraft->is_drone ? '<span class="text-uppercase" data-key="t-yes">YES</span>' : '<span class="text-uppercase" data-key="t-no">NO</span>' !!}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>NATO</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_nato ? 'info' : 'secondary' }}">
                                                    {!! $selectedAircraft->is_nato ? '<span class="text-uppercase" data-key="t-yes">YES</span>' : '<span class="text-uppercase" data-key="t-no">NO</span>' !!}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span data-key="t-friendly">Friendly</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_friendly ? 'success' : 'secondary' }}">
                                                    {!! $selectedAircraft->is_friendly ? '<span class="text-uppercase" data-key="t-yes">YES</span>' : '<span class="text-uppercase" data-key="t-no">NO</span>' !!}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span data-key="t-potential-threat">Potential Threat</span>
                                                <span class="badge bg-{{ $selectedAircraft->is_potential_threat ? 'danger' : 'secondary' }}">
                                                    {!! $selectedAircraft->is_potential_threat ? '<span class="text-uppercase" data-key="t-yes">YES</span>' : '<span class="text-uppercase" data-key="t-no">NO</span>' !!}
                                                </span>
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
                                        <h6 class="mb-0" data-key="t-country-information">Country Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="display-4 fw-bold">{!! $selectedAircraft->country ?? '<span data-key="t-unknown">Unknown</span>' !!}</div>
                                            <div class="mt-3">
                                                <span class="badge bg-secondary" data-key="t-country-of-origin">Country of Origin</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }} bg-opacity-10">
                                    <div class="card-header">
                                        <h6 class="mb-0" data-key="t-threat-assessment">Threat Assessment</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="display-4 fw-bold text-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}">
                                                <span data-key="t-level">Level</span> {{ $selectedAircraft->threat_level }}
                                            </div>
                                            <div class="mt-3">
                                                <div class="progress" style="height: 12px;">
                                                    <div class="progress-bar bg-{{ $selectedAircraft->threat_level >= 4 ? 'danger' : ($selectedAircraft->threat_level >= 3 ? 'warning' : 'success') }}" style="width: {{ $selectedAircraft->threat_level * 20 }}%"></div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <small class="text-muted"><span data-key="t-threat-scale-1-Low-to-5-critical">Threat scale: 1 (Low) to 5 (Critical)</span></small>
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
                                        <h6 class="mb-0" data-key="t-activity-timeline">Activity Timeline</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-first_seen">First Seen</small>
                                                    @if(isset($selectedAircraft->first_seen) && $selectedAircraft->first_seen->position_time)
                                                        <div class="h5">{{ \Carbon\Carbon::parse($selectedAircraft->first_seen->position_time)->format('Y-m-d') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($selectedAircraft->first_seen->position_time)->format('H:i:s') }}</small>
                                                    @else
                                                        <div class="text-muted" data-key="t-unknown">Unknown</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-last-seen">Last Seen</small>
                                                    @if($selectedAircraft->last_seen)
                                                        <div class="h5">{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->format('Y-m-d') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->format('H:i:s') }}</small>
                                                        <br>
                                                        <span class="badge bg-{{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->diffInHours() < 24 ? 'success' : 'secondary' }}">
                                                    {{ \Carbon\Carbon::parse($selectedAircraft->last_seen)->diffForHumans() }}
                                                </span>
                                                    @else
                                                        <div class="text-muted" data-key="t-unknown">Unknown</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <small class="text-muted d-block" data-key="t-database-entry">Database Entry</small>
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
                                        <h6 class="mb-0" data-key="t-latest-position">Latest Position</h6>
                                    </div>
                                    <div class="card-body">
                                        @if(isset($selectedAircraft->latest_position))
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-coordinates">Coordinates</small>
                                                        <code class="h6">{{ number_format($selectedAircraft->latest_position->latitude, 4) }}, {{ number_format($selectedAircraft->latest_position->longitude, 4) }}</code>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-altitude">Altitude</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->altitude) }} m</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-speed">Speed</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->speed) }} km/h</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <small class="text-muted d-block" data-key="t-heading">Heading</small>
                                                        <div class="h5">{{ round($selectedAircraft->latest_position->heading) }}°</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @if($selectedAircraft->latest_position->in_estonia)
                                                            <span class="badge bg-success" data-key="t-in-estonia">In Estonia</span>
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
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-3">
                                                <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                                                <p class="text-muted mb-0" data-key="t-no-position-data-available">No position data available</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($selectedAircraft->positions) && count($selectedAircraft->positions) > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0" data-key="t-recent-position-history-last-50-positions">Recent Position History (Last 50 positions)</h6>
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
                                                        <th data-key="t-threat">Threat</th>
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
                                                        <span class="badge bg-{{ $position->threat_level >= 4 ? 'danger' : ($position->threat_level >= 3 ? 'warning' : 'success') }}">
                                                            {{ $position->threat_level }}
                                                        </span>
                                                            </td>
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

                        @if($selectedAircraft->metadata)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <button class="btn btn-sm btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#metadataCollapse">
                                                <i class="fas fa-code me-1"></i> <span data-key="t-view-raw-metadata">View Raw Metadata</span>
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
                            <i class="fas fa-times me-1"></i> <span data-key="t-close">Close</span>
                        </button>

                        <button type="button" class="btn btn-success" wire:click="exportSingleAircraft" wire:loading.attr="disabled">
                            <i class="fas fa-download me-1"></i>
                            <span wire:loading.remove wire:target="exportSingleAircraft" data-key="t-export-data">Export Data</span>
                            <span wire:loading wire:target="exportSingleAircraft" data-key="t-exporting">Exporting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('user/assets/css/pages/aircraft-database.css') }}" />
    @endpush
</div>
