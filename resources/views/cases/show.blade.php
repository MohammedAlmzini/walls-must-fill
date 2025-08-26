@extends('layouts.seo')

@section('title', $case->title . ' -- ' . __('app.sections.urgent_appeals'))

@section('content')
<div class="case-show-container">
    <!-- Case Header -->
    <header class="case-header" data-reveal>
        <div class="case-header-content">
            <div class="case-meta">
                <span class="case-status {{ $case->is_completed ? 'completed' : 'active' }}">
                    {{ $case->is_completed ? __('app.status.completed') : __('app.status.active') }}
                </span>
                <span class="case-date">{{ $case->created_at->format('M d, Y') }}</span>
            </div>
            <h1 class="case-title">{{ $case->title }}</h1>
        </div>
    </header>

    <!-- Case Cover Image -->
    @if($case->cover_image_path)
        <div class="case-cover" data-reveal>
            <img src="{{ asset('storage/'.$case->cover_image_path) }}" 
                 alt="{{ $case->title }}" 
                 class="cover-image"
                 loading="lazy">
        </div>
    @endif

    <!-- Case Content -->
    <div class="case-content-wrapper">
        <!-- Main Content -->
        <div class="case-main-content" data-reveal>
            <!-- Progress Section -->
            <div class="progress-section">
                <div class="progress-header">
                    <h2 class="progress-title">{{ __('app.campaign.urgent_campaign') }}</h2>
                    <p class="progress-subtitle">{{ __('app.campaign.urgency_title') }}</p>
                </div>
                
                <div class="progress-stats">
                    <div class="stat-item">
                        <span class="stat-label">{{ __('app.amount_of.collected') }}</span>
                        <span class="stat-value collected">${{ number_format($case->collected_amount, 2) }}</span>
                    </div>
                    
                    <div class="stat-item">
                        <span class="stat-label">{{ __('app.amount_of.from') }}</span>
                        <span class="stat-value goal">
                            @if($case->goal_amount)
                                ${{ number_format($case->goal_amount, 2) }}
                            @else
                                {{ __('app.amount_of.no_goal_set') }}
                            @endif
                        </span>
                    </div>
                </div>
                
                @if($case->goal_amount && $case->goal_amount > 0)
                    <div class="progress-bar-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ min(100, max(0, ($case->collected_amount / $case->goal_amount) * 100)) }}%"></div>
                        </div>
                        <div class="progress-percentage">
                            {{ number_format(min(100, max(0, ($case->collected_amount / $case->goal_amount) * 100)), 1) }}%
                        </div>
                        <div class="progress-details">
                            <span class="progress-collected">${{ number_format($case->collected_amount, 2) }}</span>
                            <span class="progress-separator">من</span>
                            <span class="progress-goal">${{ number_format($case->goal_amount, 2) }}</span>
                        </div>
                    </div>
                @else
                    <div class="no-goal-container">
                        <div class="no-goal-icon">🎯</div>
                        <p class="no-goal-text">{{ __('app.amount_of.no_goal_set') }}</p>
                        <p class="no-goal-description">{{ __('app.amount_of.no_goal_description') }}</p>
                    </div>
                @endif
                
                @if($case->is_completed)
                    <div class="completion-banner">
                        <span class="completion-icon">✅</span>
                        <span class="completion-text">{{ __('app.messages.case_completed') }}</span>
                    </div>
                @endif
            </div>

            <!-- Case Description -->
            <div class="case-description">
                <h3 class="description-title">{{ __('app.forms.description') }}</h3>
                <div class="description-content">
                    {!! nl2br(e($case->description)) !!}
                </div>
            </div>

            <!-- YouTube Video -->
            @if($case->youtube_embed_url)
                <div class="video-section" data-reveal>
                    <h3 class="video-title">{{ __('app.post.video') }}</h3>
                    <div class="video-container">
                        <iframe src="{{ $case->youtube_embed_url }}" 
                                title="YouTube video" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen 
                                referrerpolicy="strict-origin-when-cross-origin">
                        </iframe>
                    </div>
                </div>
            @endif

            <!-- Image Gallery -->
            @if($case->images && $case->images->count())
                <div class="gallery-section" data-reveal>
                    <h3 class="gallery-title">{{ __('app.gallery.title') }}</h3>
                    <div class="image-gallery">
                        @foreach($case->images as $img)
                            <div class="gallery-item" onclick="openImageModal('{{ asset('storage/'.$img->image_path) }}', '{{ $case->title }}')">
                                <img src="{{ asset('storage/'.$img->image_path) }}" 
                                     alt="{{ __('app.gallery.case_image') }}" 
                                     class="gallery-image"
                                     loading="lazy">
                                <div class="gallery-overlay">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Support Sidebar -->
        @if($case->qr_image_path || $case->whatsapp_link)
            <aside class="support-sidebar" data-reveal>
                <div class="support-card">
                    <div class="support-header">
                        <h3 class="support-title">🎯 {{ __('app.support.title') }}</h3>
                        <p class="support-subtitle">{{ __('app.support.subtitle') }}</p>
                    </div>

                    <div class="support-methods">
                        @if($case->qr_image_path)
                            <div class="support-method qr-method">
                                <div class="method-icon">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                        <path d="M10 3v4"></path>
                                        <path d="M10 17v4"></path>
                                        <path d="M3 10h4"></path>
                                        <path d="M17 10h4"></path>
                                    </svg>
                                </div>
                                <div class="method-content">
                                    <h4 class="method-title">{{ __('app.support.qr.title') }}</h4>
                                    <p class="method-description">{{ __('app.support.qr.description') }}</p>
                                    <div class="method-features">
                                        <span class="feature-badge">⚡ {{ __('app.support.qr.features.fast') }}</span>
                                        <span class="feature-badge">🔒 {{ __('app.support.qr.features.secure') }}</span>
                                        <span class="feature-badge">💯 {{ __('app.support.qr.features.trusted') }}</span>
                                    </div>
                                    
                                    <!-- QR Code Display -->
                                    <div class="qr-display" onclick="openQRModal('{{ asset('storage/'.$case->qr_image_path) }}', '{{ $case->title }}')">
                                        <div class="qr-container">
                                            <img src="{{ asset('storage/'.$case->qr_image_path) }}" 
                                                 alt="QR Code for {{ $case->title }}" 
                                                 class="qr-image">
                                            <div class="qr-overlay">
                                                <div class="qr-overlay-content">
                                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="11" cy="11" r="8"></circle>
                                                        <path d="m21 21-4.35-4.35"></path>
                                                    </svg>
                                                    <span class="qr-overlay-text">{{ __('app.support.qr.scan_to_donate') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="qr-hint">{{ __('app.support.qr.click_to_enlarge') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($case->whatsapp_link)
                            <div class="support-method whatsapp-method">
                                <div class="method-icon whatsapp">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 2L11 13"></path>
                                        <path d="M22 2L15 22L11 13L2 9L22 2Z"></path>
                                    </svg>
                                </div>
                                <div class="method-content">
                                    <h4 class="method-title">{{ __('app.support.whatsapp.title') }}</h4>
                                    <p class="method-description">{{ __('app.support.whatsapp.description') }}</p>
                                    <a class="whatsapp-btn" href="{{ $case->whatsapp_link }}" target="_blank" rel="noopener">
                                        {{ __('app.support.whatsapp.contact_now') }}
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="m9 18 6-6-6-6"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </aside>
        @endif
    </div>
</div>

<!-- QR Modal -->
<div id="qrModal" class="modal-overlay">
    <div class="modal-content qr-modal">
        <div class="modal-header">
            <h3 id="qrModalTitle">{{ __('app.support.qr.scan_to_donate') }}</h3>
            <button class="modal-close" onclick="closeQRModal()">×</button>
        </div>
        <div class="modal-body">
            <div class="qr-modal-content">
                <div class="qr-instructions">
                    <div class="instruction-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c-1 0-2-1-2-2s1-2 2-2 2 1 2 2-1 2-2 2z"/>
                            <path d="M3 12c1 0 2-1 2-2s-1-2-2-2-2 1-2 2 1 2 2 2z"/>
                            <path d="M12 3c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M12 21c0-1 1-2 2-2s2 1 2 2-1 2-2 2-2-1-2-2z"/>
                        </svg>
                    </div>
                    <h4 class="instruction-title">{{ __('app.support.qr.modal_title') }}</h4>
                    <p class="instruction-text">{{ __('app.support.qr.modal_description') }}</p>
                </div>
                
                <div class="qr-display-large">
                    <img id="qrModalImage" src="" alt="QR Code" class="qr-modal-image">
                    <div class="qr-scan-overlay">
                        <div class="scan-frame">
                            <div class="scan-corner top-left"></div>
                            <div class="scan-corner top-right"></div>
                            <div class="scan-corner bottom-left"></div>
                            <div class="scan-corner bottom-right"></div>
                        </div>
                    </div>
                </div>
                
                <div class="qr-steps">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h5 class="step-title">{{ __('app.support.qr.step1_title') }}</h5>
                            <p class="step-description">{{ __('app.support.qr.step1_description') }}</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h5 class="step-title">{{ __('app.support.qr.step2_title') }}</h5>
                            <p class="step-description">{{ __('app.support.qr.step2_description') }}</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h5 class="step-title">{{ __('app.support.qr.step3_title') }}</h5>
                            <p class="step-description">{{ __('app.support.qr.step3_description') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="qr-features-modal">
                    <div class="feature-item">
                        <span class="feature-icon">⚡</span>
                        <span class="feature-text">{{ __('app.support.qr.features.fast') }}</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🔒</span>
                        <span class="feature-text">{{ __('app.support.qr.features.secure') }}</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">💯</span>
                        <span class="feature-text">{{ __('app.support.qr.features.trusted') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal-overlay">
    <div class="modal-content image-modal">
        <div class="modal-header">
            <h3 id="imageModalTitle"></h3>
            <button class="modal-close" onclick="closeImageModal()">×</button>
        </div>
        <div class="modal-body">
            <img id="imageModalImage" src="" alt="Case Image" class="modal-image">
        </div>
    </div>
</div>

<script>
function openQRModal(src, title) {
    document.getElementById('qrModalImage').src = src;
    document.getElementById('qrModalTitle').textContent = title;
    document.getElementById('qrModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeQRModal() {
    document.getElementById('qrModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function openImageModal(src, title) {
    document.getElementById('imageModalImage').src = src;
    document.getElementById('imageModalTitle').textContent = title;
    document.getElementById('imageModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.style.display = 'none';
        });
        document.body.style.overflow = 'auto';
    }
});
</script>

<style>
:root {
    --red: #D32F2F;
    --black: #111;
    --muted: #5f6368;
    --surface: #ffffff;
    --border: #ececec;
}

.case-show-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Case Header */
.case-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 40px 20px;
    background: linear-gradient(135deg, rgba(211, 47, 47, 0.05) 0%, rgba(46, 125, 50, 0.05) 100%);
    border-radius: 20px;
}

.case-header-content {
    max-width: 800px;
    margin: 0 auto;
}

.case-meta {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.case-status {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
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

.case-date {
    color: var(--muted);
    font-size: 14px;
}

.case-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--red);
    margin: 0;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
}

.case-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--red) 0%, #d63384 100%);
    border-radius: 2px;
}

/* Case Cover */
.case-cover {
    margin-bottom: 30px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.cover-image {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
    display: block;
}

/* Case Content Layout */
.case-content-wrapper {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
    align-items: start;
}

/* Main Content */
.case-main-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

/* Progress Section */
.progress-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.progress-header {
    text-align: center;
    margin-bottom: 25px;
}

.progress-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 8px;
}

.progress-subtitle {
    color: var(--muted);
    margin: 0;
    font-size: 1rem;
}

.progress-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.stat-item {
    text-align: center;
    padding: 20px;
    background: rgba(211, 47, 47, 0.05);
    border-radius: 16px;
    border: 1px solid rgba(211, 47, 47, 0.1);
}

.stat-label {
    display: block;
    color: var(--muted);
    font-size: 14px;
    margin-bottom: 8px;
}

.stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
}

.stat-value.collected {
    color: var(--red);
}

.stat-value.goal {
    color: var(--black);
}

.progress-bar-container {
    margin-bottom: 20px;
}

.progress-bar {
    width: 100%;
    height: 12px;
    background: #e9ecef;
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 10px;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--red) 0%, #d63384 100%);
    border-radius: 6px;
    transition: width 0.8s ease;
}

.progress-percentage {
    text-align: center;
    font-size: 18px;
    font-weight: 600;
    color: var(--red);
}

.completion-banner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    padding: 16px;
    border-radius: 12px;
    border: 1px solid rgba(46, 125, 50, 0.2);
}

.completion-icon {
    font-size: 20px;
}

.completion-text {
    font-weight: 600;
    font-size: 16px;
}

/* Case Description */
.case-description {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.description-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 20px;
}

.description-content {
    color: var(--black);
    line-height: 1.8;
    font-size: 1.1rem;
}

/* Video Section */
.video-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.video-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 20px;
}

