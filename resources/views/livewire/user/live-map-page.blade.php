<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-map-marked-alt me-2"></i>Live Air Traffic Map
                            </h1>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-3">
                                    <i class="fas fa-sync-alt fa-spin me-1" wire:loading></i>
                                    Last Update: {{ $lastUpdate }}
                                </span>
                                <button wire:click="loadAircraftData" class="btn btn-sm btn-outline-primary" wire:loading.attr="disabled">
                                    <i class="fas fa-redo"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0">Real-time monitoring of Estonian airspace</p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-black">Total Aircraft</h6>
                                        <h2 class="mb-0 text-white">{{ $totalAircraft }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-plane fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="ttext-black">Military</h6>
                                        <h2 class="mb-0 text-white">{{ $militaryCount }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-fighter-jet fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-black">High Threat</h6>
                                        <h2 class="mb-0 text-white">
                                            {{ collect($aircraft)->where('threat_level', '>=', 4)->count() }}
                                        </h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-black">In Estonia</h6>
                                        <h2 class="mb-0 text-white">
                                            {{ collect($aircraft)->where('in_estonia', true)->count() }}
                                        </h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
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
                                    <div class="col-md-3">
                                        <label class="form-label">Aircraft Type</label>
                                        <select wire:model.live="filterType" wire:change="loadAircraftData" class="form-select">
                                            <option value="all">All Types</option>
                                            <option value="military">Military Only</option>
                                            <option value="civil">Civil Only</option>
                                            <option value="drone">Drones Only</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Country</label>
                                        <select wire:model.live="filterCountry" wire:change="loadAircraftData" class="form-select">
                                            <option value="all">All Countries</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Threat Level</label>
                                        <select wire:model.live="filterThreatLevel" wire:change="loadAircraftData" class="form-select">
                                            <option value="all">All Levels</option>
                                            <option value="4">High Threat (4-5)</option>
                                            <option value="3">Medium Threat (3)</option>
                                            <option value="1">Low Threat (1-2)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Clear Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Container -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div id="map" style="height: 600px; width: 100%;" wire:ignore></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="me-3">
                                                <span class="badge bg-primary me-1">●</span> Civil
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-danger me-1">●</span> Military
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-warning me-1">●</span> High Threat
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-success me-1">●</span> In Estonia
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            Auto-refresh every 30 seconds • Click markers for details
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Debug Info -->
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body py-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Showing {{ $totalAircraft }} aircraft from last 5 minutes •
                                    <span id="map-status">Map: Loading...</span> •
                                    <a href="javascript:void(0)" onclick="showDebugInfo()" class="text-info">Debug</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aircraft Table -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Recent Aircraft Positions</h5>
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
                                        @php
                                            // Group aircraft by hex to remove duplicates
                                            $uniqueAircraft = collect($aircraft)->unique('hex')->take(10);
                                        @endphp

                                        @forelse($uniqueAircraft as $ac)
                                            <tr>
                                                <td>
                                                    <strong>{{ $ac['callsign'] ?: 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $ac['hex'] }}</small>
                                                    @php
                                                        $positionCount = collect($aircraft)->where('hex', $ac['hex'])->count();
                                                    @endphp
                                                    @if($positionCount > 1)
                                                        <br>
                                                        <small class="badge bg-info">
                                                            <i class="fas fa-history me-1"></i> {{ $positionCount }} positions
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ac['is_military'])
                                                        <span class="badge bg-danger">Military</span>
                                                    @elseif($ac['is_drone'])
                                                        <span class="badge bg-warning">Drone</span>
                                                    @else
                                                        <span class="badge bg-primary">Civil</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $ac['country'] }}
                                                    @if($ac['is_nato'])
                                                        <br><small class="badge bg-info">NATO</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($ac['latitude'], 4) }}, {{ number_format($ac['longitude'], 4) }}
                                                    @if($ac['near_sensitive'])
                                                        <br><small class="text-danger">⚠️ Near sensitive</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $altitude = $ac['altitude'] ? round(floatval($ac['altitude'])) : null;
                                                    @endphp
                                                    {{ $altitude ? $altitude . ' m' : 'N/A' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $speed = $ac['speed'] ? round(floatval($ac['speed'])) : null;
                                                    @endphp
                                                    {{ $speed ? $speed . ' km/h' : 'N/A' }}
                                                </td>
                                                <td>
                                                    @php
                                                        $threatColor = [
                                                            1 => 'success',
                                                            2 => 'info',
                                                            3 => 'warning',
                                                            4 => 'danger',
                                                            5 => 'dark'
                                                        ][$ac['threat_level']] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $threatColor }}">
                                                            Level {{ $ac['threat_level'] }}
                                                        </span>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($ac['position_time'])->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-plane-slash fa-2x mb-2"></i>
                                                        <p>No aircraft detected in the last 5 minutes</p>
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
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            let map = null;
            let markers = new Map();
            let isMapInitialized = false;
            let pendingAircraftData = null;

            // Color mapping
            const colorMap = {
                'civil': '#007bff',
                'military': '#dc3545',
                'drone': '#6f42c1',
                'high-threat': '#fd7e14'
            };

            // Initialize map
            function initMap() {
                if (isMapInitialized) return;

                console.log('Initializing map...');

                try {
                    map = L.map('map').setView([59.42, 24.83], 8);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Estonian border
                    L.polygon([
                        [59.0, 21.5], [59.0, 28.5], [57.5, 28.5], [57.5, 21.5]
                    ], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.05,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(map).bindPopup('Estonian Airspace');

                    // Sensitive locations
                    [
                        {name: 'Tallinn Airport', lat: 59.4133, lon: 24.8328, radius: 2000},
                        {name: 'Ämari Air Base', lat: 59.2603, lon: 24.2084, radius: 3000},
                        {name: 'Paldiski Port', lat: 59.3567, lon: 24.0531, radius: 2000},
                        {name: 'NATO HQ Tallinn', lat: 59.4308, lon: 24.7714, radius: 1000},
                    ].forEach(loc => {
                        L.circle([loc.lat, loc.lon], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.1,
                            radius: loc.radius
                        }).bindPopup(`<b>${loc.name}</b><br>Sensitive Location`).addTo(map);
                    });

                    isMapInitialized = true;
                    console.log('Map initialized successfully');
                    updateMapStatus('Ready');

                    // Load initial aircraft data
                    setTimeout(loadInitialAircraft, 100);

                } catch (error) {
                    console.error('Map initialization failed:', error);
                    updateMapStatus('Failed to initialize');
                }
            }

            // Update status display
            function updateMapStatus(message) {
                const statusElement = document.getElementById('map-status');
                if (statusElement) {
                    statusElement.textContent = `Map: ${message}`;
                }
            }

            function loadInitialAircraft() {
                if (!isMapInitialized) return;

                console.log('Loading initial aircraft data...');
                const aircraftData = @json($aircraft); // This is already a JavaScript array
                updateAircraftMarkers(aircraftData);
            }

            // Update markers with aircraft data - FIXED: Handle both object and JSON string
            function updateAircraftMarkers(aircraftData) {
                console.log('Received request to update aircraft markers');

                // Check if map is initialized
                if (!isMapInitialized) {
                    console.log('Map not initialized yet, storing data for later');
                    pendingAircraftData = aircraftData;
                    updateMapStatus('Waiting for map...');
                    return;
                }

                console.log('Updating aircraft markers with new data...');
                updateMapStatus('Updating markers...');

                let newAircraft = [];

                try {
                    // If aircraftData is a string (JSON), parse it
                    if (typeof aircraftData === 'string') {
                        newAircraft = JSON.parse(aircraftData);
                    }
                    // If it's already an array/object, use it directly
                    else if (Array.isArray(aircraftData)) {
                        newAircraft = aircraftData;
                    }
                    // If it's an object with an aircraft property (from Livewire event)
                    else if (aircraftData && typeof aircraftData === 'object' && aircraftData.aircraft) {
                        // Handle Livewire event format
                        if (typeof aircraftData.aircraft === 'string') {
                            newAircraft = JSON.parse(aircraftData.aircraft);
                        } else {
                            newAircraft = aircraftData.aircraft;
                        }
                    }
                    else {
                        console.error('Invalid aircraft data format:', typeof aircraftData, aircraftData);
                        updateMapStatus('Invalid data format');
                        return;
                    }
                } catch (e) {
                    console.error('Error processing aircraft data:', e, aircraftData);
                    updateMapStatus('Error processing data');
                    return;
                }

                console.log(`Received ${newAircraft.length} aircraft positions`);

                if (newAircraft.length === 0) {
                    console.log('No aircraft data available');
                    clearAllMarkers();
                    updateMapStatus('No aircraft detected');
                    return;
                }

                // Remove duplicates: Keep only most recent position for each aircraft
                console.log('Removing duplicate aircraft (keeping most recent)...');

                const uniqueAircraftMap = new Map();

                // Process each aircraft
                newAircraft.forEach(aircraft => {
                    // Skip if missing coordinates
                    if (!aircraft.latitude || !aircraft.longitude ||
                        isNaN(aircraft.latitude) || isNaN(aircraft.longitude)) {
                        console.warn('Skipping aircraft with invalid coordinates:', aircraft.hex);
                        return;
                    }

                    // Ensure proper data types
                    aircraft.latitude = parseFloat(aircraft.latitude);
                    aircraft.longitude = parseFloat(aircraft.longitude);
                    aircraft.threat_level = parseInt(aircraft.threat_level) || 1;

                    // If we haven't seen this hex, or if this position is newer than what we have
                    if (!uniqueAircraftMap.has(aircraft.hex)) {
                        uniqueAircraftMap.set(aircraft.hex, aircraft);
                    } else {
                        // Compare position times to keep the most recent
                        const existing = uniqueAircraftMap.get(aircraft.hex);
                        const existingTime = new Date(existing.position_time || 0);
                        const newTime = new Date(aircraft.position_time || 0);

                        if (newTime > existingTime) {
                            uniqueAircraftMap.set(aircraft.hex, aircraft);
                        }
                    }
                });

                // Convert map back to array
                const uniqueAircraft = Array.from(uniqueAircraftMap.values());

                console.log(`Filtered to ${uniqueAircraft.length} unique aircraft (from ${newAircraft.length} positions)`);

                // Clear existing markers
                clearAllMarkers();

                // Counters for stats
                let civilCount = 0;
                let militaryCount = 0;
                let droneCount = 0;
                let highThreatCount = 0;

                // Add markers for each unique aircraft
                uniqueAircraft.forEach(aircraft => {
                    // Determine marker color and icon
                    let color = colorMap.civil;
                    let icon = 'plane';

                    if (aircraft.is_military) {
                        color = colorMap.military;
                        icon = 'fighter-jet';
                        militaryCount++;
                    } else if (aircraft.is_drone) {
                        color = colorMap.drone;
                        icon = 'drone';
                        droneCount++;
                    } else {
                        civilCount++;
                    }

                    // High threat aircraft get orange color
                    if (aircraft.threat_level >= 4) {
                        color = colorMap['high-threat'];
                        highThreatCount++;
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
                                box-shadow: 0 0 8px rgba(0,0,0,0.7);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: white;
                                font-size: 10px;
                                cursor: pointer;
                                transition: transform 0.2s;
                            "
                            onmouseover="this.style.transform='scale(1.2)'"
                            onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-${icon}"></i>
                            </div>
                        `,
                        className: 'custom-aircraft-marker',
                        iconSize: [26, 26],
                        iconAnchor: [13, 13],
                        popupAnchor: [0, -13]
                    });

                    try {
                        // Create marker
                        const marker = L.marker([aircraft.latitude, aircraft.longitude], {
                            icon: customIcon,
                            title: `${aircraft.callsign || aircraft.hex} - ${aircraft.aircraft_name || aircraft.type}`,
                            alt: `Aircraft ${aircraft.hex}`,
                            riseOnHover: true
                        });

                        // Add popup with aircraft info
                        marker.bindPopup(createPopupContent(aircraft));

                        // Add to map
                        marker.addTo(map);

                        // Add click handler to open popup
                        marker.on('click', function() {
                            this.openPopup();
                        });

                        // Store in markers map
                        markers.set(aircraft.hex, marker);

                    } catch (error) {
                        console.error(`Failed to create marker for aircraft ${aircraft.hex}:`, error);
                    }
                });

                console.log(`Added ${markers.size} markers to map`);

                // Update statistics and map status
                updateStatistics(civilCount, militaryCount, droneCount, highThreatCount);

                // If we have markers, fit bounds to show all aircraft
                if (markers.size > 0) {
                    fitMapToMarkers();
                    updateMapStatus(`Showing ${markers.size} unique aircraft`);

                    // Log some debug info
                    console.log('Aircraft breakdown:', {
                        civil: civilCount,
                        military: militaryCount,
                        drones: droneCount,
                        highThreat: highThreatCount,
                        total: markers.size
                    });
                } else {
                    updateMapStatus('No aircraft to display');
                }
            }

            // Helper function to clear all markers
            function clearAllMarkers() {
                console.log(`Clearing ${markers.size} existing markers...`);
                markers.forEach(marker => {
                    if (map && map.hasLayer(marker)) {
                        map.removeLayer(marker);
                    }
                });
                markers.clear();
            }

            // Helper function to fit map to all markers
            function fitMapToMarkers() {
                if (markers.size === 0 || !map) {
                    return;
                }

                try {
                    const bounds = L.latLngBounds(Array.from(markers.values()).map(m => m.getLatLng()));

                    // Add padding and ensure minimum zoom
                    const paddedBounds = bounds.pad(0.1);

                    // Check if bounds are valid
                    if (paddedBounds.isValid()) {
                        map.fitBounds(paddedBounds, {
                            padding: [50, 50],
                            maxZoom: 12,
                            animate: true,
                            duration: 1
                        });
                    }
                } catch (error) {
                    console.error('Error fitting map to markers:', error);
                }
            }

            // Helper function to update statistics display
            function updateStatistics(civil, military, drone, highThreat) {
                const statsElement = document.getElementById('map-stats');
                if (statsElement) {
                    statsElement.innerHTML = `
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary">Civil: ${civil}</span>
                            <span class="badge bg-danger">Military: ${military}</span>
                            <span class="badge bg-purple">Drones: ${drone}</span>
                            <span class="badge bg-warning">High Threat: ${highThreat}</span>
                        </div>
                    `;
                }
            }

            // Enhanced popup content creation
            function createPopupContent(aircraft) {
                // Format data
                const altitude = aircraft.altitude ? Math.round(parseFloat(aircraft.altitude)) : 'N/A';
                const speed = aircraft.speed ? Math.round(parseFloat(aircraft.speed)) : 'N/A';
                const heading = aircraft.heading ? parseFloat(aircraft.heading).toFixed(0) + '°' : 'N/A';

                // Format position time
                let positionTimeFormatted = 'Unknown';
                if (aircraft.position_time) {
                    const date = new Date(aircraft.position_time);
                    positionTimeFormatted = date.toLocaleTimeString('et-EE', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Europe/Tallinn'
                    });
                }

                // Determine aircraft type badge
                let typeBadge = '';
                if (aircraft.is_military) {
                    typeBadge = '<span class="badge bg-danger">Military</span>';
                } else if (aircraft.is_drone) {
                    typeBadge = '<span class="badge bg-purple">Drone</span>';
                } else {
                    typeBadge = '<span class="badge bg-primary">Civil</span>';
                }

                // NATO badge
                const natoBadge = aircraft.is_nato ? '<span class="badge bg-info ms-1">NATO</span>' : '';

                // Threat level stars
                const threatStars = '★'.repeat(aircraft.threat_level) + '☆'.repeat(5 - aircraft.threat_level);

                // Warning indicators
                let warnings = '';
                if (aircraft.near_sensitive) warnings += '<div class="text-danger small">⚠️ Near sensitive location</div>';
                if (aircraft.near_military_base) warnings += '<div class="text-warning small">🏭 Near military base</div>';
                if (aircraft.near_border) warnings += '<div class="text-info small">🇪🇪 Near border</div>';

                return `
                    <div style="min-width: 240px; max-width: 300px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><strong>${aircraft.callsign || 'N/A'}</strong></h6>
                                <small class="text-muted">${aircraft.hex}</small>
                            </div>
                            <div>${typeBadge}${natoBadge}</div>
                        </div>

                        <hr class="my-2">

                        <div class="mb-2">
                            <strong>${aircraft.aircraft_name || aircraft.type || 'Unknown Aircraft'}</strong><br>
                            <small>${aircraft.country || 'Unknown country'}</small>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <small><strong>Position:</strong></small><br>
                                <code>${aircraft.latitude.toFixed(4)}, ${aircraft.longitude.toFixed(4)}</code>
                            </div>
                            <div class="col-6">
                                <small><strong>Threat:</strong></small><br>
                                <span class="text-warning">${threatStars}</span>
                            </div>
                            <div class="col-6">
                                <small><strong>Altitude:</strong></small><br>
                                ${altitude} m
                            </div>
                            <div class="col-6">
                                <small><strong>Speed:</strong></small><br>
                                ${speed} km/h
                            </div>
                            <div class="col-6">
                                <small><strong>Heading:</strong></small><br>
                                ${heading}
                            </div>
                            <div class="col-6">
                                <small><strong>In Estonia:</strong></small><br>
                                ${aircraft.in_estonia ? '✅ Yes' : '❌ No'}
                            </div>
                        </div>

                        ${warnings ? '<hr class="my-2">' + warnings : ''}

                        <hr class="my-2">
                        <div class="text-center">
                            <small class="text-muted">Position time: ${positionTimeFormatted}</small>
                        </div>
                    </div>
                `;
            }

            // Initialize when page loads
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Page loaded, initializing map...');
                setTimeout(initMap, 100);

                // Auto-refresh every 30 seconds
                setInterval(() => {
                    console.log('Auto-refresh triggered');
                    @this.loadAircraftData();
                }, 30000);
            });

            // Listen for Livewire events - FIXED: Handle the event properly
            document.addEventListener('livewire:init', () => {
                console.log('Livewire initialized');

                Livewire.on('aircraft-updated', (event) => {
                    console.log('Received aircraft update event', event);
                    // Pass the entire event object to updateAircraftMarkers
                    // It will handle the data format
                    updateAircraftMarkers(event);
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (map) {
                    setTimeout(() => map.invalidateSize(), 100);
                }
            });

            // Debug function
            function showDebugInfo() {
                console.log('Map debug info:', {
                    isMapInitialized: isMapInitialized,
                    markersCount: markers.size,
                    pendingData: pendingAircraftData,
                    map: map
                });

                alert(`Map Status:
- Map initialized: ${isMapInitialized}
- Markers displayed: ${markers.size}
- Last update: ${document.getElementById('map-status')?.textContent || 'N/A'}`);
            }
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            #map {
                min-height: 600px;
                border-radius: 4px;
                background-color: #e9ecef;
            }
            .leaflet-container {
                font-family: inherit;
                font-size: 14px;
            }
            .leaflet-popup-content {
                font-size: 14px;
            }
            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
            }
            .custom-aircraft-marker {
                background: transparent !important;
                border: none !important;
            }
            .badge.bg-purple {
                background-color: #6f42c1 !important;
                color: white;
            }
        </style>
    @endpush
</div>
