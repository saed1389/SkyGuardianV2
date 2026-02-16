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

                <div class="d-flex align-items-center">

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="modal" data-bs-target="#weatherModal" wire:click="refreshWeather" title="Meteorological Intelligence">
                            @if($weather)
                                <div wire:loading.remove wire:target="refreshWeather">
                                    <i class='bx {{ $this->getWeatherIcon() }} fs-22 {{ $this->getWeatherIconClass() }}'></i>
                                </div>
                                <div wire:loading wire:target="refreshWeather">
                                    <i class='bx bx-refresh fs-22 animate-spin text-primary'></i>
                                </div>
                            @else
                                <div>
                                    <i class='bx bx-cloud fs-22 text-secondary'></i>
                                </div>
                            @endif
                        </button>
                    </div>

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
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                        {!! Auth::user()->admin_id == 0 ? "<span data-key='t-founder' wire:ignore>Commander</span>" : "<span data-key='w-member' wire:ignore>Officer</span>" !!}
                                    </span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header"><span data-i18n="t-welcome">Welcome</span>, {{ Auth::user()->name }}!</h6>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-i18n="t-logout">Abort Session</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="modal fade" id="weatherModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="background: #1a1d21; color: #fff;">

                <div class="modal-header bg-soft-primary border-bottom border-secondary border-opacity-25">
                    <h5 class="modal-title text-primary mb-3" id="myModalLabel">
                        <i class="fas fa-satellite-dish me-2"></i><span class="text-white">METINT REPORT</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white mb-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if($weather)
                        <div class="text-center mb-4">
                            <h2 class="text-uppercase fw-bold mb-0 text-white">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $weather->location_name }} SECTOR
                            </h2>
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                @if($weather->weather_icon)
                                    <img src="https://openweathermap.org/img/wn/{{ $weather->weather_icon }}@4x.png" alt="Weather" width="100">
                                @else
                                    <i class='bx {{ $this->getWeatherIcon() }} display-1 {{ $this->getWeatherIconClass() }}'></i>
                                @endif
                                <div class="text-start ms-3">
                                    <h1 class="display-4 fw-bold mb-0">{{ round($weather->temperature) }}°C</h1>
                                    <p class="text-muted text-uppercase fw-medium mb-0">{{ $weather->weather_description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 border border-secondary border-opacity-25 rounded bg-soft-dark">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-wind text-info fs-18 me-2"></i>
                                        <span class="text-muted text-uppercase fs-11" data-i18n="t-wind">Wind</span>
                                    </div>
                                    <h5 class="mb-0">{{ $weather->wind_speed }} m/s</h5>
                                    <small class="text-muted" data-i18n="t-direction">Direction: {{ $weather->wind_degree }}°</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border border-secondary border-opacity-25 rounded bg-soft-dark">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-eye text-warning fs-18 me-2"></i>
                                        <span class="text-muted text-uppercase fs-11" data-i18n="t-visibility">Visibility</span>
                                    </div>
                                    <h5 class="mb-0">{{ $this->getFormattedVisibility() }}</h5>
                                    <small class="text-muted" data-i18n="t-operational-range">Operational Range</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border border-secondary border-opacity-25 rounded bg-soft-dark">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-tachometer-alt text-success fs-18 me-2"></i>
                                        <span class="text-muted text-uppercase fs-11" data-i18n="t-pressure">Pressure (QNH)</span>
                                    </div>
                                    <h5 class="mb-0">{{ $weather->pressure }} hPa</h5>
                                    <small class="text-muted" data-i18n="t-sea_level">Sea Level</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border border-secondary border-opacity-25 rounded bg-soft-dark">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-tint text-primary fs-18 me-2"></i>
                                        <span class="text-muted text-uppercase fs-11" data-i18n="t-humidity">Humidity</span>
                                    </div>
                                    <h5 class="mb-0">{{ $weather->humidity }}%</h5>
                                    <small class="text-muted" data-i18n="t-dew_point_factor">Dew Point Factor</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 pt-3 border-top border-secondary border-opacity-25">
                            <div class="col-6 text-center border-end border-secondary border-opacity-25">
                                <i class="fas fa-sun text-warning mb-1"></i>
                                <div class="fs-12 text-muted text-uppercase" data-i18n="t-sunrise">Sunrise</div>
                                <div class="fw-bold">{{ $this->getFormattedSunrise() }}</div>
                            </div>
                            <div class="col-6 text-center">
                                <i class="fas fa-moon text-white mb-1"></i>
                                <div class="fs-12 text-muted text-uppercase" data-i18n="t-sunset">Sunset</div>
                                <div class="fw-bold">{{ $this->getFormattedSunset() }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-satellite fa-spin fa-2x text-muted mb-3"></i>
                            <p class="text-muted" data_i18n="t-acquiring_satellite_data">Acquiring Satellite Data...</p>
                            <p class="small text-danger" data-i18n="t-check_n8n_connection">Check n8n connection</p>
                        </div>
                    @endif
                </div>

                <div class="modal-footer border-top border-secondary border-opacity-25 justify-content-between">
                    <small class="text-muted mt-3">
                        <i class="fas fa-sync-alt me-1"></i> <span data-i18n="t-updated">Updated</span>: {{ $this->getLastUpdated() }}
                    </small>
                    <button type="button" class="btn btn-sm btn-primary mt-3" wire:click="refreshWeather">
                        <i class="fas fa-redo-alt me-1"></i> <span data-i18n="t-re_scan">Re-Scan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let currentTranslations = null;
        let currentLocale = '{{ app()->getLocale() }}';
        let translationObserver = null;

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

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

            loadTranslations(lang);

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
                    if (!response.ok) throw new Error('Network response error');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('t-language-changed', 'success', { language: lang.toUpperCase() });

                        window.dispatchEvent(new CustomEvent('language-changed', { detail: { locale: lang } }));
                    } else {
                        revertLanguage(originalSrc);
                    }
                })
                .catch(error => {
                    console.error(error);
                    revertLanguage(originalSrc);
                });
        }

        function revertLanguage(originalSrc) {
            const langImg = document.getElementById('header-lang-img');
            if(langImg) langImg.src = originalSrc;
            localStorage.setItem('user_locale', '{{ app()->getLocale() }}');
            showToast('t-error-occurred', 'error');
        }

        function loadTranslations(lang) {

            const translationPath = `/user/assets/lang/${lang}.json`;

            fetch(translationPath)
                .then(response => {

                    if (!response.ok) return fetch(`/assets/lang/${lang}.json`);
                    return response;
                })
                .then(response => {
                    if (!response.ok) throw new Error('Translation file not found');
                    return response.json();
                })
                .then(translations => {
                    currentTranslations = translations;
                    applyTranslations(translations);
                })
                .catch(err => console.error('Translation load error:', err));
        }

        function applyTranslations(translations) {
            if (!translations) return;

            const elements = document.querySelectorAll('[data-i18n], [data-key], [data-i18n-title], [data-i18n-placeholder]');

            elements.forEach(element => {

                if (element.hasAttribute('data-i18n-title')) {
                    const key = element.getAttribute('data-i18n-title');
                    const text = getNestedProperty(translations, key);
                    if (text) element.setAttribute('title', text);
                }

                if (element.hasAttribute('data-i18n-placeholder')) {
                    const key = element.getAttribute('data-i18n-placeholder');
                    const text = getNestedProperty(translations, key);
                    if (text) element.setAttribute('placeholder', text);
                }

                applySingleTranslation(element, translations);
            });
        }

        function applySingleTranslation(element, translations) {
            const key = element.getAttribute('data-i18n') || element.getAttribute('data-key');
            if (!key) return;

            const translation = getNestedProperty(translations, key);
            if (translation) {
                if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                    element.placeholder = translation;
                } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.value = translation;
                } else {

                    if(element.children.length > 0 && !element.hasAttribute('data-text-only')) {

                        element.textContent = translation;
                    } else {
                        element.textContent = translation;
                    }
                }
            }
        }

        function getNestedProperty(obj, path) {
            if(!path) return null;
            return path.split('.').reduce((current, key) => {
                return current && current[key] !== undefined ? current[key] : null;
            }, obj);
        }

        function showToast(keyOrMessage, type = 'info', params = {}) {
            let message = keyOrMessage;

            if (keyOrMessage.startsWith('t-') && currentTranslations) {
                const trans = getNestedProperty(currentTranslations, keyOrMessage);
                if (trans) {
                    message = trans;
                    Object.keys(params).forEach(k => message = message.replace(`{${k}}`, params[k]));
                }
            }

            document.querySelectorAll('.locale-toast').forEach(t => t.remove());

            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show position-fixed locale-toast`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';

            const icon = type === 'success' ? 'bx-check-circle' : type === 'error' ? 'bx-error' : 'bx-info-circle';

            toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class='bx ${icon} fs-4 me-2'></i>
                <span class="flex-grow-1">${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {

            const savedLocale = localStorage.getItem('user_locale') || '{{ app()->getLocale() }}';

            const flagMap = {
                'en': '{{ asset("user/assets/images/flags/us.svg") }}',
                'tr': '{{ asset("user/assets/images/flags/tr.svg") }}',
                'ee': '{{ asset("user/assets/images/flags/estonia.svg") }}'
            };
            const langImg = document.getElementById('header-lang-img');
            if (langImg && flagMap[savedLocale]) langImg.src = flagMap[savedLocale];

            loadTranslations(savedLocale);

            if (translationObserver) translationObserver.disconnect();

            translationObserver = new MutationObserver(debounce(function(mutations) {
                if (!currentTranslations) return;

                let shouldUpdate = false;
                for(let mutation of mutations) {

                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        shouldUpdate = true;
                        break;
                    }
                }

                if (shouldUpdate) {
                    applyTranslations(currentTranslations);
                }
            }, 50));

            translationObserver.observe(document.body, { childList: true, subtree: true });

            if (typeof Livewire !== 'undefined') {

                if (Livewire.hook) {
                    Livewire.hook('morph.updated', ({ el, component }) => {
                        if (currentTranslations) applyTranslations(currentTranslations);
                    });
                }

                else {
                    document.addEventListener('livewire:update', function() {
                        if (currentTranslations) applyTranslations(currentTranslations);
                    });
                }
            }

            document.addEventListener('livewire:initialized', () => {
                if (currentTranslations) applyTranslations(currentTranslations);
            });
        });
    </script>
@endpush

@push('styles')
    <link href="{{ asset('user/assets/css/pages/top-bar.css') }}" rel="stylesheet" type="text/css" />
@endpush
