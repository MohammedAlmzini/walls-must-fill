@extends('admin.layouts.admin')

@section('title', 'إدارة SEO')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">إدارة إعدادات SEO</h3>
                                         <a href="{{ route('admin.seo.create') }}" class="btn btn-primary" title="إضافة إعدادات SEO جديدة">
                         <i class="fas fa-plus-circle"></i> إضافة إعدادات جديدة
                     </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.seo.bulk-actions') }}" method="POST" id="bulk-form">
                        @csrf
                        <div class="bulk-actions mb-3">
                            <button type="submit" name="action" value="activate" class="btn btn-success btn-sm bulk-btn" onclick="return confirm('هل أنت متأكد من تفعيل العناصر المحددة؟')" title="تفعيل جميع العناصر المحددة">
                                <i class="fas fa-check-circle"></i> تفعيل المحدد
                            </button>
                            <button type="submit" name="action" value="deactivate" class="btn btn-warning btn-sm bulk-btn" onclick="return confirm('هل أنت متأكد من تعطيل العناصر المحددة؟')" title="تعطيل جميع العناصر المحددة">
                                <i class="fas fa-ban"></i> تعطيل المحدد
                            </button>
                            <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm bulk-btn" onclick="return confirm('هل أنت متأكد من حذف العناصر المحددة؟')" title="حذف جميع العناصر المحددة">
                                <i class="fas fa-trash-alt"></i> حذف المحدد
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped seo-table">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">
                                            <input type="checkbox" id="select-all" class="custom-checkbox">
                                        </th>
                                        <th><i class="fas fa-file-alt"></i> الصفحة</th>
                                        <th><i class="fas fa-language"></i> اللغة</th>
                                        <th><i class="fas fa-heading"></i> العنوان</th>
                                        <th><i class="fas fa-align-left"></i> الوصف</th>
                                        <th><i class="fas fa-toggle-on"></i> الحالة</th>
                                        <th><i class="fas fa-cogs"></i> الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($seoSettings as $pageKey => $settings)
                                        @foreach($settings as $setting)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="seo_settings[]" value="{{ $setting->id }}" class="seo-checkbox custom-checkbox">
                                                </td>
                                                <td>
                                                    <div class="page-info">
                                                        <strong><i class="fas fa-file-alt"></i> {{ $availablePages[$pageKey] ?? $pageKey }}</strong>
                                                        <br>
                                                        <small class="text-muted"><i class="fas fa-code"></i> {{ $pageKey }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-globe"></i> {{ $availableLocales[$setting->locale] ?? $setting->locale }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $setting->title }}">
                                                        {{ $setting->title }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 250px;" title="{{ $setting->description }}">
                                                        {{ $setting->description }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($setting->is_active)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> مفعل
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">
                                                            <i class="fas fa-times-circle"></i> معطل
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('admin.seo.preview', [$setting->page_key, $setting->locale]) }}" 
                                                           class="btn btn-info btn-sm action-btn" title="معاينة SEO">
                                                            <i class="fas fa-eye"></i>
                                                            <span class="btn-text">معاينة</span>
                                                        </a>
                                                        <a href="{{ route('admin.seo.edit', $setting->id) }}" 
                                                           class="btn btn-primary btn-sm action-btn" title="تعديل الإعدادات">
                                                            <i class="fas fa-edit"></i>
                                                            <span class="btn-text">تعديل</span>
                                                        </a>
                                                        <form action="{{ route('admin.seo.toggle', $setting->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm action-btn" title="{{ $setting->is_active ? 'تعطيل الصفحة' : 'تفعيل الصفحة' }}">
                                                                <i class="fas fa-{{ $setting->is_active ? 'ban' : 'check' }}"></i>
                                                                <span class="btn-text">{{ $setting->is_active ? 'تعطيل' : 'تفعيل' }}</span>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.seo.destroy', $setting->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm action-btn" 
                                                                    onclick="return confirm('هل أنت متأكد من حذف هذه الإعدادات؟')" title="حذف الإعدادات">
                                                                <i class="fas fa-trash"></i>
                                                                <span class="btn-text">حذف</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">لا توجد إعدادات SEO</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
    align-items: center;
}

.action-btn {
    min-width: 80px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 11px;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    gap: 5px;
    padding: 0 8px;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.action-btn i {
    font-size: 12px;
}

.btn-text {
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
    color: #212529;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 11px;
    padding: 6px 10px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-weight: 600;
}

.badge i {
    font-size: 12px;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-secondary {
    background-color: #6c757d;
    color: white;
}

.badge-info {
    background-color: #17a2b8;
    color: white;
}

.seo-table {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.seo-table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 15px 12px;
    font-weight: 600;
    text-align: center;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.seo-table thead th i {
    font-size: 16px;
    opacity: 0.9;
}

.seo-table tbody tr {
    transition: all 0.2s ease;
}

.seo-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
}

.seo-table td {
    padding: 12px;
    border-color: #e9ecef;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.container-fluid {
    padding: 20px;
}

.card {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border-radius: 12px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px 12px 0 0;
    padding: 20px;
}

.card-title {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.alert-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
    color: white;
}

.bulk-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.bulk-btn {
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.bulk-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.bulk-btn i {
    margin-left: 5px;
}

.custom-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #667eea;
    transform: scale(1.2);
}

.custom-checkbox:checked {
    animation: checkbox-pop 0.2s ease-in-out;
}

@keyframes checkbox-pop {
    0% { transform: scale(1.2); }
    50% { transform: scale(1.4); }
    100% { transform: scale(1.2); }
}

.text-center {
    text-align: center;
}

.page-info {
    text-align: center;
}

.page-info strong {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.page-info small {
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.page-info i {
    font-size: 12px;
    opacity: 0.8;
}
</style>

<script>
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.seo-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

document.querySelectorAll('.seo-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allChecked = document.querySelectorAll('.seo-checkbox:checked').length;
        const totalCheckboxes = document.querySelectorAll('.seo-checkbox').length;
        document.getElementById('select-all').checked = allChecked === totalCheckboxes;
        document.getElementById('select-all').indeterminate = allChecked > 0 && allChecked < totalCheckboxes;
    });
});
</script>
@endsection
