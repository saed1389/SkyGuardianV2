<div wire:poll.1800s="loadWeather" wire:ignore.self>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="{{ route('user.dashboard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('user/assets/images/logo-sm.png') }}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('user/assets/images/logo-dark.png') }}" alt="" height="50">
                            </span>
                        </a>

                        <a href="{{ route('user.dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('user/assets/images/logo-sm.png') }}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('user/assets/images/logo-light.png') }}" alt="" height="50">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>

                </div>
                <div class="app-search d-none d-md-block">
                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="weatherDropdown">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:click="refreshWeather" onclick="event.stopPropagation()" wire:loading.attr="disabled">

                            @if($weather)
                                <div wire:loading.remove wire:target="refreshWeather">
                                    <i class='bx {{ $this->getWeatherIcon() }} fs-22 {{ $this->getWeatherIconClass() }}'></i>
                                    <span class="ms-1 fw-medium">{{ round($weather->temperature) }}°C</span>
                                </div>

                                <div wire:loading wire:target="refreshWeather">
                                    <i class='bx bx-refresh fs-22 animate-spin text-primary'></i>
                                </div>
                            @else
                                <div>
                                    <i class='bx bx-cloud fs-22 text-secondary'></i>
                                    <span class="ms-1 fw-medium">--°C</span>
                                </div>
                            @endif
                        </button>

                        @if($weather)
                            <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="weatherDropdown" wire:ignore.self>
                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="m-0 fs-16 fw-semibold text-white">
                                                <i class='bx bx-map-pin me-1'></i>
                                                {{ $weather->location_name }}, {{ $weather->country_code }}
                                            </h6>
                                            <button type="button" class="btn btn-ghost-light btn-sm p-0" wire:click="refreshWeather" wire:loading.attr="disabled" onclick="event.stopPropagation()" title="Refresh weather">
                                                <i class='bx bx-refresh fs-16' wire:loading.remove wire:target="refreshWeather"></i>
                                                <i class='bx bx-loader bx-spin fs-16' wire:loading wire:target="refreshWeather"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-body p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            @if($weather->weather_icon)
                                                <img src="https://openweathermap.org/img/wn/{{ $weather->weather_icon }}@2x.png" alt="{{ $weather->weather_description }}" width="60" height="60">
                                            @else
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle fs-24">
                                                        <i class='bx {{ $this->getWeatherIcon() }}'></i>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h3 class="mb-0">{{ round($weather->temperature) }}°C</h3>
                                            <p class="text-muted mb-0 text-capitalize">{{ $weather->weather_description }}</p>
                                            <small class="text-muted">Feels like: {{ round($weather->feels_like) }}°C</small>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class='bx bx-wind text-primary fs-18'></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <p class="mb-0 fs-12">Wind</p>
                                                    <h6 class="mb-0 fs-14">{{ $weather->wind_speed }} m/s</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class='bx bx-droplet text-info fs-18'></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <p class="mb-0 fs-12">Humidity</p>
                                                    <h6 class="mb-0 fs-14">{{ $weather->humidity }}%</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class='bx bx-bar-chart-alt text-success fs-18'></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <p class="mb-0 fs-12">Pressure</p>
                                                    <h6 class="mb-0 fs-14">{{ $weather->pressure }} hPa</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class='bx bx-show text-warning fs-18'></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <p class="mb-0 fs-12">Visibility</p>
                                                    <h6 class="mb-0 fs-14">{{ $this->getFormattedVisibility() }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <i class='bx bx-sunrise text-warning fs-18 d-block mb-1'></i>
                                                    <small class="text-muted">Sunrise</small>
                                                    <p class="mb-0 fs-12">
                                                        {{ $this->getFormattedSunrise() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <i class='bx bx-sunset text-orange fs-18 d-block mb-1'></i>
                                                    <small class="text-muted">Sunset</small>
                                                    <p class="mb-0 fs-12">
                                                        {{ $this->getFormattedSunset() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-footer p-2 text-center border-top">
                                    <small class="text-muted">
                                        Updated: {{ $this->getLastUpdated() }}
                                    </small>
                                </div>
                            </div>
                        @else
                            <div class="dropdown-menu dropdown-menu-end p-0" wire:ignore.self>
                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">
                                            <i class='bx bx-cloud me-1'></i>
                                            Weather Data
                                        </h6>
                                    </div>
                                </div>
                                <div class="dropdown-body p-4 text-center">
                                    <i class='bx bx-cloud-off fs-48 text-muted mb-3'></i>
                                    <p class="text-muted mb-0">No weather data available</p>
                                    <small class="text-muted">Check back later or try refreshing</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown ms-1 topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img id="header-lang-img" src="{{ asset('user/assets/images/flags/us.svg') }}" alt="Header Language" height="20" class="rounded">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                                <img src="{{ asset('user/assets/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                <span class="align-middle">English</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Estonian">
                                <img src="{{ asset('user/assets/images/flags/estonia.svg') }}" alt="user-image" class="me-2 rounded" height="18" width="18">
                                <span class="align-middle">Estonian</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Turkish">
                                <img src="{{ asset('user/assets/images/flags/tr.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                <span class="align-middle">Turkish</span>
                            </a>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                            <i class='bx bx-moon fs-22'></i>
                        </button>
                    </div>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> 4 New</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                                            Alerts
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <a href="#" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author Graphic
                                                        Optimization <span class="text-secondary">reward</span> is
                                                        ready!
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                    <label class="form-check-label" for="all-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                            All Notifications <i class="ri-arrow-right-line align-middle"></i></button>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">
                                            <img src="{{ asset('user/assets/images/users/avatar-3.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <a href="#" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">We talked about a project on linkedin.</p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 30 min ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                                    <label class="form-check-label" for="messages-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">
                                            <img src="{{ asset('user/assets/images/users/avatar-2.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <a href="#" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">Answered to your comment on the cash flow forecast's
                                                        graph 🔔.</p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="messages-notification-check02">
                                                    <label class="form-check-label" for="messages-notification-check02"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">
                                            <img src="{{ asset('user/assets/images/users/avatar-6.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <a href="#" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">Kenneth Brown</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">Mentionned you in his comment on 📃 invoice #12501.
                                                    </p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 10 hrs ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="messages-notification-check03">
                                                    <label class="form-check-label" for="messages-notification-check03"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">
                                            <img src="{{ asset('user/assets/images/users/avatar-8.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <a href="#" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">We talked about a project on linkedin.</p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 3 days ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="messages-notification-check04">
                                                    <label class="form-check-label" for="messages-notification-check04"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                            All Messages <i class="ri-arrow-right-line align-middle"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab"></div>

                            <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center">
                                    Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ asset('user/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                            <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                            <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const weatherDropdown = document.querySelector('#weatherDropdown .dropdown-menu');

            if (weatherDropdown) {
                weatherDropdown.style.inset = 'unset';
                weatherDropdown.style.width = '240px';
                weatherDropdown.style.left = 'auto';
                weatherDropdown.style.right = '0';
                weatherDropdown.style.top = '100%';
                weatherDropdown.style.transform = 'translateY(10px)';
                weatherDropdown.classList.add('weather-dropdown-fixed');
            }
        });
        document.addEventListener('livewire:init', () => {
            Livewire.hook('request', ({ fail }) => {
                fail(() => {
                    setTimeout(() => {
                        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
                        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                            return new bootstrap.Dropdown(dropdownToggleEl)
                        })
                    }, 100);
                });
            });
        });
    </script>
@endpush
@push('styles')
    <style>
        .text-orange {
            color: #fd7e14 !important;
        }

        #weatherDropdown .dropdown-body {
            min-width: 280px;
        }

        #weatherDropdown{
            inset: unset;
        }

        #weatherDropdown .avatar-title {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
@endpush
