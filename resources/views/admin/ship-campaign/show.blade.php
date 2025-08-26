@extends('admin.layouts.admin')

@section('title', __('app.admin.ship_campaign') . ' - ' . __('app.admin.view') . ' - ' . __('app.admin.site_name'))

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="header-left">
            <a href="{{ route('admin.ship-campaign.index') }}" class="btn btn-secondary">
                ← {{ __('app.admin.back_to_list') }}
            </a>
            <h1>{{ __('app.admin.ship_campaign') }} - {{ __('app.admin.view') }}</h1>
        </div>
        <div class="admin-actions">
            <button type="button" class="btn btn-danger" onclick="deleteSurvey({{ $survey->id }})">
                🗑️ {{ __('app.admin.delete') }}
            </button>
        </div>
    </div>

    <div class="survey-details">
        <div class="participant-info-section">
            <h2>{{ __('app.admin.participant_info') }}</h2>
            <div class="info-grid">
                <div class="info-item">
                    <label>{{ __('app.admin.name') }}:</label>
                    <span>{{ $survey->full_name }}</span>
                </div>
                <div class="info-item">
                    <label>{{ __('app.admin.age') }}:</label>
                    <span>{{ $survey->age }}</span>
                </div>
                <div class="info-item">
                    <label>{{ __('app.admin.whatsapp_number') }}:</label>
                    <span>
                        @if($survey->whatsapp_number)
                            <a href="https://wa.me/{{ $survey->whatsapp_number }}" target="_blank" class="whatsapp-link">
                                {{ $survey->whatsapp_number }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <label>{{ __('app.admin.email') }}:</label>
                    <span>
                        @if($survey->email)
                            <a href="mailto:{{ $survey->email }}" class="email-link">
                                {{ $survey->email }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <label>{{ __('app.admin.date') }}:</label>
                    <span>{{ $survey->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>
        </div>

        <div class="questions-section">
            <h2>{{ __('app.admin.questions') }}</h2>
            <div class="question-list">
                <div class="question-item">
                    <h3>{{ __('app.ship_campaign.form.questions.question1') }}</h3>
                    <div class="answer">{{ $survey->question1_answer }}</div>
                </div>

                <div class="question-item">
                    <h3>{{ __('app.ship_campaign.form.questions.question2') }}</h3>
                    <div class="answer">{{ $survey->question2_answer }}</div>
                </div>

                <div class="question-item">
                    <h3>{{ __('app.ship_campaign.form.questions.question3') }}</h3>
                    <div class="answer">{{ $survey->question3_answer }}</div>
                </div>

                <div class="question-item">
                    <h3>{{ __('app.ship_campaign.form.questions.question4') }}</h3>
                    <div class="answer">{{ $survey->question4_answer }}</div>
                </div>

                <div class="question-item">
                    <h3>{{ __('app.ship_campaign.form.questions.question5') }}</h3>
                    <div class="answer">{{ $survey->question5_answer }}</div>
                </div>
            </div>
        </div>

        <div class="metadata-section">
            <h2>{{ __('app.admin.metadata') }}</h2>
            <div class="metadata-grid">
                <div class="metadata-item">
                    <label>{{ __('app.admin.created_at') }}:</label>
                    <span>{{ $survey->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="metadata-item">
                    <label>{{ __('app.admin.updated_at') }}:</label>
                    <span>{{ $survey->updated_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="metadata-item">
                    <label>{{ __('app.admin.id') }}:</label>
                    <span>{{ $survey->id }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-container {
    padding: 24px;
    max-width: 1000px;
    margin: 0 auto;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e5e7eb;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-left h1 {
    margin: 0;
    font-size: 32px;
    font-weight: 700;
    color: #1a472a;
}

.admin-actions {
    display: flex;
    gap: 12px;
}

.survey-details {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.participant-info-section,
.questions-section,
.metadata-section {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.participant-info-section h2,
.questions-section h2,
.metadata-section h2 {
    margin: 0;
    padding: 24px 24px 16px;
    font-size: 24px;
    font-weight: 700;
    color: #1a472a;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.info-grid,
.metadata-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 24px;
}

.info-item,
.metadata-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-item label,
.metadata-item label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item span,
.metadata-item span {
    font-size: 16px;
    color: #1f2937;
}

.question-list {
    padding: 24px;
}

.question-item {
    margin-bottom: 32px;
    padding: 20px;
    background: #f9fafb;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.question-item:last-child {
    margin-bottom: 0;
}

.question-item h3 {
    margin: 0 0 16px;
    font-size: 18px;
    font-weight: 600;
    color: #1a472a;
    line-height: 1.4;
}

.answer {
    font-size: 16px;
    line-height: 1.6;
    color: #374151;
    background: white;
    padding: 16px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    white-space: pre-wrap;
}

.whatsapp-link,
.email-link {
    color: #1a472a;
    text-decoration: none;
    font-weight: 500;
}

.whatsapp-link:hover,
.email-link:hover {
    text-decoration: underline;
}

.text-muted {
    color: #9ca3af;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

@media (max-width: 768px) {
    .admin-container {
        padding: 16px;
    }
    
    .admin-header {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        gap: 12px;
    }
    
    .info-grid,
    .metadata-grid {
        grid-template-columns: 1fr;
        gap: 16px;
        padding: 16px;
    }
    
    .question-list {
        padding: 16px;
    }
    
    .question-item {
        padding: 16px;
    }
}
</style>

<script>
function deleteSurvey(id) {
    if (confirm('{{ __("app.admin.confirm_delete") }}')) {
        fetch(`/admin-portal-walls-must/ship-campaign/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = '{{ route("admin.ship-campaign.index") }}';
            } else {
                alert('{{ __("app.messages.something_went_wrong") }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("app.messages.something_went_wrong") }}');
        });
    }
}
</script>
@endsection
