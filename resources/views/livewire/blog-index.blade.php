<div>
    <div>
        @push('landStyles')
            <link href="{{ asset('assets/css/general.css') }}" rel="stylesheet" type="text/css" />
            <link href="{{ asset('assets/css/pages/blog.css') }}" rel="stylesheet" type="text/css" />
        @endpush

        <header class="blog-header">
            <h1 data-translate="blog_title">Aviation Insights</h1>
            <p data-translate="blog_subtitle">Latest news, technology updates, and security protocols from SkyGuardian.</p>
        </header>

        <div class="blog-controls">
            <div class="categories">
                <button wire:click="setCategory('all')" class="cat-btn {{ $category === 'all' ? 'active' : '' }}">All</button>
                <button wire:click="setCategory('Technology')" class="cat-btn {{ $category === 'Technology' ? 'active' : '' }}">Technology</button>
                <button wire:click="setCategory('Security')" class="cat-btn {{ $category === 'Security' ? 'active' : '' }}">Security</button>
            </div>
            <div class="search-box">
                <input type="text" wire:model.live="search" placeholder="Search articles...">
            </div>
        </div>

        <div class="blog-grid">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug_en) }}" class="post-card">
                    <img src="{{ $post->image }}" alt="Article Image" class="post-image">
                    <div class="post-content">
                        <span class="post-meta lang-dynamic lang-en">{{ $post->category_en }}</span>
                        <span class="post-meta lang-dynamic lang-tr">{{ $post->category_tr }}</span>
                        <span class="post-meta lang-dynamic lang-ee">{{ $post->category_ee }}</span>

                        <h2 class="post-title lang-dynamic lang-en">{{ $post->title_en }}</h2>
                        <h2 class="post-title lang-dynamic lang-tr">{{ $post->title_tr }}</h2>
                        <h2 class="post-title lang-dynamic lang-ee">{{ $post->title_ee }}</h2>

                        <p class="post-excerpt lang-dynamic lang-en">{{ Str::limit($post->excerpt_en, 120) }}</p>
                        <p class="post-excerpt lang-dynamic lang-tr">{{ Str::limit($post->excerpt_tr, 120) }}</p>
                        <p class="post-excerpt lang-dynamic lang-ee">{{ Str::limit($post->excerpt_ee, 120) }}</p>

                        <div class="post-footer">
                            <span>SkyGuardian Team</span>
                            <span>{{ $post->formatted_date }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $posts->links() }}
        </div>
    </div>
    @livewire('partials.contact')
    @livewire('partials.footer')
    @push('landScripts')
        <script src="{{ asset('assets/main.js') }}"></script>
    @endpush
</div>
