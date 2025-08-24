@extends('layouts.seo')

@section('title', __('app.nav.contact') . ' - ' . __('app.site_name'))

@section('content')
<div class="card" style="margin-top:0">
    <div class="p">
        <div style="text-align:center;margin-bottom:24px">
            <h1 style="margin:0 0 6px">{{ __('app.nav.contact') }}</h1>
            <p class="muted" style="margin:0">{{ __('app.footer.description') }}</p>
        </div>

        <div class="grid grid-2" style="gap:24px">
            <div>
                <h2 style="margin:0 0 12px">{{ __('app.forms.message') }}</h2>
                <form action="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('contact.submit') }}" method="POST">
                    @csrf
                    <div style="margin-bottom:12px">
                        <label for="name" style="display:block;margin-bottom:6px;font-weight:700">{{ __('app.forms.name') }} *</label>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}" class="@error('name') is-invalid @enderror" style="width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:12px">
                        @error('name')<div style="color:#dc3545;font-size:14px;margin-top:4px">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="email" style="display:block;margin-bottom:6px;font-weight:700">{{ __('app.forms.email') }} *</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" class="@error('email') is-invalid @enderror" style="width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:12px">
                        @error('email')<div style="color:#dc3545;font-size:14px;margin-top:4px">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="subject" style="display:block;margin-bottom:6px;font-weight:700">{{ __('app.forms.subject') }} *</label>
                        <input id="subject" name="subject" type="text" required value="{{ old('subject') }}" class="@error('subject') is-invalid @enderror" style="width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:12px">
                        @error('subject')<div style="color:#dc3545;font-size:14px;margin-top:4px">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom:12px">
                        <label for="message" style="display:block;margin-bottom:6px;font-weight:700">{{ __('app.forms.message') }} *</label>
                        <textarea id="message" name="message" rows="6" required class="@error('message') is-invalid @enderror" style="width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:12px">{{ old('message') }}</textarea>
                        @error('message')<div style="color:#dc3545;font-size:14px;margin-top:4px">{{ $message }}</div>@enderror
                    </div>

                    <button class="btn btn-green" type="submit">{{ __('app.buttons.send') }}</button>
                </form>
            </div>

            <div class="card" style="border:1px dashed var(--border)">
                <div class="p">
                    <h2 style="margin:0 0 12px">{{ __('app.footer.contact') }}</h2>
                    <div style="margin-bottom:14px">
                        <strong>{{ __('app.footer.email') }}:</strong><br>
                        <a href="mailto:info@walls-must.com">info@walls-must.com</a>
                    </div>
                    <div style="margin-bottom:14px">
                        <strong>{{ __('app.footer.whatsapp') }}:</strong><br>
                        <a href="https://wa.me/1234567890" target="_blank" rel="noopener">+1234567890</a>
                    </div>
                    <div>
                        <h3 style="margin:0 0 8px">{{ __('app.footer.description') }}</h3>
                        <p class="muted" style="margin:0">{{ __('app.footer.belief') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection