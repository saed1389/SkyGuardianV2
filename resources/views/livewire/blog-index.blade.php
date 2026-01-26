<div>
    <div>
        @push('landStyles')
            <link href="{{ asset('assets/css/index.css') }}" rel="stylesheet" type="text/css" />
            <style>
                .blog-header { margin-top: 70px; background: var(--gray-100); padding: 80px 20px; text-align: center; }
                .blog-header h1 { font-size: 48px; margin-bottom: 20px; color: var(--black); }
                .blog-header p { font-size: 18px; color: var(--gray-600); max-width: 600px; margin: 0 auto; }
                .blog-controls { max-width: 1200px; margin: -30px auto 50px; padding: 20px; background: var(--white); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); display: flex; gap: 20px; flex-wrap: wrap; align-items: center; justify-content: space-between; position: relative; z-index: 10; }
                .categories { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 5px; }
                .cat-btn { background: none; border: 1px solid var(--gray-200); padding: 8px 16px; border-radius: 20px; cursor: pointer; font-weight: 500; color: var(--gray-600); transition: all 0.2s; white-space: nowrap; }
                .cat-btn.active, .cat-btn:hover { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }
                .search-box input { padding: 10px 15px; border: 1px solid var(--gray-200); border-radius: 8px; width: 250px; }
                .blog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto 80px; padding: 0 20px; }
                .post-card { background: var(--white); border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.3s; text-decoration: none; color: inherit; display: block; border: 1px solid var(--gray-100); }
                .post-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
                .post-image { width: 100%; height: 220px; }
                .post-content { padding: 25px; }
                .lang-dynamic { display: none; }
                .lang-dynamic.lang-en { display: block; }
                span.lang-dynamic.lang-en { display: inline; }
                .post-meta { font-size: 12px; color: var(--primary-blue); font-weight: 600; text-transform: uppercase; margin-bottom: 10px; }
                .post-title { font-size: 22px; font-weight: bold; margin-bottom: 10px; line-height: 1.3; color: var(--gray-900); }
                .post-excerpt { color: var(--gray-600); font-size: 15px; margin-bottom: 20px; line-height: 1.6; }
                .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--gray-100); padding-top: 15px; font-size: 13px; color: var(--gray-600); }
                .pagination-container { text-align: center; margin-bottom: 80px; }
            </style>
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
