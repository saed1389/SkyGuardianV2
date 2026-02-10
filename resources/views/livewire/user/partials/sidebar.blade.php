<div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Mission Control</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.dashboard') }}">
                        <i class="fas fa-dashboard"></i> <span data-key="t-dashboards" class="ms-2">Command Center</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-operations">Operations</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.live-map') }}">
                        <i class="fas fa-map-marked-alt"></i> <span data-key="t-live-map" class="ms-2">Live Tactical Map</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.military-monitor') }}">
                        <i class="fas fa-fighter-jet"></i> <span data-key="t-military-monitoring" class="ms-2">Military Monitor</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-intel">Intelligence (C4ISR)</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarIntel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarIntel">
                        <i class="fas fa-brain"></i> <span data-key="t-intel-analysis" class="ms-2">AI & Analysis</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarIntel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('user.ai-threat-analysis') }}" class="nav-link" data-key="t-ai-threat">AI Threat Assessment</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.nato-reports') }}" class="nav-link">
                                    <span data-key="t-nato-salute">SALUTE Reports</span> &nbsp;<span class="text-success float-end">NATO </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.analysis-history') }}" class="nav-link" data-key="t-history">Archive & History</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.aircraft-database') }}">
                        <i class="fas fa-database"></i> <span data-key="t-aircraft-db" class="ms-2">Target Database</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-infra">Infrastructure</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSystem" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSystem">
                        <i class="fas fa-server"></i> <span data-key="t-system" class="ms-2">System Health</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSystem">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('user.sensor-status') }}" class="nav-link" data-key="t-sensors">Sensor Network (RF)</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.system-logs') }}" class="nav-link" data-key="t-system-logs">System Logs</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-settings">Configuration</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.members-list') }}">
                        <i class="fas fa-users-cog"></i> <span data-key="t-members" class="ms-2">Personnel</span>
                    </a>
                </li>

                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a class="nav-link menu-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> <span data-key="t-logout" class="ms-2">Abort Session</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer p-3 bg-soft-success m-3 rounded">
                <div class="d-flex align-items-center gap-2">
                    <span class="position-relative d-flex h-10 w-10">
                      <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle animate-ping"></span>
                      <span class="position-relative inline-flex rounded-circle h-3 w-3 bg-success p-1"></span>
                    </span>
                    <div>
                        <h6 class="mb-0 fs-12 text-uppercase text-success" data-key="t-system-online">System Online</h6>
                        <span class="fs-10 text-muted"><span data-key="t-latency">Latency</span>: 24ms</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
