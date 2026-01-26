<div>
    @push('landStyles')
        <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet" type="text/css" />
        <style>
            .article-hero { margin-top: 70px; height: 500px; position: relative; overflow: hidden; }
            .hero-img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6); }
            .article-hero-content { position: absolute; bottom: 0; left: 0; width: 100%; padding: 60px 20px; color: white; text-align: center; z-index: 2; }
            .article-meta { font-size: 14px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px; display: block; font-weight: 600; color: var(--primary-blue); }
            .article-title { font-size: 48px; line-height: 1.2; max-width: 900px; margin: 0 auto; }

            .article-container { max-width: 900px; margin: 60px auto; padding: 0 20px; }
            .article-body { font-size: 19px; line-height: 1.8; color: var(--gray-700); }
            .article-body h2, .article-body h3 { color: var(--black); margin: 40px 0 20px; }
            .article-body p { margin-bottom: 25px; }
            .article-body img { width: 100%; border-radius: 12px; margin: 30px 0; }

            /* Language handling */
            .lang-dynamic { display: none; }
            .lang-dynamic.lang-en { display: block; }

            .article-footer { margin-top: 60px; padding-top: 40px; border-top: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; }
            .share-links { display: flex; gap: 15px; align-items: center; }
            .share-btn { width: 40px; height: 40px; border-radius: 50%; background: var(--gray-100); display: flex; align-items: center; justify-content: center; transition: 0.3s; color: var(--black); text-decoration: none; }
            .share-btn:hover { background: var(--primary-blue); color: white; }
        </style>
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
