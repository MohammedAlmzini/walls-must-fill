@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <h2>تعديل تدوينة</h2>
    <form action="{{ route('admin.posts.update', $post) }}" method="post" enctype="multipart/form-data">
        @csrf @method('PUT')
        <label>العنوان</label>
        <input type="text" name="title" required value="{{ old('title', $post->title) }}">

        <label>وصف مختصر</label>
        <input type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}" maxlength="500">

        <label>النص (HTML)</label>
        <textarea name="body" rows="10">{{ old('body', $post->body) }}</textarea>

        <label>صورة مميزة</label>
        @if($post->image_path)
            <div><img src="{{ asset('storage/'.$post->image_path) }}" alt="" style="width:160px;height:110px;object-fit:cover;border-radius:8px;"></div>
        @endif
        <input type="file" name="image" accept="image/*">

        <label>رابط يوتيوب</label>
        <input type="url" name="youtube_url" value="{{ old('youtube_url', $post->youtube_url) }}">

        <label>Meta Description</label>
        <input type="text" name="meta_description" value="{{ old('meta_description', $post->meta_description) }}" maxlength="160">

        <label><input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}> منشور</label>

        <div class="actions" style="margin-top:10px;">
            <button class="btn" type="submit">تحديث</button>
            <a class="btn secondary" href="{{ route('admin.posts.index') }}">رجوع</a>
        </div>
    </form>
</div>
@endsection