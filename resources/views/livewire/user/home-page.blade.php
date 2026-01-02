<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
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
                                <button wire:click="refreshDashboard" wire:loading.attr="disabled"
                                        class="btn btn-sm btn-primary">
                                    <i class="fas fa-sync-alt" wire:loading.class="fa-spin"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Real-time Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card bg-primary text-white border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1">Active Aircraft</div>
                                        <div class="display-6 fw-bold">{{ $stats['active_aircraft'] ?? 0 }}</div>
                                        <small class="opacity-75">Last 60 minutes</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-plane"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-white"
                                             style="width: {{ min(100, ($stats['active_aircraft'] ?? 0) / max(1, ($stats['total_aircraft'] ?? 100)) * 100) }}%"></div>
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
                                        <div class="h6 mb-1">Military</div>
                                        <div class="display-6 fw-bold">{{ $stats['active_military'] ?? 0 }}</div>
                                        <small class="opacity-75">Active military</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-fighter-jet"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-white"
                                             style="width: {{ ($stats['active_aircraft'] ?? 0) > 0 ? (($stats['active_military'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100) : 0 }}%"></div>
                                    </div>
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['active_military'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% of active</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-warning text-dark border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1">High Threat</div>
                                        <div class="display-6 fw-bold">{{ $stats['high_threat'] ?? 0 }}</div>
                                        <small class="opacity-75">Threat level ≥ 4</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-dark bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-dark bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-dark"
                                             style="width: {{ ($stats['active_aircraft'] ?? 0) > 0 ? (($stats['high_threat'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100) : 0 }}%"></div>
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
                                        <div class="h6 mb-1">In Estonia</div>
                                        <div class="display-6 fw-bold">{{ $stats['in_estonia'] ?? 0 }}</div>
                                        <small class="opacity-75">Inside airspace</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-white"
                                             style="width: {{ ($stats['active_aircraft'] ?? 0) > 0 ? (($stats['in_estonia'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100) : 0 }}%"></div>
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
                                        <div class="h6 mb-1">AI Alerts</div>
                                        <div class="display-6 fw-bold">{{ $stats['ai_alerts_today'] ?? 0 }}</div>
                                        <small class="opacity-75">Today</small>
                                    </div>
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-white bg-opacity-20 rounded fs-24">
                                            <i class="fas fa-robot"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="progress bg-white bg-opacity-20" style="height: 4px;">
                                        <div class="progress-bar bg-white"
                                             style="width: {{ min(100, ($stats['ai_alerts_today'] ?? 0) / 20 * 100) }}%"></div>
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
                                        <div class="h6 mb-1">Latest Risk</div>
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
                                            <i class="fas fa-shield-alt"></i>
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

                <!-- Main Content Row -->
                <div class="row">
                    <!-- Left Column: Map and Active Aircraft -->
                    <div class="col-lg-8">
                        <!-- Live Map -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-map-marked-alt me-2"></i>Live Air Traffic Map
                                    </h5>
                                    <span class="badge bg-light text-dark" id="map-aircraft-count">
                                        {{ count($activeAircraft) }} active aircraft
                                    </span>
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
                                            Real-time positions from last 60 minutes
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Aircraft Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plane me-2"></i>Active Aircraft (Last Hour)
                                </h5>
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
                                            <tr class="{{ $aircraft->aircraft_threat >= 4 ? 'table-danger' : ($aircraft->aircraft_threat >= 3 ? 'table-warning' : '') }}">
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
                                                        {{ \Carbon\Carbon::parse($aircraft->position_time)->diffForHumans() }}
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

                    <!-- Right Column: Charts, Alerts, and Quick Stats -->
                    <div class="col-lg-4">
                        <!-- Today's Activity Chart -->
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

                        <!-- Threat Level Distribution -->
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

                        <!-- Additional Chart: Military vs Civil -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Military vs Civil
                                </h5>
                            </div>
                            <div class="card-body">
                                <div id="military-civil-chart" style="height: 200px;"></div>
                            </div>
                        </div>

                        <!-- Recent AI Alerts -->
                        <div class="card mb-4">
                            <div class="card-header bg-danger text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
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

                        <!-- Quick Links -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-rocket me-2"></i>Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('user.live-map') }}" class="btn btn-outline-primary w-100 mb-2">
                                            <i class="fas fa-map me-1"></i> Live Map
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.military-monitor') }}" class="btn btn-outline-danger w-100 mb-2">
                                            <i class="fas fa-fighter-jet me-1"></i> Military
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.ai-threat-analysis') }}" class="btn btn-outline-warning w-100 mb-2">
                                            <i class="fas fa-robot me-1"></i> AI Analysis
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.analysis-history') }}" class="btn btn-outline-info w-100 mb-2">
                                            <i class="fas fa-history me-1"></i> History
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.aircraft-database') }}" class="btn btn-outline-success w-100 mb-2">
                                            <i class="fas fa-database me-1"></i> Database
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.reports') }}" class="btn btn-outline-dark w-100 mb-2">
                                            <i class="fas fa-file-alt me-1"></i> Reports
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Threat Trends Chart -->
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
            let dashboardMap = null;
            let mapMarkers = new Map();
            let isMapInitialized = false;
            let pendingMarkersData = null;

            // Initialize dashboard map
            function initDashboardMap() {
                if (isMapInitialized) return;

                console.log('Initializing dashboard map...');

                try {
                    dashboardMap = L.map('dashboard-map').setView([59.42, 24.83], 8);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(dashboardMap);

                    // Estonian border
                    L.polygon([
                        [59.0, 21.5], [59.0, 28.5], [57.5, 28.5], [57.5, 21.5]
                    ], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.05,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(dashboardMap).bindPopup('Estonian Airspace');

                    isMapInitialized = true;
                    console.log('Dashboard map initialized');

                    // Load initial markers if we have data
                    if (pendingMarkersData) {
                        updateDashboardMarkers(pendingMarkersData);
                    }

                } catch (error) {
                    console.error('Dashboard map initialization failed:', error);
                }
            }

            // Update markers on dashboard - FIXED VERSION
            function updateDashboardMarkers(markersData) {
                console.log('updateDashboardMarkers called with:', markersData);

                // If map is not ready, store data and return
                if (!isMapInitialized) {
                    console.log('Map not ready, storing markers data');
                    pendingMarkersData = markersData;
                    return;
                }

                // Clear existing markers
                mapMarkers.forEach(marker => {
                    if (dashboardMap && dashboardMap.hasLayer(marker)) {
                        dashboardMap.removeLayer(marker);
                    }
                });
                mapMarkers.clear();

                // Handle different data formats
                let markersArray = [];

                try {
                    // If markersData is a string (JSON), parse it
                    if (typeof markersData === 'string') {
                        markersArray = JSON.parse(markersData);
                    }
                    // If it's already an array, use it directly
                    else if (Array.isArray(markersData)) {
                        markersArray = markersData;
                    }
                    // If it's an object with markers property (from Livewire event)
                    else if (markersData && typeof markersData === 'object' && markersData.markers) {
                        if (typeof markersData.markers === 'string') {
                            markersArray = JSON.parse(markersData.markers);
                        } else {
                            markersArray = markersData.markers;
                        }
                    }
                    else {
                        console.log('Invalid markers data format, using empty array');
                        markersArray = [];
                    }
                } catch (e) {
                    console.error('Error parsing markers data:', e);
                    markersArray = [];
                }

                console.log('Processing', markersArray.length, 'markers');

                // Update aircraft count badge
                document.getElementById('map-aircraft-count').textContent = markersArray.length + ' active aircraft';

                // Add new markers
                markersArray.forEach(aircraft => {
                    if (!aircraft || !aircraft.latitude || !aircraft.longitude) {
                        console.warn('Skipping invalid aircraft:', aircraft);
                        return;
                    }

                    const lat = parseFloat(aircraft.latitude);
                    const lng = parseFloat(aircraft.longitude);
                    const heading = parseFloat(aircraft.heading) || 0;

                    if (isNaN(lat) || isNaN(lng)) {
                        console.warn('Invalid coordinates for aircraft:', aircraft.hex);
                        return;
                    }

                    // Determine color and icon
                    let color = '#007bff'; // Default blue for civil
                    let icon = 'plane';

                    if (aircraft.is_military) {
                        color = '#dc3545'; // Red for military
                        icon = 'fighter-jet';
                    } else if (aircraft.is_drone) {
                        color = '#fd7e14'; // Orange for drones
                        icon = 'drone';
                    } else if (aircraft.is_nato) {
                        color = '#0dcaf0'; // Blue for NATO
                        icon = 'flag';
                    }

                    // High threat aircraft
                    if (aircraft.threat_level >= 4) {
                        color = '#dc3545'; // Red for high threat
                    }

                    // Create custom icon
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
                        iconAnchor: [13, 13],
                        popupAnchor: [0, -13]
                    });

                    const marker = L.marker([lat, lng], {
                        icon: customIcon,
                        title: `${aircraft.callsign || aircraft.hex} - ${aircraft.type || 'Aircraft'}`
                    });

                    // Create popup content
                    const popupContent = `
                    <div style="min-width: 200px;">
                        <strong>${aircraft.callsign || aircraft.hex}</strong><br>
                        <small>${aircraft.type || 'Unknown'} - ${aircraft.country || 'Unknown'}</small><br>
                        <hr>
                        <small>Threat: Level ${aircraft.threat_level || 1}</small><br>
                        <small>Alt: ${aircraft.altitude ? Math.round(aircraft.altitude) : 'N/A'}m</small><br>
                        <small>Speed: ${aircraft.speed ? Math.round(aircraft.speed) : 'N/A'}km/h</small><br>
                        <hr>
                        <small>${aircraft.position_time ? new Date(aircraft.position_time).toLocaleTimeString() : ''}</small>
                    </div>
                `;

                    marker.bindPopup(popupContent);
                    marker.addTo(dashboardMap);
                    mapMarkers.set(aircraft.hex, marker);
                });

                // Fit bounds if we have markers
                if (mapMarkers.size > 0) {
                    const bounds = L.latLngBounds(Array.from(mapMarkers.values()).map(m => m.getLatLng()));
                    if (bounds.isValid()) {
                        dashboardMap.fitBounds(bounds.pad(0.1), {
                            padding: [50, 50],
                            maxZoom: 10,
                            animate: true
                        });
                    }
                }

                console.log(`Added ${mapMarkers.size} markers to map`);
            }

            // Initialize charts
            function initCharts() {
                // Today's Activity Chart
                const todayData = @json($todayAnalyses);
                if (todayData && todayData.length > 0) {
                    const hours = todayData.map(d => d.hour + ':00');
                    const aircraftCounts = todayData.map(d => parseFloat(d.avg_aircraft) || 0);
                    const militaryCounts = todayData.map(d => parseFloat(d.avg_military) || 0);

                    const todayChart = new ApexCharts(document.querySelector("#today-activity-chart"), {
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
                            toolbar: { show: false }
                        },
                        colors: ['#0d6efd', '#dc3545'],
                        stroke: {
                            width: [3, 3],
                            curve: 'smooth'
                        },
                        markers: {
                            size: 4
                        },
                        xaxis: {
                            categories: hours,
                            labels: {
                                rotate: -45
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Aircraft Count',
                                style: {
                                    fontSize: '12px'
                                }
                            }
                        },
                        legend: {
                            show: true,
                            position: 'top'
                        },
                        tooltip: {
                            shared: true,
                            intersect: false
                        }
                    });
                    todayChart.render();
                }

                // Threat Distribution Chart
                const threatData = @json($aiAnalysis);
                if (threatData && threatData.length > 0) {
                    const threatLevels = threatData.map(d => `Level ${d.threat_level}`);
                    const threatCounts = threatData.map(d => parseInt(d.count) || 0);
                    const colors = ['#198754', '#ffc107', '#fd7e14', '#dc3545', '#6610f2'];

                    const threatChart = new ApexCharts(document.querySelector("#threat-distribution-chart"), {
                        series: threatCounts,
                        chart: {
                            type: 'donut',
                            height: 200
                        },
                        labels: threatLevels,
                        colors: colors,
                        legend: {
                            show: true,
                            position: 'bottom'
                        },
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
                        dataLabels: {
                            enabled: false
                        }
                    });
                    threatChart.render();
                }

                // Military vs Civil Chart (Additional Chart)
                const activeAircraft = @json($activeAircraft);
                if (activeAircraft && activeAircraft.length > 0) {
                    const militaryCount = activeAircraft.filter(a => a.is_military).length;
                    const civilCount = activeAircraft.length - militaryCount;
                    const droneCount = activeAircraft.filter(a => a.is_drone).length;
                    const natoCount = activeAircraft.filter(a => a.is_nato).length;

                    const militaryCivilChart = new ApexCharts(document.querySelector("#military-civil-chart"), {
                        series: [{
                            data: [
                                { x: 'Military', y: militaryCount, fillColor: '#dc3545' },
                                { x: 'Civil', y: civilCount, fillColor: '#0d6efd' },
                                { x: 'Drones', y: droneCount, fillColor: '#fd7e14' },
                                { x: 'NATO', y: natoCount, fillColor: '#0dcaf0' }
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
                            categories: ['Military', 'Civil', 'Drones', 'NATO']
                        },
                        yaxis: {
                            title: {
                                text: 'Aircraft Count'
                            }
                        }
                    });
                    militaryCivilChart.render();
                }

                // Threat Trends Chart (Last 7 Days)
                const trendsData = @json($threatTrends);
                if (trendsData && trendsData.length > 0) {
                    const dates = trendsData.map(d => {
                        const date = new Date(d.date);
                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    });
                    const anomalyScores = trendsData.map(d => parseFloat(d.avg_anomaly) || 0);
                    const highRiskDays = trendsData.map(d => parseInt(d.high_risk_count) || 0);
                    const compositeScores = trendsData.map(d => parseFloat(d.avg_composite) || 0);

                    const trendsChart = new ApexCharts(document.querySelector("#threat-trends-chart"), {
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
                            toolbar: {
                                show: true,
                                tools: {
                                    download: true,
                                    selection: true,
                                    zoom: true,
                                    zoomin: true,
                                    zoomout: true,
                                    pan: true,
                                    reset: true
                                }
                            }
                        },
                        colors: ['#dc3545', '#0d6efd', '#fd7e14'],
                        stroke: {
                            width: [3, 0, 3],
                            curve: 'smooth',
                            dashArray: [0, 0, 5]
                        },
                        markers: {
                            size: [5, 0, 5]
                        },
                        xaxis: {
                            categories: dates,
                            title: {
                                text: 'Date'
                            }
                        },
                        yaxis: [
                            {
                                title: {
                                    text: 'Anomaly Score',
                                    style: {
                                        color: '#dc3545'
                                    }
                                },
                                min: 0,
                                max: 100
                            },
                            {
                                opposite: true,
                                title: {
                                    text: 'High Risk Incidents',
                                    style: {
                                        color: '#0d6efd'
                                    }
                                }
                            }
                        ],
                        tooltip: {
                            shared: true,
                            intersect: false
                        },
                        legend: {
                            show: true,
                            position: 'top'
                        },
                        grid: {
                            borderColor: '#f1f1f1'
                        }
                    });
                    trendsChart.render();
                }
            }

            // Initialize everything when page loads
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Initializing dashboard...');

                // Initialize map
                setTimeout(initDashboardMap, 100);

                // Initialize charts
                setTimeout(initCharts, 500);

                // Auto-refresh every 30 seconds
                setInterval(() => {
                    console.log('Auto-refreshing dashboard...');
                    @this.refreshDashboard();
                }, 30000);
            });

            // Listen for Livewire events
            document.addEventListener('livewire:initialized', () => {
                console.log('Livewire initialized for dashboard');

                // Update map when data is refreshed
                Livewire.on('dashboard-data-loaded', (event) => {
                    console.log('Dashboard data loaded event received:', event);
                    updateDashboardMarkers(event);

                    // Reinitialize charts with updated data
                    setTimeout(initCharts, 100);
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (dashboardMap) {
                    setTimeout(() => dashboardMap.invalidateSize(), 100);
                }
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            #dashboard-map {
                min-height: 400px;
                border-radius: 4px;
                background-color: #f8f9fa;
            }
            .dashboard-aircraft-marker {
                background: transparent !important;
                border: none !important;
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
            .fs-24 {
                font-size: 24px;
            }
            .table-danger {
                background-color: rgba(220, 53, 69, 0.05) !important;
            }
            .table-warning {
                background-color: rgba(255, 193, 7, 0.05) !important;
            }
            .card {
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                border: 1px solid rgba(0,0,0,0.1);
                transition: transform 0.2s ease;
            }
            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .list-group-item {
                border-left: none;
                border-right: none;
                padding: 1rem;
            }
            .list-group-item:first-child {
                border-top: none;
            }
            .list-group-item:last-child {
                border-bottom: none;
            }
            .btn-outline-primary:hover {
                background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
                color: white;
            }
            .btn-outline-danger:hover {
                background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
                color: white;
            }
            .btn-outline-warning:hover {
                background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
                color: #000;
            }
            .btn-outline-info:hover {
                background: linear-gradient(135deg, #0dcaf0 0%, #31d2f2 100%);
                color: white;
            }
            .btn-outline-success:hover {
                background: linear-gradient(135deg, #198754 0%, #157347 100%);
                color: white;
            }
            .btn-outline-dark:hover {
                background: linear-gradient(135deg, #212529 0%, #424649 100%);
                color: white;
            }
            .card-header.bg-primary {
                background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
            }
            .card-header.bg-danger {
                background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%) !important;
            }
            .card.bg-primary {
                background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
            }
            .card.bg-danger {
                background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%) !important;
            }
            .card.bg-info {
                background: linear-gradient(135deg, #0dcaf0 0%, #31d2f2 100%) !important;
            }
            .card.bg-success {
                background: linear-gradient(135deg, #198754 0%, #157347 100%) !important;
            }
            .card.bg-dark {
                background: linear-gradient(135deg, #212529 0%, #424649 100%) !important;
            }
            .progress {
                border-radius: 10px;
                overflow: hidden;
            }
            .progress-bar {
                border-radius: 10px;
            }
            .font-monospace {
                font-family: 'Courier New', monospace;
                font-size: 12px;
            }
        </style>
    @endpush
</div>
