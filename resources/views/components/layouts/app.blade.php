<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $nonce = Illuminate\Support\Str::random(40);
    @endphp
    <meta http-equiv="Content-Security-Policy" content="style-src 'self' 'nonce-{{ $nonce }}'; script-src 'self' 'nonce-{{ $nonce }}'">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <title>Sky Guardian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">

    <!-- Add nonce to style tags -->
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link nonce="{{ $nonce }}" id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <link nonce="{{ $nonce }}" rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    @stack('styles')
    @livewireStyles
</head>
<body>
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    {{ $slot }}
</div>

<!-- Add nonce to script tags -->
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/config.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/sidebar-pin.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/slick/slick.js') }}"></script>
<script nonce="{{ $nonce }}" src="{{ asset('assets/js/header-slick.js') }}"></script>

<script nonce="{{ $nonce }}" src="{{ asset('assets/js/script.js') }}"></script>
@stack('scripts')
@livewireScripts


</body>
</html>
