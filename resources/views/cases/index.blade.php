@extends('layouts.seo')

@section('title', __('app.sections.urgent_appeals') . ' -- ' . __('app.site_name'))

@section('content')
<div class="cases-container">
    <header class="page-header" data-reveal>
        <h1 class="section-title">{{ __('app.sections.urgent_appeals') }}</h1>
        <p class="section-description">{{ __('app.descriptions.urgent_appeals_description') }}</p>
    </header>

    <div class="search-section" data-reveal>
        <form method="get" class="search-form">
            <div class="search-input-wrapper">
                <input type="text" 
                       name="q" 
                       value="{{ $q }}" 
                       placeholder="{{ __('app.forms.search_case_placeholder') }}"
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

    <div class="cases-grid" data-reveal>
        @forelse($cases as $case)
            <article class="case-card clickable-card" onclick="window.location.href='{{ route('cases.show', $case->slug) }}'">
                <div class="case-image-container">
                    @if($case->cover_image_path)
                        <img src="{{ asset('storage/'.$case->cover_image_path) }}" 
                             alt="{{ $case->title }}" 
                             class="case-image"
                             loading="lazy">
                    @else
                        <div class="case-placeholder">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                        </div>
                    @endif
                    
                    @if($case->is_completed)
                        <div class="completion-badge">
                            <span class="badge-text">{{ __('app.messages.case_completed') }}</span>
                            <span class="badge-icon">✅</span>
                        </div>
                    @endif
                </div>
                
                <div class="case-content">
                    <h3 class="case-title">{{ $case->title }}</h3>
                    
                    <div class="case-progress">
                        <div class="progress-info">
                            <span class="progress-label">{{ __('app.amount_of.collected') }}:</span>
                            <span class="progress-amount">${{ number_format($case->collected_amount, 2) }}</span>
                        </div>
                        
                        <div class="progress-goal">
                            <span class="goal-label">{{ __('app.amount_of.from') }}</span>
                            <span class="goal-amount">
                                @if($case->goal_amount)
                                    ${{ number_format($case->goal_amount, 2) }}
                                @else
                                    {{ __('app.amount_of.no_goal_set') }}
                                @endif
                            </span>
                        </div>
                        
                        @if($case->goal_amount && $case->goal_amount > 0)
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ min(100, ($case->collected_amount / $case->goal_amount) * 100) }}%"></div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="case-meta">
                        <span class="case-date">{{ $case->created_at->format('M d, Y') }}</span>
                        <span class="case-status {{ $case->is_completed ? 'completed' : 'active' }}">
                            {{ $case->is_completed ? __('app.status.completed') : __('app.status.active') }}
                        </span>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M9 12l2 2 4-4"/>
                        <path d="M21 12c-1 0-2-1-2-2s1-2 2-2 2 1 2 2-1 2-2 2z"/>
                        <path d="M3 12c1 0 2-1 2-2s-1-2-2-2-2 1-2 2 1 2 2 2z"/>
                        <path d="M12 3c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                        <path d="M12 21c0-1 1-2 2-2s2 1 2 2-1 2-2 2-2-1-2-2z"/>
                    </svg>
                </div>
                <h3 class="empty-title">{{ __('app.empty_states.no_cases_title') }}</h3>
                <p class="empty-description">{{ __('app.empty_states.no_cases') }}</p>
            </div>
        @endforelse
    </div>

    @if($cases->hasPages())
        <div class="pagination-wrapper" data-reveal>
            {{ $cases->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

<style>
.cases-container {
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

.cases-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.case-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    cursor: pointer;
}

.case-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    border-color: var(--red);
}

.case-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.case-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.case-card:hover .case-image {
    transform: scale(1.1);
}

.case-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--muted);
}

.completion-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(46, 125, 50, 0.9);
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    backdrop-filter: blur(10px);
}

.badge-icon {
    font-size: 14px;
}

.case-content {
    padding: 20px;
}

.case-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 16px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.case-progress {
    margin-bottom: 16px;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.progress-label {
    font-size: 14px;
    color: var(--muted);
}

.progress-amount {
    font-size: 16px;
    font-weight: 600;
    color: var(--red);
}

.progress-goal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.goal-label {
    font-size: 14px;
    color: var(--muted);
}

.goal-amount {
    font-size: 14px;
    color: var(--black);
    font-weight: 500;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--red) 0%, #d63384 100%);
    border-radius: 3px;
    transition: width 0.6s ease;
}

.case-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.case-date {
    font-size: 14px;
    color: var(--muted);
}

.case-status {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.case-status.active {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.case-status.completed {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
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
    .cases-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .cases-container {
        padding: 16px;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .cases-grid {
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
}

@media (max-width: 480px) {
    .section-title {
        font-size: 1.5rem;
    }
    
    .case-content {
        padding: 16px;
    }
    
    .case-title {
        font-size: 1.1rem;
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
    .case-card:hover {
        transform: none;
    }
    
    .case-card:active {
        transform: translateY(-4px);
    }
}
</style>