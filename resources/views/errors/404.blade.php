<x-layouts.appFront>
    <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
    @push('landStyles')
        <style>
            .error-container {
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 20px;
                background: var(--white);
            }
            .error-code {
                font-size: clamp(100px, 20vw, 180px);
                font-weight: 900;
                color: var(--gray-100);
                line-height: 1;
                position: relative;
            }
            .error-code::after {
                content: '404';
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                color: var(--primary-blue);
                clip-path: inset(45% 0 0 0);
            }
            .error-text h2 { font-size: 32px; margin: 20px 0; color: var(--black); }
            .error-text p { color: var(--gray-600); margin-bottom: 30px; max-width: 400px; }

            .error-actions { display: flex; gap: 15px; }

            @media (max-width: 480px) {
                .error-actions { flex-direction: column; width: 100%; }
                .btn-primary, .btn-secondary { width: 100%; }
            }
        </style>
    @endpush

    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-text">
            <h2 data-translate="error_title">Lost in Airspace?</h2>
            <p data-translate="error_desc">The coordinates you're looking for don't exist. This page might have been moved or decommissioned.</p>
        </div>
        <div class="error-actions">
            <a href="/" class="btn-primary" data-translate="error_btn_home">Back to Homepage</a>
            <a href="{{ route('contact-page') }}" class="btn-secondary" data-translate="error_btn_contact">Report Issue</a>
        </div>
    </div>
    @livewire('partials.footer')
</x-layouts.appFront>
