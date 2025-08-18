@extends('admin.layouts.admin')

@section('content')
    <div class="page-header">
        <h1>{{ $campaign->id ? 'تعديل الحملة الرئيسية' : 'إنشاء حملة رئيسية جديدة' }}</h1>
        <a href="{{ route('admin.main-campaign.index') }}" class="btn secondary">العودة للقائمة</a>
    </div>

    <div class="box">
        <form action="{{ route('admin.main-campaign.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <h3>المعلومات الأساسية</h3>
                    
                    <label for="title">عنوان الحملة *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $campaign->title) }}" required>
                    @error('title')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror

                    <label for="subtitle">العنوان الفرعي *</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $campaign->subtitle) }}" required>
                    @error('subtitle')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror

                    <label for="description">وصف الحملة *</label>
                    <textarea id="description" name="description" rows="4" required>{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror

                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $campaign->is_active) ? 'checked' : '' }}>
                        الحملة نشطة
                    </label>
                </div>

                <div>
                    <h3>المبالغ والإحصائيات</h3>
                    
                    <label for="goal_amount">المبلغ المطلوب *</label>
                    <input type="number" id="goal_amount" name="goal_amount" step="0.01" min="0" value="{{ old('goal_amount', $campaign->goal_amount) }}" required>
                    @error('goal_amount')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror

                    <label for="collected_amount">المبلغ المجموع *</label>
                    <input type="number" id="collected_amount" name="collected_amount" step="0.01" min="0" value="{{ old('collected_amount', $campaign->collected_amount) }}" required>
                    @error('collected_amount')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror

                    <label for="supporters_count">عدد المتبرعين *</label>
                    <input type="number" id="supporters_count" name="supporters_count" min="0" value="{{ old('supporters_count', $campaign->supporters_count) }}" required>
                    @error('supporters_count')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <h3>التواريخ</h3>
                    
                    <label for="start_date">تاريخ البداية</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $campaign->start_date ? $campaign->start_date->format('Y-m-d') : '') }}">
                    @error('start_date')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror

                    <label for="end_date">تاريخ الانتهاء</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $campaign->end_date ? $campaign->end_date->format('Y-m-d') : '') }}">
                    @error('end_date')
                        <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="margin-top: 20px;">
                <h3>معلومات التواصل</h3>
                
                <label for="whatsapp_number">رقم الواتساب *</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $campaign->whatsapp_number) }}" placeholder="+970599123456" required>
                @error('whatsapp_number')
                    <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                @enderror

                <label for="paypal_qr_code">QR Code PayPal</label>
                <input type="file" id="paypal_qr_code" name="paypal_qr_code" accept="image/*">
                @if($campaign->paypal_qr_code)
                    <div style="margin-top: 10px;">
                        <p>الصورة الحالية:</p>
                        <img src="{{ asset('storage/' . $campaign->paypal_qr_code) }}" alt="Current QR Code" style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
                @error('paypal_qr_code')
                    <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 20px;">
                <h3>الاحتياجات العاجلة</h3>
                <p style="color: #64748b; margin-bottom: 15px;">أضف الاحتياجات الأساسية العاجلة (سيتم عرضها في الصفحة الرئيسية)</p>
                
                <div id="urgent-needs-container">
                    @if(old('urgent_needs'))
                        @foreach(old('urgent_needs') as $index => $need)
                            <div class="need-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="urgent_needs[]" value="{{ $need }}" placeholder="مثال: طعام ومياه نظيفة" style="flex: 1;">
                                <button type="button" onclick="removeNeed(this)" class="btn danger" style="padding: 8px 12px;">حذف</button>
                            </div>
                        @endforeach
                    @elseif($campaign->urgent_needs)
                        @foreach($campaign->urgent_needs as $need)
                            <div class="need-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="urgent_needs[]" value="{{ $need }}" placeholder="مثال: طعام ومياه نظيفة" style="flex: 1;">
                                <button type="button" onclick="removeNeed(this)" class="btn danger" style="padding: 8px 12px;">حذف</button>
                            </div>
                        @endforeach
                    @else
                        <div class="need-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <input type="text" name="urgent_needs[]" placeholder="مثال: طعام ومياه نظيفة" style="flex: 1;">
                            <button type="button" onclick="removeNeed(this)" class="btn danger" style="padding: 8px 12px;">حذف</button>
                        </div>
                    @endif
                </div>
                
                <button type="button" onclick="addNeed()" class="btn secondary" style="margin-top: 10px;">إضافة حاجة جديدة</button>
                @error('urgent_needs')
                    <div style="color: #ef4444; font-size: 0.9rem; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 30px; text-align: center;">
                <button type="submit" class="btn" style="padding: 12px 32px; font-size: 1.1rem;">
                    {{ $campaign->id ? 'تحديث الحملة' : 'إنشاء الحملة' }}
                </button>
                <a href="{{ route('admin.main-campaign.index') }}" class="btn secondary" style="margin-right: 15px;">إلغاء</a>
            </div>
        </form>
    </div>

    <script>
        function addNeed() {
            const container = document.getElementById('urgent-needs-container');
            const needItem = document.createElement('div');
            needItem.className = 'need-item';
            needItem.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px;';
            
            needItem.innerHTML = `
                <input type="text" name="urgent_needs[]" placeholder="مثال: طعام ومياه نظيفة" style="flex: 1;">
                <button type="button" onclick="removeNeed(this)" class="btn danger" style="padding: 8px 12px;">حذف</button>
            `;
            
            container.appendChild(needItem);
        }

        function removeNeed(button) {
            const needItem = button.parentElement;
            needItem.remove();
        }
    </script>
@endsection
