<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل دخول الأدمن - Walls Must</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, "Tajawal", Arial, sans-serif; background:#0e2a28; color:#fff; margin:0; display:grid; min-height:100vh; place-items:center; }
        .card { background:#fff; color:#123; border-radius:12px; padding:20px; width:min(420px, 92vw); }
        .btn { display:inline-block; padding:10px 12px; background:#0a7; color:#fff; border-radius:8px; border:0; cursor:pointer; width:100%; }
        input[type="email"], input[type="password"] { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; margin:6px 0; }
        .alert { padding:10px; border-radius:8px; margin:10px 0; }
        .alert.error { background:#ffeaea; color:#a01818; border:1px solid #ffc9c9; }
    </style>
</head>
<body>
<div class="card">
    <h1 style="margin-top:0;">دخول الأدمن</h1>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <form method="post" action="{{ route('admin.login.submit') }}">
        @csrf
        <label>البريد الإلكتروني</label>
        <input type="email" name="email" value="{{ old('email', 'admin@wallsmust.org') }}" required>

        <label>كلمة المرور</label>
        <input type="password" name="password" required>

        <button class="btn" type="submit">دخول</button>
    </form>
</div>
</body>
</html>