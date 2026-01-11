<div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('user.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-system">System</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSystem" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-mini-program-fill"></i> <span data-key="t-system">System</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSystem">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('user.live-map') }}" class="nav-link" data-key="t-live-map">Live Map </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.ai-threat-analysis') }}" class="nav-link" data-key="t-ai-threat-analysis">AI Threat Analysis</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.analysis-history') }}" class="nav-link" data-key="t-analysis-history">Analysis History </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.military-monitor') }}" class="nav-link" data-key="t-military-monitoring">Military Monitoring </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.aircraft-database') }}" class="nav-link" data-key="t-aircraft-database">Aircraft Database </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.system-logs') }}" class="nav-link" data-key="t-system-logs">System Logs </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.reports') }}" class="nav-link" data-key="t-reports">Reports </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-settings">Settings</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUser" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-members">Members</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUser">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('user.members-list') }}" class="nav-link" data-key="t-member-list"> Member List </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Components</span></li>

                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a class="nav-link menu-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-logout-box-fill"></i> <span data-key="t-logout">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
