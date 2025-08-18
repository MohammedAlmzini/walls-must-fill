@extends('layouts.app')

@section('title', $case->title . ' -- نداء عاجل')

@section('content')
<section class="card" style="margin-top:0">
    <div class="p">
        <h1 style="margin:0 0 8px;font-weight:900">{{ $case->title }}</h1>

        @if($case->cover_image_path)
            <div style="margin:16px 0;border-radius:16px;overflow:hidden;box-shadow:var(--shadow)">
                <img src="{{ asset('storage/'.$case->cover_image_path) }}" alt="{{ $case->title }}" style="width:100%;height:auto;max-height:520px;object-fit:cover">
            </div>
        @endif

        @if($case->youtube_embed_url)
            <div style="margin:12px 0;">
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:16px;background:#000">
                    <iframe src="{{ $case->youtube_embed_url }}" title="YouTube video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"></iframe>
                </div>
            </div>
        @endif

        <div class="muted" style="margin:8px 0 16px;font-size:16px">
            {{ __('app.amount_of.collected') }}: ${{ number_format($case->collected_amount,2) }}
            {{ __('app.amount_of.from') }}
            {{ $case->goal_amount ? '$'.number_format($case->goal_amount,2) : __('app.amount_of.no_goal_set') }}
            • {{ $case->is_completed ? __('app.messages.case_completed') : 'قيد الجمع' }}
        </div>

        <div style="margin-bottom:16px">{!! nl2br(e($case->description)) !!}</div>

        @if($case->qr_image_path || $case->whatsapp_link)
            <div style="background:#fff;border:1px solid var(--border);border-radius:18px;padding:24px;margin:22px 0;box-shadow:var(--shadow)">
                <div style="text-align:center;margin-bottom:14px">
                    <h3 style="margin:0 0 6px;background:linear-gradient(135deg,var(--brand-red),var(--brand-green));-webkit-background-clip:text;-webkit-text-fill-color:transparent">🎯 {{ __('app.support.title') }}</h3>
                    <p class="muted" style="margin:0">{{ __('app.support.subtitle') }}</p>
                </div>

                <div class="grid grid-2">
                    @if($case->qr_image_path)
                        <div class="card" style="border:none;box-shadow:none">
                            <div class="p" style="display:flex;gap:16px;align-items:center;flex-wrap:wrap">
                                <div style="position:relative;cursor:pointer" onclick="openQRModal('{{ asset('storage/'.$case->qr_image_path) }}', '{{ $case->title }}')">
                                    <img src="{{ asset('storage/'.$case->qr_image_path) }}" alt="QR" style="width:130px;height:130px;border-radius:18px;box-shadow:0 10px 24px rgba(0,0,0,.15);object-fit:cover">
                                </div>
                                <div style="flex:1">
                                    <h4 style="margin:0 0 6px">💳 {{ __('app.support.qr.title') }}</h4>
                                    <p class="muted" style="margin:0 0 10px">{{ __('app.support.qr.description') }}</p>
                                    <div style="display:flex;gap:8px;flex-wrap:wrap">
                                        <span class="badge">⚡ {{ __('app.support.qr.features.fast') }}</span>
                                        <span class="badge">🔒 {{ __('app.support.qr.features.secure') }}</span>
                                        <span class="badge">💯 {{ __('app.support.qr.features.trusted') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($case->whatsapp_link)
                        <div class="card" style="border:none;box-shadow:none">
                            <div class="p" style="display:flex;gap:16px;align-items:center;flex-wrap:wrap">
                                <div style="font-size:42px;background:linear-gradient(135deg,#25d366,#128c7e);-webkit-background-clip:text;-webkit-text-fill-color:transparent">📱</div>
                                <div style="flex:1">
                                    <h4 style="margin:0 0 6px">💬 {{ __('app.support.whatsapp.title') }}</h4>
                                    <p class="muted" style="margin:0 0 10px">{{ __('app.support.whatsapp.description') }}</p>
                                    <a class="btn btn-green" href="{{ $case->whatsapp_link }}" target="_blank" rel="noopener">
                                        <span>{{ __('app.support.whatsapp.contact_now') }}</span>
                                        <span style="margin-inline-start:6px">→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($case->images && $case->images->count())
            <div style="margin-top:12px">
                <h3 style="margin:0 0 8px">معرض الصور</h3>
                <div class="grid grid-3">
                    @foreach($case->images as $img)
                        <article class="card">
                            <img src="{{ asset('storage/'.$img->image_path) }}" alt="صورة الحالة" style="width:100%;height:200px;object-fit:cover">
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- QR Modal -->
<div id="qrModal" style="display:none;position:fixed;z-index:1000;inset:0;background:rgba(0,0,0,.8);backdrop-filter:blur(4px);align-items:center;justify-content:center">
    <div style="background:#fff;border-radius:18px;max-width:90vw;max-height:90vh;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.3);position:relative">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid #eee;background:#fafafa">
            <h3 id="qrModalTitle" style="margin:0">{{ __('app.support.modal.scan_qr') }}</h3>
            <button onclick="closeQRModal()" style="border:0;background:transparent;font-size:26px;cursor:pointer;color:#666">×</button>
        </div>
        <div style="padding:20px;text-align:center">
            <img id="qrModalImage" src="" alt="QR Code" style="max-width:100%;max-height:60vh;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.2)">
            <p class="muted" style="margin:10px 0 0">{{ __('app.support.modal.click_to_close') }}</p>
        </div>
    </div>
</div>

<script>
function openQRModal(src, title){
    document.getElementById('qrModalImage').src = src;
    document.getElementById('qrModalTitle').textContent = title;
    document.getElementById('qrModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeQRModal(){
    document.getElementById('qrModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}
document.getElementById('qrModal').addEventListener('click', function(e){ if(e.target===this) closeQRModal(); });
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeQRModal(); });
</script>
@endsection