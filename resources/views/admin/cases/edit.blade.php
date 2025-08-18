@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <h2>تعديل حالة</h2>
    <form action="{{ route('admin.cases.update', $case) }}" method="post" enctype="multipart/form-data">
        @csrf @method('PUT')
        <label>عنوان الحالة</label>
        <input type="text" name="title" required value="{{ old('title', $case->title) }}">

        <label>وصف الحالة</label>
        <textarea name="description" rows="8" required>{{ old('description', $case->description) }}</textarea>

        <label>صورة الغلاف</label>
        @if($case->cover_image_path)
            <div><img src="{{ asset('storage/'.$case->cover_image_path) }}" alt="" style="width:160px;height:110px;object-fit:cover;border-radius:8px;"></div>
        @endif
        <input type="file" name="cover_image" accept="image/*">

        <label>QR للتبرع</label>
        @if($case->qr_image_path)
            <div><img src="{{ asset('storage/'.$case->qr_image_path) }}" alt="" style="width:160px;height:160px;object-fit:contain;border-radius:8px;border:1px solid #eee;padding:6px;background:#fff;"></div>
        @endif
        <input type="file" name="qr_image" accept="image/*">

        <label>رابط فيديو</label>
        <input type="url" name="video_url" value="{{ old('video_url', $case->video_url) }}">

        <label>رقم واتساب</label>
        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $case->whatsapp_number) }}">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div>
                <label>الهدف</label>
                <input type="number" step="0.01" name="goal_amount" value="{{ old('goal_amount', $case->goal_amount) }}">
            </div>
            <div>
                <label>المجموع المُجمّع</label>
                <input type="number" step="0.01" name="collected_amount" value="{{ old('collected_amount', $case->collected_amount) }}">
            </div>
        </div>

        <label><input type="checkbox" name="is_completed" value="1" {{ $case->is_completed ? 'checked' : '' }}> تم إنجاز الحالة</label>

        <label>إضافة صور جديدة (متعددة)</label>
        <input type="file" name="images[]" accept="image/*" multiple>

        <h3>معرض الصور</h3>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            @foreach($case->images as $img)
                <div style="position:relative;">
                    <img src="{{ asset('storage/'.$img->image_path) }}" style="width:140px;height:100px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                </div>
            @endforeach
        </div>

        <div class="actions" style="margin-top:10px;">
            <button class="btn" type="submit">تحديث</button>
            <a class="btn secondary" href="{{ route('admin.cases.index') }}">رجوع</a>
        </div>
    </form>
</div>
@endsection