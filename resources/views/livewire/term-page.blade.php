<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/dynamic.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <header class="legal-header">
        <h1 data-translate="term_title">Terms & Conditions</h1>
        <p data-translate="term_dec">Operational guidelines, hardware deployment terms, and service level agreements for Sky Guardian systems.</p>
    </header>

    <article class="legal-content">
        <div class="lang-dynamic lang-en">{!! $term->term_en !!}</div>
        <div class="lang-dynamic lang-tr">{!! $term->term_tr !!}</div>
        <div class="lang-dynamic lang-ee">{!! $term->term_ee !!}</div>
    </article>
    @livewire('partials.contact')
    @livewire('partials.footer')
</div>
