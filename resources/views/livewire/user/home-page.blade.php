<div>
    @if($loading)
        <div class="loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    @endif

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h3 mb-0">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </h1>
                                <p class="text-muted mb-0">Real-time airspace monitoring and threat assessment</p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-end">
                                    <div class="text-muted small">Last Update</div>
                                    <div class="h6 mb-0">{{ $stats['update_time'] ?? '--:--:--' }}</div>
                                </div>

                                <div class="form-check form-switch d-flex align-items-center me-2">
                                    <input class="form-check-input" type="checkbox"
                                           id="autoRefreshToggle"
                                           {{ $autoRefreshEnabled ? 'checked' : '' }}
                                           wire:click="toggleAutoRefresh">
                                    <label class="form-check-label ms-2 small" for="autoRefreshToggle">
                                        Auto Refresh
                                    </label>
                                </div>

                                <button wire:click="refreshDashboard" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-primary">
                                    <i class="fas fa-sync-alt" wire:loading.class="fa-spin"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($activeAircraft) === 0)
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-warning alert-dismissible fade show py-2" role="alert">
                                <small>
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    No active aircraft found in the last 60 minutes.
                                    This could mean:
                                    <ul class="mb-0 mt-1">
                                        <li>No aircraft have transmitted position data recently</li>
                                        <li>Database connection issue</li>
                                        <li>All aircraft are outside the monitoring area</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="alert alert-info alert-dismissible fade show py-2" role="alert">
                                <small>
                                    <i class="fas fa-clock me-1"></i>
                                    Showing data from the last 60 minutes only.
                                    <span id="data-freshness-indicator">
                                    {{ $stats['active_aircraft'] ?? 0 }} aircraft currently active.
                                </span>
                                </small>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card bg-primary text-white border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white">Active Aircraft</div>
                                        <div class="display-6 fw-bold">{{ $stats['active_aircraft'] ?? 0 }}</div>
                                        <small class="opacity-75">Last 60 minutes</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fa-solid fa-plane text-black"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-black" style="width: {{ min(100, ($stats['active_aircraft'] ?? 0) / max(1, ($stats['total_aircraft'] ?? 100)) * 100) }}%"></div>
                                    </div>
                                    <small class="opacity-75">{{ $stats['total_aircraft'] ?? 0 }} total in database</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-danger text-white border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white">Military</div>
                                        <div class="display-6 fw-bold">{{ $stats['active_military'] ?? 0 }}</div>
                                        <small class="opacity-75">Active military</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-fighter-jet text-black"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-black" style="width: {{ ($stats['active_aircraft'] ?? 0) > 0 ? (($stats['active_military'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100) : 0 }}%"></div>
                                    </div>
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['active_military'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% of active</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-warning text-white border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white">High Threat</div>
                                        <div class="display-6 fw-bold ">{{ $stats['high_threat'] ?? 0 }}</div>
                                        <small class="opacity-75 ">Threat level ≥ 4</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-exclamation-triangle text-black"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-black" style="width: {{ ($stats['active_aircraft'] ?? 0) > 0 ? (($stats['high_threat'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100) : 0 }}%"></div>
                                    </div>
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['high_threat'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% threat ratio</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-info text-white border-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white">In Estonia</div>
                                        <div class="display-6 fw-bold">{{ $stats['in_estonia'] ?? 0 }}</div>
                                        <small class="opacity-75">Inside airspace</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-map-marker-alt text-black"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-black" style="width: {{ ($stats['active_aircraft'] ?? 0) > 0 ? (($stats['in_estonia'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100) : 0 }}%"></div>
                                    </div>
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['in_estonia'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% in airspace</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-success text-white border-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white">AI Alerts</div>
                                        <div class="display-6 fw-bold">{{ $stats['ai_alerts_today'] ?? 0 }}</div>
                                        <small class="opacity-75">Today</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-robot text-black"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-black" style="width: {{ min(100, ($stats['ai_alerts_today'] ?? 0) / 20 * 100) }}%"></div>
                                    </div>
                                    <small class="opacity-75">Avg: {{ $stats['avg_alerts_per_hour'] ?? 0 }}/hour</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-dark text-white border-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white">Latest Risk</div>
                                        @if(isset($stats['latest_analysis']) && $stats['latest_analysis']->overall_risk)
                                            <div class="display-6 fw-bold text-{{ strtolower($stats['latest_analysis']->overall_risk) === 'high' ? 'danger' : (strtolower($stats['latest_analysis']->overall_risk) === 'medium' ? 'warning' : 'success') }}">
                                                {{ $stats['latest_analysis']->overall_risk }}
                                            </div>
                                            <small class="opacity-75">Latest analysis</small>
                                        @else
                                            <div class="display-6 fw-bold">N/A</div>
                                            <small class="opacity-75">No data</small>
                                        @endif
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-shield-alt text-black"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @if(isset($stats['latest_analysis']) && $stats['latest_analysis']->analysis_time)
                                        <small class="opacity-75">
                                            {{ \Carbon\Carbon::parse($stats['latest_analysis']->analysis_time)->format('H:i') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 text-white">
                                        <i class="fas fa-map-marked-alt me-2"></i>Live Air Traffic Map
                                    </h5>
                                    <div>
                                        <span class="badge bg-light text-dark me-2" id="map-aircraft-count">
                                            {{ count($activeAircraft) }} active aircraft
                                        </span>
                                        <span class="badge bg-info" title="Data freshness">
                                            <i class="fas fa-clock me-1"></i>Last 60 min
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="dashboard-map" style="height: 400px; width: 100%;" wire:ignore></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span>
                                                <span class="badge bg-primary me-1">●</span> Civil
                                            </span>
                                            <span>
                                                <span class="badge bg-danger me-1">●</span> Military
                                            </span>
                                            <span>
                                                <span class="badge bg-warning me-1">●</span> Drone
                                            </span>
                                            <span>
                                                <span class="badge bg-info me-1">●</span> NATO
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            <i class="fas fa-filter me-1"></i>
                                            Filtered: Last 60 minutes only
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-plane me-2"></i>Active Aircraft (Last Hour)
                                    </h5>
                                    <span class="badge bg-info">
                                        <i class="fas fa-clock me-1"></i>Showing last 60 minutes
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th>Callsign</th>
                                            <th>Type</th>
                                            <th>Country</th>
                                            <th>Position</th>
                                            <th>Altitude</th>
                                            <th>Speed</th>
                                            <th>Threat</th>
                                            <th>Last Seen</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($activeAircraft as $aircraft)
                                            @php
                                                $positionTime = $aircraft->position_time ? \Carbon\Carbon::parse($aircraft->position_time) : null;
                                                $minutesAgo = $positionTime ? $positionTime->diffInMinutes(now()) : null;

                                                $rowClass = '';
                                                if ($minutesAgo !== null) {
                                                    if ($minutesAgo > 60) {
                                                        continue;
                                                    } elseif ($minutesAgo > 30) {
                                                        $rowClass = 'table-secondary';
                                                    }
                                                }
                                            @endphp
                                            <tr class="{{ $rowClass }} {{ $aircraft->aircraft_threat >= 4 ? 'table-danger' : ($aircraft->aircraft_threat >= 3 ? 'table-warning' : '') }}">
                                                <td>
                                                    <div class="fw-bold">{{ $aircraft->callsign ?? 'N/A' }}</div>
                                                    <small class="text-muted font-monospace">{{ $aircraft->hex }}</small>
                                                </td>
                                                <td>
                                                    @if($aircraft->is_military)
                                                        <span class="badge bg-danger">Military</span>
                                                    @elseif($aircraft->is_drone)
                                                        <span class="badge bg-warning">Drone</span>
                                                    @else
                                                        <span class="badge bg-primary">Civil</span>
                                                    @endif
                                                    <br>
                                                    <small>{{ $aircraft->type ?? 'Unknown' }}</small>
                                                </td>
                                                <td>
                                                    {{ $aircraft->country ?? 'Unknown' }}
                                                    @if($aircraft->is_nato)
                                                        <br><span class="badge bg-info">NATO</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($aircraft->latitude && $aircraft->longitude)
                                                        <code>{{ number_format($aircraft->latitude, 4) }}, {{ number_format($aircraft->longitude, 4) }}</code>
                                                        @if($aircraft->in_estonia)
                                                            <br><span class="badge bg-success">In Estonia</span>
                                                        @endif
                                                        @if($aircraft->near_sensitive)
                                                            <br><span class="badge bg-danger">Near Sensitive</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No position</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $aircraft->altitude ? round(floatval($aircraft->altitude)) . ' m' : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $aircraft->speed ? round(floatval($aircraft->speed)) . ' km/h' : 'N/A' }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $aircraft->aircraft_threat >= 4 ? 'danger' : ($aircraft->aircraft_threat >= 3 ? 'warning' : 'success') }}">
                                                        Level {{ $aircraft->aircraft_threat }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($aircraft->position_time)
                                                        @php
                                                            $diff = \Carbon\Carbon::parse($aircraft->position_time)->diffForHumans();
                                                        @endphp
                                                        <span title="{{ $aircraft->position_time }}">
                                                            {{ $diff }}
                                                        </span>
                                                        @if($minutesAgo !== null && $minutesAgo > 30)
                                                            <br><small class="text-warning">
                                                                <i class="fas fa-exclamation-circle me-1"></i>Data may be stale
                                                            </small>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-plane-slash fa-2x mb-2"></i>
                                                        <p>No active aircraft in the last hour</p>
                                                        <small class="text-warning">
                                                            Check if aircraft have transmitted position data recently.
                                                        </small>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Today's Activity
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="today-activity-chart" style="height: 200px;"></div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie me-2"></i>Threat Level Distribution
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="threat-distribution-chart" style="height: 200px;"></div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Military vs Civil
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="military-civil-chart" style="height: 200px;"></div>
                                @if(count($activeAircraft) === 0)
                                    <div class="text-center text-muted small">
                                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                        <p>No aircraft data available</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-danger text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 text-white">
                                        <i class="fas fa-robot me-2"></i>Recent AI Alerts
                                    </h5>
                                    <span class="badge bg-light text-dark">
                                        {{ count($recentAlerts) }} alerts
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @forelse($recentAlerts as $alert)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div>
                                                <span class="badge bg-{{ strtolower($alert->threat_level) === 'high' ? 'danger' : 'warning' }}">
                                                    {{ $alert->threat_level }}
                                                </span>
                                                    <span class="badge bg-info">{{ $alert->trigger_level }}</span>
                                                </div>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($alert->ai_timestamp)->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div class="mb-1">
                                                <strong>{{ Str::limit($alert->primary_concern, 50) }}</strong>
                                            </div>
                                            <small class="text-muted">
                                                Confidence: {{ $alert->confidence }}
                                            </small>
                                        </div>
                                    @empty
                                        <div class="list-group-item text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-bell-slash fa-2x mb-2"></i>
                                                <p>No AI alerts today</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('user.ai-threat-analysis') }}" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-external-link-alt me-1"></i> View All AI Analysis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Threat Trends (Last 7 Days)
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="threat-trends-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            window.chartInstances = {};
            let dashboardMap = null;
            let mapMarkers = new Map();
            let isMapInitialized = false;
            let pendingMarkersData = null;
            let refreshInterval = null;
            let autoRefreshEnabled = {{ $autoRefreshEnabled ? 'true' : 'false' }};

            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            function initDashboardMap() {
                if (isMapInitialized || !document.getElementById('dashboard-map')) return;

                try {
                    dashboardMap = L.map('dashboard-map').setView([59.42, 24.83], 8);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors',
                        maxZoom: 18,
                        minZoom: 6
                    }).addTo(dashboardMap);

                    const estoniaBounds = [
                        [57.5, 21.5],
                        [59.8, 21.5],
                        [59.8, 28.2],
                        [57.5, 28.2]
                    ];

                    L.polygon(estoniaBounds, {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.05,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(dashboardMap).bindPopup('Estonian Airspace');

                    isMapInitialized = true;
                    console.log('Map initialized');

                    if (pendingMarkersData) {
                        updateDashboardMarkers(pendingMarkersData);
                        pendingMarkersData = null;
                    }

                } catch (error) {
                    console.error('Dashboard map initialization failed:', error);
                }
            }

            function cleanupCharts() {
                Object.values(window.chartInstances).forEach(chart => {
                    if (chart && typeof chart.destroy === 'function') {
                        chart.destroy();
                    }
                });
                window.chartInstances = {};
            }

            function updateDashboardMarkers(markersData) {
                console.log('Updating map markers with data:', markersData);

                if (!isMapInitialized || !dashboardMap) {
                    console.log('Map not ready, storing markers data');
                    pendingMarkersData = markersData;
                    return;
                }

                mapMarkers.forEach(marker => {
                    if (dashboardMap.hasLayer(marker)) {
                        dashboardMap.removeLayer(marker);
                    }
                });
                mapMarkers.clear();

                let markersArray = [];

                try {
                    if (typeof markersData === 'string') {
                        markersArray = JSON.parse(markersData);
                    } else if (Array.isArray(markersData)) {
                        markersArray = markersData;
                    } else if (markersData && typeof markersData === 'object' && markersData.markers) {
                        markersArray = typeof markersData.markers === 'string'
                            ? JSON.parse(markersData.markers)
                            : markersData.markers;
                    }
                } catch (e) {
                    console.error('Error parsing markers data:', e);
                    markersArray = [];
                }

                console.log('Processed markers array:', markersArray);

                const now = new Date();
                markersArray = markersArray.filter(aircraft => {
                    if (!aircraft.position_time) {
                        console.log('Aircraft has no position time:', aircraft);
                        return false;
                    }
                    const positionTime = new Date(aircraft.position_time);
                    const minutesAgo = (now - positionTime) / (1000 * 60);
                    const isRecent = minutesAgo <= 60;
                    if (!isRecent) {
                        console.log('Filtering out old aircraft:', aircraft.callsign, 'minutes ago:', minutesAgo);
                    }
                    return isRecent;
                });

                console.log('Filtered markers:', markersArray.length);

                const countElement = document.getElementById('map-aircraft-count');
                if (countElement) {
                    countElement.textContent = markersArray.length + ' active aircraft';
                }

                const bounds = L.latLngBounds();

                markersArray.forEach(aircraft => {
                    if (!aircraft || !aircraft.latitude || !aircraft.longitude) {
                        console.log('Skipping invalid aircraft:', aircraft);
                        return;
                    }

                    const lat = parseFloat(aircraft.latitude);
                    const lng = parseFloat(aircraft.longitude);
                    const heading = parseFloat(aircraft.heading) || 0;

                    if (isNaN(lat) || isNaN(lng)) {
                        console.log('Invalid coordinates:', aircraft);
                        return;
                    }

                    let color = '#007bff';
                    let icon = 'plane';

                    if (aircraft.is_military) {
                        color = '#dc3545';
                        icon = 'fighter-jet';
                    } else if (aircraft.is_drone) {
                        color = '#fd7e14';
                        icon = 'drone';
                    } else if (aircraft.is_nato) {
                        color = '#0dcaf0';
                        icon = 'flag';
                    }

                    if (aircraft.threat_level >= 4) {
                        color = '#dc3545';
                    }

                    const positionTime = aircraft.position_time ? new Date(aircraft.position_time) : null;
                    let ageIndicator = '';
                    if (positionTime) {
                        const minutesAgo = Math.round((now - positionTime) / (1000 * 60));
                        if (minutesAgo > 30) {
                            color = '#6c757d';
                        }
                        ageIndicator = `<br><small>Updated: ${minutesAgo} min ago</small>`;
                    }

                    const customIcon = L.divIcon({
                        html: `
                            <div style="
                                background-color: ${color};
                                width: 22px;
                                height: 22px;
                                border-radius: 50%;
                                border: 2px solid white;
                                box-shadow: 0 0 6px rgba(0,0,0,0.5);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: white;
                                font-size: 10px;
                                cursor: pointer;
                                transform: rotate(${heading}deg);
                            ">
                                <i class="fas fa-${icon}"></i>
                            </div>
                        `,
                        className: 'dashboard-aircraft-marker',
                        iconSize: [26, 26],
                        iconAnchor: [13, 13]
                    });

                    const marker = L.marker([lat, lng], {
                        icon: customIcon,
                        title: `${aircraft.callsign || aircraft.hex}`
                    });

                    const popupContent = `
                        <div style="min-width: 200px;">
                            <strong>${aircraft.callsign || aircraft.hex}</strong><br>
                            <small>${aircraft.type || 'Unknown'} - ${aircraft.country || 'Unknown'}</small><br>
                            <hr>
                            <small>Threat: Level ${aircraft.threat_level || 1}</small><br>
                            <small>Alt: ${aircraft.altitude ? Math.round(aircraft.altitude) : 'N/A'}m</small><br>
                            <small>Speed: ${aircraft.speed ? Math.round(aircraft.speed) : 'N/A'}km/h</small><br>
                            <small>Position: ${aircraft.latitude.toFixed(4)}, ${aircraft.longitude.toFixed(4)}</small>
                            ${ageIndicator}
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    marker.addTo(dashboardMap);
                    mapMarkers.set(aircraft.hex, marker);
                    bounds.extend([lat, lng]);

                    console.log('Added marker for:', aircraft.callsign || aircraft.hex);
                });

                if (markersArray.length > 0 && bounds.isValid()) {
                    dashboardMap.fitBounds(bounds.pad(0.1), {
                        padding: [50, 50],
                        maxZoom: 10,
                        animate: true
                    });
                } else if (markersArray.length === 0) {
                    // Reset view if no markers
                    dashboardMap.setView([59.42, 24.83], 8);
                }

                console.log('Total markers on map:', mapMarkers.size);
            }

            function setupAutoRefresh() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                    refreshInterval = null;
                }

                if (autoRefreshEnabled) {
                    refreshInterval = setInterval(() => {
                        console.log('Auto-refreshing dashboard...');
                        @this.refreshDashboard();
                    }, 30000);
                }
            }

            function initCharts() {
                cleanupCharts();

                const todayData = @json($todayAnalyses);
                if (todayData && todayData.length > 0) {
                    const todayChartElement = document.querySelector("#today-activity-chart");
                    if (todayChartElement) {
                        const hours = todayData.map(d => d.hour + ':00');
                        const aircraftCounts = todayData.map(d => parseFloat(d.avg_aircraft) || 0);
                        const militaryCounts = todayData.map(d => parseFloat(d.avg_military) || 0);

                        window.chartInstances.todayActivity = new ApexCharts(todayChartElement, {
                            series: [
                                {
                                    name: 'Total Aircraft',
                                    type: 'line',
                                    data: aircraftCounts
                                },
                                {
                                    name: 'Military Aircraft',
                                    type: 'line',
                                    data: militaryCounts
                                }
                            ],
                            chart: {
                                height: 200,
                                type: 'line',
                                toolbar: { show: false },
                                animations: { enabled: false }
                            },
                            colors: ['#0d6efd', '#dc3545'],
                            stroke: {
                                width: [3, 3],
                                curve: 'smooth'
                            },
                            markers: { size: 4 },
                            xaxis: {
                                categories: hours,
                                labels: { rotate: -45 }
                            },
                            yaxis: {
                                title: { text: 'Aircraft Count', style: { fontSize: '12px' } },
                                min: 0
                            },
                            legend: { show: true, position: 'top' },
                            tooltip: { shared: true, intersect: false }
                        });
                        window.chartInstances.todayActivity.render();
                    }
                } else {
                    const todayChartElement = document.querySelector("#today-activity-chart");
                    if (todayChartElement) {
                        todayChartElement.innerHTML = `
                            <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <p>No activity data available</p>
                            </div>
                        `;
                    }
                }

                const threatData = @json($aiAnalysis);
                if (threatData && threatData.length > 0) {
                    const threatChartElement = document.querySelector("#threat-distribution-chart");
                    if (threatChartElement) {
                        const threatLevels = threatData.map(d => `Level ${d.threat_level}`);
                        const threatCounts = threatData.map(d => parseInt(d.count) || 0);

                        window.chartInstances.threatDistribution = new ApexCharts(threatChartElement, {
                            series: threatCounts,
                            chart: {
                                type: 'donut',
                                height: 200
                            },
                            labels: threatLevels,
                            colors: ['#198754', '#ffc107', '#fd7e14', '#dc3545', '#6610f2'],
                            legend: { show: true, position: 'bottom' },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '60%',
                                        labels: {
                                            show: true,
                                            total: {
                                                show: true,
                                                label: 'Total Alerts',
                                                color: '#6c757d'
                                            }
                                        }
                                    }
                                }
                            },
                            dataLabels: { enabled: false }
                        });
                        window.chartInstances.threatDistribution.render();
                    }
                } else {
                    const threatChartElement = document.querySelector("#threat-distribution-chart");
                    if (threatChartElement) {
                        threatChartElement.innerHTML = `
                            <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                                <i class="fas fa-chart-pie fa-2x mb-2"></i>
                                <p>No threat distribution data</p>
                            </div>
                        `;
                    }
                }

                const activeAircraft = @json($activeAircraft);
                console.log('Active aircraft for chart:', activeAircraft);

                const militaryCivilElement = document.querySelector("#military-civil-chart");
                if (militaryCivilElement) {
                    if (activeAircraft && activeAircraft.length > 0) {
                        const militaryCount = activeAircraft.filter(a => a.is_military).length;
                        const civilCount = activeAircraft.length - militaryCount;
                        const droneCount = activeAircraft.filter(a => a.is_drone).length;
                        const natoCount = activeAircraft.filter(a => a.is_nato).length;

                        console.log('Chart data:', { militaryCount, civilCount, droneCount, natoCount });

                        window.chartInstances.militaryCivil = new ApexCharts(militaryCivilElement, {
                            series: [{
                                data: [
                                    { x: 'Military', y: militaryCount },
                                    { x: 'Civil', y: civilCount },
                                    { x: 'Drones', y: droneCount },
                                    { x: 'NATO', y: natoCount }
                                ]
                            }],
                            chart: {
                                type: 'bar',
                                height: 200,
                                toolbar: { show: false }
                            },
                            colors: ['#dc3545', '#0d6efd', '#fd7e14', '#0dcaf0'],
                            plotOptions: {
                                bar: {
                                    horizontal: true,
                                    borderRadius: 4,
                                    distributed: true
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val) {
                                    return val;
                                }
                            },
                            xaxis: {
                                categories: ['Military', 'Civil', 'Drones', 'NATO'],
                                labels: {
                                    show: true
                                }
                            },
                            yaxis: {
                                title: { text: 'Aircraft Count' },
                                labels: {
                                    show: true
                                }
                            }
                        });
                        window.chartInstances.militaryCivil.render();
                    } else {

                        militaryCivilElement.innerHTML = `
                            <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <p>No aircraft data available</p>
                                <small>Chart will populate when aircraft are active</small>
                            </div>
                        `;
                    }
                }

                const trendsData = @json($threatTrends);
                if (trendsData && trendsData.length > 0) {
                    const trendsElement = document.querySelector("#threat-trends-chart");
                    if (trendsElement) {
                        const dates = trendsData.map(d => {
                            const date = new Date(d.date);
                            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        });
                        const anomalyScores = trendsData.map(d => parseFloat(d.avg_anomaly) || 0);
                        const highRiskDays = trendsData.map(d => parseInt(d.high_risk_count) || 0);
                        const compositeScores = trendsData.map(d => parseFloat(d.avg_composite) || 0);

                        window.chartInstances.threatTrends = new ApexCharts(trendsElement, {
                            series: [
                                {
                                    name: 'Avg Anomaly Score',
                                    type: 'line',
                                    data: anomalyScores
                                },
                                {
                                    name: 'High Risk Incidents',
                                    type: 'column',
                                    data: highRiskDays
                                },
                                {
                                    name: 'Composite Score',
                                    type: 'line',
                                    data: compositeScores
                                }
                            ],
                            chart: {
                                height: 300,
                                type: 'line',
                                toolbar: { show: true }
                            },
                            colors: ['#dc3545', '#0d6efd', '#fd7e14'],
                            stroke: {
                                width: [3, 0, 3],
                                curve: 'smooth',
                                dashArray: [0, 0, 5]
                            },
                            markers: { size: [5, 0, 5] },
                            xaxis: {
                                categories: dates,
                                title: { text: 'Date' }
                            },
                            yaxis: [
                                {
                                    title: {
                                        text: 'Anomaly Score',
                                        style: { color: '#dc3545' }
                                    },
                                    min: 0,
                                    max: 100
                                },
                                {
                                    opposite: true,
                                    title: {
                                        text: 'High Risk Incidents',
                                        style: { color: '#0d6efd' }
                                    }
                                }
                            ],
                            tooltip: { shared: true, intersect: false },
                            legend: { show: true, position: 'top' },
                            grid: { borderColor: '#f1f1f1' }
                        });
                        window.chartInstances.threatTrends.render();
                    }
                } else {
                    const trendsElement = document.querySelector("#threat-trends-chart");
                    if (trendsElement) {
                        trendsElement.innerHTML = `
                            <div class="text-center text-muted" style="height: 300px; display: flex; flex-direction: column; justify-content: center;">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <p>No trend data available</p>
                                <small>Data will appear after analyses are performed</small>
                            </div>
                        `;
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, initializing dashboard...');
                setTimeout(initDashboardMap, 100);
                setTimeout(initCharts, 500);
                setupAutoRefresh();
            });

            document.addEventListener('livewire:initialized', () => {
                console.log('Livewire initialized');

                Livewire.on('dashboard-data-loaded', (event) => {
                    console.log('Dashboard data loaded event received');
                    updateDashboardMarkers(event);
                    setTimeout(initCharts, 100);
                });

                Livewire.on('auto-refresh-toggled', (event) => {
                    console.log('Auto refresh toggled:', event.enabled);
                    autoRefreshEnabled = event.enabled;
                    setupAutoRefresh();

                    const toggle = document.getElementById('autoRefreshToggle');
                    if (toggle) {
                        toggle.checked = autoRefreshEnabled;
                    }
                });
            });

            window.addEventListener('resize', debounce(() => {
                if (dashboardMap) {
                    setTimeout(() => dashboardMap.invalidateSize(), 100);
                }
                setTimeout(initCharts, 200);
            }, 250));

            window.addEventListener('beforeunload', () => {
                cleanupCharts();
                if (refreshInterval) clearInterval(refreshInterval);
                if (dashboardMap) {
                    dashboardMap.remove();
                }
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('user/assets/css/pages/dashboard.css') }}" />
    @endpush
</div>
