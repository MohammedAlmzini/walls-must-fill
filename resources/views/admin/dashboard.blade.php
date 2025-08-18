@extends('admin.layouts.admin')

@section('content')
<div class="grid">
    <div class="box"><div class="muted">التدوينات</div><div style="font-size:1.8rem;font-weight:700;">{{ $stats['posts'] }}</div></div>
    <div class="box"><div class="muted">الحالات</div><div style="font-size:1.8rem;font-weight:700;">{{ $stats['cases'] }}</div></div>
    <div class="box"><div class="muted">حالات منجزة</div><div style="font-size:1.8rem;font-weight:700;">{{ $stats['completed_cases'] }}</div></div>
    <div class="box"><div class="muted">إجمالي التبرعات</div><div style="font-size:1.8rem;font-weight:700;">$ {{ number_format($stats['donations_sum'],2) }}</div></div>
</div>

<div class="box" style="margin-top:14px;">
    <div class="actions">
        <a class="btn" href="{{ route('admin.posts.create') }}">+ تدوينة جديدة</a>
        <a class="btn secondary" href="{{ route('admin.cases.create') }}">+ حالة جديدة</a>
    </div>
</div>
@endsection