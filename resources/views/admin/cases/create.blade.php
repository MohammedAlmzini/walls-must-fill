@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <h2>إضافة حالة</h2>
    <form action="{{ route('admin.cases.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label>عنوان الحالة</label>
        <input type="text" name="title" required value="{{ old('title') }}">

        <label>وصف الحالة</label>
        <textarea name="description" rows="8" required>{{ old('description') }}</textarea>

        <label>صورة الغلاف</label>
        <input type="file" name="cover_image" accept="image/*">

        <label>QR للتبرع (Binance TRON20)</label>
        <input type="file" name="qr_image" accept="image/*">

        <label>رابط فيديو (اختياري)</label>
        <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/...">

        <label>رقم واتساب للتواصل</label>
        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="+970...">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div>
                <label>الهدف (اختياري)</label>
                <input type="number" step="0.01" name="goal_amount" value="{{ old('goal_amount') }}">
            </div>
            <div>
                <label>المجموع المُجمّع</label>
                <input type="number" step="0.01" name="collected_amount" value="{{ old('collected_amount', 0) }}">
            </div>
        </div>

        <label><input type="checkbox" name="is_completed" value="1"> تم إنجاز الحالة</label>

        <label>صور إضافية (يمكن اختيار عدة صور)</label>
        <input type="file" name="images[]" accept="image/*" multiple>

        <div class="actions" style="margin-top:10px;">
            <button class="btn" type="submit">حفظ</button>
            <a class="btn secondary" href="{{ route('admin.cases.index') }}">رجوع</a>
        </div>
    </form>
</div>
@endsection