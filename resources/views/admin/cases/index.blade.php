@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h2 style="margin:0;">الحالات</h2>
        <a class="btn" href="{{ route('admin.cases.create') }}">+ حالة جديدة</a>
    </div>

    <table style="margin-top:10px;">
        <thead>
            <tr><th>العنوان</th><th>المجموع</th><th>الهدف</th><th>منجزة؟</th><th>إجراءات</th></tr>
        </thead>
        <tbody>
            @forelse($cases as $case)
                <tr>
                    <td><a href="{{ route('cases.show', $case->slug) }}" target="_blank">{{ $case->title }}</a></td>
                    <td>${{ number_format($case->collected_amount,2) }}</td>
                    <td>{{ $case->goal_amount ? '$'.number_format($case->goal_amount,2) : '-' }}</td>
                    <td>{{ $case->is_completed ? 'نعم' : 'لا' }}</td>
                    <td class="actions">
                        <a class="btn" href="{{ route('admin.cases.edit', $case) }}">تعديل</a>
                        <form action="{{ route('admin.cases.destroy', $case) }}" method="post" onsubmit="return confirm('حذف الحالة وجميع صورها؟');">
                            @csrf @method('DELETE')
                            <button class="btn danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">لا توجد حالات.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px;">{{ $cases->links() }}</div>
</div>
@endsection