@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h2 style="margin:0;">التدوينات</h2>
        <a class="btn" href="{{ route('admin.posts.create') }}">+ تدوينة جديدة</a>
    </div>

    <table style="margin-top:10px;">
        <thead><tr><th>العنوان</th><th>منشورة؟</th><th>تاريخ</th><th>إجراءات</th></tr></thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td><a href="{{ route('posts.show', $post->slug) }}" target="_blank">{{ $post->title }}</a></td>
                    <td>{{ $post->is_published ? 'نعم' : 'لا' }}</td>
                    <td>{{ $post->published_at }}</td>
                    <td class="actions">
                        <a class="btn" href="{{ route('admin.posts.edit', $post) }}">تعديل</a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="post" onsubmit="return confirm('حذف التدوينة؟');">
                            @csrf @method('DELETE')
                            <button class="btn danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">لا توجد تدوينات.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px;">{{ $posts->links() }}</div>
</div>
@endsection