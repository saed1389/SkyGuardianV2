<?php

return [
    'policy' => Spatie\Csp\Policy::class,
    'report_only_policy' => '',
    'report_uri' => env('CSP_REPORT_URI', ''),
    'enabled' => env('CSP_ENABLED', true),
    'nonce_generator' => Spatie\Csp\Nonce\RandomString::class,

    // DISABLE NONCE since your app uses unsafe-inline
    'nonce_enabled' => false,

    'trim_directives' => ['style-src', 'script-src'],

    'policies' => [
        'default' => [
            'base-uri' => ["'self'"],
            'default-src' => ["'self'"],

            // ALLOW INLINE STYLES (required for Livewire, LordIcon, etc.)
            'style-src' => [
                "'self'",
                "'unsafe-inline'",  // Required!
                'cdn.jsdelivr.net',
                'cdnjs.cloudflare.com',
            ],

            // ALLOW INLINE SCRIPTS
            'script-src' => [
                "'self'",
                "'unsafe-inline'",  // Required!
                'cdn.jsdelivr.net',
            ],

            'img-src' => [
                "'self'",
                'data:',
                'http://127.0.0.1:8000',
            ],

            'font-src' => [
                "'self'",
                'cdnjs.cloudflare.com',
            ],

            'connect-src' => ["'self'"],
            'form-action' => ["'self'"],
            'frame-ancestors' => ["'none'"],
            'object-src' => ["'none'"],
            'media-src' => ["'self'"],
        ],
    ],
];
