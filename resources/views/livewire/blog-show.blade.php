<div>
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
        </article>

        <div class="article-footer">
            <div class="author-info">
                <strong data-translate="published-on">Published on:</strong> {{ $post->formatted_date }}
            </div>
            <div class="share-links">
                <span data-translate="share">Share:</span>
                <a href="#" class="share-btn">FB</a>
                <a href="#" class="share-btn">TW</a>
                <a href="#" class="share-btn">LN</a>
            </div>
        </div>
    </div>
    @livewire('partials.contact')
    @livewire('partials.footer')
        @push('landScripts')
            <script src="{{ asset('assets/main.js') }}"></script>
        @endpush
</div>
