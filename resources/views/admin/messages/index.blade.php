@extends('admin.layouts.admin')

@section('content')
<div class="box">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h2 style="margin:0;">رسائل التواصل</h2>
    </div>

    <form method="GET" action="{{ route('admin.messages.index') }}" style="margin:10px 0;">
        <input type="text" name="q" value="{{ $q }}" placeholder="ابحث بالاسم/البريد/الموضوع" style="width:300px;padding:8px;border:1px solid #ddd;border-radius:4px;">
        <button class="btn" type="submit" style="margin-left:8px;">بحث</button>
    </form>

    <table style="margin-top:10px;">
        <thead>
            <tr>
                <th>المرسل</th>
                <th>البريد الإلكتروني</th>
                <th>الموضوع</th>
                <th>الرسالة</th>
                <th>الحالة</th>
                <th>التاريخ</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td><strong>{{ $message->name }}</strong></td>
                    <td><a href="mailto:{{ $message->email }}" style="color:#007bff;text-decoration:none;">{{ $message->email }}</a></td>
                    <td>{{ $message->subject }}</td>
                    <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($message->message, 80) }}</td>
                    <td>
                        <span style="padding:4px 8px;border-radius:12px;font-size:12px;background:{{ $message->is_read ? '#e9ecef' : '#d4edda' }};color:{{ $message->is_read ? '#495057' : '#155724' }};">
                            {{ $message->is_read ? 'مقروءة' : 'غير مقروءة' }}
                        </span>
                    </td>
                    <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                    <td class="actions">
                        <a class="btn" href="{{ route('admin.messages.show', $message) }}">عرض</a>
                        <a class="btn" href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($message->email) }}&su={{ urlencode('رد على: ' . $message->subject) }}&body={{ urlencode('مرحباً ' . $message->name . '،

شكراً لك على رسالتك. 

مع تحياتي،
فريق Walls Must') }}" target="_blank">رد</a>
                        <form action="{{ route('admin.messages.toggle', $message) }}" method="post" style="display:inline;">
                            @csrf
                            <button class="btn" type="submit" style="background:{{ $message->is_read ? '#ffc107' : '#28a745' }};color:{{ $message->is_read ? '#212529' : 'white' }};">
                                {{ $message->is_read ? 'تحديد كغير مقروءة' : 'تحديد كمقروءة' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="post" onsubmit="return confirm('حذف الرسالة؟');" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">لا توجد رسائل.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px;">{{ $messages->links() }}</div>
</div>
@endsection