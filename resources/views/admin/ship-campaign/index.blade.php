@extends('admin.layouts.admin')

@section('title', __('app.admin.ship_campaign') . ' - ' . __('app.admin.site_name'))

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>{{ __('app.admin.ship_campaign') }}</h1>
        <div class="admin-actions">
            <a href="{{ route('admin.ship-campaign.export') }}" class="btn btn-success">
                📊 {{ __('app.admin.export_excel') }}
            </a>
        </div>
    </div>

    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-number">{{ $totalSurveys }}</div>
            <div class="stat-label">{{ __('app.admin.participants') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $surveys->where('created_at', '>=', now()->startOfDay())->count() }}</div>
            <div class="stat-label">{{ __('app.admin.participants') }} {{ __('app.admin.today') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format(($totalSurveys / 1000) * 100, 1) }}%</div>
            <div class="stat-label">{{ __('app.admin.progress') }}</div>
        </div>
    </div>

    <div class="admin-content">
        <div class="content-header">
            <div class="bulk-actions">
                <button type="button" class="btn btn-danger" onclick="bulkDelete()">
                    🗑️ {{ __('app.admin.bulk_delete') }}
                </button>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="{{ __('app.admin.search') }}..." onkeyup="filterTable()">
            </div>
        </div>

        <div class="table-container">
            <table class="admin-table" id="surveysTable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                        </th>
                        <th>{{ __('app.admin.name') }}</th>
                        <th>{{ __('app.admin.whatsapp_number') }}</th>
                        <th>{{ __('app.admin.email') }}</th>
                        <th>{{ __('app.admin.age') }}</th>
                        <th>{{ __('app.admin.date') }}</th>
                        <th>{{ __('app.admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surveys as $survey)
                    <tr data-id="{{ $survey->id }}">
                        <td>
                            <input type="checkbox" class="survey-checkbox" value="{{ $survey->id }}">
                        </td>
                        <td>
                            <div class="participant-info">
                                <div class="participant-name">{{ $survey->full_name }}</div>
                            </div>
                        </td>
                        <td>
                            @if($survey->whatsapp_number)
                                <a href="https://wa.me/{{ $survey->whatsapp_number }}" target="_blank" class="whatsapp-link">
                                    {{ $survey->whatsapp_number }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($survey->email)
                                <a href="mailto:{{ $survey->email }}" class="email-link">
                                    {{ $survey->email }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $survey->age }}</td>
                        <td>{{ $survey->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.ship-campaign.show', $survey) }}" class="btn btn-sm btn-info">
                                    👁️ {{ __('app.admin.view') }}
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteSurvey({{ $survey->id }})">
                                    🗑️ {{ __('app.admin.delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            {{ __('app.admin.no_records') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $surveys->links() }}
        </div>
    </div>
</div>

<style>
.admin-container {
    padding: 24px;
    max-width: 1400px;
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

.admin-header h1 {
    margin: 0;
    font-size: 32px;
    font-weight: 700;
    color: #1a472a;
}

.admin-actions {
    display: flex;
    gap: 12px;
}

.stats-overview {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
}

.stat-number {
    font-size: 32px;
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

.admin-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.bulk-actions {
    display: flex;
    gap: 12px;
}

.search-box input {
    padding: 8px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    width: 300px;
}

.search-box input:focus {
    outline: none;
    border-color: #1a472a;
}

.table-container {
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th,
.admin-table td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.admin-table th {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.admin-table tbody tr:hover {
    background: #f9fafb;
}

.participant-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.participant-name {
    font-weight: 600;
    color: #1a472a;
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

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-info {
    background: #3b82f6;
    color: white;
}

.btn-info:hover {
    background: #2563eb;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
}

.pagination-container {
    padding: 20px 24px;
    display: flex;
    justify-content: center;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
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
    
    .stats-overview {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .content-header {
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }
    
    .search-box input {
        width: 100%;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<script>
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.survey-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('surveysTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        row.style.display = found ? '' : 'none';
    }
}

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
                location.reload();
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

function bulkDelete() {
    const checkboxes = document.querySelectorAll('.survey-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        alert('{{ __("app.admin.select_records") }}');
        return;
    }
    
    if (confirm('{{ __("app.admin.confirm_delete") }}')) {
        fetch('/admin-portal-walls-must/ship-campaign/bulk-delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || '{{ __("app.messages.something_went_wrong") }}');
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
