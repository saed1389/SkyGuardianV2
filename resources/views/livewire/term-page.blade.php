<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .legal-header { margin-top: 60px; padding: 80px 20px; background: var(--gray-900); color: white; text-align: center; }
            .legal-header h1 { font-size: clamp(32px, 5vw, 48px); margin-bottom: 10px; }
            .legal-header p { opacity: 0.7; font-size: 16px; }
            .legal-content { max-width: 800px; margin: 60px auto; padding: 0 20px; line-height: 1.8; color: var(--gray-700); }
            .legal-content h2 { color: var(--black); margin: 40px 0 20px; font-size: 24px; }
            .legal-content p { margin-bottom: 20px; }
            .legal-content ul { margin-bottom: 20px; padding-left: 20px; }
            .legal-content li { margin-bottom: 10px; }
            .last-updated { margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--gray-200); font-size: 14px; font-style: italic; }
        </style>
    @endpush

    <header class="legal-header">
        <h1 data-translate="legal_title">Privacy Policy</h1> <p data-translate="legal_subtitle">How we protect and manage your data at SkyGuardian.</p>
    </header>

    <article class="legal-content">
        <h2 data-translate="legal_sec1_title">1. Data Collection</h2>
        <p data-translate="legal_sec1_desc">We collect information to provide better services to all our users. This includes signal data, account details, and telemetry from authorized monitoring devices.</p>

        <h2 data-translate="legal_sec2_title">2. Use of Information</h2>
        <p data-translate="legal_sec2_desc">The data we collect is used to:</p>
        <ul>
            <li data-translate="legal_li1">Improve detection algorithms.</li>
            <li data-translate="legal_li2">Ensure airspace compliance.</li>
            <li data-translate="legal_li3">Provide real-time alerts to critical infrastructure.</li>
        </ul>

        <div class="last-updated">
            <span data-translate="legal_last_update">Last Updated:</span> January 2026
        </div>
    </article>
    @livewire('partials.contact')
    @livewire('partials.footer')
</div>