.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    border-radius: 16px;
    background: #000;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

/* Gallery Section */
.gallery-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.gallery-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 20px;
}

.image-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.gallery-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: scale(1.05);
}

.gallery-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

/* Support Sidebar */
.support-sidebar {
    position: sticky;
    top: 20px;
}

.support-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.support-header {
    text-align: center;
    margin-bottom: 25px;
}

.support-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 8px;
}

.support-subtitle {
    color: var(--muted);
    margin: 0;
    font-size: 1rem;
}

.support-methods {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.support-method {
    display: flex;
    gap: 16px;
    padding: 20px;
    background: rgba(211, 47, 47, 0.05);
    border-radius: 16px;
    border: 1px solid rgba(211, 47, 47, 0.1);
}

.method-icon {
    width: 48px;
    height: 48px;
    background: var(--red);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.method-icon.whatsapp {
    background: #25d366;
}

.method-content {
    flex: 1;
}

.method-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--black);
    margin: 0 0 8px;
}

.method-description {
    color: var(--muted);
    margin: 0 0 12px;
    font-size: 14px;
    line-height: 1.5;
}

.method-features {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.feature-badge {
    background: rgba(255, 255, 255, 0.8);
    color: var(--red);
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
}

.scan-qr-btn {
    background: var(--red);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.scan-qr-btn:hover {
    background: #c53030;
}

.whatsapp-btn {
    background: #25d366;
    color: white;
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.3s ease;
}

.whatsapp-btn:hover {
    background: #128c7e;
}

/* Modals */
.modal-overlay {
    display: none;
    position: fixed;
    z-index: 1000;
    inset: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 20px;
    max-width: 90vw;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    position: relative;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #eee;
    background: #fafafa;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.2rem;
    color: var(--black);
}

.modal-close {
    border: 0;
    background: transparent;
    font-size: 28px;
    cursor: pointer;
    color: #666;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.3s ease;
}

.modal-close:hover {
    background: #f0f0f0;
}

.modal-body {
    padding: 24px;
    text-align: center;
}

.modal-image {
    max-width: 100%;
    max-height: 70vh;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-hint {
    color: var(--muted);
    margin: 16px 0 0;
    font-size: 14px;
}

.image-modal .modal-content {
    max-width: 95vw;
}

.qr-modal .modal-content {
    max-width: 95vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.qr-modal-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
}

.qr-instructions {
    text-align: center;
    margin-bottom: 20px;
}

.instruction-icon {
    background: var(--red);
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
}

.instruction-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 8px;
}

.instruction-text {
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.6;
}

.qr-display-large {
    position: relative;
    width: 100%;
    height: 300px; /* Adjust height as needed */
    border-radius: 16px;
    overflow: hidden;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.qr-modal-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.qr-scan-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none; /* Allow clicks to pass through to the image */
}

.scan-frame {
    position: absolute;
    width: 80%;
    height: 80%;
    border: 2px solid var(--red);
    border-radius: 10px;
    box-sizing: border-box;
}

.scan-corner {
    position: absolute;
    width: 20px;
    height: 20px;
    background: var(--red);
    border-radius: 50%;
}

.top-left {
    top: 0;
    left: 0;
}

.top-right {
    top: 0;
    right: 0;
}

.bottom-left {
    bottom: 0;
    left: 0;
}

.bottom-right {
    bottom: 0;
    right: 0;
}

.qr-steps {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
    padding: 15px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.step-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.step-number {
    background: var(--red);
    color: white;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 600;
}

.step-content {
    flex: 1;
}

.step-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 4px;
}

.step-description {
    color: var(--muted);
    font-size: 0.8rem;
    line-height: 1.4;
}

.qr-features-modal {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
    padding: 15px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.feature-icon {
    font-size: 1.2rem;
    color: var(--red);
}

.feature-text {
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.6;
}

/* QR Code Display in Sidebar */
.qr-display {
    margin-top: 20px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.qr-display:hover {
    transform: scale(1.02);
}

.qr-container {
    position: relative;
    width: 100%;
    height: 200px;
    border-radius: 16px;
    overflow: hidden;
    background: #f8f9fa;
    border: 2px solid rgba(211, 47, 47, 0.2);
    transition: all 0.3s ease;
}

.qr-container:hover {
    border-color: var(--red);
    box-shadow: 0 10px 25px rgba(211, 47, 47, 0.15);
}

.qr-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 20px;
    background: white;
}

.qr-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(211, 47, 47, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.qr-container:hover .qr-overlay {
    opacity: 1;
}

.qr-overlay-content {
    text-align: center;
    color: white;
}

.qr-overlay-content svg {
    margin-bottom: 8px;
    color: white;
}

.qr-overlay-text {
    display: block;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
}

.qr-hint {
    text-align: center;
    color: var(--muted);
    font-size: 12px;
    margin: 8px 0 0;
    font-style: italic;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .case-content-wrapper {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .support-sidebar {
        position: static;
    }
    
    .case-title {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .case-show-container {
        padding: 16px;
    }
    
    .case-header {
        padding: 30px 20px;
    }
    
    .case-title {
        font-size: 1.75rem;
    }
    
    .progress-stats {
        grid-template-columns: 1fr;
    }
    
    .image-gallery {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
    }
    
    .support-method {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .case-title {
        font-size: 1.5rem;
    }
    
    .progress-section,
    .case-description,
    .video-section,
    .gallery-section,
    .support-card {
        padding: 20px;
    }
    
    .image-gallery {
        grid-template-columns: 1fr;
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
</style>
@endsection