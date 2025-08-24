@extends('layouts.seo')

@section('title', __('app.sections.pulse_cause') . ' -- ' . __('app.site_name'))

@section('content')
<h1 data-reveal>{{ __('app.sections.pulse_cause') }}</h1>

<form method="get" style="margin:10px 0;" data-reveal>
    <div class="row">
        <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('app.forms.search_titles_placeholder') }}">
    </div>
</form>

<div class="grid cards" data-reveal>
    @forelse($posts as $post)
        <article class="card clickable-card" onclick="window.location.href='{{ route('posts.show', $post->slug) }}'">
            @if($post->image_path)
                <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" style="aspect-ratio:16/9; object-fit:cover;">
            @endif
            <div class="p">
                <h3 style="margin:0 0 6px;">{{ $post->title }}</h3>
                <p class="muted">{{ $post->excerpt }}</p>
            </div>
        </article>
    @empty
        <p class="muted">{{ __('app.empty_states.no_posts') }}</p>
    @endforelse
</div>

<div style="margin-top:12px;">
    {{ $posts->withQueryString()->links() }}
</div>
@endsection

<style>
    .grid {
        display: grid;
        gap: 14px;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    }
    
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .card .p {
        padding: 14px;
    }
    
    .card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    /* أنيميشن للكاردز القابلة للنقر */
    .clickable-card {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .clickable-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--red);
    }
    
    .clickable-card:hover img {
        transform: scale(1.05);
    }
    
    .clickable-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(211, 47, 47, 0.05) 0%, rgba(46, 125, 50, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .clickable-card:hover::before {
        opacity: 1;
    }
    
    .clickable-card:active {
        transform: translateY(-4px);
        transition: transform 0.1s ease;
    }
    
    .muted {
        color: var(--muted);
    }
    
    h1 {
        margin: 0 0 20px;
        font-size: 28px;
        color: var(--black);
    }
    
    form input {
        width: 300px;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 16px;
    }
    
    form input:focus {
        outline: none;
        border-color: var(--red);
        box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
    }
    
    .row {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    /* Responsive Design - Mobile & Tablet */
    
    /* Tablet Styles */
    @media (max-width: 1024px) {
        .grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 12px;
        }
        
        h1 {
            font-size: 24px;
        }
        
        form input {
            width: 250px;
        }
    }
    
    /* Mobile Styles */
    @media (max-width: 768px) {
        h1 {
            font-size: 20px;
            text-align: center;
        }
        
        .grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .card .p {
            padding: 16px;
        }
        
        .card img {
            height: 200px;
        }
        
        form {
            text-align: center;
            margin: 15px 0;
        }
        
        .row {
            justify-content: center;
        }
        
        form input {
            width: 100%;
            max-width: 300px;
            padding: 12px 16px;
        }
    }
    
    /* Small Mobile Styles */
    @media (max-width: 480px) {
        h1 {
            font-size: 18px;
        }
        
        .card .p {
            padding: 12px;
        }
        
        .card img {
            height: 180px;
        }
        
        form input {
            padding: 10px 14px;
            font-size: 14px;
        }
    }
    
    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .clickable-card {
            min-height: 200px;
        }
        
        .clickable-card:active {
            transform: translateY(-2px);
        }
    }
</style>