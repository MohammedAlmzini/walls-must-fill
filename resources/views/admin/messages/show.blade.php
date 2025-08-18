@extends('layouts.app')

@section('title', 'عرض رسالة -- لوحة التحكم')

@section('content')
<section class="card" data-reveal>
    <div class="p" style="display:grid;gap:10px">
        <h1 style="margin:0">الموضوع: {{ $message->subject }}</h1>
        <div class="muted">من: {{ $message->name }} — <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></div>
        <div class="muted">بتاريخ: {{ $message->created_at->format('Y-m-d H:i') }}</div>

        <hr style="border:none;border-top:1px solid #eee">

        <div style="white-space:pre-line">{{ $message->message }}</div>

        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px">
            <form method="POST" action="{{ route('admin.messages.toggle', $message) }}">
                @csrf
                <button class="btn secondary" type="submit">
                    {{ $message->is_read ? 'تعليم كغير مقروءة' : 'تعليم كمقروءة' }}
                </button>
            </form>

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('حذف الرسالة؟')">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">حذف</button>
            </form>

            <a class="btn ghost" href="{{ route('admin.messages.index') }}">رجوع</a>
        </div>
    </div>
</section>
@endsection