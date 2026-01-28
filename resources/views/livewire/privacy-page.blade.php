<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/dynamic.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <header class="legal-header">
        <h1 data-translate="footer_privacy">Privacy</h1>
        <p data-translate="legal_subtitle">How we protect and manage your data at SkyGuardian.</p>
    </header>

    <article class="legal-content">
        <div class="lang-dynamic lang-en">{!! $privacy->privacy_en !!}</div>
        <div class="lang-dynamic lang-tr">{!! $privacy->privacy_tr !!}</div>
        <div class="lang-dynamic lang-ee">{!! $privacy->privacy_ee !!}</div>
    </article>
    @livewire('partials.contact')
    @livewire('partials.footer')
</div>
