<div>
    @section('meta')
        @php
            $lang = request()->query('lang', 'en');

            $dbLang = ($lang === 'et') ? 'ee' : $lang;

            $titleColumn = 'title_' . $dbLang;
            $excerptColumn = 'excerpt_' . $dbLang;

            $metaTitle = $post->$titleColumn ?? $post->title_en;
            $metaDesc = strip_tags($post->$excerptColumn ?? $post->excerpt_en);
        @endphp

        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDesc }}">
        <meta property="og:image" content="{{ url($post->image) }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ request()->fullUrl() }}">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDesc }}">
        <meta name="twitter:image" content="{{ url($post->image) }}">
    @endsection

    @push('landStyles')
        <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/pages/blogShow.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    <div class="article-hero">
        <img src="{{ $post->image }}" class="hero-img" alt="Article Hero">
        <div class="article-hero-content">
            <span class="article-meta lang-dynamic lang-en">{{ $post->category_en }}</span>
            <span class="article-meta lang-dynamic lang-tr">{{ $post->category_tr }}</span>
            <span class="article-meta lang-dynamic lang-ee">{{ $post->category_ee }}</span>

            <h1 class="article-title lang-dynamic lang-en">{{ $post->title_en }}</h1>
            <h1 class="article-title lang-dynamic lang-tr">{{ $post->title_tr }}</h1>
            <h1 class="article-title lang-dynamic lang-ee">{{ $post->title_ee }}</h1>
        </div>
    </div>

    <div class="article-container">
        <article class="article-body">
            <div class="lang-dynamic lang-en">{!! $post->body_en !!}</div>
            <div class="lang-dynamic lang-tr">{!! $post->body_tr !!}</div>
            <div class="lang-dynamic lang-ee">{!! $post->body_ee !!}</div>
            <div class="mt-5">
                <span data-translate="resource">Resource</span>: {{ $post->resource }}
            </div>
        </article>
        <div class="article-footer">
            <div class="author-info">
                <strong data-translate="published-on">Published on:</strong>: {{ $post->formatted_date }}
            </div>
            <div class="share-links">
                <span data-translate="share">Share:</span>:

                <a href="#" class="share-btn fb-share" aria-label="Share on Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>

                <a href="#" class="share-btn tw-share" aria-label="Share on X">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                </a>

                <a href="#" class="share-btn in-share" aria-label="Share on LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
            </div>
        </div>
    </div>

    @livewire('partials.contact')
    @livewire('partials.footer')

        @push('landScripts')
            <script src="{{ asset('assets/main.js') }}"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    function getShareUrl() {
                        const currentLang = localStorage.getItem('sky_lang') || 'en';
                        const baseUrl = window.location.href.split('?')[0];
                        return encodeURIComponent(`${baseUrl}?lang=${currentLang}`);
                    }

                    function getActiveTitle() {
                        const titles = document.querySelectorAll('.article-title');
                        for (let title of titles) {
                            if (window.getComputedStyle(title).display !== 'none') {
                                return encodeURIComponent(title.innerText.trim());
                            }
                        }
                        return encodeURIComponent(document.title);
                    }

                    document.querySelector('.fb-share').addEventListener('click', function(e) {
                        e.preventDefault();
                        window.open(`https://www.facebook.com/sharer/sharer.php?u=${getShareUrl()}`, 'shareWindow', 'width=600,height=400');
                    });

                    document.querySelector('.tw-share').addEventListener('click', function(e) {
                        e.preventDefault();
                        window.open(`https://twitter.com/intent/tweet?url=${getShareUrl()}&text=${getActiveTitle()}`, 'shareWindow', 'width=600,height=400');
                    });

                    document.querySelector('.in-share').addEventListener('click', function(e) {
                        e.preventDefault();
                        window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${getShareUrl()}&title=${getActiveTitle()}`, 'shareWindow', 'width=600,height=400');
                    });
                });
            </script>
        @endpush
</div>
