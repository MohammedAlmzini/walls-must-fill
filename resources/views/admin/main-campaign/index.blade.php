@extends('admin.layouts.admin')

@section('content')
    <div class="page-header">
        <h1>إدارة الحملة الرئيسية</h1>
        <a href="{{ route('admin.main-campaign.edit') }}" class="btn">تعديل الحملة</a>
    </div>

    @if($campaign)
        <div class="box">
            <h2>تفاصيل الحملة</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                <div>
                    <h3>المعلومات الأساسية</h3>
                    <p><strong>العنوان:</strong> {{ $campaign->title }}</p>
                    <p><strong>العنوان الفرعي:</strong> {{ $campaign->subtitle }}</p>
                    <p><strong>الحالة:</strong> 
                        <span style="color: {{ $campaign->is_active ? '#10b981' : '#ef4444' }};">
                            {{ $campaign->is_active ? 'نشطة' : 'غير نشطة' }}
                        </span>
                    </p>
                    <p><strong>تاريخ البداية:</strong> {{ $campaign->start_date ? $campaign->start_date->format('Y-m-d') : 'غير محدد' }}</p>
                    <p><strong>تاريخ الانتهاء:</strong> {{ $campaign->end_date ? $campaign->end_date->format('Y-m-d') : 'غير محدد' }}</p>
                    <p><strong>الأيام المتبقية:</strong> {{ $campaign->days_left }} يوم</p>
                </div>

                <div>
                    <h3>المبالغ والإحصائيات</h3>
                    <p><strong>المبلغ المطلوب:</strong> ${{ number_format($campaign->goal_amount, 2) }}</p>
                    <p><strong>المبلغ المجموع:</strong> ${{ number_format($campaign->collected_amount, 2) }}</p>
                    <p><strong>المبلغ المتبقي:</strong> ${{ number_format($campaign->remaining_amount, 2) }}</p>
                    <p><strong>النسبة المئوية:</strong> {{ $campaign->percentage }}%</p>
                    <p><strong>عدد المتبرعين:</strong> {{ number_format($campaign->supporters_count) }}</p>
                </div>

                <div>
                    <h3>معلومات التواصل</h3>
                    <p><strong>رقم الواتساب:</strong> {{ $campaign->whatsapp_number }}</p>
                    <p><strong>QR Code PayPal:</strong> 
                        @if($campaign->paypal_qr_code)
                            <a href="{{ asset('storage/' . $campaign->paypal_qr_code) }}" target="_blank">عرض الصورة</a>
                        @else
                            غير متوفر
                        @endif
                    </p>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <h3>الوصف</h3>
                <p>{{ $campaign->description }}</p>
            </div>

            <div style="margin-top: 20px;">
                <h3>الاحتياجات العاجلة</h3>
                <ul style="list-style: none; padding: 0;">
                    @foreach($campaign->urgent_needs as $need)
                        <li style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
                            <span style="color: #10b981;">✓</span> {{ $need }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div style="margin-top: 20px;">
                <h3>شريط التقدم</h3>
                <div style="background: #e2e8f0; height: 20px; border-radius: 10px; overflow: hidden; margin: 10px 0;">
                    <div style="background: linear-gradient(90deg, #10b981, #059669); height: 100%; width: {{ $campaign->percentage }}%; transition: width 0.5s ease;"></div>
                </div>
                <p style="text-align: center; margin: 10px 0; font-weight: 600; color: #10b981;">
                    {{ $campaign->percentage }}% من الهدف المطلوب
                </p>
            </div>
        </div>
    @else
        <div class="box">
            <p>لا توجد حملة رئيسية محددة. <a href="{{ route('admin.main-campaign.edit') }}">إنشاء حملة جديدة</a></p>
        </div>
    @endif

    <div class="box">
        <h2>إحصائيات سريعة</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <div style="font-size: 2rem; font-weight: 700; color: #10b981;">{{ $campaign ? number_format($campaign->percentage, 1) : 0 }}%</div>
                <div style="color: #64748b;">نسبة الإنجاز</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <div style="font-size: 2rem; font-weight: 700; color: #3b82f6;">{{ $campaign ? number_format($campaign->supporters_count) : 0 }}</div>
                <div style="color: #64748b;">عدد المتبرعين</div>
            </div>
            <div style="text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                <div style="font-size: 2rem; font-weight: 700; color: #f59e0b;">{{ $campaign ? $campaign->days_left : 0 }}</div>
                <div style="color: #64748b;">أيام متبقية</div>
            </div>
        </div>
    </div>
@endsection
