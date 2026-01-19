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
        let translationObserver = null;

        // 1. Helper: Debounce to prevent performance issues on rapid DOM changes
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // 2. Core: Switch Language Function
        function switchLanguage(lang) {
            const flagMap = {
                'en': '{{ asset("user/assets/images/flags/us.svg") }}',
                'tr': '{{ asset("user/assets/images/flags/tr.svg") }}',
                'ee': '{{ asset("user/assets/images/flags/estonia.svg") }}'
            };

            const langImg = document.getElementById('header-lang-img');
            const originalSrc = langImg.src;

            // Visual update immediately
            if (flagMap[lang]) {
                langImg.src = flagMap[lang];
            }

            localStorage.setItem('user_locale', lang);
            currentLocale = lang;

            // Load JSON translations immediately for UI speed
            loadTranslations(lang);

            // Send request to backend to persist session
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

                        // Dispatch event so other components know language changed
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

        // 3. Helper: Revert language on failure
        function revertLanguage(originalSrc) {
            const langImg = document.getElementById('header-lang-img');
            if(langImg) langImg.src = originalSrc;
            localStorage.setItem('user_locale', '{{ app()->getLocale() }}');
            showToast('t-error-occurred', 'error');
        }

        // 4. Core: Load Translations from JSON
        function loadTranslations(lang) {
            // Adjust this path if your JSON files are in a different location
            const translationPath = `/user/assets/lang/${lang}.json`;

            fetch(translationPath)
                .then(response => {
                    // Fallback path if needed
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

        // 5. Core: Apply Translations to DOM
        function applyTranslations(translations) {
            if (!translations) return;

            // Select all translatable elements
            const elements = document.querySelectorAll('[data-i18n], [data-key], [data-i18n-title], [data-i18n-placeholder]');

            elements.forEach(element => {
                // Handle Title attribute
                if (element.hasAttribute('data-i18n-title')) {
                    const key = element.getAttribute('data-i18n-title');
                    const text = getNestedProperty(translations, key);
                    if (text) element.setAttribute('title', text);
                }
                // Handle Placeholder attribute
                if (element.hasAttribute('data-i18n-placeholder')) {
                    const key = element.getAttribute('data-i18n-placeholder');
                    const text = getNestedProperty(translations, key);
                    if (text) element.setAttribute('placeholder', text);
                }
                // Handle Text Content
                applySingleTranslation(element, translations);
            });
        }

        // 6. Helper: Apply to single element
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
                    // Safety: If element has icon children, prevent overwriting them unless explicitly allowed
                    if(element.children.length > 0 && !element.hasAttribute('data-text-only')) {
                        // Try to find a text node to replace, or append if safe.
                        // For now, simpler to assume data-key is on the text container specifically.
                        // If you have <button><i class="icon"></i> Text</button>, put data-key on a <span> around Text.
                        element.textContent = translation;
                    } else {
                        element.textContent = translation;
                    }
                }
            }
        }

        // 7. Helper: Get nested JSON property (e.g., 'messages.welcome')
        function getNestedProperty(obj, path) {
            if(!path) return null;
            return path.split('.').reduce((current, key) => {
                return current && current[key] !== undefined ? current[key] : null;
            }, obj);
        }

        // 8. Helper: Toast Notification
        function showToast(keyOrMessage, type = 'info', params = {}) {
            let message = keyOrMessage;

            // Try to translate the message itself
            if (keyOrMessage.startsWith('t-') && currentTranslations) {
                const trans = getNestedProperty(currentTranslations, keyOrMessage);
                if (trans) {
                    message = trans;
                    Object.keys(params).forEach(k => message = message.replace(`{${k}}`, params[k]));
                }
            }

            // Remove existing toasts
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

        // 9. Main Execution Block
        document.addEventListener('DOMContentLoaded', function() {

            // A. Initial Load
            const savedLocale = localStorage.getItem('user_locale') || '{{ app()->getLocale() }}';

            const flagMap = {
                'en': '{{ asset("user/assets/images/flags/us.svg") }}',
                'tr': '{{ asset("user/assets/images/flags/tr.svg") }}',
                'ee': '{{ asset("user/assets/images/flags/estonia.svg") }}'
            };
            const langImg = document.getElementById('header-lang-img');
            if (langImg && flagMap[savedLocale]) langImg.src = flagMap[savedLocale];

            loadTranslations(savedLocale);

            // B. MutationObserver (THE FIX for Modals)
            // This watches the DOM for *new* elements (like your modal) and translates them instantly
            if (translationObserver) translationObserver.disconnect();

            translationObserver = new MutationObserver(debounce(function(mutations) {
                if (!currentTranslations) return;

                let shouldUpdate = false;
                for(let mutation of mutations) {
                    // If nodes were added (like opening a modal)
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        shouldUpdate = true;
                        break;
                    }
                }

                if (shouldUpdate) {
                    applyTranslations(currentTranslations);
                }
            }, 50)); // 50ms delay to batch updates

            // Start observing the entire body
            translationObserver.observe(document.body, { childList: true, subtree: true });

            // C. Livewire Hooks (Backup)
            // Listen for Livewire updates to catch things the observer might miss (like value updates)
            if (typeof Livewire !== 'undefined') {
                // Livewire v3
                if (Livewire.hook) {
                    Livewire.hook('morph.updated', ({ el, component }) => {
                        if (currentTranslations) applyTranslations(currentTranslations);
                    });
                }
                // Livewire v2
                else {
                    document.addEventListener('livewire:update', function() {
                        if (currentTranslations) applyTranslations(currentTranslations);
                    });
                }
            }

            // Also listen for standard Livewire events
            document.addEventListener('livewire:initialized', () => {
                if (currentTranslations) applyTranslations(currentTranslations);
            });
        });
    </script>
@endpush

@push('styles')
    <link href="{{ asset('user/assets/css/pages/top-bar.css') }}" rel="stylesheet" type="text/css" />
@endpush
