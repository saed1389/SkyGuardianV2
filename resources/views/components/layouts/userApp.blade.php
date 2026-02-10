<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Sky Guardian</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <link rel="shortcut icon" href="{{ asset('user/assets/images/favicon.ico') }}">
    <script src="{{ asset('user/assets/js/layout.js') }}"></script>
    <link href="{{ asset('user/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('user/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('user/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('user/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    @livewireStyles
</head>
<body>
<div id="layout-wrapper">
    @livewire('user.partials.top-bar')
    @livewire('user.partials.header')
    {{ $slot }}
</div>

<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>

<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<script src="{{ asset('user/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('user/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('user/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('user/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('user/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('user/assets/js/app.js') }}"></script>
@livewireScripts
@push('scripts')
    <script>
        window.addEventListener('language-changed', function(event) {
            const translationsPath = `/user/assets/lang/${event.detail.locale}.json`;
            fetch(translationsPath)
                .then(response => response.json())
                .then(translations => {
                    document.querySelectorAll('[data-i18n]').forEach(element => {
                        const key = element.getAttribute('data-i18n');
                        const translation = getNestedProperty(translations, key);
                        if (translation) {
                            element.textContent = translation;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading sidebar translations:', error);
                });
        });

        function getNestedProperty(obj, path) {
            return path.split('.').reduce((current, key) => {
                return current && current[key] !== undefined ? current[key] : null;
            }, obj);
        }
    </script>
@endpush
@stack('scripts')
</body>
</html>
