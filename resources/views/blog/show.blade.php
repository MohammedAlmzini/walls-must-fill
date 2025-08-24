@extends('layouts.seo')

@section('title', $post->title . ' - ' . __('app.site_name'))

@section('content')
<main id="main-content">
    <div class="container">
        <article class="post-article" itemscope itemtype="http://schema.org/Article">
            <header class="post-header">
                <h1 itemprop="headline">{{ $post->title }}</h1>
                
                <div class="post-meta">
                    @if($post->published_at)
                        <time datetime="{{ $post->published_at->toISOString() }}" itemprop="datePublished">
                            {{ $post->published_at->format('d F Y') }}
                        </time>
                    @endif
                    @if($post->author)
                        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                            {{ __('app.post.by_author') }} <span itemprop="name">{{ $post->author->name }}</span>
                        </span>
                    @endif
                </div>

                @if($post->excerpt)
                    <div class="post-excerpt" itemprop="description">{{ $post->excerpt }}</div>
                @endif
            </header>

            @if($post->image_path)
                <figure class="post-featured-image" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                    <img src="{{ asset('storage/'.$post->image_path) }}" 
                         alt="{{ $post->title }}" 
                         itemprop="url"
                         loading="lazy"
                         width="800" 
                         height="400">
                    <meta itemprop="width" content="800">
                    <meta itemprop="height" content="400">
                </figure>
            @endif

            @if($post->youtube_embed_url)
                <div class="post-video">
                    <iframe src="{{ $post->youtube_embed_url }}"
                            title="{{ $post->title }} - {{ __('app.post.video') }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            loading="lazy"
                            style="width:100%;height:400px;border:0;border-radius:12px;"></iframe>
                </div>
            @endif

            <div class="post-content" itemprop="articleBody">
                {!! $post->body !!}
            </div>

            <!-- Microdata for SEO -->
            <meta itemprop="dateModified" content="{{ $post->updated_at->toISOString() }}">
            <div itemprop="publisher" itemscope itemtype="http://schema.org/Organization" style="display: none;">
                <meta itemprop="name" content="Walls Must">
                <div itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                    <meta itemprop="url" content="{{ asset('images/logo.png') }}">
                </div>
            </div>
        </article>

        <!-- Social sharing -->
        <div class="social-sharing">
            <h3>{{ __('app.post.share_post') }}</h3>
            <div class="sharing-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                   target="_blank" rel="noopener" class="share-btn facebook">
                    {{ __('app.post.facebook') }}
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                   target="_blank" rel="noopener" class="share-btn twitter">
                    {{ __('app.post.twitter') }}
                </a>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}" 
                   target="_blank" rel="noopener" class="share-btn whatsapp">
                    {{ __('app.post.whatsapp') }}
                </a>
            </div>
        </div>
    </div>
</main>

<style>
.post-article {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
}

.post-header {
    margin-bottom: 30px;
    text-align: center;
}

.post-meta {
    color: var(--muted);
    font-size: 14px;
    margin: 15px 0;
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.post-excerpt {
    font-size: 1.1rem;
    color: var(--muted);
    font-style: italic;
    margin: 20px 0;
    padding: 20px;
    background: var(--surface);
    border-radius: var(--radius);
    border-left: 4px solid var(--red);
}

.post-featured-image {
    margin: 30px 0;
    text-align: center;
}

.post-featured-image img {
    border-radius: 12px;
    box-shadow: var(--shadow);
    max-width: 100%;
    height: auto;
}

.post-video {
    margin: 30px 0;
}

.post-content {
    line-height: 1.8;
    font-size: 16px;
}

.post-content h2,
.post-content h3,
.post-content h4 {
    margin: 30px 0 15px;
    color: var(--black);
}

.post-content p {
    margin: 0 0 20px;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
    box-shadow: var(--shadow);
}

.post-content blockquote {
    border-right: 4px solid var(--red);
    padding-right: 20px;
    margin: 20px 0;
    font-style: italic;
    color: var(--muted);
    background: var(--surface);
    padding: 20px;
    border-radius: var(--radius);
}

.post-content ul,
.post-content ol {
    margin: 20px 0;
    padding-right: 30px;
}

.post-content li {
    margin: 10px 0;
}

.social-sharing {
    margin-top: 40px;
    padding: 20px;
    background: var(--surface);
    border-radius: var(--radius);
    text-align: center;
}

.sharing-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.share-btn {
    padding: 10px 20px;
    border-radius: var(--radius);
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: transform 0.2s;
}

.share-btn:hover {
    transform: translateY(-2px);
}

.share-btn.facebook { background: #1877f2; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.whatsapp { background: #25d366; }

@media (max-width: 768px) {
    .post-article {
        padding: 0 15px;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 5px;
    }
    
    .sharing-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .share-btn {
        width: 200px;
    }
}
</style>
@endsection