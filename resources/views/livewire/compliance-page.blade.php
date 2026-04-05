<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/dynamic.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <header class="legal-header">
        <h1 data-translate="compliance_title">Regulatory Compliance & Standards</h1>
        <p data-translate="compliance_dec">Adherence to international defense protocols, RF spectrum regulations, and data security standards at Sky Guardian.</p>
    </header>

    <article class="legal-content">
        <div class="lang-dynamic lang-en">{!! $compliance->compliance_en !!}</div>
        <div class="lang-dynamic lang-tr">{!! $compliance->compliance_tr !!}</div>
        <div class="lang-dynamic lang-ee">{!! $compliance->compliance_ee !!}</div>
    </article>
    @livewire('partials.contact')
    @livewire('partials.footer')
</div>
