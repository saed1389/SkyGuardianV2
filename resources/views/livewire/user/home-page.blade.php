<div>
    @if($loading)
        <div class="loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden" data-key="t-loading" wire:ignore>Loading...</span>
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
                                    <i class="fas fa-tachometer-alt me-2"></i><span data-key="t-dashboard" wire:ignore>Dashboard</span>
                                </h1>
                                <p class="text-muted mb-0"><span data-key="t-real-time-monitoring" wire:ignore>Real-time airspace monitoring and threat assessment</span></p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-end">
                                    <div class="text-muted small"><span data-key="t-last-update" wire:ignore>Last Update</span></div>
                                    <div class="h6 mb-0">{{ $stats['update_time'] ?? '--:--:--' }}</div>
                                </div>

                                <div class="form-check form-switch d-flex align-items-center me-2">
                                    <input class="form-check-input" type="checkbox" id="autoRefreshToggle" {{ $autoRefreshEnabled ? 'checked' : '' }} wire:click="toggleAutoRefresh">
                                    <label class="form-check-label ms-2 small" for="autoRefreshToggle">
                                        <span data-key="t-auto-refresh" wire:ignore>Auto Refresh</span>
                                    </label>
                                </div>

                                <button wire:click="refreshDashboard" wire:loading.attr="disabled" class="btn btn-sm btn-primary">
                                    <i class="fas fa-sync-alt" wire:loading.class="fa-spin"></i> <span data-key="t-refresh" wire:ignore>Refresh</span>
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
                                    <span data-key="t-no-active-aircraft-found" wire:ignore>No active aircraft found in the last 60 minutes.</span>
                                    <span data-key="t-this-could-mean" wire:ignore>This could mean:</span>
                                    <ul class="mb-0 mt-1">
                                        <li><span data-key="t-no-aircraft-transmitted" wire:ignore>No aircraft have transmitted position data recently</span></li>
                                        <li><span data-key="t-database-connection-issue" wire:ignore>Database connection issue</span></li>
                                        <li><span data-key="t-all-aircraft-outside" wire:ignore>All aircraft are outside the monitoring area</span></li>
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
                                    <span data-key="t-showing-data-last-60" wire:ignore>Showing data from the last 60 minutes only.</span>
                                    <span id="data-freshness-indicator">
                                    {{ $stats['active_aircraft'] ?? 0 }} <span data-key="t-aircraft-currently-active" wire:ignore>aircraft currently active</span>.
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
                                        <div class="h6 mb-1 text-white"><span data-key="t-active-aircraft" wire:ignore>Active Aircraft</span></div>
                                        <div class="display-6 fw-bold">{{ $stats['active_aircraft'] ?? 0 }}</div>
                                        <small class="opacity-75"><span data-key="t-last-60-minutes" wire:ignore>Last 60 minutes</span></small>
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
                                    <small class="opacity-75">{{ $stats['total_aircraft'] ?? 0 }} <span data-key="t-total-in-database" wire:ignore>total in database</span></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-danger text-white border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white"><span data-key="t-military" wire:ignore>Military</span></div>
                                        <div class="display-6 fw-bold">{{ $stats['active_military'] ?? 0 }}</div>
                                        <small class="opacity-75"><span data-key="t-active-military" wire:ignore>Active military</span></small>
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
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['active_military'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% <span data-key="t-of-active" wire:ignore>of active</span></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-warning text-white border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white"><span data-key="t-high-threat" wire:ignore>High Threat</span></div>
                                        <div class="display-6 fw-bold ">{{ $stats['high_threat'] ?? 0 }}</div>
                                        <small class="opacity-75 "><span data-key="t-threat-level-4" wire:ignore>Threat level ≥ 4</span></small>
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
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['high_threat'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% <span data-key="t-threat-ratio" wire:ignore>threat ratio</span></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-info text-white border-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white"><span data-key="t-in-estonia" wire:ignore>In Estonia</span></div>
                                        <div class="display-6 fw-bold">{{ $stats['in_estonia'] ?? 0 }}</div>
                                        <small class="opacity-75"><span data-key="t-inside-airspace" wire:ignore>Inside airspace</span></small>
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
                                    <small class="opacity-75">{{ ($stats['active_aircraft'] ?? 0) > 0 ? round((($stats['in_estonia'] ?? 0) / ($stats['active_aircraft'] ?? 1) * 100), 1) : 0 }}% <span data-key="t-in-airspace" wire:ignore>in airspace</span></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-success text-white border-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white"><span data-key="t-ai-alerts" wire:ignore>AI Alerts</span></div>
                                        <div class="display-6 fw-bold">{{ $stats['ai_alerts_today'] ?? 0 }}</div>
                                        <small class="opacity-75"><span data-key="t-today" wire:ignore>Today</span></small>
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
                                    <small class="opacity-75"><span data-key="t-avg" wire:ignore>Avg</span>: {{ $stats['avg_alerts_per_hour'] ?? 0 }}/<span data-key="t-hour" wire:ignore>hour</span></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-dark text-white border-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="h6 mb-1 text-white"><span data-key="t-latest-risk" wire:ignore>Latest Risk</span></div>
                                        @if(isset($stats['latest_analysis']) && $stats['latest_analysis']->overall_risk)
                                            <div class="display-6 fw-bold text-{{ strtolower($stats['latest_analysis']->overall_risk) === 'high' ? 'danger' : (strtolower($stats['latest_analysis']->overall_risk) === 'medium' ? 'warning' : 'success') }}">
                                                {{ $stats['latest_analysis']->overall_risk }}
                                            </div>
                                            <small class="opacity-75"><span data-key="t-latest-analysis" wire:ignore>Latest analysis</span></small>
                                        @else
                                            <div class="display-6 fw-bold" wire:ignore>N/A</div>
                                            <small class="opacity-75"><span data-key="t-no-data" wire:ignore>No data</span></small>
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
                                        <i class="fas fa-map-marked-alt me-2"></i><span data-key="t-live-air-traffic-map" wire:ignore>Live Air Traffic Map</span>
                                    </h5>
                                    <div>
                                        <span class="badge bg-light text-dark me-2" id="map-aircraft-count">
                                            {{ count($activeAircraft) }} <span data-key="t-active-aircraft" wire:ignore>active aircraft</span>
                                        </span>
                                        <span class="badge bg-info" title="" data-title-key="t-data-freshness">
                                            <i class="fas fa-clock me-1"></i><span data-key="t-last-60-minutes" wire:ignore>Last 60 min</span>
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
                                                <span class="badge bg-primary me-1">●</span> <span data-key="t-civil" wire:ignore>Civil</span>
                                            </span>
                                            <span>
                                                <span class="badge bg-danger me-1">●</span> <span data-key="t-military" wire:ignore>Military</span>
                                            </span>
                                            <span>
                                                <span class="badge bg-warning me-1">●</span> <span data-key="t-drone" wire:ignore>Drone</span>
                                            </span>
                                            <span>
                                                <span class="badge bg-info me-1">●</span> <span data-key="t-nato" wire:ignore>NATO</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            <i class="fas fa-filter me-1"></i>
                                            <span data-key="t-filtered" wire:ignore>Filtered</span>: <span data-key="t-last-60-minutes" wire:ignore>Last 60 minutes only</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-plane me-2"></i><span data-key="t-active-aircraft-last-hour" wire:ignore>Active Aircraft (Last Hour)</span>
                                    </h5>
                                    <span class="badge bg-info">
                                        <i class="fas fa-clock me-1"></i><span data-key="t-showing-last-60-minutes" wire:ignore>Showing last 60 minutes</span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th><span data-key="t-callsign" wire:ignore>Callsign</span></th>
                                            <th><span data-key="t-type" wire:ignore>Type</span></th>
                                            <th><span data-key="t-country" wire:ignore>Country</span></th>
                                            <th><span data-key="t-position" wire:ignore>Position</span></th>
                                            <th><span data-key="t-altitude" wire:ignore>Altitude</span></th>
                                            <th><span data-key="t-speed" wire:ignore>Speed</span></th>
                                            <th><span data-key="t-threat" wire:ignore>Threat</span></th>
                                            <th><span data-key="t-last-seen" wire:ignore>Last Seen</span></th>
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
                                                        <span class="badge bg-danger"><span data-key="t-military" wire:ignore>Military</span></span>
                                                    @elseif($aircraft->is_drone)
                                                        <span class="badge bg-warning"><span data-key="t-drones" wire:ignore>Drones</span></span>
                                                    @else
                                                        <span class="badge bg-primary"><span data-key="t-civil" wire:ignore>Civil</span></span>
                                                    @endif
                                                    <br>
                                                    <small>{{ $aircraft->type ?? 'Unknown' }}</small>
                                                </td>
                                                <td>
                                                    {{ $aircraft->country ?? 'Unknown' }}
                                                    @if($aircraft->is_nato)
                                                        <br><span class="badge bg-info"><span data-key="t-nato" wire:ignore>NATO</span></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($aircraft->latitude && $aircraft->longitude)
                                                        <code>{{ number_format($aircraft->latitude, 4) }}, {{ number_format($aircraft->longitude, 4) }}</code>
                                                        @if($aircraft->in_estonia)
                                                            <br><span class="badge bg-success"><span data-key="t-in-estonia" wire:ignore>In Estonia</span></span>
                                                        @endif
                                                        @if($aircraft->near_sensitive)
                                                            <br><span class="badge bg-danger"><span data-key="t-near-sensitive" wire:ignore>Near Sensitive</span></span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted"><span data-key="t-no-position" wire:ignore>No position</span></span>
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
                                                        <span data-key="t-threat" wire:ignore>Threat</span> {{ $aircraft->aircraft_threat }}
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
                                                                <i class="fas fa-exclamation-circle me-1"></i><span data-key="t-data-may-be-stale" wire:ignore>Data may be stale</span>
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
                                                        <p><span data-key="t-no-active-aircraft-last-hour" wire:ignore>No active aircraft in the last hour</span></p>
                                                        <small class="text-warning">
                                                            <span data-key="t-check-aircraft-transmitted" wire:ignore>Check if aircraft have transmitted position data recently.</span>
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
                                    <i class="fas fa-chart-line me-2"></i><span data-key="t-todays-activity" wire:ignore>Today's Activity</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div wire:ignore id="today-activity-chart" style="height: 200px;"></div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-pie me-2"></i><span data-key="t-threat-level-distribution" wire:ignore>Threat Level Distribution</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div wire:ignore id="threat-distribution-chart" style="height: 200px;"></div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i><span data-key="t-military-vs-civil" wire:ignore>Military vs Civil</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div wire:ignore id="military-civil-chart" style="height: 200px;"></div>
                                @if(count($activeAircraft) === 0)
                                    <div class="text-center text-muted small">
                                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                        <p><span data-key="t-no-aircraft-data-available" wire:ignore>No aircraft data available</span></p>
                                        <small><span data-key="t-chart-will-populate" wire:ignore>Chart will populate when aircraft are active</span></small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plane me-2"></i><span data-key="t-aircraft-types" wire:ignore>Aircraft Types</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div wire:ignore id="aircraft-types-chart" style="height: 200px;"></div>
                                @if(count($activeAircraft) === 0)
                                    <div class="text-center text-muted small">
                                        <i class="fas fa-plane fa-2x mb-2"></i>
                                        <p><span data-key="t-no-aircraft-data-available" wire:ignore>No aircraft data available</span></p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header bg-danger text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 text-white">
                                <i class="fas fa-robot me-2"></i><span data-key="t-recent-ai-alerts" wire:ignore>Recent AI Alerts</span>
                            </h5>
                            <span class="badge bg-light text-dark">
                                {{ count($recentAlerts) }} <span data-key="t-alerts" wire:ignore>alerts</span>
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
                                        <strong>{{ Str::limit($alert->primary_concern, 200) }}</strong>
                                    </div>
                                    <small class="text-muted">
                                        <span data-key="t-confidence" wire:ignore>Confidence</span>: {{ $alert->confidence }}
                                    </small>
                                </div>
                            @empty
                                <div class="list-group-item text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-bell-slash fa-2x mb-2"></i>
                                        <p><span data-key="t-no-ai-alerts-today" wire:ignore>No AI alerts today</span></p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('user.ai-threat-analysis') }}" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-external-link-alt me-1"></i> <span data-key="t-view-all-ai-analysis" wire:ignore>View All AI Analysis</span>
                        </a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-2"></i><span data-key="t-threat-trends" wire:ignore>Threat Trends (Last 7 Days)</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div wire:ignore id="threat-trends-chart" style="height: 300px;"></div>
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
                let chartsInitialized = false;
                let isRefreshing = false;
                let resizeDebounceTimer = null;

                function translate(key) {

                    const element = document.querySelector(`[data-key="${key}"]`);
                    if (element) {
                        return element.textContent || key;
                    }

                    const chartTranslations = {
                        't-total-aircraft': 'Total Aircraft',
                        't-military-aircraft': 'Military Aircraft',
                        't-aircraft-count': 'Aircraft Count',
                        't-level': 'Level',
                        't-total-alerts': 'Total Alerts',
                        't-avg-anomaly-score': 'Avg Anomaly Score',
                        't-high-risk-incidents': 'High Risk Incidents',
                        't-composite-score': 'Composite Score',
                        't-date': 'Date',
                        't-anomaly-score': 'Anomaly Score',
                        't-aircraft': 'aircraft',
                        't-updated': 'Updated',
                        't-hour': 'hour',
                        't-alerts': 'alerts',
                        't-no-activity-data': 'No activity data available',
                        't-no-threat-data': 'No threat data available',
                        't-no-trend-data': 'No trend data available',
                        't-data-will-appear': 'Data will appear when available',
                        't-data-may-be-stale': 'Data may be stale',
                        't-check-aircraft-transmitted': 'Check if aircraft have transmitted position data recently.',
                        't-no-active-aircraft-last-hour': 'No active aircraft in the last hour',
                        't-no-ai-alerts-today': 'No AI alerts today',
                        't-confidence': 'Confidence',
                        't-view-all-ai-analysis': 'View All AI Analysis',
                        't-recent-ai-alerts': 'Recent AI Alerts',
                        't-todays-activity': 'Today\'s Activity',
                        't-threat-level-distribution': 'Threat Level Distribution',
                        't-military-vs-civil': 'Military vs Civil',
                        't-aircraft-types': 'Aircraft Types',
                        't-threat-trends': 'Threat Trends (Last 7 Days)',
                        't-chart-will-populate': 'Chart will populate when aircraft are active',
                        't-no-aircraft-data-available': 'No aircraft data available',
                        't-near-sensitive': 'Near Sensitive',
                        't-drones': 'Drones',
                        't-unknown': 'Unknown',
                        't-threat': 'Threat',
                        't-altitude': 'Altitude',
                        't-speed': 'Speed',
                        't-position': 'Position',
                        't-in-estonia': 'In Estonia',
                        't-civil': 'Civil',
                        't-military': 'Military',
                        't-drone': 'Drone',
                        't-nato': 'NATO',
                        't-active-aircraft': 'active aircraft'
                    };

                    return chartTranslations[key] || key;
                }

                function getChartTranslation(key) {
                    return translate(key);
                }

                function debounce(func, wait) {
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(resizeDebounceTimer);
                            func(...args);
                        };
                        clearTimeout(resizeDebounceTimer);
                        resizeDebounceTimer = setTimeout(later, wait);
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
                        }).addTo(dashboardMap).bindPopup(getChartTranslation('t-in-estonia') + ' Airspace');

                        isMapInitialized = true;

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
                            try {
                                chart.destroy();
                            } catch (e) {
                                console.warn('Error destroying chart:', e);
                            }
                        }
                    });
                    window.chartInstances = {};
                    chartsInitialized = false;
                }

                function updateDashboardMarkers(markersData) {

                    if (!isMapInitialized || !dashboardMap) {
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
                        if (Array.isArray(markersData)) {
                            markersArray = markersData;
                        } else if (markersData && typeof markersData === 'object') {
                            markersArray = markersData.markers || [];
                        }
                    } catch (e) {
                        console.error('Error parsing markers data:', e);
                        markersArray = [];
                    }

                    const now = new Date();
                    const recentAircraft = markersArray.filter(aircraft => {
                        if (!aircraft || !aircraft.position_time) return false;

                        try {
                            const positionTime = new Date(aircraft.position_time);
                            if (isNaN(positionTime.getTime())) return false;

                            const minutesAgo = (now - positionTime) / (1000 * 60);
                            return minutesAgo <= 60;
                        } catch (e) {
                            console.warn('Error processing aircraft time:', e);
                            return false;
                        }
                    });

                    const countElement = document.getElementById('map-aircraft-count');
                    if (countElement) {
                        countElement.textContent = `${recentAircraft.length} ${getChartTranslation('t-active-aircraft')}`;
                    }

                    const bounds = L.latLngBounds();

                    recentAircraft.forEach(aircraft => {
                        try {
                            if (!aircraft || typeof aircraft !== 'object') return;

                            const lat = parseFloat(aircraft.latitude);
                            const lng = parseFloat(aircraft.longitude);
                            const heading = parseFloat(aircraft.heading) || 0;

                            if (isNaN(lat) || isNaN(lng)) return;

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

                            if (aircraft.aircraft_threat >= 4) {
                                color = '#dc3545';
                            }

                            const positionTime = aircraft.position_time ? new Date(aircraft.position_time) : null;
                            let ageIndicator = '';
                            if (positionTime && !isNaN(positionTime.getTime())) {
                                const minutesAgo = Math.round((now - positionTime) / (1000 * 60));
                                if (minutesAgo > 30) {
                                    color = '#6c757d';
                                }
                                ageIndicator = `<br><small>${getChartTranslation('t-updated')}: ${minutesAgo} min ago</small>`;
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
                                title: `${aircraft.callsign || aircraft.hex || 'Unknown'}`
                            });

                            const popupContent = `
                    <div style="min-width: 200px;">
                        <strong>${aircraft.callsign || aircraft.hex || 'Unknown'}</strong><br>
                        <small>${aircraft.type || getChartTranslation('t-unknown')} - ${aircraft.country || getChartTranslation('t-unknown')}</small><br>
                        <hr>
                        <small>${getChartTranslation('t-threat')}: ${getChartTranslation('t-level')} ${aircraft.aircraft_threat || aircraft.threat_level || 1}</small><br>
                        <small>${getChartTranslation('t-altitude')}: ${aircraft.altitude ? Math.round(aircraft.altitude) : 'N/A'}m</small><br>
                        <small>${getChartTranslation('t-speed')}: ${aircraft.speed ? Math.round(aircraft.speed) : 'N/A'}km/h</small><br>
                        <small>${getChartTranslation('t-position')}: ${lat.toFixed(4)}, ${lng.toFixed(4)}</small>
                        ${ageIndicator}
                    </div>
                `;

                            marker.bindPopup(popupContent);
                            marker.addTo(dashboardMap);
                            mapMarkers.set(aircraft.hex || aircraft.callsign, marker);
                            bounds.extend([lat, lng]);

                        } catch (e) {
                            console.warn('Error creating marker for aircraft:', aircraft, e);
                        }
                    });

                    if (recentAircraft.length > 0 && bounds.isValid()) {
                        try {
                            dashboardMap.fitBounds(bounds.pad(0.1), {
                                padding: [50, 50],
                                maxZoom: 10,
                                animate: true
                            });
                        } catch (e) {
                            console.warn('Error fitting map bounds:', e);
                        }
                    } else if (recentAircraft.length === 0) {
                        dashboardMap.setView([59.42, 24.83], 8);
                    }
                }

                function setupAutoRefresh() {

                    if (refreshInterval) {
                        clearInterval(refreshInterval);
                        refreshInterval = null;
                    }

                    if (autoRefreshEnabled && !isRefreshing) {
                        refreshInterval = setInterval(() => {
                            if (!isRefreshing) {
                                isRefreshing = true;

                                try {

                                    if (window.Livewire) {
                                        @this.refreshDashboard();
                                    }
                                } catch (e) {
                                    isRefreshing = false;
                                }

                                setTimeout(() => {
                                    isRefreshing = false;
                                }, 5000);
                            }
                        }, 30000);
                    }
                }

                function initAircraftTypesChart() {
                    try {
                        const activeAircraft = @json($activeAircraft);
                        const typesElement = document.querySelector("#aircraft-types-chart");

                        if (!typesElement) return;

                        // Clear existing content
                        typesElement.innerHTML = '';

                        if (!activeAircraft || activeAircraft.length === 0) {
                            typesElement.innerHTML = `
                    <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                        <i class="fas fa-plane fa-2x mb-2"></i>
                        <p>${getChartTranslation('t-no-aircraft-data-available')}</p>
                    </div>
                `;
                            return;
                        }

                        const typeCounts = {};
                        activeAircraft.forEach(aircraft => {
                            const type = aircraft.type || getChartTranslation('t-unknown');
                            typeCounts[type] = (typeCounts[type] || 0) + 1;
                        });

                        const sortedTypes = Object.entries(typeCounts)
                            .sort((a, b) => b[1] - a[1])
                            .slice(0, 6);

                        const types = sortedTypes.map(item => item[0]);
                        const counts = sortedTypes.map(item => item[1]);

                        const chart = new ApexCharts(typesElement, {
                            series: counts,
                            chart: {
                                type: 'pie',
                                height: 200,
                                redrawOnParentResize: true
                            },
                            labels: types,
                            colors: ['#0d6efd', '#dc3545', '#fd7e14', '#20c997', '#6610f2', '#6f42c1'],
                            legend: {
                                show: true,
                                position: 'bottom',
                                fontSize: '12px'
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val) {
                                    return Math.round(val) + '%';
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(value) {
                                        return value + ' ' + getChartTranslation('t-aircraft');
                                    }
                                }
                            }
                        });

                        window.chartInstances.aircraftTypes = chart;
                        chart.render();

                    } catch (e) {
                        console.error('Error initializing aircraft types chart:', e);
                    }
                }

                function initCharts() {
                    if (chartsInitialized) return;

                    try {
                        cleanupCharts();

                        const todayData = @json($todayAnalyses);
                        const todayChartElement = document.querySelector("#today-activity-chart");

                        if (todayChartElement) {

                            todayChartElement.innerHTML = '';

                            if (todayData && todayData.length > 0) {

                                const hours = todayData.map(d => {
                                    const hour = parseInt(d.hour);
                                    return hour < 10 ? `0${hour}:00` : `${hour}:00`;
                                });

                                const aircraftCounts = todayData.map(d => parseFloat(d.avg_aircraft) || 0);
                                const militaryCounts = todayData.map(d => parseFloat(d.avg_military) || 0);

                                window.chartInstances.todayActivity = new ApexCharts(todayChartElement, {
                                    series: [
                                        {
                                            name: getChartTranslation('t-total-aircraft'),
                                            type: 'line',
                                            data: aircraftCounts
                                        },
                                        {
                                            name: getChartTranslation('t-military-aircraft'),
                                            type: 'line',
                                            data: militaryCounts
                                        }
                                    ],
                                    chart: {
                                        height: 200,
                                        type: 'line',
                                        toolbar: { show: false },
                                        animations: { enabled: true },
                                        redrawOnParentResize: true
                                    },
                                    colors: ['#0d6efd', '#dc3545'],
                                    stroke: {
                                        width: [3, 3],
                                        curve: 'smooth'
                                    },
                                    markers: { size: 4 },
                                    xaxis: {
                                        categories: hours,
                                        labels: {
                                            rotate: -45,
                                            style: {
                                                fontSize: '11px'
                                            }
                                        }
                                    },
                                    yaxis: {
                                        title: {
                                            text: getChartTranslation('t-aircraft-count'),
                                            style: {
                                                fontSize: '12px',
                                                fontWeight: 'normal'
                                            }
                                        },
                                        min: 0,
                                        forceNiceScale: true
                                    },
                                    legend: {
                                        show: true,
                                        position: 'top',
                                        fontSize: '12px'
                                    },
                                    tooltip: {
                                        shared: true,
                                        intersect: false,
                                        style: {
                                            fontSize: '12px'
                                        }
                                    },
                                    grid: {
                                        borderColor: '#f1f1f1',
                                        strokeDashArray: 4
                                    }
                                });
                                window.chartInstances.todayActivity.render();
                            } else {

                                todayChartElement.innerHTML = `
                        <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                            <p>${getChartTranslation('t-no-activity-data')}</p>
                            <small>${getChartTranslation('t-data-will-appear')}</small>
                        </div>
                    `;
                            }
                        }

                        const threatData = @json($aiAnalysis);
                        const threatChartElement = document.querySelector("#threat-distribution-chart");

                        if (threatChartElement) {
                            threatChartElement.innerHTML = '';

                            if (threatData && threatData.length > 0) {
                                const threatLevels = threatData.map(d => getChartTranslation('t-level') + ' ' + d.threat_level);
                                const threatCounts = threatData.map(d => parseInt(d.count) || 0);

                                window.chartInstances.threatDistribution = new ApexCharts(threatChartElement, {
                                    series: threatCounts,
                                    chart: {
                                        type: 'donut',
                                        height: 200,
                                        redrawOnParentResize: true
                                    },
                                    labels: threatLevels,
                                    colors: ['#198754', '#ffc107', '#fd7e14', '#dc3545', '#6610f2'],
                                    legend: {
                                        show: true,
                                        position: 'bottom',
                                        fontSize: '12px'
                                    },
                                    plotOptions: {
                                        pie: {
                                            donut: {
                                                size: '60%',
                                                labels: {
                                                    show: true,
                                                    total: {
                                                        show: true,
                                                        label: getChartTranslation('t-total-alerts'),
                                                        color: '#6c757d',
                                                        fontSize: '12px'
                                                    }
                                                }
                                            }
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    tooltip: {
                                        style: {
                                            fontSize: '12px'
                                        },
                                        y: {
                                            formatter: function(value) {
                                                return value + ' ' + getChartTranslation('t-alerts');
                                            }
                                        }
                                    }
                                });
                                window.chartInstances.threatDistribution.render();
                            } else {
                                threatChartElement.innerHTML = `
                        <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <p>${getChartTranslation('t-no-threat-data')}</p>
                            <small>${getChartTranslation('t-data-will-appear')}</small>
                        </div>
                    `;
                            }
                        }

                        const activeAircraft = @json($activeAircraft);
                        const militaryCivilElement = document.querySelector("#military-civil-chart");

                        if (militaryCivilElement) {
                            militaryCivilElement.innerHTML = '';

                            if (activeAircraft && activeAircraft.length > 0) {
                                const militaryCount = activeAircraft.filter(a => a.is_military).length;
                                const civilCount = activeAircraft.length - militaryCount;
                                const droneCount = activeAircraft.filter(a => a.is_drone).length;
                                const natoCount = activeAircraft.filter(a => a.is_nato).length;

                                window.chartInstances.militaryCivil = new ApexCharts(militaryCivilElement, {
                                    series: [{
                                        data: [
                                            { x: getChartTranslation('t-military'), y: militaryCount },
                                            { x: getChartTranslation('t-civil'), y: civilCount },
                                            { x: getChartTranslation('t-drones'), y: droneCount },
                                            { x: getChartTranslation('t-nato'), y: natoCount }
                                        ]
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 200,
                                        toolbar: { show: false },
                                        redrawOnParentResize: true
                                    },
                                    colors: ['#dc3545', '#0d6efd', '#fd7e14', '#0dcaf0'],
                                    plotOptions: {
                                        bar: {
                                            horizontal: true,
                                            borderRadius: 4,
                                            distributed: true,
                                            columnWidth: '70%'
                                        }
                                    },
                                    dataLabels: {
                                        enabled: true,
                                        formatter: function(val) {
                                            return val;
                                        },
                                        style: {
                                            fontSize: '12px',
                                            fontWeight: 'normal'
                                        }
                                    },
                                    xaxis: {
                                        categories: [
                                            getChartTranslation('t-military'),
                                            getChartTranslation('t-civil'),
                                            getChartTranslation('t-drone'),
                                            getChartTranslation('t-nato')
                                        ],
                                        labels: {
                                            style: {
                                                fontSize: '12px'
                                            }
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            style: {
                                                fontSize: '12px'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        y: {
                                            formatter: function(value) {
                                                return value + ' ' + getChartTranslation('t-aircraft');
                                            }
                                        }
                                    },
                                    grid: {
                                        borderColor: '#f1f1f1',
                                        strokeDashArray: 4
                                    }
                                });
                                window.chartInstances.militaryCivil.render();
                            } else {
                                militaryCivilElement.innerHTML = `
                        <div class="text-center text-muted" style="height: 200px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <p>${getChartTranslation('t-no-aircraft-data-available')}</p>
                            <small>${getChartTranslation('t-chart-will-populate')}</small>
                        </div>
                    `;
                            }
                        }

                        initAircraftTypesChart();

                        const trendsData = @json($threatTrends);
                        const trendsElement = document.querySelector("#threat-trends-chart");

                        if (trendsElement) {
                            trendsElement.innerHTML = '';

                            if (trendsData && trendsData.length > 0) {
                                const dates = trendsData.map(d => {
                                    try {
                                        const date = new Date(d.date);
                                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                                    } catch (e) {
                                        return d.date;
                                    }
                                });

                                const anomalyScores = trendsData.map(d => parseFloat(d.avg_anomaly) || 0);
                                const highRiskDays = trendsData.map(d => parseInt(d.high_risk_count) || 0);
                                const compositeScores = trendsData.map(d => parseFloat(d.avg_composite) || 0);

                                window.chartInstances.threatTrends = new ApexCharts(trendsElement, {
                                    series: [
                                        {
                                            name: getChartTranslation('t-avg-anomaly-score'),
                                            type: 'line',
                                            data: anomalyScores
                                        },
                                        {
                                            name: getChartTranslation('t-high-risk-incidents'),
                                            type: 'column',
                                            data: highRiskDays
                                        },
                                        {
                                            name: getChartTranslation('t-composite-score'),
                                            type: 'line',
                                            data: compositeScores
                                        }
                                    ],
                                    chart: {
                                        height: 300,
                                        type: 'line',
                                        toolbar: { show: true },
                                        redrawOnParentResize: true
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
                                        title: {
                                            text: getChartTranslation('t-date'),
                                            style: {
                                                fontSize: '12px'
                                            }
                                        },
                                        labels: {
                                            style: {
                                                fontSize: '11px'
                                            }
                                        }
                                    },
                                    yaxis: [
                                        {
                                            title: {
                                                text: getChartTranslation('t-anomaly-score'),
                                                style: {
                                                    color: '#dc3545',
                                                    fontSize: '12px'
                                                }
                                            },
                                            min: 0,
                                            max: 100,
                                            labels: {
                                                style: {
                                                    fontSize: '11px'
                                                }
                                            }
                                        },
                                        {
                                            opposite: true,
                                            title: {
                                                text: getChartTranslation('t-high-risk-incidents'),
                                                style: {
                                                    color: '#0d6efd',
                                                    fontSize: '12px'
                                                }
                                            },
                                            labels: {
                                                style: {
                                                    fontSize: '11px'
                                                }
                                            }
                                        }
                                    ],
                                    tooltip: {
                                        shared: true,
                                        intersect: false,
                                        style: {
                                            fontSize: '12px'
                                        }
                                    },
                                    legend: {
                                        show: true,
                                        position: 'top',
                                        fontSize: '12px'
                                    },
                                    grid: {
                                        borderColor: '#f1f1f1',
                                        strokeDashArray: 4
                                    }
                                });
                                window.chartInstances.threatTrends.render();
                            } else {
                                trendsElement.innerHTML = `
                        <div class="text-center text-muted" style="height: 300px; display: flex; flex-direction: column; justify-content: center;">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <p>${getChartTranslation('t-no-trend-data')}</p>
                            <small>${getChartTranslation('t-data-will-appear')}</small>
                        </div>
                    `;
                            }
                        }

                        chartsInitialized = true;

                    } catch (e) {
                        console.error('Error initializing charts:', e);
                        chartsInitialized = false;
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {

                    setTimeout(initDashboardMap, 100);

                    requestAnimationFrame(() => {
                        setTimeout(initCharts, 300);
                    });

                    setupAutoRefresh();

                    const toggle = document.getElementById('autoRefreshToggle');
                    if (toggle) {
                        toggle.checked = autoRefreshEnabled;
                    }
                });

                document.addEventListener('livewire:initialized', () => {

                    Livewire.on('dashboard-data-loaded', (event) => {

                        try {
                            const markersData = event.detail && event.detail[0] ? event.detail[0] : event;
                            updateDashboardMarkers(markersData);

                            chartsInitialized = false;
                            requestAnimationFrame(() => {
                                setTimeout(initCharts, 100);
                            });

                            isRefreshing = false;
                        } catch (e) {
                            console.error('Error processing dashboard data:', e);
                            isRefreshing = false;
                        }
                    });

                    Livewire.on('auto-refresh-toggled', (event) => {

                        let enabled = event;
                        if (typeof event === 'object' && event.detail) {
                            enabled = event.detail[0] ? event.detail[0].enabled : event.enabled;
                        }

                        autoRefreshEnabled = enabled;

                        const toggle = document.getElementById('autoRefreshToggle');
                        if (toggle) {
                            toggle.checked = autoRefreshEnabled;
                        }

                        setupAutoRefresh();

                        chartsInitialized = false;
                        requestAnimationFrame(() => {
                            setTimeout(initCharts, 100);
                        });
                    });

                    Livewire.hook('message.processed', (message) => {
                        if (!chartsInitialized) {
                            requestAnimationFrame(() => {
                                setTimeout(initCharts, 150);
                            });
                        }
                    });
                });

                window.addEventListener('resize', debounce(() => {
                    if (dashboardMap) {
                        setTimeout(() => {
                            try {
                                dashboardMap.invalidateSize();
                            } catch (e) {
                                console.warn('Error invalidating map size:', e);
                            }
                        }, 100);
                    }

                    chartsInitialized = false;
                    requestAnimationFrame(() => {
                        setTimeout(initCharts, 200);
                    });
                }, 250));

                window.addEventListener('beforeunload', () => {
                    cleanupCharts();

                    if (refreshInterval) {
                        clearInterval(refreshInterval);
                        refreshInterval = null;
                    }

                    if (dashboardMap) {
                        try {
                            dashboardMap.remove();
                        } catch (e) {
                            console.warn('Error removing map:', e);
                        }
                    }
                });

                window.manualRefresh = function() {
                    if (!isRefreshing && window.Livewire) {
                        isRefreshing = true;
                        @this.refreshDashboard();
                        setTimeout(() => { isRefreshing = false; }, 5000);
                    }
                };
            </script>
        @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('user/assets/css/pages/dashboard.css') }}" />
    @endpush
</div>
