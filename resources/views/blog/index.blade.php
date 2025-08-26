@extends('layouts.seo')

@section('title', __('app.sections.pulse_cause') . ' -- ' . __('app.site_name'))

@section('content')
<div class="blog-container">
    <header class="page-header" data-reveal>
        <h1 class="section-title">{{ __('app.sections.pulse_cause') }}</h1>
        <p class="section-description">{{ __('app.descriptions.pulse_cause_description') }}</p>
    </header>

    <div class="search-section" data-reveal>
        <form method="get" class="search-form">
            <div class="search-input-wrapper">
                <input type="text" 
                       name="q" 
                       value="{{ $q }}" 
                       placeholder="{{ __('app.forms.search_titles_placeholder') }}"
                       class="search-input">
                <button type="submit" class="search-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="blog-grid" data-reveal>
        @forelse($posts as $post)
            <article class="blog-card clickable-card" onclick="window.location.href='{{ route('posts.show', $post->slug) }}'">
                <div class="blog-image-container">
                    @if($post->image_path)
                        <img src="{{ asset('storage/'.$post->image_path) }}" 
                             alt="{{ $post->title }}" 
                             class="blog-image"
                             loading="lazy">
                    @else
                        <div class="blog-placeholder">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="blog-overlay">
                        <div class="read-more">
                            <span>{{ __('app.actions.read_more') }}</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="blog-content">
                    <div class="blog-meta">
                        <span class="blog-date">{{ $post->created_at->format('M d, Y') }}</span>
                        <span class="blog-category">{{ __('app.categories.blog') }}</span>
                    </div>
                    
                    <h3 class="blog-title">{{ $post->title }}</h3>
                    
                    @if($post->excerpt)
                        <p class="blog-excerpt">{{ $post->excerpt }}</p>
                    @endif
                    
                    <div class="blog-footer">
                        <div class="blog-author">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>{{ __('app.common.author') }}</span>
                        </div>
                        
                        <div class="blog-stats">
                            <span class="stat-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span>{{ __('app.stats.views') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                        <circle cx="12" cy="13" r="3"/>
                    </svg>
                </div>
                <h3 class="empty-title">{{ __('app.empty_states.no_posts_title') }}</h3>
                <p class="empty-description">{{ __('app.empty_states.no_posts') }}</p>
            </div>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="pagination-wrapper" data-reveal>
            {{ $posts->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

<style>
.blog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--black);
    margin: 0 0 16px;
    background: linear-gradient(135deg, var(--red) 0%, #d63384 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-description {
    font-size: 1.1rem;
    color: var(--muted);
    margin: 0;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.search-section {
    margin-bottom: 40px;
    display: flex;
    justify-content: center;
}

.search-form {
    width: 100%;
    max-width: 500px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 100%;
    padding: 16px 20px;
    padding-right: 60px;
    border: 2px solid var(--border);
    border-radius: 50px;
    font-size: 16px;
    outline: none;
    transition: all 0.3s ease;
    background: var(--surface);
}

.search-input:focus {
    border-color: var(--red);
    box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
    transform: translateY(-2px);
}

.search-button {
    position: absolute;
    right: 8px;
    background: var(--red);
    color: white;
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-button:hover {
    background: #c53030;
    transform: scale(1.05);
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 28px;
    margin-bottom: 40px;
}

.blog-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    cursor: pointer;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: var(--red);
}

.blog-image-container {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.blog-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.blog-card:hover .blog-image {
    transform: scale(1.1);
}

.blog-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
}

.blog-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(211, 47, 47, 0.1) 0%, rgba(46, 125, 50, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.blog-card:hover .blog-overlay {
    opacity: 1;
}

.read-more {
    background: rgba(255, 255, 255, 0.95);
    color: var(--red);
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    backdrop-filter: blur(10px);
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.blog-card:hover .read-more {
    transform: translateY(0);
}

.blog-content {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.blog-date {
    font-size: 14px;
    color: var(--muted);
    font-weight: 500;
}

.blog-category {
    background: rgba(211, 47, 47, 0.1);
    color: var(--red);
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.blog-title {
    font-size: 1.35rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 16px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
}

.blog-excerpt {
    color: var(--muted);
    line-height: 1.6;
    margin: 0 0 20px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
}

.blog-footer {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.blog-author {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    font-size: 14px;
}

.blog-stats {
    display: flex;
    gap: 16px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--muted);
    font-size: 13px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    grid-column: 1 / -1;
}

.empty-icon {
    color: var(--muted);
    margin-bottom: 20px;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 12px;
}

.empty-description {
    font-size: 1.1rem;
    color: var(--muted);
    margin: 0;
    max-width: 400px;
    margin: 0 auto;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .blog-grid {
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
    }
    
    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .blog-container {
        padding: 16px;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .blog-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .search-input {
        padding: 14px 18px;
        padding-right: 56px;
    }
    
    .search-button {
        width: 40px;
        height: 40px;
    }
    
    .blog-content {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .section-title {
        font-size: 1.5rem;
    }
    
    .blog-content {
        padding: 16px;
    }
    
    .blog-title {
        font-size: 1.2rem;
    }
    
    .blog-image-container {
        height: 180px;
    }
}

/* Animation for reveal */
[data-reveal] {
    opacity: 0;
    transform: translateY(30px);
    animation: reveal 0.8s ease forwards;
}

[data-reveal]:nth-child(2) { animation-delay: 0.1s; }
[data-reveal]:nth-child(3) { animation-delay: 0.2s; }
[data-reveal]:nth-child(4) { animation-delay: 0.3s; }

@keyframes reveal {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    .blog-card:hover {
        transform: none;
    }
    
    .blog-card:active {
        transform: translateY(-4px);
    }
    
    .blog-overlay {
        opacity: 0.3;
    }
    
    .read-more {
        transform: translateY(0);
    }
}

/* Hover effects for non-touch devices */
@media (hover: hover) {
    .blog-card:hover .blog-overlay {
        opacity: 1;
    }
    
    .blog-card:hover .read-more {
        transform: translateY(0);
    }
}
</style>