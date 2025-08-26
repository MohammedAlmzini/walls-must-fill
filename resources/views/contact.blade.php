@extends('layouts.seo')

@section('title', __('app.nav.contact') . ' - ' . __('app.site_name'))

@section('content')
<style>
    /* ====== تصميم أساسي للصفحة ====== */
    .contact-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Arial', sans-serif;
    }

    .contact-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .contact-header h1 {
        font-size: 2.2rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: #222;
    }

    .contact-header p {
        color: #666;
        font-size: 1rem;
    }

    /* ====== الشبكة ====== */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    @media (max-width: 768px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ====== نموذج التواصل ====== */
    .contact-form {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        padding: 24px;
    }

    .contact-form h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        transition: border 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
    }

    .error-text {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .btn-submit {
        background: #28a745;
        color: #fff;
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-submit:hover {
        background: #218838;
    }

    /* ====== معلومات التواصل ====== */
    .contact-info {
        background: #fff;
        border: 1px dashed #ccc;
        border-radius: 12px;
        padding: 24px;
    }

    .contact-info h2 {
        font-size: 1.5rem;
        margin-bottom: 16px;
        color: #333;
    }

    .contact-info div {
        margin-bottom: 16px;
    }

    .contact-info strong {
        color: #444;
    }

    .contact-info a {
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
    }

    .contact-info a:hover {
        text-decoration: underline;
    }

    .contact-info p {
        color: #666;
        line-height: 1.6;
    }
</style>

<div class="contact-container">
    <!-- العنوان -->
    <div class="contact-header">
        <h1>{{ __('app.nav.contact') }}</h1>
        <p>{{ __('app.footer.description') }}</p>
    </div>

    <div class="contact-grid">
        <!-- نموذج التواصل -->
        <div class="contact-form">
            <h2>{{ __('app.forms.message') }}</h2>
            <form action="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('contact.submit') }}" method="POST">
                @csrf
                <!-- الاسم -->
                <div class="form-group">
                    <label for="name">{{ __('app.forms.name') }} *</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
                    @error('name')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <!-- البريد -->
                <div class="form-group">
                    <label for="email">{{ __('app.forms.email') }} *</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" class="@error('email') is-invalid @enderror">
                    @error('email')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <!-- الموضوع -->
                <div class="form-group">
                    <label for="subject">{{ __('app.forms.subject') }} *</label>
                    <input id="subject" name="subject" type="text" required value="{{ old('subject') }}" class="@error('subject') is-invalid @enderror">
                    @error('subject')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <!-- الرسالة -->
                <div class="form-group">
                    <label for="message">{{ __('app.forms.message') }} *</label>
                    <textarea id="message" name="message" rows="6" required class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <!-- زر الإرسال -->
                <button class="btn-submit" type="submit">{{ __('app.buttons.send') }}</button>
            </form>
        </div>

        <!-- معلومات التواصل -->
        <div class="contact-info">
            <h2>{{ __('app.footer.contact') }}</h2>
            <div>
                <strong>{{ __('app.footer.email') }}:</strong><br>
                <a href="mailto:info@walls-must.com">info@walls-must.com</a>
            </div>
            <div>
                <strong>{{ __('app.footer.whatsapp') }}:</strong><br>
                <a href="https://wa.me/1234567890" target="_blank" rel="noopener">+1234567890</a>
            </div>
            <div>
                <h3>{{ __('app.footer.description') }}</h3>
                <p>{{ __('app.footer.belief') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
