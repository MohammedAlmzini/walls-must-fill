@extends('layouts.app')

@section('title', __('app.ship_campaign.title') . ' - ' . __('app.site_name'))

@section('content')
<div class="container">
    <div class="ship-campaign-hero">
        <div class="hero-content">
            <h1 class="hero-title">{{ __('app.ship_campaign.title') }}</h1>
            <p class="hero-subtitle">{{ __('app.ship_campaign.subtitle') }}</p>
            <p class="hero-description">{{ __('app.ship_campaign.description') }}</p>
        </div>
        <div class="hero-visual">
            <div class="ship-icon">🚢</div>
        </div>
    </div>

    <div class="campaign-stats">
        <div class="stat-card">
            <div class="stat-number" id="totalParticipants">0</div>
            <div class="stat-label">{{ __('app.ship_campaign.stats.total_participants') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="participantsToday">0</div>
            <div class="stat-label">{{ __('app.ship_campaign.stats.participants_today') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">1000</div>
            <div class="stat-label">{{ __('app.ship_campaign.stats.goal') }}</div>
        </div>
    </div>

    <div class="survey-section">
        <div class="survey-container">
            <h2 class="survey-title">{{ __('app.ship_campaign.form.questions.title') }}</h2>
            
            <form id="surveyForm" class="survey-form">
                @csrf
                
                <div class="form-group">
                    <label for="first_name">{{ __('app.ship_campaign.form.first_name') }} *</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="last_name">{{ __('app.ship_campaign.form.last_name') }} *</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="whatsapp_number">{{ __('app.ship_campaign.form.whatsapp_number') }}</label>
                        <input type="text" id="whatsapp_number" name="whatsapp_number" placeholder="+970">
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('app.ship_campaign.form.email') }}</label>
                        <input type="email" id="email" name="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="age">{{ __('app.ship_campaign.form.age') }} *</label>
                    <input type="number" id="age" name="age" min="1" max="120" required>
                </div>

                <div class="questions-section">
                    <div class="form-group">
                        <label for="question1_answer">{{ __('app.ship_campaign.form.questions.question1') }} *</label>
                        <textarea id="question1_answer" name="question1_answer" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="question2_answer">{{ __('app.ship_campaign.form.questions.question2') }} *</label>
                        <textarea id="question2_answer" name="question2_answer" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="question3_answer">{{ __('app.ship_campaign.form.questions.question3') }} *</label>
                        <textarea id="question3_answer" name="question3_answer" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="question4_answer">{{ __('app.ship_campaign.form.questions.question4') }} *</label>
                        <textarea id="question4_answer" name="question4_answer" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="question5_answer">{{ __('app.ship_campaign.form.questions.question5') }} *</label>
                        <textarea id="question5_answer" name="question5_answer" rows="3" required></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        {{ __('app.ship_campaign.form.submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.ship-campaign-hero {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 40px;
    align-items: center;
    margin: 60px 0;
    padding: 40px;
    background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
    border-radius: 20px;
    color: white;
    position: relative;
    overflow: hidden;
}

.ship-campaign-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 48px;
    font-weight: 900;
    margin: 0 0 16px;
    background: linear-gradient(45deg, #ffffff, #f0f9ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-subtitle {
    font-size: 24px;
    margin: 0 0 16px;
    opacity: 0.9;
}

.hero-description {
    font-size: 18px;
    opacity: 0.8;
    line-height: 1.6;
    margin: 0;
}

.hero-visual {
    position: relative;
    z-index: 1;
}

.ship-icon {
    font-size: 120px;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.campaign-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin: 40px 0;
}

.stat-card {
    background: white;
    padding: 32px 24px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.15);
}

.stat-number {
    font-size: 36px;
    font-weight: 900;
    color: #1a472a;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 14px;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.survey-section {
    margin: 60px 0;
}

.survey-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
}

.survey-title {
    font-size: 32px;
    font-weight: 700;
    text-align: center;
    margin: 0 0 32px;
    color: #1a472a;
}

.survey-form {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.form-group label {
    font-weight: 600;
    color: #374151;
    font-size: 16px;
}

.form-group input,
.form-group textarea {
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #1a472a;
    box-shadow: 0 0 0 3px rgba(26, 71, 42, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.questions-section {
    background: #f9fafb;
    padding: 24px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.form-actions {
    text-align: center;
    margin-top: 16px;
}

.btn-submit {
    background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
    color: white;
    border: none;
    padding: 16px 32px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(26, 71, 42, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(26, 71, 42, 0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.alert {
    padding: 16px;
    border-radius: 8px;
    margin: 16px 0;
    font-weight: 600;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

@media (max-width: 768px) {
    .ship-campaign-hero {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 24px;
    }
    
    .hero-title {
        font-size: 32px;
    }
    
    .hero-subtitle {
        font-size: 20px;
    }
    
    .campaign-stats {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .survey-container {
        padding: 24px;
        margin: 0 16px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .ship-icon {
        font-size: 80px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('surveyForm');
    const submitBtn = form.querySelector('.btn-submit');
    
    // Load stats
    loadStats();
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (submitBtn.disabled) return;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'جاري الإرسال...';
        
        const formData = new FormData(form);
        
        fetch('{{ route("en.ship-campaign.submit") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                form.reset();
                loadStats(); // Refresh stats
            } else {
                showAlert(data.message || 'حدث خطأ أثناء إرسال الاستطلاع', 'error');
                if (data.errors) {
                    showFieldErrors(data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('حدث خطأ أثناء إرسال الاستطلاع', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = '{{ __("app.ship_campaign.form.submit") }}';
        });
    });
    
    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        
        const container = document.querySelector('.survey-container');
        container.insertBefore(alert, container.firstChild);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
    
    function showFieldErrors(errors) {
        Object.keys(errors).forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.style.borderColor = '#dc2626';
                input.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
                
                setTimeout(() => {
                    input.style.borderColor = '';
                    input.style.boxShadow = '';
                }, 3000);
            }
        });
    }
    
    function loadStats() {
        // Simulate loading stats - in real app, this would be an API call
        const totalParticipants = Math.floor(Math.random() * 1000) + 100;
        const participantsToday = Math.floor(Math.random() * 50) + 5;
        
        document.getElementById('totalParticipants').textContent = totalParticipants;
        document.getElementById('participantsToday').textContent = participantsToday;
    }
});
</script>
@endsection
