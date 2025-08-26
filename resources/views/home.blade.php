@extends('layouts.app')

@section('title', __('app.nav.home') . ' - ' . __('app.site_name'))

@section('hero')

<style>
    .hero {
        position: relative;
        padding-bottom: 40px;
    }
    .visual img {
        position: absolute;
        bottom: -90px;
        right: 0;
        width: 300px;
        height: auto;
    }
    .main-campaign {
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
        border-radius: 20px;
        overflow: hidden;
        margin: 60px 0 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        position: relative;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .main-campaign::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }
    .campaign-content {
        position: relative;
        z-index: 1;
        color: white;
        padding: 32px;
    }
    .campaign-header {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .campaign-badge {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .campaign-title {
        font-size: 36px;
        font-weight: 900;
        line-height: 1.2;
        margin: 0 0 12px;
        background: linear-gradient(45deg, #ffffff, #f0f9ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .campaign-subtitle {
        font-size: 18px;
        opacity: 0.9;
        margin: 0 0 16px;
        line-height: 1.5;
    }
    .campaign-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 40px;
        align-items: start;
    }
    .campaign-description {
        font-size: 16px;
        opacity: 0.85;
        margin: 0 0 24px;
        line-height: 1.6;
    }
    .progress-section {
        background: rgba(255,255,255,0.08);
        padding: 28px;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .progress-amount {
        font-weight: 900;
        font-size: 24px;
        color: #10b981;
    }
    .progress-goal {
        opacity: 0.8;
        font-size: 14px;
    }
    .progress-bar {
        background: rgba(255,255,255,0.15);
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
        margin: 16px 0;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #059669);
        border-radius: 5px;
        transition: width 2s ease;
        position: relative;
    }
    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
    .progress-percentage {
        text-align: center;
        margin: 12px 0;
        font-size: 16px;
        font-weight: 700;
        color: #10b981;
    }
    .campaign-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin: 24px 0;
    }
    .stat-item {
        text-align: center;
        padding: 20px 12px;
        background: rgba(255,255,255,0.08);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .stat-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
        border-color: rgba(255,255,255,0.25);
    }
    .stat-item:hover::before {
        opacity: 1;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 900;
        margin: 0 0 8px;
        color: #10b981;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        letter-spacing: -0.5px;
        position: relative;
        z-index: 1;
    }
    .stat-label {
        font-size: 10px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        position: relative;
        z-index: 1;
    }

    /* Responsive Design for Campaign Stats */
    @media (max-width: 768px) {
        .campaign-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .stat-item {
            padding: 16px 10px;
        }
        .stat-value {
            font-size: 20px;
        }
        .stat-label {
            font-size: 9px;
            letter-spacing: 0.5px;
        }
    }

    @media (max-width: 480px) {
        .campaign-stats {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .stat-item {
            padding: 14px 12px;
        }
        .stat-value {
            font-size: 18px;
        }
        .stat-label {
            font-size: 8px;
            letter-spacing: 0.3px;
        }
    }
    .urgent-needs {
        margin: 24px 0;
        padding: 20px;
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .needs-title {
        margin: 0 0 12px;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .needs-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }
    .need-item {
        display: flex;
        align-items: center;
        font-size: 14px;
        opacity: 0.9;
        padding: 4px 0;
    }
    .need-item::before {
        content: '💚';
        margin-left: 8px;
        font-size: 12px;
    }
    .campaign-cta {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 24px;
    }
    .btn-donate {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        padding: 16px 32px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }
    .btn-donate::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .btn-donate:hover::before {
        left: 100%;
    }
    .btn-donate:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(220, 38, 38, 0.4);
    }
    .btn-share {
        background: rgba(255,255,255,0.1);
        color: white;
        padding: 16px 24px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-share:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-1px);
    }
    .urgency-notice {
        margin-top: 20px;
        padding: 16px;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.1));
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .urgency-notice-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #fca5a5;
    }
    .urgency-notice-text {
        font-size: 12px;
        opacity: 0.9;
    }
    @media (max-width: 968px) {
        .campaign-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .campaign-content {
            padding: 24px;
        }
        .campaign-title {
            font-size: 28px;
        }
        .campaign-stats {
            grid-template-columns: repeat(3, 1fr);
        }
        .needs-list {
            grid-template-columns: 1fr;
        }
        .campaign-cta {
            flex-direction: column;
            align-items: stretch;
        }
    }
    @media (max-width: 640px) {
        .main-campaign {
            margin: 40px -16px;
            border-radius: 0;
        }
        .campaign-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Modal التبرع */
    .donation-modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .donation-modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 20px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .donation-modal-header {
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
        color: white;
        padding: 24px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .donation-modal-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .donation-modal-close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
        transition: opacity 0.3s;
    }

    .donation-modal-close:hover {
        opacity: 0.7;
    }

    .donation-modal-body {
        padding: 32px;
    }

    .donation-methods {
        display: grid;
        gap: 32px;
    }

    .donation-method {
        text-align: center;
        padding: 24px;
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .donation-method:hover {
        border-color: #1a472a;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26, 71, 42, 0.1);
    }

    .method-header h4 {
        margin: 0 0 12px;
        font-size: 20px;
        font-weight: 700;
        color: #1a472a;
    }

    .method-header p {
        margin: 0 0 20px;
        color: #64748b;
        line-height: 1.5;
    }

    .qr-container {
        margin: 20px 0;
        display: flex;
        justify-content: center;
    }

    .qr-code {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border: 4px solid white;
    }

    .qr-placeholder {
        width: 200px;
        height: 200px;
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #64748b;
    }

    .qr-placeholder i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .method-features {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: 20px;
    }

    .feature {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .whatsapp-container {
        margin: 20px 0;
    }

    .whatsapp-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: #25d366;
        color: white;
        padding: 16px 32px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(37, 211, 102, 0.3);
    }

    .whatsapp-btn:hover {
        background: #128c7e;
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(37, 211, 102, 0.4);
    }

    .whatsapp-btn i {
        font-size: 20px;
    }

    .donation-modal-footer {
        padding: 24px 32px;
        background: #f8fafc;
        border-radius: 0 0 20px 20px;
        text-align: center;
    }

    .btn-secondary {
        background: #64748b;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-secondary:hover {
        background: #475569;
    }

    @media (max-width: 640px) {
        .donation-modal-content {
            margin: 10% auto;
            width: 95%;
        }
        
        .donation-modal-body {
            padding: 24px;
        }
        
        .donation-methods {
            gap: 24px;
        }
        
        .qr-code, .qr-placeholder {
            width: 150px;
            height: 150px;
        }
    }

    /* ستايلات قسم حملة ال1000 سفينة - تصميم محسن ومتناسق */
    .ship-campaign-section {
        margin: 60px 0;
        padding: 40px 0;
    }

    .campaign-card {
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 40px;
        max-width: 900px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .campaign-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .campaign-icon {
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .ship-emoji {
        font-size: 80px;
        display: block;
        animation: float 3s ease-in-out infinite;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .campaign-content {
        flex: 1;
        position: relative;
        z-index: 1;
        color: white;
    }

    .campaign-title {
        font-size: 32px;
        font-weight: 900;
        margin: 0 0 16px 0;
        line-height: 1.2;
        background: linear-gradient(45deg, #ffffff, #f0f9ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .campaign-description {
        font-size: 18px;
        opacity: 0.9;
        line-height: 1.6;
        margin: 0 0 24px 0;
    }

    .campaign-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .campaign-actions .btn {
        padding: 14px 28px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .campaign-actions .btn-primary {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .campaign-actions .btn-primary:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .language-switch {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .lang-link {
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .lang-link:hover {
        color: #1e40af;
        background: #f1f5f9;
    }

    .lang-link.active {
        color: #1e40af;
        background: #dbeafe;
    }

    .separator {
        color: #cbd5e1;
        font-weight: 300;
    }

    /* تصميم متجاوب */
    @media (max-width: 768px) {
        .ship-campaign-section {
            margin: 40px 0;
            padding: 20px 0;
        }

        .campaign-card {
            flex-direction: column;
            text-align: center;
            padding: 32px 24px;
            gap: 24px;
        }

        .campaign-title {
            font-size: 28px;
        }

        .campaign-actions {
            justify-content: center;
        }

        .ship-emoji {
            font-size: 60px;
        }
    }

    @media (max-width: 480px) {
        .campaign-card {
            padding: 24px 20px;
        }

        .campaign-title {
            font-size: 24px;
        }

        .campaign-description {
            font-size: 16px;
        }

        .campaign-actions .btn {
            padding: 12px 24px;
            font-size: 15px;
        }
    }
</style>

    <div class="container hero">
        <div>
            <h1 class="hero-title">{{ __('app.hero.title_line1') }}<br>{{ __('app.hero.title_line2') }}</h1>
            <p class="hero-sub">{{ __('app.hero.subtitle') }}</p>
            <div class="cta-row">
                <a class="btn btn-primary" href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('cases.index') }}">{{ __('app.hero.explore_appeals') }}</a>
                <a class="btn btn-ghost" href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('posts.index') }}">{{ __('app.hero.pulse_cause') }}</a>
            </div>
        </div>
        <div class="visual">
            <img src="{{ asset('storage/img/hand_flag_transparent.png') }}" alt="Hand with flag">
        </div>

    </div>
@endsection

@section('content')
    <!-- كارد الإحصائيات -->
    <div class="stats-card" aria-label="site stats">
        <div class="stat">
            <div class="v">{{ number_format($casesCount + 1000) }}</div>
            <div class="l">{{ __('app.stats.donors') }}</div>
            <div class="stat-description">{{ __('app.stats.total_donors') }}</div>
        </div>
        <div class="stat">
            <div class="v">{{ number_format($casesCount) }}</div>
            <div class="l">{{ __('app.stats.cases_need_help') }}</div>
            <div class="stat-description">{{ __('app.stats.cases_description') }}</div>
            </div>
        <div class="stat">
            <div class="v">${{ number_format($totalDonations, 0) }}</div>
            <div class="l">{{ __('app.stats.total_donations') }}</div>
            <div class="stat-description">{{ __('app.stats.amount_description') }}</div>
        </div>
    </div>

    <!-- الحملة الرئيسية لأيتام غزة -->
    <div class="container">
        <div class="main-campaign">
            <div class="campaign-content">
                <div class="campaign-header">
                    <div class="campaign-badge">
                        🚨 {{ __('app.campaign.urgent_campaign') }}
                    </div>
                    <h2 class="campaign-title">{{ $mainCampaign->title }}</h2>
                    <p class="campaign-subtitle">{{ $mainCampaign->subtitle }}</p>
                </div>
                
                <div class="campaign-grid">
                    <div>
                        <p class="campaign-description">{{ $mainCampaign->description }}</p>
                        
                        <div class="urgent-needs">
                            <h4 class="needs-title">
                                🎯 {{ __('app.campaign.urgent_needs_title') }}
                            </h4>
                            <div class="needs-list">
                                @foreach($mainCampaign->urgent_needs as $need)
                                    <div class="need-item">{{ $need }}</div>
                                @endforeach
                            </div>
                        </div>

                        <div class="campaign-cta">
                            <button type="button" class="btn-donate" onclick="showDonationModal()">
                                💝 {{ __('app.campaign.donate_now') }}
                            </button>
                            <a href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('cases.index') }}" class="btn-share">
                                📢 {{ __('app.campaign.share_campaign') }}
                            </a>
                        </div>
                    </div>

                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-amount">${{ number_format($mainCampaign->collected_amount) }}</span>
                            <span class="progress-goal">{{ __('app.campaign.from') }} ${{ number_format($mainCampaign->goal_amount) }}</span>
                        </div>
                        
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $mainCampaign->percentage }}%"></div>
                        </div>
                        
                        <div class="progress-percentage">
                            {{ $mainCampaign->percentage }}% {{ __('app.campaign.goal_percentage') }}
                        </div>

                        <div class="campaign-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($mainCampaign->supporters_count) }}</div>
                                <div class="stat-label">{{ __('app.campaign.supporters') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $mainCampaign->days_left }}</div>
                                <div class="stat-label">{{ __('app.campaign.days_left') }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">${{ number_format($mainCampaign->goal_amount - $mainCampaign->collected_amount) }}</div>
                                <div class="stat-label">{{ __('app.campaign.required') }}</div>
                            </div>
                        </div>

                        <div class="urgency-notice">
                            <div class="urgency-notice-title">
                                ⏰ {{ __('app.campaign.urgency_title') }}
                            </div>
                            <div class="urgency-notice-text">
                                {{ __('app.campaign.urgency_text') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="grid grid-2" style="align-items:start;margin-top:40px">
        <div>
            <h2 class="section-title">{{ __('app.sections.share_causes') }}</h2>
            <p class="lead">{{ __('app.sections.share_description') }}</p>
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:8px">
                <a class="btn btn-dark" href="{{ route('cases.index') }}">{{ __('app.buttons.all_appeals') }}</a>
                <a class="btn btn-green" href="{{ route('posts.index') }}">{{ __('app.buttons.all_posts') }}</a>
            </div>
        </div>
        <div>
            @if($latestCases->first())
                @php $c = $latestCases->first(); @endphp
                <article class="card">
                    @if($c->cover_image_path)
                        <img src="{{ asset('storage/'.$c->cover_image_path) }}" alt="{{ $c->title }}">
                    @endif
                    <div class="p">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px">
                            <h3 style="margin:0;font-size:22px;font-weight:900">{{ strtoupper(__('app.nav.cases')) }}</h3>
                            <span class="badge">{{ __('app.amount.collected') }}: ${{ number_format($c->collected_amount,2) }}</span>
                        </div>
                        <p class="muted" style="margin:6px 0 12px">{{ $c->title }}</p>
                        <a class="btn btn-green" href="{{ route('cases.show', $c->slug) }}">{{ __('app.buttons.support_now') }}</a>
                    </div>
                </article>
            @else
                <div class="card"><div class="p">{{ __('app.empty_states.no_cases') }}</div></div>
            @endif
        </div>
    </section>

    <section style="margin-top:38px">
        <h2 class="section-title">{{ __('app.sections.urgent_appeals') }}</h2>
        <div class="grid grid-3">
            @forelse($latestCases as $case)
                <article class="card clickable-card" onclick="window.location.href='{{ route('cases.show', $case->slug) }}'">
                    @if($case->cover_image_path)
                        <img src="{{ asset('storage/'.$case->cover_image_path) }}" alt="{{ $case->title }}">
                    @endif
                    <div class="p">
                        <h3 style="margin:0 0 6px;font-size:18px">{{ $case->title }}</h3>
                        <p class="muted" style="margin:0">{{ __('app.amount.collected') }}: ${{ number_format($case->collected_amount,2) }} {{ __('app.amount.from') }} {{ $case->goal_amount ? '$'.number_format($case->goal_amount,2) : __('app.amount.no_goal_set') }}</p>
                    </div>
                </article>
            @empty
                <div class="card"><div class="p">{{ __('app.empty_states.no_cases') }}</div></div>
            @endforelse
        </div>
        <div style="margin-top:14px">
            <a class="btn btn-dark" href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('cases.index') }}">{{ __('app.buttons.all_appeals') }}</a>
        </div>
    </section>

    <section style="margin-top:38px">
        <h2 class="section-title">{{ __('app.sections.pulse_cause') }}</h2>
        <div class="grid grid-3">
            @forelse($latestPosts as $post)
                <article class="card clickable-card" onclick="window.location.href='{{ route('posts.show', $post->slug) }}'">
                    @if($post->image_path)
                        <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}">
                    @endif
                    <div class="p">
                        <h3 style="margin:0 0 6px;font-size:18px">{{ $post->title }}</h3>
                        <p class="muted" style="margin:0">{{ $post->excerpt }}</p>
                    </div>
                </article>
            @empty
                <div class="card"><div class="p">{{ __('app.empty_states.no_posts') }}</div></div>
            @endforelse
        </div>
        <div style="margin-top:14px">
            <a class="btn btn-dark" href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('posts.index') }}">{{ __('app.buttons.all_posts') }}</a>
        </div>
    </section>

    <!-- قسم حملة ال1000 سفينة -->
    <section class="ship-campaign-section">
        <div class="container">
            <div class="campaign-card">
                <div class="campaign-icon">
                    <span class="ship-emoji">🚢</span>
                </div>
                <div class="campaign-content">
                    <h2 class="campaign-title">{{ __('app.ship_campaign.title') }}</h2>
                    <p class="campaign-description">{{ __('app.ship_campaign.description') }}</p>
                    <div class="campaign-actions">
                        <a href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('ship-campaign') }}" class="btn btn-primary">
                            {{ __('app.ship_campaign.form.submit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            @if($mainCampaign->paypal_qr_code)
                                <img src="{{ asset('storage/' . $mainCampaign->paypal_qr_code) }}" 
                                     alt="PayPal QR Code" 
                                     class="qr-code">
                            @else
                                <div class="qr-placeholder">
                                    <i class="fas fa-qrcode"></i>
                                    <p>{{ __('app.support.qr.not_available') }}</p>
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
                            <a href="https://wa.me/{{ $mainCampaign->whatsapp_number ?? '970599123456' }}" 
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