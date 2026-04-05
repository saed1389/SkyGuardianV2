<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/dynamic.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <header class="legal-header">
        <h1 data-translate="license_title">Software & Hardware Licensing</h1>
        <p data-translate="license_dec">Intellectual property rights, end-user license agreements (EULA), and hardware distribution terms for Sky Guardian.</p>
    </header>

    <article class="legal-content">
        <div class="lang-dynamic lang-en">{!! $license->license_en !!}</div>
        <div class="lang-dynamic lang-tr">{!! $license->license_tr !!}</div>
        <div class="lang-dynamic lang-ee">{!! $license->license_ee !!}</div>
    </article>
    @livewire('partials.contact')
    @livewire('partials.footer')
</div>
