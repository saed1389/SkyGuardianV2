<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/dynamic.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <header class="legal-header">
        <h1 data-translate="privacy_title">Privacy Policy & Data Protection</h1>
        <p data-translate="privacy_dec">How we collect, process, and safeguard operational and organizational data at Sky Guardian.</p>
    </header>

    <article class="legal-content">
        <div class="lang-dynamic lang-en">{!! $privacy->privacy_en !!}</div>
        <div class="lang-dynamic lang-tr">{!! $privacy->privacy_tr !!}</div>
        <div class="lang-dynamic lang-ee">{!! $privacy->privacy_ee !!}</div>
    </article>
    @livewire('partials.contact')
    @livewire('partials.footer')
</div>
