<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyGuardian System - Advanced Aviation Monitoring & Drone Tracking</title>
    <meta name="description" content="Estonia's leading sky monitoring system. Complete drone monitoring, real-time aircraft tracking, weather services, and airspace security solutions.">
    <meta name="keywords" content="drone tracking, aviation monitoring, airspace security, Estonia startup">
    <meta name="author" content="SkyGuardian System">
    <meta name="robots" content="index, follow">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="SkyGuardian System">
    <meta property="og:description" content="Complete drone monitoring and security solutions.">
    <meta property="twitter:card" content="summary_large_image">

    @stack('landStyles')
    @livewireStyles
</head>
<body>
@php
    $navPrefix = Request::is('/') ? '' : url('/');
@endphp
<nav>
    <div class="nav-container">
        <div class="logo">
            <a class="logo" href="{{ url('/') }}">
                <img src="{{ asset('user/assets/images/logo.png') }}" alt="" style="width: 200px">
            </a>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ $navPrefix }}#home" data-translate="nav_home">Home</a></li>
            <li><a href="{{ $navPrefix }}#features" data-translate="nav_features">Features</a></li>
            <li><a href="{{ $navPrefix }}#services" data-translate="nav_services">Services</a></li>
            <li><a href="{{ $navPrefix }}#about" data-translate="nav_about">About</a></li>
            <li><a href="{{ route('contact-page') }}" data-translate="nav_contact">Contact</a></li>
        </ul>
        <div class="hidden md:flex" style="display:flex; align-items: center; gap: 15px;">
            <div class="language-switcher">
                <select class="lang-select" id="languageSelect" onchange="changeLanguage(this.value)">
                    <option value="en">🇬🇧 English</option>
                    <option value="tr">🇹🇷 Türkçe</option>
                    <option value="et">🇪🇪 Eesti</option>
                </select>
            </div>
        </div>
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
    </div>
</nav>
<div id="mobileMenu" class="mobile-menu" style="display: none;">
    <div class="mobile-menu-content">
        <a href="{{ $navPrefix }}#home" data-translate="nav_home">Home</a>
        <a href="{{ $navPrefix }}#features" data-translate="nav_features">Features</a>
        <a href="{{ $navPrefix }}#services" data-translate="nav_services">Services</a>
        <a href="{{ $navPrefix }}#about" data-translate="nav_about">About</a>
        <a href="{{ route('contact-page') }}" data-translate="nav_contact">Contact</a>

        <div class="language-switcher" style="padding: 10px 12px;">
            <select class="lang-select" style="width: 100%;" onchange="changeLanguage(this.value)">
                <option value="en">🇬🇧 English</option>
                <option value="tr">🇹🇷 Türkçe</option>
                <option value="et">🇪🇪 Eesti</option>
            </select>
        </div>
        <button class="cta-button" style="width: 100%; margin-top: 10px;" data-translate="nav_cta" onclick="openModal('demoModal')">Get Started</button>
    </div>
</div>
{{ $slot }}
@stack('landScripts')
@livewireScripts
<script>
    const DEFAULT_LANG = 'en';
    const SUPPORTED_LANGS = ['en', 'tr', 'et'];
    const langCache = {};

    async function fetchTranslations(lang) {
        if (langCache[lang]) return langCache[lang];
        try {
            const response = await fetch(`/translations/${lang}.json`);
            if (!response.ok) return null;
            const json = await response.json();
            langCache[lang] = json;
            return json;
        } catch (error) {
            console.error("Error loading translations:", error);
            return null;
        }
    }
    function applyTranslations(translations) {
        if (!translations) return;
        const elements = document.querySelectorAll('[data-translate]');
        elements.forEach(el => {
            const key = el.getAttribute('data-translate');
            if (translations[key]) el.textContent = translations[key];
        });
    }
    async function changeLanguage(lang) {
        if (!SUPPORTED_LANGS.includes(lang)) return;

        localStorage.setItem('sky_lang', lang);
        document.documentElement.lang = lang;
        document.querySelectorAll('.lang-select').forEach(s => s.value = lang);

        const translations = await fetchTranslations(lang);
        if (translations) applyTranslations(translations);

        const dbSuffix = (lang === 'et') ? 'ee' : lang;

        document.querySelectorAll('.lang-dynamic').forEach(el => el.style.display = 'none');

        document.querySelectorAll('.lang-dynamic.lang-' + dbSuffix).forEach(el => {
            const tagName = el.tagName.toLowerCase();
            el.style.display = (tagName === 'span') ? 'inline' : 'block';
        });
    }
    document.addEventListener('DOMContentLoaded', () => {
        const savedLang = localStorage.getItem('sky_lang') || DEFAULT_LANG;
        document.querySelectorAll('.lang-select').forEach(s => s.value = savedLang);
        changeLanguage(savedLang);
    });
</script>
</body>
</html>
