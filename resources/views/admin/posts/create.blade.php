@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <h2>تدوينة جديدة</h2>
    <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label>العنوان</label>
        <input type="text" name="title" required value="{{ old('title') }}">

        <label>وصف مختصر (Excerpt)</label>
        <input type="text" name="excerpt" value="{{ old('excerpt') }}" maxlength="500">

        <label>النص (يدعم HTML)</label>
        <textarea name="body" rows="10">{{ old('body') }}</textarea>

        <label>صورة مميزة</label>
        <input type="file" name="image" accept="image/*">

        <label>رابط فيديو يوتيوب (اختياري)</label>
        <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/embed/...">

        <label>Meta Description</label>
        <input type="text" name="meta_description" value="{{ old('meta_description') }}" maxlength="160">

        <label><input type="checkbox" name="is_published" value="1" checked> نشر التدوينة</label>

        <div class="actions" style="margin-top:10px;">
            <button class="btn" type="submit">حفظ</button>
            <a class="btn secondary" href="{{ route('admin.posts.index') }}">رجوع</a>
        </div>
    </form>
</div>
@endsection