@extends('layouts.seo')

@section('title', $campaign->title . ' - ' . __('app.site_name'))

@section('content')
<div class="container">
    <div class="main-campaign" style="margin: 40px 0;">
        <div class="campaign-content">
            <div class="campaign-header">
                <div class="campaign-badge">
                    🚨 حملة عاجلة
                </div>
                <h1 class="campaign-title">{{ $campaign->title }}</h1>
                <p class="campaign-subtitle">{{ $campaign->subtitle }}</p>
            </div>
            
            <div class="campaign-grid">
                <div>
                    <p class="campaign-description">{{ $campaign->description }}</p>
                    
                    <div class="urgent-needs">
                        <h4 class="needs-title">
                            🎯 الاحتياجات الأساسية العاجلة
                        </h4>
                        <div class="needs-list">
                            @foreach($campaign->urgent_needs as $need)
                                <div class="need-item">{{ $need }}</div>
                            @endforeach
                        </div>
                    </div>

                    <div class="campaign-cta">
                        <button type="button" class="btn-donate" onclick="showDonationModal()">
                            💝 تبرع الآن
                        </button>
                        <button type="button" class="btn-share" onclick="shareCampaign()">
                            📢 شارك الحملة
                        </button>
                    </div>
                </div>

                <div class="progress-section">
                    <div class="progress-header">
                        <span class="progress-amount">${{ number_format($campaign->collected_amount) }}</span>
                        <span class="progress-goal">من ${{ number_format($campaign->goal_amount) }}</span>
                    </div>
                    
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $campaign->percentage }}%"></div>
                    </div>
                    
                    <div class="progress-percentage">
                        {{ $campaign->percentage }}% من الهدف المطلوب
                    </div>

                    <div class="campaign-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($campaign->supporters_count) }}</div>
                            <div class="stat-label">متبرع</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $campaign->days_left }}</div>
                            <div class="stat-label">يوم متبقي</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">${{ number_format($campaign->remaining_amount) }}</div>
                            <div class="stat-label">مطلوب</div>
                        </div>
                    </div>

                    <div class="urgency-notice">
                        <div class="urgency-notice-title">
                            ⏰ كل دقيقة تأخير تعني معاناة أكثر
                        </div>
                        <div class="urgency-notice-text">
                            تبرعك اليوم يصل فوراً للمحتاجين
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal التبرع -->
<div id="donationModal" class="donation-modal" style="display: none;">
    <div class="donation-modal-content">
        <div class="donation-modal-header">
            <h3>{{ __('app.support.title') }}</h3>
            <span class="donation-modal-close" onclick="closeDonationModal()">&times;</span>
        </div>
        
        <div class="donation-modal-body">
            <div class="donation-methods">
                <!-- QR Code PayPal -->
                <div class="donation-method">
                    <div class="method-header">
                        <h4>{{ __('app.support.qr.title') }}</h4>
                        <p>{{ __('app.support.qr.description') }}</p>
                    </div>
                    <div class="qr-container">
                        @if($campaign->paypal_qr_code)
                            <img src="{{ asset('storage/' . $campaign->paypal_qr_code) }}" 
                                 alt="PayPal QR Code" 
                                 class="qr-code">
                        @else
                            <div class="qr-placeholder">
                                <i class="fas fa-qrcode"></i>
                                <p>QR Code غير متوفر</p>
                            </div>
                        @endif
                    </div>
                    <div class="method-features">
                        <span class="feature">{{ __('app.support.qr.features.fast') }}</span>
                        <span class="feature">{{ __('app.support.qr.features.secure') }}</span>
                        <span class="feature">{{ __('app.support.qr.features.trusted') }}</span>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="donation-method">
                    <div class="method-header">
                        <h4>{{ __('app.support.whatsapp.title') }}</h4>
                        <p>{{ __('app.support.whatsapp.description') }}</p>
                    </div>
                    <div class="whatsapp-container">
                        <a href="https://wa.me/{{ $campaign->whatsapp_number }}" 
                           target="_blank" 
                           class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i>
                            {{ __('app.support.whatsapp.contact_now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="donation-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDonationModal()">
                {{ __('app.support.modal.close') }}
            </button>
        </div>
    </div>
</div>

<script>
    function showDonationModal() {
        document.getElementById('donationModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeDonationModal() {
        document.getElementById('donationModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function shareCampaign() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $campaign->title }}',
                text: '{{ $campaign->subtitle }}',
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            const url = window.location.href;
            const text = '{{ $campaign->title }} - {{ $campaign->subtitle }}';
            window.open(`https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`);
        }
    }

    // إغلاق Modal عند النقر خارجه
    window.onclick = function(event) {
        const modal = document.getElementById('donationModal');
        if (event.target === modal) {
            closeDonationModal();
        }
    }

    // إغلاق Modal بمفتاح ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDonationModal();
        }
    });
</script>
@endsection
