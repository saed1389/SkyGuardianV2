<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-map-marked-alt me-2"></i><span data-key="t-live-air-traffic-map" wire:ignore>Live Air Traffic Map</span>
                            </h1>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-3">
                                    <i class="fas fa-sync-alt fa-spin me-1" wire:loading></i>
                                    <span data-key="t-last-update" wire:ignore>Last Update</span>: {{ $lastUpdate }}
                                </span>
                                <button wire:click="loadAircraftData" class="btn btn-sm btn-outline-primary" wire:loading.attr="disabled">
                                    <i class="fas fa-redo"></i> <span data-key="t-refresh">Refresh</span>
                                </button>
                            </div>
                        </div>
                        <p class="text-muted mb-0" data-key="t-Real-time-monitoring-of-Estonian-airspace" wire:ignore>Real-time monitoring of Estonian airspace</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="text-white" data-key="t-total-aircraft" wire:ignore>Total Aircraft</h6>
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
                                        <h6 class="text-white" data-key="t-military" wire:ignore>Military</h6>
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
                                        <h6 class="text-white" data-key="t-high-threat" wire:ignore>High Threat</h6>
                                        <h2 class="mb-0 text-white">
                                            {{ $highThreatCount }}
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
                                        <h6 class="text-white" data-key="t-in-estonia" wire:ignore>In Estonia</h6>
                                        <h2 class="mb-0 text-white">
                                            {{ $inEstoniaCount }}
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
                                        <label class="form-label" data-key="t-aircraft-type" wire:ignore>Aircraft Type</label>
                                        <select wire:model.live="filterType" wire:change="loadAircraftData" class="form-select">
                                            <option value="all" data-key="t-all-types" wire:ignore>All Types</option>
                                            <option value="military" data-key="t-military-only" wire:ignore>Military Only</option>
                                            <option value="civil" data-key="t-civil-only" wire:ignore>Civil Only</option>
                                            <option value="drone" data-key="t-drones-only" wire:ignore>Drones Only</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" data-key="t-country" wire:ignore>Country</label>
                                        <select wire:model.live="filterCountry" wire:change="loadAircraftData" class="form-select">
                                            <option value="all" data-key="t-all-countries" wire:ignore>All Countries</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country }}">{{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" data-key="t-threat-level" wire:ignore>Threat Level</label>
                                        <select wire:model.live="filterThreatLevel" wire:change="loadAircraftData" class="form-select">
                                            <option value="all" data-key="t-all-levels" wire:ignore>All Levels</option>
                                            <option value="4" data-key="t-high-threat-(4-5)" wire:ignore>High Threat (4-5)</option>
                                            <option value="3" data-key="t-medium-threat-(3)" wire:ignore>Medium Threat (3)</option>
                                            <option value="1" data-key="t-low-threat-(1-2)" wire:ignore>Low Threat (1-2)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> <span data-key="Clear Filters" wire:ignore>Clear Filters</span>
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
                            <div class="card-body p-0">
                                <div id="map" style="height: 600px; width: 100%;" wire:ignore></div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="me-3">
                                                <span class="badge bg-primary me-1">●</span> <span data-key="t-civil" wire:ignore>Civil</span>
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-danger me-1">●</span> <span data-key="t-military" wire:ignore>Military</span>
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-warning me-1">●</span> <span data-key="t-high-threat" wire:ignore>High Threat</span>
                                            </span>
                                            <span class="me-3">
                                                <span class="badge bg-success me-1">●</span> <span data-key="t-in-estonia" wire:ignore>In Estonia</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted" data-ket="t-auto-refresh-every-30-seconds" wire:ignore>
                                            Auto-refresh every 30 seconds • Click markers for details
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0" data-key="t-recent-aircraft-positions" wire:ignore>Recent Aircraft Positions</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th data-key="t-callsign" wire:ignore>Callsign</th>
                                            <th data-key="t-type" wire:ignore>Type</th>
                                            <th data-key="t-country" wire:ignore>Country</th>
                                            <th data-key="t-position" wire:ignore>Position</th>
                                            <th data-key="t-altitude" wire:ignore>Altitude</th>
                                            <th data-key="t-speed" wire:ignore>Speed</th>
                                            <th data-key="t-threat" wire:ignore>Threat</th>
                                            <th data-key="t-last-seen" wire:ignore>Last Seen</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
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
                                                            <i class="fas fa-history me-1"></i> {{ $positionCount }} <span data-key="t-positions" wire:ignore>positions</span>
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($ac['is_military'])
                                                        <span class="badge bg-danger" data-key="t-military" wire:ignore>Military</span>
                                                    @elseif($ac['is_drone'])
                                                        <span class="badge bg-warning" data-key="t-drone" wire:ignore>Drone</span>
                                                    @else
                                                        <span class="badge bg-primary" data-key="t-civil" wire:ignore>Civil</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $ac['country'] }}
                                                    @if($ac['is_nato'])
                                                        <br><small class="badge bg-info" data-key="t-nato" wire:ignore>NATO</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($ac['latitude'], 4) }}, {{ number_format($ac['longitude'], 4) }}
                                                    @if($ac['near_sensitive'])
                                                        <br><small class="text-danger">⚠️ <span data-key="t-near-sensitive" wire:ignore></span>Near sensitive</small>
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
                                                        <span data-key="t-level" wire:ignore>Level</span> {{ $ac['threat_level'] }}
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
                                                        <p data-key="t-no-aircraft-detected-in-the-last-5-minutes" wire:ignore>No aircraft detected in the last 5 minutes</p>
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

            const colorMap = {
                'civil': '#007bff',
                'military': '#dc3545',
                'drone': '#6f42c1',
                'high-threat': '#fd7e14'
            };

            function initMap() {
                if (isMapInitialized) return;

                try {
                    map = L.map('map').setView([58.5, 25.0], 8);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    const estonianBorder = L.polygon([
                        [59.8017, 26.5928],
                        [59.6781, 27.7683],
                        [59.4333, 27.9000],
                        [59.2333, 27.9167],
                        [58.0500, 27.5333],
                        [57.5167, 27.2167],
                        [57.3833, 26.4667],
                        [57.8833, 23.5333],
                        [58.3667, 21.7833],
                        [58.6333, 22.4333],
                        [59.3667, 22.9833],
                        [59.7833, 24.1167],
                        [59.8017, 26.5928]
                    ], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.05,
                        weight: 2,
                        dashArray: '5, 5'
                    }).addTo(map).bindPopup('<b>Estonian Airspace</b><br>National borders and territorial airspace');

                    const estoniaDetailed = L.polygon([
                        [59.8017, 26.5928],
                        [59.6667, 27.8833],
                        [59.4667, 27.9667],
                        [58.7333, 27.6500],
                        [58.0667, 27.5333],
                        [57.5167, 27.2167],
                        [57.8833, 24.5667],
                        [57.3833, 23.5333],
                        [57.8833, 23.5333],
                        [58.3667, 21.7833],
                        [58.4833, 22.0833],
                        [58.6333, 22.4333],
                        [58.8833, 22.7833],
                        [59.3667, 22.9833],
                        [59.7833, 24.1167],
                        [59.8017, 26.5928]
                    ], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.03,
                        weight: 1.5,
                        dashArray: '3, 3'
                    }).addTo(map).bindPopup('Detailed Estonian Territory');

                    const islands = {
                        'Saaremaa': [
                            [58.2167, 22.0833], [58.4833, 21.7833], [58.3667, 22.7833], [58.0667, 22.4833]
                        ],
                        'Hiiumaa': [
                            [58.9333, 22.4333], [58.8833, 22.7833], [58.7833, 23.0333], [58.8667, 22.5833]
                        ],
                        'Muhu': [
                            [58.6000, 23.2333], [58.6167, 23.3833], [58.5500, 23.4333], [58.5333, 23.2833]
                        ],
                        'Vormsi': [
                            [59.0000, 23.2000], [59.0333, 23.3000], [58.9667, 23.3667], [58.9333, 23.2500]
                        ]
                    };

                    Object.entries(islands).forEach(([name, coords]) => {
                        L.polygon(coords, {
                            color: '#0d6efd',
                            fillColor: '#0d6efd',
                            fillOpacity: 0.02,
                            weight: 1,
                            dashArray: '2, 2'
                        }).addTo(map).bindPopup(`<b>${name}</b><br>Estonian Island`);
                    });

                    L.polyline([
                        [59.8017, 26.5928],
                        [59.6667, 27.8833],
                        [59.4667, 27.9667],
                        [58.7333, 27.6500],
                        [58.0667, 27.5333]
                    ], {
                        color: '#dc3545',
                        weight: 3,
                        opacity: 0.7,
                        dashArray: '10, 10'
                    }).addTo(map).bindPopup('<b>Estonia-Russia Border</b><br>International boundary');

                    L.polyline([
                        [58.0667, 27.5333],
                        [57.5167, 27.2167],
                        [57.8833, 24.5667],
                        [57.3833, 23.5333]
                    ], {
                        color: '#28a745',
                        weight: 2,
                        opacity: 0.6,
                        dashArray: '5, 5'
                    }).addTo(map).bindPopup('<b>Estonia-Latvia Border</b><br>EU internal border');

                    const sensitiveLocations = [
                        {name: 'Tallinn Airport (TLL)', lat: 59.4133, lon: 24.8328, radius: 2000, type: 'airport'},
                        {name: 'Ämari Air Base', lat: 59.2603, lon: 24.2084, radius: 3000, type: 'military'},
                        {name: 'Tartu Airport (TAY)', lat: 58.3075, lon: 26.6904, radius: 1500, type: 'airport'},
                        {name: 'Kuressaare Airport (URE)', lat: 58.2299, lon: 22.5095, radius: 1500, type: 'airport'},
                        {name: 'Pärnu Airport (EPU)', lat: 58.4190, lon: 24.4728, radius: 1500, type: 'airport'},
                        {name: 'Kärdla Airport (KDL)', lat: 58.9908, lon: 22.8307, radius: 1500, type: 'airport'},
                        {name: 'Paldiski Port', lat: 59.3567, lon: 24.0531, radius: 2000, type: 'port'},
                        {name: 'Sillamäe Port', lat: 59.3922, lon: 27.7639, radius: 1500, type: 'port'},
                        {name: 'NATO CCDCOE Tallinn', lat: 59.4308, lon: 24.7714, radius: 1000, type: 'military'},
                        {name: 'Estonian MoD', lat: 59.4269, lon: 24.7289, radius: 800, type: 'government'},
                        {name: 'Tapa Army Base', lat: 59.2686, lon: 25.9589, radius: 2500, type: 'military'}
                    ];

                    const typeColors = {
                        'airport': '#ff9900',
                        'military': '#dc3545',
                        'port': '#17a2b8',
                        'government': '#6f42c1'
                    };

                    sensitiveLocations.forEach(loc => {
                        const color = typeColors[loc.type] || '#ff0000';
                        L.circle([loc.lat, loc.lon], {
                            color: color,
                            fillColor: color,
                            fillOpacity: 0.1,
                            radius: loc.radius
                        }).bindPopup(`<b>${loc.name}</b><br>${loc.type.charAt(0).toUpperCase() + loc.type.slice(1)} facility`).addTo(map);
                    });

                    const majorCities = [
                        {name: 'Tallinn', lat: 59.4370, lon: 24.7536, population: 447000, capital: true},
                        {name: 'Tartu', lat: 58.3780, lon: 26.7290, population: 91000, capital: false},
                        {name: 'Narva', lat: 59.3777, lon: 28.1903, population: 54000, capital: false},
                        {name: 'Pärnu', lat: 58.3850, lon: 24.4978, population: 39000, capital: false},
                        {name: 'Kohtla-Järve', lat: 59.3989, lon: 27.2503, population: 33000, capital: false},
                        {name: 'Viljandi', lat: 58.3639, lon: 25.5900, population: 17000, capital: false},
                        {name: 'Rakvere', lat: 59.3500, lon: 26.3500, population: 15000, capital: false},
                        {name: 'Maardu', lat: 59.4667, lon: 25.0167, population: 16000, capital: false},
                        {name: 'Kuressaare', lat: 58.2500, lon: 22.4833, population: 13000, capital: false},
                        {name: 'Jõhvi', lat: 59.3592, lon: 27.4211, population: 10000, capital: false}
                    ];

                    majorCities.forEach(city => {
                        const size = city.capital ? 8 : 5;
                        const color = city.capital ? '#dc3545' : '#0d6efd';

                        const formattedPopulation = city.population >= 1000 ?
                            (city.population / 1000).toFixed(0) + 'k' :
                            city.population.toLocaleString();

                        L.circleMarker([city.lat, city.lon], {
                            color: color,
                            fillColor: color,
                            fillOpacity: 0.3,
                            radius: size
                        }).addTo(map).bindPopup(`<b>${city.name}</b><br>Population: ${formattedPopulation}${city.capital ? '<br>🇪🇪 Capital of Estonia' : ''}`);
                    });

                    const legend = L.control({position: 'bottomright'});
                    legend.onAdd = function(map) {
                        const div = L.DomUtil.create('div', 'info legend');
                        div.innerHTML = `
                    <h4>Map Legend</h4>
                    <div><span style="background:#0d6efd; padding: 3px 8px; border-radius: 3px; color: white;">■</span> <span data-key="" wire:ignore>Estonian territory</span></div>
                    <div><span style="background:#dc3545; padding: 3px 8px; border-radius: 3px; color: white;">■</span> <span data-key="" wire:ignore>Russia border</span></div>
                    <div><span style="background:#28a745; padding: 3px 8px; border-radius: 3px; color: white;">■</span> <span data-key="" wire:ignore>Latvia border</span></div>
                    <div><span style="background:#ff9900; padding: 3px 8px; border-radius: 3px; color: white;">■</span> <span data-key="" wire:ignore>Airports</span></div>
                    <div><span style="background:#dc3545; padding: 3px 8px; border-radius: 3px; color: white;">■</span> <span data-key="" wire:ignore>Military bases</span></div>
                    <div><span style="background:#dc3545; padding: 3px 8px; border-radius: 3px; color: white;">●</span> <span data-key="" wire:ignore>Capital city</span></div>
                    <div><span style="background:#0d6efd; padding: 3px 8px; border-radius: 3px; color: white;">●</span> <span data-key="" wire:ignore>Other cities</span></div>
                `;
                        return div;
                    };
                    legend.addTo(map);

                    isMapInitialized = true;
                    updateMapStatus('Ready - Map showing accurate Estonian territory');

                    setTimeout(loadInitialAircraft, 100);

                } catch (error) {
                    updateMapStatus('Failed to initialize');
                }
            }

            function updateMapStatus(message) {
                const statusElement = document.getElementById('map-status');
                if (statusElement) {
                    statusElement.textContent = `Map: ${message}`;
                }
            }

            function loadInitialAircraft() {
                if (!isMapInitialized) return;

                const aircraftData = @json($aircraft);
                updateAircraftMarkers(aircraftData);
            }

            function updateAircraftMarkers(aircraftData) {

                if (!isMapInitialized) {
                    pendingAircraftData = aircraftData;
                    updateMapStatus('Waiting for map...');
                    return;
                }

                updateMapStatus('Updating markers...');

                let newAircraft = [];

                try {
                    if (typeof aircraftData === 'string') {
                        newAircraft = JSON.parse(aircraftData);
                    } else if (Array.isArray(aircraftData)) {
                        newAircraft = aircraftData;
                    } else if (aircraftData && typeof aircraftData === 'object' && aircraftData.aircraft) {
                        if (typeof aircraftData.aircraft === 'string') {
                            newAircraft = JSON.parse(aircraftData.aircraft);
                        } else {
                            newAircraft = aircraftData.aircraft;
                        }
                    } else {
                        updateMapStatus('Invalid data format');
                        return;
                    }
                } catch (e) {
                    updateMapStatus('Error processing data');
                    return;
                }

                if (newAircraft.length === 0) {
                    clearAllMarkers();
                    updateMapStatus('No aircraft detected');
                    return;
                }

                const uniqueAircraftMap = new Map();

                newAircraft.forEach(aircraft => {
                    if (!aircraft.latitude || !aircraft.longitude ||
                        isNaN(aircraft.latitude) || isNaN(aircraft.longitude)) {
                        return;
                    }

                    aircraft.latitude = parseFloat(aircraft.latitude);
                    aircraft.longitude = parseFloat(aircraft.longitude);
                    aircraft.threat_level = parseInt(aircraft.threat_level) || 1;

                    if (!uniqueAircraftMap.has(aircraft.hex)) {
                        uniqueAircraftMap.set(aircraft.hex, aircraft);
                    } else {
                        const existing = uniqueAircraftMap.get(aircraft.hex);
                        const existingTime = new Date(existing.position_time || 0);
                        const newTime = new Date(aircraft.position_time || 0);

                        if (newTime > existingTime) {
                            uniqueAircraftMap.set(aircraft.hex, aircraft);
                        }
                    }
                });

                const uniqueAircraft = Array.from(uniqueAircraftMap.values());

                clearAllMarkers();

                let civilCount = 0;
                let militaryCount = 0;
                let droneCount = 0;
                let highThreatCount = 0;
                let inEstoniaCount = 0;

                uniqueAircraft.forEach(aircraft => {
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

                    if (aircraft.threat_level >= 4) {
                        color = colorMap['high-threat'];
                        highThreatCount++;
                    }

                    if (aircraft.in_estonia) {
                        inEstoniaCount++;
                    }

                    const customIcon = L.divIcon({
                        html: `
                    <div style="
                        position: relative;
                        background-color: ${color};
                        width: 28px;
                        height: 28px;
                        border-radius: 50%;
                        border: 2px solid white;
                        box-shadow: 0 0 8px rgba(0,0,0,0.7);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-size: 12px;
                        cursor: pointer;
                        transition: transform 0.2s;
                        transform: rotate(${aircraft.heading || 0}deg);
                    "
                    onmouseover="this.style.transform='rotate(${aircraft.heading || 0}deg) scale(1.2)'"
                    onmouseout="this.style.transform='rotate(${aircraft.heading || 0}deg) scale(1)'">
                        <i class="fas fa-${icon}"></i>
                        ${aircraft.threat_level >= 4 ? '<div style="position: absolute; top: -5px; right: -5px; background: #fd7e14; width: 10px; height: 10px; border-radius: 50%; border: 1px solid white;"></div>' : ''}
                    </div>
                `,
                        className: 'custom-aircraft-marker',
                        iconSize: [30, 30],
                        iconAnchor: [15, 15],
                        popupAnchor: [0, -15]
                    });

                    try {
                        const marker = L.marker([aircraft.latitude, aircraft.longitude], {
                            icon: customIcon,
                            title: `${aircraft.callsign || aircraft.hex} - ${aircraft.aircraft_name || aircraft.type}`,
                            alt: `Aircraft ${aircraft.hex}`,
                            riseOnHover: true
                        });

                        marker.bindPopup(createPopupContent(aircraft));
                        marker.addTo(map);

                        marker.on('click', function() {
                            this.openPopup();
                        });

                        marker.on('mouseover', function() {
                            this.openPopup();
                        });

                        markers.set(aircraft.hex, marker);

                    } catch (error) {
                        console.error(`Failed to create marker for aircraft ${aircraft.hex}:`, error);
                    }
                });

                updateStatistics(civilCount, militaryCount, droneCount, highThreatCount, inEstoniaCount);

                if (markers.size > 0) {
                    fitMapToMarkers();
                    updateMapStatus(`Showing ${markers.size} aircraft over Estonia`);

                } else {
                    updateMapStatus('No aircraft to display');
                }
            }

            function clearAllMarkers() {
                markers.forEach(marker => {
                    if (map && map.hasLayer(marker)) {
                        map.removeLayer(marker);
                    }
                });
                markers.clear();
            }

            function fitMapToMarkers() {
                if (markers.size === 0 || !map) {
                    return;
                }

                try {
                    const bounds = L.latLngBounds(Array.from(markers.values()).map(m => m.getLatLng()));
                    const paddedBounds = bounds.pad(0.1);

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

            function updateStatistics(civil, military, drone, highThreat, inEstonia) {
                const statsElement = document.getElementById('map-stats');
                if (statsElement) {
                    statsElement.innerHTML = `
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-primary"><span data-key="t-civil" wire:ignore>Civil</span>: ${civil}</span>
                    <span class="badge bg-danger"><span data-key="t-military" wire:ignore>Military</span>: ${military}</span>
                    <span class="badge bg-purple"><span data-key="t-drones" wire:ignore>Drones</span>: ${drone}</span>
                    <span class="badge bg-warning"><span data-key="t-high-threat" wire:ignore>High Threat</span>: ${highThreat}</span>
                    <span class="badge bg-success"><span data-key="t-in-estonia" wire:ignore>In Estonia</span>: ${inEstonia}</span>
                </div>
            `;
                }
            }

            function createPopupContent(aircraft) {
                const altitude = aircraft.altitude ? Math.round(parseFloat(aircraft.altitude)) : 'N/A';
                const speed = aircraft.speed ? Math.round(parseFloat(aircraft.speed)) : 'N/A';
                const heading = aircraft.heading ? parseFloat(aircraft.heading).toFixed(0) + '°' : 'N/A';

                let positionTimeFormatted = 'Unknown';
                let timeAgo = '';
                if (aircraft.position_time) {
                    const date = new Date(aircraft.position_time);
                    positionTimeFormatted = date.toLocaleTimeString('et-EE', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Europe/Tallinn'
                    });

                    const now = new Date();
                    const diffMs = now - date;
                    const diffSec = Math.floor(diffMs / 1000);
                    const diffMin = Math.floor(diffSec / 60);

                    if (diffMin < 1) {
                        timeAgo = `${diffSec} seconds ago`;
                    } else if (diffMin < 60) {
                        timeAgo = `${diffMin} minutes ago`;
                    } else {
                        const diffHours = Math.floor(diffMin / 60);
                        timeAgo = `${diffHours} hours ago`;
                    }
                }

                let typeBadge = '';
                if (aircraft.is_military) {
                    typeBadge = '<span class="badge bg-danger">Military</span>';
                } else if (aircraft.is_drone) {
                    typeBadge = '<span class="badge bg-purple">Drone</span>';
                } else {
                    typeBadge = '<span class="badge bg-primary">Civil</span>';
                }

                const natoBadge = aircraft.is_nato ? '<span class="badge bg-info ms-1">NATO</span>' : '';
                const threatStars = '★'.repeat(aircraft.threat_level) + '☆'.repeat(5 - aircraft.threat_level);

                const threatColor = aircraft.threat_level >= 4 ? 'text-danger' :
                    aircraft.threat_level >= 3 ? 'text-warning' :
                        'text-success';

                let warnings = '';
                if (aircraft.near_sensitive) warnings += '<div class="text-danger small"><i class="fas fa-exclamation-triangle"></i> Near sensitive location</div>';
                if (aircraft.near_military_base) warnings += '<div class="text-warning small"><i class="fas fa-fort-awesome"></i> Near military base</div>';
                if (aircraft.near_border) warnings += '<div class="text-info small"><i class="fas fa-map-signs"></i> Near border</div>';
                if (aircraft.is_potential_threat) warnings += '<div class="text-danger small"><i class="fas fa-skull-crossbones"></i> Potential threat</div>';

                const isInEstonia = checkIfInEstonia(aircraft.latitude, aircraft.longitude);

                return `
            <div style="min-width: 260px; max-width: 320px;">
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
                    <small><i class="fas fa-flag"></i> ${aircraft.country || 'Unknown country'}</small>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <small><strong><i class="fas fa-map-marker-alt"></i> Position:</strong></small><br>
                        <code>${aircraft.latitude.toFixed(4)}, ${aircraft.longitude.toFixed(4)}</code>
                    </div>
                    <div class="col-6">
                        <small><strong><i class="fas fa-shield-alt"></i> <span data-key="t-threat" wire:ignore>Threat</span>:</strong></small><br>
                        <span class="${threatColor}">${threatStars}</span>
                    </div>
                    <div class="col-6">
                        <small><strong><i class="fas fa-mountain"></i> <span data-key="t-altitude" wire:ignore>Altitude</span>:</strong></small><br>
                        ${altitude} m
                    </div>
                    <div class="col-6">
                        <small><strong><i class="fas fa-tachometer-alt"></i> <span data-key="t-speed" wire:ignore>Speed</span>:</strong></small><br>
                        ${speed} km/h
                    </div>
                    <div class="col-6">
                        <small><strong><i class="fas fa-compass"></i> <span data-key="t-heading" wire:ignore>Heading</span>:</strong></small><br>
                        ${heading}
                    </div>
                    <div class="col-6">
                        <small><strong><i class="fas fa-location-arrow"></i> <span data-key="t-location" wire:ignore>Location</span>:</strong></small><br>
                        ${isInEstonia ? '<span class="text-success">✅ <span data-key="t-in-estonian-airspace" wire:ignore>In Estonian airspace</span></span>' :
                    aircraft.in_estonia ? '<span class="text-warning">⚠️ <span data-key="t-in-estonia" wire:ignore>In Estonia</span></span>' :
                        '<span class="text-secondary">❌ <span data-key="t-outside-estonia" wire:ignore>Outside Estonia</span></span>'}
                    </div>
                </div>

                ${warnings ? '<div class="mt-2 p-2 bg-light rounded">' + warnings + '</div>' : ''}

                <hr class="my-2">
                <div class="text-center">
                    <small class="text-muted">
                        <i class="far fa-clock"></i> ${positionTimeFormatted}<br>
                        ${timeAgo ? `<small>(${timeAgo})</small>` : ''}
                    </small>
                </div>
            </div>
        `;
            }

            function checkIfInEstonia(lat, lon) {

                return lat >= 57.5 && lat <= 60.0 && lon >= 21.5 && lon <= 28.5;
            }

            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initMap, 100);

                setInterval(() => {
                    @this.loadAircraftData();
                }, 30000);
            });

            document.addEventListener('livewire:init', () => {

                Livewire.on('aircraft-updated', (event) => {
                    updateAircraftMarkers(event);
                });
            });

            window.addEventListener('resize', () => {
                if (map) {
                    setTimeout(() => map.invalidateSize(), 100);
                }
            });

            document.addEventListener('keydown', function(e) {
                if (!map) return;

                switch(e.key) {
                    case '+':
                    case '=':
                        map.zoomIn();
                        break;
                    case '-':
                        map.zoomOut();
                        break;
                    case 'r':
                    case 'R':
                        if (e.ctrlKey) {
                            e.preventDefault();
                            @this.loadAircraftData();
                        }
                        break;
                    case 'f':
                    case 'F':
                        if (e.ctrlKey) {
                            e.preventDefault();
                            fitMapToMarkers();
                        }
                        break;
                    case 'h':
                    case 'H':
                        if (e.ctrlKey) {
                            e.preventDefault();
                            map.setView([58.5, 25.0], 8);
                        }
                        break;
                }
            });
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('user/assets/css/pages/live-map.css') }}" />
    @endpush
</div>
