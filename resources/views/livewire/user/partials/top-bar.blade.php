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
                                            <small class="text-muted" ><span data-i18n="t-feels-like" wire:ignore>Feels like</span>: {{ round($weather->feels_like) }}°C</small>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class='bx bx-wind text-primary fs-18'></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <p class="mb-0 fs-12" data-i18n="t-wind" wire:ignore>Wind</p>
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
                                                    <p class="mb-0 fs-12" data-i18n="t-humidity" wire:ignore>Humidity</p>
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
                                                    <p class="mb-0 fs-12" data-i18n="t-pressure" wire:ignore>Pressure</p>
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
                                                    <p class="mb-0 fs-12" data-i18n="t-visibility" wire:ignore>Visibility</p>
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
                                                    <small class="text-muted" data-i18n="t-sunrise" wire:ignore>Sunrise</small>
                                                    <p class="mb-0 fs-12">
                                                        {{ $this->getFormattedSunrise() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <i class='bx bx-sunset text-orange fs-18 d-block mb-1'></i>
                                                    <small class="text-muted" data-i18n="t-sunset" wire:ignore>Sunset</small>
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
                                        <span data-key="t-updated" wire:ignore>Updated</span>: {{ $this->getLastUpdated() }}
                                    </small>
                                </div>
                            </div>
                        @else
                            <div class="dropdown-menu dropdown-menu-end p-0" wire:ignore.self>
                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">
                                            <i class='bx bx-cloud me-1'></i>
                                            <span data-i18n="t-weather-data" wire:ignore>Weather Data</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="dropdown-body p-4 text-center">
                                    <i class='bx bx-cloud-off fs-48 text-muted mb-3'></i>
                                    <p class="text-muted mb-0" data-i18n="t-no-weather-data" wire:ignore>No weather data available</p>
                                    <small class="text-muted" data-i18n="t-check-back-later" wire:ignore>Check back later or try refreshing</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown ms-1 topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img id="header-lang-img" src="{{ $this->getFlagImage() }}" alt="Header Language" height="20" class="rounded" wire:ignore>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" onclick="switchLanguage('en')" title="English">
                                <img src="{{ asset('user/assets/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="18" wire:ignore>
                                <span class="align-middle">English</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" onclick="switchLanguage('ee')" title="Estonian">
                                <img src="{{ asset('user/assets/images/flags/estonia.svg') }}" alt="user-image" class="me-2 rounded" height="18" width="18" wire:ignore>
                                <span class="align-middle">Estonian</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item language" onclick="switchLanguage('tr')" title="Turkish">
                                <img src="{{ asset('user/assets/images/flags/tr.svg') }}" alt="user-image" class="me-2 rounded" height="18" wire:ignore>
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

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" src="{{ asset('user/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{!! Auth::user()->admin_id == 0 ? "<span data-key='t-founder' wire:ignore>Founder</span>" : "<span data-key='w-member' wire:ignore>Member</span>" !!}</span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header"><span data-i18n="t-welcome">Welcome</span>, {{ Auth::user()->name }}!</h6>
                            <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-i18n="t-profile">Profile</span></a>
                            <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-i18n="t-messages">Messages</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="pages-profile-settings.html"><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-i18n="t-settings">Settings</span></a>
                            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-i18n="t-lock-screen">Lock screen</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-i18n="t-logout">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

@push('scripts')
    <script>
        let currentTranslations = null;
        let currentLocale = '{{ app()->getLocale() }}';

        function switchLanguage(lang) {

            const flagMap = {
                'en': '{{ asset("user/assets/images/flags/us.svg") }}',
                'tr': '{{ asset("user/assets/images/flags/tr.svg") }}',
                'ee': '{{ asset("user/assets/images/flags/estonia.svg") }}'
            };

            const langImg = document.getElementById('header-lang-img');
            const originalSrc = langImg.src;

            if (flagMap[lang]) {
                langImg.src = flagMap[lang];
            }

            localStorage.setItem('user_locale', lang);
            currentLocale = lang;

            const formData = new FormData();
            formData.append('lang', lang);

            fetch('/switch-language', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {

                    if (data.success) {
                        const dropdownBtn = document.querySelector('.header-item [data-bs-toggle="dropdown"]');
                        if (dropdownBtn) {
                            const bsDropdown = bootstrap.Dropdown.getInstance(dropdownBtn);
                            if (bsDropdown) bsDropdown.hide();
                        }

                        showToast('t-language-changed', 'success', {
                            language: lang === 'en' ? 'English' :
                                lang === 'tr' ? 'Turkish' :
                                    'Estonian'
                        });

                        loadTranslations(lang);

                        window.dispatchEvent(new CustomEvent('language-changed', {
                            detail: { locale: lang }
                        }));

                    } else {
                        langImg.src = originalSrc;
                        localStorage.setItem('user_locale', currentLocale);
                        showToast(data.message || 'Failed to change language', 'error');
                    }
                })
                .catch(error => {
                    langImg.src = originalSrc;
                    localStorage.setItem('user_locale', currentLocale);
                    showToast('An error occurred. Please try again.', 'error');
                });
        }

        function refreshDropdownTranslations() {
            if (!currentTranslations) return;

            document.querySelectorAll('.dropdown-menu.show').forEach(dropdown => {

                dropdown.querySelectorAll('[data-i18n]').forEach(element => {
                    const key = element.getAttribute('data-i18n');
                    const translation = getNestedProperty(currentTranslations, key);
                    if (translation) {
                        element.textContent = translation;
                    }
                });

                dropdown.querySelectorAll('[data-key]').forEach(element => {
                    const key = element.getAttribute('data-key');
                    const translation = getNestedProperty(currentTranslations, key);
                    if (translation) {
                        element.textContent = translation;
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.addEventListener('shown.bs.dropdown', function() {
                    setTimeout(() => {
                        refreshDropdownTranslations();
                    }, 10);
                });
            });

            window.addEventListener('language-changed', function() {
                setTimeout(() => {
                    refreshDropdownTranslations();
                }, 100);
            });
        });

        function loadTranslations(lang) {
            const translationPath = `/user/assets/lang/${lang}.json`;

            fetch(translationPath)
                .then(response => {
                    if (!response.ok) {
                        const altPath = `/assets/lang/${lang}.json`;
                        return fetch(altPath);
                    }
                    return response;
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Failed to load translations: ${response.status}`);
                    }
                    return response.json();
                })
                .then(translations => {
                    currentTranslations = translations;
                    applyTranslations(translations);
                })
                .catch(error => {
                    if (lang !== 'en') {
                        loadTranslations('en');
                    }
                });
        }

        function applyTranslations(translations) {

            document.querySelectorAll('[data-i18n]').forEach(element => {
                const key = element.getAttribute('data-i18n');
                const translation = getNestedProperty(translations, key);
                if (translation) {
                    if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                        element.placeholder = translation;
                    } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.value = translation;
                    } else {
                        element.textContent = translation;
                    }
                }
            });

            document.querySelectorAll('[data-key]').forEach(element => {
                const key = element.getAttribute('data-key');
                const translation = getNestedProperty(translations, key);
                if (translation) {
                    element.textContent = translation;
                }
            });

            document.querySelectorAll('[data-i18n-title]').forEach(element => {
                const key = element.getAttribute('data-i18n-title');
                const translation = getNestedProperty(translations, key);
                if (translation) {
                    element.setAttribute('title', translation);
                }
            });

            document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
                const key = element.getAttribute('data-i18n-placeholder');
                const translation = getNestedProperty(translations, key);
                if (translation) {
                    element.setAttribute('placeholder', translation);
                }
            });

            refreshDropdownTranslations();
        }


        function getNestedProperty(obj, path) {
            return path.split('.').reduce((current, key) => {
                return current && current[key] !== undefined ? current[key] : null;
            }, obj);
        }

        function showToast(keyOrMessage, type = 'info', params = {}) {

            let message = keyOrMessage;

            if (keyOrMessage.startsWith('t-') && currentTranslations) {
                const translation = getNestedProperty(currentTranslations, keyOrMessage);
                if (translation) {
                    message = translation;

                    Object.keys(params).forEach(paramKey => {
                        const placeholder = `{${paramKey}}`;
                        if (message.includes(placeholder)) {
                            message = message.replace(new RegExp(placeholder, 'g'), params[paramKey]);
                        }
                    });
                } else {

                    const fallbackMessages = {
                        't-an-error-occurred': 'An error occurred. Please try again.',
                        't-language-changed': 'Language changed to {language}',
                        't-failed-to-change-language': 'Failed to change language',
                        't-network-error': 'Network error. Please try again.',
                        't-translations-loaded': 'Translations loaded successfully',
                        't-weather-updated': 'Weather data updated',
                        't-profile-updated': 'Profile updated successfully',
                        't-settings-saved': 'Settings saved successfully'
                    };
                    message = fallbackMessages[keyOrMessage] || keyOrMessage;
                }
            }

            document.querySelectorAll('.locale-toast').forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show position-fixed locale-toast`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;';
            toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class='bx ${type === 'success' ? 'bx-check-circle text-success me-2' :
                type === 'error' || type === 'danger' ? 'bx-error text-danger me-2' :
                    type === 'warning' ? 'bx-error text-warning me-2' :
                        'bx-info-circle text-info me-2'}'></i>
            <span class="flex-grow-1">${message}</span>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
        </div>
    `;
            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }

        function reapplyTranslations() {
            if (currentTranslations) {
                applyTranslations(currentTranslations);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            const savedLocale = localStorage.getItem('user_locale');
            const serverLocale = '{{ app()->getLocale() }}';

            const localeToUse = savedLocale || serverLocale;

            if (savedLocale && savedLocale !== serverLocale) {

                const flagMap = {
                    'en': '{{ asset("user/assets/images/flags/us.svg") }}',
                    'tr': '{{ asset("user/assets/images/flags/tr.svg") }}',
                    'ee': '{{ asset("user/assets/images/flags/estonia.svg") }}'
                };

                const langImg = document.getElementById('header-lang-img');
                if (langImg && flagMap[savedLocale]) {
                    langImg.src = flagMap[savedLocale];
                }
            }

            loadTranslations(localeToUse);

            setTimeout(() => {
                if (currentTranslations) {
                    applyTranslations(currentTranslations);
                }
            }, 100);

            document.addEventListener('livewire:update', function() {
                setTimeout(() => {
                    reapplyTranslations();
                }, 50);
            });

            document.addEventListener('livewire:element-updated', function(event) {
                setTimeout(() => {
                    reapplyTranslations();
                }, 50);
            });
        });

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
    </script>
@endpush

@push('styles')
    <link href="{{ asset('user/assets/css/pages/top-bar.css') }}" rel="stylesheet" type="text/css" />
@endpush
