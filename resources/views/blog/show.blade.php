@extends('layouts.app')

@section('content')
<article class="card" data-reveal>
    <div class="p">
        <h1 style="margin:0 0 8px">{{ $post->title }}</h1>

        @if($post->image_path)
            <div class="post-image-container">
                <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" class="post-image">
            </div>
        @endif

        @if($post->youtube_embed_url)
            <div style="margin:12px 0;">
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:10px;background:#000">
                    <iframe src="{{ $post->youtube_embed_url }}"
                            title="YouTube video"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            referrerpolicy="strict-origin-when-cross-origin"
                            style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"></iframe>
                </div>
            </div>
        @endif

        @if($post->excerpt)
            <div class="muted" style="margin:6px 0 14px;">{{ $post->excerpt }}</div>
        @endif

        <div>{!! $post->body !!}</div>
    </div>
</article>
@endsection

<style>
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow);
        margin: 22px auto;
        max-width: var(--container);
    }
    
    .p {
        padding: 30px;
    }
    
    h1 {
        font-size: 32px;
        color: var(--black);
        margin: 0 0 20px;
        line-height: 1.3;
    }
    
    /* تحسين عرض الصورة */
    .post-image-container {
        margin: 20px 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        background: #f8f9fa;
    }
    
    .post-image {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .post-image:hover {
        transform: scale(1.02);
    }
    
    /* تحسين عرض الفيديو */
    .youtube-container {
        margin: 20px 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    /* تحسين النص */
    .muted {
        color: var(--muted);
        font-size: 18px;
        line-height: 1.6;
        font-style: italic;
    }
    
    /* تحسين محتوى التدوينة */
    .post-content {
        line-height: 1.8;
        font-size: 16px;
        color: var(--ink);
    }
    
    .post-content h2,
    .post-content h3,
    .post-content h4 {
        color: var(--black);
        margin: 30px 0 15px;
    }
    
    .post-content p {
        margin: 0 0 20px;
    }
    
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    
    .post-content blockquote {
        border-left: 4px solid var(--red);
        padding-left: 20px;
        margin: 20px 0;
        font-style: italic;
        color: var(--muted);
    }
    
    .post-content ul,
    .post-content ol {
        margin: 20px 0;
        padding-left: 30px;
    }
    
    .post-content li {
        margin: 10px 0;
    }
    
    /* تحسينات للموبايل */
    @media (max-width: 768px) {
        .p {
            padding: 20px;
        }
        
        h1 {
            font-size: 24px;
        }
        
        .post-image {
            max-height: 300px;
        }
    }
</style>